<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

header("Content-type: application/json; charset=utf-8");

require_once("./status_repo/constantes.php");

parse_str($_SERVER['QUERY_STRING'], $pedidos);


function executar($comando) {

  exec($comando, $output);

  return $output;

}


$retorno = array();

$host = executar("hostname");


// Autenticação
if (!isset($_POST['cliente'])
  || $host[0] != $_POST['cliente']) {

  echo json_encode(array(
    "autenticacao" => false
  ));

  die;

}


// Revisão
if (isset($pedidos['revisao'])) {

  $retorno['revisao'] = executar(REVISAO);
  $retorno['revisao'] = intval($retorno['revisao'][0]);

}


// Modificados
if (isset($pedidos['modificados'])) {

  $retorno['modificados'] = executar(MODIFICADOS);
  $retorno['modificados'] = implode(PHP_EOL, $retorno['modificados']);

}



// Retorno
$retorno = json_encode($retorno);

echo $retorno;
