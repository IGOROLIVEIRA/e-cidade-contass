<?
  $clrotulo = new rotulocampo;
  $clrotulo->label("ve82_veiculo");
  $clrotulo->label("ve82_datareativacao");
  $clrotulo->label("ve82_obs");
?>
<style>
  .title {
    font-weight: bold;
  }
</style>
<form name="form1" method="post">
  <fieldset style="max-width: 510px; margin-top: 20px;">
    <legend>Reativação de Veículos</legend>
    <table border="0">
      <tr>
        <td class="title">
          <?
            db_ancora($Lve82_veiculo, "js_pesquisaveiculobaixa()", $db_opcao);
          ?>
        </td>
        <td>
          <? db_input('ve82_veiculo', 12, $ve82_veiculo, true, 'text', 3, ""); ?>
        </td>
        <td style="text-align: right;">
          <span class="title"><?=$Lve82_datareativacao?></span>
          <?
          if (!isset($ve76_data)) {
            $ve82_data_dia = date('d', db_getsession("DB_datausu"));
            $ve82_data_mes = date('m', db_getsession("DB_datausu"));
            $ve82_data_ano = date('Y', db_getsession("DB_datausu"));
          }
          db_inputdata('ve82_datareativacao', @$ve82_data_dia, @$ve82_data_mes, @$ve82_data_ano, true, 'text', $db_opcao);
          ?>
        </td>
      </tr>
      <tr>
        <td class="title" colspan="3"><?=$Lve82_obs?></td>
      </tr>
      <tr>
        <td colspan="3">
          <? db_textarea('ve82_obs', 8, 70, $Ive82_obs, true, 'text', $db_opcao, 'onkeyup="js_limpaCaracteresEspeciais(this, /[^a-zA-Z0-9áéíóúãõâêîôûçÁÉÍÓÚÃÕÂÊÎÔÛÇ .,]/g)"', "", "", 200); ?>
        </td>
      </tr>
    </table>
  </fieldset>
  <div style="margin-top: 20px;">
    <input id="processar" type="button" value="Processar" name="processar" onclick="js_processar()">
    <input id="pesquisar" type="button" value="Pesquisar" name="pesquisar" onclick="js_pesquisaveiculobaixa()">
  </div>
</form>

<script>
  (function() {
      document.addEventListener('DOMContentLoaded', js_pesquisaveiculobaixa);
  })();

  function js_pesquisaveiculobaixa() {
    js_OpenJanelaIframe('top.corpo', 'db_iframe_veiculos', 'func_veiculosalt.php?&baixa=0&funcao_js=parent.js_retornoPesquisa|ve01_codigo', 'Pesquisa', true);
  }

  function js_retornoPesquisa(ve01_codigo) {
    db_iframe_veiculos.hide();
    document.getElementById('ve82_veiculo').value = ve01_codigo;
    document.getElementById('ve82_datareativacao').value = getCurrentDateFormatted();
    document.getElementById('ve82_obs').value = "";
    document.getElementById('ve82_obsobsdig').value = "0";

  }
  
  function js_processar() {
    const campoVe82_veiculo = document.getElementById('ve82_veiculo');
    const campoVe82_datareativacao = document.getElementById('ve82_datareativacao');
    const campoVe82_obs = document.getElementById('ve82_obs');

    if (campoVe82_veiculo.value == null || campoVe82_veiculo.value.trim() === "") {
      alert('Usuário: Antes de processar é necessário selecionar uma baixa.');
      return;
    }

    if (!validateInput(campoVe82_datareativacao, "É necessário informar a data da reativação.")) {
      return;
    }

    if (!validateInput(campoVe82_obs, "É necessário informar o campo observação.")) {
      return;
    }

    const params = {
      exec: 'reativarVeiculo',
      dados: {
        ve82_veiculo: campoVe82_veiculo.value,
        ve82_datareativacao: campoVe82_datareativacao.value,
        ve82_obs: campoVe82_obs.value,
      }
    };
    veiculoBaixaRPC(params, processaRetorno, "Salvando alteração.");

  }

  function processaRetorno(res) {
    const {
      status,
      message
    } = JSON.parse(res.responseText);

    alert(message);

    if (status !== 1) {
      return;
    }

    document.getElementById('ve82_veiculo').value = "";
    document.getElementById('ve82_datareativacao').value = getCurrentDateFormatted();
    document.getElementById('ve82_obs').value = "";

    js_pesquisaveiculobaixa();
  }

  function veiculoBaixaRPC(params, callback, loadingMessage) {
    const endpoint = 'vei1_veicbaixa.RPC.php';
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

  function js_limpaCaracteresEspeciais(campo, reg = /[^a-zA-Z0-9]/g) {
    campo.value = campo.value.replace(reg, '');
  };

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

  function getCurrentDateFormatted() {
    const now = new Date();
    const day = String(now.getDate()).padStart(2, '0');
    const month = String(now.getMonth() + 1).padStart(2, '0'); // January is 0!
    const year = now.getFullYear();

    return `${day}/${month}/${year}`;
}

</script>