

BEGIN;

SELECT fc_startsession();

INSERT INTO db_itensmenu VALUES (4001000, 'Rateio', 'Rateio', '', 1, 1, 'Rateio', 't');
INSERT INTO db_itensmenu VALUES (4001001, 'Entes Consorciados', 'Entes Consorciados', '', 1, 1, 'Entes Consorciados', 't');
INSERT INTO db_itensmenu VALUES (4001002, 'Gerar Rateio', 'Gerar Rateio', '', 1, 1, 'Gerar Rateio', 't');
INSERT INTO db_itensmenu VALUES (4001003, 'Relatório Rateio', 'Relatório Rateio', '', 1, 1, 'Relatório Rateio', 't');

INSERT INTO db_menu VALUES (3332, 4001000, 100, 209);
INSERT INTO db_menu VALUES (4001000, 4001001, 101, 209);
INSERT INTO db_menu VALUES (4001000, 4001002, 102, 209);
INSERT INTO db_menu VALUES (4001000, 4001003, 103, 209);

COMMIT;

