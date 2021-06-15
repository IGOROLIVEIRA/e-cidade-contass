<?
//MODULO: configuracoes
$clrelatorios->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("nome_modulo");
?>
<form name="form1" method="post" action="">
  <center>
    <table border="0">
      <tr>
        <td nowrap title="<?= @$Trel_sequencial ?>">
          <?= @$Lrel_sequencial ?>
        </td>
        <td>
          <?
          db_input('rel_sequencial', 10, $Irel_sequencial, true, 'text', $db_opcao, "")
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
          db_input('nome_modulo', 20, $Inome_modulo, true, 'text', 3, '')
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Trel_corpo ?>">
          <?= @$Lrel_corpo ?>
        </td>
        <td>
          <?
          // db_input('rel_corpo',500,$Irel_corpo,true,'text',$db_opcao,"")
          db_textarea('rel_corpo', 3, 54, 'rel_corpo', true, 'text', $db_opcao, "")
          ?>
        </td>
      </tr>
    </table>
  </center>
  <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
  <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
</form>
<script>
  function js_pesquisarel_modulo(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_db_modulos', 'func_db_modulos.php?funcao_js=parent.js_mostradb_modulos1|id_item|nome_modulo', 'Pesquisa', true);
    } else {
      if (document.form1.rel_modulo.value != '') {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_db_modulos', 'func_db_modulos.php?pesquisa_chave=' + document.form1.rel_modulo.value + '&funcao_js=parent.js_mostradb_modulos', 'Pesquisa', false);
      } else {
        document.form1.nome_modulo.value = '';
      }
    }
  }

  function js_mostradb_modulos(chave, erro) {
    document.form1.nome_modulo.value = chave;
    if (erro == true) {
      document.form1.rel_modulo.focus();
      document.form1.rel_modulo.value = '';
    }
  }

  function js_mostradb_modulos1(chave1, chave2) {
    document.form1.rel_modulo.value = chave1;
    document.form1.nome_modulo.value = chave2;
    db_iframe_db_modulos.hide();
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
</script>
