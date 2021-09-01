<?
die("\n\n Não rodar no cliente \n\n Ja foi migrado os dados no dump_correios.sql\n\n");
// Seta Nome do Script
$sNomeScript = basename(__FILE__);

include(__DIR__ . "/../lib/db_conecta.php");

$bErro = false;

db_log("Aguarde .... \n", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,"truncate table cadenderpais,
                                          cadenderestado,
                                          cadendermunicipio,
                                          cadenderbairro,
                                          cadenderlocal,
                                          cadenderrua,
                                          cadenderbairrocadenderrua,
                                          cgmendereco,
                                          endereco,
                                          cadenderruaruastipo,
                                          cadenderruacep,
                                          cadenderparam;", 
          $sArquivoLog);
          
db_query($pConexaoDestino,"alter SEQUENCE cadenderpais_db70_sequencial_seq restart with 1;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE cadenderestado_db71_sequencial_seq restart with 1;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE cadendermunicipio_db72_sequencial_seq restart with 1;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE cadenderbairro_db73_sequencial_seq restart with 1;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE cadenderrua_db74_sequencial_seq restart with 1;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE cadenderlocal_db75_sequencial_seq restart with 1;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE cadenderruacep_db86_sequencial_seq restart with 1;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE cadenderruaruastipo_db85_sequencial_seq restart with 1;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE endereco_db76_sequencial_seq restart with 1;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE cadenderbairrocadenderrua_db87_sequencial_seq restart with 1;", $sArquivoLog);

db_query($pConexaoDestino,"begin;", $sArquivoLog);
db_query($pConexaoDestino,"insert into cadenderpais values(nextval('cadenderpais_db70_sequencial_seq'),'BRASIL',  'BR');", $sArquivoLog);
db_query($pConexaoDestino,"insert into cadenderestado select nextval('cadenderestado_db71_sequencial_seq'),1,cp03_sigla,cp03_estado from cepestados;", $sArquivoLog);
db_query($pConexaoDestino,"commit;", $sArquivoLog);
//db_query($pConexaoDestino,"truncate table cadendermunicipio on cascade", $sArquivoLog);
db_query($pConexaoDestino,"begin;", $sArquivoLog);
$sQueryEndereco = "
										SELECT distinct
										       log_logradouro.log_nu,
										       log_logradouro.ufe_sg,
										       log_logradouro.loc_nu,
										       log_logradouro.cep,
										       log_logradouro.tlo_tx, 
										       case when tlo_tx = 'Alameda' then 2 
										            when tlo_tx = 'Rua'     then 3 
										            when tlo_tx = 'Avenida' then 4
										            when tlo_tx = 'Travessa'then 5
										            when tlo_tx = 'Praça'   then 7
										            when tlo_tx = 'Rodovia' then 8
										            when tlo_tx = 'Beco'    then 9
										            when tlo_tx = 'Estrada' then 10           
										            else 6 
										       end as iruatipo,
										       log_logradouro.log_no 
										       
										  from log_logradouro
										       										 
										 order by ufe_sg ;
										 ";

//echo "\n\n $sql\n\n";
$loc_nu = "";
$log_nu = "";
$sQueryAtual = "
    SELECT distinct
           log_logradouro.log_nu,
           log_logradouro.ufe_sg,
           log_logradouro.loc_nu,
           log_localidade.loc_no,
           log_bairro.bai_nu,
           log_bairro.bai_no, 
           log_logradouro.cep,
           log_logradouro.tlo_tx,
           cadenderestado.db71_sequencial, 
           cadenderestado.db71_descricao,
           cadendermunicipio.db72_sequencial,
           cadendermunicipio.db72_descricao,
           cadendermunicipio.db72_cadenderestado,
           cadenderbairro.db73_sequencial,
           cadenderbairro.db73_descricao,
           cadenderrua.db74_sequencial,
           cadenderruacep.db86_sequencial,
           case when tlo_tx = 'Alameda' then 2 
                when tlo_tx = 'Rua'     then 3 
                when tlo_tx = 'Avenida' then 4
                when tlo_tx = 'Travessa'then 5
                when tlo_tx = 'Praça'   then 7
                when tlo_tx = 'Rodovia' then 8
                when tlo_tx = 'Beco'    then 9
                when tlo_tx = 'Estrada' then 10           
                else 6 
           end as iruatipo,
           log_logradouro.log_no 
       
      from log_logradouro
           inner join log_localidade    on log_localidade.loc_nu              = log_logradouro.loc_nu
           inner join cadenderestado    on cadenderestado.db71_sigla          = log_logradouro.ufe_sg
           inner join log_bairro        on log_bairro.bai_nu                  = log_logradouro.bai_nu_ini  
           left  join cadendermunicipio on cadendermunicipio.db72_descricao   = log_localidade.loc_no
                                       and cadendermunicipio.db72_cadenderestado = cadenderestado.db71_sequencial                                                 
           left  join cadenderbairro    on cadenderbairro.db73_descricao      = log_bairro.bai_no
                                       and cadenderbairro.db73_cadendermunicipio = cadendermunicipio.db72_sequencial

           left  join cadenderrua       on cadenderrua.db74_descricao         = log_logradouro.log_no 
                                       and cadenderrua.db74_cadendermunicipio = cadendermunicipio.db72_sequencial
           left  join cadenderruacep    on cadenderruacep.db86_cep            = log_logradouro.cep 
                                       and cadenderruacep.db86_cadenderrua    = cadenderrua.db74_sequencial
     where log_logradouro.loc_nu =$1 and log_nu = $2 
     
    ";


$sqlPreparedAtual = pg_prepare('sQueryAtual',$sQueryAtual);     
     
$result = db_query($pConexaoOrigem,$sQueryEndereco, $sArquivoLog) or die($sql);

$iNumReg  = pg_numrows($result);

for($i=0;$i<$iNumReg;$i++){

  echo "processando $i - " . $iNumReg . "\n";
  
  $oEnderAtual = new stdClass();
  $oEnderAtual->db71_sequencial = 0;
  $oEnderAtual->db72_sequencial = 0;
  $oEnderAtual->db73_sequencial = 0;
  $oEnderAtual->db74_sequencial = 0;
  $oEnderAtual->db85_sequencial = 0;
  $oEnderAtual->db86_sequencial = 0;
  
  $oEndereco = db_utils::fieldsMemory($result,$i);
  
  $loc_nu = $oEndereco->loc_nu;
  $log_nu = $oEndereco->log_nu;  
                    
  $resQueryAtual = pg_execute("sQueryAtual", array($loc_nu, $log_nu));
/*
  $sQueryAtual = "
    SELECT distinct
           log_logradouro.log_nu,
           log_logradouro.ufe_sg,
           log_logradouro.loc_nu,
           log_localidade.loc_no,
           log_bairro.bai_nu,
           log_bairro.bai_no, 
           log_logradouro.cep,
           log_logradouro.tlo_tx,
           cadenderestado.db71_sequencial, 

           cadendermunicipio.db72_sequencial,
           cadendermunicipio.db72_descricao,
           cadenderbairro.db73_sequencial,
           cadenderbairro.db73_descricao,
           cadenderrua.db74_sequencial,
           cadenderruacep.db86_sequencial,
           case when tlo_tx = 'Alameda' then 2 
                when tlo_tx = 'Rua'     then 3 
                when tlo_tx = 'Avenida' then 4
                when tlo_tx = 'Travessa'then 5
                when tlo_tx = 'Praça'   then 7
                when tlo_tx = 'Rodovia' then 8
                when tlo_tx = 'Beco'    then 9
                when tlo_tx = 'Estrada' then 10           
                else 6 
           end as iruatipo,
           log_logradouro.log_no 
       
      from log_logradouro
           inner join log_localidade    on log_localidade.loc_nu              = log_logradouro.loc_nu
           inner join log_bairro        on log_bairro.bai_nu                  = log_logradouro.bai_nu_ini  
           left  join cadendermunicipio on cadendermunicipio.db72_descricao   = log_localidade.loc_no  
           left  join cadenderbairro    on cadenderbairro.db73_descricao      = log_bairro.bai_no
           inner join cadenderestado    on cadenderestado.db71_sigla          = log_logradouro.ufe_sg
           left  join cadenderrua       on cadenderrua.db74_descricao         = log_logradouro.log_no 
                                       and cadenderrua.db74_cadendermunicipio = cadendermunicipio.db72_sequencial
           left  join cadenderruacep    on cadenderruacep.db86_cep            = log_logradouro.cep 
                                       and cadenderruacep.db86_cadenderrua    = cadenderrua.db74_sequencial
     where log_logradouro.loc_nu =$loc_nu and log_nu = $log_nu 
     
    ";
  */
  
  //echo "\n". $sQueryAtual ."\n";
  //die($sQueryAtual);
  //$resQueryAtual = db_query($pConexaoDestino,$sQueryAtual, $sArquivoLog) or die($sql);
  
  $iNumRegAtual = pg_num_rows($resQueryAtual);
  if ($iNumRegAtual > 0) {
  	
  	$oEnderecoAtual =  db_utils::fieldsMemory($resQueryAtual,0);
  	
  	//var_dump($oEnderecoAtual);
  	
  	insertCadEnderMunicipio($oEnderecoAtual,$oEnderAtual,$pConexaoDestino);  	
  	insertCadEnderRua($oEnderecoAtual,$oEnderAtual,$pConexaoDestino);
  	insertCadEnderBairro($oEnderecoAtual,$oEnderAtual,$pConexaoDestino);
  	insertCadEnderRuaCep($oEnderecoAtual,$oEnderAtual,$pConexaoDestino);

  	
  	
  } else {
  	
  	db_log("loc_nu = {{$oEndereco->loc_nu}} and log_nu = {{$oEndereco->log_nu}} \n", $sArquivoLog, 1, true, true);
  	
  }
  
  if (($i%1000) == 0) {
  	db_log("comitando $i \n", $sArquivoLog, 1, true, true);
  	db_query($pConexaoDestino,"commit;", $sArquivoLog);
  	db_log("begin......ando \n", $sArquivoLog, 1, true, true);
  	db_query($pConexaoDestino,"begin;", $sArquivoLog);
  }
  
  if (($i%10000) == 0 && $i !=0 ) {
  	db_log("comitando $i \n", $sArquivoLog, 1, true, true);
    db_query($pConexaoDestino,"commit;", $sArquivoLog);
    db_log("VACUUM ANALYZE cadenderrua $i \n", $sArquivoLog, 1, true, true);
    db_query($pConexaoDestino,"VACUUM ANALYZE cadenderrua;", $sArquivoLog);
    db_log("VACUUM ANALYZE cadenderruacep $i \n", $sArquivoLog, 1, true, true);
    db_query($pConexaoDestino,"VACUUM ANALYZE cadenderruacep;", $sArquivoLog);
    db_log("VACUUM ANALYZE cadenderbairro $i \n", $sArquivoLog, 1, true, true);
    db_query($pConexaoDestino,"VACUUM ANALYZE cadenderbairro;", $sArquivoLog);
    db_log("VACUUM ANALYZE cadenderruaruastipo $i \n", $sArquivoLog, 1, true, true);
    db_query($pConexaoDestino,"VACUUM ANALYZE cadenderruaruastipo;", $sArquivoLog);
    db_log("VACUUM ANALYZE cadendermunicipio $i \n", $sArquivoLog, 1, true, true);
    db_query($pConexaoDestino,"VACUUM ANALYZE cadendermunicipio;", $sArquivoLog);
    db_log("VACUUM ANALYZE cadenderbairrocadenderrua $i \n", $sArquivoLog, 1, true, true);
    db_query($pConexaoDestino,"VACUUM ANALYZE cadenderbairrocadenderrua;", $sArquivoLog);
    db_log("begin......ando \n", $sArquivoLog, 1, true, true);
    db_query($pConexaoDestino,"begin;", $sArquivoLog);     
  }
  
  unset($oEnderAtual);
  unset($oEnderecoAtual);
}

$sqlTempTable = "
								CREATE TABLE w_temp_cadender(
								  db72_sequencial int4 default 0,
								  db73_sequencial int4 default 0,
								  db74_sequencial int4 default 0,
								  db75_sequencial int4 default 0,
								  db76_sequencial int4 default 0,
								  db85_sequencial int4 default 0,
								  db86_sequencial int4 default 0,
								  db87_sequencial int4 default 0
								)
  ";
db_log("Criando tabela w_temp_cadender \n", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,$sqlTempTable, $sArquivoLog);
$sqlTempTable = "insert into w_temp_cadender select
  (select max(db72_sequencial)+1 from cadendermunicipio),   
  (select max(db73_sequencial)+1 from cadenderbairro),
  (select max(db74_sequencial)+1 from cadenderrua),
  (select max(db75_sequencial)+1 from cadenderlocal),
  (select max(db76_sequencial)+1 from endereco),
  (select max(db85_sequencial)+1 from cadenderruaruastipo),
  (select max(db86_sequencial)+1 from cadenderruacep),
  (select max(db87_sequencial)+1 from cadenderbairrocadenderrua)  
";


db_log("Populando w_temp_cadender \n", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,$sqlTempTable, $sArquivoLog);

//echo "\n".$sQueryAtual."\n";

if ($bErro) {
    $sOperFim = "rollback";
}else{
    $sOperFim = "commit";
}

db_log("Finalizando transacao [{$sOperFim}]", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino, "{$sOperFim};", $sArquivoLog);

// Final do Script
include(PATH_LIBS."/db_final_script.php");

function insertCadEnderMunicipio($oEnderecoAtual,$oEnderAtual,$conexao) {
  // inseri na cadendermunicipio se
  if ($oEnderecoAtual->db72_sequencial == null or $oEnderecoAtual->db72_sequencial == '') {
		
		$sQueryNextVal = "select nextval('cadendermunicipio_db72_sequencial_seq')";
		$rsQueryNextVal = db_query($conexao,$sQueryNextVal,$sArquivoLog) or die($sQueryNextVal);
		$oNextVal = db_utils::fieldsMemory($rsQueryNextVal,0);
		
		$oEnderAtual->db72_sequencial = $oNextVal->nextval;
		
		$sQueryInsert  = "insert into cadendermunicipio (db72_sequencial, 
		                                                 db72_cadenderestado, 
		                                                 db72_descricao) "; 
		$sQueryInsert .= "                       values ($oEnderAtual->db72_sequencial,
		                                                 $oEnderecoAtual->db71_sequencial,
                                                     '".pg_escape_string($oEnderecoAtual->loc_no)."' 
		                                                 )";
		//echo "\n".$sQueryInsert."\n";
    $rsQueryInsert = db_query($conexao,$sQueryInsert,$sArquivoLog) or die($sQueryInsert);                                                 
    
	} else {
	   
		$oEnderAtual->db72_sequencial = $oEnderecoAtual->db72_sequencial;
	}	
}

function insertCadEnderBairro($oEnderecoAtual,$oEnderAtual,$conexao) {
  // inseri na cadendermunicipio se
  if ($oEnderecoAtual->db73_sequencial == null or $oEnderecoAtual->db73_sequencial == '') {
    
    $sQueryNextVal = "select nextval('cadenderbairro_db73_sequencial_seq')";
    $rsQueryNextVal = db_query($conexao,$sQueryNextVal,$sArquivoLog) or die($sQueryNextVal);
    $oNextVal = db_utils::fieldsMemory($rsQueryNextVal,0);
    
    $oEnderAtual->db73_sequencial = $oNextVal->nextval;
    
    $sQueryInsert  = "insert into cadenderbairro (db73_sequencial, 
                                                  db73_cadendermunicipio, 
                                                  db73_descricao) "; 
    $sQueryInsert .= "                    values ($oEnderAtual->db73_sequencial,
                                                  $oEnderAtual->db72_sequencial,
                                                  '".pg_escape_string($oEnderecoAtual->bai_no)."' 
                                                  )";
    //echo "\n".$sQueryInsert."\n";
    $rsQueryInsert = db_query($conexao,$sQueryInsert,$sArquivoLog) or die($sQueryInsert);                                                 
    /*
    $sQueryInsert  = "insert into cadenderruabairrorua (db87_sequencial, 
                                                       db87_cadenderrua, 
                                                       db87_cadenderruabairro ) "; 
    $sQueryInsert .= "                    values (nextval('cadenderruabairro_db87_sequencial_seq'),
                                                  $oEnderAtual->db74_sequencial,
                                                  $oEnderAtual->db73_sequencial
                                                  )";
    //echo "\n".$sQueryInsert."\n";
    $rsQueryInsert = db_query($conexao,$sQueryInsert,$sArquivoLog) or die($sQueryInsert); 
    */
  } else {
     
    $oEnderAtual->db73_sequencial = $oEnderecoAtual->db73_sequencial;
  }

  //cadenderbairrocadenderrua
  
  $sBairroRua = "select * from cadenderbairrocadenderrua where db87_cadenderrua = $oEnderAtual->db74_sequencial ";
  $sBairroRua .= " and db87_cadenderbairro = $oEnderAtual->db73_sequencial ";
  
  $rsBairroRua = db_query($conexao,$sBairroRua,$sArquivoLog) or die($sBairroRua);
  
  if (pg_num_rows($rsBairroRua) == 0 ) {
  
	  $sQueryInsert  = "insert into cadenderbairrocadenderrua (db87_sequencial, 
	                                                       db87_cadenderrua, 
	                                                       db87_cadenderbairro ) "; 
	    $sQueryInsert .= "                    values (nextval('cadenderbairrocadenderrua_db87_sequencial_seq'),
	                                                  $oEnderAtual->db74_sequencial,
	                                                  $oEnderAtual->db73_sequencial
	                                                  )";
	    //echo "\n".$sQueryInsert."\n";
	    $rsQueryInsert = db_query($conexao,$sQueryInsert,$sArquivoLog) or die($sQueryInsert); 
  } 
}

function insertCadEnderRua($oEnderecoAtual,$oEnderAtual,$conexao) {
  // inseri na cadendermunicipio se
  if ($oEnderecoAtual->db74_sequencial == null or $oEnderecoAtual->db74_sequencial == '') {
    
    $sQueryNextVal = "select nextval('cadenderrua_db74_sequencial_seq')";
    $rsQueryNextVal = db_query($conexao,$sQueryNextVal,$sArquivoLog) or die($sQueryNextVal);
    $oNextVal = db_utils::fieldsMemory($rsQueryNextVal,0);
    
    $oEnderAtual->db74_sequencial = $oNextVal->nextval;
    
    $sQueryInsert  = "insert into cadenderrua (db74_sequencial, 
                                                  db74_cadendermunicipio, 
                                                  db74_descricao) "; 
    $sQueryInsert .= "                    values ($oEnderAtual->db74_sequencial,
                                                  $oEnderAtual->db72_sequencial,
                                                  '".pg_escape_string($oEnderecoAtual->log_no)."' 
                                                  )";
    //echo "\n".$sQueryInsert."\n";
    $rsQueryInsert = db_query($conexao,$sQueryInsert,$sArquivoLog) or die($sQueryInsert);                                                 
    
    $sQueryInsert  = "insert into cadenderruaruastipo (db85_sequencial, 
                                                       db85_cadenderrua, 
                                                       db85_ruastipo ) "; 
    $sQueryInsert .= "                    values (nextval('cadenderruaruastipo_db85_sequencial_seq'),
                                                  $oEnderAtual->db74_sequencial,
                                                  $oEnderecoAtual->iruatipo 
                                                  )";
    //echo "\n".$sQueryInsert."\n";
    $rsQueryInsert = db_query($conexao,$sQueryInsert,$sArquivoLog) or die($sQueryInsert);                                                 
    
    
    
  } else {
     
    $oEnderAtual->db74_sequencial = $oEnderecoAtual->db74_sequencial;
  } 
}

function insertCadEnderRuaCep($oEnderecoAtual,$oEnderAtual,$conexao) {
  // inseri na cadendermunicipio se
  if ($oEnderecoAtual->db86_sequencial == null or $oEnderecoAtual->db86_sequencial == '') {
    
    $sQueryNextVal = "select nextval('cadenderruacep_db86_sequencial_seq')";
    $rsQueryNextVal = db_query($conexao,$sQueryNextVal,$sArquivoLog) or die($sQueryNextVal);
    $oNextVal = db_utils::fieldsMemory($rsQueryNextVal,0);
    
    $oEnderAtual->db86_sequencial = $oNextVal->nextval;
    
    $sQueryInsert  = "insert into cadenderruacep (db86_sequencial, 
                                                  db86_cadenderrua, 
                                                  db86_cep) "; 
    $sQueryInsert .= "                    values ($oEnderAtual->db86_sequencial,
                                                  $oEnderAtual->db74_sequencial,
                                                  '$oEnderecoAtual->cep' 
                                                  )";
    //echo "\n".$sQueryInsert."\n";
    $rsQueryInsert = db_query($conexao,$sQueryInsert,$sArquivoLog) or die($sQueryInsert);                                                 
    
  } else {
     
    $oEnderAtual->db86_sequencial = $oEnderecoAtual->db86_sequencial;
  } 
}

?>
