<?php 
require_once DR . '/controls/classes/cupaction.php';
$upform = new CUpAction();
if (defined('PAY_ENABLED')) {
	$javascript = '<script type="text/javascript" src="/js/pay.js?' . ASSETS_VERSION . '"></script>
';
}
