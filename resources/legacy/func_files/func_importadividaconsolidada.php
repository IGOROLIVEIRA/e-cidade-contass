<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_dividaconsolidada_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$cldividaconsolidada = new cl_dividaconsolidada;
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
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_dividaconsolidada.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr> 
    <td align="center" valign="top"> 
      <?
      
        $sql = "select si167_nroleiautorizacao::varchar as si167_nroleiautorizacao ,si167_nrocontratodivida,anoreferencia as dl_Ano,(select max(si167_mesreferencia) from dividaconsolidada where x.si167_nroleiautorizacao = si167_nroleiautorizacao and x.si167_nrocontratodivida = si167_nrocontratodivida and si167_anoreferencia=anoreferencia) as si167_mesreferencia from 
(select *,(select max(si167_anoreferencia) from dividaconsolidada where dividas.si167_nroleiautorizacao = si167_nroleiautorizacao and dividas.si167_nrocontratodivida = si167_nrocontratodivida) as anoreferencia
from (select distinct si167_nroleiautorizacao,si167_nrocontratodivida from dividaconsolidada where si167_instit = ".db_getsession("DB_instit").") as dividas) x";
        $repassa = array();
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);

      ?>
     </td>
   </tr>
</table>
</body>
</html>
<?

