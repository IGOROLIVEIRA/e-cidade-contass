<?
//arreprescr k30_anulado is false
    $str_arquivo = $_SERVER['PHP_SELF'];
    set_time_limit(0);

    require(__DIR__ . "/../libs/db_stdlib.php");
    //require (__DIR__ . "/../libs/db_conn.php");
    echo "Conectando...\n";
    
    $DB_USUARIO = "postgres";
    $DB_SERVIDOR = "192.168.0.2";
    $DB_BASE = "auto_sap_20070725";
   
		//VARIAVEIS USADAS QUANDO NÃO EXISTIR ARREHIST PARA O REGISTRO
	    $dt_migracao = '2007-08-01';
		$usu_migracao = 1;
		$hrs_migracao = db_hora();
		$desc_migracao = "Migração";
    
    if(!($conn1 = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE user=$DB_USUARIO "))) {
      echo "erro ao conectar...\n";
      exit;
    }
    

    echo $str_hora = date( "h:m:s" );

    system( "clear" );

    echo "Selecionando.........\n";

    $erro = false;
    pg_exec( $conn1, "begin;");

    $str_sql = "select distinct x.k00_valor,x.k00_receit,x.k00_numpar,x.k00_numpre,arrehist.k00_id_usuario,arrehist.k00_hora,arrehist.k00_histtxt,arrehist.k00_dtoper as dthist 
		          from (select  distinct arrecant.k00_valor,arrecant.k00_receit,arrecant.k00_numpar,arrecant.k00_numpre,min(arrehist.k00_idhist) as idhist
								from arrecant 
								     left join arrecad       on arrecant.k00_numpre = arrecad.k00_numpre
																						 and arrecant.k00_numpar = arrecad.k00_numpar 
																						 and arrecant.k00_receit = arrecad.k00_receit 								 
										 left join arreprescr     on arrecant.k00_numpre = arreprescr.k30_numpre 
																						 and arrecant.k00_numpar = arreprescr.k30_numpar 
																						 and arrecant.k00_receit = arreprescr.k30_receit
																						 and arreprescr.k30_anulado is false 
								     left join arrepaga       on arrecant.k00_numpre = arrepaga.k00_numpre
																						 and arrecant.k00_numpar = arrepaga.k00_numpar 
																						 and arrecant.k00_receit = arrepaga.k00_receit 
										 left join cancdebitosreg on arrecant.k00_numpre = cancdebitosreg.k21_numpre 
																						 and arrecant.k00_numpar = cancdebitosreg.k21_numpar 
										 left join arrehist       on arrehist.k00_numpre = arrecant.k00_numpre 
																						 and arrehist.k00_numpar = arrecant.k00_numpar 
								where    (arreprescr.k30_numpre is null and arreprescr.k30_numpar is null and arreprescr.k30_receit is null )
										 and (arrepaga.k00_numpre is null   and arrepaga.k00_numpar is null   and arrepaga.k00_receit is null)
										 and (arrecad.k00_numpre is null   and arrecad.k00_numpar is null   and arrecad.k00_receit is null)
										 and (cancdebitosreg.k21_numpre is null and cancdebitosreg.k21_numpar is null) 
								group by arrecant.k00_valor,
						                 arrecant.k00_receit,
										 arrecant.k00_numpar,
										 arrecant.k00_numpre)as x left join arrehist on arrehist.k00_idhist = x.idhist


							";
	
    $res_select = pg_query( $conn1, $str_sql );
    $int_linhas = pg_num_rows( $res_select );    
		$numpre_ant = "";
    for( $i=0; $i<$int_linhas; $i++ ){
      db_fieldsmemory( $res_select, $i );
      system( "clear" );
      echo "Processando registro $i de $int_linhas!!";
			if ($numpre_ant != $k00_numpre){
				if ($dthist!=""){
					$dt_inc = $dthist;
					$usu_inc = $k00_id_usuario;
					$hrs_inc = $k00_hora;
					$descr_inc = substr($k00_histtxt,0,50)."";
				}else{
					$dt_inc = $dt_migracao;
					$usu_inc = $usu_migracao;
					$hrs_inc = $hrs_migracao;
					$descr_inc = "$desc_migracao";
				}
			  $seq_cancdebitos = pg_exec($conn1,"select nextval('cancdebitos_k20_codigo_seq')");
				$cod_cancdebitos = pg_result($seq_cancdebitos,0,0);
        $insert_cancdebitos = "insert into  cancdebitos (k20_codigo,k20_descr,k20_hora,k20_data,k20_usuario) 
										    values ($cod_cancdebitos,'$descr_inc','$hrs_inc','$dt_inc',$usu_inc)";
        $result_cancdebitos = pg_exec( $conn1, $insert_cancdebitos ) or die ($insert_cancdebitos);
         //	echo $insert_cancdebitos.";\n";
        if( $result_cancdebitos == false ){          
	        $erro = true;
				  $erromsg = pg_last_error();
          break;
        }    
		$seq_cancdebitosproc    = pg_exec($conn1,"select nextval('cancdebitosproc_k23_codigo_seq')");
        $cod_cancdebitosproc    = pg_result($seq_cancdebitosproc,0,0);
        $insert_cancdebitosproc = "insert into cancdebitosproc (k23_codigo,k23_hora,k23_data,k23_usuario,k23_obs) 
				                               values ($cod_cancdebitosproc,'$hrs_inc','$dt_inc',$usu_inc,'$descr_inc')";
        $result_cancdebitosproc = pg_exec( $conn1, $insert_cancdebitosproc ) or die ($insert_cancdebitosproc);
				//echo $insert_cancdebitosproc.";\n";
        if( $result_cancdebitosproc == false ){          
	        $erro = true;
				  $erromsg = pg_last_error();
          break;
        }    

  		  $numpre_ant = $k00_numpre;
			}else{
				if ($dthist!=""){
					$dt_inc = $dthist;
					$usu_inc = $k00_id_usuario;
					$hrs_inc = $k00_hora;
					$descr_inc = substr($k00_histtxt,0,50)."";
				}else{
					$dt_inc = $dt_migracao;
					$usu_inc = $usu_migracao;
					$hrs_inc = $hrs_migracao;
					$descr_inc = "$desc_migracao";
				}
			}
			$result_test = pg_exec("select * from cancdebitosreg where k21_numpre = $k00_numpre and k21_numpar = $k00_numpar");
			if (pg_numrows($result_test)>0){
				continue;
			}
			$seq_cancdebitosreg = pg_exec($conn1,"select nextval('cancdebitosreg_k21_sequencia_seq')");
      $cod_cancdebitosreg = pg_result($seq_cancdebitosreg,0,0);
      $insert_cancdebitosreg = "insert into cancdebitosreg 
			                      values ($cod_cancdebitosreg,$cod_cancdebitos,$k00_numpre,$k00_numpar,$k00_receit,'$dt_inc','$hrs_inc','$descr_inc')";
      $result_cancdebitosreg = pg_exec( $conn1, $insert_cancdebitosreg ) or die ($insert_cancdebitosreg);
			//echo $insert_cancdebitosreg.";\n";
      if( $result_cancdebitosreg == false ){          
	      $erro = true;
				$erromsg = pg_last_error();
        break;
      }    
			$seq_cancdebitosprocreg = pg_exec($conn1,"select nextval('cancdebitosprocreg_k24_sequencia_seq')");
      $cod_cancdebitosprocreg = pg_result($seq_cancdebitosprocreg,0,0);
      $insert_cancdebitosprocreg = "insert into cancdebitosprocreg 
			                      values ($cod_cancdebitosprocreg,$cod_cancdebitosproc,$cod_cancdebitosreg,'$k00_valor','$k00_valor','0','0','0')";
      $result_cancdebitosprocreg = pg_exec( $conn1, $insert_cancdebitosprocreg ) or die ($insert_cancdebitosprocreg);
			//echo $insert_cancdebitosprocreg.";\n";
      if( $result_cancdebitosprocreg == false ){          
	      $erro = true;				
				$erromsg = pg_last_error();
        break;
      }  
      
    }  
      
    if ($erro == false) {
       pg_exec($conn1, "commit;");
       echo "processamento ok...\n";
    }
    else {
       pg_exec($conn1, "rollback;");			
       echo "erro durante o processamento...\n $erromsg";
       exit;
    }
    echo "\n --------------------";
    echo "\n Inicio: $str_hora";
    echo "\n Fina..: ".date( "h:m:s" );
?>
