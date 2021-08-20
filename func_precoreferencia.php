<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_precoreferencia_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clprecoreferencia = new cl_precoreferencia;
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
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_precoreferencia.hide();">
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
           if(file_exists("funcoes/db_func_precoreferencia.php")==true){
             include("funcoes/db_func_precoreferencia.php");
           }else{
                $campos = "precoreferencia.oid,precoreferencia.*";
           }
        }

        $campos .= ",
            pc80_data,
            pc80_resumo,
            pc80_tipoprocesso,
            (CASE
                WHEN pc80_criterioadjudicacao = 1 THEN 'Desconto sobre tabela'
                WHEN pc80_criterioadjudicacao = 2 THEN 'Menor Taxa'
                ELSE 'Outros'
            END) AS pc80_criterioadjudicacao,
            nome,
            coddepto,
            descrdepto,
            instit
        ";

        $sql = $clprecoreferencia->sql_query('', $campos,'si01_sequencial desc');
        $repassa = array();
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clprecoreferencia->sql_record($clprecoreferencia->sql_query($pesquisa_chave));
          if($clprecoreferencia->numrows!=0){
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
