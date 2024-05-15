
-- Ocorrência 7690
BEGIN;
SELECT fc_startsession();

-- Início do script

update db_syscampo set tamanho = 9 where nomecam = 'si09_instsiconfi';

update db_syscampo set descricao = 'E-Cidade', rotulo = 'E-Cidade', rotulorel = 'E-Cidade' where nomecam = 'c210_pcaspestrut';
update db_syscampo set descricao = 'MSC', rotulo = 'MSC', rotulorel = 'MSC' where nomecam = 'c210_mscestrut';


-- Fim do script

COMMIT;

