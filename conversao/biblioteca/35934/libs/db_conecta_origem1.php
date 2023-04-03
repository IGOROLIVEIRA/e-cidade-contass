<?

$sDataSourceOrigem1 = "host={$ConfigConexaoOrigem1["host"]} dbname={$ConfigConexaoOrigem1["dbname"]} port={$ConfigConexaoOrigem1["port"]} user={$ConfigConexaoOrigem1["user"]} password={$ConfigConexaoOrigem1["password"]}";

db_log("- BASE PARA IMPORTACAO Origem 1: $sDataSourceOrigem1", $sArquivoLog);

if(!($pConexaoOrigem1 = pg_connect($sDataSourceOrigem1))) {
  db_log("Erro ao conectar na Origem 1 ($sDataSourceOrigem1)...", $sArquivoLog);
  die();
}

?>
