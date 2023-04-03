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
 * Anulações das Ordens de Pagamento Sicom Acompanhamento Mensal
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

        $sSql = "SELECT c71_coddoc,
                   e50_codord,
                   c71_codlan,
                   c70_data AS dtanulacao,
                   e50_data AS dtordem,
                   e50_data AS dtliquida,
                   (SELECT c71_codlan AS dtpagamento FROM conlancamdoc
                    WHERE c71_codlan = (SELECT max(c71_codlan) FROM conlancamdoc
                                        JOIN conlancamord ON c80_codlan = c71_codlan
                                        WHERE c80_codord = e50_codord
                                            AND c71_coddoc IN (5, 35, 37)
                                            AND c71_codlan < c70_codlan) )||lpad(e50_codord,10,0) AS numordem,
                   e50_codord AS numLiquida,
                   c70_valor AS vlrordem,
                   (SELECT c71_data AS dtpagamento FROM conlancamdoc
                    WHERE c71_codlan = (SELECT max(c71_codlan) FROM conlancamdoc
                                        JOIN conlancamord ON c80_codlan = c71_codlan
                                        WHERE c80_codord = e50_codord
                                            AND c71_coddoc IN (5, 35, 37)
                                            AND c71_codlan < c70_codlan) ) AS dtpag,
                   e60_codemp,
                   e60_numemp,
                   e60_emiss AS dtempenho,
                   z01_nome,
                   z01_cgccpf,
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
                   o58_funcao,
                   o58_subfuncao,
                   o58_programa,
                   o58_projativ,
                   substr(o56_elemento,2,6) AS elemento,
                   substr(o56_elemento,8,2) AS subelemento,
                   substr(o56_elemento,2,2) AS divida,
                   o15_codtri AS recurso,
                   o15_codigo,
                   e50_obs,
                   CASE
                       WHEN date_part('year',e50_data) < 2023 THEN e71_codnota::varchar
                       ELSE (rpad(e71_codnota::varchar,9,'0') || lpad(e71_codord::varchar,9,'0'))
                   END AS nroliquidacao,
                   si09_codorgaotce,
                   o41_subunidade AS subunidade,
                   e60_emendaparlamentar,
                    e60_esferaemendaparlamentar
            FROM conlancam
            JOIN conlancamdoc ON c71_codlan = c70_codlan
            JOIN conlancamord ON c80_codlan = c71_codlan
            JOIN pagordem ON c80_codord = e50_codord
            JOIN pagordemele ON e53_codord = e50_codord
            JOIN pagordemnota ON e71_codord = c80_codord
            JOIN empempenho ON e50_numemp = e60_numemp
            JOIN cgm ON e60_numcgm = z01_numcgm
            JOIN orcdotacao ON e60_coddot = o58_coddot AND e60_anousu = o58_anousu
            JOIN orcelemento ON o58_codele = o56_codele AND o58_anousu = o56_anousu
            JOIN orctiporec ON o58_codigo = o15_codigo
            JOIN orcunidade ON o58_anousu = o41_anousu AND o58_orgao = o41_orgao AND o58_unidade = o41_unidade
            JOIN orcorgao ON o40_orgao = o41_orgao AND o40_anousu = o41_anousu
            LEFT JOIN infocomplementaresinstit ON e60_instit = si09_instit AND si09_instit = " . db_getsession("DB_instit") . "
            WHERE c71_coddoc IN (6, 36, 38)
                AND o41_instit = " . db_getsession("DB_instit") . "
                AND e60_instit = " . db_getsession("DB_instit") . "
                AND c71_data BETWEEN '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'";

        $rsAnulacao = db_query($sSql);
        // print_r($sSql);die();
        /**
         * percorrer registros retornados do sql acima
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
             * pegar quantidade de extornos
             */
            $sSqlExtornos  = " SELECT sum(CASE ";
            $sSqlExtornos .= "                WHEN c53_tipo = 21 THEN -1 * c70_valor ";
            $sSqlExtornos .= "                ELSE c70_valor ";
            $sSqlExtornos .= "            END) AS valor ";
            $sSqlExtornos .= " FROM conlancamdoc ";
            $sSqlExtornos .= " JOIN conhistdoc ON c53_coddoc = c71_coddoc ";
            $sSqlExtornos .= " JOIN conlancamord ON c71_codlan = c80_codlan ";
            $sSqlExtornos .= " JOIN conlancam ON c70_codlan = c71_codlan ";
            $sSqlExtornos .= " WHERE c53_tipo IN (31, 30) ";
            $sSqlExtornos .= "     AND c80_codord = {$oAnulacoes->e50_codord} ";
            $sSqlExtornos .= "     AND c70_data BETWEEN '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "' ";

            $rsQuantExtornos = db_query($sSqlExtornos);

            if (db_utils::fieldsMemory($rsQuantExtornos, 0)->valor == "" || db_utils::fieldsMemory($rsQuantExtornos, 0)->valor <> 0) {


                $sSqlOp = "select c70_codlan || lpad($oAnulacoes->e50_codord,10,0) as codlan, c70_data as dtpagamento, c70_codlan from conlancam
    		             where c70_codlan in (
    					select max(c71_codlan)
				  						from conlancamdoc
				  						join conlancamord on c80_codlan = c71_codlan join conlancam on c70_codlan = c71_codlan
									   where c80_codord = {$oAnulacoes->e50_codord}
										 and c71_coddoc in (5,35,37)
										 and c71_codlan < {$oAnulacoes->c71_codlan}
										 and c70_valor = {$oAnulacoes->vlrordem})";

                $rsResultOP = db_query($sSqlOp);

                if (pg_num_rows($rsResultOP) == 0) {
                    $sSqlOp = "select c70_codlan || lpad($oAnulacoes->e50_codord,10,0) as codlan, c70_data as dtpagamento, c70_codlan from conlancam
    		             where c70_codlan in (
    					select max(c71_codlan)
				  						from conlancamdoc
				  						join conlancamord on c80_codlan = c71_codlan join conlancam on c70_codlan = c71_codlan
									   where c80_codord = {$oAnulacoes->e50_codord}
										 and c71_coddoc in (5,35,37)
										 and c71_codlan < {$oAnulacoes->c71_codlan})";
                    $rsResultOP = db_query($sSqlOp);
                }
                //echo $sSqlOp;			db_criatabela($rsResultOP);
                $OpdoExtorno = db_utils::fieldsMemory($rsResultOP)->codlan;
                $iOpPagamento = db_utils::fieldsMemory($rsResultOP)->c70_codlan;
                $DataOpExorno = db_utils::fieldsMemory($rsResultOP)->dtpagamento;

                $rsQuantExtornos = db_query($sSqlExtornos);
                /**
                 * Registro 10
                 **/
                $Hash = $oAnulacoes->c71_codlan;
                if (!isset($aAnulacoes[$Hash])) {
                    $oDadosAnulacao = new stdClass();

                    /*
                     * Verifica se o empenho existe na tabela dotacaorpsicom
                     * Caso exista, busca os dados da dotaÃ§Ã£o.
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
                    $oDadosAnulacao->si137_nroop = $OpdoExtorno; //$oAnulacoes->numordem;
                    $oDadosAnulacao->si137_dtpagamento = ($DataOpExorno == '' || $DataOpExorno == null) ? $oAnulacoes->dtanulacao : $DataOpExorno; //$oAnulacoes->dtpag;
                    $oDadosAnulacao->si137_nroanulacaoop = $OpdoExtorno;
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
                    
                    $oControleOrcamentario = new ControleOrcamentario();
                    $oControleOrcamentario->setFonte($oAnulacoes->o15_codigo);
                    $oControleOrcamentario->setEmendaParlamentar($oAnulacoes->e60_emendaparlamentar);
                    $oControleOrcamentario->setEsferaEmendaParlamentar($oAnulacoes->e60_esferaemendaparlamentar);
           
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
                $aAnulacoes[$Hash]->reg11[$Hash]->reg12 = $this->setDetalhamento12($oEmpPago, $aAnulacoes[$Hash], $aAnulacoes[$Hash]->reg11[$Hash]);
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
                // $oDadosAnulacaoFonte->si138_codorgaoempop = $reg11->si138_codorgaoempop;
                // $oDadosAnulacaoFonte->si138_codunidadeempop = $reg11->si138_codunidadeempop;
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

    public function setDetalhamento12($oEmpPago, $oAOP10, $oAOP11)
    {
        $sHash = $oEmpPago->ordem;
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
                            c23_conlancam AS codlan,
                            e81_codmov,
                            e81_numdoc
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


        $sSql12 = "
        SELECT
                12 AS tiporegistro,
                coremp.k12_codord AS codreduzidoop,
                CASE
                    WHEN e96_codigo = 4
                    AND c60_codsis = 5 THEN 5
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
                corrente.k12_valor AS vldocumento,
                CASE
                    WHEN c60_codsis = 5 THEN ''
                    ELSE e96_descr
                END desctipodocumentoop,
                c23_conlancam AS codlan,
                e81_codmov,
                e81_numdoc
            FROM
                corrente
                JOIN coremp ON (
                    coremp.k12_autent,
                    coremp.k12_data,
                    coremp.k12_id
                ) = (
                    corrente.k12_autent,
                    corrente.k12_data,
                    corrente.k12_id
                )
                JOIN conplanoreduz ON c61_reduz = k12_conta
                JOIN conplano ON c61_codcon = c60_codcon
                AND c61_anousu = c60_anousu
                LEFT JOIN conplanoconta ON c63_codcon = c60_codcon
                AND c60_anousu = c63_anousu
                JOIN corgrupocorrente ON corgrupocorrente.k105_autent = corrente.k12_autent
                AND corgrupocorrente.k105_data = corrente.k12_data
                AND (
                    corgrupocorrente.k105_data,
                    corgrupocorrente.k105_id
                ) = (corrente.k12_data, corrente.k12_id)
                JOIN conlancamcorgrupocorrente ON c23_corgrupocorrente = corgrupocorrente.k105_sequencial
                JOIN pagordem ON (k12_empen, k12_codord) = (e50_numemp, e50_codord)
                INNER JOIN empempenho ON empempenho.e60_numemp = e50_numemp
                INNER JOIN empagemov ON empempenho.e60_numemp = empagemov.e81_numemp
                INNER JOIN empord ON empord.e82_codmov = empagemov.e81_codmov
                LEFT JOIN empagemovforma ON empagemovforma.e97_codmov = empagemov.e81_codmov
                LEFT JOIN empageforma ON empageforma.e96_codigo = empagemovforma.e97_codforma
                LEFT JOIN empageconf ON empageconf.e86_codmov = empagemov.e81_codmov
                JOIN orcdotacao ON (o58_coddot, o58_anousu) = (e60_coddot, e60_anousu)
                JOIN orctiporec ON o58_codigo = o15_codigo
            WHERE
                k12_codord = {$oEmpPago->ordem}
                AND c23_conlancam = {$oEmpPago->lancamento}
                AND c61_anousu = " . db_getsession("DB_anousu") . "
                AND e81_cancelado IS NULL";

        $rsPagOrd12 = db_query($sSql12);

        $reg12 = db_utils::fieldsMemory($rsPagOrd12, 0);

        $claop12 = new cl_aop122023();

        $sSqlContaPagFont = " SELECT * FROM ( ";
        for ($iAno = 2014; $iAno <= 2023; $iAno++) {
            $sSqlContaPagFont .= $this->getUnionPagFont($reg12, $iAno);
            if ($iAno < 2023)
                $sSqlContaPagFont .= " UNION ";
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
        $claop12->si139_vldocumento = $reg12->vldocumento;
        $claop12->si139_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $claop12->si139_instit = db_getsession("DB_instit");

        return $claop12;
    }

    public function getUnionPagFont($reg12, $iAno)
    {
        return " SELECT DISTINCT 'ctb10{$iAno}' as ano, si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                JOIN conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                JOIN orctiporec on c61_codigo = o15_codigo
                JOIN ctb10{$iAno} on
                    si95_banco = c63_banco and
                    substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                    coalesce(si95_digitoverificadoragencia, '') = coalesce(c63_dvagencia, '') and
                    si95_contabancaria = c63_conta::int8 and
                    si95_digitoverificadorcontabancaria = c63_dvconta and
                    si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb20{$iAno} on si96_codctb = si95_codctb and si96_mes = si95_mes
                WHERE si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu") . "
                    and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
    }
}
