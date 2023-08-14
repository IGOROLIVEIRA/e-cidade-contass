<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_aoc102023_classe.php");
require_once("classes/db_aoc112023_classe.php");
require_once("classes/db_aoc122023_classe.php");
require_once("classes/db_aoc132023_classe.php");
require_once("classes/db_aoc142023_classe.php");
require_once("classes/db_infocomplementaresinstit_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2023/GerarAOC.model.php");

/**
 * Alterações Orçamentárias Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoAlteracoesOrcamentarias extends SicomArquivoBase implements iPadArquivoBaseCSV
{

    /**
     *
     * Codigo do layout. (db_layouttxt.db50_codigo)
     * @var Integer
     */
    protected $iCodigoLayout = 152;

    /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'AOC';

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
            "codFuncao",
            "codSubFuncao",
            "codPrograma",
            "idAcao",
            "idSubAcao",
            "elementoDespesa",
            "codFontRecursos",
            "nroDecreto",
            "dataDecreto",
            "tipoAlteracao",
            "vlAlteracao"
        );

        $aElementos[11] = array(
            "tipoRegistro",
            "codReduzido",
            "codFontRecursos",
            "valorAlteracaoFonte"
        );

        return $aElementos;
    }

    /**
     * selecionar os dados de alteracoes orcamentarias do mes para gerar o arquivo
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados()
    {

        $claoc10 = new cl_aoc102023();
        $claoc11 = new cl_aoc112023();
        $claoc12 = new cl_aoc122023();
        $claoc13 = new cl_aoc132023();
        $claoc14 = new cl_aoc142023();
        $claoc15 = new cl_aoc152023();

        /**
         * excluir informacoes do mes selecionado
         */
        db_inicio_transacao();

        $instituicao = db_getsession("DB_instit");
        $dataFinalMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

        $result = $claoc15->sql_record($claoc15->sql_query(null, "*", null, "si194_mes = {$dataFinalMes} and si194_instit = {$instituicao}"));
        if (pg_num_rows($result) > 0) {
            $claoc15->excluir(null, "si194_mes = {$dataFinalMes} and si194_instit = {$instituicao}");
            if ($claoc15->erro_status == 0) {
                throw new Exception($claoc15->erro_msg);
            }
        }

        $result = $claoc11->sql_record($claoc11->sql_query(null, "*", null, "si39_mes = {$dataFinalMes} and si39_instit = {$instituicao}"));
        if (pg_num_rows($result) > 0) {
            $claoc11->excluir(null, "si39_mes = {$dataFinalMes} and si39_instit = {$instituicao}");
            if ($claoc11->erro_status == 0) {
                throw new Exception($claoc11->erro_msg);
            }
        }

        $result = $claoc12->sql_record($claoc12->sql_query(null, "*", null, "si40_mes = {$dataFinalMes} and si40_instit = {$instituicao}"));
        if (pg_num_rows($result) > 0) {
            $claoc12->excluir(null, "si40_mes = {$dataFinalMes} and si40_instit = {$instituicao}");
            if ($claoc12->erro_status == 0) {
                throw new Exception($claoc12->erro_msg);
            }
        }

        $result = $claoc13->sql_record($claoc13->sql_query(null, "*", null, "si41_mes = {$dataFinalMes} and si41_instit = {$instituicao}"));
        if (pg_num_rows($result) > 0) {
            $claoc13->excluir(null, "si41_mes = {$dataFinalMes} and si41_instit = {$instituicao}");
            if ($claoc13->erro_status == 0) {
                throw new Exception($claoc13->erro_msg);
            }
        }

        $result = $claoc14->sql_record($claoc14->sql_query(null, "*", null, "si42_mes = {$dataFinalMes} and si42_instit = {$instituicao}"));
        if (pg_num_rows($result) > 0) {
            $claoc14->excluir(null, "si42_mes = {$dataFinalMes} and si42_instit = {$instituicao}");
            if ($claoc14->erro_status == 0) {
                throw new Exception($claoc14->erro_msg);
            }
        }

        $result = $claoc10->sql_record($claoc10->sql_query(null, "*", null, "si38_mes = {$dataFinalMes} and si38_instit = {$instituicao}"));
        if (pg_num_rows($result) > 0) {
            $claoc10->excluir(null, "si38_mes = {$dataFinalMes} and si38_instit = {$instituicao}");
            if ($claoc10->erro_status == 0) {
                throw new Exception($claoc10->erro_msg);
            }
        }
        /**
         * fim da exclusao dos registros do mes selecionado
         */
        $sSql = $claoc10->sqlReg10($instituicao);
        $rsResult10 = db_query($sSql);

        $infoComplmentar = new cl_infocomplementaresinstit();

        $where = "si09_instit =" . $instituicao . " and si09_tipoinstit = 2";
        $sSqlPrefeitura = $infoComplmentar->sql_query_file(null, "*", null, $where);
        $rsPrefeitura = $infoComplmentar->sql_record($sSqlPrefeitura);

        // matriz de entrada
        $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û',
            'Ä', 'Ã', 'À', 'Á', 'Â', 'Ê', 'Ë', 'È', 'É', 'Ï', 'Ì', 'Í', 'Ö', 'Õ', 'Ò', 'Ó', 'Ô', 'Ü', 'Ù', 'Ú', 'Û',
            'ñ', 'Ñ', 'ç', 'Ç', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', '°', "°", chr(13), chr(10), "'");

        // matriz de saÃ­da
        $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u',
            'A', 'A', 'A', 'A', 'A', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U',
            'n', 'N', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', " ", " ", " ", " ");

        if (pg_num_rows($rsPrefeitura) > 0) {

            for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

                $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
                $claoc10 = new cl_aoc102023();

                $claoc10->si38_tiporegistro = 10;
                $claoc10->si38_codorgao = $oDados10->codorgao;
                $sNrodecreto = preg_replace("/[^a-zA-Z0-9]/", "", $oDados10->nrodecreto);
                $sNrodecreto = str_replace("S", "", $sNrodecreto);
                $claoc10->si38_nrodecreto = $sNrodecreto;
                $claoc10->si38_datadecreto = $oDados10->datadecreto;
                $claoc10->si38_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $claoc10->si38_instit = $instituicao;

                $claoc10->incluir(null);
                if ($claoc10->erro_status == 0) {
                    throw new Exception($claoc10->erro_msg);
                }
                $sSql = $claoc11->sqlReg11($oDados10);
                $rsResult11 = db_query($sSql);

                for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

                    $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
                    $claoc11 = new cl_aoc112023();

                    $claoc11->si39_tiporegistro = 11;
                    $claoc11->si39_codreduzidodecreto = $oDados11->codreduzidodecreto;
                    $sNrodecreto = preg_replace("/[^a-zA-Z0-9]/", "", $oDados11->nrodecreto);
                    $sNrodecreto = str_replace("S", "", $sNrodecreto);
                    $claoc11->si39_nrodecreto = $sNrodecreto;
                    $claoc11->si39_tipodecretoalteracao = $oDados11->tipodecretoalteracao;
                    $claoc11->si39_justificativa = trim(preg_replace("/[^a-zA-Z0-9 ]/", "", substr(str_replace($what, $by, $oDados11->justificativa), 0, 500)));
                    $claoc11->si39_valoraberto = $oDados11->valoraberto;
                    $claoc11->si39_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $claoc11->si39_reg10 = $claoc10->si38_sequencial;
                    $claoc11->si39_instit = $instituicao;

                    $claoc11->incluir(null);
                    if ($claoc11->erro_status == 0) {
                        throw new Exception($claoc11->erro_msg);
                    }

                }

                /**
                 * Registro 12
                 */

                $aTipoDecretoNaoObrigReg12 = array(4, 12, 14, 15);

                if (!in_array($oDados11->tipodecretoalteracao, $aTipoDecretoNaoObrigReg12)) {

                    $sSql = $claoc12->sqlReg12($oDados10);
                    $rsResult12 = db_query($sSql);

                    for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {

                        $oDados12 = db_utils::fieldsMemory($rsResult12, $iCont12);
                        $claoc12 = new cl_aoc122023();

                        $claoc12->si40_tiporegistro = 12;
                        $claoc12->si40_codreduzidodecreto = $oDados12->codreduzidodecreto;

                        if ($oDados11->tipodecretoalteracao == 2) {
                            $oDados12->tipolei = "LAO";
                        }

                        $claoc12->si40_nroleialteracao = substr($oDados12->nroleialteracao, 0, 6);
                        $claoc12->si40_dataleialteracao = $oDados12->dataleialteracao;
                        $claoc12->si40_tpleiorigdecreto = $oDados12->tipolei;
                        $claoc12->si40_tipoleialteracao = $oDados12->tipolei == "LAO" ? $oDados12->tipoleialteracao : 0;
                        $claoc12->si40_valorabertolei = $oDados11->valoraberto;

                        $claoc12->si40_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                        $claoc12->si40_reg10 = $claoc10->si38_sequencial;
                        $claoc12->si40_instit = $instituicao;

                        $claoc12->incluir(null);

                        if ($claoc12->erro_status == 0) {
                            throw new Exception($claoc12->erro_msg);
                        }

                    }

                }

                /**
                 * Registro 13
                 */
                $sSql = $claoc13->sqlReg13($oDados10);
                $rsResult13 = db_query($sSql);

                for ($iCont13 = 0; $iCont13 < pg_num_rows($rsResult13); $iCont13++) {

                    $oDados13 = db_utils::fieldsMemory($rsResult13, $iCont13);
                    $claoc13 = new cl_aoc132023();

                    $claoc13->si41_tiporegistro = 13;
                    $claoc13->si41_codreduzidodecreto = $oDados13->codreduzidodecreto;
                    $claoc13->si41_origemrecalteracao = $oDados13->tipodecretoalteracao;
                    $claoc13->si41_valorabertoorigem = $oDados13->valoraberto;
                    $claoc13->si41_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $claoc13->si41_reg10 = $claoc10->si38_sequencial;
                    $claoc13->si41_instit = $instituicao;

                    $claoc13->incluir(null);
                    if ($claoc13->erro_status == 0) {
                        throw new Exception($claoc13->erro_msg);
                    }

                }

                /**
                 * Registro 14.
                 */
                list($sSql, $rsResult, $rsResult14) = $claoc14->sqlReg14($oDados10);

                $aDadosAgrupados14 = array();
                $aDadosAgrupados15 = array();
                $aCodOrigem = array();

                for ($iCont14 = 0; $iCont14 < pg_num_rows($rsResult); $iCont14++) {

                    $oDadosSql14 = db_utils::fieldsMemory($rsResult, $iCont14);

                    if ($oDadosSql14->tipodecretoalteracao == 3 || $oDadosSql14->tipodecretoalteracao == 98) {

                        $sHash = $oDadosSql14->codreduzidodecreto . $oDadosSql14->codorigem . $oDadosSql14->codorgao . $oDadosSql14->codunidadesub . $oDadosSql14->codfuncao;
                        $sHash .= $oDadosSql14->codsubfuncao . $oDadosSql14->codprograma . $oDadosSql14->idacao . $oDadosSql14->naturezadespesa . $oDadosSql14->codfontrecursos;

                        if ($oDadosSql14->tiporegistro == 14) {
                            $aCodOrigem[$oDadosSql14->o47_codsup][14][] = $sHash;

                            if (!isset($aDadosAgrupados14[$sHash])) {

                                $oDados14 = new stdClass();
                                $oDados14->si42_tiporegistro = 14;
                                $oDados14->si42_codreduzidodecreto = $oDadosSql14->codreduzidodecreto;
                                $oDados14->si42_origemrecalteracao = $oDadosSql14->tipodecretoalteracao;
                                $oDados14->si42_codorigem = $oDadosSql14->codorigem;
                                $oDados14->si42_codorgao = $oDadosSql14->codorgao;
                                $oDados14->si42_codunidadesub = $oDadosSql14->codunidadesub;
                                $oDados14->si42_codfuncao = $oDadosSql14->codfuncao;
                                $oDados14->si42_codsubfuncao = $oDadosSql14->codsubfuncao;
                                $oDados14->si42_codprograma = $oDadosSql14->codprograma;
                                $oDados14->si42_idacao = $oDadosSql14->idacao;
                                $oDados14->si42_idsubacao = $oDadosSql14->idsubacao;
                                $oDados14->si42_naturezadespesa = $oDadosSql14->naturezadespesa;
                                $oDados14->si42_codfontrecursos = $oDadosSql14->codfontrecursos;
                                $oDados14->si42_vlacrescimo = $oDadosSql14->vlacrescimoreducao;
                                $oDados14->si42_codsup = $oDadosSql14->o47_codsup;
                                $oDados14->si42_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                                $oDados14->si42_reg10 = $claoc10->si38_sequencial;
                                $oDados14->si42_instit = $instituicao;
                                $aDadosAgrupados14[$sHash] = $oDados14;

                            } else {

                                $aDadosAgrupados14[$sHash]->si42_vlacrescimo += $oDadosSql14->vlacrescimoreducao;
                            }

                        } else {
                            $aCodOrigem[$oDadosSql14->o47_codsup][15][] = $sHash;

                            if (!isset($aDadosAgrupados15[$sHash])) {

                                $oDados15 = new stdClass();
                                $oDados15->si194_tiporegistro = 15;
                                $oDados15->si194_codreduzidodecreto = $oDadosSql14->codreduzidodecreto;
                                $oDados15->si194_origemrecalteracao = $oDadosSql14->tipodecretoalteracao;
                                $oDados15->si194_codorigem = $oDadosSql14->codorigem;
                                $oDados15->si194_codorgao = $oDadosSql14->codorgao;
                                $oDados15->si194_codunidadesub = $oDadosSql14->codunidadesub;
                                $oDados15->si194_codfuncao = $oDadosSql14->codfuncao;
                                $oDados15->si194_codsubfuncao = $oDadosSql14->codsubfuncao;
                                $oDados15->si194_codprograma = $oDadosSql14->codprograma;
                                $oDados15->si194_idacao = $oDadosSql14->idacao;
                                $oDados15->si194_idsubacao = $oDadosSql14->idsubacao;
                                $oDados15->si194_naturezadespesa = $oDadosSql14->naturezadespesa;
                                $oDados15->si194_codfontrecursos = $oDadosSql14->codfontrecursos;
                                $oDados15->si194_vlreducao = $oDadosSql14->vlacrescimoreducao;
                                $oDados15->si194_codsup = $oDadosSql14->o47_codsup;
                                $oDados15->si194_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                                $oDados15->si194_reg10 = $claoc10->si38_sequencial;
                                $oDados15->si194_instit = $instituicao;
                                $aDadosAgrupados15[$sHash] = $oDados15;

                            } else {

                                $aDadosAgrupados15[$sHash]->si194_vlreducao += $oDadosSql14->vlacrescimoreducao;
                            }
                        }
                    } else {
                        $oDadosSql14Vlr = db_utils::fieldsMemory($rsResult14, $iCont14);
                        if (!empty($oDadosSql14Vlr->tipodecretoalteracao)) {

                            $sHash = $oDadosSql14Vlr->codorgao . $oDadosSql14Vlr->codunidadesub . $oDadosSql14Vlr->codfuncao . $oDadosSql14Vlr->codsubfuncao;
                            $sHash .= $oDadosSql14Vlr->codprograma . $oDadosSql14Vlr->idacao . $oDadosSql14Vlr->naturezadespesa . $oDadosSql14Vlr->codfontrecursos;

                            if (!isset($aDadosAgrupados14[$sHash])) {

                                $oDados14 = new stdClass();
                                $oDados14->si42_tiporegistro = 14;
                                $oDados14->si42_codreduzidodecreto = $oDadosSql14Vlr->codreduzidodecreto;
                                $oDados14->si42_origemrecalteracao = $oDadosSql14Vlr->tipodecretoalteracao;
                                $oDados14->si42_codorigem = $oDadosSql14Vlr->codorigem;
                                $oDados14->si42_codorgao = $oDadosSql14Vlr->codorgao;
                                $oDados14->si42_codunidadesub = $oDadosSql14Vlr->codunidadesub;
                                $oDados14->si42_codfuncao = $oDadosSql14Vlr->codfuncao;
                                $oDados14->si42_codsubfuncao = $oDadosSql14Vlr->codsubfuncao;
                                $oDados14->si42_codprograma = $oDadosSql14Vlr->codprograma;
                                $oDados14->si42_idacao = $oDadosSql14Vlr->idacao;
                                $oDados14->si42_idsubacao = $oDadosSql14Vlr->idsubacao;
                                $oDados14->si42_naturezadespesa = $oDadosSql14Vlr->naturezadespesa;
                                $oDados14->si42_codfontrecursos = $oDadosSql14Vlr->codfontrecursos;
                                $oDados14->si42_vlacrescimo = $oDadosSql14Vlr->vlacrescimoreducao;
                                $oDados14->si42_codsup = $oDadosSql14Vlr->o47_codsup;
                                $oDados14->si42_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                                $oDados14->si42_reg10 = $claoc10->si38_sequencial;
                                $oDados14->si42_instit = $instituicao;
                                $aDadosAgrupados14[$sHash] = $oDados14;

                            } else {
                                $aDadosAgrupados14[$sHash]->si42_vlacrescimo += $oDadosSql14Vlr->vlacrescimoreducao;
                            }
                        }
                    }
                }

                if ($oDadosSql14->tipodecretoalteracao == 3 || $oDadosSql14->tipodecretoalteracao == 98) {

                    $sTipoDecretoReg11 = $claoc11->si39_tipodecretoalteracao;
                    $aTipoDecretoNaoObrigReg15 = array(4, 6, 7);

                    if ($oDadosSql14->tipodecretoalteracao == 98 && in_array($sTipoDecretoReg11, $aTipoDecretoNaoObrigReg15)) {

                        foreach ($aDadosAgrupados14 as $oDadosReg14) {

                            $claoc14 = new cl_aoc142023();

                            $claoc14->si42_tiporegistro = 14;
                            $claoc14->si42_codreduzidodecreto = $oDadosReg14->si42_codreduzidodecreto;
                            $claoc14->si42_codorigem = '';
                            $claoc14->si42_codorgao = $oDadosReg14->si42_codorgao;
                            $claoc14->si42_codunidadesub = $oDadosReg14->si42_codunidadesub;
                            $claoc14->si42_codfuncao = $oDadosReg14->si42_codfuncao;
                            $claoc14->si42_codsubfuncao = $oDadosReg14->si42_codsubfuncao;
                            $claoc14->si42_codprograma = $oDadosReg14->si42_codprograma;
                            $claoc14->si42_idacao = $oDadosReg14->si42_idacao;
                            $claoc14->si42_idsubacao = $oDadosReg14->si42_idsubacao;
                            $claoc14->si42_naturezadespesa = $oDadosReg14->si42_naturezadespesa;
                            $claoc14->si42_codfontrecursos = $oDadosReg14->si42_codfontrecursos;
                            $claoc14->si42_vlacrescimo = $oDadosReg14->si42_vlacrescimo;
                            $claoc14->si42_origemrecalteracao = $oDadosReg14->si42_origemrecalteracao;
                            $claoc14->si42_mes = $oDadosReg14->si42_mes;
                            $claoc14->si42_reg10 = $oDadosReg14->si42_reg10;
                            $claoc14->si42_instit = $oDadosReg14->si42_instit;

                            $claoc14->incluir(null);
                            if ($claoc14->erro_status == 0) {
                                throw new Exception($claoc14->erro_msg);
                            }

                        }
                    } else {


                        foreach ($aDadosAgrupados15 as $oDadosReg14) {

                            $claoc14 = new cl_aoc142023();

                            $claoc14->si42_tiporegistro = 14;
                            $claoc14->si42_codreduzidodecreto = $oDadosReg14->si194_codreduzidodecreto;
                            $claoc14->si42_codorigem = $oDadosReg14->si194_codorigem;
                            $claoc14->si42_codorgao = $aDadosAgrupados14[$aCodOrigem[$oDadosReg14->si194_codsup][14][0]]->si42_codorgao;
                            $claoc14->si42_codunidadesub = $aDadosAgrupados14[$aCodOrigem[$oDadosReg14->si194_codsup][14][0]]->si42_codunidadesub;
                            $claoc14->si42_codfuncao = $aDadosAgrupados14[$aCodOrigem[$oDadosReg14->si194_codsup][14][0]]->si42_codfuncao;
                            $claoc14->si42_codsubfuncao = $aDadosAgrupados14[$aCodOrigem[$oDadosReg14->si194_codsup][14][0]]->si42_codsubfuncao;
                            $claoc14->si42_codprograma = $aDadosAgrupados14[$aCodOrigem[$oDadosReg14->si194_codsup][14][0]]->si42_codprograma;
                            $claoc14->si42_idacao = $aDadosAgrupados14[$aCodOrigem[$oDadosReg14->si194_codsup][14][0]]->si42_idacao;
                            $claoc14->si42_idsubacao = $aDadosAgrupados14[$aCodOrigem[$oDadosReg14->si194_codsup][14][0]]->si42_idsubacao;
                            $claoc14->si42_naturezadespesa = $aDadosAgrupados14[$aCodOrigem[$oDadosReg14->si194_codsup][14][0]]->si42_naturezadespesa;
                            $claoc14->si42_codfontrecursos = $aDadosAgrupados14[$aCodOrigem[$oDadosReg14->si194_codsup][14][0]]->si42_codfontrecursos;
                            $claoc14->si42_vlacrescimo = $oDadosReg14->si194_vlreducao;
                            $claoc14->si42_origemrecalteracao = $oDadosReg14->si194_origemrecalteracao;
                            $claoc14->si42_mes = $oDadosReg14->si194_mes;
                            $claoc14->si42_reg10 = $oDadosReg14->si194_reg10;
                            $claoc14->si42_instit = $oDadosReg14->si194_instit;

                            $claoc14->incluir(null);
                            if ($claoc14->erro_status == 0) {
                                throw new Exception($claoc14->erro_msg);
                            }

                        }

                        /**
                         * 15 - Alterações Orçamentárias de Redução
                         * Novo Registro Inserido a partir de 2023, conforme layout Versão 8.0_2023                         *
                         */

                        foreach ($aDadosAgrupados15 as $oDadosReg15) {

                            $claoc15 = new cl_aoc152023();

                            $claoc15->si194_tiporegistro = $oDadosReg15->si194_tiporegistro;
                            $claoc15->si194_codreduzidodecreto = $oDadosReg15->si194_codreduzidodecreto;
                            $claoc15->si194_codorigem = $oDadosReg15->si194_codorigem;
                            $claoc15->si194_codorgao = $oDadosReg15->si194_codorgao;
                            $claoc15->si194_codunidadesub = $oDadosReg15->si194_codunidadesub;
                            $claoc15->si194_codfuncao = $oDadosReg15->si194_codfuncao;
                            $claoc15->si194_codsubfuncao = $oDadosReg15->si194_codsubfuncao;
                            $claoc15->si194_codprograma = $oDadosReg15->si194_codprograma;
                            $claoc15->si194_idacao = $oDadosReg15->si194_idacao;
                            $claoc15->si194_idsubacao = $oDadosReg15->si194_idsubacao;
                            $claoc15->si194_naturezadespesa = $oDadosReg15->si194_naturezadespesa;
                            $claoc15->si194_codfontrecursos = $oDadosReg15->si194_codfontrecursos;
                            $claoc15->si194_vlreducao = $oDadosReg15->si194_vlreducao;
                            $claoc15->si194_origemrecalteracao = $oDadosReg15->si194_origemrecalteracao;
                            $claoc15->si194_mes = $oDadosReg15->si194_mes;
                            $claoc15->si194_reg10 = $oDadosReg15->si194_reg10;
                            $claoc15->si194_instit = $oDadosReg15->si194_instit;

                            $claoc15->incluir(null);
                            if ($claoc15->erro_status == 0) {
                                throw new Exception($claoc15->erro_msg);
                            }

                        }

                    }
                } else {
                    foreach ($aDadosAgrupados14 as $oDadosReg14) {

                        $claoc14 = new cl_aoc142023();

                        $claoc14->si42_tiporegistro = 14;
                        $claoc14->si42_codreduzidodecreto = $oDadosReg14->si42_codreduzidodecreto;
                        $claoc14->si42_codorigem = '';
                        $claoc14->si42_codorgao = $oDadosReg14->si42_codorgao;
                        $claoc14->si42_codunidadesub = $oDadosReg14->si42_codunidadesub;
                        $claoc14->si42_codfuncao = $oDadosReg14->si42_codfuncao;
                        $claoc14->si42_codsubfuncao = $oDadosReg14->si42_codsubfuncao;
                        $claoc14->si42_codprograma = $oDadosReg14->si42_codprograma;
                        $claoc14->si42_idacao = $oDadosReg14->si42_idacao;
                        $claoc14->si42_idsubacao = $oDadosReg14->si42_idsubacao;
                        $claoc14->si42_naturezadespesa = $oDadosReg14->si42_naturezadespesa;
                        $claoc14->si42_codfontrecursos = $oDadosReg14->si42_codfontrecursos;
                        $claoc14->si42_vlacrescimo = $oDadosReg14->si42_vlacrescimo;
                        $claoc14->si42_origemrecalteracao = $oDadosReg14->si42_origemrecalteracao;
                        $claoc14->si42_mes = $oDadosReg14->si42_mes;
                        $claoc14->si42_reg10 = $oDadosReg14->si42_reg10;
                        $claoc14->si42_instit = $oDadosReg14->si42_instit;

                        $claoc14->incluir(null);
                        if ($claoc14->erro_status == 0) {
                            throw new Exception($claoc14->erro_msg);
                        }

                    }
                }

            }
        }
        db_fim_transacao();

        $oGerarAOC = new GerarAOC();
        $oGerarAOC->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];;
        $oGerarAOC->gerarDados();

    }

}
