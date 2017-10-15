<?php
class CRkRdir {
	
	public function __construct($logfileshortname = 't.log', $successKey) 
	{
		$upId = $this->_getUpId();
		if ($upId) {
			sess('successKey', $successKey);
			utils_302('/cabinet/up/' . $upId . '/');
		} else {
			utils_302('/cabinet/');
		}
		file_put_contents( __DIR__ . '/' . $logfileshortname, print_r($_POST, 1) . "\n", FILE_APPEND );
		exit;
	}
	private function _getUpId()
	{
		$upId = sess('upId', null, 0);
		if ($upId) {
			return $upId;
		}
		$phone = sess('phone');
		if ($phone) {
			$upId = dbvalue("SELECT id FROM main WHERE phone = '{$phone}' AND is_deleted = 0 AND is_hide = 0 LIMIT1");
		}
		return $upId;
	}
}
