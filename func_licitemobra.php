<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_licitemobra_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$cllicitemobra = new cl_licitemobra;
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
          <strong>Material:</strong>
        </td>
        <td>
          <?
          db_input('obr06_pcmater',10,$Iobr06_pcmater,true,'text',1,"","chave_obr06_pcmater");
          ?>
        </td>
      </tr>
      <tr>
        <td>
          <strong>Data de Cadastro</strong>
        </td>
        <td>
          <?
          db_inputdata('obr06_dtregistro',@$obr06_dtregistro_dia,@$obr06_dtregistro_mes,@$obr06_dtregistro_ano,true,'text',$db_opcao,"","chave_obr06_dtregistro")
          ?>
        </td>
      </tr>
    </table>
  </fieldset>
  <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
  <input name="limpar" type="reset" id="limpar" value="Limpar" >
  <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_licitemobra.hide();">
</form>
<?
if(!isset($pesquisa_chave)){
  if(isset($campos)==false){
    if(file_exists("funcoes/db_func_licitemobra.php")==true){
      include("funcoes/db_func_licitemobra.php");
    }else{
      $campos = "licitemobra.oid,licitemobra.*";
    }
  }
//  $sql = $cllicitemobra->sql_query();
  if(isset($chave_obr06_pcmater) && (trim($chave_obr06_pcmater)!="") ){
    $sql = $cllicitemobra->sql_query(null,$campos,null,"obr06_pcmater = $chave_obr06_pcmater");
  }else if(isset($chave_obr06_dtregistro) && (trim($chave_obr06_dtregistro)!="")){
    $sql = $cllicitemobra->sql_query(null,$campos,null,"obr06_dtregistro = '$chave_obr06_dtregistro'");
  }else{
    $sql = $cllicitemobra->sql_query(null,$campos,"obr06_sequencial desc",null);
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
    $result = $cllicitemobra->sql_record($cllicitemobra->sql_query($pesquisa_chave));
    if($cllicitemobra->numrows!=0){
      db_fieldsmemory($result,0);
      echo "<script>".$funcao_js."('$oid',false);</script>";
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
