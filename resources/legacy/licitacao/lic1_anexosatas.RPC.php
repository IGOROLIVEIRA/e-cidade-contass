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
require_once("classes/db_anexosataspncp_classe.php");
require_once("classes/db_controleanexosataspncp_classe.php");

db_app::import("configuracao.DBDepartamento");

$cl_licanexoataspncp = new cl_licanexoataspncp();
$oJson              = new services_json();
$oParam             = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oErro              = new stdClass();
$oRetorno           = new stdClass();
$oRetorno->status   = 1;

switch ($oParam->exec) {

    case 'salvarDocumento':

        try {
            db_inicio_transacao();

            global $conn;

            if (!file_exists($oParam->arquivo)) {
                throw new Exception("Arquivo do Documento não Encontrado.");
            }

            $aNomeArquivo = explode("/", $oParam->arquivo);
            $sNomeArquivo = str_replace(" ", "_", $aNomeArquivo[1]);

            /**
             * Abre um arquivo em formato binario somente leitura
             */
            $rDocumento = fopen($oParam->arquivo, "rb");

            /**
             * Pega todo o conteúdo do arquivo e coloca no resource
             */
            $rDadosDocumento = fread($rDocumento, filesize($oParam->arquivo));
            fclose($rDocumento);
            $oOidBanco = pg_lo_create();

            $cl_licanexoataspncp->l216_codigoata = $oParam->sequencial;
            $cl_licanexoataspncp->l216_tipoanexo = $oParam->tipoanexo;
            $cl_licanexoataspncp->l216_oid = $oOidBanco;
            $cl_licanexoataspncp->l216_instit = db_getsession('DB_instit');
            $cl_licanexoataspncp->incluir();

            if ($cl_licanexoataspncp->erro_status == '0') {
                throw new Exception($cl_licanexoataspncp->erro_msg);
            }

            $oObjetoBanco = pg_lo_open($conn, $oOidBanco, "w");
            pg_lo_write($oObjetoBanco, $rDadosDocumento);
            pg_lo_close($oObjetoBanco);

            $oRetorno->message = "Anexo Salvo com Sucesso !";

            db_fim_transacao();

        } catch (Exception $oErro) {
            $oRetorno->status = 2;
            $oRetorno->message = urlencode($oErro->getMessage());
            db_fim_transacao(true);
        }
        break;

    case 'getAnexos':

        $campos = "l216_sequencial,
        CASE
            WHEN l216_tipoanexo = 11 THEN 'Ata de Registro de Preço'
        END AS l216_tipoanexo";

        $resultAnexos = $cl_licanexoataspncp->sql_record($cl_licanexoataspncp->sql_query(null, $campos, null, "l216_codigoata = $oParam->sequencial"));

        for ($iCont = 0; $iCont < pg_num_rows($resultAnexos); $iCont++) {
            $oDadosAnexo = db_utils::fieldsMemory($resultAnexos, $iCont);

            $oDocumentos      = new stdClass();
            $oDocumentos->iCodigo = $oDadosAnexo->l216_sequencial;
            $oDocumentos->sTipo   = urlencode($oDadosAnexo->l216_tipoanexo);
            $oRetorno->dados[]    = $oDocumentos;
        }

        $oRetorno->detalhe    = "documentos";
        break;

    case 'excluirAnexo':
        try {
            db_inicio_transacao();
            $clcontroleanexosataspncp = new cl_controleanexosataspncp();
            $rsAnexosPNCP = $clcontroleanexosataspncp->sql_record($clcontroleanexosataspncp->sql_query(null,"*",null,"l217_sequencialarquivo = $oParam->codAnexo"));

            if(pg_num_rows($rsAnexosPNCP)){
                throw new Exception('Anexo já enviado ao PNCP, para excluí-lo é necessário que seja primeiro EXCLUÍDO no PNCP.');
            }else {
                $cl_licanexoataspncp->excluir($oParam->codAnexo);
                if ($cllicobrasanexo->erro_status == '0') {
                    throw new Exception($cllicobrasanexo->erro_msg);
                }
            }

            db_fim_transacao();
        } catch (Exception $eErro) {
            $oRetorno->status = 2;
            $oRetorno->message = utf8_encode($eErro->getMessage());
        }

        break;

    case 'downloadDocumento':
        $result = $cl_licanexoataspncp->sql_record($cl_licanexoataspncp->sql_query(null, "*", null, "l216_sequencial = $oParam->codAnexo"));
        db_fieldsmemory($result, 0);

        db_inicio_transacao();

        // Abrindo o objeto no modo leitura "r" passando como parâmetro o OID.
        $sNomeArquivo = "tmp/$l216_oid.pdf";
        pg_lo_export($conn, $l216_oid, $sNomeArquivo);

        db_fim_transacao();
        $oRetorno->nomearquivo = $sNomeArquivo;

        break;
}
echo json_encode($oRetorno);
