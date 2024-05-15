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

$sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomlicitacao.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oDados = $oDOMDocument->getElementsByTagName('licitacao');

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
  	if ($oRow->getAttribute("codigo") == $_POST['codigo1'] ) {

  	  $oValores = new stdClass();
	    $oValores->codigo                          = $oRow->getAttribute("codigo");
	    $oValores->codTipoComissao                 = $oRow->getAttribute("codTipoComissao");
	    $oValores->descricaoAtoNomeacao            = $oRow->getAttribute("descricaoAtoNomeacao");
	    $oValores->nroAtoNomeacao                  = $oRow->getAttribute("nroAtoNomeacao");
	    $oValores->dataAtoNomeacao                 = $oRow->getAttribute("dataAtoNomeacao");
	    $oValores->inicioVigencia                  = $oRow->getAttribute("inicioVigencia");
	    $oValores->finalVigencia                   = $oRow->getAttribute("finalVigencia");
	    $aValores[] = $oValores;

  	}

  }

} else {

  /**
   * percorrer os dados do xml para passar para o objeto e ser adicionado ao array
   */
  foreach ($oDados as $oRow) {

    $oValores = new stdClass();
	  $oValores->codigo                          = $oRow->getAttribute("codigo");
	  $oValores->codTipoComissao                 = $oRow->getAttribute("codTipoComissao");
	  $oValores->descricaoAtoNomeacao            = $oRow->getAttribute("descricaoAtoNomeacao");
	  $oValores->nroAtoNomeacao                  = $oRow->getAttribute("nroAtoNomeacao");
	  $oValores->dataAtoNomeacao                 = $oRow->getAttribute("dataAtoNomeacao");
	  $oValores->inicioVigencia                  = $oRow->getAttribute("inicioVigencia");
	  $oValores->finalVigencia                   = $oRow->getAttribute("finalVigencia");
	  $aValores[] = $oValores;

  }

}
echo json_encode($aValores);
