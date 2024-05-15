BEGIN;
SELECT fc_startsession();

INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Ratificação', 'Ratificação de Processo', 'rat2_ratificacaoproc001.php', 1, 1, 'Ratificação de Processo', 't');
INSERT INTO db_menu VALUES (1797, (select max(id_item) from db_itensmenu), 1001, 381);
COMMIT;

BEGIN;
INSERT INTO db_tipodoc VALUES (9001,'RATIFICACAO DE PROCESSO');
COMMIT;