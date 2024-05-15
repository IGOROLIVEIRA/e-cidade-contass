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
require_once("classes/db_controleanexostermospncp_classe.php");
require_once("classes/db_acocontroletermospncp_classe.php");
require_once("classes/db_anexotermospncp_classe.php");
require_once("model/licitacao/PNCP/TermodeContratoPNCP.model.php");


$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));

$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = 1;
$oRetorno->itens   = array();
$clcontroleanexostermospncp = new cl_controleanexostermospncp();
$clacocontroletermospncp = new cl_acocontroletermospncp();
$clanexotermospncp = new cl_anexotermospncp();


switch ($oParam->exec) {
    case 'EnviarDocumentoPNCP':

        $rsTermo = $clacocontroletermospncp->sql_record($clacocontroletermospncp->sql_query($oParam->iCodigoTermo));
        $oDadosTermo = db_utils::fieldsMemory($rsTermo, 0);

        foreach ($oParam->aDocumentos as $iDocumentos) {

            try {

                $rsAnexosPNCP = $clcontroleanexostermospncp->sql_record($clcontroleanexostermospncp->sql_query_file(null, " * ", null, "ac57_sequencialarquivo = " . $iDocumentos));

                if (pg_num_rows($rsAnexosPNCP) > 0) {
                    throw new Exception("O documento do codigo " . $iDocumentos . " ja foi enviado !");
                }

                //validacao para enviar somente idocumentos de termos que ja foram enviados para PNCP
                if (pg_num_rows($rsTermo) == null) {
                    throw new Exception("Termo não localizado no PNCP !");
                }

                $campos = "anexotermospncp.*,
                           CASE
                               WHEN ac56_tipoanexo = 13 THEN 'Termo de Rescisão'
                               WHEN ac56_tipoanexo = 14 THEN 'Termo Aditivo'
                               WHEN ac56_tipoanexo = 15 THEN 'Termo de Apostilamento'
                               WHEN ac56_tipoanexo = 17 THEN 'Nota de Empenho'
                           END AS descricao";

                //busco os dados dos anexos para envio
                $rsAnexos = $clanexotermospncp->sql_record($clanexotermospncp->sql_query($iDocumentos,$campos));

                $oDadosAnexo = db_utils::fieldsMemory($rsAnexos, 0);

                //envio
                $cltermocontrato = new TermodeContrato();
                $rsApiPNCP = $cltermocontrato->enviarAnexos($oDadosTermo->l214_anousu,$oDadosTermo->l214_numcontratopncp,$oDadosTermo->l214_numerotermo,$oDadosAnexo->ac56_anexo,$oDadosAnexo->descricao,$oDadosAnexo->ac56_tipoanexo);

                if ($rsApiPNCP[0] == 201) {

                    $sAnexoPNCP = explode('x-content-type-options', $rsApiPNCP[1]);
                    $sAnexoPNCP = preg_replace('#\s+#', '', $sAnexoPNCP);
                    $sAnexoPNCP = explode('/', $sAnexoPNCP[0]);

                    $clcontroleanexostermospncp = new cl_controleanexostermospncp();
                    //monto o codigo dos arquivos do anexo no pncp
                    $clcontroleanexostermospncp->ac57_acordo  = $oDadosTermo->l214_acordo;
                    $clcontroleanexostermospncp->ac57_usuario = db_getsession('DB_id_usuario');
                    $clcontroleanexostermospncp->ac57_dataenvio = date('Y-m-d', db_getsession('DB_datausu'));
                    $clcontroleanexostermospncp->ac57_sequencialtermo = $oDadosTermo->l214_numerotermo;
                    $clcontroleanexostermospncp->ac57_tipoanexo = $oDadosAnexo->ac56_tipoanexo;
                    $clcontroleanexostermospncp->ac57_instit = db_getsession('DB_instit');
                    $clcontroleanexostermospncp->ac57_ano = $sAnexoPNCP[8];
                    $clcontroleanexostermospncp->ac57_sequencialpncp = $sAnexoPNCP[13];
                    $clcontroleanexostermospncp->ac57_sequencialarquivo = $iDocumentos;

                    $clcontroleanexostermospncp->incluir();

                    $oRetorno->status  = 1;
                    $oRetorno->message = "Enviado com Sucesso !";
                }else {
                    throw new Exception(utf8_decode($rsApiPNCP[1]));
                }

            } catch (Exception $oErro) {
                $oRetorno->message = urlencode($oErro->getMessage());
                $oRetorno->status  = 2;
            }
        }

        break;
    case 'ExcluirDocumentoPNCP':

        foreach ($oParam->aDocumentos as $iDocumentos) {

            try {

                $rsAnexos = $clcontroleanexostermospncp->sql_record($clcontroleanexostermospncp->sql_query(null, " * ", null, "l214_sequencial = $oParam->iCodigoTermo and ac57_sequencialarquivo=$iDocumentos"));
                $oDadosAnexo = db_utils::fieldsMemory($rsAnexos, 0);

                if (pg_num_rows($rsAnexos) == null) {
                    throw new Exception("O documento do codigo " . $iDocumentos . " não foi enviado no PNCP!");
                }

                //envio exclusao
                $cltermocontrato = new TermodeContrato();
                $rsApiPNCP = $cltermocontrato->excluirAnexos($oDadosAnexo->ac57_ano, $oDadosAnexo->l214_numcontratopncp, $oDadosAnexo->l214_numerotermo,$oDadosAnexo->ac57_sequencialpncp);

                if ($rsApiPNCP[0] == 201) {

                    $clcontroleanexostermospncp->excluir($oDadosAnexo->ac57_sequencial);

                    $oRetorno->status  = 1;
                    $oRetorno->message = "Enviado com Sucesso !";
                }
            } catch (Exception $oErro) {

                $oRetorno->status  = 2;
                $oRetorno->message = urlencode($oErro->getMessage());
            }
        }
        break;
}
echo json_encode($oRetorno);
