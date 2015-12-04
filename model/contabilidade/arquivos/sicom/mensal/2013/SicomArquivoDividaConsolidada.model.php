<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Divida Consolidada Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoDividaConsolidada extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 176;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'DDC';
  
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
                          "tipoLancamento",
                          "nroLeiAutorizacao",
                          "dtLeiAutorizacao",
                          "nroContrato",
    											"dataAssinatura",
    											"tipoDocumento",
    											"nroDocumento",
    											"nomeCredor",
    										  "justificativa",
					    					  "vlSaldoAnterior",
					    					  "vlContratacao",
					    					  "vlAmortizacao",
					    					  "vlCancelamento",
					    					  "vlEncampacao",
					    					  "vlAtualizacao",
					    					  "vlSaldoAtual",				  
                        );			
    return $aElementos;
  }
  
  /**
   * Parecer da Licitação do mes para gerar o arquivo
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
      
    	if($oOrgao->getAttribute('instituicao') == db_getsession("DB_instit")){
        $sOrgao     = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
    	}
    	
    }
    
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgãos.");
    }
    
    /**
  	 * selecionar arquivo xml com dados da divida
  	 */
	  $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomdividaconsolidada.xml";
    
   
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração da divida do sicom inexistente!");
    }
    
    
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oDividas     = $oDOMDocument->getElementsByTagName('dividaconsolidada');
    
    /**
     * percorrer os dados retornados do xml para selecionar as dividas da inst logada
     * para selecionar os dados da instit
     */
    $iMesReferencia = explode("-", $this->sDataInicial);
   
    foreach ($oDividas as $oDivida) {
      
    	if ($oDivida->getAttribute('instituicao') == db_getsession("DB_instit")
    	    && $oDivida->getAttribute('nroLeiAutorizacao') != ""
    	    && $oDivida->getAttribute('MesReferencia') == $iMesReferencia[1]) {
       
    	  $oDadosDivida = new stdClass();
	    	
	      $oDadosDivida->codOrgao              = $sOrgao;
		    $oDadosDivida->tipoLancamento        = str_pad($oDivida->getAttribute("tipoLancamento"), 2, "0", STR_PAD_LEFT);
		    $oDadosDivida->nroLeiAutorizacao     = substr($oDivida->getAttribute("nroLeiAutorizacao"), 0, 6);
		    $oDadosDivida->dtLeiAutorizacao      = str_replace("/", "", $oDivida->getAttribute("dtLeiAutorizacao"));
		    $oDadosDivida->nroContrato		       = substr($oDivida->getAttribute("nroContrato"), 0, 14);
		    $oDadosDivida->dataAssinatura	       = str_replace("/", "", $oDivida->getAttribute("dataAssinatura"));
		    $oDadosDivida->tipoDocumento	       = substr($oDivida->getAttribute("tipoDocumento"), 0, 1);
		    $oDadosDivida->nroDocumento	       	 = substr($oDivida->getAttribute("nroDocumento"), 0, 14);
		    $oDadosDivida->nomeCredor 	       	 = substr($oDivida->getAttribute("nroDocumento"), 0, 120);
		    $oDadosDivida->justificativa       	 = substr($oDivida->getAttribute("nroDocumento"), 0, 250);
		    $oDadosDivida->vlSaldoAnterior       = number_format($oDivida->getAttribute("vlSaldoAnterior"), 2, "", "");
		    $oDadosDivida->vlContratacao         = number_format($oDivida->getAttribute("vlContratacao"), 2, "", "");
		    $oDadosDivida->vlAmortizacao         = number_format($oDivida->getAttribute("vlAmortizacao"), 2, "", "");
		    $oDadosDivida->vlCancelamento        = number_format($oDivida->getAttribute("vlCancelamento"), 2, "", "");
		    $oDadosDivida->vlEncampacao          = number_format($oDivida->getAttribute("vlEncampacao"), 2, "", "");
		    $oDadosDivida->vlAtualizacao         = number_format($oDivida->getAttribute("vlAtualizacao"), 2, "", "");
		    $oDadosDivida->vlSaldoAtual          = number_format($oDivida->getAttribute("vlSaldoAtual"), 2, "", "");
	      
	      $this->aDados[] = $oDadosDivida;
 
    	}
    	
    }
    
    if (!isset($oDivida)) {
      throw new Exception("Arquivo sem configuração de Divida.");
    }
    
    
    
 }
		
  }			