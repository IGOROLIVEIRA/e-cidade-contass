<form class="container" style="width: 600px;" name="form1" method="post" action="<?= $db_action ?>">
  <fieldset>
    <legend>Manutenção</legend>
    <table class="form-container">
      <tr>
        <td>
          <? db_ancora("Código", "js_pesquisa_bem(true);", $db_opcao); ?>
        </td>
        <td>
          <?
          db_input('t52_bem', 8, 1, true, 'text', $db_opcao, "onchange='js_pesquisa_bem(false)'");
          db_input('t52_descr', 52, 3, true, 'text', $db_opcao, "onchange='js_pesquisa_descricaobem();'");
          db_input('t98_sequencial', 8, 1, true, 'hidden', 1, "onchange='js_pesquisa_bem(false)'");
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Tt93_id_usuario ?>">
          <? db_ancora("Placa", "js_pesquisa_placa(true);", $db_opcao); ?>
        </td>
        <td>
          <?
          db_input('t52_ident', 8, 3, true, 'text', $db_opcao, "onchange='js_pesquisa_placa(false)'");
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

          db_select('t98_tipo', $tiposmanutencao, true, $db_opcao, 'style="width: 168px;"'); ?>
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
          db_input('descrdepto', 52, 3, true, 'text', 3, "");

          ?>
        </td>
      </tr>
      <tr>
        <td colspan="2" title="<?= @$Tt93_obs ?>">
          <fieldset class="separator">
            <legend>Descrição</legend>
            <?php db_textarea("t98_descricao", 10, 50, 0, true, "text", $db_opcao, null, null, null, 500); ?>
          </fieldset>
        </td>
      </tr>
      <tr>
        <td>
          Vlr Manut.:
        </td>
        <td>
          <?
          db_input('t98_vlrmanut', 8, 4, true, 'text', $db_opcao, "");

          ?>
        </td>
      </tr>
    </table>
  </fieldset>
  <input <?= ($ocultasalvar == true ? 'style=" display: none;"' : "") ?> name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "salvar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Salvar" : "Excluir")) ?>">
  <input <?= ($ocultaexcluir == true ? 'style=" display: none;"' : "") ?> name="excluir" type="submit" id="excluir" value="Excluir">
  <input <?= ($ocultaprocessar == true ? 'style=" display: none;"' : "") ?> id="processamento" name="processar" type="submit" value="Processar">
  <input <?= ($ocultapesquisa == true ? 'style=" display: none;"' : "") ?> name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();"><br>
  <input <?= ($ocultainserircomponente == true ? 'style=" display: none;"' : "") ?> style=" margin-top: 10px;" name="inserircomponente" type="button" id="inserircomponente" value="Inserir Componente" onclick="js_inserircomponente();">

  <?php
  if (isset($pesquisa_manutencoes) && $db_opcao == 3) {
    echo "<script>
    function js_pesquisa(){
      js_OpenJanelaIframe('', 'db_iframe_bensmanutencao', 'func_bensmanutencao.php?exclusao=true&funcao_js=parent.js_mostrabemmanutencao|t98_sequencial|t98_bem|t98_data|t98_vlrmanut|t98_descricao|t98_tipo|t52_ident|t52_descr|t52_valaqu|t44_valoratual|t52_depart|descrdepto|t98_manutencaoprocessada', 'Pesquisa', true);
    }
    js_pesquisa();
    </script>";
  }
  if (isset($pesquisa_manutencoes) && $db_opcao != 3) {
    echo "<script>
    function js_pesquisa(){
      js_OpenJanelaIframe('', 'db_iframe_bensmanutencao', 'func_bensmanutencao.php?funcao_js=parent.js_mostrabemmanutencao|t98_sequencial|t98_bem|t98_data|t98_vlrmanut|t98_descricao|t98_tipo|t52_ident|t52_descr|t52_valaqu|t44_valoratual|t52_depart|descrdepto|t98_manutencaoprocessada', 'Pesquisa', true);
    }
    js_pesquisa();
    </script>";
  }
  ?>
</form>

<script>
  oAutoComplete = new dbAutoComplete(document.getElementById('t52_descr'), 'com4_pesquisabem.RPC.php');
  oAutoComplete.setTxtFieldId(document.getElementById('t52_bem'));
  oAutoComplete.show();

  function js_limparCampos() {
    document.form1.t52_descr.value = '';
    document.form1.t52_bem.value = '';
    document.form1.t44_valoratual.value = '';
    document.form1.t52_depart.value = '';
    document.form1.descrdepto.value = '';
    document.form1.t52_valaqu.value = '';
    document.form1.t52_ident.value = '';
    document.form1.t98_data.value = '';
    document.form1.t98_descricao.value = '';
    document.form1.t98_vlrmanut.value = '';
    document.form1.t98_tipo.value = 0;
  }

  function js_bloquearCampos() {
    document.form1.t52_descr.setAttribute("readonly", "readonly");
    document.form1.t52_bem.setAttribute("readonly", "readonly");
    document.form1.t44_valoratual.setAttribute("readonly", "readonly");
    document.form1.t52_depart.setAttribute("readonly", "readonly");
    document.form1.descrdepto.setAttribute("readonly", "readonly");
    document.form1.t52_valaqu.setAttribute("readonly", "readonly");
    document.form1.t52_ident.setAttribute("readonly", "readonly");
    document.form1.t98_data.setAttribute("readonly", "readonly");
    document.form1.t98_descricao.setAttribute("readonly", "readonly");
    document.form1.t98_vlrmanut.setAttribute("readonly", "readonly");
    document.form1.t98_tipo.setAttribute("readonly", "readonly");
    document.form1.t52_descr.style.backgroundColor = "#DEB887";
    document.form1.t52_bem.style.backgroundColor = "#DEB887";
    document.form1.t52_ident.style.backgroundColor = "#DEB887";
    document.form1.t98_tipo.style.backgroundColor = "#DEB887";
    document.form1.t98_data.style.backgroundColor = "#DEB887";
    document.form1.t98_descricao.style.backgroundColor = "#DEB887";
    document.form1.t98_vlrmanut.style.backgroundColor = "#DEB887";
  }

  function js_pesquisa_descricaobem() {
    if (document.getElementById('t52_descr').value == "") {
      document.form1.t52_descr.value = '';
      document.form1.t52_bem.value = '';
      document.form1.t44_valoratual.value = '';
      document.form1.t52_depart.value = '';
      document.form1.descrdepto.value = '';
      document.form1.t52_valaqu.value = '';
      document.form1.t52_ident.value = '';
      document.form1.t98_data.value = '';
      return false;
    }
    js_pesquisa_bem();
  }

  function js_mostrabemmanutencao(t98_sequencial, t98_bem, t98_data, t98_vlrmanut, t98_descricao, t98_tipo, t52_ident, t52_descr, t52_valaqu, t44_valoratual, t52_depart, descrdepto, t98_manutencaoprocessada) {

    if (t98_manutencaoprocessada == 't') {
      document.getElementById('processamento').value = "Desprocessar";
      document.getElementById('processamento').name = "desprocessar";
      document.getElementById('db_opcao').style.display = "none";
      document.getElementById('inserircomponente').style.display = "none";
      parent.document.formaba.componentes.disabled = true;
      js_bloquearCampos();
    }

    t98_manutencaoprocessada == 't' ? parent.document.formaba.componentes.disabled = true : parent.document.formaba.componentes.disabled = false;

    document.form1.t98_sequencial.value = t98_sequencial;
    document.form1.t52_bem.value = t98_bem;
    document.form1.t98_data.value = t98_data.split("-").reverse().join("/");
    document.form1.t98_vlrmanut.value = t98_vlrmanut;
    document.form1.t98_descricao.value = t98_descricao;
    document.form1.t52_ident.value = t52_ident;
    document.form1.t52_descr.value = t52_descr;
    document.form1.t52_valaqu.value = t52_valaqu;
    document.form1.t44_valoratual.value = t44_valoratual;
    document.form1.t98_tipo.value = t98_tipo;
    document.form1.t52_depart.value = t52_depart;
    document.form1.descrdepto.value = descrdepto;
    CurrentWindow.corpo.iframe_componentes.location.href = 'pat1_lancmanutencao005.php?t98_sequencial=' + t98_sequencial;
    db_iframe_bensmanutencao.hide();
  }

  function js_pesquisa_bem(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('', 'db_iframe_bens', 'func_benslancmanutencao.php?opcao=todos&funcao_js=parent.js_mostrabem1|t52_bem|t52_descr|t44_valoratual|t52_depart|descrdepto|t52_valaqu|t52_ident', 'Pesquisa', true);
      return;
    }

    if (document.form1.t52_bem.value != '') {
      js_OpenJanelaIframe('', 'db_iframe_bens', 'func_benslancmanutencao.php?opcao=todos&pesquisa_chave=' + document.form1.t52_bem.value + '&funcao_js=parent.js_mostrabem', 'Pesquisa', false);
      return;
    }

    document.form1.t52_descr.value = '';
    document.form1.t52_bem.value = '';
    document.form1.t44_valoratual.value = '';
    document.form1.t52_depart.value = '';
    document.form1.descrdepto.value = '';
    document.form1.t52_valaqu.value = '';
    document.form1.t52_ident.value = '';
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
      return;
    }
    document.form1.t52_descr.value = t52_descr;
    document.form1.t44_valoratual.value = js_formatar(t44_valoratual, "f", 2);
    document.form1.t52_depart.value = t52_depart;
    document.form1.descrdepto.value = descrdepto;
    document.form1.t52_valaqu.value = js_formatar(t52_valaqu, "f", 2);
    document.form1.t52_ident.value = t52_ident;
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
      return;
    }

    if (document.form1.t52_ident.value != '') {
      js_OpenJanelaIframe('', 'db_iframe_bens', 'func_placalancmanutencao.php?opcao=todos&pesquisa_chave=' + document.form1.t52_ident.value + '&funcao_js=parent.js_mostraplaca', 'Pesquisa', false);
      return;
    }

    document.form1.t52_descr.value = '';
    document.form1.t52_bem.value = '';
    document.form1.t44_valoratual.value = '';
    document.form1.t52_depart.value = '';
    document.form1.descrdepto.value = '';
    document.form1.t52_valaqu.value = '';

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
      return;
    }
    document.form1.t52_bem.value = t52_bem;
    document.form1.t52_descr.value = t52_descr;
    document.form1.t44_valoratual.value = js_formatar(t44_valoratual, "f", 2);
    document.form1.t52_depart.value = t52_depart;
    document.form1.descrdepto.value = descrdepto;
    document.form1.t52_valaqu.value = js_formatar(t52_valaqu, "f", 2);
    document.form1.t52_ident.value = t52_ident;

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
    CurrentWindow.corpo.iframe_componentes.location.href = 'pat1_lancmanutencao005.php?t98_sequencial=' + document.getElementById('t98_sequencial').value;
    parent.mo_camada('componentes');
  }
</script>