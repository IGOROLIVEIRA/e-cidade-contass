<?


require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_bemmanutencao_classe.php");

db_postmemory($HTTP_POST_VARS);

$clbemmanutencao = new cl_bemmanutencao;

if (isset($processar)) {
    $pesquisa_manutencoes = null;
    $clbemmanutencao->t98_bem = $t52_bem;
    $clbemmanutencao->t98_vlrmanut = $t98_vlrmanut;
    $clbemmanutencao->t98_tipo = $t98_tipo;
    $clbemmanutencao->t98_data = implode('-', array_reverse(explode('/', $t98_data)));
    $clbemmanutencao->processar($t98_sequencial);
}

if (isset($desprocessar)) {
    $pesquisa_manutencoes = null;
    $clbemmanutencao->t98_bem = $t52_bem;
    $clbemmanutencao->desprocessar($t98_sequencial);
}


if (isset($incluir)) {
    $clbemmanutencao->t98_bem = $t52_bem;
    $clbemmanutencao->t98_data = implode('-', array_reverse(explode('/', $t98_data)));
    $clbemmanutencao->t98_descricao = $t98_descricao;
    $clbemmanutencao->t98_vlrmanut = $t98_vlrmanut;
    $clbemmanutencao->t98_idusuario = db_getsession("DB_id_usuario");
    $clbemmanutencao->t98_dataservidor = date("Y-m-d", db_getsession("DB_datausu"));
    $clbemmanutencao->t98_horaservidor = date("H:i:s");
    $clbemmanutencao->t98_tipo = $t98_tipo;
    $clbemmanutencao->incluir();
    if ($clbemmanutencao->erro_status == "1") {
        $ocultapesquisa = false;
        $db_opcao = 2;
    }
}

if (isset($salvar)) {
    $db_opcao = 2;
    $pesquisa_manutencoes = null;
    $clbemmanutencao->alterar($t98_sequencial);
}

if (isset($excluir)) {
    $clbemmanutencao->excluir($t98_sequencial);
    if ($clbemmanutencao->erro_status == "1")  $db_opcao = 1;
}

?>
<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>

    <?php
    db_app::load("scripts.js, strings.js, prototype.js,datagrid.widget.js, widgets/dbautocomplete.widget.js");
    db_app::load("widgets/windowAux.widget.js");
    ?>

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

<script>
    //parent.document.formaba.componentes.disabled = false;
    //top.corpo.iframe_componentes.location.href = 'pat1_lancmanutencao005';
    //parent.mo_camada('componentes');
</script>

<?
if (isset($incluir)) {
    if ($clbemmanutencao->erro_status == "0") {
        $clbemmanutencao->erro(true, false);
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if ($clbemmanutencao->erro_campo != "") {
            echo "<script> document.form1." . $clbemmanutencao->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1." . $clbemmanutencao->erro_campo . ".focus();</script>";
        }
    } else {
        db_msgbox($clbemmanutencao->erro_msg);
        echo
        "<script> document.form1.t98_sequencial.value = $clbemmanutencao->t98_sequencial;
        parent.document.formaba.componentes.disabled = false;
        top.corpo.iframe_componentes.location.href = 'pat1_lancmanutencao005.php?t98_sequencial=' + $clbemmanutencao->t98_sequencial;
         </script>";
    }
}
if (isset($salvar) || isset($excluir) || isset($processar) || isset($desprocessar)) {
    if ($clbemmanutencao->erro_status == "0") {
        $clbemmanutencao->erro(true, false);
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if ($clbemmanutencao->erro_campo != "") {
            echo "<script> document.form1." . $clbemmanutencao->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1." . $clbemmanutencao->erro_campo . ".focus();</script>";
        }
    } else {
        db_msgbox($clbemmanutencao->erro_msg);
    }
}
?>