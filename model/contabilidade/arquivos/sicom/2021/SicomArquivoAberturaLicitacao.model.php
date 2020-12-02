<?php  
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_aberlic102021_classe.php");
require_once ("classes/db_aberlic112021_classe.php");
require_once ("classes/db_aberlic122021_classe.php");
require_once ("classes/db_aberlic132021_classe.php");
require_once ("classes/db_aberlic142021_classe.php");
require_once ("classes/db_aberlic152021_classe.php");
require_once ("classes/db_aberlic162021_classe.php");

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarABERLIC.model.php");


/**
 * Abertura da licitacao Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoAberturaLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV {

	/**
	 *
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
	protected $iCodigoLayout = 154;

	/**
	 *
	 * Nome do arquivo a ser criado
	 * @var String
	 */
	protected $sNomeArquivo = 'ABERLIC';

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
                          "codOrgaoResp",
                          "codUnidadeSubResp",
                          "exercicioLicitacao",
                          "nroProcessoLicitatorio",
                          "codModalidadeLicitacao",
                          "nroModalidade",
                          "naturezaProcedimento",
                          "dtAbertura",
                          "dtEditalConvite",
											    "dtPublicacaoEditalDO",
											    "dtPublicacaoEditalVeiculo1",
											    "veiculo1Publicacao",
											    "dtPublicacaoEditalVeiculo2",
											    "veiculo2Publicacao",
											    "dtRecebimentoDoc",
											    "tipoLicitacao",
											    "naturezaObjeto",
											    "objeto",
											    "regimeExecucaoObras",
											    "nroConvidado",
											    "clausulaProrrogacao",
											    "unidadeMedidaPrazoExecucao",
											    "prazoExecucao",
											    "formaPagamento",
    											"criterioAceitabilidade",
    											"descontoTabela"
    											);
    $aElementos[11] = array(
											    "tipoRegistro",
											    "codOrgaoResp",
											    "codUnidadeSubResp",
											    "exercicioLicitacao",
    											"nroProcessoLicitatorio",
    											"nroLote",
    											"nroItem",
    											"dtCotacao",
    											"dscItem",
    											"vlCotPrecosUnitario",
    											"quantidade",
    											"unidade",
    											"vlMinAlienBens"
    											);
    $aElementos[12] = array(
                          "tipoRegistro",
                          "codOrgaoResp",
                          "codUnidadeSubResp",
                          "exercicioLicitacao",
    											"nroProcessoLicitatorio",
											    "nroLote",
											    "nroItem",
											    "dscItem",
											    "vlItem"
											    );
	  $aElementos[13] = array(
											    "tipoRegistro",
											    "codOrgaoResp",
											    "codUnidadeSubResp",
											    "exercicioLicitacao",
											    "nroProcessoLicitatorio",
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
    return $aElementos;
	}

	/**
	 * selecionar os dados dos pagamentos de despesa do mes para gerar o arquivo
	 * @see iPadArquivoBase::gerarDados()
	 */
	public function gerarDados() {
	
   	/**
  	 * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo 
  	 */
      $claberlic102021 = new cl_aberlic102021();
      $claberlic112021 = new cl_aberlic112021();
      $claberlic122021 = new cl_aberlic122021();
      $claberlic132021 = new cl_aberlic132021();
      $claberlic142021 = new cl_aberlic142021();
      $claberlic152021 = new cl_aberlic152021();
      $claberlic162021 = new cl_aberlic162021();
      
    /**
     * excluir informacoes do mes selecioado para evitar duplicacao de registros
     */
      db_inicio_transacao();
    
    /**
     * registro 16  
     */
      $result = db_query($claberlic162021->sql_query(NULL,"*",NULL,"si52_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si52_instit=".db_getsession("DB_instit")  ));
	  if (pg_num_rows($result) > 0) {
	      $claberlic162021->excluir(NULL,"si52_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si52_instit=".db_getsession("DB_instit"));
	      if ($claberlic162021->erro_status == 0) {
	    	  throw new Exception($claberlic162021->erro_msg);
	      }
	    }
	  
	/**
     * registro 15  
     */
	    
      $result = db_query($claberlic152021->sql_query(NULL,"*",NULL,"si51_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si51_instit=".db_getsession("DB_instit") ));
      
	  if (pg_num_rows($result) > 0) {
	      $claberlic152021->excluir(NULL,"si51_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si51_instit=".db_getsession("DB_instit"));
	      if ($claberlic152021->erro_status == 0) {
	    	  throw new Exception($claberlic152021->erro_msg);
	      }
	    }
	    
	/**
     * registro 14  
     */
      $result = db_query($claberlic142021->sql_query(NULL,"*",NULL,"si50_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si50_instit=".db_getsession("DB_instit")));
	  if (pg_num_rows($result) > 0) {
	      $claberlic142021->excluir(NULL,"si50_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si50_instit=".db_getsession("DB_instit"));
	      if ($claberlic142021->erro_status == 0) {
	    	  throw new Exception($claberlic142021->erro_msg);
	      }
	    }
	    
	/**
     * registro 13  
     */
      $result = db_query($claberlic132021->sql_query(NULL,"*",NULL,"si49_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si49_instit=".db_getsession("DB_instit")));
	  if (pg_num_rows($result) > 0) {
	      $claberlic132021->excluir(NULL,"si49_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si49_instit=".db_getsession("DB_instit"));
	      if ($claberlic132021->erro_status == 0) {
	    	  throw new Exception($claberlic132021->erro_msg);
	      }
	    }
	    
	/**
     * registro 12  
     */
      $result = db_query($claberlic122021->sql_query(NULL,"*",NULL,"si48_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si48_instit=".db_getsession("DB_instit")));
	  if (pg_num_rows($result) > 0) {
	      $claberlic122021->excluir(NULL,"si48_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si48_instit=".db_getsession("DB_instit"));
	      if ($claberlic122021->erro_status == 0) {
	    	  throw new Exception($claberlic122021->erro_msg);
	      }
	    }
	    
	/**
     * registro 11  
     */
      $result = db_query($claberlic112021->sql_query(NULL,"*",NULL,"si47_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si47_instit=".db_getsession("DB_instit")));
	  if (pg_num_rows($result) > 0) {
	      $claberlic112021->excluir(NULL,"si47_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si47_instit=".db_getsession("DB_instit"));
	      if ($claberlic112021->erro_status == 0) {
	    	  throw new Exception($claberlic112021->erro_msg);
	      }
	    }
	    
	/**
     * registro 10  
     */
      $result = db_query($claberlic102021->sql_query(NULL,"*",NULL,"si46_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si46_instit=".db_getsession("DB_instit")));
	  if (pg_num_rows($result) > 0) {
	      $claberlic102021->excluir(NULL,"si46_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si46_instit=".db_getsession("DB_instit"));
	      if ($claberlic102021->erro_status == 0) {
	    	  throw new Exception($claberlic102021->erro_msg);
	      }
	    }
	    
	    
      
	   $sSql="SELECT '10' AS tipoRegistro,
	   l20_codigo as seqlicitacao,
       db_config.db21_tipoinstit AS codOrgaoResp,
       (select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
       liclicita.l20_anousu AS exercicioLicitacao,
       liclicita.l20_numero AS nroProcessoLicitatorio,
       pctipocompratribunal.l44_codigotribunal AS codModalidadeLicitacao,
       liclicita.l20_numero AS nroModalidade,
       liclicita.l20_tipnaturezaproced AS naturezaProcedimento,
       liclicita.l20_datacria AS dtAbertura,
       liclicita.l20_dataaber AS dtEditalConvite,
       liclicita.l20_dtpublic AS dtPublicacaoEditalDO,
       liclicita.l20_datapublicacao1 AS dtPublicacaoEditalVeiculo1,
       liclicita.l20_nomeveiculo1 AS veiculo1Publicacao,
       liclicita.l20_datapublicacao2 AS dtPublicacaoEditalVeiculo2,
       liclicita.l20_nomeveiculo2 AS veiculo2Publicacao,
       liclicita.l20_recdocumentacao AS dtRecebimentoDoc,
       liclicita.l20_tipliticacao AS tipoLicitacao,
       liclicita.l20_naturezaobjeto AS naturezaObjeto,
       liclicita.l20_objeto AS Objeto,
       liclicita.l20_regimexecucao AS regimeExecucaoObras,
       liclicita.l20_numeroconvidado AS nroConvidado,
       ' ' AS clausulaProrrogacao,
       '2' AS unidadeMedidaPrazoExecucao,
       liclicita.l20_execucaoentrega AS prazoExecucao,
       liclicita.l20_condicoespag AS formaPagamento,
       liclicita.l20_aceitabilidade AS criterioAceitabilidade,
       liclicita.l20_descontotab AS descontoTabela,
       	(CASE liclicita.l20_tipojulg 
		WHEN 3 THEN 1 
		ELSE 2 
	    END) as processoPorLote,
       liclicita.l20_critdesempate AS criterioDesempate,
       liclicita.l20_destexclusiva AS destinacaoExclusiva,
       liclicita.l20_subcontratacao AS subcontratacao,
       liclicita.l20_limitcontratacao AS limiteContratacao
	   FROM liclicita AS liclicita
	   INNER JOIN homologacaoadjudica AS homologacaoadjudica ON (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
	   INNER JOIN cflicita AS cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
	   INNER JOIN pctipocompratribunal AS pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
	   INNER JOIN configuracoes.db_config AS db_config ON (liclicita.l20_instit=db_config.codigo)
	   WHERE db_config.codigo=" .db_getsession("DB_instit")."
	   AND DATE_PART('YEAR',homologacaoadjudica.l202_datahomologacao)= ".db_getsession("DB_anousu")."  
	   AND DATE_PART('MONTH',homologacaoadjudica.l202_datahomologacao)=" .$this->sDataFinal['5'].$this->sDataFinal['6']."
	   AND pctipocompratribunal.l44_codigotribunal IN ('1',
		                                                  '2',
		                                                  '3',
		                                                  '4',
		                                                  '5',
		                                                  '6')";  
	   $rsResult10 = db_query($sSql);
	/**
     * registro 10  
     */
	    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++){
      
    	    $claberlic102021 = new cl_aberlic102021();
    	    $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

			  $claberlic102021->si46_tiporegistro    = 10;
			  $claberlic102021->si46_clausulaprorrogacao           = $oDados10->clausulaprorrogacao;
			  $claberlic102021->si46_codmodalidadelicitacao        = $oDados10->codmodalidadelicitacao;
			  $claberlic102021->si46_codorgaoresp    		 	   = $oDados10->codorgaoresp;
			  $claberlic102021->si46_codunidadesubresp 			   = $oDados10->codunidadesubresp;
			  $claberlic102021->si46_criterioaceitabilidade        = $oDados10->criterioAceitabilidade;
			  $claberlic102021->si46_criteriodesempate             = $oDados10->criteriodesempate;
			  $claberlic102021->si46_descontotabela                = $oDados10->descontotabela;
			  $claberlic102021->si46_destinacaoexclusiva           = $oDados10->destinacaoexclusiva;
			  $claberlic102021->si46_dtabertura 				   = $oDados10->dtabertura;
			  $claberlic102021->si46_dteditalconvite 			   = $oDados10->dteditalconvite;
			  $claberlic102021->si46_dtpublicacaoeditaldo 		   = $oDados10->dtpublicacaoeditaldo;
			  $claberlic102021->si46_dtpublicacaoeditalveiculo1    = $oDados10->dtpublicacaoeditalveiculo1;
			  $claberlic102021->si46_dtpublicacaoeditalveiculo2    = $oDados10->dtpublicacaoeditalveiculo2;
			  $claberlic102021->si46_dtrecebimentodoc              = $oDados10->dtrecebimentodoc;
			  $claberlic102021->si46_exerciciolicitacao            = $oDados10->exerciciolicitacao;
			  $claberlic102021->si46_formapagamento                = $oDados10->formaPagamento;
			  $claberlic102021->si46_limitecontratacao             = $oDados10->limitecontratacao;
			  $claberlic102021->si46_mes                           = $this->sDataFinal['5'].$this->sDataFinal['6'];
			  $claberlic102021->si46_naturezaobjeto                = $oDados10->naturezaobjeto;
			  $claberlic102021->si46_naturezaprocedimento          = $oDados10->naturezaprocedimento;
			  $claberlic102021->si46_nroconvidado                  = $oDados10->nroconvidado;
			  $claberlic102021->si46_nromodalidade                 = $oDados10->nromodalidade;
			  $claberlic102021->si46_nroprocessolicitatorio        = $oDados10->nroprocessolicitatorio;
			  $claberlic102021->si46_objeto                        = $oDados10->objeto;
			  $claberlic102021->si46_prazoexecucao                 = $oDados10->prazoexecucao;
			  $claberlic102021->si46_processoporlote               = $oDados10->processoporlote;
			  $claberlic102021->si46_regimeexecucaoobras           = $oDados10->regimeexecucaoobras;
			  $claberlic102021->si46_subcontratacao                = $oDados10->subcontratacao;
			  $claberlic102021->si46_tipolicitacao                 = $oDados10->tipolicitacao;
			  $claberlic102021->si46_unidademedidaprazoexecucao    = $oDados10->unidademedidaprazoexecucao;
			  $claberlic102021->si46_veiculo1publicacao            = $oDados10->veiculo1publicacao;
			  $claberlic102021->si46_veiculo2publicacao            = $oDados10->veiculo2Publicacao;
			  $claberlic102021->si46_instit		   				   = db_getsession("DB_instit");
			   
			  $claberlic102021->incluir(null); 
			  if ($claberlic102021->erro_status == 0) {
			  	throw new Exception($claberlic102021->erro_msg);
			  }
		  
       
	    /**
    	 * selecionar informacoes registro 11
    	 */
            
			   $sSql ="SELECT '11' AS tipoRegistro,
		       db_config.db21_tipoinstit AS codOrgaoResp,
		       (SELECT db01_unidade
		       FROM db_departorg
		   	   WHERE db01_coddepto=l20_codepartamento
		       AND db01_anousu=".db_getsession("DB_anousu").") AS codUnidadeSubResp,
		       liclicita.l20_anousu AS exercicioLicitacao,
		       liclicita.l20_numero AS nroProcessoLicitatorio,
		       liclicitemlote.l04_codigo AS nroLote,
		       liclicitemlote.l04_descricao AS dscLote
			   FROM licitacao.liclicitem AS liclicitem
			   INNER JOIN licitacao.liclicita AS liclicita ON (liclicitem.l21_codliclicita=liclicita.l20_codigo)
		       INNER JOIN configuracoes.db_config AS db_config ON (liclicita.l20_instit=db_config.codigo)
			   INNER JOIN licitacao.liclicitemlote AS liclicitemlote ON (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
			   WHERE db_config.codigo=" .db_getsession("DB_instit")."
		       AND liclicita.l20_codigo=$oDados10->seqlicitacao";

			   $rsResult11 = db_query($sSql);
			   
		       for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {
		           	
		         $claberlic112021 = new cl_aberlic112021();
		    	 $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
		    	 
		    	 $claberlic112021->si47_tiporegistro             = 11;
		    	 $claberlic112021->si47_codorgaoresp             = $oDados11->codorgaoresp;
		    	 $claberlic112021->si47_codunidadesubresp        = $oDados11->codunidadesubresp;
		    	 $claberlic112021->si47_exerciciolicitacao       = $oDados11->exerciciolicitacao;
		    	 $claberlic112021->si47_nroprocessolicitatorio   = $oDados11->nroprocessolicitatorio;
		    	 $claberlic112021->si47_nrolote       			 = $oDados11->nrolote;
		    	 $claberlic112021->si47_dsclote 				 = $oDados11->dsclote;
		    	 $claberlic112021->si47_mes                   	 = $this->sDataFinal['5'].$this->sDataFinal['6'];
		    	 $claberlic112021->si47_reg10  				 	 = $claberlic102021->si46_sequencial;// chave estrangeira
		    	 $claberlic112021->si47_instit  				 = db_getsession("DB_instit");
		    		
		    	 $claberlic112021->incluir(null);
		    	 if ($claberlic112021->erro_status == 0) {
		    	   throw new Exception($claberlic112021->erro_msg);
		    	 }
		    		
		    	}
         
         
    	        $sSql=" select '12' as tipoRegistro,
				db_config.db21_tipoinstit as codOrgaoResp,
				(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
				liclicita.l20_anousu as exercicioLicitacao,
				liclicita.l20_numero as nroProcessoLicitatorio,
				pcmater.pc01_codmater as codItem,
				liclicitem.l21_ordem as nroItem	
				FROM licitacao.liclicitem as liclicitem
				INNER JOIN licitacao.liclicita as liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
				INNER JOIN compras.pcprocitem as pcprocitem  on (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
				INNER JOIN compras.solicitem as solicitem on (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
				INNER JOIN compras.solicitempcmater as solicitempcmater on (solicitem.pc11_codigo = solicitempcmater.pc16_solicitem)
				INNER JOIN compras.pcmater as pcmater on (solicitempcmater.pc16_codmater = pcmater.pc01_codmater)
				INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
				WHERE db_config.codigo= " .db_getsession("DB_instit")."
				AND liclicita.l20_codigo= $oDados10->seqlicitacao";

    	       $rsResult12 = db_query($sSql);
		       for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {
		             	
		         $claberlic122021 = new cl_aberlic122021();
		    	 $oDados12 = db_utils::fieldsMemory($rsResult12, $iCont12);
		    	 
		    	 $claberlic122021->si48_tiporegistro             = 12;
		    	 $claberlic122021->si48_codorgaoresp             = $oDados12->codorgaoresp;
		    	 $claberlic122021->si48_exerciciolicitacao       = $oDados12->exerciciolicitacao;
		    	 $claberlic122021->si48_nroprocessolicitatorio   = $oDados12->nroprocessolicitatorio;
		    	 $claberlic122021->si48_coditem					 = $oDados12->coditem ; 
		    	 $claberlic122021->si48_nroitem					 = $oDados12->nroitem;
		    	 $claberlic122021->si48_reg10  				 	 = $claberlic102021->si46_sequencial;// chave estrangeira
		    	 $claberlic122021->si48_instit		   		     = db_getsession("DB_instit");
		    	 $claberlic122021->si48_mes                   	 = $this->sDataFinal['5'].$this->sDataFinal['6'];
		    	
		    	 
		       	 $claberlic122021->incluir(null);
		    	 if ($claberlic122021->erro_status == 0) {
		    	   throw new Exception($claberlic122021->erro_msg);
		    	 }
		    	}
		  
		    	
			$sSql=" select '13' as tipoRegistro,
			db_config.db21_tipoinstit as codOrgaoResp,
			(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
			liclicita.l20_anousu as exercicioLicitacao,
			liclicita.l20_numero as nroProcessoLicitatorio,
			liclicitemlote.l04_codigo as nroLote,
			pcmater.pc01_codmater as codItem
			FROM licitacao.liclicitem as liclicitem
			INNER JOIN licitacao.liclicita as liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
			INNER JOIN compras.pcprocitem as pcprocitem  on (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
			INNER JOIN compras.solicitem as solicitem on (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
			INNER JOIN compras.solicitempcmater as solicitempcmater on (solicitem.pc11_codigo = solicitempcmater.pc16_solicitem)
			INNER JOIN compras.pcmater as pcmater on (solicitempcmater.pc16_codmater = pcmater.pc01_codmater)
			INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
			INNER JOIN licitacao.liclicitemlote as liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
			WHERE db_config.codigo= " .db_getsession("DB_instit")."
			AND liclicita.l20_codigo= $oDados10->seqlicitacao";

    	        
    	       $rsResult13 = db_query($sSql);
		       for ($iCont13 = 0; $iCont13 < pg_num_rows($rsResult13); $iCont13++) {
		             	
		         $claberlic132021 = new cl_aberlic132021();
		    	 $oDados13 = db_utils::fieldsMemory($rsResult13, $iCont13);
		    	 
		    	 $claberlic132021->si49_tiporegistro             	= 13;
		    	 $claberlic132021->si49_codorgaoresp             	= $oDados13->codorgaoresp;
		    	 $claberlic132021->si49_codunidadesubresp       	= $oDados13->codunidadesubresp;
		    	 $claberlic132021->si49_exerciciolicitacao   		= $oDados13->exerciciolicitacao;
		    	 $claberlic132021->si49_nroprocessolicitatorio		= $oDados13->nroprocessolicitatorio; 
		    	 $claberlic132021->si49_nrolote					 	= $oDados13->nrolote;
		    	 $claberlic132021->si49_reg10 				 	 	= $claberlic102021->si46_sequencial;// chave estrangeira
		    	 $claberlic132021->si49_coditem						= $oDados13->coditem;
		    	 $claberlic132021->si49_instit		   				= db_getsession("DB_instit");
		    	 $claberlic132021->si49_mes                   	 	= $this->sDataFinal['5'].$this->sDataFinal['6'];
		    	
		    	 
		       	 $claberlic132021->incluir(null);
		    	 if ($claberlic132021->erro_status == 0) {
		    	   throw new Exception($claberlic132021->erro_msg);
		    	 }
		    	}
		    	
	    $sSql=" select '14' as tipoRegistro,
		db_config.db21_tipoinstit as codOrgaoResp,
		(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
		liclicita.l20_anousu as exercicioLicitacao,
		liclicita.l20_numero as nroProcessoLicitatorio,	
		liclicitemlote.l04_codigo as nroLote,
		pcmater.pc01_codmater as codItem,
		precoreferencia.si01_datacotacao as dtCotacao,
		itemprecoreferencia.si02_vlprecoreferencia as vlCotPrecosUnitario,
		pcorcamval.pc23_quant as quantidade,
		'000' as vlMinAlienBens
		FROM licitacao.liclicitem as liclicitem
		INNER JOIN licitacao.liclicitemlote as liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
		INNER JOIN licitacao.liclicita as liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
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
		AND liclicita.l20_codigo= $oDados10->seqlicitacao";	
    	        		
    	       $rsResult14 = db_query($sSql);
		       for ($iCont14 = 0; $iCont14 < pg_num_rows($rsResult14); $iCont14++) {
		             	
		         $claberlic142021 = new cl_aberlic142021();
		    	 $oDados14 = db_utils::fieldsMemory($rsResult14, $iCont14);
		    	 
		    	 $claberlic142021->si50_tiporegistro             	= 14;
		    	 $claberlic142021->si50_codorgaoresp             	= $oDados14->codorgaoresp;
		    	 $claberlic142021->si50_codunidadesubresp       	= $oDados14->codunidadesubresp;
		    	 $claberlic142021->si50_exerciciolicitacao   		= $oDados14->exerciciolicitacao;
		    	 $claberlic142021->si50_nroprocessolicitatorio		= $oDados14->nroprocessolicitatorio; 
		    	 $claberlic142021->si50_nrolote					 	= $oDados14->nrolote;
		    	 $claberlic142021->si50_reg10 				 	 	= $claberlic102021->si46_sequencial;// chave estrangeira
		    	 $claberlic142021->si50_coditem						= $oDados14->coditem;
		    	 $claberlic142021->si50_dtcotacao					= $oDados14->dtcotacao;
		    	 $claberlic142021->si50_vlcotprecosunitario			= $oDados14->vlcotprecosunitario;
		    	 $claberlic142021->si50_quantidade					= $oDados14->quantidade;
		    	 $claberlic142021->si50_vlminalienbens				= $oDados14->vlminalienbens;
		    	 $claberlic142021->si50_instit		   				   = db_getsession("DB_instit");
		    	 $claberlic142021->si50_mes                   	 	= $this->sDataFinal['5'].$this->sDataFinal['6'];
		    	 
		    	 
		       	 $claberlic142021->incluir(null);
		    	 if ($claberlic142021->erro_status == 0) {
		    	   throw new Exception($claberlic142021->erro_msg);
		    	 }
		    	}
		    	
		    	
		    	
	    $sSql="select '15' as tipoRegistro,
		db_config.db21_tipoinstit as codOrgaoResp,
		(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
		liclicita.l20_anousu as exercicioLicitacao,
		liclicita.l20_numero as nroProcessoLicitatorio,	
		liclicitemlote.l04_codigo as nroLote,
		pcmater.pc01_codmater as codItem,
		itemprecoreferencia.si02_vlprecoreferencia as vlItem	
		FROM licitacao.liclicitem as liclicitem
		INNER JOIN licitacao.liclicitemlote as liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
		INNER JOIN licitacao.liclicita as liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
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
		AND liclicita.l20_codigo= $oDados10->seqlicitacao";	
    		
    	                	
    	       $rsResult15 = db_query($sSql);
		       for ($iCont15 = 0; $iCont15 < pg_num_rows($rsResult15); $iCont15++) {
		             	
		         $claberlic152021 = new cl_aberlic152021();
		    	 $oDados15 = db_utils::fieldsMemory($rsResult15, $iCont15);
		    	 
		    	 $claberlic152021->si51_tiporegistro             	= 15;
		    	 $claberlic152021->si51_codorgaoresp             	= $oDados15->codorgaoresp;
		    	 $claberlic152021->si51_codunidadesubresp       	= $oDados15->codunidadesubresp;
		    	 $claberlic152021->si51_exerciciolicitacao   		= $oDados15->exerciciolicitacao;
		    	 $claberlic152021->si51_nroprocessolicitatorio		= $oDados15->nroprocessolicitatorio; 
		    	 $claberlic152021->si51_nrolote					 	= $oDados15->nrolote;
		    	 $claberlic152021->si51_reg10 				 	 	= $claberlic102021->si46_sequencial;// chave estrangeira
		    	 $claberlic152021->si51_coditem						= $oDados15->coditem;
		    	 $claberlic152021->si51_vlitem						= $oDados15->vlitem;
		    	 $claberlic152021->si51_instit		   				   = db_getsession("DB_instit");
		    	 $claberlic152021->si51_mes                   	 	= $this->sDataFinal['5'].$this->sDataFinal['6'];

		       	 $claberlic152021->incluir(null);
		    	 if ($claberlic152021->erro_status == 0) {
		    	   throw new Exception($claberlic152021->erro_msg);
		    	 }
		    	}
		    	
		    	
	    $sSql=" select '16' as tipoRegistro,
		db_config.db21_tipoinstit as codOrgaoResp,
		(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
		liclicita.l20_anousu as exercicioLicitacao,
		liclicita.l20_numero as nroProcessoLicitatorio,	
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
		INNER JOIN licitacao.liclicitem as liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
		INNER JOIN compras.pcprocitem as pcprocitem on (liclicitem.l21_codpcprocitem=pcprocitem.pc81_codprocitem)
		INNER JOIN compras.pcdotac as pcdotac on (pcprocitem.pc81_solicitem=pcdotac.pc13_codigo)
		INNER JOIN orcamento.orcdotacao as orcdotacao on (pcdotac.pc13_anousu=orcdotacao.o58_anousu and pcdotac.pc13_coddot=orcdotacao.o58_coddot)
		INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
		INNER JOIN orcamento.orctiporec as orctiporec on (orcdotacao.o58_codigo=orctiporec.o15_codigo)
		INNER JOIN orcamento.orcelemento as orcelemento on (orcdotacao.o58_anousu=orcelemento.o56_anousu and orcdotacao.o58_codele=orcelemento.o56_codele)
		WHERE db_config.codigo= " .db_getsession("DB_instit")."
		AND liclicita.l20_codigo= $oDados10->seqlicitacao";	
		
			
    	        
    	       $rsResult16 = db_query($sSql);
		       for ($iCont16 = 0; $iCont16 < pg_num_rows($rsResult16); $iCont16++) {
		             	
		         $claberlic162021 = new cl_aberlic162021();
		    	 $oDados16 = db_utils::fieldsMemory($rsResult16, $iCont16);
		    	 
		    	 $claberlic162021->si52_tiporegistro             	= 16;
		    	 $claberlic162021->si52_codorgaoresp             	= $oDados16->codorgaoresp;
		    	 $claberlic162021->si52_codunidadesubresp       	= $oDados16->codunidadesubresp;
		    	 $claberlic162021->si52_exerciciolicitacao   		= $oDados16->exerciciolicitacao;
		    	 $claberlic162021->si52_nroprocessolicitatorio		= $oDados16->nroprocessolicitatorio;
		    	 $claberlic162021->si52_codorgao					= $oDados16->codorgao;
		    	 $claberlic162021->si52_codunidadesub				= $oDados16->codunidadesub;
		    	 $claberlic162021->si52_codfuncao					= $oDados16->codfuncao;
		    	 $claberlic162021->si52_codsubfuncao				= $oDados16->codsubfuncao;
		    	 $claberlic162021->si52_codprograma					= $oDados16->codprograma;
		    	 $claberlic162021->si52_idacao						= $oDados16->idacao;
		    	 $claberlic162021->si52_idsubacao					= $oDados16->idsubacao;
		    	 $claberlic162021->si52_naturezadespesa				= $oDados16->naturezadespesa;
		    	 $claberlic162021->si52_codfontrecursos				= $oDados16->codfontrecursos;
		    	 $claberlic162021->si52_vlrecurso					= $oDados16->vlrecurso;
		    	 $claberlic162021->si52_reg10 				 	 	= $claberlic102021->si46_sequencial;// chave estrangeira
		    	 $claberlic162021->si52_instit		   				   = db_getsession("DB_instit");
		    	 $claberlic162021->si52_mes                   	 	= $this->sDataFinal['5'].$this->sDataFinal['6'];
		    		    	 
		       	 $claberlic162021->incluir(null);
		    	 if ($claberlic162021->erro_status == 0) {
		    	   throw new Exception($claberlic162021->erro_msg);
		    	 }
		    	}
	    }
	    
         
	db_fim_transacao();
    
    $oGerarABERLIC = new GerarABERLIC();
    $oGerarABERLIC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarABERLIC->gerarDados(); 
	    
	    
	}
	
}
