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
require_once("classes/db_licacontrolenexospncp_classe.php");

db_app::import("configuracao.DBDepartamento");
$envs = parse_ini_file('legacy_config/PNCP/.env', true);
$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

switch ($oParam->exec) {
    case 'getProcesso':

        $where = "AND DATE_PART('YEAR',pc80_data) = $oParam->ano";

        if($oParam->tipo == "1"){
            $where .= "AND l213_numerocontrolepncp is null";
        }else{
            $where .= "AND l213_numerocontrolepncp != ''";
        }

        $clpcproc = new cl_pcproc();
        $rsProcessos = $clpcproc->sql_record($clpcproc->sql_get_dispensa_por_valor($where));

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

        $clProcesso   = new cl_pcproc;
        $clanexocomprapncp = new cl_anexocomprapncp;

        //todas as licitacoes marcadas
        try {
            foreach ($oParam->aProcesso as $aProcesso) {
                //dados processo
                $rsDadosEnvio = $clProcesso->sql_record($clProcesso->sql_query_pncp($aProcesso->codigo));

                //itens
                $rsDadosEnvioItens = $clProcesso->sql_record($clProcesso->sql_query_pncp_itens($aProcesso->codigo));

                //Anexos do Processo
                $rsAnexos = $clanexocomprapncp->sql_record($clanexocomprapncp->sql_anexos_licitacao_compra($aProcesso->codigo));

                //valida se existe anexos no processo de compras
                if (pg_num_rows($rsAnexos) == 0) {
                    throw new Exception('Processo sem Anexos vinculados! Codigo:' . $aProcesso->codigo);
                }

                $aItensLicitacao = array();
                for ($lic = 0; $lic < pg_numrows($rsDadosEnvio); $lic++) {
                    $oDadosLicitacao = db_utils::fieldsMemory($rsDadosEnvio, $lic);

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
                $rsApiPNCP = $clDispensaporvalor->enviarAviso($tipoDocumento, $processo, $aAnexos);

                if ($rsApiPNCP[0] == 201) {

                    //monto o codigo da compra no pncp
                    //Ambiente de testes
                    if($envs['APP_ENV'] === 'T'){
                        $l213_numerocompra = substr($rsApiPNCP[1], 74);
                    }else{
                    //Ambiente de Producao
                        $l213_numerocompra = substr($rsApiPNCP[1], 67);
                    }

                    $l213_numerocontrolepncp = db_utils::getCnpj() . '-1-' . str_pad($l213_numerocompra, 6, '0', STR_PAD_LEFT) . '/' . $oDadosLicitacao->anocompra;

                    //monto o codigo da compra no pncp
                    $clliccontrolepncp = new cl_liccontrolepncp();
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
                    $clliccontrolepncp->l213_numerocompra = $l213_numerocompra;
                    $clliccontrolepncp->l213_anousu = $oDadosLicitacao->anocompra;
                    $clliccontrolepncp->l213_instit = db_getsession('DB_instit');
                    $clliccontrolepncp->incluir();

                    if ($clliccontrolepncp->erro_status == 0) {
                        throw new Exception($clliccontrolepncp->erro_msg);
                    }

                    //somente primeiro anexo obrigatorio para publicar a compra
                    $clliccontroleanexopncp = new cl_liccontroleanexopncp();
                    $clliccontroleanexopncp->l218_licitacao  = null;
                    $clliccontroleanexopncp->l218_usuario = db_getsession('DB_id_usuario');
                    $clliccontroleanexopncp->l218_dtlancamento = date('Y-m-d', db_getsession('DB_datausu'));
                    $clliccontroleanexopncp->l218_numerocontrolepncp = $l213_numerocontrolepncp;
                    $clliccontroleanexopncp->l218_tipoanexo = 2;
                    $clliccontroleanexopncp->l218_instit = db_getsession('DB_instit');
                    $clliccontroleanexopncp->l218_ano = $oDadosLicitacao->anocompra;
                    $clliccontroleanexopncp->l218_sequencialpncp = 1;
                    $clliccontroleanexopncp->l218_sequencialarquivo = $aAnexos[0]->l217_sequencial;
                    $clliccontroleanexopncp->l218_processodecompras = $aProcesso->codigo;

                    $clliccontroleanexopncp->incluir();

                    if ($clliccontroleanexopncp->erro_status == 0) {
                        throw new Exception($clliccontroleanexopncp->erro_msg);
                    }

                    //Envio restante dos anexos
                    //Anexos da Licitacao
                    $rsAnexosRestentes = $clanexocomprapncp->sql_record($clanexocomprapncp->sql_anexos_licitacao_aviso_todos($aProcesso->codigo));

                    //Enviando os anexos
                    for ($anexrest = 0; $anexrest < pg_num_rows($rsAnexosRestentes); $anexrest++) {
                        $oAnexosrest = db_utils::fieldsMemory($rsAnexosRestentes, $anexrest);

                        $rsApiAnexosPNCP = $clDispensaporvalor->enviarAnexos($oAnexosrest->l213_sequencial, utf8_decode($oAnexosrest->l213_descricao), $oAnexos->l216_nomedocumento, $oDadosLicitacao->anocompra, $l213_numerocompra);

                        if ($rsApiAnexosPNCP[0] == 201) {

                            $sAnexoPNCP = explode('x-content-type-options', $rsApiAnexosPNCP[1]);
                            $sAnexoPNCP = preg_replace('#\s+#', '', $sAnexoPNCP);
                            $sAnexoPNCP = explode('/', $sAnexoPNCP[0]);

                            //inserindo na tabela de controle
                            $clliccontroleanexopncp = new cl_liccontroleanexopncp();
                            $clliccontroleanexopncp->l218_licitacao  = null;
                            $clliccontroleanexopncp->l218_usuario = db_getsession('DB_id_usuario');
                            $clliccontroleanexopncp->l218_dtlancamento = date('Y-m-d', db_getsession('DB_datausu'));
                            $clliccontroleanexopncp->l218_numerocontrolepncp = $l213_numerocontrolepncp;
                            $clliccontroleanexopncp->l218_tipoanexo = $oAnexosrest->l213_sequencial;
                            $clliccontroleanexopncp->l218_instit = db_getsession('DB_instit');
                            $clliccontroleanexopncp->l218_ano = $oDadosLicitacao->anocompra;
                            $clliccontroleanexopncp->l218_sequencialpncp = $sAnexoPNCP[11];
                            $clliccontroleanexopncp->l218_sequencialarquivo = $oAnexosrest->l217_sequencial;
                            $clliccontroleanexopncp->l218_processodecompras = $aProcesso->codigo;
                            $clliccontroleanexopncp->incluir();

                            if ($clliccontroleanexopncp->erro_status == 0) {
                                throw new Exception($clliccontroleanexopncp->erro_msg);
                            }
                        }
                    }
                } else {
                    throw new Exception(utf8_decode($rsApiPNCP[1]));
                }
                $oRetorno->status  = 1;
                $oRetorno->message = "Enviado com Sucesso !";
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
                    $clliccontrolepncp = new cl_liccontrolepncp();

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
                $clliccontroleanexopncp = new cl_liccontroleanexopncp();

                //envia exclusao de aviso
                $rsApiPNCP = $clDispensaporvalor->excluirAviso(substr($aLicitacao->numerocontrole, 17, -5), substr($aLicitacao->numerocontrole, 24));

                if ($rsApiPNCP == null) {
                    $clliccontrolepncp->excluir(null, "l213_processodecompras = $aLicitacao->codigo");
                    $clliccontroleanexopncp->excluir_processocompra($aLicitacao->codigo);

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
