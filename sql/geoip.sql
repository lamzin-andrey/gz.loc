-- MySQL
DROP TABLE IF EXISTS `geoip`;

CREATE TABLE IF NOT EXISTS `geoip`
(
   _time DATETIME COMMENT '����� ���������� ��������� � ����� � ������� ip  � � ������ ua',
   hash VARCHAR(32) COMMENT '��� ip+ua'
   
)DEFAULT CHARSET=utf8 COMMENT='����� ���������� ��������� � ����� � ������� ip  � � ������ ua';
