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
require_once("classes/db_liclicita_classe.php");
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

        $clliclicita           = new cl_liclicita();
        if($oParam->iTipo == "1"){
            //Itens para Inclusao de resultado
            $resultItens = $clliclicita->sql_record($clliclicita->sql_query_item_pncp($oParam->iLicitacao));

            for ($iCont = 0; $iCont < pg_num_rows($resultItens); $iCont++) {

                $oItensLicitacao = db_utils::fieldsMemory($resultItens, $iCont);
                $oItem      = new stdClass();
                $oItem->pc01_codmater                   = $oItensLicitacao->pc01_codmater;
                $oItem->l21_ordem                       = $oItensLicitacao->l21_ordem;
                $oItem->pc01_descrmater                 = urlencode($oItensLicitacao->pc01_descrmater);
                $oItem->l04_descricao                   = urlencode($oItensLicitacao->l04_descricao);
                $oItem->z01_numcgm                      = $oItensLicitacao->z01_numcgm;
                $oItem->z01_nome                        = urlencode($oItensLicitacao->z01_nome);
                $oItem->m61_descr                       = urlencode($oItensLicitacao->m61_descr);
                $oItem->pc11_quant                      = $oItensLicitacao->pc11_quant;
                $oItem->pc23_valor                      = $oItensLicitacao->pc23_valor;
                $itens[]                                = $oItem;
            }
            $oRetorno->itens = $itens;
        }else{
            //Itens para Retificacao de resultado
            $resultItens = $clliclicita->sql_record($clliclicita->sql_query_item_pncp_retifica($oParam->iLicitacao));
            for ($iCont = 0; $iCont < pg_num_rows($resultItens); $iCont++) {

                $oItensLicitacao = db_utils::fieldsMemory($resultItens, $iCont);
                $oItem      = new stdClass();
                $oItem->pc01_codmater                   = $oItensLicitacao->pc01_codmater;
                $oItem->l21_ordem                       = $oItensLicitacao->l21_ordem;
                $oItem->pc01_descrmater                 = urlencode($oItensLicitacao->pc01_descrmater);
                $oItem->l04_descricao                   = urlencode($oItensLicitacao->l04_descricao);
                $oItem->z01_numcgm                      = $oItensLicitacao->z01_numcgm;
                $oItem->z01_nome                        = urlencode($oItensLicitacao->z01_nome);
                $oItem->m61_descr                       = urlencode($oItensLicitacao->m61_descr);
                $oItem->pc11_quant                      = $oItensLicitacao->pc11_quant;
                $oItem->pc23_valor                      = $oItensLicitacao->pc23_valor;
                $itens[]                                = $oItem;
            }
            $oRetorno->itens = $itens;
        }


        break;

    case 'enviarResultado':
        $clliclicita           = new cl_liclicita();
        $clliccontrolepncp     = new cl_liccontrolepncp();
        $clliccontrolepncpitens = new cl_liccontrolepncpitens();

        //Buscos Chave da compra no PNCP
        $rsAvisoPNCP = $clliccontrolepncp->sql_record($clliccontrolepncp->sql_query(null, "l213_numerocompra,l213_anousu", null, "l213_licitacao = $oParam->iLicitacao limit 1"));
        $oDadosAvisoPNCP = db_utils::fieldsMemory($rsAvisoPNCP, 0);
        try {
            foreach ($oParam->aItensLicitacao as $item) {

                //verifica se ja foi enviado resultado do item
                $rsPNCP = $clliccontrolepncpitens->sql_record($clliccontrolepncpitens->sql_query(null, "*", null, "l214_ordem = $item->l21_ordem and l214_licitacao=$oParam->iLicitacao and l214_fornecedor = $item->z01_numcgm"));

                if (pg_num_rows($rsPNCP)) {
                    throw new Exception('Resultado deste Fornecedor ja foi enviado ao PNCP para esse Item seq: ' . $item->l21_ordem);
                }

                $aItensLicitacao = array();
                $rsResultado = $clliclicita->sql_record($clliclicita->sql_query_resultado_pncp($oParam->iLicitacao, $item->l21_ordem,$item->z01_numcgm));

                for ($i = 0; $i < pg_num_rows($rsResultado); $i++) {
                    $oDadosResultado = db_utils::fieldsMemory($rsResultado, $i);
                    $aItensLicitacao[] = $oDadosResultado;
                }

                //classe modelo
                $clResultadoItensPNCP = new ResultadoItensPNCP($aItensLicitacao);
                //monta o json com os dados da licitacao
                $odadosResultado = $clResultadoItensPNCP->montarDados();
                //envia para pncp
                $rsApiPNCP = $clResultadoItensPNCP->enviarResultado($odadosResultado, $oDadosAvisoPNCP->l213_numerocompra, $oDadosAvisoPNCP->l213_anousu, $item->l21_ordem);
                if ($rsApiPNCP[1] == '201') {

                    $aResultadoItem = explode('/',$rsApiPNCP[0]);
                    $l214_sequencialresultado = preg_replace("/[^0-9]/", "", $aResultadoItem[13]);
                    $clLiccontroleItens = new cl_liccontrolepncpitens();
                    $clLiccontroleItens->l214_numeroresultado = 1;
                    $clLiccontroleItens->l214_numerocompra = $oDadosAvisoPNCP->l213_numerocompra;
                    $clLiccontroleItens->l214_anousu = $oDadosAvisoPNCP->l213_anousu;
                    $clLiccontroleItens->l214_licitacao = $oParam->iLicitacao;
                    $clLiccontroleItens->l214_ordem = $item->l21_ordem;
                    $clLiccontroleItens->l214_fornecedor = $item->z01_numcgm;
                    $clLiccontroleItens->l214_sequencialresultado = $l214_sequencialresultado;
                    $clLiccontroleItens->incluir();

                    if($clLiccontroleItens->erro_status == 0){
                        throw new Exception(utf8_decode($clLiccontroleItens->erro_msg));
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

        $clliclicita           = new cl_liclicita();
        $clliccontrolepncp     = new cl_liccontrolepncp();
        //Buscos Chave da compra no PNCP
        $rsAvisoPNCP = $clliccontrolepncp->sql_record($clliccontrolepncp->sql_query(null, "l213_numerocompra,l213_anousu", null, "l213_licitacao = $oParam->iLicitacao limit 1"));
        $oDadosAvisoPNCP = db_utils::fieldsMemory($rsAvisoPNCP, 0);

        try {
                //Retificar Resultado de Item de Contratação
                foreach ($oParam->aItensLicitacao as $item) {

                    $aItensLicitacao = array();
                    $rsResultado = $clliclicita->sql_record($clliclicita->sql_query_resultado_retifica_pncp($oParam->iLicitacao, $item->l21_ordem,$item->z01_numcgm));

                    if (!pg_num_rows($rsResultado)) {
                        continue;
                    }
                    for ($i = 0; $i < pg_num_rows($rsResultado); $i++) {
                        $oDadosResultado = db_utils::fieldsMemory($rsResultado, $i);
                        $aItensLicitacao[] = $oDadosResultado;
                    }
                    //classe modelo
                    $clResultadoItensPNCP = new ResultadoItensPNCP($aItensLicitacao);
                    //monta o json com os dados da licitacao
                    $odadosResultado = $clResultadoItensPNCP->montarDados();

                    //envia para pncp
                    $rsApiPNCP = $clResultadoItensPNCP->retificarResultado($odadosResultado, $oDadosAvisoPNCP->l213_numerocompra, $oDadosAvisoPNCP->l213_anousu, $item->l21_ordem, $oDadosResultado->l214_sequencialresultado);

                    if ($rsApiPNCP[0] != 201) {
                        throw new Exception(utf8_decode($rsApiPNCP[1]));
                    }
                }

                //Retificar Item de Contratação
                foreach ($oParam->aItensLicitacao as $item) {

                    $aItensRetificaItemLicitacao = array();

                    $rsItensRetificacao = $clliclicita->sql_record($clliclicita->sql_query_pncp_itens_retifica_situacao($oParam->iLicitacao, $item->l21_ordem));
                    for ($i = 0; $i < pg_num_rows($rsItensRetificacao); $i++) {
                        $oDadosResultado = db_utils::fieldsMemory($rsItensRetificacao, $i);
                        $aItensRetificaItemLicitacao[] = $oDadosResultado;
                    }
                    /*
                     * Aqui eu fiz uma consulta para conseguir o valor estimado do item reservado
                     */

                    if ($aItensRetificaItemLicitacao[0]->pc11_reservado == "t") {
                        $rsReservado = $clliclicita->sql_record($clliclicita->sql_query_valor_item_reservado($aItensRetificaItemLicitacao[0]->pc11_numero, $aItensRetificaItemLicitacao[0]->pc01_codmater));
                        db_fieldsmemory($rsReservado, 0);
                        $aItensRetificaItemLicitacao[0]->valorunitarioestimado = $valorunitarioestimado;
                    }

                    //classe modelo
                    $clResultadoItensPNCP = new RetificaitensPNCP($aItensRetificaItemLicitacao);
                    //monta o json com os dados da licitacao
                    $odadosItensRetifica = $clResultadoItensPNCP->montarDados();

                    //envia para pncp
                    $rsApiretitensPNCP = $clResultadoItensPNCP->retificarItem($odadosItensRetifica, $oDadosAvisoPNCP->l213_numerocompra, $oDadosAvisoPNCP->l213_anousu, $item->l21_ordem);
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
