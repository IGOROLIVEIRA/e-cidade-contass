<?
$clrotulo = new rotulocampo;
$clrotulo->label("ve01_placa");
$clrotulo->label("ve76_placa");
$clrotulo->label("ve76_obs");
?>
<style>
  .title {
    font-weight: bold;
  }
</style>
<form name="form1" method="post">
  <fieldset style="max-width: 510px; margin-top: 20px;">
    <legend>Alterar Placa</legend>
    <table border="0">
      <tr>
        <td class="title">Cód. Veículo:</td>
        <td>
          <? db_input('ve01_codigo', 12, $ve01_codigo, true, 'text', 3, ""); ?>
        </td>
        <td style="text-align: right;">
          <span class="title">Data:</span>
          <?
          if (!isset($ve76_data)) {
            $ve76_data_dia = date('d', db_getsession("DB_datausu"));
            $ve76_data_mes = date('m', db_getsession("DB_datausu"));
            $ve76_data_ano = date('Y', db_getsession("DB_datausu"));
          }
          db_inputdata('ve76_data', @$ve76_data_dia, @$ve76_data_mes, @$ve76_data_ano, true, 'text', $db_opcao);
          ?>
        </td>
      </tr>
      <tr>
        <td class="title">Descrição:</td>
        <td colspan="2">
          <? db_input('si04_descricao', 59, $vsi04_descricao, true, 'text', 3, ""); ?>
        </td>
      </tr>
      <tr>
        <td class="title">Placa Atual:</td>
        <td colspan="2">
          <? db_input('ve01_placa', 30, $Ive01_placa, true, 'text', 3, ""); ?>
        </td>
      </tr>
      <tr>
        <td class="title">Nova Placa:</td>
        <td colspan="2">
          <? db_input('ve76_placa', 30, $Ive76_placa, true, 'text', $db_opcao, 'onkeyup="js_limpaCaracteresEspeciais(this, /[^a-zA-Z0-9]/g)"') ?>
        </td>
      </tr>
      <tr>
        <td class="title" colspan="3">Observação:</td>
      </tr>
      <tr>
        <td colspan="3">
          <? db_textarea('ve76_obs', 8, 70, $Ive76_obs, true, 'text', $db_opcao, 'onkeyup="js_limpaCaracteresEspeciais(this, /[^a-zA-Z0-9áéíóúãõâêîôûçÁÉÍÓÚÃÕÂÊÎÔÛÇ .,]/g)"', "", "", 200); ?>
        </td>
      </tr>
    </table>
  </fieldset>
  <div style="margin-top: 20px;">
    <input id="alterar" type="button" value="Alterar" name="alterar" onclick="js_alterar()">
    <input id="pesquisar" type="button" value="Pesquisar" name="pesquisar" onclick="js_pesquisaveiculo()">
  </div>
</form>

<script>
  (function() {
    document.addEventListener('DOMContentLoaded', js_pesquisaveiculo);
  })();

  function js_limpaCaracteresEspeciais(campo, reg = /[^a-zA-Z0-9]/g) {
    campo.value = campo.value.replace(reg, '');
  };

  function js_pesquisaveiculo() {
    js_OpenJanelaIframe('top.corpo', 'db_iframe_alterarplaca', 'func_veiculosalt.php?baixa=1&funcao_js=parent.js_buscarveiculo|ve01_codigo', 'Pesquisa Veiculo', true);
  }

  function js_buscarveiculo(ve01_codigo) {
    db_iframe_alterarplaca.hide();

    const params = {
      exec: 'buscarVeiculo',
      codigo: ve01_codigo
    };
    alterarPlacaRPC(params, preencheForm, "Carregando dados do veiculo.");
  }

  function js_alterar() {
    const campoVe01_codigo = document.getElementById('ve01_codigo');
    const campoVe76_data = document.getElementById('ve76_data');
    const campoVe76_obs = document.getElementById('ve76_obs');
    const campoVe76_placa = document.getElementById('ve76_placa');

    if (!validateInput(campoVe76_data, "É necessário informar a data da alteração.")) {
      return;
    }

    if (!validateInput(campoVe76_placa, "É necessário informar a nova placa para o veículo.")) {
      return;
    }

    const params = {
      exec: 'alterarPlaca',
      dados: {
        ve01_codigo: campoVe01_codigo.value,
        ve76_data: campoVe76_data.value,
        ve76_obs: campoVe76_obs.value,
        ve76_placa: campoVe76_placa.value
      }
    };
    alterarPlacaRPC(params, processaRetornoAlteracao, "Salvando alteração.");
  }

  function processaRetornoAlteracao(res) {
    const {
      status,
      message,
      veiculo
    } = JSON.parse(res.responseText);

    alert(message);

    if (status !== 1) {
      return;
    }

    document.getElementById('ve01_codigo').value = veiculo.ve01_codigo;
    document.getElementById('si04_descricao').value = veiculo.si04_descricao;
    document.getElementById('ve01_placa').value = veiculo.ve01_placa;
    document.getElementById('ve76_placa').value = "";
    document.getElementById('ve76_obs').value = "";
  }

  function preencheForm(res) {
    const {
      status,
      message,
      veiculo
    } = JSON.parse(res.responseText);

    if (status !== 1) {
      alert(message);
      return;
    }

    document.getElementById('ve01_codigo').value = veiculo.ve01_codigo;
    document.getElementById('si04_descricao').value = veiculo.si04_descricao;
    document.getElementById('ve01_placa').value = veiculo.ve01_placa;
    document.getElementById('ve76_placa').value = "";
    document.getElementById('ve76_obs').value = "";
    document.getElementById('ve76_obsobsdig').value = '0';
  }

  function alterarPlacaRPC(params, callback, loadingMessage) {
    const endpoint = 'vei1_alterarplacaRPC.php';
    js_divCarregando(loadingMessage, 'div_aguarde');

    const request = new Ajax.Request(endpoint, {
      method: 'post',
      parameters: 'json=' + JSON.stringify(params),
      onComplete: function(res) {
        js_removeObj('div_aguarde');
        callback(res);
      },
      onFailure: function() {
        // Handle errors
        alert("An error occurred while processing the request.");
      }
    });
  }

  function validateInput(inputElement, errorMessage) {
    // Check if value is either null, undefined, or empty string
    if (inputElement.value == null || inputElement.value.trim() === "") {
      alert(`Usuário: ${errorMessage}`);
      inputElement.style.backgroundColor = "#6E9D88";
      inputElement.focus();
      return false;
    }
    inputElement.style.backgroundColor = "#FFFFFF";
    return true;
  }
</script>