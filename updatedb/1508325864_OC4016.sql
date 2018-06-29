
-- Ocorrência 4016

BEGIN;

SELECT fc_startsession();

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Movimentacao de​ ​Itens ​no ​Empenho', 'Movimentacao de ​Itens​ ​no​ ​Empenho', 'emp2_movimentacaoitemempenho001.php', 1, 1, 'Movimentacao de​ ​Itens​ ​no​ ​Empenho', 't');

INSERT INTO db_menu VALUES (5602, (select max(id_item) from db_itensmenu), 55, 398);

COMMIT;
