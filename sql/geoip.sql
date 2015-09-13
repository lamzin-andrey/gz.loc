-- MySQL
DROP TABLE IF EXISTS `geoip`;

CREATE TABLE IF NOT EXISTS `geoip`
(
   _time DATETIME COMMENT 'Время последнего обращения к сайту с данного ip  и с данным ua',
   hash VARCHAR(32) COMMENT 'Хэш ip+ua'
   
)DEFAULT CHARSET=utf8 COMMENT='Время последнего обращения к сайту с данного ip  и с данным ua';
