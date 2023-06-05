<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_homologacaoadjudica_classe.php");
include("classes/db_parecerlicitacao_classe.php");
include("classes/db_precomedio_classe.php");
include("classes/db_liclicita_classe.php");
include("dbforms/db_funcoes.php");
include("classes/db_condataconf_classe.php");
include("classes/db_liclicitasituacao_classe.php");
include("classes/db_licitemobra_classe.php");
db_postmemory($HTTP_POST_VARS);
?>
<html>

<head>
    <title>Contass Contabilidade Ltda - Página Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <?
    db_app::load("scripts.js, strings.js, datagrid.widget.js, windowAux.widget.js,dbautocomplete.widget.js, DBHint.widget.js");
    db_app::load("dbmessageBoard.widget.js, prototype.js, dbtextField.widget.js, dbcomboBox.widget.js,dbtextFieldData.widget.js");
    db_app::load("time.js");
    db_app::load("estilos.css, grid.style.css");
    ?>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
    <center>
        <fieldset style="margin-top: 30px;">
            <legend>Publicacao de Termos</legend>
            <?
            include("forms/db_frmpublicacaodetermospncp.php");
            ?>
        </fieldset>
    </center>
    <?
    db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
    ?>
</body>

</html>