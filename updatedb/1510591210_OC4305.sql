BEGIN;
SELECT fc_startsession();
-- Ocorrência 4305

--Inserção dos campo no dicionário
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'pc75_numdocumento', 'varchar', 'N° do Documento', 'null', 'N° do Documento', 20, FALSE, FALSE, FALSE, 0, 'varchar', 'N° do Documento');

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'pc74_observacao', 'text', 'Observação', 'null', 'Observação', 1, TRUE, FALSE, FALSE, 0, 'text', 'Observação');


-- Vínculo tabelas com campo
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='pcfornecertifdoc' LIMIT 1),
(SELECT codcam FROM db_syscampo WHERE nomecam = 'pc75_numdocumento'), 2, 0);

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='pcfornecertif' LIMIT 1),
(SELECT codcam FROM db_syscampo WHERE nomecam = 'pc74_observacao'), 2, 0);

-- Alter table
ALTER TABLE pcfornecertifdoc ADD COLUMN pc75_numdocumento varchar(20) NOT NULL default 0;
ALTER TABLE pcfornecertif ADD COLUMN pc74_observacao text;


COMMIT;
