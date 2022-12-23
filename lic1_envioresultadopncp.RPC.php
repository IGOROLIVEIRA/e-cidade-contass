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

db_app::import("configuracao.DBDepartamento");
$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

switch ($oParam->exec) {
    case 'getItens':

        $clliclicita           = new cl_liclicita();

        //Itens para Inclusao
        $resultItens = $clliclicita->sql_record($clliclicita->sql_query_item_pncp($oParam->iLicitacao));

        for ($iCont = 0; $iCont < pg_num_rows($resultItens); $iCont++) {

            $oItensLicitacao = db_utils::fieldsMemory($resultItens, $iCont);
            $oItem      = new stdClass();
            $oItem->pc01_codmater                   = $oItensLicitacao->pc01_codmater;
            $oItem->l21_ordem                       = $oItensLicitacao->l21_ordem;
            $oItem->pc01_descrmater                 = urlencode($oItensLicitacao->pc01_descrmater);
            $oItem->l04_descricao                   = $oItensLicitacao->l04_descricao;
            $oItem->z01_numcgm                      = $oItensLicitacao->z01_numcgm;
            $oItem->z01_nome                        = urlencode($oItensLicitacao->z01_nome);
            $oItem->m61_descr                       = $oItensLicitacao->m61_descr;
            $oItem->pc23_quant                      = $oItensLicitacao->pc23_quant;
            $oItem->pc23_valor                      = $oItensLicitacao->pc23_valor;
            $itens[]                                = $oItem;
        }
        $oRetorno->itens = $itens;

        break;
    case 'enviarResultado':
        /*
            [iLicitacao] => 499
        */
        $clliclicita           = new cl_liclicita();
        $clliccontrolepncp     = new cl_liccontrolepncp();
        //Buscos Chave da compra no PNCP
        $rsAvisoPNCP = $clliccontrolepncp->sql_record($clliccontrolepncp->sql_query(null, "l213_numerocompra,l213_anousu", null, "l213_licitacao = $oParam->iLicitacao limit 1"));
        $oDadosAvisoPNCP = db_utils::fieldsMemory($rsAvisoPNCP, 0);
        try {
            foreach ($oParam->aItensLicitacao as $item) {

                $aItensLicitacao = array();
                $rsResultado = $clliclicita->sql_record($clliclicita->sql_query_resultado_pncp($oParam->iLicitacao, $item->l21_ordem));
                for ($i = 0; $i < pg_numrows($rsResultado); $i++) {
                    $oDadosResultado = db_utils::fieldsMemory($rsResultado, $i);
                    $aItensLicitacao[] = $oDadosResultado;
                }
                //classe modelo
                $clResultadoItensPNCP = new ResultadoItensPNCP($aItensLicitacao);
                //monta o json com os dados da licitacao
                $odadosResultado = $clResultadoItensPNCP->montarDados();
                //envia para pncp
                $rsApiPNCP = $clResultadoItensPNCP->enviarResultado($odadosResultado, $oDadosAvisoPNCP->l213_numerocompra, $oDadosAvisoPNCP->l213_anousu, $item->l21_ordem);
                $urlResutltado = explode('x-content-type-options', $rsApiPNCP[0]);

                if ($rsApiPNCP[1] == '201') {
                    $clliccontrolepncp = new cl_liccontrolepncpitens();
                    $l214_numeroresultado = substr($urlResutltado[0], 96);
                    $clliccontrolepncp->l214_numeroresultado = $l214_numeroresultado;
                    $clliccontrolepncp->l214_numerocompra = $oDadosAvisoPNCP->l213_numerocompra;
                    $clliccontrolepncp->l214_anousu = $oDadosAvisoPNCP->l213_anousu;
                    $clliccontrolepncp->l214_licitacao = $oParam->iLicitacao;
                    $clliccontrolepncp->l214_ordem = $item->l21_ordem;
                    $clliccontrolepncp->incluir();

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
}
echo json_encode($oRetorno);
