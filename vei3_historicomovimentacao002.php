<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_transferenciaveiculos_classe.php");
include("classes/db_veicbaixa_classe.php");
include("classes/db_veicreativar_classe.php");

$oGet = db_utils::postMemory($_GET, false);

$clveiculostransferencia  = new cl_veiculostransferencia;
$clveicbaixa              = new cl_veicbaixa;
$clveicreativar           = new cl_veicreativar;

$db_opcao = 3;

switch ($oGet->tipo) {
  case 'TRANSFERENCIA':
    $campos = "ve81_sequencial,ve80_dt_transferencia,ve80_hora,ve81_codigo,ve81_placa";
    $campos .= ",vca.ve36_sequencial as coddepto_origem, vcd.ve36_sequencial as coddepto_destino";
    $campos .= ",ve80_coddeptoatual,a.descrdepto as descrdeptoatual,ve80_motivo";
    $campos .= ",ve80_coddeptodestino,d.descrdepto as descrdeptodestino,id_usuario,nome";
    $sql = $clveiculostransferencia->sql_buscar_detalhes($oGet->codigo, $campos);
    
    $result = $clveiculostransferencia->sql_record($sql);
    if ($clveiculostransferencia->numrows > 0) {
      db_fieldsmemory($result, 0);
    }
    break;
  case 'BAIXA':
    $campos = "ve04_codigo,ve04_data,ve01_codigo,ve01_placa";
    $campos .= ",ve04_hora,ve04_veiccadtipobaixa,ve12_descr";
    $campos .= ",id_usuario,nome,ve04_motivo";

    $sql = $clveicbaixa->sql_buscar_detalhes($oGet->codigo, $campos);
    $result = $clveicbaixa->sql_record($sql);
    if ($clveicbaixa->numrows > 0) {
      db_fieldsmemory($result, 0);
    }
    break;
  case 'REATIVACAO':
    $campos = "ve82_sequencial,ve82_datareativacao,TO_CHAR(ve82_criadoem, 'HH24:MI') as ve82_hora";
    $campos .= ",ve01_codigo,ve01_placa,ve82_obs";
    $campos .= ",id_usuario,nome";

    $sql = $clveicreativar->sql_buscar_detalhes($oGet->codigo, $campos);
    $result = $clveicreativar->sql_record($sql);
    if ($clveicreativar->numrows > 0) {
      db_fieldsmemory($result, 0);
    }
    break;
}
?>

<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <style>
    .removeinfo>div {
      display: none;
    }

    .title {
      font-weight: bold;
    }
  </style>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <fieldset style="max-width: 900px; margin: auto; margin-top: 20px;">
    <legend style="font-weight: bold;">
      DADOS COMPLEMENTARES
    </legend>
    <table border="0">
      <? if ($oGet->tipo == "TRANSFERENCIA") { ?>
        <tr>
          <td class="title">Sequencial:</td>
          <td>
            <? db_input('ve81_sequencial', 10, $ve81_sequencial, true, 'text', $db_opcao, ""); ?>
          </td>
          <td class="title">Veículo:</td>
          <td>
            <? db_input('ve81_codigo', 10, $ve81_codigo, true, 'text', $db_opcao, ""); ?>
            <? db_input('ve81_placa', 10, $ve81_placa, true, 'text', $db_opcao, ""); ?>
          </td>
        </tr>
        <tr>
          <td class="title">Data:</td>
          <td>
            <?
            if (isset($ve80_dt_transferencia)) {
              $ve80_dt_transferencia_dia = date('d', strtotime($ve80_dt_transferencia));
              $ve80_dt_transferencia_mes = date('m', strtotime($ve80_dt_transferencia));
              $ve80_dt_transferencia_ano = date('Y', strtotime($ve80_dt_transferencia));
            }
            db_inputdata('ve80_dt_transferencia', @$ve80_dt_transferencia_dia, @$ve80_dt_transferencia_mes, @$ve80_dt_transferencia_ano, true, 'text', $db_opcao);
            ?>

          </td>
          <td class="title">Hora:</td>
          <td>
            <?
            db_input('ve80_hora', 10, $ve80_hora, true, 'text', $db_opcao, "");
            ?>
          </td>
        </tr>
        <tr>
          <td class="title">Central Anterior:</td>
          <td>
            <? db_input('coddepto_origem', 10, $coddepto_origem, true, 'text', $db_opcao, ""); ?>
            <? db_input('descrdeptoatual', 30, $descrdeptoatual, true, 'text', $db_opcao, ""); ?>
          </td>
          <td class="title">Central Atual:</td>
          <td>
            <? db_input('coddepto_destino', 10, $coddepto_destino, true, 'text', $db_opcao, ""); ?>
            <? db_input('descrdeptodestino', 30, $descrdeptodestino, true, 'text', $db_opcao, ""); ?>
          </td>
        </tr>
        <tr>
          <td class="title" style="vertical-align: top;">Observação:</td>
          <td class="removeinfo">
            <? db_textarea('ve80_motivo', 6, 43, $ve80_motivo, true, 'text', $db_opcao, '', "", "", 200); ?>
          </td>
          <td class="title" style="vertical-align: top;">Usuário:</td>
          <td style="vertical-align: top;">
            <? db_input('id_usuario', 10, $id_usuario, true, 'text', $db_opcao, ""); ?>
            <? db_input('nome', 30, $nome, true, 'text', $db_opcao, ""); ?>
          </td>
        </tr>
      <? } else if ($oGet->tipo == "BAIXA") { ?>
        <tr>
          <td class="title">Sequencial:</td>
          <td>
            <? db_input('ve04_codigo', 10, $ve04_codigo, true, 'text', $db_opcao, ""); ?>
          </td>
          <td class="title">Veículo:</td>
          <td>
            <? db_input('ve01_codigo', 10, $ve01_codigo, true, 'text', $db_opcao, ""); ?>
            <? db_input('ve01_placa', 10, $ve01_placa, true, 'text', $db_opcao, ""); ?>
          </td>
        </tr>
        <tr>
          <td class="title">Data:</td>
          <td>
            <?
            if (isset($ve04_data)) {
              $ve04_data_dia = date('d', strtotime($ve04_data));
              $ve04_data_mes = date('m', strtotime($ve04_data));
              $ve04_data_ano = date('Y', strtotime($ve04_data));
            }
            db_inputdata('ve80_dt_transferencia', @$ve04_data_dia, @$ve04_data_mes, @$ve04_data_ano, true, 'text', $db_opcao);
            ?>

          </td>
          <td class="title">Hora:</td>
          <td>
            <?
            db_input('ve04_hora', 10, $ve04_hora, true, 'text', $db_opcao, "");
            ?>
          </td>
        </tr>
        <tr>
          <td class="title" style="vertical-align: top;">Observação:</td>
          <td class="removeinfo">
            <? db_textarea('ve04_motivo', 6, 40, $ve04_motivo, true, 'text', $db_opcao, '', "", "", 200); ?>
          </td>
          <td class="title" style="vertical-align: top;">Usuário:</td>
          <td style="vertical-align: top;">
            <? db_input('id_usuario', 10, $id_usuario, true, 'text', $db_opcao, ""); ?>
            <? db_input('nome', 30, $nome, true, 'text', $db_opcao, ""); ?>
          </td>
        </tr>
      <? } else if ($oGet->tipo == "REATIVACAO") { ?>
        <tr>
          <td class="title">Sequencial:</td>
          <td>
            <? db_input('ve82_sequencial', 10, $ve82_sequencial, true, 'text', $db_opcao, ""); ?>
          </td>
          <td class="title">Veículo:</td>
          <td>
            <? db_input('ve01_codigo', 10, $ve01_codigo, true, 'text', $db_opcao, ""); ?>
            <? db_input('ve01_placa', 10, $ve01_placa, true, 'text', $db_opcao, ""); ?>
          </td>
        </tr>
        <tr>
          <td class="title">Data:</td>
          <td>
            <?
            if (isset($ve82_datareativacao)) {
              $ve82_datareativacao_dia = date('d', strtotime($ve82_datareativacao));
              $ve82_datareativacao_mes = date('m', strtotime($ve82_datareativacao));
              $ve82_datareativacao_ano = date('Y', strtotime($ve82_datareativacao));
            }
            db_inputdata('ve82_datareativacao', @$ve82_datareativacao_dia, @$ve82_datareativacao_mes, @$ve82_datareativacao_ano, true, 'text', $db_opcao);
            ?>

          </td>
          <td class="title">Hora:</td>
          <td>
            <?
            db_input('ve82_hora', 10, $ve82_hora, true, 'text', $db_opcao, "");
            ?>
          </td>
        </tr>
        <tr>
          <td class="title" style="vertical-align: top;">Observação:</td>
          <td class="removeinfo">
            <? db_textarea('ve82_obs', 6, 40, $ve82_obs, true, 'text', $db_opcao, '', "", "", 200); ?>
          </td>
          <td class="title" style="vertical-align: top;">Usuário:</td>
          <td style="vertical-align: top;">
            <? db_input('id_usuario', 10, $id_usuario, true, 'text', $db_opcao, ""); ?>
            <? db_input('nome', 30, $nome, true, 'text', $db_opcao, ""); ?>
          </td>
        </tr>
      <? } ?>
    </table>
  </fieldset>
</body>

</html>