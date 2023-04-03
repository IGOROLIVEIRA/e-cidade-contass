<?

set_time_limit(0);

require("db_fieldsmemory.php");
require("db_conn.php");

if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
  echo "erro ao conectar...\n";
  exit;
}



system("clear");
//$filename = "tabelas/NFCES002.sql";
//$handle = fopen ($filename, "r");
//$conteudo = fread ($handle, filesize ($filename));
//echo $conteudo;
//pg_exec( $conteudo );

$dir = "arquivos/";

$filename="arquivos/01_diasemana.sql";
echo "$filename \n";
$handle = fopen ($filename, "r"); 
$conteudo = fread ($handle, filesize ($filename));
$result=pg_query( $conteudo );// or die( pg_errormessage() );

//$filename="arquivos/02_undmedhorario.sql";
//echo "$filename \n";
//$handle = fopen ($filename, "r"); 
//$conteudo = fread ($handle, filesize ($filename));
//$result=pg_query( $conteudo );// or die( pg_errormessage() );



?>
