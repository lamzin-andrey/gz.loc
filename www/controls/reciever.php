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
					file_put_contents(__DIR__ . '/postlog.txt', "Will update pay_transaction!\n" , FILE_APPEND);
					query("UPDATE pay_transaction SET 
						is_confirmed = 1, 
						ya_http_notice_id = {$yaRequestLogId},
						real_sum = {$withdraw_amount}
						WHERE id = {$label}"); 
					$this->_incrementUserAppCount($label, $withdraw_amount, $yaRequestLogId, $withdraw_amount);//Тут пользователь реально 60 отдаёт
				} else {
					file_put_contents(__DIR__ . '/postlog.txt', "In pay_transaction found record with id = {$label}, it bad!!\n" , FILE_APPEND);
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
	 * @param float $nSum номинальная сумма 
	 * @param float $nIncSum сумма фактически уплаченная пользователем, информация из нотайса
	*/
	private function _incrementUserAppCount($payTransactionId, $nSum, $yaRequestLogId, $nIncSum) {
		$sLogFile = (__DIR__ . '/postlog.txt');
		file_put_contents($sLogFile, "reciever.php::_incrementUserAppCount got payTransactionId = {$payTransactionId}\n", FILE_APPEND);
		$aUserdata = Shared::incrementUserAppCount($payTransactionId, $nSum, $yaRequestLogId, $sLogFile);
		Shared::sendEmailAboutPayment($nIncSum, $aUserdata, 'yandex', $sLogFile);
	}
}

new YaReciever();
