<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_orcleialtorcamentaria_classe.php");
include("classes/db_orcprojetolei_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clorcleialtorcamentaria = new cl_orcleialtorcamentaria;
$clorcprojetolei = new cl_orcprojetolei;
$db_opcao = 22;
$db_botao = false;
if (isset($alterar) || isset($excluir) || isset($incluir)) {
    $sqlerro = false;
}
if (isset($incluir)) {
    $iAltpercsuplementacao = db_utils::fieldsMemory(db_query($clorcprojetolei->sql_query_file($o200_orcprojetolei, "o138_altpercsuplementacao")), 0)->o138_altpercsuplementacao;
    if ($iAltpercsuplementacao == "2" && $o200_vlautorizado == "") {
        $erro_msg = "Campo Valor Autorizado nao Informado";
        $sqlerro = true;

    } elseif ($iAltpercsuplementacao == "1" && ($o200_percautorizado == "" || floatval($o200_percautorizado) <= 0)) {
        $erro_msg = "Campo Percerntual Autorizado nao Informado";
        $sqlerro = true;
    }
    if ($sqlerro == false) {
        db_inicio_transacao();
        $clorcleialtorcamentaria->o200_percautorizado = $o200_percautorizado;
        $clorcleialtorcamentaria->incluir($o200_sequencial);
        $erro_msg = $clorcleialtorcamentaria->erro_msg;
        if ($clorcleialtorcamentaria->erro_status == 0) {
            $sqlerro = true;
        } else {
            echo "<script>CurrentWindow.corpo.iframe_orcprojetolei.form1.suplementacao.disabled = false</script>";
        }
        db_fim_transacao($sqlerro);
    }
} else if (isset($alterar)) {

    $iAltpercsuplementacao = db_utils::fieldsMemory(db_query($clorcprojetolei->sql_query_file($o200_orcprojetolei, "o138_altpercsuplementacao")), 0)->o138_altpercsuplementacao;

    if ($iAltpercsuplementacao == "0" && $o200_vlautorizado == "") {
        $erro_msg = "Campo Valor Autorizado nao Informado";
        $sqlerro = true;

    } elseif ($iAltpercsuplementacao == "1" && ($o200_percautorizado == "" || floatval($o200_percautorizado) <= 0)) {
        $erro_msg = "Campo Percerntual Autorizado precisar ser maior que zero.";
        $sqlerro = true;
    }
    if ($sqlerro == false) {
        db_inicio_transacao();
        $clorcleialtorcamentaria->alterar($o200_sequencial);
        $erro_msg = $clorcleialtorcamentaria->erro_msg;
        if ($clorcleialtorcamentaria->erro_status == 0) {
            $sqlerro = true;
        }
        db_fim_transacao($sqlerro);
    }
} else if (isset($excluir)) {
    if ($sqlerro == false) {
        db_inicio_transacao();
        $clorcleialtorcamentaria->excluir($o200_sequencial);
        $erro_msg = $clorcleialtorcamentaria->erro_msg;
        if ($clorcleialtorcamentaria->erro_status == 0) {
            $sqlerro = true;
        }
        db_fim_transacao($sqlerro);
    }
} else if (isset($opcao)) {
    $result = $clorcleialtorcamentaria->sql_record($clorcleialtorcamentaria->sql_query($o200_sequencial));
    if ($result != false && $clorcleialtorcamentaria->numrows > 0) {
        db_fieldsmemory($result, 0);
    }
}
$result = $clorcprojetolei->sql_record($clorcprojetolei->sql_query(null, "o138_altpercsuplementacao", null, "o138_sequencial = $o200_orcprojetolei"));
db_fieldsmemory($result, 0);
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">

<table width="790" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
            <center>
                <?
                include("forms/db_frmorcleialtorcamentaria.php");
                ?>
            </center>
        </td>
    </tr>
</table>

</body>
</html>
<script>
    js_tabulacaoforms("form1", "o200_orcprojetolei", true, 1, "o200_orcprojetolei", true);
</script>
<?
if (isset($alterar) || isset($excluir) || isset($incluir)) {
    db_msgbox($erro_msg);
    if ($clorcleialtorcamentaria->erro_campo != "") {
        echo "<script> document.form1." . $clorcleialtorcamentaria->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1." . $clorcleialtorcamentaria->erro_campo . ".focus();</script>";
    }
}
?>
