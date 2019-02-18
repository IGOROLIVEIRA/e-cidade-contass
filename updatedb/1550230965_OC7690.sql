
-- Ocorrência 7690
BEGIN;
SELECT fc_startsession();

-- Início do script

update db_menu set id_item = 9414 where id_item_filho = (select id_item from db_itensmenu where funcao = 'con4_importacaosaldoctbext001.php') and modulo = 209;

-- Fim do script

COMMIT;

