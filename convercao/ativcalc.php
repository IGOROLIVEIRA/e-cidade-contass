<?
set_time_limit(0);

/********** VARIAVEIS DE CONFIGURAÇÃO *************/
	$ipservidor = "192.168.0.34";
	$base       = "auto_cha_0503";
	$arqlog     = "/tmp/logconver.sql";
	$arqconver  = "/tmp/classe1000.csv";
/**************************************************/

$conn = pg_connect("dbname=$base user=postgres host=$ipservidor") or die('ERRO AO CONECTAR NA BASE DE DADOS !!');
system("echo 'Aguarde conectando na base de dados...\n 5 Segundos para começar... \n CTRL+C para cancelar'");
system("sleep 5");
system("echo 'Processo iniciado !!!'");
system("echo 'BEGIN;' > $arqlog");
$arquivo = fopen ("$arqconver", "r");
pg_query("BEGIN;");
while (!feof($arquivo)){
    $linha = fgets($arquivo,4096);
    if($linha==""){
        continue;
    }
    $colunas = split (';',rtrim($linha));
    $numcol  = count($colunas);	
    for($i=1;$i<$numcol;$i++){
	$ativ = $colunas[0];
	$tipcalc = $colunas[$i];
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
