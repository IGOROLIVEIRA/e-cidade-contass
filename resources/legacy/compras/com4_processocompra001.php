<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
include("classes/db_licitaparam_classe.php");

$oGet = db_utils::postMemory($_GET);

$iAcao = ($oGet->acao ? $oGet->acao : 3);

$oParam = new cl_licitaparam;
$oParam = $oParam->sql_query(null, '*',null,"l12_instit = ".db_getsession("DB_instit"));

$oParam = db_query($oParam);
$oParam = db_utils::fieldsMemory($oParam);
$oParam = $oParam->l12_pncp;

?>
<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/DBAbas.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/windowAux.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbtextField.widget.js?v=1"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/messageboard.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body class="body-default">
  <?php


  if ($oParam == 't') {
    include("forms/db_frmprocessocompraPNCP.php");
  } else {
    include("forms/db_frmprocessocompra.php");
  }
  db_menu(
    db_getsession("DB_id_usuario"),
    db_getsession("DB_modulo"),
    db_getsession("DB_anousu"),
    db_getsession("DB_instit")
  );
  ?>
</body>

</html>
