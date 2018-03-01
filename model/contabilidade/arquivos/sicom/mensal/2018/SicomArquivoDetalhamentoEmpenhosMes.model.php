<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_emp102018_classe.php");
require_once("classes/db_emp112018_classe.php");
require_once("classes/db_emp122018_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2018/GerarEMP.model.php");

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

        $cEmp10 = new cl_emp102018();
        $cEmp11 = new cl_emp112018();
        $cEmp12 = new cl_emp122018();

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


        $sSql = "SELECT si09_codorgaotce AS codorgao
              FROM infocomplementaresinstit
              WHERE si09_instit = " . db_getsession("DB_instit");

        $rsResult = db_query($sSql);
        $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;

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
                substr(o56_elemento,2,8) AS naturezadadespesa,
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

                case when ac16_sequencial is null then 2 else 1 end as despdeccontrato,
				       ' '::char as codorgaorespcontrato,
                case when ac16_sequencial is null then null else (SELECT CASE
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
                              JOIN infocomplementares ON si08_anousu = db01_anousu
                              AND si08_instit = 1
                              JOIN orcunidade u ON db01_orgao=u.o41_orgao
                              AND db01_unidade=u.o41_unidade
                              AND db01_anousu = u.o41_anousu
                              JOIN orcorgao o ON o.o40_orgao = u.o41_orgao
                              AND o.o40_anousu = u.o41_anousu
                              WHERE db01_coddepto = ac16_deptoresponsavel
                                  AND db01_anousu = ac16_anousu
                              LIMIT 1)
                END AS codunidadesubrespcontrato,
				case when ac16_sequencial is null then null else ac16_numeroacordo end as nrocontrato,
				case when ac16_sequencial is null then null else ac16_dataassinatura end as dataassinaturacontrato,
				case when ac16_sequencial is null then null else ac26_numeroaditamento end as nrosequencialtermoaditivo,

                CASE
                    WHEN e60_convenio = 1 THEN 1
                    ELSE 2
                END AS despdecconvenio,
                CASE
                    WHEN e60_convenio = 2 THEN NULL
                    ELSE e60_numconvenio
                END AS nroconvenio,
                CASE
                    WHEN e60_convenio = 2 THEN NULL
                    ELSE e60_dataconvenio
                END AS dataassinaturaconvenio,
                CASE
                    WHEN l20_codigo IS NULL THEN 1
                    WHEN l03_pctipocompratribunal IN (100,
                                                      101,
                                                      102) THEN 3
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
                              JOIN infocomplementares ON si08_anousu = db01_anousu
                              AND si08_instit = 1
                              JOIN orcunidade u ON db01_orgao=u.o41_orgao
                              AND db01_unidade=u.o41_unidade
                              AND db01_anousu = u.o41_anousu
                              JOIN orcorgao o ON o.o40_orgao = u.o41_orgao
                              AND o.o40_anousu = u.o41_anousu
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
                    WHEN l03_pctipocompratribunal NOT IN (100,
                                                          101,
                                                          102) THEN NULL
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

            WHERE e60_anousu = " . db_getsession("DB_anousu") . "
              AND o56_anousu = " . db_getsession("DB_anousu") . "
              AND o58_anousu = " . db_getsession("DB_anousu") . "
              AND e60_instit = " . db_getsession("DB_instit") . "
              AND e60_emiss between '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'  order by e60_codemp";

        $rsEmpenho = db_query($sSql);
//        echo pg_last_error();
//        echo $sSql;db_criatabela($rsEmpenho);exit;
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

        for ($iCont = 0; $iCont < pg_num_rows($rsEmpenho); $iCont++) {

            $oEmpenho = db_utils::fieldsMemory($rsEmpenho, $iCont);



            $sSql = "select CASE WHEN o40_codtri = '0'
                     OR NULL THEN o40_orgao::varchar ELSE o40_codtri END AS db01_orgao,
                     CASE WHEN o41_codtri = '0'
                     OR NULL THEN o41_unidade::varchar ELSE o41_codtri END AS db01_unidade,o41_subunidade from db_departorg
                     join orcunidade on db01_orgao = o41_orgao and db01_unidade = o41_unidade
                     and db01_anousu = o41_anousu
                     JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                     where db01_anousu = " . db_getsession("DB_anousu") . " and db01_coddepto = " . $oEmpenho->ac16_deptoresponsavel;

            $rsDepart = db_query($sSql);
            $sOrgDepart = db_utils::fieldsMemory($rsDepart, 0)->db01_orgao;
            $sUnidDepart = db_utils::fieldsMemory($rsDepart, 0)->db01_unidade;
            $sSubUnidade = db_utils::fieldsMemory($rsDepart, 0)->o41_subunidade;


            $sCodUnidade = str_pad($sOrgDepart, 2, "0", STR_PAD_LEFT) . str_pad($sUnidDepart, 3, "0", STR_PAD_LEFT);
            if ($sSubUnidade == 1) {
                $sCodUnidade .= str_pad($sSubUnidade, 3, "0", STR_PAD_LEFT);
            }




            if ($sTrataCodUnidade == 2) {

                $sCodUnidade = str_pad($oEmpenho->o58_orgao, 3, "0", STR_PAD_LEFT);
                $sCodUnidade .= str_pad($oEmpenho->o58_unidade, 2, "0", STR_PAD_LEFT);


            } else {

                $sCodUnidade = $oEmpenho->codunidadesub;

            }

            $sElemento = substr($oEmpenho->naturezadadespesa, 0, 8);
            /**
             * percorrer xml elemento despesa
             */
            foreach ($oElementos as $oElemento) {

                if ($oElemento->getAttribute('instituicao') == db_getsession("DB_instit")
                    && $oElemento->getAttribute('elementoEcidade') == $sElemento
                ) {

                    $sElemento = $oElemento->getAttribute('elementoSicom');
                    break;

                }

            }

            db_inicio_transacao();

            $oDadosEmpenho = new cl_emp102018();

            $oDadosEmpenho->si106_tiporegistro = $oEmpenho->tiporegistro;
            $oDadosEmpenho->si106_codorgao = $oEmpenho->codorgao;
            $oDadosEmpenho->si106_codunidadesub = $sCodUnidade;
            $oDadosEmpenho->si106_codfuncao = $oEmpenho->codfuncao;
            $oDadosEmpenho->si106_codsubfuncao = $oEmpenho->codsubfuncao;
            $oDadosEmpenho->si106_codprograma = $oEmpenho->codprograma;
            $oDadosEmpenho->si106_idacao = $oEmpenho->idacao;
            $oDadosEmpenho->si106_idsubacao = $oEmpenho->idsubacao;
            $oDadosEmpenho->si106_naturezadespesa = substr($sElemento, 0, 6);
            $oDadosEmpenho->si106_subelemento = substr($sElemento, 6, 2);
            $oDadosEmpenho->si106_nroempenho = $oEmpenho->nroempenho;
            $oDadosEmpenho->si106_dtempenho = $oEmpenho->dtempenho;
            $oDadosEmpenho->si106_modalidadeempenho = $oEmpenho->modalidadempenho;
            $oDadosEmpenho->si106_tpempenho = $oEmpenho->tpempenho;
            $oDadosEmpenho->si106_vlbruto = $oEmpenho->vlbruto;
            $oDadosEmpenho->si106_especificacaoempenho = $oEmpenho->especificaoempenho == '' ? 'SEM HISTORICO' :
                trim(preg_replace("/[^a-zA-Z0-9 ]/", "", substr(str_replace($what, $by, $oEmpenho->especificaoempenho), 0, 200)));
            $aAnoContrato = explode('-', $oEmpenho->dtassinaturacontrato);

            $oDadosEmpenho->si106_despdeccontrato = $oEmpenho->despdeccontrato;
            if($oEmpenho->despdeccontrato == 3) {
                $oDadosEmpenho->si106_codorgaorespcontrato = $sCodorgao;
            }else{
                $oDadosEmpenho->si106_codorgaorespcontrato = '';
            }

            if( in_array($oEmpenho->despdeccontrato,array(1,3)) ) {
                $oDadosEmpenho->si106_codunidadesubrespcontrato = $oEmpenho->codunidadesubrespcontrato;
            }else{
                $oDadosEmpenho->si106_codunidadesubrespcontrato = '';
            }
            $oDadosEmpenho->si106_nrocontrato = $oEmpenho->nrocontrato;
            $oDadosEmpenho->si106_dtassinaturacontrato = $oEmpenho->dataassinaturacontrato;
            $oDadosEmpenho->si106_nrosequencialtermoaditivo = $oEmpenho->nrosequencialtermoaditivo;


            $oDadosEmpenho->si106_despdecconvenio = $oEmpenho->despdecconvenio;
            $oDadosEmpenho->si106_nroconvenio = $oEmpenho->nroconvenio;
            $oDadosEmpenho->si106_dataassinaturaconvenio = $oEmpenho->dataassinaturaconvenio;
            $oDadosEmpenho->si106_despdecconvenioconge = $oEmpenho->si106_despdecconvenioconge;
            $oDadosEmpenho->si106_nroconvenioconge = $oEmpenho->si106_nroconvenioconge;
            $oDadosEmpenho->si106_dataassinaturaconvenioconge = $oEmpenho->si106_dataassinaturaconvenioconge;
            $aHomologa = explode("-", $oEmpenho->datahomologacao);
            if (($oEmpenho->datahomologacao == null && $oDadosEmpenho->exercicioprocessolicitatorio < 2014) || $aHomologa[0] < 2014) {
                $oDadosEmpenho->si106_despdeclicitacao = 1;
                $oDadosEmpenho->si106_codunidadesubresplicit = null;
                $oDadosEmpenho->si106_nroprocessolicitatorio = null;
                $oDadosEmpenho->si106_exercicioprocessolicitatorio = null;
                $oDadosEmpenho->si106_tipoprocesso = null;
            } else {
                $oDadosEmpenho->si106_despdeclicitacao = $oEmpenho->despdeclicitacao;
                $oDadosEmpenho->si106_codunidadesubresplicit = $oEmpenho->codunidadesubresplicit;
                $oDadosEmpenho->si106_nroprocessolicitatorio = $oEmpenho->nroprocessolicitatorio;
                $oDadosEmpenho->si106_exercicioprocessolicitatorio = $oEmpenho->exercicioprocessolicitatorio;
                $oDadosEmpenho->si106_tipoprocesso = $oEmpenho->tipoprocesso;
            }
            $oDadosEmpenho->si106_cpfordenador = substr($oEmpenho->ordenador, 0, 11);

            /*
             * verificar se o tipo de despesa se enquadra nos elementos necessários para informar esse campo para RPPS
             */
            $oDadosEmpenho->si106_tipodespesaemprpps = in_array(substr($sElemento, 0, 6), $aTipoDespEmpRPPS) ? ($oEmpenho->tipodespesa == '0' ? 1 : $oEmpenho->tipodespesa) : '0';

            $oDadosEmpenho->si106_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $oDadosEmpenho->si106_instit = db_getsession("DB_instit");


            $oDadosEmpenho->incluir();
            if ($oDadosEmpenho->erro_status == 0) {
                throw new Exception($oDadosEmpenho->erro_msg);
            }

            /**
             * dados registro 11
             */
            $oDadosEmpenhoFonte = new cl_emp112018();

            $oDadosEmpenhoFonte->si107_tiporegistro = 11;
            $oDadosEmpenhoFonte->si107_codunidadesub = $sCodUnidade;
            $oDadosEmpenhoFonte->si107_nroempenho = $oEmpenho->nroempenho;
            $oDadosEmpenhoFonte->si107_codfontrecursos = $oEmpenho->o15_codtri;
            $oDadosEmpenhoFonte->si107_valorfonte = $oEmpenho->vlbruto;
            $oDadosEmpenhoFonte->si107_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $oDadosEmpenhoFonte->si107_reg10 = $oDadosEmpenho->si106_sequencial;
            $oDadosEmpenhoFonte->si107_instit = db_getsession("DB_instit");

            $oDadosEmpenhoFonte->incluir(null);
            if ($oDadosEmpenhoFonte->erro_status == 0) {
                throw new Exception($oDadosEmpenhoFonte->erro_msg);
            }


            $oEmp12 = new cl_emp122018();

            $oEmp12->si108_tiporegistro = '12';
            $oEmp12->si108_codunidadesub = $sCodUnidade;
            $oEmp12->si108_nroempenho = $oEmpenho->nroempenho;;
            $oEmp12->si108_tipodocumento = $oEmpenho->tipodocumento;;
            $oEmp12->si108_nrodocumento = $oEmpenho->nrodocumento;;
            $oEmp12->si108_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $oEmp12->si108_reg10 = $oDadosEmpenho->si106_sequencial;
            $oEmp12->si108_instit = db_getsession("DB_instit");


            $oEmp12->incluir(null);
            if ($oEmp12->erro_status == 0) {
                throw new Exception($oEmp12->erro_msg);
            }


            db_fim_transacao();
        }

        $oGerarEMP = new GerarEMP();
        $oGerarEMP->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oGerarEMP->gerarDados();

    }

}
