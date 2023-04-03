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
pg_query($dbportal,"drop sequence sepulturas_cm05_i_codigo_seq");
pg_query($dbportal,"drop sequence sepulta_cm24_i_codigo_seq");

pg_query($dbportal,"create sequence sepulturas_cm05_i_codigo_seq start 1") or die ('erro');
pg_query($dbportal,"create sequence sepulta_cm24_i_codigo_seq start 1") or die ('erro');

pg_query($dbportal,"truncate sepulta");
pg_query($dbportal,"truncate sepulturas");
//pg_query( $dbportal,"begin;");

$arq1 = "txt/cem_sepulturas_erro.txt";
$arq2 = "txt/cem_sepulta_erro.txt";
system( "clear" );
system("> $arq1");
system("> $arq2");

$inc1   = 0;
$ninc1  = 0;

$inc2   = 0;
$ninc2  = 0;

//SEPULTURAS
$sql = "select sepultura_i_codigo,
               sepultura_i_lote,
	       trim(upper(sepultura_c_quadra)) as sepultura_c_quadra,
               trim(upper(sepultura_c_campa)) as sepultura_c_campa,
               sepultura_d_entrada,
	       sepultamento_c_nome
          from sepulturas
         inner join sepultamentos on sepultamentos.sepultamento_i_codigo = sepulturas.sepultamento_i_codigo";
$query = pg_query($sam30,$sql);
$rows  = pg_num_rows($query);
echo "Total de Linhas: $rows \n";

for($x=0;$x<$rows;$x++){
 $array = pg_fetch_array($query);
 
//// SEPULTURAS

 //busca a campa
 $query_camp = pg_query($dbportal,"select cm19_i_codigo from campas where cm19_c_descr = '".trim(str_replace("'","",$array['sepultura_c_campa']))."'");
 $campa = pg_result($query_camp,0,0);

 //busca o lote
 $query_lote = pg_query($dbportal,"select cm23_i_codigo 
  			   	     from lotecemit
 			  	     inner join quadracemit on cm22_i_codigo = cm23_i_quadracemit
                                     where trim(cm22_c_quadra) = '".str_replace("'","",trim($array['sepultura_c_quadra']))."'
                                       and cm23_i_lotecemit = $array[sepultura_i_lote]");
 $lotecemit = pg_result($query_lote,0,0);
 
 $sepultura = pg_result(pg_query($dbportal,"select nextval('sepulturas_cm05_i_codigo_seq')"),0,0);
 $insert1 = "INSERT INTO sepulturas(cm05_i_codigo,
                                   cm05_c_numero, 
                                   cm05_i_campa,
                                   cm05_i_lotecemit)
                            VALUES ($sepultura,
			            $array[sepultura_i_codigo],
                                    $campa,
           			    $lotecemit)";
//die($insert1);
//echo '\n\n\n';
 $query1 = pg_query($dbportal,$insert1);
 if($query1) {
  $inc1++;
 }else{
  $ninc1++;
  $str_erro = "\nERRO:".pg_errormessage()."\nSQL:".$insert1."\n\n";
  system("echo \"$str_erro\" >> $arq1");
 }

 // SEPULTA
 $query_sepultamento = pg_query($dbportal, "select cm01_i_codigo 
                                               from sepultamentos
        				      inner join  cgm on z01_numcgm = cm01_i_codigo 
                                              where trim(z01_nome) = '".trim(str_replace("'","",$array[sepultamento_c_nome]))."'");
 $sepultamento = pg_result($query_sepultamento,0,0);
 $insert2 = "insert into sepulta (cm24_i_codigo,
				  cm24_i_sepultura,
				  cm24_i_sepultamento,
				  cm24_d_entrada)
			  VALUES (nextval('sepulta_cm24_i_codigo_seq'),
				  $sepultura,
				  $sepultamento,";	
			   if(trim($array['sepultura_d_entrada'])==""){
                                   $insert2 .= " null ";
                            }else{
                                   $insert2 .= "'$array[sepultura_d_entrada]'";
                            }
                           $insert2.= ")";
 $query2 = pg_query($dbportal,$insert2);
 if($query2) {
  $inc2++;
 }else{
  $ninc2++;
  $str_erro = "\nERRO:".pg_errormessage()."\nSQL:".$insert2."\n\n";
  system("echo \"$str_erro\" >> $arq2");
 }

}

echo "\n --------------------\n";
echo "sepulturas";
echo "Incluidos: $inc1 \n";
echo "N�o Incluidos: $ninc1";

echo "\n --------------------\n";
echo "sepulta";
echo "Incluidos: $inc2 \n";
echo "N�o Incluidos: $ninc2";
//pg_query($dbportal,"commit");
?>