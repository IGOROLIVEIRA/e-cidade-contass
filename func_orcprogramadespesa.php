<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_orcprograma_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clorcprograma = new cl_orcprograma;
$clorcprograma->rotulo->label();

$iAnoSessao = db_getsession('DB_anousu')+1;
$sWhereAdicional  = "o54_anousu = {$iAnoSessao}";

if (!empty($iAno)) {
  $sWhereAdicional = "o54_anousu = {$iAno}";
}

if (!empty($iTipo) && $iTipo != 0) {
  $sWhereAdicional .= " and o54_tipoprograma = {$iTipo} ";
}

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
            <td width="4%" align="right" nowrap title="<?=$To54_programa?>">
              <?=$Lo54_programa?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("o54_programa",4,$Io54_programa,true,"text",4,"","chave_o54_programa");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$To54_descr?>">
              <?=$Lo54_descr?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("o54_descr",40,$Io54_descr,true,"text",4,"","chave_o54_descr");
		       ?>
            </td>
          </tr>
          <tr> 
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_orcprograma.hide();">
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
           if(file_exists("funcoes/db_func_orcprograma.php")==true){
             include("funcoes/db_func_orcprograma.php");
           }else{
           $campos = "orcprograma.*";
           }
        }
        if(isset($chave_o54_programa) && (trim($chave_o54_programa)!="") ){
	   $sql = $clorcprograma->sql_query(null,null,$campos,
	                                   "o54_programa",
	                                   "{$sWhereAdicional} and o54_programa = $chave_o54_programa");

        }elseif(isset($chave_o54_descr) && (trim($chave_o54_descr)!="") ){
	   $sql = $clorcprograma->sql_query(null,null,$campos,"o54_programa",
	                                   "{$sWhereAdicional}   and o54_descr like '$chave_o54_descr%'
	                                   ");
        }else{
           $sql = $clorcprograma->sql_query(null,"",$campos,
                                            "o54_programa",
                                            "{$sWhereAdicional}"
                                            );
        }
        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clorcprograma->sql_record($clorcprograma->sql_query_file(null,null,'*',''
					   ," {$sWhereAdicional}  and o54_programa = $pesquisa_chave"));
          if($clorcprograma->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$o54_descr',false);</script>";
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
