<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("classes/db_homolic102024_classe.php");
require_once ("classes/db_homolic202024_classe.php");
require_once ("classes/db_homolic302023_classe.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarHOMOLIC.model.php");

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

    $clhomolic102024 = new cl_homolic102024();
  	$clhomolic202024 = new cl_homolic202024();
  	$clhomolic302023 = new cl_homolic302023();


  	db_inicio_transacao();
  	/*
  	 * excluir informacoes do mes selecionado registro 10
  	 */
    $result = $clhomolic102024->sql_record($clhomolic102024->sql_query(NULL,"*",NULL,"si63_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si63_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clhomolic102024->excluir(NULL,"si63_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si63_instit=".db_getsession("DB_instit"));
      if ($clhomolic102024->erro_status == 0) {
    	  throw new Exception($clhomolic102024->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clhomolic202024->sql_record($clhomolic202024->sql_query(NULL,"*",NULL,"si64_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si64_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {

    	$clhomolic202024->excluir(NULL,"si64_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si64_instit=".db_getsession("DB_instit"));
      if ($clhomolic202024->erro_status == 0) {
    	  throw new Exception($clhomolic202024->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 30
     */
    $result = $clhomolic302023->sql_record($clhomolic302023->sql_query(NULL,"*",NULL,"si65_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si65_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clhomolic302023->excluir(NULL,"si65_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si65_instit=".db_getsession("DB_instit"));
      if ($clhomolic302023->erro_status == 0) {
    	  throw new Exception($clhomolic302023->erro_msg);
      }
    }

    /**
     * selecionar informacoes registro 10
     */

    $sSql="SELECT   '10' as tipoRegistro,
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
	solicitem.pc11_quant as quantidade,
	liclicita.l20_codigo as codlicitacao
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
	LEFT JOIN liclicitemlote as liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
	WHERE db_config.codigo =".db_getsession("DB_instit")."
	AND DATE_PART('YEAR',homologacaoadjudica.l202_datahomologacao) =".db_getsession("DB_anousu")."
	AND DATE_PART('MONTH',homologacaoadjudica.l202_datahomologacao) =" .$this->sDataFinal['5'].$this->sDataFinal['6']."";

    	$rsResult10 = db_query($sSql);
    	for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

    		$clhomolic102024 = new cl_homolic102024();
    		$oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

    		$clhomolic102024->si63_tiporegistro	           = 10;
    		$clhomolic102024->si63_codorgao				   =$oDados10->codorgaoresp;
    		$clhomolic102024->si63_codunidadesub 		   =$oDados10->codunidadesubresp;
    		$clhomolic102024->si63_exerciciolicitacao      =$oDados10->exerciciolicitacao;
    		$clhomolic102024->si63_nroprocessolicitatorio  =$oDados10->nroprocessolicitatorio;
    		$clhomolic102024->si63_tipodocumento 		   =$oDados10->tipodocumento;
    		$clhomolic102024->si63_nrodocumento 		   =$oDados10->nrodocumento;
    		$clhomolic102024->si63_nrolote				   =$oDados10->nrolote;
    		$clhomolic102024->si63_coditem				   =$oDados10->coditem;
    		$clhomolic102024->si63_vlunitariohomologado    =$oDados10->vlunitario;
    		$clhomolic102024->si63_quantidade 			   =$oDados10->quantidade;
    		$clhomolic102024->si63_instit		   		   = db_getsession("DB_instit");
    		$clhomolic102024->si63_mes                     = $this->sDataFinal['5'].$this->sDataFinal['6'];

    		$clhomolic102024->incluir(null);
    		if ($clhomolic102024->erro_status == 0) {
    			throw new Exception($clhomolic102024->erro_msg);
    		}

    	}

    /**
     * selecionar informacoes registro 20
     */

    $sSql="SELECT   '20' as tipoRegistro,
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
	INNER JOIN descontotabela as descontotabela on (liclicita.l20_codigo=descontotabela.l204_licitacao
		and pcorcamforne.pc21_orcamforne=descontotabela.l204_fornecedor
		and descontotabela.l204_item=liclicitem.l21_codigo)
	LEFT JOIN liclicitemlote as liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
	WHERE db_config.codigo=".db_getsession("DB_instit")."
	AND liclicita.l20_codigo= $oDados10->codlicitacao";

  	$rsResult20 = db_query($sSql);
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

    	$clhomolic202024 = new cl_homolic202024();
    	$oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

    	$clhomolic202024->si64_tiporegistro            = 20;
    	$clhomolic202024->si64_codorgao				   = $oDados20->codorgaoresp;
    	$clhomolic202024->si64_codunidadesub 		   = $oDados20->codunidadesubresp;
    	$clhomolic202024->si64_exerciciolicitacao      = $oDados20->exerciciolicitacao;
    	$clhomolic202024->si64_nroprocessolicitatorio  = $oDados20->nroprocessolicitatorio;
    	$clhomolic202024->si64_tipodocumento           = $oDados20->tipodocumento;
    	$clhomolic202024->si64_nrodocumento            = $oDados20->nrodocumento;
    	$clhomolic202024->si64_nrolote                 = $oDados20->nrolote;
    	$clhomolic202024->si64_coditem                 = $oDados20->coditem;
    	$clhomolic202024->si64_percdesconto            = $oDados20->percdesconto;
    	$clhomolic202024->si64_instit		   		   = db_getsession("DB_instit");
    	$clhomolic202024->si64_mes                     = $this->sDataFinal['5'].$this->sDataFinal['6'];

    	$clhomolic202024->incluir(null);
    	if ($clhomolic202024->erro_status == 0) {
    		throw new Exception($clhomolic202024->erro_msg);
    	}

    }


    $sSql="SELECT   '30' as tipoRegistro,
	db_config.db21_tipoinstit as codOrgaoResp,
	(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
	liclicita.l20_anousu as exercicioLicitacao,
	liclicita.l20_numero as nroProcessoLicitatorio,
	homologacaoadjudica.l202_datahomologacao as dtHomologacao,
	homologacaoadjudica.l202_dataadjudicacao as dtAdjudicacao
	FROM liclicita as liclicita
	INNER JOIN homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
	INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
	WHERE db_config.codigo= ".db_getsession("DB_instit")."
	AND liclicita.l20_codigo= $oDados10->codlicitacao";


  $rsResult30 = db_query($sSql);
    for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {

    	$clhomolic302023 = new cl_homolic302023();
    	$oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);

    	$clhomolic302023->si65_tiporegistro            = 30;
    	$clhomolic302023->si65_codorgao				   = $oDados30->codorgaoresp;
    	$clhomolic302023->si65_codunidadesub 		   = $oDados30->codunidadesubresp;
    	$clhomolic302023->si65_exerciciolicitacao      = $oDados30->exerciciolicitacao;
    	$clhomolic302023->si65_nroprocessolicitatorio  = $oDados30->nroprocessolicitatorio;
    	$clhomolic302023->si65_dthomologacao 		   = $oDados30->dthomologacao;
    	$clhomolic302023->si65_dtadjudicacao   		   = $oDados30->dtadjudicacao;
    	$clhomolic302023->si65_instit		   		   = db_getsession("DB_instit");
    	$clhomolic302023->si65_mes                     = $this->sDataFinal['5'].$this->sDataFinal['6'];

    	$clhomolic302023->incluir(null);
    	if ($clhomolic302023->erro_status == 0) {
    		throw new Exception($clhomolic302023->erro_msg);
    	}

    }



    db_fim_transacao();

    $oGerarHOMOLIC = new GerarHOMOLIC();
    $oGerarHOMOLIC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarHOMOLIC->gerarDados();

  }

}
