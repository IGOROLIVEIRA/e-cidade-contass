
-- Ocorrência 9265
BEGIN;                   
SELECT fc_startsession();

-- Início do script

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'l12_usuarioadjundica', 'boolean', 'Emitir usuário no relatório de adjudicação', '0', 'Emitir usuário no relatório de adjudicação', 1, false, false, true, 1, 'boolean', 'l12_usuarioadjundica');
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l12_usuarioadjundica'), 6, 0);
ALTER TABLE licitaparam ADD column l12_usuarioadjundica boolean;

-- Fim do script

COMMIT;

