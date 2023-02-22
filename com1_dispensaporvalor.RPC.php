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
require_once("model/licitacao/PNCP/AvisoLicitacaoPNCP.model.php");
require_once("model/licitacao/PNCP/AtaRegistroprecoPNCP.model.php");

db_app::import("configuracao.DBDepartamento");
$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

switch ($oParam->exec) {
    case 'getProcesso':

        $clpcproc = new cl_pcproc();
        $campos = "DISTINCT pc80_codproc,
                    pc80_numdispensa,
                    pc80_resumo,
                    '' as numerodecontrole";
        $rsProcessos = $clpcproc->sql_record($clpcproc->sql_query(null, $campos, '', "pc80_numdispensa IS NOT NULL"));

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
        $cllicanexopncp = db_utils::getDao("licanexopncp");

        //todas as licitacoes marcadas
        try {
            foreach ($oParam->aProcesso as $aProcesso) {
                //dados processo
                $rsDadosEnvio = $clProcesso->sql_record($clProcesso->sql_query_pncp($aProcesso->codigo));

                //itens
                $rsDadosEnvioItens = $clProcesso->sql_record($clProcesso->sql_query_pncp_itens($aProcesso->codigo));

                //Anexos da Licitacao
                //$rsAnexos = $cllicanexopncp->sql_record($cllicanexopncp->sql_anexos_licitacao($aProcesso->codigo));

                $aItensLicitacao = array();
                for ($lic = 0; $lic < pg_numrows($rsDadosEnvio); $lic++) {
                    $oDadosLicitacao = db_utils::fieldsMemory($rsDadosEnvio, $lic);

                    //validaçoes
                    if ($oDadosLicitacao->dataaberturaproposta == '') {
                        throw new Exception('Data da Abertura de Proposta não informado! Licitacao:' . $aProcesso->codigo);
                    }

                    //valida se existe anexos na licitacao
                    //if (pg_numrows($rsAnexos) == 0) {
                    // throw new Exception('Licitação sem Anexos vinculados! Licitação:' . $aProcesso->codigo);
                    // }

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
                    /*for ($anex = 0; $anex < pg_numrows($rsAnexos); $anex++) {
                        $oAnexos = db_utils::fieldsMemory($rsAnexos, $anex);
                        $aAnexos[] = $oAnexos;
                    }*/
                    $oDadosLicitacao->itensCompra = $aItensLicitacao;
                    //$oDadosLicitacao->anexos = $aAnexos;
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
                    //Neste if verifico o tipo de instrumento para salvar os campos licitacao ou processo de compras
                    var_dump($oDadosLicitacao->tipoinstrumentoconvocatorioid);
                    echo "<br>";
                    echo $l213_numerocontrolepncp;
                    exit;
                    if ($oDadosLicitacao->tipoinstrumentoconvocatorioid == 3) {
                        $clliccontrolepncp->l213_processodecompras = $aProcesso->codigo;
                    } else {
                        $clliccontrolepncp->l213_licitacao = $aProcesso->codigo;
                    }
                    $clliccontrolepncp->l213_processodecompras = $aProcesso->codigo;
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
    case 'getLicitacoesRP':
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
        LIMIT 1) AS l213_numerocontrolepncp,l03_descr,l20_numero,l215_ata";
        $rsLicitacaoAbertas = $clliclicita->sql_record($clliclicita->sql_query(null, $campos, 'l20_codigo desc', "l20_usaregistropreco ='t' and l03_pctipocompratribunal in (110,51,53,52,102,101,100,101) and l213_numerocontrolepncp is not null and liclicita.l20_leidalicitacao = 1 and l20_instit = " . db_getsession('DB_instit')));

        for ($iCont = 0; $iCont < pg_num_rows($rsLicitacaoAbertas); $iCont++) {

            $oLicitacaos = db_utils::fieldsMemory($rsLicitacaoAbertas, $iCont);
            $oLicitacao      = new stdClass();
            $oLicitacao->l20_codigo = $oLicitacaos->l20_codigo;
            $oLicitacao->l20_edital = $oLicitacaos->l20_edital;
            $oLicitacao->l20_objeto = urlencode($oLicitacaos->l20_objeto);
            $oLicitacao->l213_numerocontrolepncp = $oLicitacaos->l213_numerocontrolepncp;
            $oLicitacao->l03_descr = urlencode($oLicitacaos->l03_descr . ' - ' . $oLicitacaos->l20_numero);
            $oLicitacao->l215_ata = $oLicitacaos->l215_ata;


            $itens[] = $oLicitacao;
        }
        $oRetorno->licitacoes = $itens;
        break;
    case 'enviarAtaRP':
        $clLicitacao  = db_utils::getDao("liclicita");
        $cllicanexopncp = db_utils::getDao("licanexopncp");
        try {
            foreach ($oParam->aLicitacoes as $aLicitacao) {

                //licitacao
                $rsDadosEnvioAta = $clLicitacao->sql_record($clLicitacao->sql_query_ata_pncp($aLicitacao->codigo));

                for ($licAta = 0; $licAta < pg_numrows($rsDadosEnvioAta); $licAta++) {
                    $oDadosLicitacao = db_utils::fieldsMemory($rsDadosEnvioAta, $licAta);
                    $clAtaRegistroprecoPNCP = new AtaRegistroprecoPNCP($oDadosLicitacao);
                    //monta o json com os dados da licitacao
                    $odadosEnvioAta = $clAtaRegistroprecoPNCP->montarDados();

                    //envia para pncp
                    $rsApiPNCP = $clAtaRegistroprecoPNCP->enviarAta($odadosEnvioAta, substr($aLicitacao->numerocontrole, 17, -5), substr($aLicitacao->numerocontrole, 24));
                    $urlResutltado = explode('x-content-type-options', $rsApiPNCP[0]);

                    if ($rsApiPNCP[1] == '201') {
                        $clliccontroleatarppncp = new cl_licontroleatarppncp();
                        $l215_ata = substr($urlResutltado[0], 86);
                        $l215_numerocontrolepncp = '17316563000196-1-' . substr($aLicitacao->numerocontrole, 17, -5) . '/' . substr($aLicitacao->numerocontrole, 24) . '-' . str_pad($l215_ata, 6, '0', STR_PAD_LEFT);
                        $clliccontroleatarppncp->l215_licitacao = $aLicitacao->codigo;
                        $clliccontroleatarppncp->l215_usuario = db_getsession("DB_id_usuario");
                        $clliccontroleatarppncp->l215_dtlancamento = date("Y-m-d", db_getsession("DB_datausu"));
                        $clliccontroleatarppncp->l215_numerocontrolepncp = $l215_numerocontrolepncp;
                        $clliccontroleatarppncp->l215_situacao = 1;
                        $clliccontroleatarppncp->l215_ata = $l215_ata;
                        $clliccontroleatarppncp->l215_anousu = substr($aLicitacao->numerocontrole, 24);

                        $clliccontroleatarppncp->incluir();

                        $oRetorno->status  = 1;
                        $oRetorno->situacao = 1;
                        $oRetorno->message = "Enviado com Sucesso !";
                    } else {
                        throw new Exception(utf8_decode($rsApiPNCP[0]));
                    }
                }
            }
        } catch (Exception $eErro) {
            $oRetorno->status  = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }
        break;
    case 'retificarAtaRP':
        $clLicitacao  = db_utils::getDao("liclicita");
        $cllicanexopncp = db_utils::getDao("licanexopncp");
        try {
            foreach ($oParam->aLicitacoes as $aLicitacao) {

                //licitacao
                $rsDadosEnvioAta = $clLicitacao->sql_record($clLicitacao->sql_query_ata_pncp($aLicitacao->codigo));

                for ($licAta = 0; $licAta < pg_numrows($rsDadosEnvioAta); $licAta++) {
                    $oDadosLicitacao = db_utils::fieldsMemory($rsDadosEnvioAta, $licAta);
                    $clAtaRegistroprecoPNCP = new AtaRegistroprecoPNCP($oDadosLicitacao);
                    //monta o json com os dados da licitacao
                    $odadosEnvioAta = $clAtaRegistroprecoPNCP->montarDados();

                    //envia para pncp
                    $rsApiPNCP = $clAtaRegistroprecoPNCP->enviarRetificacaoAta($odadosEnvioAta, substr($aLicitacao->numerocontrole, 17, -5), substr($aLicitacao->numerocontrole, 24), $aLicitacao->numeroata);

                    if ($rsApiPNCP[0] == '201') {
                        $clliccontroleatarppncp = new cl_licontroleatarppncp();
                        $l215_ata = substr($urlResutltado[0], 86);
                        $l215_numerocontrolepncp = '17316563000196-1-' . substr($aLicitacao->numerocontrole, 17, -5) . '/' . substr($aLicitacao->numerocontrole, 24) . '-' . str_pad($aLicitacao->numeroata, 6, '0', STR_PAD_LEFT);

                        $clliccontroleatarppncp->l215_licitacao = $aLicitacao->codigo;
                        $clliccontroleatarppncp->l215_usuario = db_getsession("DB_id_usuario");
                        $clliccontroleatarppncp->l215_dtlancamento = date("Y-m-d", db_getsession("DB_datausu"));
                        $clliccontroleatarppncp->l215_numerocontrolepncp = $l215_numerocontrolepncp;
                        $clliccontroleatarppncp->l215_situacao = 2;
                        $clliccontroleatarppncp->l215_ata = $l215_ata;
                        $clliccontroleatarppncp->l215_anousu = substr($aLicitacao->numerocontrole, 24);

                        $clliccontroleatarppncp->incluir();

                        $oRetorno->status  = 1;
                        $oRetorno->situacao = 2;
                        $oRetorno->message = "Retificado com Sucesso !";
                    } else {
                        throw new Exception(utf8_decode($rsApiPNCP[0]));
                    }
                }
            }
        } catch (Exception $eErro) {
            $oRetorno->status  = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }
        break;

    case 'excluirAtaRP':
        $cllicontroleatarppncp = db_utils::getDao("licontroleatarppncp");
        try {
            foreach ($oParam->aLicitacoes as $aLicitacao) {
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
