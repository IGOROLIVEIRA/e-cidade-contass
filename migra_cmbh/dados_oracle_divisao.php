<?php

include 'conexao_oracle.php';
include 'conexao_postgre.php';

$sql = "SELECT ss.COD_SALA,TRANSLATE(ss.NOME_SALA,'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS NOME_SALA, 
CASE WHEN ss.FLG_ATIVO = 'N' THEN 'f' ELSE 't' END AS FLG_ATIVO, ssc.COD_CC
FROM sicopt_sala ss
JOIN sicopt_sala_cc ssc ON ss.COD_SALA = ssc.COD_SALA";

$sql_parse = OCIParse($conexao_oracle,$sql); 
OCIExecute($sql_parse); 
$aDadosAgrupadosOracle = array();
$aCaracteresNome       = array("'","\"");
while (OCIFetch($sql_parse)) {
  
  $dados_oracle = array();
	$dados_oracle['COD_SALA']  = OCIResult($sql_parse,"COD_SALA");
	$dados_oracle['NOME_SALA'] = substr(str_replace($aCaracteresNome, "", OCIResult($sql_parse,"NOME_SALA")), 0, 40);
	$dados_oracle['FLG_ATIVO'] = OCIResult($sql_parse,"FLG_ATIVO");
	$dados_oracle['COD_CC'] = OCIResult($sql_parse,"COD_CC");
	$aDadosAgrupadosOracle[] = $dados_oracle;

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

foreach ($aDadosAgrupadosOracle as $aDados) {
	
	$rsResult = pg_query($conexao_postgre, "SELECT * FROM departdiv WHERE t30_codigo = {$aDados['COD_SALA']}{$aDados['COD_CC']}");
	
	if (pg_num_rows($rsResult) > 0) {
		
		pg_query($conexao_postgre, "UPDATE departdiv SET t30_descr = '{$aDados['NOME_SALA']}',t30_depto = {$aDados['COD_CC']},
		t30_ativo = '{$aDados['FLG_ATIVO']}',t30_numcgm = 1529 
		WHERE t30_codigo = {$aDados['COD_SALA']}{$aDados['COD_CC']}");
		
	} else {
	
	  $sSql_insert = "INSERT INTO departdiv (t30_codigo,t30_descr,t30_depto,t30_ativo,t30_numcgm) VALUES ({$aDados['COD_SALA']}{$aDados['COD_CC']},
	  '{$aDados['NOME_SALA']}',{$aDados['COD_CC']},'{$aDados['FLG_ATIVO']}',1529)";
	  pg_query($conexao_postgre, $sSql_insert);
	  
	}
	
}
echo "<br><br><br>";
$rsResult = pg_query($conexao_postgre, "SELECT * FROM departdiv");
while ($dados = pg_fetch_array($rsResult)) {
	echo $dados['t30_codigo']."<br>";
}
echo pg_num_rows($rsResult);

?>
