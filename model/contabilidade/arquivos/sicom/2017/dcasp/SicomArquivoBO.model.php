<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

require_once("classes/db_bodcasp102017_classe.php");
require_once("classes/db_bodcasp202017_classe.php");
require_once("classes/db_bodcasp302017_classe.php");
require_once("classes/db_bodcasp402017_classe.php");
require_once("classes/db_bodcasp502017_classe.php");

require_once("model/contabilidade/arquivos/sicom/2017/dcasp/geradores/GerarBO.model.php");

/**
 * gerar arquivo de Balanço Orçamentário
 * @author gabriel
 * @package Contabilidade
 */
class SicomArquivoBalancoOrcamentario extends SicomArquivoBase implements iPadArquivoBaseCSV
{


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

    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $clbodcasp10 = new cl_bodcasp102017();
    $clbodcasp20 = new cl_bodcasp202017();
    $clbodcasp30 = new cl_bodcasp302017();
    $clbodcasp40 = new cl_bodcasp402017();
    $clbodcasp50 = new cl_bodcasp502017();


    /**
     * excluir informacoes caso estejam repetidas
     */
    db_inicio_transacao();

    /** BODCASP10 */
    $sSQL   = $clbodcasp10->sql_query(); // configurar os parâmetros corretos
    $result = $clbodcasp10->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbodcasp10->excluir(null, ""); // configurar o WHERE correto
      if ($clbodcasp10->erro_status == 0) {
        throw new Exception($clbodcasp10->erro_msg);
      }
    }

    /** BODCASP20 */
    $sSQL   = $clbodcasp20->sql_query(); // configurar os parâmetros corretos
    $result = $clbodcasp20->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbodcasp20->excluir(null, ""); // configurar o WHERE correto
      if ($clbodcasp20->erro_status == 0) {
        throw new Exception($clbodcasp20->erro_msg);
      }
    }

    /** BODCASP30 */
    $sSQL   = $clbodcasp30->sql_query(); // configurar os parâmetros corretos
    $result = $clbodcasp30->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbodcasp30->excluir(null, ""); // configurar o WHERE correto
      if ($clbodcasp30->erro_status == 0) {
        throw new Exception($clbodcasp30->erro_msg);
      }
    }

    /** BODCASP40 */
    $sSQL   = $clbodcasp40->sql_query(); // configurar os parâmetros corretos
    $result = $clbodcasp40->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbodcasp40->excluir(null, ""); // configurar o WHERE correto
      if ($clbodcasp40->erro_status == 0) {
        throw new Exception($clbodcasp40->erro_msg);
      }
    }

    /** BODCASP50 */
    $sSQL   = $clbodcasp50->sql_query(); // configurar os parâmetros corretos
    $result = $clbodcasp50->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbodcasp50->excluir(null, ""); // configurar o WHERE correto
      if ($clbodcasp50->erro_status == 0) {
        throw new Exception($clbodcasp50->erro_msg);
      }
    }

    /*------------------------------------------------------------------------*/


    /** BODCASP102017 */
    $sSQL = " SELECT * "
          . " FROM bodcasp102017 "
          . " WHERE 1 = 1 ";

    $rsResult10 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult10); $iCont++) {

      $oDadosBO10   = db_utils::fieldsMemory($rsResult10, $iCont);
      $clbodcasp10  = new cl_bodcasp102017();

      $clbodcasp10->si201_tiporegistro          = 10;
      $clbodcasp10->si201_faserecorcamentaria   = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vlrectributaria       = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vlreccontribuicoes    = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vlrecpatrimonial      = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vlrecagropecuaria     = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vlrecindustrial       = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vlrecservicos         = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vltransfcorrentes     = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vloutrasreccorrentes  = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vloperacoescredito    = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vlalienacaobens       = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vlamortemprestimo     = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vltransfcapital       = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vloutrasreccapital    = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vlrecarrecadaxeant    = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vlopcredrefintermob   = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vlopcredrefintcontrat = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vlopcredrefextmob     = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vlopcredrefextcontrat = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vldeficit             = $oDadosBO10->__algumAtributo;
      $clbodcasp10->si201_vltotalquadroreceita  = $oDadosBO10->__algumAtributo;

      $clbodcasp10->incluir(null);
      if ($clbodcasp10->erro_status == 0) {
        throw new Exception($clbodcasp10->erro_msg);
      }

    } // $rsResult10



    /** BODCASP202017 */
    $sSQL = " SELECT * "
          . " FROM bodcasp202017 "
          . " WHERE 1 = 1 ";

    $rsResult20 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult20); $iCont++) {

      $oDadosBO20   = db_utils::fieldsMemory($rsResult20, $iCont);
      $clbodcasp20  = new cl_bodcasp202017();

      $clbodcasp20->si202_tiporegistro          = 20;
      $clbodcasp20->si202_faserecorcamentaria   = $oDadosBO20->__algumAtributo;
      $clbodcasp20->si202_vlsaldoexeantsupfin   = $oDadosBO20->__algumAtributo;
      $clbodcasp20->si202_vlsaldoexeantrecredad = $oDadosBO20->__algumAtributo;
      $clbodcasp20->si202_vltotalsaldoexeant    = $oDadosBO20->__algumAtributo;

      $clbodcasp20->incluir(null);
      if ($clbodcasp20->erro_status == 0) {
        throw new Exception($clbodcasp20->erro_msg);
      }

    } // $rsResult20



    /** BODCASP302017 */
    $sSQL = " SELECT * "
          . " FROM bodcasp302017 "
          . " WHERE 1 = 1 ";

    $rsResult30 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult30); $iCont++) {

      $oDadosBO30   = db_utils::fieldsMemory($rsResult30, $iCont);
      $clbodcasp30  = new cl_bodcasp302017();

      $clbodcasp30->si203_tiporegistro              = 30;
      $clbodcasp30->si203_fasedespesaorca           = $oDadosBO30->__algumAtributo;
      $clbodcasp30->si203_vlpessoalencarsoci        = $oDadosBO30->__algumAtributo;
      $clbodcasp30->si203_vljurosencardividas       = $oDadosBO30->__algumAtributo;
      $clbodcasp30->si203_vloutrasdespcorren        = $oDadosBO30->__algumAtributo;
      $clbodcasp30->si203_vlinvestimentos           = $oDadosBO30->__algumAtributo;
      $clbodcasp30->si203_vlinverfinanceira         = $oDadosBO30->__algumAtributo;
      $clbodcasp30->si203_vlamortizadivida          = $oDadosBO30->__algumAtributo;
      $clbodcasp30->si203_vlreservacontingen        = $oDadosBO30->__algumAtributo;
      $clbodcasp30->si203_vlreservarpps             = $oDadosBO30->__algumAtributo;
      $clbodcasp30->si203_vlamortizadiviintermob    = $oDadosBO30->__algumAtributo;
      $clbodcasp30->si203_vlamortizaoutrasdivinter  = $oDadosBO30->__algumAtributo;
      $clbodcasp30->si203_vlamortizadivextmob       = $oDadosBO30->__algumAtributo;
      $clbodcasp30->si203_vlamortizaoutrasdivext    = $oDadosBO30->__algumAtributo;
      $clbodcasp30->si203_vlsuperavit               = $oDadosBO30->__algumAtributo;
      $clbodcasp30->si203_vltotalquadrodespesa      = $oDadosBO30->__algumAtributo;

      $clbodcasp30->incluir(null);
      if ($clbodcasp30->erro_status == 0) {
        throw new Exception($clbodcasp30->erro_msg);
      }

    } // $rsResult30



    /** BODCASP402017 */
    $sSQL = " SELECT * "
          . " FROM bodcasp402017 "
          . " WHERE 1 = 1 ";

    $rsResult40 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult40); $iCont++) {

      $oDadosBO40   = db_utils::fieldsMemory($rsResult40, $iCont);
      $clbodcasp40  = new cl_bodcasp402017();

      $clbodcasp40->si204_tiporegistro                    = 40;
      $clbodcasp40->si204_faserestospagarnaoproc          = $oDadosBO40->__algumAtributo;
      $clbodcasp40->si204_vlrspnaoprocpessoalencarsociais = $oDadosBO40->__algumAtributo;
      $clbodcasp40->si204_vlrspnaoprocjurosencardividas   = $oDadosBO40->__algumAtributo;
      $clbodcasp40->si204_vlrspnaoprocoutrasdespcorrentes = $oDadosBO40->__algumAtributo;
      $clbodcasp40->si204_vlrspnaoprocinvestimentos       = $oDadosBO40->__algumAtributo;
      $clbodcasp40->si204_vlrspnaoprocinverfinanceira     = $oDadosBO40->__algumAtributo;
      $clbodcasp40->si204_vlrspnaoprocamortizadivida      = $oDadosBO40->__algumAtributo;
      $clbodcasp40->si204_vltotalexecurspnaoprocessado    = $oDadosBO40->__algumAtributo;

      $clbodcasp40->incluir(null);
      if ($clbodcasp40->erro_status == 0) {
        throw new Exception($clbodcasp40->erro_msg);
      }

    } // $rsResult40



    /** BODCASP502017 */
    $sSQL = " SELECT * "
          . " FROM bodcasp502017 "
          . " WHERE 1 = 1 ";

    $rsResult50 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult50); $iCont++) {

      $oDadosBO50   = db_utils::fieldsMemory($rsResult50, $iCont);
      $clbodcasp50  = new cl_bodcasp502017();

      $clbodcasp50->si205_tiporegistro                    = 50;
      $clbodcasp50->si205_faserestospagarprocnaoliqui     = $oDadosBO50->__algumAtributo;
      $clbodcasp50->si205_vlrspprocliqpessoalencarsoc     = $oDadosBO50->__algumAtributo;
      $clbodcasp50->si205_vlrspprocliqjurosencardiv       = $oDadosBO50->__algumAtributo;
      $clbodcasp50->si205_vlrspprocliqoutrasdespcorrentes = $oDadosBO50->__algumAtributo;
      $clbodcasp50->si205_vlrspprocesliqinv               = $oDadosBO50->__algumAtributo;
      $clbodcasp50->si205_vlrspprocliqinverfinan          = $oDadosBO50->__algumAtributo;
      $clbodcasp50->si205_vlrspprocliqamortizadivida      = $oDadosBO50->__algumAtributo;
      $clbodcasp50->si205_vltotalexecrspprocnaoproceli    = $oDadosBO50->__algumAtributo;

      $clbodcasp50->incluir(null);
      if ($clbodcasp50->erro_status == 0) {
        throw new Exception($clbodcasp50->erro_msg);
      }

    } // $rsResult50


    db_fim_transacao();

    $oGerarBO = new GerarBO();
    $oGerarBO->gerarDados();

  }

}
