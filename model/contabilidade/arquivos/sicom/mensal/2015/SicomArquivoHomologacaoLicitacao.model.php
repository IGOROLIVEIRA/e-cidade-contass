<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("classes/db_homolic102015_classe.php");
require_once ("classes/db_homolic202015_classe.php");
require_once ("classes/db_homolic302015_classe.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2015/GerarHOMOLIC.model.php");

/**
  * Homologação da Licitação Sicom Acompanhamento Mensal
  * @author Johnatan Alves 
  * @package Contabilidade
  */
class SicomArquivoHomologacaoLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 158;
  
  /**
   * 
   * @var String
   * Nome do arquivo a ser criado
   */
  protected $sNomeArquivo = 'HOMOLIC';
  
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
    											"dscItem",
    											"Quantidade",
					    					  "vlHomologacao"					  
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
					    					  "percDesconto"
    										);
    $aElementos[30] = array(
    					            "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "exercicioLicitacao",
                          "nroProcessoLicitatorio",
					    					  "dtHomologacao",
					    					  "dtAdjudicacao"
    										);
    					
   
    					
    return $aElementos;
  }
  
  /**
   * Homologação da Licitação do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
  	
    $clhomolic10 = new cl_homolic102015();
  	$clhomolic20 = new cl_homolic202015();
  	$clhomolic30 = new cl_homolic302015();
  	
  	
  	db_inicio_transacao();
  	/*
  	 * excluir informacoes do mes selecionado registro 10
  	 */
    $result = $clhomolic10->sql_record($clhomolic10->sql_query(NULL,"*",NULL,"si63_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si63_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clhomolic10->excluir(NULL,"si63_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si63_instit=".db_getsession("DB_instit"));
      if ($clhomolic10->erro_status == 0) {
    	  throw new Exception($clhomolic10->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clhomolic20->sql_record($clhomolic20->sql_query(NULL,"*",NULL,"si64_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si64_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	
    	$clhomolic20->excluir(NULL,"si64_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si64_instit=".db_getsession("DB_instit"));
      if ($clhomolic20->erro_status == 0) {
    	  throw new Exception($clhomolic20->erro_msg);
      }
    }
  	
    /*
     * excluir informacoes do mes selecionado registro 30
     */
    $result = $clhomolic30->sql_record($clhomolic30->sql_query(NULL,"*",NULL,"si65_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si65_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clhomolic30->excluir(NULL,"si65_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si65_instit=".db_getsession("DB_instit"));
      if ($clhomolic30->erro_status == 0) {
    	  throw new Exception($clhomolic30->erro_msg);
      }
    }
  	
    /**
     * selecionar informacoes registro 10
     */
    
    $sSql="SELECT   distinct '10' as tipoRegistro,
	infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
	(SELECT CASE
    WHEN o41_subunidade != 0
         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
    ELSE lpad((CASE WHEN o40_codtri = '0'
         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
   END AS codunidadesub
   FROM db_departorg
   JOIN infocomplementares ON si08_anousu = db01_anousu
   AND si08_instit = ".db_getsession("DB_instit")."
   JOIN orcunidade ON db01_orgao=o41_orgao
   AND db01_unidade=o41_unidade
   AND db01_anousu = o41_anousu
   JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
   WHERE db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu")." LIMIT 1) as codUnidadeSubResp,
	liclicita.l20_anousu as exercicioLicitacao,
	liclicita.l20_edital as nroProcessoLicitatorio,
	(CASE length(cgm.z01_cgccpf) WHEN 11 THEN 1
		ELSE 2
	END) as tipoDocumento,
	cgm.z01_cgccpf as nroDocumento,
	CASE WHEN liclicita.l20_tipojulg = 3 THEN aberlic112015.si47_nrolote ELSE 0 END AS nroLote,
	(solicitempcmater.pc16_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) as codItem,
	pcorcamval.pc23_vlrun as vlUnitario,
	solicitem.pc11_quant as quantidade, 
	liclicita.l20_codigo as codlicitacao
	FROM liclicita as liclicita 
	INNER JOIN homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
	INNER JOIN liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
	INNER JOIN pcorcamitemlic ON (liclicitem.l21_codigo = pcorcamitemlic.pc26_liclicitem )      
	INNER JOIN pcorcamitem ON (pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem)      
	INNER JOIN pcorcamjulg ON (pcorcamitem.pc22_orcamitem = pcorcamjulg.pc24_orcamitem )
	INNER JOIN pcorcamforne ON (pcorcamjulg.pc24_orcamforne = pcorcamforne.pc21_orcamforne)
	INNER JOIN cgm ON (pcorcamforne.pc21_numcgm = cgm.z01_numcgm)
	INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
	INNER JOIN pcprocitem  ON (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
	INNER JOIN solicitem ON (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
	INNER JOIN solicitempcmater ON (solicitem.pc11_codigo=solicitempcmater.pc16_solicitem)    
	INNER JOIN pcorcamval ON (pcorcamitem.pc22_orcamitem = pcorcamval.pc23_orcamitem and pcorcamforne.pc21_orcamforne=pcorcamval.pc23_orcamforne)
	LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
  LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
  INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
	INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
	LEFT JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
	LEFT JOIN aberlic112015 on (liclicitemlote.l04_descricao = aberlic112015.si47_dsclote  and aberlic112015.si47_nroprocessolicitatorio = liclicita.l20_edital::varchar)
	LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
	WHERE db_config.codigo =".db_getsession("DB_instit")."
	AND DATE_PART('YEAR',homologacaoadjudica.l202_datahomologacao) =".db_getsession("DB_anousu")."
	AND DATE_PART('MONTH',homologacaoadjudica.l202_datahomologacao) =" .$this->sDataFinal['5'].$this->sDataFinal['6']."
	AND pctipocompratribunal.l44_sequencial IN ('48',
		                                                  '49',
		                                                  '50',
		                                                  '51',
		                                                  '52',
		                                                  '53',
		                                                  '54') order by liclicita.l20_edital";
   	 	
    	$rsResult10 = db_query($sSql);//db_criatabela($rsResult10);
    	$aLicitacoes = array();
    	$aDadosAgrupados = array();
    	for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
    		
    		$oResult10 = db_utils::fieldsMemory($rsResult10, $iCont10);
    		
    		$sHash = $oResult10->exerciciolicitacao.$oResult10->nroprocessolicitatorio.$oResult10->nrodocumento.$oResult10->nrolote.$oResult10->coditem;
    		if (!$aDadosAgrupados[$sHash]) {
    			
    		  $oDados10 = new stdClass();
    		  $oDados10->si63_tiporegistro	         = 10;
    		  $oDados10->si63_codorgao				       = $oResult10->codorgaoresp;
    		  $oDados10->si63_codunidadesub 		     = $oResult10->codunidadesubresp;
    		  $oDados10->si63_exerciciolicitacao     = $oResult10->exerciciolicitacao;
    		  $oDados10->si63_nroprocessolicitatorio = $oResult10->nroprocessolicitatorio;
    		  $oDados10->si63_tipodocumento 		     = $oResult10->tipodocumento;
    		  $oDados10->si63_nrodocumento 		       = $oResult10->nrodocumento;
    		  $oDados10->si63_nrolote				         = $oResult10->nrolote;
    		  $oDados10->si63_coditem				         = $oResult10->coditem;
    		  $oDados10->si63_vlunitariohomologado   = $oResult10->vlunitario;
    		  $oDados10->si63_quantidade 			       = $oResult10->quantidade;
    		  $oDados10->si63_instit		   		       = db_getsession("DB_instit");
    		  $oDados10->si63_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
    		  $aDadosAgrupados[$sHash] = $oDados10;
    		
    		} else {
    			$aDadosAgrupados[$sHash]->si63_quantidade += $oResult10->quantidade;
    		}
    	  if (!in_array($oResult10->codlicitacao, $aLicitacoes)) {
    		  $aLicitacoes[] = $oResult10->codlicitacao;
    		}
    		    		    		
    	}
    	
    	foreach ($aDadosAgrupados as $oDadosAgrupados) {
    		
    	  $clhomolic10 = new cl_homolic102015();
    		
    		$clhomolic10->si63_tiporegistro	          = $oDadosAgrupados->si63_tiporegistro;
    		$clhomolic10->si63_codorgao				        = $oDadosAgrupados->si63_codorgao;
    		$clhomolic10->si63_codunidadesub 		      = $oDadosAgrupados->si63_codunidadesub;
    		$clhomolic10->si63_exerciciolicitacao     = $oDadosAgrupados->si63_exerciciolicitacao;
    		$clhomolic10->si63_nroprocessolicitatorio = $oDadosAgrupados->si63_nroprocessolicitatorio;
    		$clhomolic10->si63_tipodocumento 		      = $oDadosAgrupados->si63_tipodocumento;
    		$clhomolic10->si63_nrodocumento 		      = $oDadosAgrupados->si63_nrodocumento;
    		$clhomolic10->si63_nrolote				        = $oDadosAgrupados->si63_nrolote;
    		$clhomolic10->si63_coditem				        = $oDadosAgrupados->si63_coditem;
    		$clhomolic10->si63_vlunitariohomologado   = $oDadosAgrupados->si63_vlunitariohomologado;
    		$clhomolic10->si63_quantidade 			      = $oDadosAgrupados->si63_quantidade;
    		$clhomolic10->si63_instit		   		        = $oDadosAgrupados->si63_instit;
    		$clhomolic10->si63_mes                    = $oDadosAgrupados->si63_mes;
    		    	
    		$clhomolic10->incluir(null);
    		if ($clhomolic10->erro_status == 0) {
    			throw new Exception($clhomolic10->erro_msg);
    		}
    		
    	}
    	
    /**
     * selecionar informacoes registro 20
     */
    	
    $sSql="SELECT   '20' as tipoRegistro,
	infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
	(SELECT CASE
    WHEN o41_subunidade != 0
         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
    ELSE lpad((CASE WHEN o40_codtri = '0'
         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
   END AS codunidadesub
   FROM db_departorg
   JOIN infocomplementares ON si08_anousu = db01_anousu
   AND si08_instit = ".db_getsession("DB_instit")."
   JOIN orcunidade ON db01_orgao=o41_orgao
   AND db01_unidade=o41_unidade
   AND db01_anousu = o41_anousu
   JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
   WHERE db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu")." LIMIT 1) as codUnidadeSubResp,
	liclicita.l20_anousu as exercicioLicitacao,
	liclicita.l20_edital as nroProcessoLicitatorio,
	(CASE length(cgm.z01_cgccpf) WHEN 11 THEN 1
		ELSE 2
	END) as tipoDocumento,
	cgm.z01_cgccpf as nroDocumento,
	aberlic112015.si47_nrolote as nroLote,
	(solicitempcmater.pc16_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) as codItem,
	descontotabela.l204_valor as percDesconto 
	FROM liclicita 
	INNER JOIN homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
	INNER JOIN liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
	INNER JOIN pcorcamitemlic ON (liclicitem.l21_codigo = pcorcamitemlic.pc26_liclicitem )      
	INNER JOIN pcorcamitem ON (pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem)      
	INNER JOIN pcorcamjulg ON (pcorcamitem.pc22_orcamitem = pcorcamjulg.pc24_orcamitem )
	INNER JOIN pcorcamforne ON (pcorcamjulg.pc24_orcamforne = pcorcamforne.pc21_orcamforne)
	INNER JOIN cgm ON (pcorcamforne.pc21_numcgm = cgm.z01_numcgm)
	INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
	INNER JOIN pcprocitem  ON (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
	INNER JOIN solicitem ON (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
	INNER JOIN solicitempcmater ON (solicitem.pc11_codigo=solicitempcmater.pc16_solicitem)    
	INNER JOIN pcorcamval ON (pcorcamitem.pc22_orcamitem = pcorcamval.pc23_orcamitem and pcorcamforne.pc21_orcamforne=pcorcamval.pc23_orcamforne)
	INNER JOIN descontotabela on (liclicita.l20_codigo=descontotabela.l204_licitacao
		and pcorcamforne.pc21_orcamforne=descontotabela.l204_fornecedor
		and descontotabela.l204_item=solicitempcmater.pc16_codmater)
	LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
  LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
	LEFT JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
	LEFT JOIN aberlic112015 on (liclicitemlote.l04_descricao = aberlic112015.si47_dsclote  and aberlic112015.si47_nroprocessolicitatorio = liclicita.l20_edital::varchar)
	LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
	WHERE db_config.codigo=".db_getsession("DB_instit")."
	AND liclicita.l20_codigo in (".implode(",", $aLicitacoes).")";
    
  	$rsResult20 = db_query($sSql);//db_criatabela($rsResult20);
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
    	
    	$clhomolic20 = new cl_homolic202015();
    	$oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);
    	
    	$clhomolic20->si64_tiporegistro            = 20;
    	$clhomolic20->si64_codorgao				   = $oDados20->codorgaoresp;
    	$clhomolic20->si64_codunidadesub 		   = $oDados20->codunidadesubresp;
    	$clhomolic20->si64_exerciciolicitacao      = $oDados20->exerciciolicitacao;
    	$clhomolic20->si64_nroprocessolicitatorio  = $oDados20->nroprocessolicitatorio;
    	$clhomolic20->si64_tipodocumento           = $oDados20->tipodocumento;
    	$clhomolic20->si64_nrodocumento            = $oDados20->nrodocumento;
    	$clhomolic20->si64_nrolote                 = $oDados20->nrolote;
    	$clhomolic20->si64_coditem                 = $oDados20->coditem;
    	$clhomolic20->si64_percdesconto            = $oDados20->percdesconto;
    	$clhomolic20->si64_instit		   		   = db_getsession("DB_instit");
    	$clhomolic20->si64_mes                     = $this->sDataFinal['5'].$this->sDataFinal['6'];
    	
    	$clhomolic20->incluir(null);
    	if ($clhomolic20->erro_status == 0) {
    		throw new Exception($clhomolic20->erro_msg);
    	}
    	
    }
    
    
    $sSql="SELECT   '30' as tipoRegistro,
	infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
	(SELECT CASE
    WHEN o41_subunidade != 0
         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
    ELSE lpad((CASE WHEN o40_codtri = '0'
         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
   END AS codunidadesub
   FROM db_departorg
   JOIN infocomplementares ON si08_anousu = db01_anousu
   AND si08_instit = ".db_getsession("DB_instit")."
   JOIN orcunidade ON db01_orgao=o41_orgao
   AND db01_unidade=o41_unidade
   AND db01_anousu = o41_anousu
   JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
   WHERE db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu")." LIMIT 1) as codUnidadeSubResp,
	liclicita.l20_anousu as exercicioLicitacao,
	liclicita.l20_edital as nroProcessoLicitatorio,
	homologacaoadjudica.l202_datahomologacao as dtHomologacao,
	(case when liclicita.l20_tipnaturezaproced = 2 then null else homologacaoadjudica.l202_dataadjudicacao end) as dtAdjudicacao
	FROM liclicita 
	INNER JOIN homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
	INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
	LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
	WHERE db_config.codigo= ".db_getsession("DB_instit")."
	AND liclicita.l20_codigo in (".implode(",", $aLicitacoes).")";
    
    
  $rsResult30 = db_query($sSql);
    for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {
    	
    	$clhomolic30 = new cl_homolic302015();
    	$oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);
    	
    	$clhomolic30->si65_tiporegistro            = 30;
    	$clhomolic30->si65_codorgao				   = $oDados30->codorgaoresp;
    	$clhomolic30->si65_codunidadesub 		   = $oDados30->codunidadesubresp;  		   
    	$clhomolic30->si65_exerciciolicitacao      = $oDados30->exerciciolicitacao;
    	$clhomolic30->si65_nroprocessolicitatorio  = $oDados30->nroprocessolicitatorio;
    	$clhomolic30->si65_dthomologacao 		   = $oDados30->dthomologacao;
    	$clhomolic30->si65_dtadjudicacao   		   = $oDados30->dtadjudicacao;
    	$clhomolic30->si65_instit		   		   = db_getsession("DB_instit");
    	$clhomolic30->si65_mes                     = $this->sDataFinal['5'].$this->sDataFinal['6'];
    	
    	$clhomolic30->incluir(null);
    	if ($clhomolic30->erro_status == 0) {
    		throw new Exception($clhomolic30->erro_msg);
    	}
    	
    }
    
    	
    	
    db_fim_transacao();
    
    $oGerarHOMOLIC = new GerarHOMOLIC();
    $oGerarHOMOLIC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarHOMOLIC->gerarDados();
		
  }
  
}
