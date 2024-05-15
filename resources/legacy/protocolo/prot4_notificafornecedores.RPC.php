<?php

require_once("classes/db_nfaberturaprocesso_classe.php");
require_once("classes/db_nfprevisaopagamento_classe.php");
require_once("classes/db_nfpagamentorealizado_classe.php");
require_once("classes/db_protprocesso_classe.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/JSON.php");
require_once("model/PHPMailer.php");
require_once("std/db_stdClass.php");
require_once("std/DBDate.php");

//error_reporting(E_ALL);
//error_reporting(E_STRICT);
date_default_timezone_set('America/Sao_Paulo');

db_postmemory($_POST);

$protprocesso = new cl_protprocesso();
$email        = new PHPMailer();

$oJson  = new services_json();
$oParam = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$data = date("Y-m-d");
$instit = db_getsession('DB_instit');


switch ($oParam->exec) {

    case 'buscarInformacoes':

        $campos = "p58_codproc,cast(p58_numero||'/'||p58_ano AS varchar) AS p58_numero,z01_numcgm AS p58_numcgm,z01_nome";

        switch ($oParam->aba) {
            case 'geral':
                $sSQLF = $protprocesso->sql_query(null, $campos, "p58_codproc DESC", "p58_instit = $instit AND p58_codproc IN ({$oParam->aCodFornec})");
                $sSQLTN = "select p110_sequencial, p110_vinculonotificacao, p110_tipo from tiposnotificacao order by p110_sequencial";
                break;

            case 'aberturaprocesso':
                $campos .= ",p111_nfe,p111_sequencial";
                $sSQLF = $protprocesso->sql_query_abertura_processo(null, $campos, "p111_dataenvio DESC", "p58_instit = $instit AND p111_sequencial IN ({$oParam->aCodAberturaProcesso})");
                $sSQLTN = "select p110_sequencial, p110_vinculonotificacao, p110_tipo from tiposnotificacao where coalesce(p110_vinculonotificacao,0) not in (1) order by p110_sequencial";
                break;

            case 'previsaopagamento':
                $campos .= ",p112_nfe,to_char(p112_dataliquidacao,'DD/MM/YYYY') p112_dataliquidacao,to_char(p112_dataprevisao,'DD/MM/YYYY') p112_dataprevisao,p112_sequencial";
                $sSQLF = $protprocesso->sql_query_previsao_pagamento(null, $campos, "p112_dataenvio DESC", "p58_instit = $instit AND p112_sequencial IN ({$oParam->aCodPrevisaoPagamento})");
                $sSQLTN = "select p110_sequencial, p110_vinculonotificacao, p110_tipo from tiposnotificacao where coalesce(p110_vinculonotificacao,0) not in (1,2) order by p110_sequencial";
                break;
        }

        $rsResultF              = db_query($sSQLF);
        $oRetorno->fornecedores = db_utils::getCollectionByRecord($rsResultF);

        $rsResultTN                 = db_query($sSQLTN);
        $oRetorno->tiposnotificacao = db_utils::getCollectionByRecord($rsResultTN);

        break;

    case 'enviarEmail':

        try {

            $sFornecedoresErroEmail = "";
            $sFornecErroEmailInsert = array();
            $sMsgErroFornec = "\n Verificar configuração no cadastro de fornecedores.\n Operação Abortada.\n";
            foreach ($oParam->fornecedores as $fornecedor) {
                $sSQLF = "select z01_email, z01_notificaemail from cgm where z01_numcgm = $fornecedor->numcgm";
                $rsResultF = db_query($sSQLF);
                $notificaemail = db_utils::fieldsMemory($rsResultF, 0);

                if (empty($notificaemail->z01_notificaemail)) {
                    throw new Exception("Fornecedor $fornecedor->numcgm não está habilitado para notificação.$sMsgErroFornec");
                }

                if (empty($notificaemail->z01_email)) {
                    throw new Exception("Fornecedor $fornecedor->numcgm não possui e-mail cadastrado.$sMsgErroFornec");
                }
            }

            $email->SMTPDebug = 0;
            $email->SetLanguage("br");
            $email->IsHTML(true);
            $email->IsSMTP();

            $email->Host = "smtp.gmail.com";
            $email->Port = 465;
            $email->SMTPAuth = true;
            $email->SMTPSecure = 'tls';

            $email->Username = 'sistemaecidade@cmbh.mg.gov.br';
            $email->Password = '$Ecid%6548';

            $email->From = "divgef.notafiscal@cmbh.mg.gov.br";
            $email->FromName = "SECCEO";

            $replace = array('{$protocolo}', '{$nfe}', '{$dataliquidacao}', '{$dataprevisao}', '{$numpagamento}');

            foreach ($oParam->fornecedores as $fornecedor) {

                if (isset($fornecedor->codproc_p111)) {
                    $codigos = explode("-", $fornecedor->codproc_p111);
                    $codproc = $codigos[0];
                    $p111_sequencial = $codigos[1];
                } else if (isset($fornecedor->codproc_p112)) {
                    $codigos = explode("-", $fornecedor->codproc_p112);
                    $codproc = $codigos[0];
                    $p112_sequencial = $codigos[1];
                } else {
                    $codproc = $fornecedor->codproc;
                }
                $protocolo = $fornecedor->protocolo;
                $nfe       = $fornecedor->nfe;
                $dataliquidacao = implode("-", array_reverse(explode("/", $fornecedor->dataliquidacao)));
                $dataprevisao   = implode("-", array_reverse(explode("/", $fornecedor->dataprevisao)));
                $numpagamento   = $fornecedor->numpagamento;
                $numcgm         = $fornecedor->numcgm;
                $newdados = array($protocolo, $nfe, $fornecedor->dataliquidacao, $fornecedor->dataprevisao, $numpagamento);

                $rsEmail = db_query("select z01_email from cgm where z01_numcgm = $numcgm");
                $aEmail  = db_utils::fieldsMemory($rsEmail, 0);
                $email->AddAddress($aEmail->z01_email);

                $sSQLTN     = "select p110_tipo, p110_textoemail, p110_vinculonotificacao from tiposnotificacao where p110_sequencial = {$fornecedor->p110_sequencial}";
                $rsResultTN = db_query($sSQLTN);
                $tiponotificacao = db_utils::fieldsMemory($rsResultTN, 0);
                $email->Subject  = $tiponotificacao->p110_tipo;
                $email->Body     = str_replace($replace, $newdados, $tiponotificacao->p110_textoemail);

                $enviado = $email->Send();

                $email->ClearAllRecipients();

                if (!$enviado) {
                    $sFornecedoresErroEmail += "Ocorreu um ao enviar email para o fornecedor {$numcgm}, protocolo {$protocolo}\n\n" . $email->ErrorInfo;
                } else {
                    switch ($tiponotificacao->p110_vinculonotificacao) {
                        case '1':

                            $nfaberturaprocesso = new cl_nfaberturaprocesso();
                            $nfaberturaprocesso->p111_codproc = $codproc;
                            $nfaberturaprocesso->p111_nfe     = $nfe;
                            $nfaberturaprocesso->p111_dataenvio = date('Y-m-d');
                            $nfaberturaprocesso->incluir(null);

                            if ($nfaberturaprocesso->erro_status != 1) {
                                $sFornecErroEmailInsert += array($numcgm => $protocolo);
                                $erroSQL .= "\n$nfpagamentorealizado->erro_sql";
                            }

                            unset($nfaberturaprocesso);

                            break;

                        case '2':

                            $nfprevisaopagamento  = new cl_nfprevisaopagamento();
                            $nfprevisaopagamento->p112_codproc            = $codproc;
                            $nfprevisaopagamento->p112_nfe                = $nfe;
                            $nfprevisaopagamento->p112_dataliquidacao     = $dataliquidacao;
                            $nfprevisaopagamento->p112_dataprevisao       = $dataprevisao;
                            $nfprevisaopagamento->p112_nfgeral            = empty($p111_sequencial) ? "t" : "f";
                            $nfprevisaopagamento->p112_nfaberturaprocesso = empty($p111_sequencial) ? "" : $p111_sequencial;
                            $nfprevisaopagamento->p112_dataenvio          = date('Y-m-d');
                            $nfprevisaopagamento->incluir(null);

                            if ($nfprevisaopagamento->erro_status != 1) {
                                $sFornecErroEmailInsert += array($numcgm => $protocolo);
                            }

                            unset($nfprevisaopagamento);

                            break;

                        case '3':

                            $nfpagamentorealizado = new cl_nfpagamentorealizado();
                            $nfpagamentorealizado->p113_codproc             = $codproc;
                            $nfpagamentorealizado->p113_nfe                 = $nfe;
                            $nfpagamentorealizado->p113_numpagamento        = $numpagamento;
                            $nfpagamentorealizado->p113_nfgeral             = empty($p112_sequencial) ? "t" : "f";
                            $nfpagamentorealizado->p113_nfaberturaprocesso  = empty($p111_sequencial) ? "" : $p111_sequencial;
                            $nfpagamentorealizado->p113_nfprevisaopagamento = empty($p112_sequencial) ? "" : $p112_sequencial;
                            $nfpagamentorealizado->p113_dataenvio           = date('Y-m-d');
                            $nfpagamentorealizado->incluir(null);

                            if ($nfpagamentorealizado->erro_status != 1) {
                                $sFornecErroEmailInsert += array($numcgm => $protocolo);
                            }

                            unset($nfpagamentorealizado);

                            break;
                    }
                }
            }
            if (!empty($sFornecedoresErroEmail)) {
                throw new Exception($sFornecedoresErroEmail);
            }

            if (!empty($sFornecErroEmailInsert)) {
                $aErrorinsert = implode(", ", $sFornecErroEmailInsert);
                throw new Exception("Fornecedor(es) notificado(s) com sucesso.\n Porém ocorreu um erro ao salvar os dados do(s) processo(s) para o(s) protocolo(s): $aErrorinsert .\n Os demais processos foram salvos com sucesso.{$erroSQL}"); //$email->ErrorInfo
            }
        } catch (Exception $e) {
            $oRetorno->erro   = $e->getMessage();
            $oRetorno->status = 2;
        }

        break;
}

// Fim Funções

if (isset($oRetorno->erro)) {
    $oRetorno->erro = utf8_encode($oRetorno->erro);
}

for ($i = 0; $i < count($oRetorno->tiposnotificacao); $i++) {
    $oRetorno->tiposnotificacao[$i]->p110_tipo = htmlentities($oRetorno->tiposnotificacao[$i]->p110_tipo, UTF - 8);
}

echo $oJson->encode($oRetorno);
