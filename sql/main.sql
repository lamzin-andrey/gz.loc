-- MySQL
DROP TABLE IF EXISTS `main`;

CREATE TABLE IF NOT EXISTS `main`
(
   id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT '��������� ����.',
   region INTEGER COMMENT '����� �������',
   KEY `region` (`region`),
   city INTEGER COMMENT '����� ������',
   KEY `city` (`city`),
   people SMALLINT COMMENT '1 - ���� ������ ������������',
   KEY `people` (`people`),
   price DECIMAL(12,2) COMMENT '���������',
   box SMALLINT COMMENT '1 - ���� ��������',
   KEY `box` (`box`),
   term SMALLINT COMMENT '1 - ���� ����������',
   KEY `term` (`term`),
   far SMALLINT COMMENT '1 - ���� ��������',
   KEY `far` (`far`),
   near SMALLINT COMMENT '1 - ���� �� ������',
   KEY `near` (`near`),
   piknik SMALLINT COMMENT '1 - ���� �� ������',
   KEY `piknik` (`piknik`),
   title VARCHAR(255) COMMENT '��������� ����������',
   image VARCHAR(512) COMMENT '���� � ����� ����������� �� ����� �������',
   name VARCHAR(512) COMMENT '��� ������ (�������� ��������)',
   addtext VARCHAR(1000) COMMENT '����� ����������',
   phone VARCHAR(15) COMMENT '����� ��������',
   KEY `phone` (`phone`),
   `pinned` SMALLINT DEFAULT 0 COMMENT '��������� ������� �����',
   created TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '����� ���������� �������',
   is_moderate INTEGER DEFAULT 0 COMMENT '�������������� �� �������',
   is_hide INTEGER DEFAULT 0 COMMENT '������ ��',
   is_deleted INTEGER DEFAULT 0 COMMENT '������ ��� ���. ����� ���������� �� �������, �� ����� � cdbfrselectmodel ���� �������, ��� ������',
   delta INTEGER COMMENT '�������.  ����� ���������� �� �������, �� ����� � cdbfrselectmodel ���� �������, ��� ������'
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TRIGGER IF EXISTS `bimain`;

DELIMITER //

CREATE TRIGGER  `bimain` BEFORE INSERT ON `main`
FOR EACH ROW BEGIN
 SET NEW.delta = (SELECT max(delta) FROM `main`) + 1;
 IF NEW.delta IS NULL THEN
     SET NEW.delta = 1;
 END IF;
END//

DELIMITER ;

;


-- ALTER TABLE main ADD COLUMN `pinned` SMALLINT DEFAULT 0 COMMENT '��������� ������� �����';
