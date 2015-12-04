<?php

/**
 * Função para retornar os valores defaults de um campo
 * @param string $sNomeCam nome do campo
 * @return array
 */

function getValoresPadroesCampo($sNomeCam) {

  $aRetorno     = array();
  $sSqlDefault  = "select defcampo, ";
  $sSqlDefault .= "       defdescr  ";
  $sSqlDefault .= "  from db_syscampodef ";
  $sSqlDefault .= "       inner join db_syscampo on db_syscampo.codcam = db_syscampodef.codcam ";
  $sSqlDefault .= " where nomecam = '{$sNomeCam}'";
  $sSqlDefault .= " order by defcampo";
  $rsCampos     = pg_query($sSqlDefault);
  if (pg_num_rows($rsCampos) > 0) {
    
    $iTotRows = pg_num_rows($rsCampos);
    for ($i = 0; $i < $iTotRows; $i++) {

       $aRetorno[pg_result($rsCampos,$i,0)] = pg_result($rsCampos,$i,1); 
    }
  }
  return $aRetorno;
}
