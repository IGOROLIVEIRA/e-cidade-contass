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
require_once("classes/db_acordo_classe.php");
require_once("classes/db_contratos_classe.php");
require_once("classes/db_acocontratopncp_classe.php");
require_once("model/contrato/PNCP/ContratoPNCP.model.php");
require_once("model/Acordo.model.php");

db_app::import("configuracao.DBDepartamento");
$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

switch ($oParam->exec) {
    case 'getContratos':
        $clcontratos = new cl_acordo; 
        $rsContrato = $clcontratos->sql_record($clcontratos->sql_Contrato_PCNP(null,"ac16_sequencial,ac213_numerocontrolepncp, ",null,"ac16_instit = " . db_getsession('DB_instit')));
        
        for ($iCont = 0; $iCont < pg_num_rows($rsContrato); $iCont++) {

            $oContratos = db_utils::fieldsMemory($rsContrato, $iCont);
            $oContrato      = new stdClass();
            $oContrato->sequencial      = $oContratos->ac16_sequencial;
            $oContrato->objeto          = utf8_encode($oContratos->objetocontrato);
            $oContrato->contrato        = $oContratos->numerocontratoempenho.'/'.$oContratos->anocontrato;
            $oContrato->fornecedor      = utf8_encode($oContratos->nomerazaosocialfornecedor);
            $oContrato->licitacao       = $oContratos->processo;
            $oContrato->numerocontrolepncp = $oContratos->ac213_numerocontrolepncp;
            
            $itens[] = $oContrato;
        }
        $oRetorno->contratos = $itens;
        break;

    case 'enviarContrato':
        $clContrato  = db_utils::getDao("acordo");
        $clacocontrolepncp = db_utils::getDao("acocontratopncp"); 
        //todas as contratos marcadas
        try {
            foreach ($oParam->aContratos as $aContrato) {
                //Contrato
                $rsDadosEnvio = $clContrato->sql_record($clContrato->sql_ItensContrato_PCNP($aContrato->codigo));
                           
                $aItensContrato = array();
                for ($aco = 0; $aco < pg_numrows($rsDadosEnvio); $aco++) {
                    $oDadosContrato = db_utils::fieldsMemory($rsDadosEnvio, $aco);
                    $tipoDocumento = $oDadosContrato->tipocontratoid;
                    $processo = $oDadosContrato->processo;
                }
                
                $clContratoPNCP = new ContratoPNCP($oDadosContrato);
                //monta o json com os dados da Contrato
                $oDados = $clContratoPNCP->montarDados();
                $arraybensjson = json_encode(DBString::utf8_encode_all($oDados));  
                
                $rsApiPNCP = $clContratoPNCP->enviarContrato($arraybensjson,$processo,$tipoDocumento);
                
                if ($rsApiPNCP[1] == 201) {
                    $codigocontrato = explode('x-content-type-options',$rsApiPNCP[0]);
                    $clacocontrolepncp = new cl_acocontratopncp();
                    //monto o codigo do contrato no pncp
                    $ac213_numerocontrolepncp = '17316563000196-1-' . str_pad(substr($codigocontrato[0], 76), 6, '0', STR_PAD_LEFT) . '/' . $oDadosContrato->anocontrato;
                    $clacocontrolepncp->ac213_contrato = $aContrato->codigo;
                    $clacocontrolepncp->ac213_usuario = db_getsession('DB_id_usuario');
                    $clacocontrolepncp->ac213_dtlancamento = date('Y-m-d', db_getsession('DB_datausu'));
                    $clacocontrolepncp->ac213_numerocontrolepncp = $ac213_numerocontrolepncp;
                    $clacocontrolepncp->ac213_situacao = 1;
                    $clacocontrolepncp->ac213_instit = db_getsession('DB_instit');
                    $clacocontrolepncp->incluir();
                    
                    $oRetorno->status  = 1;
                } else {
                    throw new Exception(utf8_decode($rsApiPNCP[0]));
                }
            }
        } catch (Exception $eErro) {
            $oRetorno->status  = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }

        break;

    case 'RetificarContrato':
        $clContrato  = db_utils::getDao("liclicita");
        try {
            foreach ($oParam->aContratos as $aContrato) {
                //somente contratos que ja foram enviadas para pncp
                $rsDadosEnvio = $clContrato->sql_record($clContrato->sql_query_pncp($aContrato->codigo));

                for ($aco = 0; $aco < pg_numrows($rsDadosEnvio); $aco++) {
                    $oDadosContrato = db_utils::fieldsMemory($rsDadosEnvio, $aco);
                }
                $clContratoPNCP = new ContratoPNCP($oDadosContrato);
                $oDadosRatificacao = $clContratoPNCP->montarRetificacao();
                $clContratoPNCP->enviarRetificacao($oDadosRatificacao);
            }
        } catch (Exception $eErro) {
            $oRetorno->status  = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }
        break;

    case 'ExcluirContrato': 
        
        try {
            foreach ($oParam->aContratos as $aContrato) {    
                $clContratoPNCP = new ContratoPNCP($oDadosContrato);
                $statusExclusão = $clContratoPNCP->excluirContrato($aContrato->codigo);
                // echo $statusExclusão->status;
                // print_r($statusExclusão);exit;
                if($statusExclusão->status == 200){
                    throw new Exception(utf8_decode($statusExclusão->message));
                }
                if($statusExclusão->status == 404){
                    throw new Exception(utf8_decode($statusExclusão->message));
                }
                if($statusExclusão->status == 422){
                    throw new Exception(utf8_decode($statusExclusão->message));
                }
                if($statusExclusão->status == 500){
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
