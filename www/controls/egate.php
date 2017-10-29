<?php
require_once DR . "/lib/classes/mail/SampleMail.php"; 
require_once DR . "/lib/shared.php"; 
class CRemindAction {
	public $id;
	public $login;
	public function __construct() {
		if (req('pwd') != EGATE_PWD) {
			echo '{r:false}';
			exit;
		}
		$mail = new SampleMail();
		$mail->setAddressFrom([SITE_EMAIL => SITE_EMAIL]);
		$mail->setSubject(req('subject'));
		$mail->setAddressTo([req('email') => req('email')]);
		$mail->setPlainText(req('body'));
		$r = $mail->send();
		echo json_encode(['r' => $r]);
		exit;
	}
	
}

$rform = new CRemindAction();
