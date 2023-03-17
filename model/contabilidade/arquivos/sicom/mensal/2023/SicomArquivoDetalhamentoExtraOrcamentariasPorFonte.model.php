<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_ext102023_classe.php");
require_once("classes/db_ext202023_classe.php");
require_once("classes/db_ext302023_classe.php");
require_once("classes/db_ext312023_classe.php");
require_once("classes/db_rsp102023_classe.php");
require_once("model/orcamento/DeParaRecurso.model.php");


require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2023/GerarEXT.model.php");

/**
 * Detalhamento Extra Ocamentarias Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoDetalhamentoExtraOrcamentariasPorFonte extends SicomArquivoBase implements iPadArquivoBaseCSV
{

    /**
     *
     * Codigo do layout. (db_layouttxt.db50_codigo)
     * @var Integer
     */
    protected $iCodigoLayout = 171;

    /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'EXT';

    /**
 	* @var bollean
	* Realiza transfer�ncia de fontes utilizadas no reg 20 para fonte principal da conta (PCASP)
	*/
    protected $bEncerramento = false;

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
    }

    public function setEncerramentoExt($iEncerramento)
    {
        if ($iEncerramento == 1) {
            $this->bEncerramento = true;
        }
    }

    /**
     * Separa fun��o para buscar a natureza do saldo atual/final da conta
     * utilizando as condi��es j� existentes
     * @param Object $oExt20
     * @return String
     */
    private function getNatSaldoAtual($oExt20)
    {

        if (substr($oExt20->si165_codfontrecursos, 1, 2) == '59') {
            $verificaNatSaldoAtual = $oExt20->si165_vlsaldoatualfonte;
        } else {
            $verificaNatSaldoAtual = ($oExt20->si165_vlsaldoanteriorfonte + $oExt20->si165_totaldebitos - $oExt20->si165_totalcreditos);
        }

        if ($verificaNatSaldoAtual < 0) {
            return 'C';
        } elseif ($verificaNatSaldoAtual > 0) {
            return 'D';
        } else {
            return $oExt20->si165_natsaldoatualfonte;
        }

    }

    /**
     * selecionar os dados de //
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados()
    {

        $cExt10 = new cl_ext102023();
        $cExt20 = new cl_ext202023();
        $cExt30 = new cl_ext302023();
        $cExt31 = new cl_ext312023();

        /*
  	 * CASO JA TENHA SIDO GERADO ALTERIORMENTE PARA O MESMO PERIDO O SISTEMA IRA
  	 * EXCLUIR OS REGISTROS E GERAR NOVAMENTE
  	 *
  	 */


        db_inicio_transacao();

        $cExt31->excluir(NULL, "si127_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
	    								and si127_instit = " . db_getsession("DB_instit"));
        if ($cExt31->erro_status == 0) {
            throw new Exception($cExt31->erro_msg);
        }

        $cExt30->excluir(NULL, "si126_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si126_instit = " . db_getsession("DB_instit"));

        if ($cExt30->erro_status == 0) {
            throw new Exception($cExt31->erro_msg);
        }
        $cExt20->excluir(NULL, "si165_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
	    								and si165_instit = " . db_getsession("DB_instit"));

        if ($cExt20->erro_status == 0) {
            throw new Exception($cExt20->erro_msg);
        }
        $cExt10->excluir(NULL, "si124_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
	    								and si124_instit = " . db_getsession("DB_instit"));
        if ($cExt10->erro_status == 0) {
            throw new Exception($cExt10->erro_msg);
        }

        // echo pg_last_error();

        db_fim_transacao();

        $sSqlRespPGTO = "select z01_cgccpf from identificacaoresponsaveis join cgm on si166_numcgm = z01_numcgm where si166_tiporesponsavel = 1 and si166_instit = " . db_getsession("DB_instit") . " and " . db_getsession("DB_anousu") . " between DATE_PART('YEAR',si166_dataini) AND DATE_PART('YEAR',si166_datafim)";
        $rsResponsalvelPgto = db_query($sSqlRespPGTO);
        $cpfRespPGTO = db_utils::fieldsMemory($rsResponsalvelPgto, 0)->z01_cgccpf;
        /*
  	     * SQL RETORNA TODAS AS CONTAS EXTRAS EXISTENTES NO SISTEMA
  	     *
  	     */
        $sSqlExt = "SELECT 10 AS tiporegistro,
					       c61_codcon,
					       c61_reduz AS codext,
					       c61_codtce AS codtce,
					       si09_codorgaotce AS codorgao,
					       COALESCE(c60_tipolancamento,0) AS tipolancamento,
					       COALESCE(c60_subtipolancamento,0) AS subtipo,
					       COALESCE(c60_desdobramneto,0) AS desdobrasubtipo,
					       substr(c60_descr,1,50) AS descextraorc,
                           o15_codtri as recurso
					FROM conplano
					INNER JOIN conplanoreduz ON c60_codcon = c61_codcon AND c60_anousu = c61_anousu
                    INNER JOIN orctiporec ON c61_codigo = o15_codigo
					LEFT JOIN infocomplementaresinstit ON si09_instit = c61_instit
					WHERE c60_anousu = " . db_getsession("DB_anousu") . "
					  AND c60_codsis = 7
					  AND c61_instit = " . db_getsession("DB_instit") . "
					ORDER BY c61_reduz";

        $rsContasExtra = db_query($sSqlExt) or die($sSqlExt);

        // matriz de entrada
        $what = array(
            "°", chr(13), chr(10), 'ä', 'ã', '�', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô',
            'ü', 'ù', 'ú', 'û', 'À', 'Á', 'Ã', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º'
        );

        // matriz de saída
        $by   = array(
            '', '', '', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u',
            'u', 'A', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '
        );


        /*
	     * PERCORRE OS SQL PARA INSERIR NA BASE DE DADOS OS REGISTROS
	     */
        db_inicio_transacao();


        $aExt10Agrupodo = array();
        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsContasExtra); $iCont10++) {

            $oContaExtra = db_utils::fieldsMemory($rsContasExtra, $iCont10);

            $aHash  = $oContaExtra->codorgao;
            $aHash .= $oContaExtra->tipolancamento;
            $aHash .= $oContaExtra->subtipo;
            $aHash .= $oContaExtra->desdobrasubtipo;




            if (!isset($aExt10Agrupodo[$aHash])) {

                $cExt10 = new cl_ext102023();

                $cExt10->si124_tiporegistro     = $oContaExtra->tiporegistro;
                $cExt10->si124_codext              = $oContaExtra->codtce != 0 ? $oContaExtra->codtce : $oContaExtra->codext;
                $cExt10->si124_codorgao         = $oContaExtra->codorgao;
                $cExt10->si124_tipolancamento     = substr(str_pad($oContaExtra->tipolancamento, 2, "0", STR_PAD_LEFT), 0, 2);
                $cExt10->si124_subtipo             = substr(str_pad($oContaExtra->subtipo, 4, "0", STR_PAD_LEFT), 0, 4);
                $cExt10->si124_desdobrasubtipo     = substr(str_pad($oContaExtra->desdobrasubtipo, 4, "0", STR_PAD_LEFT), 0, 4);
                $cExt10->si124_descextraorc     = $oContaExtra->descextraorc;
                $cExt10->si124_mes                = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $cExt10->si124_instit            = db_getsession("DB_instit");
                $cExt10->extras                    = array();

                /*
					 * VERIFICA SE NO EM ALGUMA REMESSA ENVIADA O CODEXT FOI IMFORMADO, CASO NÃO TENHA ENCONTRATO CRIA UM NOVO
					 */
                $sSqlVerifica  = "SELECT 1 FROM ext102023
                                     WHERE si124_codorgao        = '" . $cExt10->si124_codorgao . "'
                                       AND si124_tipolancamento  = '" . $cExt10->si124_tipolancamento . "'
                                       AND si124_subtipo         = '" . $cExt10->si124_subtipo . "'
                                       AND si124_desdobrasubtipo = '" . $cExt10->si124_desdobrasubtipo . "'
                                       AND si124_mes             <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $sSqlVerifica  .= " UNION ALL
                                    SELECT 1 FROM ext102022
                                    WHERE si124_codorgao        = '" . $cExt10->si124_codorgao . "'
                                        AND si124_tipolancamento  = '" . $cExt10->si124_tipolancamento . "'
                                        AND si124_subtipo         = '" . $cExt10->si124_subtipo . "'
                                        AND si124_desdobrasubtipo =  '" . $cExt10->si124_desdobrasubtipo . "' ";
                $sSqlVerifica  .= " UNION ALL
                                    SELECT 1 FROM ext102021
                                    WHERE si124_codorgao        = '" . $cExt10->si124_codorgao . "'
                                        AND si124_tipolancamento  = '" . $cExt10->si124_tipolancamento . "'
                                        AND si124_subtipo         = '" . $cExt10->si124_subtipo . "'
                                        AND si124_desdobrasubtipo =  '" . $cExt10->si124_desdobrasubtipo . "' ";
                $sSqlVerifica  .= " UNION ALL
                                    SELECT 1 FROM ext102020
                                     WHERE si124_codorgao        = '" . $cExt10->si124_codorgao . "'
                                       AND si124_tipolancamento  = '" . $cExt10->si124_tipolancamento . "'
                                       AND si124_subtipo         = '" . $cExt10->si124_subtipo . "'
                                       AND si124_desdobrasubtipo =  '" . $cExt10->si124_desdobrasubtipo . "' ";
                $sSqlVerifica  .= " UNION ALL
                                    SELECT 1 FROM ext102019
                                     WHERE si124_codorgao        = '" . $cExt10->si124_codorgao . "'
                                       AND si124_tipolancamento  = '" . $cExt10->si124_tipolancamento . "'
                                       AND si124_subtipo         = '" . $cExt10->si124_subtipo . "'
                                       AND si124_desdobrasubtipo =  '" . $cExt10->si124_desdobrasubtipo . "' ";
                $sSqlVerifica  .= " UNION ALL
                                    SELECT 1 FROM ext102018
                                     WHERE si124_codorgao        = '" . $cExt10->si124_codorgao . "'
                                       AND si124_tipolancamento  = '" . $cExt10->si124_tipolancamento . "'
                                       AND si124_subtipo         = '" . $cExt10->si124_subtipo . "'
                                       AND si124_desdobrasubtipo =  '" . $cExt10->si124_desdobrasubtipo . "' ";
                $sSqlVerifica  .= " UNION ALL
                                    SELECT 1 FROM ext102017
                                     WHERE si124_codorgao        = '" . $cExt10->si124_codorgao . "'
                                       AND si124_tipolancamento  = '" . $cExt10->si124_tipolancamento . "'
                                       AND si124_subtipo         = '" . $cExt10->si124_subtipo . "'
                                       AND si124_desdobrasubtipo =  '" . $cExt10->si124_desdobrasubtipo . "' ";
                $sSqlVerifica  .= " UNION ALL
                                    SELECT 1 FROM ext102016
                                     WHERE si124_codorgao        = '" . $cExt10->si124_codorgao . "'
                                       AND si124_tipolancamento  = '" . $cExt10->si124_tipolancamento . "'
                                       AND si124_subtipo         = '" . $cExt10->si124_subtipo . "'
                                       AND si124_desdobrasubtipo =  '" . $cExt10->si124_desdobrasubtipo . "' ";
                $sSqlVerifica  .= " UNION ALL
                                    SELECT 1 FROM ext102015
                                    WHERE si124_codorgao        = '" . $cExt10->si124_codorgao . "'
                                      AND si124_tipolancamento    = '" . $cExt10->si124_tipolancamento . "'
                                      AND si124_subtipo           = '" . $cExt10->si124_subtipo . "'
                                      AND si124_desdobrasubtipo   = '" . $cExt10->si124_desdobrasubtipo . "' ";
                $sSqlVerifica  .= " UNION ALL
                                    SELECT 1 FROM ext102014
                                    WHERE si124_codorgao        = '" . $cExt10->si124_codorgao . "'
                                      AND si124_tipolancamento    = '" . $cExt10->si124_tipolancamento . "'
                                      AND si124_subtipo           = '" . $cExt10->si124_subtipo . "'
                                      AND si124_desdobrasubtipo   = '" . $cExt10->si124_desdobrasubtipo . "' ";

                $rsResulVerifica = db_query($sSqlVerifica) or die($sSqlVerifica);
                //  echo $rsResulVerifica;db_criatabela($rsResulVerifica);exit;

                if (pg_num_rows($rsResulVerifica) == 0) {

                    $cExt10->incluir(null);

                    if ($cExt10->erro_status == 0) {
                        throw new Exception($cExt10->erro_msg);
                    }
                }

                $oExtra = new stdClass();
                $oExtra->codext = $oContaExtra->codext;
                $oExtra->recurso = $oContaExtra->recurso;

                $cExt10->extras[]= $oExtra;
                $aExt10Agrupodo[$aHash] = $cExt10;

            } else {
                $oExtra = new stdClass();
                $oExtra->codext = $oContaExtra->codext;
                $oExtra->recurso = $oContaExtra->recurso;
                $aExt10Agrupodo[$aHash]->extras[] = $oExtra;
            }
        }
        $aExt20 = array();
        $aExtExercicioCompDevo = array();
        foreach ($aExt10Agrupodo as $oExt10Agrupado) {
            foreach ($oExt10Agrupado->extras as $oExtras) {
                $aExtExercicioCompDevo = $this->recuperarExercicioCompetenciaDevolucao($oExtras->codext, $oExt10Agrupado->si124_codorgao, $aExtExercicioCompDevo);

                /*
				 * pegar todas as fontes de recursos movimentadas para cada codext
				 */
                $sSql20Fonte  = " SELECT DISTINCT codext, fonte  from ( ";
                $sSql20Fonte .= $this->getSql20FonteBase($oExtras->codext);
                $sSql20Fonte .= " ) as extfonte order by codext, fonte ";

                $rsExt20FonteRecurso = db_query($sSql20Fonte); // or die($sSql20Fonte);
                // echo "Movimento";
                //db_criatabela($rsExt20FonteRecurso);
                for ($iC = 0; $iC < pg_num_rows($rsExt20FonteRecurso); $iC++) {
                    $Hash20 = '';
                    $oContaExtraFonte = db_utils::fieldsMemory($rsExt20FonteRecurso, $iC);

                    $sSqlSaldoFonte =    "select round(substr(fc_saldoextfonte(" . db_getsession("DB_anousu") . ",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),28,13)::float8,2)::float8 as saldo_anterior,
												round(substr(fc_saldoextfonte(" . db_getsession("DB_anousu") . ",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),42,13)::float8,2)::float8 as debitomes,
												round(substr(fc_saldoextfonte(" . db_getsession("DB_anousu") . ",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),56,13)::float8,2)::float8 as creditomes,
												round(substr(fc_saldoextfonte(" . db_getsession("DB_anousu") . ",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),70,13)::float8,2)::float8 as saldo_final,
												substr(fc_saldoextfonte(" . db_getsession("DB_anousu") . ",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),83,1)::varchar(1) as  sinalanterior,
												substr(fc_saldoextfonte(" . db_getsession("DB_anousu") . ",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),85,1)::varchar(1) as  sinalfinal ";

                    $rsExtSaldoFonteRecurso   = db_query($sSqlSaldoFonte);
                    $saldoanteriorabs         = db_utils::fieldsMemory($rsExtSaldoFonteRecurso, 0)->saldo_anterior;
                    $oExtRecurso              = $oContaExtraFonte->fonte;
                    $natsaldoanteriorfonte    = db_utils::fieldsMemory($rsExtSaldoFonteRecurso, 0)->sinalanterior;
                    $saldofinalabs            = db_utils::fieldsMemory($rsExtSaldoFonteRecurso, 0)->saldo_final;
                    $natsaldoatualfonte       = db_utils::fieldsMemory($rsExtSaldoFonteRecurso, 0)->sinalfinal;
                    $saldodebito              = db_utils::fieldsMemory($rsExtSaldoFonteRecurso, 0)->debitomes;
                    $saldocredito             = db_utils::fieldsMemory($rsExtSaldoFonteRecurso, 0)->creditomes;
                    $saldoanterior            = $natsaldoanteriorfonte == 'C' ? ($saldoanteriorabs == '' ? 0 : $saldoanteriorabs) * -1 : ($saldoanteriorabs == '' ? 0 : $saldoanteriorabs);
                    $saldofinal               = $natsaldoatualfonte == 'C' ? ($saldofinalabs == '' ? 0 : $saldofinalabs) * -1 : ($saldofinalabs == '' ? 0 : $saldofinalabs);

                    $oExtRecursoTCE = $this->getExtRecursoTCE($oContaExtraFonte->fonte);

                    //OC11537
                    $bFonteEncerrada  = in_array($oExtRecursoTCE, $this->aFontesEncerradas);
                    $bCorrecaoFonte   = ($bFonteEncerrada && $this->sDataFinal['5'] . $this->sDataFinal['6'] == '01' && db_getsession("DB_anousu") == 2023);

                    $oExtRecursoTCE2 = $bFonteEncerrada ? substr($oExtRecursoTCE, 0, 1) . '59' : $oExtRecursoTCE; //caso atenda condição, altera para fonte nova 159 ou 259

                    if ($bFonteEncerrada && $bCorrecaoFonte) {

                        $Hash20 = "20b" . $oExt10Agrupado->si124_codorgao . $oExt10Agrupado->si124_codext . $oExtRecursoTCE;

                        if (!isset($aExt20[$Hash20])) {

                            $cExt20   = new stdClass();

                            $cExt20->si165_tiporegistro          = '20';
                            $cExt20->si165_codorgao              = $oExt10Agrupado->si124_codorgao;
                            $cExt20->si165_codext                = $oExt10Agrupado->si124_codext;
                            $cExt20->si165_codfontrecursos       = $oExtRecursoTCE;
                            $cExt20->si165_exerciciocompdevo     = "";
                            $cExt20->si165_vlsaldoanteriorfonte  = $saldoanterior;
                            $cExt20->si165_natsaldoanteriorfonte = $saldoanterior > 0 ? 'D' : 'C';
                            $cExt20->si165_totaldebitos          = $saldoanterior < 0 ? abs($saldoanterior) : 0;
                            $cExt20->si165_totalcreditos         = $saldoanterior > 0 ? abs($saldoanterior) : 0;
                            $cExt20->si165_vlsaldoatualfonte     = 0;
                            $cExt20->si165_natsaldoatualfonte    = $saldoanterior > 0 ? 'D' : 'C';
                            $cExt20->si165_mes                   = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                            $cExt20->si165_instit                = db_getsession("DB_instit");
                            $cExt20->ext30                       = array();
                            $aExt20[$Hash20]                     = $cExt20;
                        } else {

                            $aExt20[$Hash20]->si165_vlsaldoanteriorfonte  += $saldoanterior;
                            $aExt20[$Hash20]->si165_totaldebitos          += $saldoanterior < 0 ? abs($saldoanterior) : 0;
                            $aExt20[$Hash20]->si165_totalcreditos         += $saldoanterior > 0 ? abs($saldoanterior) : 0;
                        }
                    }

                    $Hash20 = "20" . $oExt10Agrupado->si124_codorgao . $oExt10Agrupado->si124_codext . $oExtRecursoTCE2;
                    //echo $Hash20."<br>";
                    if (!isset($aExt20[$Hash20])) {

                        $cExt20   = new stdClass();

                        $cExt20->si165_tiporegistro          = '20';
                        $cExt20->si165_codorgao              = $oExt10Agrupado->si124_codorgao;
                        $cExt20->si165_codext                = $oExt10Agrupado->si124_codext;
                        $cExt20->si165_codfontrecursos       = $oExtRecursoTCE2;
                        $cExt20->si165_exerciciocompdevo     = "";
                        $cExt20->si165_vlsaldoanteriorfonte  = ($bFonteEncerrada && $bCorrecaoFonte) ? 0 : $saldoanterior;
                        $cExt20->si165_natsaldoanteriorfonte = $natsaldoanteriorfonte;

                        if ($bFonteEncerrada && $bCorrecaoFonte) {
                            $cExt20->si165_totaldebitos = $saldoanterior > 0 ? abs($saldoanterior) : $saldodebito;
                            $cExt20->si165_totalcreditos = $saldoanterior < 0 ? abs($saldoanterior) : $saldocredito;
                        } else {
                            $cExt20->si165_totaldebitos = $saldodebito;
                            $cExt20->si165_totalcreditos = $saldocredito;
                        }

                        $cExt20->si165_vlsaldoatualfonte     = $saldofinal;
                        $cExt20->si165_natsaldoatualfonte    = $natsaldoatualfonte;
                        $cExt20->si165_mes                   = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                        $cExt20->si165_instit                = db_getsession("DB_instit");
                        $cExt20->ext30                       = array();
                        $cExt20->iFontePrincipal			 = $oExtras->recurso;
                        $aExt20[$Hash20]                     = $cExt20;
                    } else {

                        $aExt20[$Hash20]->si165_vlsaldoanteriorfonte  += ($bFonteEncerrada && $bCorrecaoFonte) ? 0 : $saldoanterior;
                        $aExt20[$Hash20]->si165_vlsaldoatualfonte     += $saldofinal;
                        if ($bFonteEncerrada && $bCorrecaoFonte) {
                            $aExt20[$Hash20]->si165_totaldebitos += $saldoanterior > 0 ? abs($saldoanterior) : $saldodebito;
                            $aExt20[$Hash20]->si165_totalcreditos += $saldoanterior < 0 ? abs($saldoanterior) : $saldocredito;
                        } else {
                            $aExt20[$Hash20]->si165_totaldebitos += $saldodebito;
                            $aExt20[$Hash20]->si165_totalcreditos += $saldocredito;
                        }
                    }

                    /**
                     * CARREGA OS DADOS DO REGISTRO 30
                     */
                    $sSqlMov = "select conlancamdoc.c71_codlan as codreduzidomov,
                                        case when conplanoreduz.c61_codtce !=0 then conplanoreduz.c61_codtce else conplanoreduz.c61_reduz end as codext,
                                        orctiporec.o15_codtri as codfontrecursos,
                                        '2' as categoria,
                                        conlancamval.c69_data as dtLancamento,
                                        c69_valor as vllancamento,
                                        conlancamcorrente.c86_id as id,
                                        conlancamcorrente.c86_data as data,
                                        conlancamcorrente.c86_autent as autent,
                                        conlancamval.c69_credito as contapagadora
                                from conlancamval
                                inner join conlancamdoc on conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                inner join conlancamcorrente on  conlancamval.c69_codlan = conlancamcorrente.c86_conlancam
                                inner join conplanoreduz on conplanoreduz.c61_reduz = conlancamval.c69_credito
                                inner join orctiporec on  orctiporec.o15_codigo = conplanoreduz.c61_codigo
                                        and conplanoreduz.c61_anousu = conlancamval.c69_anousu
                                where conlancamdoc.c71_coddoc in (120,151,161)
                                  and conlancamval.c69_debito = {$oExtras->codext}
                                  and DATE_PART('YEAR',conlancamval.c69_data) = " . db_getsession("DB_anousu") . "
                                  and DATE_PART('MONTH',conlancamval.c69_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                                  and orctiporec.o15_codigo = {$oExtRecurso}";

                    $rsExtMov = db_query($sSqlMov);
                    // echo "Reg30";db_criatabela($rsExtMov);
                    /*FOR PARA PEGAR O REGISTRO 21 E COLOCAR NO 20*/
                    for ($linha = 0; $linha < pg_num_rows($rsExtMov); $linha++) {

                        $oExtMov = db_utils::fieldsMemory($rsExtMov, $linha);

                        $sSql30 = " SELECT '30' as tiporegistro,
                                                    c50_descr,
                                                    CASE
                                                        WHEN conplano.c60_codsis = 5
                                                        THEN 5
                                                        ELSE e91_codcheque
                                                    END AS e91_codcheque,
                                                    c86_data as dtpagamento,
                                                    (SELECT coalesce(c86_conlancam, 0) FROM conlancamcorrente
                                                        WHERE c86_id = corrente.k12_id
                                                            AND c86_data = corrente.k12_data
                                                            AND c86_autent = corrente.k12_autent) AS codreduzidomov,
                                                    (slip.k17_codigo||slip.k17_debito)::int8 AS codreduzidoop,
                                                    (slip.k17_codigo||slip.K17_debito)::int8 AS nroop,
                                                    CASE WHEN LENGTH(cc.z01_cgccpf::varchar) = 11 THEN 1 ELSE 2 END AS tipodocumentocredor,
                                                    cc.z01_cgccpf AS nrodocumentocredor,
                                                    k17_valor AS vlop,
                                                    k17_texto AS especificacaoop,
                                                    CASE WHEN c61_codtce <> 0 THEN c61_codtce ELSE slip.k17_credito END AS contapagadora,
                                                    orctiporec.o15_codtri AS fontepagadora,
                                                    (SELECT CASE WHEN o41_subunidade != 0
                                                                                OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
                                                                OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                                                                                            OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
                                                                        ELSE lpad((CASE WHEN o40_codtri = '0'
                                                                                OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                                                                                    OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
                                                        END AS unidade
                                                        FROM orcunidade
                                                        JOIN orcorgao ON o41_anousu = o40_anousu and o41_orgao = o40_orgao
                                                        WHERE o41_instit = " . db_getsession("DB_instit") . " AND o40_anousu = " . db_getsession("DB_anousu") . " ORDER BY o40_orgao LIMIT 1) AS codunidadesub
                                            FROM corlanc
                                            INNER JOIN corrente ON corlanc.k12_id = corrente.k12_id
                                                        AND corlanc.k12_data = corrente.k12_data
                                                        AND corlanc.k12_autent = corrente.k12_autent
                                            INNER JOIN slip on slip.k17_codigo = corlanc.k12_codigo
                                            INNER JOIN conhist ON slip.k17_hist = conhist.c50_codhist
                                            INNER JOIN conplanoreduz on slip.k17_credito = conplanoreduz.c61_reduz and c61_anousu = " . db_getsession("DB_anousu") . "
                                            INNER JOIN conplano ON (conplano.c60_codcon, conplano.c60_anousu) = (conplanoreduz.c61_codcon, conplanoreduz.c61_anousu)
                                            INNER JOIN orctiporec on orctiporec.o15_codigo = conplanoreduz.c61_codigo
                                            INNER JOIN slipnum on slipnum.k17_codigo = slip.k17_codigo
                                            INNER JOIN cgm cc on cc.z01_numcgm = slipnum.k17_numcgm
                                            LEFT JOIN corconf ON corlanc.k12_id = corconf.k12_id
                                                        AND corlanc.k12_data = corconf.k12_data
                                                        AND corlanc.k12_autent = corconf.k12_autent
                                            LEFT JOIN empageconfche ON k12_codmov = e91_codcheque
                                            LEFT JOIN empagemovforma ON e91_codmov = e97_codmov
                                            LEFT JOIN empageforma ON e97_codforma = e96_codigo
                                            LEFT JOIN conlancamcorrente ON conlancamcorrente.c86_id = corrente.k12_id
                                                        AND conlancamcorrente.c86_data = corrente.k12_data
                                                        AND conlancamcorrente.c86_autent = corrente.k12_autent
                                            WHERE c86_id     = {$oExtMov->id}
                                                AND c86_data   = '{$oExtMov->data}'
                                                AND c86_autent = {$oExtMov->autent} ";

                        $rsExt30 = db_query($sSql30) or die($sSql30);

                        for ($linha30 = 0; $linha30 < pg_num_rows($rsExt30); $linha30++) {

                            $oExt30 = db_utils::fieldsMemory($rsExt30, $linha30);

                            $Hash30 = $oExt10Agrupado->si124_codext . $oExt30->codfontrecursos . $oExt30->nroop . $oExt30->codunidadesub;
                            $oExt30->especificacaoop = (trim(preg_replace("/[^a-zA-Z0-9 ]/", "", substr(str_replace($what, $by, $oExt30->especificacaoop), 0, 200))) == null ? $oExt30->c50_descr : trim(preg_replace("/[^a-zA-Z0-9 ]/", "", substr(str_replace($what, $by, $oExt30->especificacaoop), 0, 200))));

                            if (!isset($aExt20[$Hash20]->ext30[$Hash30])) {

                                $cExt30 = new stdClass();

                                $cExt30->si126_tiporegistro        = '30';
                                $cExt30->si126_codext              = $oExt10Agrupado->si124_codext;
                                $cExt30->si126_codfontrecursos     = $oExt30->fontepagadora;
                                $cExt30->si126_codreduzidoop       = $oExt30->codreduzidoop;
                                $cExt30->si126_nroop               = $oExt30->nroop;
                                $cExt30->si126_codunidadesub       = $oExt30->codunidadesub;
                                $cExt30->si126_dtpagamento         = $oExt30->dtpagamento;
                                $cExt30->si126_tipodocumentocredor = $oExt30->tipodocumentocredor;
                                $cExt30->si126_nrodocumentocredor  = $oExt30->nrodocumentocredor;
                                $cExt30->si126_vlop                = $oExt30->vlop;
                                $cExt30->si126_especificacaoop     = $oExt30->especificacaoop;
                                $cExt30->si126_cpfresppgto         = $cpfRespPGTO;
                                $cExt30->si126_mes                 = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                                $cExt30->si126_instit              = db_getsession("DB_instit");
                                $cExt30->ext31                     = array();
                                $aExt20[$Hash20]->ext30[$Hash30]   = $cExt30;
                            } else {
                                $aExt20[$Hash20]->ext30[$Hash30]->si126_vlop                += $oExt30->vlop;
                            }

                            $cExt31 = new stdClass();

                            $cExt31->si127_tiporegistro        = '31';
                            $cExt31->si127_codreduzidoop       = $oExt30->codreduzidoop;
                            $cExt31->si127_tipodocumentoop     = empty($oExt30->e91_codcheque) ? 99 : (($oExt30->e91_codcheque == 5) ? 5 : 1);
                            $cExt31->si127_nrodocumento        = $oExt30->e91_codcheque == 5 ? '' : (!empty($oExt30->e91_codcheque) ? $oExt30->e91_codcheque : $aExt20[$Hash20]->ext30[$Hash30]->si126_codreduzidoop);
                            $cExt31->si127_codctb              = $oExt30->e91_codcheque == 5 ? '' : $oExt30->contapagadora;
                            $cExt31->si127_codfontectb         = $oExt30->fontepagadora;
                            $cExt31->si127_desctipodocumentoop = $cExt31->si127_tipodocumentoop == 99 ? 'TED' : ' ';
                            $cExt31->si127_dtemissao           = $cExt30->si126_dtpagamento;
                            $cExt31->si127_vldocumento         = $cExt30->si126_vlop;
                            $cExt31->si127_mes                 = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                            $cExt31->si127_reg21               = 0;
                            $cExt31->si127_instit              = db_getsession("DB_instit");

                            $aExt20[$Hash20]->ext30[$Hash30]->ext31[]  = $cExt31;
                        }
                        //$aExt20[$Hash20] = $cExt20;
                    }
                }
            }
        }

        /**
         * Realiza trasnfer�ncias das fontes utilizadas no registro 20 para o registro da fonte principal (Cadastrada no PCASP)
         */
        if ($this->bEncerramento) {

            //Percorre array dos registros 20 para fazer as transfer�ncias nas fontes que n�o s�o principal
            foreach ($aExt20 as $sHash20 => $oExt20) {

                $sHashPrincipal = substr($sHash20, 0, -3) . $oExt20->iFontePrincipal;

                //Considera apena fonte diferente da principal
                if ($oExt20->iFontePrincipal != $oExt20->si165_codfontrecursos) {

                    //Guarda soma dos saldos atuais/finais das fontes para, posteriormente, atribuir para a principal
                    $aExt20[$sHashPrincipal]->iTotalSaldoAtual += $oExt20->si165_vlsaldoatualfonte;

                    /**
                     * Caso saldo final seja D: soma vlSaldoAtualFonte com totalCreditos
                     * Caso saldo final seja C: soma vlSaldoAtualFonte com totalDebitos
                     * Zera vlSaldoAtualFonte
                     */
                    if ($this->getNatSaldoAtual($oExt20) == 'D') {

                        $oExt20->si165_totalcreditos += $oExt20->si165_vlsaldoatualfonte;
                        $oExt20->si165_vlsaldoatualfonte = 0;

                    } elseif ($this->getNatSaldoAtual($oExt20) == 'C') {

                        $oExt20->si165_totaldebitos += abs($oExt20->si165_vlsaldoatualfonte);
                        $oExt20->si165_vlsaldoatualfonte = 0;

                    }

                }

            }

            //Percorre array dos registros 20 para atualizar os saldos da fonte principal
            foreach ($aExt20 as $sHash20 => $oExt20) {
                //Considera apenas fonte principal
                if ($oExt20->iFontePrincipal == $oExt20->si165_codfontrecursos) {
                    if (!isset($oExt20->iTotalSaldoAtual)) {
                        continue;
                    }
                    //Atualiza saldo atual da fonte principal utilizando o valor acumulado no for das fontes n�o principais
                    $oExt20->si165_vlsaldoatualfonte += $oExt20->iTotalSaldoAtual;

                    //Atualiza o cr�dito/d�bito da fonte principal
                    if ($oExt20->iTotalSaldoAtual > 0) {
                        $oExt20->si165_totaldebitos += abs($oExt20->iTotalSaldoAtual);
                    } else {
                        $oExt20->si165_totalcreditos += abs($oExt20->iTotalSaldoAtual);
                    }

                }

            }

        }
        foreach($aExt20 as $oExt20) {
            $hash = $this->getChave20($oExt20);

            if (array_key_exists($hash, $aExtExercicioCompDevo)) {

                foreach ($aExtExercicioCompDevo[$hash] as $ano => $devolucao) {
                    $aExt20[$hash]->si165_vlsaldoanteriorfonte -= $devolucao->valorInicial;
                    $aExt20[$hash]->si165_totaldebitos -= $devolucao->valor;
                    $aExt20[$hash]->si165_vlsaldoatualfonte = $aExt20[$hash]->si165_vlsaldoanteriorfonte + $aExt20[$hash]->si165_totaldebitos - $aExt20[$hash]->si165_totalcreditos;

                    $hashDevolucao = $hash . $ano;
                    $aExt20[$hashDevolucao] = new stdClass();
                    $aExt20[$hashDevolucao]->si165_tiporegistro = $aExt20[$hash]->si165_tiporegistro;
                    $aExt20[$hashDevolucao]->si165_codorgao = $aExt20[$hash]->si165_codorgao;
                    $aExt20[$hashDevolucao]->si165_codext = $aExt20[$hash]->si165_codext;
                    $aExt20[$hashDevolucao]->si165_codfontrecursos = $aExt20[$hash]->si165_codfontrecursos;
                    $aExt20[$hashDevolucao]->si165_exerciciocompdevo = $ano;
                    $aExt20[$hashDevolucao]->si165_vlsaldoanteriorfonte = $devolucao->valorInicial;
                    $aExt20[$hashDevolucao]->si165_natsaldoanteriorfonte = "D";
                    $aExt20[$hashDevolucao]->si165_totaldebitos = $devolucao->valor;
                    $aExt20[$hashDevolucao]->si165_totalcreditos = 0;
                    $aExt20[$hashDevolucao]->si165_vlsaldoatualfonte = $devolucao->valorInicial + $devolucao->valor;
                    $aExt20[$hashDevolucao]->si165_natsaldoatualfonte = "D";
                    $aExt20[$hashDevolucao]->si165_mes = $aExt20[$hash]->si165_mes;
                    $aExt20[$hashDevolucao]->si165_instit = $aExt20[$hash]->si165_instit;
                    $aExt20[$hashDevolucao]->ext30 = array();
                }
            }
        }

        $aExt20 = $this->lancamentosGenericos($aExt20);


        if($this->sDataFinal['5'] . $this->sDataFinal['6'] == '01' && db_getsession("DB_anousu") == 2023){
            $aExt20 = $this->lancamentosGenericosTransferenciaSaldoFonte($aExt20);
        }

        if($this->sDataFinal['5'] . $this->sDataFinal['6'] != '01' && db_getsession("DB_anousu") == 2023){
            $aExt20 = $this->lancamentosGenericosTransferenciaSaldoFontePosJaneiro($aExt20);
        }

        ksort($aExt20);
        foreach ($aExt20 as $oExt20) {

            $cExt   = new cl_ext202023();

            $cExt->si165_tiporegistro          = $oExt20->si165_tiporegistro;
            $cExt->si165_codorgao              = $oExt20->si165_codorgao;
            $cExt->si165_codext                = $oExt20->si165_codext;
            $cExt->si165_codfontrecursos       = $oExt20->si165_codfontrecursos;
            $cExt->si165_vlsaldoanteriorfonte  = abs($oExt20->si165_vlsaldoanteriorfonte);
            $cExt->si165_exerciciocompdevo = $oExt20->si165_exerciciocompdevo;
            if (($oExt20->si165_vlsaldoanteriorfonte) < 0) {
                $cExt->si165_natsaldoanteriorfonte = 'C';
            } elseif ((($oExt20->si165_vlsaldoanteriorfonte) > 0)) {
                $cExt->si165_natsaldoanteriorfonte = 'D';
            } else {
                $cExt->si165_natsaldoanteriorfonte = $oExt20->si165_natsaldoanteriorfonte;
            }

            $cExt->si165_totaldebitos          = $oExt20->si165_totaldebitos;
            $cExt->si165_totalcreditos         = $oExt20->si165_totalcreditos;
            $cExt->si165_vlsaldoatualfonte     = abs($oExt20->si165_vlsaldoatualfonte);
            if (substr($oExt20->si165_codfontrecursos, 1, 2) == '59') {
                $verificaNatSaldoAtual          = $oExt20->si165_vlsaldoatualfonte;
            } else {
                $verificaNatSaldoAtual          = ($oExt20->si165_vlsaldoanteriorfonte + $oExt20->si165_totaldebitos - $oExt20->si165_totalcreditos);
            }

            if ($verificaNatSaldoAtual < 0) {
                $cExt->si165_natsaldoatualfonte = 'C';
            } elseif ($verificaNatSaldoAtual > 0) {
                $cExt->si165_natsaldoatualfonte = 'D';
            } else {
                $cExt->si165_natsaldoatualfonte = $oExt20->si165_natsaldoatualfonte;
            }

            $cExt->si165_mes                   = $oExt20->si165_mes;
            $cExt->si165_instit                = $oExt20->si165_instit;
            $cExt->incluir(null);

            if ($cExt->erro_status == 0) {
                throw new Exception("Registro 20!\n" . $cExt->erro_msg);
            }
            foreach ($oExt20->ext30 as $oExtAgrupado) {

                $cExt30 = new cl_ext302023();

                $cExt30->si126_tiporegistro        = $oExtAgrupado->si126_tiporegistro;
                $cExt30->si126_codext              = $oExtAgrupado->si126_codext;
                $cExt30->si126_codfontrecursos     = $oExtAgrupado->si126_codfontrecursos;
                $cExt30->si126_codreduzidoop       = $oExtAgrupado->si126_codreduzidoop;
                $cExt30->si126_nroop               = $oExtAgrupado->si126_nroop;
                $cExt30->si126_codunidadesub       = $oExtAgrupado->si126_codunidadesub;
                $cExt30->si126_dtpagamento         = $oExtAgrupado->si126_dtpagamento;
                $cExt30->si126_tipodocumentocredor = $oExtAgrupado->si126_tipodocumentocredor;
                $cExt30->si126_nrodocumentocredor  = $oExtAgrupado->si126_nrodocumentocredor;
                $cExt30->si126_vlop                = $oExtAgrupado->si126_vlop;
                $cExt30->si126_especificacaoop     = $oExtAgrupado->si126_especificacaoop;
                $cExt30->si126_cpfresppgto         = $oExtAgrupado->si126_cpfresppgto;
                $cExt30->si126_mes                 = $oExtAgrupado->si126_mes;
                $cExt30->si126_instit              = $oExtAgrupado->si126_instit;

                $cExt30->incluir(null);
                if ($cExt30->erro_status == 0) {
                    throw new Exception("Registro 30!\n" . $cExt30->erro_msg);
                }

                foreach ($oExtAgrupado->ext31 as $oext31agrupado) {

                    $cExt31 = new cl_ext312023();


                    $cExt31->si127_tiporegistro        = 31;
                    $cExt31->si127_codreduzidoop       = $oext31agrupado->si127_codreduzidoop;
                    $cExt31->si127_tipodocumentoop     = $oext31agrupado->si127_tipodocumentoop;
                    $cExt31->si127_nrodocumento        = $oext31agrupado->si127_nrodocumento;
                    $cExt31->si127_codctb              = $oext31agrupado->si127_codctb;
                    $cExt31->si127_codfontectb         = $oext31agrupado->si127_codfontectb;
                    $cExt31->si127_desctipodocumentoop = $oext31agrupado->si127_desctipodocumentoop;
                    $cExt31->si127_dtemissao           = $oext31agrupado->si127_dtemissao;
                    $cExt31->si127_vldocumento         = $oext31agrupado->si127_vldocumento;
                    $cExt31->si127_mes                 = $oext31agrupado->si127_mes;
                    $cExt31->si127_reg30               = $cExt30->si126_sequencial;
                    $cExt31->si127_instit              = db_getsession("DB_instit");

                    $cExt31->incluir(null);
                    if ($cExt31->erro_status == 0) {
                        throw new Exception("Registro 31!\n" . $cExt31->erro_msg);
                    }
                }
            }
        }

        db_fim_transacao();
        $oGerarEXT = new GerarEXT();
        $oGerarEXT->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oGerarEXT->gerarDados();
    }

    public function getSql20FonteBase($nExtras)
    {
        return " select c61_reduz  as codext, 0 as contrapart, o15_codigo as fonte
                    from conplano
            inner join conplanoreduz on conplanoreduz.c61_codcon = conplano.c60_codcon and conplanoreduz.c61_anousu = conplano.c60_anousu
            inner join orctiporec on o15_codigo = c61_codigo
                where conplanoreduz.c61_reduz  in ({$nExtras})
                    and conplanoreduz.c61_anousu = " . db_getsession("DB_anousu") . "
            UNION ALL
                select ces01_reduz as codext, ces01_reduz as contrapart,ces01_fonte as fonte
                    from conextsaldo
            inner join conplanoreduz on conextsaldo.ces01_reduz = conplanoreduz.c61_reduz
                    and conplanoreduz.c61_anousu = conextsaldo.ces01_anousu
                where conextsaldo.ces01_reduz  in ({$nExtras})
                    and conextsaldo.ces01_anousu = " . db_getsession("DB_anousu") . "
            UNION ALL
                SELECT  conlancamval.c69_credito AS codext,
                        conlancamval.c69_debito as contrapart,
                            orctiporec.o15_codigo AS fonte
                    FROM conlancamdoc
            INNER JOIN conlancamval ON conlancamval.c69_codlan = conlancamdoc.c71_codlan
            INNER JOIN conplanoreduz ON conlancamval.c69_debito = conplanoreduz.c61_reduz
                    AND conlancamval.c69_anousu = conplanoreduz.c61_anousu
            INNER JOIN orctiporec ON orctiporec.o15_codigo = conplanoreduz.c61_codigo
            INNER JOIN conlancaminstit ON conlancaminstit.c02_codlan = conlancamval.c69_codlan
            INNER JOIN conlancamcorrente ON conlancamcorrente.c86_conlancam = conlancamval.c69_codlan
            LEFT JOIN infocomplementaresinstit ON infocomplementaresinstit.si09_instit = conlancaminstit.c02_instit
                WHERE conlancamdoc.c71_coddoc IN (120,121,130,131,150,151,152,153,160,161,162,163,3000)
                    and conlancamval.c69_credito in ({$nExtras})
                    and DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . "
                    and DATE_PART('MONTH',conlancamdoc.c71_data) <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                    and conlancaminstit.c02_instit = " . db_getsession("DB_instit") . "
            UNION ALL
                SELECT conlancamval.c69_debito AS codext,
                        conlancamval.c69_credito as contrapart,
                            orctiporec.o15_codigo AS fonte
                    FROM conlancamdoc
            INNER JOIN conlancamval ON conlancamval.c69_codlan = conlancamdoc.c71_codlan
            INNER JOIN conplanoreduz ON conlancamval.c69_credito = conplanoreduz.c61_reduz
                    AND conlancamval.c69_anousu = conplanoreduz.c61_anousu
            INNER JOIN orctiporec ON orctiporec.o15_codigo = conplanoreduz.c61_codigo
            INNER JOIN conlancaminstit ON conlancaminstit.c02_codlan = conlancamval.c69_codlan
            INNER JOIN conlancamcorrente ON conlancamcorrente.c86_conlancam = conlancamval.c69_codlan
            LEFT JOIN infocomplementaresinstit ON infocomplementaresinstit.si09_instit = conlancaminstit.c02_instit
                WHERE conlancamdoc.c71_coddoc IN (120,121,130,131,150,151,152,153,160,161,162,163,3000)
                    and conlancamval.c69_debito in ({$nExtras})
                    and DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . "
                    and DATE_PART('MONTH',conlancamdoc.c71_data) <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                    and conlancaminstit.c02_instit = " . db_getsession("DB_instit") . " ";
    }

    public function getExtRecursoTCE($fonte)
    {
        /* SQL RETORNA O CODTRI DA FONTE */
        $sSqlExtRecurso = "SELECT o15_codtri FROM orctiporec WHERE o15_codigo = " . $fonte;
        $rsExtRecurso = db_query($sSqlExtRecurso);
        return db_utils::fieldsMemory($rsExtRecurso, 0)->o15_codtri; //fonte encerrada
    }

    public function recuperarExercicioCompetenciaDevolucao($nExtras, $iCodOrgao, $aExtExercicioCompDevo)
    {
        if ($this->sDataFinal['5'] . $this->sDataFinal['6'] != "01")
            $aExtExercicioCompDevo = $this->recuperarExercicioCompetenciaDevolucaoAnterior($nExtras, $iCodOrgao, $aExtExercicioCompDevo);

        $sSql20Fonte  = " SELECT DISTINCT codext, fonte, contrapart from ( ";
        $sSql20Fonte .= $this->getSql20FonteBase($nExtras);
        $sSql20Fonte .= " ) as extfonte order by codext, fonte ";

        $rsExt20FonteRecurso = db_query($sSql20Fonte);
        for ($iC = 0; $iC < pg_num_rows($rsExt20FonteRecurso); $iC++) {
            $oContaExtraFonte = db_utils::fieldsMemory($rsExt20FonteRecurso, $iC);
            $oExtRecursoTCE = $this->getExtRecursoTCE($oContaExtraFonte->fonte);

            $sql = " SELECT
                        k17_devolucao devolucao,
                        c69_valor valor
                    FROM conlancamdoc
                    INNER JOIN conlancamval ON conlancamval.c69_codlan = conlancamdoc.c71_codlan
                    INNER JOIN conplanoreduz ON conlancamval.c69_credito = conplanoreduz.c61_reduz
                        AND conlancamval.c69_anousu = conplanoreduz.c61_anousu
                    INNER JOIN orctiporec ON orctiporec.o15_codigo = conplanoreduz.c61_codigo
                    INNER JOIN conlancaminstit ON conlancaminstit.c02_codlan = conlancamval.c69_codlan
                    INNER JOIN conlancamcorrente ON conlancamcorrente.c86_conlancam = conlancamval.c69_codlan
                    LEFT JOIN infocomplementaresinstit ON infocomplementaresinstit.si09_instit = conlancaminstit.c02_instit
                    LEFT JOIN slip on k17_debito = c69_debito AND k17_credito = c69_credito AND k17_dtaut = c71_data AND k17_valor = c69_valor
                    WHERE conlancamdoc.c71_coddoc IN (120,121,130,131,150,151,152,153,160,161,162,163,3000)
                        and conlancamval.c69_debito = {$oContaExtraFonte->codext}
                        AND orctiporec.o15_codigo = {$oContaExtraFonte->fonte}
                        AND conlancamval.c69_credito = {$oContaExtraFonte->contrapart}
                        and DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . "
                        AND k17_devolucao IS NOT NULL
                        and DATE_PART('MONTH',conlancamdoc.c71_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                        and conlancaminstit.c02_instit = " . db_getsession("DB_instit");

            $resultado = db_query($sql) or die($sql);
            for ($linha = 0; $linha < pg_num_rows($resultado); $linha++) {
                $data = db_utils::fieldsMemory($resultado, $linha);
                $hash = "20{$iCodOrgao}{$oContaExtraFonte->codext}" . $oExtRecursoTCE;
                if (array_key_exists($hash, $aExtExercicioCompDevo)) {
                    if (array_key_exists($data->devolucao, $aExtExercicioCompDevo[$hash])) {
                        $aExtExercicioCompDevo[$hash][$data->devolucao]->valor += $data->valor;
                        continue;
                    }
                    $aExtExercicioCompDevo[$hash][$data->devolucao] = new stdClass();
                    $aExtExercicioCompDevo[$hash][$data->devolucao]->devolucao = $data->devolucao;
                    $aExtExercicioCompDevo[$hash][$data->devolucao]->valor = $data->valor;
                    continue;
                }
                $aExtExercicioCompDevo[$hash][$data->devolucao] = new stdClass();
                $aExtExercicioCompDevo[$hash][$data->devolucao]->devolucao = $data->devolucao;
                $aExtExercicioCompDevo[$hash][$data->devolucao]->valor = $data->valor;
            }
        }
        return $aExtExercicioCompDevo;
    }

    public function recuperarExercicioCompetenciaDevolucaoAnterior($nExtras, $iCodOrgao, $aExtExercicioCompDevo)
    {
        $sSql20Fonte  = " SELECT DISTINCT codext, fonte, contrapart from ( ";
        $sSql20Fonte .= $this->getSql20FonteBase($nExtras);
        $sSql20Fonte .= " ) as extfonte order by codext, fonte ";

        $rsExt20FonteRecurso = db_query($sSql20Fonte);
        for ($iC = 0; $iC < pg_num_rows($rsExt20FonteRecurso); $iC++) {
            $oContaExtraFonte = db_utils::fieldsMemory($rsExt20FonteRecurso, $iC);
            $oExtRecursoTCE = $this->getExtRecursoTCE($oContaExtraFonte->fonte);

            $sql = " SELECT
                        k17_devolucao devolucao,
                        c69_valor valor
                    FROM conlancamdoc
                    INNER JOIN conlancamval ON conlancamval.c69_codlan = conlancamdoc.c71_codlan
                    INNER JOIN conplanoreduz ON conlancamval.c69_credito = conplanoreduz.c61_reduz
                        AND conlancamval.c69_anousu = conplanoreduz.c61_anousu
                    INNER JOIN orctiporec ON orctiporec.o15_codigo = conplanoreduz.c61_codigo
                    INNER JOIN conlancaminstit ON conlancaminstit.c02_codlan = conlancamval.c69_codlan
                    INNER JOIN conlancamcorrente ON conlancamcorrente.c86_conlancam = conlancamval.c69_codlan
                    LEFT JOIN infocomplementaresinstit ON infocomplementaresinstit.si09_instit = conlancaminstit.c02_instit
                    LEFT JOIN slip on k17_debito = c69_debito AND k17_credito = c69_credito AND k17_dtaut = c71_data AND k17_valor = c69_valor
                    WHERE conlancamdoc.c71_coddoc IN (120,121,130,131,150,151,152,153,160,161,162,163,3000)
                        and conlancamval.c69_debito = {$oContaExtraFonte->codext}
                        AND orctiporec.o15_codigo = {$oContaExtraFonte->fonte}
                        AND conlancamval.c69_credito = {$oContaExtraFonte->contrapart}
                        and DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . "
                        AND k17_devolucao IS NOT NULL
                        and DATE_PART('MONTH',conlancamdoc.c71_data) < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                        and conlancaminstit.c02_instit = " . db_getsession("DB_instit");

            $resultado = db_query($sql) or die($sql);
            for ($linha = 0; $linha < pg_num_rows($resultado); $linha++) {
                $data = db_utils::fieldsMemory($resultado, $linha);
                $hash = "20{$iCodOrgao}{$oContaExtraFonte->codext}" . $oExtRecursoTCE;
                if (array_key_exists($hash, $aExtExercicioCompDevo)) {
                    if (array_key_exists($data->devolucao, $aExtExercicioCompDevo[$hash])) {
                        $aExtExercicioCompDevo[$hash][$data->devolucao]->valorInicial += $data->valor;
                        continue;
                    }
                    $aExtExercicioCompDevo[$hash][$data->devolucao] = new stdClass();
                    $aExtExercicioCompDevo[$hash][$data->devolucao]->devolucao = $data->devolucao;
                    $aExtExercicioCompDevo[$hash][$data->devolucao]->valorInicial = $data->valor;
                    $aExtExercicioCompDevo[$hash][$data->devolucao]->valor = 0;
                    continue;
                }
                $aExtExercicioCompDevo[$hash][$data->devolucao] = new stdClass();
                $aExtExercicioCompDevo[$hash][$data->devolucao]->devolucao = $data->devolucao;
                $aExtExercicioCompDevo[$hash][$data->devolucao]->valorInicial = $data->valor;
                $aExtExercicioCompDevo[$hash][$data->devolucao]->valor = 0;
            }
        }
        return $aExtExercicioCompDevo;
    }

    public function lancamentosGenericosTransferenciaSaldoFonte($aExt20)
    {

        $aExt20Novo = array();

        foreach($aExt20 as $oExt20){
            $oFonteNova = 0;
            if($oExt20->si165_codfontrecursos < 999){
                continue;
            }
            //criar registro nova fonte
            $hash = $oExt20->si165_tiporegistro.$oExt20->si165_codorgao.$oExt20->si165_codext.$oExt20->si165_codfontrecursos;
            $aExt20Novo[$hash] = $oExt20;
        }

        foreach($aExt20 as $oExt20){
            $oFonteNova = 0;

            if($oExt20->si165_codfontrecursos < 999){
                $oFonteNova = substr($this->oDeParaRecurso->getDePara($oExt20->si165_codfontrecursos), 0, 7);
            }

            if($oFonteNova == 0){
                continue;
            }
            //criar registro que encerra fonte do ano anterior
            $cExt20   = new stdClass();
            $cExt20->si165_tiporegistro          = $oExt20->si165_tiporegistro;
            $cExt20->si165_codorgao              = $oExt20->si165_codorgao;
            $cExt20->si165_codext                = $oExt20->si165_codext;
            $cExt20->si165_codfontrecursos       = $oExt20->si165_codfontrecursos;
            $cExt20->si165_exerciciocompdevo     = $oExt20->si165_exerciciocompdevo;
            $cExt20->si165_vlsaldoanteriorfonte  = $oExt20->si165_vlsaldoanteriorfonte;
            $cExt20->si165_natsaldoanteriorfonte = $oExt20->si165_natsaldoanteriorfonte;
            if($oExt20->si165_natsaldoatualfonte == 'D'){
                $cExt20->si165_totalcreditos     = abs($oExt20->si165_vlsaldoatualfonte);
            }
            if($oExt20->si165_natsaldoatualfonte == 'C'){
                $cExt20->si165_totaldebitos      = abs($oExt20->si165_vlsaldoatualfonte);
            }
            $cExt20->si165_vlsaldoatualfonte     = 0;
            $cExt20->si165_natsaldoatualfonte    = $oExt20->si165_natsaldoanteriorfont;
            $cExt20->si165_mes                   = $oExt20->si165_mes;
            $cExt20->si165_instit                = $oExt20->si165_instit;
            $hashAnterior = $oExt20->si165_tiporegistro.$oExt20->si165_codorgao.$oExt20->si165_codext.$oExt20->si165_codfontrecursos;
            $aExt20Novo[$hashAnterior]           = $cExt20;

            $hashNovo = $oExt20->si165_tiporegistro.$oExt20->si165_codorgao.$oExt20->si165_codext.$oFonteNova;
            if(!isset($aExt20Novo[$hashNovo])){
                $cExt20Novo   = new stdClass();
                $cExt20Novo->si165_tiporegistro          = $oExt20->si165_tiporegistro;
                $cExt20Novo->si165_codorgao              = $oExt20->si165_codorgao;
                $cExt20Novo->si165_codext                = $oExt20->si165_codext;
                $cExt20Novo->si165_codfontrecursos       = $oFonteNova;
                $cExt20Novo->si165_exerciciocompdevo     = $oExt20->si165_exerciciocompdevo;
                $cExt20Novo->si165_vlsaldoanteriorfonte  = 0;
                $cExt20Novo->si165_natsaldoanteriorfonte = 'D';
                if($oExt20->si165_natsaldoatualfonte == 'D'){
                    $cExt20Novo->si165_totaldebitos      = abs($oExt20->si165_vlsaldoatualfonte);
                }
                if($oExt20->si165_natsaldoatualfonte == 'C'){
                    $cExt20Novo->si165_totalcreditos      = abs($oExt20->si165_vlsaldoatualfonte);
                }
                $cExt20Novo->si165_vlsaldoatualfonte  = $cExt20Novo->si165_vlsaldoanteriorfonte + $cExt20Novo->si165_totaldebitos - $cExt20Novo->si165_totalcreditos;

                if($cExt20Novo->si165_vlsaldoatualfonte > 0){
                    $cExt20Novo->si165_natsaldoatualfonte    = 'D';
                }else {
                    $cExt20Novo->si165_natsaldoatualfonte    = 'C';
                }
                $cExt20Novo->si165_mes                   = $oExt20->si165_mes;
                $cExt20Novo->si165_instit                = $oExt20->si165_instit;
                $cExt20Novo->ext30                       = $oExt20->ext30;
                $aExt20Novo[$hashNovo]                   = $cExt20Novo;
            } else {
                if($oExt20->si165_natsaldoatualfonte == 'D'){
                    $aExt20Novo[$hashNovo]->si165_totaldebitos += abs($oExt20->si165_vlsaldoatualfonte);
                }
                if($oExt20->si165_natsaldoatualfonte == 'C'){
                    $aExt20Novo[$hashNovo]->si165_totalcreditos  += abs($oExt20->si165_vlsaldoatualfonte);
                }

                $aExt20Novo[$hashNovo]->si165_vlsaldoatualfonte     = $aExt20Novo[$hashNovo]->si165_vlsaldoanteriorfonte + $aExt20Novo[$hashNovo]->si165_totaldebitos - $aExt20Novo[$hashNovo]->si165_totalcreditos;
                if($aExt20Novo[$hashNovo]->si165_vlsaldoatualfonte > 0){
                    $aExt20Novo[$hashNovo]->si165_natsaldoatualfonte    =  'D';
                }else {
                    $aExt20Novo[$hashNovo]->si165_natsaldoatualfonte    =  'C';
                }
            }

        }
        return $aExt20Novo;
    }

    public function lancamentosGenericosTransferenciaSaldoFontePosJaneiro($aExt20)
    {
        $aExt20Novo = array();
        $iMes = (int)($this->sDataFinal['5'] . $this->sDataFinal['6']) - 1;

        foreach($aExt20 as $oExt20){

            $oFonteNova = $oExt20->si165_codfontrecursos;
            if($oExt20->si165_codfontrecursos < 999){
                $oFonteNova = substr($this->oDeParaRecurso->getDePara($oExt20->si165_codfontrecursos), 0, 7);
            }

            $nVlSaldoAnteriorFonte = 0;
            $sNatSaldoAnteriorFonte = 'C';
            $sSaldoAnterior  = "select si165_vlsaldoatualfonte, si165_natsaldoatualfonte ";
            $sSaldoAnterior .= " from ext202023 where si165_mes={$iMes} and si165_instit={$oExt20->si165_instit} ";
            $sSaldoAnterior .= " and si165_codext={$oExt20->si165_codext} and si165_codfontrecursos={$oFonteNova} ";
            $rsSaldoAnterior = db_query($sSaldoAnterior);
            $oSaldoAnterior  = db_utils::fieldsMemory($rsSaldoAnterior, 0);

            if(!empty($oSaldoAnterior)){
                $nVlSaldoAnteriorFonte = $oSaldoAnterior->si165_natsaldoatualfonte == 'D' ? $oSaldoAnterior->si165_vlsaldoatualfonte : ($oSaldoAnterior->si165_vlsaldoatualfonte * -1);
                $sNatSaldoAnteriorFonte = $oSaldoAnterior->si165_natsaldoatualfonte;
            }
            $cExt20   = new stdClass();
            $cExt20->si165_tiporegistro          = $oExt20->si165_tiporegistro;
            $cExt20->si165_codorgao              = $oExt20->si165_codorgao;
            $cExt20->si165_codext                = $oExt20->si165_codext;
            $cExt20->si165_codfontrecursos       = $oFonteNova;
            $cExt20->si165_exerciciocompdevo     = $oExt20->si165_exerciciocompdevo;
            $cExt20->si165_vlsaldoanteriorfonte  = $nVlSaldoAnteriorFonte;
            $cExt20->si165_natsaldoanteriorfonte = $sNatSaldoAnteriorFonte;
            $cExt20->si165_totalcreditos         = $oExt20->si165_totalcreditos;
            $cExt20->si165_totaldebitos          = $oExt20->si165_totaldebitos;
            $cExt20->si165_vlsaldoatualfonte     = $cExt20->si165_vlsaldoanteriorfonte + $cExt20->si165_totaldebitos - $cExt20->si165_totalcreditos;
            $cExt20->si165_natsaldoatualfonte    = $cExt20->si165_vlsaldoatualfonte > 0 ? 'D' : 'C';
            $cExt20->si165_mes                   = $oExt20->si165_mes;
            $cExt20->si165_instit                = $oExt20->si165_instit;
            $cExt20->ext30                       = $oExt20->ext30;
            $hashNovo = $oExt20->si165_tiporegistro.$oExt20->si165_codorgao.$oExt20->si165_codext.$oFonteNova;
            $aExt20Novo[$hashNovo]                        = $cExt20;
        }
        return $aExt20Novo;
    }

    public function lancamentosGenericos($aExt20)
    {
        return $this->buscarGenericos($aExt20);
    }

    public function buscarGenericos($aExt20)
    {
        $sSqlGenerico = "SELECT DISTINCT codext as si165_codext, fonte as si165_codfontrecursos, codorgao AS si165_codorgao FROM (
                SELECT
                    CASE
                        WHEN c61_codtce IS NULL THEN c69_debito
                        ELSE c61_codtce
                    END codext,
                    orctiporec.o15_codigo as fonte,
                    si09_codorgaotce AS codorgao
                FROM
                    conlancamdoc
                    inner join conlancamval on conlancamval.c69_codlan = conlancamdoc.c71_codlan
                    inner join conplanoreduz on conlancamval.c69_debito = conplanoreduz.c61_reduz
                    and conlancamval.c69_anousu = conplanoreduz.c61_anousu
                    inner join contacorrentedetalheconlancamval on conlancamval.c69_sequen = contacorrentedetalheconlancamval.c28_conlancamval
                    inner join contacorrentedetalhe on contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                    AND c19_reduz = c69_debito
                    left join orctiporec on orctiporec.o15_codigo = contacorrentedetalhe.c19_orctiporec
                    LEFT JOIN infocomplementaresinstit ON si09_instit = c61_instit
                    inner join conplano on conplanoreduz.c61_codcon = conplano.c60_codcon and conplanoreduz.c61_anousu = conplano.c60_anousu
                where
                    conlancamdoc.c71_coddoc in (3000)
                     AND c60_codsis = 7
                    and DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . "
                    and DATE_PART('MONTH',conlancamdoc.c71_data) <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                    and conplanoreduz.c61_instit = " . db_getsession("DB_instit") . "

                UNION

                SELECT
                    CASE
                        WHEN c61_codtce IS NULL THEN c69_credito
                        ELSE c61_codtce
                    END codext,
                    orctiporec.o15_codigo as fonte,
                    si09_codorgaotce AS codorgao
                FROM
                    conlancamdoc
                    inner join conlancamval on conlancamval.c69_codlan = conlancamdoc.c71_codlan
                    inner join conplanoreduz on conlancamval.c69_credito = conplanoreduz.c61_reduz
                    and conlancamval.c69_anousu = conplanoreduz.c61_anousu
                    inner join contacorrentedetalheconlancamval on conlancamval.c69_sequen = contacorrentedetalheconlancamval.c28_conlancamval
                    inner join contacorrentedetalhe on contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                    AND c19_reduz = c69_credito
                    left join orctiporec on orctiporec.o15_codigo = contacorrentedetalhe.c19_orctiporec
                    LEFT JOIN infocomplementaresinstit ON si09_instit = c61_instit
                    inner join conplano on conplanoreduz.c61_codcon = conplano.c60_codcon and conplanoreduz.c61_anousu = conplano.c60_anousu
                where
                    conlancamdoc.c71_coddoc in (3000)
                     AND c60_codsis = 7
                    and DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . "
                    and DATE_PART('MONTH',conlancamdoc.c71_data) <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                    and conplanoreduz.c61_instit = " . db_getsession("DB_instit") . "
            ) as x ";

        $rsGenerico = db_query($sSqlGenerico);
        for ($iC = 0; $iC < pg_num_rows($rsGenerico); $iC++) {
            $oExt20 = db_utils::fieldsMemory($rsGenerico, $iC);

            $fSaldoInicial = 0;
            $fDebito       = 0;
            $fCredito      = 0;

            $fSaldoInicial  += $this->getInicialDebitoGenerico($oExt20);
            $fSaldoInicial  -= $this->getInicialCreditoGenerico($oExt20);
            $fDebito        += $this->getDebitoGenerico($oExt20);
            $fCredito       += $this->getCreditoGenerico($oExt20);

            $aExt20 = $this->atualizaEXT20($aExt20, $oExt20, $fSaldoInicial, $fDebito, $fCredito);
        }
        return $aExt20;
    }

    public function atualizaEXT20($aExt20, $oExt20, $fSaldoInicial, $fDebito, $fCredito)
    {
        if ($fSaldoInicial <> 0 OR $fDebito <> 0 OR $fCredito <> 0) {
            $chave = $this->getChave20($oExt20);
            if (array_key_exists($chave, $aExt20)) {
                $aExt20[$chave]->si165_vlsaldoanteriorfonte += $fSaldoInicial;
                $aExt20[$chave]->si165_totaldebitos += $fDebito;
                $aExt20[$chave]->si165_totalcreditos += $fCredito;
                $aExt20[$chave]->si165_vlsaldoatualfonte = $aExt20[$chave]->si165_vlsaldoanteriorfonte + $aExt20[$chave]->si165_totaldebitos - $aExt20[$chave]->si165_totalcreditos;
                return $aExt20;
            } else {
                $aExt20[$chave] = new stdClass();
                $aExt20[$chave]->si165_tiporegistro = 20;
                $aExt20[$chave]->si165_codorgao = $oExt20->si165_codorgao;
                $aExt20[$chave]->si165_codext = $oExt20->si165_codext;
                $aExt20[$chave]->si165_codfontrecursos = $oExt20->si165_codfontrecursos;
                $aExt20[$chave]->si165_exerciciocompdevo = "";
                $aExt20[$chave]->si165_vlsaldoanteriorfonte = $fSaldoInicial;
                $aExt20[$chave]->si165_natsaldoanteriorfonte = "C";
                $aExt20[$chave]->si165_totaldebitos = $fDebito;
                $aExt20[$chave]->si165_totalcreditos = $fCredito;
                $aExt20[$chave]->si165_vlsaldoatualfonte = $fSaldoInicial + $fDebito - $fCredito;
                $aExt20[$chave]->si165_natsaldoatualfonte = "C";
                $aExt20[$chave]->si165_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $aExt20[$chave]->si165_instit = db_getsession("DB_instit");
                $aExt20[$chave]->ext30 = array();
                return $aExt20;
            }
        }
        return $aExt20;
    }

    public function getChave20($oExt20)
    {
        return "20{$oExt20->si165_codorgao}{$oExt20->si165_codext}{$oExt20->si165_codfontrecursos}";
    }


    public function getInicialDebitoGenerico($oExt20)
    {
        return $this->getLancamentoGenerico($oExt20, "debito", true);
    }

    public function getInicialCreditoGenerico($oExt20)
    {
        return $this->getLancamentoGenerico($oExt20, "credito", true);
    }

    public function getDebitoGenerico($oExt20)
    {
        return $this->getLancamentoGenerico($oExt20, "debito");
    }

    public function getCreditoGenerico($oExt20)
    {
        return $this->getLancamentoGenerico($oExt20, "credito");
    }

    public function getLancamentoGenerico($oExt20, $sTipoValor, $bSaldoInicial = false)
    {
        $sControleSinal = !$bSaldoInicial ? "=" : "<";

        $sql  = " SELECT COALESCE( ";
        $sql .= "    ( SELECT ROUND( SUM(conlancamval.c69_valor), 2) as valor ";
        $sql .= "     FROM conlancamdoc ";
        $sql .= "       inner join conlancamval on conlancamval.c69_codlan = conlancamdoc.c71_codlan ";
        $sql .= "       inner join conplanoreduz on conlancamval.c69_{$sTipoValor} = conplanoreduz.c61_reduz ";
        $sql .= "           and conlancamval.c69_anousu = conplanoreduz.c61_anousu ";
        $sql .= "       inner join contacorrentedetalheconlancamval on conlancamval.c69_sequen = contacorrentedetalheconlancamval.c28_conlancamval ";
        $sql .= "       inner join contacorrentedetalhe on contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe ";
        $sql .= "       left join orctiporec on orctiporec.o15_codigo = contacorrentedetalhe.c19_orctiporec AND c19_reduz = c69_{$sTipoValor} ";
        $sql .= "     where conlancamdoc.c71_coddoc in (3000) ";
        $sql .= "       and ( ";
        $sql .= "           (conlancamval.c69_{$sTipoValor} = {$oExt20->si165_codext} AND conplanoreduz.c61_codtce IS NULL) ";
        $sql .= "           OR conplanoreduz.c61_codtce = {$oExt20->si165_codext} ";
        $sql .= "       ) ";
        $sql .= "       and DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . " ";
        $sql .= "       and DATE_PART('MONTH',conlancamdoc.c71_data) {$sControleSinal} " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " ";
        $sql .= "       and conplanoreduz.c61_instit = " . db_getsession("DB_instit") . " ";
        $sql .= "       and orctiporec.o15_codigo::int = {$oExt20->si165_codfontrecursos}), 0) as valor ";

        $result = db_query($sql);
        return db_utils::fieldsMemory($result, 0)->valor;
    }
}
