<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/21_sau_procregistro_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  //financiamento
  $file = file("arquivos/rl_procedimento_registro.txt");
  for($x=0; $x < count($file); $x++){
   $procedimento = @pg_result(@pg_query("select sd63_i_codigo from sau_procedimento where sd63_c_procedimento = '".trim(substr($file[$x],0,10))."'"),0,0);
   if($procedimento == ""){
     echo $erro = 'Procedimento '.trim(substr($file[$x],0,10)).' n�o cadastrado!';
     system("echo \"$erro\" >> $arq1");
     continue;
   }
			   
   $registro     = @pg_result(@pg_query("select sd84_i_codigo from sau_registro     where sd84_c_registro     = '".trim(substr($file[$x],10,2))."'"),0,0);
   if($registro == ""){
    echo $erro = 'Registro '.trim(substr($file[$x],10,2)).' n�o cadastrado!';
    system("echo \"$erro\" >> $arq1");
    continue;
   }
		        
   $c1 = trim(substr($file[$x],12,4));
   $c2 = trim(substr($file[$x],16,2));


   $sql = "INSERT INTO sau_procregistro(sd85_i_codigo,
									    sd85_i_procedimento,
									    sd85_i_registro,
									    sd85_i_anocomp,
									    sd85_i_mescomp)
        		                 VALUES(nextval('sau_procregistro_sd85_i_codigo_seq'),
       			    	                $procedimento,
   			    	                    $registro,
    				                    $c1,
    				                    $c2)";

   $query = @pg_query($sql);
   if($query){
	echo "Proc: $procedimento - Registro: $registro - Comp: $c1/$c2 Incluido<br>\n";
   	$count1++;
   }else{
	echo "Proc: $procedimento - Registro: $registro - Comp: $c1/$c2 N�o Incluido<br>\n";
   	$count2++;
    system("echo \"$sql\" >> $arq1");
   }
  }

  echo "Total: ".count($file)."\n";
  echo "Total Inclu�do:".$count1."\n";
  echo "Total N�o Inclu�do:".$count2."\n";
?>
