 -- Ocorrência 5700
BEGIN;


SELECT fc_startsession();

 -- Início do script

ALTER TABLE pcforne ADD COLUMN pc60_databloqueio_ini date;


ALTER TABLE pcforne ADD COLUMN pc60_databloqueio_fim date;


ALTER TABLE pcforne ADD COLUMN pc60_motivobloqueio text;


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'pc60_databloqueio_ini',
                              'date',
                              'Período inicial de bloqueio',
                              '',
                              'Período inicial de bloqueio',
                              10,
                              FALSE,
                              TRUE,
                              FALSE,
                              0,
                              'date',
                              'Período inicial de bloqueio');


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
          (SELECT codarq
           FROM db_sysarqcamp
           WHERE codcam =
               (SELECT codcam
                FROM db_syscampo
                WHERE nomecam IN ('pc60_numcgm'))),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'pc60_databloqueio_ini'),
          (SELECT max(seqarq)+1
           FROM db_sysarqcamp
           WHERE codcam =
               (SELECT codcam
                FROM db_syscampo
                WHERE nomecam IN ('pc60_numcgm'))), 0);


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'pc60_databloqueio_fim',
                              'date',
                              'Período final de bloqueio',
                              '',
                              'Período final de bloqueio',
                              10,
                              FALSE,
                              TRUE,
                              FALSE,
                              0,
                              'date',
                              'Período final de bloqueio');


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
          (SELECT codarq
           FROM db_sysarqcamp
           WHERE codcam =
               (SELECT codcam
                FROM db_syscampo
                WHERE nomecam IN ('pc60_numcgm'))),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'pc60_databloqueio_fim'),
          (SELECT max(seqarq)+1
           FROM db_sysarqcamp
           WHERE codcam =
               (SELECT codcam
                FROM db_syscampo
                WHERE nomecam IN ('pc60_numcgm'))), 0);


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'pc60_motivobloqueio',
                              'text',
                              'Motivo do bloqueio',
                              '',
                              'Motivo do bloqueio',
                              10,
                              FALSE,
                              TRUE,
                              FALSE,
                              0,
                              'text',
                              'Motivo do bloqueio');


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
          (SELECT codarq
           FROM db_sysarqcamp
           WHERE codcam =
               (SELECT codcam
                FROM db_syscampo
                WHERE nomecam IN ('pc60_numcgm'))),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'pc60_motivobloqueio'),
          (SELECT max(seqarq)+1
           FROM db_sysarqcamp
           WHERE codcam =
               (SELECT codcam
                FROM db_syscampo
                WHERE nomecam IN ('pc60_numcgm'))), 0);


INSERT INTO db_itensmenu
VALUES (
          (SELECT max(id_item) + 1
           FROM db_itensmenu), 'Fornecedores Bloqueados',
                               'Fornecedores Bloqueados',
                               'com2_fornbloqueados001.php',
                               1,
                               1,
                               'Fornecedores Bloqueados',
                               't');


INSERT INTO db_menu
VALUES (9231,
          (SELECT max(id_item)
           FROM db_itensmenu),
          (SELECT max(menusequencia)+1
           FROM db_menu
           WHERE id_item = 9231
             AND modulo = 28), 28);

 -- Fim do script
 COMMIT;

