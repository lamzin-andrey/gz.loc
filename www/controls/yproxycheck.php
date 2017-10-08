<?php
/**
 * Этот класс принимает запросы только с юзерскрипта
*/
class YaProxyCheck {
	public function __construct() {
		$v = isset($_POST['tival']) ? $_POST['tival'] : '';
		file_put_contents(LIB_ROOT . '/classes/request/cache/tival', $v);
	}
}
$classHandler = $p = new YaProxyCheck();

