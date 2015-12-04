<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * selecionar dados de Orgaos Sicom Instrumento de Planejamento
  * @package Contabilidade
  */
class SicomArquivoPercentualAquisicao extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
  protected $iCodigoLayout = 217;
  
  protected $sNomeArquivo = 'PERC';
  
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
                          "contemplaPerc",
                          "percentualEstabelecido"
                        );
    return $aElementos;
  }
  
  public function gerarDados() {
    $oDados->contemplaPerc          = "2";
    $oDados->percentualEstabelecido = "0,00";
    $sSql = "select * from percentualaquisicao WHERE si90_anoreferencia = ".db_getsession("DB_anousu");
    $rsResult = db_query($sSql);
    $oResul = db_utils::fieldsMemory($rsResult, 0);
    
    $oDados = new stdClass();
    $oDados->contemplaPerc          = $oResul->si90_contemplaperc;
    $oDados->percentualEstabelecido = $oResul->si90_percentualestabelecido;
	$this->aDados[] = $oDados;
	
	
	
    
  }
  public function setCodigoPespectiva($iCodigoPespectiva) {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }
  
  public function getCodigoPespectiva() {
    return $this->iCodigoPespectiva;
  }
}