<?php
/**
 * Этот класс принимает запросы только с юзерскрипта
*/
class YaGate {
	public $js = '';
	public function __construct() {
		$method = isset($_POST['act']) ? $_POST['act'] : '';
		switch ($method) {
			case 'getFirstTransaction':
				//Скрипт запрашивает у нас дату последнего подтвержденного платежа.
				//	(если такого нет, возвращается дата первой транзакции или дата из конфига)
				$date = dbvalue('SELECT created FROM pay_transaction WHERE is_confirmed = 1 ORDER BY id DESC LIMIT 1');
				if (!$date) {
					$date = '2017-10-04 23:28:00';
				}
				echo $date;
				exit;
				break;
		}
		exit;
	}
}
$classHandler = $p = new YaGate();

/*$javascript = isset($javascript) ? $javascript : '';
$javascript .= $p->js;*/
