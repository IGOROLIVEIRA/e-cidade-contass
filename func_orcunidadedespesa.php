<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_orcunidade_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clorcunidade = new cl_orcunidade;
$clorcunidade->rotulo->label("o41_anousu");
$clorcunidade->rotulo->label("o41_orgao");
$clorcunidade->rotulo->label("o41_unidade");
$clorcunidade->rotulo->label("o41_descr");

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
            <td width="4%" align="right" nowrap title="<?=$To41_orgao?>">
              <?=$Lo41_orgao?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("o41_orgao",2,$Io41_orgao,true,"text",4,"","chave_o41_orgao");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$To41_unidade?>">
              <?=$Lo41_unidade?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("o41_unidade",2,$Io41_unidade,true,"text",4,"","chave_o41_unidade");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$To41_descr?>">
              <?=$Lo41_descr?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("o41_descr",50,$Io41_descr,true,"text",4,"","chave_o41_descr");
		       ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_orcunidade.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr> 
    <td align="center" valign="top"> 
      <?
      $iAnoDespesa = db_getsession("DB_anousu")+1;
			$wh1 = '';
			$wh  = '';
			if (isset($orgao)){
           
              $wh1 = " o41_orgao = {$orgao} and ";
              $wh  = " o41_orgao = {$orgao} and ";
			}
      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           if(file_exists("funcoes/db_func_orcunidade.php")==true){
             include("funcoes/db_func_orcunidade.php");
           }else{
           $campos = "orcunidade.*,o58_instit as db_o58_instit,nomeinst as db_nomeinst";
           }
        }
        $campos = "orcunidade.*,o40_instit as db_o58_instit,db_config.nomeinst as db_nomeinst";
        if(isset($chave_o41_orgao) && (trim($chave_o41_orgao)!="") ){
        	 if(isset($orgaos) && $orgaos != ""){
		        	$wh1 = " o41_orgao in  ($orgaos) and ";
		       }
	         $sql = $clorcunidade->sql_query(null, " {$chave_o41_orgao} ",$chave_o41_unidade,$campos,"o41_orgao",$wh1." o41_anousu=".$iAnoDespesa);
        }else if(isset($chave_o41_descr) && (trim($chave_o41_descr)!="") ){
	         $sql = $clorcunidade->sql_query(null,"","",$campos,"o41_descr"," $wh o41_descr like '$chave_o41_descr%' and o41_anousu=".$iAnoDespesa);
        }else{
          
		       if(isset($orgao) && $orgao != ""){
		        	$wh1 = " o41_orgao in  ($orgao) and ";
		       }
           $sql = $clorcunidade->sql_query(null,"","",$campos,"o41_anousu#o41_orgao#o41_unidade",$wh1." o41_anousu=".$iAnoDespesa);
        }
        db_lovrot($sql,15,"()","",$funcao_js);
        
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
					
					$campos = "orcunidade.o41_orgao,o40_descr,orcunidade.o41_unidade,orcunidade.o41_codtri,orcunidade.o41_descr,
					           orcunidade.o41_indent,orcunidade.o41_cnpj,
										 orcunidade.o41_ident,orcunidade.o41_anousu as db_o41_anousu,o41_instit,db_config.nomeinst as db_nomeinst";
        	if(isset($orgaos) && $orgaos != ""){
		        	$wh1 = " o41_orgao in  ($orgaos) and ";
		      }
		      
		      echo "teste : ".$pesquisa_chave. "<br><br><br><br><br><br><br><br><br><br>";
// 		      die ($clorcunidade->sql_query(null,'',null,$campos,'',$wh1." o41_anousu=".db_getsession("DB_anousu")." and o41_unidade = $pesquisa_chave" ));
		      
          $result = $clorcunidade->sql_record($clorcunidade->sql_query(null,'',null,$campos,'',$wh1." o41_anousu=".$iAnoDespesa."
					                             and o41_unidade = $pesquisa_chave" ));
					
		  if($clorcunidade->numrows > 0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$o41_descr',false,'$db_nomeinst','$o41_instit','$o41_orgao');</script>";
          }else{
	         echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true,'');</script>";
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
