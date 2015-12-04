<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_situacao_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clsituacao = new cl_situacao;
$clsituacao->rotulo->label("v52_codsit");
$clsituacao->rotulo->label("v52_descr");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
  <tr> 
    <td height="63" align="center" valign="top">
        <table width="35%" border="0" align="center" cellspacing="0">
	     <form name="form2" method="post" action="" >
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tv52_codsit?>">
              <?=$Lv52_codsit?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("v52_codsit",6,$Iv52_codsit,true,"text",4,"","chave_v52_codsit");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tv52_descr?>">
              <?=$Lv52_descr?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("v52_descr",15,$Iv52_descr,true,"text",4,"","chave_v52_descr");
		       ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr> 
    <td align="center" valign="top"> 
      <?
      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           $campos = "situacao.*";
        }
        if(isset($chave_v52_codsit) && (trim($chave_v52_codsit)!="") ){
	         $sql = $clsituacao->sql_query($chave_v52_codsit,$campos,"v52_codsit");
        }else if(isset($chave_v52_descr) && (trim($chave_v52_descr)!="") ){
	         $sql = $clsituacao->sql_query("",$campos,"v52_descr"," v52_descr like '$chave_v52_descr%' ");
        }else{
           $sql = $clsituacao->sql_query("",$campos,"v52_codsit","");
        }
        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clsituacao->sql_record($clsituacao->sql_query($pesquisa_chave));
          if($clsituacao->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$v52_descr',false);</script>";
          }else{
	         echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
          }
        }else{
	       echo "<script>".$funcao_js."('',false);</script>";
        }
      }
      ?>
     </td>
   </tr>
</table>
</body>
</html>
<?
if(!isset($pesquisa_chave)){
  ?>
  <script>
document.form2.chave_v52_codsit.focus();
document.form2.chave_v52_codsit.select();
  </script>
  <?
}
?>
