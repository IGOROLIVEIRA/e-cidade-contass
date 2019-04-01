<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
$clcriaabas     = new cl_criaabas;
$db_opcao = 1;
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="790" height="18"  border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table valign="top" marginwidth="0" width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
     <?php
	     $clcriaabas->identifica = array("convconvenios"=>"Convênios","convdetalhaconcedentes"=>"Detalhamento dos concedentes","convdetalhatermos"=>"Termos Aditivos dos Convênios");
       $clcriaabas->src = array("convconvenios"=>"con1_convconvenios005.php","convdetalhaconcedentes"=>"con1_convdetalhaconcedentes001.php", "convdetalhatermos"=>"con1_convdetalhatermos001.php");
	     $clcriaabas->disabled   =  array("convdetalhaconcedentes"=>"true","convdetalhatermos"=>"true");
	     $clcriaabas->cria_abas();
     ?>
    </td>
  </tr>
</table>
<form name="form1">
</form>
<?php
	db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
  document.formaba.convconvenios.size          = 10;
  document.formaba.convdetalhaconcedentes.size = 25;
  document.formaba.convdetalhatermos.size      = 25;
</script>
