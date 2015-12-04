<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_utils.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_orctiporec_classe.php");
include("classes/db_conplanoexe_classe.php");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$oPost = db_utils::postMemory($_POST,0);
$oGet  = db_utils::postMemory($_GET,0);

$clconplanoexe = new cl_conplanoexe;
$clorctiporec = new cl_orctiporec;
$clorctiporec->rotulo->label("o15_codigo");
$clorctiporec->rotulo->label("o15_descr");

if (isset($pesquisa_conta)){
  // temos um reduzido do plano de contas
  // descobrimos o recurso e configuramos esta consulta para apresentar aquele recurso
  $result = $clconplanoexe->sql_record(
            $clconplanoexe->sql_descr((db_getsession("DB_anousu")+1),$pesquisa_conta,"c61_codigo"));

  if ($clconplanoexe->numrows >0){
      db_fieldsmemory($result,0);
      $pesquisa_chave = $c61_codigo;
      
  }

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
            <td width="4%" align="right" nowrap title="<?=$To15_codigo?>">
              <?=$Lo15_codigo?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("o15_codigo",4,$Io15_codigo,true,"text",4,"","chave_o15_codigo");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$To15_descr?>">
              <?=$Lo15_descr?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("o15_descr",30,$Io15_descr,true,"text",4,"","chave_o15_descr");
		       ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_orctiporec.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr> 
    <td align="center" valign="top"> 
      <?
      $dbwhere = "";
      if(isset($sem_recurso) && trim($sem_recurso) != ""){
        $dbwhere = " and o15_codigo not in (" . $sem_recurso . ")";
      }
      if (isset($sFiltroTipo) && $sFiltroTipo != '') {
        $dbwhere .= " and o15_tipo = {$sFiltroTipo}";
      }
      if (!isset($ativo) || (isset($ativo) && $ativo == 0)) {
      	$dbwhere .= " and (o15_datalimite is null or o15_datalimite > '".date('Y-m-d',db_getsession('DB_datausu'))."')";
      }
      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           if(file_exists("funcoes/db_func_orctiporec.php")==true){
             include("funcoes/db_func_orctiporec.php");
           }else{
           $campos = "orctiporec.*";
           }
        }
        if(isset($chave_o15_codigo) && (trim($chave_o15_codigo)!="") ){
	         $sql = $clorctiporec->sql_query(null,$campos,"o15_codigo", "o15_codigo = " . $chave_o15_codigo . $dbwhere);
        }else if(isset($chave_o15_descr) && (trim($chave_o15_descr)!="") ){
	         $sql = $clorctiporec->sql_query(null,$campos,"o15_descr"," o15_descr like '$chave_o15_descr%' " . $dbwhere);
        }else{
           $sql = $clorctiporec->sql_query("",$campos,"o15_codigo"," 1 = 1 " . $dbwhere);
        }
        //die($sql);
        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
          if (isset($pesquisa_conta)){
                if($pesquisa_chave!=null && $pesquisa_chave!=""){
	                $result = $clorctiporec->sql_record($clorctiporec->sql_query(null, " * ", "", "o15_codigo = " . $pesquisa_chave . $dbwhere));
	                
	                if($clorctiporec->numrows!=0){
	                   db_fieldsmemory($result,0);
	                   echo "<script>".$funcao_js."('$pesquisa_chave','$o15_descr');</script>";
	                }
	              }
	
	        } else {
	          // aqui continua a funçao normalmente
	          if($pesquisa_chave!=null && $pesquisa_chave!=""){
	            $result = $clorctiporec->sql_record($clorctiporec->sql_query(null, " * ", "", "o15_codigo = " . $pesquisa_chave . $dbwhere));
	            //die($clorctiporec->sql_query(null, " * ", "", "o15_codigo = " . $pesquisa_chave . $dbwhere));
	            if($clorctiporec->numrows != 0){
	              db_fieldsmemory($result,0);
	              echo "<script>".$funcao_js."('$o15_descr',false);</script>";
	            }else{
		            echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
	            }
	          }else{
		          echo "<script>".$funcao_js."('',false);</script>";
	          }
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