<?php
///MODULO: sicom
  $clprecoreferencia->rotulo->label();
  $clrotulo = new rotulocampo;
?>
<form name="form1" method="post" action="">
  <center>
    <fieldset style="margin-left: 80px; margin-top: 10px;">
      <legend>Preço de Referência</legend>
      <table border="0">
        <tr>
          <td nowrap title="<?= @$Tsi01_sequencial ?>">
            <?= @$Lsi01_sequencial ?>
          </td>
          <td>
            <?php db_input('si01_sequencial', 10, $Isi01_sequencial, true, 'text', 3, ""); ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Tsi01_processocompra ?>">
            <?php db_ancora(@$Lsi01_processocompra, "js_pesquisasi01_processocompra(true);", $db_opcao); ?>
          </td>
          <td>
            <?php db_input('si01_processocompra', 10, $Isi01_processocompra, true, 'text', $db_opcao, " onchange='js_pesquisasi01_processocompra(false);'"); ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Tsi01_datacotacao ?>">
            <?= @$Lsi01_datacotacao ?>
          </td>
          <td>
            <?php db_inputdata('si01_datacotacao', @$si01_datacotacao_dia, @$si01_datacotacao_mes, @$si01_datacotacao_ano, true, 'text', $db_opcao, ""); ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Tsi01_tipoprecoreferencia ?>">
            <?= @$Lsi01_tipoprecoreferencia ?>
          </td>
          <td>
            <?php 
              $x = array('1' => 'Preço Médio', '2' => 'Maior Preço', '3' => 'Menor Preço');
              db_select('si01_tipoprecoreferencia', $x, true, $db_opcao, "");
            ?>
          </td>
        </tr>
        <tr>
          <td><strong>Imprimir Justificativa: </strong></td>
          <td>
            <?php 
              $x = array('n' => 'Não', 's' => 'Sim');
              db_select('impjustificativa', $x, true, $db_opcao, "style = 'width: 91px;'");
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Tsi01_justificativa ?>">
            <strong>Justificativa: </strong>
          </td>
          <td>
            <?php db_textarea('si01_justificativa', 7, 60, $Isi01_justificativa, true, 'text', $db_opcao, ""); ?>
          </td>
        </tr>
      </table>
    </fieldset>
  </center>
  <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir e Imprimir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
  <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
  <?php if ($db_opcao == 2) : ?>
    <input name="imprimir" type="submit" id="imprimir" value="Imprimir PDF">
    <input name="imprimircsv" type="submit" id="imprimircsv" value="Imprimir CSV">
  <?php endif; ?>
</form>
<script>
  function js_pesquisasi01_processocompra(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_pcproc', 'func_pcprocnovo.php?funcao_js=parent.js_mostrapcproc1|pc80_codproc', 'Pesquisa', true);
    } else {
      if (document.form1.si01_processocompra.value != '') {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_pcproc', 'func_pcprocnovo.php?pesquisa_chave=' + document.form1.si01_processocompra.value + '&funcao_js=parent.js_mostrapcproc', 'Pesquisa', false);
      }
    }
  }

  function js_mostrapcproc(chave, erro) {
    if (erro == true) {
      document.form1.si01_processocompra.focus();
      document.form1.si01_processocompra.value = '';
    }
  }

  function js_mostrapcproc1(chave1) {
    document.form1.si01_processocompra.value = chave1;
    db_iframe_pcproc.hide();
  }

  function js_pesquisa() {
    js_OpenJanelaIframe('top.corpo', 'db_iframe_precoreferencia', 'func_precoreferencia.php?funcao_js=parent.js_preenchepesquisa|si01_sequencial', 'Pesquisa', true);
  }

  function js_preenchepesquisa(chave) {
    db_iframe_precoreferencia.hide(); <?
    if ($db_opcao != 1) {
      echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]).
      "?chavepesquisa='+chave";
    } ?>
  }
</script>