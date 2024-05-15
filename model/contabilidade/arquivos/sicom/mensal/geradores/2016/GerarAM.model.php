
<?php

class GerarAM {
  /**
  *
  * @var String
  */
  protected $sArquivo;

  /**
  *
  * @var String
  */
  protected $sDelimiter = ";"; 

  /**
  *
  * @var String
  */
  protected $_arquivo;

  /**
  *
  * @var String
  */
  protected $sLinha;

  function abreArquivo() {
		$this->_arquivo = fopen($this->sArquivo.'.csv', "w" );
  }
	
  function fechaArquivo() {
		fclose ( $this->_arquivo );
  }
	
  function adicionaLinha() {
  	$aLinha = array();
  	foreach ($this->sLinha as $sLinha){
  		if ($sLinha == '' || $sLinha == null) {
  			$sLinha = ' ';
  		}
  		$aLinha[] = $sLinha;
  	}
  	$sLinha = implode(";", $aLinha);
		fputs($this->_arquivo, $sLinha);
		fputs($this->_arquivo,"\r\n");
  }

}
