<?php
if (!function_exists("pg_connect")) {

  dl("pgsql.so");
}

require(__DIR__ . "/../libs/db_utils.php");
$DB_USUARIO  = "postgres";
$DB_SENHA    = "";
$DB_SERVIDOR = "localhost"; //ip do servidor.
$DB_BASE     = "carazinho_empenhos"; //nome da base de dados
$DB_PORTA    = "5432";
$DB_SELLER   = "on";
echo "inicio da migracao: ".date("d/m/Y")." - ".date("h:i:s")."\n";
echo "Conectando...\n";
if(!($conn1 = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE       port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){
  echo "erro ao conectar...\n";
  exit;
}
echo "Iniciando Procedimento..\n";
$sDeleteNotaItem   = "DELETE FROM empnotaitem using migra_empnotaitem where migra_empnotaitem.e72_codnota = empnotaitem.e72_codnota";
pg_query("begin");
$iErro = 0;
$rs1   = pg_query($sDeleteNotaItem); 
if ($rs1) {

  $sDeletePag  = "DELETE FROM pagordemnota using migra_pagordemnota where o72_codord = e71_codord and o72_codnota = e71_codnota";
  $rs2         = pg_query($sDeletePag);
  if ($rs2) {

    $sDeleteOCItem = "DELETE FROM matordemitem using migra_matordem where m52_codordem = m72_codordem;";
    $rs3           = pg_query($sDeleteOCItem);
    if ($rs3) {

      $sDeleteEmpOC  = "DELETE FROM empnotaord using migra_matordem where empnotaord.m72_codordem = migra_matordem.m72_codordem";
      $rs4           = pg_query($sDeleteEmpOC);
      if ($rs4) {

        $sDeleteOC = "DELETE FROM matordem using migra_matordem where m51_codordem = m72_codordem";
        $rs5       = pg_query($sDeleteOC);
        if ($rs5) {

          $sDeleteNota = " DELETE FROM empnotaele using migra_empnotaitem where e70_codnota = e72_codnota";
          $rs6         = pg_query($sDeleteNota); 
           
          $sDeleteNota = " DELETE FROM empnota using migra_empnotaitem where e69_codnota = e72_codnota";
          $rs6         = pg_query($sDeleteNota); 
          if ($rs6) {

            $sDeleteEmpnl  = " DELETE FROM empempenhonl using migra_empenhonl where e68_numemp = e76_empenho";
            $rs7           = pg_query($sDeleteEmpnl);

          } else {
            $iErro++;
          }
        } else {
          $iErro++;
        }
      } else {
        $iErro++; 
      }
    } else {
      $iErro++;  
    }
  } else {
    $iErro++;
  }
} else {
  $iErro++;
}
if ($iErro > 0) {

  pg_query("rollback");
  echo "Houve erro no processamento";

} else {
  
  pg_query("delete from migra_empnotaitem");
  pg_query("delete from migra_pagordemnota");
  pg_query("delete from migra_matordem");
  pg_query("delete from migra_empenhonl");
  pg_query("commit");
  echo "Operação efetuada com sucesso";

}
?>
