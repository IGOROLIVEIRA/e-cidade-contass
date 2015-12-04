<?

db_log("- BASE PARA IMPORTACAO sam30: $DB_BASE_SAM30 - $DB_SERVIDOR_SAM30", $sArqLog);

$sDataSourceSam30 = "host=$DB_SERVIDOR_SAM30 dbname=$DB_BASE_SAM30 port=$DB_PORTA_SAM30 user=$DB_USUARIO password=$DB_SENHA";
if(!($conn2 = pg_connect($sDataSourceSam30))) {
  db_log("Erro ao conectar no Sam30... ($sDataSourceSam30)", $sArqLog);
  die();
}

?>
