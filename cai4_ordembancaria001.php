<?
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_caiparametro_classe.php");
$clcaiparametro = new cl_caiparametro;
db_postmemory($HTTP_POST_VARS);

if ($incluir) {

	if ($k00_codigo != '') {

		$data_banco = date("Y-m-d");
	  //echo "INSERT INTO ordembancaria VALUES (nextval(ordembancaria_k00_codigo_seq),{$e53_codord},'{$data_banco}')";exit;
	  pg_query("UPDATE ordembancaria SET k00_ctpagadora =  {$k29_contapadraopag},k00_dtpagamento = '{$data_banco}' WHERE k00_codigo = {$k00_codigo}");
	  $rsResult = db_query("SELECT * FROM ordembancaria WHERE k00_codigo = {$k00_codigo}");
	  $oOrdem  = db_utils::fieldsMemory($rsResult, 0);
	  echo"
			<script LANGUAGE=\"Javascript\">
			alert(\"Dados salvos com sucesso.\");
			</SCRIPT>";

	} else {

	  $data_banco = date("Y-m-d");
	  //echo "INSERT INTO ordembancaria VALUES (nextval(ordembancaria_k00_codigo_seq),{$e53_codord},'{$data_banco}')";exit;
	  pg_query("INSERT INTO ordembancaria VALUES (nextval('ordembancaria_k00_codigo_seq'),{$k29_contapadraopag},'{$data_banco}')");
	  $rsResult = db_query("SELECT * FROM ordembancaria ORDER BY k00_codigo DESC LIMIT 1");
	  $oOrdem  = db_utils::fieldsMemory($rsResult, 0);
	  echo"
			<script LANGUAGE=\"Javascript\">
			alert(\"Dados salvos com sucesso.\");
			</SCRIPT>";
	}

	echo "<script>CurrentWindow.corpo.iframe_db_pagamento.location.href='cai4_ordempagamentos001.php?k00_codigo='+".$oOrdem->k00_codigo.";</script>";
	echo "<script>parent.document.formaba.db_pagamento.disabled=false;
	parent.mo_camada('db_pagamento');
  js_db_libera();
	</script>";

}

if ($excluir) {

	if ($k00_codigo == '') {
		echo"
			<script LANGUAGE=\"Javascript\">
			alert(\"Você deve selecionar uma conta salva para exclusão.\");
			</SCRIPT>";
	} else {

		$rsResult = pg_query("SELECT * FROM ordembancariapagamento WHERE k00_codordembancaria = {$k00_codigo}");
		if (pg_num_rows($rsResult) > 0 ){
					echo"
			<script LANGUAGE=\"Javascript\">
			alert(\"Existem Ordens de Pagamento Vinculadas a Esta Ordem Bancária.\");
			</SCRIPT>";
		} else {
			pg_query("DELETE FROM ordembancaria WHERE k00_codigo = {$k00_codigo}");
			unset($k29_contapadraopag);
			unset($desc_conta);
			echo"
			<script LANGUAGE=\"Javascript\">
			alert(\"Exclusão Efetuada Com Sucesso.\");
			js_limpa_campos();
			</SCRIPT>";
		}

	}
}

$rsResult = db_query("SELECT * FROM ordembancaria");
$iTotalLista = (integer)(pg_num_rows($rsResult) / 15);

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
	include("forms/db_frmordembancaria001.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
