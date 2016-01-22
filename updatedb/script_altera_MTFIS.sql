BEGIN;

SELECT fc_startsession();

UPDATE db_layoutlinha set db51_tamlinha = 354 where db51_codigo = 432;

delete from db_layoutcampos where db52_codigo = 1010708;

COMMIT;
