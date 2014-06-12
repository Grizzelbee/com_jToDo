CREATE TABLE IF NOT EXISTS `#__jtodo_notifications` ( 
   `id`             INT NOT NULL AUTO_INCREMENT, 
   `fk_category`    INT,
   `fk_juserid`     INT, 
   `ordering`       TINYINT NOT NULL default 0,
   `published`      TINYINT NOT NULL,
   PRIMARY KEY (`id`) 
); 

ALTER TABLE `#__jtodo_notifications` 
CONVERT TO CHARACTER SET utf8 COLLATE `utf8_general_ci`;