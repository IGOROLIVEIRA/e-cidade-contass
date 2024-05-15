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

$sArquivo       = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomhabilitacao.xml";
$sArquivoSocios = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomhabilitacaosocios.xml";

/*
 * inserir ou atualizar registro do xml
 */
if (isset($_POST['btnSalvar'])){

	/*
   * verificar existencia para criar xml habilitacoes
   */
	if (!file_exists($sArquivo)) {

    $oDOMDocument = new DOMDocument('1.0','ISO-8859-1');
    $oRoot  = $oDOMDocument->createElement('habilitacoes');

  }else{

  	$oDOMDocument = new DOMDocument();
  	$sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument->loadXML($sTextoXml);
    $oRoot  = $oDOMDocument->documentElement;

  }

  /*
   * verificar existencia para criar xml socios
   */
  if (!file_exists($sArquivoSocios)) {

    $oDOMDocumentSocio = new DOMDocument('1.0','ISO-8859-1');
    $oRootSocio  = $oDOMDocumentSocio->createElement('habilitacoessocios');

  }else{

  	$oDOMDocumentSocio = new DOMDocument();
  	$sTextoXmlSocio    = file_get_contents($sArquivoSocios);
    $oDOMDocumentSocio->loadXML($sTextoXmlSocio);
    $oRootSocio  = $oDOMDocumentSocio->documentElement;

  }


  $oDOMDocument->formatOutput      = true;
  $oDOMDocumentSocio->formatOutput = true;

  $oDados       = $oDOMDocument->getElementsByTagName('habilitacao');
  $oDadosSocios = $oDOMDocumentSocio->getElementsByTagName('habilitacaosocio');

  unset($_POST['nroDocumentoSocio']);
  unset($_POST['nomeSocio']);
  unset($_POST['tipoParticipacao']);

   $aPostSocios = array();
  for ($cont = 0; $cont < $_POST['cont_socios'];$cont++) {

  	$i = $cont;
  	while (!isset($_POST['nroDocumentoSocio'.$i])) {
  		$i++;
  		if ($i == 100) {
  			break;
  		}
  	}
  	 $nroDocumentoSocio = "nroDocumentoSocio$i";
     $nomeSocio         = "nomeSocio$i";
     $tipoParticipacao  = "tipoParticipacao$i";

  	$oPostSocio = new stdClass();
  	$oPostSocio->$nroDocumentoSocio = $_POST['nroDocumentoSocio'.$i];
  	$oPostSocio->$nomeSocio         = $_POST['nomeSocio'.$i];
  	$oPostSocio->$tipoParticipacao  = $_POST['tipoParticipacao'.$i];
  	$aPostSocios[$i] = $oPostSocio;

  	unset($_POST['nroDocumentoSocio'.$i]);
  	unset($_POST['nomeSocio'.$i]);
  	unset($_POST['tipoParticipacao'.$i]);

  }
  unset($_POST['cont_socios']);
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

		  /**
		   * tirando barras e tratando acentos dos inputs para texto
		   */
		  $_POST['nomRazaoSocial'] = str_replace($aCaracteres, "", $_POST['nomRazaoSocial']);
  	  $_POST['nomRazaoSocial'] = trim(utf8_encode($_POST['nomRazaoSocial']));

  	  $_POST['objetoSocial'] = str_replace($aCaracteres, "", $_POST['objetoSocial']);
  	  $_POST['objetoSocial'] = trim(utf8_encode($_POST['objetoSocial']));

  	  $_POST['nomeSocio'] = str_replace($aCaracteres, "", $_POST['nomeSocio']);
  	  $_POST['nomeSocio'] = trim(utf8_encode($_POST['nomeSocio']));

  	  /**
  	   * passar os valores para o objeto para ser salvo no xml
  	   */
		  foreach ($_POST as $coll => $value) {
			  $oDado->setAttribute($coll, $value);
		  }
		  $oDOMDocument->save($sArquivo);
		  if (filesize($sArquivo) > filesize("legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomhabilitacao.xml")/2) {
		    system("cp $sArquivo legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomhabilitacao.xml");
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
  	$oDado  = $oDOMDocument->createElement('habilitacao');
  	$oDado->setAttribute("instituicao", db_getsession("DB_instit"));

  	$aCaracteres = array('\"', "\'");

		/**
		 * tirando barras e tratando acentos dos inputs para texto
		 */
		$_POST['nomRazaoSocial'] = str_replace($aCaracteres, "", $_POST['nomRazaoSocial']);
  	$_POST['nomRazaoSocial'] = trim(utf8_encode($_POST['nomRazaoSocial']));

  	$_POST['objetoSocial'] = str_replace($aCaracteres, "", $_POST['objetoSocial']);
  	$_POST['objetoSocial'] = trim(utf8_encode($_POST['objetoSocial']));

  	$_POST['nomeSocio'] = str_replace($aCaracteres, "", $_POST['nomeSocio']);
  	  $_POST['nomeSocio'] = trim(utf8_encode($_POST['nomeSocio']));

  	/**
  	 * passar os valores para o objeto para ser salvo no xml
  	 */
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
    if (filesize($sArquivo) > filesize("legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomhabilitacao.xml")/2) {
		  system("cp $sArquivo legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomhabilitacao.xml");
		}
		echo"
		<script LANGUAGE=\"Javascript\">
		alert(\"Seu cadastro foi realizado com sucesso.\");
		</SCRIPT>";
  }

  /**
   * caso o codigo já exista no xml dados dos socios, irá atualizar o registro
   */
  $nodeToRemove = array();
  foreach ($oDadosSocios as $oRow) {

		if ($oRow->getAttribute("codHabilitacao") == $iUltimoCodigo
		&& $oRow->getAttribute("instituicao") ==  db_getsession("DB_instit")) {
	    $nodeToRemove[] = $oRow;
    }

  }

  foreach ($nodeToRemove as $oNode) {
  	$oRootSocio->removeChild($oNode);
  }
  if (count($nodeToRemove) > 0) {

    $oDOMDocumentSocio->save($sArquivoSocios);
	  system("cp $sArquivoSocios legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomhabilitacaosocios.xml");

  }

  foreach ($aPostSocios as $iPos => $oSocios) {

  	unset($oDado);
  	$nroDocumentoSocio = "nroDocumentoSocio$iPos";
    $nomeSocio         = "nomeSocio$iPos";
    $tipoParticipacao  = "tipoParticipacao$iPos";

  		$nroDocumentoSocio = "nroDocumentoSocio$iPos";
      $nomeSocio         = "nomeSocio$iPos";
      $tipoParticipacao  = "tipoParticipacao$iPos";

  	  $oDado  = $oDOMDocumentSocio->createElement('habilitacaosocio');
  	  $oDado->setAttribute("instituicao", db_getsession("DB_instit"));

  	  $aCaracteres = array('\"', "\'");

		  /**
		   * tirando barras e tratando acentos dos inputs para texto
		   */
  	  $oSocios->$nomeSocio = str_replace($aCaracteres, "", $oSocios->$nomeSocio);
  	  $oSocios->$nomeSocio = trim(utf8_encode($oSocios->$nomeSocio));

  	  /**
  	   * passar os valores para o objeto para ser salvo no xml
  	   */
			$oDado->setAttribute("codHabilitacao", $iUltimoCodigo);
			$oDado->setAttribute("nroDocumentoSocio", $oSocios->$nroDocumentoSocio);
			$oDado->setAttribute("nomeSocio", $oSocios->$nomeSocio);
			$oDado->setAttribute("tipoParticipacao", $oSocios->$tipoParticipacao);

	  if (!file_exists($sArquivoSocios)) {

	  	$oRootSocio->appendChild($oDado);
	    $oDOMDocumentSocio->appendChild($oRootSocio);

	  } else {
	  	$oDado = $oRootSocio->appendChild($oDado);
	  }
	  $oDOMDocumentSocio->save($sArquivoSocios);
    if (filesize($sArquivoSocios) > filesize("legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomhabilitacaosocios.xml")/2) {
		  system("cp $sArquivoSocios legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomhabilitacaosocios.xml");
		}

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
  $oDados      = $oDOMDocument->getElementsByTagName('habilitacao');

  /**
   * xml de socios
   */
  if (!file_exists($sArquivoSocios)) {
    $oDOMDocumentSocio = new DOMDocument('1.0','ISO-8859-1');
  }else{
  	$oDOMDocumentSocio = new DOMDocument();
  }

 	$sTextoXml    = file_get_contents($sArquivoSocios);
  $oDOMDocumentSocio->loadXML($sTextoXml);
  $oDOMDocumentSocio->formatOutput = true;
	$oDocumentSocio = $oDOMDocumentSocio->documentElement;
  $oDadosSocios   = $oDOMDocumentSocio->getElementsByTagName('habilitacaosocio');

  $nodeToRemove = array();
  foreach ($oDadosSocios as $oRow) {

		if ($oRow->getAttribute("codHabilitacao") == $iUltimoCodigo
		&& $oRow->getAttribute("instituicao") ==  db_getsession("DB_instit")) {
	    $nodeToRemove[] = $oRow;
    }

  }

  foreach ($nodeToRemove as $oNode) {
  	$oDocumentSocio->removeChild($oNode);
  }
  if (count($nodeToRemove) > 0) {

    $oDOMDocumentSocio->save($sArquivoSocios);
	  system("cp $sArquivoSocios legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomhabilitacaosocios.xml");

  }

  /**
   * encontrar o codigo selecionado para excluir o registro no xml
   */
  foreach ($oDados as $oRow) {

		if ($oRow->getAttribute("codigo") == $_POST['codigo']) {

		  $oDocument->removeChild($oRow);
		  $oDOMDocument->save($sArquivo);
		  system("cp $sArquivo legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomhabilitacao.xml");
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
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
</table>
    <center>
	<?
	include("forms/frmsicomhabilitacao.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
