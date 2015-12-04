<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_rhelementoemp_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clrhelementoemp = new cl_rhelementoemp;
$clrhelementoemp->rotulo->label("rh38_seq");
$clrhelementoemp->rotulo->label("rh38_codele");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
  <tr> 
    <td height="63" align="center" valign="top">
        <table width="35%" border="0" align="center" cellspacing="0">
	     <form name="form2" method="post" action="" >
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Trh38_seq?>">
              <?=$Lrh38_seq?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("rh38_seq",6,$Irh38_seq,true,"text",4,"","chave_rh38_seq");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Trh38_codele?>">
              <?=$Lrh38_codele?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("rh38_codele",6,$Irh38_codele,true,"text",4,"","chave_rh38_codele");
		       ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_rhelementoemp.hide();">
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
           if(file_exists("funcoes/db_func_rhelementoemp.php")==true){
             include("funcoes/db_func_rhelementoemp.php");
           }else{
           $campos = "rhelementoemp.*";
           }
        }
        if(isset($chave_rh38_seq) && (trim($chave_rh38_seq)!="") ){
	         $sql = $clrhelementoemp->sql_query($chave_rh38_seq,$campos,"rh38_seq");
        }else if(isset($chave_rh38_codele) && (trim($chave_rh38_codele)!="") ){
	         $sql = $clrhelementoemp->sql_query("",$campos,"rh38_codele"," rh38_codele like '$chave_rh38_codele%' ");
        }else{
           $sql = $clrhelementoemp->sql_query("",$campos,"rh38_seq","");
        }
        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clrhelementoemp->sql_record($clrhelementoemp->sql_query($pesquisa_chave));
          if($clrhelementoemp->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$rh38_codele',false);</script>";
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
  </script>
  <?
}
?>
