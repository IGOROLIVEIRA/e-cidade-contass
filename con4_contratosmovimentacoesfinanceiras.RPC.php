<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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

require_once("model/Acordo.model.php");
require_once("model/AcordoPosicao.model.php");
require_once("model/AcordoHomologacao.model.php");
require_once("model/AcordoAssinatura.model.php");
require_once("model/AcordoAnulacao.model.php");
require_once('model/AcordoComissao.model.php');
require_once('model/AcordoItem.model.php');
require_once('model/AcordoComissaoMembro.model.php');
require_once("model/AcordoPenalidade.model.php");
require_once("model/AcordoGarantia.model.php");
require_once("model/CgmFactory.model.php");
require_once('model/CgmBase.model.php');
require_once('model/CgmFisico.model.php');
require_once('model/CgmJuridico.model.php');
require_once('model/Dotacao.model.php');
require_once("model/MaterialCompras.model.php");
require_once("model/empenho/AutorizacaoEmpenho.model.php");
require_once("model/AcordoPosicao.model.php");
require_once("model/licitacao.model.php");
require_once("model/ProcessoCompras.model.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_sessoes.php");
$oJson    = new services_json();
$oRetorno = new stdClass();
$oParam   = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\", "", $_POST["json"])));

$oRetorno->status   = 1;
$oRetorno->message  = '';
$oRetorno->itens    = array();
if (isset($oParam->observacao)) {
	$sObservacao = utf8_decode($oParam->observacao);
}

switch($oParam->exec) {

  /*
   * Pesquisa as posicoes do acordo
   */
  case "getPosicoesAcordo":

    $lGeraAutorizacao = false;
    if (!empty($oParam->lGeracaoAutorizacao)) {
      $lGeraAutorizacao = true;
    }

     if (isset ($_SESSION["oContrato"])) {
       unset($_SESSION["oContrato"]);
     }
     $oContrato              = new Acordo($oParam->iAcordo);
     $_SESSION["oContrato"]  = $oContrato;
     $aPosicoes              = $oContrato->getPosicoes();
     $oRetorno->posicoes     = array();
     $oRetorno->tipocontrato = $oContrato->getOrigem();
     foreach ($aPosicoes as $oPosicaoContrato) {

       $oPosicao        = new stdClass();
       $lOrigemEmpenho = false;
       if ($oContrato->getOrigem() == Acordo::ORIGEM_EMPENHO) {
         $lOrigemEmpenho = true;
       }

       if ($oPosicaoContrato->getTipo() == AcordoPosicao::TIPO_VIGENCIA) {
         continue;
       }
       $iTipoPosicao =  $oPosicaoContrato->getTipo();

       /**
        * Mostrará apenas as posições de tipo inclusão ou vigência, para acordos de origem empenho
        */
       if ($lGeraAutorizacao && $lOrigemEmpenho && ($iTipoPosicao == AcordoPosicao::TIPO_INCLUSAO || $iTipoPosicao == AcordoPosicao::TIPO_VIGENCIA) ) {
         continue;
       }

       $oPosicao->codigo         = $oPosicaoContrato->getCodigo();
       $oPosicao->data           = $oPosicaoContrato->getData();
       $oPosicao->tipo           = $oPosicaoContrato->getTipo();
       $oPosicao->numerocontrato = $oContrato->getGrupo()." - ".$oContrato->getNumero()."/".$oContrato->getAno();
       $oPosicao->descricaotipo  = urlencode($oPosicaoContrato->getDescricaoTipo());
       $oPosicao->numero         = (string)"".str_pad($oPosicaoContrato->getNumero(), "0", 7)."";
       $oPosicao->emergencial    = urlencode($oPosicaoContrato->isEmergencial()?"Sim":"Não");
       array_push($oRetorno->posicoes, $oPosicao);

     }

    break;

    case "getAditamentos":

     if (isset ($_SESSION["oContrato"])) {
       unset($_SESSION["oContrato"]);
     }
     $oContrato              = new Acordo($oParam->iAcordo);
     $_SESSION["oContrato"]  = $oContrato;
     $aPosicoes              = $oContrato->getPosicoes();
     $oRetorno->posicoes     = array();
     $oRetorno->tipocontrato = $oContrato->getOrigem();

     foreach ($aPosicoes as $oPosicaoContrato) {

       $oPosicao        = new stdClass();

       if ($oPosicaoContrato->getTipo() == AcordoPosicao::TIPO_INCLUSAO) {
         continue;
       }
       $iTipoPosicao =  $oPosicaoContrato->getTipo();

       $oPosicao->codigo         = $oPosicaoContrato->getCodigo();
       $oPosicao->data           = $oPosicaoContrato->getData();
       $oPosicao->tipo           = $oPosicaoContrato->getTipo();
       $oPosicao->numerocontrato = $oContrato->getGrupo()." - ".$oContrato->getNumero()."/".$oContrato->getAno();
       $oPosicao->descricaotipo  = urlencode($oPosicaoContrato->getDescricaoTipo());
       $oPosicao->numero         = (string)"".str_pad($oPosicaoContrato->getNumero(), "0", 7)."";
       $oPosicao->emergencial    = urlencode($oPosicaoContrato->isEmergencial()?"Sim":"Não");
       array_push($oRetorno->posicoes, $oPosicao);

     }

     if(count($oRetorno->posicoes) == 0 ){
         $oRetorno->status   = 2;
         $oRetorno->message  = urlencode('Nenhum aditamento encontrado!');
     }

    break;

  case "getPosicaoItens":

    if (isset ($_SESSION["oContrato"])) {

      $oContrato = $_SESSION["oContrato"];
      $aItens    = array();
      
      $oRetorno->iCasasDecimais = 2;
      $oRetorno->iOrigemContrato      = $oContrato->getOrigem();
      if ($oRetorno->iOrigemContrato == 2) {
        $aLicitacoesVinculadas = $oContrato->getLicitacoes();
        $oStdDados     = $aLicitacoesVinculadas[0]->getDados();
        $oRetorno->iCodigoLicitacao     = $oStdDados->l20_codigo;
        $oRetorno->iEdital              = $oStdDados->l20_edital;
        $oRetorno->iAnoLicitacao        = $oStdDados->l20_anousu;
        $oRetorno->iModalidadeLicitacao = $oStdDados->l20_codtipocom;
        $oRetorno->pc50_codcom          = $oStdDados->pc50_codcom;
        $oRetorno->l03_tipo             = $oStdDados->l03_tipo;
      }

      foreach ($oContrato->getPosicoes() as $oPosicaoContrato) {

        if ($oPosicaoContrato->getCodigo() == $oParam->iPosicao) {

          foreach ($oPosicaoContrato->getItens() as $oItem) {

              $oItemRetorno                      = new stdClass();
              $oItemRetorno->codigo              = $oItem->getCodigo();
              $oItemRetorno->material            = $oItem->getMaterial()->getDescricao();
              $oItemRetorno->codigomaterial      = urlencode($oItem->getMaterial()->getMaterial());
              $oItemRetorno->elemento            = $oItem->getElemento();
              $oItemRetorno->desdobramento       = $oItem->getDesdobramento();
              $oItemRetorno->valorunitario       = $oItem->getValorUnitario();
              $oItemRetorno->valortotal          = $oItem->getValorTotal();
              $oItemRetorno->quantidade          = $oItem->getQuantidade();
              $oItemRetorno->lControlaQuantidade = $oItem->getControlaQuantidade();

              $aCasasDecimais = explode(".", $oItemRetorno->valorunitario);
              if (count($aCasasDecimais) > 1 && strlen($aCasasDecimais[1]) > 2) {
                $oRetorno->iCasasDecimais = 3;
              }

              foreach ($oItem->getDotacoes() as $oDotacao) {

                $oDotacaoSaldo = new Dotacao($oDotacao->dotacao, $oDotacao->ano);
                $oDotacao->saldoexecutado = 0;;
                $oDotacao->valorexecutar  = 0;
                $oDotacao->saldodotacao   = $oDotacaoSaldo->getSaldoFinal();

              }
              $oItemRetorno->dotacoes       = $oItem->getDotacoes();
              $oItemRetorno->saldos         = $oItem->getSaldos();
              $oItemRetorno->servico        = $oItem->getMaterial()->isServico();
              $oRetorno->itens[]            = $oItemRetorno;
          }
          break;
        }
      }
    } else {

      $oRetorno->status   = 2;
      $oRetorno->message  = urlencode('Inconsistencia na consulta pesquise novamente os dados do acordo');
    }
    break;

  case "processarAutorizacoes":

    $oContrato = $_SESSION["oContrato"];

    try {

      db_inicio_transacao();

      if ( !empty($oParam->dados->resumo) ) {
        $oParam->dados->resumo = db_stdClass::normalizeStringJsonEscapeString($oParam->dados->resumo);
      }

      if ( !empty($oParam->dados->pagamento) ) {
        $oParam->dados->pagamento = db_stdClass::normalizeStringJsonEscapeString($oParam->dados->pagamento);
      }

      foreach ($oParam->aItens as $iItem => $oItem) {

        $nTotalExecutar = 0;

        $oAcordoItem     = new AcordoItem($oItem->codigo);
        $nValorTotalItem = $oAcordoItem->getValorTotal();

        foreach ($oItem->dotacoes as $iDotacoes => $oDotacoes) {

          $nTotalExecutar += $oDotacoes->valorexecutar;
        }

        if (round($nTotalExecutar, 2) > round($nValorTotalItem, 2)) {

          $nExecutar  = trim(db_formatar($nTotalExecutar , "f") );
          $nTotalItem = trim(db_formatar($nValorTotalItem , "f"));
          throw new BusinessException( " Valor a executar {$nExecutar} maior que o total do item {$nTotalItem}. " ) ;
        }
      }

      $oRetorno->itens  = $oContrato->processarAutorizacoes($oParam->aItens, $oParam->lProcessar, $oParam->dados);

      db_fim_transacao(false);

    } catch (Exception $eErro) {

      db_fim_transacao(true);
      $oRetorno->status = 2;
      $oRetorno->message = urlencode($eErro->getMessage());
    }

   break;

    case "processarExclusaoPosicao":

    $oContrato = $_SESSION["oContrato"];

    try {
      db_inicio_transacao();

      arsort($oParam->aPosicoes);
      foreach ($oParam->aPosicoes as $oPosicao) {

          if($oPosicao->codigo == $oContrato->getUltimaPosicao(true)->getCodigo()) {
              $oAcordoPosicao = new AcordoPosicao($oPosicao->codigo);
              $oAcordoPosicao->remover();
          } else {
              throw new BusinessException( " Não é possível excluir uma aditamente que não seja o último. Para excluir um aditamento, faça a partir do último " ) ;
          }

      }


      db_fim_transacao(false);
        $oRetorno->status = 2;
        $oRetorno->message = urlencode('Aditamento excluído com sucesso!');
    } catch (Exception $eErro) {

      db_fim_transacao(true);
      $oRetorno->status = 2;
      $oRetorno->message = urlencode($eErro->getMessage());
    }

   break;

   case "getAutorizacoesAcordo":

     if (isset ($_SESSION["oContrato"])) {
       unset($_SESSION["oContrato"]);
     }

     $oContrato    = new Acordo($oParam->iAcordo);
     $_SESSION["oContrato"]  = $oContrato;
     $oRetorno->autorizacoes = $oContrato->getAutorizacoes();
     break;

   case "anularAutorizacoes":

     $oContrato = $_SESSION["oContrato"];
     try {

       db_inicio_transacao();
       foreach ($oParam->aAutorizacoes as $iAutorizacao) {
         $oContrato->anularAutorizacao($iAutorizacao);
       }
       db_fim_transacao(false);
     } catch (Exception $eErro) {

       db_fim_transacao(true);
       $oRetorno->status  = 2;
       $oRetorno->message = urlencode($eErro->getMessage());
     }

     break;

   case "salvarMovimentacaoEmpenhoManual":

     $oContrato = $_SESSION["oContrato"];
     $oUltimaPosicao = $oContrato->getUltimaPosicao();
     $oRetorno->iPosicao = $oUltimaPosicao->getCodigo();
     try {
       db_inicio_transacao();
       foreach ($oParam->aItens as $oItem) {

         $oItemContrato = $oUltimaPosicao->getItemByCodigo($oItem->codigo);
         $oItemContrato->baixarMovimentacaoManual(1,$oItem->quantidadeexecutada, $oItem->valorexecutado);
       }
       db_fim_transacao(false);
     } catch (Exception $eErro) {

       db_fim_transacao(true);
       $oRetorno->status  = 2;
       $oRetorno->message = urlencode($eErro->getMessage());

     }
   break;

   case 'getDadosAcordo' :

     $oAcordo = new Acordo($oParam->iCodigoAcordo);
     $oRetorno->sResumoAcordo = urlencode($oAcordo->getObjeto());

   break;
}

echo $oJson->encode($oRetorno);
?>