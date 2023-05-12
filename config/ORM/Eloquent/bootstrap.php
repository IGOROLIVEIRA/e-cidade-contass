<?php
use Illuminate\Database\Capsule\Manager;

require_once(ECIDADE_PATH . "libs/db_conn.php");

$capsule = new Manager();

$capsule->addConnection([
    'driver' => 'pgsql',
    'host' => $DB_SERVIDOR,
    'database' => $DB_BASE,
    'username' => $DB_USUARIO,
    'password' => $DB_SENHA,
    'port' => $DB_PORTA,
    'charset' => 'latin1',
    'collation' => 'pt_BR',
    'prefix' => '',
    'strict' => false,
    'prefix_indexes' => true,
    'search_path' => 'public',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();