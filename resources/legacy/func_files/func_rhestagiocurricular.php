<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_rhestagiocurricular_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clrhestagiocurricular = new cl_rhestagiocurricular;
$clrotulo = new rotulocampo;
$clrotulo->label("h83_regist");
$clrotulo->label("z01_nome");
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
          <td nowrap title="<?=@$Th83_regist?>">
             <?=@$Lh83_regist?>
          </td>
          <td> 
            <?
            db_input('h83_regist',8,$Ih83_regist,true,'text', 4, "", "chave_h83_regist")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tz01_nome?>">
             <?=@$Lz01_nome?>
          </td>
          <td> 
            <?
            db_input('z01_nome',25,$Iz01_nome,true,'text', 4, "", "chave_z01_nome")
            ?>
          </td>
        </tr>
      </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar" >
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_rhestagiocurricular.hide();">
  </form>
      <?
      if(!isset($pesquisa_chave)){
        $sWhere = '';
        if(!empty($chave_h83_regist)) {
          $sWhere = " and h83_regist = {$chave_h83_regist}";
        }
        if(!empty($chave_z01_nome)) {
          $sWhere .= " and cgm.z01_nome ilike '%{$chave_z01_nome}%'";
        }
        $campos = "h83_sequencial,h83_regist,cgm.z01_nome,h83_cnpjinstensino,h83_curso,h83_dtinicio,h83_dtfim,cgmsupervisor.z01_nome as h83_supervisor";
	         $sql = $clrhestagiocurricular->sql_query(null, $campos, null, "h83_instit = ".db_getsession("DB_instit")." {$sWhere}");
        $repassa = array();
        echo '<div class="container">';
        echo '  <fieldset>';
        echo '    <legend>Resultado da Pesquisa</legend>';
          db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
        echo '  </fieldset>';
        echo '</div>';
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $campos = "rhestagiocurricular.*,h83_matricula,cgm.z01_nome";
          $result = $clrhestagiocurricular->sql_record($clrhestagiocurricular->sql_query($pesquisa_chave, $campos, null, "h83_instit = ".db_getsession("DB_instit")));
          if($clrhestagiocurricular->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$z01_nome',false);</script>";
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
