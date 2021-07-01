<?
//MODULO: configuracoes
$clrelatorios->rotulo->label();
$cldb_sysprocedarq->rotulo->label();

$clrotulo = new rotulocampo;
$clrotulo->label("nomemod");
$clrotulo->label("nomearq");
$clrotulo->label("descrproced");
?>
<form name="form1" method="post" action="">
  <div class="container">
    <fieldset>
      <legend><b>Cadastro</b></legend>
      <table border="0">
        <tr>
          <td nowrap title="<?= @$Trel_sequencial ?>" align="left">
            <?= @$Lrel_sequencial ?>
          </td>
          <td align="left">
            <?
            db_input('rel_sequencial', 10, $Irel_sequencial, true, 'text', 3, "")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Trel_descricao ?>" align="left">
            <?= @$Lrel_descricao ?>
          </td>
          <td align="left">
            <?
            db_input('rel_descricao', 50, $Irel_descricao, true, 'text', $db_opcao, "")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Tcodarq ?>" align="left">
            <?
            db_ancora(@$Lcodarq, "js_pesquisacodarq(true);", $db_opcao);
            ?>
          </td>
          <td align="left">
            <?
            db_input('codarq', 10, $Icodarq, true, 'text', $db_opcao, " onchange='js_pesquisacodarq(false);'")
            ?>
            <?
            db_input('nomearq', 50, $Inomearq, true, 'text', 3, '')
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Trel_corpo ?>" align="left">
            <strong>Texto Padrão:</strong>
          </td>
          <td>
            <?
            db_textarea('rel_corpo', 10, 85, 'rel_corpo', true, 'text', $db_opcao, "");
            ?>
          </td>
        </tr>
      </table>

    </fieldset>
    <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
    <?php if ($db_opcao == 2 || $db_opcao == 22) {  ?>
      <input name="excluir" type="submit" id="db_opcao" value="Excluir">
    <?php } ?>
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
  </div>
</form>
<div id="legendas"></div>
<script>
  var sUrl = "rel_gerenciamento.RPC.php";

  function js_pesquisacodarq(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_db_sysarquivo', 'func_db_sysarquivo.php?funcao_js=parent.js_mostradb_sysarquivo1|codarq|nomearq', 'Pesquisa', true);
    } else {
      if (document.form1.codarq.value != '') {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_db_sysarquivo', 'func_db_sysarquivo.php?pesquisa_chave=' + document.form1.codarq.value + '&funcao_js=parent.js_mostradb_sysarquivo', 'Pesquisa', false);
      } else {
        document.form1.nomearq.value = '';
      }
    }
  }

  function js_mostradb_sysarquivo(chave, erro) {
    document.form1.nomearq.value = chave;
    if (erro == true) {
      document.form1.codarq.focus();
      document.form1.codarq.value = '';
    }
    js_divCarregando("Aguarde, pesquisando dados do arquivo.", "msgBox");
    var oParam = new Object();
    oParam.exec = "verificaArquivo";
    oParam.iArquivo = document.form1.codarq.value;
    var oAjax = new Ajax.Request(sUrl, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoVerificaArquivo
    });

  }

  function js_mostradb_sysarquivo1(chave1, chave2) {
    document.form1.codarq.value = chave1;
    document.form1.nomearq.value = chave2;

    js_divCarregando("Aguarde, pesquisando dados do arquivo.", "msgBox");
    var oParam = new Object();
    oParam.exec = "verificaArquivo";
    oParam.iArquivo = chave1;
    var oAjax = new Ajax.Request(sUrl, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoVerificaArquivo
    });
    db_iframe_db_sysarquivo.hide();
  }

  function js_retornoVerificaArquivo(oAjax) {

    js_removeObj("msgBox");
    var oRetorno = eval("(" + oAjax.responseText + ")");
    console.log(oRetorno);
    if (oRetorno.status == 1) {
      const pai = document.getElementById("legendas");
      const filho = pai.querySelector("#tableLegenda");

      if (filho !== null) {
        // console.log("O elemento #filho existe em #pai");
        filho.remove();
      } else {
        // console.log("O elemento #filho não existe em #pai");
      }

      var table = document.createElement('table');
      table.setAttribute('id', 'tableLegenda');

      var arrHead = new Array();
      arrHead = ['Descrição', 'Nome do campo'];

      var arrValue = new Array();

      arrValue.push([unescape("Município"), '#$' + "sMunicipio" + '#']);
      arrValue.push([unescape("Data do sistema"), '#$' + "datasistema" + '#']);
      arrValue.push([unescape("Data do sistema mês textual"), '#$' + "dSistema" + '#']);
      oRetorno.itens.each(function(oItem, iLinha) {
        arrValue.push([unescape(oItem.descricao), '#$' + oItem.nomecam + '#']);
      });
      var tr = table.insertRow(-1);

      for (var h = 0; h < arrHead.length; h++) {
        var th = document.createElement('th'); // TABLE HEADER.
        th.innerHTML = arrHead[h];
        tr.appendChild(th);
      }

      for (var c = 0; c <= arrValue.length - 1; c++) {
        tr = table.insertRow(-1);
        for (var j = 0; j < arrHead.length; j++) {
          var td = document.createElement('td'); // TABLE DEFINITION.
          td = tr.insertCell(-1);
          td.innerHTML = arrValue[c][j]; // ADD VALUES TO EACH CELL.
        }
      }

      pai.appendChild(table);

    }

  }

  function js_pesquisa() {
    js_OpenJanelaIframe('top.corpo', 'db_iframe_relatorios', 'func_relatorios.php?funcao_js=parent.js_preenchepesquisa|rel_sequencial', 'Pesquisa', true);
  }

  function js_preenchepesquisa(chave) {
    db_iframe_relatorios.hide();
    <?
    //if ($db_opcao != 1) {
    echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
    //}
    ?>
  }

  if (document.form1.codarq.value) {
    js_divCarregando("Aguarde, pesquisando dados do arquivo.", "msgBox");
    var oParam = new Object();
    oParam.exec = "verificaArquivo";
    oParam.iArquivo = document.form1.codarq.value;
    var oAjax = new Ajax.Request(sUrl, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoVerificaArquivo
    });
  }
</script>
