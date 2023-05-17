<?php

use function GuzzleHttp\json_encode;

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
require_once("classes/db_liclicitaportalcompras_classe.php");
require_once("model/licitacao/PortalCompras/Fabricas/LicitacaoFabrica.model.php");
require_once("model/licitacao/PortalCompras/Comandos/EnviadorLicitacao.model.php");

$cl_liclicitaportalcompras = new cl_liclicitaportalcompras;
$licitacaoFabrica  = new LicitacaoFabrica;

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));

$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = '';
$oRetorno->itens   = array();

switch ($oParam->exec) {
    case 'EnviarPregao':
            try {
                $codigo    = $oParam->codigo;
                $results   = $cl_liclicitaportalcompras->buscaLicitacoes($codigo);

                if (empty($results)) {
                    throw new Exception("Registro não encontrado");
                }

                $licitacao = $licitacaoFabrica->criar($results, $cl_liclicitaportalcompras->numrows);

                $chaveAcesso = db_utils::fieldsMemory(
                    $cl_liclicitaportalcompras->buscaChaveDeAcesso(
                        db_getsession("DB_instit")
                        )
                , 0)->chaveacesso;
                if (empty($chaveAcesso)) {
                    throw new Exception("Chave de acesso não está cadastrada");
                }

                $url = $licitacao->getUrlPortalCompras($chaveAcesso);

                $enviador  = new EnviadorLicitacao();
                $resultado = $enviador->enviar($licitacao, $url);

                $oRetorno->message = $resultado['message'];
                $oRetorno->status = (int)$resultado['success'];
            } catch (Exception $oErro) {

                $oRetorno->message = $oErro->getMessage();
                $oRetorno->status  = 2;
            }
        break;
}
echo json_encode($oRetorno);
