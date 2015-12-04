<?
set_time_limit(0);
require("db_conn.php");
echo "Conectando...\n";
if(!($dbportal = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE       port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA")) ){
 echo "erro ao conectar...\n";
 exit;
}
if(!($sam30 = pg_connect("host=$DB_SERVIDOR_SAM30 dbname=$DB_BASE_SAM30 port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA")) ){
 echo "erro ao conectar...\n";
 exit;
}

pg_query( $dbportal, "drop sequence cem_legista_seq");
pg_query( $dbportal, "create sequence cem_legista_seq start 1;" );

pg_query( $dbportal, "truncate legista" );

$arq1 = "txt/cem_legista.txt";
system( "clear" );
system("> $arq1");

$inc  = 0;
$ninc = 0;

//Médico Migração
$sql_med = "INSERT INTO legista(cm32_i_codigo, 
                            cm32_i_numcgm, 
                            cm32_i_crm)
                     values(nextval('cem_legista_seq'),
                            76385,
                            null)";
$query_med = pg_query($dbportal,$sql_med);


$sql = "insert into legista select nextval('cem_legista_seq'), sd03_i_cgm, sd03_i_crm from medicos";
$query = pg_query($dbportal,$sql);
 echo 'Médicos cadastrados em Legistas';
?>
