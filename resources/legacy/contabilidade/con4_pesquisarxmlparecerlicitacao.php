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

$sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomparecerlicitacao.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oDados = $oDOMDocument->getElementsByTagName('parecerlicitacao');

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
  	if ($oRow->getAttribute("codigo") == $_POST['codigo1'] || $oRow->getAttribute("nroProcessoLicitatorio") == $_POST['codigo2']) {

  	  $oValores = new stdClass();
	    $oValores->codigo                          = $oRow->getAttribute("codigo");
		  $oValores->exercicioLicitacao              = $oRow->getAttribute("exercicioLicitacao");
		  $oValores->nroProcessoLicitatorio          = $oRow->getAttribute("nroProcessoLicitatorio");
		  $oValores->dataParecer                     = $oRow->getAttribute("dataParecer");
		  $oValores->tipoParecer                     = $oRow->getAttribute("tipoParecer");
		  $oValores->dataParecer                     = $oRow->getAttribute("dataParecer");
		  $oValores->nroCpf                          = $oRow->getAttribute("nroCpf");
		  $oValores->nomRespParecer                  = $oRow->getAttribute("nomRespParecer");
		  $oValores->logradouro                      = $oRow->getAttribute("logradouro");
		  $oValores->bairroLogra                     = $oRow->getAttribute("bairroLogra");
		  $oValores->codCidadeLogra                  = $oRow->getAttribute("codCidadeLogra");
		  $oValores->ufCidadeLogra                   = $oRow->getAttribute("ufCidadeLogra");
		  $oValores->cepLogra                   	   = $oRow->getAttribute("cepLogra");
		  $oValores->telefone                        = $oRow->getAttribute("telefone");
		  $oValores->email                           = $oRow->getAttribute("email");
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
		$oValores->exercicioLicitacao              = $oRow->getAttribute("exercicioLicitacao");
		$oValores->nroProcessoLicitatorio          = $oRow->getAttribute("nroProcessoLicitatorio");
		$oValores->dataParecer                     = $oRow->getAttribute("dataParecer");
		$oValores->tipoParecer                     = $oRow->getAttribute("tipoParecer");
		$oValores->dataParecer                     = $oRow->getAttribute("dataParecer");
		$oValores->nroCpf                          = $oRow->getAttribute("nroCpf");
		$oValores->nomRespParecer                  = $oRow->getAttribute("nomRespParecer");
		$oValores->logradouro                      = $oRow->getAttribute("logradouro");
		$oValores->bairroLogra                     = $oRow->getAttribute("bairroLogra");
		$oValores->codCidadeLogra                  = $oRow->getAttribute("codCidadeLogra");
		$oValores->ufCidadeLogra                   = $oRow->getAttribute("ufCidadeLogra");
		$oValores->cepLogra                   	   = $oRow->getAttribute("cepLogra");
		$oValores->telefone                        = $oRow->getAttribute("telefone");
		$oValores->email                           = $oRow->getAttribute("email");
		$aValores[] = $oValores;

  }

}
echo json_encode($aValores);
