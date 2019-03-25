SELECT fc_startsession();
BEGIN;

ALTER TABLE tabativ
add q07_dataini_isen date,
add q07_datafim_isen date,
add q07_justificaisencao text,
add q07_aliquota_incentivo DOUBLE PRECISION;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
            (SELECT max(codcam)+1
             FROM db_syscampo), 'q07_dataini_isen',
                                'date',
                                'Inicio da Isencao',
                                'null',
                                'Inicio Isen.',
                                10,
                                FALSE,
                                FALSE,
                                FALSE,
                                1,
                                'text',
                                'Inicio ');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
            (SELECT max(codcam)+1
             FROM db_syscampo), 'q07_datafim_isen',
                                'date',
                                'Fim da Isencao',
                                'null',
                                'Fim Isen. ',
                                10,
                                FALSE,
                                FALSE,
                                FALSE,
                                1,
                                'text',
                                'Fim ');

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
            (SELECT max(codcam)+1
             FROM db_syscampo), 'q07_justificaisencao',
                                'varchar(200)',
                                'Justificativa Isencao',
                                '',
                                'Justificativa',
                                200,
                                FALSE,
                                TRUE,
                                FALSE,
                                0,
                                'text',
                                'Justificativa');

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
            (SELECT max(codcam)+1
             FROM db_syscampo), 'q07_aliquota_incentivo',
                                'float4',
                                'Aliquota Incentivo',
                                '',
                                'Aliquota',
                                20,
                                FALSE,
                                TRUE,
                                FALSE,
                                0,
                                'float',
                                'Aliquota');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (67, (select codcam from db_syscampo where nomecam = 'q07_dataini_isen'), 12, (select max(codsequencia) from db_syssequencia));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (67, (select codcam from db_syscampo where nomecam = 'q07_datafim_isen'), 13, (select max(codsequencia) from db_syssequencia));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (67, (select codcam from db_syscampo where nomecam = 'q07_justificaisencao'), 14, (select max(codsequencia) from db_syssequencia));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (67, (select codcam from db_syscampo where nomecam = 'q07_aliquota_incentivo'), 15, (select max(codsequencia) from db_syssequencia));
COMMIT;
