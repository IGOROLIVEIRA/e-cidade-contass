
-- Ocorrência 6079
BEGIN;
SELECT fc_startsession();

-- Início do script

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Relatório Financeiro', 'Protocolos', 'pro2_protocolorelfinanceiro001.php', 1, 1, 'Protocolos', 't');
INSERT INTO db_menu VALUES ((select id_item from db_itensmenu where descricao = 'Protocolo' and help = 'Protocolos' and funcao = '' order by id_item desc limit 1)
                            ,(select max(id_item) from db_itensmenu), 3, 604);

-- Fim do script

COMMIT;


