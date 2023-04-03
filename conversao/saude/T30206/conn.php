  <?php
// Esse é o padrão para conexao
require(__DIR__ . "/../../../libs/db_conn.php");
require(__DIR__ . "/../../../libs/db_stdlib.php");
require(__DIR__ . "/../../../libs/db_utils.php");
// Fazendo dessa forma teremos a conexao padronizacao e sem necessidade de alteracoes externas
//$DB_SERVIDOR="172.30.6.1";
//$DB_BASE="capivari_v2";
//$DB_USUARIO="postgres";
//$DB_SENHA="";
//$DB_PORTA
if(!($conn = pg_connect("host='$DB_SERVIDOR' dbname='$DB_BASE' user='$DB_USUARIO' password='$DB_SENHA' port='$DB_PORTA'"))) {
//if(!($connOrigem = pg_connect("host=localhost dbname=bage user=postgres password= port=5432"))) {
	echo "Erro ao conectar 1...\n\n";
	exit;
}else{
	echo "Conexao Estabelecida! Base: $DB_BASE \n";
}

// Logo após o pg_connect rodar o fc_startsession
pg_query("SELECT fc_startsession();") or die( "ERRO na sessão do bd.");

?>
