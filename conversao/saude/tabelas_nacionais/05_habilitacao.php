<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/05_sau_habilitacao_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  //financiamento
  $file = file("arquivos/tb_habilitacao.txt");
  for($x=0; $x < count($file); $x++){
   $c1 = trim(substr($file[$x],0,4));
   $c2 = trim(substr($file[$x],4,150));
   $c3 = trim(substr($file[$x],154,4));
   $c4 = trim(substr($file[$x],158,2));

   $sql = "INSERT INTO sau_habilitacao( sd75_i_codigo,
										sd75_c_habilitacao,
										sd75_c_nome,
 										sd75_i_anocomp,
										sd75_i_mescomp  )
   		    		    VALUES(nextval('sau_habilitacao_sd75_i_codigo_seq'),
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