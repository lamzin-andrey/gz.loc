<?php 

require_once DR . "/lib/shared.php";

class SmsVerify {
	public $isNeedCookue = true;
	public $phone;
	public $timeoutMinutes; //сколько минут осталось до следующего запроса sms
	public $innerTpl = TPLS . '/sms/getSmsButton.tpl.php';
	public $resultSuccess = false;
	
	public  $sNeedCookieMessage = 'Извините, мы не можем определить номер телефона, который вы указали при подаче объявления. Возможно, в браузере отключенны куки. Включите куки и повторите попытку.';
	public  $successMessage = 'Ваше объявление добавлено и будет размещено на сайте после проверки';
	const   INVALID_CODE_MESSAGE = 'Код не совпал';
	const   LAST_SMS_REQUEST_TIME  = 'LAST_SMS_REQUEST_TIME';
	public  $invalidCodeMessage = '';
	
	public function __construct() {
		if (!isset($_SESSION['verified_adv_id']) || !isset($_SESSION['verified_adv_phone'])) {
			$this->isNeedCookue = true;
			return;
		}
		$phone = $_SESSION['verified_adv_phone'];
		$this->phone = Shared::formatPhone($_SESSION['verified_adv_phone']);
		
		$aUrl = explode('/', $_SERVER['REQUEST_URI']);
		$this->invalidCodeMessage = '';
		if ($aUrl[1] == 'smsverify') {
			if (!isset($aUrl[2])) {
				//просто показываем кнопку получить смс
				$this->innerTpl = TPLS . '/sms/getSmsButton.tpl.php';
			} elseif($aUrl[2] == 'getsms') {
				//если интервал после последнего запроса прошел,
				if ($this->_timeout()) {
					//генерим код и кладем в сессию
					$code = $this->generateCode();//TODO
					sess('smscode', $code);
					sess(self::LAST_SMS_REQUEST_TIME, time());
					//кладем или обновляем во временной таблице запись phone | code
					$this->_setCodeInDb( sess('verified_adv_phone'), $code );//TODO  и таблицу надо, и базу с сервера если на bamd
				}
				//показываем кнопку получить смc
				//показываем надпись Вам отправлено смс с кодом, введите код в это поле
				//показываем надпись Повторная отправка смс возможна через 15 минут (вычисляемое значение)
				//$this->timeoutMinutes = Устанавливается в _timeout
				$this->innerTpl = TPLS . '/sms/sendCode.tpl.php'
			} elseif ($aUrl[2] == 'verify') {
				//сравниваем код с сохраненным
				//если подошел, 
				if (sess('smscode') == req('code')) {
					// и обновляем по id строку в main сделав объявление не удаленным
					$id = sess('verified_adv_id');
					query("UPDATE main SET is_deleted = 0 WHERE id = {$id}");
					// и обновляем по номеру телефона запись в users.is_verify = 1
					$phone = sess('verified_adv_phone');
					query("UPDATE users SET is_verify = 1 WHERE phone = {$phone}");
					$this->resultSuccess = true;
					//показываем сообщение как на странице подачи объявления сейчас
				} else {
					// иначе пишем что код не совпал и показываем все как в getsms
					$this->invalidCodeMessage = self::INVALID_CODE_MESSAGE;
					$this->_timeout(); //установить кол-во минут для надписи, сколько еще нужно ждать.
					$this->innerTpl = TPLS . '/sms/sendCode.tpl.php'
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
		$result  = ($seconds < SMS_INTERVAL ? false : true);
		$minutes = floor($minutes / 60);
		$meas = pluralize($minutes, '', 'минута', 'минуты', 'минут');
		$this->timeoutMinutes = $minutes . ' ' . $meas;
		if ($seconds < 60) {
			$meas = pluralize($seconds, '', 'секунда', 'секунды', 'секунд');
			$this->timeoutMinutes = $seconds . ' ' . $meas;
		}
		return $result;
	}
}

$smsVerify = new SmsVerify();


