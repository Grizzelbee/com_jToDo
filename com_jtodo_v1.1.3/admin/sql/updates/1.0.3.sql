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

ALTER TABLE `#__jtodo_todos` 
CHANGE `name` `name` VARCHAR(240);

ALTER TABLE `#__jtodo_projects` 
CHANGE `name` `name` VARCHAR(100);

ALTER TABLE `#__jtodo_categories` 
CHANGE `name` `name` VARCHAR(160);
