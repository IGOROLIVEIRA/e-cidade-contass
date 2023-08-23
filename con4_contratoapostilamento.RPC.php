<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
require_once "libs/db_sessoes.php";
require_once "libs/db_usuariosonline.php";
require_once "dbforms/db_funcoes.php";
require_once("classes/db_condataconf_classe.php");
require_once("classes/db_apostilamento_classe.php");

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
            $clcondataconf = new cl_condataconf;

            if ($sqlerro == false) {
                $anousu = db_getsession('DB_anousu');

                $sSQL = "select to_char(c99_datapat,'YYYY') c99_datapat
                        from condataconf
                          where c99_instit = " . db_getsession('DB_instit') . "
                            order by c99_anousu desc limit 1";

                $rsResult       = db_query($sSQL);
                $maxC99_datapat = db_utils::fieldsMemory($rsResult, 0)->c99_datapat;

                $sNSQL = "";
                if ($anousu > $maxC99_datapat) {
                    $sNSQL = $clcondataconf->sql_query_file($maxC99_datapat, db_getsession('DB_instit'), 'c99_datapat');
                } else {
                    $sNSQL = $clcondataconf->sql_query_file(db_getsession('DB_anousu'), db_getsession('DB_instit'), 'c99_datapat');
                }

                $result = db_query($sNSQL);
                $c99_datapat = db_utils::fieldsMemory($result, 0)->c99_datapat;

                $datareferencia = implode("-", array_reverse(explode("/", $oParam->oApostila->datareferencia)));


                if ($oParam->oApostila->datareferencia != "") {

                    if (substr($c99_datapat, 0, 4) == substr($datareferencia, 0, 4) && mb_substr($c99_datapat, 5, 2) == mb_substr($datareferencia, 5, 2)) {
                        throw new Exception('Usuário: A data de referência deverá ser no mês posterior ao mês da data inserida.');
                    }

                    if ($c99_datapat != "" && $datareferencia <= $c99_datapat) {
                        throw new Exception(' O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.');
                    }
                }

                $dateassinatura = implode("-", array_reverse(explode("/", $oParam->oApostila->dataapostila)));

                if ($dateassinatura != "" && $oParam->oApostila->datareferencia == "") {
                    if ($c99_datapat != "" && $dateassinatura <= $c99_datapat) {
                        $oRetorno->datareferencia = true;
                        throw new Exception(' O período já foi encerrado para envio do SICOM. Preencha o campo Data de Referência com uma data no mês subsequente.');
                    }
                }
            }
            $oContrato = AcordoRepository::getByCodigo($oParam->iAcordo);

            $anousu = db_getsession('DB_anousu');

            $sSQL = "select to_char(c99_datapat,'YYYY') c99_datapat
                    from condataconf
                      where c99_instit = " . db_getsession('DB_instit') . "
                        order by c99_anousu desc limit 1";

            $rsResult       = db_query($sSQL);
            $maxC99_datapat = db_utils::fieldsMemory($rsResult, 0)->c99_datapat;

            $sNSQL = "";
            if ($anousu > $maxC99_datapat) {
                $sNSQL = $clcondataconf->sql_query_file($maxC99_datapat, db_getsession('DB_instit'), 'c99_datapat');
            } else {
                $sNSQL = $clcondataconf->sql_query_file($anousu, db_getsession('DB_instit'), 'c99_datapat');
            }

            $result = db_query($sNSQL);
            $rsData = db_utils::fieldsMemory($result, 0)->c99_datapat;
            $c99_datapat = (implode("/",(array_reverse(explode("-",$rsData)))));
            $c99_datapat = DateTime::createFromFormat('d/m/Y', $c99_datapat);
            $datareferencia = DateTime::createFromFormat('d/m/Y', $oParam->oApostila->datareferencia);
            $dateApostila = DateTime::createFromFormat('d/m/Y', $oParam->oApostila->dataapostila);
            $dateAssinaturaContrato = DateTime::createFromFormat('d/m/Y', $oContrato->getDataAssinatura());

            if ($oParam->oApostila->datareferencia != "") {

                $datareferenciaapostila = implode("-", array_reverse(explode("/", $oParam->oApostila->datareferencia)));

                if (substr($rsData, 0, 4) == substr($datareferenciaapostila, 0, 4) && mb_substr($c99_datapat, 5, 2) == mb_substr($datareferenciaapostila, 5, 2)) {
                    throw new Exception('Usuário: A data de referência deverá ser no mês posterior ao mês da data inserida.');
                }

                if ($c99_datapat != "" && $datareferencia <= $c99_datapat) {
                    throw new Exception(' O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.');
                }
            }

            if ($rsData != "" && $dateApostila <= $c99_datapat) {
                $oRetorno->datareferencia = true;
                throw new Exception(' O período já foi encerrado para envio do SICOM. Preencha o campo Data de Referência com uma data no mês subsequente.');
            }

            if($dateApostila < $dateAssinaturaContrato){
                throw new Exception('Usuário: A data da apostila não pode ser anterior a data de assinatura do contrato. Assinatura do contrato: ' . $oContrato->getDataAssinatura());
            }

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
        case 'getItensAlteracao':
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
                $oDadosAcordo->si03_dataapostila = $record->si03_dataapostila;
                $oDadosAcordo->si03_descrapostila = utf8_encode($record->si03_descrapostila);
                $oRetorno->dadosAcordo = $oDadosAcordo;

            break;

        case 'updateApostilamento':
            $tiposalteracaoapostila = array('1'=>15,'2'=>16,'3'=>17);

            $oDaoApostilamento  = new cl_apostilamento;
            $tipoalteracaoapostila = $oParam->apostilamento->si03_tipoalteracaoapostila;

            $oDaoApostilamento->si03_sequencial = $oParam->apostilamento->si03_sequencial;
            $oDaoApostilamento->si03_tipoapostila = $oParam->apostilamento->si03_tipoapostila;
            $oDaoApostilamento->si03_tipoalteracaoapostila = $tiposalteracaoapostila[$tipoalteracaoapostila];
            $oDaoApostilamento->si03_numapostilamento = $oParam->apostilamento->si03_numapostilamento;
            $oDaoApostilamento->si03_dataapostila = $oParam->apostilamento->si03_dataapostila;
            $oDaoApostilamento->si03_descrapostila = $oParam->apostilamento->si03_descrapostila;

            $oDaoApostilamento->alterar($oDaoApostilamento->si03_sequencial);

            if ($oDaoApostilamento->erro_status === 0) {
                throw new Exception($oDaoApostilamento->erro_msg);
            }

            foreach ($oParam->itens as $item) {
                $oDaoAcordoItem  = db_utils::getDao("acordoitem");
                $oDaoAcordoItem->ac20_valorunitario = $item->valorunitario;
                $oDaoAcordoItem->ac20_valortotal = $item->valorunitario * $item->quantidade;

                $oDaoAcordoItem->updateByApostilamento(
                    $oParam->iAcordo,
                    $item->codigoitem,
                    $oDaoApostilamento->si03_sequencial
                );

                if ($oDaoAcordoItem->erro_status == "0") {
                    throw new Exception($oDaoAcordoItem->erro_msg);
                }
            }

            break;
    }

    db_fim_transacao(false);
} catch (Exception $eErro) {

    db_fim_transacao(true);
    $oRetorno->erro  = true;
    $oRetorno->message = urlencode($eErro->getMessage());
}

echo json_encode($oRetorno);
