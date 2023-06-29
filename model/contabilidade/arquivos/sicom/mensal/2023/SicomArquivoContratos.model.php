<?php

require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_contratos102023_classe.php");
require_once("classes/db_contratos112023_classe.php");
require_once("classes/db_contratos122023_classe.php");
require_once("classes/db_contratos132023_classe.php");
require_once("classes/db_contratos202023_classe.php");
require_once("classes/db_contratos212023_classe.php");
require_once("classes/db_contratos302023_classe.php");
require_once("classes/db_contratos402023_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2023/GerarCONTRATOS.model.php");
require_once("model/Acordo.model.php");
require_once("model/AcordoPosicao.model.php");
require_once("model/AcordoRescisao.model.php");
//echo '<pre>';ini_set("display_errors", 1);
/**
 * Contratos Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoContratos extends SicomArquivoBase implements iPadArquivoBaseCSV
{

    const ORIGEM_PROCESSO_COMPRAS = 1;
    const ORIGEM_LICITACAO = 2;
    const ORIGEM_MANUAL = 3;
    const ORIGEM_EMPENHO = 6;

    /*
        1 - No ou dispensa por valor
        2 - Licitao
        3 - Dispensa ou Inexigibilidade
        4 - Adeso  ata de registro de preos
        5 - Licitao realizada por outro rgo ou entidade
        6 - Dispensa ou Inexigibilidade realizada por outro rgo ou entidade
        7 - Licitao - Regime Diferenciado de Contrataes Pblicas - RDC
        8 - Licitao realizada por consorcio pblico
        9 - Licitao realizada por outro ente da federao
     */

    const TIPO_ORIGEM_NAO_OU_DISPENSA = 1;
    const TIPO_ORIGEM_LICIATACAO = 2;
    const TIPO_ORIGEM_DISPENSA_INEXIGIBILIDADE = 3;
    const TIPO_ORIGEM_ADESAO_REGISTRO_PRECO = 4;
    const TIPO_ORIGEM_LICITACAO_OUTRO_ORGAO = 5;
    const TIPO_ORIGEM_DISPENSA_INEXIBILIDADE_OUTRO_ORGAO = 6;
    const TIPO_ORIGEM_LICITACAO_REGIME_DIFERENCIADO = 7;
    const TIPO_ORIGEM_LICITACAO_CONSORCIO = 8;
    const TIPO_ORIGEM_FEDERACAO = 9;

    /**
     *
     * Codigo do layout. (db_layouttxt.db50_codigo)
     * @var Integer
     */
    protected $iCodigoLayout = 163;

    /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'CONTRATOS';

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
     *esse metodo sera implementado criando um array com os campos que serao necessarios
     *para o escritor gerar o arquivo CSV
     */
    public function getCampos()
    {
    }

    /**
     * Busca a penalidade de acordo com o tipo
     * @param $iAcordo
     * @param $iTipo [1-multaRescisoria,2-multaInadimplemento]
     */
    public function getPenalidadeByAcordo($iAcordo, $iTipo)
    {
        $sSql = " select ac15_texto from acordoacordopenalidade
               where ac15_acordo = {$iAcordo} and ac15_acordopenalidade = {$iTipo}";
        return db_utils::fieldsMemory(db_query($sSql), 0)->ac15_texto;
    }

    /**
     * Busca a garantia do contrato.
     * Se houver mais de uma, busca a primeira.
     * @param $iAcordo
     * @return mixed
     */
    public function getGarantiaByAcordo($iAcordo)
    {
        $sSql = "
      select ac11_sequencial from acordoacordogarantia
      inner join acordogarantia on ac12_acordogarantia = ac11_sequencial
      where ac12_acordo = {$iAcordo} limit 1";
        return db_utils::fieldsMemory(db_query($sSql), 0)->ac11_sequencial;
    }

    /**
     * Tipo de Termo de Aditivo:
     *   04 ? Reajuste;
     *   05 ? Recomposio (Equilbrio Financeiro);
     *   06 ? Outros.
     *   07 ? Alterao de Prazo de Vigncia;
     *   08 ? Alterao de Prazo de Execuo;
     *   09 ? Acrscimo de Item(ns);
     *   10 ? Decrscimo de Item(ns);
     *   11 ? Acrscimo e Decrscimo de Item(ns);
     *   12 ? Alterao de Projeto/Especificao
     *   13 ? Alterao de Prazo de vigncia e Prazo de Execuo;
     *   14 ? Acrscimo/Decrscimo de item(ns) conjugado com
     *        outros tipos de termos aditivos;
     * @param AcordoPosicao $oAcordoPosicao
     * @return int
     */
    public function getTipoTermoAditivo(AcordoPosicao $oAcordoPosicao)
    {
        $aTipos = array();

        if ($oAcordoPosicao->getTipo() == 6) {
            $aTipos[] = 7;
        }

        if ($oAcordoPosicao->getTipo() == 5) {
            $aTipos[] = 4;
        }

        if ($oAcordoPosicao->getTipo() == 2) {
            $aTipos[] = 5;
        }

        if ($oAcordoPosicao->getTipo() == 7) {
            $aTipos[] = 6;
        }

        if ($oAcordoPosicao->getTipo() == 8) {
            $aTipos[] = 8;
        }

        if ($oAcordoPosicao->getTipo() == 13) {
            $aTipos[] = 13;
        }

        if ($oAcordoPosicao->getTipo() == 11) {
            $aTipos[] = 11;
        }

        if ($oAcordoPosicao->getTipo() == 13) {
            $aTipos[] = 13;
        }

        if ($oAcordoPosicao->getTipo() == 14) {
            $aTipos[] = 14;
        }

        return $aTipos[0] == "" ? $oAcordoPosicao->getTipo() : $aTipos[0];
    }

    public function getCodunidadesubrespAdesao($sequencial, $departadesao)
    {
        /* Substitui��o do trecho acima pela mesma consulta utilizada no campo 4 do reg. 10 da REGADESAO */
        if ($departadesao == false) {
            $consulta = "pc80_depto";
        } else {
            $consulta = "si06_departamento";
        }
        $sSql = "
	  		SELECT
    			(SELECT CASE
                	WHEN o41_subunidade != 0 OR NOT NULL
                		THEN lpad((CASE WHEN o40_codtri = '0' OR NULL THEN o40_orgao::varchar
                        											  ELSE o40_codtri
						END),2,0)||lpad((CASE WHEN o41_codtri = '0' OR NULL THEN o41_unidade::varchar
																		  ELSE o41_codtri
						END),3,0)||lpad(o41_subunidade::integer,3,0)
							ELSE lpad((CASE WHEN o40_codtri = '0' OR NULL THEN o40_orgao::varchar
																			ELSE o40_codtri
						END),2,0)||lpad((CASE WHEN o41_codtri = '0' OR NULL THEN o41_unidade::varchar
																								ELSE o41_codtri
						END),3,0)
            		END AS codunidadesub
				 FROM db_departorg
				 JOIN infocomplementares ON si08_anousu = db01_anousu AND si08_instit = " . db_getsession('DB_instit') . "
				 JOIN orcunidade ON db01_orgao=o41_orgao AND db01_unidade=o41_unidade AND db01_anousu = o41_anousu AND o41_instit = " . db_getsession('DB_instit') . "
				 JOIN orcorgao ON o40_orgao = o41_orgao AND o40_anousu = o41_anousu AND o40_instit = " . db_getsession('DB_instit') . "
				 WHERE db01_coddepto=" . $consulta . " AND db01_anousu = " . db_getsession('DB_anousu') . "
				 LIMIT 1) AS codunidadesubresp,
                 si06_codunidadesubant
			FROM adesaoregprecos
			JOIN acordo on ac16_adesaoregpreco = si06_sequencial
			JOIN cgm orgaogerenciador ON si06_orgaogerenciador = orgaogerenciador.z01_numcgm
			JOIN cgm responsavel ON si06_cgm = responsavel.z01_numcgm
            INNER JOIN pcproc ON si06_processocompra = pc80_codproc
            LEFT JOIN infocomplementaresinstit ON adesaoregprecos.si06_instit = infocomplementaresinstit.si09_instit
			WHERE si06_instit= " . db_getsession('DB_instit') . "
		  		AND ac16_sequencial = " . $sequencial . "
	  ";
        $rsCodunidadeSubAdesao = db_query($sSql);
        $oUnidadeSubAdesao = db_utils::fieldsMemory($rsCodunidadeSubAdesao, 0);

        if ($oUnidadeSubAdesao->si06_codunidadesubant != "") {
            return $oUnidadeSubAdesao->si06_codunidadesubant;
        } else {
            return $oUnidadeSubAdesao->codunidadesubresp;
        }
    }

    /**
     * Funcao usada para retornar licitacao de contratos de origem empenho
     * @param int $iCodContrato
     * @return Object
     */
    public function getLicitacaoByContrato($iCodContrato)
    {

        $sSql = "select liclicita.l20_codigo,liclicita.l20_edital,liclicita.l20_anousu,l20_codepartamento,l20_naturezaobjeto,
                    case when l20_codtipocom = 52 then 1 when l20_codtipocom = 53 then 2 else 0 end as tipoprocesso from acordo
inner join empempenhocontrato on acordo.ac16_sequencial = empempenhocontrato.e100_acordo
inner join empempenho         on empempenho.e60_numemp = empempenhocontrato.e100_numemp
inner join liclicita on ltrim(((string_to_array(e60_numerol, '/'))[1])::varchar,'0') = l20_edital::varchar
              and l20_anousu::varchar = ((string_to_array(e60_numerol, '/'))[2])::varchar
              where ac16_sequencial = {$iCodContrato} order by e100_sequencial limit 1";

        $oLicitacao = db_utils::fieldsMemory(db_query($sSql), 0);

        return $oLicitacao;
    }

    /**
     * Quando um contrato  de origem manual mas o tipo origem  adeso  ata de registro de preo,
     * busca-se os dados do processo licitatrio em: compras>>procedimentos>adeso de registro de preo
     * @param $param
     */
    public function getDadosLicitacaoAdesao($param)
    {
    }

    /**
     * selecionar os dados de Leis de Alterao
     *
     */
    public function gerarDados()
    {

        $clcontratos10 = new cl_contratos102023();
        $clcontratos11 = new cl_contratos112023();
        $clcontratos12 = new cl_contratos122023();
        $clcontratos13 = new cl_contratos132023();
        $clcontratos20 = new cl_contratos202023();
        $clcontratos21 = new cl_contratos212023();
        $clcontratos30 = new cl_contratos302023();
        $clcontratos40 = new cl_contratos402023();

        db_inicio_transacao();
        // matriz de entrada
        $what = array("", chr(13), chr(10), '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', '', '');

        // matriz de sada
        $by = array('', '', '', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ');

        /*
         * excluir informacoes do mes selecionado registro 13
         */
        $result = $clcontratos13->sql_record($clcontratos13->sql_query(NULL, "*", NULL, "si86_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si86_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {

            $clcontratos13->excluir(NULL, "si86_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si86_instit = " . db_getsession("DB_instit"));
            if ($clcontratos13->erro_status == 0) {
                throw new Exception($clcontratos13->erro_msg);
            }
        }

        /*
         * excluir informacoes do mes selecionado registro 12
         */
        $result = $clcontratos12->sql_record($clcontratos12->sql_query(NULL, "*", NULL, "si85_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si85_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {

            $clcontratos12->excluir(NULL, "si85_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si85_instit = " . db_getsession("DB_instit"));
            if ($clcontratos12->erro_status == 0) {
                throw new Exception($clcontratos12->erro_msg);
            }
        }

        /*
        * excluir informacoes do mes selecionado registro 11
        */
        $result = $clcontratos11->sql_record($clcontratos11->sql_query(NULL, "*", NULL, "si84_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si84_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {

            $clcontratos11->excluir(NULL, "si84_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si84_instit = " . db_getsession("DB_instit"));
            if ($clcontratos11->erro_status == 0) {
                throw new Exception($clcontratos11->erro_msg);
            }
        }

        /*
         * excluir informacoes do mes selecionado registro 10
         */
        $result = $clcontratos10->sql_record($clcontratos10->sql_query(NULL, "*", NULL, "si83_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si83_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clcontratos10->excluir(NULL, "si83_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si83_instit = " . db_getsession("DB_instit"));
            if ($clcontratos10->erro_status == 0) {
                throw new Exception($clcontratos10->erro_msg);
            }
        }

        /*
         * excluir informacoes do mes selecionado registro 21
         */
        $result = $clcontratos21->sql_record($clcontratos21->sql_query(NULL, "*", NULL, "si88_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si88_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clcontratos21->excluir(NULL, "si88_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si88_instit = " . db_getsession("DB_instit"));
            if ($clcontratos21->erro_status == 0) {
                throw new Exception($clcontratos21->erro_msg);
            }
        }

        /*
         * excluir informacoes do mes selecionado registro 20
         */
        $result = $clcontratos20->sql_record($clcontratos20->sql_query(NULL, "*", NULL, "si87_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si87_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clcontratos20->excluir(NULL, "si87_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si87_instit = " . db_getsession("DB_instit"));
            if ($clcontratos20->erro_status == 0) {
                throw new Exception($clcontratos20->erro_msg);
            }
        }

        /*
         * excluir informacoes do mes selecionado registro 30
         */
        $result = $clcontratos30->sql_record($clcontratos30->sql_query(NULL, "*", NULL, "si89_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si89_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clcontratos30->excluir(NULL, "si89_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si89_instit = " . db_getsession("DB_instit"));
            if ($clcontratos30->erro_status == 0) {
                throw new Exception($clcontratos30->erro_msg);
            }
        }

        /*
         * excluir informacoes do mes selecionado registro 40
         */
        $result = $clcontratos40->sql_record($clcontratos40->sql_query(NULL, "*", NULL, "si91_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si91_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clcontratos40->excluir(NULL, "si91_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si91_instit = " . db_getsession("DB_instit"));
            if ($clcontratos40->erro_status == 0) {
                throw new Exception($clcontratos40->erro_msg);
            }
        }
        db_fim_transacao();
        $sSql = "SELECT si09_codorgaotce AS codorgao
              FROM infocomplementaresinstit
              WHERE si09_instit = " . db_getsession("DB_instit");

        $rsResult = db_query($sSql);
        $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;

        /*
         * selecionar informacoes registro 10
         */

        $sSql = "SELECT DISTINCT acordo.*,
                    adesaoregprecos.si06_dataadesao as anoproc,
                    adesaoregprecos.si06_numeroadm as numeroproc,
                    liclicita.l20_codigo,
                    liclicita.l20_edital,
                    manutencaolicitacao.manutlic_editalant,
                    liclicita.l20_anousu,
                    liclicita.l20_codepartamento,
                    liclicita.l20_naturezaobjeto,
                    liclicita.l20_tipojulg,
                CASE
                    WHEN p1.pc50_pctipocompratribunal = 100 THEN 2
                    WHEN p1.pc50_pctipocompratribunal = 101 THEN 1
                    WHEN p1.pc50_pctipocompratribunal = 102 THEN 3
                    WHEN p1.pc50_pctipocompratribunal = 103 THEN 4
                    ELSE 0
                END AS tipoprocesso,
                CASE
                    WHEN p2.pc50_pctipocompratribunal = 100 THEN 2
                    WHEN p2.pc50_pctipocompratribunal = 101 THEN 1
                    WHEN p2.pc50_pctipocompratribunal = 102 THEN 3
                    WHEN p2.pc50_pctipocompratribunal = 103 THEN 4
                    ELSE 0
                END AS tipoprocessolicitacao,
                    ac16_tipoorigem AS contdeclicitacao,
                    ac16_origem,
                (CASE
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
                 END) AS codunidadesubresp,
                      CASE WHEN l2.l20_edital = NULL THEN NULL ELSE l2.l20_edital END AS editalmanual,
                      CASE WHEN l2.l20_codigo = NULL THEN NULL ELSE l2.l20_codigo END AS codlicmanual,
                      CASE WHEN l2.l20_anousu = NULL THEN NULL ELSE l2.l20_anousu END AS anousumanual,
                      CASE WHEN l2.l20_codepartamento = NULL THEN NULL ELSE l2.l20_codepartamento END AS departmanual,
                      CASE WHEN l2.l20_naturezaobjeto = NULL THEN NULL ELSE l2.l20_naturezaobjeto END AS naturezamanual,
                      ac02_acordonatureza,
                      ac16_veiculodivulgacao,
                      ac16_tipocadastro,
                      lic211_codorgaoresplicit,
					  lic211_codunisubres,
					  lic211_processo,
					  lic211_anousu,
                      si06_departamento,
                      manutac_codunidsubanterior,
                      manutac_numeroant,
                      m2.manutlic_codunidsubanterior
                FROM acordoitem
                INNER JOIN acordoposicao ON ac20_acordoposicao = ac26_sequencial
                INNER JOIN acordo ON ac16_sequencial = ac26_acordo
                LEFT JOIN acordoliclicitem ON ac24_acordoitem = ac20_sequencial
                LEFT JOIN liclicitem ON l21_codigo = ac24_liclicitem
                LEFT JOIN liclicita ON l21_codliclicita = l20_codigo
                LEFT JOIN manutencaolicitacao on manutlic_licitacao = l20_codigo
                LEFT JOIN liclicitaoutrosorgaos ON lic211_sequencial = ac16_licoutroorgao
                LEFT JOIN db_departorg ON l20_codepartamento = db01_coddepto
                AND db01_anousu = " . db_getsession("DB_anousu") . "
                LEFT JOIN orcunidade ON db01_orgao = o41_orgao
                AND db01_unidade = o41_unidade
                AND db01_anousu = o41_anousu
                AND o41_anousu = " . db_getsession("DB_anousu") . "
                LEFT JOIN orcorgao ON o40_orgao = o41_orgao
                AND o40_anousu = o41_anousu
                LEFT JOIN cflicita ON l20_codtipocom = l03_codigo
                LEFT JOIN pctipocompra p1 ON p1.pc50_codcom = l03_codcom
                LEFT JOIN liclicita l2 ON l2.l20_codigo = acordo.ac16_licitacao
                LEFT JOIN manutencaolicitacao m2 on m2.manutlic_licitacao = l2.l20_codigo
                LEFT JOIN adesaoregprecos ON si06_sequencial = ac16_adesaoregpreco
                LEFT JOIN cflicita c2 ON l2.l20_codtipocom = c2.l03_codigo
                LEFT JOIN pctipocompra p2 ON p2.pc50_codcom = c2.l03_codcom
                INNER JOIN acordogrupo ON ac02_sequencial = ac16_acordogrupo
                LEFT JOIN manutencaoacordo ON manutac_acordo = ac16_sequencial
                WHERE ac16_datareferencia <= '{$this->sDataFinal}'
                AND ac16_datareferencia >= '{$this->sDataInicial}'
                AND ac16_instit = " . db_getsession("DB_instit");
        $rsResult10 = db_query($sSql);

        db_inicio_transacao();

        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

            $clcontratos10 = new cl_contratos102023();

            $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

            $sSql = "select CASE WHEN o40_codtri = '0'
                     OR NULL THEN o40_orgao::varchar ELSE o40_codtri END AS db01_orgao,
                     CASE WHEN o41_codtri = '0'
                     OR NULL THEN o41_unidade::varchar ELSE o41_codtri END AS db01_unidade,o41_subunidade from db_departorg
                     join orcunidade on db01_orgao = o41_orgao and db01_unidade = o41_unidade
                     and db01_anousu = o41_anousu
                     JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                     where db01_anousu = " . db_getsession("DB_anousu") . " and db01_coddepto = " . $oDados10->ac16_deptoresponsavel;

            $rsDepart = db_query($sSql);
            $sOrgDepart = db_utils::fieldsMemory($rsDepart, 0)->db01_orgao;
            $sUnidDepart = db_utils::fieldsMemory($rsDepart, 0)->db01_unidade;
            $sSubUnidade = db_utils::fieldsMemory($rsDepart, 0)->o41_subunidade;


            $sCodUnidade = str_pad($sOrgDepart, 2, "0", STR_PAD_LEFT) . str_pad($sUnidDepart, 3, "0", STR_PAD_LEFT);
            if ($sSubUnidade == 1) {
                $sCodUnidade .= str_pad($sSubUnidade, 3, "0", STR_PAD_LEFT);
            }

            if (($oDados10->ac16_origem == self::ORIGEM_MANUAL || $oDados10->ac16_origem == self::ORIGEM_PROCESSO_COMPRAS) && $oDados10->departmanual != null) {

                $sSqlManual = "select CASE WHEN o40_codtri = '0'
                     OR NULL THEN o40_orgao::varchar ELSE o40_codtri END AS db01_orgao,
                     CASE WHEN o41_codtri = '0'
                     OR NULL THEN o41_unidade::varchar ELSE o41_codtri END AS db01_unidade,o41_subunidade from db_departorg
                     join orcunidade on db01_orgao = o41_orgao and db01_unidade = o41_unidade
                     and db01_anousu = o41_anousu
                     JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                     where db01_anousu = " . db_getsession("DB_anousu") . " and db01_coddepto = " . $oDados10->departmanual;

                $rsDepartManual = db_query($sSqlManual);

                $sOrgDepartM = db_utils::fieldsMemory($rsDepartManual, 0)->db01_orgao;
                $sUnidDepartM = db_utils::fieldsMemory($rsDepartManual, 0)->db01_unidade;
                $sSubUnidadeM = db_utils::fieldsMemory($rsDepartManual, 0)->o41_subunidade;

                $sCodUnidadeM = str_pad($sOrgDepartM, 2, "0", STR_PAD_LEFT) . str_pad($sUnidDepartM, 3, "0", STR_PAD_LEFT);
                if ($sSubUnidade == 1) {
                    $sCodUnidadeM .= str_pad($sSubUnidadeM, 3, "0", STR_PAD_LEFT);
                }
            }
            /*
             * Verificar se o contrato vem de licitacao mas foi vinculado apenas ao empenho
             * por ser Origem empenho
             */
            if ($oDados10->ac16_origem == self::ORIGEM_EMPENHO && in_array($oDados10->contdeclicitacao, array(2, 3))) {
                $oLicitacao = $this->getLicitacaoByContrato($oDados10->ac16_sequencial);
                $oDados10->l20_edital = $oLicitacao->l20_edital;
                $oDados10->l20_anousu = $oLicitacao->l20_anousu;
                $oDados10->l20_naturezaobjeto = $oLicitacao->l20_naturezaobjeto;
                $oDados10->tipoprocesso = empty($oLicitacao->tipoprocesso) ? 0 : $oLicitacao->tipoprocesso;
                $oDados10->l20_codigo = $oLicitacao->l20_codigo;
            }
            /*
             * verificar se o contrato e licitacao e foi vinculado a licitacao
             * por ser origem Manual
             */
            if ($oDados10->ac16_origem == self::ORIGEM_MANUAL && in_array($oDados10->contdeclicitacao, array(2, 3))) {
                $oDados10->l20_edital = $oDados10->editalmanual;
                $oDados10->l20_anousu = $oDados10->anousumanual;
                $oDados10->l20_naturezaobjeto = $oDados10->naturezamanual;
                $oDados10->l20_codigo = $oDados10->codlicmanual;
                $oDados10->l20_codepartamento = $oDados10->departmanual;
            }

            /*
            *verifica se existe codigo anterior para processo
            *OC20603
            */
            if($oDados10->manutlic_editalant != ''){
                $oDados10->l20_edital = $oDados10->manutlic_editalant;
            }

            $clcontratos10->si83_tiporegistro = 10; //campo 01
            $clcontratos10->si83_codcontrato = $oDados10->ac16_sequencial; //campo 03
            $clcontratos10->si83_codorgao = $sCodorgao; //campo 04
            if ($oDados10->manutac_codunidsubanterior != '' && $oDados10->manutac_codunidsubanterior != null) {
                $clcontratos10->si83_codunidadesub = $oDados10->manutac_codunidsubanterior; //campo 05
            } else {
                $clcontratos10->si83_codunidadesub = $sCodUnidade; //campo 05
            }
            $clcontratos10->si83_nrocontrato = $oDados10->manutac_acordo =='' ? $oDados10->ac16_numeroacordo : $oDados10->manutac_acordo; //campo 06
            $clcontratos10->si83_exerciciocontrato = $oDados10->ac16_anousu; //campo 07
            $clcontratos10->si83_dataassinatura = $oDados10->ac16_dataassinatura; //campo 08
            $clcontratos10->si83_contdeclicitacao = $oDados10->contdeclicitacao; //campo 09
            $clcontratos10->si83_codorgaoresp = ''; //campo 10

            if ($oDados10->ac16_origem == self::ORIGEM_PROCESSO_COMPRAS && in_array($oDados10->contdeclicitacao, array(2, 3))) {
                $oDados10->l20_edital = $oDados10->editalmanual;
                $oDados10->l20_anousu = $oDados10->anousumanual;
                $oDados10->l20_naturezaobjeto = $oDados10->naturezamanual;
                $oDados10->l20_codigo = $oDados10->codlicmanual;
                $oDados10->l20_codepartamento = $oDados10->departmanual;
             }

            if (in_array($oDados10->contdeclicitacao, array(1, 8, 9))) {
                $clcontratos10->si83_codunidadesubresp = ''; //campo 11
            } 

            /*
            * Origem  = 1 - Processo de Compras, 2 - Licitacao , 3 - Manual
            * Tipo origem = 2 - Licitacao , 3 - Dispensa ou Inexgibilidade
            */
            if (in_array($oDados10->ac16_origem, array(1, 2, 3)) && in_array($oDados10->contdeclicitacao, array(2, 3,))) {
                $clcontratos10->si83_codunidadesubresp = $oDados10->manutlic_codunidsubanterior == "" ? $sCodUnidadeM : $oDados10->manutlic_codunidsubanterior; //campo 11
            } 

            /*
            * Origem  = 1 - Processo de Compras, 2 - Licitacao
            * Tipo origem = 4 - Ades�o � ata de registro de pre�os
            */
            if ($oDados10->contdeclicitacao == 4) {
                if ($oDados10->si06_departamento == null) {
                    $clcontratos10->si83_codunidadesubresp = $this->getCodunidadesubrespAdesao($oDados10->ac16_sequencial, false); //campo 11
                } else {
                    $clcontratos10->si83_codunidadesubresp = $this->getCodunidadesubrespAdesao($oDados10->ac16_sequencial, true); //campo 11
                }
            } 
            
            //LICITACAO DE OUTROS ORGAOS
            if (in_array($oDados10->contdeclicitacao, array(5, 6, 7))) {
                $clcontratos10->si83_codorgaoresp = $oDados10->lic211_codorgaoresplicit; //campo 10
                $clcontratos10->si83_codunidadesubresp = $oDados10->lic211_codunisubres; //campo 11
            } 

            if ($oDados10->ac16_origem == self::ORIGEM_MANUAL || $oDados10->ac16_origem == self::ORIGEM_PROCESSO_COMPRAS) {
                if ($oDados10->ac16_tipoorigem == self::TIPO_ORIGEM_ADESAO_REGISTRO_PRECO) {
                    $clcontratos10->si83_nroprocesso = $oDados10->numeroproc; //campo 12
                    $clcontratos10->si83_exercicioprocesso = substr($oDados10->anoproc, 0, 4); //campo 13
                } elseif (in_array($oDados10->contdeclicitacao, array(5, 6, 7, 8, 9))) {
                    $clcontratos10->si83_nroprocesso = $oDados10->lic211_processo; //campo 12
                    $clcontratos10->si83_exercicioprocesso = $oDados10->lic211_anousu; //campo 13
                } else {
                    $clcontratos10->si83_nroprocesso = in_array($oDados10->contdeclicitacao, array(2, 3)) ? $oDados10->l20_edital : ' '; //campo 12
                    $clcontratos10->si83_exercicioprocesso = in_array($oDados10->contdeclicitacao, array(2, 3)) ? $oDados10->l20_anousu : ' '; //campo 13
                }
            } else {
                $clcontratos10->si83_nroprocesso = in_array($oDados10->contdeclicitacao, array(2, 3)) ? $oDados10->l20_edital : ' '; //campo 12
                $clcontratos10->si83_exercicioprocesso = in_array($oDados10->contdeclicitacao, array(2, 3)) ? $oDados10->l20_anousu : ' '; //campo 13
            }
            if ($oDados10->tipoprocesso == '' || $oDados10->tipoprocesso == 0) {
                $clcontratos10->si83_tipoprocesso = $oDados10->tipoprocessolicitacao; //campo 14
            } else {
                $clcontratos10->si83_tipoprocesso = $oDados10->tipoprocesso; //campo 14
            }
            $clcontratos10->si83_naturezaobjeto = $oDados10->ac02_acordonatureza; //campo 15
            $clcontratos10->si83_objetocontrato = substr($this->removeCaracteres($oDados10->ac16_objeto), 0, 1000); //campo 16
            $clcontratos10->si83_tipoinstrumento = $oDados10->ac16_acordocategoria; //removido
            $clcontratos10->si83_datainiciovigencia = $oDados10->ac16_datainicio; //campo 17
            $clcontratos10->si83_datafinalvigencia = $oDados10->ac16_datafim; //campo 18
            $oAcordo = new Acordo($oDados10->ac16_sequencial);
            $clcontratos10->si83_vlcontrato = $oDados10->ac16_valor; //campo 19
            //OC10386
            if ($oDados10->ac02_acordonatureza == '4' || $oDados10->ac02_acordonatureza == '5') {
                $clcontratos10->si83_formafornecimento = ''; //campo 20
                $clcontratos10->si83_formapagamento = ''; //campo 21
                $clcontratos10->si83_unidadedemedidaprazoexec = ''; //campo 29
                $clcontratos10->si83_prazoexecucao = ''; //campo 30
                $clcontratos10->si83_multarescisoria = ''; //campo 31
                $clcontratos10->si83_multainadimplemento = ''; //campo 32
                $clcontratos10->si83_garantia = ''; //campo 33
            } else {
                $clcontratos10->si83_formafornecimento = $this->removeCaracteres($oDados10->ac16_formafornecimento); //campo 20
                $clcontratos10->si83_formapagamento = $this->removeCaracteres($oDados10->ac16_formapagamento); //campo 21
                $clcontratos10->si83_unidadedemedidaprazoexec = $oDados10->ac16_tipounidtempoperiodo; //campo 29
                $clcontratos10->si83_prazoexecucao = $oDados10->ac16_qtdperiodo; //campo 30
                $clcontratos10->si83_multarescisoria = substr($this->removeCaracteres($this->getPenalidadeByAcordo($oDados10->ac16_sequencial, 1)), 0, 99); //campo 31
                $clcontratos10->si83_multainadimplemento = substr($this->removeCaracteres($this->getPenalidadeByAcordo($oDados10->ac16_sequencial, 2)), 0, 99); //campo 32
                $clcontratos10->si83_garantia = $this->getGarantiaByAcordo($oDados10->ac16_sequencial); //campo 33
            }
            //FIM OC10386
            $clcontratos10->si83_cpfsignatariocontratante = $oAcordo->getCpfsignatariocontratante(); //campo 34
            $clcontratos10->si83_datapublicacao = $oDados10->ac16_datapublicacao; //campo 35
            $clcontratos10->si83_veiculodivulgacao = $this->removeCaracteres($oDados10->ac16_veiculodivulgacao); //campo 36
            $clcontratos10->si83_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clcontratos10->si83_instit = db_getsession('DB_instit');
            $clcontratos10->si83_tipocadastro = $oDados10->ac16_tipocadastro;
            if ($oDados10->ac16_reajuste == 'f') {
                $clcontratos10->si83_indcriterioreajuste = 2; //campo 22
                $clcontratos10->si83_databasereajuste = ''; //campo 23
                $clcontratos10->si83_periodicidadereajuste = ''; //campo 24
                $clcontratos10->si83_tipocriterioreajuste = ''; //campo 25
                $clcontratos10->si83_dscindice = ''; //campo 26
                $clcontratos10->si83_indiceunicoreajuste = ''; //campo 27
                $clcontratos10->si83_dscreajuste = ''; //campo 28
            } else {
                $clcontratos10->si83_indcriterioreajuste = 1; //campo 22
                $clcontratos10->si83_databasereajuste = $oDados10->ac16_datareajuste; //campo 23
                $clcontratos10->si83_periodicidadereajuste = $oDados10->ac16_periodoreajuste; //campo 24
                $clcontratos10->si83_tipocriterioreajuste = $oDados10->ac16_criterioreajuste; //campo 25
                if ($oDados10->ac16_criterioreajuste == 2 || $oDados10->ac16_criterioreajuste == 3) {
                    $clcontratos10->si83_dscreajuste = $this->removeCaracteres($oDados10->ac16_descricaoreajuste); //campo 28
                    $clcontratos10->si83_indiceunicoreajuste = 0; //campo 27
                    $clcontratos10->si83_dscindice = ''; //campo 26
                } else {
                    $clcontratos10->si83_dscreajuste = ''; //campo 28
                    $clcontratos10->si83_indiceunicoreajuste = $oDados10->ac16_indicereajuste; //campo 27
                    if ($oDados10->ac16_indicereajuste == 6) {
                        $clcontratos10->si83_dscindice = $this->removeCaracteres($oDados10->ac16_descricaoindice); //campo 26
                    } else {
                        $clcontratos10->si83_dscindice = ''; //campo 26
                    }
                }
            }


            $clcontratos10->incluir(null);

            if ($clcontratos10->erro_status == 0) {
                throw new Exception($clcontratos10->erro_msg);
            }

            /*
             * selecionar informacoes registro 11
             */



            //OC10386
            if ($oDados10->ac02_acordonatureza != "4" && $oDados10->ac02_acordonatureza != "5") {

                $aDadosAgrupados = array();
                foreach ($oAcordo->getItensPosicaoInicial() as $oItens) {
                    $iUnidade = $oItens->getUnidade() == "" ? 1 : $oItens->getUnidade();
                    if ($oItens->getMaterial()->getCodanterior() == null) {
                        $iCodItem = $oItens->getMaterial()->getCodigo() . $iUnidade;
                    } else {
                        $iCodItem = $oItens->getMaterial()->getCodanterior();
                    }
                    $iCodPcmater = $oItens->getMaterial()->getMaterial();

                    /**
                     * busca itens obra;
                     */
                    $sqlItemobra = "select * from licitemobra where obr06_pcmater = $iCodPcmater";
                    $rsItems = db_query($sqlItemobra);
                    $oDadosItensObra = db_utils::fieldsMemory($rsItems, 0);

                    /*
                    * Buscas os lote do item
                    */
                    if ($oDados10->ac16_origem == self::ORIGEM_LICITACAO && $oDados10->l20_tipojulg == 3) {
                        $sSqlItemLote = "select l04_descricao
                        from liclicitemlote
                        inner join liclicitem on l21_codigo = l04_liclicitem
                        inner join liclicita on l21_codliclicita = l20_codigo
                        inner join pcprocitem on l21_codpcprocitem = pc81_codprocitem
                        inner join solicitem on pc11_codigo = pc81_solicitem
                        inner join solicitempcmater on pc16_solicitem =pc11_codigo
                        where l20_codigo = " . $oDados10->ac16_licitacao . " and pc16_codmater = " . $iCodPcmater;

                        $rsItemLote = db_query($sSqlItemLote);
                        $oItemLote = db_utils::fieldsMemory($rsItemLote, 0);
                    }


                    $sHash = $iCodItem;
                    if (!isset($aDadosAgrupados[$sHash])) {

                        $oContrato11 = new stdClass();
                        $oContrato11->si84_tiporegistro = 11; //campo 01
                        $oContrato11->si84_reg10 = $clcontratos10->si83_sequencial;
                        $oContrato11->si84_codcontrato = $oDados10->ac16_sequencial; //campo 02
                        if ($oDados10->ac16_origem == self::ORIGEM_LICITACAO && $oDados10->l20_tipojulg == 3) {
                            $oContrato11->si84_nrolote = preg_replace("/[^0-9]/", "", $oItemLote->l04_descricao); //campo 03
                        } else {
                            $oContrato11->si84_nrolote = 0; //campo 03
                        }
                        if ($oDados10->ac02_acordonatureza == "1") {
                            if ($oDadosItensObra->obr06_tabela == "3" || $oDadosItensObra->obr06_tabela == "4") {
                                $oContrato11->si84_coditem = $iCodItem; //campo 04
                            } else {
                                $oContrato11->si84_coditem = null; //campo 04
                            }
                        } else {
                            $oContrato11->si84_coditem = $iCodItem; //campo 04
                        }
                        $oContrato11->si84_quantidadeitem = $oItens->getQuantidade(); //campo 10
                        $oContrato11->si84_valorunitarioitem = $oItens->getValorUnitario(); //campo 11
                        $oContrato11->si84_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                        $oContrato11->si84_instit = db_getsession("DB_instit");
                        $oContrato11->si84_tipomaterial = $oDadosItensObra->obr06_tabela; //campo 05
                        if ($oDadosItensObra->obr06_tabela == "1") {
                            $oContrato11->si84_coditemsinapi = $oDadosItensObra->obr06_codigotabela; //campo 06
                            $oContrato11->si84_coditemsimcro = null; //campo 07
                            $oContrato11->si84_descoutrosmateriais = null; //campo 08
                        } elseif ($oDadosItensObra->obr06_tabela == "2") {
                            $oContrato11->si84_coditemsimcro = $oDadosItensObra->obr06_codigotabela; //campo 07
                            $oContrato11->si84_coditemsinapi = null; //campo 06
                            $oContrato11->si84_descoutrosmateriais = null; //campo 08
                        } elseif ($oDadosItensObra->obr06_tabela == "3") {
                            $oContrato11->si84_coditemsinapi = null; //campo 06
                            $oContrato11->si84_coditemsimcro = null; //campo 07
                            $oContrato11->si84_descoutrosmateriais = $oDadosItensObra->obr06_descricaotabela; //campo 08
                        }
                        $oContrato11->si84_itemplanilha = $oDadosItensObra->obr06_pcmater; //campo 09
                        $aDadosAgrupados[$sHash] = $oContrato11;
                    } else {
                        $aDadosAgrupados[$sHash]->si84_quantidadeitem += $oItens->getQuantidade();
                        $aDadosAgrupados[$sHash]->si84_valorunitarioitem = $oItens->getValorUnitario();
                    }
                }

                foreach ($aDadosAgrupados as $oDadosReg11) {

                    $clcontratos11 = new cl_contratos112023();

                    $clcontratos11->si84_tiporegistro = 11;
                    $clcontratos11->si84_reg10 = $oDadosReg11->si84_reg10;
                    $clcontratos11->si84_codcontrato = $oDadosReg11->si84_codcontrato;
                    $clcontratos11->si84_nrolote = $oDadosReg11->si84_nrolote;
                    $clcontratos11->si84_coditem = $oDadosReg11->si84_coditem;
                    $clcontratos11->si84_quantidadeitem = $oDadosReg11->si84_quantidadeitem;
                    $clcontratos11->si84_valorunitarioitem = $oDadosReg11->si84_valorunitarioitem;
                    $clcontratos11->si84_mes = $oDadosReg11->si84_mes;
                    $clcontratos11->si84_instit = $oDadosReg11->si84_instit;
                    $clcontratos11->si84_tipomaterial = $oDadosReg11->si84_tipomaterial;
                    $clcontratos11->si84_coditemsimcro = $oDadosReg11->si84_coditemsimcro;
                    $clcontratos11->si84_coditemsinapi = $oDadosReg11->si84_coditemsinapi;
                    $clcontratos11->si84_descoutrosmateriais = $oDadosReg11->si84_descoutrosmateriais;
                    $clcontratos11->si84_itemplanilha = $oDadosReg11->si84_itemplanilha;

                    $clcontratos11->incluir(null);
                    if ($clcontratos11->erro_status == 0) {
                        throw new Exception($clcontratos11->erro_msg);
                    }
                }

                /*
                 * selecionar informacoes registro 12
                 */

                $aDadosAgrupados12 = array();

                if ($clcontratos10->si83_naturezaobjeto != 4 || $clcontratos10->si83_naturezaobjeto != 5) {

                    /**
                     * Acordos de origem manual e processo de compras e NO HOUVER empenho
                     */
                    foreach ($oAcordo->getItensPosicaoInicial() as $oItens) {
                        foreach ($oItens->getDotacoes() as $oDotacao) {

                            $sSqlDotacoes = "SELECT distinct on (o58_coddot)
                                         o58_coddot,
                                         CASE WHEN o40_codtri = '0'
                                         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END AS o58_orgao,
                                         CASE WHEN o41_codtri = '0'
                                         OR NULL THEN o41_unidade::varchar ELSE o41_codtri END AS o58_unidade,
                                         o58_funcao,
                                         o58_subfuncao,
                                         o58_programa,
                                         o58_projativ,
                                         o55_origemacao,
                                         o56_elemento,
                                         o15_codtri,
                                         o58_valor,
                                         o41_subunidade
                                         from
                                         orcdotacao
                                         JOIN orcelemento ON o58_codele = o56_codele and o58_anousu = o56_anousu
                                        AND o56_anousu = " . db_getsession("DB_anousu") . "
                                        JOIN orctiporec ON o58_codigo = o15_codigo
                                        JOIN orcprojativ ON o55_projativ = o58_projativ
                                        AND o55_anousu = o58_anousu
                                        JOIN orcunidade ON o58_orgao = o41_orgao
                                        AND o58_unidade = o41_unidade
                                        AND o58_anousu = o41_anousu
                                        JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                                        where o58_coddot = {$oDotacao->dotacao}";

                            $rsDados = db_query($sSqlDotacoes);

                            for ($iContDot = 0; $iContDot < pg_num_rows($rsDados); $iContDot++) {
                                $oDadosElemento = db_utils::fieldsMemory($rsDados, $iContDot);

                                $sHash = $oAcordo->getCodigo() . $sCodorgao . str_pad($oDadosElemento->o58_orgao, 2, "0", STR_PAD_LEFT) . str_pad($oDadosElemento->o58_unidade, 3, "0", STR_PAD_LEFT);
                                $sHash .= $oDadosElemento->o58_funcao . $oDadosElemento->o58_subfuncao . $oDadosElemento->o58_programa . $oDadosElemento->o58_projativ;
                                $sHash .= $oDadosElemento->o56_elemento . $oDadosElemento->o15_codtri;

                                if (!isset($aDadosAgrupados12[$sHash])) {

                                    $sCodUnidade = str_pad($oDadosElemento->o58_orgao, 2, "0", STR_PAD_LEFT) . str_pad($oDadosElemento->o58_unidade, 3, "0", STR_PAD_LEFT);
                                    if ($oDadosElemento->o41_subunidade != 0 || $oDadosElemento->o41_subunidade = null) {
                                        $sCodUnidade .= str_pad($oDadosElemento->o41_subunidade, 3, "0", STR_PAD_LEFT);
                                    }
                                    $result = db_dotacaosaldo(8, 2, 2, true, " o58_coddot = {$oDadosElemento->o58_coddot} and o58_anousu = {$oAcordo->getAno()}", $oAcordo->getAno(), $oAcordo->getDataAssinatura(), $oAcordo->getDataAssinatura());
                                    if (pg_num_rows($result) > 0) {
                                        $oDot = db_utils::fieldsMemory($result, 0);
                                        $oDadosElemento->o58_valor = ($oDot->dot_ini + $oDot->suplementado_acumulado - $oDot->reduzido_acumulado) - $oDot->empenhado_acumulado + $oDot->anulado_acumulado;
                                    }

                                    $oContrato12 = new stdClass();
                                    $oContrato12->si85_tiporegistro = 12; //campo 01
                                    $oContrato12->si85_reg10 = $clcontratos10->si83_sequencial;
                                    $oContrato12->si85_codcontrato = $oAcordo->getCodigo(); //campo 02
                                    $oContrato12->si85_codorgao = $sCodorgao; //campo 03
                                    if ($oDados10->manutac_codunidsubanterior != '' && $oDados10->manutac_codunidsubanterior != null) {
                                        $oContrato12->si85_codunidadesub = $oDados10->manutac_codunidsubanterior; //campo 04
                                    } else {
                                        $oContrato12->si85_codunidadesub = $sCodUnidade; //campo 04
                                    }
                                    $oContrato12->si85_codfuncao = $oDadosElemento->o58_funcao; //campo 05
                                    $oContrato12->si85_codsubfuncao = $oDadosElemento->o58_subfuncao; //campo 06
                                    $oContrato12->si85_codprograma = $oDadosElemento->o58_programa; //campo 07
                                    $oContrato12->si85_idacao = $oDadosElemento->o58_projativ; //campo 08
                                    $oContrato12->si85_idsubacao = $oDadosElemento->o55_origemacao; //campo 09
                                    $oContrato12->si85_naturezadespesa = $oDadosElemento->o56_elemento; //campo 10
                                    $oContrato12->si85_codfontrecursos = $oDadosElemento->o15_codtri; //campo 11
                                    $oContrato12->si85_vlrecurso = $oDadosElemento->o58_valor; //removido
                                    $oContrato12->si85_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                                    $oContrato12->si85_instit = db_getsession("DB_instit");
                                    $aDadosAgrupados12[$sHash] = $oContrato12;
                                } else {
                                    $aDadosAgrupados12[$sHash]->si85_vlrecurso += $oDadosElemento->o58_valor;
                                }
                            }
                        }
                    }
                }

                foreach ($aDadosAgrupados12 as $oDadosReg12) {

                    $clcontratos12 = new cl_contratos122023();
                    $clcontratos12->si85_tiporegistro = 12; //campo 01
                    $clcontratos12->si85_reg10 = $oDadosReg12->si85_reg10;
                    $clcontratos12->si85_codcontrato = $oDadosReg12->si85_codcontrato; //campo 02
                    $clcontratos12->si85_codorgao = $oDadosReg12->si85_codorgao; //campo 03
                    $clcontratos12->si85_codunidadesub = $oDadosReg12->si85_codunidadesub; //campo 04
                    $clcontratos12->si85_codfuncao = $oDadosReg12->si85_codfuncao; //campo 05
                    $clcontratos12->si85_codsubfuncao = $oDadosReg12->si85_codsubfuncao; //campo 06
                    $clcontratos12->si85_codprograma = $oDadosReg12->si85_codprograma; //campo 07
                    $clcontratos12->si85_idacao = $oDadosReg12->si85_idacao; //campo 08
                    $clcontratos12->si85_idsubacao = $oDadosReg12->si85_idsubacao; //campo 09
                    $clcontratos12->si85_naturezadespesa = substr($oDadosReg12->si85_naturezadespesa, 1, 6); //campo 10
                    $clcontratos12->si85_codfontrecursos = $oDadosReg12->si85_codfontrecursos; //campo 11
                    $clcontratos12->si85_vlrecurso = $oDadosReg12->si85_vlrecurso; //removido
                    $clcontratos12->si85_mes = $oDadosReg12->si85_mes;
                    $clcontratos12->si85_instit = $oDadosReg12->si85_instit;

                    $clcontratos12->incluir(null);

                    if ($clcontratos12->erro_status == 0) {
                        throw new Exception($clcontratos12->erro_msg);
                    }
                }
            }
            //FIM OC10386
            $sSql = "select case when length(fornecedor.z01_cgccpf) = 11 then 1 else 2 end as tipodocumento,fornecedor.z01_cgccpf as nrodocumento,
                representante.z01_cgccpf as nrodocrepresentantelegal
                from cgm as fornecedor
                join pcfornereprlegal on fornecedor.z01_numcgm = pcfornereprlegal.pc81_cgmforn
                join cgm as representante on pcfornereprlegal.pc81_cgmresp = representante.z01_numcgm
                where pcfornereprlegal.pc81_tipopart in (1,3) and fornecedor.z01_numcgm = " . $oAcordo->getContratado()->getCodigo();

            $rsResult13 = db_query($sSql); //db_criatabela($rsResult13);
            $oDados13 = db_utils::fieldsMemory($rsResult13, 0);
            $clcontratos13 = new cl_contratos132023;
            $clcontratos13->si86_tiporegistro = 13; //campo 01
            $clcontratos13->si86_codcontrato = $oAcordo->getCodigo(); //campo 02
            $clcontratos13->si86_tipodocumento = $oDados13->tipodocumento; //campo 03
            $clcontratos13->si86_nrodocumento = $oDados13->nrodocumento; //campo 04
            if (strlen($oDados13->nrodocrepresentantelegal) == 11) {
                $clcontratos13->si86_tipodocrepresentante = 1; //campo 05
            } elseif (strlen($oDados13->nrodocrepresentantelegal) == 14) {
                $clcontratos13->si86_tipodocrepresentante = 2; //campo 05
            } else {
                $clcontratos13->si86_tipodocrepresentante = 3; //campo 05
            }
            $clcontratos13->si86_nrodocrepresentantelegal = substr($oDados13->nrodocrepresentantelegal, 0, 14); //campo 06
            $clcontratos13->si86_reg10 = $clcontratos10->si83_sequencial;
            $clcontratos13->si86_instit = db_getsession("DB_instit");
            $clcontratos13->si86_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

            $clcontratos13->incluir(null);

            if ($clcontratos13->erro_status == 0) {
                throw new Exception($clcontratos13->erro_msg);
            }
        }

        /*
         * Registro 20
         * Detalhamento dos Termos Aditivos dos Contratos
         *
         */

        $sSql = "
        SELECT DISTINCT ac26_sequencial,
                ac16_sequencial,
                ac16_dataassinatura,
                ac16_numero,
                ac26_numeroaditamento,
                ac35_dataassinaturatermoaditivo,
                ac35_descricaoalteracao,
                ac35_datapublicacao,
                ac35_veiculodivulgacao,
                ac16_deptoresponsavel,
                ac26_numero,
                ac26_acordoposicaotipo,
                ac26_vigenciaalterada,
                ac26_data,
                ac26_indicereajuste,
                ac26_percentualreajuste,
                ac26_descricaoindice,
                ac02_acordonatureza,
                manutac_codunidsubanterior,
                manutac_numeroant,
                ac35_datareferencia
        FROM acordoposicaoaditamento
        INNER JOIN acordoposicao ON ac26_sequencial = ac35_acordoposicao
        INNER JOIN acordo ON ac26_acordo = ac16_sequencial
        INNER JOIN acordogrupo ON ac16_acordogrupo = ac02_sequencial
        LEFT JOIN manutencaoacordo ON manutac_acordo = ac16_sequencial
        WHERE ac35_datareferencia BETWEEN '{$this->sDataInicial}' AND '{$this->sDataFinal}'
          AND ac16_instit = " . db_getsession("DB_instit") . " ORDER BY ac26_sequencial ";

        $rsResult20 = db_query($sSql);
        //echo $sSql;
        //db_criatabela($rsResult20);
        $oDadosAgrupados20 = array();
        for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

            $clcontratos20 = new cl_contratos202023();
            $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);
            $oAcordoPosicao = new AcordoPosicao($oDados20->ac26_sequencial);
            $oAcordo = new Acordo($oDados20->ac16_sequencial);
            $oDadosAgrupados21 = array();

            $sSQL20 = "
           select si87_codaditivo
               from contratos202023
               where si87_codaditivo = {$oDados20->ac26_sequencial}
           ";
            $rsConsultaR20  = db_query($sSQL20);
            if (pg_num_rows($rsConsultaR20) > 0) {
                continue;
            }

            $sSql = "select  (CASE
                    WHEN o41_subunidade != 0
                        OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
                        OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                        OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
                    ELSE lpad((CASE WHEN o40_codtri = '0'
                        OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                        OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
                    END) as codunidadesub
                    from db_departorg join orcunidade on db01_orgao = o41_orgao and db01_unidade = o41_unidade
                        and db01_anousu = o41_anousu
                    JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                    where db01_anousu = " . db_getsession("DB_anousu") . " and db01_coddepto = " . $oDados20->ac16_deptoresponsavel;
            $result = db_query($sSql);

            $sCodUnidade = db_utils::fieldsMemory($result, 0)->codunidadesub;

            /*
            * ESSE IF FOI CRIADO PARA SEPARAR OS TIPOS 11 e 14 DOS OUTROS TIPOS
            */
            if (!in_array($oAcordoPosicao->getTipo(), array(11, 14))) {
                //var_dump($oAcordoPosicao->getTipo());
                $clcontratos20->si87_tiporegistro = 20; //campo 01
                $clcontratos20->si87_codaditivo = $oDados20->ac26_sequencial; //campo 02
                $clcontratos20->si87_codorgao = $sCodorgao; //campo 03
                if (empty($oDados20->manutac_codunidsubanterior)) {
                    $clcontratos20->si87_codunidadesub = $sCodUnidade; //campo 04
                } else {
                    $clcontratos20->si87_codunidadesub = $oDados20->manutac_codunidsubanterior; //campo 04
                }
                $clcontratos20->si87_nrocontrato = $oDados20->manutac_numeroant == '' ? $oDados20->ac16_numero : $oDados20->manutac_numeroant; //campo 05
                $clcontratos20->si87_dtassinaturacontoriginal = $oDados20->ac16_dataassinatura; //campo 06
                $clcontratos20->si87_nroseqtermoaditivo = $oDados20->ac26_numeroaditamento; //campo 07
                $clcontratos20->si87_dtassinaturatermoaditivo = $oDados20->ac35_dataassinaturatermoaditivo; //campo 08
                $clcontratos20->si87_tipotermoaditivo = $this->getTipoTermoAditivo($oAcordoPosicao); //campo 10
                $clcontratos20->si87_dscalteracao = substr($this->removeCaracteres($oDados20->ac35_descricaoalteracao), 0, 250); //campo 11
                $oDataTermino = new DBDate($oAcordoPosicao->getVigenciaFinal()); //317
                if (in_array($oAcordoPosicao->getTipo(), array(6, 13))) {
                    $clcontratos20->si87_novadatatermino = $oDataTermino->getDate(); //campo 12
                } else {
                    $clcontratos20->si87_novadatatermino = ""; //campo 12
                }
                if ($this->getTipoTermoAditivo($oAcordoPosicao) == '4') {
                    $clcontratos20->si87_percentualreajuste = $oDados20->ac26_percentualreajuste; //campo 13
                    $clcontratos20->si87_indiceunicoreajuste = $oDados20->ac26_indicereajuste; //campo 14
                } else {
                    $clcontratos20->si87_percentualreajuste = ''; //campo 13
                    $clcontratos20->si87_indiceunicoreajuste = ''; //campo 14
                }
                if ($oDados20->ac26_indicereajuste == '6') {
                    $clcontratos20->si87_dscreajuste = $this->removeCaracteres($oDados20->ac26_descricaoindice); //campo 15
                } else {
                    $clcontratos20->si87_dscreajuste = ''; //campo 15
                }


                $iTotalPosicaoAnterior = 0;
                $iTotalPosicaoAditivo = 0;
                $iQuantidadeAditada = 0;
                $valortotaladitado = 0;
                $iValorAditado = 0;
                //ini_set('display_errors','on');
                /**
                 * AQUI IREI CALCULAR O VALOR ADITADO DO REGISTRO 20
                 */
                foreach ($oAcordoPosicao->getItens() as $oAcordoItem) {
                    if ($oAcordoItem->getQuantiAditada() != 0 || $oAcordoItem->getValorAditado() != 0) {

                        $iTotalPosicaoAditivo += $oAcordoItem->getValorAditado();

                        $sqlServico = "select pc01_servico, ac20_servicoquantidade
                            from acordoitem
                            inner join pcmater on pc01_codmater = ac20_pcmater
                            inner join acordoposicao on ac26_sequencial = ac20_acordoposicao
                            where ac20_pcmater = {$oAcordoItem->getMaterial()->getCodigo()}
                            and ac26_sequencial = {$oDados20->ac26_sequencial}";
                        $rsMatServicoR21  = db_query($sqlServico);
                        $matServico = db_utils::fieldsMemory($rsMatServicoR21, 0);
                        if ($matServico->pc01_servico == "t" && $matServico->ac20_servicoquantidade == "f") {
                            $valortotaladitado += $oAcordoItem->getValorAditado();
                        } else {
                            //CALCULO O VALOR DO PRIMEIRO REGISTRO 20
                            //2 = reequilibrio 5 = reajuste
                            if ($oAcordoPosicao->getTipo() == 2 || $oAcordoPosicao->getTipo() == 5) {
                                $iQuantidadeAditada = $oAcordoItem->getQuantidade();
                                $iValorAditado += $oAcordoItem->getValorTotalPosicaoAnterior($oDados20->ac26_sequencial) - $oAcordoItem->getValorTotal();
                            } else {
                                $iQuantidadeAditada = abs($oAcordoItem->getQuantidade() - $oAcordoItem->getQuantidadePosicaoAnterior($oDados20->ac26_numero));
                            }
                            $valortotaladitado += $oAcordoItem->getValorAditado();
                        }
                        //$iTotalPosicaoAditivo += $oAcordoItem->getValorTotal();
                    }
                }

                /*
                *tipo de alteracao contrato registro 20
                * 1 - acrecimo
                * 2 - decrescimo
                * 3 - nao houve alteracao no valor
                */

                if ($iTotalPosicaoAditivo > 0) {
                    $tipoalteracao = 1;
                } elseif ($iTotalPosicaoAditivo < 0) {
                    $tipoalteracao = 2;
                } else {
                    $tipoalteracao = 3;
                }
                //tipos 9 e 10 tem tratamento diferente
                if ($oAcordoPosicao->getTipo() == 9) {
                    $tipoalteracao = 1;
                } else if ($oAcordoPosicao->getTipo() == 10) {
                    $tipoalteracao = 2;
                }

                $clcontratos20->si87_tipoalteracaovalor = $tipoalteracao; //campo 10
                $clcontratos20->si87_valoraditivo = ($tipoalteracao == 3 ? 0 : abs($valortotaladitado)); //campo 16
                $clcontratos20->si87_datapublicacao = $oDados20->ac35_datapublicacao; //campo 17
                $clcontratos20->si87_veiculodivulgacao = $this->removeCaracteres($oDados20->ac35_veiculodivulgacao); //campo 18
                $clcontratos20->si87_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $clcontratos20->si87_instit = db_getsession("DB_instit");
                $clcontratos20->incluir(null);

                if ($clcontratos20->erro_status == 0) {
                    throw new Exception($clcontratos20->erro_msg);
                }

                /*
                * Registro 21
                * Detalhamento dos Itens Aditados
                */

                if (in_array($oAcordoPosicao->getTipo(), array(9, 10))) {
                    $iTotalPosicaoAnterior = 0;
                    $iTotalPosicaoAditivo = 0;
                    $iQuantidadeAditada = 0;
                    $valortotaladitado = 0;
                    foreach ($oAcordoPosicao->getItens() as $oAcordoItem) {
                        if ($oAcordoItem->getQuantiAditada() != 0 && $oAcordoItem->getValorAditado() != 0) {
                            $iTotalPosicaoAnterior += $oAcordoItem->getValorTotalPosicaoAnterior($oDados20->ac26_numero);
                            $iTotalPosicaoAditivo += $oAcordoItem->getValorTotal();

                            $sSql = "SELECT si43_coditem FROM
                                    (select si43_coditem,si43_dscitem  from item102014 union select si43_coditem,si43_dscitem from item102015 union select si43_coditem,si43_dscitem from item102016 union select si43_coditem,si43_dscitem from item102017 union select si43_coditem,si43_dscitem from item102023 union select si43_coditem,si43_dscitem from item102023) as y
                                    WHERE si43_coditem = " . $oAcordoItem->getCodigo() . $oAcordoItem->getUnidade();
                            $result = db_query($sSql);
                            $iCodItem = db_utils::fieldsMemory($result, 0)->si43_coditem;

                            if ($iCodItem == "") {
                                $iUnidade = $oAcordoItem->getUnidade() == "" ? 1 : $oAcordoItem->getUnidade();
                                $iCodItem = $oAcordoItem->getMaterial()->getCodigo() . $iUnidade;
                            }
                            $iCodPcmater = $oAcordoItem->getMaterial()->getMaterial();

                            /*
                            * Buscas os lote do item
                            */
                            if ($oDados10->ac16_origem == self::ORIGEM_LICITACAO && $oDados10->l20_tipojulg == 3) {
                                $sSqlItemLote = "select l04_descricao
                                from liclicitemlote
                                inner join liclicitem on l21_codigo = l04_liclicitem
                                inner join liclicita on l21_codliclicita = l20_codigo
                                inner join pcprocitem on l21_codpcprocitem = pc81_codprocitem
                                inner join solicitem on pc11_codigo = pc81_solicitem
                                inner join solicitempcmater on pc16_solicitem =pc11_codigo
                                where l20_codigo = " . $oDados10->ac16_licitacao . " and pc16_codmater = " . $iCodPcmater;

                                $rsItemLote = db_query($sSqlItemLote);
                                $oItemLote = db_utils::fieldsMemory($rsItemLote, 0);
                            }

                            /**
                             * busca itens obra;
                             */
                            $sqlItemobra = "select * from licitemobra where obr06_pcmater = $iCodPcmater";
                            $rsItems = db_query($sqlItemobra);
                            $oDadosItensObra = db_utils::fieldsMemory($rsItems, 0);

                            $clcontratos21->si88_tiporegistro = 21; //campo 01
                            $clcontratos21->si88_reg20 = $clcontratos20->si87_sequencial;
                            $clcontratos21->si88_codaditivo = $clcontratos20->si87_codaditivo; //campo 02
                            if ($oDados10->ac16_origem == self::ORIGEM_LICITACAO && $oDados10->l20_tipojulg == 3) {
                                $clcontratos21->si88_nrolote = preg_replace("/[^0-9]/", "", $oItemLote->l04_descricao); //campo 03
                            } else {
                                $clcontratos21->si88_nrolote = 0; //campo 03
                            }
                            if ($oDados20->ac02_acordonatureza == "1") {
                                if ($oDadosItensObra->obr06_tabela == "3" || $oDadosItensObra->obr06_tabela == "4") {
                                    $clcontratos21->si88_coditem = $iCodItem; //campo 04
                                } else {
                                    $clcontratos21->si88_coditem = null; //campo 04
                                }
                            } else {
                                $clcontratos21->si88_coditem = $iCodItem; //campo 04
                            }
                            $sqlServico = "
                            select pc01_servico, ac20_servicoquantidade
                                from acordoitem
                                inner join pcmater on pc01_codmater = ac20_pcmater
                                inner join acordoposicao on ac26_sequencial = ac20_acordoposicao
                                    where ac20_pcmater = {$oAcordoItem->getMaterial()->getCodigo()}
                                    and ac26_sequencial = {$oDados20->ac26_sequencial}
                            ";
                            $rsMatServicoR21  = db_query($sqlServico);
                            $matServico = db_utils::fieldsMemory($rsMatServicoR21, 0);
                            if ($matServico->pc01_servico == "t" && $matServico->ac20_servicoquantidade == "f") {
                                $clcontratos21->si88_valorunitarioitem = abs($oAcordoItem->getValorUnitario()); //campo 12
                            } else {
                                $clcontratos21->si88_valorunitarioitem = abs($oAcordoItem->getValorUnitario()); //campo 12
                            }

                            if ($oAcordoPosicao->getTipo() == 9) {
                                $iTipoAlteraoItem = 1;
                            } else if ($oAcordoPosicao->getTipo() == 10) {
                                $iTipoAlteraoItem = 2;
                            }

                            //QUANTIDADE ADITADA
                            if ($matServico->pc01_servico == "t" && $matServico->ac20_servicoquantidade == "f") {
                                $iTipoAlteraoItem = 1;
                                $clcontratos21->si88_quantacrescdecresc = 1; //campo 11
                            } else {
                                $clcontratos21->si88_quantacrescdecresc = abs($oAcordoItem->getQuantiAditada()); //campo 11
                            }
                            $clcontratos21->si88_tipoalteracaoitem = $iTipoAlteraoItem; //campo 10
                            $clcontratos21->si88_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                            $clcontratos21->si88_instit = db_getsession("DB_instit");
                            if ($oDados20->ac02_acordonatureza == "1" || $oDados20->ac02_acordonatureza == "7") {
                                $clcontratos21->si88_tipomaterial = $oDadosItensObra->obr06_tabela; //campo 05
                            } else {
                                $clcontratos21->si88_tipomaterial = ""; //campo 05
                            }
                            if ($oDadosItensObra->obr06_tabela == "1") {
                                $clcontratos21->si88_coditemsinapi = $oDadosItensObra->obr06_codigotabela; //campo 06
                                $clcontratos21->si88_coditemsimcro = null; //campo 07
                                $clcontratos21->si88_descoutrosmateriais = null; //campo 08
                            } elseif ($oDadosItensObra->obr06_tabela == "2") {
                                $clcontratos21->si88_coditemsimcro = $oDadosItensObra->obr06_codigotabela; //campo 07
                                $clcontratos21->si88_coditemsinapi = null; //campo 06
                                $clcontratos21->si88_descoutrosmateriais = null; //campo 08
                            } elseif ($oDadosItensObra->obr06_tabela == "3") {
                                $clcontratos21->si88_coditemsinapi = null; //campo 06
                                $clcontratos21->si88_coditemsimcro = null; //campo 07
                                $clcontratos21->si88_descoutrosmateriais = $this->removeCaracteres($oDadosItensObra->obr06_descricaotabela); //campo 08
                            }
                            $clcontratos21->si88_itemplanilha = $oDadosItensObra->obr06_pcmater; //campo 09
                            $clcontratos21->incluir(null);

                            if ($clcontratos21->erro_status == 0) {
                                throw new Exception($clcontratos21->erro_msg);
                            }
                            if ($matServico->pc01_servico == "t" && $matServico->ac20_servicoquantidade == "f" && abs(abs($oAcordoItem->getValorUnitario()) + ($oAcordoItem->getValorAditado() * -1)) != 0) {


                                $clcontratos21->si88_tiporegistro = 21; //campo 01
                                $clcontratos21->si88_reg20 = $clcontratos20->si87_sequencial;
                                $clcontratos21->si88_codaditivo = $clcontratos20->si87_codaditivo; //campo 02
                                if ($oDados10->ac16_origem == self::ORIGEM_LICITACAO && $oDados10->l20_tipojulg == 3) {
                                    $clcontratos21->si88_nrolote = preg_replace("/[^0-9]/", "", $oItemLote->l04_descricao); //campo 03
                                } else {
                                    $clcontratos21->si88_nrolote = 0; //campo 03
                                }
                                if ($oDados20->ac02_acordonatureza == "1") {
                                    if ($oDadosItensObra->obr06_tabela == "3" || $oDadosItensObra->obr06_tabela == "4") {
                                        $clcontratos21->si88_coditem = $iCodItem; //campo 04
                                    } else {
                                        $clcontratos21->si88_coditem = null; //campo 04
                                    }
                                } else {
                                    $clcontratos21->si88_coditem = $iCodItem; //campo 04
                                }
                                $sqlServico = "
                                select pc01_servico, ac20_servicoquantidade
                                    from acordoitem
                                    inner join pcmater on pc01_codmater = ac20_pcmater
                                    inner join acordoposicao on ac26_sequencial = ac20_acordoposicao
                                        where ac20_pcmater = {$oAcordoItem->getMaterial()->getCodigo()}
                                        and ac26_sequencial = {$oDados20->ac26_sequencial}
                                ";
                                $rsMatServicoR21  = db_query($sqlServico);
                                $matServico = db_utils::fieldsMemory($rsMatServicoR21, 0);

                                $clcontratos21->si88_valorunitarioitem = abs(abs($oAcordoItem->getValorUnitario()) + ($oAcordoItem->getValorAditado() * -1)); //campo 12

                                //QUANTIDADE ADITADA
                                $iTipoAlteraoItem = 2;
                                $clcontratos21->si88_quantacrescdecresc = 1; //campo 11


                                $clcontratos21->si88_tipoalteracaoitem = $iTipoAlteraoItem; //campo 10

                                $clcontratos21->si88_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                                $clcontratos21->si88_instit = db_getsession("DB_instit");
                                if ($oDados20->ac02_acordonatureza == "1" || $oDados20->ac02_acordonatureza == "7") {
                                    $clcontratos21->si88_tipomaterial = $oDadosItensObra->obr06_tabela; //campo 05
                                } else {
                                    $clcontratos21->si88_tipomaterial = ""; //campo 05
                                }
                                if ($oDadosItensObra->obr06_tabela == "1") {
                                    $clcontratos21->si88_coditemsinapi = $oDadosItensObra->obr06_codigotabela; //campo 06
                                    $clcontratos21->si88_coditemsimcro = null; //campo 07
                                    $clcontratos21->si88_descoutrosmateriais = null; //campo 08
                                } elseif ($oDadosItensObra->obr06_tabela == "2") {
                                    $clcontratos21->si88_coditemsimcro = $oDadosItensObra->obr06_codigotabela; //campo 07
                                    $clcontratos21->si88_coditemsinapi = null; //campo 06
                                    $clcontratos21->si88_descoutrosmateriais = null; //campo 08
                                } elseif ($oDadosItensObra->obr06_tabela == "3") {
                                    $clcontratos21->si88_coditemsinapi = null; //campo 06
                                    $clcontratos21->si88_coditemsimcro = null; //campo 07
                                    $clcontratos21->si88_descoutrosmateriais = $this->removeCaracteres($oDadosItensObra->obr06_descricaotabela); //campo 08
                                }
                                $clcontratos21->si88_itemplanilha = $oDadosItensObra->obr06_pcmater; //campo 09
                                $clcontratos21->incluir(null);

                                if ($clcontratos21->erro_status == 0) {
                                    throw new Exception($clcontratos21->erro_msg);
                                }
                            }
                        }
                    }
                }
            }

            /*
            *SOMENTE DOS TIPOS 11 e 14
            */ else {
                //var_dump($oAcordoPosicao->getTipo());
                $clcontratos20->si87_tiporegistro = 20; //campo 01
                $clcontratos20->si87_codaditivo = $oDados20->ac26_sequencial; //campo 02
                $clcontratos20->si87_codorgao = $sCodorgao; //campo 03
                if (empty($oDados20->manutac_codunidsubanterior)) {
                    $clcontratos20->si87_codunidadesub = $sCodUnidade; //campo 04
                } else {
                    $clcontratos20->si87_codunidadesub = $oDados20->manutac_codunidsubanterior; //campo 04
                }
                $clcontratos20->si87_nrocontrato = $oDados20->manutac_numeroant =='' ? $oDados20->ac16_numero : $oDados20->manutac_numeroant; //campo 05
                $clcontratos20->si87_dtassinaturacontoriginal = $oDados20->ac16_dataassinatura; //campo 06
                $clcontratos20->si87_nroseqtermoaditivo = $oDados20->ac26_numeroaditamento; //campo 07
                $clcontratos20->si87_dtassinaturatermoaditivo = $oDados20->ac35_dataassinaturatermoaditivo; //campo 08
                $clcontratos20->si87_tipotermoaditivo = $this->getTipoTermoAditivo($oAcordoPosicao); //campo 10
                $clcontratos20->si87_dscalteracao = substr($this->removeCaracteres($oDados20->ac35_descricaoalteracao), 0, 250); //campo 11
                $oDataTermino = new DBDate($oAcordoPosicao->getVigenciaFinal()); //317
                if (in_array($oAcordoPosicao->getTipo(), array(6, 13))) {
                    $clcontratos20->si87_novadatatermino = $oDataTermino->getDate(); //campo 12
                } else {
                    $clcontratos20->si87_novadatatermino = ""; //campo 12
                }
                if ($this->getTipoTermoAditivo($oAcordoPosicao) == '4') {
                    $clcontratos20->si87_percentualreajuste = $oDados20->ac26_percentualreajuste; //campo 13
                    $clcontratos20->si87_indiceunicoreajuste = $oDados20->ac26_indicereajuste; //campo 14
                } else {
                    $clcontratos20->si87_percentualreajuste = ''; //campo 13
                    $clcontratos20->si87_indiceunicoreajuste = ''; //campo 14
                }
                if ($oDados20->ac26_indicereajuste == '6') {
                    $clcontratos20->si87_dscreajuste = $this->removeCaracteres($oDados20->ac26_descricaoindice); //campo 15
                } else {
                    $clcontratos20->si87_dscreajuste = ''; //campo 15
                }
                $iTotalPosicaoAnterior = 0;
                $iTotalPosicaoAditivo = 0;
                $iQuantidadeAditada = 0;
                $valortotaladitado = 0;
                $iValorAditado = 0;
                //ini_set('display_errors','on');
                /**
                 * AQUI IREI CALCULAR O VALOR ADITADO DO REGISTRO 20
                 */
                foreach ($oAcordoPosicao->getItens() as $oAcordoItem) {
                    if ($oAcordoItem->getQuantiAditada() != 0 || $oAcordoItem->getValorAditado() != 0) {
                        $iTotalPosicaoAnterior += $oAcordoItem->getValorTotalPosicaoAnteriors($oDados20->ac26_numero);
                        $iTotalPosicaoAditivo += $oAcordoItem->getValorTotal();

                        $sqlServico = "select pc01_servico, ac20_servicoquantidade
                            from acordoitem
                            inner join pcmater on pc01_codmater = ac20_pcmater
                            inner join acordoposicao on ac26_sequencial = ac20_acordoposicao
                            where ac20_pcmater = {$oAcordoItem->getMaterial()->getCodigo()}
                            and ac26_sequencial = {$oDados20->ac26_sequencial}";
                        $rsMatServicoR21  = db_query($sqlServico);
                        $matServico = db_utils::fieldsMemory($rsMatServicoR21, 0);
                        if ($matServico->pc01_servico == "t" && $matServico->ac20_servicoquantidade == "f") {
                            $valortotaladitado += $oAcordoItem->getValorAditado();
                        } else {
                            //CALCULO O VALOR DO PRIMEIRO REGISTRO 20
                            //2 = reequilibrio 5 = reajuste
                            if ($oAcordoPosicao->getTipo() == 2 || $oAcordoPosicao->getTipo() == 5) {
                                $iQuantidadeAditada = $oAcordoItem->getQuantidade();
                                $iValorAditado += $oAcordoItem->getValorTotalPosicaoAnterior($oDados20->ac26_sequencial) - $oAcordoItem->getValorTotal();
                            } else {
                                $iQuantidadeAditada = $oAcordoItem->getQuantidade() - $oAcordoItem->getQuantidadePosicaoAnterior($oDados20->ac26_numero);
                            }
                            $valortotaladitado += $oAcordoItem->getValorAditado();
                        }
                        //$iTotalPosicaoAditivo += $oAcordoItem->getValorTotal();
                    }
                }

                /*
                *tipo de alteracao contrato registro 20
                * 1 - acrecimo
                * 2 - decrescimo
                * 3 - nao houve alteracao no valor
                */

                if ($valortotaladitado > 0) {
                    $tipoalteracao = 1;
                } elseif ($valortotaladitado < 0) {
                    $tipoalteracao = 2;
                } else {
                    $tipoalteracao = 3;
                }

                $clcontratos20->si87_tipoalteracaovalor = $tipoalteracao; //campo 09
                $clcontratos20->si87_valoraditivo = ($tipoalteracao == 3 ? 0 : abs($valortotaladitado)); //campo 16
                $clcontratos20->si87_datapublicacao = $oDados20->ac35_datapublicacao; //campo 17
                $clcontratos20->si87_veiculodivulgacao = $this->removeCaracteres($oDados20->ac35_veiculodivulgacao); //campo 18
                $clcontratos20->si87_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $clcontratos20->si87_instit = db_getsession("DB_instit");
                $clcontratos20->incluir(null);

                if ($clcontratos20->erro_status == 0) {
                    throw new Exception($clcontratos20->erro_msg);
                }

                /*
                * Registro 21
                * Detalhamento dos Itens Aditados
                */

                if (in_array($oAcordoPosicao->getTipo(), array(11))) {
                    $iTotalPosicaoAnterior = 0;
                    $iTotalPosicaoAditivo = 0;
                    $iQuantidadeAditada = 0;
                    $valortotaladitado = 0;
                    foreach ($oAcordoPosicao->getItens() as $oAcordoItem) {
                        if ($oAcordoItem->getQuantiAditada() != 0 || $oAcordoItem->getValorAditado() != 0) {
                            $iTotalPosicaoAnterior += $oAcordoItem->getValorTotalPosicaoAnterior($oDados20->ac26_numero);
                            $iTotalPosicaoAditivo += $oAcordoItem->getValorTotal();

                            $sSql = "SELECT si43_coditem FROM
                                    (select si43_coditem,si43_dscitem  from item102014 union select si43_coditem,si43_dscitem from item102015 union select si43_coditem,si43_dscitem from item102016 union select si43_coditem,si43_dscitem from item102017 union select si43_coditem,si43_dscitem from item102023 union select si43_coditem,si43_dscitem from item102023) as y
                                    WHERE si43_coditem = " . $oAcordoItem->getCodigo() . $oAcordoItem->getUnidade();
                            $result = db_query($sSql);
                            $iCodItem = db_utils::fieldsMemory($result, 0)->si43_coditem;

                            if ($iCodItem == "") {
                                $iUnidade = $oAcordoItem->getUnidade() == "" ? 1 : $oAcordoItem->getUnidade();
                                $iCodItem = $oAcordoItem->getMaterial()->getCodigo() . $iUnidade;
                            }
                            $iCodPcmater = $oAcordoItem->getMaterial()->getMaterial();

                            /*
                            * Buscas os lote do item
                            */
                            if ($oDados10->ac16_origem == self::ORIGEM_LICITACAO && $oDados10->l20_tipojulg == 3) {
                                $sSqlItemLote = "select l04_descricao
                                from liclicitemlote
                                inner join liclicitem on l21_codigo = l04_liclicitem
                                inner join liclicita on l21_codliclicita = l20_codigo
                                inner join pcprocitem on l21_codpcprocitem = pc81_codprocitem
                                inner join solicitem on pc11_codigo = pc81_solicitem
                                inner join solicitempcmater on pc16_solicitem =pc11_codigo
                                where l20_codigo = " . $oDados10->ac16_licitacao . " and pc16_codmater = " . $iCodPcmater;

                                $rsItemLote = db_query($sSqlItemLote);
                                $oItemLote = db_utils::fieldsMemory($rsItemLote, 0);
                            }

                            /**
                             * busca itens obra;
                             */
                            $sqlItemobra = "select * from licitemobra where obr06_pcmater = $iCodPcmater";
                            $rsItems = db_query($sqlItemobra);
                            $oDadosItensObra = db_utils::fieldsMemory($rsItems, 0);

                            $clcontratos21->si88_tiporegistro = 21; //campo 01
                            $clcontratos21->si88_reg20 = $clcontratos20->si87_sequencial;
                            $clcontratos21->si88_codaditivo = $clcontratos20->si87_codaditivo; //campo 02
                            if ($oDados10->ac16_origem == self::ORIGEM_LICITACAO && $oDados10->l20_tipojulg == 3) {
                                $clcontratos21->si88_nrolote = preg_replace("/[^0-9]/", "", $oItemLote->l04_descricao); //campo 03
                            } else {
                                $clcontratos21->si88_nrolote = 0; //campo 03
                            }
                            if ($oDados20->ac02_acordonatureza == "1") {
                                if ($oDadosItensObra->obr06_tabela == "3" || $oDadosItensObra->obr06_tabela == "4") {
                                    $clcontratos21->si88_coditem = $iCodItem; //campo 04
                                } else {
                                    $clcontratos21->si88_coditem = null; //campo 04
                                }
                            } else {
                                $clcontratos21->si88_coditem = $iCodItem; //campo 04
                            }
                            $sqlServico = "
                            select pc01_servico, ac20_servicoquantidade
                                from acordoitem
                                inner join pcmater on pc01_codmater = ac20_pcmater
                                inner join acordoposicao on ac26_sequencial = ac20_acordoposicao
                                    where ac20_pcmater = {$oAcordoItem->getMaterial()->getCodigo()}
                                    and ac26_sequencial = {$oDados20->ac26_sequencial}
                            ";
                            $rsMatServicoR21  = db_query($sqlServico);
                            $matServico = db_utils::fieldsMemory($rsMatServicoR21, 0);

                            if ($matServico->pc01_servico == "t" && $matServico->ac20_servicoquantidade == "f") {

                                $clcontratos21->si88_valorunitarioitem = abs($oAcordoItem->getValorUnitario()); //campo 12
                            } else {

                                $clcontratos21->si88_valorunitarioitem = abs($oAcordoItem->getValorUnitario()); //campo 12
                            }

                            if ($oAcordoItem->getQuantiAditada() < 0 || $oAcordoItem->getValorAditado() < 0) {

                                $iTipoAlteraoItem = 2;
                            } else {

                                $iTipoAlteraoItem = 1;
                            }

                            //QUANTIDADE ADITADA
                            if ($matServico->pc01_servico == "t" && $matServico->ac20_servicoquantidade == "f") {
                                $iTipoAlteraoItem = 1;
                                $clcontratos21->si88_quantacrescdecresc = 1; //campo 11
                            } else {
                                $clcontratos21->si88_quantacrescdecresc = abs($oAcordoItem->getQuantiAditada()); //campo 11
                            }
                            $clcontratos21->si88_tipoalteracaoitem = $iTipoAlteraoItem; //campo 10

                            $clcontratos21->si88_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                            $clcontratos21->si88_instit = db_getsession("DB_instit");
                            if ($oDados20->ac02_acordonatureza == "1" || $oDados20->ac02_acordonatureza == "7") {
                                $clcontratos21->si88_tipomaterial = $oDadosItensObra->obr06_tabela; //campo 05
                            } else {
                                $clcontratos21->si88_tipomaterial = ""; //campo 05
                            }
                            if ($oDadosItensObra->obr06_tabela == "1") {
                                $clcontratos21->si88_coditemsinapi = $oDadosItensObra->obr06_codigotabela; //campo 06
                                $clcontratos21->si88_coditemsimcro = null; //campo 07
                                $clcontratos21->si88_descoutrosmateriais = null; //campo 08
                            } elseif ($oDadosItensObra->obr06_tabela == "2") {
                                $clcontratos21->si88_coditemsimcro = $oDadosItensObra->obr06_codigotabela; //campo 07
                                $clcontratos21->si88_coditemsinapi = null; //campo 06
                                $clcontratos21->si88_descoutrosmateriais = null; //campo 08
                            } elseif ($oDadosItensObra->obr06_tabela == "3") {
                                $clcontratos21->si88_coditemsinapi = null; //campo 06
                                $clcontratos21->si88_coditemsimcro = null; //campo 07
                                $clcontratos21->si88_descoutrosmateriais = $this->removeCaracteres($oDadosItensObra->obr06_descricaotabela); //campo 08
                            }
                            $clcontratos21->si88_itemplanilha = $oDadosItensObra->obr06_pcmater; //campo 09
                            $clcontratos21->incluir(null);

                            if ($clcontratos21->erro_status == 0) {
                                throw new Exception($clcontratos21->erro_msg);
                            }
                            if ($matServico->pc01_servico == "t" && $matServico->ac20_servicoquantidade == "f") {

                                $clcontratos21->si88_tiporegistro = 21; //campo 01
                                $clcontratos21->si88_reg20 = $clcontratos20->si87_sequencial;
                                $clcontratos21->si88_codaditivo = $clcontratos20->si87_codaditivo; //campo 02
                                if ($oDados10->ac16_origem == self::ORIGEM_LICITACAO && $oDados10->l20_tipojulg == 3) {
                                    $clcontratos21->si88_nrolote = preg_replace("/[^0-9]/", "", $oItemLote->l04_descricao); //campo 03
                                } else {
                                    $clcontratos21->si88_nrolote = 0; //campo 03
                                }
                                if ($oDados20->ac02_acordonatureza == "1") {
                                    if ($oDadosItensObra->obr06_tabela == "3" || $oDadosItensObra->obr06_tabela == "4") {
                                        $clcontratos21->si88_coditem = $iCodItem; //campo 04
                                    } else {
                                        $clcontratos21->si88_coditem = null; //campo 04
                                    }
                                } else {
                                    $clcontratos21->si88_coditem = $iCodItem; //campo 04
                                }
                                $sqlServico = "
                                select pc01_servico, ac20_servicoquantidade
                                    from acordoitem
                                    inner join pcmater on pc01_codmater = ac20_pcmater
                                    inner join acordoposicao on ac26_sequencial = ac20_acordoposicao
                                        where ac20_pcmater = {$oAcordoItem->getMaterial()->getCodigo()}
                                        and ac26_sequencial = {$oDados20->ac26_sequencial}
                                ";
                                $rsMatServicoR21  = db_query($sqlServico);
                                $matServico = db_utils::fieldsMemory($rsMatServicoR21, 0);

                                $clcontratos21->si88_valorunitarioitem = abs(abs($oAcordoItem->getValorUnitario()) + ($oAcordoItem->getValorAditado() * -1)); //campo 12

                                //QUANTIDADE ADITADA
                                $iTipoAlteraoItem = 2;
                                $clcontratos21->si88_quantacrescdecresc = 1; //campo 11


                                $clcontratos21->si88_tipoalteracaoitem = $iTipoAlteraoItem; //campo 10

                                $clcontratos21->si88_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                                $clcontratos21->si88_instit = db_getsession("DB_instit");
                                if ($oDados20->ac02_acordonatureza == "1" || $oDados20->ac02_acordonatureza == "7") {
                                    $clcontratos21->si88_tipomaterial = $oDadosItensObra->obr06_tabela; //campo 05
                                } else {
                                    $clcontratos21->si88_tipomaterial = ""; //campo 05
                                }
                                if ($oDadosItensObra->obr06_tabela == "1") {
                                    $clcontratos21->si88_coditemsinapi = $oDadosItensObra->obr06_codigotabela; //campo 06
                                    $clcontratos21->si88_coditemsimcro = null; //campo 07
                                    $clcontratos21->si88_descoutrosmateriais = null; //campo 08
                                } elseif ($oDadosItensObra->obr06_tabela == "2") {
                                    $clcontratos21->si88_coditemsimcro = $oDadosItensObra->obr06_codigotabela; //campo 07
                                    $clcontratos21->si88_coditemsinapi = null; //campo 06
                                    $clcontratos21->si88_descoutrosmateriais = null; //campo 08
                                } elseif ($oDadosItensObra->obr06_tabela == "3") {
                                    $clcontratos21->si88_coditemsinapi = null; //campo 06
                                    $clcontratos21->si88_coditemsimcro = null; //campo 07
                                    $clcontratos21->si88_descoutrosmateriais = $this->removeCaracteres($oDadosItensObra->obr06_descricaotabela); //campo 08
                                }
                                $clcontratos21->si88_itemplanilha = $oDadosItensObra->obr06_pcmater; //campo 09
                                $clcontratos21->incluir(null);

                                if ($clcontratos21->erro_status == 0) {
                                    throw new Exception($clcontratos21->erro_msg);
                                }
                            }
                        }
                    }
                } else {
                    $iTotalPosicaoAnterior = 0;
                    $iTotalPosicaoAditivo = 0;
                    $iQuantidadeAditada = 0;
                    $valortotaladitado = 0;
                    foreach ($oAcordoPosicao->getItens() as $oAcordoItem) {

                        if ($oAcordoItem->getQuantiAditada() != 0 ||  ($oAcordoItem->getValorUnitario() != $oAcordoItem->getValorTotalPosicaoAnteriors($oDados20->ac26_numero) && $oAcordoItem->getValorAditado() != 0)) {
                            if (abs($oAcordoItem->getQuantidade()) == 0 || abs($oAcordoItem->getValorUnitario()) == abs($oAcordoItem->getValorTotalPosicaoAnteriors($oDados20->ac26_numero)) || abs(abs($oAcordoItem->getValorUnitario()) + ($oAcordoItem->getValorAditado() * -1)) == 0) {
                                $valortotaladitado = $oAcordoItem->getValorUnitario() - $oAcordoItem->getValorTotalPosicaoAnteriors($oDados20->ac26_numero);
                                $iTotalPosicaoAnterior += $oAcordoItem->getValorTotalPosicaoAnterior($oDados20->ac26_numero);
                                $iTotalPosicaoAditivo += $oAcordoItem->getValorTotal();

                                $sSql = "SELECT si43_coditem FROM
                                                (select si43_coditem,si43_dscitem  from item102014 union select si43_coditem,si43_dscitem from item102015 union select si43_coditem,si43_dscitem from item102016 union select si43_coditem,si43_dscitem from item102017 union select si43_coditem,si43_dscitem from item102023 union select si43_coditem,si43_dscitem from item102023) as y
                                                WHERE si43_coditem = " . $oAcordoItem->getCodigo() . $oAcordoItem->getUnidade();
                                $result = db_query($sSql);
                                $iCodItem = db_utils::fieldsMemory($result, 0)->si43_coditem;

                                if ($iCodItem == "") {
                                    $iUnidade = $oAcordoItem->getUnidade() == "" ? 1 : $oAcordoItem->getUnidade();
                                    $iCodItem = $oAcordoItem->getMaterial()->getCodigo() . $iUnidade;
                                }
                                $iCodPcmater = $oAcordoItem->getMaterial()->getMaterial();

                                /*
                                * Buscas os lote do item
                                */
                                if ($oDados10->ac16_origem == self::ORIGEM_LICITACAO && $oDados10->l20_tipojulg == 3) {
                                    $sSqlItemLote = "select l04_descricao
                                    from liclicitemlote
                                    inner join liclicitem on l21_codigo = l04_liclicitem
                                    inner join liclicita on l21_codliclicita = l20_codigo
                                    inner join pcprocitem on l21_codpcprocitem = pc81_codprocitem
                                    inner join solicitem on pc11_codigo = pc81_solicitem
                                    inner join solicitempcmater on pc16_solicitem =pc11_codigo
                                    where l20_codigo = " . $oDados10->ac16_licitacao . " and pc16_codmater = " . $iCodPcmater;

                                    $rsItemLote = db_query($sSqlItemLote);
                                    $oItemLote = db_utils::fieldsMemory($rsItemLote, 0);
                                }

                                /**
                                 * busca itens obra;
                                 */
                                $sqlItemobra = "select * from licitemobra where obr06_pcmater = $iCodPcmater";
                                $rsItems = db_query($sqlItemobra);
                                $oDadosItensObra = db_utils::fieldsMemory($rsItems, 0);

                                $clcontratos21->si88_tiporegistro = 21; //campo 01
                                $clcontratos21->si88_reg20 = $clcontratos20->si87_sequencial;
                                $clcontratos21->si88_codaditivo = $clcontratos20->si87_codaditivo; //campo 02
                                if ($oDados10->ac16_origem == self::ORIGEM_LICITACAO && $oDados10->l20_tipojulg == 3) {
                                    $clcontratos21->si88_nrolote = preg_replace("/[^0-9]/", "", $oItemLote->l04_descricao); //campo 03
                                } else {
                                    $clcontratos21->si88_nrolote = 0; //campo 03
                                }
                                if ($oDados20->ac02_acordonatureza == "1") {
                                    if ($oDadosItensObra->obr06_tabela == "3" || $oDadosItensObra->obr06_tabela == "4") {
                                        $clcontratos21->si88_coditem = $iCodItem; //campo 04
                                    } else {
                                        $clcontratos21->si88_coditem = null; //campo 04
                                    }
                                } else {
                                    $clcontratos21->si88_coditem = $iCodItem; //campo 04
                                }
                                $sqlServico = "
                                        select pc01_servico, ac20_servicoquantidade
                                            from acordoitem
                                            inner join pcmater on pc01_codmater = ac20_pcmater
                                            inner join acordoposicao on ac26_sequencial = ac20_acordoposicao
                                                where ac20_pcmater = {$oAcordoItem->getMaterial()->getCodigo()}
                                                and ac26_sequencial = {$oDados20->ac26_sequencial}
                                        ";
                                $rsMatServicoR21  = db_query($sqlServico);
                                $matServico = db_utils::fieldsMemory($rsMatServicoR21, 0);

                                $clcontratos21->si88_valorunitarioitem = abs($oAcordoItem->getValorUnitario()); //campo 12

                                //QUANTIDADE ADITADA
                                if ($matServico->pc01_servico == "t" && $matServico->ac20_servicoquantidade == "f") {
                                    $iTipoAlteraoItem = 1;
                                    $clcontratos21->si88_quantacrescdecresc = 1; //campo 11
                                } else {
                                    if ($oAcordoItem->getQuantiAditada() > 0) {
                                        $iTipoAlteraoItem = 1;
                                    } else {
                                        $iTipoAlteraoItem = 2;
                                    }
                                    $clcontratos21->si88_quantacrescdecresc = abs($oAcordoItem->getQuantiAditada()); //campo 11
                                }

                                $clcontratos21->si88_tipoalteracaoitem = $iTipoAlteraoItem;

                                $clcontratos21->si88_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                                $clcontratos21->si88_instit = db_getsession("DB_instit");
                                if ($oDados20->ac02_acordonatureza == "1" || $oDados20->ac02_acordonatureza == "7") {
                                    $clcontratos21->si88_tipomaterial = $oDadosItensObra->obr06_tabela; //campo 05
                                } else {
                                    $clcontratos21->si88_tipomaterial = ""; //campo 05
                                }
                                if ($oDadosItensObra->obr06_tabela == "1") {
                                    $clcontratos21->si88_coditemsinapi = $oDadosItensObra->obr06_codigotabela; //campo 06
                                    $clcontratos21->si88_coditemsimcro = null; //campo 07
                                    $clcontratos21->si88_descoutrosmateriais = null; //campo 08
                                } elseif ($oDadosItensObra->obr06_tabela == "2") {
                                    $clcontratos21->si88_coditemsimcro = $oDadosItensObra->obr06_codigotabela; //campo 07
                                    $clcontratos21->si88_coditemsinapi = null; //campo 06
                                    $clcontratos21->si88_descoutrosmateriais = null; //campo 08
                                } elseif ($oDadosItensObra->obr06_tabela == "3") {
                                    $clcontratos21->si88_coditemsinapi = null; //campo 06
                                    $clcontratos21->si88_coditemsimcro = null; //campo 07
                                    $clcontratos21->si88_descoutrosmateriais = $this->removeCaracteres($oDadosItensObra->obr06_descricaotabela); //campo 08
                                }
                                $clcontratos21->si88_itemplanilha = $oDadosItensObra->obr06_pcmater; //campo 09
                                $clcontratos21->incluir(null);

                                if ($clcontratos21->erro_status == 0) {
                                    throw new Exception($clcontratos21->erro_msg);
                                }
                            } else {


                                $iTotalPosicaoAnterior += $oAcordoItem->getValorTotalPosicaoAnterior($oDados20->ac26_numero);
                                $iTotalPosicaoAditivo += $oAcordoItem->getValorTotal();

                                $sSql = "SELECT si43_coditem FROM
                                                (select si43_coditem,si43_dscitem  from item102014 union select si43_coditem,si43_dscitem from item102015 union select si43_coditem,si43_dscitem from item102016 union select si43_coditem,si43_dscitem from item102017 union select si43_coditem,si43_dscitem from item102023 union select si43_coditem,si43_dscitem from item102023) as y
                                                WHERE si43_coditem = " . $oAcordoItem->getCodigo() . $oAcordoItem->getUnidade();
                                $result = db_query($sSql);
                                $iCodItem = db_utils::fieldsMemory($result, 0)->si43_coditem;

                                if ($iCodItem == "") {
                                    $iUnidade = $oAcordoItem->getUnidade() == "" ? 1 : $oAcordoItem->getUnidade();
                                    $iCodItem = $oAcordoItem->getMaterial()->getCodigo() . $iUnidade;
                                }
                                $iCodPcmater = $oAcordoItem->getMaterial()->getMaterial();

                                /*
                                * Buscas os lote do item
                                */
                                if ($oDados10->ac16_origem == self::ORIGEM_LICITACAO && $oDados10->l20_tipojulg == 3) {
                                    $sSqlItemLote = "select l04_descricao
                                    from liclicitemlote
                                    inner join liclicitem on l21_codigo = l04_liclicitem
                                    inner join liclicita on l21_codliclicita = l20_codigo
                                    inner join pcprocitem on l21_codpcprocitem = pc81_codprocitem
                                    inner join solicitem on pc11_codigo = pc81_solicitem
                                    inner join solicitempcmater on pc16_solicitem =pc11_codigo
                                    where l20_codigo = " . $oDados10->ac16_licitacao . " and pc16_codmater = " . $iCodPcmater;

                                    $rsItemLote = db_query($sSqlItemLote);
                                    $oItemLote = db_utils::fieldsMemory($rsItemLote, 0);
                                }

                                /**
                                 * busca itens obra;
                                 */
                                $sqlItemobra = "select * from licitemobra where obr06_pcmater = $iCodPcmater";
                                $rsItems = db_query($sqlItemobra);
                                $oDadosItensObra = db_utils::fieldsMemory($rsItems, 0);

                                $clcontratos21->si88_tiporegistro = 21; //campo 01
                                $clcontratos21->si88_reg20 = $clcontratos20->si87_sequencial;
                                $clcontratos21->si88_codaditivo = $clcontratos20->si87_codaditivo; //campo 02
                                if ($oDados10->ac16_origem == self::ORIGEM_LICITACAO && $oDados10->l20_tipojulg == 3) {
                                    $clcontratos21->si88_nrolote = preg_replace("/[^0-9]/", "", $oItemLote->l04_descricao); //campo 03
                                } else {
                                    $clcontratos21->si88_nrolote = 0; //campo 03
                                }
                                if ($oDados20->ac02_acordonatureza == "1") {
                                    if ($oDadosItensObra->obr06_tabela == "3" || $oDadosItensObra->obr06_tabela == "4") {
                                        $clcontratos21->si88_coditem = $iCodItem; //campo 04
                                    } else {
                                        $clcontratos21->si88_coditem = null; //campo 04
                                    }
                                } else {
                                    $clcontratos21->si88_coditem = $iCodItem; //campo 04
                                }
                                $sqlServico = "
                                        select pc01_servico, ac20_servicoquantidade
                                            from acordoitem
                                            inner join pcmater on pc01_codmater = ac20_pcmater
                                            inner join acordoposicao on ac26_sequencial = ac20_acordoposicao
                                                where ac20_pcmater = {$oAcordoItem->getMaterial()->getCodigo()}
                                                and ac26_sequencial = {$oDados20->ac26_sequencial}
                                        ";
                                $rsMatServicoR21  = db_query($sqlServico);
                                $matServico = db_utils::fieldsMemory($rsMatServicoR21, 0);
                                if ($matServico->pc01_servico == "t" && $matServico->ac20_servicoquantidade == "f") {
                                    $clcontratos21->si88_valorunitarioitem = abs($oAcordoItem->getValorUnitario()); //campo 12
                                } else {
                                    $clcontratos21->si88_valorunitarioitem = abs($oAcordoItem->getValorUnitario()); //campo 12
                                }
                                $valortotaladitado = $oAcordoItem->getValorAditado();

                                $iTipoAlteraoItem = 1;


                                $clcontratos21->si88_tipoalteracaoitem = $iTipoAlteraoItem; //campo 10

                                //QUANTIDADE ADITADA
                                if ($matServico->pc01_servico == "t" && $matServico->ac20_servicoquantidade == "f") {
                                    $clcontratos21->si88_quantacrescdecresc = 1; //campo 11
                                } else {
                                    $clcontratos21->si88_quantacrescdecresc = $oAcordoItem->getQuantidade(); //campo 11
                                }

                                $clcontratos21->si88_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                                $clcontratos21->si88_instit = db_getsession("DB_instit");
                                if ($oDados20->ac02_acordonatureza == "1" || $oDados20->ac02_acordonatureza == "7") {
                                    $clcontratos21->si88_tipomaterial = $oDadosItensObra->obr06_tabela; //campo 05
                                } else {
                                    $clcontratos21->si88_tipomaterial = ""; //campo 05
                                }
                                if ($oDadosItensObra->obr06_tabela == "1") {
                                    $clcontratos21->si88_coditemsinapi = $oDadosItensObra->obr06_codigotabela; //campo 06
                                    $clcontratos21->si88_coditemsimcro = null; //campo 07
                                    $clcontratos21->si88_descoutrosmateriais = null; //campo 08
                                } elseif ($oDadosItensObra->obr06_tabela == "2") {
                                    $clcontratos21->si88_coditemsimcro = $oDadosItensObra->obr06_codigotabela; //campo 07
                                    $clcontratos21->si88_coditemsinapi = null; //campo 06
                                    $clcontratos21->si88_descoutrosmateriais = null; //campo 08
                                } elseif ($oDadosItensObra->obr06_tabela == "3") {
                                    $clcontratos21->si88_coditemsinapi = null; //campo 06
                                    $clcontratos21->si88_coditemsimcro = null; //campo 07
                                    $clcontratos21->si88_descoutrosmateriais = $this->removeCaracteres($oDadosItensObra->obr06_descricaotabela); //campo 08
                                }
                                $clcontratos21->si88_itemplanilha = $oDadosItensObra->obr06_pcmater; //campo 09
                                $clcontratos21->incluir(null);

                                if ($clcontratos21->erro_status == 0) {
                                    throw new Exception($clcontratos21->erro_msg);
                                }



                                $iTotalPosicaoAnterior += $oAcordoItem->getValorTotalPosicaoAnterior($oDados20->ac26_numero);
                                $iTotalPosicaoAditivo += $oAcordoItem->getValorTotal();

                                $sSql = "SELECT si43_coditem FROM
                                                (select si43_coditem,si43_dscitem  from item102014 union select si43_coditem,si43_dscitem from item102015 union select si43_coditem,si43_dscitem from item102016 union select si43_coditem,si43_dscitem from item102017 union select si43_coditem,si43_dscitem from item102023 union select si43_coditem,si43_dscitem from item102023) as y
                                                WHERE si43_coditem = " . $oAcordoItem->getCodigo() . $oAcordoItem->getUnidade();
                                $result = db_query($sSql);
                                $iCodItem = db_utils::fieldsMemory($result, 0)->si43_coditem;

                                if ($iCodItem == "") {
                                    $iUnidade = $oAcordoItem->getUnidade() == "" ? 1 : $oAcordoItem->getUnidade();
                                    $iCodItem = $oAcordoItem->getMaterial()->getCodigo() . $iUnidade;
                                }
                                $iCodPcmater = $oAcordoItem->getMaterial()->getMaterial();

                                /**
                                 * busca itens obra;
                                 */
                                $sqlItemobra = "select * from licitemobra where obr06_pcmater = $iCodPcmater";
                                $rsItems = db_query($sqlItemobra);
                                $oDadosItensObra = db_utils::fieldsMemory($rsItems, 0);

                                $clcontratos21->si88_tiporegistro = 21; //campo 01
                                $clcontratos21->si88_reg20 = $clcontratos20->si87_sequencial;
                                $clcontratos21->si88_codaditivo = $clcontratos20->si87_codaditivo; //campo 02
                                if ($oDados10->ac16_origem == self::ORIGEM_LICITACAO && $oDados10->l20_tipojulg == 3) {
                                    $clcontratos21->si88_nrolote = preg_replace("/[^0-9]/", "", $oItemLote->l04_descricao); //campo 03
                                } else {
                                    $clcontratos21->si88_nrolote = 0; //campo 03
                                }
                                if ($oDados20->ac02_acordonatureza == "1") {
                                    if ($oDadosItensObra->obr06_tabela == "3" || $oDadosItensObra->obr06_tabela == "4") {
                                        $clcontratos21->si88_coditem = $iCodItem; //campo 04
                                    } else {
                                        $clcontratos21->si88_coditem = null; //campo 04
                                    }
                                } else {
                                    $clcontratos21->si88_coditem = $iCodItem; //campo 04
                                }
                                $sqlServico = "
                                        select pc01_servico, ac20_servicoquantidade
                                            from acordoitem
                                            inner join pcmater on pc01_codmater = ac20_pcmater
                                            inner join acordoposicao on ac26_sequencial = ac20_acordoposicao
                                                where ac20_pcmater = {$oAcordoItem->getMaterial()->getCodigo()}
                                                and ac26_sequencial = {$oDados20->ac26_sequencial}
                                        ";
                                $rsMatServicoR21  = db_query($sqlServico);
                                $matServico = db_utils::fieldsMemory($rsMatServicoR21, 0);
                                if ($matServico->pc01_servico == "t" && $matServico->ac20_servicoquantidade == "f") {
                                    $clcontratos21->si88_valorunitarioitem = abs(abs($oAcordoItem->getValorUnitario()) + ($oAcordoItem->getValorAditado() * -1)); //campo 12
                                } else {
                                    $clcontratos21->si88_valorunitarioitem = abs($oAcordoItem->getValorTotalPosicaoAnteriors($oDados20->ac26_numero)); //campo 12
                                }
                                $valortotaladitado = $oAcordoItem->getValorAditado();

                                $iTipoAlteraoItem = 2;


                                $clcontratos21->si88_tipoalteracaoitem = $iTipoAlteraoItem; //campo 10

                                //QUANTIDADE ADITADA
                                if ($matServico->pc01_servico == "t" && $matServico->ac20_servicoquantidade == "f") {
                                    $clcontratos21->si88_quantacrescdecresc = 1; //campo 11
                                } else {
                                    $clcontratos21->si88_quantacrescdecresc = abs($oAcordoItem->getQuantidade() - $oAcordoItem->getQuantiAditada()); //campo 11
                                }

                                $clcontratos21->si88_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                                $clcontratos21->si88_instit = db_getsession("DB_instit");
                                if ($oDados20->ac02_acordonatureza == "1" || $oDados20->ac02_acordonatureza == "7") {
                                    $clcontratos21->si88_tipomaterial = $oDadosItensObra->obr06_tabela; //campo 05
                                } else {
                                    $clcontratos21->si88_tipomaterial = ""; //campo 05
                                }
                                if ($oDadosItensObra->obr06_tabela == "1") {
                                    $clcontratos21->si88_coditemsinapi = $oDadosItensObra->obr06_codigotabela; //campo 06
                                    $clcontratos21->si88_coditemsimcro = null; //campo 07
                                    $clcontratos21->si88_descoutrosmateriais = null; //campo 08
                                } elseif ($oDadosItensObra->obr06_tabela == "2") {
                                    $clcontratos21->si88_coditemsimcro = $oDadosItensObra->obr06_codigotabela; //campo 07
                                    $clcontratos21->si88_coditemsinapi = null; //campo 06
                                    $clcontratos21->si88_descoutrosmateriais = null; //campo 08
                                } elseif ($oDadosItensObra->obr06_tabela == "3") {
                                    $clcontratos21->si88_coditemsinapi = null; //campo 06
                                    $clcontratos21->si88_coditemsimcro = null; //campo 07
                                    $clcontratos21->si88_descoutrosmateriais = $this->removeCaracteres($oDadosItensObra->obr06_descricaotabela); //campo 08
                                }
                                $clcontratos21->si88_itemplanilha = $oDadosItensObra->obr06_pcmater; //campo 09
                                $clcontratos21->incluir(null);

                                if ($clcontratos21->erro_status == 0) {
                                    throw new Exception($clcontratos21->erro_msg);
                                }
                            }
                        }
                    }
                }
            } //fim tipo 14 e 15
        } //fim for

        //AQUI SERA GERADO O REGISTRO 20 e 21
        if (!empty($oDadosAgrupados20)) {
            $oDadosgerados = array();
            foreach ($oDadosAgrupados20 as $dadosposicao) {
                //esse array reverse foi uma forma que encontrei para pegar sempre o ultimo valor aditado
                $dadosPosicaoReverte = array_reverse($dadosposicao);

                foreach ($dadosPosicaoReverte as $dados) {
                    $sHashGeracao = $dados->ac26_numeroaditamento . $dados->tipoalteracao . $dados->posicao;
                    if (!isset($oDadosgerados[$sHashGeracao])) {
                        //registro 20
                        $clcontratos20->si87_tiporegistro = 20;
                        $clcontratos20->si87_codaditivo = $dados->si87_codaditivo;
                        $clcontratos20->si87_codorgao =  $dados->sCodorgao;
                        if (empty($dados->manutac_codunidsubanterior)) {
                            $clcontratos20->si87_codunidadesub = $dados->sCodUnidade;
                        } else {
                            $clcontratos20->si87_codunidadesub = $dados->manutac_codunidsubanterior;
                        }
                        $clcontratos20->si87_nrocontrato = $dados->ac16_numero;
                        $clcontratos20->si87_dtassinaturacontoriginal = $dados->ac16_dataassinatura;
                        $clcontratos20->si87_nroseqtermoaditivo = $dados->ac26_numeroaditamento;
                        $clcontratos20->si87_dtassinaturatermoaditivo =  $dados->ac35_dataassinaturatermoaditivo;
                        $clcontratos20->si87_tipotermoaditivo = $dados->si87_tipotermoaditivo;
                        $clcontratos20->si87_dscalteracao = $this->removeCaracteres($dados->si87_dscalteracao);
                        $clcontratos20->si87_novadatatermino = $dados->si87_novadatatermino;
                        $clcontratos20->si87_tipoalteracaovalor = $dados->tipoalteracao;
                        $clcontratos20->si87_valoraditivo = $dados->valoraditamento;
                        $clcontratos20->si87_datapublicacao = $dados->ac35_datapublicacao;
                        $clcontratos20->si87_veiculodivulgacao = $dados->ac35_veiculodivulgacao;
                        $clcontratos20->si87_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                        $clcontratos20->si87_instit = db_getsession("DB_instit");
                        $clcontratos20->incluir(null);

                        if ($clcontratos20->erro_status == 0) {
                            throw new Exception($clcontratos20->erro_msg);
                        }
                        $oDadosgerados[$sHashGeracao] = $dados;
                    }
                    //registro 21
                    $clcontratos21->si88_tiporegistro = 21;
                    $clcontratos21->si88_reg20 = $clcontratos20->si87_sequencial;
                    $clcontratos21->si88_codaditivo = $dados->si87_codaditivo;
                    $clcontratos21->si88_coditem = $dados->si88_coditem;
                    $clcontratos21->si88_valorunitarioitem = $dados->valorunitarioaditado;
                    $clcontratos21->si88_tipoalteracaoitem = $dados->tipoalteracao;
                    $clcontratos21->si88_quantacrescdecresc =  $dados->quantidade;
                    $clcontratos21->si88_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $clcontratos21->si88_instit = db_getsession("DB_instit");
                    $clcontratos21->si88_tipomaterial = $dados->si88_tipomaterial;
                    $clcontratos21->si88_coditemsinapi = $dados->si88_coditemsinapi;
                    $clcontratos21->si88_coditemsimcro = $dados->si88_coditemsimcro;
                    $clcontratos21->si88_descoutrosmateriais = $this->removeCaracteres($dados->si88_descoutrosmateriais);
                    $clcontratos21->si88_itemplanilha = $dados->si88_itemplanilha;
                    $clcontratos21->incluir(null);

                    if ($clcontratos21->erro_status == 0) {
                        throw new Exception($clcontratos21->erro_msg);
                    }
                }
            }
        }

        /*
         * selecionar informacoes registro 30
         */
        $sSql = "SELECT acordo.*,
       CASE si03_tipoalteracaoapostila
           WHEN 15 THEN '1'
           WHEN 16 THEN '2'
           WHEN 17 THEN '3'
       END AS tipoalteracaoapostila,
       si03_sequencial,
       si03_licitacao,
       si03_numcontrato,
       si03_dataassinacontrato,
       si03_tipoapostila,
       si03_dataapostila,
       si03_descrapostila,
       si03_numapostilamento,
       si03_valorapostila,
       si03_instit,
       si03_numcontratoanosanteriores,
       si03_acordo,
       si03_acordoposicao,
       si03_datareferencia,
       si03_indicereajuste,
       si03_percentualreajuste,
       si03_descricaoindice,
       manutac_codunidsubanterior,
       manutac_numeroant
        FROM apostilamento
        INNER JOIN acordo ON si03_acordo=ac16_sequencial
        LEFT JOIN manutencaoacordo ON manutac_acordo = ac16_sequencial
        WHERE si03_datareferencia <='{$this->sDataFinal}'
        AND si03_datareferencia >= '{$this->sDataInicial}'
        AND si03_instit = " . db_getsession("DB_instit");
        $rsResult30 = db_query($sSql);
        for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {

            $oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);
            $aAnoContrato = explode("-", $oDados30->si03_dataassinacontrato);

            if ($aAnoContrato[0] > 2013) {
                $sSql = "select  (CASE
                    WHEN o41_subunidade != 0
                        OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
                            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                            OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
                    ELSE lpad((CASE WHEN o40_codtri = '0'
                        OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                        OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
                END) as codunidadesub
                from db_departorg join orcunidade on db01_orgao = o41_orgao and db01_unidade = o41_unidade
                        and db01_anousu = o41_anousu
                        JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                                where db01_anousu ={$oDados30->ac16_anousu}  and db01_coddepto ={$oDados30->ac16_deptoresponsavel}";

                $result = db_query($sSql);
                $sCodUnidadeSub = db_utils::fieldsMemory($result, 0)->codunidadesub;
            } else {
                $sCodUnidadeSub = ' ';
            }

            $clcontratos30 = new cl_contratos302023();

            $clcontratos30->si89_tiporegistro = 30; //campo 01
            $clcontratos30->si89_codorgao = $sCodorgao; //campo 02
            if (empty($oDados30->manutac_codunidsubanterior)) {
                $clcontratos30->si89_codunidadesub = $sCodUnidadeSub; //campo 03
            } else {
                $clcontratos30->si89_codunidadesub = $oDados30->manutac_codunidsubanterior; //campo 03
            }
            $clcontratos30->si89_nrocontrato = $oDados30->manutac_numeroant =='' ? $oDados30->ac16_numeroacordo : $oDados30->manutac_numeroant; //campo 04
            $clcontratos30->si89_dtassinaturacontoriginal = $oDados30->si03_dataassinacontrato; //campo 05
            $clcontratos30->si89_tipoapostila = $oDados30->si03_tipoapostila; //campo 06
            $clcontratos30->si89_nroseqapostila = $oDados30->si03_numapostilamento; //campo 07
            $clcontratos30->si89_dataapostila = $oDados30->si03_dataapostila; //campo 08
            $clcontratos30->si89_tipoalteracaoapostila = $oDados30->tipoalteracaoapostila; //campo 09
            $clcontratos30->si89_dscalteracao = substr($this->removeCaracteres($oDados30->si03_descrapostila), 0, 250); //campo 10
            if ($oDados30->tipoalteracaoapostila == '1') {
                $clcontratos30->si89_percentualreajuste = $oDados30->si03_percentualreajuste; //campo 11
                $clcontratos30->si89_indiceunicoreajuste = $oDados30->si03_indicereajuste; //campo 12
            } else {
                $clcontratos30->si89_percentualreajuste = ''; //campo 11
                $clcontratos30->si89_indiceunicoreajuste = ''; //campo 12
            }
            if ($oDados30->si03_indicereajuste == '6') {
                $clcontratos30->si89_dscreajuste = $this->removeCaracteres($oDados30->si03_descricaoindice); //campo 13
            } else {
                $clcontratos30->si89_dscreajuste = ''; //campo 13
            }
            $clcontratos30->si89_valorapostila = $oDados30->si03_valorapostila; //campo 14
            $clcontratos30->si89_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clcontratos30->si89_instit = $oDados30->si03_instit;
            $clcontratos30->incluir(null);
            if ($clcontratos30->erro_status == 0) {
                throw new Exception($clcontratos30->erro_msg);
            }
        }

        /*
        * selecionar informacoes registro 40
        */
        $sSql = "SELECT *
          FROM acordo
          LEFT JOIN manutencaoacordo ON manutac_acordo = ac16_sequencial
          WHERE ac16_acordosituacao = 2
            AND ac16_datareferenciarescisao BETWEEN '{$this->sDataInicial}' AND '{$this->sDataFinal}'
            AND ac16_instit = " . db_getsession("DB_instit");


        $rsResult40 = db_query($sSql);

        for ($iCont40 = 0; $iCont40 < pg_num_rows($rsResult40); $iCont40++) {

            $clcontratos40 = new cl_contratos402023();
            $oDados40 = db_utils::fieldsMemory($rsResult40, $iCont40);

            $aAnoContrato = explode("-", $oDados40->ac16_dataassinatura);

            if ($aAnoContrato[0] > 2013) {

                $sSql = "select  (CASE
                    WHEN o41_subunidade != 0
                        OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
                            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                            OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
                    ELSE lpad((CASE WHEN o40_codtri = '0'
                        OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                        OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
                END) as codunidadesub
                from db_departorg join orcunidade on db01_orgao = o41_orgao and db01_unidade = o41_unidade
                        and db01_anousu = o41_anousu
                        JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                                where db01_anousu ={$oDados40->ac16_anousu}  and db01_coddepto ={$oDados40->ac16_deptoresponsavel}";

                $result = db_query($sSql); //db_criatabela($result);echo $sSql;echo pg_last_error();
                $sCodUnidadeSub = db_utils::fieldsMemory($result, 0)->codunidadesub;
            } else {
                $sCodUnidadeSub = ' ';
            }

            $clcontratos40->si91_tiporegistro               = 40; //campo 01
            $clcontratos40->si91_codorgao                   = $sCodorgao; //campo 02
            if ($oDados40->manutac_codunidsubanterior != '' && $oDados40->manutac_codunidsubanterior != null) {
                $clcontratos40->si91_codunidadesub  = $oDados40->manutac_codunidsubanterior; //campo 03
            } else {
                $clcontratos40->si91_codunidadesub              = $sCodUnidadeSub; //campo 03
            }

            $clcontratos40->si91_nrocontrato                = $oDados40->manutac_acordo =='' ? $oDados40->ac16_numeroacordo : $oDados40->manutac_acordo; //campo 04
            $clcontratos40->si91_dtassinaturacontoriginal   = $oDados40->ac16_dataassinatura; //campo 05
            $clcontratos40->si91_datarescisao               = $oDados40->ac16_datarescisao; //campo 06
            $clcontratos40->si91_valorcancelamentocontrato  = $oDados40->ac16_valorrescisao; //campo 07
            $clcontratos40->si91_mes                        = date('m', strtotime($this->sDataFinal));
            $clcontratos40->si91_instit                     = $oDados40->ac16_instit;

            $clcontratos40->incluir(null);

            if ($clcontratos40->erro_status == 0) {
                throw new Exception($clcontratos40->erro_msg);
            }
        }

        db_fim_transacao();

        $oGerarCONTRATOS = new GerarCONTRATOS();
        $oGerarCONTRATOS->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oGerarCONTRATOS->gerarDados();
    }
}
