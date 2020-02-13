<?php

require_once("model/contabilidade/arquivos/msc/".db_getsession("DB_anousu")."/MSC.model.php");

class MSCCsv extends MSC {

  //@var String
  protected $sArquivo;

  //@var String
  protected $sDelimiter = ";";

  //@var String
  protected $_arquivo;

  //@var String
  protected $sLinha;

  function abreArquivo() {
    $this->_arquivo = fopen($this->sArquivo . '.csv', "w");
  }

  function fechaArquivo() {
    fclose($this->_arquivo);
  }

  function adicionaLinha() {
    $aLinha = array();
    foreach ($this->sLinha as $sLinha) {
      if ($sLinha == '' || $sLinha == null) {
        $sLinha = ' ';
      }
      $aLinha[] = $sLinha;
    }
    $sLinha = implode(";", $aLinha);
    fputs($this->_arquivo, $sLinha);
    fputs($this->_arquivo, "\r\n");
  }

  public function gerarArquivoCSV($aMscRegistros) {

    $this->sArquivo = $this->getNomeArq();
    $this->abreArquivo();

    $aCSV['identifier']       = $this->getIdentifier();
    $aCSV['periodIdentifier'] = $this->getPeriodIdentifier();
    $this->sLinha = $aCSV;
    $this->adicionaLinha();

    $aCabecalhoCSV['ContaContabil'] = 'ContaContabil';

    for ($ic = 1; $ic <= 6; $ic++) {
      $IC     = 'IC'.$ic;
      $TipoIC = "TipoIC".$ic;
      $aCabecalhoCSV[$IC]     = $IC;
      $aCabecalhoCSV[$TipoIC] = $TipoIC;
    }

    $aCabecalhoCSV['Valor']         = 'Valor';
    $aCabecalhoCSV['TipoValor']     = 'TipoValor';
    $aCabecalhoCSV['NaturezaValor'] = 'NaturezaValor';
    $this->sLinha = $aCabecalhoCSV;
    $this->adicionaLinha();

    foreach($aMscRegistros as $aRegistros) {
      foreach ($aRegistros->registros as $account) {
        $this->setRegistrosContas($account);
        $this->addLinhas();
      }
    }

    $this->fechaArquivo();

  }

  public function addLinhas() {

    $aMscCsv[0] = $this->getConta();

    $iIC = 1;
    for ($ic = 1; $ic <= 12; $ic+=2) {
      $IC        = "iIC".$iIC;
      $getIC     = "getIC".$iIC;
      $getTipoIC = "getTipoIC".$iIC;
      if (!empty($this->{$IC})) {
        $aMscCsv[$ic]   = $this->{$getIC}();
        $aMscCsv[$ic+1] = $this->{$getTipoIC}();
      } else {
        $aMscCsv[$ic]   = '';
        $aMscCsv[$ic+1] = '';
      }
      $iIC++;
    }

    $aMscCsv[13] = $this->getValor();
    $aMscCsv[14] = $this->getTipoValor();
    $aMscCsv[15] = $this->getNaturezaValor();
    $this->sLinha = $aMscCsv;
    $this->adicionaLinha();

  }

  public function setRegistrosContas($oRegistro) {

    $this->limpaRegistrosContas();

    $this->setConta($oRegistro->conta);

    for ($ic = 1; $ic <= 6; $ic++) {
      $IC     = "IC".$ic;
      $TipoIC = "TipoIC".$ic;
      $setIC  = "setIC".$ic;
      $setTipoIC = "setTipoIC".$ic;
      if (isset($oRegistro->{$IC})) {
        $this->{$setIC}($oRegistro->{$IC});
        $this->{$setTipoIC}($oRegistro->{$TipoIC});
      }
    }

    $this->setValor($oRegistro->valor);
    $this->setTipoValor($oRegistro->tipoValor);
    $this->setNaturezaValor($oRegistro->nat_vlr);


  }

  public function limpaRegistrosContas() {

    $this->iConta = "";

    for ($ic = 1; $ic <= 6; $ic++) {
      $IC     = "iIC".$ic;
      $TipoIC = "sTipoIC".$ic;
      $this->{$IC} = "";
      $this->{$TipoIC} = "";
    }

    $this->iValor = "";
    $this->sTipoValor = "";
    $this->sNaturezaValor = "";

  }

}

