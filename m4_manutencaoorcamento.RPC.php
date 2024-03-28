<?php

use App\Services\Patrimonial\Orcamento\ManutencaoOrcamentoService;
use App\Services\Patrimonial\Orcamento\PcOrcamService;

require_once 'libs/db_stdlib.php';
require_once 'libs/JSON.php';

db_postmemory($_POST);

$oJson = new services_json();
$oParam = json_decode(str_replace('\\', '', $_POST['json']));

$oRetorno = new stdClass();
$oRetorno->status = 1;
$oRetorno->erro = '';

try {
    switch ($oParam->sExecuta) {
        case 'processar':

            $pcOrcamService = new PcOrcamService();
            $oRetorno->dados = $pcOrcamService->getDadosManutencaoOrcamento($oParam->sequencial, $oParam->origemOrcamento);

            break;

        case 'salvar':

            $manutencaoOrcamentoService = new ManutencaoOrcamentoService();
            $manutencaoOrcamentoService->save($oParam->oPcOrcam, $oParam->aItens);

            break;
    }
} catch (Exception $e) {
    $oRetorno->erro = urlencode($e->getMessage());
    $oRetorno->status = 2;
}

echo $oJson->encode(DBString::utf8_encode_all($oRetorno));
