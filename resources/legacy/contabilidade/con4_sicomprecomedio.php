<?
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
require_once("model/licitacao.model.php");
require_once("model/Dotacao.model.php");
db_postmemory($HTTP_POST_VARS);

$sSql  = "SELECT * FROM db_config ";
$sSql .= "	WHERE prefeitura = 't'";

$rsInst = db_query($sSql);
$sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;
$sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomprecomedio.xml";
$verifica2 = 0;
/*
 * inserir ou atualizar registro do xml
 */
if (isset($_POST['btnSalvar'])) {

	if (!file_exists($sArquivo)) {

    $oDOMDocument = new DOMDocument('1.0','ISO-8859-1');
    $oRoot  = $oDOMDocument->createElement('precosmedios');

  }else{

  	$oDOMDocument = new DOMDocument();
  	$sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument->loadXML($sTextoXml);
    $oRoot  = $oDOMDocument->documentElement;

  }

  $oDOMDocument->formatOutput = true;

  $oDados      = $oDOMDocument->getElementsByTagName('precomedio');
  unset($_POST['btnSalvar']);

  /**
  * passar os valores para o objeto para ser salvo no xml
  */

  $licitacao = $_POST['nroProcessoLicitatorio'];
  $dataDota  = $_POST['dtCotacao'];
  $codigo    = $_POST['codigo'];
  unset($_POST['codigo']);
  unset($_POST['nroProcessoLicitatorio']);
  unset($_POST['dtCotacao']);

  /**
  * passar os valores para o objeto para ser atualizado no xml
  */
  foreach ($_POST as $coll => $value) {
	  $oItem = new stdClass();

	  $oItem->codigoitemprocesso       = $coll;
	  $oItem->vlCotPrecosUnitario      = $value;

	  $aItens[]                        = $oItem;

  }

  foreach ($oDados as $oDado) {

	foreach ($aItens as $oRow2) {

	  if ($oDado->getAttribute('nroProcessoLicitatorio') == $licitacao
	     && ($oDado->getAttribute('codigoitemprocesso') == $oRow2->codigoitemprocesso)
	     && ($oDado->getAttribute('instituicao') == db_getsession("DB_instit"))
	     ) {

	    $verifica2 = 1;

        $oDado->setAttribute("nroProcessoLicitatorio", $licitacao);

  		$oDado->setAttribute("dtCotacao", $dataDota);

  		$oDado->setAttribute('codigoitemprocesso' , $oRow2->codigoitemprocesso);
  		$oDado->setAttribute('vlCotPrecosUnitario' , $oRow2->vlCotPrecosUnitario);



	  }

	}

  }

  if ($verifica2 == 1) {

    $oDado = $oRoot->appendChild($oDado);
    $oDOMDocument->save($sArquivo);

  }

  if ($verifica2 == 0) {

  	unset($_POST['btnSalvar']);

  	  $aItens = array();

	  foreach ($_POST as $coll => $value) {

	  	$oItem = new stdClass();

	  	$oItem->codigoitemprocesso       = $coll;
	    $oItem->vlCotPrecosUnitario      = $value;

	  	$aItens[]                        = $oItem;

	  }

	  foreach ($aItens as $oRow) {

	  	$oDado  = $oDOMDocument->createElement('precomedio');

	  	$iUltimoCodigo++;
		$oDado->setAttribute("codigo", $iUltimoCodigo);

  		$oDado->setAttribute("instituicao", db_getsession("DB_instit"));

  		$oDado->setAttribute("nroProcessoLicitatorio", $licitacao);

  		$oDado->setAttribute("dtCotacao", $dataDota);

  		$oDado->setAttribute('codigoitemprocesso' , $oRow->codigoitemprocesso);
  		$oDado->setAttribute('vlCotPrecosUnitario' , $oRow->vlCotPrecosUnitario);


	    if (!file_exists($sArquivo)) {

	  	  $oRoot->appendChild($oDado);
	      $oDOMDocument->appendChild($oRoot);

	  	} else {

	  	  $oDado = $oRoot->appendChild($oDado);
	    }

	    $oDOMDocument->save($sArquivo);


	  }


  }
	if (filesize($sArquivo) > filesize("legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomprecomedio.xml")/2) {
	  system("cp $sArquivo legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomprecomedio.xml");
	}
  echo"
  <script LANGUAGE=\"Javascript\">
  alert(\"Seu cadastro foi realizado com sucesso.\");
  </SCRIPT>";
  unset($nroProcessoLicitatorio);
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
  $oDados    = $oDOMDocument->getElementsByTagName('precomedio');

  /**
   * encontrar o codigo selecionado para excluir o registro no xml
   */
  $nodeToRemove = null;
  foreach ($oDados as $oRow) {
		if ($oRow->getAttribute("nroProcessoLicitatorio") == $_POST['nroProcessoLicitatorio']) {
		  $nodeToRemove[] = $oRow;
    	}
  }
  foreach ($nodeToRemove as $oRowXml) {
	$oDocument->removeChild($oRowXml);
  }
  $oDOMDocument->save($sArquivo);
  system("cp $sArquivo legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomprecomedio.xml");
	echo"
	<script LANGUAGE=\"Javascript\">
	alert(\"Registro's removido com sucesso.\");
	</SCRIPT>";
}

if (isset($_POST['btnProcessar'])) {

  	/**
  * pegar codigo do orcamento
  */
  $sSql = "select * from liclicitem
  join pcorcamitemlic on pc26_liclicitem = l21_codigo
  join pcorcamitem on pc22_orcamitem = pc26_orcamitem
  where l21_codliclicita = {$nroProcessoLicitatorio} limit 1";

  $rsOrcamento = db_query($sSql);
  $oOrcamento = db_utils::fieldsMemory($rsOrcamento, 0);


  if (file_exists($sArquivo)) {


  $sTextoXml    = file_get_contents($sArquivo);
  $oDOMDocument = new DOMDocument();
  $oDOMDocument->loadXML($sTextoXml);
  $oPrecoMedio  = $oDOMDocument->getElementsByTagName('precomedio');

  /**
  * percorrer os orgaos retornados do xml para selecionar o orgao da inst logada
  * para selecionar os dados da instit
  */

  $aItensXml   = array();
  $aDataItem   = array();
  foreach ($oPrecoMedio as $oPreco) {

    if($oPreco->getAttribute('instituicao') == db_getsession("DB_instit") &&
     $oPreco->getAttribute('nroProcessoLicitatorio') == $_POST['nroProcessoLicitatorio'] ) {

     	$oItenXml   = new stdClass();

     	$oItenXml->codigoitemprocesso    = $oPreco->getAttribute('codigoitemprocesso');
     	$oItenXml->vlCotPrecosUnitario   = $oPreco->getAttribute('vlCotPrecosUnitario');

     	$aDataItem['dtCotacao'] 		 = $oPreco->getAttribute('dtCotacao');

     	$aItensXml[] = $oItenXml;
    }

    }

  }

}

if (isset($_POST['btnNovo'])) {
	unset($nroProcessoLicitatorio);
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
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
    <center>
	<?
	include("forms/frmsicomprecomedio.php");
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
