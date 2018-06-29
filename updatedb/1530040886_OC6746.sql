
-- Ocorrência 6746
BEGIN;
SELECT fc_startsession();
-- Início do script
ALTER TABLE cadferia ADD COLUMN r30_periodogozrecini DATE;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'r30_periodogozrecini', 'Date', 'Período a gozar - Recibo', '', 'Período a gozar - Recibo', 1, false, true, false, 0, 'text', 'Período a gozar - Recibo');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('r30_ponto')))
    , (select codcam from db_syscampo where nomecam = 'r30_periodogozrecini')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('r30_ponto'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('r30_ponto')))));
-- Fim do script

COMMIT;

BEGIN;
SELECT fc_startsession();

-- Início do script
ALTER TABLE cadferia ADD COLUMN r30_periodogozrecfim DATE;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'r30_periodogozrecfim', 'Date', 'Período a gozar - Recibo', '', 'Período a gozar - Recibo', 1, false, true, false, 0, 'text', 'Período a gozar - Recibo');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('r30_ponto')))
    , (select codcam from db_syscampo where nomecam = 'r30_periodogozrecfim')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('r30_ponto'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('r30_ponto')))));
-- Fim do script

COMMIT;


