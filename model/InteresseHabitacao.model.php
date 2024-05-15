<?php

class InteresseHabitacao {

  protected $iCodigo;
  
  protected $iCandidato;
  
  protected $iGrupo;
  
  protected $iTipo;
  
  public function __construct($iInteresse = '') {

    if (!empty($iInteresse)) {
      
      $oDaoInteresse  = db_utils::getDao("habitcandidatointeresse");
      $sSqlInteresses = $oDaoInteresse->sql_query_file($iInteresse);
      $rsInteresses   = $oDaoInteresse->sql_record($sSqlInteresses);
      if ($oDaoInteresse->numrows > 0) {
        
        $oDadosInteresse = db_utils::fieldsMemory($rsInteresses, 0);
        $this->setTipo($oDadosInteresse->ht20_tipo);
        $this->setGrupo($oDadosInteresse->ht20_habitgrupoprograma);
        $this->iCodigo    = $oDadosInteresse->ht20_sequencial;
        $this->iCandidato = $oDadosInteresse->ht20_habitcandidato;
        unset($oDadosInteresse);
      }
    }
       
  }
  /**
   * @return unknown
   */
  public function getCandidato() {

    return $this->iCandidato;
  }
  
  /**
   * @return unknown
   */
  public function getCodigo() {

    return $this->iCodigo;
  }
  
  /**
   * @return unknown
   */
  public function getGrupo() {

    return $this->iGrupo;
  }
  
  /**
   * @param unknown_type $iGrupo
   */
  public function setGrupo($iGrupo) {

    $this->iGrupo = $iGrupo;
  }
  
  /**
   * @return unknown
   */
  public function getTipo() {

    return $this->iTipo;
  }
  
  /**
   * @param unknown_type $iTipo
   */
  public function setTipo($iTipo) {

    $this->iTipo = $iTipo;
  }
  
  public function save($iCandidato) {
    
    $oDaoInteresse = new cl_habitcandidatointeresse;
    $oDaoInteresse->ht20_habitcandidato     = $iCandidato; 
    $oDaoInteresse->ht20_habitgrupoprograma = $this->getGrupo(); 
    $oDaoInteresse->ht20_tipo               = $this->getTipo(); 
    if (empty($this->iCodigo)) {
      
      $this->iCandidato = $iCandidato;
      $oDaoInteresse->incluir(null);
      $this->iCodigo = $oDaoInteresse->ht20_sequencial;
    } else {
      
      $oDaoInteresse->ht20_sequencial = $this->iCodigo;
      $oDaoInteresse->alterar($this->iCodigo);
    }
    if ($oDaoInteresse->erro_status == 0) {
      throw new Exception("Erro ao salvar interesse\n{$oDaoInteresse->erro_msg}");
    }
  }
}

?>