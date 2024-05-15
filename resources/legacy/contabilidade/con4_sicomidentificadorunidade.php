<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
$sArquivo = "legacy_config/sicom/sicomoidentificadorunidade.xml";

/*
 * inserir ou atualizar registro do xml
 */
if (isset($_POST['btnSalvar'])){

	if (!file_exists($sArquivo)) {

    $oDOMDocument = new DOMDocument('1.0','ISO-8859-1');
    $oUnidadeRoot  = $oDOMDocument->createElement('unidades');

  } else {

  	$oDOMDocument = new DOMDocument();
  	$sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument->loadXML($sTextoXml);
    $oUnidadeRoot  = $oDOMDocument->documentElement;

  }

  $oDOMDocument->formatOutput = true;

  $oUnidades      = $oDOMDocument->getElementsByTagName('unidade');

  /**
   * comentario robson teste branch
   */
  foreach ($oUnidades as $oUni) {

  	$iUltimoCodigo = $oUni->getAttribute("codigo");
		if ($oUni->getAttribute("codigo") == $_POST['codigo']) {

			$oUnidade = new stdClass();
			$oUnidade = $oUni;
			unset($_POST['btnSalvar']);
			$oUnidade->setAttribute("instituicao", db_getsession("DB_instit"));
			$aCaracteres = array('\"', "\'");
		  $_POST['dscTipoUnidade'] = str_replace($aCaracteres, "", $_POST['dscTipoUnidade']);
  	  $_POST['dscTipoUnidade'] = utf8_encode($_POST['dscTipoUnidade']);
		  foreach ($_POST as $coll => $value) {
			  $oUnidade->setAttribute($coll, $value);
		  }
		  $oDOMDocument->save($sArquivo);
		  system("cp $sArquivo legacy_config/sicom/backup_sicomoidentificadorunidade.xml");
			echo"
			<script LANGUAGE=\"Javascript\">
			alert(\"Seu cadastro foi realizado com sucesso.\");
			</SCRIPT>";
			break;
    }

  }
  if (!$oUnidade) {

  	unset($_POST['btnSalvar']);

  	$oUnidade  = $oDOMDocument->createElement('unidade');

  	$oUnidade->setAttribute("instituicao", db_getsession("DB_instit"));

  	$aCaracteres = array('\"', "\'");
		$_POST['dscTipoUnidade'] = str_replace($aCaracteres, "", $_POST['dscTipoUnidade']);
  	$_POST['dscTipoUnidade'] = utf8_encode($_POST['dscTipoUnidade']);

	  foreach ($_POST as $coll => $value) {
		  $oUnidade->setAttribute($coll, $value);
	  }
	  $oUnidade->setAttribute("codigo", $iUltimoCodigo+1);

	  if (!file_exists($sArquivo)) {

	  	$oUnidadeRoot->appendChild($oUnidade);
	    $oDOMDocument->appendChild($oUnidadeRoot);

	  } else {
	  	$oUnidade = $oUnidadeRoot->appendChild($oUnidade);
	  }

	  $oDOMDocument->save($sArquivo);
	  system("cp $sArquivo legacy_config/sicom/backup_sicomoidentificadorunidade.xml");
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
  $oUnidades      = $oDOMDocument->getElementsByTagName('unidade');
  foreach ($oUnidades as $oUni) {

		if ($oUni->getAttribute("codigo") == $_POST['codigo']) {

		  $oDocument->removeChild($oUni);
		  $oDOMDocument->save($sArquivo);
		  system("cp $sArquivo legacy_config/sicom/backup_sicomoidentificadorunidade.xml");
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
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
    <center>
	<?
	include("forms/frmsicomidentificadorunidade.php");
	?>
    </center>
	</td>
  </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
