<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_pcorcamforne_classe.php");
include("classes/db_contratos_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clpcorcamforne = new cl_pcorcamforne;
$clcontratos  = new cl_contratos;

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
            <td width="4%" align="right" nowrap title="<?=$Tpc21_orcamforne?>">
              <?=$Lpc21_orcamforne?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
           db_input("pc21_orcamforne",10,$Ipc21_orcamforne,true,"text",4,"","chave_pc21_orcamforne");
           ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tpc21_codorc?>">
              <?=$Lpc21_codorc?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
           db_input("pc21_codorc",10,$Ipc21_codorc,true,"text",4,"","chave_pc21_codorc");
           ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_pcorcamforne.hide();">
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
           $campos = "*";
        }
        $sql = $clcontratos->sql_fornContratos($pesquisa_chave);
        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clcontratos->sql_record($clcontratos->sql_fornContratos($pesquisa_chave));
          if($clcontratos->numrows!=0){
            //db_fieldsmemory($result,0);
            $sql = 'select * from cgm limit 5';
            db_lovrot($sql,15,"()","",$funcao_js);

            echo "<script>".$funcao_js."('$z01_numcgm',false);</script>";
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
