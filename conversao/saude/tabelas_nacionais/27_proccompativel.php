<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/27_sau_proccompativel_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  @pg_query("delete from sau_tipocompatibilidade");
  @pg_query("insert into sau_tipocompatibilidade Values(1, 'COMPATIVEL')");
  @pg_query("insert into sau_tipocompatibilidade Values(2, 'INCOMPATIVEL/EXCLUDENTE')");
  @pg_query("insert into sau_tipocompatibilidade Values(3, 'CONCOMITANTE')");

  $file = file("arquivos/rl_procedimento_compativel.txt");
  for($x=0; $x < count($file); $x++){
   $procprincipal  = @pg_result(@pg_query("select sd63_i_codigo   from sau_procedimento  where sd63_c_procedimento = '".trim(substr($file[$x],0,10))."'"),0,0);
   if($procprincipal == ""){
    echo $erro = 'Procedimento '.trim(substr($file[$x],0,10)).' não cadastrado!';
    system("echo \"$erro\" >> $arq1");
    continue;
   }
		        
   $proccompativel = @pg_result(@pg_query("select sd63_i_codigo   from sau_procedimento  where sd63_c_procedimento = '".trim(substr($file[$x],12,10))."'"),0,0);
   if($proccompativel == ""){
    echo $erro = 'Procedimento Compativel'.trim(substr($file[$x],12,10)).' não cadastrado!';
    system("echo \"$erro\" >> $arq1");
    continue;
   }
			
   $regprincipal   = pg_result(pg_query("select sd84_i_codigo   from sau_registro      where sd84_c_registro     = '".trim(substr($file[$x],10,2))."'"),0,0);
   if($regprincipal == ""){
    echo $erro = 'Reg Principal '.trim(substr($file[$x],10,2)).' não cadastrado!';
    system("echo \"$erro\" >> $arq1");
    continue;
   }
			
   $regcompativel  = pg_result(pg_query("select sd84_i_codigo   from sau_registro      where sd84_c_registro     = '".trim(substr($file[$x],22,2))."'"),0,0);
   if($regcompativel == ""){
     echo $erro = 'Reg Compativel'.trim(substr($file[$x],10,2)).' não cadastrado!';
     system("echo \"$erro\" >> $arq1");
     continue;
   }   
   $c1 = trim(substr($file[$x],24,1));
   $c2 = trim(substr($file[$x],25,4));
   $c3 = trim(substr($file[$x],29,4));
   $c4 = trim(substr($file[$x],33,2));

   $sql = "INSERT INTO sau_proccompativel(sd66_i_codigo,
										  sd66_i_procprincipal,
										  sd66_i_regprincipal,
										  sd66_i_proccompativel,
										  sd66_i_regcompativel,
										  sd66_i_compatibilidade,
										  sd66_i_qtd,
										  sd66_i_anocomp,
										  sd66_i_mescomp)
       		                    VALUES(nextval('sau_proccompativel_sd66_i_codigo_seq'),
       			    	               $procprincipal,
       			    	               $regprincipal,
       			    	               $proccompativel,
       			    	               $regcompativel,
       			    	               $c1,
       			    	               $c2,
       			    	               $c3,
       			    	               $c4)";
   $query = @pg_query($sql);
   if($query){
	echo "ProcPrinc: $procprincipal - Compativel: $proccompativel - Comp: $c3/$c4 Incluido<br>\n";
   	$count1++;
   }else{
	echo "ProcPrinc: $procprincipal - Compativel: $proccompativel - Comp: $c3/$c4 Não Incluido<br>\n";
   	$count2++;
    system("echo \"$sql\" >> $arq1");
   }
  }

  echo "Total: ".count($file)."\n";
  echo "Total Incluído:".$count1."\n";
  echo "Total Não Incluído:".$count2."\n";
?>
