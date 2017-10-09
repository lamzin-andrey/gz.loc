<?php
class RKDemo {
	public function __construct() {
		// 1.
		// Оплата заданной суммы с выбором валюты на сайте мерчанта
		// Payment of the set sum with a choice of currency on merchant site 

		// регистрационная информация (логин, пароль #1)
		// registration info (login, password #1)
		$this-> mrh_login = $mrh_login = "gazelme";
		//$mrh_pass1 = 'PcNkVpiTD1d17KRl7b8J'; //no test
		$mrh_pass1 = 'iT6A9HgYYt8ZW3iaaV7P';
		//test pass 1 = iT6A9HgYYt8ZW3iaaV7P
		
		//pass 2 Vo0rz1Q115vegSLFuMOa
		//test pass 2 = Zb2bKzcUy284NPbCI0tr

		// номер заказа
		// number of order
		$this->inv_id = $inv_id = 0;

		// описание заказа
		// order description
		$this->inv_desc = $inv_desc = "ROBOKASSA Advanced User Guide";

		// сумма заказа
		// sum of order
		$this->out_summ = $out_summ = '540.00';

		// тип товара
		// code of goods
		$this->shp_item = $shp_item = 1;

		// предлагаемая валюта платежа
		// default payment e-currency
		$this->in_curr = $in_curr = "rur";

		// язык
		// language
		$this->culture = "ru";

		// кодировка
		// encoding
		$this->encoding = "utf-8";

		// формирование подписи
		// generate signature
		$this->crc = $crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item");
	}
}
$rkDemo = new RKDemo();
