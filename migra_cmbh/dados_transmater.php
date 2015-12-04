<?php
include 'conexao_postgre.php';

$rsResult = pg_query($conexao_postgre, "select fc_startsession()");
$rsResult = pg_query($conexao_postgre, "select m60_codmater from matmater");
while ($dados = pg_fetch_array($rsResult)) {
	pg_query($conexao_postgre, "INSERT INTO transmater VALUES ({$dados['m60_codmater']},{$dados['m60_codmater']})");
}
echo pg_num_rows($rsResult)."<br>";
$rsResult = pg_query($conexao_postgre, "select * from transmater");
echo pg_num_rows($rsResult)."<br>";
?>