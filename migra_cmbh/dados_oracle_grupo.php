<?php
include 'conexao_oracle.php';
include 'conexao_postgre.php';

//$sql = "SELECT COD_CLAMAT,TRANSLATE(DESC_CLAMAT,'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC')  AS DESC_CLAMAT FROM SIGMAT_CLASSIFICACAO_MATERIAL WHERE COD_NIVEL = 1";
$sql = "SELECT COD_CLAMAT,TRANSLATE(DESC_CLAMAT,'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS DESC_CLAMAT FROM SIGMAT_CLASSIFICACAO_MATERIAL WHERE COD_NIVEL = 1";

$sql_parse = OCIParse($conexao_oracle,$sql); 
OCIExecute($sql_parse); 
$aDadosAgrupadosOracle = array();
while (OCIFetch($sql_parse)) {
  
  $dados_oracle = array();
	$aCaracteresNome             = array("'","\"");
	$dados_oracle['COD_CLAMAT']  = OCIResult($sql_parse,"COD_CLAMAT");
	$dados_oracle['DESC_CLAMAT'] = substr(str_replace($aCaracteresNome, "", OCIResult($sql_parse,"DESC_CLAMAT")), 0, 40);
	$aDadosAgrupadosOracle[] = $dados_oracle;

}
/*$i = 0;
foreach ($aDadosAgrupadosOracle as $dados) {
	echo $dados['DESC_CLAMAT']."<br>";
	$i++;
	//echo "<pre>";
	//print_r($dados);exit;
}
echo $i;exit;*/

$rsResult = pg_query($conexao_postgre, "SELECT fc_startsession();");

foreach ($aDadosAgrupadosOracle as $aDados) {
	
	$rsResult = pg_query($conexao_postgre, "select * from pcgrupo WHERE pc03_codgrupo = {$aDados['COD_CLAMAT']}");
	
	if (pg_num_rows($rsResult) > 0) {
		
		pg_query($conexao_postgre, "UPDATE pcgrupo SET pc03_descrgrupo = '{$aDados['DESC_CLAMAT']}', 
		pc03_ativo = 't' WHERE pc03_codgrupo = {$aDados['COD_CLAMAT']}");
		
	} else {
	
	  $sSql_insert = "INSERT INTO pcgrupo (pc03_codgrupo,pc03_descrgrupo,pc03_ativo) VALUES ({$aDados['COD_CLAMAT']},
	  '{$aDados['DESC_CLAMAT']}','t')";
	  pg_query($conexao_postgre, $sSql_insert);
	  
	}
	
}
$rsResult = pg_query($conexao_postgre, "select * from pcgrupo");
while ($dados = pg_fetch_array($rsResult)) {
	echo $dados['pc03_codgrupo']."<br>";
}
echo pg_num_rows($rsResult);

