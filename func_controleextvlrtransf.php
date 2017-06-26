<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_controleextvlrtransf_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clcontroleextvlrtransf = new cl_controleextvlrtransf;
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
    <input name="limpar" type="reset" id="limpar" value="Limpar" >
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_controleextvlrtransf.hide();">
  </form>
      <?
      function isValidValor($strValor) {
        return ($strValor != null) && ($strValor != "");
      }

      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           if(file_exists("funcoes/db_func_controleextvlrtransf.php")==true){
             include("funcoes/db_func_controleextvlrtransf.php");
           }else{
           $campos = "controleextvlrtransf.oid,controleextvlrtransf.*";
           }
        }
	         $sql = $clcontroleextvlrtransf->sql_query();
        $repassa = array();
        echo '<div class="container">';
        echo '  <fieldset>';
        echo '    <legend>Resultado da Pesquisa</legend>';
          db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
        echo '  </fieldset>';
        echo '</div>';
      } else {

        if (isValidValor($pesquisa_chave)) {

          if (isset($mes_compet) && isValidValor($mes_compet)) {
            $sSQL = $clcontroleextvlrtransf->sql_query($pesquisa_chave, $mes_compet);
          } else {
            $sSQL = $clcontroleextvlrtransf->sql_query($pesquisa_chave);
          }

          $result = $clcontroleextvlrtransf->sql_record($sSQL);

          if ($clcontroleextvlrtransf->numrows!=0) {
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."({$k168_mescompet}, false);</script>";
          } else {
            echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado', true);</script>";
          }

        } else {
	       echo "<script>".$funcao_js."('',false);</script>";
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
