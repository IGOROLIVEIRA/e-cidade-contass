<?php
//ini_set('display_errors','on');

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
require_once("classes/db_db_usuarios_classe.php");
require_once("classes/db_db_sysarquivo_classe.php");

$oJson             = new services_json();
$oParam           = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
switch($oParam->exec) {

    case 'getLogs':

        $where = "";

        //manut_tabela
        if(isset($oParam->table)){
            $where .= "manut_tabela = $oParam->table ";
        }

        //manut_timestamp inicio
        if($oParam->periodoinicio != ""){
            $timestamp = strtotime(implode("-",(array_reverse(explode("/", $oParam->periodoinicio)))));
            $where .= "and manut_timestamp >= $timestamp ";
        }

        //manut_timestamp fim
        if($oParam->periodofim != ""){
            $timestamp = strtotime(implode("-",(array_reverse(explode("/", $oParam->periodofim)))));
            $where .= "and manut_timestamp <= $timestamp ";
        }

        //manut_tipo
        if(isset($oParam->tipo)){
            if($oParam->tipo == "0"){
                $where .= "and manut_tipo in (1,2,3)";
            }elseif ($oParam->tipo == "1"){
                $where .= "and manut_tipo in (1) ";
            }elseif ($oParam->tipo == "2"){
                $where .= "and manut_tipo in (2) ";
            }elseif ($oParam->tipo == "3"){
                $where .= "and manut_tipo in (3) ";
            }
        }

        //manut_descricao
        if(isset($oParam->descricao)){
            $where .= " and manut_descricao like '%$oParam->descricao%'";
        }

        $sqlLogs = "select * from db_manut_log where $where";

        $rsResultLogs = db_query($sqlLogs);

        $aLogsistema = array();
        for ($iLogs = 0; $iLogs < pg_num_rows($rsResultLogs); $iLogs++) {
            $aLogsistema[] = db_utils::fieldsMemory($rsResultLogs, $iLogs);
        }

        $arrayLogs = array();
        foreach ($aLogsistema as $log){

            //busco nome do usuario
            $clusuarios = new cl_db_usuarios();

            $sqlUsuario = $clusuarios->sql_query($log->manut_id_usuario);
            $rsUsuario = $clusuarios->sql_record($sqlUsuario);
            db_fieldsmemory($rsUsuario,0);

            //busco tabela
            $clsysarquivo = new cl_db_sysarquivo();
            $sqlTabel = $clsysarquivo->sql_query($log->manut_tabela);
            $rsTabela = $clsysarquivo->sql_record($sqlTabel);
            db_fieldsmemory($rsTabela,0);

            $objLog = new stdClass();
            $objLog->manut_sequencial = $log->manut_sequencial;
            $objLog->manut_descricao  = urlencode($log->manut_descricao);
            $objLog->manut_date       = implode("/",(array_reverse(explode("-",date("Y-m-d", $log->manut_timestamp)))));
            $objLog->manut_hora       = date("H:i:s", $log->manut_timestamp);
            $objLog->manut_usuario    = $login;
            $objLog->manut_tabela     = $nomearq;

            if($log->manut_tipo == "1") {
                $objLog->manut_tipo   = urlencode("Inclusão");
            } elseif($log->manut_tipo == "2") {
                $objLog->manut_tipo   = urlencode("Alteração");
            } else {
                $objLog->manut_tipo   = urlencode("Exclusão");
            }

            $arrayLogs[] = $objLog;
        }

        $oRetorno->logs = $arrayLogs;

        break;
}
echo json_encode($oRetorno);