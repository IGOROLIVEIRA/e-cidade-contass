<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
require_once("classes/db_acocontroletermospncp_classe.php");
db_postmemory($HTTP_POST_VARS);
$clacocontroletermospncp = new cl_acocontroletermospncp();
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
            <strong>Contrato:</strong>
          </td>
          <td>
            <?
            db_input('l214_acordo',10,$Il214_acordo,true,'text',1,"","chave_l214_acordo");
            ?>
          </td>
        </tr>
      </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar" >
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_acocontroletermospncp.hide();">
  </form>
      <?
      if(!isset($pesquisa_chave)){
        $campos = "l214_sequencial,l214_numeroaditamento,ac16_sequencial,ac16_objeto";
        
        $where = "and l214_instit = ".db_getsession("DB_instit");
        
        if(isset($chave_l214_acordo) && (trim($chave_l214_acordo)!="") ){
          $sql = $clacocontroletermospncp->sql_query($chave_l214_acordo,$campos,null,null);
        }else{
          $sql = $clacocontroletermospncp->sql_query(null,$campos,null,"l214_instit = ".db_getsession("DB_instit")."");
        }

        $repassa = array();
        echo '<div class="container">';
        echo '  <fieldset>';
        echo '    <legend>Resultado da Pesquisa</legend>';
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
        echo '  </fieldset>';
        echo '</div>';
      }
      ?>
</body>
</html>