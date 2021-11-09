-- Ocorrência CorrigirTabela-avaliacaogruporespostalotacao
BEGIN;                   
SELECT fc_startsession();

-- Início do script

DROP TABLE public.avaliacaogruporespostalotacao;
SELECT fc_set_pg_search_path();

-- Fim do script

COMMIT;

