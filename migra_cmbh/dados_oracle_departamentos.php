<?php
include 'conexao_oracle.php';
include 'conexao_postgre.php';

$sSql = "SELECT COD_CC,TRANSLATE(NOME_CC,'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS NOME_CC,
CASE WHEN FLG_ATIVO = 'N' THEN '2011-12-31' ELSE NULL END AS LIMITE
FROM sicopt_centro_custo";

$sql_parse = OCIParse($conexao_oracle,$sSql); 
OCIExecute($sql_parse); 
$iCont = 0;
$rsResult = pg_query($conexao_postgre, "SELECT fc_startsession();");
while (OCIFetch($sql_parse)) {
	
  $rsResult = pg_query($conexao_postgre, "SELECT * FROM db_depart WHERE coddepto = ".OCIResult($sql_parse,"COD_CC"));
	
	if (pg_num_rows($rsResult) > 0) {
		
		if (OCIResult($sql_parse,"LIMITE") != '') {
			
	    pg_query($conexao_postgre, "UPDATE db_depart SET descrdepto = '".substr(OCIResult($sql_parse,"NOME_CC"), 0, 40)."', 
		  limite = '".OCIResult($sql_parse,"LIMITE")."', instit = 1 WHERE coddepto = ".OCIResult($sql_parse,"COD_CC"));
	  
		} else {
			
			pg_query($conexao_postgre, "UPDATE db_depart SET descrdepto = '".substr(OCIResult($sql_parse,"NOME_CC"), 0, 40)."', 
		  instit = 1 WHERE coddepto = ".OCIResult($sql_parse,"COD_CC"));
			
		}
		
	} else {
	
		if (OCIResult($sql_parse,"LIMITE") != '') {
			
	    $sSql_insert = "INSERT INTO db_depart (coddepto,descrdepto,limite,instit) VALUES (".OCIResult($sql_parse,"COD_CC").",
	    '".substr(OCIResult($sql_parse,"NOME_CC"), 0, 40)."','".OCIResult($sql_parse,"LIMITE")."',1)";
	    pg_query($conexao_postgre, $sSql_insert);
	  
		} else {
			
			$sSql_insert = "INSERT INTO db_depart (coddepto,descrdepto,instit) VALUES (".OCIResult($sql_parse,"COD_CC").",
	    '".substr(OCIResult($sql_parse,"NOME_CC"), 0, 40)."',1)";
	    pg_query($conexao_postgre, $sSql_insert);
			
		}
	  $iCont++;
	  
	}
	
}

$rsResult = pg_query($conexao_postgre, "SELECT * FROM db_depart");
while ($dados = pg_fetch_array($rsResult)) {
	echo $dados['coddepto']."<br>";
}
echo pg_num_rows($rsResult);

?>