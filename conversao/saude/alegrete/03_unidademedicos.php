<?

 include("db_conn.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "erros/03_unidademedicos.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

$filename="arquivos/unidademedicos_sql.sql";
echo "$filename \n";
$handle = fopen ($filename, "r"); 
$conteudo = fread ($handle, filesize ($filename));
$result=pg_query( $conteudo );// or die( pg_errormessage() );




  $file = file("arquivos/unidademedicos.txt");
  $filemed = file("arquivos/medicos.txt");


  for($x=2; $x < count($file)-2; $x++){
     $linha = $file[$x];
     $arr_linha = explode( "|", $linha );

     $sd04_i_codigo=(int)$arr_linha[0];
     $sd04_i_unidade=(int)$arr_linha[1];
     $sd04_i_medico=(int)$arr_linha[2];
     $sd04_c_situacao=trim($arr_linha[3]);

     $sd04_i_numerodias=0;
     $sd04_v_registroconselho="";
     medico( $sd04_i_medico, $filemed );

     $sql = "insert into unidademedicos (sd04_i_codigo, sd04_i_unidade, sd04_i_medico, sd04_i_numerodias, sd04_v_registroconselho,
                                         sd04_c_situacao,
                                         sd04_i_orgaoemissor, sd04_i_vinculo
                                        )
                          values ($sd04_i_codigo, $sd04_i_unidade, $sd04_i_medico, $sd04_i_numerodias, '$sd04_v_registroconselho',
                                  '$sd04_c_situacao',
                                  null, null
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

   @pg_query( "select setval('unidademedicos_codigo_seq', ( select sd04_i_codigo from unidademedicos order by sd04_i_codigo desc limit 1 ) ) " );
   echo "\n Total de UnidadeMedicos: ".(count($file)-4)."\n";
   echo "Total de UnidadeMedicos Incluído:".$count1."\n";
   echo "Total de UnidadeMedicos não Incluído:".$count2."\n";

function medico( $medico, $dados ){
global $sd04_i_numerodias, $sd04_v_registroconselho;

  reset( $dados );
  foreach($dados as $ind => $cont) {
    $arr_linhamed = explode( "|", $cont );
    if($medico == (int)$arr_linhamed[0] ){
       $sd04_i_numerodias=(int)$arr_linhamed[2];
       $sd04_v_registroconselho=trim($arr_linhamed[1]);
    }
  }
}
   
?>

