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
require_once("model/Acordo.model.php");
require_once("model/licitacao/PNCP/ResultadoItensPNCP.model.php");
require_once("model/licitacao/PNCP/RetificaItensPNCP.model.php");

db_app::import("configuracao.DBDepartamento");
$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

switch ($oParam->exec) {
    case 'getTermos':

        $oAcordo = new Acordo($oParam->iContrato);
        $aDadosTermos = $oAcordo->getPosicoesAditamentos();

        if($oParam->iTipo == "1"){
            foreach ($aDadosTermos as $oTermo) {
                $oItemTermo = new stdClass();
                $oItemTermo->codigo = $oTermo->getCodigo();
                $oItemTermo->vigencia = urlencode($oTermo->getVigenciaInicial() . " até " . $oTermo->getVigenciaFinal());
                $oItemTermo->numeroAditamento = $oTermo->getNumeroAditamento();
                $oItemTermo->situacao = urlencode($oTermo->getDescricaoTipo());
                $oItemTermo->data = $oTermo->getData();
                $oItemTermo->Justificativa = urlencode($oTermo->getJusitificativa());
                $oRetorno->dados[] = $oItemTermo;
            }
        }
        break;
    case 'enviarTermo':

        $clacocontrolepncp = new cl_acocontratopncp;
        $oAcordo = new Acordo($oParam->iContrato);

        //Buscos Chave do Contrato do PNCP
        $rsAvisoPNCP = $clacocontrolepncp->sql_record($clacocontrolepncp->sql_query(null, "ac213_numerocontrolepncp,ac213_sequencialpncp,ac213_ano", null, "ac213_contrato = $oParam->iContrato limit 1"));
        $oDadosAvisoPNCP = db_utils::fieldsMemory($rsAvisoPNCP, 0);

        try {
            foreach ($oParam->aTermo as $termo) {
            
                $aDadosTermos = $oAcordo->getDadosTermosPncp($termo->codigo);
                echo "<pre>";
                print_r($aDadosTermos);
                exit("aqui");



                $clliccontrolepncp = new cl_liccontrolepncpitens();
                //verifica se ja foi enviado resultado do item
                $rsPNCP = $clliccontrolepncp->sql_record($clliccontrolepncp->sql_query(null, "*", null, "l214_ordem = $item->l21_ordem and l214_licitacao=$oParam->iLicitacao"));

                if (pg_num_rows($rsPNCP)) {
                    throw new Exception('Rusultado do Iten PNCP ja foi enviado Item seq: ' . $item->l21_ordem);
                }

                $aItensLicitacao = array();
                $rsResultado = $clliclicita->sql_record($clliclicita->sql_query_resultado_pncp($oParam->iLicitacao, $item->l21_ordem));

                /*if (!pg_num_rows($rsResultado)) {
                    throw new Exception('Dados do Rultado do Iten PNCP não Encontrato! Licitacao:' . $aLicitacao->codigo . "Item seq: " . $item->l21_ordem);
                }*/
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
                    $clliccontrolepncp->l214_numeroresultado = 1;
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

    case 'retificarTermo':
        /*
            [iLicitacao] => 499
        */
        $clliclicita           = new cl_liclicita();
        $clliccontrolepncp     = new cl_liccontrolepncp();
        //Buscos Chave da compra no PNCP
        $rsAvisoPNCP = $clliccontrolepncp->sql_record($clliccontrolepncp->sql_query(null, "l213_numerocompra,l213_anousu", null, "l213_licitacao = $oParam->iLicitacao limit 1"));
        $oDadosAvisoPNCP = db_utils::fieldsMemory($rsAvisoPNCP, 0);
        try {
                //RETIFICA O RESULTADO
                foreach ($oParam->aItensLicitacao as $item) {

                    $aItensLicitacao = array();
                    $rsResultado = $clliclicita->sql_record($clliclicita->sql_query_resultado_retifica_pncp($oParam->iLicitacao, $item->l21_ordem));

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
                    $rsApiPNCP = $clResultadoItensPNCP->retificarResultado($odadosResultado, $oDadosAvisoPNCP->l213_numerocompra, $oDadosAvisoPNCP->l213_anousu, $item->l21_ordem, $oDadosResultado->l214_numeroresultado);

                    if ($rsApiPNCP[0] != 201) {
                        throw new Exception(utf8_decode($rsApiPNCP[1]));
                    }
                }

                //RETIFICAR O ITEM ALTERANDO A SITUACAO
                foreach ($oParam->aItensLicitacao as $item) {

                    $aItensRetificaItemLicitacao = array();
                    $rsItensRetificacao = $clliclicita->sql_record($clliclicita->sql_query_pncp_itens_retifica_situacao($oParam->iLicitacao, $item->l21_ordem));

                    for ($i = 0; $i < pg_num_rows($rsItensRetificacao); $i++) {
                        $oDadosResultado = db_utils::fieldsMemory($rsItensRetificacao, $i);
                        $aItensRetificaItemLicitacao[] = $oDadosResultado;
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
