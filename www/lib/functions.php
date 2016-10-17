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
