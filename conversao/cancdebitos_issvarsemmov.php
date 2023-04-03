<?
    $str_arquivo = $_SERVER['PHP_SELF'];
    set_time_limit(0);

    require(__DIR__ . "/../libs/db_stdlib.php");
   // require (__DIR__ . "/../libs/db_conn.php");
       
    $DB_USUARIO = "postgres";
    $DB_SERVIDOR = "192.168.0.2";
    $DB_BASE = "auto_sap_20070725";
    

		//VARIAVEIS USADAS QUANDO NÃO EXISTIR ARREHIST PARA O REGISTRO
	 /*   $dt_migracao = '2007-08-01';
		$usu_migracao = 1;
		$hrs_migracao = db_hora();
		$desc_migracao = "Migração";
    */
    if(!($conn1 = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE user=$DB_USUARIO "))) {
      echo "erro ao conectar...\n";
      exit;
    }
    

    echo $str_hora = date( "h:m:s" );

    //system( "clear" );

    echo "Selecionando.........\n";
    $codigo ="";
    $erro = false;
    pg_exec( $conn1, "begin;");
    $sqlcodplan = "select w10_tipo from db_confplan";
    $resultcodplan = pg_query($sqlcodplan);
    db_fieldsmemory($resultcodplan,0);
    $sql = "
			select  cancdebitosproc.*, cancdebitosprocreg.*,cancdebitosreg.*,q50_seq,q05_codigo
			from cancdebitosreg 
				inner join cancdebitosprocreg on k24_cancdebitosreg = k21_sequencia
				inner join cancdebitosproc    on k24_codigo         = k23_codigo
				inner join issvar             on k21_numpre         = q05_numpre 
			                                 and k21_numpar         = q05_numpar 
			 	inner join arrecant           on k00_numpre         = q05_numpre 
							    		     and k00_numpar         = q05_numpar
				left  join issvarsemmovreg    on q05_codigo         = q15_issvar 
				left  join issvarlancval      on q50_numpre         = k00_numpre
				     						 and q50_numpar         = k00_numpar
			where 	q15_issvarsemmov is null
			      	and k00_tipo <> $w10_tipo
				    and q05_vlrinf=0
			order by k23_codigo 
 ";
	
    $result = pg_query( $conn1, $sql );
    $linhas = pg_num_rows( $result );    
	for( $i=0; $i<$linhas; $i++ ){
      db_fieldsmemory( $result, $i );
      //system( "clear" );
      echo "Processando registro $i de $linhas!! \n";
      
      if($codigo != $k23_codigo){
        $codigo = $k23_codigo;
        if($q50_seq ==""){
          //dbportal
          $tipo = 0;
        }else{
          //dbpref
          $tipo = 1;
        }
        // incluir na issvarsemmov
		$seq_semmov = pg_exec($conn1,"select nextval('issvarsemmov_q08_sequencial_seq')");
		$cod_semmov = pg_result($seq_semmov,0,0);
		//echo "\n issvarsemmov = $cod_semmov";
		$insert_semmov = "insert into issvarsemmov (q08_sequencial,q08_usuario,q08_data,q08_hora,q08_tipolanc)
								values($cod_semmov,$k23_usuario,'$k23_data','$k23_hora',$tipo)";
		$result_semmov = pg_exec( $conn1, $insert_semmov ) or die ($insert_semmov);
        if( $result_semmov == false ){          
	        $erro = true;
			$erromsg = pg_last_error();
            break;
        }
		//echo "\n $insert_semmov";
      }
      // incluir na issvarsemmovreg
      $seq_semmovreg = pg_exec($conn1,"select nextval('issvarsemmovreg_q15_sequencial_seq')");
	  $cod_semmovreg = pg_result($seq_semmovreg,0,0);
	//  echo "\n issvarsemmovreg = $cod_semmovreg";
      $insert_semmovreg = "insert into issvarsemmovreg (q15_sequencial,q15_issvarsemmov,q15_issvar)
								values($cod_semmovreg,$cod_semmov,$q05_codigo)";
      $result_semmovreg = pg_exec( $conn1, $insert_semmovreg ) or die ($insert_semmovreg);
	  if( $result_semmovreg == false ){          
	        $erro = true;
			$erromsg = pg_last_error();
            break;
        }
      
	}	
    if ($erro == false) {
       pg_exec($conn1, "commit;");
       echo "\n processamento ok...\n";
    }
    else {
       pg_exec($conn1, "rollback;");			
       echo "\n erro durante o processamento...\n $erromsg";
       exit;
    }

?>