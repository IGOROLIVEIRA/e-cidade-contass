<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/04_sau_grupo_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  //financiamento
  $file = file("arquivos/tb_grupo.txt");
  for($x=0; $x < count($file); $x++){
   $c1 = trim(substr($file[$x],0,2));
   $c2 = trim(substr($file[$x],2,100));
   $c3 = trim(substr($file[$x],102,4));
   $c4 = trim(substr($file[$x],106,2));

   $sql = "INSERT INTO sau_grupo( sd60_i_codigo,
								  sd60_c_grupo,
								  sd60_c_nome,
								  sd60_i_anocomp,
                                  sd60_i_mescomp )
   		    		    VALUES(nextval('sau_grupo_sd60_i_codigo_seq'),
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