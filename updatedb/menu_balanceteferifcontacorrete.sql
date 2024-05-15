BEGIN;

select fc_startsession();

INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Balancete/Conta Corrente Sint.','Balancete/Conta Corrente Sint.','con2_balanceteverificacaocontacorrente001.php',1,1,'Balancete/Conta Corrente Sint.','t');
INSERT INTO db_menu values (4189,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 4189 and modulo = 209),209);

COMMIT;