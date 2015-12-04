<?php

include 'conexao_oracle.php';
include 'conexao_postgre.php';
//echo date('Y-m-d', strtotime("01/01/03"));exit;
$sSql = "SELECT ID_PAT AS COD_BEM, DATA_BAIXA
FROM SICOPT_BEM_MOVEL WHERE DATA_BAIXA IS NOT NULL";

$sql_parse = OCIParse($conexao_oracle,$sSql); 
OCIExecute($sql_parse); 
$aDadosAgrupadosOracle = array();
while (OCIFetch($sql_parse)) {
	
  $dados_oracle = array();
	$dados_oracle['COD_BEM']    = OCIResult($sql_parse,"COD_BEM");
	$dados_oracle['DATA_BAIXA'] = date('Y-m-d', strtotime(OCIResult($sql_parse,"DATA_BAIXA")));

	$aDadosAgrupadosOracle[]    = $dados_oracle;

}
/*$i = 0;
foreach ($aDadosAgrupadosOracle as $dados) {
	echo "{$dados['COD_BEM']} / {$dados['DATA_BAIXA']} <br>";
	$i++;
	//echo "<pre>";
	//print_r($dados);exit;
}
echo $i;exit;*/

$rsResult = pg_query($conexao_postgre, "SELECT fc_startsession();");

foreach ($aDadosAgrupadosOracle as $aDados) {
	
	$rsResult = pg_query($conexao_postgre, "SELECT * FROM bensbaix WHERE t55_codbem = {$aDados['COD_BEM']}");
	
	if (pg_num_rows($rsResult) > 0) {
		
		pg_query($conexao_postgre, "UPDATE bensbaix SET t55_baixa = '{$aDados['DATA_BAIXA']}'
		WHERE t55_codbem = {$aDados['COD_BEM']}");
		
	} else {
	
	  $sSql_insert = "INSERT INTO bensbaix (t55_codbem,t55_baixa) VALUES ({$aDados['COD_BEM']},'{$aDados['DATA_BAIXA']}')";
	  pg_query($conexao_postgre, $sSql_insert);
	  
	}
	
}
echo "<br><br><br>";
$rsResult = pg_query($conexao_postgre, "SELECT * FROM bensbaix");
/*while ($dados = pg_fetch_array($rsResult)) {
	echo $dados['t52_bem']."<br>";
}*/
echo pg_num_rows($rsResult);

?>
