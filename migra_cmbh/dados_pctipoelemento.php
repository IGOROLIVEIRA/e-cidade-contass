<?php
include 'conexao_postgre.php';

$rsResult = pg_query($conexao_postgre, "select fc_startsession()");
$rsResult = pg_query($conexao_postgre, "select * from pctipo");
while ($dados = pg_fetch_array($rsResult)) {
	pg_query($conexao_postgre, "INSERT INTO pctipoelemento VALUES ({$dados['pc05_codtipo']},2280)");
}
echo pg_num_rows($rsResult)."<br>";
$rsResult = pg_query($conexao_postgre, "select * from pctipoelemento");
echo pg_num_rows($rsResult)."<br>";
?>