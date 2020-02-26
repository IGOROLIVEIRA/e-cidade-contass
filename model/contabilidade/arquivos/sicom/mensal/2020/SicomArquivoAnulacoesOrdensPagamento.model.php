<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_aop102020_classe.php");
require_once("classes/db_aop112020_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarAOP.model.php");

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

        $claop10 = new cl_aop102020();
        $claop11 = new cl_aop112020();


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
                   e50_obs,
                   CASE
                       WHEN date_part('year',e50_data) < 2015 THEN e71_codnota::varchar
                       ELSE (rpad(e71_codnota::varchar,9,'0') || lpad(e71_codord::varchar,9,'0'))
                   END AS nroliquidacao,
                   si09_codorgaotce,
                   o41_subunidade AS subunidade
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

            if (($sTrataCodUnidade == "2") && ($oAnulacoes->subunidade != '' && $oAnulacoes->subunidade != 0)){

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


                $sSqlOp = "select c70_codlan || lpad($oAnulacoes->e50_codord,10,0) as codlan, c70_data as dtpagamento from conlancam
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
                    $sSqlOp = "select c70_codlan || lpad($oAnulacoes->e50_codord,10,0) as codlan, c70_data as dtpagamento from conlancam
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
                    $oDadosAnulacao->si137_nroop = $OpdoExtorno;//$oAnulacoes->numordem;
                    $oDadosAnulacao->si137_dtpagamento = ($DataOpExorno == '' || $DataOpExorno == null) ? $oAnulacoes->dtanulacao : $DataOpExorno;//$oAnulacoes->dtpag;
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
                    if($itipoOP == 3){
                        $oDadosAnulacaoFonte->si138_nroliquidacao = "";
                        $oDadosAnulacaoFonte->si138_dtliquidacao = "";
                    }else{
                        $oDadosAnulacaoFonte->si138_nroliquidacao = $oAnulacoes->nroliquidacao;
                        $oDadosAnulacaoFonte->si138_dtliquidacao = $oAnulacoes->dtliquida;
                    }
                    $oDadosAnulacaoFonte->si138_codfontrecursos = $iFonteAlterada != 0 ? $iFonteAlterada : str_pad($oAnulacoes->recurso, 3, "0", STR_PAD_LEFT);
                    if (in_array($oDadosAnulacaoFonte->si138_codfontrecursos, $this->aFontesEncerradas)) {
                        $oDadosAnulacaoFonte->si138_codfontrecursos = substr($oDadosAnulacaoFonte->si138_codfontrecursos, 0, 1).'59';
                    }
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

            }
        }

        foreach ($aAnulacoes as $anulacao) {

            $oDadosAnulacao = new cl_aop102020();

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

                $oDadosAnulacaoFonte = new cl_aop112020();

                $oDadosAnulacaoFonte->si138_tiporegistro = $reg11->si138_tiporegistro;
                $oDadosAnulacaoFonte->si138_codreduzido = $reg11->si138_codreduzido;
                $oDadosAnulacaoFonte->si138_tipopagamento = $reg11->si138_tipopagamento;
                $oDadosAnulacaoFonte->si138_nroempenho = $reg11->si138_nroempenho;
                $oDadosAnulacaoFonte->si138_dtempenho = $reg11->si138_dtempenho;
                $oDadosAnulacaoFonte->si138_nroliquidacao = $reg11->si138_nroliquidacao;
                $oDadosAnulacaoFonte->si138_dtliquidacao = $reg11->si138_dtliquidacao;
                $oDadosAnulacaoFonte->si138_codfontrecursos = $reg11->si138_codfontrecursos;
                $oDadosAnulacaoFonte->si138_valoranulacaofonte = $reg11->si138_valoranulacaofonte;
                $oDadosAnulacaoFonte->si138_codorgaoempop = $reg11->si138_codorgaoempop;
                $oDadosAnulacaoFonte->si138_codunidadeempop = $reg11->si138_codunidadeempop;
                $oDadosAnulacaoFonte->si138_mes = $reg11->si138_mes;
                $oDadosAnulacaoFonte->si138_reg10 = $oDadosAnulacao->si137_sequencial;
                $oDadosAnulacaoFonte->si138_instit = $reg11->si138_instit;

                $oDadosAnulacaoFonte->incluir(null);
                if ($oDadosAnulacaoFonte->erro_status == 0) {
                    throw new Exception($oDadosAnulacaoFonte->erro_msg);
                }
            }
        }

        db_fim_transacao();

        $oGerarAOP = new GerarAOP();
        $oGerarAOP->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oGerarAOP->gerarDados();
    }

}
