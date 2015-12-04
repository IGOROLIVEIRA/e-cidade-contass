<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/24_sau_siasih_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  @pg_query("delete from sau_tipoproc");
  @pg_query("insert into sau_tipoproc values(1,'AMBULATORIAL')");
  @pg_query("insert into sau_tipoproc values(2,'HOSPITALAR')");

  $file = file("arquivos/tb_sia_sih.txt");
  for($x=0; $x < count($file); $x++){
   $c1 = trim(substr($file[$x],0,10));
   $c2 = trim(str_replace("'","",substr($file[$x],10,100)));
   if(trim(substr($file[$x],110,1)) == "H"){   	$tipoproc = 2;   }else{   	$tipoproc = 1;   }
   $c3 = trim(substr($file[$x],111,4));
   $c4 = trim(substr($file[$x],115,2));


   $sql = "INSERT INTO sau_siasih(sd92_i_codigo,
                                  sd92_c_siasih,
                                  sd92_c_nome,
                                  sd92_i_tipoproc,
                                  sd92_i_anocomp,
                                  sd92_i_mescomp)
   		                    VALUES(nextval('sau_siasih_sd92_i_codigo_seq'),
       			    	          '$c1',
   			    	              '$c2',
   			    	              $tipoproc,
   			    	              $c3,
   			    	              $c4)";
   $query = @pg_query($sql);
   if($query){
	echo "SiaSih: $c1 - $c2 - Comp: $c3/$c4 Incluido<br>\n";
   	$count1++;
   }else{
	echo "SiaSih: $c1 - $c2 - Comp: $c3/$c4 Não Incluido<br>\n";
   	$count2++;
    system("echo \"$sql\" >> $arq1");
   }
  }

  echo "Total: ".count($file)."\n";
  echo "Total Incluído:".$count1."\n";
  echo "Total Não Incluído:".$count2."\n";
?>