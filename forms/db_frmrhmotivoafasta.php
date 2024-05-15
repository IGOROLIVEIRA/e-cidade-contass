<?
//MODULO: pessoal
$clrhmotivoafasta->rotulo->label();
?>
<style>
  #rh172_descricao {
    width: 362px;
    height: 21px;
  }
</style>
<fieldset style="margin-top:30px;margin-left:90%;width:auto;">
  <legend>
    <strong>Tipo Afastamento:</strong>
  </legend>
  <form name="form1" method="post" action="">
    <center>
      <table border="0">
        <tr>
          <td nowrap title="<?= @$Trh172_sequencial ?>">
            <input name="rh172_sequencial" type="hidden" value="<?= @$rh172_sequencial ?>">
            <?= @$Lrh172_sequencial ?>
          </td>
          <td>
            <?
            db_input('rh172_sequencial', 11, $Irh172_sequencial, true, 'text', 3, "")
            ?>
          </td>
        </tr>
        <tr>
          <td>
            <strong>Codigo Afastamento:</strong>
          </td>
          <td>
            <?
            db_input('rh172_codigo', 11, $Irh172_codigo, true, 'text', $db_opcao, "")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Trh172_descricao ?>">
            <?= @$Lrh172_descricao ?>
          </td>
          <td>
            <?
            db_textarea('rh172_descricao', 0, 0, $Irh172_descricao, true, 'text', $db_opcao, "")
            ?>
          </td>
        </tr>
      </table>
    </center>
    <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
  </form>
</fieldset>
<script>
  function js_pesquisa() {
    js_OpenJanelaIframe('top.corpo', 'db_iframe_rhmotivoafasta', 'func_rhmotivoafasta.php?funcao_js=parent.js_preenchepesquisa|0', 'Pesquisa', true);
  }

  function js_preenchepesquisa(chave) {
    db_iframe_rhmotivoafasta.hide();
    <?
    if ($db_opcao != 1) {
      echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
    }
    ?>
  }
</script>