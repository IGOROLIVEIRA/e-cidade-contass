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
require_once("classes/db_licpregaocgm_classe.php");
require_once("classes/db_licpregao_classe.php");
$cllicpregaocgm = new cl_licpregaocgm;
$cllicpregao = new cl_licpregao();

$oDaoRotulo    = new rotulocampo;
$cllicpregao->rotulo->label();

$oGet                = db_utils::postMemory($_GET);

$campos = "l45_sequencial,l45_data,l45_numatonomeacao,l45_validade,l45_tipo,l45_descrnomeacao";
$sql = $cllicpregao->sql_query('',$campos,"","l45_sequencial = (select l20_equipepregao from  liclicita where l20_codigo = $l20_codigo)"); 
$result = db_query($sql);
db_fieldsmemory($result, 0);
?>
<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <link href="estilos/tab.style.css" rel="stylesheet" type="text/css">
    <style type="text/css">

  .valor {
    background-color: #FFF;
  }
</style>
  </head>
  <body bgcolor="#cccccc" onload="">
        <div style="display: table; float:left; margin-left:10%;">
          <fieldset>
            <legend><b>Comissão de Licitação</b></legend>
            <table style="" border='0'>
            <tr>
              <td nowrap title="<?=$Tl45_sequencial?>" style="width: 100px;">
              <?=$Ll45_sequencial?>
              </td>
              <td nowrap="nowrap" class="valor" style="width: 100px; text-align: left; ">
              <?php echo $l45_sequencial;?>
              </td>
              <td nowrap="nowrap" style=" width: 50px;">
              <?=$Ll45_data?>
              </td>
              <td nowrap="nowrap" class="valor" style="width:100px; text-align: left; ">
              <?php echo implode("/", array_reverse(explode("-", $l45_data)));?>
              </td>
            </tr>
            <tr>
              <td nowrap title="<?=$Tl45_numatonomeacao?>" style="width: 100px;">
              <?=$Ll45_numatonomeacao?>
              </td>
              <td nowrap="nowrap" class="valor" style="width: 100px; text-align: left; ">
              <?php echo $l45_numatonomeacao;?>
              </td>
              <td nowrap="nowrap" style=" width: 50px;">
              <?=$Ll45_validade?>
              </td>
              <td nowrap="nowrap" class="valor" style="width:100px; text-align: left; ">
              <?php echo implode("/", array_reverse(explode("-", $l45_validade)));?>
              </td>
            </tr>
            <tr>
              <td nowrap="nowrap" style=" width: 100px;">
              <?=$Ll45_tipo?>
              </td>
              <td nowrap="nowrap" class="valor" style="width:100px; text-align: left; ">
              <?php echo $l45_tipo==1?"Permanente":"Especial";?>
              </td>
              <td nowrap="nowrap" style=" width: 100px;">
              <?=$Ll45_descrnomeacao?>
              </td>
              <td nowrap="nowrap" class="valor" style="width:100px; text-align: left; ">
              <?php echo $l45_descrnomeacao==1?"Portaria":"Decreto";?>
              </td>
            </tr>
            </table>
          <?
           $campos = "l30_codigo,l30_data,l30_portaria,l30_datavalid,l30_tipo";
           $sql = $cllicpregaocgm->sql_query(null,"l46_sequencial,z01_numcgm,z01_nome,case when l46_tipo = 1 then '1-Leiloeiro' when l46_tipo = 2 then '2-Membro/Equipe de Apoio' 
	 when l46_tipo = 3 then '3-Presidente' when l46_tipo = 4 then '4-Secretário' when l46_tipo = 5 then '5-Servidor Designado' 
	 when l46_tipo = 6 then '6-Pregoeiro' end as l46_tipo 
	 ,l46_cargo,case when l46_naturezacargo = 1 then '1-Servidor Efetivo' when l46_naturezacargo = 2 then '2-Empregado Temporário' 
	 when l46_naturezacargo = 3 then '3-Cargo em Comissão' when l46_naturezacargo = 4 then '4-Empregado Público' when l46_naturezacargo = 5 then '5-Agente Político'
	 when l46_naturezacargo = 6 then '6-Outra' end as l46_naturezacargo",
   null,"l45_sequencial = (select l20_equipepregao from  liclicita where l20_codigo = $l20_codigo)");
           db_lovrot($sql, 15, "()", "");
          ?>
          </fieldset>
        </div>
  </body>
</html>