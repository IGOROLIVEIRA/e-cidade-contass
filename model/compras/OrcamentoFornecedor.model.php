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
 * Orcamento de um Fornecedor para licitações/Processos de compras /SOlicitacoes
 * Class OrcamentoFornecedor
 * @package Compras
 */
class OrcamentoFornecedor {

  /**
   * @var integer do Orcamento
   */
  private $iCodigo;

  /**
   * @var CgmJuridico|CgmFisico
   */
  private $oFornecedor = null;

  /**
   * Cotacoes
   * @var CotacaoItem[]
   */
  private $aCotacoes = array();

  /**
   * @var OrcamentoCompra
   */
  private $oOrcamento = null;

  /**
   * Prazo de entrega dos itens
   * @var DBDate
   */
  private $oPrazoEntrega;

  /**
   * Validade do orçamento
   * @var DBDate
   */
  private $oValidadeOrcamento;

  /**
   * @return CotacaoItem[]
   */
  public function getCotacoes() {
    return $this->aCotacoes;
  }

  /**
   * @param CotacaoItem $oCotacao
   */
  public function adicionarCotacao(CotacaoItem $oCotacao) {
    $this->aCotacoes[] = $oCotacao;
  }

  /**
   * @return integer
   */
  public function getCodigo() {
    return $this->iCodigo;
  }

  /**
   * @param integer $iCodigo
   */
  public function setCodigo($iCodigo) {
    $this->iCodigo = $iCodigo;
  }

  /**
   * Retorna o Fornecedor
   * @return CgmFisico|CgmJuridico
   */
  public function getFornecedor() {
    return $this->oFornecedor;
  }

  /**
   * @param CgmBase|CgmFisico|CgmJuridico $oFornecedor
   */
  public function setFornecedor(CgmBase $oFornecedor) {
    $this->oFornecedor = $oFornecedor;
  }

  /**
   * Prazo de Entrega
   * @return DBDate
   */
  public function getPrazoEntrega() {
    return $this->oPrazoEntrega;
  }

  /**
   * Prazo de entrega dos materiais/ servico
   * @param DBDate $oPrazoEntrega
   */
  public function setPrazoEntrega(DBDate $oPrazoEntrega = null) {
    $this->oPrazoEntrega = $oPrazoEntrega;
  }

  /**
   * @return DBDate
   */
  public function getValidadeOrcamento() {
    return $this->oValidadeOrcamento;
  }

  /**
   * Data de validade do orçamento
   * @param DBDate $oValidadeOrcamento
   */
  public function setValidadeOrcamento(DBDate $oValidadeOrcamento = null) {
    $this->oValidadeOrcamento = $oValidadeOrcamento;
  }

  /**
   * Orcameto de compra
   * @param OrcamentoCompra $oOrcamento
   */
  public function setOrcamento(OrcamentoCompra $oOrcamento) {
    $this->oOrcamento = $oOrcamento;
  }

  /**
   * Persiste os dados do orcamento
   */
  public function salvar() {

    $oDaoOrcamForne                  = new cl_pcorcamforne();
    $oDaoOrcamForne->pc21_codorc     = $this->oOrcamento->getCodigo();
    $oDaoOrcamForne->pc21_numcgm     = $this->getFornecedor()->getCodigo();
    $oDaoOrcamForne->pc21_prazoent   = '';
    $oDaoOrcamForne->pc21_validadorc = '';
    if (!empty($this->oValidadeOrcamento)) {
      $oDaoOrcamForne->pc21_validadorc = $this->oValidadeOrcamento->getDate();
    }
    if (!empty($this->oPrazoEntrega)) {
      $oDaoOrcamForne->pc21_prazoent = $this->oPrazoEntrega->getDate();
    }

    if ($this->getCodigo() == '') {

      $oDaoOrcamForne->incluir(null);
      $this->iCodigo = $oDaoOrcamForne->pc21_orcamforne;
    } else {

      $oDaoOrcamForne->pc21_orcamforne = $this->getCodigo();
      $oDaoOrcamForne->alterar($this->getCodigo());
    }
    $this->salvarCotacoes();
  }

  /**
   * Persiste as cotacoes do fornecedor
   */
  private function salvarCotacoes() {

    $oDaoOrcamVal = new cl_pcorcamval;
    $oDaoOrcamVal->excluir(null, null, "pc23_orcamforne={$this->getCodigo()}");
    foreach ($this->aCotacoes as $oCotacao) {

      $oDaoOrcamVal->pc23_valor              = $oCotacao->getValorTotal();
      $oDaoOrcamVal->pc23_quant              = $oCotacao->getQuantidade();
      $oDaoOrcamVal->pc23_vlrun              = $oCotacao->getValorUnitario();
      $oDaoOrcamVal->pc23_orcamforne         = $this->getCodigo();
      $oDaoOrcamVal->pc23_orcamitem          = $oCotacao->getItem()->getCodigo();
      $oDaoOrcamVal->pc23_percentualdesconto = $oCotacao->getValorDesconto();
      $oDaoOrcamVal->incluir($this->getCodigo(), $oCotacao->getItem()->getCodigo());
    }
  }
}