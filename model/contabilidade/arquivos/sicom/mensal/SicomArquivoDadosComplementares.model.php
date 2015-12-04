<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Dados Complementares Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoDadosComplementares extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 178;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'DCLRF';
  
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
                          "vlSaldoAtualConcGarantia",
                          "recPrivatizacao",
                          "vlLiqIncentContrib",
                          "vlLiqIncentInstFinanc",
    					            "vlIRPNPIncentContrib",
    					            "vlIRPNPIncentInstFinanc"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados de Dados Complementares à LRF do mes para gerar o arquivo
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
  	 * selecionar arquivo xml com dados complementares
  	 */

	  $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomdadoscomplementalrf.xml";
    
   
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração do dados complementares do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oDadosComps      = $oDOMDocument->getElementsByTagName('dadoscomplementalrf');
    
    /**
     * percorrer os dados retornados do xml para selecionar os dados complementares da inst logada
     * para selecionar os dados da instit
     */
    foreach ($oDadosComps as $oDadosComp) {
      
    	if ($oDadosComp->getAttribute('instituicao') == db_getsession("DB_instit")
    	    && $oDadosComp->getAttribute("vlSaldoAtualConcGarantia") != "") {
          
    	  $oDadosDadosComp = new stdClass();

    	  $oDadosDadosComp->codOrgao                    = $sOrgao;
		    $oDadosDadosComp->vlSaldoAtualConcGarantia    = number_format($oDadosComp->getAttribute("vlSaldoAtualConcGarantia"), 2, "", "");
		    $oDadosDadosComp->recPrivatizacao             = number_format($oDadosComp->getAttribute("recPrivatizacao"), 2, "", "");
		    $oDadosDadosComp->vlLiqIncentContrib          = number_format($oDadosComp->getAttribute("vlLiqIncentContrib"), 2, "", "");
		    $oDadosDadosComp->vlLiqIncentInstFinanc       = number_format($oDadosComp->getAttribute("vlLiqIncentInstFinanc"), 2, "", "");
		    $oDadosDadosComp->vlIRPNPIncentContrib        = number_format($oDadosComp->getAttribute("vlIRPNPIncentContrib"), 2, "", "");
		    $oDadosDadosComp->vlIRPNPIncentInstFinanc     = number_format($oDadosComp->getAttribute("vlIRPNPIncentInstFinanc"), 2, "", "");
	      
	      $this->aDados[] = $oDadosDadosComp;
 
    	}
    	
    }
    
    if (!isset($oDadosComp)) {
      throw new Exception("Arquivo sem configuração de Dados complementares");
    }
    
 }
		
  }