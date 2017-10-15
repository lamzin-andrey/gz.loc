<?php
require_once LIB_ROOT . '/classes/request/Request.php';
require_once LIB_ROOT . '/classes/mail/SampleMail.php';
class CUpAction {
	public $id;
	public $title;
	public $upCount = 10000;
	public $payProxyEnabled = false;
	/***/
	public $unavialableTpl =  TPLS . '/mothexpiremsg.tpl.php';
	public function __construct() {
		$this->setPayProxyEnabled();
		//получить id  ипроверить, есть ли право поднимать это объявлени
		//если есть поднять если нет вывести сообщение об ошибке
		$this->id = $id = @$_GET["edit_id"];
		
		
		$phone = @$_SESSION["phone"];
		sess('upId', $this->id);
		
		sess('up_adv_flag', true);
		sess('add_adv_flag', 'unset');

		if (defined('PAY_ENABLED')) {
			$this->unavialableTpl =  TPLS . '/payform/form.tpl.php';
		}
		
		if ($id && $phone) {
			$row = dbrow("SELECT id, title FROM main WHERE id = {$id} AND phone = '{$phone}'");
			$id = (int)@$row["id"];
			$upCount = dbvalue("SELECT upcount FROM users WHERE phone = '{$phone}' LIMIT 1");
			$this->upCount = $upCount;
			$this->title = @$row["title"];
			if (!$id) {
				$_SESSION["ok_msg"] = "У вас нет прав на действие с этим объявлением";
				utils_302("/cabinet?status=1"); 
			}
			if (a($_SESSION, "ccode") && a($_POST, "cp") === @$_SESSION["ccode"]) {
				//Если пользователь не верифицирован, надо показать ему сообщение Чтобы поднять объявление, вам надо подтвердить
				//свой номер телефона. Сейчас вы будете перенаправлены на страницу подтверждения.
				//Иначе все как здесь
				$row = dbrow("SELECT `is_sms_verify`, `upcount`, `id` FROM users WHERE phone = '{$phone}'");
				$isVerify = $row['is_sms_verify'];
				$upCount  = $row['upcount'];
				$uid       = $row['id'];
				if ($isVerify == 1) {
					$status = $this->_upAction($uid, $id, $upCount);
					utils_302("/cabinet?status={$status}");
				} else {
					sess('verified_adv_id', $id);
					sess('verified_adv_phone', $phone);
					utils_302("/smsverify");
				}
			}
		}
	}
	/**
	 * @return int статус 0 (удалось поднять объявление) или 2 (не удалось поднять объявление)
	*/
	static public function up($iAdvId) {
		$id = $iAdvId;
		$cmd = "SELECT max(delta) + 2 FROM main";
		$d = dbvalue($cmd);
		query("UPDATE main SET delta = {$d} WHERE id = {$id}", $nR, $aR);
		if ($aR) {
			$_SESSION["ok_msg"] = "Ваше объявление поднято в результатах поиска";
			$date = date('Y-m-d');
			query("INSERT INTO stat_up (_date, _count) VALUES ('{$date}', 1) ON DUPLICATE KEY UPDATE _count = _count + 1");
			//utils_302("/cabinet?status=0"); //Все ок
			return 0;
		} else {
			$_SESSION["ok_msg"] = "Не удалось поднять объявление в результатах поиска. Попробуйте позже";
			//utils_302("/cabinet?status=2"); //Не удалось поднять сообщение
			return 2;
		}
	}
	/**
	 * @return string возвращает имя месяца в предложном падеже
	*/
	public function emonth() {
		return Shared::getEMonth();
	}
	/**
	 * @description в зависимости от включенной или выключенной оплаты либо просто не даёт списывать при недоступном числе поднятий,
	 * 				либо отправляет на форму оплаты
	 * @param  int $uid идентификатор пользователя
	 * @param  int $id идентификатор объявления
	 * @return int статус поднятия объявления
	*/
	private function _upAction($uid, $id, $upCount) {
		if (!defined('PAY_ENABLED')) {
			$status = 2;
			if ($upCount - 1 < 0) {
				sess('ok_msg', 'В этом месяце вы не можете поднимать объявления.');
			} else {
				$status = $this->_upAndDecrement($id, $uid);
			}
			return $status;
		}
		return $this->_upWithPayment($uid, $id, $upCount);
	}
	/**
	 * @description Списание с кол-ва поднятий при включенном балансе пользователя
	 * @param  int $uid идентификатор пользователя
	 * @param  int $id идентификатор объявления
	 * @return int статус поднятия объявления
	*/
	private function _upWithPayment($uid, $id, $upCount) {
		$status = 3;
		if ($upCount - 1 < 0) {
			sess('ok_msg', 'Чтобы поднять объявление, оплатите возможность поднятий.');
		} else {
			$status = $this->_upAndDecrement($id, $uid);
		}
		return $status;
	}
	/**
	 * @description Списание с кол-ва поднятий при включенном балансе пользователя
	 * @param  int $uid идентификатор пользователя
	 * @param  int $id идентификатор объявления
	 * @return int статус поднятия объявления
	*/
	private function _upAndDecrement($id, $uid) {
		$status = self::up($id);
		$code = CODE_DEC_FOR_UP;
		$time = now();
		if ($status == 0) {
			query("UPDATE users SET `upcount` = `upcount` - 1 WHERE id = {$uid}");
			query("INSERT INTO operations (`user_id`, `op_code_id`, `upcount`, `main_id`, `created`) 
					VALUES(
					{$uid},
					{$code},
					-1,
					{$id},
					'{$time}'
			)");
		}
		return $status;
	}
	/**
	 * @description Проверяет, доступен ли сервер, через который выполняется проксирование запросов с yandeх money
	*/
	public function setPayProxyEnabled() {
		$proxyUrlCheck = PROXY_YAM_CHECK_URL;
		$req = new Request();
		$value = md5(time() . uniqid('tival', true) . rand(11111, 99999));
		$response = $req->execute($proxyUrlCheck, [
			'tival'	=> $value
		]);
		if ($response->responseStatus == 200) {
			$check = file_get_contents(LIB_ROOT . '/classes/request/cache/tival');
			if ($check == $value) {
				$this->payProxyEnabled = true;
			} else {
				$this->_sendYaformUnworkEmail();
			}
		} else {
			$this->_sendYaformUnworkEmail();
		}
	}
	/**
	 * @description Отправляем письмо на gazelme@mail.ru если не удалось показать форму оплаты
	*/
	private function _sendYaformUnworkEmail() {
		$mailer = new SampleMail();
		$mailer->setSubject("Не доступна формы оплаты на gazel.me");
		$mailer->setAddressFrom(array("admin@gazel.me"=>"Админ Админыч"));
		$mailer->setAddressTo(array("lamzin.ann@yandex.ru"=>"Нет связи с фас"));
		//sample inline
		$mailer->setPlainText("Форма оплаты не показывается, потому что не удается связаться с сайтом fastxampp.org", []);
		$r = $mailer->send();
	}
}
