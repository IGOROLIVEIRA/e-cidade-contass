<?
 set_time_limit(0);
 require("db_fieldsmemory.php");
 require("db_conn.php");
 $str_arquivo = $_SERVER['PHP_SELF'];
 system( "clear" );
 echo "Conectando...\n";
 if(!($dbportal = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE       port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA")) ){
  echo "erro ao conectar...\n";
  exit;
 }
 if(!($sam30 = pg_connect("host=$DB_SERVIDOR_SAM30 dbname=$DB_BASE_SAM30 port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA")) ){
  echo "erro ao conectar...\n";
  exit;
 }
 $str_hora = date("H:i:s");

 //Sequencia
 pg_exec( $dbportal, "drop sequence causa_cm04_i_codigo_seq;" );
 pg_exec( $dbportal, "create sequence causa_cm04_i_codigo_seq start 1;" );
 pg_exec( $dbportal, "truncate causa;" );
// pg_exec( $dbportal, "begin;" );

 $str_sql = "select distinct sepultamento_c_causafalecimento from sepultamentos";

    $res_select = pg_query( $sam30, $str_sql ) or die ( "FALHA: $str_sql ");
    $int_linhas = pg_num_rows( $res_select );

    echo "Total de Linhas: $int_linhas \n";
    for( $i=0; $i<$int_linhas; $i++ ){
      db_fieldsmemory( $res_select, $i );

      $sql = "select nextval('causa_cm04_i_codigo_seq') as cm04_i_codigo ";
      $result = pg_exec( $dbportal, $sql );
      db_fieldsmemory( $result, 0 );

      $sepultamento_c_causafalecimento = str_replace( "'", "", $sepultamento_c_causafalecimento );
      
      $sql_causa = "insert into causa( cm04_i_codigo, cm04_c_descr )
                              values ( $cm04_i_codigo, '".trim($sepultamento_c_causafalecimento)."')";
      $res_causa = pg_exec( $dbportal, $sql_causa );
      
      if( $res_causa == false ){
      echo "Erro Inserindo causa:".$cm04_i_codigo." - ".$sepultamento_c_causafalecimento."\n";
	  echo $str_erro="Erro CAUSA: (".pg_errormessage().")";
	  system("echo \"$str_erro\" >> txt/cem_causas_erro.txt");
      }else{
       echo $cm04_i_codigo." - ".$sepultamento_c_causafalecimento."\n";
      }
      echo "$str_arquivo: $int_linhas -> $i\n";
    }
//    pg_exec( $dbportal, "commit;" );
    echo "\n --------------------\n";
    echo "Inicio: $str_hora\n";
    echo "Fim...: ".date( "H:i:s" )."\n";
?>