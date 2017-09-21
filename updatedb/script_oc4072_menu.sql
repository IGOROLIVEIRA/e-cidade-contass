BEGIN;

SELECT fc_startsession();

INSERT INTO db_itensmenu VALUES (4001100, 'Transferência', 'Transferência de veículos', 'vei1_baixatransferencia001.php', 1, 1, 'Transferência de veículos', 't');
INSERT INTO db_menu VALUES (5395, 4001100, 200, 633);

INSERT INTO db_itensmenu VALUES (4001101, 'Documentos', 'Documentos de veículos', '', 1, 1, 'Documentos de veículos', 't');
INSERT INTO db_itensmenu VALUES (4001102, 'Transferência', 'Relatório de transferência de veículos', '', 1, 1, 'Relatório de transferência de veículos', 't');
INSERT INTO db_menu VALUES (5336, 4001101, 201, 633);
INSERT INTO db_menu VALUES (4001101, 4001102, 202, 633);



COMMIT;



