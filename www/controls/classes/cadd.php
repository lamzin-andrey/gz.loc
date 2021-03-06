<?php
require_once DR . "/lib/shared.php";
require_once DR . "/lib/validators.php";
class CAdd {
	protected $cpError = 0;
	protected $imagePath;
	protected $is_moderate = 0;
	/**
	 * @var $checkPasswordState
	 * @see validateOther
	 * 0 - пароль был пуст
	 * 1 - пароль не пуст и его надо вставить
	 * 2 - пароль не пуст и его надо обновить
	 * 3 - пароль не пуст, но его не надо вставить
	 * 4 - пароль не пуст, и совпал
	 * */
	protected $checkPasswordState = 0;
	
	public  $errors = array();
	public  $warnings = [];
	public  $tSuccessMessageSms = 'Вам надо подтвердить номер вашего телефона. Сейчас вы будете перенаправлены на страницу подтверждения.';
	public  $tSuccessMessage = 'Ваше объявление добавлено и будет размещено на сайте после проверки.';
	public  $successMessage = 'Вам надо подтвердить номер вашего телефона. Сейчас вы будете перенаправлены на страницу подтверждения.';
	public  $success = 0;
	
	public $title;
	public $name;
	public $price;
	public $addtext;
	public $phone;
	public $email;
	public $isAuthVerifyUser;

	/**
	 * Если каптча для авторизованых на форме подачи объявления не должна показываться и пользователь авторизован, примиет true
	*/
	public $captchaForAuthIsOff = false;
	
	/**
	 * Если каптча для любых пользователей на форме подачи объявления не должна показываться, примиет true
	*/
	public $captchaForAllIsOff = false;
	
	public function __construct() {
		$this->_setCaptchaVars();
		CRequestPatcher::pathPost();
		$this->readPost();
		$this->checkCaptcha();
		$this->uploadHandler();
		if (count($_POST) == 0) {
			return;
		}
		$this->validateOther();
		$this->insert();
		$this->_exit();
	}
	/**
	 * @desc Считать переменные из пост в поля класса
	 * */
	protected function readPost() {
		$this->title = @$_POST["title"];
		$this->price = @$_POST["price"];
		$this->addtext = @$_POST["addtext"];
		$this->phone = @$_POST["phone"];
		if (!$this->phone) {
			$this->phone = @$_SESSION["phone"];
		}
		$this->email = @$_POST["email"];
		$this->name = @$_POST["person"];
		global $authorized;
		if ($authorized) {
			$_POST["person"] = $this->name = @$_SESSION['name'];
			$_POST["phone"] =$this->phone = @$_SESSION["viewphone"];
		} 
	}
	/**
	 * @desc Сохранить файл
	 * */
	protected function uploadHandler()
	{
		if ($this->cpError) {
			return;
		}
		$file =  a($_FILES, 'file');
		if (!$file) {
			$file =  a($_FILES, 'image');
		}
		if ($file) {
			$uploadInfo = Shared::savePhoto($file);
			if ($uploadInfo->error) {
				json_error('msg', $uploadInfo->error);
			}
			if (a($_GET, 'ajaxUpload') == 1) {
				$dest = $uploadInfo->htmlPath;
				echo (trim($dest));
				exit;
			}
			$this->imagePath = $uploadInfo->path;
		}
	}
	/**
	 * @desc Проверяем, введена ли вообще каптча
	 * */
	protected function checkCaptcha() {
		if (count($_POST) == 0 || count($_FILES)) {
			return;
		}
		if ($this->captchaForAllIsOff || $this->captchaForAuthIsOff) {
			return;
		}
		if (req('cp') != sess('ccode') ) {
			$this->errors['cp'] = 'Неверно введен текст с изображения';
			$this->cpError = 1;
		}
	}
	
	/**
	 * @desc Проверка всех остальных полей
	 * @param $advId = 0 передается не нулевой если режим редактирования объявления
	*/
	protected function validateOther($advId = 0) {
		if ($this->cpError) {
			return;
		}
		Validators::is_require("title", "Заголовок объявления", $this->errors);
		Validators::is_require("addtext", "Текст объявления", $this->errors);
		Validators::is_require("person", "Имя или название компании", $this->errors);
		Validators::is_require("phone", "Телефон", $this->errors);
		Validators::is_require('agreement', '', $this->errors, 'Необходимо согласиться с условиями использования сайта.');
		if (count($this->errors)) {
			return;
		}
		//far/near
		if (!intval(@$_POST["far"]) && !intval(@$_POST["near"]) && !intval(@$_POST["piknik"])) {
			$this->errors['distance'] = "Вы не указали расстояние на которое готовы поехать. Выберите один из вариантов из \"Межгород\", \"По городу\" или \"За город\"";
			return;
		}
		//type
		if (!intval(@$_POST["people"]) && !intval(@$_POST["box"]) && !intval(@$_POST["term"])) {
			$this->errors['autotype'] = "Вы не указали тип вашего автомобиля. Выберите один из вариантов из \"Пассажирская\", \"Грузовая\" или \"Термобудка\"";
			return;
		}
		//location
		if (!intval(@$_POST["city"]) && !intval(@$_POST["region"])) {
			$this->errors['city'] = "Выберите мегаполис или город";
			return;
		}
		//phone
		$phone = $this->preparePhone(@$_POST["phone"]);
		$len = strlen($phone);
		if ($len  < 8 || $len > 16) {
			$this->errors['phone'] = "В номере телефона должно быть от пяти до пятнадцати цифр";
			return;
		}
		//объявление уже подано и с момента его публикации прошло не более 30 суток
		//регион включить в условие не будем, так как найдутся люди, которые будут публиковать объявления по Москве а писать Кемерово
		$advUid = dbvalue("SELECT `id` FROM users WHERE phone = '{$phone}' AND is_deleted = 0 AND is_sms_verify = 1 LIMIT 1");
		$countAdvs = intval(dbvalue("SELECT COUNT(id) FROM main WHERE phone = '{$phone}'  LIMIT 3"));
		if ( ($advUid || $countAdvs > 2) && $advId == 0 && (sess('role') != 'root')) {
			$dateCreated = dbvalue("SELECT `created` FROM main WHERE phone = '{$phone}' AND is_deleted = 0 ORDER BY created DESC LIMIT 1");
			$dateCreated = strtotime($dateCreated);
			$advLifeTime = 30*24*3600;
			$timeLeft = time() - $dateCreated;
			if ($timeLeft < $advLifeTime) {
				$availableDate = date('d.m.Y H:i:s', (time() + ($advLifeTime - $timeLeft)));
				$this->errors['phone'] = "Вы уже подавали объявление о перевозках для этого номера телефона.<br>
				Если вы указывали пароль, вы можете авторизоваться по номеру телефона и паролю и отредактировать и поднять ваше объявление.<br>
				Если вы не помните пароль, но указывали при подаче объявления email, вы можете <a href=\"/remind\" target=\"_blank\">восстановить пароль</a><br>
				В противном случае вы сможете подать новое объявление с этого номера после {$availableDate} по московскому времени.
				";
				return;
			}
		}
		//password
		if (trim( @$_POST["pwd"] )) {
			$this->checkPasswordState = 1;
			$rawpass = substr( str_replace(' ', '', @$_POST["pwd"]), 0, 32);
			if ( strlen($rawpass) < 6 || strlen($rawpass) > 32 ) {
				$this->errors["pwd"] = "Длина пароля должна быть от шести до тридцати двух символов";
				return; 
			}
			$cmd = "SELECT id, rawpass, email FROM users WHERE phone = '$phone'";
			$data = query($cmd, $nR);
			if ($nR) {//если строка есть
				$row = $data[0];
				if (trim($row["rawpass"]) && $row["rawpass"] != trim(@$_POST["pwd"])) { //пароль не пуст и не совпадает
					$this->errors["pwd"] = "Для этого номера телефона уже задан пароль отличный от того, что вы ввели.<br>
Если вы хотите поднять, отредактировать, скрыть или удалить какое-то из раннее поданых объявлений, но не помните 
пароль, <a href='/remindpassword' target='_blank'>пройдите на страницу восстановления пароля</a>.<br>
Для публикации объявления сейчас вы также можете оставить поля пароль и email незаполнеными.";
					$this->checkPasswordState = 3;
					return;
				} elseif (trim($row["rawpass"]) && $row["rawpass"] == trim(@$_POST["pwd"])) {
					$this->checkPasswordState = 4;
				} elseif( !trim($row["rawpass"]) ) {
					$this->checkPasswordState = 2;
				}
			} else {
				$this->checkPasswordState = 1;
			}
		}
		//email
		if (trim( @$_POST["email"] )) {
			if ( !checkMail($_POST["email"]) ) {
				$this->errors["email"] = "Такого email не бывает";
				return; 
			}
			$m = $_POST["email"];
			$cmd = "SELECT phone, email FROM users WHERE email = '$m'";
			$data = query($cmd, $nR);
			$row = @$data[0];
			if ($nR && @$row["phone"] != $phone) {
				$this->errors["email"] = "Такой email уже используется";
				return;
			}
		}
	}
	
	private function preparePhone($phone) {
		return Shared::preparePhone($phone);
	} 
	
	protected function sendPwd($row, $phone) {
		//TODO sendMail
		$mail = new SampleMail();
		$mail->setAddressFrom(array(SITE_EMAIL));
		$mail->setAddressTo(array($row['email']));
		$mail->setSubject("Восстановлене пароля на сайте gazel.me");
		$mail->setPlainText("Здравствуйте!
Ваш пароль на сайте gazel.me для номера $phone {$row['rawpass']}. 
Не забывайте его больше!");
		return $mail->send();
	}
	
	/**
	 * @desc Вставка при отсутствии ошибок
	 * */
	protected function insert() {
		if (count($this->errors)) {
			return;
		}
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
		
		$phone = $this->preparePhone($_POST["phone"]);
		$price = doubleval( str_replace(',', '.', $_POST["price"]) );
		
		$title = $this->deinject(@$_POST["title"]);
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
		
		$rawpass = $pwd = '';
		$email = @$_POST["email"];
		if ( trim(@$_POST["pwd"]) ) {
			$rawpass = substr( str_replace(' ', '', @$_POST["pwd"]), 0, 32);
			$pwd = md5($rawpass);
		}
		
		$image = "/images/gpasy.jpeg";
		if ($box) {
			$image = "/images/gazel.jpg";
		}else if ($term) {
			$image = "/images/term.jpg";
		}
		if (utils_getImageMime(DR . @$_POST["ipath"])) {
			$image = @$_POST["ipath"];
		}else if (!@$_POST["xhr"] && $this->imagePath) {//нет ipath значит либо не было либо отправка простым постом
			$image = $this->imagePath;
		}
		
		$select = "SELECT id FROM main WHERE phone = $phone AND title = '$title' AND addtext = '$addtext' AND is_deleted != 1";
		if (dbvalue($select)) {
			$this->errors[] = "Вы уже публиковали это объявление. <br>Вы можете войти в личный кабинет и поднять его. <br>Как логин используйте свой номер телефона, пароль будет отправлен вам на email указанный при подаче объявления.<br>Если вы не помните email используйте ссылку Восстановление пароля.";
			return;
		}
		$is_moderate = $this->is_moderate;
		$codename = utils_translite_url(utils_cp1251($title));
		$is_deleted = 1;
		
		if (sess('role') == 'root') {
			$is_deleted = 0;
		}
		
		$isVerify = 0;
		if (intval( sess('uid') ) > 0) {
			$uid = intval( sess('uid') );
			$isVerify = dbvalue("SELECT is_sms_verify FROM users WHERE id = {$uid}");
		}
		$this->isAuthVerifyUser = $isAuthVerifyUser = ( intval( sess('uid') ) > 0 &&  $isVerify == 1);
		
		if ($isAuthVerifyUser) {
			$is_deleted = 0;
			$this->successMessage = $this->tSuccessMessage;
		} else {
			$this->successMessage = $this->tSuccessMessageSms;
		}
		
		$insert = "INSERT INTO main (region, city, people, price, box, term, far, near, piknik, title, image, name, 
		                       addtext, phone, is_moderate, codename, automoderate, is_deleted) 
		VALUES ($region, $city, $people, $price, $box, $term, $far, $near, $piknik, '$title', '$image', '$name', '$addtext',
			'$phone', $is_moderate, '$codename', {$automoderate}, {$is_deleted})";
		//die($insert);
		$id = query($insert);
		if ($id) {
			$d = $this->_getDelta($phone, $id);
			$now = now();
			query("UPDATE main SET delta = $d, date_update = '{$now}' WHERE id = $id");
			
			$update = "phone = '$phone'";
			if ($this->checkPasswordState == 0) {
				$this->success = 1;
				if (!$isAuthVerifyUser) {
					$this->_goSmsVerify($id, $phone);
				}
				return;
			}
			if ($this->checkPasswordState == 1 || $this->checkPasswordState == 2) {
				$update = "rawpass = '$rawpass', pwd = '$pwd'";
			}
			$cmd  = "INSERT INTO users (phone, pwd, rawpass, email) VALUES ( '$phone', '$pwd', '$rawpass', '$email') ON DUPLICATE KEY UPDATE $update";
			$uid = query($cmd);
			
			$d = dbvalue("SELECT max(delta) FROM users");
			$d += 1;
			query("UPDATE users SET delta = {$d} WHERE id = {$uid}");
			
			$this->success = 1;
			if (!$isAuthVerifyUser) {
				$this->_goSmsVerify($id, $phone);
			}
		}
	}
	/**
	 * @desc Возвращаем сообщения об ошибках или статус ок
	 * */
	protected function _exit() {
		if (count($this->errors)) {
			if (@$_POST["xhr"]) {
				$this->errors["success"] = "0";
				print json_encode($this->errors);
				exit;
			}
		}
		if (@$_POST["xhr"]) {
			$data = [
				'success' => 1,
				'msg' => $this->successMessage,
				'wrns' => $this->warnings,
				'm' => ($this->isAuthVerifyUser ? 1 : 0)
			];
			print json_encode($data);
			exit;
		}
		/*echo "<pre>";
		print_r($this->errors);
		echo "</pre>";
		die (__FILE__ . ", " . __LINE__); /**/
	}
	/**
	 * @desc Удаляем xss sql
	 * */
	protected function deinject($s) {
		return Shared::deinject($s);
	}
	
	protected function _goSmsVerify($id, $phone) {
		@session_start();
		sess('verified_adv_id', $id);
		sess('verified_adv_phone', $phone);
		sess('add_adv_flag', true);
		sess('up_adv_flag', 'unset');
	}
	
	/**
	 * @description Если для данного номера телефона существует любое объявление с момента created которог прошло не более месяца, delta будет скопирована с него
	 * @param String phone телефон пользователя
	 * @param int идентификатор вставленного объявления
	 * @return новое значение delta для таблицы main 
	*/
	protected function _getDelta($phone, $advId) {
		$row = dbrow("SELECT created, delta FROM main WHERE phone = '{$phone}' AND id != {$advId} ORDER BY created DESC LIMIT 1", $n);
		if ($n) {
			$time = nowtime();
			$lastTime = strtotime($row['created']);
			if ($time - $lastTime <= MONTH_IN_SEC) {
				$this->warnings[] = 'С момента публикации вами последнего объявления прошло менее месяца. Ваше новое объявление не будет поднято вверх, оно займет ту же позицию в результатах поиска, которую могло бы занимать старое.';
				return intval($row['delta']);
			}
		} 
		$d = intval(dbvalue('SELECT max(delta) FROM main'));
		$d += 1;
		return $d;
	}
	/**
	 * @description Устанавливает поля класса связанные с каптчей на форме ввода
	*/
	protected function _setCaptchaVars()
	{
		if (defined('CAPTCHA_ADV_AUTH_OFF') && CAPTCHA_ADV_AUTH_OFF == true && intval( sess('uid') ) > 0) { 
			$this->captchaForAuthIsOff = true;
		}
		if (defined('CAPTCHA_ADV_AL_OFF') && CAPTCHA_ADV_AL_OFF == true) { 
			$this->captchaForAllIsOff = true;
		}
	}
}
