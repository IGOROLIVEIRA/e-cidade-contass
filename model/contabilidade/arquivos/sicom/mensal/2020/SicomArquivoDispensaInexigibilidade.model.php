<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_dispensa102020_classe.php");
require_once("classes/db_dispensa112020_classe.php");
require_once("classes/db_dispensa122020_classe.php");
require_once("classes/db_dispensa132020_classe.php");
require_once("classes/db_dispensa142020_classe.php");
require_once("classes/db_dispensa152020_classe.php");
require_once("classes/db_dispensa162020_classe.php");
require_once("classes/db_dispensa172020_classe.php");
require_once("classes/db_dispensa182020_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarDISPENSA.model.php");

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
    $dispensa10 = new cl_dispensa102020();
    $dispensa11 = new cl_dispensa112020();
    $dispensa12 = new cl_dispensa122020();
    $dispensa13 = new cl_dispensa132020();
    $dispensa14 = new cl_dispensa142020();
    $dispensa15 = new cl_dispensa152020();
    $dispensa16 = new cl_dispensa162020();
    $dispensa17 = new cl_dispensa172020();
    $dispensa18 = new cl_dispensa182020();

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


    $sSql = "SELECT DISTINCT l20_codepartamento, '10' as tipoRegistro,
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
	case when liclicita.l20_dataaber is null then liclicita.l20_datacria else liclicita.l20_dataaber end as dtAbertura,
	liclicita.l20_naturezaobjeto as naturezaObjeto,
	liclicita.l20_objeto as objeto,
	liclicita.l20_justificativa as justificativa,
	liclicita.l20_razao as razao,
	liclicita.l20_dtpubratificacao as dtPublicacaoTermoRatificacao,
	l20_codigo as codlicitacao,
	liclicita.l20_veicdivulgacao as veiculoPublicacao,
	 (CASE 
        WHEN liclicita.l20_cadInicial is null or liclicita.l20_cadInicial = 0 and liclicita.l20_anousu >= 2020 THEN 1
     	ELSE liclicita.l20_cadInicial
     END) as cadInicial,
	(CASE liclicita.l20_tipojulg WHEN 3 THEN 1
		ELSE 2
	END) as processoPorLote
	FROM liclicita
	INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)

	INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
	INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
	LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
	INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo and liclicitasituacao.l11_licsituacao in (1,10)
	WHERE db_config.codigo= " . db_getsession("DB_instit") . "
	AND pctipocompratribunal.l44_sequencial in (100,101,102,103) AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
	AND DATE_PART('YEAR',l20_dtpubratificacao)=" . db_getsession("DB_anousu") . "
	AND DATE_PART('MONTH',l20_dtpubratificacao)=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];

    $rsResult10 = db_query($sSql);

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $dispensa10 = new cl_dispensa102020();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $dispensa10->si74_tiporegistro = 10;
      $dispensa10->si74_codorgaoresp = $oDados10->codorgaoresp;
      $dispensa10->si74_codunidadesubresp = $oDados10->codunidadesubresp;
      $dispensa10->si74_exercicioprocesso = $oDados10->exerciciolicitacao;
      $dispensa10->si74_nroprocesso = $oDados10->nroprocessolicitatorio;
      $dispensa10->si74_tipoprocesso = $oDados10->tipoprocesso;
      $dispensa10->si74_dtabertura = $oDados10->dtabertura;
      $dispensa10->si74_naturezaobjeto = $oDados10->naturezaobjeto;
      $dispensa10->si74_objeto = $this->removeCaracteres($oDados10->objeto);
      $dispensa10->si74_justificativa = $this->removeCaracteres($oDados10->justificativa);
      $dispensa10->si74_razao = $this->removeCaracteres($oDados10->razao);
      $dispensa10->si74_dtpublicacaotermoratificacao = $oDados10->dtpublicacaotermoratificacao;
      $dispensa10->si74_veiculopublicacao = $this->removeCaracteres($oDados10->veiculopublicacao);
      $dispensa10->si74_processoporlote = $oDados10->processoporlote;
      $dispensa10->si74_tipocadastro = !$oDados10->cadInicial ? 1 : $oDados10->cadInicial;
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
		WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
		AND liclicita.l20_tipojulg = 3
		AND liclicita.l20_codigo={$oDados10->codlicitacao}";

      $rsResult11 = db_query($sSql);//db_criatabela($rsResult11);
      $aDadosAgrupados11 = array();
      for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

        $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
        $sHash11 = $oDados11->dsclote;

        if (!isset($aDadosAgrupados11[$sHash11])) {

          $dispensa11 = new cl_dispensa112020();

          $dispensa11->si75_tiporegistro = 11;
          $dispensa11->si75_reg10 = $dispensa10->si74_sequencial;
          $dispensa11->si75_codorgaoresp = $oDados11->codorgaoresp;
          $dispensa11->si75_codunidadesubresp = $oDados11->codunidadesubresp;
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
		WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";

      $rsResult12 = db_query($sSql);

      for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {

        $dispensa12 = new cl_dispensa122020();
        $oDados12 = db_utils::fieldsMemory($rsResult12, $iCont12);

        $dispensa12->si76_tiporegistro = 12;
        $dispensa12->si76_reg10 = $dispensa10->si74_sequencial;
        $dispensa12->si76_codorgaoresp = $oDados12->codorgaoresp;
        $dispensa12->si76_codunidadesubresp = $oDados12->codunidadesubresp;
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
		pctipocompratribunal.l44_codigotribunal as tipoProcesso,
		dispensa112020.si75_nrolote as nroLote,
		(pcmater.pc01_codmater::varchar || (case when matunid.m61_codmatunid is null then 1 else matunid.m61_codmatunid end)::varchar) as codItem
		FROM liclicitem
		INNER JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
		INNER JOIN liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
		INNER JOIN dispensa112020 on (liclicitemlote.l04_descricao = dispensa112020.si75_dsclote and dispensa112020.si75_nroprocesso = liclicita.l20_edital::varchar)
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
		WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
		AND liclicita.l20_tipojulg = 3
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";

      $rsResult13 = db_query($sSql);//db_criatabela($rsResult13);

      for ($iCont13 = 0; $iCont13 < pg_num_rows($rsResult13); $iCont13++) {

        $dispensa13 = new cl_dispensa132020();
        $oDados13 = db_utils::fieldsMemory($rsResult13, $iCont13);

        $dispensa13->si77_tiporegistro = 13;
        $dispensa13->si77_reg10 = $dispensa10->si74_sequencial;
        $dispensa13->si77_codorgaoresp = $oDados13->codorgaoresp;
        $dispensa13->si77_codunidadesubresp = $oDados13->codunidadesubresp;
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
		pctipocompratribunal.l44_codigotribunal as tipoProcesso,
		(CASE liccomissaocgm.l31_tipo WHEN '1' THEN 1
		WHEN '2' THEN 4 WHEN '3' THEN 2 WHEN '4' THEN 3 WHEN '8' THEN 5 END) as tipoResp,
		cgm.z01_cgccpf as nroCPFResp
		FROM liclicita
		INNER JOIN cflicita on (liclicita.l20_codtipocom = cflicita.l03_codigo)
		INNER JOIN pctipocompratribunal on (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
		INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
		INNER JOIN liccomissaocgm AS liccomissaocgm ON (liclicita.l20_codigo=liccomissaocgm.l31_licitacao)
		INNER JOIN cgm on (liccomissaocgm.l31_numcgm=cgm.z01_numcgm)
		LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
		INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
		WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
		AND liclicita.l20_codigo= {$oDados10->codlicitacao} AND liccomissaocgm.l31_tipo in('1','2','3','4','8')";

      $rsResult14 = db_query($sSql);//db_criatabela($rsResult14);echo $sSql;

      for ($iCont14 = 0; $iCont14 < pg_num_rows($rsResult14); $iCont14++) {

        $dispensa14 = new cl_dispensa142020();
        $oDados14 = db_utils::fieldsMemory($rsResult14, $iCont14);

        $dispensa14->si78_tiporegistro = 14;
        $dispensa14->si78_reg10 = $dispensa10->si74_sequencial;
        $dispensa14->si78_codorgaoresp = $oDados14->codorgaoresp;
        $dispensa14->si78_codunidadesubres = $oDados14->codunidadesubresp;
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
		pctipocompratribunal.l44_codigotribunal as tipoProcesso,
		dispensa112020.si75_nrolote as nroLote,
		(pcmater.pc01_codmater::varchar || (case when matunid.m61_codmatunid is null then 1 else matunid.m61_codmatunid end)::varchar) as codItem,
		itemprecoreferencia.si02_vlprecoreferencia as vlCotPrecosUnitario,
		pcorcamval.pc23_quant as quantidade
		FROM liclicitem
		INNER JOIN liclicita on (liclicitem.l21_codliclicita=liclicita.l20_codigo)
		LEFT  JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem AND liclicita.l20_tipojulg = 3)
		LEFT  JOIN dispensa112020 on (liclicitemlote.l04_descricao = dispensa112020.si75_dsclote and dispensa112020.si75_nroprocesso = liclicita.l20_edital::varchar)
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
		WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";


      $rsResult15 = db_query($sSql);//db_criatabela($rsResult15);
      $aDadosAgrupados15 = array();
      for ($iCont15 = 0; $iCont15 < pg_num_rows($rsResult15); $iCont15++) {

        $oResult15 = db_utils::fieldsMemory($rsResult15, $iCont15);

        $sHash15 = $oResult15->exerciciolicitacao . $oResult15->nroprocessolicitatorio . $oResult15->nrolote . $oResult15->coditem;

        if (!isset($aDadosAgrupados15[$sHash15])) {

          $oDados15 = new stdClass();
          $oDados15->si79_tiporegistro = 15;
          $oDados15->si79_reg10 = $dispensa10->si74_sequencial;
          $oDados15->si79_codorgaoresp = $oResult15->codorgaoresp;
          $oDados15->si79_codunidadesubresp = $oResult15->codunidadesubresp;
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

        $dispensa15 = new cl_dispensa152020();

        $dispensa15->si79_tiporegistro = 15;
        $dispensa15->si79_reg10 = $oDadosAgrupados15->si79_reg10;
        $dispensa15->si79_codorgaoresp = $oDadosAgrupados15->si79_codorgaoresp;
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
		pctipocompratribunal.l44_codigotribunal as tipoProcesso,
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
		orcdotacao.o58_valor as vlRecurso
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
		WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";

      $rsResult16 = db_query($sSql);

      for ($iCont16 = 0; $iCont16 < pg_num_rows($rsResult16); $iCont16++) {

        $dispensa16 = new cl_dispensa162020();
        $oDados16 = db_utils::fieldsMemory($rsResult16, $iCont16);

        $dispensa16->si80_tiporegistro = 16;
        $dispensa16->si80_reg10 = $dispensa10->si74_sequencial;
        $dispensa16->si80_codorgaoresp = $oDados16->codorgaoresp;
        $dispensa16->si80_codunidadesubresp = $oDados16->codunidadesubresp;
        $dispensa16->si80_exercicioprocesso = $oDados16->exerciciolicitacao;
        $dispensa16->si80_nroprocesso = $oDados16->nroprocessolicitatorio;
        $dispensa16->si80_tipoprocesso = $oDados16->tipoprocesso;
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
	dispensa112020.si75_nrolote as nroLote,
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
	LEFT  JOIN dispensa112020 on (liclicitemlote.l04_descricao = dispensa112020.si75_dsclote and dispensa112020.si75_nroprocesso = liclicita.l20_edital::varchar)
	INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
	LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
  LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
	LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
	INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
	WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND (liclicita.l20_licsituacao = 1 OR liclicita.l20_licsituacao = 10)
	AND liclicita.l20_codigo= {$oDados10->codlicitacao} AND pctipocompratribunal.l44_sequencial in (100,101)";


      $rsResult17 = db_query($sSql);//db_criatabela($rsResult17);
      $aDadosAgrupados17 = array();
      for ($iCont17 = 0; $iCont17 < pg_num_rows($rsResult17); $iCont17++) {

        $oResult17 = db_utils::fieldsMemory($rsResult17, $iCont17);
        $sHash17 = $oResult17->exerciciolicitacao . $oResult17->nroprocessolicitatorio . $oResult17->nrolote . $oResult17->coditem;
        if (!isset($aDadosAgrupados17[$sHash17])) {

          $oDados17 = new stdClass;

          $oDados17->si81_tiporegistro = 17;
          $oDados17->si81_codorgaoresp = $oResult17->codorgaoresp;
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

        $dispensa17 = new cl_dispensa172020();

        $dispensa17->si81_tiporegistro = 17;
        $dispensa17->si81_codorgaoresp = $oDadosAgrupados17->si81_codorgaoresp;
        $dispensa17->si81_codunidadesubresp = $oDadosAgrupados17->si81_codunidadesubresp;
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
	dispensa112020.si75_nrolote as nroLote,
	(pcmater.pc01_codmater::varchar || (case when matunid.m61_codmatunid is null then 1 else matunid.m61_codmatunid end)::varchar) as codItem,
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
	INNER JOIN credenciamento on (liclicita.l20_codigo=credenciamento.l205_licitacao) and l205_fornecedor = l206_fornecedor
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
	INNER JOIN pcmater on (solicitempcmater.pc16_codmater = pcmater.pc01_codmater)
	INNER JOIN liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
	LEFT JOIN dispensa112020 on (liclicitemlote.l04_descricao = dispensa112020.si75_dsclote and dispensa112020.si75_nroprocesso = liclicita.l20_edital::varchar)
	INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
	LEFT JOIN solicitemunid AS solicitemunid ON solicitem.pc11_codigo = solicitemunid.pc17_codigo
  LEFT JOIN matunid AS matunid ON solicitemunid.pc17_unid = matunid.m61_codmatunid
	LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
	INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
	WHERE db_config.codigo= " . db_getsession("DB_instit") . "
	AND DATE_PART('YEAR',credenciamento.l205_datacred)= ". db_getsession("DB_anousu")."
  AND DATE_PART('MONTH',credenciamento.l205_datacred)=".$this->sDataFinal['5'] . $this->sDataFinal['6'];


    $rsResult18 = db_query($sSql);//echo $sSql; db_criatabela($rsResult18);die();

    for ($iCont18 = 0; $iCont18 < pg_num_rows($rsResult18); $iCont18++) {

      $dispensa18 = new cl_dispensa182020();
      $oDados18 = db_utils::fieldsMemory($rsResult18, $iCont18);

      $dispensa18->si82_tiporegistro = 20;
      $dispensa18->si82_codorgaoresp = $oDados18->codorgaoresp;
      $dispensa18->si82_codunidadesubresp = $oDados18->codunidadesubresp;
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




    db_fim_transacao();

    $oGerarDISPENSA = new GerarDISPENSA();
    $oGerarDISPENSA->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarDISPENSA->gerarDados();

  }
}



