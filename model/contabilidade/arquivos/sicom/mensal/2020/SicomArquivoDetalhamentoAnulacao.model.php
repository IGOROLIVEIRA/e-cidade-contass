<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_alq102020_classe.php");
require_once("classes/db_alq112020_classe.php");
require_once("classes/db_alq122020_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarALQ.model.php");

/**
 * Anulacao da Liquidacao Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoDetalhamentoAnulacao extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout = 170;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'ALQ';

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
   *esse metodo sera implementado criando um array com os campos que serao necessarios
   *para o escritor gerar o arquivo CSV
   */
  public function getCampos()
  {

    $aElementos[10] = array(
      "tipoRegistro",
      "codReduzido",
      "codOrgao",
      "codUnidadeSub",
      "nroEmpenho",
      "dtEmpenho",
      "dtLiquidacao",
      "nroLiquidacao",
      "dtAnulacaoLiq",
      "nroLiquidacaoANL",
      "tpLiquidacao",
      "vlAnulado"
    );
    $aElementos[11] = array(
      "tipoRegistro",
      "codReduzido",
      "codFontRecursos",
      "valorAnuladoFonte"
    );
    $aElementos[12] = array(
      "tipoRegistro",
      "codReduzido",
      "mesCompetencia",
      "exercicioCompetencia",
      "vlAnuladoDspExerAnt"
    );

    return $aElementos;
  }

  /**
   * Contratos mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {

    $sSqlUnidade = "select * from infocomplementares where
  	si08_anousu = " . db_getsession("DB_anousu") . " and si08_instit = " . db_getsession("DB_instit");

    $rsResultUnidade = db_query($sSqlUnidade);
    $sTrataCodUnidade = db_utils::fieldsMemory($rsResultUnidade, 0)->si08_tratacodunidade;

   $sSql = "SELECT e50_data,
                   CASE
                       WHEN date_part('year',e50_data) < 2015 THEN e71_codnota::varchar
                       ELSE (rpad(e71_codnota::varchar,7,'0') ||'0'|| lpad(e71_codord::varchar,7,'0'))
                   END AS codreduzido,
                   CASE
                       WHEN date_part('year',e50_data) < 2015 THEN e71_codnota::varchar
                       ELSE (rpad(e71_codnota::varchar,9,'0') || lpad(e71_codord::varchar,9,'0'))
                   END AS nroliquidacao,
                   c80_data,
                   orctiporec.o15_codtri,
                   e60_codemp,
                   e60_emiss,
                   e60_anousu,
                   e60_numemp,
                   e60_datasentenca,
                   e50_compdesp,
                   lpad((CASE
                             WHEN o40_codtri = '0'
                                  OR NULL THEN o40_orgao::varchar
                             ELSE o40_codtri
                         END),2,0) AS o58_orgao,
                   lpad((CASE
                             WHEN o41_codtri = '0'
                                  OR NULL THEN o41_unidade::varchar
                             ELSE o41_codtri
                         END),3,0) AS o58_unidade,
                   o41_subunidade,
                   e60_codcom,
                   sum(c70_valor) AS c70_valor,
                   c70_data,
                   c53_tipo,
                   c70_data,
                   si09_codorgaotce ,
                   o56_elemento
            FROM empempenho
            INNER JOIN conlancamemp ON c75_numemp = empempenho.e60_numemp
            INNER JOIN conlancam ON c70_codlan = c75_codlan
            LEFT JOIN conlancamnota ON c66_codlan = c70_codlan
            INNER JOIN conlancamdoc ON c71_codlan = c70_codlan
            INNER JOIN conhistdoc ON c53_coddoc = c71_coddoc
            INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
            INNER JOIN db_config ON db_config.codigo = empempenho.e60_instit
            INNER JOIN orcdotacao ON orcdotacao.o58_anousu = empempenho.e60_anousu AND orcdotacao.o58_coddot = empempenho.e60_coddot AND orcdotacao.o58_instit = empempenho.e60_instit
            INNER JOIN emptipo ON emptipo.e41_codtipo = empempenho.e60_codtipo
            INNER JOIN db_config AS a ON a.codigo = orcdotacao.o58_instit
            INNER JOIN orctiporec ON orctiporec.o15_codigo = orcdotacao.o58_codigo
            INNER JOIN orcfuncao ON orcfuncao.o52_funcao = orcdotacao.o58_funcao
            INNER JOIN orcsubfuncao ON orcsubfuncao.o53_subfuncao = orcdotacao.o58_subfuncao
            INNER JOIN orcprograma ON orcprograma.o54_anousu = orcdotacao.o58_anousu AND orcprograma.o54_programa = orcdotacao.o58_programa
            INNER JOIN orcelemento ON orcelemento.o56_codele = orcdotacao.o58_codele AND orcdotacao.o58_anousu = orcelemento.o56_anousu
            INNER JOIN orcprojativ ON orcprojativ.o55_anousu = orcdotacao.o58_anousu AND orcprojativ.o55_projativ = orcdotacao.o58_projativ
            INNER JOIN orcorgao ON orcorgao.o40_anousu = orcdotacao.o58_anousu AND orcorgao.o40_orgao = orcdotacao.o58_orgao
            INNER JOIN orcunidade ON orcunidade.o41_anousu = orcdotacao.o58_anousu AND orcunidade.o41_orgao = orcdotacao.o58_orgao AND orcunidade.o41_unidade = orcdotacao.o58_unidade
            LEFT JOIN empemphist ON empemphist.e63_numemp = empempenho.e60_numemp
            LEFT JOIN emphist ON emphist.e40_codhist = empemphist.e63_codhist
            INNER JOIN pctipocompra ON pctipocompra.pc50_codcom = empempenho.e60_codcom
            LEFT JOIN empresto ON e60_numemp = e91_numemp AND e60_anousu = e91_anousu
            JOIN conlancamord ON c80_codlan = c75_codlan
            JOIN pagordemnota ON e71_codord = c80_codord
            JOIN pagordem ON e71_codord = e50_codord
            LEFT JOIN infocomplementaresinstit ON o58_instit = si09_instit
            WHERE c53_tipo IN (21)
                AND c70_data BETWEEN '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'
                AND e60_instit IN (" . db_getsession('DB_instit') . ")
            GROUP BY e60_numemp, e60_resumo, e60_destin, e60_codemp, e60_emiss, e60_numcgm, z01_nome, z01_cgccpf, z01_munic, e60_vlremp, e60_vlranu, e60_vlrliq, e63_codhist, e40_descr, e60_vlrpag, e60_anousu, 
                     e60_coddot, o58_coddot, o58_orgao, o40_orgao, o40_descr, o58_unidade, o41_descr, o15_codigo, o15_descr, e60_codcom, pc50_descr, c70_data, c70_codlan, c53_tipo, c53_descr, e91_numemp, e71_codnota,
                     c80_data, e50_data, si09_codorgaotce, o41_subunidade, pagordemnota.e71_codord , o40_codtri, orcorgao.o40_orgao, orcunidade.o41_codtri, orcunidade.o41_unidade, o56_elemento, e50_compdesp
            ORDER BY e60_numemp, c70_codlan";
    //    echo $sSql."<br>";
    $rsDetalhamentos = db_query($sSql);
    //    db_criatabela($rsDetalhamentos);echo pg_last_error();

    $clalq10 = new cl_alq102020();
    $clalq11 = new cl_alq112020();
    $clalq12 = new cl_alq122020();

    /*
     * SE JA FOI GERADO ESTA ROTINA UMA VEZ O SISTEMA APAGA OS DADOS DO BANCO E GERA NOVAMENTE
     */
    db_inicio_transacao();
    $result = $clalq10->sql_record($clalq10->sql_query(null, "*", null, "si121_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'])
      . " and si121_instit = " . db_getsession("DB_instit"));
    if (pg_num_rows($result) > 0) {

      $clalq12->excluir(null, "si123_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
        . " and si123_instit = " . db_getsession("DB_instit"));
      $clalq11->excluir(null, "si122_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
        . " and si122_instit = " . db_getsession("DB_instit"));
      $clalq10->excluir(null, "si121_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
        . " and si121_instit = " . db_getsession("DB_instit"));

      if ($clalq10->erro_status == 0) {
        throw new Exception($clalq10->erro_msg);
      }
    }
    db_fim_transacao();
    db_inicio_transacao();
    /**
     * percorrer registros de detalhamento anulação retornados do sql acima
     */
    $aDadosAgrupados = array();
    for ($iCont = 0; $iCont < pg_num_rows($rsDetalhamentos); $iCont++) {

      $oDetalhamento = db_utils::fieldsMemory($rsDetalhamentos, $iCont);

      if ($oDetalhamento->e60_anousu == db_getsession("DB_anousu")) {
        $tpLiquidacao = 1;
      } else {
        $tpLiquidacao = 2;
      }

      if (($sTrataCodUnidade == "2") && ($oDetalhamento->o41_subunidade != '' && $oDetalhamento->o41_subunidade != 0)) {

        $sCodUnidade = str_pad($oDetalhamento->o58_orgao, 2, "0", STR_PAD_LEFT);
        $sCodUnidade .= str_pad($oDetalhamento->o58_unidade, 3, "0", STR_PAD_LEFT);
        $sCodUnidade .= str_pad($oDetalhamento->o41_subunidade, 3, "0", STR_PAD_LEFT);

      } else {

        $sCodUnidade = str_pad($oDetalhamento->o58_orgao, 2, "0", STR_PAD_LEFT);
        $sCodUnidade .= str_pad($oDetalhamento->o58_unidade, 3, "0", STR_PAD_LEFT);

      }

      $sHash = substr($oDetalhamento->nroliquidacao, 0, 19);

      if (!isset($aDadosAgrupados[$sHash])) {

        $oDadosDetalhamento = new stdClass();


        /*
         * Verifica se o empenho existe na tabela dotacaorpsicom
         * Caso exista, busca os dados da dotação.
         * */
        $sSqlDotacaoRpSicom = "select * from dotacaorpsicom where si177_numemp = {$oDetalhamento->e60_numemp}";
        $iFonteAlterada = '0';
        if (pg_num_rows(db_query($sSqlDotacaoRpSicom)) > 0) {
          $aDotacaoRpSicom = db_utils::getColectionByRecord(db_query($sSqlDotacaoRpSicom));
          $iFonteAlterada = str_pad($aDotacaoRpSicom[0]->si177_codfontrecursos, 3, "0", STR_PAD_LEFT);
          $oDadosDetalhamento->si121_codorgao = str_pad($aDotacaoRpSicom[0]->si177_codorgaotce, 2, "0", STR_PAD_LEFT);
          $oDadosDetalhamento->si121_codunidadesub = strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 5 && strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 8 ? "0" . $aDotacaoRpSicom[0]->si177_codunidadesub : $aDotacaoRpSicom[0]->si177_codunidadesub;
          $iFonteAlterada = str_pad($aDotacaoRpSicom[0]->si177_codfontrecursos, 3, "0", STR_PAD_LEFT);
        } else {
          $oDadosDetalhamento->si121_codorgao = $oDetalhamento->si09_codorgaotce;
          $oDadosDetalhamento->si121_codunidadesub = $sCodUnidade;
        }

        $oDadosDetalhamento->si121_tiporegistro = 10;
        $oDadosDetalhamento->si121_codreduzido = substr($oDetalhamento->codreduzido, 0, 15);
        $oDadosDetalhamento->si121_codorgao = $oDetalhamento->si09_codorgaotce;
        $oDadosDetalhamento->si121_codunidadesub = $sCodUnidade;
        $oDadosDetalhamento->si121_nroempenho = substr($oDetalhamento->e60_codemp, 0, 22);
        $oDadosDetalhamento->si121_dtempenho = $oDetalhamento->e60_emiss;
        $oDadosDetalhamento->si121_dtliquidacao = $oDetalhamento->e50_data;
        $oDadosDetalhamento->si121_nroliquidacao = substr($oDetalhamento->nroliquidacao, 0, 19);
        $oDadosDetalhamento->si121_dtanulacaoliq = $oDetalhamento->c70_data;
        $oDadosDetalhamento->si121_nroliquidacaoanl = substr($oDetalhamento->nroliquidacao, 0, 19);
        $oDadosDetalhamento->si121_tpliquidacao = $tpLiquidacao;
        $oDadosDetalhamento->si121_justificativaanulacao = 'ESTORNO DE LIQUIDACAO';
        $oDadosDetalhamento->si121_vlanulado = $oDetalhamento->c70_valor;
        $oDadosDetalhamento->si121_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oDadosDetalhamento->si121_instit = db_getsession("DB_instit");
        $oDadosDetalhamento->o56_elemento = $oDetalhamento->o56_elemento;
        $oDadosDetalhamento->e50_compdesp = $oDetalhamento->e50_compdesp;
        $oDadosDetalhamento->e60_datasentenca = $oDetalhamento->e60_datasentenca;

        $aDadosAgrupados[$sHash] = $oDadosDetalhamento;

        $oDadosDetalhamentoFonte = new stdClass();

        $oDadosDetalhamentoFonte->si122_tiporegistro = 11;
        $oDadosDetalhamentoFonte->si122_codreduzido = substr($oDetalhamento->codreduzido, 0, 15);
        $oDadosDetalhamentoFonte->si122_codfontrecursos = $iFonteAlterada != '0' ? $iFonteAlterada : str_pad($oDetalhamento->o15_codtri, 3, "0", STR_PAD_LEFT);
        $oDadosDetalhamentoFonte->si122_valoranuladofonte = $oDetalhamento->c70_valor;
        $oDadosDetalhamentoFonte->si122_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oDadosDetalhamentoFonte->si122_instit = db_getsession("DB_instit");

        $aDadosAgrupados[$sHash]->Reg11 = $oDadosDetalhamentoFonte;

      } else {

        $aDadosAgrupados[$sHash]->si121_vlanulado += $oDetalhamento->c70_valor;
        $aDadosAgrupados[$sHash]->Reg11->si122_valoranuladofonte += $oDetalhamento->c70_valor;

      }

    }

    foreach ($aDadosAgrupados as $oDadosAgrupados) {

      $oDados10 = new cl_alq102020();

      $oDados10->si121_tiporegistro = 10;
      $oDados10->si121_codreduzido = $oDadosAgrupados->si121_codreduzido;
      $oDados10->si121_codorgao = $oDadosAgrupados->si121_codorgao;
      $oDados10->si121_codunidadesub = $oDadosAgrupados->si121_codunidadesub;
      $oDados10->si121_nroempenho = $oDadosAgrupados->si121_nroempenho;
      $oDados10->si121_dtempenho = $oDadosAgrupados->si121_dtempenho;
      $oDados10->si121_dtliquidacao = $oDadosAgrupados->si121_dtliquidacao;
      $oDados10->si121_nroliquidacao = $oDadosAgrupados->si121_nroliquidacao;
      $oDados10->si121_dtanulacaoliq = $oDadosAgrupados->si121_dtanulacaoliq;
      $oDados10->si121_nroliquidacaoanl = $oDadosAgrupados->si121_nroliquidacaoanl;
      $oDados10->si121_tpliquidacao = $oDadosAgrupados->si121_tpliquidacao;
      $oDados10->si121_justificativaanulacao = $oDadosAgrupados->si121_justificativaanulacao;
      $oDados10->si121_vlanulado = $oDadosAgrupados->si121_vlanulado;
      $oDados10->si121_mes = $oDadosAgrupados->si121_mes;
      $oDados10->si121_instit = $oDadosAgrupados->si121_instit;

      $oDados10->incluir(null);
      if ($oDados10->erro_status == 0) {
        throw new Exception($oDados10->erro_msg);
      }

      $oDados11 = new cl_alq112020();

      $oDados11->si122_tiporegistro = 11;
      $oDados11->si122_codreduzido = $oDadosAgrupados->Reg11->si122_codreduzido;
      $oDados11->si122_codfontrecursos = $oDadosAgrupados->Reg11->si122_codfontrecursos;
      if (in_array($oDados11->si122_codfontrecursos, $this->aFontesEncerradas)) {
          $oDados11->si122_codfontrecursos = substr($oDados11->si122_codfontrecursos, 0, 1).'59';
      }
      $oDados11->si122_valoranuladofonte = $oDadosAgrupados->Reg11->si122_valoranuladofonte;
      $oDados11->si122_mes = $oDadosAgrupados->Reg11->si122_mes;
      $oDados11->si122_reg10 = $oDados10->si121_sequencial;
      $oDados11->si122_instit = $oDadosAgrupados->Reg11->si122_instit;

      $oDados11->incluir(null);
      if ($oDados11->erro_status == 0) {
        throw new Exception($oDados11->erro_msg);
      }

      $aMatrizCompDesp = array('3319092', '3319192', '3319592', '3319692');
      $aMatrizDespSentenca = array('3319091', '3319191','3319591','3319691');

      if (in_array(substr($oDadosAgrupados->o56_elemento, 0, 7), $aMatrizCompDesp)) {
          
        $oDados12 = new cl_alq122020();
        $oDados12->si123_tiporegistro = 12;
        $oDados12->si123_reg10 = $oDados10->si121_sequencial;
        $oDados12->si123_codreduzido = $oDados10->si121_codreduzido;
        $oDados12->si123_mescompetencia = substr($oDadosAgrupados->e50_compdesp, 5, 2);
        $oDados12->si123_exerciciocompetencia = substr($oDadosAgrupados->e50_compdesp, 0, 4);
        $oDados12->si123_vlanuladodspexerant = $oDados10->si121_vlanulado;
        $oDados12->si123_mes = $oDados10->si121_mes;
        $oDados12->si123_instit = db_getsession("DB_instit");
        $oDados12->incluir(null);
        if ($oDados12->erro_status == 0) {
          throw new Exception($oDados12->erro_msg);
        }

      } elseif (in_array(substr($oDadosAgrupados->o56_elemento, 0, 7), $aMatrizDespSentenca)) {
        
        $oDados12 = new cl_alq122020();
        $oDados12->si123_tiporegistro = 12;
        $oDados12->si123_reg10 = $oDados10->si121_sequencial;
        $oDados12->si123_codreduzido = $oDados10->si121_codreduzido;
        $oDados12->si123_mescompetencia = substr($oDadosAgrupados->e60_datasentenca, 5, 2);
        $oDados12->si123_exerciciocompetencia = substr($oDadosAgrupados->e60_datasentenca, 0, 4);
        $oDados12->si123_vlanuladodspexerant = $oDados10->si121_vlanulado;
        $oDados12->si123_mes = $oDados10->si121_mes;
        $oDados12->si123_instit = db_getsession("DB_instit");
        $oDados12->incluir(null);
        if ($oDados12->erro_status == 0) {
          throw new Exception($oDados12->erro_msg);
        }
      }

    }

    db_fim_transacao();

    $oGerarALQ = new GerarALQ();
    $oGerarALQ->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarALQ->gerarDados();
  }

}
