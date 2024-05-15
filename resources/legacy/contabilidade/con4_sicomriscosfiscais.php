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

$sArquivo = "legacy_config/sicom/{$sCnpj}_sicomriscos.xml";
if (isset($_POST['btnSalvar'])){

	if (!file_exists($sArquivo)) {

    $oDOMDocument = new DOMDocument('1.0','ISO-8859-1');
    $oRoot  = $oDOMDocument->createElement('riscos');

  }else{

  	$oDOMDocument = new DOMDocument();
  	$sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument->loadXML($sTextoXml);
    $oRoot  = $oDOMDocument->documentElement;

  }

  $oDOMDocument->formatOutput = true;

  $oDados = $oDOMDocument->getElementsByTagName('risco');

  /**
   * caso o codigo já exista no xml irá atualizar o registro
   */
  foreach ($oDados as $oRow) {

  	$iUltimoCodigo = $oRow->getAttribute("codRisco");
		if ($oRow->getAttribute("codRisco") == $_POST['codRisco']) {

			$oDado = new stdClass();
			$oDado = $oRow;
			unset($_POST['btnSalvar']);
			$oDado->setAttribute("instituicao", db_getsession("DB_instit"));

			$aCaracteres = array('\"', "\'");

		  /**
		   * tirando barras e tratando acentos dos inputs para texto
		   */
		  $_POST['dscRiscoFiscal'] = str_replace($aCaracteres, "", $_POST['dscRiscoFiscal']);
  	  $_POST['dscRiscoFiscal'] = trim(utf8_encode($_POST['dscRiscoFiscal']));

  	  /**
  	   * passar os valores para o objeto para ser salvo no xml
  	   */
		  foreach ($_POST as $coll => $value) {
			  $oDado->setAttribute($coll, $value);
		  }
		  $oDOMDocument->save($sArquivo);
		  if (filesize($sArquivo) > filesize("legacy_config/sicom/backup_{$sCnpj}_sicomriscos.xml")/2) {
		    system("cp $sArquivo legacy_config/sicom/backup_{$sCnpj}_sicomriscos.xml");
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
  	$oDado  = $oDOMDocument->createElement('risco');
  	$oDado->setAttribute("instituicao", db_getsession("DB_instit"));

  	$aCaracteres = array('\"', "\'");

		/**
		 * tirando barras e tratando acentos dos inputs para texto
		 */
		$_POST['dscRiscoFiscal'] = str_replace($aCaracteres, "", $_POST['dscRiscoFiscal']);
  	$_POST['dscRiscoFiscal'] = trim(utf8_encode($_POST['dscRiscoFiscal']));

  	/**
  	 * passar os valores para o objeto para ser salvo no xml
  	 */
	  foreach ($_POST as $coll => $value) {
		  $oDado->setAttribute($coll, $value);
	  }
	  $oDado->setAttribute("codRisco", $iUltimoCodigo+1);

	  if (!file_exists($sArquivo)) {


	  	$oRoot->appendChild($oDado);
	    $oDOMDocument->appendChild($oRoot);

	  } else {
	  	$oDado = $oRoot->appendChild($oDado);
	  }
	  $oDOMDocument->save($sArquivo);
    if (filesize($sArquivo) > filesize("legacy_config/sicom/backup_{$sCnpj}_sicomriscos.xml")/2) {
		  system("cp $sArquivo legacy_config/sicom/backup_{$sCnpj}_sicomriscos.xml");
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
  $oRiscos      = $oDOMDocument->getElementsByTagName('risco');

  /**
   * encontrar o codigo selecionado para excluir o registro no xml
   */
  foreach ($oRiscos as $oRisc) {

		if ($oRisc->getAttribute("codRisco") == $_POST['codRisco']) {

		  $oDocument->removeChild($oRisc);
		  $oDOMDocument->save($sArquivo);
		  system("cp $sArquivo legacy_config/sicom/backup_{$sCnpj}_sicomriscos.xml");
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
<script language="JavaScript" type="text/javascript"
  src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript"
  src="scripts/strings.js"></script>
<script language="JavaScript" type="text/javascript"
  src="scripts/prototype.js"></script>

<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/frmsicomriscofiscal.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
