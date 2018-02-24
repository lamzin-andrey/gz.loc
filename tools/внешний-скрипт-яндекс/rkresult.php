<?php
file_put_contents(__DIR__ . '/rklog.log', print_r($_POST, 1), FILE_APPEND);
require_once __DIR__ . '/Request.php';
$r = new Request();
$r = $r->execute('http://test.gazel.me/rkresult', $_POST);
echo $r->responseText;
