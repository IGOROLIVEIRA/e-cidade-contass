<?

  set_time_limit(0);

  require_once(__DIR__ . "/../libs/db_utils.php");
  require_once(__DIR__ . "/../libs/db_conn.php");
  
  $DB_USUARIO     = "postgres";
  $DB_SENHA       = "";
  $DB_SERVIDOR    = "192.168.0.20";
  $DB_BASE        = "canela_destino1";
  $DB_PORTA       = "5432";
  $lSqlErro       = false;
  $aListaIniciais = array();
  $iInstit        = 1;
  
  echo "\n\n Conectando ao servidor...\n\n";

  if(!($conn = pg_connect( "host=$DB_SERVIDOR  dbname=$DB_BASE  port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA")) ){
    echo "Erro ao conectar base {$DB_BASE}...\n";
    exit;
  }

  // Inicia sessão
  pg_query($conn,"select fc_startsession()");
  pg_query($conn,"select fc_putsession('DB_instit',{$iInstit})");
  
  
  // Inicício Transação
  pg_query($conn,"begin");
  
  $sSqlIdentificaInicial = "select v51_inicial,
	  								               count(v51_certidao)
		  							          from inicialcert 
		  							               left join termoini on termoini.inicial = inicialcert.v51_inicial
		  							         where termoini.inicial is null
 	  							             and v51_inicial not in ( select v51_inicial
																												  from inicialcert
																												 where v51_certidao in ( select certidao
																												                           from ( select v51_certidao as certidao,
																												                                         count(v51_inicial)
																												                                    from inicialcert
																												                                   group by v51_certidao
																												                                  having count(v51_inicial) > 1 ) as x ) 
 	  							                                    )    
										         group by v51_inicial
									          having count(v51_certidao) > 1  
  		  										 order by v51_inicial ";
  

  $rsIdentificaInicial   = pg_query($sSqlIdentificaInicial);
  $iNroIdentificaInicial = pg_num_rows($rsIdentificaInicial);  

  if ( $iNroIdentificaInicial > 0 ) {

  	echo "\n Consultando Dados Iniciais... \n";
  	
   	$aListaOrigens = array();
    
    for ( $iInd=0; $iInd < $iNroIdentificaInicial; $iInd++ ) {
      
      $oInicial = db_utils::fieldsMemory($rsIdentificaInicial,$iInd);

      $aListaIniciais[] = $oInicial->v51_inicial;
      
      $sSqlOrigem = "select x.*,
										        arrematric.k00_matric,
										        arreinscr.k00_inscr,
										        arrenumcgm.k00_numcgm
										   from ( select v51_certidao,
										                 inicial.*,
										                 case
										                   when v01_numpre is not null then v01_numpre
										                   else v07_numpre
										                 end as numpre
 										            from inicialcert
 										                 inner join inicial  on inicial.v50_inicial = v51_inicial
										                 left  join certdiv  on certdiv.v14_certid  = v51_certidao
										                 left  join divida   on v01_coddiv          = v14_coddiv
										                 left  join certter  on certter.v14_certid  = v51_certidao
										                 left  join termo    on v07_parcel          = v14_parcel
										           where v51_inicial = {$oInicial->v51_inicial} ) as x
										        left join arrematric on arrematric.k00_numpre = x.numpre
										        left join arreinscr  on arreinscr.k00_numpre  = x.numpre
										        left join arrenumcgm on arrenumcgm.k00_numpre = x.numpre";
      
      $rsOrigem   = pg_query($sSqlOrigem); 
      $iNroOrigem = pg_num_rows($rsOrigem);
      
      if ( $iNroOrigem > 0 ) {
      	
      	$aOrigemMatric = array();
	      $aOrigemInscr  = array();
        $aOrigemNumcgm = array();
        
      	for ( $iIndOrigem=0; $iIndOrigem < $iNroOrigem; $iIndOrigem++ ) {
      		
      		$oOrigem = db_utils::fieldsMemory($rsOrigem,$iIndOrigem);

      		$oDadosInicial = new stdClass();
      		$oDadosInicial->v50_inicial  = $oOrigem->v50_inicial;
      		$oDadosInicial->v50_advog    = $oOrigem->v50_advog; 
		      $oDadosInicial->v50_data     = $oOrigem->v50_data;
		      $oDadosInicial->v50_id_login = $oOrigem->v50_id_login;
		      $oDadosInicial->v50_codlocal = $oOrigem->v50_codlocal;
		      $oDadosInicial->v50_codmov   = '0';
		      $oDadosInicial->v50_instit   = $oOrigem->v50_instit; 
		      $oDadosInicial->v50_situacao = $oOrigem->v50_situacao;

		      
      		if ( trim($oOrigem->k00_matric) != '' ) {
     			  $aOrigemMatric[$oOrigem->k00_matric]['aCertidao'][]   = $oOrigem->v51_certidao;
     			  $aOrigemMatric[$oOrigem->k00_matric]['aNumpres'][]    = $oOrigem->numpre;
     			  $aOrigemMatric[$oOrigem->k00_matric]['oDadosInicial'] = $oDadosInicial;
      		} else if ( trim($oOrigem->k00_inscr) != '' ) {
      			$aOrigemInscr[$oOrigem->k00_inscr]['aCertidao'][]     = $oOrigem->v51_certidao;
      			$aOrigemInscr[$oOrigem->k00_inscr]['aNumpres'][]      = $oOrigem->numpre;
      			$aOrigemInscr[$oOrigem->k00_inscr]['oDadosInicial']   = $oDadosInicial;
      		} else {
            $aOrigemNumcgm[$oOrigem->k00_numcgm]['aCertidao'][]   = $oOrigem->v51_certidao;
            $aOrigemNumcgm[$oOrigem->k00_numcgm]['aNumpres'][]    = $oOrigem->numpre;
            $aOrigemNumcgm[$oOrigem->k00_numcgm]['oDadosInicial'] = $oDadosInicial;      			
      		}
      		
      	}
      	
      	
        if ( count($aOrigemMatric) > 0 ) {
          if ( count($aOrigemInscr) > 0 || count($aOrigemNumcgm) > 0 || count($aOrigemMatric) > 1) {
          	$aListaOrigens[] = $aOrigemMatric;
          }
          if ( count($aOrigemInscr) > 0) {
           $aListaOrigens[] = $aOrigemInscr;             
          }
	        if ( count($aOrigemNumcgm) > 0) {
	          $aListaOrigens[] = $aOrigemNumcgm;	                          
	        }
        } else if ( count($aOrigemInscr) > 0 ) {
          if ( count($aOrigemNumcgm) > 0 || count($aOrigemInscr) > 1 ) {
            $aListaOrigens[] = $aOrigemInscr;             
          }         
          if ( count($aOrigemNumcgm) > 0 ) {
            $aListaOrigens[] = $aOrigemNumcgm;
          }        	
        } else if ( count($aOrigemNumcgm) > 1 ) {
        	$aListaOrigens[] = $aOrigemNumcgm;
        }
      }
    }

    echo "\n Inserindo Iniciais Novas... \n";
    
    foreach ( $aListaOrigens as $iInd => $aDadosOrigem ) {
      
      if ( !$lSqlErro ) {

	      foreach ( $aDadosOrigem as $aDadosGerais ) {
	      	
	      	$oDadosInicial = $aDadosGerais['oDadosInicial'];
	      	
	      	// Insere nova inicial 
	      	$sSqlSeqInicial = " select nextval('inicial_v50_inicial_seq') as seq ";
	        $rsSeqInicial   = pg_query($sSqlSeqInicial);
	      	
	        if ( $rsSeqInicial) {
            $oSeqInicial = db_utils::fieldsMemory($rsSeqInicial,0);
            $iSeqInicial = $oSeqInicial->seq;	        	
	        } else {
            $lSqlErro = true;
            echo "ERRO:".pg_last_error();
            break;	        	
	        }
	        
	      	$sSqlInsereInicial = " insert into inicial (v50_inicial,
	      	                                            v50_data,
	      	                                            v50_advog,
	      	                                            v50_id_login,
	      	                                            v50_codlocal,
	      	                                            v50_codmov,
	      	                                            v50_instit,
	      	                                            v50_situacao)
	    	                                      values ({$iSeqInicial},
					    	                                      '{$oDadosInicial->v50_data}',
					    	                                      {$oDadosInicial->v50_advog},
					    	                                      {$oDadosInicial->v50_id_login},
					    	                                      {$oDadosInicial->v50_codlocal},
					    	                                      {$oDadosInicial->v50_codmov},
					    	                                      {$oDadosInicial->v50_instit},
					    	                                      {$oDadosInicial->v50_situacao}
	                                                   )";
	        
	        $rsInsereInicial = pg_query($sSqlInsereInicial);

	        if ( !$rsInsereInicial ) {
	        	$lSqlErro = true;
	        	echo "ERRO:".pg_last_error();
	        	break;
	        }

	        
	        $sSqlInsereInicialMov = "insert into inicialmov (v56_codmov,
	                                                         v56_inicial,
	                                                         v56_codsit,
	                                                         v56_obs,
	                                                         v56_data,
	                                                         v56_id_login) select nextval('inicialmov_v56_codmov_seq'),
	                                                                              {$iSeqInicial},
	                                                                              v56_codsit,
	                                                                              v56_obs,
	                                                                              v56_data,
	                                                                              v56_id_login
	                                                                         from inicialmov 
                                                                          where v56_inicial = {$oDadosInicial->v50_inicial}";
	        $rsInsereInicialMov = pg_query($sSqlInsereInicialMov);
	        
	        if ( !$rsInsereInicialMov ) {
            $lSqlErro = true;
            echo "ERRO:".pg_last_error();
            break;
          }	        
          
          $sSqlAcertaInicialMov = " update inicial 
                                       set v50_codmov  = ( select max(v56_codmov) 
                                                             from inicialmov 
                                                            where v56_inicial = {$iSeqInicial} )
                                     where v50_inicial = {$iSeqInicial} ";          
	        

          $rsAcertaInicialMov = pg_query($sSqlAcertaInicialMov);            
          
          if ( !$rsAcertaInicialMov ) {
            $lSqlErro = true;
            echo "ERRO:".pg_last_error();
            break;
          }       

          $sSqlInsereInicialForo = " insert into inicialcodforo (v55_inicial,
		  			                                                     v55_codforo,
			   		                                                     v55_data,
						                                                     v55_id_login,
						                                                     v55_codvara) select {$iSeqInicial},
												  			                                                     v55_codforo,
													 		                                                       v55_data,
																				                                             v55_id_login,
																				                                             v55_codvara
																				                                        from inicialcodforo
																				                                       where v55_inicial = {$oDadosInicial->v50_inicial}";
          
          $rsInsereInicialForo = pg_query($sSqlInsereInicialForo);

          if ( !$rsInsereInicialForo ) {
            $lSqlErro = true;
            echo "ERRO:".pg_last_error();
            break;
          }	        
	        
	        // Insere certidões na inicialnova ( inicialcert )
	        
          $aDadosGerais['aCertidao'] = array_unique($aDadosGerais['aCertidao']);
          
	      	foreach ( $aDadosGerais['aCertidao'] as $iCertidao ) {
	      		
	      		$sSqlInsereInicialCert = " insert into inicialcert (v51_inicial,
	      		                                                    v51_certidao)
	      		                                            values ({$iSeqInicial},
	      		                                                    {$iCertidao})";
	          
	          $rsInsereInicialCert = pg_query($sSqlInsereInicialCert);
	          
	      	  if ( !$rsInsereInicialCert ) {
	      	  	echo $sSqlInsereInicialCert;
	            $lSqlErro = true;
	            echo "ERRO:".pg_last_error();
	            break;
	          }	          
	      		
	      	}
	      	
	      	$aDadosGerais['aNumpres'] = array_unique($aDadosGerais['aNumpres']);
	      	
	      	// Insere numpres na nova inicial ( inicialnumpre )
      		foreach ( $aDadosGerais['aNumpres'] as $iNumpre ){
	      			
      			$sSqlInsereInicialNumpre = " insert into inicialnumpre (v59_inicial,
      			                                                        v59_numpre)
     			                                                  values ({$iSeqInicial},
     			                                                          {$iNumpre})";

            $rsInsereInicialNumpre = pg_query($sSqlInsereInicialNumpre);
            
            if ( !$rsInsereInicialNumpre ) {
              $lSqlErro = true;
              echo "ERRO:".pg_last_error();
              break;
            }       
      		}
	      }
      }
    }
    
    echo "\n Excluindo iniciais antigas... \n";
    
    foreach ($aListaIniciais as $iInicial) {

    	
      // Exclui codforo da inicial de origem
      $sSqlExcluiInicialCodForo = "delete 
                                     from inicialcodforo 
                                    where v55_inicial = {$iInicial}";
      $rsExcluiInicialCodForo   = pg_query($sSqlExcluiInicialCodForo);
      
      if ( !$rsExcluiInicialCodForo ) {
        $lSqlErro = true;
        echo "ERRO:".pg_last_error();
        break;
      }             
                
      // Exclui numpres da inicial de origem
      $sSqlExcluiInicialNumpre = "delete 
                                    from inicialnumpre 
                                   where v59_inicial = {$iInicial}";
      $rsExcluiInicialNumpre   = pg_query($sSqlExcluiInicialNumpre);
      
      if ( !$rsExcluiInicialNumpre ) {
        $lSqlErro = true;
        echo "ERRO:".pg_last_error();
        break;
      }       
          
      // Exclui certidões da inicial de origem
      $sSqlExcluiInicialCert = "delete 
                                  from inicialcert 
                                 where v51_inicial = {$iInicial}";
      $rsExcluiInicialCert   = pg_query($sSqlExcluiInicialCert);
                    
      if ( !$rsExcluiInicialCert ) {
        $lSqlErro = true;
        echo "ERRO:".pg_last_error();
        break;
      }       
      
      // Exclui movimentos da inicial de origem
      $sSqlExcluiInicialMov = "delete 
                              from inicialmov 
                             where v56_inicial = {$iInicial}";
      $rsExcluiInicialMov   = pg_query($sSqlExcluiInicialMov);

      if ( !$rsExcluiInicialMov ) {
        $lSqlErro = true;
        echo "ERRO:".pg_last_error();
        break;
      }       
      
      // Exclui inicial de origem
      $sSqlExcluiInicial = "delete 
                              from inicial 
                             where v50_inicial = {$iInicial}";
      $rsExcluiInicial   = pg_query($sSqlExcluiInicial);

      if ( !$rsExcluiInicial ) {
        $lSqlErro = true;
        echo "ERRO:".pg_last_error();
        break;
      }             
    }
    
  } else {
    echo "\n\n Nenhuma inicial encontrada! \n\n";
  }  

  if ( !$lSqlErro ) {
  	pg_query("commit");
		echo "\n Concluido com Sucesso!\n\n";	
  } else {
  	pg_query("rollback");
  	echo "\n Erro no acerto!\n\n";
  }
  	
?>