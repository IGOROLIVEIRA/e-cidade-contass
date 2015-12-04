<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * selecionar dados Unidade Orcamentaria Sicom Instrumento de Planejamento
  * @package Contabilidade
  */
class SicomArquivoUnidadeOrcamentaria extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
  protected $iCodigoLayout = 140;
  
  protected $sNomeArquivo = 'UOC';
  
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
                          "codOrgao",
                          "codUnidade",
                          "tipoIdUnidade",
    											"descUnidade"
                        );
    return $aElementos;
  }
  
  public function gerarDados(){
    //require_once ("model/ppaVersao.model.php");
    
    //$oPPAVersao = new ppaVersao($this->getCodigoPespectiva());
    
    //sicomoidentificadorunidade.xml
  	$sArquivo = "config/sicom/sicomorgao.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração dos orgãos do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oOrgaos      = $oDOMDocument->getElementsByTagName('orgao');
    foreach ($oOrgaos as $oOrgao) {
        
        $sSqlUnidade  = "SELECT * ";
		    $sSqlUnidade .= "FROM orcunidade ";
		    $sSqlUnidade .= "WHERE o41_anousu = ".db_getsession("DB_anousu")." AND O41_instit = {$oOrgao->getAttribute('instituicao')}";
		    $rsUnidade = db_query($sSqlUnidade);
		    //db_criatabela($rsUnidade);
		    //print_r($oOrgao);exit;
		    for ($iCont = 0; $iCont < pg_num_rows($rsUnidade); $iCont++) {
		      
		      $oUnidade =  db_utils::fieldsMemory($rsUnidade, $iCont);
		    	$oDadosUOC = new stdClass();	
		    	
		    	$iTipoUnidade = "";
		    	if($oUnidade->o41_ident[0] == '9'){
		    		$iTipoUnidade = $oUnidade->o41_ident[1].$oUnidade->o41_ident[2];
		    	}else{
		    		$iTipoUnidade = " ";
		    	}
		    	
			    $oDadosUOC->codOrgao        = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
			    $oDadosUOC->codUnidade      = str_pad($oUnidade->o41_orgao, 2, "0", STR_PAD_LEFT);
			    $oDadosUOC->codUnidade     .= str_pad($oUnidade->o41_unidade, 3, "0", STR_PAD_LEFT);
			    $oDadosUOC->tipoIdUnidade   = $iTipoUnidade;
			    $oDadosUOC->descUnidade     = substr($oUnidade->o41_descr, 0, 50);
			    
			    $this->aDados[] = $oDadosUOC;
		    }
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