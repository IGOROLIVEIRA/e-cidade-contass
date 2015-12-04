
<?php

include 'conexao_oracle.php';
include 'conexao_postgre.php';

$sql = "SELECT COD_CBM,TRANSLATE(DESC_CONSERVACAO,'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS DESC_CONSERVACAO 
FROM sicopt_conservacao_bem_movel";

$sql_parse = OCIParse($conexao_oracle,$sql); 
OCIExecute($sql_parse); 
$aDadosAgrupadosOracle = array();
$aCaracteresNome       = array("'","\"");
while (OCIFetch($sql_parse)) {
  
  $dados_oracle = array();
	$dados_oracle['COD_CBM']          = OCIResult($sql_parse,"COD_CBM");
	$dados_oracle['DESC_CONSERVACAO'] = substr(str_replace($aCaracteresNome, "", OCIResult($sql_parse,"DESC_CONSERVACAO")), 0, 40);
	$aDadosAgrupadosOracle[] = $dados_oracle;

}
/*$i = 0;
foreach ($aDadosAgrupadosOracle as $dados) {
	echo $dados['DESC_CLAMAT']."<br>";
	$i++;
	//echo "<pre>";
	//print_r($dados);exit;
}
echo $i;*/

$rsResult = pg_query($conexao_postgre, "SELECT fc_startsession();");

foreach ($aDadosAgrupadosOracle as $aDados) {
	
	$rsResult = pg_query($conexao_postgre, "SELECT * FROM situabens WHERE t70_situac = {$aDados['COD_CBM']}");
	
	if (pg_num_rows($rsResult) > 0) {
		
		pg_query($conexao_postgre, "UPDATE situabens SET t70_descr = '{$aDados['DESC_CONSERVACAO']}' 
		WHERE t70_situac = {$aDados['COD_CBM']}");
		
	} else {
	
	  $sSql_insert = "INSERT INTO situabens (t70_situac,t70_descr) VALUES ({$aDados['COD_CBM']},
	  '{$aDados['DESC_CONSERVACAO']}')";
	  pg_query($conexao_postgre, $sSql_insert);
	  
	}
	
}
$rsResult = pg_query($conexao_postgre, "SELECT * from situabens");
while ($dados = pg_fetch_array($rsResult)) {
	echo $dados['t70_situac']."<br>";
}
echo pg_num_rows($rsResult);

?>
