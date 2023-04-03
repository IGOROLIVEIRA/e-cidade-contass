<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/12_sau_forma_organizacao_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  //financiamento
  $file = file("arquivos/tb_forma_organizacao.txt");
  for($x=0; $x < count($file); $x++){
   $grupo    = pg_result(pg_query("select sd60_i_codigo from sau_grupo    where sd60_c_grupo    = '".trim(substr($file[$x],0,2))."'"),0,0);
   $subgrupo = pg_result(pg_query("select sd61_i_codigo from sau_subgrupo where sd61_c_subgrupo = '".trim(substr($file[$x],2,2))."'"),0,0);
   $c1 = trim(substr($file[$x],4,2));
   $c2 = trim(str_replace("'","",substr($file[$x],6,100)));
   $c3 = trim(substr($file[$x],106,4));
   $c4 = trim(substr($file[$x],110,2));

   $sql = "INSERT INTO sau_formaorganizacao(sd62_i_codigo,
								    sd62_i_grupo,
									sd62_i_subgrupo,
									sd62_c_formaorganizacao,
									sd62_c_nome,
									sd62_i_anocomp,
									sd62_i_mescomp )
        		    		   VALUES(nextval('sau_formaorganizacao_sd62_i_codigo_seq'),
   			    	                  $grupo,
   			    	                  $subgrupo,
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