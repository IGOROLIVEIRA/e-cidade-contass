<?php

abstract class SicomArquivoBase {
  
  /**
   *nome do arquivo que sera gerado
   * @var String
   */
  protected $sNomeAquivo;
  
  /**
   *extensao do arquivo a ser gerado
   * @var String
   */
  protected $sOutPut = 'csv';
  
  /**
   *dados a serem escritos no arquivo
   * @var ArrayIterator::
   */
  protected $aDados;
  
  /**
   *data inicial da emissao dos dados 
   * @var String
   */
  protected $sDataInicial;
  
  /**
   *data final da emissao dos dados 
   * @var String
   */
  protected $sDataFinal;
  
  protected  $rsLogger;

  /**
   * Parametro de encerramento do exercício
   * @var bool
   */
  protected $bEncerramento = FALSE;

    /**
     * Parametro de $iDeParaNatureza do exercício
     * @var integer
     */
    protected $iDeParaNatureza = 0;

  /**
   * @return boolean
   */
  public function getEncerramento()
  {
    return $this->bEncerramento;
  }

  /**
   * @param boolean $deParaNatureza
   */
  public function setDeParaNatureza($iDeParaNatureza)
  {
    $this->iDeParaNatureza = $iDeParaNatureza;
  }

    /**
     * @return boolean
     */
    public function getDeParaNatureza()
    {
        return $this->iDeParaNatureza;
    }

    /**
     * @param integer $deParaNatureza
     */
    public function setEncerramento($bEncerramento)
    {
        $this->bEncerramento = $bEncerramento;
    }
  
  /**
     *retorna array de dados
     */
  public function  getDados() {
    
    return $this->aDados;
  }
  
/**
   * 
   * @see iPadArquivoBase::setDataFinal()
   */
  public function setDataFinal($sDataFinal) {
    
    if (strpos($sDataFinal, "/", 0)) {
      $sDataFinal = implode("-", array_reverse(explode("/", $sDataFinal)));
    }
    $this->sDataFinal = $sDataFinal;
  }
  
  /**
   * 
   * @see iPadArquivoBase::setDataInicial()
   */
  public function setDataInicial($sDataInicial) {
   
  if (strpos($sDataInicial, "/",0)) {
      $sDataInicial = implode("-", array_reverse(explode("/", $sDataInicial)));
    }
    $this->sDataInicial = $sDataInicial;
  }
  
  /**
   * Retorna o nome do arquivo
   *
   * @return string
   */
  function getNomeArquivo() {

    return $this->sNomeArquivo;
  }
  
  /**
   *retorna o Tipo de saida o arquivo 
   */
  function getOutPut() {
    return  $this->sOutPut;
  }
  
public function addLog($sLog) {
    fputs($this->rsLogger, $sLog);
  }
  
  public function removeCaracteres($sString) {

  	/**
  	 * matriz de entrada
  	 */
    $what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û',
    'Ä','Ã','À','Á','Â','Ê','Ë','È','É','Ï','Ì','Í','Ö','Õ','Ò','Ó','Ô','Ü','Ù','Ú','Û',
    'ñ','Ñ','ç','Ç','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','°', "°",chr(13),chr(10),"'");

    /**
  	 * matriz de saida
  	 */
    $by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u',
    'A','A','A','A','A','E','E','E','E','I','I','I','O','O','O','O','O','U','U','U','U',
    'n','N','c','C',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ', " "," "," "," ");

    return iconv('UTF-8', 'ISO-8859-1//IGNORE',str_replace($what, $by, $sString));
  }
  
}