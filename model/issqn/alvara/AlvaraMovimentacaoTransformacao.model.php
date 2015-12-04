<?php
require_once 'model/issqn/AlvaraMovimentacao.model.php';


class AlvaraMovimentacaoTransformacao extends AlvaraMovimentacao {

  /**
   * Id da entidade issgrupotipoalvara 
   *
   * @var Integer
   */
  protected $iGrupoTipoAlvara;
  /**
   * Id da entidade isstipoalvara 
   *
   * @var Integer
   */  
  protected $iTipoAlvara;
  /**
   * Id da entidade issbase 
   *
   * @var Integer
   */  
  protected $iInscricao;
  
  /**
   * Construtor da Classe.
   * Deve ser passado o Código do Alvará por parâmetro
   *
   * @param Integer $iCodAlvara
   */
  public function __construct($iCodAlvara) {
    parent::__construct($iCodAlvara);
  }
  
  /**
   * Este método insere uma nova movimentação na entidade issmovalvara e altera o código do tipo do alvara na 
   * entidade issalvara
   *
   */
  public function transformar() {
    
    try {
      db_inicio_transacao();
      try {
        parent::salvar();
      } catch (Exception $oException) {
        throw new Exception($oException->getMessage());      
      }
      
      $oDaoIssAlvara = db_utils::getDAO("issalvara",true);

      $oDaoIssAlvara->q123_isstipoalvara = $this->iTipoAlvara;
      $oDaoIssAlvara->q123_sequencial    = $this->getCodigoAlvara();      
      
      $oDaoIssAlvara->alterar($this->getCodigoAlvara());
      
      if($oDaoIssAlvara->erro_status == "0") {
        throw new Exception($oDaoIssAlvara->erro_msg);
      }
      db_inicio_transacao(false);
    } catch (Exception $oException) {
      echo $oException->getMessage(); 
      db_inicio_transacao(true);
    }
  }
  /**
   * Seta valor da Variavel $iGrupoTipoAlvara
   *
   * @param Integer $iGrupo
   */
  public function setGrupoTipo($iGrupo) {
    $this->iGrupoTipoAlvara = $iGrupo;
  }
    
  /**
   * Seta valor da Variavel $iTipoAlvara
   *
   * @param Integer $iTipo
   */
  public function setTipo($iTipo) {
    $this->iTipoAlvara = $iTipo ;
  }
  
  /**
   * Seta valor da Variavel $iInscricao
   *
   * @param Integer $iInscricao
   */
  public function setInscricao($iInscricao) {
    $this->iInscricao = $iInscricao ;
  }
  
  /**
  * Retorna valor da variável $iInscricao
  * @return integer $iInscricao
  */
  protected function getInscricao() {
    return $this->iInscricao;
  }
  
  /**
  * Retorna valor da variável $iGrupoTipoAlvara
  * @return integer $iGrupoTipoAlvara
  */
  protected function getGrupoTipo() {
    return $this->iGrupoTipoAlvara;
  }
  
  /**
  * Retorna valor da variável $iTipoAlvara
  * @return integer $iTipoAlvara
  */
  protected function getTipo() {
    return $this->iTipoAlvara;
  }
  
}


?>
