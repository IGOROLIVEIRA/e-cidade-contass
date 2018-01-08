
-- Ocorrência 4974
BEGIN;
SELECT fc_startsession();

-- Início do script


BEGIN;

SELECT fc_startsession();

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Conta Bancaria', 'Conta Bancaria', 'pes4_contabancaria001.php', 1, 1, 'Conta Bancaria', 't');

INSERT INTO db_menu VALUES (5204, (select max(id_item) from db_itensmenu), (select max(menusequencia)+1 from db_menu where id_item = 5204 and modulo = 952), 952);

COMMIT;
select * from db_menu
-- Fim do script

COMMIT;

