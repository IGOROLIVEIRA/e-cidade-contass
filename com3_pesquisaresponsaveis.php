<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
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

require_once("dbforms/db_funcoes.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("classes/db_liccomissaocgm_classe.php");
require_once("classes/db_liccomissao_classe.php");
require_once("classes/db_liclicita_classe.php");
$clliccomissaocgm = new cl_liccomissaocgm;
$clliccomissao = new cl_liccomissao;
$clliclicita = new cl_liclicita;

$oDaoRotulo    = new rotulocampo;
$clliccomissao->rotulo->label();

$oGet                = db_utils::postMemory($_GET);

$campos = "l30_codigo,l30_data,l30_portaria,l30_datavalid,l30_tipo";
$sql = $clliccomissao->sql_query('',$campos,"","l30_codigo = (select l20_liccomissao from  liclicita where l20_codigo = $l20_codigo)");

$result = db_query($sql);
db_fieldsmemory($result, 0);

$sql = $clliclicita->sql_query('','*',"","l20_codigo = $l20_codigo");
$result = db_query($sql);
db_fieldsmemory($result, 0);
?>
<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <!-- <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script> -->
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <!-- <link href="estilos/tab.style.css" rel="stylesheet" type="text/css"> -->
    <style type="text/css">

  .valor {
    background-color: #FFF;
  }
  .bordas{
    border: 2px solid #cccccc;
    border-top-color: #999999;
    border-right-color: #999999;
    border-left-color: #999999;
    border-bottom-color: #999999;
    background-color: #999999;
}
.bordas_corp{
    border: 1px solid #cccccc;
    border-top-color: #999999;
    border-right-color: #999999;
    border-left-color: #999999;
    border-bottom-color: #999999;
    background-color: #cccccc;
}
</style>
  </head>
  <body bgcolor="#cccccc" onload="">
        <div style="display: table; float:left; margin-left:10%;">
          <fieldset>
            <legend><b>Responsáveis pela Licitação</b></legend>
            <?
            $l20_datacria  = explode('-',$l20_datacria);
            if($l20_datacria[0] < 2016 ) {
                ?>
                <table style="" border='0'>
                    <tr>
                        <td nowrap title="<?= $Tl30_codigo ?>" style="width: 100px;">
                            <?= $Ll30_codigo ?>
                        </td>
                        <td nowrap="nowrap" class="valor" style="width: 100px; text-align: left; ">
                            <?php echo $l30_codigo; ?>
                        </td>
                        <td nowrap="nowrap" style=" width: 50px;">
                            <?= $Ll30_data ?>
                        </td>
                        <td nowrap="nowrap" class="valor" style="width:100px; text-align: left; ">
                            <?php echo implode("/", array_reverse(explode("-", $l30_data))); ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= $Tl30_portaria ?>" style="width: 100px;">
                            <?= $Ll30_portaria ?>
                        </td>
                        <td nowrap="nowrap" class="valor" style="width: 100px; text-align: left; ">
                            <?php echo $l30_portaria; ?>
                        </td>
                        <td nowrap="nowrap" style=" width: 50px;">
                            <?= $Ll30_datavalid ?>
                        </td>
                        <td nowrap="nowrap" class="valor" style="width:100px; text-align: left; ">
                            <?php echo implode("/", array_reverse(explode("-", $l30_datavalid))); ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap="nowrap" style=" width: 100px;">
                            <?= $Ll30_tipo ?>
                        </td>
                        <td nowrap="nowrap" class="valor" style="width:100px; text-align: left; ">
                            <?php echo $l30_tipo == 1 ? "Permanente" : "Especial"; ?>
                        </td>
                    </tr>
                </table>
                <?
          }
          $clliclicita->sql_record($clliclicita->sql_query('', '*', '', "l20_codigo = $l20_codigo and pc50_pctipocompratribunal in (100,101,102,103)"));

            if ($clliclicita->numrows > 0) {

              $sql = $clliccomissaocgm->sql_query_file(null,"
l31_codigo,l31_numcgm, (select cgm.z01_nome from cgm where z01_numcgm = l31_numcgm),
               case
               when l31_tipo::varchar = '1' then '1-Autorização para abertura do procedimento de dispensa ou inexigibilidade'
               when l31_tipo::varchar = '2' then '2-Cotação de preços'
               when l31_tipo::varchar = '3' then '3-Informação de existência de recursos orçamentários'
               when l31_tipo::varchar = '4' then '4-Ratificação'
               when l31_tipo::varchar = '5' then '5-Publicação em órgão oficial'
               when l31_tipo::varchar = '6' then '6-Parecer Jurídico'
               when l31_tipo::varchar = '7' then '7-Parecer (outros)'
               end as l31_tipo
                ",null,"l31_licitacao=$l20_codigo");

          }else {

            $clliclicita->sql_record($clliclicita->sql_query_file('', '*', '', "l20_codigo = $l20_codigo and l20_naturezaobjeto = 6"));

            if ($clliclicita->numrows > 0) {

              $campos = "l30_codigo,l30_data,l30_portaria,l30_datavalid,l30_tipo";
              $sql = $clliccomissaocgm->sql_query(null, "l31_codigo,       l31_numcgm,
       (select z01_nome from cgm where z01_numcgm = l31_numcgm),
   case 
   when l31_tipo::varchar = '1' then '1-Autorização para abertura do procedimento licitatório'
               when l31_tipo::varchar = '2' then '2-Emissão do edital'
               when l31_tipo::varchar = '3' then '3-Pesquisa de preços'
               when l31_tipo::varchar = '4' then '4-Informação de existência de recursos orçamentários'
               when l31_tipo::varchar = '5' then '5-Condução do procedimento licitatório'
               when l31_tipo::varchar = '6' then '6-Homologação'
               when l31_tipo::varchar = '7' then '7-Adjudicação'
               when l31_tipo::varchar = '8' then '8-Publicação em órgão Oficial'
               when l31_tipo::varchar = '9' then '9-Avaliação de Bens'
   end as l31_tipo",
                  "", "l31_licitacao =  $l20_codigo");
          }else{

                $campos = "l30_codigo,l30_data,l30_portaria,l30_datavalid,l30_tipo";
                $sql = $clliccomissaocgm->sql_query_file(null, "l31_codigo,       l31_numcgm,
       (select z01_nome from cgm where z01_numcgm = l31_numcgm),
   case
   when l31_tipo::varchar = '1' then '1-Autorização para abertura do procedimento licitatório'
               when l31_tipo::varchar = '2' then '2-Emissão do edital'
               when l31_tipo::varchar = '3' then '3-Pesquisa de preços'
               when l31_tipo::varchar = '4' then '4-Informação de existência de recursos orçamentários'
               when l31_tipo::varchar = '5' then '5-Condução do procedimento licitatório'
               when l31_tipo::varchar = '6' then '6-Homologação'
               when l31_tipo::varchar = '7' then '7-Adjudicação'
               when l31_tipo::varchar = '8' then '8-Publicação em órgão Oficial'
   end as l31_tipo",
                    "", "l31_licitacao =  $l20_codigo");

            }


            }
           db_lovrot(@$sql,15,"","","");
          ?>
          </fieldset>
        </div>
  </body>
</html>