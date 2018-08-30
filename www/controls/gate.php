<?php
require_once DR . "/lib/shared.php"; 
class CGateAdv {
	public $id;
	public $login;
	private $_errors = [];
	
	public function __construct() {
		if (req('pwd') != ADV_GATE_PWD) {
			echo 'Invalid password';
			exit;
		}
		/*print_r($_POST);
		die;*/
		if (req('bCheck')) {
			$this->_checkPhone();
		}
		if (req('bSend')) {
			$this->_saveAdv();
		}
	}
	
	private function saveAdv() {
		//get city id!!
		//check type and far away
		//check price
		//save data
		if ($this->_validate()) {
			$people = ireq('people');
			$box = ireq('box');
			$term = ireq('term');
			$far = ireq('far');
			$near = ireq('near');
			$piknik = ireq('piknik');
			//TODO закончить вставку
			query("INSERT INTO main 
			(`region`, `city`, `people`, `price`, `box`, `term`, `far`, `near`, `piknik`, `title`, `image`, `name`, `addtext`, `phone`, `is_moderate`, `codename`) VALUES 
			('{$this->regId}', 
					   '{$this->cityId}',
								{$people},
										{$this->price},
												{$box},
														{$term},
																{$far},
																		{$near},
																			{$piknik},
																				'{$this->title}'
																					'{$image}'
					   )");//TODO safe image
		} else {
			$this->_echoErrors();
			exit;
		}
		if (!$this->phone) {
			exit('Не заполнен телефон');
		}
	}
	
	private function _checkPhone() {
		$phone = Shared::preparePhone(req('iPhone'));
		$sql = 'SELECT * FROM main WHERE phone = \'' . $phone . '\'';
		$rows = query($sql);
		var_dump($_POST);
		var_dump($_FILES);
		if (count($rows)) {
			die('Существует объявление с таким телефоном');
		} else if ($phone){
			echo('<p>Телефон свободен</p>');
		}
		$isValid = $this->_validate();
		if ($phone && $isValid) {
			exit('Можно подавать');
		} else {
			if (!$phone) {
				echo('<p>Телефон не заполнен</p>');
			}
			$this->_echoErrors();
			die;
		}
	}
	
	private function _validate()
	{
		//validate region
		$sRegion = treq('iRegion');
		$this->regId = $regId = dbvalue("SELECT id FROM regions WHERE region_name = '{$sRegion}'");
		$cityId = 0;
		if ($regId) {
			$sCity = treq('iCity');
			$this->cityId = $cityId = dbvalue("SELECT id FROM cities WHERE city_name = '{$sCity}' AND region = {$regId}");
		}
		if (!$regId) {
			$this->_errors[] = 'Не определен регион'; 
		}
		if (!$cityId) {
			$this->_errors[] = 'Не определен город'; 
		}
		$this->phone = Shared::preparePhone(req('iPhone'));
		$isTypeDefined = ireq('term') || ireq('box') || ireq('people');
		$isDistanceDefined = ireq('far') || ireq('near') || ireq('piknik');
		$this->price = $price = freq('iPrice');
		$this->name = $name = treq('iName');
		$this->title = $title = ireq('iTitle');
		if (!$isTypeDefined) {
			$this->_errors[] = 'Не определен тип машины'; 
		}
		if (!$isDistanceDefined) {
			$this->_errors[] = 'Не определено расстояние'; 
		}
		if (!$price) {
			$this->_errors[] = 'Не указана стоимость'; 
		}
		if (!$name) {
			$this->_errors[] = 'Не указано имя'; 
		}
		return (count($this->_errors) == 0);
	}
	private function _echoErrors()
	{
		foreach ($this->_errors as $s) {
			echo '<p>' . $s . '</p>';
		}
		
	}
}

$rform = new CGateAdv();
