<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_linhafrequencia_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$cllinhafrequencia = new cl_linhafrequencia;
$cllinhafrequencia->rotulo->label("tre13_sequencial");
$cllinhafrequencia->rotulo->label("tre13_linhatransporte");

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
          <td><label><?=$Ltre13_sequencial?></label></td>
          <td><? db_input("tre13_sequencial",10,$Itre13_sequencial,true,"text",4,"","chave_tre13_sequencial"); ?></td>
        </tr>
        <tr>
          <td><label><?=$Ltre13_linhatransporte?></label></td>
          <td><? db_input("tre13_linhatransporte",10,$Itre13_linhatransporte,true,"text",4,"","chave_tre13_linhatransporte");?></td>
        </tr>
      </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar" >
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_linhafrequencia.hide();">
  </form>
      <?
      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           if(file_exists("funcoes/db_func_linhafrequencia.php")==true){
              include("funcoes/db_func_linhafrequencia.php");
           }else{
              $campos = "linhafrequencia.*";
           }
        }
       if(isset($chave_tre13_sequencial) && (trim($chave_tre13_sequencial)!="") ){
          $sql = $cllinhafrequencia->sql_query_linhas($campos,"tre13_sequencial", "tre13_sequencial = $chave_tre13_sequencial");
       }else if(isset($chave_tre13_linhatransporte) && (trim($chave_tre13_linhatransporte)!="") ){
          $sql = $cllinhafrequencia->sql_query_linhas($campos,"tre13_linhatransporte"," tre13_linhatransporte = $chave_tre13_linhatransporte ");
       }else if(isset($chave_tre13_sequencial) && (trim($chave_tre13_sequencial)!="") ){
          $sql = $cllinhafrequencia->sql_query_linhas($campos,"tre13_sequencial"," tre13_sequencial like '$chave_tre13_sequencial%' ");
       } else {
           $sql = $cllinhafrequencia->sql_query_linhas($campos,"tre13_sequencial","");
       }
       echo '<div class="container">';
       echo '  <fieldset>';
       echo '    <legend>Resultado da Pesquisa</legend>';
       if(isset($sql) && $sql != ''){
           db_lovrot($sql,15,"()","",$funcao_js);
       }
       echo '  </fieldset>';
       echo '</div>';
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $cllinhafrequencia->sql_record($cllinhafrequencia->sql_query($pesquisa_chave));
          if($cllinhafrequencia->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$tre13_sequencial',false);</script>";
          }else{
	         echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
          }
        }else{
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
