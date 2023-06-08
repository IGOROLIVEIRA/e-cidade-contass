<?
//ini_set('display_errors','on');
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_empenhosexcluidos_classe.php");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$clempenhosexcluidos = new cl_empenhosexcluidos;
$clempenhosexcluidos->rotulo->label("e290_e60_numemp");
$clempenhosexcluidos->rotulo->label("e290_e60_codemp");
$clempenhosexcluidos->rotulo->label("e290_z01_numcgm");
$clempenhosexcluidos->rotulo->label("e290_z01_nome");

?>
<html>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
  <link href='estilos.css' rel='stylesheet' type='text/css'>
  <script language='JavaScript' type='text/javascript' src='scripts/scripts.js'></script>
</head>
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <form name="form2" method="post" action="" class="container">
    <fieldset>
      <legend>Pesquisa de Empenhos Excluídos</legend>
      <table border="0" class="form-container">
        <tr>
          <td><label for="chave_e290_e60_numemp"> <?= @$Le290_e60_numemp; ?> </label></td>
          <td>
            <?php db_input('e290_e60_numemp', 10, $Ie290_e60_numemp, true, 'text', 4, "", "chave_e290_sequencial");?>
          </td>
        </tr>

        <tr>
          <td><label for="chave_e290_e60_codemp"> <?= @$Le290_e60_codemp; ?> </label></td>
          <td>
            <?php db_input('e290_e60_codemp', 15, $Ie290_e60_codemp, true, 'text', 4, "", "chave_e290_e60_codemp"); ?>
          </td>
        </tr>

        <tr>
          <td><label for="chave_e290_z01_numcgm"> <?= @$Le290_z01_numcgm; ?> </label></td>
          <td>
            <?php db_input('e290_z01_numcgm', 10, $Ie290_z01_numcgm, true, 'text', 4, "", "chave_e290_z01_numcgm"); ?>
          </td>
        </tr>

        <tr>
          <td><label for="chave_e290_z01_nome"> <?= @$Le290_z01_nome; ?> </label></td>
          <td>
            <?php db_input('e290_z01_nome', 40, $Ie290_z01_nome, true, 'text', 4, "", "chave_e290_z01_nome"); ?>
          </td>
        </tr>
      </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar" >
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_empenhosexcluidos.hide();">
  </form>
      <?
      if (!isset($pesquisa_chave)) {
        if (isset($campos)==false) {
           if (file_exists ("funcoes/db_func_empenhosexcluidos.php") == true) {
             include("funcoes/db_func_empenhosexcluidos.php");
           }
        }

        else{
          $campos = "empenhosexcluidos.oid,empenhosexcluidos.*";
        }

        if (isset($chave_e290_sequencial) && !empty($chave_e290_sequencial)) {
          $filtro  = $chave_e290_sequencial;
          $orderby = null;
          $where   = " e290_sequencial = {$chave_e290_sequencial}";

        }

        if (isset($chave_e290_e60_codemp) && !empty($chave_e290_e60_codemp)) {
          $filtro  = $chave_e290_e60_codemp;
          $orderby = null;
          $where   = " e290_e60_codemp = '{$chave_e290_e60_codemp}'";

        }

        if (isset($chave_e290_z01_numcgm) && !empty($chave_e290_z01_numcgm)) {
          $filtro  = $chave_e290_z01_numcgm;
          $orderby = null;
          $where   = " e290_z01_numcgm = '{$chave_e290_z01_numcgm}'";

        }

        if (isset($chave_e290_z01_nome) && !empty($chave_e290_z01_nome)) {
          $filtro  = $chave_e290_z01_nome;
          $orderby = null;
          $where   = " e290_z01_nome ilike '{$chave_e290_z01_nome}%'";

        }

        $sql = $clempenhosexcluidos->sql_query($filtro,'*',$where,$orderby);
        //print_r($sql);
        $repassa = array();
        echo '<div class="container">';
        echo '  <fieldset>';
        echo '    <legend>Resultado da Pesquisa</legend>';
          db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa,false);
        echo '  </fieldset>';
        echo '</div>';
       }

       else {
        if ($pesquisa_chave!=null && $pesquisa_chave!="") {
          $result = $clempenhosexcluidos->sql_record($clempenhosexcluidos->sql_query($pesquisa_chave));
          if ($clempenhosexcluidos->numrows!=0) {
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$oid',false);</script>";
          } else {
             echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
            }
        }

        if (isset($codemp) && !empty($codemp)) {

          $sSQL = $clempenhosexcluidos->sql_query(null, '*', "e290_e60_numemp = {$codemp}", null);

          $result = $clempenhosexcluidos->sql_record($sSQL);

          if ($clempenhosexcluidos->numrows!=0) {
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('{$e290_z01_nome}', '{$e290_e60_anousu}',false);</script>";
          } else {
            echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado', '', true);</script>";
          }

        }

        else {
           echo "<script>".$funcao_js."('',false);</script>";
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
