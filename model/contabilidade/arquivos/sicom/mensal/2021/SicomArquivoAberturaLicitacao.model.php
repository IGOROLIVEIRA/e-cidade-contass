<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_aberlic102021_classe.php");
require_once("classes/db_aberlic112021_classe.php");
require_once("classes/db_aberlic122021_classe.php");
require_once("classes/db_aberlic132021_classe.php");
require_once("classes/db_aberlic142021_classe.php");
require_once("classes/db_aberlic152021_classe.php");
require_once("classes/db_aberlic162021_classe.php");

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarABERLIC.model.php");


/**
 * Abertura da licitacao Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoAberturaLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV
{

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
	public function __construct()
	{

	}

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
	 *metodo para passar os dados das Acoes e Metas pada o $this->aDados
	 */
	public function getCampos()
	{

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
	public function gerarDados()
	{

		/**
		 * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
		 */
		$claberlic10 = new cl_aberlic102021();
		$claberlic11 = new cl_aberlic112021();
		$claberlic12 = new cl_aberlic122021();
		$claberlic13 = new cl_aberlic132021();
		$claberlic14 = new cl_aberlic142021();
		$claberlic15 = new cl_aberlic152021();
		$claberlic16 = new cl_aberlic162021();

		/**
		 * excluir informacoes do mes selecioado para evitar duplicacao de registros
		 */
		db_inicio_transacao();

		/**
		 * registro 16
		 */
		$result = db_query($claberlic16->sql_query(null, "*", null, "si52_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si52_instit=" . db_getsession("DB_instit")));
		if (pg_num_rows($result) > 0) {
			$claberlic16->excluir(null, "si52_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si52_instit=" . db_getsession("DB_instit"));
			if ($claberlic16->erro_status == 0) {
				throw new Exception($claberlic16->erro_msg);
			}
		}

		/**
		 * registro 15
		 */

		$result = db_query($claberlic15->sql_query(null, "*", null, "si51_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si51_instit=" . db_getsession("DB_instit")));

		if (pg_num_rows($result) > 0) {
			$claberlic15->excluir(null, "si51_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si51_instit=" . db_getsession("DB_instit"));
			if ($claberlic15->erro_status == 0) {
				throw new Exception($claberlic15->erro_msg);
			}
		}

		/**
		 * registro 14
		 */
		$result = db_query($claberlic14->sql_query(null, "*", null, "si50_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si50_instit=" . db_getsession("DB_instit")));
		if (pg_num_rows($result) > 0) {
			$claberlic14->excluir(null, "si50_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si50_instit=" . db_getsession("DB_instit"));
			if ($claberlic14->erro_status == 0) {
				throw new Exception($claberlic14->erro_msg);
			}
		}

		/**
		 * registro 13
		 */
		$result = db_query($claberlic13->sql_query(null, "*", null, "si49_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si49_instit=" . db_getsession("DB_instit")));
		if (pg_num_rows($result) > 0) {
			$claberlic13->excluir(null, "si49_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si49_instit=" . db_getsession("DB_instit"));
			if ($claberlic13->erro_status == 0) {
				throw new Exception($claberlic13->erro_msg);
			}
		}

		/**
		 * registro 12
		 */
		$result = db_query($claberlic12->sql_query(null, "*", null, "si48_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si48_instit=" . db_getsession("DB_instit")));
		if (pg_num_rows($result) > 0) {
			$claberlic12->excluir(null, "si48_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si48_instit=" . db_getsession("DB_instit"));
			if ($claberlic12->erro_status == 0) {
				throw new Exception($claberlic12->erro_msg);
			}
		}

		/**
		 * registro 11
		 */
		$result = db_query($claberlic11->sql_query(null, "*", null, "si47_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si47_instit=" . db_getsession("DB_instit")));
		if (pg_num_rows($result) > 0) {
			$claberlic11->excluir(null, "si47_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si47_instit=" . db_getsession("DB_instit"));
			if ($claberlic11->erro_status == 0) {
				throw new Exception($claberlic11->erro_msg);
			}
		}

		/**
		 * registro 10
		 */
		$result = db_query($claberlic10->sql_query(null, "*", null, "si46_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si46_instit=" . db_getsession("DB_instit")));
		if (pg_num_rows($result) > 0) {
			$claberlic10->excluir(null, "si46_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si46_instit=" . db_getsession("DB_instit"));
			if ($claberlic10->erro_status == 0) {
				throw new Exception($claberlic10->erro_msg);
			}
		}


		$sSql = "SELECT '10' AS tipoRegistro,
     l20_codigo as seqlicitacao,
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
       liclicita.l20_anousu AS exercicioLicitacao,
       liclicita.l20_edital AS nroProcessoLicitatorio,
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
       case when liclicita.l20_naturezaobjeto = '1' then liclicita.l20_regimexecucao else 0 end AS regimeExecucaoObras,
       case when pctipocompratribunal.l44_codigotribunal = '1' then liclicita.l20_numeroconvidado else 0 end AS nroConvidado,
       ' ' AS clausulaProrrogacao,
       '2' AS unidadeMedidaPrazoExecucao,
       liclicita.l20_execucaoentrega AS prazoExecucao,
       liclicita.l20_condicoespag AS formaPagamento,
       liclicita.l20_aceitabilidade AS criterioAceitabilidade,
       CASE
           WHEN liclicita.l20_criterioadjudicacao is null THEN 3
           WHEN liclicita.l20_criterioadjudicacao = 0 THEN 3
           ELSE liclicita.l20_criterioadjudicacao
       END AS criterioAdjudicacao,
       	(CASE liclicita.l20_tipojulg
    WHEN 3 THEN 1
    ELSE 2
      END) as processoPorLote,
       liclicita.l20_critdesempate AS criterioDesempate,
       liclicita.l20_destexclusiva AS destinacaoExclusiva,
       liclicita.l20_subcontratacao AS subcontratacao,
       liclicita.l20_limitcontratacao AS limiteContratacao,
       liclicita.l20_nroedital,
       liclicita.l20_exercicioedital
     FROM liclicita
     INNER JOIN homologacaoadjudica ON (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
     INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
     INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
     INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
     LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
     WHERE db_config.codigo=" . db_getsession("DB_instit") . "
     AND DATE_PART('YEAR',homologacaoadjudica.l202_datahomologacao)= " . db_getsession("DB_anousu") . "
     AND DATE_PART('MONTH',homologacaoadjudica.l202_datahomologacao)=" . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
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
		for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

			$claberlic10 = new cl_aberlic102021();
			$oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

			$claberlic10->si46_tiporegistro = 10;
			$claberlic10->si46_clausulaprorrogacao = $oDados10->clausulaprorrogacao;
			$claberlic10->si46_codmodalidadelicitacao = $oDados10->codmodalidadelicitacao;
			$claberlic10->si46_codorgaoresp = $oDados10->codorgaoresp;
			$claberlic10->si46_codunidadesubresp = $oDados10->codunidadesubresp;
			$claberlic10->si46_criterioaceitabilidade = substr($this->removeCaracteres($oDados10->criterioaceitabilidade), 0, 80);
			$claberlic10->si46_criteriodesempate = $oDados10->criteriodesempate;
			$claberlic10->si46_nroedital = $oDados10->l20_nroedital;
            $claberlic10->si46_exercicioedital = $oDados10->l20_exercicioedital;
			$claberlic10->si46_descontotabela = $oDados10->criterioadjudicacao;
			$claberlic10->si46_destinacaoexclusiva = $oDados10->destinacaoexclusiva;
			$claberlic10->si46_dtabertura = $oDados10->dtabertura;
			$claberlic10->si46_dteditalconvite = $oDados10->dteditalconvite;
			$claberlic10->si46_dtpublicacaoeditaldo = $oDados10->dtpublicacaoeditaldo;
			$claberlic10->si46_dtpublicacaoeditalveiculo1 = $oDados10->dtpublicacaoeditalveiculo1;
			$claberlic10->si46_dtpublicacaoeditalveiculo2 = $oDados10->dtpublicacaoeditalveiculo2;
			$claberlic10->si46_dtrecebimentodoc = $oDados10->dtrecebimentodoc;
			$claberlic10->si46_exerciciolicitacao = $oDados10->exerciciolicitacao;
			$claberlic10->si46_formapagamento = substr($this->removeCaracteres($oDados10->formapagamento), 0, 80);
			$claberlic10->si46_limitecontratacao = $oDados10->limitecontratacao;
			$claberlic10->si46_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
			$claberlic10->si46_naturezaobjeto = $oDados10->naturezaobjeto;
			$claberlic10->si46_naturezaprocedimento = $oDados10->naturezaprocedimento;
			$claberlic10->si46_nroconvidado = $oDados10->nroconvidado;
			$claberlic10->si46_nromodalidade = $oDados10->nromodalidade;
			$claberlic10->si46_nroprocessolicitatorio = $oDados10->nroprocessolicitatorio;
			$claberlic10->si46_objeto = substr($this->removeCaracteres($oDados10->objeto), 0, 500);
			$claberlic10->si46_prazoexecucao = $oDados10->prazoexecucao;
			$claberlic10->si46_processoporlote = $oDados10->processoporlote;
			$claberlic10->si46_regimeexecucaoobras = $oDados10->regimeexecucaoobras;
			$claberlic10->si46_subcontratacao = $oDados10->subcontratacao;
			$claberlic10->si46_tipolicitacao = $oDados10->tipolicitacao;
			$claberlic10->si46_unidademedidaprazoexecucao = $oDados10->unidademedidaprazoexecucao;
			$claberlic10->si46_criterioadjudicacao = $oDados10->criterioadjudicacao;
			$claberlic10->si46_veiculo1publicacao = $this->removeCaracteres($oDados10->veiculo1publicacao);
			$claberlic10->si46_veiculo2publicacao = $this->removeCaracteres($oDados10->veiculo2Publicacao);
			$claberlic10->si46_instit = db_getsession("DB_instit");


			$claberlic10->incluir(null);
			if ($claberlic10->erro_status == 0) {
				throw new Exception($claberlic10->erro_msg);
			}


			/**
			 * selecionar informacoes registro 11
			 */

			$sSql = "SELECT distinct '11' AS tipoRegistro,
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
           liclicita.l20_anousu AS exercicioLicitacao,
           liclicita.l20_edital AS nroProcessoLicitatorio,
           liclicitemlote.l04_codigo AS nroLote,
           liclicitemlote.l04_descricao AS dscLote
         FROM liclicitem
         INNER JOIN liclicita ON (liclicitem.l21_codliclicita=liclicita.l20_codigo)
           INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
         INNER JOIN liclicitemlote ON (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
         LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
         WHERE db_config.codigo=" . db_getsession("DB_instit") . " AND liclicita.l20_tipojulg = 3
           AND liclicita.l20_codigo=$oDados10->seqlicitacao order by liclicitemlote.l04_codigo";

			$rsResult11 = db_query($sSql);//db_criatabela($rsResult11);

			$aDadosAgrupados11 = array();
			for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

				$oResult11 = db_utils::fieldsMemory($rsResult11, $iCont11);
				$sHash11 = $oResult11->dsclote;

				if (!isset($aDadosAgrupados11[$sHash11])) {

					$claberlic11 = new cl_aberlic112021();

					$claberlic11->si47_tiporegistro = 11;
					$claberlic11->si47_codorgaoresp = $oResult11->codorgaoresp;
					$claberlic11->si47_codunidadesubresp = $oResult11->codunidadesubresp;
					$claberlic11->si47_exerciciolicitacao = $oResult11->exerciciolicitacao;
					$claberlic11->si47_nroprocessolicitatorio = $oResult11->nroprocessolicitatorio;
					$claberlic11->si47_nrolote = substr($oResult11->nrolote, -4);
					$claberlic11->si47_dsclote = $oResult11->dsclote;
					$claberlic11->si47_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
					$claberlic11->si47_reg10 = $claberlic10->si46_sequencial;// chave estrangeira
					$claberlic11->si47_instit = db_getsession("DB_instit");

					$claberlic11->incluir(null);
					if ($claberlic11->erro_status == 0) {
						throw new Exception($claberlic11->erro_msg);
					}
					$aDadosAgrupados11[$sHash11] = $claberlic11;

				}

			}


			$sSql = " select distinct '12' as tipoRegistro,
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
        (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) as codItem
        FROM liclicitem
        INNER JOIN liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
        INNER JOIN pcprocitem  on (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
        INNER JOIN solicitem on (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
        INNER JOIN solicitempcmater on (solicitem.pc11_codigo = solicitempcmater.pc16_solicitem)
        INNER JOIN pcmater on (solicitempcmater.pc16_codmater = pcmater.pc01_codmater)
        INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
        LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
        LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
        LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
        WHERE db_config.codigo= " . db_getsession("DB_instit") . "
        AND liclicita.l20_codigo= $oDados10->seqlicitacao";

			$rsResult12 = db_query($sSql);//db_criatabela($rsResult12);echo $sSql;
			for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {

				$claberlic12 = new cl_aberlic122021();
				$oDados12 = db_utils::fieldsMemory($rsResult12, $iCont12);

				$claberlic12->si48_tiporegistro = 12;
				$claberlic12->si48_codorgaoresp = $oDados12->codorgaoresp;
				$claberlic12->si48_codunidadesubresp = $oDados12->codunidadesubresp;
				$claberlic12->si48_exerciciolicitacao = $oDados12->exerciciolicitacao;
				$claberlic12->si48_nroprocessolicitatorio = $oDados12->nroprocessolicitatorio;
				$claberlic12->si48_coditem = $oDados12->coditem;
				$claberlic12->si48_nroitem = $iCont12 + 1;
				$claberlic12->si48_reg10 = $claberlic10->si46_sequencial;// chave estrangeira
				$claberlic12->si48_instit = db_getsession("DB_instit");
				$claberlic12->si48_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];


				$claberlic12->incluir(null);
				if ($claberlic12->erro_status == 0) {
					throw new Exception($claberlic12->erro_msg);
				}
			}


			$sSql = " select '13' as tipoRegistro,
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
      aberlic112021.si47_nrolote as nroLote,
      (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) as codItem
      FROM liclicitem
      INNER JOIN liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
      INNER JOIN pcprocitem  on (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
      INNER JOIN solicitem on (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
      INNER JOIN solicitempcmater on (solicitem.pc11_codigo = solicitempcmater.pc16_solicitem)
      INNER JOIN pcmater on (solicitempcmater.pc16_codmater = pcmater.pc01_codmater)
      INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
      INNER JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
      INNER JOIN aberlic112021 on (liclicitemlote.l04_descricao = aberlic112021.si47_dsclote and aberlic112021.si47_nroprocessolicitatorio = liclicita.l20_edital::varchar)
      LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
      LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
      LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
      WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND liclicita.l20_tipojulg = 3
      AND liclicita.l20_codigo= $oDados10->seqlicitacao";


			$rsResult13 = db_query($sSql);//echo pg_last_error();db_criatabela($rsResult13);
			for ($iCont13 = 0; $iCont13 < pg_num_rows($rsResult13); $iCont13++) {

				$claberlic13 = new cl_aberlic132021();
				$oDados13 = db_utils::fieldsMemory($rsResult13, $iCont13);

				$claberlic13->si49_tiporegistro = 13;
				$claberlic13->si49_codorgaoresp = $oDados13->codorgaoresp;
				$claberlic13->si49_codunidadesubresp = $oDados13->codunidadesubresp;
				$claberlic13->si49_exerciciolicitacao = $oDados13->exerciciolicitacao;
				$claberlic13->si49_nroprocessolicitatorio = $oDados13->nroprocessolicitatorio;
				$claberlic13->si49_nrolote = $oDados13->nrolote;
				$claberlic13->si49_reg10 = $claberlic10->si46_sequencial;// chave estrangeira
				$claberlic13->si49_coditem = $oDados13->coditem;
				$claberlic13->si49_instit = db_getsession("DB_instit");
				$claberlic13->si49_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];


				$claberlic13->incluir(null);
				if ($claberlic13->erro_status == 0) {
					throw new Exception($claberlic13->erro_msg);
				}
			}

			$sSql = " select distinct '14' as tipoRegistro,
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
    CASE WHEN liclicita.l20_tipojulg = 3 THEN aberlic112021.si47_nrolote ELSE 0 END AS nroLote,
    (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) as codItem,
    precoreferencia.si01_datacotacao as dtCotacao,
    itemprecoreferencia.si02_vlpercreferencia AS vlRefPercentual,
    itemprecoreferencia.si02_vlprecoreferencia as vlCotPrecosUnitario,
    pcorcamval.pc23_quant as quantidade,
    '0' as vlMinAlienBens
    FROM liclicitem
    INNER JOIN liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
    LEFT  JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
    LEFT JOIN aberlic112021 on (liclicitemlote.l04_descricao = aberlic112021.si47_dsclote and aberlic112021.si47_nroprocessolicitatorio = liclicita.l20_edital::varchar)
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
    INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
    INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
    LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
    WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND pctipocompratribunal.l44_sequencial != 102
    AND liclicita.l20_codigo= $oDados10->seqlicitacao";

			$rsResult14 = db_query($sSql);//echo $sSql;db_criatabela($rsResult14);
			if (pg_num_rows($rsResult14) == 0) {
				$sSql = " select distinct '14' as tipoRegistro,
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
            CASE WHEN liclicita.l20_tipojulg = 3 THEN aberlic112021.si47_nrolote ELSE 0 END AS nroLote,
            (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) as codItem,
            precomedio.l209_datacotacao as dtCotacao,
            precomedio.l209_valor as vlCotPrecosUnitario,
            solicitem.pc11_quant as quantidade,
            '0' as vlMinAlienBens
            FROM liclicitem
            INNER JOIN liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
            LEFT  JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
            LEFT JOIN aberlic112021 on (liclicitemlote.l04_descricao = aberlic112021.si47_dsclote and aberlic112021.si47_nroprocessolicitatorio = liclicita.l20_edital::varchar)
            INNER JOIN pcprocitem  on (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
            INNER JOIN solicitem on (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
            INNER JOIN solicitempcmater on (solicitem.pc11_codigo = solicitempcmater.pc16_solicitem)
            INNER JOIN pcmater on (solicitempcmater.pc16_codmater = pcmater.pc01_codmater)
            INNER JOIN precomedio on (precomedio.l209_licitacao = liclicita.l20_codigo and precomedio.l209_item = pcmater.pc01_codmater)
            INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
            LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
            LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
            INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
            INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
            LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
            WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND pctipocompratribunal.l44_sequencial != 102
            AND liclicita.l20_codigo= $oDados10->seqlicitacao";

				$rsResult14 = db_query($sSql);//echo $sSql;db_criatabela($rsResult14);
			}
			$aDadosAgrupados14 = array();
			for ($iCont14 = 0; $iCont14 < pg_num_rows($rsResult14); $iCont14++) {

				$oResult14 = db_utils::fieldsMemory($rsResult14, $iCont14);

				$sHash14 = $oResult14->coditem;

				if (!isset($aDadosAgrupados14[$sHash14])) {

					$oDados14 = new stdClass();

					$oDados14->si50_tiporegistro = 14;
					$oDados14->si50_codorgaoresp = $oResult14->codorgaoresp;
					$oDados14->si50_codunidadesubresp = $oResult14->codunidadesubresp;
					$oDados14->si50_exerciciolicitacao = $oResult14->exerciciolicitacao;
					$oDados14->si50_nroprocessolicitatorio = $oResult14->nroprocessolicitatorio;
					$oDados14->si50_nrolote = $oResult14->nrolote;
					$oDados14->si50_reg10 = $claberlic10->si46_sequencial;// chave estrangeira
					$oDados14->si50_coditem = $oResult14->coditem;
					$oDados14->si50_dtcotacao = $oResult14->dtcotacao;
					$oDados14->si50_vlrefpercentual = isset($oResult14->si02_vlpercreferencia) ? number_format($oResult14->si02_vlpercreferencia,'2',',','.') : 0;
					$oDados14->si50_vlcotprecosunitario = $oResult14->vlcotprecosunitario;
					$oDados14->si50_quantidade = $oResult14->quantidade;
					$oDados14->si50_vlminalienbens = $oResult14->vlminalienbens;
					$oDados14->si50_instit = db_getsession("DB_instit");
					$oDados14->si50_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

					$aDadosAgrupados14[$sHash14] = $oDados14;

				} else {
					$aDadosAgrupados14[$sHash14]->si50_quantidade += $oResult14->quantidade;
				}

			}

			foreach ($aDadosAgrupados14 as $oDadosAgrupados14) {

				$claberlic14 = new cl_aberlic142021();

				$claberlic14->si50_tiporegistro = $oDadosAgrupados14->si50_tiporegistro;
				$claberlic14->si50_codorgaoresp = $oDadosAgrupados14->si50_codorgaoresp;
				$claberlic14->si50_codunidadesubresp = $oDadosAgrupados14->si50_codunidadesubresp;
				$claberlic14->si50_exerciciolicitacao = $oDadosAgrupados14->si50_exerciciolicitacao;
				$claberlic14->si50_nroprocessolicitatorio = $oDadosAgrupados14->si50_nroprocessolicitatorio;
				$claberlic14->si50_nrolote = $oDadosAgrupados14->si50_nrolote;
				$claberlic14->si50_reg10 = $oDadosAgrupados14->si50_reg10;// chave estrangeira
				$claberlic14->si50_coditem = $oDadosAgrupados14->si50_coditem;
				$claberlic14->si50_dtcotacao = $oDadosAgrupados14->si50_dtcotacao;
				$claberlic14->si50_vlrefpercentual = $oDadosAgrupados14->si50_vlrefpercentual;
				$claberlic14->si50_vlcotprecosunitario = $oDadosAgrupados14->si50_vlcotprecosunitario;
				$claberlic14->si50_quantidade = $oDadosAgrupados14->si50_quantidade;
				$claberlic14->si50_vlminalienbens = $oDadosAgrupados14->si50_vlminalienbens;
				$claberlic14->si50_instit = $oDadosAgrupados14->si50_instit;
				$claberlic14->si50_mes = $oDadosAgrupados14->si50_mes;


				$claberlic14->incluir(null);
				if ($claberlic14->erro_status == 0) {
					throw new Exception($claberlic14->erro_msg);
				}

			}


			$sSql = "select distinct '15' as tipoRegistro,
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
    aberlic112021.si47_nrolote as nroLote,
    (pcmater.pc01_codmater::varchar || matunid.m61_codmatunid::varchar) as codItem,
    itemprecoreferencia.si02_vlprecoreferencia as vlItem
    FROM liclicitem
    INNER JOIN liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
    INNER JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
    INNER JOIN aberlic112021 on (liclicitemlote.l04_descricao = aberlic112021.si47_dsclote and aberlic112021.si47_nroprocessolicitatorio = liclicita.l20_edital::varchar)
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
    INNER JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
    INNER JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
    INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
    INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
    LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
    WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND pctipocompratribunal.l44_sequencial = 102
    AND liclicita.l20_codigo= $oDados10->seqlicitacao";


			$rsResult15 = db_query($sSql);//db_criatabela($rsResult15);
			for ($iCont15 = 0; $iCont15 < pg_num_rows($rsResult15); $iCont15++) {

				$claberlic15 = new cl_aberlic152021();
				$oDados15 = db_utils::fieldsMemory($rsResult15, $iCont15);

				$claberlic15->si51_tiporegistro = 15;
				$claberlic15->si51_codorgaoresp = $oDados15->codorgaoresp;
				$claberlic15->si51_codunidadesubresp = $oDados15->codunidadesubresp;
				$claberlic15->si51_exerciciolicitacao = $oDados15->exerciciolicitacao;
				$claberlic15->si51_nroprocessolicitatorio = $oDados15->nroprocessolicitatorio;
				$claberlic15->si51_nrolote = $oDados15->nrolote;
				$claberlic15->si51_reg10 = $claberlic10->si46_sequencial;// chave estrangeira
				$claberlic15->si51_coditem = $oDados15->coditem;
				$claberlic15->si51_vlitem = $oDados15->vlitem;
				$claberlic15->si51_instit = db_getsession("DB_instit");
				$claberlic15->si51_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

				$claberlic15->incluir(null);
				if ($claberlic15->erro_status == 0) {
					throw new Exception($claberlic15->erro_msg);
				}
			}


			$sSql = " select tiporegistro,codorgaoresp,codunidadesubresp,exerciciolicitacao,nroprocessolicitatorio,codorgao,
 codunidadesub,codfuncao,codsubfuncao,codprograma,idacao,idsubacao,naturezadespesa,codfontrecursos,sum(vlrecurso) as vlrecurso
 from (select distinct '16' as tipoRegistro,
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
    infocomplementaresinstit.si09_codorgaotce as codOrgao,
    CASE WHEN o41_subunidade != 0
    OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
    OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
    OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0) ELSE lpad((CASE WHEN o40_codtri = '0'
    OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
    OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0) END AS codunidadesub,
    orcdotacao.o58_orgao,
    orcdotacao.o58_unidade,
    orcdotacao.o58_funcao as codFuncao,
    orcdotacao.o58_subfuncao as codSubFuncao,
    orcdotacao.o58_programa as codPrograma,
    orcdotacao.o58_projativ as idAcao,
    orcprojativ.o55_origemacao as idSubAcao,
    substr(orcelemento.o56_elemento,2,6) as naturezaDespesa,
    orctiporec.o15_codtri as codFontRecursos,
    orcdotacao.o58_valor as vlRecurso
    FROM liclicita
    INNER JOIN liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
    INNER JOIN pcprocitem on (liclicitem.l21_codpcprocitem=pcprocitem.pc81_codprocitem)
    INNER JOIN pcdotac on (pcprocitem.pc81_solicitem=pcdotac.pc13_codigo)
    INNER JOIN orcdotacao on (pcdotac.pc13_anousu=orcdotacao.o58_anousu and pcdotac.pc13_coddot=orcdotacao.o58_coddot)
    inner join orcunidade on o41_anousu = o58_anousu and o41_orgao = o58_orgao and o41_unidade = o58_unidade
    inner join orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
    INNER JOIN orcprojativ on orcdotacao.o58_projativ = orcprojativ.o55_projativ and orcdotacao.o58_anousu = orcprojativ.o55_anousu
    INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
    INNER JOIN orctiporec on (orcdotacao.o58_codigo=orctiporec.o15_codigo)
    INNER JOIN orcelemento on (orcdotacao.o58_anousu=orcelemento.o56_anousu and orcdotacao.o58_codele=orcelemento.o56_codele)
    LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
    WHERE db_config.codigo= " . db_getsession("DB_instit") . "
    AND liclicita.l20_codigo= $oDados10->seqlicitacao) as x group by tiporegistro,codorgaoresp,codunidadesubresp,
    exerciciolicitacao,nroprocessolicitatorio,codorgao,codunidadesub,codfuncao,codsubfuncao,codprograma,idacao,idsubacao,
    naturezadespesa,codfontrecursos";


			$rsResult16 = db_query($sSql);//db_criatabela($rsResult16);echo pg_last_error();
			for ($iCont16 = 0; $iCont16 < pg_num_rows($rsResult16); $iCont16++) {

				$claberlic16 = new cl_aberlic162021();
				$oDados16 = db_utils::fieldsMemory($rsResult16, $iCont16);

				$claberlic16->si52_tiporegistro = 16;
				$claberlic16->si52_codorgaoresp = $oDados16->codorgaoresp;
				$claberlic16->si52_codunidadesubresp = $oDados16->codunidadesubresp;
				$claberlic16->si52_exerciciolicitacao = $oDados16->exerciciolicitacao;
				$claberlic16->si52_nroprocessolicitatorio = $oDados16->nroprocessolicitatorio;
				$claberlic16->si52_codorgao = $oDados16->codorgao;
				$claberlic16->si52_codunidadesub = $oDados16->codunidadesub;
				$claberlic16->si52_codfuncao = $oDados16->codfuncao;
				$claberlic16->si52_codsubfuncao = $oDados16->codsubfuncao;
				$claberlic16->si52_codprograma = $oDados16->codprograma;
				$claberlic16->si52_idacao = $oDados16->idacao;
				$claberlic16->si52_idsubacao = $oDados16->idsubacao;
				$claberlic16->si52_naturezadespesa = $oDados16->naturezadespesa;
				$claberlic16->si52_codfontrecursos = $oDados16->codfontrecursos;
				$claberlic16->si52_vlrecurso = $oDados16->vlrecurso;
				$claberlic16->si52_reg10 = $claberlic10->si46_sequencial;// chave estrangeira
				$claberlic16->si52_instit = db_getsession("DB_instit");
				$claberlic16->si52_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

				$claberlic16->incluir(null);
				if ($claberlic16->erro_status == 0) {
					throw new Exception($claberlic16->erro_msg);
				}
			}
		}


		db_fim_transacao();

		$oGerarABERLIC = new GerarABERLIC();
		$oGerarABERLIC->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
		$oGerarABERLIC->gerarDados();


	}

}
