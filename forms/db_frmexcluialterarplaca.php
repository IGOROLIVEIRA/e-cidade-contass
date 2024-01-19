<style>
  .title {
    font-weight: bold;
  }
</style>

<form name="form1" method="post">
  <fieldset style="max-width: 510px; margin-top: 20px;">
    <legend>Excluír alteração de placa</legend>
    <table border="0">
      <? db_input('ve76_sequencial', 0, $ve76_sequencial, true, 'hidden', $db_opcao, ""); ?>
      <tr>
        <td class="title">Cód. Veículo:</td>
        <td>
          <? db_input('ve76_veiculo', 12, $ve76_veiculo, true, 'text', $db_opcao, ""); ?>
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
        <td class="title">Placa Atual:</td>
        <td colspan="2">
          <? db_input('ve76_placa', 30, $ve76_placa, true, 'text', $db_opcao, ""); ?>
        </td>
      </tr>
      <tr>
        <td class="title">Placa Anterior:</td>
        <td colspan="2">
          <? db_input('ve76_placaanterior', 30, $ve76_placaanterior, true, 'text', $db_opcao, "", "", "", 20); ?>
        </td>
      </tr>
      <tr>
        <td class="title" colspan="3">Observação:</td>
      </tr>
      <tr>
        <td colspan="3">
          <? db_textarea('ve76_obs', 8, 70, $Ive76_obs, true, 'text', $db_opcao, "", "", "", 200); ?>
        </td>
      </tr>
    </table>
  </fieldset>
  <div style="margin-top: 20px;">
    <input id="excluir" type="button" value="Excluir" name="excluir" onclick="js_excluir()">
    <input id="pesquisar" type="button" value="Pesquisar" name="pesquisar" onclick="js_pesquisaalterarplaca()">
  </div>
</form>

<script>
  (function() {
    document.addEventListener('DOMContentLoaded', js_pesquisaalterarplaca);
  })();

  function js_pesquisaalterarplaca() {
    js_OpenJanelaIframe('top.corpo', 'db_iframe_excluialterarplaca', 'func_veiculosaltplaca.php?baixa=1&funcao_js=parent.js_buscaralterarplaca|ve76_sequencial', 'Pesquisa Alteração de Placa', true);
  }

  function js_buscaralterarplaca(ve76_sequencial) {
    db_iframe_excluialterarplaca.hide();

    const params = {
      exec: 'buscarAlteracao',
      codigo: ve76_sequencial
    };

    alterarPlacaRPC(params, preencheForm, "Carregando dados da alteração.");
  }

  function preencheForm(res) {
    const {
      status,
      message,
      alterarplaca
    } = JSON.parse(res.responseText);

    if (status !== 1) {
      alert(message);
      js_pesquisaalterarplaca();
      return;
    }

    document.getElementById('ve76_sequencial').value = alterarplaca.ve76_sequencial;
    document.getElementById('ve76_veiculo').value = alterarplaca.ve76_veiculo;
    document.getElementById('ve76_placa').value = alterarplaca.ve76_placa;
    document.getElementById('ve76_placaanterior').value = alterarplaca.ve76_placaanterior;
    document.getElementById('ve76_obs').value = alterarplaca.ve76_obs;
  }

  function js_excluir() {
    const codigo = document.getElementById('ve76_sequencial').value;

    const params = {
      exec: 'excluirAlteracao',
      codigo: codigo
    };

    alterarPlacaRPC(params, retornoExclusao, "Excluíndo alteração de placa.");
  }

  function retornoExclusao(res) {
    const {
      status,
      message
    } = JSON.parse(res.responseText);
    
    alert(message);

    if (status !== 1) {
      return;
    }

    js_pesquisaalterarplaca();
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
</script>