<?php
include 'conexao_postgre.php';

$rsResult = pg_query($conexao_postgre, "select fc_startsession()");
$rsResult = pg_query($conexao_postgre, "select coddepto from db_depart");
while ($dados = pg_fetch_array($rsResult)) {
	pg_query($conexao_postgre, "INSERT INTO db_departorg VALUES ({$dados['coddepto']},2012,1,1)");
}
echo pg_num_rows($rsResult)."<br>";
$rsResult = pg_query($conexao_postgre, "select * from db_departorg");
echo pg_num_rows($rsResult)."<br>";
?>