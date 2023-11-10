<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
include_once("libs/db_sessoes.php");
include_once("libs/db_usuariosonline.php");
include_once("dbforms/db_funcoes.php");

$sArquivo = "legacy_config/sicom/sicomoidentificadorunidade.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oUnidades = $oDOMDocument->getElementsByTagName('unidade');

/**
 * caso tenha passado um dos dois codigos para ser pesquisado
 */
if($_POST['codigoSeq'] || $_POST['codigoTri']){

	/**
	 * percorrer dados do xml para passar para o objeto para ser adicionado ao array
	 */
  foreach ($oUnidades as $oUni) {

  	/**
     * selecionando linha conforme o codigo passado
     */
  	if($oUni->getAttribute("codigo") == $_POST['codigoSeq'] || $oUni->getAttribute("codTribunal") == $_POST['codigoTri']) {

  		$oValores = new stdClass();
		  $oValores->codigo      = $oUni->getAttribute("codigo");
			$oValores->dscTipoUnidade = $oUni->getAttribute("dscTipoUnidade");
			$oValores->codTribunal = $oUni->getAttribute("codTribunal");
			$aValores[] = $oValores;

  	}

  }

}else{

	/**
	 * percorrer os dados do xml para passar para o objeto e ser adicionado ao array
	 */
  foreach ($oUnidades as $oUni) {

  	$oValores = new stdClass();
		$oValores->codigo      = $oUni->getAttribute("codigo");
		$oValores->dscTipoUnidade = $oUni->getAttribute("dscTipoUnidade");
		$oValores->codTribunal = $oUni->getAttribute("codTribunal");
		$aValores[] = $oValores;

  }

}
echo json_encode($aValores);
