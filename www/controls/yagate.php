<?php
/**
 * Этот класс принимает запросы только с юзерскрипта
*/
class YaGate {
	public $master = '/crossmaster.tpl.php';
	public $js = '';
	public function __construct() {
		$method = isset($_POST['act']) ? $_POST['act'] : '';
		$this->js = "<script type=\"text/javascript\">
			window.location.href = window.location.href + '#{$method}';
		</script>";
	}
}
$classHandler = $p = new YaGate();

$javascript = isset($javascript) ? $javascript : '';
$javascript .= $p->js;
