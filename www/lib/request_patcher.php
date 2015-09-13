<?php
require_once LIB_ROOT. '/SxGeo22_API/SxGeo.php';
require_once LIB_ROOT. '/geoip.php';

class CRequestPatcher {
	/** Идентификатор России в базе данных*/
	const RUSSIA_DB_ID = 3;
	
	/** Связь "мегаполисов" с регионом мегаполиса, например 1 - "регион" Москва, 43 - регион Московская область*/
	static private $bind = array( 1 => 43, 2 => 39, 3 => 25, 4 => 56, 5 => 60, 6 => 36,
								  7 => 45, 8 => 50, 9 => 54, 10 => 65, 17 => 76, 128 => 153,
								  129 => 154, 130 => 143, 131 => 155, 132 => 148,
								  133 => 150, 134 => 151, 136 => 164, 137 => 159,
								  138 => 161, 208 => 76
								);
  
	static public function move302() {
		$b = self::$bind;
		if ( a($b,  a($_GET, 'city')) && $b[ a($_GET, 'city') ] == a($_GET, 'region')) {
			$_GET['region'] = $_GET['city'];
			$_GET['city'] = 0;
			$data = array();
			foreach ($_GET as $k => $i) {
				$data[] = "$k=$i";
			}
			$tail = join('&', $data);
			//echo("/?$tail<br>");
			utils_302("/?$tail");
			exit;
		}
	}
	/**
	 * @desc
	 * **/
	static public function pathPost() {
		$b = self::$bind;
		if ( a($b,  a($_POST, 'city')) && $b[ a($_POST, 'city') ] == a($_POST, 'region')) {
			$_POST['region'] = $_POST['city'];
			$_POST['city'] = 0;
		}
	}
	/**
	 * @desc переправить человека на страницу его города / региона, если на ней есть объявления
	 * для безопасности редирект делается не чаще чем раз в час для одного ua+ip
	*/
	static public function moveToRegion() {
		if ($_SERVER['REQUEST_URI'] == '/') { //TODO  и не search bot
			CGeoIp::getInfo($sCity, $sCountryCode);
			if ($sCountryCode == 'RU' && $sCity) {
				if (self::_needGeoRedirect()) { //если этот ua+ip в течении последнего часа не перенаправлялся
					
					if (self::_countAdvertInCity($sCity, $regionName, $cityName) > 0) {
						if ($regionName == $cityName) {
							self::_setGeotimestamp();
							utils_302('/' . $cityName);
							exit;
						} else {
							self::_setGeotimestamp();
							utils_302("/$regionName/$cityName");
							exit;
						}
					} else if (self::_countAdvertInRegion($sCity, $regionName) > 0) {
						self::_setGeotimestamp();
						utils_302('/' . $regionName);
						exit;
					}
				}
			}
		}
	}
	/**
	 * @desc Удаляет из базы все записи старше часа. Ищет запись по хешу md5(ip+ua)
	 * @return bool true если запись не найдена
	*/
	static private function _needGeoRedirect() {
		//clear
		$time = date('Y-m-d H:i:s', strtotime(now()) - 3600);
		//die("t = $time");
		query('DELETE  FROM geoip WHERE _time > \'' . $time . '\'');
		
		//search
		$hash = self::_geoHash();
		$v = dbvalue("SELECT _time FROM geoip WHERE hash = '{$hash}'");
		if ($v) {
			return false;
		}
		return true;
	}
	/**
	 * @return хеш md5(ip+ua)
	*/
	static private function _geoHash() {
		return md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
	}
	/**
	 * @param string $sCity строка имя города, полученая из базы геоайпи
	 * @param string &$regionName будет записано транслитированное имя региона в случае успешного поиска
	 * @param string &$cityName будет записано транслитированное имя города в случае успешного поиска
	 * @return int количество объявлений в пункте, если удалось найти в базе населенный пункт sCity. Если их несколько, (например Кизляр в Дагестане и не только ) ), выбирается случайный из них
	*/
	static private function _countAdvertInCity($sCity, &$regionName, &$cityName) {
		$sCity = trim($sCity);
		if ($sCity) {
			$ru = self::RUSSIA_DB_ID; //Россия
			$rows = query("SELECT codename, region, id FROM cities WHERE country = {$ru} AND city_name = '{$sCity}'", $nR);//replace to country IN if....
			/*if (!$nR) { Это здесь не нужно! Потому что получится url moskva/moskva
				$rows = query("SELECT codename, id AS region, 0 AS id FROM regions WHERE country = {$ru} AND region_name = '{$sCity}'", $nR);//replace to country IN if....
			}*/
			if ($nR) {
				if ($nR > 1) {
					$row = $rows[ rand(0, $nR - 1) ];
				} else {
					$row = $rows[0];
				}
				$cityName = $row['codename'];
				$region_id = $row['region'];
				$city = $row['id'];
				$row = dbrow("SELECT codename FROM regions WHERE id = {$region_id}", $nR);
				if ($nR) {
					$regionName = $row['codename'];
					$count = dbvalue("SELECT COUNT(id) FROM main WHERE city = {$city}");
					return $count;
				}
			}
		}
		return 0;
	}
	/**
	 * @param string $sCity строка имя города, полученая из базы геопайпи
	 * @param string &$regionName будет записано транслитированное имя региона в случае успешного поиска
	 * @return int количество объявлений в  регионе России содержащий населенный пункт sCity. Если регионов несколько, (например Кизляр в Дагестане и не только ) ), выдается случайный из них
	*/
	static private function _countAdvertInRegion($sCity, &$regionName) {
		$sCity = trim($sCity);
		if ($sCity) {
			$ru = self::RUSSIA_DB_ID; //Россия
			$rows = query("SELECT codename, region, id FROM cities WHERE country = {$ru} AND city_name = '{$sCity}'", $nR);//replace to country IN if....
			$is_city = 1;
			if (!$nR) {//для тех, что есть в регионах, но их фактически нет в городах, например Москва
				$rows = query("SELECT codename, id AS region, 0 AS id FROM regions WHERE country = {$ru} AND region_name = '{$sCity}'", $nR);//replace to country IN if....
				$is_city = 0;
			}
			if ($nR) {
				if ($nR > 1) {
					$row = $rows[ rand(0, $nR - 1) ];
				} else {
					$row = $rows[0];
				}
				$regionName = $row['codename'];
				if ($is_city) {
					$regionName = dbvalue("SELECT codename FROM regions WHERE id = {$row['region']}");
				}
				$region_id = $row['region'];
				$cond = "region = {$region_id}";
				if (isset(self::$bind[$region_id])) {
					$mirror_region_id = self::$bind[$region_id];
					$cond = "region IN({$region_id}, {$mirror_region_id})";
				}
				$count = dbvalue("SELECT COUNT(id) FROM main WHERE {$cond}");
				return $count;
			}
		}
		return 0;
	}
	/**
	 * @desc Установить время последнего редиректа для данного ip + ua
	*/
	static private function _setGeotimestamp() {
		$now = date('Y-m-d H:i:s', strtotime(now()) - 2*3600);
		//die("n = $now");
		$hash = self::_geoHash();
		query("INSERT INTO geoip (_time, hash) VALUES('{$now}', '{$hash}')");
	}
}
