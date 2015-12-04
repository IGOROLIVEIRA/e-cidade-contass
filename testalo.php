<?
$DB_USUARIO = "postgres";
$DB_SENHA = "";
$DB_SERVIDOR = "192.168.0.36";  
$DB_BASE = "auto_bag_3108";
$DB_PORTA = "5433";
if(!($conn = @pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
	echo "\n\nPutzzz...\n\n";
}else{
	echo "\n\nOK...\n\n";
	$arquivo = "/var/www/dbportal2/tmp/manual_implanta_introducao_v0.pdf";
	pg_query("begin");

  $arquivograva = fopen($arquivo,"rb");

  $dados = fread($arquivograva,filesize($arquivo));

  fclose($arquivograva);

  $oidgrava = pg_lo_create();

  $objeto = pg_lo_open($conn,$oidgrava,"w");

  pg_lo_write($objeto,$dados);
echo "\n\n$oidgrava\n\n";

  pg_lo_close($objeto);

	pg_query("commit");
	pg_close($conn);
}
?>
