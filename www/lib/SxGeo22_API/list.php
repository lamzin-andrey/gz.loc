<?php
require_once __DIR__ . '/SxGeo.php';

class CGeoIp {
	/**
	 * @param string &$city    Имя города
	 * @param string &$country Код страны
	*/
	static public function getInfo(&$city, &$country) {
		$ip_addr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
		$SxGeo = new SxGeo(__DIR__ . '/SxGeoCity.dat');
		$city_obj = $SxGeo->get($ip_addr);
		if (is_array($city_obj)) {
			$city = mb_convert_encoding($city_obj['city']['name_ru'], 'UTF-8', 'Windows-1251');
			$country = $city_obj['country']['iso'];
		}
		if (!$country) {
			$SxGeo = new SxGeo(dirname(__FILE__) . '/SxGeo.dat');
			$code = $SxGeo->get($ip_addr);
			if (trim($code)) {
				$country = $code;
			}
		}
	}
}

function main() {
	$a = 164;
	$b = 98;
	$c = 0;
	$d = 0;
	$map = [];
	
	while (true) {
		if ($a == 255 && $b == 255 && $c == 255 && $d == 255) {
			break;
		}
		$ip = strval($a) . '.' . strval($b) . '.' . strval($c) . '.' . strval($d);
		$_SERVER['REMOTE_ADDR'] = $ip;
		CGeoIp::getInfo($city, $co);
		if ($city && !isset($map[$city.$co])) {
			file_put_contents(__DIR__ . '/cities.list', "'{$ip}', '{$city}', '{$co}'\n", FILE_APPEND);
			$map[$city.$co] = 1;
		}
		
		$d++;
		if ($d > 255) {
			$d = 0;
			$c++;
			if ($c > 255) {
				$c = 0;
				$b++;
				if ($b > 255) {
					$b = 0;
					$a++;
				}
			}
		}
		if ($c == 0 && $d == 0) {
			echo "{$ip}\n";
		}
	}
}

main();
