
-- Ocorrência CategoriaeSocial
BEGIN;                   
SELECT fc_startsession();

-- Início do script

ALTER TABLE tpcontra ADD COLUMN h13_categoria int4;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'h13_categoria', 'int4', 'Categoria e-Social', '', 'Categoria e-Social', 3, false, false, false, 1, 'text', 'Categoria e-Social');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (597, (select codcam from db_syscampo where nomecam = 'h13_categoria'), 5, 0);


-- Fim do script

COMMIT;

