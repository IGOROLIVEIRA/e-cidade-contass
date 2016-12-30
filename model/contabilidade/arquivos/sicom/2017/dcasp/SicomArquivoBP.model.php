<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

require_once("classes/db_bpdcasp102017_classe.php");
require_once("classes/db_bpdcasp202017_classe.php");
require_once("classes/db_bpdcasp302017_classe.php");
require_once("classes/db_bpdcasp402017_classe.php");
require_once("classes/db_bpdcasp502017_classe.php");
require_once("classes/db_bpdcasp602017_classe.php");
require_once("classes/db_bpdcasp702017_classe.php");
require_once("classes/db_bpdcasp712017_classe.php");

require_once("model/contabilidade/arquivos/sicom/2017/dcasp/geradores/GerarBP.model.php");

/**
 * gerar arquivo de Balanço Patrimonial
 * @author gabriel
 * @package Contabilidade
 */
class SicomArquivoBalancoPatrimonial extends SicomArquivoBase implements iPadArquivoBaseCSV
{


  /**
   * Contrutor da classe
   */
  public function __construct() { }

  /**
   * selecionar os dados do balanço patrimonial pra gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {

    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $clbpdcasp10 = new cl_bpdcasp102017();
    $clbpdcasp20 = new cl_bpdcasp202017();
    $clbpdcasp30 = new cl_bpdcasp302017();
    $clbpdcasp40 = new cl_bpdcasp402017();
    $clbpdcasp50 = new cl_bpdcasp502017();
    $clbpdcasp60 = new cl_bpdcasp602017();
    $clbpdcasp70 = new cl_bpdcasp702017();
    $clbpdcasp71 = new cl_bpdcasp712017();

    /**
     * excluir informacoes caso estejam repetidas
     */
    db_inicio_transacao();

    /** BPDCASP10 */
    $sSQL   = $clbpdcasp10->sql_query(); // configurar os parâmetros corretos
    $result = $clbpdcasp10->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbpdcasp10->excluir(null, ""); // configurar o WHERE correto
      if ($clbpdcasp10->erro_status == 0) {
        throw new Exception($clbpdcasp10->erro_msg);
      }
    }

    /** BPDCASP20 */
    $sSQL   = $clbpdcasp20->sql_query(); // configurar os parâmetros corretos
    $result = $clbpdcasp20->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbpdcasp20->excluir(null, ""); // configurar o WHERE correto
      if ($clbpdcasp20->erro_status == 0) {
        throw new Exception($clbpdcasp20->erro_msg);
      }
    }

    /** BPDCASP30 */
    $sSQL   = $clbpdcasp30->sql_query(); // configurar os parâmetros corretos
    $result = $clbpdcasp30->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbpdcasp30->excluir(null, ""); // configurar o WHERE correto
      if ($clbpdcasp30->erro_status == 0) {
        throw new Exception($clbpdcasp30->erro_msg);
      }
    }

    /** BPDCASP40 */
    $sSQL   = $clbpdcasp40->sql_query(); // configurar os parâmetros corretos
    $result = $clbpdcasp40->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbpdcasp40->excluir(null, ""); // configurar o WHERE correto
      if ($clbpdcasp40->erro_status == 0) {
        throw new Exception($clbpdcasp40->erro_msg);
      }
    }

    /** BPDCASP50 */
    $sSQL   = $clbpdcasp50->sql_query(); // configurar os parâmetros corretos
    $result = $clbpdcasp50->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbpdcasp50->excluir(null, ""); // configurar o WHERE correto
      if ($clbpdcasp50->erro_status == 0) {
        throw new Exception($clbpdcasp50->erro_msg);
      }
    }

    /** BPDCASP60 */
    $sSQL   = $clbpdcasp60->sql_query(); // configurar os parâmetros corretos
    $result = $clbpdcasp60->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbpdcasp60->excluir(null, ""); // configurar o WHERE correto
      if ($clbpdcasp60->erro_status == 0) {
        throw new Exception($clbpdcasp60->erro_msg);
      }
    }

    /** BPDCASP70 */
    $sSQL   = $clbpdcasp70->sql_query(); // configurar os parâmetros corretos
    $result = $clbpdcasp70->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbpdcasp70->excluir(null, ""); // configurar o WHERE correto
      if ($clbpdcasp70->erro_status == 0) {
        throw new Exception($clbpdcasp70->erro_msg);
      }
    }

    /** BPDCASP71 */
    $sSQL   = $clbpdcasp71->sql_query(); // configurar os parâmetros corretos
    $result = $clbpdcasp71->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbpdcasp71->excluir(null, ""); // configurar o WHERE correto
      if ($clbpdcasp71->erro_status == 0) {
        throw new Exception($clbpdcasp71->erro_msg);
      }
    }

    /*------------------------------------------------------------------------*/


    /** BPDCASP102017 */
    $sSQL = " SELECT * "
          . " FROM bpdcasp102017 "
          . " WHERE 1 = 1 ";

    $rsResult10 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult10); $iCont++) {

      $oDadosBP10   = db_utils::fieldsMemory($rsResult10, $iCont);
      $clbpdcasp10  = new cl_bpdcasp102017();

      $clbpdcasp10->si208_tiporegistro                      = 10;
      $clbpdcasp10->si208_exercicio                         = $oDadosBP10->__algumAtributo;
      $clbpdcasp10->si208_vlativocircucaixaequicaixa        = $oDadosBP10->__algumAtributo;
      $clbpdcasp10->si208_vlativocircucredicurtoprazo       = $oDadosBP10->__algumAtributo;
      $clbpdcasp10->si208_vlativocircuinvestapliccurtoprazo = $oDadosBP10->__algumAtributo;
      $clbpdcasp10->si208_vlativocircuestoques              = $oDadosBP10->__algumAtributo;
      $clbpdcasp10->si208_vlativocircuvpdantecipada         = $oDadosBP10->__algumAtributo;
      $clbpdcasp10->si208_vlativonaocircucredilongoprazo    = $oDadosBP10->__algumAtributo;
      $clbpdcasp10->si208_vlativonaocircuinvestemplongpraz  = $oDadosBP10->__algumAtributo;
      $clbpdcasp10->si208_vlativonaocircuestoques           = $oDadosBP10->__algumAtributo;
      $clbpdcasp10->si208_vlativonaocircuvpdantecipada      = $oDadosBP10->__algumAtributo;
      $clbpdcasp10->si208_vlativonaocircuinvestimentos      = $oDadosBP10->__algumAtributo;
      $clbpdcasp10->si208_vlativonaocircuimobilizado        = $oDadosBP10->__algumAtributo;
      $clbpdcasp10->si208_vlativonaocircuintagivel          = $oDadosBP10->__algumAtributo;
      $clbpdcasp10->si208_vltotalativo                      = $oDadosBP10->__algumAtributo;

      $clbpdcasp10->incluir(null);
      if ($clbpdcasp10->erro_status == 0) {
        throw new Exception($clbpdcasp10->erro_msg);
      }

    } // $rsResult10


    /** BPDCASP202017 */
    $sSQL = " SELECT * "
          . " FROM bpdcasp202017 "
          . " WHERE 1 = 1 ";

    $rsResult20 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult20); $iCont++) {

      $oDadosBP20   = db_utils::fieldsMemory($rsResult20, $iCont);
      $clbpdcasp20  = new cl_bpdcasp202017();

      $clbpdcasp20->si209_tiporegistro                        = 20;
      $clbpdcasp20->si209_exercicio                           = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpassivcircultrabprevicurtoprazo   = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpassivcirculemprefinancurtoprazo  = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpassivocirculafornecedcurtoprazo  = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpassicircuobrigfiscacurtoprazo    = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpassivocirculaobrigacoutrosentes  = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpassivocirculaprovisoecurtoprazo  = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpassicircudemaiobrigcurtoprazo    = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpassinaocircutrabprevilongoprazo  = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpassnaocircemprfinalongpraz       = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpassivnaocirculforneclongoprazo   = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpassnaocircobrifisclongpraz       = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpassivnaocirculprovislongoprazo   = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpassnaocircdemaobrilongpraz       = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpassivonaocircularesuldiferido    = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpatriliquidocapitalsocial         = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpatriliquidoadianfuturocapital    = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpatriliquidoreservacapital        = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpatriliquidoajustavaliacao        = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpatriliquidoreservalucros         = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpatriliquidodemaisreservas        = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpatriliquidoresultexercicio       = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpatriliquidresultacumexeranteri   = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vlpatriliquidoacoescotas            = $oDadosBP20->__algumAtributo;
      $clbpdcasp20->si209_vltotalpassivo                      = $oDadosBP20->__algumAtributo;

      $clbpdcasp20->incluir(null);
      if ($clbpdcasp20->erro_status == 0) {
        throw new Exception($clbpdcasp20->erro_msg);
      }

    } // $rsResult20


    /** BPDCASP302017 */
    $sSQL = " SELECT * "
          . " FROM bpdcasp302017 "
          . " WHERE 1 = 1 ";

    $rsResult30 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult30); $iCont++) {

      $oDadosBP30   = db_utils::fieldsMemory($rsResult30, $iCont);
      $clbpdcasp30  = new cl_bpdcasp302017();

      $clbpdcasp30->  = $oDadosBP30->__algumAtributo;

      $clbpdcasp30->si210_tiporegistro                      = 30;
      $clbpdcasp30->si210_exercicio                         = $oDadosBP30->__algumAtributo;
      $clbpdcasp30->si210_vlativofinanceiro                 = $oDadosBP30->__algumAtributo;
      $clbpdcasp30->si210_vlativopermanente                 = $oDadosBP30->__algumAtributo;
      $clbpdcasp30->si210_vltotalativofinanceiropermanente  = $oDadosBP30->__algumAtributo;

      $clbpdcasp30->incluir(null);
      if ($clbpdcasp30->erro_status == 0) {
        throw new Exception($clbpdcasp30->erro_msg);
      }

    } // $rsResult30


    /** BPDCASP402017 */
    $sSQL = " SELECT * "
          . " FROM bpdcasp402017 "
          . " WHERE 1 = 1 ";

    $rsResult40 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult40); $iCont++) {

      $oDadosBP40   = db_utils::fieldsMemory($rsResult40, $iCont);
      $clbpdcasp40  = new cl_bpdcasp402017();

      $clbpdcasp40->si211_tiporegistro                        = 40;
      $clbpdcasp40->si211_exercicio                           = $oDadosBP40->__algumAtributo;
      $clbpdcasp40->si211_vlpassivofinanceiro                 = $oDadosBP40->__algumAtributo;
      $clbpdcasp40->si211_vlpassivopermanente                 = $oDadosBP40->__algumAtributo;
      $clbpdcasp40->si211_vltotalpassivofinanceiropermanente  = $oDadosBP40->__algumAtributo;

      $clbpdcasp40->incluir(null);
      if ($clbpdcasp40->erro_status == 0) {
        throw new Exception($clbpdcasp40->erro_msg);
      }

    } // $rsResult40


    /** BPDCASP502017 */
    $sSQL = " SELECT * "
          . " FROM bpdcasp502017 "
          . " WHERE 1 = 1 ";

    $rsResult50 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult50); $iCont++) {

      $oDadosBP50   = db_utils::fieldsMemory($rsResult50, $iCont);
      $clbpdcasp50  = new cl_bpdcasp502017();

      $clbpdcasp50->si212_tiporegistro        = 50;
      $clbpdcasp50->si212_exercicio           = $oDadosBP50->__algumAtributo;
      $clbpdcasp50->si212_vlsaldopatrimonial  = $oDadosBP50->__algumAtributo;

      $clbpdcasp50->incluir(null);
      if ($clbpdcasp50->erro_status == 0) {
        throw new Exception($clbpdcasp50->erro_msg);
      }

    } // $rsResult50


    /** BPDCASP602017 */
    $sSQL = " SELECT * "
          . " FROM bpdcasp602017 "
          . " WHERE 1 = 1 ";

    $rsResult60 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult60); $iCont++) {

      $oDadosBP60   = db_utils::fieldsMemory($rsResult60, $iCont);
      $clbpdcasp60  = new cl_bpdcasp602017();

      $clbpdcasp60->si213_tiporegistro                        = 60;
      $clbpdcasp60->si213_exercicio                           = $oDadosBP60->__algumAtributo;
      $clbpdcasp60->si213_vlatospotenativosgarancontrarecebi  = $oDadosBP60->__algumAtributo;
      $clbpdcasp60->si213_vlatospotenativodirconveoutroinstr  = $oDadosBP60->__algumAtributo;
      $clbpdcasp60->si213_vlatospotenativosdireitoscontratua  = $oDadosBP60->__algumAtributo;
      $clbpdcasp60->si213_vlatospotenativosoutrosatos         = $oDadosBP60->__algumAtributo;
      $clbpdcasp60->si213_vlatospotenpassivgarancontraconced  = $oDadosBP60->__algumAtributo;
      $clbpdcasp60->si213_vlatospotepassobriconvoutrinst      = $oDadosBP60->__algumAtributo;
      $clbpdcasp60->si213_vlatospotenpassivoobrigacocontratu  = $oDadosBP60->__algumAtributo;
      $clbpdcasp60->si213_vlatospotenpassivooutrosatos        = $oDadosBP60->__algumAtributo;

      $clbpdcasp60->incluir(null);
      if ($clbpdcasp60->erro_status == 0) {
        throw new Exception($clbpdcasp60->erro_msg);
      }

    } // $rsResult60


    /** BPDCASP702017 */
    $sSQL = " SELECT * "
          . " FROM bpdcasp702017 "
          . " WHERE 1 = 1 ";

    $rsResult70 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult70); $iCont++) {

      $oDadosBP70   = db_utils::fieldsMemory($rsResult70, $iCont);
      $clbpdcasp70  = new cl_bpdcasp702017();

      $clbpdcasp70->si214_tiporegistro  = 70;
      $clbpdcasp70->si214_exercicio     = $oDadosBP70->__algumAtributo;
      $clbpdcasp70->si214_vltotalsupdef = $oDadosBP70->__algumAtributo;


      $clbpdcasp70->incluir(null);
      if ($clbpdcasp70->erro_status == 0) {
        throw new Exception($clbpdcasp70->erro_msg);
      }

    } // $rsResult70


    /** BPDCASP712017 */
    $sSQL = " SELECT * "
          . " FROM bpdcasp712017 "
          . " WHERE 1 = 1 ";

    $rsResult71 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult71); $iCont++) {

      $oDadosBP71   = db_utils::fieldsMemory($rsResult71, $iCont);
      $clbpdcasp71  = new cl_bpdcasp712017();

      $clbpdcasp71->si215_tiporegistro    = 71;
      $clbpdcasp71->si215_exercicio       = $oDadosBP71->__algumAtributo;
      $clbpdcasp71->si215_codfontrecursos = $oDadosBP71->__algumAtributo;
      $clbpdcasp71->si215_vlsaldofonte    = $oDadosBP71->__algumAtributo;

      $clbpdcasp71->incluir(null);
      if ($clbpdcasp71->erro_status == 0) {
        throw new Exception($clbpdcasp71->erro_msg);
      }

    } // $rsResult71


    db_fim_transacao();

    $oGerarBP = new GerarBP();
    $oGerarBP->gerarDados();

  }

}
