<?php

include 'conexao_oracle.php';
include 'conexao_postgre.php';

$sql = "SELECT COD_CLAMAT,TRANSLATE(DESC_CLAMAT,'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS DESC_CLAMAT,NVL(COD_CLAMAT_PAI,COD_CLAMAT) AS COD_CLAMAT_PAI FROM 
SIGMAT_CLASSIFICACAO_MATERIAL WHERE COD_NIVEL = 2 
OR COD_CLAMAT IN (SELECT DISTINCT COD_CLAMAT FROM SIGMAT_MATERIAL WHERE COD_CLAMAT IN 
(SELECT COD_CLAMAT FROM SIGMAT_CLASSIFICACAO_MATERIAL WHERE COD_NIVEL = 1))";

$sql_parse = OCIParse($conexao_oracle,$sql); 
OCIExecute($sql_parse); 
$aDadosAgrupadosOracle = array();
while (OCIFetch($sql_parse)) {
  
  $dados_oracle = array();
	$aCaracteresNome             = array("'","\"");
	$dados_oracle['COD_CLAMAT']  = OCIResult($sql_parse,"COD_CLAMAT");
	$dados_oracle['DESC_CLAMAT'] = substr(str_replace($aCaracteresNome, "", OCIResult($sql_parse,"DESC_CLAMAT")), 0, 40);
	$dados_oracle['COD_CLAMAT_PAI']  = OCIResult($sql_parse,"COD_CLAMAT_PAI");
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
	
	$rsResult = pg_query($conexao_postgre, "select * from pcsubgrupo WHERE pc04_codsubgrupo = {$aDados['COD_CLAMAT']}");
	
	if (pg_num_rows($rsResult) > 0) {
		
		pg_query($conexao_postgre, "UPDATE pcsubgrupo SET pc04_descrsubgrupo = '{$aDados['DESC_CLAMAT']}', 
		pc04_codgrupo = {$aDados['COD_CLAMAT_PAI']}, pc04_codtipo = {$aDados['COD_CLAMAT_PAI']}, pc04_ativo = 't' 
		WHERE pc04_codsubgrupo = {$aDados['COD_CLAMAT']}");
		
	} else {
	
	  $sSql_insert = "INSERT INTO pcsubgrupo (pc04_codsubgrupo,pc04_descrsubgrupo,pc04_codgrupo,pc04_codtipo,pc04_ativo,
	  pc04_tipoutil) VALUES ({$aDados['COD_CLAMAT']},
	  '{$aDados['DESC_CLAMAT']}',{$aDados['COD_CLAMAT_PAI']},{$aDados['COD_CLAMAT_PAI']},'t',3)";
	  pg_query($conexao_postgre, $sSql_insert);
	  
	}
	
}
$rsResult = pg_query($conexao_postgre, "select * from pcsubgrupo");
while ($dados = pg_fetch_array($rsResult)) {
	echo $dados['pc04_codsubgrupo']."<br>";
}
echo pg_num_rows($rsResult);

?>
