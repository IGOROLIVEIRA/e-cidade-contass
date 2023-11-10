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

$sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomaditivoscontratos.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oDados = $oDOMDocument->getElementsByTagName('aditivoscontrato');

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
  	if ($oRow->getAttribute("codigo") == $_POST['codigo1'] || $oRow->getAttribute("codAditivo") == $_POST['codigo2'] ) {

  	  $oValores = new stdClass();
		  $oValores->codigo                     = $oRow->getAttribute("codigo");
		  $oValores->codAditivo                 = $oRow->getAttribute("codAditivo");
		  $oValores->nroContrato      				  = $oRow->getAttribute("nroContrato");
		  $oValores->AnoContrato               	= $oRow->getAttribute("AnoContrato");
		  $oValores->dataAssinaturaContOriginal = $oRow->getAttribute("dataAssinaturaContOriginal");
		  $oValores->tipoTermoAditivo         	= $oRow->getAttribute("tipoTermoAditivo");
		  $oValores->dscAlteracao          			= $oRow->getAttribute("dscAlteracao");
		  $oValores->nroSeqTermoAditivo		      = $oRow->getAttribute("nroSeqTermoAditivo");
		  $oValores->dataAssinaturaTermoAditivo	= $oRow->getAttribute("dataAssinaturaTermoAditivo");
		  $oValores->novaDataTermino				    = $oRow->getAttribute("novaDataTermino");
		  $oValores->valorAditivo					      = $oRow->getAttribute("valorAditivo");
		  $oValores->valorAtualizadoContrato		= $oRow->getAttribute("valorAtualizadoContrato");
		  $oValores->dataPublicacao					    = $oRow->getAttribute("dataPublicacao");
		  $oValores->veiculoDivulgacao				  = $oRow->getAttribute("veiculoDivulgacao");

		  $aValores[] = $oValores;

  	}

  }

} else {

  /**
   * percorrer os dados do xml para passar para o objeto e ser adicionado ao array
   */
  foreach ($oDados as $oRow) {

    $oValores = new stdClass();
	  $oValores->codigo                     = $oRow->getAttribute("codigo");
		$oValores->codAditivo                 = $oRow->getAttribute("codAditivo");
		$oValores->nroContrato      				  = $oRow->getAttribute("nroContrato");
		$oValores->AnoContrato               	= $oRow->getAttribute("AnoContrato");
		$oValores->dataAssinaturaContOriginal = $oRow->getAttribute("dataAssinaturaContOriginal");
		$oValores->tipoTermoAditivo         	= $oRow->getAttribute("tipoTermoAditivo");
		$oValores->dscAlteracao          			= $oRow->getAttribute("dscAlteracao");
		$oValores->nroSeqTermoAditivo		      = $oRow->getAttribute("nroSeqTermoAditivo");
		$oValores->dataAssinaturaTermoAditivo	= $oRow->getAttribute("dataAssinaturaTermoAditivo");
		$oValores->novaDataTermino					  = $oRow->getAttribute("novaDataTermino");
		$oValores->valorAditivo						    = $oRow->getAttribute("valorAditivo");
		$oValores->valorAtualizadoContrato		= $oRow->getAttribute("valorAtualizadoContrato");
		$oValores->dataPublicacao					    = $oRow->getAttribute("dataPublicacao");
		$oValores->veiculoDivulgacao				  = $oRow->getAttribute("veiculoDivulgacao");

		$aValores[] = $oValores;

  }

}
echo json_encode($aValores);
