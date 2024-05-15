<?
include(__DIR__ . "/../libs/db_conn.php");

if(count($argv)!= 4) {
  echo "Faltam parametros\n";
  exit;
}
$exerc   = $argv[1];
$dataini = $argv[2];
$datafim = $argv[3];

$conn = pg_connect("host=$DB_SERVIDOR port=$DB_PORTA dbname=$DB_BASE user=$DB_USUARIO password=$DB_SENHA");

$sql = "
select j46_matric, j46_tipo from iptuisen 
inner join isenexe on j47_codigo = j46_codigo
where j46_dtinc between '$dataini' and '$datafim' 
and   j46_tipo = 231
and   j47_anousu = $exerc";

$result = pg_query($conn, $sql);

while($row = pg_fetch_row($result)) {
  printf("%07s\n", $row[0]);
}

pg_close($conn);

?>
