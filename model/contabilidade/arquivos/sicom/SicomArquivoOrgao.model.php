<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * selecionar dados de Orgaos Sicom Instrumento de Planejamento
  * @package Contabilidade
  */
class SicomArquivoOrgao extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
  protected $iCodigoLayout = 106;
  
  protected $sNomeArquivo = 'ORGAO';
  
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
    
    $aElementos = array(
                          "codOrgao",
                          "cpfGestor",
                          "tipoOrgao"
                        );
    return $aElementos;
  }
  
  public function gerarDados() {
    
    $sArquivo = "config/sicom/sicomorgao.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração dos orgãos do sicom inexitente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oOrgaos      = $oDOMDocument->getElementsByTagName('orgao');
    
    foreach ($oOrgaos as $oOrgao) {

				$oDadosOrgao  = new stdClass();
        $oDadosOrgao->codOrgao = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
        $oDadosOrgao->cpfGestor = $oOrgao->getAttribute('cpfGestor');
        $oDadosOrgao->tipoOrgao = str_pad($oOrgao->getAttribute('tipoOrgao'), 2, "0", STR_PAD_LEFT);
        $this->aDados[] = $oDadosOrgao;
        
    }
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgãos.");
    }
  }
  public function setCodigoPespectiva($iCodigoPespectiva) {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }
  
  public function getCodigoPespectiva() {
    return $this->iCodigoPespectiva;
  }
}