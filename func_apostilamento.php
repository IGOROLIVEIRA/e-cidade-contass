<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_apostilamento_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clapostilamento = new cl_apostilamento;
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
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_apostilamento.hide();">
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
           if(file_exists("funcoes/db_func_apostilamento.php")==true){
             include("funcoes/db_func_apostilamento.php");
           }else{
           $campos = "si03_sequencial,l20_edital as dl_Processo,l20_anousu,(si172_nrocontrato||'/'||si172_exerciciocontrato) AS dl_N_Contrato,
           case when si03_numcontratoanosanteriores = 0 then null else si03_numcontratoanosanteriores end as dl_N_Contrato_Anos_Ant,
           si03_dataassinacontrato,
           (case si03_tipoapostila when 1 then 'Reajuste de preço previsto no contrato'
           when 2 then 'Atualizações, compensações ou penalizações'
           when 3 then 'Empenho de dotações orçamentárias suplementares' end) as si03_tipoapostila,
           si03_dataapostila,si03_descrapostila,si03_numapostilamento as dl_Num_Seq_Apostila,
           (case si03_tipoalteracaoapostila when 1 then 'Acréscimo de valor'
           when 2 then 'Decréscimo de valor'
           when 3 then 'Não houve alteração de valor' end) as si03_tipoalteracaoapostila,
           si03_valorapostila
           ";
           }
        }
	         $sql = $clapostilamento->sql_query(null,$campos,"si03_sequencial desc","si03_instit = ".db_getsession("DB_instit"));
        $repassa = array();
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clapostilamento->sql_record($clapostilamento->sql_query($pesquisa_chave));
          if($clapostilamento->numrows!=0){
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
