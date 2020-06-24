<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_licobraslicitacao_classe.php");
include("classes/db_liclicita_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$cllicobraslicitacao = new cl_licobraslicitacao;
$clliclicita = new cl_liclicita();
$cllicobraslicitacao->rotulo->label();
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
              <td nowrap title="<?=@$Tobr07_sequencial?>">
                  <input name="oid" type="hidden" value="<?=@$oid?>">
                  <?=@$Lobr07_sequencial?>
              </td>
              <td>
                  <?
                  db_input('obr07_sequencial',11,$Iobr07_sequencial,true,'text',$db_opcao,"","chave_sequencial")
                  ?>
              </td>
          </tr>
          <tr>
              <td nowrap title="<?=@$Tobr07_processo?>">
                  <?=@$Lobr07_processo?>
              </td>
              <td>
                  <?
                  db_input('obr07_processo',11,$Iobr07_processo,true,'text',$db_opcao,"","chave_processo")
                  ?>
              </td>
          </tr>
          <tr>
              <td nowrap title="<?=@$Tobr07_exercicio?>">
                  <?=@$Lobr07_exercicio?>
              </td>
              <td>
                  <?
                  db_input('obr07_exercicio',11,$Iobr07_exercicio,true,'text',$db_opcao,"","chave_exercicio")
                  ?>
              </td>
          </tr>
      </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar" >
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_licobraslicitacao.hide();">
  </form>
      <?
      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           if(file_exists("funcoes/db_func_licobraslicitacao.php")==true){
             include("funcoes/db_func_licobraslicitacao.php");
           }else{
           $campos = "licobraslicitacao.*,l44_descricao";
           }
        }

          if(isset($chave_sequencial) && (trim($chave_sequencial)!="") ){
              $sql = $cllicobraslicitacao->sql_query($chave_sequencial,$campos,null,null);
          }else if(isset($chave_processo) && (trim($chave_processo)!="")){
              $sql = $cllicobraslicitacao->sql_query(null,$campos,null,"obr07_processo = $chave_processo");
          }else if(isset($chave_exercicio) && (trim($chave_exercicio)!="")){
              $sql = $cllicobraslicitacao->sql_query(null,$campos,null,"obr07_exercicio = $chave_exercicio");
          }else{
              $sql = $cllicobraslicitacao->sql_query(null,$campos,null,null);
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
          if($licitacaosistema == "1"){
              $result = $clliclicita->sql_record($clliclicita->sql_query(null,"l03_descr,l20_objeto,l20_numero",null,"l20_codigo = $pesquisa_chave $and $dbwhere_instit "));

              if($clliclicita->numrows != 0){
                  db_fieldsmemory($result,0);
                  echo "<script>".$funcao_js."('$l03_descr','$l20_objeto,','$l20_numero',false);</script>";
              } else {
                  echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado','Chave(".$pesquisa_chave.") não Encontrado','Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
              }
          }else{
              $result = $cllicobraslicitacao->sql_record($cllicobraslicitacao->sql_query($pesquisa_chave));
              if($cllicobraslicitacao->numrows!=0){
                  db_fieldsmemory($result,0);
                  echo "<script>".$funcao_js."('$l44_descricao','$obr07_objeto','$l20_numero',false);</script>";
              }else{
                  echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
              }
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
