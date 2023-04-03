<?

include("db_inicio_script.php");

$sArqLog      = "log/01_TesteLogConexao.txt";
$sArqLogWork  = 'log/03_geraBaseAux_logVerificaWork.txt';
$sArqLogInfos = 'log/03_geraBaseAux_logInfo.txt';
$sArqLogErros = 'log/03_geraBaseAux_logErros.txt';

//
// Configuracoes para programas de Conversão
//

include(PATH_ECIDADE."/libs/db_conn.php");

$ConfigConexao["host"]     = $DB_SERVIDOR; 
$ConfigConexao["port"]     = isset($DB_PORTAL_ALT)?$DB_PORTA_ALT:$DB_PORTA;
$ConfigConexao["dbname"]   = $DB_BASE;
$ConfigConexao["user"]     = $DB_USUARIO;
$ConfigConexao["password"] = $DB_SENHA;


db_log("", $sArqLog);

$iAnoAtual   = date('Y');

$dDataConversao = date('Y-m-d');

include("db_cria_conexoes.php");

/**
 * Inicia a sessao
 *
 */
$rsStartSession = db_query($pConexao, "select fc_startsession()", $sArquivoLog);

db_log("", $sArqLog);

?>
