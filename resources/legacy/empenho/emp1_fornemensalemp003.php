<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_fornemensalemp_classe.php");
include("dbforms/db_funcoes.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clfornemensalemp = new cl_fornemensalemp;
$db_botao = false;
$db_opcao = 33;
if (isset($excluir)) {
    db_inicio_transacao();
    $db_opcao = 3;
    $clfornemensalemp->excluir(" fm101_numcgm = {$fm101_numcgm} and fm101_sequencial = $chavepesquisa");
    db_fim_transacao();
} else if (isset($chavepesquisa)) {
    $db_opcao = 3;
    $result = $clfornemensalemp->sql_record($clfornemensalemp->sql_query($chavepesquisa));
    db_fieldsmemory($result, 0);
    $db_botao = true;
}
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="10" topmargin="0" marginwidth="450" marginheight="0" onLoad="a=1">
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
    <tr>
        <td width="360" height="18">&nbsp;</td>
        <td width="263">&nbsp;</td>
        <td width="25">&nbsp;</td>
        <td width="140">&nbsp;</td>
    </tr>
</table>
<table width="590" border="0" cellspacing="10" cellpadding="50">
    <tr>
        <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
            <center>
                <?
                include("forms/db_frmfornemensalemp.php");
                ?>
            </center>
        </td>
    </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
?>
</body>
</html>
<?
if (isset($excluir)) {
    if ($clfornemensalemp->erro_status == "0") {
        $clfornemensalemp->erro(true, false);
    } else {
        $clfornemensalemp->erro(true, true);
    }
}
if($db_opcao==33){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","excluir",true,1,"excluir",true);
</script>
