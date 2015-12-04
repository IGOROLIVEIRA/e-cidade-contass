<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Responsáveis pela Licitação Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoResponsaveisLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
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
  protected $sNomeArquivo = 'RESPLIC';
  
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
                          "tipoResp",
					    					  "nroCPFResp",
					    					  "nomeResp",
					    					  "logradouro",
					    					  "bairroLogra",
					    					  "codCidadeLogra",
					    					  "ufCidadeLogra",
					    					  "cepLogra",
					    					  "telefone",
					    					  "email"
                        );
    $aElementos[20] = array(
    					            "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
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
   * selecionar os dados de Responsáveis pela Licitação do mes para gerar o arquivo
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
  	* Selecionar xml do decreto/licitação 
  	*/
	  $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomlicitacao.xml";
	
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração do licitacao do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oComissoes      = $oDOMDocument->getElementsByTagName('licitacao');
    
    /**
     * 
     * Selecionar xml responsável pela licitação
     */
    
    $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomresponsavel.xml";
	
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração do responsável do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oResponsaveis      = $oDOMDocument->getElementsByTagName('resp');
    
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
     * remover o parentese do telefone
     */
    $aTelefone = array("(",")");
    
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
		$sLicitacao = implode(",", $aLicitacao);
    
    $sSql  = "SELECT l31_tipo,l20_codigo, l20_numero, l20_dataaber,l20_anousu, l03_descr,z01_numcgm,l20_liccomissao, "; 
    $sSql .= "l03_pctipocompratribunal, z01_cgccpf, z01_nome, z01_ender, z01_bairro, ";
    $sSql .= "z01_munic, z01_uf, z01_cep, z01_telef, z01_email, z01_cxpostal from liclicita ";
    $sSql .= "join cflicita on l20_codtipocom = l03_codigo left join liccomissao on l20_liccomissao = l30_codigo ";
    $sSql .= "left join liccomissaocgm on l30_codigo = l31_liccomissao left join cgm on l31_numcgm = z01_numcgm  ";
    $sSql .= "left join pctipocompratribunal on cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial ";
    $sSql .= "where  l20_codigo in (".$sLicitacao.") and l44_codigotribunal in ('1','2','3','4','5','6') and l44_sequencial < 100 ";
    $sSql .= "and l20_instit = ".db_getsession("DB_instit");
   	
    $rsRespLici = db_query($sSql);
    
    /**
     * percorrer registros de contas retornados do sql acima
     */$i = 0;
    for ($iCont = 0;$iCont < pg_num_rows($rsRespLici); $iCont++) {
    	
      $oRespLici = db_utils::fieldsMemory($rsRespLici, $iCont);
      
      foreach ($oDadosComplLicitacoes as $oDadosComplLicitacao) {
			    
	      if ($oDadosComplLicitacao->getAttribute('instituicao') == db_getsession("DB_instit")
			  && $oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio') == $oRespLici->l20_codigo) {
          
	        $oDadosRespLici = new stdClass();
	
	        //$sSqlParticipante = "select l31_tipo from liccomissaocgm where l31_numcgm = $oRespLici->z01_numcgm and l31_liccomissao = $oRespLici->l20_liccomissao";
	        //$rsParticipante = db_query($sSqlParticipante);
	        
	        
	        $oDadosRespLici->tipoRegistro  				   = 10;
		      $oDadosRespLici->detalhesessao 				   = 10;
		      $oDadosRespLici->codOrgao                = $sOrgao;
		      $oDadosRespLici->codUnidadeSub           = " ";
		      $oDadosRespLici->exercicioLicitacao      = str_pad($oDadosComplLicitacao->getAttribute('ano'), 4, "0", STR_PAD_LEFT);
		      $oDadosRespLici->nroProcessoLicitatorio  = substr($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);
		      $oDadosRespLici->tipoResp						     = $oRespLici->l31_tipo;
		      $oDadosRespLici->nroCPFResp					     = str_pad($oRespLici->z01_cgccpf, 11, "0", STR_PAD_LEFT);
				  $oDadosRespLici->nomeResp                = substr($oRespLici->z01_nome, 0, 50);
				  $oDadosRespLici->logradouro              = substr($oRespLici->z01_ender, 0, 75);
				  $oDadosRespLici->bairroLogra             = substr($oRespLici->z01_bairro, 0, 50);
				  $oDadosRespLici->codCidadeLogra          = str_pad($oRespLici->z01_cxpostal, 5, "0", STR_PAD_LEFT);
				  $oDadosRespLici->ufCidadeLogra           = str_pad($oRespLici->z01_uf, 2, "0", STR_PAD_LEFT);
				  $oDadosRespLici->cepLogra                = str_pad($oRespLici->z01_cep, 8, "0", STR_PAD_LEFT);
				  $oDadosRespLici->telefone                = str_replace($aTelefone, "", $oRespLici->z01_telef);
				  $oDadosRespLici->email                   = substr($oRespLici->z01_email, 0, 50);
			  
			    $this->aDados[] = $oDadosRespLici;
          		  
		    }
		
      }
	      
    }
    
    $sSql  = "select * from (SELECT max(l11_sequencial), l20_codigo, l20_numero, l20_dataaber, l20_anousu from liclicita join cflicita" ;
    $sSql .= " on l20_codtipocom = l03_codigo join pctipocompratribunal on l44_sequencial = l03_pctipocompratribunal join liclicitasituacao ";
    $sSql .= " on l11_liclicita = l20_codigo and l20_licsituacao = l11_licsituacao where l20_codigo in (".$sLicitacao.") ";
    $sSql .= " and l44_codigotribunal in ('1','2','3','4','5','6') and l44_sequencial < 100 and l20_instit = ".db_getsession("DB_instit") ;
    $sSql .= " group by l20_codigo, l20_numero, l20_dataaber, l20_anousu ) as julgamento join liclicitasituacao on max = l11_sequencial;";
           
   /* $sSql  = "SELECT max(l11_sequencial), l20_codigo, l20_numero, l20_dataaber, l20_anousu, l11_data from liclicita "; 
    $sSql .= "join cflicita on l20_codtipocom = l03_codigo ";
    $sSql .= "join pctipocompratribunal on l44_sequencial = l03_pctipocompratribunal ";
    $sSql .= "join liclicitasituacao on  l11_liclicita = l20_codigo and l20_licsituacao = l11_licsituacao ";
    $sSql .= "where  l20_codigo in (".$sLicitacao.") and l44_codigotribunal in ('1','2','3','4','5','6') and l44_sequencial < 100 ";
    $sSql .= "and l20_instit = ".db_getsession("DB_instit");
    $sSql .= "group by l20_codigo, l20_numero, l20_dataaber, l20_anousu, l11_data";*/
    
    $rsLicit = db_query($sSql);
   
    /**
     * percorrer registros de contas retornados do sql acima
     */
    for ($iCont2 = 0;$iCont2 < pg_num_rows($rsLicit); $iCont2++) {
    	
      $oLicit = db_utils::fieldsMemory($rsLicit,$iCont2);
      
      /**
       * percorrer os dados retornados do xml de homologacao
       */    
    	foreach ($oHomologacoes as $oHomologacao) {

			  if ($oHomologacao->getAttribute('instituicao') == db_getsession("DB_instit")
			      && $oHomologacao->getAttribute('nroProcessoLicitatorio') == $oLicit->l20_codigo){
				  $dDtHomologacao = implode("-", array_reverse(explode("/", $oHomologacao->getAttribute("dtHomologacao"))));
			  }
				
		  }
      /**
       * percorrer os dados retornados do xml para selecionar as licitacões da inst logada
       */    
        foreach ($oComissoes as $oComissao) {
      	  	
    	    if ($oComissao->getAttribute('instituicao') == db_getsession("DB_instit") 
    	    && implode("-", array_reverse(explode("/", $oComissao->getAttribute("inicioVigencia")))) <= $dDtHomologacao   
    	    && implode("-", array_reverse(explode("/", $oComissao->getAttribute("finalVigencia")))) >= $dDtHomologacao) {

    	    	if (!isset($oComissaoSelecionada)){
    	    		$oComissaoSelecionada = $oComissao;
    	    	} else {
    	    		
    	    		if (implode("-", array_reverse(explode("/", $oComissao->getAttribute("inicioVigencia")))) > 
    	    		    implode("-", array_reverse(explode("/", $oComissaoSelecionada->getAttribute("inicioVigencia")))) ) {
    	    			$oComissaoSelecionada = $oComissao;
    	    		}
    	    		
    	    	}
    	    	
    	    }
    	    
        }
    	  
    	      foreach ($oResponsaveis as $oResponsavel) {
    
    	  	    if ($oResponsavel->getAttribute('instituicao') == db_getsession("DB_instit") 
    	  	    && $oResponsavel->getAttribute('codigoLic') == $oComissaoSelecionada->getAttribute('codigo')) {

						    $sSql  =  "SELECT * from cgm where z01_numcgm = ".$oResponsavel->getAttribute('numCgm') ; 
						    $rsCgm = db_query($sSql);
			          
			    			$oCgm  = db_utils::fieldsMemory($rsCgm, 0);
			    						    
			          foreach ($oDadosComplLicitacoes as $oDadosComplLicitacao) {
			
	    		        if ($oDadosComplLicitacao->getAttribute('instituicao') == db_getsession("DB_instit")
		    		      && $oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio') == $oLicit->l20_codigo) {

							      $oDadosResponsavel = new stdClass();
							    
							      $oDadosResponsavel->tipoRegistro  			   = 20;
				    	  		$oDadosResponsavel->detalhesessao 			   = 20;
				    	  		$oDadosResponsavel->codOrgao               = $sOrgao;
				    	  		$oDadosResponsavel->codUnidadeSub  		     = " ";
					  	  		$oDadosResponsavel->exercicioLicitacao		 = str_pad($oDadosComplLicitacao->getAttribute('ano'), 4, "0", STR_PAD_LEFT);
					  	  		$oDadosResponsavel->nroProcessoLicitatorio = str_pad($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);
					  	  		$oDadosResponsavel->codTipoComissao			   = str_replace("0", "", $oComissaoSelecionada->getAttribute("codTipoComissao"));
				    	  		$oDadosResponsavel->descricaoAtoNomeacao   = str_replace("0", "", $oComissaoSelecionada->getAttribute("descricaoAtoNomeacao"));
					  	  		$oDadosResponsavel->nroAtoNomeacao         = substr($oComissaoSelecionada->getAttribute("nroAtoNomeacao"), 0, 7);
					  	  		$oDadosResponsavel->dataAtoNomeacao        = str_replace("/", "", $oComissaoSelecionada->getAttribute("dataAtoNomeacao"));
					  	  		$oDadosResponsavel->inicioVigencia         = str_replace("/", "", $oComissaoSelecionada->getAttribute("inicioVigencia"));
					  	  		$oDadosResponsavel->finalVigencia          = str_replace("/", "", $oComissaoSelecionada->getAttribute("finalVigencia"));
					  	 		  $oDadosResponsavel->cpfMembroComissao      = str_pad($oCgm->z01_cgccpf, 11, "0", STR_PAD_LEFT);
					  	  		$oDadosResponsavel->nomMembroComLic        = substr($oCgm->z01_nome, 0, 50);
					  	  		$oDadosResponsavel->codAtribuicao          = str_replace("0", "", $oResponsavel->getAttribute("codAtribuicao"));
					  	  		$oDadosResponsavel->cargo                  = substr($oResponsavel->getAttribute("cargo"), 0, 50);
					  	  		$oDadosResponsavel->naturezaCargo          = str_replace("0", "", $oResponsavel->getAttribute("naturezaCargo"));
					  	  		$oDadosResponsavel->logradouro             = substr($oCgm->z01_ender, 0, 75);
					  	  		$oDadosResponsavel->bairroLogra            = substr($oCgm->z01_bairro, 0, 50);
					  	  		$oDadosResponsavel->codCidadeLogra         = str_pad($oCgm->z01_cxpostal, 5, "0", STR_PAD_LEFT);
					  	  		$oDadosResponsavel->ufCidadeLogra          = str_pad($oCgm->z01_uf, 2, "0", STR_PAD_LEFT);
					  	  		$oDadosResponsavel->cepLogra               = str_pad($oCgm->z01_cep, 8, "0", STR_PAD_LEFT);
					  	  		$oDadosResponsavel->telefone               = str_replace($aTelefone, "", $oCgm->z01_telef);
					  	  		$oDadosResponsavel->email                  = substr($oCgm->z01_email, 0, 50);
    	  	    	
	  	  		        $this->aDados[] = $oDadosResponsavel;
	  	  		
    	  	        }
	  	  		
    	  	      }
    	  	    
    	  	    }
    	  	
    	      } 	
    		
    	    //} // data
          
        //} // comissao
    
      }
    
    }
		
  }