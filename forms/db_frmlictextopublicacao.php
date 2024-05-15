<?

//MODULO:  licitacao

$cllictextopublicacao->rotulo->label();

?>

<form name="form1" method="post" action="">
  <center>
    <fieldset>
      <legend><b>Textos padroes Publicação</b></legend>
      <table border="0">
        <tr>
          <td nowrap title="<?= @$Tl214_sequencial ?>">
            <input name="oid" type="hidden" value="<?= @$oid ?>">
            <?= @$Ll214_sequencial ?>
          </td>
          <td>
            <?
            db_input('l214_sequencial', 8, $Il214_sequencial, true, 'text', 3, "");
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Tl214_tipo ?>">
            <?= @$Ll214_tipo ?>
          </td>
          <td>
            <?
            db_input('l214_tipo', 72, $Il214_tipo, true, 'text', $db_opcao, "")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Tl214_texto ?>">
            <?= @$Ll214_texto ?>
          </td>
          <td>
            <?
            db_textarea('l214_texto', 15, 70, $Il214_texto, true, 'text', $db_opcao, "")
            ?>
          </td>
        </tr>
      </table>
    </fieldset>
    <table>
  </center>
  <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
  <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
</form>
<script>
  function js_pesquisa() {
    js_OpenJanelaIframe('top.corpo', 'db_iframe_lictextopublicacao', 'func_lictextopublicacao.php?funcao_js=parent.js_preenchepesquisa|0', 'Pesquisa', true);
  }

  function js_preenchepesquisa(chave) {
    db_iframe_lictextopublicacao.hide();
    <?
    if ($db_opcao != 1) {
      echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
    }
    ?>
  }
</script>