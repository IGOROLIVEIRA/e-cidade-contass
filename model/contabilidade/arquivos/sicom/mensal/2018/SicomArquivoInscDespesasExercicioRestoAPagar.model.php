<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_iderp102018_classe.php");
require_once ("classes/db_iderp112018_classe.php");
require_once ("classes/db_iderp202018_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2018/GerarIDERP.model.php");
/**
 * TomadasContasEspeciais Sicom Acompanhamento Mensal
 * @author Mario Junior
 * @package Contabilidade
 */
class SicomArquivoInscDespesasExercicioRestoAPagar extends SicomArquivoBase implements iPadArquivoBaseCSV {

    /**
     *
     * Codigo do layout. (db_layouttxt.db50_codigo)
     * @var Integer
     */
    protected $iCodigoLayout;

    /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'IDERP';

    /**
     *
     * Construtor da classe
     */
    public function __construct() {

    }

    /**
     * Retorna o codigo do layout
     *
     * @return Integer
     */
    public function getCodigoLayout(){
        return $this->iCodigoLayout;
    }

    /**
     *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
     */
    public function getCampos(){

    }

    public function getSeqEmpenho($codemp,$anousu){
        $sql = "select e60_numemp from empempenho where e60_codemp = '$codemp' and e60_anousu = $anousu";
        $result = db_query($sql);
        $SequencialEmp = db_utils::fieldsMemory($result, 0)->e60_numemp;

        return $SequencialEmp;
    }


    public function getCodUnidSub($codemp,$anousu){

        $sql = "SELECT DISTINCT lpad((CASE
                          WHEN orcorgao.o40_codtri = '0'
                               OR NULL THEN orcorgao.o40_orgao::varchar
                          ELSE orcorgao.o40_codtri
                      END),2,0)||lpad((CASE
                                           WHEN orcunidade.o41_codtri = '0'
                                                OR NULL THEN orcunidade.o41_unidade::varchar
                                           ELSE orcunidade.o41_codtri
                                       END),3,0)||(CASE WHEN orcunidade.o41_subunidade = '0'
                                                             OR NULL THEN ''
                                                        ELSE lpad(orcunidade.o41_subunidade::VARCHAR,3,0)
                                                   END) AS codunidadesub
FROM empempenho
JOIN orcdotacao ON e60_coddot = o58_coddot
JOIN empelemento ON e60_numemp = e64_numemp
JOIN orcelemento ON e64_codele = o56_codele
JOIN orctiporec ON o58_codigo = o15_codigo
JOIN emptipo ON e60_codtipo = e41_codtipo
JOIN cgm ON e60_numcgm = z01_numcgm
JOIN orcprojativ ON o58_anousu = o55_anousu
AND o58_projativ = o55_projativ
LEFT JOIN pctipocompra ON e60_codcom = pc50_codcom
LEFT JOIN cflicita ON pc50_pctipocompratribunal = l03_pctipocompratribunal
AND l03_instit = 1
LEFT JOIN infocomplementaresinstit ON si09_instit = e60_instit
LEFT JOIN liclicita ON ltrim(((string_to_array(e60_numerol, '/'))[1])::varchar,'0') = l20_edital::varchar
AND l20_anousu::varchar = ((string_to_array(e60_numerol, '/'))[2])::varchar
AND l03_codigo = l20_codtipocom
LEFT JOIN orcunidade ON o58_anousu = orcunidade.o41_anousu
AND o58_orgao = orcunidade.o41_orgao
AND o58_unidade = orcunidade.o41_unidade
LEFT JOIN orcorgao ON orcorgao.o40_orgao = orcunidade.o41_orgao
AND orcorgao.o40_anousu = orcunidade.o41_anousu
LEFT JOIN cgm o ON o.z01_numcgm = orcunidade.o41_orddespesa
LEFT JOIN homologacaoadjudica ON l20_codigo = l202_licitacao
LEFT JOIN empempaut ON e61_numemp = e60_numemp
LEFT JOIN empautoriza ON e61_autori = e60_numemp
LEFT JOIN acordoitemexecutadoempautitem on ac19_autori = e61_autori
LEFT JOIN acordoitemexecutado on ac29_sequencial = ac19_acordoitemexecutado
LEFT JOIN acordoitem on ac20_sequencial = ac29_acordoitem
LEFT JOIN acordoposicao on ac20_acordoposicao = ac26_sequencial
LEFT JOIN acordo on ac26_acordo = ac16_sequencial and ac16_acordosituacao = 4
WHERE e60_anousu = $anousu
AND o56_anousu = $anousu
AND o58_anousu = $anousu
AND e60_instit = ".db_getsession("DB_instit")."
AND e60_codemp = '$codemp'";

        $result = db_query($sql);
//        echo $sql;exit;
        $CodUnidadeSub = db_utils::fieldsMemory($result, 0)->codunidadesub;

        return $CodUnidadeSub;
    }

    public function getReg10($seqEmp){

        $sSql = "select si179_sequencial from iderp102018 where si179_codreduzidoiderp = $seqEmp";
        $result = db_query($sSql);
        $codSeqReg10 = db_utils::fieldsMemory($result, 0)->si179_sequencial;

        return $codSeqReg10;
    }

    public function getVlrInscricaoFonte($seqEmp){
        $sSql = "select c223_vlrnaoliquidado,c223_vlrliquidado from iderp102018 where si179_codreduzidoiderp = $seqEmp";
        $result = db_query($sSql);

        for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

            $oDados10 = db_utils::fieldsMemory($result, $iCont);
        }

        $valornaoliquidado = 0;
        $valorliquidado = 0;

        foreach ($oDados10 as $emp) {
            $valornaoliquidado += $emp->c223_vlrnaoliquidado;
            $valorliquidado += $emp->c223_vlrliquidado;
        }

//        echo $valornaoliquidado; exit;
    }




    /**
     * selecionar os dados de Dados
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados()
    {

        $iderp102018 = new cl_iderp102018();
        $iderp112018 = new cl_iderp112018();
        $iderp202018 = new cl_iderp202018();


        db_inicio_transacao();

        /*
         * excluir informacoes do mes selecionado
         */
        $result = $iderp202018->sql_record($iderp202018->sql_query(NULL, "*", NULL, "si181_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si181_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $iderp202018->excluir(NULL, "si181_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si181_instit = " . db_getsession("DB_instit"));
            if ($iderp202018->erro_status == 0) {
                throw new Exception($iderp202018->erro_msg);
            }
        }
        $result = $iderp112018->sql_record($iderp112018->sql_query(NULL, "*", NULL, "si180_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si180_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $iderp112018->excluir(NULL, "si180_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si180_instit = " . db_getsession("DB_instit"));
            if ($iderp112018->erro_status == 0) {
                throw new Exception($iderp112018->erro_msg);
            }
        }
        $result = $iderp102018->sql_record($iderp102018->sql_query(NULL, "*", NULL, "si179_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si179_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $iderp102018->excluir(NULL, "si179_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si179_instit = " . db_getsession("DB_instit"));
            if ($iderp102018->erro_status == 0) {
                throw new Exception($iderp102018->erro_msg);
            }
        }


        $sSql = "SELECT si09_codorgaotce AS codorgao, si09_tipoinstit AS tipoinstit
              FROM infocomplementaresinstit
              WHERE si09_instit = " . db_getsession("DB_instit");
        $rsResult = db_query($sSql);

        $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;

        /*
         * selecionar informacoes registro 10
         */

        $sSql = "SELECT * FROM despesasinscritasRP WHERE c223_anousu = ". db_getsession("DB_anousu");
        $rsResult10 = db_query($sSql);
//db_criatabela($rsResult10);
        $empLiqMaiorque0 = array();
        $empNaoLiqMaiorque0 = array();

        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

            $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

            if ($oDados10->c223_vlrliquidado > 0) {
                $empLiqMaiorque0[] = $oDados10;
            }

            if ($oDados10->c223_vlrnaoliquidado > 0) {
                $empNaoLiqMaiorque0[] = $oDados10;
            }
        }
        /**
         * empenho com liquidacao maior que 0
         */

        foreach ($empLiqMaiorque0 as $empliq) {

            $iderp102018->si179_tiporegistro = 10;
            $iderp102018->si179_codorgao = $sCodorgao;
            $iderp102018->si179_codunidadesub = $this->getCodUnidSub($empliq->c223_codemp, $empliq->c223_anousu);
            $iderp102018->si179_nroempenho = $empliq->c223_codemp;
            $iderp102018->si179_tiporestospagar = 1;
            $iderp102018->si179_disponibilidadecaixa = $empliq->c223_vlrdisrpp > 0 ? 1 : 2;
            if ($empliq->c223_vlrdisrpp > 0 && $empliq->c223_vlrdisrpp != $empliq->c223_vlrliquidado && $iderp102018->si179_disponibilidadecaixa == 1) {
                $iderp102018->si179_tiporegistro = 10;
                $iderp102018->si179_codorgao = $sCodorgao;
                $iderp102018->si179_codunidadesub = $this->getCodUnidSub($empliq->c223_codemp, $empliq->c223_anousu);
                $iderp102018->si179_nroempenho = $empliq->c223_codemp;
                $iderp102018->si179_tiporestospagar = 1;
                $iderp102018->si179_disponibilidadecaixa = 2;
                $iderp102018->si179_codreduzidoiderp = $this->getSeqEmpenho($empliq->c223_codemp, $empliq->c223_anousu).$iderp102018->si179_tiporestospagar.$iderp102018->si179_disponibilidadecaixa;
                $iderp102018->si179_vlinscricao = $empliq->c223_vlrsemdisrpp;
                $iderp102018->si179_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $iderp102018->si179_instit = db_getsession('DB_instit');

                $iderp102018->incluir(null);
                if ($iderp102018->erro_status == 0) {
                    throw new Exception($iderp102018->erro_msg);
                }

                /*incluindo registro 11*/
                $iderp112018->si180_tiporegistro = 11;
                $iderp112018->si180_codreduzidoiderp = $this->getSeqEmpenho($empliq->c223_codemp, $empliq->c223_anousu).$iderp102018->si179_tiporestospagar.$iderp102018->si179_disponibilidadecaixa;
                $iderp112018->si180_codfontrecursos = $empliq->c223_fonte;
                $iderp112018->si180_vlinscricaofonte = $empliq->c223_vlrsemdisrpp;
                $iderp112018->si180_reg10 = $iderp102018->si179_sequencial;
                $iderp112018->si180_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $iderp112018->si180_instit = db_getsession('DB_instit');
                $iderp112018->incluir(null);

                if ($iderp112018->erro_status == 0) {
                    throw new Exception($iderp112018->erro_msg);
                }
            }

            $iderp102018->si179_disponibilidadecaixa = $empliq->c223_vlrdisrpp > 0 ? 1 : 2;
            $iderp102018->si179_codreduzidoiderp = $this->getSeqEmpenho($empliq->c223_codemp, $empliq->c223_anousu).$iderp102018->si179_tiporestospagar.$iderp102018->si179_disponibilidadecaixa;

            if ($empliq->c223_vlrdisrpp > 0 ? 1 : 2 == 1) {
                $iderp102018->si179_vlinscricao = $empliq->c223_vlrdisrpp;
            } else {
                $iderp102018->si179_vlinscricao = $empliq->c223_vlrsemdisrpp;
            }
            $iderp102018->si179_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $iderp102018->si179_instit = db_getsession('DB_instit');

            $iderp102018->incluir(null);

            if ($iderp102018->erro_status == 0) {
                throw new Exception($iderp102018->erro_msg);
            }

            /*incluindo registro 11*/
            $iderp112018->si180_tiporegistro = 11;
            $iderp112018->si180_codreduzidoiderp = $this->getSeqEmpenho($empliq->c223_codemp, $empliq->c223_anousu).$iderp102018->si179_tiporestospagar.$iderp102018->si179_disponibilidadecaixa;
            $iderp112018->si180_codfontrecursos = $empliq->c223_fonte;
            $iderp112018->si180_vlinscricaofonte = $iderp102018->si179_vlinscricao;
            $iderp112018->si180_reg10 = $iderp102018->si179_sequencial;
            $iderp112018->si180_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $iderp112018->si180_instit = db_getsession('DB_instit');
            $iderp112018->incluir(null);

            if ($iderp112018->erro_status == 0) {
                throw new Exception($iderp112018->erro_msg);
            }

        }

        /***
         * empenho sem liquidacao maior que 0
         */

        foreach ($empNaoLiqMaiorque0 as $empnaoliq) {

            $iderp102018->si179_tiporegistro = 10;
            $iderp102018->si179_codunidadesub = $this->getCodUnidSub($empnaoliq->c223_codemp, $empnaoliq->c223_anousu);
            $iderp102018->si179_codorgao = $sCodorgao;
            $iderp102018->si179_nroempenho = $empnaoliq->c223_codemp;
            $iderp102018->si179_tiporestospagar = 2;
            $iderp102018->si179_disponibilidadecaixa = $empnaoliq->c223_vlrdisrpnp > 0 ? 1 : 2;

            if ($empnaoliq->c223_vlrdisrpnp > 0 && $empnaoliq->c223_vlrdisrpnp != $empnaoliq->c223_vlrnaoliquidado && ($empnaoliq->c223_vlrdisrpnp > 0 ? 1 : 2) == 1) {
                $iderp102018->si179_tiporegistro = 10;
                $iderp102018->si179_codorgao = $sCodorgao;
                $iderp102018->si179_codunidadesub = $this->getCodUnidSub($empnaoliq->c223_codemp, $empnaoliq->c223_anousu);
                $iderp102018->si179_nroempenho = $empnaoliq->c223_codemp;
                $iderp102018->si179_tiporestospagar = 2;
                $iderp102018->si179_disponibilidadecaixa = 2;
                $iderp102018->si179_codreduzidoiderp = $this->getSeqEmpenho($empnaoliq->c223_codemp, $empnaoliq->c223_anousu).$iderp102018->si179_tiporestospagar.$iderp102018->si179_disponibilidadecaixa;
                $iderp102018->si179_vlinscricao = $empnaoliq->c223_vlrsemdisrpnp;
                $iderp102018->si179_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $iderp102018->si179_instit = db_getsession('DB_instit');
                $iderp102018->incluir(null);

                if ($iderp102018->erro_status == 0) {
                    throw new Exception($iderp102018->erro_msg);
                }

                /*incluindo registro 11*/
                $iderp112018->si180_tiporegistro = 11;
                $iderp112018->si180_codreduzidoiderp = $this->getSeqEmpenho($empnaoliq->c223_codemp, $empnaoliq->c223_anousu).$iderp102018->si179_tiporestospagar.$iderp102018->si179_disponibilidadecaixa;
                $iderp112018->si180_codfontrecursos = $empnaoliq->c223_fonte;
                $iderp112018->si180_vlinscricaofonte = $empnaoliq->c223_vlrsemdisrpnp;
                $iderp112018->si180_reg10 = $iderp102018->si179_sequencial;
                $iderp112018->si180_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $iderp112018->si180_instit = db_getsession('DB_instit');
                $iderp112018->incluir(null);

                if ($iderp112018->erro_status == 0) {
                    throw new Exception($iderp112018->erro_msg);
                }

            }

            $iderp102018->si179_disponibilidadecaixa = $empnaoliq->c223_vlrdisrpnp > 0 ? 1 : 2;
            $iderp102018->si179_codreduzidoiderp = $this->getSeqEmpenho($empnaoliq->c223_codemp, $empnaoliq->c223_anousu).$iderp102018->si179_tiporestospagar.$iderp102018->si179_disponibilidadecaixa;

            if ($empnaoliq->c223_vlrdisrpnp > 0 ? 1 : 2 == 1) {
                $iderp102018->si179_vlinscricao = $empnaoliq->c223_vlrdisrpnp;
            } else {
                $iderp102018->si179_vlinscricao = $empnaoliq->c223_vlrsemdisrpnp;
            }
            $iderp102018->si179_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $iderp102018->si179_instit = db_getsession('DB_instit');
            $iderp102018->incluir(null);

            if ($iderp102018->erro_status == 0) {
                throw new Exception($iderp102018->erro_msg);
            }

            /*incluindo registro 11*/
            $iderp112018->si180_tiporegistro = 11;
            $iderp112018->si180_codreduzidoiderp = $this->getSeqEmpenho($empnaoliq->c223_codemp, $empnaoliq->c223_anousu).$iderp102018->si179_tiporestospagar.$iderp102018->si179_disponibilidadecaixa;
            $iderp112018->si180_codfontrecursos = $empnaoliq->c223_fonte;
            $iderp112018->si180_vlinscricaofonte = $iderp102018->si179_vlinscricao;
            $iderp112018->si180_reg10 = $iderp102018->si179_sequencial;
            $iderp112018->si180_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $iderp112018->si180_instit = db_getsession('DB_instit');
            $iderp112018->incluir(null);

            if ($iderp112018->erro_status == 0) {
                throw new Exception($iderp112018->erro_msg);
            }

        }

        /*registro 20*/

        $anousu = db_getsession("DB_anousu");
        $perini = $anousu . "-01-01";
        $perfim = $anousu . "-12-31";
        /**
         * retornatodas as fontes
         */

        $sSqlRecurso = "SELECT DISTINCT o15_codtri FROM orctiporec WHERE o15_codtri != '' ORDER BY o15_codtri";

        $rsResultrRecurso = db_query($sSqlRecurso);

        $recurso = array();
        $aFontes = array();
        $vlRspExerciciosAnteriores = array();
        $aSaldoAgrupadosFonte = array();

        for ($iCont = 0; $iCont < pg_num_rows($rsResultrRecurso); $iCont++) {

            $oRecurso = db_utils::fieldsMemory($rsResultrRecurso, $iCont);

            $recurso[] = $oRecurso->o15_codtri;

        }

        foreach ($recurso as $fonte) {

            /**
             *Aqui irei calcular o valor de caixabruta referenciado na analise por campo 4 do ctb + campo 4 ext
             */

            //retorna contas bancarias por fonte
            $sqlCtbfonte = "SELECT
                              k13_reduz AS codctb,
                              o15_codtri AS fonte
                            FROM saltes
                            JOIN conplanoreduz ON k13_reduz = c61_reduz AND c61_anousu = $anousu
                            JOIN conplanoconta ON c63_codcon = c61_codcon AND c63_anousu = c61_anousu
                            JOIN orctiporec ON c61_codigo = o15_codigo
                            LEFT JOIN conplanocontabancaria ON c56_codcon = c61_codcon AND c56_anousu = c61_anousu
                            LEFT JOIN contabancaria ON c56_contabancaria = db83_sequencial
                            LEFT JOIN infocomplementaresinstit ON si09_instit = c61_instit
                            WHERE (k13_limite IS NULL OR k13_limite > '$anousu-12-31') AND c61_instit = 1 AND o15_codtri::int = {$fonte}
                            ORDER BY k13_reduz";

            $rsCtbfonte = db_query($sqlCtbfonte); //echo($sqlCtbfonte); db_criatabela($rsCtbfonte);die();

            $aContasAgrupadosFonte = array();

            for ($iCont = 0; $iCont < pg_num_rows($rsCtbfonte); $iCont++) {

                $oTodasContas = db_utils::fieldsMemory($rsCtbfonte, $iCont);

                $aHash = $oTodasContas->fonte;
                //contas agrupadas por fonte
                $aContasAgrupadosFonte[$aHash]->contas[] = $oTodasContas->codctb;
            }

            foreach ($aContasAgrupadosFonte as  $ifonte => $Todascontas){

                foreach ($Todascontas->contas as $conta) {

                    $sqlFonteMovimento = "SELECT DISTINCT codctb,fontemovimento
                                       FROM
                 (SELECT c61_reduz AS codctb,o15_codtri AS fontemovimento
                 FROM conplano
                 INNER JOIN conplanoreduz ON conplanoreduz.c61_codcon = conplano.c60_codcon
                 AND conplanoreduz.c61_anousu = conplano.c60_anousu
                 INNER JOIN orctiporec ON o15_codigo = c61_codigo
                 WHERE conplanoreduz.c61_reduz IN ($conta)
                     AND conplanoreduz.c61_anousu = $anousu
                     UNION ALL
                     SELECT c61_reduz AS codctb,
                           ces02_fonte::varchar AS fontemovimento
                     FROM conctbsaldo
                     INNER JOIN conplanoreduz ON conctbsaldo.ces02_reduz = conplanoreduz.c61_reduz
                     AND conplanoreduz.c61_anousu = conctbsaldo.ces02_anousu
                     INNER JOIN orctiporec ON o15_codigo = c61_codigo WHERE conctbsaldo.ces02_reduz IN ($conta)
                     AND conctbsaldo.ces02_anousu = $anousu
                     UNION ALL
                 SELECT contacredito.c61_reduz AS codctb,
                 CASE
                    WHEN c71_coddoc IN (5,35,37, 6,36,38) THEN fontempenho.o15_codtri
                    WHEN c71_coddoc IN (100,101,115,116) THEN fontereceita.o15_codtri
                    WHEN c71_coddoc IN (140,141) THEN contadebitofonte.o15_codtri
                    ELSE contacreditofonte.o15_codtri
                 END AS fontemovimento
                 FROM conlancamdoc
                 INNER JOIN conlancamval ON conlancamval.c69_codlan = conlancamdoc.c71_codlan
                 INNER JOIN conplanoreduz contadebito ON contadebito.c61_reduz = conlancamval.c69_debito
                 AND contadebito.c61_anousu = conlancamval.c69_anousu
                 INNER JOIN conplanoreduz contacredito ON contacredito.c61_reduz = conlancamval.c69_credito
                 AND contacredito.c61_anousu = conlancamval.c69_anousu
                 LEFT JOIN conlancamemp ON conlancamemp.c75_codlan = conlancamdoc.c71_codlan
                 LEFT JOIN empempenho ON empempenho.e60_numemp = conlancamemp.c75_numemp
                 LEFT JOIN orcdotacao ON orcdotacao.o58_anousu = empempenho.e60_anousu
                 AND orcdotacao.o58_coddot = empempenho.e60_coddot
                 LEFT JOIN orctiporec fontempenho ON fontempenho.o15_codigo = orcdotacao.o58_codigo
                 LEFT JOIN orctiporec contacreditofonte ON contacreditofonte.o15_codigo = contacredito.c61_codigo
                 LEFT JOIN orctiporec contadebitofonte ON contadebitofonte.o15_codigo = contadebito.c61_codigo
                 LEFT JOIN conlancamrec ON conlancamrec.c74_codlan = conlancamdoc.c71_codlan
                 LEFT JOIN orcreceita ON orcreceita.o70_codrec = conlancamrec.c74_codrec
                 AND orcreceita.o70_anousu = conlancamrec.c74_anousu
                 LEFT JOIN orcfontes receita ON receita.o57_codfon = orcreceita.o70_codfon
                 AND receita.o57_anousu = orcreceita.o70_anousu
                 LEFT JOIN orctiporec fontereceita ON fontereceita.o15_codigo = orcreceita.o70_codigo
                 WHERE DATE_PART('YEAR',conlancamdoc.c71_data) = $anousu
                 AND DATE_PART('MONTH',conlancamdoc.c71_data) <= 12
                 AND conlancamval.c69_credito IN ($conta)
                 UNION ALL
                 SELECT contadebito.c61_reduz AS codctb,
                 CASE
                     WHEN c71_coddoc IN (5,35,37,6,36,38) THEN fontempenho.o15_codtri
                     WHEN c71_coddoc IN (100,101,115,116) THEN fontereceita.o15_codtri
                     WHEN c71_coddoc IN (140,141) THEN contacreditofonte.o15_codtri
                     ELSE contadebitofonte.o15_codtri
                 END AS fontemovimento
                 FROM conlancamdoc
                 INNER JOIN conlancamval ON conlancamval.c69_codlan = conlancamdoc.c71_codlan
                 INNER JOIN conplanoreduz contadebito ON contadebito.c61_reduz = conlancamval.c69_debito
                 AND contadebito.c61_anousu = conlancamval.c69_anousu
                 INNER JOIN conplanoreduz contacredito ON contacredito.c61_reduz = conlancamval.c69_credito
                 AND contacredito.c61_anousu = conlancamval.c69_anousu
                 LEFT JOIN conlancamemp ON conlancamemp.c75_codlan = conlancamdoc.c71_codlan
                 LEFT JOIN empempenho ON empempenho.e60_numemp = conlancamemp.c75_numemp
                 LEFT JOIN orcdotacao ON orcdotacao.o58_anousu = empempenho.e60_anousu
                 AND orcdotacao.o58_coddot = empempenho.e60_coddot
                 LEFT JOIN orctiporec fontempenho ON fontempenho.o15_codigo = orcdotacao.o58_codigo
                 LEFT JOIN orctiporec contacreditofonte ON contacreditofonte.o15_codigo = contacredito.c61_codigo
                 LEFT JOIN orctiporec contadebitofonte ON contadebitofonte.o15_codigo = contadebito.c61_codigo
                 LEFT JOIN conlancamrec ON conlancamrec.c74_codlan = conlancamdoc.c71_codlan
                 LEFT JOIN orcreceita ON orcreceita.o70_codrec = conlancamrec.c74_codrec
                 AND orcreceita.o70_anousu = conlancamrec.c74_anousu
                 LEFT JOIN orcfontes receita ON receita.o57_codfon = orcreceita.o70_codfon
                 AND receita.o57_anousu = orcreceita.o70_anousu
                 LEFT JOIN orctiporec fontereceita ON fontereceita.o15_codigo = orcreceita.o70_codigo
                 WHERE DATE_PART('YEAR',conlancamdoc.c71_data) = $anousu
                 AND DATE_PART('MONTH',conlancamdoc.c71_data) = 12
                 AND conlancamval.c69_debito IN ($conta)
                 UNION ALL
                 SELECT ces02_reduz,
                 ces02_fonte::varchar
                 FROM conctbsaldo WHERE ces02_reduz IN ($conta)
                 AND ces02_anousu = $anousu ) AS xx";

                    //Contas com Movimentacao
                    $rsMovimentofonte = db_query($sqlFonteMovimento);//db_criatabela($rsMovimentofonte);// die ($sqlFonteMovimento);

                    for ($iCont = 0; $iCont < pg_num_rows($rsMovimentofonte); $iCont++) {

                        $iFonte = db_utils::fieldsMemory($rsMovimentofonte, $iCont)->fontemovimento;


                        $sSqlMov = "select
                            round(substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$conta,'" . $iFonte . "',12," . db_getsession("DB_instit") . "),29,15)::float8,2)::float8 as saldo_anterior,
                            round(substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$conta,'" . $iFonte . "',12," . db_getsession("DB_instit") . "),43,15)::float8,2)::float8 as debitomes,
                            round(substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$conta,'" . $iFonte . "',12," . db_getsession("DB_instit") . "),57,15)::float8,2)::float8 as creditomes,
                            round(substr(fc_saldoctbfonte(" . db_getsession("DB_anousu") . ",$conta,'" . $iFonte . "',12," . db_getsession("DB_instit") . "),72,15)::float8,2)::float8 as saldo_final,
                            substr(fc_saldoctbfonte      (" . db_getsession("DB_anousu") . ",$conta,'" . $iFonte . "',12," . db_getsession("DB_instit") . "),87,1)::varchar(1) as  sinalanterior,
                            substr(fc_saldoctbfonte      (" . db_getsession("DB_anousu") . ",$conta,'" . $iFonte . "',12," . db_getsession("DB_instit") . "),89,1)::varchar(1) as  sinalfinal,
                            $iFonte as fonte";

                        $rsTotalMov = db_query($sSqlMov);

                        $oTotalMov = db_utils::fieldsMemory($rsTotalMov);
                        //echo "<pre>"; print_r($oTotalMov);
                        $aHash = $iFonte;
                        $saldos = new stdClass();
                        if(!$aSaldoAgrupadosFonte[$aHash]){
                            $saldos->fonte = $oTotalMov->fonte;
                            $saldos->ValorCaixabruta += $oTotalMov->sinalfinal == 'C' ? $oTotalMov->saldo_final * -1 : $oTotalMov->saldo_final;
                            //saldo agrupado por fonte
                            $aSaldoAgrupadosFonte[$aHash] = $saldos;
                        }else{
                            $saldos = $aSaldoAgrupadosFonte[$aHash];
                            $saldos->ValorCaixabruta += $oTotalMov->sinalfinal == 'C' ? $oTotalMov->saldo_final * -1 : $oTotalMov->saldo_final;
                        }

                    }
                }
                //echo "<pre>"; print_r($aSaldoAgrupadosFonte);die();
            }

            /**
             * Aqui retorno todas as contas caixa por fonte
             */
            $sSqlCaixa = "SELECT c60_codcon,
                                 c61_reduz,
                                 c60_descr,
                                 si09_codorgaotce,
                                 o15_codtri
                          FROM conplano
                          JOIN conplanoreduz ON c60_codcon = c61_codcon
                          LEFT JOIN infocomplementaresinstit ON c61_instit = si09_instit
                          JOIN orctiporec ON o15_codigo = c61_codigo
                          WHERE c60_codsis = 5
                              AND c60_anousu = $anousu
                              AND c61_anousu = $anousu
                              AND c61_instit = " . db_getsession("DB_instit") . "
                              AND o15_codtri::int = {$fonte}";
            $resultCaixa = db_query($sSqlCaixa);
            //echo $sSqlCaixa;db_criatabela($resultCaixa);die();

            /**
             * percorrer registros de contas retornados do sql acima para pega saldo anterior
             */

            for ($iCont = 0; $iCont < pg_num_rows($resultCaixa); $iCont++) {

                $oContas = db_utils::fieldsMemory($resultCaixa, $iCont);

                $where2 = " c61_instit in (" . db_getsession("DB_instit") . ") and c60_codsis in (5) ";
                $where2 .= "and c61_codcon = " . $oContas->c60_codcon;

                /**
                 * Comando adicionado para excluir tabela temporária que, ao gerar o arquivo juntamente com outros que utilizam essa função, traz valores diferentes
                 */
                db_query("drop table if EXISTS work_pl");
                $rsPlanoContas = db_planocontassaldo($anousu, '2018-01-01', '2018-12-31', false, $where2);
                //echo "<pre>"; print_r($rsPlanoContas);
                for ($iContPlano = 0; $iContPlano < pg_num_rows($rsPlanoContas); $iContPlano++) {

                    if (db_utils::fieldsMemory($rsPlanoContas, $iContPlano)->c61_reduz != 0) {
                        $oPlanoContas = db_utils::fieldsMemory($rsPlanoContas, $iContPlano);
                    }
                }

                $aHash = $oContas->o15_codtri;
                $saldosCaixa = new stdClass();
                if(!$aSaldoAgrupadosFonte[$aHash]){
                    $saldosCaixa->ValorCaixabruta += $oPlanoContas->sinal_final == 'C' ? $oPlanoContas->saldo_final * -1 : $oPlanoContas->saldo_final;
                    //saldo agrupado por fonte
                    $aSaldoAgrupadosFonte[$aHash] = $saldosCaixa;
                }else{
                    $saldosCaixa = $aSaldoAgrupadosFonte[$aHash];
                    $saldosCaixa->ValorCaixabruta += $oPlanoContas->sinal_final == 'C' ? $oPlanoContas->saldo_final * -1 : $oPlanoContas->saldo_final;
                }
            }
            //echo "<pre>"; print_r($aSaldoAgrupadosFonte);exit;

            $sql = "SELECT e91_numemp,e91_vlremp,e91_vlranu,e91_vlrliq,e91_vlrpag,o15_codtri,vlranu,vlrliq,vlrpag,
                           vlrpagnproc,vlranuliq,vlranuliqnaoproc
                    FROM
                        (SELECT e91_numemp,e91_anousu,e91_codtipo,e90_descr,o15_descr,o15_codtri,c70_anousu,
                        coalesce(e91_vlremp,0) AS e91_vlremp,
                        coalesce(e91_vlranu,0) AS e91_vlranu,
                        coalesce(e91_vlrliq,0) AS e91_vlrliq,
                        coalesce(e91_vlrpag,0) AS e91_vlrpag,e91_recurso,
                        coalesce(vlranu,0) AS vlranu,
                        coalesce(vlranuliq,0) AS vlranuliq,
                        coalesce(vlranuliqnaoproc,0) AS vlranuliqnaoproc,
                        coalesce(vlrliq,0) AS vlrliq,
                        coalesce(vlrpag,0) AS vlrpag,
                        coalesce(vlrpagnproc,0) AS vlrpagnproc
                          FROM empresto
                          INNER JOIN emprestotipo ON e91_codtipo = e90_codigo
                          INNER JOIN orctiporec ON e91_recurso = o15_codigo
                          LEFT OUTER JOIN
                            (SELECT c75_numemp,c70_anousu,
                              sum(round(CASE WHEN c53_tipo = 11 THEN c70_valor ELSE 0 END,2)) AS vlranu,
                              sum(round(CASE WHEN c71_coddoc = 31 THEN c70_valor ELSE 0 END,2)) AS vlranuliq,
                              sum(round(CASE WHEN c71_coddoc = 32 THEN c70_valor ELSE 0 END,2)) AS vlranuliqnaoproc,
                              sum(round(CASE WHEN c53_tipo = 20 THEN c70_valor ELSE (CASE WHEN c53_tipo = 21 THEN c70_valor*-1 ELSE 0 END) END,2)) AS vlrliq,
                              sum(round(CASE WHEN c71_coddoc = 35 THEN c70_valor ELSE (CASE WHEN c71_coddoc = 36 THEN c70_valor*-1 ELSE 0 END) END,2)) AS vlrpag,
                              sum(round(CASE WHEN c71_coddoc = 37 THEN c70_valor ELSE (CASE WHEN c71_coddoc = 38 THEN c70_valor*-1 ELSE 0 END) END,2)) AS vlrpagnproc
                                FROM conlancamemp
                                INNER JOIN conlancamdoc ON c71_codlan = c75_codlan
                                INNER JOIN conhistdoc ON c53_coddoc = c71_coddoc
                                INNER JOIN conlancam ON c70_codlan = c75_codlan
                                INNER JOIN empempenho ON e60_numemp = c75_numemp
                                WHERE e60_anousu < " . DB_getsession("DB_anousu") . " AND c75_data BETWEEN '$perini' AND '$perfim'
                                AND e60_instit IN (" . db_getsession('DB_instit') . ") GROUP BY c75_numemp,c70_anousu) AS x ON x.c75_numemp = e91_numemp
                                WHERE e91_anousu = " . DB_getsession("DB_anousu") . " ) AS x
                                INNER JOIN empempenho ON e60_numemp = e91_numemp AND e60_instit IN (" . db_getsession('DB_instit') . ")
                                INNER JOIN empelemento ON e64_numemp = e60_numemp
                                INNER JOIN cgm ON z01_numcgm = e60_numcgm
                                INNER JOIN orcdotacao ON o58_coddot = e60_coddot AND o58_anousu = e60_anousu
                                AND o58_instit = e60_instit
                                INNER JOIN orcorgao ON o40_orgao = o58_orgao AND o40_anousu = o58_anousu
                                INNER JOIN orcunidade ON o41_anousu = o58_anousu AND o41_orgao = o58_orgao AND o41_unidade = o58_unidade
                                INNER JOIN orcfuncao ON o52_funcao = orcdotacao.o58_funcao
                                INNER JOIN orcsubfuncao ON o53_subfuncao = orcdotacao.o58_subfuncao
                                INNER JOIN orcprograma ON o54_programa = o58_programa AND o54_anousu = orcdotacao.o58_anousu
                                INNER JOIN orcprojativ ON o55_projativ = o58_projativ AND o55_anousu = orcdotacao.o58_anousu
                                INNER JOIN orcelemento ON o58_codele = o56_codele AND o58_anousu = o56_anousu AND 1=1
                                AND o15_codtri::int4 IN($fonte)
                                ORDER BY e91_recurso,e60_anousu,e60_codemp::bigint";

            $resultMovFonte = db_query($sql);
            //db_criatabela($resultMovFonte);

            for ($iContMov = 0; $iContMov < pg_num_rows($resultMovFonte); $iContMov++) {
                $rsFontes = db_utils::fieldsMemory($resultMovFonte, $iContMov);
                $aFontes[$rsFontes->o15_codtri][] = $rsFontes;
            }

            foreach ($aFontes as $fonte) {
                $oVlrTote91Emp = 0;
                $oVlrTote91Anu = 0;
                $oVlrTote91Liq = 0;
                $oVlrTote91Pag = 0;
                $oVlrTotEmp = 0;
                $oVlrTotLiq = 0;
                $oVlrTotAnu = 0;
                $oVlrTotPag = 0;

                $vlrTotpagnproc = 0;
                $vlrTotanuliq = 0;
                $vlrTotanuliqnaoproc = 0;
                $vlRspExeAnt = new stdClass();
                foreach ($fonte as $item) {
                    $oVlrTote91Emp += $item->e91_vlremp;
                    $oVlrTote91Anu += $item->e91_vlranu;
                    $oVlrTote91Liq += $item->e91_vlrliq;
                    $oVlrTote91Pag += $item->e91_vlrpag;

                    $oVlrTotLiq += $item->vlrliq;
                    $oVlrTotAnu += $item->vlranu;
                    $oVlrTotPag += $item->vlrpag;

                    $vlrTotpagnproc += $item->vlrpagnproc;
                    $vlrTotanuliq += $item->vlranuliq;
                    $vlrTotanuliqnaoproc += $item->vlranuliqnaoproc;

                    $totLiq = ($oVlrTote91Liq - $oVlrTote91Pag - $oVlrTotPag - $oVlrTotAnu) + ($oVlrTotLiq - $vlrTotpagnproc);

                    $totNP = $oVlrTote91Emp - $oVlrTote91Anu - $oVlrTote91Liq - $vlrTotanuliqnaoproc - $oVlrTotLiq;

                    $vlRspExeAnt->vlRspExeAnt = $totLiq + $totNP;
                    $vlRspExerciciosAnteriores[$item->o15_codtri] = $vlRspExeAnt;
                }
            }
        }

        //echo "<pre>";print_r($vlRspExerciciosAnteriores);die();
        /**
         * Busco todas as contas ext com movimento 1,2,99
         */

        $sqlext = "SELECT c61_reduz AS codext,
                   c60_tipolancamento
                   FROM conplano
                   INNER JOIN conplanoreduz ON c60_codcon = c61_codcon AND c60_anousu = c61_anousu
                   LEFT JOIN infocomplementaresinstit ON si09_instit = c61_instit
                   WHERE c60_anousu = 2018 AND c60_codsis = 7 AND c61_instit = 1
                   AND c60_tipolancamento in (1,2,3,99)
                   ORDER BY c61_reduz";

        $resultExt = db_query($sqlext);
//        db_criatabela($resultExt);
        $aContasExt = array();
        for ($iContExt = 0; $iContExt < pg_num_rows($resultExt); $iContExt++) {

            $rsExt = db_utils::fieldsMemory($resultExt, $iContExt);

            $aContasExt[] = $rsExt;
        }

        $vlRestituiveisRecolher = array();
        $vlRestituiveisAtivoFinanceiro = array();
        $tiposlancamento = array(1, 2, 99);
        foreach ($aContasExt as $xconta) {
            /**
             * pegar todas as fontes de recursos movimentadas para cada codext
             */
            $sSqlFonte = "   SELECT DISTINCT codext,fonte  from (
   								    select c61_reduz  as codext,0 as contrapart,o15_codigo as fonte
									  from conplano
								inner join conplanoreduz on conplanoreduz.c61_codcon = conplano.c60_codcon and conplanoreduz.c61_anousu = conplano.c60_anousu
								inner join orctiporec on o15_codigo = c61_codigo
									 where conplanoreduz.c61_reduz  in ({$xconta->codext})
									   and conplanoreduz.c61_anousu = " . db_getsession("DB_anousu") . "
								 union all
							        select ces01_reduz as codext, ces01_reduz as contrapart,ces01_fonte as fonte
									  from conextsaldo
								inner join conplanoreduz on conextsaldo.ces01_reduz = conplanoreduz.c61_reduz
								       and conplanoreduz.c61_anousu = conextsaldo.ces01_anousu
									 where conextsaldo.ces01_reduz  in ({$xconta->codext})
									   and conextsaldo.ces01_anousu = " . db_getsession("DB_anousu") . "
								 union all
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
									 WHERE conlancamdoc.c71_coddoc IN (120,121,130,131,150,151,152,153,160,161,162,163)
									   and conlancamval.c69_credito in ({$xconta->codext})
									   and DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . "
									   and DATE_PART('MONTH',conlancamdoc.c71_data) <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
									   and conlancaminstit.c02_instit = " . db_getsession("DB_instit") . "
								 union all
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
									 WHERE conlancamdoc.c71_coddoc IN (120,121,130,131,150,151,152,153,160,161,162,163)
									   and conlancamval.c69_debito in ({$xconta->codext})
									   and DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . "
									   and DATE_PART('MONTH',conlancamdoc.c71_data) <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
									   and conlancaminstit.c02_instit = " . db_getsession("DB_instit") . "
								  ) as extfonte order by codext,fonte";

            $rsExtFonteRecurso = db_query($sSqlFonte);
            //echo $sSqlFonte;db_criatabela($rsExtFonteRecurso);

            for ($iC = 0; $iC < pg_num_rows($rsExtFonteRecurso); $iC++) {
                $oContaExtraFonte = db_utils::fieldsMemory($rsExtFonteRecurso, $iC);

                $sSqlSaldoFonte = "
                select round(substr(fc_saldoextfonte(" . db_getsession("DB_anousu") . ",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),28,13)::float8,2)::float8 as saldo_anterior,
				round(substr(fc_saldoextfonte(" . db_getsession("DB_anousu") . ",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),42,13)::float8,2)::float8 as debitomes,
				round(substr(fc_saldoextfonte(" . db_getsession("DB_anousu") . ",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),56,13)::float8,2)::float8 as creditomes,
				round(substr(fc_saldoextfonte(" . db_getsession("DB_anousu") . ",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),70,13)::float8,2)::float8 as saldo_final,
				substr(fc_saldoextfonte(" . db_getsession("DB_anousu") . ",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),83,1)::varchar(1) as  sinalanterior,
				substr(fc_saldoextfonte(" . db_getsession("DB_anousu") . ",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),85,1)::varchar(1) as  sinalfinal,
				$xconta->c60_tipolancamento as tipolancamento";

                $rsExtSaldoFonteRecurso = db_query($sSqlSaldoFonte);
//                db_criatabela($rsExtSaldoFonteRecurso);

                $oExtRecurso = $oContaExtraFonte->fonte;

                $saldofinalabs = db_utils::fieldsMemory($rsExtSaldoFonteRecurso)->saldo_final;
                $natsaldoatualfonte = db_utils::fieldsMemory($rsExtSaldoFonteRecurso)->sinalfinal;
                $saldofinal = $natsaldoatualfonte == 'C' ? ($saldofinalabs == '' ? 0 : $saldofinalabs) * -1 : ($saldofinalabs == '' ? 0 : $saldofinalabs);

                /* SQL RETORNA O CODTRI DA FONTE */
                $sSqlExtRecurso = "select o15_codtri
                                         from orctiporec
	        						    where o15_codigo = " . $oExtRecurso;

                $rsExtRecurso = db_query($sSqlExtRecurso);
                $oExtRecursoTCE = db_utils::fieldsMemory($rsExtRecurso, 0)->o15_codtri;

                $Hash20 = $oExtRecursoTCE;

                $vlRestRecolher = new stdClass();
                $vlRestAtivoFinanceiro = new stdClass();

                if (in_array($xconta->c60_tipolancamento, $tiposlancamento)) {

                    if (!$vlRestituiveisRecolher[$Hash20]) {
                        $vlRestRecolher->tipolancamento = $xconta->c60_tipolancamento;
                        $vlRestRecolher->vlRestituiveisRecolher += $saldofinalabs;
                        $vlRestituiveisRecolher[$Hash20] = $vlRestRecolher;
                    } else {
                        $vlRestRecolher = $vlRestituiveisRecolher[$Hash20];
                        $vlRestituiveisRecolher->vlRestituiveisRecolher += $saldofinalabs;
                    }

                } else {

                    if (!$vlRestituiveisAtivoFinanceiro[$Hash20]) {
                        $vlRestAtivoFinanceiro->tipolancamento = $xconta->c60_tipolancamento;
                        $vlRestAtivoFinanceiro->vlRestAtivoFinanceiro += $saldofinalabs;
                        $vlRestituiveisAtivoFinanceiro[$Hash20] = $vlRestAtivoFinanceiro;
                    } else {
                        $vlRestAtivoFinanceiro = $vlRestituiveisAtivoFinanceiro[$Hash20];
                        $vlRestAtivoFinanceiro->vlRestAtivoFinanceiro += $saldofinalabs;
                    }
                }
            }
        }

//        echo "<pre>"; print_r($aSaldoAgrupadosFonte);echo "<br>"; echo "////////////////////////////////////////////////////";
//        echo "<pre>"; print_r($vlRspExerciciosAnteriores);echo "<br>"; echo "////////////////////////////////////////////////////";
//        echo "<pre>"; print_r($vlRestituiveisRecolher);echo "<br>"; echo "////////////////////////////////////////////////////";
//        echo "<pre>"; print_r($vlRestituiveisAtivoFinanceiro);echo "<br>"; echo "////////////////////////////////////////////////////";
//        echo "@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@RESULT@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@";echo "<br>";

        $VlrDisCaixa = array();
        // Valor caixa bruta
        foreach ($aSaldoAgrupadosFonte as $saldofonte => $ifonte){
            $VlrDisCaixa[$saldofonte]->VlrDisCaixa = $ifonte->ValorCaixabruta;
        }
        // Valor vlRspExerciciosAnteriores
        foreach ($vlRspExerciciosAnteriores as $saldofonte => $ifonte) {
            if(!$VlrDisCaixa[$saldofonte]){
                $VlrDisCaixa[$saldofonte]->VlrDisCaixa = $ifonte->vlRspExeAnt;
            }else{
                $VlrDisCaixa[$saldofonte]->VlrDisCaixa -= $ifonte->vlRspExeAnt;
            }
        }
        //vlRestituiveisRecolher
        foreach ($vlRestituiveisRecolher as $saldofonte => $ifonte){
            if(!$VlrDisCaixa[$saldofonte]){
                $VlrDisCaixa[$saldofonte]->VlrDisCaixa = $ifonte->vlRestituiveisRecolher;
            }else{
                $VlrDisCaixa[$saldofonte]->VlrDisCaixa -= $ifonte->vlRestituiveisRecolher;
            }
        }
        //vlRestituiveisAtivoFinanceiro
        foreach ($vlRestituiveisAtivoFinanceiro as $saldofonte => $ifonte){
            if(!$VlrDisCaixa[$saldofonte]){
                $VlrDisCaixa[$saldofonte]->VlrDisCaixa = $ifonte->vlRestAtivoFinanceiro;
            }else{
                $VlrDisCaixa[$saldofonte]->VlrDisCaixa += $ifonte->vlRestAtivoFinanceiro;
            }
        }

        /**
         * Aqui irei percorrer todos os array e montar um array do registro 20 por fonte.
         */
        $oDadosRegistro20 = array();

        foreach ($aSaldoAgrupadosFonte as $saldofonte => $ifonte){
            $oDadosRegistro20[$saldofonte]->registro = 20;
            $oDadosRegistro20[$saldofonte]->orgao = $sCodorgao;
            $oDadosRegistro20[$saldofonte]->fonte = $saldofonte;
            $oDadosRegistro20[$saldofonte]->valorcaixabruta = $ifonte->ValorCaixabruta;
            $oDadosRegistro20[$saldofonte]->vlRspExeAnt = 0;
            $oDadosRegistro20[$saldofonte]->vlRestRecolher = 0;
            $oDadosRegistro20[$saldofonte]->vlRestAtivoFinanceiro = 0;
            $oDadosRegistro20[$saldofonte]->vlRdispCaixa = 0;
        }

        foreach ($vlRspExerciciosAnteriores as $saldofonte => $ifonte){
            if(!$oDadosRegistro20[$saldofonte]){
                $oDadosRegistro20[$saldofonte]->registro = 20;
                $oDadosRegistro20[$saldofonte]->orgao = $sCodorgao;
                $oDadosRegistro20[$saldofonte]->fonte = $saldofonte;
                $oDadosRegistro20[$saldofonte]->valorcaixabruta = 0;
                $oDadosRegistro20[$saldofonte]->vlRspExeAnt = $ifonte->vlRspExeAnt;
                $oDadosRegistro20[$saldofonte]->vlRestRecolher = 0;
                $oDadosRegistro20[$saldofonte]->vlRestAtivoFinanceiro = 0;
                $oDadosRegistro20[$saldofonte]->vlRdispCaixa = 0;
            }else{
                $oDadosRegistro20[$saldofonte]->vlRspExeAnt = $ifonte->vlRspExeAnt;
            }
        }

        foreach ($vlRestituiveisRecolher as $saldofonte => $ifonte){
            if(!$oDadosRegistro20[$saldofonte]){
                $oDadosRegistro20[$saldofonte]->registro = 20;
                $oDadosRegistro20[$saldofonte]->orgao = $sCodorgao;
                $oDadosRegistro20[$saldofonte]->fonte = $saldofonte;
                $oDadosRegistro20[$saldofonte]->valorcaixabruta = 0;
                $oDadosRegistro20[$saldofonte]->vlRspExeAnt = 0;
                $oDadosRegistro20[$saldofonte]->vlRestRecolher = $ifonte->vlRestituiveisRecolher;
                $oDadosRegistro20[$saldofonte]->vlRestAtivoFinanceiro = 0;
                $oDadosRegistro20[$saldofonte]->vlRdispCaixa = 0;
            }else{
                $oDadosRegistro20[$saldofonte]->vlRestRecolher = $ifonte->vlRestituiveisRecolher;
            }
        }

        foreach ($vlRestituiveisAtivoFinanceiro as $saldofonte => $ifonte){
            if(!$oDadosRegistro20[$saldofonte]){
                $oDadosRegistro20[$saldofonte]->registro = 20;
                $oDadosRegistro20[$saldofonte]->orgao = $sCodorgao;
                $oDadosRegistro20[$saldofonte]->fonte = $saldofonte;
                $oDadosRegistro20[$saldofonte]->valorcaixabruta = 0;
                $oDadosRegistro20[$saldofonte]->vlRspExeAnt = 0;
                $oDadosRegistro20[$saldofonte]->vlRestRecolher = 0;
                $oDadosRegistro20[$saldofonte]->vlRestAtivoFinanceiro = $ifonte->vlRestAtivoFinanceiro;
                $oDadosRegistro20[$saldofonte]->vlRdispCaixa = 0;
            }else{
                $oDadosRegistro20[$saldofonte]->vlRestAtivoFinanceiro = $ifonte->vlRestAtivoFinanceiro;
            }
        }

        foreach ($VlrDisCaixa as $saldofonte => $ifonte){
            if(!$oDadosRegistro20[$saldofonte]){
                $oDadosRegistro20[$saldofonte]->registro = 20;
                $oDadosRegistro20[$saldofonte]->orgao = $sCodorgao;
                $oDadosRegistro20[$saldofonte]->fonte = $saldofonte;
                $oDadosRegistro20[$saldofonte]->valorcaixabruta = 0;
                $oDadosRegistro20[$saldofonte]->vlRspExeAnt = 0;
                $oDadosRegistro20[$saldofonte]->vlRestRecolher = 0;
                $oDadosRegistro20[$saldofonte]->vlRestAtivoFinanceiro = 0;
                $oDadosRegistro20[$saldofonte]->vlRdispCaixa = $ifonte->VlrDisCaixa;
            }else{
                $oDadosRegistro20[$saldofonte]->vlRdispCaixa = $ifonte->VlrDisCaixa;
            }
        }
        /**
         * Incluindo o registro 20
         *
         */
        foreach ($oDadosRegistro20 as $reg20){

            $iderp202018->si181_tiporegistro = 20;
            $iderp202018->si181_codorgao = $reg20->orgao;
            $iderp202018->si181_codfontrecursos = $reg20->fonte;
            $iderp202018->si181_vlcaixabruta = $reg20->valorcaixabruta;
            $iderp202018->si181_vlrspexerciciosanteriores = $reg20->vlRspExeAnt;
            $iderp202018->si181_vlrestituiveisrecolher = $reg20->vlRestRecolher;
            $iderp202018->si181_vlrestituiveisativofinanceiro = $reg20->vlRestAtivoFinanceiro;
            $iderp202018->si181_vlsaldodispcaixa = $reg20->vlRdispCaixa < 0 ? 0 : $reg20->vlRdispCaixa;
            $iderp202018->si181_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];;
            $iderp202018->si181_instit = db_getsession("DB_instit");
            $iderp202018->incluir(null);

            if ($iderp202018->erro_status == 0) {
                throw new Exception($iderp202018->erro_msg);
            }
        }

        db_fim_transacao();

        $oGerarIDERP = new GerarIDERP();
        $oGerarIDERP->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $oGerarIDERP->gerarDados();

    }

}
