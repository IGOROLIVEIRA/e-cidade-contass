<?php
/**
 * Classe 
 * @author bruno.silva
 * @package orcamento
 * @version $Revision: 1.1 $
 */
class ProgramaIniciativa {
  
  /**
   * Sequencial da tabela orciniciativa
   * @var integer
   */
  private $iCodigoSequencial;
  
  /**
   * Descriчуo sucinta da iniciativa
   * @var string
   */
  private $sIniciativa;
  
  /**
   * Descriчуo completa da iniciativa
   * @var string
   */
  private $sDescricao;

  public function getCodigoSequencial() {
    return $this->iCodigoSequencial;
  }
  
  public function setCodigoSequencial($iCodigoSequencial) {
    $this->iCodigoSequencial = $iCodigoSequencial;
  }
  
  public function getIniciativa() {
    return $this->sIniciativa;
  }
  
  public function setIniciativa($sIniciativa) {
    $this->sIniciativa = $sIniciativa;
  }
  
  public function getDescricao() {
    return $this->sDescricao;
  }
  
  public function setDescricao($sDescricao) {
    $this->sDescricao = $sDescricao;
  }
  
  
  function __construct($iCodigoSequencial = null) {
    
    if (!empty($iCodigoSequencial)) {
      
      $oDAOOrciniciativa = db_utils::getDao("orciniciativa");
      $sSQL              = $oDAOOrciniciativa->sql_query_file(null, "*", null, "o147_sequencial ={$iCodigoSequencial}");
      $rsResultado       = $oDAOOrciniciativa->sql_query($sSQL);
      
      if ($oDAOOrciniciativa->erro_status == 0) {
        
        $sMensagemErro  = "Erro Tщcnico: erro ao carregar dados da Iniciativa {$iCodigoSequencial}.";
        $sMensagemErro .= $oDAOOrciniciativa->erro_msg;
        throw new Exception($sMensagemErro);
      }
      
      $oIniciativa             = db_utils::fieldsMemory($rsResultado, 0);
      $this->iCodigoSequencial = $oIniciativa->o147_sequencial;
      $this->sDescricao        = $oIniciativa->o147_descricao;
      $this->sIniciativa       = $oIniciativa->o147_iniciativa;
    }
  }
  
  /**
   * Salva os dados da iniciativa, caso o sequъncial seja nulo
   * Do contrсrio, altera a iniciativa 
   */
  function salvar() {
    
    $oDAOOrciniciativa                  = db_utils::getDao("orciniciativa");
    $oDAOOrciniciativa->o147_descricao  = $this->sDescricao;  
    $oDAOOrciniciativa->o147_iniciativa = $this->sIniciativa;

    if (empty($this->iCodigoSequencial)) {
      $oDAOOrciniciativa->incluir(null);
    } else {
      
      $oDAOOrciniciativa->o147_sequencial = $this->iCodigoSequencial;
      $oDAOOrciniciativa->alterar($this->iCodigoSequencial);
    }
    
    if ($oDAOOrciniciativa->erro_status == 0) {
      $sMensagemErro  = "Erro Tщcnico: erro ao salvar dados da Iniciativa.";
      $sMensagemErro .= $oDAOOrciniciativa->erro_msg;
      throw new Exception($sMensagemErro);
    }
  }
  
  
  
  
}

?>