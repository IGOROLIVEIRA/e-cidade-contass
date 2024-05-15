<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");

require_once("model/patrimonio/Bem.model.php");
require_once("model/patrimonio/BemCedente.model.php");
require_once("model/patrimonio/BemClassificacao.model.php");
require_once("model/patrimonio/PlacaBem.model.php");
require_once("model/patrimonio/BemHistoricoMovimentacao.model.php");
require_once("model/patrimonio/BemDadosMaterial.model.php");
require_once("model/patrimonio/BemDadosImovel.model.php");
require_once("model/patrimonio/BemTipoAquisicao.php");
require_once("model/patrimonio/BemTipoDepreciacao.php");
require_once("model/CgmFactory.model.php");

$oGet = db_utils::postMemory($_GET, false);
$oBem = new Bem($oGet->t52_bem);

$oMaterial = $oBem->getDadosCompra();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type='text/css'>
	.valores {background-color:#FFFFFF}
</style>
</head>
  <body>
    <center>
      <fieldset>
        <legend><strong>Dados Material</strong></legend>
          <table width="100%">
          
          	<tr>
          	
          		<td width="20%"><b>Nota Fiscal: </b></td>
          		
          		<td width="30%" class="valores">
          		  <?php 
          		    if ($oMaterial != null) {
          		      echo $oMaterial->getNotaFiscal();
          		    }
          		  ?>
          		</td>
          		
          		<td width="20%"><b>Empenho: </b></td>
          		
          		<td width="30%" class="valores">
          			<?php 
          			  if ($oMaterial != null) {
          			    echo $oMaterial->getEmpenho();
          			  }
          			?>
          		</td>
          	
          	</tr>
          	
          	<tr>
          	
          		<td><b>Ordem de Compra: </b></td>
          		
          		<td class="valores">
          			<?php 
          			  if ($oMaterial != null) {
          			    echo $oMaterial->getOrdemCompra();
          			  }
          			?>
          		</td>
          		
          		<td><b>Data Garantia: </b></td>
          		
          		<td class="valores">
          			<?php 
          			  if ($oMaterial != null) {
          			    echo $oMaterial->getDataGarantia();
          			  }
          			?>
          		</td>
          	
          	</tr>
          	
          	<tr>
          	
          		<td><b>Credor: </b></td>
          		
          		<td class="valores">
          			<?php 
          			  if ($oMaterial != null) {
          			    echo $oMaterial->getCredor();
          			  }
          			?>
          		</td>
          		
          		<td colspan="2"></td>
          	
          	</tr>
          	
          </table>
      </fieldset>
    </center>
  </body>
</html>