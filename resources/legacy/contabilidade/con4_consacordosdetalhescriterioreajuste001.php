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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("model/Acordo.model.php");

$clAcordo = new Acordo($ac16_sequencial);

?>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
  <style>.tdWidth{width:3%}.tdBgColor{background-color:#fff;color:#000;width:10%}</style>
</head>

<form name="form1" method="post" action="">
  <center>

    <table align="center" style="margin-top:15px;" width="98%" border="0">

      <tr>

        <td nowrap="nowrap" class="tdWidth" align="left">
          <b>Critério de Reajuste:</b>
        </td>

        <td class="tdBgColor">
          <?php
          $aCriterioReajuste = array("1" => "Índice Único", "2" => "Cesta de Índices", "3" => "Índice Específico");
          echo $aCriterioReajuste[$clAcordo->getCriterioReajuste()];
          ?>
        </td>

        <td nowrap="nowrap" class="tdWidth" align="left">
          <b>Data Base Reajuste:</b>
        </td>

        <td align="left" class="tdBgColor"><?php echo db_formatar($clAcordo->getDataReajuste(),"d"); ?></td>

      </tr>

      <tr>

        <td class="tdWidth" align="left" nowrap="nowrap">
          <b>Período de Reajuste:</b>
        </td>
        <td class="tdBgColor"><?php echo $clAcordo->getPeriodoreajuste(); ?></td>

        <td align="left" nowrap="nowrap">
          <b>Índice de Reajuste:</b>
        </td>

        <td class="tdBgColor">
          <?php
          $aIndiceReajuste = array(
            ""  => "-",
            "0" => "-",
            "1" => 'IPCA',
            "2" => 'INPC',
            "3" => 'INCC',
            "4" => 'IGP-M',
            "5" => 'IGP-DI',
            "6" => 'Outro'
          );
          echo $aIndiceReajuste[$clAcordo->getIndiceReajuste()];
          ?>
        </td>

      </tr>

      <tr>
        <td nowrap colspan="5">
          <fieldset style="margin-top: 30px;">
            <legend>Descrição do Critério de Reajuste</legend>
            <?
            db_textarea('descricaoReajuste', 10, 145, 1, true, 'text', $db_opcao, "readonly='' style='resize: none'");
            echo "<script> document.getElementById('descricaoReajuste').value = '{$clAcordo->getDescricaoReajuste()} {$clAcordo->getDescricaoIndice()}'; </script>";
            ?>
          </fieldset>
        </td>
      </tr>

    </table>

  </center>
</form>