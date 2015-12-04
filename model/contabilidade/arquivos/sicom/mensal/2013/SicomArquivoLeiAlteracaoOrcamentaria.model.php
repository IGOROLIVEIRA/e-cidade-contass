<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * selecionar dados de Leis de Alteração Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoLeiAlteracaoOrcamentaria extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
  /**
   * 
   * Codigo do layout
   * @var Integer
   */
  protected $iCodigoLayout = 151;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var unknown_type
   */
  protected $sNomeArquivo = 'LAO';
  
  /**
   * 
   * Contrutor da classe
   */
  public function __construct() {
    
  }
  
  /**
   * retornar o codigo do layout
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
                          "tipoLeiAlteracao",
                          "nroLeiAlteracao",
                          "dataLeiAlteracao",
                          "artigoLeiAlteracao",
                          "descricaoArtigo",
                          "vlAutorizadoAlteracao"
                        );
    $aElementos[20] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "nroLeiAlterOrcam",
                          "dataLeiAlterOrcam",
    											"artigoLeiAlterOrcamento",
    											"descricaoArtigo",
    											"novoPercentual"
                        );
    $aElementos[30] = array(
                          "tipoRegistro",
                          "tipoDecretoAlteracao",
                          "nroDecreto",
                          "dataDecreto",
    											"nroLeiAlteracao",
    											"dataLeiAlteracao",
    											"valorAberto",
    											"origemRecAlteracao"
                       );
    return $aElementos;
  }
  
  /**
   * selecionar os dados de Leis de Alteração
   * 
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

			if ($oOrgao->getAttribute('tipoOrgao') == "02") {
				$sOrgao     = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
			} else {
	      	/**
	      	 * nao gerar se nao for prefeitura
	      	 */
	      	return;
	    }
			 
		}

		if (!isset($oOrgao)) {
			throw new Exception("Arquivo sem configuração de Orgãos.");
		}
		
		/**
		 * selecionar arquivo xml com dados das leis que autoriza a alteração orcamentarias
		 */
		$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomlimitecredito.xml";
		if (!file_exists($sArquivo)) {
			throw new Exception("Arquivo de configuração de leis que autoriza alteração orcamentarias inexistente!");
		}
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oLeis      = $oDOMDocument->getElementsByTagName('limitecredito');
		
		/**
		 * selecionar arquivo xml com dados das leis de alteração orcamentarias
		 */
		$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomaltlimitecredito.xml";
		if (!file_exists($sArquivo)) {
			throw new Exception("Arquivo de configuração de leis de alteração orcamentarias inexistente!");
		}
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oAltLeis      = $oDOMDocument->getElementsByTagName('altlimitecredito');
		
		/*
		 * array de caracteres a serem tirados do numero da lei e artigo
		 */
		$aCaracteres =  array("/", "-", ".");
		
		/*
		 * selecionar dados xml lei de alteração orcamentaria
		 */
		foreach ($oLeis as $olei) {
			
			if (implode("-", array_reverse(explode("/", $olei->getAttribute('dataLeiAlteracao')))) >= $this->sDataInicial
			    && implode("-", array_reverse(explode("/", $olei->getAttribute('dataLeiAlteracao')))) <= $this->sDataFinal) {
				
			  $oDadosLei = new stdClass();
			  $oDadosLei->tipoRegistro          = 10;
			  $oDadosLei->detalhesessao         = 10;  
			  $oDadosLei->codOrgao              = $sOrgao;
			  $oDadosLei->tipoLeiAlteracao      = $olei->getAttribute('tipoLeiAlteracao');
			  $oDadosLei->nroLeiAlteracao       = substr(str_replace($aCaracteres, "", $olei->getAttribute('nroLeiAlteracao')), 0, 6);
			  $oDadosLei->dataLeiAlteracao      = implode(explode("/", $olei->getAttribute('dataLeiAlteracao')));
			  $oDadosLei->artigoLeiAlteracao    = substr(str_replace($aCaracteres, "", $olei->getAttribute('artigoLeiAlteracao')), 0, 6);
			  $oDadosLei->descricaoArtigo       = substr(utf8_decode($olei->getAttribute('descricaoArtigo')), 0, 512);
			  $oDadosLei->vlAutorizadoAlteracao = number_format($olei->getAttribute('vlAutorizadoAlteracao'), 2, "", "");

			  $this->aDados[] = $oDadosLei;
			  
		  }
			
		}
    
		/*
		 * selecionar dados xml lei de alteração percentual
		 */
    foreach ($oAltLeis as $oAltLei) {
			
			if (implode("-", array_reverse(explode("/", $oAltLei->getAttribute('dataLeiAlterOrcam')))) >= $this->sDataInicial
			    && implode("-", array_reverse(explode("/", $oAltLei->getAttribute('dataLeiAlterOrcam')))) <= $this->sDataFinal) {
				
			  $oDadosAltLei = new stdClass();
			  $oDadosAltLei->tipoRegistro            = 20;
			  $oDadosAltLei->detalhesessao           = 20;  
			  $oDadosAltLei->codOrgao                = $sOrgao;
			  $oDadosAltLei->nroLeiAlterOrcam        = substr(str_replace($aCaracteres, $olei->getAttribute('nroLeiAlterOrcam')), 0, 6);
			  $oDadosAltLei->dataLeiAlterOrcam       = implode(explode("/", $olei->getAttribute('dataLeiAlterOrcam')));
			  $oDadosAltLei->artigoLeiAlterOrcamento = substr(str_replace($aCaracteres, $olei->getAttribute('artigoLeiAlterOrcamento')), 0, 6);
			  $oDadosAltLei->descricaoArtigo         = substr(utf8_decode($olei->getAttribute('descricaoArtigo')), 0, 512);
			  $oDadosAltLei->novoPercentual          = number_format($olei->getAttribute('novoPercentual'), 2, "", ""); 

			  $this->aDados[] = $oDadosAltLei;
			
			}
			
		}
		
		$sSql = "SELECT  o39_data as datadecreto,o39_numero,o45_numlei,o45_dataini,
	o47_coddot,o39_usalimite,o39_tipoproj,o47_codsup,o47_valor,
	
	(SELECT o48_coddocsup from orcsuplem 
		join orcsuplemtipo on  o46_tiposup = o48_tiposup 
	 where o46_codsup = o47_codsup) as doc,	

	 (SELECT o48_arrecadmaior from orcsuplem 
		join orcsuplemtipo on  o46_tiposup = o48_tiposup 
	 where o46_codsup = o47_codsup) as arrecadmaior,
	 
	 (SELECT o48_superavit from orcsuplem 
		join orcsuplemtipo on  o46_tiposup = o48_tiposup 
	 where o46_codsup = o47_codsup) as superavit
from orcprojeto
	join orclei on o39_codlei = o45_codlei 
	join orcsuplem on o46_codlei = o39_codproj
	join orcsuplemval on o47_codsup = o46_codsup
where o39_data >= '".$this->sDataInicial."' and o39_data <= '".$this->sDataFinal."' and o47_valor > 0";
		
		$rsDecretos = db_query($sSql);
		$aDecretosAgrupados = array();
		for ($iCont = 0; $iCont < pg_num_rows($rsDecretos); $iCont++) {
			
		  $oDecretos = db_utils::fieldsMemory($rsDecretos, $iCont);
		  
			if ($oDecretos->doc == 14) {
		  	$oDecretos->o39_tipoproj = 4;
		  } else {
		    if ($oDecretos->o39_usalimite == 'f') {
		  	  $oDecretos->o39_tipoproj = 3;
		    }
		  }
		  
		  $sOrigemRecAlteracao = "03";

		  if ($oDecretos->superavit == "t") {
		  	$sOrigemRecAlteracao = "01";
		  } else {
			  if ($oDecretos->arrecadmaior != 0) {
		  	  $sOrigemRecAlteracao = "02";
		    }
		  }
		  
		  if ($oDecretos->o39_tipoproj == 3 || $oDecretos->o39_tipoproj == 4 || $oDecretos->o39_tipoproj == 5) {
		  	$sOrigemRecAlteracao = " ";
		  }
		  
		  $sHash  = $oDecretos->o39_tipoproj.substr(preg_replace("/[^0-9\s]/", "", $oDecretos->o39_numero), 0, 8);
		  $sHash .= $oDecretos->o45_dataini.$sOrigemRecAlteracao;
		  
		  if (!isset($aDecretosAgrupados[$sHash])) {
		  
		  	$sSqlLoa  = "select o142_dataloa from ppaleidadocomplementar where o142_numeroloa = '";
		  	$sSqlLoa .= preg_replace("/[^0-9\s]/", "", $oDecretos->o45_numlei)."'";
		  	$rsLoa = db_query($sSqlLoa);
		  	
		  	if (pg_num_rows($rsLoa) > 0) {
		  		
		  		$sDataLeiAlteracao = db_utils::fieldsMemory($rsLoa, 0)->o142_dataloa;
		  		$sDataLeiAlteracao = implode(array_reverse(explode("-", $sDataLeiAlteracao)));
		  		
		  	} else {
		  		
		  		foreach ($oLeis as $olei) {
		  			
		  			
		  			if ($olei->getAttribute('nroLeiAlteracao') == preg_replace("/[^0-9\s]/", "", $oDecretos->o45_numlei)) {
		  				$sDataLeiAlteracao = implode(explode("/", $olei->getAttribute('dataLeiAlteracao')));
		  			}
		  			
		  		}
		  		
		  	}
			  $oDadosDecretos = new stdClass();
			  $oDadosDecretos->tipoRegistro         = 30;
			  $oDadosDecretos->detalhesessao        = 30;
			  $oDadosDecretos->tipoDecretoAlteracao = $oDecretos->o39_tipoproj;
			  $oDadosDecretos->nroDecreto           = substr(preg_replace("/[^0-9\s]/", "", $oDecretos->o39_numero), 0, 8);
			  $oDadosDecretos->dataDecreto          = implode(array_reverse(explode("-", $oDecretos->datadecreto)));
			  $oDadosDecretos->nroLeiAlteracao      = substr(str_replace($aCaracteres, "", $oDecretos->o45_numlei), 0, 6);
			  $oDadosDecretos->dataLeiAlteracao     = $sDataLeiAlteracao;
			  $oDadosDecretos->valorAberto          = number_format($oDecretos->o47_valor, 2, "", "");
			  $oDadosDecretos->origemRecAlteracao   = $sOrigemRecAlteracao;
			  $aDecretosAgrupados[$sHash] = $oDadosDecretos;
		  
		  } else {
		  	$aDecretosAgrupados[$sHash]->valorAberto += number_format($oDecretos->o47_valor, 2, "", "");
		  }
						
		}
		
		foreach ($aDecretosAgrupados as $oDecretosAgrupados) {
			$this->aDados[] = $oDecretosAgrupados;
		}
		
  }
  
}