<?php
require_once DR . "/lib/shared.php";
class Operations {
	public $rows;
	public $numRows = 0;
	public $prev;
	public $next;
	public $phone;
	public $otype;
	
	public $countedSumm = 'pNaN';
	public $balance = 'pNaN';
	public function __construct() {
		$this->phone = $phone = Shared::preparePhone(req('phone'));
		//if ($phone) {
			$this->_getRows();
		//}
	}
	private function _getRows() {
		if (!req('from', 'GET')) {
			$_GET['from'] = date('Y-m-01');
		}
		if (!req('to', 'GET')) {
			$_GET['to'] = date('Y-m-d');
		}
		$this->from = req('from', 'GET');
		/*var_dump($this->from);
		die;/**/
		$this->to = req('to', 'GET');
		$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		$page = $page ? $page : 1;
		$limit = 31;
		$offset = ($page - 1) * 10;
		
		$typeCondition = $this->_readTypeCond();
		$phoneCondition = "u.phone = '{$this->phone}'";
		if (!$this->phone) {
			$phoneCondition = "u.phone != 'NANT'";
		}
		$interval = $this->_readDateInterval();
		
		$cmd = "SELECT o.created, u.phone, u.email AS uemail, oc.name, o.main_id, o.upcount, o.sum, pt.real_sum, o.pay_transaction_id 
		FROM operations AS o
		LEFT JOIN op_codes AS oc ON oc.id = o.op_code_id
		LEFT JOIN pay_transaction AS pt ON pt.id = o.pay_transaction_id
		LEFT JOIN users AS u ON u.id = o.user_id
		WHERE {$phoneCondition}
		{$typeCondition}
		{$interval}
		ORDER BY created DESC LIMIT {$offset}, {$limit}
		";
		
		$this->rows = $data = query($cmd, $this->numRows);
		
		$this->prev = $page - 1;
		$this->prev = $this->prev ? $this->prev : 1;
		$this->next = $page + 1;
		
		//Посчитать сумму баланса за период
		$cmd = "SELECT SUM(o.upcount) AS sum
		FROM operations AS o
		LEFT JOIN users AS u ON u.id = o.user_id
		WHERE u.phone = '{$this->phone}'
		{$interval}
		";
		$this->countedSumm = dbvalue($cmd);
		$this->balance = dbvalue("SELECT upcount FROM users WHERE phone = '{$this->phone}'");
	}
	
	/**
	 * @description Считать требуемый тип операции - Расход, приход
	*/
	private function _readDateInterval(){
		$from = req('from');
		$to = req('to');
		$s = '';
		if ($from) {
			$from .= ' 00:00:00';
			$s = ' AND o.created >= \'' . $from . '\'';
		}
		$to = req('to');
		if ($to) {
			$from .= ' 23:59:59';
			$s .= ' AND o.created <= \'' . $to . '\'';
		}
		return $s;
	}
	
	/**
	 * @description Считать требуемый тип операции - Расход, приход
	*/
	private function _readTypeCond(){
		$this->otype = $type = intval(req('otype'));
		if ($type) {
			switch ($type) {
				case 3:
					return ' AND o.upcount < 0 ';
			}
			return ' AND o.upcount > 0 ';
		}
		return '';
	}
}

$ops = new Operations();
$css = isset($css) ? $css : '';
$css .= '<link href="/styles/ops.css?' . ASSETS_VERSION . '" media="all" rel="stylesheet" type="text/css" />';
