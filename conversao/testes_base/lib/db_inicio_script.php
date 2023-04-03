<?
// Desabilita tempo maximo de execucao
set_time_limit(0);

// Hora de Inicio do Script
$sHoraInicio = date( "H:i:s" );

// Bibliotecas
require_once("db_libconversao.php");
require_once("db_utils.php");

// Timestamp para data/Hora
$sTimeStampInicio = date("Ymd_His");

// Verifica se nao foi setado o nome do script
if(!isset($sNomeScript)) {
  $sNomeScript = basename(__FILE__);
}

// Seta nome do arquivo de Log, caso jÃ¡ nÃ£o exista
if(!defined("DB_ARQUIVO_LOG")) {
  $sArquivoLog = "log/".$sNomeScript."_".$sTimeStampInicio.".log";
  define("DB_ARQUIVO_LOG", $sArquivoLog);
}

require_once("db_conecta.php");

// Logs...
db_log("", $sArquivoLog);
db_log("*** INICIO Script ".$sNomeScript." ***", $sArquivoLog);
db_log("", $sArquivoLog);

db_log("Arquivo de Log: $sArquivoLog", $sArquivoLog);
db_log("    Script PHP: ".$sNomeScript, $sArquivoLog);
db_log("", $sArquivoLog);

db_log("Iniciando Sessao", $sArquivoLog);
db_query($pConexao, "select fc_startsession()") or die ("Erro inicializando sessão");

db_log("Setando Variáveis da Sessao", $sArquivoLog);
db_query($pConexao, "select fc_putsession('DB_instit',{$ConfigINI["ConfigInstit"]}::varchar)") or die ("Erro inicializando sessão");
db_query($pConexao, "select fc_putsession('DB_anousu',{$ConfigINI["ConfigAnoUsu"]}::varchar)") or die ("Erro inicializando sessão");
db_query($pConexao, "select fc_putsession('DB_datausu','{$ConfigINI["ConfigDataUsu"]}'::varchar)") or die ("Erro inicializando sessão");

?>
