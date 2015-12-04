<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Projeção Atuarial Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoProjecaoAtuarial extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 177;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'PARPPS';
  
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
                          "exercicio",
                          "vlReceitaPrevidenciaria",
                          "vlDespesaPrevidenciaria",
                          "vlSaldoFinanceiroExercicioAnterior"	
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados de Projeção Atuarial do RPPS do mes para gerar o arquivo
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
  	 * selecionar arquivo xml com dados da Projeção
  	 */
	  $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomprojatuarialrpps.xml";
    
   
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração da Projeção Atuarial do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oProjecoes      = $oDOMDocument->getElementsByTagName('projatuarialrpps');
    
    /**
     * percorrer os dados retornados do xml para selecionar os Projeção Atuarial da inst logada
     * para selecionar os dados da instit
     */
    foreach ($oProjecoes as $oProjecao) {
      
    	if ($oProjecao->getAttribute('instituicao') == db_getsession("DB_instit")
    	    && $oProjecao->getAttribute('exercicio') != "") {
          
    	  $oDadosProjecao = new stdClass();

    	  $oDadosProjecao->codOrgao                               = $sOrgao;
	  	  $oDadosProjecao->exercicio                              = str_pad($oProjecao->getAttribute("exercicio"), 4, "0", STR_PAD_LEFT);
	  	  $oDadosProjecao->vlReceitaPrevidenciaria                = number_format($oProjecao->getAttribute("vlReceitaPrevidenciaria"), 2, "", "");
	  	  $oDadosProjecao->vlDespesaPrevidenciaria          	    = number_format($oProjecao->getAttribute("vlDespesaPrevidenciaria"), 2, "", "");
	  	  $oDadosProjecao->vlSaldoFinanceiroExercicioAnterior     = number_format($oProjecao->getAttribute("vlSaldoFinanceiroExercicioAnterior"), 2, "", "");
	      
	      $this->aDados[] = $oDadosProjecao;
 
    	}
    	
    }
    
    if (!isset($oProjecao)) {
      throw new Exception("Arquivo sem configuração de Projecões.");
    }
    
 }
		
  }