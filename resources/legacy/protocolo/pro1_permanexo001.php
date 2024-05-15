<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_permanexo_classe.php");
include("dbforms/db_funcoes.php");
include("libs/db_utils.php");
include("libs/db_usuariosonline.php");



db_postmemory($HTTP_POST_VARS);
$clpermanexo = new cl_permanexo;
$db_opcao = 1;
$db_botao = true;

if (isset($incluir)) {
  db_inicio_transacao();
  $perfis   = $HTTP_POST_VARS["aItonsMarcados"];
  if (count($perfis) == 0) {
    echo '<script>alert("Usuário: é necessário selecionar um perfil de acesso para inclusão de uma permissão de anexo")</script>';
  } else {
    $clpermanexo->incluir($perfis);
  }
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

  <style type="text/css">

  </style>

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
<script>
  js_tabulacaoforms("form1", "p202_tipo", true, 1, "p202_tipo", true);
</script>
<?
if (isset($incluir)) {
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
?>