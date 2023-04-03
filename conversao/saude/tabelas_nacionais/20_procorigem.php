<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/20_sau_procorigem_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  //financiamento
  $file = file("arquivos/rl_procedimento_origem.txt");
  for($x=0; $x < count($file); $x++){
   $procedimento = pg_result(pg_query("select sd63_i_codigo from sau_procedimento where sd63_c_procedimento = '".trim(substr($file[$x],0,10))."'"),0,0);
   $origem       = pg_result(pg_query("select sd63_i_codigo from sau_procedimento where sd63_c_procedimento = '".trim(substr($file[$x],10,10))."'"),0,0);
   $c1 = trim(substr($file[$x],20,4));
   $c2 = trim(substr($file[$x],24,2));


   $sql = "INSERT INTO sau_procorigem(sd95_i_codigo,
									  sd95_i_procedimento,
									  sd95_i_origem,
									  sd95_i_anocomp,
									  sd95_i_mescomp)
      		                   VALUES(nextval('sau_procorigem_sd95_i_codigo_seq'),
       			    	              $procedimento,
   			    	                  $origem,
    				                  $c1,
    				                  $c2)";

   $query = @pg_query($sql);
   if($query){
	echo "Proc: $procedimento - Origem: $origem - Comp: $c1/$c2 Incluido<br>\n";
   	$count1++;
   }else{
	echo "Proc: $procedimento - Origem: $origem - Comp: $c1/$c2 Não Incluido<br>\n";
   	$count2++;
    system("echo \"$sql\" >> $arq1");
   }
  }

  echo "Total: ".count($file)."\n";
  echo "Total Incluído:".$count1."\n";
  echo "Total Não Incluído:".$count2."\n";
?>