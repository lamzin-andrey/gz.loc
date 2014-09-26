-- MySQL
DROP TABLE IF EXISTS `admins`;

CREATE TABLE IF NOT EXISTS `admins`
(
   id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT '��������� ����.',
   pwd VARCHAR(32) COMMENT '������',
   login  VARCHAR(32) COMMENT 'login',
   is_deleted INTEGER DEFAULT 0 COMMENT '������ ��� ���. ����� ���������� �� �������, �� ����� � cdbfrselectmodel ���� �������, ��� ������',
   delta INTEGER COMMENT '�������.  ����� ���������� �� �������, �� ����� � cdbfrselectmodel ���� �������, ��� ������'
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TRIGGER IF EXISTS `biadmins`;

DELIMITER //

CREATE TRIGGER  `biadmins` BEFORE INSERT ON `admins`
FOR EACH ROW BEGIN
 SET NEW.delta = (SELECT max(delta) FROM `admins`) + 1;
 IF NEW.delta IS NULL THEN
     SET NEW.delta = 1;
 END IF;
END//

DELIMITER ;

;


-- ALTER TABLE admins ADD COLUMN `pinned` SMALLINT DEFAULT 0 COMMENT '��������� ������� �����';
