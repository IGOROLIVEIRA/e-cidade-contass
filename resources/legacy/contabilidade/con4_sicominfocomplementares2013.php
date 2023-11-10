<?
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");

$sSql  = "SELECT * FROM db_config ";
$sSql .= "	WHERE prefeitura = 't'";

$rsInst = db_query($sSql);
$sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;
$sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomorgao.xml";

/*
 * inserir ou atualizar registro do xml
 */
if (isset($_POST['btnSalvar'])){

	if (!file_exists($sArquivo)) {

    $oDOMDocument = new DOMDocument('1.0','ISO-8859-1');
    $oRoot  = $oDOMDocument->createElement('orgaos');

  }else{

  	$oDOMDocument = new DOMDocument();
  	$sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument->loadXML($sTextoXml);
    $oRoot  = $oDOMDocument->documentElement;

  }

  $oDOMDocument->formatOutput = true;

  $oDados      = $oDOMDocument->getElementsByTagName('orgao');

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

  	  /**
  	   * passar os valores para o objeto para ser salvo no xml
  	   */

		  foreach ($_POST as $coll => $value) {
			  $oDado->setAttribute($coll, $value);
		  }
		  $oDOMDocument->save($sArquivo);
		  if (filesize($sArquivo) > filesize("legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomorgao.xml")/2) {
		    system("cp $sArquivo legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomorgao.xml");
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

  	$oDado  = $oDOMDocument->createElement('orgao');

  	$oDado->setAttribute("instituicao", db_getsession("DB_instit"));


  	/**
  	 * passar os valores para o objeto para ser salvo no xml
  	 */
	  foreach ($_POST as $coll => $value) {
		  $oDado->setAttribute($coll, $value);
	  }
	  $oDado->setAttribute("codigo", $iUltimoCodigo+1);

	  if (!file_exists($sArquivo)) {

	  	$oRoot->appendChild($oDado);
	    $oDOMDocument->appendChild($oRoot);

	  } else {
	  	$oDado = $oRoot->appendChild($oDado);
	  }

	  $oDOMDocument->save($sArquivo);
    if (filesize($sArquivo) > filesize("legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomorgao.xml")/2) {
		  system("cp $sArquivo legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomorgao.xml");
		}
		echo"
		<script LANGUAGE=\"Javascript\">
		alert(\"Seu cadastro foi realizado com sucesso.\");
		</SCRIPT>";
  }
}

if (file_exists($sArquivo)) {

  $sTextoXml    = file_get_contents($sArquivo);
  $oDOMDocument = new DOMDocument();
  $oDOMDocument->loadXML($sTextoXml);
  $oOrgaos      = $oDOMDocument->getElementsByTagName('orgao');
  foreach ($oOrgaos as $oOrg) {

		if ($oOrg->getAttribute("instituicao") == db_getsession("DB_instit")) {

			$oOrgao = new stdClass();
			$oOrgao->codigo              = $oOrg->getAttribute('codigo');
			$oOrgao->instituicao         = $oOrg->getAttribute('instituicao');
			$oOrgao->codOrgao            = $oOrg->getAttribute('codOrgao');
			$oOrgao->cpfGestor           = $oOrg->getAttribute('cpfGestor');
			$oOrgao->tipoOrgao           = $oOrg->getAttribute('tipoOrgao');
			$oOrgao->opcaoSemestralidade = $oOrg->getAttribute('opcaoSemestralidade');
			$oOrgao->ctINSS              = $oOrg->getAttribute('ctINSS');
			$oOrgao->ctRPPS              = $oOrg->getAttribute('ctRPPS');
			$oOrgao->ctIRRF              = $oOrg->getAttribute('ctIRRF');
			$oOrgao->ctISSQN             = $oOrg->getAttribute('ctISSQN');
			$oOrgao->ctRepasseCamara     = $oOrg->getAttribute('ctRepasseCamara');
			$oOrgao->trataCodUnidade     = $oOrg->getAttribute('trataCodUnidade');
			$oOrgao->cnpjCamara          = $oOrg->getAttribute('cnpjCamara');
			$oOrgao->cpfOrdPag           = $oOrg->getAttribute('cpfOrdPag');
			$oOrgao->tipoLiquidante      = $oOrg->getAttribute('tipoLiquidante');


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
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
</table>
    <center>
	<?
	include("forms/frmsicominfocomplementar2013.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>



