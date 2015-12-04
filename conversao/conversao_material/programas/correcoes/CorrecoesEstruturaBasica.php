<?php

abstract class CorrecoesAbstract {
  
  public $sMsgHelp     = "";
  public $sNameFileLog = "";
  public $sFile        = "";
  public function __construct(){
     
  }

  public function retornoOk(){
    
  }
  
  public function retornoErro(){

  }
  
  public function setMsgHelp($sMsgHelp){
    $this->sMsgHelp = $sMsgHelp;  
  }
  
  public function getMsgHelp(){
    return $this->sMsgHelp;  
  }
  
  public function getFileHelp(){
    // implementar a busca do help
    $sFile = "correcoes/help/".substr($this->sFile,0,-9).".help.txt";
    $this->setMsgHelp(@file_get_contents($sFile));
    return $this->sMsgHelp;
  }
  
  public function initLog($sFileName){
    
    $sNameTmp = "log/correcoes/".$sFileName."_".date("Ymd_His").".log";
    $this->sNameFileLog = $sNameTmp;
    $this->sFile        = $sFileName;
    $this->log($this->getFileHelp());
    $this->log("Iniciando processamento do script : {$sFileName}");
    
  }
  
  public function processamento($iIndice, $iQtdLinhas, $iBloco=null) {
    
    $nPercentual = round((($iIndice + 1) / $iQtdLinhas) * 100, 2);
    
    if ( round($nPercentual,0) == round($nPercentual,2)) {
      
      $aDataHora   = getdate();
      $sHora       = "[".str_pad($aDataHora["mday"],2,'0',STR_PAD_LEFT). "/".str_pad($aDataHora["mon"],2,'0',STR_PAD_LEFT)."/".$aDataHora["year"].
                     " ".str_pad($aDataHora["hours"],2,'0',STR_PAD_LEFT).":".str_pad($aDataHora["minutes"],2,'0',STR_PAD_LEFT).":".str_pad($aDataHora["seconds"],2,'0',STR_PAD_LEFT)."]";
      if ($iBloco == null) {
        $iBloco = $iQtdLinhas; 
      }
      $sMsg        = "{$sHora} Processando ".($iIndice+1)." de {$iQtdLinhas} - {$nPercentual} % em blocos de {$iBloco} Registros";
        
      echo str_pad($sMsg,150,' ',STR_PAD_RIGHT)."\r";
     
      if ($nPercentual == 100) {
        echo str_pad("Buscando registros ... ",150,' ',STR_PAD_RIGHT)."\r";  
      }
    }
    
     
  }
  
  public function log($sMsg,$lTipoLog=2){
    db_log($sMsg,$this->sNameFileLog,$lTipoLog) ;
  }

}
