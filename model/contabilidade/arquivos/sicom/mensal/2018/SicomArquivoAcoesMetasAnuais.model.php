<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Acoes e Metas Anuais Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoAcoesMetasAnuais extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 181;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'AMPANUAL';
  
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
   *metodo para passar os dados das Acoes e Metas pada o $this->aDados 
   */
  public function getCampos(){
    
    $aElementos[10] = array(
                          "tipoRegistro",
                          "possuiSubAcao",
                          "codAcao",
                          "codOrgao",
                          "codUnidade",
                          "codFuncao",
                          "codSubFuncao",
                          "codPrograma",
                          "idAcao",
                          "descAcao",
											    "finalidadeAcao",
											    "Produto",
											    "unidadeMedida",
											    "metasAno",
											    "recursosAno"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
                          "codAcao",
                          "codSubAcao",
                          "descSubAcao",
    											"finalidadeSubAcao",
											    "produtoSubAcao",
											    "unidadeMedida",
											    "metasAno",
											    "recursosAno"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados das receitas do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
    
  	/**
  	 * selecionar arquivo xml com dados dos orgao
  	 */
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
     */
    foreach ($oOrgaos as $oOrgao) {
      
    	if ($oOrgao->getAttribute('instituicao') == db_getsession("DB_instit")) {
        $sOrgao     = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
    	}
    	
    }
    
    $sSql = "SELECT 
 
	o58_orgao,
	o58_unidade,
	o58_funcao as codFuncao,
	o58_subfuncao as codSubFuncao,
	o58_programa as codPrograma,
	o58_projativ as idAcao,
	o55_descr as descAcao,
	o55_finali as finalidadeAcao,
	o22_descrprod as produto,
	o55_descrunidade as unidadeMedida,
	o55_valorunidade as metasAno,
	o47_valor as recursosAno
	
	from orcprojetolei 
		join orcprojetoorcprojetolei on o139_orcprojetolei = o138_sequencial
		join orcsuplem on o46_codlei = o139_orcprojeto
		join orcsuplemval on o47_codsup = o46_codsup
		join orcdotacao on o47_coddot = o58_coddot 
			and o47_anousu = o58_anousu 
			and o58_valor = 0
		join orcprograma on o58_anousu = o54_anousu 
			and o58_programa = o54_programa
		join orcprojativ on o58_anousu = o55_anousu
			and o58_projativ = o55_projativ
		join orcproduto on o55_orcproduto = o22_codproduto
		
	where o138_data between '{$this->sDataInicial}' 
		and '{$this->sDataFinal}' and o47_valor > 0";
    
    $rsAcoesMetas = db_query($sSql);
  
    /**
     * array para agrupar dados conforme o hash
     */
    $aDadosAgrupados = array();
    /**
     * percorrer resultados so sql acima
     */
    for ($iCont = 0; $iCont < pg_num_rows($rsAcoesMetas); $iCont++) {
    	
    	$oAcoesMetas = db_utils::fieldsMemory($rsAcoesMetas, $iCont);
    	$sHash  = $oAcoesMetas->idacao.$sOrgao.$oAcoesMetas->o58_orgao.$oAcoesMetas->o58_unidade.$oAcoesMetas->codfuncao;
    	$sHash .= $oAcoesMetas->codsubfuncao.$oAcoesMetas->codprograma.$oAcoesMetas->idacao;
    	
    	if (!isset($aDadosAgrupados[$sHash])) {
    		
    		$oDadosAcoesMetas = new stdClass();
    		$oDadosAcoesMetas->tipoRegistro   = 10;
    		$oDadosAcoesMetas->detalhesessao  = 10;
    		$oDadosAcoesMetas->possuiSubAcao  = 2;
    		$oDadosAcoesMetas->codAcao        = substr($oAcoesMetas->idacao, 0, 15);
    		$oDadosAcoesMetas->codOrgao       = $sOrgao;
    		$oDadosAcoesMetas->codUnidade     = str_pad($oAcoesMetas->o58_orgao, 2, "0", STR_PAD_LEFT);
    		$oDadosAcoesMetas->codUnidade    .= str_pad($oAcoesMetas->o58_unidade, 3, "0", STR_PAD_LEFT);
    		$oDadosAcoesMetas->codFuncao      = str_pad($oAcoesMetas->codfuncao, 2, "0", STR_PAD_LEFT);
    		$oDadosAcoesMetas->codSubFuncao   = str_pad($oAcoesMetas->codsubfuncao, 3, "0", STR_PAD_LEFT);
    		$oDadosAcoesMetas->codPrograma    = str_pad($oAcoesMetas->codprograma, 4, "0", STR_PAD_LEFT);
    		$oDadosAcoesMetas->idAcao         = str_pad($oAcoesMetas->idacao, 4, "0", STR_PAD_LEFT);
    		$oDadosAcoesMetas->descAcao       = substr($oAcoesMetas->descacao, 0, 100);
    		$oDadosAcoesMetas->finalidadeAcao = substr($oAcoesMetas->finalidadeacao, 0, 230);
    		$oDadosAcoesMetas->Produto        = substr($oAcoesMetas->produto, 0, 50);
    		$oDadosAcoesMetas->unidadeMedida  = substr($oAcoesMetas->unidademedida, 0, 15);
    		$oDadosAcoesMetas->metasAno       = $oAcoesMetas->metasano;
    		$oDadosAcoesMetas->recursosAno    = $oAcoesMetas->recursosano;
    		
    		$aDadosAgrupados[$sHash] = $oDadosAcoesMetas;
    		
    	} else {
    		
    		$aDadosAgrupados[$sHash]->metasAno    += $oAcoesMetas->metasano;
    		$aDadosAgrupados[$sHash]->recursosAno += $oAcoesMetas->recursosano;
    		
    	}
    	
    }

	    /**
	     * passar valores do array de dados para o array do csv
	     */
		  foreach ($aDadosAgrupados as $oDados) {
		  	
		  	$oDados->metasAno    = number_format($oDados->metasAno, 2, "", "");
		  	$oDados->recursosAno = number_format($oDados->recursosAno, 2, "", "");
		  	$this->aDados[]      = $oDados; 
		  	
		  }
    
    }
		
  }
