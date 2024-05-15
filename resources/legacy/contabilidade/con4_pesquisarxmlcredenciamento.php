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

$sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomcredenciamento.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oDados = $oDOMDocument->getElementsByTagName('credenciamento');

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
  	if ($oRow->getAttribute("codigo") == $_POST['codigo1']||$oRow->getAttribute("nroDocumento") == $_POST['codigo2'] ) {

  	  $oValores = new stdClass();
		  $oValores->codigo                     			  = $oRow->getAttribute("codigo");
		  $oValores->nroProcessoLicitatorio             = $oRow->getAttribute("nroProcessoLicitatorio");
		  $oValores->nroDocumento      						      = $oRow->getAttribute("nroDocumento");
		  $oValores->dataCredenciamento      				    = $oRow->getAttribute("dataCredenciamento");
		  $oValores->nroItem      							        = $oRow->getAttribute("nroItem");
		  $oValores->nomRazaoSocial               			= $oRow->getAttribute("nomRazaoSocial");
		  $oValores->nroInscricaoEstadual     				  = $oRow->getAttribute("nroInscricaoEstadual");
		  $oValores->ufInscricaoEstadual         	 		  = $oRow->getAttribute("ufInscricaoEstadual");
		  $oValores->nroCertidaoRegularidadeINSS        = $oRow->getAttribute("nroCertidaoRegularidadeINSS");
		  $oValores->dtEmissaoCertidaoRegularidadeINSS	= $oRow->getAttribute("dtEmissaoCertidaoRegularidadeINSS");
		  $oValores->dtValidadeCertidaoRegularidadeINSS	= $oRow->getAttribute("dtValidadeCertidaoRegularidadeINSS");
		  $oValores->nroCertidaoRegularidadeFGTS			  = $oRow->getAttribute("nroCertidaoRegularidadeFGTS");
		  $oValores->dtEmissaoCertidaoRegularidadeFGTS	= $oRow->getAttribute("dtEmissaoCertidaoRegularidadeFGTS");
		  $oValores->dtValidadeCertidaoRegularidadeFGTS	= $oRow->getAttribute("dtValidadeCertidaoRegularidadeFGTS");
		  $oValores->nroCNDT                            = $oRow->getAttribute("nroCNDT");
	    $oValores->dtEmissaoCNDT                      = $oRow->getAttribute("dtEmissaoCNDT");
	    $oValores->dtValidadeCNDT                     = $oRow->getAttribute("dtValidadeCNDT");

		  $aValores[] = $oValores;

  	}

  }

} else {

  /**
   * percorrer os dados do xml para passar para o objeto e ser adicionado ao array
   */
  foreach ($oDados as $oRow) {

    $oValores = new stdClass();
		$oValores->codigo                     				= $oRow->getAttribute("codigo");
		$oValores->nroProcessoLicitatorio             = $oRow->getAttribute("nroProcessoLicitatorio");
		$oValores->nroDocumento      						      = $oRow->getAttribute("nroDocumento");
		$oValores->dataCredenciamento      					  = $oRow->getAttribute("dataCredenciamento");
		$oValores->nroItem      							        = $oRow->getAttribute("nroItem");
		$oValores->nomRazaoSocial               			= $oRow->getAttribute("nomRazaoSocial");
		$oValores->nroInscricaoEstadual     				  = $oRow->getAttribute("nroInscricaoEstadual");
		$oValores->ufInscricaoEstadual         	 			= $oRow->getAttribute("ufInscricaoEstadual");
		$oValores->nroCertidaoRegularidadeINSS        = $oRow->getAttribute("nroCertidaoRegularidadeINSS");
		$oValores->dtEmissaoCertidaoRegularidadeINSS	= $oRow->getAttribute("dtEmissaoCertidaoRegularidadeINSS");
		$oValores->dtValidadeCertidaoRegularidadeINSS	= $oRow->getAttribute("dtValidadeCertidaoRegularidadeINSS");
		$oValores->nroCertidaoRegularidadeFGTS				= $oRow->getAttribute("nroCertidaoRegularidadeFGTS");
		$oValores->dtEmissaoCertidaoRegularidadeFGTS	= $oRow->getAttribute("dtEmissaoCertidaoRegularidadeFGTS");
		$oValores->dtValidadeCertidaoRegularidadeFGTS	= $oRow->getAttribute("dtValidadeCertidaoRegularidadeFGTS");
		$oValores->nroCNDT                            = $oRow->getAttribute("nroCNDT");
	  $oValores->dtEmissaoCNDT                      = $oRow->getAttribute("dtEmissaoCNDT");
	  $oValores->dtValidadeCNDT                     = $oRow->getAttribute("dtValidadeCNDT");

		$aValores[] = $oValores;

  }

}
echo json_encode($aValores);
