<?php
/*
 * Flag para usar o arquivo de configuracao db_conn.php
 */
$lConn = true;

define("CAMINHO_LIBS_PADRAO", "../../");
define("CAMINHO_LOGS_PADRAO", "./logs");

if ($lConn) {
  require_once(CAMINHO_LIBS_PADRAO."libs/db_conn.php");	
} else {
	
  $DB_USUARIO  = "postgres";
  $DB_SENHA    = "";
  $DB_SERVIDOR = ""; 
  $DB_BASE     = "";
  $DB_PORTA    = "5432";
}

require_once(CAMINHO_LIBS_PADRAO."libs/db_utils.php");
require_once(CAMINHO_LIBS_PADRAO."libs/db_libconsole.php");

$sArquivo = "./logs/log_migracao_contabancaria_".date("YmdHis").".txt";

if (!file_exists(CAMINHO_LOGS_PADRAO)) {
    
  if (!$pDirLog = mkdir(CAMINHO_LOGS_PADRAO, 0777)) {
    
    echo "Erro ao criar diretorio ".CAMINHO_LOGS_PADRAO." padrao...\n";
    exit;
  }
} else {
	
  db_log("",                                                                             $sArquivo, 0);
  db_log("Script PHP já foi executado as ".date("d/m/Y - h:i:s", time())."! Verifique.", $sArquivo, 0);
  db_log("",                                                                             $sArquivo, 0);
  db_log("\n",                                                                           $sArquivo, 0);
  exit;
}

db_log("",                                                                        $sArquivo, 0);
db_log("Inicio da migracao tabela contabancaria: ".date("d/m/Y - h:i:s", time()), $sArquivo, 0);
db_log("",                                                                        $sArquivo, 0);

db_log("Conectando...",                                                           $sArquivo, 0);
db_log("",                                                                        $sArquivo, 0);

$sConexao = "host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA";

if (!$conn1 = pg_connect($sConexao)) {
  
	db_log("Erro ao conectar...", $sArquivo, 0);
	db_log("",                    $sArquivo, 0);
  exit;
}

db_log("Processando...", $sArquivo, 0);
db_log("",               $sArquivo, 0);

try {

	db_query($conn1, "BEGIN");
	
	$sSqlStartSession = " select fc_startsession(); ";
  $rsStartSession   = db_query($conn1, $sSqlStartSession);
  
  /**
   *  Consulta CNPJ da prefeitura
   */
  $sSqlCNPJPrefeitura  = " select cgc                ";
  $sSqlCNPJPrefeitura .= "   from db_config          ";
  $sSqlCNPJPrefeitura .= "  where prefeitura is true ";
  $rsCNPJPrefeitura    = db_query($conn1, $sSqlCNPJPrefeitura);
  $sCNPJPrefeitura     = db_utils::fieldsMemory($rsCNPJPrefeitura, 0)->cgc; 
  
  /**
   *  Lista todas as contas bancarias 
   */
  $sSqlContas   = "    select distinct                                                                                                    ";
  $sSqlContas  .= "           contabancaria.db83_sequencial         as contabancaria,                                                     ";
  $sSqlContas  .= "           contabancaria.db83_descricao          as descrconta,                                                        ";
  $sSqlContas  .= "           max(conplanocontabancaria.c56_anousu) as anousu                                                             ";
  $sSqlContas  .= "      from contabancaria                                                                                               ";
  $sSqlContas  .= "           left join conplanocontabancaria on conplanocontabancaria.c56_contabancaria = contabancaria.db83_sequencial  ";
  $sSqlContas  .= "  group by contabancaria.db83_sequencial, contabancaria.db83_descricao                                                 ";
  $rsSqlContas  = db_query($conn1, $sSqlContas);
  $iRowsContas  = pg_num_rows($rsSqlContas);

  $iRowsReduzContasLog    = 0;
  $aLogSemContaCadastrada = array();
  $aLogContaMaisInstCad   = array();
  $aLogContaSemInstCad    = array();
  
  for ($iInd = 0; $iInd < $iRowsContas; $iInd++) {
  	
  	$oConta = db_utils::fieldsMemory($rsSqlContas, $iInd);
  	
  	if (trim($oConta->anousu) != '') {
  		  		
  		/**
  		 *  Busca as contas por instituição e agrupa
  		 */
  		$sSqlInstitReduz  = " select distinct                                                                                                       ";
      $sSqlInstitReduz .= "        conplanoreduz.c61_instit,                                                                                      ";
      $sSqlInstitReduz .= "        db_config.cgc                                                                                                  ";
      $sSqlInstitReduz .= "   from contabancaria                                                                                                  ";
      $sSqlInstitReduz .= "        left join conplanocontabancaria on conplanocontabancaria.c56_contabancaria = contabancaria.db83_sequencial     ";          
      $sSqlInstitReduz .= "        left join conplanoreduz         on conplanoreduz.c61_codcon                = conplanocontabancaria.c56_codcon  ";                                          
      $sSqlInstitReduz .= "                                       and conplanoreduz.c61_anousu                = conplanocontabancaria.c56_anousu  ";
      $sSqlInstitReduz .= "        left join db_config             on db_config.codigo                        = conplanoreduz.c61_instit          ";                        
      $sSqlInstitReduz .= "  where conplanocontabancaria.c56_contabancaria = {$oConta->contabancaria}                                             ";
      $sSqlInstitReduz .= "    and conplanocontabancaria.c56_anousu        = {$oConta->anousu}                                                    ";
      $rsSqlInstitReduz = db_query($conn1, $sSqlInstitReduz);
      $iRowsInstitReduz = pg_num_rows($rsSqlInstitReduz);
      
  		if ($iRowsInstitReduz > 0 ) {
  			
  			$oInstitReduz = db_utils::fieldsMemory($rsSqlInstitReduz, 0);
  			
	  		if ($iRowsInstitReduz > 1 ) {
	        
	        /**
	         *  Update com o valor do CGC do 1º registro encontrado
	         */
	  		  $sSqlUpdate  = " update contabancaria                                 ";
          $sSqlUpdate .= "    set db83_identificador = '{$oInstitReduz->cgc}'   ";
          $sSqlUpdate .= "  where db83_sequencial    = {$oConta->contabancaria} ";
          $rsSqlUpdate = db_query($conn1, $sSqlUpdate);
          if (!$rsSqlUpdate) {
            throw new Exception("Erro ao alterar registros na tabela(contabancaria)! Verifique.");
          }
	         
		      $sSqlInstitReduzContasLog  = " select c56_codcon as codcon,                                                                                          ";
          $sSqlInstitReduzContasLog .= "        c56_anousu as anousu,                                                                                          ";
          $sSqlInstitReduzContasLog .= "        c61_reduz  as reduzido,                                                                                        ";
          $sSqlInstitReduzContasLog .= "        codigo     as instituicao                                                                                      ";
		      $sSqlInstitReduzContasLog .= "   from contabancaria                                                                                                  ";
		      $sSqlInstitReduzContasLog .= "        left join conplanocontabancaria on conplanocontabancaria.c56_contabancaria = contabancaria.db83_sequencial     ";          
		      $sSqlInstitReduzContasLog .= "        left join conplanoreduz         on conplanoreduz.c61_codcon                = conplanocontabancaria.c56_codcon  ";                                          
		      $sSqlInstitReduzContasLog .= "                                       and conplanoreduz.c61_anousu                = conplanocontabancaria.c56_anousu  ";
		      $sSqlInstitReduzContasLog .= "        left join db_config             on db_config.codigo                        = conplanoreduz.c61_instit          ";                        
		      $sSqlInstitReduzContasLog .= "  where conplanocontabancaria.c56_contabancaria = {$oConta->contabancaria}                                             ";
		      $sSqlInstitReduzContasLog .= "    and conplanocontabancaria.c56_anousu        = {$oConta->anousu}                                                    ";
		      $rsSqlInstitReduzContasLog = db_query($conn1, $sSqlInstitReduzContasLog);
		      $iRowsInstitReduzContasLog = pg_num_rows($rsSqlInstitReduzContasLog);
          
		      $iRowsReduzContasLog      += $iRowsInstitReduzContasLog;
		      
          /**
           *  Gera log das contas bancarias com mais de uma conta para a mesma instituição
           */
	        for ($xInd = 0; $xInd < $iRowsInstitReduzContasLog; $xInd++) {
	        	
	        	$oInstitReduzContasLog = db_utils::fieldsMemory($rsSqlInstitReduzContasLog, $xInd);
	        	
            $sInstitReduzContasLog  = " - CODCON: [{$oInstitReduzContasLog->codcon}]           ";
            $sInstitReduzContasLog .= " - ANOUSU: [{$oInstitReduzContasLog->anousu}]           ";
            $sInstitReduzContasLog .= " - REDUZ: [{$oInstitReduzContasLog->reduzido}]          ";
            $sInstitReduzContasLog .= " - INSTITUIÇÃO: [{$oInstitReduzContasLog->instituicao}] ";
	        	if (!empty($oInstitReduzContasLog->instituicao)) {	        		
	        		$aLogContaMaisInstCad[] = $sInstitReduzContasLog;
	        	} else {
	        		$aLogContaSemInstCad[]  = $sInstitReduzContasLog;
	        	}
	        }
	      } else {
	        	        
	        /**
	         *  Update com o valor CGC encontrado
	         */       
	        $sSqlUpdate  = " update contabancaria                                 ";
	        $sSqlUpdate .= "    set db83_identificador = '{$oInstitReduz->cgc}'   ";
	        $sSqlUpdate .= "  where db83_sequencial    = {$oConta->contabancaria} ";
	        $rsSqlUpdate = db_query($conn1, $sSqlUpdate);
	        if (!$rsSqlUpdate) {
	          throw new Exception("Erro ao alterar registros na tabela(contabancaria)! Verifique.");
	        }
	      }	
  		}					            
  	} else {

  		/**
  		 *  Update com o valor CGC da prefeitura
  		 */
  		$sSqlUpdate  = " update contabancaria                                 ";
      $sSqlUpdate .= "    set db83_identificador = '{$sCNPJPrefeitura}'     ";
      $sSqlUpdate .= "  where db83_sequencial    = {$oConta->contabancaria} ";
      $rsSqlUpdate = db_query($conn1, $sSqlUpdate);
      if (!$rsSqlUpdate) {
        throw new Exception("Erro ao alterar registros na tabela(contabancaria)! Verifique.");
      }
            
  		/**
  		 *  Gera log identificando essa conta como sem conplano cadastrado
  		 */ 
       $sLogSemContaCadastrada   = "CONTABANCARIA: {$oConta->contabancaria} - {$oConta->descrconta} \n";
       $sLogSemContaCadastrada  .= " - Não existem reduzidos cadastrados para essa conta bancaria.\n";
       $aLogSemContaCadastrada[] = $sLogSemContaCadastrada;
  	}  	
  	
  	logProcessamento($iInd, $iRowsContas, 0);
  }
  
  $sSqlAlterTable  = "alter table contabancaria alter column db83_identificador set not null";
  $rsSqlAlterTable = db_query($conn1, $sSqlAlterTable);
  if (!$rsSqlAlterTable) {
    throw new Exception("Erro ao alterar coluna db83_identificador na tabela(contabancaria)! Verifique.");
  } 
  
  db_log('Migracao registros concluida com sucesso.', $sArquivo, 0);
  db_log('',                                          $sArquivo, 0);
  
  db_query($conn1, "COMMIT");
} catch ( Exception $eException ) {
  
  db_query($conn1, "ROLLBACK");
  db_log($eException->getMessage(), $sArquivo ,0);
}

foreach ($aLogSemContaCadastrada as $oLogSemContaCadastrada) {
	db_log($oLogSemContaCadastrada, $sArquivo, 0);
}

foreach ($aLogContaMaisInstCad as $oLogContaMaisInstCad) {
	db_log($oLogContaMaisInstCad, $sArquivo, 0);
}

foreach ($aLogContaSemInstCad as $oLogContaSemInstCad) {
	db_log($oLogContaSemInstCad, $sArquivo, 0);
}

db_log("Quantidade de contas encontradas : {$iRowsContas}",                                     $sArquivo ,0);
db_log("Quantidade de reduzidos com mais de uma contas encontradas: {$iRowsReduzContasLog}",    $sArquivo ,0);
db_log('OBS: Favor verificar os logs gerados no arquivo ./log_*',                               $sArquivo ,0);
db_log('OBS: Cuidado script deve ser executado apenas 1x, para nao duplicar os registros.',     $sArquivo ,0);
db_log('',                                                                                      $sArquivo ,0);
db_log("\n",                                                                                    $sArquivo, 0);

/**
 * Função que exibe na tela a quantidade de registros processados 
 * e a quandidade de memória utilizada
 *
 * @param integer $iInd      Indice da linha que está sendo processada
 * @param integer $iTotalLinhas  Total de linhas a processar
 * @param integer $iParamLog     Caso seja passado true é exibido na tela 
 */
function logProcessamento($iInd, $iTotalLinhas, $iParamLog) {
  
  $nPercentual = round((($iInd + 1) / $iTotalLinhas) * 100, 2);
  $nMemScript  = (float)round( (memory_get_usage()/1024 ) / 1024,2);
  $sMemScript  = $nMemScript ." Mb";
  $sMsg        = " ".($iInd+1)." de {$iTotalLinhas} Processando {$nPercentual} %"." Total de memoria utilizada : {$sMemScript} ";
  $sMsg        = str_pad($sMsg,100," ",STR_PAD_RIGHT);
  
  db_log($sMsg."\r",null,$iParamLog,true,false);
}
?>