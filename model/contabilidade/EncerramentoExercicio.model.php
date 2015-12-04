<?php
/**
 * E-cidade Software Publico para Gest�o Municipal
 *   Copyright (C) 2014 DBSeller Servi�os de Inform�tica Ltda
 *                          www.dbseller.com.br
 *                          e-cidade@dbseller.com.br
 *   Este programa � software livre; voc� pode redistribu�-lo e/ou
 *   modific�-lo sob os termos da Licen�a P�blica Geral GNU, conforme
 *   publicada pela Free Software Foundation; tanto a vers�o 2 da
 *   Licen�a como (a seu crit�rio) qualquer vers�o mais nova.
 *   Este programa e distribu�do na expectativa de ser �til, mas SEM
 *   QUALQUER GARANTIA; sem mesmo a garantia impl�cita de
 *   COMERCIALIZA��O ou de ADEQUA��O A QUALQUER PROP�SITO EM
 *   PARTICULAR. Consulte a Licen�a P�blica Geral GNU para obter mais
 *   detalhes.
 *   Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU
 *   junto com este programa; se n�o, escreva para a Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *   02111-1307, USA.
 *   C�pia da licen�a no diret�rio licenca/licenca_en.txt
 *                                 licenca/licenca_pt.txt
 */

/**
 * Encerramento do Exericio contabil para o PCASP
 * @author Iuri Guntchnigg iuri@dbseller.com.br
 * @package Contabilidade
 */
class EncerramentoExercicio {

  /**
   * Encerramento das restos a pagar
   */
  const ENCERRAR_RESTOS_A_PAGAR = 1;

  /**
   * Encerramento das Variacoes patrimoniais
   */
  const ENCERRAR_VARIACOES_PATRIMONIAIS = 6;

  /**
   * Encerramento do sistema orcamentario e controle
   */
  const ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE = 7;

  /**
   * Instituicao que sera realizado o encerramento
   * @var Instituicao
   */
  private $oInstituicao = null;

  /**
   * Ano do Encerramento
   * @var null
   */
  private $iAno = null;

  /**
   *
   * @var array
   */
  private $aEncerramentos = array();

  /**
   * Lista de Encerramentos para o exercicio
   * @var array
   */
  protected $aListaEncerramentos = array();

  /**
   * Retorna a lista dos encerramentos dispon�veis
   * @return array
   */
  public function getListaEncerramentos() {
    return $this->aListaEncerramentos;
  }

  /**
   * Data do encerramento
   * @var DBdate
   */
  protected $oDataEncerramento = null;

  /**
   * Data dos Lan�amentos Contabeis
   * @var DBdate
   */
  protected $oDataLancamento = null;

  /**
   * Codigo dos encerramentos
   * @var array
   */
  private $aCodigosEncerramentos = array();


  /**
   * Lista de contas Correntes removidas
   * @var array
   */
  private $aListaContaCorrentes = array();

  /**
   * Encerramento do exercicio contabil
   *
   * @param Instituicao $oInstituicao
   * @param             $iAno
   * @throws ParameterException
   */
  public function __construct(Instituicao $oInstituicao, $iAno) {

    if (empty($oInstituicao) || empty ($iAno)) {
      throw new ParameterException("Informe a institui��o e o ano do encerramento");
    }
    $this->aListaEncerramentos = array(
                                       self::ENCERRAR_RESTOS_A_PAGAR,
                                       self::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE,
                                       self::ENCERRAR_VARIACOES_PATRIMONIAIS
                                     );

    $this->oInstituicao = $oInstituicao;
    $this->iAno         = $iAno;
  }

  /**
   * @return DBdate
   */
  public function getDataEncerramento() {
    return $this->oDataEncerramento;
  }

  /**
   * @param DBdate $oDataEncerramento
   */
  public function setDataEncerramento($oDataEncerramento) {
    $this->oDataEncerramento = $oDataEncerramento;
  }

  /**
   * @return DBdate
   */
  public function getDataLancamento() {
    return $this->oDataLancamento;
  }

  /**
   * @param DBdate $oDataLancamento
   */
  public function setDataLancamento($oDataLancamento) {
    $this->oDataLancamento = $oDataLancamento;
  }


  /**
   * Realiza o encerramento informado
   *
   * @param  int $iTipoEncerramento
   * @throws BusinessException
   * @throws DBException
   * @throws ParameterException
   */
  public function encerrar($iTipoEncerramento) {

    if (!db_utils::inTransaction()) {
      throw new DBException("Sem transacao com o banco de dados");
    }
    $this->desabiliarContaCorrente();
    switch ($iTipoEncerramento) {

      case EncerramentoExercicio::ENCERRAR_RESTOS_A_PAGAR:
        $this->encerrarRestosAPagar();
      break;

      case EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS:

        $this->encerrarVariacoesPatrimoniais();
        break;

      case EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE:

        $this->encerrarSistemaOrcamentario();
        break;
      default:

        throw new ParameterException('Tipo de encerramento n�o existe');
        break;
    }
    $this->habilitarContasCorrentes();
    $this->encerrarPeriodoContabil();
  }

  /**
   * Cancela o tipo de Encerramento informado
   *
   * @param $iTipoEncerramento
   * @throws BusinessException
   * @throws Exception
   * @return bool
   */
  public function cancelar($iTipoEncerramento) {

    $oDaoConEncerramentolancan = new cl_conencerramentolancam;
    $iCodigoEncerramento       = $this->getCodigoEncerramentoDoTipo($iTipoEncerramento);
    if (empty($iCodigoEncerramento)) {
      throw new BusinessException("$iTipoEncerramento ainda n�o encerrado!");
    }

    $this->abrirPeriodoContabil();

    $sWhere          = "c44_encerramento = {$iCodigoEncerramento}";
    $sSqlLancamentos = $oDaoConEncerramentolancan->sql_query_file(null, "c44_conlancam", null, $sWhere);
    $rsLancamentos   = $oDaoConEncerramentolancan->sql_record($sSqlLancamentos);
    $iTotalLancamentos = $oDaoConEncerramentolancan->numrows;

    $oDaoConEncerramentolancan->excluir(null, $sWhere);
    if ($oDaoConEncerramentolancan->erro_status == 0) {
      throw new BusinessException($oDaoConEncerramentolancan->erro_msg);
    }

    for ($iLancamentos = 0; $iLancamentos < $iTotalLancamentos; $iLancamentos++) {
      lancamentoContabil::excluirLancamento(db_utils::fieldsMemory($rsLancamentos, $iLancamentos)->c44_conlancam);
    }

    $oDaoConencerramento = new cl_conencerramento();
    $oDaoConencerramento->excluir($iCodigoEncerramento);
    if ($oDaoConencerramento->erro_status == 0) {
      throw new Exception($oDaoConencerramento->erro_msg);
    }
    return true;
  }

  /**
   * Realiza os encerramento dos restos a pagar
   * @throws BusinessException
   */
  private function encerrarRestosAPagar() {

    if ($this->getCodigoEncerramentoDoTipo(EncerramentoExercicio::ENCERRAR_RESTOS_A_PAGAR)) {
      throw new BusinessException("Encerramento dos restos a pagar j� realizado em {$this->iAno}");
    }
    $this->incluirDadosEncerramento(EncerramentoExercicio::ENCERRAR_RESTOS_A_PAGAR);

    $oDaoEmpempenho        = new cl_empempenho();
    $sCalculoNaoProcessado = "round(e60_vlremp - e60_vlranu - e60_vlrliq, 2)";
    $sCalculoProcessado    = "round(e60_vlrliq - e60_vlrpag, 2)";

    $sCampos         = "e60_numemp, {$sCalculoNaoProcessado} as valor_nao_processado,";
    $sCampos        .= "{$sCalculoProcessado} as valor_processado";

    $sWhereEmpenho  = "e60_anousu = {$this->iAno} and e60_instit = {$this->oInstituicao->getCodigo()}";
    $sWhereEmpenho .= " and ({$sCalculoProcessado} > 0 or $sCalculoNaoProcessado > 0)";
    $sSqlEmpenho    = $oDaoEmpempenho->sql_query_file(null, $sCampos, null, $sWhereEmpenho);
    $rsLancamentos = $oDaoEmpempenho->sql_record($sSqlEmpenho);
    if ($oDaoEmpempenho->numrows == 0) {
      return true;
    }

    for ($iEmpenho = 0; $iEmpenho < $oDaoEmpempenho->numrows; $iEmpenho++) {

      $oDadoEmpenho = db_utils::fieldsMemory($rsLancamentos, $iEmpenho);

      $oEmpenho = new EmpenhoFinanceiro($oDadoEmpenho->e60_numemp);
      if ($oDadoEmpenho->valor_processado > 0) {
        $this->executarLancamentoRestos($oEmpenho, 1008, $oDadoEmpenho->valor_processado);
      }
      if ($oDadoEmpenho->valor_nao_processado > 0) {
        $this->executarLancamentoRestos($oEmpenho, 1007, $oDadoEmpenho->valor_nao_processado);
      }
      unset($oEmpenho);
      unset($oDadoEmpenho);
    }
  }

  /**
   * Executa o lancamento dos restos a pagars
   * @param EmpenhoFinanceiro $oEmpenho
   * @param                   $iDocumento
   * @param                   $nValor
   * @throws BusinessException
   */
  private function executarLancamentoRestos(EmpenhoFinanceiro $oEmpenho, $iDocumento, $nValor) {

    $oLancamento = new LancamentoAuxiliarEncerramentoExercicio();
    $oLancamento->setValorTotal($nValor);
    $oLancamento->setObservacaoHistorico("Inscri��o no valor de " . trim(db_formatar($nValor, "f")));
    $oLancamento->setEmpenho($oEmpenho);
    $this->executarLancamento($oLancamento, $iDocumento, EncerramentoExercicio::ENCERRAR_RESTOS_A_PAGAR);
  }
  /**
   * Vincula os lancamentos com o tipo do encerramento
   * @param $iCodigoLancamento
   * @param $iTipoEncerramento
   * @throws BusinessException
   */
  private function vincularLancamento($iCodigoLancamento, $iTipoEncerramento) {

    $oDaoConEncerramentoLancam                   = new cl_conencerramentolancam();
    $oDaoConEncerramentoLancam->c44_conlancam    = $iCodigoLancamento;
    $oDaoConEncerramentoLancam->c44_encerramento = $this->getCodigoEncerramentoDoTipo($iTipoEncerramento);
    $oDaoConEncerramentoLancam->incluir(null);
    if ($oDaoConEncerramentoLancam->erro_status == 0) {
      throw new BusinessException($oDaoConEncerramentoLancam->erro_msg);
    }


  }
  /**
   * Retorna todos os encerramentos realizados para instituicao
   * @return array
   */
  public function getEncerramentosRealizados() {

    if (count($this->aEncerramentos) > 0) {
      return $this->aEncerramentos;
    }

    $oDaoEncerramento            = new cl_conencerramento();
    $sWhereEncerramento          = "c42_anousu = {$this->iAno} and c42_instit = {$this->oInstituicao->getCodigo()}";
    $sSqlEncerramentosRealizados = $oDaoEncerramento->sql_query_file(null,
                                                                    "c42_encerramentotipo,
                                                                    c42_sequencial",
                                                                     null,
                                                                     $sWhereEncerramento
                                                                    );
    $rsEncerramentosRealizados  = $oDaoEncerramento->sql_record($sSqlEncerramentosRealizados);
    if ($oDaoEncerramento->numrows > 0) {
      for ($iEncerramento = 0; $iEncerramento < $oDaoEncerramento->numrows; $iEncerramento++) {

        $oDadosEncerramento = db_utils::fieldsMemory($rsEncerramentosRealizados, $iEncerramento);
        $this->aEncerramentos[$oDadosEncerramento->c42_sequencial] = $oDadosEncerramento->c42_encerramentotipo;

        $this->aCodigosEncerramentos[$oDadosEncerramento->c42_encerramentotipo] = $oDadosEncerramento->c42_sequencial;
      }
    }
    return $this->aEncerramentos;
  }

  /**
   * Retorna o codigo do encerramento realizado por tipo
   * @param $iTipoEncerramento
   * @return mixed
   */
  private function getCodigoEncerramentoDoTipo($iTipoEncerramento) {

    $this->getEncerramentosRealizados();
    if (isset($this->aCodigosEncerramentos[$iTipoEncerramento])) {
      return $this->aCodigosEncerramentos[$iTipoEncerramento];
    }
  }

  /**
   * Realiza a inclusao de um tipo de encerramento.
   * @param $iTipoEncerramento
   * @throws BusinessException
   * @throws Exception
   */
  private function incluirDadosEncerramento($iTipoEncerramento) {

    $oDaoConEncerramento                       = new cl_conencerramento();
    $oDaoConEncerramento->c42_data             = $this->oDataEncerramento->getDate();
    $oDaoConEncerramento->c42_hora             = db_hora();
    $oDaoConEncerramento->c42_anousu           = $this->iAno;
    $oDaoConEncerramento->c42_encerramentotipo = $iTipoEncerramento;
    $oDaoConEncerramento->c42_instit           = $this->oInstituicao->getCodigo();
    $oDaoConEncerramento->c42_usuario          = db_getsession("DB_id_usuario");
    $oDaoConEncerramento->incluir(null);
    if ($oDaoConEncerramento->erro_status == 0) {
      throw new Exception($oDaoConEncerramento->erro_msg);
    }
    $this->aCodigosEncerramentos[$iTipoEncerramento] = $oDaoConEncerramento->c42_sequencial;
  }

  /**
   * Realiza o encerremento as variacoesPatrimoniais
   */
  private function encerrarVariacoesPatrimoniais () {

    if ($this->getCodigoEncerramentoDoTipo(EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS)) {
      throw new BusinessException("Encerramento das varia��es patrimoniais j� realizado em {$this->iAno}");
    }

    $this->incluirDadosEncerramento(EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS);

    $sWherePatrimoniais     = "substr(c60_estrut, 1, 1) in('3', '4') ";
    $rsBalanceteVerificacao = $this->exececutarBalanceteVerificacao($sWherePatrimoniais);
    if (!$rsBalanceteVerificacao) {
      throw new DBException('Erro na execu��o do balancete de Verifica��o durante o encerramento das VP');
    }
    $iTotalLinhas          = pg_num_rows($rsBalanceteVerificacao);
    for ($iConta = 0; $iConta < $iTotalLinhas; $iConta++) {

      $oConta = db_utils::fieldsMemory($rsBalanceteVerificacao, $iConta);
      /**
       * Contas analiticas, ou contas sem sinal, nao devemos encerrar
       */
      if (empty($oConta->c61_reduz) || empty($oConta->sinal_final)) {
        continue;
      }

      $oMovimentacaoContabil = new MovimentacaoContabil();
      $oMovimentacaoContabil->setConta($oConta->c61_reduz);
      $oMovimentacaoContabil->setSaldoFinal($oConta->saldo_final);
      $oMovimentacaoContabil->setTipoSaldo($oConta->sinal_final);

      $oLancamento = new LancamentoAuxiliarEncerramentoExercicio();
      $oLancamento->setValorTotal($oMovimentacaoContabil->getSaldoFinal());
      $oLancamento->setObservacaoHistorico("Inscri��o no valor de ".trim(db_formatar($oConta->saldo_final, "f")));
      $oLancamento->setMovimentacaoContabil($oMovimentacaoContabil);
      $this->executarLancamento($oLancamento, 1009, EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS);
      unset($oMovimentacaoContabil);
      unset($oLancamento);
    }
  }

  /**
   * Realizado o Lancamento Contabil
   * @param LancamentoAuxiliarEncerramentoExercicio $oLancamento
   * @param                                         $iDocumento
   * @param                                         $iTipo
   * @throws BusinessException
   */
  private function executarLancamento(LancamentoAuxiliarEncerramentoExercicio $oLancamento, $iDocumento, $iTipo) {

    $oEvento           = new EventoContabil($iDocumento, $this->iAno);
    $iCodigoLancamento = $oEvento->executaLancamento($oLancamento, $this->oDataLancamento->getDate());
    $this->vincularLancamento($iCodigoLancamento, $iTipo);
  }

  /**
   * Retorna as regras da natureza or�amnet�ria
   * @throws Exception
   * @return array
   */
  public function getRegrasNaturezaOrcamentaria() {

    $oDaoRegrasEncerramento = new cl_regraencerramentonaturezaorcamentaria();
    $sSqlRegrasEncerramento = $oDaoRegrasEncerramento->sql_query( null,
                                                                  "*",
                                                                  null,
                                                                  "c117_anousu = {$this->iAno}"
                                                                  . " and c117_instit = {$this->oInstituicao->getCodigo()}" );
    $rsRegrasEncerramento   = $oDaoRegrasEncerramento->sql_record( $sSqlRegrasEncerramento );

    $aRegras = array();

    if ($oDaoRegrasEncerramento->numrows > 0) {
      $aRegras = db_utils::getCollectionByRecord($rsRegrasEncerramento);
    }
    return $aRegras;
  }

  /**
   * Realiza o sistema or�amentario
   * @throws BusinessException
   */
  private function encerrarSistemaOrcamentario() {

    $aRegras = $this->getRegrasNaturezaOrcamentaria();
    if (count($aRegras) == 0) {
      throw new BusinessException("Sem regras lan�adas para o encerramento do sistema or�amentario.");
    }

    if ($this->getCodigoEncerramentoDoTipo(EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE)) {
      throw new BusinessException("Encerramento dos sistemas Or�amentario e Controle j� realizado em {$this->iAno}");
    }
    $this->incluirDadosEncerramento(EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE);

    $oDaoConPlano = new cl_conplano();
    foreach ($aRegras as $oRegra) {

      /**
       * Procuramos a primeira conta analitica devedora.
       * Est� conta ser� usada como referencia para os lancamentos.
       */
      $sWhereContaReferencia = "c61_instit = {$this->oInstituicao->getCodigo()} ";
      $sWhereContaReferencia .= "and c60_estrut like '{$oRegra->c117_contadevedora}%' ";
      $sWhereContaReferencia .= "and c61_anousu = {$this->iAno}";
      $sSqlContaReferencia = $oDaoConPlano->sql_query_reduz(null, 'c61_reduz, c60_estrut', 'c60_estrut limit 1', $sWhereContaReferencia);
      $rsContaReferencia   = $oDaoConPlano->sql_record($sSqlContaReferencia);
      if ($oDaoConPlano->numrows == 0) {
        throw new BusinessException("N�o foram encontradas contas analiticas com a regra {$oRegra->c117_contadevedora}}");
      }

      $iContaReferencia = db_utils::fieldsMemory($rsContaReferencia, 0)->c61_reduz;

      $iTamanhoEstruturalDevedor = strlen($oRegra->c117_contadevedora);
      $iTamanhoEstruturalCredor  = strlen($oRegra->c117_contacredora);

      $sWhereBalancete  = "(substr(c60_estrut, 1, {$iTamanhoEstruturalDevedor}) = '{$oRegra->c117_contadevedora}'  ";
      $sWhereBalancete .= "or substr(c60_estrut, 1, {$iTamanhoEstruturalCredor}) = '{$oRegra->c117_contacredora}' )";
      $sWhereBalancete .= " and c61_reduz <> {$iContaReferencia}";
      $rsBalancete      = $this->exececutarBalanceteVerificacao($sWhereBalancete);

      $iTotalLinhas     = pg_num_rows($rsBalancete);
      for ($iConta = 0; $iConta < $iTotalLinhas; $iConta++) {

        $oConta = db_utils::fieldsMemory($rsBalancete, $iConta);
        /**
         * Contas analiticas, ou contas sem sinal, nao devemos encerrar
         */
        if (empty($oConta->c61_reduz) || empty($oConta->sinal_final)) {
          continue;
        }

        $oMovimentacaoContabil = new MovimentacaoContabil();
        $oMovimentacaoContabil->setConta($oConta->c61_reduz);
        $oMovimentacaoContabil->setSaldoFinal($oConta->saldo_final);
        $oMovimentacaoContabil->setTipoSaldo($oConta->sinal_final);

        $oLancamento = new LancamentoAuxiliarEncerramentoExercicio();
        $oLancamento->setValorTotal($oMovimentacaoContabil->getSaldoFinal());
        $oLancamento->setObservacaoHistorico("Inscri��o no valor de ".trim(db_formatar($oConta->saldo_final, "f")));
        $oLancamento->setMovimentacaoContabil($oMovimentacaoContabil);
        $oLancamento->setContaReferencia($iContaReferencia);
        $this->executarLancamento($oLancamento, 1010, EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE);
        unset($oMovimentacaoContabil);
        unset($oLancamento);
      }
    }
  }

  /**
   * Executa o balancete de Verificacao
   * @param $sWhere
   * @return resource|string
   * @throws DBException
   */
  protected function exececutarBalanceteVerificacao($sWhere ) {

    $sDataInicial           = "{$this->iAno}-01-1";
    $sDataFim               = "{$this->iAno}-12-31";
    $sWherePatrimoniais     = $sWhere;
    $sWherePatrimoniais    .= " and c61_instit = {$this->oInstituicao->getCodigo()}";
    $rsBalanceteVerificacao = db_planocontassaldo_matriz($this->iAno, $sDataInicial, $sDataFim, false, $sWherePatrimoniais, '', true, 'true');
    if (!$rsBalanceteVerificacao) {
      throw new DBException('Erro na execu��o do balancete de Verifica��o durante o encerramento das VP');
    }
    db_query('drop table work_pl');
    return $rsBalanceteVerificacao;
  }

  /**
   * Encerra  o periodo contabil apos todos os registros serem processados
   * @throws Exception
   */
  public function encerrarPeriodoContabil() {

    $oDaoConEncerramento = new cl_conencerramento();
    $oDaoConEncerramento->lancaBloqueioContabil(implode(",", $this->aListaEncerramentos));
  }

  /**
   * remove o Bloqueio da contabilidade
   * @throws Exception
   */
  public function abrirPeriodoContabil() {

    $oDaoConEncerramento = new cl_conencerramento();
    $oDaoConEncerramento->verificaLancamentoContabil();
  }

  /**
   * Realiza a remova��o das contas correntes, evitando a excu��o da mesma
   * @throws BusinessException
   */
  private function desabiliarContaCorrente() {


    $oDaoContaCorrente   = new cl_conplanocontacorrente();
    $sSqlContasCorrentes = $oDaoContaCorrente->sql_query_file(null, "*", null, "c18_anousu = {$this->iAno}");
    $rsContasCorrentes   = db_query($sSqlContasCorrentes);
    if (!$rsContasCorrentes) {
      throw new BusinessException('Erro ao processar conta corrente');
    }

    $this->aListaContaCorrentes = db_utils::getCollectionByRecord($rsContasCorrentes);

    $oDaoContaCorrente->excluir(null, "c18_anousu = {$this->iAno}");
    if ($oDaoContaCorrente->erro_status == 0) {
      throw new BusinessException("Erro ao realizar bloqueio da execu��o das contas correntes no encerramento \n{$oDaoContaCorrente->erro_msg}");
    }
  }

  /**
   * Insere novamente os dados da conta corrente para o exericio, apos a execu��o do encerramento
   */
  public function habilitarContasCorrentes() {

    $oDaoContaCorrente = new cl_conplanocontacorrente();
    foreach ($this->aListaContaCorrentes as $oContaCorrente) {

      $oDaoContaCorrente->c18_sequencial    = $oContaCorrente->c18_sequencial;
      $oDaoContaCorrente->c18_anousu        = $oContaCorrente->c18_anousu;
      $oDaoContaCorrente->c18_codcon        = $oContaCorrente->c18_codcon;
      $oDaoContaCorrente->c18_contacorrente = $oContaCorrente->c18_contacorrente;
      $oDaoContaCorrente->incluir($oContaCorrente->c18_sequencial);
      if ($oDaoContaCorrente->erro_status == 0) {
        throw new BusinessException("Erro ao realizar desbloqueio da execu��o das contas correntes no encerramento");
      }
    }
  }
}