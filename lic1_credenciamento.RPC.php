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
include("classes/db_homologacaoadjudica_classe.php");
include("classes/db_credenciamento_classe.php");

$clcredenciamento       = new cl_credenciamento;
$clitenshomologacao    = new cl_itenshomologacao;
$clhomologacaoadjudica = new cl_homologacaoadjudica;
$clliclicitasituacao   = new cl_liclicitasituacao;
$clliclicita           = new cl_liclicita;
$clliclicitasituacao   = new cl_liclicitasituacao;

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

        case 'SalvarHomologacao':

            /**
             * realiza as alterações na licitaçao
             */

            db_inicio_transacao();
            $result = $clliclicita->sql_record($clliclicita->sql_query_file(null,"l20_codtipocom",null,"l20_codigo = $oParam->licitacao"));

            $l20_codtipocom = pg_result($result,0,0);

            $clliclicita->alterarSituacaoCredenciamento($oParam->licitacao,10);

            $clliclicita->l20_codtipocom = $l20_codtipocom;
            $clliclicita-> l20_codigo = $oParam->licitacao;
            $clliclicita->l20_tipoprocesso = $oParam->l20_tipoprocesso;
            $clliclicita->l20_dtpubratificacao = $oParam->l20_dtpubratificacao;
            $clliclicita->l20_dtlimitecredenciamento = $oParam->l20_dtlimitecredenciamento;
            $clliclicita->l20_veicdivulgacao = $oParam->l20_veicdivulgacao;
            $clliclicita->l20_justificativa = $oParam->l20_justificativa;
            $clliclicita->l20_razao = $oParam->l20_razao;
            $clliclicita->alterar($oParam->licitacao,null,null);

            if ($clliclicita->erro_status == "0") {
                $erro_msg = $clliclicita->erro_msg;
                $sqlerro = true;
                $oRetorno = $erro_msg;
            }

            /**
             * incluir a situaçao homologada
             */

            $clliclicitasituacao->l11_data        = date("Y-m-d", db_getsession("DB_datausu"));
            $clliclicitasituacao->l11_hora        = db_hora();
            $clliclicitasituacao->l11_licsituacao = 10;
            $clliclicitasituacao->l11_id_usuario  = db_getsession("DB_id_usuario");
            $clliclicitasituacao->l11_liclicita   = $oParam->licitacao;
            $clliclicitasituacao->l11_obs         = "Homologação";
            $clliclicitasituacao->incluir(null);

            /**
             * incluir a homologação
             */
            $clhomologacaoadjudica->l202_licitacao = $oParam->licitacao;
            $clhomologacaoadjudica->l202_datahomologacao = $oParam->l20_dtpubratificacao;
            $clhomologacaoadjudica->l202_dataadjudicacao = $oParam->l20_dtpubratificacao;
            $clhomologacaoadjudica->incluir(null);

            /**
             * incluir itens na homologação
             */
            foreach ($oParam->itens as $iten) {
                $clitenshomologacao->l203_item = $iten->l205_item;
                $clitenshomologacao->l203_homologaadjudicacao = $clhomologacaoadjudica->l202_sequencial;
                $clitenshomologacao->incluir(null);
            }
            db_fim_transacao();
            break;

        case 'getItensHomo':
            $aItens = array();

            $sql = "SELECT l203_item,l202_datahomologacao
                            FROM itenshomologacao
                    INNER JOIN homologacaoadjudica ON l202_sequencial = l203_homologaadjudicacao
                    WHERE l202_licitacao = {$oParam->licitacao}";

            $result = db_query($sql);

            for ($iContItens = 0; $iContItens < pg_num_rows($result); $iContItens++) {
                $oItens = db_utils::fieldsMemory($result, $iContItens);
                $aItens[] = $oItens;
            }
//            echo "<pre>"; print_r($oItens);exit;
            $oRetorno->itens = $aItens;
            $oRetorno->dtpublicacao = $oItens->l202_datahomologacao;

            break;
    }

    db_fim_transacao (true);

} catch (Exception $eErro) {
    $oRetorno->erro  = true;
    $oRetorno->message = urlencode($eErro->getMessage());
}
echo $oJson->encode($oRetorno);