
-- Ocorrência 6782
BEGIN;
SELECT fc_startsession();

-- Início do script

-- ADICIONAR RÓTULO ENCERRAMENTO DO PERÍODO CONTÁBIL
-- #################################################
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'c99_encpercont', 'varchar(120)', 'Encerramento do Período Contábil', '', 'Encerramento do Período Contábil', 120, false, false, false, 0, 'text', 'Encerramento do Período Contábil');

  INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c99_anousu')))
    , (select codcam from db_syscampo where nomecam = 'c99_encpercont')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c99_anousu'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c99_anousu')))));


-- ADICIONAR RÓTULO ENCERRAMENTO DO PERÍODO PATRIMONIAL
-- #################################################

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'c99_encperpat', 'varchar(120)', 'Encerramento do Período Patrimonial', '', 'Encerramento do Período Patrimonial', 120, false, false, false, 0, 'text', 'Encerramento do Período Patrimonial');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c99_anousu')))
    , (select codcam from db_syscampo where nomecam = 'c99_encperpat')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c99_anousu'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c99_anousu')))));


-- ADICIONAR INPUT ENCERRAMENTO DO PERÍODO PATRIMONIAL
-- #################################################
ALTER TABLE condataconf ADD COLUMN c99_datapat DATE;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'c99_datapat', 'date', 'Data de Encerramento do Período Patrim.', '', 'Data de Encerramento do Período Patrim.', 1, false, false, false, 0, 'text', 'Data de Encerramento do Período Patrim.');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c99_anousu')))
    , (select codcam from db_syscampo where nomecam = 'c99_datapat')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c99_anousu'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c99_anousu')))));


-- CORREÇÃO DE RÓTULO E DESCRIÇÃO
-- #################################################
UPDATE db_syscampo
SET rotulo='Instituição', descricao='Instituição', rotulorel='Instituição'
WHERE codcam=8010;

-- Fim do script

-- Fim do script

COMMIT;
