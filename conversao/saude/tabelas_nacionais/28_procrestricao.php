<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/28_sau_execao_compatibilidade_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  $file = file("arquivos/rl_excecao_compatibilidade.txt");
  for($x=0; $x < count($file); $x++){
   $procrestricao  = @pg_result(@pg_query("select sd63_i_codigo   from sau_procedimento  where sd63_c_procedimento = '".trim(substr($file[$x],0,10))."'"),0,0);
   if($procrestricao == ""){
     echo $erro = 'Procedimento '.trim(substr($file[$x],0,10)).' não cadastrado!';
     system("echo \"$erro\" >> $arq1");
     continue;
   }
		        
   $procprincipal  = @pg_result(@pg_query("select sd63_i_codigo   from sau_procedimento  where sd63_c_procedimento = '".trim(substr($file[$x],10,10))."'"),0,0);
   if($procprincipal == ""){
    echo $erro = 'Procedimento Principal'.trim(substr($file[$x],10,10)).' não cadastrado!';
    system("echo \"$erro\" >> $arq1");
    continue;
   }
		        
   $proccompativel = @pg_result(@pg_query("select sd63_i_codigo   from sau_procedimento  where sd63_c_procedimento = '".trim(substr($file[$x],22,10))."'"),0,0);
   if($proccompativel == ""){
    echo $erro = 'Procedimento Compativel'.trim(substr($file[$x],22,10)).' não cadastrado!';
    system("echo \"$erro\" >> $arq1");
    continue;
   }
		        
   $regprincipal   = @pg_result(@pg_query("select sd84_i_codigo   from sau_registro      where sd84_c_registro     = '".trim(substr($file[$x],20,2))."'"),0,0);
   if($regprincipal == ""){
    echo $erro = 'Reg. Principal '.trim(substr($file[$x],20,2)).' não cadastrado!';
    system("echo \"$erro\" >> $arq1");
    continue;
   }
		        
   $regcompativel  = @pg_result(@pg_query("select sd84_i_codigo   from sau_registro      where sd84_c_registro     = '".trim(substr($file[$x],32,2))."'"),0,0);
   if($regcompativel == ""){
    echo $erro = 'Reg. Compativel '.trim(substr($file[$x],32,2)).' não cadastrado!';
    system("echo \"$erro\" >> $arq1");
    continue;
   }   
   
   $c1 = trim(substr($file[$x],34,1));
   $c2 = trim(substr($file[$x],35,4));
   $c3 = trim(substr($file[$x],39,2));


   $sql = "INSERT INTO sau_execaocompatibilidade(sd67_i_codigo,
										  sd67_i_procrestricao,
										  sd67_i_procprincipal,
										  sd67_i_regprincipal,
										  sd67_i_proccompativel,
										  sd67_i_regcompativel,
										  sd67_i_compatibilidade,
										  sd67_i_anocomp,
										  sd67_i_mescomp)
       		                    VALUES(nextval('sau_execaocompatibilidade_sd67_i_codigo_seq'),
       			    	               $procrestricao,
       			    	               $procprincipal,
       			    	               $regprincipal,
       			    	               $proccompativel,
       			    	               $regcompativel,
       			    	               $c1,
       			    	               $c2,
       			    	               $c3)";
   $query = @pg_query($sql);
   if($query){
	echo "Restricao: $procrestricao - ProcPrinc: $procprincipal - Compativel: $proccompativel - Comp: $c2/$c3 Incluido<br>\n";
   	$count1++;
   }else{
	echo "Restricao: $procrestricao - ProcPrinc: $procprincipal - Compativel: $proccompativel - Comp: $c2/$c3 Não Incluido<br>\n";
   	$count2++;
    system("echo \"$sql\" >> $arq1");
   }
  }

  echo "Total: ".count($file)."\n";
  echo "Total Incluído:".$count1."\n";
  echo "Total Não Incluído:".$count2."\n";
?>
