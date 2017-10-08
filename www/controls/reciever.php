<?php
require_once DR . '/controls/classes/cpaycheck.php';
class YaReciever {
	public function __construct() {
		file_put_contents(__DIR__ . '/postlog.txt', "\n===========" . date('Y-m-d H:i:s') . "===========\n" . print_r($_POST, 1) . "\n" , FILE_APPEND);
		$operation_id      = req('operation_id');
		$operation_label      = req('operation_label');
		$notification_type = req('notification_type');
		$datetime          = req('datetime');
		$unaccepted        = req('unaccepted');
		$sha1_hash         = req('sha1_hash');
		$sender            = req('sender');
		$codepro           = req('codepro');
		$codepro = $codepro && $codepro != 'false' ? 'true' : 'false';
		$unaccepted = $unaccepted && $unaccepted != 'false' ? 'true' : 'false';
		$currency = req('currency');
		$amount   = req('amount');
		$withdraw_amount = req('withdraw_amount');
		$label    = req('label');
		
		$secret = YAKEY;
		$str = "{$notification_type}&{$operation_id}&{$amount}&{$currency}&{$datetime}&{$sender}&{$codepro}&{$secret}&{$label}";
		$hash = sha1($str);
		
		file_put_contents(__DIR__ . '/postlog.txt', "\nhash = {$hash}\n\n" , FILE_APPEND);
		file_put_contents(__DIR__ . '/postlog.txt', "\nstr = '{$str}'\n\n" , FILE_APPEND);
		
		if ($hash == $sha1_hash) {
			if (intval($label)) {
				$label = intval($label);
				$yaRequestLogId = $this->_insertYandexNotificationData($operation_id, $notification_type, $datetime, $sender, $codepro, $amount, $withdraw_amount, 	$label, $operation_label, $unaccepted);
				$nAff = dbvalue("SELECT is_confirmed FROM pay_transaction WHERE id = {$label}");
				if ($nAff == 0) {
					query("UPDATE pay_transaction SET is_confirmed = 1, ya_http_notice_id = {$yaRequestLogId} WHERE id = {$label}"); 
					$this->_incrementUserAppCount($label, $withdraw_amount, $yaRequestLogId);
				}
			}
			json_ok();
		}
		header("HTTP/1.1 201 Created");
		exit;/**/
	}
	
	/**
	 * Логирование данных HTTP уаведомления от Яндекса в Базе данных
	*/
	private function _insertYandexNotificationData($operation_id, $notification_type, $datetime, $sender, $codepro, $amount, $withdraw_amount, 	$label, $operation_label, $unaccepted) {
		$notificationId = dbvalue('SELECT id FROM ya_notification_type WHERE name= \'' . $notification_type . '\'');
		if (!$notificationId) {
			$notificationId = 0;
		}
		$cmd = 'INSERT INTO ya_http_notice (
			`notification_type_id`,  `amount`, `_datetime`, `codepro`, `unaccepted`, `withdraw_amount`, `sender`, 
			`operation_label`, `operation_id`, `label`)
			VALUES (\'' . $notificationId . '\', \'' . $amount . '\', \'' . $datetime . '\', \'' . $codepro . '\', 
			\'' . $unaccepted . '\', \'' . $withdraw_amount . '\', \'' . $sender . '\',
			\'' . $operation_label . '\', \'' . $operation_id . '\', \'' . $label . '\')
		';
		$insertId = query($cmd);
		return $insertId;
	}
	/**
	 * @description Увелечение возможности поднимать объявления после успешной оплаты
	 * @param integer $payTransactionId идентификатор из pay_transaction
	 * @param float $nSum сумма фактически уплаченная пользователем, информация из нотайса
	*/
	private function _incrementUserAppCount($payTransactionId, $nSum, $yaRequestLogId) {
		$storedSumData = dbrow("SELECT sum, user_id FROM pay_transaction WHERE id = {$payTransactionId}");
		$storedSum = isset($storedSumData['sum']) ? $storedSumData['sum'] : 0;
		if (!$storedSum) {
			file_put_contents('wrong_summ_log.txt', ($yaRequestLogId. "\n"), FILE_APPEND);
			return;
		}
		$upcount = Paycheck::$offers[intval($storedSum)];
		//если сумма, оплаченная пользователем не входит в перечень заданных в платежной форме,
		//	находим среди заданных первый, меньший чем внесенная сумма, и считаем кол-во поднятий по этой стоимости.
		if (intval($storedSum) != intval($nSum)) {
			$a = array_keys(Paycheck::$offers);
			$sz = count($a);
			$sumFound = false;
			$upPrice = 60;
			for ($i = $sz - 1; $i > -1; $i--) {
				if ($a[$i] == $nSum) {
					$sumFound = true;
					break;
				}
				if ($a[$i] <= $nSum)	{
					$upPrice = $a[$i] / Paycheck::$offers[ $a[$i] ];
					$upcount = ceil($nSum / $upPrice);	
					break;
				}
			}
		} else {
			$upcount = Paycheck::$offers[intval($nSum)];
		}
		//записываем в истории операций
		$userId = isset($storedSumData['user_id']) ? $storedSumData['user_id'] : 0;
		$now = now();
		$sql = "INSERT INTO operations
			(`user_id`, `op_code_id`, `upcount`, `main_id`, `created`, `sum`, `pay_transaction_id`) VALUES
			('{$userId}', 2, '{$upcount}', 0, '{$now}', '{$nSum}', '{$payTransactionId}')
		";
		query($sql);
		//Увеличиваем баланс
		$sql = "UPDATE users SET upcount = '{$upcount}' WHERE id = {$userId}";
		query($sql);
	}
}

new YaReciever();
