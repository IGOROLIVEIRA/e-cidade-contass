<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Decreto Municipal Regulamentador do Pregão / Registro de Preços Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoDecretoMunicipal extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 153;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'REGLIC';
  
  /**
   * 
   * Construtor da classe
   */
  public function __construct() {
    
  }
  
  /**
	 * Retorna o codigo do layout
	 *
	 * @return Integer
	 */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV 
   */
  public function getCampos(){
    
    $aElementos = array(
                          "codOrgao",
                          "tipoDecreto",
                          "nroDecretoMunicipal",
                          "dataDecretoMunicipal",
                          "dataPublicacaoDecretoMunicipal"	
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados de Decreto Municipal Regulamentador do Pregão / Registro de Preços do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
    
  	$sSql  = "SELECT * FROM db_config ";
	  $sSql .= "	WHERE prefeitura = 't'";
    	
	  $rsInst = db_query($sSql);
	  $sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;
	  
  	/**
  	 * selecionar arquivo xml com dados dos orgão
  	 */
    $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomorgao.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração dos orgãos do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oOrgaos      = $oDOMDocument->getElementsByTagName('orgao');
    
    /**
     * percorrer os orgaos retornados do xml para selecionar o orgao da inst logada
     * para selecionar os dados da instit
     */
    foreach ($oOrgaos as $oOrgao) {
      
    	if ($oOrgao->getAttribute('instituicao') == db_getsession("DB_instit")) {
          $sOrgao     = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
    	}
    	
    }
    
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgãos.");
    }
    
    /**
  	 * selecionar arquivo xml com dados do Decreto
  	 */

	  $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomdecpregaoregpreco.xml";
    
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração do decreto do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oDecretos      = $oDOMDocument->getElementsByTagName('decpregaoregpreco');
    
    /**
     * percorrer os dados retornados do xml para selecionar os decretos da inst logada
     */
    foreach ($oDecretos as $oDecreto) {
      
    	if ($oDecreto->getAttribute('instituicao') == db_getsession("DB_instit")) {
          
    	  $oDadosDecreto = new stdClass();

    	  $oDadosDecreto->codOrgao                        = $sOrgao;
    	  $oDadosDecreto->tipoDecreto                     = substr($oDecreto->getAttribute("tipoDecreto"), 1, 1);
	      $oDadosDecreto->nroDecretoMunicipal             = substr($oDecreto->getAttribute("nroDecretoMunicipal"), 0, 9);
	      $oDadosDecreto->dataDecretoMunicipal            = implode(explode("/", $oDecreto->getAttribute("dataDecretoMunicipal")));
	      $oDadosDecreto->dataPublicacaoDecretoMunicipal  = implode(explode("/", $oDecreto->getAttribute("dataPublicacaoDecretoMunicipal")));
	      
	      $this->aDados[] = $oDadosDecreto;
	      
    	}
    	
    }
    
    /*if (!isset($oDecreto)) {
      throw new Exception("Arquivo sem configuração de Decretos.");
    }*/
    
 }
		
  }
