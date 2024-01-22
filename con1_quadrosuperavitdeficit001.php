<?php
require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
require_once "libs/db_sessoes.php";
require_once "libs/db_usuariosonline.php";
require_once "dbforms/db_funcoes.php";
require_once("libs/db_app.utils.php");
require_once("dbforms/db_funcoes.php");
include("classes/db_orctiporec_classe.php");
include("classes/db_quadrosuperavitdeficit_classe.php");

db_postmemory($HTTP_POST_VARS);

if ($incluir) {
    foreach ($aFonte as $fonte) {  
        $sqlerro = false;
        db_inicio_transacao();

        $clquadrosuperavitdeficit = new cl_quadrosuperavitdeficit();

        $clquadrosuperavitdeficit->c241_fonte = $fonte['fonte'];
        $clquadrosuperavitdeficit->c241_valor = $fonte['valor'];
        $clquadrosuperavitdeficit->c241_ano = db_getsession("DB_anousu");
        $clquadrosuperavitdeficit->c241_instit = db_getsession("DB_instit");

        $result = $clquadrosuperavitdeficit->sql_record($clquadrosuperavitdeficit->sql_query(null, "c241_fonte", null, " c241_fonte = {$fonte['fonte']} and c241_ano = " . db_getsession("DB_anousu") . " AND c241_instit = " . db_getsession("DB_instit")));

        if (pg_num_rows($result) == 0) {
            $clquadrosuperavitdeficit->incluir();
        } else {
            $clquadrosuperavitdeficit->alterar(null);
        }

        if ($clquadrosuperavitdeficit->erro_status == 0) {
            $sqlerro = true;
        }
        db_fim_transacao($sqlerro);
    }
}
?>
<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/windowAux.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbautocomplete.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbtextField.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbtextFieldData.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbcomboBox.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/roundDecimal.js"></script>

    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body class="body-default">
    <center>
        <? include("forms/db_frmquadrosuperavitdeficit.php"); ?>
    </center>
    <?php db_menu(); ?>
</body>

</html>