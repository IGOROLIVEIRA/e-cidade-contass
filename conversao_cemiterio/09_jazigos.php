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
pg_exec( $dbportal, "drop table tmp_jazigocod" );
pg_exec( $dbportal, "create table tmp_jazigocod(jazigo_i_codigo int, ossoariojazigo int)");
pg_exec( $dbportal, "drop sequence jazigos_cm03_i_codigo_seq" );
pg_exec( $dbportal, "create sequence jazigos_cm03_i_codigo_seq start 1;" );
pg_exec( $dbportal, "truncate jazigos" );
//pg_query( $dbportal, "begin;" );
$arq1 = "txt/cem_ossoariojazigo_erro.txt";
$arq2 = "txt/cem_propricemit_erro.txt";
$arq3 = "txt/cem_proprijazigo_erro.txt";
$arq4 = "txt/cem_jazigos_erro.txt";
system( "clear" );
system("> $arq1");
system("> $arq2");
system("> $arq3");
system("> $arq4");

$inc1  = 0;
$ninc1 = 0;
$inc2  = 0;
$ninc2 = 0;
$inc3  = 0;
$ninc3 = 0;
$inc4  = 0;
$ninc4 = 0;

$sql = "select *
          from jazigos";
$query = pg_query($sam30,$sql);
$rows  = pg_num_rows($query);
echo "Total de Linhas: $rows \n";
for($x=0;$x<$rows;$x++){
$array = pg_fetch_array($query);
if(empty($array['jazigo_c_proprietario'])){
  $str_erro = "Nome do proprietario invï¿½lido. Ossoario: $array[jazigo_i_codigo]\n";
  system("echo \"$str_erro\" >> $arq");
  continue;
 }

/*
  Ossoariojazigo
 */
 
 //quadracemit
$sql_quadracemit = "select cm22_i_codigo 
                      from quadracemit 
                     where trim(cm22_c_quadra) ";
if(trim(str_replace(",","",$array['jazigo_c_quadra'])) == "" ){
 $sql_quadracemit.= " is null ";
}else{
 $sql_quadracemit.= " = '".trim(str_replace("'","",$array['jazigo_c_quadra']))."'";
}
 $sql_quadracemit.= " and cm22_i_cemiterio = ".$array['cemiterio_i_codigo'];
$quadracemit = pg_result(pg_query($dbportal,$sql_quadracemit),0,0);

 //lotecemit
$lotecemit = pg_result(pg_query($dbportal,"select cm23_i_codigo 
                                   from lotecemit 
                                   where cm23_i_quadracemit = $quadracemit                                   and cm23_i_lotecemit   = $array[jazigo_i_lote]"),0,0);

$ossoariojazigo = pg_result(pg_query($dbportal,"select nextval('ossoariojazigo_cm25_i_codigo_seq')"),0,0);

$sql_ossoariojazigo = "insert into ossoariojazigo(cm25_i_codigo,
                                                   cm25_i_lotecemit,
						   cm25_f_comprimento,
                                                   cm25_f_largura,
                                                   cm25_c_tipo)
                                            values($ossoariojazigo,
                                                   $lotecemit,
                                                   $array[jazigo_n_1metragem], 
                                                   $array[jazigo_n_2metragem],
                                                   'J')";
 $query1 = pg_query($dbportal,$sql_ossoariojazigo);
 if($query1){
  $inc1++;
  echo $x."Ossoariojazigo: Incluido\n";
  $query_tmp = pg_query($dbportal,"insert into tmp_jazigocod  values($array[jazigo_i_codigo],$ossoariojazigo)");
 }else{
  $ninc1++;
  echo $x."Ossoariojazigo: Não Incluido\n";
  $str_erro = "\nERRO:".pg_result_error()."\nSQL:".$sql_ossoariojazigo."\n\n";
  system("echo \"$str_erro\" >> $arq1");
 }


$sql_cgm   = "select z01_numcgm
                     from cgm
                    where trim(z01_nome) = '".trim(str_replace("'","",$array['jazigo_c_proprietario']))."'";
$query_cgm = pg_query($dbportal,$sql_cgm);
if(pg_num_rows($query_cgm) == 0){
 $cgm = pg_result(pg_query($dbportal,"select nextval('cgm_z01_numcgm_seq')"),0,0);
 $insert1 = "INSERT INTO cgm (z01_numcgm,z01_nome)
                    VALUES ($cgm,'".trim(str_replace("'","",$array['jazigo_c_proprietario']))."')";
 $query1 = pg_query($dbportal,$insert1);
}else{
 $cgm = pg_result($query_cgm,0,0);
}

/*
  Propricemit
 */
 if(trim($array['jazigo_c_proprietario']) != ""){
 $propricemit = pg_result(pg_query($dbportal,"select nextval('propricemit_cm28_i_codigo_seq')"),0,0);
 $sql_propricemit = "insert into propricemit(cm28_i_codigo,
                                             cm28_i_processo,
                                             cm28_i_proprietario,
                                             cm28_i_ossoariojazigo,
                                             cm28_d_aquisicao)
                                      values($propricemit,";
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

if(empty($array['jazigo_i_lote'])){
$array['jazigo_i_lote'] = 0;
}

 $insert_proprijazigo = "INSERT into proprijazigo (cm29_i_codigo,
                                                   cm29_i_propricemit,
                                                   cm29_i_termo,
                                                   cm29_d_termo,
                                                   cm29_t_termo,
                                                   cm29_i_concessao,
                                                   cm29_d_concessao,
                                                   cm29_t_concessao,
                                                   cm29_d_estrutura,
                                                   cm29_d_base,
                                                   cm29_d_pronto)
                                            values(nextval('proprijazigo_cm29_i_codigo_seq'),
                                                   $propricemit,
                                                   0,";
                                if(trim($array['jazigo_d_termo'])==""){
                                    $insert_proprijazigo .= " null,";
                                }else{
                                    $insert_proprijazigo .= "'$array[jazigo_d_termo]',";
                                }
                                $insert_proprijazigo .= "'$array[jazigo_c_termo]',
                                                         0,
                                                        ";
                                if(trim($array['jazigo_d_aquisicao'])==""){
                                    $insert_proprijazigo .= " null,";
                                }else{
                                    $insert_proprijazigo .= "'$array[jazigo_d_aquisicao]',";
                                }
                                $insert_proprijazigo .= "'$array[jazigo_c_carta]', null, null, null)";

 $query_proprijazigo = pg_query($dbportal, $insert_proprijazigo);
 if($query_proprijazigo){
  $inc3++;
 }else{
  $ninc3++;
  $str_erro = "\nERRO:".pg_errormessage()."\nSQL:".$insert2."\n\n";
  system("echo \"$str_erro\" >> $arq3");
 }

 $insert2 = "INSERT INTO jazigos VALUES(nextval('jazigos_cm03_i_codigo_seq'),
                                    $cgm,
                                    '$array[jazigo_c_termo]',";
				if(trim($array['jazigo_d_termo'])==""){
                                    $insert2 .= " null,";
                                }else{
                                    $insert2 .= "'$array[jazigo_d_termo]',";
                                }
				$insert2 .= "'$array[jazigo_c_carta]',";
				if(trim($array['jazigo_d_carta'])==""){
                                    $insert2 .= " null,";
                                }else{
                                    $insert2 .= "'$array[jazigo_d_carta]',";
                                }

				if(trim($array['jazigo_d_aquisicao'])==""){
                                    $insert2 .= " null,";
                                }else{
                                    $insert2 .= "'$array[jazigo_d_aquisicao]',";
                                }
                       $insert2 .=" '$array[jazigo_c_base]',
                                    '$array[jazigo_c_estrutura]',
                                    '$array[jazigo_c_pronto]',
                                    '$array[jazigo_c_quadra]',
                                    $array[jazigo_i_lote],
                                    $array[jazigo_n_1metragem],
                                    $array[jazigo_n_2metragem]
                                    )";
 $query2 = pg_query($dbportal,$insert2);
 if($query2){
  $inc4++;
 }else{
  $ninc4++;
  $str_erro = "\nERRO:".pg_errormessage()."\nSQL:".$insert2."\n\n";
  system("echo \"$str_erro\" >> $arq4");
 }
}
echo "\n --------------------\n";
echo "Incluidos: $inc1 \n";
echo "Nï¿½o Incluidos: $ninc1";

echo "\n --------------------\n";
echo "Incluidos: $inc2 \n";
echo "Nï¿½o Incluidos: $ninc2";

echo "\n --------------------\n";
echo "Incluidos: $inc3 \n";
echo "Nï¿½o Incluidos: $ninc3";

echo "\n --------------------\n";
echo "Incluidos: $inc4 \n";
echo "Nï¿½o Incluidos: $ninc4";

//pg_query( $dbportal, "commit;" );
?>