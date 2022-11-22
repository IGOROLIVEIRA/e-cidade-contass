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
require_once("model/licitacao/PNCP/AvisoLicitacaoPNCP.model.php");

db_app::import("configuracao.DBDepartamento");
$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

switch ($oParam->exec) {
    case 'getLicitacoes':
        $clliclicita = new cl_liclicita();
        $rsLicitacaoAbertas = $clliclicita->sql_record($clliclicita->sql_query(null, 'distinct l20_codigo,l20_edital,l20_objeto', 'l20_codigo desc', "l20_licsituacao = 0 and liclicita.l20_leidalicitacao = 1 and l20_instit = " . db_getsession('DB_instit')));
        for ($iCont = 0; $iCont < pg_num_rows($rsLicitacaoAbertas); $iCont++) {

            $oLicitacaos = db_utils::fieldsMemory($rsLicitacaoAbertas, $iCont);
            $oLicitacao      = new stdClass();
            $oLicitacao->l20_codigo = $oLicitacaos->l20_codigo;
            $oLicitacao->l20_edital = $oLicitacaos->l20_edital;
            $oLicitacao->l20_objeto = urlencode($oLicitacaos->l20_objeto);

            $itens[] = $oLicitacao;
        }
        $oRetorno->licitacoes = $itens;
        break;

    case 'enviarAviso':

        $clLicitacao  = db_utils::getDao("liclicita");
        $cllicanexopncp = db_utils::getDao("licanexopncp");
        //todas as licitacoes marcadas
        foreach ($oParam->aLicitacoes as $aLicitacao) {
            //licitacao
            $rsDadosEnvio = $clLicitacao->sql_record($clLicitacao->sql_query_pncp($aLicitacao->codigo));
            //itens
            $rsDadosEnvioItens = $clLicitacao->sql_record($clLicitacao->sql_query_pncp_itens($aLicitacao->codigo));
            //Anexos da Licitacao
            $rsAnexos = $cllicanexopncp->sql_record($cllicanexopncp->sql_anexos_licitacao($aLicitacao->codigo));

            $aItensLicitacao = array();
            for ($lic = 0; $lic < pg_numrows($rsDadosEnvio); $lic++) {
                $oDadosLicitacao = db_utils::fieldsMemory($rsDadosEnvio, $lic);
                $tipoDocumento = $oDadosLicitacao->tipoinstrumentoconvocatorioid;
                $processo = $oDadosLicitacao->numerocompra;
                for ($item = 0; $item < pg_numrows($rsDadosEnvioItens); $item++) {
                    $oDadosLicitacaoItens = db_utils::fieldsMemory($rsDadosEnvioItens, $item);
                    /*
                    * Aqui eu fiz uma consulta para conseguir o valor estimado do item reservado
                    */
                    if ($oDadosLicitacaoItens->pc11_reservado == "t") {
                        $rsReservado = $clLicitacao->sql_record($clLicitacao->sql_query_valor_item_reservado($oDadosLicitacaoItens->pc11_numero, $oDadosLicitacaoItens->pc01_codmater));
                        db_fieldsmemory($rsReservado, 0);
                        $oDadosLicitacaoItens->valorunitarioestimado = $valorunitarioestimado;
                    }
                    $aItensLicitacao[] = $oDadosLicitacaoItens;
                }

                //vinculando os anexos
                for ($anex = 0; $anex < pg_numrows($rsAnexos); $anex++) {
                    $oAnexos = db_utils::fieldsMemory($rsAnexos, $anex);
                    $aAnexos[] = $oAnexos;
                }
                $oDadosLicitacao->itensCompra = $aItensLicitacao;
                $oDadosLicitacao->anexos = $aAnexos;
            }

            $clAvisoLicitacaoPNCP = new AvisoLicitacaoPNCP($oDadosLicitacao);
            //monta o json com os dados da licitacao
            $clAvisoLicitacaoPNCP->montarDados();
            //envia para pncp
            $clAvisoLicitacaoPNCP->enviarAviso($tipoDocumento, $processo);
        }

        break;
}
echo json_encode($oRetorno);
