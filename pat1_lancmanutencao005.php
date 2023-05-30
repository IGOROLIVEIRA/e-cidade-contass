<?

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_manutbensitem_classe.php");
include("classes/db_bensdispensatombamento_classe.php");

db_postmemory($HTTP_POST_VARS);

$db_opcao = 1;
$db_botao = true;
$cl_manutbensitem = new cl_manutbensitem;
$cl_bensdispensatombamento = new cl_bensdispensatombamento;

if (isset($inserir)) {

    if ($t99_itemsistema == 1) {
        $t99_codpcmater = $cl_bensdispensatombamento->get_codpcmater($t99_codbensdispensatombamento);
    }

    $cl_manutbensitem->t99_itemsistema = $t99_itemsistema;
    $cl_manutbensitem->t99_valor = $t99_valor;
    $cl_manutbensitem->t99_descricao = $t99_descricao;
    $cl_manutbensitem->t99_codbemmanutencao = $t98_sequencial;
    $cl_manutbensitem->t99_codpcmater = $t99_codpcmater;
    $cl_manutbensitem->t99_codbensdispensatombamento = $t99_codbensdispensatombamento;
    $cl_manutbensitem->incluir();
}

if (isset($alterar)) {

    if ($t99_itemsistema == 1) {
        $t99_codpcmater = $cl_bensdispensatombamento->get_codpcmater($t99_codbensdispensatombamento);
    }

    $cl_manutbensitem->t99_sequencial = $t99_sequencial;
    $cl_manutbensitem->t99_valor = $t99_valor;
    $cl_manutbensitem->t99_codbensdispensatombamento = $t99_codbensdispensatombamento;
    $cl_manutbensitem->alterar($t99_sequencial);
}

if (isset($excluir)) {
    $cl_manutbensitem->excluir($t99_sequencial);
}

?>
<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>

    <?php
    db_app::load("scripts.js, prototype.js, datagrid.widget.js,windowAux.widget.js,messageboard.widget.js, strings.js, AjaxRequest.js,widgets/dbautocomplete.widget.js");
    db_app::load("estilos.css, grid.style.css");
    ?>

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC>

    <?
    include("forms/db_frmcomponentesmanutencao.php");
    ?>

</body>

</html>

<?
if (isset($inserir)) {
    if ($cl_manutbensitem->erro_status == "0") {
        $cl_manutbensitem->erro(true, false);
        $db_botao = true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if ($cl_manutbensitem->erro_campo != "") {
            echo "<script> document.form1." . $cl_manutbensitem->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1." . $cl_manutbensitem->erro_campo . ".focus();</script>";
        }
    } else {
        db_msgbox($cl_manutbensitem->erro_msg);
        db_redireciona("pat1_lancmanutencao005.php?t98_sequencial='$t98_sequencial;");
    }
}
if (isset($alterar) || isset($excluir)) {
    if ($cl_manutbensitem->erro_status == "0") {
        $cl_manutbensitem->erro(true, false);
        $db_botao = true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if ($cl_manutbensitem->erro_campo != "") {
            echo "<script> document.form1." . $cl_manutbensitem->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1." . $cl_manutbensitem->erro_campo . ".focus();</script>";
        }
    } else {
        db_msgbox($cl_manutbensitem->erro_msg);
        db_redireciona("pat1_lancmanutencao005.php?t98_sequencial='$t98_sequencial;");
    }
}
?>