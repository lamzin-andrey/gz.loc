<?php 

require_once DR . "/lib/shared.php";

class SmsVerify {
	public $isNeedCookue = true;
	public $phone;
	
	public $sNeedCookieMessage = 'Извините, мы не можем определить номер телефона, который вы указали при подаче объявления. Возможно, в браузере отключенны куки. Включите куки и повторите попытку.';
	
	public function __construct() {
		if (!isset($_SESSION['verified_adv_id']) || !isset($_SESSION['verified_adv_phone'])) {
			$this->isNeedCookue = true;
			return;
		}
		$phone = $_SESSION['verified_adv_phone'];
		$this->phone = Shared::formatPhone($_SESSION['verified_adv_phone']);
		
		$aUrl = explode('/', $_SERVER['REQUEST_URI']);
		if ($aUrl[1] == 'smsverify') {
			if (!isset($aUrl[2])) {
				//просто показываем кнопку получить смс
			} elseif($aUrl[2] == 'getsms') {
				//если интервал после последнего запроса прошел,
				//генерим код и кладем в сессию
				//показываем кнопку получить смc
				//показываем надпись Вам отправлено смс с кодом, введите код в это поле
				//показываем надпись Повторная отправка смс возможна через 15 минут (вычисляемое значение)
			} elseif ($aUrl[2] == 'verify') {
				//сравниваем код с сохраненным
				//если подошел, показываем сообщение как на странице подачи объявления сейчас
				// и обновляем по id строку в main сделав объявление не удаленным
				// и обновляем по номеру телефона запись в users.is_verify = 1
				
				// иначе пишем что код не совпал и показываем все как в getsms
			}
		} else {
			utils_404();
		}
	}
}

$smsVerify = new SmsVerify();


