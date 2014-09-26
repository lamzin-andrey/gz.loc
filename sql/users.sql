-- MySQL
DROP TABLE IF EXISTS `users`;

CREATE TABLE IF NOT EXISTS `users`
(
   id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT '��������� ����.',
   pwd VARCHAR(32) COMMENT '������',
   rawpass  VARCHAR(32) COMMENT '������ ��� �� ����',
   phone VARCHAR(15) COMMENT '����� ��������',
   email    VARCHAR(64) COMMENT 'email',
   firster    TINYINT COMMENT '������� ����, ��� � ��� ��� �������, ��������� �������������� ������ �� email',
   is_deleted INTEGER DEFAULT 0 COMMENT '������ ��� ���. ����� ���������� �� �������, �� ����� � cdbfrselectmodel ���� �������, ��� ������',
   delta INTEGER COMMENT '�������.  ����� ���������� �� �������, �� ����� � cdbfrselectmodel ���� �������, ��� ������'
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TRIGGER IF EXISTS `biusers`;

DELIMITER //

CREATE TRIGGER  `biusers` BEFORE INSERT ON `users`
FOR EACH ROW BEGIN
 SET NEW.delta = (SELECT max(delta) FROM `users`) + 1;
 IF NEW.delta IS NULL THEN
     SET NEW.delta = 1;
 END IF;
END//

DELIMITER ;

;


-- ALTER TABLE users ADD COLUMN `pinned` SMALLINT DEFAULT 0 COMMENT '��������� ������� �����';
