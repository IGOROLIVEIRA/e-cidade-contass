<?
/**
 *  Configuraчуo base Prefeitura
 */
$ConfigConexaoPrefeitura["host"]     = $DB_SERVIDOR;
$ConfigConexaoPrefeitura["port"]     = $DB_PORTA;
$ConfigConexaoPrefeitura["dbname"]   = $DB_BASE;
$ConfigConexaoPrefeitura["user"]     = $DB_USER;
$ConfigConexaoPrefeitura["password"] = $DB_SENHA;

/**
 *  Conexуo com base de dados da Prefeitura
 */
try {
	
  $sDataSourcePrefeitura = " host={$ConfigConexaoPrefeitura["host"]} 
                             dbname={$ConfigConexaoPrefeitura["dbname"]} 
                             port={$ConfigConexaoPrefeitura["port"]} 
                             user={$ConfigConexaoPrefeitura["user"]} 
                             password={$ConfigConexaoPrefeitura["password"]}";
                            
  db_log("- BASE PARA IMPORTACAO PREFEITURA: $sDataSourcePrefeitura", $sArquivoLog, $iParamLog);
 
  if ( !($connOrigem = @pg_connect($sDataSourcePrefeitura)) ) {
   throw new Exception("ERRO AO CONECTAR NO DBPORTAL ( $sDataSourcePrefeitura )!");
  }

  db_log("", $sArquivoLog, $iParamLog);
  $lErro = false;
} catch (Exception $eException) {
	
	$lErro = true;
  db_log($eException->getMessage(), $sArquivoLog, $iParamLog);
}
?>