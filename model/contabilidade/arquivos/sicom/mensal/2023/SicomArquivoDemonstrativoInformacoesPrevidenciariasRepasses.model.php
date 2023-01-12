<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_dipr102023_classe.php");
require_once("classes/db_dipr202023_classe.php");
require_once("classes/db_dipr302023_classe.php");
require_once("classes/db_dipr402023_classe.php");
require_once("classes/db_dipr502023_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2023/GerarDIPR.model.php");

/**
 * Selecionar dados de DIPR Sicom Acompanhamento Mensal
 * @author widouglas
 * @package Contabilidade
 */
class SicomArquivoDemonstrativoInformacoesPrevidenciariasRepasses extends SicomArquivoBase implements iPadArquivoBaseCSV
{

    /**
     *
     * Codigo do layout
     * @var Integer
     */
    protected $iCodigoLayout;

    /**
     *
     * Nome do arquivo a ser criado
     * @var unknown_type
     */
    protected $sNomeArquivo = 'DIPR';

    /*
   * Contrutor da classe
   */
    public function __construct()
    {
    }

    /**
     * retornar o codigo do layout
     *
     * @return Integer
     */
    public function getCodigoLayout()
    {
        return $this->iCodigoLayout;
    }

    /**
     *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
     * @return Array
     */
    public function getCampos()
    {
    }

    /**
     * selecionar os dados de Leis de Alteração
     *
     */
    public function gerarDados()
    {
        $cldipr10 = new cl_dipr102023();
        $cldipr20 = new cl_dipr202023();
        $cldipr30 = new cl_dipr302023();
        $cldipr40 = new cl_dipr402023();
        $cldipr50 = new cl_dipr502023();

        db_inicio_transacao();
        /*
         * excluir informacoes do mes selecionado registro 10
        */

        $result = $cldipr10->sql_record($cldipr10->sql_query(null, "*", null, "si230_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si230_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $cldipr10->excluir(null, "si230_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si230_instit = " . db_getsession("DB_instit"));
            if ($cldipr10->erro_status == 0) {
                throw new Exception($cldipr10->erro_msg);
            }
        }

        $result = $cldipr20->sql_record($cldipr20->sql_query(null, "*", null, "si231_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si231_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $cldipr20->excluir(null, "si231_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si231_instit = " . db_getsession("DB_instit"));
    
            if ($cldipr20->erro_status == 0) {
                throw new Exception($cldipr20->erro_msg);
            }
        }

        $result = $cldipr30->sql_record($cldipr30->sql_query(null, "*", null, "si232_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si232_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $cldipr30->excluir(null, "si232_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si232_instit = " . db_getsession("DB_instit"));
            if ($cldipr30->erro_status == 0) {
                throw new Exception($cldipr30->erro_msg);
            }
        }

        $result = $cldipr40->sql_record($cldipr40->sql_query(null, "*", null, "si233_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si233_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $cldipr40->excluir(null, "si233_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si233_instit = " . db_getsession("DB_instit"));
            if ($cldipr40->erro_status == 0) {
                throw new Exception($cldipr40->erro_msg);
            }
        }

        $result = $cldipr50->sql_record($cldipr50->sql_query(null, "*", null, "si234_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si234_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $cldipr50->excluir(null, "si234_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si234_instit = " . db_getsession("DB_instit"));
            if ($cldipr50->erro_status == 0) {
                throw new Exception($cldipr50->erro_msg);
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
        
        $sSql = "SELECT * FROM dipr WHERE c236_orgao = " . db_getsession("DB_instit") . " AND not exists (select 1 from dipr102023 where si230_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "  and si230_instit = " . db_getsession("DB_instit") . " AND si230_coddipr = c236_coddipr );";

        $rsResult10 = db_query($sSql);
        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

            $cldipr10 = new cl_dipr102023();
            $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

            $cldipr10->si230_tiporegistro = 10;
            $cldipr10->si230_coddipr = $oDados10->c236_coddipr;
            $cldipr10->si230_segregacaomassa = $oDados10->c236_massainstituida == 't' ? 1 : 2;
            $cldipr10->si230_benefcustesouro = $oDados10->c236_beneficiotesouro == 't' ? 1 : 2;
            $cldipr10->si230_atonormativo = $oDados10->c236_atonormativo;
            $cldipr10->si230_exercicioato = $oDados10->c236_exercicionormativo;
            $cldipr10->si230_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $cldipr10->si230_instit = db_getsession("DB_instit");

            $cldipr10->incluir(null);

            if ($cldipr10->erro_status == 0) {
                throw new Exception($cldipr10->erro_msg);
            }
        }

        $sSql = "SELECT diprbasecontribuicao.*, CASE WHEN c237_tipoente = 1 THEN i1.si09_codorgaotce WHEN c237_tipoente = 2 THEN i2.si09_codorgaotce WHEN c237_tipoente = 3 THEN i3.si09_codorgaotce END as c236_orgao FROM diprbasecontribuicao LEFT JOIN dipr ON c236_coddipr = c237_coddipr LEFT JOIN db_config db1 ON db1.numcgm = c236_numcgmexecutivo LEFT JOIN infocomplementaresinstit i1 ON i1.si09_instit = db1.codigo LEFT JOIN db_config db2 ON db2.numcgm = c236_numcgmlegislativo LEFT JOIN infocomplementaresinstit i2 ON i2.si09_instit = db2.codigo LEFT JOIN db_config db3 ON db3.numcgm = c236_numcgmgestora LEFT JOIN infocomplementaresinstit i3 ON i3.si09_instit = db3.codigo WHERE c236_orgao = " . db_getsession("DB_instit") . " AND c237_datasicom BETWEEN '{$this->sDataInicial}' AND '{$this->sDataFinal}'; ";

        $rsResult20 = db_query($sSql);
        $aEnte = array(1 => "Executivo", 2 => "Legistalivo", 3 => "Gestor");
        for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

            $cldipr20 = new cl_dipr202023();
            $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

            if (empty($oDados20->c236_orgao))
                throw new Exception("O ente " . $aEnte[$oDados20->c237_tipoente] . " informado no <b> Cadastro de InformaçÕes Previdenciarias </b> não está vinculado ao órgão do TCE.");

            $cldipr20->si231_tiporegistro = 20;
            $cldipr20->si231_codorgao = $oDados20->c236_orgao;
            $cldipr20->si231_coddipr = $oDados20->c237_coddipr;
            $cldipr20->si231_tipobasecalculo = $oDados20->c237_basecalculocontribuinte;
            $cldipr20->si231_mescompetencia = $oDados20->c237_mescompetencia ? $oDados20->c237_mescompetencia : 0;
            $cldipr20->si231_exerciciocompetencia = $oDados20->c237_exerciciocompetencia ? $oDados20->c237_exerciciocompetencia : 0;
            $cldipr20->si231_tipofundo = $oDados20->c237_tipofundo;
            $cldipr20->si231_remuneracaobrutafolhapag = $oDados20->c237_remuneracao;
            $cldipr20->si231_tipobasecalculocontrprevidencia = $oDados20->c237_basecalculosegurados;
            $cldipr20->si231_tipobasecalculocontrseg = $oDados20->c237_basecalculoorgao;
            $cldipr20->si231_valorbasecalculocontr = $oDados20->c237_valorbasecalculo;
            $cldipr20->si231_tipocontribuicao = $oDados20->c237_tipocontribuinte;
            $cldipr20->si231_aliquota = $oDados20->c237_aliquota;
            $cldipr20->si231_valorcontribdevida = $oDados20->c237_valorcontribuicao;
            $cldipr20->si231_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $cldipr20->si231_instit = db_getsession("DB_instit");

            $cldipr20->incluir(null);

            if ($cldipr20->erro_status == 0) {
                throw new Exception($cldipr20->erro_msg);
            }
        }
         
        $sSql = "SELECT diprbaseprevidencia.*, CASE WHEN c238_tipoente = 1 THEN i1.si09_codorgaotce WHEN c238_tipoente = 2 THEN i2.si09_codorgaotce WHEN c238_tipoente = 3 THEN i3.si09_codorgaotce END as c236_orgao FROM diprbaseprevidencia LEFT JOIN dipr ON c236_coddipr = c238_coddipr LEFT JOIN db_config db1 ON db1.numcgm = c236_numcgmexecutivo LEFT JOIN infocomplementaresinstit i1 ON i1.si09_instit = db1.codigo LEFT JOIN db_config db2 ON db2.numcgm = c236_numcgmlegislativo LEFT JOIN infocomplementaresinstit i2 ON i2.si09_instit = db2.codigo LEFT JOIN db_config db3 ON db3.numcgm = c236_numcgmgestora LEFT JOIN infocomplementaresinstit i3 ON i3.si09_instit = db3.codigo WHERE c236_orgao = " . db_getsession("DB_instit") . " AND c238_datasicom BETWEEN '{$this->sDataInicial}' AND '{$this->sDataFinal}';";

        $rsResult30 = db_query($sSql);
        for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {

            $cldipr30 = new cl_dipr302023();
            $oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);

            $cldipr30->si232_tiporegistro = 30;
            $cldipr30->si232_codorgao = $oDados30->c236_orgao;
            $cldipr30->si232_coddipr = $oDados30->c238_coddipr;
            $cldipr30->si232_mescompetencia = $oDados30->c238_mescompetencia ? $oDados30->c238_mescompetencia : 0;
            $cldipr30->si232_exerciciocompetencia = $oDados30->c238_exerciciocompetencia ? $oDados30->c238_exerciciocompetencia : 0;
            $cldipr30->si232_tipofundo = $oDados30->c238_tipofundo;
            $cldipr30->si232_tiporepasse = $oDados30->c238_tiporepasse;
            $cldipr30->si232_tipocontripatronal = $oDados30->c238_tipocontribuicaopatronal;
            $cldipr30->si232_tipocontrisegurado = $oDados30->c238_tipocontribuicaosegurados;
            $cldipr30->si232_tipocontribuicao = $oDados30->c238_tipocontribuicao;
            $cldipr30->si232_datarepasse = $oDados30->c238_datarepasse;
            $cldipr30->si232_datavencirepasse = $oDados30->c238_datavencimentorepasse;
            $cldipr30->si232_valororiginal = $oDados30->c238_valororiginal;
            $cldipr30->si232_valororiginalrepassado = $oDados30->c238_valororiginalrepassado;
            $cldipr30->si232_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $cldipr30->si232_instit = db_getsession("DB_instit");

            $cldipr30->incluir(null);

            if ($cldipr30->erro_status == 0) {
                throw new Exception($cldipr30->erro_msg);
            }
        }

        $sSql = "SELECT diprdeducoes.*, CASE WHEN c239_tipoente = 1 THEN i1.si09_codorgaotce WHEN c239_tipoente = 2 THEN i2.si09_codorgaotce WHEN c239_tipoente = 3 THEN i3.si09_codorgaotce END as c236_orgao FROM diprdeducoes LEFT JOIN dipr ON c236_coddipr = c239_coddipr LEFT JOIN db_config db1 ON db1.numcgm = c236_numcgmexecutivo LEFT JOIN infocomplementaresinstit i1 ON i1.si09_instit = db1.codigo LEFT JOIN db_config db2 ON db2.numcgm = c236_numcgmlegislativo LEFT JOIN infocomplementaresinstit i2 ON i2.si09_instit = db2.codigo LEFT JOIN db_config db3 ON db3.numcgm = c236_numcgmgestora LEFT JOIN infocomplementaresinstit i3 ON i3.si09_instit = db3.codigo WHERE c236_orgao = " . db_getsession("DB_instit") . " AND c239_datasicom BETWEEN '{$this->sDataInicial}' AND '{$this->sDataFinal}';";

        $rsResult40 = db_query($sSql);
        for ($iCont40 = 0; $iCont40 < pg_num_rows($rsResult40); $iCont40++) {

            $cldipr40 = new cl_dipr402023();
            $oDados40 = db_utils::fieldsMemory($rsResult40, $iCont40);

            $cldipr40->si233_tiporegistro = 40;
            $cldipr40->si233_codorgao = $oDados40->c236_orgao;
            $cldipr40->si233_coddipr = $oDados40->c239_coddipr;
            $cldipr40->si233_mescompetencia = $oDados40->c239_mescompetencia ? $oDados40->c239_mescompetencia : 0;
            $cldipr40->si233_exerciciocompetencia = $oDados40->c239_exerciciocompetencia ? $oDados40->c239_exerciciocompetencia : 0;
            $cldipr40->si233_tipofundo = $oDados40->c239_tipofundo;
            $cldipr40->si233_tiporepasse = $oDados40->c239_tiporepasse;
            $cldipr40->si233_tipocontripatronal = $oDados40->c239_tipocontribuicaopatronal;
            $cldipr40->si233_tipocontrisegurado = $oDados40->c239_tipocontribuicaosegurados;
            $cldipr40->si233_tipocontribuicao = $oDados40->c239_tipocontribuicao;
            $cldipr40->si233_tipodeducao = $oDados40->c239_tipodeducao;
            $cldipr40->si233_dsctiposdeducoes = $oDados40->c239_descricao;
            $cldipr40->si233_valordeducao = $oDados40->c239_valordeducao;
            $cldipr40->si233_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $cldipr40->si233_instit = db_getsession("DB_instit");

            $cldipr40->incluir(null);

            if ($cldipr40->erro_status == 0) {
                throw new Exception($cldipr40->erro_msg);
            }
        }

        $sSql = "SELECT dipraportes.*, CASE WHEN c240_tipoente = 1 THEN i1.si09_codorgaotce WHEN c240_tipoente = 2 THEN i2.si09_codorgaotce WHEN c240_tipoente = 3 THEN i3.si09_codorgaotce END as c236_orgao FROM dipraportes LEFT JOIN dipr ON c236_coddipr = c240_coddipr LEFT JOIN db_config db1 ON db1.numcgm = c236_numcgmexecutivo LEFT JOIN infocomplementaresinstit i1 ON i1.si09_instit = db1.codigo LEFT JOIN db_config db2 ON db2.numcgm = c236_numcgmlegislativo LEFT JOIN infocomplementaresinstit i2 ON i2.si09_instit = db2.codigo LEFT JOIN db_config db3 ON db3.numcgm = c236_numcgmgestora LEFT JOIN infocomplementaresinstit i3 ON i3.si09_instit = db3.codigo WHERE c236_orgao = " . db_getsession("DB_instit") . " AND c240_datasicom BETWEEN '{$this->sDataInicial}' AND '{$this->sDataFinal}';";

        $rsResult50 = db_query($sSql);
        for ($iCont50 = 0; $iCont50 < pg_num_rows($rsResult50); $iCont50++) {

            $cldipr50 = new cl_dipr502023();
            $oDados50 = db_utils::fieldsMemory($rsResult50, $iCont50);

            $cldipr50->si234_tiporegistro = 50;
            $cldipr50->si234_codorgao = $oDados50->c236_orgao;
            $cldipr50->si234_coddipr = $oDados50->c240_coddipr;
            $cldipr50->si234_mescompetencia = $oDados50->c240_mescompetencia ? $oDados50->c240_mescompetencia : 0;
            $cldipr50->si234_exerciciocompetencia = $oDados50->c240_exerciciocompetencia ? $oDados50->c240_exerciciocompetencia : 0;
            $cldipr50->si234_tipofundo = $oDados50->c240_tipofundo;
            $cldipr50->si234_tipoaportetransf = $oDados50->c240_tipoaporte;
            $cldipr50->si234_dscoutrosaportestransf = $oDados50->c240_descricao;
            $cldipr50->si234_atonormativo = $oDados50->c240_atonormativo;
            $cldipr50->si234_exercicioato = $oDados50->c240_exercicioatonormativo;
            $cldipr50->si234_valoraportetransf = $oDados50->c240_valoraporte;
            $cldipr50->si234_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $cldipr50->si234_instit = db_getsession("DB_instit");

            $cldipr50->incluir(null);

            if ($cldipr50->erro_status == 0) {
                throw new Exception($cldipr50->erro_msg);
            }
        }

        db_fim_transacao();
        
        $oGerarDIPR = new GerarDIPR();
        $oGerarDIPR->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oGerarDIPR->gerarDados();
    }
}
