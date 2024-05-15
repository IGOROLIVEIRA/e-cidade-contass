<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_conlancam_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clconlancam = new cl_conlancam;
$clconlancam->rotulo->label("c70_codlan");
$clconlancam->rotulo->label("c70_anousu");
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
    <td align="center" valign="top"> 
      <?

      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           
           $campos = "conlancam.c70_codlan, conlancam.c70_data, conlancam.c70_valor, conlancam.c70_anousu as db_c70_anousu,c53_coddoc,c53_descr";
           
        }
        if(isset($chave_c70_codlan) && (trim($chave_c70_codlan)!="") ){
           $sql = $clconlancam->sql_query_trans($chave_c70_codlan,$campos,"c70_codlan","c70_anousu = ".db_getsession("DB_anousu"));
        }else if(isset($chave_c70_anousu) && (trim($chave_c70_anousu)!="") ){
           $sql = $clconlancam->sql_query_trans("",$campos,"c70_anousu","c70_anousu = ".db_getsession("DB_anousu"));
        }else{
           $sql = $clconlancam->sql_query_trans("",$campos,"c70_codlan","c70_anousu = ".db_getsession("DB_anousu"));
        }
        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clconlancam->sql_record($clconlancam->sql_query_trans($pesquisa_chave));
          if($clconlancam->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$c70_anousu',false);</script>";
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
 </form>  
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