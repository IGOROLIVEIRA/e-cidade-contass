<?
$HOST = "localhost";
$BASE = "bage";
$PORT = "5432";
$USER = "postgres";
$PASS = "";
set_time_limit(0);
if(!($conn = pg_connect("host=$HOST dbname=$BASE port=$PORT user=$USER password=$PASS"))){
 echo "Erro ao conectar base de dados...\n";
 exit;
}
system("clear");
pg_exec("begin");
$sql = "SELECT ed72_i_codigo,ed95_i_escola FROM diarioavaliacao inner join diario on ed95_i_codigo = ed72_i_diario ORDER BY ed72_i_codigo";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
echo "Começando UPDATE em $linhas registros:\n\n";
sleep(3);
for($x=0;$x<$linhas;$x++){
 $coddiario = pg_result($result,$x,0);
 $codescola = pg_result($result,$x,1);
 $sql1 = "UPDATE diarioavaliacao SET ed72_i_escola = $codescola WHERE ed72_i_codigo = $coddiario";
 $result1 = pg_query($sql1);
 if(!$result1){
  pg_exec("rollback");
  break;
 }else{
  echo str_pad(($x+1),6,0,STR_PAD_LEFT)." -> UPDATE registro $coddiario \n";
 }
}
echo "\n\n Terminado UPDATE em $linhas registros.\n\n";
pg_exec("commit");
?>
