<?
set_time_limit(0);

/********** VARIAVEIS DE CONFIGURAÇÃO *************/
	$ipservidor = "192.168.0.141";
	$base       = "osorio_dbportal_1108";
	$porta			= 5433;
	$arqlog     = "/tmp/logconver_ativtipo.sql";
	$arqconver  = "/tmp/ativtipo.csv";
/**************************************************/

$conn = pg_connect("dbname=$base user=postgres port=$porta host=$ipservidor") or die('ERRO AO CONECTAR NA BASE DE DADOS !!');
system("echo 'Aguarde conectando na base de dados...\n 5 Segundos para começar... \n CTRL+C para cancelar'");
system("sleep 5");
system("echo 'Processo iniciado !!!'");
system("echo 'BEGIN;' > $arqlog");
$arquivo = fopen ("$arqconver", "r");
pg_query("delete from ativtipo;");
pg_query("BEGIN;");
while (!feof($arquivo)){
    $linha = fgets($arquivo,4096);
    if($linha==""){
        continue;
    }
    $colunas = split (',',rtrim($linha));
    $numcol  = count($colunas);	
    for($i=1;$i<$numcol;$i++){
	$ativ = $colunas[0];
	$tipcalc = $colunas[$i];
	if ($tipcalc==""){
	     continue;
	}     
        $sql = "\r INSERT INTO ativtipo VALUES ($ativ,$tipcalc)";
        echo "$sql";
        system("echo '".$sql."' >> $arqlog");
	pg_query($sql) or die($sql);
    }
}
fclose($arquivo);

//pg_query("ROLLBACK;");
pg_query("COMMIT;");

echo "OPERAÇÃO REALIZADA COM SUCESSO !!! \n";
echo "FOI CRIADO O ARQUIVO : $arqlog PARA CONFERENCIA ! \n";
?>
