<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

require_once("classes/db_dfcdcasp102017_classe.php");
require_once("classes/db_dfcdcasp202017_classe.php");
require_once("classes/db_dfcdcasp302017_classe.php");
require_once("classes/db_dfcdcasp402017_classe.php");
require_once("classes/db_dfcdcasp502017_classe.php");
require_once("classes/db_dfcdcasp602017_classe.php");
require_once("classes/db_dfcdcasp702017_classe.php");
require_once("classes/db_dfcdcasp802017_classe.php");
require_once("classes/db_dfcdcasp902017_classe.php");
require_once("classes/db_dfcdcasp1002017_classe.php");
require_once("classes/db_dfcdcasp1102017_classe.php");

require_once("model/contabilidade/arquivos/sicom/2017/dcasp/geradores/GerarDFC.model.php");

/**
 * gerar arquivo de Demonstração dos Fluxos de Caixa
 * @author gabriel
 * @package Contabilidade
 */
class SicomArquivoDemonstracaoFluxosCaixa extends SicomArquivoBase implements iPadArquivoBaseCSV
{


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

    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $cldfcdcasp10   = new db_dfcdcasp102017();
    $cldfcdcasp20   = new db_dfcdcasp202017();
    $cldfcdcasp30   = new db_dfcdcasp302017();
    $cldfcdcasp40   = new db_dfcdcasp402017();
    $cldfcdcasp50   = new db_dfcdcasp502017();
    $cldfcdcasp60   = new db_dfcdcasp602017();
    $cldfcdcasp70   = new db_dfcdcasp702017();
    $cldfcdcasp80   = new db_dfcdcasp802017();
    $cldfcdcasp90   = new db_dfcdcasp902017();
    $cldfcdcasp100  = new db_dfcdcasp1002017();
    $cldfcdcasp110  = new db_dfcdcasp1102017();

    /**
     * excluir informacoes caso estejam repetidas
     */
    db_inicio_transacao();

    /** DFCDCASP10 */
    $sSQL   = $cldfcdcasp10->sql_query(); // configurar os parâmetros corretos
    $result = $cldfcdcasp10->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $cldfcdcasp10->excluir(null, ""); // configurar o WHERE correto
      if ($cldfcdcasp10->erro_status == 0) {
        throw new Exception($cldfcdcasp10->erro_msg);
      }
    }

    /** DFCDCASP20 */
    $sSQL   = $cldfcdcasp20->sql_query(); // configurar os parâmetros corretos
    $result = $cldfcdcasp20->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $cldfcdcasp20->excluir(null, ""); // configurar o WHERE correto
      if ($cldfcdcasp20->erro_status == 0) {
        throw new Exception($cldfcdcasp20->erro_msg);
      }
    }

    /** DFCDCASP30 */
    $sSQL   = $cldfcdcasp30->sql_query(); // configurar os parâmetros corretos
    $result = $cldfcdcasp30->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $cldfcdcasp30->excluir(null, ""); // configurar o WHERE correto
      if ($cldfcdcasp30->erro_status == 0) {
        throw new Exception($cldfcdcasp30->erro_msg);
      }
    }

    /** DFCDCASP40 */
    $sSQL   = $cldfcdcasp40->sql_query(); // configurar os parâmetros corretos
    $result = $cldfcdcasp40->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $cldfcdcasp40->excluir(null, ""); // configurar o WHERE correto
      if ($cldfcdcasp40->erro_status == 0) {
        throw new Exception($cldfcdcasp40->erro_msg);
      }
    }

    /** DFCDCASP50 */
    $sSQL   = $cldfcdcasp50->sql_query(); // configurar os parâmetros corretos
    $result = $cldfcdcasp50->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $cldfcdcasp50->excluir(null, ""); // configurar o WHERE correto
      if ($cldfcdcasp50->erro_status == 0) {
        throw new Exception($cldfcdcasp50->erro_msg);
      }
    }

    /** DFCDCASP60 */
    $sSQL   = $cldfcdcasp60->sql_query(); // configurar os parâmetros corretos
    $result = $cldfcdcasp60->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $cldfcdcasp60->excluir(null, ""); // configurar o WHERE correto
      if ($cldfcdcasp60->erro_status == 0) {
        throw new Exception($cldfcdcasp60->erro_msg);
      }
    }

    /** DFCDCASP70 */
    $sSQL   = $cldfcdcasp70->sql_query(); // configurar os parâmetros corretos
    $result = $cldfcdcasp70->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $cldfcdcasp70->excluir(null, ""); // configurar o WHERE correto
      if ($cldfcdcasp70->erro_status == 0) {
        throw new Exception($cldfcdcasp70->erro_msg);
      }
    }

    /** DFCDCASP80 */
    $sSQL   = $cldfcdcasp80->sql_query(); // configurar os parâmetros corretos
    $result = $cldfcdcasp80->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $cldfcdcasp80->excluir(null, ""); // configurar o WHERE correto
      if ($cldfcdcasp80->erro_status == 0) {
        throw new Exception($cldfcdcasp80->erro_msg);
      }
    }

    /** DFCDCASP90 */
    $sSQL   = $cldfcdcasp90->sql_query(); // configurar os parâmetros corretos
    $result = $cldfcdcasp90->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $cldfcdcasp90->excluir(null, ""); // configurar o WHERE correto
      if ($cldfcdcasp90->erro_status == 0) {
        throw new Exception($cldfcdcasp90->erro_msg);
      }
    }

    /** DFCDCASP100 */
    $sSQL   = $cldfcdcasp100->sql_query(); // configurar os parâmetros corretos
    $result = $cldfcdcasp100->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $cldfcdcasp100->excluir(null, ""); // configurar o WHERE correto
      if ($cldfcdcasp100->erro_status == 0) {
        throw new Exception($cldfcdcasp100->erro_msg);
      }
    }

    /** DFCDCASP110 */
    $sSQL   = $cldfcdcasp110->sql_query(); // configurar os parâmetros corretos
    $result = $cldfcdcasp110->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $cldfcdcasp110->excluir(null, ""); // configurar o WHERE correto
      if ($cldfcdcasp110->erro_status == 0) {
        throw new Exception($cldfcdcasp110->erro_msg);
      }
    }


    /*------------------------------------------------------------------------*/


    /** DFCDCASP102017 */
    $sSQL = " SELECT * "
          . " FROM dfcdcasp102017 "
          . " WHERE 1 = 1 ";

    $rsResult10 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult10); $iCont++) {

      $oDadosDFC10  = db_utils::fieldsMemory($rsResult10, $iCont);
      $cldfcdcasp10 = new cl_dfcdcasp102017();

      $cldfcdcasp10->si219_tiporegistro                     = 10;
      $cldfcdcasp10->si219_exercicio                        = $oDadosDFC10->__algumAtributo;
      $cldfcdcasp10->si219_vlreceitaderivadaoriginaria      = $oDadosDFC10->__algumAtributo;
      $cldfcdcasp10->si219_vltranscorrenterecebida          = $oDadosDFC10->__algumAtributo;
      $cldfcdcasp10->si219_vloutrosingressosoperacionais    = $oDadosDFC10->__algumAtributo;
      $cldfcdcasp10->si219_vltotalingressosativoperacionais = $oDadosDFC10->__algumAtributo;

      $cldfcdcasp10->incluir(null);
      if ($cldfcdcasp10->erro_status == 0) {
        throw new Exception($cldfcdcasp10->erro_msg);
      }

    } // $rsResult10


    /** DFCDCASP202017 */
    $sSQL = " SELECT * "
          . " FROM dfcdcasp202017 "
          . " WHERE 1 = 1 ";

    $rsResult20 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult20); $iCont++) {

      $oDadosDFC20  = db_utils::fieldsMemory($rsResult20, $iCont);
      $cldfcdcasp20 = new cl_dfcdcasp202017();

      $cldfcdcasp20->si220_tiporegistro                       = 20;
      $cldfcdcasp20->si220_exercicio                          = $oDadosDFC20->__algumAtributo;
      $cldfcdcasp20->si220_vldesembolsopessoaldespesas        = $oDadosDFC20->__algumAtributo;
      $cldfcdcasp20->si220_vldesembolsojurosencargdivida      = $oDadosDFC20->__algumAtributo;
      $cldfcdcasp20->si220_vldesembolsotransfconcedidas       = $oDadosDFC20->__algumAtributo;
      $cldfcdcasp20->si220_vloutrosdesembolsos                = $oDadosDFC20->__algumAtributo;
      $cldfcdcasp20->si220_vltotaldesembolsosativoperacionais = $oDadosDFC20->__algumAtributo;

      $cldfcdcasp20->incluir(null);
      if ($cldfcdcasp20->erro_status == 0) {
        throw new Exception($cldfcdcasp20->erro_msg);
      }

    } // $rsResult20


    /** DFCDCASP302017 */
    $sSQL = " SELECT * "
          . " FROM dfcdcasp302017 "
          . " WHERE 1 = 1 ";

    $rsResult30 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult30); $iCont++) {

      $oDadosDFC30  = db_utils::fieldsMemory($rsResult30, $iCont);
      $cldfcdcasp30 = new cl_dfcdcasp302017();

      $cldfcdcasp30->si221_tiporegistro                   = 30;
      $cldfcdcasp30->si221_exercicio                      = $oDadosDFC30->__algumAtributo;
      $cldfcdcasp30->si221_vlfluxocaixaliquidooperacional = $oDadosDFC30->__algumAtributo;

      $cldfcdcasp30->incluir(null);
      if ($cldfcdcasp30->erro_status == 0) {
        throw new Exception($cldfcdcasp30->erro_msg);
      }

    } // $rsResult30


    /** DFCDCASP402017 */
    $sSQL = " SELECT * "
          . " FROM dfcdcasp402017 "
          . " WHERE 1 = 1 ";

    $rsResult40 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult40); $iCont++) {

      $oDadosDFC40  = db_utils::fieldsMemory($rsResult40, $iCont);
      $cldfcdcasp40 = new cl_dfcdcasp402017();

      $cldfcdcasp40->si222_tiporegistro                       = 40;
      $cldfcdcasp40->si222_exercicio                          = $oDadosDFC40->__algumAtributo;
      $cldfcdcasp40->si222_vlalienacaobens                    = $oDadosDFC40->__algumAtributo;
      $cldfcdcasp40->si222_vlamortizacaoemprestimoconcedido   = $oDadosDFC40->__algumAtributo;
      $cldfcdcasp40->si222_vloutrosingressos                  = $oDadosDFC40->__algumAtributo;
      $cldfcdcasp40->si222_vltotalingressosatividainvestiment = $oDadosDFC40->__algumAtributo;

      $cldfcdcasp40->incluir(null);
      if ($cldfcdcasp40->erro_status == 0) {
        throw new Exception($cldfcdcasp40->erro_msg);
      }

    } // $rsResult40


    /** DFCDCASP502017 */
    $sSQL = " SELECT * "
          . " FROM dfcdcasp502017 "
          . " WHERE 1 = 1 ";

    $rsResult50 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult50); $iCont++) {

      $oDadosDFC50  = db_utils::fieldsMemory($rsResult50, $iCont);
      $cldfcdcasp50 = new cl_dfcdcasp502017();

      $cldfcdcasp50->si223_tiporegistro                       = 50;
      $cldfcdcasp50->si223_exercicio                          = $oDadosDFC50->__algumAtributo;
      $cldfcdcasp50->si223_vlaquisicaoativonaocirculante      = $oDadosDFC50->__algumAtributo;
      $cldfcdcasp50->si223_vlconcessaoempresfinanciamento     = $oDadosDFC50->__algumAtributo;
      $cldfcdcasp50->si223_vloutrosdesembolsos                = $oDadosDFC50->__algumAtributo;
      $cldfcdcasp50->si223_vltotaldesembolsoatividainvestimen = $oDadosDFC50->__algumAtributo;

      $cldfcdcasp50->incluir(null);
      if ($cldfcdcasp50->erro_status == 0) {
        throw new Exception($cldfcdcasp50->erro_msg);
      }

    } // $rsResult50


    /** DFCDCASP602017 */
    $sSQL = " SELECT * "
          . " FROM dfcdcasp602017 "
          . " WHERE 1 = 1 ";

    $rsResult60 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult60); $iCont++) {

      $oDadosDFC60  = db_utils::fieldsMemory($rsResult60, $iCont);
      $cldfcdcasp60 = new cl_dfcdcasp602017();

      $cldfcdcasp60->si224_tiporegistro                     = 60;
      $cldfcdcasp60->si224_exercicio                        = $oDadosDFC60->__algumAtributo;
      $cldfcdcasp60->si224_vlfluxocaixaliquidoinvestimento  = $oDadosDFC60->__algumAtributo;

      $cldfcdcasp60->incluir(null);
      if ($cldfcdcasp60->erro_status == 0) {
        throw new Exception($cldfcdcasp60->erro_msg);
      }

    } // $rsResult60


    /** DFCDCASP702017 */
    $sSQL = " SELECT * "
          . " FROM dfcdcasp702017 "
          . " WHERE 1 = 1 ";

    $rsResult70 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult70); $iCont++) {

      $oDadosDFC70  = db_utils::fieldsMemory($rsResult70, $iCont);
      $cldfcdcasp70 = new cl_dfcdcasp702017();

      $cldfcdcasp70->si225_tiporegistro                       = 70;
      $cldfcdcasp70->si225_exercicio                          = $oDadosDFC70->__algumAtributo;
      $cldfcdcasp70->si225_vloperacoescredito                 = $oDadosDFC70->__algumAtributo;
      $cldfcdcasp70->si225_vlintegralizacaodependentes        = $oDadosDFC70->__algumAtributo;
      $cldfcdcasp70->si225_vltranscapitalrecebida             = $oDadosDFC70->__algumAtributo;
      $cldfcdcasp70->si225_vloutrosingressosfinanciamento     = $oDadosDFC70->__algumAtributo;
      $cldfcdcasp70->si225_vltotalingressoatividafinanciament = $oDadosDFC70->__algumAtributo;

      $cldfcdcasp70->incluir(null);
      if ($cldfcdcasp70->erro_status == 0) {
        throw new Exception($cldfcdcasp70->erro_msg);
      }

    } // $rsResult70


    /** DFCDCASP802017 */
    $sSQL = " SELECT * "
          . " FROM dfcdcasp802017 "
          . " WHERE 1 = 1 ";

    $rsResult80 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult80); $iCont++) {

      $oDadosDFC80  = db_utils::fieldsMemory($rsResult80, $iCont);
      $cldfcdcasp80 = new cl_dfcdcasp802017();

      $cldfcdcasp80->si226_tiporegistro                       = 80;
      $cldfcdcasp80->si226_exercicio                          = $oDadosDFC80->__algumAtributo;
      $cldfcdcasp80->si226_vlamortizacaorefinanciamento       = $oDadosDFC80->__algumAtributo;
      $cldfcdcasp80->si226_vloutrosdesembolsosfinanciamento   = $oDadosDFC80->__algumAtributo;
      $cldfcdcasp80->si226_vltotaldesembolsoatividafinanciame = $oDadosDFC80->__algumAtributo;

      $cldfcdcasp80->incluir(null);
      if ($cldfcdcasp80->erro_status == 0) {
        throw new Exception($cldfcdcasp80->erro_msg);
      }

    } // $rsResult80


    /** DFCDCASP902017 */
    $sSQL = " SELECT * "
          . " FROM dfcdcasp902017 "
          . " WHERE 1 = 1 ";

    $rsResult90 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult90); $iCont++) {

      $oDadosDFC90  = db_utils::fieldsMemory($rsResult90, $iCont);
      $cldfcdcasp90 = new cl_dfcdcasp902017();

      $cldfcdcasp90->si227_tiporegistro               = 90;
      $cldfcdcasp90->si227_exercicio                  = $oDadosDFC90->__algumAtributo;
      $cldfcdcasp90->si227_vlfluxocaixafinanciamento  = $oDadosDFC90->__algumAtributo;

      $cldfcdcasp90->incluir(null);
      if ($cldfcdcasp90->erro_status == 0) {
        throw new Exception($cldfcdcasp90->erro_msg);
      }

    } // $rsResult90


    /** DFCDCASP1002017 */
    $sSQL = " SELECT * "
          . " FROM dfcdcasp1002017 "
          . " WHERE 1 = 1 ";

    $rsResult100 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult100); $iCont++) {

      $oDadosDFC100  = db_utils::fieldsMemory($rsResult100, $iCont);
      $cldfcdcasp100 = new cl_dfcdcasp1002017();

      $cldfcdcasp100->si228_tiporegistro                      = 100;
      $cldfcdcasp100->si228_exercicio                         = $oDadosDFC100->__algumAtributo;
      $cldfcdcasp100->si228_vlgeracaoliquidaequivalentecaixa  = $oDadosDFC100->__algumAtributo;

      $cldfcdcasp100->incluir(null);
      if ($cldfcdcasp100->erro_status == 0) {
        throw new Exception($cldfcdcasp100->erro_msg);
      }

    } // $rsResult100


    /** DFCDCASP1102017 */
    $sSQL = " SELECT * "
          . " FROM dfcdcasp1102017 "
          . " WHERE 1 = 1 ";

    $rsResult110 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult110); $iCont++) {

      $oDadosDFC110  = db_utils::fieldsMemory($rsResult110, $iCont);
      $cldfcdcasp110 = new cl_dfcdcasp1102017();

      $cldfcdcasp110->si229_tiporegistro                    = 110;
      $cldfcdcasp110->si229_exercicio                       = $oDadosDFC110->__algumAtributo;
      $cldfcdcasp110->si229_vlcaixaequivalentecaixainicial  = $oDadosDFC110->__algumAtributo;
      $cldfcdcasp110->si229_vlcaixaequivalentecaixafinal    = $oDadosDFC110->__algumAtributo;

      $cldfcdcasp110->incluir(null);
      if ($cldfcdcasp110->erro_status == 0) {
        throw new Exception($cldfcdcasp110->erro_msg);
      }

    } // $rsResult110



    db_fim_transacao();

    $oGerarDFC = new GerarDFC();
    $oGerarDFC->gerarDados();

  }

}
