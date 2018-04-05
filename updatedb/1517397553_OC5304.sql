
-- Ocorrência 5304
BEGIN;
SELECT fc_startsession();

-- Início do script

ALTER TABLE acordoitem ADD COLUMN ac20_valoraditado NUMERIC DEFAULT 0;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'ac20_valoraditado', 'Double', 'Vl Aditado', '', 'Vl Aditado', 1, false, true, false, 0, 'Double', 'Vl Aditado');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('ac20_sequencial')))
    , (select codcam from db_syscampo where nomecam = 'ac20_valoraditado')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('ac20_sequencial'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('ac20_sequencial')))));

-- Fim do script

COMMIT;

BEGIN;
SELECT fc_startsession();

-- Início do script

ALTER TABLE acordoitem ADD COLUMN ac20_quantidadeaditada NUMERIC DEFAULT 0;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'ac20_quantidadeaditada', 'Double', 'Qt Aditado', '', 'Qt Aditado', 1, false, true, false, 0, 'Double', 'Qt Aditado');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('ac20_sequencial')))
    , (select codcam from db_syscampo where nomecam = 'ac20_quantidadeaditada')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('ac20_sequencial'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('ac20_sequencial')))));

-- Fim do script
COMMIT;

BEGIN;
SELECT fc_startsession();

-- Início do script

ALTER TABLE acordoposicao ADD COLUMN ac26_vigenciaalterada character varying(1);

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'ac26_vigenciaalterada', 'Varchar', 'Alt Vigencia', '', 'Alt Vigencia', 1, false, true, false, 0, 'Varchar', 'Alt Vigencia');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('ac26_sequencial')))
    , (select codcam from db_syscampo where nomecam = 'ac26_vigenciaalterada')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('ac26_sequencial'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('ac26_sequencial')))));

-- Fim do script

COMMIT;
