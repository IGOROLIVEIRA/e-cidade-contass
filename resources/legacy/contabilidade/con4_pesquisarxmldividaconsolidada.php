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

$sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomdividaconsolidada.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oDados = $oDOMDocument->getElementsByTagName('dividaconsolidada');

/**
 * caso tenha passado um dos dois codigos para ser pesquisado
 */
if ($_POST['codigo1']) {

	/**
	 * percorrer dados do xml para passar para o objeto para ser adicionado ao array
	 */
  foreach ($oDados as $oRow) {

  	/**
     * selecionando linha conforme o codigo passado
     */
  	if ($oRow->getAttribute("codigo") == $_POST['codigo1']) {

	  $oValores = new stdClass();
	  $oValores->codigo                 = $oRow->getAttribute("codigo");
	  $oValores->tipoLancamento         = $oRow->getAttribute("tipoLancamento");
	  $oValores->nroLeiAutorizacao      = $oRow->getAttribute("nroLeiAutorizacao");
	  $oValores->dtLeiAutorizacao       = $oRow->getAttribute("dtLeiAutorizacao");
	  $oValores->especificacao          = $oRow->getAttribute("especificacao");
	  $oValores->vlSaldoAnterior        = $oRow->getAttribute("vlSaldoAnterior");
	  $oValores->vlContratacao          = $oRow->getAttribute("vlContratacao");
	  $oValores->vlAmortizacao          = $oRow->getAttribute("vlAmortizacao");
	  $oValores->vlCancelamento         = $oRow->getAttribute("vlCancelamento");
	  $oValores->vlEncampacao           = $oRow->getAttribute("vlEncampacao");
	  $oValores->vlAtualizacao          = $oRow->getAttribute("vlAtualizacao");
	  $oValores->vlSaldoAtual           = $oRow->getAttribute("vlSaldoAtual");
	  $oValores->nroContrato            = $oRow->getAttribute("nroContrato");
	  $oValores->dataAssinatura         = $oRow->getAttribute("dataAssinatura");
	  $oValores->tipoDocumento          = $oRow->getAttribute("tipoDocumento");
	  $oValores->nroDocumento           = $oRow->getAttribute("nroDocumento");
	  $oValores->nomeCredor             = $oRow->getAttribute("nomeCredor");
	  $oValores->justificativa          = $oRow->getAttribute("justificativa");
	  $aValores[] = $oValores;

  	}

  }

} else {

  /**
   * percorrer os dados do xml para passar para o objeto e ser adicionado ao array
   */
  foreach ($oDados as $oRow) {

  	$oValores = new stdClass();
	  $oValores->codigo                 = $oRow->getAttribute("codigo");
	  $oValores->tipoLancamento         = $oRow->getAttribute("tipoLancamento");
	  $oValores->nroLeiAutorizacao      = $oRow->getAttribute("nroLeiAutorizacao");
	  $oValores->dtLeiAutorizacao       = $oRow->getAttribute("dtLeiAutorizacao");
	  $oValores->especificacao          = $oRow->getAttribute("especificacao");
	  $oValores->vlSaldoAnterior        = $oRow->getAttribute("vlSaldoAnterior");
	  $oValores->vlContratacao          = $oRow->getAttribute("vlContratacao");
	  $oValores->vlAmortizacao          = $oRow->getAttribute("vlAmortizacao");
	  $oValores->vlCancelamento         = $oRow->getAttribute("vlCancelamento");
	  $oValores->vlEncampacao           = $oRow->getAttribute("vlEncampacao");
	  $oValores->vlAtualizacao          = $oRow->getAttribute("vlAtualizacao");
	  $oValores->vlSaldoAtual           = $oRow->getAttribute("vlSaldoAtual");
	  $oValores->nroContrato            = $oRow->getAttribute("nroContrato");
	  $oValores->dataAssinatura         = $oRow->getAttribute("dataAssinatura");
	  $oValores->tipoDocumento          = $oRow->getAttribute("tipoDocumento");
	  $oValores->nroDocumento           = $oRow->getAttribute("nroDocumento");
	  $oValores->nomeCredor             = $oRow->getAttribute("nomeCredor");
	  $oValores->justificativa          = $oRow->getAttribute("justificativa");
	  $aValores[] = $oValores;

  }

}
echo json_encode($aValores);
