ALTER TABLE `main` ADD COLUMN date_update DATETIME;
UPDATE main SET date_update = '2018-09-11 09:35:00';
