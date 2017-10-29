<?php

/** Очищает очередь sms собщений */
class ClearQueue {
	public function __construct() {
		query('TRUNCATE TABLE sms_code');
	}
}
new ClearQueue();
