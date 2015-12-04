<?
set_time_limit(0);
$conn = pg_connect("dbname=auto_cha_0603 user=postgres host=192.168.0.34") or die('ERRO AO CONECTAR NA BASE DE DADOS !!');
system("echo 'Aguarde conectando na base de dados...'");
system("echo 'BEGIN;' > /tmp/logconver.sql");
$arquivo = fopen ("./classe1000.csv", "r");
pg_query("BEGIN;");
while (!feof($ponteiro_fornec)){
    $linha = fgets($arquivo,4096);
	if($linha==""){
        continue;
    }
	$colunas = split (';', $data);
    $numcol  = count($colunas);	
	for($i=1;$i==$numcol;$i++){
	    $ativ = $colunas[0];
	    $ativ = $colunas[$i];
		$sql = "INSERT INTO ativtipo VALUES ($ativ,$tipcalc);";
		system("echo '".$sql."'>> /tmp/logconver.sql");
	    pg_query($sql);
	}
}
fclose($arquivo);
pg_query("ROLLBACK;");
//pg_query("COMMIT;");

/*
for para o arquivo
     for para cada linha
	   insert na ativtipo...	   
*/



?>
