<?php
require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
require_once "libs/db_sessoes.php";
require_once "libs/db_usuariosonline.php";
require_once "dbforms/db_funcoes.php";

$oParam            = json_decode(str_replace("\\","",$_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->erro    = false;
$oRetorno->message = '';

try {

  db_inicio_transacao();

  switch ($oParam->exec) {

    /**
     * Pesquisa as posicoes do acordo
     */
    case "getItens":

      $oContrato  = AcordoRepository::getByCodigo($oParam->iAcordo);

      $oPosicao                    = $oContrato->getUltimaPosicao(true);
      $oRetorno->tipocontrato      = $oContrato->getOrigem();
      $oRetorno->datainicial       = $oContrato->getDataInicial();
      $oRetorno->datafinal         = $oContrato->getDataFinal();
      $oRetorno->valores           = $oContrato->getValoresItens();
      $oRetorno->seqapostila       = $oContrato->getProximoNumeroApostila($oParam->iAcordo);

      $aItens = array();
      foreach ($oPosicao->getItens() as $oItemPosicao) {

        $oItem                 = new stdClass();

        $oItem->codigo         = $oItemPosicao->getCodigo();
        $oItem->codigoitem     = $oItemPosicao->getMaterial()->getMaterial();
        $oItem->elemento       = $oItemPosicao->getDesdobramento();
        $oItem->descricaoitem  = $oItemPosicao->getMaterial()->getDescricao();
        $oItem->valorunitario  = $oItemPosicao->getValorUnitario();
        $oItem->quantidade     = $oItemPosicao->getQuantidadeAtualizadaRenovacao();
        $oItem->valor          = $oItemPosicao->getValorAtualizadoRenovacao();
        $aItemPosicao = $oItemPosicao->getPeriodosItem();
        $oItem->periodoini     = $aItemPosicao[0]->dtDataInicial;
        $oItem->periodofim     = $aItemPosicao[0]->dtDataFinal;
        $oItem->servico        = $oItemPosicao->getMaterial()->isServico();
        $oItem->controlaquantidade = $oItemPosicao->getServicoQuantidade();
        $oItem->dotacoes       = array();

        /**
         * retornar saldo do item conforme autorizacoes
         */
        $oItemUltimoValor = $oItemPosicao->getSaldos();
        $oItem->qtdeanterior = $oItemUltimoValor->quantidadeautorizar;
        $oItem->vlunitanterior = $oItem->valorunitario;
        $oItem->quantidade = $oItemUltimoValor->quantidadeautorizar;

        /**
         * Caso seja servico e nao controlar quantidade, a quantidade padrao sera 1
         * e o valor sera o saldo a executar
         */
        if ($oItem->servico && $oItem->controlaquantidade == "f") {
          $oItem->quantidade     = 1;
          $oItem->qtdeanterior   = 1;
          $oItem->valor          = $oItemUltimoValor->valorautorizar;
          $oItem->vlunitanterior = $oItemUltimoValor->valorautorizar;
          $oItem->valorunitario  = $oItemUltimoValor->valorautorizar;
        }
        
        foreach($oItemPosicao->getDotacoes() as $oDotacao) {
          if ($oItem->servico && $oItem->controlaquantidade == "f") {
            $iQuantDot =  1;
            $nValorDot = $oDotacao->valor-$oDotacao->executado;
          } else {
            $iQuantDot = $oDotacao->quantidade-($oDotacao->executado/$oItem->valorunitario);
            $nValorDot = $oDotacao->valor;
          }
          $oItem->dotacoes[] = (object) array(
              'dotacao' => $oDotacao->dotacao,
              'quantidade' => $iQuantDot,
              'valor' => $nValorDot,
              'valororiginal' => $nValorDot
            );
        }

        $aItens[] = $oItem;
      }

      $oRetorno->itens = $aItens;
      break;

    case "processarApostilamento":

      $oContrato = AcordoRepository::getByCodigo($oParam->iAcordo);
      $oContrato->apostilar($oParam->aItens, $oParam->oApostila, $oParam->datainicial, $oParam->datafinal, $oParam->aSelecionados);
      break;

    case "getUnidades":

      $oDaoMatUnid  = db_utils::getDao("matunid");
      $sSqlUnidades = $oDaoMatUnid->sql_query_file( null,
                                                    "m61_codmatunid,substr(m61_descr,1,20) as m61_descr",
                                                    "m61_descr" );
      $rsUnidades      = $oDaoMatUnid->sql_record($sSqlUnidades);
      $iNumRowsUnidade = $oDaoMatUnid->numrows;
      for ($i = 0; $i < $iNumRowsUnidade; $i++) {

        $oUnidade = db_utils::fieldsMemory($rsUnidades, $i);
        $aUnidades[] = $oUnidade;
      }
      $oRetorno->itens = $aUnidades;
      break;

  }

  db_fim_transacao(false);

} catch (Exception $eErro) {

  db_fim_transacao (true);
  $oRetorno->erro  = true;
  $oRetorno->message = urlencode($eErro->getMessage());
}

echo json_encode($oRetorno);