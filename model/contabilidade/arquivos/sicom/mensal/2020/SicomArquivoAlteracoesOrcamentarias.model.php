<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_aoc102020_classe.php");
require_once("classes/db_aoc112020_classe.php");
require_once("classes/db_aoc122020_classe.php");
require_once("classes/db_aoc132020_classe.php");
require_once("classes/db_aoc142020_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarAOC.model.php");

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

        $claoc10 = new cl_aoc102020();
        $claoc11 = new cl_aoc112020();
        $claoc12 = new cl_aoc122020();
        $claoc13 = new cl_aoc132020();
        $claoc14 = new cl_aoc142020();
        $claoc15 = new cl_aoc152020();

        /**
         * excluir informacoes do mes selecionado
         */
        db_inicio_transacao();
        $result = $claoc15->sql_record($claoc15->sql_query(null, "*", null, "si194_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si194_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $claoc15->excluir(null, "si194_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si194_instit = " . db_getsession("DB_instit"));
            if ($claoc15->erro_status == 0) {
                throw new Exception($claoc15->erro_msg);
            }
        }

        $result = $claoc11->sql_record($claoc11->sql_query(null, "*", null, "si39_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si39_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $claoc11->excluir(null, "si39_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si39_instit = " . db_getsession("DB_instit"));
            if ($claoc11->erro_status == 0) {
                throw new Exception($claoc11->erro_msg);
            }
        }

        $result = $claoc12->sql_record($claoc12->sql_query(null, "*", null, "si40_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si40_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $claoc12->excluir(null, "si40_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si40_instit = " . db_getsession("DB_instit"));
            if ($claoc12->erro_status == 0) {
                throw new Exception($claoc12->erro_msg);
            }
        }

        $result = $claoc13->sql_record($claoc13->sql_query(null, "*", null, "si41_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si41_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $claoc13->excluir(null, "si41_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si41_instit = " . db_getsession("DB_instit"));
            if ($claoc13->erro_status == 0) {
                throw new Exception($claoc13->erro_msg);
            }
        }

        $result = $claoc14->sql_record($claoc14->sql_query(null, "*", null, "si42_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si42_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $claoc14->excluir(null, "si42_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si42_instit = " . db_getsession("DB_instit"));
            if ($claoc14->erro_status == 0) {
                throw new Exception($claoc14->erro_msg);
            }
        }

        $result = $claoc10->sql_record($claoc10->sql_query(null, "*", null, "si38_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si38_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $claoc10->excluir(null, "si38_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si38_instit = " . db_getsession("DB_instit"));
            if ($claoc10->erro_status == 0) {
                throw new Exception($claoc10->erro_msg);
            }
        }
        /**
         * fim da exclusao dos registros do mes selecionado
         */


        /**
         * selecionar as informacoes pertinentes ao AOC
         */

        $sSql = "select  distinct o39_codproj as codigovinc,
       '10' as tiporegistro,
       si09_codorgaotce as codorgao,
       replace(o39_numero,' ','') as nroDecreto,
       o39_data as dataDecreto,o39_tipoproj as tipodecreto
       from
       orcsuplem
       join orcsuplemval  on o47_codsup = o46_codsup
       join orcprojeto    on o46_codlei = o39_codproj
       join db_config on prefeitura  = 't'
       join orcsuplemlan on o49_codsup=o46_codsup and o49_data is not null
       left join infocomplementaresinstit on si09_instit = " . db_getsession("DB_instit") . "
     where o39_data between  '$this->sDataInicial' and '$this->sDataFinal'";
        $rsResult10 = db_query($sSql);

        $sSqlPrefeitura = "select * from infocomplementaresinstit where  si09_instit =" . db_getsession("DB_instit") . " and si09_tipoinstit = 2";
        $rsPrefeitura = db_query($sSqlPrefeitura);

        if (pg_num_rows($rsPrefeitura) > 0) {

            for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

                $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
                $claoc10 = new cl_aoc102020();

                $claoc10->si38_tiporegistro = 10;
                $claoc10->si38_codorgao = $oDados10->codorgao;
                $sNrodecreto = preg_replace("/[^a-zA-Z0-9]/", "", $oDados10->nrodecreto);
                $sNrodecreto = str_replace("S", "", $sNrodecreto);
                $claoc10->si38_nrodecreto = $sNrodecreto;
                $claoc10->si38_datadecreto = $oDados10->datadecreto;
                $claoc10->si38_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $claoc10->si38_instit = db_getsession("DB_instit");

                $claoc10->incluir(null);
                if ($claoc10->erro_status == 0) {
                    throw new Exception($claoc10->erro_msg);
                }

                /**
                 * registro 11
                 */
                $sSql = "SELECT '11' AS tiporegistro,
                                 o46_codlei AS codreduzidodecreto,
                                 o39_numero AS nrodecreto,
                                 (CASE
                                      WHEN o46_tiposup IN (1002, 1004, 1005, 1006, 1007, 1008, 1009, 1010) THEN 2
                                      WHEN o46_tiposup IN (1001, 1003) THEN 1
                                      WHEN o46_tiposup = 1012 THEN 6
                                      WHEN o46_tiposup = 1013 THEN 7
                                      WHEN o46_tiposup = 1016 THEN 8
                                      WHEN o46_tiposup = 1014 THEN 9
                                      WHEN o46_tiposup = 1015 THEN 10
                                      WHEN o46_tiposup = 1017 THEN 5
                                      WHEN o46_tiposup = 1011 THEN 4
                                  END ) AS tipoDecretoAlteracao,
                                 sum(o47_valor) AS valorAberto
                         FROM orcsuplem
                         JOIN orcsuplemval ON o47_codsup = o46_codsup
                         JOIN orcprojeto ON o46_codlei = o39_codproj
                         JOIN orcsuplemtipo ON o46_tiposup = o48_tiposup
                         JOIN orcsuplemlan ON o49_codsup=o46_codsup AND o49_data IS NOT NULL
                         WHERE o47_valor > 0
                           AND o46_codlei IN ({$oDados10->codigovinc})
                         GROUP BY o46_codlei, o39_numero, o46_tiposup";
                $rsResult11 = db_query($sSql);

                for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

                    $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
                    $claoc11 = new cl_aoc112020();

                    $claoc11->si39_tiporegistro = 11;
                    $claoc11->si39_codreduzidodecreto = $oDados11->codreduzidodecreto;
                    $sNrodecreto = preg_replace("/[^a-zA-Z0-9]/", "", $oDados11->nrodecreto);
                    $sNrodecreto = str_replace("S", "", $sNrodecreto);
                    $claoc11->si39_nrodecreto = $sNrodecreto;
                    $claoc11->si39_tipodecretoalteracao = $oDados11->tipodecretoalteracao;
                    $claoc11->si39_valoraberto = $oDados11->valoraberto;
                    $claoc11->si39_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $claoc11->si39_reg10 = $claoc10->si38_sequencial;
                    $claoc11->si39_instit = db_getsession("DB_instit");

                    $claoc11->incluir(null);
                    if ($claoc11->erro_status == 0) {
                        throw new Exception($claoc11->erro_msg);
                    }

                }

                /**
                 * registro 12
                 */

                if ($oDados10->tipodecreto == 1) {
                    $sSql = "select '12' as tiporegistro,
                         o39_codproj as codReduzidoDecreto,
                         o45_numlei as nroLeiAlteracao ,
                         o45_datalei as dataLeiAlteracao, 'LOA' as o138_altpercsuplementacao, 1 as sql
                   from orcprojeto
                   join orclei on o39_codlei = o45_codlei
                  where o39_codproj in ({$oDados10->codigovinc}) ";

                } else {
                    $sSql = "select '12' as tiporegistro,
                         o39_codproj as codReduzidoDecreto,
                         o138_numerolei as nroLeiAlteracao ,
                         o138_data as dataLeiAlteracao,
                         case when o138_altpercsuplementacao =1 then 'LAOP' else 'LAO' end o138_altpercsuplementacao, 2 as sql
                   from orcprojeto
                   join orcprojetoorcprojetolei on o39_codproj = o139_orcprojeto
                   join orcprojetolei on o139_orcprojetolei = o138_sequencial
                    where o39_codproj in ({$oDados10->codigovinc})";

                }
                $rsResult12 = db_query($sSql);
                //db_criatabela($rsResult12);echo $sSql;

                for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {

                    $oDados12 = db_utils::fieldsMemory($rsResult12, $iCont12);
                    $claoc12 = new cl_aoc122020();

                    if ($oDados11->tipodecretoalteracao == 1) {
                        $si40_tipoleialteracao = 1;
                    } elseif ($oDados11->tipodecretoalteracao == 2 || $oDados11->tipodecretoalteracao == 6) {
                        $si40_tipoleialteracao = 2;
                    } elseif ($oDados11->tipodecretoalteracao == 8 || $oDados11->tipodecretoalteracao == 9
                        || $oDados11->tipodecretoalteracao == 10
                    ) {
                        $si40_tipoleialteracao = 3;
                    } elseif ($oDados11->tipodecretoalteracao == 5) {
                        $si40_tipoleialteracao = 4;
                    } elseif ($oDados11->tipodecretoalteracao == 11) {
                        $si40_tipoleialteracao = 5;
                    }

                    $claoc12->si40_tiporegistro = 12;
                    $claoc12->si40_codreduzidodecreto = $oDados12->codreduzidodecreto;

                    
                    if ($oDados11->tipodecretoalteracao != 4) {
                        
                        $claoc12->si40_nroleialteracao  = substr($oDados12->nroleialteracao, 0, 6);
                        $claoc12->si40_dataleialteracao = $oDados12->dataleialteracao;
                        $claoc12->si40_tpleiorigdecreto = $oDados12->o138_altpercsuplementacao;
                        $claoc12->si40_tipoleialteracao = $oDados12->o138_altpercsuplementacao == "LAO" ? $si40_tipoleialteracao : 0;
                        $claoc12->si40_valorabertolei   = $oDados11->valoraberto;

                    }else{
                        
                        $claoc12->si40_nroleialteracao  = '';
                        $claoc12->si40_dataleialteracao = '';
                        $claoc12->si40_tpleiorigdecreto = '';
                        $claoc12->si40_tipoleialteracao = '';
                        $claoc12->si40_valorabertolei   = '';
                    }


                    $claoc12->si40_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $claoc12->si40_reg10 = $claoc10->si38_sequencial;
                    $claoc12->si40_instit = db_getsession("DB_instit");

                    $claoc12->incluir(null);
                    // echo $claoc12->erro_sql;
                    // echo pg_last_error();
                    if ($claoc12->erro_status == 0) {
                        throw new Exception($claoc12->erro_msg);
                    }

                }

                /**
                 * registro 13
                 */
                $sSql = "select '13'       as tiporegistro,
       o46_codlei as codreduzidodecreto,
       (case when o46_tiposup = 1001 or o46_tiposup = 1006 then 3
       when o46_tiposup = 1002 then 4
       when o46_tiposup = 1003 then 1
             when o46_tiposup in (1004,1005,1007,1008,1009,1010) then 2
             else 98
         end
       ) as tipoDecretoAlteracao,
       sum(o47_valor) as valorAberto
     from orcsuplem
     join orcsuplemval  on o47_codsup = o46_codsup
     join orcprojeto    on o46_codlei = o39_codproj
     join orcsuplemtipo on o46_tiposup =  o48_tiposup
     join orcsuplemlan on o49_codsup=o46_codsup and o49_data is not null
    where o47_valor > 0 and o46_codlei in ({$oDados10->codigovinc})
    group by o46_codlei, o39_numero,o46_tiposup";
                $rsResult13 = db_query($sSql);
                //db_criatabela($rsResult13);

                for ($iCont13 = 0; $iCont13 < pg_num_rows($rsResult13); $iCont13++) {

                    $oDados13 = db_utils::fieldsMemory($rsResult13, $iCont13);
                    $claoc13 = new cl_aoc132020();

                    $claoc13->si41_tiporegistro = 13;
                    $claoc13->si41_codreduzidodecreto = $oDados13->codreduzidodecreto;
                    $claoc13->si41_origemrecalteracao = $oDados13->tipodecretoalteracao;
                    $claoc13->si41_valorabertoorigem = $oDados13->valoraberto;
                    $claoc13->si41_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $claoc13->si41_reg10 = $claoc10->si38_sequencial;
                    $claoc13->si41_instit = db_getsession("DB_instit");

                    $claoc13->incluir(null);
                    if ($claoc13->erro_status == 0) {
                        throw new Exception($claoc13->erro_msg);
                    }

                }

                /**
                 * registro 14
                 */
                $sSql = "SELECT DISTINCT o46_codsup,
                                CASE
                                    WHEN o47_valor > 0 THEN 14
                                    WHEN o47_valor < 0 AND o46_tiposup IN (1001,1006) THEN 15
                                END AS tipoRegistro,
                                o46_codlei AS codReduzidoDecreto,
                                CASE
                                   WHEN o46_tiposup = 1001 OR o46_tiposup = 1006 THEN 3
                                   WHEN o46_tiposup = 1002 THEN 4
                                   WHEN o46_tiposup = 1003 THEN 1
                                   WHEN o46_tiposup IN (1004, 1005, 1007, 1008, 1009, 1010) THEN 2
                                   ELSE 98
                                 END AS tipoDecretoAlteracao,
                                si09_codorgaotce AS codOrgao,
                                substr(o47_codsup, length(o47_codsup::varchar) -2, 3)||substr(o56_elemento,3,5)||o58_projativ||o58_subfuncao AS codorigem,
                                o47_codsup,
                                CASE
                                    WHEN o41_subunidade != 0
                                         OR NOT NULL THEN lpad((CASE
                                                                    WHEN o40_codtri = '0' OR NULL THEN o40_orgao::varchar
                                                                    ELSE o40_codtri
                                                                END),2,0)||lpad((CASE
                                                                                     WHEN o41_codtri = '0' OR NULL THEN o41_unidade::varchar
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
                                END AS codunidadesub,
                                o58_funcao AS codFuncao,
                                o58_subfuncao AS codSubFuncao,
                                o58_programa AS codPrograma,
                                o58_projativ AS idAcao,
                                ' ' AS idSubAcao,
                                substr(o56_elemento,2,6) AS naturezaDespesa,
                                o15_codtri AS codFontRecursos,
                                abs(o47_valor) AS vlacrescimoreducao,
                                o41_subunidade AS subunidade
                         FROM orcsuplemval
                         JOIN orcsuplem ON o47_codsup = o46_codsup
                         JOIN orcdotacao ON (o47_anousu, o47_coddot) = (o58_anousu, o58_coddot)
                         JOIN orcelemento ON (o58_codele, o58_anousu) = (o56_codele, o56_anousu)
                         JOIN orctiporec ON o58_codigo = o15_codigo
                         JOIN db_config ON o58_instit = codigo
                         JOIN orcunidade ON (orcdotacao.o58_orgao, orcdotacao.o58_unidade, orcdotacao.o58_anousu) = (orcunidade.o41_orgao, orcunidade.o41_unidade, orcunidade.o41_anousu)
                         JOIN orcorgao ON (o40_orgao, o40_anousu) = (o41_orgao, o41_anousu)
                         JOIN orcsuplemlan ON o49_codsup=o46_codsup AND o49_data IS NOT NULL
                         LEFT JOIN infocomplementaresinstit ON codigo = si09_instit
                         WHERE o46_codlei IN ({$oDados10->codigovinc})
                         ORDER BY o46_codsup";

                         // echo $oDados10->codigovinc;
                         // echo $sSql;
                         
                $rsResult = db_query($sSql);

                $rsResult14 = db_query("
                            SELECT tiporegistro,
                                   codreduzidodecreto,
                                   tipodecretoalteracao,
                                   codorgao,
                                   codunidadesub,
                                   codfuncao,
                                   codsubfuncao,
                                   codprograma,
                                   idacao,
                                   idsubacao,
                                   naturezadespesa,
                                   codfontrecursos,
                                   sum(vlacrescimoreducao) vlacrescimoreducao,
                                   subunidade
                            FROM
                            ($sSql) reg14
                            GROUP BY codorgao, codunidadesub, codfuncao, codsubfuncao, codprograma, idacao, idsubacao, tiporegistro, codreduzidodecreto, 
                                     tipodecretoalteracao, naturezadespesa, codfontrecursos, subunidade");

                $aDadosAgrupados14 = array();
                $aDadosAgrupados15 = array();
                $aCodOrigem = array();

                for ($iCont14 = 0; $iCont14 < pg_num_rows($rsResult); $iCont14++) {

                    $oDadosSql14 = db_utils::fieldsMemory($rsResult, $iCont14);

                    if ($oDadosSql14->tipodecretoalteracao == 3 || $oDadosSql14->tipodecretoalteracao == 98){

                        $sHash  = $oDadosSql14->codreduzidodecreto . $oDadosSql14->codorigem . $oDadosSql14->codorgao . $oDadosSql14->codunidadesub . $oDadosSql14->codfuncao;
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
                                $oDados14->si42_instit = db_getsession("DB_instit");
                                $aDadosAgrupados14[$sHash] = $oDados14;

                            } else {

                                $aDadosAgrupados14[$sHash]->si42_vlacrescimoreducao += $oDadosSql14->vlacrescimoreducao;
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
                                $oDados15->si194_instit = db_getsession("DB_instit");
                                $aDadosAgrupados15[$sHash] = $oDados15;

                            } else {

                                $aDadosAgrupados15[$sHash]->si194_vlreducao += $oDadosSql14->vlreduz;
                            }
                        }
                    }else{
                      $oDadosSql14Vlr = db_utils::fieldsMemory($rsResult14, $iCont14);
                      if (!empty($oDadosSql14Vlr->tipodecretoalteracao)){

                        $sHash  = $oDadosSql14Vlr->codorgao . $oDadosSql14Vlr->codunidadesub . $oDadosSql14Vlr->codfuncao . $oDadosSql14Vlr->codsubfuncao;
                        $sHash .= $oDadosSql14Vlr->codprograma . $oDadosSql14Vlr->idacao . $oDadosSql14Vlr->naturezadespesa . $oDadosSql14Vlr->codfontrecursos;

                        if (!isset($aDadosAgrupados14[$sHash])){

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
                          $oDados14->si42_instit = db_getsession("DB_instit");
                          $aDadosAgrupados14[$sHash] = $oDados14;
                        }else{
                          $aDadosAgrupados14[$sHash]->si42_vlacrescimoreducao += $oDadosSql14->vlacrescimoreducao;
                        }
                      }
                    }
                }
                // print_r($oDadosSql14);exit;
                if ($oDadosSql14->tipodecretoalteracao == 3 || $oDadosSql14->tipodecretoalteracao == 98) {

                    foreach ($aDadosAgrupados15 as $oDadosReg14) {

                        $claoc14 = new cl_aoc142020();

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
                     * 15 ? Alterações Orçamentárias de Redução
                     * Novo Registro Inserido a partir de 2020, conforme layout Versão 8.0_2020
                     *
                     */

                    foreach ($aDadosAgrupados15 as $oDadosReg15) {

                        $claoc15 = new cl_aoc152020();

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
                }else{
                    foreach ($aDadosAgrupados14 as $oDadosReg14) {

                        $claoc14 = new cl_aoc142020();

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
