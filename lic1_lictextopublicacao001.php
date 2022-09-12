<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_lictextopublicacao_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$cllictextopublicacao = new cl_lictextopublicacao;
$db_opcao = 1;
$db_botao = true;
if (isset($incluir)) {
  db_inicio_transacao();
  $cllictextopublicacao->incluir("");
  db_fim_transacao();
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
<script>
  js_tabulacaoforms("form1", "l214_tipo", true, 1, "l214_tipo", true);
</script>
<?
if (isset($incluir)) {
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
?>