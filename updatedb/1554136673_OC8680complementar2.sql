
-- Ocorrência 8680complementar2
BEGIN;                   
SELECT fc_startsession();

-- Início do script

update db_syscampo set descricao = 'Medida', rotulo='Medida' where codcam = (select codcam from db_syscampo where descricao like '%c224_medida%');

-- Fim do script

COMMIT;

