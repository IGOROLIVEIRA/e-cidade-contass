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
require_once("model/patrimonio/BemDadosImovel.model.php");
require_once("model/patrimonio/BemTipoAquisicao.php");
require_once("model/patrimonio/BemTipoDepreciacao.php");
require_once("model/CgmFactory.model.php");

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

  $oImovel = $oBem->getDadosImovel();
	
?>   
    
      <fieldset>
        <legend><strong>Dados Imovel</strong></legend>
          <table width="100%">
          
          <tr>
          	
							<td width="20%"><b>Código do Bem: </b></td>
							
							<td width="30%" class="valores">
								<?php 
								    echo $t52_bem;
								?>
							</td>
							
							<td colspan="2"></td>
          	
          	</tr>
          	
          	<tr>
          
          	<tr>
          	
							<td width="20%"><b>Lote: </b></td>
							
							<td width="30%" class="valores">
								<?php 
								  if ($oImovel != null) {
								    echo $oImovel->getIdBql();
								  }
								?>
							</td>
							
							<td colspan="2"></td>
          	
          	</tr>
          	
          	<tr>
          	
          		<td><b>Observação: </b>
          		
          		<td class="valores" colspan="3">
          			<?php 
          			  if ($oImovel != null) {
          			    echo $oImovel->getObservacao();
          			  }
          			?>
          		</td>
          	
          	</tr>
          	
          </table>
      </fieldset>
      <? 
      }
      ?>
    </center>
  </body>
</html>