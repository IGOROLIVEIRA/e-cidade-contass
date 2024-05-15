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

$sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomprecomedio.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oDados = $oDOMDocument->getElementsByTagName('precomedio');

$sLicitacao = 0;

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
  	if ($oRow->getAttribute("codigo") == $_POST['codigo1'] || $oRow->getAttribute("nroProcessoLicitatorio") == $_POST['codigo2']) {

  		if ($oRow->getAttribute("nroProcessoLicitatorio") != $sLicitacao) {

  		  $oValores = new stdClass();
		    $oValores->codigo                 = $oRow->getAttribute("codigo");
			  $oValores->nroProcessoLicitatorio = $oRow->getAttribute("nroProcessoLicitatorio");
			  $oValores->dtCotacao = $oRow->getAttribute("dtCotacao");
			  $aValores[] = $oValores;
			  $sLicitacao = $oRow->getAttribute("nroProcessoLicitatorio");

  		}

  	}

  }

} else {

	/**
	 * percorrer os dados do xml para passar para o objeto e ser adicionado ao array
	 */
  foreach ($oDados as $oRow) {

  	if ($oRow->getAttribute("nroProcessoLicitatorio") != $sLicitacao) {

  		$oValores = new stdClass();
			$oValores->codigo                 = $oRow->getAttribute("codigo");
			$oValores->nroProcessoLicitatorio = $oRow->getAttribute("nroProcessoLicitatorio");
			$oValores->dtCotacao = $oRow->getAttribute("dtCotacao");
			$aValores[] = $oValores;
			$sLicitacao = $oRow->getAttribute("nroProcessoLicitatorio");

  	}

  }

}
echo json_encode($aValores);
