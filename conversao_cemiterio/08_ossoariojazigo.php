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

pg_exec( $dbportal, "drop table tmp_ossoariocod");
pg_exec( $dbportal, "create table tmp_ossoariocod(ossoario_i_codigo int, ossoariojazigo int)");
pg_exec( $dbportal, "drop sequence ossoariopart_cm02_i_codigo_seq" );
pg_exec( $dbportal, "create sequence ossoariopart_cm02_i_codigo_seq start 1" );
//pg_query( $dbportal, "begin;" );

$arq1 = "txt/cem_ossoariojazigo_erro.txt";
$arq2 = "txt/cem_propricemit_erro.txt";
$arq3 = "txt/cem_ossoariopart_erro.txt";
system( "clear" );
system("> $arq1");
system("> $arq2");
system("> $arq3");

$inc1  = 0;
$ninc1 = 0;

$inc2  = 0;
$ninc2 = 0;

$inc3  = 0;
$ninc3 = 0;

$sql   = "select ossoario_i_codigo,
                 ossoario_c_proprietario,
                 ossoario_c_quadra,
                 ossoario_i_lote,
                 ossoario_n_1metragem,
                 ossoario_n_2metragem,
                 ossoario_d_aquisicao,
                 ossoario_d_entrada,
                 cemiterio_i_codigo,
                 z02_proces
            from ossoarios";
$query = pg_query($sam30,$sql);
$rows  = pg_num_rows($query);
echo "Total de Linhas: $rows \n";
for($x=0;$x<$rows;$x++){
 $array     = pg_fetch_array($query);
 if(empty($array['ossoario_c_proprietario'])){
  $str_erro = "Nome do proprietario invï¿½lido. Ossoario: $array[ossoario_i_codigo]\n";
  system("echo \"$str_erro\" >> $arq1");
  continue;
 }

 /*
  Ossoariojazigo
 */
 
 //quadracemit
$sql_quadracemit = "select cm22_i_codigo 
                      from quadracemit 
                     where trim(cm22_c_quadra) ";
if(trim(str_replace(",","",$array['ossoario_c_quadra'])) == "" ){
 $sql_quadracemit.= " is null ";
}else{
 $sql_quadracemit.= " = '".trim(str_replace("'","",$array['ossoario_c_quadra']))."'";
}
 $sql_quadracemit.= " and cm22_i_cemiterio = ".$array['cemiterio_i_codigo'];
$quadracemit = pg_result(pg_query($dbportal,$sql_quadracemit),0,0);

 //lotecemit
$lotecemit = pg_result(pg_query($dbportal,"select cm23_i_codigo 
                                   from lotecemit 
                                   where cm23_i_quadracemit = $quadracemit                                   and cm23_i_lotecemit   = $array[ossoario_i_lote]"),0,0);

$ossoariojazigo = pg_result(pg_query($dbportal,"select nextval('ossoariojazigo_cm25_i_codigo_seq')"),0,0);

$sql_ossoariojazigo = "insert into ossoariojazigo(cm25_i_codigo,
                                                  cm25_c_numero,
                                                   cm25_i_lotecemit,
						   cm25_f_comprimento,
                                                   cm25_f_largura,
                                                   cm25_c_tipo)
                                            values($ossoariojazigo,
					           $array[ossoario_i_codigo],
                                                   $lotecemit,
                                                   $array[ossoario_n_1metragem], 
                                                   $array[ossoario_n_2metragem],
                                                   'O'
                                                   )";
 $query1 = pg_query($dbportal,$sql_ossoariojazigo);
 if($query1){
  $inc1++;
  echo $x."Ossoariojazigo: Incluido\n";
  $query_tmp = pg_query($dbportal,"insert into tmp_ossoariocod values($array[ossoario_i_codigo],$ossoariojazigo)");
 }else{
  $ninc1++;
  echo $x."Ossoariojazigo: Não Incluido\n";
  $str_erro = "\nERRO:".pg_result_error()."\nSQL:".$sql_ossoariojazigo."\n\n";
  system("echo \"$str_erro\" >> $arq1");
 }

 
 $sql_cgm   = "select z01_numcgm
                     from cgm
                    where trim(z01_nome) = '".trim(str_replace("'","",$array['ossaorio_c_proprietario']))."'
                    limit 1";
 $query_cgm = pg_query($dbportal,$sql_cgm);
 if(pg_num_rows($query_cgm) == 0){
  $cgm = pg_result(pg_query($dbportal,"select nextval('cgm_z01_numcgm_seq')"),0,0);
  $insert_cgm = "INSERT INTO cgm (z01_numcgm,z01_nome)
                       VALUES ($cgm,'".str_replace("'","",trim($array[1]))."')";
  $query_inc_cgm = pg_query($dbportal,$insert_cgm);
 }else{
  $cgm = pg_result($query_cgm,0,0);
 }

 /*
  Propricemit
 */
 if(trim($array['ossoario_c_proprietario']) != ""){
 $sql_propricemit = "insert into propricemit(cm28_i_codigo,
                                             cm28_i_processo,
                                             cm28_i_proprietario,
                                             cm28_i_ossoariojazigo,
                                             cm28_d_aquisicao)
                                      values(nextval('propricemit_cm28_i_codigo_seq'),";
                                       if(trim($array['z02_proces']) != ""){
                                        $sql_propricemit.=" $array[z02_proces]"; 
                                       }else{
                                        $sql_propricemit.= " null "; 
				       }
                        $sql_propricemit .= ",$cgm,                                                                              $ossoariojazigo, ";
                                      if(($array['ossoario_d_aquisicao']) != ""){
                                        $sql_propricemit .= " '$array[ossoario_d_aquisicao]' "; 
                                       }else{
                                        $sql_propricemit .= " null "; 
				       }
                                       $sql_propricemit .= ")";
 $query_propricemit = pg_query($dbportal,$sql_propricemit);
 if($query_propricemit){
  $inc2++;
  echo $x."propricemit: Incluido\n";
 }else{
  $ninc2++;
  echo $x."propricemit: Nï¿½o Incluido\n";
  $str_erro = "\nERRO:".pg_result_error()."\nSQL:".$sql_propricemit."\n\n";
  system("echo \"$str_erro\" >> $arq2");
 }
 }


 $sql2 = "INSERT INTO ossoariopart VALUES($ossoariojazigo,
                                   null,
                                   $cgm,
                                   '$array[ossoario_c_quadra]',
                                   $array[ossoario_i_lote],
                                   $array[ossoario_n_1metragem],
                                   $array[ossoario_n_2metragem],
                                   '$array[ossoario_d_aquisicao]',
                                   '$array[ossoario_d_aquisicao]'
                                   )";
 $query2 = pg_query($dbportal,$sql2);
 if($query2){
  $inc3++;
  echo $x."OssoarioPart: Incluido\n";
 }else{
  $ninc3++;
  echo $x."OssoarioPart: Nï¿½o Incluido\n";
  $str_erro = "\nERRO:".pg_result_error()."\nSQL:".$sql2."\n\n";
  system("echo \"$str_erro\" >> $arq3");
 }
}
echo "\n --------------------\n";
echo "Ossoariojazigo \n";
echo "Incluidos: $inc1 \n";
echo "Nï¿½o Incluidos: $ninc1";
echo "\n --------------------\n";

echo "propricemit \n";
echo "Incluidos: $inc2 \n";
echo "Nï¿½o Incluidos: $ninc2";
echo "\n --------------------\n";

echo "ossoariopart \n";
echo "Incluidos: $inc3 \n";
echo "Nï¿½o Incluidos: $ninc3";
echo "\n --------------------\n";

//pg_query( $dbportal, "commit;" );
?>
