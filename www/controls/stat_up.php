<?php
class CStatUp {
	public $rows;
	public $numRows = 0;
	public $prev;
	public $next;
	public function __construct() {
		$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		$page = $page ? $page : 1;
		$limit = 10;
		$offset = ($page - 1) * 10;
		$cmd = "SELECT _date, _count FROM stat_up
		ORDER BY _date DESC LIMIT {$offset}, {$limit}";
		$this->rows = $data = query($cmd, $this->numRows);
		$this->prev = $page - 1;
		$this->prev = $this->prev ? $this->prev : 1;
		$this->next = $page + 1;
	}
}

$statUp = new CStatUp();
