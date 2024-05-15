
-- Ocorrência 4864
BEGIN;
SELECT fc_startsession();

-- Início do script

ALTER TABLE veicmanutitem ADD COLUMN ve63_vlrtot double precision default 0;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 've63_vlrtot', 'float8', 'Valor Total do Item de Manutencao', '', 'Vlr. Total', 15, false, true, false, 4, 'text', 'Vlr. Total');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('ve63_codigo'))), (select codcam from db_syscampo where nomecam = 've63_vlrtot'), 6, 0);

-- Fim do script

COMMIT;

