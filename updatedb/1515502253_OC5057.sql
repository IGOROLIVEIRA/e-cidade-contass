-- Ocorrência 5057
BEGIN;                   
SELECT fc_startsession();

-- Início do script
INSERT INTO db_itensmenu values (nextval('db_itensmenu_id_item_seq'),'Manutenção por Periodo','Manutenção por Periodo','vei2_veicmanut001.php','1','1','Manutenção por Periodo');

INSERT INTO db_menu(id_item,id_item_filho,menusequencia,modulo) values (5336,(select max(id_item) from db_itensmenu),23,633);

-- Fim do script

COMMIT;

