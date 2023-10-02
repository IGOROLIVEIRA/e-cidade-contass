#!/usr/bin/php -q
<?php
ini_set('display_errors', 'off');
error_reporting(E_ERROR);

require("libs/db_utils.php");
require("model/configuracao/TraceLog.model.php");
require("libs/db_stdlib.php");

ini_set('memory_limit', '-1');

$code = 0;

try {
    if (empty($argv[1])) {
        echo "\n ERROR: Informe os parametros. SERVIDOR, BASE, PORTA, USUARIO, SENHA \n \n";
        exit(1);
    }
    $DB_SERVIDOR = "$argv[1]";//"localhost";
    $DB_BASE     = "$argv[2]";//"e-cidade";
    $DB_PORTA    = "$argv[3]";//"5432";
    $DB_USUARIO  = "$argv[4]";//"dbportal";
    $DB_SENHA    = "$argv[5]";//"dbportal";

    if (!($conn = @pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
        echo "\n ERRO: Erro ao conectar com a base de dados \n";
        exit(1);
    }

    $sqlsessao = "select login from db_usuarios where usuext=0;";
    $resultsessao = db_query($conn, $sqlsessao);

    for ($record_correto=0; $record_correto < pg_num_rows($resultsessao); $record_correto++) {
        db_fieldsmemory($resultsessao, $record_correto);
        $output = shell_exec("bin/v3/extension/install Desktop ".$login);
        echo $output;
    }

} catch (Exception $error) {

  echo "\n message: ". $error;
  $code = 2;
}

echo "\n memory: " . round((memory_get_peak_usage(true)/1024)/1024, 2) . "mb\n\n";

exit($code);
