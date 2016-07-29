<?php
class Worker {
	public function __construct(){
		$action = isset($_POST['action']) ? $_POST['action'] : 'automoderate';
		switch ($action) {
			case 'automoderate':
				$this->_automoderate();
				break;
		}
	}
	/**
	 * @description 
	 * Модерирует объявления
    **/
	private function _automoderate() {
		if (!defined('AUTO_MODERATION_ON') || AUTO_MODERATION_ON !== true) {
			return;
		}
		$rows = query("SELECT id, created FROM main WHERE is_moderate = 0 AND automoderate = 1 LIMIT 100;", $n);
		if ($n) {
			$ids = array();
			$m = 0;
			foreach ($rows as $row) {
				$time = strtotime($row['created']);
				$now = strtotime(now());
				
				if ($now - $time > 15 * 60) {
					$ids[] = $row['id'];
					$m++;
				}
			}
			if ($m) {
				$ids = join(',', $ids);
				query("UPDATE main SET is_moderate = 1 WHERE id IN ({$ids})");
			}
		}
		json_ok();
	}
}




$w = new Worker();
