<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

require_once("classes/db_dvpdcasp102017_classe.php");
require_once("classes/db_dvpdcasp202017_classe.php");
require_once("classes/db_dvpdcasp302017_classe.php");

require_once("model/contabilidade/arquivos/sicom/2017/dcasp/geradores/GerarDVP.model.php");

/**
 * gerar arquivo de Demonstração das Variações Patrimoniais
 * @author gabriel
 * @package Contabilidade
 */
class SicomArquivoDemonstracaoVariacoesPatrimoniais extends SicomArquivoBase implements iPadArquivoBaseCSV
{


  /**
   * Contrutor da classe
   */
  public function __construct() { }

  /**
   * selecionar os dados das demonstração das variações patrimoniais pra gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {

    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $cldvpdcasp10 = new cl_dvpdcasp102017();
    $cldvpdcasp20 = new cl_dvpdcasp202017();
    $cldvpdcasp30 = new cl_dvpdcasp302017();

    /**
     * excluir informacoes caso estejam repetidas
     */
    db_inicio_transacao();

    /** DVPDCASP10 */
    $sSQL   = $cldvpdcasp10->sql_query(); // configurar os parâmetros corretos
    $result = $cldvpdcasp10->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $cldvpdcasp10->excluir(null, ""); // configurar o WHERE correto
      if ($cldvpdcasp10->erro_status == 0) {
        throw new Exception($cldvpdcasp10->erro_msg);
      }
    }

    /** DVPDCASP20 */
    $sSQL   = $cldvpdcasp20->sql_query(); // configurar os parâmetros corretos
    $result = $cldvpdcasp20->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $cldvpdcasp20->excluir(null, ""); // configurar o WHERE correto
      if ($cldvpdcasp20->erro_status == 0) {
        throw new Exception($cldvpdcasp20->erro_msg);
      }
    }

    /** DVPDCASP30 */
    $sSQL   = $cldvpdcasp30->sql_query(); // configurar os parâmetros corretos
    $result = $cldvpdcasp30->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $cldvpdcasp30->excluir(null, ""); // configurar o WHERE correto
      if ($cldvpdcasp30->erro_status == 0) {
        throw new Exception($cldvpdcasp30->erro_msg);
      }
    }


    /*------------------------------------------------------------------------*/


    /** DVPDCASP102017 */
    $sSQL = " SELECT * "
          . " FROM dvpdcasp102017 "
          . " WHERE 1 = 1 ";

    $rsResult10 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult10); $iCont++) {

      $oDadosDVP10   = db_utils::fieldsMemory($rsResult10, $iCont);
      $cldvpdcasp10  = new cl_dvpdcasp102017();

      $cldvpdcasp10->si216_tiporegistro                       = 10;
      $cldvpdcasp10->si216_exercicio                          = $oDadosDVP10->__algumAtributo;
      $cldvpdcasp10->si216_vlimpostos                         = $oDadosDVP10->__algumAtributo;
      $cldvpdcasp10->si216_vlcontribuicoes                    = $oDadosDVP10->__algumAtributo;
      $cldvpdcasp10->si216_vlexploracovendasdireitos          = $oDadosDVP10->__algumAtributo;
      $cldvpdcasp10->si216_vlvariacoesaumentativasfinanceiras = $oDadosDVP10->__algumAtributo;
      $cldvpdcasp10->si216_vltransfdelegacoesrecebidas        = $oDadosDVP10->__algumAtributo;
      $cldvpdcasp10->si216_vlvalorizacaoativodesincorpassivo  = $oDadosDVP10->__algumAtributo;
      $cldvpdcasp10->si216_vloutrasvariacoespatriaumentativas = $oDadosDVP10->__algumAtributo;
      $cldvpdcasp10->si216_vltotalvpaumentativas              = $oDadosDVP10->__algumAtributo;

      $cldvpdcasp10->incluir(null);
      if ($cldvpdcasp10->erro_status == 0) {
        throw new Exception($cldvpdcasp10->erro_msg);
      }

    } // $rsResult10


    /** DVPDCASP202017 */
    $sSQL = " SELECT * "
          . " FROM dvpdcasp202017 "
          . " WHERE 1 = 1 ";

    $rsResult20 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult20); $iCont++) {

      $oDadosDVP20   = db_utils::fieldsMemory($rsResult20, $iCont);
      $cldvpdcasp20  = new cl_dvpdcasp202017();

      $cldvpdcasp20->si216_tiporegistro                       = 20;
      $cldvpdcasp20->si216_exercicio                          = $oDadosDVP20->__algumAtributo;
      $cldvpdcasp20->si216_vlimpostos                         = $oDadosDVP20->__algumAtributo;
      $cldvpdcasp20->si216_vlcontribuicoes                    = $oDadosDVP20->__algumAtributo;
      $cldvpdcasp20->si216_vlexploracovendasdireitos          = $oDadosDVP20->__algumAtributo;
      $cldvpdcasp20->si216_vlvariacoesaumentativasfinanceiras = $oDadosDVP20->__algumAtributo;
      $cldvpdcasp20->si216_vltransfdelegacoesrecebidas        = $oDadosDVP20->__algumAtributo;
      $cldvpdcasp20->si216_vlvalorizacaoativodesincorpassivo  = $oDadosDVP20->__algumAtributo;
      $cldvpdcasp20->si216_vloutrasvariacoespatriaumentativas = $oDadosDVP20->__algumAtributo;
      $cldvpdcasp20->si216_vltotalvpaumentativas              = $oDadosDVP20->__algumAtributo;

      $cldvpdcasp20->incluir(null);
      if ($cldvpdcasp20->erro_status == 0) {
        throw new Exception($cldvpdcasp20->erro_msg);
      }

    } // $rsResult20


    /** DVPDCASP302017 */
    $sSQL = " SELECT * "
          . " FROM dvpdcasp302017 "
          . " WHERE 1 = 1 ";

    $rsResult30 = db_query($sSQL);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult30); $iCont++) {

      $oDadosDVP30   = db_utils::fieldsMemory($rsResult30, $iCont);
      $cldvpdcasp30  = new cl_dvpdcasp302017();

      $cldvpdcasp30->si218_tiporegistro                   = 30;
      $cldvpdcasp30->si218_exercicio                      = $oDadosDVP30->__algumAtributo;
      $cldvpdcasp30->si218_vlresultadopatrimonialperiodo  = $oDadosDVP30->__algumAtributo;

      $cldvpdcasp30->incluir(null);
      if ($cldvpdcasp30->erro_status == 0) {
        throw new Exception($cldvpdcasp30->erro_msg);
      }

    } // $rsResult30

    db_fim_transacao();

    $oGerarDVP = new GerarDVP();
    $oGerarDVP->gerarDados();

  }

}
