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
pg_query( $dbportal, "drop sequence cem_legista_seq");
pg_query( $dbportal, "create sequence cem_legista_seq start 1;" );

pg_query( $dbportal, "truncate legista" );

$arq1 = "txt/cem_legista_erro.txt";
system( "clear" );
system("> $arq1");


$sql = "select *
          from sepultamentos";
$query = pg_query($sam30,$sql);
$rows  = pg_num_rows($query);
echo "Total de Linhas: $rows \n";

for($x=0;$x<$rows;$x++){

    $array = pg_fetch_array($query);

    $array["sepultamento_c_medico"]           = str_replace( "'", "", $array["sepultamento_c_medico"]);

    if(empty($array["sepultamento_c_medico"])){
     $str_erro = "Nome do médico legista inválido. sepultamento: $array[sepultamento_i_codigo]\n... Adotado o código do Legista 1... Migração!";
     system("echo \"$str_erro\" >> $arq1");
     continue;
    }

    $sql_cgm = "select z01_numcgm
                  from cgm
                 where trim(z01_nome) = '".trim($array["sepultamento_c_medico"])."'";
    $query_cgm = pg_query($dbportal,$sql_cgm);
    if(pg_num_rows($query_cgm) == 0){
      $cgm = pg_result(pg_query($dbportal,"select nextval('cgm_z01_numcgm_seq')"),0,0);
      $insert_cgm = "INSERT INTO cgm (z01_numcgm,z01_nome)
                           VALUES ($cgm,'".trim($array['sepultamento_c_medico'])."')";
      $query_cgm1 = pg_query($dbportal,$insert_cgm);
    }else{
      $cgm = pg_result($query_cgm,0,0);
    }

    $sql1 = "INSERT INTO legista (cm32_i_codigo,
                                  cm32_i_numcgm,
                                  cm32_i_crm)
                          VALUES (nextval('cem_legista_seq'),
                                  $cgm,
                                  $array[sepultamento_i_crmcro]
                                 )";

     $query1 = pg_query($dbportal,$sql1);
     if($query1){
      echo "\n".$x."Legista: Incluido\n";
      $inc++;
     }else{
      echo "\n".$x."Legista: Não Incluido\n";
      $ninc++;
      $str_erro = "\nERRO:".pg_errormessage()."\nSQL:".$sql1."\n\n";
      system("echo \"$str_erro\" >> $arq1");
     }

}
 echo "\n --------------------\n";
 echo "Legistas:\n";
 echo "Incluidos: $inc\n";
 echo "Não Incluidos: $ninc\n";
 //pg_query( $dbportal, "commit;" );
?>