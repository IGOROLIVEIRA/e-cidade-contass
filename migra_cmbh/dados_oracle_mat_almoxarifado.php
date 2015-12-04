<?php
include 'conexao_oracle.php';
include 'conexao_postgre.php';

$sql = "SELECT COD_MATERIAL,TRANSLATE(NOME_MATERIAL,'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS NOME_MATERIAL,
DECODE(FLG_ATIVO,'S','t','N','f') AS FLG_ATIVO FROM SIGMAT_MATERIAL order by COD_MATERIAL";

$sql_parse = OCIParse($conexao_oracle,$sql); 
OCIExecute($sql_parse); 
$aDadosAgrupadosOracle = array();
while (OCIFetch($sql_parse)) {
  
  $dados_oracle = array();
	$aCaracteresNome                = array("'","\"");
	$dados_oracle['COD_MATERIAL']   = OCIResult($sql_parse,"COD_MATERIAL");
	$dados_oracle['NOME_MATERIAL']  = substr(str_replace($aCaracteresNome, "", OCIResult($sql_parse,"NOME_MATERIAL")), 0, 80);
	$dados_oracle['FLG_ATIVO']      = OCIResult($sql_parse,"FLG_ATIVO");
	$aDadosAgrupadosOracle[] = $dados_oracle;

}
/*$i = 0;
foreach ($aDadosAgrupadosOracle as $dados) {
	echo $dados['NOME_DETALHADO']."<br>";
	$i++;
	//echo "<pre>";
	//print_r($dados);exit;
}
echo $i;exit;*/

$rsResult = pg_query($conexao_postgre, "SELECT fc_startsession();");

foreach ($aDadosAgrupadosOracle as $aDados) {
	
	$rsResult = pg_query($conexao_postgre, "select * from matmater WHERE m60_codmater = {$aDados['COD_MATERIAL']}");
	
	if (pg_num_rows($rsResult) > 0) {
		
		pg_query($conexao_postgre, "UPDATE matmater SET m60_descr = '{$aDados['NOME_MATERIAL']}', 
		m60_codmatunid = 1, m60_quantent = 1, m60_ativo = '{$aDados['FLG_ATIVO']}', m60_controlavalidade = 3
		WHERE m60_codmater = {$aDados['COD_MATERIAL']}");
		
	} else {
	
	  $sSql_insert = "INSERT INTO matmater (m60_codmater, m60_descr, m60_codmatunid, m60_quantent, m60_ativo, 
	  m60_controlavalidade) VALUES ({$aDados['COD_MATERIAL']},'{$aDados['NOME_MATERIAL']}',1,1,'t',3)";
	  pg_query($conexao_postgre, $sSql_insert);
	  //echo "faltava: ".$aDados['COD_MATERIAL']."<br>";
	}
	
}
$rsResult = pg_query($conexao_postgre, "select * from matmater");
while ($dados = pg_fetch_array($rsResult)) {
	echo $dados['m60_codmater']."<br>";
}
echo pg_num_rows($rsResult);

?>
