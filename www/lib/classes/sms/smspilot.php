<?php
require_once DR . '/lib/classes/sms/smspilot1.9.10/smspilot.php';
class SMSPilot {
	/**
	 * 
	 * @param array of ['phone'=>,'code'=>] $list 
	 * @return StdClass {success, number} success - true если удалось отправить смс или если номер не валидный !!!!
										  number - номер, чтобы удалить его из- очереди.
	*/
	static public function send($list) {
		//Так как ответ невнятный просто возвращаем переформатированный $list
		$result = [];
		if (!count($list)) {
			return $result;
		}
		$request = new Request();
		$messages = [
			'%1% - Код подтверждения на Gazel.Me',
			'Ваш код подтверждения на Gazel.Me %1%',
			'Gazel.Me: Ваш код подтверждения %1%',
			'Спасибо, что вы с нами! Код подтверждения: %1%. Gazel.Me',
			'Спасибо за регистрацию! Код: %1%. Gazel.Me',
		];
		$s = $messages[ rand(0, count($messages) - 1)];
		
		$numbers = [];
		foreach ($list as $phoneData) {
			$phone = preg_replace("#^8#", '7', $phoneData['phone']);
			//$s = '<number variables="' . $phoneData['code'] . ';">' . $phone . '</number>';
			
			$s = str_replace('%1%', $phoneData['code'], $s);
			$o = new StdClass();
			$o->number = $phoneData['phone'];
			$o->success = sms($phone, $s, 'GazelMe');
			$o->success = $o->success ? true : false;
			$result[] = $o;
		}
		return $result;
	}
	
	/**
	 * #return int status -1 - AUTH_FAILED,  -2 WRONG XML, -3 NOT_ENOUGH_CREDITS, -4 NO_RECIPIENTS 
	 * -5 не удалось распарсить ответ
	 * > 0 количество отправленных
	*/
	static private function _getStatus($s) {
		$dom = new DOMDocument();
		$dom->validateOnParse =  false;
		@$dom->loadXML($s);
		$statuses = $dom->getElementsByTagName('status');
		if ($statuses->length) {
			return (int)$statuses->item(0)->textContent;
		}
		return -5;
	}
	
	static  private function _log($s) {
		file_put_contents(__DIR__ . '/log.log', $s . "\n\n===================\n\n", FILE_APPEND);
	}
}

