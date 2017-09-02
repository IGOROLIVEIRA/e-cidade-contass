BEGIN;
SELECT fc_startsession();
UPDATE db_itensmenu  SET libcliente = 'f' WHERE descricao = 'Autenticação de Recebimentos';
COMMIT;