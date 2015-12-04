<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/29_sau_prochabilitacao_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  $file = file("arquivos/rl_procedimento_habilitacao.txt");
  for($x=0; $x < count($file); $x++){
   $procedimento = @pg_result(@pg_query("select sd63_i_codigo from sau_procedimento     where sd63_c_procedimento     = '".trim(substr($file[$x],0,10))."'"),0,0);
   if($procedimento == ""){
     echo $erro = 'Procedimento '.trim(substr($file[$x],0,10)).' não cadastrado!';
     system("echo \"$erro\" >> $arq1");
     continue;
   }
		     
   $habilitacao  = @pg_result(@pg_query("select sd75_i_codigo from sau_habilitacao      where sd75_c_habilitacao      = '".trim(substr($file[$x],10,4))."'"),0,0);
   if($habilitacao == ""){
    echo $erro = 'Procedimento '.trim(substr($file[$x],10,4)).' não cadastrado!';
    system("echo \"$erro\" >> $arq1");
    continue;
   }
		        
   $grupo        = @pg_result(@pg_query("select sd76_i_codigo from sau_grupohabilitacao where sd76_c_grupohabilitacao = '".trim(substr($file[$x],14,4))."'"),0,0);
   if($grupo == ""){
    $grupo = 'null';  
   }
   $c1 = trim(substr($file[$x],18,4));
   $c2 = trim(substr($file[$x],22,2));

   $sql = "INSERT INTO sau_prochabilitacao( sd77_i_codigo,
										    sd77_i_procedimento,
     										sd77_i_habilitacao,
	    									sd77_i_grupohabilitacao,
		    								sd77_i_anocomp,
			    							sd77_i_mescomp )
        		           		    VALUES(nextval('sau_prochabilitacao_sd77_i_codigo_seq'),
       			    	                  $procedimento,
   	    		    	                  $habilitacao,
   		    	    	                  $grupo,
   			    	                      $c1,
   				                          $c2)";
   $query = pg_query($sql);
   if($query){
	echo "Proc: $procedimento - Habilitacao: $habilitacao - Comp: $c1/$c2 Incluido<br>\n";
   	$count1++;
   }else{
	echo "Proc: $procedimento - Habilitacao: $habilitacao - Comp: $c1/$c2 Não Incluido<br>\n";
   	$count2++;
    system("echo \"$sql\" >> $arq1");
   }
  }

  echo "Total: ".count($file)."\n";
  echo "Total Incluído:".$count1."\n";
  echo "Total Não Incluído:".$count2."\n";
?>
