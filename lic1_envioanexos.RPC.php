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
require_once("classes/cl_licontroleatarppncp.php");
require_once("model/licitacao/PNCP/AvisoLicitacaoPNCP.model.php");
require_once("model/licitacao/PNCP/AtaRegistroprecoPNCP.model.php");
require_once("classes/db_licacontrolenexospncp_classe.php");
require_once("classes/db_licanexopncp_classe.php");



$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));

$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = 1;
$oRetorno->itens   = array();

switch ($oParam->exec) {
    case 'EnviarDocumentoPNCP':

        $cl_liccontroleanexopncp = new cl_liccontroleanexopncp();
        $clliccontrolepncp = new cl_liccontrolepncp();
        $cllicanexopncp = new cl_licanexopncp();

        foreach ($oParam->aDocumentos as $iDocumentos) {

            try {

                $rsAnexos = $cl_liccontroleanexopncp->sql_record($cl_liccontroleanexopncp->sql_query_file(null, " * ", null, "l218_sequencialarquivo = " . $iDocumentos." and l218_licitacao ". $oParam->iCodigoProcesso));

                if (pg_num_rows($rsAnexos) > 0) {
                    throw new Exception("O documento do codigo " . $iDocumentos . " ja foi enviado !");
                }

                $rsAvisodeContratacao = $clliccontrolepncp->sql_record($clliccontrolepncp->sql_query_file(null, " * ", null, "l213_licitacao = " . $oParam->iCodigoProcesso));

                //validacao para enviar somente idocumentos de contratos que ja foram enviados para PNCP
                if (pg_num_rows($rsAvisodeContratacao) == null) {
                    throw new Exception("Compra não localizada no PNCP, verificar a publicação!");
                }

                for ($iCont = 0; $iCont < pg_num_rows($rsAvisodeContratacao); $iCont++) {
                    $dadospncp = db_utils::fieldsMemory($rsAvisodeContratacao, $iCont);
                }

                //busco os dados dos anexos para envio
                $rsAnexos = $cllicanexopncp->sql_record($cllicanexopncp->sql_anexos_licitacao($oParam->iCodigoProcesso, $iDocumentos));

                for ($Anex = 0; $Anex < pg_num_rows($rsAnexos); $Anex++) {
                    $oDadosAnexo = db_utils::fieldsMemory($rsAnexos, $Anex);
                }

                //envio
                $clAvisoLicitacaoPNCP = new AvisoLicitacaoPNCP();
                $rsApiPNCP = $clAvisoLicitacaoPNCP->enviarAnexos($oDadosAnexo->l216_tipoanexo, utf8_decode($oDadosAnexo->l213_descricao), $oDadosAnexo->l216_nomedocumento, $dadospncp->l213_anousu, $dadospncp->l213_numerocompra);

                if ($rsApiPNCP[0] == 201) {

                    $sAnexoPNCP = explode('x-content-type-options', $rsApiPNCP[1]);
                    $sAnexoPNCP = preg_replace('#\s+#', '', $sAnexoPNCP);
                    $sAnexoPNCP = explode('/', $sAnexoPNCP[0]);

                    $clliccontroleanexopncp = new cl_liccontroleanexopncp();

                    //monto o codigo dos arquivos do anexo no pncp
                    $l218_numerocontrolepncp = db_utils::getCnpj() . '-2-' . str_pad($sAnexoPNCP[9], 6, '0', STR_PAD_LEFT) . '/' . $sAnexoPNCP[8];
                    $clliccontroleanexopncp->l218_licitacao  = $oParam->iCodigoProcesso;
                    $clliccontroleanexopncp->l218_usuario = db_getsession('DB_id_usuario');
                    $clliccontroleanexopncp->l218_dtlancamento = date('Y-m-d', db_getsession('DB_datausu'));
                    $clliccontroleanexopncp->l218_numerocontrolepncp = $l218_numerocontrolepncp;
                    $clliccontroleanexopncp->l218_tipoanexo = $oDadosAnexo->l216_tipoanexo;
                    $clliccontroleanexopncp->l218_instit = db_getsession('DB_instit');
                    $clliccontroleanexopncp->l218_ano = $sAnexoPNCP[8];
                    $clliccontroleanexopncp->l218_sequencialpncp = $sAnexoPNCP[11];
                    $clliccontroleanexopncp->l218_sequencialarquivo = $iDocumentos;
                    $clliccontroleanexopncp->l218_processodecompras = null;

                    $clliccontroleanexopncp->incluir();

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
        $cl_liccontroleanexopncp = new cl_liccontroleanexopncp();
        $clliccontrolepncp = new cl_liccontrolepncp();
        $cllicanexopncp = new cl_licanexopncp();

        foreach ($oParam->aDocumentos as $iDocumentos) {

            try {

                $rsAnexos = $cl_liccontroleanexopncp->sql_record($cl_liccontroleanexopncp->sql_query_file(null, " * ", null, "l218_sequencialarquivo = " . $iDocumentos));

                if (pg_num_rows($rsAnexos) == null) {
                    throw new Exception("O documento do codigo " . $iDocumentos . " não foi enviado no PNCP!");
                }

                $rsAvisodeContratacao = $clliccontrolepncp->sql_record($clliccontrolepncp->sql_query_file(null, " * ", null, "l213_licitacao = " . $oParam->iCodigoProcesso));

                //validacao para enviar somente idocumentos de contratos que ja foram enviados para PNCP
                if (pg_num_rows($rsAvisodeContratacao) == null) {
                    throw new Exception("Compra não localizada no PNCP, verificar a publicação!");
                }

                for ($iCont = 0; $iCont < pg_num_rows($rsAvisodeContratacao); $iCont++) {
                    $dadospncp = db_utils::fieldsMemory($rsAvisodeContratacao, $iCont);
                }

                for ($Anex = 0; $Anex < pg_num_rows($rsAnexos); $Anex++) {
                    $oDadosAnexo = db_utils::fieldsMemory($rsAnexos, $Anex);
                }

                //envio exclusao
                $clAvisoLicitacaoPNCP = new AvisoLicitacaoPNCP();
                $rsApiPNCP = $clAvisoLicitacaoPNCP->excluirAnexos($dadospncp->l213_anousu, $dadospncp->l213_numerocompra, $oDadosAnexo->l218_sequencialpncp);

                if ($rsApiPNCP[0] == 201) {
                    $clliccontroleanexopncp = new cl_liccontroleanexopncp();
                    $clliccontroleanexopncp->excluir($oDadosAnexo->l218_sequencial);
                    $cllicanexopncp->excluir($oParam->iCodigoProcesso);
                    $oRetorno->status  = 1;
                    $oRetorno->message = "Enviado com Sucesso !";
                }else{
                    $oRetorno->status  = 2;
                    throw new Exception($rsApiPNCP[1]);
                }
            } catch (Exception $oErro) {

                $oRetorno->status  = 2;
                $oRetorno->message = urlencode($oErro->getMessage());
            }
        }
        break;
}
echo json_encode($oRetorno);
