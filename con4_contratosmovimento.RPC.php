<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");
require_once("dbforms/db_funcoes.php");
require_once("model/Acordo.model.php");
require_once("model/CgmBase.model.php");
require_once("model/CgmFactory.model.php");
require_once("model/CgmFisico.model.php");
require_once("model/CgmJuridico.model.php");
require_once("model/AcordoHomologacao.model.php");
require_once("model/AcordoComissao.model.php");
require_once("model/AcordoComissaoMembro.model.php");
require_once("model/AcordoAssinatura.model.php");
require_once("model/AcordoRescisao.model.php");
require_once("model/AcordoAnulacao.model.php");
require_once("model/AcordoPosicao.model.php");
require_once("model/AcordoItem.model.php");
require_once("model/contrato/AcordoLancamentoContabil.model.php");
require_once("model/licitacao.model.php");
require_once("model/Dotacao.model.php");
require_once("model/MaterialCompras.model.php");
require_once("std/DBDate.php");

$oJson    = new services_json();
$oRetorno = new stdClass();
$oParam   = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\", "", $_POST["json"])));

$oRetorno->status  = 1;

if (isset($oParam->observacao)) {
    $sObservacao = utf8_decode($oParam->observacao);
}

switch ($oParam->exec) {

        /*
   * Pesquisa homologação para o contrato
   */
    case "getDadosHomologacao":

        try {

            $oHomologacao        = new AcordoHomologacao($oParam->codigo);
            $oAcordo             = new Acordo($oHomologacao->getAcordo());
            $oRetorno->codigo    = $oHomologacao->getCodigo();
            $oRetorno->acordo    = $oAcordo->getCodigoAcordo();
            $oRetorno->descricao = urlencode($oAcordo->getResumoObjeto());
        } catch (Exception $eExeption) {

            $oRetorno->status = 2;
            $oRetorno->erro   = urlencode(str_replace("\\n", "\n", $eExeption->getMessage()));
        }

        break;

        /*
   * Incluir homologação para o contrato
   */
    case "homologarContrato":

        try {

            db_inicio_transacao();

            $oHomologacao = new AcordoHomologacao();
            $oHomologacao->setAcordo($oParam->acordo);
            $oHomologacao->setObservacao($sObservacao);
            $oHomologacao->save();
            $oAcordo                   = new Acordo($oParam->acordo);
            $oAcordoLancamentoContabil = new AcordoLancamentoContabil();
            $sHistorico = "Valor referente a homologação do Acordo: {$iCodigoAcordo}.";
            $oAcordoLancamentoContabil->registraControleContrato($oParam->acordo, $oAcordo->getValorContrato(), $sHistorico, $oHomologacao->getDataMovimento());

            db_fim_transacao(false);
        } catch (Exception $eExeption) {

            db_fim_transacao(true);
            $oRetorno->status = 2;
            $oRetorno->erro   = urlencode(str_replace("\\n", "\n", $eExeption->getMessage()));
        }

        break;

        /*
   * Cancelar homologação para o contrato
   */
    case "cancelarHomologacao":

        try {

            db_inicio_transacao();

            $oHomologacao = new AcordoHomologacao($oParam->codigo);
            $oHomologacao->setObservacao($sObservacao);
            $oHomologacao->cancelar();
            $oAcordo                   = new Acordo($oHomologacao->getAcordo());
            $oAcordoLancamentoContabil = new AcordoLancamentoContabil();
            $sHistorico = "Valor referente a Cancelamento homologação do Acordo: {$iCodigoAcordo}.";
            $oAcordoLancamentoContabil->anulaRegistroControleContrato($oAcordo->getCodigoAcordo(), $oAcordo->getValorContrato(), $sHistorico, $oHomologacao->getDataMovimento());

            db_fim_transacao(false);
        } catch (Exception $eExeption) {

            db_fim_transacao(true);
            $oRetorno->status = 2;
            $oRetorno->erro   = urlencode(str_replace("\\n", "\n", $eExeption->getMessage()));
        }

        break;

        /*
   * Pesquisa dados da assinatura
   */
    case "getDadosAssinatura":

        try {

            $oAssinatura             = new AcordoAssinatura($oParam->codigo);
            $oAcordo                 = new Acordo($oAssinatura->getAcordo());
            $oRetorno->codigo        = $oAssinatura->getCodigo();
            $oRetorno->acordo        = $oAcordo->getCodigoAcordo();
            $oRetorno->datamovimento = date("Y-m-d", db_getsession("DB_datausu"));
            $oRetorno->descricao     = urlencode($oAcordo->getResumoObjeto());
        } catch (Exception $eExeption) {

            db_fim_transacao(true);
            $oRetorno->status = 2;
            $oRetorno->erro   = urlencode(str_replace("\\n", "\n", $eExeption->getMessage()));
        }

        break;

        /*
   * Incluir assinatura para o contrato
   */
    case "assinarContrato":

        try {

            $clAcordoItem = new cl_acordoitem;
            $sSqlSomaItens = $clAcordoItem->sql_query('', 'sum(ac20_valortotal) as soma', '', 'ac16_sequencial = ' . $oParam->acordo);
            $rsSomaItens = $clAcordoItem->sql_record($sSqlSomaItens);
            $iSoma = db_utils::fieldsMemory($rsSomaItens, 0)->soma;

            $clAcordo = new cl_acordo;
            $clAcordo->ac16_valor = $iSoma;
            $clAcordo->alterar($oParam->acordo);

            $oDataMovimentacao = new DBDate($oParam->dtmovimentacao);
            $oDataPublicacao = new DBDate($oParam->dtpublicacao);

            db_inicio_transacao();
            $oAssinatura = new AcordoAssinatura();
            $oAssinatura->setAcordo($oParam->acordo);
            $oAssinatura->setDataMovimento($oDataMovimentacao->getDate());
            $oAssinatura->setDataPublicacao($oDataPublicacao->getDate());
            $oAssinatura->setVeiculoDivulgacao($oParam->veiculodivulgacao);
            $oAssinatura->setObservacao($sObservacao);
            $oAcordo = new Acordo($oParam->acordo);

            if (!$oAssinatura->verificaPeriodoPatrimonial()) {
                $lAcordoValido = false;
            }

            if ($oAcordo->getNaturezaAcordo($oParam->acordo) == "1") {
                if ($oAcordo->getObras($oParam->acordo) == null) {
                    $iLicitacao = $oAcordo->getLicitacao();
                    $oLicitacao = new licitacao($iLicitacao);
                    $iAnousu     = $oLicitacao->getAno();
                    $iModalidade = $oLicitacao->getNumeroLicitacao();
                    $iProcesso   = $oLicitacao->getEdital();
                    $oModalidade = $oLicitacao->getModalidade();
                    $sDescricaoMod = $oModalidade->getDescricao();
                    throw new Exception("Contrato de Natureza OBRAS E SERVIÇOS DE ENGENHARIA, sem Obra informada. Solicitar cadastro no módulo Obras para o processo Nº $iProcesso/$iAnousu $sDescricaoMod Nº $iModalidade/$iAnousu");
                }
            }

            if ($oDataPublicacao->getTimeStamp() < $oDataMovimentacao->getTimeStamp()) {
                throw new Exception("A data de assinatura do contrato não pode ser menor que a data de publicação.");
            }


            /*
       * Validações caso a origem do contrato seja Licitação
       * O sistema não deve permitir a inclusão de acordos quando a data de assinatura do acordo for anterior a data de homologação da licitação.
       * Para dispensa/inexigibilidade deve se validar a data de ratificação presente no cadastro de licitação
       */
            if ($oAcordo->getOrigem() == 2) {
                foreach ($oAcordo->getLicitacoes() as $oLicitacao) {
                    $bValidaDispensa = in_array($oLicitacao->getModalidade()->getCodigo(), array(9, 10)) ? true : false;
                    if (!$oAcordo->validaDataAssinatura($oLicitacao->getCodigo(), $oParam->dtmovimentacao, $bValidaDispensa)) {
                        $lAcordoValido = false;
                        throw new Exception("A data de assinatura do acordo não pode ser anterior a data de homologação da licitação.");
                    }
                }
            }

            if (strtotime($dtMovimento) > strtotime(str_replace("/", "-", $oAcordo->getDataFinal()))) {
                $lAcordoValido = false;
                throw new Exception("A data de assinatura do acordo {$oParam->dtmovimentacao} não pode ser posterior ao período de vigência do contrato {$oAcordo->getDataFinal()}.");
            }

            /**
             * Validação solicitada: não seja possível incluir assinatura de acordos que não tenha as penalidades e garantias cadastradas.?
             * @see OC 3495, 4408
             */

            if (count($oAcordo->getPenalidades()) < 2 || count($oAcordo->getGarantias()) == 0) {
                $lAcordoValido = false;
                throw new Exception("Não é permitido assinar um acordos que não tenha as penalidades e garantias cadastradas.");
            }

            /**
             * Validação soliciatada: Validar o sistema para que não seja possível assinar acordos de origem Manual que não tenha itens vinculados.
             * @see OC 3499
             */

            if ($oAcordo->getOrigem() == Acordo::ORIGEM_MANUAL && count($oAcordo->getItens()) == 0) {
                $lAcordoValido = false;
                throw new Exception("Acordo sem itens Cadastrados.");
            } else {
                $itens = $oAcordo->getItens();
                foreach ($itens as $item) {

                    if ($item->getPeriodosItem() == null) {
                        $lAcordoValido = false;
                        throw new Exception("Preencha as datas de previsão de execução dos ítens.");
                    }
                }
            }

            $oAssinatura->save();

            db_fim_transacao(false);
        } catch (Exception $eExeption) {

            db_fim_transacao(true);
            $oRetorno->status = 2;
            $oRetorno->erro   = urlencode(str_replace("\\n", "\n", $eExeption->getMessage()));
        }

        break;

        /*
   * Cancelamento da assinatura para o contrato
   */
    case "cancelarAssinatura":

        try {

            db_inicio_transacao();

            $oAssinatura = new AcordoAssinatura($oParam->codigo);

            if (!$oAssinatura->verificaPeriodoPatrimonial()) {
                $lAcordoValido = false;
            }
            $oAssinatura->setDataMovimento();
            $oAssinatura->setObservacao($sObservacao);
            $oAssinatura->cancelar();

            db_fim_transacao(false);
        } catch (Exception $eExeption) {

            db_fim_transacao(true);
            $oRetorno->status = 2;
            $oRetorno->erro   = urlencode(str_replace("\\n", "\n", $eExeption->getMessage()));
        }

        break;

        /*
   * Pesquisa recisão para o contrato
   */
    case "getDadosRescisao":

        try {

            $oRecisao                = new AcordoRescisao($oParam->codigo);
            $oAcordo                 = new Acordo($oRecisao->getAcordo());
            $oRetorno->codigo        = $oRecisao->getCodigo();
            $oRetorno->valorrescisao = $oAcordo->getValorRescisao();
            $oRetorno->acordo        = $oAcordo->getCodigoAcordo();

            $oRetorno->datamovimento = date("Y-m-d", db_getsession("DB_datausu"));
            $oRetorno->datamovimentoantiga = $oRecisao->getDataMovimento();
            $oRetorno->descricao     = urlencode($oAcordo->getResumoObjeto());
        } catch (Exception $eExeption) {

            db_fim_transacao(true);
            $oRetorno->status = 2;
            $oRetorno->erro   = urlencode(str_replace("\\n", "\n", $eExeption->getMessage()));
        }

        break;

        /*
   * Incluir recisão para o contrato
   */
    case "rescindirContrato":

        try {

            db_inicio_transacao();

            $oAcordo = new Acordo($oParam->acordo);

            $oRecisao = new AcordoRescisao();
            $oRecisao->setAcordo($oParam->acordo);
            $nValorRescisao = str_replace(',', '.', $oParam->valorrescisao);
            $dtMovimento = implode("-", array_reverse(explode("/", $oParam->dtmovimentacao)));
            $oRecisao->setDataMovimento($dtMovimento);
            $oRecisao->setObservacao($sObservacao);
            $oRecisao->setValorRescisao($nValorRescisao);

            if (!$oRecisao->verificaPeriodoPatrimonial()) {
                $lAcordoValido = false;
            }

            if ($oRecisao->getValorRescisao() > $oAcordo->getValorContrato()) {
                throw new Exception("O valor rescindido não pode ser maior que o valor do acordo.");
            }

            $oRecisao->save();

            $oAcordoLancamentoContabil = new AcordoLancamentoContabil();
            $sHistorico = "Valor referente a Recisão do Acordo: {$oAcordo->getCodigoAcordo()}.";
            $oAcordoLancamentoContabil->anulaRegistroControleContrato($oAcordo->getCodigoAcordo(), $nValorRescisao, $sHistorico, $oRecisao->getDataMovimento());

            db_fim_transacao(false);
        } catch (Exception $eExeption) {

            db_fim_transacao(true);
            $oRetorno->status = 2;
            $oRetorno->erro   = urlencode(str_replace("\\n", "\n", $eExeption->getMessage()));
        }

        break;

        /*
   * Cancelamento de recisão para o contrato
   */
    case "cancelarRescisao":

        try {

            db_inicio_transacao();
            $dtMovimento = implode("-", array_reverse(explode("/", $oParam->sData)));
            $oRecisao = new AcordoRescisao($oParam->codigo);
            $nValorRescisao = floatval(str_replace(',', '.', $oParam->valorrescisao));

            if (!$oRecisao->verificaPeriodoPatrimonial()) {
                $lAcordoValido = false;
            }

            $oRecisao->setDataMovimento();
            $oRecisao->setValorRescisao(0);
            $oRecisao->setObservacao($sObservacao);
            $oRecisao->cancelar();

            $oAcordo = new Acordo($oRecisao->getAcordo());
            $oAcordoLancamentoContabil = new AcordoLancamentoContabil();
            $sHistorico = "Valor referente a Cancelamento da Recisão do Acordo: {$oAcordo->getCodigoAcordo()}.";
            $oAcordoLancamentoContabil->registraControleContrato($oAcordo->getCodigoAcordo(), $nValorRescisao, $sHistorico, $dtMovimento);

            db_fim_transacao(false);
        } catch (Exception $eExeption) {

            db_fim_transacao(true);
            $oRetorno->status = 2;
            $oRetorno->erro   = urlencode(str_replace("\\n", "\n", $eExeption->getMessage()));
        }

        break;

        /*
   * Cancela cancelamento de recisão para o contrato
   */
    case "desfazerCancelarRecisao":

        try {

            db_inicio_transacao();

            $oRecisao = new AcordoRescisao($oParam->codigo);
            if (!$oRecisao->verificaPeriodoPatrimonial()) {
                $lAcordoValido = false;
            }
            $oRecisao->setObservacao($sObservacao);
            $oRecisao->setDataMovimento();
            $oRecisao->desfazerCancelamento();

            db_fim_transacao(false);
        } catch (Exception $eExeption) {

            db_fim_transacao(true);
            $oRetorno->status = 2;
            $oRetorno->erro   = urlencode(str_replace("\\n", "\n", $eExeption->getMessage()));
        }

        break;

        /*
   * Pesquisa anulação de contrato
   */
    case "getDadosAnulacao":

        try {

            $oAnulacao = new AcordoAnulacao($oParam->codigo);
            $oAcordo   = new Acordo($oAnulacao->getAcordo());
            $oRetorno->codigo        = $oAnulacao->getCodigo();
            $oRetorno->acordo        = $oAcordo->getCodigoAcordo();
            $oRetorno->datamovimento = date("Y-m-d", db_getsession("DB_datausu"));
            $oRetorno->descricao     = urlencode($oAcordo->getResumoObjeto());
        } catch (Exception $eExeption) {

            db_fim_transacao(true);
            $oRetorno->status = 2;
            $oRetorno->erro   = urlencode(str_replace("\\n", "\n", $eExeption->getMessage()));
        }

        break;

        /*
   * Incluir anulação de contrato
   */
    case "anularContrato":

        try {

            db_inicio_transacao();

            $oAnulacao = new AcordoAnulacao();
            $oAnulacao->setAcordo($oParam->acordo);
            $dtMovimento = implode("-", array_reverse(explode("/", $oParam->dtmovimentacao)));
            $oAnulacao->setDataMovimento($dtMovimento);
            $oAnulacao->setObservacao($sObservacao);
            $oAnulacao->save();

            db_fim_transacao(false);
        } catch (Exception $eExeption) {

            db_fim_transacao(true);
            $oRetorno->status = 2;
            $oRetorno->erro   = urlencode(str_replace("\\n", "\n", $eExeption->getMessage()));
        }

        break;

        /*
   * Cancelamento de anulação de contrato
   */
    case "cancelarAnulacao":

        try {

            db_inicio_transacao();

            $oAnulacao = new AcordoAnulacao($oParam->codigo);
            $oAnulacao->setDataMovimento();
            $oAnulacao->setObservacao($sObservacao);
            $oAnulacao->cancelar();

            db_fim_transacao(false);
        } catch (Exception $eExeption) {

            db_fim_transacao(true);
            $oRetorno->status = 2;
            $oRetorno->erro   = urlencode(str_replace("\\n", "\n", $eExeption->getMessage()));
        }

        break;

        /*
   * Cancela cancelamento de anulação de contrato
   */
    case "desfazerCancelarAnulacao":

        try {

            db_inicio_transacao();

            $oAnulacao = new AcordoAnulacao($oParam->codigo);
            $oAnulacao->setObservacao($sObservacao);
            $oAnulacao->setDataMovimento();
            $oAnulacao->desfazerCancelamento();

            db_fim_transacao(false);
        } catch (Exception $eExeption) {

            db_fim_transacao(true);
            $oRetorno->status = 2;
            $oRetorno->erro   = urlencode(str_replace("\\n", "\n", $eExeption->getMessage()));
        }

        break;
}

echo $oJson->encode($oRetorno);
