<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/14_sau_procedimento_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  @pg_query("insert into sau_rubrica values(0,'','',2008,05)");

  //financiamento
  $file = file("arquivos/tb_procedimento.txt");
  for($x=0; $x < count($file); $x++){   $financiamento  = pg_result(pg_query("select sd65_i_codigo from sau_financiamento where sd65_c_financiamento = '".trim(substr($file[$x],312,2))."'"),0,0);

   if(trim(substr($file[$x],314,6)) == ""){   	$rubrica = "null";   }else{    $rubrica = pg_result(pg_query("select sd64_i_codigo from sau_rubrica       where sd64_c_rubrica = '".trim(substr($file[$x],314,6))."'"),0,0);   }

   $complexidade    = trim(substr($file[$x],260,1));
   $c1 = trim(substr($file[$x],0,10));
   $c2 = trim(str_replace("'","",substr($file[$x],10,250)));
   $c3 = trim(substr($file[$x],261,1));
   $c4 = trim(substr($file[$x],262,4));
   $c5 = trim(substr($file[$x],266,4));
   $c6 = trim(substr($file[$x],270,4));
   $c7 = trim(substr($file[$x],274,4));
   $c8 = trim(substr($file[$x],278,4));
   $c9 = trim(substr($file[$x],282,10));
   $c10= trim(substr($file[$x],292,10));
   $c11= trim(substr($file[$x],302,10));
   $c14= trim(substr($file[$x],320,4));
   $c15= trim(substr($file[$x],324,2));

   $sql = "INSERT INTO sau_procedimento(sd63_i_codigo,
                                       sd63_c_procedimento,
                                       sd63_c_nome        ,
                                       sd63_i_complexidade,
                                       sd63_c_sexo        ,
									   sd63_i_execucaomax ,
									   sd63_i_maxdias     ,
									   sd63_i_pontos      ,
									   sd63_i_idademin    ,
									   sd63_i_idademax    ,
									   sd63_f_sh          ,
									   sd63_f_sa          ,
									   sd63_f_sp          ,
									   sd63_i_financiamento,
									   sd63_i_rubrica      ,
									   sd63_i_anocomp      ,
									   sd63_i_mescomp )
        		    		   VALUES(nextval('sau_procedimento_sd63_i_codigo_seq'),
   			    	                  '$c1',
   			    	                  '$c2',
       			 	                  $complexidade,
       			 	                  '$c3',
       			 	                  '$c4',
       			 	                  '$c5',
       			 	                  '$c6',
       			 	                  '$c7',
       			 	                  '$c8',
       			 	                  '$c9',
       			 	                  '$c10',
       			 	                  '$c11',
       			 	                  $financiamento,
       			 	                  $rubrica,
       			 	                  '$c14',
       			 	                  '$c15')";

   $query = @pg_query($sql);
   if($query){
	echo "$c1 - $c2 - $c3/$c4 Incluido<br>\n";
   	$count1++;
   }else{
	echo "$c1 - $c2 - $c3/$c4 Não Incluido<br>\n";
   	$count2++;
    system("echo \"$sql\" >> $arq1");
   }
  }

  echo "Total: ".count($file)."\n";
  echo "Total Incluído:".$count1."\n";
  echo "Total Não Incluído:".$count2."\n";
?>