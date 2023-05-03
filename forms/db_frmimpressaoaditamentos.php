<form class="container" style="width: 800px; margin-top:40px;" name="form1" method="post" action="<?= $db_action ?>">
  <fieldset>
    <legend>Informe o acordo</legend>
    <table class="form-container">
      <tr>
        <td nowrap title="Acordo" width="130">
          <?php db_ancora("Cód. Acordo:", "js_acordo(true);", 1); ?>
        </td>
        <td colspan="2">
          <?php
          db_input('ac16_sequencial', 10, $Iac16_sequencial, true, 'text', 1, "onchange='js_acordo(false);'");
          db_input('ac16_resumoobjeto', 80, $Iac16_resumoobjeto, true, 'text', 3);
          ?>
        </td>
      </tr>

    </table>

  </fieldset>

  <table>
    <tr>
      <td>
        <fieldset>
          <legend>Aditamentos</legend>
          <div id='ctnGridItens' style="width: 800px"></div>
        </fieldset>
      </td>
    </tr>
  </table>

  <input name="Imprimir" type="button" value="Imprimir" onclick="js_imprimir();">

</form>
<script>
  var sUrlRpc = 'con4_contratosmovimentacoesfinanceiras.RPC.php';

  oGridItens = new DBGrid('oGridItens');
  oGridItens.setCheckbox(0);
  oGridItens.nameInstance = 'oGridItens';
  oGridItens.setCellAlign(['center', 'center', 'center', 'center']);
  oGridItens.setCellWidth(["0%", "30%", "30%", "40%", ]);
  oGridItens.setHeader(["Codigo", "Número do Aditamento", "Tipo", "Data de Assinatura"]);
  oGridItens.aHeaders[1].lDisplayed = false;

  oGridItens.setHeight(200);
  oGridItens.show($('ctnGridItens'));

  function js_acordo(mostra) {

    if (mostra == true) {
      js_OpenJanelaIframe('', 'db_iframe_acordo',
        'func_acordo.php?aditamentos=true&funcao_js=parent.js_mostraAcordo1|ac16_sequencial|ac16_resumoobjeto',
        'Pesquisa', true);
      return;
    }

    if ($F('ac16_sequencial').trim() != '') {
      js_OpenJanelaIframe('', 'db_iframe_depart',
        'func_acordo.php?pesquisa_chave=' + $F('ac16_sequencial') + '&funcao_js=parent.js_mostraAcordo' +
        '&descricao=true&aditamentos=true',
        'Pesquisa', false);
      return;
    }

    $('ac16_resumoobjeto').value = '';
    oGridItens.clearAll(true);

  }

  function js_mostraAcordo(chave, descricao, erro) {

    js_pesquisarPosicoesContrato();
    $('ac16_resumoobjeto').value = descricao;
    if (erro == true) {
      $('ac16_sequencial').focus();
      $('ac16_sequencial').value = '';
    }

  }

  function js_mostraAcordo1(chave1, chave2) {

    $('ac16_sequencial').value = chave1;
    $('ac16_resumoobjeto').value = chave2;
    db_iframe_acordo.hide();
    js_pesquisarPosicoesContrato();

  }

  function js_pesquisarPosicoesContrato() {

    js_divCarregando('Aguarde, pesquisando dados do acordo', 'msgbox');

    var oParam = new Object();
    oParam.exec = 'getAditamentos';
    oParam.iAcordo = $('ac16_sequencial').value;
    var oAjax = new Ajax.Request(sUrlRpc, {
      method: 'post',
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoGetPosicoesAcordo
    })

  }

  function js_retornoGetPosicoesAcordo(oAjax) {

    js_removeObj('msgbox');
    oGridItens.clearAll(true);
    var oRetorno = eval("(" + oAjax.responseText + ")");

    if (oRetorno.status == 1) {

      oRetorno.posicoes.each(function(oPosicao, iLinha) {

        var aLinha = new Array();
        aLinha[0] = oPosicao.codigo;
        aLinha[1] = oPosicao.numero;
        aLinha[2] = oPosicao.tipo + ' - ' + oPosicao.descricaotipo.urlDecode();
        aLinha[3] = oPosicao.data;
        oGridItens.addRow(aLinha);

      });
      oGridItens.renderRows();
    }
  }

  function js_imprimir() {
    var aListaCheckbox = oGridItens.getSelection();
    if (aListaCheckbox.length == 0) return alert('Nenhum aditamento selecionado !')

    var aditamentos = "";

    aListaCheckbox.each(function(aRow) {
      aditamentos += aRow[1] + ",";
    });

    acordo = document.getElementById('ac16_sequencial').value;
    jan = window.open('aco2_impressaoaditamentos002.php?ac16_acordo=' + acordo + '&aditamentos=' + aditamentos.substring(0, aditamentos.length - 1), '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
    jan.moveTo(0, 0);

  }
</script>