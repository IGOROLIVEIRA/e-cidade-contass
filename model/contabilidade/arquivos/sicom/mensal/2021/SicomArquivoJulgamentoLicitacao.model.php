<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_julglic102021_classe.php");
require_once("classes/db_julglic202021_classe.php");
require_once("classes/db_julglic302021_classe.php");
require_once("classes/db_julglic402021_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarJULGLIC.model.php");


/**
 * Julgamento da Licitação Sicom Acompanhamento Mensal
 * @author Marcelo
 * @package Contabilidade
 */
class SicomArquivoJulgamentoLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV
{

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
	public function __construct()
	{ }

	/**
	 * Retorna o codigo do layout
	 *
	 * @return Integer
	 */
	public function getCodigoLayout()
	{
		return $this->iCodigoLayout;
	}

	/**
	 *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
	 */
	public function getCampos()
	{

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
		$aElementos[40] = array(
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
	public function gerarDados()
	{
		/**
		 * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
		 */
		$cljulglic10 = new cl_julglic102021();
		$cljulglic20 = new cl_julglic202021();
		$cljulglic30 = new cl_julglic302021();
		$cljulglic40 = new cl_julglic402021();

		/**
		 * excluir informacoes do mes selecioado
		 */
		db_inicio_transacao();
		$result = db_query($cljulglic10->sql_query(null, "*", null, "si60_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si60_instit=" . db_getsession("DB_instit")));
		if (pg_num_rows($result) > 0) {
			$cljulglic10->excluir(null, "si60_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si60_instit=" . db_getsession("DB_instit"));
			if ($cljulglic10->erro_status == 0) {
				throw new Exception($cljulglic10->erro_msg);
			}
		}

		$result = db_query($cljulglic20->sql_query(null, "*", null, "si61_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si61_instit=" . db_getsession("DB_instit")));
		if (pg_num_rows($result) > 0) {
			$cljulglic20->excluir(null, "si61_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si61_instit=" . db_getsession("DB_instit"));
			if ($cljulglic20->erro_status == 0) {
				throw new Exception($cljulglic20->erro_msg);
			}
		}

		$result = db_query($cljulglic30->sql_query(null, "*", null, "si62_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si62_instit=" . db_getsession("DB_instit")));
		if (pg_num_rows($result) > 0) {
			$cljulglic30->excluir(null, "si62_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si62_instit=" . db_getsession("DB_instit"));
			if ($cljulglic30->erro_status == 0) {
				throw new Exception($cljulglic30->erro_msg);
			}
		}

		$result = db_query($cljulglic40->sql_query(null, "*", null, "si62_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si62_instit=" . db_getsession("DB_instit")));
		if (pg_num_rows($result) > 0) {
			$cljulglic40->excluir(null, "si62_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si62_instit=" . db_getsession("DB_instit"));
			if ($cljulglic40->erro_status == 0) {
				throw new Exception($cljulglic40->erro_msg);
			}
		}
		db_fim_transacao();


		db_inicio_transacao();
		$sSql = "SELECT distinct '10' as tipoRegistro,
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
   AND si08_instit = " . db_getsession("DB_instit") . "
   JOIN orcunidade ON db01_orgao=o41_orgao
   AND db01_unidade=o41_unidade
   AND db01_anousu = o41_anousu
   JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
   WHERE db01_coddepto=l20_codepartamento and db01_anousu=" . db_getsession("DB_anousu") . " LIMIT 1) as codUnidadeSubResp,
	liclicita.l20_anousu as exercicioLicitacao,
	liclicita.l20_edital as nroProcessoLicitatorio,
	(CASE length(cgm.z01_cgccpf) WHEN 11 THEN 1
		ELSE 2
	END) as tipoDocumento,
	cgm.z01_cgccpf as nroDocumento,
	CASE WHEN liclicita.l20_tipojulg = 3 THEN aberlic112021.si47_nrolote  ELSE 0 END AS nroLote,
	(solicitempcmater.pc16_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) as codItem,
	pcorcamval.pc23_vlrun as vlUnitario,
	pcorcamval.pc23_quant as quantidade,
  l20_codigo as codlicitacao,
  aberlic102021.si46_criterioadjudicacao as criterioadjudicacao
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
  LEFT  JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
  LEFT JOIN aberlic102021 on (aberlic102021.si46_nroprocessolicitatorio = liclicita.l20_edital::varchar)
	LEFT JOIN aberlic112021 on (liclicitemlote.l04_descricao = aberlic112021.si47_dsclote and aberlic112021.si47_nroprocessolicitatorio = liclicita.l20_edital::varchar)
	LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
  LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
  INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
	INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
	LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
	WHERE db_config.codigo= " . db_getsession("DB_instit") . "
	AND DATE_PART('YEAR',homologacaoadjudica.l202_datahomologacao)=" . db_getsession("DB_anousu") . "
	AND DATE_PART('MONTH',homologacaoadjudica.l202_datahomologacao)= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
	AND pctipocompratribunal.l44_sequencial IN ('48',
		                                                  '49',
		                                                  '50',
		                                                  '51',
		                                                  '52',
		                                                  '53',
		                                                  '54')";

		$rsResult10 = db_query($sSql);
		/**
		 * registro 10
		 */
		$aLicitacoes = array();
		$aDadosAgrupados10 = array();
		for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

			$oResult10 = db_utils::fieldsMemory($rsResult10, $iCont10);
			$sHash10 = $oResult10->exerciciolicitacao . $oResult10->nroprocessolicitatorio . $oResult10->nrodocumento . $oResult10->nrolote . $oResult10->coditem;

			if (!$aDadosAgrupados10[$sHash10]) {

				if ($oResult10->criterioadjudicacao == 3) {
					$oDados10 = new stdClass();

					$oDados10->si60_tiporegistro = 10;
					$oDados10->si60_codorgao = $oResult10->codorgaoresp;
					$oDados10->si60_codunidadesub = $oResult10->codunidadesubresp;
					$oDados10->si60_exerciciolicitacao = $oResult10->exerciciolicitacao;
					$oDados10->si60_nroprocessolicitatorio = $oResult10->nroprocessolicitatorio;
					$oDados10->si60_tipodocumento = $oResult10->tipodocumento;
					$oDados10->si60_nrodocumento = $oResult10->nrodocumento;
					$oDados10->si60_nrolote = $oResult10->nrolote;
					$oDados10->si60_coditem = $oResult10->coditem;
					$oDados10->si60_vlunitario = $oResult10->vlunitario;
					$oDados10->si60_quantidade = $oResult10->quantidade;
					$oDados10->si60_instit = db_getsession("DB_instit");
					$oDados10->si60_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

					$aDadosAgrupados10[$sHash10] = $oDados10;
				}

				if (!in_array($oResult10->codlicitacao, $aLicitacoes)) {
					$aLicitacoes[] = $oResult10->codlicitacao;
				}
			} else {
				$aDadosAgrupados10[$sHash10]->si60_quantidade += $oResult10->quantidade;
			}
		}

		foreach ($aDadosAgrupados10 as $oDadosAgrupados10) {

			$cljulglic10 = new cl_julglic102021();

			$cljulglic10->si60_tiporegistro = $oDadosAgrupados10->si60_tiporegistro;
			$cljulglic10->si60_codorgao = $oDadosAgrupados10->si60_codorgao;
			$cljulglic10->si60_codunidadesub = $oDadosAgrupados10->si60_codunidadesub;
			$cljulglic10->si60_exerciciolicitacao = $oDadosAgrupados10->si60_exerciciolicitacao;
			$cljulglic10->si60_nroprocessolicitatorio = $oDadosAgrupados10->si60_nroprocessolicitatorio;
			$cljulglic10->si60_tipodocumento = $oDadosAgrupados10->si60_tipodocumento;
			$cljulglic10->si60_nrodocumento = $oDadosAgrupados10->si60_nrodocumento;
			$cljulglic10->si60_nrolote = $oDadosAgrupados10->si60_nrolote;
			$cljulglic10->si60_coditem = $oDadosAgrupados10->si60_coditem;
			$cljulglic10->si60_vlunitario = $oDadosAgrupados10->si60_vlunitario;
			$cljulglic10->si60_quantidade = $oDadosAgrupados10->si60_quantidade;
			$cljulglic10->si60_instit = $oDadosAgrupados10->si60_instit;
			$cljulglic10->si60_mes = $oDadosAgrupados10->si60_mes;

			$cljulglic10->incluir(null);
			if ($cljulglic10->erro_status == 0) {
				throw new Exception($cljulglic10->erro_msg);
			}
		}

		$sSql = "SELECT   '20' as tipoRegistro,
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
   AND si08_instit = " . db_getsession("DB_instit") . "
   JOIN orcunidade ON db01_orgao=o41_orgao
   AND db01_unidade=o41_unidade
   AND db01_anousu = o41_anousu
   JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
   WHERE db01_coddepto=l20_codepartamento and db01_anousu=" . db_getsession("DB_anousu") . " LIMIT 1) as codUnidadeSubResp,
	liclicita.l20_anousu as exercicioLicitacao,
	liclicita.l20_edital as nroProcessoLicitatorio,
	(CASE length(cgm.z01_cgccpf) WHEN 11 THEN 1
		ELSE 2
	END) as tipoDocumento,
	cgm.z01_cgccpf as nroDocumento,
	aberlic112021.si47_nrolote as nroLote,
	(solicitempcmater.pc16_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) as codItem,
  pcorcamval.pc23_perctaxadesctabela as percDesconto,
  aberlic102021.si46_criterioadjudicacao as criterioadjudicacao
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
  LEFT  JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
  LEFT JOIN aberlic102021 on (aberlic102021.si46_nroprocessolicitatorio = liclicita.l20_edital::varchar)
	LEFT JOIN aberlic112021 on (liclicitemlote.l04_descricao = aberlic112021.si47_dsclote and aberlic112021.si47_nroprocessolicitatorio = liclicita.l20_edital::varchar)
	LEFT JOIN descontotabela on (liclicita.l20_codigo=descontotabela.l204_licitacao
	and pcorcamforne.pc21_orcamforne=descontotabela.l204_fornecedor
	and descontotabela.l204_item=solicitempcmater.pc16_codmater)
	LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
  LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
	LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
	WHERE db_config.codigo = " . db_getsession("DB_instit") . "
	AND aberlic102021.si46_criterioadjudicacao = 1 AND liclicita.l20_codigo in (" . implode(",", $aLicitacoes) . ")";

		if (count($aLicitacoes) > 0) {
			$rsResult20 = db_query($sSql);
		}
		/**
		 * registro 20
		 */
		$aDadosAgrupados20 = array();
		for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

			$oResult20 = db_utils::fieldsMemory($rsResult20, $iCont20);

			if ($oResult20->criterioadjudicacao == 1) {
				$sHash20 = $oResult20->exerciciolicitacao . $oResult20->nroprocessolicitatorio . $oResult20->nrodocumento . $oResult20->nrolote . $oResult20->coditem;

				if (!$aDadosAgrupados20[$sHash20]) {

					$oDados20 = new stdClass();

					$oDados20->si61_tiporegistro = 20;
					$oDados20->si61_codorgao = $oResult20->codorgaoresp;
					$oDados20->si61_codunidadesub = $oResult20->codunidadesubresp;
					$oDados20->si61_exerciciolicitacao = $oResult20->exerciciolicitacao;
					$oDados20->si61_nroprocessolicitatorio = $oResult20->nroprocessolicitatorio;
					$oDados20->si61_tipodocumento = $oResult20->tipodocumento;
					$oDados20->si61_nrodocumento = $oResult20->nrodocumento;
					$oDados20->si61_nrolote = $oResult20->nrolote;
					$oDados20->si61_coditem = $oResult20->coditem;
					$oDados20->si61_percdesconto = $oResult20->percdesconto;
					$oDados20->si61_instit = db_getsession("DB_instit");
					$oDados20->si61_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
					$aDadosAgrupados20[$sHash20] = $oDados20;
				}
			}
		}

		foreach ($aDadosAgrupados20 as $oDadosAgrupados20) {

			$cljulglic20 = new cl_julglic202021();

			$cljulglic20->si61_tiporegistro = $oDadosAgrupados20->si61_tiporegistro;
			$cljulglic20->si61_codorgao = $oDadosAgrupados20->si61_codorgao;
			$cljulglic20->si61_codunidadesub = $oDadosAgrupados20->si61_codunidadesub;
			$cljulglic20->si61_exerciciolicitacao = $oDadosAgrupados20->si61_exerciciolicitacao;
			$cljulglic20->si61_nroprocessolicitatorio = $oDadosAgrupados20->si61_nroprocessolicitatorio;
			$cljulglic20->si61_tipodocumento = $oDadosAgrupados20->si61_tipodocumento;
			$cljulglic20->si61_nrodocumento = $oDadosAgrupados20->si61_nrodocumento;
			$cljulglic20->si61_nrolote = $oDadosAgrupados20->si61_nrolote;
			$cljulglic20->si61_coditem = $oDadosAgrupados20->si61_coditem;
			$cljulglic20->si61_percdesconto = $oDadosAgrupados20->si61_percdesconto;
			$cljulglic20->si61_instit = $oDadosAgrupados20->si61_instit;
			$cljulglic20->si61_mes = $oDadosAgrupados20->si61_mes;

			$cljulglic20->incluir(null);
			if ($cljulglic20->erro_status == 0) {
				throw new Exception($cljulglic20->erro_msg);
			}
		}

		$sSql = "SELECT '30' as tipoRegistro,
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
   AND si08_instit = " . db_getsession("DB_instit") . "
   JOIN orcunidade ON db01_orgao=o41_orgao
   AND db01_unidade=o41_unidade
   AND db01_anousu = o41_anousu
   JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
   WHERE db01_coddepto=l20_codepartamento and db01_anousu=" . db_getsession("DB_anousu") . " LIMIT 1) as codUnidadeSubResp,
  liclicita.l20_anousu as exercicioLicitacao,
  liclicita.l20_edital as nroProcessoLicitatorio,
  (CASE length(cgm.z01_cgccpf) WHEN 11 THEN 1
    ELSE 2
  END) as tipoDocumento,
  cgm.z01_cgccpf as nroDocumento,
  aberlic112021.si47_nrolote as nroLote,
  (solicitempcmater.pc16_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) as codItem,
  pcorcamval.pc23_percentualdesconto as perctaxaadm,
  aberlic102021.si46_criterioadjudicacao as criterioadjudicacao
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
  LEFT  JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
  LEFT JOIN aberlic102021 on (aberlic102021.si46_nroprocessolicitatorio = liclicita.l20_edital::varchar)
  LEFT JOIN aberlic112021 on (liclicitemlote.l04_descricao = aberlic112021.si47_dsclote and aberlic112021.si47_nroprocessolicitatorio = liclicita.l20_edital::varchar)
  LEFT JOIN descontotabela on (liclicita.l20_codigo=descontotabela.l204_licitacao
  and pcorcamforne.pc21_orcamforne=descontotabela.l204_fornecedor
  and descontotabela.l204_item=solicitempcmater.pc16_codmater)
  LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
  LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
  LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
  WHERE db_config.codigo = " . db_getsession("DB_instit") . "
  AND aberlic102021.si46_criterioadjudicacao = 2 AND liclicita.l20_codigo in (" . implode(",", $aLicitacoes) . ")";

		if (count($aLicitacoes) > 0) {
			$rsResult30 = db_query($sSql);
		}
		/**
		 * registro 30
		 */
		$aDadosAgrupados30 = array();
		for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {

			$oResult30 = db_utils::fieldsMemory($rsResult30, $iCont30);
			$sHash30 = '30' . $oResult30->codorgaoresp . $oResult30->codunidadesubresp . $oResult30->exerciciolicitacao . $oResult30->nroprocessolicitatorio.
				$oResult30->tipodocumento.$oResult30->nrodocumento.$oResult30->nrolote.$oResult30->coditem;

			if (!$aDadosAgrupados30[$sHash30]) {
				if ($oResult30->criterioadjudicacao == 2) {
					$oDados30 = new stdClass();

					$oDados30->si62_tiporegistro = 30;
					$oDados30->si62_codorgao = $oResult30->codorgaoresp;
					$oDados30->si62_codunidadesub = $oResult30->codunidadesubresp;
					$oDados30->si62_exerciciolicitacao = $oResult30->exerciciolicitacao;
					$oDados30->si62_nroprocessolicitatorio = $oResult30->nroprocessolicitatorio;
					$oDados30->si62_tipodocumento = $oResult30->tipodocumento;
					$oDados30->si62_nrodocumento = $oResult30->nrodocumento;
					$oDados30->si62_nrolote = $oResult30->nrolote;
					$oDados30->si62_coditem = $oResult30->coditem;
					$oDados30->si62_perctaxaadm = $oResult30->perctaxaadm;
					$oDados30->si62_instit = db_getsession("DB_instit");
					$oDados30->si62_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
					$aDadosAgrupados30[$sHash30] = $oDados30;
				}
			}
		}

		foreach ($aDadosAgrupados30 as $oDadosAgrupados30) {

			$cljulglic30 = new cl_julglic302021();

			$cljulglic30->si62_tiporegistro = $oDadosAgrupados30->si62_tiporegistro;
			$cljulglic30->si62_codorgao = $oDadosAgrupados30->si62_codorgao;
			$cljulglic30->si62_codunidadesub = $oDadosAgrupados30->si62_codunidadesub;
			$cljulglic30->si62_exerciciolicitacao = $oDadosAgrupados30->si62_exerciciolicitacao;
			$cljulglic30->si62_nroprocessolicitatorio = $oDadosAgrupados30->si62_nroprocessolicitatorio;
			$cljulglic30->si62_tipodocumento = $oDadosAgrupados30->si62_tipodocumento;
			$cljulglic30->si62_nrodocumento = $oDadosAgrupados30->si62_nrodocumento;
			$cljulglic30->si62_nrolote = $oDadosAgrupados30->si62_nrolote;
			$cljulglic30->si62_coditem = $oDadosAgrupados30->si62_coditem;
			$cljulglic30->si62_perctaxaadm = $oDadosAgrupados30->si62_perctaxaadm;
			$cljulglic30->si62_instit = $oDadosAgrupados30->si62_instit;
			$cljulglic30->si62_mes = $oDadosAgrupados30->si62_mes;
			$cljulglic30->incluir(null);
			if ($cljulglic30->erro_status == 0) {
				throw new Exception($cljulglic30->erro_msg);
			}

		}


		$sSql = " SELECT distinct '40' as tipoRegistro,
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
   AND si08_instit = " . db_getsession("DB_instit") . "
   JOIN orcunidade ON db01_orgao=o41_orgao
   AND db01_unidade=o41_unidade
   AND db01_anousu = o41_anousu
   JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
   WHERE db01_coddepto=l20_codepartamento and db01_anousu=" . db_getsession("DB_anousu") . " LIMIT 1) as codUnidadeSubResp,
	liclicita.l20_anousu as exercicioLicitacao,
	liclicita.l20_edital as nroProcessoLicitatorio,
	liclicitasituacao.l11_data as dtJulgamento,
	'1' as PresencaLicitantes,
	(case when pc31_renunrecurso is null then 2 else pc31_renunrecurso end) as renunciaRecurso
	FROM liclicita as liclicita
	INNER JOIN homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
	INNER JOIN liclicitasituacao on (liclicita.l20_codigo = liclicitasituacao.l11_liclicita)
	INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
	LEFT  JOIN  pcorcamfornelic on liclicita.l20_codigo=pcorcamfornelic.pc31_liclicita
	LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
	WHERE db_config.codigo= " . db_getsession("DB_instit") . "  AND liclicitasituacao.l11_licsituacao = 1
	AND liclicita.l20_codigo in (" . implode(",", $aLicitacoes) . ")";

		$rsResult40 = db_query($sSql);

		$aDadosAgrupados40 = array();
		for ($iCont40 = 0; $iCont40 < pg_num_rows($rsResult40); $iCont40++) {
			$oResult40 = db_utils::fieldsMemory($rsResult40, $iCont40);
			$sHash40 = '40' . $oResult40->codorgaoresp . $oResult40->codunidadesubresp . $oResult40->exerciciolicitacao . $oResult40->nroprocessolicitatorio.
				$oResult40->dtjulgamento;

			if(!$aDadosAgrupados40[$sHash40]) {
				$oDados40 = new stdClass();

				$oDados40->si62_tiporegistro = $oResult40->tiporegistro;
				$oDados40->si62_codorgao = $oResult40->codorgaoresp;
				$oDados40->si62_codunidadesub = $oResult40->codunidadesubresp;
				$oDados40->si62_exerciciolicitacao = $oResult40->exerciciolicitacao;
				$oDados40->si62_nroprocessolicitatorio = $oResult40->nroprocessolicitatorio;
				$oDados40->si62_dtjulgamento = $oResult40->dtjulgamento;
				$oDados40->si62_presencalicitantes = $oResult40->presencalicitantes;
				$oDados40->si62_renunciarecurso = $oResult40->renunciarecurso;
				$oDados40->si62_instit = db_getsession("DB_instit");
				$oDados40->si62_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
				$aDadosAgrupados40[$sHash40] = $oDados40;
			}
		}

		foreach ($aDadosAgrupados40 as $oDados40){
			$cljulglic40 = new cl_julglic402021();

			$cljulglic40->si62_tiporegistro = $oDados40->si62_tiporegistro;
			$cljulglic40->si62_codorgao = $oDados40->si62_codorgao;
			$cljulglic40->si62_codunidadesub = $oDados40->si62_codunidadesub;
			$cljulglic40->si62_exerciciolicitacao = $oDados40->si62_exerciciolicitacao;
			$cljulglic40->si62_nroprocessolicitatorio = $oDados40->si62_nroprocessolicitatorio;
			$cljulglic40->si62_dtjulgamento = $oDados40->si62_dtjulgamento;
			$cljulglic40->si62_presencalicitantes = $oDados40->si62_presencalicitantes;
			$cljulglic40->si62_renunciarecurso = $oDados40->si62_renunciarecurso;
			$cljulglic40->si62_instit = db_getsession("DB_instit");
			$cljulglic40->si62_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

			$cljulglic40->incluir(null);
			if ($cljulglic40->erro_status == 0) {
				throw new Exception($cljulglic40->erro_msg);
			}
		}

		db_fim_transacao();

		$oGerarJULGLIC = new GerarJULGLIC();
		$oGerarJULGLIC->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
		$oGerarJULGLIC->gerarDados();
	}
}
