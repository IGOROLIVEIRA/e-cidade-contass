<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBSeller Servicos de Informatica             
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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_assenta_classe.php");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$classenta  = new cl_assenta;
$cltipoasse = new cl_tipoasse;
$clrotulo   = new rotulocampo;

$classenta->rotulo->label("h16_codigo");
$classenta->rotulo->label("h16_regist");

$clrotulo->label("z01_numcgm");
$clrotulo->label("z01_nome");
$clrotulo->label("h12_assent");

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
                <td width="4%" align="right" nowrap title="<?=$Th12_assent?>">
                  <?=$Lh12_assent?>
                </td>
                <td width="96%" align="left" nowrap> 
                  <?
    		       db_input("h12_assent",6,$Ih12_assent,true,"text",4,"","chave_h12_assent");
    		       ?>
                </td>
              </tr>
              <tr> 
                <td width="4%" align="right" nowrap title="<?=$Th16_regist?>">
                  <b>Matricula :</b>
                </td>
                <td width="96%" align="left" nowrap> 
                  <?
    		       db_input("h16_regist",6,$Ih16_regist,true,"text",4,"","chave_h16_regist");
    		       ?>
                </td>
              </tr>
              <tr> 
                <td width="4%" align="right" nowrap title="<?=$Tz01_nome?>">
                <?=$Lz01_nome?>
                </td>
                <td width="96%" align="left" nowrap colspan='3'> 
                <?
                db_input("z01_nome",80,$Iz01_nome,true,"text",4,"","chave_z01_nome");
    	        ?>
                </td>
              </tr>
              <tr> 
                <td colspan="2" align="center"> 
                  <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
                  <input name="limpar" type="reset" id="limpar" value="Limpar" >
                  <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_assenta.hide();">
                 </td>
              </tr>
            </form>
            </table>
          </td>
      </tr>
      <tr> 
        <td align="center" valign="top"> 
          <?php

          $sWhere = "";
          if (isset($bloqueia_reajuste)) {
            $sWhere .= " and h12_tiporeajuste = 0";
          }

          if(!isset($pesquisa_chave)){

            if(isset($campos)==false){
              if(file_exists("funcoes/db_func_assenta.php")==true){
                include("funcoes/db_func_assenta.php");
              }else{
                $campos = "assenta.*";
              }
            }

            if(isset($chave_h12_assent) && (trim($chave_h12_assent)!="") ){
              $sql = $classenta->sql_query("",$campos,"h16_regist"," h12_assent = '$chave_h12_assent' {$sWhere}");
            }else if(isset($chave_h16_regist) && (trim($chave_h16_regist)!="") ){
    	        $sql = $classenta->sql_query("",$campos,"h16_regist"," h16_regist = '$chave_h16_regist' {$sWhere}");
            }else if(isset($chave_z01_nome) && (trim($chave_z01_nome)!="") ){
    	        $sql = $classenta->sql_query("",$campos,"h16_regist"," z01_nome like '$chave_z01_nome%' {$sWhere}");
            }

            $repassa = array();
            if(isset($chave_h16_regist) && (trim($chave_h16_regist)!="")  ){
              $repassa = array("chave_h16_regist"=>$chave_h16_regist,"chave_h16_regist"=>$chave_h16_regist);
            }else if(isset($chave_z01_nome) && (trim($chave_z01_nome)!="") ){
              $repassa = array("chave_z01_nome"=>$chave_z01_nome,"chave_z01_nome"=>$chave_z01_nome);
            }else if(isset($chave_h12_assent) && (trim($chave_h12_assent)!="") ){
              $repassa = array("chave_h12_assent"=>$chave_h12_assent,"chave_h12_assent"=>$chave_h12_assent);
            }

    	      if(isset($sql) && trim($sql) != ""){
              db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
            }
          }else{

            if($pesquisa_chave!=null && $pesquisa_chave!=""){
              $result = $classenta->sql_record($classenta->sql_query($pesquisa_chave, "*", null, " 1=1 {$sWhere}"));
              if($classenta->numrows!=0){
                db_fieldsmemory($result,0);
                echo "<script>".$funcao_js."('$h16_regist',false);</script>";
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
  js_tabulacaoforms("form2","chave_z01_nome",true,1,"chave_z01_nome",true);
</script>