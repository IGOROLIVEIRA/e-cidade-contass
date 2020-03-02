<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_adesaoregprecos_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$cladesaoregprecos = new cl_adesaoregprecos;
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
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_adesaoregprecos.hide();">
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
           if(file_exists("funcoes/db_func_adesaoregprecos.php")==true){
             include("funcoes/db_func_adesaoregprecos.php");
           }else{
           $campos = "si06_sequencial,cgm.z01_nome as dl_Orgao_Gerenciador,si06_numeroprc,si06_anoproc,si06_numlicitacao,si06_dataadesao,si06_dataata,si06_objetoadesao,
                      c.z01_nome as dl_Resp_Aprovacao,si06_numeroadm,si06_anocadastro";
           }
        }
	    $sql = $cladesaoregprecos->sql_query(null,$campos);
        $repassa = array();
        
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
            if(isset($par) && $par = true){
              $sSQL = "select si06_objetoadesao,si06_numeroprc,si06_numlicitacao,si06_anoproc from adesaoregprecos where si06_sequencial = {$pesquisa_chave}";
              $result = $cladesaoregprecos->sql_record($sSQL);
          }else {
                $result = $cladesaoregprecos->sql_record($cladesaoregprecos->sql_query($pesquisa_chave, "*", "", "si06_instit = " . db_getsession("DB_instit")));
            }

          if($cladesaoregprecos->numrows!=0){
            db_fieldsmemory($result,0);
              if(isset($par) && $par = true){
                  echo "<script>".$funcao_js."('$si06_objetoadesao','$si06_numeroprc','$si06_numlicitacao','$si06_anoproc',false);</script>";
              }else {
                  echo "<script>" . $funcao_js . "('$oid',false);</script>";
              }
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
