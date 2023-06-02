<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include_once("libs/db_sessoes.php");
include_once("libs/db_usuariosonline.php");
include_once("dbforms/db_funcoes.php");

/**
 * caso tenha passado os dois codigos para serem pesquisados
 */
if ($_POST['codigo2']) {
  
	$sSql  = "SELECT l21_codigo, pc01_descrmater from liclicitem ";
  $sSql .= "join pcprocitem on l21_codpcprocitem = pc81_codprocitem ";
  $sSql .= "join solicitem on pc81_solicitem = pc11_codigo ";
  $sSql .= "join solicitempcmater on pc16_solicitem = pc11_codigo ";
  $sSql .= "join pcmater on pc16_codmater = pc01_codmater ";
  $sSql .= "where l21_codigo = {$_POST['codigo2']} and l21_codliclicita = {$_POST['codigo1']}";
    	
  $rsItem = db_query($sSql);
  $oItem  = db_utils::fieldsMemory($rsItem, 0);
	

  $oValores = new stdClass();
	$oValores->nroItem = $oItem->l21_codigo;
	$oValores->dscItem = utf8_encode($oItem->pc01_descrmater);
	$aValores[] = $oValores;

} else {		
  
	$sSql  = "SELECT l21_codigo, pc01_descrmater from liclicitem ";
  $sSql .= "join pcprocitem on l21_codpcprocitem = pc81_codprocitem ";
  $sSql .= "join solicitem on pc81_solicitem = pc11_codigo ";
  $sSql .= "join solicitempcmater on pc16_solicitem = pc11_codigo ";
  $sSql .= "join pcmater on pc16_codmater = pc01_codmater ";
  $sSql .= "where l21_codliclicita = {$_POST['codigo1']}";
    	
  $rsItem = db_query($sSql);
	
	/**
	 * percorrer os dados retornados do sql acima
	 */
  for ($iCont = 0; $iCont < pg_num_rows($rsItem); $iCont++) {
  	
  	$oItem  = db_utils::fieldsMemory($rsItem, $iCont);
  	
    $oValores = new stdClass();
	  $oValores->nroItem = $oItem->l21_codigo;
	  $oValores->dscItem = utf8_encode($oItem->pc01_descrmater);
	  $aValores[] = $oValores;
		
  }
  
}
echo json_encode($aValores);
