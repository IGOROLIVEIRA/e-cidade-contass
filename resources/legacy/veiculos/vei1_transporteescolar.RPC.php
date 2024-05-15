<?php
require_once("std/db_stdClass.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");

require_once("libs/JSON.php");//RPC
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");

$oJSON = new Services_JSON();

$oParametros = $oJSON->decode( str_replace("\\", "", $_POST["json"]) );

$oRetorno            = new stdClass();
$oRetorno->lErro     = false;
$oRetorno->sMensagem = ""; 
try {

  switch ($oParametros->sMetodo) {
     
     case "getDistancia":

       /*$sSql = "select ve61_medidadevol - ve60_medidasaida as distancia 
                from veicdevolucao join veicretirada on ve61_veicretirada = ve60_codigo 
                where ve60_datasaida >= '".implode("-", array_reverse(explode("/", $oParametros->dtini)))."' 
                and ve61_datadevol <= '".implode("-", array_reverse(explode("/", $oParametros->dtfim)))."'";
       echo $sSql;exit;
       $rsCalculo                 = db_query($sSql);
       $iDistancia                = db_utils::fieldsMemory($rsCalculo, 0)->distancia;
       

       $oTransporte = new cl_transporteescolar();
       $oTransporte->getRetirada();
        
       $oRetorno->iDistancia      = $iDistancia;*/

     break ;

     case "get":
     //  echo "OPAAA";
     break ;

     default:
       throw new Exception("Método Inválido");
     break;
  }
} catch ( Exception $oException ) {

  $oRetorno->lErro     = true;
  $oRetorno->sMensagem = urlencode($oException->getMessage());
}


echo $oJSON->encode($oRetorno);