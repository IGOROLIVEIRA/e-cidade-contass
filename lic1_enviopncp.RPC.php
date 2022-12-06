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
        $campos = "distinct l20_codigo,l20_edital,l20_objeto,(SELECT l213_numerocontrolepncp
        FROM liccontrolepncp
        WHERE l213_situacao = 1
            AND l213_licitacao=l20_codigo
            AND l213_licitacao NOT IN
                (SELECT l213_licitacao
                 FROM liccontrolepncp
                 WHERE l213_situacao = 3
                     AND l213_licitacao=l20_codigo)
        ORDER BY l213_sequencial DESC
        LIMIT 1) AS l213_numerocontrolepncp,l03_descr,l20_numero";
        $rsLicitacaoAbertas = $clliclicita->sql_record($clliclicita->sql_query(null, $campos, 'l20_codigo desc', "l20_licsituacao = 0 and l03_pctipocompratribunal in (110,51,53,52,102,101,100,101) and liclicita.l20_leidalicitacao = 1 and l20_instit = " . db_getsession('DB_instit')));

        for ($iCont = 0; $iCont < pg_num_rows($rsLicitacaoAbertas); $iCont++) {

            $oLicitacaos = db_utils::fieldsMemory($rsLicitacaoAbertas, $iCont);
            $oLicitacao      = new stdClass();
            $oLicitacao->l20_codigo = $oLicitacaos->l20_codigo;
            $oLicitacao->l20_edital = $oLicitacaos->l20_edital;
            $oLicitacao->l20_objeto = urlencode($oLicitacaos->l20_objeto);
            $oLicitacao->l213_numerocontrolepncp = $oLicitacaos->l213_numerocontrolepncp;
            $oLicitacao->l03_descr = urlencode($oLicitacaos->l03_descr . ' - ' . $oLicitacaos->l20_numero);

            $itens[] = $oLicitacao;
        }
        $oRetorno->licitacoes = $itens;
        break;

    case 'enviarAviso':

        $clLicitacao  = db_utils::getDao("liclicita");
        $cllicanexopncp = db_utils::getDao("licanexopncp");

        //todas as licitacoes marcadas
        try {
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

                    //validaçoes
                    if ($oDadosLicitacao->dataaberturaproposta == '') {
                        throw new Exception('Data da Abertura de Proposta não informado! Licitacao:' . $aLicitacao->codigo);
                    }

                    //valida se existe anexos na licitacao
                    if (pg_numrows($rsAnexos) == 0) {
                        throw new Exception('Licitação sem Anexos vinculados! Licitação:' . $aLicitacao->codigo);
                    }

                    //continua...

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
                $rsApiPNCP = $clAvisoLicitacaoPNCP->enviarAviso($tipoDocumento, $processo);

                if ($rsApiPNCP->compraUri) {
                    //monto o codigo da compra no pncp
                    $clliccontrolepncp = new cl_liccontrolepncp();
                    $l213_numerocontrolepncp = '17316563000196-1-' . str_pad(substr($rsApiPNCP->compraUri, 74), 6, '0', STR_PAD_LEFT) . '/' . $oDadosLicitacao->anocompra;
                    $clliccontrolepncp->l213_licitacao = $aLicitacao->codigo;
                    $clliccontrolepncp->l213_usuario = db_getsession('DB_id_usuario');
                    $clliccontrolepncp->l213_dtlancamento = date('Y-m-d', db_getsession('DB_datausu'));
                    $clliccontrolepncp->l213_numerocontrolepncp = $l213_numerocontrolepncp;
                    $clliccontrolepncp->l213_situacao = 1;
                    $clliccontrolepncp->l213_numerocompra = substr($rsApiPNCP->compraUri, 74);
                    $clliccontrolepncp->l213_anousu = $oDadosLicitacao->anocompra;
                    $clliccontrolepncp->l213_instit = db_getsession('DB_instit');
                    $clliccontrolepncp->incluir();

                    $oRetorno->status  = 1;
                    $oRetorno->message = "Enviado com Sucesso !";
                } else {
                    throw new Exception(utf8_decode($rsApiPNCP->message));
                }
            }
        } catch (Exception $eErro) {
            $oRetorno->status  = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }

        break;

    case 'RetificarAviso':
        $clLicitacao  = db_utils::getDao("liclicita");
        $clliccontrolepncp = db_utils::getDao("liccontrolepncp");

        try {
            foreach ($oParam->aLicitacoes as $aLicitacao) {
                //somente licitacoes que ja foram enviadas para pncp
                $rsDadosEnvio = $clLicitacao->sql_record($clLicitacao->sql_query_pncp($aLicitacao->codigo));

                for ($lic = 0; $lic < pg_numrows($rsDadosEnvio); $lic++) {
                    $oDadosLicitacao = db_utils::fieldsMemory($rsDadosEnvio, $lic);
                }
                $clAvisoLicitacaoPNCP = new AvisoLicitacaoPNCP($oDadosLicitacao);
                $oDadosRatificacao = $clAvisoLicitacaoPNCP->montarRetificacao();
                //envia Retificacao para pncp
                $rsApiPNCP = $clAvisoLicitacaoPNCP->enviarRetificacao($oDadosRatificacao, substr($aLicitacao->numerocontrole, 17, -5), substr($aLicitacao->numerocontrole, 24));

                if ($rsApiPNCP->compraUri == null) {
                    //monto o codigo da compra no pncp
                    $l213_numerocontrolepncp = $aLicitacao->numerocontrole;
                    $clliccontrolepncp->l213_licitacao = $aLicitacao->codigo;
                    $clliccontrolepncp->l213_usuario = db_getsession('DB_id_usuario');
                    $clliccontrolepncp->l213_dtlancamento = date('Y-m-d', db_getsession('DB_datausu'));
                    $clliccontrolepncp->l213_numerocontrolepncp = $l213_numerocontrolepncp;
                    $clliccontrolepncp->l213_situacao = 2;
                    $clliccontrolepncp->l213_numerocompra = substr($aLicitacao->numerocontrole, 17, -5);
                    $clliccontrolepncp->l213_anousu = $oDadosLicitacao->anocompra;
                    $clliccontrolepncp->l213_instit = db_getsession('DB_instit');
                    $clliccontrolepncp->incluir();

                    $oRetorno->status  = 1;
                    $oRetorno->message = "Retificada com Sucesso !";
                } else {
                    throw new Exception(utf8_decode($rsApiPNCP->message));
                }
            }
        } catch (Exception $eErro) {
            $oRetorno->status  = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }
        break;

    case 'excluiraviso':
        $clliccontrolepncp = db_utils::getDao("liccontrolepncp");
        try {
            foreach ($oParam->aLicitacoes as $aLicitacao) {
                $clAvisoLicitacaoPNCP = new AvisoLicitacaoPNCP();
                //envia exclusao de aviso
                $rsApiPNCP = $clAvisoLicitacaoPNCP->excluirAviso(substr($aLicitacao->numerocontrole, 17, -5), substr($aLicitacao->numerocontrole, 24));

                if ($rsApiPNCP == null) {
                    $clliccontrolepncp->excluir(null, "l213_licitacao = $aLicitacao->codigo");

                    $oRetorno->status  = 1;
                    $oRetorno->message = "Excluido com Sucesso !";
                } else {
                    throw new Exception(utf8_decode($rsApiPNCP->message));
                }
            }
        } catch (Exception $eErro) {
            $oRetorno->status  = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }
        break;
}
echo json_encode($oRetorno);
