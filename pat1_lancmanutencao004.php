<?


require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_POST_VARS);


$db_opcao = 1;
$db_botao = true;



if (isset($incluir)) {
    $sqlerro = false;
    db_inicio_transacao();

    db_fim_transacao($sqlerro);
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

<body bgcolor=#CCCCCC>

    <?
    include("forms/db_frmlancmanutencao.php");
    ?>

</body>

</html>
<?
if (isset($incluir)) {
    db_msgbox($erro_msg);
    if ($sqlerro == true) {
        if ($clbenstransf->erro_campo != "") {
            echo "<script> document.form1." . $clbenstransf->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1." . $clbenstransf->erro_campo . ".focus();</script>";
        };
    } else {
        db_redireciona("pat1_benstransf005.php?liberaaba=true&chavepesquisa=$t93_codtran&t93_depart=$t93_depart&db_param=$db_param&transfdireta=$transfdireta");
    }
}
?>