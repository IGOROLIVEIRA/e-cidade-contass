<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_avaliacaoS1000_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clavaliacaoS1000 = new cl_avaliacaoS1000();
?>
<html>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
  <link href='estilos.css' rel='stylesheet' type='text/css'>
  <script language='JavaScript' type='text/javascript' src='scripts/scripts.js'></script>
</head>
<style>
  #chave_l20_objeto{
    width: 350px;
  }
</style>
<body>
<form name="form2" method="post" action="" class="container">
  <fieldset>
    <legend>Dados para Pesquisa</legend>
    <table>
      <tr>
        <td>
          <strong>Cod. Sequencial:</strong>
        </td>
        <td>
          <?
          db_input('eso05_sequencial',10,$Ieso05_sequencial,true,'text',1,"","chave_eso05_sequencial");
          ?>
        </td>
      </tr>
    </table>
  </fieldset>
  <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
  <input name="limpar" type="reset" id="limpar" value="Limpar" >
  <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_avaliacaoS1000.hide();">
</form>
<?
if(!isset($pesquisa_chave)){
  if(isset($campos)==false){
    if(file_exists("funcoes/db_func_avaliacaoS1000.php")==true){
      include("funcoes/db_func_avaliacaoS1000.php");
    }else{
      $campos = "";
    }
  }
  $ordem = "eso05_sequencial desc";
  $where = "and eso05_instit = ".db_getsession("DB_instit");
  if($pesquisa == "true"){
    $campos = "*";
      $sql = $clavaliacaoS1000->sql_query($chave_eso05_sequencial,$campos,null,null);
  }else{
      $sql = $clavaliacaoS1000->sql_query($chave_eso05_sequencial,$campos,null,null);
  }
  $repassa = array();
  echo '<div class="container">';
  echo '  <fieldset>';
  echo '    <legend>Resultado da Pesquisa</legend>';
  db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
  echo '  </fieldset>';
  echo '</div>';
}else{
  if($pesquisa_chave!=null && $pesquisa_chave!=""){
    if($pesquisa == "true"){
      $campos = "*";
      $result = $clavaliacaoS1000->sql_record($clavaliacaoS1000->sql_query(null,$campos,null,"eso05_sequencial = $pesquisa_chave"));
    }else{
      $result = $clavaliacaoS1000->sql_record($clavaliacaoS1000->sql_query($pesquisa_chave));
    }
    if($clavaliacaoS1000->numrows!=0){
      db_fieldsmemory($result,0);
      echo "<script>".$funcao_js."('$eso05_sequencial',false);</script>";
    }else{
      echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado','Chave(".$pesquisa_chave.") não Encontrado','Chave(".$pesquisa_chave.") não Encontrado','Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
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
