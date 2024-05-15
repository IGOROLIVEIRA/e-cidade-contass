
-- Ocorrência 5932
BEGIN;
SELECT fc_startsession();

-- Início do script

update db_itensmenu set descricao = 'Licitacao de Outros Orgaos', help = 'Licitacao de Outros Orgaos', desctec = 'Licitacao de Outros Orgaos'
 where descricao = 'Licitacao de Outros Orgao'
  and help = 'Licitacao de Outros Orgao'
  and desctec = 'Licitacao de Outros Orgao';

-- Fim do script

COMMIT;
