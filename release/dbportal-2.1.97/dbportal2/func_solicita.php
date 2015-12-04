<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_solicita_classe.php");

db_postmemory($HTTP_POST_VARS);
db_postmemory($HTTP_GET_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$clsolicita = new cl_solicita;
$clsolicita->rotulo->label("pc10_numero");
$clsolicita->rotulo->label("pc10_data");
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
            <td width="4%" align="right" nowrap title="<?=$Tpc10_numero?>">
              <?=$Lpc10_numero?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("pc10_numero",10,$Ipc10_numero,true,"text",4,"","chave_pc10_numero");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tpc10_data?>">
              <?=$Lpc10_data?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
	         db_input("pc10_data",10,$Ipc10_data,true,"text",4,"","chave_pc10_data");
           db_input("param",10,"",false,"hidden",3);
              ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_solicita.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr> 
    <td align="center" valign="top"> 
      <?
      if(!isset($passar)){
          $where_depart = " and pc81_solicitem ";
	  if (isset($param) && $param == ""){
	       $nulo = " is null ";
	  } else {
	       $nulo = "";
	  }

      if (trim($nulo) == ""){
        $where_depart  = " and (e55_sequen is null or (e55_sequen is not null and e54_anulad is not null))";
	  } else {
        $where_depart .= $nulo;
	  }
      }
      if(isset($anular) && $anular=="true"){
		$where_depart = " and e54_autori is not null and e54_anulad is null and (e61_numemp is null or (e60_numemp is not null and e60_vlremp=e60_vlranu))";
      }
      if(isset($anular) && $anular=="false"){
		$where_depart .= " and ( e54_autori is null or ( e54_autori is not null and e54_anulad is null and (e61_numemp is null or (e60_numemp is not null and e60_vlremp=e60_vlranu))))";
      }
      if(isset($anular)){
        $where_depart .= " and pc11_codigo is not null ";
      }

      if(isset($departamento) && trim($departamento)!=""){
      	$where_depart .= " and pc10_depto=$departamento ";
      }
      if(isset($gerautori)){
		$where_depart .= " and pc10_correto='t' ";
      }
      
      if(isset($proc)){
		$where_depart .= " and pc81_codproc is not null";
      }
      
      if(isset($nada)){
		$where_depart = "";
      }
      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           if(file_exists("funcoes/db_func_solicita.php")==true){
             include("funcoes/db_func_solicita.php");
           }else{
           $campos = "solicita.*";
           }
        }
        $where_depart .= " and pc10_instit = " . db_getsession("DB_instit");
	$campos = " distinct ".$campos;
        if(isset($chave_pc10_numero) && (trim($chave_pc10_numero)!="") ){
	       $sql = $clsolicita->sql_query(null,$campos,"pc10_numero desc "," pc10_numero=$chave_pc10_numero $where_depart ");
        }else if(isset($chave_pc10_data) && (trim($chave_pc10_data)!="") ){
	       $sql = $clsolicita->sql_query("",$campos,"pc10_numero desc "," pc10_data like '$chave_pc10_data%' $where_depart ");
        }else{
           $sql = $clsolicita->sql_query("",$campos,"pc10_numero desc "," 1=1 $where_depart");
        }
        //die($sql);
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",array(),false);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clsolicita->sql_record($clsolicita->sql_query(null,"distinct *",""," pc10_numero=$pesquisa_chave $where_depart "));
          if($clsolicita->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$pc10_data',false);</script>";
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
