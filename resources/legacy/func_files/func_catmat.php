<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_pcmater_classe.php");
db_postmemory($HTTP_GET_VARS);
db_postmemory($HTTP_POST_VARS);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
  <tr> 
    <td height="63" align="center" valign="top">
    <table width="35%" border="0" align="center" cellspacing="0">
    <form name="form1" method="post" action="" >
   <tr> 
      <td width="4%" align="right" nowrap title="Medicamento"><b> Medicamento: </b></td>
      <td width="96%" align="left" nowrap><? db_input("nom_medicamento",80,$nom_medicamento,true,"text",4,""); ?></td>
   </tr>
   <tr> 
      <td colspan="2" align="center"> 
          <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
          <input name="limpar" type="reset" id="limpar" value="Limpar" >
          <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_catmat.hide();">
          </td>
    </tr>
    </form>
    </table>
    </td>
  </tr>
  <tr> 
    <td align="center" valign="top"> 
      <?
      $campos = 'nom_medicamento as dl_medicamento, dsc_codigo_barra as dl_codigo_de_barras, nom_item_financeiro as dl_item, catmat as dl_catmat, dsc_registro_anvisa as dl_registro_anvisa';
      if($nom_medicamento!=null && $nom_medicamento!=""){
          $sql = "select $campos from catalogomat where  nom_medicamento ilike '%$nom_medicamento%' order by nom_medicamento asc";
          db_lovrot($sql,15,"()","",$funcao_js);    
      }else{
        $sql = "select $campos from catalogomat order by nom_medicamento asc";
        db_lovrot($sql,15,"()","",$funcao_js);
	      echo "<script>".$funcao_js."('',false);</script>";

      }
      
      ?>
     </td>
   </tr>
</table>
</body>
</html>
<script>
function js_reload(){
  document.form1.submit();
}

</script>