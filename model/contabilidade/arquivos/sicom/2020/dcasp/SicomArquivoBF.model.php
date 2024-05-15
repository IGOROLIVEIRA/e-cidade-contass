<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

require_once('model/contabilidade/relatorios/dcasp/BalancoFinanceiroDCASP2015.model.php');
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

require_once("classes/db_bfdcasp102020_classe.php");
require_once("classes/db_bfdcasp202020_classe.php");

require_once("model/contabilidade/arquivos/sicom/2020/dcasp/geradores/GerarBF.model.php");

/**
 * gerar arquivo de Balanço Financeiro
 * @author gabriel
 * @package Contabilidade
 */
class SicomArquivoBF extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  protected $iCodigoLayout = 152; // Código do relatório

  protected $sNomeArquivo = 'BF';

  protected $sTipoGeracao;

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
    $sTipoImpressao     = 'A';
    $iCodigoPeriodo     = date('m', strtotime($this->sDataFinal)) + 16;
    $iCodigoRelatorio   = $this->iCodigoLayout;

    /**
     * Se o tipo da geração for consolidado, busca todas as instituições do sistema. Se não, pega a instituição da sessão
     */

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
    $clbfdcasp10 = new cl_bfdcasp102020();
    $clbfdcasp20 = new cl_bfdcasp202020();


    /**
     * excluir informacoes caso estejam repetidas
     */
    db_inicio_transacao();

    /** BFDCASP10 */
    $sWhereSelectDelete = "si206_ano = {$iAnoUsu} AND si206_periodo = {$iCodigoPeriodo} AND si206_institu IN ({$sListaInstituicoes}) ";
    $sSQL   = $clbfdcasp10->sql_query(null, '*', null, $sWhereSelectDelete);
    $result = $clbfdcasp10->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbfdcasp10->excluir(null, $sWhereSelectDelete);
      if ($clbfdcasp10->erro_status == 0) {
        throw new Exception($clbfdcasp10->erro_msg);
      }
    }

    /** BFDCASP20 */
    $sWhereSelectDelete = "si207_ano = {$iAnoUsu} AND si207_periodo = {$iCodigoPeriodo} AND si207_institu IN ({$sListaInstituicoes}) ";
    $sSQL   = $clbfdcasp20->sql_query(null, '*', null, $sWhereSelectDelete);
    $result = $clbfdcasp20->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbfdcasp20->excluir(null, $sWhereSelectDelete);
      if ($clbfdcasp20->erro_status == 0) {
        throw new Exception($clbfdcasp20->erro_msg);
      }
    }

    /*------------------------------------------------------------------------*/


    /**
     * O método `getDados()`, da classe `BalancoFinanceiroDCASP2015()`,
     * retorna um array enorme. Para pegar os dados necessários para cada
     * registro do SICOM DCASP, estamos passando os índices exatos do array.
     * Se eles forem alterados (nas configurações dos relatórios), devem
     * ser alterados aqui também.
     */

    $oBalancoFinanceiro = new BalancoFinanceiroDCASP2015($iAnoUsu, $iCodigoRelatorio, $iCodigoPeriodo);
    $oBalancoFinanceiro->setInstituicoes($sListaInstituicoes);
    $oBalancoFinanceiro->setExibirExercicioAnterior(true);
    $oBalancoFinanceiro->setTipo($sTipoImpressao);

    $oRetornoBF = $oBalancoFinanceiro->getDados();


    /** BFDCASP102020 */
    $aExercicios = array(
        1 => 'vlrexatual'
    );


    foreach ($aExercicios as $iValorNumerico => $sChave) {

      $clbfdcasp10  = new cl_bfdcasp102020();

      $clbfdcasp10->si206_ano                               = $iAnoUsu;
      $clbfdcasp10->si206_periodo                           = $iCodigoPeriodo;
      $clbfdcasp10->si206_institu                           = db_getsession("DB_instit");
      $clbfdcasp10->si206_tiporegistro                      = 10;
      $clbfdcasp10->si206_exercicio                         = $iValorNumerico;
      $clbfdcasp10->si206_vlrecorcamenrecurord              = $oRetornoBF[2]->$sChave;
      $clbfdcasp10->si206_vlrecorcamenrecinceduc            = $oRetornoBF[4]->$sChave;
      $clbfdcasp10->si206_vlrecorcamenrecurvincusaude       = $oRetornoBF[5]->$sChave;
      $clbfdcasp10->si206_vlrecorcamenrecurvincurpps        = $oRetornoBF[6]->$sChave;
      $clbfdcasp10->si206_vlrecorcamenrecurvincuassistsoc   = $oRetornoBF[8]->$sChave;
      $clbfdcasp10->si206_vlrecorcamenoutrasdestrecursos    = $oRetornoBF[9]->$sChave;
      $clbfdcasp10->si206_vltransfinanexecuorcamentaria     = $oRetornoBF[11]->$sChave;
      $clbfdcasp10->si206_vltransfinanindepenexecuorc       = $oRetornoBF[12]->$sChave;
      $clbfdcasp10->si206_vltransfinanreceaportesrpps       = $oRetornoBF[13]->$sChave;
      $clbfdcasp10->si206_vlincrirspnaoprocessado           = $oRetornoBF[16]->$sChave;
      $clbfdcasp10->si206_vlincrirspprocessado              = $oRetornoBF[17]->$sChave;
      $clbfdcasp10->si206_vldeporestituvinculados           = $oRetornoBF[18]->$sChave;
      $clbfdcasp10->si206_vloutrosrecextraorcamentario      = $oRetornoBF[19]->$sChave;
      $clbfdcasp10->si206_vlsaldoexeranteriorcaixaequicaixa = $oRetornoBF[21]->$sChave;
      $clbfdcasp10->si206_vlsaldoexerantdeporestvinc        = $oRetornoBF[22]->$sChave;
      $clbfdcasp10->si206_vltotalingresso                   = $oRetornoBF[23]->$sChave;

      $clbfdcasp10->incluir(null);
      if ($clbfdcasp10->erro_status == 0) {
        throw new Exception($clbfdcasp10->erro_msg);
      }

    } // $rsResult10


    /** BFDCASP202020 */
    $aExercicios = array(
        1 => 'vlrexatual'
    );

    foreach ($aExercicios as $iValorNumerico => $sChave) {

      $clbfdcasp20  = new cl_bfdcasp202020();

      $clbfdcasp20->si207_ano                               = $iAnoUsu;
      $clbfdcasp20->si207_periodo                           = $iCodigoPeriodo;
      $clbfdcasp20->si207_institu                           = db_getsession("DB_instit");
      $clbfdcasp20->si207_tiporegistro                      = 20;
      $clbfdcasp20->si207_exercicio                         = $iValorNumerico;
      $clbfdcasp20->si207_vldesporcamenrecurordinarios      = $oRetornoBF[25]->$sChave;
      $clbfdcasp20->si207_vldesporcamenrecurvincueducacao   = $oRetornoBF[27]->$sChave;
      $clbfdcasp20->si207_vldesporcamenrecurvincusaude      = $oRetornoBF[28]->$sChave;
      $clbfdcasp20->si207_vldesporcamenrecurvincurpps       = $oRetornoBF[29]->$sChave;
      $clbfdcasp20->si207_vldesporcamenrecurvincuassistsoc  = $oRetornoBF[31]->$sChave;
      $clbfdcasp20->si207_vloutrasdesporcamendestrecursos   = $oRetornoBF[32]->$sChave;
      $clbfdcasp20->si207_vltransfinanconcexecorcamentaria  = $oRetornoBF[34]->$sChave;
      $clbfdcasp20->si207_vltransfinanconcindepenexecorc    = $oRetornoBF[35]->$sChave;
      $clbfdcasp20->si207_vltransfinanconcaportesrecurpps   = $oRetornoBF[36]->$sChave;
      $clbfdcasp20->si207_vlpagrspnaoprocessado             = $oRetornoBF[39]->$sChave;
      $clbfdcasp20->si207_vlpagrspprocessado                = $oRetornoBF[40]->$sChave;
      $clbfdcasp20->si207_vldeposrestvinculados             = $oRetornoBF[41]->$sChave;
      $clbfdcasp20->si207_vloutrospagextraorcamentarios     = $oRetornoBF[42]->$sChave;
      $clbfdcasp20->si207_vlsaldoexeratualcaixaequicaixa    = $oRetornoBF[44]->$sChave;
      $clbfdcasp20->si207_vlsaldoexeratualdeporestvinc      = $oRetornoBF[45]->$sChave;
      $clbfdcasp20->si207_vltotaldispendios                 = $oRetornoBF[46]->$sChave;

      $clbfdcasp20->incluir(null);
      if ($clbfdcasp20->erro_status == 0) {
        throw new Exception($clbfdcasp20->erro_msg);
      }

    } // $rsResult20


    db_fim_transacao();

    $oGerarBF = new GerarBF();
    $oGerarBF->iAno = $iAnoUsu;
    $oGerarBF->iPeriodo = $iCodigoPeriodo;
    $oGerarBF->gerarDados();

  }

}
