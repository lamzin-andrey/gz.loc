-- MySQL
DROP TABLE IF EXISTS `stat_up`;

CREATE TABLE IF NOT EXISTS `stat_up`
(
   `_date` DATE COMMENT 'День добавления',
   _count INTEGER COMMENT 'Счетчик обращений к страницам, на которых пока нет объявлений',
   UNIQUE KEY `_date` (`_date`)
   
)DEFAULT CHARSET=utf8;
