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

$sArquivo = "legacy_config/sicom/{$sCnpj}_sicomriscos.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oRiscos      = $oDOMDocument->getElementsByTagName('risco');

/**
 * caso tenha passado um dos dois codigos para ser pesquisado
 */
if($_POST['codigoRisco'] || $_POST['codigoPerspectiva']){

	/**
	 * percorrer dados do xml para passar para o objeto para ser adicionado ao array
	 */
  foreach ($oRiscos as $oRisc) {

  	 /**
      * selecionando linha conforme o codigo passado
      */
  		if($oRisc->getAttribute("codRisco") == $_POST['codigoRisco'] || $oRisc->getAttribute("codPerspectiva") == $_POST['codigoPerspectiva']) {

  			$oValores = new stdClass();
				$oValores->codRisco      = $oRisc->getAttribute("codRisco");
				$oValores->codPerspectiva = $oRisc->getAttribute("codPerspectiva");
				$oValores->exercicio = $oRisc->getAttribute("exercicio");
				$oValores->dscRiscoFiscal = $oRisc->getAttribute("dscRiscoFiscal");
				$oValores->vlRiscoFiscal = $oRisc->getAttribute("vlRiscoFiscal");
				$oValores->codRiscoFiscal = $oRisc->getAttribute("codRiscoFiscal");
				$aValores[] = $oValores;

  		}

  }

}else{

 /**
	* percorrer os dados do xml para passar para o objeto e ser adicionado ao array
	*/
  foreach ($oRiscos as $oRisc) {

  		$oValores = new stdClass();
			$oValores->codRisco      = $oRisc->getAttribute("codRisco");
			$oValores->codPerspectiva = $oRisc->getAttribute("codPerspectiva");
			$oValores->exercicio = $oRisc->getAttribute("exercicio");
			$oValores->dscRiscoFiscal = $oRisc->getAttribute("dscRiscoFiscal");
			$oValores->vlRiscoFiscal = $oRisc->getAttribute("vlRiscoFiscal");
			$oValores->codRiscoFiscal = $oRisc->getAttribute("codRiscoFiscal");
			$aValores[] = $oValores;

  }

}
echo json_encode($aValores);
