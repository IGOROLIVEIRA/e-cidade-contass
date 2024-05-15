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

$sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomresponsavel.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oDados = $oDOMDocument->getElementsByTagName('resp');

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

  		$sSql  =  "SELECT z01_nome from cgm where z01_numcgm = ".$oRow->getAttribute("numCgm");
			$rsCgm = db_query($sSql);
			$sNome  = db_utils::fieldsMemory($rsCgm, 0)->z01_nome;

  	  $oValores = new stdClass();
  	  $oValores->codigoLic                       = $oRow->getAttribute("codigoLic");
	    $oValores->codigo                          = $oRow->getAttribute("codigo");
	    $oValores->numCgm                          = $oRow->getAttribute("numCgm");
	    $oValores->nomeResponsavel                 = $sNome;
	    $oValores->codAtribuicao                   = $oRow->getAttribute("codAtribuicao");
	    $oValores->cargo                           = $oRow->getAttribute("cargo");
	    $oValores->naturezaCargo                   = $oRow->getAttribute("naturezaCargo");
	    $aValores[] = $oValores;
			break;

  	}

  }

} else {

  /**
   * percorrer os dados do xml para passar para o objeto e ser adicionado ao array
   */
  foreach ($oDados as $oRow) {

  	if ($oRow->getAttribute("codigoLic") == $_POST['codigo_licitacao']) {

	  	$sSql  =  "SELECT z01_nome from cgm where z01_numcgm = ".$oRow->getAttribute("numCgm");
			$rsCgm = db_query($sSql);
			$sNome  = db_utils::fieldsMemory($rsCgm, 0)->z01_nome;

	    $oValores = new stdClass();
	    $oValores->codigoLic                       = $oRow->getAttribute("codigoLic");
		  $oValores->codigo                          = $oRow->getAttribute("codigo");
		  $oValores->numCgm                          = $oRow->getAttribute("numCgm");
		  $oValores->nomeResponsavel                 = $sNome;
		  $oValores->codAtribuicao                   = $oRow->getAttribute("codAtribuicao");
		  $oValores->cargo                           = $oRow->getAttribute("cargo");
		  $oValores->naturezaCargo                   = $oRow->getAttribute("naturezaCargo");
		  $aValores[] = $oValores;

  	}

  }

}
echo json_encode($aValores);
