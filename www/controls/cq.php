<?php

/** Очищает очередь sms собщений */
class ClearQueue {
	public function __construct() {
		global $dberror;
		query('TRUNCATE TABLE sms_code');
		sess('clearcodescomplete', 'Очередь сообщений очищена');
		utils_302('/private/ops');
		exit;
		
	}
}
new ClearQueue();
