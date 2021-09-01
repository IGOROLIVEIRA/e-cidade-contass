<?
    $str_arquivo = $_SERVER['PHP_SELF'];
    set_time_limit(0);

    require(__DIR__ . "/../libs/db_stdlib.php");
    require (__DIR__ . "/../libs/db_conn.php");
    echo "Conectando...\n";
   /* 
    $DB_USUARIO = "postgres";
    $DB_SERVIDOR = "192.168.0.52";
    $DB_BASE = "auto_arr_20080718";
   */
		//VARIAVEIS USADAS QUANDO NÃO EXISTIR ARREHIST PARA O REGISTRO
		$ano = "2008";
	  $str_hora = date( "h:m:s" );
	 if(!($conn1 = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE user=$DB_USUARIO "))) {
      echo "erro ao conectar...\n";
      exit;
    }
    

    echo $str_hora = date( "h:m:s" );

    system( "clear" );

    echo "Selecionando.........\n";

    $erro = false;
    pg_exec( $conn1, "begin;");

   //corrigi registro dublicados na cancdebitosprocreg..
   $sqlCorrigiCanc = "select k21_sequencia,k21_numpre, k21_numpar, k21_receit ,min(k23_codigo) as codigo_proc
                      from cancdebitosreg
                      inner join cancdebitosprocreg on k24_cancdebitosreg = k21_sequencia
                      inner join cancdebitosproc    on k23_codigo         = k24_codigo
                      where k21_receit = 0 
                      group by k21_sequencia,k21_numpre, k21_numpar, k21_receit
                      having count(*) >1 
                      order by k21_numpre,k21_numpar;
                      ";
   $resultCorrigiCanc = pg_query($conn1,$sqlCorrigiCanc);                   
   $linhasCorrigiCanc = pg_num_rows($resultCorrigiCanc);
   $codigo_proc_aux = "";
   $codigo_proc_in  = "";
   $vir = "";
   if($linhasCorrigiCanc > 0){
     for($c=0;$c<$linhasCorrigiCanc;$c++){
       db_fieldsmemory($resultCorrigiCanc,$c); 
       $sqlMin = "select min(k24_sequencia) as codigo_procreg  
                  from cancdebitosprocreg 
                  inner join cancdebitosproc on k23_codigo=k24_codigo 
                  where k24_cancdebitosreg = {$k21_sequencia} ";
       $resultMin = pg_query($conn1,$sqlMin );
       $linhasMin = pg_num_rows($resultMin);
       if($linhasMin > 0){
         db_fieldsmemory($resultMin,0);
         echo "\n k21_sequencia = $k21_sequencia ... codigo_procreg = $codigo_procreg\n";
         $delMinProcreg = "delete from cancdebitosprocreg where k24_sequencia = {$codigo_procreg}";
         $resultMinProcreg = pg_query($conn1,$delMinProcreg);
        if( $resultMinProcreg == false ){          
	         $erro = true;
				   $erromsg = pg_last_error();
           break;
         }  
         if($erro == false){
           if( $codigo_proc_aux != $codigo_proc){
              $codigo_proc_aux = $codigo_proc;
              $codigo_proc_in .= $vir.$codigo_proc;
              $vir = ",";
           }
   
         }
       }
     }
     $sqlBuscaCod = "select distinct k23_codigo,k24_codigo 
                     from cancdebitosproc 
                     left join cancdebitosprocreg on k23_codigo=k24_codigo
                     where k23_codigo in({$codigo_proc_in})and k24_codigo is null";
     $resultBuscaCod = pg_query($conn1,$sqlBuscaCod);
     $linhasBuscaCod = pg_num_rows($resultBuscaCod);
     if($linhasBuscaCod >0){
       for($p=0;$p<$linhasBuscaCod;$p++){
         db_fieldsmemory($resultBuscaCod,$p);
         $delMinProc = "delete from cancdebitosproc where k23_codigo = {$k23_codigo}";
         $resultMinProc = pg_query($conn1,$delMinProc);
         if( $resultMinProc == false ){          
	         $erro = true;
		       $erromsg = pg_last_error();
           break;
         } 
       }
     }


   }


    $str_sql = "select cancdebitosreg.* , cancdebitosprocreg.*, k23_data  
		            from cancdebitosreg 
								inner join cancdebitosprocreg on k24_cancdebitosreg = k21_sequencia
								inner join cancdebitosproc    on k23_codigo         = k24_codigo 
								where k21_receit = 0  ";
		
    $res_select = pg_query( $conn1, $str_sql );
    $int_linhas = pg_num_rows( $res_select );    
    for( $i=0; $i<$int_linhas; $i++ ){
      db_fieldsmemory( $res_select, $i );
      //system( "clear" );
			
      //verificar se não existe registro duplicados na arrecant
      $sqlArrecant_duplo ="select k00_numpre,k00_numpar,k00_receit 
             from arrecant 
             where k00_numpre = $k21_numpre and k00_numpar= $k21_numpar 
             group by k00_numpre,k00_numpar,k00_receit 
             having count(*) >1 ";
      $resultArrecant_duplo= pg_query($conn1,$sqlArrecant_duplo );
      $linhasArrecant_duplo= pg_num_rows($resultArrecant_duplo);
      if($linhasArrecant_duplo > 0 ){
        $criaTable = "create temp table w_arrecant_duplo as 
                      select distinct * from arrecant 
                      where k00_numpre = $k21_numpre 
                        and k00_numpar=$k21_numpar ";
        $resultTable = pg_query($conn1,$criaTable);
        if( $resultTable == false ){          
	        $erro = true;
		      $erromsg = pg_last_error();
          break;
        } 
        $delArrecantDuplo = "delete from arrecant where k00_numpre = $k21_numpre and k00_numpar= $k21_numpar";
        $resultdelArrecantDuplo = pg_query($conn1,$delArrecantDuplo);
        if( $resultdelArrecantDuplo == false ){
          $erro = true;
          $erromsg = pg_last_error();
          break;
        }
        $incArrecant = "insert into arrecant select * from w_arrecant_duplo ";
        $resultincArrecant = pg_query($conn1,$incArrecant);
        if( $resultincArrecant == false ){
          $erro = true;
          $erromsg = pg_last_error();
          break;
        }
        $dropTemp = " drop  table w_arrecant_duplo ";
        $resultDropTemp = pg_query($conn1,$dropTemp);
        if( $resultDropTemp == false ){
          $erro = true;
          $erromsg = pg_last_error();
          break;
        }

      }

      echo "\n Processando registro $i de $int_linhas!!...cancdebitos = $k21_codigo reg =$k21_sequencia    N=$k21_numpre P=$k21_numpar R= $k21_receit";
					
			$sql_arrecant = "
			select k00_numpre,
             k00_numpar,
             k00_receit,
             sum(k00_valor) as k00_valor,
             sum(corrigido) as corrigido,
             round ( (sum(k00_valor) / 100 * sum(juros)) ,2) as valor_juros,
             round ( (sum(k00_valor) / 100 * sum(multa)) ,2) as valor_multa
      from ( select k00_numpre,
                    k00_numpar,
                    k00_receit,
                    k00_valor,
                    coalesce(fc_corre(k00_receit,k00_dtvenc,k00_valor,'$k23_data',$ano,'$k23_data') )as corrigido,
                    coalesce(fc_juros(k00_receit,k00_dtvenc,'$k23_data','$k23_data',false,$ano)) as juros,
                    coalesce(fc_multa(k00_receit,k00_dtvenc,'$k23_data',k00_dtoper,$ano)) as multa
             from arrecant 
             where k00_numpre = $k21_numpre and k00_numpar = $k21_numpar
             order by k00_numpar ) as x 
      group by k00_numpre, k00_numpar, k00_receit ";
      $res_arrecant = pg_query( $conn1, $sql_arrecant );
			$linhas_arrecant = pg_num_rows($res_arrecant );
			for($a=0;$a<$linhas_arrecant;$a++){
				db_fieldsmemory( $res_arrecant, $a );
				// incluir na cancdebitosreg
        $k21_obs = addslashes($k21_obs);
			  $seq_cancdebitosreg = pg_exec($conn1,"select nextval('cancdebitosreg_k21_sequencia_seq')");
			  $cod_cancdebitosreg = pg_result($seq_cancdebitosreg,0,0);
        $insert_cancdebitosreg = "insert into cancdebitosreg (k21_sequencia,k21_codigo,k21_numpre,k21_numpar,k21_receit,k21_data,k21_hora,k21_obs )
			                                                values ($cod_cancdebitosreg,$k21_codigo,$k00_numpre,$k00_numpar,$k00_receit,'$k21_data','$k21_hora','$k21_obs')";
        $result_cancdebitosreg = pg_exec( $conn1, $insert_cancdebitosreg ) or die ($insert_cancdebitosreg);
			  echo "\n Inclui na cancdebitosprocreg!!...cancdebitos = $k21_codigo reg =$cod_cancdebitosreg N=$k00_numpre P=$k00_numpar R= $k00_receit \n";
			  //echo "Inclui na cancdebitosprocreg \n $cod_cancdebitosreg,$k21_codigo,$k00_numpre,$k00_numpar,$k00_receit,'$k21_data','$k21_hora','$k21_obs' \n \n";
        if( $result_cancdebitosreg == false ){          
	        $erro = true;
				  $erromsg = pg_last_error();
          break;
        }  
			  
								
				// incluir na cancdebitosprocreg
			  $seq_cancdebitosprocreg = pg_exec($conn1,"select nextval('cancdebitosprocreg_k24_sequencia_seq')");
        $cod_cancdebitosprocreg = pg_result($seq_cancdebitosprocreg,0,0);
        $insert_cancdebitosprocreg = "insert into cancdebitosprocreg (k24_sequencia,k24_codigo,k24_cancdebitosreg,k24_vlrhis,k24_vlrcor,k24_juros,k24_multa,k24_desconto )
			                                                        values ($cod_cancdebitosprocreg,$k24_codigo,$cod_cancdebitosreg,$k00_valor,$corrigido,$valor_juros,$valor_multa,'0')";
        $result_cancdebitosprocreg = pg_exec( $conn1, $insert_cancdebitosprocreg ) or die ($insert_cancdebitosprocreg);
			  //echo "Inclui na cancdebitosprocreg \n $cod_cancdebitosprocreg,$k24_codigo,$cod_cancdebitosreg,$k00_valor,$corrigido,$valor_juros,$valor_multa,'0' \n \n";
        if( $result_cancdebitosprocreg == false ){          
	        $erro = true;				
				  $erromsg = pg_last_error();
          break;
        } 
				
			}// do for
			
			if($erro == false){
				//deleta da cancdebitosprocreg
				$sql_del_procreg = "delete from cancdebitosprocreg where k24_cancdebitosreg = $k21_sequencia";
				$result_del_procreg = pg_exec( $conn1,$sql_del_procreg );
				if( $result_del_procreg == false ){          
	        $erro = true;				
				  $erromsg = pg_last_error();
          break;
        } 
				//deleta da cancdebitosreg
			  $sql_del_reg = "delete from cancdebitosreg where k21_sequencia = $k21_sequencia";
				$result_del_reg = pg_exec( $conn1,$sql_del_reg );
				if( $result_del_reg == false ){          
	        $erro = true;				
				  $erromsg = pg_last_error();
          break;
        } 
			
			}
			
			
		}// do for de cima	
		//echo "\n\n erro == $erro \n\n";	
		//$erro = true;	      
    if ($erro == false) {
       pg_exec($conn1, "commit;");
       echo "processamento ok...\n";
    }else {
       pg_exec($conn1, "rollback;");			
       echo "erro durante o processamento...\n $erromsg";
       exit;
    }
    echo "\n --------------------";
    echo "\n Inicio: $str_hora";
    echo "\n Final..: ".date( "h:m:s" );
?>
