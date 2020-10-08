<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_tipoquestaoaudit_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$cltipoquestaoaudit = new cl_tipoquestaoaudit;
$cltipoquestaoaudit->rotulo->label("ci01_codtipo");
$cltipoquestaoaudit->rotulo->label("ci01_tipoaudit");
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
            <td width="4%" align="right" nowrap title="<?=$Tci01_codtipo?>">
              <?=$Lci01_codtipo?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("ci01_codtipo",4,$Ici01_codtipo,true,"text",4,"","chave_ci01_codtipo");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tci01_tipoaudit?>">
              <?=$Lci01_tipoaudit?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("ci01_tipoaudit",40,$Ici01_tipoaudit,true,"text",4,"","chave_ci01_tipoaudit");
		       ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_tipoquestaoaudit.hide();">
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
           if(file_exists("funcoes/db_func_tipoquestaoaudit.php")==true){
             include("funcoes/db_func_tipoquestaoaudit.php");
           }else{
           $campos = "tipoquestaoaudit.*";
           }
        }
        if(isset($chave_ci01_codtipo) && (trim($chave_ci01_codtipo)!="") ){
          $sql = $cltipoquestaoaudit->sql_query($chave_ci01_codtipo,$campos,"ci01_codtipo", "ci01_instit = ".db_getsession('DB_instit'));
        }else if(isset($chave_ci01_tipoaudit) && (trim($chave_ci01_tipoaudit)!="") ){
          $sql = $cltipoquestaoaudit->sql_query("",$campos,"ci01_tipoaudit"," ci01_tipoaudit like '$chave_ci01_tipoaudit%' AND ci01_instit = ".db_getsession('DB_instit'));
        }else{
          $sql = $cltipoquestaoaudit->sql_query(null, $campos, "ci01_codtipo", "ci01_instit = ".db_getsession('DB_instit'));
        }
        
        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $cltipoquestaoaudit->sql_record($cltipoquestaoaudit->sql_query($pesquisa_chave));
          if($cltipoquestaoaudit->numrows!=0){
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
