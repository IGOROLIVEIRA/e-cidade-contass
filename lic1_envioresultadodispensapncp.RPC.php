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
            $oItem->pc68_nome                       = $oItensLicitacao->pc68_nome;
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
                $urlResutltado = explode('x-content-type-options', $rsApiPNCP[0]);

                if ($rsApiPNCP[1] == '201') {
                    $clliccontrolepncpitens = new cl_liccontrolepncpitens();
                    $l214_numeroresultado = substr($urlResutltado[0], 96);
                    $clliccontrolepncpitens->l214_numeroresultado = $l214_numeroresultado;
                    $clliccontrolepncpitens->l214_numerocompra = $oDadosAvisoPNCP->l213_numerocompra;
                    $clliccontrolepncpitens->l214_anousu = $oDadosAvisoPNCP->l213_anousu;
                    $clliccontrolepncpitens->l214_licitacao = $oParam->iLicitacao;
                    $clliccontrolepncpitens->l214_ordem = $item->pc11_seq;
                    $clliccontrolepncpitens->l214_pcproc = $oParam->iPcproc;
                    $clliccontrolepncpitens->incluir();

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
