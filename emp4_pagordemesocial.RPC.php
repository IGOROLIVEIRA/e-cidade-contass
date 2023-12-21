<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("classes/db_pagordem_classe.php");

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = "";

switch ($oParam->method) {

  case "verificaEsocial":

    $clpagordemEsocial      = new cl_pagordem;
    $campos = " e50_cattrabalhador , e50_cattrabalhadorremurenacao, e50_empresadesconto, e50_contribuicaoprev, e50_valorremuneracao, e50_valordesconto, e50_datacompetencia,
                ( select ct01_descricaocategoria from pagordem 
                    inner join categoriatrabalhador on 
                      e50_cattrabalhador = ct01_codcategoria
                    where pagordem.e50_codord = $oParam->iCodOrdem)  as desccattrabalhado,
                ( select ct01_descricaocategoria from pagordem 
                    inner join categoriatrabalhador on 
                      e50_cattrabalhadorremurenacao = ct01_codcategoria
                    where pagordem.e50_codord = $oParam->iCodOrdem)  as desctrabremuneracao ,
                    z01_nome     ";

    $oDados =  pg_fetch_all($clpagordemEsocial->sql_record($clpagordemEsocial->sql_query_boxesocial($oParam->iCodOrdem,$campos,null,$where)));

    if ($clpagordemEsocial->numrows > 0 ) {
      foreach ($oDados as $Dados) {
        $oRetorno->e50_cattrabalhador            = $Dados['e50_cattrabalhador'];
        $oRetorno->e50_cattrabalhadorremurenacao = $Dados['e50_cattrabalhadorremurenacao'];
        $oRetorno->e50_empresadesconto           = $Dados['e50_empresadesconto'];
        $oRetorno->e50_contribuicaoPrev          = $Dados['e50_contribuicaoprev'];
        $oRetorno->e50_valorremuneracao          = number_format($Dados['e50_valorremuneracao'],2);
        $oRetorno->e50_valordesconto             = number_format($Dados['e50_valordesconto'],2);
        if ($Dados['e50_datacompetencia']) {
          $oRetorno->e50_datacompetencia           = formateDate($Dados['e50_datacompetencia']);
        }
        $oRetorno->desccattrabalhado             = $Dados['desccattrabalhado'];
        $oRetorno->desctrabremuneracao           = $Dados['desctrabremuneracao'];
        $oRetorno->nomeempresa                   = $Dados['z01_nome'];
      }
    }
    break;  
}

echo $oJson->encode($oRetorno);

function formateDateReverse(string $date): string
{
  $data_objeto = DateTime::createFromFormat('d/m/Y', $date);
  $data_formatada = $data_objeto->format('Y-m-d');
  return date('Y-m-d', strtotime($data_formatada));
}
function formateDate(string $date): string
{
    return date('d/m/Y', strtotime($date));
}
