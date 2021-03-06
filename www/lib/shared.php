<?php
require_once DR . '/lib/classes/mail/SampleMail.php';
class Shared {
	
	static $authUserBalance = null;
	
	static public function preparePhone($phone) {
		$phone = trim($phone);
		$plus = 0;
		if (isset($phone[0]) && $phone[0] == '+') {
			$plus = 1;
		}
		$s = trim(preg_replace("#[\D]#", "", $phone));
		if ($plus && strlen($s) > 10) {
			$code = substr($s, 0, strlen($s) - 10 );
			$tail = substr($s, strlen($s) - 10 );
			$code++;
			$s = $code . $tail;
		} elseif($plus) {
			$s = '';
		}
		return $s;
	}
	static public function prepareItem(&$r) {
		$r["type"] = array();
		if ($r["box"] == 1) {
			$r["type"][] = "грузовая";
		}
		if ($r["people"] == 1) {
			$r["type"][] = "пассажирская";
		}
		if ($r["term"] == 1) {
			$r["type"][] = "термобудка";
		}
		$r["type"] = join(", ", $r["type"]);
		$r["type"] = Shared::up1st($r["type"]);
		
		$r["distance"] = array();
		if ($r["near"] == 1) {
			$r["distance"][] = "по городу";
		}
		if ($r["far"] == 1) {
			$r["distance"][] = "межгород";
		}
		if ($r["piknik"] == 1) {
			$r["distance"][] = "за город (пикник)";
		}
		$r["distance"] = join(", ", $r["distance"]);
		$r["distance"] = Shared::up1st($r["distance"]);
		
		$r["viewphone"] = Shared::formatPhone($r['phone']);
		$r["created"] = Shared::formatDate($r['created']);
		global $baseUrl;
		$r["link"] = "$baseUrl/" . $r["codename"] . "/" . $r["id"];
		if ($baseUrl == '') {
			$bu = "";
			$bu = self::loadLocationByAbvId($r["id"]);
			$r["link"] = "$bu/" . $r["codename"] . "/" . $r["id"];
		}
		
	}
	
	static private function loadLocationByAbvId($id) {
		$id = (int)$id;
		if (!@$_SESSION["locs"][$id]) {
			$cmd = "SELECT r.codename AS rc, c.codename AS cc FROM main
				LEFT JOIN regions AS r ON r.id = main.region 
				LEFT JOIN cities AS c ON c.id = main.city
				WHERE main.id = $id 
			";
			$row = dbrow($cmd, $nr);
			if ($nr) {
				if (strlen($row['cc']) && strlen($row['rc'])) {
					$_SESSION["locs"][$id] = $s = "/{$row['rc']}/{$row['cc']}";
				} else if( strlen($row['rc']) ) {
					$_SESSION["locs"][$id] = $s = "/{$row['rc']}";
				}
			}
		}
		return @$_SESSION["locs"][$id];
	}
	
	static public function modCityName($s) {
		if ($s == "Марий Эл") return $s;
		$s = trim($s);
		$g = "аеёиоуыэюя";
		$sg = "бвгджзйклмнпрстфхцчшщъь";
		$g = utils_cp1251($g);
		$sg = utils_cp1251($sg);
		$s = utils_cp1251($s);
		
		if (strpos($s, ' ') !== false) {
			$ar = explode(' ', $s);
			$first = str_replace(
				array( utils_cp1251("ой "), utils_cp1251("ая "),  utils_cp1251("ое "), utils_cp1251("ый "), utils_cp1251("ие "), utils_cp1251("ые "), utils_cp1251("кий "), utils_cp1251("ий "),  ),
				array( utils_cp1251("ом "), utils_cp1251("ой "), utils_cp1251("ом "), utils_cp1251("ом "), utils_cp1251("их "), utils_cp1251("ых "), utils_cp1251("ком "),  utils_cp1251("ем ") ),
				$ar[ count($ar) - 2] . ' '
			);
			$second = $ar[ count($ar) - 1];
			if ($second == utils_cp1251("Яр")) return utils_utf8($s);
			self::modLastLetter($second, $sg);
			$s = utils_utf8(trim($first)) . ' ' . utils_utf8($second); 
		} else {
			self::modLastLetter($s, $sg);
			$s = utils_utf8($s);
		}
		return $s;
	}
	
	static private function modLastLetter(&$second, $sg) {
		$secondSRep = 0;
		$lastLetter = a($second, strlen($second) - 1);
		$preLastLetter = a($second, strlen($second) - 2);
		$preLastLetter2 = a($second, strlen($second) - 3);
		$msog = utils_cp1251( "н" );
		if ( strpos($sg, $lastLetter) === false ) {
			if ($lastLetter == utils_cp1251('е')) {
				$secondSRep = 1;
				$second = str_replace(
					array( utils_cp1251("ае "),  utils_cp1251("ое "), utils_cp1251("ый "), utils_cp1251("ие "), utils_cp1251("ые ") ),
					array(utils_cp1251("ае"), utils_cp1251("ом"), utils_cp1251("ом"), utils_cp1251("их"), utils_cp1251("ых") ),
					$second . ' ',
					$cnt
				);
			}
			if ($lastLetter == utils_cp1251('а')) {
				$lastLetter = utils_cp1251('е');
			}
			if ($lastLetter == utils_cp1251('ы')) {
				$lastLetter = utils_cp1251('ах');
			}
			if ($lastLetter == utils_cp1251('и')) {
				if (strpos($msog, $preLastLetter) === false) {
					$lastLetter = utils_cp1251('ах');
				} else {
					$lastLetter = utils_cp1251('ях');
				}
			}
			if ($lastLetter == utils_cp1251('я') && $preLastLetter != utils_cp1251('а')) {
				$lastLetter = utils_cp1251('и');
			}
		} else { 
			if ($lastLetter == utils_cp1251('ь')) {
				//$lastLetter = utils_cp1251('и');
				if (strpos($msog, $preLastLetter) !== false) {
					$lastLetter = utils_cp1251('и');
				} else {
					$lastLetter = utils_cp1251('е');
				}
			}else
			if ($lastLetter == utils_cp1251('й')) {
				$secondSRep = 1;
				$second = str_replace(
					array( utils_cp1251("ий "),  utils_cp1251("ай "), utils_cp1251("ый "), utils_cp1251("ой "), utils_cp1251("ей") ),
					array(utils_cp1251("ом"), utils_cp1251("ае"), utils_cp1251("ом"), utils_cp1251("ом"), utils_cp1251("ее") ),
					$second . ' '
				);
			}else {
				$lastLetter .= utils_cp1251('е');
			}
		}
		if (!$secondSRep) {
			if ( strlen($lastLetter) == 1 ) {
				$second[ strlen($second) - 1 ] = $lastLetter;
			} else {
				//$second[ strlen($second) - 1 ] = '';
				$second = substr($second, 0, strlen($second) - 1);
				$second .= $lastLetter;
			}
		}
		trim($second);
	}
	
	static public function formatPhone($s) {
		if (strlen($s) < 11) {
			return $s; 
		}
		$a = array();
		for ($i = strlen($s) - 1, $j = 1; $i > -1; $i--, $j++) {
			$a[] = $s[$i];
			if ($j == 2 || $j == 4 /*|| $j == 7 || $j == 10*/) {
				$a[] = '-';
			}
			if ($j == 10) {
				$a[] = '(';
			}
			if ($j == 7) {
				$a[] = ')';
			}
		}
		$s = join('', array_reverse($a));
		return $s;
	}
	
	static public function up1st($s, $enc = "utils_utf8") {
		if ($enc == "utils_utf8") {
			$s = utils_cp1251($s);
		}
		$first = substr($s, 0, 1);
		$tail = substr($s, 1);
		$first = mb_strtoupper($first, "Windows-1251");
		$s = "$first$tail";
		if ($enc == "utils_utf8") {
			$s = utils_utf8($s);
		}
		return $s;
	}
	
	/**
    * @desc 
    * @param
    * @param
    * @return
    **/
    static public function formatDate($r, $breakTime = false) {
    	if ($r == '0000-00-00 00:00:00' || !$r) return ' вчера';
    	$a = explode(" ", $r);
    	$_d = $d = @$a[0];
    	$t = @$a[1];
    	$d = explode("-", $d);
    	$d = join('.', array_reverse($d));
    	
    	$t = explode(":", $t);
    	unset($t[2]);
    	$r = $d;
    	
    	$now = explode(' ', now());
    	$now = $now[0];
    	
    	if ($_d == $now) {
    		$r = 'сегодня';
    	}
    	
    	if (!$breakTime) {
    	   $r .= " в " .join(':', $t);
    	}
        return $r;
    }
    /**
    * @desc 
    * @param
    * @param
    * @return
    **/
    static public function price($s) {
    	return utils_money($s);
    }
    /**
    * @desc Изменить значение переменной var в request_uri
    * @param string $var
    * @param string $val
    * @return string
    **/
    static public function setUrlVar($var, $val) {
    	$a = explode("?", $_SERVER["REQUEST_URI"]);
    	$base = $a[0];
    	$data = array();
    	$_GET[$var] = $val;
    	if ($val == 1) {
    		unset($_GET[$var]);
    	}
    	foreach ($_GET as $k => $i) {
    		$data[] = "$k=$i";
    	}
    	if (count ($_GET)) {
    		$base .= "?" . join('&', $data);
    	}
    	return $base;
    }
    /**
	 * @desc Удаляем xss sql
	 * */
    static public function deinject($s) {
    	$s = trim($s);
    	$words = array('select', 'insert', 'delete', 'drop', 'and', 'or', 'union', 'join', 'update', 'SELECT', 'INSERT', 'DELETE', 'DROP', 'AND', 'OR', 'UNION', 'JOIN', 'UPDATE');
		$replaces = array();
		foreach ($words as $w) {
			$replaces[] = '';
		}
		$s = str_replace($words, $replaces, $s);
		//xss
		$s = strip_tags($s, 'a');
		$s = preg_replace("#on[\S]+[\s]*=#", '', $s);
		$s = str_replace("'", '&quot;', $s);
		$s = mysql_real_escape_string($s);
		return trim($s);
    }
    
    static private function normalize(&$cname){
		$cname = substr($cname, 0, 128);
		$w = "abcdefghijklmnopqrstuvwxyz-_";
		$r = '';
		for ($i = 0; $i < strlen($cname); $i++) {
			if ( strpos($w, $cname[$i]) !== false) {
				$r .= $cname[$i];
			}
		}
		$cname = $r;
	}
	static public function getRegion($cname) {
		//normalize($cname);
		$cmd = "SELECT id FROM regions WHERE codename = '$cname'";
		$id = (int)dbvalue($cmd);
		return $id;
	}
	
	static public function getCity($cname, $regId = 0) {
		$cmd = "SELECT id FROM cities WHERE codename = '$cname'";
		if ($regId) {
			$cmd = "SELECT id FROM cities WHERE codename = '{$cname}' AND region = {$regId}";
		}
		$id = (int)dbvalue($cmd);
		return $id;
	}
	
	static public function getTitle($id) {
		$id = (int)$id;
		$cmd = "SELECT codename FROM main WHERE id = $id";
		$title = dbvalue($cmd);
		return $title;
	}
    
	static public function getCityNameById($id) {
		$id = (int)$id;
		$cmd = "SELECT codename FROM cities WHERE id = $id";
		return dbvalue($cmd);
	}
	
	static public function getRegNameById($id) {
		$id = (int)$id;
		$cmd = "SELECT codename FROM regions WHERE id = $id";
		return dbvalue($cmd);
	}
	static public function getEMonth($shift = 0) {
		$n = intval(date('m')) + $shift;
		if ($n > 12) {
			$n = 1;
		}
		$a = [0, 'январе', 'феврале', 'марте', 'апреле', 'мае', 'июне', 'июле', 'августе', 'сентябре', 'октябре', 'ноябре', 'декабре'];
		return $a[$n];
	}
	/**
	 * @description Увелечение возможности поднимать объявления после успешной оплаты
	 * @param integer $payTransactionId идентификатор из pay_transaction
	 * @param float $nSum сумма фактически уплаченная пользователем, информация из нотайса
	 * @param integer $requestLogId идентификатор записи в талблице в таблице ya_http_notice, логируется если не удалось найти запись в pay_transaction
	 * @param string $logFileName имя файла в который логируется идентификатор записи, если не удалось найти запись в pay_transaction
	 * @return array row from users
	*/
	static public function incrementUserAppCount($payTransactionId, $nSum, $requestLogId, $logFileName = 'wrong_summ_log.txt') {
		$sql = "SELECT pt.real_sum,  pt.sum, pt.user_id, u.email, u.phone
		FROM pay_transaction AS pt
		LEFT JOIN users AS u ON u.id = pt.user_id
		
		WHERE pt.id = {$payTransactionId}
		";
		$storedSumData = dbrow($sql);
		$storedSum = isset($storedSumData['sum']) ? $storedSumData['sum'] : 0;
		if (!$storedSum) {
			file_put_contents($logFileName, ('!$storedSum, requestLogId = ' . $requestLogId. ", 
				payTransactionId = {$payTransactionId}\n"), FILE_APPEND);
			file_put_contents($logFileName, ('Sql: "' . $sql . '"' . "\n"), FILE_APPEND);
			return ['sum' => 0, 'user_id' => 0, 'email' => '', 'phone' => ''];
		} else {
			file_put_contents($logFileName, "storedSum = '{$storedSum}', nSum = '{$nSum}' \n", FILE_APPEND);
		}
		$upcount = Paycheck::$offers[intval($storedSum)];
		file_put_contents($logFileName, "init upcount = '{$upcount}' \n", FILE_APPEND);
		//если сумма, оплаченная пользователем не входит в перечень заданных в платежной форме,
		//	находим среди заданных первый, меньший чем внесенная сумма, и считаем кол-во поднятий по этой стоимости.
		if (intval($storedSum) != intval($nSum)) {
			$a = array_keys(Paycheck::$offers);
			$sz = count($a);
			$sumFound = false;
			$upPrice = 60;
			for ($i = $sz - 1; $i > -1; $i--) {
				if ($a[$i] == $nSum) {
					$sumFound = true;
					break;
				}
				if ($a[$i] <= $nSum)	{
					$upPrice = $a[$i] / Paycheck::$offers[ $a[$i] ];
					$upcount = ceil($nSum / $upPrice);	
					break;
				}
			}
		} else {
			$upcount = Paycheck::$offers[intval($nSum)];
			file_put_contents($logFileName, "ELSE380 upcount = '{$upcount}' \n", FILE_APPEND);
		}
		file_put_contents($logFileName, "calc upcount = '{$upcount}'\n", FILE_APPEND);
		//записываем в истории операций
		$userId = isset($storedSumData['user_id']) ? $storedSumData['user_id'] : 0;
		$now = now();
		$sql = "INSERT INTO operations
			(`user_id`, `op_code_id`, `upcount`, `main_id`, `created`, `sum`, `pay_transaction_id`) VALUES
			('{$userId}', 2, '{$upcount}', 0, '{$now}', '{$nSum}', '{$payTransactionId}')
		";
		query($sql);
		//Увеличиваем баланс
		$sql = "UPDATE users SET upcount = '{$upcount}' WHERE id = {$userId}";
		file_put_contents($logFileName, "sql for up: '{$sql}'\n", FILE_APPEND);
		query($sql);
		$storedSumData['sum'] = $storedSumData['real_sum'];
		return $storedSumData;
	}
	/**
	 * @return StdClass {path:абсолютный путь к файлу, htmlPath:путь файлу для html, error:сообщение об ошибке}
	*/
	public static function savePhoto($file)
	{
		$r =  new StdClass();
		$r->path     = '';
		$r->htmlPath = '';
		$r->error    = '';
		if ($file) {
			$ext = utils_getExt($file['name']);
			$name = md5($file['name'] . now());
			$subdir = date('Y') . '/' . date('m');
			$dest = DR . '/images/' . $subdir . '/' . $name . $ext;
			move_uploaded_file($file['tmp_name'], $dest);
			$mime = utils_getImageMime($dest, $w, $h);
			if ($mime) {
				if($w >= $h) {
		        	$new_size_w = MAX_WIDTH;
		        	$h = $h * MAX_WIDTH/$w;
		        	$w = $new_size_w;
				}
				else{
					$new_size_h = MAX_HEIGHT;
		        	$w = $w * MAX_HEIGHT/$h;
		        	$h = $new_size_h;
				}
				switch ($mime) {
					case 'image/png':
						utils_pngResize($dest, $dest, $w, $h);
						break;
					case 'image/gif':
						utils_gifResize($dest, $dest, $w, $h);
						break;
					case 'image/jpeg':
						utils_jpgResize($dest, $dest, $w, $h, 100);
				}
			} else {
				@unlink($dest);
				//json_error('msg', 'Ошибка загрузки файла');
				$r->error = 'Ошибка загрузки файла';
				return $r;
			}
			if (a($_GET, 'ajaxUpload') == 1) {
				$r->path = $dest;
				$dest = str_replace(DR, '', $dest);
				$r->htmlPath = $dest;
				//die(trim($dest));
				return $r;
			}
			$dest = str_replace(DR, '', $dest);
			$r->htmlPath = $dest;
			//$this->imagePath = str_replace(DR, '', $dest);
		}
		return $r;
	}
	/**
	 * @description Отправка уведомления на email в случае оплаты поднятий
	 * @param float $nSum сумма фактически уплаченная пользователем, информация из нотайса
	*/
	public static function sendEmailAboutPayment(/*float*/ $nSum, array $aUserdata, $paysystemname, $sLog = 'postlog.txt')
	{
		file_put_contents($sLog, "call sendEmailAboutPayment\n", FILE_APPEND);
		file_put_contents($sLog, (print_r($aUserdata, 1) . "\n"), FILE_APPEND);
		file_put_contents($sLog, "nSum = {$nSum}\n", FILE_APPEND);
		if (!defined('SITE_NAME')) {
			file_put_contents($sLog, "!defined('SITE_NAME')\n", FILE_APPEND);
			include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
		}
		
		if ($aUserdata['email'] || $aUserdata['phone']) {
			$mailer = new SampleMail();
			$mailer->setSubject('На ' . SITE_NAME . ' поднято объявление');
			$mailer->setPlainText("ООО, ИП!
			На сайте " . SITE_NAME . "
			Пользователь {$aUserdata['email']} оплатил {$nSum} рублей через {$paysystemname}.
			Его телефон {$aUserdata['phone']}.
			Поднимись и пробей человеку чек.
			");
			file_put_contents($sLog, "before set addresses\n", FILE_APPEND);
			$mailer->setAddressFrom([SITE_EMAIL => SITE_EMAIL]);
			$mailer->setAddressTo([NOTICE_EMAIL => NOTICE_EMAIL]);
			file_put_contents($sLog, "before send\n", FILE_APPEND);
			$b = $mailer->send();
			$sb = ($b ? 'true' : 'false');
			file_put_contents($sLog, "sendEmailAboutPayment - mail sended with status {$sb}\n", FILE_APPEND);
		} else {
			file_put_contents($sLog, "sendEmailAboutPayment - no actuial data\n", FILE_APPEND);
			file_put_contents($sLog, (print_r($aUserdata, 1) . "\n"), FILE_APPEND);
		}
	}
	/**
	 * @description Считает сумму для вывода. Если определена pay_transaction.real_sum вернет её, иначе sum
	 * @param array $row результат запроса к operations из Operations::_getRows
	*/
	public static function calcOutSum(array $row)
	{
		$sum = ($row['real_sum'] ? $row['real_sum'] : '' );//фактически уплаченная сумма
		if (!$sum || !floatval($sum)) {
			$sum = ($row['sum'] ? $row['sum'] : '0' );//номинальная сумма
		}
		return $sum;
	}
	/**
	 * @description Если пользователь авторизован, вернет его баланс (upcount)
	*/
	public static function getAuthUserBalance() {
		if (static::$authUserBalance !== null) {
			return static::$authUserBalance;
		}
		static::$authUserBalance = 0;
		if ($uid = intval(sess('uid'))) {
			static::$authUserBalance = intval( dbvalue('SELECT upcount FROM users WHERE id = ' . $uid) );
		}
		return static::$authUserBalance;
	}
}
