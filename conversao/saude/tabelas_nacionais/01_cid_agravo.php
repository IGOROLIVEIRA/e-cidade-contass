<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/01_sau_cid_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  //agravo
  @pg_query("delete from sau_agravo");
  @pg_query("insert into sau_agravo values(0,'SEM AGRAVO')");
  @pg_query("insert into sau_agravo values(1,'AGRAVO DE NOTIFICACAO')");
  @pg_query("insert into sau_agravo values(2,'AGRAVO DE BLOQUEIO')");

  //cids
  $file = file("arquivos/tb_cid.txt");
  for($x=0; $x < count($file); $x++){   $c1 = trim(substr($file[$x],0,4));
   $c2 = trim(str_replace("'","",substr($file[$x],4,100)));
   $c3 = trim(substr($file[$x],104,1));
   $c4 = trim(substr($file[$x],105,1));

   $sql = "INSERT INTO SAU_cid(sd70_i_codigo,
  						       sd70_c_cid,
 						       sd70_c_nome,
    						   sd70_i_agravo,
	    					   sd70_c_sexo )
   		    		    VALUES(nextval('sau_cid_sd70_i_codigo_seq'),
   			    	           '$c1',
   				               '$c2',
   				               '$c3',
   				               '$c4')";
   $query = @pg_query($sql);
   if($query){	echo "$c1 - $c2 - $c3 - $c4 Incluido<br>\n";   	$count1++;   }else{	echo "$c1 - $c2 - $c3 - $c4 Não Incluido<br>\n";   	$count2++;
    system("echo \"$sql\" >> $arq1");   }
  }
  echo "Total de Cids: ".count($file)."\n";
  echo "Total de Cids Incluído:".$count1."\n";
  echo "Total de Cids não Incluído:".$count2."\n";
?>

