<?php

include 'conexao_oracle.php';
include 'conexao_postgre.php';

$sql = "SELECT distinct COD_CLPAT,TRANSLATE(DESC_CLPAT,'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS DESC_CLPAT 
from sicopt_classif_patrimonial";

$sql_parse = OCIParse($conexao_oracle,$sql); 
OCIExecute($sql_parse); 
$aDadosAgrupadosOracle = array();
$aCaracteresNome       = array("'","\"");
while (OCIFetch($sql_parse)) {
  
  $dados_oracle = array();
	$dados_oracle['COD_CLPAT']  = OCIResult($sql_parse,"COD_CLPAT");
	$dados_oracle['DESC_CLPAT'] = substr(str_replace($aCaracteresNome, "", OCIResult($sql_parse,"DESC_CLPAT")), 0, 40);
	if ($dados_oracle['COD_CLPAT'] == 'C') {
		$dados_oracle['COD_CLPAT'] = '311010000000000';
	}
	$aDadosAgrupadosOracle[]    = $dados_oracle;

}
/*$i = 0;
foreach ($aDadosAgrupadosOracle as $dados) {
	echo $dados['COD_SALA']."<br>";
	$i++;
	//echo "<pre>";
	//print_r($dados);exit;
}
echo $i;exit;*/

$rsResult = pg_query($conexao_postgre, "SELECT fc_startsession();");
$rsResult = pg_query($conexao_postgre, "SELECT case when max(t64_class) is null then '0' else max(t64_class) end as classe from clabens");
$iNumClass = pg_fetch_object($rsResult)->classe;
$iNumClass++;
//echo $sClass;exit;
foreach ($aDadosAgrupadosOracle as $aDados) {
	
	$rsResult = pg_query($conexao_postgre, "SELECT * FROM clabens WHERE t64_codcla = {$aDados['COD_CLPAT']}");
	$sClass = "01001".str_pad($iNumClass, 3, "0", STR_PAD_LEFT);
	
	$iNumClass++;
	if (pg_num_rows($rsResult) > 0) {
			
		pg_query($conexao_postgre, "UPDATE clabens SET t64_descr = '{$aDados['DESC_CLPAT']}',t64_bemtipos = 1,t64_class = '{$sClass}',
		t64_obs = 'OBS',t64_analitica = 't',t64_benstipodepreciacao = 3,t64_vidautil = 5,t64_instit = 1 
		WHERE t64_codcla = {$aDados['COD_CLPAT']}");
		
	} else {
	
	  $sSql_insert = "INSERT INTO clabens (t64_codcla,t64_descr,t64_bemtipos,t64_class,t64_obs,t64_analitica,
	  t64_benstipodepreciacao,t64_vidautil,t64_instit) VALUES ({$aDados['COD_CLPAT']},'{$aDados['DESC_CLPAT']}',1,'{$sClass}','OBS','t',
	  3,5,1)";
	  pg_query($conexao_postgre, $sSql_insert);
	  
	}
	
}
echo "<br><br><br>";
$rsResult = pg_query($conexao_postgre, "SELECT * FROM clabens");
while ($dados = pg_fetch_array($rsResult)) {
	echo $dados['t64_codcla']."<br>";
}
echo pg_num_rows($rsResult);

?>
