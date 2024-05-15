BEGIN;
SELECT fc_startsession();
-- Ocorrência

--Inserção dos campo no dicionário
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si09_codunidadesubunidade', 'int8', 'Cod. Unidade ou Subunidade​', '0', 'Cod. Unidade ou Subunidade​', 8, FALSE, FALSE, FALSE, 0, 'int', 'Cod. Unidade ou Subunidade​');

-- Vínculo tabelas com campo
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='infocomplementaresinstit' LIMIT 1),
(SELECT codcam FROM db_syscampo WHERE nomecam = 'si09_codunidadesubunidade'), 10, 0);

-- Alter table
ALTER TABLE infocomplementaresinstit ADD COLUMN si09_codunidadesubunidade varchar(8);

COMMIT;
