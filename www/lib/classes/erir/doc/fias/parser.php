<?php
// define('DR', '/opt/lampp/htdocs/gz.loc/www/');
// require_once __DIR__ . '/../../../../main.php';
require_once __DIR__ . '/../../../../../config.php';
require_once __DIR__ . '/../../../../classes/db/mysql.php';

function main() {
	$html = file_get_contents('fias.htm');
	$dom = new DOMDocument();
	$dom->validateOnParse = false;
	$dom->loadHtml('<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $html);
	$images = $dom->getElementsByTagName('img');
	
	for ($i = 0; $i < $images->length; $i++) {
		$src = trim(strval($images->item($i)->getAttribute('src')));
		$fiasId = str_replace('/images/', '', $src);
		$fiasId = str_replace('.png', '', $fiasId);
		$fiasId = trim($fiasId);
		$regionName = trim(strval($images->item($i)->getAttribute('alt')));
		$regionName = str_replace('герб', '', $regionName);
		$regionName = str_replace('Республика', '', $regionName);
		$regionName = trim($regionName);
		// echo "$regionName\n";
		$isRegionFound = false;
		$megapolicyName = getMegapolicyName($regionName, $isRegionFound);
		if ($isRegionFound) {
			writeSql($regionName, $megapolicyName, $fiasId);
		} else {
			echo "Not found region $regionName\n";
		}
	}
	
}

function writeSql($regionName, $megapolicyName, $fiasId)
{
	$tpl = "UPDATE regions SET fias_id = '{$fiasId}'
 WHERE region_name IN('{$regionName}'{x});";
	
	if ($megapolicyName) {
		$s = str_replace('{x}', ", '{$megapolicyName}'", $tpl);
	} else {
		$s = str_replace('{x}', '', $tpl);
	}
	
	file_put_contents('update.sql', $s . "\n", FILE_APPEND);
}

function getMegapolicyName($regionName, &$isRegionFound)
{
	$isRegionFound = false;
	$row = dbrow("SELECT id FROM regions WHERE region_name = '{$regionName}' LIMIT 1;", $nR);
	if ($nR) {
		$isRegionFound = true;
		$id = $row['id'];
		$row = dbrow("SELECT region_name FROM regions WHERE parent_id = '{$id}' LIMIT 1", $nR);
		if ($nR) {
			return $row['region_name'];
		}
	}
	
	return '';
}

main();

