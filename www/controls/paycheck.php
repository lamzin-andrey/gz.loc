<?php
class Paycheck {
	public function __construct() {
		//TODO validate it
		$method = isset($_POST['q']) ? $_POST['q'] : '';
		//TODO validate it
		$sum    = isset($_POST['n']) ? intval($_POST['n']) : '';
		$cache  = isset($_POST['r']) ? intval($_POST['r']) : '';
		if ($cache == YAM) {
			//TODO insert order data
			//insert: sess('phone'), cache, sum, method, datetime, user.id
			json_ok('id', $insertId, 'sum', $sum, 'q', $q);
		}
		json_error();
	}
}
