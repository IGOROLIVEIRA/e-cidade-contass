<?
$DB_USUARIO = "postgres";
$DB_SENHA = "";
$DB_SERVIDOR = "localhost";  
$DB_BASE = "bage";
$DB_PORTA = "5433";
if(!($conn = @pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
	echo "\n\nPutzzz...\n\n";
}else{
	echo "\n\nOK...\n\n";
	pg_query("begin");
  // Abre o arquivo
	$oidgrava = 2075020697;
	$objetoleitura = pg_lo_open($oidgrava,"r");

	$mostrar = pg_lo_read_all($objetoleitura);

	pg_lo_close($objetoleitura);

	pg_query("rollback");
	pg_close($conn);
}
?>
