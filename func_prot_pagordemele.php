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
include("classes/db_pagordemele_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clpagordemele = new cl_pagordemele;
$clpagordemele->rotulo->label("e53_codord");
$clpagordemele->rotulo->label("e53_codele");
$clpagordemele->rotulo->label("e53_valor");
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
            <td width="4%" align="right" nowrap title="<?=$Te53_codord?>">
              <?=$Le53_codord?>
            </td>
            <td width="96%" align="left" nowrap>
              <?
           db_input("e53_codord",6,$Ie53_codord,true,"text",4,"","chave_e53_codord");
           ?>
            </td>
          </tr>
          <tr>
            <td width="4%" align="right" nowrap title="<?=$Te53_codele?>">
              <?=$Le53_codele?>
            </td>
            <td width="96%" align="left" nowrap>
              <?
           db_input("e53_codele",6,$Ie53_codele,true,"text",4,"","chave_e53_codele");
           ?>
            </td>
          </tr>
          <tr>
            <td width="4%" align="right" nowrap title="<?=$Te53_valor?>">
              <?=$Le53_valor?>
            </td>
            <td width="96%" align="left" nowrap>
              <?
           db_input("e53_valor",15,$Ie53_valor,true,"text",4,"","chave_e53_valor");
           ?>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_pagordemele.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr>
    <td align="center" valign="top">
      <?
      $where_instit = " e60_instit = ".db_getsession("DB_instit");
      //$pesquisa_chave = "";
      if(!isset($pesquisa_chave)){
        if(isset($chave_e53_codord) && (trim($chave_e53_codord)!="") ){
           //$sql = $clpagordemele->sql_query($chave_e53_codord." and ".$where_instit,$chave_e53_codele,$campos,"e53_codord");
           $condicao = "and pagordemele.e53_codord = {$chave_e53_codord} ";
           $sql = "
              SELECT pagordemele.e53_codord,
                     cgm.z01_nome,
                     pagordem.e50_data,
                     pagordemele.e53_valor
              FROM pagordemele
              INNER JOIN pagordem ON pagordem.e50_codord = pagordemele.e53_codord
              INNER JOIN empempenho ON empempenho.e60_numemp = pagordem.e50_numemp
              INNER JOIN orcelemento ON orcelemento.o56_codele = pagordemele.e53_codele
              INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
              AND orcelemento.o56_anousu = empempenho.e60_anousu
              WHERE e60_instit = 1 {$condicao}
              ORDER BY e53_codord,
                       e53_codele
           ";
        }
        else if(isset($chave_e53_valor) && (trim($chave_e53_valor)!="") ){
           //$sql = $clpagordemele->sql_query("","",$campos,"e53_valor"," e53_valor like '$chave_e53_valor%' and $where_instit");
           $condicao = "and e53_valor like = '{$chave_e53_valor}%' ";
           $sql = "
              SELECT pagordemele.e53_codord,
                     cgm.z01_nome,
                     pagordem.e50_data,
                     pagordemele.e53_valor
              FROM pagordemele
              INNER JOIN pagordem ON pagordem.e50_codord = pagordemele.e53_codord
              INNER JOIN empempenho ON empempenho.e60_numemp = pagordem.e50_numemp
              INNER JOIN orcelemento ON orcelemento.o56_codele = pagordemele.e53_codele
              INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
              AND orcelemento.o56_anousu = empempenho.e60_anousu
              WHERE e60_instit = 1 {$condicao}
              ORDER BY e53_codord,
                       e53_codele
           ";
        }

        else{
           //$sql = $clpagordemele->sql_query("","",$campos,"e53_codord#e53_codele",$where_instit);
           $sql = "
              SELECT pagordemele.e53_codord,
                     cgm.z01_nome,
                     pagordem.e50_data,
                     pagordemele.e53_valor
              FROM pagordemele
              INNER JOIN pagordem ON pagordem.e50_codord = pagordemele.e53_codord
              INNER JOIN empempenho ON empempenho.e60_numemp = pagordem.e50_numemp
              INNER JOIN orcelemento ON orcelemento.o56_codele = pagordemele.e53_codele
              INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
              AND orcelemento.o56_anousu = empempenho.e60_anousu
              WHERE e60_instit = 1 {$condicao}
              ORDER BY e53_codord,
                       e53_codele
           ";
        }

        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          /*$result = $clpagordemele->sql_record($clpagordemele->sql_query($pesquisa_chave." and ".$where_instit,null,"e53_codord,e53_valor,replace(pagordem.e50_obs,'\n',' ') as e50_obs"));
          if($clpagordemele->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$z01_nome','$e50_obs',false);</script>";
          }*/
          //ini_set("display_errors", 1);
          if (isset($prot)) {
              $sql = "
              SELECT pagordemele.e53_codord,
                     cgm.z01_nome,
                     pagordem.e50_data,
                     pagordemele.e53_valor
              FROM pagordemele
              INNER JOIN pagordem ON pagordem.e50_codord = pagordemele.e53_codord
              INNER JOIN empempenho ON empempenho.e60_numemp = pagordem.e50_numemp
              INNER JOIN orcelemento ON orcelemento.o56_codele = pagordemele.e53_codele
              INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
              AND orcelemento.o56_anousu = empempenho.e60_anousu
              WHERE e60_instit = 1 AND pagordemele.e53_codord = {$pesquisa_chave}
              ORDER BY e53_codord,
                       e53_codele
           ";

           $result = db_query($sql);
           db_fieldsMemory($result,0);
           echo "<script>".$funcao_js."('$e53_codord','$z01_nome','$e50_data','$e53_valor',false);</script>";
           die;
          }

          else{
           echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
          }
        }

        if (isset($e60_codemp) && !empty($e60_codemp)) {
          $sql = "
              SELECT empempenho.e60_numemp,
                     empempenho.e60_codemp,
                     empempenho.e60_anousu,
                     pagordemele.e53_codord,
                     cgm.z01_nome,
                     pagordem.e50_data,
                     pagordemele.e53_valor
              FROM pagordemele
              INNER JOIN pagordem ON pagordem.e50_codord = pagordemele.e53_codord
              INNER JOIN empempenho ON empempenho.e60_numemp = pagordem.e50_numemp
              INNER JOIN orcelemento ON orcelemento.o56_codele = pagordemele.e53_codele
              INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
              AND orcelemento.o56_anousu = empempenho.e60_anousu
              WHERE e60_instit = 1
                AND empempenho.e60_codemp = {$e60_codemp}
              ORDER BY e53_codord
           ";
           db_lovrot($sql,15,"()","",$funcao_js);
        }

        else if (isset($e60_numemp) && !empty($e60_numemp)) {
          $sql = "
              SELECT empempenho.e60_numemp,
                     empempenho.e60_codemp,
                     empempenho.e60_anousu,
                     pagordemele.e53_codord,
                     cgm.z01_nome,
                     pagordem.e50_data,
                     pagordemele.e53_valor
              FROM pagordemele
              INNER JOIN pagordem ON pagordem.e50_codord = pagordemele.e53_codord
              INNER JOIN empempenho ON empempenho.e60_numemp = pagordem.e50_numemp
              INNER JOIN orcelemento ON orcelemento.o56_codele = pagordemele.e53_codele
              INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
              AND orcelemento.o56_anousu = empempenho.e60_anousu
              WHERE e60_instit = 1
                AND empempenho.e60_numemp = {$e60_numemp}
              ORDER BY e53_codord
           ";
           db_lovrot($sql,15,"()","",$funcao_js);
        }

        else if (isset($z01_numcgm) && !empty($z01_numcgm)) {
          $sql = "
              SELECT empempenho.e60_numemp,
                     empempenho.e60_codemp,
                     empempenho.e60_anousu,
                     pagordemele.e53_codord,
                     cgm.z01_nome,
                     pagordem.e50_data,
                     pagordemele.e53_valor
              FROM pagordemele
              INNER JOIN pagordem ON pagordem.e50_codord = pagordemele.e53_codord
              INNER JOIN empempenho ON empempenho.e60_numemp = pagordem.e50_numemp
              INNER JOIN orcelemento ON orcelemento.o56_codele = pagordemele.e53_codele
              INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
              AND orcelemento.o56_anousu = empempenho.e60_anousu
              WHERE e60_instit = 1
                AND cgm.z01_numcgm = {$z01_numcgm}
              ORDER BY e53_codord
           ";
           db_lovrot($sql,15,"()","",$funcao_js);
        }

        else{
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
