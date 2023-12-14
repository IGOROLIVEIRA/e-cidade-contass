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
include("classes/db_veiculos_classe.php");
include("classes/db_condataconf_classe.php");

db_app::import("configuracao.DBDepartamento");


// Função para buscar um veiculo a partir do código
function buscarVeiculo($codigo) {
  
  $clveiculos = new cl_veiculos;

  if (!isset($codigo)) {
      return buildResponse(2, "Para buscar veículo é necessário informar o código.");
  }

  $sql = $clveiculos->sql_query($codigo, "ve01_codigo,ve01_placa,si04_descricao");
  $result = $clveiculos->sql_record($sql);
  if (!$result) {
      return buildResponse(2, "Veiculo código $codigo não encontrado.");
  }

  $records = db_utils::getCollectionByRecord($result);
  return buildResponse(1, "", ['veiculo' => $records[0]]);
}

// Função para alteração da placa do veículo
function alterarPlaca($dados) {

  if (!isset($dados->ve01_codigo) || empty($dados->ve01_codigo)) {
    return buildResponse(2, "É necessário informar o código do veiculo.");
  }

  if (!isset($dados->ve76_data) || empty($dados->ve76_data)) {
    return buildResponse(2, "É necessário informar a data da alteração.");
  }

  if (!isset($dados->ve76_placa) || empty($dados->ve76_placa)) {
    return buildResponse(2, "É necessário informar a nova placa.");
  }

  $clveiculos = new cl_veiculos;

  $sql = $clveiculos->sql_query($dados->ve01_codigo, "ve01_codigo,ve01_placa,si04_descricao");
  $result = $clveiculos->sql_record($sql);

  if (!$result) {
    return buildResponse(2, "Ocorreu um erro ao buscar o veculo $dados->ve01_codigo.");
  }

  $veiculo = db_utils::getCollectionByRecord($result)[0];

  // Validar se a placa está sendo alterada para o mesmo código
  if (strcasecmp($veiculo->ve01_placa, $dados->ve76_placa) == 0) {
    return buildResponse(2, "A placa informada é igual a placa já cadastrada para o veículo.");
  }
  
  // Verificar se já existe placa cadastrada
  $sqlPlaca = $clveiculos->sql_query($dados->ve01_codigo, "ve01_codigo,ve01_placa,si04_descricao", "", "ve01_placa = $$data->ve76_placa");
  $result = $clveiculos->sql_record($sqlPlaca);
  if($result) {
    return buildResponse(2, "A placa informada já está cadastrada para outro veículo.");
  }

  // Verifica a data de encerramento do período patrimonial
  $clcondataconf = new cl_condataconf;
  $sqlConf = $clcondataconf->sql_query_file(db_getsession("DB_anousu"),db_getsession("DB_instit"));
  $result = $clcondataconf->sql_record($sqlConf);
  
  if ($result != false) {
    $config = db_utils::getCollectionByRecord($result)[0];

    $dataEncerramentoPatrimonial = convertToDate($config->c99_datapat);
    $dataAlteracaoPlaca = convertToDate($dados->ve76_placa);
       
    if($dataAlteracaoPlaca <= $dataEncerramentoPatrimonial) {
      return buildResponse(2, "O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.");
    }
  }

  // Adicionar alteração na tabela veiculosplaca
  $ve76_placaanterior = $veiculo->ve01_placa;
  
  // Altera a placa do veiculo
  $clveiculos->ve01_placa = $dados->ve76_placa;
  $clveiculos->alterar($veiculo->ve01_codigo);


}

// Função para excluir a alteração de placa
function excluirAlteracao() {

}

// Função responsável por preparar a resposta da requisição
function buildResponse($status, $message, $data = []) {
  $oJson    = new services_json();
  $oRetorno = new stdClass();
  
  $oRetorno->status = $status;
  $oRetorno->message = urldecode($message);
  
  foreach ($data as $key => $value) {
      $oRetorno->$key = $value;
  }
  return $oJson->encode($oRetorno);
}

// Converter a data para datetime
function convertToDate($dateString) {
  if (strpos($dateString, '/') !== false) {
      return DateTime::createFromFormat('d/m/Y', $dateString);
  } else if (strpos($dateString, '-') !== false) {
      return DateTime::createFromFormat('Y-m-d', $dateString);
  } else {
      return false;
  }
}

// Executa as funções disponíveis via Ajaz
function executar($oParam)
{
  switch ($oParam->exec) {
    case 'buscarVeiculo':
        return buscarVeiculo($oParam->codigo);
        break;
    case 'alterarPlaca':
        return alterarPlaca($oParam->data);
        break;
    case 'excluirAlteracao':
      return excluirAlteracao();
      break;
    default:
        return buildResponse(2, "Operação inválida para opção ($oParam->exec.)");
        break;
}
}

// Recebe os parametros e executa a operação
$oParam = (new services_json())->decode(str_replace("\\", "", $_POST["json"]));
echo executar($oParam);
