<?
    $str_arquivo = $_SERVER['PHP_SELF'];
    set_time_limit(0);

    require(__DIR__ . "/../libs/db_stdlib.php");
    require (__DIR__ . "/../libs/db_conn.php");
    echo "Conectando...\n";
    /*
    $DB_USUARIO = "postgres";
    $DB_SERVIDOR = "192.168.0.52";
    $DB_BASE = "auto_gua_20080716"; //auto_ara_20080708";
   */
		//VARIAVEIS USADAS QUANDO NÃO EXISTIR ARREHIST PARA O REGISTRO
	  $str_hora = date( "h:m:s" );
	  if(!($conn1 = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE user=$DB_USUARIO "))) {
      echo "erro ao conectar...\n";
      exit;
    }
    
	  echo $str_hora = date( "h:m:s" );

    system( "clear" );

    $erro = false;
    pg_exec( $conn1, "begin;");
		
		// criar campos e tabela nova.
		
		$sqlSeqArrevenclog = "CREATE SEQUENCE arrevenclog_k75_sequencial_seq
													INCREMENT 1
													MINVALUE 1
													MAXVALUE 9223372036854775807
													START 1
													CACHE 1 ";
    $rsSeqArrevenclog = pg_query($conn1, $sqlSeqArrevenclog);
		if($rsSeqArrevenclog == false ){          
	    $erro = true;				
			$erromsg = pg_last_error();
    } 
    $sqlSeqArrevenc = "CREATE SEQUENCE arrevenc_k00_sequencial_seq
													INCREMENT 1
													MINVALUE 1
													MAXVALUE 9223372036854775807
													START 1
													CACHE 1";
    $rsSeqArrevenc = pg_query($conn1, $sqlSeqArrevenc);
		if($rsSeqArrevenc == false ){          
	    $erro = true;				
			$erromsg = pg_last_error();
    } 
		
		$sqlCriaArrevenclog = "CREATE TABLE arrevenclog(
														k75_sequencial    int4 default 0,
														k75_instit    int4 default 0,
														k75_usuario   int4 default 0,
														k75_data    date default null,
														k75_hora    char(10) ,
														CONSTRAINT arrevenclog_sequ_pk PRIMARY KEY (k75_sequencial))";
		
		$rsCriaArrevenclog = pg_query($conn1, $sqlCriaArrevenclog);
		if($rsCriaArrevenclog == false ){          
	    $erro = true;				
			$erromsg = pg_last_error();
    } 
		
		$sqlFKArrevenclogInstit = "ALTER TABLE arrevenclog
															 ADD CONSTRAINT arrevenclog_instit_fk FOREIGN KEY (k75_instit)
															 REFERENCES db_config";
		
	  $rsFKArrevenclogInstit = pg_query($conn1, $sqlFKArrevenclogInstit);
		if($rsFKArrevenclogInstit == false ){          
	    $erro = true;				
			$erromsg = pg_last_error();
    } 
		
    $sqlFKArrevenclogUsuario = "ALTER TABLE arrevenclog
																ADD CONSTRAINT arrevenclog_usuario_fk FOREIGN KEY (k75_usuario)
																REFERENCES db_usuarios";
		$rsFKArrevenclogUsuario = pg_query($conn1, $sqlFKArrevenclogUsuario);
		if($rsFKArrevenclogUsuario == false ){          
	    $erro = true;				
			$erromsg = pg_last_error();
    } 
		
			
    $sqlCampoArrevenclog = "alter table arrevenc add k00_arrevenclog int4 ";
    $rsCampoArrevenclog = pg_query($conn1, $sqlCampoArrevenclog);
		if($rsCampoArrevenclog == false ){          
	    $erro = true;				
			$erromsg = pg_last_error();
    } 
  
		$instit = "";	
		$numpreAux = "";
		
		$sqlExcluiNulo = "delete from arrevenc where k00_numpre is null";
		$rsExcluiNulo = pg_query($conn1,$sqlExcluiNulo);
		if( $rsExcluiNulo == false ){          
		  $erro = true;				
			$erromsg = pg_last_error();
	  }			
		
		$sqlIncluiInstit = "insert into arreinstit (k00_numpre, k00_instit)
										       select distinct
										              arrevenc.k00_numpre,
										             (select codigo from db_config where prefeitura is true limit 1) as k00_instit
										       from arrevenc
										       left join arreinstit on arreinstit.k00_numpre = arrevenc.k00_numpre
										       where arreinstit.k00_numpre is null ";
    $rsIncluiInstit = pg_query($conn1,$sqlIncluiInstit);
		if( $rsIncluiInstit == false ){          
		  $erro = true;				
			$erromsg = pg_last_error();
	  }	
					
		$sSqlArrevencPacr ="select arrevenc.*, arreinstit.k00_instit 
		                     from arrevenc 
												 inner join arreinstit on arreinstit.k00_numpre = arrevenc.k00_numpre 
												 order by arreinstit.k00_instit";
		
    $rsSqlArrevencPacr = pg_query($conn1,$sSqlArrevencPacr);		
    $linhasSqlArrevencPacr = pg_num_rows($rsSqlArrevencPacr);    
		if($linhasSqlArrevencPacr > 0){
	    for( $i=0; $i<$linhasSqlArrevencPacr; $i++ ){
	      db_fieldsmemory( $rsSqlArrevencPacr, $i );
				echo "\n Processando registro $i de $linhasSqlArrevencPacr!!...";
				//echo "\n inst = $instit .... $k00_instit \n "; 
        if(	$numpreAux	!= $k00_numpre){
          $numpreAux = 	$k00_numpre;
          $sqlNext = "select nextval ('arrevenclog_k75_sequencial_seq') as seq";
		      $rsNext = pg_query($conn1, $sqlNext);
		      db_fieldsmemory($rsNext,0);
					$data = date("Y-m-d");
		      $hora = date("H:i");
		      $InsertArrevenclog = "insert into arrevenclog (k75_sequencial,k75_instit,k75_usuario,k75_data,k75_hora) 
		                                             values ($seq, $k00_instit, 1, '$data', '$hora')";
					$rsInsertArrevenclog = pg_query($conn1 , $InsertArrevenclog);		
					if( $rsInsertArrevenclog == false ){          
		            $erro = true;				
					      $erromsg = pg_last_error();
	              break;
	        }																	 
																							      
        }
					     
				if($k00_numpar == 0){	
					$sqlParc = "select distinct k00_numpre as numpre, k00_numpar as parcela
					              from arrecad 
												where k00_numpre = {$k00_numpre} 
											union 
											select distinct k00_numpre as numpre, k00_numpar as parcela
											  from arrecant 
		                    where k00_numpre = {$k00_numpre} 
											union 
											select distinct k00_numpre as numpre, k00_numpar as parcela
											  from arreold 
		                    where k00_numpre = {$k00_numpre} 	
											union 
											select distinct k00_numpre as numpre, k00_numpar as parcela
											  from arrepaga 
		                    where k00_numpre = {$k00_numpre} 	
											union 
											select distinct k00_numpre as numpre, k00_numpar as parcela
											  from arreforo 
		                    where k00_numpre = {$k00_numpre} 		
												";
					$rsParc = pg_query($conn1 , $sqlParc);
					$linhasParc = pg_num_rows($rsParc);
					if($linhasParc > 0){
						// deletar o registro dom a parcela 0 e incluir as outras
						$sqlExcluiParc = "delete from arrevenc where k00_numpre = $k00_numpre and k00_numpar = 0";
						//echo "\n $sqlExcluiParc \n"; 
						$rsExcluiParc = pg_query($conn1, $sqlExcluiParc);
						if( $rsExcluiParc == false ){          
		          $erro = true;				
					    $erromsg = pg_last_error();
	            break;
	          } 
									
						for($p=0;$p<$linhasParc;$p++){
							db_fieldsmemory($rsParc ,0);
							$sqlIncluiParc = "Insert into arrevenc (k00_arrevenclog,k00_numpre,k00_numpar,k00_dtini,k00_dtfim,k00_obs) 
							                                values ($seq,$numpre,$parcela,".($k00_dtini==''?'null':"'".$k00_dtini."'").",".($k00_dtfim==''?'null':"'".$k00_dtfim."'").",'$k00_obs')";
	           																		
							$rsIncluiParc = pg_query($conn1, $sqlIncluiParc);
						  if( $rsIncluiParc == false ){          
		            $erro = true;				
					      $erromsg = pg_last_error();
	              break;
	            }
							 
						}// for das parcelas
					}else{
						// se não encontou o numpre em nenhuma tabela... colocar parcela = 1
						$k00_obs .= ". Migração, parcela = 0 .";
						$sqlParcNulo = "update arrevenc set k00_arrevenclog = $seq, k00_numpar = 1, k00_obs = '".$k00_obs."' where k00_numpre = $k00_numpre and k00_numpar = 0";
						echo "\n\n $sqlParcNulo ";
					  $rsParcNulo = pg_query($conn1, $sqlParcNulo);
						  if( $rsParcNulo == false ){          
		            $erro = true;				
					      $erromsg = pg_last_error();
	              break;
	            } 
					}
					
				}else{
					// se não for parcela = 0 então tem que alterar o fk
					
					$sqlFK = "update arrevenc set k00_arrevenclog = $seq where k00_numpre = $k00_numpre and k00_numpar = $k00_numpar";
					$rsFK = pg_query($conn1, $sqlFK);
						  if( $rsFK == false ){          
		            $erro = true;				
					      $erromsg = pg_last_error();
	              break;
	            } 
							
				}
					
		
					
					
			}// do for de cima	
		}
		
		$sqlFKarrevenclog = "ALTER TABLE arrevenc
		ADD CONSTRAINT arrevenc_arrevenclog_fk FOREIGN KEY (k00_arrevenclog)
		REFERENCES arrevenclog";
		$rsFKarrevenclog  = pg_query($conn1, $sqlFKarrevenclog);
		if($rsFKarrevenclog == false ){          
	    $erro = true;				
			$erromsg = pg_last_error();
    } 
		
		// alterar as PK 
		$sqlCampoSequencial  = "alter table arrevenc add k00_sequencial int4  ";
		$rsCampoSequencial = pg_query($conn1, $sqlCampoSequencial);
		if($rsCampoSequencial == false ){          
	    $erro = true;				
			$erromsg = pg_last_error();
    }
		
    $sqlAlteraSeq = "update arrevenc set k00_sequencial = (nextval('arrevenc_k00_sequencial_seq'))";
		$rsAlteraSeq = pg_query($conn1, $sqlAlteraSeq);
		if($rsAlteraSeq == false ){          
	    $erro = true;				
			$erromsg = pg_last_error();
    } 
		
		$sqlPKarrevenc = "ALTER TABLE arrevenc
		ADD CONSTRAINT arrevenc_sequ_pk PRIMARY KEY (k00_sequencial)";
		$rsPKarrevenc = pg_query($conn1, $sqlPKarrevenc);
		if($rsPKarrevenc == false ){          
	    $erro = true;				
			$erromsg = pg_last_error();
    } 
		
		$sqlteste = "select count(*) from arrevenc where k00_numpar = 0";
		$rsTeste = pg_query($conn1,$sqlteste);
		db_fieldsmemory($rsTeste,0);
		
		echo "\n\n Numero de registros com parcela = 0 ... $count";
		if ($erro == false) {
      pg_exec($conn1, "commit;");
		  echo "\n\n processamento ok...\n";
	
    }else {
       pg_exec($conn1, "rollback;");			
       echo "\n\n erro durante o processamento...\n $erromsg";
       exit;
    }
    echo "\n --------------------";
    echo "\n Inicio: $str_hora";
    echo "\n Final..: ".date( "h:m:s" ) ."\n";
?>
