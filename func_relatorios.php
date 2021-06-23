<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_relatorios_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clrelatorios = new cl_relatorios;
?>
<html>

<head>
  <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
  <link href='estilos.css' rel='stylesheet' type='text/css'>
  <script language='JavaScript' type='text/javascript' src='scripts/scripts.js'></script>
</head>

<body>
  <form name="form2" method="post" action="" class="container">
    <fieldset>
      <legend>Dados para Pesquisa</legend>
      <table width="35%" border="0" align="center" cellspacing="3" class="form-container">
      </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar">
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_relatorios.hide();">
  </form>
  <?
  if (!isset($pesquisa_chave)) {
    if (isset($campos) == false) {
      if (file_exists("funcoes/db_func_relatorios.php") == true) {
        include("funcoes/db_func_relatorios.php");
      } else {
        $campos = "relatorios.oid,relatorios.*";
      }
    }

    if (db_getsession("DB_modulo") == 1)
      $sql = $clrelatorios->sql_query();
    else
      $sql = $clrelatorios->sql_query('', '*', '', "db_modulos.id_item = " . db_getsession("DB_modulo"));

    $repassa = array();
    echo '<div class="container">';
    echo '  <fieldset>';
    echo '    <legend>Resultado da Pesquisa</legend>';
    db_lovrot($sql, 15, "()", "", $funcao_js, "", "NoMe", $repassa);
    echo '  </fieldset>';
    echo '</div>';
  } else {
    if ($pesquisa_chave != null && $pesquisa_chave != "") {

      if (db_getsession("DB_modulo") == 1)
        $sql = $clrelatorios->sql_query($pesquisa_chave);
      else
        $sql = $clrelatorios->sql_query($pesquisa_chave, '*', '', "db_modulos.id_item = " . db_getsession("DB_modulo"));

      $result = $clrelatorios->sql_record($sql);
      if ($clrelatorios->numrows != 0) {
        db_fieldsmemory($result, 0);
        echo "<script>" . $funcao_js . "('$oid',false);</script>";
      } else {
        echo "<script>" . $funcao_js . "('Chave(" . $pesquisa_chave . ") não Encontrado',true);</script>";
      }
    } else {
      echo "<script>" . $funcao_js . "('',false);</script>";
    }
  }
  ?>
</body>

</html>
<?
if (!isset($pesquisa_chave)) {
?>
  <script>
  </script>
<?
}
?>
