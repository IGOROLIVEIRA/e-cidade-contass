<?

$sArquivoConfig = "db_config_testando.ini";

include("db_inicio_script.php");

$sArqLog      = "log/01_TesteLogConexao.txt";
$sArqLogWork  = 'log/03_geraBaseAux_logVerificaWork.txt';
$sArqLogInfos = 'log/03_geraBaseAux_logInfo.txt';
$sArqLogErros = 'log/03_geraBaseAux_logErros.txt';

db_log("", $sArqLog);

//$tipoconversao 1 = tributario sozinho
//$tipoconversao 2 = financeiro sozinho
//$tipoconversao 3 = protocolo junto com o tributario

$tipoconversao = 3 ;

/// empresa_conversao 1 = siamweb
/// empresa_conversao 2 = tecnosistemas
/// empresa_conversao 3 = system visual
/// empresa_conversao 4 = system dbf
/// empresa_conversao 5 = sam30

$empresa_conversao = 4;

$institprefa = 1;
$cnpjprefa   = '88585518000185';
$iAnoAtual   = 2009;
$iRecJur     = 1;
$iAdvog      = 1;
$iHistDivida = 70;
$iArretipoIPTU = 1;
$iHistDiversos = 80;

/////  CONEXOES 
/// $pConexaoDestino1
/// $pConexaoDestino2
/// $pConexaoOrigem1
/// $pConexaoOrigem2
/// $pConexaoFirebird

$dDataConversao = date("Y-m-d");

include("db_conecta_origem1.php");
//include("db_conecta_origem2.php");
//include("db_conecta_firebird.php");
//include("db_conecta_destino1.php");

db_log("", $sArqLog);

?>
