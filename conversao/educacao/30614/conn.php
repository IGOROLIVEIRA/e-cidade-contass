  <?php
// Esse � o padr�o para conexao
require("../../../libs/db_conn.php");
require("../../../libs/db_stdlib.php");
$DB_ORIGEM = "canela";
// Fazendo dessa forma teremos a conexao padronizacao e sem necessidade de alteracoes externas
if(!($connOrigem = pg_connect("host='$DB_SERVIDOR' dbname='$DB_ORIGEM' user='$DB_USUARIO' password='$DB_SENHA' port='$DB_PORTA'"))) {
//if(!($connOrigem = pg_connect("host=localhost dbname=bage2009 user=postgres password= port=5432"))) {
	echo "Erro ao conectar 1...\n\n";
	exit;
}else{
	if(!($connDestino = pg_connect("host='$DB_SERVIDOR' dbname='$DB_BASE' user='$DB_USUARIO' password='$DB_SENHA' port='$DB_PORTA'"))) {
	//if(!($connDestino = pg_connect("host='localhost' dbname='capivari' user='postgres' password='' port='5432'"))) {
		echo "Erro ao conectar 2...\n\n".pg_errormessage();
		exit;
	}else{
		echo "conectado...\n\n";
	}
}

// Logo ap�s o pg_connect rodar o fc_startsession
pg_query($connDestino, "SELECT fc_startsession();");

?>
