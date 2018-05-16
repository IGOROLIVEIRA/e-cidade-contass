
-- Ocorrência 5171
BEGIN;
SELECT fc_startsession();

-- Início do script

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Assinatura de aditamentos', 'Assinatura de aditamentos', '', 1, 1, 'Assinatura de aditamentos', 't');

INSERT INTO db_menu VALUES (32, (select max(id_item) from db_itensmenu), (select max(menusequencia)+1 from db_menu where id_item = 32 and modulo = 8251), 8251);

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Inclusao', 'Inclusao de assinaturas', 'con4_inclusaoassinatura001.php', 1, 1, 'Inclusao de assinatura de aditamentos', 't');

INSERT INTO db_menu VALUES ((select max(id_item) from db_itensmenu)-1, (select max(id_item) from db_itensmenu), (select max(menusequencia)+1 from db_menu where id_item = (select max(id_item) from db_itensmenu)-1 and modulo = 8251), 8251);

-- Fim do script

COMMIT;

