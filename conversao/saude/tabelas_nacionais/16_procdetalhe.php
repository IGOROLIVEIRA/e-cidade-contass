<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/16_sau_procdetalhe_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  //financiamento
  $file = file("arquivos/rl_procedimento_detalhe.txt");
  for($x=0; $x < count($file); $x++){
   $procedimento = @pg_result(@pg_query("select sd63_i_codigo from sau_procedimento where sd63_c_procedimento = '".trim(substr($file[$x],0,10))."'"),0,0);
   if($procedimento == ""){
    echo $erro = 'Procedimento '.trim(substr($file[$x],0,10)).' não cadastrado!';
    system("echo \"$erro\" >> $arq1");
    continue;
   }
  
   $detalhe      = @pg_result(@pg_query("select sd73_i_codigo from sau_detalhe      where sd73_c_detalhe      = '".trim(substr($file[$x],10,3))."'"),0,0);
   if($detalhe == ""){
    echo $erro = 'Detalhe '.trim(substr($file[$x],10,3)).' não cadastrado!';
    system("echo \"$erro\" >> $arq1");
    continue;
   }
		     
   
   $c2 = trim(substr($file[$x],13,4));
   $c3 = trim(substr($file[$x],17,2));

   $sql = "INSERT INTO sau_procdetalhe(sd74_i_codigo,
                                       sd74_i_procedimento,
                                       sd74_i_detalhe,
									   sd74_i_anocomp,
									   sd74_i_mescomp  )
        		    		   VALUES(nextval('sau_procdetalhe_sd74_i_codigo_seq'),
   			    	                  $procedimento,
   			    	                  $detalhe,
   				                      $c2,
   				                      $c3)";
   $query = @pg_query($sql);
   if($query){
	echo "Proc: $procedimento - Detalhe: $detalhe - Comp: $c2/$c3 Incluido<br>\n";
   	$count1++;
   }else{
	echo "Proc: $procedimento - Detalhe: $detalhe - Comp: $c2/$c3 Não Incluido<br>\n";
   	$count2++;
    system("echo \"$sql\" >> $arq1");
   }
  }

  echo "Total: ".count($file)."\n";
  echo "Total Incluído:".$count1."\n";
  echo "Total Não Incluído:".$count2."\n";
?>
