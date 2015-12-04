<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("dbforms/verticalTab.widget.php");

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

$oGet = db_utils::postMemory($_GET, false);

/**
 * Carregamos informacao da transferencia
 */
$oBensTransf = new cl_benstransfcodigo();
$rsResult = $oBensTransf->sql_record($oBensTransf->sql_query($oGet->t93_codtran));
$oBemTransf = db_utils::fieldsMemory($rsResult, 0);

/**
 * identificamos departamento de origem e destino
 */
$sSql = "select dp1.coddepto,dp1.descrdepto as origem, dp2.descrdepto as destino 
																	from benstransf as bt1 
																	inner join db_depart as dp1 on bt1.t93_depart = dp1.coddepto
																	inner join benstransfdes as btd1 on bt1.t93_codtran = btd1.t94_codtran
																	inner join db_depart as dp2 on dp2.coddepto = btd1.t94_depart 
																	where bt1.t93_codtran = {$oGet->t93_codtran}";

$rsResultDpOrigem = db_query($sSql);
$oDpOrigem = db_utils::fieldsMemory($rsResultDpOrigem, 0);


/**
 * verificamos se a transferencia foi confirmada pelo departamento de destino
 */
$sSql = "select * from histbemtrans where t97_codtran = {$oGet->t93_codtran}";
$rsStatusTransf = db_query($sSql);
if (pg_num_rows($rsStatusTransf) > 0){
	$sStatusTransf = "TRANSFERÊNCIA CONFIRMADA";
} else {
	$sStatusTransf = "CONFIRMAÇÃO DE TRANSFERÊNCIA PENDENTE";
}


?>
<html>
<head>
<title>Dados do Cadastro de Veículos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="estilos/tab.style.css" rel="stylesheet" type="text/css">
<style type='text/css'>
.valores {background-color:#FFFFFF}
</style>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

  <fieldset>

    <legend>
      <strong>Dados da Transferência:</strong>
    </legend>

    <table>

      <tr>
        <td>
          <strong>Código da Transferência: </strong>
        </td>
        <td class="valores" width="300" align="left">
          <?php echo $oGet->t93_codtran; ?>
        </td>
        <td>
          <strong>Departamento de Origem: </strong>
        </td>
        <td class="valores" width="30" align="right" >
          <?php
          if ($oDpOrigem->coddepto != null) {
              echo $oDpOrigem->coddepto;
          }
          ?>
        </td>
        <td class="valores" width="300" align="left">
          <?php
          if ($oDpOrigem->origem != null) {
              echo $oDpOrigem->origem;
          }
          ?>
        </td>
      </tr>

      <tr>
        <td>
          <strong>Departamento: </strong>
        </td>
        <td class="valores" align="left">
          <?php echo $oDpOrigem->destino; ?>
        </td>
        <td>
          <strong>Cod. Usuário: </strong>
        </td>
        <td class="valores" align="right">
          <?php
              echo $oBemTransf->id_usuario;
          ?>
        </td>
        <td class="valores" align="left">
          <?php
              echo $oBemTransf->nome;
          ?>
        </td>
      </tr>

      <tr>
        <td>
          <strong>Data: </strong>
        </td>
        <td class="valores" >
           <?php echo implode("/" , array_reverse(explode("-", $oBemTransf->t93_data))); ?>
        </td>
        <td>
          <strong>Status Transferência: </strong>
        </td>
        <td class="valores" colspan="2">
           <?php echo $sStatusTransf; ?>
        </td>
      </tr>

      <tr>
        <td>
          <strong>Observações: </strong>
        </td>
        <td class="valores" colspan="5">
           <?php echo $oBemTransf->t93_obs; ?>
        </td>
      </tr>
    </table>

  </fieldset>

  <?php
    $aCodBens = array();  
    for ($i = 0; $i < pg_num_rows($rsResult); $i++) {
    	$aCodBens[] = db_utils::fieldsMemory($rsResult, $i)->t52_bem;
    }
  
    $oTabDetalhes = new verticalTab('detalhesBem', 450);

    $sGetUrl = "?t52_bem=".implode(",", $aCodBens);
    $oTabDetalhes->add('dadosMaterial', 'Dados dos Materiais', "func_dadosmaterialbenstrans.php{$sGetUrl}");
    $oTabDetalhes->add('dadosImovel', 'Dados Imovel', "func_dadosimovelbenstrans.php{$sGetUrl}");
    $oTabDetalhes->add('impressao', 'Impressão', "func_impressaobenstrans.php{$sGetUrl}&t93_codtran={$oGet->t93_codtran}");
    $oTabDetalhes->show();
  ?>
</body>
</html>
