<?php
class CUpAction {
	public $id;
	public $title;
	public $upCount = 10000;
	public function __construct() {
		//получить id  ипроверить, есть ли право поднимать это объявлени
		//если есть поднять если нет вывести сообщение об ошибке
		$this->id = $id = @$_GET["edit_id"];
		$phone = @$_SESSION["phone"];
		
		sess('up_adv_flag', true);
		sess('add_adv_flag', 'unset');

		
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
					if ($upCount - 1 < 0) {
						$status = 2;
						sess('ok_msg', 'В этом месяце вы не можете поднимать объявления.');
					} else {
						$status = self::up($id);
						query("UPDATE users SET `upcount` = `upcount` - 1 WHERE id = {$uid}");
					}
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
		$n = intval(date('m'));
		$a = [0, 'январе', 'феврале', 'марте', 'апреле', 'мае', 'июне', 'июле', 'августе', 'сентябре', 'октябре', 'ноябре', 'декабре'];
		return $a[$n];
	}
}
