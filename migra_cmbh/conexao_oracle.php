<?php

// Conex�o com Oracle usando OCI
/*$user='system'; // seta o usu�rio
$pass='123'; // seta a senha
$db='rps_dump'; // Inst�ncia do banco de dados

ci_connect
$conexao=ocilogon($user,$pass,$db);

if ($conexao) {
 echo "deu certo";
}*/

$conexao_oracle = oci_connect('rps_dump', 'rps_dump', '172.16.255.250/orateste','WE8ISO8859P1');
 
/*if (!$conexao_oracle){
	echo "n�o deu certo";
} else {
	echo "deu certo";
}
exit;*/
			   
?>
