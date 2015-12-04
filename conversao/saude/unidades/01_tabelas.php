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

$dir = "tabelas/";

// Abre um diretorio conhecido, e faz a leitura de seu conteudo
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while ( (($file = readdir($dh)) !== false)  ) {
           $extension = explode( ".", $file );
           if($file != "." && $file != ".." && $extension[1] == "sql" ){
              $filename=$dir.$file;
              echo "$filename \n";
              $handle = fopen ($filename, "r"); 
              $conteudo = fread ($handle, filesize ($filename));
              @pg_query( "drop table ".$extension[0] );
              $result=pg_query( $conteudo ); //or die( pg_errormessage() );
           }
        }
        closedir($dh);
    }
}




?>

