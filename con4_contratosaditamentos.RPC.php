
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
require_once("libs/JSON.php");
require_once("classes/db_condataconf_classe.php");

$oJson             = new services_json();

//$oParam            = json_decode(str_replace("\\", "", $_POST["json"]));
$oParam           = $oJson->decode(str_replace("\\", "", $_POST["json"]));

$oRetorno          = new stdClass();
$oRetorno->erro    = false;
$oRetorno->message = '';

try {

    db_inicio_transacao();

    switch ($oParam->exec) {

            /**
         * Pesquisa as posicoes do acordo
         */
        case "getItensAditar":

            $oContrato  = AcordoRepository::getByCodigo($oParam->iAcordo);

            $oPosicao                    = $oContrato->getUltimaPosicao(true);
            $oRetorno->tipocontrato      = $oContrato->getOrigem();
            $oRetorno->datainicial       = $oContrato->getDataInicial();
            $oRetorno->datafinal         = $oContrato->getDataFinal();
            $oRetorno->valores           = $oContrato->getValoresItens();
            $oRetorno->seqaditivo        = $oContrato->getProximoNumeroAditivo($oParam->iAcordo);
            $oAditivo = db_utils::getDao('acordoposicaoaditamento');
            $oResult = $oAditivo->sql_query(null, "*", null, "ac16_sequencial={$oParam->iAcordo}");
            //echo $oResult;
            $oResult = $oAditivo->sql_record($oResult);
            $oResult = db_utils::getColectionByRecord($oResult);

            $oRetorno->infoaditivo       = $oResult;

            $aItens = array();


            $oParamC = db_utils::getDao('parametroscontratos');
            $oParamC = $oParamC->sql_query(null, '*');
            $oParamC = db_query($oParamC);
            $oParamC = db_utils::fieldsMemory($oParamC);
            $oParamC = $oParamC->pc01_liberarcadastrosemvigencia;
            if ($oParamC == 't') {
            }
            foreach ($oPosicao->getItens() as $oItemPosicao) {

                $oItem                 = new stdClass();

                $oItem->codigo         = $oItemPosicao->getCodigo();
                $oItem->codigoitem     = $oItemPosicao->getMaterial()->getMaterial();
                $oItem->elemento       = $oItemPosicao->getDesdobramento();
                $oItem->descricaoitem  = $oItemPosicao->getMaterial()->getDescricao();
                $oItem->valorunitario  = $oItemPosicao->getValorUnitario();
                $oItem->quantidade     = $oItemPosicao->getQuantidadeAtualizadaRenovacao();
                $oItem->valoraditado   = $oItemPosicao->getValorAditado(); //OC5304
                $oItem->quantiaditada  = $oItemPosicao->getQuantiAditada(); //OC5304
                $oItem->valor          = $oItemPosicao->getValorAtualizadoRenovacao();
                $aItemPosicao          = $oItemPosicao->getPeriodosItem();
                if ($oParamC == 't') {
                    if ($aItemPosicao[0]->dtDataInicial == null || $aItemPosicao[0]->dtDataInicial == "") {
                        $oItem->periodoini = $oContrato->getDataInicial();
                    } else {
                        $oItem->periodoini = $aItemPosicao[0]->dtDataInicial;
                    }
                    if ($aItemPosicao[0]->dtDataFinal == null || $aItemPosicao[0]->dtDataFinal == "") {
                        $oItem->periodofim = $oContrato->getDataFinal();
                    } else {
                        $oItem->periodofim = $aItemPosicao[0]->dtDataFinal;
                    }
                } else {
                    $oItem->periodoini = $aItemPosicao[0]->dtDataInicial;
                    $oItem->periodofim = $aItemPosicao[0]->dtDataFinal;
                }
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
            //print_r($oRetorno);
            break;

        case "processarAditamento":

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
                $dateassinatura = implode("-", array_reverse(explode("/", $oParam->dataassinatura)));

                if ($dateassinatura != "") {
                    if ($c99_datapat != "" && $dateassinatura <= $c99_datapat) {
                        throw new Exception(' O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.');
                    }
                }
            }

            $oAditivo = db_utils::getDao('acordoposicaoaditamento');
            $oResult = $oAditivo->sql_query(null, "*", 'ac35_sequencial', "ac35_dataassinaturatermoaditivo is null and ac16_sequencial={$oParam->iAcordo}");
            // echo $oResult;
            $oResult = $oAditivo->sql_record($oResult);

            if (count(db_utils::getColectionByRecord($oResult)) > 0) {
                throw new Exception('Este acordo possui aditamentos sem assinatura.');
            }

            $oContrato = AcordoRepository::getByCodigo($oParam->iAcordo); //var_dump($oParam->sVigenciaalterada);
            $oContrato->aditar($oParam->aItens, $oParam->tipoaditamento, $oParam->datainicial, $oParam->datafinal, $oParam->sNumeroAditamento, $oParam->dataassinatura, $oParam->datapublicacao, $oParam->descricaoalteracao, $oParam->veiculodivulgacao, $oParam->tipoalteracaoaditivo, $oParam->aSelecionados, $oParam->sVigenciaalterada, $oParam->lProvidencia);

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
        case "salvaAssinatura":

            $clcondataconf = new cl_condataconf;

            if ($sqlerro == false) {
                $result = db_query($clcondataconf->sql_query_file(db_getsession('DB_anousu'), db_getsession('DB_instit')));
                $c99_datapat = db_utils::fieldsMemory($result, 0)->c99_datapat;
                $dateassinatura = implode("-", array_reverse(explode("/", $oParam->sData)));

                if ($dateassinatura != "") {
                    if ($c99_datapat != "" && $dateassinatura <= $c99_datapat) {
                        throw new Exception(' O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.');
                    }
                }
            }

            $oAditivo = db_utils::getDao('acordoposicaoaditamento');
            //seta variaveis

            $iAcordo = $oParam->iAcordo;
            $iCodigoAditivo = $oParam->iCodigoAditivo;
            $sData = $oParam->sData;
            $sDataPublicacao = $oParam->sDataPublicacao;
            $sVeiculoDivulgacao = $oParam->sVeiculoDivulgacao;
            //var_dump($oParam);
            $sData = str_replace("/", "-", $sData);
            $sData = date('Y-m-d', strtotime($sData));
            $sDataPublicacao = str_replace("/", "-", $sDataPublicacao);
            $sDataPublicacao = date('Y-m-d', strtotime($sDataPublicacao));

            //
            $oAditivo->ac35_sequencial = $iCodigoAditivo;
            $oAditivo->ac35_dataassinaturatermoaditivo = $sData;
            $oAditivo->ac35_datapublicacao = $sDataPublicacao;
            $oAditivo->ac35_veiculodivulgacao = $sVeiculoDivulgacao;

            $oAditivo->alterar($iCodigoAditivo);
            if ($oAditivo->erro_status == 0) {
                throw new Exception($oAditivo->erro_msg);
            } else {
                $oRetorno->message = "Assinatura salva com sucesso";
            }


            break;
    }

    db_fim_transacao(false);
} catch (Exception $eErro) {

    db_fim_transacao(true);
    $oRetorno->erro  = true;
    $oRetorno->message = urlencode($eErro->getMessage());
}
echo $oJson->encode($oRetorno);
//echo json_encode($oRetorno);
