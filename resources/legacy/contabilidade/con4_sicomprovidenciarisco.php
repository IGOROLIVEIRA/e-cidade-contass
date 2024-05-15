<?
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

$sArquivo = "legacy_config/sicom/{$sCnpj}_sicomprovidenciasriscos.xml";
if (isset($_POST['btnSalvar'])){

	if (!file_exists($sArquivo)) {

    $oDOMDocument = new DOMDocument('1.0','ISO-8859-1');
    $oRoot  = $oDOMDocument->createElement('providencias');

  }else{

  	$oDOMDocument = new DOMDocument();
  	$sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument->loadXML($sTextoXml);
    $oRoot  = $oDOMDocument->documentElement;

  }

  $oDOMDocument->formatOutput = true;

  $oDados = $oDOMDocument->getElementsByTagName('providencia');

  /**
   * caso o codigo já exista no xml irá atualizar o registro
   */
  foreach ($oDados as $oRow) {

  	$iUltimoCodigo = $oRow->getAttribute("codProvidencia");
		if ($oRow->getAttribute("codProvidencia") == $_POST['codProvidencia']) {

			$oDado = new stdClass();
			$oDado = $oRow;
			unset($_POST['btnSalvar']);
			$oDado->setAttribute("instituicao", db_getsession("DB_instit"));

			$aCaracteres = array('\"', "\'");

		  /**
		   * tirando barras e tratando acentos dos inputs para texto
		   */
		  $_POST['dscProvidencia'] = str_replace($aCaracteres, "", $_POST['dscProvidencia']);
  	  $_POST['dscProvidencia'] = trim(utf8_encode($_POST['dscProvidencia']));

  	  /**
  	   * passar os valores para o objeto para ser salvo no xml
  	   */
		  foreach ($_POST as $coll => $value) {
			  $oDado->setAttribute($coll, $value);
		  }
		  $oDOMDocument->save($sArquivo);
		  if (filesize($sArquivo) > filesize("legacy_config/sicom/backup_{$sCnpj}_sicomprovidenciasriscos.xml")/2) {
		    system("cp $sArquivo legacy_config/sicom/backup_{$sCnpj}_sicomprovidenciasriscos.xml");
		  }
			echo"
			<script LANGUAGE=\"Javascript\">
			alert(\"Seu cadastro foi realizado com sucesso.\");
			</SCRIPT>";
			break;
    }

  }
  if (!$oDado) {

  	unset($_POST['btnSalvar']);
  	$oDado  = $oDOMDocument->createElement('providencia');
  	$oDado->setAttribute("instituicao", db_getsession("DB_instit"));

  	$aCaracteres = array('\"', "\'");

		/**
		 * tirando barras e tratando acentos dos inputs para texto
		 */
		$_POST['dscProvidencia'] = str_replace($aCaracteres, "", $_POST['dscProvidencia']);
  	$_POST['dscProvidencia'] = trim(utf8_encode($_POST['dscProvidencia']));

  	/**
  	 * passar os valores para o objeto para ser salvo no xml
  	 */
	  foreach ($_POST as $coll => $value) {
		  $oDado->setAttribute($coll, $value);
	  }
	  $oDado->setAttribute("codProvidencia", $iUltimoCodigo+1);

	  if (!file_exists($sArquivo)) {


	  	$oRoot->appendChild($oDado);
	    $oDOMDocument->appendChild($oRoot);

	  } else {
	  	$oDado = $oRoot->appendChild($oDado);
	  }
	  $oDOMDocument->save($sArquivo);
    if (filesize($sArquivo) > filesize("legacy_config/sicom/backup_{$sCnpj}_sicomprovidenciasriscos.xml")/2) {
		  system("cp $sArquivo legacy_config/sicom/backup_{$sCnpj}_sicomprovidenciasriscos.xml");
		}
		echo"
		<script LANGUAGE=\"Javascript\">
		alert(\"Seu cadastro foi realizado com sucesso.\");
		</SCRIPT>";
  }
}

/*
 * remover um registro do xml
 */
if (isset($_POST['btnExcluir'])){

	if (!file_exists($sArquivo)) {
    $oDOMDocument = new DOMDocument('1.0','ISO-8859-1');
  }else{
  	$oDOMDocument = new DOMDocument();
  }

 	$sTextoXml    = file_get_contents($sArquivo);
  $oDOMDocument->loadXML($sTextoXml);
  $oDOMDocument->formatOutput = true;
	$oDocument = $oDOMDocument->documentElement;
  $oRiscos      = $oDOMDocument->getElementsByTagName('providencia');

  /**
   * encontrar o codigo selecionado para excluir o registro no xml
   */
  foreach ($oRiscos as $oRisc) {

		if ($oRisc->getAttribute("codProvidencia") == $_POST['codProvidencia']) {

		  $oDocument->removeChild($oRisc);
		  $oDOMDocument->save($sArquivo);
		  system("cp $sArquivo legacy_config/sicom/backup_{$sCnpj}_sicomprovidenciasriscos.xml");
			echo"
			<script LANGUAGE=\"Javascript\">
			alert(\"Registro removido com sucesso.\");
			</SCRIPT>";
			break;
    }

  }

}

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/frmsicomprovidencia.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
