<?
    $str_arquivo = $_SERVER['PHP_SELF'];
    set_time_limit(0);

    require(__DIR__ . "/../libs/db_stdlib.php");

    echo "Conectando...\n";
    
    $DB_USUARIO = "postgres";
    $DB_SERVIDOR = "192.168.0.41";
    $DB_BASE = "auto_bag_2107";
    
    
    if(!($conn1 = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE user=$DB_USUARIO "))) {
      echo "erro ao conectar...\n";
      exit;
    }
    

    echo $str_hora = date( "h:m:s" );

    system( "clear" );

    echo "Selecionando.........\n";

    $erro = false;
    pg_exec( $conn1, "begin;");

    $str_sql = "select distinct k00_numpre,k00_numpar,k00_valor,k00_dtvenc from arrecad left join issvar on q05_numpre = k00_numpre and q05_numpar = k00_numpar where k00_tipo = 3 and q05_codigo is null";
			 
    $res_select = pg_query( $conn1, $str_sql );
    $int_linhas = pg_num_rows( $res_select );    
    for( $i=0; $i<$int_linhas; $i++ ){
      db_fieldsmemory( $res_select, $i );
      echo "-----For posicao $i-----\n";
      $arr_data=split('-',$k00_dtvenc);
      $ano=$arr_data[0];
      $mes=$arr_data[1];      
      $res_sequencial = pg_exec($conn1,"select nextval('issvar_q05_codigo_seq')");
      $sequencial = pg_result($res_sequencial,0,0);
      $str_insert = "insert into issvar
                      values ($sequencial,$k00_numpre,$k00_numpar,$k00_valor,$ano,$mes,'',0,0,0)";
      $result = pg_exec( $conn1, $str_insert ) or die (cancelaTransacao($str_insert));
      if( $result == false ){          
	  $erro = true;
          break;
      }    

    }
    
    if ($erro == false) {
       pg_exec($conn1, "commit;");
       echo "processamento ok...\n";
    }
    else {
       pg_exec($conn1, "rollback;");
       echo "erro durante o processamento...\n";
       exit;
    }
    echo "\n --------------------";
    echo "\n Inicio: $str_hora";
    echo "\n Fina..: ".date( "h:m:s" );
?>
