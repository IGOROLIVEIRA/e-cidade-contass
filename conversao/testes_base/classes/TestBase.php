<?

class TestBase {
  
  private $sPath        = "";
  
  private $sPathTest    = "";
  
  private $aProcessFile = array();
  
  private $sLogFile     = "";
  
  const   CLASS_TEST    = ".test.php";
  

  function __construct($sPath, $sLogFile, $aProcessFile=array()){

    $this->sPath        = $sPath;
    $this->sPathTest    = "testes/{$sPath}";
    $this->aProcessFile = $aProcessFile;
    $this->sLogFile     = "{$sLogFile}";
  }  

  public function run(){
    
    // Verificamos se o caminho passado e um diretorio
    
    if (is_dir($this->sPathTest)) {
      
      // Abrimos o Diretorio
      
      if ($dh = opendir($this->sPathTest)) {
        
        while (($file = readdir($dh)) !== false ) {

          $iInicio = strpos($file,self::CLASS_TEST);
          $iFinal  = strlen($file);

          if (   substr($file,$iInicio,$iFinal) == self::CLASS_TEST 
              && ( count($this->aProcessFile) == 0 || in_array($file,$this->aProcessFile) ) ){
            
            $this->runTest($file);
          }
        }
        closedir($dh);
      }
    }
  }

  public function runTest($sFile) {

    if (!class_exists("{$this->sPathTest}/{$sFile}")){
      require_once "{$this->sPathTest}/{$sFile}";
    }

    $sClassName = substr($sFile,0,strpos($sFile,self::CLASS_TEST));
    db_log_arquivo("Processando $sFile",$this->sLogFile);
    $obj = new $sClassName;
    $obj->run();
    
    if ($obj->hasError() == false) {
      
    	db_log_arquivo(str_pad("Script: $sFile Não encontrou erro ", 150, ".", STR_PAD_RIGHT)." [  OK  ]",$this->sLogFile);
    	db_log_arquivo("",$this->sLogFile);

     /*
      * Caso não tenha sido retornado nenhum erro o log gerado é excluído
      */
    	unlink($obj->sNameFileLog);
    } else {
      
      db_log_arquivo(str_pad("Script: $sFile Encontrou erro ", 150, ".", STR_PAD_RIGHT)." [ ERRO ]",$this->sLogFile);
      db_log_arquivo("",$this->sLogFile);      
    }
    
    $this->showMessage($obj->getMessage(),$obj->hasError());

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
  
  public function addProcessFile($sFile='') {
    
    if ( trim($sFile) != '') {
      $this->aProcessFile[] = $sFile;
    }
  }

}
?>