<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_ctb102024_classe.php");
require_once("classes/db_ctb202024_classe.php");
require_once("classes/db_ctb212024_classe.php");
require_once("classes/db_ctb222024_classe.php");
require_once("classes/db_ctb302024_classe.php");
require_once("classes/db_ctb312024_classe.php");
require_once("classes/db_ctb402024_classe.php");
require_once("classes/db_ctb502024_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2024/GerarCTB.model.php");
require_once("model/orcamento/DeParaRecurso.model.php");
require_once("model/orcamento/ControleOrcamentario.model.php");


/**
 * Contas bancarias Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoContasBancarias extends SicomArquivoBase implements iPadArquivoBaseCSV
{

    /**
     *
     * Codigo do layout. (db_layouttxt.db50_codigo)
     * @var Integer
     */
    protected $iCodigoLayout = 164;

    /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'CTB';

    /**
     * @var array Tipo Entrada/Saída que devem informar conta
     */
    protected $aTiposObrigConta = array(5, 6, 7, 9, 96, 95);

    /**
     * @var array Tipo Entrada/Saída que devem informar fonte
     */
    protected $aTiposObrigFonte = array(5, 6, 7, 9, 11, 18, 95, 96);

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

    }

    public function setEncerramentoCtb($iEncerramento)
    {
        if ($iEncerramento == 1) {
            $this->bEncerramento = true;
        }
    }

    /**
     * selecionar os dados das contas bancarias
     * @throws Exception
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados()
    {


        $cCtb10 = new cl_ctb102024();
        $cCtb20 = new cl_ctb202024();
        $cCtb21 = new cl_ctb212024();
        $cCtb22 = new cl_ctb222024();
        $cCtb40 = new cl_ctb402024();
        $cCtb50 = new cl_ctb502024();

        // matriz de entrada
        $what = array("°", chr(13), chr(10), 'ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'Ã', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º');

        // matriz de saída
        $by = array('', '', '', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ');

        /**
         * selecionar arquivo xml com dados das receitas
         */
        $sSql = "SELECT * FROM db_config ";
        $sSql .= "	WHERE prefeitura = 't'";

        $rsInst = db_query($sSql);
        $sCnpj = db_utils::fieldsMemory($rsInst, 0)->cgc;
        $sArquivo = "config/sicom/" . db_getsession("DB_anousu") . "/{$sCnpj}_sicomnaturezareceita.xml";

        $sTextoXml = file_get_contents($sArquivo);
        $oDOMDocument = new DOMDocument();
        $oDOMDocument->loadXML($sTextoXml);
        $oNaturezaReceita = $oDOMDocument->getElementsByTagName('receita');

        /**
         * Variaveis de uso comum
         */
        $ano = db_getsession("DB_anousu");
        $instit = db_getsession("DB_instit");
        $mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

        $this->registrosAnteriores($cCtb20, $mes, $instit, $cCtb50, $cCtb40, $cCtb22, $cCtb21, $cCtb10);

        list($sSqlGeral, $aBancosAgrupados, $aRectce, $oRegistro10, $cCtb10) = $this->registro10($cCtb10, $mes, $what, $by, $ano, $instit);

        /**
         * Regras para gerar Registros 20 e 21
        */
        $aCtb20Agrupado = array();
        $aCtb21 = array();

        foreach ($aBancosAgrupados as $oContaAgrupada) {

            foreach ($oContaAgrupada->contas as $oConta) {

                $codtce = false;

                if (!empty($oConta->codtce)){
                    $oConta->codctb = $oConta->codtce;
                    $codtce = true;
                }

                if (($oConta->codtce != $codTce20) || empty($oConta->codtce)){

                    $sSql20Fonte = $cCtb20->sql_Reg20Fonte($oConta->codctb, db_getsession("DB_anousu"), $mes, $codtce);
                    $rsReg20Fonte = $cCtb20->sql_record($sSql20Fonte) or die($sSql20Fonte);

                    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsReg20Fonte); $iCont20++) {

                        list($iFonte, $sHash20, $oCtb20, $aCtb20Agrupado) = $this->gerarRegistro20($rsReg20Fonte, $iCont20, $oConta, $aCtb20Agrupado, $oContaAgrupada, $codtce);

                        if (isset($aCtb21[$sHash20])) {
                            continue;
                        }

                        /**
                         * Dados Registro 21
                         */
                        $clDeParaFonte = new DeParaRecurso;

                        $rsMovi21 = $cCtb21->sql_Reg21($this->sDataFinal, $ano, $mes, $oCtb20->si96_codctb, $iFonte, $clDeParaFonte, $instit, $codtce);

                        $aCtb21[$sHash20] = db_utils::fieldsMemory($rsMovi21, 0);

                        if (pg_num_rows($rsMovi21) != 0) {

                            for ($iCont21 = 0; $iCont21 < pg_num_rows($rsMovi21); $iCont21++) {

                                $oMovi = db_utils::fieldsMemory($rsMovi21, $iCont21);

                                $nValor = $oMovi->valorentrsaida;

                                $iCodSis = 0;
                                $conta = 0;
                                $instituicao = db_getsession("DB_instit");

                                if ($oMovi->codctbtransf != 0 && $oMovi->codctbtransf != '') {

                                    $sqlcontatransf = $cCtb21->contaTransf($instituicao, $ano, $oMovi->codctbtransf);
                                    $rsConta = $cCtb21->sql_record($sqlcontatransf);

                                    if (pg_num_rows($rsConta) == 0) {
                                        $sSql = $cCtb21->sql_codSisReg21($ano, $oMovi->codctbtransf);
                                        $rsCodSis = db_query($sSql);
                                        /**
                                         * Se o c60_codsis for 5, essa eh uma conta caixa
                                         */
                                        $iCodSis = db_utils::fieldsMemory($rsCodSis, 0)->c60_codsis;
                                    } else {

                                        $contaTransf = db_utils::fieldsMemory($rsConta, 0)->contadebito;
                                        $contaTransfTipo = db_utils::fieldsMemory($rsConta, 0)->tipo;

                                        if ($oRegistro10->si09_tipoinstit == 5 && $contaTransfTipo == 2) {

                                            $contaTransf .= db_utils::fieldsMemory($rsConta, 0)->tipoaplicacao;
                                            $contaTransf .= db_utils::fieldsMemory($rsConta, 0)->nroseqaplicacao;
                                        }

                                        $conta = $aBancosAgrupados[$contaTransf]->si95_codctb;
                                    }
                                } else {
                                    $conta = 0;
                                    $recurso = 0;
                                    $iCodSis = 0;
                                }


                                $sHash = $oMovi->tiporegistro;
                                $sHash .= $oCtb20->si96_codctb;
                                $sHash .= $oCtb20->si96_codfontrecursos;
                                $sHash .= $oMovi->tipomovimentacao;
                                $sHash .= $oMovi->saldocec;

                                /**
                                 * Quando o codctb for igual codctbtransf, será agrupado a movimentação no tipoentrsaida 99
                                 */
                                if (($iCodSis != '' || $iCodSis != 0) && ($oMovi->codsisctb == 6 && $iCodSis == 5) && $oMovi->tipomovimentacao == 2) {
                                    $iTipoEntrSaida = '11';
                                } elseif (($iCodSis != '' || $iCodSis != 0) && ($oMovi->codsisctb == 6 && $iCodSis == 5) && $oMovi->tipomovimentacao == 1) {
                                    $iTipoEntrSaida = '18';
                                } elseif (($iCodSis == 5) || ($oCtb20->si96_codctb == $conta) || ($oMovi->retencao == 1 && $oMovi->tipoentrsaida == 8)) {
                                    $iTipoEntrSaida = '99';
                                } else {
                                    $iTipoEntrSaida = $oMovi->tipoentrsaida;
                                }

                                $sHash .= $iTipoEntrSaida;
                                $sHash .= (in_array($oMovi->tipoentrsaida, $this->aTiposObrigConta) && ($iCodSis != 5) && ($oCtb20->si96_codctb != $conta)) ? $conta : 0;
                                $sHash .= ((in_array($oMovi->tipoentrsaida, $this->aTiposObrigFonte) && ($iCodSis != 5) && ($oCtb20->si96_codctb != $conta)) ? $oMovi->codfontectbtransf : 0);

                                $this->gerarRegistro21($oCtb20, $sHash, $oMovi, $iTipoEntrSaida, $nValor, $iCodSis, $conta);

                                $sSql = $cCtb22->sql_Reg22($ano, $oMovi->codreduzido);
                                $rsReceita = $cCtb22->sql_record($sSql);

                                $this->gerarRegistro22($rsReceita, $oCtb20, $sHash, $oNaturezaReceita, $aRectce, $instit);
                            }
                        }

                        $aCtb20Agrupado[$sHash20] = $oCtb20;
                    }

                }
                $codTce20 = db_utils::fieldsMemory($rsReg20Fonte, 0)->c61_codtce;

                if (pg_num_rows($rsReg20Fonte) == 0) {

                    list($iFonte, $oCtb20, $aCtb20Agrupado) = $this->gerarReg20SemContaCorrente($oConta, $aCtb20Agrupado, $oContaAgrupada);
                }

            }
        }

        $this->registro40($sSqlGeral, $cCtb10, $ano, $instit, $mes, $cCtb40);

        $this->registro50($cCtb50, $ano, $instit);

//        $oCtb20 = $this->fontesEncerradas($aCtb20Agrupado, $oContaAgrupada);

        /**
         * Inclusão do registro 20 e 21 do procedimento normal
         */
        foreach ($aCtb20Agrupado as $oCtb20) {

            $cCtb20 = new cl_ctb202024();

            $cCtb20->si96_tiporegistro = $oCtb20->si96_tiporegistro;
            $cCtb20->si96_codorgao = $oCtb20->si96_codorgao;
            $cCtb20->si96_codctb = $oCtb20->si96_codctb;
            $cCtb20->si96_codfontrecursos = $oCtb20->si96_codfontrecursos;
            $cCtb20->si96_saldocec = $oCtb20->si96_saldocec;
            $cCtb20->si96_vlsaldoinicialfonte = $oCtb20->si96_vlsaldoinicialfonte;
            $cCtb20->si96_vlsaldofinalfonte = (abs(number_format($oCtb20->si96_vlsaldofinalfonte, 2, ".", "")) == 0) ? 0 : $oCtb20->si96_vlsaldofinalfonte;
            $cCtb20->si96_mes = $oCtb20->si96_mes;
            $cCtb20->si96_instit = $oCtb20->si96_instit;

            $cCtb20->incluir(null);
            if ($cCtb20->erro_status == 0) {
                throw new Exception($cCtb20->erro_msg);
            }

            foreach ($oCtb20->ctb21 as $oCtb21agrupado) {

                $cCtb21 = new cl_ctb212024();

                $cCtb21->si97_tiporegistro = $oCtb21agrupado->si97_tiporegistro;
                $cCtb21->si97_codctb = $oCtb21agrupado->si97_codctb;
                $cCtb21->si97_codfontrecursos = $oCtb21agrupado->si97_codfontrecursos;
                $cCtb21->si97_codreduzidomov = $oCtb21agrupado->si97_codreduzidomov;
                $cCtb21->si97_tipomovimentacao = $oCtb21agrupado->si97_tipomovimentacao;
                $cCtb21->si97_saldocectransf = $oCtb21agrupado->si97_saldocectransf;
                $cCtb21->si97_saldocec = $oCtb21agrupado->si97_saldocec;
                $cCtb21->si97_tipoentrsaida = $oCtb21agrupado->si97_tipoentrsaida;
                $cCtb21->si97_valorentrsaida = abs($oCtb21agrupado->si97_valorentrsaida);
                $cCtb21->si97_dscoutrasmov = ($oCtb21agrupado->si97_tipoentrsaida == 99 ? 'Recebimento Extra-Orçamentário' : ($oCtb21agrupado->si97_tipoentrsaida == 10 ? $oCtb21agrupado->si97_dscoutrasmov : ' '));

                $cCtb21->si97_codctbtransf = ($oCtb21agrupado->si97_tipoentrsaida == 5 || $oCtb21agrupado->si97_tipoentrsaida == 6
                    || $oCtb21agrupado->si97_tipoentrsaida == 7 || $oCtb21agrupado->si97_tipoentrsaida == 9
                    || $oCtb21agrupado->si97_tipoentrsaida == 95 || $oCtb21agrupado->si97_tipoentrsaida == 96) ? $oCtb21agrupado->si97_codctbtransf : 0;

                $cCtb21->si97_codfontectbtransf = ($oCtb21agrupado->si97_tipoentrsaida == 5 || $oCtb21agrupado->si97_tipoentrsaida == 6
                    || $oCtb21agrupado->si97_tipoentrsaida == 7 || $oCtb21agrupado->si97_tipoentrsaida == 9
                    || $oCtb21agrupado->si97_tipoentrsaida == 95 || $oCtb21agrupado->si97_tipoentrsaida == 96) ? $oCtb21agrupado->si97_codfontectbtransf : 0;

                $cCtb21->si97_codidentificafr = ($oCtb21agrupado->si97_tipoentrsaida == 94 ? $oCtb21agrupado->si97_codidentificafr : 'null');
                $cCtb21->si97_mes = $oCtb21agrupado->si97_mes;
                $cCtb21->si97_reg20 = $cCtb20->si96_sequencial;
                $cCtb21->si97_instit = $oCtb21agrupado->si97_instit;

                $cCtb21->incluir(null);
                if ($cCtb21->erro_status == 0) {
                    throw new Exception($cCtb21->erro_msg);
                }


                foreach ($oCtb21agrupado->registro22 as $oCtb22Agrupado) {

                    $cCtb22 = new cl_ctb222024();

                    $cCtb22->si98_tiporegistro = $oCtb22Agrupado->si98_tiporegistro;
                    $cCtb22->si98_codreduzidomov = $oCtb22Agrupado->si98_codreduzidomov;
                    $cCtb22->si98_ededucaodereceita = $oCtb22Agrupado->si98_ededucaodereceita;
                    $cCtb22->si98_identificadordeducao = $oCtb22Agrupado->si98_identificadordeducao;
                    $cCtb22->si98_naturezareceita = $oCtb22Agrupado->si98_naturezareceita;
                    $cCtb22->si98_codfontrecursos = $oCtb21agrupado->si97_codfontrecursos;
                    $cCtb22->si98_codco = $oCtb22Agrupado->si98_codco;
                    $cCtb22->si98_vlrreceitacont = $oCtb22Agrupado->si98_vlrreceitacont;
                    $cCtb22->si98_saldocec = $oCtb22Agrupado->si98_saldocec;
                    $cCtb22->si98_mes = $oCtb22Agrupado->si98_mes;
                    $cCtb22->si98_reg21 = $cCtb21->si97_sequencial;
                    $cCtb22->si98_instit = $oCtb22Agrupado->si98_instit;

                    $cCtb22->incluir(null);
                    if ($cCtb22->erro_status == 0) {
                        throw new Exception($cCtb22->erro_msg);
                    }
                }
            }
        }

        $oGerarCTB = new GerarCTB();
        $oGerarCTB->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oGerarCTB->gerarDados();
    }

    /**
     * @param bool $rsReg20Fonte
     * @param int $iCont20
     * @param $oConta
     * @param array $aCtb20Agrupado
     * @param $oContaAgrupada
     * @return array
     */
    public function gerarRegistro20($rsReg20Fonte, int $iCont20, $oConta, array $aCtb20Agrupado, $oContaAgrupada, $codtce): array
    {
        $clDeParaFonte = new DeParaRecurso;

        $codCtbReg20 = db_utils::fieldsMemory($rsReg20Fonte, $iCont20);
        $codCtb = empty($codCtbReg20->c61_codtce) ? $codCtbReg20->c61_reduz : $codCtbReg20->c61_codtce;

        $iFonte = db_utils::fieldsMemory($rsReg20Fonte, $iCont20)->fontemovimento;

        if (strlen($iFonte) == 4){
            $iFonte = db_utils::fieldsMemory($rsReg20Fonte, $iCont20)->o15_codtri;
        }
        $iFonte = substr($clDeParaFonte->getDePara($iFonte), 0, 7);

        $sinalSaldoInicial = db_utils::fieldsMemory($rsReg20Fonte, $iCont20)->nat_vlr_si;
        $sinalSaldoFinal = db_utils::fieldsMemory($rsReg20Fonte, $iCont20)->nat_vlr_sf;

        $saldoInicial = db_utils::fieldsMemory($rsReg20Fonte, $iCont20)->saldoinicial;
        $saldoFinal = db_utils::fieldsMemory($rsReg20Fonte, $iCont20)->saldofinal;

        $saldoInicial = $sinalSaldoInicial == 'C' ? $saldoInicial *-1 : $saldoInicial;
        $saldoFinal = $sinalSaldoFinal == 'C' ? $saldoFinal *-1 : $saldoFinal;

        $sHash20 = $codCtb . $iFonte;

        if ($codtce){
            $sHash20 = $oConta->codtce . $iFonte;
        }

        if (!$aCtb20Agrupado[$sHash20]) {

            $oCtb20 = new stdClass();
            $oCtb20->si96_tiporegistro = '20';
            $oCtb20->si96_codorgao = $oContaAgrupada->si95_codorgao;
            $oCtb20->si96_codctb = $codCtb;
            $oCtb20->si96_codfontrecursos = $iFonte;
            $oCtb20->si96_saldocec = $oConta->saldocec;
            $oCtb20->si96_vlsaldoinicialfonte = $saldoInicial;
            $oCtb20->si96_vlsaldofinalfonte = $saldoFinal;
            $oCtb20->si96_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $oCtb20->si96_instit = db_getsession("DB_instit");
            $oCtb20->iFontePrincipal = $oConta->recurso;
            $oCtb20->nat_vlr_si = $sinalSaldoInicial;
            $oCtb20->nat_vlr_sf = $sinalSaldoFinal;
            $oCtb20->ctb21 = array();
            $aCtb20Agrupado[$sHash20] = $oCtb20;
        } else {
            $oCtb20 = $aCtb20Agrupado[$sHash20];
            $oCtb20->si96_vlsaldoinicialfonte += $saldoInicial;
            $oCtb20->si96_vlsaldofinalfonte += $saldoFinal;
        }

        return array($iFonte, $sHash20, $oCtb20, $aCtb20Agrupado);
    }

    /**
     * @param $oCtb20
     * @param string $sHash
     * @param $oMovi
     * @param string $iTipoEntrSaida
     * @param $nValor
     * @param int $iCodSis
     * @param $conta
     * @return stdClass
     */
    public function gerarRegistro21($oCtb20, string $sHash, $oMovi, string $iTipoEntrSaida, $nValor, int $iCodSis, $conta)
    {
        if (!isset($oCtb20->ctb21[$sHash])) {

            $oDadosMovi21 = new stdClass();

            $codReduzidoMov = $oMovi->codreduzido . substr($oCtb20->si96_codfontrecursos, 0, 4) . $oMovi->tipomovimentacao;

            $oDadosMovi21->si97_tiporegistro = $oMovi->tiporegistro;
            $oDadosMovi21->si97_codctb = $oCtb20->si96_codctb;
            $oDadosMovi21->si97_codfontrecursos = $oCtb20->si96_codfontrecursos;
            $oDadosMovi21->si97_codreduzidomov = $codReduzidoMov;
            $oDadosMovi21->si97_tipomovimentacao = $oMovi->tipomovimentacao;
            $oDadosMovi21->si97_tipoentrsaida = $iTipoEntrSaida;
            $oDadosMovi21->si97_valorentrsaida = $nValor;
            $oDadosMovi21->si97_saldocec = $oMovi->saldocec;
            $oDadosMovi21->si97_dscoutrasmov = ($oMovi->tipoentrsaida == 99 ? 'Recebimento Extra Orcamentario' : ($iTipoEntrSaida == 10 ? 'Estorno de recebimentos' : ' '));

            $oDadosMovi21->si97_codctbtransf = (in_array($iTipoEntrSaida, $this->aTiposObrigConta)
                && ($iCodSis != 5) && ($oCtb20->si96_codctb != $conta)) ? $conta : 0;

            $oDadosMovi21->si97_codfontectbtransf = (in_array($iTipoEntrSaida, $this->aTiposObrigFonte)
                && ($iCodSis != 5 || ($iCodSis == 5 && ($iTipoEntrSaida == 11 || $iTipoEntrSaida == 18))) && ($oCtb20->si96_codctb != $conta)) ? $oMovi->fontemovimento : 0;

            $oDadosMovi21->si97_saldocectransf = (in_array($iTipoEntrSaida, $this->aTiposObrigFonte)
                && ($iCodSis != 5 || ($iCodSis == 5 && $iTipoEntrSaida == 11 && $oMovi->tipomovimentacao != 2)) && ($oCtb20->si96_codctb != $conta)) ? $oMovi->saldocectransf : 0;

            $oDadosMovi21->si97_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $oDadosMovi21->si97_instit = db_getsession("DB_instit");
            $oDadosMovi21->registro22 = array();

            $oCtb20->ctb21[$sHash] = $oDadosMovi21;
        } else {
            $oCtb20->ctb21[$sHash]->si97_valorentrsaida += $nValor;
        }
        return $oDadosMovi21;
    }

    /**
     * @param bool $rsReceita
     * @param $oCtb20
     * @param string $sHash
     * @param $oNaturezaReceita
     * @param array $aRectce
     * @param $instit
     * @return void
     */
    public function gerarRegistro22($rsReceita, $oCtb20, string $sHash, $oNaturezaReceita, array $aRectce, $instit): void
    {
        $aTipoEntSaida = array('1', '2', '3', '4', '15', '16');
        if (pg_num_rows($rsReceita) != 0 && (in_array($oCtb20->ctb21[$sHash]->si97_tipoentrsaida, $aTipoEntSaida))) {

            $oReceita = db_utils::fieldsMemory($rsReceita, 0);

            $sEmParlamentar = $oReceita->k81_emparlamentar == '' ? '3' : $oReceita->k81_emparlamentar;

            $oControleOrcamentario = new ControleOrcamentario();
            $oControleOrcamentario->setNaturezaReceita("4" . $oReceita->naturezareceita);
            $oControleOrcamentario->setFonte($oReceita->o70_codigo);
            $oControleOrcamentario->setEmendaParlamentar($sEmParlamentar);

            $sNaturezaReceita = $oReceita->naturezareceita;
            foreach ($oNaturezaReceita as $oNatureza) {

                if (
                    $oNatureza->getAttribute('instituicao') == db_getsession("DB_instit")
                    && $oNatureza->getAttribute('receitaEcidade') == $sNaturezaReceita
                ) {
                    $oReceita->naturezareceita = $oNatureza->getAttribute('receitaSicom');
                    break;
                }
            }


            if (in_array(substr($oReceita->naturezareceita, 0, 6), $aRectce)) {
                $oReceita->naturezareceita = substr($oReceita->naturezareceita, 0, 6) . "00";
            }

            $sHash22 = $oReceita->naturezareceita . $oCtb20->ctb21[$sHash]->si97_codreduzidomov;
            $sHash22 .= in_array($oControleOrcamentario->getCodigoPorReceita(), array('1001', '1002', '1070')) ? '0000' : $oControleOrcamentario->getCodigoPorReceita();

            if (!isset($oCtb20->ctb21[$sHash]->registro22[$sHash22])) {

                $oDadosReceita = new stdClass();

                $oDadosReceita->si98_tiporegistro = $oReceita->tiporegistro;
                $oDadosReceita->si98_codreduzidomov = $oCtb20->ctb21[$sHash]->si97_codreduzidomov;
                $oDadosReceita->si98_ededucaodereceita = $oReceita->ededucaodereceita;
                $oDadosReceita->si98_identificadordeducao = $oReceita->identificadordeducao;
                $oDadosReceita->si98_naturezareceita = $oReceita->naturezareceita;
                $oDadosReceita->si98_codfontrecursos = $oCtb20->ctb21[$sHash]->si97_codfontrecursos;
                $oDadosReceita->si98_codco = in_array($oControleOrcamentario->getCodigoPorReceita(), array('1001', '1002', '1070')) ? '0000' : $oControleOrcamentario->getCodigoPorReceita();
                $oDadosReceita->si98_saldocec = $oCtb20->ctb21[$sHash]->si97_saldocec;
                $oDadosReceita->si98_vlrreceitacont = $oReceita->vlrreceitacont;
                $oDadosReceita->si98_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $oDadosReceita->si98_reg20 = 0;
                $oDadosReceita->si98_instit = $instit;


                $oCtb20->ctb21[$sHash]->registro22[$sHash22] = $oDadosReceita;
            } else {
                $oCtb20->ctb21[$sHash]->registro22[$sHash22]->si98_vlrreceitacont += $oReceita->vlrreceitacont;
            }
        }
    }

    /**
     * @param $oConta
     * @param $aCtb20Agrupado
     * @param $oContaAgrupada
     * @param $cCtb20
     * @return array
     */
    public function gerarReg20SemContaCorrente($oConta, $aCtb20Agrupado, $oContaAgrupada): array
    {
        $cCtb20 = new cl_ctb202024();
        $instituicao = db_getsession("DB_instit");

        $iAnoUsu = db_getsession("DB_anousu");
        $sDataInicial = $this->sDataInicial;
        $sDataFinal = $this->sDataFinal;

        $sqlBalancete = $cCtb20->saldosBalancete($iAnoUsu, $instituicao, $oConta, $sDataInicial, $sDataFinal);
        $rsBalancete = db_query($sqlBalancete);

        $clDeParaFonte = new DeParaRecurso;

        $iFonte = db_utils::fieldsMemory($rsBalancete, 0)->c61_codigo;
        $iFonte = strlen($iFonte) <= 4 ? substr($clDeParaFonte->getDePara($iFonte), 0, 7) : substr($iFonte, 0, 7);

        $saldoInicial = db_utils::fieldsMemory($rsBalancete, 0)->saldo_anterior;
        $saldoFinal = db_utils::fieldsMemory($rsBalancete, 0)->saldo_final;

        $sinal_anterior = db_utils::fieldsMemory($rsBalancete, 0)->sinal_anterior;
        $sinal_final = db_utils::fieldsMemory($rsBalancete, 0)->sinal_final;

        $saldoInicial = $sinal_anterior == 'C' ? $saldoInicial *-1 : $saldoInicial;
        $saldoFinal = $sinal_final == 'C' ? $saldoFinal *-1 : $saldoFinal;

        $codCtbReg20 = db_utils::fieldsMemory($rsBalancete, 0);
        $codCtb = empty($codCtbReg20->c61_codtce) ? $codCtbReg20->c61_reduz : $codCtbReg20->c61_codtce;

        $sHash20 = $oConta->codctb . $iFonte;

        if (!$aCtb20Agrupado[$sHash20]) {

            $oCtb20 = new stdClass();
            $oCtb20->si96_tiporegistro = '20';
            $oCtb20->si96_codorgao = $oContaAgrupada->si95_codorgao;
            $oCtb20->si96_codctb = $codCtb;
            $oCtb20->si96_codfontrecursos = $iFonte;
            $oCtb20->si96_saldocec = $oConta->saldocec;
            $oCtb20->si96_vlsaldoinicialfonte = $saldoInicial;
            $oCtb20->si96_vlsaldofinalfonte = $saldoFinal;
            $oCtb20->si96_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $oCtb20->si96_instit = $instituicao;
            $oCtb20->iFontePrincipal = $oConta->recurso;
            $oCtb20->ctb21 = array();
            $aCtb20Agrupado[$sHash20] = $oCtb20;
        } else {
            $oCtb20 = $aCtb20Agrupado[$sHash20];
            $oCtb20->si96_vlsaldoinicialfonte += $saldoInicial;
            $oCtb20->si96_vlsaldofinalfonte += $saldoFinal;
        }
        return array($iFonte, $oCtb20, $aCtb20Agrupado);
    }

    /**
     * @param cl_ctb102024 $cCtb10
     * @param string $mes
     * @param array $what
     * @param array $by
     * @param $ano
     * @param $instit
     * @return array
     * @throws Exception
     */
    public function registro10(cl_ctb102024 $cCtb10, string $mes, array $what, array $by, $ano, $instit): array
    {
        $sSqlGeral = $cCtb10->sql_Reg10(db_getsession("DB_anousu"), db_getsession("DB_instit"), $mes, $this->sDataFinal);
        $rsContas = $cCtb10->sql_record($sSqlGeral);

        $aBancosAgrupados = array();
        /* RECEITAS QUE DEVEM SER SUBSTIUIDAS RUBRICA CADASTRADA ERRADA */
        $aRectce = array('111202', '111208', '172136', '191138', '191139', '191140',
            '191308', '191311', '191312', '191313', '193104', '193111',
            '193112', '193113', '172401', '247199', '247299');

        for ($iCont = 0; $iCont < pg_num_rows($rsContas); $iCont++) {

            $oRegistro10 = db_utils::fieldsMemory($rsContas, $iCont);


            $aHash = $oRegistro10->si09_codorgaotce;
            $aHash .= intval($oRegistro10->c63_banco);
            $aHash .= intval($oRegistro10->c63_agencia);
            $aHash .= $oRegistro10->c63_dvagencia;
            $aHash .= intval($oRegistro10->c63_conta);
            $aHash .= $oRegistro10->c63_dvconta;
            $aHash .= $oRegistro10->tipoconta;

            // Instituição RPPS.
            if ($oRegistro10->si09_tipoinstit == 5) {
                $aHash .= $oRegistro10->tipoaplicacao;
                $aHash .= $oRegistro10->nroseqaplicacao;
            }

            if (!isset($aBancosAgrupados[$aHash])) {

                $cCtb10 = new cl_ctb102024();


                $cCtb10->si95_tiporegistro = $oRegistro10->tiporegistro;
                $cCtb10->si95_codctb = $oRegistro10->codtce != 0 ? $oRegistro10->codtce : $oRegistro10->codctb;
                $cCtb10->si95_codorgao = $oRegistro10->si09_codorgaotce;
                $cCtb10->si95_banco = $oRegistro10->c63_banco;
                $cCtb10->si95_agencia = $oRegistro10->c63_agencia;
                $cCtb10->si95_digitoverificadoragencia = $oRegistro10->c63_dvagencia;
                $cCtb10->si95_contabancaria = $oRegistro10->c63_conta;
                $cCtb10->si95_digitoverificadorcontabancaria = $oRegistro10->c63_dvconta;
                $cCtb10->si95_tipoconta = $oRegistro10->tipoconta;
                $cCtb10->si95_nroseqaplicacao = $oRegistro10->nroseqaplicacao;
                $cCtb10->si95_desccontabancaria = preg_replace("/[^a-zA-Z0-9 ]/", "", str_replace($what, $by, substr($oRegistro10->desccontabancaria, 0, 50)));
                $cCtb10->si95_contaconvenio = $oRegistro10->contaconvenio;
                $cCtb10->si95_nroconvenio = $oRegistro10->nroconvenio;
                $cCtb10->si95_dataassinaturaconvenio = $oRegistro10->dataassinaturaconvenio;
                $cCtb10->si95_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $cCtb10->si95_instit = db_getsession("DB_instit");
                $cCtb10->recurso = $oRegistro10->recurso;
                $cCtb10->contas = array();


                $sSqlVerifica = $cCtb10->verificaExisteReg10($oRegistro10, db_getsession('DB_instit'), $this->sDataFinal['5'] . $this->sDataFinal['6'], db_getsession("DB_anousu"));
                $rsResultVerifica = $cCtb10->sql_record($sSqlVerifica);

                /**
                 * Verifica data de cadastro da conta
                 **/
                $sSqlDtCad = $cCtb10->verificaDtCadastro($oRegistro10, $ano, $instit);
                $rsResultDtCad = db_query($sSqlDtCad);

                $oDtCadastro = db_utils::fieldsMemory($rsResultDtCad, 0);

                /**
                 * Verificação se a data de cadastro da conta está dentro do periodo de geração do arquivo.
                 */
                if ((pg_num_rows($rsResultVerifica) == 0) && ($oDtCadastro->k13_dtimplantacao <= $this->sDataFinal)) {

                    $cCtb10->incluir(null);

                    if ($cCtb10->erro_status == 0) {
                        throw new Exception($cCtb10->erro_msg);
                    }
                }

                $cCtb10->si95_codctb = $oRegistro10->codtce != 0 ? $oRegistro10->codtce : $oRegistro10->codctb;

                $oConta = new stdClass();
                $oConta->codctb = $oRegistro10->codctb;
                $oConta->codtce = $oRegistro10->codtce;
                $oConta->fonte = $oRegistro10->recurso;
                $oConta->saldocec = $oRegistro10->saldocec;

                $cCtb10->contas[] = $oConta;
                $aBancosAgrupados[$aHash] = $cCtb10;
            } else {
                $oConta = new stdClass();
                $oConta->codctb = $oRegistro10->codctb;
                $oConta->codtce = $oRegistro10->codtce;
                $oConta->saldocec = $oRegistro10->saldocec;
                $oConta->fonte = $oRegistro10->recurso;
                $oConta->recurso = $aBancosAgrupados[$aHash]->contas[0]->recurso;

                $aBancosAgrupados[$aHash]->contas[] = $oConta;
            }
        }
        return array($sSqlGeral, $aBancosAgrupados, $aRectce, $oRegistro10, $cCtb10, $sSqlVerifica, $sSqlDtCad, $rsResultDtCad, $oConta);
    }

    /**
     * @param cl_ctb202024 $cCtb20
     * @param string $mes
     * @param $instit
     * @param cl_ctb502024 $cCtb50
     * @param cl_ctb402024 $cCtb40
     * @param cl_ctb222024 $cCtb22
     * @param cl_ctb212024 $cCtb21
     * @param cl_ctb102024 $cCtb10
     * @return void
     * @throws Exception
     */
    public function registrosAnteriores(cl_ctb202024 $cCtb20, string $mes, $instit, cl_ctb502024 $cCtb50, cl_ctb402024 $cCtb40, cl_ctb222024 $cCtb22, cl_ctb212024 $cCtb21, cl_ctb102024 $cCtb10): void
    {
        /**
         * excluir informacoes do mes caso ja tenha sido gerado anteriormente
         */

        $result = $cCtb20->sql_record($cCtb20->sql_query(null, "*", null, "si96_mes = '{$mes}' AND si96_instit = {$instit}"));


        db_inicio_transacao();
        if (pg_num_rows($result) > 0) {

            $cCtb50->excluir(null, "si102_mes = {$mes} and si102_instit = {$instit}");
            if ($cCtb50->erro_status == 0) {
                throw new Exception($cCtb50->erro_msg);
            }

            $cCtb40->excluir(null, "si101_mes = {$mes} and si101_instit = {$instit}");
            if ($cCtb40->erro_status == 0) {
                throw new Exception($cCtb40->erro_msg);
            }

            $cCtb22->excluir(null, "si98_mes = {$mes} and si98_instit = {$instit}");
            if ($cCtb22->erro_status == 0) {

                throw new Exception($cCtb22->erro_msg);
            }
            $cCtb21->excluir(null, "si97_mes = {$mes} and si97_instit = {$instit}");
            if ($cCtb21->erro_status == 0) {

                throw new Exception($cCtb21->erro_msg);
            }
            $cCtb20->excluir(null, "si96_mes = {$mes} and si96_instit = {$instit}");
            if ($cCtb20->erro_status == 0) {

                throw new Exception($cCtb20->erro_msg);
            }
            $cCtb10->excluir(null, "si95_mes = {$mes} and si95_instit = {$instit}");
            if ($cCtb10->erro_status == 0) {

                throw new Exception($cCtb10->erro_msg);
            }
        }
        db_fim_transacao();
    }

    /**
     * @param $aCtb20Agrupado
     * @param $oContaAgrupada
     * @return mixed
     */
    public function fontesEncerradas($aCtb20Agrupado, $oContaAgrupada)
    {
        /**
         * Se a opção "Transferência de Fontes CTB" na tela de geração do sicom for sim
         */
        if ($this->bEncerramento) {

            /**
             * Percorre todo array para acertar os saldos finais do reg20.
             * Para cada reg20 que não seja a fonte principal, será necessário transferir o saldo final para a fonte principal
             * Caso fonte do registro 20 seja diferente da fonte principal da conta, criamos 2 registros 21:
             * 1 registro 21 de saída da fonte atual;
             * 1 registro 21 de entrada na fonte principal.
             */

            foreach ($aCtb20Agrupado as $sHash20 => $oCtb20) {

                if ($oCtb20->si96_codfontrecursos != $oCtb20->iFontePrincipal && $oCtb20->si96_vlsaldofinalfonte != 0) {

                    //Cria o primeiro registro 21 entrada/saída da fonte atual
                    $iTipoMovimentacao = $oCtb20->si96_vlsaldofinalfonte > 0 ? 2 : 1;
                    $sHash21 = $oCtb20->si96_codctb . $oCtb20->si96_codfontrecursos . $iTipoMovimentacao;

                    if (!$aCtb20Agrupado[$sHash20]->ctb21[$sHash21]) {

                        $oDadosMovi21 = new stdClass();
                        $oDadosMovi21->si97_tiporegistro = '21';
                        $oDadosMovi21->si97_codctb = $oCtb20->si96_codctb;
                        $oDadosMovi21->si97_codfontrecursos = $oCtb20->si96_codfontrecursos;
                        $oDadosMovi21->si97_codreduzidomov = $oCtb20->si96_codctb . $oCtb20->si96_codfontrecursos . $iTipoMovimentacao;
                        $oDadosMovi21->si97_tipomovimentacao = $iTipoMovimentacao;
                        $oDadosMovi21->si97_saldocec = $oCtb20->si96_saldocec;
                        $oDadosMovi21->si97_saldocectransf = 0;
                        $oDadosMovi21->si97_tipoentrsaida = '98';
                        $oDadosMovi21->si97_dscoutrasmov = ' ';
                        $oDadosMovi21->si97_valorentrsaida = $oCtb20->si96_vlsaldofinalfonte;
                        $oDadosMovi21->si97_codctbtransf = ' ';
                        $oDadosMovi21->si97_codfontectbtransf = ' ';
                        $oDadosMovi21->si97_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                        $oDadosMovi21->si97_instit = db_getsession("DB_instit");

                        $aCtb20Agrupado[$sHash20]->ctb21[$sHash21] = $oDadosMovi21;
                    } else {
                        $aCtb20Agrupado[$sHash20]->ctb21[$sHash21]->si97_valorentrsaida += $oCtb20->si96_vlsaldofinalfonte;
                    }

                    //Monta hash do reg 20 da fonte principal
                    $sHash20recurso = substr($sHash20, 0, -3) . $oCtb20->iFontePrincipal;

                    // Registro 20 da fonte principal recebe saldos finais das demais fontes
                    $aCtb20Agrupado[$sHash20recurso]->si96_vlsaldofinalfonte += $oCtb20->si96_vlsaldofinalfonte;

                    //Cria segundo registro 21 entrada/saída da fonte principal
                    $iTipoMovimentacao = $oCtb20->si96_vlsaldofinalfonte > 0 ? 1 : 2;
                    $sHash21 = $oCtb20->si96_codctb . $oCtb20->iFontePrincipal . $iTipoMovimentacao;

                    if (!$aCtb20Agrupado[$sHash20recurso]->ctb21[$sHash21]) {

                        $oDadosMovi21 = new stdClass();
                        $oDadosMovi21->si97_tiporegistro = '21';
                        $oDadosMovi21->si97_codctb = $oCtb20->si96_codctb;
                        $oDadosMovi21->si97_codfontrecursos = $oCtb20->iFontePrincipal;
                        $oDadosMovi21->si97_codreduzidomov = $oCtb20->si96_codctb . $oCtb20->iFontePrincipal . $iTipoMovimentacao;
                        $oDadosMovi21->si97_tipomovimentacao = $iTipoMovimentacao;
                        $oDadosMovi21->si97_saldocec = $oCtb20->si96_saldocec;
                        $oDadosMovi21->si97_saldocectransf = 0;
                        $oDadosMovi21->si97_tipoentrsaida = '98';
                        $oDadosMovi21->si97_dscoutrasmov = ' ';
                        $oDadosMovi21->si97_valorentrsaida = $oCtb20->si96_vlsaldofinalfonte;
                        $oDadosMovi21->si97_codctbtransf = ' ';
                        $oDadosMovi21->si97_codfontectbtransf = ' ';
                        $oDadosMovi21->si97_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                        $oDadosMovi21->si97_instit = db_getsession("DB_instit");

                        $aCtb20Agrupado[$sHash20recurso]->ctb21[$sHash21] = $oDadosMovi21;
                    } else {
                        $aCtb20Agrupado[$sHash20recurso]->ctb21[$sHash21]->si97_valorentrsaida += $oCtb20->si96_vlsaldofinalfonte;
                    }

                    // Atualiza saldo final da fonte atual
                    $aCtb20Agrupado[$sHash20]->si96_vlsaldofinalfonte -= $oCtb20->si96_vlsaldofinalfonte;
                }
            }

            /**
             * Percorre array para criar registros com dados criados na rotina (saldotransfctb)
             */
            foreach ($aCtb20Agrupado as $sHash20 => $oCtb20) {

                /**
                 * Caso seja informado um valor de Saldo Final nesta rotina (saldotransfctb) para alguma fonte,
                 * o sistema deverá fazer uma saída (2) do tipo 98 na fonte principal da conta e uma entrada (1) do tipo 98 na fonte informada na rotina.
                 */

                $sSqlSaldoTransfCtb = "	SELECT * FROM saldotransfctb
                              WHERE si202_codctb = {$oCtb20->si96_codctb}
                              AND si202_anousu = " . db_getsession("DB_anousu") . " AND si202_instit = " . db_getsession("DB_instit");

                $rsSaldoTransfCtb = db_query($sSqlSaldoTransfCtb);

                if (pg_num_rows($rsSaldoTransfCtb)) {

                    for ($iSaldoTransfCtb = 0; $iSaldoTransfCtb < pg_num_rows($rsSaldoTransfCtb); $iSaldoTransfCtb++) {

                        //Caso a fonte atual seja igual a fonte principal, criamos a saída da fonte principal e entrada na fonte cadastrada na saldotransfctb
                        if ($oCtb20->iFontePrincipal == $oCtb20->si96_codfontrecursos) {

                            $oSaldoTransfCtb = db_utils::fieldsMemory($rsSaldoTransfCtb, $iSaldoTransfCtb);

                            if ($oSaldoTransfCtb->si202_codctb == $oCtb20->si96_codctb) {

                                $iTipoMovimentacao = $oSaldoTransfCtb->si202_saldofinal < 0 ? 1 : 2;

                                /**
                                 * Cria reg21 de saída/entrada da fonte principal para fonte cadastrada na tabela saldotransfctb
                                 * Se o valor cadastrado for negativo, será uma entrada na principal
                                 */
                                $sHash21 = $oCtb20->si96_codctb . $oCtb20->iFontePrincipal . $iTipoMovimentacao;

                                //Cria saída da fonte principal
                                if (!$aCtb20Agrupado[$sHash20]->ctb21[$sHash21]) {

                                    $oDadosMovi21 = new stdClass();
                                    $oDadosMovi21->si97_tiporegistro = '21';
                                    $oDadosMovi21->si97_codctb = $oCtb20->si96_codctb;
                                    $oDadosMovi21->si97_codfontrecursos = $oCtb20->iFontePrincipal;
                                    $oDadosMovi21->si97_codreduzidomov = $oCtb20->si96_codctb . $oCtb20->si96_codfontrecursos . $iTipoMovimentacao;
                                    $oDadosMovi21->si97_tipomovimentacao = $iTipoMovimentacao;
                                    $oDadosMovi21->si97_saldocec = $oCtb20->si96_saldocec;
                                    $oDadosMovi21->si97_saldocectransf = 0;
                                    $oDadosMovi21->si97_tipoentrsaida = '98';
                                    $oDadosMovi21->si97_dscoutrasmov = ' ';
                                    $oDadosMovi21->si97_valorentrsaida = $oSaldoTransfCtb->si202_saldofinal;
                                    $oDadosMovi21->si97_codctbtransf = ' ';
                                    $oDadosMovi21->si97_codfontectbtransf = ' ';
                                    $oDadosMovi21->si97_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                                    $oDadosMovi21->si97_instit = db_getsession("DB_instit");

                                    $aCtb20Agrupado[$sHash20]->ctb21[$sHash21] = $oDadosMovi21;
                                } else {
                                    $aCtb20Agrupado[$sHash20]->ctb21[$sHash21]->si97_valorentrsaida += $aCtb20Agrupado[$sHash20]->ctb21[$sHash21]->si97_valorentrsaida < 0 ? ($oSaldoTransfCtb->si202_saldofinal * -1) : abs($oSaldoTransfCtb->si202_saldofinal);
                                }

                                //Atualiza saldo do reg20
                                $aCtb20Agrupado[$sHash20]->si96_vlsaldofinalfonte -= $oSaldoTransfCtb->si202_saldofinal;

                                $iTipoMovimentacao = $oSaldoTransfCtb->si202_saldofinal < 0 ? 2 : 1;

                                /**
                                 * Cria entrada/saída na fonte cadastrada na tabela saldotransfctb
                                 * Se o valor cadastrado for negativo, será uma saída na fonte cadastrada
                                 */
                                $sHash21b = $oCtb20->si96_codctb . $oSaldoTransfCtb->si202_codfontrecursos . $iTipoMovimentacao;
                                $sHash20b = substr($sHash20, 0, -3) . $oSaldoTransfCtb->si202_codfontrecursos;

                                if (!$aCtb20Agrupado[$sHash20b]->ctb21[$sHash21b]) {

                                    $oDadosMovi21 = new stdClass();
                                    $oDadosMovi21->si97_tiporegistro = '21';
                                    $oDadosMovi21->si97_codctb = $oCtb20->si96_codctb;
                                    $oDadosMovi21->si97_codfontrecursos = $oSaldoTransfCtb->si202_codfontrecursos;
                                    $oDadosMovi21->si97_codreduzidomov = $oCtb20->si96_codctb . $oSaldoTransfCtb->si202_codfontrecursos . $iTipoMovimentacao;
                                    $oDadosMovi21->si97_tipomovimentacao = $iTipoMovimentacao;
                                    $oDadosMovi21->si97_saldocec = $oCtb20->si96_saldocec;
                                    $oDadosMovi21->si97_saldocectransf = 0;
                                    $oDadosMovi21->si97_tipoentrsaida = '98';
                                    $oDadosMovi21->si97_dscoutrasmov = ' ';
                                    $oDadosMovi21->si97_valorentrsaida = $oSaldoTransfCtb->si202_saldofinal;
                                    $oDadosMovi21->si97_codctbtransf = ' ';
                                    $oDadosMovi21->si97_codfontectbtransf = ' ';
                                    $oDadosMovi21->si97_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                                    $oDadosMovi21->si97_instit = db_getsession("DB_instit");
                                    $oDadosMovi21->codorgao = $oContaAgrupada->si95_codorgao;

                                    $aCtb20Agrupado[$sHash20b]->ctb21[$sHash21b] = $oDadosMovi21;
                                } else {
                                    $aCtb20Agrupado[$sHash20b]->ctb21[$sHash21b]->si97_valorentrsaida += $aCtb20Agrupado[$sHash20b]->ctb21[$sHash21b]->si97_valorentrsaida < 0 ? ($oSaldoTransfCtb->si202_saldofinal * -1) : $aCtb20Agrupado[$sHash20b]->ctb21[$sHash21b]->si97_valorentrsaida;
                                }

                                //Atualiza saldo do reg20
                                $aCtb20Agrupado[$sHash20b]->si96_vlsaldofinalfonte += $oSaldoTransfCtb->si202_saldofinal;
                            }
                        }
                    }
                }
            }
            /**
             * Percorre array para verificar se existe algum registro 21 criado em um registro 20 vazio
             * Caso exista, um registro 20 é criado utilizando os dados do reg21
             */
            foreach ($aCtb20Agrupado as $oCtb20) {

                if (!$oCtb20->si96_tiporegistro) {

                    $sHash21 = key($oCtb20->ctb21);

                    $oCtb20->si96_tiporegistro = 20;
                    $oCtb20->si96_codorgao = $oCtb20->ctb21[$sHash21]->codorgao;
                    $oCtb20->si96_codctb = $oCtb20->ctb21[$sHash21]->si97_codctb;
                    $oCtb20->si96_codfontrecursos = $oCtb20->ctb21[$sHash21]->si97_codfontrecursos;
                    $oCtb20->si96_vlsaldoinicialfonte = 0;
                    $oCtb20->si96_saldocec = $oCtb20->si96_saldocec;
                    $oCtb20->si96_vlsaldofinalfonte = $oCtb20->ctb21[$sHash21]->si97_valorentrsaida;
                    $oCtb20->si96_mes = $oCtb20->ctb21[$sHash21]->si97_mes;
                    $oCtb20->si96_instit = $oCtb20->ctb21[$sHash21]->si97_instit;
                }
            }
        }
        return $oCtb20;
    }

    /**
     * @param $sSqlGeral
     * @param $cCtb10
     * @param $ano
     * @param $instit
     * @param string $mes
     * @param cl_ctb402024 $cCtb40
     * @return void
     * @throws Exception
     */
    public function registro40($sSqlGeral, $cCtb10, $ano, $instit, string $mes, cl_ctb402024 $cCtb40): void
    {
        /**
         * REGISTRO 40 ALTERACAO DE CONTAS BANCARIAS
         */
        $rsCtasReg40 = db_query($sSqlGeral);

        if (pg_num_rows($rsCtasReg40) != 0) {

            for ($icont40 = 0; $icont40 < pg_num_rows($rsCtasReg40); $icont40++) {

                $oMovi40 = db_utils::fieldsMemory($rsCtasReg40, $icont40);

                /**
                 * Adicionada consulta abaixo para verificacao da data de cadastro da conta
                 **/
                $sSqlDtCad = $cCtb10->verificaDtCadastro($oMovi40, $ano, $instit);
                $rsResultDtCad = db_query($sSqlDtCad);
                $oDtCad = db_utils::fieldsMemory($rsResultDtCad, 0);

                $sSqlVerifica = $cCtb10->verificaExisteReg10($oMovi40, $instit, $mes, $ano);
                $rsResultVerifica40 = db_query($sSqlVerifica);
                $oVerificaReg40 = db_utils::fieldsMemory($rsResultVerifica40, 0);

                $sSql40 = $cCtb40->sql_verificaReg40($oVerificaReg40->si95_codctb, $ano, $mes, $instit);
                $rsQuery40 = db_query($sSql40);
                $oReg40 = db_utils::fieldsMemory($rsQuery40, 0);

                if (
                    $oMovi40->contaconvenio == 1 && ($oMovi40->nroconvenio != $oReg40->si101_nroconvenio) && empty($oMovi40->nroconvenio)
                    && pg_num_rows($rsQuery40) == 0 && ($oDtCad->k13_dtimplantacao <= $this->sDataFinal)
                ) {

                    $cCtb40 = new cl_ctb402024();

                    $cCtb40->si101_tiporegistro = 40;
                    $cCtb40->si101_codorgao = $oMovi40->si09_codorgaotce;
                    $cCtb40->si101_codctb = $oMovi40->codtce != 0 ? $oMovi40->codtce : $oMovi40->codctb;
                    $cCtb40->si101_desccontabancaria = substr($oMovi40->desccontabancaria, 0, 50);
                    $cCtb40->si101_nroconvenio = $oMovi40->nroconvenio;
                    $cCtb40->si101_dataassinaturaconvenio = ($oMovi40->dataassinaturaconvenio == NULL || $oMovi40->dataassinaturaconvenio == ' ') ? NULL : $oMovi40->dataassinaturaconvenio;
                    $cCtb40->si101_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $cCtb40->si101_instit = db_getsession("DB_instit");

                    $cCtb40->incluir(null);
                    if ($cCtb40->erro_status == 0) {
                        throw new Exception($cCtb40->erro_msg);
                    }
                }
            }
        }
    }

    /**
     * @param cl_ctb502024 $cCtb50
     * @param $ano
     * @param $instit
     * @return void
     * @throws Exception
     */
    public function registro50(cl_ctb502024 $cCtb50, $ano, $instit): void
    {
        /**
         * REGISTRO 50 CONTAS ENCERRADAS
         */

        $sSqlCtbEncerradas = $cCtb50->sql_Reg50($ano, $this->sDataInicial, $this->sDataFinal, $instit);
        $rsCtbEncerradas = db_query($sSqlCtbEncerradas);

        if (pg_num_rows($rsCtbEncerradas) != 0) {

            for ($iCont50 = 0; $iCont50 < pg_num_rows($rsCtbEncerradas); $iCont50++) {

                $oMovi50 = db_utils::fieldsMemory($rsCtbEncerradas, $iCont50);

                $cCtb50 = new cl_ctb502024();

                $cCtb50->si102_tiporegistro = $oMovi50->tiporegistro;
                $cCtb50->si102_codorgao = $oMovi50->si09_codorgaotce;
                $cCtb50->si102_codctb = $oMovi50->codctb;
                $cCtb50->si102_situacaoconta = $oMovi50->situacaoconta;
                $cCtb50->si102_datasituacao = $oMovi50->dataencerramento;
                $cCtb50->si102_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $cCtb50->si102_instit = db_getsession("DB_instit");

                $cCtb50->incluir(null);
                if ($cCtb50->erro_status == 0) {
                    throw new Exception($cCtb50->erro_msg);
                }

            }

        }
    }

}
