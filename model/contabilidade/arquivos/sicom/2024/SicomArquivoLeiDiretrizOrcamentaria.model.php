<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

class SicomArquivoLeiDiretrizOrcamentaria extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
  protected $iCodigoLayout = 139;
  
  protected $sNomeArquivo = 'LDO';
  
  protected $iCodigoPespectiva;
  
  public function __construct()
  {
    
  }
  
  public function getCodigoLayout()
  {
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   */
  public function getCampos()
  {
    
    $aElementos = array(
      "nroLDO",
      "dataLDO",
      "dataPubLDO",
      "nroLeiAlteracao",
      "dataLeiAlteracao",
      "dataPubLeiAlt"
    );
    
    return $aElementos;
  }
  
  public function gerarDados()
  {
    require_once("model/ppaVersao.model.php");
    
    $oPPAVersao = new ppaVersao($this->getCodigoPespectiva());
    
    $oDadosLDO = new stdClass();
    
    $sSqlLDO = "SELECT * ";
    $sSqlLDO .= "FROM ppaleidadocomplementar ";
    $sSqlLDO .= " WHERE o142_ppalei = {$oPPAVersao->getCodigolei()}";
    
    
    $rsLDO = db_query($sSqlLDO);
    // db_criatabela($rsLDO);
    
    $oLDO = db_utils::fieldsMemory($rsLDO, 0);
    
    
    $oDadosLDO->nroLDO            = substr($oPPAVersao->getNumerolei(), 0, 6);
    $oDadosLDO->dataLDO           = implode(array_reverse(explode("-", $oLDO->o142_dataldo)));
    $oDadosLDO->dataPubLDO        = implode(array_reverse(explode("-", $oLDO->o142_datapublicacaoldo)));
    $oDadosLDO->nroLeiAlteracao   = '';
    $oDadosLDO->dataLeiAlteracao  = '';
    $oDadosLDO->dataPubLeiAlt     = '';
    
    $this->aDados[] = $oDadosLDO;
    
  }
  
  public function setCodigoPespectiva($iCodigoPespectiva)
  {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }
  
  public function getCodigoPespectiva()
  {
    return $this->iCodigoPespectiva;
  }
}
