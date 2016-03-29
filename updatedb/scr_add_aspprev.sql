BEGIN;

select fc_startsession();

INSERT INTO db_itensmenu VALUES (3000262,'ASPPREV', '','pes4_geraraspprev.php',1,1,'','t');

INSERT INTO db_menu VALUES (268991,3000262,100,952);

COMMIT;