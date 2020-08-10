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

$oJson             = new services_json();
$oParam           = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
switch($oParam->exec) {

    case 'getLogs':
//        echo "<pre>";
//        var_dump($oParam);
//        exit;
        $where = "";

        //manut_tabela
        if(isset($oParam->table)){
            $where .= "manut_tabela = $oParam->table ";
        }

        //manut_timestamp
        if(isset($oParam->periodo)){
            $where .= "and manut_timestamp = $oParam->periodo ";
        }

        //manut_tipo
        if(isset($oParam->tipo)){
            $where .= "and manut_tipo = $oParam->tipo ";
        }

        //manut_descricao
//        if(isset($oParam->descricao)){
//            $where .= "and manut_descricao = like '%$oParam->descricao ";
//        }

        $sqlLogs = "select * from db_manut_log where $where";
        $rsResultLogs = db_query($sqlLogs);

        $aLogsistema = array();
        for ($iLogs = 0; $iLogs < pg_num_rows($rsResultLogs); $iLogs++) {
            $aLogsistema[] = db_utils::fieldsMemory($rsResultLogs, $iLogs);
        }

        $arrayLogs = array();
        foreach ($aLogsistema as $log){
            $objLog = new stdClass();
            $objLog->manut_sequencial = $log->manut_sequencial;
            $objLog->manut_descricao  = $log->manut_descricao;
            $objLog->manut_date       = implode("/",(array_reverse(explode("-",date("Y-m-d", $log->manut_timestamp)))));
            $objLog->manut_hora       = date("H:i:s", $log->manut_timestamp);
            $objLog->manut_tabela     = $log->manut_tabela;
            $objLog->manut_tipo       = $log->manut_tipo;

            $arrayLogs[] = $objLog;
        }

        $oRetorno->logs = $arrayLogs;

        break;
}
echo json_encode($oRetorno);