<?
//MODULO: configuracoes
$clrelatorios->rotulo->label();
$cldb_sysprocedarq->rotulo->label();

$clrotulo = new rotulocampo;
$clrotulo->label("nomemod");
$clrotulo->label("rel_descricao");
$clrotulo->label("descrproced");
?>
<form name="form1" method="post" action="">
  <div class="container">
    <fieldset>
      <legend><b>Gerador</b></legend>
      <table border="0">
        <tr>
          <td nowrap title="Relatorios">
            <?
            db_ancora("Relatorios", "js_pesquisarelatorios(true);", $db_opcao);
            ?>
          </td>
          <td>
            <?
            db_input('rel_sequencial', 10, $Irel_sequencial, true, 'text', $db_opcao, " onchange='js_pesquisarelatorios(false);'")
            ?>
            <?
            db_input('rel_descricao', 50, $Irel_descricao, true, 'text', 3, '')
            ?>
          </td>
        </tr>
        <tr>
          <td id="tdArquivoAncora"></td>
          <td id="tdArquivoInput"></td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Trel_corpo ?>">
            <?= @$Lrel_corpo ?>
          </td>
          <td>
            <?
            db_textarea('rel_corpo', 15, 90, 'rel_corpo', true, 'text', 3, "")
            ?>
          </td>
        </tr>
      </table>

    </fieldset>
    <input name="Gerar" type="submit" id="db_opcao" value="Gerar">
  </div>
</form>
<script>
  var sUrl = "rel_gerenciamento.RPC.php";

  function js_pesquisarelatorios(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_relatorios', 'func_relatorios.php?funcao_js=parent.js_mostrafunc_relatorios1|rel_sequencial|rel_descricao|rel_corpo|rel_arquivo', 'Pesquisa', true);
    } else {
      if (document.form1.rel_sequencial.value != '') {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_relatorios', 'func_relatorios.php?pesquisa_chave=' + document.form1.rel_sequencial.value + '&funcao_js=parent.js_mostrafunc_relatorios', 'Pesquisa', false);
      } else {
        document.form1.rel_descricao.value = '';
      }
    }
  }

  function js_mostrafunc_relatorios(chave, erro) {
    document.form1.rel_descricao.value = chave;
    if (erro == true) {
      document.form1.rel_sequencial.focus();
      document.form1.rel_sequencial.value = '';
    }

  }

  function js_mostrafunc_relatorios1(chave1, chave2, chave3, chave4) {
    document.form1.rel_sequencial.value = chave1;
    document.form1.rel_descricao.value = chave2;

    console.log(chave3);
    tinymce.activeEditor.execCommand('mceNewDocument');
    tinymce.activeEditor.execCommand('mceInsertContent', false, chave3);
    //tinymce.execInstanceCommand('rel_corpo', 'mceInsertContent', false, chave3);

    js_divCarregando("Aguarde, pesquisando dados do arquivo.", "msgBox");
    var oParam = new Object();
    oParam.exec = "getArquivo";
    oParam.iArquivo = chave4;
    var oAjax = new Ajax.Request(sUrl, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoArquivo
    });
    db_iframe_relatorios.hide();
  }

  function js_pesquisa() {
    js_OpenJanelaIframe('top.corpo', 'db_iframe_relatorios', 'func_relatorios.php?funcao_js=parent.js_preenchepesquisa|rel_sequencial', 'Pesquisa', true);
  }

  function js_preenchepesquisa(chave) {
    db_iframe_relatorios.hide();
    <?
    echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
    ?>
  }

  function js_retornoArquivo(oAjax) {

    js_removeObj("msgBox");
    var oRetorno = eval("(" + oAjax.responseText + ")");
    if (oRetorno.status == 1) {
      js_generateAncora(oRetorno.arquivo.nometabela, oRetorno.arquivo.nomecampo);
    }
  }

  function js_generateAncora(sArq, sCamp) {

    var tdArquivoAncora = document.getElementById("tdArquivoAncora");
    var ancora = document.createElement('a');
    ancora.setAttribute('class', 'dbancora');
    ancora.setAttribute('onclick', 'js_pesquisa' + sArq + '(true)');
    ancora.setAttribute("style", "text-decoration:underline;");
    ancora.setAttribute("id", "ancora_arquivo");
    ancora.setAttribute("href", "#");
    tdArquivoAncora.appendChild(ancora);
    if (sArq != 'liclicita') {
      document.getElementById("ancora_arquivo").innerHTML = sArq[0].toUpperCase() + sArq.substr(1);
    } else {
      document.getElementById("ancora_arquivo").innerHTML = 'Licitações';
    }

    var tdArquivoInput = document.getElementById("tdArquivoInput");

    if (document.getElementById("input_arquivo"))
      document.getElementById("input_arquivo").remove();

    var input = document.createElement('input');
    input.setAttribute('class', 'dbinput');
    input.setAttribute('type', 'text');
    input.setAttribute('maxlength', '10');
    input.setAttribute('onblur', "js_ValidaMaiusculo(this,'f',event)");
    input.setAttribute('oninput', "js_ValidaCampos(this,1,'Sequencial','f','f',event)");
    input.setAttribute('onkeydown', "return js_controla_tecla_enter(this,event)");
    input.setAttribute("autocomplete", "off");
    input.setAttribute("tabindex", "1");
    input.setAttribute("id", "input_arquivo");
    input.setAttribute("name", "input_arquivo");
    input.setAttribute("href", "#");
    input.setAttribute("readonly", "");
    input.setAttribute("style", "background-color:#DEB887;text-transform:uppercase;");

    tdArquivoInput.appendChild(input);

    var input2 = document.createElement('input');
    input2.setAttribute('class', 'dbinput');
    input2.setAttribute("id", "arquivo");
    input2.setAttribute("name", "arquivo");
    input2.setAttribute("type", "hidden");
    input2.setAttribute("value", sArq);

    tdArquivoInput.appendChild(input2);

    var script = document.createElement('script');

    script.innerText = "function js_pesquisa" + sArq + "(mostra) { ";
    script.innerText += "if (mostra == true) {";
    script.innerText += " js_OpenJanelaIframe('top.corpo', 'db_iframe_" + sArq + "', 'func_" + sArq + ".php?funcao_js=parent.js_mostrafunc_" + sArq + "1|" + sCamp + "', 'Pesquisa', true);"
    script.innerText += "} else {";
    script.innerText += " if (document.form1.input_arquivo.value != '') {";
    script.innerText += " js_OpenJanelaIframe('top.corpo', 'db_iframe_" + sArq + "', 'func_" + sArq + ".php?pesquisa_chave=' + document.form1.input_arquivo.value + '&funcao_js=parent.js_mostrafunc_" + sArq + "', 'Pesquisa', false);";
    script.innerText += "} else {"
    script.innerText += " document.form1.input_arquivo_descricao.value = '';"
    script.innerText += "}";
    script.innerText += "}";
    script.innerText += "}";
    document.body.appendChild(script);

    var script2 = document.createElement('script');
    script2.innerText = "function js_mostrafunc_" + sArq + "1(chave1) {";
    script2.innerText += "document.form1.input_arquivo.value = chave1;";
    script2.innerText += "db_iframe_" + sArq + ".hide();";
    script2.innerText += "}";
    document.body.appendChild(script2);

  }

  function js_gerar() {

    var oParam = new Object();

    oParam.sExec = 'gerar';
    oParam.sequencial = $F('rel_sequencial');
    oParam.arquivo = $F('input_arquivo');

    js_divCarregando('Gerando Relatório, aguarde.', 'msgbox');

    var oAjax = new Ajax.Request(sUrl, {
      method: 'POST',
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_confirma
    });

  }

  function js_confirma(oAjax) {

    js_removeObj('msgbox');

    var oRetorno = eval("(" + oAjax.responseText + ")");
    if (oRetorno.iStatus == 1) {
      sMensagem = "Relatório Gerado";
    } else {
      //alert(oRetorno.sMensagem.urlDecode());
      return false;
    }
  }
</script>
