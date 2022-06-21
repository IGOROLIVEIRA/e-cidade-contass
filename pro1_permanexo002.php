<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_permanexo_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clpermanexo = new cl_permanexo;
$db_opcao = 22;
$db_botao = false;
if (isset($alterar)) {
  db_inicio_transacao();
  $db_opcao = 2;
  $perfis   = $HTTP_POST_VARS["aItonsMarcados"];
  $clpermanexo->alterar($p202_sequencial, $perfis);
  db_fim_transacao();
} else if (isset($chavepesquisa)) {
  $db_opcao = 2;
  $result = $clpermanexo->sql_record($clpermanexo->sql_query($chavepesquisa));
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
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
    <tr>
      <td width="360" height="18">&nbsp;</td>
      <td width="263">&nbsp;</td>
      <td width="25">&nbsp;</td>
      <td width="140">&nbsp;</td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="430" align="center" valign="top" bgcolor="#CCCCCC">
        <center>
          <?
          if (db_getsession("DB_administrador") == "1") {
            include("forms/db_frmpermanexo.php");
          } else {
            echo "Acesso restrito para administradores ";
          }
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

$result = db_query("select * from perfispermanexo where p203_permanexo = $p202_sequencial");
$numrows = pg_numrows($result);
for ($i = 0; $i < $numrows; $i++) {
  $perfil = pg_result($result, $i, "p203_perfil");
  echo "<script> document.getElementById('$perfil').checked = true; </script>";
}

if (isset($alterar)) {



  if ($clpermanexo->erro_status == "0") {
    $clpermanexo->erro(true, false);
    $db_botao = true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if ($clpermanexo->erro_campo != "") {
      echo "<script> document.form1." . $clpermanexo->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1." . $clpermanexo->erro_campo . ".focus();</script>";
    }
  } else {
    $clpermanexo->erro(true, true);
  }
}
if ($db_opcao == 22) {
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
  js_tabulacaoforms("form1", "p202_tipo", true, 1, "p202_tipo", true);
</script>