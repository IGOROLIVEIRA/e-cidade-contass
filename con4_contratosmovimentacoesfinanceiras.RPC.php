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
require_once("model/compras/TipoCompra.model.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_sessoes.php");
require_once("classes/db_condataconf_classe.php");
require_once("classes/db_liclicitaoutrosorgaos_classe.php");
$oJson    = new services_json();
$oRetorno = new stdClass();
$oDaoTipocompra = new cl_pctipocompra();
//$oParam   = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\", "", $_POST["json"])));
$oParam   = json_decode(str_replace('\\', '', $_POST["json"]));

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

//       if ($oPosicaoContrato->getTipo() == AcordoPosicao::TIPO_VIGENCIA) {
//         continue;
//       }
            $iTipoPosicao =  $oPosicaoContrato->getTipo();

//            /**
//             * Mostrará apenas as posições de tipo inclusão ou vigência, para acordos de origem empenho
//             */
//            if ($lGeraAutorizacao && $lOrigemEmpenho && ($iTipoPosicao == AcordoPosicao::TIPO_INCLUSAO || $iTipoPosicao == AcordoPosicao::TIPO_VIGENCIA) ) {
//                continue;
//            }

            $oPosicao->codigo         = $oPosicaoContrato->getCodigo();
            $oPosicao->codigoaditivo  = $oPosicaoContrato->getCodigoAditivo();
            $oPosicao->data           = $oPosicaoContrato->getData();
            $oPosicao->tipo           = $oPosicaoContrato->getTipo();
            $oPosicao->dataassinatura = $oPosicaoContrato->getDataAssinatura();
            $oPosicao->datapublicacao = $oPosicaoContrato->getDataPublicacao();
            $oPosicao->numerocontrato = $oContrato->getGrupo()." - ".$oContrato->getNumero()."/".$oContrato->getAno();
            $oPosicao->descricaotipo  = urlencode($oPosicaoContrato->getDescricaoTipo());
            $oPosicao->numero         = (string)"".str_pad($oPosicaoContrato->getNumeroAditamento(), "0", 7)."";
            $oPosicao->emergencial    = urlencode($oPosicaoContrato->isEmergencial()?"Sim":"Não");
            $oPosicao->cgccpf         = $oContrato->getContratado()->getCgccpf();
            array_push($oRetorno->posicoes, $oPosicao);

        }

        break;

    case "getAditamentos":

        if (isset ($_SESSION["oContrato"])) {
            unset($_SESSION["oContrato"]);
        }
        $oContrato              = new Acordo($oParam->iAcordo);
        $_SESSION["oContrato"]  = $oContrato;
        $aPosicoes              = $oContrato->getPosicoesAditamentos();
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
            if($oPosicaoContrato->getTipo() == 14 || $oPosicaoContrato->getTipo() == 15 || $oPosicaoContrato->getTipo() == 16){
                $oPosicao->numero         = (string)"".str_pad($oPosicaoContrato->getNumeroApostilamento(), "0", 7)."";
            }else{
                $oPosicao->numero         = (string)"".str_pad($oPosicaoContrato->getNumeroAditamento(), "0", 7)."";
            }
            $oPosicao->emergencial    = urlencode($oPosicaoContrato->isEmergencial()?"Sim":"Não");
            array_push($oRetorno->posicoes, $oPosicao);

        }

        if(count($oRetorno->posicoes) == 0 ){
            $oRetorno->status   = 2;
            $oRetorno->message  = urlencode('Nenhum aditamento encontrado!');
        }

        break;

    case "getApostilamentos":

        if (isset ($_SESSION["oContrato"])) {
            unset($_SESSION["oContrato"]);
        }
        $oContrato              = new Acordo($oParam->iAcordo);
        $_SESSION["oContrato"]  = $oContrato;
        $aPosicoes              = $oContrato->getPosicoesApostilamentos();
        $oRetorno->posicoes     = array();
        $oRetorno->tipocontrato = $oContrato->getOrigem();

        foreach ($aPosicoes as $oPosicaoContrato) {

            $oPosicao        = new stdClass();

            if ($oPosicaoContrato->getTipo() == AcordoPosicao::TIPO_INCLUSAO || $oPosicaoContrato->getNumeroAditamento()) {
                continue;
            }
            $iTipoPosicao =  $oPosicaoContrato->getTipo();
            $oPosicao->codigo         = $oPosicaoContrato->getCodigo();
            $oPosicao->data           = $oPosicaoContrato->getData();
            $oPosicao->tipo           = $oPosicaoContrato->getTipo();
            $oPosicao->numerocontrato = $oContrato->getGrupo()." - ".$oContrato->getNumero()."/".$oContrato->getAno();
            $oPosicao->descricaotipo  = urlencode($oPosicaoContrato->getDescricaoTipo());
            $oPosicao->numero         = (string)"".str_pad($oPosicaoContrato->getNumeroAditamento(), "0", 7)."";
            $oPosicao->emergencial    = urlencode($oPosicaoContrato->isEmergencial()?"Sim":"Não");
            array_push($oRetorno->posicoes, $oPosicao);

        }

        if(count($oRetorno->posicoes) == 0 ){
            $oRetorno->status   = 2;
            $oRetorno->message  = urlencode('Nenhum apostilamento encontrado!');
        }

        break;

    case "getPosicaoItens":

        if (isset ($_SESSION["oContrato"])) {

            $oContrato = $_SESSION["oContrato"];
            $aItens    = array();

            $oRetorno->iCasasDecimais = 2;
            //echo 'info contrato ';
            //print_r($oContrato);

            $oRetorno->iOrigemContrato      = $oContrato->getOrigem();

            if ($oRetorno->iOrigemContrato == 2) {
                $aLicitacoesVinculadas = $oContrato->getLicitacoes();
                $oStdDados     = $aLicitacoesVinculadas[0]->getDados();
                $oRetorno->iCodigoLicitacao     = $oStdDados->l20_codigo;
                $oRetorno->iEdital              = $oStdDados->l20_edital;
                $oRetorno->iAnoLicitacao        = $oStdDados->l20_anousu;
                $oRetorno->iModalidadeLicitacao = $oStdDados->l20_codtipocom;
                $oRetorno->iNumModalidade       = $oStdDados->l20_numero;
                $oRetorno->pc50_codcom          = $oStdDados->pc50_codcom;
                $oRetorno->l03_tipo             = $oStdDados->l03_tipo;
            }else if ($oRetorno->iOrigemContrato == 3 )  {
                $aLicitacoesVinculadas = $oContrato->getLicitacoes();

                if(empty($aLicitacoesVinculadas[0])){

                    $oRetorno->iCodigoLicitacao     = '';
                    $oRetorno->iEdital              = '';
                    $oRetorno->iAnoLicitacao        = '';
                    $oRetorno->iModalidadeLicitacao = '';
                    $oRetorno->pc50_codcom          = '';
                    $oRetorno->l03_tipo             = '';

                }else{

                    $oStdDados     = $aLicitacoesVinculadas[0]->getDados();
                    $oRetorno->iCodigoLicitacao     = $oStdDados->l20_codigo;
                    $oRetorno->iEdital              = $oStdDados->l20_edital;
                    $oRetorno->iNumModalidade       = $oStdDados->l20_numero;
                    $oRetorno->iAnoLicitacao        = $oStdDados->l20_anousu;
                    $oRetorno->iModalidadeLicitacao = $oStdDados->l20_codtipocom;
                    $oRetorno->pc50_codcom          = $oStdDados->pc50_codcom;
                    $oRetorno->l03_tipo             = $oStdDados->l03_tipo;

                }

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
                            $oDotacao->saldoexecutado = 0;
                            $oDotacao->valorexecutar  = 0;
                            $oDotacao->saldodotacao   = $oDotacaoSaldo->getSaldoFinal();

                            $oDotacao->valor -= $oDotacao->executado;

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

                    $nTotalExecutar += $oDotacoes->valor;
                }

                if (round($nTotalExecutar, 2) > round($nValorTotalItem, 2)) {

                    $nExecutar  = trim(db_formatar($nTotalExecutar , "f") );
                    $nTotalItem = trim(db_formatar($nValorTotalItem , "f"));
                    throw new BusinessException( " Valor a executar {$nExecutar} maior que o total do item {$nTotalItem}. " ) ;
                }
            }
            /**
             * verifico o tipo de licitação para escolher o tipoorigem
             * @MarioJunior
             * OC 7425
             */

            $tipoLicitacao = array(52,48,49,50,51,53,54);
            $tipoDispensaInex = array(100,101,102);
            $oAcordo = new Acordo($oParam->iCodigoAcordo);
            $aLicitacoesVinculadas = $oAcordo->getLicitacoes();

            if(!empty($aLicitacoesVinculadas))
                $oStdDados     = $aLicitacoesVinculadas[0]->getDados();

            if(in_array($oStdDados->l44_sequencial, $tipoLicitacao)){
                $oParam->dados->sTipoorigem = 2;
            }else if(in_array($oStdDados->l44_sequencial, $tipoDispensaInex)){
                $oParam->dados->sTipoorigem = 3;
            }
            $oParam->dados->sTipoautorizacao = 2;

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
            $clcondataconf = new cl_condataconf;

            $anousu = db_getsession('DB_anousu');

            $sSQL = "select to_char(c99_datapat,'YYYY') c99_datapat
                      from condataconf
                        where c99_instit = ".db_getsession('DB_instit')."
                          order by c99_anousu desc limit 1";

            $rsResult       = db_query($sSQL);
            $maxC99_datapat = db_utils::fieldsMemory($rsResult, 0)->c99_datapat;

            $sNSQL = "";
            if ($anousu > $maxC99_datapat) {
              $sNSQL = $clcondataconf->sql_query_file($maxC99_datapat,db_getsession('DB_instit'),'c99_datapat');

            } else {
                $sNSQL = $clcondataconf->sql_query_file(db_getsession('DB_anousu'),db_getsession('DB_instit'),'c99_datapat');
            }

            $result = db_query($sNSQL);

            $c99_datapat = db_utils::fieldsMemory($result, 0)->c99_datapat;

            arsort($oParam->aPosicoes);

            foreach ($oParam->aPosicoes as $oPosicao) {

                $oAcordoPosicao = new AcordoPosicao($oPosicao->codigo);
                $DataAssinatura = implode("-",array_reverse(explode("/",$oAcordoPosicao->getDataAssinatura())));

                if(($c99_datapat != "" && $DataAssinatura != '') && $DataAssinatura <= $c99_datapat){
                    $erro_msg = "O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.";
                    $oRetorno->status = 1;
                    throw new BusinessException($erro_msg);
                }else {
                    if ($oPosicao->codigo == $oContrato->getUltimaPosicao(true)->getCodigo()) {
                      $oAcordoPosicao->remover();
                    } else {
                      throw new BusinessException(" Não é possível excluir uma aditamento/apostilamento que não seja o último. Para excluir um aditamento/apostilamento, faça a partir do último ");
                    }
                    db_fim_transacao(false);
                    $oRetorno->status = 2;
                    $oRetorno->message = urlencode('Aditamento excluído com sucesso!');
                }
            }

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
                $oContrato->anularAutorizacao2($iAutorizacao);
            }
            db_fim_transacao(false);
        } catch (Exception $eErro) {

            db_fim_transacao(true);
            $oRetorno->status  = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }

        break;

    case "excluirAutorizacoes":

        $oContrato = $_SESSION["oContrato"];
        try {
            $aiAutorizacao = array();
            db_inicio_transacao();
            foreach ($oParam->aAutorizacoes as $iAutorizacao) {
                array_push($aiAutorizacao, $iAutorizacao);
            }
            $oContrato->excluirAutorizacao($aiAutorizacao);
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

        $aLicitacoesVinculadas = $oAcordo->getLicitacoes();
        if($aLicitacoesVinculadas[0] != "") {
            $oStdDados = $aLicitacoesVinculadas[0]->getDados();
            $oRetorno->sLicitacao = urlencode($oAcordo->getLicitacao());
            $oRetorno->iModalidade = urlencode($oAcordo->getModalidade());
            $oRetorno->iNumModalidade = urlencode($oStdDados->l20_numero);
            $oRetorno->iProcesso = $oStdDados->l20_edital."/".$oStdDados->l20_anousu;
            $oRetorno->sTipo = urlencode($oStdDados->l03_codcom);
            $oRetorno->sTipoorigem = $oAcordo->getTipoOrigem();
            $oRetorno->sTipoautorizacao = urlencode(2);
            $oRetorno->sResumoAcordo = urlencode($oAcordo->getObjeto());
        }else{
            $oRetorno->sLicitacao = '';
            $oRetorno->iModalidade = '';
            $oRetorno->iNumModalidade = '';
            $oRetorno->iProcesso = '';
            $oRetorno->sTipo = '';
            $oRetorno->sTipoorigem = '';
            $oRetorno->sTipoautorizacao = urlencode(2);
            $oRetorno->sResumoAcordo = urlencode($oAcordo->getObjeto());
        }

        /**
         *Retorna dados da licitacao de outro orgao
         */
        $aLicOutrosorgaosVinculadas = $oAcordo->getiLicoutroorgao();
        if($aLicOutrosorgaosVinculadas[0] != ""){
            $oDaoAcordo = db_utils::getDao("liclicitaoutrosorgaos");
            $codLicOutrosOrgaos = $aLicOutrosorgaosVinculadas[0];
            $sCampos = "lic211_processo||'/'||lic211_anousu as lic211_processo,lic211_numero,lic211_anousu,lic211_tipo";
            $sSqlLicoutroorgao = $oDaoAcordo->sql_query($codLicOutrosOrgaos,$sCampos);
            $rsLicoutroorgao = $oDaoAcordo->sql_record($sSqlLicoutroorgao);
            $oDadosLicoutroorgao = db_utils::fieldsMemory($rsLicoutroorgao, 0);

            $oRetorno->iModalidade = urlencode($oAcordo->getModalidade());
            $oRetorno->iNumModalidade = urlencode($oDadosLicoutroorgao->lic211_numero);
            $oRetorno->iProcesso = $oDadosLicoutroorgao->lic211_processo;
            $oRetorno->iAnoProc = urlencode($oDadosLicoutroorgao->lic211_anousu);

            //ACHAR CODCOMPRA
            if($oDadosLicoutroorgao->lic211_tipo = 5){
                $sPctipocampos = "pc50_codcom";
                $sPctipowhere = "pc50_pctipocompratribunal = 105";
            }elseif ($oDadosLicoutroorgao->lic211_tipo = 6){
                $sPctipocampos = "pc50_codcom";
                $sPctipowhere = "pc50_pctipocompratribunal = 106";
            }elseif ($oDadosLicoutroorgao->lic211_tipo = 7){
                $sPctipocampos = "pc50_codcom";
                $sPctipowhere = "pc50_pctipocompratribunal = 107";
            }elseif ($oDadosLicoutroorgao->lic211_tipo = 8){
                $sPctipocampos = "pc50_codcom";
                $sPctipowhere = "pc50_pctipocompratribunal = 108";
            }elseif ($oDadosLicoutroorgao->lic211_tipo = 9){
                $sPctipocampos = "pc50_codcom";
                $sPctipowhere = "pc50_pctipocompratribunal = 109";
            }
            $sqlTipocompra = $oDaoTipocompra->sql_query_file(null,$sPctipocampos,null,$sPctipowhere);
            $rsTipocompra  = $oDaoTipocompra->sql_record($sqlTipocompra);
            $oTipocompra = db_utils::fieldsMemory($rsTipocompra,0)->pc50_codcom;
            $oRetorno->sTipo = ($oTipocompra);
            $oRetorno->sTipoorigem = $oAcordo->getTipoOrigem();
            $oRetorno->sTipoautorizacao = urlencode(2);
            $oRetorno->sResumoAcordo = urlencode($oAcordo->getObjeto());
        }
        /**
         * retorna adesao de registro de preco
         */
        $aAdesaoVinculada = $oAcordo->getiAdesaoregpreco();

        if($aAdesaoVinculada[0] != ""){

            $oDaoAcordo = db_utils::getDao("adesaoregprecos");
            $sCampos = "si06_numeroprc||'/'||si06_anoproc as si06_numeroprc,si06_numlicitacao";
            $sSqlAdesao = $oDaoAcordo->sql_query($aAdesaoVinculada,$sCampos);
            $rsAdesao = $oDaoAcordo->sql_record($sSqlAdesao);
            $oDadosAdesao = db_utils::fieldsMemory($rsAdesao, 0);

            $oRetorno->iModalidade = urlencode($oAcordo->getModalidade());
            $oRetorno->iNumModalidade = urlencode($oDadosAdesao->si06_numlicitacao);
            $oRetorno->iProcesso = $oDadosAdesao->si06_numeroprc;

            //ACHAR CODCOMPRA
            $sPctipocampos = "pc50_codcom";
            $sPctipowhere = "pc50_pctipocompratribunal = 104";
            $sqlTipocompra = $oDaoTipocompra->sql_query_file(null,$sPctipocampos,null,$sPctipowhere);
            $rsTipocompra  = $oDaoTipocompra->sql_record($sqlTipocompra);
            $oTipocompra = db_utils::fieldsMemory($rsTipocompra,0)->pc50_codcom;
            $oRetorno->sTipo = ($oTipocompra);
            $oRetorno->sTipoorigem = $oAcordo->getTipoOrigem();
            $oRetorno->sTipoautorizacao = urlencode(4);
            $oRetorno->sResumoAcordo = urlencode($oAcordo->getObjeto());
        }

        break;

    case 'getVigencia':

        $oContrato = $_SESSION["oContrato"];
        $dataFimVigencia = implode("-",array_reverse(explode("/",$oContrato->getUltimaPosicao(true)->getVigenciaFinal())));
        $dataAssinatura = implode("-",array_reverse(explode("/",$oContrato->getDataAssinatura())));
        $dataAutorizacao = date("Y-m-d",db_getsession("DB_datausu"));
        $gerarAutorizacao = array();

        if($dataAutorizacao > $dataFimVigencia){
            $gerarAutorizacao[0] = false;
            $gerarAutorizacao[1] = implode("/",array_reverse(explode("-",$dataFimVigencia)));
            $gerarAutorizacao[2] = true;
            $gerarAutorizacao[3] = implode("/",array_reverse(explode("-",$dataAssinatura)));
        }elseif($dataAutorizacao < $dataAssinatura){
            $gerarAutorizacao[0] = false;
            $gerarAutorizacao[1] = implode("/",array_reverse(explode("-",$dataFimVigencia)));
            $gerarAutorizacao[2] = false;
            $gerarAutorizacao[3] = implode("/",array_reverse(explode("-",$dataAssinatura)));
        }else{
            $gerarAutorizacao[0] = true;
            $gerarAutorizacao[1] = implode("/",array_reverse(explode("-",$dataFimVigencia)));
        }
        $oRetorno = $gerarAutorizacao;

        break;
}

echo $oJson->encode($oRetorno);
?>
