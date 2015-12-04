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
pg_query($dbportal,"drop sequence lotecemit_cm23_i_codigo_seq");
pg_query($dbportal,"create sequence lotecemit_cm23_i_codigo_seq start 1") or die ('erro');
pg_query($dbportal,"truncate lotecemit");
//pg_query( $dbportal,"begin;");

$arq = "txt/cem_lotecemit_erro.txt";
system( "clear" );
system("> $arq");

$inc   = 0;
$ninc  = 0;

//SEPULTURAS
$sql = "select distinct trim(upper(sepultura_c_quadra)) as sepultura_c_quadra,
               sepultura_i_lote
          from sepulturas";
$query = pg_query($sam30,$sql);
$rows  = pg_num_rows($query);
echo "Total de Linhas: $rows \n";

for($x=0;$x<$rows;$x++){
 $array = pg_fetch_array($query);
 
//cadastra no lotecemit
$sql_quadracemit = "select cm22_i_codigo 
                      from quadracemit 
                     where cm22_c_quadra ";
if(trim(str_replace(",","",$array['sepultura_c_quadra'])) == "" ){
 $sql_quadracemit.= " is null ";
}else{
 $sql_quadracemit.= " = '".trim(str_replace("'","",$array['sepultura_c_quadra']))."'";
}
$quadracemit = pg_result(pg_query($dbportal,$sql_quadracemit),0,0);

  

 $insert = "insert into lotecemit(cm23_i_codigo,
				   cm23_i_quadracemit,
				   cm23_i_lotecemit,
				   cm23_c_situacao,
				   cm23_b_selecionado)
			  VALUES  (nextval('lotecemit_cm23_i_codigo_seq'),
				   $quadracemit,
				   $array[sepultura_i_lote],
				   'D',
				   'false')";
 $query1 = @pg_query($dbportal,$insert);
 if($query1) {
  $inc++;
 }else{
  $ninc++;
  $str_erro = "\nS ERRO:".pg_errormessage()."\nSQL:".$insert."\n\n";
  system("echo \"$str_erro\" >> $arq");
 }
}

echo "\n --------------------\n";
echo "Lotecemit - Sepulturas";
echo "Incluidos: $inc \n";
echo "N�o Incluidos: $ninc";

$inc   = 0;
$ninc  = 0;

//Ossoarios
$sql = "select distinct trim(upper(ossoario_c_quadra)) as ossoario_c_quadra,
               ossoario_i_lote
          from ossoarios";
$query = pg_query($sam30,$sql);
$rows  = pg_num_rows($query);
echo "Total de Linhas: $rows \n";

for($x=0;$x<$rows;$x++){
 $array = pg_fetch_array($query);
 
  $sql_quadracemit = "select cm22_i_codigo 
                      from quadracemit 
                     where cm22_c_quadra ";
if(trim(str_replace(",","",$array['ossoario_c_quadra'])) == "" ){
 $sql_quadracemit.= " is null ";
}else{
 $sql_quadracemit.= " = '".trim(str_replace("'","",$array['ossoario_c_quadra']))."'";
}
$quadracemit = pg_result(pg_query($dbportal,$sql_quadracemit),0,0);

 $insert = "insert into lotecemit(cm23_i_codigo,
			          cm23_i_quadracemit,
				  cm23_i_lotecemit,
				  cm23_c_situacao,
				  cm23_b_selecionado)
			 VALUES  (nextval('lotecemit_cm23_i_codigo_seq'),
			          $quadracemit,
				  $array[ossoario_i_lote],
				  'D',
				  'false')";
 $query1 = @pg_query($dbportal,$insert);
 if($query1) {
  $inc++;
 }else{
  $ninc++;
  $str_erro = "\nO ERRO:".pg_errormessage()."\nSQL:".$insert."\n\n";
  system("echo \"$str_erro\" >> $arq");
 }
}

echo "\n --------------------\n";
echo "Lotecemit - Ossoarios";
echo "Incluidos: $inc \n";
echo "N�o Incluidos: $ninc";

$inc   = 0;
$ninc  = 0;

//Jazigos
$sql = "select distinct trim(upper(jazigo_c_quadra)) as jazigo_c_quadra,
               jazigo_i_lote
          from jazigos";
$query = pg_query($sam30,$sql);
$rows  = pg_num_rows($query);
echo "Total de Linhas: $rows \n";

for($x=0;$x<$rows;$x++){
 $array = pg_fetch_array($query);
 
 //cadastra no lotecemit
  $sql_quadracemit = "select cm22_i_codigo 
                      from quadracemit 
                     where cm22_c_quadra ";
if(trim(str_replace(",","",$array['jazigo_c_quadra'])) == "" ){
 $sql_quadracemit.= " is null ";
}else{
 $sql_quadracemit.= " = '".trim(str_replace("'","",$array['jazigo_c_quadra']))."'";
}
$quadracemit = pg_result(pg_query($dbportal,$sql_quadracemit),0,0);

 $insert = "insert into lotecemit(cm23_i_codigo,
			          cm23_i_quadracemit,
				  cm23_i_lotecemit,
				  cm23_c_situacao,
				  cm23_b_selecionado)
			 VALUES  (nextval('lotecemit_cm23_i_codigo_seq'),
			          $quadracemit,
				  $array[jazigo_i_lote],
				  'D',
				  'false')";
 $query1 = @pg_query($dbportal,$insert);
 if($query1) {
  $inc++;
 }else{
  $ninc++;
  $str_erro = "\n J ERRO:".pg_errormessage()."\nSQL:".$insert."\n\n";
  system("echo \"$str_erro\" >> $arq");
 }
}

echo "\n --------------------\n";
echo "Lotecemit - Jazigos";
echo "Incluidos: $inc \n";
echo "N�o Incluidos: $ninc";
//pg_query($dbportal,"commit");
?>