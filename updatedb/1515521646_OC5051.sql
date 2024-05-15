
-- Ocorrência 5051
BEGIN;
SELECT fc_startsession();

-- Início do script

ALTER TABLE parametroscontratos ADD COLUMN pc01_liberarcadastrosemvigencia BOOLEAN;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
(SELECT max(codcam)+1
FROM db_syscampo), 'pc01_liberarcadastrosemvigencia',
'bool',
'Liberar cadastro de contratos sem vigência',
FALSE,
'Liberar cadastro de contratos sem vigência',
1,
FALSE,
FALSE,
FALSE,
5,
'text',
'Liberar cadastro');


UPDATE parametroscontratos SET pc01_liberarcadastrosemvigencia = 'f';

ALTER TABLE parametroscontratos ADD COLUMN pc01_liberarsemassinaturaaditivo BOOLEAN;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
(SELECT max(codcam)+1
FROM db_syscampo), 'pc01_liberarsemassinaturaaditivo',
'bool',
'Liberar cadastro de contratos s/ass. de aditivo',
FALSE,
'Liberar cadastro de contratos s/ass. de aditivo',
1,
FALSE,
FALSE,
FALSE,
5,
'text',
'Liberar cadastro');




UPDATE parametroscontratos SET pc01_liberarsemassinaturaaditivo = 'f';
-- Fim do script

COMMIT;

