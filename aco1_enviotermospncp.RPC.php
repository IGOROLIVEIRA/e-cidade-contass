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
require_once("classes/db_acocontroletermospncp_classe.php");
require_once("classes/db_liccontrolepncp_classe.php");
require_once("model/Acordo.model.php");
require_once("model/licitacao/PNCP/TermodeContratoPNCP.model.php");


db_app::import("configuracao.DBDepartamento");
$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

switch ($oParam->exec) {
    case 'getTermos':

        $oAcordo = new Acordo($oParam->iContrato);
        $aDadosTermos = $oAcordo->getPosicoesAditamentos();
        foreach ($aDadosTermos as $oTermo) {
            $oItemTermo = new stdClass();
            $oItemTermo->codigo = $oTermo->getCodigo();
            $oItemTermo->vigencia = urlencode($oTermo->getVigenciaInicial() . " até " . $oTermo->getVigenciaFinal());

            if($oTermo->getTipo() == '15' || $oTermo->getTipo() == '16' || $oTermo->getTipo() == '17'){
                $oItemTermo->numeroAditamento = $oTermo->getNumeroApostilamento();
            }else{
                $oItemTermo->numeroAditamento = $oTermo->getNumeroAditamento();
            }
            $oItemTermo->numtermopncp = $oAcordo->getNumeroTermoPNCP($oParam->iContrato,$oTermo->getCodigo());
            $oItemTermo->situacao = urlencode($oTermo->getDescricaoTipo());
            $oItemTermo->data = $oTermo->getData();
            $oItemTermo->Justificativa = urlencode($oTermo->getJusitificativa());
            $oRetorno->dados[] = $oItemTermo;
            $numeroAditamento = $oTermo->getNumeroAditamento();
        }

        if($oAcordo->getSituacao() == "2"){

            $aDadosTermosRescisao = new stdClass();
            $aDadosTermosRescisao->codigo = $oTermo->getCodigo();
            $aDadosTermosRescisao->vigencia = urlencode($oTermo->getVigenciaInicial() . " até " . $oTermo->getVigenciaFinal());
            $aDadosTermosRescisao->numeroAditamento = $numeroAditamento + 1;
            $aDadosTermosRescisao->numtermopncp = $oAcordo->getSeqTermoRecisaopncp($oAcordo->getCodigo(),$aDadosTermosRescisao->numeroAditamento);
            $aDadosTermosRescisao->situacao = urlencode($oAcordo->getRecisoes()[0]->ac09_descricao);
            $aDadosTermosRescisao->data = implode("/",array_reverse(explode("-",$oAcordo->getRecisoes()[0]->ac10_datamovimento)));
            $aDadosTermosRescisao->Justificativa = $oAcordo->getRecisoes()[0]->ac10_justificativa;
            $oRetorno->dados[] = $aDadosTermosRescisao;
        }

        break;
    case 'enviarTermo':

        $clacocontrolepncp = new cl_acocontratopncp;
        $oAcordo = new Acordo($oParam->iContrato);
        $cl_acocontroletermospncp = new cl_acocontroletermospncp();

        //Buscos Chave do Contrato do PNCP
        $rsAvisoPNCP = $clacocontrolepncp->sql_record($clacocontrolepncp->sql_query(null, "ac213_numerocontrolepncp,ac213_contrato,ac213_sequencialpncp,ac213_ano", null, "ac213_contrato = $oParam->iContrato limit 1"));
        $oDadosAvisoPNCP = db_utils::fieldsMemory($rsAvisoPNCP, 0);



        try {
            foreach ($oParam->aTermo as $termo) {

                //Verifica se ja existe lancamento de termo de recisao no PNCP
                $rsTermoPNCP = $cl_acocontroletermospncp->sql_record($cl_acocontroletermospncp->sql_query(null,"*",null,"l214_acordo = $oParam->iContrato and l214_tipotermocontratoid = 1"));

                if(pg_num_rows($rsTermoPNCP)){
                    throw new Exception(utf8_decode("Contrato já possui termo de rescisão publicado no pncp."));
                }

                $aDadosTermos = $oAcordo->getDadosTermosPncp($termo->codigo,$termo->numeroaditamento);

                //classe modelo
                $clTermodeContrato = new TermodeContrato($aDadosTermos);
                //monta o json com os dados da licitacao
                $oDadosTermo = $clTermodeContrato->montarDados();

                //envia para pncp
                $rsApiPNCP = $clTermodeContrato->enviarTermo($oDadosTermo, $oDadosAvisoPNCP->ac213_sequencialpncp, $oDadosAvisoPNCP->ac213_ano);

                if ($rsApiPNCP[1] == 201) {
                    $l214_numerotermo = explode('x-content-type-options', $rsApiPNCP[0]);
                    $l214_numerotermo = preg_replace('#\s+#', '', $l214_numerotermo);
                    $l214_numerotermo = explode('/', $l214_numerotermo[0]);

                    $cl_acocontroletermospncp = new cl_acocontroletermospncp();
                    $cl_acocontroletermospncp->l214_numerotermo = $l214_numerotermo[11];
                    $cl_acocontroletermospncp->l214_numcontratopncp = $oDadosAvisoPNCP->ac213_sequencialpncp;
                    $cl_acocontroletermospncp->l213_usuario = db_getsession('DB_id_usuario');
                    $cl_acocontroletermospncp->l213_dtlancamento = date('Y-m-d', db_getsession('DB_datausu'));
                    $cl_acocontroletermospncp->l214_anousu = $oDadosAvisoPNCP->ac213_ano;
                    $cl_acocontroletermospncp->l214_acordo = $oParam->iContrato;
                    $cl_acocontroletermospncp->l214_numeroaditamento = $termo->numeroaditamento;
                    $cl_acocontroletermospncp->l214_acordoposicao = $termo->codigo;
                    $cl_acocontroletermospncp->l214_instit = db_getsession('DB_instit');
                    $cl_acocontroletermospncp->l214_tipotermocontratoid = $aDadosTermos[0]->tipotermocontratoid;

                    $cl_acocontroletermospncp->incluir();

                    $oRetorno->status  = 1;
                    $oRetorno->message = "Enviado com Sucesso !";
                } else {
                    throw new Exception(utf8_decode($rsApiPNCP[0]).'. Termo número: '.$termo->numero);
                }
            }
        } catch (Exception $eErro) {
            $oRetorno->status  = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }
        break;

    case 'excluirTermo':
        $oAcordo = new Acordo($oParam->iContrato);

        try {
            foreach ($oParam->aTermo as $termo) {

                if($termo->codigotermo == 0){
                    throw new Exception(utf8_decode("Termo de número $termo->codigotermo não existe."));
                }

                //envia para pncp
                $clTermodeContrato = new TermodeContrato();
                $rsApiPNCP = $clTermodeContrato->excluirTermo($oAcordo->getAno(),$oAcordo->getCodigoContratoPNCP($oParam->iContrato),$termo->codigotermo);

                if ($rsApiPNCP == null) {
                    $cl_acocontroletermospncp = new cl_acocontroletermospncp();
                    $cl_acocontroletermospncp->excluir(null, "l214_acordo = $oParam->iContrato and l214_numerotermo = $termo->codigotermo");

                    $oRetorno->status  = 1;
                    $oRetorno->message = "Excluido com Sucesso !";
                } else {
                    throw new Exception(utf8_decode($rsApiPNCP->message));
                }
            }
        }catch (Exception $eErro) {
            $oRetorno->status  = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }
        break;
}
echo json_encode($oRetorno);
