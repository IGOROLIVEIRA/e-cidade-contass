<?
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");

db_postmemory($HTTP_POST_VARS);
$sSql = "SELECT p.*,c.z01_nome,pc63_contabanco,(pc63_agencia || '-' || pc63_agencia_dig || '/' || pc63_conta || '-' || pc63_conta_dig) AS contafornec,
CASE WHEN k00_codord IS NULL THEN 'SL' ELSE 'OP' END AS tipo,
CASE WHEN k00_codord IS NULL THEN k00_slip ELSE k00_codord END AS codigo,
CASE WHEN k00_formapag IS NULL THEN 'NÃO DEFINIDO' ELSE k00_formapag END AS k00_formapag
FROM ordembancariapagamento p JOIN cgm c ON k00_cgmfornec = z01_numcgm
LEFT JOIN pcfornecon ON k00_cgmfornec = pc63_numcgm and k00_contabanco = pc63_contabanco
WHERE k00_codordembancaria = {$k00_codigo}";
$rsResultTabela = pg_query($sSql);
?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmordembancariapagamento001.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>