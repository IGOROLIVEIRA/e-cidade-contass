-- Ocorrência 6257
BEGIN;

SELECT fc_startsession();

-- Início do script

ALTER TABLE acordoitem ADD COLUMN ac20_marca varchar(150);


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
            (SELECT max(codcam)+1
             FROM db_syscampo), 'ac20_marca',
                                'text',
                                'Marca do ítem',
                                '',
                                'Marca do ítem',
                                10,
                                FALSE,
                                TRUE,
                                FALSE,
                                0,
                                'text',
                                'Marca do ítem');


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
            (SELECT codarq
             FROM db_sysarqcamp
             WHERE codcam =
                     (SELECT codcam
                      FROM db_syscampo
                      WHERE nomecam IN ('ac20_acordoposicao'))),
            (SELECT codcam
             FROM db_syscampo
             WHERE nomecam = 'ac20_marca'),
            (SELECT max(seqarq)+1
             FROM db_sysarqcamp
             WHERE codcam =
                     (SELECT codcam
                      FROM db_syscampo
                      WHERE nomecam IN ('ac20_sequencial'))), 0);

ALTER TABLE empautitem ADD COLUMN e55_marca varchar(150);


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
            (SELECT max(codcam)+1
             FROM db_syscampo), 'e55_marca',
                                'text',
                                'Marca do ítem',
                                '',
                                'Marca do ítem',
                                10,
                                FALSE,
                                TRUE,
                                FALSE,
                                0,
                                'text',
                                'Marca do ítem');


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
            (SELECT codarq
             FROM db_sysarqcamp
             WHERE codcam =
                     (SELECT codcam
                      FROM db_syscampo
                      WHERE nomecam IN ('e55_autori'))),
            (SELECT codcam
             FROM db_syscampo
             WHERE nomecam = 'e55_marca'),
            (SELECT max(seqarq)+1
             FROM db_sysarqcamp
             WHERE codcam =
                     (SELECT codcam
                      FROM db_syscampo
                      WHERE nomecam IN ('e55_autori'))), 0);

-- Fim do script

COMMIT;

