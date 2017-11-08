
-- Ocorrência 4474

BEGIN;

SELECT fc_startsession();

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Protocolo', 'Protocolos', '', 1, 1, 'Protocolos', 't');
INSERT INTO db_menu VALUES (32, (select max(id_item) from db_itensmenu), 410, 604);

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Incluir', 'Protocolos', 'pro1_protocoloinclusao001.php', 1, 1, 'Cadastro Protocolos', 't');
INSERT INTO db_menu VALUES ((select max(id_item) - 1 from db_itensmenu), (select max(id_item) from db_itensmenu), 1, 604);

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Localizar', 'Protocolos', 'pro3_consultaprocesso_aut_emp_oc_op001.php', 1, 1, 'Localizar protocolos', 't');
INSERT INTO db_menu VALUES ((select max(id_item) - 2 from db_itensmenu), (select max(id_item) from db_itensmenu), 2, 604);

COMMIT;



