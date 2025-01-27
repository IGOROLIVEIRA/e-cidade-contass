<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_dispensa102014_classe.php");
require_once ("classes/db_dispensa112014_classe.php");
require_once ("classes/db_dispensa122014_classe.php");
require_once ("classes/db_dispensa132014_classe.php");
require_once ("classes/db_dispensa142014_classe.php");
require_once ("classes/db_dispensa152014_classe.php");
require_once ("classes/db_dispensa162014_classe.php");
require_once ("classes/db_dispensa172014_classe.php");
require_once ("classes/db_dispensa182014_classe.php");


require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2014/GerarDISPENSA.model.php");


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
  	
  	
  	/**
  	 * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo 
  	 */
  	$dispensa102014 = new cl_dispensa102014();
  	$dispensa112014 = new cl_dispensa112014();
  	$dispensa122014 = new cl_dispensa122014();
  	$dispensa132014 = new cl_dispensa132014();
  	$dispensa142014 = new cl_dispensa142014();
  	$dispensa152014 = new cl_dispensa152014();
  	$dispensa162014 = new cl_dispensa162014();
  	$dispensa172014 = new cl_dispensa172014();
  	$dispensa182014 = new cl_dispensa182014();
    
    /**
     * excluir informacoes do mes selecioado
     */
    db_inicio_transacao();
    
  
    $result = db_query($dispensa112014->sql_query(NULL,"*",NULL,"si75_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si75_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa112014->excluir(NULL,"si75_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si75_instit=".db_getsession("DB_instit"));
      if ($dispensa112014->erro_status == 0) {
    	  throw new Exception($dispensa112014->erro_msg);
      }
    }
    
  
    $result = db_query($dispensa122014->sql_query(NULL,"*",NULL,"si76_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si76_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa122014->excluir(NULL,"si76_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si76_instit=".db_getsession("DB_instit"));
      if ($dispensa122014->erro_status == 0) {
    	  throw new Exception($dispensa122014->erro_msg);
      }
    }
    
  
    $result = db_query($dispensa132014->sql_query(NULL,"*",NULL,"si77_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si77_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa132014->excluir(NULL,"si77_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si77_instit=".db_getsession("DB_instit"));
      if ($dispensa132014->erro_status == 0) {
    	  throw new Exception($dispensa132014->erro_msg);
      }
    }
    
  
    $result = db_query($dispensa142014->sql_query(NULL,"*",NULL,"si78_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si78_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa142014->excluir(NULL,"si78_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si78_instit=".db_getsession("DB_instit"));
      if ($dispensa142014->erro_status == 0) {
    	  throw new Exception($dispensa142014->erro_msg);
      }
    }
    
    
  
    $result = db_query($dispensa152014->sql_query(NULL,"*",NULL,"si79_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si79_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa152014->excluir(NULL,"si79_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si79_instit=".db_getsession("DB_instit"));
      if ($dispensa152014->erro_status == 0) {
    	  throw new Exception($dispensa152014->erro_msg);
      }
    }
    
  
    $result = db_query($dispensa162014->sql_query(NULL,"*",NULL,"si80_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si80_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa162014->excluir(NULL,"si80_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si80_instit=".db_getsession("DB_instit"));
      if ($dispensa162014->erro_status == 0) {
    	  throw new Exception($dispensa162014->erro_msg);
      }
    }
    
    $result = db_query($dispensa172014->sql_query(NULL,"*",NULL,"si81_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si81_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa172014->excluir(NULL,"si81_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si81_instit=".db_getsession("DB_instit"));
      if ($dispensa172014->erro_status == 0) {
    	  throw new Exception($dispensa172014->erro_msg);
      }
    }
    
  	$result = db_query($dispensa182014->sql_query(NULL,"*",NULL,"si82_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si82_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa182014->excluir(NULL,"si82_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si82_instit=".db_getsession("DB_instit"));
      if ($dispensa182014->erro_status == 0) {
    	  throw new Exception($dispensa182014->erro_msg);
      }
    }
    
    
  $result = db_query($dispensa102014->sql_query(NULL,"*",NULL,"si74_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si74_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa102014->excluir(NULL,"si74_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si74_instit=".db_getsession("DB_instit"));
      if ($dispensa102014->erro_status == 0) {
    	  throw new Exception($dispensa102014->erro_msg);
      }
    }
    
  	
	$sSql = "SELECT DISTINCT l20_codepartamento, '10' as tipoRegistro,
	infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
	(select case when subunidade = 1 then codunidade ||  lpad(subunidade::varchar,3,0) else codunidade end as codunidade from (select case when si08_tratacodunidade = 1 then lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) else lpad(db01_unidade,2,0) || lpad(db01_orgao,3,0) end as codunidade,o41_subunidade as subunidade from db_departorg 
	join infocomplementares on si08_anousu = db01_anousu and si08_instit = ".db_getsession("DB_instit")."  
join orcunidade on db01_orgao=o41_orgao and db01_unidade=o41_unidade and db01_anousu = o41_anousu
	where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu")." limit 1) as x) as codUnidadeSubResp,
	liclicita.l20_anousu as exercicioLicitacao,
	liclicita.l20_edital as nroProcessoLicitatorio,
	pctipocompratribunal.l44_codigotribunal as tipoProcesso,
	liclicita.l20_dataaber as dtAbertura,
	liclicita.l20_naturezaobjeto as naturezaObjeto,
	liclicita.l20_objeto as objeto,
	liclicita.l20_justificativa as justificativa,
	liclicita.l20_razao as razao,
	liclicita.l20_dtpubratificacao as dtPublicacaoTermoRatificacao,
	l20_codigo as codlicitacao,
	liclicita.l20_veicdivulgacao as veiculoPublicacao,
	(CASE liclicita.l20_tipojulg WHEN 3 THEN 1		
		ELSE 2
	END) as processoPorLote
	FROM liclicita 
	INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
	
	INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
	INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
	LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
	INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
	WHERE db_config.codigo= " .db_getsession("DB_instit")." 
	AND pctipocompratribunal.l44_sequencial in (100,101,102) AND liclicitasituacao.l11_licsituacao = 1
	AND DATE_PART('YEAR',liclicitasituacao.l11_data)=".db_getsession("DB_anousu")."
	AND DATE_PART('MONTH',liclicitasituacao.l11_data)=".$this->sDataFinal['5'].$this->sDataFinal['6'];
		
		$rsResult10 = db_query($sSql);//db_criatabela($rsResult10);
		
		for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
		  	
		  $dispensa102014 = new cl_dispensa102014();
		  $oDados10       = db_utils::fieldsMemory($rsResult10, $iCont10);
		  	
		  $dispensa102014->si74_tiporegistro   				  = 10;
		  $dispensa102014->si74_codorgaoresp         		  = $oDados10->codorgaoresp;
		  $dispensa102014->si74_codunidadesubresp      		  = $oDados10->codunidadesubresp;
		  $dispensa102014->si74_exercicioprocesso			  = $oDados10->exerciciolicitacao;
		  $dispensa102014->si74_nroprocesso    				  = $oDados10->nroprocessolicitatorio;
		  $dispensa102014->si74_tipoprocesso    			  = $oDados10->tipoprocesso;
		  $dispensa102014->si74_dtabertura    				  = $oDados10->dtabertura  ;
		  $dispensa102014->si74_naturezaobjeto    			  = $oDados10->naturezaobjeto;
		  $dispensa102014->si74_objeto    					  = $oDados10->objeto ;
		  $dispensa102014->si74_justificativa    			  = $oDados10->justificativa ;
		  $dispensa102014->si74_razao    					  = $oDados10->razao ;
		  $dispensa102014->si74_dtpublicacaotermoratificacao  = $oDados10->dtpublicacaotermoratificacao;
		  $dispensa102014->si74_veiculopublicacao    		  = $oDados10->veiculopublicacao ;
		  $dispensa102014->si74_processoporlote    			  = $oDados10->processoporlote ;
		  $dispensa102014->si74_instit		   				   = db_getsession("DB_instit");
		  $dispensa102014->si74_mes          				  = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  	
		  $dispensa102014->incluir(null);
		  if ($dispensa102014->erro_status == 0) {
		    throw new Exception($dispensa102014->erro_msg);
		  }
		  
			
		  
		  			
		$sSql="SELECT DISTINCT  '11' as tipoRegistro,
		infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
	(select case when subunidade = 1 then codunidade ||  lpad(subunidade::varchar,3,0) else codunidade end as codunidade from (select case when si08_tratacodunidade = 1 then lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) else lpad(db01_unidade,2,0) || lpad(db01_orgao,3,0) end as codunidade,o41_subunidade as subunidade from db_departorg 
	join infocomplementares on si08_anousu = db01_anousu and si08_instit = ".db_getsession("DB_instit")."  
join orcunidade on db01_orgao=o41_orgao and db01_unidade=o41_unidade and db01_anousu = o41_anousu
	where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu")." limit 1) as x) as codUnidadeSubResp,
		liclicita.l20_anousu as exercicioLicitacao,
		liclicita.l20_edital as nroProcessoLicitatorio,
		pctipocompratribunal.l44_codigotribunal as tipoProcesso,
		liclicitemlote.l04_codigo as nroLote,
		liclicitemlote.l04_descricao as dscLote
		FROM liclicita
		INNER JOIN liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
		INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
		INNER JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
		LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
		INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
		WHERE db_config.codigo= " .db_getsession("DB_instit")." AND liclicitasituacao.l11_licsituacao = 1
		AND liclicita.l20_tipojulg = 3
		AND liclicita.l20_codigo={$oDados10->codlicitacao}";
			
		$rsResult11 = db_query($sSql);//db_criatabela($rsResult11);
		$aDadosAgrupados11 = array();
		for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {
		  	
			$oDados11       = db_utils::fieldsMemory($rsResult11, $iCont11);
			$sHash11 = $oDados11->dsclote;
			
			if (!isset($aDadosAgrupados11[$sHash11])) {
				
		    $dispensa112014 = new cl_dispensa112014();
		    
		    $dispensa112014->si75_tiporegistro   				  = 11;
		    $dispensa112014->si75_reg10    					  = $dispensa102014->si74_sequencial;
		    $dispensa112014->si75_codorgaoresp         		  = $oDados11->codorgaoresp ;
		    $dispensa112014->si75_codunidadesubresp     		  = $oDados11->codunidadesubresp;
		    $dispensa112014->si75_exercicioprocesso			  = $oDados11->exerciciolicitacao;
		    $dispensa112014->si75_nroprocesso    				  = $oDados11->nroprocessolicitatorio;
		    $dispensa112014->si75_tipoprocesso    			  = $oDados11->tipoprocesso;
		    $dispensa112014->si75_nrolote  				  	  = $oDados11->nrolote  ;
		    $dispensa112014->si75_dsclote    			  		  = $oDados11->dsclote;
		    $dispensa112014->si75_instit		   				   = db_getsession("DB_instit");
		    $dispensa112014->si75_mes          				  = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  	
		    $dispensa112014->incluir(null);
		    if ($dispensa112014->erro_status == 0) {
		      throw new Exception($dispensa112014->erro_msg);
		    }
		    $aDadosAgrupados11[$sHash11] = $dispensa112014;
		    
			}
		  
		}
		
		$sSql="select DISTINCT '12' as tipoRegistro,
		infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
	(select case when subunidade = 1 then codunidade ||  lpad(subunidade::varchar,3,0) else codunidade end as codunidade from (select case when si08_tratacodunidade = 1 then lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) else lpad(db01_unidade,2,0) || lpad(db01_orgao,3,0) end as codunidade,o41_subunidade as subunidade from db_departorg 
	join infocomplementares on si08_anousu = db01_anousu and si08_instit = ".db_getsession("DB_instit")."  
join orcunidade on db01_orgao=o41_orgao and db01_unidade=o41_unidade and db01_anousu = o41_anousu
	where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu")." limit 1) as x) as codUnidadeSubResp,
		liclicita.l20_anousu as exercicioLicitacao,
		liclicita.l20_edital as nroProcessoLicitatorio,
		pctipocompratribunal.l44_codigotribunal as tipoProcesso,
		(pcmater.pc01_codmater::varchar || (case when matunid.m61_codmatunid is null then 1 else matunid.m61_codmatunid end)::varchar) as codItem,
		(pcmater.pc01_codmater::varchar || (case when matunid.m61_codmatunid is null then 1 else matunid.m61_codmatunid end)::varchar) as nroItem	
		FROM liclicitem
		INNER JOIN liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
		INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN pcprocitem  on (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
		INNER JOIN solicitem on (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
		INNER JOIN solicitempcmater on (solicitem.pc11_codigo = solicitempcmater.pc16_solicitem)
		INNER JOIN pcmater on (solicitempcmater.pc16_codmater = pcmater.pc01_codmater)
		INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
		LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
    LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
		LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
		INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
		WHERE db_config.codigo= " .db_getsession("DB_instit")." AND liclicitasituacao.l11_licsituacao = 1
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";
		
		$rsResult12 = db_query($sSql);
		
		for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {
		  	
		  $dispensa122014 = new cl_dispensa122014();
		  $oDados12       = db_utils::fieldsMemory($rsResult12, $iCont12);
		  	
		  $dispensa122014->si76_tiporegistro   				  = 12;
		  $dispensa122014->si76_reg10 						  = $dispensa102014->si74_sequencial;		
		  $dispensa122014->si76_codorgaoresp  				  =	$oDados12->codorgaoresp;
		  $dispensa122014->si76_codunidadesubresp             = $oDados12->codunidadesubresp ;
		  $dispensa122014->si76_exercicioprocesso             = $oDados12->exerciciolicitacao; 
		  $dispensa122014->si76_nroprocesso                   = $oDados12->nroprocessolicitatorio;
		  $dispensa122014->si76_tipoprocesso				  = $oDados12->tipoprocesso;
		  $dispensa122014->si76_nroitem						  = $oDados12->nroitem;
		  $dispensa122014->si76_coditem						  = $oDados12->coditem;
		  $dispensa122014->si76_instit		   				   = db_getsession("DB_instit");
		  $dispensa122014->si76_mes          				  = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  /*###########  verificar esses dois campos###############
		    nrolote 
		    dsclote*/
		  
		
		  $dispensa122014->incluir(null);
		  if ($dispensa122014->erro_status == 0) {
		    throw new Exception($dispensa122014->erro_msg);
		  }
		}
		
		
		$sSql=" select DISTINCT '13' as tipoRegistro,
		infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
	(select case when subunidade = 1 then codunidade ||  lpad(subunidade::varchar,3,0) else codunidade end as codunidade from (select case when si08_tratacodunidade = 1 then lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) else lpad(db01_unidade,2,0) || lpad(db01_orgao,3,0) end as codunidade,o41_subunidade as subunidade from db_departorg 
	join infocomplementares on si08_anousu = db01_anousu and si08_instit = ".db_getsession("DB_instit")."  
join orcunidade on db01_orgao=o41_orgao and db01_unidade=o41_unidade and db01_anousu = o41_anousu
	where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu")." limit 1) as x) as codUnidadeSubResp,
		liclicita.l20_anousu as exercicioLicitacao,
		liclicita.l20_edital as nroProcessoLicitatorio,
		pctipocompratribunal.l44_codigotribunal as tipoProcesso,
		dispensa112014.si75_nrolote as nroLote,
		(pcmater.pc01_codmater::varchar || (case when matunid.m61_codmatunid is null then 1 else matunid.m61_codmatunid end)::varchar) as codItem
		FROM liclicitem
		INNER JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
		INNER JOIN liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
		INNER JOIN dispensa112014 on (liclicitemlote.l04_descricao = dispensa112014.si75_dsclote and dispensa112014.si75_nroprocesso = liclicita.l20_edital::varchar)
		INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN pcprocitem  on (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
		INNER JOIN solicitem on (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
		INNER JOIN solicitempcmater on (solicitem.pc11_codigo = solicitempcmater.pc16_solicitem)
		INNER JOIN pcmater on (solicitempcmater.pc16_codmater = pcmater.pc01_codmater)
		INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
		LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
    LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
		LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
		INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
		WHERE db_config.codigo= " .db_getsession("DB_instit")." AND liclicitasituacao.l11_licsituacao = 1
		AND liclicita.l20_tipojulg = 3
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";
 
		$rsResult13 = db_query($sSql);//db_criatabela($rsResult13);
		
		for ($iCont13 = 0; $iCont13 < pg_num_rows($rsResult13); $iCont13++) {
		  	
		  $dispensa132014 = new cl_dispensa132014();
		  $oDados13       = db_utils::fieldsMemory($rsResult13, $iCont13);
		  	
		  $dispensa132014->si77_tiporegistro   				  = 13;
		  $dispensa132014->si77_reg10 						  = $dispensa102014->si74_sequencial;		
		  $dispensa132014->si77_codorgaoresp  				  =	$oDados13->codorgaoresp;
		  $dispensa132014->si77_codunidadesubresp			  = $oDados13->codunidadesubresp;
		  $dispensa132014->si77_exercicioprocesso			  = $oDados13->exerciciolicitacao;
		  $dispensa132014->si77_nroprocesso					  = $oDados13->nroprocessolicitatorio; 
		  $dispensa132014->si77_tipoprocesso				  = $oDados13->tipoprocesso;
		  $dispensa132014->si77_nrolote						  = $oDados13->nrolote ;
		  $dispensa132014->si77_coditem						  = $oDados13->coditem;
		  $dispensa132014->si77_instit		   				   = db_getsession("DB_instit");
		  $dispensa132014->si77_mes          				  = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  
		  $dispensa132014->incluir(null);
		  if ($dispensa132014->erro_status == 0) {
		    throw new Exception($dispensa132014->erro_msg);
		  }
		}
								
		
		$sSql="select DISTINCT '14' as tipoRegistro,
		infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
	(select case when subunidade = 1 then codunidade ||  lpad(subunidade::varchar,3,0) else codunidade end as codunidade from (select case when si08_tratacodunidade = 1 then lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) else lpad(db01_unidade,2,0) || lpad(db01_orgao,3,0) end as codunidade,o41_subunidade as subunidade from db_departorg 
	join infocomplementares on si08_anousu = db01_anousu and si08_instit = ".db_getsession("DB_instit")."  
join orcunidade on db01_orgao=o41_orgao and db01_unidade=o41_unidade and db01_anousu = o41_anousu
	where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu")." limit 1) as x) as codUnidadeSubResp,
		liclicita.l20_anousu as exercicioLicitacao,
		liclicita.l20_edital as nroProcessoLicitatorio,
		pctipocompratribunal.l44_codigotribunal as tipoProcesso,
		(CASE parecerlicitacao.l200_tipoparecer WHEN 2 THEN 6
			ELSE 7
		END) as tipoResp,
		cgm.z01_cgccpf as nroCPFResp		
		FROM liclicita 
		INNER JOIN parecerlicitacao on (liclicita.l20_codigo=parecerlicitacao.l200_licitacao)
		INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN cgm on (parecerlicitacao.l200_numcgm=cgm.z01_numcgm)
		INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
		LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
		INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
		WHERE db_config.codigo= " .db_getsession("DB_instit")." AND liclicitasituacao.l11_licsituacao = 1
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";
		
		$sSql .=" union select DISTINCT '14' as tipoRegistro,
		infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
	(select case when subunidade = 1 then codunidade ||  lpad(subunidade::varchar,3,0) else codunidade end as codunidade from (select case when si08_tratacodunidade = 1 then lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) else lpad(db01_unidade,2,0) || lpad(db01_orgao,3,0) end as codunidade,o41_subunidade as subunidade from db_departorg 
	join infocomplementares on si08_anousu = db01_anousu and si08_instit = ".db_getsession("DB_instit")."  
join orcunidade on db01_orgao=o41_orgao and db01_unidade=o41_unidade and db01_anousu = o41_anousu
	where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu")." limit 1) as x) as codUnidadeSubResp,
		liclicita.l20_anousu as exercicioLicitacao,
		liclicita.l20_edital as nroProcessoLicitatorio,
		pctipocompratribunal.l44_codigotribunal as tipoProcesso,
		(CASE liccomissaocgm.l31_tipo WHEN '1' THEN 1
		WHEN '2' THEN 4 WHEN '3' THEN 2 WHEN '4' THEN 3 WHEN '8' THEN 5 END) as tipoResp,
		cgm.z01_cgccpf as nroCPFResp		
		FROM liclicita 
		INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
		INNER JOIN liccomissao as liccomissao on (liclicita.l20_liccomissao=liccomissao.l30_codigo)
		INNER JOIN liccomissaocgm as liccomissaocgm on (liccomissao.l30_codigo=liccomissaocgm.l31_liccomissao)
		INNER JOIN cgm on (liccomissaocgm.l31_numcgm=cgm.z01_numcgm)  
		LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
		INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
		WHERE db_config.codigo= " .db_getsession("DB_instit")." AND liclicitasituacao.l11_licsituacao = 1
		AND liclicita.l20_codigo= {$oDados10->codlicitacao} AND liccomissaocgm.l31_tipo in('1','2','3','4','8')";
 
		
		$rsResult14 = db_query($sSql);//db_criatabela($rsResult14);echo $sSql;echo pg_last_error();
		
		for ($iCont14 = 0; $iCont14 < pg_num_rows($rsResult14); $iCont14++) {
		  	
		  $dispensa142014 = new cl_dispensa142014();
		  $oDados14       = db_utils::fieldsMemory($rsResult14, $iCont14);
		  	
		  $dispensa142014->si78_tiporegistro   				  = 14;
		  $dispensa142014->si78_reg10 						  = $dispensa102014->si74_sequencial;		
		  $dispensa142014->si78_codorgaoresp  				  =	$oDados14->codorgaoresp;
		  $dispensa142014->si78_codunidadesubres			  = $oDados14->codunidadesubresp;
		  $dispensa142014->si78_exercicioprocesso			  = $oDados14->exerciciolicitacao;
		  $dispensa142014->si78_nroprocesso					  = $oDados14->nroprocessolicitatorio; 
		  $dispensa142014->si78_tipoprocesso				  = $oDados14->tipoprocesso;
		  $dispensa142014->si78_tiporesp					  = $oDados14->tiporesp ;
		  $dispensa142014->si78_nrocpfresp					  = $oDados14->nrocpfresp;
		  $dispensa142014->si78_instit		   				   = db_getsession("DB_instit");
		  $dispensa142014->si78_mes           				  = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  
		  $dispensa142014->incluir(null);
		  if ($dispensa142014->erro_status == 0) {
		    throw new Exception($dispensa142014->erro_msg);
		  }
		}
	
		$sSql="select DISTINCT '15' as tipoRegistro,
		infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
	(select case when subunidade = 1 then codunidade ||  lpad(subunidade::varchar,3,0) else codunidade end as codunidade from (select case when si08_tratacodunidade = 1 then lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) else lpad(db01_unidade,2,0) || lpad(db01_orgao,3,0) end as codunidade,o41_subunidade as subunidade from db_departorg 
	join infocomplementares on si08_anousu = db01_anousu and si08_instit = ".db_getsession("DB_instit")."  
join orcunidade on db01_orgao=o41_orgao and db01_unidade=o41_unidade and db01_anousu = o41_anousu
	where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu")." limit 1) as x) as codUnidadeSubResp,
		liclicita.l20_anousu as exercicioLicitacao,
		liclicita.l20_edital as nroProcessoLicitatorio,
		pctipocompratribunal.l44_codigotribunal as tipoProcesso,
		dispensa112014.si75_nrolote as nroLote,
		(pcmater.pc01_codmater::varchar || (case when matunid.m61_codmatunid is null then 1 else matunid.m61_codmatunid end)::varchar) as codItem,
		itemprecoreferencia.si02_vlprecoreferencia as vlCotPrecosUnitario,
		pcorcamval.pc23_quant as quantidade
		FROM liclicitem
		INNER JOIN liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
		LEFT  JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem AND liclicita.l20_tipojulg = 3)
		LEFT  JOIN dispensa112014 on (liclicitemlote.l04_descricao = dispensa112014.si75_dsclote and dispensa112014.si75_nroprocesso = liclicita.l20_edital::varchar)
		INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN pcprocitem  on (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
		INNER JOIN solicitem on (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
		INNER JOIN solicitempcmater on (solicitem.pc11_codigo = solicitempcmater.pc16_solicitem)
		INNER JOIN pcmater on (solicitempcmater.pc16_codmater = pcmater.pc01_codmater)
		INNER JOIN pcproc on (pcprocitem.pc81_codproc=pcproc.pc80_codproc)
		INNER JOIN pcorcamitemproc on (pcprocitem.pc81_codprocitem = pcorcamitemproc.pc31_pcprocitem)
		INNER JOIN pcorcamitem on (pcorcamitemproc.pc31_orcamitem = pcorcamitem.pc22_orcamitem)
		INNER JOIN pcorcamval on (pcorcamitem.pc22_orcamitem = pcorcamval.pc23_orcamitem)
		INNER JOIN precoreferencia on (pcproc.pc80_codproc = precoreferencia.si01_processocompra)
		INNER JOIN itemprecoreferencia on (precoreferencia.si01_sequencial = itemprecoreferencia.si02_precoreferencia and pcorcamval.pc23_orcamitem = itemprecoreferencia.si02_itemproccompra)	
		INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
		LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
    LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
		LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
		INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
		WHERE db_config.codigo= " .db_getsession("DB_instit")." AND liclicitasituacao.l11_licsituacao = 1
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";
 
		
		$rsResult15 = db_query($sSql);//db_criatabela($rsResult15);
		$aDadosAgrupados15 = array();
		for ($iCont15 = 0; $iCont15 < pg_num_rows($rsResult15); $iCont15++) {
			
			$oResult15 = db_utils::fieldsMemory($rsResult15, $iCont15);
			
			$sHash15 = $oResult15->exerciciolicitacao.$oResult15->nroprocessolicitatorio.$oResult15->nrolote.$oResult15->coditem;
			
			if (!isset($aDadosAgrupados15[$sHash15])) {
				
				$oDados15 = new stdClass();
				$oDados15->si79_tiporegistro   				  = 15;
		    $oDados15->si79_reg10 						  = $dispensa102014->si74_sequencial;		
		    $oDados15->si79_codorgaoresp  				  =	$oResult15->codorgaoresp;
		    $oDados15->si79_codunidadesubresp			  = $oResult15->codunidadesubresp;
		    $oDados15->si79_exercicioprocesso			  = $oResult15->exerciciolicitacao;
		    $oDados15->si79_nroprocesso					  = $oResult15->nroprocessolicitatorio; 
		    $oDados15->si79_tipoprocesso				  = $oResult15->tipoprocesso;
		    $oDados15->si79_nrolote						  = $oResult15->nrolote;
		    $oDados15->si79_coditem						  = $oResult15->coditem;
		    $oDados15->si79_vlcotprecosunitario			  = $oResult15->vlcotprecosunitario ;
		    $oDados15->si79_quantidade					  = $oResult15->quantidade;
		    $oDados15->si79_instit		   				   = db_getsession("DB_instit");
		    $oDados15->si79_mes          				  = $this->sDataFinal['5'].$this->sDataFinal['6'];
		    $aDadosAgrupados15[$sHash15] = $oDados15;
				
			} else {
				$aDadosAgrupados15[$sHash15]->si79_quantidade += $oResult15->quantidade;
			}
			
		}
		
		foreach ($aDadosAgrupados15 as $oDadosAgrupados15) {
		  	
		  $dispensa152014 = new cl_dispensa152014();
		  	
		  $dispensa152014->si79_tiporegistro   				  = 15;
		  $dispensa152014->si79_reg10 						  = $oDadosAgrupados15->si79_reg10;		
		  $dispensa152014->si79_codorgaoresp  				  =	$oDadosAgrupados15->si79_codorgaoresp;
		  $dispensa152014->si79_codunidadesubresp			  = $oDadosAgrupados15->si79_codunidadesubresp;
		  $dispensa152014->si79_exercicioprocesso			  = $oDadosAgrupados15->si79_exercicioprocesso;
		  $dispensa152014->si79_nroprocesso					  = $oDadosAgrupados15->si79_nroprocesso; 
		  $dispensa152014->si79_tipoprocesso				  = $oDadosAgrupados15->si79_tipoprocesso;
		  $dispensa152014->si79_nrolote						  = $oDadosAgrupados15->si79_nrolote;
		  $dispensa152014->si79_coditem						  = $oDadosAgrupados15->si79_coditem;
		  $dispensa152014->si79_vlcotprecosunitario			  = $oDadosAgrupados15->si79_vlcotprecosunitario ;
		  $dispensa152014->si79_quantidade					  = $oDadosAgrupados15->si79_quantidade;
		  $dispensa152014->si79_instit		   				   =$oDadosAgrupados15->si79_instit;
		  $dispensa152014->si79_mes          				  = $oDadosAgrupados15->si79_mes;
			 
		  
		  $dispensa152014->incluir(null);
		  if ($dispensa152014->erro_status == 0) {
		    throw new Exception($dispensa152014->erro_msg);
		  }
		}

		$sSql="select DISTINCT '16' as tipoRegistro,
		infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
	(select case when subunidade = 1 then codunidade ||  lpad(subunidade::varchar,3,0) else codunidade end as codunidade from (select case when si08_tratacodunidade = 1 then lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) else lpad(db01_unidade,2,0) || lpad(db01_orgao,3,0) end as codunidade,o41_subunidade as subunidade from db_departorg 
	join infocomplementares on si08_anousu = db01_anousu and si08_instit = ".db_getsession("DB_instit")."  
join orcunidade on db01_orgao=o41_orgao and db01_unidade=o41_unidade and db01_anousu = o41_anousu
	where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu")." limit 1) as x) as codUnidadeSubResp,
		liclicita.l20_anousu as exercicioLicitacao,
		liclicita.l20_edital as nroProcessoLicitatorio,	
		pctipocompratribunal.l44_codigotribunal as tipoProcesso,
		infocomplementaresinstit.si09_codorgaotce as codorgaotce,
		orcdotacao.o58_orgao as codOrgao,
		orcdotacao.o58_unidade as codUnidadeSub,
		orcdotacao.o58_funcao as codFuncao,
		orcdotacao.o58_subfuncao as codSubFuncao,
		orcdotacao.o58_programa as codPrograma,
		orcdotacao.o58_projativ as idAcao,
		' ' as idSubAcao,
		substr(orcelemento.o56_elemento,2,6) as naturezaDespesa,
		orctiporec.o15_codtri as codFontRecursos,
		orcdotacao.o58_valor as vlRecurso			
		FROM liclicita 
		INNER JOIN liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
		INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN pcprocitem on (liclicitem.l21_codpcprocitem=pcprocitem.pc81_codprocitem)
		INNER JOIN pcdotac on (pcprocitem.pc81_solicitem=pcdotac.pc13_codigo)
		INNER JOIN orcdotacao on (pcdotac.pc13_anousu=orcdotacao.o58_anousu and pcdotac.pc13_coddot=orcdotacao.o58_coddot)
		INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
		INNER JOIN orctiporec on (orcdotacao.o58_codigo=orctiporec.o15_codigo)
		INNER JOIN orcelemento on (orcdotacao.o58_anousu=orcelemento.o56_anousu and orcdotacao.o58_codele=orcelemento.o56_codele)
		LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
		INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
		WHERE db_config.codigo= " .db_getsession("DB_instit")." AND liclicitasituacao.l11_licsituacao = 1 
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";
		
		
		$rsResult16 = db_query($sSql);//db_criatabela($rsResult16);echo $sSql;
		
		for ($iCont16 = 0; $iCont16 < pg_num_rows($rsResult16); $iCont16++) {
		  	
		  $dispensa162014 = new cl_dispensa162014();
		  $oDados16       = db_utils::fieldsMemory($rsResult16, $iCont16);
		  	
		  $dispensa162014->si80_tiporegistro   		= 16;
		  $dispensa162014->si80_reg10 						= $dispensa102014->si74_sequencial;		
		  $dispensa162014->si80_codorgaoresp  		=	$oDados16->codorgaoresp;
		  $dispensa162014->si80_codunidadesubresp	= $oDados16->codunidadesubresp;
		  $dispensa162014->si80_exercicioprocesso	= $oDados16->exerciciolicitacao;
		  $dispensa162014->si80_nroprocesso				= $oDados16->nroprocessolicitatorio; 
		  $dispensa162014->si80_tipoprocesso			= $oDados16->tipoprocesso;
		  $dispensa162014->si80_codorgao					= $oDados16->codorgaotce;
		  $dispensa162014->si80_codunidadesub			= str_pad($oDados16->codorgao, 2,"0", STR_PAD_LEFT).str_pad($oDados16->codunidadesub, 3,"0", STR_PAD_LEFT);
		  $dispensa162014->si80_codfuncao 			  = $oDados16->codfuncao;
		  $dispensa162014->si80_codsubfuncao 			= $oDados16->codsubfuncao;
		  $dispensa162014->si80_codprograma 			= $oDados16->codprograma;
		  $dispensa162014->si80_idacao 			      = $oDados16->idacao;
		  $dispensa162014->si80_idsubacao 			  = $oDados16->idsubacao;
		  $dispensa162014->si80_naturezadespesa   = $oDados16->naturezadespesa;
		  $dispensa162014->si80_codfontrecursos   = $oDados16->codfontrecursos;
		  $dispensa162014->si80_vlrecurso					= $oDados16->vlrecurso;
		  $dispensa162014->si80_instit		   			= db_getsession("DB_instit");
		  $dispensa162014->si80_mes          			= $this->sDataFinal['5'].$this->sDataFinal['6'];
			 
		  
		  $dispensa162014->incluir(null);
		  if ($dispensa162014->erro_status == 0) {
		    throw new Exception($dispensa162014->erro_msg);
		  }
		}
	 
		  
		  
	$sSql="select DISTINCT '17' as tipoRegistro,
	infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
	(select case when subunidade = 1 then codunidade ||  lpad(subunidade::varchar,3,0) else codunidade end as codunidade from (select case when si08_tratacodunidade = 1 then lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) else lpad(db01_unidade,2,0) || lpad(db01_orgao,3,0) end as codunidade,o41_subunidade as subunidade from db_departorg 
	join infocomplementares on si08_anousu = db01_anousu and si08_instit = ".db_getsession("DB_instit")."  
join orcunidade on db01_orgao=o41_orgao and db01_unidade=o41_unidade and db01_anousu = o41_anousu
	where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu")." limit 1) as x) as codUnidadeSubResp,
	liclicita.l20_anousu as exercicioLicitacao,
	liclicita.l20_edital as nroProcessoLicitatorio,	
	pctipocompratribunal.l44_codigotribunal as tipoProcesso,
	(CASE length(cgm.z01_cgccpf) WHEN 11 THEN 1
		ELSE 2
	END) as tipoDocumento,
	cgm.z01_cgccpf as nroDocumento,
	pcforne.pc60_inscriestadual as nroInscricaoEstadual,
	pcforne.pc60_uf as ufInscricaoEstadual,
	habilitacaoforn.l206_numcertidaoinss as nroCertidaoRegularidadeINSS,
	habilitacaoforn.l206_dataemissaoinss as dataEmissaoCertidaoRegularidadeINSS,
	habilitacaoforn.l206_datavalidadeinss as dataValidadeCertidaoRegularidadeINSS,
	habilitacaoforn.l206_numcertidaofgts as nroCertidaoRegularidadeFGTS,
	habilitacaoforn.l206_dataemissaofgts as dataEmissaoCertidaoRegularidadeFGTS,
	habilitacaoforn.l206_datavalidadefgts as dataValidadeCertidaoRegularidadeFGTS,
	habilitacaoforn.l206_numcertidaocndt as nroCNDT,
	habilitacaoforn.l206_dataemissaocndt as dtEmissaoCNDT,
	habilitacaoforn.l206_datavalidadecndt as dtValidadeCNDT,
	dispensa112014.si75_nrolote as nroLote,
	(solicitempcmater.pc16_codmater::varchar || (case when matunid.m61_codmatunid is null then 1 else matunid.m61_codmatunid end)::varchar) as codItem,
	pcorcamval.pc23_vlrun as vlUnitario,
	pcorcamval.pc23_quant as quantidade 	
	FROM liclicita 
	INNER JOIN habilitacaoforn on (liclicita.l20_codigo=habilitacaoforn.l206_licitacao)
	INNER JOIN pcforne on (habilitacaoforn.l206_fornecedor=pcforne.pc60_numcgm)
	INNER JOIN cgm on (pcforne.pc60_numcgm=cgm.z01_numcgm)
	INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
	INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
	INNER JOIN liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
	INNER JOIN pcorcamitemlic ON (liclicitem.l21_codigo = pcorcamitemlic.pc26_liclicitem )      
	INNER JOIN pcorcamitem ON (pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem)      
	INNER JOIN pcorcamjulg ON (pcorcamitem.pc22_orcamitem = pcorcamjulg.pc24_orcamitem )
	INNER JOIN pcorcamforne ON (pcorcamjulg.pc24_orcamforne = pcorcamforne.pc21_orcamforne)
	INNER JOIN pcprocitem  ON (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
	INNER JOIN solicitem ON (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
	INNER JOIN solicitempcmater ON (solicitem.pc11_codigo=solicitempcmater.pc16_solicitem)    
	INNER JOIN pcorcamval ON (pcorcamitem.pc22_orcamitem = pcorcamval.pc23_orcamitem and pcorcamforne.pc21_orcamforne=pcorcamval.pc23_orcamforne)
	LEFT  JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem AND liclicita.l20_tipojulg = 3)
	LEFT  JOIN dispensa112014 on (liclicitemlote.l04_descricao = dispensa112014.si75_dsclote and dispensa112014.si75_nroprocesso = liclicita.l20_edital::varchar)
	INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
	LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
  LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
	LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
	INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
	WHERE db_config.codigo= " .db_getsession("DB_instit")." AND liclicitasituacao.l11_licsituacao = 1  
	AND liclicita.l20_codigo= {$oDados10->codlicitacao}";
		
	
		$rsResult17 = db_query($sSql);//db_criatabela($rsResult17);
		$aDadosAgrupados17 = array();
		for ($iCont17 = 0; $iCont17 < pg_num_rows($rsResult17); $iCont17++) {
			
			$oResult17 = db_utils::fieldsMemory($rsResult17, $iCont17);
			$sHash17 =  $oResult17->exerciciolicitacao.$oResult17->nroprocessolicitatorio.$oResult17->nrolote.$oResult17->coditem;
			if (!isset($aDadosAgrupados17[$sHash17])) {
				
				$oDados17 = new stdClass;
				
				$oDados17->si81_tiporegistro				 					 	= 17;
 		  	$oDados17->si81_codorgaoresp									 	=	$oResult17->codorgaoresp;                        
			  $oDados17->si81_codunidadesubresp									=	$oResult17->codunidadesubresp;                     
			  $oDados17->si81_exercicioprocesso									=	$oResult17->exerciciolicitacao;                  
			  $oDados17->si81_nroprocesso										=	$oResult17->nroprocessolicitatorio;               
			  $oDados17->si81_tipoprocesso										=	$oResult17->tipoprocesso;              
			  $oDados17->si81_tipodocumento										=	$oResult17->tipodocumento;             
			  $oDados17->si81_nrodocumento										=	$oResult17->nrodocumento;                         
			  $oDados17->si81_nroinscricaoestadual								=	$oResult17->nroinscricaoestadual;                  
			  $oDados17->si81_ufinscricaoestadual								 =	$oResult17->ufinscricaoestadual;                  
			  $oDados17->si81_nrocertidaoregularidadeinss						=	$oResult17->nrocertidaoregularidadeinss;          
			  $oDados17->si81_dtemissaocertidaoregularidadeinss					=	$oResult17->dataemissaocertidaoregularidadeinss;  
			  $oDados17->si81_dtvalidadecertidaoregularidadeinss				=	$oResult17->datavalidadecertidaoregularidadeinss; 
			  $oDados17->si81_nrocertidaoregularidadefgts						=	$oResult17->nrocertidaoregularidadefgts;          
			  $oDados17->si81_dtemissaocertidaoregularidadefgts					=	$oResult17->dataemissaocertidaoregularidadefgts;  
			  $oDados17->si81_dtvalidadecertidaoregularidadefgts				=	$oResult17->datavalidadecertidaoregularidadefgts; 
			  $oDados17->si81_nrocndt											=	$oResult17->tipodocumento == 1 ? ' ' : $oResult17->nrocndt;                              
			  $oDados17->si81_dtemissaocndt										=	$oResult17->tipodocumento == 1 ? '' :  $oResult17->dtemissaocndt;                        
			  $oDados17->si81_dtvalidadecndt									=	$oResult17->tipodocumento == 1 ? '' :  $oResult17->dtvalidadecndt;                       
			  $oDados17->si81_nrolote											=	$oResult17->nrolote;                              
			  $oDados17->si81_coditem											=	$oResult17->coditem;                              
			  $oDados17->si81_vlitem											=	$oResult17->vlunitario;                           
			  $oDados17->si81_quantidade										=	$oResult17->quantidade;
			  $oDados17->si81_instit		   				   = db_getsession("DB_instit");                           
		  	$oDados17->si81_mes          				 						= $this->sDataFinal['5'].$this->sDataFinal['6'];
		  	$oDados17->si81_reg10                 = $dispensa102014->si74_sequencial;
		  	
		  	$aDadosAgrupados17[$sHash17] = $oDados17;
				
			} else {
				$aDadosAgrupados17[$sHash17]->si81_quantidade += $oResult17->quantidade;
			}
			
		}
		
		foreach ($aDadosAgrupados17 as $oDadosAgrupados17) {
		  	
		  $dispensa172014 = new cl_dispensa172014();
		  	
		  $dispensa172014->si81_tiporegistro				 					 	= 17;
 		  $dispensa172014->si81_codorgaoresp									 	=	$oDadosAgrupados17->si81_codorgaoresp;                        
			$dispensa172014->si81_codunidadesubresp									=	$oDadosAgrupados17->si81_codunidadesubresp;                     
			$dispensa172014->si81_exercicioprocesso									=	$oDadosAgrupados17->si81_exercicioprocesso;                  
			$dispensa172014->si81_nroprocesso										=	$oDadosAgrupados17->si81_nroprocesso;               
			$dispensa172014->si81_tipoprocesso										=	$oDadosAgrupados17->si81_tipoprocesso;              
			$dispensa172014->si81_tipodocumento										=	$oDadosAgrupados17->si81_tipodocumento;             
			$dispensa172014->si81_nrodocumento										=	$oDadosAgrupados17->si81_nrodocumento;                         
			$dispensa172014->si81_nroinscricaoestadual								=	$oDadosAgrupados17->si81_nroinscricaoestadual;                  
			$dispensa172014->si81_ufinscricaoestadual								=	$oDadosAgrupados17->si81_ufinscricaoestadual;                  
			$dispensa172014->si81_nrocertidaoregularidadeinss						=	$oDadosAgrupados17->si81_nrocertidaoregularidadeinss;          
			$dispensa172014->si81_dtemissaocertidaoregularidadeinss					=	$oDadosAgrupados17->si81_dtemissaocertidaoregularidadeinss;  
			$dispensa172014->si81_dtvalidadecertidaoregularidadeinss				=	$oDadosAgrupados17->si81_dtvalidadecertidaoregularidadeinss; 
			$dispensa172014->si81_nrocertidaoregularidadefgts						=	$oDadosAgrupados17->si81_nrocertidaoregularidadefgts;          
			$dispensa172014->si81_dtemissaocertidaoregularidadefgts					=	$oDadosAgrupados17->si81_dtemissaocertidaoregularidadefgts;  
			$dispensa172014->si81_dtvalidadecertidaoregularidadefgts				=	$oDadosAgrupados17->si81_dtvalidadecertidaoregularidadefgts; 
			$dispensa172014->si81_nrocndt											=	$oDadosAgrupados17->si81_nrocndt;                              
			$dispensa172014->si81_dtemissaocndt										=	$oDadosAgrupados17->si81_dtemissaocndt;                        
			$dispensa172014->si81_dtvalidadecndt									=	$oDadosAgrupados17->si81_dtvalidadecndt;                       
			$dispensa172014->si81_nrolote											=	$oDadosAgrupados17->si81_nrolote;                              
			$dispensa172014->si81_coditem											=	$oDadosAgrupados17->si81_coditem;                              
			$dispensa172014->si81_vlitem											=	$oDadosAgrupados17->si81_vlitem;                           
			$dispensa172014->si81_quantidade										=	$oDadosAgrupados17->si81_quantidade;
			$dispensa172014->si81_instit		   				   = $oDadosAgrupados17->si81_instit;                           
		  $dispensa172014->si81_mes          				 						= $oDadosAgrupados17->si81_mes;
		  $dispensa172014->si81_reg10                 = $oDadosAgrupados17->si81_reg10;
			 
		  
		  $dispensa172014->incluir(null);
		  if ($dispensa172014->erro_status == 0) {
		    throw new Exception($dispensa172014->erro_msg);
		  }  
		  
		} 
    
    $sSql="select DISTINCT '18' as tipoRegistro,
	infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
	(select case when subunidade = 1 then codunidade ||  lpad(subunidade::varchar,3,0) else codunidade end as codunidade from (select case when si08_tratacodunidade = 1 then lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) else lpad(db01_unidade,2,0) || lpad(db01_orgao,3,0) end as codunidade,o41_subunidade as subunidade from db_departorg 
	join infocomplementares on si08_anousu = db01_anousu and si08_instit = ".db_getsession("DB_instit")."  
join orcunidade on db01_orgao=o41_orgao and db01_unidade=o41_unidade and db01_anousu = o41_anousu
	where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu")." limit 1) as x) as codUnidadeSubResp,
	liclicita.l20_anousu as exercicioLicitacao,
	liclicita.l20_edital as nroProcessoLicitatorio,	
	pctipocompratribunal.l44_codigotribunal as tipoProcesso,
	(CASE length(cgm.z01_cgccpf) WHEN 11 THEN 1
		ELSE 2
	END) as tipoDocumento,
	cgm.z01_cgccpf as nroDocumento,
	credenciamento.l205_datacred as dataCredenciamento,
	dispensa112014.si75_nrolote as nroLote,
	solicitem.pc11_codigo as codItem,	
	(solicitempcmater.pc16_codmater::varchar || (case when matunid.m61_codmatunid is null then 1 else matunid.m61_codmatunid end)::varchar) as codItem,
	pcforne.pc60_inscriestadual as nroInscricaoEstadual,
	pcforne.pc60_uf as ufInscricaoEstadual,
	habilitacaoforn.l206_numcertidaoinss as nroCertidaoRegularidadeINSS,
	habilitacaoforn.l206_dataemissaoinss as dataEmissaoCertidaoRegularidadeINSS,
	habilitacaoforn.l206_datavalidadeinss as dataValidadeCertidaoRegularidadeINSS,
	habilitacaoforn.l206_numcertidaofgts as nroCertidaoRegularidadeFGTS,
	habilitacaoforn.l206_dataemissaofgts as dataEmissaoCertidaoRegularidadeFGTS,
	habilitacaoforn.l206_datavalidadefgts as dataValidadeCertidaoRegularidadeFGTS,
	habilitacaoforn.l206_numcertidaocndt as nroCNDT,
	habilitacaoforn.l206_dataemissaocndt as dtEmissaoCNDT,
	habilitacaoforn.l206_datavalidadecndt as dtValidadeCNDT 			
	FROM liclicita 
	INNER JOIN habilitacaoforn on (liclicita.l20_codigo=habilitacaoforn.l206_licitacao)
	INNER JOIN credenciamento on (liclicita.l20_codigo=credenciamento.l205_licitacao)
	INNER JOIN pcforne on (habilitacaoforn.l206_fornecedor=pcforne.pc60_numcgm)
	INNER JOIN cgm on (pcforne.pc60_numcgm=cgm.z01_numcgm)
	INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
	INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
	INNER JOIN liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
	INNER JOIN pcorcamitemlic ON (liclicitem.l21_codigo = pcorcamitemlic.pc26_liclicitem )      
	INNER JOIN pcorcamitem ON (pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem)      
	INNER JOIN pcprocitem  ON (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
	INNER JOIN solicitem ON (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
	INNER JOIN solicitempcmater ON (solicitem.pc11_codigo=solicitempcmater.pc16_solicitem)
	INNER JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
	LEFT JOIN dispensa112014 on (liclicitemlote.l04_descricao = dispensa112014.si75_dsclote and dispensa112014.si75_nroprocesso = liclicita.l20_edital::varchar)
	INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
	LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
  LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid    
	LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
	INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
	WHERE db_config.codigo= " .db_getsession("DB_instit")." AND liclicitasituacao.l11_licsituacao = 1
	AND liclicita.l20_codigo= {$oDados10->codlicitacao}";
		
		
		$rsResult18 = db_query($sSql);//db_criatabela($rsResult18);
		
		for ($iCont18 = 0; $iCont18 < pg_num_rows($rsResult18); $iCont18++) {
		  	
		  $dispensa182014 = new cl_dispensa182014();
		  $oDados18       = db_utils::fieldsMemory($rsResult18, $iCont18);
		  	
		  	$dispensa182014->si82_tiporegistro				  					= 	18;
 		  	$dispensa182014->si82_codorgaoresp				 					=	$oDados18->codorgaoresp;
			$dispensa182014->si82_codunidadesubresp 							=	$oDados18->codunidadesubresp;
			$dispensa182014->si82_exercicioprocesso								=	$oDados18->exerciciolicitacao;
			$dispensa182014->si82_nroprocesso									=	$oDados18->nroprocessolicitatorio;
			$dispensa182014->si82_tipoprocesso									=	$oDados18->tipoprocesso;
			$dispensa182014->si82_tipodocumento									=	$oDados18->tipodocumento;
			$dispensa182014->si82_nrodocumento									=	$oDados18->nrodocumento;
			$dispensa182014->si82_datacredenciamento							=	$oDados18->datacredenciamento;
			$dispensa182014->si82_nrolote										=	$oDados18->nrolote;
			$dispensa182014->si82_coditem										=	$oDados18->coditem;
			$dispensa182014->si82_nroinscricaoestadual							=	$oDados18->nroinscricaoestadual;
			$dispensa182014->si82_ufinscricaoestadual							=	$oDados18->ufinscricaoestadual;
			$dispensa182014->si82_nrocertidaoregularidadeinss					=	$oDados18->nrocertidaoregularidadeinss;
			$dispensa182014->si82_dataemissaocertidaoregularidadeinss			=	$oDados18->dataemissaocertidaoregularidadeinss;
			$dispensa182014->si82_dtvalidadecertidaoregularidadeinssd			=	$oDados18->datavalidadecertidaoregularidadeinss;
			$dispensa182014->si82_nrocertidaoregularidadefgts					=	$oDados18->nrocertidaoregularidadefgts;
			$dispensa182014->si82_dtemissaocertidaoregularidadefgts				=	$oDados18->dataemissaocertidaoregularidadefgts;
			$dispensa182014->si82_nrocndt										=	$oDados18->nrocndt;
			$dispensa182014->si82_dtemissaocndt									=	$oDados18->dtemissaocndt;
			$dispensa182014->si82_dtvalidadecndt								=	$oDados18->dtvalidadecndt;
			$dispensa182014->si82_instit		   				   = db_getsession("DB_instit");
			$dispensa182014->si82_mes          				  					=   $this->sDataFinal['5'].$this->sDataFinal['6'];
			$dispensa182014->si82_reg10                     = $dispensa102014->si74_sequencial; 
		  
		  $dispensa182014->incluir(null);
		  if ($dispensa182014->erro_status == 0) {
		    throw new Exception($dispensa182014->erro_msg);
		  }
		}
    
	 }
		
    
    db_fim_transacao();
    
    $oGerarDISPENSA = new GerarDISPENSA();
    $oGerarDISPENSA->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarDISPENSA->gerarDados();
    
  }
}
     

 