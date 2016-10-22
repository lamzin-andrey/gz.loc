<?php 

require_once DR . "/lib/shared.php";

class SmsVerify {
	public $isNeedCookue = true;
	public $phone;
	public $timeoutMinutes; //сколько минут осталось до следующего запроса sms
	public $innerTpl;
	public $resultSuccess = false;
	
	public  $sNeedCookieMessage = 'Извините, мы не можем определить номер телефона, который вы указали при подаче объявления. Возможно, в браузере отключенны куки. Включите куки и повторите попытку.';
	public  $successMessage = 'Ваше объявление добавлено и будет размещено на сайте после проверки';
	const   INVALID_CODE_MESSAGE = 'Код не совпал';
	const   LAST_SMS_REQUEST_TIME  = 'LAST_SMS_REQUEST_TIME';
	public  $invalidCodeMessage = '';
	
	public function __construct() {
		$this->innerTpl = TPLS . '/sms/getSmsButton.tpl.php';
		if (!isset($_SESSION['verified_adv_id']) || !isset($_SESSION['verified_adv_phone'])) {
			$this->isNeedCookue = true;
			utils_302('/');
			return;
		}
		$phone = $_SESSION['verified_adv_phone'];
		$this->phone = Shared::formatPhone($_SESSION['verified_adv_phone']);
		$this->infoMessage = 'Подтвердите, что номер ' . $this->phone . '  действительно ваш. Для этого нажмите на кнопку &laquo;Получить смс&raquo;';
		
		$aUrl = explode('/', $_SERVER['REQUEST_URI']);
		$this->invalidCodeMessage = '';
		if ($aUrl[1] == 'smsverify') {
			if (!isset($aUrl[2])) {
				//просто показываем кнопку получить смс
				$this->innerTpl = TPLS . '/sms/getSmsButton.tpl.php';
			} elseif($aUrl[2] == 'getsms') {
				//если интервал после последнего запроса прошел,
				if ($this->_timeout()) {
					if (count($_POST)) {
						//генерим код и кладем в сессию
						$code = $this->_generateCode();
						sess('smscode', $code);
						sess(self::LAST_SMS_REQUEST_TIME, time());
						//кладем или обновляем во временной таблице запись phone | code
						$this->_setCodeInDb( sess('verified_adv_phone'), $code );
						$this->_timeout();
						$this->infoMessage = 'Не пришло sms? Через ' . $this->timeoutMinutes . ' нажмите на кнопку &laquo;Получить смс&raquo;, чтобы отправить sms на номер ' . $this->phone . '  для подтверждения, что он действительно ваш. ';
					}
				} else {
					$this->infoMessage = 'Не пришло sms? Через ' . $this->timeoutMinutes . ' нажмите на кнопку &laquo;Получить смс&raquo;, чтобы отправить sms на номер ' . $this->phone . '  для подтверждения, что он действительно ваш. ';
				}
				//показываем кнопку получить смc
				//показываем надпись Вам отправлено смс с кодом, введите код в это поле
				//показываем надпись Повторная отправка смс возможна через 15 минут (вычисляемое значение)
				//$this->timeoutMinutes = Устанавливается в _timeout
				$this->innerTpl = TPLS . '/sms/sendCode.tpl.php';
			} elseif ($aUrl[2] == 'verify') {
				//сравниваем код с сохраненным
				//если подошел, 
				$reqCode = ireq('smsCode');
				if (sess('smscode') == $reqCode) {
					// и обновляем по id строку в main сделав объявление не удаленным
					$id = sess('verified_adv_id');
					query("UPDATE main SET is_deleted = 0 WHERE id = {$id}");
					// и обновляем по номеру телефона запись в users.is_verify = 1
					$phone = sess('verified_adv_phone');
					query("UPDATE users SET is_sms_verify = 1 WHERE phone = {$phone}");
					$this->resultSuccess = true;
					//показываем сообщение как на странице подачи объявления сейчас
					$this->innerTpl = TPLS . '/sms/sendCode.tpl.php';
				} else {
					// иначе пишем что код не совпал и показываем все как в getsms
					if ($reqCode){
						$this->invalidCodeMessage = self::INVALID_CODE_MESSAGE;
					}
					$this->_timeout(); //установить кол-во минут для надписи, сколько еще нужно ждать.
					$this->innerTpl = TPLS . '/sms/sendCode.tpl.php';
				}
			}
		} else {
			utils_404();
		}
	}
	/**
	 * @description Устанавливает timeoutMinutes в минутах или секундах, если секунд менее 60-ти. Также устанавливает ед. измерения.
	 * @return bool true если с момента последнего запроса прошло более SMS_INTERVAL секунд
	*/
	private function _timeout() {
		$seconds =  time() - sess(self::LAST_SMS_REQUEST_TIME, null, 0);
		$result  = ($seconds > SMS_INTERVAL ? true : false);
		$dS = $seconds = SMS_INTERVAL - $seconds;
		$minutes = floor($seconds / 60);
		$meas = pluralize($minutes, '', 'минуту', 'минуты', 'минут');
		$this->timeoutMinutes = $minutes . ' ' . $meas;
		if ($seconds < 60) {
			$meas = pluralize($seconds, '', 'секунду', 'секунды', 'секунд');
			$this->timeoutMinutes = $seconds . ' ' . $meas;
		}
		//$this->timeoutMinutes .= ', (' . $dS . ' secs)';
		return $result;
	}
	/**
	 * @description Генерирует код для sms
	 * @return string
	*/
	private function _generateCode($sz = 4) {
		return rand(1000, 9999);
	}
	/**
	 * @description Генерирует код для sms
	 * @return string
	*/
	private function _setCodeInDb($phone, $code) {
		$query = "INSERT INTO sms_code (phone, code) VALUES('{$phone}', {$code}) ON DUPLICATE KEY UPDATE code = {$code}";
		query($query);
	}
}

$smsVerify = new SmsVerify();


