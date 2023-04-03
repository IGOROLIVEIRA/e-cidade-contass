<?php
/**
 * Classe abstrata com o comportamento padrao para scripts de testes
 *
 */
abstract class TestesAbstract {
	/**
	 * String com mensagem de help para log
	 *
	 * @var string
	 */
  public $sMsgHelp     = "";
  /**
   * Nome do arquivo de log
   *
   * @var string
   */
  public $sNameFileLog = "";
  /**
   * Nome do arquivo de help
   *
   * @var string
   */
  public $sFile        = "";
  /**
   * nome do cursor aberto para consultas
   *
   * @var string
   */
  public $sNameCursor  = "";
  
  /**
   * Metodo contrutor
   *
   */
  public function __construct(){}

  public function retornoOk(){}
  
  public function retornoErro(){}
  /**
   * Seta mensagem de help para log
   *
   * @param string $sMsgHelp
   */
  public function setMsgHelp($sMsgHelp){
    $this->sMsgHelp = $sMsgHelp;	
  }
  /**
   * Retorna mensagem de help
   *
   * @return string
   */
  public function getMsgHelp(){
    return $this->sMsgHelp;  
  }
  /**
   * Metodo que retorna conteudo da mensagem de help
   *
   * @return string
   */
  public function getFileHelp(){
    // implementar a busca do help
    $sFile = "testes/help/".substr($this->sFile,0,-9).".help.txt";
    $this->setMsgHelp(@file_get_contents($sFile));
    return $this->sMsgHelp;
  }
  
  public function initLog($sFileName) {
  	
  	$sNameTmp = "log/".$sFileName."_".date("Ymd_His").".log";
    $this->sNameFileLog = $sNameTmp;
    $this->sFile        = $sFileName;
    $this->log($this->getFileHelp());
    $this->log("Iniciando processamento do script : {$sFileName}");
    
  }
  
  public function log($sMsg){
  	db_log_arquivo($sMsg,$this->sNameFileLog);
  	
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
  
  public function openCursor($pConexao,$sName,$sSql) {
  	
  	$this->sNameCursor = $sName;
  	$rsBegin    = db_query($pConexao,"BEGIN");
  	$sSqlCursor = "declare {$this->sNameCursor} cursor for {$sSql}";
  	$rsBegin    = db_query($pConexao,$sSqlCursor);
    if (!$rsBegin) {
      throw (new Exception('Erro ao abrir transacao com o banco de dados'));     
    }
  }
  
  public function fetch($pConexao,$sNameCursor,$iQuantidade){
  	
  	$sSqlBloco = "fetch {$iQuantidade} from {$sNameCursor}";
    $rsBloco   = db_query($pConexao,$sSqlBloco);
    return $rsBloco;
  	
  }
  
  public function __destruct(){
  	
  	global $pConexao;
  	$rsCommit = db_query($pConexao,'COMMIT');
  	if (!$rsCommit) {
  		throw (new Exception('Erro ao finalizar transacao'));  		
  	}
  	
  }

}
