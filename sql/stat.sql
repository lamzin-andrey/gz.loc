-- MySQL
DROP TABLE IF EXISTS `stat`;

CREATE TABLE IF NOT EXISTS `stat`
(
   region INTEGER COMMENT '����� �������',   
   city INTEGER COMMENT '����� ������',   
   country INTEGER COMMENT '����� ������',
   KEY `region` (`region`), KEY `city` (`city`),
   UNIQUE KEY `location` (`region`, `country`, `city`),
    cnt INTEGER COMMENT '������� ��������� � ���������, �� ������� ���� ��� ����������'
   
)DEFAULT CHARSET=utf8;
