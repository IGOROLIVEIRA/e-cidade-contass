<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_dispensa102024_classe.php");
require_once("classes/db_dispensa112024_classe.php");
require_once("classes/db_dispensa122024_classe.php");
require_once("classes/db_dispensa132024_classe.php");
require_once("classes/db_dispensa142024_classe.php");
require_once("classes/db_dispensa152024_classe.php");
require_once("classes/db_dispensa162024_classe.php");
require_once("classes/db_dispensa172024_classe.php");
require_once("classes/db_dispensa182024_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2024/GerarDISPENSA.model.php");

/**
 * Dispensa ou Inexigibilidade Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoDispensaInexigibilidade extends SicomArquivoBase implements iPadArquivoBaseCSV
{

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
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   */
  public function getCampos()
  {

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
  public function gerarDados()
  {


    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $dispensa10 = new cl_dispensa102024();
    $dispensa11 = new cl_dispensa112024();
    $dispensa12 = new cl_dispensa122024();
    $dispensa13 = new cl_dispensa132024();
    $dispensa14 = new cl_dispensa142024();
    $dispensa15 = new cl_dispensa152024();
    $dispensa16 = new cl_dispensa162024();
    $dispensa17 = new cl_dispensa172024();
    $dispensa18 = new cl_dispensa182024();
    $dispensa30 = new cl_dispensa302024();
    $dispensa40 = new cl_dispensa402024();

    /**
     * excluir informacoes do mes selecioado
     */
    db_inicio_transacao();


    $result = db_query($dispensa11->sql_query(NULL, "*", NULL, "si75_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si75_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $dispensa11->excluir(NULL, "si75_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si75_instit=" . db_getsession("DB_instit"));
      if ($dispensa11->erro_status == 0) {
        throw new Exception($dispensa11->erro_msg);
      }
    }


    $result = db_query($dispensa12->sql_query(NULL, "*", NULL, "si76_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si76_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $dispensa12->excluir(NULL, "si76_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si76_instit=" . db_getsession("DB_instit"));
      if ($dispensa12->erro_status == 0) {
        throw new Exception($dispensa12->erro_msg);
      }
    }


    $result = db_query($dispensa13->sql_query(NULL, "*", NULL, "si77_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si77_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $dispensa13->excluir(NULL, "si77_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si77_instit=" . db_getsession("DB_instit"));
      if ($dispensa13->erro_status == 0) {
        throw new Exception($dispensa13->erro_msg);
      }
    }


    $result = db_query($dispensa14->sql_query(NULL, "*", NULL, "si78_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si78_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $dispensa14->excluir(NULL, "si78_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si78_instit=" . db_getsession("DB_instit"));
      if ($dispensa14->erro_status == 0) {
        throw new Exception($dispensa14->erro_msg);
      }
    }


    $result = db_query($dispensa15->sql_query(NULL, "*", NULL, "si79_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si79_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $dispensa15->excluir(NULL, "si79_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si79_instit=" . db_getsession("DB_instit"));
      if ($dispensa15->erro_status == 0) {
        throw new Exception($dispensa15->erro_msg);
      }
    }


    $result = db_query($dispensa16->sql_query(NULL, "*", NULL, "si80_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si80_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $dispensa16->excluir(NULL, "si80_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si80_instit=" . db_getsession("DB_instit"));
      if ($dispensa16->erro_status == 0) {
        throw new Exception($dispensa16->erro_msg);
      }
    }

    $result = db_query($dispensa17->sql_query(NULL, "*", NULL, "si81_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si81_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $dispensa17->excluir(NULL, "si81_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si81_instit=" . db_getsession("DB_instit"));
      if ($dispensa17->erro_status == 0) {
        throw new Exception($dispensa17->erro_msg);
      }
    }

    $result = db_query($dispensa18->sql_query(NULL, "*", NULL, "si82_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si82_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $dispensa18->excluir(NULL, "si82_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si82_instit=" . db_getsession("DB_instit"));
      if ($dispensa18->erro_status == 0) {
        throw new Exception($dispensa18->erro_msg);
      }
    }


    $result = db_query($dispensa10->sql_query(NULL, "*", NULL, "si74_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si74_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $dispensa10->excluir(NULL, "si74_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si74_instit=" . db_getsession("DB_instit"));
      if ($dispensa10->erro_status == 0) {
        throw new Exception($dispensa10->erro_msg);
      }
    }

    $result = db_query($dispensa30->sql_query(NULL, "*", NULL, "si203_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si203_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $dispensa30->excluir(NULL, "si203_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si203_instit=" . db_getsession("DB_instit"));
      if ($dispensa30->erro_status == 0) {
        throw new Exception($dispensa30->erro_msg);
      }
    }

    $result = db_query($dispensa40->sql_query(NULL, "*", NULL, "si204_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si204_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $dispensa40->excluir(NULL, "si204_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si204_instit=" . db_getsession("DB_instit"));
      if ($dispensa40->erro_status == 0) {
        throw new Exception($dispensa40->erro_msg);
      }
    }

    $sSql = "SELECT DISTINCT l20_codepartamento, '10' as tipoRegistro,
  l20_leidalicitacao,
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
	liclicita.l20_tipoprocesso as tipoProcesso,
	case when liclicita.l20_dataaber is null then liclicita.l20_datacria else liclicita.l20_dataaber end as dtAbertura,
	liclicita.l20_naturezaobjeto as naturezaObjeto,
	liclicita.l20_objeto as objeto,
	liclicita.l20_justificativa as justificativa,
	liclicita.l20_razao as razao,
	liclicita.l20_dtpubratificacao as dtPublicacaoTermoRatificacao,
	l20_codigo as codlicitacao,
	liclicita.l20_veicdivulgacao as veiculoPublicacao,
	 (CASE
        WHEN liclicita.l20_cadInicial is null or liclicita.l20_cadInicial = 0 and liclicita.l20_anousu >= 2024 THEN 1
     	ELSE liclicita.l20_cadInicial
     END) as cadInicial,
	(CASE liclicita.l20_tipojulg WHEN 3 THEN 1
		ELSE 2
	END) as processoPorLote,
  manutencaolicitacao.manutlic_codunidsubanterior AS codunidsubant,
  (SELECT CASE
  WHEN o41_subunidade != 0
       OR NOT NULL THEN lpad((CASE
                                  WHEN o40_codtri = '0'
                                       OR NULL THEN o40_orgao::varchar
                                  ELSE o40_codtri
                              END),2,0)||lpad((CASE
                                                   WHEN o41_codtri = '0'
                                                        OR NULL THEN o41_unidade::varchar
                                                   ELSE o41_codtri
                                               END),3,0)||lpad(o41_subunidade::integer,3,0)
  ELSE lpad((CASE
                 WHEN o40_codtri = '0'
                      OR NULL THEN o40_orgao::varchar
                 ELSE o40_codtri
             END),2,0)||lpad((CASE
                                  WHEN o41_codtri = '0'
                                       OR NULL THEN o41_unidade::varchar
                                  ELSE o41_codtri
                              END),3,0)
END AS codunidadesubresp
FROM db_departorg
JOIN infocomplementares ON si08_anousu = db01_anousu
AND si08_instit = " . db_getsession('DB_instit') . "
JOIN orcunidade ON db01_orgao=o41_orgao
AND db01_unidade=o41_unidade
AND db01_anousu = o41_anousu
JOIN orcorgao ON o40_orgao = o41_orgao
AND o40_anousu = o41_anousu
WHERE db01_coddepto=l20_codepartamento
AND db01_anousu = " . db_getsession('DB_anousu') . "
LIMIT 1) AS codUnidadeSubEdital,
l20_criterioadjudicacao
	FROM liclicita
	INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)

	INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
	INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
	LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
	INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo and liclicitasituacao.l11_licsituacao in (1,10)
	LEFT JOIN manutencaolicitacao on (manutencaolicitacao.manutlic_licitacao = liclicita.l20_codigo)
  WHERE db_config.codigo= " . db_getsession("DB_instit") . "
	AND pctipocompratribunal.l44_sequencial in (100,101,102,103) AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
	AND DATE_PART('YEAR',l20_dtpubratificacao)=" . db_getsession("DB_anousu") . "
	AND DATE_PART('MONTH',l20_dtpubratificacao)=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];

    $rsResult10 = db_query($sSql);
    //db_criatabela($rsResult10);
    //exit;

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $dispensa10 = new cl_dispensa102024();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);


      $dispensa10->si74_tiporegistro = 10;
      $dispensa10->si74_codorgaoresp = $oDados10->codorgaoresp;
      if ($oDados10->codunidsubant != null || $oDados10->codunidsubant != '') {
        $dispensa10->si74_codunidadesubresp = $oDados10->codunidsubant;
      } else {
        $dispensa10->si74_codunidadesubresp = $oDados10->codunidadesubresp;
      }
      $dispensa10->si74_exercicioprocesso = $oDados10->exerciciolicitacao;
      $dispensa10->si74_nroprocesso = $oDados10->nroprocessolicitatorio;
      $dispensa10->si74_codunidadesubedital = $oDados10->codunidadesubedital;
      $dispensa10->si74_tipoprocesso = $oDados10->tipoprocesso;
      $dispensa10->si74_tipocriterio = $oDados10->tipoprocesso == 5 || $oDados10->tipoprocesso == 6 ? $oDados10->l20_criterioadjudicacao : '';
      $dispensa10->si74_dtabertura = $oDados10->dtabertura;
      $dispensa10->si74_naturezaobjeto = $oDados10->naturezaobjeto;
      $dispensa10->si74_objeto = $this->removeCaracteres($oDados10->objeto);
      $dispensa10->si74_justificativa = $this->removeCaracteres($oDados10->justificativa);
      $dispensa10->si74_razao = $this->removeCaracteres($oDados10->razao);
      $dispensa10->si74_dtpublicacaotermoratificacao = $oDados10->dtpublicacaotermoratificacao;
      $dispensa10->si74_veiculopublicacao = $this->removeCaracteres($oDados10->veiculopublicacao);
      $dispensa10->si74_processoporlote = $oDados10->processoporlote;
      $dispensa10->si74_tipocadastro = !$oDados10->cadInicial ? 1 : $oDados10->cadInicial;
      $dispensa10->si74_leidalicitacao = $oDados10->l20_leidalicitacao;
      $dispensa10->si74_instit = db_getsession("DB_instit");
      $dispensa10->si74_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

      $dispensa10->incluir(null);
      if ($dispensa10->erro_status == 0) {
        throw new Exception($dispensa10->erro_msg);
      }


      $sSql = "SELECT DISTINCT  '11' as tipoRegistro,
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
		liclicita.l20_tipoprocesso as tipoProcesso,
		liclicitemlote.l04_numerolote as nroLote,
		liclicitemlote.l04_descricao as dscLote,
    manutencaolicitacao.manutlic_codunidsubanterior AS codunidsubant
		FROM liclicita
		INNER JOIN liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
		INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
		INNER JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
		LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
		INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
    LEFT JOIN manutencaolicitacao on (manutencaolicitacao.manutlic_licitacao = liclicita.l20_codigo)
		WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
		AND liclicita.l20_tipojulg = 3
    AND liclicitemlote.l04_numerolote IS NOT NULL
		AND liclicita.l20_codigo={$oDados10->codlicitacao}";

      $rsResult11 = db_query($sSql);
      $aDadosAgrupados11 = array();
      for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

        $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
        $sHash11 = $oDados11->dsclote;

        if (!isset($aDadosAgrupados11[$sHash11])) {

          $dispensa11 = new cl_dispensa112024();

          $dispensa11->si75_tiporegistro = 11;
          $dispensa11->si75_reg10 = $dispensa10->si74_sequencial;
          $dispensa11->si75_codorgaoresp = $oDados11->codorgaoresp;
          if ($oDados11->codunidsubant != null || $oDados11->codunidsubant != '') {
            $dispensa11->si75_codunidadesubresp = $oDados11->codunidsubant;
          } else {
            $dispensa11->si75_codunidadesubresp = $oDados11->codunidadesubresp;
          }
          $dispensa11->si75_exercicioprocesso = $oDados11->exerciciolicitacao;
          $dispensa11->si75_nroprocesso = $oDados11->nroprocessolicitatorio;
          $dispensa11->si75_tipoprocesso = $oDados11->tipoprocesso;
          $dispensa11->si75_nrolote = $oDados11->nrolote;
          $dispensa11->si75_dsclote = $oDados11->dsclote;
          $dispensa11->si75_instit = db_getsession("DB_instit");
          $dispensa11->si75_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

          $dispensa11->incluir(null);
          if ($dispensa11->erro_status == 0) {
            throw new Exception($dispensa11->erro_msg);
          }
          $aDadosAgrupados11[$sHash11] = $dispensa11;
        }
      }

      $sSql = "select DISTINCT '12' as tipoRegistro,
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
		liclicita.l20_tipoprocesso as tipoProcesso,
    CASE
    WHEN (pcmater.pc01_codmaterant != 0 or pcmater.pc01_codmaterant != null) THEN pcmater.pc01_codmaterant::varchar
  ELSE (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) END AS coditem,
		(pcmater.pc01_codmater::varchar || (case when matunid.m61_codmatunid is null then 1 else matunid.m61_codmatunid end)::varchar) as nroItem,
		manutencaolicitacao.manutlic_codunidsubanterior AS codunidsubant
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
		LEFT JOIN manutencaolicitacao on (manutencaolicitacao.manutlic_licitacao = liclicita.l20_codigo)
    WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";

      $rsResult12 = db_query($sSql);

      for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {

        $dispensa12 = new cl_dispensa122024();
        $oDados12 = db_utils::fieldsMemory($rsResult12, $iCont12);

        $dispensa12->si76_tiporegistro = 12;
        $dispensa12->si76_reg10 = $dispensa10->si74_sequencial;
        $dispensa12->si76_codorgaoresp = $oDados12->codorgaoresp;
        if ($oDados12->codunidsubant != null || $oDados12->codunidsubant != '') {
          $dispensa12->si76_codunidadesubresp = $oDados12->codunidsubant;
        } else {
          $dispensa12->si76_codunidadesubresp = $oDados12->codunidadesubresp;
        }
        $dispensa12->si76_exercicioprocesso = $oDados12->exerciciolicitacao;
        $dispensa12->si76_nroprocesso = $oDados12->nroprocessolicitatorio;
        $dispensa12->si76_tipoprocesso = $oDados12->tipoprocesso;
        $dispensa12->si76_nroitem = $iCont12 + 1;
        $dispensa12->si76_coditem = $oDados12->coditem;
        $dispensa12->si76_instit = db_getsession("DB_instit");
        $dispensa12->si76_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        /*###########  verificar esses dois campos###############
          nrolote
          dsclote*/


        $dispensa12->incluir(null);
        if ($dispensa12->erro_status == 0) {
          throw new Exception($dispensa12->erro_msg);
        }
      }


      $sSql = " select DISTINCT '13' as tipoRegistro,
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
		liclicita.l20_tipoprocesso as tipoProcesso,
		dispensa112024.si75_nrolote as nroLote,
    CASE
    WHEN (pcmater.pc01_codmaterant != 0 or pcmater.pc01_codmaterant != null) THEN pcmater.pc01_codmaterant::varchar
  ELSE (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) END AS coditem,
		manutencaolicitacao.manutlic_codunidsubanterior AS codunidsubant
    FROM liclicitem
		INNER JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
		INNER JOIN liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
		INNER JOIN dispensa112024 on (liclicitemlote.l04_descricao = dispensa112024.si75_dsclote and dispensa112024.si75_nroprocesso = liclicita.l20_edital::varchar)
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
		LEFT JOIN manutencaolicitacao on (manutencaolicitacao.manutlic_licitacao = liclicita.l20_codigo)
    WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
		AND liclicita.l20_tipojulg = 3
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";

      $rsResult13 = db_query($sSql); //db_criatabela($rsResult13);

      for ($iCont13 = 0; $iCont13 < pg_num_rows($rsResult13); $iCont13++) {

        $dispensa13 = new cl_dispensa132024();
        $oDados13 = db_utils::fieldsMemory($rsResult13, $iCont13);

        $dispensa13->si77_tiporegistro = 13;
        $dispensa13->si77_reg10 = $dispensa10->si74_sequencial;
        $dispensa13->si77_codorgaoresp = $oDados13->codorgaoresp;
        if ($oDados13->codunidsubant != null || $oDados13->codunidsubant != '') {
          $dispensa13->si77_codunidadesubresp = $oDados13->codunidsubant;
        } else {
          $dispensa13->si77_codunidadesubresp = $oDados13->codunidadesubresp;
        }
        $dispensa13->si77_exercicioprocesso = $oDados13->exerciciolicitacao;
        $dispensa13->si77_nroprocesso = $oDados13->nroprocessolicitatorio;
        $dispensa13->si77_tipoprocesso = $oDados13->tipoprocesso;
        $dispensa13->si77_nrolote = $oDados13->nrolote;
        $dispensa13->si77_coditem = $oDados13->coditem;
        $dispensa13->si77_instit = db_getsession("DB_instit");
        $dispensa13->si77_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

        $dispensa13->incluir(null);
        if ($dispensa13->erro_status == 0) {
          throw new Exception($dispensa13->erro_msg);
        }
      }


      $sSql = "select DISTINCT '14' as tipoRegistro,
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
		liclicita.l20_tipoprocesso as tipoProcesso,
		(CASE parecerlicitacao.l200_tipoparecer WHEN 2 THEN 6
			ELSE 7
		END) as tipoResp,
		cgm.z01_cgccpf as nroCPFResp,
    manutencaolicitacao.manutlic_codunidsubanterior AS codunidsubant
		FROM liclicita
		INNER JOIN parecerlicitacao on (liclicita.l20_codigo=parecerlicitacao.l200_licitacao)
		INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN cgm on (parecerlicitacao.l200_numcgm=cgm.z01_numcgm)
		INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
		LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
		INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
    LEFT JOIN manutencaolicitacao on (manutencaolicitacao.manutlic_licitacao = liclicita.l20_codigo)
		WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND liclicitasituacao.l11_licsituacao = 1
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";

      $sSql .= " union select DISTINCT '14' as tipoRegistro,
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
		liclicita.l20_tipoprocesso as tipoProcesso,
		(CASE liccomissaocgm.l31_tipo WHEN '1' THEN 1
		WHEN '2' THEN 4 WHEN '3' THEN 2 WHEN '4' THEN 3 WHEN '8' THEN 5 END) as tipoResp,
		cgm.z01_cgccpf as nroCPFResp,
    manutencaolicitacao.manutlic_codunidsubanterior AS codunidsubant
		FROM liclicita
		INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
		INNER JOIN liccomissaocgm AS liccomissaocgm ON (liclicita.l20_codigo=liccomissaocgm.l31_licitacao)
		INNER JOIN cgm on (liccomissaocgm.l31_numcgm=cgm.z01_numcgm)
		LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
		INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
		LEFT JOIN manutencaolicitacao on (manutencaolicitacao.manutlic_licitacao = liclicita.l20_codigo)
    WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
		AND liclicita.l20_codigo= {$oDados10->codlicitacao} AND liccomissaocgm.l31_tipo in('1','2','3','4','8')";

      $rsResult14 = db_query($sSql); //db_criatabela($rsResult14);echo $sSql;
      $aLicitacoes1 = array();
      $tipoRes = 0;
      for ($iCont14 = 0; $iCont14 < pg_num_rows($rsResult14); $iCont14++) {

        $dispensa14 = new cl_dispensa142024();
        $oDados14 = db_utils::fieldsMemory($rsResult14, $iCont14);

        if ($oDados14->tiporesp == 7) {
          if ($tipoRes == 0) {
            $dispensa14->si78_tiporegistro = 14;
            $dispensa14->si78_reg10 = $dispensa10->si74_sequencial;
            $dispensa14->si78_codorgaoresp = $oDados14->codorgaoresp;
            if ($oDados14->codunidsubant != null || $oDados14->codunidsubant != '') {
              $dispensa14->si78_codunidadesubres = $oDados14->codunidsubant;
            } else {
              $dispensa14->si78_codunidadesubres = $oDados14->codunidadesubresp;
            }
            $dispensa14->si78_exercicioprocesso = $oDados14->exerciciolicitacao;
            $dispensa14->si78_nroprocesso = $oDados14->nroprocessolicitatorio;
            $dispensa14->si78_tipoprocesso = $oDados14->tipoprocesso;
            $dispensa14->si78_tiporesp = $oDados14->tiporesp;
            $dispensa14->si78_nrocpfresp = $oDados14->nrocpfresp;
            $dispensa14->si78_instit = db_getsession("DB_instit");
            $dispensa14->si78_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

            $dispensa14->incluir(null);
            if ($dispensa14->erro_status == 0) {
              throw new Exception($dispensa14->erro_msg);
            }
            if (!in_array($oDados10->codlicitacao, $aLicitacoes1)) {
              $aLicitacoes1[] = $oDados10->codlicitacao;

              $slq1 = "select * from precoreferencia where si01_processocompra = (select pc81_codproc from pcprocitem where pc81_codprocitem = (select max(l21_codpcprocitem) from liclicitem where l21_codliclicita = $oDados10->codlicitacao))";
              $rsResult10Preco = db_query($slq1);
              $oDados10Preco = db_utils::fieldsMemory($rsResult10Preco, 0);

              if ($oDados10Preco->si01_tipocotacao != "") {

                $slq2 = "select z01_cgccpf from cgm where z01_numcgm =  $oDados10Preco->si01_numcgmcotacao";
                $rsResultCPF = db_query($slq2);
                $rsResultCPF = db_utils::fieldsMemory($rsResultCPF, 0);

                $dispensa14->si78_tiporegistro = 14;
                $dispensa14->si78_reg10 = $dispensa10->si74_sequencial;
                $dispensa14->si78_codorgaoresp = $oDados14->codorgaoresp;
                if ($oDados14->codunidsubant != null || $oDados14->codunidsubant != '') {
                  $dispensa14->si78_codunidadesubres = $oDados14->codunidsubant;
                } else {
                  $dispensa14->si78_codunidadesubres = $oDados14->codunidadesubresp;
                }
                $dispensa14->si78_exercicioprocesso = $oDados14->exerciciolicitacao;
                $dispensa14->si78_nroprocesso = $oDados14->nroprocessolicitatorio;
                $dispensa14->si78_tipoprocesso = $oDados14->tipoprocesso;
                $dispensa14->si78_tiporesp = 2;
                $dispensa14->si78_nrocpfresp = $rsResultCPF->z01_cgccpf;
                $dispensa14->si78_instit = db_getsession("DB_instit");
                $dispensa14->si78_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $dispensa14->incluir(null);

                $slq3 = "select z01_cgccpf from cgm where z01_numcgm =  $oDados10Preco->si01_numcgmorcamento";
                $rsResultCPF1 = db_query($slq3);
                $rsResultCPF1 = db_utils::fieldsMemory($rsResultCPF1, 0);

                $dispensa14->si78_tiporegistro = 14;
                $dispensa14->si78_reg10 = $dispensa10->si74_sequencial;
                $dispensa14->si78_codorgaoresp = $oDados14->codorgaoresp;
                if ($oDados14->codunidsubant != null || $oDados14->codunidsubant != '') {
                  $dispensa14->si78_codunidadesubres = $oDados14->codunidsubant;
                } else {
                  $dispensa14->si78_codunidadesubres = $oDados14->codunidadesubresp;
                }
                $dispensa14->si78_exercicioprocesso = $oDados14->exerciciolicitacao;
                $dispensa14->si78_nroprocesso = $oDados14->nroprocessolicitatorio;
                $dispensa14->si78_tipoprocesso = $oDados14->tipoprocesso;
                $dispensa14->si78_tiporesp = 3;
                $dispensa14->si78_nrocpfresp = $rsResultCPF1->z01_cgccpf;
                $dispensa14->si78_instit = db_getsession("DB_instit");
                $dispensa14->si78_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $dispensa14->incluir(null);
              }
            }
            $tipoRes = 1;
          }
        } else {

          $dispensa14->si78_tiporegistro = 14;
          $dispensa14->si78_reg10 = $dispensa10->si74_sequencial;
          $dispensa14->si78_codorgaoresp = $oDados14->codorgaoresp;
          if ($oDados14->codunidsubant != null || $oDados14->codunidsubant != '') {
            $dispensa14->si78_codunidadesubres = $oDados14->codunidsubant;
          } else {
            $dispensa14->si78_codunidadesubres = $oDados14->codunidadesubresp;
          }
          $dispensa14->si78_exercicioprocesso = $oDados14->exerciciolicitacao;
          $dispensa14->si78_nroprocesso = $oDados14->nroprocessolicitatorio;
          $dispensa14->si78_tipoprocesso = $oDados14->tipoprocesso;
          $dispensa14->si78_tiporesp = $oDados14->tiporesp;
          $dispensa14->si78_nrocpfresp = $oDados14->nrocpfresp;
          $dispensa14->si78_instit = db_getsession("DB_instit");
          $dispensa14->si78_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

          $dispensa14->incluir(null);
          if ($dispensa14->erro_status == 0) {
            throw new Exception($dispensa14->erro_msg);
          }
          if (!in_array($oDados10->codlicitacao, $aLicitacoes1)) {
            $aLicitacoes1[] = $oDados10->codlicitacao;

            $slq1 = "select * from precoreferencia where si01_processocompra = (select pc81_codproc from pcprocitem where pc81_codprocitem = (select max(l21_codpcprocitem) from liclicitem where l21_codliclicita = $oDados10->codlicitacao))";
            $rsResult10Preco = db_query($slq1);
            $oDados10Preco = db_utils::fieldsMemory($rsResult10Preco, 0);

            if ($oDados10Preco->si01_tipocotacao != "") {

              $slq2 = "select z01_cgccpf from cgm where z01_numcgm =  $oDados10Preco->si01_numcgmcotacao";
              $rsResultCPF = db_query($slq2);
              $rsResultCPF = db_utils::fieldsMemory($rsResultCPF, 0);

              $dispensa14->si78_tiporegistro = 14;
              $dispensa14->si78_reg10 = $dispensa10->si74_sequencial;
              $dispensa14->si78_codorgaoresp = $oDados14->codorgaoresp;
              if ($oDados14->codunidsubant != null || $oDados14->codunidsubant != '') {
                $dispensa14->si78_codunidadesubres = $oDados14->codunidsubant;
              } else {
                $dispensa14->si78_codunidadesubres = $oDados14->codunidadesubresp;
              }
              $dispensa14->si78_exercicioprocesso = $oDados14->exerciciolicitacao;
              $dispensa14->si78_nroprocesso = $oDados14->nroprocessolicitatorio;
              $dispensa14->si78_tipoprocesso = $oDados14->tipoprocesso;
              $dispensa14->si78_tiporesp = 2;
              $dispensa14->si78_nrocpfresp = $rsResultCPF->z01_cgccpf;
              $dispensa14->si78_instit = db_getsession("DB_instit");
              $dispensa14->si78_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
              $dispensa14->incluir(null);

              $slq3 = "select z01_cgccpf from cgm where z01_numcgm =  $oDados10Preco->si01_numcgmorcamento";
              $rsResultCPF1 = db_query($slq3);
              $rsResultCPF1 = db_utils::fieldsMemory($rsResultCPF1, 0);

              $dispensa14->si78_tiporegistro = 14;
              $dispensa14->si78_reg10 = $dispensa10->si74_sequencial;
              $dispensa14->si78_codorgaoresp = $oDados14->codorgaoresp;
              if ($oDados14->codunidsubant != null || $oDados14->codunidsubant != '') {
                $dispensa14->si78_codunidadesubres = $oDados14->codunidsubant;
              } else {
                $dispensa14->si78_codunidadesubres = $oDados14->codunidadesubresp;
              }
              $dispensa14->si78_exercicioprocesso = $oDados14->exerciciolicitacao;
              $dispensa14->si78_nroprocesso = $oDados14->nroprocessolicitatorio;
              $dispensa14->si78_tipoprocesso = $oDados14->tipoprocesso;
              $dispensa14->si78_tiporesp = 3;
              $dispensa14->si78_nrocpfresp = $rsResultCPF1->z01_cgccpf;
              $dispensa14->si78_instit = db_getsession("DB_instit");
              $dispensa14->si78_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
              $dispensa14->incluir(null);
            }
          }
        }
      }

      $sSql = "select DISTINCT '15' as tipoRegistro,
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
		liclicita.l20_tipoprocesso as tipoProcesso,
		dispensa112024.si75_nrolote as nroLote,
    CASE
    WHEN (pcmater.pc01_codmaterant != 0 or pcmater.pc01_codmaterant != null) THEN pcmater.pc01_codmaterant::varchar
  ELSE (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) END AS coditem,
		itemprecoreferencia.si02_vlprecoreferencia as vlCotPrecosUnitario,
		pcorcamval.pc23_quant as quantidade,
    manutencaolicitacao.manutlic_codunidsubanterior AS codunidsubant
		FROM liclicitem
		INNER JOIN liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
		LEFT  JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem AND liclicita.l20_tipojulg = 3)
		LEFT  JOIN dispensa112024 on (liclicitemlote.l04_descricao = dispensa112024.si75_dsclote and dispensa112024.si75_nroprocesso = liclicita.l20_edital::varchar)
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
		LEFT JOIN manutencaolicitacao on (manutencaolicitacao.manutlic_licitacao = liclicita.l20_codigo)
    WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";


      $rsResult15 = db_query($sSql); //db_criatabela($rsResult15);
      $aDadosAgrupados15 = array();
      for ($iCont15 = 0; $iCont15 < pg_num_rows($rsResult15); $iCont15++) {

        $oResult15 = db_utils::fieldsMemory($rsResult15, $iCont15);

        $sHash15 = $oResult15->exerciciolicitacao . $oResult15->nroprocessolicitatorio . $oResult15->nrolote . $oResult15->coditem;

        if (!isset($aDadosAgrupados15[$sHash15])) {

          $oDados15 = new stdClass();
          $oDados15->si79_tiporegistro = 15;
          $oDados15->si79_reg10 = $dispensa10->si74_sequencial;
          $oDados15->si79_codorgaoresp = $oResult15->codorgaoresp;
          if ($oResult15->codunidsubant != null || $oResult15->codunidsubant != '') {
            $oDados15->si79_codunidadesubresp = $oResult15->codunidsubant;
          } else {
            $oDados15->si79_codunidadesubresp = $oResult15->codunidadesubresp;
          }
          $oDados15->si79_exercicioprocesso = $oResult15->exerciciolicitacao;
          $oDados15->si79_nroprocesso = $oResult15->nroprocessolicitatorio;
          $oDados15->si79_tipoprocesso = $oResult15->tipoprocesso;
          $oDados15->si79_nrolote = $oResult15->nrolote;
          $oDados15->si79_coditem = $oResult15->coditem;
          $oDados15->si79_vlcotprecosunitario = $oResult15->vlcotprecosunitario;
          $oDados15->si79_quantidade = $oResult15->quantidade;
          $oDados15->si79_instit = db_getsession("DB_instit");
          $oDados15->si79_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
          $aDadosAgrupados15[$sHash15] = $oDados15;
        } else {
          $aDadosAgrupados15[$sHash15]->si79_quantidade += $oResult15->quantidade;
        }
      }

      foreach ($aDadosAgrupados15 as $oDadosAgrupados15) {

        $dispensa15 = new cl_dispensa152024();

        $dispensa15->si79_tiporegistro = 15;
        $dispensa15->si79_reg10 = $oDadosAgrupados15->si79_reg10;
        $dispensa15->si79_codorgaoresp = $oDadosAgrupados15->si79_codorgaoresp;
        if ($oDadosAgrupados15->codunidsubant != null || $oDadosAgrupados15->codunidsubant != '') {
          $dispensa15->si79_codunidadesubresp = $oDadosAgrupados15->codunidsubant;
        } else {
          $dispensa15->si79_codunidadesubresp = $oDadosAgrupados15->codunidadesubresp;
        }
        $dispensa15->si79_codunidadesubresp = $oDadosAgrupados15->si79_codunidadesubresp;
        $dispensa15->si79_exercicioprocesso = $oDadosAgrupados15->si79_exercicioprocesso;
        $dispensa15->si79_nroprocesso = $oDadosAgrupados15->si79_nroprocesso;
        $dispensa15->si79_tipoprocesso = $oDadosAgrupados15->si79_tipoprocesso;
        $dispensa15->si79_nrolote = $oDadosAgrupados15->si79_nrolote;
        $dispensa15->si79_coditem = $oDadosAgrupados15->si79_coditem;
        $dispensa15->si79_vlcotprecosunitario = $oDadosAgrupados15->si79_vlcotprecosunitario;
        $dispensa15->si79_quantidade = $oDadosAgrupados15->si79_quantidade;
        $dispensa15->si79_instit = $oDadosAgrupados15->si79_instit;
        $dispensa15->si79_mes = $oDadosAgrupados15->si79_mes;


        $dispensa15->incluir(null);
        if ($dispensa15->erro_status == 0) {
          throw new Exception($dispensa15->erro_msg);
        }
      }

      $sSql = "select DISTINCT '16' as tipoRegistro,
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
		liclicita.l20_tipoprocesso as tipoProcesso,
		infocomplementaresinstit.si09_codorgaotce as codorgaotce,
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
		o55_origemacao as idSubAcao,
		substr(orcelemento.o56_elemento,2,6) as naturezaDespesa,
		orctiporec.o15_codtri as codFontRecursos,
		orcdotacao.o58_valor as vlRecurso,
    manutencaolicitacao.manutlic_codunidsubanterior AS codunidsubant
		FROM liclicita
		INNER JOIN liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
		INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN pcprocitem on (liclicitem.l21_codpcprocitem=pcprocitem.pc81_codprocitem)
		INNER JOIN pcdotac on (pcprocitem.pc81_solicitem=pcdotac.pc13_codigo)
		INNER JOIN orcdotacao on (pcdotac.pc13_anousu=orcdotacao.o58_anousu and pcdotac.pc13_coddot=orcdotacao.o58_coddot)
		inner join orcunidade on o41_anousu = o58_anousu and o41_orgao = o58_orgao and o41_unidade = o58_unidade
		inner join orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
		INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
		INNER JOIN orctiporec on (orcdotacao.o58_codigo=orctiporec.o15_codigo)
		INNER JOIN orcelemento on (orcdotacao.o58_anousu=orcelemento.o56_anousu and orcdotacao.o58_codele=orcelemento.o56_codele)
		INNER JOIN orcprojativ on o58_anousu = o55_anousu and o58_projativ = o55_projativ
		LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
		INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
		LEFT JOIN manutencaolicitacao on (manutencaolicitacao.manutlic_licitacao = liclicita.l20_codigo)
    WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";

      $rsResult16 = db_query($sSql);

      for ($iCont16 = 0; $iCont16 < pg_num_rows($rsResult16); $iCont16++) {

        $dispensa16 = new cl_dispensa162024();
        $oDados16 = db_utils::fieldsMemory($rsResult16, $iCont16);

        $dispensa16->si80_tiporegistro = 16;
        $dispensa16->si80_reg10 = $dispensa10->si74_sequencial;
        $dispensa16->si80_codorgaoresp = $oDados16->codorgaoresp;
        if ($oDados16->codunidsubant != null || $oDados16->codunidsubant != '') {
          $dispensa16->si80_codunidadesubresp = $oDados16->codunidsubant;
        } else {
          $dispensa16->si80_codunidadesubresp = $oDados16->codunidadesubresp;
        }

        $dispensa16->si80_exercicioprocesso = $oDados16->exerciciolicitacao;
        $dispensa16->si80_nroprocesso = $oDados16->nroprocessolicitatorio;
        if($oDados16->tipoprocesso == "5" || $oDados16->tipoprocesso == "6"){
          $dispensa16->si80_tipoprocesso = '';
        } else {
          $dispensa16->si80_tipoprocesso = $oDados16->tipoprocesso;
        }
        $dispensa16->si80_codorgao = $oDados16->codorgaotce;
        $dispensa16->si80_codunidadesub = $oDados16->codunidadesub;
        $dispensa16->si80_codfuncao = $oDados16->codfuncao;
        $dispensa16->si80_codsubfuncao = $oDados16->codsubfuncao;
        $dispensa16->si80_codprograma = $oDados16->codprograma;
        $dispensa16->si80_idacao = $oDados16->idacao;
        $dispensa16->si80_idsubacao = $oDados16->idsubacao;
        $dispensa16->si80_naturezadespesa = $oDados16->naturezadespesa;
        $dispensa16->si80_codfontrecursos = $oDados16->codfontrecursos;
        $dispensa16->si80_vlrecurso = $oDados16->vlrecurso;
        $dispensa16->si80_instit = db_getsession("DB_instit");
        $dispensa16->si80_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];


        $dispensa16->incluir(null);
        if ($dispensa16->erro_status == 0) {
          throw new Exception($dispensa16->erro_msg);
        }
      }


      $sSql = "select DISTINCT '17' as tipoRegistro,
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
	liclicita.l20_tipoprocesso as tipoProcesso,
	(CASE length(cgm.z01_cgccpf) WHEN 11 THEN 1
		ELSE 2
	END) as tipoDocumento,
	(
    select
    z01_cgccpf
    from
      cgm
    join pcorcamforne pof on
      pof.pc21_numcgm = cgm.z01_numcgm
    where
      pof.pc21_orcamforne = pcorcamforne.pc21_orcamforne) as nroDocumento,
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
	dispensa112024.si75_nrolote as nroLote,
  CASE
  WHEN (pcmater.pc01_codmaterant != 0 or pcmater.pc01_codmaterant != null) THEN pcmater.pc01_codmaterant::varchar
ELSE (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) END AS coditem,
	pcorcamval.pc23_vlrun as vlUnitario,
	pcorcamval.pc23_quant as quantidade,
  manutencaolicitacao.manutlic_codunidsubanterior AS codunidsubant
	FROM liclicita
	INNER JOIN habilitacaoforn on (liclicita.l20_codigo=habilitacaoforn.l206_licitacao)
	INNER JOIN pcforne on (habilitacaoforn.l206_fornecedor=pcforne.pc60_numcgm)
	INNER JOIN cgm on (pcforne.pc60_numcgm=cgm.z01_numcgm)
	INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
	INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
	INNER JOIN liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
	INNER JOIN pcorcamitemlic ON (liclicitem.l21_codigo = pcorcamitemlic.pc26_liclicitem )
	INNER JOIN pcorcamitem ON (pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem)

	inner join pcorcam on pc20_codorc = pc22_codorc

inner join pcorcamforne on
	(pcorcam.pc20_codorc = pcorcamforne.pc21_codorc)


inner join pcorcamjulg on
	(pcorcamitem.pc22_orcamitem = pcorcamjulg.pc24_orcamitem
	and pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne)

  INNER JOIN pcprocitem  ON (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
	INNER JOIN solicitem ON (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
	INNER JOIN solicitempcmater ON (solicitem.pc11_codigo=solicitempcmater.pc16_solicitem)
  inner join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater
	INNER JOIN pcorcamval ON (pcorcamitem.pc22_orcamitem = pcorcamval.pc23_orcamitem and pcorcamforne.pc21_orcamforne=pcorcamval.pc23_orcamforne)
	LEFT  JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem AND liclicita.l20_tipojulg = 3)
	LEFT  JOIN dispensa112024 on (liclicitemlote.l04_descricao = dispensa112024.si75_dsclote and dispensa112024.si75_nroprocesso = liclicita.l20_edital::varchar)
	LEFT JOIN pcorcamjulg as julgamento ON julgamento.pc24_orcamitem = pcorcamitem.pc22_orcamitem
  AND pcorcamforne.pc21_orcamforne = julgamento.pc24_orcamforne
  INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
	LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
  LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
	LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
	INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
	LEFT JOIN manutencaolicitacao on (manutencaolicitacao.manutlic_licitacao = liclicita.l20_codigo)
  WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
	AND liclicita.l20_codigo= {$oDados10->codlicitacao} AND pctipocompratribunal.l44_sequencial in (100,101) AND julgamento.pc24_pontuacao=1";

      // echo $sSql;
      // exit;
      $rsResult17 = db_query($sSql); //db_criatabela($rsResult17);
      $aDadosAgrupados17 = array();
      for ($iCont17 = 0; $iCont17 < pg_num_rows($rsResult17); $iCont17++) {

        $oResult17 = db_utils::fieldsMemory($rsResult17, $iCont17);
        $sHash17 = $oResult17->exerciciolicitacao . $oResult17->nroprocessolicitatorio . $oResult17->nrolote . $oResult17->coditem;
        if (!isset($aDadosAgrupados17[$sHash17])) {

          $oDados17 = new stdClass;

          $oDados17->si81_tiporegistro = 17;
          $oDados17->si81_codorgaoresp = $oResult17->codorgaoresp;
          if ($oResult17->codunidsubant != null || $oResult17->codunidsubant != '') {
            $oDados17->si81_codunidadesubresp = $oResult17->codunidsubant;
          } else {
            $oDados17->si81_codunidadesubresp = $oResult17->codunidadesubresp;
          }
          $oDados17->si81_codunidadesubresp = $oResult17->codunidadesubresp;
          $oDados17->si81_exercicioprocesso = $oResult17->exerciciolicitacao;
          $oDados17->si81_nroprocesso = $oResult17->nroprocessolicitatorio;
          $oDados17->si81_tipoprocesso = $oResult17->tipoprocesso;
          $oDados17->si81_tipodocumento = $oResult17->tipodocumento;
          $oDados17->si81_nrodocumento = $oResult17->nrodocumento;
          $oDados17->si81_nroinscricaoestadual = $oResult17->nroinscricaoestadual;
          $oDados17->si81_ufinscricaoestadual = $oResult17->ufinscricaoestadual;
          $oDados17->si81_nrocertidaoregularidadeinss = $oResult17->tipodocumento == 2 ? $oResult17->nrocertidaoregularidadeinss : "";
          $oDados17->si81_dtemissaocertidaoregularidadeinss = $oResult17->tipodocumento == 2 ? $oResult17->dataemissaocertidaoregularidadeinss : "";
          $oDados17->si81_dtvalidadecertidaoregularidadeinss = $oResult17->tipodocumento == 2 ? $oResult17->datavalidadecertidaoregularidadeinss : "";
          $oDados17->si81_nrocertidaoregularidadefgts = $oResult17->tipodocumento == 2 ? $oResult17->nrocertidaoregularidadefgts : "";
          $oDados17->si81_dtemissaocertidaoregularidadefgts = $oResult17->tipodocumento == 2 ? $oResult17->dataemissaocertidaoregularidadefgts : "";
          $oDados17->si81_dtvalidadecertidaoregularidadefgts = $oResult17->tipodocumento == 2 ? $oResult17->datavalidadecertidaoregularidadefgts : "";
          $oDados17->si81_nrocndt = $oResult17->tipodocumento == 1 ? ' ' : $oResult17->nrocndt;
          $oDados17->si81_dtemissaocndt = $oResult17->tipodocumento == 1 ? '' : $oResult17->dtemissaocndt;
          $oDados17->si81_dtvalidadecndt = $oResult17->tipodocumento == 1 ? '' : $oResult17->dtvalidadecndt;
          $oDados17->si81_nrolote = $oResult17->nrolote;
          $oDados17->si81_coditem = $oResult17->coditem;
          $oDados17->si81_vlitem = $oResult17->vlunitario;
          $oDados17->si81_quantidade = $oResult17->quantidade;
          $oDados17->si81_instit = db_getsession("DB_instit");
          $oDados17->si81_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
          $oDados17->si81_reg10 = $dispensa10->si74_sequencial;

          $aDadosAgrupados17[$sHash17] = $oDados17;
        } else {
          $aDadosAgrupados17[$sHash17]->si81_quantidade += $oResult17->quantidade;
        }
      }

      foreach ($aDadosAgrupados17 as $oDadosAgrupados17) {

        $dispensa17 = new cl_dispensa172024();

        $dispensa17->si81_tiporegistro = 17;
        $dispensa17->si81_codorgaoresp = $oDadosAgrupados17->si81_codorgaoresp;
        if ($oDadosAgrupados17->codunidsubant != null || $oDadosAgrupados17->codunidsubant != '') {
          $dispensa17->si81_codunidadesubresp = $oDadosAgrupados17->codunidsubant;
        } else {
          $dispensa17->si81_codunidadesubresp = $oDadosAgrupados17->si81_codunidadesubresp;
        }

        $dispensa17->si81_exercicioprocesso = $oDadosAgrupados17->si81_exercicioprocesso;
        $dispensa17->si81_nroprocesso = $oDadosAgrupados17->si81_nroprocesso;
        $dispensa17->si81_tipoprocesso = $oDadosAgrupados17->si81_tipoprocesso;
        $dispensa17->si81_tipodocumento = $oDadosAgrupados17->si81_tipodocumento;
        $dispensa17->si81_nrodocumento = $oDadosAgrupados17->si81_nrodocumento;
        $dispensa17->si81_nroinscricaoestadual = $oDadosAgrupados17->si81_nroinscricaoestadual;
        $dispensa17->si81_ufinscricaoestadual = $oDadosAgrupados17->si81_ufinscricaoestadual;
        $dispensa17->si81_nrocertidaoregularidadeinss = $oDadosAgrupados17->si81_nrocertidaoregularidadeinss;
        $dispensa17->si81_dtemissaocertidaoregularidadeinss = $oDadosAgrupados17->si81_dtemissaocertidaoregularidadeinss;
        $dispensa17->si81_dtvalidadecertidaoregularidadeinss = $oDadosAgrupados17->si81_dtvalidadecertidaoregularidadeinss;
        $dispensa17->si81_nrocertidaoregularidadefgts = $oDadosAgrupados17->si81_nrocertidaoregularidadefgts;
        $dispensa17->si81_dtemissaocertidaoregularidadefgts = $oDadosAgrupados17->si81_dtemissaocertidaoregularidadefgts;
        $dispensa17->si81_dtvalidadecertidaoregularidadefgts = $oDadosAgrupados17->si81_dtvalidadecertidaoregularidadefgts;
        $dispensa17->si81_nrocndt = $oDadosAgrupados17->si81_nrocndt;
        $dispensa17->si81_dtemissaocndt = $oDadosAgrupados17->si81_dtemissaocndt;
        $dispensa17->si81_dtvalidadecndt = $oDadosAgrupados17->si81_dtvalidadecndt;
        $dispensa17->si81_nrolote = $oDadosAgrupados17->si81_nrolote;
        $dispensa17->si81_coditem = $oDadosAgrupados17->si81_coditem;
        $dispensa17->si81_vlitem = $oDadosAgrupados17->si81_vlitem;
        $dispensa17->si81_quantidade = $oDadosAgrupados17->si81_quantidade;
        $dispensa17->si81_instit = $oDadosAgrupados17->si81_instit;
        $dispensa17->si81_mes = $oDadosAgrupados17->si81_mes;
        $dispensa17->si81_reg10 = $oDadosAgrupados17->si81_reg10;


        $dispensa17->incluir(null);
        if ($dispensa17->erro_status == 0) {
          throw new Exception($dispensa17->erro_msg);
        }
      }
    }
    $sSql = "select DISTINCT '20' as tipoRegistro,
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
	pctipocompratribunal.l44_codigotribunal as tipoProcesso,
	(CASE length(cgm.z01_cgccpf) WHEN 11 THEN 1
		ELSE 2
	END) as tipoDocumento,
	cgm.z01_cgccpf as nroDocumento,
	credenciamento.l205_datacred as dataCredenciamento,
	dispensa112024.si75_nrolote as nroLote,
  CASE
  WHEN (pcmater.pc01_codmaterant != 0 or pcmater.pc01_codmaterant != null) THEN pcmater.pc01_codmaterant::varchar
ELSE (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) END AS coditem,
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
  manutencaolicitacao.manutlic_codunidsubanterior AS codunidsubant
	FROM liclicita
	INNER JOIN habilitacaoforn on (liclicita.l20_codigo=habilitacaoforn.l206_licitacao)
	INNER JOIN credenciamento on (liclicita.l20_codigo=credenciamento.l205_licitacao) and l205_fornecedor = l206_fornecedor
	INNER JOIN pcforne on (habilitacaoforn.l206_fornecedor=pcforne.pc60_numcgm)
	INNER JOIN cgm on (pcforne.pc60_numcgm=cgm.z01_numcgm)
	INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
	INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
	INNER JOIN liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita) and (liclicitem.l21_codpcprocitem = credenciamento.l205_item)
	INNER JOIN pcorcamitemlic ON (liclicitem.l21_codigo = pcorcamitemlic.pc26_liclicitem )
	INNER JOIN pcorcamitem ON (pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem)
	INNER JOIN pcprocitem  ON (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
	INNER JOIN solicitem ON (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
	INNER JOIN solicitempcmater ON (solicitem.pc11_codigo=solicitempcmater.pc16_solicitem)
	INNER JOIN pcmater on (solicitempcmater.pc16_codmater = pcmater.pc01_codmater)
	INNER JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
	LEFT JOIN dispensa112024 on (liclicitemlote.l04_descricao = dispensa112024.si75_dsclote and dispensa112024.si75_nroprocesso = liclicita.l20_edital::varchar)
	INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
	LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
  LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
	LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
	INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
	LEFT JOIN manutencaolicitacao on (manutencaolicitacao.manutlic_licitacao = liclicita.l20_codigo)
  WHERE db_config.codigo= " . db_getsession("DB_instit") . "
	AND DATE_PART('YEAR',credenciamento.l205_datacred)= " . db_getsession("DB_anousu") . "
  AND DATE_PART('MONTH',credenciamento.l205_datacred)=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];


    $rsResult18 = db_query($sSql); //echo $sSql; db_criatabela($rsResult18);die();

    for ($iCont18 = 0; $iCont18 < pg_num_rows($rsResult18); $iCont18++) {

      $dispensa18 = new cl_dispensa182024();
      $oDados18 = db_utils::fieldsMemory($rsResult18, $iCont18);

      $dispensa18->si82_tiporegistro = 20;
      $dispensa18->si82_codorgaoresp = $oDados18->codorgaoresp;
      if ($oDados18->codunidsubant != null || $oDados18->codunidsubant != '') {
        $dispensa18->si82_codunidadesubresp = $oDados18->codunidsubant;
      } else {
        $dispensa18->si82_codunidadesubresp = $oDados18->codunidadesubresp;
      }

      $dispensa18->si82_exercicioprocesso = $oDados18->exerciciolicitacao;
      $dispensa18->si82_nroprocesso = $oDados18->nroprocessolicitatorio;
      $dispensa18->si82_tipoprocesso = $oDados18->tipoprocesso;
      $dispensa18->si82_tipodocumento = $oDados18->tipodocumento;
      $dispensa18->si82_nrodocumento = $oDados18->nrodocumento;
      $dispensa18->si82_datacredenciamento = $oDados18->datacredenciamento;
      $dispensa18->si82_nrolote = $oDados18->nrolote;
      $dispensa18->si82_coditem = $oDados18->coditem;
      $dispensa18->si82_nroinscricaoestadual = $oDados18->nroinscricaoestadual;
      $dispensa18->si82_ufinscricaoestadual = $oDados18->ufinscricaoestadual;
      $dispensa18->si82_nrocertidaoregularidadeinss = $oDados18->nrocertidaoregularidadeinss;
      $dispensa18->si82_dataemissaocertidaoregularidadeinss = $oDados18->dataemissaocertidaoregularidadeinss;
      $dispensa18->si82_dtvalidadecertidaoregularidadeinssd = $oDados18->datavalidadecertidaoregularidadeinss;
      $dispensa18->si82_nrocertidaoregularidadefgts = $oDados18->nrocertidaoregularidadefgts;
      $dispensa18->si82_dtemissaocertidaoregularidadefgts = $oDados18->dataemissaocertidaoregularidadefgts;
      $dispensa18->si82_nrocndt = $oDados18->nrocndt;
      $dispensa18->si82_dtemissaocndt = $oDados18->dtemissaocndt;
      $dispensa18->si82_dtvalidadecndt = $oDados18->dtvalidadecndt;
      $dispensa18->si82_instit = db_getsession("DB_instit");
      $dispensa18->si82_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $dispensa18->si82_reg10 = $dispensa10->si74_sequencial;

      $dispensa18->incluir(null);
      if ($dispensa18->erro_status == 0) {
        throw new Exception($dispensa18->erro_msg);
      }
    }
    
    
    $sSql = "select distinct on (l20_codigo)l20_codigo, infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
    l20_tipojulg,
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
    liclicita.l20_tipoprocesso as tipoProcesso,
    liclicitemlote.l04_numerolote as nroLote,
    manutencaolicitacao.manutlic_codunidsubanterior AS codunidsubant,
     CASE
      WHEN (pcmater.pc01_codmaterant != 0 or pcmater.pc01_codmaterant != null) THEN pcmater.pc01_codmaterant::varchar
    ELSE (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) END AS coditem,
    (CASE length(cgm.z01_cgccpf) WHEN 11 THEN 1 ELSE 2 END) as tipoDocumento,
    (
        select
        z01_cgccpf
        from
          cgm
        join pcorcamforne pof on
          pof.pc21_numcgm = cgm.z01_numcgm
        where
          pof.pc21_orcamforne = pcorcamforne.pc21_orcamforne) as nroDocumento,
          pcorcamval.pc23_perctaxadesctabela as percDesconto,
    * from liclicita
    INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
    INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
    INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
    INNER JOIN habilitacaoforn on (liclicita.l20_codigo=habilitacaoforn.l206_licitacao)
    INNER JOIN pcforne on (habilitacaoforn.l206_fornecedor=pcforne.pc60_numcgm)
    INNER JOIN cgm on (pcforne.pc60_numcgm=cgm.z01_numcgm)
    INNER JOIN liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
    INNER JOIN pcorcamitemlic ON (liclicitem.l21_codigo = pcorcamitemlic.pc26_liclicitem )
    INNER JOIN pcorcamitem ON (pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem)
    INNER join pcorcam on pc20_codorc = pc22_codorc
    INNER join pcorcamforne on (pcorcam.pc20_codorc = pcorcamforne.pc21_codorc)
    inner join pcorcamjulg on
      (pcorcamitem.pc22_orcamitem = pcorcamjulg.pc24_orcamitem
      and pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne)
        INNER JOIN pcorcamval ON (pcorcamjulg.pc24_orcamitem = pcorcamval.pc23_orcamitem and pcorcamjulg.pc24_orcamforne=pcorcamval.pc23_orcamforne)
      INNER JOIN pcprocitem  ON (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
      INNER JOIN solicitem ON (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
      INNER JOIN solicitempcmater ON (solicitem.pc11_codigo=solicitempcmater.pc16_solicitem)
      inner join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater
    INNER JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
      LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
      LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
    LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
    LEFT JOIN manutencaolicitacao on (manutencaolicitacao.manutlic_licitacao = liclicita.l20_codigo)
    WHERE db_config.codigo= " . db_getsession("DB_instit") . "
	AND pctipocompratribunal.l44_sequencial in (100,101,102,103) AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
	AND DATE_PART('YEAR',l20_dtpubratificacao)=" . db_getsession("DB_anousu") . "
	AND DATE_PART('MONTH',l20_dtpubratificacao)=" . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and l20_criterioadjudicacao = 1;";

    $rsRegistro30 = db_query($sSql);

    for ($i = 0; $i < pg_num_rows($rsRegistro30); $i++) {

      $dispensa30 = new cl_dispensa302024();
      $oDados30 = db_utils::fieldsMemory($rsRegistro30, $i);

      $dispensa30->si203_tiporegistro = 30;
      $dispensa30->si203_codorgaoresp = $oDados30->codorgaoresp;
      $dispensa30->si203_codunidadesubresp = $oDados30->codunidsubant != null || $oDados30->codunidsubant != '' ? $oDados30->codunidsubant : $oDados30->codunidadesubresp;
      $dispensa30->si203_exercicioprocesso = $oDados30->exerciciolicitacao;
      $dispensa30->si203_nroprocesso = $oDados30->nroprocessolicitatorio;
      $dispensa30->si203_tipoprocesso = $oDados30->tipoprocesso;
      $dispensa30->si203_tipodocumento = $oDados30->tipodocumento;
      $dispensa30->si203_nrodocumento = $oDados30->nrodocumento;
      $dispensa30->si203_nrolote = $oDados30->nrolote;
      $dispensa30->si203_coditem = $oDados30->l20_tipojulg == 2 ? '' : $oDados30->coditem;
      $dispensa30->si203_percdesconto = $oDados30->percdesconto;
      $dispensa30->si203_instit = db_getsession("DB_instit");
      $dispensa30->si203_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

      $dispensa30->incluir(null);

      if ($dispensa30->erro_status == 0) {
          throw new Exception($dispensa30->erro_msg);
      }

    }

    $sSql = "select distinct on (l20_codigo)l20_codigo, infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
    l20_tipojulg,
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
    liclicita.l20_tipoprocesso as tipoProcesso,
    liclicitemlote.l04_numerolote as nroLote,
    manutencaolicitacao.manutlic_codunidsubanterior AS codunidsubant,
     CASE
      WHEN (pcmater.pc01_codmaterant != 0 or pcmater.pc01_codmaterant != null) THEN pcmater.pc01_codmaterant::varchar
    ELSE (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) END AS coditem,
    (CASE length(cgm.z01_cgccpf) WHEN 11 THEN 1 ELSE 2 END) as tipoDocumento,
    (
        select
        z01_cgccpf
        from
          cgm
        join pcorcamforne pof on
          pof.pc21_numcgm = cgm.z01_numcgm
        where
          pof.pc21_orcamforne = pcorcamforne.pc21_orcamforne) as nroDocumento,
          pcorcamval.pc23_percentualdesconto as perctaxaadm,
    * from liclicita
    INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
    INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
    INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
    INNER JOIN habilitacaoforn on (liclicita.l20_codigo=habilitacaoforn.l206_licitacao)
    INNER JOIN pcforne on (habilitacaoforn.l206_fornecedor=pcforne.pc60_numcgm)
    INNER JOIN cgm on (pcforne.pc60_numcgm=cgm.z01_numcgm)
    INNER JOIN liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita)
    INNER JOIN pcorcamitemlic ON (liclicitem.l21_codigo = pcorcamitemlic.pc26_liclicitem )
    INNER JOIN pcorcamitem ON (pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem)
    INNER join pcorcam on pc20_codorc = pc22_codorc
    INNER join pcorcamforne on (pcorcam.pc20_codorc = pcorcamforne.pc21_codorc)
    inner join pcorcamjulg on
      (pcorcamitem.pc22_orcamitem = pcorcamjulg.pc24_orcamitem
      and pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne)
        INNER JOIN pcorcamval ON (pcorcamjulg.pc24_orcamitem = pcorcamval.pc23_orcamitem and pcorcamjulg.pc24_orcamforne=pcorcamval.pc23_orcamforne)
      INNER JOIN pcprocitem  ON (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
      INNER JOIN solicitem ON (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
      INNER JOIN solicitempcmater ON (solicitem.pc11_codigo=solicitempcmater.pc16_solicitem)
      inner join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater
    INNER JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
      LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
      LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
    LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
    LEFT JOIN manutencaolicitacao on (manutencaolicitacao.manutlic_licitacao = liclicita.l20_codigo)
    WHERE db_config.codigo= " . db_getsession("DB_instit") . "
	AND pctipocompratribunal.l44_sequencial in (100,101,102,103) AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
	AND DATE_PART('YEAR',l20_dtpubratificacao)=" . db_getsession("DB_anousu") . "
	AND DATE_PART('MONTH',l20_dtpubratificacao)=" . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and l20_criterioadjudicacao = 2;";

    $rsRegistro40 = db_query($sSql);

    for ($i = 0; $i < pg_num_rows($rsRegistro40); $i++) {

      $dispensa40 = new cl_dispensa402024();
      $oDados40 = db_utils::fieldsMemory($rsRegistro40, $i);

      $dispensa40->si204_tiporegistro = 40;
      $dispensa40->si204_codorgaoresp = $oDados40->codorgaoresp;
      $dispensa40->si204_codunidadesubresp = $oDados40->codunidsubant != null || $oDados40->codunidsubant != '' ? $oDados40->codunidsubant : $oDados40->codunidadesubresp;
      $dispensa40->si204_exercicioprocesso = $oDados40->exerciciolicitacao;
      $dispensa40->si204_nroprocesso = $oDados40->nroprocessolicitatorio;
      $dispensa40->si204_tipoprocesso = $oDados40->tipoprocesso;
      $dispensa40->si204_tipodocumento = $oDados40->tipodocumento;
      $dispensa40->si204_nrodocumento = $oDados40->nrodocumento;
      $dispensa40->si204_nrolote = $oDados40->nrolote;
      $dispensa40->si204_coditem = $oDados40->l20_tipojulg == 2 ? '' : $oDados40->coditem;
      $dispensa40->si204_perctaxaadm = $oDados40->perctaxaadm;
      $dispensa40->si204_instit = db_getsession("DB_instit");
      $dispensa40->si204_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

      $dispensa40->incluir(null);

      if ($dispensa40->erro_status == 0) {
          throw new Exception($dispensa40->erro_msg);
      }

    }

    db_fim_transacao();

    $oGerarDISPENSA = new GerarDISPENSA();
    $oGerarDISPENSA->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarDISPENSA->gerarDados();
  }
}
