<?php
require_once __DIR__ . '/api/OrdYaClient.php';

class SendInvoice {
	public function __construct()
	{
		$this->api = new OrdYaClient();
	}
	public function process()
	{
		return;
		$list = $this->getNoSendInvoices();
		
		foreach ($list as $n => $row) {
			if ($row['ordya_request_id']) {
				$resp = $this->api->getStatus($row['ordya_request_id']);
				$status = isset($resp->status) ? $resp->status : '';
				if (strpos($status, 'success') !== false) {
					$this->saveAsSended($row['invoice_id'], $resp->status);
				} else {
					$this->saveStatus($row['invoice_id'], $resp->status);
				}
			} else {
				$resp = $this->api->postInvoice($row['invoice_id'], $row['user_id'], $row['start_date'], $row['end_date'], $row['main_id'], $row['amounts'], $row['imps']);
				$status = isset($resp->status) ? $resp->status : '';
				if (strpos($status, 'success') !== false) {
					$this->saveAsSended($row['invoice_id'], $resp->status);
				}
				if ($resp->requestId) {
					$this->saveRequestId($row['invoice_id'], $resp->requestId);
				}
			}
		}
	}
	
	private function saveAsSended($invoiceId, $status)
	{
		$now = now();
		query("UPDATE ordya_erid_invoices_stat 
				SET is_sended = 1,
					ordya_last_request = '{$now}',
					ordya_status = '{$status}'
					WHERE invoice_id = {$invoiceId};");
	}
	
	private function saveStatus($invoiceId, $status)
	{
		$now = now();
		query("UPDATE ordya_erid_invoices_stat 
				SET is_sended = 1,
					ordya_last_request = '{$now}',
					ordya_status = '{$status}'
					WHERE invoice_id = {$invoiceId};");
	}
	
	private function saveRequestId($invoiceId, $requestId)
	{
		$now = now();
		query("UPDATE ordya_erid_invoices_stat 
				SET ordya_request_id = '{$requestId}',
					ordya_last_request = '{$now}'
					WHERE invoice_id = {$invoiceId};");
	}
	
	private function getNoSendInvoices()
	{
		$m = intval(date('m'));
		$y = date('Y');
		$startM = $m < 10 ? ('0' . $m) : $m;
		$endDate = $y . '-' . $startM . '-01 00:00:00';
		$m--;
		if ($m <= 0) {
			$m = 12;
			$y--;
		}
		$endM = $m < 10 ? ('0' . $m) : $m;
		$startDate = $y . '-' . $endM . '-01 00:00:00';
		
		$sql = "SELECT ordya_invoices.id AS invoice_id, 
						users.id AS user_id,
						main_user.user_id AS user_id2,
						ordya_invoices.start_date,
						ordya_invoices.end_date,
						ordya_invoices.main_id,
						st.amounts, 
						st.imps,
						st.ordya_request_id 
				FROM ordya_invoices
				INNER JOIN main  ON main.id = ordya_invoices.main_id
				LEFT JOIN main_user  ON main_user.main_id = ordya_invoices.main_id
				LEFT JOIN users  ON users.phone = main.phone
				INNER JOIN ordya_erid_invoices_stat AS st ON st.invoice_id = ordya_invoices.id
				
				WHERE (st.is_sended IS NULL OR st.is_sended = 0)
					AND ordya_invoices.start_date >= '{$startDate}' 
					AND  ordya_invoices.end_date <= '{$endDate}'
		";
		
		return query($sql);
	}
}
