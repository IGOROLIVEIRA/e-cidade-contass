
-- Ocorrência 5283
BEGIN;                   
SELECT fc_startsession();

-- Início do script

DELETE FROM db_layoutcampos where db52_codigo in (SELECT lc.db52_codigo from db_layouttxt l join db_layoutlinha ll on db50_codigo = db51_layouttxt join db_layoutcampos lc on db51_codigo = db52_layoutlinha where db50_descr like 'SICOM%');

DELETE FROM db_layoutlinha where db51_codigo in (SELECT ll.db51_codigo from db_layouttxt l join db_layoutlinha ll on db50_codigo = db51_layouttxt where db50_descr like 'SICOM%');

DELETE FROM db_layouttxt where db50_codigo in (SELECT db50_codigo from db_layouttxt where db50_descr like 'SICOM%');

\copy db_layouttxt FROM 'updatedb/db_layouttxt.csv' DELIMITER ';'
\copy db_layoutlinha FROM 'updatedb/db_layoutlinha.csv' DELIMITER ';'
\copy db_layoutcampos FROM 'updatedb/db_layoutcampos.csv' DELIMITER ';'

-- Fim do script

COMMIT;

