<fieldset id="diariaFieldset" style="overflow:hidden">
  <legend><b>&nbsp;Diárias&nbsp;</b></legend>
  <table>
    <tr>
      <td>
        <b>Viajante:</b>
      </td>
      <td>
        <? db_input("diariaViajante", 45, 1, true, 'text', 3) ?>
        <b>&nbsp;Matrícula:</b>
        <? db_input("e140_matricula", 10, 1, true, 'text', 1) ?>
        <b>Cargo:</b>
        <? db_input("e140_cargo", 26, 3, true, 'text', 1) ?>
      </td>
    </tr>
    <tr></tr>
    <tr>
      <td>
        <? db_ancora('Origem:', "js_pesquisaMunicipio(true,'Origem')", 1); ?>
      </td>
      <td>
        <? db_input('diariaOrigemMunicipio', 36, 2, true, 'text', 1, "onkeyup=js_buscaMunicipio('Origem')"); ?>
        <? db_input('diariaOrigemUf', 6, 2, true, 'text', 1); ?>
        <? db_ancora('Destino:', "js_pesquisaMunicipio(true,'Destino')", 1); ?>
        <? db_input('diariaDestinoMunicipio', 38, 2, true, 'text', 1, "onkeyup=js_buscaMunicipio('Destino')"); ?>
        <? db_input('diariaDestinoUf', 6, 2, true, 'text', 1); ?>
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
        <? db_inputdata("e140_dtautorizacao", "", "", "", true, 'text', 1, 'onchange=js_validaData(e140_dtautorizacao)', "", "", "none", "", "", 'js_validaData(e140_dtautorizacao)') ?>
        <b>Data Inicial da Viagem:</b>
        <? db_inputdata("e140_dtinicial", "", "", "", true, 'text', 1, 'onchange=js_validaData(e140_dtinicial)', "", "", "none", "", "", 'js_validaData(e140_dtinicial)') ?>
        <b>Hora:</b>
        <?db_input('e140_horainicial',5,3,1,'text',1,"onkeydown=js_mascaraHora(this.value,this.id)","","","",5)?>
        <b>Data Final da Viagem:</b>
        <? db_inputdata("e140_dtfinal", "", "", "", true, 'text', 1, 'onchange=js_validaData(e140_dtfinal)', "", "", "none", "", "", 'js_validaData(e140_dtfinal)') ?>
        <b>Hora:</b>
        <?db_input('e140_horafinal',5,3,1,'text',1,"onkeydown=js_mascaraHora(this.value,this.id)","","","",5)?>
      </td>
    </tr>
    <tr></tr>
    <tr>
      <td>
        <b>Quantidade de Diárias:</b>
      </td>
      <td>
        <? db_input("e140_qtddiarias", 8, 4, true, 'text', 1, "onchange=js_calculaTotal('e140_qtddiarias','e140_vrldiariauni','diariaVlrTotal')") ?>
        <b style='margin-left: 22px'>Valor Unitário da Diária:</b>
        <? db_input("e140_vrldiariauni", 8, 4, true, 'text', 1, "onchange=js_calculaTotal('e140_qtddiarias','e140_vrldiariauni','diariaVlrTotal')") ?>
        <b style='margin-left: 53px'>Valor Total das Diárias:</b>
        <? db_input("diariaVlrTotal", 8, 4, true, 'text', 3) ?>
      </td>
    </tr>
    <tr></tr>
    <tr>
      <td>
        <b>Quantidade de Diárias Pernoite:</b>
      </td>
      <td>
        <? db_input("e140_qtddiariaspernoite", 8, 4, true, 'text', 1, "onchange=js_calculaTotal('e140_qtddiariaspernoite','e140_vrldiariaspernoiteuni','diariaPernoiteVlrTotal')") ?>
        <b style='margin-left: 22px'>Valor Unitário da Diária Pernoite:</b>
        <? db_input("e140_vrldiariaspernoiteuni", 8, 4, true, 'text', 1, "onchange=js_calculaTotal('e140_qtddiariaspernoite','e140_vrldiariaspernoiteuni','diariaPernoiteVlrTotal')") ?>
        <b style='margin-left: 53px'>Valor Total das Diárias Pernoite:</b>
        <? db_input("diariaPernoiteVlrTotal", 8, 4, true, 'text', 3) ?>
      </td>
    </tr>
    <tr></tr>
    <tr>
      <td>
        <b>Quantidade de Hospedagens:</b>
      </td>
      <td>
        <? db_input("e140_qtdhospedagens", 8, 4, true, 'text', 1, "onchange=js_calculaTotal('e140_qtdhospedagens','e140_vrlhospedagemuni','hospedagemVlrTotal')") ?>
        <b style='margin-left: 22px'>Valor Unitário da Hospedagem:</b>
        <? db_input("e140_vrlhospedagemuni", 8, 4, true, 'text', 1, "onchange=js_calculaTotal('e140_qtdhospedagens','e140_vrlhospedagemuni','hospedagemVlrTotal')") ?>
        <b style='margin-left: 53px'>Valor Total das Hospedagens:</b>
        <? db_input("hospedagemVlrTotal", 8, 4, true, 'text', 3) ?>
      </td>
    </tr>
    <tr></tr>
    <tr>
      <td>
        <b>Transporte:</b>
      </td>
      <td>
        <? db_input("e140_transporte", 21, 2, true, 'text', 1) ?>
        <b>Valor do Transporte:</b>
        <? db_input("e140_vlrtransport", 8, 4, true, 'text', 1, "onchange=js_calculaTotalDespesa()") ?>
        <b style='margin-left: 53px'>Valor Total da Despesa:</b>
        <? db_input("diariaVlrDespesa", 8, 4, true, 'text', 3) ?>
      </td>
    </tr>
    <tr></tr>
  </table>
  <b>&nbsp;Objetivo da Viagem:</b></br>
  <? db_textarea("e140_objetivo", 2, 130, 0, true, 'text', 1) ?>
</fieldset>

<script>
  $('e140_dtautorizacao').size = 8;
  $('e140_dtinicial').size = 8;
  $('e140_dtfinal').size = 8;

  $('e140_vrldiariauni').style.marginLeft = '52px';
  $('e140_vrlhospedagemuni').style.marginLeft = '10px';
  $('e140_vlrtransport').style.marginLeft = '2px';
  $('diariaVlrTotal').style.marginLeft = '50px';
  $('hospedagemVlrTotal').style.marginLeft = '12px';
  $('diariaVlrDespesa').style.marginLeft = '48px';

  $('diariaViajante').disabled = true;
  $('diariaVlrTotal').disabled = true;
  $('diariaVlrDespesa').disabled = true;
  $('hospedagemVlrTotal').disabled = true;
  $('diariaPernoiteVlrTotal').disabled = true;

  $('e140_horainicial').addEventListener('blur', function () {js_validaHora('e140_horainicial')});
  $('e140_horafinal').addEventListener('blur', function () {js_validaHora('e140_horafinal')});

  function js_validaData(campo) {
    let dtAutorizacao = $F('e140_dtautorizacao');
    let e140_dtinicial = $F('e140_dtinicial');
    let e140_dtfinal = $F('e140_dtfinal');
    if (js_comparadata(dtAutorizacao, e140_dtinicial, '>')) {
      alert('A Data Inicial da Viagem não pode ser maior que a Data da Autorização');
      $(campo).value = '';
    } else if (js_comparadata(e140_dtinicial, e140_dtfinal, '>')) {
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

  function js_calculaTotal(campoQtd, campoVlrUni, campoTotal) {
    let qtd = $(campoQtd).value != '' ? parseFloat($(campoQtd).value) : 0;
    let vlrUnitario = $(campoVlrUni).value != '' ? parseFloat($(campoVlrUni).value) : 0;
    $(campoTotal).value = (qtd * vlrUnitario).toFixed(2);
    js_calculaTotalDespesa();
  }

  function js_calculaTotalDespesa() {
    let vlrTotalDiaria = $('diariaVlrTotal').value != '' ? parseFloat($('diariaVlrTotal').value) : 0;
    let vlrTotalDiariaPernoite = $('diariaPernoiteVlrTotal').value != '' ? parseFloat($('diariaPernoiteVlrTotal').value) : 0;
    let vlrTotalHospedagem = $('hospedagemVlrTotal').value != '' ? parseFloat($('hospedagemVlrTotal').value) : 0;
    let vlrTransporte = $('e140_vlrtransport').value != '' ? parseFloat($('e140_vlrtransport').value) : 0;
    $('diariaVlrDespesa').value = (vlrTotalDiaria + vlrTransporte + vlrTotalHospedagem + vlrTotalDiariaPernoite).toFixed(2);
  }

  function js_mascaraHora(hora,id){
    let horaMascara = '';
    horaMascara = horaMascara + hora;
    if(horaMascara.length == 2){
      horaMascara = horaMascara + ':';
      $(id).value = horaMascara;
    }
  }

  function js_validaHora(id){
    let hora = $(id).value;
    if (hora.length < 5 || hora.length > 5 ){
      alert("Hora inválida! Preencha corretamente o campo!");
      $(id).value = "";
      $(id).focus();
    }else{
      let hrs = (hora.substring(0,2));
      let min = (hora.substring(3,5));
      if ( (hrs < 0 ) || (hrs > 23) || ( min < 0) || ( min > 59) || (/\D/.test(hrs)) || (/\D/.test(min))) {
        alert("Hora inválida! Preencha corretamente o campo!");
        $(id).value="";
        $(id).focus();
      }
    }
  }

  function js_verificaHora(id){
    let hrs = ($(id).value.substring(0,2));
    let min = ($(id).value.substring(3,5));
    if ( (hrs < 0 ) || (hrs > 23) || ( min < 0) || ( min > 59) || (/\D/.test(hrs)) || (/\D/.test(min))) {
      alert("Hora inválida! Preencha corretamente o campo!");
      $(id).value="";
      $(id).focus();
    }
  }

  function js_separaMunicipio(municipio){
    if (municipio != '') {
      const separador = / *-/;
      const aString = municipio.split(separador);
      return aString;
    }else{
      return false;
    }
  }

  function js_preencheCampos(oAjax){
    obj  = eval("("+oAjax.responseText+")");
    const desdobramentoDiaria = obj.sDesdobramento.substr(5, 2);
    $('desdobramentoDiaria').value = desdobramentoDiaria;
    if((desdobramentoDiaria == '14' || desdobramentoDiaria == '33')){
      $('diariaFieldset').style.display = 'table-cell';
      if(obj.oDiaria != null){
        const oDiaria = obj.oDiaria;
        const aOrigem = js_separaMunicipio(oDiaria.e140_origem);
        const aDestino = js_separaMunicipio(oDiaria.e140_destino);
        $('salvarDiaria').value = 1;
        $('e140_sequencial').value            = oDiaria.e140_sequencial;
        $('diariaViajante').value             = oDiaria.z01_nome;
        $('e140_matricula').value             = oDiaria.e140_matricula;
        $('e140_cargo').value                 = oDiaria.e140_cargo;
        $('e140_dtautorizacao').value         = converterData(oDiaria.e140_dtautorizacao);
        $('e140_dtinicial').value             = converterData(oDiaria.e140_dtinicial);
        $('e140_dtfinal').value               = converterData(oDiaria.e140_dtfinal);
        $('e140_horainicial').value           = oDiaria.e140_horainicial;
        $('e140_horafinal').value             = oDiaria.e140_horafinal;
        $('diariaOrigemMunicipio').value      = aOrigem ? aOrigem[0].trim() : '';
        $('diariaOrigemUf').value             = aOrigem ? aOrigem[1].trim() : '';
        $('diariaDestinoMunicipio').value     = aDestino ? aDestino[0].trim() : '';
        $('diariaDestinoUf').value            = aDestino ? aDestino[1].trim() : '';
        $('e140_qtddiarias').value            = oDiaria.e140_qtddiarias;
        $('e140_vrldiariauni').value          = oDiaria.e140_vrldiariauni;
        $('diariaVlrTotal').value             = (oDiaria.e140_qtddiarias * oDiaria.e140_vrldiariauni).toFixed(2);
        $('e140_qtddiariaspernoite').value    = oDiaria.e140_qtddiariaspernoite;
        $('e140_vrldiariaspernoiteuni').value = oDiaria.e140_vrldiariaspernoiteuni;
        $('diariaPernoiteVlrTotal').value     = (oDiaria.e140_qtddiariaspernoite * oDiaria.e140_vrldiariaspernoiteuni).toFixed(2);
        $('e140_qtdhospedagens').value        = oDiaria.e140_qtdhospedagens;
        $('e140_vrlhospedagemuni').value      = oDiaria.e140_vrlhospedagemuni;
        $('hospedagemVlrTotal').value         = (oDiaria.e140_qtdhospedagens * oDiaria.e140_vrlhospedagemuni).toFixed(2);         
        $('e140_transporte').value            = oDiaria.e140_transporte;
        $('e140_vlrtransport').value          = oDiaria.e140_vlrtransport;    
        $('e140_objetivo').value              = oDiaria.e140_objetivo;
        js_calculaTotalDespesa()
      }else{
        $('salvarDiaria').value = 2;
        var elementos = $('diariaFieldset').querySelectorAll('input, textarea');
        elementos.forEach(function(elemento) {
          if(elemento.id.substring(0,4) != 'dtjs'){
            elemento.value = '';
            elemento.addEventListener("change", function() {
              $('salvarDiaria').value = 1;
            });
            js_pesquisaViajante(obj.e60_numcgm);
          }else{
            elemento.addEventListener("click", function() {
              $('salvarDiaria').value = 1;
            });
          }
        });
      }
    }else{
      $('diariaFieldset').style.display = 'none';
    }      
  }

  function js_pesquisaDiaria(iCodord, iNumemp){
    let oParam = new Object();
    oParam.exec = 'pesquisaDiaria';
    oParam.iCodord = iCodord;
    oParam.iNumemp = iNumemp;
    let oAjax = new Ajax.Request("emp4_empdiaria.RPC.php", {
        method: 'post',
        parameters: 'json=' + Object.toJSON(oParam),
        onComplete: js_preencheCampos
      });
  }

  function js_pesquisaViajante(e60_numcgm){
    let oParam        = new Object();
    oParam.exec       = 'consultaMatricula';
    oParam.iNumCgm    = e60_numcgm;
    console.log(e60_numcgm)
    oAjax    = new Ajax.Request(
                            'pes1_rhpessoal.RPC.php',
                              {
                              method: 'post',
                              parameters: 'json='+Object.toJSON(oParam),
                              onComplete: function(oAjax){
                                oRetorno = eval("("+oAjax.responseText+")");
                                if(oRetorno.iStatus === 1){
                                  $('e140_matricula').value = oRetorno.rh01_regist;
                                  $('e140_cargo').value = oRetorno.rh37_descr;
                                  $('diariaViajante').value = oRetorno.z01_nome;
                                }
                              }
                              }
                            );
  }
</script>