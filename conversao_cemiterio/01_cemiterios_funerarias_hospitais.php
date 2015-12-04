<?
  set_time_limit(0);
  require("db_fieldsmemory.php");
  require("db_conn.php");
  $str_arquivo = $_SERVER['PHP_SELF'];
  system( "clear" );
  echo "Conectando...\n";
  if(!($dbportal = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE       port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA")) )  {
   echo "erro ao conectar...\n";
   exit;
  }
  if(!($sam30 = pg_connect("host=$DB_SERVIDOR_SAM30 dbname=$DB_BASE_SAM30 port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA")) )  {
   echo "erro ao conectar...\n";
   exit;
  }
  $str_hora = date("H:i:s");

  //Sequencia
  pg_exec( $dbportal, "drop sequence cemiterio_cm14_i_codigo_seq");
  pg_exec( $dbportal, "create sequence cemiterio_cm14_i_codigo_seq start 1;" );

  //Truncando
  echo "Truncando........\n";
  pg_exec( $dbportal, "truncate cemiteriocgm" );
  pg_exec( $dbportal, "truncate cemiterio" );
  pg_exec( $dbportal, "truncate funerarias" );
  pg_exec( $dbportal, "truncate hospitais;" );
//  pg_exec( $dbportal, "begin;" );

  //cemiterio
  $query1 = pg_query($dbportal,"select z01_numcgm from cgm where trim(z01_nome) = 'CEMITERIO MUNICIPAL DE ALEGRETE'");
  if(pg_num_rows($query1)==0){
   $nextval_cgm   = pg_result(pg_query($dbportal,"select nextval('cgm_z01_numcgm_seq')"),0,0);
   pg_query($dbportal,"INSERT INTO cgm (z01_numcgm,z01_nome) VALUES ($nextval_cgm,'CEMITERIO MUNICIPAL DE ALEGRETE')");
   pg_query($dbportal,"INSERT INTO cemiterio values(1)");
   pg_query($dbportal,"INSERT INTO cemiteriocgm values(1,$nextval_cgm)");
  }else{
   $nextval_cgm = pg_result($query1,0,0);
   pg_query($dbportal,"INSERT INTO cemiterio values(1)");
   pg_query($dbportal,"INSERT INTO cemiteriocgm values(1,$nextval_cgm)");
  }

  $query1 = pg_query($dbportal,"select z01_numcgm from cgm where trim(z01_nome) = 'CEMITERIO DA PALMA'");
  if(pg_num_rows($query1)==0){
   $nextval_cgm = pg_result(pg_query($dbportal,"select nextval('cgm_z01_numcgm_seq')"),0,0);
   pg_query($dbportal,"INSERT INTO cgm (z01_numcgm,z01_nome) VALUES ($nextval_cgm,'CEMITERIO DA PALMA')");
   pg_query($dbportal,"INSERT INTO cemiterio values(2)");
   pg_query($dbportal,"INSERT INTO cemiteriocgm values(2,$nextval_cgm)");
  }else{
   $nextval_cgm = pg_result($query1,0,0);
   pg_query($dbportal,"INSERT INTO cemiterio values(2)");
   pg_query($dbportal,"INSERT INTO cemiteriocgm values(2,$nextval_cgm)");
  }
  


//funerarias
$query = pg_query($sam30, "select funeraria_c_nome from funerarias");
for($x=0; $x < pg_num_rows($query);$x++){
  $array = pg_fetch_array($query);
  $query1 = pg_query($dbportal,"select z01_numcgm from cgm where trim(z01_nome) = '".trim($array[0])."'");
  if(pg_num_rows($query1)==0){
   $nextval_cgm = pg_result(pg_query($dbportal,"select nextval('cgm_z01_numcgm_seq')"),0,0);
   pg_query($dbportal,"INSERT INTO cgm (z01_numcgm,z01_nome) VALUES ($nextval_cgm,'".trim($array[0])."')");
   pg_query($dbportal,"INSERT INTO funerarias values($nextval_cgm)");
  }else{
   $nextval_cgm = pg_result($query1,0,0);
   pg_query($dbportal,"INSERT INTO funerarias values($nextval_cgm)");
  }
}

  
  //hospitais
  $str_sql = "select * from hospitais";
  $res_select = pg_query( $sam30, $str_sql ) or die ( "FALHA: $str_sql ");
  $int_linhas = pg_num_rows( $res_select );
  echo "Total de Linhas: $int_linhas \n";
for( $i=0; $i<$int_linhas; $i++ ){
 db_fieldsmemory( $res_select, $i );
 $result = pg_exec($dbportal,"select * from cgm where trim(z01_nome) = '".trim($hospital_c_nome)."'");
 if(pg_num_rows($result) == 0 ){
  echo $hospital_c_nome;
  $numcgm     = pg_result(pg_query($dbportal,"select nextval('cgm_z01_numcgm_seq')"),0,0);
  $query_cgm  = pg_query($dbportal,"insert into cgm(z01_numcgm, z01_nome,           z01_ender,              z01_munic,            z01_bairro,
                                                    z01_uf,               z01_cep,           z01_telef)
     values ($numcgm,    '".trim($hospital_c_nome)."', '$hospital_c_endereco', '$hospital_c_cidade', '$hospital_c_bairro',
                                                    '$hospital_c_estado', '$hospital_c_cep', '$hospital_c_telefone')");
  $query_hosp = pg_query($dbportal,"insert into hospitais values ( $numcgm )");
  if( $query_cgm == false  or $query_hosp == false ){
   echo $str_erro="Erro HOSPITAIS: ($str_cgm) ($str_hosp)";
   system("echo \"$str_erro\" >> txt/cem_hospitais_erro.txt");
  }
  echo "$str_arquivo: $int_linhas -> $i\n";
 }
 else{
  $numcgm = pg_result($result,0,0);
  $query_hosp = pg_query($dbportal,"insert into hospitais values ( $numcgm )");
 }
}

echo "\n --------------------\n";
echo "Inicio: $str_hora\n";
echo "Fim...: ".date( "H:i:s" )."\n";
?>
