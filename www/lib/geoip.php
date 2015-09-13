<?php
class CGeoIp {
	static public function getInfo(&$city, &$country) {
		$ip_addr = $_SERVER['REMOTE_ADDR'];
		$SxGeo = new SxGeo(dirname(__FILE__) . '/SxGeo22_API/SxGeoCity.dat');
		$city_obj = $SxGeo->get($ip_addr);
		if (is_array($city_obj)) {
			$city = utils_utf8($city_obj['city']['name_ru']);
			$country = $city_obj['country']['iso'];
		}
		if (!$country) {
			$SxGeo = new SxGeo(dirname(__FILE__) . '/SxGeo22_API/SxGeo.dat');
			$code = $SxGeo->get($ip_addr);
			if (trim($code)) {
				$country = $code;
			}
		}
	}
}
