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

                $rsAnexosPNCP = $clcontroleanexosataspncp->sql_record($clcontroleanexosataspncp->sql_query_file(null, " * ", null, "l217_sequencialarquivo = " . $iDocumentos));

                if (pg_num_rows($rsAnexosPNCP) > 0) {
                    throw new Exception("O documento do codigo " . $iDocumentos . " ja foi enviado !");
                }

                //validacao para enviar somente idocumentos de termos que ja foram enviados para PNCP
                if (pg_num_rows($rsAta) == null) {
                    throw new Exception("Ata não localizada no PNCP !");
                }
                $campos = "licanexoataspncp.*,
                           CASE
                               WHEN l216_tipoanexo = 11 THEN 'Ata de Registro de Preço'
                           END AS descricao";

                //busco os dados dos anexos para envio
                $rsAnexos = $cllicanexoataspncp->sql_record($cllicanexoataspncp->sql_query(null,$campos,null,"l216_sequencial = $iDocumentos"));
                $oDadosAnexo = db_utils::fieldsMemory($rsAnexos, 0);

                //envio
                $clataregistropreco = new AtaRegistroprecoPNCP();
                $rsApiPNCP = $clataregistropreco->enviarAnexos($oDadosAtas->l213_anousu,$oDadosAtas->l213_numerocompra,$oDadosAtas->l215_ata,$oDadosAnexo->l216_oid,$oDadosAnexo->descricao,$oDadosAnexo->l216_tipoanexo);

                if ($rsApiPNCP[0] == 201) {

                    $sAnexoPNCP = explode('x-content-type-options', $rsApiPNCP[1]);
                    $sAnexoPNCP = preg_replace('#\s+#', '', $sAnexoPNCP);
                    $sAnexoPNCP = explode('/', $sAnexoPNCP[0]);

                    $clcontroleanexosataspncp = new cl_controleanexosataspncp();
                    //monto o codigo dos arquivos do anexo no pncp
                    $clcontroleanexosataspncp->l217_licatareg  = $oParam->iCodigoAta;
                    $clcontroleanexosataspncp->l217_usuario = db_getsession('DB_id_usuario');
                    $clcontroleanexosataspncp->l217_dataenvio = date('Y-m-d', db_getsession('DB_datausu'));
                    $clcontroleanexosataspncp->l217_sequencialata = $oDadosAtas->l215_ata;
                    $clcontroleanexosataspncp->l217_tipoanexo = $oDadosAnexo->l216_tipoanexo;
                    $clcontroleanexosataspncp->l217_instit = db_getsession('DB_instit');
                    $clcontroleanexosataspncp->l217_anocompra = $oDadosAtas->l213_anousu;
                    $clcontroleanexosataspncp->l217_sequencialpncp = $sAnexoPNCP[13];
                    $clcontroleanexosataspncp->l217_sequencialarquivo = $iDocumentos;

                    $clcontroleanexosataspncp->incluir();

                    $oRetorno->status  = 1;
                    $oRetorno->message = "Enviado com Sucesso !";
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

                $rsAnexos = $clcontroleanexosataspncp->sql_record($clcontroleanexosataspncp->sql_query(null, " * ", null, "l217_sequencialarquivo = $iDocumentos"));

                $oDadosAnexo = db_utils::fieldsMemory($rsAnexos, 0);

                if (pg_num_rows($rsAnexos) == null) {
                    throw new Exception("O documento do codigo " . $iDocumentos . " não foi enviado no PNCP!");
                }

                //envio exclusao
                $clataregistropreco = new AtaRegistroprecoPNCP();
                $rsApiPNCP = $clataregistropreco->excluirAnexos($oDadosAnexo->l217_anocompra, $oDadosAnexo->l213_numerocompra, $oDadosAnexo->l217_sequencialata,$oDadosAnexo->l217_sequencialpncp);

                if ($rsApiPNCP[0] == 201) {

                    $clcontroleanexosataspncp->excluir($oDadosAnexo->l217_sequencial);

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
