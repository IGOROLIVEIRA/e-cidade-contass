<?php
include 'conexao_oracle.php';
include 'conexao_postgre.php';

$sql = "SELECT COD_MATERIAL,ID_MATERIAL,TRANSLATE(NOME_MATERIAL,'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS NOME_MATERIAL,
TRANSLATE(nvl(NOME_DETALHADO,NOME_MATERIAL),'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS NOME_DETALHADO,COD_CLAMAT,
DECODE(FLG_ATIVO,'S','f','N','t') AS FLG_ATIVO FROM SIGMAT_MATERIAL";

$sql_parse = OCIParse($conexao_oracle,$sql); 
OCIExecute($sql_parse); 
$aDadosAgrupadosOracle = array();
while (OCIFetch($sql_parse)) {
  
  /*$iHash = str_replace(".", "", OCIResult($sql_parse,"ID_MATERIAL"));
	if (isset($aDadosAgrupadosOracle[$iHash])) {
		echo "teste";}*/
		/*$id_material = explode(".", OCIResult($sql_parse,"ID_MATERIAL"));
		if (strlen($id_material[1]) > 1) {
			
			$id_altera = explode(".", $aDadosAgrupadosOracle[$iHash]['ID_MATERIAL_PONTO']);
			$id_altera = $id_altera[0]."0".$id_altera[1].$id_altera[2];
			$aDadosAgrupadosOracle[$iHash]['ID_MATERIAL'] = $id_altera;
			$id_material = str_replace(".", "", OCIResult($sql_parse,"ID_MATERIAL"));
			echo $aDadosAgrupadosOracle[$iHash]['ID_MATERIAL_PONTO']." | $id_altera<br>";
			
		} else {
		  $id_material = $id_material[0]."0".$id_material[1].$id_material[2];	
		  echo OCIResult($sql_parse,"ID_MATERIAL")." | $id_material<br>";
		}
			
	} else {
		$id_material = str_replace(".", "", OCIResult($sql_parse,"ID_MATERIAL"));
	}*/
  $id_material = explode(".", OCIResult($sql_parse,"ID_MATERIAL"));
  $dados_oracle = array();
	$aCaracteresNome                = array("'","\"");
	$dados_oracle['COD_MATERIAL']   = OCIResult($sql_parse,"COD_MATERIAL");
	$dados_oracle['ID_MATERIAL']    = $id_material[0].str_pad($id_material[1], 2, "0", STR_PAD_LEFT).str_pad($id_material[2], 2, "0", STR_PAD_LEFT);
	$dados_oracle['NOME_MATERIAL']  = substr(str_replace($aCaracteresNome, "", OCIResult($sql_parse,"NOME_MATERIAL")), 0, 80);
	$dados_oracle['NOME_DETALHADO'] = substr(str_replace($aCaracteresNome, "", OCIResult($sql_parse,"NOME_DETALHADO")),0, 300);
	$dados_oracle['COD_CLAMAT']     = OCIResult($sql_parse,"COD_CLAMAT");
	$dados_oracle['FLG_ATIVO']      = OCIResult($sql_parse,"FLG_ATIVO");
	$aDadosAgrupadosOracle[] = $dados_oracle;

}
/*$i = 0;
foreach ($aDadosAgrupadosOracle as $dados) {
	if ($dados['ID_MATERIAL'] <= 5216) {
	echo $dados['ID_MATERIAL']." | ".$dados['NOME_DETALHADO']."<br>";
	$i++;
	}
	//echo "<pre>";
	//print_r($dados);exit;
}
echo $i;exit;*/

pg_query($conexao_postgre, "SELECT fc_startsession();");
pg_query($conexao_postgre, "BEGIN;");
pg_query($conexao_postgre, "DELETE FROM matestoqueinimeipm;");
pg_query($conexao_postgre, "DELETE FROM matestoqueinimei;");
pg_query($conexao_postgre, "DELETE FROM matestoqueitem;");
pg_query($conexao_postgre, "DELETE FROM matestoqueini;");
pg_query($conexao_postgre, "DELETE FROM matmaterprecomedio;");
pg_query($conexao_postgre, "DELETE FROM matestoque;");
pg_query($conexao_postgre, "DELETE FROM transmater;");
pg_query($conexao_postgre, "DELETE FROM matmaterunisai;");
pg_query($conexao_postgre, "DELETE FROM far_matersaude;");
pg_query($conexao_postgre, "DELETE FROM matmaterestoque;");
pg_query($conexao_postgre, "DELETE FROM matmatermaterialestoquegrupo;");
pg_query($conexao_postgre, "DELETE FROM matmater;");
$rsResult = pg_query($conexao_postgre, "select * from matmater");
echo pg_num_rows($rsResult)."<br>";
foreach ($aDadosAgrupadosOracle as $aDados) {
	echo $aDados['COD_MATERIAL']." / ".$aDados['ID_MATERIAL']."<br>";
	$sSql_insert = "INSERT INTO matmater (m60_codmater, m60_descr, m60_codmatunid, m60_quantent, m60_ativo, 
	m60_controlavalidade) VALUES ({$aDados['ID_MATERIAL']},'{$aDados['NOME_MATERIAL']}',1,1,'t',3)";
	pg_query($conexao_postgre, $sSql_insert);

	pg_query($conexao_postgre, "INSERT INTO transmater (m63_codmatmater,m63_codpcmater) values ({$aDados['ID_MATERIAL']},
	{$aDados['COD_MATERIAL']})");
	
}

pg_query($conexao_postgre, "COMMIT;");
$rsResult = pg_query($conexao_postgre, "select * from matmater");
while ($dados = pg_fetch_array($rsResult)) {
	echo $dados['m60_codmater']."<br>";
}
echo pg_num_rows($rsResult);

?>
