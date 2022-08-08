<?

include("db_inicio_script.php");

$sArqLog      = "log/01_TesteLogConexao.txt";
$sArqLogWork  = 'log/03_geraBaseAux_logVerificaWork.txt';
$sArqLogInfos = 'log/03_geraBaseAux_logInfo.txt';
$sArqLogErros = 'log/03_geraBaseAux_logErros.txt';
$sArquivoLog  = 'log/enderecoCgm.txt';
//
// Configuracoes para programas de Conversão
//

//$ConfigINI = parse_ini_file("db_config.ini");

require_once (__DIR__ . "/../../../libs/db_conn.php");

// ORIGEM 1
/*
$ConfigConexaoOrigem["host"]     = $ConfigINI["ConfigConexaoOrigem_host"];
$ConfigConexaoOrigem["port"]     = $ConfigINI["ConfigConexaoOrigem_port"];
$ConfigConexaoOrigem["dbname"]   = $ConfigINI["ConfigConexaoOrigem_dbname"];
$ConfigConexaoOrigem["user"]     = $ConfigINI["ConfigConexaoOrigem_user"];
$ConfigConexaoOrigem["password"] = $ConfigINI["ConfigConexaoOrigem_password"];
*/
// DESTINO 1   
$ConfigConexaoDestino["host"]     = $DB_SERVIDOR;
$ConfigConexaoDestino["port"]     = $DB_PORTA;
$ConfigConexaoDestino["dbname"]   = $DB_BASE;
$ConfigConexaoDestino["user"]     = $DB_USUARIO;
$ConfigConexaoDestino["password"] = $DB_SENHA;

db_log("", $sArqLog);

//$tipoconversao 1 = tributario
//$tipoconversao 2 = financeiro
//$tipoconversao 3 = protocolo 
$tipoconversao = 2 ;

/// empresa_conversao 1 = siamweb
/// empresa_conversao 2 = tecnosistemas
/// empresa_conversao 3 = system visual
/// empresa_conversao 4 = system dbf
/// empresa_conversao 5 = sam30
/// empresa_conversao 6 = infotec

$empresa_conversao = 6;

$institprefa = 1;
$cnpjprefa   = '88601943000110';
$iAnoAtual   = 2009;
$iRecJur     = 1;
$iAdvog      = 1;
$iHistDivida = 70;

$dDataConversao = '2010-06-08';

include("db_cria_conexoes.php");
/**
 * Inicia a sessao
 *
 */
$rsStartSession = db_query($pConexaoDestino, "select fc_startsession()", $sArquivoLog);

db_log("", $sArqLog);

?>
