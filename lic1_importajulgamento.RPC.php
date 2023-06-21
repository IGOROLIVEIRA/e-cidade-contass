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
require_once("classes/db_liclicitaimportarjulgamento_classe.php");
require_once("model/licitacao/PortalCompras/Julgamento/Comandos/BuscaJulgamento.model.php");
require_once("model/licitacao/PortalCompras/Comandos/ValidaChaveAcesso.model.php");
require_once("model/licitacao/PortalCompras/Julgamento/Fabricas/JulgamentoFabrica.model.php");
require_once("model/licitacao/PortalCompras/Julgamento/Comandos/InsereJulgalmento.model.php");
require_once("model/licitacao/PortalCompras/Julgamento/Comandos/ValidaFornecedores.model.php");

$cl_liclcitaimportarjulgamento = new cl_liclicitaimportarjulgamento();

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));

$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = '';
$oRetorno->itens   = array();


switch ($oParam->exec) {
    case 'BuscarDados':
            try {
                $busca = $cl_liclcitaimportarjulgamento->buscarModalidadeComObjeto($oParam->codigo);
                $resource = db_utils::fieldsMemory($busca, 0);
                $resultado['id'] = $resource->id;
                $resultado['modalidade'] = utf8_encode($resource->modalidade);
                $resultado['numero'] = $resource->numeroprocesso.'/'.$resource->anoprocesso;
                $resultado['objeto'] = utf8_encode($resource->objeto);
                $resultado['situacao'] = $resource->situacao;
                $oRetorno->message = $resultado;
                $oRetorno->status = 1;

            } catch (Exception $oErro) {
                $oRetorno->message = $oErro->getMessage();
                $oRetorno->status  = 2;
            }
        break;
    case 'ProcessaJulgamento':
        try{
            $codigo = $oParam->codigo;
            $chaveAcesso = (new ValidaChaveAcesso)->execute();
            $julgamentoFabrica = new JulgamentoFabrica();
            $validadorFornecedores = new ValidaFornecedores();

            $buscador = new BuscaJulgamento();

            $dados = $buscador->execute((int)$codigo, $chaveAcesso);

            if ($dados['success'] === false) {
                throw new Exception($dados['message']);
            }

            $julgamento = $julgamentoFabrica->criar($dados['message']);

            $validadorFornecedores->execute($julgamento);

            $insereJugalmento = new  InsereJulgamento;
            $resultado = $insereJugalmento->execute($julgamento);

            if ($resultado['success'] === false) {
                throw new Exception($resultado['message']);
            }

            $oRetorno->message = "Julgamento inserido com sucesso";
            $oRetorno->status = 1;
        } catch(Exception $oErro) {
            $oRetorno->message = $oErro->getMessage();
            $oRetorno->status  = 2;
        }
}



echo json_encode($oRetorno);
