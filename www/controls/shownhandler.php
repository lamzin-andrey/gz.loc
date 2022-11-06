<?php
class ShownHandler {
	public function __construct()
	{
		$this->qDay = [0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
		$list = isset($_POST['list']) ? $_POST['list'] : [];
		foreach ($list as $id) {
			$this->addShown($id);
		}
		json_ok();
	}
	
	private function addShown($mainId)
	{
		$table = 'ordya_invoices';
		$nR = 0;
		$endDate = $this->getEndDate();
		$exists = dbrow("SELECT id FROM `ordya_invoices` WHERE main_id = {$mainId} AND end_date = '{$endDate}'", $nR);
		if (!$nR) {
			$advDate = dbvalue("SELECT created FROM main WHERE id = {$mainId};");
			if ($this->dateAGtDateB($advDate, $endDate)) {
				return;
			}
			$startDate = $this->getStartDate();
			if ($this->dateAGtDateB($advDate, $startDate)) {
				$startDate = $advDate;
			}
			$sql = "INSERT INTO {$table} (main_id, start_date, end_date) VALUES({$mainId}, '{$startDate}', '{$endDate}')";
			$invoiceId = query($sql);
		} else {
			$invoiceId = $exists['id'];
		}
		
		$table = 'ordya_erid_invoices_stat';
		$statId = intval(dbvalue("SELECT id FROM {$table} WHERE invoice_id = {$invoiceId} LIMIT 1;"));
		if (!$statId) {
			$sql = "INSERT INTO {$table} (invoice_id, imps, amounts) VALUES({$invoiceId}, 1, 0.00)";
			query($sql);
		} else {
			$sql = "UPDATE {$table} SET imps = imps + 1 WHERE invoice_id = {$invoiceId}";
			query($sql);
		}
		
	}
	
	private function getEndDate()
	{
		$m = intval(date('m'));
		$d = $this->getQDays($m);
		$date = date('Y-m-') . $d . ' 23:59:59';
		return $date;
	}
	
	private function getStartDate()
	{
		$date = date('Y-m-01') . ' 00:00:00';
		return $date;
	}
	
	private function getQDays($m)
	{
		$aDays = $this->qDay;
		if ($this->isLeapYear(date('Y'))) {
			$aDays[2] = 29;
		}
		
		$d = $aDays[$m];
		
		return $d;
	}
	
	private function isLeapYear($year)
	{
		$y = intval($year);
        $r = false;
        if ($y % 4 == 0) {
          if ($y % 100 == 0){
            if ($y % 400 == 0) return true;
              return false;
            }      
          return true;
        }
        return false;
	}	
	
	private function dateAGtDateB($dateA, $dateB)
	{
		$timeA = strtotime($dateA);
		$timeB = strtotime($dateB);
		return $timeA > $timeB;
	}
}

$sh = new ShownHandler();
