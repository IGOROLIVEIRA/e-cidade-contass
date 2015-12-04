<?
//
// Configuracoes para programas de Conversão
//

if (isset($sArquivoConfig)) {
  $ConfigINI = parse_ini_file("$sArquivoConfig");
} else {
  $ConfigINI = parse_ini_file("db_config.ini");
}

// ORIGEM 1
$ConfigConexaoOrigem1["host"]     = $ConfigINI["ConfigConexaoOrigem1_host"];
$ConfigConexaoOrigem1["port"]     = $ConfigINI["ConfigConexaoOrigem1_port"];
$ConfigConexaoOrigem1["dbname"]   = $ConfigINI["ConfigConexaoOrigem1_dbname"];
$ConfigConexaoOrigem1["user"]     = $ConfigINI["ConfigConexaoOrigem1_user"];
$ConfigConexaoOrigem1["password"] = $ConfigINI["ConfigConexaoOrigem1_password"];
/*
// ORIGEM 2     
$ConfigConexaoOrigem2["host"]     = $ConfigINI["ConfigConexaoOrigem2_host"];
$ConfigConexaoOrigem2["port"]     = $ConfigINI["ConfigConexaoOrigem2_port"];
$ConfigConexaoOrigem2["dbname"]   = $ConfigINI["ConfigConexaoOrigem2_dbname"];
$ConfigConexaoOrigem2["user"]     = $ConfigINI["ConfigConexaoOrigem2_user"];
$ConfigConexaoOrigem2["password"] = $ConfigINI["ConfigConexaoOrigem2_password"];

// FIREBIRD     
$ConfigConexaoFirebird["host"]     = $ConfigINI["ConfigConexaoFirebird_host"];
$ConfigConexaoFirebird["user"]     = $ConfigINI["ConfigConexaoFirebird_user"];
$ConfigConexaoFirebird["password"] = $ConfigINI["ConfigConexaoFirebird_password"];
*/
// DESTINO 1   
$ConfigConexaoDestino1["host"]     = $ConfigINI["ConfigConexaoDestino1_host"];
$ConfigConexaoDestino1["port"]     = $ConfigINI["ConfigConexaoDestino1_port"];
$ConfigConexaoDestino1["dbname"]   = $ConfigINI["ConfigConexaoDestino1_dbname"];
$ConfigConexaoDestino1["user"]     = $ConfigINI["ConfigConexaoDestino1_user"];
$ConfigConexaoDestino1["password"] = $ConfigINI["ConfigConexaoDestino1_password"];
/*
// DESTINO 2
$ConfigConexaoDestino2["host"]     = $ConfigINI["ConfigConexaoDestino2_host"];
$ConfigConexaoDestino2["port"]     = $ConfigINI["ConfigConexaoDestino2_port"];
$ConfigConexaoDestino2["dbname"]   = $ConfigINI["ConfigConexaoDestino2_dbname"];
$ConfigConexaoDestino2["user"]     = $ConfigINI["ConfigConexaoDestino2_user"];
$ConfigConexaoDestino2["password"] = $ConfigINI["ConfigConexaoDestino2_password"];
*/
?>
