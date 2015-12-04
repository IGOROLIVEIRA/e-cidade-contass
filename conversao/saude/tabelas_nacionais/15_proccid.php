<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/15_sau_proccid_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  //financiamento
  $file = file("arquivos/rl_procedimento_cid.txt");
  for($x=0; $x < count($file); $x++){
   $procedimento = @pg_result(@pg_query("select sd63_i_codigo from sau_procedimento where sd63_c_procedimento = '".trim(substr($file[$x],0,10))."'"),0,0);
   if($procedimento == ""){
     echo $erro = 'Procedimento '.trim(substr($file[$x],0,10)).' não cadastrado!';
     system("echo \"$erro\" >> $arq1");
     continue;
   }
		     
   $cid          = @pg_result(@pg_query("select sd70_i_codigo from sau_cid         where sd70_c_cid          = '".trim(substr($file[$x],10,4))."'"),0,0);
   if($cid == ""){
    echo $erro = 'Cid '.trim(substr($file[$x],10,4)).' não cadastrado!';
    system("echo \"$erro\" >> $arq1");
    continue;
   }   
   $c1 = trim(substr($file[$x],14,1));
   $c2 = trim(substr($file[$x],15,4));
   $c3 = trim(substr($file[$x],19,2));

   $sql = "INSERT INTO sau_proccid(sd72_i_codigo,
								   sd72_i_procedimento,
								   sd72_i_cid,
								   sd72_c_principal,
								   sd72_i_anocomp,
								   sd72_i_mescomp  )
        		    		   VALUES(nextval('sau_proccid_sd72_i_codigo_seq'),
   			    	                  $procedimento,
   			    	                  $cid,
       			 	                  '$c1',
   				                      $c2,
   				                      $c3)";
   $query = @pg_query($sql);
   if($query){
	echo "Proc: $procedimento - Cid: $cid - Principal: $c1 - Comp: $c2/$c3 Incluido<br>\n";
   	$count1++;
   }else{
	echo "Proc: $procedimento - Cid: $cid - Principal: $c1 - Comp: $c2/$c3 Não Incluido<br>\n";
   	$count2++;
    system("echo \"$sql\" >> $arq1");
   }
  }

  echo "Total: ".count($file)."\n";
  echo "Total Incluído:".$count1."\n";
  echo "Total Não Incluído:".$count2."\n";
?>
