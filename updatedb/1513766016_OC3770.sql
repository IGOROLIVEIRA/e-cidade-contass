
-- Ocorrência 3770
BEGIN;
SELECT fc_startsession();
-- Início do script
-- CAMPO PARA IDENTIFICAR O ITEM EM pcmater
ALTER TABLE pcmater ADD COLUMN pc01_tabela BOOLEAN DEFAULT FALSE;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'pc01_tabela', 'boolean', 'Código da Tabela', '', 'Cod. Tabela', 1, false, true, false, 0, 'text', 'Cod. Tabela');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('pc01_codmater')))
    , (select codcam from db_syscampo where nomecam = 'pc01_tabela')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('pc01_codmater'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('pc01_codmater')))));
-- Fim do script

COMMIT;

BEGIN;
SELECT fc_startsession();
-- Início do script
-- CAMPO PARA IDENTIFICAR O ITEM EM pcmater
ALTER TABLE pcmater ADD COLUMN pc01_taxa BOOLEAN DEFAULT FALSE;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'pc01_taxa', 'boolean', 'Taxa', '', 'Taxa', 1, false, true, false, 0, 'boolean', 'Taxa');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('pc01_codmater')))
    , (select codcam from db_syscampo where nomecam = 'pc01_taxa')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('pc01_codmater'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('pc01_codmater')))));
-- Fim do script

COMMIT;

BEGIN;
SELECT fc_startsession();
-- Início do script
-- CAMPO PARA IDENTIFICAR O TIPO DE CRITERIO DE ADJUDICACAO
ALTER TABLE pcproc ADD COLUMN pc80_criterioadjudicacao INTEGER;
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'pc80_criterioadjudicacao', 'int4', 'Criterio Adjudicacao', '', 'Criterio Adjudicacao', 10, false, true, false, 0, 'int4', 'Criterio Adjudicacao');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('pc80_codproc')))
    , (select codcam from db_syscampo where nomecam = 'pc80_criterioadjudicacao')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('pc80_codproc'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('pc80_codproc')))));
-- Fim do script

COMMIT;

BEGIN;
SELECT fc_startsession();
-- Início do script
-- CAMPO PARA ARMAZENAR O VALOR DE DESCONTO TABELA OU TAXA
ALTER TABLE pcorcamval ADD COLUMN pc23_perctaxadesctabela DOUBLE PRECISION DEFAULT 0;
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'pc23_perctaxadesctabela', 'int8', 'Desconto', '', 'Desconto', 10, false, true, false, 0, 'int4', 'Desconto');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('pc23_orcamforne')))
    , (select codcam from db_syscampo where nomecam = 'pc23_perctaxadesctabela')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('pc23_orcamforne'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('pc23_orcamforne')))));

-- Fim do script

COMMIT;

BEGIN;
SELECT fc_startsession();
-- Início do script
-- CAMPO EM ITEMPRECOREFERENCIA PARA IDENTIFICAR A MÉDIA PERCENTUAL DE DESCONTO DO ITEM
ALTER TABLE itemprecoreferencia ADD COLUMN si02_vlpercreferencia DOUBLE PRECISION DEFAULT 0;
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'si02_vlpercreferencia', 'int8', 'Percentual Referencia', '', 'Percentual Referencia', 10, false, true, false, 0, 'int4', 'Percentual Referencia');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('si02_sequencial')))
    , (select codcam from db_syscampo where nomecam = 'si02_vlpercreferencia')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('si02_sequencial'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('si02_sequencial')))));

-- Fim do script

COMMIT;

BEGIN;
SELECT fc_startsession();
-- Início do script
-- CAMPO EM EMPAUTORIZA PARA ARMAZENAR O CÓDIGO DA LICITAÇÃO
ALTER TABLE empautoriza ADD COLUMN e54_codlicitacao INTEGER;
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'e54_codlicitacao', 'int8', 'Licitacao', '', 'Licitacao', 10, false, true, false, 0, 'int8', 'Licitacao');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('e54_autori')))
    , (select codcam from db_syscampo where nomecam = 'e54_codlicitacao')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('e54_autori'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('e54_autori')))));

-- Fim do script
COMMIT;

BEGIN;
SELECT fc_startsession();
-- Início do script
-- CAMPO PARA IDENTIFICAR O TIPO DE CRITERIO DE ADJUDICACAO
ALTER TABLE liclicita ADD COLUMN l20_criterioadjudicacao INTEGER;
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'l20_criterioadjudicacao', 'int4', 'Criterio Adjudicacao', '', 'Criterio Adjudicacao', 10, false, true, false, 0, 'int4', 'Criterio Adjudicacao');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('l20_codigo')))
    , (select codcam from db_syscampo where nomecam = 'l20_criterioadjudicacao')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('l20_codigo'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('l20_codigo')))));
-- Fim do script

COMMIT;



