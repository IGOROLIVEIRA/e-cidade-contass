<?
// Inicio do Script
$sNomeScript = basename(__FILE__);
include("lib/db_inicio_script.php");

db_log("Iniciando Processamento ",$sArquivoLog);
echo "\n \n";
// db_query($pConexao,"VACUUM ANALYZE;");

$sDir     = "correcoes/";
$sPathern = ".path.php";

if (@$argv[1] != "") {
  $sXmlFile = "correcoes/".$argv[1];
} else {
  $sXmlFile = "correcoes/correcao_scripts.xml"; 
}
$oRunner = new Runner($sDir,$sPathern,$sXmlFile,$sArquivoLog);
$oRunner->run($sXmlFile);

class Runner {
  
  private $sPath         = "";
  private $sClassPathern = "";
  private $sXmlFile      = ""; 

  function __construct($sPath,$sClassPathern,$sXmlFile,$sLogFile){

    $this->sPath              = $sPath;
    $this->sClassPathern      = $sClassPathern;
    $this->sXmlFile           = $sXmlFile;
    $this->sLogFile           = $sLogFile;
  }  

  public function run($sXmlFile) {
    // Verifica se existe o arquivo com mapeamento das tabelas 
    if ( file_exists($sXmlFile) ) {
       $xml = new DOMdocument;
       $xml->load($sXmlFile);
       if ( $xml->hasChildNodes() ) {
          foreach($xml->childNodes as $child) {
            // se o tipo de no for texto passa para o proximo
            if ( $child->nodeType == 3 ) {
              continue;      
            }
            $scripts = $child->getElementsByTagName("script");
            foreach($scripts as $script) {
            	if ($script->getAttribute("lModoTeste") == "true") {
            		$lModoTeste = true;
            	} else{
            		$lModoTeste = false;
            	}
              $this->runPath($script->getAttribute("className"),$lModoTeste);
            }
          }
       }  
    } else {
      db_log('ERRO : Arquivo de configuracao XML nao encontrado.');
      exit;
    }
  }

  public function runPath($sFile,$lModoTeste) {

    if (!class_exists("correcoes/{$sFile}.path.php")){
      require_once "correcoes/{$sFile}.path.php";
    }

    $sClassName = $sFile;
    $obj = new $sClassName;
    $obj->setModoTeste($lModoTeste); 
    if ($lModoTeste == false) {
    	$sModoTeste = "Commit"; 
    } else {
    	$sModoTeste = "Rollback";
    }
    db_log_arquivo("Processando Script: {$sFile}.path.php com {$sModoTeste}",$this->sLogFile);
    $obj->run();
    
    if ($obj->hasError() == false) {
      db_log_arquivo(str_pad("Script: $sFile - Processamento efetuado com Sucesso ", 150, ".", STR_PAD_RIGHT)." [  OK  ]",$this->sLogFile);
      db_log_arquivo("",$this->sLogFile);
    } else {
      db_log_arquivo(str_pad("Script: $sFile - Ocorreram erros durante o processamento do script. Verificar o Log: [{$obj->sNameFileLog}]", 150, ".", STR_PAD_RIGHT)." [ ERRO ]",$this->sLogFile);
      db_log_arquivo("",$this->sLogFile);      
    }    

    $this->showMessage($obj->getMessage()." com {$sModoTeste}",$obj->hasError());

  }

  public function showMessage($sMensagem,$lErro){
    
    echo str_pad($sMensagem." ", 150, ".", STR_PAD_RIGHT)." [";
    if ($lErro) {
      system('tput setaf 1');      
      echo " ERRO ";
    } else {
      system('tput setaf 2');      
      echo "  OK  ";
    }
    system('tput op');
    echo "]\n";


  }

}
// Final do Script
include("lib/db_final_script.php");
?>
