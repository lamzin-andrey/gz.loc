<?php
file_put_contents(__DIR__ . '/log.log', print_r($_POST, 1), FILE_APPEND);

require_once __DIR__ . '/Request.php';
require_once __DIR__ . '/pgetdomain.php';

$r = new Request();
//'http://gazel.me/pcf'
$r = $r->execute($domain . '/pcf', $_POST);
//print_r($r);
echo $r->responseText;
