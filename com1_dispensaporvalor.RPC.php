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
require_once("classes/db_pcproc_classe.php");
require_once("classes/db_liccontrolepncp_classe.php");
require_once("classes/cl_licontroleatarppncp.php");
require_once("model/licitacao/PNCP/DispensaporValorPNCP.model.php");
require_once("model/licitacao/PNCP/ResultadoItensPNCP.model.php");

db_app::import("configuracao.DBDepartamento");
$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

switch ($oParam->exec) {
    case 'getProcesso':

        $clpcproc = new cl_pcproc();
        $rsProcessos = $clpcproc->sql_record($clpcproc->sql_get_dispensa_por_valor());

        for ($iCont = 0; $iCont < pg_num_rows($rsProcessos); $iCont++) {

            $oProcessos = db_utils::fieldsMemory($rsProcessos, $iCont);
            $oProcessp  = new stdClass();
            $oProcessp->pc80_codproc = $oProcessos->pc80_codproc;
            $oProcessp->pc80_numdispensa = $oProcessos->pc80_numdispensa;
            $oProcessp->pc80_resumo = urlencode($oProcessos->pc80_resumo);
            $oProcessp->numerodecontrole = $oProcessos->numerodecontrole;

            $itens[] = $oProcessp;
        }
        $oRetorno->processos = $itens;
        break;

    case 'enviarProcesso':

        $clProcesso   = db_utils::getDao("pcproc");
        $clanexocomprapncp = db_utils::getDao("anexocomprapncp");

        //todas as licitacoes marcadas
        try {
            foreach ($oParam->aProcesso as $aProcesso) {
                //dados processo
                $rsDadosEnvio = $clProcesso->sql_record($clProcesso->sql_query_pncp($aProcesso->codigo));

                //itens
                $rsDadosEnvioItens = $clProcesso->sql_record($clProcesso->sql_query_pncp_itens($aProcesso->codigo));

                //Anexos do Processo
                $rsAnexos = $clanexocomprapncp->sql_record($clanexocomprapncp->sql_anexos_licitacao($aProcesso->codigo));

                $aItensLicitacao = array();
                for ($lic = 0; $lic < pg_numrows($rsDadosEnvio); $lic++) {
                    $oDadosLicitacao = db_utils::fieldsMemory($rsDadosEnvio, $lic);

                    //validaçoes
                    if ($oDadosLicitacao->dataaberturaproposta == '') {
                        throw new Exception('Data da Abertura de Proposta não informado! Licitacao:' . $aProcesso->codigo);
                    }

                    //valida se existe anexos na licitacao
                    if (pg_numrows($rsAnexos) == 0) {
                        throw new Exception('Processo sem Anexos vinculados! Processo:' . $aProcesso->codigo);
                    }

                    //continua...

                    $tipoDocumento = $oDadosLicitacao->tipoinstrumentoconvocatorioid;
                    $processo = $oDadosLicitacao->numerocompra;

                    for ($item = 0; $item < pg_numrows($rsDadosEnvioItens); $item++) {
                        $oDadosLicitacaoItens = db_utils::fieldsMemory($rsDadosEnvioItens, $item);

                        //Aqui eu fiz uma consulta para conseguir o valor estimado do item reservado

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

                $clDispensaporvalor = new DispensaPorValorPNCP($oDadosLicitacao);
                //monta o json com os dados da licitacao
                $clDispensaporvalor->montarDados();
                //envia para pncp
                $rsApiPNCP = $clDispensaporvalor->enviarAviso($tipoDocumento, $processo);

                if ($rsApiPNCP->compraUri) {
                    //monto o codigo da compra no pncp
                    $clliccontrolepncp = new cl_liccontrolepncp();
                    $l213_numerocontrolepncp = '17316563000196-1-' . str_pad(substr($rsApiPNCP->compraUri, 74), 6, '0', STR_PAD_LEFT) . '/' . $oDadosLicitacao->anocompra;
                    //Neste if verifico o tipo de instrumento para salvar os campos licitacao ou processo de compras

                    if ($oDadosLicitacao->tipoinstrumentoconvocatorioid == "3") {
                        $clliccontrolepncp->l213_processodecompras = $aProcesso->codigo;
                    } else {
                        $clliccontrolepncp->l213_licitacao = $aProcesso->codigo;
                    }
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

        $clProcesso   = db_utils::getDao("pcproc");
        $clanexocomprapncp = db_utils::getDao("anexocomprapncp");

        try {
            foreach ($oParam->aProcesso as $aLicitacao) {
                //somente licitacoes que ja foram enviadas para pncp
                $rsDadosEnvio = $clProcesso->sql_record($clProcesso->sql_query_pncp($aLicitacao->codigo));

                for ($lic = 0; $lic < pg_numrows($rsDadosEnvio); $lic++) {
                    $oDadosLicitacao = db_utils::fieldsMemory($rsDadosEnvio, $lic);
                }
                $clDispensaporvalor = new DispensaPorValorPNCP($oDadosLicitacao);
                $oDadosRatificacao = $clDispensaporvalor->montarRetificacao();
                //envia Retificacao para pncp
                $rsApiPNCP = $clDispensaporvalor->enviarRetificacao($oDadosRatificacao, substr($aLicitacao->numerocontrole, 17, -5), substr($aLicitacao->numerocontrole, 24));

                if ($rsApiPNCP->compraUri == null) {
                    //monto o codigo da compra no pncp
                    $l213_numerocontrolepncp = $aLicitacao->numerocontrole;
                    if ($oDadosLicitacao->tipoinstrumentoconvocatorioid == "3") {
                        $clliccontrolepncp->l213_processodecompras = $aProcesso->codigo;
                    } else {
                        $clliccontrolepncp->l213_licitacao = $aProcesso->codigo;
                    }
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
            foreach ($oParam->aProcesso as $aLicitacao) {
                $clDispensaporvalor = new DispensaPorValorPNCP();
                //envia exclusao de aviso
                $rsApiPNCP = $clDispensaporvalor->excluirAviso(substr($aLicitacao->numerocontrole, 17, -5), substr($aLicitacao->numerocontrole, 24));

                if ($rsApiPNCP == null) {
                    $clliccontrolepncp->excluir(null, "l213_processodecompras = $aLicitacao->codigo");

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

        $cllicontroleatarppncp = db_utils::getDao("licontroleatarppncp");
        try {
            foreach ($oParam->aProcesso as $aLicitacao) {
                $clAtaRegistroprecoPNCP = new AtaRegistroprecoPNCP();
                //envia exclusao de Atas
                $rsApiPNCP = $clAtaRegistroprecoPNCP->excluirAta(substr($aLicitacao->numerocontrole, 17, -5), substr($aLicitacao->numerocontrole, 24), $aLicitacao->numeroata);

                if ($rsApiPNCP == null) {
                    $cllicontroleatarppncp->excluir(null, "l215_licitacao = $aLicitacao->codigo and l215_ata = $aLicitacao->numeroata");

                    $oRetorno->status  = 1;
                    $oRetorno->situacao = 3;
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
