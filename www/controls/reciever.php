<?php
class YaReciever {
	public function __construct() {
		file_put_contents(__DIR__ . '/postlog.txt', "\n===========" . date('Y-m-d H:i:s') . "===========\n" . print_r($_POST, 1) . "\n" , FILE_APPEND);
		$operation_id      = req('operation_id');
		$notification_type = req('notification_type');
		$datetime          = req('datetime');
		$sha1_hash         = req('sha1_hash');
		$sender            = req('sender');
		$codepro           = req('codepro');
		$codepro = $codepro && $codepro != 'false' ? 'true' : 'false';
		$currency = req('currency');
		$amount   = req('amount');
		$withdraw_amount = req('withdraw_amount');
		$label    = req('label');
		
		$secret = YAKEY;
		$str = "{$notification_type}&{$operation_id}&{$amount}&{$currency}&{$datetime}&{$sender}&{$secret}&{$label}";
		$hash = sha1($str);
		
		file_put_contents(__DIR__ . '/postlog.txt', "\nhash = {$hash}\n\n" , FILE_APPEND);
		
		if ($str == $sha1_hash) {
			json_ok();
		}
		header("HTTP/1.1 201 Created");
		exit;/**/
	}
}

new YaReciever();
