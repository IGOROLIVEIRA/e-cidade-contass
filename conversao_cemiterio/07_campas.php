<?
set_time_limit(0);
require("db_conn.php");
echo "Conectando...\n";
if(!($dbportal = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE       port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA")) ){
 echo "erro ao conectar...\n";
 exit;
}
if(!($sam30 = pg_connect("host=$DB_SERVIDOR_SAM30 dbname=$DB_BASE_SAM30 port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA")) ){
 echo "erro ao conectar...\n";
 exit;
}
pg_exec( $dbportal, "drop sequence campas_cm19_i_codigo_seq" );
pg_exec( $dbportal, "create sequence campas_cm19_i_codigo_seq start 1;" );
//pg_query( $dbportal, "begin;" );

$arq = "txt/cem_campas_erro.txt";
system( "clear" );
system("> $arq");

$inc   = 0;
$ninc  = 0;

$sql   = "select distinct trim(sepultura_c_campa) as sepultura_c_campa from sepulturas";
$query = pg_query($sam30,$sql);
$rows  = pg_num_rows($query);
for($x=0;$x<$rows;$x++){
 $array = pg_fetch_array($query);
 $sql2 = "insert into campas(cm19_i_codigo,
                             cm19_c_descr)
                      values(nextval('campas_cm19_i_codigo_seq'),
                             '".trim(str_replace("'","",$array['sepultura_c_campa']))."')";
 $query2   = pg_query($dbportal,$sql2);
 if($query2) {
  $inc++;
 }else{
  $ninc++;
  $str_erro = "\nERRO:".pg_errormessage()."\nSQL:".$sql2."\n\n";
  system("echo \"$str_erro\" >> $arq");
 }
}
echo "\n --------------------\n";
echo "Incluidos: $inc \n";
echo "N�o Incluidos: $ninc";

//pg_query($dbportal,"commit");
?>