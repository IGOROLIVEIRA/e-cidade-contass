<?php

/**
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBselller Servicos de Informatica             
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
include("classes/db_evt5001consulta_classe.php");
include("classes/db_cgm_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clevt5001consulta = new cl_evt5001consulta;
$clcgm = new cl_cgm;
$clevt5001consulta->rotulo->label("rh218_perapurano");
$clevt5001consulta->rotulo->label("rh218_perapurmes");
$clevt5001consulta->rotulo->label("rh218_regist");
$clcgm->rotulo->label("z01_cgccpf");
if (!isset($chave_rh218_perapurano)) {
  $chave_rh218_perapurano = db_getsession("DB_anousu");
}
if (!isset($chave_rh218_perapurmes)) {
  $chave_rh218_perapurmes = date("m", db_getsession("DB_datausu"));
}
?>
<html xmlns="http://www.w3.org/1999/html">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
  <tr> 
    <td height="63" align="center" valign="top">
      <form name="form2" method="post" action="" >
        <fieldset style="width: 35%">
          <legend>Pesquisa de Função</legend>
          <table width="35%" border="0" align="center" cellspacing="0">
            <tr>
              <td width="4%" align="left" nowrap title="<?=$Trh218_perapurano?>">
                <?=$Lrh218_perapurano?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("rh218_perapurano",5,$Irh218_perapurano,true,"text",4,"","chave_rh218_perapurano");
                ?>
              </td>
            </tr>
            <tr>
              <td width="4%" align="left" nowrap title="<?=$Trh218_perapurmes?>">
                <?=$Lrh218_perapurmes?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("rh218_perapurmes",5,$Irh218_perapurmes,true,"text",4,"","chave_rh218_perapurmes");
                ?>
              </td>
            </tr>
            <tr>
              <td width="4%" align="left" nowrap title="<?=$Trh218_regist?>">
                <?=$Lrh218_regist?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("rh218_regist",5,$Irh218_regist,true,"text",4,"","chave_rh218_regist");
                ?>
              </td>
            </tr>
            <tr>
              <td width="4%" align="left" nowrap title="<?=$Tz01_cgccpf?>">
                <?=$Lz01_cgccpf?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("z01_cgccpf",40 ,1 ,true,"text",4,"","chave_z01_cgccpf");
                ?>
              </td>
            </tr>
          </table>
        </fieldset>
        <table width="35%" border="0" align="center" cellspacing="0">
          <tr>
            <td colspan="2" align="center">
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_evt5001consulta.hide();">
            </td>
          </tr>
        </table>
      </form>
      </td>
  </tr>
  <tr> 
    <td align="center" valign="top">
      <fieldset>
        <legend>Resultado da Pesquisa</legend>
      <?
      $where = " rh218_instit = ".db_getsession("DB_instit");
      if(!isset($pesquisa_chave)) {
        
         $campos = "rh218_sequencial,
                    rh218_regist,
                    z01_cgccpf,
                    z01_nome,
                    rh218_codcateg,
                    CASE WHEN rh218_indapuracao = 1 THEN 'Mensal'::varchar ELSE '13º Salário'::varchar END AS rh218_indapuracao,
                    rh218_nrrecarqbase,
                    rh218_tpcr,       
                    rh218_vrdescseg,
                    rh218_vrcpseg, 
                    (rh218_vrdescseg - rh218_vrcpseg) as dl_Diferença";

        if (isset($chave_rh218_regist) && (trim($chave_rh218_regist)!="") ) {
	         $where .= " and rh218_regist = $chave_rh218_regist ";
        }
        if (isset($chave_z01_cgccpf) && (trim($chave_z01_cgccpf)!="") ) {
	         $where .= " and z01_cgccpf = '$chave_z01_cgccpf' ";
        }
        if (isset($chave_rh218_perapurano) && (trim($chave_rh218_perapurano)!="") ) {
           $where .= " and rh218_perapurano = $chave_rh218_perapurano ";
        }
        if (isset($chave_rh218_perapurmes) && (trim($chave_rh218_perapurmes)!="") ) {
           $where .= " and rh218_perapurmes = $chave_rh218_perapurmes ";
        }
        $sql = $clevt5001consulta->sql_query(null,$campos,"rh218_regist",$where);
        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clevt5001consulta->sql_record($clevt5001consulta->sql_query($pesquisa_chave,db_getsession("DB_instit")));
          if($clevt5001consulta->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$rh218_sequencial',false);</script>";
          }else{
	         echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
          }
        }else{
	       echo "<script>".$funcao_js."('',false);</script>";
        }
      }
      ?>
     </fieldset>
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