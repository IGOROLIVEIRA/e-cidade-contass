
-- Ocorrência 8680complentar
BEGIN;                   
SELECT fc_startsession();

-- Início do script

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c224_medida', 'int4', 'c224_medida', '0', 'c224_medida', 11, false, false, true, 1, 'text', 'c224_medida');

-- Fim do script

COMMIT;

