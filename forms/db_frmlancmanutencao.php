<?php

db_app::load("scripts.js, strings.js, prototype.js,datagrid.widget.js, widgets/dbautocomplete.widget.js");
db_app::load("widgets/windowAux.widget.js");

?>
<form class="container" style="width: 600px;" name="form1" method="post" action="<?= $db_action ?>">
  <fieldset>
    <legend>Manutenção</legend>
    <table class="form-container">
      <tr>
        <td>
          <? db_ancora("Código", "js_pesquisa_bem(true);", 1); ?>
        </td>
        <td>
          <?
          db_input('t52_bem', 8, 1, true, 'text', 1, "onchange='js_pesquisa_bem(false)'");
          db_input('t52_descr', 40, 3, true, 'text', 1, 'style="width: 303px;"');

          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Tt93_id_usuario ?>">
          <? db_ancora("Placa", "js_pesquisa_bem(true);", 1); ?>
        </td>
        <td>
          <?
          db_input('t93_id_usuario', 8, $It93_id_usuario, true, 'text', 1, "");
          ?>
          <b> Vlr Aquisição: </b>
          <?
          db_input('t52_valaqu', 8, '', true, 'text', 3, "");
          ?>
          <b> Vlr Atual: </b>
          <?
          db_input('t44_valoratual', 8, '', true, 'text', 3, "");
          ?>
        </td>

      </tr>


      <tr>
        <td nowrap title="<?= @$Tt94_depart ?>">
          Tipo Manutenção:
        </td>
        <td>
          <?
          $tiposmanutencao  = array('Selecione', 'Acréscimo de valor', 'Decréscimo de valor', 'Adição de componente', 'Remoção de componente', 'Manunteção de Imóvel');

          db_select('tipo_manutencao', $tiposmanutencao, true, 1, 'style="width: 80px;"');          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Tt93_data ?>">
          Data:
        </td>
        <td>
          <?
          if (!isset($t93_data)) {
            $t93_data_ano = date('Y', db_getsession("DB_datausu"));
            $t93_data_mes = date('m', db_getsession("DB_datausu"));
            $t93_data_dia = date('d', db_getsession("DB_datausu"));
          }
          db_inputdata('t93_data', @$t93_data_dia, @$t93_data_mes, @$t93_data_ano, true, 'text', $db_opcao, "");
          db_input('db_param', 3, 0, true, 'hidden', 3)
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Tt93_codtran ?>">
          Departamento:
        </td>
        <td>
          <?
          db_input('t52_depart', 8, 1, true, 'text', 3, "");
          db_input('descrdepto', 40, 3, true, 'text', 3, "");

          ?>
        </td>
      </tr>
      <tr>
        <td colspan="2" title="<?= @$Tt93_obs ?>">
          <fieldset class="separator">
            <legend>Descrição</legend>
            <?php db_textarea("t93_obs", 10, 50, $It93_obs, true, "text", $db_opcao, null, null, null, 500); ?>
          </fieldset>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Tt93_codtran ?>">
          Vlr Manut.:
        </td>
        <td>
          <?
          db_input('t93_codtran', 8, 1, true, 'text', 1, "");

          ?>
        </td>
      </tr>
    </table>
  </fieldset>
  <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?> <?= (($db_opcao == 1 || $db_opcao == 2 || $db_opcao == 22) ? "onClick = 'return ver_depto_destino()'" : "") ?>>
  <input name="excluir" type="button" id="excluir" value="Excluir" onclick="js_pesquisa();">
  <input name="processar" type="button" id="processar" value="Processar" onclick="js_imprime();"> <br>
  <input style="margin-top: 10px;" name="inserircomponente" type="button" id="inserircomponente" value="Inserir Componente" onclick="js_imprime();">

</form>
<script>
  oAutoComplete = new dbAutoComplete(document.getElementById('t52_descr'), 'com4_pesquisabem.RPC.php');
  oAutoComplete.setTxtFieldId(document.getElementById('t52_bem'));
  oAutoComplete.show();


  function js_pesquisa_bem(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('', 'db_iframe_bens', 'func_benslancmanutencao.php?opcao=todos&funcao_js=parent.js_mostrabem1|t52_bem|t52_descr|t44_valoratual|t52_depart|descrdepto|t52_valaqu', 'Pesquisa', true);
    } else {
      if (document.form1.t52_bem.value != '') {
        js_OpenJanelaIframe('', 'db_iframe_bens', 'func_benslancmanutencao.php?opcao=todos&pesquisa_chave=' + document.form1.t52_bem.value + '&funcao_js=parent.js_mostrabem', 'Pesquisa', false);
      } else {
        document.form1.t52_descr.value = '';
      }
    }
  }

  function js_mostrabem(t52_descr, t44_valoratual, t52_depart, descrdepto, t52_valaqu, erro) {
    if (erro == true) {
      document.form1.t52_bem.focus();
      document.form1.t52_descr.value = t52_descr;
      document.form1.t52_bem.value = '';
      document.form1.t44_valoratual.value = '';
      document.form1.t52_depart.value = '';
      document.form1.descrdepto.value = '';
      document.form1.t52_valaqu.value = '';
    } else {
      document.form1.t52_descr.value = t52_descr;
      document.form1.t44_valoratual.value = js_formatar(t44_valoratual, "f", 2);
      document.form1.t52_depart.value = t52_depart;
      document.form1.descrdepto.value = descrdepto;
      document.form1.t52_valaqu.value = js_formatar(t52_valaqu, "f", 2);
    }


  }

  function js_mostrabem1(t52_bem, t52_descr, t44_valoratual, t52_depart, descrdepto, t52_valaqu) {
    document.form1.t52_bem.value = t52_bem;
    document.form1.t52_descr.value = t52_descr;
    db_iframe_bens.hide();
  }
</script>