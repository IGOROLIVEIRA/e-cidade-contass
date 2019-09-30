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
include("classes/db_requisitantes_transparencia_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clrequisitantes_transparencia = new cl_requisitantes_transparencia;
$clrequisitantes_transparencia->rotulo->label("db149_matricula");
$clrequisitantes_transparencia->rotulo->label("db149_data");
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<center>
<div style="margin-top: 20px;">
<fieldset>
<legend><b>Consulta Acessos a Folha no Portal da Transparência</b></legend>
  <table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td height="63" align="center" valign="top">
        <table width="35%" border="0" align="center" cellspacing="0">
          <form name="form2" method="post" action="" >
            <tr>
              <td width="4%" align="right" nowrap title="<?=$Tdb149_matricula?>">
                <?=$Ldb149_matricula?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("db149_matricula",10,$Idb149_matricula,true,"text",4,"","chave_db149_matricula");
                ?>
              </td>
            </tr>
            <tr>
              <td width="4%" align="right" nowrap title="<?=$Tdb149_data?>">
                <?=$Ldb149_data?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_inputdata('chave_data1',@$echave_data1_dia,@$echave_data1_mes,@$echave_data1_ano,true,'text',1,"");
                ?>
                à
                <?
                db_inputdata('chave_data2',@$echave_data2_dia,@$echave_data2_mes,@$echave_data2_ano,true,'text',1,"");
                ?>
              </td>
            </tr>
            <tr>
              <td colspan="2" align="center">
                <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                <input name="limpar" type="reset" id="limpar" value="Limpar" >
                <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_matordem.hide();">
              </td>
            </tr>
          </form>
        </table>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top">
        <?
        $where = " 1=1 ";
        if(isset($chave_db149_matricula) && (trim($chave_db149_matricula)!="") ){
          $where .= " and db149_matricula = {$chave_db149_matricula} ";
        }
        if((isset($chave_data1) && (trim($chave_data1)!="")) && (isset($chave_data2) && (trim($chave_data2)!="")) ){
          $where .= " and db149_data between '{$chave_data1}' and '{$chave_data2}'";
        }
        $sql = $clrequisitantes_transparencia->sql_query("","requisitantes_transparencia.*","",$where);

        // echo $sql;die;
        db_lovrot($sql,15,"()","",$funcao_js);
      
      ?>
    </td>
  </tr>
</table>
</fieldset>
</div>
</center>
<? 
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
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
