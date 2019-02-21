
-- Ocorrência 8546
BEGIN;
SELECT fc_startsession();

-- Início do script

ALTER TABLE consideracoes ALTER COLUMN si171_codarquivo TYPE varchar(10);

ALTER TABLE consideracoes ADD COLUMN si171_anousu integer;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'si171_anousu', 'integer', 'Ano de referência', '', 'Ano de referência', 11, false, true, false, 0, 'int4', 'Ano de referência');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('si171_sequencial') limit 1) order by codarq limit 1)
    , (select codcam from db_syscampo where nomecam = 'si171_anousu')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('si171_sequencial') limit 1) order by codarq limit 1))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('si171_sequencial') limit 1) order by codarq limit 1)));


-- Fim do script

COMMIT;
