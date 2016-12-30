<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

require_once("classes/db_bfdcasp102017_classe.php");
require_once("classes/db_bfdcasp202017_classe.php");

require_once("model/contabilidade/arquivos/sicom/2017/dcasp/geradores/GerarBF.model.php");

/**
 * gerar arquivo de Balanço Financeiro
 * @author gabriel
 * @package Contabilidade
 */
class SicomArquivoBalancoFinanceiro extends SicomArquivoBase implements iPadArquivoBaseCSV
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
    $clbfdcasp10 = new cl_bfdcasp102017();
    $clbfdcasp20 = new cl_bfdcasp202017();


    /**
     * excluir informacoes caso estejam repetidas
     */
    db_inicio_transacao();

    /** BFDCASP10 */
    $sSQL   = $clbfdcasp10->sql_query(); // configurar os parâmetros corretos
    $result = $clbfdcasp10->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbfdcasp10->excluir(null, ""); // configurar o WHERE correto
      if ($clbfdcasp10->erro_status == 0) {
        throw new Exception($clbfdcasp10->erro_msg);
      }
    }

    /** BFDCASP20 */
    $sSQL   = $clbfdcasp20->sql_query(); // configurar os parâmetros corretos
    $result = $clbfdcasp20->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbfdcasp20->excluir(null, ""); // configurar o WHERE correto
      if ($clbfdcasp20->erro_status == 0) {
        throw new Exception($clbfdcasp20->erro_msg);
      }
    }

    /*------------------------------------------------------------------------*/


    /** BFDCASP102017 */
    $sSQL = " SELECT * "
          . " FROM bfdcasp102017 "
          . " WHERE 1 = 1 ";

    $rsResult10 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult10); $iCont++) {

      $oDadosBF10   = db_utils::fieldsMemory($rsResult10, $iCont);
      $clbfdcasp10  = new cl_bfdcasp102017();

      $clbfdcasp10->si206_tiporegistro                      = 10;
      $clbfdcasp10->si206_exercicio                         = $oDadosBF10->__algumAtributo;
      $clbfdcasp10->si206_vlrecorcamenrecurord              = $oDadosBF10->__algumAtributo;
      $clbfdcasp10->si206_vlrecorcamenrecinceduc            = $oDadosBF10->__algumAtributo;
      $clbfdcasp10->si206_vlrecorcamenrecurvincusaude       = $oDadosBF10->__algumAtributo;
      $clbfdcasp10->si206_vlrecorcamenrecurvincurpps        = $oDadosBF10->__algumAtributo;
      $clbfdcasp10->si206_vlrecorcamenrecurvincuassistsoc   = $oDadosBF10->__algumAtributo;
      $clbfdcasp10->si206_vlrecorcamenoutrasdestrecursos    = $oDadosBF10->__algumAtributo;
      $clbfdcasp10->si206_vltransfinanexecuorcamentaria     = $oDadosBF10->__algumAtributo;
      $clbfdcasp10->si206_vltransfinanindepenexecuorc       = $oDadosBF10->__algumAtributo;
      $clbfdcasp10->si206_vltransfinanreceaportesrpps       = $oDadosBF10->__algumAtributo;
      $clbfdcasp10->si206_vlincrirspnaoprocessado           = $oDadosBF10->__algumAtributo;
      $clbfdcasp10->si206_vlincrirspprocessado              = $oDadosBF10->__algumAtributo;
      $clbfdcasp10->si206_vldeporestituvinculados           = $oDadosBF10->__algumAtributo;
      $clbfdcasp10->si206_vloutrosrecextraorcamentario      = $oDadosBF10->__algumAtributo;
      $clbfdcasp10->si206_vlsaldoexeranteriorcaixaequicaixa = $oDadosBF10->__algumAtributo;
      $clbfdcasp10->si206_vlsaldoexerantdeporestvinc        = $oDadosBF10->__algumAtributo;
      $clbfdcasp10->si206_vltotalingresso                   = $oDadosBF10->__algumAtributo;

      $clbfdcasp10->incluir(null);
      if ($clbfdcasp10->erro_status == 0) {
        throw new Exception($clbfdcasp10->erro_msg);
      }

    } // $rsResult10


    /** BFDCASP202017 */
    $sSQL = " SELECT * "
          . " FROM bfdcasp202017 "
          . " WHERE 1 = 1 ";

    $rsResult20 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult20); $iCont++) {

      $oDadosBF20   = db_utils::fieldsMemory($rsResult20, $iCont);
      $clbfdcasp20  = new cl_bfdcasp202017();

      $clbfdcasp20->si207_tiporegistro                      = 20;
      $clbfdcasp20->si207_exercicio                         = $oDadosBF20->__algumAtributo;
      $clbfdcasp20->si207_vldesporcamenrecurordinarios      = $oDadosBF20->__algumAtributo;
      $clbfdcasp20->si207_vldesporcamenrecurvincueducacao   = $oDadosBF20->__algumAtributo;
      $clbfdcasp20->si207_vldesporcamenrecurvincusaude      = $oDadosBF20->__algumAtributo;
      $clbfdcasp20->si207_vldesporcamenrecurvincurpps       = $oDadosBF20->__algumAtributo;
      $clbfdcasp20->si207_vldesporcamenrecurvincuassistsoc  = $oDadosBF20->__algumAtributo;
      $clbfdcasp20->si207_vloutrasdesporcamendestrecursos   = $oDadosBF20->__algumAtributo;
      $clbfdcasp20->si207_vltransfinanconcexecorcamentaria  = $oDadosBF20->__algumAtributo;
      $clbfdcasp20->si207_vltransfinanconcindepenexecorc    = $oDadosBF20->__algumAtributo;
      $clbfdcasp20->si207_vltransfinanconcaportesrecurpps   = $oDadosBF20->__algumAtributo;
      $clbfdcasp20->si207_vlpagrspnaoprocessado             = $oDadosBF20->__algumAtributo;
      $clbfdcasp20->si207_vlpagrspprocessado                = $oDadosBF20->__algumAtributo;
      $clbfdcasp20->si207_vldeposrestvinculados             = $oDadosBF20->__algumAtributo;
      $clbfdcasp20->si207_vloutrospagextraorcamentarios     = $oDadosBF20->__algumAtributo;
      $clbfdcasp20->si207_vlsaldoexeratualcaixaequicaixa    = $oDadosBF20->__algumAtributo;
      $clbfdcasp20->si207_vlsaldoexeratualdeporestvinc      = $oDadosBF20->__algumAtributo;
      $clbfdcasp20->si207_vltotaldispendios                 = $oDadosBF20->__algumAtributo;

      $clbfdcasp20->incluir(null);
      if ($clbfdcasp20->erro_status == 0) {
        throw new Exception($clbfdcasp20->erro_msg);
      }

    } // $rsResult20


    db_fim_transacao();

    $oGerarBF = new GerarBF();
    $oGerarBF->gerarDados();

  }

}
