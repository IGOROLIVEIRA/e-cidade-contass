<?php
//ini_set("display_errors",true);
//error_reporting(E_ALL);

require_once("dbforms/db_funcoes.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");
require_once("std/DBDate.php");

db_postmemory($_POST);
$oJson  = new services_json();
$oParam = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

$ufs = array(

  11 => "RO", 12 => "AC", 13 => "AM", 14 => "RR", 15 => "PA", 16 => "AP", 17 => "TO", 21 => "MA", 22 => "PI",
  23 => "CE", 24 => "RN", 25 => "PB", 26 => "PE", 27 => "AL", 28 => "SE", 29 => "BA", 31 => "MG", 32 => "ES",
  33 => "RJ", 35 => "SP", 41 => "PR", 42 => "SC", 43 => "RS", 50 => "MS", 51 => "MT", 52 => "GO", 53 => "DF"

);


switch ($oParam->exec) {//

  case 'validachave' :

  $ufKey   = substr($oParam->chave,0,2);
  $dataKey = substr($oParam->chave,2,4);
  $cnpjKey = substr($oParam->chave,6,14);
  $nfKey   = substr($oParam->chave,25,9);

  $oDaoCgm   = db_utils::getDao("cgm");
  $sSqlCgm   = $oDaoCgm->sql_query_file($oParam->cgm);
  $rsCgm     = $oDaoCgm->sql_record($sSqlCgm);
  $oDadosCgm = db_utils::fieldsMemory($rsCgm,0);


  $key  = (array_key_exists($ufKey, $ufs)) ? $ufKey : 0;
  $data = substr(implode("",array_reverse(explode("/", $oParam->data))), 2, 4);

  if ($ufs[$key] != $oDadosCgm->z01_uf) {
    $oRetorno->status = 0;
    $oRetorno->erro   = "Chave de acesso inválida!\nVerifique a Cidade e o Estado do Fornecedor!";
  }

  else if (strcmp($data, $dataKey)) {
    $oRetorno->status = 0;
    $oRetorno->erro   = "Chave de acesso inválida!\nVerifique a data da Nota Fiscal!";
  }

  else if (strcmp(str_pad($oParam->nfe, 9, "0", STR_PAD_LEFT), $nfKey)) {// 31180516928871000100550020001071891162450627 16928871000100 000107189
    $oRetorno->status = 0;
    $oRetorno->erro   = "Chave de acesso inválida!\nVerifique o Número da Nota!";
  }

  else if ($oParam->tipo == 1) {///04930131000129-04930131000129 / 11636961000103
    if (strcmp($oDadosCgm->z01_cgccpf, $cnpjKey)) {
      $oRetorno->status = 0;
      $oRetorno->erro   = "Chave de acesso inválida!\nVerifique o CNPJ do Fornecedor!";
   }
  }

  break;

}

if (isset($oRetorno->erro)) {
  $oRetorno->erro = utf8_encode($oRetorno->erro);
}

echo $oJson->encode($oRetorno);

?>
