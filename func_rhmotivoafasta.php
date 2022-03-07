<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_rhmotivoafasta_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clrhmotivoafasta = new cl_rhmotivoafasta;
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
        <tr>
          <td>
            <strong>Codigo Afastamento:</strong>
          </td>
          <td>
            <?
            db_input('rh172_codigo', 10, $Irh172_codigo, true, 'text', 1, "", "chave_rh172_codigo");
            ?>
          </td>
        </tr>
        <tr>
          <td>
            <strong>Descrição:</strong>
          </td>
          <td>
            <?
            db_input('rh172_descricao', 80, $Irh172_descricao, true, 'text', 1, "", "chave_rh172_descricao");
            ?>
          </td>
        </tr>
      </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar">
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_rhmotivoafasta.hide();">
  </form>
  <?
  if (!isset($pesquisa_chave) && !isset($pesquisa_chave_codigo)) {
    $campos = "*";
    if (isset($chave_rh172_codigo) && (trim($chave_rh172_codigo) != "")) {
      $sql = $clrhmotivoafasta->sql_query(null, $campos, null, "rh172_codigo='$chave_rh172_codigo'");
    } else if (isset($chave_rh172_descricao) && (trim($chave_rh172_descricao) != "")) {
      $sql = $clrhmotivoafasta->sql_query(null, $campos, null, "rh172_descricao like '%$chave_rh172_descricao%'");
    } else {
      $sql = $clrhmotivoafasta->sql_query(null, $campos, null, "");
    }
    $repassa = array();
    echo '<div class="container">';
    echo '  <fieldset>';
    echo '    <legend>Resultado da Pesquisa</legend>';
    db_lovrot($sql, 15, "()", "", $funcao_js, "", "NoMe", $repassa);
    echo '  </fieldset>';
    echo '</div>';
  } else {
    if ($pesquisa_chave != null && $pesquisa_chave != "") {
      $result = $clrhmotivoafasta->sql_record($clrhmotivoafasta->sql_query($pesquisa_chave));
      if ($clrhmotivoafasta->numrows != 0) {
        db_fieldsmemory($result, 0);
        echo "<script>" . $funcao_js . "('$rh172_sequencial',false);</script>";
      } else {
        echo "<script>" . $funcao_js . "('Chave(" . $pesquisa_chave . ") não Encontrado',true);</script>";
      }
    } else if ($pesquisa_chave_codigo != null && $pesquisa_chave_codigo != "") {
      $result = $clrhmotivoafasta->sql_record($clrhmotivoafasta->sql_query(null, "rh172_descricao", null, "rh172_codigo = '{$pesquisa_chave_codigo}'"));
      if ($clrhmotivoafasta->numrows != 0) {
        db_fieldsmemory($result, 0);
        echo "<script>" . $funcao_js . "('$rh172_descricao',false);</script>";
      } else {
        echo "<script>" . $funcao_js . "('Chave(" . $pesquisa_chave_codigo . ") não Encontrado',true);</script>";
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