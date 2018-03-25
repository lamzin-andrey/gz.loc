<?php
require_once DR . '/lib/classes/sms/epochta2.php';
require_once DR . '/lib/classes/sms/smspilot.php';
class Worker {
	public function __construct(){
		$action = isset($_POST['action']) ? $_POST['action'] : 'automoderate';
		switch ($action) {
			case 'automoderate': //this legacy - теперь выполняем все действия, в зависимости от включенных констант.
				$this->_automoderate();
				$this->_sms();
				$this->_upcountRestore();
				json_ok();
				break;
		}
	}
	/**
	 * @description восстановить всем "баланс" поднятий сообщений в начале месяца
    */
    private function _upcountRestore() {
		if (defined('PAY_ENABLED')) {
			return;
		}
		$s = date('Ym');
		$sql = "SELECT c FROM ymup WHERE c = {$s}";
		$r = dbvalue($sql);
		if ($r === $s) {
			return;
		}
		query("UPDATE users SET upcount = 200 WHERE upcount < 200");
		query("INSERT INTO ymup VALUES ({$s})");
	}
	/**
	 * @description рассылка сообщений
    **/
    private function _sms() {
		if (!defined('SMS_SERVICE_ON') || SMS_SERVICE_ON !== true) {
			return;
		}
		//чтобы избежать рассылок на одни и те же номера.
		$file = __DIR__ . '/smsproc';
		if (file_exists($file)) {
			$time = filemtime($file);
			if (time() - $time < 60) {
				return;//еще и минуты не прошло, как кто-то запустил воркер
			}
		}
		file_put_contents($file, time());
		
		//берем из базы 100 записей.
		$list = query('SELECT * FROM sms_code LIMIT 0, 100', $count);
		
		foreach ($list as $k => $i) {
			if ($i['phone'] == '710637') {
				unset($list[$k]);
			}
		}
		
		if ($count) {
			//отправляем смс
			$className = rand(1111, 9999) % 2 == 0 ? 'EPochta2' : 'SMSPilot';
			$className = 'SMSPilot';
			//$results = EPochta2::send($list);//TODO
			//$results = SMSPilot::send($list);
			$results = $className::send($list);
			//если успешно, удаляем из базы номер.
			$numbers = [];
			$numbersSz = 0;
			foreach ($results as $smsResult) {
				//if ($smsResult->success == true) {
					$numbers[] = $smsResult->number;
					$numbersSz++;
				//}
			}
			if ($numbersSz) {
				$numbers = array_map(function($i){
					return "'{$i}'";
				}, $numbers);
				$sNumbers = join(',', $numbers);
				query("DELETE FROM sms_code WHERE phone IN({$sNumbers})");
			}
		}
		@unlink($file);
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
	}
}




$w = new Worker();
