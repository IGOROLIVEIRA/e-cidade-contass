<?php
/**
 * @fileoverview - Classe de Modelo para movimentações do Alvará 
 * @author    Rafael Serpa Nery - rafael.nery@dbseller.com.br	
 * @package   ISSQN
 * @revision  $Author: dbrafael.nery $
 * @version   $Revision: 1.2 $
 */
require_once('libs/db_stdlib.php');
require_once('libs/db_utils.php');

abstract class AlvaraMovimentacao {
  
  /**
   * Código com o alvara que será realizada a movimentação
   * @var integer
   */
  private $iCodigoAlvara        = null;
  
  /**
   * Sequencial da Tabela issmovalvara
   * @var integer
   */
  private $iCodigoMovimentacao  = null;
  
  /**
   * Tipo de Movimentacao do Alvará
   * Dados cadastrados na tabela isstipomovalvara
   * @var integer
   */
  private $iTipoMovimentacao    = null;
  
  /**
   * Data da ocorrência da movimentcao
   * @var date
   */
  private $dtMovimentacao       = null;
  
  /**
   * Id do usuario que realizou a movimentacao
   * @var integer
   */
  private $iIdUsuario           = null;
  
  /**
   * 
   * Observação da movimentacao
   * @var string
   */
  private $sObservacao          = "";
  
  /**
   * Número do processo do protocolo, na tabela issmovalvaraproc
   * @var integer
   */
  private $iCodigoProcesso      = null;
  
 /**
  * Dias da validade do alvará
  * @var integer
  */
  private $iValidadeAlvara      = null;
  
  /**
   * Array dos documentos da movimentação
   * @var array
   */
  private $aDocumentos          = array();
  
  /**
   * Construtor da funcao
   */
  function __construct($iCodigoAlvara = null){
    
    if(!empty($iCodigoAlvara)){
      
      $this->iCodigoAlvara = $iCodigoAlvara;
      $this->iIdUsuario    = db_getsession("DB_login");
    } else {
      
      throw new ErrorException("Selecione o Alvará que deseja realizar a movimentacao");
    }
    
  }
  
  
  /**
   * Salva movimentação do alvará
   * @see iMovimentacaoAlvara::salvar()
   */  
  protected function salvar() {
    /**
     * Seta variável para executar uma nova inserção
     */
    $this->setCodigoMovimentacao(null);
    
    if ($this->$iTipoMovimentacao == null) {
      throw new ErrorException("Sem tipo de movimentação setada");
    }
    if(db_utils::inTransaction()){
      
      $oDaoIssMovAlvara  = db_utils::getDAO("issmovalvara",true);
      
      $oDaoIssMovAlvara->q120_issalvara         = $this->getCodigoAlvara();
      $oDaoIssMovAlvara->q120_isstipomovalvara  = $this->getTipoMovimentacao();
      $oDaoIssMovAlvara->q120_dtmov             = $this->getDataMovimentacao();
      $oDaoIssMovAlvara->q120_usuario           = $this->getIdUsuario();
      $oDaoIssMovAlvara->q120_obs               = $this->getObservacao();
      $oDaoIssMovAlvara->q120_validadealvara    = $this->getValidadeAlvara();
      $oDaoIssMovAlvara->q120_issalvara         = $this->getCodigoAlvara();
      $oDaoIssMovAlvara->incluir("");
      
      if($oDaoIssMovAlvara != "0"){
        /**
         * Grava os Documentos 
         */
        $this->gravaDocumentos($this->aDocumentos);
        /**
         * Grava os Processos
         */
        if($this->getCodigoProcesso() == null){
          $this->gravaProcesso();
        }
      } else {
        throw new ErrorException($oDaoIssMovAlvara->erro_msg);
      }
    } else {
      throw new ErrorException("Sem transação ativa no banco de dados");
    }
  }
    
  /**
   * Adiciona documento a lista de documentos da movimentação do alvará
   * @param integer $iCodigoDocumento - SEQUENCIA TABELA caddocumento
   */
  public function addDocumento($iCodigoDocumento){
    $this->aDocumentos[] = $iCodigoDocumento;
  }
  
  /**
   * Salva os Documentos da movimentação
   * Enter description here ...
   * @param unknown_type $aDocumentos
   */
  private function gravaDocumentos($aDocumentos){
    
    $oDaoIssMovAlvaraDocumento = db_utils::getDAO('issalvaradocumento');
    
    foreach ($aDocumentos as $iDocumento){
      
      $oDaoIssMovAlvaraDocumento->q122_issmovalvara = $this->getCodigoMovimentacao();
      $oDaoIssMovAlvaraDocumento->q122_caddocumento = $iDocumento;
      $oDaoIssMovAlvaraDocumento->incluir("");
      if($oDaoIssMovAlvaraDocumento->erro_status == "0"){
        throw new ErrorException($oDaoIssMovAlvaraDocumento->erro_msg);
      } 
    }
  }

  /**
   * Salva o Processo ligado a movimentacao
   * Enter description here ...
   */
  private function gravaProcesso(){
    
    $oDaoIssMovAlvaraProcesso  = db_utils::getDAO("issmovalvaraprocesso",true);
    
    $oDaoIssMovAlvaraProcesso->q124_codproc      = $this->getCodigoProcesso();
    $oDaoIssMovAlvaraProcesso->q124_issmovalvara = $this->getCodigoMovimentacao();
    $oDaoIssMovAlvaraProcesso->incluir("");
    if($oDaoIssMovAlvaraProcesso->erro_status == "0"){
      throw new ErrorException($oDaoIssMovAlvaraProcesso->erro_msg);
    }
  }

  /**
   * Método de que busca as movimentações do alvará
   * @return array;
   */
  public function getMovimentacoesAlvara(){
    
    $oDaoIssMovAlvara = db_utils::getDAO("issmovalvara",true);
    $sSqlMovAlvara    = $oDaoIssMovAlvara->sql_query_file(null, "*", "q120_issalvara = {$this->getCodigoAlvara()}");
    $rsSqlMovAlvara   = $oDaoIssMovAlvara->sql_record($sSqlMovAlvara);
    
    if($oDaoIssMovAlvara->num_rows == 0){
      return array();
    } else {
      return db_utils::getColectionByRecord($rsSqlMovAlvara);
    }
  }

  public function getCodigoUltimaMovimentacao(){
    
  }
  /**
   * Retorna array com os códigos(caddocumento) de documentos 
   * Depende que o Código da Movimentação esteja setado
   */
  public function getDocumentosMovimentacao(){
    
    if($this->iCodigoMovimentacao == null){
      throw new ErrorException("Código da movimentação não está setado");
    }
    
    $oDaoIssMovAlvaraDocumento  = db_utils::getDAO('issalvaradocumento');
    $sSqlIssMovAlvaraDocumento  = $oDaoIssMovAlvaraDocumento->sql_query_file(null,"q122_caddocumento", "q122_issmovalvara = {$this->iCodigoMovimentacao}");
    $rsSqlIssMovAlvaraDocumento = $oDaoIssMovAlvaraDocumento->sql_record($sSqlIssMovAlvaraDocumento);
    if($oDaoIssMovAlvaraDocumento->num_rows == 0){
      return array();
    } else {
      
      $aIssMovAlvaraDocumentos = db_utils::getColetionByRecord($rsSqlIssMovAlvaraDocumento);
      
      foreach ($aIssMovAlvaraDocumentos as $oDocumentos) {
        $aDocumentos[] = $oDocumentos->q122_caddocumento;
      }
      return $aDocumentos;
    }
  }
  
  
  /* Setters */
  
  /**
   * Seta valor da variável $iCodigoMovimentacao
   * @param integer $iCodigoMovimentacao
   */
  public function setCodigoMovimentacao($iCodigoMovimentacao) {

    $this->iCodigoMovimentacao = $iCodigoMovimentacao;
    return $this;
  }
  
  /**
  * Seta valor da variável $iTipoMovimentacao
  * @param integer $iTipoMovimentacao
  */
  public function setTipoMovimentacao($iTipoMovimentacao) {
    $this->iTipoMovimentacao = $iTipoMovimentacao;
    return $this;
  }
  
  /**
  * Seta valor da variável $dtMovimentacao
  * @param date $dtMovimentacao
  */
  public function setDataMovimentacao($dtMovimentacao) {
    $this->dtMovimentacao = $dtMovimentacao;
    return $this;
  }
  
  /**
  * Seta valor da variável $sObservacao
  * @param strinfg $sObservacao
  */
  public function setObservacao($sObservacao) {
    $this->sObservacao = $sObservacao;
    return $this;
  }
  
  /**
  * Seta valor da variável $iCodigoProcesso
  * @param integer $iCodigoProcesso
  */
  public function setCodigoProcesso($iCodigoProcesso) {
    $this->iCodigoProcesso = $iCodigoProcesso;
    return $this;
  }
  
 /**
  * Seta validade do alvará $iCodigoProcesso
  * @param integer $iCodigoProcesso
  */
  public function setValidadeAlvara($iValidadeAlvara) {
    $this->iValidadeAlvara = $iValidadeAlvara;
    return $this;
  }
  
  /* Getters */
  
  /**
   * Retorna valor da variável $iCodigoAlvara
   * @return integer $iCodigoAlvara
   */
  public function getCodigoAlvara() {
    return $this->iCodigoAlvara;
  }

 /**
  * Retorna valor da variável $iCodigoMovimentacao
  * @return integer $iCodigoMovimentacao
  */
  public function getCodigoMovimentacao() {
    return $this->iCodigoMovimentacao;
  }
  
 /**
  * Retorna valor da variável $iTipoMovimentacao
  * @return integer $iTipoMovimentacao
  */
  public function getTipoMovimentacao() {
    return $this->iTipoMovimentacao;
  }
  
 /**
  * Retorna valor da variável $dtMovimentacao
  * @return date $dtMovimentacao
  */
  public function getDataMovimentacao() {
    return $this->dtMovimentacao;
  }
  
 /**
  * Retorna valor da variável $iIdUsuario
  * @return integer $iIdUsuario
  */
  public function getIdUsuario() {
    return $this->iIdUsuario;
  }
  
  /**
  * Retorna valor da variável $sObservacao
  * @return integer $sObservacao
  */
  public function getObservacao() {
    return $this->sObservacao;
  }
  
  /**
  * Retorna valor da variável $iCodigoProcesso
  * @return integer $iCodigoProcesso
  */
  public function getCodigoProcesso() {
    return $this->iCodigoProcesso;
  }
  
  /**
  * Retorna valor da variável $iCodigoProcesso
  * @return integer $iCodigoProcesso
  */
  public function getValidadeAlvara() {
    return $this->$iValidadeAlvara;
  }
  /**
   * Retorna um array com os códigos dos documentos vinculados a movimentacao do alvara;
   */
  public function getDocumentosMovimentacao(){
        
  }
}
?>
