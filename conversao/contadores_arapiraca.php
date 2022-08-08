<?
$str_arquivo = $_SERVER['PHP_SELF'];
set_time_limit(0);

require(__DIR__ . "/../libs/db_stdlib.php");
//require (__DIR__ . "/../libs/db_conn.php");

$DB_USUARIO = "dbseller";
$DB_SERVIDOR = "127.0.0.1";
$DB_BASE = "dbseller";
$DB_PORTA="5432";
$DB_SENHA="dbspg3rprc900";

if(!($conn1 = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE user=$DB_USUARIO port=$DB_PORTA password=$DB_SENHA"))) {
  echo "erro ao conectar...\n ";
  exit;
}


echo $str_hora = date( "h:m:s" );

system( "clear" );

echo "Selecionando.........\n";
$codigo ="";
$erro = false;
pg_exec( $conn1, "begin;");

$sql = "select * from contadores";
$result = pg_query( $conn1, $sql );
$linhas = pg_num_rows( $result );
for( $i=0; $i<$linhas; $i++ ){
  db_fieldsmemory( $result, $i );
  echo "Processando registro $i de $linhas!! \n";

  $seq= pg_exec($conn1,"select nextval('cgm_z01_numcgm_seq')");
  $cod= pg_result($seq,0,0);
		//echo "\n issvarsemmov = $cod_semmov";
		$insert_cgm = "
			insert into cgm (  z01_numcgm,
					 z01_cgccpf, 
					 z01_nome   ,
					 z01_ender  ,
					 z01_numero ,
					 z01_compl  ,
					 z01_bairro ,
					 z01_cep    ,
					 z01_munic  ,
					 z01_uf     ,
					 z01_telef  ,
					 z01_fax)
			values($cod,'00000000000000','$nome','$endereco_logradouro',$endereco_numero,
			'$endereco_complemento','$endereco_bairro','$endereco_cep','Arapiraca','AL','$telefone','$fax')";
		echo "\n incluiu cgm";
		$result_cgm = pg_exec( $conn1, $insert_cgm ) or die ($insert_cgm);
		if( $result_cgm == false ){
		  $erro = true;
		  $erromsg = pg_last_error();
		  break;
		}
		$seq_usu= pg_exec($conn1,"select nextval('db_usuarios_id_usuario_seq')");
		$cod_usu= pg_result($seq_usu,0,0);
		$senha = $cod;
		$insert_usu= "insert into db_usuarios (id_usuario,nome,login,senha,usuarioativo,email,usuext)
                  values($cod_usu,'$nome','$cod','".(@$senha==""?'':(~$senha))."','1','',1)";
		$result_usu = pg_exec( $conn1, $insert_usu ) or die ($insert_usu);
		echo "\n incluiu usuario \n";
		if( $result_usu == false ){
		  $erro = true;
		  $erromsg = pg_last_error();
		  break;
		}
	
		$insert_uc = "insert into db_usuacgm (id_usuario,cgmlogin) values ($cod_usu,$cod)";
		$result_uc = pg_exec( $conn1, $insert_uc ) or die ($insert_uc);
		echo "\n incluiu db_usuacgm \n";
		if( $result_uc == false ){
		  $erro = true;
		  $erromsg = pg_last_error();
		  break;
		}

		
}
if ($erro == false) {
  pg_exec($conn1, "commit;");
  echo "\n processamento ok...\n";
}
else {
  pg_exec($conn1, "rollback;");
  echo "\n erro durante o processamento...\n $erromsg";
  exit;
}

?>