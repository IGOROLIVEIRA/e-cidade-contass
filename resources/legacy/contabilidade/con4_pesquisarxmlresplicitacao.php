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

$sArquivo = "legacy_config/sicom/{$sCnpj}_sicomresplicitacao.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oDados = $oDOMDocument->getElementsByTagName('resplicitacao');

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
	  $oValores->codTipoComissao                 = $oRow->getAttribute("codTipoComissao");
	  $oValores->descricaoAtoNomeacao            = $oRow->getAttribute("descricaoAtoNomeacao");
	  $oValores->nroAtoNomeacao                  = $oRow->getAttribute("nroAtoNomeacao");
	  $oValores->dataAtoNomeacao                 = $oRow->getAttribute("dataAtoNomeacao");
	  $oValores->inicioVigencia                  = $oRow->getAttribute("inicioVigencia");
	  $oValores->finalVigencia                   = $oRow->getAttribute("finalVigencia");
	  $oValores->cpfMembroComissao               = $oRow->getAttribute("cpfMembroComissao");
	  $oValores->nomMembroComLic                 = $oRow->getAttribute("nomMembroComLic");
	  $oValores->codAtribuicao                   = $oRow->getAttribute("codAtribuicao");
	  $oValores->cargo                           = $oRow->getAttribute("cargo");
	  $oValores->naturezaCargo                   = $oRow->getAttribute("naturezaCargo");
	  $oValores->logradouro                      = $oRow->getAttribute("logradouro");
	  $oValores->bairroLogra                     = $oRow->getAttribute("bairroLogra");
	  $oValores->codCidadeLogra                  = $oRow->getAttribute("codCidadeLogra");
	  $oValores->ufCidadeLogra                   = $oRow->getAttribute("ufCidadeLogra");
	  $oValores->cepLogra                        = $oRow->getAttribute("cepLogra");
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
	$oValores->codTipoComissao                 = $oRow->getAttribute("codTipoComissao");
	$oValores->descricaoAtoNomeacao            = $oRow->getAttribute("descricaoAtoNomeacao");
	$oValores->nroAtoNomeacao                  = $oRow->getAttribute("nroAtoNomeacao");
	$oValores->dataAtoNomeacao                 = $oRow->getAttribute("dataAtoNomeacao");
	$oValores->inicioVigencia                  = $oRow->getAttribute("inicioVigencia");
	$oValores->finalVigencia                   = $oRow->getAttribute("finalVigencia");
	$oValores->cpfMembroComissao               = $oRow->getAttribute("cpfMembroComissao");
	$oValores->nomMembroComLic                 = $oRow->getAttribute("nomMembroComLic");
	$oValores->codAtribuicao                   = $oRow->getAttribute("codAtribuicao");
	$oValores->cargo                           = $oRow->getAttribute("cargo");
	$oValores->naturezaCargo                   = $oRow->getAttribute("naturezaCargo");
	$oValores->logradouro                      = $oRow->getAttribute("logradouro");
	$oValores->bairroLogra                     = $oRow->getAttribute("bairroLogra");
	$oValores->codCidadeLogra                  = $oRow->getAttribute("codCidadeLogra");
	$oValores->ufCidadeLogra                   = $oRow->getAttribute("ufCidadeLogra");
	$oValores->cepLogra                        = $oRow->getAttribute("cepLogra");
	$oValores->telefone                        = $oRow->getAttribute("telefone");
	$oValores->email                           = $oRow->getAttribute("email");
	$aValores[] = $oValores;

  }

}
echo json_encode($aValores);
