<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

$clnaturezabemservico->rotulo->label();
?>
<div class="container">
  <form name="form1" method="post" action="">
    <fieldset>
      <legend>Natureza de Bem ou Serviço</legend>
      <table border="0">
        <tr>
          <td nowrap title="<?php echo $Te101_sequencial; ?>">
            <?php echo $Le101_sequencial; ?>
          </td>
          <td>
            <?php db_input('e101_sequencial', 5, $Ie101_sequencial, true, 'text', 3); ?>
            <?php echo $Le101_codnaturezarendimento; ?>
            <?php db_input('e101_codnaturezarendimento', 5, $Ie101_codnaturezarendimento, true, 'text', $db_opcao); ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?php echo $Te101_descr; ?>">
            <?php echo $Le101_descr; ?>
          </td>
          <td>
            <?php db_textarea('e101_descr', 5, 50, $Ie101_descr, true, 'text', $db_opcao); ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?php echo $Te101_aliquota; ?>">
            <?php echo $Le101_aliquota; ?>
          </td>
          <td>
            <?php db_input('e101_aliquota', 5, $Ie101_aliquota, true, 'text', $db_opcao); ?>
          </td>
        </tr>
      </table>
    </fieldset>

    <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
  </form>
</div>
<script>
  function js_pesquisa() {
    js_OpenJanelaIframe('top.corpo', 'db_iframe_naturezabemservico', 'func_naturezabemservico.php?funcao_js=parent.js_preenchepesquisa|e101_sequencial', 'Pesquisa', true);
  }

  function js_preenchepesquisa(chave) {
    db_iframe_naturezabemservico.hide();

    <?php
    if ($db_opcao != 1) {
      echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
    }
    ?>
  }
</script>