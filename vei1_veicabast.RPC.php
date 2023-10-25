<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
require_once("libs/JSON.php");
require_once("classes/db_empempenho_classe.php");
require_once("classes/db_veicparam_classe.php");
require_once("classes/db_empveiculos_classe.php");

db_postmemory($_POST);

$clempempenho = new cl_empempenho;
$clveicparam  = new cl_veicparam;
$clempveiculos = new cl_empveiculos;

$oJson = new services_json();
$oParametros = json_decode(str_replace('\\', '', $_POST["json"]));

$oRetorno            = new stdClass();
$oRetorno->lErro     = false;
$oRetorno->sMensagem = ""; 

try {

  switch ($oParametros->sMetodo) {
     
     case "validacaoAbastecimentoPorEmpenho":

      $rsVeicparam = $clveicparam->sql_record($clveicparam->sql_query_file(null, "*", null, "ve50_instit = " . db_getsession("DB_instit")));
      $ve50_abastempenho = db_utils::fieldsMemory($rsVeicparam, 0)->ve50_abastempenho;

      if($ve50_abastempenho == 1){

        $e60_numemp = isset($oParametros->e60_numemp) ? $oParametros->e60_numemp : "";  

        if(isset($oParametros->anulacaoAbastecimento)){
          $rsEmpenhoVeiculo = $clempveiculos->sql_record($clempveiculos->sql_query_file($e60_numemp,"si05_numemp",null,"si05_codabast = $oParametros->codigoAbastecimento"));
          $e60_numemp = db_utils::fieldsMemory($rsEmpenhoVeiculo, 0)->si05_numemp;  
        }

        $rsDataEmpenho = $clempempenho->sql_record($clempempenho->sql_query_file($e60_numemp,"e60_emiss",null,"")); 
        $e60_emiss = db_utils::fieldsMemory($rsDataEmpenho, 0)->e60_emiss;
        $ve50_datacorte = db_utils::fieldsMemory($rsVeicparam, 0)->ve50_datacorte;

        if($ve50_datacorte > $e60_emiss){
          $oRetorno->lErro = true;
        }

      }

     break;

  }
} catch ( Exception $oException ) {

  $oRetorno->lErro     = true;
  $oRetorno->sMensagem = urlencode($oException->getMessage());
}

echo json_encode($oRetorno);
