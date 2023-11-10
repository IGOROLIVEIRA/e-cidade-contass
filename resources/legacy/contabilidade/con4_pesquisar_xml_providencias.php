<?php
$sArquivo = "legacy_config/sicom/sicomprovidenciasriscos.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oProvidencias = $oDOMDocument->getElementsByTagName('providencia');

if($_POST['codigoProvidencia'] || $_POST['codigoRisco']){

  foreach ($oProvidencias as $oProv) {

  		$oValores = new stdClass();
  		if($oProv->getAttribute("codProvidencia") == $_POST['codigoProvidencia'] || $oProv->getAttribute("codRisco") == $_POST['codigoRisco']) {

				$oValores->codRisco               = $oProv->getAttribute("codRisco");
				$oValores->codProvidencia         = $oProv->getAttribute("codProvidencia");
				$oValores->dscProvidencia         = $oProv->getAttribute("dscProvidencia");
				$oValores->vlAssociadoProvidencia = $oProv->getAttribute("vlAssociadoProvidencia");
				$aValores[] = $oValores;
  		}
  }
}else{

  foreach ($oProvidencias as $oProv) {

  		$oValores = new stdClass();
				$oValores->codRisco               = $oProv->getAttribute("codRisco");
				$oValores->codProvidencia         = $oProv->getAttribute("codProvidencia");
				$oValores->dscProvidencia         = $oProv->getAttribute("dscProvidencia");
				$oValores->vlAssociadoProvidencia = $oProv->getAttribute("vlAssociadoProvidencia");
				$aValores[] = $oValores;
  }
}
echo json_encode($aValores);
