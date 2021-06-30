<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_relatorios_classe.php");
include("classes/db_db_sysprocedarq_classe.php");
include("dbforms/db_funcoes.php");
require_once("model/relatorios/Relatorio.php");

db_postmemory($HTTP_POST_VARS);
$clrelatorios      = new cl_relatorios;
$cldb_sysprocedarq = new cl_db_sysprocedarq;
$db_opcao = 1;
$db_botao = true;
?>

<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">

  <style>
    #tableLegenda,
    #tableLegenda th,
    #tableLegenda td {
      border: 1px solid black;
    }
  </style>
  <?
  db_app::load("scripts.js, strings.js, datagrid.widget.js, windowAux.widget.js,dbautocomplete.widget.js");
  db_app::load("dbmessageBoard.widget.js, prototype.js, dbtextField.widget.js, dbcomboBox.widget.js");
  db_app::load("estilos.css, grid.style.css");
  ?>
  <script script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=kcd8n7brt444oarrbdfk633ydzmb80qomjucnpdzlhsvfa1y'>
  </script>
  <script type="text/javascript">
    tinymce.init({
      selector: "#rel_corpo",
      setup: function(editor) {
        editor.on('change', function() {
          tinymce.triggerSave();
          chkSubmit();
        });
      }
    });
  </script>
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
  <table width="790" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
        <center>
          <?
          include("forms/db_frmrelatoriosgerador.php");
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
  js_tabulacaoforms("form1", "rel_descricao", true, 1, "rel_descricao", true);
</script>
<?
if (isset($gerar)) {
  if ($clrelatorios->erro_status == "0") {
    $clrelatorios->erro(true, false);
    $db_botao = true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if ($clrelatorios->erro_campo != "") {
      echo "<script> document.form1." . $clrelatorios->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1." . $clrelatorios->erro_campo . ".focus();</script>";
    }
  } else {
    $clrelatorios->erro(true, true);
  }
}

?>
