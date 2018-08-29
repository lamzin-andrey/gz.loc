<?php
require_once DR . "/lib/shared.php"; 
class CGateAdv {
	public $id;
	public $login;
	public function __construct() {
		if (req('pwd') != ADV_GATE_PWD) {
			echo 'Invalid password';
			exit;
		}
		/*print_r($_POST);
		die;*/
		if (req('bCheck')) {
			$this->_checkPhone();
		}
		if (req('bSend')) {
			$this->_saveAdv();
		}
	}
	
	private function saveAdv() {
		//get city id!!
		//check type and far away
		//check price
		//save data
	}
	
	private function _checkPhone() {
		$phone = Shared::preparePhone(req('iPhone'));
		$sql = 'SELECT * FROM main WHERE phone = \'' . $phone . '\'';
		$rows = query($sql);
		if (count($rows)) {
			die('Существует объявление с таким телефоном');
		}
		die('Можно подавать');
	}
	
}

$rform = new CGateAdv();
