<?php
require_once('libs/db_stdlib.php');
require_once('libs/db_utils.php');
require_once('libs/db_app.utils.php');
require_once('libs/db_conecta.php');
require_once('libs/db_sessoes.php');
require_once('dbforms/db_funcoes.php');
require_once('libs/JSON.php');
require_once('model/pessoal/ImportarNomeReceita.model.php');

$oJson = new services_json();
$oParam = JSON::create()->parse(str_replace('\\', "", $_POST["json"]));
$oRetorno = new stdClass();
$oRetorno->iStatus = 1;
$oRetorno->sMessage = '';

try {
    switch ($oParam->exec) {

        case "importarReceita":
            if (!file_exists($oParam->sPath)) {
                throw new Exception("Houve um erro ao realizar upload do arquivo. Tente novamente.");
            }

            db_inicio_transacao();
            $oImportarNomeReceita = new ImportarNomeReceita($oParam->sPath);
            $oImportarNomeReceita->processar();
            db_fim_transacao(false);
            $oRetorno->sMessage = "Dados importados com sucesso.";

            unlink($oParam->sPath);
            break;
    }
} catch (Exception $eErro) {
    if (db_utils::inTransaction()) {
        db_fim_transacao(true);
    }
    $oRetorno->iStatus  = 2;
    $oRetorno->sMessage = $eErro->getMessage();
}

$oRetorno->erro = $oRetorno->iStatus == 2;
echo JSON::create()->stringify($oRetorno);
