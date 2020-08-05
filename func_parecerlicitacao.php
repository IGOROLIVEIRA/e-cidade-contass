<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_parecerlicitacao_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clparecerlicitacao = new cl_parecerlicitacao;
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
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_parecerlicitacao.hide();">
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
           if(file_exists("funcoes/db_func_parecerlicitacao.php")==true){
             include("funcoes/db_func_parecerlicitacao.php");
           }else{
           $campos = "l200_sequencial,l20_codigo, l200_licitacao,(select l20_edital::varchar||'/'||l20_anousu::varchar from liclicita where l20_codigo=l200_licitacao) as l20_edital,
                        liclicita.l20_numero,
					    (CASE 
                            WHEN liclicita.l20_nroedital IS NULL THEN '-'
                            ELSE liclicita.l20_nroedital::varchar
                        END) as l20_nroedital,
                        l03_descr as dl_Modalidade,
                        l200_exercicio,
                        l200_data,
                        (CASE 
                            WHEN l200_tipoparecer = 1 THEN 'Técnico'
                            WHEN l200_tipoparecer = 2 THEN 'Juridico - Edital'
                            WHEN l200_tipoparecer = 3 THEN 'Juridico - Julgamento'
                            ELSE 						   'Juridico - Outros'
                        END) as l200_tipoparecer,
                        z01_nome,
                        l20_objeto,
                        l08_descr as dl_Situação
                        ";
           }
        }
         $sql = $clparecerlicitacao->sql_query('',$campos,'', 'codigo = '.db_getsession('DB_instit'));
        $repassa = array();
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clparecerlicitacao->sql_record($clparecerlicitacao->sql_query($pesquisa_chave));
          if($clparecerlicitacao->numrows!=0){
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
