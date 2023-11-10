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
require_once("classes/db_empempenhopncp_classe.php");
require_once("model/contrato/PNCP/ContratoPNCP.model.php");
require_once("classes/db_empempenho_classe.php");
require_once("model/licitacao.model.php");

db_app::import("configuracao.DBDepartamento");
$envs = parse_ini_file('legacy_config/PNCP/.env', true);
$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

switch ($oParam->exec) {
    case 'getEmpenhos':
        $clliclicita = new cl_liclicita();
        $rsEmpenhos = $clliclicita->sql_record($clliclicita->sql_query_publicacaoEmpenho_pncp(null, " e213_numerocontrolepncp desc", "e60_anousu = " . db_getsession("DB_anousu"), null));

        for ($iCont = 0; $iCont < pg_num_rows($rsEmpenhos); $iCont++) {

            $oEmpenhos = db_utils::fieldsMemory($rsEmpenhos, $iCont);

            $oEmpenho      = new stdClass();

            $oEmpenho->sequencial      = $oEmpenhos->e60_numemp;
            $oEmpenho->objeto          = utf8_encode($oEmpenhos->objetocontrato);
            $oEmpenho->empenho         = $oEmpenhos->numerocontratoempenho . '/' . $oEmpenhos->anocontrato;
            $oEmpenho->fornecedor      = utf8_encode($oEmpenhos->nomerazaosocialfornecedor);
            $oEmpenho->licitacao       = $oEmpenhos->processo;
            $oEmpenho->numerocontrolepncp = $oEmpenhos->e213_numerocontrolepncp;

            $itens[] = $oEmpenho;
        }
        $oRetorno->empenhos = $itens;
        break;

    case 'enviarEmpenho':

        $clliclicita  = new cl_liclicita();
        $clEmpeempnho = new cl_empempenho();
        $clempcontrolepncp = db_utils::getDao("empempenhopncp");

        //todas os empenhos marcadas
        try {
            foreach ($oParam->aEmpenhos as $aEmpenho) {
                //pega a data do empenho
                $rsDataEmpenho = $clEmpeempnho->sql_record($clEmpeempnho->sql_query($aEmpenho->codigo, "e60_emiss", null, ""));
                $odataEmpenho = db_utils::fieldsMemory($rsDataEmpenho, 0);
                //Empenhos
                $rsDadosEnvio = $clliclicita->sql_record($clliclicita->sql_query_pncp_empenho($aEmpenho->codigo, $odataEmpenho->e60_emiss));

                for ($aco = 0; $aco < pg_numrows($rsDadosEnvio); $aco++) {
                    $oDadosEmpenho = db_utils::fieldsMemory($rsDadosEnvio, $aco);
                }

                $clliclicitaPNCP = new ContratoPNCP($oDadosEmpenho);
                //monta o json com os dados da Contrato
                $oDados = $clliclicitaPNCP->montarDados();

                $arraybensjson = json_encode(DBString::utf8_encode_all($oDados));

                $rsApiPNCP = $clliclicitaPNCP->enviarContrato($arraybensjson);

                if ($rsApiPNCP[0] == 201) {

                    $clempcontrolepncp = new cl_empempenhopncp();

                    //Ambiente de testes
                    if($envs['APP_ENV'] === 'T'){
                        $sequencial = trim(substr(str_replace('x-content-type-options', '', $rsApiPNCP[1]), 70));
                    }else{
                    //Ambiente de Producao
                        $sequencial = trim(substr(str_replace('x-content-type-options', '', $rsApiPNCP[1]), 63));
                    }
                    $e213_numerocontrolepncp = db_utils::getCnpj() . '-2-' . str_pad($sequencial, 6, '0', STR_PAD_LEFT) . '/' . $oDadosEmpenho->anocontrato;

                    //monto o codigo do contrato no pncp
                    $clempcontrolepncp->e213_contrato = $aEmpenho->codigo;
                    $clempcontrolepncp->e213_usuario = db_getsession('DB_id_usuario');
                    $clempcontrolepncp->e213_dtlancamento = date('Y-m-d', db_getsession('DB_datausu'));
                    $clempcontrolepncp->e213_numerocontrolepncp = $e213_numerocontrolepncp;
                    $clempcontrolepncp->e213_situacao = 1;
                    $clempcontrolepncp->e213_instit = db_getsession('DB_instit');
                    $clempcontrolepncp->e213_ano = $oDadosEmpenho->anocontrato;
                    $clempcontrolepncp->e213_sequencialpncp = $sequencial;
                    $clempcontrolepncp->incluir();

                    if ($clempcontrolepncp->erro_status == 0) {
                        throw new Exception($clempcontrolepncp->erro_msg);
                    }

                    $oRetorno->status  = 1;
                    $oRetorno->message = "Enviado com Sucesso !";
                } else {
                    throw new Exception(utf8_decode($rsApiPNCP[1]));
                }
            }
        } catch (Exception $eErro) {
            $oRetorno->status  = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }

        break;

    case 'RetificarEmpenho':
        $clliclicita  = db_utils::getDao("liclicita");
        $clempcontrolepncp = db_utils::getDao("empempenhopncp");
        $clEmpeempnho = new cl_empempenho();

        try {
            foreach ($oParam->aEmpenhos as $aEmpenho) {
                //pega a data do empenho
                $rsDataEmpenho = $clEmpeempnho->sql_record($clEmpeempnho->sql_query($aEmpenho->codigo, "e60_emiss", null, ""));
                $odataEmpenho = db_utils::fieldsMemory($rsDataEmpenho, 0);
                //Empenhos
                $rsDadosEnvio = $clliclicita->sql_record($clliclicita->sql_query_pncp_empenho($aEmpenho->codigo, $odataEmpenho->e60_emiss));

                for ($aco = 0; $aco < pg_numrows($rsDadosEnvio); $aco++) {
                    $oDadosEmpenhoExtras = db_utils::fieldsMemory($rsDadosEnvio, $aco);
                }

                $clliclicitaPNCP = new ContratoPNCP($oDadosEmpenhoExtras);
                $oDadosRatificacao = $clliclicitaPNCP->montarRetificacao();
                $arraybensjson = json_encode(DBString::utf8_encode_all($oDadosRatificacao));
                $rsApiPNCP = $clliclicitaPNCP->enviarRetificacaoEmpenho($arraybensjson, $oDadosEmpenhoExtras);
            }
        } catch (Exception $eErro) {
            $oRetorno->status  = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }
        break;


    case 'ExcluirEmpenho':
        $clliclicita = db_utils::getDao("liclicita");
        $clempcontrolepncp = new cl_empempenhopncp();

        try {
            foreach ($oParam->aEmpenhos as $aEmpenho) {
                $clempcontrolepncp = new cl_empempenhopncp();
                $clliclicitaPNCP = new ContratoPNCP($oDadosEmpenho);

                $rsContrato = $clempcontrolepncp->sql_record($clempcontrolepncp->sql_query_file(null, " * ", null, " e213_contrato = " . $aEmpenho->codigo));

                for ($iCont = 0; $iCont < pg_num_rows($rsContrato); $iCont++) {
                    $sequencialpncp = db_utils::fieldsMemory($rsContrato, $iCont);
                }

                $statusExclusão = $clliclicitaPNCP->excluirContrato($sequencialpncp->e213_sequencialpncp, $sequencialpncp->e213_ano, $sequencialpncp->e213_numerocontrolepncp);

                if ($statusExclusão->status == null)
                    $clempcontrolepncp->excluir($e123_sequencial = null, "e213_contrato = $aEmpenho->codigo");

                if ($statusExclusão->status == 404) {
                    throw new Exception(utf8_decode($statusExclusão->message));
                }
                if ($statusExclusão->status == 422) {
                    throw new Exception(utf8_decode($statusExclusão->message));
                }
                if ($statusExclusão->status == 500) {
                    throw new Exception(utf8_decode($statusExclusão->message));
                }
            }
        } catch (Exception $eErro) {
            $oRetorno->status  = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }
        break;
}
echo json_encode($oRetorno);
