<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

// require_once('model/contabilidade/relatorios/RelatoriosLegaisBase.model.php');
require_once('model/contabilidade/relatorios/dcasp/BalancoOrcamentarioDCASP2015.model.php');
require_once('libs/db_stdlib.php');
require_once('libs/db_conecta.php');
require_once('libs/db_sessoes.php');
require_once('libs/db_usuariosonline.php');
require_once('fpdf151/assinatura.php');
require_once('libs/db_utils.php');
require_once('libs/db_app.utils.php');
require_once('dbforms/db_funcoes.php');
require_once('libs/db_libcontabilidade.php');
require_once('libs/db_liborcamento.php');
require_once('fpdf151/PDFDocument.php');

require_once("classes/db_bodcasp102017_classe.php");
// require_once("classes/db_bodcasp202017_classe.php");
// require_once("classes/db_bodcasp302017_classe.php");
require_once("classes/db_bodcasp402017_classe.php");
require_once("classes/db_bodcasp502017_classe.php");

require_once("model/contabilidade/arquivos/sicom/2017/dcasp/geradores/GerarBO.model.php");

/**
 * gerar arquivo de Balanço Orçamentário
 * @author gabriel
 * @package Contabilidade
 */
class SicomArquivoBO extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  protected $iCodigoLayout = 153; // Código do relatório

  protected $sNomeArquivo = 'BO';

  protected $iCodigoPespectiva;

  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }

  public function getNomeArquivo(){
    return $this->sNomeArquivo;
  }

  /**
   * esse metodo sera implementado criando um array com os campos
   * que serao necessarios para o escritor gerar o arquivo CSV
   */
  public function getCampos() {
    $aElementos  = array();
    return $aElementos;
  }

  /**
   * Contrutor da classe
   */
  public function __construct() { }

  /**
   * selecionar os dados do balanço orcamentário pra gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {
    $iAnoUsu            = db_getsession("DB_anousu");
    $iCodigoPeriodo     = date('m', strtotime($this->sDataFinal)) + 16;
    $iCodigoRelatorio   = $this->iCodigoLayout;
    $oInstit            = new Instituicao(db_getsession("DB_instit"));

    if ($oInstit->getTipoInstit() == Instituicao::TIPO_INSTIT_PREFEITURA) {

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
    $clbodcasp10 = new cl_bodcasp102017();
    // $clbodcasp20 = new cl_bodcasp202017();
    // $clbodcasp30 = new cl_bodcasp302017();
    $clbodcasp40 = new cl_bodcasp402017();
    $clbodcasp50 = new cl_bodcasp502017();


    /**
     * excluir informacoes caso estejam repetidas
     */
    db_inicio_transacao();

    /** BODCASP10 */
    $sWhereSelectDelete = "si201_ano = {$iAnoUsu} AND si201_periodo = {$iCodigoPeriodo} AND si201_institu IN ({$sListaInstituicoes}) ";
    $sSQL   = $clbodcasp10->sql_query(null, '*', null, $sWhereSelectDelete);
    $result = $clbodcasp10->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbodcasp10->excluir(null, $sWhereSelectDelete);
      if ($clbodcasp10->erro_status == 0) {
        throw new Exception($clbodcasp10->erro_msg);
      }
    }

    /** BODCASP40 */
    $sWhereSelectDelete = "si204_ano = {$iAnoUsu} AND si204_periodo = {$iCodigoPeriodo} AND si204_institu IN ({$sListaInstituicoes})";
    $sSQL   = $clbodcasp40->sql_query(null, '*', null, $sWhereSelectDelete);
    $result = $clbodcasp40->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbodcasp40->excluir(null, $sWhereSelectDelete);
      if ($clbodcasp40->erro_status == 0) {
        throw new Exception($clbodcasp40->erro_msg);
      }
    }

    /** BODCASP50 */
    $sWhereSelectDelete = "si205_ano = {$iAnoUsu} AND si205_periodo = {$iCodigoPeriodo} AND si205_institu IN ({$sListaInstituicoes})";
    $sSQL   = $clbodcasp50->sql_query(null, '*', null, $sWhereSelectDelete);
    $result = $clbodcasp50->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbodcasp50->excluir(null, $sWhereSelectDelete);
      if ($clbodcasp50->erro_status == 0) {
        throw new Exception($clbodcasp50->erro_msg);
      }
    }

    /*------------------------------------------------------------------------*/


    /**
     * O método `getDados()`, da classe `BalancoOrcamentarioDCASP2015()`,
     * retorna um array enorme. Para pegar os dados necessários para cada
     * registro do SICOM DCASP, estamos passando os índices exatos do array.
     * Se eles forem alterados (nas configurações dos relatórios), devem
     * ser alterados aqui também.
    */

    $oBalancoOrcamentario = new BalancoOrcamentarioDCASP2015($iAnoUsu, $iCodigoRelatorio, $iCodigoPeriodo);
    $oBalancoOrcamentario->setInstituicoes($sListaInstituicoes);

    $aQuadros   = array();
    $aQuadros[] = BalancoOrcamentarioDCASP2015::QUADRO_PRINCIPAL;
    $aQuadros[] = BalancoOrcamentarioDCASP2015::QUADRO_RESTOS_NAO_PROCESSADOS;
    $aQuadros[] = BalancoOrcamentarioDCASP2015::QUADRO_RESTOS_PROCESSADOS;

    $oBalancoOrcamentario->setExibirQuadros($aQuadros);

    $oRetornoBO = $oBalancoOrcamentario->getDados();


    /** BODCASP102017
     *  Quadro principal do relatório
     */

    $aFasesReceitaOrcamentaria = array(
      1 => 'previni',
      2 => 'prevatu',
      3 => 'recrealiza'
    );

    foreach ($aFasesReceitaOrcamentaria as $iValorNumerico => $sChave) {

      $clbodcasp10 = new cl_bodcasp102017();

      // $clbodcasp10 = new stdClass();
      $clbodcasp10->si201_ano                   = $iAnoUsu;
      $clbodcasp10->si201_periodo               = $iCodigoPeriodo;
      $clbodcasp10->si201_institu               = $sListaInstituicoes;
      $clbodcasp10->si201_tiporegistro          = 10;
      $clbodcasp10->si201_faserecorcamentaria   = $iValorNumerico;
      $clbodcasp10->si201_vlrectributaria       = $oRetornoBO[2]->$sChave;
      $clbodcasp10->si201_vlreccontribuicoes    = $oRetornoBO[3]->$sChave;
      $clbodcasp10->si201_vlrecpatrimonial      = $oRetornoBO[4]->$sChave;
      $clbodcasp10->si201_vlrecagropecuaria     = $oRetornoBO[5]->$sChave;
      $clbodcasp10->si201_vlrecindustrial       = $oRetornoBO[6]->$sChave;
      $clbodcasp10->si201_vlrecservicos         = $oRetornoBO[7]->$sChave;
      $clbodcasp10->si201_vltransfcorrentes     = $oRetornoBO[8]->$sChave;
      $clbodcasp10->si201_vloutrasreccorrentes  = $oRetornoBO[9]->$sChave;
      $clbodcasp10->si201_vloperacoescredito    = $oRetornoBO[11]->$sChave;
      $clbodcasp10->si201_vlalienacaobens       = $oRetornoBO[12]->$sChave;
      $clbodcasp10->si201_vlamortemprestimo     = $oRetornoBO[13]->$sChave;
      $clbodcasp10->si201_vltransfcapital       = $oRetornoBO[14]->$sChave;
      $clbodcasp10->si201_vloutrasreccapital    = $oRetornoBO[15]->$sChave;
      $clbodcasp10->si201_vlrecarrecadaxeant    = $oRetornoBO[16]->$sChave;
      $clbodcasp10->si201_vlopcredrefintermob   = $oRetornoBO[20]->$sChave;
      $clbodcasp10->si201_vlopcredrefintcontrat = $oRetornoBO[21]->$sChave;
      $clbodcasp10->si201_vlopcredrefextmob     = $oRetornoBO[23]->$sChave;
      $clbodcasp10->si201_vlopcredrefextcontrat = $oRetornoBO[24]->$sChave;
      $clbodcasp10->si201_vldeficit             = $oRetornoBO[26]->$sChave;
      $clbodcasp10->si201_vltotalquadroreceita  = $oRetornoBO[27]->$sChave;

      $clbodcasp10->incluir(null);
      if ($clbodcasp10->erro_status == 0) {
        throw new Exception($clbodcasp10->erro_msg);
      }

    } // Registo 10



    /** BODCASP402017
     *  Quadro da Execução de Restos a Pagar Não Processados
     */

    $faseRestosPagarNaoProcessados = array(
      1 => 'exanterior',
      2 => 'exanterior3112',
      3 => 'liquidados',
      4 => 'pagos',
      5 => 'cancelados'
    );

    foreach ($faseRestosPagarNaoProcessados as $iValorNumerico => $sChave) {

      $clbodcasp40  = new cl_bodcasp402017();

      $clbodcasp40->si204_ano                             = $iAnoUsu;
      $clbodcasp40->si204_periodo                         = $iCodigoPeriodo;
      $clbodcasp40->si204_institu                         = $sListaInstituicoes;
      $clbodcasp40->si204_tiporegistro                    = 40;
      $clbodcasp40->si204_faserestospagarnaoproc          = $iValorNumerico;
      $clbodcasp40->si204_vlrspnaoprocpessoalencarsociais = $oRetornoBO[53]->$sChave;
      $clbodcasp40->si204_vlrspnaoprocjurosencardividas   = $oRetornoBO[54]->$sChave;
      $clbodcasp40->si204_vlrspnaoprocoutrasdespcorrentes = $oRetornoBO[55]->$sChave;
      $clbodcasp40->si204_vlrspnaoprocinvestimentos       = $oRetornoBO[57]->$sChave;
      $clbodcasp40->si204_vlrspnaoprocinverfinanceira     = $oRetornoBO[58]->$sChave;
      $clbodcasp40->si204_vlrspnaoprocamortizadivida      = $oRetornoBO[59]->$sChave;
      $clbodcasp40->si204_vltotalexecurspnaoprocessado    = $oRetornoBO[60]->$sChave;

      $clbodcasp40->incluir(null);
      if ($clbodcasp40->erro_status == 0) {
        throw new Exception($clbodcasp40->erro_msg);
      }

    } // $rsResult40



    /** BODCASP502017
     *  Quadro da Execução de Restos a Pagar Processados e não Processados Liquidados
     */

    $RestosPagarProcessadosNaoProcessadosLiquidados = array(
      1 => 'exanterior',
      2 => 'exanterior3112',
      4 => 'pagos',
      5 => 'cancelados'
    );

    foreach ($RestosPagarProcessadosNaoProcessadosLiquidados as $iValorNumerico => $sChave) {

      $clbodcasp50  = new cl_bodcasp502017();

      $clbodcasp50->si205_ano                             = $iAnoUsu;
      $clbodcasp50->si205_periodo                         = $iCodigoPeriodo;
      $clbodcasp50->si205_institu                         = $sListaInstituicoes;
      $clbodcasp50->si205_tiporegistro                    = 50;
      $clbodcasp50->si205_faserestospagarprocnaoliqui     = $iValorNumerico;
      $clbodcasp50->si205_vlrspprocliqpessoalencarsoc     = $oRetornoBO[62]->$sChave;
      $clbodcasp50->si205_vlrspprocliqjurosencardiv       = $oRetornoBO[63]->$sChave;
      $clbodcasp50->si205_vlrspprocliqoutrasdespcorrentes = $oRetornoBO[64]->$sChave;
      $clbodcasp50->si205_vlrspprocesliqinv               = $oRetornoBO[66]->$sChave;
      $clbodcasp50->si205_vlrspprocliqinverfinan          = $oRetornoBO[67]->$sChave;
      $clbodcasp50->si205_vlrspprocliqamortizadivida      = $oRetornoBO[68]->$sChave;
      $clbodcasp50->si205_vltotalexecrspprocnaoproceli    = $oRetornoBO[69]->$sChave;

      $clbodcasp50->incluir(null);
      if ($clbodcasp50->erro_status == 0) {
        throw new Exception($clbodcasp50->erro_msg);
      }

    } // $rsResult50


    db_fim_transacao();

    $oGerarBO = new GerarBO();
    $oGerarBO->iAno = $iAnoUsu;
    $oGerarBO->iPeriodo = $iCodigoPeriodo;
    $oGerarBO->gerarDados();

  }

}
