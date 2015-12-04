BEGIN;

SELECT fc_startsession();

UPDATE db_itensmenu SET descricao = 'Fornecedor', help = 'Fornecedor' WHERE id_item = 3962;

COMMIT;


