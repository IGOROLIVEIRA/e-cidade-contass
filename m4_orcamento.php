<?php
require 'libs/db_stdlib.php';
require 'libs/db_conecta.php';
include 'libs/db_sessoes.php';
include 'libs/db_usuariosonline.php';
include 'dbforms/db_funcoes.php';
?>
<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?php
    db_app::load('scripts.js,estilos.css,grid.style.css,datagrid.widget.js,prototype.js');
    ?>
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<style>
</style>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
        <tr>
            <td bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
        <tr>
            <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
                <?php
                  include 'forms/db_frmmanutencaoorcamento.php';
                ?>
            </td>
        </tr>
    </table>
    <?php
  db_menu(db_getsession('DB_id_usuario'), db_getsession('DB_modulo'), db_getsession('DB_anousu'), db_getsession('DB_instit'));
  ?>
</body>

</html>
