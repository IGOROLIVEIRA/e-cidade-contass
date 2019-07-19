<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_sessoes.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitasituacao_classe.php");
include("classes/db_credenciamento_classe.php");

$clcredenciamento       = new cl_credenciamento;
$oJson    = new services_json();
$oRetorno = new stdClass();
$oParam   = json_decode(str_replace('\\', '',$_POST["json"]));

$oRetorno->status   = 1;
$oRetorno->erro     = false;
$oRetorno->message  = '';

try{
    db_fim_transacao ();

    switch($oParam->exec) {

        case 'SalvarCred':

            foreach ($oParam->itens as $item){

                $clcredenciamento->l205_fornecedor = $item->l205_fornecedor;
                $clcredenciamento->l205_datacred = $item->l205_datacred;
                $clcredenciamento->l205_item = $item->l205_item;
                $clcredenciamento->l205_licitacao = $item->l205_licitacao;
                $clcredenciamento->l205_datacreditem = $item->l205_datacreditem;

                $resultitem = $clcredenciamento->sql_record($clcredenciamento->sql_query(null,"*",null,"l205_item = {$item->l205_item} and l205_fornecedor={$item->l205_fornecedor}"));

                db_fieldsmemory($resultitem,0)->l205_sequencial;

                if ($resultitem == 0) {
                    $clcredenciamento->incluir(null);
                } else {
                    $clcredenciamento->l205_sequencial = $l205_sequencial;
                    $clcredenciamento->alterar();
                }

                if ($clcredenciamento->erro_status == 0) {
                    $sqlerro = true;
                    $erro_msg = $clcredenciamento->erro_msg;
                    break;
                }
            }

            break;

        case 'getCredforne':
            $aItens = array();

            $resultcredforne = $clcredenciamento->sql_record($clcredenciamento->sql_query(null,"*",null,"l205_fornecedor = {$oParam->forne}"));
            if(pg_num_rows($resultcredforne) != 0){
                $oRetorno->result = $nenhumresultado;
                for ($iContItens = 0; $iContItens < pg_num_rows($resultcredforne); $iContItens++) {
                    $oItens = db_utils::fieldsMemory($resultcredforne, $iContItens);
                    $aItens[] = $oItens;
                }
                $oRetorno->itens = $aItens;
            }else{
                $oRetorno->itens = null;
            }

            break;

        case 'excluirCred':

            $clcredenciamento->excluir(null,$oParam->forne);

            if ($clcredenciamento->erro_status == 0) {
                $sqlerro = true;
                $erro_msg = $clcredenciamento->erro_msg;
                break;
            }
            break;

        case 'julgarLic':

            $clliclicita           = new cl_liclicita;
            $clliclicitasituacao   = new cl_liclicitasituacao;

            /*altero a situação da licitacao para julgada*/
            $clliclicita->alterarSituacaoCredenciamento($oParam->licitacao,1);

            /*salvo os dados da situação na tabela licsituacao*/
            $l11_sequencial                       = '';
            $clliclicitasituacao->l11_id_usuario  = DB_getSession("DB_id_usuario");
            $clliclicitasituacao->l11_licsituacao = 1;
            $clliclicitasituacao->l11_liclicita   = $oParam->licitacao;
            $clliclicitasituacao->l11_obs         = "Licitação Julgada";
            $clliclicitasituacao->l11_data        = date("Y-m-d",DB_getSession("DB_datausu"));
            $clliclicitasituacao->l11_hora        = DB_hora();
            $clliclicitasituacao->incluir($l11_sequencial);

            if ($clliclicitasituacao->erro_status == 0) {
                $sqlerro = true;
            }

            break;
    }

    db_fim_transacao (true);

} catch (Exception $eErro) {

    $oRetorno->erro  = true;
    $oRetorno->message = urlencode($eErro->getMessage());
}
echo $oJson->encode($oRetorno);