<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_licobras_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$cllicobras = new cl_licobras;
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
            db_input('obr01_sequencial',10,$Iobr01_sequencial,true,'text',1,"","chave_obr01_sequencial");
            ?>
          </td>
        </tr>
        <tr>
          <td>
            <strong>Nº da Obra:</strong>
          </td>
          <td>
            <?
            db_input('obr01_numeroobra',10,$Iobr01_numeroobra,true,'text',1,"","chave_obr01_numeroobra");
            ?>
          </td>
        </tr>
        <tr>
          <td>
            <strong>Processo:</strong>
          </td>
          <td>
            <?
            db_input('l20_edital',10,$Il20_edital,true,'text',1,"","chave_l20_edital");
            ?>
          </td>
        </tr>
        <tr>
          <td>
            <strong>Objeto:</strong>
          </td>
          <td>
            <?
            db_input('l20_objeto',10,$Il20_objeto,true,'text',1,"","chave_l20_objeto");
            ?>
          </td>
        </tr>
        <tr>
          <td>
            <strong>Ano:</strong>
          </td>
          <td>
            <?
            db_input('l20_anousu',10,$Il20_anousu,true,'text',1,"","chave_l20_anousu");
            ?>
          </td>
        </tr>
      </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar" >
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_licobras.hide();">
  </form>
      <?
      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           if(file_exists("funcoes/db_func_licobras.php")==true){
             include("funcoes/db_func_licobras.php");
           }else{
           $campos = "";
           }
        }
      $ordem = "obr01_sequencial desc";

      if($pesquisa == "true"){
          $campos = "obr01_sequencial,
                     obr01_licitacaosistema,
                     obr01_licitacao,
                     obr01_linkobra,
                     obr01_numeroobra,
                     l20_edital,
                     l03_descr,
                     l20_numero,
                     l20_objeto";
          if(isset($chave_obr01_sequencial) && (trim($chave_obr01_sequencial)!="") ){
              $sql = $cllicobras->sql_query_pesquisa($chave_obr01_sequencial,$campos,null,null);
          }else if(isset($chave_obr01_numeroobra) && (trim($chave_obr01_numeroobra)!="")){
              $sql = $cllicobras->sql_query_pesquisa(null,$campos,null,"obr01_numeroobra = $chave_obr01_numeroobra");
          }else if(isset($chave_l20_edital) && (trim($chave_l20_edital)!="")){
              $sql = $cllicobras->sql_query_pesquisa(null,$campos,null,"l20_edital = $chave_l20_edital");
          }else if(isset($chave_l20_objeto) && (trim($chave_l20_objeto)!="")){
              $sql = $cllicobras->sql_query_pesquisa(null,$campos,null,"l20_objeto like '%$chave_l20_objeto%'");
          }else if(isset($chave_l20_anousu) && (trim($chave_l20_anousu)!="")){
              $sql = $cllicobras->sql_query_pesquisa(null,$campos,null,"l20_anousu = $chave_l20_anousu");
          }else{
              $sql = $cllicobras->sql_query_pesquisa(null,$campos,$ordem,null);
          }
      }else{
          if(isset($chave_obr01_sequencial) && (trim($chave_obr01_sequencial)!="") ){
              $sql = $cllicobras->sql_query($chave_obr01_sequencial,$campos,null,null);
          }else if(isset($chave_obr01_numeroobra) && (trim($chave_obr01_numeroobra)!="")){
              $sql = $cllicobras->sql_query(null,$campos,null,"obr01_numeroobra = $chave_obr01_numeroobra");
          }else if(isset($chave_l20_edital) && (trim($chave_l20_edital)!="")){
              $sql = $cllicobras->sql_query(null,$campos,null,"l20_edital = $chave_l20_edital");
          }else if(isset($chave_l20_objeto) && (trim($chave_l20_objeto)!="")){
              $sql = $cllicobras->sql_query(null,$campos,null,"l20_objeto like '%$chave_l20_objeto%'");
          }else if(isset($chave_l20_anousu) && (trim($chave_l20_anousu)!="")){
              $sql = $cllicobras->sql_query(null,$campos,null,"l20_anousu = $chave_l20_anousu");
          }else{
              $sql = $cllicobras->sql_query(null,$campos,$ordem,null);
          }
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
                $campos = "obr01_sequencial,
                     obr01_licitacaosistema,
                     obr01_licitacao,
                     obr01_linkobra,    
                     obr01_numeroobra,
                     l20_edital,
                     l03_descr,
                     l20_numero,
                     l20_objeto";
                $result = $cllicobras->sql_record($cllicobras->sql_query_pesquisa(null,$campos,null,"obr01_sequencial = $pesquisa_chave"));
            }else{
                $result = $cllicobras->sql_record($cllicobras->sql_query($pesquisa_chave));
            }
          if($cllicobras->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$l20_edital','$l03_descr','$l20_numero','$obr01_numeroobra',false);</script>";
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
