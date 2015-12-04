<?

include("libs/db_conn.php");
include("libs/db_stdlib.php");

if(!($conn1 = @pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
  echo "Contate com Administrador do Sistema! (Conexão Inválida.)   <br>Sessão terminada, feche seu navegador!\n";
  exit;
}

if(!($conn2 = @pg_connect("host=192.168.78.245 dbname=daeb port=5433 user=postgres"))) {
  echo "Contate com Administrador do Sistema! (Conexão Inválida.)   <br>Sessão terminada, feche seu navegador!\n";
  exit;
}

$sql = "select * from cgm order by z01_numcgm";
$result = pg_exec($conn1, $sql) or die($sql);

$naoexistedaeb=0;
$identicodaeb=0;
$diferentedaeb=0;

$arquivo = fopen("/tmp/comparacgm_daeb.txt", "w");

for ($x=0; $x < pg_numrows($result); $x++) {
	db_fieldsmemory($result, $x);

  // compara com daeb

	$sql_daeb = "select z01_nome as z01_nome_daeb from cgm where z01_numcgm = $z01_numcgm";
	$result_daeb = pg_exec($conn2, $sql_daeb) or die($sql_daeb);

  if (pg_numrows($result_daeb) == 0) {
		$naoexistedaeb++;
	} else {
		db_fieldsmemory($result_daeb,0);

    if ($z01_nome <> $z01_nome_daeb) {
			$diferentedaeb++;
//			echo $z01_nome . " - " . $z01_nome_daeb . "\n";
			echo "registro $x/" . pg_numrows($result) . " - " . str_pad($z01_numcgm,6) . " - naoexistedaeb: $naoexistedaeb - identicodaeb: $identicodaeb - diferentedaeb: $diferentedaeb\n";
      $linha = "$z01_numcgm;" . trim(addslashes($z01_nome)) . ";" . trim(addslashes($z01_nome_daeb)) . "\n";
			fputs($arquivo,$linha);

		} else {
			$identicodaeb++;
		}
		
	}

}

fclose($arquivo);

?>
