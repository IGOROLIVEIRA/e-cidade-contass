
-- Ocorrência 4604
BEGIN;
SELECT fc_startsession();

-- Início do script

ALTER TABLE empempenho ADD COLUMN e60_datasentenca DATE;


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'e60_datasentenca',
                              'date',
                              'Data da Sentenca Judicial',
                              '',
                              'Data da Sentenca Judicial',
                              10,
                              FALSE,
                              TRUE,
                              FALSE,
                              0,
                              'date',
                              'Data da Sentenca Judicial');


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
          (SELECT codarq
           FROM db_sysarqcamp
           WHERE codcam =
               (SELECT codcam
                FROM db_syscampo
                WHERE nomecam IN ('e60_dataconvenio'))),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'e60_datasentenca'),
          (SELECT max(seqarq)+1
           FROM db_sysarqcamp
           WHERE codcam =
               (SELECT codcam
                FROM db_syscampo
                WHERE nomecam IN ('e60_dataconvenio'))), 0);

-- Fim do script

--ALTER TABLE lqd102017 ADD COLUMN si118_dtsentenca DATE;
--ALTER TABLE lqd102018 ADD COLUMN si118_dtsentenca DATE;
--ALTER TABLE alq102017 ADD COLUMN si121_dtsentenca DATE;

COMMIT;

