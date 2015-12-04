<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Habilitação Licitação Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoHabilitacaoLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 156;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'HABLIC';
  
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
                          "codUnidadeSub",
                          "exercicioLicitacao",
                          "nroProcessoLicitatorio",
                          "tipoDocumento",
                          "nroDocumento",
                          "nomRazaoSocial",
    											"objetoSocial",
    											"orgaoRespRegistro",
    											"dataRegistro",
    											"nroRegistro",
    											"dataRegistroCVM",
    											"nroRegistroCVM",
                          "nroInscricaoEstadual",
                          "ufInscricaoEstadual",
                          "nroCertidaoRegularidadeINSS",
                          "dtEmissaoCertidaoRegularidadeINSS",
                          "dtValidadeCertidaoRegularidadeINSS",
                          "nroCertidaoRegularidadeFGTS",
                          "dtEmissaoCertidaoRegularidadeFGTS",
                          "dtValidadeCertidaoRegularidadeFGTS",
    											"nroCNDT",
    											"dtEmissaoCNDT",
    											"dtValidadeCNDT",
                          "dtHabilitacao",
    											"PresencaLicitantes",
                          "renunciaRecurso"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "exercicioLicitacao",
    										  "nroProcessoLicitatorio",
    											"tipoDocumentoCNPJEmpresaHablic",
                          "CNPJEmpresaHablic",
                          "tipoDocumentoSocio",
                          "nroDocumentoSocio",
                          "nomeSocio",
                          "tipoParticipacao"
                        );
    $aElementos[20] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "exercicioLicitacao",
    										  "nroProcessoLicitatorio",
    											"tipoDocumento",
                          "nroDocumento",
                          "dataCredenciamento",
                          "nroLote",
                          "nroItem",
                          "nomeRazaoSocial",
                          "nroInscricaoEstadual",
                          "ufInscricaoEstadual",
                          "nroCertidaoRegularidadeINSS",
                          "dataEmissaoCertidaoRegularidadeINSS",
                          "dataValidadeCertidaoRegularidadeINSS",
                          "nroCertidaoRegularidadeFGTS",
                          "dataEmissaoCertidaoRegularidadeFGTS",
                          "dataValidadeCertidaoRegularidadeFGTS",
    											"nroCNDT",
    											"dtEmissaoCNDT",
    											"dtValidadeCNDT"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados dE Habilitação da licitação
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
      
    	if($oOrgao->getAttribute('instituicao') == db_getsession("DB_instit")){
        $sOrgao     = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
    	}
    	
    }
  
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgãos.");
    }
    
    /**
		 * selecionar aquivo xml com dados da habilitação da licitação
		 */
		$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomhabilitacao.xml";
		
		if (!file_exists($sArquivo)) {
			throw new Exception("Arquivo de habilitação da licitação inexistente!");
		}
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oHabilitacoes = $oDOMDocument->getElementsByTagName('habilitacao');
		
    /**
		 * selecionar aquivo xml com dados da habilitação da licitação
		 */
		$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomhabilitacaosocios.xml";
		
		/*if (!file_exists($sArquivo)) {
			throw new Exception("Arquivo de Societários dos participantes da habilitação inexistente!");
		}*/
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oHabilitacoesSocios = $oDOMDocument->getElementsByTagName('habilitacaosocio');
		
    	/**
		 * selecionar aquivo xml com dados de identificação do responsável
		 */
		$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomcredenciamento.xml";
		
		if (!file_exists($sArquivo)) {
			throw new Exception("Arquivo de credenciamentos inexistente!");
		}
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oCredenciamentos = $oDOMDocument->getElementsByTagName('credenciamento');
		
		
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
		 * selecionar arquivo xml de Homologacao
		 */
		$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomhomologalict.xml";
		if (!file_exists($sArquivo)) {
			throw new Exception("Arquivo de Homologação inexistente!");
		}
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oHomologacoes = $oDOMDocument->getElementsByTagName('homologalict');
		$aLicitacao = array();
		foreach ($oHomologacoes as $oHomologacao) {

			$dDtHomologacao = implode("-", array_reverse(explode("/",$oHomologacao->getAttribute('dtHomologacao'))));
			if ($oHomologacao->getAttribute('instituicao') == db_getsession("DB_instit")
			&& $dDtHomologacao >= $this->sDataInicial
			&& $dDtHomologacao <= $this->sDataFinal){
				$aLicitacao[] = $oHomologacao->getAttribute('nroProcessoLicitatorio');
			}
				
		}
  /*if (count($aLicitacao) == 0) {
			throw new Exception("Não existe Homologação cadastrada para o mês selecionado!");
		}*/
		$sLicitacao = implode(",", $aLicitacao);
		
    $sSql  = "select l20_codigo,l20_anousu
              from liclicita  
	            inner join db_config on db_config.codigo = liclicita.l20_instit  
	            inner join db_usuarios on db_usuarios.id_usuario = liclicita.l20_id_usucria  
	            inner join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom
	            left  join pctipocompratribunal on cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial  
	            inner join liclocal on liclocal.l26_codigo = liclicita.l20_liclocal  
	            inner join liccomissao on liccomissao.l30_codigo = liclicita.l20_liccomissao  
	            inner join licsituacao on licsituacao.l08_sequencial = liclicita.l20_licsituacao  
	            inner join cgm on cgm.z01_numcgm = db_config.numcgm  
	            inner join db_config as dbconfig on dbconfig.codigo = cflicita.l03_instit  
	            inner join pctipocompra on pctipocompra.pc50_codcom = cflicita.l03_codcom  
	            inner join bairro on bairro.j13_codi = liclocal.l26_bairro  
	            inner join ruas on ruas.j14_codigo = liclocal.l26_lograd  
	            left join liclicitaproc on liclicitaproc.l34_liclicita = liclicita.l20_codigo  
	            left join protprocesso on protprocesso.p58_codproc = liclicitaproc.l34_protprocesso  
              where  l20_codigo in (".$sLicitacao.") and l44_codigotribunal in ('1','2','3','4','5','6') and l44_sequencial < 100 
	            and l20_licsituacao in (1)  
	            and l20_instit = ".db_getsession("DB_instit")."   
              order by l20_codtipocom,l20_numero";
    
    $rsLicitacao = db_query($sSql);
    
    /**
     * percorrer registros de contas retornados do sql acima
     */
    for ($iCont = 0;$iCont < pg_num_rows($rsLicitacao); $iCont++) {
      	    	
    	$oLicitacao = db_utils::fieldsMemory($rsLicitacao, $iCont);
    
    	foreach ($oHabilitacoes as $oHabilitacao) {
    		
    		if ($oHabilitacao->getAttribute('instituicao') == db_getsession("DB_instit")
    		    && $oHabilitacao->getAttribute('nroProcessoLicitatorio') == $oLicitacao->l20_codigo) {
    			
    		  $sTipoDocumento = 2;
    		  if (strlen($oHabilitacao->getAttribute('nroDocumento')) == 11) {
    		  	$sTipoDocumento = 1;
    		  }  	
    		  
    		  foreach ($oDadosComplLicitacoes as $oDadosComplLicitacao) {
			
	    	    if ($oDadosComplLicitacao->getAttribute('instituicao') == db_getsession("DB_instit")
			      && $oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio') == $oLicitacao->l20_codigo) {
    		    	
    			$oDadosHabilitacao = new stdClass();
    			
    			$oDadosHabilitacao->tipoRegistro                       = 10;
			    $oDadosHabilitacao->detalhesessao                      = 10;
			    $oDadosHabilitacao->codOrgao                           = $sOrgao;
			    $oDadosHabilitacao->codUnidadeSub                      = " ";
			    $oDadosHabilitacao->exercicioLicitacao                 = str_pad($oDadosComplLicitacao->getAttribute('ano'), 4, "0", STR_PAD_LEFT);
			    $oDadosHabilitacao->nroProcessoLicitatorio             = substr($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);
			    $oDadosHabilitacao->tipoDocumento                      = $sTipoDocumento;
			    $oDadosHabilitacao->nroDocumento                       = $oHabilitacao->getAttribute('nroDocumento');
			    $oDadosHabilitacao->nomRazaoSocial                     = utf8_decode($oHabilitacao->getAttribute('nomRazaoSocial'));
			    $oDadosHabilitacao->objetoSocial                       = utf8_decode(substr($oHabilitacao->getAttribute('objetoSocial'), 0, 250));
			    $oDadosHabilitacao->orgaoRespRegistro                  = $oHabilitacao->getAttribute('orgaoRespRegistro');
			    $oDadosHabilitacao->dataRegistro                       = implode(explode("/", $oHabilitacao->getAttribute('dataRegistro')));
			    $oDadosHabilitacao->nroRegistro                        = $oHabilitacao->getAttribute('nroRegistro');
			    $oDadosHabilitacao->dataRegistroCVM                    = implode(explode("/", $oHabilitacao->getAttribute('dataRegistroCVM')));
			    $oDadosHabilitacao->nroRegistroCVM                     = $oHabilitacao->getAttribute('nroRegistroCVM');
			    $oDadosHabilitacao->nroInscricaoEstadual               = $oHabilitacao->getAttribute('nroInscricaoEstadual');
			    $oDadosHabilitacao->ufInscricaoEstadual                = $oHabilitacao->getAttribute('ufInscricaoEstadual');
			    $oDadosHabilitacao->nroCertidaoRegularidadeINSS        = $oHabilitacao->getAttribute('nroCertidaoRegularidadeINSS');
			    $oDadosHabilitacao->dtEmissaoCertidaoRegularidadeINSS  = implode(explode("/", $oHabilitacao->getAttribute('dtEmissaoCertidaoRegularidadeINSS')));
			    $oDadosHabilitacao->dtValidadeCertidaoRegularidadeINSS = implode(explode("/", $oHabilitacao->getAttribute('dtValidadeCertidaoRegularidadeINSS')));
			    $oDadosHabilitacao->nroCertidaoRegularidadeFGTS        = $oHabilitacao->getAttribute('nroCertidaoRegularidadeFGTS');
			    $oDadosHabilitacao->dtEmissaoCertidaoRegularidadeFGTS  = implode(explode("/", $oHabilitacao->getAttribute('dtEmissaoCertidaoRegularidadeFGTS')));
			    $oDadosHabilitacao->dtValidadeCertidaoRegularidadeFGTS = implode(explode("/", $oHabilitacao->getAttribute('dtValidadeCertidaoRegularidadeFGTS')));
			    $oDadosHabilitacao->nroCNDT                            = $oHabilitacao->getAttribute('nroCNDT');
			    $oDadosHabilitacao->dtEmissaoCNDT                      = implode(explode("/", $oHabilitacao->getAttribute('dtEmissaoCNDT')));
			    $oDadosHabilitacao->dtValidadeCNDT                     = implode(explode("/", $oHabilitacao->getAttribute('dtValidadeCNDT')));
			    $oDadosHabilitacao->dtHabilitacao                      = implode(explode("/", $oHabilitacao->getAttribute('dtHabilitacao')));
			    $oDadosHabilitacao->PresencaLicitantes                 = $oHabilitacao->getAttribute('PresencaLicitantes');
			    $oDadosHabilitacao->renunciaRecurso                    = $oHabilitacao->getAttribute('renunciaRecurso');
    			
			    $this->aDados[] = $oDadosHabilitacao;
			    
			    
			      if ($sTipoDocumento == 2){
    			
			      	foreach ($oHabilitacoesSocios as $oHabilitacaoSocio) {
			      		
			      		if ($oHabilitacaoSocio->getAttribute('codHabilitacao') == $oHabilitacao->getAttribute('codigo')) {
			      			
			      			if (strlen($oHabilitacaoSocio->getAttribute('nroDocumentoSocio')) == 11) {
			      				$iTipoDocumentoSocio = 1;
			      			} else {
			      				$iTipoDocumentoSocio = 2;
			      			}
			      			
				    		  $oDadosParticipantes = new stdClass();
				    			
				    			$oDadosParticipantes->tipoRegistro                       = 11;
							    $oDadosParticipantes->detalhesessao                      = 11;
							    $oDadosParticipantes->codOrgao                           = $sOrgao;
							    $oDadosParticipantes->codUnidadeSub                      = " ";
							    $oDadosParticipantes->exercicioLicitacao                 = str_pad($oDadosComplLicitacao->getAttribute('ano'), 4, "0", STR_PAD_LEFT);
							    $oDadosParticipantes->nroProcessoLicitatorio             = substr($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);
							    $oDadosParticipantes->tipoDocumentoCNPJEmpresaHablic     = "2";
							    $oDadosParticipantes->CNPJEmpresaHablic     						 = $oHabilitacao->getAttribute('nroDocumento');
							    $oDadosParticipantes->tipoDocumentoSocio     						 = $iTipoDocumentoSocio;
							    $oDadosParticipantes->nroDocumentoSocio     						 = $oHabilitacaoSocio->getAttribute('nroDocumentoSocio');
							    $oDadosParticipantes->nomeSocio     						 				 = $oHabilitacaoSocio->getAttribute('nomeSocio');
							    $oDadosParticipantes->tipoParticipacao     						 	 = $oHabilitacaoSocio->getAttribute('tipoParticipacao');
							    
							    $this->aDados[] = $oDadosParticipantes;
			    
			      		}
						    
			      	}
    			
    		}
			    
			    break;
			    
			      }
			      
    		  }
    		
    	  }
    		
    	}
    	
      foreach ($oCredenciamentos as $oCredenciamento) {
    	  	
    		if ($oCredenciamento->getAttribute('instituicao') == db_getsession("DB_instit")
    		    && $oCredenciamento->getAttribute('nroProcessoLicitatorio') == $oLicitacao->l20_codigo) {
    			
    		  $sTipoDocumento = 2;
    		  if (strlen($oCredenciamento->getAttribute('nroDocumento')) == 11) {
    		  	$sTipoDocumento = 1;
    		  }  	
    		    	
    			$oDadosCredenciamento = new stdClass();
    			
    			$oDadosCredenciamento->tipoRegistro                         = 20;
			    $oDadosCredenciamento->detalhesessao                        = 20;
			    $oDadosCredenciamento->codOrgao                             = $sOrgao;
			    $oDadosCredenciamento->codUnidadeSub                        = " ";
			    $oDadosCredenciamento->exercicioLicitacao                   = $oDadosHabilitacao->exercicioLicitacao;
			    $oDadosCredenciamento->nroProcessoLicitatorio               = $oDadosHabilitacao->nroProcessoLicitatorio;
			    $oDadosCredenciamento->tipoDocumento                        = $sTipoDocumento;
			    $oDadosCredenciamento->nroDocumento                         = $oCredenciamento->getAttribute('nroDocumento');
			    $oDadosCredenciamento->dataCredenciamento                   = str_replace("/", "", $oCredenciamento->getAttribute('dataCredenciamento'));
			    $oDadosCredenciamento->nroLote                              = " ";
			    $oDadosCredenciamento->nroItem                              = substr($oCredenciamento->getAttribute('nroItem'), 0, 4);
			    $oDadosCredenciamento->nomeRazaoSocial                      = $oCredenciamento->getAttribute('nomRazaoSocial');
			    $oDadosCredenciamento->nroInscricaoEstadual                 = $oCredenciamento->getAttribute('nroInscricaoEstadual');
			    $oDadosCredenciamento->ufInscricaoEstadual                  = $oCredenciamento->getAttribute('ufInscricaoEstadual');
			    $oDadosCredenciamento->nroCertidaoRegularidadeINSS          = $oCredenciamento->getAttribute('nroCertidaoRegularidadeINSS');
			    $oDadosCredenciamento->dataEmissaoCertidaoRegularidadeINSS  = str_replace("/", "", $oCredenciamento->getAttribute('dtEmissaoCertidaoRegularidadeINSS'));
			    $oDadosCredenciamento->dataValidadeCertidaoRegularidadeINSS = str_replace("/", "", $oCredenciamento->getAttribute('dtValidadeCertidaoRegularidadeINSS'));
			    $oDadosCredenciamento->nroCertidaoRegularidadeFGTS          = $oCredenciamento->getAttribute('nroCertidaoRegularidadeFGTS');
			    $oDadosCredenciamento->dataEmissaoCertidaoRegularidadeFGTS  = str_replace("/", "", $oCredenciamento->getAttribute('dtEmissaoCertidaoRegularidadeFGTS'));
			    $oDadosCredenciamento->dataValidadeCertidaoRegularidadeFGTS = str_replace("/", "", $oCredenciamento->getAttribute('dtValidadeCertidaoRegularidadeFGTS'));
			    $oDadosCredenciamento->nroCNDT                              = $oCredenciamento->getAttribute('nroCNDT');
    			$oDadosCredenciamento->dtEmissaoCNDT                        = implode(explode("/", $oCredenciamento->getAttribute('dtEmissaoCNDT')));
    			$oDadosCredenciamento->dtValidadeCNDT                       = implode(explode("/", $oCredenciamento->getAttribute('dtValidadeCNDT')));
    			
			    $this->aDados[] = $oDadosCredenciamento;
			    break;
			    
    		}
    		
    	}
    	
    } 
    	    
  }
		
 }
