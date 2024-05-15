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

$sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomcontratos.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oDados = $oDOMDocument->getElementsByTagName('contrato');

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
  	if ($oRow->getAttribute("codigo") == $_POST['codigo1'] || $oRow->getAttribute("nroProcessoLicitatorio") == $_POST['codigo2']
  	    && $_POST['codigo1'] != "" && $_POST['codigo2'] != "") {

  		$oValores = new stdClass();
		  $oValores->codigo                       = $oRow->getAttribute("codigo");
			$oValores->nroContrato                  = $oRow->getAttribute("nroContrato");
			$oValores->dataAssinatura               = $oRow->getAttribute("dataAssinatura");
			$oValores->nomContratadoParcPublico     = $oRow->getAttribute("nomContratadoParcPublico");
			$oValores->nroDocumento                 = $oRow->getAttribute("nroDocumento");
			$oValores->representanteLegalContratado = $oRow->getAttribute("representanteLegalContratado");
			$oValores->cpfrepresentanteLegal        = $oRow->getAttribute("cpfrepresentanteLegal");
			$oValores->nroProcessoLicitatorio       = $oRow->getAttribute("nroProcessoLicitatorio");
			$oValores->naturezaObjeto               = $oRow->getAttribute("naturezaObjeto");
			$oValores->objetoContrato               = $oRow->getAttribute("objetoContrato");
			$oValores->tipoInstrumento              = $oRow->getAttribute("tipoInstrumento");
			$oValores->dataInicioVigencia           = $oRow->getAttribute("dataInicioVigencia");
			$oValores->dataFinalVigencia            = $oRow->getAttribute("dataFinalVigencia");
			$oValores->vlContrato                   = $oRow->getAttribute("vlContrato");
			$oValores->formaFornecimento            = $oRow->getAttribute("formaFornecimento");
			$oValores->formaPagamento               = $oRow->getAttribute("formaPagamento");
			$oValores->prazoExecucao                = $oRow->getAttribute("prazoExecucao");
			$oValores->multaRescisoria              = $oRow->getAttribute("multaRescisoria");
			$oValores->multaInadimplemento          = $oRow->getAttribute("multaInadimplemento");
			$oValores->garantia                     = $oRow->getAttribute("garantia");
			$oValores->signatarioContratante        = $oRow->getAttribute("signatarioContratante");
			$oValores->cpfsignatarioContratante     = $oRow->getAttribute("cpfsignatarioContratante");
			$oValores->dataPublicacao               = $oRow->getAttribute("dataPublicacao");
			$oValores->veiculoDivulgacao            = $oRow->getAttribute("veiculoDivulgacao");
			$aValores[] = $oValores;

  	}

  }

} else {

	/**
	 * percorrer os dados do xml para passar para o objeto e ser adicionado ao array
	 */
  foreach ($oDados as $oRow) {

    $oValores = new stdClass();
		$oValores->codigo                       = $oRow->getAttribute("codigo");
	  $oValores->nroContrato                  = $oRow->getAttribute("nroContrato");
		$oValores->dataAssinatura               = $oRow->getAttribute("dataAssinatura");
		$oValores->nomContratadoParcPublico     = $oRow->getAttribute("nomContratadoParcPublico");
		$oValores->nroDocumento                 = $oRow->getAttribute("nroDocumento");
		$oValores->representanteLegalContratado = $oRow->getAttribute("representanteLegalContratado");
		$oValores->cpfrepresentanteLegal        = $oRow->getAttribute("cpfrepresentanteLegal");
		$oValores->nroProcessoLicitatorio       = $oRow->getAttribute("nroProcessoLicitatorio");
		$oValores->naturezaObjeto               = $oRow->getAttribute("naturezaObjeto");
		$oValores->objetoContrato               = $oRow->getAttribute("objetoContrato");
		$oValores->tipoInstrumento              = $oRow->getAttribute("tipoInstrumento");
		$oValores->dataInicioVigencia           = $oRow->getAttribute("dataInicioVigencia");
		$oValores->dataFinalVigencia            = $oRow->getAttribute("dataFinalVigencia");
		$oValores->vlContrato                   = $oRow->getAttribute("vlContrato");
		$oValores->formaFornecimento            = $oRow->getAttribute("formaFornecimento");
		$oValores->formaPagamento               = $oRow->getAttribute("formaPagamento");
		$oValores->prazoExecucao                = $oRow->getAttribute("prazoExecucao");
		$oValores->multaRescisoria              = $oRow->getAttribute("multaRescisoria");
		$oValores->multaInadimplemento          = $oRow->getAttribute("multaInadimplemento");
		$oValores->garantia                     = $oRow->getAttribute("garantia");
		$oValores->signatarioContratante        = $oRow->getAttribute("signatarioContratante");
		$oValores->cpfsignatarioContratante     = $oRow->getAttribute("cpfsignatarioContratante");
		$oValores->dataPublicacao               = $oRow->getAttribute("dataPublicacao");
		$oValores->veiculoDivulgacao            = $oRow->getAttribute("veiculoDivulgacao");
		$aValores[] = $oValores;

  }

}
echo json_encode($aValores);
