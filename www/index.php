<?php
//$_SERVER['REMOTE_ADDR'] = '78.109.16.152';//TODO remove me!

//file_put_contents(__DIR__ . '/log.log', 'hello' . print_r($_POST, 1));


include $_SERVER["DOCUMENT_ROOT"] . "/config.php";
require_once DR . "/lib/main.php";
$handler = "404.php";
$inner = TPLS . "/404.tpl.php";
$title='Заказ Газели онлайн в любом городе России';
$h1 = 'Заказ ГАЗели в любом городе России';

$showCabBtn = $showAddAdvBtn = true;
$showExitBtn = (bool)@$_SESSION['uid'] || (@$_SESSION['role'] == 'root');
$showSetBtn =(bool)@$_SESSION['uid'];

include DR . "/lib/request_patcher.php";
include DR . "/router.php";
include DR . "/lib/view_helpers.php";

include DR . "/controls/{$handler}";
include TPLS . (isset($classHandler) && isset($classHandler->master) ? $classHandler->master : '/master.tpl.php');

