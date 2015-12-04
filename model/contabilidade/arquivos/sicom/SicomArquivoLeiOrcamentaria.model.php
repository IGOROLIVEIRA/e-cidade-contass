<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

class SicomArquivoLeiOrcamentaria extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
  protected $iCodigoLayout = 138;
  
  protected $sNomeArquivo = 'LOA';
  
  protected $iCodigoPespectiva;
  
  public function __construct() {
    
  }
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV 
   */
  public function getCampos(){
    
    $aElementos  = array(
                          "nroLOA",
                          "dataLOA",
                          "dataPubLOA",
                          "percSuplementacao",
    											"percOpCredARO",
    											"percOpCredInt"
                        );
    return $aElementos;
  }
  
  public function gerarDados(){
    require_once ("model/ppaVersao.model.php");
    
    $oPPAVersao = new ppaVersao($this->getCodigoPespectiva());
    
    $oDadosLOA = new stdClass();
    
    $sSqlLOA  = "SELECT * ";
    $sSqlLOA .= "FROM ppaleidadocomplementar ";
    //$sSqlLOA .= "	WHERE o142_ppalei = 4";
    $sSqlLOA .= "	WHERE o142_ppalei = {$oPPAVersao->getCodigolei()}";
    $rsLOA    = db_query($sSqlLOA);

  	if (pg_num_rows($rsLOA) == 0) {
	      throw new Exception("Não existe Lei Orçamentaria lançada.", 4);
	 	}
	 	
    $oLOA  = db_utils::fieldsMemory($rsLOA, 0);
    
    
    $oDadosLOA->nroLOA        = substr($oLOA->o142_numeroloa, 0, 6);
    $oDadosLOA->dataLOA       = str_replace("-", "", implode("-", array_reverse(explode("-", $oLOA->o142_dataloa))));
    $oDadosLOA->dataPubLOA    = str_replace("-", "", implode("-", array_reverse(explode("-", $oLOA->o142_datapubloa))));
    $oDadosLOA->percSuplementacao = number_format($oLOA->o142_percsuplementacao,2,"",".");
    $oDadosLOA->percOpCredARO     = number_format($oLOA->o142_percaro,2,"",".");
    $oDadosLOA->percOpCredInt     = number_format($oLOA->o142_percopercredito,2,"",".");
    $this->aDados[] = $oDadosLOA;
    
  }
  
  public function setCodigoPespectiva($iCodigoPespectiva) {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }
  
  public function getCodigoPespectiva() {
    return $this->iCodigoPespectiva;
  }
}