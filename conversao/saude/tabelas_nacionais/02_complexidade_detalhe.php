<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/02_sau_complexidade_detalhe_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  //Complexidades
  @pg_query("delete from sau_complexidade");
  @pg_query("insert into sau_complexidade values(0,'NÃO SE APLICA')");
  @pg_query("insert into sau_complexidade values(1,'ATENÇÃO BÁSICA COMPLEXIDADE')");
  @pg_query("insert into sau_complexidade values(2,'MÉDIA COMPLEXIDADE')");
  @pg_query("insert into sau_complexidade values(3,'ALTA COMPLEXIDADE')");

  //detalhe
  $file = file("arquivos/tb_detalhe.txt");
  for($x=0; $x < count($file); $x++){
   $c1 = trim(substr($file[$x],0,3));
   $c2 = trim(substr($file[$x],3,100));
   $c3 = trim(substr($file[$x],103,4));
   $c4 = trim(substr($file[$x],107,2));

   $sql = "INSERT INTO sau_detalhe(sd73_i_codigo ,
							   sd73_c_detalhe,
							   sd73_c_nome   ,
							   sd73_i_anocomp,
                               sd73_i_mescomp )
   		    		    VALUES(nextval('sau_detalhe_sd73_i_codigo_seq'),
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