<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * selecionar dados de Orgao Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoAmOrgao extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
  /**
   * 
   * Codigo do layout
   * @var Integer
   */
  protected $iCodigoLayout = 148;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var unknown_type
   */
  protected $sNomeArquivo = 'ORGAO';
  
  /**
   * 
   * Contrutor da classe
   */
  public function __construct() {
    
  }
  
  /**
   * retornar o codio do layout
   * 
   *@return Integer
   */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   *@return Array 
   */
  public function getCampos(){
    
    $aElementos[10] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "descOrgao",
                          "tipoOrgao",
                          "cnpjOrgao",
                          "lograOrgao",
                          "bairroLograOrgao",
                          "cepLograOrgao",
                          "telefoneOrgao",
                          "emailOrgao"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
                          "tipoResponsavel",
                          "nome",
                          "cartIdent",
    											"orgEmissorCi",
    											"cpf",
    											"crcContador",
    											"ufCrcContador",
    											"cargoOrdDespDeleg",
    											"dtInicio",
    											"dtFinal",
    											"logradouro",
    											"bairroLogra",
    											"codCidadeLogra",
    											"ufCidadeLogra",
    											"cepLogra",
    											"telefone",
    											"email"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados do Orgao referente a instituicao logada
   * 
   */
  public function gerarDados() {
    
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
    	  
        $sOrgao     = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
        $sTipoOrgao = str_pad($oOrgao->getAttribute('tipoOrgao'), 2, "0", STR_PAD_LEFT);
		    
    	}
    	
    }
  
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgãos.");
    }
    
    $sSql  = "SELECT * FROM db_config ";
    $sSql .= "	WHERE codigo = ".db_getsession("DB_instit");
    	
    $rsInst = db_query($sSql);
    $oInst  = db_utils::fieldsMemory($rsInst, 0);

		$oDadosOrgao  = new stdClass();
		$oDadosOrgao->detalhesessao    = 10;
		$oDadosOrgao->tipoRegistro     = 10; 
    $oDadosOrgao->codOrgao         = $sOrgao;
    $oDadosOrgao->descOrgao        = substr($oInst->nomeinst, 0, 100);
    $oDadosOrgao->tipoOrgao        = $sTipoOrgao;
    $oDadosOrgao->cnpjOrgao        = str_pad($oInst->cgc, 14, "0", STR_PAD_LEFT);
    $oDadosOrgao->lograOrgao       = substr($oInst->ender, 0, 75);
    $oDadosOrgao->bairroLograOrgao = substr($oInst->bairro, 0, 50);
    $oDadosOrgao->cepLograOrgao    = str_pad($oInst->cep, 8, "0", STR_PAD_LEFT);
    $oDadosOrgao->telefoneOrgao    = substr($oInst->telef, -10);
    $oDadosOrgao->emailOrgao       = substr($oInst->email, 0, 50);
    $this->aDados[] = $oDadosOrgao;
		
    /*
     * selecionar xml com dados dos resposáveis do orgão
     */    
    $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomidentresponsavel.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração de responsáveis inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oResponsaveis      = $oDOMDocument->getElementsByTagName('identresp');
    $aCaracteres = array("-","(",")","/");
    foreach ($oResponsaveis as $oResponsavel) {
    	
    	$dDtFimResp = implode("-", array_reverse(explode("/",$oResponsavel->getAttribute('dtFinal'))));
    	
    	if ($dDtFimResp >= $this->sDataFinal) {
    	
    	if($oResponsavel->getAttribute('instituicao') == db_getsession("DB_instit")){
    	  
        $sSql  = "SELECT * FROM cgm ";
        $sSql .= "	WHERE z01_numcgm = ".$oResponsavel->getAttribute("numCgm");
    	
        $rsResp = db_query($sSql);
        $oResp  = db_utils::fieldsMemory($rsResp, 0);
        
    		$oDadosResp = new stdClass();
    	  $oDadosResp->detalhesessao     = 11;
    	  $oDadosResp->tipoRegistro      = 11;
    	  $oDadosResp->tipoResponsavel   = str_pad($oResponsavel->getAttribute('tipoResponsavel'), 2, "0", STR_PAD_LEFT);
    	  $oDadosResp->nome              = substr($oResp->z01_nome, 0, 50);
    	  $oDadosResp->cartIdent         = substr($oResp->z01_ident, 0, 10);
    	  $oDadosResp->orgEmissorCi      = substr($oResponsavel->getAttribute('orgEmissorCi'), 0, 10);
    	  $oDadosResp->cpf               = substr($oResp->z01_cgccpf, 0, 11);
    	  $oDadosResp->crcContador       = substr($oResponsavel->getAttribute('crcContador'), 0, 10);
    	  $oDadosResp->ufCrcContador     = substr($oResponsavel->getAttribute('ufCrcContador'), 0, 2);
    	  $oDadosResp->cargoOrdDespDeleg = substr($oResponsavel->getAttribute('cargoOrdDespDeleg'), 0, 50);
    	  $oDadosResp->dtInicio          = implode(array_reverse(explode("-", $this->sDataInicial)));
    	  $oDadosResp->dtFinal           = implode(array_reverse(explode("-", $this->sDataFinal)));
    	  $oDadosResp->logradouro        = substr($oResp->z01_ender, 0, 75);
    	  $oDadosResp->bairroLogra       = substr($oResp->z01_bairro, 0, 75);
    	  $oDadosResp->codCidadeLogra    = substr($oResponsavel->getAttribute('codCidadeLogra'), 0, 5);
    	  $oDadosResp->ufCidadeLogra     = substr($oResp->z01_uf, 0, 2);
    	  $oDadosResp->cepLogra          = substr($oResp->z01_cep, 0, 8);
    	  $oDadosResp->telefone          = substr(str_replace($aCaracteres, "", $oResp->z01_telef), -10);
    	  $oDadosResp->email             = substr($oResp->z01_email, 0, 50);
    	  
    	  $this->aDados[] = $oDadosResp;
    	  
    	}
    	
    }
    	
    }
    if (!isset($oResponsavel)) {
      throw new Exception("Arquivo sem configuração de Responsáveis!");
    }
    
  }
}