<?php
require_once __DIR__ . '/api/OrdYaClient.php';

class GetErid {
	
	public function __construct()
	{
		$this->api = new OrdYaClient();
	}
	
	public function process()
	{
		$list = $this->getListEridNull();
		
		foreach ($list as $n => $row) {
			
			if ($this->isNull($row['user_id'])) {
				$row['user_id'] = $row['user_id2'];
				if ($this->isNull($row['user_id'])) {
					$row['user_id'] = $this->saveMainUser($n, $list);
				}
			}
			
			if ($this->isNull($row['contract_request_id'])) {
				$result = $this->api->postContract($row['user_id'], $this->getCreated($row['user_id']));
				if ($result->requestId) {
					$this->saveContractRequestId($row['user_id'], $result->requestId);
					$row['contract_request_id'] = $result->requestId;
				}
				if ($result->contractId) {
					$this->saveContractId($row['user_id'], $result->contractId);
					$row['ordya_contract_id'] = $result->requestId;
				}
			}
			
			if ($this->isNull($row['ordya_contract_id']) && !$this->isNull($row['contract_request_id'])) {
				$result = $this->api->getStatus($row['contract_request_id']);
				if ($result->objectId) {
					$this->saveContractId($row['user_id'], $result->objectId);
					$row['ordya_contract_id'] = $result->objectId;
				}
			}
			
			if ($this->isNull(@$row['ordya_erid']) && !$this->isNull($row['ordya_contract_id'])) {
				if ($this->isNull($row['creative_request_id'])) {
					$url = $this->getUrl($row['main_id'], $row['region_codename'], $row['codename']);
					$result = $this->api->postCreative($row['main_id'], $url, $row['ordya_contract_id'], $row['fias_id']);
					if ($result->creativeId) {
						$this->saveCreativeId($row['main_id'], $result->creativeId);
						$row['creative_request_id'] = $result->creativeId;
					}
					if ($result->requestId) {
						$this->saveCreativeRequestId($row['main_id'], $result->requestId);
						$row['ordya_erid'] = $result->creativeId;
						$row['creative_request_id'] = $result->requestId;
					}
				}
				if ($this->isNull(@$row['ordya_erid']) && !$this->isNull($row['creative_request_id'])) {
					$result = $this->api->getStatus($row['creative_request_id']);
					if ($result->creativeId) {
						$this->saveCreativeId($row['main_id'], $result->creativeId);
						$row['ordya_erid'] = $result->creativeId;
					}
				}
			}
			
			// break; // TODO remove me!
		}
	}
	
	private function isNull($v)
	{
		if (!isset($v)) {
			return true;
		}
		
		if ($v === '') {
			return true;
		}
		
		return false;
	}
	
	
	private function getListEridNull()
	{
		$sql = 'SELECT main.id AS main_id, users.id AS user_id, main_user.user_id AS user_id2,
						users.ordya_request_id AS contract_request_id,
						users.ordya_contract_id,
						regions.fias_id,
						main.ordya_request_id AS creative_request_id,
						regions.codename AS region_codename,
						main.codename
				FROM main
				LEFT JOIN users ON users.phone = main.phone
				LEFT JOIN regions ON regions.id = main.region
				LEFT JOIN main_user ON main_user.main_id = main.id
				WHERE main.is_hide = 0 AND main.is_moderate = 1 AND main.is_deleted = 0
					AND (main.ordya_erid IS NULL OR main.ordya_erid = \'\')
				ORDER BY main.id DESC
				LIMIT 100;
				';
		return query($sql);
	}
	
	private function saveMainUser($n, $list)
	{
		$mainId = $list[$n]['main_id'];
		$sz = count($list);
		for ($i = $n; $i < $sz; $i++) {
			$row = $list[$i];
			if (!$this->isNull($row['user_id'])) {
				query("INSERT INTO main_user (`main_id`, `user_id`) VALUES({$mainId}, {$row['user_id']});");
				return $row['user_id'];
			}
		}
		return 0;
	}
	
	private function getCreated($userId)
	{
		$nR = 0;
		$phone = dbvalue("SELECT phone FROM users WHERE id = {$userId} LIMIT 1;", $nR);
		if (!$nR) {
			return dbvalue("SELECT MIN(created) FROM main;");
		}
		$v = dbvalue("SELECT MIN(created) FROM main WHERE phone = '{$phone}' LIMIT 1;", $nR);
		if (!$nR) {
			return dbvalue("SELECT MIN(created) FROM main;");
		}
		
		return $v;
	}
	
	private function saveContractRequestId($userId, $requestId)
	{
		$now = now();
		query("UPDATE users SET ordya_request_id = '{$requestId}', ordya_last_request = '{$now}'
				WHERE id = {$userId}");
	}
	
	
	private function saveCreativeRequestId($mainId, $requestId)
	{
		$now = now();
		query("UPDATE main SET ordya_request_id = '{$requestId}', ordya_last_request = '{$now}'
				WHERE id = {$mainId}");
	}
	
	private function saveContractId($userId, $contractId)
	{
		$now = now();
		query("UPDATE users SET ordya_contract_id = '{$contractId}', ordya_last_request = '{$now}'
				WHERE id = {$userId}");
	}
	
	private function saveCreativeId($mainId, $creativeId)
	{
		$now = now();
		query("UPDATE main SET ordya_erid = '{$creativeId}', ordya_last_request = '{$now}'
				WHERE id = {$mainId}");
	}
	
	private function getUrl($mainId, $regionUrl, $codename)
	{
		$url = dbrow("SELECT url FROM custom_creatives WHERE main_id = {$mainId} LIMIT 1;");
		if ($url) {
			return $url;
		}
		return HTTP . SITE_NAME . '/' . $regionUrl . '/' . $codename . '/' . $mainId;
	}
}
