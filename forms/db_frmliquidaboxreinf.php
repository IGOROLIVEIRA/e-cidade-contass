<? db_app::load("strings.js"); ?>

<style>
  .cabecTableEstabelecimento {
    font-size: 10;
    color: darkblue;
    background-color: #aacccc;
    border: none;
    width: 90px;
    text-align: center;
  }

  .cabecTableEstabelecimentoNome {
    font-size: 10;
    color: darkblue;
    background-color: #aacccc;
    border: none;
    width: 400px;
    text-align: center;
  }

  .corpoTableEstabelecimento {
    font-size: 10;
    color: black;
    background-color: #ccddcc;
    width: 90px;
    text-align: center;
  }

  .corpoTableEstabelecimentoNome {
    font-size: 10;
    color: black;
    background-color: #ccddcc;
    width: 400px;
    text-align: center;
  }

  .anchorEstabelecimento{
    text-decoration: none;
    color: blue;
    font-weight: bold;
  }

  .anchorEstabelecimento:active {
    color: black;
    font-weight: bold;
  }

  .anchorEstabelecimento:hover {
    color: black;
  }
</style>

<fieldset id='reinf'>
  <legend><b>Efd-Reinf</b></legend>
  <table>
    <tr>
      <td><strong>Incide Retenção do Imposto de Renda:</strong></td>
      <td>
        <?
        $aReinfRetencao = array('0' => 'Selecione', 'sim' => 'Sim', 'nao' => 'Não');
        db_select('reinfRetencao', $aReinfRetencao, true, 1,'onchange=js_validarRetencaoIR()');
        ?>
      </td>
    </tr>
    <tr id='linhaNaturezaRendimento'>
      <td><? db_ancora('Natureza do Rendimento:', 'js_pesquisaNatureza(true)', 1); ?></td>
      <td><? db_input('naturezaCod', 10, 1, true, 'text', 1, 'onchange=js_pesquisaNatureza(false)'); ?></td>
      <td><? db_input('naturezaDesc', 81, 0, true, 'text', 1, 'onkeyup=js_buscaNaturezaDescricao(this.value)'); ?></td>
    </tr>
    <tr>
      <td id='autocompleteNatureza'>
      </td>
    </tr>
    <tr id='linhaRetencaoTerceiro'>
      <td><strong>Retenção Realizada por Terceiro:</strong></td>
      <td>
        <?
        $aReinfRetencao = array('0' => 'Não', '1' => 'Sim');
        db_select('reinfRetencaoEstabelecimento', $aReinfRetencao, true, 1, "onchange=js_validarEstabelecimentos()");
        ?>
      </td>
    </tr>
  </table>
  <fieldset id='fieldsetEstabelecimentos'>
    <legend><b>Estabelecimentos</b></legend>
    <table>
      <tr>
        <td>
          <? db_ancora('CGM Estabelecimento:', 'js_pesquisaEstabelecimento(true)', 1); ?>
          <? db_input('estabelecimentoCod', 10, 1, true, 'text', 1, 'onchange=js_pesquisaEstabelecimento(false)'); ?>
          <? db_input('estabelecimentoDesc', 70, 0, true, 'text', 1, 'onkeyup=js_buscaEstabelecimento(this.value)'); ?>
        </td>
      </tr>
      <tr>
        <td id='autocompleteEstabelecimento'>
        </td>
      </tr>
      <tr>
        <td>
          <strong>Valor Bruto:</strong>
          <?
          db_input('estabelecimentoValorBruto', 10, 4, true, 'text', 1,'onchange=js_verificaValores(this.name)');
          ?>
          <strong>Valor Base:</strong>
          <?
          db_input('estabelecimentoValorBase', 10, 4, true, 'text', 1,'onchange=js_verificaValores(this.name)');
          ?>
          <strong>Valor do IR:</strong>
          <?
          db_input('estabelecimentoValorIR', 10, 4, true, 'text', 1,'onchange=js_verificaValores(this.name)');
          ?>
          <?
          db_input('arrayEstabelecimentos',10,0,1,'hidden');
          db_input('arrayEstabelecimentosExcluidos',10,0,1,'hidden');
          ?>
          <input name="Adicionar" type="button" id="estabelecimentoAdicionar" value="Adicionar" onclick="js_adicionarEstabelecimento()">
        </td>
      </tr>
    </table>
    <fieldset id='fieldsetEstabelecimentosIncluir'>
      <legend><b>Estabelecimentos Adicionados</b></legend>
      <table id="estabelecimentosTable" border="1">
        <thead>
          <tr>
            <th class="cabecTableEstabelecimento">CGM Estabelecimento</th>
            <th class="cabecTableEstabelecimentoNome">Nome/Razão Social</th>
            <th class="cabecTableEstabelecimento">Valor Bruto</th>
            <th class="cabecTableEstabelecimento">Valor Base</th>
            <th class="cabecTableEstabelecimento">Valor IR</th>
            <th class="cabecTableEstabelecimento">Ações</th>
          </tr>
        </thead>
        <tbody id="estabelecimentosTableBody">
        </tbody>
      </table>
    </fieldset>
  </fieldset>
</fieldset>

<script>
  let aEstabelecimentos = [];
  let aEstabelecimentosExclusao = [];

  function js_verificaValores(campo){
    let valor = $(campo).value;
    let partes = valor.split('.');
    if(partes.length > 2 || partes[1] && partes[1].length > 2){
      alert('Valor invalido.')
      $(campo).value = '';
    }
  }

  function js_validarRetencaoIR(){
    if ($('reinfRetencao').value == 'sim') {
      $('linhaNaturezaRendimento').style.display = 'table-row';
      $('linhaRetencaoTerceiro').style.display = 'table-row';
    }
    if ($('reinfRetencao').value == 'nao') {
      $('linhaNaturezaRendimento').style.display = 'none';
      $('naturezaCod').value = '';
      $('naturezaDesc').value = '';
      $('linhaRetencaoTerceiro').style.display = 'none';
      $('reinfRetencaoEstabelecimento').value = 0;
      js_validarEstabelecimentos();
    }
  }

  function js_validarEstabelecimentos(apagar = false) {
    if ($('reinfRetencaoEstabelecimento').value == 1) {
      $('fieldsetEstabelecimentos').style.display = 'table-cell';
    }
    if ($('reinfRetencaoEstabelecimento').value == 0 || apagar == true) {
      $('fieldsetEstabelecimentos').style.display = 'none';
      aEstabelecimentos = [];
      aEstabelecimentosExclusao = [];
      $('estabelecimentosTableBody').innerHTML = '';
      if (apagar == true) {
        $('reinfRetencaoEstabelecimento').value = 0;
      }
    }
  }

  function js_adicionarEstabelecimentoTabela(item) {
    const table = $("estabelecimentosTableBody");
    const novoEstabelecimento = table.insertRow();

    const numCgm = novoEstabelecimento.insertCell(0);
    numCgm.innerHTML = item.e102_numcgm;
    numCgm.className = "corpoTableEstabelecimento";

    const nomeEstabelecimento = novoEstabelecimento.insertCell(1);
    nomeEstabelecimento.innerHTML = item.z01_nome;
    nomeEstabelecimento.className = "corpoTableEstabelecimentoNome";

    const vlrBruto = novoEstabelecimento.insertCell(2);
    vlrBruto.innerHTML = item.e102_vlrbruto;
    vlrBruto.className = "corpoTableEstabelecimento";

    const vlrBase = novoEstabelecimento.insertCell(3);
    vlrBase.innerHTML = item.e102_vlrbase;
    vlrBase.className = "corpoTableEstabelecimento";

    const vlrIr = novoEstabelecimento.insertCell(4);
    vlrIr.innerHTML = item.e102_vlrir;
    vlrIr.className = "corpoTableEstabelecimento";

    const opcoes = novoEstabelecimento.insertCell(5);
    opcoes.className = "corpoTableEstabelecimento";
    opcoes.style = "display: flex; justify-content: space-around;"
    const botaoExcluir = document.createElement("a");
    botaoExcluir.className = 'anchorEstabelecimento';
    botaoExcluir.innerHTML = "E";
    botaoExcluir.href = "#";
    botaoExcluir.addEventListener("click", function() {
      js_excluirLinha(novoEstabelecimento.rowIndex - 1, table);
    });
    const botaoAlterar = document.createElement("a");
    botaoAlterar.className = 'anchorEstabelecimento';
    botaoAlterar.innerHTML = "A";
    botaoAlterar.href = "#";
    botaoAlterar.addEventListener("click", function() {
      js_alterarLinha(novoEstabelecimento, table);
    });
    opcoes.appendChild(botaoExcluir)
    opcoes.appendChild(botaoAlterar);
  }

  function js_excluirLinha(numLinha, table){
    let estabelecimentoExcluido = aEstabelecimentos.splice(numLinha, 1);
    aEstabelecimentosExclusao.push(estabelecimentoExcluido[0]);
    $('arrayEstabelecimentosExcluidos').value = JSON.stringify(aEstabelecimentosExclusao);
    table.deleteRow(numLinha);
  }

  function js_alterarLinha(linha, table){
    const numLinha = linha.rowIndex - 1
    $('estabelecimentoCod').value = linha.cells[0].innerHTML;
    $('estabelecimentoDesc').value =  linha.cells[1].innerHTML;
    $('estabelecimentoValorBruto').value =  linha.cells[2].innerHTML;
    $('estabelecimentoValorBase').value =  linha.cells[3].innerHTML;
    $('estabelecimentoValorIR').value =  linha.cells[4].innerHTML;
    aEstabelecimentos.splice(numLinha, 1);
    table.deleteRow(numLinha);
  }

  function js_adicionarEstabelecimento() {
    let numCgm = $('estabelecimentoCod').value;
    let nomeEstabelecimento = $('estabelecimentoDesc').value;
    let vlrBruto = $('estabelecimentoValorBruto').value;
    let vlrBase = $('estabelecimentoValorBase').value;
    let vlrIR = $('estabelecimentoValorIR').value;
    if (numCgm == '' || nomeEstabelecimento == '' || vlrBruto == '' || vlrBase == '' || vlrIR == '') {
      alert("Todos os campos do estabeleciomento são obrigatorios!");
      return;
    }
    if (js_verificaCGM(numCgm)) {
      alert('Este estabelecimento já foi adicionado.');
      return;
    }
    const oNovoEstabelecimento = {
      e102_numcgm: numCgm,
      z01_nome: nomeEstabelecimento,
      e102_vlrbruto: vlrBruto,
      e102_vlrbase: vlrBase,
      e102_vlrir: vlrIR
    };

    aEstabelecimentos.push(oNovoEstabelecimento);
    $('arrayEstabelecimentos').value = JSON.stringify(aEstabelecimentos);
    js_apagaCamposEstabelecimento();
    js_adicionarEstabelecimentoTabela(oNovoEstabelecimento);
  }

  function js_verificaCGM(numCgm) {
    const oEstabelecimento = aEstabelecimentos.find(function(estabelecimento) {
      return estabelecimento.e102_numcgm == numCgm;
    });
    if (oEstabelecimento) {
      return true;
    } else {
      return false;
    }
  }

  function js_apagaCamposEstabelecimento() {
    const aCampos = ['estabelecimentoCod', 'estabelecimentoDesc', 'estabelecimentoValorBruto', 'estabelecimentoValorBase', 'estabelecimentoValorIR']
    for (let i = 0; i < aCampos.length; i++) {
      $(aCampos[i]).value = '';
    }
  }

  function js_pesquisaEstabelecimento(lMostra) {
    let iEstabelecimentoCod = $('estabelecimentoCod').value;

    if (iEstabelecimentoCod == "") {
      $('estabelecimentoCod').value = '';
      $('estabelecimentoDesc').value = '';
    }

    let sUrl = 'func_nome.php?pesquisa_chave=' + iEstabelecimentoCod + '&funcao_js=parent.js_preencheEstabelecimento';
    if (lMostra) {
      sUrl = 'func_nome.php?funcao_js=parent.js_preencheEstabelecimentoAncora|z01_numcgm|z01_nome';
    }

    js_OpenJanelaIframe("", 'db_iframe_cgm', sUrl, "Pesquisa Estabelecimento", lMostra);
  };

  function js_preencheEstabelecimento(lErro, sNome, sCnpj) {

    if (sCnpj.length == 11) {
      if (sCnpj == '00000000000') {
        alert("ERRO: Número do CPF está zerado. Corrija o CGM do estabelecimento e tente novamente");
        return false
      }
    } else {
      if (sCnpj == '' || sCnpj == null) {
        alert("ERRO: Número do CPF está zerado. Corrija o CGM do estabelecimento e tente novamente");
        return false
      }
    }

    if (sCnpj.length == 14) {
      if (sCnpj == '00000000000000') {
        alert("ERRO: Número do CNPJ está zerado. Corrija o CGM do estabelecimento e tente novamente");
        return false
      }
    } else {
      if (sCnpj == '' || sCnpj == null) {
        alert("ERRO: Número do CNPJ está zerado. Corrija o CGM do estabelecimento e tente novamente");
        return false
      }
    }
    var sCnpjTratado = "";
    if (sCnpj != "" && sCnpj != undefined) {
      sCnpjTratado = js_formatar(sCnpj, 'cpfcnpj') + " - ";
    }
    $('estabelecimentoDesc').value = sCnpjTratado + "" + sNome;

    if (lErro) {
      $('estabelecimentoDesc').value = '';
    }
  };

  function js_preencheEstabelecimentoAncora(z01_numcgm, z01_nome) {
    db_iframe_cgm.hide();
    $('estabelecimentoCod').value = z01_numcgm;
    $('estabelecimentoDesc').value = z01_nome;
  }

  function js_pesquisaNatureza(lMostra) {

    let iNaturezaCod = $('naturezaCod').value;

    if (naturezaCod == "") {
      $('naturezaCod').value = '';
      $('naturezaDesc').value = '';
    }

    let sUrl = 'func_naturezabemservico.php?pesquisa_chave=' + iNaturezaCod + '&funcao_js=parent.js_preencheNatureza';
    if (lMostra) {
      sUrl = 'func_naturezabemservico.php?funcao_js=parent.js_preencheNaturezaAncora|e101_codnaturezarendimento|e101_resumo';
    }
    js_OpenJanelaIframe('','db_iframe_naturezabemservico',sUrl,'Pesquisar Natureza',lMostra);
  }

  function js_preencheNatureza(lErro, sDescricao) {
    $('naturezaDesc').value = sDescricao;
    if (lErro) {
      $('naturezaCod').value = '';
    }
  }

  function js_preencheNaturezaAncora(e101_codnaturezarendimento, e101_resumo) {
    db_iframe_naturezabemservico.hide();
    $('naturezaCod').value = e101_codnaturezarendimento;
    $('naturezaDesc').value = e101_resumo;
  }

  function js_buscaNaturezaDescricao() {
    let inputField = $('naturezaDesc').id
    let inputCodigo = $('naturezaCod').id
    let ulField = 'autocompleteNatureza';
    buscaNaturezaAutoComplete(inputField, inputCodigo, ulField, $('naturezaDesc').value);
  }

  function js_buscaEstabelecimento() {
    let inputField = $('estabelecimentoDesc').id
    let inputCodigo = $('estabelecimentoCod').id
    let ulField = 'autocompleteEstabelecimento';
    js_buscaEstabelecimentoAutoComplete(inputField, inputCodigo, ulField, $('estabelecimentoDesc').value);
  }

  function js_buscaEstabelecimentoAutoComplete(inputField, inputCodigo, ulField, chave) {

    var oParam = new Object();
    oParam.exec = "verificaFavorecidoAutoComplete";
    oParam.iDescricao = chave;
    oParam.inputField = inputField;
    oParam.inputCodigo = inputCodigo;
    oParam.ulField = ulField;
    if (oParam.iDescricao.length == 5) {
      js_divCarregando("Aguarde, verificando favorecido...", "msgBox");
    }
    if (oParam.iDescricao.length > 4) {
      let oAjax = new Ajax.Request("con4_planoContas.RPC.php", {
        method: 'post',
        parameters: 'json=' + Object.toJSON(oParam),
        onComplete: fillAutoComplete
      });
    };
  };

  function buscaNaturezaAutoComplete(inputField, inputCodigo, ulField, chave) {

    var oParam = new Object();
    oParam.exec = "verificaNaturezaAutoComplete";
    oParam.iChave = chave;
    oParam.inputField = inputField;
    oParam.inputCodigo = inputCodigo;
    oParam.ulField = ulField;
    if (oParam.iChave.length >= 3) {
      js_divCarregando("Aguarde, verificando natureza...", "msgBox");
    }
    if (oParam.iChave.length >= 3) {
      let oAjax = new Ajax.Request("emp4_naturezabemservico.RPC.php", {
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

  function js_alterarRetencao(){
        if(aEstabelecimentos.length > 0){
        var oParam = new Object();
        oParam.method = "incluiRetencaoImposto"
        oParam.iCodOrdem = $('e50_codord').value
        oParam.aEstabelecimentos = aEstabelecimentos;
        url      = 'emp4_pagordemreinf.RPC.php';
        oAjax    = new Ajax.Request(
            url,
            {
            method: 'post',
            parameters: 'json='+js_objectToJson(oParam)
            }
        );
        }
    }

    function js_verificaEstabelecimentosInclusos(e50_codord) {
        var oParam = new Object();
        oParam.method = "verificaEstabelecimentos";
        oParam.iCodOrdem = e50_codord;
        let oAjax = new Ajax.Request("emp4_pagordemreinf.RPC.php", {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: js_preencheTabelaEstabelecimentos
        });
    }

    function js_preencheTabelaEstabelecimentos(oAjax) {
        obj = eval("(" + oAjax.responseText + ")");
        if (obj.aEstabelecimentos != null) {
            $('reinfRetencaoEstabelecimento').value = 1;
            aEstabelecimentos = obj.aEstabelecimentos;
            for (i = 0; i < aEstabelecimentos.length; i++) {
                js_adicionarEstabelecimentoTabela(aEstabelecimentos[i]);
            }
        } else {
            $('reinfRetencaoEstabelecimento').value = 0;
        }
        js_validarEstabelecimentos()
    }

  $('reinfRetencao').style.width = "85px";
  $('reinfRetencaoEstabelecimento').style.width = "85px";
  $('fieldsetEstabelecimentos').style.display = "none";
</script>