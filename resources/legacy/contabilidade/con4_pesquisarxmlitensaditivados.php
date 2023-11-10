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

$sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomitensaditivados.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oDados = $oDOMDocument->getElementsByTagName('itensaditivado');

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
  	if (($oRow->getAttribute("codAditivo") == $_POST['codadi'] && $oRow->getAttribute("nroContrato") == $_POST['codcontrato']) &&
  	($oRow->getAttribute("codigo") == $_POST['codigo1'] || $oRow->getAttribute("codAditivo") == $_POST['codigo2'])) {

  	  $oValores = new stdClass();
		  $oValores->codigo   		     = $oRow->getAttribute("codigo");
		  $oValores->codAditivo     	 = $oRow->getAttribute("codAditivo");
		  $oValores->nroContrato  	   = $oRow->getAttribute("nroContrato");
		  $oValores->AnoContrato  	   = $oRow->getAttribute("AnoContrato");
		  $oValores->descricaoItem     = $oRow->getAttribute("descricaoItem");
		  $oValores->quantidadeItem    = $oRow->getAttribute("quantidadeItem");
		  $oValores->unidade     			 = $oRow->getAttribute("unidade");
		  $oValores->valorUnitarioItem = $oRow->getAttribute("valorUnitarioItem");

	    $aValores[] = $oValores;

  	}

  }

} else {

  /**
   * percorrer os dados do xml para passar para o objeto e ser adicionado ao array
   */
  foreach ($oDados as $oRow) {

  	if ($oRow->getAttribute("codAditivo") == $_POST['codadi'] && $oRow->getAttribute("nroContrato") == $_POST['codcontrato']) {

  		$oValores = new stdClass();
		  $oValores->codigo         	 = $oRow->getAttribute("codigo");
		  $oValores->codAditivo  	     = $oRow->getAttribute("codAditivo");
		  $oValores->nroContrato  	   = $oRow->getAttribute("nroContrato");
		  $oValores->AnoContrato  	   = $oRow->getAttribute("AnoContrato");
		  $oValores->descricaoItem     = $oRow->getAttribute("descricaoItem");
		  $oValores->quantidadeItem    = $oRow->getAttribute("quantidadeItem");
		  $oValores->unidade     			 = $oRow->getAttribute("unidade");
		  $oValores->valorUnitarioItem = $oRow->getAttribute("valorUnitarioItem");
		  $aValores[] = $oValores;

  	}

  }

}
echo json_encode($aValores);
