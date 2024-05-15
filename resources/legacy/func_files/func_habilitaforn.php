<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_pcforne_classe.php");
include("classes/db_cgm_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clpcforne = new cl_pcforne;
$clcgm     = new cl_cgm;
$clhabilitacaoforn = new cl_habilitacaoforn;
$clpcforne->rotulo->label("pc60_numcgm");
$clpcforne->rotulo->label("pc60_dtlanc");
$clcgm->rotulo->label("z01_nome");
$clcgm->rotulo->label("z01_cgccpf");
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
            <td width="4%" align="right" nowrap title="<?=$Tpc60_numcgm?>">
              <?=$Lpc60_numcgm?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("pc60_numcgm",8,$Ipc60_numcgm,true,"text",4,"","chave_pc60_numcgm");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tz01_nome?>">
              <?=$Lz01_nome?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("z01_nome",40,$Iz01_nome,true,"text",4,"","chave_z01_nome");
		       ?>
            </td>
          </tr>
          <tr>
            <td width="4%" align="right" nowrap title="<?=$Tz01_cgccpf;?>"><?=$Lz01_cgccpf; ?></td>
            <td>
              <?
                db_input("z01_cgccpf", 25, $Iz01_cgccpf, true, "text", 4, "", "chave_z01_cgccpf");
              ?>
            </td>
          </tr>          
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tpc60_dtlanc?>">
              <?=$Lpc60_dtlanc?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("pc60_dtlanc",10,$Ipc60_dtlanc,true,"text",4,"","chave_pc60_dtlanc");
		       ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_pcforne.hide();">
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
        //   if(file_exists("funcoes/db_func_pcforne.php")==true){
        //     include("funcoes/db_func_pcforne.php");
        //   }else{
           $campos = "distinct pcforne.*,cgm.*";
        //   }
        }
        if(isset($chave_pc60_numcgm) && (trim($chave_pc60_numcgm)!="") ){
	         $sql = $clpcforne->sql_query($chave_pc60_numcgm,$campos,"pc60_numcgm");
        }else if(isset($chave_pc60_dtlanc) && (trim($chave_pc60_dtlanc)!="") ){
	         $sql = $clpcforne->sql_query("",$campos,"pc60_dtlanc"," pc60_dtlanc like '$chave_pc60_dtlanc%' ");
        }else if(isset($chave_z01_nome) && (trim($chave_z01_nome)!="") ){
	         $sql = $clpcforne->sql_query("",$campos,"z01_nome"," z01_nome like '$chave_z01_nome%' ");
        } else if (isset($chave_z01_cgccpf) && (trim($chave_z01_cgccpf) != "")) {
           $sql = $clpcforne->sql_query("",$campos,"z01_cgccpf"," z01_cgccpf like '$chave_z01_cgccpf%' ");
        }else{
           //echo "<script>alert('teste')</script>";
           $sql = $clhabilitacaoforn->sql_query_fornecedor("",$campos,"pc60_numcgm","");
        }
        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clpcforne->sql_record($clpcforne->sql_query($pesquisa_chave));
          if($clpcforne->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$pc60_dtlanc',false);</script>";
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
