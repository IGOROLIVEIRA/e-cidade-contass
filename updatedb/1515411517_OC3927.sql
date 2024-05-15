
-- Ocorrência 3927
BEGIN;
SELECT fc_startsession();

-- Início do script

SELECT fc_startsession();

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Saldo de Contratos', 'Saldo de Contratos', 'con2_saldocontratos001.php', 1, 1, 'Saldo de Contratos', 't');

INSERT INTO db_menu VALUES (8595, (select max(id_item) from db_itensmenu), (select max(menusequencia)+1 from db_menu where id_item = 8595 and modulo = 8251), 8251);


-- Fim do script

COMMIT;

