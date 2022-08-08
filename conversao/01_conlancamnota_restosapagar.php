<?php
if (!function_exists("pg_connect")) {

  dl("pgsql.so");
}
require(__DIR__ . "/../libs/db_utils.php");
$DB_USUARIO         = "postgres";
$DB_SENHA           = "";
$DB_SERVIDOR        = "192.168.0.25"; //ip do servidor.
$DB_BASE            = "auto_sapiranga_20110323_v2_2_49"; //nome da base de dados
$DB_PORTA           = "5432";
$DB_SELLER          = "on";
echo "inicio da migracao: ".date("d/m/Y")." - ".date("h:i:s");
echo "Conectando...\n";
$nomearquivo  = "/tmp/correcao_lancamentos_restos_pagar_nota.log";
$fp           = fopen ("{$nomearquivo}", "w");

if(!($conn1 = pg_connect("host='$DB_SERVIDOR' dbname='$DB_BASE' port='$DB_PORTA' user='$DB_USUARIO'"))){

  echo "erro ao conectar...\n";
  exit;
}
pg_query("begin");
pg_query("select fc_startsession()");
$sSqlLancamentos  = "SELECT * ";
$sSqlLancamentos .= " From conlancam ";
$sSqlLancamentos .= "      inner join conlancamdoc on c71_codlan = c70_codlan ";
$sSqlLancamentos .= "      inner join conlancamemp on c75_codlan = c70_codlan ";
$sSqlLancamentos .= "      left join conlancamnota on c66_codlan = c70_codlan ";
$sSqlLancamentos .= " where c71_coddoc = 31 ";
$sSqlLancamentos .= "   and c66_codlan is null";

$rsLancamentos       = pg_query($sSqlLancamentos);
$iNumRowsLancamentos = pg_num_rows($rsLancamentos);
$aEmpenhosMigrados   = array();
for ($i = 0; $i < $iNumRowsLancamentos; $i++) {
  
  
  $oLancamento = db_utils::fieldsMemory($rsLancamentos, $i);
  echo "Migrando Empenho ".($i+1)." de {$iNumRowsLancamentos}\r\n";
  /**
   * verificamos se o empenho possui mais de um anota.
   * caso enviamos o empenho para o array $aEmpenhosMigrados.
   */
  
  $sSqlNumeroNotas = "select * from empnota where e69_numemp = {$oLancamento->c75_numemp}";
  $rsNumeroNotas   = pg_query($sSqlNumeroNotas);
  if (pg_num_rows($rsNumeroNotas) > 1) {

    $aEmpenhosMigrados["naomigrados"][$oLancamento->c75_numemp] = "Empenho {$oLancamento->c75_numemp} com mais de uma nota";
    continue; 
  } else if (pg_num_rows($rsNumeroNotas) == 0) {
    
    $aEmpenhosMigrados["naomigrados"][$oLancamento->c75_numemp] = "Empenho {$oLancamento->c75_numemp} sem nota fiscal lançada";
    continue;  
  } else {
    
    echo $oLancamento->c75_numemp."\n";
    $oNota = db_utils::fieldsMemory($rsNumeroNotas, 0); 
    print_r($oNota);
    
    /**
     * insermos para esse empenho, os dados na tabela conlancamord, e conlancamnota.
     */
    $sInsertConlancamNota  = "insert into conlancamnota ";
    $sInsertConlancamNota .= "       (c66_codlan,"; 
    $sInsertConlancamNota .= "        c66_codnota) ";
    $sInsertConlancamNota .= " values ({$oLancamento->c70_codlan}, ";
    $sInsertConlancamNota .= "         {$oNota->e69_codnota}) ";
    $rsInsertConlancamNota = @pg_query($sInsertConlancamNota);
    $aEmpenhosMigrados["migrados"][$oLancamento->c75_numemp] = "Empenho {$oLancamento->c75_numemp}.";
  }
 
}
pg_query("commit");
fputs($fp, "-------------- Empenhos nao Migrados:-----------------\n");
foreach ($aEmpenhosMigrados["naomigrados"] as $iNumEmp => $sMensagem) {
  fputs($fp, "$sMensagem\n");  
}
fputs($fp, "\n\n-------------- Empenhos Migrados:-----------------\n");
foreach ($aEmpenhosMigrados["migrados"] as $iNumEmp => $sMensagem) {
  fputs($fp, "$sMensagem\n");  
}
fclose($fp);
echo "\nFim da migracao: ".date("d/m/Y")." - ".date("h:i:s");
?>
