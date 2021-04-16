<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */


require_once("model/AcordoItem.model.php");
require_once("model/MaterialCompras.model.php");
require_once("model/contrato/AcordoItemTipoCalculoFactory.model.php");
require_once("std/DBDate.php");
require_once("libs/exceptions/ParameterException.php");

/**
 * posicoes do acordo
 * @package Contratos
 */
class AcordoPosicao {

  const TIPO_INCLUSAO                = 1;
  const TIPO_REEQUILIBRIO            = 2;
  const TIPO_REALINHAMENTO           = 3;
  const TIPO_ADITAMENTO              = 4;
  const TIPO_RENOVACAO               = 5;
  const TIPO_VIGENCIA                = 6;
  const TIPO_OUTROS                  = 7;
  const TIPO_EXECUCAO                = 8;
  const TIPO_ACRESCIMOITEM           = 9;
  const TIPO_DECRESCIMOITEM          = 10;
  const TIPO_VIGENCIAEXECUCAO        = 13;
  const TIPO_ACRESCIMODECRESCIMOITEM = 11;
  const TIPO_ACRESCIMODECRESCIMOITEMCONJUGADO = 14;
  const TIPO_ACRESCIMOVALOR_APOSTILA = 15;
  const TIPO_DECRESCIMOVALOR_APOSTILA = 16;
  const TIPO_SEMALTERACAO_APOSTILA = 17;

  /**
   * Codigo do acordo
   *
   * @var integer
   */
  protected $iAcordo;

  /**
   * Codigo sequencial da posicao
   *
   * @var integer
   */
  protected $iCodigo = null;
  /**
   * Codigo sequencial do aditivo
   *
   * @var integer
   */
  protected $iCodigoAditivo = null;

  /**
   * Código da posição de um acordo
   */
  protected $iAcordoPosicao;

  /**
   * Número da posição
   *
   * @var integer
   */
  protected $iNumero;

  /**
   * situacao da posicao
   *
   * @var integer
   */
  protected $iSituacao;

  /**
   * tipo da posição
   *
   * @var integer
   */
  protected $iTipo;

  /**
   * descrição tipo da posição
   *
   * @var string
   */
  protected $sDescricaoTipo;

  /**
   * data do Movimento
   *
   * @var string
   */
  protected $dtData;

  /**
   * data da vigencia inicial
   *
   * @var string
   */
  protected $dtVigenciaInicial = '';

  /**
   * data da vigencia final
   *
   * @var string
   */
  protected $dtVigenciaFinal   = '';

  /**
   * data da assinatura final
   *
   * @var string
   */
  protected $dtAssinatura   = '';

  /**
   * data da publicacao final
   *
   * @var string
   */
  protected $dtPublicacao   = '';

  /**
   * Posisao foi realizada emergencialmente
   *
   * @var bool
   */
  protected $lEmergencial;

   /**
    * itens da posição.
    *
    * @var AcordoItem collection
    */
  protected $aItens = array();

  /**
   * array de posicoes periodos
   */
  protected $aPosicaoPeriodo = array();

  /**
   * observação da posição
   *
   * @var sting
   */
  protected $sObservacao;

  /**
   * Dados anteriores
   *
   * @var object
   */
  protected $oDadosAnteriores;

  /**
   * Numero do aditamento
   *
   * @var string
   * @access protected
   */
  protected $sNumeroAditamento;

  /**
   * Numero do apostilamento
   *
   * @var string
   * @access protected
   */
  protected $sNumeroApostilamento;

  /**
   * Se houve alteração no prazo de vigência do contrato
   *
   * @var string
   * @access protected
   */
  protected $sVigenciaalterada;//OC5304

  /**
   * Constante do caminho da mensagem do model
   * @var string
   */
  const CAMINHO_MENSAGENS = 'patrimonial.contratos.AcordoPosicao.';

  /**
   * Construtor da classe. Recebe o código da posição como parâmetro
   *
   * @param integer $iCodigoPosicao
   */
  function __construct($iCodigoPosicao = null) {

    if (!empty($iCodigoPosicao)) {

      $this->iCodigo     = $iCodigoPosicao;
      $oDaoAcordoPosicao = db_utils::getDao("acordoposicao");
      $sSqlPosicao       = $oDaoAcordoPosicao->sql_query_vigencia($iCodigoPosicao);
      $rsPosicao         = $oDaoAcordoPosicao->sql_record($sSqlPosicao);

      if ($oDaoAcordoPosicao->numrows != 1) {
        throw new Exception("Posição não encontrada!\nContate suporte!");
      }
      $oDadosPosicao = db_utils::fieldsMemory($rsPosicao, 0);
      $this->setAcordo($oDadosPosicao->ac26_acordo);
      $this->setEmergencial($oDadosPosicao->ac26_emergencial=='t'?true:false);
      $this->setNumero($oDadosPosicao->ac26_numero);
      $this->setData(db_formatar($oDadosPosicao->ac26_data, 'd'));
      $this->setSituacao($oDadosPosicao->ac26_situacao);
      $this->setTipo($oDadosPosicao->ac26_acordoposicaotipo);
      $this->setCodigoAditivo($oDadosPosicao->ac35_sequencial);
      $this->setVigenciaInicial(db_formatar($oDadosPosicao->ac18_datainicio, "d"));
      $this->setVigenciaFinal(db_formatar($oDadosPosicao->ac18_datafim, "d"));
      $this->setDataAssinatura(db_formatar($oDadosPosicao->ac35_dataassinaturatermoaditivo, "d"));
      $this->setDataPublicacao(db_formatar($oDadosPosicao->ac35_datapublicacao, "d"));
      $this->sDescricaoTipo = $oDadosPosicao->ac27_descricao;
      $this->oDadosAnteriores = $oDadosPosicao;
      $this->setObservacao($oDadosPosicao->ac26_observacao);
      $this->setNumeroAditamento($oDadosPosicao->ac26_numeroaditamento);
      $this->setNumeroApostilamento($oDadosPosicao->ac26_numeroapostilamento);
      $this->setVigenciaAlterada($oDadosPosicao->ac26_vigenciaalterada);
    }
  }

  /**
   * retorna o numero do aditamento
   *
   * @access public
   * @return void
   */
  public function getNumeroAditamento() {

    return $this->sNumeroAditamento;
  }

  /**
   * Define numero do aditamento
   *
   * @param string $sNumeroAditamento
   * @access public
   * @return void
   */
  public function setNumeroAditamento( $sNumeroAditamento ) {

    $this->sNumeroAditamento = $sNumeroAditamento;
    return $this;
  }

  /**
   * retorna o numero do apostilamento
   *
   * @access public
   * @return void
   */
  public function getNumeroApostilamento() {

    return $this->sNumeroApostilamento;
  }

  /**
   * Define numero do apostilamento
   *
   * @param string $sNumeroApostilamento
   * @access public
   * @return void
   */
  public function setNumeroApostilamento( $sNumeroApostilamento ) {

    $this->sNumeroApostilamento = $sNumeroApostilamento;
    return $this;
  }

  /**
   * retorna o codigo do acordo
   * @return integer
   */
  public function getDescricaoTipo() {

    return $this->sDescricaoTipo;
  }

  /**
   * retorna o codigo do acordo
   * @return integer
   */
  public function getAcordo() {

    return $this->iAcordo;
  }

  /**
   * define  o co codigo do acordo
   * @param integer $iAcordo
   * @return AcordoPosicao
   */
  public function setAcordo($iAcordo) {

    $this->iAcordo = $iAcordo;
    return $this;
  }

  /**
   * retorna o código da posição do acordo
   * @return integer
   */
  public function getCodigoAcordoPosicao() {
    return $this->iAcordoPosicao;
  }

  /**
   *
   * define o código da posição do acordo
   * @param integer $iAcordoPosicao
   * @return AcordoPosicao
   */
  public function setCodigoAcordoPosicao($iAcordoPosicao) {
    $this->iAcordoPosicao = $iAcordoPosicao;
    return $this;
  }

  /**
   * retorna o codigo sequencial da posicao
   * @return integer
   *
   */
  public function getCodigo() {

    return $this->iCodigo;
  }
  /**
   * retorna o codigo sequencial do aditivo
   * @return integer
   *
   */
  public function getCodigoAditivo() {

    return $this->iCodigoAditivo;
  }

  /**
   * retorna o numero da posicao
   * @return integer
   */
  public function getNumero() {

    return $this->iNumero;
  }

  /**
   * define o numero da posicao
   * @param integer $iNumero
   * @return AcordoPosicao
   */
  public function setNumero($iNumero) {

    $this->iNumero = $iNumero;
    return $this;
  }
  /**
   * define o numero do aditivo
   * @param integer $aditivo
   * @return iCodigoAditivo
   */
  public function setCodigoAditivo($iCodigoAditivo) {

    $this->iCodigoAditivo = $iCodigoAditivo;
    return $this;
  }

  /**
   * retorna a situacao da posição
   * @return integer
   */
  public function getSituacao() {

    return $this->iSituacao;
  }

  /**
   * retorna a situação da posição
   * @param integer $iSituacao
   * @return AcordoPosicao
   */
  public function setSituacao($iSituacao) {

    $this->iSituacao = $iSituacao;
    return $this;
  }

  /**
   * retorna o tipo da posição
   * @return integer
   */
  public function getTipo() {

    return $this->iTipo;
  }

  /**
   * define o tipo da posicão
   * @param integer $iTipo
   * @return AcordoPosicao
   */
  public function setTipo($iTipo) {

    $this->iTipo = $iTipo;
    return $this;
  }
  /**
   * retorna a data da posicao
   * @return string
   */
  public function getData() {

    return $this->dtData;
  }

  /**
   * define a data da posição
   * @param string $dtData
   * @return AcordoPosicao
   */
  public function setData($dtData) {

    $this->dtData = $dtData;
    return $this;
  }

  /**
   * define se a posição foi realizada emergencialmente.
   *
   * @param bool $lEmergencial
   * @return AcordoPosicao
   */
  public function setEmergencial($lEmergencial) {

    if (is_bool($lEmergencial)) {
      $this->lEmergencial = $lEmergencial;
    }
    return $this;
  }

  /**
   * Verifica se a posição do contratado é emergencial
   *
   * @return bool
   */
  public function isEmergencial() {
    return $this->lEmergencial;
  }
  /**
   * @return string
   */
  public function getVigenciaFinal() {

    return $this->dtVigenciaFinal;
  }
  /**
   * @return string
   */
  public function getDataAssinatura() {

    return $this->dtAssinatura;
  }
  /**
   * @return string
   */
  public function getDataPublicacao() {

    return $this->dtPublicacao;
  }

  /**
   * define a data de vigencia final do contrato
   * @param string $dtVigenciaFinal data no formado dd/mm/YYYY
   * @return AcordoPosicao
   */
  public function setVigenciaFinal($dtVigenciaFinal) {

    $this->dtVigenciaFinal = $dtVigenciaFinal;
    return $this;
  }
  public function setDataAssinatura($dtAssinatura) {

    $this->dtAssinatura = $dtAssinatura;
    return $this;
  }
  public function setDataPublicacao($dtPublicacao) {

    $this->dtPublicacao = $dtPublicacao;
    return $this;
  }

  /**
   * @return unknown
   */
  public function getVigenciaInicial() {
    return $this->dtVigenciaInicial;
  }

  /**
   * define a data de vigencia inicial do contrato.
   * @param string $dtVigenciaInicial data no formado dd/mm/YYYY
   * @return AcordoPosicao
   */
  public function setVigenciaInicial($dtVigenciaInicial) {

    $this->dtVigenciaInicial = $dtVigenciaInicial;
    return $this;
  }

  /**
   * define a observação da posição
   *
   * @param string $sObservacao
   */
  public function setObservacao($sObservacao) {

  	$this->sObservacao = $sObservacao;
  	return $this;
  }

  /**
   * retorna a observação da posição
   *
   * @return string
   */
  public function getObservacao() {
  	return $this->sObservacao;
  }

  /** OC5304
   * define se o contrato de vigência foi alterado
   *
   * @param string $sObservacao
   */
  public function setVigenciaAlterada($sVigenciaalterada) {

    $this->sVigenciaalterada = $sVigenciaalterada;
    return $this;
  }

  /**
   * retorna a observação da posição
   *
   * @return string
   */
  public function getVigenciaAlterada() {
    return $this->sVigenciaalterada;
  }

  /**
   * @return AcordoItem[]
   */
  public function getItens() {

    $this->aItens   = array();
    $oDaoAcordoItem = db_utils::getDao("acordoitem");
    $sSqlAcordoitem = $oDaoAcordoItem->sql_query_file(null,
                                                      "ac20_sequencial",
                                                      "ac20_ordem",
                                                      "ac20_acordoposicao={$this->getCodigo()}"
                                                     );
    $rsItens = $oDaoAcordoItem->sql_record($sSqlAcordoitem);
    for ($i = 0; $i < $oDaoAcordoItem->numrows; $i++) {
      $this->aItens[] = (new AcordoItem(db_utils::fieldsMemory($rsItens, $i)->ac20_sequencial));
    }
    //echo '<pre>';print_r($this->aItens);die;
    return $this->aItens;
  }

  /**
   * adiciona um item atravez de um item da licitação
   *
   * @param integer $iLicitem codigo do item da licitacao
   * @return AcordoItem
   */
  public function adicionarItemDeLicitacao($iLicitem, $oItemAcordo = null) {

    $oDaoLiclicitem = db_utils::getDao("liclicitem");
    $sSqlDadosItem  = $oDaoLiclicitem->sql_query_soljulg($iLicitem);
    $rsDadosItem    = $oDaoLiclicitem->sql_record($sSqlDadosItem);
    if ($oDaoLiclicitem->numrows == 1) {

      $oItemLicitacao = db_utils::fieldsMemory($rsDadosItem, 0);

      $oItem = new AcordoItem();
      $oItem->setCodigoPosicao($this->getCodigo());
      $oItem->setMaterial(new MaterialCompras($oItemLicitacao->pc01_codmater));
      $oItem->setElemento($oItemLicitacao->pc18_codele);
      $oItem->setQuantidade($oItemLicitacao->pc23_quant);
      $oItem->setUnidade($oItemLicitacao->pc17_unid);
      if ($oItemLicitacao->pc17_unid == '') {
        $oItem->setUnidade(1);
      }
      $oItem->setValorUnitario($oItemLicitacao->pc23_vlrun);
      $oItem->setOrigem($oItemLicitacao->l21_codigo, 2);
      $oItem->setValorTotal($oItemLicitacao->pc23_quant*$oItemLicitacao->pc23_vlrun);
      $oItem->setResumo($oItemLicitacao->pc11_resum);
      $oItem->setServicoQuantidade($oItemLicitacao->pc11_servicoquantidade);
      /**
       * pesquisamos as dotacoes do item
       */
      $oDaoDotacoesItem = db_utils::getDao("pcdotac");
      $sSqlDotacoes     = $oDaoDotacoesItem->sql_query_dotreserva($oItemLicitacao->pc11_codigo);
      $rsDotacoes       = db_query($sSqlDotacoes);
      $aDotacoes        = db_utils::getCollectionByRecord($rsDotacoes);

      foreach ($aDotacoes as $oDotacaoItem) {
//echo "<pre>"; echo $oItemLicitacao->pc23_vlrun;exit;
        $oDotacao    = new stdClass();

        /*
         * A formula de calculo do valor da Dotacao foi alterado para dividir
         * o valor entre as dotacoes conforme acontece em Gerar Autorizacao do Mod. Compras
         * solicitado por Danilo
         */

        /*
         * calcula o percentual da dotação em relacao ao valor total
         */
//        $nPercentualDotacao = 100;
//        if ( $oDotacaoItem->pc11_vlrun > 0 ) {
//          $nPercentualDotacao = ($oDotacaoItem->pc13_valor*100)/($oDotacaoItem->pc11_quant*$oDotacaoItem->pc11_vlrun);
//        }
//        /**
//         * retorna o valor novo da dotacao; (pode ter um aumento/diminuicao do valor)
//         */
        $oDotacao->valor      = round(($oItemLicitacao->pc23_vlrun * $oDotacaoItem->pc13_quant), 2);

        $oDotacao->ano        = $oDotacaoItem->pc13_anousu;
        $oDotacao->dotacao    = $oDotacaoItem->pc13_coddot;
        $oDotacao->quantidade = $oDotacaoItem->pc13_quant;

          $oItem->adicionarDotacoes($oDotacao);
        /**
         * Deletamos as reservas da solicitacao
         */
        if ($oDotacaoItem->o80_codres != '') {
          $oDaoOrcReservaSol = db_utils::getDao("orcreservasol");
          $oDaoOrcReservaSol->excluir(null,"o82_codres = {$oDotacaoItem->o80_codres}");

          $oDaoOrcReserva = db_utils::getDao("orcreserva");
          $oDaoOrcReserva->excluir($oDotacaoItem->o80_codres);
        }
      }
      $oItem->setCodigoPosicao($this->getCodigo());

      $oItem->setTipoControle($oItemAcordo->iFormaControle);

      $aPeriodos = array();
      $oPeriodos = new stdClass();
      $oPeriodos->dtDataInicial   = $oItemAcordo->dtInicial;
      $oPeriodos->dtDataFinal     = $oItemAcordo->dtFinal;
      $oPeriodos->ac41_sequencial = '';
      $aPeriodos[] = $oPeriodos;

      $oItem->setPeriodos($aPeriodos);

      $oAcordo = new Acordo($this->iAcordo);

      $lPeriodoComercial = false;
      if ($oAcordo->getPeriodoComercial()) {
        $lPeriodoComercial = true;
      }
      unset($oAcordo);
      $oItem->setPeriodosExecucao($this->iAcordo, $lPeriodoComercial);

      $oItem->save();
      $this->adicionarItens($oItem);
    }
  }

    /**
     * adiciona um item atravez de um item de credenciamento
     *
     * @param integer $iLicitem codigo do item da licitacao
     * @return AcordoItem
     */
    public function adicionarItemDeCredenciamento($iLicitacao,$iFornecedor,$iLicitem, $oItemAcordo = null,$iContrato,$iTipocompraTribunal) {

        $oDaoLiclicitem = db_utils::getDao("liclicitem");
        $sWhere = "l20_codigo = {$iLicitacao} AND l205_fornecedor = {$iFornecedor} and pc24_pontuacao = 1 AND l21_codigo = {$iLicitem} limit 1";
        $sSqlDadosItem  = $oDaoLiclicitem->sql_query_soljulgCredenciamento(null,"*",null,$sWhere);
        $rsDadosItem    = $oDaoLiclicitem->sql_record($sSqlDadosItem);

        if ($oDaoLiclicitem->numrows == 1) {
            $oItemLicitacao = db_utils::fieldsMemory($rsDadosItem, 0);
            $oItem = new AcordoItem();
            $oItem->setCodigoPosicao($this->getCodigo());
            $oItem->setMaterial(new MaterialCompras($oItemLicitacao->pc01_codmater));
            $oItem->setElemento($oItemLicitacao->pc18_codele);
            $oItem->setQuantidade($oItemAcordo->quantidade);
            $oItem->setUnidade($oItemLicitacao->pc17_unid);
            if ($oItemLicitacao->pc17_unid == '') {
                $oItem->setUnidade(1);
            }
            $oItem->setValorUnitario($oItemAcordo->valorunitario);
            $oItem->setOrigem($oItemLicitacao->l21_codigo, 2);
            $oItem->setValorTotal($oItemAcordo->quantidade*$oItemAcordo->valorunitario);
            $oItem->setResumo($oItemLicitacao->pc11_resum);
            $oItem->setServicoQuantidade($oItemLicitacao->pc11_servicoquantidade);
            $oItem->setIContrato($iContrato);
            $oItem->setILicitacao($iLicitacao);
            $oItem->setIContratado($iFornecedor);
            $oItem->setIQtdcontratada($oItemAcordo->quantidade);
            $oItem->setILicitem($iLicitem);
            $oItem->setITipocompratribunal($iTipocompraTribunal);

            /**
             * pesquisamos as dotacoes do item
             */

            $oDaoDotacoesItem = db_utils::getDao("pcdotac");
            $sSqlDotacoes     = $oDaoDotacoesItem->sql_query_dotreserva($oItemLicitacao->pc11_codigo);
            $rsDotacoes       = db_query($sSqlDotacoes);
            $aDotacoes        = db_utils::getCollectionByRecord($rsDotacoes);
            $iTotaldeDotacoes = pg_num_rows($rsDotacoes);

            $iQtdporDotacao   = $oItemAcordo->quantidade / $iTotaldeDotacoes;
            $iValorUnt        = (float)$oItemAcordo->valorunitario;
            $iValor           = $iValorUnt * round($iQtdporDotacao,2);

            foreach ($aDotacoes as $oDotacaoItem) {

                $oDotacao    = new stdClass();

                $oDotacao->valor      = $iValor;
                $oDotacao->ano        = $oDotacaoItem->pc13_anousu;
                $oDotacao->dotacao    = $oDotacaoItem->pc13_coddot;
                $oDotacao->quantidade = round($iQtdporDotacao,2);
                $oItem->adicionarDotacoes($oDotacao);

                /**
                 * Deletamos as reservas da solicitacao
                 */

                if ($oDotacaoItem->o80_codres != '') {
                    $oDaoOrcReservaSol = db_utils::getDao("orcreservasol");
                    $oDaoOrcReservaSol->excluir(null,"o82_codres = {$oDotacaoItem->o80_codres}");

                    $oDaoOrcReserva = db_utils::getDao("orcreserva");
                    $oDaoOrcReserva->excluir($oDotacaoItem->o80_codres);
                }
            }
            $oItem->setCodigoPosicao($this->getCodigo());

            $oItem->setTipoControle($oItemAcordo->iFormaControle);

            $aPeriodos = array();
            $oPeriodos = new stdClass();
            $oPeriodos->dtDataInicial   = $oItemAcordo->dtInicial;
            $oPeriodos->dtDataFinal     = $oItemAcordo->dtFinal;
            $oPeriodos->ac41_sequencial = '';
            $aPeriodos[] = $oPeriodos;

            $oItem->setPeriodos($aPeriodos);

            $oAcordo = new Acordo($this->iAcordo);

            $lPeriodoComercial = false;
            if ($oAcordo->getPeriodoComercial()) {
                $lPeriodoComercial = true;
            }
            unset($oAcordo);
            $oItem->setPeriodosExecucao($this->iAcordo, $lPeriodoComercial);
            $oItem->save();
            $this->adicionarItens($oItem);
        }
    }

    /**
   * adiciona um item atravez de um item do processo de compras
   *
   * @param integer $iCodprocItem codigo do item do Processo
   * @return AcordoItem
   */
  public function adicionarItemDeProcesso($iCodprocItem, $oItemAcordo = null) {

    $oDaoLiclicitem = db_utils::getDao("pcprocitem");
    $sSqlDadosItem  = $oDaoLiclicitem->sql_query_soljulg($iCodprocItem);
    $rsDadosItem    = $oDaoLiclicitem->sql_record($sSqlDadosItem);

    if ($oDaoLiclicitem->numrows == 1) {

      $oItemLicitacao = db_utils::fieldsMemory($rsDadosItem, 0);
      $oItem = new AcordoItem();
      $oItem->setCodigoPosicao($this->getCodigo());
      $oItem->setMaterial(new MaterialCompras($oItemLicitacao->pc01_codmater));
      $oItem->setElemento($oItemLicitacao->pc18_codele);
      $oItem->setQuantidade($oItemLicitacao->pc23_quant);
      $oItem->setUnidade($oItemLicitacao->pc17_unid);

      if ($oItemLicitacao->pc17_unid == '') {
        $oItem->setUnidade(1);
      }

      $oItem->setValorUnitario($oItemLicitacao->pc23_vlrun);
      $oItem->setOrigem($oItemLicitacao->pc81_codprocitem, 1);
      $oItem->setValorTotal($oItemLicitacao->pc23_quant*$oItemLicitacao->pc23_vlrun);
      $oItem->setResumo($oItemLicitacao->pc11_resum);
      $oItem->setServicoQuantidade($oItemLicitacao->pc11_servicoquantidade);

      /**
       * pesquisamos as dotacoes do item
       */
      $oDaoDotacoesItem = db_utils::getDao("pcdotac");
      $sSqlDotacoes     = $oDaoDotacoesItem->sql_query_dotreserva($oItemLicitacao->pc11_codigo,
                                                                  null,
                                                                  null,
                                                                  "solicitem.*,pcdotac.*, orcreserva.*");
      $rsDotacoes       = db_query($sSqlDotacoes);
      $aDotacoes        = db_utils::getCollectionByRecord($rsDotacoes);

      foreach ($aDotacoes as $oDotacaoItem) {


        $oDotacao   = new stdClass();
         /*
         * A formula de calculo do valor da Dotacao foi alterado para dividir
         * o valor entre as dotacoes conforme acontece em Gerar Autorizacao do Mod. Compras
         * solicitado por Danilo
         */

        /*
         * calcula o percentual da dotação em relacao ao valor total
         */
        $nPercentualDotacao = 100;
        if ( $oDotacaoItem->pc11_vlrun > 0 ) {
          $nPercentualDotacao = ($oDotacaoItem->pc13_valor*100)/($oDotacaoItem->pc11_quant*$oDotacaoItem->pc11_vlrun);
        }
        /**
         * retorna o valor novo da dotacao; (pode ter um aumento/diminuicao do valor)
         */
        $oDotacao->valor      = round(($oItemLicitacao->pc23_valor * $nPercentualDotacao)/100, 2);

        $oDotacao->ano        = $oDotacaoItem->pc13_anousu;
        $oDotacao->dotacao    = $oDotacaoItem->pc13_coddot;
        $oDotacao->quantidade = $oDotacaoItem->pc13_quant;
        $oItem->adicionarDotacoes($oDotacao);

        /**
         * Deletamos as reservas da solicitacao
         */
        if ($oDotacaoItem->o80_codres != '') {

          $oDaoOrcReservaSol = db_utils::getDao("orcreservasol");
          $oDaoOrcReservaSol->excluir(null,"o82_codres = {$oDotacaoItem->o80_codres}");

          $oDaoOrcReserva = db_utils::getDao("orcreserva");
          $oDaoOrcReserva->excluir($oDotacaoItem->o80_codres);
        }
      }

      $oItem->setTipoControle($oItemAcordo->iFormaControle);

      $aPeriodos = array();
      $oPeriodos = new stdClass();
      $oPeriodos->dtDataInicial   = $oItemAcordo->dtInicial;
      $oPeriodos->dtDataFinal     = $oItemAcordo->dtFinal;
      $oPeriodos->ac41_sequencial = '';
      $aPeriodos[] = $oPeriodos;

      $oItem->setPeriodos($aPeriodos);

      $oAcordo = new Acordo($this->iAcordo);

      $lPeriodoComercial = false;
      if ($oAcordo->getPeriodoComercial()) {
        $lPeriodoComercial = true;
      }

      $oItem->setPeriodosExecucao($this->iAcordo, $lPeriodoComercial);

      $oItem->setCodigoPosicao($this->getCodigo());
      $oItem->save();
      $this->adicionarItens($oItem);
    }
  }

 /**
   * Adiciona um item a posição
   * @param AcordoItem $aItens
   * @return Acordo
   */

  public function adicionarItens(AcordoItem $oItem) {

    $this->aItens[] = $oItem;
    return $this;
  }

  public function save() {

    $isInclusao                          = false;
    $oDaoPosicao                         = db_utils::getDao("acordoposicao");
    $oDaoPosicao->ac26_acordo            = $this->getAcordo();
    $oDaoPosicao->ac26_acordoposicaotipo = $this->getTipo();
    $oDaoPosicao->ac26_numero            = $this->getNumero();
    $oDaoPosicao->ac26_situacao          = $this->getSituacao();
    $oDaoPosicao->ac26_numeroaditamento  = $this->getNumeroAditamento();
    $oDaoPosicao->ac26_data              = implode("-", array_reverse(explode("/", $this->getData())));
    $oDaoPosicao->ac26_emergencial       = $this->isEmergencial() ? "true" : "false";
    $oDaoPosicao->ac26_observacao        = $this->sObservacao;
    $oDaoPosicao->ac26_numeroapostilamento = $this->getNumeroApostilamento();
    $oDaoPosicao->ac26_vigenciaalterada = $this->getVigenciaAlterada();
    $iCodigo                             = $this->getCodigo();

    if (empty($iCodigo)) {

      $isInclusao = true;
      $oDaoPosicao->incluir(null);
      $this->iCodigo = $oDaoPosicao->ac26_sequencial;
      foreach ($this->getPosicaoPeriodo() as $sPosicaoPeriodo) {

        $oDaoAcordoPosicaoPeriodo                      = db_utils::getDao('acordoposicaoperiodo');
        $oDaoAcordoPosicaoPeriodo->ac36_acordoposicao  = $this->getCodigo();
        $oDaoAcordoPosicaoPeriodo->ac36_datainicial    = $sPosicaoPeriodo->dtIni;
        $oDaoAcordoPosicaoPeriodo->ac36_datafinal      = $sPosicaoPeriodo->dtFin;
        $oDaoAcordoPosicaoPeriodo->ac36_descricao      = $sPosicaoPeriodo->descrPer;
        $oDaoAcordoPosicaoPeriodo->ac36_numero         = $sPosicaoPeriodo->periodo;
        $oDaoAcordoPosicaoPeriodo->incluir(null);
      }
    } else {

      $oDaoPosicao->ac26_sequencial = $this->getCodigo() ;
      $oDaoPosicao->alterar($this->getCodigo());
    }

     if ($oDaoPosicao->erro_status == 0) {
      throw new Exception("Não foi possivel salvar posição do acordo!\nErro: {$oDaoPosicao->erro_msg}");
    }
    /*
     * inclui os registros em caso de inclusao
     * exclui e inclui novamente os registros em caso de altaracao
     */
    $oDaoAcordoPosicaoPeriodo = db_utils::getDao('acordoposicaoperiodo');

    /**
     * apenas devemos realizar a modificaçãio, se o periodo de vigencia da posicao mudar..
     */
    if (!$isInclusao && $this->getVigenciaFinal()  != db_formatar($this->oDadosAnteriores->ac18_datafim, 'd') &&
      $this->getVigenciaInicial() != db_formatar($this->oDadosAnteriores->ac18_datainicio, 'd')) {


      $sWhereAcordo = " ac36_acordoposicao = {$this->getCodigo()} ";
      $oDaoAcordoPosicaoPeriodo->excluir("",$sWhereAcordo);

      foreach ($this->getPosicaoPeriodo() as $oPosicaoPeriodo){

        $oDaoAcordoPosicaoPeriodo->ac36_acordoposicao  = $this->getCodigo();
        $oDaoAcordoPosicaoPeriodo->ac36_datainicial    = $oPosicaoPeriodo->dtIni;
        $oDaoAcordoPosicaoPeriodo->ac36_datafinal      = $oPosicaoPeriodo->dtFin;
        $oDaoAcordoPosicaoPeriodo->ac36_descricao      = $oPosicaoPeriodo->descrPer;
        $oDaoAcordoPosicaoPeriodo->ac36_numero         = $oPosicaoPeriodo->periodo;

        $oDaoAcordoPosicaoPeriodo->incluir(null);
      }
    }



    /**
     * incluimos e excluimos novamente das tabela acordovigência
     */
     $oDaoAcordoVigencia                     = db_utils::getDao("acordovigencia");
     $oDaoAcordoVigencia->excluir(null, "ac18_acordoposicao={$this->getCodigo()}");
     if ($oDaoAcordoVigencia->erro_status == 0) {
       throw new Exception("Erro ao definir vigência do contrato.\n{$oDaoAcordoVigencia->erro_msg}");
     }

     if ($this->getVigenciaInicial() != "" && $this->getVigenciaFinal()) {

       $oDaoAcordoVigencia->ac18_acordoposicao = $this->getCodigo();
       $oDaoAcordoVigencia->ac18_ativo         = "true";
       $oDaoAcordoVigencia->ac18_datainicio    = implode("-", array_reverse(explode("/", $this->getVigenciaInicial())));
       $oDaoAcordoVigencia->ac18_datafim       = implode("-", array_reverse(explode("/", $this->getVigenciaFinal())));
       $oDaoAcordoVigencia->incluir(null);
       if ($oDaoAcordoVigencia->erro_status == 0) {
         throw new Exception("Erro ao definir vigência do contrato.\n{$oDaoAcordoVigencia->erro_msg}");
       }
     }
  }

  public function getDotacoesItemOrigem($iCodigo, $iTipoOrigem) {

    $iNumRows = 0;
    if ($iTipoOrigem == 2) {

      $oDaoLiclicitem = db_utils::getDao("liclicitem");
      $sSqlDadosItem  = $oDaoLiclicitem->sql_query_soljulg($iCodigo);
      $rsDadosItem    = $oDaoLiclicitem->sql_record($sSqlDadosItem);
      $iNumRows       = $oDaoLiclicitem->numrows;
    } else if ($iTipoOrigem == 1) {

      $oDaoLiclicitem = db_utils::getDao("pcprocitem");
      $sSqlDadosItem  = $oDaoLiclicitem->sql_query_soljulg($iCodigo);
      $rsDadosItem    = $oDaoLiclicitem->sql_record($sSqlDadosItem);
      $iNumRows       = $oDaoLiclicitem->numrows;
    }
    $aDotacoes   = array();
    if ($iNumRows == 1) {

      $oItemOrigem      = db_utils::fieldsMemory($rsDadosItem, 0);
      $oDaoDotacoesItem = db_utils::getDao("pcdotac");
      $sSqlDotacoes     = $oDaoDotacoesItem->sql_query_file($oItemOrigem->pc11_codigo);
      $rsDotacoes       = db_query($sSqlDotacoes);
      $aDotacoesOrigem  = db_utils::getCollectionByRecord($rsDotacoes);
      foreach ($aDotacoesOrigem as $oDotacaoItem) {

        $oDotacao             = new stdClass();
        $oDotacao->valor      = $oDotacaoItem->pc13_valor;
        $oDotacao->ano        = $oDotacaoItem->pc13_anousu;
        $oDotacao->dotacao    = $oDotacaoItem->pc13_coddot;
        $oDotacao->quantidade = $oDotacaoItem->pc13_quant;
        $aDotacoes[] = $oDotacao;

      }
    }
    $oItemOrigem->dotacoes = $aDotacoes;
    return $oItemOrigem;
  }

  public function removerItem($iCodigoItem) {

    $iSeqItem = 0;
    foreach ($this->aItens as $oItem) {

      if ($iCodigoItem == $oItem->getCodigo()) {

        $oItemContrato = $oItem;
        $oItem->remover();
        array_splice($this->aItens, $iSeqItem, 1);
        break;
      }
      $iSeqItem ++;
    }
    $iOrdemItem = 1;
    foreach ($this->aItens as $oItem) {

    	$oItem->setOrdem($iOrdemItem);
    	$oItem->save();
    	$iOrdemItem++;
    }
  }

  /**
   * retorna  o item pelo codigo de cadastro
   *
   * @param integer $iCodigo codigo do item
   * @return AcordoItem
   */
  public function getItemByCodigo($iCodigo) {

    foreach ($this->getItens() as $oItem) {

      if ($oItem->getCodigo() == $iCodigo) {
        return $oItem;
      }
    }
  }

  /**
   * Salva o valor aditado na posicao
   *
   * @param float $nValorSaldo valor aditado
   * @param date $dtAssinatura data da assinatura do adivito
   * @param date $dtPublicacao data da publicação do adivito
   * @param string $sDescricaoAlteracao descricao da alteração
   * @param string $sVeiculoDivulgacao veiculo de divulgacao
   */
  function salvarSaldoAditamento($nValorSaldo,$dtAssinatura,$dtPublicacao,$sDescricaoAlteracao,$sVeiculoDivulgacao) {

    if (!empty($this->iCodigo)) {

      $oDaoAcordoPosicaoAditamento = db_utils::getDao("acordoposicaoaditamento");
      $oDaoAcordoPosicaoAditamento->ac35_acordoposicao                      = $this->getCodigo();
      $oDaoAcordoPosicaoAditamento->ac35_valor                              = $nValorSaldo;
      $oDaoAcordoPosicaoAditamento->ac35_dataassinaturatermoaditivo         = $dtAssinatura;
      $oDaoAcordoPosicaoAditamento->ac35_datapublicacao                     = $dtPublicacao;
      $oDaoAcordoPosicaoAditamento->ac35_descricaoalteracao                 = utf8_decode($sDescricaoAlteracao);
      $oDaoAcordoPosicaoAditamento->ac35_veiculodivulgacao                  = utf8_decode($sVeiculoDivulgacao);
      $oDaoAcordoPosicaoAditamento->incluir(null);
    }
  }

  public function getValorAditado() {

    $oDaoAcordoPosicaoAditamento = db_utils::getDao("acordoposicaoaditamento");
    $sSqlAditamentos             = $oDaoAcordoPosicaoAditamento->sql_query_file(null,
                                                                                "sum(ac35_valor) as valor",
                                                                               null,
                                                                               "ac35_acordoposicao={$this->iCodigo}"
                                                                               );
    $rsAditamentos             = $oDaoAcordoPosicaoAditamento->sql_record($sSqlAditamentos);
    return db_utils::fieldsMemory($rsAditamentos, 0)->valor;
  }


  /**
   *
   * metodo para calcular periodos mensais
   *
   * @param string $dtDataInicial data inicial
   * @param string $dtDataFinal data final
   * @param integer $iAcordo  acordo a ser calculado
   * @return array
   *
   */
  static public function calcularPeriodosMensais($dtDataInicial, $dtDataFinal, $iAcordo) {

    /*
     * inicializa objeto
    */
    $oPosicaoPeriodo = new stdClass();
    $oPosicaoPeriodo->periodo     = 0;
    $oPosicaoPeriodo->dtIni       = 0;
    $oPosicaoPeriodo->dtFin       = 0;
    $oPosicaoPeriodo->descrPer    = 0;

    $aDtIni = explode("/", $dtDataInicial);
    $aDtFin = explode("/", $dtDataFinal);

    $aPosicaoPeriodoMensais = array();

    $iPer                   = self::calculaDiferencaMeses($iAcordo, $dtDataInicial, $dtDataFinal);

    /*
     * insere dados no objeto a cada novo periodo
    */
    for ($iInd = 1; $iInd <= $iPer; $iInd++) {

      /*
       * calculo para data incial
      * se for o primeiro periodo '0' data inicial recebe a data que vem por parametro
      * senao datainicial recebe a data final do periodo anterio +1 dia
      */
      if ( $oPosicaoPeriodo->periodo == 0 ) {
        $dtDataIniPer = $dtDataInicial;
      } else {

        $aDtInicial   = explode("/", $dtDataFinPer);
        $dtDataIniPer =  date("d/m/Y", mktime(0, 0, 0, $aDtInicial[1]+1, 1, $aDtInicial[2]) );
      }

      /*
       * calculo para data final
      * por default soma 30 dias apos a data inicial
      * se ultrapassar o ultimo dia do mes a data final recebe o ultimo dia do mes
      * quando o mesfinal do periodo for igual ao mes final da data final geral o dia recebe o dia final da data geral
      */
      $aDtInicial   = explode("/", $dtDataIniPer);
      $iDiasMes     = cal_days_in_month(CAL_GREGORIAN, $aDtInicial[1], $aDtInicial[2]);
      $dtDataFinPer =  date("d/m/Y", mktime(0, 0, 0, $aDtInicial[1], $iDiasMes, $aDtInicial[2]) );

      /*
       * rotina para decricao do periodo
      */
      $descrPer = db_mesAbreviado($aDtInicial[1]) . '/' . $aDtInicial[2];

      /*
       * insere dados no objeto
      */
      $oPosicaoPeriodo = new stdClass();
      $oPosicaoPeriodo->periodo     = $iInd;
      $oPosicaoPeriodo->dtIni       = $dtDataIniPer;
      $oPosicaoPeriodo->dtFin       = $dtDataFinPer;
      $oPosicaoPeriodo->descrPer    = $descrPer;

      $aPosicaoPeriodoMensais[$iInd] = $oPosicaoPeriodo;

    }

    return $aPosicaoPeriodoMensais;
  }


  /**
   * cria os peridos para a posição
   *
   * @param string $dtDataInicial data inicial
   * @param string $dtDataFinal data final
   * @param bool   $lPeriodoComercial
   * @return AcordoPosicao
   */
  public function setPosicaoPeriodo($dtDataInicial, $dtDataFinal, $lPeriodoComercial) {

    if (!$lPeriodoComercial || $lPeriodoComercial === 'false') {

      $this->aPosicaoPeriodo = self::calcularPeriodosMensais($dtDataInicial, $dtDataFinal, $this->iAcordo);

    } else {
      $this->aPosicaoPeriodo = self::calculaPeriodosComerciais($dtDataInicial, $dtDataFinal);
    }
    return $this;
  }

  /**
   * retorna os periodos da previsao.
   *
   * @return array
   */
  public function getPosicaoPeriodo() {

    if (count($this->aPosicaoPeriodo) == 0 && !empty($this->iCodigo)) {

      $oDaoAcordoPosicaoPeriodo = new cl_acordoposicaoperiodo();
      $sWhere       = "ac36_acordoposicao = {$this->iCodigo}";
      $sSqlPeriodos = $oDaoAcordoPosicaoPeriodo->sql_query_file(null, "*", 'ac36_numero', $sWhere);
      $rsPeriodos   = $oDaoAcordoPosicaoPeriodo->sql_record($sSqlPeriodos);
      if ($rsPeriodos && $oDaoAcordoPosicaoPeriodo->numrows > 0) {

        for ($iPosicao = 0; $iPosicao < $oDaoAcordoPosicaoPeriodo->numrows; $iPosicao++) {

          $oPeriodo                                      = db_utils::fieldsMemory($rsPeriodos, $iPosicao);
          $oPosicaoPeriodo                               = new stdClass();
          $oPosicaoPeriodo->dtIni                        = $oPeriodo->ac36_datainicial;
          $oPosicaoPeriodo->dtFin                        = $oPeriodo->ac36_datafinal;
          $oPosicaoPeriodo->descrPer                     = $oPeriodo->ac36_descricao;
          $oPosicaoPeriodo->periodo                      = $oPeriodo->ac36_numero;
          $oPosicaoPeriodo->codigo                       = $oPeriodo->ac36_sequencial;
          $this->aPosicaoPeriodo[$oPeriodo->ac36_numero] = $oPosicaoPeriodo;
        }
      }
    }
    return $this->aPosicaoPeriodo;
  }
  /**
   * retrono o quadro com as previsoes de cada item da posição
   *
   * @return sdtClass
   */
  public function getQuadroPrevisao () {

    $oQuadro = new stdClass();
    /**
     * buscamos o periodo da posicao
     */
    $sSqlPeriodos         = "select * ";
    $sSqlPeriodos        .= "  from acordoposicaoperiodo ";
    $sSqlPeriodos        .= " left join acordoparalisacaoperiodo on ac36_sequencial = ac49_acordoposicaoperiodo ";
    $sSqlPeriodos        .= " where ac36_acordoposicao  = {$this->iCodigo}";
    $sSqlPeriodos        .= " order by ac36_numero";


    $rsPeriodos           = db_query($sSqlPeriodos);
    $oQuadro->aPeriodos   = array();
    $iTotalPeriodos = pg_num_rows($rsPeriodos);
    for ($i = 0; $i < $iTotalPeriodos; $i++) {

      $oDado                 = db_utils::fieldsMemory($rsPeriodos, $i, false, false, true);
      $oPeriodo              = new stdClass();
      $oPeriodo->codigo      = $oDado->ac36_sequencial;
      $oPeriodo->periodo     = $oDado->ac36_numero;
      $oPeriodo->descricao   = $oDado->ac36_descricao;
      $oPeriodo->datainicial = db_formatar($oDado->ac36_datainicial, "d");
      $oPeriodo->datafinal   = db_formatar($oDado->ac36_datafinal, "d");
      $oPeriodo->lParalisado = false;
      if ($oDado->ac49_tipoperiodo != '' && $oDado->ac49_tipoperiodo == 1) {
        $oPeriodo->lParalisado = true;
      }
      unset($oDado);
      $oQuadro->aPeriodos[] = $oPeriodo;
    }
    $oQuadro->aItens = array();
    $aItens = $this->getItens();
    foreach ($aItens as $oItemContrato) {

      $oItem = new stdClass();
      $oItem->valorunitario      = $oItemContrato->getValorUnitario();
      $oItem->codigo             = $oItemContrato->getCodigo();
      $oItem->ordem              = $oItemContrato->getOrdem();
      $oItem->quantidade         = $oItemContrato->getQuantidade();
      $oItem->unidade            = $oItemContrato->getDescricaoUnidade();
      $oItem->valorunitario      = $oItemContrato->getValorUnitario();
      $oItem->valortotal         = $oItemContrato->getValorTotal();
      $oItem->datainicial        = $oItemContrato->getDataInicial();
      $oItem->datafinal          = $oItemContrato->getDataFinal();
      $oItem->controlemensal     = $oItemContrato->getTipoControle()==1?false:true;
      $oItem->descricao          = $oItemContrato->getMaterial()->getDescricao();
      $oItem->observacao         = $oItemContrato->getResumo();
      $oItem->tipocontrole       = $oItemContrato->getTipocontrole();
      $oItem->previsoes          = $oItemContrato->getPeriodos();
      $oItem->estruturalelemento = $oItemContrato->getEstruturalElemento();
      $oItem->descricaoelemento  = $oItemContrato->getDescEstruturalElemento();
      $oItem->codigoempenho      = '-';
      if ($oItemContrato->getOrigem()->tipo == 6) {
      	$oItem->codigoempenho = $oItemContrato->getOrigem()->oEmpenhoFinanceiro->getCodigo();
      }

      $iTotalQuantidadeExecutado = 0;
      $iTotalValorExecutado      = 0;
      foreach ($oItem->previsoes as $iIndicePeriodo => $oPeriodo) {

        $iTotalQuantidadeExecutado += $oPeriodo->executado;
        $iTotalValorExecutado      += $oPeriodo->valorexecutado;
      }
      $oItem->nTotalQuantidadeExecutado = $iTotalQuantidadeExecutado;
      $oItem->nTotalValorExecutado      = $iTotalValorExecutado;
      $oItem->nQuantidadeDisponivel     = ($oItemContrato->getQuantidade() - $iTotalQuantidadeExecutado);
      $oItem->nValorDisponivel          = ($oItemContrato->getValorTotal() - $iTotalValorExecutado);
      $oQuadro->aItens[]                = $oItem;
    }
    return $oQuadro;
  }

  static function calculaDiferencaMeses($iAcordo, $dtDataInicial, $dtDataFinal) {

    $oAcordo = AcordoRepository::getByCodigo($iAcordo);

    if ($oAcordo->getPeriodoComercial()) {

      $aPeriodos = self::calculaPeriodosComerciais($dtDataInicial, $dtDataFinal);
      return count($aPeriodos);
    }

    $aDataInicial     = explode("/", $dtDataInicial);
    $aDataFinal       = explode("/", $dtDataFinal);
    $iTotalMeses      = 0;

    for ($iAnoInicial = $aDataInicial[2]; $iAnoInicial <= $aDataFinal[2]; $iAnoInicial++) {

      $iMesInicial   = 1;
      $iMesFinal     = 12;

      if ($iAnoInicial == $aDataInicial[2]) {

        $iMesInicial   = $aDataInicial[1];
        $iMesFinal     = 12;

        if ($aDataInicial[2] == $aDataFinal[2]) {
            $iMesFinal  = $aDataFinal[1];
        }
     } else if ($iAnoInicial == $aDataFinal[2]) {

      $iMesInicial   = 1;
      $iMesFinal     = $aDataFinal[1];
     }
     $iTotalAno = 0;
     for ($iMes = $iMesInicial; $iMes <= $iMesFinal; $iMes++) {
      $iTotalAno++;

     }
     $iTotalMeses += $iTotalAno;
    }
   return $iTotalMeses;
  }

  /**
   * Método que busca o sequencial da tabela acordoposicaoperiodo de acordo com os parâmetros passados. Caso não
   * exista período para a data informada, retorna FALSE
   *
   * @param  date $dtDataInicial Ex: DD/MM/AAAA
   * @param  date $dtDataFinal Ex: DD/MM/AAAA
   * @return mixed
   */
  public function getCodigoPosicaoPeriodo ($dtDataInicial, $dtDataFinal) {

    list($iDiaInicial, $iMesInicial, $iAnoInicial) = explode("/", $dtDataInicial);
    list($iDiaFinal, $iMesFinal, $iAnoFinal)       = explode("/", $dtDataFinal);

    $oDaoPosicaoPeriodo    = db_utils::getDao("acordoposicaoperiodo");
    $sCamposPosicaoPeriodo = " ac36_sequencial ";
    $sWherePosicaoPeriodo  = " ac36_acordoposicao = {$this->getCodigoAcordoPosicao()} ";
    $sWherePosicaoPeriodo .= " and (extract(month from ac36_datainicial) = {$iMesInicial} ";
    $sWherePosicaoPeriodo .= " and  extract(year from ac36_datainicial) = {$iAnoInicial})";
    $sSqlPosicaoPeriodo    = $oDaoPosicaoPeriodo->sql_query(null, $sCamposPosicaoPeriodo,
                                                            null, $sWherePosicaoPeriodo);
    $rsPosicaoPeriodo      = $oDaoPosicaoPeriodo->sql_record($sSqlPosicaoPeriodo);
    if ($oDaoPosicaoPeriodo->numrows == 0) {
      return false;
    }
    $iCodigoPosicaoPeriodo = db_utils::fieldsMemory($rsPosicaoPeriodo, 0)->ac36_sequencial;
    return $iCodigoPosicaoPeriodo;
  }

  /**
   * Adiciona um item de um Empenho vinculado ao contrato
   *
   * @param integer      $iPKEmpempitem codigo do item do Processo
   * @param stdClass     $oStdItemContrato
   *                     - dtInicial      : data incial do periodo execução
   *                     - dtFinal        : data final do periodo execução
   *                     - iTipoControle  : código da forma de controle
   */
  public function adicionarItemDeEmpenho($iPKEmpempitem, $oStdItemContrato) {

    $oDAOEmpempitem = db_utils::getDao("empempitem");
    $sWhere         = "e62_sequencial = {$iPKEmpempitem}";
    $sCampos  = "*";
    $sCampos .= ",(select e55_unid from empautitem
    join empempaut on e55_autori = e61_autori
    join empempitem item on e61_numemp = e62_numemp and e55_item = e62_item
    where item.e62_sequencial=empempitem.e62_sequencial) as e55_unid";
    $sSqlDadosItem  = $oDAOEmpempitem->sql_query_file(null, null, $sCampos, null, $sWhere);
    $rsDadosItem    = $oDAOEmpempitem->sql_record($sSqlDadosItem);

    if ($oDAOEmpempitem->numrows == 1) {

      $oItemEmpenho = db_utils::fieldsMemory($rsDadosItem, 0);
      $oItem        = new AcordoItem();

      $oItem->setCodigoPosicao($this->getCodigo());
      $oItem->setElemento($oItemEmpenho->e62_codele);
      $oItem->setQuantidade($oItemEmpenho->e62_quant);
      $oItem->setValorUnitario($oItemEmpenho->e62_vlrun);
      $oItem->setUnidade($oItemEmpenho->e55_unid);

      $oItem->setResumo($oItemEmpenho->e62_descr);
      $oItem->setTipoControle($oStdItemContrato->iTipoControle);
      $oItem->setMaterial(new MaterialCompras($oItemEmpenho->e62_item));
      $oItem->setOrigem($oItemEmpenho->e62_sequencial, 6);
      $oItem->setValorTotal($oItemEmpenho->e62_vltot);
      $oItem->setCodigoPosicao($this->getCodigo());
      $oItem->setServicoQuantidade($oItemEmpenho->e62_servicoquantidade);

      $aPeriodos = array();
      $oPeriodos = new stdClass();
      $oPeriodos->dtDataInicial   = $oStdItemContrato->dtInicial;
      $oPeriodos->dtDataFinal     = $oStdItemContrato->dtFinal;
      $oPeriodos->ac41_sequencial = '';
      $aPeriodos[] = $oPeriodos;
      $oItem->setPeriodos($aPeriodos);

      $oAcordo = new Acordo($this->iAcordo);

      $lPeriodoComercial = false;
      if ($oAcordo->getPeriodoComercial()) {
        $lPeriodoComercial = true;
      }
      unset($oAcordo);
      $oItem->setPeriodosExecucao($this->iAcordo, $lPeriodoComercial);

      /**
       * pesquisamos a dotacao do empenho para adicionar ao item,
       * pois estava causando problema ao fazer aditivo, por nao ter dotacao
       */
      $oDaoEmpenho    = db_utils::getDao("empempenho");
      $sSqlDotacaoEmp = $oDaoEmpenho->sql_query_file($oItemEmpenho->e62_numemp,"e60_coddot,e60_anousu");
      $rsDotacaoEmp   = db_query($sSqlDotacaoEmp);
      $oDotacaoEmp    = db_utils::fieldsMemory($rsDotacaoEmp,0);

      $oDotacao = new stdClass();
      $oDotacao->valor      = $oItemEmpenho->e62_vltot;
      $oDotacao->ano        = $oDotacaoEmp->e60_anousu;
      $oDotacao->dotacao    = $oDotacaoEmp->e60_coddot;
      $oDotacao->quantidade = $oItemEmpenho->e62_quant;
      $oItem->adicionarDotacoes($oDotacao);

      $oItem->save();
      $this->adicionarItens($oItem);
    }
  }


  static public function calculaPeriodosComerciais($dtDataInicial, $dtDataFinal) {

    $aDtIni = explode("/", $dtDataInicial);
    $aDtFin = explode("/", $dtDataFinal);

    $iDiaInicial = (int) $aDtIni[0];
    $iMesInicial = (int) $aDtIni[1];
    $iAnoInicial = (int) $aDtIni[2];

    $iDiaFinal = (int)$aDtFin[0];
    $iMesFinal = (int)$aDtFin[1];
    $iAnoFinal = (int)$aDtFin[2];

    $aDescricaoPeriodo = array();
    $aDescricaoPeriodo[1] = "Janeiro";
    $aDescricaoPeriodo[2] = "Fevereiro";
    $aDescricaoPeriodo[3] = "Março";
    $aDescricaoPeriodo[4] = "Abril";
    $aDescricaoPeriodo[5] = "Maio";
    $aDescricaoPeriodo[6] = "Junho";
    $aDescricaoPeriodo[7] = "Julho";
    $aDescricaoPeriodo[8] = "Agosto";
    $aDescricaoPeriodo[9] = "Setembro";
    $aDescricaoPeriodo[10] = "Outubro";
    $aDescricaoPeriodo[11] = "Novembro";
    $aDescricaoPeriodo[12] = "Dezembro";

    $aDatas             = array();
    $iDiaInicialPeriodo = $iDiaInicial;
    $iMesInicialPeriodo = $iMesInicial;
    $iAnoInicialPeriodo = $iAnoInicial;

    $iTotalPeriodos     = $iMesFinal - ($iMesInicial-1) + ($iAnoFinal - $iAnoInicial)*12 ;
    $aMeses31 = array(1, 3, 5, 7, 8, 10, 12);

    for ($iPeriodo = 0;  $iPeriodo < $iTotalPeriodos; $iPeriodo++) {

      $oDataInicialPeriodo = new DBDate("$iAnoInicialPeriodo-$iMesInicialPeriodo-$iDiaInicialPeriodo");
      $oDataFinalComparar  = new DBDate("$iAnoFinal-$iMesFinal-$iDiaFinal");

      if ($oDataInicialPeriodo->getTimeStamp() > $oDataFinalComparar->getTimeStamp()) {
      	break;
      }

      //Data inicial do periodo-i
      $sDataInicial       = date("Y-m-d", mktime(0, 0, 0, $iMesInicialPeriodo, $iDiaInicialPeriodo, $iAnoInicialPeriodo));
      $aDataInicial       = explode("-",$sDataInicial);
      $iDiaInicialPeriodo = (int) $aDataInicial[2];
      $iMesInicialPeriodo = (int) $aDataInicial[1];
      $iAnoInicialPeriodo = (int) $aDataInicial[0];


      $lAnoPeriodoBisexto = (bool)date("L", mktime(0, 0, 0, $iMesInicialPeriodo, $iDiaInicialPeriodo, $iAnoInicialPeriodo)); ;

      $iDiasSomar       = 29;
      if (in_array($iMesInicialPeriodo, $aMeses31)) {
        $iDiasSomar     = 30;
      }

      if ($iMesInicialPeriodo == 2) {
         $iDiasSomar = 27;
        if ($lAnoPeriodoBisexto){
          $iDiasSomar = 28;
        }
      }

      //Data Final periodo-i
      $sDataFinal         = date("d-m-Y", mktime(0, 0, 0, $iMesInicialPeriodo, $iDiaInicialPeriodo + $iDiasSomar, $iAnoInicialPeriodo));
      $aDataFinal         = explode("-", $sDataFinal);

      //Verifica se a data final do periodo está correta
      $iDiaFinalPeriodo   = (int) $aDataFinal[0];
      $iMesFinalPeriodo   = (int) $aDataFinal[1];
      $iAnoFinalPeriodo   = (int) $aDataFinal[2];

      if ($iAnoInicialPeriodo == $iAnoFinal && (($iMesFinalPeriodo == $iMesFinal && $iDiaFinalPeriodo > $iDiaFinal) || $iMesFinalPeriodo > $iMesFinal)) {

        $iDiaFinalPeriodo = $iDiaFinal;
        $iMesFinalPeriodo = $iMesFinal;
      }

      $sDataFinal         = date("Y-m-d", mktime(0, 0, 0, $iMesFinalPeriodo, $iDiaFinalPeriodo, $iAnoFinalPeriodo));
      $sDescricaoPeriodo  = $aDescricaoPeriodo[$iMesInicialPeriodo];
      if ($iMesInicialPeriodo != $iMesFinalPeriodo ) {
        $sDescricaoPeriodo  .= " / {$aDescricaoPeriodo[$iMesFinalPeriodo]}";
      }

      $sDescricaoPeriodo .= " {$iAnoFinalPeriodo}";


      $oStdPeriodo           = new stdClass();
      $oStdPeriodo->periodo  = $iPeriodo+1;
      $oStdPeriodo->descrPer = $sDescricaoPeriodo;
      $oStdPeriodo->dtIni    = $sDataInicial;
      $oStdPeriodo->dtFin    = $sDataFinal;
      $aDatas[$iPeriodo+1]   = $oStdPeriodo;

      //Prepara variaveis para calculo do próximo periodo
      $sDataFinal         = date("d-m-Y", mktime(0, 0, 0, $iMesFinalPeriodo, $iDiaFinalPeriodo + 1, $iAnoFinalPeriodo));
      $aPeriodoFinal      = explode("-", $sDataFinal);
      $iDiaInicialPeriodo = $aPeriodoFinal[0];
      $iMesInicialPeriodo = $aPeriodoFinal[1];
      $iAnoInicialPeriodo = $aPeriodoFinal[2];
    }

    return $aDatas;

  }

  /**
   * Remove as vigências vinculadas a um acordoposicao
   *
   * @throws DBException
   * @throws BusinessException
   */
  protected function removerVigencia() {

    if ( !db_utils::inTransaction() ) {
      throw new DBException( _M( AcordoPosicao::CAMINHO_MENSAGEM."sem_transacao_ativa" ) );
    }

    if ( $this->getCodigo() == null ) {
      throw new BusinessException( _M( AcordoPosicao::CAMINHO_MENSAGEM."sequencial_nao_existente" ) );
    }

    $oDaoAcordoVigencia   = new cl_acordovigencia();
    $sWhereAcordoVigencia = "ac18_acordoposicao = {$this->getCodigo()}";
    $oDaoAcordoVigencia->excluir( null, $sWhereAcordoVigencia );

    if ( $oDaoAcordoVigencia->erro_status == 0 ) {
      throw new BusinessException( $oDaoAcordoVigencia->erro_msg );
    }
  }

  /**
   * Remove um acordoposicao e tabelas dependentes
   * 1º Remove os registros da tabela acordoitem e dependentes (AcordoItem)
   * 2º Remove os registros da tabela acordoposicaoperio pelo código de acordoposicao
   * 3º Remove os registros da tabela acordovigencia chamando o método removerVigencia
   * 4º Remove o registro da tabela acordoposicao
   *
   * @throws DBException
   * @throws BusinessException
   */
  public function remover() {

    if ( !db_utils::inTransaction() ) {
      throw new DBException( _M( self::CAMINHO_MENSAGENS."sem_transacao_ativa" ) );
    }

    if ( $this->getCodigo() == null ) {
      throw new BusinessException( _M( self::CAMINHO_MENSAGENS."sequencial_nao_existente" ) );
    }

    foreach ( $this->getItens() as $oAcordoItem ) {
      $oAcordoItem->remover();
    }
    $oDAoAcordoPosicaoAditamento = new cl_acordoposicaoaditamento();
    $oDAoAcordoPosicaoAditamento->excluir(null, "ac35_acordoposicao = {$this->getCodigo()}");

    if ( $oDAoAcordoPosicaoAditamento->erro_status == 0 ) {
      throw new BusinessException( $oDAoAcordoPosicaoAditamento->erro_msg );
    }

    /**
     * Remover apostilamento vinculado a posicao
     */
    $oDaoApostilamento = db_utils::getDao("apostilamento");
    $oDaoApostilamento->excluir(null, "si03_acordoposicao = {$this->getCodigo()}");
    if ( $oDaoApostilamento->erro_status == 0 ) {
      throw new BusinessException( $oDaoApostilamento->erro_msg );
    }

    $oDaoAcordoPosicaoPeriodo   = new cl_acordoposicaoperiodo();
    $sWhereAcordoPosicaoPeriodo = "ac36_acordoposicao = {$this->getCodigo()}";
    $oDaoAcordoPosicaoPeriodo->excluir( null, $sWhereAcordoPosicaoPeriodo );

    if ( $oDaoAcordoPosicaoPeriodo->erro_status == 0 ) {
      throw new BusinessException( $oDaoAcordoPosicaoPeriodo->erro_msg );
    }

    $this->removerVigencia();

    $oDaoAcordoPosicao = new cl_acordoposicao();
    $oDaoAcordoPosicao->excluir( $this->getCodigo() );
    /**
     * Volta a vigencia da posicao anterior
     * Caso seja uma exclusão de acordo, não terá uma ultima posição, pois todas já foram deletadas. Portanto essa parte do código não será executada.
     */
    $oDaoPosicao = db_utils::GetDao("acordoposicao");
    $sWhere = "ac26_acordo       = {$this->getAcordo()}";
    $sSqlultimaPosicao = $oDaoPosicao->sql_query_file(null,
        "ac26_sequencial",
        'ac26_numero desc limit 1',
        $sWhere
    );
    $rsPosicao = $oDaoPosicao->sql_record($sSqlultimaPosicao);
    if (pg_num_rows($rsPosicao) > 0) {
      $oAcordo = new Acordo($this->getAcordo());
      $oAcordo->setDataInicial($oAcordo->getUltimaPosicao(true)->getVigenciaInicial());
      $oAcordo->setDataFinal($oAcordo->getUltimaPosicao(true)->getVigenciaFinal());
      $oAcordo->setProvidencia(1);
      $oAcordo->save();
    }

    if ( $oDaoAcordoPosicao->erro_status == 0 ) {
      throw new BusinessException( $oDaoAcordoPosicao->erro_msg );
    }
  }

  /**
   * Vincula o apostilamento na posicao
   *
   * @param integer $0Apostila
   * @param Date $dDtAssAcordo
   */
  function salvarApostilamento($oApostila, $dDtAssAcordo) {

    if (!empty($this->iCodigo)) {

      $oDaoApostilamento = db_utils::getDao("apostilamento");
      $oDaoApostilamento->si03_dataassinacontrato = implode("-",array_reverse(explode("/",$dDtAssAcordo)));
      $oDaoApostilamento->si03_tipoapostila = $oApostila->tipoapostila;
      $oDaoApostilamento->si03_dataapostila = implode("-",array_reverse(explode("/",$oApostila->dataapostila)));
      $oDaoApostilamento->si03_descrapostila = utf8_decode(db_stdClass::db_stripTagsJson($oApostila->descrapostila));
      $oDaoApostilamento->si03_tipoalteracaoapostila = $oApostila->tipoalteracaoapostila;
      $oDaoApostilamento->si03_numapostilamento = $oApostila->numapostilamento;
      $oDaoApostilamento->si03_valorapostila = $oApostila->valorapostila;
      $oDaoApostilamento->si03_instit = db_getsession("DB_instit");
      $oDaoApostilamento->si03_acordo = $this->getAcordo();
      $oDaoApostilamento->si03_acordoposicao = $this->getCodigo();
      $oDaoApostilamento->si03_numcontrato = "null";
      $oDaoApostilamento->incluir(null);
      if ($oDaoApostilamento->erro_status == 0) {
          throw new Exception("Erro ao salvar apostilamento.\n{$oDaoApostilamento->erro_msg}");
      }

    }
  }
  function getValorPosicaoAnterior($iNumeroAditamento){
      $oDaoValorTotal = new cl_acordoposicao();
      $rsValdoraditado=0;
      $sCampos = " sum(ac20_valortotal) AS valortotal";
      $sWhere  = " ac16_sequencial = {$this->getAcordo()} AND ac26_numero =".($iNumeroAditamento -1)."
                   GROUP BY acordoitem.ac20_ordem,
                            ac20_valortotal
                   ORDER BY ac20_ordem";
      $sSqlvalor = $oDaoValorTotal->sql_valor_total_aditado($sCampos, null, $sWhere);
      $srValor = $oDaoValorTotal->sql_record($sSqlvalor);
      for($iCont = 0; $iCont < pg_num_rows($srValor); $iCont++) {
          $valor = db_utils::fieldsMemory($srValor, $iCont);
          $rsValdoraditado += $valor->valortotal;
      }
      return $rsValdoraditado;
  }
  function getValorPosicaoAtual($iNumero){
      $oDaoValorAtual = new cl_acordoposicao();
      $rsValorAtual=0;
      $sCampos = "sum(ac20_valortotal) AS valortotal";
      $sWhere  = "ac16_sequencial = {$this->getAcordo()} AND ac26_numero =".($iNumero)."
                   GROUP BY acordoitem.ac20_ordem,
                            ac20_valortotal
                   ORDER BY ac20_ordem";
      $sSqlvalor = $oDaoValorAtual->sql_valor_total_aditado($sCampos, null, $sWhere);
      $srValor = $oDaoValorAtual->sql_record($sSqlvalor);
      for($iCont = 0; $iCont < pg_num_rows($srValor); $iCont++) {
          $valor = db_utils::fieldsMemory($srValor, $iCont);
          $rsValorAtual += $valor->valortotal;
      }
      return $rsValorAtual;
  }

}
