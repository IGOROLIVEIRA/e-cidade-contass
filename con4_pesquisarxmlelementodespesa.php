<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

$sSql  = "SELECT * FROM db_config ";
$sSql .= "	WHERE prefeitura = 't'";
    	
$rsInst = db_query($sSql);
$sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;

$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomelementodespesa.xml";

$oDOMDocument = new DOMDocument();		
    
$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;
  
$oDados = $oDOMDocument->getElementsByTagName('elemento');

/**
 * dados paginacao
 */
$iQuantLinhas = 15;
if (isset($_POST['inicio'])) {
	$iInicio      = $_POST['inicio']*15;
} else {
  $iInicio      = 0*15;
}

/**
 * caso tenha passado um dos dois codigos para ser pesquisado
 */
if ($_POST['codigo1'] || $_POST['codigo2']) {
  
	/**
	 * percorrer dados do xml para passar para o objeto para ser adicionado ao array
	 */
  foreach ($oDados as $oRow) {
  	
  	/**
     * selecionando linha conforme o codigo passado
     */
  	if ($oRow->getAttribute("codigo") == $_POST['codigo1'] || $oRow->getAttribute("elementoEcidade") == $_POST['codigo2']) {

  	  $oValores = new stdClass();
	    $oValores->codigo          = $oRow->getAttribute("codigo");
		  $oValores->elementoEcidade = $oRow->getAttribute("elementoEcidade");
		  $oValores->elementoSicom   = $oRow->getAttribute("elementoSicom");
		  $oValores->instituicao   = $oRow->getAttribute("instituicao");
		  $aValores[] = $oValores;
			
  	}
  	
  }
  
} else {		
  
  /**
   * percorrer os dados do xml para passar para o objeto e ser adicionado ao array
   */
	for ($iCont = $iInicio; $iCont < ($iInicio+$iQuantLinhas); $iCont++) {
  	
		$oRow = $oDados->item($iCont);
  	$oValores = new stdClass();
	  $oValores->codigo          = $oRow->getAttribute("codigo");
		$oValores->elementoEcidade = $oRow->getAttribute("elementoEcidade");
		$oValores->elementoSicom   = $oRow->getAttribute("elementoSicom");
		$oValores->instituicao   = $oRow->getAttribute("instituicao");
		$oValores->deParaDesdobramento   = $oRow->getAttribute("deParaDesdobramento") == '' ? '' : ($oRow->getAttribute("deParaDesdobramento") == 1 ? 'Sim' : 'Nao');
		$aValores[] = $oValores;
	  if ($iCont == $oDados->length-1) {
			break;
		}
		
  }
  
}
echo json_encode($aValores);
