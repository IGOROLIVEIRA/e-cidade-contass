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
require_once('classes/db_efdreinfr2099_classe.php');
require_once('classes/db_efdreinfr2010_classe.php');
require_once('classes/db_efdreinfnotasr2010_classe.php');
require_once('classes/db_efdreinfr2055_classe.php');
require_once('classes/db_efdreinfnotasr2055_classe.php');
require_once('classes/db_empnota_classe.php');
require_once("model/efdreinf/EfdReinf.model.php");

$oJson = new services_json();
$oParam = JSON::create()->parse(str_replace('\\', "", $_POST["json"]));
$oRetorno = new stdClass();
$oRetorno->iStatus  = 1;
$oRetorno->sMessage = '';
$sInstituicao       = db_getsession('DB_instit');
try {
    switch ($oParam->exec) {

        case "getEventos2010":

            $iUltimoDiaMes = date("d", mktime(0, 0, 0, $oParam->sMescompetencia + 1, 0, $oParam->sAnocompetencia));
            $sDataInicialFiltros = $oParam->sAnocompetencia . "-{$oParam->sMescompetencia}-01";
            $sDataFinalFiltros   = $oParam->sAnocompetencia . "-{$oParam->sMescompetencia}-{$iUltimoDiaMes}";
            $sCampos = "distinct e50_codord,
                        cgm.z01_nome,
                        cgm.z01_cgccpf,
                        efd60_numcno,
                        e70_valor,
                        e70_vlrliq,
                        e69_numero,
                        e69_nfserie,
                        e69_dtnota,
                        e70_valor,
                        e23_valorbase,
                        e21_retencaotipocalc,
                        e23_valorretencao,
                        efd60_prescontricprb,
                        efd60_tiposervico,
                        efd60_indprestservico,
                        efd60_cessaomaoobra,
                        efd60_possuicno,
                        e60_codemp,
                        e60_anousu,
                        efd60_numcno";
            $sWhere  = " where length(cgm.z01_cgccpf) = 14 and e69_dtnota between '{$sDataInicialFiltros}' and '{$sDataFinalFiltros}' and e23_ativo = true and e21_retencaotipocalc in (4) and e60_instit = {$sInstituicao}";
            $clempnota           = new cl_empnota;
            $rsEfdreinfR2010 = $clempnota->sql_record($clempnota->sqlRelRetencoesPJ($sWhere, null, " order by z01_cgccpf", $sCampos));

            $valorBruto = 0;
            $valorBase  = 0;
            $valorRetencao = 0;
            for ($iCont = 0; $iCont < pg_num_rows($rsEfdreinfR2010); $iCont++) {
                $oEfdreinfr2010 = db_utils::fieldsMemory($rsEfdreinfR2010, $iCont);
                $oEfdreinfr2010Proximo = db_utils::fieldsMemory($rsEfdreinfR2010, $iCont + 1);

                $destacarcampos = 3;
                if ($oParam->sStatus != 3) {
                    $destacarcampos = 2;
                    $instituicao = db_getsession("DB_instit");
                    $sWhereNotas = " efd05_cnpjprestador = '{$oEfdreinfr2010->z01_cgccpf}' and efd06_numeroop = '{$oEfdreinfr2010->e50_codord}' and efd06_numdocto = '{$oEfdreinfr2010->e69_numero}' and efd05_instit = {$instituicao} and efd05_ambiente = {$oParam->sAmbiente} and (efd05_status = 2 or efd05_dscresp like 'Não é permitido o envio de mais de um evento para o mesmo contribuinte, num mesmo período de apuração%')";
                    $cldestacarcampos = new cl_efdreinfr2010;
                    $rsDestacarcampos = $cldestacarcampos->sql_record($cldestacarcampos->sql_query_file(null,"*",null,$sWhereNotas));

                    if (pg_num_rows($rsDestacarcampos) > 0) {
                        $destacarcampos = 1;
                    }
                }
               
                $sHash = $oEfdreinfr2010->z01_cgccpf.$oEfdreinfr2010->efd60_numcno;
                $sHashproximo = $oEfdreinfr2010Proximo->z01_cgccpf.$oEfdreinfr2010Proximo->efd60_numcno;

                $valorBruto += $oEfdreinfr2010->e70_valor;
                $valorBase  += $oEfdreinfr2010->e23_valorbase;
                $valorRetencao += $oEfdreinfr2010->e23_valorretencao;

                $filtroNumCno = " and (efd60_numcno is null or efd60_numcno = '' ) ";
                if ($oEfdreinfr2010->efd60_numcno) {
                    $filtroNumCno = " and efd60_numcno = '{$oEfdreinfr2010->efd60_numcno}' ";
                } 
               
                $sWhere  = " where length(cgm.z01_cgccpf) = 14 and e69_dtnota between '{$sDataInicialFiltros}' and '{$sDataFinalFiltros}' and e23_ativo = true and e21_retencaotipocalc in (4)  and z01_cgccpf = '$oEfdreinfr2010->z01_cgccpf' $filtroNumCno ";
                $rsnotas2010 = $clempnota->sql_record($clempnota->sqlRelRetencoesPJ($sWhere, null, null, $sCampos));
                $separador = " ; ";
                $oefdreinfr2010     = new stdClass();

                for ($i = 0; $i < pg_num_rows($rsnotas2010); $i++) {
                    $oNota2010 = db_utils::fieldsMemory($rsnotas2010, $i);
                    if (pg_num_rows($rsnotas2010) - $i  == 1) {
                        $separador = " ; ,";
                    }
                        $oefdreinfr2010->DadosExtras[] = searchDescricao($oNota2010->efd60_tiposervico) . " ; ," . $oNota2010->e69_numero . " ; ," . $oNota2010->e69_nfserie . " ; ," . formateDate($oNota2010->e69_dtnota)  . " ; ," . $oNota2010->e60_codemp."/".$oNota2010->e60_anousu . " ; ," . $oNota2010->e50_codord . " ; ," . "R$" .db_formatar($oNota2010->e70_valor, 'f') . " ; ," . "R$" . db_formatar($oNota2010->e23_valorbase, 'f') . " ; ," . "R$" . db_formatar($oNota2010->e23_valorretencao, 'f'). " ; ," .  db_formatar($oNota2010->z01_cgccpf, 'cnpj')." - ".$oNota2010->z01_nome.$separador;
                        $oefdreinfr2010->DadosExtrasNotas[] = searchDescricao($oNota2010->efd60_tiposervico) . " ; ," . $oNota2010->e69_numero . " ; ," . $oNota2010->e69_nfserie . " ; ," . formateDate($oNota2010->e69_dtnota) . " ; ," . "R$" .db_formatar($oNota2010->e70_valor, 'f') . " ; ," . "R$" . db_formatar($oNota2010->e23_valorbase, 'f') . " ; ," . "R$" . db_formatar($oNota2010->e23_valorretencao, 'f'). " ; ," .$oNota2010->e50_codord. " ; ," .$oNota2010->e60_codemp."/".$oNota2010->e60_anousu.$separador;
                } 
                
                if ($sHash != $sHashproximo) {
               
                    $oefdreinfr2010->Estabelecimento = db_formatar($oEfdreinfr2010->z01_cgccpf, 'cnpj')." - ".removeAccents($oEfdreinfr2010->z01_nome);
                    $oefdreinfr2010->CNPJPrestador   = $oEfdreinfr2010->efd60_numcno;
                    $oefdreinfr2010->ValorBruto      = "R$" . db_formatar($valorBruto, 'f');
                    $oefdreinfr2010->ValorBase       = "R$" . db_formatar($valorBase, 'f');
                    $oefdreinfr2010->ValorRetidoCP   = "R$" . db_formatar($valorRetencao, 'f');
                    $oefdreinfr2010->OptanteCPRB     = $oEfdreinfr2010->efd60_prescontricprb == 0 ? '0 - Não é contribuinte da CPRB retenção de 11%' : '1 - É contribuinte da CPRB retenção de 3,5%.';
                    $oefdreinfr2010->Obra            = searchObras($oEfdreinfr2010->efd60_indprestservico);
                    $oefdreinfr2010->PossuiCNO       = $oEfdreinfr2010->efd60_possuicno;
                    $oefdreinfr2010->NumeroCNO       = $oEfdreinfr2010->efd60_numcno;
                    $oefdreinfr2010->IndPrestServico = $oEfdreinfr2010->efd60_indprestservico;
                    $oefdreinfr2010->DestacarCampos  = $destacarcampos;

                    $itens[] = $oefdreinfr2010;

                    $valorBruto = 0;
                    $valorBase  = 0;
                    $valorRetencao = 0;
                } 

            } 

            $oRetorno->efdreinfr2010 = $itens;

            break;
        case "transmitirreinf2010":

            $cldb_config = new cl_db_config;
            $resul = $cldb_config->sql_record($cldb_config->sql_query($sInstituicao, "cgc,z01_numcgm", "", " codigo = {$sInstituicao} "));
            db_fieldsmemory($resul, 0);

            foreach ($oParam->aEventos as $oEventos) {
                
                $oEventos->CNPJPrestador = clean_cpf_cnpj($oEventos->CNPJPrestador);

                $clEfdReinf = new EFDReinfEventos($oEventos, $oParam, $cgc);

                $oDados = $clEfdReinf->montarDadosReinfR2010();
                
                $oCertificado = $clEfdReinf->buscarCertificado($z01_numcgm);

                $rsApiEnvio = $clEfdReinf->emitirReinfR2010($oDados, $oCertificado);

                $dhRecepcaoEnvio     = $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
                $protocoloEnvio = (string) $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->protocoloEnvio;

                sleep(5);
                $oDados = $clEfdReinf->montarDadosReinfR2010();
                
                $clEfdReinf = new EFDReinfEventos($oEventos, $oParam, $cgc);
                
                $rsApiConsulta = $clEfdReinf->buscarReinfR2010($oDados, $oCertificado, $protocoloEnvio);
                               
                if ($protocoloEnvio) {
                    $statusConsulta         = $rsApiConsulta->retornoLoteEventosAssincrono->status->cdResposta;
                    $descRespostaConsulta   = (string) $rsApiConsulta->retornoLoteEventosAssincrono->status->descResposta;
                    $dhRecepcaoConsulta     = $rsApiConsulta->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
                    $dscRespConsulta        = (string) $rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtTotal->ideRecRetorno->ideStatus->regOcorrs->dscResp;
                    $codRespConsulta        = $rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtRet->ideRecRetorno->ideStatus->regOcorrs->codResp;
                } else {
                    $statusConsulta         = $rsApiEnvio->retornoLoteEventosAssincrono->status->cdResposta;
                    $descRespostaConsulta   = (string) $rsApiEnvio->retornoLoteEventosAssincrono->status->descResposta;
                    $dscRespConsulta        = (string) $rsApiEnvio->retornoLoteEventosAssincrono->status->ocorrencias->ocorrencia->descricao;
                } 

                $clefdreinfR2010 = new cl_efdreinfr2010;
                $clefdreinfR2010->efd05_mescompetencia     = $oParam->sMescompetencia;
                $clefdreinfR2010->efd05_cnpjprestador      = substr(clean_cpf_cnpj($oEventos->CNPJPrestador), 0, 14);
                $clefdreinfR2010->efd05_estabelecimento    = removeAccents(substr($oEventos->Estabelecimento,21));
                $clefdreinfR2010->efd05_ambiente           = $oParam->sAmbiente;
                $clefdreinfR2010->efd05_instit             = $sInstituicao;
                $clefdreinfR2010->efd05_anocompetencia     = $oParam->sAnocompetencia;
                $clefdreinfR2010->efd05_valorbruto         = tranformarFloat(ltrim($oEventos->ValorBruto));
                $clefdreinfR2010->efd05_valorbase          = tranformarFloat(ltrim($oEventos->ValorBase));
                $clefdreinfR2010->efd05_valorretidocp      = tranformarFloat(ltrim($oEventos->ValorRetidoCP));
                $clefdreinfR2010->efd05_protocolo          = $protocoloEnvio;
                $clefdreinfR2010->efd05_dataenvio          = $dhRecepcaoEnvio;
                $clefdreinfR2010->efd05_indprestservico    = $oEventos->Obra;
                $clefdreinfR2010->efd05_optantecprb        = $oEventos->OptanteCPRB;
                $clefdreinfR2010->efd05_status             = $statusConsulta;
                $clefdreinfR2010->efd05_descResposta       = utf8_decode($descRespostaConsulta);
                $clefdreinfR2010->efd05_dscResp            = removeAspas(utf8_decode($dscRespConsulta));
                $clefdreinfR2010->incluir();

                if ($clefdreinfR2010->erro_status == 0) {
                    throw new Exception($clefdreinfR2010->erro_msg);
                }

                $dados = str_replace(["\r", "\n", " ; ,"], ["", "", ";"],  $oEventos->DadosExtras);
                $itens = explode(";", $dados);
                $itens = array_filter(array_map('trim', $itens));
                $dadosArray = array_chunk($itens, 9);
        
                $dadosNotas = [];
                foreach ($dadosArray as $chave => $valor) {
                    $dadosNotas[$chave] = array(
                        "tipoServico" => $valor[0],
                        "serie" => $valor[2],
                        "numDocto" => $valor[1],
                        "dtEmissaoNF" => $valor[3],
                        "vlrBruto" => $valor[4],
                        "vlrBase" => $valor[5],
                        "vlrRetido" => $valor[6],
                        "obs" => $valor[7],
                    );
                    if (isset($dadosNotas[$chave]['dtEmissaoNF']) && DateTime::createFromFormat('d/m/Y', $dadosNotas[$chave]['dtEmissaoNF'])) {
                        $dataObj = DateTime::createFromFormat('d/m/Y', $dadosNotas[$chave]['dtEmissaoNF']);
                        $dadosNotas[$chave]['dtEmissaoNF'] = $dataObj->format('Y-m-d');
                    }
                    $camposMonetarios = ['vlrBruto', 'vlrBase', 'vlrRetido'];
                    foreach ($camposMonetarios as $campo) {
                        if (isset($dadosNotas[$chave][$campo])) {
                            $dadosNotas[$chave][$campo] = str_replace(['R$', ' ', ' '], '', $dadosNotas[$chave][$campo]);
                        }
                    }
                } 
                foreach ($dadosNotas as $aDadosNotas) {
                   
                    $clefdreinfnotasR2010 = new cl_efdreinfnotasr2010;
                    $clefdreinfnotasR2010->efd06_cnpjprestador      = substr(clean_cpf_cnpj($oEventos->CNPJPrestador), 0, 14);
                    $clefdreinfnotasR2010->efd06_protocolo          = $protocoloEnvio;
                    $clefdreinfnotasR2010->efd06_tipoServico        = $aDadosNotas['tipoServico'];
                    $clefdreinfnotasR2010->efd06_serie              = $aDadosNotas['serie'];
                    $clefdreinfnotasR2010->efd06_numDocto           = $aDadosNotas['numDocto'];
                    $clefdreinfnotasR2010->efd06_dtEmissaoNF        = $aDadosNotas['dtEmissaoNF'];
                    $clefdreinfnotasR2010->efd06_vlrBruto           = tranformarFloat(ltrim($aDadosNotas['vlrBruto']));
                    $clefdreinfnotasR2010->efd06_vlrBase            = tranformarFloat(ltrim($aDadosNotas['vlrBase']));
                    $clefdreinfnotasR2010->efd06_vlrRetido          = tranformarFloat(ltrim($aDadosNotas['vlrRetido']));
                    $clefdreinfnotasR2010->efd06_numeroop           = $aDadosNotas['obs'];
                    $clefdreinfnotasR2010->efd06_mescompetencia     = $oParam->sMescompetencia;
                    $clefdreinfnotasR2010->efd06_anocompetencia     = $oParam->sAnocompetencia;
                    $clefdreinfnotasR2010->efd06_ambiente           = $oParam->sAmbiente;
                    $clefdreinfnotasR2010->efd06_instit             = $sInstituicao;

                    $clefdreinfnotasR2010->incluir();
                }

                if ($clefdreinfnotasR2010->erro_status == 0) {
                    throw new Exception($clefdreinfnotasR2010->erro_msg);
                }
                  
                if ($descRespostaConsulta) {
                    $oRetorno->sMessage = "O lote foi processado. Acesse o menu de consultas para verificar o status do evento.";
                }
            }
            break;
        case "getConsultarEvento2010":

            $status = '';
            $sCampos = " distinct efd05_sequencial,
            efd05_mescompetencia,
            efd05_cnpjprestador,
            efd05_estabelecimento,
            case when efd05_status = 2 or efd05_dscresp like 'Não é permitido o envio de mais de um evento para o mesmo contribuinte, num mesmo período de apuração%'  then 2 else efd05_status end as efd05_status,
            efd05_dscresp,
            efd05_descResposta,
            efd05_ambiente,
            efd05_protocolo,
            efd60_numcno,
            efd05_valorbruto,
            efd05_valorbase,
            efd05_valorretidocp,
            efd05_optantecprb,
            efd05_indprestservico,
            efd05_dataenvio,
            efd60_possuicno
            ";
            if ($oParam->sStatus) {
                $status = " and efd05_status = $oParam->sStatus ";
                if ($oParam->sStatus == 2)
                    $status = " and (efd05_status = 2 or efd05_dscresp like 'Não é permitido o envio de mais de um evento para o mesmo contribuinte, num mesmo período de apuração%') ";
                if ($oParam->sStatus == 3)
                    $status = " and (( efd05_status = 3 or efd05_status is null ) and efd05_dscresp not like 'Não é permitido o envio de mais de um evento para o mesmo contribuinte, num mesmo período de apuração%') ";
          
            }

            $instituicao = db_getsession("DB_instit");
            $sWhere = " efd05_mescompetencia = '{$oParam->sMescompetencia}' and efd05_anocompetencia = '$oParam->sAnocompetencia' and efd05_ambiente = '$oParam->sAmbiente' and efd05_instit = {$instituicao} $status  ";
        
            $clefdreinfr2010 = new cl_efdreinfr2010;
            $rsEfdreinfR2010 = $clefdreinfr2010->sql_record($clefdreinfr2010->sql_query_file(null,$sCampos,null,$sWhere));

            for ($iCont = 0; $iCont < pg_num_rows($rsEfdreinfR2010); $iCont++) {

                $oEfdreinfr2010 = db_utils::fieldsMemory($rsEfdreinfR2010, $iCont);
                $sWhere = " efd05_mescompetencia = '{$oParam->sMescompetencia}' and efd05_anocompetencia = '$oParam->sAnocompetencia' and efd05_ambiente = '$oParam->sAmbiente' and efd05_instit = {$instituicao} $status and efd06_protocolo =  '$oEfdreinfr2010->efd05_protocolo' ";
                $rsnotas2010 = $clefdreinfr2010->sql_record($clefdreinfr2010->sql_query_file(null,"*",null,$sWhere));
                $separador = " ; ";
                $oefdreinfr2010     = new stdClass();
                for ($i = 0; $i < pg_num_rows($rsnotas2010); $i++) {
                    if (pg_num_rows($rsnotas2010) - $i  == 1) {
                        $separador = " ; ,";
                    }
                        $oNota2010 = db_utils::fieldsMemory($rsnotas2010, $i);
                        $oefdreinfr2010->DadosExtras[] = $oNota2010->efd06_tiposervico. " ; ," . $oNota2010->efd06_numdocto . " ; ," . $oNota2010->efd06_serie . " ; ," . formateDate($oNota2010->efd06_dtemissaonf) . " ; ," . $oNota2010->e60_codemp."/".$oNota2010->e60_anousu  . " ; ," . $oNota2010->efd06_numeroop . " ; ," . "R$" .db_formatar($oNota2010->efd06_vlrbruto, 'f') . " ; ," . "R$" . db_formatar($oNota2010->efd06_vlrbase, 'f') . " ; ," . "R$" . db_formatar($oNota2010->efd06_vlrretido, 'f'). " ; ," .  db_formatar($oEfdreinfr2010->efd05_cnpjprestador, 'cnpj') ." - ".$oEfdreinfr2010->efd05_estabelecimento.$separador;
                } 
  
                $oefdreinfr2010->Estabelecimento = db_formatar($oEfdreinfr2010->efd05_cnpjprestador, 'cnpj')." - ".removeAccents($oEfdreinfr2010->efd05_estabelecimento);
                $oefdreinfr2010->CNPJPrestador   = $oEfdreinfr2010->efd60_numcno ? $oEfdreinfr2010->efd60_numcno: '';
                $oefdreinfr2010->ValorBruto      = "R$" . db_formatar($oEfdreinfr2010->efd05_valorbruto, 'f');
                $oefdreinfr2010->ValorBase       = "R$" . db_formatar($oEfdreinfr2010->efd05_valorbase, 'f');
                $oefdreinfr2010->ValorRetidoCP   = "R$" . db_formatar($oEfdreinfr2010->efd05_valorretidocp, 'f');
                $oefdreinfr2010->OptanteCPRB     = $oEfdreinfr2010->efd05_optantecprb == 0 ? '0 - Não é contribuinte da CPRB retenção de 11%' : '1 - É contribuinte da CPRB retenção de 3,5%.';
                $oefdreinfr2010->Obra            = $oEfdreinfr2010->efd05_indprestservico;
                $oefdreinfr2010->Protocolo       = $oEfdreinfr2010->efd05_protocolo;
                $oefdreinfr2010->DataEnvio       = formateDate(substr($oEfdreinfr2010->efd05_dataenvio, 0, 10)) . " - " . substr($oEfdreinfr2010->efd05_dataenvio, 11, 8);
                $oefdreinfr2010->Status          = messageStatus($oEfdreinfr2010->efd05_status);
                $oefdreinfr2010->DscResp         = $oEfdreinfr2010->efd05_status ? $oEfdreinfr2010->efd05_dscresp : "Erro no envio";;
                
                $itens[] = $oefdreinfr2010;
                
            }
            $oRetorno->efdreinfr2010 = $itens;
         break;
        case "getEventos2055":

            $iUltimoDiaMes = date("d", mktime(0, 0, 0, $oParam->sMescompetencia + 1, 0, $oParam->sAnocompetencia));
            $sDataInicialFiltros = $oParam->sAnocompetencia . "-{$oParam->sMescompetencia}-01";
            $sDataFinalFiltros   = $oParam->sAnocompetencia . "-{$oParam->sMescompetencia}-{$iUltimoDiaMes}";

            $sWhere  = " where e69_dtnota between '{$sDataInicialFiltros}' and '{$sDataFinalFiltros}' and e23_ativo = true and (e21_retencaotipocalc in ('10','11','12') or efd60_aquisicaoprodrural != 0) and e60_instit = {$sInstituicao}";
            $sGroupBY =" group by 1, 2, 3, 4, 5, 6, 7, e21_retencaotipocalc, e23_valorretencao";
            $clempnota           = new cl_empnota;
            $rsEfdreinfR2055 = $clempnota->sql_record($clempnota->sqlRelRetencoesReinf($sWhere, $sGroupBY, null, null));
        
            for ($iCont = 0; $iCont < pg_num_rows($rsEfdreinfR2055); $iCont++) {
                $oEfdreinfr2055 = db_utils::fieldsMemory($rsEfdreinfR2055, $iCont);
              
                $destacarcampos = 3;
                if ($oParam->sStatus != 3) {
                    $destacarcampos = 2;
                    $instituicao = db_getsession("DB_instit");
                    $sWhereNotas = " efd07_cpfcnpjprodutor = '{$oEfdreinfr2055->z01_cgccpf}' and efd07_instit = {$instituicao} and efd07_ambiente = {$oParam->sAmbiente} and ( efd07_status = 2 or efd07_dscresp like 'Não é permitido o envio de mais de um evento para o contribuinte, num mesmo período de apuração%')";
                    $cldestacarcampos = new cl_efdreinfr2055;
                    $rsDestacarcampos = $cldestacarcampos->sql_record($cldestacarcampos->sql_query_file(null,"*",null,$sWhereNotas));
                    if (pg_num_rows($rsDestacarcampos) > 0) {
                        $destacarcampos = 1;
                    }
                }
   
                $sWhere  = " where e69_dtnota between '{$sDataInicialFiltros}' and '{$sDataFinalFiltros}' and e23_ativo = true and z01_cgccpf = '$oEfdreinfr2055->z01_cgccpf' and  (e21_retencaotipocalc in ('10','11','12') or efd60_aquisicaoprodrural != 0) ";
                $sGroupBY =" group by 1,2,3,4,5,6,7,8,9,10,11,12,e21_retencaotipocalc, e23_valorretencao";
                $rsnotas2055 = $clempnota->sql_record($clempnota->sqlRelRetencoesReinfNotas($sWhere, $sGroupBY, null, null));
                $separador = " ; ";
                $oefdreinfr2055     = new stdClass();
              
                for ($i = 0; $i < pg_num_rows($rsnotas2055); $i++) {
                    $oNota2055 = db_utils::fieldsMemory($rsnotas2055, $i);
                    if (pg_num_rows($rsnotas2055) - $i  == 1) {
                        $separador = " ; ,";
                    }
                    $oNota2055->efd60_prodoptacp = $oNota2055->efd60_prodoptacp ? $oNota2055->efd60_prodoptacp : "S/N";
                    $z01_cgccpf =  strlen($oNota2055->z01_cgccpf) == 11 ? db_formatar($oNota2055->z01_cgccpf, 'cpf') : db_formatar($oNota2055->z01_cgccpf, 'cnpj');
                    $oefdreinfr2055->DadosExtras[] = $oNota2055->e69_numero . " ; ," . $oNota2055->e69_nfserie . " ; ," . formateDate($oNota2055->e69_dtnota)  . " ; ," . $oNota2055->e60_codemp."/".$oNota2055->e60_anousu . " ; ," . $oNota2055->e50_codord . " ; ," . "R$" .db_formatar($oNota2055->e70_valor, 'f') . " ; ," . "R$" . db_formatar($oNota2055->valor_cp, 'f') . " ; ," . "R$" . db_formatar($oNota2055->valor_gilrat, 'f'). " ; ," . "R$" . db_formatar($oNota2055->valor_senar, 'f'). " ; ," . searchIndAquisicao($oNota2055->efd60_aquisicaoprodrural). " ; ," .  $z01_cgccpf." - ". $oNota2055->z01_nome.$separador;
                    $oefdreinfr2055->DadosExtrasNotas[] = $oNota2055->e69_numero . " ; ," . $oNota2055->e69_nfserie . " ; ," . formateDate($oNota2055->e69_dtnota) . " ; ," . "R$" .db_formatar($oNota2055->e70_valor, 'f') . " ; ," . "R$" . db_formatar($oNota2055->valor_cp, 'f') . " ; ," . "R$" . db_formatar($oNota2055->valor_gilrat, 'f'). " ; ," . "R$" . db_formatar($oNota2055->valor_senar, 'f'). " ; ," .$oNota2055->e50_codord. " ; ," . searchIndAquisicao($oNota2055->efd60_aquisicaoprodrural). " ; ," .  $oNota2055->efd60_prodoptacp. " ; ," . $oNota2055->e60_codemp."/".$oNota2055->e60_anousu.$separador;
                } 
                $oefdreinfr2055->CPFCNPJProdutor = strlen($oEfdreinfr2055->z01_cgccpf) == 11 ? db_formatar($oEfdreinfr2055->z01_cgccpf, 'cpf')." - ".$oEfdreinfr2055->z01_nome : db_formatar($oEfdreinfr2055->z01_cgccpf, 'cnpj')." - ".$oEfdreinfr2055->z01_nome;
                $oefdreinfr2055->ValorBruto      = "R$" . db_formatar($oEfdreinfr2055->e70_valor, 'f');
                $oefdreinfr2055->ValorCP         = "R$" . db_formatar($oEfdreinfr2055->valor_cp, 'f');
                $oefdreinfr2055->ValorGILRAT     = "R$" . db_formatar($oEfdreinfr2055->valor_gilrat, 'f');
                $oefdreinfr2055->ValorSenar      = "R$" . db_formatar($oEfdreinfr2055->valor_senar, 'f');
                $oefdreinfr2055->TipoProdutor    = strlen($oEfdreinfr2055->z01_cgccpf) == 11 ? "CPF" : "CNPJ";
                $oefdreinfr2055->ProdOptaCp      = $oNota2055->efd60_prodoptacp;
                $oefdreinfr2055->DestacarCampos  = $destacarcampos;

                $itens[] =  $oefdreinfr2055;
            } 
            $oRetorno->efdreinfr2055 = $itens;
            break;
        case "transmitirreinf2055":

            $cldb_config = new cl_db_config;
            $resul = $cldb_config->sql_record($cldb_config->sql_query($sInstituicao, "cgc,z01_numcgm", "", " codigo = {$sInstituicao} "));
            db_fieldsmemory($resul, 0);

            foreach ($oParam->aEventos as $oEventos) {
                
                $oEventos->CPFCNPJProdutor = clean_cpf_cnpj($oEventos->CPFCNPJProdutor);


                $clEfdReinf = new EFDReinfEventos($oEventos, $oParam, $cgc);

                $oDados = $clEfdReinf->montarDadosReinfR2055();
                
                $oCertificado = $clEfdReinf->buscarCertificado($z01_numcgm);

                $rsApiEnvio = $clEfdReinf->emitirReinfR2055($oDados, $oCertificado);

                $dhRecepcaoEnvio     = $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
                $protocoloEnvio = (string) $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->protocoloEnvio;

                sleep(5);
                $oDados = $clEfdReinf->montarDadosReinfR2055();
    
                $clEfdReinf = new EFDReinfEventos($oEventos, $oParam, $cgc);
                $rsApiConsulta = $clEfdReinf->buscarReinfR2055($oDados, $oCertificado, $protocoloEnvio);

                if ($protocoloEnvio) {
                    $statusConsulta         = $rsApiConsulta->retornoLoteEventosAssincrono->status->cdResposta;
                    $descRespostaConsulta   = (string) $rsApiConsulta->retornoLoteEventosAssincrono->status->descResposta;
                    $dhRecepcaoConsulta     = $rsApiConsulta->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
                    $dscRespConsulta        = (string) $rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtTotal->ideRecRetorno->ideStatus->regOcorrs->dscResp;
                    $codRespConsulta        = $rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtRet->ideRecRetorno->ideStatus->regOcorrs->codResp;
                } else {
                    $statusConsulta         = $rsApiEnvio->retornoLoteEventosAssincrono->status->cdResposta;
                    $descRespostaConsulta   = (string) $rsApiEnvio->retornoLoteEventosAssincrono->status->descResposta;
                    $dscRespConsulta        = (string) $rsApiEnvio->retornoLoteEventosAssincrono->status->ocorrencias->ocorrencia->descricao;
                }

                $clefdreinfR2055 = new cl_efdreinfr2055;
                $clefdreinfR2055->efd07_mescompetencia     = $oParam->sMescompetencia;
                $clefdreinfR2055->efd07_cpfcnpjprodutor   = clean_cpf_cnpj($oEventos->CPFCNPJProdutor);
                $clefdreinfR2055->efd07_ambiente           = $oParam->sAmbiente;
                $clefdreinfR2055->efd07_instit             = $sInstituicao;
                $clefdreinfR2055->efd07_anocompetencia     = $oParam->sAnocompetencia;
                $clefdreinfR2055->efd07_valorbruto         = tranformarFloat(ltrim($oEventos->ValorBruto));
                $clefdreinfR2055->efd07_valorcp            = tranformarFloat(ltrim($oEventos->ValorCP));
                $clefdreinfR2055->efd07_valorgilrat        = tranformarFloat(ltrim($oEventos->ValorGILRAT));
                $clefdreinfR2055->efd07_valorsenar         = tranformarFloat(ltrim($oEventos->ValorSenar));
                $clefdreinfR2055->efd07_protocolo          = $protocoloEnvio;
                $clefdreinfR2055->efd07_dataenvio          = $dhRecepcaoEnvio;
                $clefdreinfR2055->efd07_status             = $statusConsulta;
                $clefdreinfR2055->efd07_descResposta       = utf8_decode($descRespostaConsulta);
                $clefdreinfR2055->efd07_dscResp            =  removeAspas(utf8_decode($dscRespConsulta));

                $clefdreinfR2055->incluir();

                if ($clefdreinfR2055->erro_status == 0) {
                    throw new Exception($clefdreinfR2055->erro_msg);
                }
                $dados = str_replace(["\r", "\n", " ; ,"], ["", "", ";"],  $oEventos->DadosExtras);
                $itens = explode(";", $dados);
                $itens = array_filter(array_map('trim', $itens));
                $dadosArray = array_chunk($itens, 11);
                $dadosNotas = [];
                foreach ($dadosArray as $chave => $valor) {
                    $dadosNotas[$chave] = array(
                        "numNotaFiscal" => $valor[0],
                        "serie"         => $valor[1],
                        "dtEmissaoNF"   => $valor[2],
                        "vlrBruto"      => $valor[3],
                        "vlrCP"         => $valor[4],
                        "vlrGilrat"     => $valor[5],
                        "vlrSenar"      => $valor[6],
                        "numOP"         => $valor[7],
                        "indAquisicao"  => $valor[8],
                        "prodOptaCp"    => $valor[9],
                        "numEmp"        => $valor[10],
                    );
                    if (isset($dadosNotas[$chave]['dtEmissaoNF']) && DateTime::createFromFormat('d/m/Y', $dadosNotas[$chave]['dtEmissaoNF'])) {
                        $dataObj = DateTime::createFromFormat('d/m/Y', $dadosNotas[$chave]['dtEmissaoNF']);
                        $dadosNotas[$chave]['dtEmissaoNF'] = $dataObj->format('Y-m-d');
                    }
                    $camposMonetarios = ['vlrBruto', 'vlrCP', 'vlrGilrat', 'vlrSenar'];
                    foreach ($camposMonetarios as $campo) {
                        if (isset($dadosNotas[$chave][$campo])) {
                            $dadosNotas[$chave][$campo] = str_replace(['R$', ' ', ' '], '', $dadosNotas[$chave][$campo]);
                        }
                    }
                } 
                foreach ($dadosNotas as $aDadosNotas) {
                   
                    $clefdreinfnotasR2055 = new cl_efdreinfnotasr2055;
                    $clefdreinfnotasR2055->efd08_mescompetencia     = $oParam->sMescompetencia;
                    $clefdreinfnotasR2055->efd08_anocompetencia     = $oParam->sAnocompetencia;
                    $clefdreinfnotasR2055->efd08_cpfcnpjprodutor   = clean_cpf_cnpj($oEventos->CPFCNPJProdutor);
                    $clefdreinfnotasR2055->efd08_indaquisicao       = $aDadosNotas['indAquisicao'];
                    $clefdreinfnotasR2055->efd08_ambiente           = $oParam->sAmbiente;
                    $clefdreinfnotasR2055->efd08_instit             = $sInstituicao;
                    $clefdreinfnotasR2055->efd08_protocolo          = $protocoloEnvio;
                    $clefdreinfnotasR2055->efd08_serie              = $aDadosNotas['serie'];
                    $clefdreinfnotasR2055->efd08_numnotafiscal      = $aDadosNotas['numNotaFiscal'];
                    $clefdreinfnotasR2055->efd08_numeroop           = $aDadosNotas['numOP'];
                    $clefdreinfnotasR2055->efd08_numemp             = $aDadosNotas['numEmp'];
                    $clefdreinfnotasR2055->efd08_dtEmissaoNF        = $aDadosNotas['dtEmissaoNF'];
                    $clefdreinfnotasR2055->efd08_vlrBruto           = tranformarFloat(ltrim($aDadosNotas['vlrBruto']));
                    $clefdreinfnotasR2055->efd08_vlrCP              = tranformarFloat(ltrim($aDadosNotas['vlrCP']));
                    $clefdreinfnotasR2055->efd08_vlrGilrat          = tranformarFloat(ltrim($aDadosNotas['vlrGilrat']));
                    $clefdreinfnotasR2055->efd08_vlrSenar           = tranformarFloat(ltrim($aDadosNotas['vlrSenar']));

                    $clefdreinfnotasR2055->incluir();
                }

                if ($clefdreinfnotasR2055->erro_status == 0) {
                    throw new Exception($clefdreinfnotasR2055->erro_msg);
                }
                  
                if ($descRespostaConsulta) {
                    $oRetorno->sMessage = "O lote foi processado. Acesse o menu de consultas para verificar o status do evento.";
                }
            }
            break;
        case "getConsultarEvento2055":

            $status = '';
            $sCampos = "distinct efd07_cpfcnpjprodutor,
                        efd07_protocolo,
                        z01_nome,
                        efd07_valorbruto,
                        efd07_valorcp,
                        efd07_valorgilrat,
                        efd07_valorsenar,
                        efd07_dataenvio,
                        case when efd07_status = 2 or efd07_dscresp like 'Não é permitido o envio de mais de um evento para o contribuinte, num mesmo período de apuração%'  then 2 else efd07_status end as efd07_status,
                        efd07_dscresp,
                        efd07_descResposta
            ";
            if ($oParam->sStatus) {
                $status = " and efd07_status = $oParam->sStatus ";
                if ($oParam->sStatus == 2)
                    $status = " and (efd07_status = 2 OR efd07_dscresp LIKE 'Não é permitido o envio de mais de um evento para o contribuinte, num mesmo período de apuração%') ";
                if ($oParam->sStatus == 3)
                    $status = " and ((efd07_status = 3 or efd07_status is null ) and efd07_dscresp NOT LIKE 'Não é permitido o envio de mais de um evento para o contribuinte, num mesmo período de apuração%') ";
            }
            $instituicao = db_getsession("DB_instit");
            $sWhere = " efd07_mescompetencia = '{$oParam->sMescompetencia}' and efd07_anocompetencia = '$oParam->sAnocompetencia' and efd07_ambiente = '$oParam->sAmbiente' and efd07_instit = {$instituicao} $status  ";
        
            $clefdreinfr2055 = new cl_efdreinfr2055;
            $rsEfdreinfR2055 = $clefdreinfr2055->sql_record($clefdreinfr2055->sql_query_file(null,"$sCampos",null,$sWhere));

            for ($iCont = 0; $iCont < pg_num_rows($rsEfdreinfR2055); $iCont++) {

                $oEfdreinfr2055 = db_utils::fieldsMemory($rsEfdreinfR2055, $iCont);
                $sWhere = " efd07_mescompetencia = '{$oParam->sMescompetencia}' and efd07_anocompetencia = '$oParam->sAnocompetencia' and efd07_ambiente = '$oParam->sAmbiente' and efd07_instit = {$instituicao} and efd08_protocolo =  '$oEfdreinfr2055->efd07_protocolo'" ;
                $rsnotas2055 = $clefdreinfr2055->sql_record($clefdreinfr2055->sql_query_file(null,"*",null,$sWhere));
                $separador = " ; ";
                $oefdreinfr2055     = new stdClass();
                for ($i = 0; $i < pg_num_rows($rsnotas2055); $i++) {
                    if (pg_num_rows($rsnotas2055) - $i  == 1) {
                        $separador = " ; ,";
                    }
                    $oNota2055 = db_utils::fieldsMemory($rsnotas2055, $i);
                    $dadosProdutor = strlen($oNota2055->efd08_cpfcnpjprodutor ) == 11 ? db_formatar($oNota2055->efd08_cpfcnpjprodutor , 'cpf')." - ".$oNota2055->z01_nome : db_formatar($oNota2055->efd08_cpfcnpjprodutor , 'cnpj')." - ".$oNota2055->z01_nome;
                    
                    $oefdreinfr2055->DadosExtras[] = $oNota2055->efd08_numnotafiscal . " ; ," . $oNota2055->efd08_serie . " ; ," . formateDate($oNota2055->efd08_dtemissaonf)  . " ; ," . $oNota2055->efd08_numemp . " ; ," . $oNota2055->efd08_numeroop . " ; ," . "R$" .db_formatar($oNota2055->efd08_vlrbruto, 'f') . " ; ," . "R$" . db_formatar($oNota2055->ef08_vlrcp, 'f') . " ; ," . "R$" . db_formatar($oNota2055->efd08_vlrgilrat, 'f'). " ; ," . "R$" . db_formatar($oNota2055->efd08_vlrsenar, 'f'). " ; ," . searchIndAquisicao($oNota2055->efd08_indaquisicao). " ; ," .  $dadosProdutor.$separador;
                } 
                 
                $oefdreinfr2055->CPFCNPJProdutor = strlen($oEfdreinfr2055->efd07_cpfcnpjprodutor ) == 11 ? db_formatar($oEfdreinfr2055->efd07_cpfcnpjprodutor , 'cpf')." - ".$oEfdreinfr2055->z01_nome : db_formatar($oEfdreinfr2055->efd07_cpfcnpjprodutor , 'cnpj')." - ".$oEfdreinfr2055->z01_nome;
                $oefdreinfr2055->ValorBruto      = "R$" . db_formatar($oEfdreinfr2055->efd07_valorbruto, 'f');
                $oefdreinfr2055->ValorCP         = "R$" . db_formatar($oEfdreinfr2055->efd07_valorcp, 'f');
                $oefdreinfr2055->ValorGILRAT     = "R$" . db_formatar($oEfdreinfr2055->efd07_valorgilrat, 'f');
                $oefdreinfr2055->ValorSenar      = "R$" . db_formatar($oEfdreinfr2055->efd07_valorsenar, 'f');;
                $oefdreinfr2055->Protocolo       = $oEfdreinfr2055->efd07_protocolo;
                $oefdreinfr2055->DataEnvio       = $oEfdreinfr2055->efd07_dataenvio ? formateDate(substr($oEfdreinfr2055->efd07_dataenvio, 0, 10)) . " - " . substr($oEfdreinfr2055->efd07_dataenvio, 11, 8) : "";
                $oefdreinfr2055->Status          = messageStatus($oEfdreinfr2055->efd07_status);
                $oefdreinfr2055->DscResp         = $oEfdreinfr2055->efd07_status ? $oEfdreinfr2055->efd07_dscresp : "Erro no envio";

                $itens[] = $oefdreinfr2055;
                
            }

            $oRetorno->efdreinfr2055 = $itens;
            break;
        case "transmitirreinf2099":

            $oDaoCgm        = db_utils::getDao("cgm");
            $rsDadosCgm    = $oDaoCgm->sql_record($oDaoCgm->sql_query($oParam->sCgm));

            $cldb_config = new cl_db_config;

            if (pg_num_rows($rsDadosCgm) > 0) {
                $oDadosCgm = db_utils::fieldsMemory($rsDadosCgm, 0);

                if ($oDadosCgm->z01_telef == null || $oDadosCgm->z01_telef == '' || strlen($oDadosCgm->z01_telef) < 10) {
                    $oRetorno->sMessage = "Telefone do Responsável inválido! Informe o número do telefone com DDD.";
                    $oRetorno->erro = $oRetorno->iStatus == 2;
                    break;
                }

                if ($oDadosCgm->z01_email == null || $oDadosCgm->z01_email == '') {
                    $oRetorno->sMessage = "Email do Responsável inválido!.";
                    $oRetorno->erro = $oRetorno->iStatus == 2;
                    break;
                }
            }

            $resul = $cldb_config->sql_record($cldb_config->sql_query($sInstituicao, "cgc,z01_numcgm", "", " codigo = {$sInstituicao} "));
            db_fieldsmemory($resul, 0);

            $clefdreinfR2099 = new cl_efdreinfr2099;
            $clefdreinfR2099->efd04_mescompetencia = $oParam->sMescompetencia;
            $clefdreinfR2099->efd04_anocompetencia = $oParam->sAnocompetencia;
            $clefdreinfR2099->efd04_tipo           = $oParam->sTipo;
            $clefdreinfR2099->efd04_ambiente       = $oParam->sAmbiente;
            $clefdreinfR2099->efd04_cgm            = $oParam->sCgm;
            $clefdreinfR2099->efd04_instit         = $sInstituicao;
            $clefdreinfR2099->efd04_servicoprev    = $oParam->sServicoprev;
            $clefdreinfR2099->efd04_producaorural  = $oParam->sProducaorural;

            $oDadosCgm->z01_nome = removeAccents($oDadosCgm->z01_nome);
            $clEfdReinf = new EFDReinfEventos($clefdreinfR2099, $oDadosCgm, $cgc);

            $oDados = $clEfdReinf->montarDadosReinfR2099();

            $oCertificado = $clEfdReinf->buscarCertificado($z01_numcgm);

            $rsApiEnvio = $clEfdReinf->emitirReinfR2099($oDados, $oCertificado);
            $dhRecepcaoEnvio     = $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
            $protocoloEnvio = (string) $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->protocoloEnvio;

            sleep(5);
            $clEfdReinf = new EFDReinfEventos($clefdreinfR2099, $oDadosCgm, $cgc);
            $oDados = $clEfdReinf->montarDadosReinfR2099();
            $rsApiConsulta = $clEfdReinf->buscarReinfR2099($oDados, $oCertificado, $protocoloEnvio);
            
            $statusConsulta         = $rsApiConsulta->retornoLoteEventosAssincrono->status->cdResposta;
            $descRespostaConsulta   = (string) $rsApiConsulta->retornoLoteEventosAssincrono->status->descResposta;
            $dhRecepcaoConsulta     = $rsApiConsulta->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
            if ($rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtTotalContrib->ideRecRetorno->ideStatus->regOcorrs->dscResp) {
                foreach ($rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtTotalContrib->ideRecRetorno->ideStatus->regOcorrs as $MsgAux) {
                 $dscRespConsulta .=   (string) removeAspas(utf8_decode($MsgAux->dscResp)); 
                } 
            } else {
                $dscRespConsulta    =  (string) utf8_decode($rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtTotal->ideRecRetorno->ideStatus->regOcorrs->dscResp);
            }
       
            $codRespConsulta        = $rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtTotal->ideRecRetorno->ideStatus->regOcorrs->codResp;

            $clefdreinfR2099->efd04_protocolo    = $protocoloEnvio;
            $clefdreinfR2099->efd04_status       = $statusConsulta;
            $clefdreinfR2099->efd04_descResposta = utf8_decode($descRespostaConsulta);
            $clefdreinfR2099->efd04_dscResp      =  removeAspas(utf8_decode($dscRespConsulta));
            $clefdreinfR2099->efd04_dataenvio    = $dhRecepcaoEnvio;

            $clefdreinfR2099->incluir();

            if ($clefdreinfR2099->erro_status == 0) {
                    throw new Exception($clefdreinfR2099->erro_msg);
            }

            if ($descRespostaConsulta) {
                $oRetorno->sMessage = "O lote foi processado. Acesse o menu de consultas para verificar o status do evento.";
            } else {
                $oRetorno->sMessage = $rsApiEnvio->retornoLoteEventosAssincrono->status->descResposta;
            }
            break;
        case "getEventos2099":

            if ($oParam->status)
                $status = " and efd04_status = $oParam->status ";
            $cl_efdreinfr2099 = new cl_efdreinfr2099;
            $where = " efd04_mescompetencia = '{$oParam->mes}' and  efd04_anocompetencia = '{$oParam->ano}' and efd04_ambiente = {$oParam->ambiente} and efd04_instit = {$sInstituicao} $status ";
            $rsefdreinfr2099 = $cl_efdreinfr2099->sql_record($cl_efdreinfr2099->sql_query_file(null, "*", "efd04_sequencial desc", $where));

            for ($iCont = 0; $iCont < pg_num_rows($rsefdreinfr2099); $iCont++) {

                $oEfdreinfr2099 = db_utils::fieldsMemory($rsefdreinfr2099, $iCont);

                $clcgm = new cl_cgm;
                $rscgm = $clcgm->sql_record($clcgm->sql_query_file($oEfdreinfr2099->efd04_cgm, "z01_nome,z01_cgccpf "));
                $oCgm = db_utils::fieldsMemory($rscgm, 0);

                $cl_db_config            = new cl_db_config();
                $rsdb_config            = $cl_db_config->sql_record($cl_db_config->sql_query_file($sInstituicao, 'nomeinst'));
                $oInstituicao           = db_utils::fieldsmemory($rsdb_config, 0);

                $oefdreinfr2099      = new stdClass();
                $oefdreinfr2099->sequencial      = $oEfdreinfr2099->efd04_sequencial;
                $oefdreinfr2099->numcgm          = db_formatar($oCgm->z01_cgccpf, 'cpf') . " - " . strtoupper($oCgm->z01_nome);
                $oefdreinfr2099->mescompetencia  = $oEfdreinfr2099->efd04_mescompetencia;
                $oefdreinfr2099->anocompetencia  = $oEfdreinfr2099->efd04_anocompetencia;
                $oefdreinfr2099->tipo            = $oEfdreinfr2099->efd04_tipo == 0 ? "Fechamento" : "Abertura";
                $oefdreinfr2099->servicoprev     = searchDescricao($oEfdreinfr2099->efd04_servicoprev);
                $oefdreinfr2099->prodrural       = searchDescricao($oEfdreinfr2099->efd04_producaorural);
                $oefdreinfr2099->status          = messageStatus($oEfdreinfr2099->efd04_status);
                $oefdreinfr2099->protocolo       = $oEfdreinfr2099->efd04_protocolo;
                $oefdreinfr2099->dscResp         = $oEfdreinfr2099->efd04_dscresp;
                $oefdreinfr2099->dataenvio       = formateDate(substr($oEfdreinfr2099->efd04_dataenvio, 0, 10)) . " - " . substr($oEfdreinfr2099->efd04_dataenvio, 11, 8);

                $itens[] = $oefdreinfr2099;
            }
            $oRetorno->efdreinfr2099 = $itens;

            break;
        case "transmitirreinfR4010":

            $iUltimoDiaMes = date("d", mktime(0, 0, 0, $oParam->sMescompetencia + 1, 0, $oParam->sAnocompetencia));
            $sDataInicial = $oParam->sAnocompetencia . "-{$oParam->sMescompetencia}-01";
            $sDataFinal   = $oParam->sAnocompetencia . "-{$oParam->sMescompetencia}-{$iUltimoDiaMes}";

            $clefdreinfR4010 = new cl_efdreinfr4010;
            $rsEfdreinfR4010 = $clefdreinfR4010->sql_record($clefdreinfR4010->sql_DadosEFDReinf(11, $sDataInicial, $sDataFinal, $sInstituicao));

            $cldb_config = new cl_db_config;
            $resul = $cldb_config->sql_record($cldb_config->sql_query($sInstituicao, "cgc,z01_numcgm", "", " codigo = {$sInstituicao} "));
            db_fieldsmemory($resul, 0);

            if (pg_num_rows($rsEfdreinfR4010) > 0) {
                $oDadosReinfR4010 = db_utils::fieldsMemory($rsEfdreinfR4010, 0);
            } else {
                throw new Exception("Dados não encontrado na base.");
            }

            foreach ($oParam->aEventos as $oEventos) {

                if ($oEventos->NatRendimento > 0) {

                    $oEventos->CPFBeneficiario = substr(clean_cpf_cnpj($oEventos->CPFBeneficiario), 0, 11);
                    $oEventos->DataFG = formateDateReverse($oEventos->DataFG);
                    $clEfdReinf = new EFDReinfEventos($oEventos, $oParam, $cgc);

                    $oDados = $clEfdReinf->montarDadosReinfR4010();

                    $oCertificado = $clEfdReinf->buscarCertificado($z01_numcgm);

                    $rsApiEnvio = $clEfdReinf->emitirReinfR4010($oDados, $oCertificado);

                    $dhRecepcaoEnvio     = $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
                    $protocoloEnvio = (string) $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->protocoloEnvio;

                    sleep(5);
                    $oDados = $clEfdReinf->montarDadosReinfR4010();
                    $clEfdReinf = new EFDReinfEventos($oEventos, $oParam, $cgc);
                    $rsApiConsulta = $clEfdReinf->buscarReinfR4010($oDados, $oCertificado, $protocoloEnvio);

                    $statusConsulta         = $rsApiConsulta->retornoLoteEventosAssincrono->status->cdResposta;
                    $descRespostaConsulta   = (string) $rsApiConsulta->retornoLoteEventosAssincrono->status->descResposta;
                    $dhRecepcaoConsulta     = $rsApiConsulta->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
                    $dscRespConsulta        = (string) $rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtRet->ideRecRetorno->ideStatus->regOcorrs->dscResp;
                    $codRespConsulta        = $rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtRet->ideRecRetorno->ideStatus->regOcorrs->codResp;

                    $clefdreinfR4010 = new cl_efdreinfr4010;
                    $clefdreinfR4010->efd03_cpfbeneficiario   = substr(clean_cpf_cnpj($oEventos->CPFBeneficiario), 0, 11);
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
                    $clefdreinfR4010->efd03_dscResp            = removeAspas(utf8_decode($dscRespConsulta));
                    $clefdreinfR4010->incluir();

                    if ($clefdreinfR4010->erro_status == 0) {
                        throw new Exception($clefdreinfR4010->erro_msg);
                    }
                }
            }

            $opsErros = "";
            foreach ($oParam->aOpsErros as $oOpsErros) {
                $opsErros .= "<b>" . $oOpsErros->op . ", </b>";
            }
            if ($opsErros)
                $oRetorno->sMessageOp = "As OPs $opsErros não foram enviadas. Informe a natureza do rendimento e tente novamente.";

            if ($descRespostaConsulta) {
                $oRetorno->sMessage = "O lote foi processado. Acesse o menu de consultas para verificar o status do evento.";
            }

            break;
        case "getEventos4010":

            $sDataInicial = $oParam->sAnocompetencia . "-01-01";
            $sDataFinal   = $oParam->sAnocompetencia . "-12-31";

            $iUltimoDiaMes = date("d", mktime(0, 0, 0, $oParam->sMescompetencia + 1, 0, $oParam->sAnocompetencia));
            $sDataInicialFiltros = $oParam->sAnocompetencia . "-{$oParam->sMescompetencia}-01";
            $sDataFinalFiltros   = $oParam->sAnocompetencia . "-{$oParam->sMescompetencia}-{$iUltimoDiaMes}";

            $clefdreinfR4010 = new cl_efdreinfr4010;
            $rsEfdreinfR4010 = $clefdreinfR4010->sql_record($clefdreinfR4010->sql_DadosEFDReinf(11, $sDataInicial, $sDataFinal, $sInstituicao));

            for ($iCont = 0; $iCont < pg_num_rows($rsEfdreinfR4010); $iCont++) {

                $oEfdreinfr4010 = db_utils::fieldsMemory($rsEfdreinfR4010, $iCont);
                $oEfdreinfr4010Proximo = db_utils::fieldsMemory($rsEfdreinfR4010, $iCont + 1);

                $destacarcampos = 3;
                if ($oParam->sStatus != 3) {
                    $destacarcampos = 2;
                    $instituicao = db_getsession("DB_instit");
                    $sWhereNotas = " efd03_cpfbeneficiario = '{$oEfdreinfr4010->cpf}' and efd03_identificadorop = '{$oEfdreinfr4010->op}' and efd03_instit = {$instituicao} and efd03_ambiente = {$oParam->sAmbiente} and ( efd03_status = 2 or efd03_dscresp not like 'Não é permitido o envio de mais de um evento num mesmo período de apuração, mesmo estabelecimento%')";
                    $cldestacarcampos = new cl_efdreinfr4010;
                    $rsDestacarcampos = $cldestacarcampos->sql_record($cldestacarcampos->sql_query_file(null,"*",null,$sWhereNotas));
    
                    if (pg_num_rows($rsDestacarcampos) > 0) {
                        $destacarcampos = 1;
                    } 
                }

                if (!(($oEfdreinfr4010->cnpj == $oEfdreinfr4010Proximo->cnpj) && ($oEfdreinfr4010->op == $oEfdreinfr4010Proximo->op))) {
                    if ($oEfdreinfr4010->data_pgto >= $sDataInicialFiltros   && $oEfdreinfr4010->data_pgto <= $sDataFinalFiltros) {
                        $oefdreinfr4010 = new stdClass();
                        $oefdreinfr4010->CPFBeneficiario = db_formatar($oEfdreinfr4010->cpf, 'cpf') . " - " . removeAccents($oEfdreinfr4010->beneficiario);
                        $oefdreinfr4010->Identificador = $oEfdreinfr4010->op;
                        $oefdreinfr4010->NaturezaRendimento = $oEfdreinfr4010->natureza_rendimento ? $oEfdreinfr4010->natureza_rendimento : '';
                        $oefdreinfr4010->DataFG = formateDate($oEfdreinfr4010->data_pgto);
                        $oefdreinfr4010->ValorBruto = "R$" . db_formatar($oEfdreinfr4010->valor_bruto, 'f');
                        $oefdreinfr4010->ValorBase = $oEfdreinfr4010->valor_base == 0 ? "R$" . db_formatar($oEfdreinfr4010->valor_bruto, 'f') : "R$" . db_formatar($oEfdreinfr4010->valor_base, 'f');
                        $oefdreinfr4010->ValorIRRF = "R$" . db_formatar($oEfdreinfr4010->valor_irrf, 'f');
                        $oefdreinfr4010->DestacarCampos  = $destacarcampos;

                        $itens[] = $oefdreinfr4010;
                    }
                }
            }

            $oRetorno->efdreinfr4010 = $itens;

            break;
        case "getConsultarEvento4010":

            $status = '';
            $sCampos = "efd03_cpfbeneficiario,
                        z01_nome,
                        efd03_identificadorop,
                        efd03_naturezarendimento,
                        efd03_datafg,
                        efd03_valorbruto,
                        efd03_valorbase,
                        efd03_valorirrf,
                        efd03_protocolo,
                        efd03_dataenvio,
                        case
                            when efd03_status = 2
                            or efd03_dscresp like 'Não é permitido o envio de mais de um evento num mesmo período de apuração, mesmo estabelecimento%' then 2
                            else efd03_status
                        end as efd03_status,
                        efd03_dscresp,
                        efd03_descResposta
            "; 

            if ($oParam->sStatus) {
                $status = " and efd03_status = $oParam->sStatus ";
                if ($oParam->sStatus == "2") {
                    $status = " and ( efd03_status = 2 or efd03_dscresp like 'Não é permitido o envio de mais de um evento num mesmo período de apuração, mesmo estabelecimento%') "; 
                }
                if ($oParam->sStatus == "3") {
                    $status = " and (( efd03_status = 3 or efd03_status is null ) and efd03_dscresp not like 'Não é permitido o envio de mais de um evento num mesmo período de apuração, mesmo estabelecimento%') "; 
                }
            } 
            $instituicao = db_getsession("DB_instit");
            $sWhere = " efd03_mescompetencia = '{$oParam->sMescompetencia}' and efd03_anocompetencia = '$oParam->sAnocompetencia' and efd03_ambiente = '$oParam->sAmbiente' and efd03_instit = {$instituicao} $status  ";
            $clefdreinfR4010 = new cl_efdreinfr4010;
            $rsEfdreinfR4010 = $clefdreinfR4010->sql_record($clefdreinfR4010->sql_query_file(null, $sCampos, null, $sWhere));

            for ($iCont = 0; $iCont < pg_num_rows($rsEfdreinfR4010); $iCont++) {

                $oEfdreinfr4010 = db_utils::fieldsMemory($rsEfdreinfR4010, $iCont);

                $oefdreinfr4010 = new stdClass();
                $oefdreinfr4010->CPFBeneficiario = db_formatar($oEfdreinfr4010->efd03_cpfbeneficiario, 'cpf') . " - " . $oEfdreinfr4010->z01_nome;
                $oefdreinfr4010->Identificador = $oEfdreinfr4010->efd03_identificadorop;
                $oefdreinfr4010->NaturezaRendimento = $oEfdreinfr4010->efd03_naturezarendimento;
                $oefdreinfr4010->DataFG = formateDate($oEfdreinfr4010->efd03_datafg);
                $oefdreinfr4010->ValorBruto = "R$" . db_formatar($oEfdreinfr4010->efd03_valorbruto, 'f');
                $oefdreinfr4010->ValorBase = "R$" . db_formatar($oEfdreinfr4010->efd03_valorbase, 'f');
                $oefdreinfr4010->ValorIRRF = "R$" . db_formatar($oEfdreinfr4010->efd03_valorirrf, 'f');
                $oefdreinfr4010->Protocolo =  $oEfdreinfr4010->efd03_protocolo;
                $oefdreinfr4010->Status =  messageStatus($oEfdreinfr4010->efd03_status);
                $oefdreinfr4010->Dataenvio = formateDate(substr($oEfdreinfr4010->efd03_dataenvio, 0, 10)) . " - " . substr($oEfdreinfr4010->efd03_dataenvio, 11, 8);
                $oefdreinfr4010->MsgRetornoErro =  $oEfdreinfr4010->efd03_status ? $oEfdreinfr4010->efd03_dscresp : "Erro no envio";

                $itens[] = $oefdreinfr4010;
            }

            $oRetorno->efdreinfr4010 = $itens;

            break;
        case "transmitirreinfR4020":

                $iUltimoDiaMes = date("d", mktime(0, 0, 0, $oParam->sMescompetencia + 1, 0, $oParam->sAnocompetencia));
                $sDataInicial = $oParam->sAnocompetencia . "-{$oParam->sMescompetencia}-01";
                $sDataFinal   = $oParam->sAnocompetencia . "-{$oParam->sMescompetencia}-{$iUltimoDiaMes}";
    
                $clefdreinfR4020 = new cl_efdreinfr4020;
                $rsEfdreinfR4020 = $clefdreinfR4020->sql_record($clefdreinfR4020->sql_DadosEFDReinf(14, $sDataInicial, $sDataFinal, $sInstituicao));
    
                $cldb_config = new cl_db_config;
                $resul = $cldb_config->sql_record($cldb_config->sql_query($sInstituicao, "cgc,z01_numcgm", "", " codigo = {$sInstituicao} "));
                db_fieldsmemory($resul, 0);
    
                if (pg_num_rows($rsEfdreinfR4020) > 0) {
                    $oDadosReinfR4020 = db_utils::fieldsMemory($rsEfdreinfR4020, 0);
                } else {
                    throw new Exception("Dados não encontrado na base.");
                }
    
                foreach ($oParam->aEventos as $oEventos) {
    
                    if ($oEventos->NatRendimento > 0) {
    
                        $oEventos->CNPJBeneficiario = substr(clean_cpf_cnpj($oEventos->CNPJBeneficiario), 0, 14);
                        $oEventos->DataFG = formateDateReverse($oEventos->DataFG);
                        $clEfdReinf = new EFDReinfEventos($oEventos, $oParam, $cgc);
    
                        $oDados = $clEfdReinf->montarDadosReinfR4020();
    
                        $oCertificado = $clEfdReinf->buscarCertificado($z01_numcgm);
    
                        $rsApiEnvio = $clEfdReinf->emitirReinfR4020($oDados, $oCertificado);
    
                        $dhRecepcaoEnvio     = $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
                        $protocoloEnvio = (string) $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->protocoloEnvio;
    
                        sleep(5);
                        $oDados = $clEfdReinf->montarDadosReinfR4020();
                        $clEfdReinf = new EFDReinfEventos($oEventos, $oParam, $cgc);
                        $rsApiConsulta = $clEfdReinf->buscarReinfR4020($oDados, $oCertificado, $protocoloEnvio);
                        
                        if ($protocoloEnvio) {
                            $statusConsulta         = $rsApiConsulta->retornoLoteEventosAssincrono->status->cdResposta;
                            $descRespostaConsulta   = (string) $rsApiConsulta->retornoLoteEventosAssincrono->status->descResposta;
                            $dhRecepcaoConsulta     = $rsApiConsulta->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
                            $dscRespConsulta        = (string) $rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtRet->ideRecRetorno->ideStatus->regOcorrs->dscResp;
                            $codRespConsulta        = $rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtRet->ideRecRetorno->ideStatus->regOcorrs->codResp;
                        } else {
                            $statusConsulta         = $rsApiEnvio->retornoLoteEventosAssincrono->status->cdResposta;
                            $descRespostaConsulta   = (string) $rsApiEnvio->retornoLoteEventosAssincrono->status->descResposta;
                            $dscRespConsulta        = (string) $rsApiEnvio->retornoLoteEventosAssincrono->status->ocorrencias->ocorrencia->descricao;
                        }    
                        $clefdreinfR4020 = new cl_efdreinfr4020;
                        $clefdreinfR4020->efd02_cnpjbeneficiario   = substr(clean_cpf_cnpj($oEventos->CNPJBeneficiario), 0, 14);
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
                        $clefdreinfR4020->efd02_dscResp            =  removeAspas(utf8_decode($dscRespConsulta));
                        $clefdreinfR4020->incluir();
    
                        if ($clefdreinfR4020->erro_status == 0) {
                            throw new Exception($clefdreinfR4020->erro_msg);
                        }
                    }
                }
    
                $opsErros = "";
                foreach ($oParam->aOpsErros as $oOpsErros) {
                    $opsErros .= "<b>" . $oOpsErros->op . ", </b>";
                }
                if ($opsErros)
                    $oRetorno->sMessageOp = "As OPs $opsErros não foram enviadas. Informe a natureza do rendimento e tente novamente.";
    
                if ($descRespostaConsulta) {
                    $oRetorno->sMessage = "O lote foi processado. Acesse o menu de consultas para verificar o status do evento.";
                }
            break;
        case "getEventos4020":
    
                $sDataInicial = $oParam->sAnocompetencia . "-01-01";
                $sDataFinal   = $oParam->sAnocompetencia . "-12-31";
               
                $iUltimoDiaMes = date("d", mktime(0, 0, 0, $oParam->sMescompetencia + 1, 0, $oParam->sAnocompetencia));
                $sDataInicialFiltros = $oParam->sAnocompetencia . "-{$oParam->sMescompetencia}-01";
                $sDataFinalFiltros   = $oParam->sAnocompetencia . "-{$oParam->sMescompetencia}-{$iUltimoDiaMes}";
    
                $clefdreinfR4020 = new cl_efdreinfr4020;
                $rsEfdreinfR4020 = $clefdreinfR4020->sql_record($clefdreinfR4020->sql_DadosEFDReinf(14, $sDataInicial, $sDataFinal, $sInstituicao));
    
                for ($iCont = 0; $iCont < pg_num_rows($rsEfdreinfR4020); $iCont++) {
    
                    $oEfdreinfr4020 = db_utils::fieldsMemory($rsEfdreinfR4020, $iCont);
                    $oEfdreinfr4020Proximo = db_utils::fieldsMemory($rsEfdreinfR4020, $iCont + 1);
                    $destacarcampos = 3;
                    if ($oParam->sStatus != 3) {
                        $destacarcampos = 2;
                        $instituicao = db_getsession("DB_instit");
                        $sWhereNotas = " efd02_cnpjbeneficiario = '{$oEfdreinfr4020->cnpj}' and efd02_identificadorop = '{$oEfdreinfr4020->op}' and efd02_instit = {$instituicao} and efd02_ambiente = {$oParam->sAmbiente} and (efd02_status = 2 or efd02_dscresp like 'Não é permitido o envio de mais de um evento num mesmo período de apuração, mesmo estabelecimento%')";
                        $cldestacarcampos = new cl_efdreinfr4020;
                        $rsDestacarcampos = $cldestacarcampos->sql_record($cldestacarcampos->sql_query_file(null,"*",null,$sWhereNotas));
        
                        if (pg_num_rows($rsDestacarcampos) > 0) {
                            $destacarcampos = 1;
                        } 
                    }
                    if (!(($oEfdreinfr4020->cnpj == $oEfdreinfr4020Proximo->cnpj) && ($oEfdreinfr4020->op == $oEfdreinfr4020Proximo->op))) {
                        if ($oEfdreinfr4020->data_pgto >= $sDataInicialFiltros   && $oEfdreinfr4020->data_pgto <= $sDataFinalFiltros) {
                            $oefdreinfr4020 = new stdClass();
                            $oefdreinfr4020->CNPJBeneficiario = db_formatar($oEfdreinfr4020->cnpj, 'cnpj') . " - " . removeAccents($oEfdreinfr4020->beneficiario);
                            $oefdreinfr4020->Identificador = $oEfdreinfr4020->op;
                            $oefdreinfr4020->NaturezaRendimento = $oEfdreinfr4020->natureza_rendimento ? $oEfdreinfr4020->natureza_rendimento : '';
                            $oefdreinfr4020->DataFG = formateDate($oEfdreinfr4020->data_pgto);
                            $oefdreinfr4020->ValorBruto = "R$" . db_formatar($oEfdreinfr4020->valor_bruto, 'f');
                            $oefdreinfr4020->ValorBase = $oEfdreinfr4020->valor_base == 0 ? "R$" . db_formatar($oEfdreinfr4020->valor_bruto, 'f') : "R$" . db_formatar($oEfdreinfr4020->valor_base, 'f');
                            $oefdreinfr4020->ValorIRRF = "R$" . db_formatar($oEfdreinfr4020->valor_irrf, 'f');
                            $oefdreinfr4020->DestacarCampos  = $destacarcampos;
    
                            $itens[] = $oefdreinfr4020;
                        }
                    }
                }
    
                $oRetorno->efdreinfr4020 = $itens;
    
            break;
        case "getConsultarEvento4020":

                $status = '';
                $sCampos = "efd02_cnpjbeneficiario,
                z01_nome,
                efd02_identificadorop,
                efd02_naturezarendimento,
                efd02_datafg,
                efd02_valorbruto,
                efd02_valorbase,
                efd02_valorirrf,
                efd02_protocolo,
                efd02_dataenvio,
                case
                    when efd02_status = 2
                    or efd02_dscresp like 'Não é permitido o envio de mais de um evento num mesmo período de apuração, mesmo estabelecimento%' then 2
                    else efd02_status
                end as efd02_status,
                efd02_dscresp,
                efd02_descResposta
            "; 
                if ($oParam->sStatus) {
                    $status = " and efd02_status = $oParam->sStatus ";
                    if ($oParam->sStatus == "2") {
                        $status = " and ( efd02_status = 2 or efd02_dscresp like 'Não é permitido o envio de mais de um evento num mesmo período de apuração, mesmo estabelecimento%') "; 
                    }
                    if ($oParam->sStatus == "3") {
                        $status = " and ( ( efd02_status = 3 or efd02_status is null ) and efd02_dscresp not like 'Não é permitido o envio de mais de um evento num mesmo período de apuração, mesmo estabelecimento%') "; 
                    }
                } 
                $instituicao = db_getsession("DB_instit");
                $sWhere = " efd02_mescompetencia = '{$oParam->sMescompetencia}' and efd02_anocompetencia = '$oParam->sAnocompetencia' and efd02_ambiente = '$oParam->sAmbiente' and efd02_instit = {$instituicao} $status  ";
                $clefdreinfR4020 = new cl_efdreinfr4020;
                $rsEfdreinfR4020 = $clefdreinfR4020->sql_record($clefdreinfR4020->sql_query_file(null, $sCampos, null, $sWhere));
                for ($iCont = 0; $iCont < pg_num_rows($rsEfdreinfR4020); $iCont++) {
    
                    $oEfdreinfr4020 = db_utils::fieldsMemory($rsEfdreinfR4020, $iCont);
                    $oefdreinfr4020 = new stdClass();
                    $oefdreinfr4020->CNPJBeneficiario = db_formatar($oEfdreinfr4020->efd02_cnpjbeneficiario, 'cnpj') . " - " . $oEfdreinfr4020->z01_nome;
                    $oefdreinfr4020->Identificador = $oEfdreinfr4020->efd02_identificadorop;
                    $oefdreinfr4020->NaturezaRendimento = $oEfdreinfr4020->efd02_naturezarendimento;
                    $oefdreinfr4020->DataFG = formateDate($oEfdreinfr4020->efd02_datafg);
                    $oefdreinfr4020->ValorBruto = "R$" . db_formatar($oEfdreinfr4020->efd02_valorbruto, 'f');
                    $oefdreinfr4020->ValorBase = "R$" . db_formatar($oEfdreinfr4020->efd02_valorbase, 'f');
                    $oefdreinfr4020->ValorIRRF = "R$" . db_formatar($oEfdreinfr4020->efd02_valorirrf, 'f');
                    $oefdreinfr4020->Protocolo =  $oEfdreinfr4020->efd02_protocolo;
                    $oefdreinfr4020->Status =  messageStatus($oEfdreinfr4020->efd02_status);
                    $oefdreinfr4020->Dataenvio =  formateDate(substr($oEfdreinfr4020->efd02_dataenvio, 0, 10)) . " - " . substr($oEfdreinfr4020->efd02_dataenvio, 11, 8);
                    $oefdreinfr4020->MsgRetornoErro =  $oEfdreinfr4020->efd02_status ?  $oEfdreinfr4020->efd02_dscresp : "Erro no envio";
                    $itens[] = $oefdreinfr4020;
                }
    
                $oRetorno->efdreinfr4020 = $itens;
    
            break;
        case "transmitirreinf4099":

                $oDaoCgm        = db_utils::getDao("cgm");
                $rsDadosCgm    = $oDaoCgm->sql_record($oDaoCgm->sql_query($oParam->sCgm));
    
                $cldb_config = new cl_db_config;
    
                if (pg_num_rows($rsDadosCgm) > 0) {
                    $oDadosCgm = db_utils::fieldsMemory($rsDadosCgm, 0);
    
                    if ($oDadosCgm->z01_telef == null || $oDadosCgm->z01_telef == '' || strlen($oDadosCgm->z01_telef) < 10) {
                        $oRetorno->sMessage = "Telefone do Responsável inválido! Informe o número do telefone com DDD.";
                        $oRetorno->erro = $oRetorno->iStatus == 2;
                        break;
                    }
    
                    if ($oDadosCgm->z01_email == null || $oDadosCgm->z01_email == '') {
                        $oRetorno->sMessage = "Email do Responsável inválido!.";
                        $oRetorno->erro = $oRetorno->iStatus == 2;
                        break;
                    }
                }
    
                $resul = $cldb_config->sql_record($cldb_config->sql_query($sInstituicao, "cgc,z01_numcgm", "", " codigo = {$sInstituicao} "));
                db_fieldsmemory($resul, 0);
    
                $clefdreinfR4099 = new cl_efdreinfr4099;
                $clefdreinfR4099->efd01_mescompetencia = $oParam->sMescompetencia;
                $clefdreinfR4099->efd01_anocompetencia = $oParam->sAnocompetencia;
                $clefdreinfR4099->efd01_tipo           = $oParam->sTipo;
                $clefdreinfR4099->efd01_ambiente       = $oParam->sAmbiente;
                $clefdreinfR4099->efd01_cgm            = $oParam->sCgm;
                $clefdreinfR4099->efd01_instit         = $sInstituicao;
    
                $oDadosCgm->z01_nome = removeAccents($oDadosCgm->z01_nome);
                $clEfdReinf = new EFDReinfEventos($clefdreinfR4099, $oDadosCgm, $cgc);
    
                $oDados = $clEfdReinf->montarDadosReinfR4099();
    
                $oCertificado = $clEfdReinf->buscarCertificado($z01_numcgm);
    
                $rsApiEnvio = $clEfdReinf->emitirReinfR4099($oDados, $oCertificado);
                $dhRecepcaoEnvio     = $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
                $protocoloEnvio = (string) $rsApiEnvio->retornoLoteEventosAssincrono->dadosRecepcaoLote->protocoloEnvio;
    
                sleep(5);
                $clEfdReinf = new EFDReinfEventos($clefdreinfR4099, $oDadosCgm, $cgc);
                $oDados = $clEfdReinf->montarDadosReinfR4099();
                $rsApiConsulta = $clEfdReinf->buscarReinfR4099($oDados, $oCertificado, $protocoloEnvio);
    
                if ($protocoloEnvio) {
                    $statusConsulta         = $rsApiConsulta->retornoLoteEventosAssincrono->status->cdResposta;
                    $descRespostaConsulta   = (string) $rsApiConsulta->retornoLoteEventosAssincrono->status->descResposta;
                    $dhRecepcaoConsulta     = $rsApiConsulta->retornoLoteEventosAssincrono->dadosRecepcaoLote->dhRecepcao;
                    $dscRespConsulta        = (string) $rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtRetCons->ideRecRetorno->ideStatus->regOcorrs->dscResp;
                    $codRespConsulta        = $rsApiConsulta->retornoLoteEventosAssincrono->retornoEventos->evento->retornoEvento->Reinf->evtRetCons->ideRecRetorno->ideStatus->regOcorrs->codResp;
                } else {
                    $statusConsulta         = $rsApiEnvio->retornoLoteEventosAssincrono->status->cdResposta;
                    $descRespostaConsulta   = (string) $rsApiEnvio->retornoLoteEventosAssincrono->status->descResposta;
                    $dscRespConsulta        = (string) $rsApiEnvio->retornoLoteEventosAssincrono->status->ocorrencias->ocorrencia->descricao;
                }

                $clefdreinfR4099->efd01_protocolo    = $protocoloEnvio;
                $clefdreinfR4099->efd01_status       = $statusConsulta;
                $clefdreinfR4099->efd01_descResposta = utf8_decode($descRespostaConsulta);
                $clefdreinfR4099->efd01_dscResp      = removeAspas(utf8_decode($dscRespConsulta));
                $clefdreinfR4099->efd01_dataenvio    = $dhRecepcaoEnvio;
                $clefdreinfR4099->incluir();
                if ($clefdreinfR4099->erro_status == 0) {
                    throw new Exception($clefdreinfR4099->erro_msg);
                }
    
                if ($descRespostaConsulta) {
                    $oRetorno->sMessage = "O lote foi processado. Acesse o menu de consultas para verificar o status do evento.";
                } else {
                    $oRetorno->sMessage = $rsApiEnvio;
                }
            break;
        case "getEventos4099":
    
                if ($oParam->status)
                    $status = " and efd01_status = $oParam->status ";
                $cl_efdreinfr4099 = new cl_efdreinfr4099;
                $where = " efd01_mescompetencia = '{$oParam->mes}' and  efd01_anocompetencia = '{$oParam->ano}' and efd01_ambiente = {$oParam->ambiente} and efd01_instit = {$sInstituicao} $status ";
                $rsefdreinfr4099 = $cl_efdreinfr4099->sql_record($cl_efdreinfr4099->sql_query_file(null, "*", "efd01_sequencial desc", $where));
    
                for ($iCont = 0; $iCont < pg_num_rows($rsefdreinfr4099); $iCont++) {
    
                    $oEfdreinfr4099 = db_utils::fieldsMemory($rsefdreinfr4099, $iCont);
    
                    $clcgm = new cl_cgm;
                    $rscgm = $clcgm->sql_record($clcgm->sql_query_file($oEfdreinfr4099->efd01_cgm, "z01_nome "));
                    $oCgm = db_utils::fieldsMemory($rscgm, 0);
    
                    $cl_db_config            = new cl_db_config();
                    $rsdb_config            = $cl_db_config->sql_record($cl_db_config->sql_query_file($sInstituicao, 'nomeinst'));
                    $oInstituicao           = db_utils::fieldsmemory($rsdb_config, 0);
    
                    $oefdreinfr4099      = new stdClass();
                    $oefdreinfr4099->sequencial      = $oEfdreinfr4099->efd01_sequencial;
                    $oefdreinfr4099->numcgm          = $oEfdreinfr4099->efd01_cgm . " - " . strtoupper($oCgm->z01_nome);
                    $oefdreinfr4099->mescompetencia  = $oEfdreinfr4099->efd01_mescompetencia;
                    $oefdreinfr4099->anocompetencia  = $oEfdreinfr4099->efd01_anocompetencia;
                    $oefdreinfr4099->tipo            = $oEfdreinfr4099->efd01_tipo == 0 ? "Fechamento" : "Abertura";
                    $oefdreinfr4099->status          = messageStatus($oEfdreinfr4099->efd01_status);
                    $oefdreinfr4099->protocolo       = $oEfdreinfr4099->efd01_protocolo;
                    $oefdreinfr4099->dscResp         = $oEfdreinfr4099->efd01_dscresp;
                    $oefdreinfr4099->dataenvio       = formateDate(substr($oEfdreinfr4099->efd01_dataenvio, 0, 10)) . " - " . substr($oEfdreinfr4099->efd01_dataenvio, 11, 8);
    
                    $itens[] = $oefdreinfr4099;
                }
                $oRetorno->efdreinfr4099 = $itens;
    
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
function clean_cpf_cnpj($valor)
{
    $valor = trim($valor);
    $valor = str_replace(array('.', '-', '/'), "", $valor);
    return $valor;
}
function tranformarFloat($numero)
{
    $numero = str_replace(".", "", $numero);
    $numero = str_replace(",", ".", $numero);
    $numero_float = (float) $numero;
    return $numero_float;
}
function removeAccents($str)
{
    $acentosMap = array(
        'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'ä' => 'a', 'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
        'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i', 'ó' => 'o', 'ò' => 'o', 'õ' => 'o', 'ô' => 'o', 'ö' => 'o',
        'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u', 'ç' => 'c', 'Á' => 'A', 'À' => 'A', 'Ã' => 'A', 'Â' => 'A',
        'Ä' => 'A', 'É' => 'E', 'È' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Í' => 'I', 'Ì' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ó' => 'O', 'Ò' => 'O', 'Õ' => 'O', 'Ô' => 'O', 'Ö' => 'O', 'Ú' => 'U', 'Ù' => 'U', 'Û' => 'U', 'Ü' => 'U',
        'Ç' => 'C', '&' => 'e',"'"  => ''
    );
    return strtr($str, $acentosMap);
}
function removeAspas($str)
{
    $acentosMap = array(
        "'"  => ''
    );
    return strtr($str, $acentosMap);
}
function messageStatus($status)
{
    switch ($status) {
        case 1:
            return "EM PROCESSAMENTO";
            break;
        case 2:
            return "ENVIADO";
            break;
        case 3:
            return "ERRO NO ENVIO";
            break;
        case 8:
            return "ERRO NA CONSULTA ";
            break;
        case 9:
            return "ERRO NA CONSULTA";
            break;
        case 99:
            return "ERRO NO ENVIO";
            break;
        default:
            return "ERRO NO ENVIO";
            break;
    }
}
function searchCgm($valor)
{
    $valor = explode("-", $valor);
    return $valor[2];
}
function searchObras($status)
{
    switch ($status) {
        case 0:
            return "0 - Não é obra de construção civil ou não está sujeita a matrícula de obra";
            break;
        case 1:
            return "1 - É obra de construção civil, modalidade empreitada total";
            break;
        case 2:
            return "2 - É obra de construção civil, modalidade empreitada parcial";
            break;
    }    
}
function searchIndAquisicao($status)
{
    switch ($status) {
        case 0:
            return "0 - Não se aplica";
            break;
        case 1:
            return "1 - Aquisição de produção de produtor rural pessoa física ou segurado especial em geral";
            break;
        case 2:
            return "2 - Aquisição de produção de produtor rural pessoa física ou segurado especial em geral por entidade executora do Programa de Aquisição de Alimentos PAA";
            break;
        case 3:
            return "3 - Aquisição de produção de produtor rural pessoa jurídica por entidade executora do PAA";
            break;
        case 4:
            return "4 - Aquisição de produção de produtor rural pessoa física ou segurado especial em geral Produção isenta (Lei 13.606/2018)";
            break;
        case 5:
            return "5 - Aquisição de produção de produtor rural pessoa física ou segurado especial em geral por entidade executora do PAA Produção isenta (Lei 13.606/2018)";
            break;
        case 6:
            return "6 - Aquisição de produção de produtor rural pessoa jurídica por entidade executora do PAA Produção isenta (Lei 13.606/2018)";
            break;
        case 7:
            return "7 - Aquisição de produção de produtor rural pessoa física ou segurado especial para fins de exportação";
            break;        
    
        } 
}
function searchDescricao($descricao)
{
    switch ($descricao) {
        case 1:
            return "SIM";
        case 2:
            return "NÃO";
        case '100000001':
            return '100000001 - Limpeza, conservação ou zeladoria';
        case '100000002':
            return '100000002 - Vigilância ou segurança';
        case '100000003':
            return '100000003 - Construção civil';
        case '100000004':
            return '100000004 - Serviços de natureza rural';
        case '100000005':
            return '100000005 - Digitação';
        case '100000006':
            return '100000006 - Preparação de dados para processamento';
        case '100000007':
            return '100000007 - Acabamento';
        case '100000008':
            return '100000008 - Embalagem';
        case '100000009':
            return '100000009 - Acondicionamento';
        case '100000010':
            return '100000010 - Cobrança';
        case '100000011':
            return '100000011 - Coleta ou reciclagem de lixo ou de resíduos';
        case '100000012':
            return '100000012 - Copa';
        case '100000013':
            return '100000013 - Hotelaria';
        case '100000014':
            return '100000014 - Corte ou ligação de serviços públicos';
        case '100000015':
            return '100000015 - Distribuição';
        case '100000016':
            return '100000016 - Treinamento e ensino';
        case '100000017':
            return '100000017 - Entrega de contas e de documentos';
        case '100000018':
            return '100000018 - Ligação de medidores';
        case '100000019':
            return '100000019 - Leitura de medidores';
        case '100000020':
            return '100000020 - Manutenção de instalações, de máquinas ou de equipamentos';
        case '100000021':
            return '100000021 - Montagem';
        case '100000022':
            return '100000022 - Operação de máquinas, de equipamentos e de veículos';
        case '100000023':
            return '100000023 - Operação de pedágio ou de terminal de transporte';
        case '100000024':
            return '100000024 - Operação de transporte de passageiros';
        case '100000025':
            return '100000025 - Portaria, recepção ou ascensorista';
        case '100000026':
            return '100000026 - Recepção, triagem ou movimentação de materiais';
        case '100000027':
            return '100000027 - Promoção de vendas ou de eventos';
        case '100000028':
            return '100000028 - Secretaria e expediente';
        case '100000029':
            return '100000029 - Saúde';
        case '100000030':
            return '100000030 - Telefonia ou telemarketing';
        case '100000031':
            return '100000031 - Trabalho temporário na forma da Lei nº 6.019, de janeiro de 1974';
    }
}
$oRetorno->erro = $oRetorno->iStatus == 2;
echo JSON::create()->stringify($oRetorno);
