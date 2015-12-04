<?

db_log("- BASE PARA IMPORTACAO dbportal: $DB_BASE - $DB_SERVIDOR", $sArqLog);

$sDataSourceDBPortal = "host=$DB_SERVIDOR dbname=$DB_BASE       port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA";
if(!($conn1 = pg_connect($sDataSourceDBPortal))) {
  db_log("Erro ao conectar no DBPortal ($sDataSourceDBPortal)...", $sArqLog);
  die();
}

?>
