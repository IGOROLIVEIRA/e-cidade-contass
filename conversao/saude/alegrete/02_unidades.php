<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "erros/02_unidades.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;


  $file = file("arquivos/unidades.txt");

  for($x=2; $x < count($file)-2; $x++){
     $linha = $file[$x];
     $arr_linha = explode( "|", $linha );

     $sd02_i_codigo=(int)$arr_linha[0];
     $sd02_i_cgm=1;
     $sd02_i_diretor=1;
     $sd02_i_distrito=(int)$arr_linha[1];
     $sd02_i_regiao=(int)$arr_linha[2];

     $sd02_c_siasus=trim($arr_linha[4]);

     $sql = "insert into unidades(sd02_i_codigo, sd02_i_numcgm,sd02_i_diretor, sd02_i_distrito, sd02_i_regiao, sd02_c_siasus,
                                  sd02_i_cod_ativ,sd02_i_codnivhier,sd02_i_cod_client,
				  sd02_i_cod_esfadm,sd02_i_cod_natorg,sd02_i_reten_trib,sd02_i_tp_unid_id,sd02_i_cod_turnat
                                 )
                          values ($sd02_i_codigo, $sd02_i_cgm, $sd02_i_diretor, $sd02_i_distrito, $sd02_i_regiao, '$sd02_c_siasus',
			         null, null, null,
				 null, null, null, null, null
			         )
            ";

     $query = @pg_query($sql);
     if(!$query){
	echo $erro = pg_errormessage()."\n".$sql; 
        system("echo \"$erro\" >> $arq1");
	$count2++;
     }else{
	echo ".";
	$count1++;
     }
   }

   echo "\n Total de Unidades: ".(count($file)-4)."\n";
   echo "Total de Uniaddes Incluído:".$count1."\n";
   echo "Total de Unidades não Incluído:".$count2."\n";
?>

