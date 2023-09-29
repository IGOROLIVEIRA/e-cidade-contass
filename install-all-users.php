<?php
require("libs/db_utils.php");
require("model/configuracao/TraceLog.model.php");
require("libs/db_stdlib.php");

ini_set('memory_limit', '-1');

$code = 0;

$DB_SERVIDOR = "localhost";
$DB_BASE     = "e-cidade";
$DB_PORTA    = "5432";
$DB_USUARIO  = "dbportal";
$DB_SENHA    = "dbportal";

if (!($conn = @pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
    db_logduplos("Erro ao conectar com a base de dados");;
    exit(1);
}

try {

    $sqlsessao = "select login from db_usuarios where usuext=0;";
    $resultsessao = db_query($conn, $sqlsessao);

    for ($record_correto=0; $record_correto < pg_num_rows($resultsessao); $record_correto++) {
        $login = db_fieldsmemory($resultsessao, $record_correto);
        $output = shell_exec("bin/v3/extension/install Desktop ".$login);
        echo $output;
    }


} catch (Exception $error) {

  echo "\n message: ". $error;
  $code = 2;
}

echo "\n memory: " . round((memory_get_peak_usage(true)/1024)/1024, 2) . "mb\n\n";

exit($code);
