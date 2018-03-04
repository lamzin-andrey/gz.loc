<?php
file_put_contents(__DIR__ . '/rklog.log', print_r($_POST, 1), FILE_APPEND);
require_once __DIR__ . '/Request.php';
require_once __DIR__ . '/pgetdomain.php';
$r = new Request();
$r = $r->execute($domain . '/rkresult', $_POST);
//$r = $r->execute('http://gazel.me/rkresult', $_POST);
echo $r->responseText;
