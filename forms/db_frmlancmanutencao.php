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
          db_input('t98_sequencial', 8, 1, true, 'hidden', 1, "onchange='js_pesquisa_bem(false)'");


          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Tt93_id_usuario ?>">
          <? db_ancora("Placa", "js_pesquisa_placa(true);", 1); ?>
        </td>
        <td>
          <?
          db_input('t52_ident', 8, 3, true, 'text', 1, "onchange='js_pesquisa_placa(false)'");
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

          db_select('t98_tipo', $tiposmanutencao, true, 1, 'style="width: 80px;"'); ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Tt93_data ?>">
          Data:
        </td>
        <td>
          <?
          if (!isset($t98_data)) {
            $t98_data_ano = date('Y', db_getsession("DB_datausu"));
            $t98_data_mes = date('m', db_getsession("DB_datausu"));
            $t98_data_dia = date('d', db_getsession("DB_datausu"));
          }
          db_inputdata('t98_data', @$t98_data_dia, @$t98_data_mes, @$t98_data_ano, true, 'text', $db_opcao, "");
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
            <?php db_textarea("t98_descricao", 10, 50, 3, true, "text", $db_opcao, null, null, null, 500); ?>
          </fieldset>
        </td>
      </tr>
      <tr>
        <td>
          Vlr Manut.:
        </td>
        <td>
          <?
          db_input('t98_vlrmanut', 8, 4, true, 'text', 1, "");

          ?>
        </td>
      </tr>
    </table>
  </fieldset>
  <input id="acao" name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "salvar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Salvar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
  <input name="excluir" type="button" id="excluir" value="Excluir" onclick="js_pesquisa();">
  <input name="processar" type="button" id="processar" value="Processar" onclick="js_imprime();"> <br>
  <input disabled style="margin-top: 10px;" name="inserircomponente" type="button" id="inserircomponente" value="Inserir Componente" onclick="js_inserircomponente();">

</form>
<script>
  oAutoComplete = new dbAutoComplete(document.getElementById('t52_descr'), 'com4_pesquisabem.RPC.php');
  oAutoComplete.setTxtFieldId(document.getElementById('t52_bem'));
  oAutoComplete.show();


  function js_pesquisa_bem(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('', 'db_iframe_bens', 'func_benslancmanutencao.php?opcao=todos&funcao_js=parent.js_mostrabem1|t52_bem|t52_descr|t44_valoratual|t52_depart|descrdepto|t52_valaqu|t52_ident', 'Pesquisa', true);
    } else {
      if (document.form1.t52_bem.value != '') {
        js_OpenJanelaIframe('', 'db_iframe_bens', 'func_benslancmanutencao.php?opcao=todos&pesquisa_chave=' + document.form1.t52_bem.value + '&funcao_js=parent.js_mostrabem', 'Pesquisa', false);
      } else {
        document.form1.t52_descr.value = '';
        document.form1.t52_bem.value = '';
        document.form1.t44_valoratual.value = '';
        document.form1.t52_depart.value = '';
        document.form1.descrdepto.value = '';
        document.form1.t52_valaqu.value = '';
        document.form1.t52_ident.value = '';

      }
    }
  }

  function js_mostrabem(t52_descr, t44_valoratual, t52_depart, descrdepto, t52_valaqu, t52_ident, erro) {
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
      document.form1.t52_ident.value = t52_ident;


    }


  }

  function js_mostrabem1(t52_bem, t52_descr, t44_valoratual, t52_depart, descrdepto, t52_valaqu, t52_ident) {
    document.form1.t52_bem.value = t52_bem;
    document.form1.t52_descr.value = t52_descr;
    document.form1.t44_valoratual.value = js_formatar(t44_valoratual, "f", 2);
    document.form1.t52_depart.value = t52_depart;
    document.form1.descrdepto.value = descrdepto;
    document.form1.t52_valaqu.value = js_formatar(t52_valaqu, "f", 2);
    document.form1.t52_ident.value = t52_ident;
    db_iframe_bens.hide();
  }

  function js_pesquisa_placa(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('', 'db_iframe_bens', 'func_placalancmanutencao.php?opcao=todos&funcao_js=parent.js_mostraplaca1|t52_bem|t52_descr|t44_valoratual|t52_depart|descrdepto|t52_valaqu|t52_ident', 'Pesquisa', true);
    } else {
      if (document.form1.t52_ident.value != '') {
        js_OpenJanelaIframe('', 'db_iframe_bens', 'func_placalancmanutencao.php?opcao=todos&pesquisa_chave=' + document.form1.t52_ident.value + '&funcao_js=parent.js_mostraplaca', 'Pesquisa', false);
      } else {
        document.form1.t52_descr.value = '';
        document.form1.t52_bem.value = '';
        document.form1.t44_valoratual.value = '';
        document.form1.t52_depart.value = '';
        document.form1.descrdepto.value = '';
        document.form1.t52_valaqu.value = '';
      }
    }
  }

  function js_mostraplaca(t52_bem, t52_descr, t44_valoratual, t52_depart, descrdepto, t52_valaqu, t52_ident, erro) {
    if (erro == true) {
      document.form1.t52_bem.focus();
      document.form1.t52_descr.value = t52_descr;
      document.form1.t52_bem.value = '';
      document.form1.t44_valoratual.value = '';
      document.form1.t52_depart.value = '';
      document.form1.descrdepto.value = '';
      document.form1.t52_valaqu.value = '';
    } else {
      document.form1.t52_bem.value = t52_bem;
      document.form1.t52_descr.value = t52_descr;
      document.form1.t44_valoratual.value = js_formatar(t44_valoratual, "f", 2);
      document.form1.t52_depart.value = t52_depart;
      document.form1.descrdepto.value = descrdepto;
      document.form1.t52_valaqu.value = js_formatar(t52_valaqu, "f", 2);
      document.form1.t52_ident.value = t52_ident;


    }


  }

  function js_mostraplaca1(t52_bem, t52_descr, t44_valoratual, t52_depart, descrdepto, t52_valaqu, t52_ident) {
    document.form1.t52_bem.value = t52_bem;
    document.form1.t52_descr.value = t52_descr;
    document.form1.t44_valoratual.value = js_formatar(t44_valoratual, "f", 2);
    document.form1.t52_depart.value = t52_depart;
    document.form1.descrdepto.value = descrdepto;
    document.form1.t52_valaqu.value = js_formatar(t52_valaqu, "f", 2);
    document.form1.t52_ident.value = t52_ident;

    db_iframe_bens.hide();
  }

  function js_inserircomponente() {
    parent.document.formaba.componentes.disabled = false;
    top.corpo.iframe_componentes.location.href = 'pat1_lancmanutencao005.php';
    parent.mo_camada('componentes');
  }
</script>