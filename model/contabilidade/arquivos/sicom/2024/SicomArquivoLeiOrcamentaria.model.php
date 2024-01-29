<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

class SicomArquivoLeiOrcamentaria extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
  protected $iCodigoLayout = 138;
  
  protected $sNomeArquivo = 'LOA';
  
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
    
    $aElementos[10] = array("tipoRegistro", "nroLOA", "dataLOA", "dataPubLOA", "discriDespLOA");
    $aElementos[11] = array("tipoRegistro", "tipoAutorizacao", "percAutorizado");
    
    return $aElementos;
  }
  
  public function gerarDados()
  {
    require_once("model/ppaVersao.model.php");
    
    $oPPAVersao = new ppaVersao($this->getCodigoPespectiva());
    
    $oDadosLOA = new stdClass();

    $anoInicio = $oPPAVersao->getAnoinicio();

    $anoSessao =  db_getsession('DB_anousu');

    $anoReferencia = $anoSessao - intval($anoInicio);
    
    $sSqlLOA = "SELECT * ";
    $sSqlLOA .= "FROM ppaleidadocomplementar ";
    $sSqlLOA .= "	WHERE o142_ppalei = {$oPPAVersao->getCodigolei()}; ";
    
    $rsLOA = db_query($sSqlLOA);
    
    
    if (pg_num_rows($rsLOA) == 0) {
      throw new Exception("Não existe Lei Orçamentaria lançada.", 4);
    }
    
    $oLOA = db_utils::fieldsMemory($rsLOA, 0);
    
    $oDadosLOA->tipoRegistro  = 10;
    $oDadosLOA->detalhesessao = 10;
    $oDadosLOA->nroLOA        = returnFieldNameNroLOA($anoReferencia,$oLOA);
    $oDadosLOA->dataLOA       = returnFieldNameDataLOA($anoReferencia,$oLOA);
    $oDadosLOA->dataPubLOA    = returnFieldNameDataPubLOA($anoReferencia,$oLOA);
    $oDadosLOA->discriDespLOA = returnFieldNameDiscriDespLOA($anoReferencia,$oLOA);
    
    $this->aDados[] = $oDadosLOA;
    
    $oDadosPecentual = new stdClass();
    
    $oDadosPecentual->tipoRegistro    = 11;
    $oDadosPecentual->detalhesessao   = 11;
    $oDadosPecentual->tipoAutorizacao = 1;
    $oDadosPecentual->percAutorizado  = returnFieldNamePercAutorizado1($anoReferencia,$oLOA);
    $this->aDados[] = $oDadosPecentual;
    
    $oDadosPecentual = new stdClass();
    
    $oDadosPecentual->tipoRegistro    = 11;
    $oDadosPecentual->detalhesessao   = 11;
    $oDadosPecentual->tipoAutorizacao = 2;
    $oDadosPecentual->percAutorizado  = returnFieldNamePercAutorizado2($anoReferencia,$oLOA);
    $this->aDados[] = $oDadosPecentual;
    
    $oDadosPecentual = new stdClass();
    
    $oDadosPecentual->tipoRegistro    = 11;
    $oDadosPecentual->detalhesessao   = 11;
    $oDadosPecentual->tipoAutorizacao = 3;
    $oDadosPecentual->percAutorizado  = returnFieldNamePercAutorizado3($anoReferencia,$oLOA);
    $this->aDados[] = $oDadosPecentual;
    
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
function returnFieldNameNroLOA($anoReferencia,$oLOA) 
{
  switch($anoReferencia){
    case 0:
      return substr($oLOA->o142_numeroloa, 0, 6);
    case 1:
      return substr($oLOA->o142_numeroloaano2, 0, 6);
    case 2:
      return substr($oLOA->o142_numeroloaano3, 0, 6); 
    case 3:
      return substr($oLOA->o142_numeroloaano4, 0, 6);             
  }
}
function returnFieldNameDataLOA($anoReferencia,$oLOA) 
{
  switch($anoReferencia){
    case 0:
      return str_replace("-", "", implode("-", array_reverse(explode("-", $oLOA->o142_dataloa))));
    case 1:
      return str_replace("-", "", implode("-", array_reverse(explode("-", $oLOA->o142_dataloaano2))));
    case 2:
      return str_replace("-", "", implode("-", array_reverse(explode("-", $oLOA->o142_dataloaano3))));
    case 3:
      return str_replace("-", "", implode("-", array_reverse(explode("-", $oLOA->o142_dataloaano4))));           
  }
}
function returnFieldNameDataPubLOA($anoReferencia,$oLOA) 
{
  switch($anoReferencia){
    case 0:
      return str_replace("-", "", implode("-", array_reverse(explode("-", $oLOA->o142_datapubloa))));
    case 1:
      return str_replace("-", "", implode("-", array_reverse(explode("-", $oLOA->o142_datapubloaano2))));
    case 2:
      return str_replace("-", "", implode("-", array_reverse(explode("-", $oLOA->o142_datapubloaano3))));
    case 3:
      return str_replace("-", "", implode("-", array_reverse(explode("-", $oLOA->o142_datapubloaano4))));           
  }
}
function returnFieldNameDiscriDespLOA($anoReferencia,$oLOA) 
{
  switch($anoReferencia){
    case 0:
      return $oLOA->o142_orcmodalidadeaplic == "t" ? 2 : 1;
    case 1:
      return $oLOA->o142_orcmodalidadeaplicano2 == "t" ? 2 : 1;
    case 2:
      return $oLOA->o142_orcmodalidadeaplicano3 == "t" ? 2 : 1;
    case 3:
      return $oLOA->o142_orcmodalidadeaplicano4 == "t" ? 2 : 1;           
  }
}
function returnFieldNamePercAutorizado1($anoReferencia,$oLOA) 
{
  switch($anoReferencia){
    case 0:
      return number_format($oLOA->o142_percsuplementacao, 2, ",", "");
    case 1:
      return number_format($oLOA->o142_percsuplementacaoano2, 2, ",", "");
    case 2:
      return number_format($oLOA->o142_percsuplementacaoano3, 2, ",", "");
    case 3:
      return number_format($oLOA->o142_percsuplementacaoano4, 2, ",", "");           
  }
}
function returnFieldNamePercAutorizado2($anoReferencia,$oLOA) 
{
  switch($anoReferencia){
    case 0:
      return number_format($oLOA->o142_percopercredito, 2, ",", "");
    case 1:
      return number_format($oLOA->o142_percopercreditoano2, 2, ",", "");
    case 2:
      return number_format($oLOA->o142_percopercreditoano3, 2, ",", "");
    case 3:
      return number_format($oLOA->o142_percopercreditoano4, 2, ",", "");           
  }
}
function returnFieldNamePercAutorizado3($anoReferencia,$oLOA) 
{
  switch($anoReferencia){
    case 0:
      return number_format($oLOA->o142_percaro, 2, ",", "");
    case 1:
      return number_format($oLOA->o142_percaroano2, 2, ",", "");
    case 2:
      return number_format($oLOA->o142_percaroano3, 2, ",", "");
    case 3:
      return number_format($oLOA->o142_percaroano4, 2, ",", "");           
  }
}
