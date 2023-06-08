<?php
/*
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


require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once ("dbforms/db_funcoes.php");

$oGet = db_utils::postMemory($_GET);

$sCampos    = " tf16_d_dataagendamento, tf16_c_horaagendamento, tf17_d_datasaida, tf17_c_horasaida, tf17_c_localsaida, ";
$sCampos   .= " tf18_d_dataretorno, tf18_c_horaretorno, tf18_i_veiculo, ve01_placa, tf18_i_motorista, " ;
$sCampos   .= " cgm_motorista.z01_nome AS nome_motorista  ";
$sWhere     = " tf01_i_codigo = {$oGet->iPedido} ";
$oDaoPedido = new cl_tfd_pedidotfd();
$sSqlPedido = $oDaoPedido->sql_query_pedido_saida( null, $sCampos, "", $sWhere );
$rsPedido   = db_query( $sSqlPedido );

$oSaida                   = new stdClass();
$oSaida->dtAgendamento    = "";
$oSaida->sHoraAgendamento = "";
$oSaida->dtSaida          = "";
$oSaida->sHoraSaida       = "";
$oSaida->sLocalSaida      = "";
$oSaida->dtRetorno        = "";
$oSaida->sHoraRetorno     = "";
$oSaida->iVeiculo         = "";
$oSaida->sPlaca           = "";
$oSaida->sMotorista       = "";

if ($rsPedido && pg_num_rows($rsPedido) > 0) {

  $oDados = db_utils::fieldsMemory($rsPedido, 0);

  $oSaida->dtAgendamento    = db_formatar($oDados->tf16_d_dataagendamento, 'd');
  $oSaida->sHoraAgendamento = $oDados->tf16_c_horaagendamento;
  $oSaida->dtSaida          = db_formatar($oDados->tf17_d_datasaida, 'd');
  $oSaida->sHoraSaida       = $oDados->tf17_c_horasaida;
  $oSaida->sLocalSaida      = $oDados->tf17_c_localsaida;
  $oSaida->dtRetorno        = db_formatar( $oDados->tf18_d_dataretorno, 'd');
  $oSaida->sHoraRetorno     = $oDados->tf18_c_horaretorno;
  $oSaida->iVeiculo         = $oDados->tf18_i_veiculo;
  $oSaida->sPlaca           = $oDados->ve01_placa;
  $oSaida->sMotorista       = "";

  if (!empty($oDados->nome_motorista)) {
    $oSaida->sMotorista = "{$oDados->tf18_i_motorista} - {$oDados->nome_motorista} ";
  }

}

?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
</head>
<body class='body-default'>

<div class="subcontainer">
  <fieldset >
    <legend>Dados do Veículo </legend>

    <table class="form-container">
      <tr>
        <td class="bold">Data Agendamento:</td>
        <td class="field-size3" style="background-color:#FFF; border: 1px solid #CCC;" >
          <?= $oSaida->dtAgendamento ?>
        </td>
        <td class="bold">Hora Agendamento:</td>
        <td class="field-size2" style="background-color:#FFF; border: 1px solid #CCC;" >
          <?= $oSaida->sHoraAgendamento ?>
        </td>
      </tr>
      <tr>
        <td class="bold">Data de Saída:</td>
        <td class="field-size3" style="background-color:#FFF; border: 1px solid #CCC;">
          <?= $oSaida->dtSaida ?>
        </td>
        <td class="bold">Hora de Saída:</td>
        <td class="field-size2" style="background-color:#FFF; border: 1px solid #CCC;">
          <?= $oSaida->sHoraSaida ?>
        </td>
      </tr>
      <tr>
        <td class="bold">Data de Retorno:</td>
        <td class="field-size3 " style="background-color:#FFF; border: 1px solid #CCC;">
          <?= $oSaida->dtRetorno ?>
        </td>
        <td class="bold">Hora de Retorno:</td>
        <td class="field-size2 " style="background-color:#FFF; border: 1px solid #CCC;">
          <?= $oSaida->sHoraRetorno ?>
        </td>
      </tr>
      <tr>
        <td class="bold">Local de Saída:</td>
        <td colspan='3' style="background-color:#FFF; border: 1px solid #CCC;">
          <?= $oSaida->sLocalSaida ?>
        </td>
      </tr>
      <tr>
        <td class="bold">Veículo:</td>
        <td colspan='3' style="background-color:#FFF; border: 1px solid #CCC;">
          <?= $oSaida->sPlaca ?>
        </td>
      </tr>
      <tr>
        <td class="bold">Motorista:</td>
        <td colspan='3' style="background-color:#FFF; border: 1px solid #CCC;">
          <?= $oSaida->sMotorista  ?>
        </td>
      </tr>
    </table>
  </fieldset>
</div>


</body>
</html>
