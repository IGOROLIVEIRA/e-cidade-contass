  <?php
// Esse é o padrão para conexao
require(__DIR__ . "/../../../libs/db_conn.php");
require(__DIR__ . "/../../../libs/db_stdlib.php");
//$DB_BASE = "canela";
// Fazendo dessa forma teremos a conexao padronizacao e sem necessidade de alteracoes externas
if(!($DB_BASE = pg_connect("host='$DB_SERVIDOR' dbname='$DB_BASE' user='$DB_USUARIO' password='$DB_SENHA' port='$DB_PORTA'"))) {
	echo "Erro ao conectar 1...\n\n";
	exit;
}

// Logo após o pg_connect rodar o fc_startsession
pg_query($DB_BASE, "SELECT fc_startsession();");

?>