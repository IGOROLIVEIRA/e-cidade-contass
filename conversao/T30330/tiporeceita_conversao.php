<?php
require(__DIR__ . "/../../libs/db_utils.php");
//require(__DIR__ . "/../../libs/db_conn.php");

$DB_USUARIO         = "";
$DB_SENHA           = "";
$DB_SERVIDOR        = ""; 
$DB_BASE            = "";
$DB_PORTA           = "5432";

echo "inicio da migracao: ".date("d/m/Y")." - ".date("h:i:s")."\n";
echo "Conectando...\n";

$sConexao = "host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA";

if(!($conn1 = pg_connect($sConexao))){
  echo "erro ao conectar...\n";
  exit;
}

echo "Iniciando Procedimento..\n\n";

$aDadosIncorretos = array();
$lErro            = true;

$sSqlTabRec  = " select fc_startsession(); ";
$sSqlTabRec .= " select * from tabrec;     ";

$rsTabRec    = pg_query($sSqlTabRec);
$iTabRec     = pg_num_rows($rsTabRec);

$sArquivo    = "log_migracao_tiporeceita_".date("YmdHis").".txt";

echo "BEGIN \n";

pg_query("BEGIN");

for ($i = 0; $i  < $iTabRec; $i++) {
	$oTabRec = db_utils::fieldsMemory($rsTabRec,$i);
	
  $sSqlTabRecMul = " SELECT k02_codigo
                       FROM tabrec
                      WHERE k02_recmul = {$oTabRec->k02_codigo} limit 1; ";
  
  $rsTabRecMul = pg_query($sSqlTabRecMul); 
                         
	if ( pg_num_rows($rsTabRecMul) > 0 ) {
		$lMulta = true;
	} else {
		$lMulta = false;
	}
    
  
	$sSqlTabRecJur = " SELECT k02_codigo
                       FROM tabrec
	                    WHERE k02_recjur = {$oTabRec->k02_codigo} limit 1; ";  
	                    
  $rsTabRecJur = pg_query($sSqlTabRecJur); 
                         
  if ( pg_num_rows($rsTabRecJur) > 0 ) {
    $lJuros = true;
  } else {
    $lJuros = false;
  }
  
  if ( $lMulta && $lJuros) {
 	
    $aDadosIncorretos[$i]['Cod'] = $oTabRec->k02_codigo;
    $aDadosIncorretos[$i]['Jur'] = $oTabRec->k02_recjur;
    $aDadosIncorretos[$i]['Mul'] = $oTabRec->k02_recmul;
  	
    echo "\n\n Multa - ".$lMulta." Juros - ".$lJuros."\n\n";
    
    $sSql = " UPDATE tabrec SET k02_tabrectipo = 5 WHERE k02_codigo = {$oTabRec->k02_codigo}; ";
    
  } else if ( $lJuros && !$lMulta ) {

    $sSql = " UPDATE tabrec SET k02_tabrectipo = 2 WHERE k02_codigo = {$oTabRec->k02_codigo}; ";
  	
  } else if ( $lMulta && !$lJuros ) {

    $sSql = " UPDATE tabrec SET k02_tabrectipo = 3 WHERE k02_codigo = {$oTabRec->k02_codigo}; ";
  	
  } else {

    $sSql = " UPDATE tabrec SET k02_tabrectipo = 1 WHERE k02_codigo = {$oTabRec->k02_codigo}; ";
  	
  }

  if (isset($sSql)) {
    echo $sSql."\n";
    $rs = pg_query($sSql);
    
	  if ($rs) {
	    $lErro = false;
	    echo " Inserir ...\n";
	  } else {
	    $lErro = true;
	    echo "Não Inserir ...\n";
	  }
  }
}

    db_log("+---------------------+---------------------+----------------------+\n"                         ,$sArquivo);
    db_log("+---------------------+---------------------+----------------------+\n"                         ,$sArquivo);
    db_log("\n\n"                                                                                           ,$sArquivo);
    
    db_log("\n\n              ---------- TIPO JURO E MULTA ---------              "                         ,$sArquivo);
    db_log("\n\n"                                                                                           ,$sArquivo);
    db_log("+---------------------+---------------------+----------------------+\n"                         ,$sArquivo);
    db_log("|         CODIGO      |         JURO        |        MULTA         |\n"                         ,$sArquivo);   
    db_log("+---------------------+---------------------+----------------------+\n"                         ,$sArquivo); 
    
    $iDados = 0;
    foreach ( $aDadosIncorretos as $aDados ) {
        
      db_log("+---------------------+---------------------+----------------------+\n"                         ,$sArquivo);
      db_log("|     ".$aDados['Cod']."       |       ".$aDados['Jur']."     |     ".$aDados['Mul']."    |\n"  ,$sArquivo);   
      db_log("+---------------------+---------------------+----------------------+\n"                         ,$sArquivo); 
      db_log("\n\n"                                                                                           ,$sArquivo);
      
      $iDados++;
    }

    db_log("+---------------------+---------------------+----------------------+\n"                         ,$sArquivo);
    db_log("+---------------------+---------------------+----------------------+\n"                         ,$sArquivo);
    db_log("\n\n"                                                                                           ,$sArquivo);
    
    db_log("TOTAL: $iDados \n"                                                                              ,$sArquivo);

  function db_log($sLog="", $sArquivo="", $iTipo=0, $lLogDataHora=true, $lQuebraAntes=false) {
  
  // Tipos: 0 = Saida Tela e Arquivo
  //        1 = Saida Somente Tela
  //        2 = Saida Somente Arquivo
    
  $aDataHora = getdate();
  $sQuebraAntes = $lQuebraAntes?"\n":"";


  if($lLogDataHora) {
    $sOutputLog = sprintf("%s[%02d/%02d/%04d %02d:%02d:%02d] %s", $sQuebraAntes,
                          $aDataHora["mday"], $aDataHora["mon"], $aDataHora["year"],
                          $aDataHora["hours"], $aDataHora["minutes"], $aDataHora["seconds"],
                          $sLog);
  } else {
    $sOutputLog = sprintf("%s%s", $sQuebraAntes, $sLog);
  }

   $sOutputLog = sprintf("%s%s", $sQuebraAntes, $sLog);
  
  // Se habilitado saida na tela...
  if($iTipo==0 or $iTipo==1) {
    echo $sOutputLog;
  }

  // Se habilitado saida para arquivo...
  if($iTipo==0 or $iTipo==2) {
    if(!empty($sArquivo)) {
      $fd=fopen($sArquivo, "a+");
      if($fd) { 
        fwrite($fd, $sOutputLog);
        fclose($fd);
      }
    }
  }

  return $aDataHora;
}

if ($lErro == true) {

  db_log("\n"                                                                                               ,$sArquivo);
  db_log("Ocorreu algum erro, ROLLBACK ... \n"                                                              ,$sArquivo);
  echo "ROLLBACK \n";
  pg_query('ROLLBACK');
  
} else {

	db_log("\n"                                                                                               ,$sArquivo);
	db_log("Processo Concluido com Sucesso ... \n"                                                            ,$sArquivo);
	echo "COMMIT \n";
	pg_query('COMMIT');
}
?>