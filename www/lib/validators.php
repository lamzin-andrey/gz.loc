<?php
class Validators {
	static public function is_require($var, $label, &$errors, $message = '', $post = true) {
		$data = $_POST;
		if (!$post) {
			$data = $_GET;
		}
		if (trim(@$data[$var]) == '') {
			if (!$message) {
				$message = "Поле \"{$label}\" обязательно для заполнения";
			}
			$errors[$var] = $message;
		}
	}
}
