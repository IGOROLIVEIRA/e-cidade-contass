<?php

require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
require_once "libs/db_sessoes.php";
require_once "libs/db_usuariosonline.php";
require_once "dbforms/db_funcoes.php";
require_once("classes/db_condataconf_classe.php");
require_once("model/contrato/apostilamento/Command/UpdateApostilamentoCommand.model.php");
require_once("model/contrato/apostilamento/Command/UpdateAcordoItemCommand.model.php");
require_once("model/contrato/apostilamento/Command/ValidaAlteracaoApostilamentoCommand.model.php");
require_once("model/contrato/apostilamento/Command/ValidaDataApostilamentoCommand.model.php");

$oParam            = json_decode(str_replace("\\", "", $_POST["json"]));
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
            getItens($oParam, $oRetorno);
            break;

        case "processarApostilamento":

            $oContrato = AcordoRepository::getByCodigo($oParam->iAcordo);

            $validaDatas =  new  ValidaDataApostilamentoCommand();
            $validaDatas->execute(
                $oParam->oApostila->datareferencia,
                $oParam->oApostila->dataapostila,
                $oParam->validaDtApostila,
                $oContrato,
                $oRetorno
            );

            $oContrato->apostilar($oParam->aItens, $oParam->oApostila, $oParam->datainicial, $oParam->datafinal, $oParam->aSelecionados, $oParam->oApostila->datareferencia);
            break;

        case "getleilicitacao":
            $sSQL = "select l20_leidalicitacao  from liclicita
            inner join acordo on
                acordo.ac16_licitacao = liclicita.l20_codigo
            where
            acordo.ac16_origem = 2
            and acordo.ac16_sequencial = $oParam->licitacao";


            $rsResult       = db_query($sSQL);
            $leilicitacao = db_utils::fieldsMemory($rsResult, 0);

            $oRetorno->lei = $leilicitacao->l20_leidalicitacao;

            break;

        case "getUnidades":
            $oDaoMatUnid  = db_utils::getDao("matunid");
            $sSqlUnidades = $oDaoMatUnid->sql_query_file(
                null,
                "m61_codmatunid,substr(m61_descr,1,20) as m61_descr",
                "m61_descr"
            );
            $rsUnidades      = $oDaoMatUnid->sql_record($sSqlUnidades);
            $iNumRowsUnidade = $oDaoMatUnid->numrows;
            for ($i = 0; $i < $iNumRowsUnidade; $i++) {

                $oUnidade = db_utils::fieldsMemory($rsUnidades, $i);
                $aUnidades[] = $oUnidade;
            }
            $oRetorno->itens = $aUnidades;
            break;
        case 'getDadosAlteracao':

            $validaAlterecao = new ValidaAlteracaoApostilamentoCommand;
            $validaAlterecao->execute($oParam->iAcordo);

            $tiposalteracaoapostila = array('15'=>1,'16'=>2,'17'=>3);

            $oDaoAcordoItem  = db_utils::getDao("acordoitem");
            $sSqlItens = $oDaoAcordoItem->getItemsApostilaUltPosicao($oParam->iAcordo);
            $result = $oDaoAcordoItem->sql_record($sSqlItens);

            if ($oDaoAcordoItem->erro_status == "0") {
                throw new Exception($oDaoAcordoItem->erro_msg);
            }

            $record = db_utils::fieldsmemory($result, 0);
            $oDadosAcordo = new stdClass();
            $oDadosAcordo->si03_sequencial = $record->si03_sequencial;
            $oDadosAcordo->si03_tipoapostila = $record->si03_tipoapostila;
            $oDadosAcordo->si03_tipoalteracaoapostila = $tiposalteracaoapostila[$record->si03_tipoalteracaoapostila];
            $oDadosAcordo->ac26_numeroapostilamento = $record->ac26_numeroapostilamento;
            $date = new DateTime( $record->si03_dataapostila );
            $oDadosAcordo->si03_dataapostila = $date->format( 'd/m/Y' );
            $oDadosAcordo->si03_percentualreajuste = $record->si03_percentualreajuste;
            $oDadosAcordo->si03_indicereajuste = $record->si03_indicereajuste;
            $oDadosAcordo->si03_justificativa = utf8_encode($record->si03_justificativa);
            $date = new DateTime( $record->si03_datareferencia );
            $oDadosAcordo->si03_datareferencia = $date->format( 'd/m/Y' );
            $oDadosAcordo->si03_descrapostila = utf8_encode($record->si03_descrapostila);
            $oDadosAcordo->si03_descrapostila = utf8_encode($record->si03_descrapostila);
            $oDadosAcordo->ac26_descricaoreajuste = utf8_encode($record->ac26_descricaoreajuste);
            $oDadosAcordo->ac26_criterioreajuste = $record->ac26_criterioreajuste;
            $oRetorno->dadosAcordo = $oDadosAcordo;
            getItens($oParam, $oRetorno);
            break;

        case 'updateApostilamento':
            $oContrato = AcordoRepository::getByCodigo($oParam->iAcordo);

            $validaDatas =  new  ValidaDataApostilamentoCommand();
            $validaDatas->execute(
                $oParam->apostilamento->si03_datareferencia,
                $oParam->apostilamento->si03_dataapostila,
                $oParam->validaDtApostila,
                $oContrato,
                $oRetorno
            );

            $updateApostilamento = new UpdateApostilamentoCommand;
            $updateApostilamento->execute($oParam->apostilamento, $oParam->iAcordo);

            if (!empty($oParam->itens)) {
                $updateAcordoItem = new UpdateAcordoItemCommand;
                $updateAcordoItem->execute(
                    $oParam->itens,
                    $oParam->iAcordo,
                    $oParam->apostilamento->si03_sequencial
                );
            }

            break;

            case "getLeiAndOrigem":
                $sSQL = "select l20_leidalicitacao,ac16_tipoorigem from liclicita
                inner join acordo on
                    acordo.ac16_licitacao = liclicita.l20_codigo
                where acordo.ac16_sequencial = $oParam->licitacao";
    
                $rsLeiAndOrigem     = db_query($sSQL);
                $oLeiAndOrigem = db_utils::fieldsMemory($rsLeiAndOrigem, 0);
    
                $oRetorno->lei = $oLeiAndOrigem->l20_leidalicitacao;
                $oRetorno->tipoorigem = $oLeiAndOrigem->ac16_tipoorigem;
    
                break;
    }

    db_fim_transacao(false);
} catch (Exception $eErro) {

    db_fim_transacao(true);
    $oRetorno->erro  = true;
    $oRetorno->message = urlencode($eErro->getMessage());
}

function getItens($oParam, $oRetorno)
{
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

        foreach ($oItemPosicao->getDotacoes() as $oDotacao) {
            if ($oItem->servico && $oItem->controlaquantidade == "f") {
                $iQuantDot =  1;
                $nValorDot = $oDotacao->valor - $oDotacao->executado;
            } else {
                $iQuantDot = $oDotacao->quantidade - ($oDotacao->executado / $oItem->valorunitario);
                $nValorDot = $oDotacao->valor;
            }
            $oItem->dotacoes[] = (object) array(
                'dotacao' => $oDotacao->dotacao
            );
        }

        $aItens[] = $oItem;
    }
    $oRetorno->itens = $aItens;
}

echo json_encode($oRetorno);
