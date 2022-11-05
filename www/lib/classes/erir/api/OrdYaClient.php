<?php
require_once __DIR__ . '/Request.php';
class OrdYaClient
{
	const CONTRACTOR_ID = 1; // admin.id
	const DISTRIBUTION = 'distribution'; // см. документацию метода contract
	const HOST = 'https://ord.yandex.ru/api/v1'; // см. документацию если слетит
	const CREATIVE_DEFAULT_DESCRIPTION = 'Объявление о грузоперевозках малогабаритным грузовым транспортом';
	
	public function __construct()
	{
		
	}
	
	/**
	 * $userCreated 'Y-m-d H:i:s' время создания первого объявления пользователя
	 * @return {
	 * 	contractId, // готовый контракт id 
	 *  requestId   // с чем ходить за статусом
	 * }
	*/
	public function postContract($userId, $userCreated)
	{
		$id = $userId;
		$type = 'contract';
		$clientId = $userId;
		$contractorId = self::CONTRACTOR_ID;
		$isRegReport = true;
		$actionType = self::DISTRIBUTION;
		$subjectType = self::DISTRIBUTION;
		$number = '№' . $userId;
		$date = $this->date($userCreated);
		$amount = 0;
		$isVat = false;
		$req = new Request();
		
		$data = compact($id, $type, $clientId, $contractorId, $isRegReport, $actionType, $subjectType, $number, $date, $amount, $isVat);
		
		$url = self::HOST . '/contract'
		$resp = $req->execute($url, $data);
		$contractId = $resp->json->token; // TODO здесь после проверки может всё поменяться
		$result = new StdClass();
		$result->contractId = $contractId;
		$result->requestId = $request_id;
		
		return $result;
	}
	
	/**
	 * $contractId Полагаю, полученный из /contract id договора
	 * $fiasId     Идентификатор в ФИАС
	 * @return {
	 * 	creativeId, // готовый маркер креативности
	 *  requestId   // с чем ходить за статусом
	 * }
	*/
	public function postCreative($mainId, $url, $contractId, $fiasId)
	{
		$id = $mainId;
		$type = 'other';
		$form = 'text-graphic-block';
		$urls = [$url];
		$okveds = [];
		$fiasRegionList = [$fiasId];
		$description = self::CREATIVE_DEFAULT_DESCRIPTION;
		$data = compact($id, $type, $form, $urls, $okveds, $fiasRegionList, $description);
		
		$req = new Request();
		
		$url = self::HOST . '/creative'
		$resp = $req->execute($url, $data);
		$creativeId = $resp->json->token ? $resp->json->token : ''; // TODO здесь после проверки может всё поменяться
		$result = new StdClass();
		$result->creativeId = $creativeId;
		$result->requestId = $request_id;
		
		return $result;
	}
	
	/**
	 * $dateEnd invoices.date_end
	 * 
	 * @return {
	 * 	creativeId, // готовый маркер креативности
	 *  requestId   // с чем ходить за статусом
	 * }
	*/
	public function postInvoice($invoiceId, $userId, $dateStart, $dateEnd, $mainId, $amount, $imps)
	{
		$id = $invoiceId;
		$contractId = $userId;
		$clientRole = 'rd';
		$contractorRole = 'rr';
		$date = date('Y-m-d');
		$startDate = $this->date($dateStart);
		$endDate = $this->date($dateEnd);
		$isVat = false;
		$number = '№' . $invoiceId;
		$items = $this->createItems($invoiceId, $userId, $dateStart, $dateEnd, $mainId, $amount, $imps);
		
		$data = compact($id, $contractId, $clientRole, $contractorRole, $date, $startDate, $endDate, $amount, $isVat, $number, $items);
		
		$req = new Request();
		
		$url = self::HOST . '/invoice'
		$resp = $req->execute($url, $data);
		$status = $resp->json->token ? $resp->json->token : '';
		$result = new StdClass();
		$result->status = $status;
		$result->requestId = $request_id;
		
		return $result;
	}
	
	private function createItem($invoiceId, $userId, $dateStart, $dateEnd, $mainId, $amount, $imps)
	{
		$amountPerShow = 0;
		if (!$imps) {
			$imps = 1;
		}
		if ($amount > 0) {
			$amountPerShow = round($amount / $imps);
		}
		
		$item = [
			'contractId' => $userId,
			'amount' => $amount,
			'isVat' => false,
			'creatives' => [[
				'creativeId' => $mainId,
				'platforms' => [[
					'type' => 'site',
					'url' => 'http://' . SITE_NAME,
					'imps' => $imps,
					'dateStart' => $dateStart,
					'dateEnd' => $dateEnd,
					'amount' => $amount,
					'amountPerShow' => $amountPerShow,
					'isVat' => false,
				]],
			]]
		];
	}
	
	/**
	 * $dateEnd invoices.date_end
	 * 
	 * @return {
	 * 	creativeId, // готовый маркер креативности
	 *  status
	 * }
	*/
	public function getStatus($requestId)
	{
		
		$req = new Request();
		
		$url = self::HOST . '/status?reqid=' . $requestId;
		$resp = $req->execute($url);
		$creativeId = $resp->json->token ? $resp->json->token : '';
		$status = $resp->json->status ? $resp->json->status : '';
		$result = new StdClass();
		$result->creativeId = $creativeId;
		$result->status = $status;
		
		return $result;
	}
	
	private date($datetime)
	{
		$a = explode(' ', $datetime);
		return trim($a[0]);
	}
}
