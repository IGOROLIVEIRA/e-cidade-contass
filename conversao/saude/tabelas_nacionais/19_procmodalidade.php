<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/19_sau_procmodalidade_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  //financiamento
  $file = file("arquivos/rl_procedimento_modalidade.txt");
  for($x=0; $x < count($file); $x++){
     
   $procedimento = @pg_result(@pg_query("select sd63_i_codigo from sau_procedimento where sd63_c_procedimento = '".trim(substr($file[$x],0,10))."'"),0,0);
   $modalidade   = @pg_result(@pg_query("select sd82_i_codigo from sau_modalidade   where sd82_c_modalidade   = '".trim(substr($file[$x],10,2))."'"),0,0);
   if($procedimento == ""){
    echo $erro = 'Procedimento '.trim(substr($file[$x],0,10)).' não cadastrado!<br>\n';  
    system("echo \"$erro\" >> $arq1");   
    continue;
   }

   if($modalidade == ""){
    echo $erro = 'Modalidade '.trim(substr($file[$x],10,2)).' não cadastrada!';
    system("echo \"$erro\" >> $arq1");
    continue;  
   }
   
   $c1 = trim(substr($file[$x],12,4));
   $c2 = trim(substr($file[$x],16,2));

   $sql = "INSERT INTO sau_procmodalidade(sd83_i_codigo,
									      sd83_i_procedimento,
									      sd83_i_modalidade,
									      sd83_i_anocomp,
									      sd83_i_mescomp)
   		    		               VALUES(nextval('sau_procmodalidade_sd83_i_codigo_seq'),
       			    	                  $procedimento,
   			    	                      $modalidade,
    				                      $c1,
    				                      $c2)";

   $query = @pg_query($sql);
   if($query){
	echo "Proc: $procedimento - modalidade: $modalidade - Comp: $c1/$c2 Incluido<br>\n";
   	$count1++;
   }else{
	echo "Proc: $procedimento - modalidade: $modalidade - Comp: $c1/$c2 Não Incluido<br>\n";
   	$count2++;
        system("echo \"$sql\" >> $arq1");
   }
  }

  echo "Total: ".count($file)."\n";
  echo "Total Incluído:".$count1."\n";
  echo "Total Não Incluído:".$count2."\n";
?>
