<?

set_time_limit(0);

require("db_fieldsmemory.php");
$DB_USUARIO = "postgres";
$DB_SENHA = "";
$DB_SERVIDOR = "192.168.0.2";
$DB_BASE = "auto_arr_20080426";
$DB_PORTA = "5432";
$DB_SELLER = "on";

echo "Conectando...\n";

if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE  port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA")) )
{
  echo "erro ao conectar...\n";
  exit;
}

$sqlInstit			= "select codigo as instit from db_config order by codigo;";
$rsInstit				= pg_query($conn, $sqlInstit) or die($sqlInstit); 
$iNumRowsInstit = pg_num_rows($rsInstit);

for($iCont=0; $iCont < $iNumRowsInstit; $iCont++ ){

	db_fieldsmemory($rsInstit,$iCont);
	
	pg_exec($conn, "begin;");

	$sSqlInstitDoc  = " select db02_idparag as idparag,                            ";
	$sSqlInstitDoc .= "			   db02_instit  as institparag,                        ";
	$sSqlInstitDoc .= "			   db03_instit  as institdoc                           ";
	$sSqlInstitDoc .= "		from db_paragrafo                                        ";
	$sSqlInstitDoc .= "		  inner join db_docparag  on db02_idparag = db04_idparag ";
	$sSqlInstitDoc .= "		  inner join db_documento on db03_docum   = db04_docum   ";
	$sSqlInstitDoc .= "	 where db03_instit = {$instit}													   ";
	$sSqlInstitDoc .= "	 order by db02_idparag                                     ";
	
	$rsInstitDoc			 = pg_query($sSqlInstitDoc) or die($sSqlInstitDoc);
  $iNumRowsInstitDoc = pg_num_rows($rsInstitDoc); 	

  if($iNumRowsInstitDoc == 0){
	  echo "Não encontrado registros na db_paragrafo da instituição: $instit ";
		pg_exec($conn, "rollback;");
		exit;
	}
  
  for($i=0; $i<$iNumRowsInstitDoc; $i++ ){
		
		db_fieldsmemory($rsInstitDoc,$i);
		
		$sSqlVerificaParag  = " select *						     						";
		$sSqlVerificaParag .= "	  from db_paragrafo									";
		$sSqlVerificaParag .= "	 where db02_idparag = {$idparag} 	  ";
		$sSqlVerificaParag .= "	   and db02_instit  = {$institdoc}  ";

		$rsVerificaParag			 = pg_query($sSqlVerificaParag) or die($sSqlVerificaParag);
		$iNumRowsVerificaParag = pg_num_rows($rsVerificaParag);

		if($iNumRowsVerificaParag > 0){
      echo "db02_idparag = $idparag não alterado para instituição = $institdoc \n";													 
      continue;
    }else{
			$sSqlUpdateParag = " update db_paragrafo set db02_instit = {$institdoc} where db02_idparag = {$idparag}"; 
      echo " Alterado db02_idparag = $idparag para instituição = $institdoc \n";													 
      $rsUpdateParag = pg_query($sSqlUpdateParag) or die($sSqlUpdateParag);
		}
	}
	
  $sSqlUpdateNullParag  = " update db_paragrafo 														 ";
	$sSqlUpdateNullParag .= "    set db02_instit = ( select codigo 						 ";
	$sSqlUpdateNullParag .= "												 from db_config 					 ";
	$sSqlUpdateNullParag .= "												where prefeitura is true ) ";
	$sSqlUpdateNullParag .= " where db02_instit is null     									 ";
  
  $rsUpdateNullParag = pg_query($sSqlUpdateNullParag) or die($sSqlUpdateNullParag) ; 

	pg_exec($conn, "commit;");
	echo "\nConcluído! \n";

}

?>
