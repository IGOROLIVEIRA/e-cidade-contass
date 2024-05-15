-- Ocorrência 6114
BEGIN;


SELECT fc_startsession();

 -- Início do script

ALTER TABLE orcprojeto ADD COLUMN o39_tiposuplementacao int;


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'o39_tiposuplementacao',
                              'int',
                              'Tipo de suplementação',
                              '',
                              'Tipo de suplementação',
                              10,
                              FALSE,
                              TRUE,
                              FALSE,
                              0,
                              'int',
                              'Tipo de suplementação');


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
          (SELECT codarq
           FROM db_sysarqcamp
           WHERE codcam =
               (SELECT codcam
                FROM db_syscampo
                WHERE nomecam IN ('o39_codproj'))),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'o39_tiposuplementacao'),
          (SELECT max(seqarq)+1
           FROM db_sysarqcamp
           WHERE codcam =
               (SELECT codcam
                FROM db_syscampo
                WHERE nomecam IN ('o39_codproj'))), 0);


 -- Fim do script
 COMMIT;

