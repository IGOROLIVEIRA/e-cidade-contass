<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_rhmotivorescisao_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clrhmotivorescisao = new cl_rhmotivorescisao;
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
            <strong>Codigo Rescisão:</strong>
          </td>
          <td>
            <?php
            db_input('rh173_codigo', 10, $Irh173_codigo, true, 'text', 1, "", "chave_rh173_codigo");
            ?>
          </td>
        </tr>
        <tr>
          <td>
            <strong>Descrição:</strong>
          </td>
          <td>
            <?php
            db_input('rh173_descricao', 80, $Irh173_descricao, true, 'text', 1, "", "chave_rh173_descricao");
            ?>
          </td>
        </tr>
      </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar">
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_rhmotivorescisao.hide();">
  </form>
  <?php
  if (!isset($pesquisa_chave) && !isset($pesquisa_chave_codigo)) {
      $campos = "*";
      if (isset($chave_rh173_codigo) && (trim($chave_rh173_codigo) != "")) {
          $sql = $clrhmotivorescisao->sql_query(null, $campos, null, "rh173_codigo='$chave_rh173_codigo'");
      } elseif (isset($chave_rh173_descricao) && (trim($chave_rh173_descricao) != "")) {
          $sql = $clrhmotivorescisao->sql_query(null, $campos, null, "rh173_descricao like '%$chave_rh173_descricao%'");
      } else {
          $sql = $clrhmotivorescisao->sql_query(null, $campos, null, "");
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
          $result = $clrhmotivorescisao->sql_record($clrhmotivorescisao->sql_query($pesquisa_chave));
          if ($clrhmotivorescisao->numrows != 0) {
              db_fieldsmemory($result, 0);
              echo "<script>" . $funcao_js . "('$rh173_sequencial',false);</script>";
          } else {
              echo "<script>" . $funcao_js . "('Chave(" . $pesquisa_chave . ") não Encontrado',true);</script>";
          }
      } elseif ($pesquisa_chave_codigo != null && $pesquisa_chave_codigo != "") {
          $result = $clrhmotivorescisao->sql_record($clrhmotivorescisao->sql_query(null, "rh173_descricao", null, "rh173_codigo = '{$pesquisa_chave_codigo}'"));

          if ($clrhmotivorescisao->numrows != 0) {
              db_fieldsmemory($result, 0);
              echo "<script>" . $funcao_js . "('$rh173_descricao',false);</script>";
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
<?php
if (!isset($pesquisa_chave)) {
      ?>
  <script>
  </script>
<?php
  }
?>
