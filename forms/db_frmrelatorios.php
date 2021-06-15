<?
//MODULO: configuracoes
$clrelatorios->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("nomemod");
?>
<form name="form1" method="post" action="">
  <div class="container">
    <fieldset>
      <legend><b></b></legend>
      <table border="0">
        <tr>
          <td nowrap title="<?= @$Trel_sequencial ?>">
            <?= @$Lrel_sequencial ?>
          </td>
          <td>
            <?
            db_input('rel_sequencial', 10, $Irel_sequencial, true, 'text', 3, "")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Trel_descricao ?>">
            <?= @$Lrel_descricao ?>
          </td>
          <td>
            <?
            db_input('rel_descricao', 50, $Irel_descricao, true, 'text', $db_opcao, "")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Trel_modulo ?>">
            <?
            db_ancora(@$Lrel_modulo, "js_pesquisarel_modulo(true);", $db_opcao);
            ?>
          </td>
          <td>
            <?
            db_input('rel_modulo', 10, $Irel_modulo, true, 'text', $db_opcao, " onchange='js_pesquisarel_modulo(false);'")
            ?>
            <?
            db_input('nomemod', 20, $Inomemod, true, 'text', 3, '')
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Trel_corpo ?>">
            <?= @$Lrel_corpo ?>
          </td>
          <td>
            <?
            db_textarea('rel_corpo', 3, 54, 'rel_corpo', true, 'text', $db_opcao, "")
            ?>
          </td>
        </tr>
      </table>
    </fieldset>
    <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
  </div>
</form>
<script>
  function js_pesquisarel_modulo(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_db_modulos', 'func_db_sysmodulo.php?funcao_js=parent.js_mostradb_modulos1|codmod|nomemod', 'Pesquisa', true);
    } else {
      if (document.form1.rel_modulo.value != '') {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_db_modulos', 'func_db_sysmodulo.php?pesquisa_chave=' + document.form1.rel_modulo.value + '&funcao_js=parent.js_mostradb_modulos', 'Pesquisa', false);
      } else {
        document.form1.nomemod.value = '';
      }
    }
  }

  var sUrl = "rel_gerenciamento.RPC.php";

  function js_mostradb_modulos(chave, erro) {

    document.form1.nomemod.value = chave;
    if (erro == true) {
      document.form1.rel_modulo.focus();
      document.form1.rel_modulo.value = '';
    }

    js_divCarregando("Aguarde, pesquisando dados do modulo.", "msgBox");
    var oParam = new Object();
    oParam.exec = "verificaModulo";
    oParam.iModulo = chave;

    var oAjax = new Ajax.Request(sUrl, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoVerificaModulo
    });

  }

  function js_mostradb_modulos1(chave1, chave2) {
    alert('teste2');

    document.form1.rel_modulo.value = chave1;
    document.form1.nomemod.value = chave2;

    js_divCarregando("Aguarde, pesquisando dados do modulo.", "msgBox");
    var oParam = new Object();
    oParam.exec = "verificaModulo";
    oParam.iModulo = chave1;
    console.log(oParam);
    var oAjax = new Ajax.Request(sUrl, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoVerificaModulo
    });


    db_iframe_db_modulos.hide();
  }

  function js_retornoVerificaModulo(oAjax) {

    js_removeObj("msgBox");
    var oRetorno = eval("(" + oAjax.responseText + ")");

    // $("l20_usaregistropreco").options.length = 0;
    // if (oRetorno.l03_usaregistropreco == 't') {
    //   //true pode por sim nao no campo l20_usaregistropreco

    //   $("l20_usaregistropreco").options[0] = new Option("Não", "f");
    //   $("l20_usaregistropreco").options[1] = new Option("Sim", "t");
    // } else {
    //   // false somentenao
    //   $("l20_usaregistropreco").options[0] = new Option("Não", "f");
    // }
  }

  function js_pesquisa() {
    js_OpenJanelaIframe('top.corpo', 'db_iframe_relatorios', 'func_relatorios.php?funcao_js=parent.js_preenchepesquisa|rel_sequencial', 'Pesquisa', true);
  }

  function js_preenchepesquisa(chave) {
    db_iframe_relatorios.hide();
    <?
    if ($db_opcao != 1) {
      echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
    }
    ?>
  }

  function js_main() {

    oTxtCodigoAcordo = new DBTextField('oTxtCodigoAcordo', 'oTxtCodigoAcordo', '', 10);
    oTxtCodigoAcordo.addEvent("onChange", ";js_pesquisaac16_sequencial(false);");
    oTxtCodigoAcordo.addEvent("onKeyUp", ";js_verificaAcordo(this.value);");
    oTxtCodigoAcordo.addEvent('onKeyPress', 'return js_mask(event, "0-9|")');
    oTxtCodigoAcordo.show($('ctnTxtCodigoAcordo'));

    oTxtDescricaoAcordo = new DBTextField('oTxtDescricaoAcordo', 'oTxtDescricaoAcordo', '', 80);
    oTxtDescricaoAcordo.show($('ctnTxtDescricaoAcordo'));
    oTxtDescricaoAcordo.setReadOnly(true);

    oGridAutorizacoes = new DBGrid('oGridAutorizacoes');
    oGridAutorizacoes.nameInstance = 'oGridAutorizacoes';
    oGridAutorizacoes.setCheckbox(0);
    oGridAutorizacoes.setCellAlign(new Array('right', 'right', "center", 'right'));
    oGridAutorizacoes.setHeader(new Array("cod", 'Autorização', 'Data', 'Valor'));
    oGridAutorizacoes.aHeaders[1].lDisplayed = false;
    oGridAutorizacoes.setHeight(250);
    oGridAutorizacoes.show($('ctnGridAutorizacoes'));

    $('btnPesquisarAutorizacoes').onclick = js_pesquisarAutorizacoesContrato;
  }
  js_main();
</script>
