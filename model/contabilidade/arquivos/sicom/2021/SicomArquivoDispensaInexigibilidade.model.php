<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_dispensa102021_classe.php");
require_once ("classes/db_dispensa112021_classe.php");
require_once ("classes/db_dispensa122021_classe.php");
require_once ("classes/db_dispensa132021_classe.php");
require_once ("classes/db_dispensa142021_classe.php");
require_once ("classes/db_dispensa152021_classe.php");
require_once ("classes/db_dispensa162021_classe.php");
require_once ("classes/db_dispensa172021_classe.php");
require_once ("classes/db_dispensa182021_classe.php");


require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarDISPENSA.model.php");


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
  	$dispensa102021 = new cl_dispensa102021();
  	$dispensa112021 = new cl_dispensa112021();
  	$dispensa122021 = new cl_dispensa122021();
  	$dispensa132021 = new cl_dispensa132021();
  	$dispensa142021 = new cl_dispensa142021();
  	$dispensa152021 = new cl_dispensa152021();
  	$dispensa162021 = new cl_dispensa162021();
  	$dispensa172021 = new cl_dispensa172021();
  	$dispensa182021 = new cl_dispensa182021();
    
    /**
     * excluir informacoes do mes selecioado
     */
    db_inicio_transacao();
    
  
    $result = db_query($dispensa112021->sql_query(NULL,"*",NULL,"si75_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si75_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa112021->excluir(NULL,"si75_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si75_instit=".db_getsession("DB_instit"));
      if ($dispensa112021->erro_status == 0) {
    	  throw new Exception($dispensa112021->erro_msg);
      }
    }
    
  
    $result = db_query($dispensa122021->sql_query(NULL,"*",NULL,"si76_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si76_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa122021->excluir(NULL,"si76_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si76_instit=".db_getsession("DB_instit"));
      if ($dispensa122021->erro_status == 0) {
    	  throw new Exception($dispensa122021->erro_msg);
      }
    }
    
  
    $result = db_query($dispensa132021->sql_query(NULL,"*",NULL,"si77_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si77_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa132021->excluir(NULL,"si77_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si77_instit=".db_getsession("DB_instit"));
      if ($dispensa132021->erro_status == 0) {
    	  throw new Exception($dispensa132021->erro_msg);
      }
    }
    
  
    $result = db_query($dispensa142021->sql_query(NULL,"*",NULL,"si78_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si78_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa142021->excluir(NULL,"si78_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si78_instit=".db_getsession("DB_instit"));
      if ($dispensa142021->erro_status == 0) {
    	  throw new Exception($dispensa142021->erro_msg);
      }
    }
    
    
  
    $result = db_query($dispensa152021->sql_query(NULL,"*",NULL,"si79_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si79_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa152021->excluir(NULL,"si79_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si79_instit=".db_getsession("DB_instit"));
      if ($dispensa152021->erro_status == 0) {
    	  throw new Exception($dispensa152021->erro_msg);
      }
    }
    
  
    $result = db_query($dispensa162021->sql_query(NULL,"*",NULL,"si80_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si80_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa162021->excluir(NULL,"si80_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si80_instit=".db_getsession("DB_instit"));
      if ($dispensa162021->erro_status == 0) {
    	  throw new Exception($dispensa162021->erro_msg);
      }
    }
    
    $result = db_query($dispensa172021->sql_query(NULL,"*",NULL,"si81_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si81_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa172021->excluir(NULL,"si81_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si81_instit=".db_getsession("DB_instit"));
      if ($dispensa172021->erro_status == 0) {
    	  throw new Exception($dispensa172021->erro_msg);
      }
    }
    
  	$result = db_query($dispensa182021->sql_query(NULL,"*",NULL,"si82_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si82_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa182021->excluir(NULL,"si82_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si82_instit=".db_getsession("DB_instit"));
      if ($dispensa182021->erro_status == 0) {
    	  throw new Exception($dispensa182021->erro_msg);
      }
    }
    
    
  $result = db_query($dispensa102021->sql_query(NULL,"*",NULL,"si74_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si74_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$dispensa102021->excluir(NULL,"si74_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si74_instit=".db_getsession("DB_instit"));
      if ($dispensa102021->erro_status == 0) {
    	  throw new Exception($dispensa102021->erro_msg);
      }
    }
    
  	
	$sSql = "SELECT   '10' as tipoRegistro,
	db_config.db21_tipoinstit as codOrgaoResp,
	(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
	liclicita.l20_anousu as exercicioLicitacao,
	liclicita.l20_numero as nroProcessoLicitatorio,
	pctipocompratribunal.l44_codigotribunal as tipoProcesso,
	liclicita.l20_dataaber as dtAbertura,
	liclicita.l20_naturezaobjeto as naturezaObjeto,
	liclicita.l20_objeto as objeto,
	liclicita.l20_justificativa as justificativa,
	liclicita.l20_razao as razao,
	liclicita.l20_dtpublic as dtPublicacaoTermoRatificacao,
	l20_codigo as codlicitacao,
	liclicita.l20_nomeveiculo1 as veiculoPublicacao,
	(CASE liclicita.l20_tipojulg WHEN 3 THEN 1		
		ELSE 2
	END) as processoPorLote
	FROM liclicita as liclicita 
	INNER JOIN homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
	INNER JOIN cflicita as cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
	INNER JOIN liccomissao as liccomissao on (liclicita.l20_liccomissao = liccomissao.l30_codigo)
	INNER JOIN liccomissaocgm as liccomissaocgm on (liccomissao.l30_codigo = liccomissaocgm.l31_liccomissao )
	INNER JOIN protocolo.cgm as cgm on (liccomissaocgm.l31_numcgm=cgm.z01_numcgm)
	INNER JOIN pctipocompratribunal as pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
	INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
	WHERE db_config.codigo= " .db_getsession("DB_instit")."
	AND pctipocompratribunal.l44_sequencial in (100,101,102)
	AND DATE_PART('YEAR',homologacaoadjudica.l202_datahomologacao)=".db_getsession("DB_anousu")."
	AND DATE_PART('MONTH',homologacaoadjudica.l202_datahomologacao)=".$this->sDataFinal['5'].$this->sDataFinal['6'];
		
		$rsResult10 = db_query($sSql);
		
		for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
		  	
		  $dispensa102021 = new cl_dispensa102021();
		  $oDados10       = db_utils::fieldsMemory($rsResult10, $iCont10);
		  	
		  $dispensa102021->si74_tiporegistro   				  = 10;
		  $dispensa102021->si74_codorgaoresp         		  = $oDados10->codorgaoresp;
		  $dispensa102021->si74_codunidadesubresp      		  = $oDados10->codorgaoresp;
		  $dispensa102021->si74_exercicioprocesso			  = $oDados10->exerciciolicitacao;
		  $dispensa102021->si74_nroprocesso    				  = $oDados10->nroprocessolicitatorio;
		  $dispensa102021->si74_tipoprocesso    			  = $oDados10->tipoprocesso;
		  $dispensa102021->si74_dtabertura    				  = $oDados10->dtabertura  ;
		  $dispensa102021->si74_naturezaobjeto    			  = $oDados10->naturezaobjeto;
		  $dispensa102021->si74_objeto    					  = $oDados10->objeto ;
		  $dispensa102021->si74_justificativa    			  = $oDados10->justificativa ;
		  $dispensa102021->si74_razao    					  = $oDados10->razao ;
		  $dispensa102021->si74_dtpublicacaotermoratificacao  = $oDados10->dtpublicacaotermoratificacao;
		  $dispensa102021->si74_veiculopublicacao    		  = $oDados10->veiculopublicacao ;
		  $dispensa102021->si74_processoporlote    			  = $oDados10->processoporlote ;
		  $dispensa102021->si74_instit		   				   = db_getsession("DB_instit");
		  $dispensa102021->si74_mes          				  = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  	
		  $dispensa102021->incluir(null);
		  if ($dispensa102021->erro_status == 0) {
		    throw new Exception($dispensa102021->erro_msg);
		  }
		  
			
		  
		  			
		$sSql="SELECT   '11' as tipoRegistro,
		db_config.db21_tipoinstit as codOrgaoResp,
		(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
		liclicita.l20_anousu as exercicioLicitacao,
		liclicita.l20_numero as nroProcessoLicitatorio,
		pctipocompratribunal.l44_codigotribunal as tipoProcesso,
		liclicitemlote.l04_codigo as nroLote,
		liclicitemlote.l04_descricao as dscLote
		FROM liclicita as liclicita 
		INNER JOIN homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
		INNER JOIN liclicitem as liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
		INNER JOIN cflicita as cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal as pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
		INNER JOIN liclicitemlote as liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
		WHERE db_config.codigo= " .db_getsession("DB_instit")."
		AND liclicita.l20_codigo={$oDados10->codlicitacao}";
			
		$rsResult11 = db_query($sSql);
		
		for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {
		  	
		  $dispensa112021 = new cl_dispensa112021();
		  $oDados11       = db_utils::fieldsMemory($rsResult11, $iCont11);
		  	
		  $dispensa112021->si75_tiporegistro   				  = 11;
		  $dispensa112021->si75_reg10    					  = $dispensa102021->si74_sequencial;
		  $dispensa112021->si75_codorgaoresp         		  = $oDados11->codorgaoresp ;
		  $dispensa112021->si75_codunidadesubresp     		  = $oDados11->codunidadesubresp;
		  $dispensa112021->si75_exercicioprocesso			  = $oDados11->exerciciolicitacao;
		  $dispensa112021->si75_nroprocesso    				  = $oDados11->nroprocessolicitatorio;
		  $dispensa112021->si75_tipoprocesso    			  = $oDados11->tipoprocesso;
		  $dispensa112021->si75_nrolote  				  	  = $oDados11->nrolote  ;
		  $dispensa112021->si75_dsclote    			  		  = $oDados11->dsclote;
		  $dispensa112021->si75_instit		   				   = db_getsession("DB_instit");
		  $dispensa112021->si75_mes          				  = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  	
		  $dispensa112021->incluir(null);
		  if ($dispensa112021->erro_status == 0) {
		    throw new Exception($dispensa112021->erro_msg);
		  }
		}
		
		$sSql="select '12' as tipoRegistro,
		db_config.db21_tipoinstit as codOrgaoResp,
		(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
		liclicita.l20_anousu as exercicioLicitacao,
		liclicita.l20_numero as nroProcessoLicitatorio,
		pctipocompratribunal.l44_codigotribunal as tipoProcesso,
		pcmater.pc01_codmater as codItem,
		liclicitem.l21_ordem as nroItem	
		FROM liclicitem as liclicitem
		INNER JOIN liclicita as liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
		INNER JOIN homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
		INNER JOIN cflicita as cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal as pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN compras.pcprocitem as pcprocitem  on (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
		INNER JOIN compras.solicitem as solicitem on (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
		INNER JOIN compras.solicitempcmater as solicitempcmater on (solicitem.pc11_codigo = solicitempcmater.pc16_solicitem)
		INNER JOIN compras.pcmater as pcmater on (solicitempcmater.pc16_codmater = pcmater.pc01_codmater)
		INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
		WHERE db_config.codigo= " .db_getsession("DB_instit")."
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";
		
		$rsResult12 = db_query($sSql);
		
		for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {
		  	
		  $dispensa122021 = new cl_dispensa122021();
		  $oDados12       = db_utils::fieldsMemory($rsResult12, $iCont12);
		  	
		  $dispensa122021->si76_tiporegistro   				  = 12;
		  $dispensa122021->si76_reg10 						  = $dispensa102021->si74_sequencial;		
		  $dispensa122021->si76_codorgaoresp  				  =	$oDados12->codorgaoresp;
		  $dispensa122021->si76_codunidadesubresp             = $oDados12->codunidadesubresp ;
		  $dispensa122021->si76_exercicioprocesso             = $oDados12->exerciciolicitacao; 
		  $dispensa122021->si76_nroprocesso                   = $oDados12->nroprocessolicitatorio;
		  $dispensa122021->si76_tipoprocesso				  = $oDados12->tipoprocesso;
		  $dispensa122021->si76_nroitem						  = $oDados12->nrolote;
		  $dispensa122021->si76_instit		   				   = db_getsession("DB_instit");
		  $dispensa122021->si76_mes          				  = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  /*###########  verificar esses dois campos###############
		    nrolote 
		    dsclote*/
		  
		
		  $dispensa122021->incluir(null);
		  if ($dispensa122021->erro_status == 0) {
		    throw new Exception($dispensa122021->erro_msg);
		  }
		}
		
		
		$sSql=" select '13' as tipoRegistro,
		db_config.db21_tipoinstit as codOrgaoResp,
		(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
		liclicita.l20_anousu as exercicioLicitacao,
		liclicita.l20_numero as nroProcessoLicitatorio,
		pctipocompratribunal.l44_codigotribunal as tipoProcesso,
		liclicitemlote.l04_codigo as nroLote,
		pcmater.pc01_codmater as codItem
		FROM liclicitem as liclicitem
		INNER JOIN liclicitemlote as liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
		INNER JOIN liclicita as liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
		INNER JOIN homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
		INNER JOIN cflicita as cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal as pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN compras.pcprocitem as pcprocitem  on (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
		INNER JOIN compras.solicitem as solicitem on (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
		INNER JOIN compras.solicitempcmater as solicitempcmater on (solicitem.pc11_codigo = solicitempcmater.pc16_solicitem)
		INNER JOIN compras.pcmater as pcmater on (solicitempcmater.pc16_codmater = pcmater.pc01_codmater)
		INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
		WHERE db_config.codigo= " .db_getsession("DB_instit")."
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";
 
		$rsResult13 = db_query($sSql);
		
		for ($iCont13 = 0; $iCont13 < pg_num_rows($rsResult13); $iCont13++) {
		  	
		  $dispensa132021 = new cl_dispensa132021();
		  $oDados13       = db_utils::fieldsMemory($rsResult13, $iCont13);
		  	
		  $dispensa132021->si77_tiporegistro   				  = 13;
		  $dispensa132021->si77_reg10 						  = $dispensa102021->si74_sequencial;		
		  $dispensa132021->si77_codorgaoresp  				  =	$oDados13->codorgaoresp;
		  $dispensa132021->si77_codunidadesubresp			  = $oDados13->codunidadesubresp;
		  $dispensa132021->si77_exercicioprocesso			  = $oDados13->exerciciolicitacao;
		  $dispensa132021->si77_nroprocesso					  = $oDados13->nroprocessolicitatorio; 
		  $dispensa132021->si77_tipoprocesso				  = $oDados13->tipoprocesso;
		  $dispensa132021->si77_nrolote						  = $oDados13->nrolote ;
		  $dispensa132021->si77_coditem						  = $oDados13->coditem;
		  $dispensa132021->si77_instit		   				   = db_getsession("DB_instit");
		  $dispensa132021->si77_mes          				  = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  
		  $dispensa132021->incluir(null);
		  if ($dispensa132021->erro_status == 0) {
		    throw new Exception($dispensa132021->erro_msg);
		  }
		}
								
		
		$sSql="select '14' as tipoRegistro,
		db_config.db21_tipoinstit as codOrgaoResp,
		(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
		liclicita.l20_anousu as exercicioLicitacao,
		liclicita.l20_numero as nroProcessoLicitatorio,
		pctipocompratribunal.l44_codigotribunal as tipoProcesso,
		(CASE parecerlicitacao.l200_tipoparecer WHEN 2 THEN 6
			ELSE 7
		END) as tipoResp,
		cgm.z01_cgccpf as nroCPFResp		
		FROM liclicita as liclicita 
		INNER JOIN homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
		INNER JOIN parecerlicitacao as parecerlicitacao on (liclicita.l20_codigo=parecerlicitacao.l200_licitacao)
		INNER JOIN cflicita as cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal as pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN protocolo.cgm as cgm on (parecerlicitacao.l200_numcgm=cgm.z01_numcgm)
		INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
		WHERE db_config.codigo= " .db_getsession("DB_instit")."
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";
 
		
		$rsResult14 = db_query($sSql);
		
		for ($iCont14 = 0; $iCont14 < pg_num_rows($rsResult14); $iCont14++) {
		  	
		  $dispensa142021 = new cl_dispensa142021();
		  $oDados14       = db_utils::fieldsMemory($rsResult14, $iCont14);
		  	
		  $dispensa142021->si78_tiporegistro   				  = 14;
		  $dispensa142021->si78_reg10 						  = $dispensa102021->si74_sequencial;		
		  $dispensa142021->si78_codorgaoresp  				  =	$oDados14->codorgaoresp;
		  $dispensa142021->si78_codunidadesubres			  = $oDados14->codunidadesubresp;
		  $dispensa142021->si78_exercicioprocesso			  = $oDados14->exerciciolicitacao;
		  $dispensa142021->si78_nroprocesso					  = $oDados14->nroprocessolicitatorio; 
		  $dispensa142021->si78_tipoprocesso				  = $oDados14->tipoprocesso;
		  $dispensa142021->si78_tiporesp					  = $oDados14->tiporesp ;
		  $dispensa142021->si78_nrocpfresp					  = $oDados14->nrocpfresp;
		  $dispensa142021->si78_instit		   				   = db_getsession("DB_instit");
		  $dispensa142021->si78_mes           				  = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  
		  $dispensa142021->incluir(null);
		  if ($dispensa142021->erro_status == 0) {
		    throw new Exception($dispensa142021->erro_msg);
		  }
		}
	
		$sSql="select '15' as tipoRegistro,
		db_config.db21_tipoinstit as codOrgaoResp,
		(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
		liclicita.l20_anousu as exercicioLicitacao,
		liclicita.l20_numero as nroProcessoLicitatorio,
		pctipocompratribunal.l44_codigotribunal as tipoProcesso,
		liclicitemlote.l04_codigo as nroLote,
		pcmater.pc01_codmater as codItem,
		itemprecoreferencia.si02_vlprecoreferencia as vlCotPrecosUnitario,
		pcorcamval.pc23_quant as quantidade
		FROM liclicitem as liclicitem
		INNER JOIN liclicitemlote as liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
		INNER JOIN liclicita as liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
		INNER JOIN homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
		INNER JOIN cflicita as cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal as pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN compras.pcprocitem as pcprocitem  on (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
		INNER JOIN compras.solicitem as solicitem on (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
		INNER JOIN compras.solicitempcmater as solicitempcmater on (solicitem.pc11_codigo = solicitempcmater.pc16_solicitem)
		INNER JOIN compras.pcmater as pcmater on (solicitempcmater.pc16_codmater = pcmater.pc01_codmater)
		INNER JOIN compras.pcproc as pcproc on (pcprocitem.pc81_codproc=pcproc.pc80_codproc)
		INNER JOIN compras.pcorcamitemproc as pcorcamitemproc on (pcprocitem.pc81_codprocitem = pcorcamitemproc.pc31_pcprocitem)
		INNER JOIN compras.pcorcamitem as pcorcamitem on (pcorcamitemproc.pc31_orcamitem = pcorcamitem.pc22_orcamitem)
		INNER JOIN compras.pcorcamval as pcorcamval on (pcorcamitem.pc22_orcamitem = pcorcamval.pc23_orcamitem)
		INNER JOIN sicom.precoreferencia as precoreferencia on (pcproc.pc80_codproc = precoreferencia.si01_processocompra)
		INNER JOIN sicom.itemprecoreferencia as itemprecoreferencia on (precoreferencia.si01_sequencial = itemprecoreferencia.si02_precoreferencia and pcorcamval.pc23_orcamitem = itemprecoreferencia.si02_itemproccompra)	
		INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
		WHERE db_config.codigo= " .db_getsession("DB_instit")."
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";
 
		
		$rsResult15 = db_query($sSql);
		
		for ($iCont15 = 0; $iCont15 < pg_num_rows($rsResult15); $iCont15++) {
		  	
		  $dispensa152021 = new cl_dispensa152021();
		  $oDados15       = db_utils::fieldsMemory($rsResult15, $iCont15);
		  	
		  $dispensa152021->si79_tiporegistro   				  = 15;
		  $dispensa152021->si79_reg10 						  = $dispensa102021->si74_sequencial;		
		  $dispensa152021->si79_codorgaoresp  				  =	$oDados15->codorgaoresp;
		  $dispensa152021->si79_codunidadesubresp			  = $oDados15->codunidadesubresp;
		  $dispensa152021->si79_exercicioprocesso			  = $oDados15->exerciciolicitacao;
		  $dispensa152021->si79_nroprocesso					  = $oDados15->nroprocessolicitatorio; 
		  $dispensa152021->si79_tipoprocesso				  = $oDados15->tipoprocesso;
		  $dispensa152021->si79_nrolote						  = $oDados15->nrolote;
		  $dispensa152021->si79_coditem						  = $oDados15->coditem;
		  $dispensa152021->si79_vlcotprecosunitario			  = $oDados15->vlcotprecosunitario ;
		  $dispensa152021->si79_quantidade					  = $oDados15->quantidade;
		  $dispensa152021->si79_instit		   				   = db_getsession("DB_instit");
		  $dispensa152021->si79_mes          				  = $this->sDataFinal['5'].$this->sDataFinal['6'];
			 
		  
		  $dispensa152021->incluir(null);
		  if ($dispensa152021->erro_status == 0) {
		    throw new Exception($dispensa152021->erro_msg);
		  }
		}

		$sSql="select '16' as tipoRegistro,
		db_config.db21_tipoinstit as codOrgaoResp,
		(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
		liclicita.l20_anousu as exercicioLicitacao,
		liclicita.l20_numero as nroProcessoLicitatorio,	
		pctipocompratribunal.l44_codigotribunal as tipoProcesso,
		orcdotacao.o58_orgao as codOrgao,
		orcdotacao.o58_unidade as codUnidadeSub,
		orcdotacao.o58_funcao as codFuncao,
		orcdotacao.o58_subfuncao as codSubFuncao,
		orcdotacao.o58_programa as codPrograma,
		orcdotacao.o58_projativ as idAcao,
		' ' as idSubAcao,
		substr(orcelemento.o56_elemento,2,6) as naturezaDespesa,
		orctiporec.o15_codtri as codFontRecursos,
		pcdotac.pc13_valor as vlRecurso			
		FROM licitacao.liclicita as liclicita 
		INNER JOIN licitacao.homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
		INNER JOIN licitacao.liclicitem as liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
		INNER JOIN licitacao.cflicita as cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN licitacao.pctipocompratribunal as pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN compras.pcprocitem as pcprocitem on (liclicitem.l21_codpcprocitem=pcprocitem.pc81_codprocitem)
		INNER JOIN compras.pcdotac as pcdotac on (pcprocitem.pc81_solicitem=pcdotac.pc13_codigo)
		INNER JOIN orcamento.orcdotacao as orcdotacao on (pcdotac.pc13_anousu=orcdotacao.o58_anousu and pcdotac.pc13_coddot=orcdotacao.o58_coddot)
		INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
		INNER JOIN orcamento.orctiporec as orctiporec on (orcdotacao.o58_codigo=orctiporec.o15_codigo)
		INNER JOIN orcamento.orcelemento as orcelemento on (orcdotacao.o58_anousu=orcelemento.o56_anousu and orcdotacao.o58_codele=orcelemento.o56_codele)
		WHERE db_config.codigo= " .db_getsession("DB_instit")."
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";
		
		
		$rsResult16 = db_query($sSql);
		
		for ($iCont16 = 0; $iCont16 < pg_num_rows($rsResult16); $iCont16++) {
		  	
		  $dispensa162021 = new cl_dispensa162021();
		  $oDados16       = db_utils::fieldsMemory($rsResult16, $iCont16);
		  	
		  $dispensa162021->si79_tiporegistro   				  = 16;
		  $dispensa162021->si79_reg10 						  = $dispensa102021->si74_sequencial;		
		  $dispensa162021->si79_codorgaoresp  				  =	$oDados16->codorgaoresp;
		  $dispensa162021->si79_codunidadesubresp			  = $oDados16->codunidadesubresp;
		  $dispensa162021->si79_exercicioprocesso			  = $oDados16->exerciciolicitacao;
		  $dispensa162021->si79_nroprocesso					  = $oDados16->nroprocessolicitatorio; 
		  $dispensa162021->si79_tipoprocesso				  = $oDados16->tipoprocesso;
		  $dispensa162021->si79_nrolote						  = $oDados16->nrolote;
		  $dispensa162021->si79_coditem						  = $oDados16->coditem;
		  $dispensa162021->si79_vlcotprecosunitario			  = $oDados16->vlcotprecosunitario ;
		  $dispensa162021->si79_quantidade					  = $oDados16->quantidade;
		  $dispensa162021->si79_instit		   				   = db_getsession("DB_instit");
		  $dispensa162021->si79_mes          				  = $this->sDataFinal['5'].$this->sDataFinal['6'];
			 
		  
		  $dispensa162021->incluir(null);
		  if ($dispensa162021->erro_status == 0) {
		    throw new Exception($dispensa162021->erro_msg);
		  }
		}
	 
		  
		  
	$sSql="select '17' as tipoRegistro,
	db_config.db21_tipoinstit as codOrgaoResp,
	(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
	liclicita.l20_anousu as exercicioLicitacao,
	liclicita.l20_numero as nroProcessoLicitatorio,	
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
	liclicitemlote.l04_codigo as nroLote,
	solicitempcmater.pc16_codmater as codItem,
	pcorcamval.pc23_vlrun as vlUnitario,
	pcorcamval.pc23_quant as quantidade 	
	FROM licitacao.liclicita as liclicita 
	INNER JOIN licitacao.homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
	INNER JOIN licitacao.habilitacaoforn as habilitacaoforn on (liclicita.l20_codigo=habilitacaoforn.l206_licitacao)
	INNER JOIN compras.pcforne as pcforne on (habilitacaoforn.l206_fornecedor=pcforne.pc60_numcgm)
	INNER JOIN protocolo.cgm as cgm on (pcforne.pc60_numcgm=cgm.z01_numcgm)
	INNER JOIN licitacao.cflicita as cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
	INNER JOIN licitacao.pctipocompratribunal as pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
	INNER JOIN licitacao.liclicitem as liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
	INNER JOIN licitacao.pcorcamitemlic as pcorcamitemlic ON (liclicitem.l21_codigo = pcorcamitemlic.pc26_liclicitem )      
	INNER JOIN compras.pcorcamitem as pcorcamitem ON (pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem)      
	INNER JOIN compras.pcorcamjulg as pcorcamjulg ON (pcorcamitem.pc22_orcamitem = pcorcamjulg.pc24_orcamitem )
	INNER JOIN compras.pcorcamforne as pcorcamforne ON (pcorcamjulg.pc24_orcamforne = pcorcamforne.pc21_orcamforne)
	INNER JOIN compras.pcprocitem as pcprocitem  ON (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
	INNER JOIN compras.solicitem as solicitem ON (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
	INNER JOIN compras.solicitempcmater as solicitempcmater ON (solicitem.pc11_codigo=solicitempcmater.pc16_solicitem)    
	INNER JOIN compras.pcorcamval as pcorcamval ON (pcorcamitem.pc22_orcamitem = pcorcamval.pc23_orcamitem and pcorcamforne.pc21_orcamforne=pcorcamval.pc23_orcamforne)
	INNER JOIN licitacao.liclicitemlote as liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
	INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
	WHERE db_config.codigo= " .db_getsession("DB_instit")."
	AND liclicita.l20_codigo= {$oDados10->codlicitacao}";
		
	
		$rsResult17 = db_query($sSql);
		
		for ($iCont17 = 0; $iCont17 < pg_num_rows($rsResult17); $iCont17++) {
		  	
		  $dispensa172021 = new cl_dispensa172021();
		  $oDados17       = db_utils::fieldsMemory($rsResult17, $iCont17);
		  	
		  	$dispensa172021->si81_tiporegistro				 					 	= 17;
 		  	$dispensa172021->si81_codorgaoresp									 	=	$oDados17->codorgaoresp;                        
			$dispensa172021->si81_codunidadesubresp									=	$oDados17->codunidadesubresp;                     
			$dispensa172021->si81_exercicioprocesso									=	$oDados17->exerciciolicitacao;                  
			$dispensa172021->si81_nroprocesso										=	$oDados17->nroprocessolicitatorio;               
			$dispensa172021->si81_tipoprocesso										=	$oDados17->tipoprocesso;              
			$dispensa172021->si81_tipodocumento										=	$oDados17->tipodocumento;             
			$dispensa172021->si81_nrodocumento										=	$oDados17->nrodocumento;                         
			$dispensa172021->si81_nroinscricaoestadual								=	$oDados17->nroinscricaoestadual;                  
			$dispensa172021->si81_ufinscricaoestadual								=	$oDados17->ufinscricaoestadual;                  
			$dispensa172021->si81_nrocertidaoregularidadeinss						=	$oDados17->nrocertidaoregularidadeinss;          
			$dispensa172021->si81_dtemissaocertidaoregularidadeinss					=	$oDados17->dataemissaocertidaoregularidadeinss;  
			$dispensa172021->si81_dtvalidadecertidaoregularidadeinss				=	$oDados17->datavalidadecertidaoregularidadeinss; 
			$dispensa172021->si81_nrocertidaoregularidadefgts						=	$oDados17->nrocertidaoregularidadefgts;          
			$dispensa172021->si81_dtemissaocertidaoregularidadefgts					=	$oDados17->dataemissaocertidaoregularidadefgts;  
			$dispensa172021->si81_dtvalidadecertidaoregularidadefgts				=	$oDados17->datavalidadecertidaoregularidadefgts; 
			$dispensa172021->si81_nrocndt											=	$oDados17->nrocndt;                              
			$dispensa172021->si81_dtemissaocndt										=	$oDados17->dtemissaocndt;                        
			$dispensa172021->si81_dtvalidadecndt									=	$oDados17->dtvalidadecndt;                       
			$dispensa172021->si81_nrolote											=	$oDados17->nrolote;                              
			$dispensa172021->si81_coditem											=	$oDados17->coditem;                              
			$dispensa172021->si81_vlitem											=	$oDados17->vlunitario;                           
			$dispensa172021->si81_quantidade										=	$oDados17->quantidade;
			$dispensa172021->si81_instit		   				   = db_getsession("DB_instit");                           
		  	$dispensa172021->si81_mes          				 						= $this->sDataFinal['5'].$this->sDataFinal['6'];
			 
		  
		  $dispensa172021->incluir(null);
		  if ($dispensa172021->erro_status == 0) {
		    throw new Exception($dispensa172021->erro_msg);
		  }  
		} 
    
    $sSql="select '18' as tipoRegistro,
	db_config.db21_tipoinstit as codOrgaoResp,
	(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
	liclicita.l20_anousu as exercicioLicitacao,
	liclicita.l20_numero as nroProcessoLicitatorio,	
	pctipocompratribunal.l44_codigotribunal as tipoProcesso,
	(CASE length(cgm.z01_cgccpf) WHEN 11 THEN 1
		ELSE 2
	END) as tipoDocumento,
	cgm.z01_cgccpf as nroDocumento,
	credenciamento.l205_datacred as dataCredenciamento,
	liclicitemlote.l04_codigo as nroLote,
	solicitem.pc11_codigo as codItem,	
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
	FROM licitacao.liclicita as liclicita 
	INNER JOIN licitacao.homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
	INNER JOIN licitacao.habilitacaoforn as habilitacaoforn on (liclicita.l20_codigo=habilitacaoforn.l206_licitacao)
	INNER JOIN licitacao.credenciamento as credenciamento on (liclicita.l20_codigo=credenciamento.l205_licitacao)
	INNER JOIN compras.pcforne as pcforne on (habilitacaoforn.l206_fornecedor=pcforne.pc60_numcgm)
	INNER JOIN protocolo.cgm as cgm on (pcforne.pc60_numcgm=cgm.z01_numcgm)
	INNER JOIN licitacao.cflicita as cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
	INNER JOIN licitacao.pctipocompratribunal as pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
	INNER JOIN licitacao.liclicitem as liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
	INNER JOIN licitacao.pcorcamitemlic as pcorcamitemlic ON (liclicitem.l21_codigo = pcorcamitemlic.pc26_liclicitem )      
	INNER JOIN compras.pcorcamitem as pcorcamitem ON (pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem)      
	INNER JOIN compras.pcprocitem as pcprocitem  ON (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
	INNER JOIN compras.solicitem as solicitem ON (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
	INNER JOIN licitacao.liclicitemlote as liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
	INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)    
	WHERE db_config.codigo= " .db_getsession("DB_instit")."
	AND liclicita.l20_codigo= {$oDados10->codlicitacao}";
		
		
		$rsResult18 = db_query($sSql);
		
		for ($iCont18 = 0; $iCont18 < pg_num_rows($rsResult18); $iCont18++) {
		  	
		  $dispensa182021 = new cl_dispensa182021();
		  $oDados18       = db_utils::fieldsMemory($rsResult18, $iCont18);
		  	
		  	$dispensa182021->si82_tiporegistro				  					= 	18;
 		  	$dispensa182021->si82_codorgaoresp				 					=	$oDados18->codorgaoresp;
			$dispensa182021->si82_codunidadesubresp 							=	$oDados18->codunidadesubresp;
			$dispensa182021->si82_exercicioprocesso								=	$oDados18->exerciciolicitacao;
			$dispensa182021->si82_nroprocesso									=	$oDados18->nroprocessolicitatorio;
			$dispensa182021->si82_tipoprocesso									=	$oDados18->tipoprocesso;
			$dispensa182021->si82_tipodocumento									=	$oDados18->tipodocumento;
			$dispensa182021->si82_nrodocumento									=	$oDados18->nrodocumento;
			$dispensa182021->si82_datacredenciamento							=	$oDados18->datacredenciamento;
			$dispensa182021->si82_nrolote										=	$oDados18->nrolote;
			$dispensa182021->si82_coditem										=	$oDados18->coditem;
			$dispensa182021->si82_nroinscricaoestadual							=	$oDados18->nroinscricaoestadual;
			$dispensa182021->si82_ufinscricaoestadual							=	$oDados18->ufinscricaoestadual;
			$dispensa182021->si82_nrocertidaoregularidadeinss					=	$oDados18->nrocertidaoregularidadeinss;
			$dispensa182021->si82_dataemissaocertidaoregularidadeinss			=	$oDados18->dataemissaocertidaoregularidadeinss;
			$dispensa182021->si82_dtvalidadecertidaoregularidadeinssd			=	$oDados18->datavalidadecertidaoregularidadeinss;
			$dispensa182021->si82_nrocertidaoregularidadefgts					=	$oDados18->nrocertidaoregularidadefgts;
			$dispensa182021->si82_dtemissaocertidaoregularidadefgts				=	$oDados18->dataemissaocertidaoregularidadefgts;
			$dispensa182021->si82_nrocndt										=	$oDados18->nrocndt;
			$dispensa182021->si82_dtemissaocndt									=	$oDados18->dtemissaocndt;
			$dispensa182021->si82_dtvalidadecndt								=	$oDados18->dtvalidadecndt;
			$dispensa182021->si82_instit		   				   = db_getsession("DB_instit");
			$dispensa182021->si82_mes          				  					=   $this->sDataFinal['5'].$this->sDataFinal['6'];
			 
		  
		  $dispensa182021->incluir(null);
		  if ($dispensa182021->erro_status == 0) {
		    throw new Exception($dispensa182021->erro_msg);
		  }
		}
    
	 }
		
    
    db_fim_transacao();
    
    $oGerarDISPENSA = new GerarDISPENSA();
    $oGerarDISPENSA->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarDISPENSA->gerarDados();
    
  }
}
     

 
