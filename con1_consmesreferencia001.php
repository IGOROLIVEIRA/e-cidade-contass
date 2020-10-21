<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_consexecucaoorc_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clconsexecucaoorc = new cl_consexecucaoorc;
$iAnoUsu = db_getsession('DB_anousu');

$sCampos    = "c202_mescompetencia, c202_mesreferenciasicom";
$sWhere     = "c202_consconsorcios = {$c202_consconsorcios} and c202_anousu = {$iAnoUsu} GROUP BY c202_mescompetencia, c202_mesreferenciasicom";
$sOrder     = "c202_mescompetencia";
$sSql       = $clconsexecucaoorc->sql_query_file(null, $sCampos, $sOrder, $sWhere);
$rsResult   = db_query($sSql);
$aMesCompRef = db_utils::getCollectionByRecord($rsResult);

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
<script type="text/javascript" src="scripts/strings.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmconsmesreferencia.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>