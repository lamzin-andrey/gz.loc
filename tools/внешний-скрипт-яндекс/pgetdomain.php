<?php
$label = isset($_POST['label']) ? $_POST['label'] : 0;
$domain = 'http://gazel.me';
if ($label) {
	$n = intval($label);
	$f = str_replace(strval($n), '', $label);
	if ($f == 'q') {
		$domain = 'http://test.gazel.me';
	}
}
