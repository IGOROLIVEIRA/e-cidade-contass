<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_pcmater_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clpcmater = new cl_pcmater;
$clpcmater->rotulo->label("pc01_codmater");
$clpcmater->rotulo->label("pc01_descrmater");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload='document.form1.chave_pc01_descrmater.focus();'>
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
  <tr> 
    <td height="63" align="center" valign="top">
    <table width="35%" border="0" align="center" cellspacing="0">
    <form name="form1" method="post" action="" >
   <tr> 
      <td width="4%" align="right" nowrap title="<?=$Tpc01_codmater?>"><?=$Lpc01_codmater?></td>
      <td width="96%" align="left" nowrap><?  db_input("pc01_codmater",6,$Ipc01_codmater,true,"text",4,"","chave_pc01_codmater"); ?> </td>
   </tr>
   <tr> 
      <td width="4%" align="right" nowrap title="<?=$Tpc01_descrmater?>"> <?=$Lpc01_descrmater?></td>
      <td width="96%" align="left" nowrap><? db_input("pc01_descrmater",80,$Ipc01_descrmater,true,"text",4,"","chave_pc01_descrmater"); ?></td>
   </tr>
   <tr> 
      <td colspan="2" align="center"> 
          <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
          <input name="limpar" type="reset" id="limpar" value="Limpar" >
          <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_pcmater.hide();">
          </td>
    </tr>
    </form>
    </table>
    </td>
  </tr>
  <tr> 
    <td align="center" valign="top"> 
      <?
      $where_ativo = " and pc01_ativo='f' ";
      if(isset($vertudo)){
        $where_ativo = "";
      }
      
      if(!isset($pesquisa_chave)){
        if(empty($campos)){
           if(file_exists("funcoes/db_func_pcmater.php")==true){
             include("funcoes/db_func_pcmater.php");
           }else{
           $campos = "pcmater.*";
           }
        } 
	/*
        $campos = "pcmater.pc01_codmater,
	           pcmater.pc01_descrmater,
		   pcmater.pc01_complmater,
		   pcmater.pc01_codsubgrupo,
		   pcsubgrupo.pc04_descrsubgrupo,
		   pcmater.pc01_codele"; */
        $campos = "pcmater.pc01_codmater,
	           pcmater.pc01_descrmater,
		   pcmater.pc01_complmater,
		   pcmater.pc01_codsubgrupo,
		   pcsubgrupo.pc04_descrsubgrupo,
		   pctipo.pc05_servico as DL_pc05_servico";

        if(isset($chave_pc01_codmater) && (trim($chave_pc01_codmater)!="") ){
	         $sql = $clpcmater->sql_query(null,$campos,"pc01_codmater","pc01_codmater=$chave_pc01_codmater $where_ativo");
        }else if(isset($chave_pc01_descrmater) && (trim($chave_pc01_descrmater)!="") ){
	         $sql = $clpcmater->sql_query("",$campos,"pc01_descrmater"," pc01_descrmater like '$chave_pc01_descrmater%'  $where_ativo");
        }else{
           $sql = $clpcmater->sql_query("",$campos,"pc01_descrmater","1=1 $where_ativo");
        }
        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clpcmater->sql_record($clpcmater->sql_query(null,"pc01_descrmater","","pc01_codmater=$pesquisa_chave $where_ativo"));
          if($clpcmater->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$pc01_descrmater',false);</script>";
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
<script>

</script>

