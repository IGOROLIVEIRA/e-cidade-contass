<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "txt/22_sau_servclassificacao_erro.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

  //financiamento
  $file = file("arquivos/tb_servico_classificacao.txt");
  for($x=0; $x < count($file); $x++){
   $servico = pg_result(pg_query("select sd86_i_codigo from sau_servico where sd86_c_servico = '".trim(substr($file[$x],0,3))."'"),0,0);
   if($servico == ""){
    echo $erro = 'Servico '.trim(substr($file[$x],0,3)).' não cadastrado!';
    system("echo \"$erro\" >> $arq1");
    continue;
   }
		     
   $c1 = trim(substr($file[$x],3,3));
   $c2 = trim(substr($file[$x],6,150));
   $c3 = trim(substr($file[$x],156,4));
   $c4 = trim(substr($file[$x],160,2));


   $sql = "INSERT INTO sau_servclassificacao(sd87_i_codigo,
									         sd87_c_classificacao,
											 sd87_c_nome,
											 sd87_i_servico,
											 sd87_i_anocomp,
											 sd87_i_mescomp)
        		                 VALUES(nextval('sau_servclassificacao_sd87_i_codigo_seq'),
       			    	                '$c1',
       			    	                '$c2',
       			    	                $servico,
    				                    $c3,
    				                    $c4)";
   $query = @pg_query($sql);
   if($query){
	echo "Serv: $servico - Classificacao: $c1 - Comp: $c3/$c4 Incluido<br>\n";
   	$count1++;
   }else{
	echo "Serv: $servico - Classificacao: $c1 - Comp: $c3/$c4 Não Incluido<br>\n";
   	$count2++;
    system("echo \"$sql\" >> $arq1");
   }
  }

  echo "Total: ".count($file)."\n";
  echo "Total Incluído:".$count1."\n";
  echo "Total Não Incluído:".$count2."\n";
?>
