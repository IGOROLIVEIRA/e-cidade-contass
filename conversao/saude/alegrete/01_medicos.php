<?
 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "erros/01_medicos.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;


  $file = file("arquivos/medicos.txt");

  for($x=2; $x < count($file)-2; $x++){
     $linha = $file[$x];
     $arr_linha = explode( "|", $linha );

     $sd03_i_codigo=(int)$arr_linha[0];
     $sd03_i_cgm=(int)$arr_linha[5];
     $sd03_i_numerodias=(int)$arr_linha[2];

     $sql = "insert into medicos (sd03_i_codigo, sd03_i_cgm)
                          values ($sd03_i_codigo, $sd03_i_cgm)
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

   @pg_query( "select setval('medicos_sd03_i_codigo_seq', ( select sd03_i_codigo from medicos order by sd03_i_codigo desc limit 1 ) ) " );
   echo "\n Total de Medicos: ".(count($file)-4)."\n";
   echo "Total de Medicos Incluído:".$count1."\n";
   echo "Total de Medicos não Incluído:".$count2."\n";
?>

