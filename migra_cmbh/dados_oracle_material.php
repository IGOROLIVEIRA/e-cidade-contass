<?php
include 'conexao_oracle.php';
include 'conexao_postgre.php';

$sql = "SELECT COD_MATERIAL,TRANSLATE(NOME_MATERIAL,'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS NOME_MATERIAL,
TRANSLATE(nvl(NOME_DETALHADO,NOME_MATERIAL),'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS NOME_DETALHADO,COD_CLAMAT,
DECODE(FLG_ATIVO,'S','t','N','f') AS FLG_ATIVO FROM SIGMAT_MATERIAL";

$sql_parse = OCIParse($conexao_oracle,$sql); 
OCIExecute($sql_parse); 
$aDadosAgrupadosOracle = array();
while (OCIFetch($sql_parse)) {
  
  $dados_oracle = array();
	$aCaracteresNome                = array("'","\"");
	$dados_oracle['COD_MATERIAL']   = OCIResult($sql_parse,"COD_MATERIAL");
	$dados_oracle['NOME_MATERIAL']  = substr(str_replace($aCaracteresNome, "", OCIResult($sql_parse,"NOME_MATERIAL")), 0, 80);
	$dados_oracle['NOME_DETALHADO'] = substr(str_replace($aCaracteresNome, "", OCIResult($sql_parse,"NOME_DETALHADO")),0, 300);
	$dados_oracle['COD_CLAMAT']     = OCIResult($sql_parse,"COD_CLAMAT");
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
	
	$rsResult = pg_query($conexao_postgre, "select * from pcmater WHERE pc01_codmater = {$aDados['COD_MATERIAL']}");
	
	if (pg_num_rows($rsResult) > 0) {
		
		pg_query($conexao_postgre, "UPDATE pcmater SET pc01_descrmater = '{$aDados['NOME_MATERIAL']}', 
		pc01_complmater = '{$aDados['NOME_DETALHADO']}', pc01_codsubgrupo = {$aDados['COD_CLAMAT']}, pc01_ativo = '{$aDados['FLG_ATIVO']}',
		pc01_libaut = 't', pc01_servico = 'f', pc01_veiculo = 'f', pc01_validademinima = 'f'
		WHERE pc01_codmater = {$aDados['COD_MATERIAL']}");
		
	} else {
	
	  $sSql_insert = "INSERT INTO pcmater (pc01_codmater, pc01_descrmater, pc01_complmater, pc01_codsubgrupo, pc01_ativo, 
	  pc01_id_usuario,pc01_libaut, pc01_servico, pc01_veiculo, pc01_validademinima) VALUES ({$aDados['COD_MATERIAL']},
	  '{$aDados['NOME_MATERIAL']}','{$aDados['NOME_DETALHADO']}',{$aDados['COD_CLAMAT']},'{$aDados['FLG_ATIVO']}',1,'t','f','f','f')";
	  pg_query($conexao_postgre, $sSql_insert);
	  //echo "faltava: ".$aDados['COD_MATERIAL']."<br>";
	}
	
}
$rsResult = pg_query($conexao_postgre, "select * from pcmater");
while ($dados = pg_fetch_array($rsResult)) {
	echo $dados['pc01_codmater']."<br>";
}
echo pg_num_rows($rsResult);

?>
