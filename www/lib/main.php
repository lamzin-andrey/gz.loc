<?php
if ( @$_GET["PHPSESSID"] ) {
    @session_id( @$_GET["PHPSESSID"]);
}
@session_start();
$token = @$_SESSION["utoken"];
if (!$token) {
    $token = $_SESSION["utoken"] = md5( strtotime( date("Y-m-d H:i:s") ) );
}
if (count($_POST) && $_SERVER['REQUEST_URI'] != '/pcf' && $_SERVER['REQUEST_URI'] != '/yagate' && $_SERVER['REQUEST_URI'] != '/rksuccess' && $_SERVER['REQUEST_URI'] != '/rkresult' && $_SERVER['REQUEST_URI'] != '/rkfail'&& $_SERVER['REQUEST_URI'] != '/yproxycheck' ) {
	if ($token && ($token != @$_REQUEST["utk"] && $token != @$_REQUEST["token"])) {
		die("Неверный ключ");
	}
}
@date_default_timezone_set("Europe/Moscow");
require_once dirname(__FILE__)."/config.php";
require_once LIB_ROOT."/functions.php";

$javascript = utils_addScript("global", "var utoken='$token';");
?>
