ALTER TABLE main ADD COLUMN IF NOT EXISTS ordya_erid VARCHAR(255) DEFAULT NULL COMMENT 'Полученный из ОРД Яндекса erid';
ALTER TABLE main ADD COLUMN IF NOT EXISTS ordya_request_id VARCHAR(255) DEFAULT NULL COMMENT 'Для запроса GET status';
ALTER TABLE main ADD COLUMN IF NOT EXISTS ordya_last_request DATETIME COMMENT 'Время последнего запроса на сервер ОРДЯ';

 
