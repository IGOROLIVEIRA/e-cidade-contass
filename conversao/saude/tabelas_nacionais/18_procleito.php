<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/18_sau_procleito_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  //financiamento
  $file = file("arquivos/rl_procedimento_leito.txt");
  for($x=0; $x < count($file); $x++){
   $procedimento = @pg_result(@pg_query("select sd63_i_codigo from sau_procedimento where sd63_c_procedimento = '".trim(substr($file[$x],0,10))."'"),0,0);
   if($procedimento == ""){
    echo $erro = 'Procedimento '.trim(substr($file[$x],0,10)).' não cadastrado!';
    system("echo \"$erro\" >> $arq1");
    continue;
   }
   $leito        = @pg_result(@pg_query("select sd80_i_codigo from sau_tipoleito    where sd80_c_leito        = '".trim(substr($file[$x],10,2))."'"),0,0);
   if($leito == ""){
    echo $erro = 'Leito '.trim(substr($file[$x],10,2)).' não cadastrado!';
    system("echo \"$erro\" >> $arq1");
    continue;
   }   
   $c1 = trim(substr($file[$x],12,4));
   $c2 = trim(substr($file[$x],16,2));


   $sql = "INSERT INTO sau_procleito(sd81_i_codigo,
									 sd81_i_procedimento,
									 sd81_i_leito,
									 sd81_i_anocomp,
									 sd81_i_mescomp)
   		    		          VALUES(nextval('sau_procleito_sd81_i_codigo_seq'),
   			    	                 $procedimento,
   			    	                 $leito,
    				                 $c1,
    				                 $c2)";

   $query = @pg_query($sql);
   if($query){
	echo "Proc: $procedimento - leito: $leito - Comp: $c1/$c2 Incluido<br>\n";
   	$count1++;
   }else{
	echo "Proc: $procedimento - leito: $leito - Comp: $c1/$c2 Não Incluido<br>\n";
   	$count2++;
    system("echo \"$sql\" >> $arq1");
   }
  }

  echo "Total: ".count($file)."\n";
  echo "Total Incluído:".$count1."\n";
  echo "Total Não Incluído:".$count2."\n";
?>
