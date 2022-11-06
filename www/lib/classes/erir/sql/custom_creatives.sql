CREATE TABLE custom_creatives
(
	id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Нужно для того, чтобы отправить кастомную ссылку (баннеры размещенные руками)',
	main_id INTEGER,
	url VARCHAR(512),
	INDEX main_id (main_id)
);
