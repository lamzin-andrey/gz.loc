<?php
require_once DR . "/lib/shared.php"; 
class CUnsubscribeAction {
	public $id;
	public $email;
	public function __construct() {
		$email = '';
		if (a($_GET, 'status') !== null && !count($_POST)) {
			$this->email = sess('email');
		}
		if ( count($_POST) ) {
			$email = $this->email = treq('email');
		}
		
		if ($email) {
			$success = false;
			//TODO insert into uns ON DUP UP
			global $dberror;
			if ($dberror) die($dberror);
			$insertId = query("INSERT INTO unsubscribe (`email`, `n`) VALUES('{$email}', 0) 
				ON DUPLICATE KEY UPDATE n = n + 1
			", $nR, $nAf);
			
			if ($insertId) {
				$_SESSION['ok_msg'] = "Получатель {$email} отписан от рассылки.";
				utils_302("/unsubscribe?status=0"); //Все ок
			} else {
				$_SESSION["ok_msg"] = "Не удалось отписать от рассылки адрес {$email}. Пожалуйста, повторите попытку позже.";
				utils_302("/unsubscribe?status=1");
			}
		}
	}
}

$rform = new CUnsubscribeAction();
