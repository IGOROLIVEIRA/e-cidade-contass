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

require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
require_once "libs/db_sessoes.php";
require_once "libs/db_usuariosonline.php";
require_once "dbforms/db_funcoes.php";
require_once "libs/JSON.php";

$oJson                  = new services_json();
$oParam                 = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno               = new stdClass();
$oRetorno->erro         = false;
$oRetorno->sMessage     = '';

$sMensagens = "patrimonial.licitacao.lic4_lancamentovalororcamento.";

try {

  db_inicio_transacao(true);
  switch ($oParam->sExecucao) {

    case 'getDadosOrcamento':

      $oRetorno->fornecedores = array();
      $oRetorno->itens        = array();
      $oRetorno->temcotacao   = false;

      $oOrcamento    = new OrcamentoCompra($oParam->codigo_orcamento);

      $oRetorno->temcotacao = $oOrcamento->temCotacao();
      $aFornecedores        = $oOrcamento->getFornecedores();
      foreach ($aFornecedores as $oFornecedores) {

        $oDadosFornecedor         = new stdClass();
        $oDadosFornecedor->codigo = $oFornecedores->getCodigo();
        $oDadosFornecedor->nome   = urlencode($oFornecedores->getNome());
        $oRetorno->fornecedores[] = $oDadosFornecedor;
      }

      $aItens = $oOrcamento->getItens();
      foreach ($aItens as $oItem) {

        $oDadosItem            = new stdClass();
        $oDadosItem->ordem     = $oItem->getItemOrigem()->getOrdem();
        $oDadosItem->codigo    = $oItem->getCodigo();
        $oDadosItem->descricao = $oItem->getItemSolicitacao()->getDescricaoMaterial();
        $oDadosItem->valor     = $oItem->getItemSolicitacao()->getValorUnitario();
        $oRetorno->itens[]     = $oDadosItem;
      }

      usort($oRetorno->itens, function($oItem1, $oItem2) {
        return $oItem1->ordem > $oItem2->ordem;
      });
      break;

    case 'getCotacoesFornecedor':

      $oOrcamento  = new OrcamentoCompra($oParam->codigo_orcamento);

      $oFornecedor          = CgmFactory::getInstanceByCgm($oParam->fornecedor);
      $oOrcamentoFornecedor = $oOrcamento->getOrcamentoDoFornecedor($oFornecedor);
      $aItens               = $oOrcamento->getItens();

      $oRetorno->temcotacao        = $oOrcamento->temCotacao();
      $oRetorno->cotacoes          = array();
      $oRetorno->prazoentrega      = '';
      $oRetorno->validadeorcamento = '';

      if ($oOrcamentoFornecedor->getPrazoEntrega() != '') {
        $oRetorno->prazoentrega = $oOrcamentoFornecedor->getPrazoEntrega()->getDate(DBDate::DATA_PTBR);
      }
      if ($oOrcamentoFornecedor->getValidadeOrcamento() != '') {
        $oRetorno->validadeorcamento = $oOrcamentoFornecedor->getValidadeOrcamento()->getDate(DBDate::DATA_PTBR);
      }
      foreach ($aItens as $oItem) {

        $oCotacaoFornecedor = $oItem->getCotacaoDoFornecedor($oFornecedor);
        if (!empty($oCotacaoFornecedor)) {

          $oDadosCotacao             = new stdClass();
          $oDadosCotacao->item       = $oCotacaoFornecedor->getItem()->getItemOrigem()->getOrdem();
          $oDadosCotacao->percentual = $oCotacaoFornecedor->getValorDesconto();

          $oRetorno->cotacoes[$oDadosCotacao->item] = $oDadosCotacao;
        }
      }

      break;

    case 'salvarCotacoes':

      $oOrcamento           = new OrcamentoCompra($oParam->codigo_orcamento);
      $oFornecedor          = CgmFactory::getInstanceByCgm($oParam->fornecedor);
      $oOrcamentoFornecedor = $oOrcamento->getOrcamentoDoFornecedor($oFornecedor);
      $oOrcamentoFornecedor->setPrazoEntrega(null);
      $oOrcamentoFornecedor->setValidadeOrcamento(null);
      if (!empty($oParam->prazoentrega)) {
        $oOrcamentoFornecedor->setPrazoEntrega(new DBDate($oParam->prazoentrega));
      }
      if (!empty($oParam->validadeorcamento)) {
        $oOrcamentoFornecedor->setValidadeOrcamento(new DBDate($oParam->validadeorcamento));
      }

      foreach ($oParam->cotacoes as $oCotacao) {

        $nValorCotado = (($oCotacao->valor * $oCotacao->percentual)/ 100);
        $oCotacaoItem = new CotacaoItem();
        $oCotacaoItem->setValorDesconto($oCotacao->percentual);
        $oCotacaoItem->setValorUnitario($oCotacao->valor - $nValorCotado);
        $oCotacaoItem->setQuantidade(1);
        $oCotacaoItem->setItem(new ItemOrcamento($oCotacao->item));
        $oOrcamentoFornecedor->adicionarCotacao($oCotacaoItem);
      }
      $oOrcamentoFornecedor->salvar();
      break;
  }
  db_fim_transacao(false);

} catch (Exception $eErro){

  db_fim_transacao(true);

  $oRetorno->erro     = true;
  $oRetorno->sMessage = urlencode($eErro->getMessage());
}
echo $oJson->encode($oRetorno);