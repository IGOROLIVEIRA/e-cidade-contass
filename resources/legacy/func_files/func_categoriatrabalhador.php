<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_categoriatrabalhador_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clcategoriatrabalhador = new cl_categoriatrabalhador;

$clcategoriatrabalhador->rotulo->label("ct01_codcategoria");
$clcategoriatrabalhador->rotulo->label("ct01_descricaocategoria");

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
              <td width="4%" align="right" nowrap title="<?= $Tct01_codcategorial ?>">
              <?= @$Lct01_codcategoria ?>    
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("ct01_codcategoria", 10, $Ict01_codcategoria, true, "text", 4, "", "chave_ct01_codcategoria");
                ?>
              </td>
            </tr>
            <tr>
              <td width="4%" align="right" nowrap title="<?= $Tct01_descricaocategoria ?>">
              <?= @$Lct01_descricaocategoria ?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("ct01_descricaocategoria", 30, $Ict01_descricaocategoria, true, "text", 4, "", "chave_ct01_descricaocategoria");
                ?>
              </td>
            </tr>
      </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar" >
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_categoriatrabalhador.hide();">
  </form>
      <?
      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           if(file_exists("funcoes/db_func_categoriatrabalhador.php")==true){
             include("funcoes/db_func_categoriatrabalhador.php");
           }else{
           $campos = "categoriatrabalhador.*";
           }
        }
        if (isset($chave_ct01_codcategoria) && (trim($chave_ct01_codcategoria) != "")) {
          $sql = $clcategoriatrabalhador->sql_query("",$campos,"", "ct01_codcategoria like '$chave_ct01_codcategoria%'");
        } else if (isset($chave_ct01_descricaocategoria) && (trim($chave_ct01_descricaocategoria) != "")) {
          $sql = $clcategoriatrabalhador->sql_query("", $campos, "ct01_descricaocategoria", " ct01_descricaocategoria like '$chave_ct01_descricaocategoria%' ");
        } else if (isset($chave_ct01_codcategoria) && (isset($chave_ct01_descricaocategoria)) && (trim($chave_ct01_codcategoria) != "") && (trim($chave_ct01_descricaocategoria) != "")) {
          $sql = $clcategoriatrabalhador->sql_query("", $campos, "ct01_descricaocategoria", " ct01_codcategoria like '$chave_ct01_codcategoria% and ct01_descricaocategoria like '$chave_ct01_descricaocategoria%' ");
        }
         else {
          $sql = $clcategoriatrabalhador->sql_query("", $campos, "ct01_codcategoria", "");
        } 
        $repassa = array();
        if (isset($chave_ct01_descricaocategoria)) {
          $repassa = array("chave_ct01_codcategoria" => $chave_ct01_codcategoria, "chave_ct01_descricaocategoria" => $chave_ct01_descricaocategoria);
        }
        echo '<div class="container">';
        echo '  <fieldset>';
        echo '    <legend>Resultado da Pesquisa</legend>';
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
        echo '  </fieldset>';
        echo '</div>';
      }else{ 
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clcategoriatrabalhador->sql_record($clcategoriatrabalhador->sql_query($pesquisa_chave,"*"));
         
          if($clcategoriatrabalhador->numrows!=0){
           
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$ct01_codcategoria','$ct01_descricaocategoria',false);</script>";
          }else{
            echo "<script>".$funcao_js."(true,'Código (".$pesquisa_chave.") não Encontrado');</script>";
           }
        }else{
	        if ($pesquisa_chave != null && $pesquisa_chave != "") {
            $result = $clcategoriatrabalhador->sql_record($clcategoriatrabalhador->sql_query($pesquisa_chave));
            if ($clcategoriatrabalhador->numrows != 0) {
              db_fieldsmemory($result, 0);
              echo "<script>" . $funcao_js . "('$ct01_codcategoria','$ct01_descricaocategoria',false);</script>";
            } else {
              echo "<script>".$funcao_js."(true,'Código (".$pesquisa_chave.") não Encontrado');</script>";
            }
          } else {
            echo "<script>" . $funcao_js . "('',false);</script>";
          }
        }
      }
      ?>
</body>
</html>
<?
if(!isset($pesquisa_chave)){
  ?>
  <script>
  </script>
  <?
}
?>
