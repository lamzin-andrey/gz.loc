<?php
require_once LIB_ROOT. '/SxGeo22_API/SxGeo.php';
require_once LIB_ROOT. '/geoip.php';

class CRequestPatcher {
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
							utils_302('/' . $cityName);
							exit;
						} else {
							utils_302("/$regionName/$cityName");
							exit;
						}
					} else if (self::_countAdvertInRegion($sCity, $regionName) > 0) {
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
		//TODO не забыть удалять если прошло после последнего удаления более часа
		//не забыть, что md5 можно вроде хранить  как число
		return false;
	}
	/**
	 * @param string $sCity строка имя города, полученая из базы геопайпи
	 * @param string &$regionName будет записано транслитированное имя региона в случае успешного поиска
	 * @param string &$cityName будет записано транслитированное имя города в случае успешного поиска
	 * @return bool true если удалось найти в базе населенный пункт sCity. Если их несколько, (например Кизляр в Дагестане и не только ) ), выдается случайный из них
	*/
	static private function _countAdvertInCity($sCity, &$regionName, &$cityName) {
		//TODO
		return false;
	}
	/**
	 * @param string $sCity строка имя города, полученая из базы геопайпи
	 * @param string &$regionName будет записано транслитированное имя региона в случае успешного поиска
	 * @return bool true если удалось найти в базе регион России содержащий населенный пункт sCity. Если регионов несколько, (например Кизляр в Дагестане и не только ) ), выдается случайный из них
	*/
	static private function _countAdvertInRegion($sCity, &$regionName) {
		//TODO
		return false;
	}
}
