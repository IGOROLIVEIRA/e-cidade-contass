<?php
include 'conexao_postgre.php';
//echo date('H:i');exit();
$rsResult = pg_query($conexao_postgre, "SELECT fc_startsession()");
$rsResult = pg_query($conexao_postgre, "SELECT z01_numcgm from cgm");

while ($aDados = pg_fetch_array($rsResult)) {
	$rsResultQuant = pg_query($conexao_postgre, "SELECT * FROM pcforne WHERE pc60_numcgm = {$aDados['z01_numcgm']}");
	
	if (pg_num_rows($rsResultQuant) > 0) {
		
		pg_query($conexao_postgre, "UPDATE pcforne SET pc60_dtlanc = '".date('Y-m-d')."', pc60_obs = '',
		pc60_bloqueado = 'f', pc60_hora = '".date('H:i')."', pc60_usuario = 1 WHERE pc60_numcgm = {$aDados['z01_numcgm']}");
		
	} else {
	
		pg_query($conexao_postgre, "INSERT INTO pcforne VALUES ({$aDados['z01_numcgm']},'".date('Y-m-d')."','',
		'f','".date('H:i')."',1)");
		
	}
	
}

$rsResult = pg_query($conexao_postgre, "SELECT * FROM pcforne");
echo pg_num_rows($rsResult);

?>
