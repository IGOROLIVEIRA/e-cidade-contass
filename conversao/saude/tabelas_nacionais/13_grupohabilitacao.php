<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/13_sau_grupohabilitacao_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  //financiamento
  $file = file("arquivos/tb_grupo_habilitacao.txt");
  for($x=0; $x < count($file); $x++){   $array_habilitacao = explode(" e ", trim(substr($file[$x],4,20)));
   for($y=0; $y < count($array_habilitacao); $y++){   	$c1 = trim(substr($file[$x],0,4));
    $c2 = trim(str_replace("'","",substr($file[$x],24,250)));
    $habilitacao = pg_result(pg_query("select sd75_i_codigo from sau_habilitacao where sd75_c_habilitacao = '".$array_habilitacao[$y]."'"),0,0);

     $sql = "INSERT INTO sau_grupohabilitacao(sd76_i_codigo,
                                              sd76_c_grupohabilitacao,
                                              sd76_i_habilitacao,
                                              sd76_c_descricao )
                   		    		   VALUES(nextval('sau_grupohabilitacao_sd76_i_codigo_seq'),
   			            	                  '$c1',
   			    	                          $habilitacao,
       			 	                          '$c2')";

    $query = @pg_query($sql);
    if($query){
	 echo "$c1 - $habilitacao - $c2 Incluido<br>\n";
   	 $count1++;
    }else{
	 echo "$c1 - $habilitacao - $c2 Não incluido<br>\n";
     $count2++;
     system("echo \"$sql\" >> $arq1");
    }
   }
  }

  echo "Total: ".count($file)."\n";
  echo "Total Incluído:".$count1."\n";
  echo "Total Não Incluído:".$count2."\n";
?>