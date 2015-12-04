<?php
include 'conexao_postgre.php';

$rsResult = pg_query($conexao_postgre, "select fc_startsession()");

pg_query($conexao_postgre, "INSERT INTO db_itensmenu VALUES (2000022,'Migrar Estoque','Migracao de Estoque','func_migraestoquebh',1,1,'','t')");

pg_query($conexao_postgre, "INSERT INTO db_arquivos VALUES (2000022,'func_migraestoquebh.php','Migracao de Estoque',0)");

pg_query($conexao_postgre, "INSERT INTO db_itensfilho VALUES (2000022,2000022)");

pg_query($conexao_postgre, "INSERT INTO db_menu VALUES (32,2000022,413,1)");

echo "Menus Incluidos";

?>
