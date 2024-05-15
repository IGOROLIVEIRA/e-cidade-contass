<?php
/**
 * E-cidade Software Publico para Gestão Municipal
 *   Copyright (C) 2014 DBSeller Serviços de Informática Ltda
 *                          www.dbseller.com.br
 *                          e-cidade@dbseller.com.br
 *   Este programa é software livre; você pode redistribuí-lo e/ou
 *   modificá-lo sob os termos da Licença Pública Geral GNU, conforme
 *   publicada pela Free Software Foundation; tanto a versão 2 da
 *   Licença como (a seu critério) qualquer versão mais nova.
 *   Este programa e distribuído na expectativa de ser útil, mas SEM
 *   QUALQUER GARANTIA; sem mesmo a garantia implícita de
 *   COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM
 *   PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais
 *   detalhes.
 *   Você deve ter recebido uma cópia da Licença Pública Geral GNU
 *   junto com este programa; se não, escreva para a Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *   02111-1307, USA.
 *   Cópia da licença no diretório licenca/licenca_en.txt
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
   * Transferencias dos creditos empenhados para RP
   */
  const TRANSFERENCIA_CREDITOS_EMPENHADOS_RP = 8;


  /**
   * Encerramento: Implantação de Saldos
   */
  const ENCERRAR_IMPLANTACAO_SALDOS = 8;

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
   * Retorna a lista dos encerramentos disponíveis
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
   * Data dos Lançamentos Contabeis
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
      throw new ParameterException("Informe a instituição e o ano do encerramento");
    }
    $this->aListaEncerramentos = array(
        self::ENCERRAR_RESTOS_A_PAGAR,
        self::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE,
        self::ENCERRAR_VARIACOES_PATRIMONIAIS,
        self::ENCERRAR_IMPLANTACAO_SALDOS
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

      case EncerramentoExercicio::TRANSFERENCIA_CREDITOS_EMPENHADOS_RP:

        $this->transferirCreditosEmpenhadosRP();
        break;

      case EncerramentoExercicio::ENCERRAR_RESTOS_A_PAGAR:

        $this->encerrarRestosAPagar();
        break;

      case EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS:

        $this->encerrarVariacoesPatrimoniais();
        break;

      case EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE:

        $this->encerrarSistemaOrcamentario();
        break;
      case EncerramentoExercicio::ENCERRAR_IMPLANTACAO_SALDOS:

        $this->encerrarImplantacaoSaldos();
        break;
      default:

        throw new ParameterException('Tipo de encerramento não existe');
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
      throw new BusinessException("$iTipoEncerramento ainda não encerrado!");
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

    $this->excluirDadosEncerramento($iTipoEncerramento);
    return true;
  }

  public function cancelarTransferencia() {

    $rsConlancadamDoc = $this->getTransferenciasRealizadas();

    for($i=0; $i<pg_num_rows($rsConlancadamDoc); $i++) {
      lancamentoContabil::excluirLancamento(db_utils::fieldsMemory($rsConlancadamDoc, $i)->c71_codlan);
    }

    return true;

  }

  /**
   * Retorna todos os encerramentos realizados para instituicao
   * @return array
   */
  public function getTransferenciasRealizadas() {

    $oDaoConlancaDoc = new cl_conlancamdoc();
    $sSql = "SELECT c71_codlan FROM conlancamdoc INNER JOIN conlancaminstit ON c71_codlan = c02_codlan WHERE c71_coddoc IN (1012, 1013, 1014) AND date_part('year', c71_data) = {$this->iAno} AND c02_instit = {$this->oInstituicao->getCodigo()}";
    $rsTransferenciasRealizadas = $oDaoConlancaDoc->sql_record($sSql);

    return $rsTransferenciasRealizadas;

  }

  public function cancelarImplantacaoSaldos() {

    $iExercicioNovo  = $this->iAno + 1;
    $sDataInicio     = "{$this->iAno}-01-01";
    $sDataFim        = "{$this->iAno}-12-31";
    $oDaoConplanoExe = new cl_conplanoexe();

    $sSqlImplantacaoSaldos = $oDaoConplanoExe->sql_query_implantacao_saldos($sDataInicio,
        $sDataFim,
        $this->oInstituicao->getCodigo(),
        $this->iAno);

    $rsImplatacaoSaldo = $oDaoConplanoExe->sql_record($sSqlImplantacaoSaldos);
    $iNumrows          = $oDaoConplanoExe->numrows;

    if ($rsImplatacaoSaldo == false || $iNumrows == 0) {
      throw new DBException("Nenhuma conta encontrada para cancelamento da Implantaçao de Saldos.");
    }

    for ($iConta = 0; $iConta < $iNumrows; $iConta++) {

      $oConta = db_utils::fieldsMemory($rsImplatacaoSaldo, $iConta);

      $oDaoConplanoExe->c62_anousu = $iExercicioNovo;
      $oDaoConplanoExe->c62_reduz  = $oConta->c61_reduz;
      $oDaoConplanoExe->c62_codrec = $oConta->c61_codigo;
      $oDaoConplanoExe->c62_vlrcre = "0";
      $oDaoConplanoExe->c62_vlrdeb = "0";

      $oDaoConplanoExe->alterar($iExercicioNovo, $oConta->c61_reduz);

      if ($oDaoConplanoExe->erro_status == "0") {
        throw new DBException($oDaoConplanoExe->erro_msg);
      }
    }

    $this->excluirDadosEncerramento(EncerramentoExercicio::ENCERRAR_IMPLANTACAO_SALDOS);
    return true;
  }

  /**
   * Realiza os encerramento dos restos a pagar
   * @throws BusinessException
   */
  private function encerrarRestosAPagar() {
    $this->habilitarContasCorrentes();
    if ($this->getCodigoEncerramentoDoTipo(EncerramentoExercicio::ENCERRAR_RESTOS_A_PAGAR)) {
      throw new BusinessException("Encerramento dos restos a pagar já realizado em {$this->iAno}");
    }
    $this->incluirDadosEncerramento(EncerramentoExercicio::ENCERRAR_RESTOS_A_PAGAR);

    $oDaoEmpempenho        = new cl_empempenho();
    /*$sCalculoNaoProcessado = "round(e60_vlremp - e60_vlranu - e60_vlrliq, 2)";
    $sCalculoProcessado    = "round(e60_vlrliq - e60_vlrpag, 2)";

    $sCampos         = "e60_numemp, {$sCalculoNaoProcessado} as valor_nao_processado, ";
    $sCampos        .= "{$sCalculoProcessado} as valor_processado";

    $sWhereEmpenho  = "(e91_anousu = {$this->iAno} or e60_anousu = {$this->iAno}) and e60_instit = {$this->oInstituicao->getCodigo()}";
    $sWhereEmpenho .= " and ({$sCalculoProcessado} > 0 or $sCalculoNaoProcessado > 0)";
    $sSqlEmpenho    = $oDaoEmpempenho->sql_query_encerramento_empresto($sCampos, null, $sWhereEmpenho);
    */
    $sSqlEmpenho    = $oDaoEmpempenho->sql_query_saldo_encerramento_rp();
    $rsLancamentos = $oDaoEmpempenho->sql_record($sSqlEmpenho);
    
    if ($oDaoEmpempenho->numrows == 0) {
      $this->desabiliarContaCorrente();
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
      if ($oDadoEmpenho->valor_em_liquidacao > 0) {
        $this->executarLancamentoRestos($oEmpenho, 1011, $oDadoEmpenho->valor_em_liquidacao);
      }
      unset($oEmpenho);
      unset($oDadoEmpenho);
    }
    $this->desabiliarContaCorrente();
  }

  /**
   * Executa o lancamento dos restos a pagars
   * @param EmpenhoFinanceiro $oEmpenho
   * @param                   $iDocumento
   * @param                   $nValor
   * @throws BusinessException
   */
  private function executarLancamentoRestos(EmpenhoFinanceiro $oEmpenho, $iDocumento, $nValor) {

    $oContaCorrenteDetalhe = new ContaCorrenteDetalhe();
    $oContaCorrenteDetalhe->setEmpenho($oEmpenho);
    $oLancamento = new LancamentoAuxiliarEncerramentoExercicio();
    $oLancamento->setValorTotal($nValor);
    $oLancamento->setObservacaoHistorico("Inscrição no valor de " . trim(db_formatar($nValor, "f")));
    $oLancamento->setEmpenho($oEmpenho);
    $oLancamento->setContaCorrenteDetalhe($oContaCorrenteDetalhe);
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
   * Realiza a exclusão de um tipo de encerramento.
   * @param $iTipoEncerramento
   *
   * @throws Exception
   */
  private function excluirDadosEncerramento($iTipoEncerramento) {

    $iCodigoEncerramento = $this->getCodigoEncerramentoDoTipo($iTipoEncerramento);

    $oDaoConEncerramento = new cl_conencerramento();
    $oDaoConEncerramento->excluir($iCodigoEncerramento);
    if ($oDaoConEncerramento->erro_status == 0) {
      throw new Exception($oDaoConEncerramento->erro_msg);
    }
    unset($this->aCodigosEncerramentos[$iTipoEncerramento]);
  }

  /**
   * Realiza o encerremento as variacoesPatrimoniais
   */
  private function encerrarVariacoesPatrimoniais () {

    if ($this->getCodigoEncerramentoDoTipo(EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS)) {
      throw new BusinessException("Encerramento das variações patrimoniais já realizado em {$this->iAno}");
    }

    $this->incluirDadosEncerramento(EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS);

    $sWherePatrimoniais     = "substr(c60_estrut, 1, 1) in('3', '4') ";
    $rsBalanceteVerificacao = $this->exececutarBalanceteVerificacao($sWherePatrimoniais);
    if (!$rsBalanceteVerificacao) {
      throw new DBException('Erro na execução do balancete de Verificação durante o encerramento das VP');
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
      $oLancamento->setObservacaoHistorico("Inscrição no valor de ".trim(db_formatar($oConta->saldo_final, "f")));
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
  private function executarLancamento(LancamentoAuxiliarEncerramentoExercicio $oLancamento, $iDocumento, $iTipo, $ctCredora = null, $ctDevedora = null) {

    $oEvento           = new EventoContabil($iDocumento, $this->iAno);
    $iCodigoLancamento = $oEvento->executaLancamento($oLancamento, $this->oDataLancamento->getDate(), $ctCredora, $ctDevedora);
    $this->vincularLancamento($iCodigoLancamento, $iTipo);
  }

  /**
   * Realizado o Lancamento Contabil
   * @param LancamentoAuxiliarEncerramentoExercicio $oLancamento
   * @param                                         $iDocumento
   * @param                                         $iTipo
   * @throws BusinessException
   *
   * OC11342 Funcao criada separadamente da executarLancamento
   * Pois para transferir os creditos nao sera necessario vincularLancamento (gravar na tabela de encerramento)
   */
  private function executarLancamentoTransferenciaCreditosEmpRP(LancamentoAuxiliarEncerramentoExercicio $oLancamento, $iDocumento, $iTipo) {

    $oEvento           = new EventoContabil($iDocumento, $this->iAno);
    $iCodigoLancamento = $oEvento->executaLancamento($oLancamento, $this->oDataLancamento->getDate());

  }

  /**
   * Retorna as regras da natureza orçamnetária
   * @throws Exception
   * @return array
   */
  public function getRegrasNaturezaOrcamentaria() {

    $oDaoRegrasEncerramento = new cl_regraencerramentonaturezaorcamentaria();
    $sSqlRegrasEncerramento = $oDaoRegrasEncerramento->sql_query( null,
        "*",
        " c117_sequencial ",
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
   * Realiza o sistema orçamentario
   * @throws BusinessException
   *
   */
    private function encerrarSistemaOrcamentario() {

    $aRegras = $this->getRegrasNaturezaOrcamentaria();
    if (count($aRegras) == 0) {
      throw new BusinessException("Não é possível executar o encerramento pois não existem regras configuradas para Natureza Orçamentária e Controle.");
    }

    if ($this->getCodigoEncerramentoDoTipo(EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE)) {
      throw new BusinessException("Encerramento dos sistemas Orçamentario e Controle já realizado em {$this->iAno}");
    }
    $this->incluirDadosEncerramento(EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE);

    $oDaoConPlano = new cl_conplano();
    foreach ($aRegras as $oRegra) {

      /**
       * A conta usada como referência para os lançamentos é aquela indicada na tela de cadastro das regras.
       * @contareferencia: $sContaReferencia
       */

      $sContaReferencia = ($oRegra->c117_contareferencia == "C" ? $oRegra->c117_contacredora : $oRegra->c117_contadevedora);
      $sWhereContaReferencia = "c61_instit = {$this->oInstituicao->getCodigo()} ";
      $sWhereContaReferencia .= "and c60_estrut like '{$sContaReferencia}%' ";
      $sWhereContaReferencia .= "and c61_anousu = {$this->iAno}";
      $sSqlContaReferencia = $oDaoConPlano->sql_query_reduz(null, 'c61_reduz, c60_estrut', 'c60_estrut limit 1', $sWhereContaReferencia);
      $rsContaReferencia   = $oDaoConPlano->sql_record($sSqlContaReferencia);

      if ($oDaoConPlano->numrows == 0) {
        throw new BusinessException("Não foram encontradas contas analiticas com a regra {$sContaReferencia}.");
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
         * Contas sinteticas, nao devemos encerrar
         */
        if (empty($oConta->c61_reduz)) {
          continue;
        }
        /**
         *
         * 1. Buscar o cc do reduzido.
         * 2. Apurar o saldo do contacorrente atravez do reduzido na conlancamval
         * 3. Gravar na contacorrentedetalhe
         *
         */

        $iContaCorrente = $this->getContaCorrenteByReduz($iContaReferencia);

        if ($iContaCorrente != "") {

          $this->habilitarContasCorrentes();

          foreach ($this->getContaCorrenteDetalheByReduz($iContaReferencia,$iContaCorrente) as $oContaCorrente) {

            $oContaCorrenteDetalhe = new ContaCorrenteDetalhe($oContaCorrente->c19_sequencial);
            $aSaldo = $this->getSaldoContaCorrente($oContaCorrente->c19_sequencial, $iContaCorrente);

            $nSaldoAnt = ($aSaldo[0]->saldoanterior == "" ? 0 : $aSaldo[0]->saldoanterior);
            $nDebitos  = ($aSaldo[0]->debitos == "" ? 0 : $aSaldo[0]->debitos);
            $nCreditos = ($aSaldo[0]->creditos == "" ? 0 : $aSaldo[0]->creditos);
            $nValorFinal = number_format(($nSaldoAnt + $nDebitos - $nCreditos),2,".","");

            /**
             * Inverção do saldo da conta referência para o lançamento correto na conta credora.
             */
             $sSinalFinal = ($nValorFinal >= 0 ? 'C' : 'D');

            if($nValorFinal == 0){

              continue;
            }

            $oMovimentacaoContabil = new MovimentacaoContabil();
            $oMovimentacaoContabil->setConta($oConta->c61_reduz);
            $oMovimentacaoContabil->setSaldoFinal(abs($nValorFinal));
            $oMovimentacaoContabil->setTipoSaldo($sSinalFinal);

            $oLancamento = new LancamentoAuxiliarEncerramentoExercicio();
            $oLancamento->setValorTotal($oMovimentacaoContabil->getSaldoFinal());
            $oLancamento->setObservacaoHistorico("Inscrição no valor de " . trim(db_formatar($nValorFinal, "f")));
            $oLancamento->setMovimentacaoContabil($oMovimentacaoContabil);
            $oLancamento->setContaReferencia($iContaReferencia);
            $oLancamento->setContaCorrenteDetalhe($oContaCorrenteDetalhe);
            $this->executarLancamento($oLancamento, 1010, EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE, $oRegra->c117_contacredora, $oRegra->c117_contadevedora);
            unset($oMovimentacaoContabil);
            unset($oLancamento);

          }
          $this->desabiliarContaCorrente();

        } else {

          $oMovimentacaoContabil = new MovimentacaoContabil();
          $oMovimentacaoContabil->setConta($oConta->c61_reduz);
          $oMovimentacaoContabil->setSaldoFinal($oConta->saldo_final);
          $oMovimentacaoContabil->setTipoSaldo($oConta->sinal_final);

          $oLancamento = new LancamentoAuxiliarEncerramentoExercicio();
          $oLancamento->setValorTotal($oMovimentacaoContabil->getSaldoFinal());
          $oLancamento->setObservacaoHistorico("Inscrição no valor de " . trim(db_formatar($oConta->saldo_final, "f")));
          $oLancamento->setMovimentacaoContabil($oMovimentacaoContabil);
          $oLancamento->setContaReferencia($iContaReferencia);
          $this->executarLancamento($oLancamento, 1010, EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE, $oRegra->c117_contacredora, $oRegra->c117_contadevedora);
          unset($oMovimentacaoContabil);
          unset($oLancamento);

        }
      }
    }
  }

  /**
   * Realiza transferencia de creditos empenhados para RP
   * @throws BusinessException
   *
   */
  private function transferirCreditosEmpenhadosRP() {

    /**
     * Cria array com as transações 1012,1013,1014
     */

    $aDocumentos = array(1012, 1013, 1014);

    foreach($aDocumentos as $iDocumento) {

      $iContaReferencia = $this->getReduzidoByDocumento($iDocumento, 1);

      /**
       *
       * 1. Buscar o cc do reduzido.
       * 2. Apurar o saldo do contacorrente atravez do reduzido na conlancamval
       * 3. Gravar na contacorrentedetalhe
       *
       */

      $iContaCorrente = $this->getContaCorrenteByReduz($iContaReferencia);

      if ($iContaCorrente != "") {

        $this->habilitarContasCorrentes();

        foreach ($this->getContaCorrenteDetalheByReduz($iContaReferencia,$iContaCorrente) as $oContaCorrente) {

          $oContaCorrenteDetalhe = new ContaCorrenteDetalhe($oContaCorrente->c19_sequencial);

          $aSaldo = $this->getSaldoContaCorrente($oContaCorrente->c19_sequencial, $iContaCorrente);

          $nSaldoAnt = ($aSaldo[0]->saldoanterior == "" ? 0 : $aSaldo[0]->saldoanterior);
          $nDebitos  = ($aSaldo[0]->debitos == "" ? 0 : $aSaldo[0]->debitos);
          $nCreditos = ($aSaldo[0]->creditos == "" ? 0 : $aSaldo[0]->creditos);
          $nValorFinal = number_format(($nSaldoAnt + $nDebitos - $nCreditos),2,".","");

          /**
           * Inverção do saldo da conta referência para o lançamento correto na conta credora.
           */
          $sSinalFinal = ($nValorFinal >= 0 ? 'C' : 'D');

          if($nValorFinal == 0){
            continue;
          }

          $oMovimentacaoContabil = new MovimentacaoContabil();
          $oMovimentacaoContabil->setConta($oConta->c61_reduz);
          $oMovimentacaoContabil->setSaldoFinal(abs($nValorFinal));
          $oMovimentacaoContabil->setTipoSaldo($sSinalFinal);

          $oLancamento = new LancamentoAuxiliarEncerramentoExercicio();
          $oLancamento->setValorTotal($oMovimentacaoContabil->getSaldoFinal());
          $oLancamento->setObservacaoHistorico("Transferencia de Creditos Empenhados Resta a Pagar do empenho " . $oContaCorrenteDetalhe->getEmpenho()->getCodigo() . " no valor " . trim(db_formatar($nValorFinal, "f")));
          $oLancamento->setMovimentacaoContabil($oMovimentacaoContabil);
          $oLancamento->setContaReferencia($iContaReferencia);
          $oLancamento->setContaCorrenteDetalhe($oContaCorrenteDetalhe);
          $this->executarLancamentoTransferenciaCreditosEmpRP($oLancamento, $iDocumento, EncerramentoExercicio::TRANSFERENCIA_CREDITOS_EMPENHADOS_RP);
          unset($oMovimentacaoContabil);
          unset($oLancamento);

        }

        $this->desabiliarContaCorrente();

      }

    }

  }

  private function getReduzidoByDocumento($iSeqTransacao, $iTipo) {

    $oDaoTrans    = db_utils::getDao("contrans");
    $sWhereTrans  = "c45_coddoc = {$iSeqTransacao} AND c45_anousu = {$this->iAno} AND c45_instit = {$this->oInstituicao->getCodigo()}";
    $sSqlTrans    = $oDaoTrans->sql_query_evento_contabil(null, "*", null, $sWhereTrans);
    $rsTrans      = $oDaoTrans->sql_record($sSqlTrans);

    if (pg_num_rows($rsTrans) == 0) {
        throw new BusinessException("Conta referência não encontrada para o documento {$iSeqTransacao}");
    }

    if($iTipo == 1) {
      return db_utils::fieldsMemory($rsTrans, 0)->c47_debito;
    } elseif($iTipo == 2) {
      return db_utils::fieldsMemory($rsTrans, 0)->c47_credito;
    }

  }

  /**
   * Realiza a implantação de saldos para a rotina de encerramento de exercício.
   * @throws DBException
   */
  private function encerrarImplantacaoSaldos() {

    $iExercicioNovo  = $this->iAno + 1;
    $sDataInicio     = "{$this->iAno}-01-01";
    $sDataFim        = "{$this->iAno}-12-31";
    $oDaoConplanoExe = new cl_conplanoexe();

    $sSqlImplantacaoSaldos = $oDaoConplanoExe->sql_query_implantacao_saldos($sDataInicio,
        $sDataFim,
        $this->oInstituicao->getCodigo(),
        $this->iAno);

    $rsImplatacaoSaldo = $oDaoConplanoExe->sql_record($sSqlImplantacaoSaldos);
    $iNumrows          = $oDaoConplanoExe->numrows;

    if ($rsImplatacaoSaldo == false || $iNumrows == 0) {
      throw new DBException("Nenhuma conta encontrada para Implantaçao de Saldos.");
    }

    for ($iConta = 0; $iConta < $iNumrows; $iConta++) {

      $oConta = db_utils::fieldsMemory($rsImplatacaoSaldo, $iConta);

      $oDaoConplanoExe->c62_anousu = $iExercicioNovo;
      $oDaoConplanoExe->c62_reduz  = $oConta->c61_reduz;
      $oDaoConplanoExe->c62_codrec = $oConta->c61_codigo;

      $oDaoConplanoExe->c62_vlrcre = "0";
      $oDaoConplanoExe->c62_vlrdeb = "0";

      if ($oConta->sinal_final == 'C') {
        $oDaoConplanoExe->c62_vlrcre = $oConta->saldo_final;
      }

      if ($oConta->sinal_final == 'D') {
        $oDaoConplanoExe->c62_vlrdeb = $oConta->saldo_final;
      }

      $oDaoConplanoExe->alterar($iExercicioNovo, $oConta->c61_reduz);

      if ($oDaoConplanoExe->erro_status == "0") {
        throw new DBException($oDaoConplanoExe->erro_msg);
      }
    }
    $this->incluirDadosEncerramento(EncerramentoExercicio::ENCERRAR_IMPLANTACAO_SALDOS);
  }

  /**
   * Executa o balancete de Verificacao
   * @param $sWhere
   * @return resource|string
   * @throws DBException
   */
  public function exececutarBalanceteVerificacao($sWhere ) {

    $sDataInicial           = "{$this->iAno}-01-1";
    $sDataFim               = "{$this->iAno}-12-31";
    $sWherePatrimoniais     = $sWhere;
    $sWherePatrimoniais    .= " and c61_instit = {$this->oInstituicao->getCodigo()}";
    $rsBalanceteVerificacao = db_planocontassaldo_matriz($this->iAno, $sDataInicial, $sDataFim, false, $sWherePatrimoniais, '', true, 'true');
    if (!$rsBalanceteVerificacao) {
      throw new DBException('Erro na execução do balancete de Verificação durante o encerramento das VP');
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
   * Realiza a removação das contas correntes, evitando a excução da mesma
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
      throw new BusinessException("Erro ao realizar bloqueio da execução das contas correntes no encerramento \n{$oDaoContaCorrente->erro_msg}");
    }
  }

  /**
   * Insere novamente os dados da conta corrente para o exericio, apos a execução do encerramento
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
        throw new BusinessException("Erro ao realizar desbloqueio da execução das contas correntes no encerramento");
      }
    }
  }

  /**
   * Funcao que busca o saldo do contacorrente
   * @param $nContaCorrenteDetalhe
   * @param $nContaCorrente
   * @return array|stdClass[]
   * @throws Exception
   */

  public function getSaldoContaCorrente($nContaCorrenteDetalhe, $nContaCorrente){

    $sSqlSaldos = " SELECT
                              (SELECT round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) AS saldoinicial
                               FROM
                                 (SELECT
                                    (SELECT CASE WHEN c29_debito > 0 THEN c29_debito WHEN c29_credito > 0 THEN -1 * c29_credito ELSE 0 END AS saldoanterior
                                     FROM contacorrente
                                     INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                     INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial
                                     AND contacorrentesaldo.c29_mesusu = 0 and contacorrentesaldo.c29_anousu = " . db_getsession("DB_anousu") . "
                                     WHERE contacorrentedetalhe.c19_sequencial = {$nContaCorrenteDetalhe}
                                     AND c17_sequencial = {$nContaCorrente}) AS saldoimplantado,

                                    (SELECT sum(c69_valor) AS debito
                                     FROM conlancamval
                                       INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                       AND conlancam.c70_anousu = conlancamval.c69_anousu
                                       INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                       INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                       INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                       INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                       WHERE c28_tipo = 'D'
                                       AND DATE_PART('MONTH',c69_data) < 12
                                       AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                       AND c19_contacorrente = {$nContaCorrente}
                                       AND c19_sequencial = {$nContaCorrenteDetalhe}
                                       AND c19_instit = " . db_getsession("DB_instit") . "
                                       GROUP BY c28_tipo) AS debitoatual,

                                    (SELECT sum(c69_valor) AS credito
                                     FROM conlancamval
                                       INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                       AND conlancam.c70_anousu = conlancamval.c69_anousu
                                       INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                       INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                       INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                       INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                       WHERE c28_tipo = 'C'
                                       AND DATE_PART('MONTH',c69_data) < 12
                                       AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                       AND c19_contacorrente = {$nContaCorrente}
                                       AND c19_sequencial = {$nContaCorrenteDetalhe}
                                       AND c19_instit = " . db_getsession("DB_instit") . "
                                       GROUP BY c28_tipo) AS creditoatual) AS movi) AS saldoanterior,

                              (SELECT sum(c69_valor)
                               FROM conlancamval
                               INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                               AND conlancam.c70_anousu = conlancamval.c69_anousu
                               INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                               INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                               INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                               INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                               WHERE c28_tipo = 'C'
                               AND DATE_PART('MONTH',c69_data) = 12
                               AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                               AND c19_contacorrente = {$nContaCorrente}
                               AND c19_sequencial = {$nContaCorrenteDetalhe}
                               AND c19_instit = " . db_getsession("DB_instit") . "
                               GROUP BY c28_tipo) AS creditos,

                              (SELECT sum(c69_valor)
                               FROM conlancamval
                               INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                               AND conlancam.c70_anousu = conlancamval.c69_anousu
                               INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                               INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                               INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                               INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                               WHERE c28_tipo = 'D'
                               AND DATE_PART('MONTH',c69_data) = 12
                               AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                               AND c19_contacorrente = {$nContaCorrente}
                               AND c19_sequencial = {$nContaCorrenteDetalhe}
                               AND c19_instit = " . db_getsession("DB_instit") . "
                               GROUP BY c28_tipo) AS debitos";
    try{

      $rsSaldos         = db_query($sSqlSaldos) or die($sSqlSaldos." Erro: ".pg_last_error());
      $aSaldos          = db_utils::getColectionByRecord($rsSaldos);

      return $aSaldos;

    } catch (Exception $ex){

      throw new Exception("Erro ao executar o SQL getSaldoContaCorrenteById. Erro: ".$ex->getMessage());

    }


  }

  /**
   * Retorna a movimentação do reduzido e contacorrente.
   * @param $iReduzido
   * @param $iFiltroContaCorrente
   * @return array|stdClass[]
   */

  public function getContaCorrenteDetalheByReduz($iReduzido, $iFiltroContaCorrente){

    $sCampos  = " distinct c19_sequencial  ";

    $sSqlLancamentos  = " select distinct c19_sequencial  from (  ";
    $sSqlLancamentos .= " select {$sCampos}      ";
    $sSqlLancamentos .= "   from conlancamval " ;
    $sSqlLancamentos .= " inner join contacorrentedetalheconlancamval on contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen ";
    $sSqlLancamentos .= " inner join contacorrentedetalhe on contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe";
    $sSqlLancamentos .= "  where c69_data between '".db_getsession('DB_anousu')."-01-01' and '".db_getsession('DB_anousu')."-12-31' ";
    $sSqlLancamentos .= "    and c19_contacorrente = {$iFiltroContaCorrente} ";
    $sSqlLancamentos .= "    and c19_reduz = {$iReduzido} ";
    $sSqlLancamentos .= "    and c19_instit = " . db_getsession("DB_instit");
    $sSqlLancamentos .= " union all ";
    $sSqlLancamentos .= " select distinct c29_contacorrentedetalhe as c19_sequencial from contacorrentesaldo  ";
    $sSqlLancamentos .= "  where c29_contacorrentedetalhe in (select c19_sequencial from contacorrentedetalhe ";
    $sSqlLancamentos .= " where c19_conplanoreduzanousu = ".db_getsession('DB_anousu')." and c19_reduz = {$iReduzido} ) ";
    $sSqlLancamentos .= " and c29_anousu = ".db_getsession('DB_anousu')." and c29_mesusu =0 ) as xx";

    $rsLancamentos    = db_query($sSqlLancamentos) or die($sSqlLancamentos);
    $aLancamento      = db_utils::getColectionByRecord($rsLancamentos);

    return $aLancamento;

  }

  /**
   * @param $iReduz
   * @return mixed
   */
  public function getContaCorrenteByReduz($iReduz){

    $this->habilitarContasCorrentes();

    $oDaoConplanoContaCorrente = new cl_conplanocontacorrente();
    $sWhere = " c61_reduz = {$iReduz} and c61_anousu = ".db_getsession("DB_anousu")." and c61_instit = ".db_getsession("DB_instit");
    $sSqlConplanoContaCorrente = $oDaoConplanoContaCorrente->sql_query_conplano_contacorrente(null,"DISTINCT c17_sequencial",null,$sWhere);
    $iContacorrente = db_utils::fieldsMemory(db_query($sSqlConplanoContaCorrente), 0)->c17_sequencial;

    $this->desabiliarContaCorrente();

    return $iContacorrente;

  }
}