<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/23_sau_procservico_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  //financiamento
  $file = file("arquivos/rl_procedimento_servico.txt");
  for($x=0; $x < count($file); $x++){
   $procedimento  = @pg_result(@pg_query("select sd63_i_codigo from sau_procedimento      where sd63_c_procedimento  = '".trim(substr($file[$x],0,10))."'"),0,0);
    if($procedimento == ""){
     $erro = 'Procedimento '.trim(substr($file[$x],0,10)).' não cadastrado!';
     system("echo \"$erro\" >> $arq1");
     continue;
    } 
   
   $servico       = @pg_result(@pg_query("select sd86_i_codigo from sau_servico           where sd86_c_servico       = '".trim(substr($file[$x],10,3))."'"),0,0);
    if($servico == ""){
     $erro = 'Servico '.trim(substr($file[$x],10,3)).' não cadastrado!';
     system("echo \"$erro\" >> $arq1");
     continue;
    }
			     
   $classificacao = pg_result(pg_query("select sd87_i_codigo from sau_servclassificacao where sd87_c_classificacao = '".trim(substr($file[$x],13,3))."'"),0,0);
   if($classificacao == ""){
     $erro = 'Classificacao '.trim(substr($file[$x],13,3)).' não cadastrado!';
     system("echo \"$erro\" >> $arq1");
     continue;
   }
			     
   $c1 = trim(substr($file[$x],16,4));
   $c2 = trim(substr($file[$x],20,2));


   $sql = "INSERT INTO sau_procservico( sd88_i_codigo,
                                        sd88_i_procedimento,
                                        sd88_i_classificacao,
                                        sd88_i_servico,
                                        sd88_i_anocomp,
                                        sd88_i_mescomp)
        		                 VALUES(nextval('sau_procservico_sd88_i_codigo_seq'),
       			    	                $procedimento,
   			    	                    $classificacao,
    				                    $servico,
    				                    $c1,
    				                    $c2)";

   $query = @pg_query($sql);
   if($query){
	echo "Proc: $procedimento - Servico: $servico - Comp: $c1/$c2 Incluido<br>\n";
   	$count1++;
   }else{
	echo "Proc: $procedimento - Servico: $servico - Comp: $c1/$c2 Não Incluido<br>\n";
   	$count2++;
    system("echo \"$sql\" >> $arq1");
   }
  }

  echo "Total: ".count($file)."\n";
  echo "Total Incluído:".$count1."\n";
  echo "Total Não Incluído:".$count2."\n";
?>
