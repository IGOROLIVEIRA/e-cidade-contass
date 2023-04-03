<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/17_sau_procincremento_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  //financiamento
  $file = file("arquivos/rl_procedimento_incremento.txt");
  for($x=0; $x < count($file); $x++){
   $procedimento = @pg_result(@pg_query("select sd63_i_codigo from sau_procedimento where sd63_c_procedimento = '".trim(substr($file[$x],0,10))."'"),0,0);
   if($procedimento == ""){
    echo $erro = 'Procedimento '.trim(substr($file[$x],0,10)).' não cadastrado!';
    system("echo \"$erro\" >> $arq1");
    continue;
   }
			
   $habilitacao  = @pg_result(@pg_query("select sd75_i_codigo from sau_habilitacao  where sd75_c_habilitacao  = '".trim(substr($file[$x],10,4))."'"),0,0);
   if($habilitacao == ""){
    echo $erro = 'Habilitacao'.trim(substr($file[$x],10,4)).' não cadastrado!';
    system("echo \"$erro\" >> $arq1");
    continue;
   }
		        
   $c1 = trim(substr($file[$x],14,7));
   $c2 = trim(substr($file[$x],21,7));
   $c3 = trim(substr($file[$x],28,7));
   $c4 = trim(substr($file[$x],35,4));
   $c5 = trim(substr($file[$x],39,2));

   $sql = "INSERT INTO sau_procincremento(sd79_i_codigo,
 										  sd79_i_procedimento,
 										  sd79_i_habilitacao,
										  sd79_f_sh,
										  sd79_f_sa,
										  sd79_f_sp,
										  sd79_i_anocomp,
										  sd79_i_mescomp)
          		    		       VALUES(nextval('sau_procinremento_sd79_i_codigo_seq'),
   			    	                      $procedimento,
   			    	                      $habilitacao,
    				                      $c1,
    				                      $c2,
    				                      $c3,
    				                      $c4,
   	     			                      $c5)";

   $query = @pg_query($sql);
   if($query){
	echo "Proc: $procedimento - habilitacao: $habilitacao - Comp: $c4/$c5 Incluido<br>\n";
   	$count1++;
   }else{
	echo "Proc: $procedimento - habilitacao: $habilitacao - Comp: $c4/$c5 Não Incluido<br>\n";
   	$count2++;
    system("echo \"$sql\" >> $arq1");
   }
  }

  echo "Total: ".count($file)."\n";
  echo "Total Incluído:".$count1."\n";
  echo "Total Não Incluído:".$count2."\n";
?>
