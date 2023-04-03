<?
set_time_limit(0);

/************************************************/
$dbname   = "auto_bag_2803";
$dbhost   = "192.168.0.37";
$dbarq    = "/tmp/inscrzona.csv";
$dblogsql = "/tmp/logconverisszona.sql";
/***********************************************/

$conn = pg_connect("dbname=$dbname user=postgres host=$dbhost") or die('ERRO AO CONECTAR NA BASE DE DADOS !!');
system("echo 'Aguarde conectando na base de dados...'");
system("echo 'BEGIN;' > $dblogsql");
$arquivo = fopen ("$dbarq", "r");
pg_query("BEGIN;");
while (!feof($arquivo)){
    $linha = fgets($arquivo,4096);
	if($linha==""){
        continue;
    }
	$colunas = split (';', $data);

    $zona  = $colunas[0];
    $inscr = $colunas[1];
	$sql   = "INSERT INTO isszona VALUES ($inscr,$zona);";
	system("echo '".$sql."'>> $dblogsql");
    pg_query($sql);
}

fclose($arquivo);
pg_query("ROLLBACK;");
//pg_query("COMMIT;");
?>
