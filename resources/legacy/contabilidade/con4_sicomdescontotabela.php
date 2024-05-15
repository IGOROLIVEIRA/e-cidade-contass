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
$sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomdescontotabela.xml";
$verifica2 = 0;
/*
 * inserir ou atualizar registro do xml
 */
if (isset($_POST['btnSalvar'])) {

	if (!file_exists($sArquivo)) {

    $oDOMDocument = new DOMDocument('1.0','ISO-8859-1');
    $oRoot  = $oDOMDocument->createElement('descontotabelas');

  }else{

  	$oDOMDocument = new DOMDocument();
  	$sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument->loadXML($sTextoXml);
    $oRoot  = $oDOMDocument->documentElement;

  }

  $oDOMDocument->formatOutput = true;

  $oDados      = $oDOMDocument->getElementsByTagName('descontotabela');
  unset($_POST['btnSalvar']);

  /**
  * passar os valores para o objeto para ser salvo no xml
  */

  $licitacao  = $_POST['nroProcessoLicitatorio'];
  $fornecedor = $_POST['fornecedor'];
  $codigo     = $_POST['codigo'];
  unset($_POST['codigo']);
  unset($_POST['nroProcessoLicitatorio']);
  unset($_POST['fornecedor']);

  /**
  * passar os valores para o objeto para ser atualizado no xml
  */
  foreach ($_POST as $coll => $value) {
	  $oItem = new stdClass();

	  $oItem->pc01_codmater   = $coll;
	  $oItem->vldesconto      = $value;

	  $aItens[]                        = $oItem;

  }

  foreach ($oDados as $oDado) {

	foreach ($aItens as $oRow2) {

	  if ($oDado->getAttribute('nroProcessoLicitatorio') == $licitacao
	     && ($oDado->getAttribute('pc01_codmater') == $oRow2->pc01_codmater)
	     && $oDado->getAttribute('fornecedor') == $fornecedor
	     && ($oDado->getAttribute('instituicao') == db_getsession("DB_instit"))
	     ) {

	    $verifica2 = 1;

      $oDado->setAttribute("nroProcessoLicitatorio", $licitacao);

  		$oDado->setAttribute("fornecedor", $fornecedor);

  		$oDado->setAttribute('pc01_codmater' , $oRow2->pc01_codmater);
  		$oDado->setAttribute('vldesconto' , $oRow2->vldesconto);



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

	  	$oItem->pc01_codmater   = $coll;
	    $oItem->vldesconto      = $value;

	  	$aItens[]               = $oItem;

	  }

	  foreach ($aItens as $oRow) {

	  	$oDado  = $oDOMDocument->createElement('descontotabela');

	  	$iUltimoCodigo++;
		  $oDado->setAttribute("codigo", $iUltimoCodigo);

  		$oDado->setAttribute("instituicao", db_getsession("DB_instit"));

  		$oDado->setAttribute("nroProcessoLicitatorio", $licitacao);

  		$oDado->setAttribute("fornecedor", $fornecedor);

  		$oDado->setAttribute('pc01_codmater' , $oRow->pc01_codmater);
  		$oDado->setAttribute('vldesconto' , $oRow->vldesconto);


	    if (!file_exists($sArquivo)) {

	  	  $oRoot->appendChild($oDado);
	      $oDOMDocument->appendChild($oRoot);

	  	} else {

	  	  $oDado = $oRoot->appendChild($oDado);
	    }

	    $oDOMDocument->save($sArquivo);


	  }


  }
	if (filesize($sArquivo) > filesize("legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomdescontotabela.xml")/2) {
	  system("cp $sArquivo legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomdescontotabela.xml");
	}
  echo"
  <script LANGUAGE=\"Javascript\">
  alert(\"Seu cadastro foi realizado com sucesso.\");
  </SCRIPT>";
  $processar = 1;
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
  $oDados      = $oDOMDocument->getElementsByTagName('descontotabela');

  /**
   * encontrar o codigo selecionado para excluir o registro no xml
   */
  $sVerificaExclusao = 0;
  $iContXml = 0;
  while ($sVerificaExclusao == 0) {

    $iContXml = 0;
    foreach ($oDados as $oRow) {
    	$iContXml++;
      if ($iContXml > 1) {
  	    break;
  	  }
    }
    foreach ($oDados as $oRow) {


		  if (($oRow->getAttribute("nroProcessoLicitatorio") == $_POST['nroProcessoLicitatorio'])
		      && ($oRow->getAttribute("fornecedor") == $_POST['fornecedor'])
		      && ($oRow->getAttribute('instituicao') == db_getsession("DB_instit"))) {

			  $oDocument->removeChild($oRow);
			  $sVerificaExclusao = 0;
			  break;

      }
      $sVerificaExclusao = 1;

    }
    if ($iContXml < 2) {
  	  break;
  	}

  }
  $oDOMDocument->save($sArquivo);
  system("cp $sArquivo legacy_config/sicom/".db_getsession("DB_anousu")."/backup_{$sCnpj}_sicomdescontotabela.xml");
  echo"
			<script LANGUAGE=\"Javascript\">
			alert(\"Registro removido com sucesso.\");
			</SCRIPT>";
  $processar = 1;
}

if (isset($_POST['btnProcessar']) || $processar == 1) {

	/**
 * pegar codigo do orcamento
 */
$sSql = "select * from liclicitem
join pcorcamitemlic on pc26_liclicitem = l21_codigo
join pcorcamitem on pc22_orcamitem = pc26_orcamitem
where l21_codliclicita = {$nroProcessoLicitatorio} limit 1";

$rsOrcamento = db_query($sSql);
$oOrcamento = db_utils::fieldsMemory($rsOrcamento, 0);

/**
 * pegar fornecedores
 */
$sSql = "select z01_numcgm,z01_nome from pcorcamforne join cgm on pc21_numcgm = z01_numcgm where pc21_codorc = {$oOrcamento->pc22_codorc}";

$rsFornecedores = db_query($sSql);
$oForcenedor = db_utils::fieldsMemory($rsFornecedores, 0);

  if (file_exists($sArquivo)) {


  $sTextoXml    = file_get_contents($sArquivo);
  $oDOMDocument = new DOMDocument();
  $oDOMDocument->loadXML($sTextoXml);
  $oDescontoTabela  = $oDOMDocument->getElementsByTagName('descontotabela');

  $aItensXml   = array();
  foreach ($oDescontoTabela as $oDesconto) {

    if($oDesconto->getAttribute('instituicao') == db_getsession("DB_instit") &&
     $oDesconto->getAttribute('nroProcessoLicitatorio') == $nroProcessoLicitatorio
     && $oDesconto->getAttribute('fornecedor') == $oForcenedor->z01_numcgm) {

     	$oItenXml   = new stdClass();

     	$oItenXml->pc01_codmater    = $oDesconto->getAttribute('pc01_codmater');
     	$oItenXml->vldesconto   = $oDesconto->getAttribute('vldesconto');

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
	include("forms/frmsicomdescontotabela.php");
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
