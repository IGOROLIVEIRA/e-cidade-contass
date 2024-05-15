
-- Ocorrência 8724
BEGIN;
SELECT fc_startsession();

-- Início do script

ALTER TABLE convconvenios ADD COLUMN c206_datacadastro date;
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'c206_datacadastro', 'date', 'Data de cadastro', '', 'Data de cadastro', 10, false, false, false, 1, 'date', 'Data de cadastro');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c206_sequencial') limit 1) order by codarq limit 1)
    , (select codcam from db_syscampo where nomecam = 'c206_datacadastro')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c206_sequencial') limit 1) order by codarq limit 1))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c206_sequencial') limit 1) order by codarq limit 1)));


ALTER TABLE convconvenios ADD COLUMN c206_tipocadastro integer;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'c206_tipocadastro', 'integer', 'Tipo de Recurso', '', 'Tipo de Recurso', 10, false, false, false, 1, 'integer', 'Tipo de Recurso');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c206_sequencial') limit 1) order by codarq limit 1)
    , (select codcam from db_syscampo where nomecam = 'c206_tipocadastro')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c206_sequencial') limit 1) order by codarq limit 1))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c206_sequencial') limit 1) order by codarq limit 1)));

ALTER TABLE convdetalhaconcedentes ADD COLUMN c207_descrconcedente varchar(120);
ALTER TABLE convdetalhaconcedentes ALTER COLUMN c207_descrconcedente SET default '0'::character varying;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'c207_descrconcedente', 'varchar(120)', 'Descrição do Concedente', '', 'Descrição do Concedente', 120, true, false, false, 0, 'text', 'Descrição do Concedente');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c207_sequencial') limit 1) order by codarq limit 1)
    , (select codcam from db_syscampo where nomecam = 'c207_descrconcedente')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c207_sequencial') limit 1) order by codarq limit 1))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('c207_sequencial') limit 1) order by codarq limit 1)));

ALTER TABLE conv102019 RENAME COLUMN si92_dtassinatura TO si92_dataassinatura;

ALTER TABLE conv202019 RENAME COLUMN si94_dtssinaturatermoaditivo TO si94_dtassinaturatermoaditivo;
-- Fim do script

COMMIT;

