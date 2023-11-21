<?php
require_once('libs/db_stdlib.php');
require_once('libs/db_utils.php');
require_once('libs/db_app.utils.php');
require_once('libs/db_conecta.php');
require_once('libs/db_sessoes.php');
require_once('dbforms/db_funcoes.php');
require_once('libs/JSON.php');
require_once('classes/db_efdreinfr4099_classe.php'); 
require_once('classes/db_efdreinfr4020_classe.php'); 
require_once('classes/db_efdreinfr4010_classe.php'); 
require_once("model/efdreinf/EfdReinf.model.php");

$oJson = new services_json();
$oParam = JSON::create()->parse(str_replace('\\', "", $_POST["json"]));
$oRetorno = new stdClass();
$oRetorno->iStatus  = 1;
$oRetorno->sMessage = '';
$sInstituicao       = db_getsession('DB_instit');
try {
    switch ($oParam->exec) {
        case "transmitirreinf4099" :
            
            $oDaoCgm        = db_utils::getDao("cgm");
            $rsDadosCgm    = $oDaoCgm->sql_record($oDaoCgm->sql_query($oParam->sCgm));

            $cldb_config = new cl_db_config;

            if (pg_num_rows($rsDadosCgm) > 0){
                $oDadosCgm = db_utils::fieldsMemory($rsDadosCgm, 0);
               
                if ($oDadosCgm->z01_telef == null || $oDadosCgm->z01_telef == '' || strlen($oDadosCgm->z01_telef) < 10  ){
                    $oRetorno->sMessage = "Telefone do Responsável inválido! Informe o número do telefone com DDD.";
                    $oRetorno->erro = $oRetorno->iStatus == 2;
                    break;
                }
                
                if ($oDadosCgm->z01_email == null || $oDadosCgm->z01_email == ''  ){
                    $oRetorno->sMessage = "Email do Responsável inválido!.";
                    $oRetorno->erro = $oRetorno->iStatus == 2;
                    break;
                }
            }

            $resul = $cldb_config->sql_record($cldb_config->sql_query($sInstituicao, "cgc,z01_numcgm",""," codigo = {$sInstituicao} "));
	        db_fieldsmemory($resul, 0); 
            
            $clefdreinfR4099 = new cl_efdreinfr4099;
            $clefdreinfR4099->efd01_mescompetencia = $oParam->sMescompetencia;
            $clefdreinfR4099->efd01_anocompetencia = $oParam->sAnocompetencia;
            $clefdreinfR4099->efd01_tipo           = $oParam->sTipo;
            $clefdreinfR4099->efd01_ambiente       = $oParam->sAmbiente;
            $clefdreinfR4099->efd01_cgm            = $oParam->sCgm;
            $clefdreinfR4099->efd01_instit         = $sInstituicao;
         
            $oDadosCgm->z01_nome = removeAccents($oDadosCgm->z01_nome);
            $clEfdReinf = new EFDReinfR4000($clefdreinfR4099,$oDadosCgm,$cgc);
        
            $oDados = $clEfdReinf->montarDadosReinfR4099();

            $oCertificado = $clEfdReinf->buscarCertificado($z01_numcgm);

            // Envia o evento 4099
            $rsApiEnvio = $clEfdReinf->emitirReinfR4099($oDados,$oCertificado);
            $dhRecepcaoEnvio     = $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
            $protocoloEnvio = (string) $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->protocoloEnvio;

            // Consulta o evento 4099
            sleep(5);
            $clEfdReinf = new EFDReinfR4000($clefdreinfR4099,$oDadosCgm,$cgc);        
            $oDados = $clEfdReinf->montarDadosReinfR4099();
            $rsApiConsulta = $clEfdReinf->buscarReinfR4099($oDados,$oCertificado,$protocoloEnvio);
               
            $statusConsulta         = $rsApiConsulta->retornoLoteEventosAssincrono->status->cdResposta;
            $descRespostaConsulta   = (string) $rsApiConsulta->retornoLoteEventosAssincrono->status->descResposta;
            $dhRecepcaoConsulta     = $rsApiConsulta->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
            $dscRespConsulta        = (string) $rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtRetCons->ideRecRetorno->ideStatus->regOcorrs->dscResp;
            $codRespConsulta        = $rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtRetCons->ideRecRetorno->ideStatus->regOcorrs->codResp; 
                        
            
            $clefdreinfR4099->efd01_protocolo    = $protocoloEnvio;
            $clefdreinfR4099->efd01_status       = $statusConsulta;
            $clefdreinfR4099->efd01_descResposta = utf8_decode($descRespostaConsulta);
            $clefdreinfR4099->efd01_dscResp      = utf8_decode($dscRespConsulta);
            $clefdreinfR4099->efd01_dataenvio    = $dhRecepcaoEnvio;

            if( $protocoloEnvio) {
                $clefdreinfR4099->incluir();

                if ($clefdreinfR4099->erro_status == 0) {
                    throw new Exception($clefdreinfR4099->erro_msg);
                }
                
            }

            if($descRespostaConsulta){
                $oRetorno->sMessage = "O lote foi processado. Acesse o menu de consultas para verificar o status do evento.";
            }else{ 
                $oRetorno->sMessage = $rsApiEnvio;
            }    
        break;
        case "getEventos4099":
             
            if($oParam->status)
                $status = " and efd01_status = $oParam->status ";
            $cl_efdreinfr4099 = new cl_efdreinfr4099;
            $where = " efd01_mescompetencia = '{$oParam->mes}' and  efd01_anocompetencia = '{$oParam->ano}' and efd01_ambiente = {$oParam->ambiente} and efd01_instit = {$sInstituicao} $status ";
            $rsefdreinfr4099 = $cl_efdreinfr4099->sql_record($cl_efdreinfr4099->sql_query_file(null,"*","efd01_sequencial desc", $where));

            for ($iCont = 0; $iCont < pg_num_rows($rsefdreinfr4099); $iCont++) {

                $oEfdreinfr4099 = db_utils::fieldsMemory($rsefdreinfr4099, $iCont);

                $clcgm = new cl_cgm;
                $rscgm = $clcgm->sql_record($clcgm->sql_query_file($oEfdreinfr4099->efd01_cgm,"z01_nome "));
                $oCgm = db_utils::fieldsMemory($rscgm, 0);

                $cl_db_config		    = new cl_db_config();
                $rsdb_config            = $cl_db_config->sql_record($cl_db_config->sql_query_file($sInstituicao,'nomeinst'));
                $oInstituicao           = db_utils::fieldsmemory($rsdb_config,0);
    
                $oefdreinfr4099      = new stdClass();
                $oefdreinfr4099->sequencial      = $oEfdreinfr4099->efd01_sequencial;
                $oefdreinfr4099->numcgm          = $oEfdreinfr4099->efd01_cgm." - ".strtoupper($oCgm->z01_nome);
                $oefdreinfr4099->mescompetencia  = $oEfdreinfr4099->efd01_mescompetencia;
                $oefdreinfr4099->anocompetencia  = $oEfdreinfr4099->efd01_anocompetencia;
                $oefdreinfr4099->tipo            = $oEfdreinfr4099->efd01_tipo == 0 ? "Fechamento" : "Abertura";
                // $oefdreinfr4099->ambiente        = $oEfdreinfr4099->efd01_ambiente == 1 ? "Produção" : "Produção Restrita";
                $oefdreinfr4099->status          = messageStatus($oEfdreinfr4099->efd01_status);
                $oefdreinfr4099->protocolo       = $oEfdreinfr4099->efd01_protocolo;
                $oefdreinfr4099->dscResp         = $oEfdreinfr4099->efd01_dscresp;
                $oefdreinfr4099->dataenvio       = formateDate(substr($oEfdreinfr4099->efd01_dataenvio,0,10))." - ".substr($oEfdreinfr4099->efd01_dataenvio,11,8);;
                
                $itens[] = $oefdreinfr4099;
            }
            $oRetorno->efdreinfr4099 = $itens;

        break;
        case "transmitirreinfR4020" :

            $iUltimoDiaMes = date("d", mktime(0, 0, 0, $oParam->sMescompetencia + 1, 0, $oParam->sAnocompetencia));
            $sDataInicial = db_getsession("DB_anousu") . "-{$oParam->sMescompetencia}-01";
            $sDataFinal   = db_getsession("DB_anousu") . "-{$oParam->sMescompetencia}-{$iUltimoDiaMes}";

            $clefdreinfR4020 = new cl_efdreinfr4020;
            $rsEfdreinfR4020 = $clefdreinfR4020->sql_record($clefdreinfR4020->sql_DadosEFDReinf(14,$sDataInicial,$sDataFinal,$sInstituicao));

            $cldb_config = new cl_db_config;
            $resul = $cldb_config->sql_record($cldb_config->sql_query($sInstituicao, "cgc,z01_numcgm",""," codigo = {$sInstituicao} "));
	        db_fieldsmemory($resul, 0); 

            if (pg_num_rows($rsEfdreinfR4020) > 0){
                $oDadosReinfR4020 = db_utils::fieldsMemory($rsEfdreinfR4020, 0);
            }else{
                    throw new Exception("Dados não encontrado na base.");
            }
        
            foreach ($oParam->aEventos as $oEventos) {

                if ($oEventos->NatRendimento > 0) {
                  
                    $oEventos->CNPJBeneficiario = substr(clean_cpf_cnpj($oEventos->CNPJBeneficiario),0,14);
                    $oEventos->DataFG = formateDateReverse($oEventos->DataFG);
                    $clEfdReinf = new EFDReinfR4000($oEventos,$oParam,$cgc);
        
                    $oDados = $clEfdReinf->montarDadosReinfR4020();
                   
                    $oCertificado = $clEfdReinf->buscarCertificado($z01_numcgm);

                    $rsApiEnvio = $clEfdReinf->emitirReinfR4020($oDados,$oCertificado);

                    $dhRecepcaoEnvio     = $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
                    $protocoloEnvio = (string) $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->protocoloEnvio;
                    
                    sleep(5);
                    $oDados = $clEfdReinf->montarDadosReinfR4020();
                    $clEfdReinf = new EFDReinfR4000($oEventos,$oParam,$cgc);
                    $rsApiConsulta = $clEfdReinf->buscarReinfR4020($oDados,$oCertificado,$protocoloEnvio);
                       
                    $statusConsulta         = $rsApiConsulta->retornoLoteEventosAssincrono->status->cdResposta;
                    $descRespostaConsulta   = (string) $rsApiConsulta->retornoLoteEventosAssincrono->status->descResposta;
                    $dhRecepcaoConsulta     = $rsApiConsulta->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
                    $dscRespConsulta        = (string) $rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtRet->ideRecRetorno->ideStatus->regOcorrs->dscResp;
                    $codRespConsulta        = $rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtRet->ideRecRetorno->ideStatus->regOcorrs->codResp; 
                    
                    $clefdreinfR4020 = new cl_efdreinfr4020;
                    $clefdreinfR4020->efd02_cnpjbeneficiario   = substr(clean_cpf_cnpj($oEventos->CNPJBeneficiario),0,14);
                    $clefdreinfR4020->efd02_identificadorop    = $oEventos->Identificador;
                    $clefdreinfR4020->efd02_naturezarendimento = $oEventos->NatRendimento;
                    $clefdreinfR4020->efd02_datafg             = $oEventos->DataFG;
                    $clefdreinfR4020->efd02_valorbruto         = tranformarFloat(ltrim($oEventos->ValorBruto));
                    $clefdreinfR4020->efd02_valorbase          = tranformarFloat(ltrim($oEventos->ValorBase));
                    $clefdreinfR4020->efd02_valorirrf          = tranformarFloat(ltrim($oEventos->ValorIRRF));
                    $clefdreinfR4020->efd02_mescompetencia     = $oParam->sMescompetencia;
                    $clefdreinfR4020->efd02_anocompetencia     = $oParam->sAnocompetencia;
                    $clefdreinfR4020->efd02_ambiente           = $oParam->sAmbiente;
                    $clefdreinfR4020->efd02_instit             = $sInstituicao;
                    $clefdreinfR4020->efd02_protocolo          = $protocoloEnvio;
                    $clefdreinfR4020->efd02_dataenvio          = $dhRecepcaoEnvio;
                    $clefdreinfR4020->efd02_numcgm             = searchCgm($oEventos->Numcgm);
                    $clefdreinfR4020->efd02_status             = $statusConsulta;
                    $clefdreinfR4020->efd02_descResposta       = utf8_decode($descRespostaConsulta);
                    $clefdreinfR4020->efd02_dscResp            = utf8_decode($dscRespConsulta);
                    $clefdreinfR4020->incluir();

                    if ($clefdreinfR4020->erro_status == 0) {
                        throw new Exception($clefdreinfR4020->erro_msg);
                    }

                }
            } 
            
            $opsErros = "";
            foreach ($oParam->aOpsErros as $oOpsErros) {
                $opsErros .= "<b>".$oOpsErros->op .", </b>";
            } 
            if ($opsErros)
                $oRetorno->sMessageOp = "As OPs $opsErros não foram enviadas. Informe a natureza do rendimento e tente novamente.";
            
            if($descRespostaConsulta){
                $oRetorno->sMessage = "O lote foi processado. Acesse o menu de consultas para verificar o status do evento.";
            }
        break;
        case "getEventos4020":
            
            $sDataInicial = db_getsession("DB_anousu") . "-01-01";
            $sDataFinal   = db_getsession("DB_anousu") . "-12-31";

            $iUltimoDiaMes = date("d", mktime(0, 0, 0, $oParam->sMescompetencia + 1, 0, $oParam->sAnocompetencia));
            $sDataInicialFiltros = db_getsession("DB_anousu") . "-{$oParam->sMescompetencia}-01";
            $sDataFinalFiltros   = db_getsession("DB_anousu") . "-{$oParam->sMescompetencia}-{$iUltimoDiaMes}";

            $clefdreinfR4020 = new cl_efdreinfr4020;
            $rsEfdreinfR4020 = $clefdreinfR4020->sql_record($clefdreinfR4020->sql_DadosEFDReinf(14,$sDataInicial,$sDataFinal,$sInstituicao));

            for ($iCont = 0; $iCont < pg_num_rows($rsEfdreinfR4020); $iCont++) { 
          
                $oEfdreinfr4020 = db_utils::fieldsMemory($rsEfdreinfR4020, $iCont);
                $oEfdreinfr4020Proximo = db_utils::fieldsMemory($rsEfdreinfR4020, $iCont + 1);
 
                if (!(($oEfdreinfr4020->cnpj == $oEfdreinfr4020Proximo->cnpj) && ($oEfdreinfr4020->op == $oEfdreinfr4020Proximo->op) )) {  
                   if ($oEfdreinfr4020->data_pgto >= $sDataInicialFiltros   && $oEfdreinfr4020->data_pgto <= $sDataFinalFiltros) {
                        $oefdreinfr4020 = new stdClass();
                        $oefdreinfr4020->CNPJBeneficiario = db_formatar($oEfdreinfr4020->cnpj,'cnpj')." - ". removeAccents($oEfdreinfr4020->beneficiario);
                        $oefdreinfr4020->Identificador = $oEfdreinfr4020->op;
                        $oefdreinfr4020->NaturezaRendimento = $oEfdreinfr4020->natureza_rendimento ? $oEfdreinfr4020->natureza_rendimento : '' ;
                        $oefdreinfr4020->DataFG = formateDate($oEfdreinfr4020->data_pgto);
                        $oefdreinfr4020->ValorBruto = "R$".db_formatar($oEfdreinfr4020->valor_bruto,'f');
                        $oefdreinfr4020->ValorBase = "R$".db_formatar($oEfdreinfr4020->valor_base,'f');
                        $oefdreinfr4020->ValorIRRF = "R$".db_formatar($oEfdreinfr4020->valor_irrf,'f');
        
                        $itens[] = $oefdreinfr4020;  
                   }    
                }
            }
            
            $oRetorno->efdreinfr4020 = $itens;

        break;
        case "getConsultarEvento4020":
            
            if($oParam->sStatus)
                $status = " and efd02_status = $oParam->sStatus ";
            $instituicao = db_getsession("DB_instit");
            $sWhere = " efd02_mescompetencia = '{$oParam->sMescompetencia}' and efd02_anocompetencia = '$oParam->sAnocompetencia' and efd02_ambiente = '$oParam->sAmbiente' and efd02_instit = {$instituicao} $status  ";
            $clefdreinfR4020 = new cl_efdreinfr4020;
            $rsEfdreinfR4020 = $clefdreinfR4020->sql_record($clefdreinfR4020->sql_query_file(null,"*",null,$sWhere));

            for ($iCont = 0; $iCont < pg_num_rows($rsEfdreinfR4020); $iCont++) { 
          
                    $oEfdreinfr4020 = db_utils::fieldsMemory($rsEfdreinfR4020, $iCont);
                    $oefdreinfr4020 = new stdClass();
                    $oefdreinfr4020->CNPJBeneficiario = db_formatar($oEfdreinfr4020->efd02_cnpjbeneficiario,'cnpj')." - ".$oEfdreinfr4020->z01_nome;
                    $oefdreinfr4020->Identificador = $oEfdreinfr4020->efd02_identificadorop;
                    $oefdreinfr4020->NaturezaRendimento = $oEfdreinfr4020->efd02_naturezarendimento ;
                    $oefdreinfr4020->DataFG = formateDate($oEfdreinfr4020->efd02_datafg);
                    $oefdreinfr4020->ValorBruto = "R$".db_formatar($oEfdreinfr4020->efd02_valorbruto,'f');
                    $oefdreinfr4020->ValorBase = "R$".db_formatar($oEfdreinfr4020->efd02_valorbase,'f');
                    $oefdreinfr4020->ValorIRRF = "R$".db_formatar($oEfdreinfr4020->efd02_valorirrf,'f');
                    $oefdreinfr4020->Protocolo =  $oEfdreinfr4020->efd02_protocolo;
                    $oefdreinfr4020->Status =  messageStatus($oEfdreinfr4020->efd02_status);
                    $oefdreinfr4020->Dataenvio =  formateDate(substr($oEfdreinfr4020->efd02_dataenvio,0,10))." - ".substr($oEfdreinfr4020->efd02_dataenvio,11,8);
                    $oefdreinfr4020->MsgRetornoErro =  $oEfdreinfr4020->efd02_dscresp;
                    $itens[] = $oefdreinfr4020;                
            }
            
            $oRetorno->efdreinfr4020 = $itens;

        break;
        case "transmitirreinfR4010":

            $iUltimoDiaMes = date("d", mktime(0, 0, 0, $oParam->sMescompetencia + 1, 0, $oParam->sAnocompetencia));
            $sDataInicial = db_getsession("DB_anousu") . "-{$oParam->sMescompetencia}-01";
            $sDataFinal   = db_getsession("DB_anousu") . "-{$oParam->sMescompetencia}-{$iUltimoDiaMes}";

            $clefdreinfR4010 = new cl_efdreinfr4010;
            $rsEfdreinfR4010 = $clefdreinfR4010->sql_record($clefdreinfR4010->sql_DadosEFDReinf(11,$sDataInicial,$sDataFinal,$sInstituicao));

            $cldb_config = new cl_db_config;
            $resul = $cldb_config->sql_record($cldb_config->sql_query($sInstituicao, "cgc,z01_numcgm",""," codigo = {$sInstituicao} "));
	        db_fieldsmemory($resul, 0); 

            if (pg_num_rows($rsEfdreinfR4010) > 0){
                $oDadosReinfR4010 = db_utils::fieldsMemory($rsEfdreinfR4010, 0);
            }else{
                    throw new Exception("Dados não encontrado na base.");
            }
        
            foreach ($oParam->aEventos as $oEventos) {

                if ($oEventos->NatRendimento > 0) {
                   
                    $oEventos->CPFBeneficiario = substr(clean_cpf_cnpj($oEventos->CPFBeneficiario),0,11);
                    $oEventos->DataFG = formateDateReverse($oEventos->DataFG);
                    $clEfdReinf = new EFDReinfR4000($oEventos,$oParam,$cgc);
        
                    $oDados = $clEfdReinf->montarDadosReinfR4010();
                   
                    $oCertificado = $clEfdReinf->buscarCertificado($z01_numcgm);

                    $rsApiEnvio = $clEfdReinf->emitirReinfR4010($oDados,$oCertificado);

                    $dhRecepcaoEnvio     = $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
                    $protocoloEnvio = (string) $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->protocoloEnvio;
                    
                    sleep(5);
                    $oDados = $clEfdReinf->montarDadosReinfR4010();
                    $clEfdReinf = new EFDReinfR4000($oEventos,$oParam,$cgc);
                    $rsApiConsulta = $clEfdReinf->buscarReinfR4010($oDados,$oCertificado,$protocoloEnvio);
                       
                    $statusConsulta         = $rsApiConsulta->retornoLoteEventosAssincrono->status->cdResposta;
                    $descRespostaConsulta   = (string) $rsApiConsulta->retornoLoteEventosAssincrono->status->descResposta;
                    $dhRecepcaoConsulta     = $rsApiConsulta->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
                    $dscRespConsulta        = (string) $rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtRet->ideRecRetorno->ideStatus->regOcorrs->dscResp;
                    $codRespConsulta        = $rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtRet->ideRecRetorno->ideStatus->regOcorrs->codResp; 
                    
                    $clefdreinfR4010 = new cl_efdreinfr4010;
                    $clefdreinfR4010->efd03_cpfbeneficiario   = substr(clean_cpf_cnpj($oEventos->CPFBeneficiario),0,11);
                    $clefdreinfR4010->efd03_identificadorop    = $oEventos->Identificador;
                    $clefdreinfR4010->efd03_naturezarendimento = $oEventos->NatRendimento;
                    $clefdreinfR4010->efd03_datafg             = $oEventos->DataFG;
                    $clefdreinfR4010->efd03_valorbruto         = tranformarFloat(ltrim($oEventos->ValorBruto));
                    $clefdreinfR4010->efd03_valorbase          = tranformarFloat(ltrim($oEventos->ValorBase));
                    $clefdreinfR4010->efd03_valorirrf          = tranformarFloat(ltrim($oEventos->ValorIRRF));
                    $clefdreinfR4010->efd03_mescompetencia     = $oParam->sMescompetencia;
                    $clefdreinfR4010->efd03_anocompetencia     = $oParam->sAnocompetencia;
                    $clefdreinfR4010->efd03_ambiente           = $oParam->sAmbiente;
                    $clefdreinfR4010->efd03_instit             = $sInstituicao;
                    $clefdreinfR4010->efd03_protocolo          = $protocoloEnvio;
                    $clefdreinfR4010->efd03_dataenvio          = $dhRecepcaoEnvio;
                    $clefdreinfR4010->efd03_numcgm             = searchCgm($oEventos->Numcgm);
                    $clefdreinfR4010->efd03_status             = $statusConsulta;
                    $clefdreinfR4010->efd03_descResposta       = utf8_decode($descRespostaConsulta);
                    $clefdreinfR4010->efd03_dscResp            = utf8_decode($dscRespConsulta);
                    $clefdreinfR4010->incluir();

                    if ($clefdreinfR4010->erro_status == 0) {
                        throw new Exception($clefdreinfR4010->erro_msg);
                    }

                }
            } 
            
            $opsErros = "";
            foreach ($oParam->aOpsErros as $oOpsErros) {
                $opsErros .= "<b>".$oOpsErros->op .", </b>";
            } 
            if ($opsErros)
                $oRetorno->sMessageOp = "As OPs $opsErros não foram enviadas. Informe a natureza do rendimento e tente novamente.";
            
            if($descRespostaConsulta){
                $oRetorno->sMessage = "O lote foi processado. Acesse o menu de consultas para verificar o status do evento.";
            }
          
        break;
        case "getEventos4010":
            
            $sDataInicial = db_getsession("DB_anousu") . "-01-01";
            $sDataFinal   = db_getsession("DB_anousu") . "-12-31";

            $iUltimoDiaMes = date("d", mktime(0, 0, 0, $oParam->sMescompetencia + 1, 0, $oParam->sAnocompetencia));
            $sDataInicialFiltros = db_getsession("DB_anousu") . "-{$oParam->sMescompetencia}-01";
            $sDataFinalFiltros   = db_getsession("DB_anousu") . "-{$oParam->sMescompetencia}-{$iUltimoDiaMes}";

            $clefdreinfR4010 = new cl_efdreinfr4010;
            $rsEfdreinfR4010 = $clefdreinfR4010->sql_record($clefdreinfR4010->sql_DadosEFDReinf(11,$sDataInicial,$sDataFinal,$sInstituicao));

            for ($iCont = 0; $iCont < pg_num_rows($rsEfdreinfR4010); $iCont++) { 
          
                $oEfdreinfr4010 = db_utils::fieldsMemory($rsEfdreinfR4010, $iCont);
                $oEfdreinfr4010Proximo = db_utils::fieldsMemory($rsEfdreinfR4010, $iCont + 1);
 
                if (!(($oEfdreinfr4010->cnpj == $oEfdreinfr4010Proximo->cnpj) && ($oEfdreinfr4010->op == $oEfdreinfr4010Proximo->op))) {  
                    if ($oEfdreinfr4010->data_pgto >= $sDataInicialFiltros   && $oEfdreinfr4010->data_pgto <= $sDataFinalFiltros) {
                        $oefdreinfr4010 = new stdClass();
                        $oefdreinfr4010->CPFBeneficiario = db_formatar($oEfdreinfr4010->cpf,'cpf')." - ".removeAccents($oEfdreinfr4010->beneficiario);
                        $oefdreinfr4010->Identificador = $oEfdreinfr4010->op;
                        $oefdreinfr4010->NaturezaRendimento = $oEfdreinfr4010->natureza_rendimento ? $oEfdreinfr4010->natureza_rendimento : '' ;
                        $oefdreinfr4010->DataFG = formateDate($oEfdreinfr4010->data_pgto);
                        $oefdreinfr4010->ValorBruto = "R$".db_formatar($oEfdreinfr4010->valor_bruto,'f');
                        $oefdreinfr4010->ValorBase = "R$".db_formatar($oEfdreinfr4010->valor_base,'f');
                        $oefdreinfr4010->ValorIRRF = "R$".db_formatar($oEfdreinfr4010->valor_irrf,'f');

                        $itens[] = $oefdreinfr4010;  
                    }                  
                } 
            }
            
            $oRetorno->efdreinfr4010 = $itens;

        break;
        case "getConsultarEvento4010":
            
            if($oParam->sStatus) {
                $status = " and efd03_status = $oParam->sStatus ";
            }
            $instituicao = db_getsession("DB_instit");
            $sWhere = " efd03_mescompetencia = '{$oParam->sMescompetencia}' and efd03_anocompetencia = '$oParam->sAnocompetencia' and efd03_ambiente = '$oParam->sAmbiente' and efd03_instit = {$instituicao} $status  ";
            $clefdreinfR4010 = new cl_efdreinfr4010;
            $rsEfdreinfR4010 = $clefdreinfR4010->sql_record($clefdreinfR4010->sql_query_file(null,"*",null,$sWhere));

            for ($iCont = 0; $iCont < pg_num_rows($rsEfdreinfR4010); $iCont++) { 
          
                $oEfdreinfr4010 = db_utils::fieldsMemory($rsEfdreinfR4010, $iCont);

                    $oefdreinfr4010 = new stdClass();
                    $oefdreinfr4010->CPFBeneficiario = db_formatar($oEfdreinfr4010->efd03_cpfbeneficiario,'cpf')." - ".$oEfdreinfr4010->z01_nome;
                    $oefdreinfr4010->Identificador = $oEfdreinfr4010->efd03_identificadorop;
                    $oefdreinfr4010->NaturezaRendimento = $oEfdreinfr4010->efd03_naturezarendimento ;
                    $oefdreinfr4010->DataFG = formateDate($oEfdreinfr4010->efd03_datafg);
                    $oefdreinfr4010->ValorBruto = "R$".db_formatar($oEfdreinfr4010->efd03_valorbruto,'f');
                    $oefdreinfr4010->ValorBase = "R$".db_formatar($oEfdreinfr4010->efd03_valorbase,'f');
                    $oefdreinfr4010->ValorIRRF = "R$".db_formatar($oEfdreinfr4010->efd03_valorirrf,'f');
                    $oefdreinfr4010->Protocolo =  $oEfdreinfr4010->efd03_protocolo;
                    $oefdreinfr4010->Status =  messageStatus($oEfdreinfr4010->efd03_status);
                    $oefdreinfr4010->Dataenvio = formateDate(substr($oEfdreinfr4010->efd03_dataenvio,0,10))." - ".substr($oEfdreinfr4010->efd03_dataenvio,11,8);
                    $oefdreinfr4010->MsgRetornoErro =  $oEfdreinfr4010->efd03_dscresp;
                   
                    $itens[] = $oefdreinfr4010;                
                  
            }
            
            $oRetorno->efdreinfr4010 = $itens;

        break;
    }
} catch (Exception $eErro) {
    if (db_utils::inTransaction()) {
        db_fim_transacao(true);
    }
    $oRetorno->iStatus  = 2;
    $oRetorno->sMessage = $eErro->getMessage();
}

function formateDate(string $date): string
{
    return date('d/m/Y', strtotime($date));
}

function formateDateReverse(string $date): string
{
   
    $data_objeto = DateTime::createFromFormat('d/m/Y', $date);
    $data_formatada = $data_objeto->format('Y-m-d');
    return date('Y-m-d', strtotime($data_formatada));
}
function clean_cpf_cnpj($valor){
    $valor = trim($valor);
    $valor = str_replace(array('.','-','/'), "", $valor);
    return $valor;
}
function tranformarFloat($numero){
    $numero = str_replace(".", "", $numero); 
    $numero = str_replace(",", ".", $numero);
    return $numero_float = (float) $numero;
}
function searchCgm($valor){
    $valor = explode("-",$valor);
    return $valor[2];
}
function removeAccents($str) {
    $acentosMap = array(
        'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'ä' => 'a', 'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
        'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i', 'ó' => 'o', 'ò' => 'o', 'õ' => 'o', 'ô' => 'o', 'ö' => 'o',
        'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u', 'ç' => 'c', 'Á' => 'A', 'À' => 'A', 'Ã' => 'A', 'Â' => 'A',
        'Ä' => 'A', 'É' => 'E', 'È' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Í' => 'I', 'Ì' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ó' => 'O', 'Ò' => 'O', 'Õ' => 'O', 'Ô' => 'O', 'Ö' => 'O', 'Ú' => 'U', 'Ù' => 'U', 'Û' => 'U', 'Ü' => 'U',
        'Ç' => 'C', '&' => 'e'
    );
    return strtr($str, $acentosMap);
}
function messageStatus($status){
    switch($status){
        case 1 : 
            return "EM PROCESSAMENTO" ;
        break;
        case 2 : 
            return "ENVIADO" ;
            break;
        case 3 : 
            return "ERRO NO ENVIO" ;
            break;
        case 8 : 
            return "ERRO NA CONSULTA " ;
            break;
        case 9 : 
            return "ERRO NA CONSULTA" ;
            break;
        case 99 :
            return "ERRO NO ENVIO" ;
            break;
        default:
            return " " ;
        break;
    }
}
$oRetorno->erro = $oRetorno->iStatus == 2;
echo JSON::create()->stringify($oRetorno);