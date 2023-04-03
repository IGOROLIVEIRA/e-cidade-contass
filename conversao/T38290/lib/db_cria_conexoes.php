<?


$sDataSourceDestino = "host={$ConfigConexaoDestino["host"]} 
                       dbname={$ConfigConexaoDestino["dbname"]} 
                       port={$ConfigConexaoDestino["port"]} 
                       user={$ConfigConexaoDestino["user"]} 
                       password={$ConfigConexaoDestino["password"]}";

db_log("- BASE PARA IMPORTACAO Destino : $sDataSourceDestino", $sArquivoLog);

if(!($pConexaoDestino = pg_connect($sDataSourceDestino))) {
  db_log("Erro ao conectar na Destino ($sDataSourceDestino)...", $sArquivoLog);
  die();
}



?>
