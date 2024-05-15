<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include_once("libs/db_sessoes.php");
include_once("libs/db_usuariosonline.php");
include_once("dbforms/db_funcoes.php");

$sSql  = "SELECT * FROM db_config ";
$sSql .= "	WHERE prefeitura = 't'";

$rsInst = db_query($sSql);
$sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;

$sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomdotacao.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oDados = $oDOMDocument->getElementsByTagName('dotacao');

/**
 * caso tenha passado um dos dois codigos para ser pesquisado
 */
if ($_POST['codigo2'] || $_POST['codigo3']) {

	/**
	 * percorrer dados do xml para passar para o objeto para ser adicionado ao array
	 */
  foreach ($oDados as $oRow) {

  	/**
     * selecionando linha conforme o codigo passado
     */
  	if ($oRow->getAttribute("codContrato") == $_POST['codigo1']
  	    && ($oRow->getAttribute("codEmpenho") == $_POST['codigo2']
  	    || $oRow->getAttribute("anoEmpenho")  == $_POST['codigo3'])) {

  		$oValores = new stdClass();
		  $oValores->codigo                   = $oRow->getAttribute("codigo");
		  $oValores->codContrato              = $oRow->getAttribute("codContrato");
	    $oValores->codEmpenho               = $oRow->getAttribute("codEmpenho");
		  $oValores->anoEmpenho               = $oRow->getAttribute("anoEmpenho");
			$aValores[] = $oValores;

  	}

  }

} else {

	/**
	 * percorrer os dados do xml para passar para o objeto e ser adicionado ao array
	 */
  foreach ($oDados as $oRow) {

  	if ($oRow->getAttribute("codContrato") == $_POST['codigo1']) {

  		$oValores = new stdClass();
		  $oValores->codigo                   = $oRow->getAttribute("codigo");
		  $oValores->codContrato              = $oRow->getAttribute("codContrato");
	    $oValores->codEmpenho               = $oRow->getAttribute("codEmpenho");
		  $oValores->anoEmpenho               = $oRow->getAttribute("anoEmpenho");

		  $aValores[] = $oValores;

  	}

  }

}
echo json_encode($aValores);
