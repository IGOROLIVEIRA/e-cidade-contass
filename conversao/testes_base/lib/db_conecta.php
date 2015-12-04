<?
//

$ConfigINI = parse_ini_file("db_conecta.ini");

$sDataSource = "host={$ConfigINI["ConfigConexao_host"]} 
                dbname={$ConfigINI["ConfigConexao_dbname"]} 
                port={$ConfigINI["ConfigConexao_port"]} 
                user={$ConfigINI["ConfigConexao_user"]} 
                password={$ConfigINI["ConfigConexao_password"]}";

db_log("- BASE PARA IMPORTACAO Prefeitura: $sDataSource", $sArquivoLog);

if(!($pConexao = pg_connect($sDataSource))) {
  db_log("Erro ao conectar no DBPortal ($sDataSource)...", $sArquivoLog);
  die();
}

?>
