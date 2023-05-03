<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_arc102023_classe.php");
require_once("classes/db_arc112023_classe.php");
require_once("classes/db_arc122023_classe.php");
require_once("classes/db_arc202023_classe.php");
require_once("classes/db_arc212023_classe.php");
require_once("classes/db_rec102023_classe.php");
require_once("classes/db_rec112023_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2023/GerarARC.model.php");

/**
 * detalhamento das correcoes das receitas do mes Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoDetalhamentoCorrecoesReceitas extends SicomArquivoBase implements iPadArquivoBaseCSV
{

    /**
     *
     * Codigo do layout. (db_layouttxt.db50_codigo)
     * @var Integer
     */
    protected $iCodigoLayout = 150;

    /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'ARC';

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
            "codOrgao",
            "identificadorDeducaoRecDeduzida",
            "rubricaDeduzida",
            "codFonteDeduzida",
            "especificacaoDeduzida",
            "identificadorDeducaoRecAcrescida",
            "rubricaAcrescida",
            "codFonteAcrescida",
            "especificacaoAcrescida",
            "vlDeduzidoAcrescido"
        );
        $aElementos[20] = array(
            "tipoRegistro",
            "codOrgao",
            "codEstorno",
            "eDeducaoDeReceita",
            "identificadorDeducao",
            "naturezaReceitaEstornada",
            "vlEstornado"
        );
        $aElementos[21] = array(
            "tipoRegistro",
            "codEstorno",
            "codFonteEstornada",
            "tipoDocumento",
            "nroDocumento",
            "nroConvenio",
            "dataAssinatura",
            "vlrEstornadoFonte"
        );

        return $aElementos;
    }

    /**
     * selecionar os dados de detalhamente das correcoes receitas do mes para gerar o arquivo
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados(){


        /**
         * selecionar arquivo xml com dados das receitas
         */
        $sSql = "SELECT * FROM db_config ";
        $sSql .= "  WHERE prefeitura = 't'";

        $rsInst = db_query($sSql);
        $sCnpj = db_utils::fieldsMemory($rsInst, 0)->cgc;
        $sArquivo = "config/sicom/" . db_getsession("DB_anousu") . "/{$sCnpj}_sicomnaturezareceita.xml";

        $sTextoXml = file_get_contents($sArquivo);
        $oDOMDocument = new DOMDocument();
        $oDOMDocument->loadXML($sTextoXml);
        $oNaturezaReceita = $oDOMDocument->getElementsByTagName('receita');


        /**
         * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
         */
        $clrec10 = new cl_rec102023();
        $clrec11 = new cl_rec112023();
        $clarc20 = new cl_arc202023();
        $clarc21 = new cl_arc212023();


        $db_filtro = "o70_instit = " . db_getsession("DB_instit");
        $rsResult10 = db_receitasaldo(11, 1, 3, true, $db_filtro, db_getsession("DB_anousu"), $this->sDataInicial, $this->sDataFinal, false, ' * ', true, 0);
        // db_criatabela($rsResult10);

        $sSql = "select si09_codorgaotce from infocomplementaresinstit where si09_instit = " . db_getsession("DB_instit");
        $rsResult = db_query($sSql);
        $sCodOrgaoTce = db_utils::fieldsMemory($rsResult, 0)->si09_codorgaotce;

        /**
         * exlcuir informacoes do mes selecionado
         */
        db_inicio_transacao();

        $result = $clrec11->sql_record($clrec11->sql_query(null, "*", null, "si26_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']) . " and si26_instit = " . db_getsession("DB_instit"));
        if (pg_num_rows($result) > 0) {
            $clrec11->excluir(null, "si26_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si26_instit = " . db_getsession("DB_instit"));
            if ($clrec11->erro_status == 0) {
                throw new Exception($clrec11->erro_msg);
            }
        }

        $result = $clrec10->sql_record($clrec10->sql_query(null, "*", null, "si25_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si25_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clrec10->excluir(null, "si25_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si25_instit = " . db_getsession("DB_instit"));
            if ($clrec10->erro_status == 0) {
                throw new Exception($clrec10->erro_msg);
            }
        }

        $result = $clarc21->sql_record($clarc21->sql_query(null, "*", null, "si32_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si32_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clarc21->excluir(null, "si32_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si32_instit = " . db_getsession("DB_instit"));
            if ($clarc21->erro_status == 0) {
                throw new Exception($clarc21->erro_msg);
            }
        }

        $result = $clarc20->sql_record($clarc20->sql_query(null, "*", null, "si31_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si31_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clarc20->excluir(null, "si31_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si31_instit = " . db_getsession("DB_instit"));
            if ($clarc20->erro_status == 0) {
                throw new Exception($clarc20->erro_msg);
            }
        }


        /* RECEITAS QUE DEVEM SER SUBSTIUIDAS RUBRICA CADASTRADA ERRADA */
        $aRectce = array('111202', '111208', '172136', '191138', '191139', '191140',
            '191308', '191311', '191312', '191313', '193104', '193111', '193112',
            '193113', '172401', '247199', '247299', '176299', '172199', '172134',
            '160099', '112299', '176202', '242201', '242202', '222900', '193199',
            '191199', '176101', '160004', '132810', '132820', '132830', '192210',
            '242102', /*'199099',*/ '247101', '172402', '172233');

        $aDadosAgrupados = array();
        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

            $oDadosRec = db_utils::fieldsMemory($rsResult10, $iCont10);

            $sSql = "SELECT c74_codlan, c70_valor, c53_tipo, o57_fonte, k81_regrepasse, k81_exerc, k81_emparlamentar, o15_codtri FROM conlancamrec
               JOIN conlancamdoc ON c71_codlan = c74_codlan
               JOIN conhistdoc ON c71_coddoc = c53_coddoc
               JOIN conlancam ON c70_codlan = c74_codlan
               JOIN orcreceita ON (c74_anousu, c74_codrec) = (o70_anousu, o70_codrec)
               JOIN conlancamcorrente ON c86_conlancam = c70_codlan
               JOIN corrente ON (c86_id, c86_data, c86_autent) = (corrente.k12_id, corrente.k12_data, corrente.k12_autent)
               LEFT JOIN corplacaixa ON (corrente.k12_id, corrente.k12_data, corrente.k12_autent) = (k82_id, k82_data, k82_autent)
               LEFT JOIN placaixarec ON k82_seqpla = k81_seqpla
               JOIN orcfontes ON (o70_codfon, o70_anousu) = (o57_codfon, o57_anousu)
               JOIN orctiporec ON o15_codigo = o70_codigo
               WHERE c74_anousu = ". db_getsession("DB_anousu") ."
                 AND o57_fonte = '{$oDadosRec->o57_fonte}'
                 AND ((c53_tipo = 101 AND substr(o57_fonte,1,2) != '49')
                        OR (c53_tipo = 100 AND substr(o57_fonte,1,2) = '49'))
                 AND c74_data BETWEEN '{$this->sDataInicial}' AND '{$this->sDataFinal}'
                GROUP BY 1, 2, 3, 4, 5, 6, 7, 8 ORDER BY 4, 3, 6";


            $rsDocRec = db_query($sSql);

            $oCodDoc = db_utils::fieldsMemory($rsDocRec, 0);

            if (($oCodDoc->c53_tipo == 101 && substr($oDadosRec->o57_fonte, 0, 2) != '49') || ($oCodDoc->c53_tipo == 100 && substr($oDadosRec->o57_fonte, 0, 2) == '49')) {

                if ($oDadosRec->o70_codigo != 0 && $oDadosRec->saldo_arrecadado) {

                    $sNaturezaReceita = substr($oDadosRec->o57_fonte, 1, 8);
                    foreach ($oNaturezaReceita as $oNatureza) {

                        if ($oNatureza->getAttribute('instituicao') == db_getsession("DB_instit")
                            && $oNatureza->getAttribute('receitaEcidade') == $sNaturezaReceita
                        ) {
                            $sNaturezaReceita = $oNatureza->getAttribute('receitaSicom');
                            break;

                        }

                    }

                    if (substr($oDadosRec->o57_fonte, 1, 8) == $sNaturezaReceita) {

                        if (in_array(substr($oDadosRec->o57_fonte, 1, 6), $aRectce)) {
                            $sNaturezaReceita = substr($oDadosRec->o57_fonte, 1, 6) . "00";
                        } else if (substr($oDadosRec->o57_fonte, 0, 2) == '49') {
                            $sNaturezaReceita = substr($oDadosRec->o57_fonte, 3, 8);
                        } else {
                            $sNaturezaReceita = substr($oDadosRec->o57_fonte, 1, 8);
                        }

                    }

                    for($i=0; $i<pg_num_rows($rsDocRec);$i++){

                        $oCodDoc2 = db_utils::fieldsMemory($rsDocRec, $i);

                        $sRegRepasse    = $oCodDoc2->k81_regrepasse == '' ? '2' : $oCodDoc2->k81_regrepasse;
                        $sEmParlamentar = $oCodDoc2->k81_emparlamentar == '' ? '3' : $oCodDoc2->k81_emparlamentar;

                        $iIdentDeducao = (substr($oDadosRec->o57_fonte, 0, 2) == 49) ? substr($oDadosRec->o57_fonte, 1, 2) : "0";
                        $sHash10 = $iIdentDeducao . $sNaturezaReceita . substr($oDadosRec->o70_concarpeculiar, -2);
                        // echo $sHash10.' '.$iIdentDeducao . $sNaturezaReceita . substr($oDadosRec->o70_concarpeculiar, -2) . $sRegRepasse . $oCodDoc2->k81_exerc . $sEmParlamentar.' '.$oCodDoc2->c70_valor.'<br>';

                        if (!isset($aDadosAgrupados[$sHash10])) {
                            $oDados10 = new stdClass();
                            $oDados10->si25_tiporegistro = 10;
                            $oDados10->si25_codreceita = $oDadosRec->o70_codrec;
                            $oDados10->si25_codorgao = $sCodOrgaoTce;
                            $oDados10->si25_ededucaodereceita = $iIdentDeducao != '0' ? 1 : 2;
                            $oDados10->si25_identificadordeducao = $iIdentDeducao;
                            $oDados10->si25_naturezareceita = $sNaturezaReceita;
                            $oDados10->si25_vlarrecadado = 0;
                            $oDados10->si25_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                            $oDados10->Reg11 = array();

                            $aDadosAgrupados[$sHash10] = $oDados10;

                        }
                        $aDadosAgrupados[$sHash10]->si25_vlarrecadado += $oCodDoc2->c70_valor;

                        $oControleOrcamentario = new ControleOrcamentario();
                        $oControleOrcamentario->setNaturezaReceita($oDadosRec->o57_fonte);
                        $oControleOrcamentario->setFonte($oCodDoc->o15_codtri);
                        $oControleOrcamentario->setEmendaParlamentar($sEmParlamentar);

                        /**
                         * agrupar registro 11
                         */
                        $sHash11 = $oCodDoc->o15_codtri . $sRegRepasse . $oCodDoc2->k81_exerc . $sEmParlamentar . $oControleOrcamentario->getCodigoPorReceita();

                        if (!isset($aDadosAgrupados[$sHash10]->Reg11[$sHash11])) {

                            $sSql = " SELECT taborc.k02_estorc,
                                            CASE
                                                WHEN substr(taborc.k02_estorc,2,4) IN ('1215', '7215') THEN cgm.z01_cgccpf
                                                ELSE ''
                                            END AS z01_cgccpf,
                                            o70_codrec,
                                            o15_codtri,
                                            SUM(CASE
                                                    WHEN c53_tipo = 100 THEN ROUND(C70_VALOR,2)::FLOAT8
                                                    WHEN c53_tipo = 101 THEN ROUND(C70_VALOR*-1,2)::FLOAT8
                                                    ELSE 0::FLOAT8
                                                END) AS c70_valor,
                                            c206_nroconvenio,
                                            c206_dataassinatura,
                                            op01_numerocontratoopc,
                                            op01_dataassinaturacop
                                    FROM conlancamrec
                                    INNER JOIN orcreceita ON (c74_anousu, c74_codrec) = (o70_anousu, o70_codrec)
                                    INNER JOIN orctiporec ON o70_codigo = o15_codigo
                                    LEFT JOIN conlancamcorrente ON c86_conlancam = c74_codlan
                                    LEFT JOIN corplacaixa ON (k82_id, k82_data, k82_autent) = (c86_id, c86_data, c86_autent)
                                    LEFT JOIN placaixarec ON k81_seqpla = k82_seqpla
                                    LEFT JOIN convconvenios ON c206_sequencial = k81_convenio
                                    LEFT JOIN taborc ON (k02_anousu, k02_codrec) = (o70_anousu, o70_codrec)
                                    AND k02_codigo =
                                        (SELECT max(k02_codigo) FROM taborc tab
                                        WHERE (tab.k02_codrec, tab.k02_anousu) = (taborc.k02_codrec, taborc.k02_anousu))
                                    LEFT JOIN conlancam ON c74_codlan = c70_codlan
                                    LEFT JOIN conlancamcgm ON c76_codlan = c70_codlan
                                    INNER JOIN conlancamdoc ON c71_codlan = c70_codlan
                                    INNER JOIN conhistdoc ON c53_coddoc = c71_coddoc
                                    LEFT JOIN cgm ON k81_numcgm = cgm.z01_numcgm
                                    INNER JOIN saltes ON k13_conta = k81_conta
                                    INNER join conplanoreduz on c61_reduz = k13_reduz
                                    and c61_anousu = o70_anousu
                                    INNER JOIN conplano on conplanoreduz.c61_codcon = conplano.c60_codcon
                                        AND c61_anousu = c60_anousu
                                    INNER JOIN conplanocontabancaria ON c56_codcon = c60_codcon AND c56_anousu = c60_anousu
                                    INNER JOIN contabancaria on contabancaria.db83_sequencial = c56_contabancaria
                                    LEFT JOIN db_operacaodecredito ON op01_sequencial = db83_codigoopcredito::int 
                                    WHERE o15_codigo = " . $oDadosRec->o70_codigo . "
                                        AND o70_instit = " . db_getsession('DB_instit') . "
                                        AND (CASE
                                                WHEN substr(taborc.k02_estorc,1,2) = '49' THEN substr(taborc.k02_estorc,2,10) = '". substr($oDadosRec->o57_fonte,1,10)."'
                                                ELSE substr(taborc.k02_estorc,2,8) = '". substr($oDadosRec->o57_fonte,1,8)."'
                                            END)
                                        AND conlancamrec.c74_data BETWEEN '{$this->sDataInicial}' AND '{$this->sDataFinal}'
                                        AND ((c53_tipo = 101 AND substr(taborc.k02_estorc,1,2) != '49')
                                                OR (c53_tipo = 100 AND substr(taborc.k02_estorc,1,2) = '49'))
                                    GROUP BY 1, 2, 3, 4, c53_tipo, c70_valor, c206_nroconvenio, c206_dataassinatura, op01_numerocontratoopc, op01_dataassinaturacop
                                    ORDER BY 1, 4, 3";

                            $result = db_query($sSql);
                            $aDadosCgm11 = array();

                            for ($iContCgm = 0; $iContCgm < pg_num_rows($result); $iContCgm++){

                                $oCodFontRecursos = db_utils::fieldsMemory($result, $iContCgm);

                                $sHashCgm = $oCodFontRecursos->z01_cgccpf.$oCodFontRecursos->c206_nroconvenio.$oCodFontRecursos->c206_dataassinatura.$oCodFontRecursos->op01_numerocontratoopc.$oCodFontRecursos->op01_dataassinaturacop.$oControleOrcamentario->getCodigoPorReceita();

                                if (!isset($aDadosCgm11[$sHashCgm]) && $oCodFontRecursos->z01_cgccpf != ''){

                                    $oDados11 = new stdClass();
                                    $oDados11->si26_tiporegistro = 11;
                                    $oDados11->si26_codreceita = $oCodFontRecursos->o70_codrec;
                                    $oDados11->si26_codfontrecursos = $oCodFontRecursos->o15_codtri;
                                    $oDados11->si26_codigocontroleorcamentario = $oControleOrcamentario->getCodigoPorReceita();
                                    if(strlen($oCodFontRecursos->z01_cgccpf) == 11){
                                        $oDados11->si26_tipodocumento = 1;
                                    } elseif (strlen($oCodFontRecursos->z01_cgccpf) == 14){
                                        $oDados11->si26_tipodocumento = 2;
                                    }else{
                                        $oDados11->si26_tipodocumento = "";
                                    }
                                    $oDados11->si26_cnpjorgaocontribuinte = $oCodFontRecursos->z01_cgccpf;
                                    $oDados11->si26_nroconvenio = $oCodFontRecursos->c206_nroconvenio;
                                    $oDados11->si26_dataassinatura = $oCodFontRecursos->c206_dataassinatura;
                                    $oDados11->si26_nrocontratoop = $oCodFontRecursos->op01_numerocontratoopc;
                                    $oDados11->si26_dataassinaturacontratoop = $oCodFontRecursos->op01_dataassinaturacop;
                                    $oDados11->si26_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

                                    $aDadosCgm11[$sHashCgm] = $oDados11;

                                }

                                if($oCodFontRecursos->z01_cgccpf != ''){
                                    $aDadosCgm11[$sHashCgm]->si26_vlarrecadadofonte += $oCodFontRecursos->c70_valor;
                                }

                            }

                            $aDadosAgrupados[$sHash10]->Reg11[$sHash11] = $aDadosCgm11;

                            if(!isset($aDadosAgrupados[$sHash10]->Reg11[$sHash11][$sHash10.$sHash11]) && empty($aDadosCgm11)) {
                                

                                $aDados = new stdClass();
                                $aDados->si26_tiporegistro = 11;
                                $aDados->si26_codreceita = $oCodFontRecursos->o70_codrec;
                                $aDados->si26_codfontrecursos = $oCodFontRecursos->o15_codtri;
                                $aDados->si26_codigocontroleorcamentario = $oControleOrcamentario->getCodigoPorReceita();
                                if(strlen($oCodFontRecursos->z01_cgccpf) == 11){
                                    $aDados->si26_tipodocumento = 1;
                                } elseif (strlen($oCodFontRecursos->z01_cgccpf) == 14){
                                    $aDados->si26_tipodocumento = 2;
                                }else{
                                    $aDados->si26_tipodocumento = "";
                                }
                                $aDados->si26_cnpjorgaocontribuinte = $oCodFontRecursos->z01_cgccpf;
                                $aDados->si26_nroconvenio = $oCodFontRecursos->c206_nroconvenio;
                                $aDados->si26_dataassinatura = $oCodFontRecursos->c206_dataassinatura;
                                $aDados->si26_nrocontratoop = $oCodFontRecursos->op01_numerocontratoopc;
                                $aDados->si26_dataassinaturacontratoop = $oCodFontRecursos->op01_dataassinaturacop;
                                $aDados->si26_vlarrecadadofonte = $oCodDoc2->c70_valor;
                                $aDados->si26_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

                                $aDadosAgrupados[$sHash10]->Reg11[$sHash11][$sHash10.$sHash11] = $aDados;

                            }

                        } elseif (array_key_exists($sHash10.$sHash11, $aDadosAgrupados[$sHash10]->Reg11[$sHash11])) {

                            $aDadosAgrupados[$sHash10]->Reg11[$sHash11][$sHash10.$sHash11]->si26_vlarrecadadofonte += $oCodDoc2->c70_valor;

                        }

                    }
                }
            }
        }
        /*
         * Altera��o das fontes de receitas, para considerar os novos estruturais disponibilizados pelo TCE para 2023!
         * */

        $aRectceSaudEduc = array('11120111', '11180111', '11130311', '11130341', '11180141', '11180231', '11180241', '17180121', '17180151', '17180611',
            '17280111', '17280121', '17280131', '11120112', '11180112', '11180142', '11180232', '19130800', '11180114', '11180144',
            '11180234', '19310400', '11180113', '11180143', '11180233');

        foreach ($aDadosAgrupados as $oDados10) {

            $clarc20 = new cl_arc202023();
            $clarc20->si31_tiporegistro = 20;
            $clarc20->si31_codorgao = $oDados10->si25_codorgao;
            $clarc20->si31_codestorno = $oDados10->si25_codreceita;
            $clarc20->si31_ededucaodereceita = $oDados10->si25_ededucaodereceita;
            $clarc20->si31_identificadordeducao = $oDados10->si25_identificadordeducao;
            $clarc20->si31_naturezareceitaestornada = $oDados10->si25_naturezareceita;
            $clarc20->si31_vlestornado = abs($oDados10->si25_vlarrecadado);
            $clarc20->si31_mes = $oDados10->si25_mes;
            $clarc20->si31_instit = db_getsession("DB_instit");
            $clarc20->incluir(null);


            if ($clarc20->erro_status == 0) {

                throw new Exception($clarc20->erro_msg);
            }


            foreach ($oDados10->Reg11 as $aDados11) {
                foreach ($aDados11 as $oDados11) {


                    if (in_array($oDados10->si25_naturezareceita, $aRectceSaudEduc) &&
                        ($oDados10->si25_identificadordeducao == 0 || $oDados10->si25_identificadordeducao == '91' || $oDados10->si25_identificadordeducao == '')
                    ) {

                        $clarc21 = new cl_arc212023();
                        $clarc21->si32_tiporegistro = 21;
                        $clarc21->si32_reg20 = $clarc20->si31_sequencial;
                        $clarc21->si32_codestorno = intval($oDados10->si25_codreceita);
                        $clarc21->si32_codfonteestornada = $oDados11->si26_codfontrecursos;
                        $clarc21->si32_codigocontroleorcamentario = $oDados11->si26_codigocontroleorcamentario;
                        $clarc21->si32_tipodocumento = intval($oDados11->si26_tipodocumento);
                        $clarc21->si32_nrodocumento = $oDados11->si26_cnpjorgaocontribuinte;
                        $clarc21->si32_nroconvenio = $oDados11->si26_nroconvenio;
                        $clarc21->si32_dataassinatura = $oDados11->si26_dataassinatura;
                        $clarc21->si32_nrocontratoop = $oDados11->si26_nrocontratoop;
                        $clarc21->si32_dataassinaturacontratoop = $oDados11->si26_dataassinaturacontratoop;
                        $clarc21->si32_vlestornadofonte = number_format(abs($oDados11->si26_vlarrecadadofonte), 2, ".", "");
                        $clarc21->si32_mes = intval($oDados11->si26_mes);
                        $clarc21->si32_instit = db_getsession("DB_instit");

                        $clarc21->incluir(null);
                        if ($clarc21->erro_status == 0) {
                            throw new Exception($clarc21->erro_msg);
                        }

                        if ($clarc21->erro_status == 0) {
                            throw new Exception($clarc21->erro_msg);
                        }
                        break;
                    } else if (!in_array($oDados10->si25_naturezareceita, $aRectceSaudEduc)
                        || $oDados10->si25_identificadordeducao != 0
                        || $oDados10->si25_identificadordeducao != ''
                    ) {

                        $clarc21 = new cl_arc212023();
                        $clarc21->si32_tiporegistro = 21;
                        $clarc21->si32_reg20 = $clarc20->si31_sequencial;
                        $clarc21->si32_codestorno = intval($oDados10->si25_codreceita);
                        $clarc21->si32_codfonteestornada = $oDados11->si26_codfontrecursos;
                        $clarc21->si32_codigocontroleorcamentario = $oDados11->si26_codigocontroleorcamentario;
                        $clarc21->si32_tipodocumento = intval($oDados11->si26_tipodocumento);// \d arc212023
                        $clarc21->si32_nrodocumento = $oDados11->si26_cnpjorgaocontribuinte;
                        $clarc21->si32_nroconvenio = $oDados11->si26_nroconvenio;
                        $clarc21->si32_dataassinatura = $oDados11->si26_dataassinatura;
                        $clarc21->si32_nrocontratoop = $oDados11->si26_nrocontratoop;
                        $clarc21->si32_dataassinaturacontratoop = $oDados11->si26_dataassinaturacontratoop;
                        $clarc21->si32_vlestornadofonte = number_format(abs($oDados11->si26_vlarrecadadofonte), 2, ".", "");
                        $clarc21->si32_mes = intval($oDados11->si26_mes);
                        $clarc21->si32_instit = db_getsession("DB_instit");
                        $clarc21->incluir(null);
                        if ($clarc21->erro_status == 0) {
                            throw new Exception($clarc21->erro_msg);
                        }

                    }

                }

            }

        }

        db_fim_transacao();
        $oGerarARC = new GerarARC();
        $oGerarARC->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oGerarARC->gerarDados();

    }
}
