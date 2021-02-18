<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

require_once("model/contabilidade/relatorios/dcasp/FluxoCaixaDCASP2015.model.php");
require_once("fpdf151/assinatura.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_libtxt.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_libpostgres.php");
require_once("libs/db_libcontabilidade.php");
require_once("libs/db_liborcamento.php");
require_once("fpdf151/PDFDocument.php");

require_once("classes/db_dfcdcasp102020_classe.php");
require_once("classes/db_dfcdcasp202020_classe.php");
require_once("classes/db_dfcdcasp302020_classe.php");
require_once("classes/db_dfcdcasp402020_classe.php");
require_once("classes/db_dfcdcasp502020_classe.php");
require_once("classes/db_dfcdcasp602020_classe.php");
require_once("classes/db_dfcdcasp702020_classe.php");
require_once("classes/db_dfcdcasp802020_classe.php");
require_once("classes/db_dfcdcasp902020_classe.php");
require_once("classes/db_dfcdcasp1002020_classe.php");
require_once("classes/db_dfcdcasp1102020_classe.php");

require_once("model/contabilidade/arquivos/sicom/2020/dcasp/geradores/GerarDFC.model.php");

/**
 * gerar arquivo de Demonstração dos Fluxos de Caixa
 * @author gabriel
 * @package Contabilidade
 */
class SicomArquivoDFC extends SicomArquivoBase implements iPadArquivoBaseCSV
{

    protected $iCodigoLayout = 150; // Código do relatório

    protected $sNomeArquivo = 'DFC';

    protected $iCodigoPespectiva;

    protected $sTipoGeracao;

    /**
     * @return mixed
     */
    public function getTipoGeracao()
    {
        return $this->sTipoGeracao;
    }

    /**
     * @param mixed $sTipoGeracao
     */
    public function setTipoGeracao($sTipoGeracao)
    {
        $this->sTipoGeracao = $sTipoGeracao;
    }

    public function getCodigoLayout(){
        return $this->iCodigoLayout;
    }

    public function getNomeArquivo(){
        return $this->sNomeArquivo;
    }

    public function getCampos() {
        return array();
    }


    /**
     * Contrutor da classe
     */
    public function __construct() { }

    /**
     * selecionar os dados das Demonstrações dos Fluxos de Caixa pra gerar o arquivo
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados()
    {
        $iAnoUsu            = db_getsession("DB_anousu");
        $iCodigoPeriodo     = date('m', strtotime($this->sDataFinal)) + 16;
        $iCodigoRelatorio   = $this->iCodigoLayout;

        if ($this->getTipoGeracao() == 'CONSOLIDADO') {

            $sSqlInstit = "select codigo from db_config ";
            $aInstits   = db_utils::getColectionByRecord(db_query($sSqlInstit));
            $aInstituicoes = array_map(function ($oItem) {
                return $oItem->codigo;
            }, $aInstits);

        } else {
            $aInstituicoes = array(db_getsession("DB_instit"));
        }

        $sListaInstituicoes = implode(',', $aInstituicoes);
        /**
         * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
         */
        $cldfcdcasp10   = new cl_dfcdcasp102020();
        $cldfcdcasp20   = new cl_dfcdcasp202020();
        $cldfcdcasp30   = new cl_dfcdcasp302020();
        $cldfcdcasp40   = new cl_dfcdcasp402020();
        $cldfcdcasp50   = new cl_dfcdcasp502020();
        $cldfcdcasp60   = new cl_dfcdcasp602020();
        $cldfcdcasp70   = new cl_dfcdcasp702020();
        $cldfcdcasp80   = new cl_dfcdcasp802020();
        $cldfcdcasp90   = new cl_dfcdcasp902020();
        $cldfcdcasp100  = new cl_dfcdcasp1002020();
        $cldfcdcasp110  = new cl_dfcdcasp1102020();

        /**
         * excluir informacoes caso estejam repetidas
         */
        db_inicio_transacao();

        /** DFCDCASP10 */
        $sWhereSelectDelete = "si219_anousu = {$iAnoUsu} AND si219_periodo = {$iCodigoPeriodo} AND si219_instit IN ({$sListaInstituicoes}) ";
        $sSQL   = $cldfcdcasp10->sql_query(null, '*', null, $sWhereSelectDelete);
        $result = $cldfcdcasp10->sql_record($sSQL);
        if (pg_num_rows($result) > 0) {
            $cldfcdcasp10->excluir(null, $sWhereSelectDelete);
            if ($cldfcdcasp10->erro_status == 0) {
                throw new Exception($cldfcdcasp10->erro_msg);
            }
        }

        /** DFCDCASP20 */
        $sWhereSelectDelete = "si220_anousu = {$iAnoUsu} AND si220_periodo = {$iCodigoPeriodo} AND si220_instit IN ({$sListaInstituicoes}) ";
        $sSQL   = $cldfcdcasp20->sql_query(null, '*', null, $sWhereSelectDelete);
        $result = $cldfcdcasp20->sql_record($sSQL);
        if (pg_num_rows($result) > 0) {
            $cldfcdcasp20->excluir(null, $sWhereSelectDelete);
            if ($cldfcdcasp20->erro_status == 0) {
                throw new Exception($cldfcdcasp20->erro_msg);
            }
        }

        /** DFCDCASP30 */
        $sWhereSelectDelete = "si221_anousu = {$iAnoUsu} AND si221_periodo = {$iCodigoPeriodo} AND si221_instit IN ({$sListaInstituicoes}) ";
        $sSQL   = $cldfcdcasp30->sql_query(null, '*', null, $sWhereSelectDelete);
        $result = $cldfcdcasp30->sql_record($sSQL);
        if (pg_num_rows($result) > 0) {
            $cldfcdcasp30->excluir(null, $sWhereSelectDelete);
            if ($cldfcdcasp30->erro_status == 0) {
                throw new Exception($cldfcdcasp30->erro_msg);
            }
        }

        /** DFCDCASP40 */
        $sWhereSelectDelete = "si222_anousu = {$iAnoUsu} AND si222_periodo = {$iCodigoPeriodo} AND si222_instit IN ({$sListaInstituicoes}) ";
        $sSQL   = $cldfcdcasp40->sql_query(null, '*', null, $sWhereSelectDelete);
        $result = $cldfcdcasp40->sql_record($sSQL);
        if (pg_num_rows($result) > 0) {
            $cldfcdcasp40->excluir(null, $sWhereSelectDelete);
            if ($cldfcdcasp40->erro_status == 0) {
                throw new Exception($cldfcdcasp40->erro_msg);
            }
        }

        /** DFCDCASP50 */
        $sWhereSelectDelete = "si223_anousu = {$iAnoUsu} AND si223_periodo = {$iCodigoPeriodo} AND si223_instit IN ({$sListaInstituicoes}) ";
        $sSQL   = $cldfcdcasp50->sql_query(null, '*', null, $sWhereSelectDelete);
        $result = $cldfcdcasp50->sql_record($sSQL);
        if (pg_num_rows($result) > 0) {
            $cldfcdcasp50->excluir(null, $sWhereSelectDelete);
            if ($cldfcdcasp50->erro_status == 0) {
                throw new Exception($cldfcdcasp50->erro_msg);
            }
        }

        /** DFCDCASP60 */
        $sWhereSelectDelete = "si224_anousu = {$iAnoUsu} AND si224_periodo = {$iCodigoPeriodo} AND si224_instit IN ({$sListaInstituicoes}) ";
        $sSQL   = $cldfcdcasp60->sql_query(null, '*', null, $sWhereSelectDelete);
        $result = $cldfcdcasp60->sql_record($sSQL);
        if (pg_num_rows($result) > 0) {
            $cldfcdcasp60->excluir(null, $sWhereSelectDelete);
            if ($cldfcdcasp60->erro_status == 0) {
                throw new Exception($cldfcdcasp60->erro_msg);
            }
        }

        /** DFCDCASP70 */
        $sWhereSelectDelete = "si225_anousu = {$iAnoUsu} AND si225_periodo = {$iCodigoPeriodo} AND si225_instit IN ({$sListaInstituicoes}) ";
        $sSQL   = $cldfcdcasp70->sql_query(null, '*', null, $sWhereSelectDelete);
        $result = $cldfcdcasp70->sql_record($sSQL);
        if (pg_num_rows($result) > 0) {
            $cldfcdcasp70->excluir(null, $sWhereSelectDelete);
            if ($cldfcdcasp70->erro_status == 0) {
                throw new Exception($cldfcdcasp70->erro_msg);
            }
        }

        /** DFCDCASP80 */
        $sWhereSelectDelete = "si226_anousu = {$iAnoUsu} AND si226_periodo = {$iCodigoPeriodo} AND si226_instit IN ({$sListaInstituicoes}) ";
        $sSQL   = $cldfcdcasp80->sql_query(null, '*', null, $sWhereSelectDelete);
        $result = $cldfcdcasp80->sql_record($sSQL);
        if (pg_num_rows($result) > 0) {
            $cldfcdcasp80->excluir(null, $sWhereSelectDelete);
            if ($cldfcdcasp80->erro_status == 0) {
                throw new Exception($cldfcdcasp80->erro_msg);
            }
        }

        /** DFCDCASP90 */
        $sWhereSelectDelete = "si227_anousu = {$iAnoUsu} AND si227_periodo = {$iCodigoPeriodo} AND si227_instit IN ({$sListaInstituicoes}) ";
        $sSQL   = $cldfcdcasp90->sql_query(null, '*', null, $sWhereSelectDelete);
        $result = $cldfcdcasp90->sql_record($sSQL);
        if (pg_num_rows($result) > 0) {
            $cldfcdcasp90->excluir(null, $sWhereSelectDelete);
            if ($cldfcdcasp90->erro_status == 0) {
                throw new Exception($cldfcdcasp90->erro_msg);
            }
        }

        /** DFCDCASP100 */
        $sWhereSelectDelete = "si228_anousu = {$iAnoUsu} AND si228_periodo = {$iCodigoPeriodo} AND si228_instit IN ({$sListaInstituicoes}) ";
        $sSQL   = $cldfcdcasp100->sql_query(null, '*', null, $sWhereSelectDelete);
        $result = $cldfcdcasp100->sql_record($sSQL);
        if (pg_num_rows($result) > 0) {
            $cldfcdcasp100->excluir(null, $sWhereSelectDelete);
            if ($cldfcdcasp100->erro_status == 0) {
                throw new Exception($cldfcdcasp100->erro_msg);
            }
        }

        /** DFCDCASP110 */
        $sWhereSelectDelete = "si229_anousu = {$iAnoUsu} AND si229_periodo = {$iCodigoPeriodo} AND si229_instit IN ({$sListaInstituicoes}) ";
        $sSQL   = $cldfcdcasp110->sql_query(null, '*', null, $sWhereSelectDelete);
        $result = $cldfcdcasp110->sql_record($sSQL);
        if (pg_num_rows($result) > 0) {
            $cldfcdcasp110->excluir(null, $sWhereSelectDelete);
            if ($cldfcdcasp110->erro_status == 0) {
                throw new Exception($cldfcdcasp110->erro_msg);
            }
        }


        /*------------------------------------------------------------------------*/

        /**
         * O método `getDados()`, da classe `FluxoCaixaDCASP2015()`,
         * retorna um array enorme. Para pegar os dados necessários para cada
         * registro do SICOM DCASP, estamos passando os índices exatos do array.
         * Se eles forem alterados (nas configurações dos relatórios), devem
         * ser alterados aqui também.
         */

        $oFluxoCaixa = new FluxoCaixaDCASP2015($iAnoUsu, $iCodigoRelatorio, $iCodigoPeriodo);
        $aQuadros = array();
        $aQuadros[] = FluxoCaixaDCASP2015::QUADRO_PRINCIPAL;
        // $aQuadros[] = FluxoCaixaDCASP2015::QUADRO_RECEITAS;
        // $aQuadros[] = FluxoCaixaDCASP2015::QUADRO_TRANSFERENCIAS;
        // $aQuadros[] = FluxoCaixaDCASP2015::QUADRO_DESEMBOLSOS;
        // $aQuadros[] = FluxoCaixaDCASP2015::QUADRO_DIVIDA;

        $oFluxoCaixa->setInstituicoes($sListaInstituicoes);
        $oFluxoCaixa->setExibirQuadros($aQuadros);
        $oFluxoCaixa->setExibirExercicioAnterior(true);

        $aRetornoDFC = $oFluxoCaixa->getDados();
//        print_r($aRetornoDFC);exit;
        // $oTeste = new stdClass();
        // $oTeste->vlrexatual = rand(10,1000);
        // $oTeste->vlrexanter = rand(10,1000);
        // $aRetornoDFC = array_fill(0, 40, $oTeste);

        /*------------------------------------------------------------------------*/

        $aExercicios = array(
            1 => 'vlrexatual'
        );


        /** DFCDCASP102020
         * FLUXOS DE CAIXA DAS ATIVIDADES OPERACIONAIS - Ingressos
         */
        foreach ($aExercicios as $iValorNumerico => $sChave) {

            $cldfcdcasp10 = new cl_dfcdcasp102020();

            $cldfcdcasp10->si219_anousu                           = $iAnoUsu;
            $cldfcdcasp10->si219_periodo                          = $iCodigoPeriodo;
            $cldfcdcasp10->si219_instit                           = db_getsession("DB_instit");
            $cldfcdcasp10->si219_tiporegistro                     = 10;
            $cldfcdcasp10->si219_exercicio                        = $iValorNumerico;

//      $cldfcdcasp10->si219_vlreceitaderivadaoriginaria      = $aRetornoDFC[3]->$sChave;
//      $cldfcdcasp10->si219_vltranscorrenterecebida          = $aRetornoDFC[4]->$sChave;

            $cldfcdcasp10->si219_vlreceitatributaria = $aRetornoDFC[36]->$sChave;
            $cldfcdcasp10->si219_vlreceitacontribuicao = $aRetornoDFC[37]->$sChave;
            $cldfcdcasp10->si219_vlreceitapatrimonial = $aRetornoDFC[38]->$sChave;
            $cldfcdcasp10->si219_vlreceitaagropecuaria = $aRetornoDFC[39]->$sChave;
            $cldfcdcasp10->si219_vlreceitaindustrial = $aRetornoDFC[40]->$sChave;
            $cldfcdcasp10->si219_vlreceitaservicos = $aRetornoDFC[41]->$sChave;
            $cldfcdcasp10->si219_vlremuneracaodisponibilidade = $aRetornoDFC[42]->$sChave;
            $cldfcdcasp10->si219_vloutrasreceitas = $aRetornoDFC[43]->$sChave;
            $cldfcdcasp10->si219_vltransferenciarecebidas = $aRetornoDFC[4]->$sChave;
            $cldfcdcasp10->si219_vloutrosingressosoperacionais    = $aRetornoDFC[5]->$sChave;

            $cldfcdcasp10->si219_vltotalingressosativoperacionais = $aRetornoDFC[2]->$sChave;

            $cldfcdcasp10->incluir(null);
            if ($cldfcdcasp10->erro_status == 0) {
                throw new Exception($cldfcdcasp10->erro_msg);
            }

        } // $rsResult10


        /** DFCDCASP202020
         * FLUXOS DE CAIXA DAS ATIVIDADES OPERACIONAIS - Desembolsos
         */
        foreach ($aExercicios as $iValorNumerico => $sChave) {

            $cldfcdcasp20 = new cl_dfcdcasp202020();

            $cldfcdcasp20->si220_anousu                             = $iAnoUsu;
            $cldfcdcasp20->si220_periodo                            = $iCodigoPeriodo;
            $cldfcdcasp20->si220_instit                             = db_getsession("DB_instit");
            $cldfcdcasp20->si220_tiporegistro                       = 20;
            $cldfcdcasp20->si220_exercicio                          = $iValorNumerico;
            $cldfcdcasp20->si220_vldesembolsopessoaldespesas        = $aRetornoDFC[7]->$sChave;
            $cldfcdcasp20->si220_vldesembolsojurosencargdivida      = $aRetornoDFC[8]->$sChave;
            $cldfcdcasp20->si220_vldesembolsotransfconcedidas       = $aRetornoDFC[9]->$sChave;
            $cldfcdcasp20->si220_vloutrosdesembolsos                = $aRetornoDFC[10]->$sChave;
            $cldfcdcasp20->si220_vltotaldesembolsosativoperacionais = $aRetornoDFC[6]->$sChave;

            $cldfcdcasp20->incluir(null);
            if ($cldfcdcasp20->erro_status == 0) {
                throw new Exception($cldfcdcasp20->erro_msg);
            }

        } // $rsResult20


        /** DFCDCASP302020
         * Fluxo de caixa líquido das atividades operacionais (I)
         */

        foreach ($aExercicios as $iValorNumerico => $sChave) {

            $cldfcdcasp30 = new cl_dfcdcasp302020();

            $cldfcdcasp30->si221_anousu                         = $iAnoUsu;
            $cldfcdcasp30->si221_periodo                        = $iCodigoPeriodo;
            $cldfcdcasp30->si221_instit                         = db_getsession("DB_instit");
            $cldfcdcasp30->si221_tiporegistro                   = 30;
            $cldfcdcasp30->si221_exercicio                      = $iValorNumerico;
            $cldfcdcasp30->si221_vlfluxocaixaliquidooperacional = $aRetornoDFC[11]->$sChave;

            $cldfcdcasp30->incluir(null);
            if ($cldfcdcasp30->erro_status == 0) {
                throw new Exception($cldfcdcasp30->erro_msg);
            }

        } // $rsResult30


        /** DFCDCASP402020
         * FLUXOS DE CAIXA DAS ATIVIDADES DE INVESTIMENTO - Ingressos
         */

        foreach ($aExercicios as $iValorNumerico => $sChave) {

            $cldfcdcasp40 = new cl_dfcdcasp402020();

            $cldfcdcasp40->si222_anousu                             = $iAnoUsu;
            $cldfcdcasp40->si222_periodo                            = $iCodigoPeriodo;
            $cldfcdcasp40->si222_instit                             = db_getsession("DB_instit");
            $cldfcdcasp40->si222_tiporegistro                       = 40;
            $cldfcdcasp40->si222_exercicio                          = $iValorNumerico;
            $cldfcdcasp40->si222_vlalienacaobens                    = $aRetornoDFC[14]->$sChave;
            $cldfcdcasp40->si222_vlamortizacaoemprestimoconcedido   = $aRetornoDFC[15]->$sChave;
            $cldfcdcasp40->si222_vloutrosingressos                  = $aRetornoDFC[16]->$sChave;
            $cldfcdcasp40->si222_vltotalingressosatividainvestiment = $aRetornoDFC[13]->$sChave;

            $cldfcdcasp40->incluir(null);
            if ($cldfcdcasp40->erro_status == 0) {
                throw new Exception($cldfcdcasp40->erro_msg);
            }

        } // $rsResult40


        /** DFCDCASP502020
         * FLUXOS DE CAIXA DAS ATIVIDADES DE INVESTIMENTO - Desembolsos
         */

        foreach ($aExercicios as $iValorNumerico => $sChave) {

            $cldfcdcasp50 = new cl_dfcdcasp502020();

            $cldfcdcasp50->si223_anousu                             = $iAnoUsu;
            $cldfcdcasp50->si223_periodo                            = $iCodigoPeriodo;
            $cldfcdcasp50->si223_instit                             = db_getsession("DB_instit");
            $cldfcdcasp50->si223_tiporegistro                       = 50;
            $cldfcdcasp50->si223_exercicio                          = $iValorNumerico;
            $cldfcdcasp50->si223_vlaquisicaoativonaocirculante      = $aRetornoDFC[18]->$sChave;
            $cldfcdcasp50->si223_vlconcessaoempresfinanciamento     = $aRetornoDFC[19]->$sChave;
            $cldfcdcasp50->si223_vloutrosdesembolsos                = $aRetornoDFC[20]->$sChave;
            $cldfcdcasp50->si223_vltotaldesembolsoatividainvestimen = $aRetornoDFC[17]->$sChave;

            $cldfcdcasp50->incluir(null);
            if ($cldfcdcasp50->erro_status == 0) {
                throw new Exception($cldfcdcasp50->erro_msg);
            }

        } // $rsResult50


        /** DFCDCASP602020
         * Fluxo de caixa líquido das atividades de investimento (II)
         */

        foreach ($aExercicios as $iValorNumerico => $sChave) {

            $cldfcdcasp60 = new cl_dfcdcasp602020();

            $cldfcdcasp60->si224_anousu                           = $iAnoUsu;
            $cldfcdcasp60->si224_periodo                          = $iCodigoPeriodo;
            $cldfcdcasp60->si224_instit                           = db_getsession("DB_instit");
            $cldfcdcasp60->si224_tiporegistro                     = 60;
            $cldfcdcasp60->si224_exercicio                        = $iValorNumerico;
            $cldfcdcasp60->si224_vlfluxocaixaliquidoinvestimento  = $aRetornoDFC[21]->$sChave;

            $cldfcdcasp60->incluir(null);
            if ($cldfcdcasp60->erro_status == 0) {
                throw new Exception($cldfcdcasp60->erro_msg);
            }

        } // $rsResult60


        /** DFCDCASP702020
         * FLUXOS DE CAIXA DAS ATIVIDADES DE FINANCIAMENTO - Ingressos
         */

        foreach ($aExercicios as $iValorNumerico => $sChave) {

            $cldfcdcasp70 = new cl_dfcdcasp702020();

            $cldfcdcasp70->si225_anousu                             = $iAnoUsu;
            $cldfcdcasp70->si225_periodo                            = $iCodigoPeriodo;
            $cldfcdcasp70->si225_instit                             = db_getsession("DB_instit");
            $cldfcdcasp70->si225_tiporegistro                       = 70;
            $cldfcdcasp70->si225_exercicio                          = $iValorNumerico;
            $cldfcdcasp70->si225_vloperacoescredito                 = $aRetornoDFC[24]->$sChave;
            $cldfcdcasp70->si225_vlintegralizacaodependentes        = $aRetornoDFC[25]->$sChave;
            $cldfcdcasp70->si225_vltranscapitalrecebida             = $aRetornoDFC[26]->$sChave;
            $cldfcdcasp70->si225_vloutrosingressosfinanciamento     = $aRetornoDFC[27]->$sChave;
            $cldfcdcasp70->si225_vltotalingressoatividafinanciament = $aRetornoDFC[23]->$sChave;

            $cldfcdcasp70->incluir(null);
            if ($cldfcdcasp70->erro_status == 0) {
                throw new Exception($cldfcdcasp70->erro_msg);
            }

        } // $rsResult70


        /** DFCDCASP802020
         * FLUXOS DE CAIXA DAS ATIVIDADES DE FINANCIAMENTO - Desembolsos
         */

        foreach ($aExercicios as $iValorNumerico => $sChave) {

            $cldfcdcasp80 = new cl_dfcdcasp802020();

            $cldfcdcasp80->si226_anousu                             = $iAnoUsu;
            $cldfcdcasp80->si226_periodo                            = $iCodigoPeriodo;
            $cldfcdcasp80->si226_instit                             = db_getsession("DB_instit");
            $cldfcdcasp80->si226_tiporegistro                       = 80;
            $cldfcdcasp80->si226_exercicio                          = $iValorNumerico;
            $cldfcdcasp80->si226_vlamortizacaorefinanciamento       = $aRetornoDFC[29]->$sChave;
            $cldfcdcasp80->si226_vloutrosdesembolsosfinanciamento   = $aRetornoDFC[30]->$sChave;
            $cldfcdcasp80->si226_vltotaldesembolsoatividafinanciame = $aRetornoDFC[28]->$sChave;

            $cldfcdcasp80->incluir(null);
            if ($cldfcdcasp80->erro_status == 0) {
                throw new Exception($cldfcdcasp80->erro_msg);
            }

        } // $rsResult80


        /** DFCDCASP902020
         * Fluxo de caixa líquido das atividades de financiamento (III)
         */

        foreach ($aExercicios as $iValorNumerico => $sChave) {

            $cldfcdcasp90 = new cl_dfcdcasp902020();

            $cldfcdcasp90->si227_anousu                     = $iAnoUsu;
            $cldfcdcasp90->si227_periodo                    = $iCodigoPeriodo;
            $cldfcdcasp90->si227_instit                     = db_getsession("DB_instit");
            $cldfcdcasp90->si227_tiporegistro               = 90;
            $cldfcdcasp90->si227_exercicio                  = $iValorNumerico;
            $cldfcdcasp90->si227_vlfluxocaixafinanciamento  = $aRetornoDFC[31]->$sChave;

            $cldfcdcasp90->incluir(null);
            if ($cldfcdcasp90->erro_status == 0) {
                throw new Exception($cldfcdcasp90->erro_msg);
            }

        } // $rsResult90


        /** DFCDCASP1002020
         * GERAÇÃO LÍQUIDA DE CAIXA E EQUIVALENTE DE CAIXA ( I+II+III )
         */

        foreach ($aExercicios as $iValorNumerico => $sChave) {

            $cldfcdcasp100 = new cl_dfcdcasp1002020();

            $cldfcdcasp100->si228_anousu                            = $iAnoUsu;
            $cldfcdcasp100->si228_periodo                           = $iCodigoPeriodo;
            $cldfcdcasp100->si228_instit                            = db_getsession("DB_instit");
            $cldfcdcasp100->si228_tiporegistro                      = 100;
            $cldfcdcasp100->si228_exercicio                         = $iValorNumerico;
            $cldfcdcasp100->si228_vlgeracaoliquidaequivalentecaixa  = $aRetornoDFC[32]->$sChave;

            $cldfcdcasp100->incluir(null);
            if ($cldfcdcasp100->erro_status == 0) {
                throw new Exception($cldfcdcasp100->erro_msg);
            }

        } // $rsResult100


        /** DFCDCASP1102020
         * Caixa e Equivalentes de caixa inicial e final
         */

        foreach ($aExercicios as $iValorNumerico => $sChave) {

            $cldfcdcasp110 = new cl_dfcdcasp1102020();

            $cldfcdcasp110->si229_anousu                          = $iAnoUsu;
            $cldfcdcasp110->si229_periodo                         = $iCodigoPeriodo;
            $cldfcdcasp110->si229_instit                          = db_getsession("DB_instit");
            $cldfcdcasp110->si229_tiporegistro                    = 110;
            $cldfcdcasp110->si229_exercicio                       = $iValorNumerico;
            $cldfcdcasp110->si229_vlcaixaequivalentecaixainicial  = $aRetornoDFC[33]->$sChave;
            $cldfcdcasp110->si229_vlcaixaequivalentecaixafinal    = $aRetornoDFC[34]->$sChave;

            $cldfcdcasp110->incluir(null);
            if ($cldfcdcasp110->erro_status == 0) {
                throw new Exception($cldfcdcasp110->erro_msg);
            }

        } // $rsResult110



        db_fim_transacao();

        $oGerarDFC = new GerarDFC();
        $oGerarDFC->iAno      = $iAnoUsu;
        $oGerarDFC->iPeriodo  = $iCodigoPeriodo;
        $oGerarDFC->gerarDados();

    }

}
