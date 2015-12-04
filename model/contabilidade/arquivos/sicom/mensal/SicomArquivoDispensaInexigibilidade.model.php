<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Dispensa ou Inexigibilidade Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoDispensaInexigibilidade extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 161;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'DISPENSA';
  
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
                          "codOrgaoResp",
                          "codUnidadeSubResp",
                          "exercicioProcesso",
                          "nroProcesso",
                          "tipoProcesso",
					    					  "dtAbertura",
					    					  "naturezaObjeto",
					    					  "objeto",
					    					  "justificativa",
					    					  "razao",
					    					  "dtPublicacaoTermoRatificacao",
					    					  "veiculoPublicacao"		  
                        );
    $aElementos[11] = array(
    					            "tipoRegistro",
                          "codOrgaoResp",
                          "codUnidadeSubResp",
                          "exercicioProcesso",
    					            "nroProcesso",
                          "tipoProcesso",
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
    $aElementos[12] = array(
    					            "tipoRegistro",
                          "codOrgaoResp",
                          "codUnidadeSubResp",
                          "exercicioProcesso",
			                    "nroProcesso",
											    "tipoProcesso",
					    					  "nroLote",
					     					  "nroItem",
					    					  "dscItem",
					    					  "vlCotPrecosUnitario"
    					);
    $aElementos[13] = array(
    					            "tipoRegistro",
                          "codOrgaoResp",
                          "codUnidadeSubResp",
                          "exercicioProcesso",
                          "nroProcesso",
											    "tipoProcesso",
    											"codOrgao",
                          "codUnidadeSub",
					    					  "codFuncao",
					     					  "codSubFuncao",
					    					  "codPrograma",
					    					  "idAcao",
    											"idSubAcao",
					    					  "elementoDespesa",
					    					  "codFontRecursos",
					    					  "vlRecurso"
    					);
    $aElementos[14] = array(
    					            "tipoRegistro",
                          "codOrgaoResp",
                          "codUnidadeSubResp",
                          "exercicioProcesso",
                          "nroProcesso",
											    "tipoProcesso",
					    					  "tipoDocumento",
					     					  "nroDocumento",
					    					  "nomRazaoSocial",
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
					    					  "nroLote",
					    					  "nroItem",
					    					  "quantidade",
    					            "vlItem"
    					);
    $aElementos[15] = array(
    					            "tipoRegistro",
                          "codOrgao",
                          "codUnidade",
                          "exercicioProcesso",
                          "nroProcesso",
											    "tipoProcesso",
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
					    					  "dataValidadeCertidaoRegularidadeFGTS"
    					);
    return $aElementos;
  }
  
  /**
   * Dispensa ou Inexigibilidade mes para gerar o arquivo
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
    		
        $sOrgao           = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
        $sTrataCodUnidade = $oOrgao->getAttribute('trataCodUnidade');
        
    	}
    	
    }
    
    /**
	    * selecionar arquivo xml de Dados Compl Licitacao
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
	   * selecionar arquivo xml de paracer da licitacao
	   */
    
		$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomparecerlicitacao.xml";
		$oDadosParecer = array();
		if (file_exists($sArquivo)) {
			
		  $sTextoXml    = file_get_contents($sArquivo);
		  $oDOMDocument = new DOMDocument();
		  $oDOMDocument->loadXML($sTextoXml);
		  $oDadosParecer = $oDOMDocument->getElementsByTagName('parecerlicitacao');
		
		}
		
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
			    	
			    	foreach ($oDadosComplLicitacoes as $oDadoComp) {
			    		
			    		if ($oDadoComp->getAttribute('justificativa') != '' 
			    		    && $oHomologacao->getAttribute('nroProcessoLicitatorio') == $oDadoComp->getAttribute('nroProcessoLicitatorio')) {
				        $aLicitacao[] = $oHomologacao->getAttribute('nroProcessoLicitatorio');
				        break;
			    		}
			    	}
			    	
			}
					
		}
		$sLicitacao = implode(",", $aLicitacao);  
	    
	  /**
		 * selecionar arquivo xml de Preço Médio
		 */
		$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomprecomedio.xml";
		if (!file_exists($sArquivo)) {
			throw new Exception("Arquivo de Preco medio inexistente!");
		}
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oPrecosMedios = $oDOMDocument->getElementsByTagName('precomedio');
	
		/**
		 * selecionar arquivo xml de habilitacao
		 */
		$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomhabilitacao.xml";
		if (!file_exists($sArquivo)) {
			throw new Exception("Arquivo de habilitação inexistente!");
		}
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oHabilitacoes = $oDOMDocument->getElementsByTagName('habilitacao');
	    
	  $sSql = "select distinct l20_codigo,l20_anousu,l20_numero,l20_dataaber,l20_datacria,l20_dtpublic,l20_objeto, l44_codigotribunal  
		from liclicita 
			inner join db_config on db_config.codigo = liclicita.l20_instit 
			inner join db_usuarios on db_usuarios.id_usuario = liclicita.l20_id_usucria 
			inner join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom 
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
			join pctipocompratribunal on l03_pctipocompratribunal = l44_sequencial
			inner join liclicitasituacao on l11_liclicita = l20_codigo 
		where l20_instit = ".db_getsession("DB_instit")." and l11_licsituacao = 1 
		and l44_sequencial in (100,101,102) and l11_data between '".$this->sDataInicial."' and '".$this->sDataFinal."'";
	  //where l20_codigo in (".$sLicitacao.") 
    
    $rsDispensaInex = db_query($sSql);//db_criatabela($rsDispensaInex);
   
    /**
     * percorrer registros de contas retornados do sql acima
     */
    for ($iCont = 0;$iCont < pg_num_rows($rsDispensaInex); $iCont++) {
      
      $oDispensaInex = db_utils::fieldsMemory($rsDispensaInex,$iCont);
      
      foreach ($oDadosComplLicitacoes as $oDadosComplLicitacao ) {
      	      	
      	if ($oDadosComplLicitacao->getAttribute('instituicao') == db_getsession("DB_instit")
				  && $oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio') == $oDispensaInex->l20_codigo) {
      	
				  /**
           *variavel usada no registro 12
				   */
				  	$sTipoProcesso = $oDadosComplLicitacao->getAttribute('tipoProcesso');
				  	$sNumerol      = $oDadosComplLicitacao->getAttribute('codigoProcesso')."/".$oDadosComplLicitacao->getAttribute('ano');
				  	
          $oDadosDispensaInex = new stdClass();
      	
          $oDadosDispensaInex->tipoRegistro          				=  10;
          $oDadosDispensaInex->detalhesessao 		    			  =  10;
          $oDadosDispensaInex->codOrgaoResp      	 				  =  $sOrgao;
          $oDadosDispensaInex->codUnidadeSubResp     				=  " ";
          $oDadosDispensaInex->exercicioProcesso          	=  str_pad($oDispensaInex->l20_anousu, 4, "0", STR_PAD_LEFT);
          $oDadosDispensaInex->nroProcesso          				=  substr($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);
          $oDadosDispensaInex->tipoProcesso          				=  substr($oDispensaInex->l44_codigotribunal, 0, 1);
          $oDadosDispensaInex->dtAbertura          				 	=  implode(array_reverse(explode("-", $oDispensaInex->l20_dataaber)));
          $oDadosDispensaInex->naturezaObjeto          			=  substr($oDadosComplLicitacao->getAttribute('naturezaObjeto'), -1, 1);
          $oDadosDispensaInex->objeto          					 	  =  substr($oDispensaInex->l20_objeto, 0, 250);
          $oDadosDispensaInex->justificativa          			=  utf8_decode(substr($oDadosComplLicitacao->getAttribute('justificativa'), 0, 250));
          $oDadosDispensaInex->razao          					 	  =  utf8_decode(substr($oDadosComplLicitacao->getAttribute('razao'), 0, 250));
          $oDadosDispensaInex->dtPublicacaoTermoRatificacao =  implode(array_reverse(explode("-", $oDispensaInex->l20_dtpublic)));
          $oDadosDispensaInex->veiculoPublicacao        		=  substr($oDadosComplLicitacao->getAttribute('veiculoPublicacao'), 0, 50);;
      
          $this->aDados[]     = $oDadosDispensaInex;
          
		  }
		
    }
      
      
      $sSql2 = "SELECT l20_codigo, l20_numero, l20_dataaber,l20_anousu, 
	  l03_descr, l03_pctipocompratribunal, z01_cgccpf, 
	  z01_nome, z01_ender, z01_bairro, z01_munic, z01_uf, z01_cep, z01_telef, z01_email, z01_cxpostal,
	  case when l31_tipo = '3' then '2' when l31_tipo = '4' then '3' when l31_tipo = '5' then '4' when l31_tipo = '8' then '5' else l31_tipo end as l31_tipo 
	  from liclicita 
	  join cflicita on l20_codtipocom = l03_codigo 
	  join liccomissao on l20_liccomissao = l30_codigo 
	  join liccomissaocgm on l30_codigo = l31_liccomissao 
	  join cgm on l31_numcgm = z01_numcgm  
	  where l20_instit = ".db_getsession("DB_instit")." and l20_codigo = ".$oDispensaInex->l20_codigo." and l31_tipo not in('2','6','7','9')";
      
      $rsDetaResp = db_query($sSql2);
   
    foreach ($oDadosComplLicitacoes as $oDadosComplLicitacao ) {
        	
      if ($oDadosComplLicitacao->getAttribute('instituicao') == db_getsession("DB_instit")
				  && $oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio') == $oDispensaInex->l20_codigo) {
			  $iNroProcesso = substr($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);	
			}
			
    }
      
      /**
     * percorrer registros de contas retornados do sql acima
     */
      for ($iCont2 = 0;$iCont2 < pg_num_rows($rsDetaResp); $iCont2++) {
      
        $oDetaResp = db_utils::fieldsMemory($rsDetaResp,$iCont2);
      		
				$aTelefone = array("(",")");
				  	
        $oDadosDetaResp = new stdClass();
      
        $oDadosDetaResp->tipoRegistro      =  11;
        $oDadosDetaResp->detalhesessao 		 =  11;
        $oDadosDetaResp->codOrgaoResp      =  $sOrgao;
        $oDadosDetaResp->codUnidadeSubResp =  " ";
        $oDadosDetaResp->exercicioProcesso =  str_pad($oDispensaInex->l20_anousu, 4, "0", STR_PAD_LEFT);
        $oDadosDetaResp->nroProcesso       =  $iNroProcesso;
        $oDadosDetaResp->tipoProcesso      =  $oDadosDispensaInex->tipoProcesso;
        $oDadosDetaResp->tipoResp					 =  substr($oDetaResp->l31_tipo, -1, 1);
        $oDadosDetaResp->nroCPFResp        =  str_pad($oDetaResp->z01_cgccpf, 11, "0", STR_PAD_LEFT);
        $oDadosDetaResp->nomeResp          =  substr($oDetaResp->z01_nome, 0, 50);
        $oDadosDetaResp->logradouro        =  substr($oDetaResp->z01_ender, 0, 75);
        $oDadosDetaResp->bairroLogra       =  substr($oDetaResp->z01_bairro, 0, 50);
        $oDadosDetaResp->codCidadeLogra    =  str_pad($oDetaResp->z01_cxpostal, 5, "0", STR_PAD_LEFT);
        $oDadosDetaResp->ufCidadeLogra     =  str_pad($oDetaResp->z01_uf, 2, "0", STR_PAD_LEFT);
        $oDadosDetaResp->cepLogra        	 =  str_pad($oDetaResp->z01_cep, 2, "0", STR_PAD_LEFT);
      	$oDadosDetaResp->telefone        	 =  str_replace($aTelefone, "", $oDetaResp->z01_telef);
        $oDadosDetaResp->email        		 =  substr($oDetaResp->z01_email, 0, 50);
          
        $this->aDados[]     = $oDadosDetaResp;
        
      }
      
      /**
       * adicionar responsaveis cadastrados no parecer da licitacao
       */
      foreach ($oDadosParecer as $oParecer) {
      	
      	if ($oParecer->getAttribute('instituicao') == db_getsession("DB_instit")
				  && $oParecer->getAttribute('nroProcessoLicitatorio') == $oDispensaInex->l20_codigo) {
      	
				  if ($oParecer->getAttribute('tipoParecer') != '02') {
				  	$iTipoResp = '7';
				  } else {
				  	$iTipoResp = '6';
				  }
				  	
				  $oDadosDetaResp = new stdClass();
      
          $oDadosDetaResp->tipoRegistro      =  11;
          $oDadosDetaResp->detalhesessao 		 =  11;
          $oDadosDetaResp->codOrgaoResp      =  $sOrgao;
          $oDadosDetaResp->codUnidadeSubResp =  " ";
          $oDadosDetaResp->exercicioProcesso =  str_pad($oDispensaInex->l20_anousu, 4, "0", STR_PAD_LEFT);
          $oDadosDetaResp->nroProcesso       =  $iNroProcesso;
          $oDadosDetaResp->tipoProcesso      =  $oDadosDispensaInex->tipoProcesso;
          $oDadosDetaResp->tipoResp					 =  $iTipoResp;
          $oDadosDetaResp->nroCPFResp        =  $oParecer->getAttribute('nroCpf');
          $oDadosDetaResp->nomeResp          =  utf8_decode(substr($oParecer->getAttribute('nomRespParecer'), 0, 50));
          $oDadosDetaResp->logradouro        =  utf8_decode(substr($oParecer->getAttribute('logradouro'), 0, 75));
          $oDadosDetaResp->bairroLogra       =  utf8_decode(substr($oParecer->getAttribute('bairroLogra'), 0, 50));
          $oDadosDetaResp->codCidadeLogra    =  str_pad($oParecer->getAttribute('codCidadeLogra'), 5, "0", STR_PAD_LEFT);
          $oDadosDetaResp->ufCidadeLogra     =  $oParecer->getAttribute('ufCidadeLogra');
          $oDadosDetaResp->cepLogra        	 =  $oParecer->getAttribute('cepLogra');
      	  $oDadosDetaResp->telefone        	 =  str_replace($aTelefone, "", $oParecer->getAttribute('telefone'));
          $oDadosDetaResp->email        		 =  substr($oParecer->getAttribute('email'), 0, 50);
          
          $this->aDados[]     = $oDadosDetaResp;
				  	
				}
				  	
      }
      
      $sSql3 = "select m61_descr,pc01_codmater,pc01_descrmater, pc81_codprocitem
	  from liclicitem
		join pcprocitem  on l21_codpcprocitem = pc81_codprocitem
		join solicitem on pc81_solicitem = pc11_codigo
		join solicitempcmater on pc16_solicitem = pc11_codigo
		join pcmater on pc16_codmater = pc01_codmater
		join solicitemunid on pc17_codigo = pc11_codigo
		join matunid on pc17_unid = m61_codmatunid
	  where l21_codliclicita = ".$oDispensaInex->l20_codigo;
      
      $rsDetaPesq = db_query($sSql3);
      
      if (pg_num_rows($rsDetaPesq) == 0) {
      	
      	$sSql3 = "select e60_numemp,pc01_codmater,pc01_descrmater,e62_vlrun from empempenho join empempitem on e60_numemp = e62_numemp
      	          join pctipocompra on empempenho.e60_codcom = pctipocompra.pc50_codcom
      	          join pctipocompratribunal on pctipocompra.pc50_pctipocompratribunal = pctipocompratribunal.l44_sequencial
									join pcmater on e62_item = pc01_codmater where e60_numerol = '".$sNumerol."' and pctipocompratribunal.l44_sequencial in (100,101,102)";
      	$rsDetaPesq = db_query($sSql3);
      	//db_criatabela($rsDetaPesq);
      	$aDadosAgrupados12 = array();
      	for ($iCont3 = 0;$iCont3 < pg_num_rows($rsDetaPesq); $iCont3++) {
      		
      		$oDetaPesq = db_utils::fieldsMemory($rsDetaPesq,$iCont3);
      		
				  $sHash12 = $oDetaPesq->pc01_codmater;
      		if (!$aDadosAgrupados12[$sHash12]) {
      			
      		  $oDadosDetaPesq = new stdClass();
	      		
            $oDadosDetaPesq->tipoRegistro        =  12;
            $oDadosDetaPesq->detalhesessao 		   =  12;
            $oDadosDetaPesq->codOrgaoResp      	 =  $sOrgao;
            $oDadosDetaPesq->codUnidadeSubResp   =  " ";
            $oDadosDetaPesq->exercicioProcesso   =  str_pad($oDispensaInex->l20_anousu, 4, "0", STR_PAD_LEFT);
            $oDadosDetaPesq->nroProcesso         =  $iNroProcesso;
            $oDadosDetaPesq->tipoProcesso        =  $oDadosDispensaInex->tipoProcesso;
            $oDadosDetaPesq->nroLote					   =  " ";
            $oDadosDetaPesq->nroItem             =  substr($oDetaPesq->pc01_codmater, 0, 4);
            $oDadosDetaPesq->dscItem             =  substr($oDetaPesq->pc01_descrmater, 0, 50);
            $oDadosDetaPesq->vlCotPrecosUnitario =  $oDetaPesq->e62_vlrun;
            
            $aDadosAgrupados12[$sHash12] = $oDadosDetaPesq;
          
      		} else {
      			$aDadosAgrupados12[$sHash12]->vlCotPrecosUnitario += $oDetaPesq->e62_vlrun;
      		}
      		
      	}
        foreach ($aDadosAgrupados12 as $oDado) {
      	
      	  $oDado->vlCotPrecosUnitario = number_format($oDado->vlCotPrecosUnitario, 4, "", "");
      	  $this->aDados[] = $oDado;
      	
        }
      	
      } else {
      
      /**
     * percorrer registros de contas retornados do sql
     */
      $aDadosAgrupados = array();
      for ($iCont3 = 0;$iCont3 < pg_num_rows($rsDetaPesq); $iCont3++) {
      
        $oDetaPesq = db_utils::fieldsMemory($rsDetaPesq,$iCont3);
        
        foreach ($oPrecosMedios as $oPrecoMedio ) {
          
          if ($oPrecoMedio->getAttribute('instituicao') == db_getsession("DB_instit")
				      && $oPrecoMedio->getAttribute('nroProcessoLicitatorio') == $oDispensaInex->l20_codigo
				      && $oPrecoMedio->getAttribute('codigoitemprocesso') == $oDetaPesq->pc81_codprocitem) {
        	
				    $nPrecoMedio = $oPrecoMedio->getAttribute('vlCotPrecosUnitario');
        
      
            foreach ($oDadosComplLicitacoes as $oDadosComplLicitacao ) {
        	
              if ($oDadosComplLicitacao->getAttribute('instituicao') == db_getsession("DB_instit")
				          && $oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio') == $oDispensaInex->l20_codigo) {
        		  	
				        $sHash  = $sOrgao.$oDispensaInex->l20_anousu.$oDadosComplLicitacao->getAttribute('codigoProcesso');
				        $sHash .= $oDadosDispensaInex->tipoProcesso.$oDetaPesq->pc01_codmater;
				        
				        if (!isset($aDadosAgrupados[$sHash])) {
				        
	                $oDadosDetaPesq = new stdClass();
	      		
		              $oDadosDetaPesq->tipoRegistro        =  12;
		              $oDadosDetaPesq->detalhesessao 		   =  12;
		              $oDadosDetaPesq->codOrgaoResp      	 =  $sOrgao;
		              $oDadosDetaPesq->codUnidadeSubResp   =  " ";
		              $oDadosDetaPesq->exercicioProcesso   =  str_pad($oDispensaInex->l20_anousu, 4, "0", STR_PAD_LEFT);
		              $oDadosDetaPesq->nroProcesso         =  $iNroProcesso;
		              $oDadosDetaPesq->tipoProcesso        =  $oDadosDispensaInex->tipoProcesso;
		              $oDadosDetaPesq->nroLote					   =  " ";
		              $oDadosDetaPesq->nroItem             =  substr($oDetaPesq->pc01_codmater, 0, 4);
		              $oDadosDetaPesq->dscItem             =  substr($oDetaPesq->pc01_descrmater, 0, 50);
		              $oDadosDetaPesq->vlCotPrecosUnitario =  0;
		            
		              $aDadosAgrupados[$sHash] = $oDadosDetaPesq;
			
				        } else {
				        	$oDadosDetaPesq = $aDadosAgrupados[$sHash];
				        }
	              
				        $oDadosDetaPesq->vlCotPrecosUnitario += $nPrecoMedio;
				        
				        $DadosAgrupados[$sHash] = $oDadosDetaPesq;
				        
		         }
            
            }
            
				  }
	        	  
        }
       
      }
      
      foreach ($aDadosAgrupados as $oDado) {
      	
      	$oDado->vlCotPrecosUnitario = number_format($oDado->vlCotPrecosUnitario, 4, "", "");
      	$this->aDados[] = $oDado;
      	
      }
      
    }
      
	     $sSql4 = "select distinct  o58_orgao, o58_unidade, o58_funcao, o58_subfuncao, o58_programa, o58_projativ, o15_codtri,
		substr(o56_elemento,2,6) as elemento, o58_valor
		from liclicitem 
		inner join pcprocitem on liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem 
		inner join pcproc on pcproc.pc80_codproc = pcprocitem.pc81_codproc 
		inner join solicitem on solicitem.pc11_codigo = pcprocitem.pc81_solicitem 
		inner join solicita on solicita.pc10_numero = solicitem.pc11_numero 
		inner join db_depart on db_depart.coddepto = solicita.pc10_depto
		left join liclicita on liclicita.l20_codigo = liclicitem.l21_codliclicita 
		left join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom 
		left join pctipocompra on pctipocompra.pc50_codcom = cflicita.l03_codcom 
		left join solicitemunid on solicitemunid.pc17_codigo = solicitem.pc11_codigo 
		left join matunid on matunid.m61_codmatunid = solicitemunid.pc17_unid 
		left join pcorcamitemlic on l21_codigo = pc26_liclicitem 
		left join pcorcamval on pc26_orcamitem = pc23_orcamitem 
		left join db_usuarios on pcproc.pc80_usuario = db_usuarios.id_usuario 
		left join solicitempcmater on solicitempcmater.pc16_solicitem = solicitem.pc11_codigo 
		left join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater 
		left join pcsubgrupo on pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo 
		left join pctipo on pctipo.pc05_codtipo = pcsubgrupo.pc04_codtipo 
		left join solicitemele on solicitemele.pc18_solicitem = solicitem.pc11_codigo 
		left join orcelemento on orcelemento.o56_codele = solicitemele.pc18_codele 
			and orcelemento.o56_anousu = 2012 
		left join empautitempcprocitem on empautitempcprocitem.e73_pcprocitem = pcprocitem.pc81_codprocitem 
		left join empautitem on empautitem.e55_autori = empautitempcprocitem.e73_autori 
			and empautitem.e55_sequen = empautitempcprocitem.e73_sequen
		left join empautoriza on empautoriza.e54_autori = empautitem.e55_autori 
		left join empempaut on empempaut.e61_autori = empautitem.e55_autori 
		left join empempenho on empempenho.e60_numemp = empempaut.e61_numemp 
		left join pcdotac on solicitem.pc11_codigo = pcdotac.pc13_codigo
		join orcdotacao on pc13_anousu = o58_anousu 
			and pc13_coddot = o58_coddot
		join orctiporec on o58_codigo = o15_codigo
		
		where l21_codliclicita= ".$oDispensaInex->l20_codigo;
      
      $rsDetaRecursos = db_query($sSql4);
      /**
     * percorrer registros de contas retornados do sql acima
     */
      
      for ($iCont4 = 0;$iCont4 < pg_num_rows($rsDetaRecursos); $iCont4++) {
      
        $oDetaRecursos = db_utils::fieldsMemory($rsDetaRecursos,$iCont4);
      
        foreach ($oDadosComplLicitacoes as $oDadosComplLicitacao ) {
        	 
          if ($oDadosComplLicitacao->getAttribute('instituicao') == db_getsession("DB_instit")
				  && $oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio') == $oDispensaInex->l20_codigo) {
      		
				    if ($sTrataCodUnidade == "01") {
      		
      		    $sCodUnidade  = str_pad($oDetaRecursos->o58_orgao, 2, "0", STR_PAD_LEFT);
	   		      $sCodUnidade .= str_pad($oDetaRecursos->o58_unidade, 3, "0", STR_PAD_LEFT);
	   		  
      	    } else {
      		
      		    $sCodUnidade	= str_pad($oDetaRecursos->o58_orgao, 3, "0", STR_PAD_LEFT);
	   		      $sCodUnidade .= str_pad($oDetaRecursos->o58_unidade, 2, "0", STR_PAD_LEFT);
      		
      	    }
				  	
            $oDadosDetaRecursos = new stdClass();
      
            $oDadosDetaRecursos->tipoRegistro      =  13;
            $oDadosDetaRecursos->detalhesessao 		 =  13;
            $oDadosDetaRecursos->codOrgaoResp      =  $sOrgao;
            $oDadosDetaRecursos->codUnidadeSubResp =  " ";
            $oDadosDetaRecursos->exercicioProcesso =  str_pad($oDispensaInex->l20_anousu, 4, "0", STR_PAD_LEFT);
            $oDadosDetaRecursos->nroProcesso       =  substr($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);
            $oDadosDetaRecursos->tipoProcesso      =  $oDadosDispensaInex->tipoProcesso;
            $oDadosDetaRecursos->codOrgao          =  $sOrgao;
            $oDadosDetaRecursos->codUnidadeSub     =  $sCodUnidade;
            $oDadosDetaRecursos->codFuncao				 =  str_pad($oDetaRecursos->o58_funcao, 2, "0", STR_PAD_LEFT);;
            $oDadosDetaRecursos->codSubFuncao      =  str_pad($oDetaRecursos->o58_subfuncao, 3, "0", STR_PAD_LEFT);
            $oDadosDetaRecursos->codPrograma       =  str_pad($oDetaRecursos->o58_programa, 4, "0", STR_PAD_LEFT);
            $oDadosDetaRecursos->idAcao          	 =  str_pad($oDetaRecursos->o58_projativ, 4, "0", STR_PAD_LEFT);
            $oDadosDetaRecursos->idSubAcao       	 =  " ";
            $oDadosDetaRecursos->elementoDespesa   =  str_pad($oDetaRecursos->elemento, 6, "0", STR_PAD_LEFT);
            $oDadosDetaRecursos->codFontRecursos   =  str_pad($oDetaRecursos->o15_codtri, 3, "0", STR_PAD_LEFT);
            $oDadosDetaRecursos->vlRecurso         =  substr($oDetaRecursos->o58_valor, 0, 13);
          
            $this->aDados[]     = $oDadosDetaRecursos;
      
		      }
            
        }
        
      }
      
      $sSql5 = "select distinct liclicitem.l21_codigo,z01_nome,pc01_descrmater,(pc01_codmater::varchar||matunid.m61_codmatunid::varchar) as pc01_codmater,pc11_quant,pc23_valor, z01_cgccpf
	  from pcorcamjulg 
		inner join pcorcamforne on pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne 
		inner join pcorcamitem on pcorcamitem.pc22_orcamitem = pcorcamjulg.pc24_orcamitem 
		inner join cgm on cgm.z01_numcgm = pcorcamforne.pc21_numcgm 
		inner join pcorcam on pcorcam.pc20_codorc = pcorcamforne.pc21_codorc 
		inner join pcorcam a on a.pc20_codorc = pcorcamitem.pc22_codorc 
		inner join pcorcamitemlic on pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem 
		inner join liclicitem on liclicitem.l21_codigo = pcorcamitemlic.pc26_liclicitem 
		inner join pcprocitem on pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem 
		inner join pcproc on pcproc.pc80_codproc=pcprocitem.pc81_codproc
		inner join liclicita on liclicita.l20_codigo = liclicitem.l21_codliclicita 
		inner join pcdotac on pc13_codigo=pcprocitem.pc81_solicitem 
		left join pcdotaccontrapartida on pc13_sequencial=pc19_pcdotac 
		inner join pcorcamval on pcorcamval.pc23_orcamforne=pcorcamjulg.pc24_orcamforne 
			and pcorcamval.pc23_orcamitem=pcorcamitem.pc22_orcamitem 
		inner join solicitem on solicitem.pc11_codigo= pcprocitem.pc81_solicitem 
		inner join solicita on solicita.pc10_numero = solicitem.pc11_numero 
		inner join solicitempcmater on solicitempcmater.pc16_solicitem= solicitem.pc11_codigo 
		inner join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater 
		inner join solicitemele on solicitemele.pc18_solicitem= solicitem.pc11_codigo 
		left join solicitemunid on solicitemunid.pc17_codigo = solicitem.pc11_codigo 
		left join matunid on matunid.m61_codmatunid = solicitemunid.pc17_unid 
		left join pcsubgrupo on pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo 
		left join pctipo on pctipo.pc05_codtipo = pcsubgrupo.pc04_codtipo 
		left join orcelemento on pc18_codele = o56_codele and o56_anousu = ".db_getsession("DB_anousu")." 
where  pc24_pontuacao=1 and pc10_instit= ".db_getsession("DB_instit")." and l20_codigo= ".$oDispensaInex->l20_codigo;
      
      $rsDetaForn = db_query($sSql5);//echo $sSql5." / ".$oDispensaInex->l20_codigo;db_criatabela($rsDetaForn);
      /**
     * percorrer registros de contas retornados do sql acima
     */
      for ($iCont5 = 0;$iCont5 < pg_num_rows($rsDetaForn); $iCont5++) {
      
        $oDetaForn = db_utils::fieldsMemory($rsDetaForn,$iCont5);
        
        if (strlen($oDetaForn->z01_cgccpf) == 11) 
        	$iTipoDocumento   = 1;
        else 
        	$iTipoDocumento   = 2;	
        	
        foreach ($oDadosComplLicitacoes as $oDadosComplLicitacao ) {
        	 
          if ($oDadosComplLicitacao->getAttribute('instituicao') == db_getsession("DB_instit")
				  && $oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio') == $oDispensaInex->l20_codigo) {
      
				  	foreach ($oHabilitacoes as $oHabilitacao) {
        	 
              if ($oHabilitacao->getAttribute('instituicao') == db_getsession("DB_instit")
				          && $oHabilitacao->getAttribute('nroProcessoLicitatorio') == $oDispensaInex->l20_codigo
				          && $oHabilitacao->getAttribute('nroDocumento') == $oDetaForn->z01_cgccpf) {
				          	
                $oDadosDetaForn = new stdClass();
      
		            $oDadosDetaForn->tipoRegistro          				      =  14;
		            $oDadosDetaForn->detalhesessao 		    			        =  14;
		            $oDadosDetaForn->codOrgaoResp      	 		            =  $sOrgao;
			          $oDadosDetaForn->codUnidadeSubResp     		          =  " ";
		            $oDadosDetaForn->exercicioProcesso                  =  str_pad($oDispensaInex->l20_anousu, 4, "0", STR_PAD_LEFT);
		            $oDadosDetaForn->nroProcesso          				      =  substr($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);
		            $oDadosDetaForn->tipoProcesso          				      =  $oDadosDispensaInex->tipoProcesso;
		            $oDadosDetaForn->tipoDocumento           	 		      =  $iTipoDocumento;
		            $oDadosDetaForn->nroDocumento            		        =  substr($oDetaForn->z01_cgccpf, 0, 14);
		            $oDadosDetaForn->nomRazaoSocial            		      =  utf8_decode(substr($oHabilitacao->getAttribute('nomRazaoSocial'), 0, 120));
		            $oDadosDetaForn->nroInscricaoEstadual			          =  substr($oHabilitacao->getAttribute('nroInscricaoEstadual'), 0, 30);
		            $oDadosDetaForn->ufInscricaoEstadual          		  =  $oHabilitacao->getAttribute('ufInscricaoEstadual');
		            $oDadosDetaForn->nroCertidaoRegularidadeINSS        =  substr($oHabilitacao->getAttribute('nroCertidaoRegularidadeINSS'), 0, 30);
		            $oDadosDetaForn->dtEmissaoCertidaoRegularidadeINSS  =  str_replace("/", "", $oHabilitacao->getAttribute('dtEmissaoCertidaoRegularidadeINSS'));
		            $oDadosDetaForn->dtValidadeCertidaoRegularidadeINSS =  str_replace("/", "", $oHabilitacao->getAttribute('dtValidadeCertidaoRegularidadeINSS'));
		            $oDadosDetaForn->nroCertidaoRegularidadeFGTS        =  substr($oHabilitacao->getAttribute('nroCertidaoRegularidadeFGTS'), 0, 30);
		            $oDadosDetaForn->dtEmissaoCertidaoRegularidadeFGTS  =  str_replace("/", "", $oHabilitacao->getAttribute('dtEmissaoCertidaoRegularidadeFGTS'));
		            $oDadosDetaForn->dtValidadeCertidaoRegularidadeFGTS	=  str_replace("/", "", $oHabilitacao->getAttribute('dtValidadeCertidaoRegularidadeFGTS'));
		            $oDadosDetaForn->nroCNDT                            =  $iTipoDocumento == 1 ? ' ' : $oHabilitacao->getAttribute('nroCNDT');
    						$oDadosDetaForn->dtEmissaoCNDT                      =  $iTipoDocumento == 1 ? ' ' : implode(explode("/", $oHabilitacao->getAttribute('dtEmissaoCNDT')));
    						$oDadosDetaForn->dtValidadeCNDT                     =  $iTipoDocumento == 1 ? ' ' : implode(explode("/", $oHabilitacao->getAttribute('dtValidadeCNDT')));
		            $oDadosDetaForn->nroLote          		 			        =  " ";
		            $oDadosDetaForn->nroItem           					        =  str_pad($oDetaForn->l21_codigo, 4, "0", STR_PAD_LEFT);
		            $oDadosDetaForn->quantidade     					          =  number_format($oDetaForn->pc11_quant, 4, "", "");
		            $oDadosDetaForn->vlItem    							            =  number_format($oDetaForn->pc23_valor, 4, "", "");
		          
		            $this->aDados[]     = $oDadosDetaForn;
                break;
                
				      }
				      
				  	}
				  	break;
          }
        
        }
        
      }
      
      /**
     * caso o sql acima nao retorne dados
     */
 
        
        
      if (pg_num_rows($rsDetaForn) == 0) {
        foreach ($oDadosComplLicitacoes as $oDadosComplLicitacao ) {
        	 
          if ($oDadosComplLicitacao->getAttribute('instituicao') == db_getsession("DB_instit")
				  && $oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio') == $oDispensaInex->l20_codigo) {
      
				  	foreach ($oHabilitacoes as $oHabilitacao) {
        	 
              if ($oHabilitacao->getAttribute('instituicao') == db_getsession("DB_instit")
				          && $oHabilitacao->getAttribute('nroProcessoLicitatorio') == $oDispensaInex->l20_codigo) {

				        if (strlen($oHabilitacao->getAttribute('nroDocumento')) == 11) 
        	        $iTipoDocumento   = '1';
                else 
        	        $iTipoDocumento   = '2';	

        	      $sSqlItem = "select e62_sequencial,pc01_codmater,pc01_descrmater,e62_vlrun,e62_quant from empempenho join empempitem on e60_numemp = e62_numemp
join pcmater on e62_item = pc01_codmater where e60_numerol = '".$sNumerol."'";
        	      $rsDetaForn = db_query($sSqlItem);
        	      
        	      for ($iContItem= 0; $iContItem < pg_num_rows($rsDetaForn); $iContItem++) {
        	      	
	        	      $oDetaForn = db_utils::fieldsMemory($rsDetaForn,$iContItem);
	                $oDadosDetaForn = new stdClass();
	      
			            $oDadosDetaForn->tipoRegistro          				      =  14;
			            $oDadosDetaForn->detalhesessao 		    			        =  14;
			            $oDadosDetaForn->codOrgaoResp      	 		            =  $sOrgao;
			            $oDadosDetaForn->codUnidadeSubResp     		          =  " ";
			            $oDadosDetaForn->exercicioProcesso                  =  str_pad($oDispensaInex->l20_anousu, 4, "0", STR_PAD_LEFT);
			            $oDadosDetaForn->nroProcesso          				      =  substr($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);
			            $oDadosDetaForn->tipoProcesso          				      =  $oDadosDispensaInex->tipoProcesso;
			            $oDadosDetaForn->tipoDocumento           	 		      =  $iTipoDocumento;
			            $oDadosDetaForn->nroDocumento            		        =  substr($oHabilitacao->getAttribute('nroDocumento'), 0, 14);
			            $oDadosDetaForn->nomRazaoSocial            		      =  substr($oHabilitacao->getAttribute('nomRazaoSocial'), 0, 120);
			            $oDadosDetaForn->nroInscricaoEstadual			          =  substr($oHabilitacao->getAttribute('nroInscricaoEstadual'), 0, 30);
			            $oDadosDetaForn->ufInscricaoEstadual          		  =  $oHabilitacao->getAttribute('ufInscricaoEstadual');
			            $oDadosDetaForn->nroCertidaoRegularidadeINSS        =  substr($oHabilitacao->getAttribute('nroCertidaoRegularidadeINSS'), 0, 30);
			            $oDadosDetaForn->dtEmissaoCertidaoRegularidadeINSS  =  str_replace("/", "", $oHabilitacao->getAttribute('dtEmissaoCertidaoRegularidadeINSS'));
			            $oDadosDetaForn->dtValidadeCertidaoRegularidadeINSS =  str_replace("/", "", $oHabilitacao->getAttribute('dtValidadeCertidaoRegularidadeINSS'));
			            $oDadosDetaForn->nroCertidaoRegularidadeFGTS        =  substr($oHabilitacao->getAttribute('nroCertidaoRegularidadeFGTS'), 0, 30);
			            $oDadosDetaForn->dtEmissaoCertidaoRegularidadeFGTS  =  str_replace("/", "", $oHabilitacao->getAttribute('dtEmissaoCertidaoRegularidadeFGTS'));
			            $oDadosDetaForn->dtValidadeCertidaoRegularidadeFGTS	=  str_replace("/", "", $oHabilitacao->getAttribute('dtValidadeCertidaoRegularidadeFGTS'));
			            $oDadosDetaForn->nroCNDT                            =  $oHabilitacao->getAttribute('nroCNDT');
	    						$oDadosDetaForn->dtEmissaoCNDT                      =  implode(explode("/", $oHabilitacao->getAttribute('dtEmissaoCNDT')));
	    						$oDadosDetaForn->dtValidadeCNDT                     =  implode(explode("/", $oHabilitacao->getAttribute('dtValidadeCNDT')));
			            $oDadosDetaForn->nroLote          		 			        =  " ";
			            $oDadosDetaForn->nroItem           					        =  str_pad($oDetaForn->e62_sequencial, 4, "0", STR_PAD_LEFT);
			            $oDadosDetaForn->quantidade     					          =  number_format($oDetaForn->e62_quant, 4, "", "");
			            $oDadosDetaForn->vlItem    							            =  number_format($oDetaForn->e62_vlrun, 4, "", "");
			          
			            $this->aDados[]     = $oDadosDetaForn;
		            
        	      }
                break;
                
				      }
				      
				  	}
				  	break;
          }
        
        }
      }    
    
      
    }
    
   }
}
		
  

 