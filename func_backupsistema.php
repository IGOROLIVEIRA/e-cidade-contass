<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

system("rm -R /var/www/e-cidade/backup_e-cidade_*");
system("pg_dump -U dbportal e-cidade | bzip2 -c > /var/www/e-cidade/backup_e-cidade_".date("dmY").".sql.bz2");

// As linhas abaixo forçam o download do arquivo
/*$link = "/var/www/e-cidade/backup_e-cidade_".date("dmY").".sql.bz2";
header ("Content-Disposition: attachment; filename="."backup_e-cidade_".date("dmY").".sql.bz2");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($link));
readfile($link);
*/

echo json_encode("/var/www/e-cidade/backup_e-cidade_".date("dmY").".sql.bz2");

?>
