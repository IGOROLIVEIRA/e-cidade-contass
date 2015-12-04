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
pg_query($dbportal,"drop sequence restos_old_cm12_i_codigo_seq");
pg_query($dbportal,"create sequence restos_old_cm12_i_codigo_seq start 1");
pg_query($dbportal,"truncate restos_old");
//pg_query($dbportal,"begin;");

$arq = "txt/cem_restos_old_erro.txt";
system( "clear" );
system("> $arq");

$sql = "select resto_i_codigo,
               ossoario_i_codigo,
               sepultamento_c_nome,
               resto_d_entrada
          from restos
         inner join sepultamentos on restos.sepultamento_i_codigo = sepultamentos.sepultamento_i_codigo";
$query = pg_query($sam30,$sql);
$rows  = pg_num_rows($query);
echo "Total de Linhas: $rows \n";
for($x=0;$x<$rows;$x++){
 $array = pg_fetch_array($query);
 $sql2 = "select cm01_i_codigo from sepultamentos
           inner join cgm on z01_numcgm = cm01_i_codigo
           where trim(z01_nome) = '".trim(str_replace("'","",$array['sepultamento_c_nome']))."'";
 $query2 = pg_query($dbportal,$sql2);
 $sepultamento = pg_result($query2,0,0);
  
   $ossoario = pg_result(pg_query($dbportal,"select ossoariojazigo from tmp_ossoariocod where ossoario_i_codigo =  $array[ossoario_i_codigo]"),0,0);

  $insert = "INSERT INTO restos_old(cm12_i_codigo,
				   cm12_i_resto,	
                                   cm12_i_ossoariopart,
                                   cm12_i_sepultamento,
                                   cm12_d_entrada)
                           VALUES (nextval('restos_old_cm12_i_codigo_seq'),
                                   $array[resto_i_codigo],
                                   $ossoario,
                                   $sepultamento,";
		  	   if(trim($array['resto_d_entrada'])==""){
                                   $insert .= " null ";
                           }else{
                                   $insert .= "'$array[resto_d_entrada]'";
                           }
                          $insert.= ")";
 $query3 = pg_query($dbportal,$insert);
 if($query3) {
  $inc++;
 }else{
  $ninc++;
  $str_erro = "\nERRO:".pg_errormessage()."\nSQL:".$insert."\n\n";
  system("echo \"$str_erro\" >> $arq");
 }
}
echo "Incluidos: $inc <br>";
echo "N�o Incluidos: $ninc";
//pg_query($dbportal,"commit");
?>