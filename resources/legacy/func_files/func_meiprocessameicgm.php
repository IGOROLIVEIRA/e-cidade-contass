<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_meiprocessameicgm_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clmeiprocessameicgm = new cl_meiprocessameicgm;
$clmeiprocessameicgm->rotulo->label("q118_sequencial");
$clmeiprocessameicgm->rotulo->label("q118_meicgm");
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
            <td width="4%" align="right" nowrap title="<?=$Tq118_sequencial?>">
              <?=$Lq118_sequencial?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("q118_sequencial",10,$Iq118_sequencial,true,"text",4,"","chave_q118_sequencial");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tq118_meicgm?>">
              <?=$Lq118_meicgm?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("q118_meicgm",10,$Iq118_meicgm,true,"text",4,"","chave_q118_meicgm");
		       ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_meiprocessameicgm.hide();">
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
           if(file_exists("funcoes/db_func_meiprocessameicgm.php")==true){
             include("funcoes/db_func_meiprocessameicgm.php");
           }else{
           $campos = "meiprocessameicgm.*";
           }
        }
        if(isset($chave_q118_sequencial) && (trim($chave_q118_sequencial)!="") ){
	         $sql = $clmeiprocessameicgm->sql_query($chave_q118_sequencial,$campos,"q118_sequencial");
        }else if(isset($chave_q118_meicgm) && (trim($chave_q118_meicgm)!="") ){
	         $sql = $clmeiprocessameicgm->sql_query("",$campos,"q118_meicgm"," q118_meicgm like '$chave_q118_meicgm%' ");
        }else{
           $sql = $clmeiprocessameicgm->sql_query("",$campos,"q118_sequencial","");
        }
        $repassa = array();
        if(isset($chave_q118_meicgm)){
          $repassa = array("chave_q118_sequencial"=>$chave_q118_sequencial,"chave_q118_meicgm"=>$chave_q118_meicgm);
        }
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clmeiprocessameicgm->sql_record($clmeiprocessameicgm->sql_query($pesquisa_chave));
          if($clmeiprocessameicgm->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$q118_meicgm',false);</script>";
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
<script>
js_tabulacaoforms("form2","chave_q118_meicgm",true,1,"chave_q118_meicgm",true);
</script>
