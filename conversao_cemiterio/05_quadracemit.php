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
pg_query($dbportal,"drop sequence quadracemit_cm22_i_codigo_seq");
pg_query($dbportal,"create sequence quadracemit_cm22_i_codigo_seq start 1") or die ('erro');
pg_query($dbportal,"delete from quadracemit");
//pg_query( $dbportal,"begin;");

$arq = "txt/cem_quadracemit_erro.txt";
system( "clear" );
system("> $arq");

$inc   = 0;
$ninc  = 0;

//SEPULTURAS
$sql = "select distinct sepulturas.cemiterio_i_codigo,
               trim(upper(sepultura_c_quadra)) as sepultura_c_quadra
          from sepulturas";
$query = pg_query($sam30,$sql);
$rows  = pg_num_rows($query);
echo "Total de Linhas: $rows \n";

for($x=0;$x<$rows;$x++){
 $array = pg_fetch_array($query);
 
 //quadracemit
  $insert = "insert into quadracemit(cm22_i_codigo,
      	    		              cm22_i_cemiterio,
				      cm22_c_quadra,
				      cm22_c_tipo)
                               values(nextval('quadracemit_cm22_i_codigo_seq'),";
				     if($array["cemiterio_i_codigo"] == ""){
                                      $insert .= "1,";
                                     }else{
 				      $insert .= $array["cemiterio_i_codigo"].",";
                                     }
			   	    if(trim($array["sepultura_c_quadra"]) == ""){
                                      $insert .= " null";
                                     }else{
 				      $insert .= "'".str_replace("'","",$array['sepultura_c_quadra'])."'";
                                     }
                                    $insert.= " , 'S')";
 $query1 = pg_query($dbportal,$insert);
 if($query1) {
  $inc++;
 }else{
  $ninc++;
  $str_erro = "\n S ERRO:".pg_errormessage()."\nSQL:".$insert."\n\n";
  system("echo \"$str_erro\" >> $arq");
 }

}

echo "\n --------------------\n";
echo "Quadracemit das sepulturas";
echo "Incluidos: $inc \n";
echo "N�o Incluidos: $ninc";
echo "\n --------------------\n";

$inc   = 0;
$ninc  = 0;

//Ossaorios
$sql = "select distinct ossoarios.cemiterio_i_codigo,
               trim(upper(ossoario_c_quadra)) as ossoario_c_quadra
          from ossoarios";
$query = pg_query($sam30,$sql);
$rows  = pg_num_rows($query);
echo "Total de Linhas: $rows \n";

for($x=0;$x<$rows;$x++){
 $array = pg_fetch_array($query);
 
 //quadracemit
  $insert = "insert into quadracemit(cm22_i_codigo,
      	    		             cm22_i_cemiterio,
				     cm22_c_quadra,
				     cm22_c_tipo)
                               values(nextval('quadracemit_cm22_i_codigo_seq'),";
				     if($array["cemiterio_i_codigo"] == ""){
                                      $insert .= "1,";
                                     }else{
 				      $insert .= $array["cemiterio_i_codigo"].",";
                                     }
			   	    if(trim($array["ossoario_c_quadra"]) == ""){
                                      $insert .= " null";
                                     }else{
 				      $insert .= "'".str_replace("'","",$array['ossoario_c_quadra'])."'";
                                     }
                                    $insert.= " , 'O')";
 $query1 = pg_query($dbportal,$insert);
 if($query1) {
  $inc++;
 }else{
  $ninc++;
  $str_erro = "\n O ERRO:".pg_errormessage()."\nSQL:".$insert."\n\n";
  system("echo \"$str_erro\" >> $arq");
 }

}

echo "\n --------------------\n";
echo "Quadracemit dos ossoarios";
echo "Incluidos: $inc \n";
echo "N�o Incluidos: $ninc";
echo "\n --------------------\n";

$inc   = 0;
$ninc  = 0;

//Jazigos
$sql = "select distinct jazigos.cemiterio_i_codigo,
               trim(upper(jazigo_c_quadra)) as jazigo_c_quadra
          from jazigos";
$query = pg_query($sam30,$sql);
$rows  = pg_num_rows($query);
echo "Total de Linhas: $rows \n";

for($x=0;$x<$rows;$x++){
 $array = pg_fetch_array($query);
 
 //quadracemit
  $insert = "insert into quadracemit(cm22_i_codigo,
      	    		             cm22_i_cemiterio,
				     cm22_c_quadra,
				     cm22_c_tipo)
                               values(nextval('quadracemit_cm22_i_codigo_seq'),";
				     if($array["cemiterio_i_codigo"] == ""){
                                      $insert .= "1,";
                                     }else{
 				      $insert .= $array["cemiterio_i_codigo"].",";
                                     }
			   	    if(trim($array["jazigo_c_quadra"]) == ""){
                                      $insert .= "''";
                                     }else{
 				      $insert .= "'".str_replace("'","",$array['jazigo_c_quadra'])."'";
                                     }
                                    $insert.= ", 'J')";
 $query1 = pg_query($dbportal,$insert);
 if($query1) {
  $inc++;
 }else{
  $ninc++;
  $str_erro = "\nJ ERRO:".pg_errormessage()."\nSQL:".$insert."\n\n";
  system("echo \"$str_erro\" >> $arq");
 }

}

echo "\n --------------------\n";
echo "Quadracemit dos jazigos";
echo "Incluidos: $inc \n";
echo "N�o Incluidos: $ninc";
echo "\n --------------------\n";

//pg_query($dbportal,"commit");
?>
