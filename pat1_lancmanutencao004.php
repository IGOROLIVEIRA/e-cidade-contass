<?


require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_bemmanutencao_classe.php");


parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_POST_VARS);


$db_opcao = 1;
$db_botao = true;
$clbemmanutencao = new cl_bemmanutencao;


if (isset($incluir)) {
    db_inicio_transacao();

    $clbemmanutencao->t98_bem = "";
    $clbemmanutencao->t98_data = "";
    $clbemmanutencao->t98_descricao = "";
    $clbemmanutencao->t98_vlrmanut = "";
    $clbemmanutencao->t98_idusuario = db_getsession("DB_id_usuario");
    $clbemmanutencao->t98_dataservidor = "";
    $clbemmanutencao->t98_horaservidor = "";

    $clbemmanutencao->incluir();

    if ($clbemmanutencao->erro_status == "0") {
        db_fim_transacao(true);
    } else {
        db_fim_transacao(false);
    }
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
    if ($clbemmanutencao->erro_status == "0") {
        $clbemmanutencao->erro(true, false);
        $db_botao = true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if ($clbemmanutencao->erro_campo != "") {
            echo "<script> document.form1." . $clbemmanutencao->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1." . $clbemmanutencao->erro_campo . ".focus();</script>";
        }
    } else {
        $clpermanexo->erro(true, true);
    }
}
?>