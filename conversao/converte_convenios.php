<?

  set_time_limit(0);

  require_once(__DIR__ . "/../libs/db_utils.php");
  require_once(__DIR__ . "/../libs/db_conn.php");
  
  
  //************** RODAR COM ROLLBACK ANTES PARA VERIFICAR INCONSISTÊNCIAS ***************************//
  
  $DB_USUARIO   = "postgres";
  $DB_SENHA     = "";
  $DB_SERVIDOR  = "192.168.0.2";
  $DB_BASE      = "auto_bage_20090429_v103";
  $DB_PORTA     = "5432";


  // Observações: Nos clientes Bagé, Sapiranga, Guaíba, Charqueadas, Alegrete e Itaqui deve ser visto antes de rodar o script
  // as triggers das tabelas modcarnepadrao, modcarnepadraotipo e modcarneexcessao. 
  
  
  echo "\n\n Conectando ao servidor...\n\n";

  if(!($conn = pg_connect( "host=$DB_SERVIDOR  dbname=$DB_BASE  port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA")) ){
    echo "Erro ao conectar base {$DB_BASE}...\n";
    exit;
  }

    
  // Inicício Transação
  pg_query($conn,"begin");

  
  
  $sSqlVerificaConflitos  = " select 'Regra Padrao'  as tipo,          ";
	$sSqlVerificaConflitos .= "	       k48_instit      as instituicao,   ";
	$sSqlVerificaConflitos .= "		     k48_cadtipomod  as tipo_modelo,   ";
	$sSqlVerificaConflitos .= "		     null            as tipo_debito,   ";
	$sSqlVerificaConflitos .= "		     null            as ip,            ";
	$sSqlVerificaConflitos .= "			   count(*)        as quantidade     ";
	$sSqlVerificaConflitos .= "   from modcarnepadrao                     ";
	$sSqlVerificaConflitos .= "	       left join modcarnepadraotipo on modcarnepadraotipo.k49_modcarnepadrao = modcarnepadrao.k48_sequencial   ";
	$sSqlVerificaConflitos .= "		where modcarnepadraotipo.k49_modcarnepadrao is null   ";
	$sSqlVerificaConflitos .= "   group by k48_instit,                                  ";
	$sSqlVerificaConflitos .= "		         k48_cadtipomod                               ";
	$sSqlVerificaConflitos .= "	 having count(*) > 1           ";
	$sSqlVerificaConflitos .= "	                           	   ";
	$sSqlVerificaConflitos .= "	union all                      ";
	$sSqlVerificaConflitos .= "        											   ";
	$sSqlVerificaConflitos .= "	select 'Regra por Tipo' as tipo,      ";
	$sSqlVerificaConflitos .= "	       k48_instit,                    ";
	$sSqlVerificaConflitos .= "	       k48_cadtipomod,                ";
	$sSqlVerificaConflitos .= "	       modcarnepadraotipo.k49_tipo,   ";
	$sSqlVerificaConflitos .= "	       null,                          ";
	$sSqlVerificaConflitos .= "	       count(*)                       ";
	$sSqlVerificaConflitos .= "	  from modcarnepadrao                 ";
	$sSqlVerificaConflitos .= "	       inner join modcarnepadraotipo on modcarnepadraotipo.k49_modcarnepadrao = modcarnepadrao.k48_sequencial   ";
	$sSqlVerificaConflitos .= "	       left  join modcarneexcessao   on modcarneexcessao.k36_modcarnepadraotipo = modcarnepadraotipo.k49_sequencial   ";
	$sSqlVerificaConflitos .= "	 where modcarneexcessao.k36_modcarnepadraotipo is null   ";
	$sSqlVerificaConflitos .= "	 group by k48_instit,                    ";
	$sSqlVerificaConflitos .= "	          modcarnepadraotipo.k49_tipo,   ";
	$sSqlVerificaConflitos .= "	          k48_cadtipomod                 ";   
	$sSqlVerificaConflitos .= " having count(*) > 1                      ";
	$sSqlVerificaConflitos .= "                        					         ";
	$sSqlVerificaConflitos .= "	union all                                ";
	$sSqlVerificaConflitos .= "	                             					   ";
	$sSqlVerificaConflitos .= "	select 'Regra por IP' as tipo,           ";
	$sSqlVerificaConflitos .= "	       k48_instit,                       ";
	$sSqlVerificaConflitos .= "	       k48_cadtipomod,                   ";
	$sSqlVerificaConflitos .= "	       modcarnepadraotipo.k49_tipo,      ";
	$sSqlVerificaConflitos .= "	       k36_ip,                           ";
	$sSqlVerificaConflitos .= "        count(*)                          ";
	$sSqlVerificaConflitos .= "   from modcarnepadrao                    ";
	$sSqlVerificaConflitos .= "	       inner join modcarnepadraotipo on modcarnepadraotipo.k49_modcarnepadrao = modcarnepadrao.k48_sequencial   ";
	$sSqlVerificaConflitos .= "	       inner join modcarneexcessao   on modcarneexcessao.k36_modcarnepadraotipo = modcarnepadraotipo.k49_sequencial   ";
	$sSqlVerificaConflitos .= "	 group by k48_instit,                  ";
	$sSqlVerificaConflitos .= "	       modcarnepadraotipo.k49_tipo,     ";
	$sSqlVerificaConflitos .= "	       k36_ip,                          ";
	$sSqlVerificaConflitos .= "	       k48_cadtipomod                   ";
	$sSqlVerificaConflitos .= "				 having count(*) > 1 ;            ";
  
	
  $rsConflitos      = pg_query($conn,$sSqlVerificaConflitos);
  $iLinhasConflitos = pg_num_rows($rsConflitos);
    
  if ( $iLinhasConflitos > 0 ) {
  	
    $sArquivo = "log_conflitos_modelos_".date("YmdHis").".txt";
    	
    db_log("Encontrado {$iLinhasConflitos} conflitos :  \n"                                          ,$sArquivo);
    db_log("\n"                                                                                      ,$sArquivo);
    db_log("+--------------+-------------+-------------+-------------+-----------------+-------------+\n",$sArquivo);
    db_log("      Tipo     | Instituição | Tipo Modelo | Tipo Débito |       IP        |  Quantidade  \n",$sArquivo);    
    db_log("+--------------+-------------+-------------+-------------+-----------------+-------------+\n",$sArquivo);

  	for ( $iInd=0; $iInd < $iLinhasConflitos; $iInd++ ) {
  		
  		$oConflitos = db_utils::fieldsMemory($rsConflitos,$iInd );
  	  
      db_log( str_pad($oConflitos->tipo       ,15," ",STR_PAD_BOTH)."|" ,$sArquivo);  
      db_log( str_pad($oConflitos->instituicao,13," ",STR_PAD_BOTH)."|" ,$sArquivo,0,false);
      db_log( str_pad($oConflitos->tipo_modelo,13," ",STR_PAD_BOTH)."|" ,$sArquivo,0,false);
      db_log( str_pad($oConflitos->tipo_debito,13," ",STR_PAD_BOTH)."|" ,$sArquivo,0,false);
      db_log( str_pad($oConflitos->ip         ,17," ",STR_PAD_BOTH)."|" ,$sArquivo,0,false);
      db_log( str_pad($oConflitos->quantidade ,13," ",STR_PAD_BOTH)."\n" ,$sArquivo,0,false);
      
      
  	}
  	
  }
  
  db_log("\n\n",$sArquivo);
  
  // Insere coluna k36_modcarnepadrao na tabela modcarneexcessao
  $sSqlAlteraEstrutura  = " ALTER TABLE modcarneexcessao ADD COLUMN  k36_modcarnepadrao INTEGER ; 																					   ";
  $sSqlAlteraEstrutura .= " ALTER TABLE modcarneexcessao ADD CONSTRAINT modcarneexcessao_modcarnepadrao_fk FOREIGN KEY (k36_modcarnepadrao) REFERENCES modcarnepadrao(k48_sequencial); ";

  
  // Insere registros na coluna k36_modcarnepadrao
  $sSqlAlteraEstrutura .= " UPDATE modcarneexcessao 					     ";
  $sSqlAlteraEstrutura .= "    SET k36_modcarnepadrao = k49_modcarnepadrao   ";
  $sSqlAlteraEstrutura .= "   FROM modcarnepadraotipo					     ";
  $sSqlAlteraEstrutura .= "  WHERE k49_sequencial = k36_modcarnepadraotipo ; ";

  // Cria Tabela temporária para alteração dos dados
  $sSqlAlteraEstrutura .= " CREATE TABLE w_nova_modcarneexcessao AS SELECT distinct k36_modcarnepadrao, ";
  $sSqlAlteraEstrutura .= "                                                         k36_ip				";
  $sSqlAlteraEstrutura .= "                                                    FROM modcarneexcessao;   ";
  
  $sSqlAlteraEstrutura .= " TRUNCATE modcarneexcessao; ";

  $sSqlAlteraEstrutura .= " SELECT  setval('modcarneexcessao_k36_sequencial_seq',1); ";

  $sSqlAlteraEstrutura .= " INSERT INTO modcarneexcessao ( k36_sequencial,    								      ";
  $sSqlAlteraEstrutura .= "                                K36_ip,												  ";
  $sSqlAlteraEstrutura .= "                                k36_modcarnepadrao  									  ";
  $sSqlAlteraEstrutura .= "                              ) select nextval('modcarneexcessao_k36_sequencial_seq'), ";
  $sSqlAlteraEstrutura .= "                                       K36_ip,										  ";
  $sSqlAlteraEstrutura .= "                                       k36_modcarnepadrao							  ";
  $sSqlAlteraEstrutura .= "                                  from w_nova_modcarneexcessao;						  ";

  $sSqlAlteraEstrutura .= " DROP TABLE w_nova_modcarneexcessao;  ";


  // Remove coluna k36_modcarnepadraotipo 

  $sSqlAlteraEstrutura .= " ALTER TABLE modcarneexcessao DROP COLUMN  k36_modcarnepadraotipo; ";

  // Insere coluna k48_cadconvenio na tabela modcarnepadrao

  $sSqlAlteraEstrutura .= " ALTER TABLE modcarnepadrao ADD  COLUMN  k48_cadconvenio INTEGER ; 																				 ";
  $sSqlAlteraEstrutura .= " ALTER TABLE modcarnepadrao ADD  CONSTRAINT modcarnepadrao_cadconvenio_fk FOREIGN KEY (k48_cadconvenio) REFERENCES cadconvenio(ar11_sequencial);  ";


  // Verificar migração
  	
  $sSqlAlteraEstrutura .= " INSERT INTO modcarnepadraocadmodcarne ( m01_sequencial,  																	   ";
  $sSqlAlteraEstrutura .= "                                         m01_cadmodcarne,    																   ";
  $sSqlAlteraEstrutura .= "                                         m01_modcarnepadrao )  select nextval('modcarnepadraocadmodcarne_m01_sequencial_seq'),  ";
  $sSqlAlteraEstrutura .= "                                                                      k48_cadmodcarne, 										   ";
  $sSqlAlteraEstrutura .= "                                                                      k48_sequencial   										   ";
  $sSqlAlteraEstrutura .= "                                                                 from modcarnepadrao ;  										   ";


  $sSqlAlteraEstrutura .= " ALTER TABLE modcarnepadrao DROP COLUMN  k48_cadmodcarne ;  ";

  
  pg_query($sSqlAlteraEstrutura);

  
  
  
  //**************************************************************************************//
  
  
  
  $sSqlBuscaBancoAgencia  = " select distinct lpad(trim(k15_codbco),3,'0') as k15_codbco, ";
  $sSqlBuscaBancoAgencia .= "                 k15_codage                         		      ";
  $sSqlBuscaBancoAgencia .= "            from ( select k15_codbco,                		    ";
  $sSqlBuscaBancoAgencia .= "                          k15_codage,               		      ";
  $sSqlBuscaBancoAgencia .= "                          count(*)                  		      ";
  $sSqlBuscaBancoAgencia .= "                     from disarq                    		      ";
  $sSqlBuscaBancoAgencia .= "                    where dtarquivo >= '2008-01-01'  	   	  ";
  $sSqlBuscaBancoAgencia .= "                  group by k15_codbco,               		    ";
  $sSqlBuscaBancoAgencia .= "                           k15_codage               		      ";
  $sSqlBuscaBancoAgencia .= "                    having count(*) > 5 ) as x       		    ";
  
  $rsBuscaBancoAgencia	      = pg_query($sSqlBuscaBancoAgencia);
  $iNroLinhaBuscaBancoAgencia = pg_num_rows($rsBuscaBancoAgencia);
  
  if ( $iNroLinhaBuscaBancoAgencia > 0 ) {
  	
		for ( $i=0; $i < $iNroLinhaBuscaBancoAgencia; $i++ ) {
	  	  
		  $oBuscaBancoAgencia = db_utils::fieldsMemory($rsBuscaBancoAgencia,$i);
		  
		  $iCodAgencia = substr($oBuscaBancoAgencia->k15_codage,0,strlen($oBuscaBancoAgencia->k15_codage)-1);
		  $iCodAgencia = str_replace("-","",$iCodAgencia);
		  $iCodDigito  = substr($oBuscaBancoAgencia->k15_codage,strlen($oBuscaBancoAgencia->k15_codage)-1,1);
		  
	  	  $sSqlInsereBancoAgencia = " insert into bancoagencia ( db89_sequencial,
	  														     db89_db_bancos,
	  														     db89_codagencia,
	  														     db89_digito 				
	  	                                                       ) values (
	  	                                                         (select nextval('bancoagencia_db89_sequencial_seq')),
	  	                                                         '{$oBuscaBancoAgencia->k15_codbco}',
	  	                                                         '{$iCodAgencia}',
	  															 '{$iCodDigito}'	
	  	                                                       )";
	  	                                                         
	  	  pg_query($conn,$sSqlInsereBancoAgencia);
		 
	  	  
		}
	
  }
  
  
  // Consulta Instituições 
  $sSqlConfig       = " select * 		   "; 
  $sSqlConfig      .= " 	from db_config ";

  $rsConfig 		= pg_query($conn,$sSqlConfig); 
  $iNroLinhasConfig = pg_num_rows($rsConfig);

  
  
  
  
  // For principal por instituições
  for ($i=0; $i < $iNroLinhasConfig; $i++){
	
  	$oConfig = db_utils::fieldsMemory($rsConfig,$i);

  	echo "\n\n +--------------------------------------------------------------------+ \n\n";
	echo " Código Instituição: {$oConfig->codigo} \n";
	echo " Nome   Instituição: {$oConfig->nomeinst} \n";

  	/******************************************************** COBRANÇA ************************************************************/
  	
  	
	$sSqlModCarnePadraoCobranca  = "select lpad(trim(k15_codbco),3,'0') as k15_codbco,                                                                          ";
	$sSqlModCarnePadraoCobranca .= "       k15_codage,                                                                                                          ";	
	$sSqlModCarnePadraoCobranca .= "       k15_conv1,                                                                                                           ";
	$sSqlModCarnePadraoCobranca .= "       k15_carte,                                                                                                           ";		
	$sSqlModCarnePadraoCobranca .= "       k15_seq,                                                                                                             ";
	$sSqlModCarnePadraoCobranca .= "       k15_seq1,                                                                                                            ";
	$sSqlModCarnePadraoCobranca .= "       k15_seq2,                                                                                                            ";
	$sSqlModCarnePadraoCobranca .= "       k15_seq3,                                                                                                            ";
	$sSqlModCarnePadraoCobranca .= "       k15_seq4,                                                                                                            ";
	$sSqlModCarnePadraoCobranca .= "       k15_seq5,                                                                                                            ";
	$sSqlModCarnePadraoCobranca .= "       k15_ceden1,                                                                                                          ";		
	$sSqlModCarnePadraoCobranca .= "       k48_sequencial                                                                                                       ";
	$sSqlModCarnePadraoCobranca .= "  from modcarnepadrao                                                                                                       ";
	$sSqlModCarnePadraoCobranca .= "       inner join  modcarnepadraocobranca on  modcarnepadraocobranca.k22_modcarnepadrao = modcarnepadrao.k48_sequencial     ";
	$sSqlModCarnePadraoCobranca .= "       inner join  cadban                 on  cadban.k15_codigo                         = modcarnepadraocobranca.k22_cadban ";
	$sSqlModCarnePadraoCobranca .= " where k48_instit = {$oConfig->codigo}																						";	
  	
	$rsModCarnePadraoCobranca 	     = pg_query($conn,$sSqlModCarnePadraoCobranca);  	
  	$iNroLinhaModCarnePadraoCobranca = pg_num_rows($rsModCarnePadraoCobranca);
	 

  	// Insere registros referentes a cobrança ( bancoagencia, cadconvenio, conveniocobranca )
  	
  	for ($x=0; $x < $iNroLinhaModCarnePadraoCobranca; $x++) {
  	  
  	  $oModCarnePadraoCobranca = db_utils::fieldsMemory($rsModCarnePadraoCobranca,$x);	
  	  
  	  $iCodAgencia = substr($oModCarnePadraoCobranca->k15_codage,0,strlen($oModCarnePadraoCobranca->k15_codage)-1);
	  $iCodAgencia = str_replace("-","",$iCodAgencia);
	  $iCodDigito  = substr($oModCarnePadraoCobranca->k15_codage,strlen($oModCarnePadraoCobranca->k15_codage)-1,1);  	  
  	  
  	  $sSqlVerificaBancoAgencia = " select db89_sequencial 
  	  								  from bancoagencia
  	  								 where db89_db_bancos  = '{$oModCarnePadraoCobranca->k15_codbco}'
  	  								   and db89_codagencia = '{$iCodAgencia}'	 
  	  								   and db89_digito     = '{$iCodDigito}'"; 
		  	  
  	  								   
  	  								   
	  $rsVerificaBancoAgencia   	 = pg_query($sSqlVerificaBancoAgencia);
	  $iNroLinhaVerificaBancoAgencia = pg_num_rows($rsVerificaBancoAgencia); 

	  
  	  
	  
	  if ( $iNroLinhaVerificaBancoAgencia > 0) {
	  	$oVerificaBancoAgencia = db_utils::fieldsMemory($rsVerificaBancoAgencia,0);
		$iCodBancoAgencia      = $oVerificaBancoAgencia->db89_sequencial; 
	  	
	  } else {
  	    // Acha Sequencial da tabela bancoagencia ( Cobrança )
  	    $sSqlSeqBancoAgencia = "select nextval('bancoagencia_db89_sequencial_seq') as sequencial";
  	    $rsSeqBancoAgencia   = pg_query($conn,$sSqlSeqBancoAgencia);
  	    $oSeqBancoAgencia	 = db_utils::fieldsMemory($rsSeqBancoAgencia,0); 

  	  	$iCodAgencia = substr($oModCarnePadraoCobranca->k15_codage,0,strlen($oModCarnePadraoCobranca->k15_codage)-1);
	    $iCodAgencia = str_replace("-","",$iCodAgencia);
	    $iCodDigito  = substr($oModCarnePadraoCobranca->k15_codage,strlen($oModCarnePadraoCobranca->k15_codage)-1,1);
  	    
  	    
   	    // Insere bancoagencia ( Cobrança )
  	    $sSqlInsereBancoAgencia = " insert into bancoagencia ( db89_sequencial,
  														       db89_db_bancos,
  														       db89_codagencia,
  														       db89_digito 				
  	                                                         ) values (
  	                                                           {$oSeqBancoAgencia->sequencial},
  	                                                           '{$oModCarnePadraoCobranca->k15_codbco}',
  	                                                           '{$iCodAgencia}',
  															   '{$iCodDigito}'	
  	                                                         )";
  	                                                          
 	    pg_query($conn,$sSqlInsereBancoAgencia);

	  	$iCodBancoAgencia = $oSeqBancoAgencia->sequencial;	
	  	
	  }
  	  								   
  	  
	  
	  $sSqlVerificaConvenio = " select ar13_cadconvenio 
	  							  from conveniocobranca
	  							  	   inner join cadconvenio on ar11_sequencial = ar13_cadconvenio 
	  							 where ar13_bancoagencia = {$iCodBancoAgencia}
	  							   and ar13_carteira     = {$oModCarnePadraoCobranca->k15_carte}
	  							   and ar13_convenio     = {$oModCarnePadraoCobranca->k15_conv1}
	  							   and ar13_cedente      = {$oModCarnePadraoCobranca->k15_ceden1}
	  							   and ar13_variacao     = ".(empty($oModCarnePadraoCobranca->k15_seq)?0:$oModCarnePadraoCobranca->k15_seq)."
	  							   and ar11_instit 		 = {$oConfig->codigo}";   
	  
     $rsVerificaConvenio = pg_query($conn,$sSqlVerificaConvenio);	  							   
	 $iNroLinhaVerificaConvenio = pg_num_rows($rsVerificaConvenio);							   
	  							   

     // Verifica se já existe convenio cadastrado
     
     if ($iNroLinhaVerificaConvenio > 0) {
     
     	$oVerificaConvenio = db_utils::fieldsMemory($rsVerificaConvenio,0);
     	$iCodConvenio	   = $oVerificaConvenio->ar13_cadconvenio;
     	
     } else {	

  	  // Descobre o tipo de convênio :  4 = (BSJ)  e  6 ou 7 = (BDL) 
  	  if (strlen(trim($oModCarnePadraoCobranca->k15_conv1)) == 4) {
  	  	
  	  	$iTipoConvenio = 2;
  	  	
  	  } else if (strlen(trim($oModCarnePadraoCobranca->k15_conv1)) == 6 || strlen(trim($oModCarnePadraoCobranca->k15_conv1)) == 7){
  	  	
  	  	$iTipoConvenio = 1;
  	  	
  	  } else {
  	  	
  	  	echo "\n\n Erro: Convênio difere de 4,6 ou 7 posições! k15_conv: {$oModCarnePadraoCobranca->k15_conv1} \n\n";
  	  	exit;
  	  	
  	  }
  	  
  	  // Acha Sequencial da tabela cadconvenio ( Cobrança )
  	  $sSqlSeqCadConvenio = "select nextval('cadconvenio_ar11_sequencial_seq') as sequencial";
  	  
  	  $rsSeqCadConvenio   = pg_query($conn,$sSqlSeqCadConvenio);
  	  $oSeqCadConvenio    = db_utils::fieldsMemory($rsSeqCadConvenio,0);  	  
  	  $iCodCadConvenio	  = $oSeqCadConvenio->sequencial; 
  	  
  	  // Insere cadconvenio ( Cobrança )
  	  $sSqlInsereCadConvenio = " insert into cadconvenio ( ar11_sequencial,
														   ar11_cadtipoconvenio,
														   ar11_instit,
													       ar11_nome
  	                                                     ) values (
  	                                                       {$iCodCadConvenio},
  	                                                       {$iTipoConvenio},
  	                                                       {$oConfig->codigo},
  	                                                       'CONVENIO COBRANCA '		  	                 									                                   														
  	  													 )";
	  pg_query($conn,$sSqlInsereCadConvenio);

     }
	  
  	  // Acha Sequencial da tabela conveniocobranca ( Cobrança )
  	  $sSqlSeqConvenioCobranca = "select nextval('conveniocobranca_ar13_sequencial_seq') as sequencial";
  	  $rsSeqConvenioCobranca   = pg_query($conn,$sSqlSeqConvenioCobranca);
  	  $oSeqConvenioCobranca    = db_utils::fieldsMemory($rsSeqConvenioCobranca,0);  	  
	  
	  
	  // Insere conveniocobranca  	  
	  $sSqlInsereConvenioCobranca = " insert into conveniocobranca ( ar13_sequencial,
	  																 ar13_bancoagencia,
	  																 ar13_cadconvenio,
	  																 ar13_carteira,
	  																 ar13_convenio,
	  																 ar13_cedente,
	  																 ar13_especie,
	  																 ar13_variacao
	  															   ) values (
	  															     {$oSeqConvenioCobranca->sequencial},
  																	 {$iCodBancoAgencia},
  																	 {$iCodCadConvenio},
  																	 '{$oModCarnePadraoCobranca->k15_carte}',
  																	 '{$oModCarnePadraoCobranca->k15_conv1}',
  																	 '{$oModCarnePadraoCobranca->k15_ceden1}',
  																	 '',
  																	 ".(empty($oModCarnePadraoCobranca->k15_seq)?0:$oModCarnePadraoCobranca->k15_seq)."
  																   )";
	  															   
	  pg_query($conn,$sSqlInsereConvenioCobranca);
  	
	  
	  
	  // Insere conveniocobrancaseq
	  
	  for($iSeq=1; $iSeq < 6; $iSeq++){
	  	if ($oModCarnePadraoCobranca->k15_seq{$iSeq} != 0){
	      $sSqlInsereConvenioCobrancaSeq = " insert into conveniocobrancaseq ( ar20_sequencial,
		  																       ar20_conveniocobranca,
		  																       ar20_sequencia,
		  																       ar20_valor
		  															         ) values (
	  																   	       (select nextval('conveniocobrancaseq_ar20_sequencial_seq')),
	  																	       {$oSeqConvenioCobranca->sequencial},
	  																	      '{$iSeq}',
	  																	       {$oModCarnePadraoCobranca->k15_seq{$iSeq}}
		  															         )";
	      pg_query($conn,$sSqlInsereConvenioCobrancaSeq);
	  	}	  
	  }
	  
	  
	  
	  
	  
	  // Altera tabela modcarnepadrao
	  
	  $sSqlAlteraModCarnePadrao  = " update modcarnepadrao set k48_cadconvenio = {$iCodCadConvenio} 		"; 
	  $sSqlAlteraModCarnePadrao .= "  where k48_sequencial = {$oModCarnePadraoCobranca->k48_sequencial}     ";							
	  
	  pg_query($conn,$sSqlAlteraModCarnePadrao);
	  
  	}
  	echo "\n Insere {$x} registros na cobrança \n";

  	
  	
  	
  	
  	
  	/********************************************************** ARRECADAÇÃO *******************************************************/


  	// Insere registros referente a arrecadação ( cadconvenio,convenioarrecadacao,cadarrecadacao )
  	
  	
    $sSqlBuscaBancoAgenciaArrecad  = "    select distinct lpad(trim(k15_codbco),3,'0') as k15_codbco, 							 "; 
    $sSqlBuscaBancoAgenciaArrecad .= " 				      k15_codage	  														 ";
    $sSqlBuscaBancoAgenciaArrecad .= " 				from  ( select x.k15_codbco, 	 											 "; 
    $sSqlBuscaBancoAgenciaArrecad .= "							   x.k15_codage,   												 ";
    $sSqlBuscaBancoAgenciaArrecad .= "							   trim(cadban.k15_carte) as k15_carte  						 "; 
    $sSqlBuscaBancoAgenciaArrecad .= "						  from ( select k15_codbco,   										 ";
    $sSqlBuscaBancoAgenciaArrecad .= "									    k15_codage,   										 ";
    $sSqlBuscaBancoAgenciaArrecad .= "										count(*)   											 ";
    $sSqlBuscaBancoAgenciaArrecad .= "								   from disarq   											 ";
    $sSqlBuscaBancoAgenciaArrecad .= "								  where dtarquivo >= '2008-01-01'  							 ";
    $sSqlBuscaBancoAgenciaArrecad .= "								    and instit    = {$oConfig->codigo} 						 ";
    $sSqlBuscaBancoAgenciaArrecad .= "						  	   group by k15_codbco,   										 ";
    $sSqlBuscaBancoAgenciaArrecad .= "										k15_codage  										 ";
    $sSqlBuscaBancoAgenciaArrecad .= "										having count(*) > 5 ) as x  						 "; 
    $sSqlBuscaBancoAgenciaArrecad .= "								inner join cadban on x.k15_codbco = cadban.k15_codbco  	 	 "; 
    $sSqlBuscaBancoAgenciaArrecad .= "												 and x.k15_codage = cadban.k15_codage	     ";
    $sSqlBuscaBancoAgenciaArrecad .= "						 where ( k15_carte is null 									   	     ";    
    $sSqlBuscaBancoAgenciaArrecad .= "						    or   trim(k15_carte) = '' )) as x							     ";
  	
    
  	$rsBuscaBancoAgenciaArrecad 	   = pg_query($sSqlBuscaBancoAgenciaArrecad);
  	$iNroLinhaBuscaBancoAgenciaArrecad = pg_num_rows($rsBuscaBancoAgenciaArrecad);
  	
  	
  	
	if ( $iNroLinhaBuscaBancoAgenciaArrecad > 0) {
  	
  	  // Acha Sequencial da tabela cadarrecadacao
  	  $sSqlSeqCadArrecadacao = "select nextval('cadarrecadacao_ar16_sequencial_seq') as sequencial";
  	  
  	  $rsSeqCadArrecadacao   = pg_query($conn,$sSqlSeqCadArrecadacao);
      $oSeqCadArrecadacao    = db_utils::fieldsMemory($rsSeqCadArrecadacao,0);  	
  	

  	
  	  // Insere cadarrecadacao
  	  $sSqlInsereCadArrecadacao = " insert into cadarrecadacao ( ar16_sequencial,
  															     ar16_instit,
  															     ar16_convenio,
  															     ar16_segmento,
  															     ar16_formatovenc
  															   ) values (
															     {$oSeqCadArrecadacao->sequencial},
															     {$oConfig->codigo},
															     '{$oConfig->numbanco}',
															     {$oConfig->segmento},
															     {$oConfig->formvencfebraban}															   	
  															   )";
  	  pg_query($conn,$sSqlInsereCadArrecadacao);
  	

  	
	  // Acha Sequencial da tabela cadconvenio ( Arrecadação )

  	  $sSqlSeqCadConvenioArrecad = "select nextval('cadconvenio_ar11_sequencial_seq') as sequencial";
		  	  
  	  $rsSeqCadConvenioArrecad   = pg_query($conn,$sSqlSeqCadConvenioArrecad);
  	  $oSeqCadConvenioArrecad    = db_utils::fieldsMemory($rsSeqCadConvenioArrecad,0);  	  
		  	
		  	

  	  // Insere cadconvenio ( Arrecadação )
  	  $sSqlInsereCadConvenioArrecad = " insert into cadconvenio ( ar11_sequencial,
															      ar11_cadtipoconvenio,
															      ar11_instit,
															      ar11_nome
			  	                                                ) values (
			  	                                                  {$oSeqCadConvenioArrecad->sequencial},
			  	                                                  3,
			  	                                                  {$oConfig->codigo},
			  	                                                  'CONVENIO ARRECADACAO '		  	                 									                                   														
			  	  											    )";
	  pg_query($conn,$sSqlInsereCadConvenioArrecad);  	
  	

	  
	  
	  
	  for ($x=0; $x < $iNroLinhaBuscaBancoAgenciaArrecad; $x++) {
	  	
	  	$oBuscaBancoAgenciaArrecad = db_utils::fieldsMemory($rsBuscaBancoAgenciaArrecad,$x);
	  	
	    $iCodAgencia = substr($oBuscaBancoAgenciaArrecad->k15_codage,0,strlen($oBuscaBancoAgenciaArrecad->k15_codage)-1);
	    $iCodAgencia = str_replace("-","",$iCodAgencia);
	    $iCodDigito  = substr($oBuscaBancoAgenciaArrecad->k15_codage,strlen($oBuscaBancoAgenciaArrecad->k15_codage)-1,1);	  	

  	    $sSqlVerificaBancoAgenciaArrecad = " select db89_sequencial 
	  	  								       from bancoagencia
	  	  								      where db89_db_bancos  = {$oBuscaBancoAgenciaArrecad->k15_codbco}
	  	  								        and db89_codagencia = '{$iCodAgencia}'	 
	  	  								        and db89_digito     = '{$iCodDigito}'"; 
		  	  
	    $rsVerificaBancoAgenciaArrecad 		  = pg_query($sSqlVerificaBancoAgenciaArrecad);
	    $iNroLinhaVerificaBancoAgenciaArrecad = pg_num_rows($rsVerificaBancoAgenciaArrecad); 
	  	
	  	if ( $iNroLinhaVerificaBancoAgenciaArrecad > 0 ) {
	  		
	  	  $oVerificaBancoAgenciaArrecad = db_utils::fieldsMemory($rsVerificaBancoAgenciaArrecad,0);
	  	  $iCodBancoAgencia = $oVerificaBancoAgenciaArrecad->db89_sequencial;
	  	  
	    } else {
		
  	    // Acha Sequencial da tabela bancoagencia ( Arrecadação )
  	    $sSqlSeqBancoAgencia = "select nextval('bancoagencia_db89_sequencial_seq') as sequencial";
  	    $rsSeqBancoAgencia   = pg_query($conn,$sSqlSeqBancoAgencia);
  	    $oSeqBancoAgencia	 = db_utils::fieldsMemory($rsSeqBancoAgencia,0); 

	    $iCodAgencia = substr($oBuscaBancoAgenciaArrecad->k15_codage,0,strlen($oBuscaBancoAgenciaArrecad->k15_codage)-1);
	    $iCodAgencia = str_replace("-","",$iCodAgencia);
	    $iCodDigito  = substr($oBuscaBancoAgenciaArrecad->k15_codage,strlen($oBuscaBancoAgenciaArrecad->k15_codage)-1,1);  	    
  	    
   	    // Insere bancoagencia ( Cobrança )
  	    $sSqlInsereBancoAgencia = " insert into bancoagencia ( db89_sequencial,
  														       db89_db_bancos,
  														       db89_codagencia,
  														       db89_digito 				
  	                                                         ) values (
  	                                                           {$oSeqBancoAgencia->sequencial},
  	                                                           '{$oBuscaBancoAgenciaArrecad->k15_codbco}',
  	                                                           '{$iCodAgencia}',
  															   '{$iCodDigito}'	
  	                                                         )";
  	                                                          
 	    pg_query($conn,$sSqlInsereBancoAgencia);

	  	$iCodBancoAgencia = $oSeqBancoAgencia->sequencial;	
	  	
	   }
	  		

		  // Insere convenioarrecadacao
		  $sSqlInsereConvenioArrecadacao  = " insert into convenioarrecadacao ( ar14_sequencial,										    ";
          $sSqlInsereConvenioArrecadacao .= "				 				    ar14_bancoagencia,										    ";
          $sSqlInsereConvenioArrecadacao .= " 								    ar14_cadarrecadacao,									    ";
          $sSqlInsereConvenioArrecadacao .= " 								    ar14_cadconvenio										    ";
          $sSqlInsereConvenioArrecadacao .= " 								  ) values (												    ";
          $sSqlInsereConvenioArrecadacao .= " 								   (select nextval('convenioarrecadacao_ar14_sequencial_seq')), ";
		  $sSqlInsereConvenioArrecadacao .= " 								   {$iCodBancoAgencia},											";
		  $sSqlInsereConvenioArrecadacao .= " 								   {$oSeqCadArrecadacao->sequencial},							";
		  $sSqlInsereConvenioArrecadacao .= " 								   {$oSeqCadConvenioArrecad->sequencial}						";
		  $sSqlInsereConvenioArrecadacao .= " 								  ) 															";
		  
		  
	      pg_query($conn,$sSqlInsereConvenioArrecadacao);
	  	  
	  	
	  } // "for" nº bancoagencias arrecad

	  $sSqlVerificaRegraArrecad  = " select k48_sequencial 		    		";
	  $sSqlVerificaRegraArrecad .= "   from modcarnepadrao 		    		";
	  $sSqlVerificaRegraArrecad .= "  where k48_cadconvenio is null 		";
	  $sSqlVerificaRegraArrecad .= "    and k48_instit = {$oConfig->codigo} ";
	   
	  
	  $rsVerificaRegraArrecad        = pg_query($conn,$sSqlVerificaRegraArrecad);
	  $iNroLinhaVerificaRegraArrecad = pg_num_rows($rsVerificaRegraArrecad);
	  
	  for ($w=0; $w < $iNroLinhaVerificaRegraArrecad; $w++) {
	    
	  	$oVerificaRegraArrecad = db_utils::fieldsMemory($rsVerificaRegraArrecad,$w);
	    
	    $sSqlAlteraModCarnePadrao  = " update modcarnepadrao set k48_cadconvenio = {$oSeqCadConvenioArrecad->sequencial}"; 
	    $sSqlAlteraModCarnePadrao .= "  where k48_sequencial = {$oVerificaRegraArrecad->k48_sequencial}";							
	  
	    pg_query($conn,$sSqlAlteraModCarnePadrao);	    
	    
	  }
      echo "\n Insere {$w} registros na arrecadação \n";
      
      
	} else {

		
	  // Acha Sequencial da tabela cadconvenio ( Caixa Padrão )
  	  $sSqlSeqCadConvenioCaixa = "select nextval('cadconvenio_ar11_sequencial_seq') as sequencial";
		  	  
  	  $rsSeqCadConvenioCaixa   = pg_query($conn,$sSqlSeqCadConvenioCaixa);
  	  $oSeqCadConvenioCaixa    = db_utils::fieldsMemory($rsSeqCadConvenioCaixa,0);  	  
		  	

  	  // Insere cadconvenio ( Caixa Padrão )
  	  $sSqlInsereCadConvenioCaixa =   " insert into cadconvenio ( ar11_sequencial,
															      ar11_cadtipoconvenio,
															      ar11_instit,
															      ar11_nome
			  	                                                ) values (
			  	                                                  {$oSeqCadConvenioCaixa->sequencial},
			  	                                                  4,
			  	                                                  {$oConfig->codigo},
			  	                                                  'CAIXA PADRÃO ( AUTOMÁTICO ) '		  	                 									                                   														
			  	  											    )";
	  pg_query($conn,$sSqlInsereCadConvenioCaixa);  	
		
	  
	  $sSqlVerificaRegraCaixa  = " select k48_sequencial 		    		";
	  $sSqlVerificaRegraCaixa .= "   from modcarnepadrao 		    		";
	  $sSqlVerificaRegraCaixa .= "  where k48_cadconvenio is null 		";
	  $sSqlVerificaRegraCaixa .= "    and k48_instit = {$oConfig->codigo} ";
	   
	  
	  $rsVerificaRegraCaixa        = pg_query($conn,$sSqlVerificaRegraCaixa);
	  $iNroLinhaVerificaRegraCaixa = pg_num_rows($rsVerificaRegraCaixa);
	  
	  for ($y=0; $y < $iNroLinhaVerificaRegraCaixa; $y++) {
	    
	  	$oVerificaRegraCaixa = db_utils::fieldsMemory($rsVerificaRegraCaixa,$y);
	    
	    $sSqlAlteraModCarnePadrao  = " update modcarnepadrao set k48_cadconvenio = {$oSeqCadConvenioCaixa->sequencial}"; 
	    $sSqlAlteraModCarnePadrao .= "  where k48_sequencial = {$oVerificaRegraCaixa->k48_sequencial}";							
	  
	    pg_query($conn,$sSqlAlteraModCarnePadrao);	    
	    
	  }
	  
      echo "\n Insere {$y} registros com caixa padrão \n";
		
	}
	
  } // Fim "for" principal por instituição 

  
 
//  echo "\n\n------------------- Verifica Cobrança -----------------------\n\n";
//  
//  $sSqlTesteCobranc	 = " select * 																  ";
//  $sSqlTesteCobranc	.= "   from modcarnepadrao													  ";
//  $sSqlTesteCobranc	.= "   	    inner join cadconvenio 	  	 on ar11_sequencial  = k48_cadconvenio";
//  $sSqlTesteCobranc	.= " 	    inner join conveniocobranca  on ar13_cadconvenio = ar11_sequencial";
//	  				 
//  $rsTesteCobranc = pg_query($conn,$sSqlTesteCobranc); 
//  $iNroLinhaTesteCobranc = pg_num_rows($rsTesteCobranc);
//  
//  
//  for ($i=0; $i < $iNroLinhaTesteCobranc; $i++) {
//  	
//  	$oTesteCobranc = db_utils::fieldsMemory($rsTesteCobranc,$i);
//  	
//  	for ($x=0; $x < pg_num_rows($rsModCarnePadraoCobranca); $x++){
//  	  $oTesteCobrancAnt = db_utils::fieldsMemory($rsModCarnePadraoCobranca,$x);
//  	  if ($oTesteCobranc->k48_sequencial == $oTesteCobrancAnt->k48_sequencial){	
//  	    echo "\nModCarne: {$oTesteCobranc->k48_sequencial} \n";
//  	    echo "ConvenioAnt : $oTesteCobrancAnt->k15_conv1      Convenio : {$oTesteCobranc->ar13_convenio}  \n";
//  	    echo "CarteiraAnt : $oTesteCobrancAnt->k15_carte      Carteira : {$oTesteCobranc->ar13_carteira}  \n";
//  	    echo "CedenteAnt  : $oTesteCobrancAnt->k15_ceden1     Cedente  : {$oTesteCobranc->ar13_cedente}   \n";
//  	    echo "VariacaoAnt : $oTesteCobrancAnt->k15_seq       Variacao : {$oTesteCobranc->ar13_variacao}  \n";
//  	  }
//    } 
//  }
  
  
  // Fim Transação
  pg_query($conn,"commit");
//  pg_query($conn,"rollback	");
  
  echo "\n\n +--------------------------------------------------------------------+ \n\n";
  echo "\n\n Operação concluída com sucesso!!\n\n\n";
  
    
  function db_log($sLog="", $sArquivo="", $iTipo=0, $lLogDataHora=true, $lQuebraAntes=false) {
  
  // Tipos: 0 = Saida Tela e Arquivo
  //        1 = Saida Somente Tela
  //        2 = Saida Somente Arquivo
    
  $aDataHora = getdate();
  $sQuebraAntes = $lQuebraAntes?"\n":"";


  if($lLogDataHora) {
    $sOutputLog = sprintf("%s[%02d/%02d/%04d %02d:%02d:%02d] %s", $sQuebraAntes,
                          $aDataHora["mday"], $aDataHora["mon"], $aDataHora["year"],
                          $aDataHora["hours"], $aDataHora["minutes"], $aDataHora["seconds"],
                          $sLog);
  } else {
    $sOutputLog = sprintf("%s%s", $sQuebraAntes, $sLog);
  }


  // Se habilitado saida na tela...
  if($iTipo==0 or $iTipo==1) {
    echo $sOutputLog;
  }

  // Se habilitado saida para arquivo...
  if($iTipo==0 or $iTipo==2) {
    if(!empty($sArquivo)) {
      $fd=fopen($sArquivo, "a+");
      if($fd) { 
        fwrite($fd, $sOutputLog);
        fclose($fd);
      }
      //system("echo '$sOutputLog' >> $sArquivo");
    }
  }

  return $aDataHora;
}
?>
