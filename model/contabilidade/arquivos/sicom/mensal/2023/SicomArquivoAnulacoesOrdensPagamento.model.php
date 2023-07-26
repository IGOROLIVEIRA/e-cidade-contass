<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_aop102023_classe.php");
require_once("classes/db_aop112023_classe.php");
require_once("classes/db_aop122023_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2023/GerarAOP.model.php");
require_once("model/orcamento/ControleOrcamentario.model.php");
require_once("model/orcamento/DeParaRecurso.model.php");

/*
ini_set('display_errors', 1);
error_reporting(E_ALL);
*/
/**
 * Anulaes das Ordens de Pagamento Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoAnulacoesOrdensPagamento extends SicomArquivoBase implements iPadArquivoBaseCSV
{
    /**
     *
     * Codigo do layout. (db_layouttxt.db50_codigo)
     * @var Integer
     */
    protected $iCodigoLayout = 173;

    /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'AOP';

    /**
     * @var array Fontes encerradas em 2023
     */
    protected $aFontesEncerradas = array('148', '149', '150', '151', '152', '248', '249', '250', '251', '252');

    private $oDeParaRecurso;

    /**
     *
     * Construtor da classe
     */
    public function __construct()
    {
        $this->oDeParaRecurso = new DeParaRecurso();
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
            "codReduzido",
            "codOrgao",
            "codUnidadeSub",
            "nroOP",
            "dtPagamento",
            "nroAnulacaoOP",
            "dtAnulacaoOP",
            "vlAnulacaoOP"
        );
        $aElementos[11] = array(
            "tipoRegistro",
            "codReduzido",
            "tipoPagamento",
            "nroEmpenho",
            "dtEmpenho",
            "nroLiquidacao",
            "dtLiquidacao",
            "codFontRecursos",
            "valorAnulacaoFonte"
        );
        return $aElementos;
    }

    /**
     * GERAR A ANULACOES DE PAGAMENTO DE EMPENHOS
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados()
    {

        $claop10 = new cl_aop102023();
        $claop11 = new cl_aop112023();
        $claop12 = new cl_aop122023();


        $sSqlUnidade = "select * from infocomplementares where
  	si08_anousu = " . db_getsession("DB_anousu") . " and si08_instit = " . db_getsession("DB_instit");

        $rsResultUnidade = db_query($sSqlUnidade);
        $sTipoLiquidante = db_utils::fieldsMemory($rsResultUnidade, 0)->si08_tipoliquidante;

        $sSqlUnidade = "select * from infocomplementares where
  	 si08_anousu = " . db_getsession("DB_anousu") . " and si08_instit = " . db_getsession("DB_instit");

        $rsResultUnidade = db_query($sSqlUnidade);
        $sTrataCodUnidade = db_utils::fieldsMemory($rsResultUnidade, 0)->si08_tratacodunidade;


        /*
         * SE JA FOI GERADO ESTA ROTINA UMA VEZ O SISTEMA APAGA OS DADOS DO BANCO E GERA NOVAMENTE
         */
        db_inicio_transacao();
        $result = $claop10->sql_record($claop10->sql_query(null, "*", null, "si137_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
            . " and si137_instit = " . db_getsession("DB_instit")));

        if (pg_num_rows($result) > 0) {
            $claop12->excluir(null, "si139_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si139_instit = " . db_getsession("DB_instit"));

            if ($claop12->erro_status == 0) {
                throw new Exception($claop12->erro_msg);
            }

            $claop11->excluir(null, "si138_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si138_instit = " . db_getsession("DB_instit"));

            if ($claop11->erro_status == 0) {
                throw new Exception($claop11->erro_msg);
            }

            $claop10->excluir(null, "si137_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si137_instit = " . db_getsession("DB_instit"));
            if ($claop10->erro_status == 0) {
                throw new Exception($claop10->erro_msg);
            }
        }

        $iInstit = db_getsession ("DB_instit");
        $sDataInicial = $this->sDataInicial;
        $sDataFinal = $this->sDataFinal;

        $sSql = $claop10->sqlPrincipal ($iInstit, $sDataInicial, $sDataFinal);
        $rsAnulacao = db_query($sSql);

        /**
         * Percorrer registros retornados do sql acima
         */
        $aAnulacoes = array();
        for ($iCont = 0; $iCont < pg_num_rows($rsAnulacao); $iCont++) {

            $oAnulacoes = db_utils::fieldsMemory($rsAnulacao, $iCont);

            $itipoOP = 0;
            if ($oAnulacoes->c71_coddoc == 6 && $oAnulacoes->divida != 46) {
                $itipoOP = 1;
            } else {

                if ($oAnulacoes->c71_coddoc == 36) {
                    $itipoOP = 3;
                } else {

                    if ($oAnulacoes->c71_coddoc == 38) {
                        $itipoOP = 4;
                    } else {
                        $itipoOP = 2;
                    }
                }
            }

            if (($sTrataCodUnidade == "2") && ($oAnulacoes->subunidade != '' && $oAnulacoes->subunidade != 0)) {

                $sCodUnidade  = str_pad($oAnulacoes->o58_orgao, 2, "0", STR_PAD_LEFT);
                $sCodUnidade .= str_pad($oAnulacoes->o58_unidade, 3, "0", STR_PAD_LEFT);
                $sCodUnidade .= str_pad($oAnulacoes->subunidade, 3, "0", STR_PAD_LEFT);
            } else {

                $sCodUnidade = str_pad($oAnulacoes->o58_orgao, 2, "0", STR_PAD_LEFT);
                $sCodUnidade .= str_pad($oAnulacoes->o58_unidade, 3, "0", STR_PAD_LEFT);
            }
            /**
             * Consulta quantidade de estornos.
             */
            $sSqlEstornos = $this->sqlEstornos($oAnulacoes, $sDataInicial, $this->sDataFinal);
            $rsQuantEstornos = db_query($sSqlEstornos);


            if (db_utils::fieldsMemory($rsQuantEstornos, 0)->valor == "" || db_utils::fieldsMemory($rsQuantEstornos, 0)->valor <> 0) {

                $rsResultOP = $this->sqlOpDoEstorno ($oAnulacoes);

                $iOpDoEstorno = db_utils::fieldsMemory($rsResultOP)->codlan;
                $iOpPagamento = db_utils::fieldsMemory($rsResultOP)->c70_codlan;
                $DataOpExorno = db_utils::fieldsMemory($rsResultOP)->dtpagamento;

                /**
                 * Registro 10
                 **/
                $Hash = $oAnulacoes->c71_codlan;
                if (!isset($aAnulacoes[$Hash])) {
                    $oDadosAnulacao = new stdClass();

                    /*
                     * Verifica se o empenho existe na tabela dotacaorpsicom
                     * Caso exista, busca os dados da dotação.
                     * */
                    $sSqlDotacaoRpSicom = "select * from dotacaorpsicom where si177_numemp = {$oAnulacoes->e60_numemp}";
                    $iFonteAlterada = '0';
                    if (pg_num_rows(db_query($sSqlDotacaoRpSicom)) > 0) {
                        $aDotacaoRpSicom = db_utils::getColectionByRecord(db_query($sSqlDotacaoRpSicom));
                        $iFonteAlterada = str_pad($aDotacaoRpSicom[0]->si177_codfontrecursos, 3, "0", STR_PAD_LEFT);
                        $oDadosAnulacao->si137_codorgao = str_pad($aDotacaoRpSicom[0]->si177_codorgaotce, 2, "0", STR_PAD_LEFT);
                        $oDadosAnulacao->si137_codunidadesub = strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 5 && strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 8 ? "0" . $aDotacaoRpSicom[0]->si177_codunidadesub : $aDotacaoRpSicom[0]->si177_codunidadesub;
                        $iFonteAlterada = str_pad($aDotacaoRpSicom[0]->si177_codfontrecursos, 3, "0", STR_PAD_LEFT);
                    } else {
                        $oDadosAnulacao->si137_codorgao = $oAnulacoes->si09_codorgaotce;
                        $oDadosAnulacao->si137_codunidadesub = $sCodUnidade;
                    }

                    $oDadosAnulacao->si137_tiporegistro = 10;
                    $oDadosAnulacao->si137_codreduzido = $oAnulacoes->c71_codlan;
                    $oDadosAnulacao->si137_nroop = $iOpDoEstorno;
                    $oDadosAnulacao->si137_dtpagamento = ($DataOpExorno == '' || $DataOpExorno == null) ? $oAnulacoes->dtanulacao : $DataOpExorno; //$oAnulacoes->dtpag;
                    $oDadosAnulacao->si137_nroanulacaoop = $iOpDoEstorno;
                    $oDadosAnulacao->si137_dtanulacaoop = $oAnulacoes->dtanulacao;
                    $oDadosAnulacao->si137_justificativaanulacao = "ESTORNO DE PAGAMENTO";
                    $oDadosAnulacao->si137_vlanulacaoop = $oAnulacoes->vlrordem;
                    $oDadosAnulacao->si137_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $oDadosAnulacao->si137_instit = db_getsession("DB_instit");
                    $oDadosAnulacao->reg11 = array();

                    /**
                     * Registro 11
                     */

                    $oDadosAnulacaoFonte = new stdClass();

                    $oDadosAnulacaoFonte->si138_tiporegistro = 11;
                    $oDadosAnulacaoFonte->si138_codreduzido = $oAnulacoes->c71_codlan;
                    $oDadosAnulacaoFonte->si138_tipopagamento = $itipoOP;
                    $oDadosAnulacaoFonte->si138_nroempenho = $oAnulacoes->e60_codemp;
                    $oDadosAnulacaoFonte->si138_dtempenho = $oAnulacoes->dtempenho;
                    if ($itipoOP == 3) {
                        $oDadosAnulacaoFonte->si138_nroliquidacao = "";
                        $oDadosAnulacaoFonte->si138_dtliquidacao = "";
                    } else {
                        $oDadosAnulacaoFonte->si138_nroliquidacao = $oAnulacoes->nroliquidacao;
                        $oDadosAnulacaoFonte->si138_dtliquidacao = $oAnulacoes->dtliquida;
                    }
                    $oDadosAnulacaoFonte->si138_codfontrecursos = $iFonteAlterada != 0 ? $iFonteAlterada : str_pad($oAnulacoes->recurso, 3, "0", STR_PAD_LEFT);
                    if (in_array($oDadosAnulacaoFonte->si138_codfontrecursos, $this->aFontesEncerradas)) {
                        $oDadosAnulacaoFonte->si138_codfontrecursos = substr($oDadosAnulacaoFonte->si138_codfontrecursos, 0, 1) . '59';
                    }
                    $oDadosAnulacaoFonte->si138_codfontrecursos = substr($this->oDeParaRecurso->getDePara($oDadosAnulacaoFonte->si138_codfontrecursos), 0, 7);

                    $oControleOrcamentario = new ControleOrcamentario();
                    $oControleOrcamentario->setTipoDespesa($oAnulacoes->e60_tipodespesa);
                    $oControleOrcamentario->setFonte($oAnulacoes->o15_codigo);
                    $oControleOrcamentario->setEmendaParlamentar($oAnulacoes->e60_emendaparlamentar);
                    $oControleOrcamentario->setEsferaEmendaParlamentar($oAnulacoes->e60_esferaemendaparlamentar);
                    $oControleOrcamentario->setDeParaFonteCompleta();

                    $oDadosAnulacaoFonte->si138_codco = $oControleOrcamentario->getCodigoParaEmpenho();
                    $oDadosAnulacaoFonte->si138_valoranulacaofonte = $oAnulacoes->vlrordem;
                    $oDadosAnulacaoFonte->si138_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $oDadosAnulacaoFonte->si138_reg10 = 0;
                    $oDadosAnulacaoFonte->si138_instit = db_getsession("DB_instit");

                    $oDadosAnulacao->reg11[$Hash] = $oDadosAnulacaoFonte;
                    $aAnulacoes[$Hash] = $oDadosAnulacao;
                } else {
                    $aAnulacoes[$Hash]->si137_vlanulacaoop += $oAnulacoes->vlrordem;
                    $aAnulacoes[$Hash]->reg11[$Hash]->si138_valoranulacaofonte += $oAnulacoes->vlrordem;
                }

                $oEmpPago = new stdClass();
                $oEmpPago->ordem = $oAnulacoes->e50_codord;
                $oEmpPago->lancamento = $iOpPagamento;
                $oEmpPago->valor = $oAnulacoes->vlrordem;

                $sDataFinal = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $iAnoUsu = db_getsession ("DB_anousu");
                $iInstit = db_getsession ("DB_instit");

                $aAnulacoes[$Hash]->reg11[$Hash]->reg12 = $this->setDetalhamento12($oEmpPago, $aAnulacoes[$Hash], $aAnulacoes[$Hash]->reg11[$Hash], $sDataFinal, $iAnoUsu, $iInstit);
            }
        }

        foreach ($aAnulacoes as $anulacao) {

            $oDadosAnulacao = new cl_aop102023();

            $oDadosAnulacao->si137_tiporegistro = $anulacao->si137_tiporegistro;
            $oDadosAnulacao->si137_codreduzido = $anulacao->si137_codreduzido;
            $oDadosAnulacao->si137_codorgao = $anulacao->si137_codorgao;
            $oDadosAnulacao->si137_codunidadesub = $anulacao->si137_codunidadesub;
            $oDadosAnulacao->si137_nroop = $anulacao->si137_nroop;
            $oDadosAnulacao->si137_dtpagamento = $anulacao->si137_dtpagamento;
            $oDadosAnulacao->si137_nroanulacaoop = $anulacao->si137_nroanulacaoop;
            $oDadosAnulacao->si137_dtanulacaoop = $anulacao->si137_dtanulacaoop;
            $oDadosAnulacao->si137_justificativaanulacao = $anulacao->si137_justificativaanulacao;
            $oDadosAnulacao->si137_vlanulacaoop = $anulacao->si137_vlanulacaoop;
            $oDadosAnulacao->si137_mes = $anulacao->si137_mes;
            $oDadosAnulacao->si137_instit = $anulacao->si137_instit;

            $oDadosAnulacao->incluir(null);
            if ($oDadosAnulacao->erro_status == 0) {
                throw new Exception($oDadosAnulacao->erro_msg);
            }

            foreach ($anulacao->reg11 as $reg11) {

                $oDadosAnulacaoFonte = new cl_aop112023();

                $oDadosAnulacaoFonte->si138_tiporegistro = $reg11->si138_tiporegistro;
                $oDadosAnulacaoFonte->si138_codreduzido = $reg11->si138_codreduzido;
                $oDadosAnulacaoFonte->si138_tipopagamento = $reg11->si138_tipopagamento;
                $oDadosAnulacaoFonte->si138_nroempenho = $reg11->si138_nroempenho;
                $oDadosAnulacaoFonte->si138_dtempenho = $reg11->si138_dtempenho;
                $oDadosAnulacaoFonte->si138_nroliquidacao = $reg11->si138_nroliquidacao;
                $oDadosAnulacaoFonte->si138_dtliquidacao = $reg11->si138_dtliquidacao;
                $oDadosAnulacaoFonte->si138_codfontrecursos = $reg11->si138_codfontrecursos;
                $oDadosAnulacaoFonte->si138_codco = $reg11->si138_codco;
                $oDadosAnulacaoFonte->si138_valoranulacaofonte = $reg11->si138_valoranulacaofonte;
                $oDadosAnulacaoFonte->si138_mes = $reg11->si138_mes;
                $oDadosAnulacaoFonte->si138_reg10 = $oDadosAnulacao->si137_sequencial;
                $oDadosAnulacaoFonte->si138_instit = $reg11->si138_instit;

                $oDadosAnulacaoFonte->incluir(null);
                if ($oDadosAnulacaoFonte->erro_status == 0) {
                    throw new Exception($oDadosAnulacaoFonte->erro_msg);
                }

                if ($reg11->reg12) {

                    $reg11->reg12->si139_reg10 = $oDadosAnulacao->si137_sequencial;
                    $reg11->reg12->incluir(null);

                    if ($reg11->reg12->erro_status == 0) {
                        throw new Exception($reg11->reg12->erro_msg);
                    }
                }
            }
        }

        db_fim_transacao();

        $oGerarAOP = new GerarAOP();
        $oGerarAOP->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oGerarAOP->gerarDados();
    }

    public function setDetalhamento12($oEmpPago, $oAOP10, $oAOP11, $sDataFinal, $iAnoUsu, $iInstit)
    {
        $claop12 = new cl_aop122023();

        $rsPagOrd12 = $claop12->sqlReg12($oEmpPago, $iAnoUsu);
        $reg12 = db_utils::fieldsMemory($rsPagOrd12, 0);

        $sSqlContaPagFont = " SELECT * FROM ( ";
        for ($iAno = 2014; $iAno <= 2023; $iAno++) {
            $sSqlContaPagFont .= $claop12->getUnionPagFont($reg12, $iAno, $sDataFinal, $iInstit, $iAnoUsu);
            if ($iAno < 2023) {
                $sSqlContaPagFont .= " UNION ";
            }
        }
        $sSqlContaPagFont .= ") AS x ORDER BY ano DESC";

        $rsResultContaPag = db_query($sSqlContaPagFont) or die($sSqlContaPagFont . " teste1");

        $ContaPag = db_utils::fieldsMemory($rsResultContaPag)->contapag;

        $claop12->si139_tiporegistro = $reg12->tiporegistro;
        $claop12->si139_codreduzido = $oAOP10->si137_codreduzido;
        $claop12->si139_tipodocumento = $reg12->tipodocumentoop;
        $claop12->si139_nrodocumento = ($reg12->tipodocumentoop == '99' && $reg12->e81_numdoc != '') ? ' ' : $reg12->nrodocumento;
        $claop12->si139_codctb = $ContaPag;
        $claop12->si139_codfontectb = $oAOP11->si138_codfontrecursos;
        if ($reg12->tipodocumentoop == '99' && $reg12->e81_numdoc != '') {
            $claop12->si139_desctipodocumentoop = $reg12->e81_numdoc;
        } elseif ($reg12->tipodocumentoop == '99') {
            $claop12->si139_desctipodocumentoop = 'TED';
        } else {
            $claop12->si139_desctipodocumentoop = ' ';
        }
        $claop12->si139_dtemissao = $reg12->dtemissao;
        $claop12->si139_vldocumento = abs($oEmpPago->valor);
        $claop12->si139_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $claop12->si139_instit = $iInstit;

        return $claop12;
    }

    public function sqlEstornos($oAnulacoes, $sDataInicial, $sDataFinal)
    {
        $sSqlEstornos = " SELECT sum(CASE ";
        $sSqlEstornos .= "                WHEN c53_tipo = 31 THEN -1 * c70_valor ";
        $sSqlEstornos .= "                ELSE c70_valor ";
        $sSqlEstornos .= "            END) AS valor ";
        $sSqlEstornos .= " FROM conlancamdoc ";
        $sSqlEstornos .= " JOIN conhistdoc ON c53_coddoc = c71_coddoc ";
        $sSqlEstornos .= " JOIN conlancamord ON c71_codlan = c80_codlan ";
        $sSqlEstornos .= " JOIN conlancam ON c70_codlan = c71_codlan ";
        $sSqlEstornos .= " WHERE c53_tipo IN (31, 30) ";
        $sSqlEstornos .= "     AND c80_codord = {$oAnulacoes->e50_codord} ";
        $sSqlEstornos .= "     AND c70_data BETWEEN '{$sDataInicial}' AND '{$sDataFinal}'";
        return $sSqlEstornos;
    }

    public function sqlOpDoEstorno($oAnulacoes)
    {
        $sSqlOp = "WITH max_codlan AS (
                        SELECT MAX(c71_codlan) AS max_codlan FROM conlancamdoc
                        JOIN conlancamord ON c80_codlan = c71_codlan
                        JOIN conlancam ON c70_codlan = c71_codlan
                        WHERE c80_codord = {$oAnulacoes->e50_codord}
                          AND c71_coddoc IN (5, 35, 37)
                          AND c71_codlan < {$oAnulacoes->c71_codlan}
                          AND c70_valor = {$oAnulacoes->vlrordem}
                    )
                    SELECT c70_codlan || lpad($oAnulacoes->e50_codord, 10, '0') AS codlan, c70_data AS dtpagamento, c70_codlan
                    FROM conlancam
                    WHERE c70_codlan IN (SELECT max_codlan FROM max_codlan)";

        $rsResultOP = db_query ($sSqlOp);

        if (pg_num_rows ($rsResultOP) == 0) {
            $sSqlOp = "WITH max_c71_codlan AS (
                            SELECT max(c71_codlan) AS max_codlan FROM conlancamdoc
                            JOIN conlancamord ON c80_codlan = c71_codlan
                            JOIN conlancam ON c70_codlan = c71_codlan
                            WHERE c80_codord = {$oAnulacoes->e50_codord}
                              AND c71_coddoc IN (5, 35, 37)
                              AND c71_codlan < {$oAnulacoes->c71_codlan}
                        )
                        SELECT c70_codlan || lpad($oAnulacoes->e50_codord::text, 10, '0') AS codlan, c70_data AS dtpagamento, c70_codlan
                        FROM conlancam
                        WHERE c70_codlan = (SELECT max_codlan FROM max_c71_codlan)";
            $rsResultOP = db_query ($sSqlOp);
        }

        return $rsResultOP;
    }

}
