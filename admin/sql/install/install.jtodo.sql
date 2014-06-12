CREATE TABLE IF NOT EXISTS `#__jtodo_projects` ( 
   `id` INT NOT NULL AUTO_INCREMENT, 
   `name`           VARCHAR(100) CHARACTER SET utf8 , 
   `preamble`       TEXT CHARACTER SET utf8,
   `ordering`       SMALLINT NOT NULL,
   `published`      SMALLINT NOT NULL,
   PRIMARY KEY (`id`) 
); 

CREATE TABLE IF NOT EXISTS `#__jtodo_categories` ( 
    `id` INT NOT NULL AUTO_INCREMENT, 
    `name`           VARCHAR(160) CHARACTER SET utf8 , 
    `ordering`       SMALLINT NOT NULL,
    `published`      SMALLINT NOT NULL,
    PRIMARY KEY (`id`)
); 

CREATE TABLE IF NOT EXISTS `#__jtodo_todos` ( 
    `id`              INT NOT NULL AUTO_INCREMENT, 
    `name`            VARCHAR(240) CHARACTER SET utf8 ,
    `targetdate`      DATE,
    `status`          TINYINT NOT NULL DEFAULT 0, 
    `published`       TINYINT NOT NULL,
    `ordering`        SMALLINT NOT NULL,
    `inserted`        DATE,
    `updated`         DATE,
    `done_at`         DATE,
    `done_by_juserid` INT,
    `fk_category`     INT NOT NULL,
    `fk_project`      INT NOT NULL,
    PRIMARY KEY (`id`)
); 

CREATE TABLE IF NOT EXISTS `#__jtodo_mappings` ( 
   `id`             INT NOT NULL AUTO_INCREMENT, 
   `juserid`        INT, 
   `fk_todo`        INT,
   `published`      TINYINT NOT NULL,
   PRIMARY KEY (`id`) 
); 

CREATE TABLE IF NOT EXISTS `#__jtodo_visits` ( 
   `id`             INT NOT NULL AUTO_INCREMENT, 
   `juserid`        INT , 
   `fk_project`     INT,
   `lastvisitdate`  DATE,
   PRIMARY KEY (`id`) 
); 

CREATE TABLE IF NOT EXISTS `#__jtodo_notifications` ( 
   `id`             INT NOT NULL AUTO_INCREMENT, 
   `fk_category`    INT,
   `fk_juserid`     INT, 
   `ordering`       TINYINT NOT NULL default 0,
   `published`      TINYINT NOT NULL,
   PRIMARY KEY (`id`) 
); 


ALTER TABLE `#__jtodo_projects` 
CONVERT TO CHARACTER SET utf8 COLLATE `utf8_general_ci`;

ALTER TABLE `#__jtodo_categories` 
CONVERT TO CHARACTER SET utf8 COLLATE `utf8_general_ci`;

ALTER TABLE `#__jtodo_todos` 
CONVERT TO CHARACTER SET utf8 COLLATE `utf8_general_ci`;

ALTER TABLE `#__jtodo_mappings` 
CONVERT TO CHARACTER SET utf8 COLLATE `utf8_general_ci`;

ALTER TABLE `#__jtodo_visits` 
CONVERT TO CHARACTER SET utf8 COLLATE `utf8_general_ci`;

ALTER TABLE `#__jtodo_notifications` 
CONVERT TO CHARACTER SET utf8 COLLATE `utf8_general_ci`;