<?php
class RKParams {
	public function __construct() {
		// 1.
		// Оплата заданной суммы с выбором валюты на сайте мерчанта
		// Payment of the set sum with a choice of currency on merchant site 

		// регистрационная информация (логин, пароль #1)
		// registration info (login, password #1)
		$this-> mrh_login = $mrh_login = RK_ID;
		$mrh_pass1 = RK_P1;

		// номер заказа
		// number of order
		$this->inv_id = $inv_id = sess('payId', 0);

		// описание заказа
		// order description
		$this->inv_desc = $inv_desc = 'Оплата возможности поднять объявление на gazel.me';

		// сумма заказа
		// sum of order
		$this->out_summ = $out_summ = sess('paySum', 0);

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
		$data = compact('mrh_login', 'out_summ', 'inv_id', 'in_curr', 'inv_desc', 'crc', 'shp_item', 'culture', 'encoding');
		if (defined('RK_TEST_MODE')) {
			$data['isTest'] = 1;
		}
		json_ok_arr($data);
	}
}
//$rkDemo = new RKParams();
