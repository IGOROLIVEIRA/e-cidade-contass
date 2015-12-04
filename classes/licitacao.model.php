<?

class licitacao {


  private $iCodLicitacao   = null;
  private $aItensLicitacao = array();
  private $oDados          = null;
  private $oDaoLicita      = null;
  function __construct($iCodLicitacao = null) {

    if (!empty($iCodLicitacao)) {
      $this->iCodLicitacao = $iCodLicitacao;
    }
    $this->oDaoLicita  = db_utils::getDao("liclicita");

  }


  /**
   * traz os Processos de compra VInculadas a licitacao.
   * @return array
   */ 

  function getProcessoCompras() {

    if ($this->iCodLicitacao == null) {

      throw new exception("Código da licitacao nulo");
      return false;

    }
    $oDaoLicitem  = db_utils::getDao("liclicitem");
    $sCampos      = "distinct pc80_codproc,coddepto, descrdepto,login,pc80_data,pc80_resumo";
    $rsProcessos  = $oDaoLicitem->sql_record(
                    $oDaoLicitem->sql_query_inf(null, $sCampos,"pc80_codproc",
                                                      "l21_codliclicita = {$this->iCodLicitacao}")
        );
    if ($oDaoLicitem->numrows > 0) {

      for ($iInd = 0; $iInd < $oDaoLicitem->numrows; $iInd++) {

        $aSolicitacoes[] = db_utils::fieldsMemory($rsProcessos, $iInd); 
      }
      return $aSolicitacoes;
    } else {
      return false;
    }

  }
  /**
   * retorna os Dados da Licitacao
   * @return object
   */
  function getDados() {

     $rsLicita     = $this->oDaoLicita->sql_record($this->oDaoLicita->sql_query($this->iCodLicitacao));
     $this->oDados = db_utils::fieldsMemory($rsLicita, 0);
     return $this->oDados;

  }
}
