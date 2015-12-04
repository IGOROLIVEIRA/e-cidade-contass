<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Contratos Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoContratos extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 163;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'CONTRATOS';
  
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
   *esse metodo sera implementado criando um array com os campos que serao necessarios 
   *para o escritor gerar o arquivo CSV 
   */
  public function getCampos(){
    
    $aElementos[10] = array(
						    					  "tipoRegistro",
						    					  "codContrato",
						                "codOrgao",
						                "codUnidadeSub",
						    					  "nroContrato",
						    					  "dataAssinatura",
						    					  "nomContratadoParcPublico",
						                "tipoDocumento",
						    					  "nroDocumento",
						    	  				"representanteLegalContratado",
						    					  "cpfrepresentanteLegal",
						    					  "nroProcessoLicitatorio",
						    					  "exercicioProcessoLicitatorio",
						    					  "naturezaObjeto",
						    					  "objetoContrato",
						    					  "tipoInstrumento",
						    					  "dataInicioVigencia",
						    					  "dataFinalVigencia",
						    					  "vlContrato",
						    					  "formaFornecimento",
						    					  "formaPagamento",
						    					  "prazoExecucao",
						    					  "multaRescisoria",
						    					  "multaInadimplemento",
						    					  "garantia",
						    					  "signatarioContratante",
						    					  "cpfsignatarioContratante",
						    					  "dataPublicacao",
						    					  "veiculoDivulgacao"
                        );
    $aElementos[11] = array(
    					              "tipoRegistro",
                            "codContrato",
                            "descricaoItem",
                            "quantidadeItem",
    					              "unidade",
                            "valorUnitarioItem"
    					);
    $aElementos[12] = array(
						    					  "tipoRegistro",
						                "codContrato",
						    					  "codOrgao",
						                "codUnidadeSub",
						                "codFuncao",
						                "codSubFuncao",
												    "codPrograma",
						    					  "idAcao",
    												"idSubAcao",
						     					  "elementoDespesa",
						    					  "codFontRecursos"
    					);
    $aElementos[13] = array(
    												"tipoRegistro",
                            "codContrato",
    												"tipoDocumento",
                            "nroDocumento",
                            "nomeCredor"
    					);
    $aElementos[40] = array(
    					              "tipoRegistro",
                            "codOrgao",
                            "codUnidadeSub",
                            "nroContrato",
                            "dataAssinaturaContOriginal",
						                "dataRescisao",
    					              "valorCancelamentoContrato"
    					);
    $aElementos[20] = array(
						    					  "tipoRegistro",
						                "codAditivo",
						                "codOrgao",
						                "codUnidadeSub",
						                "nroContrato",
												    "dataAssinaturaContOriginal",
						    					  "tipoTermoAditivo",
						     					  "dscAlteracao",
						    					  "nroSeqTermoAditivo",
						    					  "dataAssinaturaTermoAditivo",
						    					  "novaDataTermino",
						    					  "valorAditivo",
						    					  "valorAtualizadoContrato",
						    					  "dataPublicacao",
						    					  "veiculoDivulgacao"
    					);
    $aElementos[21] = array(
    					              "tipoRegistro",
                            "codAditivo",
                            "descricaoItem",
                            "quantidadeItem",
                            "unidade",
						                "valorUnitarioItem"
    					);
    					
    $aElementos[30] = array(
    					              "tipoRegistro",
                            "codOrgao",
                            "codUnidadeSub",
                            "nroContrato",
                            "dataAssinaturaContOriginal",
						                "tipoApostila",
                            "nroSeqApostila",
                            "dataApostila",
                            "dscAlteracao"
    					);
    return $aElementos;
  }
  
  /**
   * Contratos mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
    
  	$sSql  = "SELECT * FROM db_config ";
	  $sSql .= "	WHERE prefeitura = 't'";
    	
	  $rsInst = db_query($sSql);
	  $sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;
	
  	/**
  	 * selecionar arquivo xml com dados dos orgao
  	 */
    $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomorgao.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuracao dos orgaos do sicom inexistente!");
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
    		
        $sOrgao           = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
        $sTrataCodUnidade = $oOrgao->getAttribute('trataCodUnidade');
        
    	}
    	
    }
    
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuracao de Orgaos.");
    }
    
    /**
     * Carregando xml de contratos
     */	
    $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomcontratos.xml";
	 
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuracao dos contratos do sicom inexistente!");
    }
     
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oContratos   = $oDOMDocument->getElementsByTagName('contrato');
    /**
     * Carregando xml do empenho
     */
    $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomdotacao.xml";
	
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuracao da dotacao do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oEmpenhos    = $oDOMDocument->getElementsByTagName('dotacao');
    
     /**
     * Carregando xml de Rescisao
     */
    $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomrescisaocontrato.xml";
	
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuracao da rescisao do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oRescisoes    = $oDOMDocument->getElementsByTagName('rescisaocontrato');
    
     /**
     * Carregando xml de Aditivos
     */
    $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomaditivoscontratos.xml";
	
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuracao dos aditivos do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oAditivos    = $oDOMDocument->getElementsByTagName('aditivoscontrato');
    
     /**
     * Carregando xml de Itens Aditivos
     */
    
    $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomitensaditivados.xml";
	
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuracao dos aditivos do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oItensAditivos    = $oDOMDocument->getElementsByTagName('itensaditivado');
    
     /**
	* selecionar arquivo xml de Dados Compl Licitação
	*/
	$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomdadoscompllicitacao.xml";
	if (!file_exists($sArquivo)) {
		throw new Exception("Arquivo de dados compl licitacao inexistente!");
	}
	$sTextoXml    = file_get_contents($sArquivo);
	$oDOMDocument = new DOMDocument();
	$oDOMDocument->loadXML($sTextoXml);
	$oDadosComplLicitacoes = $oDOMDocument->getElementsByTagName('dadoscompllicitacao');

	 /**
	  * array para fazer hash dos dados registro 12
	  */
	 $aChaveDadosReg11 = array();
   $aChaveDadosReg12 = array();
    /**
     * Percorre as informacoes do xml contratos
     */
    foreach ($oContratos as $oContrato) {
    
    	if ($oContrato->getAttribute('instituicao') == db_getsession("DB_instit") && 
    	  implode("-", array_reverse(explode("/", $oContrato->getAttribute("dataAssinatura")))) >= $this->sDataInicial && 
    	  implode("-", array_reverse(explode("/", $oContrato->getAttribute("dataAssinatura")))) <= $this->sDataFinal) {

    	  $sSql   = "SELECT l20_codigo,l20_anousu from liclicita "; 
    	  $sSql  .= "where l20_codigo = ".$oContrato->getAttribute("nroProcessoLicitatorio");
    
    	  $rsContrato = db_query($sSql);
    	  
     	  $oReg = db_utils::fieldsMemory($rsContrato, 0);

     	  if (strlen($oContrato->getAttribute("nroDocumento")) == 11 ) {
     	    $iTipoDocumento = 1;	
     	  }else{
     	  	$iTipoDocumento = 2;
     	  }
     	  
     	  $sNumProcesso = " ";
				$sExercicioProcesso = " ";
     	  foreach ($oDadosComplLicitacoes as $oDadosComplLicitacao) {
			
			if ($oDadosComplLicitacao->getAttribute('instituicao') == db_getsession("DB_instit")
				&& $oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio') == $oReg->l20_codigo
				&& $oContrato->getAttribute("nroProcessoLicitatorio") != "") {
					
					$sNumProcesso = substr($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);
					$sExercicioProcesso = str_pad($oDadosComplLicitacao->getAttribute('ano'), 4, "0", STR_PAD_LEFT);
					
				}
     
     	 }
     	  //echo $oContrato->getAttribute("codigo")."<br>";
    	  $oDadosContrato = new stdClass();
    	  	
    	  $oDadosContrato->tipoRegistro  				        = 10;
    	  $oDadosContrato->codContrato						      = substr($oContrato->getAttribute("codigo"), 0, 15);
    	  $oDadosContrato->detalhesessao 				        = 10;
    	  $oDadosContrato->codOrgao                     = $sOrgao;
    	  $oDadosContrato->codUnidadeSub				        = " ";
    	  $oDadosContrato->nroContrato                  = substr(str_replace("/", "", $oContrato->getAttribute("nroContrato")), 0, 14);
    	  $oDadosContrato->dataAssinatura   				    = str_replace("/", "", $oContrato->getAttribute("dataAssinatura"));
    	  $oDadosContrato->nomContratadoParcPublico		  = utf8_decode(substr($oContrato->getAttribute("nomContratadoParcPublico"), 0, 120));
    	  $oDadosContrato->tipoDocumento					      = $iTipoDocumento;
    	  $oDadosContrato->nroDocumento						      = substr($oContrato->getAttribute("nroDocumento"), 0, 14);
    	  $oDadosContrato->representanteLegalContratado	= utf8_decode(substr($oContrato->getAttribute("representanteLegalContratado"), 0, 50));
    	  $oDadosContrato->cpfrepresentanteLegal			  = str_pad($oContrato->getAttribute("cpfrepresentanteLegal"), 11, "0", STR_PAD_LEFT);
    	  $oDadosContrato->nroProcessoLicitatorio			  = $sNumProcesso;
    	  $oDadosContrato->exercicioProcessoLicitatorio = $sExercicioProcesso;
    	  $oDadosContrato->naturezaObjeto					      = $oContrato->getAttribute("naturezaObjeto");
    	  $oDadosContrato->objetoContrato					      = utf8_decode(substr($oContrato->getAttribute("objetoContrato"), 0, 500));
    	  $oDadosContrato->tipoInstrumento					    = substr($oContrato->getAttribute("tipoInstrumento"), 0, 1);
    	  $oDadosContrato->dataInicioVigencia				    = str_replace("/", "", $oContrato->getAttribute("dataInicioVigencia"));
    	  $oDadosContrato->dataFinalVigencia				    = str_replace("/", "", $oContrato->getAttribute("dataFinalVigencia"));
    	  $oDadosContrato->vlContrato						        = number_format($oContrato->getAttribute("vlContrato"), 2, "", "");
    	  $oDadosContrato->formaFornecimento				    = utf8_decode(substr($oContrato->getAttribute("formaFornecimento"), 0, 50));
    	  $oDadosContrato->formaPagamento					      = utf8_decode(substr($oContrato->getAttribute("formaPagamento"), 0, 100));
    	  $oDadosContrato->prazoExecucao					      = utf8_decode(str_replace("/", "", $oContrato->getAttribute("prazoExecucao")));
    	  $oDadosContrato->multaRescisoria					    = utf8_decode(substr($oContrato->getAttribute("multaRescisoria"), 0, 100));
    	  $oDadosContrato->multaInadimplemento				  = utf8_decode(substr($oContrato->getAttribute("multaInadimplemento"), 0, 100));
    	  $oDadosContrato->garantia							        = substr($oContrato->getAttribute("garantia"), 0, 1);
    	  $oDadosContrato->signatarioContratante			  = utf8_decode(substr($oContrato->getAttribute("signatarioContratante"), 0, 50));
    	  $oDadosContrato->cpfsignatarioContratante			= str_pad($oContrato->getAttribute("cpfsignatarioContratante"), 11, "0", STR_PAD_LEFT);
    	  $oDadosContrato->dataPublicacao					      = str_replace("/", "", $oContrato->getAttribute("dataPublicacao"));
    	  $oDadosContrato->veiculoDivulgacao				    = utf8_decode(substr($oContrato->getAttribute("veiculoDivulgacao"), 0, 50));
    	  
    	  $this->aDados[] = $oDadosContrato;
    	  
    	  if ($oContrato->getAttribute("naturezaObjeto") != "4" || $oContrato->getAttribute("naturezaObjeto") != "5" ) {
            
    	  	/**
     		* Percorre as informacoes do xml Empenho
     		*/
    	  	foreach ($oEmpenhos as $oEmpenho ) {
    	  	
    	  	  if ($oEmpenho->getAttribute('instituicao') == db_getsession("DB_instit") &&
    	  	      $oEmpenho->getAttribute('codContrato') == $oContrato->getAttribute("codigo")) {
    	  		
    	  	    $sSql   = "SELECT pc01_codmater,m60_codmater,m60_codmatunid,m61_descr,e60_numemp, e60_codemp, e60_anousu,e60_emiss, pc01_descrmater, "; 
    	  	    $sSql  .= "e62_quant, e62_vlrun from empempenho ";
			        $sSql  .= "left join empempitem on e62_numemp = e60_numemp ";
			        $sSql  .= "left join pcmater on e62_item = pc01_codmater left join transmater on pc01_codmater =  m63_codpcmater ";
			        $sSql  .=  "left join matmater on m60_codmater = m63_codmatmater";
              $sSql  .=" left join matunid on m60_codmatunid = m61_codmatunid "; 
			        $sSql  .= "where e60_codemp = '".$oEmpenho->getAttribute("codEmpenho")."'";
			        $sSql  .= " and e60_anousu = ".db_getsession("DB_anousu")." "; 
    	  	 
    	        $rsItens = db_query($sSql);
    	     
    	        /**
     			* Percorre as informacoes de itens do Empenho no banco
     			*/
    	        for ($iCont11 = 0;$iCont11 < pg_num_rows($rsItens); $iCont11++) {
    	        	
     	          $oItem = db_utils::fieldsMemory($rsItens, $iCont11++);

     	          if ($oItem->m61_descr != '') {
     	          	$sUnidade = substr($oItem->m61_descr, 0, 50);
     	          } else {
     	          	$sUnidade = "Serviço";
     	          }
    	  	      $oDadosItens = new stdClass();
    	  	      
    	  	      $oDadosItens->tipoRegistro			= 11;
    	  	      $sHash11                        = 11;
    	  	      $oDadosItens->detalhesessao 		= 11;
    	          $oDadosItens->codContrato				= substr($oContrato->getAttribute("codigo"), 0, 15);
    	          $sHash11                        = substr($oContrato->getAttribute("codigo"), 0, 15);
    	          $oDadosItens->descricaoItem			= substr($oItem->pc01_descrmater, 0, 150);
    	          $sHash11                        = substr($oItem->pc01_descrmater, 0, 150);
    	  	      $oDadosItens->quantidadeItem		= number_format($oItem->e62_quant, 4, "", "");
    	  	      $sHash11                        = number_format($oItem->e62_quant, 4, "", "");
    	  	      $oDadosItens->unidade					  = $sUnidade;
    	  	      $sHash11                        = $sUnidade;
    	  	      $oDadosItens->valorUnitarioItem = number_format($oItem->e62_vlrun, 4, "", "");
    	  	      $sHash11                        = number_format($oItem->e62_vlrun, 4, "", "");
    	  	      
    	  	      
    	          if (!in_array($sHash11, $aChaveDadosReg11)) {
    	          	
    	          	$aChaveDadosReg11[]  = $sHash11;
    	          	$this->aDados[] = $oDadosItens;
    	          	
    	          }
    	        
    	        }
    	        
    	        $sSql  = "SELECT o58_orgao, o58_unidade, o58_funcao, o58_subfuncao,o58_programa,o58_projativ,";
    	        $sSql .= "o56_elemento,o15_codtri from empempenho ";
    	        $sSql .= "join orcdotacao on e60_coddot = o58_coddot "; 
    	        $sSql .= "join orcelemento on o58_codele = o56_codele and o56_anousu =   ".db_getsession("DB_anousu"); 
    	        $sSql .= " join orctiporec on o58_codigo = o15_codigo"; 
    	        $sSql .= " where o58_anousu =  ".db_getsession("DB_anousu")." and e60_anousu = ".db_getsession("DB_anousu"); 
    	        $sSql .= " and e60_codemp = '".$oEmpenho->getAttribute("codEmpenho")."' and e60_instit = ".db_getsession("DB_instit");
    	  	  
    	        $rsCreditos = db_query($sSql);
    	        
    	        /**
     			     * Percorre as informacoes dos Creditos Orcamentarios 
     			     */
    	        for ($iCont12 = 0;$iCont12 < pg_num_rows($rsCreditos); $iCont12++) {

    	          $oCredito = db_utils::fieldsMemory($rsCreditos, $iCont12++);
    	          
    	          if ($sTrataCodUnidade == "01") {
      		
      		        $sCodUnidade					  = str_pad($oCredito->o58_orgao, 2, "0", STR_PAD_LEFT);
	   		          $sCodUnidade					 .= str_pad($oCredito->o58_unidade, 3, "0", STR_PAD_LEFT);
	   		  
      	        } else {
      		
      		        $sCodUnidade					  = str_pad($oCredito->o58_orgao, 3, "0", STR_PAD_LEFT);
	   		          $sCodUnidade					 .= str_pad($oCredito->o58_unidade, 2, "0", STR_PAD_LEFT);
      		
      	        }
    	       
      	        
    	          $oDadosCreditos = new stdClass();

    	          $oDadosCreditos->tipoRegistro        = 12;
    	          $sHash12                             = 12;
    	          $oDadosCreditos->detalhesessao 	     = 12;
    	          $oDadosCreditos->codContrato         = substr($oContrato->getAttribute("codigo"), 0, 15);
    	          $sHash12                            .= substr($oContrato->getAttribute("codigo"), 0, 15);
    	          $oDadosCreditos->codOrgao            = $sOrgao;
    	          $sHash12                            .= $sOrgao;
    	          $oDadosCreditos->codUnidadeSub       = $sCodUnidade;
    	          $sHash12                            .= $sCodUnidade;
    	          $oDadosCreditos->codFuncao           = str_pad($oCredito->o58_funcao, 2, "0", STR_PAD_LEFT);
    	          $sHash12                            .= str_pad($oCredito->o58_funcao, 2, "0", STR_PAD_LEFT);
    	          $oDadosCreditos->codSubFuncao        = str_pad($oCredito->o58_subfuncao, 3, "0", STR_PAD_LEFT);
    	          $sHash12                            .= str_pad($oCredito->o58_subfuncao, 3, "0", STR_PAD_LEFT);
    	          $oDadosCreditos->codPrograma         = str_pad($oCredito->o58_programa, 4, "0", STR_PAD_LEFT);
    	          $sHash12                            .= str_pad($oCredito->o58_programa, 4, "0", STR_PAD_LEFT);
    	          $oDadosCreditos->idAcao              = str_pad($oCredito->o58_projativ, 4, "0", STR_PAD_LEFT);
    	          $sHash12                            .= str_pad($oCredito->o58_projativ, 4, "0", STR_PAD_LEFT);
    	          $oDadosCreditos->idSubAcao           = " ";
    	          $oDadosCreditos->elementoDespesa     = substr($oCredito->o56_elemento, 1, 6);
    	          $sHash12                            .= substr($oCredito->o56_elemento, 1, 6);
    	          $oDadosCreditos->codFontRecursos     = str_pad($oCredito->o15_codtri, 3, "0", STR_PAD_LEFT);
    	          $sHash12                            .= str_pad($oCredito->o15_codtri, 3, "0", STR_PAD_LEFT);
    	          
    	          if (!in_array($sHash12, $aChaveDadosReg12)) {
    	          	
    	          	$aChaveDadosReg12[]  = $sHash12;
    	          	$this->aDados[] = $oDadosCreditos;
    	          	
    	          }
    	        	
    	        } 
    	        
    	  	  }
    	  	  
    	  	}
    	  	
    	      /**
     		  * Percorre as informacoes do xml Aditivos
     		  */
    		  foreach ($oAditivos as $oAditivo) {
    	      
    		  	if ($oAditivo->getAttribute('instituicao') == db_getsession("DB_instit") &&
    	  	      $oAditivo->getAttribute('nroContrato') == $oContrato->getAttribute("nroContrato")) {
    		  	//echo $oAditivo->getAttribute('nroContrato')."<br>";
    	  	    $sTipoTermoAditivo = str_pad($oAditivo->getAttribute("tipoTermoAditivo"), 2, "0", STR_PAD_LEFT);
    	  	    if ($sTipoTermoAditivo == "06") {
    	  	    	$sDescAlteracao = substr($oAditivo->getAttribute("dscAlteracao"), 0, 250);
    	  	    } else {
    	  	    	$sDescAlteracao = " ";
    	  	    }  	
    	  	      	
		      	  $oDadosAditivo = new stdClass();
		    	
		      	  $oDadosAditivo->tipoRegistro               = 20;
		      	  $oDadosAditivo->detalhesessao 				     = 20;
		      	  $oDadosAditivo->codAditivo							   = substr($oAditivo->getAttribute("codigo"), 0, 15);
			      	$oDadosAditivo->codOrgao							     = $sOrgao;
			      	$oDadosAditivo->codUnidadeSub						   = " ";
			      	$oDadosAditivo->nroContrato							   = substr($oAditivo->getAttribute("nroContrato"), 0, 14);
			      	$oDadosAditivo->dataAssinaturaContOriginal = str_replace("/", "", $oAditivo->getAttribute("dataAssinaturaContOriginal"));
			      	$oDadosAditivo->tipoTermoAditivo					 = $sTipoTermoAditivo;
			      	$oDadosAditivo->dscAlteracao						   = $sDescAlteracao;
			      	$oDadosAditivo->nroSeqTermoAditivo				 = str_pad($oAditivo->getAttribute("nroSeqTermoAditivo"), 2, "0", STR_PAD_LEFT);
			      	$oDadosAditivo->dataAssinaturaTermoAditivo = str_replace("/", "", $oAditivo->getAttribute("dataAssinaturaTermoAditivo"));
			      	$oDadosAditivo->novaDataTermino						 = str_replace("/", "", $oAditivo->getAttribute("novaDataTermino"));
		          $oDadosAditivo->valorAditivo						   = number_format($oAditivo->getAttribute("valorAditivo"), 2, "", "");
			      	$oDadosAditivo->valorAtualizadoContrato		 = number_format($oAditivo->getAttribute("valorAtualizadoContrato"), 2, "", "");
			      	$oDadosAditivo->dataPublicacao						 = str_replace("/", "", $oAditivo->getAttribute("dataPublicacao"));
			      	$oDadosAditivo->veiculoDivulgacao					 = substr($oAditivo->getAttribute("veiculoDivulgacao"), 0, 15);
			    	
		      	  $this->aDados[] = $oDadosAditivo;
      	  		
    		  	/**
		         * Percorre as informacoes do xml Aditivos
		         */
		        foreach ($oItensAditivos as $oItemAditivo) {
		          
		        	if ($oItemAditivo->getAttribute("instituicao") == db_getsession("DB_instit") && 
		        	    $oAditivo->getAttribute("codAditivo") == $oItemAditivo->getAttribute("codAditivo") &&
		        	    $oAditivo->getAttribute("nroContrato") == $oItemAditivo->getAttribute("nroContrato")) {

		        		$oDadosItemAditivo = new stdClass();
		      
		      	    $oDadosItemAditivo->tipoRegistro      = 21;
		      	    $oDadosItemAditivo->detalhesessao 		= 21;
		      	    $oDadosItemAditivo->codAditivo        = substr($oAditivo->getAttribute("codigo"), 0, 15);
		      	    $oDadosItemAditivo->descricaoItem			= substr($oItemAditivo->getAttribute("descricaoItem"), 0, 150);
		      	    $oDadosItemAditivo->quantidadeItem		= number_format($oItemAditivo->getAttribute("quantidadeItem"), 4, "", "");
		      	    $oDadosItemAditivo->unidade           = substr($oItemAditivo->getAttribute("unidade"), 0, 50);
		      	    $oDadosItemAditivo->valorUnitarioItem	= number_format($oItemAditivo->getAttribute("valorUnitarioItem"), 4, "", "");
		      
     	          $this->aDados[] = $oDadosItemAditivo;
		    
		        		
		        	}
		      	  
		        }
		        
    		   }
    		   
    		  }
    	  	
    	  } 
    	  
    	}
 
    }
    
    /**
     * Informacoes Registro 30 apostilamento
     */
    $sSqlApostilamento = "select * from apostilamento where si03_dataapostila between '{$this->sDataInicial}' and '{$this->sDataFinal}'";
    $rsApostilamento = db_query($sSqlApostilamento);
    for ($iContAp = 0; $iContAp < pg_num_rows($rsApostilamento); $iContAp++) {
    	
    	$oApostilamento = db_utils::fieldsMemory($rsApostilamento, $iContAp);
    	
    	$oDadosApostilamento = new stdClass();
    	$oDadosApostilamento->tipoRegistro               = 30;
    	$oDadosApostilamento->detalhesessao              = 30;
    	$oDadosApostilamento->codOrgao                   = $sOrgao;
    	$oDadosApostilamento->codUnidadeSub              = " ";
    	$oDadosApostilamento->nroContrato                = substr($oApostilamento->si03_numcontrato, 0, 14);
    	$oDadosApostilamento->dataAssinaturaContOriginal = implode(array_reverse(explode("-", $oApostilamento->si03_dataassinacontrato)));
    	$oDadosApostilamento->tipoApostila               = str_pad($oApostilamento->si03_tipoapostila, 2, "0", STR_PAD_LEFT);
    	$oDadosApostilamento->nroSeqApostila             = substr($oApostilamento->si03_numapostilamento, 0, 3);
    	$oDadosApostilamento->dataApostila               =  implode(array_reverse(explode("-", $oApostilamento->si03_dataapostila)));
    	$oDadosApostilamento->dscAlteracao               = substr($oApostilamento->si03_descrapostila, 0, 250);
    	$this->aDados[]                                  = $oDadosApostilamento; 	
    	
    }
    
    
     /**
     * Percorre as informacoes do xml Rescisoes
     */
    foreach ($oRescisoes as $oRescisao) {
    	
      if ( $oRescisao->getAttribute("instituicao") == db_getsession("DB_instit") &&
           implode("-", array_reverse(explode("/", $oRescisao->getAttribute("dataRescisao")))) >= $this->sDataInicial && 
           implode("-", array_reverse(explode("/", $oRescisao->getAttribute("dataRescisao")))) <= $this->sDataFinal ) {
           	
      	$oDadosRescisao = new stdClass();
      	
      	$oDadosRescisao->tipoRegistro      					   = 40;
      	$oDadosRescisao->detalhesessao 			           = 40;
      	$oDadosRescisao->codOrgao          					   = $sOrgao;
      	$oDadosRescisao->codUnidadeSub     					   = " ";
      	$oDadosRescisao->nroContrato   			  			   = substr($oRescisao->getAttribute("nroContrato"), 0, 14);
      	$oDadosRescisao->dataAssinaturaContOriginal    = str_replace("/", "", $oRescisao->getAttribute("dataAssinaturaContOriginal"));
      	$oDadosRescisao->dataRescisao					    	   = str_replace("/", "", $oRescisao->getAttribute("dataRescisao"));
      	$oDadosRescisao->valorCancelamentoContrato	   = number_format($oRescisao->getAttribute("valorCancelamentoContrato"), 2, "", "");
    		
      	$this->aDados[] = $oDadosRescisao;
      	
      }
    	
    }
    
  }
  
}			