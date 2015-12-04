<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_pcproc_classe.php");
include("classes/db_pcprocitem_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clpcproc = new cl_pcproc;
$clpcprocitem = new cl_pcprocitem;
$clpcproc->rotulo->label("pc80_codproc");
$clpcproc->rotulo->label("pc80_data");
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
            <td width="4%" align="right" nowrap title="<?=$Tpc80_codproc?>">
              <?=$Lpc80_codproc?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("pc80_codproc",10,$Ipc80_codproc,true,"text",4,"","chave_pc80_codproc");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tpc80_data?>">
              <?=$Lpc80_data?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("pc80_data",10,$Ipc80_data,true,"text",4,"","chave_pc80_data");
		       ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_pcproc.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr> 
    <td align="center" valign="top"> 
      <?
      if(isset($orc)){	
	$result_chave = $clpcprocitem->sql_record($clpcprocitem->sql_query_orcam(null," distinct pc81_codproc as chave_pc80_codproc",""," pc22_codorc=$orc "));
	if($clpcprocitem->numrows>0){
	  db_fieldsmemory($result_chave,0);
	}	
      }
      if(isset($campos)==false){
	 if(file_exists("funcoes/db_func_pcproc.php")==true){
	   include("funcoes/db_func_pcproc.php");
	 }else{
	 $campos = "pcproc.*";
	 }
      }
      if(!isset($pesquisa_chave)){
        if(isset($chave_pc80_codproc) && (trim($chave_pc80_codproc)!="") ){
	         $sql = $clpcproc->sql_query($chave_pc80_codproc,$campos,"pc80_codproc desc");
        }else if(isset($chave_pc80_data) && (trim($chave_pc80_data)!="") ){
	         $sql = $clpcproc->sql_query("",$campos,"pc80_data"," pc80_data like '$chave_pc80_data% desc' ");
        }else{
           $sql = $clpcproc->sql_query("",$campos,"pc80_codproc desc");
        }
        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clpcproc->sql_record($clpcproc->sql_query($pesquisa_chave));
          if($clpcproc->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$pc80_data',false);</script>";
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
