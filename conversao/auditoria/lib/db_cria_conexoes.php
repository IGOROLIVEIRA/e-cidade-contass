<?
// á
$sDataSource = "host={$ConfigConexao["host"]} 
                dbname={$ConfigConexao["dbname"]} 
                port={$ConfigConexao["port"]} 
                user={$ConfigConexao["user"]} 
                password={$ConfigConexao["password"]}";

db_log("- BASE PARA PROCESSAMENTO  : $sDataSource", $sArquivoLog);

if(!($pConexao = pg_connect($sDataSource))) {
  db_log("Erro ao conectar na  ($sDataSource)...", $sArquivoLog);
  die();
}



?>
