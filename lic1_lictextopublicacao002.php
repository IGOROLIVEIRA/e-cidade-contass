<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_lictextopublicacao_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$cllictextopublicacao = new cl_lictextopublicacao;
$db_opcao = 22;
$db_botao = false;
if (isset($alterar)) {
  db_inicio_transacao();
  $db_opcao = 2;
  $cllictextopublicacao->alterar();
  db_fim_transacao();
} else if (isset($chavepesquisa)) {
  $db_opcao = 2;
  $result = $cllictextopublicacao->sql_record($cllictextopublicacao->sql_query(null, "lictextopublicacao.*", null, "l214_sequencial = $chavepesquisa"));
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

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
  <table style="margin-top: 30px;" border="0" align="center" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#CCCCCC">
        <center>
          <?
          include("forms/db_frmlictextopublicacao.php");
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
if (isset($alterar)) {
  if ($cllictextopublicacao->erro_status == "0") {
    $cllictextopublicacao->erro(true, false);
    $db_botao = true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>   ";
    if ($cllictextopublicacao->erro_campo != "") {
      echo "<script> document.form1." . $cllictextopublicacao->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1." . $cllictextopublicacao->erro_campo . ".focus();</script>";
    }
  } else {
    $cllictextopublicacao->erro(true, true);
  }
}
if ($db_opcao == 22) {
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
  js_tabulacaoforms("form1", "l214_tipo", true, 1, "l214_tipo", true);
</script>