<?php
require_once DR . "/controls/classes/cadd.php";

class CCabinetEdit extends CAdd {
	private $id = 0;
	private $safePhone;
	private $safeName;
	public  $javascript;
	public  $image;
	public function __construct() {
		CRequestPatcher::pathPost();
		$this->loadRecord();
		$this->readPost();
		$this->checkCaptcha();
		$this->uploadHandler();
		if (count($_POST) == 0) {
			return;
		}
		$this->validateOther($this->id);
		$this->update();
		$this->_exit();
	}
	/**
	 * @desc Загрузка данных
	 * */
	private function loadRecord() {
		$this->id = $id = (int)@$_GET["edit_id"];
		if (!$id) {
			utils_302("/cabinet?status=e1"); //wrong id
		}
		$this->safePhone = $phone = @$_SESSION['phone'];
		$data = query("SELECT * FROM main WHERE id = $id AND is_deleted != 1 AND phone = '$phone'", $nR);
		if (!$nR) {
			utils_302("/cabinet?status=e2"); //alien or deleted record
		}
		$row = $data[0];
		$this->title = $row["title"];
		$this->price = $row["price"];
		$this->box   = $row["box"];
		$this->far   = $row["far"];
		$this->near   = $row["near"];
		$this->piknik   = $row["piknik"];
		$this->people   = $row["people"];
		$this->term   = $row["term"];
		$this->addtext   = $row["addtext"];
		$this->safeEmail = a($row, "email");
		$this->name = $this->safeName  = $row["name"];
		$this->image  = $row["image"];
		$this->javascript = '	localStorage.setItem("region", "' . $row["region"] . '");
	localStorage.setItem("city", "' . $row["city"] . '");
	selectByValue("region", "' . $row["region"] . '");
';
	}
	/**
	 * @desc Загрузка данных
	 * */
	protected function readPost() {
		$this->phone = $this->safePhone;
		$this->name  = $this->safeName;
		$this->email = $this->safeEmail;
		
		$this->title = @$_POST["title"]? $_POST["title"] : $this->title;
		$this->price = @$_POST["price"]? $_POST["price"] : $this->price;
		$this->addtext = @$_POST["addtext"]? $_POST["addtext"] : $this->addtext;
	}
	/**
	 * @desc Обновление при отсутствии ошибок
	 * */
	protected function update() {
		if (count($this->errors)) {
			return;
		}
		$this->successMessage = "Изменения применены, объявление появится на сайте после проверки";
		$region = (int)@$_POST["region"];
		$city = (int)@$_POST["city"];
		$people = (int)@$_POST["people"];
		$box = (int)@$_POST["box"];
		$term = (int)@$_POST["term"];
		$far = (int)@$_POST["far"];
		$near = (int)@$_POST["near"];
		$piknik = (int)@$_POST["piknik"];
		$need_moderate = (int)isset($_POST["nm"]) ? (int)$_POST["nm"] : 0;
		$automoderate = $need_moderate == 1 ? 0 : 1;
		
		$price = doubleval( str_replace(',', '.', $_POST["price"]) );
		
		$title = $this->deinject(@$_POST["title"]);
		$codename = utils_translite_url(utils_cp1251($title));
		$addtext = $this->deinject(@$_POST["addtext"]);
		
		$name = $this->deinject(@$_POST["person"]);
		
		if ($need_moderate != 1) {
			$obj = new StdClass();
			$obj->addtext = $addtext;
			$obj = setAutoFlag($obj);
			if (!isset($obj->nm)) {
				$obj->addtext = $title;
				$obj = setAutoFlag($obj);
			}
			if (!isset($obj->nm)) {
				$obj->addtext = $name;
				$obj = setAutoFlag($obj);
			}
			$automoderate = isset($obj->nm) ? 0 : 1;
		}
		
		
		$image = "/images/gpasy.jpeg";
		if ($box) {
			$image = "/images/gazel.jpg";
		}else if ($term) {
			$image = "/images/term.jpeg";
		}
		if (utils_getImageMime(DR . @$_POST["ipath"])) {
			$image = @$_POST["ipath"];
		}else if (!@$_POST["xhr"] && $this->imagePath) {//нет ipath значит либо не было либо отправка простым постом
			$image = $this->imagePath;
		}
		$is_moderate = $this->is_moderate;
		
		$now = now();
		$update = "UPDATE main SET
			region = $region,
			city =  $city,
			people = $people,
			price = $price,
			box = $box,
			term = $term,
			far = $far,
			near = $near,
			piknik = $piknik,
			title = '$title',
			image = '$image',
			addtext = '$addtext',
			is_moderate = '$is_moderate',
			automoderate = {$automoderate},
			date_update = '{$now}',
			codename = '$codename'
		WHERE id = {$this->id} AND phone = {$this->phone}";
		
		query($update, $nR, $aR);
		if ($aR) {
			$this->success = 1;
		}
	}
}
