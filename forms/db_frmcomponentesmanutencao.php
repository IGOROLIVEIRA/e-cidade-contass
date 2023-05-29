<form class="container" style="width: 800px;" name="form1" method="post" action="<?= $db_action ?>">
  <fieldset>
    <legend>Componentes</legend>
    <table class="form-container">
      <tr>
        <td>
          Item do Sistema:
        </td>
        <td>
          <?
          $aItemSistema  = array('Selecione', 'Sim', 'Não');
          db_select('t99_itemsistema', $aItemSistema, true, 1, "style='width: 80px;' onchange='js_selectitemsistema(false)'"); ?>
        </td>
      </tr>

      <tr>
        <td>
          <a id="descricao">Descrição:</a>
          <a id="descricaoancora" href="#" class="dbancora" style="text-decoration:underline; display:none" onclick="js_pesquisa_bem();">Descrição:</a>
        </td>
        <td>
          <?
          db_input('t99_descricao', 110, 5, true, 'text', 1, "");
          ?>
        </td>
      </tr>

      <?
      db_input('t99_codbensdispensatombamento', 110, 5, true, 'hidden', 1);
      db_input('t99_sequencial', 110, 5, true, 'hidden', 1);
      ?>

      <tr>
        <td>
          Valor:
        </td>
        <td>
          <?
          db_input('t99_valor', 8, 4, true, 'text', 1, "");

          ?>
        </td>
    </table>
    <input name="<?= ($db_opcao == 1 ? "inserir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Inserir" : ($db_opcao == 2 || $db_opcao == 22 ? "Salvar" : "Salvar")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>

  </fieldset>

  <table>
    <tr>
      <td>
        <fieldset>
          <legend>Componentes/Itens</legend>
          <div id='ctnGridItens' style="width: 1000px"></div>
        </fieldset>
      </td>
    </tr>
  </table>

  <?php
  if ($cl_manutbensitem->erro_status != "0") {
    echo "
      <script>
      document.getElementById('t99_itemsistema').value = 0;
      document.getElementById('t99_descricao').value = '';
      document.getElementById('t99_valor').value = '';
      document.getElementById('t99_sequencial').value = '';
       </script>";
  }
  ?>

</form>
<script>
  oGridItens = new DBGrid('oGridItens');
  oGridItens.nameInstance = 'oGridItens';
  oGridItens.setCellAlign(['center', 'center', 'center', 'center', 'center', 'center', 'center', 'center', 'center']);
  oGridItens.setCellWidth(["0%", "0%", "10%", "15%", "45%", "15%", "15%"]);
  oGridItens.setHeader(["Cod Dispensa", "Sequencial", "Item do Sistema", "Codigo do Item", "Descrição", "Valor", "Ação"]);
  oGridItens.aHeaders[0].lDisplayed = false;
  oGridItens.aHeaders[1].lDisplayed = false;
  oGridItens.setHeight(200);
  oGridItens.show($('ctnGridItens'));

  var sUrl = "com4_materialsolicitacao.RPC.php";

  var oRequest = new Object();
  oRequest.t98_sequencial = CurrentWindow.corpo.iframe_manutencao.document.form1.t98_sequencial.value;
  oRequest.exec = "getItens";
  var oAjax = new Ajax.Request(
    "com4_manutbensitem.RPC.php", {
      method: 'post',
      parameters: 'json=' + js_objectToJson(oRequest),
      onComplete: js_retornogetItens
    }
  );

  function js_retornogetItens(oAjax) {
    var oRetorno = eval("(" + oAjax.responseText + ")");
    oGridItens.clearAll(true);

    var aLinha = new Array();
    for (var i = 0; i < oRetorno.aItens.length; i++) {
      aLinha[0] = " <input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='sequencial[]' value='" + oRetorno.aItens[i].t99_sequencial + "'>"
      aLinha[1] = " <input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='codbensdispensatombamento[]' value='" + oRetorno.aItens[i].t99_codbensdispensatombamento + "'>"
      aLinha[2] = " <input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='itemdosistema[]' value='" + oRetorno.aItens[i].t99_itemsistema.urlDecode() + "'>"
      aLinha[3] = " <input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='codmaterial[]' value='" + oRetorno.aItens[i].t99_codpcmater + "'>"
      aLinha[4] = " <input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='descricao[]' value='" + oRetorno.aItens[i].t99_descricao.urlDecode() + "'>"
      aLinha[5] = " <input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='valor[]' value='" + oRetorno.aItens[i].t99_valor + "'>";
      aLinha[6] = "<input  type='button' value='A'  onclick='js_alterar(" + i + ")'> <input type='button' name='excluir' value='E' onclick='js_excluir(" + i + ")'>";
      oGridItens.addRow(aLinha);
    }

    oGridItens.renderRows();

  }

  function js_pesquisa_bem(mostra) {
    js_OpenJanelaIframe('', 'db_iframe_bens', 'func_bensdispensados.php?funcao_js=parent.js_mostrabem|e139_sequencial|pc01_descrmater', 'Pesquisa', true);
  }

  function js_mostrabem(e139_sequencial, pc01_descrmater) {
    document.form1.t99_codbensdispensatombamento.value = e139_sequencial;
    document.form1.t99_descricao.value = pc01_descrmater;
    db_iframe_bens.hide();
  }

  function js_selectitemsistema() {
    if (document.getElementById('t99_itemsistema').value == 1) {
      oAutoComplete = new dbAutoComplete(document.getElementById('t99_descricao'), 'com4_pesquisabemdispensatombamento.RPC.php');
      oAutoComplete.setTxtFieldId(document.getElementById('t99_codbensdispensatombamento'));
      oAutoComplete.show();
      document.getElementById('descricao').style.display = 'none';
      document.getElementById('descricaoancora').style.display = '';
      return true;
    }
    document.getElementById('descricao').style.display = '';
    document.getElementById('descricaoancora').style.display = 'none';
    document.getElementById('div_lista_t99_descricao').remove();
  }


  function js_alterar(indice) {
    document.getElementById('t99_descricao').value = document.getElementsByName("descricao[]")[indice].value;
    document.getElementById('t99_valor').value = document.getElementsByName("valor[]")[indice].value;
    document.getElementById('t99_itemsistema').value = document.getElementsByName("itemdosistema[]")[indice].value == 'Sim' ? 1 : 2;
    document.getElementById('t99_itemsistema').disabled = true;
    document.getElementById('t99_sequencial').value = document.getElementsByName("sequencial[]")[indice].value;
    document.getElementById('t99_codbensdispensatombamento').value = document.getElementsByName("codbensdispensatombamento[]")[indice].value;
    document.getElementById('db_opcao').value = 'Salvar';
    document.getElementById('db_opcao').name = 'alterar';
    js_selectitemsistema();
  }

  function js_excluir(indice) {
    document.getElementById('t99_descricao').value = document.getElementsByName("descricao[]")[indice].value;
    document.getElementById('t99_valor').value = document.getElementsByName("valor[]")[indice].value;
    document.getElementById('t99_itemsistema').value = document.getElementsByName("itemdosistema[]")[indice].value == 'Sim' ? 1 : 2;
    document.getElementById('t99_descricao').disabled = true;
    document.getElementById('t99_valor').disabled = true;
    document.getElementById('t99_itemsistema').disabled = true;
    document.getElementById('t99_sequencial').value = document.getElementsByName("sequencial[]")[indice].value;
    document.getElementById('db_opcao').value = 'Excluir';
    document.getElementById('db_opcao').name = 'excluir';
  }
</script>