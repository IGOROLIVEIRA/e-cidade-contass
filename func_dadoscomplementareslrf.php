<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_dadoscomplementareslrf_classe.php");
include("classes/db_infocomplementaresinstit_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$cldadoscomplementareslrf = new cl_dadoscomplementareslrf;
$oDaoinfocomplementaresinstit = new cl_infocomplementaresinstit;
$oInstituicao = $oDaoinfocomplementaresinstit->sql_query_file(null,"*",null,"si09_instit = ".db_getsession('DB_instit'));
$oInstituicao = $oDaoinfocomplementaresinstit->sql_record($oInstituicao);
$oInstituicao = db_utils::fieldsMemory($oInstituicao);
$iCodOrgao = $oInstituicao->si09_codorgaotce;

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
           if(file_exists("funcoes/db_func_dadoscomplementareslrf.php")==true){
             include("funcoes/db_func_dadoscomplementareslrf.php");
           }else{
           $campos = "dadoscomplementareslrf.c218_sequencial,
           dadoscomplementareslrf.c218_codorgao,
           dadoscomplementareslrf.c218_mesusu,
           dadoscomplementareslrf.c218_anousu";
           }
        }

	      $sql = $cldadoscomplementareslrf->sql_query(null,$campos, "c218_codorgao asc, c218_mesusu asc", "c218_codorgao = '$iCodOrgao' and c218_anousu=".db_getsession('DB_anousu'));

        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $cldadoscomplementareslrf->sql_record($cldadoscomplementareslrf->sql_query($pesquisa_chave));
          if($cldadoscomplementareslrf->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$c218_sequencial',false);</script>";
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
