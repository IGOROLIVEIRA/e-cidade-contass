
-- Ocorrência 8381
BEGIN;
SELECT fc_startsession();

-- Início do script

ALTER TABLE placaixarec ADD COLUMN k81_convenio integer;

ALTER TABLE placaixarec
ADD CONSTRAINT placaixarec_convenio_fk FOREIGN KEY (k81_convenio)
REFERENCES convconvenios;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'k81_convenio', 'integer', 'Convênio', '', 'Convênio', 11, false, true, false, 0, 'text', 'Convênio');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('k81_codigo') limit 1) order by codarq limit 1)
    , (select codcam from db_syscampo where nomecam = 'k81_convenio')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('k81_codigo') limit 1) order by codarq limit 1))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('k81_codigo') limit 1) order by codarq limit 1)));

-- Fim do script

COMMIT;
