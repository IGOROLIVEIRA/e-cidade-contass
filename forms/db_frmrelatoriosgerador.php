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
      <legend><b></b></legend>
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
        <!-- <tr>
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
        </tr> -->
        <tr>
          <td nowrap title="<?= @$Trel_corpo ?>">
            <?= @$Lrel_corpo ?>
          </td>
          <td>
            <?
            db_textarea('rel_corpo', 15, 90, 'rel_corpo', true, 'text', $db_opcao, "")
            ?>
          </td>
        </tr>
      </table>

    </fieldset>
    <input name="Gerar" type="submit" id="db_opcao" value="Gerar" onclick="js_pesquisa();">
    <!-- <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();"> -->
  </div>
</form>
<script>
  var sUrl = "rel_gerenciamento.RPC.php";

  function js_pesquisarelatorios(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_relatorios', 'func_relatorios.php?funcao_js=parent.js_mostrafunc_relatorios1|rel_sequencial|rel_descricao|rel_corpo|rel_arquivo', 'Pesquisa', true, '0');
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
    document.form1.rel_corpo.value = chave3;

    js_divCarregando("Aguarde, pesquisando dados do arquivo.", "msgBox");
    var oParam = new Object();
    oParam.exec = "verificaArquivo";
    oParam.iArquivo = chave1;
    var oAjax = new Ajax.Request(sUrl, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoVerificaArquivo
    });
    db_iframe_relatorios.hide();
  }

  function js_retornoVerificaArquivo(oAjax) {

    js_removeObj("msgBox");
    var oRetorno = eval("(" + oAjax.responseText + ")");
    console.log(oRetorno);
    if (oRetorno.status == 1) {

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
</script>