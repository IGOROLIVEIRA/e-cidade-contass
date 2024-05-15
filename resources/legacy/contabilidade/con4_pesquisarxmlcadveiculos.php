<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

$oDaoVeiculos             = db_utils::getdao('veiculos');
$oDaoVeicCadCentralDepart = db_utils::getdao('veiccadcentraldepart');

$oDaoVeiculos->rotulo->label("ve01_codigo");
$oDaoVeicCadCentralDepart->rotulo->label("ve37_veiccadcentral");


/* Descubro a central deste departamento */
$sWhereCentral = " ve37_coddepto = ".db_getsession("DB_coddepto");
$sSqlCentral   = $oDaoVeicCadCentralDepart->sql_query("",
"ve37_veiccadcentral",
"",
$sWhereCentral
);
$rsCentral     = $oDaoVeicCadCentralDepart->sql_record($sSqlCentral);

/* Se encontrou resultado */
if ($oDaoVeicCadCentralDepart->numrows > 0) {

  $sIn        = "";
  $sConcatena = "";

/* Adiciona as centrais encontradas no IN do where */
  for ($iCont = 0; $iCont < $oDaoVeicCadCentralDepart->numrows; $iCont++) {

    $oDados     = db_utils::fieldsmemory($rsCentral, $iCont);
    $sIn       .= $sConcatena.$oDados->ve37_veiccadcentral;
    $sConcatena = ", ";

  }

  $sWhere .= " ve36_sequencial in($sIn) ";
}
$sWhere = " and ".$sWhere;

$sSql  = "SELECT * FROM db_config ";
$sSql .= "	WHERE prefeitura = 't'";

$rsInst = db_query($sSql);
$sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;

$sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomcadveiculos.xml";

$oDOMDocument = new DOMDocument();

$sTextoXml    = file_get_contents($sArquivo);
$oDOMDocument->loadXML($sTextoXml);
$oDOMDocument->formatOutput = true;

$oDados = $oDOMDocument->getElementsByTagName('cadveiculo');


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

      $sSqlVeiculos = $oDaoVeiculos->sql_query_central($pesquisa_chave,
      "*",
      null,
      "ve01_codigo = ".$oRow->getAttribute("codVeiculo")." and ve01_ativo = '1'".$sWhere
      );
      $result = $oDaoVeiculos->sql_record($sSqlVeiculos);
  	  $sPlaca = db_utils::fieldsMemory($result, 0)->ve01_placa;

  	  $oValores = new stdClass();
	    $oValores->codigo                   = $oRow->getAttribute("codigo");
	    $oValores->codVeiculo               = $oRow->getAttribute("codVeiculo");
	    $oValores->nomeEstabelecimento      = $oRow->getAttribute("nomeEstabelecimento");
	    $oValores->localidade         			= $oRow->getAttribute("localidade");
	    $oValores->numeroPassageiros        = $oRow->getAttribute("numeroPassageiros");
	    $oValores->distanciaEstabelecimento = $oRow->getAttribute("distanciaEstabelecimento");
	    $oValores->turnos       					  = $oRow->getAttribute("turnos");
	    $oValores->placaVeiculo       		  = $sPlaca;
	    $aValores[] = $oValores;

  	}

  }

} else {

  /**
   * percorrer os dados do xml para passar para o objeto e ser adicionado ao array
   */
  foreach ($oDados as $oRow) {

    $sSqlVeiculos = $oDaoVeiculos->sql_query_central($pesquisa_chave,
    "*",
    null,
    "ve01_codigo = ".$oRow->getAttribute("codVeiculo")." and ve01_ativo = '1'".$sWhere
    );
    $result = $oDaoVeiculos->sql_record($sSqlVeiculos);
  	$sPlaca = db_utils::fieldsMemory($result, 0)->ve01_placa;

    $oValores = new stdClass();
	  $oValores->codigo                   = $oRow->getAttribute("codigo");
	  $oValores->codVeiculo               = $oRow->getAttribute("codVeiculo");
	  $oValores->nomeEstabelecimento      = $oRow->getAttribute("nomeEstabelecimento");
	  $oValores->localidade         			= $oRow->getAttribute("localidade");
	  $oValores->numeroPassageiros        = $oRow->getAttribute("numeroPassageiros");
	  $oValores->distanciaEstabelecimento = $oRow->getAttribute("distanciaEstabelecimento");
	  $oValores->turnos       				    = $oRow->getAttribute("turnos");
	  $oValores->placaVeiculo       		  = $sPlaca;
	  $aValores[] = $oValores;

  }

}
echo json_encode($aValores);
