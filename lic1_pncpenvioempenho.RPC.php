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
require_once("model/licitacao.model.php");

db_app::import("configuracao.DBDepartamento");
$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

switch ($oParam->exec) {
    case 'getEmpenhos':
        $clliclicita = new cl_liclicita();
        $rsEmpenhos = $clliclicita->sql_record($clliclicita->sql_query_publicacaoEmpenho_pncp(null, " e213_numerocontrolepncp desc","e60_anousu = " . db_getsession("DB_anousu"),null));
        
        for ($iCont = 0; $iCont < pg_num_rows($rsEmpenhos); $iCont++) {

            $oEmpenhos = db_utils::fieldsMemory($rsEmpenhos, $iCont);
            
            $oEmpenho      = new stdClass();
           
            $oEmpenho->sequencial      = $oEmpenhos->e60_numemp;
            $oEmpenho->objeto          = utf8_encode($oEmpenhos->objetocontrato);
            $oEmpenho->empenho         = $oEmpenhos->numerocontratoempenho.'/'.$oEmpenhos->anocontrato;
            $oEmpenho->fornecedor      = utf8_encode($oEmpenhos->nomerazaosocialfornecedor);
            $oEmpenho->licitacao       = $oEmpenhos->processo;
            $oEmpenho->numerocontrolepncp = $oEmpenhos->e213_numerocontrolepncp;
            
            $itens[] = $oEmpenho;
        }
        $oRetorno->empenhos = $itens;
    break;

    case 'enviarEmpenho':
        $clEmpenho  = new cl_liclicita();
        $clempcontrolepncp = db_utils::getDao("empempenhopncp");
               
        //todas os empenhos marcadas
        try {
            foreach ($oParam->aEmpenhos as $aEmpenho) {
              
                //Empenhos
                                
                $rsDadosEnvio = $clEmpenho->sql_record($clEmpenho->sql_query_pncp_empenho($aEmpenho->codigo));
                           
                for ($aco = 0; $aco < pg_numrows($rsDadosEnvio); $aco++) {
                    $oDadosEmpenho = db_utils::fieldsMemory($rsDadosEnvio, $aco);
                }
                
                $clEmpenhoPNCP = new ContratoPNCP($oDadosEmpenho);
                //monta o json com os dados da Contrato
                $oDados = $clEmpenhoPNCP->montarDados();
                
                $arraybensjson = json_encode(DBString::utf8_encode_all($oDados));  
                
                $rsApiPNCP = $clEmpenhoPNCP->enviarContrato($arraybensjson);
              
                if ($rsApiPNCP[1] == 201) {
                    
                    $codigoempenho = explode('x-content-type-options',$rsApiPNCP[0]);
                    $codigoempenho = preg_replace('#\s+#', '', $codigoempenho);
                    $clempcontrolepncp = new cl_empempenhopncp();
                    //monto o codigo do contrato no pncp
                    $e213_numerocontrolepncp = '17316563000196-2-' . str_pad(substr($codigoempenho[0], 75), 6, '0', STR_PAD_LEFT). '/' .$oDadosEmpenho->anocontrato;
                    $clempcontrolepncp->e213_contrato = $aEmpenho->codigo;
                    $clempcontrolepncp->e213_usuario = db_getsession('DB_id_usuario');
                    $clempcontrolepncp->e213_dtlancamento = date('Y-m-d', db_getsession('DB_datausu'));
                    $clempcontrolepncp->e213_numerocontrolepncp = $e213_numerocontrolepncp;
                    $clempcontrolepncp->e213_situacao = 1;
                    $clempcontrolepncp->e213_instit = db_getsession('DB_instit');
                    $clempcontrolepncp->e213_ano = substr($codigoempenho[0], 70, 4);
                    $clempcontrolepncp->e213_sequencialpncp = str_pad(substr($codigoempenho[0], 75), 6, '0', STR_PAD_LEFT);
                    $clempcontrolepncp->incluir();
                
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

        case 'RetificarEmpenho':
            $clEmpenho  = db_utils::getDao("liclicita");
            $clempcontrolepncp = db_utils::getDao("empempenhopncp");
            // $clEmpenho  = new cl_liclicita();
            // $clempcontrolepncp = db_utils::getDao("empempenhopncp");
            try {
                foreach ($oParam->aEmpenhos as $aEmpenho) {
                    //somente empenho que ja foram enviadas para pncp
                    $rsDadosExtras = $clEmpenho->sql_record($clEmpenho->sql_query_pncp_empenho_enviado($aEmpenho->codigo));
    
                    for ($aco = 0; $aco < pg_numrows($rsDadosExtras); $aco++) {
                        $oDadosEmpenhoExtras = db_utils::fieldsMemory($rsDadosExtras, $aco);
                    }
                   
                    $clEmpenhoPNCP = new ContratoPNCP($oDadosEmpenhoExtras);
                    $oDadosRatificacao = $clEmpenhoPNCP->montarRetificacao();
                    $arraybensjson = json_encode(DBString::utf8_encode_all($oDadosRatificacao)); 
                    $rsApiPNCP = $clEmpenhoPNCP->enviarRetificacaoEmpenho($arraybensjson,$oDadosEmpenhoExtras);
                }
            } catch (Exception $eErro) {
                $oRetorno->status  = 2;
                $oRetorno->message = urlencode($eErro->getMessage());
            }
            break;
    

        case 'ExcluirEmpenho': 
            $clEmpenho = db_utils::getDao("liclicita");
            $clempcontrolepncp = new cl_empempenhopncp();
            
            try {
                foreach ($oParam->aEmpenhos as $aEmpenho) {
                    $clempcontrolepncp = new cl_empempenhopncp();
                    $clEmpenhoPNCP = new ContratoPNCP($oDadosEmpenho);
                   
                    $rsContrato = $clempcontrolepncp->sql_record($clempcontrolepncp->sql_query_file(null," * ",null," e213_contrato = " . $aEmpenho->codigo));
                    
                    for ($iCont = 0; $iCont < pg_num_rows($rsContrato); $iCont++) {
                         $sequencialpncp = db_utils::fieldsMemory($rsContrato, $iCont);
                    }    
                                       
                    $statusExclusão = $clEmpenhoPNCP->excluirContrato($sequencialpncp->e213_sequencialpncp,$sequencialpncp->e213_ano,$sequencialpncp->e213_numerocontrolepncp);
                    
                    if($statusExclusão->status == null)
                        $clempcontrolepncp->excluir($e123_sequencial = null,"e213_contrato = $aEmpenho->codigo");
                    
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
