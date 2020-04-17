<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

require_once("classes/db_ops102020_classe.php");
require_once("classes/db_ops112020_classe.php");
require_once("classes/db_ops122020_classe.php");
require_once("classes/db_ops132020_classe.php");

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarOPS.model.php");

/**
 * Pagamento das Despesas Sicom Acompanhamento Mensal
 * @author Marcelo
 * @package Contabilidade
 */
class SicomArquivoPagamentosDespesas extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout = 172;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'OPS';

  /**
   * @var array Fontes encerradas em 2020
   */
  protected $aFontesEncerradas = array('148', '149', '150', '151', '152', '248', '249', '250', '251', '252');

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

  }

  /**
   * selecionar os dados dos pagamentos de despesa do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {


    $clops10 = new cl_ops102020();
    $clops11 = new cl_ops112020();
    $clops12 = new cl_ops122020();
    $clops13 = new cl_ops132020();

      $sSqlUnidade = "SELECT * FROM infocomplementares
                      WHERE si08_anousu = " . db_getsession("DB_anousu") . "
                        AND si08_instit = " . db_getsession("DB_instit");

      $rsResultUnidade = db_query($sSqlUnidade);
      $sTrataCodUnidade = db_utils::fieldsMemory($rsResultUnidade, 0)->si08_tratacodunidade;

    db_inicio_transacao();
    /**
     * excluir informacoes do mes caso ja tenha sido gerado anteriormente
     */

    $result = $clops13->sql_record($clops13->sql_query(null, "*", null, "si135_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'])
      . " and si135_instit = " . db_getsession("DB_instit"));

    if (pg_num_rows($result) > 0) {
      $clops13->excluir(null, "si135_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
        . " and si135_instit = " . db_getsession("DB_instit"));
      if ($clops13->erro_status == 0) {
        throw new Exception($clops13->erro_msg);
      }
    }
    $result = $clops12->sql_record($clops12->sql_query(null, "*", null, "si134_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
      . " and si134_instit = " . db_getsession("DB_instit")));

    if (pg_num_rows($result) > 0) {
      $clops12->excluir(null, "si134_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
        . " and si134_instit = " . db_getsession("DB_instit"));
      if ($clops12->erro_status == 0) {
        throw new Exception($clops12->erro_msg);
      }
    }

    $result = $clops11->sql_record($clops11->sql_query(null, "*", null, "si133_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
      . " and si133_instit = " . db_getsession("DB_instit")));

    if (pg_num_rows($result) > 0) {
      $clops11->excluir(null, "si133_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
        . " and si133_instit = " . db_getsession("DB_instit"));
      if ($clops11->erro_status == 0) {
        throw new Exception("Erro registro 11:" . $clops11->erro_msg);
      }
    }

    $result = $clops10->sql_record($clops10->sql_query(null, "*", null, "si132_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
      . " and si132_instit = " . db_getsession("DB_instit")));

    if (pg_num_rows($result) > 0) {
      $clops10->excluir(null, "si132_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
        . " and si132_instit = " . db_getsession("DB_instit"));
      if ($clops10->erro_status == 0) {
        throw new Exception("Erro registro 10:" . $clops10->erro_msg);
      }
    }


    $sSql = "SELECT 10 AS tiporesgistro,
                   si09_codorgaotce AS codorgao,
                   lpad((CASE
                             WHEN o40_codtri = '0'
                                  OR NULL THEN o40_orgao::varchar
                             ELSE o40_codtri
                         END),2,0)||lpad((CASE
                                              WHEN o41_codtri = '0'
                                                   OR NULL THEN o41_unidade::varchar
                                              ELSE o41_codtri
                                          END),3,0) AS codunidadesub,
                   c71_codlan||lpad(e50_codord,10,0) AS nroop,
                   c80_data AS dtpagamento,
                   c70_valor AS valor,
                   e50_obs AS especificacaoop,
                   o41_ordpagamento,
                   o41_orgao,
                   o41_unidade,
                   o41_anousu,
                   o.z01_cgccpf AS cpfresppgto,
                   e50_codord AS ordem,
                   e60_numemp,
                   o41_subunidade AS subunidade,
                   c71_codlan AS lancamento
            FROM pagordem
            JOIN pagordemele ON e53_codord = e50_codord
            JOIN empempenho ON e50_numemp = e60_numemp
            JOIN orcdotacao ON (e60_anousu, e60_coddot) = (o58_anousu, o58_coddot)
            JOIN orcunidade ON (o58_anousu, o58_orgao, o58_unidade) = (o41_anousu, o41_orgao, o41_unidade)
            JOIN orcorgao ON (o40_orgao, o40_anousu) = (o41_orgao, o41_anousu)
            JOIN conlancamord ON c80_codord = e50_codord
            JOIN conlancamdoc ON c71_codlan = c80_codlan
            JOIN conlancam ON c70_codlan = c71_codlan
            LEFT JOIN db_usuacgm ON id_usuario = e50_id_usuario
            LEFT JOIN infocomplementaresinstit ON si09_instit = e60_instit
            LEFT JOIN cgm o ON o.z01_numcgm = o41_ordpagamento
            WHERE c80_data BETWEEN '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'
              AND c71_coddoc IN (5, 35, 37)
              AND e60_instit = " . db_getsession("DB_instit") . "
            ORDER BY e50_codord, c70_valor";

    $rsEmpenhosPagosGeral = db_query($sSql);

    //$aCaracteres = array("°",chr(13),chr(10),"'",);
    // matriz de entrada
    $what = array("°", chr(13), chr(10), 'ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'Ã', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º');

    // matriz de saída
    $by = array('', '', '', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ');
    $aInformado = array();
    for ($iCont = 0; $iCont < pg_num_rows($rsEmpenhosPagosGeral); $iCont++) {

      $oEmpPago = db_utils::fieldsMemory($rsEmpenhosPagosGeral, $iCont);

      /**
       * pegar quantidade de extornos
       */


      $sSqlExtornos = "SELECT sum(c70_valor) AS valor
                        FROM conlancamdoc
                        JOIN conhistdoc ON c53_coddoc = c71_coddoc
                        JOIN conlancamord ON c71_codlan = c80_codlan
                        JOIN conlancam ON c70_codlan = c71_codlan
                        WHERE c53_tipo IN (31, 30)
        AND c80_codord = {$oEmpPago->ordem}
                          AND c70_data BETWEEN  '{$this->sDataInicial}'  AND '{$this->sDataFinal}'";
      $rsQuantExtornos = db_query($sSqlExtornos);

      if (db_utils::fieldsMemory($rsQuantExtornos, 0)->valor == "" || db_utils::fieldsMemory($rsQuantExtornos, 0)->valor > 0) {
        $sHash = $oEmpPago->ordem;

        if (!isset($aInformado[$sHash])) {

          $clops10 = new cl_ops102020();

            if (($sTrataCodUnidade == 2) && ($oEmpPago->subunidade != '' && $oEmpPago->subunidade != 0)) {

                $sCodUnidade  = $oEmpPago->codunidadesub;
                $sCodUnidade .= str_pad($oEmpPago->subunidade, 3, "0", STR_PAD_LEFT);

            } else {

                $sCodUnidade  = $oEmpPago->codunidadesub;

            }
          /*
           * Verifica se o empenho existe na tabela dotacaorpsicom
           * Caso exista, busca os dados da dotação.
           * */
          $sSqlDotacaoRpSicom = "select * from dotacaorpsicom where si177_numemp = {$oEmpPago->e60_numemp}";
          $iFonteAlterada = '0';
          if (pg_num_rows(db_query($sSqlDotacaoRpSicom)) > 0) {
            $aDotacaoRpSicom = db_utils::getColectionByRecord(db_query($sSqlDotacaoRpSicom));
            $iFonteAlterada = str_pad($aDotacaoRpSicom[0]->si177_codfontrecursos, 3, "0", STR_PAD_LEFT);
            $clops10->si132_codorgao = str_pad($aDotacaoRpSicom[0]->si177_codorgaotce, 2, "0", STR_PAD_LEFT);
            $clops10->si132_codunidadesub = strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 5 && strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 8 ? "0" . $aDotacaoRpSicom[0]->si177_codunidadesub : $aDotacaoRpSicom[0]->si177_codunidadesub;
          } else {
            $clops10->si132_codorgao = $oEmpPago->codorgao;
            $clops10->si132_codunidadesub = $sCodUnidade;
          }
          $clops10->si132_tiporegistro = $oEmpPago->tiporesgistro;
          $clops10->si132_nroop = $oEmpPago->nroop;
          $clops10->si132_dtpagamento = $oEmpPago->dtpagamento;
          $clops10->si132_vlop = $oEmpPago->valor;
          $clops10->si132_especificacaoop = $oEmpPago->especificacaoop == '' ? 'SEM HISTORICO'
            : trim(preg_replace("/[^a-zA-Z0-9 ]/", "", substr(str_replace($what, $by, $oEmpPago->especificacaoop), 0, 500)));
          $clops10->si132_cpfresppgto = substr($oEmpPago->cpfresppgto, 0, 11);
          $clops10->si132_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
          $clops10->si132_instit = db_getsession("DB_instit");
          $clops10->retencao = 0;

          $clops10->incluir(null);
          if ($clops10->erro_status == 0) {

            throw new Exception($clops10->erro_msg);
          }
          $aInformado[$sHash] = $clops10;

          $sSql11 = " SELECT tiporegistro, codreduzidoop, codunidadesub, nroop, tipopagamento, nroempenho, dtempenho, nroliquidacao, dtliquidacao,
                             codfontrecursos, sum(valorfonte) AS valorfonte, tipodocumentocredor, nrodocumento, codorgaoempop, codunidadeempop, subunidade
                      FROM
                          (SELECT 11 AS tiporegistro,
                                  c71_codlan||e50_codord AS codreduzidoop,
                                  lpad((CASE
                                            WHEN o40_codtri = '0'
                                                 OR NULL THEN o40_orgao::varchar
                                            ELSE o40_codtri
                                        END),2,0)||lpad((CASE
                                                             WHEN o41_codtri = '0'
                                                                  OR NULL THEN o41_unidade::varchar
                                                             ELSE o41_codtri
                                                         END),3,0) AS codunidadesub,
                                  c71_codlan||lpad(e50_codord,10,0) AS nroop,
                                  CASE
                                      WHEN c71_coddoc = 35 THEN 3
                                      WHEN c71_coddoc = 37 THEN 4
                                      WHEN substr(o56_elemento,2,2) = '46' THEN 2
                                      ELSE 1
                                  END AS tipopagamento,
                                  e60_codemp AS nroempenho,
                                  e60_emiss AS dtempenho,
                                  CASE
                                      WHEN date_part('year',e50_data) < 2015 THEN e71_codnota::varchar /*nao alterar esse ano*/
                                      ELSE (rpad(e71_codnota::varchar,9,'0') || lpad(e71_codord::varchar,9,'0'))
                                  END AS nroliquidacao,
                                  e50_data AS dtliquidacao,
                                  o15_codtri AS codfontrecursos,
                                  c70_valor AS valorfonte,
                                  CASE
                                      WHEN length(forn.z01_cgccpf) = 11 THEN 1
                                      ELSE 2
                                  END AS tipodocumentocredor,
                                  forn.z01_cgccpf AS nrodocumento,
                                  ' '::char AS codorgaoempop,
                                  ' '::char AS codunidadeempop,
                                  e60_instit AS instituicao,
                                  o41_subunidade AS subunidade
                           FROM pagordem
                           JOIN pagordemele ON e53_codord = e50_codord
                           JOIN empempenho ON e50_numemp = e60_numemp
                           JOIN orcdotacao ON o58_anousu = e60_anousu AND e60_coddot = o58_coddot
                           JOIN orcunidade ON o58_anousu = o41_anousu AND o58_orgao = o41_orgao AND o58_unidade =o41_unidade
                           JOIN orcorgao ON o40_orgao = o41_orgao AND o40_anousu = o41_anousu
                           JOIN conlancamord ON c80_codord = e50_codord
                           JOIN conlancamdoc ON c71_codlan = c80_codlan
                           JOIN conlancam ON c70_codlan = c71_codlan
                           JOIN orcelemento ON o58_codele = o56_codele AND o58_anousu = o56_anousu
                           JOIN orctiporec ON o58_codigo = o15_codigo
                           JOIN cgm forn ON e60_numcgm = forn.z01_numcgm
                           JOIN pagordemnota ON e71_codord = e50_codord
                           LEFT JOIN infocomplementaresinstit ON si09_instit = e60_instit
                           WHERE c71_data BETWEEN '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'
                             AND c71_coddoc IN (5, 35, 37)
                             AND e50_codord = {$oEmpPago->ordem}
                             AND c71_codlan = {$oEmpPago->lancamento}
                           ORDER BY c71_codlan) AS pagamentos
                      GROUP BY tiporegistro, codreduzidoop, codunidadesub, nroop, tipopagamento, nroempenho, dtempenho, nroliquidacao, 
                               dtliquidacao, codfontrecursos, tipodocumentocredor, nrodocumento, codorgaoempop, codunidadeempop, subunidade ";

          $rsPagOrd11 = db_query($sSql11);

          $reg11 = db_utils::fieldsMemory($rsPagOrd11, 0);

          if (pg_num_rows($rsPagOrd11) > 0) {
            $clops11 = new cl_ops112020();
            if ($reg11->subunidade != '' && $reg11->subunidade != 0) {
              $reg11->codunidadesub .= str_pad($reg11->subunidade, 3, "0", STR_PAD_LEFT);
            }
            $clops11->si133_tiporegistro = $reg11->tiporegistro;
            $clops11->si133_codreduzidoop = $reg11->codreduzidoop;
            $clops11->si133_codunidadesub = $clops10->si132_codunidadesub;
            $clops11->si133_nroop = $oEmpPago->nroop;
            $clops11->si133_dtpagamento = $oEmpPago->dtpagamento;
            $clops11->si133_tipopagamento = $reg11->tipopagamento;
            $clops11->si133_nroempenho = $reg11->nroempenho;
            $clops11->si133_dtempenho = $reg11->dtempenho;
            if($reg11->tipopagamento == 3){
                $clops11->si133_nroliquidacao = "";
                $clops11->si133_dtliquidacao = "";
            }else{
                $clops11->si133_nroliquidacao = $reg11->nroliquidacao;
                $clops11->si133_dtliquidacao = $reg11->dtliquidacao;
            }
            $clops11->si133_codfontrecursos = $iFonteAlterada != '0' ? $iFonteAlterada : $reg11->codfontrecursos;
            if (in_array($clops11->si133_codfontrecursos, $this->aFontesEncerradas)) {
                $clops11->si133_codfontrecursos = substr($clops11->si133_codfontrecursos, 0, 1).'59';
            }
            $clops11->si133_valorfonte = $oEmpPago->valor;
            $clops11->si133_tipodocumentocredor = $reg11->tipodocumentocredor;
            $clops11->si133_nrodocumento = $reg11->nrodocumento;
            $clops11->si133_codorgaoempop = $reg11->codorgaoempop;
            $clops11->si133_codunidadeempop = $reg11->codunidadeempop;
            $clops11->si133_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clops11->si133_reg10 = $clops10->si132_sequencial;
            $clops11->si133_instit = db_getsession("DB_instit");


            $clops11->incluir(null);
            if ($clops11->erro_status == 0) {
              throw new Exception($clops11->erro_msg);
            }

          }

          $sSql12 = "SELECT 12 AS tiporegistro,
                            e82_codord AS codreduzidoop,
                            CASE
                                WHEN e96_codigo = 4 AND c60_codsis = 5 THEN 5
                                WHEN e96_codigo = 1 THEN 5
                                WHEN e96_codigo = 2 THEN 1
                                ELSE 99
                            END AS tipodocumentoop,
                            CASE
                                WHEN e96_codigo = 2 THEN e86_cheque
                                ELSE NULL
                            END AS nrodocumento,
                            c61_reduz AS codctb,
                            o15_codigo AS codfontectb,
                            e50_data AS dtemissao,
                            k12_valor AS vldocumento,
                            CASE
                                WHEN c60_codsis = 5 THEN ''
                                ELSE e96_descr
                            END desctipodocumentoop,
                            c23_conlancam AS codlan
                     FROM empagemov
                     INNER JOIN empage ON empage.e80_codage = empagemov.e81_codage
                     INNER JOIN empord ON empord.e82_codmov = empagemov.e81_codmov
                     INNER JOIN empempenho ON empempenho.e60_numemp = empagemov.e81_numemp
                     LEFT JOIN empagemovforma ON empagemovforma.e97_codmov = empagemov.e81_codmov
                     LEFT JOIN empageforma ON empageforma.e96_codigo = empagemovforma.e97_codforma
                     LEFT JOIN empagepag ON empagepag.e85_codmov = empagemov.e81_codmov
                     LEFT JOIN empagetipo ON empagetipo.e83_codtipo = empagepag.e85_codtipo
                     LEFT JOIN empageconf ON empageconf.e86_codmov = empagemov.e81_codmov
                     LEFT JOIN empageconfgera ON (empageconfgera.e90_codmov, empageconfgera.e90_cancelado) = (empagemov.e81_codmov, 'f')
                     LEFT JOIN saltes ON saltes.k13_conta = empagetipo.e83_conta
                     LEFT JOIN empagegera ON empagegera.e87_codgera = empageconfgera.e90_codgera
                     LEFT JOIN empagedadosret ON empagedadosret.e75_codgera = empagegera.e87_codgera
                     LEFT JOIN empagedadosretmov ON (empagedadosretmov.e76_codret, empagedadosretmov.e76_codmov) = (empagedadosret.e75_codret, empagemov.e81_codmov)
                     LEFT JOIN empagedadosretmovocorrencia ON (empagedadosretmovocorrencia.e02_empagedadosretmov, empagedadosretmovocorrencia.e02_empagedadosret) = (empagedadosretmov.e76_codmov, empagedadosretmov.e76_codret)
                     LEFT JOIN errobanco ON errobanco.e92_sequencia = empagedadosretmovocorrencia.e02_errobanco
                     LEFT JOIN empageconfche ON empageconfche.e91_codmov = empagemov.e81_codmov AND empageconfche.e91_ativo IS TRUE
                     LEFT JOIN corconf ON corconf.k12_codmov = empageconfche.e91_codcheque AND corconf.k12_ativo IS TRUE
                     LEFT JOIN corempagemov ON corempagemov.k12_codmov = empagemov.e81_codmov
                     LEFT JOIN pagordemele ON e53_codord = empord.e82_codord
                     LEFT JOIN empagenotasordem ON e43_empagemov = e81_codmov
                     LEFT JOIN coremp ON (coremp.k12_id, coremp.k12_data, coremp.k12_autent) = (corempagemov.k12_id, corempagemov.k12_data, corempagemov.k12_autent)
                     JOIN pagordem ON (k12_empen, k12_codord) = (e50_numemp, e50_codord)
                     JOIN corrente ON (coremp.k12_autent, coremp.k12_data, coremp.k12_id) = (corrente.k12_autent, corrente.k12_data, corrente.k12_id) AND corrente.k12_estorn != TRUE
                     JOIN conplanoreduz ON c61_reduz = k12_conta AND c61_anousu = " . db_getsession("DB_anousu") . "
                     JOIN conplano ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu
                     LEFT JOIN conplanoconta ON c63_codcon = c60_codcon AND c60_anousu = c63_anousu
                     JOIN corgrupocorrente cg ON cg.k105_autent = corrente.k12_autent
                     JOIN orcdotacao ON (o58_coddot, o58_anousu) = (e60_coddot, e60_anousu)
                     JOIN orctiporec ON o58_codigo = o15_codigo AND (cg.k105_data, cg.k105_id) = (corrente.k12_data, corrente.k12_id)
                     JOIN conlancamcorgrupocorrente ON c23_corgrupocorrente = cg.k105_sequencial AND c23_conlancam = {$oEmpPago->lancamento}
                     WHERE e60_instit = " . db_getsession("DB_instit") . "
                       AND k12_codord = {$oEmpPago->ordem}
                       AND e81_cancelado IS NULL";

          $rsPagOrd12 = db_query($sSql12);

          $reg12 = db_utils::fieldsMemory($rsPagOrd12, 0);

          /**
           * VERIFICA SE HOUVE RETENCAO NA ORDEM. CASO TENHA O VALOR SERA SUBTRAIDO NO VALOR DO LANCAMENTO.
           */
          $sqlReten = "SELECT sum(e23_valorretencao) AS descontar
                       FROM retencaopagordem
                       JOIN retencaoreceitas ON e23_retencaopagordem = e20_sequencial
                       JOIN retencaotiporec ON e23_retencaotiporec = e21_sequencial
                       WHERE e23_recolhido = TRUE
                         AND e20_pagordem = {$oEmpPago->ordem}
                         AND e23_dtcalculo BETWEEN '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'";
          $rsReteIsIs = db_query($sqlReten);

          if (pg_num_rows($rsReteIsIs) > 0 && db_utils::fieldsMemory($rsReteIsIs, 0)->descontar > 0) {

            $nVolorOp = $oEmpPago->valor - db_utils::fieldsMemory($rsReteIsIs, 0)->descontar;
            if ($nVolorOp == 0) {
              $saldopag = db_utils::fieldsMemory($rsReteIsIs, 0)->descontar;
            } else {
              $saldopag = $nVolorOp;
            }
            $aInformado[$sHash]->retencao = 1;
            if ($nVolorOp < 0) {
              $nVolorOp = $oEmpPago->valor;
              $aInformado[$sHash]->retencao = 0;
            }

          } else {
            $nVolorOp = $oEmpPago->valor;
            $saldopag = $nVolorOp;
          }

          if (pg_num_rows($rsPagOrd12) > 0 && $reg12->codctb != '') {
            $clops12 = new cl_ops122020();

            $sSqlContaPagFont = "select * from ( select distinct 'ctb102020' as ano, si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102020 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202020 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu") . "
                              and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $sSqlContaPagFont .= " UNION select distinct 'ctb102019' as ano, si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102019 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202019 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct 'ctb102018' as ano, si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102018 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202018 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct 'ctb102017' as ano, si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102017 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202017 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct 'ctb102016' as ano, si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102016 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202016 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu");
              $sSqlContaPagFont .= " UNION select distinct 'ctb102015' as ano, si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102015 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202015 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct 'ctb102014' as ano, si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102014 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202014 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu") . ") as x order by contapag asc";
            $rsResultContaPag = db_query($sSqlContaPagFont) or die($sSqlContaPagFont." teste1");

            $ContaPag = db_utils::fieldsMemory($rsResultContaPag)->contapag;

            $FontContaPag = db_utils::fieldsMemory($rsResultContaPag)->fonte;

            $clops12->si134_tiporegistro = $reg12->tiporegistro;
            $clops12->si134_codreduzidoop = $reg11->codreduzidoop;
            $clops12->si134_tipodocumentoop = $reg12->tipodocumentoop;
            $clops12->si134_nrodocumento = $reg12->nrodocumento;
            $clops12->si134_codctb = $ContaPag;
            $clops12->si134_codfontectb = $reg11->codfontrecursos;
            if (in_array($clops12->si134_codfontectb, $this->aFontesEncerradas)) {
                $clops12->si134_codfontectb = substr($clops12->si134_codfontectb, 0, 1).'59';
            }
            $clops12->si134_desctipodocumentoop = $reg12->tipodocumentoop == "99" ? "TED" : ' ';
            $clops12->si134_dtemissao = $reg12->dtemissao;
            $clops12->si134_vldocumento = $nVolorOp;
            $clops12->si134_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clops12->si134_reg10 = $clops10->si132_sequencial;
            $clops12->si134_instit = db_getsession("DB_instit");
          } else {
            //pegar codlan
            //$codlan = substr($oEmpPago->nroop, 0, -10);
            $sSqlContaPagFont = "select * from (select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102020 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202020 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu") . "
                              and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $sSqlContaPagFont .= " UNION  select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102018 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202018 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu") . "
                              and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $sSqlContaPagFont .= " UNION  select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102017 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202017 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu") . "
                              and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $sSqlContaPagFont .= " UNION  select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102016 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202016 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu") . "
                              and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102015 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202015 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102014 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202014 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu") . ") as x order by contapag asc";
            $rsResultContaPag = db_query($sSqlContaPagFont) or die($sSqlContaPagFont." teste2");

            $ContaPag2 = db_utils::fieldsMemory($rsResultContaPag)->contapag;

            $FontContaPag2 = db_utils::fieldsMemory($rsResultContaPag)->fonte;

            $clops12 = new cl_ops122020();

            $clops12->si134_tiporegistro = 12;
            $clops12->si134_codreduzidoop = $reg11->codreduzidoop;
            $clops12->si134_tipodocumentoop = 99;
            $clops12->si134_nrodocumento = 0;
            $clops12->si134_codctb = $ContaPag2;
            $clops12->si134_codfontectb = $reg11->codfontrecursos;
            if (in_array($clops12->si134_codfontectb, $this->aFontesEncerradas)) {
                $clops12->si134_codfontectb = substr($clops12->si134_codfontectb, 0, 1).'59';
            }
            $clops12->si134_desctipodocumentoop = "TED";
            $clops12->si134_dtemissao = $oEmpPago->dtpagamento;
            $clops12->si134_vldocumento = $nVolorOp;
            $clops12->si134_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clops12->si134_reg10 = $clops10->si132_sequencial;
            $clops12->si134_instit = db_getsession("DB_instit");
          }

          $clops12->incluir(null);
          if ($clops12->erro_status == 0) {
            throw new Exception($clops12->erro_msg);
          }
          $nVolorOp = 0;
          if ($saldopag > 0 && $aInformado[$sHash]->retencao == 1) {
            $sSql13 = "SELECT 13 AS tiporegistro,
                              e20_pagordem AS codreduzidoop,
                              CASE
                                  WHEN substr(k02_estorc,1,9) IN ('411130311', '411130341', '411180231') THEN 1
                                  ELSE c60_tipolancamento
                              END AS c60_tipolancamento,
                              CASE
                                  WHEN substr(k02_estorc,1,9) = '411180231' THEN 4
                                  WHEN substr(k02_estorc,1,9) IN ('411130311', '411130341') THEN 3
                                  ELSE c60_subtipolancamento
                              END AS c60_subtipolancamento,
                              CASE 
                                 WHEN k02_reduz IS NULL THEN k02_codrec
                                 ELSE k02_reduz
                              END AS k02_reduz,
                              CASE
                                  WHEN e21_retencaotipocalc = 5 OR substr(k02_estorc,1,9)::integer = 411180231 THEN 4
                                  WHEN e21_retencaotipocalc IN (3, 4, 7) THEN 1
                                  WHEN e21_retencaotipocalc IN (1, 2) OR substr(k02_estorc,1,9)::integer IN (411130311, 411130341) THEN 3
                                  ELSE lpad(k02_reduz,4,0)::integer
                              END AS tiporetencao,
                              CASE
                                  WHEN e21_retencaotipocalc NOT IN (1, 2, 3, 4, 5, 7) THEN e21_descricao
                                  ELSE NULL
                              END AS descricaoretencao,
                              e23_valorretencao AS vlrentencao
                       FROM retencaopagordem
                       JOIN retencaoreceitas ON e23_retencaopagordem = e20_sequencial
                       JOIN retencaotiporec ON e23_retencaotiporec = e21_sequencial
                       LEFT JOIN tabrec tr ON tr.k02_codigo = e21_receita
                       LEFT JOIN tabplan tp ON tp.k02_codigo = tr.k02_codigo AND tp.k02_anousu = " . db_getsession("DB_anousu") . "
                       LEFT JOIN conplano ON (tp.k02_anousu, tp.k02_estpla) = (conplano.c60_anousu, conplano.c60_estrut)
                       LEFT JOIN taborc ON tr.k02_codigo = taborc.k02_codigo AND taborc.k02_anousu = " . db_getsession("DB_anousu") . "
                       WHERE e23_recolhido = TRUE
                         AND e20_pagordem = {$oEmpPago->ordem}
                         AND e23_dtcalculo BETWEEN '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'";

            $rsPagOrd13 = db_query($sSql13);

            if (pg_num_rows($rsPagOrd13) > 0 && $aInformado[$sHash]->retencao == 1) {

              $aOps23 = array();
              $subTipo = array(1, 2, 3, 4);
              for ($iCont13 = 0; $iCont13 < pg_num_rows($rsPagOrd13); $iCont13++) {

                $reg13 = db_utils::fieldsMemory($rsPagOrd13, $iCont13);
                $sHash = $reg13->tiporetencao . $reg11->e50_codord;
                if ($reg13->c60_tipolancamento == 1){
                  $sHash .= $reg13->c60_tipolancamento.$reg13->c60_subtipolancamento;
                }

                if (!isset($aOps23[$sHash])) {
                  $clops13 = new stdClass();

                  $clops13->si135_tiporegistro = $reg13->tiporegistro;
                  $clops13->si135_codreduzidoop = $reg11->codreduzidoop;

                  if ($reg13->c60_tipolancamento == 1){
                    $clops13->si135_tiporetencao = $reg13->c60_subtipolancamento;
                  } elseif ($reg13->c60_tipolancamento != 1 && !empty($reg13->c60_subtipolancamento)) {
                    $clops13->si135_tiporetencao = substr($reg13->c60_tipolancamento, 0, 2).substr($reg13->c60_subtipolancamento,-2);
                  } else {
                    $clops13->si135_tiporetencao = $reg13->tiporetencao;
                  }

                  if ($reg13->c60_tipolancamento == 1 && in_array($reg13->c60_subtipolancamento, $subTipo)){
                    $clops13->si135_descricaoretencao = " ";
                  } else {
                    $clops13->si135_descricaoretencao = substr($reg13->descricaoretencao, 0, 50);
                  }

                  $clops13->si135_vlretencao = $reg13->vlrentencao;
                  $clops13->si135_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                  $clops13->si135_reg10 = $clops10->si132_sequencial;
                  $clops13->si135_instit = db_getsession("DB_instit");

                  $aOps23[$sHash] = $clops13;
                } else {
                  $aOps23[$sHash]->si135_vlretencao += $reg13->vlrentencao;
                }
              }

              foreach ($aOps23 as $oOps23ag) {

                $clops13 = new cl_ops132020();

                $clops13->si135_tiporegistro = $oOps23ag->si135_tiporegistro;
                $clops13->si135_codreduzidoop = $oOps23ag->si135_codreduzidoop;
                $clops13->si135_tiporetencao = $oOps23ag->si135_tiporetencao;
                $clops13->si135_descricaoretencao = substr($oOps23ag->si135_descricaoretencao, 0, 50);
                $clops13->si135_vlretencao = $oOps23ag->si135_vlretencao;
                $clops13->si135_mes = $oOps23ag->si135_mes;
                $clops13->si135_reg10 = $oOps23ag->si135_reg10;
                $clops13->si135_instit = $oOps23ag->si135_instit;

                $clops13->incluir(null);
                if ($clops13->erro_status == 0) {
                  echo "<pre>";
                  print_r($clops13);
                  throw new Exception($clops13->erro_msg);
                }
              }


            }
          }

        } else {
          /*
           * CASO JA EXISTE UMA ORDEM DE PAGAMENTO INFORMADA NO ARRAY O SISTEMA VERIFICARA NOVAMENTE O LANCAMENTO CONTABIL DE
           * PAGAMENTO PARA INFORMAR COMO UM NOVO PAGAMENTO
           */

          $clops10 = new cl_ops102020();
          if ($oEmpPago->subunidade != '' && $oEmpPago->subunidade != 0) {
            $oEmpPago->codunidadesub .= str_pad($oEmpPago->subunidade, 3, "0", STR_PAD_LEFT);
          }

          /*
          * Verifica se o empenho existe na tabela dotacaorpsicom
          * Caso exista, busca os dados da dotação.
          * */
          $sSqlDotacaoRpSicom = "select * from dotacaorpsicom where si177_numemp = {$oEmpPago->e60_numemp}";
          $iFonteAlterada = '0';
          if (pg_num_rows(db_query($sSqlDotacaoRpSicom)) > 0) {
            $aDotacaoRpSicom = db_utils::getColectionByRecord(db_query($sSqlDotacaoRpSicom));
            $iFonteAlterada = str_pad($aDotacaoRpSicom[0]->si177_codfontrecursos, 3, "0", STR_PAD_LEFT);
            $clops10->si132_codorgao = str_pad($aDotacaoRpSicom[0]->si177_codorgaotce, 2, "0", STR_PAD_LEFT);
            $clops10->si132_codunidadesub = strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 5 && strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 8 ? "0" . $aDotacaoRpSicom[0]->si177_codunidadesub : $aDotacaoRpSicom[0]->si177_codunidadesub;
          } else {
            $clops10->si132_codorgao = $oEmpPago->codorgao;
            $clops10->si132_codunidadesub = $oEmpPago->codunidadesub;
          }
          $clops10->si132_tiporegistro = $oEmpPago->tiporesgistro;
          $clops10->si132_nroop = $oEmpPago->nroop;
          $clops10->si132_dtpagamento = $oEmpPago->dtpagamento;
          $clops10->si132_vlop = $oEmpPago->valor;
          $clops10->si132_especificacaoop = $oEmpPago->especificacaoop == '' ? 'SEM HISTORICO'
            : trim(preg_replace("/[^a-zA-Z0-9 ]/", "", substr(str_replace($what, $by, $oEmpPago->especificacaoop), 0, 500)));
          $clops10->si132_cpfresppgto = substr($oEmpPago->cpfresppgto, 0, 11);
          $clops10->si132_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
          $clops10->si132_instit = db_getsession("DB_instit");
          $clops10->retencao = 0;

          $clops10->incluir(null);

          if ($clops10->erro_status == 0) {
            throw new Exception($clops10->erro_msg);
          }


          $sSql11 = " SELECT tiporegistro, codreduzidoop, codunidadesub, nroop, tipopagamento, nroempenho, dtempenho, nroliquidacao, dtliquidacao,
                             codfontrecursos, sum(valorfonte) AS valorfonte, tipodocumentocredor, nrodocumento, codorgaoempop, codunidadeempop, subunidade
                      FROM
                          (SELECT 11 AS tiporegistro,
                                  c71_codlan||e50_codord AS codreduzidoop,
                                  lpad(o58_orgao,2,0)||lpad(o58_unidade,3,0) AS codunidadesub,
                                  c71_codlan||lpad(e50_codord,10,0) AS nroop,
                                  CASE
                                      WHEN substr(o56_elemento,2,2) = '46' THEN 2
                                      WHEN c71_coddoc = 35 THEN 3
                                      WHEN c71_coddoc = 37 THEN 4
                                      ELSE 1
                                  END AS tipopagamento,
                                  e60_codemp AS nroempenho,
                                  e60_emiss AS dtempenho,
                                  CASE
                                      WHEN date_part('year',e50_data) < 2015 THEN e71_codnota::varchar
                                      ELSE (rpad(e71_codnota::varchar,9,'0') || lpad(e71_codord::varchar,9,'0'))
                                  END AS nroliquidacao,
                                  e50_data AS dtliquidacao,
                                  o15_codtri AS codfontrecursos,
                                  c70_valor AS valorfonte,
                                  CASE
                                      WHEN length(forn.z01_cgccpf) = 11 THEN 1
                                      ELSE 2
                                  END AS tipodocumentocredor,
                                  forn.z01_cgccpf AS nrodocumento,
                                  ' '::char AS codorgaoempop,
                                  ' '::char AS codunidadeempop,
                                  e60_instit AS instituicao,
                                  o41_subunidade AS subunidade
                           FROM pagordem
                           JOIN pagordemele ON e53_codord = e50_codord
                           JOIN empempenho ON e50_numemp = e60_numemp
                           JOIN orcdotacao ON o58_anousu = e60_anousu AND e60_coddot = o58_coddot
                           JOIN orcunidade ON o58_anousu = o41_anousu AND o58_orgao = o41_orgao AND o58_unidade =o41_unidade
                           JOIN conlancamord ON c80_codord = e50_codord
                           JOIN conlancamdoc ON c71_codlan = c80_codlan
                           JOIN conlancam ON c70_codlan = c71_codlan
                           JOIN orcelemento ON o58_codele = o56_codele AND o58_anousu = o56_anousu
                           JOIN orctiporec ON o58_codigo = o15_codigo
                           JOIN cgm forn ON e60_numcgm = forn.z01_numcgm
                           JOIN pagordemnota ON e71_codord = e50_codord
                           LEFT JOIN infocomplementaresinstit ON si09_instit = e60_instit
                           WHERE c71_data BETWEEN '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'
                             AND c71_coddoc IN (5, 35, 37)
                             AND e50_codord = {$oEmpPago->ordem}
                             AND c71_codlan = {$oEmpPago->lancamento}
                           ORDER BY c71_codlan) AS pagamentos
                      GROUP BY tiporegistro, codreduzidoop, codunidadesub, nroop, tipopagamento, nroempenho, dtempenho, nroliquidacao,
                               dtliquidacao, codfontrecursos, tipodocumentocredor, nrodocumento, codorgaoempop, codunidadeempop, subunidade ";

          $rsPagOrd11 = db_query($sSql11);

          $reg11 = db_utils::fieldsMemory($rsPagOrd11, 0);

          if (pg_num_rows($rsPagOrd11) > 0) {

            $clops11 = new cl_ops112020();
            if ($reg11->subunidade != '' && $reg11->subunidade != 0) {
              $reg11->codunidadesub .= str_pad($reg11->subunidade, 3, "0", STR_PAD_LEFT);
            }
            $clops11->si133_tiporegistro = $reg11->tiporegistro;
            $clops11->si133_codreduzidoop = $reg11->codreduzidoop;
            $clops11->si133_codunidadesub = $clops10->si132_codunidadesub;
            $clops11->si133_nroop = $oEmpPago->nroop;
            $clops11->si133_dtpagamento = $oEmpPago->dtpagamento;
            $clops11->si133_tipopagamento = $reg11->tipopagamento;
            $clops11->si133_nroempenho = $reg11->nroempenho;
            $clops11->si133_dtempenho = $reg11->dtempenho;
              if($reg11->tipopagamento == 3){
                  $clops11->si133_nroliquidacao = "";
                  $clops11->si133_dtliquidacao = "";
              }else{
                  $clops11->si133_nroliquidacao = $reg11->nroliquidacao;
                  $clops11->si133_dtliquidacao = $reg11->dtliquidacao;
              }
            $clops11->si133_codfontrecursos = $iFonteAlterada != '0' ? $iFonteAlterada : $reg11->codfontrecursos;
            if (in_array($clops11->si133_codfontrecursos, $this->aFontesEncerradas)) {
                $clops11->si133_codfontrecursos = substr($clops11->si133_codfontrecursos, 0, 1).'59';
            }
            $clops11->si133_valorfonte = $oEmpPago->valor;
            $clops11->si133_tipodocumentocredor = $reg11->tipodocumentocredor;
            $clops11->si133_nrodocumento = $reg11->nrodocumento;
            $clops11->si133_codorgaoempop = $reg11->codorgaoempop;
            $clops11->si133_codunidadeempop = $reg11->codunidadeempop;
            $clops11->si133_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clops11->si133_reg10 = $clops10->si132_sequencial;
            $clops11->si133_instit = db_getsession("DB_instit");


            $clops11->incluir(null);
            if ($clops11->erro_status == 0) {
              throw new Exception($clops11->erro_msg . " 11 ");
            }
          }

          $sSql12 = " SELECT 12 AS tiporegistro,
                             e82_codord AS codreduzidoop,
                             CASE
                                 WHEN e96_codigo = 1 THEN 5
                                 WHEN e96_codigo = 2 THEN 1
                                 ELSE 99
                             END AS tipodocumentoop,
                             CASE
                                 WHEN e96_codigo = 2 THEN e86_cheque
                                 ELSE NULL
                             END AS nrodocumento,
                             CASE
                                 WHEN e96_codigo IN (2, 3, 4) THEN c61_reduz
                                 ELSE NULL
                             END AS codctb,
                             CASE
                                 WHEN e96_codigo IN (2, 3, 4) THEN o15_codtri
                                 ELSE NULL
                             END AS codfontectb,
                             e50_data AS dtemissao,
                             k12_valor AS vldocumento,
                             c23_conlancam AS codlan
                      FROM empagemov
                      INNER JOIN empage ON empage.e80_codage = empagemov.e81_codage
                      INNER JOIN empord ON empord.e82_codmov = empagemov.e81_codmov
                      INNER JOIN empempenho ON empempenho.e60_numemp = empagemov.e81_numemp
                      LEFT JOIN empagemovforma ON empagemovforma.e97_codmov = empagemov.e81_codmov
                      LEFT JOIN empageforma ON empageforma.e96_codigo = empagemovforma.e97_codforma
                      LEFT JOIN empagepag ON empagepag.e85_codmov = empagemov.e81_codmov
                      LEFT JOIN empagetipo ON empagetipo.e83_codtipo = empagepag.e85_codtipo
                      LEFT JOIN empageconf ON empageconf.e86_codmov = empagemov.e81_codmov
                      LEFT JOIN empageconfgera ON empageconfgera.e90_codmov = empagemov.e81_codmov AND empageconfgera.e90_cancelado = 'f'
                      LEFT JOIN saltes ON saltes.k13_conta = empagetipo.e83_conta
                      LEFT JOIN empagegera ON empagegera.e87_codgera = empageconfgera.e90_codgera
                      LEFT JOIN empagedadosret ON empagedadosret.e75_codgera = empagegera.e87_codgera
                      LEFT JOIN empagedadosretmov ON (empagedadosretmov.e76_codret, empagedadosretmov.e76_codmov) = (empagedadosret.e75_codret, empagemov.e81_codmov)
                      LEFT JOIN empagedadosretmovocorrencia ON (empagedadosretmovocorrencia.e02_empagedadosretmov, empagedadosretmovocorrencia.e02_empagedadosret) = (empagedadosretmov.e76_codmov, empagedadosretmov.e76_codret)
                      LEFT JOIN errobanco ON errobanco.e92_sequencia = empagedadosretmovocorrencia.e02_errobanco
                      LEFT JOIN empageconfche ON (empageconfche.e91_codmov, empageconfche.e91_ativo) = (empagemov.e81_codmov, TRUE)
                      LEFT JOIN corconf ON (corconf.k12_codmov, corconf.k12_ativo) = (empageconfche.e91_codcheque, TRUE)
                      LEFT JOIN corempagemov ON corempagemov.k12_codmov = empagemov.e81_codmov
                      LEFT JOIN pagordemele ON e53_codord = empord.e82_codord
                      LEFT JOIN empagenotasordem ON e43_empagemov = e81_codmov
                      LEFT JOIN coremp ON (coremp.k12_id, coremp.k12_data, coremp.k12_autent) = (corempagemov.k12_id, corempagemov.k12_data, corempagemov.k12_autent)
                      JOIN pagordem ON (e50_numemp, e50_codord) = (k12_empen, k12_codord)
                      JOIN corrente ON (coremp.k12_autent, coremp.k12_data, coremp.k12_id) = (corrente.k12_autent, corrente.k12_data, corrente.k12_id) AND corrente.k12_estorn != TRUE
                      JOIN conplanoreduz ON c61_reduz = k12_conta AND c61_anousu = " . db_getsession("DB_anousu") . "
                      JOIN conplano ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu
                      LEFT JOIN conplanoconta ON c63_codcon = c60_codcon AND c60_anousu = c63_anousu
                      JOIN corgrupocorrente cg ON cg.k105_autent = corrente.k12_autent
                      JOIN orcdotacao ON (o58_coddot, o58_anousu) = (e60_coddot, e60_anousu)
                      JOIN orctiporec ON o58_codigo = o15_codigo AND cg.k105_data = corrente.k12_data AND cg.k105_id = corrente.k12_id
                      JOIN conlancamcorgrupocorrente ON c23_corgrupocorrente = cg.k105_sequencial AND c23_conlancam = {$oEmpPago->lancamento}
                      WHERE k105_corgrupotipo != 2
                        AND e80_instit = " . db_getsession("DB_instit") . "
                        AND k12_codord = {$oEmpPago->ordem}
                        AND e81_cancelado IS NULL";

          $rsPagOrd12 = db_query($sSql12) or die($sSql12);

          $reg12 = db_utils::fieldsMemory($rsPagOrd12, 0);

          /**
           * NOVA VERIFICAÇÃO RETENÇÃO PARA A ORDEM, PARA QUE O VALOR DA RETENÇÃO SEJA SUBTRAIDO DO VALOR DO LANCAMENTO.
           */
          $sqlReten = "SELECT sum(e23_valorretencao) AS descontar
                       FROM retencaopagordem
                       JOIN retencaoreceitas ON e23_retencaopagordem = e20_sequencial
                       JOIN retencaotiporec ON e23_retencaotiporec = e21_sequencial
                       WHERE e23_recolhido = TRUE
                         AND e20_pagordem = {$oEmpPago->ordem}
                         AND e23_dtcalculo BETWEEN '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'";
          $rsReteIs = db_query($sqlReten);

          if ($aInformado[$sHash]->retencao == 0) {
            if (pg_num_rows($rsReteIs) > 0) {

              $retencao2 = $aInformado[$sHash]->retencao;


              $nVolorOp = $oEmpPago->valor - db_utils::fieldsMemory($rsReteIs, 0)->descontar;
              $saldopag = db_utils::fieldsMemory($rsReteIs, 0)->descontar;
              $aInformado[$sHash]->retencao = 1;
              if ($nVolorOp < 0) {
                $nVolorOp = $oEmpPago->valor;
                $aInformado[$sHash]->retencao = 0;
              }


            } else {
              $nVolorOp = $oEmpPago->valor;
              $saldopag = $nVolorOp;
            }
          } else {
            $retencao2 = 1;
            $aInformado[$sHash]->retencao = 0;
            $nVolorOp = $oEmpPago->valor;
          }

          if (pg_num_rows($rsPagOrd12) > 0 && $reg12->codctb != '') {

            $clops12 = new cl_ops122020();


            $sSqlContaPagFont = "select * from (select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102020 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202020 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu") . "
                              and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $sSqlContaPagFont .= " UNION  select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102019 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202019 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION  select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102018 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202018 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION  select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102017 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202017 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION  select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102016 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202016 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102015 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202015 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102014 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202014 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu") . ") as x order by contapag asc";
            $rsResultContaPag = db_query($sSqlContaPagFont) or die($sSqlContaPagFont." teste3");

            $ContaPag = db_utils::fieldsMemory($rsResultContaPag)->contapag;

            $FontContaPag = db_utils::fieldsMemory($rsResultContaPag)->fonte;

            $clops12->si134_tiporegistro = $reg12->tiporegistro;
            $clops12->si134_codreduzidoop = $reg11->codreduzidoop;
            $clops12->si134_tipodocumentoop = $reg12->tipodocumentoop;
            $clops12->si134_nrodocumento = $reg12->nrodocumento;
            $clops12->si134_codctb = $ContaPag;
            $clops12->si134_codfontectb = $reg11->codfontrecursos;
            if (in_array($clops12->si134_codfontectb, $this->aFontesEncerradas)) {
                $clops12->si134_codfontectb = substr($clops12->si134_codfontectb, 0, 1).'59';
            }
            $clops12->si134_desctipodocumentoop = $reg12->tipodocumentoop == "99" ? "TED" : ' ';
            $clops12->si134_dtemissao = $reg12->dtemissao;
            $clops12->si134_vldocumento = $nVolorOp;
            $clops12->si134_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clops12->si134_reg10 = $clops10->si132_sequencial;
            $clops12->si134_instit = db_getsession("DB_instit");
          } else {

            $sSqlContaPagFont = "select * from (select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102014 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202014 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= "UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102015 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202015 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102016 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202016 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102017 on
                      si95_banco = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202017 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102018 on
                      si95_banco = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202018 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102019 on
                      si95_banco = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202019 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102020 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202020 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu") . " and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'] . ") as x order by contapag desc";
            $rsResultContaPag = db_query($sSqlContaPagFont) or die($sSqlContaPagFont." teste4");

            $ContaPag2 = db_utils::fieldsMemory($rsResultContaPag)->contapag;

            $FontContaPag2 = db_utils::fieldsMemory($rsResultContaPag)->fonte;

            $clops12 = new cl_ops122020();


            $clops12->si134_tiporegistro = 12;
            $clops12->si134_codreduzidoop = $reg11->codreduzidoop;
            $clops12->si134_tipodocumentoop = 99;
            $clops12->si134_nrodocumento = 0;
            $clops12->si134_codctb = $ContaPag2;
            $clops12->si134_codfontectb = $reg11->codfontrecursos;
            if (in_array($clops12->si134_codfontectb, $this->aFontesEncerradas)) {
                $clops12->si134_codfontectb = substr($clops12->si134_codfontectb, 0, 1).'59';
            }
            $clops12->si134_desctipodocumentoop = "TED";
            $clops12->si134_dtemissao = $oEmpPago->dtpagamento;
            $clops12->si134_vldocumento = $nVolorOp;
            $clops12->si134_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clops12->si134_reg10 = $clops10->si132_sequencial;
            $clops12->si134_instit = db_getsession("DB_instit");
          }

          $clops12->incluir(null);
          if ($clops12->erro_status == 0) {
            throw new Exception($clops12->erro_msg);
          }

          if ($saldopag >= 0 && $retencao2 == 0) {

            $sSql13 = "SELECT 13 AS tiporegistro,
                              e20_pagordem AS codreduzidoop,
                              CASE
                                  WHEN substr(k02_estorc,1,9) IN ('411130311', '411130341', '411180231') THEN 1
                                  ELSE c60_tipolancamento
                              END AS c60_tipolancamento,
                              CASE
                                  WHEN substr(k02_estorc,1,9) = '411180231' THEN 4
                                  WHEN substr(k02_estorc,1,9) IN ('411130311', '411130341') THEN 3
                                  ELSE c60_subtipolancamento
                              END AS c60_subtipolancamento,
                              CASE 
                                 WHEN k02_reduz IS NULL THEN k02_codrec
                                 ELSE k02_reduz
                              END AS k02_reduz,
                              CASE
                                  WHEN e21_retencaotipocalc = 5 OR substr(k02_estorc,1,9)::integer = 411180231 THEN 4
                                  WHEN e21_retencaotipocalc IN (3, 4, 7) THEN 1
                                  WHEN e21_retencaotipocalc IN (1, 2) OR substr(k02_estorc,1,9)::integer IN (411130311, 411130341) THEN 3
                                  ELSE lpad(k02_reduz,4,0)::integer
                              END AS tiporetencao,
                              CASE
                                  WHEN e21_retencaotipocalc NOT IN (1, 2, 3, 4, 5, 7) THEN e21_descricao
                                  ELSE NULL
                              END AS descricaoretencao,
                              e23_valorretencao AS vlrentencao
                       FROM retencaopagordem
                       JOIN retencaoreceitas ON e23_retencaopagordem = e20_sequencial
                       JOIN retencaotiporec ON e23_retencaotiporec = e21_sequencial
                       LEFT JOIN tabrec tr ON tr.k02_codigo = e21_receita
                       LEFT JOIN tabplan tp ON tp.k02_codigo = tr.k02_codigo AND tp.k02_anousu = " . db_getsession("DB_anousu") . "
                       LEFT JOIN conplano ON (tp.k02_anousu, tp.k02_estpla) = (conplano.c60_anousu, conplano.c60_estrut)
                       LEFT JOIN taborc ON tr.k02_codigo = taborc.k02_codigo AND taborc.k02_anousu = " . db_getsession("DB_anousu") . "
                       WHERE e23_recolhido = TRUE
                         AND e20_pagordem = {$oEmpPago->ordem}
                         AND e23_dtcalculo BETWEEN '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'";

            $rsPagOrd13 = db_query($sSql13);

            if (pg_num_rows($rsPagOrd13) > 0) {

              $aOps23 = array();
              $subTipo = array(1, 2, 3, 4);
              for ($iCont13 = 0; $iCont13 < pg_num_rows($rsPagOrd13); $iCont13++) {

                $reg13 = db_utils::fieldsMemory($rsPagOrd13, $iCont13);
                $sHash = $reg13->tiporetencao . $reg11->e50_codord;
                if ($reg13->c60_tipolancamento == 1){
                  $sHash .= $reg13->c60_tipolancamento.$reg13->c60_subtipolancamento;
                }

                if (!isset($aOps23[$sHash])) {
                  $clops13 = new stdClass();

                  $clops13->si135_tiporegistro = $reg13->tiporegistro;
                  $clops13->si135_codreduzidoop = $reg11->codreduzidoop;

                  if ($reg13->c60_tipolancamento == 1){
                    $clops13->si135_tiporetencao = $reg13->c60_subtipolancamento;
                  } elseif ($reg13->c60_tipolancamento != 1 && !empty($reg13->c60_subtipolancamento)) {
                    $clops13->si135_tiporetencao = substr($reg13->c60_tipolancamento, 0, 2).substr($reg13->c60_subtipolancamento,-2);
                  } else {
                    $clops13->si135_tiporetencao = $reg13->tiporetencao;
                  }

                  if ($reg13->c60_tipolancamento == 1 && in_array($reg13->c60_subtipolancamento, $subTipo)){
                    $clops13->si135_descricaoretencao = " ";
                  } else {
                    $clops13->si135_descricaoretencao = substr($reg13->descricaoretencao, 0, 50);
                  }

                  $clops13->si135_vlretencao = $reg13->vlrentencao;
                  $clops13->si135_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                  $clops13->si135_reg10 = $clops10->si132_sequencial;
                  $clops13->si135_instit = db_getsession("DB_instit");

                  $aOps23[$sHash] = $clops13;
                } else {
                  $aOps23[$sHash]->si135_vlretencao += $reg13->vlrentencao;
                }
              }

              foreach ($aOps23 as $oOps23ag) {

                $clops13 = new cl_ops132020();

                $clops13->si135_tiporegistro = $oOps23ag->si135_tiporegistro;
                $clops13->si135_codreduzidoop = $oOps23ag->si135_codreduzidoop;
                $clops13->si135_tiporetencao = $oOps23ag->si135_tiporetencao;
                $clops13->si135_descricaoretencao = substr($oOps23ag->si135_descricaoretencao, 0, 50);
                $clops13->si135_vlretencao = $oOps23ag->si135_vlretencao;
                $clops13->si135_mes = $oOps23ag->si135_mes;
                $clops13->si135_reg10 = $oOps23ag->si135_reg10;
                $clops13->si135_instit = $oOps23ag->si135_instit;

                $clops13->incluir(null);
                if ($clops13->erro_status == 0) {
                  echo "<pre>";
                  print_r($clops13);
                  throw new Exception($clops13->erro_msg);
                }
              }


            }
          }

        }

      }
    }
    db_fim_transacao();
    $oGerarOPS = new GerarOPS();
    $oGerarOPS->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];;
    $oGerarOPS->gerarDados();
  }
}
