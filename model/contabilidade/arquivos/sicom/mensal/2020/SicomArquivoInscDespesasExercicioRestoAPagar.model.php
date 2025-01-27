<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_iderp102020_classe.php");
require_once ("classes/db_iderp112020_classe.php");
require_once ("classes/db_iderp202020_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarIDERP.model.php");
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
        $instint = db_getsession("DB_instit");
        $sql = "select e60_numemp from empempenho where e60_codemp = '$codemp' and e60_anousu = $anousu and e60_instit = $instint";
        $result = db_query($sql);
//        echo $sql; db_criatabela($result);exit;
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
AND l03_instit = ".db_getsession("DB_instit")."
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
//        echo $sql;db_criatabela($result);
        $CodUnidadeSub = db_utils::fieldsMemory($result, 0)->codunidadesub;

        return $CodUnidadeSub;
    }

    public function getReg10($seqEmp){

        $sSql = "select si179_sequencial from iderp102020 where si179_codiderp = $seqEmp";
        $result = db_query($sSql);
        $codSeqReg10 = db_utils::fieldsMemory($result, 0)->si179_sequencial;
        return $codSeqReg10;
    }

    public function getVlrInscricaoFonte($seqEmp){
        $sSql = "select c223_vlrnaoliquidado,c223_vlrliquidado from iderp102020 where si179_codiderp = $seqEmp";
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

        $iderp102020 = new cl_iderp102020();
        $iderp112020 = new cl_iderp112020();
        $iderp202020 = new cl_iderp202020();
        $cl_despesasinscritasrp = new cl_despesasinscritasRP();

        db_inicio_transacao();

        /*
         * excluir informacoes do mes selecionado
         */
        $result = $iderp202020->sql_record($iderp202020->sql_query(NULL, "*", NULL, "si181_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si181_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $iderp202020->excluir(NULL, "si181_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si181_instit = " . db_getsession("DB_instit"));
            if ($iderp202020->erro_status == 0) {
                throw new Exception($iderp202020->erro_msg);
            }
        }
        $result = $iderp112020->sql_record($iderp112020->sql_query(NULL, "*", NULL, "si180_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si180_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $iderp112020->excluir(NULL, "si180_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si180_instit = " . db_getsession("DB_instit"));
            if ($iderp112020->erro_status == 0) {
                throw new Exception($iderp112020->erro_msg);
            }
        }
        $result = $iderp102020->sql_record($iderp102020->sql_query(NULL, "*", NULL, "si179_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si179_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $iderp102020->excluir(NULL, "si179_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si179_instit = " . db_getsession("DB_instit"));
            if ($iderp102020->erro_status == 0) {
                throw new Exception($iderp102020->erro_msg);
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

        /***
         * Verifica empenhos que foram pagos e nao constam mais como RP
         * Tratamento solicitado por barbara apos desenvolvimento da tela de despesasinscritasrp
         */

        $anousu = db_getsession("DB_anousu");
        $perini = $anousu."-01-01";
        $perfin = $anousu."-12-31";

        $sqlEmpRP = "SELECT * FROM
    (SELECT fonte,
            empenho,
            credor,
            round(sum(e60_vlremp - e60_vlranu - e60_vlrliq),2) AS vlr_n_lqd,
            round(sum(e60_vlrliq - e60_vlrpag),2) AS vlr_lqd,
            z01_numcgm,
            e60_anousu
     FROM
         (SELECT o15_codtri AS fonte,
                 e60_codemp AS empenho,
                 z01_numcgm,
                 z01_numcgm||'-'||z01_nome AS credor,
                 round(sum((CASE
                            WHEN c53_tipo = 10 THEN c70_valor
                            ELSE 0
                        END)),2) AS e60_vlremp,
                 round(sum((CASE
                            WHEN c53_tipo = 11 THEN c70_valor
                            ELSE 0
                        END)),2) AS e60_vlranu,
                 round(sum((CASE
                                WHEN c53_tipo = 20 THEN c70_valor
                                ELSE 0
                            END) - (CASE
                                        WHEN c53_tipo = 21 THEN c70_valor
                                        ELSE 0
                                    END)),2) AS e60_vlrliq,
                 round(sum((CASE
                                WHEN c53_tipo = 30 THEN c70_valor
                                ELSE 0
                            END) - (CASE
                                        WHEN c53_tipo = 31 THEN c70_valor
                                        ELSE 0
                                    END)),2) AS e60_vlrpag,
                 e60_anousu
          FROM empempenho
          JOIN conlancamemp ON c75_numemp = e60_numemp
          JOIN conlancamdoc ON c71_codlan = c75_codlan
          JOIN conlancam ON c70_codlan = c75_codlan
          JOIN conhistdoc ON c53_coddoc = c71_coddoc
          JOIN orcdotacao ON (e60_anousu, e60_coddot) = (o58_anousu, o58_coddot)
          JOIN orctiporec ON o15_codigo = o58_codigo
          JOIN cgm ON (e60_numcgm) = (z01_numcgm)
          WHERE e60_instit = ".db_getsession("DB_instit")." and e60_anousu = ".db_getsession("DB_anousu")."
              AND c75_data BETWEEN '$perini' AND '$perfin'
          GROUP BY 1,2,3,4,c53_tipo,c70_valor,e60_anousu
          ORDER BY 2, 3) AS x
     GROUP BY 1, 2, 3,z01_numcgm, e60_anousu
     ORDER BY 1, 2, 3) AS total
     WHERE (vlr_n_lqd > 0 OR vlr_lqd > 0)";

        $resultEmp = db_query($sqlEmpRP);
//db_criatabela($resultEmp);
        $empenhos = array();
        $empLiqMaiorque0 = array();
        $empNaoLiqMaiorque0 = array();
        for ($i=0; $i<pg_num_rows($resultEmp); $i++){
            $oDadosEmp = db_utils::fieldsMemory($resultEmp, $i);
            $empenhos[] = $oDadosEmp->empenho;
        }

        $aFontesExistentes = array();

        foreach ($empenhos as $emp) {

            $sSql = "SELECT * FROM despesasinscritasRP WHERE c223_codemp = $emp and c223_instit = " . db_getsession("DB_instit") . " and  c223_anousu = " . db_getsession("DB_anousu");
            $rsResult10 = db_query($sSql);

            for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

                $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

                if ($oDados10->c223_vlrliquidado > 0) {
                    $empLiqMaiorque0[] = $oDados10;
                }

                if ($oDados10->c223_vlrnaoliquidado > 0) {
                    $empNaoLiqMaiorque0[] = $oDados10;
                }
                
                if (!in_array($oDados10->c223_fonte, $aFontesExistentes)) {
                    array_push($aFontesExistentes, $oDados10->c223_fonte);
                }
            }
        }
//        exit;
        /**
         * empenho com liquidacao maior que 0
         */

        foreach ($empLiqMaiorque0 as $empliq) {

            $iderp102020->si179_tiporegistro = 10;
            $iderp102020->si179_codorgao = $sCodorgao;
            $iderp102020->si179_codunidadesub = $this->getCodUnidSub($empliq->c223_codemp, $empliq->c223_anousu);
            $iderp102020->si179_nroempenho = $empliq->c223_codemp;
            $iderp102020->si179_tiporestospagar = 1;
            $iderp102020->si179_disponibilidadecaixa = $empliq->c223_vlrdisrpp > 0 ? 1 : 2;
            if ($empliq->c223_vlrdisrpp > 0 && $empliq->c223_vlrdisrpp != $empliq->c223_vlrliquidado && $iderp102020->si179_disponibilidadecaixa == 1) {
                $iderp102020->si179_tiporegistro = 10;
                $iderp102020->si179_codorgao = $sCodorgao;
                $iderp102020->si179_codunidadesub = $this->getCodUnidSub($empliq->c223_codemp, $empliq->c223_anousu);
                $iderp102020->si179_nroempenho = $empliq->c223_codemp;
                $iderp102020->si179_tiporestospagar = 1;
                $iderp102020->si179_disponibilidadecaixa = 2;
                $iderp102020->si179_codiderp = $this->getSeqEmpenho($empliq->c223_codemp, $empliq->c223_anousu).$iderp102020->si179_tiporestospagar.$iderp102020->si179_disponibilidadecaixa;
                $iderp102020->si179_vlinscricao = $empliq->c223_vlrsemdisrpp;
                $iderp102020->si179_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $iderp102020->si179_instit = db_getsession('DB_instit');
                $iderp102020->incluir(null);
                if ($iderp102020->erro_status == 0) {
                    throw new Exception($iderp102020->erro_msg);
                }

                /*incluindo registro 11*/
                $iderp112020->si180_tiporegistro = 11;
                $iderp112020->si180_codiderp = $this->getSeqEmpenho($empliq->c223_codemp, $empliq->c223_anousu).$iderp102020->si179_tiporestospagar.$iderp102020->si179_disponibilidadecaixa;
                $iderp112020->si180_codfontrecursos = $empliq->c223_fonte;
                $iderp112020->si180_vlinscricaofonte = $empliq->c223_vlrsemdisrpp;
                $iderp112020->si180_reg10 = $iderp102020->si179_sequencial;
                $iderp112020->si180_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $iderp112020->si180_instit = db_getsession('DB_instit');
                $iderp112020->incluir(null);

                if ($iderp112020->erro_status == 0) {
                    throw new Exception($iderp112020->erro_msg);
                }
            }

            $iderp102020->si179_disponibilidadecaixa = $empliq->c223_vlrdisrpp > 0 ? 1 : 2;
            $iderp102020->si179_codiderp = $this->getSeqEmpenho($empliq->c223_codemp, $empliq->c223_anousu).$iderp102020->si179_tiporestospagar.$iderp102020->si179_disponibilidadecaixa;

            if ($empliq->c223_vlrdisrpp > 0 ? 1 : 2 == 1) {
                $iderp102020->si179_vlinscricao = $empliq->c223_vlrdisrpp;
            } else {
                $iderp102020->si179_vlinscricao = $empliq->c223_vlrsemdisrpp;
            }
            $iderp102020->si179_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $iderp102020->si179_instit = db_getsession('DB_instit');

            $iderp102020->incluir(null);

            if ($iderp102020->erro_status == 0) {
                throw new Exception($iderp102020->erro_msg);
            }

            /*incluindo registro 11*/
            $iderp112020->si180_tiporegistro = 11;
            $iderp112020->si180_codiderp = $this->getSeqEmpenho($empliq->c223_codemp, $empliq->c223_anousu).$iderp102020->si179_tiporestospagar.$iderp102020->si179_disponibilidadecaixa;
            $iderp112020->si180_codfontrecursos = $empliq->c223_fonte;
            $iderp112020->si180_vlinscricaofonte = $iderp102020->si179_vlinscricao;
            $iderp112020->si180_reg10 = $iderp102020->si179_sequencial;
            $iderp112020->si180_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $iderp112020->si180_instit = db_getsession('DB_instit');
            $iderp112020->incluir(null);

            if ($iderp112020->erro_status == 0) {
                throw new Exception($iderp112020->erro_msg);
            }

        }

        /***
         * empenho sem liquidacao maior que 0
         */

        foreach ($empNaoLiqMaiorque0 as $empnaoliq) {

            $iderp102020->si179_tiporegistro = 10;
            $iderp102020->si179_codunidadesub = $this->getCodUnidSub($empnaoliq->c223_codemp, $empnaoliq->c223_anousu);
            $iderp102020->si179_codorgao = $sCodorgao;
            $iderp102020->si179_nroempenho = $empnaoliq->c223_codemp;
            $iderp102020->si179_tiporestospagar = 2;
            $iderp102020->si179_disponibilidadecaixa = $empnaoliq->c223_vlrdisrpnp > 0 ? 1 : 2;

            if ($empnaoliq->c223_vlrdisrpnp > 0 && $empnaoliq->c223_vlrdisrpnp != $empnaoliq->c223_vlrnaoliquidado && ($empnaoliq->c223_vlrdisrpnp > 0 ? 1 : 2) == 1) {
                $iderp102020->si179_tiporegistro = 10;
                $iderp102020->si179_codorgao = $sCodorgao;
                $iderp102020->si179_codunidadesub = $this->getCodUnidSub($empnaoliq->c223_codemp, $empnaoliq->c223_anousu);
                $iderp102020->si179_nroempenho = $empnaoliq->c223_codemp;
                $iderp102020->si179_tiporestospagar = 2;
                $iderp102020->si179_disponibilidadecaixa = 2;
                $iderp102020->si179_codiderp = $this->getSeqEmpenho($empnaoliq->c223_codemp, $empnaoliq->c223_anousu).$iderp102020->si179_tiporestospagar.$iderp102020->si179_disponibilidadecaixa;
                $iderp102020->si179_vlinscricao = $empnaoliq->c223_vlrsemdisrpnp;
                $iderp102020->si179_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $iderp102020->si179_instit = db_getsession('DB_instit');
                $iderp102020->incluir(null);

                if ($iderp102020->erro_status == 0) {
                    throw new Exception($iderp102020->erro_msg);
                }

                /*incluindo registro 11*/
                $iderp112020->si180_tiporegistro = 11;
                $iderp112020->si180_codiderp = $this->getSeqEmpenho($empnaoliq->c223_codemp, $empnaoliq->c223_anousu).$iderp102020->si179_tiporestospagar.$iderp102020->si179_disponibilidadecaixa;
                $iderp112020->si180_codfontrecursos = $empnaoliq->c223_fonte;
                $iderp112020->si180_vlinscricaofonte = $empnaoliq->c223_vlrsemdisrpnp;
                $iderp112020->si180_reg10 = $iderp102020->si179_sequencial;
                $iderp112020->si180_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $iderp112020->si180_instit = db_getsession('DB_instit');
                $iderp112020->incluir(null);

                if ($iderp112020->erro_status == 0) {
                    throw new Exception($iderp112020->erro_msg);
                }

            }

            $iderp102020->si179_disponibilidadecaixa = $empnaoliq->c223_vlrdisrpnp > 0 ? 1 : 2;
            $iderp102020->si179_codiderp = $this->getSeqEmpenho($empnaoliq->c223_codemp, $empnaoliq->c223_anousu).$iderp102020->si179_tiporestospagar.$iderp102020->si179_disponibilidadecaixa;

            if ($empnaoliq->c223_vlrdisrpnp > 0 ? 1 : 2 == 1) {
                $iderp102020->si179_vlinscricao = $empnaoliq->c223_vlrdisrpnp;
            } else {
                $iderp102020->si179_vlinscricao = $empnaoliq->c223_vlrsemdisrpnp;
            }
            $iderp102020->si179_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $iderp102020->si179_instit = db_getsession('DB_instit');
            $iderp102020->incluir(null);

            if ($iderp102020->erro_status == 0) {
                throw new Exception($iderp102020->erro_msg);
            }

            /*incluindo registro 11*/
            $iderp112020->si180_tiporegistro = 11;
            $iderp112020->si180_codiderp = $this->getSeqEmpenho($empnaoliq->c223_codemp, $empnaoliq->c223_anousu).$iderp102020->si179_tiporestospagar.$iderp102020->si179_disponibilidadecaixa;
            $iderp112020->si180_codfontrecursos = $empnaoliq->c223_fonte;
            $iderp112020->si180_vlinscricaofonte = $iderp102020->si179_vlinscricao;
            $iderp112020->si180_reg10 = $iderp102020->si179_sequencial;
            $iderp112020->si180_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $iderp112020->si180_instit = db_getsession('DB_instit');
            $iderp112020->incluir(null);

            if ($iderp112020->erro_status == 0) {
                throw new Exception($iderp112020->erro_msg);
            }

        }

        /*registro 20*/


        /**
         * Incluindo o registro 20
         *
         */

        $sFontesExistentes = implode(',',$aFontesExistentes);
        if(pg_num_rows($resultEmp) > 0) {
            $sSql20 = "SELECT distinct c224_fonte, c224_vlrcaixabruta, c224_rpexercicioanterior, c224_vlrdisponibilidadecaixa, c224_anousu, c224_instit
            FROM disponibilidadecaixa
            WHERE c224_anousu = ". db_getsession('DB_anousu')."
            AND c224_instit = ". db_getsession('DB_instit')."
            AND (c224_vlrcaixabruta != 0
            OR c224_rpexercicioanterior != 0
            OR c224_vlrrestoarecolher != 0
            OR c224_vlrdisponibilidadecaixa != 0
            OR c224_fonte IN ({$sFontesExistentes}))
            AND c224_fonte NOT IN ('148','149','150','151','152','248','249','250','251','252') order by c224_fonte";
        }else{
            $sSql20 = "SELECT distinct c224_fonte, c224_vlrcaixabruta, c224_rpexercicioanterior, c224_vlrdisponibilidadecaixa, c224_anousu, c224_instit
            FROM disponibilidadecaixa
            WHERE c224_anousu = ". db_getsession('DB_anousu')."
            AND c224_instit = ". db_getsession('DB_instit')."
            AND (c224_vlrcaixabruta != 0
            OR c224_rpexercicioanterior != 0
            OR c224_vlrrestoarecolher != 0
            OR c224_vlrdisponibilidadecaixa != 0)
            AND c224_fonte NOT IN ('148','149','150','151','152','248','249','250','251','252') order by c224_fonte";
        }

        $rsResult20 = db_query($sSql20);
        //echo $sSql20;db_criatabela($rsResult20);exit;
        if(pg_num_rows($rsResult20) > 0) {

            for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

                $oDados20[] = db_utils::fieldsMemory($rsResult20, $iCont20);

            }

            foreach ($oDados20 as $reg20) {

                $iderp202020->si181_tiporegistro = 20;
                $iderp202020->si181_codorgao = $sCodorgao;
                $iderp202020->si181_codfontrecursos = $reg20->c224_fonte;
                $iderp202020->si181_vlcaixabruta = $reg20->c224_vlrcaixabruta;
                $iderp202020->si181_vlrspexerciciosanteriores = $reg20->c224_rpexercicioanterior;
                $iderp202020->si181_vlrestituiveisrecolher = 0;
                $iderp202020->si181_vlrestituiveisativofinanceiro = 0;
                $iderp202020->si181_vlsaldodispcaixa = $reg20->vlRdispCaixa < 0 ? 0 : $reg20->c224_vlrdisponibilidadecaixa;
                $iderp202020->si181_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];;
                $iderp202020->si181_instit = $reg20->c224_instit;
                $iderp202020->incluir(null);

                if ($iderp202020->erro_status == 0) {
                    throw new Exception($iderp202020->erro_msg);
                }
            }

        }else{
            $iderp202020->si181_tiporegistro = 20;
            $iderp202020->si181_codorgao = $sCodorgao;
            $iderp202020->si181_codfontrecursos = '100';
            $iderp202020->si181_vlcaixabruta = '0.00';
            $iderp202020->si181_vlrspexerciciosanteriores = '0.00';
            $iderp202020->si181_vlrestituiveisrecolher = '0.00';
            $iderp202020->si181_vlrestituiveisativofinanceiro = '0.00';
            $iderp202020->si181_vlsaldodispcaixa = '0.00';
            $iderp202020->si181_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];;
            $iderp202020->si181_instit = db_getsession('DB_instit');
            $iderp202020->incluir(null);

            if ($iderp202020->erro_status == 0) {
                throw new Exception($iderp202020->erro_msg);
            }
        }

        db_fim_transacao();

        $oGerarIDERP = new GerarIDERP();
        $oGerarIDERP->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $oGerarIDERP->gerarDados();

    }

}
