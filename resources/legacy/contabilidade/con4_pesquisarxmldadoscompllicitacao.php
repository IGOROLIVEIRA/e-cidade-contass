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

$sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomdadoscompllicitacao.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oDados = $oDOMDocument->getElementsByTagName('dadoscompllicitacao');

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
  	if ($oRow->getAttribute("codigo") == $_POST['codigo1'] || $oRow->getAttribute("nroDecretoMunicipal") == $_POST['codigo2']) {

  	  $oValores = new stdClass();

  	  $oValores->codigo		                  = $oRow->getAttribute("codigo");
		  $oValores->nroProcessoLicitatorio     = $oRow->getAttribute("nroProcessoLicitatorio");
		  $oValores->codigoProcesso		          = $oRow->getAttribute("codigoProcesso");
		  $oValores->ano                        = $oRow->getAttribute("ano");
		  $oValores->dtRecebimentoDoc           = $oRow->getAttribute("dtRecebimentoDoc");
		  $oValores->tipoLicitacao              = $oRow->getAttribute("tipoLicitacao");
		  $oValores->naturezaObjeto             = $oRow->getAttribute("naturezaObjeto");
		  $oValores->regimeExecucaoObras        = $oRow->getAttribute("regimeExecucaoObras");
		  $oValores->nroConvidado               = $oRow->getAttribute("nroConvidado");
		  $oValores->unidadeMedidaPrazoExecucao = $oRow->getAttribute("unidadeMedidaPrazoExecucao");
		  $oValores->prazoExecucao              = $oRow->getAttribute("prazoExecucao");
		  $oValores->formaPagamento             = $oRow->getAttribute("formaPagamento");
		  $oValores->descontoTabela             = $oRow->getAttribute("descontoTabela");
		  $oValores->tipoProcesso               = $oRow->getAttribute("tipoProcesso");
		  $oValores->naturezaObjeto2            = $oRow->getAttribute("naturezaObjeto2");
		  $oValores->justificativa              = $oRow->getAttribute("justificativa");
		  $oValores->razao                      = $oRow->getAttribute("razao");
		  $oValores->veiculoPublicacao          = $oRow->getAttribute("veiculoPublicacao");
		  $oValores->PresencaLicitantes         = $oRow->getAttribute("PresencaLicitantes");
		  $aValores[] = $oValores;

  	}

  }

} else {

  /**
   * percorrer os dados do xml para passar para o objeto e ser adicionado ao array
   */
  foreach ($oDados as $oRow) {

  	$oValores = new stdClass();

 	  $oValores->codigo		                  = $oRow->getAttribute("codigo");
	  $oValores->nroProcessoLicitatorio     = $oRow->getAttribute("nroProcessoLicitatorio");
	  $oValores->codigoProcesso		          = $oRow->getAttribute("codigoProcesso");
	  $oValores->ano                        = $oRow->getAttribute("ano");
	  $oValores->dtRecebimentoDoc           = $oRow->getAttribute("dtRecebimentoDoc");
	  $oValores->tipoLicitacao              = $oRow->getAttribute("tipoLicitacao");
	  $oValores->naturezaObjeto             = $oRow->getAttribute("naturezaObjeto");
	  $oValores->regimeExecucaoObras        = $oRow->getAttribute("regimeExecucaoObras");
	  $oValores->nroConvidado               = $oRow->getAttribute("nroConvidado");
	  $oValores->unidadeMedidaPrazoExecucao = $oRow->getAttribute("unidadeMedidaPrazoExecucao");
	  $oValores->prazoExecucao              = $oRow->getAttribute("prazoExecucao");
	  $oValores->formaPagamento             = $oRow->getAttribute("formaPagamento");
	  $oValores->descontoTabela             = $oRow->getAttribute("descontoTabela");
	  $oValores->tipoProcesso               = $oRow->getAttribute("tipoProcesso");
		$oValores->naturezaObjeto2            = $oRow->getAttribute("naturezaObjeto2");
		$oValores->justificativa              = $oRow->getAttribute("justificativa");
		$oValores->razao                      = $oRow->getAttribute("razao");
		$oValores->veiculoPublicacao          = $oRow->getAttribute("veiculoPublicacao");
		$oValores->PresencaLicitantes         = $oRow->getAttribute("PresencaLicitantes");
	  $aValores[] = $oValores;

  }

}
echo json_encode($aValores);
