<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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

//MODULO: patrim
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clbensimoveis->rotulo->label();
$clrotulo = new rotulocampo;

?>
<fieldset style="text-align: left;">
  <legend><b>Dados do Imóvel</b></legend>
  <form name="form1" method="post" action="">
    <table border="0">
      <tr>
        <td nowrap title="<?= @$Tt54_codbem ?>">
          <?= @$Lt54_codbem ?>
        </td>
        <td>
          <?
          db_input('t54_codbem', 15, $It54_codbem, true, 'text', 3, "");
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Tt54_idbql ?>">
          <?
          db_ancora(@$Lt54_idbql, "js_pesquisat54_idbql(true);", $db_opcao);
          ?>
        </td>
        <td>
          <?
          db_input('t54_idbql', 15, $It54_idbql, true, 'text', 3, " onchange='js_pesquisat54_idbql(false);'")
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Tt54_obs ?>">
          <?= @$Lt54_obs ?>
        </td>
        <td>
          <?
          db_textarea('t54_obs', 2, 60, $It54_obs, true, 'text', $db_opcao, "")

          ?>
        </td>

      </tr>

      <tr>
        <td colspan="4">
          <fieldset>

            <div>
              <b>Endereço:</b>
              <?
              db_input('idEnderPrimario', 20, '', true, 'hidden', $db_opcao);
              db_input('t54_endereco', 45, '', true, 'text', 3);
              ?>
              <input type="button" value="Lançar" id="btnLancarEnd" onclick="js_lancaEnderPrimario();" <?= $btnDisabled ?>>
              <input type="button" value="Excluir" id="btnExcluirEndPrimario" onclick="js_ExcluiEnderPrimario();" <?= $btnDisabled ?>>

            </div>

          </fieldset>
        </td>
      </tr>

      <tr>
        <td nowrap="nowrap" title="Valor do terreno:">
          <b>Valor do terreno:</b>
        </td>
        <td title="Valor do terreno:">
          <?php
          db_input('t54_valor_terreno', 15, $t54_valor_terreno, true, 'text', $db_opcao, 'onchange = "js_calculaValorTotal();"
          onkeypress="return js_mask(event, \'0-9|.\')"');
          ?>
        </td>
      </tr>

      <tr>
        <td nowrap="nowrap" title="Valor área construída:">
          <b>Valor área construída:</b>
        </td>
        <td title="Valor área construída:">
          <?php
          db_input('t54_valor_area', 15, $t54_valor_area, true, 'text', $db_opcao, 'onchange = "js_calculaValorTotal();"
          onkeypress="return js_mask(event, \'0-9|.\')"');
          ?>
        </td>
      </tr>

      <tr>
        <td nowrap="nowrap" title="Valor Total:">
          <b>Valor Total:</b>
        </td>
        <td title="Valor Total:">
          <?php
          db_input('t54_valor_total', 15, $t54_valor_total, true, 'text', 3);
          ?>
        </td>
      </tr>

      <tr>
        <td nowrap="nowrap" title="Limites e confrontações:">
          <b>Limites e confrontações:</b>
        </td>
        <td title="Limites e confrontações:">
          <?php
          db_textarea('t54_limites_confrontacoes', 2, 60, $t54_limites_confrontacoes, true, 'text', $db_opcao, "", "", "", "200");
          ?>
        </td>
      </tr>

      <tr>
        <td nowrap="nowrap" title="Aplicação:">
          <b>Aplicação:</b>
        </td>
        <td title="Aplicação:">
          <?php
          db_input('t54_aplicacao', 62, $t54_aplicacao, true, 'text', 1, "", "", "", "", "200");
          ?>
        </td>
      </tr>

    </table>




    <fieldset style=" border: none; border-top: 2px groove #FFF; ">
      <legend class="bold">Origem</legend>
      <table border="0">

        <tr>
          <td nowrap="nowrap" title="Aplicação:">
            <b>Proprietário Anterior:</b>
          </td>
          <td title="Proprietário Anterior:">
            <?php
            db_input('t54_prop_anterior', 62, $t54_prop_anterior, true, 'text', 2, '', '', '#E6E4F1', "", "200");
            ?>
          </td>
        </tr>

        <tr>
          <td nowrap="nowrap" title="CPF / CNPJ::">
            <b>CPF / CNPJ:</b>
          </td>
          <td title="CPF / CNPJ:">
            <?php
            db_input('t54_cpfcnpj', 15, $t54_cpfcnpj, true, 'text', 1, "onkeyup=js_ValidaCampos(this,1,'CPF/CNPJ','t','t',event);", '', '#E6E4F1', '', "14");
            ?>
          </td>
        </tr>
      </table>
    </fieldset>







    <fieldset style="border: none; border-top: 2px groove #FFF; ">
      <legend class="bold">Transcrição no Cartório</legend>
      <table border="0">


        <tr>
          <td nowrap="nowrap" title="Cartório:">
            <b>Cartório:</b>
          </td>
          <td title="Proprietário Anterior:">
            <?php
            db_input('t54_cartorio_tc', 62, $t54_cartorio_tc, true, 'text', 1, '', '', '#E6E4F1', "", "200");
            ?>
          </td>
        </tr>

        <tr>
          <td nowrap="nowrap" title="Comarca:">
            <b>Comarca:</b>
          </td>
          <td title="Comarca:">
            <?php
            db_input('t54_comarca_tc', 62, $t54_comarca_tc, true, 'text', 1, '', '', '#E6E4F1', "", "200");
            ?>
          </td>
        </tr>

        <tr>
          <td nowrap="nowrap" title="Nº Registro:">
            <b>Nº Registro:</b>
          </td>
          <td title="Nº Registro:">
            <?php
            db_input('t54_registro_tc', 15, $t54_registro_tc, true, 'text', 1, "onkeyup=js_ValidaCampos(this,1,'Registro','t','t',event);", '', '#E6E4F1', '', "14");
            ?>
          </td>
        </tr>

        <tr>
          <td nowrap="nowrap" title="Livro:">
            <b>Livro:</b>
          </td>
          <td title="Livro:">
            <?php
            db_input('t54_livro_tc', 15, $t54_livro_tc, true, 'text', 1, '', '', '#E6E4F1', "", "200");
            ?>
          </td>
        </tr>

        <tr>
          <td nowrap="nowrap" title="folha:">
            <b>Folha:</b>
          </td>
          <td title="Folha:">
            <?php
            db_input('t54_folha_tc', 15, $t54_folha_tc, true, 'text', 1, "onkeyup=js_ValidaCampos(this,1,'Folha','t','t',event);", '', '#E6E4F1', '', "14");
            ?>
          </td>
        </tr>

        <tr>
          <td nowrap="nowrap" title="data:">
            <b>Data:</b>
          </td>
          <td title="Data:">
            <?php
            db_inputdata('t54_data_tc', @$t54_data_tc_dia, @$t54_data_tc_mes, @$t54_data_tc_ano, true, 'text', 1, "", "", "#E6E4F1");
            ?>
          </td>
        </tr>


      </table>
    </fieldset>





    <fieldset style="border: none; border-top: 2px groove #FFF; ">
      <legend class="bold">Título de propriedade</legend>
      <table border="0">


        <tr>
          <td nowrap="nowrap" title="Cartório:">
            <b>Cartório:</b>
          </td>
          <td title="Cartório:">
            <?php
            db_input('t54_cartorio_tp', 62, $t54_cartorio_tp, true, 'text', 1, '', '', '#E6E4F1', "", "200");
            ?>
          </td>
        </tr>

        <tr>
          <td nowrap="nowrap" title="Comarca:">
            <b>Tabelião:</b>
          </td>
          <td title="Comarca:">
            <?php
            db_input('t54_tabeliao_tp', 62, $t54_tabeliao_tp, true, 'text', 1, '', '', '#E6E4F1', "", "200");
            ?>
          </td>
        </tr>

        <tr>
          <td nowrap="nowrap" title="Nº Registro:">
            <b>Livro:</b>
          </td>
          <td title="Nº Registro:">
            <?php
            db_input('t54_livro_tp', 15, $t54_livro_tp, true, 'text', 1, '', '', '#E6E4F1', "", "200");
            ?>
          </td>
        </tr>

        <tr>
          <td nowrap="nowrap" title="Folha:">
            <b>Folha:</b>
          </td>
          <td title="Folha:">
            <?php
            db_input('t54_folha_tp', 15, $t54_folha_tp, true, 'text', 1, "onkeyup=js_ValidaCampos(this,1,'Folha','t','t',event);", '', '#E6E4F1', '', "14");
            ?>
          </td>
        </tr>

        <tr>
          <td nowrap="nowrap" title="Data:">
            <b>Data:</b>
          </td>
          <td title="Data:">
            <?php
            db_inputdata('t54_data_tp', @$t54_data_tp_dia, @$t54_data_tp_mes, @$t54_data_tp_ano, true, 'text', 1, "", "", "#E6E4F1");
            ?>
          </td>
        </tr>

        <tr>
          <td nowrap="Escritura" title="Escritura:">
            <b>Escritura:</b>
          </td>
          <td title="Escritura:">
            <?php
            db_textarea('t54_escritura_tp', 2, 60, $t54_escritura_tp, true, 'text', $db_opcao, '', '', '#E6E4F1', "200");
            ?>
          </td>
        </tr>

        <tr>
          <td nowrap="nowrap" title="Carta de sentença:">
            <b>Carta de sentença:</b>
          </td>
          <td title="Carta de sentença:">
            <?php
            db_textarea('t54_carta_tp', 2, 60, $t54_carta_tp, true, 'text', $db_opcao, '', '', '#E6E4F1', "200");
            ?>
          </td>
        </tr>

      </table>
    </fieldset>


</fieldset>

<table>
  <tr>
    <td colspan="2" align="center">
      <input name="<?= ($db_opcao == 1 ? 'incluir' : 'alterar') ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? 'Incluir' : 'Alterar') ?>" <?= ($db_botao == false || (isset($tipo_inclui) && $tipo_inclui == "true" || isset($global) && $global == "true") ? "disabled" : "") ?>>
      <input name="excluir" type="submit" id="db_opcao" value="Excluir" <?= ($db_opcao == 1 || $db_opcao == 22 || $db_opcao == 33 || (isset($tipo_inclui) && $tipo_inclui == "true" || isset($global) && $global == "true") ? "disabled" : "") ?>>
    </td>
  </tr>
</table>
</form>

<script>
  function js_calculaValorTotal() {

    var vlTerreno = new Number($F("t54_valor_terreno"));
    var vlArea = new Number($F("t54_valor_area"));


    $("t54_valor_total").value = (vlTerreno + vlArea).toFixed(2);

  }

  function js_pesquisat54_idbql(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('top.corpo.iframe_bensimoveis', 'db_iframe_lote', 'func_lote.php?funcao_js=parent.js_mostralote1|j34_idbql', 'Pesquisa', true);
    } else {
      if (document.form1.t54_idbql.value != '') {
        js_OpenJanelaIframe('top.corpo.iframe_bensimoveis', 'db_iframe_lote', 'func_lote.php?pesquisa_chave=' + document.form1.t54_idbql.value + '&funcao_js=parent.js_mostralote', 'Pesquisa', false);
      }
    }
  }

  function js_mostralote(chave, erro) {
    if (erro == true) {
      document.form1.t54_idbql.focus();
      document.form1.t54_idbql.value = '';
    }
  }

  function js_mostralote1(chave1) {
    document.form1.t54_idbql.value = chave1;
    db_iframe_lote.hide();
  }
  <?
  if (isset($incluir) || isset($excluir)) {
    $clbensimoveis->sql_record($clbensimoveis->sql_query_file($t54_codbem));
    if ($clbensimoveis->numrows > 0) {
      echo "top.corpo.iframe_bensmater.location.href='pat1_bensmater001.php?desabilita=true&t53_codbem=$t54_codbem';";
    } else {
      if (isset($excluir)) {
        echo "top.corpo.iframe_bensmater.location.href='pat1_bensmater001.php?t53_codbem=$t54_codbem';";
      }
    }
  }
  ?>

  function js_PreencheEndereco(aEndereco) {

    var iNumEndereco = aEndereco.length;
    for (var iInd = 0; iInd < iNumEndereco; iInd++) {

      var sEndereco = "";
      sEndereco += aEndereco[iInd].srua.urlDecode();
      sEndereco += ",  nº " + aEndereco[iInd].snumero.urlDecode();
      sEndereco += " " + aEndereco[iInd].scomplemento.urlDecode();
      sEndereco += " - " + aEndereco[iInd].sbairro.urlDecode();
      sEndereco += " - " + aEndereco[iInd].smunicipio.urlDecode();
      sEndereco += " - " + aEndereco[iInd].ssigla.urlDecode();

      if (aEndereco[iInd].stipo == 'P') {

        $('idEnderPrimario').value = aEndereco[iInd].iendereco;
        $('t54_endereco').value = sEndereco;
      } else {
        $('idEnderSecundario').value = aEndereco[iInd].iendereco;
        $('t54_endereco').value = sEndereco;
      }
    }
  }

  var j14_codigo = "";
  var j13_codi = "";

  function js_ruas() {
    js_OpenJanelaIframe('', 'db_iframe',
      'func_ruas.php?rural=1&funcao_js=parent.js_preenchepesquisaruas|j14_codigo|j14_nome',
      'Pesquisa', true, 0, 0);
  }

  function js_preenchepesquisaruas(chave, chave1) {
    j14_codigo = chave;
    db_iframe.hide();
    js_bairro();
  }

  function js_bairro() {
    js_OpenJanelaIframe('', 'db_iframe_bairro',
      'func_bairro.php?rural=1&funcao_js=parent.js_preenchebairro|j13_codi|j13_descr',
      'Pesquisa', true);
  }

  function js_preenchebairro(chave, chave1) {

    j13_codi = chave;
    db_iframe_bairro.hide();
    js_abreEnderPrimario();
  }


  function js_lancaEnderPrimario() {

    j13_codi = '';
    j14_codigo = '';


    js_abreEnderPrimario();

  }

  function js_abreEnderPrimario() {



    var idEnderPrimario = '';
    if ($F('idEnderPrimario') != "") {

      idEnderPrimario = $F('idEnderPrimario');
    }
    var lEnderMunic = false;
    oEnderPrimario = new DBViewCadastroEndereco('pri', 'oEnderPrimario', idEnderPrimario);
    oEnderPrimario.setObjetoRetorno($('idEnderPrimario'));
    oEnderPrimario.setTipoValidacao(2);
    oEnderPrimario.setEnderecoMunicipio(lEnderMunic);
    oEnderPrimario.setCallBackFunction(function() {
      js_lancaEnderPrimarioCallBack()
    });
    oEnderPrimario.setCodigoBairroMunicipio(j13_codi);
    oEnderPrimario.setCodigoRuaMunicipio(j14_codigo);

    if (lEnderMunic) {
      oEnderPrimario.buscaEndereco();
    }
    oEnderPrimario.show();
  }

  function js_Ajax(oSend, jsRetorno) {
    var msgDiv = "Aguarde ...";
    js_divCarregando(msgDiv, 'msgBox');

    var sUrlRpc = "prot1_cadgeralmunic.RPC.php";

    var oAjax = new Ajax.Request(
      sUrlRpc, {
        parameters: 'json=' + Object.toJSON(oSend),
        method: 'post',
        onComplete: jsRetorno
      }

    );
  }

  /* Função disparada no retorno do fechamneto da janela de endereço */
  function js_lancaEnderPrimarioCallBack() {

    var oEndereco = new Object();
    oEndereco.exec = 'findEnderecoByCodigo';
    oEndereco.iCodigoEndereco = $F('idEnderPrimario');
    js_Ajax(oEndereco, js_retornoEnderPrimario);

    function js_retornoEnderPrimario(oAjax) {

      js_removeObj('msgBox');

      var oRetorno = eval('(' + oAjax.responseText + ')');

      var sExpReg = new RegExp('\\\\n', 'g');

      if (oRetorno.endereco == false) {

        var strMessageUsuario = "Falha ao ler o endereço cadastrado! ";
        js_messageBox(strMessageUsuario, '');
        return false;
      } else {

        oRetorno.endereco[0].stipo = 'P';
        js_PreencheEndereco(oRetorno.endereco);
      }
    }
  }
</script>
