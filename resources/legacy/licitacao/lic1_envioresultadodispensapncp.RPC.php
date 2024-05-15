<?php
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once('libs/db_app.utils.php');
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("std/DBTime.php");
require_once("std/DBDate.php");
require_once("classes/db_pcproc_classe.php");
require_once("classes/db_liccontrolepncp_classe.php");
require_once("classes/db_liccontrolepncpitens_classe.php");
require_once("model/licitacao/PNCP/ResultadoItensPNCP.model.php");
require_once("model/licitacao/PNCP/RetificaItensPNCP.model.php");

db_app::import("configuracao.DBDepartamento");
$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

switch ($oParam->exec) {
    case 'getItens':

        $clpcproc           = new cl_pcproc();

        //Itens para Inclusao
        $resultItens = $clpcproc->sql_record($clpcproc->sql_query_item_pncp($oParam->iPcproc));

        for ($iCont = 0; $iCont < pg_num_rows($resultItens); $iCont++) {

            $oItensLicitacao = db_utils::fieldsMemory($resultItens, $iCont);
            $oItem      = new stdClass();
            $oItem->pc01_codmater                   = $oItensLicitacao->pc01_codmater;
            $oItem->pc11_seq                        = $oItensLicitacao->pc11_seq;
            $oItem->pc01_descrmater                 = urlencode($oItensLicitacao->pc01_descrmater);
            $oItem->pc68_nome                       = urlencode($oItensLicitacao->pc68_nome);
            $oItem->z01_numcgm                      = $oItensLicitacao->z01_numcgm;
            $oItem->z01_nome                        = urlencode($oItensLicitacao->z01_nome);
            $oItem->m61_descr                       = urlencode($oItensLicitacao->m61_descr);
            $oItem->pc23_quant                      = $oItensLicitacao->pc23_quant;
            $oItem->pc23_valor                      = $oItensLicitacao->pc23_valor;
            $itens[]                                = $oItem;
        }
        $oRetorno->itens = $itens;

        break;

    case 'enviarResultado':

            $clliccontrolepncp     = new cl_liccontrolepncp();
            $clpcproc              = new cl_pcproc();

            //Buscos Chave da compra no PNCP
            $rsAvisoPNCP = $clliccontrolepncp->sql_record($clliccontrolepncp->sql_query(null, "l213_numerocompra,l213_anousu", null, "l213_processodecompras = $oParam->iPcproc limit 1"));

            $oDadosAvisoPNCP = db_utils::fieldsMemory($rsAvisoPNCP, 0);
            try {
                foreach ($oParam->aItensLicitacao as $item) {
                    $clliccontrolepncpitens     = new cl_liccontrolepncpitens();

                    //verifica se ja foi enviado resultado do item
                    $rsPNCP = $clliccontrolepncpitens->sql_record($clliccontrolepncpitens->sql_query(null, "*", null, "l214_ordem = $item->pc11_seq and l214_pcproc=$oParam->iPcproc and l214_fornecedor = $item->z01_numcgm"));

                    if (pg_num_rows($rsPNCP)) {
                        throw new Exception('Resultado deste Fornecedor ja foi enviado ao PNCP para esse Item seq: ' . $item->pc11_seq);
                    }

                    $aItensProcessoResultado = array();
                    //busco resultado dos itens do processo
                    $rsResultado = $clpcproc->sql_record($clpcproc->sql_query_pncp_itens_resultado($oParam->iPcproc, $item->pc01_codmater, $item->pc11_seq));

                    for ($i = 0; $i < pg_numrows($rsResultado); $i++) {
                        $oDadosResultado = db_utils::fieldsMemory($rsResultado, $i);
                        $aItensProcessoResultado[] = $oDadosResultado;
                    }
                    //classe modelo
                    $clResultadoItensPNCP = new ResultadoItensPNCP($aItensProcessoResultado);
                    //monta o json com os dados da licitacao
                    $odadosResultado = $clResultadoItensPNCP->montarDados();

                    //envia para pncp
                    $rsApiPNCP = $clResultadoItensPNCP->enviarResultado($odadosResultado, $oDadosAvisoPNCP->l213_numerocompra, $oDadosAvisoPNCP->l213_anousu, $item->pc11_seq);

                    if ($rsApiPNCP[1] == '201') {

                        $aResultadoItem = explode('/',$rsApiPNCP[0]);
                        $l214_sequencialresultado = preg_replace("/[^0-9]/", "", $aResultadoItem[13]);

                        $clliccontrolepncpitens->l214_numeroresultado = 1;
                        $clliccontrolepncpitens->l214_numerocompra = $oDadosAvisoPNCP->l213_numerocompra;
                        $clliccontrolepncpitens->l214_anousu = $oDadosAvisoPNCP->l213_anousu;
                        $clliccontrolepncpitens->l214_licitacao = $oParam->iPcproc;
                        $clliccontrolepncpitens->l214_pcproc = $oParam->iPcproc;
                        $clliccontrolepncpitens->l214_ordem = $item->pc11_seq;
                        $clliccontrolepncpitens->l214_fornecedor = $item->z01_numcgm;
                        $clliccontrolepncpitens->l214_sequencialresultado = $l214_sequencialresultado;
                        $clliccontrolepncpitens->incluir();

                        if($clliccontrolepncpitens->erro_status == 0){
                            $erro = $clliccontrolepncpitens->erro_msg;
                            throw new Exception($erro);
                        }

                        $oRetorno->status  = 1;
                        $oRetorno->message = "Enviado com Sucesso !";
                    } else {
                        throw new Exception(utf8_decode($rsApiPNCP[0]));
                    }
                }
            } catch (Exception $eErro) {
                $oRetorno->status  = 2;
                $oRetorno->message = urlencode($eErro->getMessage());
            }
            break;

    case 'RetificarResultado':

            $clliccontrolepncp     = new cl_liccontrolepncp();
            $clpcproc              = new cl_pcproc();

            //Buscos Chave da compra no PNCP
            $rsAvisoPNCP = $clliccontrolepncp->sql_record($clliccontrolepncp->sql_query(null, "l213_numerocompra,l213_anousu", null, "l213_processodecompras = $oParam->iPcproc limit 1"));

            $oDadosAvisoPNCP = db_utils::fieldsMemory($rsAvisoPNCP, 0);
            try {
                foreach ($oParam->aItensLicitacao as $item) {

                    $aItensProcessoResultado = array();
                    //busco resultado dos itens do processo
                    $rsResultado = $clpcproc->sql_record($clpcproc->sql_query_pncp_itens_resultado($oParam->iPcproc, $item->pc01_codmater, $item->pc11_seq));

                    for ($i = 0; $i < pg_num_rows($rsResultado); $i++) {
                        $oDadosResultado = db_utils::fieldsMemory($rsResultado, $i);
                        $aItensProcessoResultado[] = $oDadosResultado;
                    }
                    //classe modelo
                    $clResultadoItensPNCP = new ResultadoItensPNCP($aItensProcessoResultado);
                    //monta o json com os dados da licitacao
                    $odadosResultado = $clResultadoItensPNCP->montarDados();

                    //envia para pncp
                    $rsApiPNCP = $clResultadoItensPNCP->retificarResultado($odadosResultado, $oDadosAvisoPNCP->l213_numerocompra, $oDadosAvisoPNCP->l213_anousu, $item->pc11_seq,1);
                    if ($rsApiPNCP[0] != 201) {
                        throw new Exception(utf8_decode($rsApiPNCP[1]));
                    }
                }

                foreach ($oParam->aItensLicitacao as $item) {
                    //RETIFICAR O ITEM ALTERANDO A SITUACAO

                    $aItensRetificaItemLicitacao = array();
                    $rsItensRetificacao = $clpcproc->sql_record($clpcproc->sql_query_pncp_itens_retifica_situacao($oParam->iPcproc,$item->pc01_codmater, $item->pc11_seq));

                    for ($i = 0; $i < pg_num_rows($rsItensRetificacao); $i++) {
                        $oDadosResultado = db_utils::fieldsMemory($rsItensRetificacao, $i);
                        $aItensRetificaItemLicitacao[] = $oDadosResultado;
                    }

                    //classe modelo
                    $clResultadoItensPNCP = new RetificaitensPNCP($aItensRetificaItemLicitacao);
                    //monta o json com os dados da licitacao
                    $odadosResultado = $clResultadoItensPNCP->montarDados();

                    //envia para pncp
                    $rsApiretitensPNCP = $clResultadoItensPNCP->retificarItem($odadosResultado, $oDadosAvisoPNCP->l213_numerocompra, $oDadosAvisoPNCP->l213_anousu, $item->pc11_seq);
                    if ($rsApiretitensPNCP[0] != 201) {
                        throw new Exception(utf8_decode($rsApiretitensPNCP[1]));
                    }

                }

                $oRetorno->status  = 1;
                $oRetorno->message = "Enviado com Sucesso !";
            } catch (Exception $eErro) {
                $oRetorno->status  = 2;
                $oRetorno->message = urlencode($eErro->getMessage());
            }
            break;
}
echo json_encode($oRetorno);
