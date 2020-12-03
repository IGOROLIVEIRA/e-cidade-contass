<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_julglic102021_classe.php");
require_once ("classes/db_julglic202121_classe.php");
require_once ("classes/db_julglic302021_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarJULGLIC.model.php");


 /**
  * Julgamento da Licitação Sicom Acompanhamento Mensal
  * @author Johnatan 
  * @package Contabilidade
  */
class SicomArquivoJulgamentoLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 157;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'JULGLIC';
  
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
						    					  "nroLote",
						    					  "nroItem",
						    					  "dscProdutoServico",
						    					  "vlUnitario",
						    					  "quantidade",
						    					  "unidade"   					  
                        );
    $aElementos[20] = array(
						    					  "tipoRegistro",
						                "codOrgao",
						                "codUnidadeSub",
						                "exercicioLicitacao",
						                "nroProcessoLicitatorio",
						    					  "tipoDocumento",
						    					  "nroDocumento",
												    "nroLote",
    												"nroItem",
												    "dscLote",
    												"dscItem",
												    "percDesconto"
    					);
    $aElementos[30] = array(
						    					  "tipoRegistro",
						                "codOrgao",
						                "codUnidadeSub",
						                "exercicioLicitacao",
						                "nroProcessoLicitatorio",
						    					  "dtJulgamento",
    												"PresencaLicitantes",
						    					  "renunciaRecurso"
    					);					
    return $aElementos;
  }
  
  /**
   * Julgamento da Licitação do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
  	/**
  	 * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo 
  	 */
  	$cljulglic102021 = new cl_julglic102021();
  	$cljulglic202121 = new cl_julglic202121();
  	$cljulglic302021 = new cl_julglic302021();
    
    /**
     * excluir informacoes do mes selecioado
     */
    db_inicio_transacao();
    $result = db_query($cljulglic102021->sql_query(NULL,"*",NULL,"si60_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si60_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$cljulglic102021->excluir(NULL,"si60_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si60_instit=".db_getsession("DB_instit"));
      if ($cljulglic102021->erro_status == 0) {
    	  throw new Exception($cljulglic102021->erro_msg);
      }
    }
    
    $result = db_query($cljulglic202121->sql_query(NULL,"*",NULL,"si61_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si61_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$cljulglic202121->excluir(NULL,"si61_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si61_instit=".db_getsession("DB_instit"));
      if ($cljulglic202121->erro_status == 0) {
    	  throw new Exception($cljulglic202121->erro_msg);
      }
    }
    
    $result = db_query($cljulglic302021->sql_query(NULL,"*",NULL,"si62_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si62_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$cljulglic302021->excluir(NULL,"si62_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si62_instit=".db_getsession("DB_instit"));
      if ($cljulglic302021->erro_status == 0) {
    	  throw new Exception($cljulglic302021->erro_msg);
      }
    }
    
    
    $sSql = "SELECT   '10' as tipoRegistro,
	db_config.db21_tipoinstit as codOrgaoResp,
	(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
	liclicita.l20_anousu as exercicioLicitacao,
	liclicita.l20_numero as nroProcessoLicitatorio,
	(CASE length(cgm.z01_cgccpf) WHEN 11 THEN 1
		ELSE 2
	END) as tipoDocumento,
	cgm.z01_cgccpf as nroDocumento,
	liclicitemlote.l04_codigo as nroLote,
	solicitempcmater.pc16_codmater as codItem,
	pcorcamval.pc23_vlrun as vlUnitario,
	pcorcamval.pc23_quant as quantidade,
	l20_codigo as codlicitacao 
	FROM liclicita as liclicita 
	INNER JOIN homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
	INNER JOIN liclicitem as liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
	INNER JOIN pcorcamitemlic as pcorcamitemlic ON (liclicitem.l21_codigo = pcorcamitemlic.pc26_liclicitem )      
	INNER JOIN compras.pcorcamitem as pcorcamitem ON (pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem)      
	INNER JOIN compras.pcorcamjulg as pcorcamjulg ON (pcorcamitem.pc22_orcamitem = pcorcamjulg.pc24_orcamitem )
	INNER JOIN compras.pcorcamforne as pcorcamforne ON (pcorcamjulg.pc24_orcamforne = pcorcamforne.pc21_orcamforne)
	INNER JOIN protocolo.cgm as cgm ON (pcorcamforne.pc21_numcgm = cgm.z01_numcgm)
	INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
	INNER JOIN compras.pcprocitem as pcprocitem  ON (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
	INNER JOIN compras.solicitem as solicitem ON (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
	INNER JOIN compras.solicitempcmater as solicitempcmater ON (solicitem.pc11_codigo=solicitempcmater.pc16_solicitem)    
	INNER JOIN compras.pcorcamval as pcorcamval ON (pcorcamitem.pc22_orcamitem = pcorcamval.pc23_orcamitem and pcorcamforne.pc21_orcamforne=pcorcamval.pc23_orcamforne)
	INNER JOIN liclicitemlote as liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem) 
	WHERE db_config.codigo= " .db_getsession("DB_instit")."
	AND DATE_PART('YEAR',homologacaoadjudica.l202_datahomologacao)=".db_getsession("DB_anousu")."
	AND DATE_PART('MONTH',homologacaoadjudica.l202_datahomologacao)= ".$this->sDataFinal['5'].$this->sDataFinal['6'];
		  
		$rsResult10 = db_query($sSql); 
		/**
		 * registro 10
		 */
		for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
		  	
		  $cljulglic102021 = new cl_julglic102021();
		  $oDados10       = db_utils::fieldsMemory($rsResult10, $iCont10);
		  	
			$cljulglic102021->si60_tiporegistro   		  = 10;
			$cljulglic102021->si60_codorgao	 			  = $oDados10->codorgaoresp;
			$cljulglic102021->si60_codunidadesub	      = $oDados10->codunidadesubresp;
			$cljulglic102021->si60_exerciciolicitacao	  = $oDados10->exerciciolicitacao;
			$cljulglic102021->si60_nroprocessolicitatorio = $oDados10->nroprocessolicitatorio;
			$cljulglic102021->si60_tipodocumento		  = $oDados10->tipodocumento;
			$cljulglic102021->si60_nrodocumento			  = $oDados10->nrodocumento;
			$cljulglic102021->si60_nrolote				  = $oDados10->nrolote;
			$cljulglic102021->si60_coditem				  = $oDados10->coditem;
			$cljulglic102021->si60_vlunitario	          = $oDados10->vlunitario;
			$cljulglic102021->si60_quantidade	          = $oDados10->quantidade;
			$cljulglic102021->si60_instit		   		  = db_getsession("DB_instit");
		 	$cljulglic102021->si60_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  	
		  $cljulglic102021->incluir(null);
		  if ($cljulglic102021->erro_status == 0) {
		    throw new Exception($cljulglic102021->erro_msg);
		  }
		  	
		}
		  
	$sSql = "SELECT   '20' as tipoRegistro,
	db_config.db21_tipoinstit as codOrgaoResp,
	(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
	liclicita.l20_anousu as exercicioLicitacao,
	liclicita.l20_numero as nroProcessoLicitatorio,
	(CASE length(cgm.z01_cgccpf) WHEN 11 THEN 1
		ELSE 2
	END) as tipoDocumento,
	cgm.z01_cgccpf as nroDocumento,
	liclicitemlote.l04_codigo as nroLote,
	solicitempcmater.pc16_codmater as codItem,
	descontotabela.l204_valor as percDesconto 
	FROM liclicita as liclicita 
	INNER JOIN homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
	INNER JOIN liclicitem as liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
	INNER JOIN pcorcamitemlic as pcorcamitemlic ON (liclicitem.l21_codigo = pcorcamitemlic.pc26_liclicitem )      
	INNER JOIN compras.pcorcamitem as pcorcamitem ON (pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem)      
	INNER JOIN compras.pcorcamjulg as pcorcamjulg ON (pcorcamitem.pc22_orcamitem = pcorcamjulg.pc24_orcamitem )
	INNER JOIN compras.pcorcamforne as pcorcamforne ON (pcorcamjulg.pc24_orcamforne = pcorcamforne.pc21_orcamforne)
	INNER JOIN protocolo.cgm as cgm ON (pcorcamforne.pc21_numcgm = cgm.z01_numcgm)
	INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
	INNER JOIN compras.pcprocitem as pcprocitem  ON (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
	INNER JOIN compras.solicitem as solicitem ON (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
	INNER JOIN compras.solicitempcmater as solicitempcmater ON (solicitem.pc11_codigo=solicitempcmater.pc16_solicitem)    
	INNER JOIN compras.pcorcamval as pcorcamval ON (pcorcamitem.pc22_orcamitem = pcorcamval.pc23_orcamitem and pcorcamforne.pc21_orcamforne=pcorcamval.pc23_orcamforne)
	INNER JOIN liclicitemlote as liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
	INNER JOIN descontotabela as descontotabela on (liclicita.l20_codigo=descontotabela.l204_licitacao
	and pcorcamforne.pc21_orcamforne=descontotabela.l204_fornecedor
	and descontotabela.l204_item=liclicitem.l21_codigo)
	WHERE db_config.codigo= " .db_getsession("DB_instit")."
	AND liclicita.l20_codigo = {$oDados10->codlicitacao}";
		
		$rsResult20 = db_query($sSql); 
		/**
		 * registro 20
		 */
		for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
		  	
		  $cljulglic202121 = new cl_julglic202121();
		  $oDados20       = db_utils::fieldsMemory($rsResult20, $iCont20);
		  	
		  $cljulglic202121->si61_tiporegistro        	= 20;
		  $cljulglic202121->si61_codorgao            	= $oDados20->codorgaoresp;
		  $cljulglic202121->si61_codunidadesub		 	= $oDados20->codunidadesubresp;
		  $cljulglic202121->si61_exerciciolicitacao	 	= $oDados20->exerciciolicitacao;
		  $cljulglic202121->si61_nroprocessolicitatorio	= $oDados20->nroprocessolicitatorio;
		  $cljulglic202121->si61_tipodocumento   		= $oDados20->tipodocumento;
		  $cljulglic202121->si61_nrodocumento   		= $oDados20->nrodocumento;
		  $cljulglic202121->si61_nrolote  			    = $oDados20->nrolote;
		  $cljulglic202121->si61_coditem				= $oDados20->coditem;
		  $cljulglic202121->si61_percdesconto			= $oDados20->percdesconto;
		  $cljulglic202121->si61_instit		   		    = db_getsession("DB_instit");
		  $cljulglic202121->si61_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  	
		  $cljulglic202121->incluir(null);
		  if ($cljulglic202121->erro_status == 0) {
		    throw new Exception($cljulglic202121->erro_msg);
		  }
		  	
		}
		  
		  
	$sSql = " SELECT   '30' as tipoRegistro,
	db_config.db21_tipoinstit as codOrgaoResp,
	(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
	liclicita.l20_anousu as exercicioLicitacao,
	liclicita.l20_numero as nroProcessoLicitatorio,
	liclicitasituacao.l11_data as dtJulgamento,
	'1' as PresencaLicitantes,
	pc31_renunrecurso as renunciaRecurso
	FROM liclicita as liclicita 
	INNER JOIN homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
	INNER JOIN liclicitasituacao as liclicitasituacao on (liclicita.l20_codigo = liclicitasituacao.l11_liclicita)
	INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
	LEFT  JOIN  pcorcamfornelic on liclicita.l20_codigo=pcorcamfornelic.pc31_liclicita
	WHERE db_config.codigo= " .db_getsession("DB_instit")."
	AND liclicita.l20_codigo = {$oDados10->codlicitacao}";
		
		$rsResult30 = db_query($sSql);
		
		for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {
		  	
		  $cljulglic302021 = new cl_julglic302021();
		  $oDados30       = db_utils::fieldsMemory($rsResult30, $iCont30);
		  	
		  $cljulglic302021->si62_tiporegistro     		= 30;
		  $cljulglic302021->si62_codorgao 				=$oDados30->codorgaoresp;
		  $cljulglic302021->si62_codunidadesub 			=$oDados30->codunidadesubresp;
		  $cljulglic302021->si62_exerciciolicitacao 	=$oDados30->exerciciolicitacao;
		  $cljulglic302021->si62_nroprocessolicitatorio =$oDados30->nroprocessolicitatorio;
		  $cljulglic302021->si62_dtjulgamento 			=$oDados30->dtjulgamento;
		  $cljulglic302021->si62_presencalicitantes 	=$oDados30->presencalicitantes;
		  $cljulglic302021->si62_renunciarecurso		=$oDados30->renunciarecurso;
		  $cljulglic302021->si62_instit		   		    = db_getsession("DB_instit");
		  $cljulglic302021->si62_mes              		= $this->sDataFinal['5'].$this->sDataFinal['6'];
		  	
		  $cljulglic302021->incluir(null);
		  if ($cljulglic302021->erro_status == 0) {
		    throw new Exception($cljulglic302021->erro_msg);
		  }
		  	
		}
    
    db_fim_transacao();
    
    $oGerarJULGLIC = new GerarJULGLIC();
    $oGerarJULGLIC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarJULGLIC->gerarDados();
    
  }
}			
