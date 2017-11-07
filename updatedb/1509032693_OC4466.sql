-- Ocorrência 4466
BEGIN;
SELECT fc_startsession();


--Inserção dos campo no dicionário
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ac16_valorrescisao', 'float8', 'Valor Rescisão', 'null', 'Valor Rescisão', 10, FALSE, FALSE, FALSE, 4, 'text', 'Valor Rescisão');


-- Vínculo tabelas com campo
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='acordo' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ac16_valorrescisao'), 2, 0);


-- Alter table
ALTER TABLE acordo ADD COLUMN ac16_valorrescisao float8;


COMMIT;
