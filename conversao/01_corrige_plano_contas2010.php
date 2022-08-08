<?php

$str_arquivo = $_SERVER['PHP_SELF'];
set_time_limit(0);

require(__DIR__ . "/../libs/db_stdlib.php");
require(__DIR__ . "/../libs/db_utils.php");
require (__DIR__ . "/../libs/db_conn.php");
echo "Conectando...\n";


//
// VARIAVEIS DE CONFIGURACAO DA CONEXAO COM O BANCO DE DADOS
//
$DB_USUARIO  = "postgres";
$DB_SERVIDOR = "localhost";
$DB_BASE     = "sapiranga_teste_folha";

if(!($conn1 = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE user=$DB_USUARIO "))) {
  echo "erro ao conectar...\n";
  exit;
}

system( "clear" );
echo $str_hora = date( "h:m:s" )."\n";

$erro        = false;
$iAnoInicial = 2010; 
$iAnofinal   = 2013; 
pg_query($conn1, "begin;");

/**
 * Selecionamos da conplano a partir do ano inicial, e atualizamos os dados ate o ultimo ano cadastrado;
 */
echo "Atualizando Plano de contas 2010 - 2013\n";
$sSqlConplano     = "select * from conplano where c60_anousu = {$iAnoInicial}";
$rsConplano       = db_query($sSqlConplano);
$iNumRowsConplano = pg_num_rows($rsConplano);
$aConplano        = db_utils::getColectionByRecord($rsConplano);
foreach ($aConplano as $oPlano) {
   
  $iAnoInicialPlano   = $oPlano->c60_anousu+1;  
  for ($i = $iAnoInicialPlano; $i <= $iAnofinal; $i++) {
    
    /**
     * Atualizamos os dados da conplano
     */
    $sStrUpdate  = "update conplano ";
    $sStrUpdate .= "   set c60_estrut = '{$oPlano->c60_estrut}',";
    $sStrUpdate .= "       c60_descr  = '{$oPlano->c60_descr}',";
    $sStrUpdate .= "       c60_finali = '{$oPlano->c60_finali}',";
    $sStrUpdate .= "       c60_codsis = {$oPlano->c60_codsis},";
    $sStrUpdate .= "       c60_codcla = {$oPlano->c60_codcla}";
    $sStrUpdate .= " where c60_anousu = {$i} ";
    $sStrUpdate .= "   and c60_codcon = {$oPlano->c60_codcon} ";
    $rsUpdate    = db_query($sStrUpdate);
    if (!$rsUpdate) {

      echo "Erro ao Atualizar plano:{$oPlano->c60_codcon}.\n".pg_last_error()."\n";
      pg_query("rollback");
      exit;
      
    }
    echo "Atualizando conta {$oPlano->c60_codcon} ano {$i}\r";
  }
}
echo "\nAtualizando Receitas 2010 - 2013\n";
$sSqlReceitas     = "select * from orcfontes where o57_anousu = {$iAnoInicial}";
$rsReceitas       = db_query($sSqlReceitas);
$iNumRowsReceitas = pg_num_rows($rsReceitas);
$aReceitas        = db_utils::getColectionByRecord($rsReceitas);
foreach ($aReceitas as $oReceita) {
   
  $iAnoInicialPlano   = $oReceita->o57_anousu+1;  
  for ($i = $iAnoInicialPlano; $i <= $iAnofinal; $i++) {
    
    /**
     * Atualizamos os dados da conplano
     */    
    $sStrUpdate  = "update orcfontes ";
    $sStrUpdate .= "   set o57_fonte  = '{$oReceita->o57_fonte}',";
    $sStrUpdate .= "       o57_descr  = '{$oReceita->o57_descr}',";
    $sStrUpdate .= "       o57_finali = '{$oReceita->o57_finali}'";
    $sStrUpdate .= " where o57_anousu = {$i} ";
    $sStrUpdate .= "   and o57_codfon = {$oReceita->o57_codfon} ";
    $rsUpdate    = db_query($sStrUpdate);
    if (!$rsUpdate) {

      echo "Erro ao Atualizar receita:{$oReceita->o57_codfon}.\n".pg_last_error()."\n";
      pg_query("rollback");
      exit;
      
    }
    echo "Atualizando receita {$oReceita->o57_codfon} ano {$i}\r";
  }
}
echo "\nAtualizando Despesas 2010 - 2013\n";
$sSqlDespesas     = "select * from orcelemento where o56_anousu = {$iAnoInicial}";
$rsDespesas       = db_query($sSqlDespesas);
$iNumRowsDespesas = pg_num_rows($rsDespesas);
echo pg_last_error()."\n";
$aDespesas        = db_utils::getColectionByRecord($rsDespesas);
foreach ($aDespesas as $oDespesa) {
   
  $iAnoInicialPlano   = $oDespesa->o56_anousu+1;  
  for ($i = $iAnoInicialPlano; $i <= $iAnofinal; $i++) {
    
    /**
     * Atualizamos os dados da conplano
     */
    
    $sStrUpdate  = "update orcelemento ";
    $sStrUpdate .= "   set o56_elemento  = '{$oDespesa->o56_elemento}',";
    $sStrUpdate .= "       o56_descr     = '{$oDespesa->o56_descr}',";
    $sStrUpdate .= "       o56_finali    = '{$oDespesa->o56_finali}'";
    $sStrUpdate .= " where o56_anousu    = {$i} ";
    $sStrUpdate .= "   and o56_codele    = {$oDespesa->o56_codele} ";
    $rsUpdate    = db_query($sStrUpdate);
    if (!$rsUpdate) {

      echo "Erro ao Atualizar Despesa:{$oDespesa->o56_codele}.\n".pg_last_error()."\n";
      pg_query("rollback");
      exit;
      
    }
    echo "Atualizando despesa {$oDespesa->o56_codele} ano {$i}\r";
  }
}
echo "\n Termino da atualizacao.\n";
echo $str_hora = date( "h:m:s" );
db_query("commit");
?>