<?php
class Paycheck {
	/**
	 * @description сумма - кол-во поднятий.
	*/
	public static $offers = [
		60 => 1,
		200 => 5,
		700 => 31
	];
	
	public function __construct() {
		$method = isset($_POST['q']) ? $_POST['q'] : '';
		$sum    = isset($_POST['n']) ? intval($_POST['n']) : '';
		$isValid = $this->_validatePaysum($sum);
		$isValid = $isValid && $this->_validatePaytype($method);
		$cache  = isset($_POST['r']) ? trim($_POST['r']) : '';
		$userId = sess('uid');
		if ($userId && $isValid) {
			if ($cache == YAM) {
				$now = now();
				$insertId = query("INSERT INTO pay_transaction
					(user_id, cache,        sum,       method, created)
				VALUES
					({$userId}, '{$cache}', '{$sum}', '{$method}', '{$now}')
				");
				json_ok('id', $insertId, 'sum', $sum, 'q', $method);
			} else {
				file_put_contents(__DIR__ . '/invalidrec.txt', $cache . "\n", FILE_APPEND);
			}
		}
		/*$yam = ($cache == YAM);
		$vars = compact('isValid', 'yam', 'userId');
		json_error_arr($vars);/**/
		json_error();
	}
	
	private function _validatePaysum($sum) {
		if ($sum == 60 || $sum == 200 || $sum == 700) {
			return true;
		}
		return false;
	}
	private function _validatePaytype($s) {
		if ($s == 'ps' || $s == 'bs' || $s == 'ms') {
			return true;
		}
		return false;
	}
}
