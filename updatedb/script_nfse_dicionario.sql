SELECT fc_startsession();
BEGIN;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'q62_vlrirrf     ', 'float8 ', 'Valor IRRF', null, 'Valor IRRF', 30, TRUE, FALSE, FALSE, 4, 'text', 'Valor IRRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'q62_vlrinss     ', 'float8 ', 'Valor INSS', null, 'Valor INSS', 30, TRUE, FALSE, FALSE, 4, 'text', 'Valor INSS');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'q62_tiporetirrf ', 'varchar', 'Tipo de retenção IRRF', null, 'Tipo de retenção IRRF', 30, TRUE, TRUE, FALSE, 0, 'text', 'Tipo de retenção IRRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'q62_tiporetinss ', 'varchar', 'Tipo de retenção INSS', null, 'Tipo de retenção INSS', 30, TRUE, TRUE, FALSE, 0, 'text', 'Tipo de retenção INSS');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'q62_deducaoinss ', 'float8 ', 'Retenções outros INSS', null, 'Retenções outros INSS', 30, TRUE, TRUE, FALSE, 0, 'text', 'Retenções outros INSS');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'q62_qtddepend   ', 'int4   ', 'Qtd. de dependentes', null, 'Qtd. de dependentes', 30, TRUE, TRUE, FALSE, 0, 'text', 'Qtd. de dependentes');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'issnotaavulsaservico'), (SELECT codcam FROM db_syscampo WHERE nomecam = 'q62_vlrirrf'), 13, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'issnotaavulsaservico'), (SELECT codcam FROM db_syscampo WHERE nomecam = 'q62_vlrinss'), 15, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'issnotaavulsaservico'), (SELECT codcam FROM db_syscampo WHERE nomecam = 'q62_tiporetirrf'), 16, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'issnotaavulsaservico'), (SELECT codcam FROM db_syscampo WHERE nomecam = 'q62_tiporetinss'), 17, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'issnotaavulsaservico'), (SELECT codcam FROM db_syscampo WHERE nomecam = 'q62_deducaoinss'), 18, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'issnotaavulsaservico'), (SELECT codcam FROM db_syscampo WHERE nomecam = 'q62_qtddepend'), 19, 0);


COMMIT;

--

SELECT fc_startsession();
BEGIN;

ALTER TABLE issnotaavulsaservico ADD COLUMN q62_vlrirrf float8 NULL;
ALTER TABLE issnotaavulsaservico ADD COLUMN q62_vlrinss float8 NULL;
ALTER TABLE issnotaavulsaservico ADD COLUMN q62_tiporetirrf varchar NULL;
ALTER TABLE issnotaavulsaservico ADD COLUMN q62_tiporetinss varchar NULL;
ALTER TABLE issnotaavulsaservico ADD COLUMN q62_deducaoinss float8 NULL;
ALTER TABLE issnotaavulsaservico ADD COLUMN q62_qtddepend int4 NULL;


COMMIT;
