<?

// Inicio do Script
$sNomeScript = basename(__FILE__);

require_once("lib/db_inicio_script.php");
require_once("classes/TestBase.php");

db_log("Iniciando Processamento\n\n", $sArquivoLog);

$aArquivosProcessar = array();

if (@$argv[1] != "") {
  $aArquivosProcessar = explode(',',@$argv[1]);
}

$oTestBaseDivida = new TestBase("material", $sArquivoLog, $aArquivosProcessar);
$oTestBaseDivida->run();


// Final do Script
require_once("lib/db_final_script.php");

?>