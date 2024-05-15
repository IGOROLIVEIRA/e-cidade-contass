<?php
// Declarando variáveis necessárias para que a inclusão das bibliotecas n�o retorne mensagens.
$HTTP_SERVER_VARS['HTTP_HOST']      = '';
$HTTP_SERVER_VARS['PHP_SELF']       = '';
$HTTP_SERVER_VARS["HTTP_REFERER"]   = '';
$HTTP_POST_VARS                     = array();
$HTTP_GET_VARS                      = array();

define("PATH_IMPORTACAO", "integracao_externa/recadastramento_imobiliario/");

require_once(PATH_IMPORTACAO . "ImportacaoFaces.php");
require_once(PATH_IMPORTACAO . "libs/Conexao.model.php");
require_once("model/dataManager.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_stdlib.php");
require_once("std/DBDate.php");
require_once("libs/JSON.php");

db_app::import("configuracao.DBLog");
db_app::import("configuracao.DBLogTXT");

try {

  pg_query(Conexao::getInstancia()->getConexao(), "BEGIN");
  pg_query(Conexao::getInstancia()->getConexao(), "SELECT fc_startsession();");

  $oImportacaoFaces = new ImportacaoFaces(PATH_IMPORTACAO . 'arquivos/facedequadra.txt');
  $oImportacaoFaces->carregarArquivo();
  $oImportacaoFaces->processarInformacoes();
  pg_query(Conexao::getInstancia()->getConexao(), "COMMIT");
} catch (Exception $eErro) {

  pg_query(Conexao::getInstancia()->getConexao(), "ROLLBACK");
}
