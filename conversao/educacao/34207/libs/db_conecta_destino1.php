<?

$sDataSourceDestino1 = "host={$ConfigConexaoDestino1["host"]} dbname={$ConfigConexaoDestino1["dbname"]} port={$ConfigConexaoDestino1["port"]} user={$ConfigConexaoDestino1["user"]} password={$ConfigConexaoDestino1["password"]}";

db_log("- BASE PARA IMPORTACAO Destino 1: $sDataSourceDestino1", $sArquivoLog);

if(!($pConexaoDestino1 = pg_connect($sDataSourceDestino1))) {
  db_log("Erro ao conectar na Destino 1 ($sDataSourceDestino1)...", $sArquivoLog);
  die();
}

?>
