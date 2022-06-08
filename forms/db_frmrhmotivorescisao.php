<?php
//MODULO: pessoal
$clrhmotivorescisao->rotulo->label();
?>
<style>
  #rh173_descricao {
    width: 362px;
    height: 21px;
  }
</style>
<fieldset style="margin-top:30px;margin-left:90%;width:auto;">
  <legend>
    <strong>Tipo Rescisão:</strong>
  </legend>
  <form name="form1" method="post" action="">
    <center>
      <table border="0">
        <tr>
          <td nowrap title="<?= @$Trh173_sequencial ?>">
            <input name="rh173_sequencial" type="hidden" value="<?= @$rh173_sequencial ?>">
            <?= @$Lrh173_sequencial ?>
          </td>
          <td>
            <?php
            db_input('rh173_sequencial', 11, $Irh173_sequencial, true, 'text', 3, "")
            ?>
          </td>
        </tr>
        <tr>
          <td>
            <strong>Codigo Rescisão:</strong>
          </td>
          <td>
            <?php
            db_input('rh173_codigo', 11, $Irh173_codigo, true, 'text', $db_opcao, "")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Trh173_descricao ?>">
            <?= @$Lrh173_descricao ?>
          </td>
          <td>
            <?php
            db_textarea('rh173_descricao', 0, 0, $Irh173_descricao, true, 'text', $db_opcao, "")
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
    js_OpenJanelaIframe('top.corpo', 'db_iframe_rhmotivorescisao', 'func_rhmotivorescisao.php?funcao_js=parent.js_preenchepesquisa|0', 'Pesquisa', true);
  }

  function js_preenchepesquisa(chave) {
    db_iframe_rhmotivorescisao.hide();
    <?php
    if ($db_opcao != 1) {
        echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
    }
    ?>
  }
</script>
