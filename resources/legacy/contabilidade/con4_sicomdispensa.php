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
$sArquivo = "legacy_config/sicom/{$sCnpj}_sicomdispensas.xml";

/*
 * inserir ou atualizar registro do xml
 */
if (isset($_POST['btnSalvar'])){

	if (!file_exists($sArquivo)) {

    $oDOMDocument = new DOMDocument('1.0','ISO-8859-1');
    $oRoot  = $oDOMDocument->createElement('dispensas');

  }else{

  	$oDOMDocument = new DOMDocument();
  	$sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument->loadXML($sTextoXml);
    $oRoot  = $oDOMDocument->documentElement;

  }

  $oDOMDocument->formatOutput = true;

  $oDados      = $oDOMDocument->getElementsByTagName('dispensa');

  /**
   * caso o codigo já exista no xml irá atualizar o registro
   */

  foreach ($oDados as $oRow) {

  	$iUltimoCodigo = $oRow->getAttribute("codigo");
		if ($oRow->getAttribute("codigo") == $_POST['codigo']) {

			$oDado = new stdClass();
			$oDado = $oRow;
			unset($_POST['btnSalvar']);
			$oDado->setAttribute("instituicao", db_getsession("DB_instit"));

			$aCaracteres = array('\"', "\'");
			/*
			 * tirando barras e tratando acentos dos inputs para texto
			 */
			$_POST['justificativa'] = str_replace($aCaracteres, "", $_POST['justificativa']);
  	  $_POST['justificativa'] = trim(utf8_encode($_POST['justificativa']));

  	  $_POST['razao'] = str_replace($aCaracteres, "", $_POST['razao']);
  	  $_POST['razao'] = trim(utf8_encode($_POST['razao']));

  	  /**
  	   * passar os valores para o objeto para ser salvo no xml
  	   */

		  foreach ($_POST as $coll => $value) {
			  $oDado->setAttribute($coll, $value);
		  }
		  $oDOMDocument->save($sArquivo);
		  system("cp $sArquivo legacy_config/sicom/backup_{$sCnpj}_sicomdispensas.xml");
			echo"
			<script LANGUAGE=\"Javascript\">
			alert(\"Seu cadastro foi realizado com sucesso.\");
			</SCRIPT>";
			break;
    }

  }
  if (!$oDado) {

  	unset($_POST['btnSalvar']);

  	$oDado  = $oDOMDocument->createElement('dispensa');

  	$oDado->setAttribute("instituicao", db_getsession("DB_instit"));


  	/**
  	 * passar os valores para o objeto para ser salvo no xml
  	 */

  	$aCaracteres = array('\"', "\'");
			/*
			 * tirando barras e tratando acentos dos inputs para texto
			 */
		$_POST['justificativa'] = str_replace($aCaracteres, "", $_POST['justificativa']);
  	$_POST['justificativa'] = utf8_encode($_POST['justificativa']);

  	$_POST['razao'] = str_replace($aCaracteres, "", $_POST['razao']);
    $_POST['razao'] = utf8_encode($_POST['razao']);


	  foreach ($_POST as $coll => $value) {
		  $oDado->setAttribute($coll, $value);
	  }

	  $iUltimoCodigo++;

	  $oDado->setAttribute("codigo", $iUltimoCodigo);

	  if (!file_exists($sArquivo)) {

	  	$oRoot->appendChild($oDado);
	    $oDOMDocument->appendChild($oRoot);

	  } else {
	  	$oDado = $oRoot->appendChild($oDado);
	  }

	  $oDOMDocument->save($sArquivo);
	  system("cp $sArquivo legacy_config/sicom/backup_{$sCnpj}_sicomdispensas.xml");
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
  $oDados      = $oDOMDocument->getElementsByTagName('dispensa');

  /**
   * encontrar o codigo selecionado para excluir o registro no xml
   */
  foreach ($oDados as $oRow) {

		if ($oRow->getAttribute("codigo") == $_POST['codigo']) {

		  $oDocument->removeChild($oRow);
		  $oDOMDocument->save($sArquivo);
		  system("cp $sArquivo legacy_config/sicom/backup_{$sCnpj}_sicomdispensas.xml");
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
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/jquery.min.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
</table>
    <center>
	<?
	include("forms/frmsicomdispensa.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
