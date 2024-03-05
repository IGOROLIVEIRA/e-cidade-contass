<?php
// Declarando variáveis necessárias para que a inclusão das bibliotecas n�o retorne mensagens.
$HTTP_SERVER_VARS['HTTP_HOST']      = '';
$HTTP_SERVER_VARS['PHP_SELF']       = '';
$HTTP_SERVER_VARS["HTTP_REFERER"]   = '';
$HTTP_POST_VARS                     = array();
$HTTP_GET_VARS                      = array();

define("PATH_IMPORTACAO", "integracao_externa/recadastramento_imobiliario/");

require_once(PATH_IMPORTACAO . "ImportacaoLogradouros.php");
require_once(PATH_IMPORTACAO . "libs/Conexao.model.php");
require_once("model/dataManager.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_stdlib.php");
db_app::import("configuracao.DBLog");
db_app::import("configuracao.DBLogTXT");

try {

  pg_query(Conexao::getInstancia()->getConexao(), "BEGIN");
  $oImportacaoLogradouros = new ImportacaoLogradouros(PATH_IMPORTACAO . 'arquivos/logradouronomapa_20120410.txt');

  $oImportacaoLogradouros->carregarArquivo();
  $oImportacaoLogradouros->processarImportacao();

  pg_query(Conexao::getInstancia()->getConexao(), "COMMIT;");
} catch (Exception $eErro) {

  pg_query(Conexao::getInstancia()->getConexao(), "ROLLBACK");
  echo "Erro ao Processar" . $eErro->getMessage();
}
