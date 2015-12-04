<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * gerar arquivo de identificacao da Remessa Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoIdentificacaoRemessa extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 147;
  
  /**
   * 
   * NOme do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'IDE';
  
  /**
   * 
   * Contrutor da classe
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
    
    $aElementos  = array(
                          "codMunicipio",
                          "cnpjMunicipio",
    											"codOrgao",
    											"tipoOrgao",
                          "exercicioReferencia",
                          "mesReferencia",
                          "dataGeracao",
    											"codControleRemessa"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados de indentificacao da remessa pra gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados(){
 		
  	$sSql  = "SELECT * FROM db_config ";
		$sSql .= "	WHERE prefeitura = 't'";
    	
    $rsInst = db_query($sSql);
    $sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;
      
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
    	  
    		$sSql  = "SELECT db21_codigomunicipoestado,cgc,prefeitura FROM db_config ";
    	  $sSql .= "	WHERE codigo = ".db_getsession("DB_instit");
    	  
    	  $rsInst = db_query($sSql);
    	  $oInst  = db_utils::fieldsMemory($rsInst, 0);
    	    
    		if ($oOrgao->getAttribute('tipoOrgao') != "01") {
    	    $sCnpjMunic = str_pad($oInst->cgc, 14, "0", STR_PAD_LEFT);
    		} else {
    			$sCnpjMunic = $oOrgao->getAttribute('cnpjCamara');
    		}
			
	      $oDadosMunicipio = new stdClass();
	      
		    $oDadosMunicipio->codMunicipio           = str_pad($oInst->db21_codigomunicipoestado, 5, "0", STR_PAD_LEFT);
		    $oDadosMunicipio->cnpjMunicipio          = $sCnpjMunic;
		    $oDadosMunicipio->codOrgao							 = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
		    $oDadosMunicipio->tipoOrgao              = str_pad($oOrgao->getAttribute('tipoOrgao'), 2, "0", STR_PAD_LEFT);
		    $oDadosMunicipio->exercicioReferencia    = db_getsession("DB_anousu");
		    $oDadosMunicipio->mesReferencia          = $this->sDataFinal['5'].$this->sDataFinal['6'];
		    $oDadosMunicipio->dataGeracao            = implode(explode("-", date("d-m-Y")));
		    $oDadosMunicipio->codControleRemessa     = " ";
		    $this->aDados[] = $oDadosMunicipio;
		    
    	}
    	
    }
  
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgãos.");
    }
    
  }
}
