
-- Ocorrência 4847
BEGIN;                   
SELECT fc_startsession();

-- Início do script

--ADD CAMPO SI06_ANOPROC A TABELA
ALTER TABLE adesaoregprecos ADD column si06_anoproc int8;

--CRIA CAMPO SI06_ANOPROC
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'si06_anoproc', 'int4', 'Exercício da Licitação', '0', 'Exercício da Licitação', 4, false, false, true, 1, 'text', 'si06_anoproc');

--VINCULO TABELA COM CAMPO
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si06_anoproc'), 1, (select max(codsequencia) from db_syssequencia));

-- Fim do script

COMMIT;

