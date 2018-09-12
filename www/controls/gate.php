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
			$this->shuffleAction();
			echo '<a href="/">Type here!</a>';
			exit;
		}
	}
	/**
	 * @description потому что мало ли где ещё буду использовать
	*/
	public function shuffleAction()
	{
		$N = rand(40, 50);
		//Пока количество менее N выбираем N последних объявлений, 
		//	отсортированных по убыванию id и возрастанию даты последнего поднятия, 
		// таких, чтобы user_id IS NULL
		$rows = query('SELECT main.id FROM main LEFT JOIN users ON main.phone = users.phone WHERE users.id IS NULL ORDER BY id DESC, date_update ASC LIMIT ' . $N, $cnt);
		//В выборке берем первую половину
		$rows = array_chunk($rows, floor($N/2))[0];
		//Перемешиваем её и поднимаем, при этом увеличиваем date_update
		$now = now();
		$a = [];
		$n = dbvalue('SELECT delta FROM main ORDER BY id DESC LIMIT 1') + 1;
		shuffle($rows);
		$N = rand(10, 20);
		for ($i = 0; $i < $N; $i++) {
			shuffle($rows);
		}
		for ($i = 0; $i < $cnt; $i++) {
			query('UPDATE main SET delta = ' . $n . ', date_update = \'' . $now . '\' WHERE id = ' . $rows[$i]['id']);
			$n++;
		}
	}
	private function _saveAdv() {
		if (req('pwd') != ADV_GATE_PWD) {
			echo 'Invalid password';
			exit;
		}
		if ($this->_validate()) {
			$people = ireq('people');
			$box = ireq('box');
			$term = ireq('term');
			$far = ireq('far');
			$near = ireq('near');
			$piknik = ireq('piknik');
			//TODO закончить вставку
			$image = $this->_saveImage($people, $box, $term);
			$codename = utils_translite_url(utils_cp1251($this->title));
			$id = query("INSERT INTO main 
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
																				'{$this->title}',
																					'{$image}'," . 
			//`name`, `addtext`, `phone`, `is_moderate`, `codename`
			"'{$this->name}', '{$this->body}', '{$this->phone}', 1, '{$codename}'
					   )");
			$max = dbvalue('SELECT MAX(delta) FROM main');
			$max++;
			query('UPDATE main SET delta = ' . $max . ' WHERE id = ' . $id);
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
		$this->body = $body = treq('iBody');
		$this->title = $title = treq('iTitle');
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
		if (!$body) {
			$this->_errors[] = 'Не указан текст объявления'; 
		}
		return (count($this->_errors) == 0);
	}
	private function _echoErrors()
	{
		foreach ($this->_errors as $s) {
			echo '<p>' . $s . '</p>';
		}
		
	}
	private function _saveImage($people, $box, $term)
	{
		$image = '/images/gazel.jpg';
		if (isset($_FILES['iPhoto'])) {
			$o = Shared::savePhoto($_FILES['iPhoto']);
			$image = $o->htmlPath ? $o->htmlPath : $image;
		} else {
			if ($people) {
				$image = '/images/gpasy.jpeg';
			}
			if ($term) {
				$image = '/images/trem.jpg';
			}
			if ($box) {
				$image = '/images/gazel.jpg';
			}
		}
		return $image;
	}
}

$rform = new CGateAdv();
