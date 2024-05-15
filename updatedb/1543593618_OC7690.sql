
-- Ocorrência 7690
BEGIN;
SELECT fc_startsession();

-- Início do script

ALTER TABLE conplano ADD COLUMN c60_infcompmsc integer;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'c60_infcompmsc', 'integer', 'Inf. Comp. MSC', '', 'Inf. Comp. MSC', 11, false, true, false, 0, 'text', 'Inf. Comp. MSC');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c60_codcon') limit 1) order by codarq limit 1)
    , (select codcam from db_syscampo where nomecam = 'c60_infcompmsc')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c60_codcon') limit 1) order by codarq limit 1))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c60_codcon') limit 1) order by codarq limit 1)));


-- Fim do script

COMMIT;

