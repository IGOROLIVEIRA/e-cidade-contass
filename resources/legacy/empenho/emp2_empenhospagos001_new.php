<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
db_postmemory($HTTP_POST_VARS);

$clcriaabas     = new cl_criaabas;
$clcriaabas->scrolling="yes";
$abas    = array();
$titulos = array();
$fontes  = array();
$sizecp  = array();

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
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="25%" height="18">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
      <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
       <?
           $anousu = db_getsession("DB_anousu");
           $instit = db_getsession("DB_instit");

           $clcriaabas->identifica = array("principal"=>"Relatório","filtro"=>"Filtro");
           $clcriaabas->src        = array("principal"=>"emp2_empenhospagos001.php","filtro"=>"func_selorcdotacao_aba.php?instit=$instit&desdobramento=true");
           // $clcriaabas->funcao_js  = array("principal"=>"","filtro"=>"");
           $clcriaabas->sizecampo  = array("principal"=>"20","filtro"=>"20");
           $clcriaabas->cria_abas();
        ?>
      </td>
    </tr>
  </table>
  <?
    db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
  ?>
  </body>
  <script>
  </script>
  </html>
