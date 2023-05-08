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
require_once("classes/cl_licontroleatarppncp.php");
require_once("model/licitacao/PNCP/AvisoLicitacaoPNCP.model.php");
require_once("model/licitacao/PNCP/AtaRegistroprecoPNCP.model.php");
require_once("classes/db_licacontrolenexospncp_classe.php");
require_once("classes/db_liccontrolepncpitens_classe.php");

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
        $rsLicitacaoAbertas = $clliclicita->sql_record($clliclicita->sql_query(null, $campos, 'l20_codigo desc', "l03_pctipocompratribunal in (110,50,51,53,52,102,101,100,101) and liclicita.l20_leidalicitacao = 1 and l20_instit = " . db_getsession('DB_instit')));

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

        $clLicitacao  = new cl_liclicita();
        $cllicanexopncp = new cl_licanexopncp();

        //todas as licitacoes marcadas
        try {
            foreach ($oParam->aLicitacoes as $aLicitacao) {
                //licitacao
                $rsDadosEnvio = $clLicitacao->sql_record($clLicitacao->sql_query_pncp($aLicitacao->codigo));

                if (!pg_num_rows($rsDadosEnvio)) {
                    throw new Exception('Dados de envio do PNCP não Encontrato! Licitacao:' . $aLicitacao->codigo);
                }

                //itens
                $rsDadosEnvioItens = $clLicitacao->sql_record($clLicitacao->sql_query_pncp_itens($aLicitacao->codigo));

                if (!pg_num_rows($rsDadosEnvioItens)) {
                    throw new Exception('Dados dos Itens PNCP não Encontrato! Licitacao:' . $aLicitacao->codigo);
                }

                //Anexos da Licitacao
                $rsAnexos = $cllicanexopncp->sql_record($cllicanexopncp->sql_anexos_licitacao_aviso($aLicitacao->codigo));

                $aItensLicitacao = array();
                for ($lic = 0; $lic < pg_num_rows($rsDadosEnvio); $lic++) {
                    $oDadosLicitacao = db_utils::fieldsMemory($rsDadosEnvio, $lic);

                    //validaçoes
                    if ($oDadosLicitacao->dataaberturaproposta == '') {
                        throw new Exception('Data da Abertura de Proposta(l20_dataaberproposta) não informado! Licitacao:' . $aLicitacao->codigo);
                    }

                    //valida se existe anexos na licitacao
                    if (pg_num_rows($rsAnexos) == 0) {
                        throw new Exception('Licitação sem Anexos vinculados! Licitação:' . $aLicitacao->codigo);
                    }

                    for ($item = 0; $item < pg_num_rows($rsDadosEnvioItens); $item++) {
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
                    for ($anex = 0; $anex < pg_num_rows($rsAnexos); $anex++) {
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
                $rsApiPNCP = $clAvisoLicitacaoPNCP->enviarAviso($oDadosLicitacao->numerocompra, $aAnexos);

                //$rsApiPNCP = array(201, 'https://treina.pncp.gov.br/pncp-api/v1/orgaos/17316563000196/compras/2023/130');

                if ($rsApiPNCP[0] == 201) {
                    //monto o codigo da compra no pncp
                    $l213_numerocompra = substr($rsApiPNCP[1], 74);
                    $l213_numerocontrolepncp = db_utils::getCnpj() . '-1-' . str_pad($l213_numerocompra, 6, '0', STR_PAD_LEFT) . '/' . $oDadosLicitacao->anocompra;

                    $clliccontrolepncp = new cl_liccontrolepncp();
                    $clliccontrolepncp->l213_licitacao = $aLicitacao->codigo;
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
                    $clliccontroleanexopncp->l218_licitacao  = $aLicitacao->codigo;
                    $clliccontroleanexopncp->l218_usuario = db_getsession('DB_id_usuario');
                    $clliccontroleanexopncp->l218_dtlancamento = date('Y-m-d', db_getsession('DB_datausu'));
                    $clliccontroleanexopncp->l218_numerocontrolepncp = $l213_numerocontrolepncp;
                    $clliccontroleanexopncp->l218_tipoanexo = 2;
                    $clliccontroleanexopncp->l218_instit = db_getsession('DB_instit');
                    $clliccontroleanexopncp->l218_ano = $oDadosLicitacao->anocompra;
                    $clliccontroleanexopncp->l218_sequencialpncp = 1;
                    $clliccontroleanexopncp->l218_sequencialarquivo = $aAnexos[0]->l216_sequencial;
                    $clliccontroleanexopncp->l218_processodecompras = null;
                    $clliccontroleanexopncp->incluir();

                    if ($clliccontroleanexopncp->erro_status == 0) {
                        throw new Exception($clliccontroleanexopncp->erro_msg);
                    }

                    //Envio restante dos anexos
                    //Anexos da Licitacao
                    $rsAnexosRestentes = $cllicanexopncp->sql_record($cllicanexopncp->sql_anexos_licitacao_aviso_todos($aLicitacao->codigo));

                    //Enviando os anexos
                    for ($anexrest = 0; $anexrest < pg_num_rows($rsAnexosRestentes); $anexrest++) {
                        $oAnexosrest = db_utils::fieldsMemory($rsAnexosRestentes, $anexrest);

                        $rsApiAnexosPNCP = $clAvisoLicitacaoPNCP->enviarAnexos($oAnexosrest->l213_sequencial, utf8_decode($oAnexosrest->l213_descricao), $oAnexos->l216_nomedocumento, $oDadosLicitacao->anocompra, $l213_numerocompra);

                        if ($rsApiAnexosPNCP[0] == 201) {

                            $sAnexoPNCP = explode('x-content-type-options', $rsApiAnexosPNCP[1]);
                            $sAnexoPNCP = preg_replace('#\s+#', '', $sAnexoPNCP);
                            $sAnexoPNCP = explode('/', $sAnexoPNCP[0]);
                            //inserindo na tabela de controle
                            $clliccontroleanexopncp = new cl_liccontroleanexopncp();
                            $clliccontroleanexopncp->l218_licitacao  = $aLicitacao->codigo;
                            $clliccontroleanexopncp->l218_usuario = db_getsession('DB_id_usuario');
                            $clliccontroleanexopncp->l218_dtlancamento = date('Y-m-d', db_getsession('DB_datausu'));
                            $clliccontroleanexopncp->l218_numerocontrolepncp = $l213_numerocontrolepncp;
                            $clliccontroleanexopncp->l218_tipoanexo = $oAnexosrest->l213_sequencial;
                            $clliccontroleanexopncp->l218_instit = db_getsession('DB_instit');
                            $clliccontroleanexopncp->l218_ano = $oDadosLicitacao->anocompra;
                            $clliccontroleanexopncp->l218_sequencialpncp = $sAnexoPNCP[11];
                            $clliccontroleanexopncp->l218_sequencialarquivo = $oAnexosrest->l216_sequencial;
                            $clliccontroleanexopncp->l218_processodecompras = null;
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
        $clLicitacao  = db_utils::getDao("liclicita");
        $clliccontrolepncp = db_utils::getDao("liccontrolepncp");

        try {
            foreach ($oParam->aLicitacoes as $aLicitacao) {
                //somente licitacoes que ja foram enviadas para pncp
                $rsDadosEnvio = $clLicitacao->sql_record($clLicitacao->sql_query_pncp($aLicitacao->codigo));

                for ($lic = 0; $lic < pg_num_rows($rsDadosEnvio); $lic++) {
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
                $clliccontroleanexopncp = new cl_liccontroleanexopncp();
                $clliccontrolepncpitens = new cl_liccontrolepncpitens();

                //envia exclusao de aviso
                $rsApiPNCP = $clAvisoLicitacaoPNCP->excluirAviso(substr($aLicitacao->numerocontrole, 17, -5), substr($aLicitacao->numerocontrole, 24));

                if ($rsApiPNCP == null) {
                    $clliccontrolepncp->excluir(null, "l213_licitacao = $aLicitacao->codigo");
                    $clliccontroleanexopncp->excluir_licitacao($aLicitacao->codigo);
                    $clliccontrolepncpitens->excluir(null, "l214_licitacao = $aLicitacao->codigo");

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

                for ($licAta = 0; $licAta < pg_num_rows($rsDadosEnvioAta); $licAta++) {
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
                        $l215_numerocontrolepncp = db_utils::getCnpj() . '-1-' . substr($aLicitacao->numerocontrole, 17, -5) . '/' . substr($aLicitacao->numerocontrole, 24) . '-' . str_pad($l215_ata, 6, '0', STR_PAD_LEFT);
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

                for ($licAta = 0; $licAta < pg_num_rows($rsDadosEnvioAta); $licAta++) {
                    $oDadosLicitacao = db_utils::fieldsMemory($rsDadosEnvioAta, $licAta);
                    $clAtaRegistroprecoPNCP = new AtaRegistroprecoPNCP($oDadosLicitacao);
                    //monta o json com os dados da licitacao
                    $odadosEnvioAta = $clAtaRegistroprecoPNCP->montarDados();

                    //envia para pncp
                    $rsApiPNCP = $clAtaRegistroprecoPNCP->enviarRetificacaoAta($odadosEnvioAta, substr($aLicitacao->numerocontrole, 17, -5), substr($aLicitacao->numerocontrole, 24), $aLicitacao->numeroata);

                    if ($rsApiPNCP[0] == '201') {
                        $clliccontroleatarppncp = new cl_licontroleatarppncp();
                        $l215_ata = substr($urlResutltado[0], 86);
                        $l215_numerocontrolepncp = db_utils::getCnpj() . '-1-' . substr($aLicitacao->numerocontrole, 17, -5) . '/' . substr($aLicitacao->numerocontrole, 24) . '-' . str_pad($aLicitacao->numeroata, 6, '0', STR_PAD_LEFT);

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
