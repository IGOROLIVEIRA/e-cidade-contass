<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

require_once('model/contabilidade/relatorios/dcasp/VariacaoPatrimonialDCASP$PROXIMO_ANO.model.php');
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

require_once("classes/db_dvpdcasp10$PROXIMO_ANO_classe.php");
require_once("classes/db_dvpdcasp20$PROXIMO_ANO_classe.php");
require_once("classes/db_dvpdcasp30$PROXIMO_ANO_classe.php");

require_once("model/contabilidade/arquivos/sicom/$PROXIMO_ANO/dcasp/geradores/GerarDVP.model.php");

/**
 * gerar arquivo de Demonstração das Variações Patrimoniais
 * @author gabriel
 * @package Contabilidade
 */
class SicomArquivoDVP extends SicomArquivoBase implements iPadArquivoBaseCSV
{


  protected $iCodigoLayout = VariacaoPatrimonialDCASP$PROXIMO_ANO::CODIGO_RELATORIO; // Código do relatório

  protected $sNomeArquivo = 'DVP';

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

  public function getCampos(){

  }

  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }

  public function getNomeArquivo(){
    return $this->sNomeArquivo;
  }
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

    $iAnoUsu            = db_getsession("DB_anousu");
    $iCodigoPeriodo     = 28;
    $iCodigoRelatorio   = $this->iCodigoLayout;
    $oInstit            = new Instituicao(db_getsession("DB_instit"));

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
    $cldvpdcasp10 = new cl_dvpdcasp10$PROXIMO_ANO();
    $cldvpdcasp20 = new cl_dvpdcasp20$PROXIMO_ANO();
    $cldvpdcasp30 = new cl_dvpdcasp30$PROXIMO_ANO();

    /**
     * excluir informacoes caso estejam repetidas
     */
    db_inicio_transacao();

    /** DVPDCASP10 */
    $sWhereSelectDelete = "si216_ano = {$iAnoUsu} AND si216_periodo = {$iCodigoPeriodo} AND si216_institu IN ({$sListaInstituicoes}) ";
    $sSQL   = $cldvpdcasp10->sql_query(null,"*",null,$sWhereSelectDelete);
    $result = $cldvpdcasp10->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $cldvpdcasp10->excluir(null, $sWhereSelectDelete);
      if ($cldvpdcasp10->erro_status == 0) {
        throw new Exception($cldvpdcasp10->erro_msg);
      }
    }

    /** DVPDCASP20 */
    $sWhereSelectDelete = "si217_ano = {$iAnoUsu} AND si217_periodo = {$iCodigoPeriodo} AND si217_institu IN ({$sListaInstituicoes}) ";
    $sSQL   = $cldvpdcasp20->sql_query(null,"*",null,$sWhereSelectDelete);
    $result = $cldvpdcasp20->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $cldvpdcasp20->excluir(null, $sWhereSelectDelete);
      if ($cldvpdcasp20->erro_status == 0) {
        throw new Exception($cldvpdcasp20->erro_msg);
      }
    }

    /** DVPDCASP30 */
    $sWhereSelectDelete = "si218_ano = {$iAnoUsu} AND si218_periodo = {$iCodigoPeriodo} AND si218_institu IN ({$sListaInstituicoes}) ";
    $sSQL   = $cldvpdcasp30->sql_query(null,"*",null,$sWhereSelectDelete);
    $result = $cldvpdcasp30->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $cldvpdcasp30->excluir(null, $sWhereSelectDelete);
      if ($cldvpdcasp30->erro_status == 0) {
        throw new Exception($cldvpdcasp30->erro_msg);
      }
    }


    /*------------------------------------------------------------------------*/

    $oVariacoesPatrimoniais = new VariacaoPatrimonialDCASP$PROXIMO_ANO($iAnoUsu, $iCodigoRelatorio, $iCodigoPeriodo);
    $oVariacoesPatrimoniais->setInstituicoes($sListaInstituicoes);
    $oVariacoesPatrimoniais->setImprimirExercicioAnterior(true);
    $oVariacoesPatrimoniais->setTipo(VariacaoPatrimonialDCASP$PROXIMO_ANO::TIPO_ANALITICO);

    $oRetornoDVP = $oVariacoesPatrimoniais->getDados();

    $aExercicios = array(
        1 => 'vlrexatual'
    );

    foreach ($aExercicios as $iValorNumerico => $sChave) {

      $cldvpdcasp10  = new cl_dvpdcasp10$PROXIMO_ANO();
      $cldvpdcasp10->si216_ano                                = $iAnoUsu;
      $cldvpdcasp10->si216_periodo                            = $iCodigoPeriodo;
      $cldvpdcasp10->si216_institu                            = db_getsession("DB_instit");
      $cldvpdcasp10->si216_tiporegistro                       = 10;
      $cldvpdcasp10->si216_exercicio                          = $iValorNumerico;
      $cldvpdcasp10->si216_vlimpostos                         = $oRetornoDVP[2]->$sChave;
      $cldvpdcasp10->si216_vlcontribuicoes                    = $oRetornoDVP[6]->$sChave;
      $cldvpdcasp10->si216_vlexploracovendasdireitos          = $oRetornoDVP[11]->$sChave;
      $cldvpdcasp10->si216_vlvariacoesaumentativasfinanceiras = $oRetornoDVP[15]->$sChave;
      $cldvpdcasp10->si216_vltransfdelegacoesrecebidas        = $oRetornoDVP[22]->$sChave;
      $cldvpdcasp10->si216_vlvalorizacaoativodesincorpassivo  = $oRetornoDVP[32]->$sChave;
      $cldvpdcasp10->si216_vloutrasvariacoespatriaumentativas = $oRetornoDVP[38]->$sChave;
      $cldvpdcasp10->si216_vltotalvpaumentativas              = $oRetornoDVP[43]->$sChave;

      $cldvpdcasp10->incluir(null);
      if ($cldvpdcasp10->erro_status == 0) {
        throw new Exception($cldvpdcasp10->erro_msg);
      }

    }

    foreach ($aExercicios as $iValorNumerico => $sChave) {

      $cldvpdcasp20  = new cl_dvpdcasp20$PROXIMO_ANO();

      $cldvpdcasp20->si217_ano                                = $iAnoUsu;
      $cldvpdcasp20->si217_periodo                            = $iCodigoPeriodo;
      $cldvpdcasp20->si217_institu                            = db_getsession("DB_instit");
      $cldvpdcasp20->si217_tiporegistro                       = 20;
      $cldvpdcasp20->si217_exercicio                          = $iValorNumerico;
      $cldvpdcasp20->si217_vldiminutivapessoaencargos         = $oRetornoDVP[45]->$sChave;
      $cldvpdcasp20->si217_vlprevassistenciais                = $oRetornoDVP[50]->$sChave;
      $cldvpdcasp20->si217_vlservicoscapitalfixo              = $oRetornoDVP[57]->$sChave;
      $cldvpdcasp20->si217_vldiminutivavariacoesfinanceiras   = $oRetornoDVP[61]->$sChave;
      $cldvpdcasp20->si217_vltransfconcedidas                 = $oRetornoDVP[67]->$sChave;
      $cldvpdcasp20->si217_vldesvaloativoincorpopassivo       = $oRetornoDVP[76]->$sChave;
      $cldvpdcasp20->si217_vltributarias                      = $oRetornoDVP[82]->$sChave;
      $cldvpdcasp20->si217_vlmercadoriavendidoservicos        = $oRetornoDVP[85]->$sChave;
      $cldvpdcasp20->si217_vloutrasvariacoespatridiminutivas  = $oRetornoDVP[89]->$sChave;
      $cldvpdcasp20->si217_vltotalvpdiminutivas               = $oRetornoDVP[97]->$sChave;

      $cldvpdcasp20->incluir(null);
      if ($cldvpdcasp20->erro_status == 0) {
        throw new Exception($cldvpdcasp20->erro_msg);
      }

    }

    foreach ($aExercicios as $iValorNumerico => $sChave) {

      $cldvpdcasp30  = new cl_dvpdcasp30$PROXIMO_ANO();
      $cldvpdcasp30->si218_ano                            = $iAnoUsu;
      $cldvpdcasp30->si218_periodo                        = $iCodigoPeriodo;
      $cldvpdcasp30->si218_institu                        = db_getsession("DB_instit");
      $cldvpdcasp30->si218_tiporegistro                   = 30;
      $cldvpdcasp30->si218_exercicio                      = $iValorNumerico;
      $cldvpdcasp30->si218_vlresultadopatrimonialperiodo  = $oRetornoDVP[98]->$sChave;

      $cldvpdcasp30->incluir(null);
      if ($cldvpdcasp30->erro_status == 0) {
        throw new Exception($cldvpdcasp30->erro_msg);
      }

    }

    db_fim_transacao();

    $oGerarDVP = new GerarDVP();
    $oGerarDVP->iAno = $iAnoUsu;
    $oGerarDVP->iPeriodo = $iCodigoPeriodo;
    $oGerarDVP->gerarDados();

  }

}
