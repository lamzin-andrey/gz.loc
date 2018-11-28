<?php

/**
 * Конвертит win1251 utf8 если строка в windows-1251
 * */
function utils_utf8($s) {
	return mb_convert_encoding($s, "UTF-8", "WINDOWS-1251");
	return $s;
}

/**/
function checkMail($mail)	 {
	 $reg = "#^[\w\.]+[^\.]@[\w]+\.[\w]{2,4}#";	 
	 $n = preg_match($reg, $mail, $m);
	 return $n;
 }
/**
 * выдает в поток данные в json формате
 * четные аргументы - ключи, нечетные - значения
 * в данных всегда присутствует status => ok 
 * */
function json_ok() {
 $sz = func_num_args();
 $data['status'] = "ok";
 if ((int)@$_POST['reqi'] > 0) {
 	$data["reqi"]= $_POST['reqi'];
 }
 if ((int)@$_POST['dbfrts'] > 0) {
 	$data["dbfrts"]= $_POST['dbfrts'];
 }
 //"reqi", $_POST['reqi']
 for ($i = 0; $i < $sz; $i++) {
 	if ($i + 1 < $sz) {
 		$data[func_get_arg($i)] = func_get_arg($i + 1);
 		$i++;
 	}
 }mysql_close();
 die(json_encode($data));
}
/**
 * выдает в поток данные в json формате
 * четные аргументы - ключи, нечетные - значения
 * в данных всегда присутствует status => error 
 * */
function json_error() {
	$sz = func_num_args();
	$data['status'] = "error";
	if ((int)@$_POST['dbfrts'] > 0) {
		$data["dbfrts"]= $_POST['dbfrts'];
	}
 	for ($i = 0; $i < $sz; $i++) {
 		if ($i + 1 < $sz) {
 			$data[func_get_arg($i)] = func_get_arg($i + 1);
 			$i++;
 		}
 	}mysql_close();
	die(json_encode($data));
}
/**
 * Добавляет в массив элемент 'status' => 'ok' и выдает в поток данные в json формате
*/
function json_ok_arr($data) {
	$data['status'] = 'ok';
	die(json_encode($data));
}
/**
 * Добавляет в массив элемент 'status' => 'ok' и выдает в поток данные в json формате
*/
function json_error_arr($data) {
	$data['status'] = 'error';
	die(json_encode($data));
}

/**
* @desc Конвертирует русские буквы в транслит
*/

function utils_translite ($string)  {
	$string = @ereg_replace("ё","e",$string);
	$string = @ereg_replace("й","i",$string);
	$string = @ereg_replace("ю","u",$string);
	$string = @ereg_replace("ь","'",$string);
	$string = @ereg_replace("ч","ch",$string);
	$string = @ereg_replace("щ","sh",$string);
	$string = @ereg_replace("ц","c",$string);
	$string = @ereg_replace("у","y",$string);
	$string = @ereg_replace("к","k",$string);
	$string = @ereg_replace("е","e",$string);
	$string = @ereg_replace("н","n",$string);
	$string = @ereg_replace("г","g",$string);
	$string = @ereg_replace("ш","sh",$string);
	$string = @ereg_replace("з","z",$string);
	$string = @ereg_replace("х","h",$string);
	$string = @ereg_replace("ъ","'",$string);
	$string = @ereg_replace("ф","f",$string);
	$string = @ereg_replace("ы","w",$string);
	$string = @ereg_replace("в","v",$string);
	$string = @ereg_replace("а","a",$string);
	$string = @ereg_replace("п","p",$string);
	$string = @ereg_replace("р","r",$string);
	$string = @ereg_replace("о","o",$string);
	$string = @ereg_replace("л","l",$string);
	$string = @ereg_replace("д","d",$string);
	$string = @ereg_replace("ж","j",$string);
	$string = @ereg_replace("э","е",$string);
	$string = @ereg_replace("я","ya",$string);
	$string = @ereg_replace("с","s",$string);
	$string = @ereg_replace("м","m",$string);
	$string = @ereg_replace("и","i",$string);
	$string = @ereg_replace("т","t",$string);
	$string = @ereg_replace("б","b",$string);
	$string = @ereg_replace("Ё","E",$string);
	$string = @ereg_replace("Й","I",$string);
	$string = @ereg_replace("Ю","U",$string);
	$string = @ereg_replace("Ч","CH",$string);
	$string = @ereg_replace("Ь","'",$string);
	$string = @ereg_replace("Щ","SH",$string);
	$string = @ereg_replace("Ц","C",$string);
	$string = @ereg_replace("У","Y",$string);
	$string = @ereg_replace("К","K",$string);
	$string = @ereg_replace("Е","E",$string);
	$string = @ereg_replace("Н","N",$string);
	$string = @ereg_replace("Г","G",$string);
	$string = @ereg_replace("Ш","SH",$string);
	$string = @ereg_replace("З","Z",$string);
	$string = @ereg_replace("Х","H",$string);
	$string = @ereg_replace("Ъ","'",$string);
	$string = @ereg_replace("Ф","F",$string);
	$string = @ereg_replace("Ы","W",$string);
	$string = @ereg_replace("В","V",$string);
	$string = @ereg_replace("А","A",$string);
	$string = @ereg_replace("П","P",$string);
	$string = @ereg_replace("Р","R",$string);
	$string = @ereg_replace("О","O",$string);
	$string = @ereg_replace("Л","L",$string);
	$string = @ereg_replace("Д","D",$string);
	$string = @ereg_replace("Ж","J",$string);
	$string = @ereg_replace("Э","E",$string);
	$string = @ereg_replace("Я","YA",$string);
	$string = @ereg_replace("С","S",$string);
	$string = @ereg_replace("М","M",$string);
	$string = @ereg_replace("И","I",$string);
	$string = @ereg_replace("Т","T",$string);
	$string = @ereg_replace("Б","B",$string);
	return $string;
}
 /**
 * @descr 
 * @param
 * @param
 * @return
 **/
 function utils_cp1251($s) {
 	return mb_convert_encoding($s, "WINDOWS-1251", "UTF-8");
 }
 /**
 * @desc 
 * @param
 * @param
 * @return
 **/
 function utils_money($v) {
 	$v = str_replace('.', ',', $v);
 	$a = explode(',', $v);
 	$s = $a[0];
 	$q = array();
 	for ($i = strlen($s) - 1, $j = 1; $i > -1; $i--, $j++) {
 		$q[] = $s[$i];
 		if ($j % 3 == 0) $q[] = ' ';
 	}
 	$a[0] = join("", array_reverse($q));
 	if (@$a[1] == '00') return $a[0] . utils_utf8(' Руб.');
 	$v = join(",", $a);
 	return $v . utils_utf8(' Руб.');
 }
 
function now() {
    $d = date("Y-m-d H:i:s");
    return date("Y-m-d H:i:s", strtotime($d) + SUMMER_TIME);
}
/**
 * @desc Функция ресайза png c сохранением прозрачности
 * @param string $srcFilename   - путь к файлу изображения в формате png
 * @param string $destFilename  - путь к файлу изображения в формате png
 * @param int   $destW - требуемая ширина изображения
 * @param int   $destH - требуемая высота изображения
 * @param array $defaultTransparentColor [0,0,0] - это значение цвета будет использоваться как прозрачное, если прозрачный цвет не удасться определить из исходного изображения 
 * */
function utils_pngResize($srcFilename, $destFilename, $destW, $destH, $compression = 9, $defaultTransparentColor = array(0, 0, 0)) {
	if (!$img = @imagecreatefrompng($srcFilename)) {
		throw new Exception('Ошибка формата изображения');
	}
	$sz = getImageSize($srcFilename);
	$srcW = $sz[0];
	$srcH = $sz[1];
	$output = imagecreatetruecolor($destW, $destH);
    imagealphablending($output, false); //чтобы не было непрозрачной границы по контуру
    imagesavealpha($output, true);
    $transparencyIndex = imagecolortransparent($img);
    if ($transparencyIndex >= 0) {
        $transparencyColor = imagecolorsforindex($img, $transparencyIndex);
    }
    $transparenctColor = imagecolorallocate($output, $defaultTransparentColor[0], $defaultTransparentColor[1], $defaultTransparentColor[2]);
    imagecolortransparent($output, $transparencyIndex);
    imagefill($output, 0, 0, $transparencyIndex);
    imagecopyresampled($output, $img, 0, 0, 0, 0, $destW, $destH, $srcW, $srcH);
	if (!@imagepng($output, $destFilename, $compression)) {
    	throw new Exception('Ошибка сохранения изображения');
	}
}
/**
 * @desc Функция ресайза png c сохранением прозрачности
 * @param string $srcFilename   - путь к файлу изображения в формате png
 * @param string $destFilename  - путь к файлу изображения в формате png
 * @param int   $destW - требуемая ширина изображения
 * @param int   $destH - требуемая высота изображения
 * @param array $defaultTransparentColor [0,0,0] - это значение цвета будет использоваться как прозрачное, если прозрачный цвет не удасться определить из исходного изображения 
 * */
function utils_gifResize($srcFilename, $destFilename, $destW, $destH, $defaultTransparentColor = array(0, 0, 0)) {
	if (!$img = @imagecreatefromgif($srcFilename)) {
		throw new Exception('Ошибка формата изображения');
	}
	$sz = getImageSize($srcFilename);
	$srcW = $sz[0];
	$srcH = $sz[1];
	$output = imagecreatetruecolor($destW, $destH);
    //imagealphablending($output, false); //чтобы не было непрозрачной границы по контуру
    //imagesavealpha($output, true);
    $transparencyIndex = imagecolortransparent($img);
    if ($transparencyIndex !== -1) {
        $transparencyColor = imagecolorsforindex($img, $transparencyIndex);
    }
    $transparenctColor = imagecolorallocate($output, $defaultTransparentColor[0], $defaultTransparentColor[1], $defaultTransparentColor[2]);
    imagecolortransparent($output, $transparencyIndex);
    imagefill($output, 0, 0, $transparencyIndex);
    imagecopyresampled($output, $img, 0, 0, 0, 0, $destW, $destH, $srcW, $srcH);
	if (!@imagegif($output, $destFilename)) {
    	throw new Exception('Ошибка сохранения изображения');
	}
}

function utils_jpgResize($srcFilename, $destFilename, $destW, $destH, $quality = 80) {
	if (!$img = @imagecreatefromjpeg($srcFilename)) {
		throw new Exception('Ошибка формата изображения');
	}
	$sz = getImageSize($srcFilename);
	$srcW = $sz[0];
	$srcH = $sz[1];
	$output = imagecreatetruecolor($destW, $destH);
    imagecopyresampled($output, $img, 0, 0, 0, 0, $destW, $destH, $srcW, $srcH);
	if (!@imagejpeg($output, $destFilename, $quality)) {
    	throw new Exception('Ошибка сохранения изображения');
	}
}

function utils_404($template = null, $masterTemplate = null) {
	header("HTTP/1.1 404 Not Found");
	if ($template && !$masterTemplate) {
		if (file_exists($template)) {
			include_once $template;
		}
	} elseif($masterTemplate && $template){
		if (file_exists($template) && file_exists($masterTemplate)) {
			$content = $template;
			include_once $masterTemplate;
		}
	}elseif($masterTemplate){
		if (file_exists($masterTemplate)) {
			include_once $masterTemplate;
		}
	}
	
	exit;
}

function utils_302($location = "/") {
	header("location: $location");
	exit;
}

function utils_getExt($filename){
	if (strpos($filename, '.') === false) {
		return '';
	}
	$a = explode(".", $filename);
	$s = $a[ count($a) - 1 ];
	return $s;
}
function utils_getImageMime($path, &$w = null, &$h = null) {
	$sz = @getImageSize($path);
	if (is_array($sz) && count($sz)) {
		$w = $sz[0];
		$h = $sz[1];
		return $sz["mime"];
	}
}

function utils_translite_url ($string)  {
	$string = @ereg_replace("ё","e",$string);
	$string = @ereg_replace("й","i",$string);
	$string = @ereg_replace("ю","yu",$string);
	$string = @ereg_replace("ь","",$string);
	$string = @ereg_replace("ч","ch",$string);
	$string = @ereg_replace("щ","sh",$string);
	$string = @ereg_replace("ц","c",$string);
	$string = @ereg_replace("у","u",$string);
	$string = @ereg_replace("к","k",$string);
	$string = @ereg_replace("е","e",$string);
	$string = @ereg_replace("н","n",$string);
	$string = @ereg_replace("г","g",$string);
	$string = @ereg_replace("ш","sh",$string);
	$string = @ereg_replace("з","z",$string);
	$string = @ereg_replace("х","h",$string);
	$string = @ereg_replace("ъ","",$string);
	$string = @ereg_replace("ф","f",$string);
	$string = @ereg_replace("ы","i",$string);
	$string = @ereg_replace("в","v",$string);
	$string = @ereg_replace("а","a",$string);
	$string = @ereg_replace("п","p",$string);
	$string = @ereg_replace("р","r",$string);
	$string = @ereg_replace("о","o",$string);
	$string = @ereg_replace("л","l",$string);
	$string = @ereg_replace("д","d",$string);
	$string = @ereg_replace("ж","j",$string);
	$string = @ereg_replace("э","е",$string);
	$string = @ereg_replace("я","ya",$string);
	$string = @ereg_replace("с","s",$string);
	$string = @ereg_replace("м","m",$string);
	$string = @ereg_replace("и","i",$string);
	$string = @ereg_replace("т","t",$string);
	$string = @ereg_replace("б","b",$string);
	$string = @ereg_replace("Ё","E",$string);
	$string = @ereg_replace("Й","I",$string);
	$string = @ereg_replace("Ю","YU",$string);
	$string = @ereg_replace("Ч","CH",$string);
	$string = @ereg_replace("Ь","",$string);
	$string = @ereg_replace("Щ","SH",$string);
	$string = @ereg_replace("Ц","C",$string);
	$string = @ereg_replace("У","U",$string);
	$string = @ereg_replace("К","K",$string);
	$string = @ereg_replace("Е","E",$string);
	$string = @ereg_replace("Н","N",$string);
	$string = @ereg_replace("Г","G",$string);
	$string = @ereg_replace("Ш","SH",$string);
	$string = @ereg_replace("З","Z",$string);
	$string = @ereg_replace("Х","H",$string);
	$string = @ereg_replace("Ъ","",$string);
	$string = @ereg_replace("Ф","F",$string);
	$string = @ereg_replace("Ы","I",$string);
	$string = @ereg_replace("В","V",$string);
	$string = @ereg_replace("А","A",$string);
	$string = @ereg_replace("П","P",$string);
	$string = @ereg_replace("Р","R",$string);
	$string = @ereg_replace("О","O",$string);
	$string = @ereg_replace("Л","L",$string);
	$string = @ereg_replace("Д","D",$string);
	$string = @ereg_replace("Ж","J",$string);
	$string = @ereg_replace("Э","E",$string);
	$string = @ereg_replace("Я","YA",$string);
	$string = @ereg_replace("С","S",$string);
	$string = @ereg_replace("М","M",$string);
	$string = @ereg_replace("И","I",$string);
	$string = @ereg_replace("Т","T",$string);
	$string = @ereg_replace("Б","B",$string);
	$string = str_replace(" ","_",$string);
	$string = str_replace('"',"",$string);
	$string = str_replace('.',"",$string);
	$string = str_replace("'","",$string);
	$string = str_replace(",","",$string);
	$string = str_replace('\\', "", $string);
	$string = str_replace('?', "", $string);
	
	return strtolower($string);
}


function utils_addScript($script, $code = '', $enc = '') {
	if ($script == "global" && strlen($code)) {
		$GLOBALS["javascriptglobal"][] = $code;
        return '';
	}
	if (strpos($script, "/") !== 0) {
	    $script = DBFR_HROOT . "/$script";
	}
	if ($enc) {
		$enc = 'charset="'.$enc.'"';
	}
    $s = '<script type="text/javascript" src="'.$script.'" '.$enc.'></script>'."\n";
    return $s;
}

function utils_javascript() {
	$s = '<script type="text/javascript">'.join("\n", @$GLOBALS["javascriptglobal"]).'</script>'."\n";
	$s .= @$GLOBALS["javascript"];
	return  $s;
}

function a($v, $k) {
	if ( (is_array($v) || is_string($v) ) && isset($v[$k])) {
		return $v[$k];
	}
	return null;
}
function o($v, $k) {
	if (is_object($v) && isset($v->$k)) {
		return $v->$k;
	}
	return null;
}
/**
 * @description Проверяет, нет ли в тексте номера телефона
 * @param {StdClass} data
 * @return {StdClass}
*/	
function setAutoFlag($data) {
	$s = mb_strtolower(strval($data->addtext), 'UTF-8' );
	$safe;
	$a = preg_split("/\s+/", $s);
	$j = 0;
	$prevIsNumber = 0;
	$mx = 0;
	$L = count($a);
	for ($i = 0; $i < $L; $i++) {
		$safe = $a[$i];
		if (strpos($safe, 'http') !== false) {
			$data->nm = 1;
			break;
		}
		if (strpos($safe, 'www') !== false) {
			$data->nm = 1;
			break;
		}
		if (strpos($safe, '.ru') !== false) {
			$data->nm = 1;
			break;
		}
		if (strpos($safe, '.com') !== false) {
			$data->nm = 1;
			break;
		}
		$s = trim(preg_replace("/\D/mis", '', $a[$i]));
		if (!$s || $safe == '-' || $safe == 'x' || $safe == '(' || $safe == ')') {
			if ($safe && $safe != '-' && $safe != 'x' && $safe != '(' && $safe != ')') {
				$prevIsNumber = 0;
				$mx = $mx > $j ? $mx : $j;
				$j = 0;
			}
			continue;
		}
		$M = strlen($s);
		if ($M > 4) {
			$data->nm = 1;
			break;
		} else if ($M > 0) {
			$prevIsNumber = 1;
			$j++;
		}
	}
	if ($mx > 2 || $j > 2) {
		$data->nm = 1;
	}
	return $data;
}
/**
 * @desc Работа с сессией
 * **/
function sess($key, $value = null, $default_value = null) {
	if ($value !== null && $value !== 'unset') {
		$_SESSION[$key] = $value;
	}
	if ($value === 'unset') {
		unset( $_SESSION[$key] );
	}
	if (!a($_SESSION, $key) && $default_value) {
		return $default_value;
	}
	return a($_SESSION, $key);
}
/**
 * @desc получить переменную из request
**/
function req($v, $varname = 'REQUEST') {
	$data = $_REQUEST;
	switch ($varname) {
		case 'POST':
		$data = $_POST;
			break;
		case 'GET':
			$data = $_GET;
			break;
	}
	if (isset($data[$v])) {
		return $data[$v];
	}
	return null;
}
/**
 * @desc получить int переменную из request
**/
function ireq($v, $varname = 'REQUEST') {
	return (int)req($v, $varname);
}
/**
 * @desc Добавляет к корню слова окончание в зависимости от величины числа n
 * @param n - число
 * @param root корень слова
 * @param one окончание в ед. числе
 * @param less4 окончание при величине числа от 1 до 4
 * @param more19 окончание при величине числа более 19
 * @returString
*/
function pluralize($n, $root, $one, $less4, $more19, $dbg = false) {
	if ($n == 0) {
		return $root . $more19;
	}
	$m = strval($n);
	if (strlen($m) > 1) {
		$m =  intval( $m[ strlen($m) - 2 ] . $m[ strlen($m) - 1 ] );
	}
	$lex = $root . $less4;
	if ($m > 20) {
		$r = strval($n);
		$i = intval( $r[ strlen($r) - 1 ] );
	   if ($i == 1) {
			$lex = $root . $one;
		} else {
			if ($i == 0 || $i > 4) {
			   $lex = $root . $more19;
			}
		}
	} else if ($m > 4 || $m == '00') {
		$lex = $root . $more19;
	} else if ($m == 1) {
		$lex = $root . $one;
	}
	return $lex;
}
/**
 * @description Устанавливает переменную в строке link. Заменяет в строке вида base?=a=v1&b=v2&c=v3 значение переменной varName. Если переменной нет, добавляет ее. 
 *  value может иметь значение CMD_UNSET, тогда переменная будет удалена
 * @param bool $checkByValue = false если true то наличие в ссылке переменной проверяется не по имени, а по имени и значению
*/
function setGetVar($link, $varName, $value, $checkByValue = false) {
	$sep = '&';
	$arr = explode('?', $link);
	$base = $arr[0];
	$tail = isset($arr[1]) ? $arr[1] : null;
	$cmdUnset = 'CMD_UNSET';
	
	if (!$tail) {
		$sep = '';
		$tail = '';
	}
	$searchStr = $checkByValue ? ($varName . '=' . $value) : ($varName . '=');
	if (strpos($tail, $searchStr) === false) {
		if ($value != $cmdUnset) {
			$tail .= $sep . $varName . '=' . $value;
		}
	} else {
		if ($value != $cmdUnset) {
			if (!$checkByValue) {
				$tail = preg_replace("#" . $varName . "=[^&]*#", ($varName . '=' . $value), $tail);
			}
		} else {
			if (!$checkByValue) {
				$tail = preg_replace("#" . $varName . "=[^&]*#", '', $tail);
			} else {
				$tail = preg_replace("#" . $varName . '=' . $value, '', $tail);
			}
			$tail = preg_replace("#&&#s", '&', $tail);
		}
	}
	$link = $base . '?' . $tail;
	return $link;
}



































class Shared {
	static public function preparePhone($phone) {
		$phone = trim($phone);
		$plus = 0;
		if (isset($phone[0]) && $phone[0] == '+') {
			$plus = 1;
		}
		$s = trim(preg_replace("#[\D]#", "", $phone));
		if ($plus && strlen($s) > 10) {
			$code = substr($s, 0, strlen($s) - 10 );
			$tail = substr($s, strlen($s) - 10 );
			$code++;
			$s = $code . $tail;
		} elseif($plus) {
			$s = '';
		}
		return $s;
	}
	static public function prepareItem(&$r) {
		$r["type"] = array();
		if ($r["box"] == 1) {
			$r["type"][] = "грузовая";
		}
		if ($r["people"] == 1) {
			$r["type"][] = "пассажирская";
		}
		if ($r["term"] == 1) {
			$r["type"][] = "термобудка";
		}
		$r["type"] = join(", ", $r["type"]);
		$r["type"] = Shared::up1st($r["type"]);
		
		$r["distance"] = array();
		if ($r["near"] == 1) {
			$r["distance"][] = "по городу";
		}
		if ($r["far"] == 1) {
			$r["distance"][] = "межгород";
		}
		if ($r["piknik"] == 1) {
			$r["distance"][] = "за город (пикник)";
		}
		$r["distance"] = join(", ", $r["distance"]);
		$r["distance"] = Shared::up1st($r["distance"]);
		
		$r["viewphone"] = Shared::formatPhone($r['phone']);
		$r["created"] = Shared::formatDate($r['created']);
		global $baseUrl;
		$r["link"] = "$baseUrl/" . $r["codename"] . "/" . $r["id"];
		if ($baseUrl == '') {
			$bu = "";
			$bu = self::loadLocationByAbvId($r["id"]);
			$r["link"] = "$bu/" . $r["codename"] . "/" . $r["id"];
		}
		
	}
	
	static private function loadLocationByAbvId($id) {
		$id = (int)$id;
		if (!@$_SESSION["locs"][$id]) {
			$cmd = "SELECT r.codename AS rc, c.codename AS cc FROM main
				LEFT JOIN regions AS r ON r.id = main.region 
				LEFT JOIN cities AS c ON c.id = main.city
				WHERE main.id = $id 
			";
			$row = dbrow($cmd, $nr);
			if ($nr) {
				if (strlen($row['cc']) && strlen($row['rc'])) {
					$_SESSION["locs"][$id] = $s = "/{$row['rc']}/{$row['cc']}";
				} else if( strlen($row['rc']) ) {
					$_SESSION["locs"][$id] = $s = "/{$row['rc']}";
				}
			}
		}
		return @$_SESSION["locs"][$id];
	}
	
	static public function modCityName($s) {
		if ($s == "Марий Эл") return $s;
		$s = trim($s);
		$g = "аеёиоуыэюя";
		$sg = "бвгджзйклмнпрстфхцчшщъь";
		$g = utils_cp1251($g);
		$sg = utils_cp1251($sg);
		$s = utils_cp1251($s);
		
		if (strpos($s, ' ') !== false) {
			$ar = explode(' ', $s);
			$first = str_replace(
				array( utils_cp1251("ой "), utils_cp1251("ая "),  utils_cp1251("ое "), utils_cp1251("ый "), utils_cp1251("ие "), utils_cp1251("ые "), utils_cp1251("кий "), utils_cp1251("ий "),  ),
				array( utils_cp1251("ом "), utils_cp1251("ой "), utils_cp1251("ом "), utils_cp1251("ом "), utils_cp1251("их "), utils_cp1251("ых "), utils_cp1251("ком "),  utils_cp1251("ем ") ),
				$ar[ count($ar) - 2] . ' '
			);
			$second = $ar[ count($ar) - 1];
			if ($second == utils_cp1251("Яр")) return utils_utf8($s);
			self::modLastLetter($second, $sg);
			$s = utils_utf8(trim($first)) . ' ' . utils_utf8($second); 
		} else {
			self::modLastLetter($s, $sg);
			$s = utils_utf8($s);
		}
		return $s;
	}
	
	static private function modLastLetter(&$second, $sg) {
		$secondSRep = 0;
		$lastLetter = a($second, strlen($second) - 1);
		$preLastLetter = a($second, strlen($second) - 2);
		$preLastLetter2 = a($second, strlen($second) - 3);
		$msog = utils_cp1251( "н" );
		if ( strpos($sg, $lastLetter) === false ) {
			if ($lastLetter == utils_cp1251('е')) {
				$secondSRep = 1;
				$second = str_replace(
					array( utils_cp1251("ае "),  utils_cp1251("ое "), utils_cp1251("ый "), utils_cp1251("ие "), utils_cp1251("ые ") ),
					array(utils_cp1251("ае"), utils_cp1251("ом"), utils_cp1251("ом"), utils_cp1251("их"), utils_cp1251("ых") ),
					$second . ' ',
					$cnt
				);
			}
			if ($lastLetter == utils_cp1251('а')) {
				$lastLetter = utils_cp1251('е');
			}
			if ($lastLetter == utils_cp1251('ы')) {
				$lastLetter = utils_cp1251('ах');
			}
			if ($lastLetter == utils_cp1251('и')) {
				if (strpos($msog, $preLastLetter) === false) {
					$lastLetter = utils_cp1251('ах');
				} else {
					$lastLetter = utils_cp1251('ях');
				}
			}
			if ($lastLetter == utils_cp1251('я') && $preLastLetter != utils_cp1251('а')) {
				$lastLetter = utils_cp1251('и');
			}
		} else { 
			if ($lastLetter == utils_cp1251('ь')) {
				//$lastLetter = utils_cp1251('и');
				if (strpos($msog, $preLastLetter) !== false) {
					$lastLetter = utils_cp1251('и');
				} else {
					$lastLetter = utils_cp1251('е');
				}
			}else
			if ($lastLetter == utils_cp1251('й')) {
				$secondSRep = 1;
				$second = str_replace(
					array( utils_cp1251("ий "),  utils_cp1251("ай "), utils_cp1251("ый "), utils_cp1251("ой "), utils_cp1251("ей") ),
					array(utils_cp1251("ом"), utils_cp1251("ае"), utils_cp1251("ом"), utils_cp1251("ом"), utils_cp1251("ее") ),
					$second . ' '
				);
			}else {
				$lastLetter .= utils_cp1251('е');
			}
		}
		if (!$secondSRep) {
			if ( strlen($lastLetter) == 1 ) {
				$second[ strlen($second) - 1 ] = $lastLetter;
			} else {
				//$second[ strlen($second) - 1 ] = '';
				$second = substr($second, 0, strlen($second) - 1);
				$second .= $lastLetter;
			}
		}
		trim($second);
	}
	
	static public function formatPhone($s) {
		if (strlen($s) < 11) {
			return $s; 
		}
		$a = array();
		for ($i = strlen($s) - 1, $j = 1; $i > -1; $i--, $j++) {
			$a[] = $s[$i];
			if ($j == 2 || $j == 4 /*|| $j == 7 || $j == 10*/) {
				$a[] = '-';
			}
			if ($j == 10) {
				$a[] = '(';
			}
			if ($j == 7) {
				$a[] = ')';
			}
		}
		$s = join('', array_reverse($a));
		return $s;
	}
	
	static public function up1st($s, $enc = "utils_utf8") {
		if ($enc == "utils_utf8") {
			$s = utils_cp1251($s);
		}
		$first = substr($s, 0, 1);
		$tail = substr($s, 1);
		$first = mb_strtoupper($first, "Windows-1251");
		$s = "$first$tail";
		if ($enc == "utils_utf8") {
			$s = utils_utf8($s);
		}
		return $s;
	}
	
	/**
    * @desc 
    * @param
    * @param
    * @return
    **/
    static public function formatDate($r, $breakTime = false) {
    	if ($r == '0000-00-00 00:00:00' || !$r) return ' вчера';
    	$a = explode(" ", $r);
    	$_d = $d = @$a[0];
    	$t = @$a[1];
    	$d = explode("-", $d);
    	$d = join('.', array_reverse($d));
    	
    	$t = explode(":", $t);
    	unset($t[2]);
    	$r = $d;
    	
    	$now = explode(' ', now());
    	$now = $now[0];
    	
    	if ($_d == $now) {
    		$r = 'сегодня';
    	}
    	
    	if (!$breakTime) {
    	   $r .= " в " .join(':', $t);
    	}
        return $r;
    }
    /**
    * @desc 
    * @param
    * @param
    * @return
    **/
    static public function price($s) {
    	return utils_money($s);
    }
    /**
    * @desc Изменить значение переменной var в request_uri
    * @param string $var
    * @param string $val
    * @return string
    **/
    static public function setUrlVar($var, $val) {
    	$a = explode("?", $_SERVER["REQUEST_URI"]);
    	$base = $a[0];
    	$data = array();
    	$_GET[$var] = $val;
    	if ($val == 1) {
    		unset($_GET[$var]);
    	}
    	foreach ($_GET as $k => $i) {
    		$data[] = "$k=$i";
    	}
    	if (count ($_GET)) {
    		$base .= "?" . join('&', $data);
    	}
    	return $base;
    }
    /**
	 * @desc Удаляем xss sql
	 * */
    static public function deinject($s) {
    	$s = trim($s);
    	$words = array('select', 'insert', 'delete', 'drop', 'and', 'or', 'union', 'join', 'update', 'SELECT', 'INSERT', 'DELETE', 'DROP', 'AND', 'OR', 'UNION', 'JOIN', 'UPDATE');
		$replaces = array();
		foreach ($words as $w) {
			$replaces[] = '';
		}
		$s = str_replace($words, $replaces, $s);
		//xss
		$s = strip_tags($s, 'a');
		$s = preg_replace("#on[\S]+[\s]*=#", '', $s);
		$s = str_replace("'", '&quot;', $s);
		$s = mysql_real_escape_string($s);
		return trim($s);
    }
    
    static private function normalize(&$cname){
		$cname = substr($cname, 0, 128);
		$w = "abcdefghijklmnopqrstuvwxyz-_";
		$r = '';
		for ($i = 0; $i < strlen($cname); $i++) {
			if ( strpos($w, $cname[$i]) !== false) {
				$r .= $cname[$i];
			}
		}
		$cname = $r;
	}
	static public function getRegion($cname) {
		//normalize($cname);
		$cmd = "SELECT id FROM regions WHERE codename = '$cname'";
		$id = (int)dbvalue($cmd);
		return $id;
	}
	
	static public function getCity($cname) {
		//normalize($cname);
		$cmd = "SELECT id FROM cities WHERE codename = '$cname'";
		$id = (int)dbvalue($cmd);
		return $id;
	}
	
	static public function getTitle($id) {
		$id = (int)$id;
		$cmd = "SELECT codename FROM main WHERE id = $id";
		$title = dbvalue($cmd);
		return $title;
	}
    
	static public function getCityNameById($id) {
		$id = (int)$id;
		$cmd = "SELECT codename FROM cities WHERE id = $id";
		return dbvalue($cmd);
	}
	
	static public function getRegNameById($id) {
		$id = (int)$id;
		$cmd = "SELECT codename FROM regions WHERE id = $id";
		return dbvalue($cmd);
	}
	static public function getEMonth($shift = 0) {
		$n = intval(date('m')) + $shift;
		if ($n > 12) {
			$n = 1;
		}
		$a = [0, 'январе', 'феврале', 'марте', 'апреле', 'мае', 'июне', 'июле', 'августе', 'сентябре', 'октябре', 'ноябре', 'декабре'];
		return $a[$n];
	}
	/**
	 * @description Увелечение возможности поднимать объявления после успешной оплаты
	 * @param integer $payTransactionId идентификатор из pay_transaction
	 * @param float $nSum сумма фактически уплаченная пользователем, информация из нотайса
	 * @param integer $requestLogId идентификатор записи в талблице в таблице ya_http_notice, логируется если не удалось найти запись в pay_transaction
	 * @param string $logFileName имя файла в который логируется идентификатор записи, если не удалось найти запись в pay_transaction
	*/
	static public function incrementUserAppCount($payTransactionId, $nSum, $requestLogId, $logFileName = 'wrong_summ_log.txt') {
		$storedSumData = dbrow("SELECT sum, user_id FROM pay_transaction WHERE id = {$payTransactionId}");
		$storedSum = isset($storedSumData['sum']) ? $storedSumData['sum'] : 0;
		if (!$storedSum) {
			file_put_contents($logFileName, ($requestLogId. "\n"), FILE_APPEND);
			return;
		}
		$upcount = Paycheck::$offers[intval($storedSum)];
		//если сумма, оплаченная пользователем не входит в перечень заданных в платежной форме,
		//	находим среди заданных первый, меньший чем внесенная сумма, и считаем кол-во поднятий по этой стоимости.
		if (intval($storedSum) != intval($nSum)) {
			$a = array_keys(Paycheck::$offers);
			$sz = count($a);
			$sumFound = false;
			$upPrice = 60;
			for ($i = $sz - 1; $i > -1; $i--) {
				if ($a[$i] == $nSum) {
					$sumFound = true;
					break;
				}
				if ($a[$i] <= $nSum)	{
					$upPrice = $a[$i] / Paycheck::$offers[ $a[$i] ];
					$upcount = ceil($nSum / $upPrice);	
					break;
				}
			}
		} else {
			$upcount = Paycheck::$offers[intval($nSum)];
		}
		//записываем в истории операций
		$userId = isset($storedSumData['user_id']) ? $storedSumData['user_id'] : 0;
		$now = now();
		$sql = "INSERT INTO operations
			(`user_id`, `op_code_id`, `upcount`, `main_id`, `created`, `sum`, `pay_transaction_id`) VALUES
			('{$userId}', 2, '{$upcount}', 0, '{$now}', '{$nSum}', '{$payTransactionId}')
		";
		query($sql);
		//Увеличиваем баланс
		$sql = "UPDATE users SET upcount = '{$upcount}' WHERE id = {$userId}";
		query($sql);
	}
}



class FV {
		static public $obj = null;
		
		static public function  i($id, $value = null, $isPassword = 0, $sAttributes = '') {
			$type = "text";
			if ($isPassword) {
				$type = "password";
			}
			self::checkValue($value, $id);
			return '<input type="'.$type.'" name="'.$id.'" id="'.$id.'" value="'.$value.'" ' . $sAttributes  . ' />';
		}
		static public function  checkbox($id, $label, $space = ' ') {
			self::checkValue($v, $id);
			$ch = '';
			if ($v) {
				$ch = 'checked="checked"';
			}
			return '<input type="checkbox" name="'.$id.'" id="'.$id.'" value="1" '.$ch.'/>' . $space . '<label for="'.$id.'">'.$label.'</label>';
		}
		static public function  radio($id, $name, $label, $value = null) {
			self::checkValue($cvalue, $name);
			$ch = '';
			if ($value == $cvalue) {
				$ch = 'checked="checked"';
			}
			$label = str_replace('*', '<span class="red">*</span>', $label);
			return '<input type="radio" name="'.$name.'" id="'.$id.'" value="'.$value.'" '.$ch.'/> <label for="'.$id.'">'.$label.'</label>';
		}
		static public function  sub($id, $value = null) {
			self::checkValue($value, $id);
			return '<input type="submit" name="'.$id.'" id="'.$id.'" value="'.$value.'" />';
		}
		static public function  but($id, $value = null, $css = '', $dataattr = array()) {
			self::checkValue($value, $id);
			if ($css) {
				$css = ' class="' . $css . '" ';
			}
			$attr = '';
			foreach ($dataattr as $k => $i) {
				$attr .= "data-$k=\"$i\" ";
			}
			return '<input type="button" name="'.$id.'" id="'.$id.'" value="'.$value.'" ' . $css . ' ' . $attr . ' />';
		}
		static public function  inplab($id, $label, $value = null) {
			self::checkValue($value, $id);
			$label = str_replace('*', '<span class="red">*</span>', $label);
			return '<input type="text" name="'.$id.'" id="'.$id.'" value="'.$value.'" /> <label for="'.$id.'">'.$label.'</label>';
		}
		static public function  labinp($id, $label, $value = null, $maxlength = 0, $ispass = 0, $disabled = 0) {
			self::checkValue($value, $id);
			$label = str_replace('*', '<span class="red">*</span>', $label);
			$s =  '';
			if ($maxlength) {
				$s = 'maxlength="'.$maxlength.'"';
			}
			$type = "text";
			if ($ispass) {
				$type = "password";
			}
			$dis = '';
			if ($disabled) {
				$dis = 'disabled="disabled"';
			}
			return '<label for="'.$id.'">'.$label.'</label> <input type="'.$type.'" name="'.$id.'" id="'.$id.'" value="'.$value.'" '.$maxlength.' ' . $dis . '/>';
		}
		static private function checkValue(&$value, $id) {
			if ($value ===  null && @self::$obj->$id) {
				$value = self::$obj->$id;
			}
		}
	}






























function db_cache_table_struct($tableName, $fileName){
	$res   = mysql_query("SELECT * FROM $tableName LIMIT 0, 1");
	if ( mysql_error() ) {
	    echo "Data Source <br>
	    $tableName
	    <br>
	    was not found
	    <br>
	    Mysql Error:<br>
	    <hr>
	    " . mysql_error()."<hr>";
	    die;
	}
	$data  = array("fields"=>array(), "aliases"=>array());
	$cache = array();
	for ($i = 0; $i < mysql_num_fields($res); $i++) {
		$key    = mysql_field_name($res, $i);
		$type   = mysql_field_type($res, $i);
		$len    = mysql_field_len($res, $i);
		$alias  = utils_get_alias($cache, $len);
		$row    = array("field"=>$key, "type"=>$type, "length"=>$len, "alias"=>$alias);
		$data["fields"][$key]    = $row;
		$data["aliases"][$alias] = $row;		
	}
	$s = serialize($data);
	file_put_contents($fileName, $s);
}

function query($cmd, &$numRows = 0, &$affectedRows = 0) {
	$lCmd = strtolower($cmd);
	$insert = 0;
	if (strpos($lCmd, 'insert') === 0) {
		$insert = 1;
	}
	global $dberror; 
	global $dbaffectedrows; 
	global $dbnumrows;
	$res = mysql_query($cmd);
	$data = array();
	$dberror = mysql_error();
	if ($dberror) {
		var_dump($dberror); echo "\n<hr>\n$cmd<hr>\n";
		return $data;
	}
	$numRows = $dbnumrows = @mysql_num_rows($res);
	if ($dbnumrows ) {
		while ($row = mysql_fetch_array($res)) {
			$rec =array();
			foreach ($row as $k=>$i) {				
				if (strval((int) $k) != strval($k)) {
					$rec[$k] = htmlspecialchars_decode($i);
				}
			}
			$data[] = $rec;
		}
	}
	$affectedRows = $dbaffectedrows = mysql_affected_rows();
	if ($insert) {
		return mysql_insert_id(); 
	}
	return $data;
}
function dbrow($cmd, &$numRows = null) {
	$data = query($cmd, $numRows);
	if ($numRows) {
		return $data[0];
	}
	return array();
}
function dbvalue($cmd) {
    $res = mysql_query($cmd);
    if (@mysql_num_rows($res) != 0) {
    	return mysql_result($res, 0, 0);
    }
    return false;
}
