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

$sqlInstit = "select codigo as instit from db_config order by codigo";
$rsInstit  = pg_query($conn, $sqlInstit) or die($sqlInstit); 
$iNumRowsInstit = pg_num_rows($rsInstit);

for($iCont=0; $iCont < $iNumRowsInstit; $iCont++){
db_fieldsmemory($rsInstit,$iCont);

	pg_exec($conn, "begin;");

	$sqlTextos  = " select *														";
	$sqlTextos .= "	  from db_textos										";
	$sqlTextos .= "  where id_instit = $instit				  ";
	$sqlTextos .= "	   and (descrtexto like '%inicial%'	";
	$sqlTextos .= "	    or descrtexto like '%ass_ad%')  ";
	$sqlTextos .= "	 order by descrtexto								";

	$rsTextos = pg_exec($conn, $sqlTextos) or die($sqlTextos);

	if(pg_num_rows($rsTextos) == 0){

		echo "Não existem registros na db_textos para instituição: $instit  \n";
		pg_exec($conn, "rollback");
		continue;

	}

	// -----------------  Inserindo Documento 

	$sqlIdDocumento = " select nextval('db_documento_db03_docum_seq') as iddocumento";
	$rsIdDocumento  = pg_query($conn,$sqlIdDocumento) or die($sqlIdDocumento);

	db_fieldsmemory($rsIdDocumento,0);

	$sqlInsereDocumento  = " insert into db_documento ( db03_docum,																	";
	$sqlInsereDocumento .= "														db03_descr,																	";
	$sqlInsereDocumento .= "														db03_tipodoc,																";
	$sqlInsereDocumento .= "														db03_instit )																";
	$sqlInsereDocumento .= "									 values ( {$iddocumento},'EMISSÃO DE INICIAL',1203,{$instit}) ";

	$rsInsereDocumento  = pg_query($conn,$sqlInsereDocumento) or die($sqlInsereDocumento);




	for ($i=0; $i < pg_num_rows($rsTextos); $i++) {
		
		db_fieldsmemory($rsTextos, $i);
		
	 
	 // -----------------  Procurando Id do Paragrafo

		
		$sqlIdParag = " select nextval('db_paragrafo_db02_idparag_seq') as idparag";
		$rsIdParag  = pg_query($conn,$sqlIdParag) or die($sqlIdParag);
		db_fieldsmemory($rsIdParag,0);

		
	 
	 // -----------------  Inserindo na db_paragrafo
		
		
		if($descrtexto == "inicial_p1" || $descrtexto == "ass_adv1" || $descrtexto == "ass_adv2" ){
			$iInicia = 1;
			$iAltura = 5;
		}else if($descrtexto == "inicial_p2"){
			$iInicia = 1;
			$iAltura = 10;
		}else{
			$iInicia = 45;
			$iAltura = 5;
		}

		echo "\n Inserindo $descrtexto em db_paragrafo da instituição $instit \n";
		
		$sqlInsereParag  = "	insert into db_paragrafo ( db02_idparag,                                                                   ";
		$sqlInsereParag .= "														 db02_descr,			                                                               ";
		$sqlInsereParag .= "														 db02_texto,			                                                               ";
		$sqlInsereParag .= "														 db02_alinha,			                                                               ";
		$sqlInsereParag .= "														 db02_inicia,			                                                               ";
		$sqlInsereParag .= "														 db02_espaca,			                                                               ";
		$sqlInsereParag .= "														 db02_altura,			                                                               ";
		$sqlInsereParag .= "														 db02_largura,		                                                               ";
		$sqlInsereParag .= "														 db02_alinhamento,                                                               ";
		$sqlInsereParag .= "														 db02_tipo, 			                                                               ";
		$sqlInsereParag .= "														 db02_instit )		                                                               ";
		$sqlInsereParag .= "									values   ( {$idparag},'{$descrtexto}','{$conteudotexto}',1,{$iInicia},1,{$iAltura},0,'J',1,{$instit})";

		$rsInsereParag  = pg_query($conn,$sqlInsereParag) or die($sqlInsereParag); 
				

	 
	 
	 // -----------------  Inserindo na db_docparg
		
		echo " Inserindo db04_docum: $iddocumento , db04_idparag: $idparag, db04_ordem:".($i+1)." em db_docparg \n";

		$sqlInsereDocParag  = " insert into db_docparag ( db04_docum,														 ";
		$sqlInsereDocParag .= "													 db04_idparag,													 ";
		$sqlInsereDocParag .= "													 db04_ordem )														 ";
		$sqlInsereDocParag .= "								  values ( {$iddocumento},{$idparag},".($i+1).");  ";
		
		$rsInsereDocParag  = pg_query($conn,$sqlInsereDocParag) or die($sqlInsereDocParag);
	}
  pg_exec($conn, "commit;");
}
echo "\nConcluído! \n";

?>
