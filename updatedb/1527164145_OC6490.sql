
-- Ocorrência 6490
BEGIN;
SELECT fc_startsession();

-- Início do script

-- CAMPO PARA IDENTIFICAR A FINALIZAÇÃO DO ITEM EM MATREQUI
ALTER TABLE matrequi ADD COLUMN m40_finalizado BOOLEAN DEFAULT FALSE;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'm40_finalizado', 'boolean', 'Status da Requisição', '', 'Status da Requisição', 1, false, true, false, 0, 'text', 'Status da Requisição');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('m40_codigo')))
    , (select codcam from db_syscampo where nomecam = 'm40_finalizado')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('m40_codigo'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('m40_codigo')))));

-- Fim do script

COMMIT;

BEGIN;
SELECT fc_startsession();

-- Início do script

-- CAMPO PARA IDENTIFICAR A DATA DA FINALIZAÇÃO DO ITEM EM MATREQUI
ALTER TABLE matrequi ADD COLUMN m40_dtfinalizado DATE;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'm40_dtfinalizado', 'date', 'Dt. Finalização', '', 'Dt. Finalização', 1, false, true, false, 0, 'text', 'Dt. Finalização');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('m40_codigo')))
    , (select codcam from db_syscampo where nomecam = 'm40_dtfinalizado')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('m40_codigo'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('m40_codigo')))));

-- Fim do script

COMMIT;
