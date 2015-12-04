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
require_once("classes/db_benstransfcodigo_classe.php");

$oBensTransf = new cl_benstransfcodigo();

$oGet = db_utils::postMemory($_GET, false);
$aCodBens = explode(",", $oGet->t52_bem);

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
<? 
foreach ($aCodBens as $t52_bem) {
	
	$oBem = new Bem($t52_bem);

  $oMaterial = $oBem->getDadosCompra();
  
  $rsResult = $oBensTransf->sql_record($oBensTransf->sql_query("",$t52_bem,"t52_descr,t95_histor,t52_ident"));
  $oBemTransf = db_utils::fieldsMemory($rsResult, 0);
	
?>    
    
      <fieldset>
        <legend><strong>Dados Material</strong></legend>
          <table width="100%">
          
          <tr>
          	
          		<td width="20%"><b>Descrição: </b></td>
          		
          		<td width="50%" class="valores">
          		  <?php 
          		      echo $oBemTransf->t52_descr;
          		  ?>
          		</td>
          		
          		<td ><b>Placa: </b></td>
          		
          		<td width="30%" class="valores" align="left">
          			<?php 
          			    echo $oBemTransf->t52_ident;
          			?>
          		</td>
          	
          	</tr>
          
          	<tr>
          	
          	<tr>
          		
          		<td width="20%"><b>Histórico Transferência: </b></td>
          		
          		<td width="30%" class="valores" colspan="3">
          			<?php 
          			    echo $oBemTransf->t95_histor;
          			?>
          		</td>
          	
          	</tr>
          
          	<tr>
          	
          		<td width="20%"><b>Nota Fiscal: </b></td>
          		
          		<td width="30%" class="valores">
          		  <?php 
          		    if ($oMaterial != null) {
          		      echo $oMaterial->getNotaFiscal();
          		    }
          		  ?>
          		</td>
          		
          		<td ><b>Empenho: </b></td>
          		
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
      <?
} 
      ?>
    </center>
  </body>
</html>