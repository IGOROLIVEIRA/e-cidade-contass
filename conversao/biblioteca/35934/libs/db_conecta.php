<?

include("db_inicio_script.php");

$sArqLog      = "log/01_TesteLogConexao.txt";
$sArqLogWork  = 'log/03_geraBaseAux_logVerificaWork.txt';
$sArqLogInfos = 'log/03_geraBaseAux_logInfo.txt';
$sArqLogErros = 'log/03_geraBaseAux_logErros.txt';

db_log("", $sArqLog);

//$tipoconversao 1 = tributario sozinho
//$tipoconversao 2 = financeiro sozinho
//$tipoconversao 3 = protocolo junto com o tributario
//

$tipoconversao = 1 ;

/// empresa_conversao 1 = siamweb
/// empresa_conversao 2 = tecnosistemas
/// empresa_conversao 3 = system visual
/// empresa_conversao 4 = system dbf
/// empresa_conversao 5 = sam30
/// empresa_conversao 6 = infotec

$empresa_conversao = 6;

$institprefa=1;
$cnpjprefa   = '88585518000185';
$iAnoAtual   = 2009;
$iRecJur     = 1;
$iAdvog      = 1;
$iHistDivida = 70;
$iHistParc   = 75;
$iHistDiversos = 80;
$iHistParcDiversos = 85;

$iArretipoIPTU = 1;
$iArretipoDivida = 5;
$iArretipoCDA = 19;
$iArretipoInicial = 34;

$iCGM=16027;

/////  CONEXOES 
/// $pConexaoDestino1
/// $pConexaoDestino2
/// $pConexaoOrigem1
/// $pConexaoOrigem2
/// $pConexaoFirebird

$dDataConversao = date("Y-m-d");

include("db_conecta_origem1.php");



#include("db_conecta_origem2.php");
#include("db_conecta_firebird.php");
include("db_conecta_destino1.php");
#include("db_conecta_destino2.php");

db_log("", $sArqLog);
?>
