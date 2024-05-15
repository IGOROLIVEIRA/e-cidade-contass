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

$sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomhabilitacaosocios.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oDados = $oDOMDocument->getElementsByTagName('habilitacaosocio');

/**
 * caso tenha passado um dos dois codigos para ser pesquisado
 */
if ($_POST['codigo']) {

	/**
	 * percorrer dados do xml para passar para o objeto para ser adicionado ao array
	 */
  foreach ($oDados as $oRow) {

  	/**
     * selecionando linha conforme o codigo passado
     */
  	if ($oRow->getAttribute("codHabilitacao") == $_POST['codigo'] && $oRow->getAttribute("instituicao") == db_getsession("DB_instit")) {

  	  $oValores = new stdClass();
		  $oValores->nroDocumentoSocio = $oRow->getAttribute("nroDocumentoSocio");
		  $oValores->nomeSocio         = $oRow->getAttribute("nomeSocio");
		  $oValores->tipoParticipacao  = $oRow->getAttribute("tipoParticipacao");

		  $aValores[] = $oValores;

  	}

  }

}
echo json_encode($aValores);
