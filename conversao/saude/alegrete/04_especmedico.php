<?

 include("db_conn.php");
 include("db_fieldsmemory.php");
 if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
 }

  $arq1 = "erros/04_especmedico.txt";
  system( "clear" );
  system("> $arq1");

  $count1=0;
  $count2=0;

$filename="arquivos/especmedico_sql.sql";
echo "$filename \n";
$handle = fopen ($filename, "r"); 
$conteudo = fread ($handle, filesize ($filename));
$result=pg_query( $conteudo );// or die( pg_errormessage() );



  $file = file("arquivos/conver_especmedico.csv");


  for($x=1; $x < count($file)-1; $x++){
     $linha = $file[$x];
     $arr_linha = explode( ",", $linha );

     $sd03_i_cgm=(int)$arr_linha[0];
     $sd27_i_rhcbo=trim($arr_linha[5]);

     $sql = "select * from unidademedicos where sd04_i_medico = $sd03_i_cgm";
     $result = pg_query($sql);
     for( $y=0; $y < pg_numrows($result); $y++ ){
	db_fieldsmemory( $result, $y );
	$sql = "select rh70_sequencial from rhcbo where rh70_estrutural='$sd27_i_rhcbo' and rh70_tipo=4";
        $result1 = pg_query($sql );
	if( pg_numrows($result1) > 0 ){
	  db_fieldsmemory( $result1, 0 );

	  $sql = "insert into especmedico (sd27_i_codigo, sd27_i_rhcbo, sd27_i_undmed )
				    values (nextval('especmedico_i_codigo_seq'), $rh70_sequencial, $sd04_i_codigo )
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
	 }else{
	   echo "\n CBO nao encontrado  >> $linha ";
	   system("echo \"$erro\" >> $arq1");
	 }
     }
     if( pg_numrows($result) == 0 ){
	echo "\n Linha $x nao incluida  >> $linha ";
	system("echo \"$erro\" >> $arq1");
     }
   }

   @pg_query( "select setval('especmedico_i_codigo_seq', ( select sd27_i_codigo from especmedico order by sd27_i_codigo desc limit 1 ) ) " );
   echo "\n Total de EspecMedicos: ".(count($file)-4)."\n";
   echo "Total de EspecMedicos Incluído:".$count1."\n";
   echo "Total de EspecMedicos não Incluído:".$count2."\n";

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

