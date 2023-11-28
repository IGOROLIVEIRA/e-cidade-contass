<fieldset id="diariaFieldset" style="overflow:hidden">
  <legend><b>&nbsp;Diárias&nbsp;</b></legend>
  <table>
    <tr>
      <td>
        <b>Viajante:</b>
      </td>
      <td>
        <? db_input("diariaViajante", 43, 1, true, 'text', 3) ?>
      </td>
      <td>
        <b>Matrícula:</b>
      </td>
      <td>
        <? db_input("e140_matricula", 10, 1, true, 'text', 1) ?>
        <b>Cargo:</b>
        <? db_input("e140_cargo", 24, 3, true, 'text', 1) ?>
      </td>
    </tr>
    <tr>
      <td>
        <? db_ancora('Origem:', "js_pesquisaMunicipio(true,'Origem')", 1); ?>
      </td>
      <td>
        <? db_input('diariaOrigemMunicipio', 35, 2, true, 'text', 1, "onkeyup=js_buscaMunicipio('Origem')"); ?>
        <? db_input('diariaOrigemUf', 5, 2, true, 'text', 1); ?>
      </td>
      <td>
        <? db_ancora('Destino:', "js_pesquisaMunicipio(true,'Destino')", 1); ?>
      </td>
      <td colspan=2>
        <? db_input('diariaDestinoMunicipio', 35, 2, true, 'text', 1, "onkeyup=js_buscaMunicipio('Destino')"); ?>
        <? db_input('diariaDestinoUf', 5, 2, true, 'text', 1); ?>
      </td>
    <tr>
      <td id='autocompleteOrigem' colspan=3></td>
      <td id='autocompleteDestino' colspan=3></td>
    </tr>
    <tr>
      <td>
        <b>Data da Autorização:</b>
      </td>
      <td>
        <? db_inputdata("e140_dtautorizacao", "", "", "", true, 'text', 1, 'onchange=js_validaData(e140_dtautorizacao)',"","","none","","",'js_validaData(e140_dtautorizacao)') ?>
        <b>Data Inicial da Viagem:</b>
        <? db_inputdata("e140_dtinicial", "", "", "", true, 'text', 1, 'onchange=js_validaData(e140_dtinicial)',"","","none","","",'js_validaData(e140_dtinicial)') ?>
      </td>      
      <td>
        <b>Data Final da Viagem:</b>
      </td>
      <td>
        <? db_inputdata("e140_dtfinal", "", "", "", true, 'text', 1, 'onchange=js_validaData(e140_dtfinal)',"","","none","","",'js_validaData(e140_dtfinal)') ?>
      </td>
    </tr>
    <tr>
    <td>
        <b>Quantidade de Diárias:</b>
      </td>
      <td>
    <? db_input("e140_qtddiarias", 8, 4, true, 'text', 1, "onchange=js_calculaTotalDiarias()") ?>
        <b>&nbsp;&emsp;Valor Unitário da Diária:</b>
        <? db_input("e140_vrldiariauni", 8, 4, true, 'text', 1, "onchange=js_calculaTotalDiarias()") ?>
      </td>
      <td>
        <b>Valor Total das Diárias:</b>
      </td>
      <td>
        <? db_input("diariaVlrTotal", 8, 4, true, 'text', 3) ?>
      </td>
    </tr>
    </tr>
    <td>
      <b>Transporte:</b>
    </td>
    <td>
      <? db_input("e140_transporte", 43, 2, true, 'text', 1) ?>
    </td>
    <td>
      <b>Valor do Transporte:</b>
    </td>
    <td>
      <? db_input("e140_vlrtransport", 8, 4, true, 'text', 1, "onchange=js_calculaTotalDespesa()") ?>

      <b>Valor Total da Despesa:</b>
      <? db_input("diariaVlrDespesa", 7, 4, true, 'text', 3) ?>
    </td>
    </tr>
  </table>
  <b>&nbsp;Objetivo da Viagem:</b></br>
  <? db_textarea("e140_objetivo", 2, 126, 0, true, 'text', 1) ?>
</fieldset>

<script>
  $('e140_dtautorizacao').size = 8;
  $('e140_dtinicial').size = 8;
  $('e140_dtfinal').size = 8;

  $('diariaViajante').disabled = true;
  $('diariaVlrTotal').disabled = true;
  $('diariaVlrDespesa').disabled = true;

  function js_validaData(campo){
    let dtAutorizacao = $F('e140_dtautorizacao');
    let e140_dtinicial = $F('e140_dtinicial');
    let e140_dtfinal = $F('e140_dtfinal');
    if(js_comparadata(dtAutorizacao, e140_dtinicial, '>')){
      alert('A Data Inicial da Viagem não pode ser maior que a Data da Autorização');
      $(campo).value = '';
    }
    else if(js_comparadata(e140_dtinicial, e140_dtfinal, '>')){
      alert('A Data Final da Viagem não pode ser maior que a Data Inicial da Viagem');
      $(campo).value = '';
    }
  }

  function js_pesquisaMunicipio(lMostra, campo) {

    let sMunicipio = $('diaria' + campo + 'Municipio').value;
    if (sMunicipio == "") {
      $('diaria' + campo + 'Municipio').value = '';
      $('diaria' + campo + 'Uf').value = '';
    }

    let sUrl = '';
    if (campo === 'Origem') {
      sUrl = 'func_ceplocalidades.php?pesquisa_chave=' + sMunicipio + '&funcao_js=parent.js_preencheMunicipioOrigem&origem=liquidacao';
    } else if (campo === 'Destino') {
      sUrl = 'func_ceplocalidades.php?pesquisa_chave=' + sMunicipio + '&funcao_js=parent.js_preencheMunicipioDestino&origem=liquidacao';
    }
    if (lMostra) {
      if (campo === 'Origem') {
        sUrl = 'func_ceplocalidades.php?funcao_js=parent.js_preencheMunicipioOrigemAncora|cp05_sigla|cp05_localidades';
      } else if (campo === 'Destino') {
        sUrl = 'func_ceplocalidades.php?funcao_js=parent.js_preencheMunicipioDestinoAncora|cp05_sigla|cp05_localidades';
      }
    }
    js_OpenJanelaIframe('', 'db_iframe_ceplocalidades', sUrl, 'Pesquisar Municipios', lMostra);
  }

  function js_preencheMunicipioOrigem(sSigla, lErro) {
    if (!lErro) {
      $('diariaOrigemUf').value = sSigla;
      $('diariaOrigemMunicipio').value = $('diariaOrigemMunicipio').value.toUpperCase();
    } else {
      $('diariaOrigemMunicipio').value = '';
    }
  }

  function js_preencheMunicipioDestino(sSigla, lErro) {
    if (!lErro) {
      $('diariaDestinoUf').value = sSigla;
      $('diariaDestinoMunicipio').value = $('diariaDestinoMunicipio').value.toUpperCase();
    } else {
      $('diariaDestinoMunicipio').value = '';
    }
  }

  function js_preencheMunicipioOrigemAncora(cp05_sigla, cp05_localidades) {
    db_iframe_ceplocalidades.hide();
    $('diariaOrigemMunicipio').value = cp05_localidades;
    $('diariaOrigemUf').value = cp05_sigla;
  }

  function js_preencheMunicipioDestinoAncora(cp05_sigla, cp05_localidades) {
    db_iframe_ceplocalidades.hide();
    $('diariaDestinoMunicipio').value = cp05_localidades;
    $('diariaDestinoUf').value = cp05_sigla;
  }

  function js_buscaMunicipio(campo) {
    let inputCodigo = $('diaria' + campo + 'Uf').id
    let inputField = $('diaria' + campo + 'Municipio').id
    let ulField = 'autocomplete' + campo;
    buscaMunicipioAutoComplete(inputField, inputCodigo, ulField, $('diaria' + campo + 'Municipio').value);
  }

  function buscaMunicipioAutoComplete(inputField, inputCodigo, ulField, chave) {
    var oParam = new Object();
    oParam.exec = "verificaMunicipioAutoComplete";
    oParam.iChave = chave;
    oParam.inputField = inputField;
    oParam.inputCodigo = inputCodigo;
    oParam.ulField = ulField;
    if (oParam.iChave.length >= 3) {
      js_divCarregando("Aguarde, verificando municipio...", "msgBox");
    }
    if (oParam.iChave.length >= 3) {
      let oAjax = new Ajax.Request("pro4_ceplocalidades.RPC.php", {
        method: 'post',
        parameters: 'json=' + Object.toJSON(oParam),
        onComplete: fillAutoComplete
      });
    };
  }

  function fillAutoComplete(oAjax) {
    js_removeObj("msgBox");
    require_once('scripts/classes/autocomplete/AutoComplete.js');
    performsAutoComplete(oAjax);
  }

  function js_calculaTotalDiarias() {
    let qtdDiaria = $('e140_qtddiarias').value != '' ? parseFloat($('e140_qtddiarias').value) : 0;
    let vlrUnitario = $('e140_vrldiariauni').value != '' ? parseFloat($('e140_vrldiariauni').value) : 0;
    $('diariaVlrTotal').value = qtdDiaria * vlrUnitario;
    js_calculaTotalDespesa();
  }

  function js_calculaTotalDespesa() {
    let vlrTotal = $('diariaVlrTotal').value != '' ? parseFloat($('diariaVlrTotal').value) : 0;
    let vlrTransporte = $('e140_vlrtransport').value != '' ? parseFloat($('e140_vlrtransport').value) : 0;
    $('diariaVlrDespesa').value = vlrTotal + vlrTransporte;
  }

</script>