<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include_once("libs/db_sessoes.php");
include_once("libs/db_usuariosonline.php");
include_once("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);

/**
 * dados paginacao
 */
$iQuantLinhas = 15;
if (isset($inicio)) {
	$iInicio      = $inicio*15;
} else {
  $iInicio      = 0*15;
}


/**
 * caso tenha passado um dos dois codigos para ser pesquisado
 */
if ($codigo1 || $codigo2 ) {
  	
	if ($codigo1 != '' && $codigo2 != '') {
	  $where = "k00_codigo = {$codigo1} AND k00_ctpagadora =  {$codigo2}";
	} else {
		
    if ($codigo2 != '') {
	    $where = "k00_ctpagadora =  {$codigo2}";
	  } else {
		
	    if ($codigo1 != '') {
	      $where = "k00_codigo = {$codigo1}";
	    }
	  
	  }
	}
	$rsResult = db_query("SELECT * FROM ordembancaria WHERE {$where}");
	/**
	 * percorrer os dados para passar para o objeto e ser adicionado ao array
	 */
  for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {
		  
  	$oDados = db_utils::fieldsMemory($rsResult, $iCont);
  	$aValores[] = $oDados;
			
  }
  
} else {		
  
	/**
	 * percorrer os dados para passar para o objeto e ser adicionado ao array
	 */
	$rsResult = db_query("SELECT * FROM ordembancaria ORDER BY k00_codigo LIMIT 15 OFFSET {$iInicio}");
  for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {
  	
  	$oDados = db_utils::fieldsMemory($rsResult, $iCont);
  	
  	$aValores[] = $oDados;
		
  }
  
}
echo json_encode($aValores);
