<?php

include 'conexao_oracle.php';
include 'conexao_postgre.php';
//echo date('Y-m-d', strtotime("01/01/03"));exit;
$sSql = "SELECT sbm.ID_PAT AS COD_BEM,
sbm.COD_PAT AS PLACA,
TRANSLATE(sbm.DESC_BMO,'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS DESC_BEM,
CASE WHEN sbm.COD_CLPAT = 'C' THEN '311010000000000' ELSE sbm.COD_CLPAT END AS COD_CLASSIF,
CASE WHEN sp.cod_pessoa IS NULL THEN 1529 ELSE sp.cod_pessoa END AS COD_FORNEC,
TRANSLATE(sbm.DESC_MODELO,'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS MODELO,
TRANSLATE(sbm.DESC_MARCA,'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS MARCA,
sbm.VR_INICIAL AS VALOR_AQUISICAO,
sbm.DATA_AQUISICAO,
((CASE WHEN sbm.DESC_ADICIONAL IS NOT NULL THEN 
TRANSLATE(sbm.DESC_ADICIONAL,'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') || ', ' END ) || 
(CASE WHEN sbm.DESC_COR IS NOT NULL THEN 
'cor ' || TRANSLATE(sbm.DESC_COR,'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') || ', ' END ) || 
(CASE WHEN sbm.DESC_SERIE IS NOT NULL THEN 
'serie ' || TRANSLATE(sbm.DESC_SERIE,'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') END)) AS OBSERVACAO,
COD_CC_ATUAL AS COD_DEPARTAMENTO,
COD_CBM_ATUAL AS COD_SITUACAO,
CASE WHEN COD_SALA_ATUAL IS NOT NULL THEN COD_SALA_ATUAL || COD_CC_ATUAL ELSE NULL END AS COD_DIVISAO
FROM SICOPT_BEM_MOVEL sbm
LEFT JOIN sicopt_fornecedor sf ON sbm.COD_FORNEC = sf.COD_FORNEC
LEFT JOIN safcit_pessoa sp ON sp.id_pessoa = sf.id_pessoa";

$sql_parse = OCIParse($conexao_oracle,$sSql); 
OCIExecute($sql_parse); 
$aDadosAgrupadosOracle = array();
$aCaracteresNome       = array("'","\"");
while (OCIFetch($sql_parse)) {
	
  $dados_oracle = array();
$acerto_data = explode("/",OCIResult($sql_parse,"DATA_AQUISICAO"));
//print_r($acerto_data);exit;
if ($acerto_data[2] >= 80) {
$acerto_data[2] = "19".$acerto_data[2];
} else {
$acerto_data[2] = "20".$acerto_data[2];
}
	$dados_oracle['COD_BEM']           = OCIResult($sql_parse,"COD_BEM");
	$dados_oracle['PLACA']             = OCIResult($sql_parse,"PLACA");
	$dados_oracle['DESC_BEM']          = substr(str_replace($aCaracteresNome, "", OCIResult($sql_parse,"DESC_BEM")), 0, 100);
	$dados_oracle['COD_CLASSIF']       = OCIResult($sql_parse,"COD_CLASSIF");
	$dados_oracle['COD_FORNEC']        = OCIResult($sql_parse,"COD_FORNEC");
	$dados_oracle['MODELO']            = OCIResult($sql_parse,"MODELO");
	$dados_oracle['MARCA']             = OCIResult($sql_parse,"MARCA");
	$dados_oracle['VALOR_AQUISICAO']   = str_replace(",",".",OCIResult($sql_parse,"VALOR_AQUISICAO"));
$dados_oracle['DATA_AQUISICAO']   = implode("-",$acerto_data);
	$dados_oracle['DATA_AQUISICAO_ANT']    = date('Y-m-d', strtotime(OCIResult($sql_parse,"DATA_AQUISICAO")));
$dados_oracle['DATA_AQUISICAO2']    = OCIResult($sql_parse,"DATA_AQUISICAO");
	$dados_oracle['OBSERVACAO']        = OCIResult($sql_parse,"OBSERVACAO");
	$dados_oracle['COD_DEPARTAMENTO']  = OCIResult($sql_parse,"COD_DEPARTAMENTO");
	$dados_oracle['COD_SITUACAO']      = OCIResult($sql_parse,"COD_SITUACAO");
	$dados_oracle['COD_DIVISAO']       = OCIResult($sql_parse,"COD_DIVISAO");

	$aDadosAgrupadosOracle[]    = $dados_oracle;

}
$i = 0;
foreach ($aDadosAgrupadosOracle as $dados) {
	//echo "{$dados['COD_BEM']} / ".number_format($dados['VALOR_AQUISICAO'],2,".","")." / {$dados['DATA_AQUISICAO']}<br>";
if ($dados['DATA_AQUISICAO_ANT'] != '1969-12-31') {
echo "{$dados['COD_BEM']} | {$dados['PLACA']} | {$dados['DATA_AQUISICAO']} | {$dados['DATA_AQUISICAO2']} | {$dados['DATA_AQUISICAO_ANT']}<br>";
	$i++;
	//echo "<pre>";
	//print_r($dados);exit;
$rsResult = pg_query($conexao_postgre, "SELECT fc_startsession();");
pg_query($conexao_postgre, "UPDATE bens SET t52_dtaqu = '{$dados['DATA_AQUISICAO']}' WHERE t52_bem = {$dados['COD_BEM']}");
}
}
echo $i;exit;

$rsResult = pg_query($conexao_postgre, "SELECT fc_startsession();");

foreach ($aDadosAgrupadosOracle as $aDados) {
//$aDados['VALOR_AQUISICAO'];exit;	
	/**
	 * inserir as marcas e passar o codigo para o array de dados
	 */
	$rsResult = pg_query($conexao_postgre, "SELECT * FROM bensmarca WHERE t65_descricao = '{$aDados['MARCA']}'");
	if (pg_num_rows($rsResult) > 0) {
		
		$dados = pg_fetch_array($rsResult);
		$aDados['MARCA'] = $dados['t65_sequencial'];
		
	} else {
		
		if ($aDados['MARCA'] != '') {
			
			$rsResult = pg_query($conexao_postgre, "SELECT MAX(t65_sequencial)+1 AS sequencial FROM bensmarca");
			$aSequencial = pg_fetch_array($rsResult);
			pg_query($conexao_postgre, "INSERT INTO bensmarca (t65_sequencial,t65_descricao) VALUES ({$aSequencial['sequencial']},'{$aDados['MARCA']}')");
			$rsResult = pg_query($conexao_postgre, "SELECT * FROM bensmarca WHERE t65_descricao = '{$aDados['MARCA']}'");
			$dados = pg_fetch_array($rsResult);
			$aDados['MARCA'] = $dados['t65_sequencial'];
			
		} else {
		  $aDados['MARCA'] = 0;	
		}
		
	}
	
	/**
	 * inserir os modelos e passar o codigo para o array de dados
	 */
	$rsResult = pg_query($conexao_postgre, "SELECT * FROM bensmodelo WHERE t66_descricao = '{$aDados['MODELO']}'");
	if (pg_num_rows($rsResult) > 0) {
		
		$dados = pg_fetch_array($rsResult);
		$aDados['MODELO'] = $dados['t66_sequencial'];
		
	} else {
		
		if ($aDados['MODELO'] != '') {
			
			$rsResult = pg_query($conexao_postgre, "SELECT MAX(t66_sequencial)+1 AS sequencial FROM bensmodelo");
			$aSequencial = pg_fetch_array($rsResult);
			pg_query($conexao_postgre, "INSERT INTO bensmodelo (t66_sequencial,t66_descricao) VALUES ({$aSequencial['sequencial']},'{$aDados['MODELO']}')");
			$rsResult = pg_query($conexao_postgre, "SELECT * FROM bensmodelo WHERE t66_descricao = '{$aDados['MODELO']}'");
			$dados = pg_fetch_array($rsResult);
			$aDados['MODELO'] = $dados['t66_sequencial'];
			
		} else {
			$aDados['MODELO'] = 0;
		}
		
	}
	
	
	$rsResult = pg_query($conexao_postgre, "SELECT * FROM bens WHERE t52_bem = {$aDados['COD_BEM']}");
	
	if (pg_num_rows($rsResult) > 0) {
		
		pg_query($conexao_postgre, "UPDATE bens SET t52_ident = {$aDados['PLACA']}, t52_codcla = {$aDados['COD_CLASSIF']}, t52_numcgm = {$aDados['COD_FORNEC']},
		t52_valaqu = {$aDados['VALOR_AQUISICAO']}, t52_dtaqu = '{$aDados['DATA_AQUISICAO']}', t52_descr = '{$aDados['DESC_BEM']}',
		t52_obs = '{$aDados['OBSERVACAO']}', t52_depart = {$aDados['COD_DEPARTAMENTO']}, t52_instit = 1,
		t52_bensmarca = {$aDados['MARCA']}, t52_bensmodelo = {$aDados['MODELO']} 
		WHERE t52_bem = {$aDados['COD_BEM']}");
		
		if ($aDados['COD_DIVISAO'] != '') {
			pg_query($conexao_postgre, "UPDATE bensdiv SET t33_divisao = {$aDados['COD_DIVISAO']} 
		  WHERE t33_bem = {$aDados['COD_BEM']}");
		}
		
		pg_query($conexao_postgre, "UPDATE histbem SET t56_histbem = {$aDados['COD_BEM']}{$aDados['COD_SITUACAO']},
		t56_data = '".date('Y-m-d')."', t56_depart = {$aDados['COD_DEPARTAMENTO']}, t56_situac = {$aDados['COD_SITUACAO']},
		t56_histor = 'INCLUSAO DE BEM' 
		WHERE t56_codbem = {$aDados['COD_BEM']}");
		
	} else {
	echo "{$aDados['COD_BEM']}<br>";
	  $sSql_insert = "INSERT INTO bens (t52_bem,t52_ident,t52_codcla,t52_numcgm,t52_valaqu,t52_dtaqu,t52_descr,t52_obs,t52_depart,
	  t52_instit,t52_bensmarca,t52_bensmodelo) VALUES ({$aDados['COD_BEM']},{$aDados['PLACA']},{$aDados['COD_CLASSIF']},{$aDados['COD_FORNEC']},
	  {$aDados['VALOR_AQUISICAO']},'{$aDados['DATA_AQUISICAO']}','{$aDados['DESC_BEM']}','{$aDados['OBSERVACAO']}',
	  {$aDados['COD_DEPARTAMENTO']},1,{$aDados['MARCA']},{$aDados['MODELO']})";
	  
//          echo "$sSql_insert";exit;

	  pg_query($conexao_postgre, $sSql_insert);
	  
	  if ($aDados['COD_DIVISAO'] != '') {
	  	
	    $sSql_insert = "INSERT INTO bensdiv (t33_bem,t33_divisao) VALUES ({$aDados['COD_BEM']},{$aDados['COD_DIVISAO']})";
	    pg_query($conexao_postgre, $sSql_insert);
	    
	  }
	  
	  $sSql_insert = "INSERT INTO histbem (t56_codbem,t56_histbem,t56_data,t56_depart,t56_situac,t56_histor) VALUES 
	  ({$aDados['COD_BEM']},{$aDados['COD_BEM']}{$aDados['COD_SITUACAO']},'".date('Y-m-d')."',{$aDados['COD_DEPARTAMENTO']},
	  {$aDados['COD_SITUACAO']},'INCLUSAO DE BEM')";
	  pg_query($conexao_postgre, $sSql_insert);
	  
	}
	
}
echo "<br><br><br>";
$rsResult = pg_query($conexao_postgre, "SELECT * FROM bens");
/*while ($dados = pg_fetch_array($rsResult)) {
	echo $dados['t52_bem']."<br>";
}*/
echo pg_num_rows($rsResult);

?>
