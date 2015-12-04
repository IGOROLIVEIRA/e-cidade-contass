<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Alterações Orçamentárias Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoAlteracoesOrcamentarias extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 152;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'AOC';
  
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
    			  								"codReduzido",
                  					"codOrgao",
					                  "codUnidadeSub",
					                  "codFuncao",
					                  "codSubFuncao",
					                  "codPrograma",
					                  "idAcao",
    												"idSubAcao",
					                  "elementoDespesa",
								    			  "codFontRecursos",
								    			  "nroDecreto",
								    		    "dataDecreto",	
								    			  "tipoAlteracao",
								        		"vlAlteracao"
                        );

    $aElementos[11] = array(
						    					  "tipoRegistro",
						    					  "codReduzido",
	                          "codFontRecursos",
	                          "valorAlteracaoFonte"
                        );
                        
    return $aElementos;
  }
  
  /**
   * selecionar os dados de alteracoes orcamentarias do mes para gerar o arquivo
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
    		
	    	$sTrataCodUnidade = $oOrgao->getAttribute('trataCodUnidade');
	    	if($oOrgao->getAttribute('tipoOrgao') == "02"){
	        $sOrgao = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);        
	      } else {
	      	/**
	      	 * nao gerar se nao for prefeitura
	      	 */
	      	return;
	      }
	      
    	}
    	
    }
    
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgãos.");
    }
    
    /**
		 * selecionar arquivo xml de dados elemento da despesa
		 */
		$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomelementodespesa.xml";
		if (!file_exists($sArquivo)) {
		  throw new Exception("Arquivo de elemento da despesa inexistente!");
	 	}
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oElementos = $oDOMDocument->getElementsByTagName('elemento');
    
		
    $sSql  = "SELECT o49_codsup, o49_data, o47_coddot, o47_valor, o46_tiposup, o48_coddocsup, 
    		   o48_coddocred, o48_superavit, o48_suplcreditoespecial, o48_redcreditoespecial, 
    		   o48_suplcreditoespecial,o39_tipoproj,o39_usalimite,o39_numero,o39_data from orcsuplemlan 
    		   join orcsuplemval on o47_codsup = o49_codsup join orcsuplem on o46_codsup = o49_codsup 
    		   join orcsuplemtipo on o48_tiposup = o46_tiposup join orcprojeto on o39_codproj = o46_codlei 
			   where o49_data >= '".$this->sDataInicial."' and o49_data <= '".$this->sDataFinal."' ";
    
      $rsAlter = db_query($sSql);
   
    /**
     * percorrer registros de contas retornados do sql acima
     */
    $aDadosAgrupados = array();
    for ($iCont = 0;$iCont < pg_num_rows($rsAlter); $iCont++) {
		    	
      $oAlter = db_utils::fieldsMemory($rsAlter,$iCont);
            
      $sSql2 = "SELECT o58_coddot,o58_orgao, o58_unidade, o58_funcao, o58_subfuncao,  o58_programa, o58_projativ, o15_codtri, o56_elemento from orcdotacao 
      join orcelemento on o58_codele = o56_codele 
      join orctiporec on o58_codigo = o15_codigo  
      where o58_coddot = ".$oAlter->o47_coddot." and o58_anousu = ". db_getsession('DB_anousu')." and o56_anousu = ". db_getsession('DB_anousu')." ";
     
      $rsAlter2 = db_query($sSql2);
     
      for ($iCont2 = 0;$iCont2 < pg_num_rows($rsAlter2); $iCont2++) {
      
      	$oAlter2  = db_utils::fieldsMemory($rsAlter2,$iCont2);
      	
      	if ($sTrataCodUnidade == "01") {
      		
      		$sCodUnidade  = str_pad($oAlter2->o58_orgao, 2, "0", STR_PAD_LEFT);
	   		  $sCodUnidade .= str_pad($oAlter2->o58_unidade, 3, "0", STR_PAD_LEFT);
	   		  
      	} else {
      		
      		$sCodUnidade	= str_pad($oAlter2->o58_orgao, 3, "0", STR_PAD_LEFT);
	   		  $sCodUnidade .= str_pad($oAlter2->o58_unidade, 2, "0", STR_PAD_LEFT);
      		
      	}
      	
        if ( $oAlter->o47_valor < 0 && $oAlter->o39_usalimite == "f" ) {
   		    $sTipoAlteracao					  = "07";
	   		} elseif ( $oAlter->o47_valor < 0 && $oAlter->o39_usalimite == "t" ) {
		      $sTipoAlteracao					  = "06";
	   		} elseif ( $oAlter->o47_valor > 0 && $oAlter->o39_tipoproj == 1 && $oAlter->o39_usalimite == "t" ) {
	   		  $sTipoAlteracao					  = "01";
	   		} elseif ( $oAlter->o47_valor > 0 && $oAlter->o39_tipoproj == 2 && $oAlter->o39_usalimite == "t" ) {
	   		  $sTipoAlteracao					  = "02";
	   		} elseif ( $oAlter->o47_valor > 0 && ($oAlter->o39_tipoproj == 2 || $oAlter->o39_tipoproj == 1) && $oAlter->o39_usalimite == "f" ) {
	   		  $sTipoAlteracao					  = "08";
	   		} else {
	   		  $sTipoAlteracao                     = "01";
	   		}
      	
      	$sHash  = $sOrgao.$sCodUnidade.$oAlter2->o58_funcao.$oAlter2->o58_subfuncao.$oAlter2->o58_programa.$oAlter2->o58_projativ;
      	$sHash .= $oAlter2->o56_elemento.$oAlter2->o15_codtri.preg_replace("/[^0-9\s]/", "", $oAlter->o39_numero).$oAlter->o39_data.$sTipoAlteracao;
      	
      	if (!isset($aDadosAgrupados[$sHash])) {
      	
      	  $sElemento = substr($oAlter2->o56_elemento, 1, 8);
         /**
          * percorrer xml elemento despesa
          */
          foreach ($oElementos as $oElemento) {
      	
      	  if ($oElemento->getAttribute('instituicao') == db_getsession("DB_instit") 
						&& $oElemento->getAttribute('elementoEcidade') == $sElemento) {
							
      	    $sElemento = $oElemento->getAttribute('elementoSicom');
      	    break; 	
      	  
      	  }
      	
        }
      		
		      $oDadosAlter = new stdClass();
		        
		        $oDadosAlter->tipoRegistro  				= 10;
		        $oDadosAlter->detalhesessao  				= 10;
		        $oDadosAlter->codReduzido					  = substr(($oAlter->o49_codsup.$oAlter2->o58_coddot), 0, 15);         
		        $oDadosAlter->codOrgao              = $sOrgao;
		        $oDadosAlter->codUnidadeSub 			  = $sCodUnidade;
			   		$oDadosAlter->codFuncao						  = str_pad($oAlter2->o58_funcao, 2, "0", STR_PAD_LEFT);
			   		$oDadosAlter->codSubFuncao					= str_pad($oAlter2->o58_subfuncao, 3, "0", STR_PAD_LEFT);
			   		$oDadosAlter->codPrograma					  = str_pad($oAlter2->o58_programa, 4, "0", STR_PAD_LEFT);
			   		$oDadosAlter->idAcao						    = str_pad($oAlter2->o58_projativ, 4, "0", STR_PAD_LEFT);
			   		$oDadosAlter->idSubAcao					    = " ";
			   		$oDadosAlter->elementoDespesa				= substr($sElemento, 0, 6);
			   		$oDadosAlter->codFontRecursos				= str_pad($oAlter2->o15_codtri, 3, "0", STR_PAD_LEFT);
			   		$aCaracteres = array('/', "-", ".");
			   		$oDadosAlter->nroDecreto					  = substr(preg_replace("/[^0-9\s]/", "", $oAlter->o39_numero), 0, 8);
			   		$oDadosAlter->dataDecreto					  = implode(array_reverse(explode("-", $oAlter->o39_data))); 
			   		$oDadosAlter->tipoAlteracao	        = $sTipoAlteracao;
		   		
		   		  if ( $oDadosAlter->tipoAlteracao == 1 || $oDadosAlter->tipoAlteracao == 2 ) {
		   		  
			   		  if ( $oAlter->o48_superavit == "t") {	
			   		    $oDadosAlter->origemRecAlteracao  					  = "01"; 
			   		  } elseif ( o48_coddocsup == 54 ) {
			   		  	$oDadosAlter->origemRecAlteracao  					  = "02"; 
			   		  } elseif ( o48_coddocsup == 52 ) {
			   		  	$oDadosAlter->origemRecAlteracao  					  = "04"; 
			   		  } elseif ( o48_coddocsup == 55 ) {
			   		  	$oDadosAlter->origemRecAlteracao  					  = "05";
			   		  } else {
			   		  	$oDadosAlter->origemRecAlteracao  					  = "03";
			   		  }
		   		
		   		  } 
		   		$oDadosAlter->vlAlteracao = $oAlter->o47_valor;
		   		
		   		
		   		$aDadosAgrupados[$sHash] = $oDadosAlter;
		   		
      	} else {
      		
      		$aDadosAgrupados[$sHash]->vlAlteracao += $oAlter->o47_valor;
   		    
      	}
   		
      }
   
    }
    
    foreach ($aDadosAgrupados as $oDados) {
    	$oDados->vlAlteracao = abs(number_format($oDados->vlAlteracao, 2, "", ""));
    	$this->aDados[] = $oDados;
    }
    
    }
		
  }
