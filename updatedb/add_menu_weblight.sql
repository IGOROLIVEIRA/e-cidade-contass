begin;

select fc_startsession();

INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Weblight', 'Weblight','pes1_weblight.php',1,1,'','t');
INSERT INTO db_menu VALUES (5106,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu),952);

commit;
