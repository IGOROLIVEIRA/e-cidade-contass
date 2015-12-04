<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/09_sau_servico_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  //financiamento
  $file = file("arquivos/tb_servico.txt");
  for($x=0; $x < count($file); $x++){
   $c1 = trim(substr($file[$x],0,3));
   $c2 = trim(str_replace("'","",substr($file[$x],3,120)));
   $c3 = trim(substr($file[$x],123,4));
   $c4 = trim(substr($file[$x],127,2));

   $sql = "INSERT INTO sau_servico(sd86_i_codigo,
								   sd86_c_servico,
								   sd86_c_nome,
								   sd86_i_anocomp,
								   sd86_i_mescomp   )
        		    		   VALUES(nextval('sau_servico_sd86_i_codigo_seq'),
   			    	                  '$c1',
       			 	                  '$c2',
   				                      '$c3',
   				                      '$c4')";

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