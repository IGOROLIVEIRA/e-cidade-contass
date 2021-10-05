<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_balancete102021_classe.php");
require_once("classes/db_balancete112021_classe.php");
require_once("classes/db_balancete122021_classe.php");
require_once("classes/db_balancete132021_classe.php");
require_once("classes/db_balancete142021_classe.php");
require_once("classes/db_balancete152021_classe.php");
require_once("classes/db_balancete162021_classe.php");
require_once("classes/db_balancete172021_classe.php");
require_once("classes/db_balancete182021_classe.php");
require_once("classes/db_balancete192021_classe.php");
require_once("classes/db_balancete202021_classe.php");
require_once("classes/db_balancete212021_classe.php");
require_once("classes/db_balancete222021_classe.php");
require_once("classes/db_balancete232021_classe.php");
require_once("classes/db_balancete242021_classe.php");
require_once("classes/db_balancete252021_classe.php");
require_once("classes/db_balancete262021_classe.php");
require_once("classes/db_balancete272021_classe.php");
require_once("classes/db_balancete282021_classe.php");
require_once("classes/db_balancete292021_classe.php");
require_once("classes/db_balancete302021_classe.php");
require_once("classes/db_balancete312021_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarBALANCETE.model.php");
require_once("model/contabilidade/planoconta/ContaPlanoPCASP.model.php");

/**
 * Dados Complementares Sicom Acompanhamento Mensal
 * @author Gabriel
 * @package Contabilidade
 * @revision Rodrigo e Igor
 */

class SicomArquivoBalancete extends SicomArquivoBase implements iPadArquivoBaseCSV
{
    /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'BALANCETE';

    /**
     * @var array Fontes encerradas em 2021
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

    }

    /**
     * Busca no AM a fonte de recursos pelo reduzido.
     * @param $iReduz
     * @return mixed
     */
    public function getFontReduzAM($iReduz)
    {
        $sSqlVerifica = " select distinct si96_codfontrecursos, si96_anousu from ( SELECT distinct si96_codfontrecursos, 2021 as si96_anousu FROM ctb202021 WHERE si96_codctb = {$iReduz}
                                      AND si96_mes <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $sSqlVerifica .= " UNION SELECT distinct si96_codfontrecursos, 2021 as si96_anousu FROM ctb202121 WHERE si96_codctb = {$iReduz}) as x order by 2 DESC limit 1";
        $iCodFont = db_utils::fieldsMemory(db_query($sSqlVerifica), 0)->si96_codfontrecursos;

        return $iCodFont;

    }

    public function getCodOrgaoTce($iTipoInstit)
    {
        $sSqlorgao = "select si09_codorgaotce as codorgao from infocomplementaresinstit where si09_tipoinstit = {$iTipoInstit}";
        $iCodOrgaoTce = db_utils::fieldsMemory(db_query($sSqlorgao), 0)->codorgao;
        if ($iCodOrgaoTce == "") {
            throw new Exception("Não foi possível encontrar o código do TCE do instituição {$iTipoInstit} em " . db_getsession('DB_anousu') . " Verifique o cadastro da instituição no módulo Configurações, menu Cadastros->Instiuições.");
        }

        return $iCodOrgaoTce;
    }

    public function getCodUnidadeTce($iTipoInstit)
    {
        $sSqlunidade = "select si09_codunidadesubunidade from infocomplementaresinstit where si09_tipoinstit = {$iTipoInstit}";
        $iCodUnidadeTce = db_utils::fieldsMemory(db_query($sSqlunidade), 0)->si09_codunidadesubunidade;
        if ($iCodUnidadeTce == "") {
            throw new Exception("Não foi possível encontrar o código do TCE do instituição {$iTipoInstit} em " . db_getsession('DB_anousu') . " Verifique o cadastro da instituição no módulo Configurações, menu Cadastros->Instiuições.");
        }

        return $iCodUnidadeTce;
    }

    public function getTipoinstit($CodInstit){
        $sSqltipoistint = "select si09_tipoinstit from infocomplementaresinstit inner join db_config on codigo = si09_instit where codigo = {$CodInstit}";
        $iTipoInstit = db_utils::fieldsMemory(db_query($sSqltipoistint), 0)->si09_tipoinstit;
        if ($iTipoInstit == "") {
            throw new Exception("Não foi possível encontrar o código do TCE do instituição {$CodInstit} em " . db_getsession('DB_anousu') . " Verifique o cadastro da instituição no módulo Configurações, menu Cadastros->Instiuições.");
        }

        return $iTipoInstit;
    }

    /**
    * Busca código fundo tce mg pertecente no cadastro da instituição. Caso não seja cadastrado, retorna o valor padrão "00000000"
    */
    public function getCodFundo(){
        $sSqlCodFundo = "select si09_codfundotcemg from infocomplementaresinstit where si09_instit = " . db_getsession('DB_instit');
        $sCodFundo = db_utils::fieldsMemory(db_query($sSqlCodFundo), 0)->si09_codfundotcemg;
        if ($sCodFundo == "") {
            return "00000000";
        } else {
            return str_pad($sCodFundo, 8, '0', STR_PAD_LEFT);
        }
    }

    /**
     *  Função que busca dotacao pelo codigo do orgao e unidade no exercicio da sessao.
     *  Se não encontrar, busca o padrão.
     */
    public function getDotacaoByCodunidadesub($iOrgao, $iUnidade)
    {
        try {

            $sSql = "select *, case when o41_subunidade != 0 or not null then
                                    lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0)||lpad(o41_subunidade::integer,3,0)
                                    else lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0) end as codunidadesub
                        from orcdotacao
                        inner join orcunidade on o41_anousu = o58_anousu and o41_orgao = o58_orgao and o41_unidade = o58_unidade
                        inner join orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                 where o58_orgao = {$iOrgao}
                 and o58_unidade = {$iUnidade}
                 and o58_anousu = " . db_getsession('DB_anousu') . " and o58_instit = " . db_getsession('DB_instit') . " limit 1";

            $rsSql = db_query($sSql) or die($sSql);

            if (pg_num_rows($rsSql) > 0) {

                $sCodUnidadesub = db_utils::fieldsMemory(db_query($sSql), 0)->codunidadesub;

            } else {

                $sCodUnidadesub = db_utils::fieldsMemory(db_query("select si08_codunidadesub from infocomplementares where si08_instit = " . db_getsession('DB_instit') . " and si08_anousu = " . db_getsession('DB_anousu')), 0)->si08_codunidadesub;

                if ($sCodUnidadesub == "") {
                    throw new Exception("Não foi encontrado registro na tabela infocomplementares para a instituição " . db_getsession('DB_instit') . ", ano " . db_getsession('DB_anousu') . ". Favor realizar o cadastro pelo menu: Sicom->Cadastros->Informações Complementares.");
                }
            }

            return $sCodUnidadesub;

        } catch (Exception $e) {

            throw new Exception("Erro: " . $e->getMessage());

        }

    }

    /**
     * selecionar os dados para arquivo
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados()
    {

        /**
         * selecionar arquivo xml de acordo com o tipo da instituição
         */
        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);
        $sSql = "SELECT * FROM db_config ";
        $sSql .= "	WHERE prefeitura = 't'";

        $rsInst = db_query($sSql);
        $sCnpj = db_utils::fieldsMemory($rsInst, 0)->cgc;
        $iTipoInstit = db_utils::fieldsMemory($rsInst, 0)->si09_tipoinstit;

        /**
         * selecionar arquivo xml com dados das receitas
         */

        $sArquivo = "config/sicom/" . db_getsession("DB_anousu") . "/{$sCnpj}_sicomnaturezareceita.xml";

        $sTextoXml = file_get_contents($sArquivo);
        $oDOMDocument = new DOMDocument();
        $oDOMDocument->loadXML($sTextoXml);
        $oNaturezaReceita = $oDOMDocument->getElementsByTagName('receita');

        /*
         * Se for câmara não busca receita.
         */
        if ($iTipoInstit != 1) {

            $sArquivo = "config/sicom/" . db_getsession("DB_anousu") . "/{$sCnpj}_sicomnaturezareceita.xml";

            /*if (!file_exists($sArquivo)) {
                throw new Exception("Arquivo de natureza da receita inexistente!");
            }*/

            $sTextoXml = file_get_contents($sArquivo);
            $oDOMDocument = new DOMDocument();
            $oDOMDocument->loadXML($sTextoXml);
            $oNaturezaReceita = $oDOMDocument->getElementsByTagName('receita');

        }
        /**
         * Array com os estrutruais do orçamento modalidade aplicação.
         */
        $aContasModalidadeAplicacao = array('52211', '52212', '52213', '52219', '62211', '62212');

        /**
         * Array com os documentos de encerramento
         */
        $aDocumentos = db_utils::getColectionByRecord(db_query("select distinct c53_coddoc from conhistdoc where c53_tipo = 1000"));
        foreach ($aDocumentos as $key => $oDocumento) {
            $aDocumentosEncerramento[$key] = $oDocumento->c53_coddoc;
        }

        /**
         * selecionar arquivo xml de dados elemento da despesa
         */
        $sArquivo = "config/sicom/" . db_getsession("DB_anousu") . "/{$sCnpj}_sicomelementodespesa.xml";
        /*if (!file_exists($sArquivo)) {
            throw new Exception("Arquivo de elemento da despesa inexistente!");
        }*/
        $sTextoXml = file_get_contents($sArquivo);
        $oDOMDocument = new DOMDocument();
        $oDOMDocument->loadXML($sTextoXml);
        $oElementos = $oDOMDocument->getElementsByTagName('elemento');

        /**
         *    GERACAO DO REGISTRO 10
         *  SOMENTE CONTAS DO ATIVO E PASSIVO QUE SEJAM ANALITICAS
         *
         * Enter description here ...
         * @var unknown_type
         */

        $nMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

        /**
         * Tratamento para o encerramento do exercicio
         */

        if ($this->bEncerramento) {
            $sEncerramento = "TRUE";
            $sWhereEncerramento = "";
        } else {
            $sEncerramento = "FALSE";
            $sWhereEncerramento = " AND conhistdoc.c53_tipo not in (1000) ";
        }

        db_inicio_transacao();
        $obalancete10 = new cl_balancete102021();
        $obalancete11 = new cl_balancete112021();
        $obalancete12 = new cl_balancete122021();
        $obalancete13 = new cl_balancete132021();
        $obalancete14 = new cl_balancete142021();
        $obalancete15 = new cl_balancete152021();
        $obalancete16 = new cl_balancete162021();
        $obalancete17 = new cl_balancete172021();
        $obalancete18 = new cl_balancete182021();
        $obalancete19 = new cl_balancete192021();
        $obalancete20 = new cl_balancete202021();
        $obalancete21 = new cl_balancete212021();
        $obalancete22 = new cl_balancete222021();
        $obalancete23 = new cl_balancete232021();
        $obalancete24 = new cl_balancete242021();
        $obalancete25 = new cl_balancete252021();
        $obalancete26 = new cl_balancete262021();
        $obalancete27 = new cl_balancete272021();
        $obalancete28 = new cl_balancete282021();
        $obalancete29 = new cl_balancete292021();
        $obalancete30 = new cl_balancete302021();
        $obalancete31 = new cl_balancete312021();
        // \d balancete252021
        $obalancete31->excluir(null, "si243_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si243_instit = " . db_getsession("DB_instit"));
        $obalancete30->excluir(null, "si242_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si242_instit = " . db_getsession("DB_instit"));
        $obalancete29->excluir(null, "si241_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si241_instit = " . db_getsession("DB_instit"));
        $obalancete28->excluir(null, "si198_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si198_instit = " . db_getsession("DB_instit"));
        $obalancete27->excluir(null, "si197_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si197_instit = " . db_getsession("DB_instit"));
        $obalancete26->excluir(null, "si196_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si196_instit = " . db_getsession("DB_instit"));
        $obalancete25->excluir(null, "si195_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si195_instit = " . db_getsession("DB_instit"));
        $obalancete24->excluir(null, "si191_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si191_instit = " . db_getsession("DB_instit"));
        $obalancete23->excluir(null, "si190_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si190_instit = " . db_getsession("DB_instit"));
        $obalancete22->excluir(null, "si189_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si189_instit = " . db_getsession("DB_instit"));
        $obalancete21->excluir(null, "si188_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si188_instit = " . db_getsession("DB_instit"));
        $obalancete20->excluir(null, "si187_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si187_instit = " . db_getsession("DB_instit"));
        $obalancete19->excluir(null, "si186_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si186_instit = " . db_getsession("DB_instit"));
        $obalancete18->excluir(null, "si185_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si185_instit = " . db_getsession("DB_instit"));
        $obalancete17->excluir(null, "si184_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si184_instit = " . db_getsession("DB_instit"));
        $obalancete16->excluir(null, "si183_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si183_instit = " . db_getsession("DB_instit"));
        $obalancete15->excluir(null, "si182_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si182_instit = " . db_getsession("DB_instit"));
        $obalancete14->excluir(null, "si181_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si181_instit = " . db_getsession("DB_instit"));
        $obalancete13->excluir(null, "si180_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si180_instit = " . db_getsession("DB_instit"));
        $obalancete12->excluir(null, "si179_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si179_instit = " . db_getsession("DB_instit"));
        $obalancete11->excluir(null, "si178_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si178_instit = " . db_getsession("DB_instit"));
        $obalancete10->excluir(null, "si177_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si177_instit = " . db_getsession("DB_instit"));

        /**
         * Proibido informar as
         *  contas 2.3.7.1.1.01.00,
         *  2.3.7.1.2.01.00,
         *  2.3.7.1.3.01.00,
         *  2.3.7.1.4.01.00,
         *   2.3.7.1.5.01.00no período
         *   de fevereiro a dezembro.
         */
        $aContasProibidas = array("'237110100'", "'237120100'", "'237130100'", "'237140100'", "'237150100'");
        $sWhere10 = ($nMes != 1 ? " and substr(c60_estrut,1,9) not in (" . implode(',', $aContasProibidas) . ") " : "");
        /*
         * sql pega somente contas com movimento e/ou com saldo anterior
         */
        $sqlReg10 = "select
                    tiporegistro,
                    contacontabil,
                    coalesce(saldoinicialano,0) saldoinicialano,
                    coalesce(debito,0) debito,
                    coalesce(credito,0) credito,
                    codcon,
                    c61_reduz,
                    c60_nregobrig,
                    c60_identificadorfinanceiro,
                    case when c60_naturezasaldo = 1 then 'D' when c60_naturezasaldo = 2 then 'C' else 'C' end as c60_naturezasaldo
                         from
                            (select 10 as tiporegistro,
                                    case when c209_tceestrut is null then substr(c60_estrut,1,9) else c209_tceestrut end as contacontabil,
                                    (select sum(c69_valor) as credito from conlancamval where c69_credito = c61_reduz and DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . " and  DATE_PART('MONTH',c69_data) <= {$nMes}) as credito,
                                    (select sum(c69_valor) as debito from conlancamval where c69_debito = c61_reduz and DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . " and  DATE_PART('MONTH',c69_data) <= {$nMes}) as debito,
                                    (c62_vlrdeb - c62_vlrcre) as saldoinicialano,c61_reduz, c60_nregobrig,
                                    c60_codcon as codcon, c60_identificadorfinanceiro,c60_naturezasaldo
                              from contabilidade.conplano
						inner join conplanoreduz on c61_codcon = c60_codcon and c61_anousu = c60_anousu and c61_instit = " . db_getsession("DB_instit") . "
                        inner join conplanoexe on c62_reduz = c61_reduz and c61_anousu = c62_anousu
                        left join vinculopcasptce on substr(c60_estrut,1,9) = c209_pcaspestrut
                             where c60_anousu = " . db_getsession("DB_anousu") . " {$sWhere10}) as x
                        where debito != 0 or credito != 0 or saldoinicialano != 0 order by contacontabil";

        $rsReg10 = db_query($sqlReg10);

        /**
         * Busca código fundo tce mg pertecente no cadastro da instituição
         */
        $sCodFundo = $this->getCodFundo();

        $aDadosAgrupados10 = array();
        for ($iCont = 0; $iCont < pg_num_rows($rsReg10); $iCont++) {

            $oReg10 = db_utils::fieldsMemory($rsReg10, $iCont);

            $nSaldoInicial = $oReg10->saldoinicialano;
            $nCreditos = $oReg10->credito;
            $nDebitos = $oReg10->debito;
            /*
             * Verifica se é Janeiro. Caso não seja, o saldo inicial, debito e credito do mes de referencia é buscado pelo SQL abaixo.
             */
            if ($nMes != 1) {

                $sSqlSaldoAnt = " select sinal_anterior,sinal_final,sum(saldoinicial) saldoinicial, sum(debitos) debitos, sum(creditos) creditos from(SELECT estrut_mae,
                                           estrut,
                                           c61_reduz,
                                           c61_codcon,
                                           c61_codigo,
                                           c60_descr,
                                           c60_finali,
                                           c61_instit,
                                           round(substr(fc_planosaldonovo,3,14)::float8,2)::float8 AS saldoinicial,
                                           round(substr(fc_planosaldonovo,17,14)::float8,2)::float8 AS debitos,
                                           round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 AS creditos,
                                           round(substr(fc_planosaldonovo,45,14)::float8,2)::float8 AS saldo_final,
                                           substr(fc_planosaldonovo,59,1)::varchar(1) AS sinal_anterior,
                                           substr(fc_planosaldonovo,60,1)::varchar(1) AS sinal_final
                                    FROM
                                      (SELECT p.c60_estrut AS estrut_mae,
                                              p.c60_estrut AS estrut,
                                              c61_reduz,
                                              c61_codcon,
                                              c61_codigo,
                                              p.c60_descr,
                                              p.c60_finali,
                                              r.c61_instit,
                                              fc_planosaldonovo(" . db_getsession('DB_anousu') . ",c61_reduz,'" . $this->sDataInicial . "','" . $this->sDataFinal . "',{$sEncerramento})
                                       FROM conplanoexe e
                                       INNER JOIN conplanoreduz r ON r.c61_anousu = c62_anousu
                                       AND r.c61_reduz = c62_reduz
                                       INNER JOIN conplano p ON r.c61_codcon = c60_codcon
                                       AND r.c61_anousu = c60_anousu
                                       LEFT OUTER JOIN consistema ON c60_codsis = c52_codsis
                                       WHERE c62_anousu = " . db_getsession('DB_anousu') . "
                                         AND c61_instit IN (" . db_getsession('DB_instit') . ")
						 AND c61_codcon = {$oReg10->codcon} ) AS x) as y where saldoinicial > 0 or debitos > 0 or creditos > 0 group by 1,2";

                $rsSaldoAnt = db_query($sSqlSaldoAnt) or die(pg_last_error());

                if (pg_num_rows($rsSaldoAnt) == 0) {
                    continue;
                }

                $nSaldoInicial = db_utils::fieldsMemory($rsSaldoAnt, 0)->saldoinicial;
                $nCreditos = db_utils::fieldsMemory($rsSaldoAnt, 0)->creditos;
                $nDebitos = db_utils::fieldsMemory($rsSaldoAnt, 0)->debitos;
                $sNaturezaSaldoIni = db_utils::fieldsMemory($rsSaldoAnt, 0)->sinal_anterior;



            }

            /*
             * Cria o $sHash para agrupar as contas e realizar o somatório.
             */
            $sHash = $oReg10->contacontabil;

            /*
             * Guarda os dados agrupados no array $aDadosAgrupados10. Caso já exista, faz apenas a atualização da soma dos saldos
             */
            if (!isset($aDadosAgrupados10[$sHash])) {

                $obalancete = new stdClass();

                $obalancete->si177_tiporegistro = "10";
                $obalancete->si177_contacontaabil = $oReg10->contacontabil;
                $obalancete->si177_codfundo = $sCodFundo;

                /*
                * Zera os saldos para registro 17, pois os saldos serao buscados na tabela ctb do sicom
                * Zera o deb e cred para reg 18, pois serao manipulados pelo reg detalhe
                */
                if ($oReg10->c60_nregobrig == 17) {

                    $obalancete->si177_saldoinicial     = 0;
                    $obalancete->si177_totaldebitos     = 0;
                    $obalancete->si177_totalcreditos    = 0;
                    $obalancete->si177_saldofinal       = 0;

                } else {

                    $obalancete->si177_saldoinicial     = ($sNaturezaSaldoIni == 'C' ? $nSaldoInicial * -1 : $nSaldoInicial);
                    $obalancete->si177_totaldebitos     = $nDebitos;
                    $obalancete->si177_totalcreditos    = $nCreditos;
                    $obalancete->si177_saldofinal       = $obalancete->si177_saldoinicial + $nDebitos - $nCreditos;

                }

                $obalancete->si177_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $obalancete->si177_instit = db_getsession("DB_instit");
                $obalancete->nregobrig = $oReg10->c60_nregobrig;
                $obalancete->codcon = $oReg10->codcon;
                $obalancete->identificadorfinanceiro = $oReg10->c60_identificadorfinanceiro;
                $obalancete->naturezasaldo = $oReg10->c60_naturezasaldo;
                $obalancete->contas = array();
                $obalancete->reg11 = array();
                $obalancete->reg12 = array();
                $obalancete->reg13 = array();
                $obalancete->reg14 = array();
                $obalancete->reg15 = array();
                $obalancete->reg16 = array();
                $obalancete->reg17 = array();
                $obalancete->reg18 = array();
                $obalancete->reg19 = array();
                $obalancete->reg20 = array();
                $obalancete->reg21 = array();
                $obalancete->reg22 = array();
                $obalancete->reg23 = array();
                $obalancete->reg24 = array();
                $obalancete->reg25 = array();
                $obalancete->reg26 = array();
                $obalancete->reg27 = array();
                $obalancete->reg28 = array();
                $obalancete->reg29 = array();
                $obalancete->reg30 = array();
                $obalancete->reg31 = array();
                $obalancete->contas[] = $oReg10->c61_reduz;
                $aDadosAgrupados10[$sHash] = $obalancete;

            } else {
                $obalancete->contas[] = $oReg10->c61_reduz;

                if ($oReg10->c60_nregobrig != 17) {

                    $aDadosAgrupados10[$sHash]->si177_saldoinicial += ($sNaturezaSaldoIni == 'C' ? $nSaldoInicial * -1 : $nSaldoInicial);
                    $aDadosAgrupados10[$sHash]->si177_totaldebitos += $nDebitos;
                    $aDadosAgrupados10[$sHash]->si177_totalcreditos += $nCreditos;
                    $aDadosAgrupados10[$sHash]->si177_saldofinal += ($sNaturezaSaldoIni == 'C' ? $nSaldoInicial * -1 : $nSaldoInicial) + $nDebitos - $nCreditos;

                }
            }

        }


        $aContasReg10 = array();

        foreach ($aDadosAgrupados10 as $reg10Hash => $oContas10) {

            /*
             * DADOS PARA GERAÇÃO DO REGISTRO 11 CELULA DA DESPESA,
             * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 11
             */

            $aContasReg10[$reg10Hash] = $oContas10;

            if ($oContas10->nregobrig == 11 || $oContas10->nregobrig == 30) {

                //Natureza de despesa que precisam informar campo Tipo de Despesa (Reg30)
                $aNaturDespTipoDespesa = "'319001', '319003', '319091', '319092', '319094', '319191', '319192', '319194'";

                /*
                 * SQL PARA PEGA AS DOTACOES QUE DIVERAM MOVIMENTACAO NO MES
                 */

                if (substr($oContas10->si177_contacontaabil, 0, 5) != '62213') {
                    $sSqlDotacoes = "select distinct o58_coddot as c73_coddot,
                                    si09_codorgaotce as codorgao,
                                    case when o41_subunidade != 0 or not null then
                                    lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0)||lpad(o41_subunidade::integer,3,0)
                                    else lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0) end as codunidadesub,
					                o58_funcao as codfuncao,
					                o58_subfuncao as codsubfuncao,
					                o58_programa as codprograma,
					                o58_projativ as idacao,
					                o55_origemacao as idsubacao,
					                substr(o56_elemento,2,12) as naturezadadespesa,
					                '00' as subelemento,
					                o15_codtri as codfontrecursos, si08_orcmodalidadeaplic,
                                    case
                                        when si09_tipoinstit IN (5,6)
                                            and substr(o56_elemento,2,6) in ({$aNaturDespTipoDespesa})
                                            and $oContas10->nregobrig = 30 then e60_tipodespesa
                	                    else 0
                                    end as e60_tipodespesa
					  from orcdotacao
					  join orcunidade on o41_anousu = o58_anousu and o41_orgao = o58_orgao and o41_unidade = o58_unidade
					  join orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
					  join orcelemento ON o56_codele = o58_codele and o58_anousu = o56_anousu
					  JOIN orcprojativ on o58_anousu = o55_anousu and o58_projativ = o55_projativ
					  JOIN orctiporec ON o58_codigo = o15_codigo
					  inner join infocomplementaresinstit on  o58_instit = si09_instit
					  inner join infocomplementares on si09_instit = si08_instit
                      left join empempenho on o58_coddot = e60_coddot and o58_anousu = e60_anousu
					  where o58_instit = " . db_getsession('DB_instit') . " and o58_anousu = " . db_getsession("DB_anousu");
                    $nContaCorrente = 101;

                } else {
                    if (substr($oContas10->si177_contacontaabil, 0, 5) == '62213') {

                        $sSqlDotacoes = "select distinct o58_coddot as c73_coddot,
                                    si09_codorgaotce as codorgao,
                                    case when o41_subunidade != 0 or not null then
                                    lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0)||lpad(o41_subunidade::integer,3,0)
                                    else lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0) end as codunidadesub,
					                o58_funcao as codfuncao,
					                o58_subfuncao as codsubfuncao,
					                o58_programa as codprograma,
					                o58_projativ as idacao,
					                o55_origemacao as idsubacao,
					                substr(o56_elemento,2,12) as naturezadadespesa,
					                substr(o56_elemento,8,2) as subelemento,
								    o15_codtri as codfontrecursos,
								    e60_numemp,
                                    case
                                        when si09_tipoinstit IN (5,6)
                                            and substr(o56_elemento,2,6) in ({$aNaturDespTipoDespesa})
                                            and $oContas10->nregobrig = 30 then e60_tipodespesa
                	                    else 0
                                    end as e60_tipodespesa
					  from conlancamval
					  inner join contacorrentedetalheconlancamval on c69_sequen = c28_conlancamval
					  inner join contacorrentedetalhe on c19_sequencial = c28_contacorrentedetalhe
					  inner join empempenho on c19_numemp = e60_numemp
					  join empelemento on e64_numemp = e60_numemp
					  join orcdotacao on e60_coddot = o58_coddot and e60_anousu = o58_anousu
					  join orcunidade on o41_anousu = o58_anousu and o41_orgao = o58_orgao and o41_unidade = o58_unidade
					  join orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
					  join orcelemento ON o56_codele = e64_codele and e60_anousu = o56_anousu
					  JOIN orcprojativ on o58_anousu = o55_anousu and o58_projativ = o55_projativ
					  JOIN orctiporec ON o58_codigo = o15_codigo
					  left join infocomplementaresinstit on  o58_instit = si09_instit
					  where o58_instit = " . db_getsession('DB_instit') . " and DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . " and DATE_PART('MONTH',c69_data) <= {$nMes}
					  and (c69_credito in (" . implode(',', $oContas10->contas) . ") or c69_debito in (" . implode(',', $oContas10->contas) . "))";
                        //where DATE_PART('YEAR',c73_data) = " . db_getsession("DB_anousu") . " and DATE_PART('MONTH',c73_data) <= {$nMes} and substr(o56_elemento,2,6) = '319011' and o15_codtri = '100' and o58_projativ = 2007 and substr(o56_elemento,8,2) = '05'";

                        $nContaCorrente = 102;

                    } else {

                        $sSqlDotacoes = "select distinct c73_coddot,
                                    si09_codorgaotce as codorgao,
                                    case when o41_subunidade != 0 or not null then
                                    lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0)||lpad(o41_subunidade::integer,3,0)
                                    else lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0) end as codunidadesub,
					                o58_funcao as codfuncao,
					                o58_subfuncao as codsubfuncao,
					                o58_programa as codprograma,
					                o58_projativ as idacao,
					                o55_origemacao as idsubacao,
					                substr(o56_elemento,2,12) as naturezadadespesa,
                                    substr(o56_elemento,8,2) as subelemento,
								    o15_codtri as codfontrecursos,
					                e60_numemp,
                                    case
                                        when si09_tipoinstit IN (5,6)
                                            and substr(o56_elemento,2,6) in ({$aNaturDespTipoDespesa})
                                            and $oContas10->nregobrig = 30 then e60_tipodespesa
                	                    else 0
                                    end as e60_tipodespesa
					  from conlancamemp
					  join conlancamdot on c75_codlan = c73_codlan
					  join orcdotacao on c73_anousu = o58_anousu and o58_coddot = c73_coddot
					  join orcunidade on o41_anousu = o58_anousu and o41_orgao = o58_orgao and o41_unidade = o58_unidade
					  join orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
					  join empempenho on e60_numemp = c75_numemp join empelemento on e64_numemp = e60_numemp
					  join orcelemento ON o56_codele = e64_codele and e60_anousu = o56_anousu
					  join conlancamval on c69_codlan = c73_codlan and  (c69_credito in (" . implode(',', $oContas10->contas) . ") or c69_debito in (" . implode(',', $oContas10->contas) . "))
					  JOIN orcprojativ on o58_anousu = o55_anousu and o58_projativ = o55_projativ
					  JOIN orctiporec ON o58_codigo = o15_codigo
					  left join infocomplementaresinstit on  o58_instit = si09_instit
					  where o58_instit = " . db_getsession('DB_instit') . " and DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . " and DATE_PART('MONTH',c69_data) <= {$nMes}";
                        //where DATE_PART('YEAR',c73_data) = " . db_getsession("DB_anousu") . " and DATE_PART('MONTH',c73_data) <= {$nMes} and substr(o56_elemento,2,6) = '319011' and o15_codtri = '100' and o58_projativ = 2007 and substr(o56_elemento,8,2) = '05'";

                        $nContaCorrente = 102;

                    }
                }

                $rsDotacoes = db_query($sSqlDotacoes) or die(pg_last_error());

                for ($iCont11 = 0; $iCont11 < pg_num_rows($rsDotacoes); $iCont11++) {

                    $oReg11 = db_utils::fieldsMemory($rsDotacoes, $iCont11);

                    /*
                     * Contabilidade->procedimentos->Utilitarios->Implantação de Saldo.
                     */
                    $sWhere = "";
                    if ($nContaCorrente == 102) {

                        $sWhere = " and c19_numemp = {$oReg11->e60_numemp}";
                    }
                    $sSqlReg11saldos = " SELECT
                                          (SELECT case when round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) = '0.00' then null else round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) end AS saldoinicial
                                           FROM
                                             (SELECT
                                                (SELECT CASE WHEN c29_debito > 0 THEN c29_debito WHEN c29_credito > 0 THEN -1 * c29_credito ELSE 0 END AS saldoanterior
                                                 FROM contacorrente
                                                 INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                                 INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial
                                                 AND contacorrentesaldo.c29_mesusu = 0 and contacorrentesaldo.c29_anousu = " . db_getsession("DB_anousu") . " and c19_conplanoreduzanousu = " . db_getsession("DB_anousu") . "
                                                 WHERE c19_reduz IN (" . implode(',', $oContas10->contas) . ") " . $sWhere . "
                                                   AND c17_sequencial = {$nContaCorrente}
                                                   AND c19_orcdotacao = {$oReg11->c73_coddot}) AS saldoimplantado,

                                                (SELECT sum(c69_valor) AS debito
                                                 FROM conlancamval
                                                   INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                                   AND conlancam.c70_anousu = conlancamval.c69_anousu
                                                   INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                                   INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                                   INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                                   INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                                   WHERE c28_tipo = 'D'
                                                     AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                                                     AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                                     AND c19_contacorrente = {$nContaCorrente}
                                                     AND c19_reduz IN (" . implode(',', $oContas10->contas) . ") " . $sWhere . "
                                                     AND c19_instit = " . db_getsession("DB_instit") . "
                                                     AND c19_orcdotacao = {$oReg11->c73_coddot}
                                                     {$sWhereEncerramento}
                                                   GROUP BY c28_tipo) AS debitoatual,

                                                (SELECT sum(c69_valor) AS credito
                                                 FROM conlancamval
                                                   INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                                   AND conlancam.c70_anousu = conlancamval.c69_anousu
                                                   INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                                   INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                                   INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                                   INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                                   WHERE c28_tipo = 'C'
                                                     AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                                                     AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                                     AND c19_contacorrente = {$nContaCorrente}
                                                     AND c19_reduz IN (" . implode(',', $oContas10->contas) . ") " . $sWhere . "
                                                     AND c19_instit = " . db_getsession("DB_instit") . "
                                                     AND c19_orcdotacao = {$oReg11->c73_coddot}
                                                     {$sWhereEncerramento}
                                                   GROUP BY c28_tipo) AS creditoatual) AS movi) AS saldoanterior,

                                          (SELECT sum(c69_valor)
                                           FROM conlancamval
                                           INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                           AND conlancam.c70_anousu = conlancamval.c69_anousu
                                           INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                           INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                           INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                           INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                           WHERE c28_tipo = 'C'
                                             AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                             AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                             AND c19_contacorrente = {$nContaCorrente}
                                             AND c19_reduz IN (" . implode(',', $oContas10->contas) . ") " . $sWhere . "
                                             AND c19_instit = " . db_getsession("DB_instit") . "
                                             AND c19_orcdotacao = {$oReg11->c73_coddot}
                                             {$sWhereEncerramento}
                                           GROUP BY c28_tipo) AS creditos,

                                          (SELECT sum(c69_valor)
                                           FROM conlancamval
                                           INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                           AND conlancam.c70_anousu = conlancamval.c69_anousu
                                           INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                           INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                           INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                           INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                           WHERE c28_tipo = 'D'
                                             AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                             AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                             AND c19_contacorrente = {$nContaCorrente}
                                             AND c19_reduz IN (" . implode(',', $oContas10->contas) . ") " . $sWhere . "
                                             AND c19_instit = " . db_getsession("DB_instit") . "
                                             AND c19_orcdotacao = {$oReg11->c73_coddot}
                                             {$sWhereEncerramento}
                                           GROUP BY c28_tipo) AS debitos";

                    $rsReg11saldos = db_query($sSqlReg11saldos) or die($sSqlReg11saldos);

                    for ($iContSaldo = 0; $iContSaldo < pg_num_rows($rsReg11saldos); $iContSaldo++) {

                        $oReg11Saldo = db_utils::fieldsMemory($rsReg11saldos, $iContSaldo);

                        if (!(($oReg11Saldo->saldoanterior == "" || $oReg11Saldo->saldoanterior == 0) && $oReg11Saldo->debitos == "" && $oReg11Saldo->creditos == "")) {

                            $sElemento = substr($oReg11->naturezadadespesa, 0, 6);
                            $sSubElemento = $oReg11->subelemento;


                            if ($oContas10->nregobrig == 11) {

                                /**
                                 * percorrer xml elemento despesa
                                 */
                                if($this->iDeParaNatureza == 1) {
                                    foreach ($oElementos as $oElemento) {

                                        $sElementoXml = $oElemento->getAttribute('elementoEcidade');

                                        if (substr($sElementoXml, 0, 6) == $sElemento) {
                                            $sElemento = substr($oElemento->getAttribute('elementoSicom'), 0, 6);
                                        }

                                    }
                                }
                                /**
                                 * Verifica se a contacontabil faz parte do Orçamento por modalidade de aplicação e trata o elemento.
                                 */
                                if (in_array(substr($oContas10->si177_contacontaabil, 0, 5), $aContasModalidadeAplicacao)) {

                                    if ($oReg11->si08_orcmodalidadeaplic == 1) {
                                        $sElemento = substr($sElemento, 0, 4) . "00";
                                    }
                                }

                                $sHash11 = '11' . $oContas10->si177_contacontaabil . $oReg11->codorgao . $oReg11->codunidadesub . $oReg11->codfuncao . $oReg11->codsubfuncao . $oReg11->codprograma;
                                $sHash11 .= $oReg11->idacao . $oReg11->idsubacao . $sElemento . $oReg11->codfontrecursos;

                                if (!isset($aContasReg10[$reg10Hash]->reg11[$sHash11])) {

                                    $obalancete11 = new stdClass();

                                    $obalancete11->si178_tiporegistro = 11;
                                    $obalancete11->si178_contacontaabil = $oContas10->si177_contacontaabil;
                                    $obalancete11->si178_codfundo = $sCodFundo;
                                    $obalancete11->si178_codorgao = $oReg11->codorgao;
                                    $obalancete11->si178_codunidadesub = $oReg11->codunidadesub;
                                    $obalancete11->si178_codfuncao = $oReg11->codfuncao;
                                    $obalancete11->si178_codsubfuncao = $oReg11->codsubfuncao;
                                    $obalancete11->si178_codprograma = $oReg11->codprograma;
                                    $obalancete11->si178_idacao = $oReg11->idacao;
                                    $obalancete11->si178_idsubacao = $oReg11->idsubacao;
                                    $obalancete11->si178_naturezadespesa = $sElemento;
                                    $obalancete11->si178_codfontrecursos = $oReg11->codfontrecursos;
                                    $obalancete11->si178_saldoinicialcd = $oReg11Saldo->saldoanterior;
                                    $obalancete11->si178_naturezasaldoinicialcd = $oReg11Saldo->saldoanterior > 0 ? 'D' : 'C';
                                    $obalancete11->si178_totaldebitoscd = $oReg11Saldo->debitos;
                                    $obalancete11->si178_totalcreditoscd = $oReg11Saldo->creditos;
                                    $obalancete11->si178_saldofinalcd = ($oReg11Saldo->saldoanterior + $oReg11Saldo->debitos - $oReg11Saldo->creditos) == '' ? 0 : ($oReg11Saldo->saldoanterior + $oReg11Saldo->debitos - $oReg11Saldo->creditos);
                                    $obalancete11->si178_naturezasaldofinalcd = ($oReg11Saldo->saldoanterior + $oReg11Saldo->debitos - $oReg11Saldo->creditos) >= 0 ? 'D' : 'C';
                                    $obalancete11->si178_instit = db_getsession("DB_instit");
                                    $obalancete11->si178_mes = $nMes;

                                    $aContasReg10[$reg10Hash] = $oContas10;
                                    $aContasReg10[$reg10Hash]->reg11[$sHash11] = $obalancete11;



                                } else {
                                    $aContasReg10[$reg10Hash]->reg11[$sHash11]->si178_saldoinicialcd += $oReg11Saldo->saldoanterior;
                                    $aContasReg10[$reg10Hash]->reg11[$sHash11]->si178_totaldebitoscd += $oReg11Saldo->debitos;
                                    $aContasReg10[$reg10Hash]->reg11[$sHash11]->si178_totalcreditoscd += $oReg11Saldo->creditos;
                                    $aContasReg10[$reg10Hash]->reg11[$sHash11]->si178_saldofinalcd += ($oReg11Saldo->saldoanterior + $oReg11Saldo->debitos - $oReg11Saldo->creditos) == '' ? 0 : ($oReg11Saldo->saldoanterior + $oReg11Saldo->debitos - $oReg11Saldo->creditos);
                                    $aContasReg10[$reg10Hash]->reg11[$sHash11]->si178_naturezasaldofinalcd = $aContasReg10[$reg10Hash]->reg11[$sHash11]->si178_saldofinalcd >= 0 ? 'D' : 'C';
                                    $aContasReg10[$reg10Hash]->reg11[$sHash11]->si178_naturezasaldoinicialcd = $aContasReg10[$reg10Hash]->reg11[$sHash11]->si178_saldoinicialcd >= 0 ? 'D' : 'C';

                                }

                            } else {

                                /**
                                 * percorrer xml elemento despesa
                                 */
                                if($this->iDeParaNatureza == 1) {

                                    foreach ($oElementos as $oElemento) {

                                        $sElementoXml = $oElemento->getAttribute('elementoEcidade');
                                        $iElementoXmlDesdobramento = $oElemento->getAttribute('deParaDesdobramento');

                                        if ($nContaCorrente == 101) {
                                            if (substr($sElementoXml, 0, 6) == $sElemento) {
                                                $sElemento = substr($oElemento->getAttribute('elementoSicom'), 0, 6);
                                                $sSubElemento = '00';
                                            }
                                        } else {
                                            if ($iElementoXmlDesdobramento != '' && $iElementoXmlDesdobramento == 1) {
                                                if($sElementoXml == $oReg11->naturezadadespesa) {
                                                    $sElemento = substr($oElemento->getAttribute('elementoSicom'), 0, 6);
                                                    $sSubElemento = substr($oElemento->getAttribute('elementoSicom'), 6, 2);
                                                }
                                            } elseif ($sElementoXml == $sElemento . $sSubElemento) {
                                                $sElemento = substr($oElemento->getAttribute('elementoSicom'), 0, 6);
                                                $sSubElemento = substr($oElemento->getAttribute('elementoSicom'), 6, 2);
                                            }

                                        }

                                    }

                                }

                                /**
                                 * Verifica se a contacontabil faz parte do Orçamento por modalidade de aplicação e trata o elemento.
                                 */
                                if (in_array(substr($oContas10->si177_contacontaabil, 0, 5), $aContasModalidadeAplicacao)) {

                                    if ($oReg11->si08_orcmodalidadeaplic == 1) {
                                        $sElemento = substr($sElemento, 0, 4) . "00";
                                    }
                                }

                                $sHash30 = '30' . $oContas10->si177_contacontaabil . $oReg11->codorgao . $oReg11->codunidadesub . $oReg11->codfuncao . $oReg11->codsubfuncao . $oReg11->codprograma;
                                $sHash30 .= $oReg11->idacao . $oReg11->idsubacao . $sElemento . $sSubElemento . $oReg11->codfontrecursos;

                                if (!isset($aContasReg10[$reg10Hash]->reg30[$sHash30])) {

                                    $obalancete30 = new stdClass();

                                    $obalancete30->si242_tiporegistro = 30;
                                    $obalancete30->si242_contacontaabil = $oContas10->si177_contacontaabil;
                                    $obalancete30->si242_codfundo = $sCodFundo;
                                    $obalancete30->si242_codorgao = $oReg11->codorgao;
                                    $obalancete30->si242_codunidadesub = $oReg11->codunidadesub;
                                    $obalancete30->si242_codfuncao = $oReg11->codfuncao;
                                    $obalancete30->si242_codsubfuncao = $oReg11->codsubfuncao;
                                    $obalancete30->si242_codprograma = $oReg11->codprograma;
                                    $obalancete30->si242_idacao = $oReg11->idacao;
                                    $obalancete30->si242_idsubacao = $oReg11->idsubacao;
                                    $obalancete30->si242_naturezadespesa = $sElemento;
                                    $obalancete30->si242_subelemento = $sSubElemento;
                                    $obalancete30->si242_codfontrecursos = $oReg11->codfontrecursos;
                                    $obalancete30->si242_tipodespesarpps = $oReg11->e60_tipodespesa;
                                    $obalancete30->si242_saldoinicialcde = $oReg11Saldo->saldoanterior;
                                    $obalancete30->si242_naturezasaldoinicialcde = $oReg11Saldo->saldoanterior > 0 ? 'D' : 'C';
                                    $obalancete30->si242_totaldebitoscde = $oReg11Saldo->debitos;
                                    $obalancete30->si242_totalcreditoscde = $oReg11Saldo->creditos;
                                    $obalancete30->si242_saldofinalcde = ($oReg11Saldo->saldoanterior + $oReg11Saldo->debitos - $oReg11Saldo->creditos) == '' ? 0 : ($oReg11Saldo->saldoanterior + $oReg11Saldo->debitos - $oReg11Saldo->creditos);
                                    $obalancete30->si242_naturezasaldofinalcde = ($oReg11Saldo->saldoanterior + $oReg11Saldo->debitos - $oReg11Saldo->creditos) >= 0 ? 'D' : 'C';
                                    $obalancete30->si242_instit = db_getsession("DB_instit");
                                    $obalancete30->si242_mes = $nMes;

                                    $aContasReg10[$reg10Hash] = $oContas10;
                                    $aContasReg10[$reg10Hash]->reg30[$sHash30] = $obalancete30;

                                } else {

                                    $aContasReg10[$reg10Hash]->reg30[$sHash30]->si242_saldoinicialcde += $oReg11Saldo->saldoanterior;
                                    $aContasReg10[$reg10Hash]->reg30[$sHash30]->si242_totaldebitoscde += $oReg11Saldo->debitos;
                                    $aContasReg10[$reg10Hash]->reg30[$sHash30]->si242_totalcreditoscde += $oReg11Saldo->creditos;
                                    $aContasReg10[$reg10Hash]->reg30[$sHash30]->si242_saldofinalcde += ($oReg11Saldo->saldoanterior + $oReg11Saldo->debitos - $oReg11Saldo->creditos) == '' ? 0 : ($oReg11Saldo->saldoanterior + $oReg11Saldo->debitos - $oReg11Saldo->creditos);
                                    $aContasReg10[$reg10Hash]->reg30[$sHash30]->si242_naturezasaldofinalcde = $aContasReg10[$reg10Hash]->reg30[$sHash30]->si242_saldofinalcde >= 0 ? 'D' : 'C';
                                    $aContasReg10[$reg10Hash]->reg30[$sHash30]->si242_naturezasaldoinicialcde = $aContasReg10[$reg10Hash]->reg11[$sHash30]->si242_saldoinicialcde >= 0 ? 'D' : 'C';

                                }
                            }
                        }
                    }
                }
            }
            //fim 11
            /*
             * DADOS PARA GERAÇÃO DO REGISTRO 12 CELULA DA RECEITA,
             * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 12
             */

            if ($oContas10->nregobrig == 12 || $oContas10->nregobrig == 23 || $oContas10->nregobrig == 31) {
                /*
                 * Buscar o vinculo da conta pcasp com o plano orçamentário
                 *
                 */

                if ($oContas10->nregobrig == 31) {
                    $sSqlVinculoContaOrcamento = "
                                                select DISTINCT conplanoorcamento.c60_codcon,
                                                            conplanoorcamento.c60_descr,
                                                            conplanoorcamento.c60_estrut,
                                                            o15_codtri,
                                                            case when c19_emparlamentar is not null then c19_emparlamentar else 3 end as c19_emparlamentar
                                                FROM conplanoorcamento
                                                INNER JOIN conplanoorcamentoanalitica ON c61_codcon = conplanoorcamento.c60_codcon AND c61_anousu = conplanoorcamento.c60_anousu
                                                INNER JOIN orctiporec ON conplanoorcamentoanalitica.c61_codigo = orctiporec.o15_codigo
                                                LEFT JOIN contacorrentedetalhe ON c61_reduz = c19_reduz AND c61_anousu = c19_conplanoreduzanousu
                                                WHERE  substr(conplanoorcamento.c60_estrut,1,1) in ('3','4') and conplanoorcamentoanalitica.c61_instit = " . db_getsession('DB_instit') . "
                                                AND conplanoorcamentoanalitica.c61_anousu = " . db_getsession("DB_anousu");
                } else {

                    $sSqlVinculoContaOrcamento = "
                                                select DISTINCT conplanoorcamento.c60_codcon,
                                                            conplanoorcamento.c60_descr,
                                                            conplanoorcamento.c60_estrut, o15_codtri
                                                FROM conplanoorcamento
                                                INNER JOIN conplanoorcamentoanalitica ON c61_codcon = conplanoorcamento.c60_codcon AND c61_anousu = conplanoorcamento.c60_anousu
                                                INNER JOIN orctiporec ON conplanoorcamentoanalitica.c61_codigo = orctiporec.o15_codigo
                                                WHERE  substr(conplanoorcamento.c60_estrut,1,1) in ('3','4') and conplanoorcamentoanalitica.c61_instit = " . db_getsession('DB_instit') . "
                                                AND conplanoorcamentoanalitica.c61_anousu = " . db_getsession("DB_anousu");
                }

                $rsVinculoContaOrcamento = db_query($sSqlVinculoContaOrcamento) or die($sSqlVinculoContaOrcamento);

                //Constante da contacorrente orçamentária
                $nContaCorrente = 100;

                for ($iContVinculo = 0; $iContVinculo < pg_num_rows($rsVinculoContaOrcamento); $iContVinculo++) {

                    $objContas = db_utils::fieldsMemory($rsVinculoContaOrcamento, $iContVinculo);

                    //Verifica os saldos de cada estrutural do orçamento vinculado ao PCASP
                    $sSqlReg12saldos = " SELECT
                                          (SELECT case when round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) = '0.00' then null else round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) end AS saldoinicial
                                           FROM
                                             (SELECT
                                                (SELECT CASE WHEN c29_debito > 0 THEN c29_debito WHEN c29_credito > 0 THEN -1 * c29_credito ELSE 0 END AS saldoanterior
                                                 FROM contacorrente
                                                 INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                                 INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial
                                                 AND contacorrentesaldo.c29_mesusu = 0 and contacorrentesaldo.c29_anousu = " . db_getsession("DB_anousu") . " and c19_conplanoreduzanousu = " . db_getsession("DB_anousu") . "
                                                 WHERE c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                                   AND c17_sequencial = {$nContaCorrente}
                                                   AND c19_estrutural = '{$objContas->c60_estrut}') AS saldoimplantado,

                                                (SELECT sum(c69_valor) AS debito
                                                 FROM conlancamval
                                                   INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                                   AND conlancam.c70_anousu = conlancamval.c69_anousu
                                                   INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                                   INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                                   INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                                   INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                                   WHERE c28_tipo = 'D'
                                                     AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                                                     AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                                     AND c19_contacorrente = {$nContaCorrente}
                                                     AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                                     AND c19_estrutural = '{$objContas->c60_estrut}'
                                                     {$sWhereEncerramento}
                                                   GROUP BY c28_tipo) AS debitoatual,

                                                (SELECT sum(c69_valor) AS credito
                                                 FROM conlancamval
                                                   INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                                   AND conlancam.c70_anousu = conlancamval.c69_anousu
                                                   INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                                   INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                                   INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                                   INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                                   WHERE c28_tipo = 'C'
                                                     AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                                                     AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                                     AND c19_contacorrente = {$nContaCorrente}
                                                     AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                                     AND c19_estrutural = '{$objContas->c60_estrut}'
                                                     {$sWhereEncerramento}
                                                   GROUP BY c28_tipo) AS creditoatual) AS movi) AS saldoanterior,

                                          (SELECT sum(c69_valor)
                                           FROM conlancamval
                                           INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                           AND conlancam.c70_anousu = conlancamval.c69_anousu
                                           INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                           INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                           INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                           INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                           WHERE c28_tipo = 'C'
                                             AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                             AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                             AND c19_contacorrente = {$nContaCorrente}
                                             AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                             AND c19_estrutural = '{$objContas->c60_estrut}'
                                             {$sWhereEncerramento}
                                           GROUP BY c28_tipo) AS creditos,

                                          (SELECT sum(c69_valor)
                                           FROM conlancamval
                                           INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                           AND conlancam.c70_anousu = conlancamval.c69_anousu
                                           INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                           INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                           INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                           INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                           WHERE c28_tipo = 'D'
                                             AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                             AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                             AND c19_contacorrente = {$nContaCorrente}
                                             AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                             AND c19_estrutural = '{$objContas->c60_estrut}'
                                             {$sWhereEncerramento}
                                           GROUP BY c28_tipo) AS debitos";

                    $rsReg12saldos = db_query($sSqlReg12saldos) or die($sSqlReg12saldos);

                    for ($iContSaldo12 = 0; $iContSaldo12 < pg_num_rows($rsReg12saldos); $iContSaldo12++) {

                        $oReg12Saldo = db_utils::fieldsMemory($rsReg12saldos, $iContSaldo12);

                        if (!(($oReg12Saldo->saldoanterior == "" || $oReg12Saldo->saldoanterior == 0) && $oReg12Saldo->debitos == "" && $oReg12Saldo->creditos == "")) {

                            /* RECEITAS QUE DEVEM SER SUBSTIUIDAS RUBRICA CADASTRADA ERRADA */
                            $aRectce = array('111202', '111208', '172136', '191138', '191139', '191140', '191308', '191311', '191312', '191313', '193104', '193111', '193112', '193113', '172401', '247199', '247299');

                            $sNaturezaReceita = substr($objContas->c60_estrut, 1, 8);

                            if (substr($objContas->c60_estrut, 1, 8) == $sNaturezaReceita) {

                                if (in_array(substr($objContas->c60_estrut, 1, 6), $aRectce)) {
                                    $sNaturezaReceita = substr($objContas->c60_estrut, 1, 6) . "00";
                                } else {
                                    if (substr($objContas->c60_estrut, 0, 2) == '49') {
                                        $sNaturezaReceita = substr($objContas->c60_estrut, 3, 8);
                                    } else {
                                        $sNaturezaReceita = substr($objContas->c60_estrut, 1, 8);

                                    }
                                }
                            }

                            if ($oContas10->nregobrig == 12) {

                                foreach ($oNaturezaReceita as $oNatureza) {

                                    if ($oNatureza->getAttribute('instituicao') == db_getsession("DB_instit")
                                        && $oNatureza->getAttribute('receitaEcidade') == $sNaturezaReceita
                                    ) {
                                        $sNaturezaReceita = $oNatureza->getAttribute('receitaSicom');
                                        break;
                                    }
                                }

                                $sHash12 = '12' . $oContas10->si177_contacontaabil . $sNaturezaReceita . $objContas->o15_codtri;

                                if (!isset($aContasReg10[$reg10Hash]->reg12[$sHash12])) {

                                    $obalancete12 = new stdClass();
                                    $obalancete12->si179_tiporegistro = 12;
                                    $obalancete12->si179_contacontabil = $oContas10->si177_contacontaabil;
                                    $obalancete12->si179_codfundo = $sCodFundo;
                                    $obalancete12->si179_naturezareceita = str_replace(" ", "", $sNaturezaReceita);
                                    $obalancete12->si179_codfontrecursos = $objContas->o15_codtri;
                                    $obalancete12->si179_saldoinicialcr = $oReg12Saldo->saldoanterior;
                                    $obalancete12->si179_naturezasaldoinicialcr = $oReg12Saldo->saldoanterior >= 0 ? 'D' : 'C';
                                    $obalancete12->si179_totaldebitoscr = $oReg12Saldo->debitos;
                                    $obalancete12->si179_totalcreditoscr = $oReg12Saldo->creditos;
                                    $obalancete12->si179_saldofinalcr = ($oReg12Saldo->saldoanterior + $oReg12Saldo->debitos - $oReg12Saldo->creditos) == '' ? 0 : ($oReg12Saldo->saldoanterior + $oReg12Saldo->debitos - $oReg12Saldo->creditos);
                                    $obalancete12->si179_naturezasaldofinalcr = ($oReg12Saldo->saldoanterior + $oReg12Saldo->debitos - $oReg12Saldo->creditos) >= 0 ? 'D' : 'C';
                                    $obalancete12->si179_instit = db_getsession("DB_instit");
                                    $obalancete12->si179_mes = $nMes;

                                    $aContasReg10[$reg10Hash]->reg12[$sHash12] = $obalancete12;
                                } else {
                                    $aContasReg10[$reg10Hash]->reg12[$sHash12]->si179_saldoinicialcr += $oReg12Saldo->saldoanterior;
                                    $aContasReg10[$reg10Hash]->reg12[$sHash12]->si179_totaldebitoscr += $oReg12Saldo->debitos;
                                    $aContasReg10[$reg10Hash]->reg12[$sHash12]->si179_totalcreditoscr += $oReg12Saldo->creditos;
                                    $aContasReg10[$reg10Hash]->reg12[$sHash12]->si179_saldofinalcr += ($oReg12Saldo->saldoanterior + $oReg12Saldo->debitos - $oReg12Saldo->creditos) == '' ? 0 : ($oReg12Saldo->saldoanterior + $oReg12Saldo->debitos - $oReg12Saldo->creditos);
                                    $aContasReg10[$reg10Hash]->reg12[$sHash12]->si179_naturezasaldofinalcr = $aContasReg10[$reg10Hash]->reg12[$sHash12]->si179_saldofinalcr >= 0 ? 'D' : 'C';
                                    $aContasReg10[$reg10Hash]->reg12[$sHash12]->si179_naturezasaldoinicialcr = $aContasReg10[$reg10Hash]->reg12[$sHash12]->si179_saldoinicialcr >= 0 ? 'D' : 'C';
                                }

                            } elseif ($oContas10->nregobrig == 23) {

                                /*
                                 * DADOS PARA GERAÇÃO DO REGISTRO 23 Natureza da Receita
                                 * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 23
                                 */

                                $sHash23 = '23' . $oContas10->si177_contacontaabil . $sNaturezaReceita;

                                if (!isset($aContasReg10[$reg10Hash]->reg23[$sHash23])) {

                                    $obalancete23 = new stdClass();

                                    $obalancete23->si190_tiporegistro = 23;
                                    $obalancete23->si190_contacontabil = $oContas10->si177_contacontaabil;
                                    $obalancete23->si190_codfundo = $sCodFundo;
                                    $obalancete23->si190_naturezareceita = $sNaturezaReceita;
                                    $obalancete23->si190_saldoinicialnatreceita = $oReg12Saldo->saldoanterior;
                                    $obalancete23->si190_naturezasaldoinicialnatreceita = $oReg12Saldo->saldoanterior >= 0 ? 'D' : 'C';
                                    $obalancete23->si190_totaldebitosnatreceita = $oReg12Saldo->debitos;
                                    $obalancete23->si190_totalcreditosnatreceita = $oReg12Saldo->creditos;
                                    $obalancete23->si190_saldofinalnatreceita = ($oReg12Saldo->saldoanterior + $oReg12Saldo->debitos - $oReg12Saldo->creditos) == '' ? 0 : ($oReg12Saldo->saldoanterior + $oReg12Saldo->debitos - $oReg12Saldo->creditos);
                                    $obalancete23->si190_naturezasaldofinalnatreceita = ($oReg12Saldo->saldoanterior + $oReg12Saldo->debitos - $oReg12Saldo->creditos) >= 0 ? 'D' : 'C';
                                    $obalancete23->si190_instit = db_getsession("DB_instit");
                                    $obalancete23->si190_mes = $nMes;

                                    $aContasReg10[$reg10Hash]->reg23[$sHash23] = $obalancete23;

                                } else {

                                    $aContasReg10[$reg10Hash]->reg12[$sHash12]->si190_saldoinicialnatreceita += $oReg12Saldo->saldoanterior;
                                    $aContasReg10[$reg10Hash]->reg12[$sHash12]->si190_totaldebitosnatreceita += $oReg12Saldo->debitos;
                                    $aContasReg10[$reg10Hash]->reg12[$sHash12]->si190_totalcreditosnatreceita += $oReg12Saldo->creditos;
                                    $aContasReg10[$reg10Hash]->reg12[$sHash12]->si190_saldofinalnatreceita += ($oReg12Saldo->saldoanterior + $oReg12Saldo->debitos - $oReg12Saldo->creditos) == '' ? 0 : ($oReg12Saldo->saldoanterior + $oReg12Saldo->debitos - $oReg12Saldo->creditos);
                                    $aContasReg10[$reg10Hash]->reg12[$sHash12]->si190_naturezasaldofinalnatreceita = $aContasReg10[$reg10Hash]->reg12[$sHash12]->si190_saldofinalnatreceita >= 0 ? 'D' : 'C';
                                    $aContasReg10[$reg10Hash]->reg23[$sHash23]->si190_naturezasaldoinicialnatreceita = $aContasReg10[$reg10Hash]->reg23[$sHash23]->si190_saldoinicialnatreceita >= 0 ? 'D' : 'C';

                                }

                            } else {

                                /*
                                 * DADOS PARA GERA��O DO REGISTRO 31 C�lula da Receita ? Execu��o
                                 * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 31
                                 */

                                foreach ($oNaturezaReceita as $oNatureza) {

                                    if ($oNatureza->getAttribute('instituicao') == db_getsession("DB_instit")
                                        && $oNatureza->getAttribute('receitaEcidade') == $sNaturezaReceita
                                    ) {
                                        $sNaturezaReceita = $oNatureza->getAttribute('receitaSicom');
                                        break;
                                    }
                                }

                                $sHash31 = '31' . $oContas10->si177_contacontaabil . $sNaturezaReceita . $objContas->o15_codtri;

                                if (!isset($aContasReg10[$reg10Hash]->reg31[$sHash31])) {

                                    $obalancete31 = new stdClass();
                                    $obalancete31->si243_tiporegistro = 31;
                                    $obalancete31->si243_contacontabil = $oContas10->si177_contacontaabil;
                                    $obalancete31->si243_codfundo = $sCodFundo;
                                    $obalancete31->si243_naturezareceita = str_replace(" ", "", $sNaturezaReceita);
                                    $obalancete31->si243_codfontrecursos = $objContas->o15_codtri;
                                    $obalancete31->si243_emendaparlamentar = $objContas->c19_emparlamentar;
                                    $obalancete31->si243_saldoinicialcre = $oReg12Saldo->saldoanterior;
                                    $obalancete31->si243_naturezasaldoinicialcre = $oReg12Saldo->saldoanterior >= 0 ? 'D' : 'C';
                                    $obalancete31->si243_totaldebitoscre = $oReg12Saldo->debitos;
                                    $obalancete31->si243_totalcreditoscre = $oReg12Saldo->creditos;
                                    $obalancete31->si243_saldofinalcre = ($oReg12Saldo->saldoanterior + $oReg12Saldo->debitos - $oReg12Saldo->creditos) == '' ? 0 : ($oReg12Saldo->saldoanterior + $oReg12Saldo->debitos - $oReg12Saldo->creditos);
                                    $obalancete31->si243_naturezasaldofinalcre = ($oReg12Saldo->saldoanterior + $oReg12Saldo->debitos - $oReg12Saldo->creditos) >= 0 ? 'D' : 'C';
                                    $obalancete31->si243_instit = db_getsession("DB_instit");
                                    $obalancete31->si243_mes = $nMes;

                                    $aContasReg10[$reg10Hash]->reg31[$sHash31] = $obalancete31;
                                } else {
                                    $aContasReg10[$reg10Hash]->reg31[$sHash31]->si243_saldoinicialcre += $oReg12Saldo->saldoanterior;
                                    $aContasReg10[$reg10Hash]->reg31[$sHash31]->si243_totaldebitoscre += $oReg12Saldo->debitos;
                                    $aContasReg10[$reg10Hash]->reg31[$sHash31]->si243_totalcreditoscre += $oReg12Saldo->creditos;
                                    $aContasReg10[$reg10Hash]->reg31[$sHash31]->si243_saldofinalcre += ($oReg12Saldo->saldoanterior + $oReg12Saldo->debitos - $oReg12Saldo->creditos) == '' ? 0 : ($oReg12Saldo->saldoanterior + $oReg12Saldo->debitos - $oReg12Saldo->creditos);
                                    $aContasReg10[$reg10Hash]->reg31[$sHash31]->si243_naturezasaldofinalcre = $aContasReg10[$reg10Hash]->reg31[$sHash31]->si243_saldofinalcre >= 0 ? 'D' : 'C';
                                    $aContasReg10[$reg10Hash]->reg31[$sHash31]->si243_naturezasaldoinicialcre = $aContasReg10[$reg10Hash]->reg31[$sHash31]->si243_saldoinicialcre >= 0 ? 'D' : 'C';
                                }

                            }
                        }
                    }
                }
            }

            /*
             * DADOS PARA GERAÇÃO DO REGISTRO 13 - PROGRAMA E AÇÃO,
             * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 13
             */

            if ($oContas10->nregobrig == 13) {
                /*
                 * Contass do PPA
                 */
                if (in_array(substr($oContas10->si177_contacontaabil, 0, 5), array('51110','51120','61110','61120','61130'))) {

                    /**
                     * Busca os dados importados atraves do conta
                     *
                     */
                    $sNomeClasse = 'cl_balancete13'.(db_getsession('DB_anousu')-1);

                    require_once("classes/db_balancete13".(db_getsession('DB_anousu')-1)."_classe.php");
                    $oBalancete13 = new $sNomeClasse;
                    $sWhere = "si180_mes = ".$oBalancete13::PERIODO_ENCERRAMENTO." and si180_instit = ".db_getsession('DB_instit')." and si180_contacontabil = '{$oContas10->si177_contacontaabil}'";

                    $oDadosImportados = db_utils::getCollectionByRecord($oBalancete13->sql_record($oBalancete13->sql_query_file(null,"*",null,$sWhere)));

                    foreach ($oDadosImportados as $oDadoImportado) {
                        $sHash13 = '13' . $oDadoImportado->si180_contacontabil . $oDadoImportado->si180_codprograma . $oDadoImportado->si180_idacao;

                        $obalancete13 = new stdClass();

                        $obalancete13->si180_tiporegistro = 13;
                        $obalancete13->si180_contacontabil = $oDadoImportado->si180_contacontabil;
                        $obalancete13->si180_codfundo = $sCodFundo;
                        $obalancete13->si180_codprograma = $oDadoImportado->si180_codprograma;
                        $obalancete13->si180_idacao = $oDadoImportado->si180_idacao;
                        $obalancete13->si180_idsubacao = $oDadoImportado->si180_idsubacao;
                        $obalancete13->si180_saldoinicialpa = $oDadoImportado->si180_saldoiniciaipa;
                        $obalancete13->si180_naturezasaldoinicialpa = $oDadoImportado->si180_naturezasaldoiniciaipa;
                        $obalancete13->si180_totaldebitospa = $oDadoImportado->si180_totaldebitospa;
                        $obalancete13->si180_totalcreditospa = $oDadoImportado->si180_totalcreditospa;
                        $obalancete13->si180_saldofinalpa = $oDadoImportado->si180_saldofinaipa;
                        $obalancete13->si180_naturezasaldofinalpa = $oDadoImportado->si180_naturezasaldofinaipa;
                        $obalancete13->si180_instit = db_getsession("DB_instit");
                        $obalancete13->si180_mes = $nMes;

                        $aContasReg10[$reg10Hash]->reg13[$sHash13] = $obalancete13;
                    }

                } else {

                    /*
                     * Busca as dotacoes
                     */
                    $sSqlDotacoes13 = "select distinct o58_coddot,
                                    si09_codorgaotce as codorgao,
                                    case when o41_subunidade != 0 or not null then
                                    lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0)||lpad(o41_subunidade::integer,3,0)
                                    else lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0) end as codunidadesub,
					                o58_funcao as codfuncao,
					                o58_subfuncao as codsubfuncao,
					                o58_programa as codprograma,
					                o58_projativ as idacao,
					                o55_origemacao as idsubacao,
					                substr(o56_elemento,2,6) as naturezadadespesa,
					                '00' as subelemento,
					                o15_codtri as codfontrecursos,
                                    si09_codfundotcemg as codfundo
                                  from
                                  orcdotacao
                                  join orcunidade on o41_anousu = o58_anousu and o41_orgao = o58_orgao and o41_unidade = o58_unidade
                                  join orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                                  join orcelemento ON o56_codele = o58_codele and o58_anousu = o56_anousu
                                  JOIN orcprojativ on o58_anousu = o55_anousu and o58_projativ = o55_projativ
                                  JOIN orctiporec ON o58_codigo = o15_codigo
                                  left join infocomplementaresinstit on  o58_instit = si09_instit
                                  where o58_instit = " . db_getsession("DB_instit") . " and o58_anousu = " . db_getsession("DB_anousu");

                    $nContaCorrente = 101;

                    $rsDotacoes13 = db_query($sSqlDotacoes13) or die($sSqlDotacoes13);

                    for ($iCont13 = 0; $iCont13 < pg_num_rows($rsDotacoes13); $iCont13++) {
                        $oReg13 = db_utils::fieldsMemory($rsDotacoes13, $iCont13);

                        $sSqlReg13saldos = " SELECT
                                          (SELECT case when round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) = '0.00' then null else round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) end AS saldoinicial
                                           FROM
                                             (SELECT
                                                (SELECT CASE WHEN c29_debito > 0 THEN c29_debito WHEN c29_credito > 0 THEN -1 * c29_credito ELSE 0 END AS saldoanterior
                                                 FROM contacorrente
                                                 INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                                 INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial
                                                 AND contacorrentesaldo.c29_mesusu = 0 and contacorrentesaldo.c29_anousu = " . db_getsession("DB_anousu") . " and c19_conplanoreduzanousu = " . db_getsession("DB_anousu") . "
                                                 WHERE c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                                   AND c17_sequencial = {$nContaCorrente}
                                                   AND c19_orcdotacao = {$oReg13->o58_coddot}) AS saldoimplantado,

                                                (SELECT sum(c69_valor) AS debito
                                                 FROM conlancamval
                                                   INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                                   AND conlancam.c70_anousu = conlancamval.c69_anousu
                                                   INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                                   INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                                   INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                                   INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                                   WHERE c28_tipo = 'D'
                                                     AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                                                     AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                                     AND c19_contacorrente = {$nContaCorrente}
                                                     AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                                     AND c19_instit = " . db_getsession("DB_instit") . "
                                                     AND c19_orcdotacao = {$oReg13->o58_coddot}
                                                     {$sWhereEncerramento}
                                                   GROUP BY c28_tipo) AS debitoatual,

                                                (SELECT sum(c69_valor) AS credito
                                                 FROM conlancamval
                                                   INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                                   AND conlancam.c70_anousu = conlancamval.c69_anousu
                                                   INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                                   INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                                   INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                                   INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                                   WHERE c28_tipo = 'C'
                                                     AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                                                     AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                                     AND c19_contacorrente = {$nContaCorrente}
                                                     AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                                     AND c19_instit = " . db_getsession("DB_instit") . "
                                                     AND c19_orcdotacao = {$oReg13->o58_coddot}
                                                     {$sWhereEncerramento}
                                                   GROUP BY c28_tipo) AS creditoatual) AS movi) AS saldoanterior,

                                          (SELECT sum(c69_valor)
                                           FROM conlancamval
                                           INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                           AND conlancam.c70_anousu = conlancamval.c69_anousu
                                           INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                           INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                           INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                           INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                           WHERE c28_tipo = 'C'
                                             AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                             AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                             AND c19_contacorrente = {$nContaCorrente}
                                             AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                             AND c19_instit = " . db_getsession("DB_instit") . "
                                             AND c19_orcdotacao = {$oReg13->o58_coddot}
                                             {$sWhereEncerramento}
                                           GROUP BY c28_tipo) AS creditos,

                                          (SELECT sum(c69_valor)
                                           FROM conlancamval
                                           INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                           AND conlancam.c70_anousu = conlancamval.c69_anousu
                                           INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                           INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                           INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                           INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                           WHERE c28_tipo = 'D'
                                             AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                             AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                             AND c19_contacorrente = {$nContaCorrente}
                                             AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                             AND c19_instit = " . db_getsession("DB_instit") . "
                                             AND c19_orcdotacao = {$oReg13->o58_coddot}
                                             {$sWhereEncerramento}
                                           GROUP BY c28_tipo) AS debitos";

                        $rsReg13saldos = db_query($sSqlReg13saldos) or die($sSqlReg13saldos);

                        for ($iContSaldo13 = 0; $iContSaldo13 < pg_num_rows($rsReg13saldos); $iContSaldo13++) {

                            $oReg13Saldo = db_utils::fieldsMemory($rsReg13saldos, $iContSaldo13);

                            if (!(($oReg13Saldo->saldoanterior == "" || $oReg13Saldo->saldoanterior == 0) && $oReg13Saldo->debitos == "" && $oReg13Saldo->creditos == "")) {

                                $sHash13 = '13' . $oContas10->si177_contacontaabil . $oReg13->codprograma . $oReg13->idacao;

                                if (!isset($aContasReg10[$reg10Hash]->reg13[$sHash13])) {

                                    $obalancete13 = new stdClass();

                                    $obalancete13->si180_tiporegistro = 13;
                                    $obalancete13->si180_contacontabil = $oContas10->si177_contacontaabil;
                                    $obalancete13->si180_codfundo = $sCodFundo;
                                    $obalancete13->si180_codprograma = $oReg13->codprograma;
                                    $obalancete13->si180_idacao = $oReg13->idacao;
                                    $obalancete13->si180_idsubacao = $oReg13->idsubacao;
                                    $obalancete13->si180_saldoinicialpa = $oReg13Saldo->saldoanterior;
                                    $obalancete13->si180_naturezasaldoinicialpa = $oReg13Saldo->saldoanterior >= 0 ? 'D' : 'C';
                                    $obalancete13->si180_totaldebitospa = $oReg13Saldo->debitos;
                                    $obalancete13->si180_totalcreditospa = $oReg13Saldo->creditos;
                                    $obalancete13->si180_saldofinalpa = ($oReg13Saldo->saldoanterior + $oReg13Saldo->debitos - $oReg13Saldo->creditos) == '' ? 0 : ($oReg13Saldo->saldoanterior + $oReg13Saldo->debitos - $oReg13Saldo->creditos);
                                    $obalancete13->si180_naturezasaldofinalpa = ($oReg13Saldo->saldoanterior + $oReg13Saldo->debitos - $oReg13Saldo->creditos) >= 0 ? 'D' : 'C';
                                    $obalancete13->si180_instit = db_getsession("DB_instit");
                                    $obalancete13->si180_mes = $nMes;

                                    $aContasReg10[$reg10Hash]->reg13[$sHash13] = $obalancete13;


                                } else {
                                    $aContasReg10[$reg10Hash]->reg13[$sHash13]->si180_saldoinicialpa += $oReg13Saldo->saldoanterior;
                                    $aContasReg10[$reg10Hash]->reg13[$sHash13]->si180_totaldebitospa += $oReg13Saldo->debitos;
                                    $aContasReg10[$reg10Hash]->reg13[$sHash13]->si180_totalcreditospa += $oReg13Saldo->creditos;
                                    $aContasReg10[$reg10Hash]->reg13[$sHash13]->si180_saldofinalpa += ($oReg13Saldo->saldoanterior + $oReg13Saldo->debitos - $oReg13Saldo->creditos) == '' ? 0 : ($oReg13Saldo->saldoanterior + $oReg13Saldo->debitos - $oReg13Saldo->creditos);
                                    $aContasReg10[$reg10Hash]->reg13[$sHash13]->si180_naturezasaldofinalpa = $aContasReg10[$reg10Hash]->reg13[$sHash13]->si180_saldofinalpa >= 0 ? 'D' : 'C';
                                    $aContasReg10[$reg10Hash]->reg13[$sHash13]->si180_naturezasaldoinicialpa = $aContasReg10[$reg10Hash]->reg13[$sHash13]->si180_saldoinicialpa >= 0 ? 'D' : 'C';
                                }
                            }
                        }
                    }
                }
            }

            /**
             * DADOS PARA GERAÇÃO DO REGISTRO 14 RESTOS A PAGAR,
             * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 14
             *
             */

            if ($oContas10->nregobrig == 14) {
                $sEstrutural = substr($oContas10->si177_contacontaabil, 0, 4);

                $sSqlRestos = "select distinct
                                    e60_coddot,
                                    si09_codorgaotce as codorgao,
                                    case when o41_subunidade != 0 or not null then
                                    lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0)||lpad(o41_subunidade::integer,3,0)
                                    else lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0) end as codunidadesub,
                                    o58_funcao as codfuncao,
                                    o58_subfuncao as codsubfuncao,
                                    o58_programa as codprograma,
                                    o58_projativ as idacao,
                                    o55_origemacao as idsubacao,
                                    substr(o56_elemento,2,12) as naturezadadespesa,
                                    substr(o56_elemento,8,2) as subelemento,
                                    o15_codtri as codfontrecursos,
                                    e60_codemp nroempenho,
                                    e60_numemp numemp,
                                    e60_anousu anoinscricao,
                                    o58_orgao,o58_unidade
                                    from conlancamval
                                    inner join contacorrentedetalheconlancamval on c28_conlancamval = c69_sequen
                                    inner join contacorrentedetalhe on c19_sequencial = c28_contacorrentedetalhe
                                    inner join empempenho on e60_numemp = c19_numemp
                                    inner join orcdotacao on e60_anousu = o58_anousu and o58_coddot = e60_coddot
                                    inner join orcunidade on o41_anousu = o58_anousu and o41_orgao = o58_orgao and o41_unidade = o58_unidade
                                    inner join orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                                    inner join empelemento on e64_numemp = e60_numemp
                                    inner join empresto on e91_numemp = e60_numemp
                                    left join orcelemento ON o56_codele = e64_codele and e60_anousu = o56_anousu
                                    inner JOIN orcprojativ on o58_anousu = o55_anousu and o58_projativ = o55_projativ
                                    inner JOIN orctiporec ON o58_codigo = o15_codigo
                                    left join infocomplementaresinstit on  o58_instit = si09_instit
                                    where (c69_credito IN (" . implode(',', $oContas10->contas) . ") OR c69_debito IN (" . implode(',', $oContas10->contas) . "))
                                    and DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . " and DATE_PART('MONTH',c69_data) <= {$nMes}";
                if ($sEstrutural == "5312" || $sEstrutural == "5322" || $sEstrutural == "6311" || $sEstrutural == "6321" | $sEstrutural == "6313") {
                    $sSqlRestos .= " union ";
                    $sSqlRestos .= " select distinct
                                    e60_coddot,
                                    si09_codorgaotce as codorgao,
                                    case when o41_subunidade != 0 or not null then
                                    lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0)||lpad(o41_subunidade::integer,3,0)
                                    else lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0) end as codunidadesub,
                                    o58_funcao as codfuncao,
                                    o58_subfuncao as codsubfuncao,
                                    o58_programa as codprograma,
                                    o58_projativ as idacao,
                                    o55_origemacao as idsubacao,
                                    substr(o56_elemento,2,12) as naturezadadespesa,
                                    substr(o56_elemento,8,2) as subelemento,
                                    o15_codtri as codfontrecursos,
                                    e60_codemp nroempenho,
                                    e60_numemp numemp,
                                    e60_anousu anoinscricao,
                                    o58_orgao,o58_unidade
                                    from conlancamval
                                    inner join contacorrentedetalheconlancamval on c28_conlancamval = c69_sequen
                                    inner join contacorrentedetalhe on c19_sequencial = c28_contacorrentedetalhe
                                    inner join empempenho on e60_numemp = c19_numemp
                                    inner join orcdotacao on e60_anousu = o58_anousu and o58_coddot = e60_coddot
                                    inner join orcunidade on o41_anousu = o58_anousu and o41_orgao = o58_orgao and o41_unidade = o58_unidade
                                    inner join orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                                    inner join empelemento on e64_numemp = e60_numemp
                                    inner join empresto on e91_numemp = e60_numemp
                                    left join orcelemento ON o56_codele = e64_codele and e60_anousu = o56_anousu
                                    inner JOIN orcprojativ on o58_anousu = o55_anousu and o58_projativ = o55_projativ
                                    inner JOIN orctiporec ON o58_codigo = o15_codigo
                                    left join infocomplementaresinstit on  o58_instit = si09_instit
                                    where (c69_credito IN (" . implode(',', $oContas10->contas) . ") OR c69_debito IN (" . implode(',', $oContas10->contas) . "))
                                    and DATE_PART('YEAR',c69_data) < " . db_getsession("DB_anousu");
                    /**
                     * SQL que busca os restos sem movimentação anterior
                     * Clientes novos
                     */
                    $sSqlRestos .= " union select distinct
                                    e60_coddot,
                                    si09_codorgaotce as codorgao,
                                    case when o41_subunidade != 0 or not null then
                                    lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0)||lpad(o41_subunidade::integer,3,0)
                                    else lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0) end as codunidadesub,
                                    o58_funcao as codfuncao,
                                    o58_subfuncao as codsubfuncao,
                                    o58_programa as codprograma,
                                    o58_projativ as idacao,
                                    o55_origemacao as idsubacao,
                                    substr(o56_elemento,2,12) as naturezadadespesa,
                                    substr(o56_elemento,8,2) as subelemento,
                                    o15_codtri as codfontrecursos,
                                    e60_codemp nroempenho,
                                    e60_numemp numemp,
                                    e60_anousu anoinscricao,
                                    o58_orgao,o58_unidade
                                    from contacorrentedetalhe
                                    inner join empempenho on e60_numemp = c19_numemp
                                    inner join orcdotacao on e60_anousu = o58_anousu and o58_coddot = e60_coddot
                                    inner join orcunidade on o41_anousu = o58_anousu and o41_orgao = o58_orgao and o41_unidade = o58_unidade
                                    inner join orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                                    inner join empelemento on e64_numemp = e60_numemp
                                    inner join empresto on e91_numemp = e60_numemp
                                    left join orcelemento ON o56_codele = e64_codele and e60_anousu = o56_anousu
                                    inner JOIN orcprojativ on o58_anousu = o55_anousu and o58_projativ = o55_projativ
                                    inner JOIN orctiporec ON o58_codigo = o15_codigo
                                    left join infocomplementaresinstit on  o58_instit = si09_instit
                                    where c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                    and c19_conplanoreduzanousu = " . db_getsession("DB_anousu");
                }

                if (pg_num_rows(pg_query($sSqlRestos)) == 0) {

                    $sSqlRestos = "select distinct
                                    e60_coddot,
                                    si09_codorgaotce as codorgao,
                                    case when o41_subunidade != 0 or not null then
                                    lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0)||lpad(o41_subunidade::integer,3,0)
                                    else lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0) end as codunidadesub,
                                    o58_funcao as codfuncao,
                                    o58_subfuncao as codsubfuncao,
                                    o58_programa as codprograma,
                                    o58_projativ as idacao,
                                    o55_origemacao as idsubacao,
                                    substr(o56_elemento,2,12) as naturezadadespesa,
                                    substr(o56_elemento,8,2) as subelemento,
                                    o15_codtri as codfontrecursos,
                                    e60_codemp nroempenho,
                                    e60_numemp numemp,
                                    e60_anousu anoinscricao,
                                    o58_orgao,o58_unidade
                                    from conlancamval
                                    inner join contacorrentedetalheconlancamval on c28_conlancamval = c69_sequen
                                    inner join contacorrentedetalhe on c19_sequencial = c28_contacorrentedetalhe
                                    inner join empempenho on e60_numemp = c19_numemp
                                    inner join orcdotacao on e60_anousu = o58_anousu and o58_coddot = e60_coddot
                                    inner join orcunidade on o41_anousu = o58_anousu and o41_orgao = o58_orgao and o41_unidade = o58_unidade
                                    inner join orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                                    inner join empelemento on e64_numemp = e60_numemp
                                    inner join empresto on e91_numemp = e60_numemp
                                    left join orcelemento ON o56_codele = e64_codele and e60_anousu = o56_anousu
                                    inner JOIN orcprojativ on o58_anousu = o55_anousu and o58_projativ = o55_projativ
                                    inner JOIN orctiporec ON o58_codigo = o15_codigo
                                    left join infocomplementaresinstit on  o58_instit = si09_instit
                                    where (c69_credito IN (" . implode(',', $oContas10->contas) . ") OR c69_debito IN (" . implode(',', $oContas10->contas) . "))
                                    and DATE_PART('YEAR',c69_data) < " . db_getsession("DB_anousu") . " and DATE_PART('MONTH',c69_data) <= {$nMes}";

                }

                $rsRestos = db_query($sSqlRestos) or die($sSqlRestos);

                //Constante da contacorrente orçamentária
                $nContaCorrente = 106;

                for ($iContRp = 0; $iContRp < pg_num_rows($rsRestos); $iContRp++) {

                    $oReg14 = db_utils::fieldsMemory($rsRestos, $iContRp);

                    //Verifica os saldos de cada estrutural do orçamento vinculado ao PCASP
                    $sSqlReg14saldos = " SELECT
                                      (SELECT case when round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) = '0.00' then null else round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) end AS saldoinicial
                                       FROM
                                         (SELECT
                                            (SELECT CASE WHEN c29_debito > 0 THEN c29_debito WHEN c29_credito > 0 THEN -1 * c29_credito ELSE 0 END AS saldoanterior
                                             FROM contacorrente
                                             INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                             INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial
                                             AND contacorrentesaldo.c29_mesusu = 0 and contacorrentesaldo.c29_anousu = " . db_getsession("DB_anousu") . " and c19_conplanoreduzanousu = " . db_getsession("DB_anousu") . "
                                             WHERE c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                               AND c17_sequencial = {$nContaCorrente}
                                               AND c19_numemp = {$oReg14->numemp}) AS saldoimplantado,

                                            (SELECT sum(c69_valor) AS debito
                                             FROM conlancamval
                                       INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                       AND conlancam.c70_anousu = conlancamval.c69_anousu
                                       INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                       INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                       INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                       INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                       WHERE c28_tipo = 'D'
                                         AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                                         AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                         AND c19_contacorrente = {$nContaCorrente}
                                         AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                         AND c19_instit = " . db_getsession("DB_instit") . "
                                         AND c19_numemp = {$oReg14->numemp}
                                         {$sWhereEncerramento}
                                       GROUP BY c28_tipo) AS debitoatual,

                                            (SELECT sum(c69_valor) AS credito
                                             FROM conlancamval
                                       INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                       AND conlancam.c70_anousu = conlancamval.c69_anousu
                                       INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                       INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                       INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                       INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                       WHERE c28_tipo = 'C'
                                         AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                                         AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                         AND c19_contacorrente = {$nContaCorrente}
                                         AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                         AND c19_instit = " . db_getsession("DB_instit") . "
                                         AND c19_numemp = {$oReg14->numemp}
                                         {$sWhereEncerramento}
                                       GROUP BY c28_tipo) AS creditoatual) AS movi) AS saldoanterior,

                                      (SELECT sum(c69_valor)
                                       FROM conlancamval
                                       INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                       AND conlancam.c70_anousu = conlancamval.c69_anousu
                                       INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                       INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                       INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                       INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                       WHERE c28_tipo = 'C'
                                         AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                         AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                         AND c19_contacorrente = {$nContaCorrente}
                                         AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                         AND c19_instit = " . db_getsession("DB_instit") . "
                                         AND c19_numemp = {$oReg14->numemp}
                                         {$sWhereEncerramento}
                                       GROUP BY c28_tipo) AS creditos,

                                      (SELECT sum(c69_valor)
                                       FROM conlancamval
                                       INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                       AND conlancam.c70_anousu = conlancamval.c69_anousu
                                       INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                       INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                       INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                       INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                       WHERE c28_tipo = 'D'
                                         AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                         AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                         AND c19_contacorrente = {$nContaCorrente}
                                         AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                         AND c19_instit = " . db_getsession("DB_instit") . "
                                         AND c19_numemp = {$oReg14->numemp}
                                         {$sWhereEncerramento}
                                       GROUP BY c28_tipo) AS debitos";

                    $rsReg14saldos = db_query($sSqlReg14saldos) or die($sSqlReg14saldos);

                    for ($iContSaldo14 = 0; $iContSaldo14 < pg_num_rows($rsReg14saldos); $iContSaldo14++) {

                        $oReg14Saldo = db_utils::fieldsMemory($rsReg14saldos, $iContSaldo14);

                        if (!(($oReg14Saldo->saldoanterior == "" || $oReg14Saldo->saldoanterior == 0) && $oReg14Saldo->debitos == "" && $oReg14Saldo->creditos == "")) {

                            $sElemento      = substr($oReg14->naturezadadespesa, 0, 6);
                            $sSubElemento   = $oReg14->subelemento;
                            /**
                             * percorrer xml elemento despesa
                             */
                            if($this->iDeParaNatureza == 1) {

                                foreach ($oElementos as $oElemento) {

                                    $sElementoXml = $oElemento->getAttribute('elementoEcidade');
                                    $iElementoXmlDesdobramento = $oElemento->getAttribute('deParaDesdobramento');

                                    if ($iElementoXmlDesdobramento != '' && $iElementoXmlDesdobramento == 1) {

                                        if($sElementoXml == $oReg14->naturezadadespesa) {

                                            $sElemento = substr($oElemento->getAttribute('elementoSicom'), 0, 6);
                                            $sSubElemento = substr($oElemento->getAttribute('elementoSicom'), 6, 2);

                                        }

                                    } elseif ($sElementoXml == $sElemento . $sSubElemento) {

                                        $sElemento = substr($oElemento->getAttribute('elementoSicom'), 0, 6);
                                        $sSubElemento = substr($oElemento->getAttribute('elementoSicom'), 6, 2);

                                    }

                                }

                            }

                            /**
                             * Realiza o tratamento do codunidadesub e do codunidadesuborig
                             * 1. Toma-se como verdade que o codunidadesub é sempre igual ao codunidadesuborig, ou seja, não houve alteração
                             * 2. Verifica se existe dotacao em 2021 passando a unidade e o orgao
                             * 3. Caso nao exista, então buscamos o padrao e passamos para o sCodunidadesub, e o valor do sCodunidadesub é passado para o $sCodunidadesubOrig
                             */

                            $sCodunidadesub = $oReg14->codunidadesub;
                            $sCodunidadesubOrig = $oReg14->codunidadesub;

                            if (!($oReg14->codunidadesub == $this->getDotacaoByCodunidadesub($oReg14->o58_orgao, $oReg14->o58_unidade))) {
                                $sCodunidadesub = ($sCodunidadesub == '' || $sCodunidadesub == 0 ? $this->getDotacaoByCodunidadesub($oReg14->o58_orgao, $oReg14->o58_unidade) : $sCodunidadesub);
                                $sCodunidadesubOrig = $sCodunidadesub;
                            }

                            //OC12114
                            $saldoFinalRsp      = ($oReg14Saldo->saldoanterior + $oReg14Saldo->debitos - $oReg14Saldo->creditos) == '' ? 0 : ($oReg14Saldo->saldoanterior + $oReg14Saldo->debitos - $oReg14Saldo->creditos);
                            $bFonteEncerrada    = in_array($oReg14->codfontrecursos, $this->aFontesEncerradas);

                            if ($bFonteEncerrada) {
                                $iFonte = substr($oReg14->codfontrecursos, 0, 1).'59';
                            } else {
                                $iFonte = $oReg14->codfontrecursos;
                            }

                            $sHash14 = '14' . $oContas10->si177_contacontaabil . $oReg14->codorgao . $sCodunidadesub . $sCodunidadesubOrig . $oReg14->codfuncao . $oReg14->codsubfuncao . $oReg14->codprograma;
                            $sHash14 .= $oReg14->idacao . $oReg14->idsubacao . $sElemento . $sSubElemento . $iFonte . $oReg14->nroempenho . $oReg14->anoinscricao;

                            if (!isset($aContasReg10[$reg10Hash]->reg14[$sHash14])) {

                                $obalancete14 = new stdClass();

                                /*
                                 * Verifica se o empenho existe na tabela dotacaorpsicom
                                 * Caso exista, busca os dados da dotação.
                                 * */

                                $sSqlDotacaoRpSicom = "select *
                                                        from dotacaorpsicom
                                                       where si177_numemp = {$oReg14->numemp}";

                                if (pg_num_rows(db_query($sSqlDotacaoRpSicom)) > 0) {

                                    $aDotacaoRpSicom = db_utils::getColectionByRecord(db_query($sSqlDotacaoRpSicom));

                                    $obalancete14->si181_codorgao = $aDotacaoRpSicom[0]->si177_codorgaotce;
                                    $obalancete14->si181_codunidadesub = $aDotacaoRpSicom[0]->si177_codunidadesub;
                                    $obalancete14->si181_codunidadesuborig = $aDotacaoRpSicom[0]->si177_codunidadesuborig;
                                    $obalancete14->si181_codfuncao = $aDotacaoRpSicom[0]->si177_codfuncao;
                                    $obalancete14->si181_codsubfuncao = $aDotacaoRpSicom[0]->si177_codsubfuncao;
                                    $obalancete14->si181_codprograma = trim($aDotacaoRpSicom[0]->si177_codprograma);
                                    $obalancete14->si181_idacao = $aDotacaoRpSicom[0]->si177_idacao;
                                    $obalancete14->si181_idsubacao = ($aDotacaoRpSicom[0]->si177_idsubacao == 0 ? "" : $aDotacaoRpSicom[0]->si177_idsubacao);
                                    $obalancete14->si181_naturezadespesa = substr($aDotacaoRpSicom[0]->si177_naturezadespesa,0,6);
                                    $obalancete14->si181_subelemento = $aDotacaoRpSicom[0]->si177_subelemento;
                                    if (substr($iFonte, 1, 2) == '59' && in_array($aDotacaoRpSicom[0]->si177_codfontrecursos, $this->aFontesEncerradas)) {
                                        $obalancete14->si181_codfontrecursos = substr($aDotacaoRpSicom[0]->si177_codfontrecursos, 0, 1).'59';
                                    } else {
                                        $obalancete14->si181_codfontrecursos = $aDotacaoRpSicom[0]->si177_codfontrecursos;
                                    }

                                } else {


                                    $obalancete14->si181_codorgao = $oReg14->codorgao;
                                    $obalancete14->si181_codunidadesub = $sCodunidadesub;
                                    $obalancete14->si181_codunidadesuborig = $sCodunidadesubOrig;
                                    $obalancete14->si181_codfuncao = $oReg14->codfuncao;
                                    $obalancete14->si181_codsubfuncao = $oReg14->codsubfuncao;
                                    $obalancete14->si181_codprograma = trim($oReg14->codprograma);
                                    $obalancete14->si181_idacao = $oReg14->idacao;
                                    $obalancete14->si181_idsubacao = $oReg14->idsubacao;
                                    $obalancete14->si181_naturezadespesa = $sElemento;
                                    $obalancete14->si181_subelemento = $sSubElemento;
                                    $obalancete14->si181_codfontrecursos = $iFonte;

                                }

                                $obalancete14->si181_tiporegistro = 14;
                                $obalancete14->si181_contacontabil = $oContas10->si177_contacontaabil;
                                $obalancete14->si181_codfundo = $sCodFundo;
                                $obalancete14->si181_nroempenho = $oReg14->nroempenho;
                                $obalancete14->si181_anoinscricao = $oReg14->anoinscricao;
                                $obalancete14->si181_saldoinicialrsp = $oReg14Saldo->saldoanterior;
                                $obalancete14->si181_naturezasaldoinicialrsp = ($oReg14Saldo->saldoanterior >= 0 ? 'D' : 'C');
                                $obalancete14->si181_totaldebitosrsp = $oReg14Saldo->debitos;
                                $obalancete14->si181_totalcreditosrsp = $oReg14Saldo->creditos;
                                $obalancete14->si181_saldofinalrsp = $saldoFinalRsp;
                                $obalancete14->si181_naturezasaldofinalrsp = $saldoFinalRsp >= 0 ? 'D' : 'C';
                                $obalancete14->si181_instit = db_getsession("DB_instit");
                                $obalancete14->si181_mes = $nMes;
                                $aContasReg10[$reg10Hash]->reg14[$sHash14] = $obalancete14;

                            } else {
                                $aContasReg10[$reg10Hash]->reg14[$sHash14]->si181_saldoinicialrsp += $oReg14Saldo->saldoanterior;
                                $aContasReg10[$reg10Hash]->reg14[$sHash14]->si181_totaldebitosrsp += $oReg14Saldo->debitos;
                                $aContasReg10[$reg10Hash]->reg14[$sHash14]->si181_totalcreditosrsp += $oReg14Saldo->creditos;
                                $aContasReg10[$reg10Hash]->reg14[$sHash14]->si181_saldofinalrsp += $saldoFinalRsp;
                                $aContasReg10[$reg10Hash]->reg14[$sHash14]->si181_naturezasaldofinalrsp = $aContasReg10[$reg10Hash]->reg14[$sHash14]->si181_saldofinalrsp >= 0 ? 'D' : 'C';
                                $aContasReg10[$reg10Hash]->reg14[$sHash14]->si181_naturezasaldoinicialrsp = $aContasReg10[$reg10Hash]->reg14[$sHash14]->si181_saldoinicialrsp >= 0 ? 'D' : 'C';
                            }
                        }
                    }
                }


            }

            /*
             * DADOS PARA GERAÇÃO DO REGISTRO 15 Atributo de Superávit Financeiro,
             * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 15
             *
             */

            if ($oContas10->nregobrig == 15) {

                /*
                 * Busca os saldos das contas pelo reduzido na função fc_saltessaldo();
                 * */
                foreach ($oContas10->contas as $oReduz) {

                    $sSqlReg15saldos = "SELECT
                                               round(substr(fc_planosaldonovo,3,14)::float8,2)::float8 AS anterior,
                                               round(substr(fc_planosaldonovo,17,14)::float8,2)::float8 AS debitos,
                                               round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 AS creditos,
                                               round(substr(fc_planosaldonovo,45,14)::float8,2)::float8 AS saldo_final,
                                               substr(fc_planosaldonovo,59,1)::varchar(1) AS naturezasaldoinicialsf,
                                               substr(fc_planosaldonovo,60,1)::varchar(1) AS naturezasaldofinalsf,
                                               identificadorfinanceiro
                                          FROM
                                          (SELECT p.c60_estrut AS estrut_mae,
                                                  p.c60_estrut AS estrut,
                                                  c61_reduz,
                                                  c61_codcon,
                                                  c61_codigo,
                                                  p.c60_descr,
                                                  p.c60_finali,
                                                  r.c61_instit,
                                                  fc_planosaldonovo(" . db_getsession('DB_anousu') . ",c61_reduz,'" . $this->sDataInicial . "','" . $this->sDataFinal . "',$sEncerramento),
                                                  p.c60_identificadorfinanceiro as identificadorfinanceiro,
                                                  c60_consistemaconta
                                           FROM conplanoexe e
                                           INNER JOIN conplanoreduz r ON r.c61_anousu = c62_anousu
                                           AND r.c61_reduz = c62_reduz
                                           INNER JOIN conplano p ON r.c61_codcon = c60_codcon
                                           AND r.c61_anousu = c60_anousu
                                           LEFT OUTER JOIN consistema ON c60_codsis = c52_codsis
                                           WHERE c62_anousu = " . db_getsession('DB_anousu') . "
                                             AND c61_instit IN (" . db_getsession('DB_instit') . ")
                                             AND c61_reduz = {$oReduz}) as x";

                    $rsReg15saldos = db_query($sSqlReg15saldos) or die($sSqlReg15saldos);

                    for ($iContSaldo15 = 0; $iContSaldo15 < pg_num_rows($rsReg15saldos); $iContSaldo15++) {

                        $oReg15Saldo = db_utils::fieldsMemory($rsReg15saldos, $iContSaldo15);

                        $sHash15 = '15' . $oContas10->si177_contacontaabil . $oReg15Saldo->identificadorfinanceiro;

                        $oReg15Saldo->anterior = $oReg15Saldo->naturezasaldoinicialsf == 'C' ? $oReg15Saldo->anterior * -1 : $oReg15Saldo->anterior;

                        if (!isset($aContasReg10[$reg10Hash]->reg15[$sHash15])){
                            $obalancete15 = new stdClass();
                            $obalancete15->si182_tiporegistro = 15;
                            $obalancete15->si182_contacontabil = $oContas10->si177_contacontaabil;
                            $obalancete15->si182_atributosf = $oReg15Saldo->identificadorfinanceiro;
                            $obalancete15->si182_codfundo = $sCodFundo;
                            $obalancete15->si182_saldoinicialsf = $oReg15Saldo->anterior;
                            $obalancete15->si182_naturezasaldoinicialsf = $obalancete15->anterior >= 0 ? 'D' : 'C';
                            $obalancete15->si182_totaldebitossf = $oReg15Saldo->debitos;
                            $obalancete15->si182_totalcreditossf = $oReg15Saldo->creditos;
                            $obalancete15->si182_saldofinalsf = $oReg15Saldo->anterior + $oReg15Saldo->debitos - $oReg15Saldo->creditos;
                            $obalancete15->si182_naturezasaldofinalsf = $obalancete15->si182_saldofinalsf >= 0 ? 'D' : 'C';
                            $obalancete15->si182_instit = db_getsession("DB_instit");
                            $obalancete15->si182_mes = $nMes;
                            $aContasReg10[$reg10Hash]->reg15[$sHash15] = $obalancete15;

                        } else{
                            $aContasReg10[$reg10Hash]->reg15[$sHash15]->si182_saldoinicialsf += $oReg15Saldo->anterior;
                            $aContasReg10[$reg10Hash]->reg15[$sHash15]->si182_totaldebitossf += $oReg15Saldo->debitos;
                            $aContasReg10[$reg10Hash]->reg15[$sHash15]->si182_totalcreditossf += $oReg15Saldo->creditos;
                            $aContasReg10[$reg10Hash]->reg15[$sHash15]->si182_saldofinalsf += ($oReg15Saldo->anterior + $oReg15Saldo->debitos - $oReg15Saldo->creditos) == '' ? 0 : ($oReg15Saldo->anterior + $oReg15Saldo->debitos - $oReg15Saldo->creditos);
                            $aContasReg10[$reg10Hash]->reg15[$sHash15]->si182_naturezasaldofinalsf = ($aContasReg10[$reg10Hash]->reg15[$sHash15]->si182_saldofinalsf >= 0 ? 'D' : 'C');
                            $aContasReg10[$reg10Hash]->reg15[$sHash15]->si182_naturezasaldoinicialsf = ($aContasReg10[$reg10Hash]->reg15[$sHash15]->si182_saldoinicialsf >= 0 ? 'D' : 'C');

                        }
                    }
                }
            }

            /*
             * DADOS PARA GERA�ÃO DOS REGISTROS:
             *      16 Controle por Fonte de Recursos e Atributo SF,
             *      29 Controle por Fonte de Recursos, Atributo SF e D�vida Consolidada
             * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 16 E 29
             *
             */

            if ($oContas10->nregobrig == 16 || $oContas10->nregobrig == 29) {

                /*
                 * PEGA TODAS AS CONTAS CAIXA DA INSTIUICAO
                 */

                $sSqlFonteReg16 = "SELECT c60_codcon,c61_reduz,c60_descr,si09_codorgaotce,o15_codtri codfontrecursos from ";
                $sSqlFonteReg16 .= "conplano join conplanoreduz on c60_codcon = c61_codcon
    					 left join  infocomplementaresinstit on c61_instit = si09_instit
    					 join orctiporec on o15_codigo = c61_codigo ";
                $sSqlFonteReg16 .= "where c60_anousu = " . db_getsession("DB_anousu");
                $sSqlFonteReg16 .= " and c61_anousu = " . db_getsession("DB_anousu") . " and c61_reduz in (" . implode(',', $oContas10->contas) . ") and c61_instit = " . db_getsession("DB_instit");

                $rsReg16Font = db_query($sSqlFonteReg16) or die($sSqlFonteReg16);

                for ($iContFont16 = 0; $iContFont16 < pg_num_rows($rsReg16Font); $iContFont16++) {

                    $oReg16Font = db_utils::fieldsMemory($rsReg16Font, $iContFont16);

                    /*
                     * Verifica os saldos de cada estrutural do orçamento vinculado ao PCASP
                     *
                     */

                    $sSqlReg16saldos = "SELECT
                                               round(substr(fc_planosaldonovo,3,14)::float8,2)::float8 AS saldoanterior,
                                               round(substr(fc_planosaldonovo,17,14)::float8,2)::float8 AS debitos,
                                               round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 AS creditos,
                                               round(substr(fc_planosaldonovo,45,14)::float8,2)::float8 AS saldo_final,
                                               substr(fc_planosaldonovo,59,1)::varchar(1) AS naturezasaldoinicialctb,
                                               substr(fc_planosaldonovo,60,1)::varchar(1) AS naturezasaldofinalctb,
                                               identificadorfinanceiro
                                        FROM
                                          (SELECT p.c60_estrut AS estrut_mae,
                                                  p.c60_estrut AS estrut,
                                                  c61_reduz,
                                                  c61_codcon,
                                                  c61_codigo,
                                                  p.c60_descr,
                                                  p.c60_finali,
                                                  r.c61_instit,
                                                  fc_planosaldonovo(" . db_getsession('DB_anousu') . ",c61_reduz,'" . $this->sDataInicial . "','" . $this->sDataFinal . "',$sEncerramento),
                                                  p.c60_identificadorfinanceiro as identificadorfinanceiro,
                                                  c60_consistemaconta
                                           FROM conplanoexe e
                                           INNER JOIN conplanoreduz r ON r.c61_anousu = c62_anousu
                                           AND r.c61_reduz = c62_reduz
                                           INNER JOIN conplano p ON r.c61_codcon = c60_codcon
                                           AND r.c61_anousu = c60_anousu
                                           LEFT OUTER JOIN consistema ON c60_codsis = c52_codsis
                                           WHERE c62_anousu = " . db_getsession('DB_anousu') . "
                                             AND c61_instit IN (" . db_getsession('DB_instit') . ")
                                             AND c61_reduz = {$oReg16Font->c61_reduz}) as x";

                    $rsReg16saldos = db_query($sSqlReg16saldos) or die($sSqlReg16saldos);

                    for ($iContSaldo16 = 0; $iContSaldo16 < pg_num_rows($rsReg16saldos); $iContSaldo16++) {

                        $oReg16Saldo = db_utils::fieldsMemory($rsReg16saldos, $iContSaldo16);

                        if (!(($oReg16Saldo->saldoanterior == "" || $oReg16Saldo->saldoanterior == 0) && $oReg16Saldo->debitos == "" && $oReg16Saldo->creditos == "")) {

                            /**
                             * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 16
                             * Controle por Fonte de Recursos e Atributo SF
                             */
                            if ($oContas10->nregobrig == 16) {

                                if ($oReg16Saldo->identificadorfinanceiro == 'F') {
                                    $sHash16 = '16' . $oContas10->si177_contacontaabil . $oReg16Saldo->identificadorfinanceiro . $oReg16Font->codfontrecursos;
                                } else {
                                    $sHash16 = '16' . $oContas10->si177_contacontaabil . $oReg16Saldo->identificadorfinanceiro;
                                }

                                if (!isset($aContasReg10[$reg10Hash]->reg16[$sHash16])) {

                                    $obalancete16 = new stdClass();

                                    $obalancete16->si183_tiporegistro = 16;
                                    $obalancete16->si183_contacontabil = $oContas10->si177_contacontaabil;
                                    $obalancete16->si183_codfundo = $sCodFundo;
                                    $obalancete16->si183_atributosf = $oReg16Saldo->identificadorfinanceiro;
                                    $obalancete16->si183_codfontrecursos = ($oReg16Saldo->identificadorfinanceiro == 'F') ? $oReg16Font->codfontrecursos : 0;
                                    $obalancete16->si183_saldoinicialfontsf = $oReg16Saldo->naturezasaldoinicialctb == 'C' ? $oReg16Saldo->saldoanterior * -1 : $oReg16Saldo->saldoanterior;
                                    $obalancete16->si183_naturezasaldoinicialfontsf = $oReg16Saldo->saldoanterior >= 0 ? 'D' : 'C';
                                    $obalancete16->si183_totaldebitosfontsf = $oReg16Saldo->debitos;
                                    $obalancete16->si183_totalcreditosfontsf = $oReg16Saldo->creditos;
                                    $obalancete16->si183_saldofinalfontsf = ($oReg16Saldo->saldoanterior + $oReg16Saldo->debitos - $oReg16Saldo->creditos) == '' ? 0 : ($oReg16Saldo->saldoanterior + $oReg16Saldo->debitos - $oReg16Saldo->creditos);
                                    $obalancete16->si183_naturezasaldofinalfontsf = ($oReg16Saldo->saldoanterior + $oReg16Saldo->debitos - $oReg16Saldo->creditos) >= 0 ? 'D' : 'C';
                                    $obalancete16->si183_instit = db_getsession("DB_instit");
                                    $obalancete16->si183_mes = $nMes;

                                    $aContasReg10[$reg10Hash]->reg16[$sHash16] = $obalancete16;

                                } else {

                                    $aContasReg10[$reg10Hash]->reg16[$sHash16]->si183_saldoinicialfontsf += $oReg16Saldo->naturezasaldoinicialctb == 'C' ? $oReg16Saldo->saldoanterior * -1 : $oReg16Saldo->saldoanterior;
                                    $aContasReg10[$reg10Hash]->reg16[$sHash16]->si183_totaldebitosfontsf += $oReg16Saldo->debitos;
                                    $aContasReg10[$reg10Hash]->reg16[$sHash16]->si183_totalcreditosfontsf += $oReg16Saldo->creditos;
                                    $aContasReg10[$reg10Hash]->reg16[$sHash16]->si183_saldofinalfontsf += ($oReg16Saldo->saldoanterior + $oReg16Saldo->debitos - $oReg16Saldo->creditos) == '' ? 0 : ($oReg16Saldo->saldoanterior + $oReg16Saldo->debitos - $oReg16Saldo->creditos);
                                    $aContasReg10[$reg10Hash]->reg16[$sHash16]->si183_naturezasaldofinalfontsf = $aContasReg10[$reg10Hash]->reg16[$sHash16]->si183_saldofinalfontsf >= 0 ? 'D' : 'C';
                                    $aContasReg10[$reg10Hash]->reg16[$sHash16]->si183_naturezasaldoinicialfontsf = $aContasReg10[$reg10Hash]->reg16[$sHash16]->si183_saldoinicialfontsf >= 0 ? 'D' : 'C';
                                }

                            } else {

                                /**
                                 * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 29
                                 * Controle por Fonte de Recursos, Atributo SF e D�vida Consolidada
                                 */

                                $sHash29 = '29' . $oContas10->si177_contacontaabil . $oReg16Saldo->identificadorfinanceiro . $oReg16Font->codfontrecursos;

                                if (!isset($aContasReg10[$reg10Hash]->reg29[$sHash29])) {

                                    $obalancete29 = new stdClass();

                                    $obalancete29->si241_tiporegistro = 29;
                                    $obalancete29->si241_contacontabil = $oContas10->si177_contacontaabil;
                                    $obalancete29->si241_codfundo = $sCodFundo;
                                    $obalancete29->si241_atributosf = $oReg16Saldo->identificadorfinanceiro;
                                    $obalancete29->si241_codfontrecursos = ($oReg16Saldo->identificadorfinanceiro == 'F') ? $oReg16Font->codfontrecursos : 0;
                                    $obalancete29->si241_dividaconsolidada = substr($oContas10->si177_contacontaabil,0,2) == '22' ? 1 : 2;
                                    $obalancete29->si241_saldoinicialfontsf = $oReg16Saldo->naturezasaldoinicialctb == 'C' ? $oReg16Saldo->saldoanterior * -1 : $oReg16Saldo->saldoanterior;
                                    $obalancete29->si241_naturezasaldoinicialfontsf = $oReg16Saldo->saldoanterior >= 0 ? 'D' : 'C';
                                    $obalancete29->si241_totaldebitosfontsf = $oReg16Saldo->debitos;
                                    $obalancete29->si241_totalcreditosfontsf = $oReg16Saldo->creditos;
                                    $obalancete29->si241_saldofinalfontsf = ($oReg16Saldo->saldoanterior + $oReg16Saldo->debitos - $oReg16Saldo->creditos) == '' ? 0 : ($oReg16Saldo->saldoanterior + $oReg16Saldo->debitos - $oReg16Saldo->creditos);
                                    $obalancete29->si241_naturezasaldofinalfontsf = ($oReg16Saldo->saldoanterior + $oReg16Saldo->debitos - $oReg16Saldo->creditos) >= 0 ? 'D' : 'C';
                                    $obalancete29->si241_instit = db_getsession("DB_instit");
                                    $obalancete29->si241_mes = $nMes;

                                    $aContasReg10[$reg10Hash]->reg29[$sHash29] = $obalancete29;

                                } else {

                                    $aContasReg10[$reg10Hash]->reg29[$sHash29]->si241_saldoinicialfontsf += $oReg16Saldo->naturezasaldoinicialctb == 'C' ? $oReg16Saldo->saldoanterior * -1 : $oReg16Saldo->saldoanterior;
                                    $aContasReg10[$reg10Hash]->reg29[$sHash29]->si241_totaldebitosfontsf += $oReg16Saldo->debitos;
                                    $aContasReg10[$reg10Hash]->reg29[$sHash29]->si241_totalcreditosfontsf += $oReg16Saldo->creditos;
                                    $aContasReg10[$reg10Hash]->reg29[$sHash29]->si241_saldofinalfontsf += ($oReg16Saldo->saldoanterior + $oReg16Saldo->debitos - $oReg16Saldo->creditos) == '' ? 0 : ($oReg16Saldo->saldoanterior + $oReg16Saldo->debitos - $oReg16Saldo->creditos);
                                    $aContasReg10[$reg10Hash]->reg29[$sHash29]->si241_naturezasaldofinalfontsf = $aContasReg10[$reg10Hash]->reg29[$sHash29]->si241_saldofinalfontsf >= 0 ? 'D' : 'C';
                                    $aContasReg10[$reg10Hash]->reg29[$sHash29]->si241_naturezasaldoinicialfontsf = $aContasReg10[$reg10Hash]->reg29[$sHash29]->si241_saldoinicialfontsf >= 0 ? 'D' : 'C';
                                }
                            }
                        }
                    }
                }
            }

            /*
             * DADOS PARA GERAÇÃO DO REGISTRO 17 Controle por Fonte de Recursos, Atributo SF e Conta Bancária,
             * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 17
             *
             */

            if ($oContas10->nregobrig == 17) {

                /*
                 * Modificacao realizada pela OC12114.
                 * So era considerado as movimentacoes das contas com apenas uma fonte, a fonte de cadastro no PCASP.
                 * Com novas exigencias do TCE/MG, sera necessario informar todas as fontes destas contas bancarias,
                 * tal informaçao so temos no Acompanhamento Mensal no arquivo CTB.
                 * Desta maneira, sera necessario gerar o saldo das contas por fonte de acordo com os dados do registro 20 e 21 do arquivo CTB.
                 * 
                 * Caso seja RPPS, descrever as regras que barbara me passou
                 */

                $bIsRPPS = $this->getTipoinstit(db_getsession("DB_instit")) == 5;
                
                if ($bIsRPPS) {
                    
                    $sSqlCtb = "    SELECT DISTINCT 17 AS tiporegistro,
                                            contacontabil,
                                            atributosf,
                                            codctb,
                                            codfontrecursos,
                                            CASE
                                                WHEN contasagrupadas AND atributos_diferentes THEN saldoanteriorbalancete
                                                ELSE saldoinicialctb
                                            END AS saldoinicial,
                                            CASE
                                                WHEN contasagrupadas AND atributos_diferentes THEN naturezasaldoinicialbalancete
                                                ELSE natursaldoinictb
                                            END AS natursaldoinicial,
                                            coalesce(CASE
                                                        WHEN contasagrupadas AND atributos_diferentes THEN debitos
                                                        WHEN tipoentrsaida = 1 THEN vlentrsaida
                                                        ELSE 0
                                                    END,0) AS debitos,
                                            coalesce(CASE
                                                        WHEN contasagrupadas AND atributos_diferentes THEN creditos
                                                        WHEN tipoentrsaida = 2 THEN vlentrsaida
                                                        ELSE 0
                                                    END,0) AS creditos,
                                            CASE
                                                WHEN contasagrupadas AND atributos_diferentes THEN saldofinalbalancete
                                                ELSE saldofinalctb
                                            END AS saldofinal,
                                            CASE
                                                WHEN contasagrupadas AND atributos_diferentes THEN naturezasaldofinalbalancete
                                                ELSE natursaldofinctb
                                            END AS natursaldofinal
                                        FROM
                                            (SELECT contacontabil,
                                                    atributosf,
                                                    codctb,
                                                    codfontrecursos,
                                                    saldoinicialctb,
                                                    CASE
                                                        WHEN saldoinicialctb < 0 THEN 'C'
                                                        ELSE 'D'
                                                    END AS natursaldoinictb,
                                                    round(substr(fc_planosaldonovo,3,14)::float8,2)::float8 AS saldoanteriorbalancete,
                                                    substr(fc_planosaldonovo,59,1)::varchar(1) AS naturezasaldoinicialbalancete,
                                                    round(substr(fc_planosaldonovo,17,14)::float8,2)::float8 AS debitos,
                                                    round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 AS creditos,
                                                    coalesce(si97_tipomovimentacao,0) AS tipoentrsaida,
                                                    si97_valorentrsaida AS vlentrsaida,
                                                    saldofinalctb,
                                                    CASE
                                                        WHEN saldofinalctb < 0 THEN 'C'
                                                        ELSE 'D'
                                                    END AS natursaldofinctb,
                                                    round(substr(fc_planosaldonovo,45,14)::float8,2)::float8 AS saldofinalbalancete,
                                                    substr(fc_planosaldonovo,60,1)::varchar(1) AS naturezasaldofinalbalancete,
                                                    (
                                                        (SELECT count(*)
                                                        FROM conplano
                                                        INNER JOIN conplanoreduz ON c61_codcon = c60_codcon
                                                        AND c61_anousu = c60_anousu
                                                        WHERE c61_anousu = ".db_getsession('DB_anousu')."
                                                            AND c61_instit = ".db_getsession("DB_instit")."
                                                            AND (c61_reduz = codctb
                                                                OR c61_codtce = codctb) ) > 1) AS contasagrupadas,
                                                    (
                                                        (SELECT count(*)
                                                        FROM
                                                            (SELECT DISTINCT c60_identificadorfinanceiro
                                                                FROM conplano
                                                                INNER JOIN conplanoreduz ON c61_codcon = c60_codcon
                                                                    AND c61_anousu = c60_anousu
                                                                WHERE c61_anousu = ".db_getsession('DB_anousu')."
                                                                AND c61_instit = ".db_getsession("DB_instit")."
                                                                AND (c61_reduz = codctb
                                                                    OR c61_codtce = codctb) ) AS atributo) > 1) AS atributos_diferentes
                                            FROM
                                                (SELECT si96_sequencial,
                                                        CASE
                                                            WHEN c209_tceestrut IS NULL THEN substr(c60_estrut,1,9)
                                                            ELSE c209_tceestrut
                                                        END AS contacontabil,
                                                        c60_identificadorfinanceiro AS atributosf,
                                                        si96_codctb AS codctb,
                                                        si96_codfontrecursos AS codfontrecursos,
                                                        c61_reduz,
                                                        si96_vlsaldoinicialfonte AS saldoinicialctb,
                                                        fc_planosaldonovo(".db_getsession('DB_anousu').",c61_reduz,'" . $this->sDataInicial . "','" . $this->sDataFinal . "',$sEncerramento),
                                                        si96_vlsaldofinalfonte AS saldofinalctb
                                                FROM ctb202021
                                                INNER JOIN conplanoreduz ON c61_instit = si96_instit
                                                AND c61_anousu = ".db_getsession('DB_anousu')."
                                                AND (c61_codtce = si96_codctb
                                                    OR c61_reduz = si96_codctb)
                                                INNER JOIN conplano ON c60_codcon = c61_codcon
                                                AND c60_anousu = c61_anousu
                                                LEFT JOIN vinculopcasptce ON substr(c60_estrut,1,9) = c209_pcaspestrut
                                                WHERE si96_mes = ".$this->sDataFinal['5'] . $this->sDataFinal['6']."
                                                    AND si96_instit = ".db_getsession("DB_instit")." ) AS x
                                            LEFT JOIN ctb212021 ON si96_sequencial = si97_reg20 ) AS xx
                                        ORDER BY codctb,
                                                codfontrecursos ";
                } else {
                    
                    $sSqlCtb = "    SELECT  17 AS tiporegistro,
                                            (SELECT CASE
                                                WHEN c209_tceestrut IS NULL THEN substr(c60_estrut,1,9)
                                                ELSE c209_tceestrut
                                            END
                                            FROM conplano
                                                INNER JOIN conplanoreduz ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu
                                                LEFT JOIN vinculopcasptce ON substr(c60_estrut,1,9) = c209_pcaspestrut
                                            WHERE c61_anousu =".db_getsession('DB_anousu')."
                                                AND (c61_reduz = si96_codctb OR c61_codtce = si96_codctb)
                                            ORDER BY c60_estrut
                                            LIMIT 1) AS contacontabil,
                                            (SELECT c60_identificadorfinanceiro
                                                FROM conplano
                                                INNER JOIN conplanoreduz ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu
                                                WHERE c61_anousu =".db_getsession('DB_anousu')."
                                                    AND (c61_reduz = si96_codctb OR c61_codtce = si96_codctb)
                                                ORDER BY c60_estrut
                                                LIMIT 1) AS atributosf,
                                            si96_codctb AS codctb,
                                            si96_codfontrecursos AS codfontrecursos,
                                            si96_vlsaldoinicialfonte AS saldoinicial,
                                            CASE
                                                WHEN si96_vlsaldoinicialfonte < 0 THEN 'C'
                                                ELSE 'D'
                                            END AS natursaldoinicial,
                                            si97_tipomovimentacao AS tipoentrsaida,
                                            si97_valorentrsaida AS vlentrsaida,
                                            si96_vlsaldofinalfonte AS saldofinal,
                                            CASE
                                                WHEN si96_vlsaldofinalfonte < 0 THEN 'C'
                                                ELSE 'D'
                                            END AS natursaldofinal
                                        FROM
                                            (SELECT *
                                                FROM ctb202021
                                                LEFT JOIN ctb212021 ON si96_sequencial = si97_reg20
                                                WHERE si96_mes = ".$this->sDataFinal['5'] . $this->sDataFinal['6']."
                                                    AND si96_instit = ".db_getsession("DB_instit").") AS xx
                                        ORDER BY codctb";

                }

                $rsCtb = db_query($sSqlCtb) or die($sSqlCtb);

                if (pg_num_rows($rsCtb) == 0) {
                    throw new Exception("Gere o arquivo CTB mensal para prosseguir com a geração do balancete");
                }

                for ($iCtb = 0; $iCtb < pg_num_rows($rsCtb); $iCtb++) {

                    $objContasctb = db_utils::fieldsMemory($rsCtb, $iCtb);

                    $sHash17 = '17'.$objContasctb->contacontabil . $objContasctb->atributosf . $objContasctb->codctb . $objContasctb->codfontrecursos;

                    /**
                     * Os resultados da consulta serao sempre os mesmos para cada iteracao do reg10.
                     * Porem, serao agrupados se a conta contabil for igual a conta contabil do reg10
                     */

                    if($reg10Hash == $objContasctb->contacontabil
                        && !($objContasctb->saldoinicial == 0 && $objContasctb->saldofinal == 0 && $objContasctb->debitos == 0 && $objContasctb->creditos == 0)) {

                        if (!isset($aContasReg10[$reg10Hash]->reg17[$sHash17])) {

                            $obalancete17 = new stdClass();
                            $obalancete17->si184_tiporegistro = 17;
                            $obalancete17->si184_contacontabil = $objContasctb->contacontabil;
                            $obalancete17->si184_codfundo = $sCodFundo;
                            $obalancete17->si184_atributosf = $objContasctb->atributosf;
                            $obalancete17->si184_codctb = $objContasctb->codctb;
                            $obalancete17->si184_codfontrecursos = $objContasctb->codfontrecursos;
                            $obalancete17->si184_saldoinicialctb = $objContasctb->saldoinicial;
                            $obalancete17->si184_naturezasaldoinicialctb = $objContasctb->natursaldoinicial;
                            $obalancete17->si184_totaldebitosctb = $objContasctb->debitos;
                            $obalancete17->si184_totalcreditosctb = $objContasctb->creditos;
                            $obalancete17->si184_totaldebitosctb = $bIsRPPS ? $objContasctb->debitos : ($objContasctb->tipoentrsaida == 1 ? $objContasctb->vlentrsaida : 0);
                            $obalancete17->si184_totalcreditosctb = $bIsRPPS ? $objContasctb->creditos : ($objContasctb->tipoentrsaida == 2 ? $objContasctb->vlentrsaida : 0);

                            $obalancete17->si184_saldofinalctb = $objContasctb->saldofinal;
                            $obalancete17->si184_naturezasaldofinalctb = $objContasctb->natursaldofinal;
                            $obalancete17->si184_instit = db_getsession("DB_instit");
                            $obalancete17->si184_mes = $nMes;

                            $aContasReg10[$reg10Hash]->reg17[$sHash17] = $obalancete17;

                            $aContasReg10[$reg10Hash]->si177_saldoinicial += $objContasctb->saldoinicial;
                            $aContasReg10[$reg10Hash]->si177_totaldebitos += $bIsRPPS ? $objContasctb->debitos : ($objContasctb->tipoentrsaida == 1 ? $objContasctb->vlentrsaida : 0);
                            $aContasReg10[$reg10Hash]->si177_totalcreditos += $bIsRPPS ? $objContasctb->creditos : ($objContasctb->tipoentrsaida == 2 ? $objContasctb->vlentrsaida : 0);
                            $aContasReg10[$reg10Hash]->si177_saldofinal += $objContasctb->saldofinal;

                        } else {

                            $aContasReg10[$reg10Hash]->reg17[$sHash17]->si184_totaldebitosctb += $bIsRPPS ? $objContasctb->debitos : ($objContasctb->tipoentrsaida == 1 ? $objContasctb->vlentrsaida : 0);
                            $aContasReg10[$reg10Hash]->reg17[$sHash17]->si184_totalcreditosctb += $bIsRPPS ? $objContasctb->creditos : ($objContasctb->tipoentrsaida == 2 ? $objContasctb->vlentrsaida : 0);

                            $aContasReg10[$reg10Hash]->si177_totaldebitos += $bIsRPPS ? $objContasctb->debitos : ($objContasctb->tipoentrsaida == 1 ? $objContasctb->vlentrsaida : 0);
                            $aContasReg10[$reg10Hash]->si177_totalcreditos += $bIsRPPS ? $objContasctb->creditos : ($objContasctb->tipoentrsaida == 2 ? $objContasctb->vlentrsaida : 0);

                        }

                    }

                }

            }


            /*
             * DADOS PARA GERAÇÃO DO REGISTRO 18 Controle por Fonte de Recursos,
             * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 18
             *
             */

            if ($oContas10->nregobrig == 18) {

                /*
                 * Busca tas as fontes de recurso.
                 * */

                $sSqlfr = " select DISTINCT o15_codigo, o15_codtri codfontrecursos FROM orctiporec where o15_codtri is not null";

                $rsSqlfr = db_query($sSqlfr) or die($sSqlfr);

                /*
                 * Constante da contacorrente que indica o superavit financeiro
                 *
                 */
                $nContaCorrente = 103;

                for ($iContfr = 0; $iContfr < pg_num_rows($rsSqlfr); $iContfr++) {

                    $objContasfr = db_utils::fieldsMemory($rsSqlfr, $iContfr);

                    /*
                     * Verificarmos se possui alguma destas fontes de recursos para cada conta
                     * e calculamos os saldos.
                     */

                    $sSqlReg18saldos = " SELECT
                                          (SELECT case when round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) = '0.00' then null else round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) end AS saldoinicial
                                           FROM
                                             (SELECT
                                                (SELECT SUM(saldoanterior) AS saldoanterior FROM
                                                    (SELECT CASE WHEN c29_debito > 0 THEN c29_debito WHEN c29_credito > 0 THEN -1 * c29_credito ELSE 0 END AS saldoanterior
                                                     FROM contacorrente
                                                     INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                                     INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial
                                                     AND contacorrentesaldo.c29_mesusu = 0 and contacorrentesaldo.c29_anousu = " . db_getsession("DB_anousu") . " and c19_conplanoreduzanousu = " . db_getsession("DB_anousu") . "
                                                     WHERE c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                                       AND c17_sequencial = {$nContaCorrente}
                                                       AND c19_orctiporec = {$objContasfr->o15_codigo}) as x) AS saldoimplantado,

                                                (SELECT sum(c69_valor) AS debito
                                                 FROM conlancamval
                                                   INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                                   AND conlancam.c70_anousu = conlancamval.c69_anousu
                                                   INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                                   INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                                   INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                                   INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                                   WHERE c28_tipo = 'D'
                                                     AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                                                     AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                                     AND c19_contacorrente = {$nContaCorrente}
                                                     AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                                     AND c19_orctiporec = {$objContasfr->o15_codigo}
                                                     {$sWhereEncerramento}
                                                   GROUP BY c28_tipo) AS debitoatual,

                                                (SELECT sum(c69_valor) AS credito
                                                 FROM conlancamval
                                                   INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                                   AND conlancam.c70_anousu = conlancamval.c69_anousu
                                                   INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                                   INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                                   INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                                   INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                                   WHERE c28_tipo = 'C'
                                                     AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                                                     AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                                     AND c19_contacorrente = {$nContaCorrente}
                                                     AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                                     AND c19_orctiporec = {$objContasfr->o15_codigo}
                                                     {$sWhereEncerramento}
                                                   GROUP BY c28_tipo) AS creditoatual) AS movi) AS saldoanterior,

                                          (SELECT sum(c69_valor)
                                           FROM conlancamval
                                           INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                           AND conlancam.c70_anousu = conlancamval.c69_anousu
                                           INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                           INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                           INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                           INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                           WHERE c28_tipo = 'C'
                                             AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                             AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                             AND c19_contacorrente = {$nContaCorrente}
                                             AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                             AND c19_orctiporec = {$objContasfr->o15_codigo}
                                             {$sWhereEncerramento}
                                           GROUP BY c28_tipo) AS creditos,

                                          (SELECT sum(c69_valor)
                                           FROM conlancamval
                                           INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                           AND conlancam.c70_anousu = conlancamval.c69_anousu
                                           INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                           INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                           INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                           INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                           WHERE c28_tipo = 'D'
                                             AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                             AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                             AND c19_contacorrente = {$nContaCorrente}
                                             AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                             AND c19_orctiporec = {$objContasfr->o15_codigo}
                                             {$sWhereEncerramento}
                                           GROUP BY c28_tipo) AS debitos";

                    $rsReg18saldos = db_query($sSqlReg18saldos) or die($sSqlReg18saldos);

                    //OC12114
                    $bFonteEncerrada  = in_array($objContasfr->codfontrecursos, $this->aFontesEncerradas);

                    $iFonte = $bFonteEncerrada ? substr($objContasfr->codfontrecursos, 0, 1).'59' : $objContasfr->codfontrecursos;

                    for ($iContSaldo18 = 0; $iContSaldo18 < pg_num_rows($rsReg18saldos); $iContSaldo18++) {

                        $oReg18Saldo = db_utils::fieldsMemory($rsReg18saldos, $iContSaldo18);

                        if (!(($oReg18Saldo->saldoanterior == "" || $oReg18Saldo->saldoanterior == 0) && $oReg18Saldo->debitos == "" && $oReg18Saldo->creditos == "")) {

                            $sHash18 = '18' . $oContas10->si177_contacontaabil . $iFonte;

                            if (!isset($aContasReg10[$reg10Hash]->reg18[$sHash18])) {

                                $obalancete18 = new stdClass();

                                $obalancete18->si185_tiporegistro = 18;
                                $obalancete18->si185_contacontabil = $oContas10->si177_contacontaabil;
                                $obalancete18->si185_codfundo = $sCodFundo;
                                $obalancete18->si185_codfontrecursos = $iFonte;
                                $obalancete18->si185_saldoinicialfr = $oReg18Saldo->saldoanterior;
                                $obalancete18->si185_naturezasaldoinicialfr = $oReg18Saldo->saldoanterior >= 0 ? 'D' : 'C';
                                $obalancete18->si185_totaldebitosfr = $oReg18Saldo->debitos;
                                $obalancete18->si185_totalcreditosfr = $oReg18Saldo->creditos;
                                $obalancete18->si185_saldofinalfr = (($oReg18Saldo->saldoanterior) + $oReg18Saldo->debitos - $oReg18Saldo->creditos) == '' ? 0 : (($oReg18Saldo->saldoanterior) + $oReg18Saldo->debitos - $oReg18Saldo->creditos);
                                $obalancete18->si185_naturezasaldofinalfr = ($oReg18Saldo->saldoanterior + $oReg18Saldo->debitos - $oReg18Saldo->creditos) >= 0 ? 'D' : 'C';
                                $obalancete18->si185_instit = db_getsession("DB_instit");
                                $obalancete18->si185_mes = $nMes;

                                $aContasReg10[$reg10Hash]->reg18[$sHash18] = $obalancete18;

                            } else {

                                $aContasReg10[$reg10Hash]->reg18[$sHash18]->si185_saldoinicialfr += $oReg18Saldo->saldoanterior;
                                $aContasReg10[$reg10Hash]->reg18[$sHash18]->si185_totaldebitosfr += $oReg18Saldo->debitos;
                                $aContasReg10[$reg10Hash]->reg18[$sHash18]->si185_totalcreditosfr += $oReg18Saldo->creditos;
                                $aContasReg10[$reg10Hash]->reg18[$sHash18]->si185_saldofinalfr += ($oReg18Saldo->saldoanterior + $oReg18Saldo->debitos - $oReg18Saldo->creditos) == '' ? 0 : ($oReg18Saldo->saldoanterior + $oReg18Saldo->debitos - $oReg18Saldo->creditos);
                                $aContasReg10[$reg10Hash]->reg18[$sHash18]->si185_naturezasaldofinalfr = $aContasReg10[$reg10Hash]->reg18[$sHash18]->si185_saldofinalfr >= 0 ? 'D' : 'C';
                                $aContasReg10[$reg10Hash]->reg18[$sHash18]->si185_naturezasaldoinicialfr = $aContasReg10[$reg10Hash]->reg18[$sHash18]->si185_saldoinicialfr >= 0 ? 'D' : 'C';

                            }

                        }
                    }
                }
            }

            /*
             * DADOS PARA GERAÇÃO DO REGISTRO 19 Identificação do Consórcio,
             * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 19
             * @todo: validar SQL
             */

            if ($oContas10->nregobrig == 19) {

                /*
                 * Buscar o vinculo da conta pcasp com o plano orçamentário
                 *
                 * */
                $sSqlconsor = "";

                $rsSqlconsor = db_query($sSqlconsor);

                /*
                 * Constante da contacorrente que indica o superavit financeiro
                 *
                 */
                $nContaCorrente = 104;

                for ($iContconsor = 0; $iContconsor < pg_num_rows($rsSqlconsor); $iContconsor++) {

                    $objContasconsor = db_utils::fieldsMemory($rsSqlconsor, $iContconsor);

                    /*
                     * Verifica os saldos de cada estrutural do orçamento vinculado ao PCASP
                     * @todo: validar filtro de busca
                     */

                    $sSqlReg19saldos = "";

                    $rsReg19saldos = db_query($sSqlReg19saldos);

                    for ($iContSaldo19 = 0; $iContSaldo19 < pg_num_rows($rsReg19saldos); $iContSaldo19++) {

                        $oReg19Saldo = db_utils::fieldsMemory($rsReg19saldos, $iContSaldo19);

                        $sHash19 = '19' . $oContas10->si197_contacontaabil . $objContasconsor->cnpjconsorcio;
                        if (!isset($aContasReg10[$reg10Hash]->reg19[$sHash19])) {

                            $obalancete19 = new stdClass();

                            $obalancete19->si186_tiporegistro = 19;
                            $obalancete19->si186_contacontabil = $oContas10->si177_contacontaabil;
                            $obalancete19->si186_codfundo = $sCodFundo;
                            $obalancete19->cnpjconsorcio = $objContasconsor->cnpjconsorcio;
                            $obalancete19->si186_saldoinicialconsor = $oReg19Saldo->saldoanterior;
                            $obalancete19->si186_naturezasaldoinicialconsor = $oReg19Saldo->saldoanterior >= 0 ? 'D' : 'C';
                            $obalancete19->si186_totaldebitosconsor = abs($oReg19Saldo->debitos);
                            $obalancete19->si186_totalcreditosconsor = abs($oReg19Saldo->creditos);
                            $obalancete19->si186_saldofinalconsor = abs(($oReg19Saldo->saldoanterior + $oReg19Saldo->debitos - $oReg19Saldo->creditos) == '' ? 0 : ($oReg19Saldo->saldoanterior + $oReg19Saldo->debitos - $oReg19Saldo->creditos));
                            $obalancete19->si186_naturezasaldofinalconsor = ($oReg19Saldo->saldoanterior + $oReg19Saldo->debitos - $oReg19Saldo->creditos) >= 0 ? 'D' : 'C';
                            $obalancete19->si186_instit = db_getsession("DB_instit");
                            $obalancete19->si186_mes = $nMes;

                            $aContasReg10[$reg10Hash]->reg19[$sHash19] = $obalancete19;
                        } else {
                            $aContasReg10[$reg10Hash]->reg19[$sHash19]->si186_saldoinicialconsor += $oReg19Saldo->saldoanterior;
                            $aContasReg10[$reg10Hash]->reg19[$sHash19]->si186_totaldebitosconsor += $oReg19Saldo->debitos;
                            $aContasReg10[$reg10Hash]->reg19[$sHash19]->si186_totalcreditosconsor += $oReg19Saldo->creditos;
                            $aContasReg10[$reg10Hash]->reg19[$sHash19]->si186_saldofinalconsor += abs(($oReg19Saldo->saldoanterior + $oReg19Saldo->debitos - $oReg19Saldo->creditos) == '' ? 0 : ($oReg19Saldo->saldoanterior + $oReg19Saldo->debitos - $oReg19Saldo->creditos));
                            $aContasReg10[$reg10Hash]->reg19[$sHash19]->si186_naturezasaldofinalconsor = $aContasReg10[$reg10Hash]->reg19[$sHash19]->si186_saldofinalconsor >= 0 ? 'D' : 'C';
                        }
                    }
                }
            }

            /*
             * DADOS PARA GERAÇÃO DO REGISTRO 20 Controle por Consórcio e Classificação por Função, Natureza da Despesa e Fonte de Recursos*
             * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 20
             * @todo: validar SQL
             */

            if ($oContas10->nregobrig == 20) {

                /*
                 * Buscar o vinculo da conta pcasp com o plano orçamentário
                 *
                 * */
                $sSqlconscf = "";

                $rsSqlconscf = db_query($sSqlconscf);

                /*
                 * Constante da contacorrente que indica o superavit financeiro
                 *
                 */
                $nContaCorrente = 101;

                for ($iContconscf = 0; $iContconscf < pg_num_rows($rsSqlconscf); $iContconscf++) {

                    $objContasconscf = db_utils::fieldsMemory($rsSqlconscf, $iContconscf);

                    /*
                     * Verifica os saldos de cada estrutural do orçamento vinculado ao PCASP
                     * @todo: criar sql e validar filtro de busca
                     */

                    $sSqlReg20saldos = "";

                    $rsReg20saldos = db_query($sSqlReg20saldos);

                    for ($iContSaldo20 = 0; $iContSaldo20 < pg_num_rows($rsReg20saldos); $iContSaldo20++) {

                        $oReg20Saldo = db_utils::fieldsMemory($rsReg20saldos, $iContSaldo20);

                        $sHash20 = '20' . $oContas10->si207_contacontaabil . $objContasconscf->cnpjconscfcio . $objContasconscf->tiporecurso . $objContasconscf->codfuncao;
                        $sHash20 .= $objContasconscf->subfuncao . $objContasconscf->naturezadespesa . $objContasconscf->subelemento . $objContasconscf->codfontrecursos;
                        if (!isset($aContasReg10[$reg10Hash]->reg20[$sHash20])) {

                            $obalancete20 = new stdClass();

                            $obalancete20->si187_tiporegistro = 20;
                            $obalancete20->si187_contacontabil = $oContas10->si177_contacontaabil;
                            $obalancete20->si187_codfundo = $sCodFundo;
                            $obalancete20->si187_cnpjconscfcio = $objContasconscf->cnpjconscfcio;
                            $obalancete20->si187_tiporecurso = $objContasconscf->tiporecurso;
                            $obalancete20->si187_codfuncao = $objContasconscf->codfuncao;
                            $obalancete20->si187_subfuncao = $objContasconscf->subfuncao;
                            $obalancete20->si187_naturezadespesa = $objContasconscf->naturezadespesa;
                            $obalancete20->si187_subelemento = $objContasconscf->subelemento;
                            $obalancete20->si187_codfontrecursos = $objContasconscf->codfontrecursos;
                            $obalancete20->si187_saldoinicialconscf = $oReg20Saldo->saldoanterior;
                            $obalancete20->si187_naturezasaldoinicialconscf = $oReg20Saldo->saldoanterior >= 0 ? 'D' : 'C';
                            $obalancete20->si187_totaldebitosconscf = abs($oReg20Saldo->debitos);
                            $obalancete20->si187_totalcreditosconscf = abs($oReg20Saldo->creditos);
                            $obalancete20->si187_saldofinalconscf = abs(($oReg20Saldo->saldoanterior + $oReg20Saldo->debitos - $oReg20Saldo->creditos) == '' ? 0 : ($oReg20Saldo->saldoanterior + $oReg20Saldo->debitos - $oReg20Saldo->creditos));
                            $obalancete20->si187_naturezasaldofinalconscf = ($oReg20Saldo->saldoanterior + $oReg20Saldo->debitos - $oReg20Saldo->creditos) >= 0 ? 'D' : 'C';
                            $obalancete20->si187_instit = db_getsession("DB_instit");
                            $obalancete20->si187_mes = $nMes;

                            $aContasReg10[$reg10Hash]->reg20[$sHash20] = $obalancete20;
                        } else {
                            $aContasReg10[$reg10Hash]->reg20[$sHash20]->si187_saldoinicialconscf += $oReg20Saldo->saldoanterior;
                            $aContasReg10[$reg10Hash]->reg20[$sHash20]->si187_totaldebitosconscf += $oReg20Saldo->debitos;
                            $aContasReg10[$reg10Hash]->reg20[$sHash20]->si187_totalcreditosconscf += $oReg20Saldo->creditos;
                            $aContasReg10[$reg10Hash]->reg20[$sHash20]->si187_saldofinalconscf += abs(($oReg20Saldo->saldoanterior + $oReg20Saldo->debitos - $oReg20Saldo->creditos) == '' ? 0 : ($oReg20Saldo->saldoanterior + $oReg20Saldo->debitos - $oReg20Saldo->creditos));
                            $aContasReg10[$reg10Hash]->reg20[$sHash20]->si187_naturezasaldofinalconscf = $aContasReg10[$reg10Hash]->reg20[$sHash20]->si187_saldofinalconscf >= 0 ? 'D' : 'C';
                        }
                    }
                }
            }

            /*
             * DADOS PARA GERAÇÃO DO REGISTRO 21 Identificação do Consórcio e Fonte de Recursos*
             * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 21
             * @todo: validar SQL, definir contacorrente
             */

            if ($oContas10->nregobrig == 21) {

                /*
                 * Buscar o vinculo da conta pcasp com o plano orçamentário
                 *
                 * */
                $sSqlconsorfr = "";

                $rsSqlconsorfr = db_query($sSqlconsorfr);

                /*
                 * Constante da contacorrente que indica o superavit financeiro
                 *
                 */
                $nContaCorrente = null;

                for ($iContconsorfr = 0; $iContconsorfr < pg_num_rows($rsSqlconsorfr); $iContconsorfr++) {

                    $objContasconsorfr = db_utils::fieldsMemory($rsSqlconsorfr, $iContconsorfr);

                    /*
                     * Verifica os saldos de cada estrutural do orçamento vinculado ao PCASP
                     * @todo: criar sql e validar filtro de busca
                     */

                    $sSqlReg21saldos = "";

                    $rsReg21saldos = db_query($sSqlReg21saldos);

                    for ($iContSaldo21 = 0; $iContSaldo21 < pg_num_rows($rsReg21saldos); $iContSaldo21++) {

                        $oReg21Saldo = db_utils::fieldsMemory($rsReg21saldos, $iContSaldo21);

                        $sHash21 = '21' . $oContas10->si217_contacontaabil . $objContasconsorfr->cnpjconsorfrcio . $objContasconsorfr->codfontrecursos;

                        if (!isset($aContasReg10[$reg10Hash]->reg21[$sHash21])) {

                            $obalancete21 = new stdClass();

                            $obalancete21->si188_tiporegistro = 21;
                            $obalancete21->si188_contacontabil = $oContas10->si177_contacontaabil;
                            $obalancete21->si188_codfundo = $sCodFundo;
                            $obalancete21->si188_cnpjconsorfrcio = $objContasconsorfr->cnpjconsorfrcio;
                            $obalancete21->si188_codfontrecursos = $objContasconsorfr->codfontrecursos;
                            $obalancete21->si188_saldoinicialconsorfr = $oReg21Saldo->saldoanterior;
                            $obalancete21->si188_naturezasaldoinicialconsorfr = $oReg21Saldo->saldoanterior >= 0 ? 'D' : 'C';
                            $obalancete21->si188_totaldebitosconsorfr = abs($oReg21Saldo->debitos);
                            $obalancete21->si188_totalcreditosconsorfr = abs($oReg21Saldo->creditos);
                            $obalancete21->si188_saldofinalconsorfr = abs(($oReg21Saldo->saldoanterior + $oReg21Saldo->debitos - $oReg21Saldo->creditos) == '' ? 0 : ($oReg21Saldo->saldoanterior + $oReg21Saldo->debitos - $oReg21Saldo->creditos));
                            $obalancete21->si188_naturezasaldofinalconsorfr = ($oReg21Saldo->saldoanterior + $oReg21Saldo->debitos - $oReg21Saldo->creditos) >= 0 ? 'D' : 'C';
                            $obalancete21->si188_instit = db_getsession("DB_instit");
                            $obalancete21->si188_mes = $nMes;

                            $aContasReg10[$reg10Hash]->reg21[$sHash21] = $obalancete21;
                        } else {
                            $aContasReg10[$reg10Hash]->reg21[$sHash21]->si188_saldoinicialconsorfr += $oReg21Saldo->saldoanterior;
                            $aContasReg10[$reg10Hash]->reg21[$sHash21]->si188_totaldebitosconsorfr += $oReg21Saldo->debitos;
                            $aContasReg10[$reg10Hash]->reg21[$sHash21]->si188_totalcreditosconsorfr += $oReg21Saldo->creditos;
                            $aContasReg10[$reg10Hash]->reg21[$sHash21]->si188_saldofinalconsorfr += abs(($oReg21Saldo->saldoanterior + $oReg21Saldo->debitos - $oReg21Saldo->creditos) == '' ? 0 : ($oReg21Saldo->saldoanterior + $oReg21Saldo->debitos - $oReg21Saldo->creditos));
                            $aContasReg10[$reg10Hash]->reg21[$sHash21]->si188_naturezasaldofinalconsorfr = $aContasReg10[$reg10Hash]->reg21[$sHash21]->si188_saldofinalconsorfr >= 0 ? 'D' : 'C';
                        }
                    }
                }
            }

            /*
             * DADOS PARA GERAÇÃO DO REGISTRO 22 Conta Bancária e Atributo SF (Somente F)
             * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 22
             * @todo: validar SQL, definir nContacorrente
             */

            if ($oContas10->nregobrig == 22) {

                /*
                 * Buscar o vinculo da conta pcasp com o plano orçamentário
                 *
                 * */
                $sSqlctbsf = "";

                $rsSqlctbsf = db_query($sSqlctbsf);

                /*
                 * Constante da contacorrente que indica o superavit financeiro
                 *
                 */
                $nContaCorrente = 2;

                for ($iContctbsf = 0; $iContctbsf < pg_num_rows($rsSqlctbsf); $iContctbsf++) {

                    $objContasctbsf = db_utils::fieldsMemory($rsSqlctbsf, $iContctbsf);

                    /*
                     * Verifica os saldos de cada estrutural do orçamento vinculado ao PCASP
                     * @todo: criar sql e validar filtro de busca
                     */

                    $sSqlReg22saldos = "";

                    $rsReg22saldos = db_query($sSqlReg22saldos);

                    for ($iContSaldo22 = 0; $iContSaldo22 < pg_num_rows($rsReg22saldos); $iContSaldo22++) {

                        $oReg22Saldo = db_utils::fieldsMemory($rsReg22saldos, $iContSaldo22);

                        $sHash22 = '22' . $oContas10->si227_contacontaabil . $objContasctbsf->atributosf . $objContasctbsf->codctb;

                        if (!isset($aContasReg10[$reg10Hash]->reg22[$sHash22])) {

                            $obalancete22 = new stdClass();

                            $obalancete22->si189_tiporegistro = 22;
                            $obalancete22->si189_contacontabil = $oContas10->si177_contacontaabil;
                            $obalancete22->si189_codfundo = $sCodFundo;
                            $obalancete22->si189_atributosf = $objContasctbsf->atributosf;
                            $obalancete22->si189_codctb = $objContasctbsf->codctb;
                            $obalancete22->si189_saldoinicialctbsf = $oReg22Saldo->saldoanterior;
                            $obalancete22->si189_naturezasaldoinicialctbsf = $oReg22Saldo->saldoanterior >= 0 ? 'D' : 'C';
                            $obalancete22->si189_totaldebitosctbsf = abs($oReg22Saldo->debitos);
                            $obalancete22->si189_totalcreditosctbsf = abs($oReg22Saldo->creditos);
                            $obalancete22->si189_saldofinalctbsf = abs(($oReg22Saldo->saldoanterior + $oReg22Saldo->debitos - $oReg22Saldo->creditos) == '' ? 0 : ($oReg22Saldo->saldoanterior + $oReg22Saldo->debitos - $oReg22Saldo->creditos));
                            $obalancete22->si189_naturezasaldofinalctbsf = ($oReg22Saldo->saldoanterior + $oReg22Saldo->debitos - $oReg22Saldo->creditos) >= 0 ? 'D' : 'C';
                            $obalancete22->si189_instit = db_getsession("DB_instit");
                            $obalancete22->si189_mes = $nMes;

                            $aContasReg10[$reg10Hash]->reg22[$sHash22] = $obalancete22;
                        } else {
                            $aContasReg10[$reg10Hash]->reg22[$sHash22]->si189_saldoinicialctbsf += $oReg22Saldo->saldoanterior;
                            $aContasReg10[$reg10Hash]->reg22[$sHash22]->si189_totaldebitosctbsf += $oReg22Saldo->debitos;
                            $aContasReg10[$reg10Hash]->reg22[$sHash22]->si189_totalcreditosctbsf += $oReg22Saldo->creditos;
                            $aContasReg10[$reg10Hash]->reg22[$sHash22]->si189_saldofinalctbsf += abs(($oReg22Saldo->saldoanterior + $oReg22Saldo->debitos - $oReg22Saldo->creditos) == '' ? 0 : ($oReg22Saldo->saldoanterior + $oReg22Saldo->debitos - $oReg22Saldo->creditos));
                            $aContasReg10[$reg10Hash]->reg22[$sHash22]->si189_naturezasaldofinalctbsf = $aContasReg10[$reg10Hash]->reg22[$sHash22]->si189_saldofinalctbsf >= 0 ? 'D' : 'C';

                        }
                    }
                }
            }

            /*
             * DADOS PARA GERAÇÃO DO REGISTRO 24 Orgao
             * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 24
             *
             */

            if ($oContas10->nregobrig == 24) {

                /*
                 * Constante da contacorrente que indica o orgao
                 */

                $nContaCorrente = 3;

                $sSqlReg24saldos = "SELECT
                                          (SELECT round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) AS saldoinicial
                                           FROM
                                             (SELECT
                                                (SELECT SUM(saldoanterior) AS saldoanterior FROM
                                                    (SELECT CASE WHEN c29_debito > 0 THEN c29_debito WHEN c29_credito > 0 THEN -1 * c29_credito ELSE 0 END AS saldoanterior
                                                     FROM contacorrente
                                                     INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                                     INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial
                                                     AND contacorrentesaldo.c29_mesusu = 0 and contacorrentesaldo.c29_anousu = " . db_getsession("DB_anousu") . " and c19_conplanoreduzanousu = " . db_getsession("DB_anousu") . "
                                                     AND c19_instit = " . db_getsession('DB_instit') . "
                                                     AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                                       AND c17_sequencial = {$nContaCorrente}) as x) AS saldoimplantado,

                                                (SELECT sum(c69_valor) AS debito
                                                 FROM conlancamval
                                                   INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                                   AND conlancam.c70_anousu = conlancamval.c69_anousu
                                                   INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                                   INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                                   INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                                   INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                                   WHERE c28_tipo = 'D'
                                                     AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                                                     AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                                     AND c19_contacorrente = {$nContaCorrente}
                                                     AND c19_instit = " . db_getsession('DB_instit') . "
                                                     AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                                     {$sWhereEncerramento}
                                                   GROUP BY c28_tipo) AS debitoatual,

                                                (SELECT sum(c69_valor) AS credito
                                                 FROM conlancamval
                                                   INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                                   AND conlancam.c70_anousu = conlancamval.c69_anousu
                                                   INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                                   INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                                   INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                                   INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                                   WHERE c28_tipo = 'C'
                                                     AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                                                     AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                                     AND c19_contacorrente = {$nContaCorrente}
                                                     AND c19_instit = " . db_getsession('DB_instit') . "
                                                     AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                                     {$sWhereEncerramento}
                                                   GROUP BY c28_tipo) AS creditoatual) AS movi) AS saldoanterior,

                                          (SELECT sum(c69_valor)
                                           FROM conlancamval
                                           INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                           AND conlancam.c70_anousu = conlancamval.c69_anousu
                                           INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                           INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                           INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                           INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                           WHERE c28_tipo = 'C'
                                             AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                             AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                             AND c19_contacorrente = {$nContaCorrente}
                                             AND c19_instit = " . db_getsession('DB_instit') . "
                                             AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                             {$sWhereEncerramento}
                                           GROUP BY c28_tipo) AS creditos,

                                          (SELECT sum(c69_valor)
                                           FROM conlancamval
                                           INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                           AND conlancam.c70_anousu = conlancamval.c69_anousu
                                           INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                           INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                           INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                           INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                           WHERE c28_tipo = 'D'
                                             AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                             AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                             AND c19_contacorrente = {$nContaCorrente}
                                             AND c19_instit = " . db_getsession('DB_instit') . "
                                             AND c19_reduz IN (" . implode(',', $oContas10->contas) . ")
                                             {$sWhereEncerramento}
                                           GROUP BY c28_tipo) AS debitos";

                $rsReg24saldos = db_query($sSqlReg24saldos);

                for ($iContSaldo24 = 0; $iContSaldo24 < pg_num_rows($rsReg24saldos); $iContSaldo24++) {

                    $oReg24Saldo = db_utils::fieldsMemory($rsReg24saldos, $iContSaldo24);

                    if (!(($oReg24Saldo->saldoanterior == "" || $oReg24Saldo->saldoanterior == 0) && $oReg24Saldo->debitos == "" && $oReg24Saldo->creditos == "")) {

                        $sHash24 = '24' . $oContas10->si177_contacontaabil . $objContasorgao->codorgao;

                        if (!isset($aContasReg10[$reg10Hash]->reg24[$sHash24])) {

                            $obalancete24 = new stdClass();

                            $obalancete24->si191_tiporegistro = 24;
                            $obalancete24->si191_contacontabil = $oContas10->si177_contacontaabil;
                            $obalancete24->si191_codfundo = $sCodFundo;
                            if($this->getTipoinstit(db_getsession("DB_instit")) == 2){
                                $obalancete24->si191_codorgao = $this->getCodOrgaoTce(1);
                                $obalancete24->si191_codunidadesub = $this->getCodUnidadeTce(1);
                            }elseif ($this->getTipoinstit(db_getsession("DB_instit")) == 1){
                                $obalancete24->si191_codorgao = $this->getCodOrgaoTce(2);
                                $obalancete24->si191_codunidadesub = $this->getCodUnidadeTce(2);
                            }else{
                                $obalancete24->si191_codorgao = "00";
                                $obalancete24->si191_codunidadesub = "00000000";
                            }
                            $obalancete24->si191_saldoinicialorgao = $oReg24Saldo->saldoanterior;
                            $obalancete24->si191_naturezasaldoinicialorgao = $oReg24Saldo->saldoanterior >= 0 ? 'D' : 'C';
                            $obalancete24->si191_totaldebitosorgao = $oReg24Saldo->debitos;
                            $obalancete24->si191_totalcreditosorgao = $oReg24Saldo->creditos;
                            $obalancete24->si191_saldofinalorgao = ($oReg24Saldo->saldoanterior + $oReg24Saldo->debitos - $oReg24Saldo->creditos) == '' ? 0 : ($oReg24Saldo->saldoanterior + $oReg24Saldo->debitos - $oReg24Saldo->creditos);
                            $obalancete24->si191_naturezasaldofinalorgao = ($oReg24Saldo->saldoanterior + $oReg24Saldo->debitos - $oReg24Saldo->creditos) >= 0 ? 'D' : 'C';
                            $obalancete24->si191_instit = db_getsession("DB_instit");
                            $obalancete24->si191_mes = $nMes;

                            $aContasReg10[$reg10Hash]->reg24[$sHash24] = $obalancete24;
                        } else {

                            $aContasReg10[$reg10Hash]->reg24[$sHash24]->si191_saldoinicialorgao += $oReg24Saldo->saldoanterior;
                            $aContasReg10[$reg10Hash]->reg24[$sHash24]->si191_totaldebitosorgao += $oReg24Saldo->debitos;
                            $aContasReg10[$reg10Hash]->reg24[$sHash24]->si191_totalcreditosorgao += $oReg24Saldo->creditos;
                            $aContasReg10[$reg10Hash]->reg24[$sHash24]->si191_saldofinalorgao += ($oReg24Saldo->saldoanterior + $oReg24Saldo->debitos - $oReg24Saldo->creditos) == '' ? 0 : ($oReg24Saldo->saldoanterior + $oReg24Saldo->debitos - $oReg24Saldo->creditos);
                            $aContasReg10[$reg10Hash]->reg24[$sHash24]->si191_naturezasaldofinalorgao = $aContasReg10[$reg10Hash]->reg24[$sHash24]->si191_saldofinalorgao >= 0 ? 'D' : 'C';
                            $aContasReg10[$reg10Hash]->reg24[$sHash24]->si191_naturezasaldoinicialorgao = $aContasReg10[$reg10Hash]->reg24[$sHash24]->si191_saldoinicialorgao >= 0 ? 'D' : 'C';
                        }
                    }
                }

            }

            /*
             * DADOS PARA GERAÇÃO DO REGISTRO 25 Orgao
             * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 25
             *
             */

            if($oContas10->nregobrig == 25){

                foreach ($oContas10->contas as $oReduz) {

                    $sSqlReg25saldos = "SELECT
                                               round(substr(fc_planosaldonovo,3,14)::float8,2)::float8 AS anterior,
                                               round(substr(fc_planosaldonovo,17,14)::float8,2)::float8 AS debitos,
                                               round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 AS creditos,
                                               round(substr(fc_planosaldonovo,45,14)::float8,2)::float8 AS saldo_final,
                                               substr(fc_planosaldonovo,59,1)::varchar(1) AS naturezasaldoinicialnrsf,
                                               substr(fc_planosaldonovo,60,1)::varchar(1) AS naturezasaldofinalnrsf,
                                               c60_estrut,
                                               identificadorfinanceiro
                                        FROM
                                          (SELECT p.c60_estrut AS estrut_mae,
                                                  p.c60_estrut AS estrut,
                                                  c61_reduz,
                                                  c61_codcon,
                                                  c61_codigo,
                                                  p.c60_descr,
                                                  p.c60_finali,
                                                  r.c61_instit,
                                                  fc_planosaldonovo(" . db_getsession('DB_anousu') . ",c61_reduz,'" . $this->sDataInicial . "','" . $this->sDataFinal . "',$sEncerramento),
                                                  p.c60_identificadorfinanceiro as identificadorfinanceiro,
                                                  p.c60_consistemaconta,
                                                  o.c60_estrut
                                           FROM conplanoexe e
                                           INNER JOIN conplanoreduz r ON r.c61_anousu = c62_anousu
                                           AND r.c61_reduz = c62_reduz
                                           INNER JOIN conplano p ON r.c61_codcon = p.c60_codcon
                                           AND r.c61_anousu = p.c60_anousu
                                           INNER JOIN conplanoorcamento o ON o.c60_codcon = p.c60_naturezadareceita AND o.c60_anousu = p.c60_anousu
                                           LEFT OUTER JOIN consistema ON p.c60_codsis = c52_codsis
                                           WHERE c62_anousu = " . db_getsession('DB_anousu') . "
                                             AND c61_instit IN (" . db_getsession('DB_instit') . ")
                                             AND c61_reduz = {$oReduz}) as x";

                    $rsReg25saldos = db_query($sSqlReg25saldos) or die($sSqlReg25saldos);

                    for ($iContSaldo25 = 0; $iContSaldo25 < pg_num_rows($rsReg25saldos); $iContSaldo25++) {

                        $oReg25Saldo = db_utils::fieldsMemory($rsReg25saldos, $iContSaldo25);

                        $sHash25 = '25' . $oContas10->si177_contacontaabil . '00000000' . $oContas10->identificadorfinanceiro.substr($oReg25Saldo->c60_estrut,1,8);

                        $oReg25Saldo->anterior = $oReg25Saldo->naturezasaldoinicialnrsf == 'C' ? $oReg25Saldo->anterior * -1 : $oReg25Saldo->anterior;

                        if (!isset($aContasReg10[$reg10Hash]->reg25[$sHash25])) {

                            $obalancete25 = new stdClass();
                            $obalancete25->si195_tiporegistro = 25;
                            $obalancete25->si195_contacontabil = $oContas10->si177_contacontaabil;
                            $obalancete25->si195_codfundo = $sCodFundo;
                            $obalancete25->si195_atributosf = $oContas10->identificadorfinanceiro;
                            $obalancete25->si195_naturezareceita = substr($oReg25Saldo->c60_estrut,1,8);
                            $obalancete25->si195_saldoinicialnrsf = $oReg25Saldo->anterior;
                            $obalancete25->si195_naturezasaldoinicialnrsf = $obalancete25->si195_saldoinicialnrsf >= 0 ? 'D' : 'C';
                            $obalancete25->si195_totaldebitosnrsf = $oReg25Saldo->debitos;
                            $obalancete25->si195_totalcreditosnrsf = $oReg25Saldo->creditos;
                            $obalancete25->si195_saldofinalnrsf = $oReg25Saldo->anterior + $oReg25Saldo->debitos - $oReg25Saldo->creditos;
                            $obalancete25->si195_naturezasaldofinalnrsf = $obalancete25->si195_saldofinalnrsf >= 0 ? 'D' : 'C';
                            $obalancete25->si195_instit = db_getsession("DB_instit");
                            $obalancete25->si195_mes = $nMes;
                            $aContasReg10[$reg10Hash]->reg25[$sHash25] = $obalancete25;
                        } else {
                            $aContasReg10[$reg10Hash]->reg25[$sHash25]->si195_saldoinicialnrsf += $oReg25Saldo->anterior;
                            $aContasReg10[$reg10Hash]->reg25[$sHash25]->si195_totaldebitosnrsf += $oReg25Saldo->debitos;
                            $aContasReg10[$reg10Hash]->reg25[$sHash25]->si195_totalcreditosnrsf += $oReg25Saldo->creditos;
                            $aContasReg10[$reg10Hash]->reg25[$sHash25]->si195_saldofinalnrsf += ($oReg25Saldo->anterior + $oReg25Saldo->debitos - $oReg25Saldo->creditos) == '' ? 0 : ($oReg25Saldo->anterior + $oReg25Saldo->debitos - $oReg25Saldo->creditos);
                            $aContasReg10[$reg10Hash]->reg25[$sHash25]->si195_naturezasaldofinalnrsf = ($aContasReg10[$reg10Hash]->reg25[$sHash25]->si195_saldofinalnrsf >= 0 ? 'D' : 'C');
                            $aContasReg10[$reg10Hash]->reg25[$sHash25]->si195_naturezasaldoinicialnrsf = ($aContasReg10[$reg10Hash]->reg25[$sHash25]->si195_saldoinicialnrsf >= 0 ? 'D' : 'C');
                        }
                    }
                }

            }

            /*
            * DADOS PARA GERAÇÃO DO REGISTRO 26 Atributo de Superávit Financeiro,
            * SOMENTE CONTAS QUE O NUMERO REGISTRO SEJA IGUAL A 26 OU 15
            *
            */

            if ($oContas10->nregobrig == 26) {

                /*
                 * Busca os saldos das contas pelo reduzido na função fc_saltessaldo();
                 * */
                foreach ($oContas10->contas as $oReduz) {

                    $sSqlReg26saldos = "SELECT
                                               round(substr(fc_planosaldonovo,3,14)::float8,2)::float8 AS anterior,
                                               round(substr(fc_planosaldonovo,17,14)::float8,2)::float8 AS debitos,
                                               round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 AS creditos,
                                               round(substr(fc_planosaldonovo,45,14)::float8,2)::float8 AS saldo_final,
                                               substr(fc_planosaldonovo,59,1)::varchar(1) AS naturezasaldoinicialsf,
                                               substr(fc_planosaldonovo,60,1)::varchar(1) AS naturezasaldofinalsf,
                                               nrodocumentopessoaatributosf,z01_numcgm,
                                               identificadorfinanceiro
                                        FROM
                                          (SELECT p.c60_estrut AS estrut_mae,
                                                  p.c60_estrut AS estrut,
                                                  c61_reduz,
                                                  c61_codcon,
                                                  c61_codigo,
                                                  p.c60_descr,
                                                  p.c60_finali,
                                                  r.c61_instit,
                                                  fc_planosaldonovo(" . db_getsession('DB_anousu') . ",c61_reduz,'" . $this->sDataInicial . "','" . $this->sDataFinal . "',$sEncerramento),
                                                  p.c60_identificadorfinanceiro as identificadorfinanceiro,
                                                  c60_consistemaconta,
                                                  cgm.z01_cgccpf as nrodocumentopessoaatributosf,z01_numcgm
                                           FROM conplanoexe e
                                           INNER JOIN conplanoreduz r ON r.c61_anousu = c62_anousu
                                           AND r.c61_reduz = c62_reduz
                                           INNER JOIN conplano p ON r.c61_codcon = c60_codcon
                                           AND r.c61_anousu = c60_anousu
                                           LEFT OUTER JOIN consistema ON c60_codsis = c52_codsis
                                           LEFT JOIN cgm ON p.c60_cgmpessoa = cgm.z01_numcgm
                                           WHERE c62_anousu = " . db_getsession('DB_anousu') . "
                                             AND c61_instit IN (" . db_getsession('DB_instit') . ")
                                             AND c61_reduz = {$oReduz}) as x";

                    $rsReg26saldos = db_query($sSqlReg26saldos) or die($sSqlReg26saldos." ".pg_last_error());
                    //db_criatabela($rsReg26saldos);die($sSqlReg26saldos);

                    for ($iContSaldo26 = 0; $iContSaldo26 < pg_num_rows($rsReg26saldos); $iContSaldo26++) {

                        $oReg26Saldo = db_utils::fieldsMemory($rsReg26saldos, $iContSaldo26);

                        $sHash26 = '26' . $oContas10->si177_contacontaabil . $oContas10->identificadorfinanceiro . $oReg26Saldo->nrodocumentopessoaatributosf;

                        $oReg26Saldo->anterior = $oReg26Saldo->naturezasaldoinicialsf == 'C' ? $oReg26Saldo->anterior * -1 : $oReg26Saldo->anterior;

                        if (!isset($aContasReg10[$reg10Hash]->reg26[$sHash26])) {

                            $obalancete26 = new stdClass();
                            $obalancete26->si196_tiporegistro = 26;
                            $obalancete26->si196_contacontabil = $oContas10->si177_contacontaabil;
                            $obalancete26->si196_codfundo = $sCodFundo;
                            $obalancete26->si196_tipodocumentopessoaatributosf = strlen($oReg26Saldo->nrodocumentopessoaatributosf) > 11 ? 2 : 1;
                            $obalancete26->si196_nrodocumentopessoaatributosf = $oReg26Saldo->nrodocumentopessoaatributosf;
                            $obalancete26->si196_atributosf = $oContas10->identificadorfinanceiro;
                            $obalancete26->si196_saldoinicialpessoaatributosf = $oReg26Saldo->anterior;
                            $obalancete26->si196_naturezasaldoinicialpessoaatributosf = $obalancete26->anterior >= 0 ? 'D' : 'C';
                            $obalancete26->si196_totaldebitospessoaatributosf = $oReg26Saldo->debitos;
                            $obalancete26->si196_totalcreditospessoaatributosf = $oReg26Saldo->creditos;
                            $obalancete26->si196_saldofinalpessoaatributosf = $oReg26Saldo->anterior + $oReg26Saldo->debitos - $oReg26Saldo->creditos;
                            $obalancete26->si196_naturezasaldofinalpessoaatributosf = $obalancete26->si196_saldofinalpessoaatributosf >= 0 ? 'D' : 'C';
                            $obalancete26->si196_instit = db_getsession("DB_instit");
                            $obalancete26->si196_mes = $nMes;

                            $aContasReg10[$reg10Hash]->reg26[$sHash26] = $obalancete26;

                        } else {
                            $aContasReg10[$reg10Hash]->reg26[$sHash26]->si196_saldoinicialpessoaatributosf += $oReg26Saldo->anterior;
                            $aContasReg10[$reg10Hash]->reg26[$sHash26]->si196_totaldebitospessoaatributosf += $oReg26Saldo->debitos;
                            $aContasReg10[$reg10Hash]->reg26[$sHash26]->si196_totalcreditospessoaatributosf += $oReg26Saldo->creditos;
                            $aContasReg10[$reg10Hash]->reg26[$sHash26]->si196_saldofinalpessoaatributosf += ($oReg26Saldo->anterior + $oReg26Saldo->debitos - $oReg26Saldo->creditos) == '' ? 0 : ($oReg26Saldo->anterior + $oReg26Saldo->debitos - $oReg26Saldo->creditos);
                            $aContasReg10[$reg10Hash]->reg26[$sHash26]->si196_naturezasaldofinalpessoaatributosf = ($aContasReg10[$reg10Hash]->reg26[$sHash26]->si196_saldofinalpessoaatributosf >= 0 ? 'D' : 'C');
                            $aContasReg10[$reg10Hash]->reg26[$sHash26]->si196_naturezasaldoinicialpessoaatributosf = ($aContasReg10[$reg10Hash]->reg26[$sHash26]->si196_saldoinicialpessoaatributosf >= 0 ? 'D' : 'C');
                        }
                    }
                }
            }

        }

        if(db_getsession("DB_anousu")==2021){
            $sSqlEncerradas = "select distinct si95_reduz,si95_codtceant from  acertactb
        join conplanoreduz on c61_reduz = si95_reduz and c61_anousu = ".db_getsession("DB_anousu")."
         join infocomplementaresinstit on c61_instit = si09_instit and si09_instit = ".db_getsession("DB_instit")." order by si95_reduz desc";
            $rsEncerradas = db_query($sSqlEncerradas);
            $aEncerradas = array();
            $aEncerradas['si95_reduz'][]     = array();
            $aEncerradas['si95_codtceant'][] = array();
            if (pg_num_rows($rsEncerradas) != 0) {
                for ($iCont = 0; $iCont < pg_num_rows($rsEncerradas); $iCont++) {

                    $oEncerradas = db_utils::fieldsMemory($rsEncerradas, $iCont);
                    $aEncerradas['si95_reduz'][$oEncerradas->si95_codtceant]     = $oEncerradas->si95_reduz;
                    $aEncerradas['si95_codtceant'][] = $oEncerradas->si95_codtceant;

                }
            }
        }

        /*
        * DESAGRUPANDO O REGISTRO 10 PARA INSERIR NAS TABELAS DO SICOM
        */

        foreach ($aContasReg10 as $oDado10) {

            $obalancete10 = new cl_balancete102021();

            $obalancete10->si177_tiporegistro = $oDado10->si177_tiporegistro;
            $obalancete10->si177_contacontaabil = $oDado10->si177_contacontaabil;
            $obalancete10->si177_codfundo = $sCodFundo;
            $obalancete10->si177_saldoinicial = number_format(abs($oDado10->si177_saldoinicial), 2, '.', '');
            $obalancete10->si177_naturezasaldoinicial = $oDado10->si177_saldoinicial == 0 ? $oDado10->naturezasaldo : ($oDado10->si177_saldoinicial > 0 ? 'D' : 'C');
            $obalancete10->si177_totaldebitos = number_format(abs($oDado10->si177_totaldebitos), 2, '.', '');
            $obalancete10->si177_totalcreditos = number_format(abs($oDado10->si177_totalcreditos), 2, '.', '');
            $obalancete10->si177_saldofinal = number_format(abs($oDado10->si177_saldofinal), 2, '.', '');
            $obalancete10->si177_naturezasaldofinal = $obalancete10->si177_saldofinal == 0 ? $obalancete10->si177_naturezasaldoinicial : ($oDado10->si177_saldofinal > 0 ? 'D' : 'C');
            $obalancete10->si177_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $obalancete10->si177_instit = db_getsession("DB_instit");

            $obalancete10->incluir(null);

            if ($obalancete10->erro_status == 0) {
                throw new Exception($obalancete10->erro_msg);
            }

            foreach ($oDado10->reg11 as $reg11) {

                $obalreg11 = new cl_balancete112021();

                $obalreg11->si178_tiporegistro = $reg11->si178_tiporegistro;
                $obalreg11->si178_contacontaabil = $reg11->si178_contacontaabil;
                $obalreg11->si178_codfundo = $sCodFundo;
                $obalreg11->si178_codorgao = $reg11->si178_codorgao;
                $obalreg11->si178_codunidadesub = $reg11->si178_codunidadesub;
                $obalreg11->si178_codfuncao = $reg11->si178_codfuncao;
                $obalreg11->si178_codsubfuncao = $reg11->si178_codsubfuncao;
                $obalreg11->si178_codprograma = $reg11->si178_codprograma;
                $obalreg11->si178_idacao = $reg11->si178_idacao;
                $obalreg11->si178_idsubacao = $reg11->si178_idsubacao;
                $obalreg11->si178_naturezadespesa = $reg11->si178_naturezadespesa;
                $obalreg11->si178_codfontrecursos = $reg11->si178_codfontrecursos;
                $obalreg11->si178_saldoinicialcd = number_format(abs($reg11->si178_saldoinicialcd == '' ? 0 : $reg11->si178_saldoinicialcd), 2, ".", "");
                $obalreg11->si178_naturezasaldoinicialcd = $reg11->si178_saldoinicialcd == 0 ? $oDado10->naturezasaldo : ($reg11->si178_saldoinicialcd > 0 ? 'D' : 'C');
                $obalreg11->si178_totaldebitoscd = number_format(abs($reg11->si178_totaldebitoscd), 2, ".", "");
                $obalreg11->si178_totalcreditoscd = number_format(abs($reg11->si178_totalcreditoscd), 2, ".", "");
                $saldoFinal = ($reg11->si178_saldoinicialcd + $reg11->si178_totaldebitoscd - $reg11->si178_totalcreditoscd) == '' ? 0 : ($reg11->si178_saldoinicialcd + $reg11->si178_totaldebitoscd - $reg11->si178_totalcreditoscd);
                $obalreg11->si178_saldofinalcd = number_format(abs($saldoFinal == '' ? 0 : $saldoFinal), 2, ".", "");
                $obalreg11->si178_naturezasaldofinalcd = $saldoFinal == 0 ? $obalreg11->si178_naturezasaldoinicialcd : ($saldoFinal > 0 ? 'D' : 'C');
                $obalreg11->si178_instit = $reg11->si178_instit;
                $obalreg11->si178_mes = $reg11->si178_mes;
                $obalreg11->si178_reg10 = $obalancete10->si177_sequencial;

                $obalreg11->incluir(null);

                if ($obalreg11->erro_status == 0) {
                    throw new Exception($obalreg11->erro_msg);
                }
            }

            foreach ($oDado10->reg12 as $reg12) {

                $obalreg12 = new cl_balancete122021();

                $obalreg12->si179_tiporegistro = $reg12->si179_tiporegistro;
                $obalreg12->si179_contacontabil = $reg12->si179_contacontabil;
                $obalreg12->si179_codfundo = $sCodFundo;
                $obalreg12->si179_naturezareceita = $reg12->si179_naturezareceita;
                $obalreg12->si179_codfontrecursos = $reg12->si179_codfontrecursos;
                $obalreg12->si179_saldoinicialcr = number_format(abs($reg12->si179_saldoinicialcr == '' ? 0 : $reg12->si179_saldoinicialcr), 2, ".", "");
                $obalreg12->si179_naturezasaldoinicialcr = $reg12->si179_saldoinicialcr == 0 ? $oDado10->naturezasaldo : ($reg12->si179_saldoinicialcr > 0 ? 'D' : 'C');
                $obalreg12->si179_totaldebitoscr = number_format(abs($reg12->si179_totaldebitoscr), 2, ".", "");
                $obalreg12->si179_totalcreditoscr = number_format(abs($reg12->si179_totalcreditoscr), 2, ".", "");
                $saldoFinal = ($reg12->si179_saldoinicialcr + $reg12->si179_totaldebitoscr - $reg12->si179_totalcreditoscr) == '' ? 0 : ($reg12->si179_saldoinicialcr + $reg12->si179_totaldebitoscr - $reg12->si179_totalcreditoscr);
                $obalreg12->si179_saldofinalcr = number_format(abs($saldoFinal == '' ? 0 : $saldoFinal), 2, ".", "");
                $obalreg12->si179_naturezasaldofinalcr = $saldoFinal == 0 ? $obalreg12->si179_naturezasaldoinicialcr : ($saldoFinal > 0 ? 'D' : 'C');
                $obalreg12->si179_instit = $reg12->si179_instit;
                $obalreg12->si179_mes = $reg12->si179_mes;
                $obalreg12->si179_reg10 = $obalancete10->si177_sequencial;

                $obalreg12->incluir(null);

                if ($obalreg12->erro_status == 0) {
                    throw new Exception($obalreg12->erro_msg);
                }
            }

            foreach ($oDado10->reg13 as $reg13) {

                $obalreg13 = new cl_balancete132021();
                /*
                 * Contas do PPA
                 */
                if (in_array(substr($reg13->si180_contacontabil, 0, 5), array('51110','51120','61110','61120','61130'))) {

                    $obalreg13->si180_tiporegistro = $reg13->si180_tiporegistro;
                    $obalreg13->si180_contacontabil = $reg13->si180_contacontabil;
                    $obalreg13->si180_codfundo = $sCodFundo;
                    $obalreg13->si180_codprograma = $reg13->si180_codprograma;
                    $obalreg13->si180_idacao = $reg13->si180_idacao;
                    $obalreg13->si180_idsubacao = $reg13->si180_idsubacao;
                    $obalreg13->si180_saldoIniciaipa = number_format(abs($reg13->si180_saldoinicialpa == '' ? 0 : $reg13->si180_saldoinicialpa), 2, ".", "");
                    $obalreg13->si180_naturezasaldoIniciaipa = $reg13->si180_naturezasaldoinicialpa;
                    $obalreg13->si180_totaldebitospa = number_format(abs($reg13->si180_totaldebitospa), 2, ".", "");
                    $obalreg13->si180_totalcreditospa = number_format(abs($reg13->si180_totalcreditospa), 2, ".", "");
                    $obalreg13->si180_saldofinaipa = number_format(abs($reg13->si180_saldofinalpa == '' ? 0 : $reg13->si180_saldofinalpa), 2, ".", "");
                    $obalreg13->si180_naturezasaldofinaipa = $reg13->si180_naturezasaldofinalpa;

                } else {

                    $obalreg13->si180_tiporegistro = $reg13->si180_tiporegistro;
                    $obalreg13->si180_contacontabil = $reg13->si180_contacontabil;
                    $obalreg13->si180_codfundo = $sCodFundo;
                    $obalreg13->si180_codprograma = $reg13->si180_codprograma;
                    $obalreg13->si180_idacao = $reg13->si180_idacao;
                    $obalreg13->si180_idsubacao = $reg13->si180_idsubacao;
                    $obalreg13->si180_saldoIniciaipa = number_format(abs($reg13->si180_saldoinicialpa == '' ? 0 : $reg13->si180_saldoinicialpa), 2, ".", "");
                    $obalreg13->si180_naturezasaldoIniciaipa = $reg13->si180_saldoinicialpa == 0 ? $oDado10->naturezasaldo : ($reg13->si180_saldoinicialpa > 0 ? 'D' : 'C');
                    $obalreg13->si180_totaldebitospa = number_format(abs($reg13->si180_totaldebitospa), 2, ".", "");
                    $obalreg13->si180_totalcreditospa = number_format(abs($reg13->si180_totalcreditospa), 2, ".", "");
                    $saldoFinal = ($reg13->si180_saldoiniciaipa + $reg13->si180_totaldebitospa - $reg13->si180_totalcreditospa) == '' ? 0 : ($reg13->si180_saldoiniciaipa + $reg13->si180_totaldebitospa - $reg13->si180_totalcreditospa);
                    $obalreg13->si180_saldofinaipa = number_format(abs($saldoFinal == '' ? 0 : $saldoFinal), 2, ".", "");
                    $obalreg13->si180_naturezasaldofinaipa = $saldoFinal == 0 ? $obalreg13->si180_naturezasaldoIniciaipa : ($saldoFinal > 0 ? 'D' : 'C');
                }
                $obalreg13->si180_instit = $reg13->si180_instit;
                $obalreg13->si180_mes = $reg13->si180_mes;
                $obalreg13->si180_reg10 = $obalancete10->si177_sequencial;

                $obalreg13->incluir(null);

                if ($obalreg13->erro_status == 0) {
                    throw new Exception($obalreg13->erro_msg);
                }
            }

            foreach ($oDado10->reg14 as $reg14) {

                $obalreg14 = new cl_balancete142021();

                $obalreg14->si181_tiporegistro = $reg14->si181_tiporegistro;
                $obalreg14->si181_contacontabil = $reg14->si181_contacontabil;
                $obalreg14->si181_codfundo = $sCodFundo;
                $obalreg14->si181_codorgao = $reg14->si181_codorgao;
                $obalreg14->si181_codunidadesub = $reg14->si181_codunidadesub;
                $obalreg14->si181_codunidadesuborig = $reg14->si181_codunidadesuborig;
                $obalreg14->si181_codfuncao = $reg14->si181_codfuncao;
                $obalreg14->si181_codsubfuncao = $reg14->si181_codsubfuncao;
                $obalreg14->si181_codprograma = $reg14->si181_codprograma;
                $obalreg14->si181_idacao = $reg14->si181_idacao;
                $obalreg14->si181_idsubacao = $reg14->si181_idsubacao;
                $obalreg14->si181_naturezadespesa = $reg14->si181_naturezadespesa;
                $obalreg14->si181_subelemento = $reg14->si181_subelemento;
                $obalreg14->si181_codfontrecursos = $reg14->si181_codfontrecursos;
                $obalreg14->si181_nroempenho = $reg14->si181_nroempenho;
                $obalreg14->si181_anoinscricao = $reg14->si181_anoinscricao;
                $obalreg14->si181_saldoinicialrsp = number_format(abs($reg14->si181_saldoinicialrsp == '' ? 0 : $reg14->si181_saldoinicialrsp), 2, ".", "");
                $obalreg14->si181_naturezasaldoinicialrsp = $reg14->si181_saldoinicialrsp == 0 ? $oDado10->naturezasaldo : ($reg14->si181_saldoinicialrsp > 0 ? 'D' : 'C');
                $obalreg14->si181_totaldebitosrsp = number_format(abs($reg14->si181_totaldebitosrsp), 2, ".", "");
                $obalreg14->si181_totalcreditosrsp = number_format(abs($reg14->si181_totalcreditosrsp), 2, ".", "");
                $saldoFinal = ($reg14->si181_saldoinicialrsp + $reg14->si181_totaldebitosrsp - $reg14->si181_totalcreditosrsp) == '' ? 0 : ($reg14->si181_saldoinicialrsp + $reg14->si181_totaldebitosrsp - $reg14->si181_totalcreditosrsp);
                $obalreg14->si181_saldofinalrsp = number_format(abs($saldoFinal == '' ? 0 : $saldoFinal), 2, ".", "");
                $obalreg14->si181_naturezasaldofinalrsp = $saldoFinal == 0 ? $obalreg14->si181_naturezasaldoinicialrsp : ($saldoFinal > 0 ? 'D' : 'C');
                $obalreg14->si181_instit = $reg14->si181_instit;
                $obalreg14->si181_mes = $reg14->si181_mes;
                $obalreg14->si181_reg10 = $obalancete10->si177_sequencial;

                $obalreg14->incluir(null);

                if ($obalreg14->erro_status == 0) {
                    throw new Exception($obalreg14->erro_msg);
                }
            }
            foreach ($oDado10->reg15 as $reg15) {

                $obalreg15 = new cl_balancete152021();

                $obalreg15->si182_tiporegistro = $reg15->si182_tiporegistro;
                $obalreg15->si182_contacontabil = $reg15->si182_contacontabil;
                $obalreg15->si182_codfundo = $sCodFundo;
                $obalreg15->si182_atributosf = $reg15->si182_atributosf;
                $obalreg15->si182_saldoinicialsf = number_format(abs($reg15->si182_saldoinicialsf == '' ? 0 : $reg15->si182_saldoinicialsf), 2, ".", "");
                $obalreg15->si182_naturezasaldoinicialsf = $reg15->si182_saldoinicialsf == 0 ? $oDado10->naturezasaldo : ($reg15->si182_saldoinicialsf > 0 ? 'D' : 'C');
                $obalreg15->si182_totaldebitossf = number_format(abs($reg15->si182_totaldebitossf), 2, ".", "");
                $obalreg15->si182_totalcreditossf = number_format(abs($reg15->si182_totalcreditossf), 2, ".", "");
//
                $saldoFinal = ($reg15->si182_saldoinicialsf + $reg15->si182_totaldebitossf - $reg15->si182_totalcreditossf) == '' ? 0 : ($reg15->si182_saldoinicialsf + $reg15->si182_totaldebitossf - $reg15->si182_totalcreditossf);

                $obalreg15->si182_saldofinalsf = number_format(abs($saldoFinal), 2, ".", "");
                $obalreg15->si182_naturezasaldofinalsf = $obalancete10->si177_saldofinal == 0 ? $obalancete10->si177_naturezasaldoinicial : ($saldoFinal > 0 ? 'D' : 'C');//$obalreg15->si182_naturezasaldoinicialsf;
                $obalreg15->si182_instit = $reg15->si182_instit;
                $obalreg15->si182_mes = $reg15->si182_mes;
                $obalreg15->si182_reg10 = $obalancete10->si177_sequencial;

                $obalreg15->incluir(null);

                if ($obalreg15->erro_status == 0) {
                    throw new Exception($obalreg15->erro_msg);
                }
            }

            foreach ($oDado10->reg16 as $reg16) {

                $obalreg16 = new cl_balancete162021();

                $obalreg16->si183_tiporegistro = $reg16->si183_tiporegistro;
                $obalreg16->si183_contacontabil = $reg16->si183_contacontabil;
                $obalreg16->si183_codfundo = $sCodFundo;
                $obalreg16->si183_atributosf = $reg16->si183_atributosf;
                $obalreg16->si183_codfontrecursos = $reg16->si183_codfontrecursos;
                $obalreg16->si183_saldoinicialfontsf = number_format(abs($reg16->si183_saldoinicialfontsf == '' ? 0 : $reg16->si183_saldoinicialfontsf), 2, ".", "");
                $obalreg16->si183_naturezasaldoinicialfontsf = $reg16->si183_saldoinicialfontsf == 0 ? $oDado10->naturezasaldo : ($reg16->si183_saldoinicialfontsf > 0 ? 'D' : 'C');
                $obalreg16->si183_totaldebitosfontsf = number_format(abs($reg16->si183_totaldebitosfontsf), 2, ".", "");
                $obalreg16->si183_totalcreditosfontsf = number_format(abs($reg16->si183_totalcreditosfontsf), 2, ".", "");
                $saldoFinal = ($reg16->si183_saldoinicialfontsf + $reg16->si183_totaldebitosfontsf - $reg16->si183_totalcreditosfontsf) == '' ? 0 : ($reg16->si183_saldoinicialfontsf + $reg16->si183_totaldebitosfontsf - $reg16->si183_totalcreditosfontsf);
                $obalreg16->si183_saldofinalfontsf = number_format(abs($saldoFinal), 2, ".", "");
                $obalreg16->si183_naturezasaldofinalfontsf = $saldoFinal == 0 ? $obalreg16->si183_naturezasaldoinicialfontsf : ($saldoFinal > 0 ? 'D' : 'C');
                $obalreg16->si183_instit = $reg16->si183_instit;
                $obalreg16->si183_mes = $reg16->si183_mes;
                $obalreg16->si183_reg10 = $obalancete10->si177_sequencial;

                $obalreg16->incluir(null);

                if ($obalreg16->erro_status == 0) {
                    throw new Exception($obalreg16->erro_msg);
                }
            }

            foreach ($oDado10->reg17 as $reg17) {

                $obalreg17 = new cl_balancete172021();

                $obalreg17->si184_tiporegistro = $reg17->si184_tiporegistro;
                $obalreg17->si184_contacontabil = $reg17->si184_contacontabil;
                $obalreg17->si184_codfundo = $sCodFundo;
                $obalreg17->si184_atributosf = $reg17->si184_atributosf;
                $obalreg17->si184_codctb = $reg17->si184_codctb;
                $obalreg17->si184_codfontrecursos = $reg17->si184_codfontrecursos;
                $obalreg17->si184_saldoinicialctb = number_format(abs($reg17->si184_saldoinicialctb == '' ? 0 : $reg17->si184_saldoinicialctb), 2, ".", "");
                $obalreg17->si184_naturezasaldoinicialctb = $reg17->si184_naturezasaldoinicialctb;
                $obalreg17->si184_totaldebitosctb = number_format(abs($reg17->si184_totaldebitosctb), 2, ".", "");
                $obalreg17->si184_totalcreditosctb = number_format(abs($reg17->si184_totalcreditosctb), 2, ".", "");
                $obalreg17->si184_saldofinalctb = number_format(abs($reg17->si184_saldofinalctb), 2, ".", "");
                $obalreg17->si184_naturezasaldofinalctb = $reg17->si184_naturezasaldofinalctb;
                $obalreg17->si184_instit = $reg17->si184_instit;
                $obalreg17->si184_mes = $reg17->si184_mes;
                $obalreg17->si184_reg10 = $obalancete10->si177_sequencial;

                if(db_getsession("DB_anousu")==2021
                    && $this->sDataFinal['5'] . $this->sDataFinal['6']==1
                    && in_array($obalreg17->si184_codctb,$aEncerradas['si95_codtceant'])) {
                    $obalreg17Encerrar = clone $obalreg17;
                    if($obalreg17Encerrar->si184_naturezasaldoinicialctb == 'D') {
                        $obalreg17Encerrar->si184_totalcreditosctb += $obalreg17Encerrar->si184_saldofinalctb;
                    } else {
                        $obalreg17Encerrar->si184_totaldebitosctb += $obalreg17Encerrar->si184_saldofinalctb;
                    }
                    $obalreg17Encerrar->si184_saldofinalctb = '0.00';
                    $obalreg17Encerrar->incluir(null);

                    $obalreg17->si184_codctb = $aEncerradas['si95_reduz'][$obalreg17->si184_codctb];
                    $obalreg17->si184_saldoinicialctb = '0.00';
                    if($obalreg17->si184_naturezasaldoinicialctb == 'D') {
                        $obalreg17->si184_totaldebitosctb = $obalreg17->si184_saldofinalctb;
                        $obalreg17->si184_totalcreditosctb = '0.00';
                    } else {
                        $obalreg17->si184_totalcreditosctb = $obalreg17->si184_saldofinalctb;
                        $obalreg17->si184_totaldebitosctb = '0.00';
                    }

                    $obalancete10->si177_totaldebitos  += $obalreg17->si184_saldofinalctb;
                    $obalancete10->si177_totalcreditos += $obalreg17->si184_saldofinalctb;
                    $obalancete10->alterar($obalancete10->si177_sequencial) ;
                } else if(db_getsession("DB_anousu")==2021 && in_array($obalreg17->si184_codctb,$aEncerradas['si95_codtceant'])){
                    $obalreg17->si184_codctb = $aEncerradas['si95_reduz'][$obalreg17->si184_codctb];
                }
                $obalreg17->incluir(null);

                if ($obalreg17->erro_status == 0) {
                    throw new Exception($obalreg17->erro_msg);
                }
            }

            foreach ($oDado10->reg18 as $reg18) {

                $obalreg18 = new cl_balancete182021();

                $obalreg18->si185_tiporegistro = $reg18->si185_tiporegistro;
                $obalreg18->si185_contacontabil = $reg18->si185_contacontabil;
                $obalreg18->si185_codfundo = $sCodFundo;
                $obalreg18->si185_codfontrecursos = $reg18->si185_codfontrecursos;
                $obalreg18->si185_saldoinicialfr = number_format(abs($reg18->si185_saldoinicialfr == '' ? 0 : $reg18->si185_saldoinicialfr), 2, ".", "");
                $obalreg18->si185_naturezasaldoinicialfr = $reg18->si185_saldoinicialfr == 0 ? $oDado10->naturezasaldo : ($reg18->si185_saldoinicialfr > 0 ? 'D' : 'C');
                $obalreg18->si185_totaldebitosfr = number_format(abs($reg18->si185_totaldebitosfr), 2, ".", "");
                $obalreg18->si185_totalcreditosfr = number_format(abs($reg18->si185_totalcreditosfr), 2, ".", "");
                $saldoFinal = ($reg18->si185_saldoinicialfr + $reg18->si185_totaldebitosfr - $reg18->si185_totalcreditosfr) == '' ? 0 : ($reg18->si185_saldoinicialfr + $reg18->si185_totaldebitosfr - $reg18->si185_totalcreditosfr);
                $obalreg18->si185_saldofinalfr = number_format(abs($saldoFinal), 2, ".", "");
                $obalreg18->si185_naturezasaldofinalfr = $saldoFinal == 0 ? $obalreg18->si185_naturezasaldoinicialfr : ($saldoFinal > 0 ? 'D' : 'C');
                $obalreg18->si185_instit = $reg18->si185_instit;
                $obalreg18->si185_mes = $reg18->si185_mes;
                $obalreg18->si185_reg10 = $obalancete10->si177_sequencial;


                $obalreg18->incluir(null);

                if ($obalreg18->erro_status == 0) {
                    throw new Exception($obalreg18->erro_msg);
                }
            }

            foreach ($oDado10->reg19 as $reg19) {

                $obalreg19 = new cl_balancete192021();

                $obalreg19->si186_tiporegistro = $reg19->si186_tiporegistro;
                $obalreg19->si186_contacontabil = $reg19->si186_contacontabil;
                $obalreg19->si186_codfundo = $sCodFundo;
                $obalreg19->si186_cnpjconsorcio = $reg19->si186_cnpjconsorcio;
                $obalreg19->si186_saldoinicialconsor = number_format(abs($reg19->si186_saldoinicialconsor == '' ? 0 : $reg19->si186_saldoinicialconsor), 2, ".", "");
                $obalreg19->si186_naturezasaldoinicialconsor = $reg19->si186_saldoinicialfontsf >= 0 ? 'D' : 'C';
                $obalreg19->si186_totaldebitosconsor = number_format(abs($reg19->si186_totaldebitosconsor), 2, ".", "");
                $obalreg19->si186_totalcreditosconsor = number_format(abs($reg19->si186_totalcreditosconsor), 2, ".", "");
                $saldoFinal = ($reg19->si186_saldoinicialconsor + $reg19->si186_totaldebitosconsor - $reg19->si186_totalcreditosconsor) == '' ? 0 : ($reg19->si186_saldoinicialconsor + $reg19->si186_totaldebitosconsor - $reg19->si186_totalcreditosconsor);
                $obalreg19->si186_saldofinalconsor = number_format(abs($saldoFinal), 2, ".", "");
                $obalreg19->si186_naturezasaldofinalconsor = $saldoFinal >= 0 ? 'D' : 'C';
                $obalreg19->si186_instit = $reg19->si186_instit;
                $obalreg19->si186_mes = $reg19->si186_mes;
                $obalreg19->si186_reg10 = $obalancete10->si177_sequencial;

                //$obalreg19->incluir(null);

                if ($obalreg19->erro_status == 0) {
                    throw new Exception($obalreg19->erro_msg);
                }
            }

            foreach ($oDado10->reg20 as $reg20) {

                $obalreg20 = new cl_balancete202021();

                $obalreg20->si187_tiporegistro = $reg20->si187_tiporegistro;
                $obalreg20->si187_contacontabil = $reg20->si187_contacontabil;
                $obalreg20->si187_codfundo = $sCodFundo;
                $obalreg20->si187_cnpjconsorcio = $reg20->si187_cnpjconsorcio;
                $obalreg20->si187_tiporecurso = $reg20->si187_tiporecurso;
                $obalreg20->si187_codfuncao = $reg20->si187_codfuncao;
                $obalreg20->si187_codsubfuncao = $reg20->si187_codsubfuncao;
                $obalreg20->si187_naturezadespesa = $reg20->si187_naturezadespesa;
                $obalreg20->si187_subelemento = $reg20->si187_subelemento;
                $obalreg20->si187_codfontrecursos = $reg20->si187_codfontrecursos;
                $obalreg20->si187_saldoinicialconscf = number_format(abs($reg20->si187_saldoinicialconscf == '' ? 0 : $reg20->si187_saldoinicialconscf), 2, ".", "");
                $obalreg20->si187_naturezasaldoinicialconscf = $reg20->si187_saldoinicialfontsf >= 0 ? 'D' : 'C';
                $obalreg20->si187_totaldebitosconscf = number_format(abs($reg20->si187_totaldebitosconscf), 2, ".", "");
                $obalreg20->si187_totalcreditosconscf = number_format(abs($reg20->si187_totalcreditosconscf), 2, ".", "");
                $saldoFinal = ($reg20->si187_saldoinicialconscf + $reg20->si187_totaldebitosconscf - $reg20->si187_totalcreditosconscf) == '' ? 0 : ($reg20->si187_saldoinicialconscf + $reg20->si187_totaldebitosconscf - $reg20->si187_totalcreditosconscf);
                $obalreg20->si187_saldofinalconscf = number_format(abs($saldoFinal), 2, ".", "");
                $obalreg20->si187_naturezasaldofinalconscf = $saldoFinal >= 0 ? 'D' : 'C';
                $obalreg20->si187_instit = $reg20->si187_instit;
                $obalreg20->si187_mes = $reg20->si187_mes;
                $obalreg20->si187_reg10 = $obalancete10->si177_sequencial;

                //$obalreg20->incluir(null);

                if ($obalreg20->erro_status == 0) {
                    throw new Exception($obalreg20->erro_msg);
                }
            }

            foreach ($oDado10->reg21 as $reg21) {

                $obalreg21 = new cl_balancete212021();

                $obalreg21->si188_tiporegistro = $reg21->si188_tiporegistro;
                $obalreg21->si188_contacontabil = $reg21->si188_contacontabil;
                $obalreg21->si188_codfundo = $sCodFundo;
                $obalreg21->si188_cnpjconsorcio = $reg21->si188_cnpjconsorcio;
                $obalreg21->si188_codfontrecursos = $reg21->si188_codfontrecursos;
                $obalreg21->si188_saldoinicialconsorfr = number_format(abs($reg21->si188_saldoinicialconsorfr == '' ? 0 : $reg21->si188_saldoinicialconsorfr), 2, ".", "");
                $obalreg21->si188_naturezasaldoinicialconsorfr = $reg21->si188_saldoinicialfontsf >= 0 ? 'D' : 'C';
                $obalreg21->si188_totaldebitosconsorfr = number_format(abs($reg21->si188_totaldebitosconsorfr), 2, ".", "");
                $obalreg21->si188_totalcreditosconsorfr = number_format(abs($reg21->si188_totalcreditosconsorfr), 2, ".", "");
                $saldoFinal = ($reg21->si188_saldoinicialconsorfr + $reg21->si188_totaldebitosconsorfr - $reg21->si188_totalcreditosconsorfr) == '' ? 0 : ($reg21->si188_saldoinicialconsorfr + $reg21->si188_totaldebitosconsorfr - $reg21->si188_totalcreditosconsorfr);
                $obalreg21->si188_saldofinalconsorfr = number_format(abs($saldoFinal), 2, ".", "");
                $obalreg21->si188_naturezasaldofinalconsorfr = $saldoFinal >= 0 ? 'D' : 'C';
                $obalreg21->si188_instit = $reg21->si188_instit;
                $obalreg21->si188_mes = $reg21->si188_mes;
                $obalreg21->si188_reg10 = $obalancete10->si177_sequencial;

                //$obalreg21->incluir(null);

                if ($obalreg21->erro_status == 0) {
                    throw new Exception($obalreg21->erro_msg);
                }
            }

            foreach ($oDado10->reg22 as $reg22) {

                $obalreg22 = new cl_balancete222021();

                $obalreg22->si189_tiporegistro = $reg22->si189_tiporegistro;
                $obalreg22->si189_contacontabil = $reg22->si189_contacontabil;
                $obalreg22->si189_codfundo = $sCodFundo;
                $obalreg22->si189_atributosf = $reg22->si189_atributosf;
                $obalreg22->si189_codctb = $reg22->si189_codctb;
                $obalreg22->si189_saldoInicialctbsf = number_format(abs($reg22->si189_saldoinicialctbsf == '' ? 0 : $reg22->si189_saldoinicialctbsf), 2, ".", "");
                $obalreg22->si189_naturezasaldoinicialctbsf = $reg22->si189_saldoinicialfontsf >= 0 ? 'D' : 'C';
                $obalreg22->si189_totaldebitosctbsf = number_format(abs($reg22->si189_totaldebitosctbsf), 2, ".", "");
                $obalreg22->si189_totalcreditosctbsf = number_format(abs($reg22->si189_totalcreditosctbsf), 2, ".", "");
                $saldoFinal = ($reg22->si189_saldoinicialctbsf + $reg22->si189_totaldebitosctbsf - $reg22->si189_totalcreditosctbsf) == '' ? 0 : ($reg22->si189_saldoinicialctbsf + $reg22->si189_totaldebitosctbsf - $reg22->si189_totalcreditosctbsf);
                $obalreg22->si189_saldofinalctbsf = number_format(abs($saldoFinal), 2, ".", "");
                $obalreg22->si189_naturezasaldofinalctbsf = $saldoFinal >= 0 ? 'D' : 'C';
                $obalreg22->si189_instit = $reg22->si189_instit;
                $obalreg22->si189_mes = $reg22->si189_mes;
                $obalreg22->si189_reg10 = $obalancete10->si177_sequencial;

                //$obalreg22->incluir(null);

                if ($obalreg22->erro_status == 0) {
                    throw new Exception($obalreg22->erro_msg);
                }
            }

            foreach ($oDado10->reg23 as $reg23) {

                $obalreg23 = new cl_balancete232021();

                $obalreg23->si190_tiporegistro = $reg23->si190_tiporegistro;
                $obalreg23->si190_contacontabil = $reg23->si190_contacontabil;
                $obalreg23->si190_codfundo = $sCodFundo;
                $obalreg23->si190_naturezareceita = $reg23->si190_naturezareceita;
                $obalreg23->si190_saldoinicialnatreceita = number_format(abs($reg23->si190_saldoinicialnatreceita == '' ? 0 : $reg23->si190_saldoinicialnatreceita), 2, ".", "");
                $obalreg23->si190_naturezasaldoinicialnatreceita = $reg23->si190_saldoinicialnatreceita == 0 ? $oDado10->naturezasaldo : ($reg23->si190_saldoinicialnatreceita > 0 ? 'D' : 'C');
                $obalreg23->si190_totaldebitosnatreceita = number_format(abs($reg23->si190_totaldebitosnatreceita), 2, ".", "");
                $obalreg23->si190_totalcreditosnatreceita = number_format(abs($reg23->si190_totalcreditosnatreceita), 2, ".", "");
                $saldoFinal = ($reg23->si190_saldoinicialnatreceita + $reg23->si190_totaldebitosnatreceita - $reg23->si190_totalcreditosnatreceita) == '' ? 0 : ($reg23->si190_saldoinicialnatreceita + $reg23->si190_totaldebitosnatreceita - $reg23->si190_totalcreditosnatreceita);
                $obalreg23->si190_saldofinalnatreceita = number_format(abs($saldoFinal), 2, ".", "");
                $obalreg23->si190_naturezasaldofinalnatreceita = $saldoFinal == 0 ? $obalreg23->si190_naturezasaldoinicialnatreceita : ($saldoFinal > 0 ? 'D' : 'C');
                $obalreg23->si190_instit = $reg23->si190_instit;
                $obalreg23->si190_mes = $reg23->si190_mes;
                $obalreg23->si190_reg10 = $obalancete10->si177_sequencial;

                $obalreg23->incluir(null);

                if ($obalreg23->erro_status == 0) {
                    throw new Exception($obalreg23->erro_msg);
                }
            }

            foreach ($oDado10->reg24 as $reg24) {

                $obalreg24 = new cl_balancete242021();

                $obalreg24->si191_tiporegistro = $reg24->si191_tiporegistro;
                $obalreg24->si191_contacontabil = $reg24->si191_contacontabil;
                $obalreg24->si191_codfundo = $sCodFundo;
                $obalreg24->si191_codorgao = $reg24->si191_codorgao;
                $obalreg24->si191_codunidadesub = $reg24->si191_codunidadesub;
                $obalreg24->si191_saldoinicialorgao = number_format(abs($reg24->si191_saldoinicialorgao == '' ? 0 : $reg24->si191_saldoinicialorgao), 2, ".", "");
                $obalreg24->si191_naturezasaldoinicialorgao = $obalreg24->si191_naturezasaldoinicialorgao = $reg24->si191_saldoinicialorgao == 0 ? $oDado10->naturezasaldo : ($reg24->si191_saldoinicialorgao > 0 ? 'D' : 'C');
                $obalreg24->si191_totaldebitosorgao = number_format(abs($reg24->si191_totaldebitosorgao), 2, ".", "");
                $obalreg24->si191_totalcreditosorgao = number_format(abs($reg24->si191_totalcreditosorgao), 2, ".", "");
                $saldoFinal = ($reg24->si191_saldoinicialorgao + $reg24->si191_totaldebitosorgao - $reg24->si191_totalcreditosorgao) == '' ? 0 : ($reg24->si191_saldoinicialorgao + $reg24->si191_totaldebitosorgao - $reg24->si191_totalcreditosorgao);
                $obalreg24->si191_saldofinalorgao = number_format(abs($saldoFinal), 2, ".", "");
                $obalreg24->si191_naturezasaldofinalorgao = $saldoFinal == 0 ? $obalreg24->si191_naturezasaldoinicialorgao : ($saldoFinal > 0 ? 'D' : 'C');
                $obalreg24->si191_instit = $reg24->si191_instit;
                $obalreg24->si191_mes = $reg24->si191_mes;
                $obalreg24->si191_reg10 = $obalancete10->si177_sequencial;

                $obalreg24->incluir(null);

                if ($obalreg24->erro_status == 0) {
                    throw new Exception($obalreg24->erro_msg);
                }
            }

            foreach ($oDado10->reg25 as $reg25) {

                $obalreg25 = new cl_balancete252021();

                $obalreg25->si195_tiporegistro    = $reg25->si195_tiporegistro;
                $obalreg25->si195_contacontabil   = $reg25->si195_contacontabil;
                $obalreg25->si195_codfundo        = $reg25->si195_codfundo;
                $obalreg25->si195_atributosf      = $reg25->si195_atributosf;
                $obalreg25->si195_naturezareceita = $reg25->si195_naturezareceita;
                $obalreg25->si195_saldoinicialnrsf  = number_format(abs($reg25->si195_saldoinicialnrsf == '' ? 0 : $reg25->si195_saldoinicialnrsf),2,".","");
                $obalreg25->si195_naturezasaldoinicialnrsf = $reg25->si195_naturezasaldoinicialnrsf;
                $obalreg25->si195_totaldebitosnrsf = number_format(abs($reg25->si195_totaldebitosnrsf == '' ? 0 : $reg25->si195_totaldebitosnrsf),2,".","");
                $obalreg25->si195_totalcreditosnrsf = number_format(abs($reg25->si195_totalcreditosnrsf == '' ? 0 : $reg25->si195_totalcreditosnrsf),2,".","");
                $obalreg25->si195_saldofinalnrsf = number_format(abs($reg25->si195_saldofinalnrsf == '' ? 0 : $reg25->si195_saldofinalnrsf),2,".","");
                $obalreg25->si195_naturezasaldofinalnrsf = $reg25->si195_naturezasaldofinalnrsf;
                $obalreg25->si195_mes = $reg25->si195_mes;
                $obalreg25->si195_instit = $reg25->si195_instit;
                $obalreg25->si195_reg10 = $obalancete10->si177_sequencial;

                $obalreg25->incluir(null);

                if ($obalreg25->erro_status == 0) {
                    throw new Exception($obalreg25->erro_msg);
                }
            }

            foreach ($oDado10->reg26 as $reg26) {

                $obalreg26 = new cl_balancete262021();

                $obalreg26->si196_tiporegistro = $reg26->si196_tiporegistro;
                $obalreg26->si196_contacontabil = $reg26->si196_contacontabil;
                $obalreg26->si196_codfundo = $sCodFundo;
                $obalreg26->si196_tipodocumentopessoaatributosf = $reg26->si196_tipodocumentopessoaatributosf;
                $obalreg26->si196_nrodocumentopessoaatributosf = $reg26->si196_nrodocumentopessoaatributosf;
                $obalreg26->si196_atributosf = $reg26->si196_atributosf;
                $obalreg26->si196_saldoinicialpessoaatributosf = number_format(abs($reg26->si196_saldoinicialpessoaatributosf == '' ? 0 : $reg26->si196_saldoinicialpessoaatributosf), 2, ".", "");
                $obalreg26->si196_naturezasaldoinicialpessoaatributosf = $reg26->si196_saldoinicialpessoaatributosf == 0 ? $oDado10->naturezasaldo : ($reg26->si196_saldoinicialpessoaatributosf > 0 ? 'D' : 'C');
                $obalreg26->si196_totaldebitospessoaatributosf = number_format(abs($reg26->si196_totaldebitospessoaatributosf), 2, ".", "");
                $obalreg26->si196_totalcreditospessoaatributosf = number_format(abs($reg26->si196_totalcreditospessoaatributosf), 2, ".", "");
                $saldoFinal = ($reg26->si196_saldoinicialpessoaatributosf + $reg26->si196_totaldebitospessoaatributosf - $reg26->si196_totalcreditospessoaatributosf) == '' ? 0 : ($reg26->si196_saldoinicialpessoaatributosf + $reg26->si196_totaldebitospessoaatributosf - $reg26->si196_totalcreditospessoaatributosf);
                $obalreg26->si196_saldofinalpessoaatributosf = number_format(abs($saldoFinal), 2, ".", "");
                $obalreg26->si196_naturezasaldofinalpessoaatributosf = $saldoFinal == 0 ? $obalreg26->si196_naturezasaldoinicialpessoaatributosf : ($saldoFinal > 0 ? 'D' : 'C');
                $obalreg26->si196_instit = $reg26->si196_instit;
                $obalreg26->si196_mes = $reg26->si196_mes;
                $obalreg26->si196_reg10 = $obalancete10->si177_sequencial;

                $obalreg26->incluir(null);

                if ($obalreg26->erro_status == 0) {
                    throw new Exception($obalreg26->erro_msg." conta contabil {$obalreg26->si196_contacontabil}");
                }
            }

            foreach ($oDado10->reg27 as $reg27) {

                $obalreg27 = new cl_balancete272021();

                $obalreg27->si197_tiporegistro = $reg27->si197_tiporegistro;
                $obalreg27->si197_contacontabil = $reg27->si197_contacontabil;
                $obalreg27->si197_codfundo = $sCodFundo;
                $obalreg27->si197_codorgao = $reg27->si197_codorgao;
                $obalreg27->si197_codunidadesub = $reg27->si197_codunidadesub;
                $obalreg27->si179_codfontrecursos = $reg27->si179_codfontrecursos;
                $obalreg27->si197_atributosf = $reg27->si197_atributosf;
                $obalreg27->si197_saldoinicialoufontesf = number_format(abs($reg27->si197_saldoinicialoufontesf == '' ? 0 : $reg27->si197_saldoinicialoufontesf), 2, ".", "");
                $obalreg27->si197_naturezasaldoinicialoufontesf = $reg27->si197_saldoinicialoufontesf == 0 ? $oDado10->naturezasaldo : ($reg27->si197_saldoinicialoufontesf > 0 ? 'D' : 'C');
                $obalreg27->si197_totaldebitosoufontesf = number_format(abs($reg27->si197_totaldebitosoufontesf), 2, ".", "");
                $obalreg27->si197_totalcreditosoufontesf = number_format(abs($reg27->si197_totalcreditosoufontesf), 2, ".", "");
                $saldoFinal = ($reg27->si197_saldoinicialoufontesf + $reg27->si197_totaldebitosoufontesf - $reg27->si197_totalcreditosoufontesf) == '' ? 0 : ($reg27->si197_saldoinicialoufontesf + $reg27->si197_totaldebitosoufontesf - $reg27->si197_totalcreditosoufontesf);
                $obalreg27->si197_saldofinaloufontesf = number_format(abs($saldoFinal), 2, ".", "");
                $obalreg27->si197_naturezasaldofinaloufontesf = $saldoFinal == 0 ? $obalreg27->si197_naturezasaldoinicialoufontesf : ($saldoFinal > 0 ? 'D' : 'C');
                $obalreg27->si197_instit = $reg27->si197_instit;
                $obalreg27->si197_mes = $reg27->si197_mes;
                $obalreg27->si197_reg10 = $obalancete10->si177_sequencial;

                $obalreg27->incluir(null);

                if ($obalreg27->erro_status == 0) {
                    throw new Exception($obalreg27->erro_msg." conta contabil {$obalreg27->si197_contacontabil}");
                }
            }

            foreach ($oDado10->reg28 as $reg28) {

                $obalreg28 = new cl_balancete282021();

                $obalreg28->si198_tiporegistro = $reg28->si198_tiporegistro;
                $obalreg28->si198_contacontabil = $reg28->si198_contacontabil;
                $obalreg28->si198_codfundo = $reg28->si198_codfundo;
                $obalreg28->si198_codctb = $reg28->si198_codctb;
                $obalreg28->si198_codfontrecursos = $reg28->si198_codfontrecursos;
                $obalreg28->si198_saldoinicialctbfonte = number_format(abs($reg28->si198_saldoinicialctbfonte == '' ? 0 : $reg28->si198_saldoinicialctbfonte), 2, ".", "");
                $obalreg28->si198_naturezasaldoinicialctbfonte = $reg28->si198_saldoinicialctbfonte == 0 ? $oDado10->naturezasaldo : ($reg28->si198_saldoinicialctbfonte > 0 ? 'D' : 'C');
                $obalreg28->si198_totaldebitosctbfonte = number_format(abs($reg28->si198_totaldebitosctbfonte), 2, ".", "");
                $obalreg28->si198_totalcreditosctbfonte = number_format(abs($reg28->si198_totalcreditosctbfonte), 2, ".", "");
                $saldoFinal = ($reg28->si198_saldoinicialctbfonte + $reg28->si198_totaldebitosctbfonte - $reg28->si198_totalcreditosctbfonte) == '' ? 0 : ($reg28->si198_saldoinicialctbfonte + $reg28->si198_totaldebitosctbfonte - $reg28->si198_totalcreditosctbfonte);
                $obalreg28->si198_saldofinalctbfonte = number_format(abs($saldoFinal), 2, ".", "");
                $obalreg28->si198_naturezasaldofinalctbfonte = $saldoFinal == 0 ? $obalreg28->si198_naturezasaldoinicialctbfonte : ($saldoFinal > 0 ? 'D' : 'C');
                $obalreg28->si198_instit = $reg28->si198_instit;
                $obalreg28->si198_mes = $reg28->si198_mes;
                $obalreg28->si197_reg10 = $obalancete10->si177_sequencial;

                $obalreg28->incluir(null);

                if ($obalreg28->erro_status == 0) {
                    throw new Exception($obalreg28->erro_msg." conta contabil {$obalreg28->si198_contacontabil}");
                }
            }

            foreach ($oDado10->reg29 as $reg29) {

                $obalreg29 = new cl_balancete292021();

                $obalreg29->si241_tiporegistro = $reg29->si241_tiporegistro;
                $obalreg29->si241_contacontabil = $reg29->si241_contacontabil;
                $obalreg29->si241_codfundo = $sCodFundo;
                $obalreg29->si241_atributosf = $reg29->si241_atributosf;
                $obalreg29->si241_codfontrecursos = $reg29->si241_codfontrecursos;
                $obalreg29->si241_dividaconsolidada = $reg29->si241_dividaconsolidada;
                $obalreg29->si241_saldoinicialfontsf = number_format(abs($reg29->si241_saldoinicialfontsf == '' ? 0 : $reg29->si241_saldoinicialfontsf), 2, ".", "");
                $obalreg29->si241_naturezasaldoinicialfontsf = $reg29->si241_saldoinicialfontsf == 0 ? $oDado10->naturezasaldo : ($reg29->si241_saldoinicialfontsf > 0 ? 'D' : 'C');
                $obalreg29->si241_totaldebitosfontsf = number_format(abs($reg29->si241_totaldebitosfontsf), 2, ".", "");
                $obalreg29->si241_totalcreditosfontsf = number_format(abs($reg29->si241_totalcreditosfontsf), 2, ".", "");
                $saldoFinal = ($reg29->si241_saldoinicialfontsf + $reg29->si241_totaldebitosfontsf - $reg29->si241_totalcreditosfontsf) == '' ? 0 : ($reg29->si241_saldoinicialfontsf + $reg29->si241_totaldebitosfontsf - $reg29->si241_totalcreditosfontsf);
                $obalreg29->si241_saldofinalfontsf = number_format(abs($saldoFinal), 2, ".", "");
                $obalreg29->si241_naturezasaldofinalfontsf = $saldoFinal == 0 ? $obalreg29->si241_naturezasaldoinicialfontsf : ($saldoFinal > 0 ? 'D' : 'C');
                $obalreg29->si241_instit = $reg29->si241_instit;
                $obalreg29->si241_mes = $reg29->si241_mes;
                $obalreg29->si241_reg10 = $obalancete10->si177_sequencial;

                $obalreg29->incluir(null);

                if ($obalreg29->erro_status == 0) {
                    throw new Exception($obalreg29->erro_msg);
                }
            }

            foreach ($oDado10->reg30 as $reg30) {

                $obalreg30 = new cl_balancete302021();

                $obalreg30->si242_tiporegistro = $reg30->si242_tiporegistro;
                $obalreg30->si242_contacontaabil = $reg30->si242_contacontaabil;
                $obalreg30->si242_codfundo = $sCodFundo;
                $obalreg30->si242_codorgao = $reg30->si242_codorgao;
                $obalreg30->si242_codunidadesub = $reg30->si242_codunidadesub;
                $obalreg30->si242_codfuncao = $reg30->si242_codfuncao;
                $obalreg30->si242_codsubfuncao = $reg30->si242_codsubfuncao;
                $obalreg30->si242_codprograma = $reg30->si242_codprograma;
                $obalreg30->si242_idacao = $reg30->si242_idacao;
                $obalreg30->si242_idsubacao = $reg30->si242_idsubacao;
                $obalreg30->si242_naturezadespesa = $reg30->si242_naturezadespesa;
                $obalreg30->si242_subelemento = $reg30->si242_subelemento;
                $obalreg30->si242_codfontrecursos = $reg30->si242_codfontrecursos;
                $obalreg30->si242_tipodespesarpps = $reg30->si242_tipodespesarpps;
                $obalreg30->si242_saldoinicialcde = number_format(abs($reg30->si242_saldoinicialcde == '' ? 0 : $reg30->si242_saldoinicialcde), 2, ".", "");
                $obalreg30->si242_naturezasaldoinicialcde = $reg30->si242_saldoinicialcde == 0 ? $oDado10->naturezasaldo : ($reg30->si242_saldoinicialcde > 0 ? 'D' : 'C');
                $obalreg30->si242_totaldebitoscde = number_format(abs($reg30->si242_totaldebitoscde), 2, ".", "");
                $obalreg30->si242_totalcreditoscde = number_format(abs($reg30->si242_totalcreditoscde), 2, ".", "");
                $saldoFinal = ($reg30->si242_saldoinicialcde + $reg30->si242_totaldebitoscde - $reg30->si242_totalcreditoscde) == '' ? 0 : ($reg30->si242_saldoinicialcde + $reg30->si242_totaldebitoscde - $reg30->si242_totalcreditoscde);
                $obalreg30->si242_saldofinalcde = number_format(abs($saldoFinal == '' ? 0 : $saldoFinal), 2, ".", "");
                $obalreg30->si242_naturezasaldofinalcde = $saldoFinal == 0 ? $obalreg30->si242_naturezasaldoinicialcde : ($saldoFinal > 0 ? 'D' : 'C');
                $obalreg30->si242_instit = $reg30->si242_instit;
                $obalreg30->si242_mes = $reg30->si242_mes;
                $obalreg30->si242_reg10 = $obalancete10->si177_sequencial;

                $obalreg30->incluir(null);

                if ($obalreg30->erro_status == 0) {
                    throw new Exception($obalreg30->erro_msg);
                }
            }

            foreach ($oDado10->reg31 as $reg31) {

                $obalreg31 = new cl_balancete312021();

                $obalreg31->si243_tiporegistro = $reg31->si243_tiporegistro;
                $obalreg31->si243_contacontabil = $reg31->si243_contacontabil;
                $obalreg31->si243_codfundo = $sCodFundo;
                $obalreg31->si243_naturezareceita = $reg31->si243_naturezareceita;
                $obalreg31->si243_codfontrecursos = $reg31->si243_codfontrecursos;
                $obalreg31->si243_emendaparlamentar = $reg31->si243_emendaparlamentar;
                $obalreg31->si243_saldoinicialcre = number_format(abs($reg31->si243_saldoinicialcre == '' ? 0 : $reg31->si243_saldoinicialcre), 2, ".", "");
                $obalreg31->si243_naturezasaldoinicialcre = $reg31->si243_saldoinicialcre == 0 ? $oDado10->naturezasaldo : ($reg31->si243_saldoinicialcre > 0 ? 'D' : 'C');
                $obalreg31->si243_totaldebitoscre = number_format(abs($reg31->si243_totaldebitoscre), 2, ".", "");
                $obalreg31->si243_totalcreditoscre = number_format(abs($reg31->si243_totalcreditoscre), 2, ".", "");
                $saldoFinal = ($reg31->si243_saldoinicialcre + $reg31->si243_totaldebitoscre - $reg31->si243_totalcreditoscre) == '' ? 0 : ($reg31->si243_saldoinicialcre + $reg31->si243_totaldebitoscre - $reg31->si243_totalcreditoscre);
                $obalreg31->si243_saldofinalcre = number_format(abs($saldoFinal == '' ? 0 : $saldoFinal), 2, ".", "");
                $obalreg31->si243_naturezasaldofinalcre = $saldoFinal == 0 ? $obalreg31->si243_naturezasaldoinicialcre : ($saldoFinal > 0 ? 'D' : 'C');
                $obalreg31->si243_instit = $reg31->si243_instit;
                $obalreg31->si243_mes = $reg31->si243_mes;
                $obalreg31->si243_reg10 = $obalancete10->si177_sequencial;

                $obalreg31->incluir(null);

                if ($obalreg31->erro_status == 0) {
                    throw new Exception($obalreg31->erro_msg);
                }
            }


        }

        db_fim_transacao();
        $oGerarbalancete = new GerarBALANCETE();
        $oGerarbalancete->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oGerarbalancete->gerarDados();

    }

}
