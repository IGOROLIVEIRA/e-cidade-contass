<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_liclicitem_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clliclicitem = new cl_liclicitem;
$clliclicitem->rotulo->label("l21_codigo");
$clliclicitem->rotulo->label("l21_codigo");
	$sSql  = "SELECT l21_codigo, pc01_descrmater from liclicitem ";
  $sSql .= "join pcprocitem on l21_codpcprocitem = pc81_codprocitem ";
  $sSql .= "join solicitem on pc81_solicitem = pc11_codigo ";
  $sSql .= "join solicitempcmater on pc16_solicitem = pc11_codigo ";
  $sSql .= "join pcmater on pc16_codmater = pc01_codmater ";
  $sSql .= "where l21_codliclicita = $cod_licita";
    

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
            <td width="4%" align="right" nowrap title="<?=$Tl21_codigo?>">
              <?=$Ll21_codigo?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("l21_codigo",10,$Il21_codigo,true,"text",4,"","chave_l21_codigo");
		       ?>
            </td>
          </tr>
          
          <tr> 
            <td width="4%" align="right">
              <strong>Descrição:</strong>
            </td>
            <td width="96%" align="left" nowrap> 
						<input name="chave_pc01_descrmater" id="chave_pc01_descrmater" >
            </td>
          </tr>
                    
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_liclicitem.hide();">
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

        if(isset($chave_l21_codigo) && (trim($chave_l21_codigo)!="") ){
	        $sSql .= " and l21_codigo = $chave_l21_codigo";
        }
        if (isset($chave_pc01_descrmater) && (trim($chave_pc01_descrmater != ""))) {
          $sSql .= " and pc01_descrmater like '%".strtoupper($chave_pc01_descrmater)."%'";
        }
        db_lovrot($sSql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
        	$sSql .= " and l21_codigo = $pesquisa_chave";
          $rsItem = db_query($sSql);
          if(pg_num_rows($rsItem)!=0){
            db_fieldsmemory($rsItem,0);
            echo "<script>".$funcao_js."('$pc01_descrmater',false);</script>";
          }else{
	         echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") $sSql',true);</script>";
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
