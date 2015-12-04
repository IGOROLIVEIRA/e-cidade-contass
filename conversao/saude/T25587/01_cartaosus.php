<?
require("db_fieldsmemory.php");
require("db_conn.php");

if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
  echo "erro ao conectar...\n";
  exit;
}

$arq1 = "erro_cartaosus.txt";
system("> $arq1");
system("bunzip2 -f tb_ms_usuario.sql.bz2");



echo "\n Abrindo tb_ms_usuario.sql...";
$filename = "tb_ms_usuario.sql";
$handle   = fopen ($filename, "r");
$conteudo = fread ($handle, filesize ($filename));
@pg_query( "drop table tb_ms_usuario;" );

echo "\n Importando tb_ms_usuario.sql...";
pg_query( $conteudo ) or die( pg_errormessage() );
 
//seleciona toda tabela vinda do cartao sus
$result  = pg_query("select * from tb_ms_usuario order by no_usuario, tp_cartao ");
$nomeant = "";

pg_query("begin");

echo "\n\n Entrando no laço: ";
$xtot = pg_num_rows($result); 
for( $x=0; $x<$xtot; $x++){
	db_fieldsmemory($result,$x);
	system( "clear" );
	echo "\n\n Registros: [ $x de $xtot ] ".number_format($x*100/$xtot, 2 )."%";
	echo "\n $no_usuario, $co_numero_cartao"; 
	
	//monta condição para pegar cgs
	$cpf = trim($cpf);
	$ci  = trim($ci);
	$condicao = " z01_v_nome = '".trim($no_usuario)."'";
	if( strlen($cpf)>0) {
		$condicao = "z01_v_cgccpf = '".$cpf."'";
	}else if( strlen($ci)>0  ){
		$condicao = "z01_v_ident = '".$ci."'";
	}
	
	if( $nomeant != $no_usuario ){
		$nomeant = $no_usuario;
		$result_cgs = pg_query( "select *
									from cgs_cartaosus
									where s115_c_cartaosus = '$co_numero_cartao'
									");
		if( pg_num_rows( $result_cgs ) == 0 ){ 
			$result_cgs = pg_query( "select z01_i_cgsund
										from cgs_und
										inner join cgs on cgs.z01_i_numcgs = cgs_und.z01_i_cgsund 
										where $condicao
										");
			if( pg_num_rows( $result_cgs ) > 0 ){
				db_fieldsmemory($result_cgs,0);
				//echo "\n $z01_i_cgsund - $co_numero_cartao - $condicao - $cpf ".strlen($cpf)."- $ci".strlen($ci)." -";
				$update = "insert into cgs_cartaosus ( s115_i_codigo, s115_i_cgs, s115_c_cartaosus, s115_c_tipo )
							values( nextval('cgs_cartaosus_codigo_seq'), $z01_i_cgsund, '$co_numero_cartao', '$tp_cartao' )";
				$result_ins = pg_query($update);// or die( "ERRO: $update \n ".pg_errormessage() );
				if( pg_affected_rows($result_ins) == 0 ){
					$insert .= "\n".pg_errormessage(); 
					system("echo \"$insert\" >> $arq1");
				}
			}
		}
		
	}
}


pg_query("commit");

?>