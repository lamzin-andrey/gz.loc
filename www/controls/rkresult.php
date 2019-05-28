<?php
require_once DR . '/controls/classes/cpaycheck.php';
require_once DR . '/lib/classes/mail/SampleMail.php';
class RkResultReciever {
	public function __construct() {
		file_put_contents(__DIR__ . '/rklog.txt', "\n===========" . date('Y-m-d H:i:s') . "===========\n" . print_r($_POST, 1) . "\n" , FILE_APPEND);
		// registration info (password #2)
		$mrh_pass2 = RK_P2;
		if (defined('RK_TEST_MODE')) {
			$mrh_pass2 = RK_P2T;
		}
		//установка текущего времени
		//current date
		$tm=getdate(time()+9*3600);
		$date="$tm[year]-$tm[mon]-$tm[mday] $tm[hours]:$tm[minutes]:$tm[seconds]";

		// чтение параметров
		// read parameters
		$out_summ = req('OutSum');
		$label = $inv_id = ireq('InvId');
		$crc    = req('SignatureValue');
		$shp_item = req('Shp_item');
		$paymentMethod = req('PaymentMethod');
		$incSumm = floatval(req('IncSum'));
		$incCurrLabel = req('IncCurrLabel');
		$crc = strtoupper($crc);
		$my_crc = strtoupper(md5("{$out_summ}:{$inv_id}:{$mrh_pass2}:Shp_item={$shp_item}"));
		
		
		file_put_contents(__DIR__ . '/postlogrk.txt', "\ncrc = {$crc}\n\n" , FILE_APPEND);
		file_put_contents(__DIR__ . '/postlogrk.txt', "\nmy = '{$my_crc}'\n\n" , FILE_APPEND);
		
		if ($crc == $my_crc) {
			if (intval($label)) {
				$label = intval($label);
				$rkRequestLogId = $this->_insertRkassaNotificationData($out_summ, $label, $incSumm, $paymentMethod, $incCurrLabel, $shp_item);
				$nAff = dbvalue("SELECT is_confirmed FROM pay_transaction WHERE id = {$label}");
				if ($nAff == 0) {
					query("UPDATE pay_transaction 
						SET is_confirmed = 1, rk_http_notice_id = {$rkRequestLogId},
						real_sum = {$incSumm}
						WHERE id = {$label}"); 
					$this->_incrementUserAppCount($label, $out_summ, $rkRequestLogId, $incSumm);
				}
			}
			json_ok();
		} else {
			/*echo "$crc == $my_crc";
			die(__FILE__ .__LINE__);*/
		}
		header("HTTP/1.1 201 Created");
		exit;/**/
	}
	
	/**
	 * Логирование данных HTTP уаведомления от Рообокассы в базе данных
	*/
	private function _insertRkassaNotificationData($out_summ, $label, $incSumm, $paymentMethod, $incCurrLabel, $shp_item) {
		$cmd = 'INSERT INTO rk_http_notice (
			`out_summ`,  `inv_id`, `inc_sum`, `payment_method`, `inc_curr_label`, `shp_item`)
			VALUES (' . $out_summ . ', ' . $label . ', ' . $incSumm . ', \'' . $paymentMethod . '\', 
			\'' . $incCurrLabel . '\', ' . $shp_item . ')';
		$insertId = query($cmd);
		return $insertId;
	}
	/**
	 * @description Увелечение возможности поднимать объявления после успешной оплаты
	 * @param integer $payTransactionId идентификатор из pay_transaction
	 * @param float $nSum номинальная сумма 
	 * @param float $nIncSum сумма фактически уплаченная пользователем, информация из нотайса
	*/
	private function _incrementUserAppCount($payTransactionId, $nSum, $rkRequestLogId, $nIncSum) {
		$sLog = (__DIR__ . '/postlogrk.txt');
		$aUserdata = Shared::incrementUserAppCount($payTransactionId, $nSum, $rkRequestLogId, $sLog);
		Shared::sendEmailAboutPayment($nIncSum, $aUserdata, 'robokassa', $sLog);
	}
	
}

new RkResultReciever();
