<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Cadastro de veiculo Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoCadVeiculo extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 155;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'CVC';
  
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
    
    $aElementos[10] = array(
    					  "tipoRegistro",
                          "codOrgao",
                          "codUnidade",
                          "exercicioLicitacao",
                          "nroProcessoLicitatorio",
                          "tipoResp",
    					  "nroCPFResp",
    					  "nomeResp",
    					  "logradouro",
    					  "bairroLogra",
    					  "codCidadeLogra",
    					  "ufCidadeLogra",
    					  "cepLogra",
    					  "telefone",
    					  "email",
                        );
    $aElementos[20] = array(
    					  "tipoRegistro",
                          "codOrgao",
                          "codUnidade",
                          "exercicioLicitacao",
                          "nroProcessoLicitatorio",
    					  "codTipoComissao",
    					  "descricaoAtoNomeacao",
    					  "nroAtoNomeacao",
    					  "dataAtoNomeacao",
    					  "inicioVigencia",
    					  "finalVigencia",
    					  "cpfMembroComissao",
    					  "nomMembroComLic",
    					  "codAtribuicao",
    					  "cargo",
    					  "naturezaCargo",
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
   * selecionar os dados de Cadastro de Veículos ou Equipamentos do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
    
  	/**
  	 * selecionar arquivo xml com dados dos orgão
  	 */
    $sArquivo = "config/sicom/sicomorgao.xml";
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
  	 * selecionar arquivo xml com dados do Decreto
  	 */
    
    $sSql  = "SELECT * FROM db_config ";
	$sSql .= "	WHERE prefeitura = 't'";
    	
	$rsInst = db_query($sSql);
	$sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;

	$sArquivo = "config/sicom/{$sCnpj}_sicomresplicitacao.xml";
    
   
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração do decreto do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oDecretos      = $oDOMDocument->getElementsByTagName('sicomresplicitacao');
    
    /**
     * percorrer os dados retornados do xml para selecionar os reponsaveis da inst logada
     * para selecionar os dados da instit
     */
    foreach ($oCadVeiculos as $oCadVeiculo) {
      
    	if ($oCadVeiculo->getAttribute('instituicao') == db_getsession("DB_instit")) {
          
    	  $oDadosCadVeiculo = new stdClass();

    	  $oDadosCadVeiculo->tipoRegistro  					= 11;
    	  $oDadosCadVeiculo->detalhesessao 					= 11;
    	  $oDadosCadVeiculo->codOrgao              			= $sOrgao;
    	  $oDadosCadVeiculo->codUnidade      				= str_pad($oCadVeiculo->getAttribute("codUnidade"), 5, "0", STR_PAD_LEFT);
	  	  $oDadosCadVeiculo->codVeiculo               		= substr($oCadVeiculo->getAttribute("codVeiculo"), 0, 10);
	  	  $oDadosCadVeiculo->nomeEstabelecimento            = substr($oCadVeiculo->getAttribute("nomeEstabelecimento"), 0, 250);
	  	  $oDadosCadVeiculo->localidade         			= substr($oCadVeiculo->getAttribute("localidade"), 0, 250);
	  	  $oDadosCadVeiculo->numeroPassageiros          	= number_format($oCadVeiculo->getAttribute("numeroPassageiros"), 2, "", "");
	  	  $oDadosCadVeiculo->distanciaEstabelecimento       = substr($oCadVeiculo->getAttribute("distanciaEstabelecimento"), 0, 5);
	  	  $oDadosCadVeiculo->turnos       					= str_pad($oCadVeiculo->getAttribute("turnos"), 2, "0", STR_PAD_LEFT);
	      
	      $this->aDados[] = $oDadosCadVeiculo;
 
    	}
    	
    }
    
    if (!isset($oCadVeiculo)) {
      throw new Exception("Arquivo sem configuração de Cadastro de veiculos.");
    }
    }
		
  }
