alter TABLE  `#__scet_events` 
change `duty`  `mandatory` tinyint;

alter TABLE  `#__scet_events` 
add column   `anniversary`     tinyint;

update `#__scet_events` 
set    anniversary = 0
where  anniversary is null;