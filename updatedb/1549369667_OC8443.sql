-- Ocorrência 8443
SELECT fc_startsession();

BEGIN;

ALTER TABLE parissqn ADD COLUMN q60_codvenc_incentivo INT4 NOT NULL DEFAULT 0;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES ((SELECT max(codcam) + 1
         FROM db_syscampo), 'q60_codvenc_incentivo', 'int4', 'Vencimento com Incentivo', '0',
        'Vencimento com Incentivo', 4, FALSE, FALSE, FALSE, 1, 'text', 'Vencimento com Incentivo');
-- Vínculo tabelas com campos
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (664, (SELECT codcam
                                                                               FROM db_syscampo
                                                                               WHERE nomecam = 'q60_codvenc_incentivo'),
                                                                         (SELECT max(seqarq) + 1
                                                                          FROM db_sysarqcamp
                                                                          WHERE codarq = 664), 0);

--ajustes
CREATE TEMP TABLE w_confvencissqnvariavel ON COMMIT DROP AS SELECT *
                                                            FROM confvencissqnvariavel;
ALTER TABLE confvencissqnvariavel DROP COLUMN q144_codvenc_desconto;
ALTER TABLE confvencissqnvariavel ADD COLUMN q144_codvenc_desconto INT4 DEFAULT 0;
UPDATE confvencissqnvariavel
SET q144_codvenc_desconto = (SELECT q144_codvenc_desconto
                             FROM w_confvencissqnvariavel
                             WHERE confvencissqnvariavel.q144_sequencial = w_confvencissqnvariavel.q144_sequencial);

COMMIT;