<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include_once("libs/db_sessoes.php");
include_once("libs/db_usuariosonline.php");
include_once("dbforms/db_funcoes.php");
include("classes/db_orcorgao_classe.php");

$clorcorgao = new cl_orcorgao;
$clorcorgao->rotulo->label("o40_anousu");
$clorcorgao->rotulo->label("o40_orgao");
$clorcorgao->rotulo->label("o40_descr");

$sSql  = "SELECT * FROM db_config ";
$sSql .= "	WHERE prefeitura = 't'";

$rsInst = db_query($sSql);
$sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;

$sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomidentresponsavel.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oDados = $oDOMDocument->getElementsByTagName('identresp');

/**
 * dados paginacao
 */
$iQuantLinhas = 15;
if (isset($_POST['inicio'])) {
	$iInicio      = $_POST['inicio']*15;
} else {
  $iInicio      = 0*15;
}


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
  	if ($oRow->getAttribute("codigo") == $_POST['codigo1'] || $oRow->getAttribute("numCgm") == $_POST['codigo2']) {

  		$sSql  =  "SELECT z01_nome from cgm where z01_numcgm = ".$oRow->getAttribute("numCgm");
		  $rsCgm = db_query($sSql);
		  $sNome  = db_utils::fieldsMemory($rsCgm, 0)->z01_nome;

  	  if ($oRow->getAttribute("tipoResponsavel") == '04') {
  	    $result = $clorcorgao->sql_record($clorcorgao->sql_query(null,null,"*",""," o40_anousu = ".db_getsession('DB_anousu')." and o40_orgao = ".$oRow->getAttribute("OrgaoResp")." and o40_instit = ".db_getsession('DB_instit')));
		    $sNomeOrgao = db_utils::fieldsMemory($result, 0)->o40_descr;
  	  } else {
  		  $sNomeOrgao = "Não Aplicável";
  	  }

  		$oValores = new stdClass();
		  $oValores->codigo            = $oRow->getAttribute("codigo");
			$oValores->numCgm            = $oRow->getAttribute("numCgm");
			$oValores->nomeResponsavel   = utf8_encode($sNome);
			$oValores->tipoResponsavel   = $oRow->getAttribute("tipoResponsavel");
			$oValores->OrgaoResp         = $oRow->getAttribute("OrgaoResp");
			$oValores->orgEmissorCi      = $oRow->getAttribute("orgEmissorCi");
			$oValores->crcContador       = $oRow->getAttribute("crcContador");
			$oValores->ufCrcContador     = $oRow->getAttribute("ufCrcContador");
			$oValores->cargoOrdDespDeleg = $oRow->getAttribute("cargoOrdDespDeleg");
			$oValores->dtInicio          = $oRow->getAttribute("dtInicio");
			$oValores->dtFinal           = $oRow->getAttribute("dtFinal");
			$oValores->codCidadeLogra    = $oRow->getAttribute("codCidadeLogra");
			$oValores->nomeOrgao          = utf8_encode($sNomeOrgao);
			$aValores[] = $oValores;
			break;

  	}

  }

} else {

	/**
	 * percorrer os dados do xml para passar para o objeto e ser adicionado ao array
	 */
  for ($iCont = $iInicio; $iCont < ($iInicio+$iQuantLinhas); $iCont++) {

  	$oRow = $oDados->item($iCont);
  	$sSql  =  "SELECT z01_nome from cgm where z01_numcgm = ".$oRow->getAttribute("numCgm");
		$rsCgm = db_query($sSql);
		$sNome  = db_utils::fieldsMemory($rsCgm, 0)->z01_nome;

    if ($oRow->getAttribute("tipoResponsavel") == '04') {
  	  $result = $clorcorgao->sql_record($clorcorgao->sql_query(null,null,"*",""," o40_anousu = ".db_getsession('DB_anousu')." and o40_orgao = ".$oRow->getAttribute("OrgaoResp")." and o40_instit = ".db_getsession('DB_instit')));
		  $sNomeOrgao = db_utils::fieldsMemory($result, 0)->o40_descr;
  	} else {
  		$sNomeOrgao = "Não Aplicável";
  	}

  	$oValores = new stdClass();
		$oValores->codigo             = $oRow->getAttribute("codigo");
		$oValores->numCgm             = $oRow->getAttribute("numCgm");
		$oValores->nomeResponsavel    = utf8_encode($sNome);
		$oValores->tipoResponsavel    = $oRow->getAttribute("tipoResponsavel");
		$oValores->OrgaoResp          = $oRow->getAttribute("OrgaoResp");
		$oValores->orgEmissorCi       = $oRow->getAttribute("orgEmissorCi");
		$oValores->crcContador        = $oRow->getAttribute("crcContador");
		$oValores->ufCrcContador      = $oRow->getAttribute("ufCrcContador");
		$oValores->cargoOrdDespDeleg  = $oRow->getAttribute("cargoOrdDespDeleg");
		$oValores->dtInicio           = $oRow->getAttribute("dtInicio");
		$oValores->dtFinal            = $oRow->getAttribute("dtFinal");
		$oValores->codCidadeLogra     = $oRow->getAttribute("codCidadeLogra");
		$oValores->nomeOrgao          = utf8_encode($sNomeOrgao);
		$aValores[] = $oValores;

		if ($iCont == $oDados->length-1) {
			break;
		}

  }

}
echo json_encode($aValores);
