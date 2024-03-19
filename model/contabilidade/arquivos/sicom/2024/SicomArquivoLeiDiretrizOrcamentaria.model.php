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

    $anoInicio = $oPPAVersao->getAnoinicio();

    $anoSessao =  db_getsession('DB_anousu');

    $anoReferencia = $anoSessao - intval($anoInicio);
    
    $sSqlLDO = "SELECT * ";
    $sSqlLDO .= "FROM ppaleidadocomplementar ";
    $sSqlLDO .= "JOIN ppalei on o01_sequencial = o142_ppalei ";
    $sSqlLDO .= " WHERE o142_ppalei = {$oPPAVersao->getCodigolei()}";
    
    $rsLDO = db_query($sSqlLDO);
    // db_criatabela($rsLDO);
    
    $oLDO = db_utils::fieldsMemory($rsLDO, 0);
    
    
    $oDadosLDO->nroLDO            = returnFieldNameNroLDO($anoReferencia,$oLDO);
    $oDadosLDO->dataLDO           = returnFieldNameDataLDO($anoReferencia,$oLDO); 
    $oDadosLDO->dataPubLDO        = returnFieldNameDataPubLDO($anoReferencia,$oLDO);
    $oDadosLDO->nroLeiAlteracao   = returnFieldNameNroLeiAlteracaoLDO($anoReferencia,$oLDO);
    $oDadosLDO->dataLeiAlteracao  = returnFieldNameDataLeiAlteracaoLDO($anoReferencia,$oLDO);
    $oDadosLDO->dataPubLeiAlt     = returnFieldNameDataPubLeiAltLDO($anoReferencia,$oLDO);
    
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
function returnFieldNameNroLDO($anoReferencia,$oLDO) 
{ 
  switch($anoReferencia){
    case 0:
      return substr($oLDO->o01_numerolei, 0, 6);
    case 1:
      return substr($oLDO->o01_numeroleiano2, 0, 6);
    case 2:
      return substr($oLDO->o01_numeroleiano3, 0, 6); 
    case 3:
      return substr($oLDO->o01_numeroleiano4, 0, 6);             
  }
} 
function returnFieldNameDataLDO($anoReferencia,$oLDO) 
{
  switch($anoReferencia){
    case 0:
      return implode(array_reverse(explode("-", $oLDO->o142_dataldo)));
    case 1:
      return implode(array_reverse(explode("-", $oLDO->o142_dataldoano2)));
    case 2:
      return implode(array_reverse(explode("-", $oLDO->o142_dataldoano3)));
    case 3:
      return implode(array_reverse(explode("-", $oLDO->o142_dataldoano4)));             
  }
}
function returnFieldNameDataPubLDO($anoReferencia,$oLDO) 
{
  switch($anoReferencia){
    case 0:
      return implode(array_reverse(explode("-", $oLDO->o142_datapublicacaoldo)));
    case 1:
      return implode(array_reverse(explode("-", $oLDO->o142_datapublicacaoldoano2)));
    case 2:
      return implode(array_reverse(explode("-", $oLDO->o142_datapublicacaoldoano3)));
    case 3:
      return implode(array_reverse(explode("-", $oLDO->o142_datapublicacaoldoano4)));            
  }
}
function returnFieldNameNroLeiAlteracaoLDO($anoReferencia,$oLDO) 
{
  switch($anoReferencia){
    case 0:
      return $oLDO->o142_leialteracaoldo;
    case 1:
      return $oLDO->o142_leialteracaoldoano2;
    case 2:
      return $oLDO->o142_leialteracaoldoano3;
    case 3:
      return $oLDO->o142_leialteracaoldoano4;            
  }
}
function returnFieldNameDataLeiAlteracaoLDO($anoReferencia,$oLDO) 
{
  switch($anoReferencia){
    case 0:
      return implode(array_reverse(explode("-", $oLDO->o142_dataalteracaoldo)));
    case 1:
      return implode(array_reverse(explode("-", $oLDO->o142_dataalteracaoldoano2)));
    case 2:
      return implode(array_reverse(explode("-", $oLDO->o142_dataalteracaoldoano3)));
    case 3:
      return implode(array_reverse(explode("-", $oLDO->o142_dataalteracaoldoano4)));            
  }
}
function returnFieldNameDataPubLeiAltLDO($anoReferencia,$oLDO) 
{
  switch($anoReferencia){
    case 0:
      return implode(array_reverse(explode("-", $oLDO->o142_datapubalteracaoldo)));
    case 1:
      return implode(array_reverse(explode("-", $oLDO->o142_datapubalteracaoldoano2)));
    case 2:
      return implode(array_reverse(explode("-", $oLDO->o142_datapubalteracaoldoano3)));
    case 3:
      return implode(array_reverse(explode("-", $oLDO->o142_datapubalteracaoldoano4)));            
  }
}
