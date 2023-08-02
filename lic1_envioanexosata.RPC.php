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
require_once("classes/db_controleanexosataspncp_classe.php");
require_once("classes/cl_licontroleatarppncp.php");
require_once("classes/db_anexosataspncp_classe.php");
require_once("model/licitacao/PNCP/AtaRegistroprecoPNCP.model.php");


$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));

$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = 1;
$oRetorno->itens   = array();
$clcontroleanexosataspncp = new cl_controleanexosataspncp();
$cllicontroleatarppncp = new cl_licontroleatarppncp();
$cllicanexoataspncp = new cl_licanexoataspncp();


switch ($oParam->exec) {
    case 'EnviarDocumentoPNCP':

        $rsAta = $cllicontroleatarppncp->sql_record($cllicontroleatarppncp->sql_query(null,"*",null,"l221_sequencial = $oParam->iCodigoAta"));

        $oDadosAtas = db_utils::fieldsMemory($rsAta, 0);

        foreach ($oParam->aDocumentos as $iDocumentos) {

            try {

                $rsAnexosPNCP = $clcontroleanexosataspncp->sql_record($clcontroleanexosataspncp->sql_query_file(null, " * ", null, "l217_sequencial = " . $iDocumentos));

                if (pg_num_rows($rsAnexosPNCP) > 0) {
                    throw new Exception("O documento do codigo " . $iDocumentos . " ja foi enviado !");
                }

                //validacao para enviar somente idocumentos de termos que ja foram enviados para PNCP
                if (pg_num_rows($rsAta) == null) {
                    throw new Exception("Ata não localizada no PNCP !");
                }

                $campos = "licanexoataspncp.*,
                           CASE
                               WHEN ac56_tipoanexo = 11 THEN 'Ata de Registro de Preço'
                           END AS descricao";

                //busco os dados dos anexos para envio
                $rsAnexos = $cllicanexoataspncp->sql_record($cllicanexoataspncp->sql_query($iDocumentos,$campos));

                $oDadosAnexo = db_utils::fieldsMemory($rsAnexos, 0);

                //envio
                $cltermocontrato = new AtaRegistroprecoPNCP();
                $rsApiPNCP = $cltermocontrato->enviarAnexos($oDadosAtas->l214_anousu,$oDadosAtas->l214_numcontratopncp,$oDadosAtas->l214_numerotermo,$oDadosAnexo->ac56_anexo,$oDadosAnexo->descricao,$oDadosAnexo->ac56_tipoanexo);

                if ($rsApiPNCP[0] == 201) {

                    $sAnexoPNCP = explode('x-content-type-options', $rsApiPNCP[1]);
                    $sAnexoPNCP = preg_replace('#\s+#', '', $sAnexoPNCP);
                    $sAnexoPNCP = explode('/', $sAnexoPNCP[0]);

                    $clcontroleanexosataspncp = new cl_controleanexosataspncp();
                    //monto o codigo dos arquivos do anexo no pncp
                    $clcontroleanexosataspncp->ac57_acordo  = $oDadosAtas->l214_acordo;
                    $clcontroleanexosataspncp->ac57_usuario = db_getsession('DB_id_usuario');
                    $clcontroleanexosataspncp->ac57_dataenvio = date('Y-m-d', db_getsession('DB_datausu'));
                    $clcontroleanexosataspncp->ac57_sequencialtermo = $oDadosAtas->l214_numerotermo;
                    $clcontroleanexosataspncp->ac57_tipoanexo = $oDadosAnexo->ac56_tipoanexo;
                    $clcontroleanexosataspncp->ac57_instit = db_getsession('DB_instit');
                    $clcontroleanexosataspncp->ac57_ano = $sAnexoPNCP[8];
                    $clcontroleanexosataspncp->ac57_sequencialpncp = $sAnexoPNCP[13];
                    $clcontroleanexosataspncp->ac57_sequencialarquivo = $iDocumentos;

                    $clcontroleanexosataspncp->incluir();

                    $oRetorno->status  = 1;
                    $oRetorno->message = "Enviado com Sucesso !";
                }
            } catch (Exception $oErro) {

                $oRetorno->message = $oErro->getMessage();
                $oRetorno->status  = 2;
            }
        }

        break;
    case 'ExcluirDocumentoPNCP':

        foreach ($oParam->aDocumentos as $iDocumentos) {

            try {

                $rsAnexos = $clcontroleanexosataspncp->sql_record($clcontroleanexosataspncp->sql_query(null, " * ", null, "l214_sequencial = $oParam->iCodigoAta and ac57_sequencialarquivo=$iDocumentos"));
                $oDadosAnexo = db_utils::fieldsMemory($rsAnexos, 0);

                if (pg_num_rows($rsAnexos) == null) {
                    throw new Exception("O documento do codigo " . $iDocumentos . " não foi enviado no PNCP!");
                }

                //envio exclusao
                $cltermocontrato = new TermodeContrato();
                $rsApiPNCP = $cltermocontrato->excluirAnexos($oDadosAnexo->ac57_ano, $oDadosAnexo->l214_numcontratopncp, $oDadosAnexo->l214_numerotermo,$oDadosAnexo->ac57_sequencialpncp);

                if ($rsApiPNCP[0] == 201) {

                    $clcontroleanexosataspncp->excluir($oDadosAnexo->ac57_sequencial);

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
