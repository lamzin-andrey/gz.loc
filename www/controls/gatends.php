<?php
require_once DR . "/lib/shared.php"; 
class CGateNDS {
	public $id;
	public $login;
	private $_errors = [];
	
	public function __construct() {
		if (req('pwd') != ADV_GATE_PWD) {
			echo 'Invalid password';
			exit;
		}
		$this->cors();
		
		$aData = req('data');
		//print_r($aData);
		
		foreach ($aData as $aRow) {
			$exists = dbvalue("SELECT id FROM googlends WHERE payment_date = '{$aRow['date']}' AND payment_sum = {$aRow['price']}");
			if (!$exists) {
				query("INSERT INTO googlends 
				(`payment_date`, `payment_sum`, `is_public`) VALUES 
				('{$aRow['date']}', {$aRow['price']}, 0)");
			}
		}
		die('Hello');
	}
	
	function cors() {
		// Allow from any origin
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			// Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
			// you want to allow, and if so:
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400');    // cache for 1 day
		}

		// Access-Control headers are received during OPTIONS requests
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				// may also be using PUT, PATCH, HEAD etc
				header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

			exit(0);
		}

		//echo "You have CORS!";
	}

	/**
	 * @description потому что мало ли где ещё буду использовать
	*/
	
}

$rform = new CGateNDS();
