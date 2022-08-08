<?

// Seta Nome do Script
$sNomeScript = basename(__FILE__);

include(__DIR__ . "/../lib/db_conecta.php");

$bErro = false;

$aRuas = array();
db_log("Aguarde .... \n", $sArquivoLog, 1, true, true);

//db_query($pConexaoDestino,"select fc_startsession();", $sArquivoLog);

$sQuerySequence = "select * from w_temp_cadender "; 

$rsQuerySequence = db_query($pConexaoDestino, $sQuerySequence, $sArquivoLog);

$oSequence = db_utils::fieldsMemory($rsQuerySequence, 0);

db_query($pConexaoDestino,"begin;", $sArquivoLog);

db_log("deletando cadenderparam registros  \n", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,"truncate cadenderparam ", $sArquivoLog);
db_log("deletando cadenderruaruas registros  \n", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,"delete from cadenderruaruas ", $sArquivoLog);
db_log("deletando cgmendereco \n", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,"delete from cgmendereco ", $sArquivoLog);
db_log("deletando endereco registros >=  $oSequence->db76_sequencial \n", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,"delete from endereco  ", $sArquivoLog);
db_log("deletando cadenderlocal registros >=  $oSequence->db75_sequencial \n", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,"delete from cadenderlocal ", $sArquivoLog);
db_log("deletando cadenderbairrocadenderrua registros >=  $oSequence->db87_sequencial \n", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,"delete from cadenderbairrocadenderrua where db87_sequencial >= $oSequence->db87_sequencial", $sArquivoLog);
db_log("deletando cadenderbairro registros >=  $oSequence->db73_sequencial \n", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,"delete from cadenderbairro    where db73_sequencial >= $oSequence->db73_sequencial", $sArquivoLog);
db_log("deletando cadenderruacep registros >=  $oSequence->db86_sequencial \n", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,"delete from cadenderruacep    where db86_sequencial >= $oSequence->db86_sequencial", $sArquivoLog);
db_log("deletando cadenderruaruastipo registros >=  $oSequence->db85_sequencial \n", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,"delete from cadenderruaruastipo where db85_sequencial >= $oSequence->db85_sequencial", $sArquivoLog);
db_log("deletando cadenderrua registros >=  $oSequence->db74_sequencial \n", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,"delete from cadenderrua       where db74_sequencial >= $oSequence->db74_sequencial", $sArquivoLog);
db_log("deletando cadendermunicipio registros >=  $oSequence->db72_sequencial \n", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,"delete from cadendermunicipio where db72_sequencial >= $oSequence->db72_sequencial", $sArquivoLog);
db_query($pConexaoDestino,"delete from cadenderbairro where db73_sequencial = 0", $sArquivoLog);
db_query($pConexaoDestino,"delete from cadendermunicipio where db72_sequencial = 0", $sArquivoLog);

db_query($pConexaoDestino,"alter SEQUENCE cadenderparam_db99_sequencial_seq restart with 1", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE cadendermunicipio_db72_sequencial_seq restart with $oSequence->db72_sequencial;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE cadenderbairro_db73_sequencial_seq    restart with $oSequence->db73_sequencial;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE cadenderrua_db74_sequencial_seq       restart with $oSequence->db74_sequencial;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE cadenderlocal_db75_sequencial_seq     restart with 1;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE cadenderruacep_db86_sequencial_seq    restart with $oSequence->db86_sequencial;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE cadenderruaruastipo_db85_sequencial_seq restart with $oSequence->db85_sequencial;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE endereco_db76_sequencial_seq          restart with 1;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE cadenderbairrocadenderrua_db87_sequencial_seq restart with $oSequence->db87_sequencial;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE cgmendereco_z07_sequencial_seq restart with 1;", $sArquivoLog);
db_query($pConexaoDestino,"alter SEQUENCE cadenderruaruas_db88_sequencial_seq  restart with 1;", $sArquivoLog);

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
db_log("VACUUM ANALYZE cgmendereco $i \n", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,"VACUUM ANALYZE cgmendereco;", $sArquivoLog);
db_log("VACUUM ANALYZE cadenderruaruas $i \n", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,"VACUUM ANALYZE cadenderruaruas;", $sArquivoLog);



$oMunicBairroNI = new stdClass();

$sqlEstado = "select * from cadenderestado where db71_sigla = 'RS'";
$rsqlEstado = db_query($pConexaoDestino, $sqlEstado, $sArquivoLog) or die($sql);
$iNumEstado = pg_num_rows($rsqlEstado);

if ($iNumEstado > 0) {
	$oEstado = db_utils::fieldsMemory($rsqlEstado,0);
	$oMunicBairroNI->db71_sequencial = $oEstado->db71_sequencial;
	unset($oEstado); 	
}


$sqlMunicNI = "select * from cadendermunicipio where db72_descricao = 'NÃO INFORMADO' AND db72_sigla = 'RS'";
$rsqlMunicNI = db_query($pConexaoDestino, $sqlMunicNI, $sArquivoLog) or die($sql);
$iNumMunicNI = pg_num_rows($rsqlMunicNI);

if ($iNumMunicNI == 0 || $iNumMunicNI === false) {
    $sQueryNextVal = "select nextval('cadendermunicipio_db72_sequencial_seq')";
    $rsQueryNextVal = db_query($pConexaoDestino,$sQueryNextVal,$sArquivoLog) or die($sQueryNextVal);
    $oNextVal = db_utils::fieldsMemory($rsQueryNextVal,0);
    
    $oMunicBairroNI->db72_sequencial = 0;
    $sQueryInsert  = "insert into cadendermunicipio (db72_sequencial, 
                                                     db72_cadenderestado, 
                                                     db72_descricao) "; 
    $sQueryInsert .= "                       values ($oMunicBairroNI->db72_sequencial,
                                                     $oMunicBairroNI->db71_sequencial,
                                                     'NÃO INFORMADO' 
                                                     )";
    //echo "\n".$sQueryInsert."\n";
    $rsQueryInsert = db_query($pConexaoDestino,$sQueryInsert,$sArquivoLog) or die($sQueryInsert);      
    
}

$sqlBairroNI = "select * from cadenderbairro where db73_descricao = 'NÃO INFORMADO' AND db73_cadendermunicipio = ".$oMunicBairroNI->db72_sequencial;
$rsqlBairroNI = db_query($pConexaoDestino, $sqlBairroNI, $sArquivoLog) or die($sql);
$iNumBairroNI = pg_num_rows($rsqlBairroNI);
if ($iNumBairroNI == 0 || $iNumBairroNI === false) {
//    $sQueryNextVal = "select nextval('cadenderbairro_db73_sequencial_seq')";
//    $rsQueryNextVal = db_query($pConexaoDestino,$sQueryNextVal,$sArquivoLog) or die($sQueryNextVal);
//    $oNextVal = db_utils::fieldsMemory($rsQueryNextVal,0);
    
    $oMunicBairroNI->db73_sequencial = 0;
    $sQueryInsert  = "insert into cadenderbairro (db73_sequencial, 
                                                  db73_cadendermunicipio, 
                                                  db73_descricao) "; 
    $sQueryInsert .= "                    values ($oMunicBairroNI->db73_sequencial,
                                                  $oMunicBairroNI->db72_sequencial,
                                                  'NÃO INFORMADO' 
                                                  )";
    //echo "\n".$sQueryInsert."\n";
    $rsQueryInsert = db_query($pConexaoDestino,$sQueryInsert,$sArquivoLog) or die($sQueryInsert);            
    
    
}
//print_r($oMunicBairroNI);
//db_query($pConexaoDestino,"begin;", $sArquivoLog);
//die('Fimmm');
$sqlTempTable = " create table w_temp_cgm_ender (
                      z01_numcgm int4,
										  z01_uf char(2),
										  z01_nome varchar(40),
										  z01_ender varchar(100),
										  z01_numero int4,
										  z01_bairro varchar(40),
										  z01_munic varchar(40),
										  z01_cep char(8),
										  migrado boolean default true
                   )
";
pg_query($pConexaoDestino,"drop table w_temp_cgm_ender");



db_log("begin......ando \n", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,"begin;", $sArquivoLog);
db_log("Criando tabela ", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino,$sqlTempTable, $sArquivoLog);

$sQueryEndereco = "
										SELECT distinct
										       z01_numcgm,
										       z01_uf,
										       trim(z01_nome) as z01_nome,
										       trim(z01_ender) as z01_ender,
										       z01_numero,
										       trim(z01_bairro) as z01_bairro,
										       trim(z01_munic) as z01_munic,
										       trim(z01_cep) as z01_cep,
										       trim(z01_compl) as z01_compl,
										       case when substr(trim(z01_ender),1,7) = 'ALAMEDA'  then 2 
												        when substr(trim(z01_ender),1,3) = 'RUA'      then 3 
												        when substr(trim(z01_ender),1,7) = 'AVENIDA'  then 4
												        when substr(trim(z01_ender),1,2) = 'AV'       then 4
												        when substr(trim(z01_ender),1,8) = 'TRAVESSA' then 5
												        when substr(trim(z01_ender),1,5) = 'PRAÇA'    then 7
												        when substr(trim(z01_ender),1,7) = 'RODOVIA'  then 8
												        when substr(trim(z01_ender),1,2) = 'BR'       then 8
												        when substr(trim(z01_ender),1,3) = 'ROD'      then 8
												        when substr(trim(z01_ender),1,4) = 'BECO'     then 9
												        when substr(trim(z01_ender),1,7) = 'ESTRADA'  then 10           
												        when substr(trim(z01_ender),1,3) = 'EST'  then 10           
												        else 6 
												    end as iruatipo
										       
										   from protocolo.cgm	 			       										 
										 ";
//where cgm.z01_numcgm in( SELECT z01_numcgm from cgm where z01_ender = 'RUA PROFESSOR LUIZ TEIXEIRA');
//where z01_numcgm in(600,1374,313,5090,4976,5641)
$sQueryAtual = "
    SELECT distinct
           z01_numcgm,
           z01_uf,
           trim(z01_munic) as z01_munic,
           trim(z01_bairro) as z01_bairro,
           trim(z01_ender) as z01_ender,
           z01_numero,
           trim(z01_cep) as z01_cep,
           trim(z01_nome) as z01_nome,
           trim(z01_compl) as z01_compl,
           db87_sequencial,
           cadenderestado.db71_sequencial, 
           cadenderestado.db71_descricao,
           cadendermunicipio.db72_sequencial,
           cadendermunicipio.db72_descricao,
           cadendermunicipio.db72_cadenderestado,
           cadenderbairro.db73_sequencial,
           cadenderbairro.db73_descricao,
           cadenderrua.db74_sequencial,
           cadenderruacep.db86_sequencial,
           case when substr(trim(z01_ender),1,7) = 'ALAMEDA'  then 2 
                when substr(trim(z01_ender),1,3) = 'RUA'      then 3 
                when substr(trim(z01_ender),1,7) = 'AVENIDA'  then 4
                when substr(trim(z01_ender),1,2) = 'AV'       then 4
                when substr(trim(z01_ender),1,8) = 'TRAVESSA' then 5
                when substr(trim(z01_ender),1,5) = 'PRAÇA'    then 7
                when substr(trim(z01_ender),1,7) = 'RODOVIA'  then 8
                when substr(trim(z01_ender),1,2) = 'BR'       then 8
                when substr(trim(z01_ender),1,3) = 'ROD'      then 8
                when substr(trim(z01_ender),1,4) = 'BECO'     then 9
                when substr(trim(z01_ender),1,7) = 'ESTRADA'  then 10           
                when substr(trim(z01_ender),1,3) = 'EST'      then 10           
                else 6 
            end as iruatipo
                 
      from cgm 
           
           left join cadenderestado    on cadenderestado.db71_sigla             = case when cgm.z01_uf = '' then 'RS'::char(2)
                                                                                        when upper(cgm.z01_uf) = 'NI' then 'RS'::char(2)   
                                                                                        else cgm.z01_uf::char(2)
                                                                                   end 
           left  join cadendermunicipio on cadendermunicipio.db72_descricao      = trim(cgm.z01_munic)
                                       and cadendermunicipio.db72_cadenderestado = cadenderestado.db71_sequencial                                                 
           left  join cadenderbairro    on cadenderbairro.db73_descricao         = trim(cgm.z01_bairro) 
                                       and cadenderbairro.db73_cadendermunicipio = cadendermunicipio.db72_sequencial
           left  join cadenderrua       on cadenderrua.db74_descricao            = trim(cgm.z01_ender) 
                                       and cadenderrua.db74_cadendermunicipio    = cadendermunicipio.db72_sequencial
           left  join cadenderbairrocadenderrua on db87_cadenderrua              = db74_sequencial
                                       and db87_cadenderbairro                   = db73_sequencial
           left  join cadenderruacep    on cadenderruacep.db86_cep               = cgm.z01_cep 
                                       and cadenderruacep.db86_cadenderrua       = cadenderrua.db74_sequencial
     where cgm.z01_numcgm = $1  
     
    ";

$sqlPreparedAtual = pg_prepare('sQueryAtual', $sQueryAtual);     
     
$result = db_query($pConexaoDestino,$sQueryEndereco, $sArquivoLog) or die($sQueryEndereco);

$iNumReg  = pg_numrows($result);

for ($i = 0; $i < $iNumReg; $i++) {

  echo "processando $i - " . $iNumReg . "\n";
  
  $oEnderAtual = new stdClass();
  $oEnderAtual->db71_sequencial = 0;
  $oEnderAtual->db72_sequencial = 0;
  $oEnderAtual->db73_sequencial = 0;
  $oEnderAtual->db74_sequencial = 0;
  $oEnderAtual->db85_sequencial = 0;
  $oEnderAtual->db86_sequencial = 0;
  
  $oEndereco = db_utils::fieldsMemory($result,$i);
  $resQueryAtual = pg_execute("sQueryAtual", array($oEndereco->z01_numcgm));
  
  $iNumRegAtual = pg_num_rows($resQueryAtual);
  if ($iNumRegAtual > 0) {
    
    $oEnderecoAtual =  db_utils::fieldsMemory($resQueryAtual,0);
  }
    
  if (($oEndereco->z01_uf == "" || $oEndereco->z01_munic == "" || $oEndereco->z01_bairro == "") && trim($oEndereco->z01_ender) != "" ) {
  	//Estado RS, Municipio = NI e Bairro = NI
    db_log("CGM [{$oEndereco->z01_numcgm}] incluído como Não Informado \n", $sArquivoLog, 1, true, true);
    if ( empty($oEnderecoAtual->db71_sequencial) ) {
      $oEnderecoAtual->db71_sequencial = $oMunicBairroNI->db71_sequencial;
    }
    $oEnderecoAtual->db71_sequencial = $oMunicBairroNI->db71_sequencial;
    $oEnderecoAtual->db72_sequencial = $oMunicBairroNI->db72_sequencial;
    $oEnderecoAtual->db73_sequencial = $oMunicBairroNI->db73_sequencial;
    insertCadEnderMunicipio($oEnderecoAtual,$oEnderAtual,$pConexaoDestino,$sArquivoLog);   
    insertCadEnderRua($oEnderecoAtual,$oEnderAtual,$pConexaoDestino,$sArquivoLog);
    insertCadEnderBairro($oEnderecoAtual,$oEnderAtual,$pConexaoDestino,$sArquivoLog);
    //insertCadEnderRuaCep($oEnderecoAtual,$oEnderAtual,$pConexaoDestino);
    insertCadEnderLocal($oEnderecoAtual,$oEnderAtual,$pConexaoDestino,$sArquivoLog);
    insertEndereco($oEnderecoAtual,$oEnderAtual,$pConexaoDestino,$sArquivoLog);
    insertCgmEndereco($oEnderecoAtual,$oEnderAtual,$pConexaoDestino,$sArquivoLog);
    
    insertWtempCgmEnder($oEndereco,$pConexaoDestino,'t',$sArquivoLog);
  	
  } else if ($oEndereco->z01_uf != "" && $oEndereco->z01_munic != "" 
             && $oEndereco->z01_bairro != "" && trim($oEndereco->z01_ender) != "") {
    //Se tem migra senao inseri
    
  	db_log("CGM [{$oEndereco->z01_numcgm}] incluído \n", $sArquivoLog, 1, true, true);
  	
  	
  	if ( empty($oEnderecoAtual->db71_sequencial) ) {
  		$oEnderecoAtual->db71_sequencial = $oMunicBairroNI->db71_sequencial;
  	}
  	insertCadEnderMunicipio($oEnderecoAtual,$oEnderAtual,$pConexaoDestino,$sArquivoLog);   
    insertCadEnderRua($oEnderecoAtual,$oEnderAtual,$pConexaoDestino,$sArquivoLog);
    insertCadEnderBairro($oEnderecoAtual,$oEnderAtual,$pConexaoDestino,$sArquivoLog);
    insertCadEnderLocal($oEnderecoAtual,$oEnderAtual,$pConexaoDestino,$sArquivoLog);
    insertEndereco($oEnderecoAtual,$oEnderAtual,$pConexaoDestino,$sArquivoLog);
    insertCgmEndereco($oEnderecoAtual,$oEnderAtual,$pConexaoDestino,$sArquivoLog);
    
  } else {
  	db_log("CGM [{$oEndereco->z01_numcgm}] não incluído \n", $sArquivoLog, 1, true, true);
  	insertWtempCgmEnder($oEndereco,$pConexaoDestino,'f',$sArquivoLog);
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
/*
$sQueryImobiliario = "
      insert into cadenderruaruas
       select nextval('cadenderruaruas_db88_sequencial_seq'),
              db74_sequencial,
              j14_codigo
         from cgmendereco        
              inner join db_cgmruas on z07_numcgm = z01_numcgm
              inner join endereco   on db76_sequencial = z07_endereco
              inner join cadenderlocal on db76_cadenderlocal = db75_sequencial
              inner join cadenderbairrocadenderrua on  db87_sequencial = db75_cadenderbairrocadenderrua        
              inner join cadenderrua on db74_sequencial = db87_cadenderrua ;
";
*/
$sQueryImobiliario = "
  insert into cadenderruaruas
    select nextval('cadenderruaruas_db88_sequencial_seq'),
           db74_sequencial,
           j14_codigo
      from ( select distinct
                    db74_sequencial,
                    j14_codigo
		           from cgmendereco        
		                inner join cgm  on cgm.z01_numcgm = z07_numcgm
		                inner join ruas on upper(trim(ruas.j14_nome))  = upper(trim(z01_ender))
		                inner join endereco   on db76_sequencial = z07_endereco
		                inner join cadenderlocal on db76_cadenderlocal = db75_sequencial
		                inner join cadenderbairrocadenderrua on  db87_sequencial = db75_cadenderbairrocadenderrua        
		                inner join cadenderrua on db74_sequencial = db87_cadenderrua 
		       ) as x
  ";

db_query($pConexaoDestino,$sQueryImobiliario, $sArquivoLog);
/*
foreach ($aRuas as $oRua) {
	
	if ($oRua->z01_ender == 'RUA PROFESSOR LUIZ TEIXEIRA') {
		
    print_r($oRua);		
	}
}
*/
if ($bErro) {
    $sOperFim = "rollback";
}else{
    $sOperFim = "commit";
}

db_log("Finalizando transacao [{$sOperFim}]", $sArquivoLog, 1, true, true);
db_query($pConexaoDestino, "{$sOperFim};", $sArquivoLog);

db_log("\nInserindo na cadenderparam\n", $sArquivoLog, 1, true, true);
insertCadEnderParametros($pConexaoDestino,$sArquivoLog);
// Final do Script
include(PATH_LIBS."/db_final_script.php");

function insertCadEnderMunicipio($oEnderecoAtual, $oEnderAtual, $conexao, $sArquivoLog) {
  // inseri na cadendermunicipio se
  
	$sQueryMunicipio = " select db72_sequencial 
	                       from cadendermunicipio 
	                      where db72_cadenderestado = ".$oEnderecoAtual->db71_sequencial ." and
	                      trim(db72_descricao) = '".addslashes(trim($oEnderecoAtual->z01_munic))."'";
	
	$rsQueryMunicipio = db_query($conexao,$sQueryMunicipio,$sArquivoLog) or die($sQueryMunicipio);
	if (pg_num_rows($rsQueryMunicipio) > 0) {
		
		$oMunicipio = db_utils::fieldsMemory($rsQueryMunicipio,0);
		$oEnderAtual->db72_sequencial = $oMunicipio->db72_sequencial;
	} else {
		
		if (trim($oEnderecoAtual->z01_munic) == "" ) {
			$oEnderAtual->db72_sequencial = 0;
		} else {
		
	  	$sQueryNextVal = "select nextval('cadendermunicipio_db72_sequencial_seq')";
			$rsQueryNextVal = db_query($conexao,$sQueryNextVal,$sArquivoLog) or die($sQueryNextVal);
			$oNextVal = db_utils::fieldsMemory($rsQueryNextVal,0);
			
			
			$oEnderAtual->db72_sequencial = $oNextVal->nextval;
			
			$sQueryInsert  = "insert into cadendermunicipio (db72_sequencial, 
			                                                 db72_cadenderestado, 
			                                                 db72_descricao) "; 
			$sQueryInsert .= "                       values ($oEnderAtual->db72_sequencial,
			                                                 $oEnderecoAtual->db71_sequencial,
	                                                     '".pg_escape_string($oEnderecoAtual->z01_munic)."' 
			                                                 )";
			//echo "\n".$sQueryInsert."\n";
	    $rsQueryInsert = db_query($conexao,$sQueryInsert,$sArquivoLog) or die($sQueryInsert);
		}                                                 
    
	} 
}

function insertCadEnderBairro($oEnderecoAtual,$oEnderAtual,$conexao,$sArquivoLog) {
  // inseri na cadendermunicipio se
  
  if (empty($oEnderecoAtual->db73_sequencial)) {
  	
  	if (trim($oEnderecoAtual->z01_bairro) == "") {
  		
  	   $oEnderAtual->db73_sequencial = 0;	
  	} else {
	    $sQueryNextVal = "select nextval('cadenderbairro_db73_sequencial_seq')";
	    $rsQueryNextVal = db_query($conexao,$sQueryNextVal,$sArquivoLog) or die($sQueryNextVal);
	    $oNextVal = db_utils::fieldsMemory($rsQueryNextVal,0);
	    
	    $oEnderAtual->db73_sequencial = $oNextVal->nextval;
	    
	    $sQueryInsert  = "insert into cadenderbairro (db73_sequencial, 
	                                                  db73_cadendermunicipio, 
	                                                  db73_descricao) "; 
	    $sQueryInsert .= "                    values ($oEnderAtual->db73_sequencial,
	                                                  $oEnderAtual->db72_sequencial,
	                                                  '".pg_escape_string($oEnderecoAtual->z01_bairro)."' 
	                                                  )";
	    $rsQueryInsert = db_query($conexao,$sQueryInsert,$sArquivoLog) or die($sQueryInsert);
  	}                                                 
  } else {
     
    $oEnderAtual->db73_sequencial = $oEnderecoAtual->db73_sequencial;
  }
  
  $sBairroRua = "select * from cadenderbairrocadenderrua where db87_cadenderrua = $oEnderAtual->db74_sequencial ";
  $sBairroRua .= " and db87_cadenderbairro = $oEnderAtual->db73_sequencial ";
  $rsBairroRua = db_query($conexao,$sBairroRua,$sArquivoLog) or die($sBairroRua);
  
  if (pg_num_rows($rsBairroRua) == 0 ) {
  
  	$sQueryNextVal = "select nextval('cadenderbairrocadenderrua_db87_sequencial_seq')";
    $rsQueryNextVal = db_query($conexao,$sQueryNextVal,$sArquivoLog) or die($sQueryNextVal);
    $oNextVal = db_utils::fieldsMemory($rsQueryNextVal,0);
    
    $oEnderAtual->db87_sequencial = $oNextVal->nextval;
  	
  	
	  $sQueryInsert  = "insert into cadenderbairrocadenderrua (db87_sequencial, 
	                                                       db87_cadenderrua, 
	                                                       db87_cadenderbairro ) "; 
	    $sQueryInsert .= "                    values ($oEnderAtual->db87_sequencial,
	                                                  $oEnderAtual->db74_sequencial,
	                                                  $oEnderAtual->db73_sequencial
	                                                  )";
	    //echo "\n".$sQueryInsert."\n";
	    $rsQueryInsert = db_query($conexao,$sQueryInsert,$sArquivoLog) or die($sQueryInsert); 
  } else {

  	$oBairroRua = db_utils::fieldsMemory($rsBairroRua,0);
  	$oEnderAtual->db87_sequencial = $oBairroRua->db87_sequencial;
  }
}

function insertCadEnderRua($oEnderecoAtual,$oEnderAtual,$conexao,$sArquivoLog) {
  // inseri na cadendermunicipio se
  
	
  //global $aRuas;
  if (empty($oEnderecoAtual->db74_sequencial)) {

  	$sSqlCodigoRua  = "select db74_sequencial ";
  	$sSqlCodigoRua .= "  from cadenderrua ";
  	$sSqlCodigoRua .= " where db74_descricao = '".addslashes($oEnderecoAtual->z01_ender)."'";
  	$sSqlCodigoRua .= "   and db74_cadendermunicipio = {$oEnderAtual->db72_sequencial}";
  	$rsCodigoMunicipio = db_query($conexao, $sSqlCodigoRua);
  	if (pg_numrows($rsCodigoMunicipio) > 0) {

  		$oEnderAtual->db74_sequencial = db_utils::fieldsMemory($rsCodigoMunicipio, 0)->db74_sequencial;
  	} else {
  		
	  	$sQueryNextVal = "select nextval('cadenderrua_db74_sequencial_seq')";
	    $rsQueryNextVal = db_query($conexao,$sQueryNextVal,$sArquivoLog) or die($sQueryNextVal);
	    $oNextVal = db_utils::fieldsMemory($rsQueryNextVal,0);
	    
	    $oEnderAtual->db74_sequencial = $oNextVal->nextval;
	    
	    $sQueryInsert  = "insert into cadenderrua (db74_sequencial, 
	                                                  db74_cadendermunicipio, 
	                                                  db74_descricao) "; 
	    $sQueryInsert .= "                    values ($oEnderAtual->db74_sequencial,
	                                                  $oEnderAtual->db72_sequencial,
	                                                  '".addslashes($oEnderecoAtual->z01_ender)."' 
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
    
  	}
    
  } else {
    //echo "\n no else db74_sequencial =   $oEnderecoAtual->db74_sequencial \n";
    $oEnderAtual->db74_sequencial = $oEnderecoAtual->db74_sequencial;
  }
  $oEnderecoAtual->codigoruaatual  = $oEnderAtual->db74_sequencial;  
  $aRuas[] = $oEnderecoAtual; 
}

function insertCadEnderRuaCep($oEnderecoAtual,$oEnderAtual,$conexao,$sArquivoLog) {
  
	// inseri na cadendermunicipio se
  if (empty($oEnderecoAtual->db86_sequencial)) {
    
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

function insertCadEnderLocal($oEnderecoAtual,$oEnderAtual,$conexao,$sArquivoLog) {
  // inseri na cadendermunicipio se
  
    
    $sQueryNextVal = "select nextval('cadenderlocal_db75_sequencial_seq')";
    $rsQueryNextVal = db_query($conexao,$sQueryNextVal,$sArquivoLog) or die($sQueryNextVal);
    $oNextVal = db_utils::fieldsMemory($rsQueryNextVal,0);
    
    $oEnderAtual->db75_sequencial = $oNextVal->nextval;
    
    $sQueryInsert  = "insert into cadenderlocal (db75_sequencial, 
                                                  db75_cadenderbairrocadenderrua, 
                                                  db75_numero) "; 
    $sQueryInsert .= "                    values ($oEnderAtual->db75_sequencial,
                                                  $oEnderAtual->db87_sequencial,
                                                  '$oEnderecoAtual->z01_numero' 
                                                  )";
    //echo "\n".$sQueryInsert."\n";
    $rsQueryInsert = db_query($conexao,$sQueryInsert,$sArquivoLog) or die($sQueryInsert);      
     
    $oEnderAtual->db75_sequencial = $oEnderAtual->db75_sequencial;
   
}

function insertEndereco($oEnderecoAtual,$oEnderAtual,$conexao,$sArquivoLog) {
  // inseri na cadendermunicipio se
  
    
    $sQueryNextVal = "select nextval('endereco_db76_sequencial_seq')";
    $rsQueryNextVal = db_query($conexao,$sQueryNextVal,$sArquivoLog) or die($sQueryNextVal);
    $oNextVal = db_utils::fieldsMemory($rsQueryNextVal,0);
    
    $oEnderAtual->db76_sequencial = $oNextVal->nextval;
    
    $sQueryInsert  = "insert into endereco (db76_sequencial, 
                                            db76_cadenderlocal,
                                            db76_cep,
                                            db76_complemento ) "; 
    $sQueryInsert .= "                    values ($oEnderAtual->db76_sequencial,
                                                  $oEnderAtual->db75_sequencial,
                                                  '$oEnderecoAtual->z01_cep', 
                                                  '".pg_escape_string($oEnderecoAtual->z01_compl)."' 
                                                  )";
    //echo "\n".$sQueryInsert."\n";
    $rsQueryInsert = db_query($conexao,$sQueryInsert,$sArquivoLog) or die($sQueryInsert);                                                 
     
  // $oEnderAtual->db76_sequencial = $oEnderecoAtual->db76_sequencial;
   
}

function insertCgmEndereco($oEnderecoAtual,$oEnderAtual,$conexao,$sArquivoLog) {
  // inseri na cadendermunicipio se
    
    $sQueryNextVal = "select nextval('cgmendereco_z07_sequencial_seq')";
    $rsQueryNextVal = db_query($conexao,$sQueryNextVal,$sArquivoLog) or die($sQueryNextVal);
    $oNextVal = db_utils::fieldsMemory($rsQueryNextVal,0);
    
    $oEnderAtual->z07_sequencial = $oNextVal->nextval;
    
    $sQueryInsert  = "insert into cgmendereco (z07_sequencial, 
                                               z07_endereco,
                                               z07_numcgm,
                                               z07_tipo 
                                            ) "; 
    $sQueryInsert .= "                    values ($oEnderAtual->z07_sequencial,
                                                  $oEnderAtual->db76_sequencial,
                                                  $oEnderecoAtual->z01_numcgm,
                                                  'P' 
                                                  )";
    //echo "\n".$sQueryInsert."\n";
    $rsQueryInsert = db_query($conexao,$sQueryInsert,$sArquivoLog) or die($sQueryInsert);                                       
     
   
}



function insertWtempCgmEnder($oEndereco, $conexao, $migrado='t',$sArquivoLog) {
      
  $sQueryInsert  = "insert into w_temp_cgm_ender (
                                                  z01_numcgm,
																								  z01_uf,
																								  z01_nome,
																								  z01_ender,
																								  z01_numero,
																								  z01_bairro,
																								  z01_munic,
																								  z01_cep,
																								  migrado  
       
                                                  ) "; 
  $sQueryInsert .= "                    values ( $oEndereco->z01_numcgm,
                                                '$oEndereco->z01_uf',
                                                '".pg_escape_string($oEndereco->z01_nome)."',
                                                '".pg_escape_string($oEndereco->z01_ender)."',
                                                 $oEndereco->z01_numero,
                                                '".pg_escape_string($oEndereco->z01_bairro)."',
                                                '".pg_escape_string($oEndereco->z01_munic)."',
                                                '$oEndereco->z01_cep',
                                                '$migrado'
                                                
                                               )";
    //echo "\n".$sQueryInsert."\n";
  $rsQueryInsert = db_query($conexao,$sQueryInsert,$sArquivoLog) or die($sQueryInsert);                                                 
    
   
}

function insertCadEnderParametros($conexao,$sArquivoLog) {
      
  $sQueryParametros  = " select  db70_sequencial, ";
  $sQueryParametros .= "         db71_sequencial,  ";
  $sQueryParametros .= "         db72_sequencial  ";
  $sQueryParametros .= "    from cadendermunicipio   ";
  $sQueryParametros .= "         inner join cadenderestado on db71_sequencial = db72_cadenderestado ";
  $sQueryParametros .= "         inner join cadenderpais   on db70_sequencial = db71_cadenderpais   ";
  $sQueryParametros .= "         where trim(db72_descricao) in (select trim(munic) from db_config where prefeitura is true) ";
 	//echo $sQueryParametros;
  $rsQueryParametros = db_query($conexao,$sQueryParametros,$sArquivoLog) or die($sQueryParametros);
  
  if (pg_num_rows($rsQueryParametros) > 0) {
  	
  	$oParam = db_utils::fieldsMemory($rsQueryParametros,0);
  	
  	//print_r($oParam);
  	
  	$sInsertParam = " insert into cadenderparam (db99_sequencial,db99_cadenderpais,db99_cadenderestado,db99_cadendermunicipio) ";
  	$sInsertParam .= " values (nextval('cadenderparam_db99_sequencial_seq'),
  	                                   $oParam->db70_sequencial,
  	                                   $oParam->db71_sequencial,
  	                                   $oParam->db72_sequencial) ";
  	$rsInsertParam = db_query($conexao,$sInsertParam,$sArquivoLog) or die($sInsertParam);
  }else{
    
  	$sQueryParametros  = " select  db70_sequencial, ";
    $sQueryParametros .= "         db71_sequencial,  ";
    $sQueryParametros .= "         db72_sequencial  ";
    $sQueryParametros .= "    from cadendermunicipio   ";
    $sQueryParametros .= "         inner join cadenderestado on db71_sequencial = db72_cadenderestado ";
    $sQueryParametros .= "         inner join cadenderpais   on db70_sequencial = db71_cadenderpais   ";
    $sQueryParametros .= "         where trim(db72_descricao) in (select trim(munic) from db_config limit 1) ";
    //echo $sQueryParametros;
    $rsQueryParametros = db_query($conexao,$sQueryParametros,$sArquivoLog) or die($sQueryParametros);
    if (pg_num_rows($rsQueryParametros) > 0) {
    
	    $oParam = db_utils::fieldsMemory($rsQueryParametros,0);
	    $sInsertParam = " insert into cadenderparam (db99_sequencial,db99_cadenderpais,db99_cadenderestado,db99_cadendermunicipio) ";
	    $sInsertParam .= " values (nextval('cadenderparam_db99_sequencial_seq'),
	                                       $oParam->db70_seqeuncial,
	                                       $oParam->db71_seqeuncial,
	                                       $oParam->db72_seqeuncial) ";
	    $rsInsertParam = db_query($conexao,$sInsertParam,$sArquivoLog) or die($sInsertParam);
    }else{
      echo "\n\nErro ao inserir na cadenderparam! Configurar atraves do  programa de manutenção.\n\n";
    }
  }
  
  
   
}

?>
