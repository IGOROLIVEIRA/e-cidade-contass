<?

include("db_conn.php");
if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
	echo "erro ao conectar...\n";
 	exit;
}

//Verifica competencia
if( !isset($argv[1]) ){
	echo "\n Passagem de Parametros incoreta, dever� ser informado Ano M�s:  Ex: 200810 ";
	exit;
}

$comp = $argv[1];

 
$arq1 = "txt/26_sau_proccbo_erro_$comp.txt";
system( "clear" );
system("> $arq1");

$count1=0;
$count2=0;

//Procedimento X CBO
$file  = file("TabelaUnificada_".$comp."/rl_procedimento_ocupacao.txt");
$file2 = file("TabelaUnificada_".$comp."/tb_ocupacao.txt");

$erro = false;
pg_query("begin;");
for($x=0; $x < count($file); $x++){
	$procedimento  = @pg_result(@pg_query("select sd63_i_codigo   from sau_procedimento  where sd63_c_procedimento  = '".trim(substr($file[$x],0,10))."'"),0,0);
	if($procedimento == ""){
		echo $erro = 'Procedimento '.trim(substr($file[$x],0,10)).' n�o cadastrado!';
		system("echo \"$erro\" >> $arq1");
		continue;
	}
	
	// alterado em 2008/07/17 pois vinha mtos registros da rhcbo
	$result        = @pg_query("select rh70_sequencial
								  from rhcbo
								 where rh70_estrutural  = '".trim(substr($file[$x],10,6))."' order by rh70_sequencial ");
	$cbo           = @pg_result( $result,0,0 );
	if( pg_numrows( $result ) > 1 ){
		$nome = "";
		for($y=0; $y < count($file2); $y++){
			if(trim(substr($file[$x],10,6)) == trim(substr($file2[$y],0,6)))
				$nome       = trim(str_replace("'","",substr($file2[$y],6,156)));
		}
		
		if( $nome != "" ){
			$result = @pg_query("select rh70_sequencial
								   from rhcbo
								  where rh70_estrutural  = '".trim(substr($file[$x],10,6))."'
								    and upper(rh70_descr) = upper('".$nome."')
								  order by rh70_sequencial ");
			$cbo    = @pg_result( $result,0,0 );
		}
	}
	
	if($cbo == ""){
		for($y=0; $y < count($file2); $y++){
			if(trim(substr($file[$x],10,6)) == trim(substr($file2[$y],0,6))){
				$cbo        = pg_result(pg_query("select nextval('rhcbo_rh70_sequencial_seq')"),0,0);
				$estrutural = trim(substr($file2[$y],0,6));
				$nome       = trim(str_replace("'","",substr($file2[$y],6,156)));
				$sql_cbo    = "insert into rhcbo values($cbo, '$estrutural', '$nome', 4)";
				$query_cbo  = pg_query($sql_cbo) or die ( "\n $sql_cbo \n ".pg_errormessage() );
			}
		}
	}
	
	$c1 = trim(substr($file[$x],16,4));
	$c2 = trim(substr($file[$x],20,2));
	
	$sql = "INSERT INTO sau_proccbo (sd96_i_codigo,
                                       sd96_i_procedimento,
                                       sd96_i_cbo,
                                       sd96_i_anocomp,
                                       sd96_i_mescomp)
       		                    VALUES(nextval('sau_proccbo_sd96_i_codigo_seq'),
       			    	               $procedimento,
   			    	                   $cbo,
    				                   $c1,
    				                   $c2)";
    $query = @pg_query($sql);
    if($query){
    	echo "Proc: $procedimento - Cbo: $cbo - Comp: $c1/$c2 Incluido<br>\n";
    	$count1++;
    }else{
    	echo "Proc: $procedimento - Cbo: $cbo - Comp: $c1/$c2 N�o Incluido  ".pg_errormessage()."<br>\n";
    	$count2++;
    	system("echo \"$sql\" >> $arq1");
    	$erro = true;
    }
}
if( $erro ){
	pg_query("rollback;");
}else{
	pg_query("commit;");
}

echo "Total: ".count($file)."\n";
echo "Total Inclu�do:".$count1."\n";
echo "Total N�o Inclu�do:".$count2."\n";
?>
