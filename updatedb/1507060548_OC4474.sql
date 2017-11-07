
-- Ocorrência 4474

BEGIN;

SELECT fc_startsession();

INSERT INTO db_itensmenu VALUES (4001110, 'Protocolo', 'Protocolos', '', 1, 1, 'Protocolos', 't');
INSERT INTO db_itensmenu VALUES (4001111, 'Incluir', 'Protocolos', 'pro1_protocoloinclusao001.php', 1, 1, 'Cadastro Protocolos', 't');
INSERT INTO db_itensmenu VALUES (4001112, 'Localizar', 'Protocolos', 'pro3_consultaprocesso_aut_emp_oc_op001.php', 1, 1, 'Localizar protocolos', 't');

INSERT INTO db_menu VALUES (32, 4001110, 410, 604);
INSERT INTO db_menu VALUES (4001110, 4001111, 1, 604);
INSERT INTO db_menu VALUES (4001110, 4001112, 2, 604);

COMMIT;


