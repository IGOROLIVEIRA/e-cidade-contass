<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_contratos102020_classe.php");
require_once("classes/db_contratos112020_classe.php");
require_once("classes/db_contratos122020_classe.php");
require_once("classes/db_contratos132020_classe.php");
require_once("classes/db_contratos202020_classe.php");
require_once("classes/db_contratos212020_classe.php");
require_once("classes/db_contratos302020_classe.php");
require_once("classes/db_contratos402020_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarCONTRATOS.model.php");
require_once("model/Acordo.model.php");
require_once("model/AcordoPosicao.model.php");
require_once("model/AcordoRescisao.model.php");

//echo '<pre>';ini_set("display_errors", 1);

/**
 * Contratos Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoContratos extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  CONST ORIGEM_PROCESSO_COMPRAS = 1;
  CONST ORIGEM_LICITACAO = 2;
  CONST ORIGEM_MANUAL = 3;
  CONST ORIGEM_EMPENHO = 6;

  /*
      1 - No ou dispensa por valor
      2 - Licitao
      3 - Dispensa ou Inexigibilidade
      4 - Adeso  ata de registro de preos
      5 - Licitao realizada por outro rgo ou entidade
      6 - Dispensa ou Inexigibilidade realizada por outro rgo ou entidade
      7 - Licitao - Regime Diferenciado de Contrataes Pblicas - RDC
      8 - Licitao realizada por consorcio pblico
      9 - Licitao realizada por outro ente da federao
   */

  CONST TIPO_ORIGEM_NAO_OU_DISPENSA = 1;
  CONST TIPO_ORIGEM_LICIATACAO = 2;
  CONST TIPO_ORIGEM_DISPENSA_INEXIGIBILIDADE = 3;
  CONST TIPO_ORIGEM_ADESAO_REGISTRO_PRECO = 4;
  CONST TIPO_ORIGEM_LICITACAO_OUTRO_ORGAO = 5;
  CONST TIPO_ORIGEM_DISPENSA_INEXIBILIDADE_OUTRO_ORGAO = 6;
  CONST TIPO_ORIGEM_LICITACAO_REGIME_DIFERENCIADO = 7;
  CONST TIPO_ORIGEM_LICITACAO_CONSORCIO = 8;
  CONST TIPO_ORIGEM_FEDERACAO = 9;

  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout = 163;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'CONTRATOS';

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
   *esse metodo sera implementado criando um array com os campos que serao necessarios
   *para o escritor gerar o arquivo CSV
   */
  public function getCampos()
  {

  }

  /**
   * Busca a penalidade de acordo com o tipo
   * @param $iAcordo
   * @param $iTipo [1-multaRescisoria,2-multaInadimplemento]
   */
  public function getPenalidadeByAcordo($iAcordo, $iTipo)
  {
    $sSql = " select ac15_texto from acordoacordopenalidade
               where ac15_acordo = {$iAcordo} and ac15_acordopenalidade = {$iTipo}";
    return db_utils::fieldsMemory(db_query($sSql), 0)->ac15_texto;
  }

  /**
   * Busca a garantia do contrato.
   * Se houver mais de uma, busca a primeira.
   * @param $iAcordo
   * @return mixed
   */
  public function getGarantiaByAcordo($iAcordo)
  {
    $sSql = "
      select ac11_sequencial from acordoacordogarantia
      inner join acordogarantia on ac12_acordogarantia = ac11_sequencial
      where ac12_acordo = {$iAcordo} limit 1";
    return db_utils::fieldsMemory(db_query($sSql), 0)->ac11_sequencial;
  }

  /**
   * Tipo de Termo de Aditivo:
   *   04 ? Reajuste;
   *   05 ? Recomposio (Equilbrio Financeiro);
   *   06 ? Outros.
   *   07 ? Alterao de Prazo de Vigncia;
   *   08 ? Alterao de Prazo de Execuo;
   *   09 ? Acrscimo de Item(ns);
   *   10 ? Decrscimo de Item(ns);
   *   11 ? Acrscimo e Decrscimo de Item(ns);
   *   12 ? Alterao de Projeto/Especificao
   *   13 ? Alterao de Prazo de vigncia e Prazo de Execuo;
   *   14 ? Acrscimo/Decrscimo de item(ns) conjugado com
   *        outros tipos de termos aditivos;
   * @param AcordoPosicao $oAcordoPosicao
   * @return int
   */
  public function getTipoTermoAditivo(AcordoPosicao $oAcordoPosicao)
  {
    $aTipos = array();

    if ($oAcordoPosicao->getTipo() == 6) {
      $aTipos[] = 7;
    }

    if ($oAcordoPosicao->getTipo() == 5) {
      $aTipos[] = 4;
    }

    if ($oAcordoPosicao->getTipo() == 2) {
      $aTipos[] = 5;
    }

    if ($oAcordoPosicao->getTipo() == 7) {
      $aTipos[] = 6;
    }

    if ($oAcordoPosicao->getTipo() == 8) {
      $aTipos[] = 8;
    }

    if ($oAcordoPosicao->getTipo() == 13) {
      $aTipos[] = 13;
    }

    if ($oAcordoPosicao->getTipo() == 11) {
      $aTipos[] = 11;
    }

    if ($oAcordoPosicao->getTipo() == 13) {
      $aTipos[] = 13;
    }

    if ($oAcordoPosicao->getTipo() == 14) {
      $aTipos[] = 14;
    }

    return $aTipos[0] == "" ? $oAcordoPosicao->getTipo() : $aTipos[0];

  }

  public function getCodunidadesubrespAdesao($iCodContratos)
  {
    $sSql = "select
      case when o41_subunidade != 0 or not null then
                                    lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0)||lpad(o41_subunidade::integer,3,0)
                                    else lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0) end as codunidadesubresp
                        from empempenhocontrato
                      inner join empempenho on e60_numemp = e100_numemp
            join empelemento on e64_numemp = e60_numemp
            join orcdotacao on e60_coddot = o58_coddot and e60_anousu = o58_anousu
            join orcunidade on o41_anousu = o58_anousu and o41_orgao = o58_orgao and o41_unidade = o58_unidade
            join orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
            where e100_acordo = {$iCodContratos}
      ";

    $sCodunidadesubresp = db_utils::fieldsMemory(db_query($sSql), 0)->codunidadesubresp;

    return $sCodunidadesubresp;

  }

  /**
   * Funcao usada para retornar licitacao de contratos de origem empenho
   * @param int $iCodContrato
   * @return Object
   */
  public function getLicitacaoByContrato($iCodContrato)
  {

    $sSql = "select liclicita.l20_codigo,liclicita.l20_edital,liclicita.l20_anousu,l20_codepartamento,l20_naturezaobjeto,
                    case when l20_codtipocom = 52 then 1 when l20_codtipocom = 53 then 2 else 0 end as tipoprocesso from acordo
inner join empempenhocontrato on acordo.ac16_sequencial = empempenhocontrato.e100_acordo
inner join empempenho         on empempenho.e60_numemp = empempenhocontrato.e100_numemp
inner join liclicita on ltrim(((string_to_array(e60_numerol, '/'))[1])::varchar,'0') = l20_edital::varchar
              and l20_anousu::varchar = ((string_to_array(e60_numerol, '/'))[2])::varchar
              where ac16_sequencial = {$iCodContrato} order by e100_sequencial limit 1";

    $oLicitacao = db_utils::fieldsMemory(db_query($sSql), 0);

    return $oLicitacao;

  }

  /**
   * Quando um contrato  de origem manual mas o tipo origem  adeso  ata de registro de preo,
   * busca-se os dados do processo licitatrio em: compras>>procedimentos>adeso de registro de preo
   * @param $param
   */
  public function getDadosLicitacaoAdesao($param){

  }

  /**
   * selecionar os dados de Leis de Alterao
   *
   */
  public function gerarDados()
  {

    $clcontratos10 = new cl_contratos102020();
    $clcontratos11 = new cl_contratos112020();
    $clcontratos12 = new cl_contratos122020();
    $clcontratos13 = new cl_contratos132020();
    $clcontratos20 = new cl_contratos202020();
    $clcontratos21 = new cl_contratos212020();
    $clcontratos30 = new cl_contratos302020();
    $clcontratos40 = new cl_contratos402020();

    db_inicio_transacao();
    // matriz de entrada
    $what = array("", chr(13), chr(10), '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', '', '');

    // matriz de sada
    $by = array('', '', '', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ');

    /*
     * excluir informacoes do mes selecionado registro 13
     */
    $result = $clcontratos13->sql_record($clcontratos13->sql_query(NULL, "*", NULL, "si86_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si86_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {

      $clcontratos13->excluir(NULL, "si86_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si86_instit = " . db_getsession("DB_instit"));
      if ($clcontratos13->erro_status == 0) {
        throw new Exception($clcontratos13->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 12
     */
    $result = $clcontratos12->sql_record($clcontratos12->sql_query(NULL, "*", NULL, "si85_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si85_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {

      $clcontratos12->excluir(NULL, "si85_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si85_instit = " . db_getsession("DB_instit"));
      if ($clcontratos12->erro_status == 0) {
        throw new Exception($clcontratos12->erro_msg);
      }
    }

    /*
    * excluir informacoes do mes selecionado registro 11
    */
    $result = $clcontratos11->sql_record($clcontratos11->sql_query(NULL, "*", NULL, "si84_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si84_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {

      $clcontratos11->excluir(NULL, "si84_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si84_instit = " . db_getsession("DB_instit"));
      if ($clcontratos11->erro_status == 0) {
        throw new Exception($clcontratos11->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clcontratos10->sql_record($clcontratos10->sql_query(NULL, "*", NULL, "si83_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si83_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcontratos10->excluir(NULL, "si83_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si83_instit = " . db_getsession("DB_instit"));
      if ($clcontratos10->erro_status == 0) {
        throw new Exception($clcontratos10->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 21
     */
    $result = $clcontratos21->sql_record($clcontratos21->sql_query(NULL, "*", NULL, "si88_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si88_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcontratos21->excluir(NULL, "si88_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si88_instit = " . db_getsession("DB_instit"));
      if ($clcontratos21->erro_status == 0) {
        throw new Exception($clcontratos21->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clcontratos20->sql_record($clcontratos20->sql_query(NULL, "*", NULL, "si87_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si87_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcontratos20->excluir(NULL, "si87_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si87_instit = " . db_getsession("DB_instit"));
      if ($clcontratos20->erro_status == 0) {
        throw new Exception($clcontratos20->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 30
     */
    $result = $clcontratos30->sql_record($clcontratos30->sql_query(NULL, "*", NULL, "si89_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si89_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcontratos30->excluir(NULL, "si89_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si89_instit = " . db_getsession("DB_instit"));
      if ($clcontratos30->erro_status == 0) {
        throw new Exception($clcontratos30->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 40
     */
    $result = $clcontratos40->sql_record($clcontratos40->sql_query(NULL, "*", NULL, "si91_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si91_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcontratos40->excluir(NULL, "si91_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si91_instit = " . db_getsession("DB_instit"));
      if ($clcontratos40->erro_status == 0) {
        throw new Exception($clcontratos40->erro_msg);
      }
    }
    db_fim_transacao();
    $sSql = "SELECT si09_codorgaotce AS codorgao
              FROM infocomplementaresinstit
              WHERE si09_instit = " . db_getsession("DB_instit");

    $rsResult = db_query($sSql);
    $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;

    /*
     * selecionar informacoes registro 10
     */

    $sSql = "SELECT DISTINCT acordo.*,
                    adesaoregprecos.si06_dataadesao as anoproc,
                    adesaoregprecos.si06_numeroadm as numeroproc,
                    liclicita.l20_codigo,
                    liclicita.l20_edital,
                    liclicita.l20_anousu,
                    liclicita.l20_codepartamento,
                    liclicita.l20_naturezaobjeto,
                CASE
                    WHEN p1.pc50_pctipocompratribunal = 100 THEN 2
                    WHEN p1.pc50_pctipocompratribunal = 101 THEN 1
                    WHEN p1.pc50_pctipocompratribunal = 102 THEN 3
                    WHEN p1.pc50_pctipocompratribunal = 103 THEN 4
                    ELSE 0
                END AS tipoprocesso,
                CASE
                    WHEN p2.pc50_pctipocompratribunal = 100 THEN 2
                    WHEN p2.pc50_pctipocompratribunal = 101 THEN 1
                    WHEN p2.pc50_pctipocompratribunal = 102 THEN 3
                    WHEN p2.pc50_pctipocompratribunal = 103 THEN 4
                    ELSE 0
                END AS tipoprocessolicitacao,
                    ac16_tipoorigem AS contdeclicitacao,
                    ac16_origem,
                (CASE
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
                 END) AS codunidadesubresp,
                      CASE WHEN l2.l20_edital = NULL THEN NULL ELSE l2.l20_edital END AS editalmanual,
                      CASE WHEN l2.l20_codigo = NULL THEN NULL ELSE l2.l20_codigo END AS codlicmanual,
                      CASE WHEN l2.l20_anousu = NULL THEN NULL ELSE l2.l20_anousu END AS anousumanual,
                      CASE WHEN l2.l20_codepartamento = NULL THEN NULL ELSE l2.l20_codepartamento END AS departmanual,
                      CASE WHEN l2.l20_naturezaobjeto = NULL THEN NULL ELSE l2.l20_naturezaobjeto END AS naturezamanual,
                      ac02_acordonatureza,
                      ac16_veiculodivulgacao,
                      ac16_tipocadastro
                FROM acordoitem
                INNER JOIN acordoposicao ON ac20_acordoposicao = ac26_sequencial
                INNER JOIN acordo ON ac16_sequencial = ac26_acordo
                LEFT JOIN acordoliclicitem ON ac24_acordoitem = ac20_sequencial
                LEFT JOIN liclicitem ON l21_codigo = ac24_liclicitem
                LEFT JOIN liclicita ON l21_codliclicita = l20_codigo
                LEFT JOIN db_departorg ON l20_codepartamento = db01_coddepto
                AND db01_anousu = " . db_getsession("DB_anousu") . "
                LEFT JOIN orcunidade ON db01_orgao = o41_orgao
                AND db01_unidade = o41_unidade
                AND db01_anousu = o41_anousu
                AND o41_anousu = " . db_getsession("DB_anousu") . "
                LEFT JOIN orcorgao ON o40_orgao = o41_orgao
                AND o40_anousu = o41_anousu
                LEFT JOIN cflicita ON l20_codtipocom = l03_codigo
                LEFT JOIN pctipocompra p1 ON p1.pc50_codcom = l03_codcom
                LEFT JOIN liclicita l2 ON l2.l20_codigo = acordo.ac16_licitacao
                LEFT JOIN adesaoregprecos ON si06_sequencial = ac16_adesaoregpreco
                LEFT JOIN cflicita c2 ON l2.l20_codtipocom = c2.l03_codigo
                LEFT JOIN pctipocompra p2 ON p2.pc50_codcom = c2.l03_codcom
                INNER JOIN acordogrupo ON ac02_sequencial = ac16_acordogrupo
                WHERE ac16_dataassinatura <= '{$this->sDataFinal}'
                AND ac16_dataassinatura >= '{$this->sDataInicial}'
                AND ac16_instit = " . db_getsession("DB_instit");

    $rsResult10 = db_query($sSql); //db_criatabela($rsResult10); die($sSql);

    db_inicio_transacao();

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clcontratos10 = new cl_contratos102020();

      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $sSql = "select CASE WHEN o40_codtri = '0'
                     OR NULL THEN o40_orgao::varchar ELSE o40_codtri END AS db01_orgao,
                     CASE WHEN o41_codtri = '0'
                     OR NULL THEN o41_unidade::varchar ELSE o41_codtri END AS db01_unidade,o41_subunidade from db_departorg
                     join orcunidade on db01_orgao = o41_orgao and db01_unidade = o41_unidade
                     and db01_anousu = o41_anousu
                     JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                     where db01_anousu = " . db_getsession("DB_anousu") . " and db01_coddepto = " . $oDados10->ac16_deptoresponsavel;

      $rsDepart = db_query($sSql);
      $sOrgDepart = db_utils::fieldsMemory($rsDepart, 0)->db01_orgao;
      $sUnidDepart = db_utils::fieldsMemory($rsDepart, 0)->db01_unidade;
      $sSubUnidade = db_utils::fieldsMemory($rsDepart, 0)->o41_subunidade;


      $sCodUnidade = str_pad($sOrgDepart, 2, "0", STR_PAD_LEFT) . str_pad($sUnidDepart, 3, "0", STR_PAD_LEFT);
      if ($sSubUnidade == 1) {
        $sCodUnidade .= str_pad($sSubUnidade, 3, "0", STR_PAD_LEFT);
      }

      if(($oDados10->ac16_origem == self::ORIGEM_MANUAL || $oDados10->ac16_origem == self::ORIGEM_PROCESSO_COMPRAS)&& $oDados10->departmanual != null) {

        $sSqlManual = "select CASE WHEN o40_codtri = '0'
                     OR NULL THEN o40_orgao::varchar ELSE o40_codtri END AS db01_orgao,
                     CASE WHEN o41_codtri = '0'
                     OR NULL THEN o41_unidade::varchar ELSE o41_codtri END AS db01_unidade,o41_subunidade from db_departorg
                     join orcunidade on db01_orgao = o41_orgao and db01_unidade = o41_unidade
                     and db01_anousu = o41_anousu
                     JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                     where db01_anousu = " . db_getsession("DB_anousu") . " and db01_coddepto = " . $oDados10->departmanual;

        $rsDepartManual = db_query($sSqlManual);

        $sOrgDepartM = db_utils::fieldsMemory($rsDepartManual, 0)->db01_orgao;
        $sUnidDepartM = db_utils::fieldsMemory($rsDepartManual, 0)->db01_unidade;
        $sSubUnidadeM = db_utils::fieldsMemory($rsDepartManual, 0)->o41_subunidade;

        $sCodUnidadeM = str_pad($sOrgDepartM, 2, "0", STR_PAD_LEFT) . str_pad($sUnidDepartM, 3, "0", STR_PAD_LEFT);
        if ($sSubUnidade == 1) {
          $sCodUnidadeM .= str_pad($sSubUnidadeM, 3, "0", STR_PAD_LEFT);
        }
      }
      /*
       * Verificar se o contrato vem de licitacao mas foi vinculado apenas ao empenho
       * por ser Origem empenho
       */
      if ($oDados10->ac16_origem == self::ORIGEM_EMPENHO && in_array($oDados10->contdeclicitacao, array(2, 3))) {
        $oLicitacao = $this->getLicitacaoByContrato($oDados10->ac16_sequencial);
        $oDados10->l20_edital = $oLicitacao->l20_edital;
        $oDados10->l20_anousu = $oLicitacao->l20_anousu;
        $oDados10->l20_naturezaobjeto = $oLicitacao->l20_naturezaobjeto;
        $oDados10->tipoprocesso = empty($oLicitacao->tipoprocesso) ? 0 : $oLicitacao->tipoprocesso;
        $oDados10->l20_codigo = $oLicitacao->l20_codigo;
      }
      /*
       * verificar se o contrato e licitacao e foi vinculado a licitacao
       * por ser origem Manual
       */
      if($oDados10->ac16_origem == self::ORIGEM_MANUAL && in_array($oDados10->contdeclicitacao, array(2, 3))) {
        $oDados10->l20_edital = $oDados10->editalmanual;
        $oDados10->l20_anousu = $oDados10->anousumanual;
        $oDados10->l20_naturezaobjeto = $oDados10->naturezamanual;
        $oDados10->l20_codigo = $oDados10->codlicmanual;
        $oDados10->l20_codepartamento = $oDados10->departmanual;
      }

      /*
       * verifica se o contrato e de origem processo de compra e tipo origem licitação por ser registro de preço
       *
       */

      if($oDados10->ac16_origem == self::ORIGEM_PROCESSO_COMPRAS && in_array($oDados10->contdeclicitacao, array(2, 3))) {
         $oDados10->l20_edital = $oDados10->editalmanual;
         $oDados10->l20_anousu = $oDados10->anousumanual;
         $oDados10->l20_naturezaobjeto = $oDados10->naturezamanual;
         $oDados10->l20_codigo = $oDados10->codlicmanual;
         $oDados10->l20_codepartamento = $oDados10->departmanual;
         $clcontratos10->si83_codunidadesubresp = $sCodUnidadeM;
      }

      $clcontratos10->si83_tiporegistro = 10;
      $clcontratos10->si83_codcontrato = $oDados10->ac16_sequencial;
      $clcontratos10->si83_codorgao = $sCodorgao;
      $clcontratos10->si83_codunidadesub = $sCodUnidade;
      $clcontratos10->si83_nrocontrato = $oDados10->ac16_numeroacordo;
      $clcontratos10->si83_exerciciocontrato = $oDados10->ac16_anousu;
      $clcontratos10->si83_dataassinatura = $oDados10->ac16_dataassinatura;
      $clcontratos10->si83_contdeclicitacao = $oDados10->contdeclicitacao;
      $clcontratos10->si83_codorgaoresp = $oDados10->contdeclicitacao == 5 || $oDados10->contdeclicitacao == 6 ? $sCodorgao : ' ';
      if ($oDados10->contdeclicitacao == 1 || $oDados10->contdeclicitacao == 8) {
        $clcontratos10->si83_codunidadesubresp = ' ';
      }elseif ($oDados10->contdeclicitacao == 4) {
        $clcontratos10->si83_codunidadesubresp = $this->getCodunidadesubrespAdesao($oDados10->ac16_sequencial);
      }elseif ($oDados10->ac16_origem == self::ORIGEM_MANUAL) {
        $clcontratos10->si83_codunidadesubresp = $sCodUnidadeM;
      }elseif ($oDados10->ac16_origem == self::ORIGEM_PROCESSO_COMPRAS){
          $clcontratos10->si83_codunidadesubresp = $sCodUnidadeM;
      }else{
        $clcontratos10->si83_codunidadesubresp = $oDados10->codunidadesubresp;
      }


      if($oDados10->ac16_origem == self::ORIGEM_MANUAL || $oDados10->ac16_origem == self::ORIGEM_PROCESSO_COMPRAS){
        if($oDados10->ac16_tipoorigem == self::TIPO_ORIGEM_ADESAO_REGISTRO_PRECO){
          $clcontratos10->si83_nroprocesso = $oDados10->numeroproc;
          $clcontratos10->si83_exercicioprocesso = substr($oDados10->anoproc, 0, 4);
        }else{
          $clcontratos10->si83_nroprocesso = in_array($oDados10->contdeclicitacao, array(2, 3)) ? $oDados10->l20_edital : ' ';
          $clcontratos10->si83_exercicioprocesso = in_array($oDados10->contdeclicitacao, array(2, 3)) ? $oDados10->l20_anousu : ' ';
        }
      }else{
        $clcontratos10->si83_nroprocesso = in_array($oDados10->contdeclicitacao, array(2, 3)) ? $oDados10->l20_edital : ' ';
        $clcontratos10->si83_exercicioprocesso = in_array($oDados10->contdeclicitacao, array(2, 3)) ? $oDados10->l20_anousu : ' ';
      }
      if($oDados10->tipoprocesso == '' || $oDados10->tipoprocesso == 0){
        $clcontratos10->si83_tipoprocesso = $oDados10->tipoprocessolicitacao;
      }else $clcontratos10->si83_tipoprocesso = $oDados10->tipoprocesso;
      $clcontratos10->si83_naturezaobjeto = $oDados10->ac02_acordonatureza;
      $clcontratos10->si83_objetocontrato = substr($this->removeCaracteres($oDados10->ac16_objeto), 0, 500);
      $clcontratos10->si83_tipoinstrumento = $oDados10->ac16_acordocategoria;
      $clcontratos10->si83_datainiciovigencia = $oDados10->ac16_datainicio;
      $clcontratos10->si83_datafinalvigencia = $oDados10->ac16_datafim;
      $oAcordo = new Acordo($oDados10->ac16_sequencial);
      $clcontratos10->si83_vlcontrato = $oDados10->ac16_valor;
      //OC10386
      if($oDados10->ac02_acordonatureza == '4' || $oDados10->ac02_acordonatureza == '5'){
        $clcontratos10->si83_formafornecimento = '';
        $clcontratos10->si83_formapagamento = '';
        $clcontratos10->si83_unidadedemedidaprazoexex = '';
        $clcontratos10->si83_prazoexecucao = '';
        $clcontratos10->si83_multarescisoria = '';
        $clcontratos10->si83_multainadimplemento = '';
        $clcontratos10->si83_garantia = '';
      }else{
        $clcontratos10->si83_formafornecimento = $this->removeCaracteres($oDados10->ac16_formafornecimento);
        $clcontratos10->si83_formapagamento = $this->removeCaracteres($oDados10->ac16_formapagamento);
        $clcontratos10->si83_unidadedemedidaprazoexex = $oDados10->ac16_tipounidtempoperiodo;
        $clcontratos10->si83_prazoexecucao = $oDados10->ac16_qtdperiodo;
        $clcontratos10->si83_multarescisoria = substr($this->removeCaracteres($this->getPenalidadeByAcordo($oDados10->ac16_sequencial, 1)), 0, 99);
        $clcontratos10->si83_multainadimplemento = substr($this->removeCaracteres($this->getPenalidadeByAcordo($oDados10->ac16_sequencial, 2)), 0, 99);
        $clcontratos10->si83_garantia = $this->getGarantiaByAcordo($oDados10->ac16_sequencial);
      }
      //FIM OC10386
      $clcontratos10->si83_cpfsignatariocontratante = $oAcordo->getCpfsignatariocontratante();
      $clcontratos10->si83_datapublicacao = $oDados10->ac16_datapublicacao;
      $clcontratos10->si83_veiculodivulgacao = $this->removeCaracteres($oDados10->ac16_veiculodivulgacao);
      $clcontratos10->si83_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clcontratos10->si83_instit = db_getsession('DB_instit');
      $clcontratos10->si83_tipocadastro = $oDados10->ac16_tipocadastro;

      $clcontratos10->incluir(null);

      if ($clcontratos10->erro_status == 0) {
        throw new Exception($clcontratos10->erro_msg);
      }

      /*
       * selecionar informacoes registro 11
       */

      //OC10386
      if($oDados10->ac02_acordonatureza != "4" && $oDados10->ac02_acordonatureza != "5") {

        $aDadosAgrupados = array();
        foreach ($oAcordo->getItensPosicaoInicial() as $oItens) {
          $iUnidade = $oItens->getUnidade() == "" ? 1 : $oItens->getUnidade();
          $iCodItem = $oItens->getMaterial()->getCodigo() . $iUnidade;
          $iCodPcmater = $oItens->getMaterial()->getMaterial();

          /**
           * busca itens obra;
           */
          $sqlItemobra = "select * from licitemobra where obr06_pcmater = $iCodPcmater";
          $rsItems = db_query($sqlItemobra);
          $oDadosItensObra = db_utils::fieldsMemory($rsItems, 0);

          $sHash = $iCodItem;
          if (!isset($aDadosAgrupados[$sHash])) {

            $oContrato11 = new stdClass();
            $oContrato11->si84_tiporegistro = 11;
            $oContrato11->si84_reg10 = $clcontratos10->si83_sequencial;
            $oContrato11->si84_codcontrato = $oDados10->ac16_sequencial;
            $oContrato11->si84_coditem = $iCodItem;
            $oContrato11->si84_quantidadeitem = $oItens->getQuantidade();
            $oContrato11->si84_valorunitarioitem = $oItens->getValorUnitario();
            $oContrato11->si84_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $oContrato11->si84_instit = db_getsession("DB_instit");
            $oContrato11->si84_tipomaterial = $oDadosItensObra->obr06_tabela;
            if($oDadosItensObra->obr06_tabela == "1"){
              $oContrato11->si84_coditemsinapi = $oDadosItensObra->obr06_codigotabela;
              $oContrato11->si84_coditemsimcro = null;
              $oContrato11->si84_descoutrosmateriais = null;
            }elseif ($oDadosItensObra->obr06_tabela == "2"){
              $oContrato11->si84_coditemsimcro = $oDadosItensObra->obr06_codigotabela;
              $oContrato11->si84_coditemsinapi = null;
              $oContrato11->si84_descoutrosmateriais = null;
            }elseif ($oDadosItensObra->obr06_tabela == "3"){
              $oContrato11->si84_coditemsinapi = null;
              $oContrato11->si84_coditemsimcro = null;
              $oContrato11->si84_descoutrosmateriais = $oDadosItensObra->obr06_descricaotabela;
            }
            $oContrato11->si84_itemplanilha = $oDadosItensObra->obr06_codigotabela;
            $aDadosAgrupados[$sHash] = $oContrato11;

          } else {
            $aDadosAgrupados[$sHash]->si84_quantidadeitem += $oItens->getQuantidade();
            $aDadosAgrupados[$sHash]->si84_valorunitarioitem += $oItens->getValorUnitario();
          }

        }

        foreach ($aDadosAgrupados as $oDadosReg11) {

          $clcontratos11 = new cl_contratos112020();

          $clcontratos11->si84_tiporegistro = 11;
          $clcontratos11->si84_reg10 = $oDadosReg11->si84_reg10;
          $clcontratos11->si84_codcontrato = $oDadosReg11->si84_codcontrato;
          $clcontratos11->si84_coditem = $oDadosReg11->si84_coditem;
          $clcontratos11->si84_quantidadeitem = $oDadosReg11->si84_quantidadeitem;
          $clcontratos11->si84_valorunitarioitem = $oDadosReg11->si84_valorunitarioitem;
          $clcontratos11->si84_mes = $oDadosReg11->si84_mes;
          $clcontratos11->si84_instit = $oDadosReg11->si84_instit;
          $clcontratos11->si84_tipomaterial = $oDadosReg11->si84_tipomaterial;
          $clcontratos11->si84_coditemsimcro = $oDadosReg11->si84_coditemsimcro;
          $clcontratos11->si84_coditemsinapi = $oDadosReg11->si84_coditemsinapi;
          $clcontratos11->si84_descoutrosmateriais = $oDadosReg11->si84_descoutrosmateriais;
          $clcontratos11->si84_itemplanilha = $oDadosReg11->si84_itemplanilha;

          $clcontratos11->incluir(null);
          if ($clcontratos11->erro_status == 0) {
            throw new Exception($clcontratos11->erro_msg);
          }

        }

        /*
         * selecionar informacoes registro 12
         */

        $aDadosAgrupados12 = array();

        if ($clcontratos10->si83_naturezaobjeto != 4 || $clcontratos10->si83_naturezaobjeto != 5) {

          /**
           * Caso o contrato seja de origem manual (3) e quando for processo de compras e NO HOUVER empenho, deve ser buscado as dotaes para cada item do contrato.
           */

          if($oDados10->ac16_origem == self::ORIGEM_MANUAL or ($oDados10->ac16_origem == self::ORIGEM_PROCESSO_COMPRAS && count($oAcordo->getEmpenhosAcordo()) == 0)) {

            /**
             * Acordos de origem manual e processo de compras e NO HOUVER empenho
             */
            foreach($oAcordo->getItensPosicaoInicial() as $oItens) {
              foreach ($oItens->getDotacoes() as $oDotacao) {

                $sSqlDotacoes = "SELECT distinct on (o58_coddot)
                                         o58_coddot,
                                         CASE WHEN o40_codtri = '0'
                                         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END AS o58_orgao,
                                         CASE WHEN o41_codtri = '0'
                                         OR NULL THEN o41_unidade::varchar ELSE o41_codtri END AS o58_unidade,
                                         o58_funcao,
                                         o58_subfuncao,
                                         o58_programa,
                                         o58_projativ,
                                         o55_origemacao,
                                         o56_elemento,
                                         o15_codtri,
                                         o58_valor,
                                         o41_subunidade
                                         from
                                         orcdotacao
                                         JOIN orcelemento ON o58_codele = o56_codele and o58_anousu = o56_anousu
                                        AND o56_anousu = " . db_getsession("DB_anousu") . "
                                        JOIN orctiporec ON o58_codigo = o15_codigo
                                        JOIN orcprojativ ON o55_projativ = o58_projativ
                                        AND o55_anousu = o58_anousu
                                        JOIN orcunidade ON o58_orgao = o41_orgao
                                        AND o58_unidade = o41_unidade
                                        AND o58_anousu = o41_anousu
                                        JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                                        where o58_coddot = {$oDotacao->dotacao}";

                $rsDados = db_query($sSqlDotacoes);

                for ($iContDot = 0; $iContDot < pg_num_rows($rsDados); $iContDot++) {
                  $oDadosElemento = db_utils::fieldsMemory($rsDados, $iContDot);

                  $sHash = $oAcordo->getCodigo() . $sCodorgao . str_pad($oDadosElemento->o58_orgao, 2, "0", STR_PAD_LEFT) . str_pad($oDadosElemento->o58_unidade, 3, "0", STR_PAD_LEFT);
                  $sHash .= $oDadosElemento->o58_funcao . $oDadosElemento->o58_subfuncao . $oDadosElemento->o58_programa . $oDadosElemento->o58_projativ;
                  $sHash .= $oDadosElemento->o56_elemento . $oDadosElemento->o15_codtri;

                  if (!isset($aDadosAgrupados12[$sHash])) {

                    $sCodUnidade = str_pad($oDadosElemento->o58_orgao, 2, "0", STR_PAD_LEFT) . str_pad($oDadosElemento->o58_unidade, 3, "0", STR_PAD_LEFT);
                    if ($oDadosElemento->o41_subunidade != 0 || $oDadosElemento->o41_subunidade = null) {
                      $sCodUnidade .= str_pad($oDadosElemento->o41_subunidade, 3, "0", STR_PAD_LEFT);
                    }
                    $result = db_dotacaosaldo(8, 2, 2, true, " o58_coddot = {$oDadosElemento->o58_coddot} and o58_anousu = {$oAcordo->getAno()}",
                      $oAcordo->getAno(), $oAcordo->getDataAssinatura(), $oAcordo->getDataAssinatura());
                    if (pg_num_rows($result) > 0) {
                      $oDot = db_utils::fieldsMemory($result, 0);
                      $oDadosElemento->o58_valor = ($oDot->dot_ini + $oDot->suplementado_acumulado - $oDot->reduzido_acumulado) - $oDot->empenhado_acumulado + $oDot->anulado_acumulado;
                    }

                    $oContrato12 = new stdClass();
                    $oContrato12->si85_tiporegistro = 12;
                    $oContrato12->si85_reg10 = $clcontratos10->si83_sequencial;
                    $oContrato12->si85_codcontrato = $oAcordo->getCodigo();
                    $oContrato12->si85_codorgao = $sCodorgao;
                    $oContrato12->si85_codunidadesub = $sCodUnidade;
                    $oContrato12->si85_codfuncao = $oDadosElemento->o58_funcao;
                    $oContrato12->si85_codsubfuncao = $oDadosElemento->o58_subfuncao;
                    $oContrato12->si85_codprograma = $oDadosElemento->o58_programa;
                    $oContrato12->si85_idacao = $oDadosElemento->o58_projativ;
                    $oContrato12->si85_idsubacao = $oDadosElemento->o55_origemacao;
                    $oContrato12->si85_naturezadespesa = $oDadosElemento->o56_elemento;
                    $oContrato12->si85_codfontrecursos = $oDadosElemento->o15_codtri;
                    $oContrato12->si85_vlrecurso = $oDadosElemento->o58_valor;
                    $oContrato12->si85_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $oContrato12->si85_instit = db_getsession("DB_instit");
                    $aDadosAgrupados12[$sHash] = $oContrato12;

                  } else {
                    $aDadosAgrupados12[$sHash]->si85_vlrecurso += $oDadosElemento->o58_valor;
                  }
                }
              }
            }
          }
          else{

            /**
             * Aqui  tratado apenas os contratos de origem Licitao, Empenho e Processo de Compras quando HOUVER empenho. Quando no houver  tratado no if anterior.
             */

            $oDadosBusca = $oDados10->ac16_origem == self::ORIGEM_LICITACAO ? $oAcordo->getLicitacoes() : $oAcordo->getEmpenhosAcordo();

//                        echo "<pre>";var_dump($oDadosBusca);die();
            foreach ($oDadosBusca as $oDados12) {

              //Se a origem for licitao
              if ($oDados10->ac16_origem == self::ORIGEM_LICITACAO && $oDados10->l20_codigo != '') {
                $sSql = "SELECT distinct on (o58_coddot)
                               o58_coddot,
                               CASE WHEN o40_codtri = '0'
                               OR NULL THEN o40_orgao::varchar ELSE o40_codtri END AS o58_orgao,
                               CASE WHEN o41_codtri = '0'
                               OR NULL THEN o41_unidade::varchar ELSE o41_codtri END AS o58_unidade,
                               o58_funcao, o58_subfuncao,o58_programa,o58_projativ, o55_origemacao,
                               o56_elemento,o15_codtri,o58_valor,o41_subunidade from
                               liclicitem
                               INNER JOIN pcprocitem  ON (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
                               INNER JOIN solicitem ON (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
                               join pcdotac on (pcdotac.pc13_codigo = solicitem.pc11_codigo)
                               join orcdotacao on (pcdotac.pc13_anousu = orcdotacao.o58_anousu) and (pcdotac.pc13_coddot = orcdotacao.o58_coddot)
                               and (orcdotacao.o58_instit = " . db_getsession("DB_instit") . ")
                               join orcelemento on o58_codele = o56_codele and o56_anousu = " . db_getsession("DB_anousu") . "
                               join orctiporec on o58_codigo = o15_codigo
                               join orcprojativ on o55_projativ = o58_projativ and o55_anousu = o58_anousu
                               join orcunidade on o58_orgao = o41_orgao and o58_unidade = o41_unidade and o58_anousu = o41_anousu
                               JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                               where liclicitem.l21_codliclicita = " . $oDados10->l20_codigo;
                $rsDados = db_query($sSql);
              }
              if (($oDados10->l20_codigo == '' || pg_num_rows($rsDados) == 0) && $oDados12->getNumero() != '') {
                $sSql = "SELECT distinct on (o58_coddot)
                        o58_coddot,
                        CASE WHEN o40_codtri = '0'
           OR NULL THEN o40_orgao::varchar ELSE o40_codtri END AS o58_orgao,
                        CASE WHEN o41_codtri = '0'
             OR NULL THEN o41_unidade::varchar ELSE o41_codtri END AS o58_unidade,
             o58_funcao, o58_subfuncao,o58_programa,o58_projativ, o55_origemacao,
                     o56_elemento,o15_codtri,o58_valor,o41_subunidade from empempenho
                     join orcdotacao on e60_coddot = o58_coddot
                     join orcelemento on o58_codele = o56_codele and o56_anousu =   " . db_getsession("DB_anousu") . "
                     join orctiporec on o58_codigo = o15_codigo
                     join orcprojativ on o55_projativ = o58_projativ and o55_anousu = o58_anousu
                     join orcunidade on o58_orgao = o41_orgao and o58_unidade = o41_unidade and o58_anousu = o41_anousu
                     JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                     where o58_anousu =  " . db_getsession("DB_anousu") . " and e60_anousu = " . db_getsession("DB_anousu") . "
                     and e60_numemp = {$oDados12->getNumero()}";
                $rsDados = db_query($sSql);
              }
              if (pg_num_rows($rsDados) == 0 && $oDados10->l20_codigo != '') {
                $sSql = "SELECT distinct on (o58_coddot)
                        o58_coddot,
                        CASE WHEN o40_codtri = '0'
           OR NULL THEN o40_orgao::varchar ELSE o40_codtri END AS o58_orgao,
                        CASE WHEN o41_codtri = '0'
             OR NULL THEN o41_unidade::varchar ELSE o41_codtri END AS o58_unidade,
                        o58_funcao,
                        o58_subfuncao,
                        o58_programa,
                        o58_projativ,
                        o55_origemacao,
                        o56_elemento,
                        o15_codtri,
                        o58_valor,
                        o41_subunidade
                 FROM solicitem
                 JOIN pcdotac ON (pcdotac.pc13_codigo = solicitem.pc11_codigo)
                 JOIN orcdotacao ON (pcdotac.pc13_anousu = orcdotacao.o58_anousu)
                 AND (pcdotac.pc13_coddot = orcdotacao.o58_coddot)
                 AND (orcdotacao.o58_instit = 1)
                 JOIN orcelemento ON o58_codele = o56_codele
                 AND o56_anousu = " . db_getsession("DB_anousu") . "
                 JOIN orctiporec ON o58_codigo = o15_codigo
                 JOIN orcprojativ ON o55_projativ = o58_projativ
                 AND o55_anousu = o58_anousu
                 JOIN orcunidade ON o58_orgao = o41_orgao
                 AND o58_unidade = o41_unidade
                 AND o58_anousu = o41_anousu
                 JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                 WHERE pc11_numero in (select solicitacao.pc53_solicitafilho from solicitavinculo compilacao
                 join solicitavinculo abertura on compilacao.pc53_solicitafilho = abertura.pc53_solicitafilho
                 join solicitavinculo estimativa on estimativa.pc53_solicitapai = abertura.pc53_solicitapai
                 join solicitavinculo solicitacao on estimativa.pc53_solicitafilho = solicitacao.pc53_solicitapai
                 where compilacao.pc53_solicitafilho = (select solicitem.pc11_numero FROM liclicitem
                 INNER JOIN pcprocitem ON (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
                 INNER JOIN solicitem ON (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
                 WHERE liclicitem.l21_codliclicita = {$oDados10->l20_codigo} order by pc11_numero desc limit 1))";
                $rsDados = db_query($sSql);
              }

              for ($iContDot = 0; $iContDot < pg_num_rows($rsDados); $iContDot++) {
                $oDadosElemento = db_utils::fieldsMemory($rsDados, $iContDot);

                $sHash = $oAcordo->getCodigo() . $sCodorgao . str_pad($oDadosElemento->o58_orgao, 2, "0", STR_PAD_LEFT) . str_pad($oDadosElemento->o58_unidade, 3, "0", STR_PAD_LEFT);
                $sHash .= $oDadosElemento->o58_funcao . $oDadosElemento->o58_subfuncao . $oDadosElemento->o58_programa . $oDadosElemento->o58_projativ;
                $sHash .= $oDadosElemento->o56_elemento . $oDadosElemento->o15_codtri;

                if (!isset($aDadosAgrupados12[$sHash])) {

                  $sCodUnidade = str_pad($oDadosElemento->o58_orgao, 2, "0", STR_PAD_LEFT) . str_pad($oDadosElemento->o58_unidade, 3, "0", STR_PAD_LEFT);
                  if ($oDadosElemento->o41_subunidade != 0 || $oDadosElemento->o41_subunidade = null) {
                    $sCodUnidade .= str_pad($oDadosElemento->o41_subunidade, 3, "0", STR_PAD_LEFT);
                  }
                  $result = db_dotacaosaldo(8, 2, 2, true, " o58_coddot = {$oDadosElemento->o58_coddot} and o58_anousu = {$oAcordo->getAno()}",
                    $oAcordo->getAno(), $oAcordo->getDataAssinatura(), $oAcordo->getDataAssinatura());
                  if (pg_num_rows($result) > 0) {
                    $oDot = db_utils::fieldsMemory($result, 0);
                    $oDadosElemento->o58_valor = ($oDot->dot_ini + $oDot->suplementado_acumulado - $oDot->reduzido_acumulado) - $oDot->empenhado_acumulado + $oDot->anulado_acumulado;
                  }

                  $oContrato12 = new stdClass();
                  $oContrato12->si85_tiporegistro = 12;
                  $oContrato12->si85_reg10 = $clcontratos10->si83_sequencial;
                  $oContrato12->si85_codcontrato = $oAcordo->getCodigo();
                  $oContrato12->si85_codorgao = $sCodorgao;
                  $oContrato12->si85_codunidadesub = $sCodUnidade;
                  $oContrato12->si85_codfuncao = $oDadosElemento->o58_funcao;
                  $oContrato12->si85_codsubfuncao = $oDadosElemento->o58_subfuncao;
                  $oContrato12->si85_codprograma = $oDadosElemento->o58_programa;
                  $oContrato12->si85_idacao = $oDadosElemento->o58_projativ;
                  $oContrato12->si85_idsubacao = $oDadosElemento->o55_origemacao;
                  $oContrato12->si85_naturezadespesa = $oDadosElemento->o56_elemento;
                  $oContrato12->si85_codfontrecursos = $oDadosElemento->o15_codtri;
                  $oContrato12->si85_vlrecurso = $oDadosElemento->o58_valor;
                  $oContrato12->si85_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                  $oContrato12->si85_instit = db_getsession("DB_instit");
                  $aDadosAgrupados12[$sHash] = $oContrato12;

                } else {
                  $aDadosAgrupados12[$sHash]->si85_vlrecurso += $oDadosElemento->o58_valor;
                }
              }
            }
          }
        }

        foreach ($aDadosAgrupados12 as $oDadosReg12) {

          $clcontratos12 = new cl_contratos122020();
          $clcontratos12->si85_tiporegistro = 12;
          $clcontratos12->si85_reg10 = $oDadosReg12->si85_reg10;
          $clcontratos12->si85_codcontrato = $oDadosReg12->si85_codcontrato;
          $clcontratos12->si85_codorgao = $oDadosReg12->si85_codorgao;
          $clcontratos12->si85_codunidadesub = $oDadosReg12->si85_codunidadesub;
          $clcontratos12->si85_codfuncao = $oDadosReg12->si85_codfuncao;
          $clcontratos12->si85_codsubfuncao = $oDadosReg12->si85_codsubfuncao;
          $clcontratos12->si85_codprograma = $oDadosReg12->si85_codprograma;
          $clcontratos12->si85_idacao = $oDadosReg12->si85_idacao;
          $clcontratos12->si85_idsubacao = $oDadosReg12->si85_idsubacao;
          $clcontratos12->si85_naturezadespesa = substr($oDadosReg12->si85_naturezadespesa, 1, 6);
          $clcontratos12->si85_codfontrecursos = $oDadosReg12->si85_codfontrecursos;
          $clcontratos12->si85_vlrecurso = $oDadosReg12->si85_vlrecurso;
          $clcontratos12->si85_mes = $oDadosReg12->si85_mes;
          $clcontratos12->si85_instit = $oDadosReg12->si85_instit;

          $clcontratos12->incluir(null);

          if ($clcontratos12->erro_status == 0) {
            throw new Exception($clcontratos12->erro_msg);
          }

        }
      }
      //FIM OC10386
      $sSql = "select case when length(fornecedor.z01_cgccpf) = 11 then 1 else 2 end as tipodocumento,fornecedor.z01_cgccpf as nrodocumento,
      representante.z01_cgccpf as cpfrepresentantelegal
      from cgm as fornecedor
      join pcfornereprlegal on fornecedor.z01_numcgm = pcfornereprlegal.pc81_cgmforn
      join cgm as representante on pcfornereprlegal.pc81_cgmresp = representante.z01_numcgm
      where pcfornereprlegal.pc81_tipopart in (1,3) and fornecedor.z01_numcgm = " . $oAcordo->getContratado()->getCodigo();

      $rsResult13 = db_query($sSql);//db_criatabela($rsResult13);
      $oDados13 = db_utils::fieldsMemory($rsResult13, 0);

      $clcontratos13 = new cl_contratos132020;
      $clcontratos13->si86_tiporegistro = 13;
      $clcontratos13->si86_codcontrato = $oAcordo->getCodigo();
      $clcontratos13->si86_tipodocumento = $oDados13->tipodocumento;
      $clcontratos13->si86_nrodocumento = $oDados13->nrodocumento;
      $clcontratos13->si86_cpfrepresentantelegal = substr($oDados13->cpfrepresentantelegal, 0, 11);
      $clcontratos13->si86_reg10 = $clcontratos10->si83_sequencial;
      $clcontratos13->si86_instit = db_getsession("DB_instit");
      $clcontratos13->si86_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

      $clcontratos13->incluir(null);

      if ($clcontratos13->erro_status == 0) {
        throw new Exception($clcontratos13->erro_msg);
      }

    }

    /*
     * Registro 20
     * Detalhamento dos Termos Aditivos dos Contratos
     *
     */

    $sSql = "
        SELECT DISTINCT ac26_sequencial,
                ac16_sequencial,
                ac16_dataassinatura,
                ac16_numero,
                ac26_numeroaditamento,
                ac35_dataassinaturatermoaditivo,
                ac35_descricaoalteracao,
                ac35_datapublicacao,
                ac35_veiculodivulgacao,
                ac16_deptoresponsavel,
                ac26_numero,
                valoraditado.ac20_valoraditado AS valoraditado,
                quantidadeaditada.ac20_quantidadeaditada AS quantidadeaditada,
                ac26_acordoposicaotipo,
                ac26_vigenciaalterada,
                ac26_data
      FROM acordoposicaoaditamento
      INNER JOIN acordoposicao ON ac26_sequencial = ac35_acordoposicao
      INNER JOIN
          (SELECT ac20_acordoposicao,
                  sum(ac20_valoraditado) AS ac20_valoraditado
          FROM acordoitem
          GROUP BY ac20_acordoposicao ) valoraditado ON valoraditado.ac20_acordoposicao = ac26_sequencial
      INNER JOIN
      ( SELECT ac20_acordoposicao,
              ac20_quantidadeaditada
      FROM acordoitem) quantidadeaditada ON quantidadeaditada.ac20_acordoposicao = ac26_sequencial
      INNER JOIN acordo ON ac26_acordo = ac16_sequencial
      WHERE ac35_dataassinaturatermoaditivo BETWEEN '{$this->sDataInicial}' AND '{$this->sDataFinal}'
          AND ac16_instit = " . db_getsession("DB_instit") . " ORDER BY ac26_sequencial ";

    $rsResult20 = db_query($sSql);
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

      $clcontratos20 = new cl_contratos202020();
      $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

      $sSQL20 = "
              select si87_codaditivo
                from contratos202020
                  where si87_codaditivo = {$oDados20->ac26_sequencial}
            ";
      $rsConsultaR20  = db_query($sSQL20);
      if (pg_num_rows($rsConsultaR20) > 0) {
        continue;
      }

      $sSql = "select  (CASE
              WHEN o41_subunidade != 0
                   OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
                      OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                        OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
              ELSE lpad((CASE WHEN o40_codtri = '0'
                   OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                     OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
             END) as codunidadesub
             from db_departorg join orcunidade on db01_orgao = o41_orgao and db01_unidade = o41_unidade
                   and db01_anousu = o41_anousu
                   JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                   where db01_anousu = " . db_getsession("DB_anousu") . " and db01_coddepto = " . $oDados20->ac16_deptoresponsavel;
      $result = db_query($sSql);
      $sCodUnidade = db_utils::fieldsMemory($result, 0)->codunidadesub;

      $clcontratos20->si87_tiporegistro = 20;
      $clcontratos20->si87_codaditivo = $oDados20->ac26_sequencial;
      $clcontratos20->si87_codorgao = $sCodorgao;
      $clcontratos20->si87_codunidadesub = $sCodUnidade;
      $clcontratos20->si87_nrocontrato = $oDados20->ac16_numero;
      $clcontratos20->si87_dtassinaturacontoriginal = $oDados20->ac16_dataassinatura;
      $clcontratos20->si87_nroseqtermoaditivo = $oDados20->ac26_numeroaditamento;
      $clcontratos20->si87_dtassinaturatermoaditivo = $oDados20->ac35_dataassinaturatermoaditivo;

      $oAcordoPosicao = new AcordoPosicao($oDados20->ac26_sequencial);
      $oAcordo = new Acordo($oDados20->ac16_sequencial);
      $iTipoAlteracaoValor = 3;

      if ($oDados20->valoraditado > 0) {
        $iTipoAlteracaoValor = 1;
      } else if ($oDados20->valoraditado < 0) {
        $iTipoAlteracaoValor = 2;
      }
      $clcontratos20->si87_tipoalteracaovalor = $iTipoAlteracaoValor;
      $clcontratos20->si87_tipotermoaditivo = $this->getTipoTermoAditivo($oAcordoPosicao);


      $clcontratos20->si87_dscalteracao = substr($this->removeCaracteres($oDados20->ac35_descricaoalteracao), 0, 250);
      $oDataTermino = new DBDate($oAcordoPosicao->getVigenciaFinal());//317
      if (in_array($oAcordoPosicao->getTipo(), array(6, 13, 14))) {
        if ($oAcordoPosicao->getTipo() == 14) {
          $clcontratos20->si87_novadatatermino = ($oAcordoPosicao->getVigenciaAlterada() == 's') ? $oDataTermino->getDate() : "";
        } else {
          $clcontratos20->si87_novadatatermino = $oDataTermino->getDate();
        }
      } else {
        $clcontratos20->si87_novadatatermino = "";
      }
      //$clcontratos20->si87_novadatatermino = in_array($oAcordoPosicao->getTipo(), array(7, 13, 14)) ? $oDataTermino->getDate() : "";
      $clcontratos20->si87_valoraditivo = ($iTipoAlteracaoValor == 3 ? 0 : abs($oDados20->valoraditado));
      $clcontratos20->si87_datapublicacao = $oDados20->ac35_datapublicacao;
      $clcontratos20->si87_veiculodivulgacao = $this->removeCaracteres($oDados20->ac35_veiculodivulgacao);
      $clcontratos20->si87_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clcontratos20->si87_instit = db_getsession("DB_instit");

      $clcontratos20->incluir(null);
      if ($clcontratos20->erro_status == 0) {
        throw new Exception($clcontratos20->erro_msg);
      }

      /*
       * Registro 21
       * Detalhamento dos Itens Aditados
       *
       */

      if (in_array($oAcordoPosicao->getTipo(), array(4, 9, 10, 11, 14))) {
        /*if ($oDados20->ac26_sequencial == 320){
        echo '<pre>';var_dump($oAcordoPosicao->getItens());die;}*/
        foreach ($oAcordoPosicao->getItens() as $oAcordoItem) {
          if ($oAcordoItem->getQuantiAditada() > 0 || $oAcordoItem->getValorAditado() > 0) {

            $sSql = "SELECT si43_coditem FROM
                                (select si43_coditem,si43_dscitem  from item102014 union select si43_coditem,si43_dscitem from item102015 union select si43_coditem,si43_dscitem from item102016 union select si43_coditem,si43_dscitem from item102017 union select si43_coditem,si43_dscitem from item102020) as y
                                WHERE si43_dscitem LIKE
                                        '" . trim(preg_replace("/[^a-zA-Z0-9 ]/", "", str_replace($what, $by, $oAcordoItem->getMaterial()->getDescricao()))) . "%'";
            $result = db_query($sSql);
            $iCodItem = db_utils::fieldsMemory($result, 0)->si43_coditem;

            if ($iCodItem == "") {
              $iUnidade = $oAcordoItem->getUnidade() == "" ? 1 : $oAcordoItem->getUnidade();
              $iCodItem = $oAcordoItem->getMaterial()->getCodigo() . $iUnidade;
            }
            $iCodPcmater = $oAcordoItem->getMaterial()->getMaterial();

            $iTipoAlteraoItem = 1;
            if ($oAcordoPosicao->getTipo() == 9) {
              $iTipoAlteraoItem = 1;
            }
            else if ($oAcordoPosicao->getTipo() == 10) {
              $iTipoAlteraoItem = 2;
            }
            else if ($oAcordoPosicao->getTipo() == 11 || $oAcordoPosicao->getTipo() == 14) {
              if ($oAcordoItem->getValorAditado() > 0) {
                $iTipoAlteraoItem = 1;
              } else {
                $iTipoAlteraoItem = 2;
              }
            }
            /*else {
                $iTipoAlteraoItem = $oAcordoItem->getCodigoPosicaoTipo();
            }*/

            $clcontratos21->si88_tiporegistro = 21;
            $clcontratos21->si88_reg20 = $clcontratos20->si87_sequencial;
            $clcontratos21->si88_codaditivo = $clcontratos20->si87_codaditivo;
            $clcontratos21->si88_coditem = $iCodItem  ;
            $clcontratos21->si88_tipoalteracaoitem = $iTipoAlteraoItem;
            //$clcontratos21->si88_quantacrescdecresc = $oAcordoItem->getQuantidadeAditivada($oDados20->ac26_numero);
            $sqlServico = "
                          select pc01_servico, ac20_servicoquantidade
                            from acordoitem
                             inner join pcmater on pc01_codmater = ac20_pcmater
                             inner join acordoposicao on ac26_sequencial = ac20_acordoposicao
                                where ac20_pcmater = {$oAcordoItem->getMaterial()->getCodigo()}
                                 and ac26_sequencial = {$oDados20->ac26_sequencial}

                        ";
            $rsMatServicoR21  = db_query($sqlServico);
            $matServico = db_utils::fieldsMemory($rsMatServicoR21, 0);
            if ($matServico->pc01_servico == "t" && $matServico->ac20_servicoquantidade == "f"){
              $clcontratos21->si88_valorunitarioitem = abs($oAcordoItem->getValorAditado());
            }else{
              $clcontratos21->si88_valorunitarioitem = abs($oAcordoItem->getValorUnitario());
            }
            if($oAcordoItem->getQuantiAditada() == 0){
              $clcontratos21->si88_quantacrescdecresc = 1;
            }else{
              $clcontratos21->si88_quantacrescdecresc = $oAcordoItem->getQuantiAditada();
            }

            /**
             * busca itens obra;
             */
            $sqlItemobra = "select * from licitemobra where obr06_pcmater = $iCodPcmater";
            $rsItems = db_query($sqlItemobra);
            $oDadosItensObra = db_utils::fieldsMemory($rsItems, 0);

            $clcontratos21->si88_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clcontratos21->si88_instit = db_getsession("DB_instit");
            if($oDadosItensObra->obr06_tabela == "1"){
              $clcontratos21->si88_coditemsinapi = $oDadosItensObra->obr06_codigotabela;
              $clcontratos21->si88_coditemsimcro = null;
              $clcontratos21->si88_descoutrosmateriais = null;
            }elseif ($oDadosItensObra->obr06_tabela == "2"){
              $clcontratos21->si88_coditemsimcro = $oDadosItensObra->obr06_codigotabela;
              $clcontratos21->si88_coditemsinapi = null;
              $clcontratos21->si88_descoutrosmateriais = null;
            }elseif ($oDadosItensObra->obr06_tabela == "3"){
              $clcontratos21->si88_coditemsinapi = null;
              $clcontratos21->si88_coditemsimcro = null;
              $clcontratos21->si88_descoutrosmateriais = $oDadosItensObra->obr06_descricaotabela;
            }
            $clcontratos21->si88_itemplanilha = $oDadosItensObra->obr06_codigotabela;

            $clcontratos21->incluir(null);
            if ($clcontratos21->erro_status == 0) {
              throw new Exception($clcontratos21->erro_msg);
            }

          }
        }
      }
    }

    /*
     * selecionar informacoes registro 30
     */
    $sSql = "SELECT acordo.*,
       CASE si03_tipoalteracaoapostila
           WHEN 15 THEN '1'
           WHEN 16 THEN '2'
           WHEN 17 THEN '3'
       END AS tipoalteracaoapostila,
       si03_sequencial,
       si03_licitacao,
       si03_numcontrato,
       si03_dataassinacontrato,
       si03_tipoapostila,
       si03_dataapostila,
       si03_descrapostila,
       si03_numapostilamento,
       si03_valorapostila,
       si03_instit,
       si03_numcontratoanosanteriores,
       si03_acordo,
       si03_acordoposicao
FROM apostilamento
INNER JOIN acordo ON si03_acordo=ac16_sequencial
WHERE si03_dataapostila <='{$this->sDataFinal}'
    AND si03_dataapostila >= '{$this->sDataInicial}'
    AND si03_instit = " . db_getsession("DB_instit");
    $rsResult30 = db_query($sSql);
//        echo $sSql; db_criatabela($rsResult30);

    for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {

      $oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);
      $aAnoContrato = explode("-", $oDados30->si03_dataassinacontrato);

      if ($aAnoContrato[0] > 2013) {
        $sSql = "select  (CASE
    WHEN o41_subunidade != 0
         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
    ELSE lpad((CASE WHEN o40_codtri = '0'
         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
   END) as codunidadesub
   from db_departorg join orcunidade on db01_orgao = o41_orgao and db01_unidade = o41_unidade
         and db01_anousu = o41_anousu
         JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                  where db01_anousu ={$oDados30->ac16_anousu}  and db01_coddepto ={$oDados30->ac16_deptoresponsavel}";

        $result = db_query($sSql);
        $sCodUnidadeSub = db_utils::fieldsMemory($result, 0)->codunidadesub;
      } else {
        $sCodUnidadeSub = ' ';
      }

      $clcontratos30 = new cl_contratos302020();

      $clcontratos30->si89_tiporegistro = 30;
      $clcontratos30->si89_codorgao = $sCodorgao;
      $clcontratos30->si89_codunidadesub = $sCodUnidadeSub;
      $clcontratos30->si89_nrocontrato = $oDados30->ac16_numeroacordo;
      $clcontratos30->si89_dtassinaturacontoriginal = $oDados30->si03_dataassinacontrato;
      $clcontratos30->si89_tipoapostila = $oDados30->si03_tipoapostila;
      $clcontratos30->si89_nroseqapostila = $oDados30->si03_numapostilamento;
      $clcontratos30->si89_dataapostila = $oDados30->si03_dataapostila;
      $clcontratos30->si89_tipoalteracaoapostila = $oDados30->tipoalteracaoapostila;
      $clcontratos30->si89_dscalteracao = substr($this->removeCaracteres($oDados30->si03_descrapostila), 0, 250);
      $clcontratos30->si89_valorapostila = $oDados30->si03_valorapostila;
      $clcontratos30->si89_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clcontratos30->si89_instit = $oDados30->si03_instit;
      $clcontratos30->incluir(null);
      if ($clcontratos30->erro_status == 0) {
        throw new Exception($clcontratos30->erro_msg);
      }

    }

    /*
    * selecionar informacoes registro 40
    */
    $sSql = "SELECT *
          FROM acordo
          WHERE ac16_acordosituacao = 2
            AND ac16_datarescisao BETWEEN '{$this->sDataInicial}' AND '{$this->sDataFinal}'
            AND ac16_instit = " . db_getsession("DB_instit");

    $rsResult40 = db_query($sSql);

    for ($iCont40 = 0; $iCont40 < pg_num_rows($rsResult40); $iCont40++) {

      $clcontratos40 = new cl_contratos402020();
      $oDados40 = db_utils::fieldsMemory($rsResult40, $iCont40);

      $aAnoContrato = explode("-", $oDados40->ac16_dataassinatura);

      if ($aAnoContrato[0] > 2013) {

        $sSql = "select  (CASE
    WHEN o41_subunidade != 0
         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
    ELSE lpad((CASE WHEN o40_codtri = '0'
         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
   END) as codunidadesub
   from db_departorg join orcunidade on db01_orgao = o41_orgao and db01_unidade = o41_unidade
         and db01_anousu = o41_anousu
         JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                  where db01_anousu ={$oDados40->ac16_anousu}  and db01_coddepto ={$oDados40->ac16_deptoresponsavel}";

        $result = db_query($sSql);//db_criatabela($result);echo $sSql;echo pg_last_error();
        $sCodUnidadeSub = db_utils::fieldsMemory($result, 0)->codunidadesub;
      } else {
        $sCodUnidadeSub = ' ';
      }

      $clcontratos40->si91_tiporegistro               = 40;
      $clcontratos40->si91_codorgao                   = $sCodorgao;
      $clcontratos40->si91_codunidadesub              = $sCodUnidadeSub;
      $clcontratos40->si91_nrocontrato                = $oDados40->ac16_numeroacordo;
      $clcontratos40->si91_dtassinaturacontoriginal   = $oDados40->ac16_dataassinatura;
      $clcontratos40->si91_datarescisao               = $oDados40->ac16_datarescisao;
      $clcontratos40->si91_valorcancelamentocontrato  = $oDados40->ac16_valorrescisao;
      $clcontratos40->si91_mes                        = date('m', strtotime($this->sDataFinal));
      $clcontratos40->si91_instit                     = $oDados40->ac16_instit;

      $clcontratos40->incluir(null);

      if ($clcontratos40->erro_status == 0) {
        throw new Exception($clcontratos40->erro_msg);
      }

    }

    db_fim_transacao();

    $oGerarCONTRATOS = new GerarCONTRATOS();
    $oGerarCONTRATOS->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarCONTRATOS->gerarDados();

  }

}
