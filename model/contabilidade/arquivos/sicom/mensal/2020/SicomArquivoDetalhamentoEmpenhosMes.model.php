<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_emp102020_classe.php");
require_once("classes/db_emp112020_classe.php");
require_once("classes/db_emp122020_classe.php");
require_once("classes/db_emp302020_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarEMP.model.php");

/**
 * detalhamento dos empenhos do mês Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoDetalhamentoEmpenhosMes extends SicomArquivoBase implements iPadArquivoBaseCSV
{

    /**
     *
     * Codigo do layout. (db_layouttxt.db50_codigo)
     * @var Integer
     */
    protected $iCodigoLayout = 166;

    /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'EMP';

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

    /**
     * selecionar os dados dos empenhos do mes para gerar o arquivo
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados()
    {

        $cEmp10 = new cl_emp102020();
        $cEmp11 = new cl_emp112020();
        $cEmp12 = new cl_emp122020();
        $cEmp30 = new cl_emp302020();

        $sSqlInstit = "select cgc from db_config where codigo = " . db_getsession("DB_instit");
        $rsResultCnpj = db_query($sSqlInstit);
        $sCnpj = db_utils::fieldsMemory($rsResultCnpj, 0)->cgc;


        $sSqlTrataUnidade = "select si08_tratacodunidade from infocomplementares where si08_instit = " . db_getsession("DB_instit");
        $rsResultTrataUnidade = db_query($sSqlTrataUnidade);
        $sTrataCodUnidade = db_utils::fieldsMemory($rsResultTrataUnidade, 0)->si08_tratacodunidade;


        db_inicio_transacao();

        /**
         * excluir informacoes do mes caso ja tenha sido gerado anteriormente
         */

        $result = $cEmp10->sql_record($cEmp10->sql_query(null, "*", null, "si106_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'])
            . " and si106_instit = " . db_getsession("DB_instit"));

        if (pg_num_rows($result) > 0) {

            $cEmp30->excluir(null, "si206_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
                . " and si206_instit = " . db_getsession("DB_instit"));
            $cEmp12->excluir(null, "si108_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
                . " and si108_instit = " . db_getsession("DB_instit"));
            $cEmp11->excluir(null, "si107_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
                . " and si107_instit = " . db_getsession("DB_instit"));
            $cEmp10->excluir(null, "si106_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
                . " and si106_instit = " . db_getsession("DB_instit"));
            if ($cEmp10->erro_status == 0) {
                throw new Exception($cEmp10->erro_msg);
            }
        }

        db_fim_transacao();

        /**
         * selecionar arquivo xml de dados elemento da despesa
         */
        $sArquivo = "config/sicom/" . db_getsession("DB_anousu") . "/{$sCnpj}_sicomelementodespesa.xml";
        // print_r('enter');
        // print_r($sArquivo);
        if (!file_exists($sArquivo)) {
            throw new Exception("Arquivo de elemento da despesa inexistente!");
        }
        $sTextoXml = file_get_contents($sArquivo);
        $oDOMDocument = new DOMDocument();
        $oDOMDocument->loadXML($sTextoXml);
        $oElementos = $oDOMDocument->getElementsByTagName('elemento');

        /**
         * selecionar arquivo xml de Dados Compl Licitação
         */
        $sArquivo = "config/sicom/" . (db_getsession("DB_anousu") - 1) . "/{$sCnpj}_sicomdadoscompllicitacao.xml";
        /*if (!file_exists($sArquivo)) {
            throw new Exception("Arquivo de dados compl licitacao inexistente!");
        }*/
        $sTextoXml = file_get_contents($sArquivo);
        $oDOMDocument = new DOMDocument();
        $oDOMDocument->loadXML($sTextoXml);
        $oDadosComplLicitacoes = $oDOMDocument->getElementsByTagName('dadoscompllicitacao');


        $sSql = "SELECT si09_codorgaotce AS codorgao,
        si09_tipoinstit
        FROM infocomplementaresinstit
        WHERE si09_instit = " . db_getsession("DB_instit");

        $rsResult = db_query($sSql);
        $sCodorgao = db_utils::fieldsMemory($rsResult, 0);

        $sSql = "SELECT DISTINCT 10 AS tiporegistro,
        CASE
        WHEN orcorgao.o40_codtri = '0'
        OR NULL THEN orcorgao.o40_orgao::varchar
        ELSE orcorgao.o40_codtri
        END AS o58_orgao,
        CASE
        WHEN orcunidade.o41_codtri = '0'
        OR NULL THEN orcunidade.o41_unidade::varchar
        ELSE orcunidade.o41_codtri
        END AS o58_unidade,
        o15_codtri,
        si09_codorgaotce AS codorgao,
        lpad((CASE
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
        END) AS codunidadesub,
        o58_funcao AS codfuncao,
        o58_subfuncao AS codsubfuncao,
        o58_programa AS codprograma,
        o58_projativ AS idacao,
        o55_origemacao AS idsubacao,
        substr(o56_elemento,2,12) AS naturezadadespesa,
        substr(o56_elemento,7,2) AS subelemento,
        e60_codemp AS nroempenho,
        e60_emiss AS dtempenho,
        CASE
        WHEN e60_codtipo = 2 THEN 3
        WHEN e60_codtipo = 3 THEN 2
        ELSE 1
        END AS modalidadempenho,
        CASE
        WHEN si09_tipoinstit = 5 THEN COALESCE(e54_tipodespesa,0)
        ELSE 0
        END AS tipodespesa,
        CASE
        WHEN substr(o56_elemento,1,3) = '346' THEN 2
        ELSE 1
        END AS tpempenho,
        e60_vlremp AS vlbruto,
        e60_resumo AS especificaoempenho,

        CASE
        WHEN ac16_sequencial IS NULL THEN 2
        ELSE 1
        END AS despdeccontrato,
        ' '::char AS codorgaorespcontrato,

        CASE WHEN ac16_sequencial IS NULL THEN NULL ELSE (SELECT CASE
        WHEN o41_subunidade != 0
        OR NOT NULL THEN lpad((CASE
        WHEN o40_codtri = '0'
        OR NULL THEN o40_orgao::varchar
        ELSE o40_codtri
        END),2,0)||lpad((CASE
        WHEN o41_codtri = '0'
        OR NULL THEN o41_unidade::varchar
        ELSE o41_codtri
        END),3,0)||lpad(o41_subunidade::integer,3,0)
        ELSE lpad((CASE
        WHEN o40_codtri = '0'
        OR NULL THEN o40_orgao::varchar
        ELSE o40_codtri
        END),2,0)||lpad((CASE
        WHEN o41_codtri = '0'
        OR NULL THEN o41_unidade::varchar
        ELSE o41_codtri
        END),3,0)
        END AS unidadesub
        FROM db_departorg
        LEFT JOIN infocomplementares ON (si08_anousu, si08_instit) = (db01_anousu, 1)
        JOIN orcunidade u ON (db01_orgao, db01_unidade, db01_anousu) = (u.o41_orgao, u.o41_unidade, u.o41_anousu)
        JOIN orcorgao o ON (o.o40_orgao, o.o40_anousu) = (u.o41_orgao, u.o41_anousu)
        WHERE db01_coddepto = ac16_deptoresponsavel
        AND db01_anousu = ac16_anousu
        LIMIT 1)
        END AS codunidadesubrespcontrato, 

        CASE
        WHEN ac16_sequencial IS NULL THEN NULL
        ELSE ac16_numeroacordo
        END AS nrocontrato,
        CASE
        WHEN ac16_sequencial IS NULL THEN NULL
        ELSE ac16_dataassinatura
        END AS dataassinaturacontrato,
        CASE
        WHEN ac16_sequencial IS NULL THEN NULL
        ELSE ac26_numeroaditamento
        END AS nrosequencialtermoaditivo,

        CASE
        WHEN e60_numconvenio is null THEN 2
        ELSE 1
        END AS despdecconvenio,
        CASE
        WHEN e60_numconvenio IS NULL THEN NULL
        ELSE (SELECT c206_nroconvenio FROM convconvenios WHERE c206_sequencial = e60_numconvenio)
        END AS nroconvenio,
        CASE
        WHEN e60_convenio IS NULL THEN NULL
        ELSE (SELECT c206_dataassinatura FROM convconvenios WHERE c206_sequencial = e60_numconvenio)
        END AS dataassinaturaconvenio,
        CASE
        WHEN l20_codigo IS NULL THEN 1
        WHEN l03_pctipocompratribunal IN (100, 101, 102, 103) THEN 3
        ELSE 2
        END AS despDecLicitacao,
        ' ' AS codorgaoresplicit,
        CASE
        WHEN l20_codigo IS NULL THEN NULL
        ELSE
        (SELECT CASE
        WHEN o41_subunidade != 0
        OR NOT NULL THEN lpad((CASE
        WHEN o40_codtri = '0'
        OR NULL THEN o40_orgao::varchar
        ELSE o40_codtri
        END),2,0)||lpad((CASE
        WHEN o41_codtri = '0'
        OR NULL THEN o41_unidade::varchar
        ELSE o41_codtri
        END),3,0)||lpad(o41_subunidade::integer,3,0)
        ELSE lpad((CASE
        WHEN o40_codtri = '0'
        OR NULL THEN o40_orgao::varchar
        ELSE o40_codtri
        END),2,0)||lpad((CASE
        WHEN o41_codtri = '0'
        OR NULL THEN o41_unidade::varchar
        ELSE o41_codtri
        END),3,0)
        END AS unidadesub
        FROM db_departorg
        JOIN infocomplementares ON si08_anousu = db01_anousu AND si08_instit = 1
        JOIN orcunidade u ON db01_orgao=u.o41_orgao AND db01_unidade=u.o41_unidade AND db01_anousu = u.o41_anousu
        JOIN orcorgao o ON o.o40_orgao = u.o41_orgao AND o.o40_anousu = u.o41_anousu
        WHERE db01_coddepto = l20_codepartamento
        AND db01_anousu = e60_anousu
        LIMIT 1)
        END AS codunidadesubresplicit,
        liclicita.l20_codigo,
        CASE
        WHEN l20_codigo IS NULL THEN NULL
        ELSE l20_edital
        END nroprocessolicitatorio,
        CASE
        WHEN l20_codigo IS NULL THEN NULL
        ELSE l20_anousu
        END exercicioprocessolicitatorio,
        CASE
        WHEN l20_codigo IS NULL THEN NULL
        WHEN l03_pctipocompratribunal NOT IN (100, 101, 102, 103) THEN NULL
        WHEN l03_pctipocompratribunal = 100 THEN 2
        WHEN l03_pctipocompratribunal = 101 THEN 1
        ELSE 3
        END AS tipoprocesso,
        o.z01_cgccpf AS ordenador,
        e60_numemp AS numemp,
        CASE
        WHEN length(cgm.z01_cgccpf) = 11 THEN 1
        ELSE 2
        END AS tipodocumento,
        cgm.z01_cgccpf AS nrodocumento,
        orcunidade.o41_subunidade AS subunidade,
        homologacaoadjudica.l202_datahomologacao AS datahomologacao,
        ac16_deptoresponsavel,
        2 as si106_despdecconvenioconge,
        NULL as si106_nroconvenioconge,
        NULL as si106_dataassinaturaconvenioconge,
        e60_tipodespesa

        FROM empempenho
        JOIN orcdotacao ON e60_coddot = o58_coddot
        JOIN empelemento ON e60_numemp = e64_numemp
        JOIN orcelemento ON e64_codele = o56_codele
        JOIN orctiporec ON o58_codigo = o15_codigo
        JOIN emptipo ON e60_codtipo = e41_codtipo
        JOIN cgm ON e60_numcgm = z01_numcgm
        JOIN orcprojativ ON (o58_anousu, o58_projativ) = (o55_anousu, o55_projativ)
        LEFT JOIN pctipocompra ON e60_codcom = pc50_codcom
        LEFT JOIN cflicita ON pc50_pctipocompratribunal = l03_pctipocompratribunal AND l03_instit = " . db_getsession("DB_instit") . "
        LEFT JOIN infocomplementaresinstit ON si09_instit = e60_instit
        LEFT JOIN liclicita ON (ltrim(((string_to_array(e60_numerol, '/'))[1])::varchar,'0'), l20_anousu::varchar, l03_codigo) = (l20_edital::varchar, ((string_to_array(e60_numerol, '/'))[2])::varchar, l20_codtipocom)
        LEFT JOIN orcunidade ON (o58_anousu, o58_orgao, o58_unidade) = (orcunidade.o41_anousu, orcunidade.o41_orgao, orcunidade.o41_unidade)
        LEFT JOIN orcorgao ON (orcorgao.o40_orgao, orcorgao.o40_anousu) = (orcunidade.o41_orgao, orcunidade.o41_anousu)
        LEFT JOIN cgm o ON o.z01_numcgm = orcunidade.o41_orddespesa
        LEFT JOIN homologacaoadjudica ON l20_codigo = l202_licitacao
        LEFT JOIN empempaut ON e61_numemp = e60_numemp
        LEFT JOIN empautoriza ON e61_autori = e60_numemp
        
        LEFT JOIN acordoitemexecutadoempautitem on ac19_autori = e61_autori
        LEFT JOIN acordoitemexecutado on ac29_sequencial = ac19_acordoitemexecutado
        LEFT JOIN acordoitem on ac20_sequencial = ac29_acordoitem
        LEFT JOIN acordoposicao on ac20_acordoposicao = ac26_sequencial
        LEFT JOIN acordo on ac26_acordo = ac16_sequencial AND ac16_acordosituacao = 4
        
        WHERE e60_anousu = " . db_getsession("DB_anousu") . "
        AND o56_anousu = " . db_getsession("DB_anousu") . "
        AND o58_anousu = " . db_getsession("DB_anousu") . "
        AND e60_instit = " . db_getsession("DB_instit") . "
        AND e60_emiss between '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'  order by e60_codemp";
        
        $rsEmpenho10 = db_query($sSql);

        $aCaracteres = array("°", chr(13), chr(10), "'", ";");
        // matriz de entrada
        $what = array("°", chr(13), chr(10), 'ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'Ã', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º');

        // matriz de saída
        $by = array('', '', '', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ');

        /**
         * elementos de despesa utilizados para verificar se a despesa precisa ser identificada como sendo do poder executivo ou legislativo
         * par empenhos de orgaos RPPS
         */
        $aTipoDespEmpRPPS = array('31900101', '31900102', '31900301', '31900302', '31900501', '31900502', '31900503', '31909102', '31909103', '31909201',
            '31909202', '31909203', '31909403', '31919102', '31919103', '31919201', '31919202', '31919203', '31969102', '31969103', '31969201', '31969202', '31969203');

        for ($iCont = 0; $iCont < pg_num_rows($rsEmpenho10); $iCont++) {

            $oEmpenho10 = db_utils::fieldsMemory($rsEmpenho10, $iCont);

            /**
             *pega os codigos de unidade e subunidade do departamento do contrato somente necessario quando despesa for de contrato.
             */
            if($oEmpenho10->despdeccontrato == 1) {
                $sSql = " SELECT CASE
                WHEN o40_codtri = '0'
                OR NULL THEN o40_orgao::varchar
                ELSE o40_codtri
                END AS db01_orgao,
                CASE
                WHEN o41_codtri = '0'
                OR NULL THEN o41_unidade::varchar
                ELSE o41_codtri
                END AS db01_unidade,
                o41_subunidade
                FROM db_departorg
                JOIN orcunidade ON (db01_orgao, db01_unidade, db01_anousu) = (o41_orgao, o41_unidade, o41_anousu)
                JOIN orcorgao ON (o40_orgao, o40_anousu) = (o41_orgao, o41_anousu)
                WHERE db01_anousu = " . db_getsession("DB_anousu") . "
                AND db01_coddepto =" . $oEmpenho10->ac16_deptoresponsavel;
                $rsDepart = db_query($sSql);

                $sOrgDepart = db_utils::fieldsMemory($rsDepart, 0)->db01_orgao;
                $sUnidDepart = db_utils::fieldsMemory($rsDepart, 0)->db01_unidade;
                $sSubUnidade = db_utils::fieldsMemory($rsDepart, 0)->o41_subunidade;

                $sCodUnidade = str_pad($sOrgDepart, 2, "0", STR_PAD_LEFT) . str_pad($sUnidDepart, 3, "0", STR_PAD_LEFT);
                if ($sSubUnidade == 1) {
                    $sCodUnidade .= str_pad($sSubUnidade, 3, "0", STR_PAD_LEFT);
                }
            }

            if ($sTrataCodUnidade == 1) {
                $sCodUnidade = str_pad($oEmpenho10->o58_orgao, 2, "0", STR_PAD_LEFT);
                $sCodUnidade .= str_pad($oEmpenho10->o58_unidade, 3, "0", STR_PAD_LEFT);
            } else {
                $sCodUnidade = $oEmpenho10->codunidadesub;
            }

            $sElemento = substr($oEmpenho10->naturezadadespesa, 0, 8);
            /**
             * percorrer xml elemento despesa
             */
            foreach ($oElementos as $oElemento) {

                if ($oElemento->getAttribute('instituicao') == db_getsession("DB_instit")) {

                    if ($oElemento->getAttribute('deParaDesdobramento') != '' && $oElemento->getAttribute('deParaDesdobramento') == 1) {
                        if($oElemento->getAttribute('elementoEcidade') == $oEmpenho10->naturezadadespesa) {
                            $sElemento = $oElemento->getAttribute('elementoSicom');
                            break;
                        }
                    } elseif ($oElemento->getAttribute('elementoEcidade') == $sElemento) {
                        $sElemento = $oElemento->getAttribute('elementoSicom');
                        break;
                    }

                }

            }

            db_inicio_transacao();

            $oDadosEmpenho10 = new cl_emp102020();

            $oDadosEmpenho10->si106_tiporegistro = $oEmpenho10->tiporegistro; // campo 1
            $oDadosEmpenho10->si106_codorgao = $oEmpenho10->codorgao; // campo 2
            $oDadosEmpenho10->si106_codunidadesub = $sCodUnidade; // campo 3
            $oDadosEmpenho10->si106_codfuncao = $oEmpenho10->codfuncao; // campo 4
            $oDadosEmpenho10->si106_codsubfuncao = $oEmpenho10->codsubfuncao; // campo 5
            $oDadosEmpenho10->si106_codprograma = $oEmpenho10->codprograma; // campo 6
            $oDadosEmpenho10->si106_idacao = $oEmpenho10->idacao; // campo 7
            $oDadosEmpenho10->si106_idsubacao = $oEmpenho10->idsubacao; // campo 8
            $oDadosEmpenho10->si106_naturezadespesa = substr($sElemento, 0, 6); // campo 9
            $oDadosEmpenho10->si106_subelemento = substr($sElemento, 6, 2); // campo 10
            $oDadosEmpenho10->si106_nroempenho = $oEmpenho10->nroempenho; // campo 11
            $oDadosEmpenho10->si106_dtempenho = $oEmpenho10->dtempenho; // campo 12
            $oDadosEmpenho10->si106_modalidadeempenho = $oEmpenho10->modalidadempenho; // campo 13
            $oDadosEmpenho10->si106_tpempenho = $oEmpenho10->tpempenho; // campo 14
            $oDadosEmpenho10->si106_vlbruto = $oEmpenho10->vlbruto; // campo 15
            $oDadosEmpenho10->si106_especificacaoempenho = $oEmpenho10->especificaoempenho == '' ? 'SEM HISTORICO' :
                trim(preg_replace("/[^a-zA-Z0-9 ]/", "", substr(str_replace($what, $by, $oEmpenho10->especificaoempenho), 0, 200))); // campo 16

                $aAnoContrato = explode('-', $oEmpenho10->dtassinaturacontrato);



                if ( (date('Y', strtotime($oEmpenho10->dtempenho)) <= date('Y', strtotime($oEmpenho10->dataassinaturacontrato)) &&  date('m', strtotime($oEmpenho10->dtempenho)) < date('m', strtotime($oEmpenho10->dataassinaturacontrato)) ) 
                    || $oEmpenho10->dataassinaturacontrato == null) {



                    if ($oEmpenho10->despdeccontrato == 1) {
                    $oDadosEmpenho10->si106_despdeccontrato = 4; // campo 17
                } else {
                    $oDadosEmpenho10->si106_despdeccontrato = 2; // campo 17
                }
                if ($oEmpenho10->despdeccontrato == 3) {
                    $oDadosEmpenho10->si106_codorgaorespcontrato = $sCodorgao->codorgao; // campo 18
                } else {
                    $oDadosEmpenho10->si106_codorgaorespcontrato = ''; // campo 18
                }
                $oDadosEmpenho10->si106_codunidadesubrespcontrato = ''; // campo 19
                $oDadosEmpenho10->si106_nrocontrato = ''; // campo 20
                $oDadosEmpenho10->si106_dtassinaturacontrato = ''; // campo 21
                $oDadosEmpenho10->si106_nrosequencialtermoaditivo = ''; // campo 22
                
            }else {
                $oDadosEmpenho10->si106_despdeccontrato = $oEmpenho10->despdeccontrato; // campo 17
                if ($oEmpenho10->despdeccontrato == 3) {
                    $oDadosEmpenho10->si106_codorgaorespcontrato = $sCodorgao->codorgao; // campo 18
                } else {
                    $oDadosEmpenho10->si106_codorgaorespcontrato = ''; // campo 18
                }

                if (in_array($oEmpenho10->despdeccontrato, array(1, 3))) {
                    $oDadosEmpenho10->si106_codunidadesubrespcontrato = $oEmpenho10->codunidadesubrespcontrato; // campo 19
                } else {
                    $oDadosEmpenho10->si106_codunidadesubrespcontrato = ''; // campo 19
                }
                $oDadosEmpenho10->si106_nrocontrato = $oEmpenho10->nrocontrato; // campo 20
                $oDadosEmpenho10->si106_dtassinaturacontrato = $oEmpenho10->dataassinaturacontrato; // campo 21
                $oDadosEmpenho10->si106_nrosequencialtermoaditivo = $oEmpenho10->nrosequencialtermoaditivo; // campo 22
            }

            $oDadosEmpenho10->si106_despdecconvenio = $oEmpenho10->despdecconvenio; // campo 23
            $oDadosEmpenho10->si106_nroconvenio = $oEmpenho10->nroconvenio; // campo 24
            $oDadosEmpenho10->si106_dataassinaturaconvenio = $oEmpenho10->dataassinaturaconvenio; // campo 25
            $oDadosEmpenho10->si106_despdecconvenioconge = $oEmpenho10->si106_despdecconvenioconge; // campo 26
            $oDadosEmpenho10->si106_nroconvenioconge = $oEmpenho10->si106_nroconvenioconge; // campo 27
            $oDadosEmpenho10->si106_dataassinaturaconvenioconge = $oEmpenho10->si106_dataassinaturaconvenioconge; // campo 28
            $aHomologa = explode("-", $oEmpenho10->datahomologacao);
            if (($oEmpenho10->datahomologacao == null && $oDadosEmpenho10->exercicioprocessolicitatorio < 2014) || $aHomologa[0] < 2014) {
                $oDadosEmpenho10->si106_despdeclicitacao = 1; // campo 29
                $oDadosEmpenho10->si106_codunidadesubresplicit = null; // campo 30
                $oDadosEmpenho10->si106_nroprocessolicitatorio = null; // campo 31
                $oDadosEmpenho10->si106_exercicioprocessolicitatorio = null; // campo 32
                $oDadosEmpenho10->si106_tipoprocesso = null; // campo 33
            } else {
                $oDadosEmpenho10->si106_despdeclicitacao = $oEmpenho10->despdeclicitacao; // campo 29
                $oDadosEmpenho10->si106_codunidadesubresplicit = $oEmpenho10->codunidadesubresplicit; // campo 30
                $oDadosEmpenho10->si106_nroprocessolicitatorio = $oEmpenho10->nroprocessolicitatorio; // campo 31
                $oDadosEmpenho10->si106_exercicioprocessolicitatorio = $oEmpenho10->exercicioprocessolicitatorio; // campo 32
                $oDadosEmpenho10->si106_tipoprocesso = $oEmpenho10->tipoprocesso; // campo 33
            }
            $oDadosEmpenho10->si106_cpfordenador = substr($oEmpenho10->ordenador, 0, 11); // campo 34
            /*
             * verificar se o tipo de despesa se enquadra nos elementos necessários para informar esse campo para RPPS
             */
            if (($sCodorgao->si09_tipoinstit == 5 || $sCodorgao->si09_tipoinstit == 6) && (in_array($sElemento, $aTipoDespEmpRPPS))) {
                $oDadosEmpenho10->si106_tipodespesaemprpps = $oEmpenho10->e60_tipodespesa; // campo 35
            }else{
                $oDadosEmpenho10->si106_tipodespesaemprpps = null; // campo 35
            }
            $oDadosEmpenho10->si106_mes = $this->sDataFinal['5'] . $this->sDataFinal['6']; // campo 36
            $oDadosEmpenho10->si106_instit = db_getsession("DB_instit"); // campo 37

            $oDadosEmpenho10->incluir();
            if ($oDadosEmpenho10->erro_status == 0) {
              throw new Exception($oDadosEmpenho10->erro_msg);
          }

            /**
             * dados registro 11
             */
            $oDadosEmpenhoFonte = new cl_emp112020();

            $oDadosEmpenhoFonte->si107_tiporegistro = 11;
            $oDadosEmpenhoFonte->si107_codunidadesub = $sCodUnidade;
            $oDadosEmpenhoFonte->si107_nroempenho = $oEmpenho10->nroempenho;
            $oDadosEmpenhoFonte->si107_codfontrecursos = $oEmpenho10->o15_codtri;
            $oDadosEmpenhoFonte->si107_valorfonte = $oEmpenho10->vlbruto;
            $oDadosEmpenhoFonte->si107_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $oDadosEmpenhoFonte->si107_reg10 = $oDadosEmpenho10->si106_sequencial;
            $oDadosEmpenhoFonte->si107_instit = db_getsession("DB_instit");

            $oDadosEmpenhoFonte->incluir(null);
            if ($oDadosEmpenhoFonte->erro_status == 0) {
                throw new Exception($oDadosEmpenhoFonte->erro_msg);
            }


            $oEmp12 = new cl_emp122020();

            $oEmp12->si108_tiporegistro = '12';
            $oEmp12->si108_codunidadesub = $sCodUnidade;
            $oEmp12->si108_nroempenho = $oEmpenho10->nroempenho;
            $oEmp12->si108_tipodocumento = $oEmpenho10->tipodocumento;
            $oEmp12->si108_nrodocumento = $oEmpenho10->nrodocumento;
            $oEmp12->si108_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $oEmp12->si108_reg10 = $oDadosEmpenho10->si106_sequencial;
            $oEmp12->si108_instit = db_getsession("DB_instit");

            $oEmp12->incluir(null);
            if ($oEmp12->erro_status == 0) {
                throw new Exception($oEmp12->erro_msg);
            }

        }

        /**
         * Consulta do registro 30
         */

        $sSql = "SELECT  ac16_sequencial AS acordo, ac16_dataassinatura, e60_emiss, e60_codemp, e60_numemp
        FROM  empempenhocontrato
        INNER JOIN  acordo ON ac16_sequencial = e100_acordo
        INNER JOIN  empempenho ON e100_numemp = e60_numemp
        WHERE  (
        (date_part('year', empempenho.e60_emiss) < date_part('year',acordo.ac16_dataassinatura))
        OR  (date_part('year',empempenho.e60_emiss) = date_part('year', acordo.ac16_dataassinatura)
        AND  date_part('month', empempenho.e60_emiss) < date_part('month', acordo.ac16_dataassinatura))
        )
        AND  acordo.ac16_dataassinatura between '".$this->sDataInicial."' AND '".$this->sDataFinal."'
        AND  e60_instit = " . db_getsession("DB_instit") .";";

        $rsEmpenhoContrato30 = db_query($sSql);

        // debug ini
        // for($jCont = 0; $jCont < pg_num_rows($rsEmpenhoContrato30); $jCont++){
        //     var_dump(db_utils::fieldsMemory($rsEmpenhoContrato30, $jCont));
        // }
        // die('teste');
        // debug fim

        if(pg_num_rows($rsEmpenhoContrato30) > 0){

          for($jCont = 0; $jCont < pg_num_rows($rsEmpenhoContrato30); $jCont++){

            $sSql = "SELECT  DISTINCT 30 AS tiporegistro,
            si09_codorgaotce AS codorgao,
            lpad((CASE WHEN orcorgao.o40_codtri = '0' OR NULL THEN orcorgao.o40_orgao::varchar ELSE orcorgao.o40_codtri END),2,0)||lpad(
            (CASE WHEN orcunidade.o41_codtri = '0' OR NULL THEN orcunidade.o41_unidade::varchar ELSE orcunidade.o41_codtri END),3,0)||(
            CASE WHEN orcunidade.o41_subunidade = '0' OR NULL THEN '' ELSE lpad(orcunidade.o41_subunidade::VARCHAR,3,0) END) AS codunidadesub,
            e60_codemp AS nroempenho,
            e60_emiss AS dtempenho,
            ' '::char as codorgaorespcontrato,
            case when ac16_sequencial is null then null else (
            SELECT CASE WHEN o41_subunidade != 0 OR NOT NULL THEN lpad(
            (CASE WHEN o40_codtri = '0' OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||
            lpad((CASE WHEN o41_codtri = '0' OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||
            lpad(o41_subunidade::integer,3,0) ELSE
            lpad((CASE WHEN o40_codtri = '0' OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||
            lpad((CASE WHEN o41_codtri = '0' OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
            END AS unidadesub
            FROM db_departorg
            JOIN infocomplementares ON si08_anousu = db01_anousu AND si08_instit = 1
            JOIN orcunidade u ON db01_orgao=u.o41_orgao AND db01_unidade=u.o41_unidade AND db01_anousu = u.o41_anousu
            JOIN orcorgao o ON o.o40_orgao = u.o41_orgao
            AND o.o40_anousu = u.o41_anousu
            WHERE db01_coddepto = ac16_deptoresponsavel AND db01_anousu = ac16_anousu LIMIT 1) END AS codunidadesubrespcontrato,
            case when ac16_sequencial is null then null else ac16_numeroacordo end as nrocontrato,
            case when ac16_sequencial is null then null else ac16_dataassinatura end as dataassinaturacontrato,
            case when ac16_sequencial is null then null else ac26_numeroaditamento end as nrosequencialtermoaditivo,
            CASE WHEN e60_numconvenio IS NULL THEN NULL ELSE
            (select c206_nroconvenio FROM convconvenios WHERE c206_sequencial = e60_numconvenio) END AS nroconvenio,
            CASE WHEN e60_convenio IS NULL THEN NULL ELSE
            (select c206_dataassinatura FROM convconvenios WHERE c206_sequencial = e60_numconvenio) END AS dataassinaturaconvenio,
            NULL as si106_nroconvenioconge,
            NULL as si106_dataassinaturaconvenioconge
            
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
            LEFT JOIN acordo on ac26_acordo = ac16_sequencial
            and ac16_acordosituacao = 4          
            WHERE  e60_numemp = ".db_utils::fieldsMemory($rsEmpenhoContrato30, $jCont)->e60_numemp.";";

            $rsRegistro30 = db_query($sSql);

            for ($kCont = 0; $kCont < pg_num_rows($rsRegistro30); $kCont++) {

              $oEmpenho30 = db_utils::fieldsMemory($rsRegistro30, $kCont);

              /**
              * dados do registro 30
              */
              $oDadosEmpenho30 = new cl_emp302020();

              $oDadosEmpenho30->si206_tiporegistro = $oEmpenho30->tiporegistro; // campo 1
              $oDadosEmpenho30->si206_codorgao = $oEmpenho30->codorgao; //campo 2
              $oDadosEmpenho30->si206_codunidadesub = $oEmpenho30->codunidadesub; // campo 3
              $oDadosEmpenho30->si206_nroempenho = $oEmpenho30->nroempenho; // campo 4
              $oDadosEmpenho30->si206_dtempenho = $oEmpenho30->dtempenho; // campo 5

              $oDadosEmpenho30->si206_codorgaorespcontrato = $oEmpenho30->codorgaorespcontrato; // campo 18
              $oDadosEmpenho30->si206_codunidadesubrespcontrato = $oEmpenho30->codunidadesubrespcontrato; // campo 19
              $oDadosEmpenho30->si206_nrocontrato = $oEmpenho30->nrocontrato; // campo 20
              $oDadosEmpenho30->si206_dtassinaturacontrato = $oEmpenho30->dataassinaturacontrato; // campo 21
              $oDadosEmpenho30->si206_nrosequencialtermoaditivo = $oEmpenho30->nrosequencialtermoaditivo; // campo 22

              $oDadosEmpenho30->si206_nroconvenio = $oEmpenho30->nroconvenio; // campo 24
              $oDadosEmpenho30->si206_dtassinaturaconvenio = $oEmpenho30->dataassinaturaconvenio; // campo 25
              $oDadosEmpenho30->si206_nroconvenioconge = ''; // campo 27
              $oDadosEmpenho30->si206_dtassinaturaconge = ''; // campo 28
              $oDadosEmpenho30->si206_mes = $this->sDataFinal['5'] . $this->sDataFinal['6']; // campo 36
              $oDadosEmpenho30->si206_instit = db_getsession("DB_instit"); // campo 37

              $oDadosEmpenho30->incluir();
          }
      }

      if ($oDadosEmpenho30->erro_status == 0) {
        throw new Exception($oDadosEmpenho30->erro_msg);
    }

}


db_fim_transacao();

$oGerarEMP = new GerarEMP();
$oGerarEMP->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
$oGerarEMP->gerarDados();

}
}
