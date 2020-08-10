<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_homologacaoadjudica_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clhomologacaoadjudica = new cl_homologacaoadjudica;
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
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_homologacaoadjudica.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr>
    <td align="center" valign="top">
      <?
      if($validadispensa == "true"){
        $where = "pc50_pctipocompratribunal not in (100,101,103,102)";
        $where .= ' AND EXISTS
                        (SELECT 1
                            FROM habilitacaoforn
                                WHERE l206_licitacao = liclicita.l20_codigo) ';
      }else{
        $where = null;
      }
        if($situacao){
            $where .= ' and l20_licsituacao = '.$situacao;
        }

      if(!isset($pesquisa_chave)){
        /*if(isset($campos)==false){
           if(file_exists("funcoes/db_func_homologacaoadjudica.php")==true){
             include("funcoes/db_func_homologacaoadjudica.php");
           }else{
           $campos = "homologacaoadjudica.oid,homologacaoadjudica.*";
           }
        }*/
      	$campos = "
        distinct l202_sequencial,l202_licitacao, 
        pctipocompra.pc50_descr,
        liclicita.l20_numero,
        (CASE 
        WHEN l20_nroedital IS NULL THEN '-'
        ELSE l20_nroedital::varchar
        END) as l20_nroedital,
      	l20_edital,
      	l20_anousu,
      	l202_datahomologacao,l202_dataadjudicacao";
	         $sql = $clhomologacaoadjudica->sql_query('',$campos,'',$where);
        $repassa = array();
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query($pesquisa_chave));
          if($clhomologacaoadjudica->numrows!=0){
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
