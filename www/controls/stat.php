<?php
class CStat {
	public $rows;
	public $numRows = 0;
	public function __construct() {
		$rows = $this->_getPart($num);
		$limit = 15;
		$rows = $this->_deleteExists($rows, $num, $sz);
		$page = 2;
		while ($sz < $limit) {
			if ($num == 0) {
				break;
			}
			$rowsNext = $this->_getPart($num, $page);
			$rowsNext = $this->_deleteExists($rowsNext, $num, $sz);
			$rows += $rowsNext;//TODO test it
		}
		$this->rows = $rows;
		$this->numRows = count($rows);
		if ($this->numRows > $limit) {
			$this->rows = array_chunk($rows, $limit);
			$this->rows = $this->rows[0];
			$this->numRows = $limit;
		}
	}
	
	private function _getPart(&$numRows, $page = 1) {
		$limit = 30;
		$offset = ($page - 1) * $limit;
		$cmd = "SELECT country_name, region_name, city_name, cities.id  AS city_id FROM stat AS s
		 LEFT JOIN countries ON s.country = countries.id
		 LEFT JOIN regions ON s.region = regions.id
		 LEFT JOIN cities ON s.city = cities.id
		ORDER BY cnt DESC LIMIT {$offset}, {$limit}";
		$rows  = query($cmd, $numRows);
		return $rows;
	}
	/**
	 * @description Удаляет из выборки те записи, для которых есть хотя бы одно опубликованное объявление
	 * @param $rows
	 * @param $num размер $rows
	 * @param &$sz размер $rows после удаления существующих
	*/
	private function _deleteExists($rows, $num, &$sz) {
		if ($num == 0) {
			$sz = 0;
			return $rows;
		}
		$ids = [];
		$buf = [];
		foreach ($rows as $row) {
			$ids[] = (int)$row['city_id'];
			$buf[$row['city_id']] = $row;
		}
		$sIds = join(',', $ids);
		$data = query("SELECT id, city FROM main WHERE city IN ({$sIds}) AND is_deleted = 0 AND is_moderate = 1 AND is_hide = 0", $count);
		foreach ($data as $item) {
			if (  isset($buf[ $item['city'] ])  ) {
				unset($buf[ $item['city'] ]);
			}
		}
		$sz = count($buf);
		return $buf;
	}
}

$stat = new CStat();
