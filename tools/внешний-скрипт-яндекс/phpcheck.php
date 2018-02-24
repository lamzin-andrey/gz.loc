<?php
file_put_contents(__DIR__ . '/log.log', print_r($_POST, 1), FILE_APPEND);
require_once __DIR__ . '/Request.php';
$r = new Request();
$r = $r->execute('http://gazel.me/yproxycheck', $_POST);
echo $r->responseText;
