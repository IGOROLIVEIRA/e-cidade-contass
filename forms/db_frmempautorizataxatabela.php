<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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


$clempautoriza->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("e44_tipo");
$clrotulo->label("z01_nome");
$clrotulo->label("nome");
$clrotulo->label("pc50_descr");
$clrotulo->label("e57_codhist");
$clrotulo->label("c58_descr");
$clrotulo->label("e150_numeroprocesso");
$clrotulo->label("e54_codlicitacao");
if ($db_opcao == 1) {
  $ac = "emp1_empautorizataxatabela004.php";
} else if ($db_opcao == 2 || $db_opcao == 22) {
  $ac = "emp1_empautorizataxatabela005.php";
} else if ($db_opcao == 3) {
  $ac = "emp1_empautorizataxatabela006.php";
}
if (isset($db_opcaoal)) {
  $db_opcao = 3;
  $db_botao = false;
}

db_app::load("DBFormCache.js");

?>

<script>
  function js_relatorio() {
    jan = window.open('emp2_emiteautori002.php?e54_autori=<?= $e54_autori ?>&instit=<?= db_getsession("DB_instit") ?>', '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
    jan.moveTo(0, 0);
  }
</script>

<style>
  #e57_codhistdescr,
  #e54_codtipodescr,
  #e54_codcomdescr {
    width: 400px;
  }

  #e57_codhist,
  #e54_codtipo,
  #e54_tipol,
  #e54_codcom {
    width: 50px;
  }

  #e44_tipo {
    width: 453px;
  }

  #e54_tipodespesa {
    width: 453px;
  }

  #e54_tipoldescr {
    width: 200px;
  }

  #e54_nummodalidade {
    width: 370px;
  }

  #e54_destin {
    width: 369px;
  }
</style>

<form name="form1" method="post" onsubmit="<?php ($db_opcao == 1) ? 'return js_salvaCache();' : ''; ?>" action="<?= $ac ?>">
  <fieldset>
    <legend><strong>Autorização de Empenho </strong></legend>
    <table border="0">
      <input id="e57_codhist" name="e57_codhist" value="0" type="hidden">
      <input id="e54_anousu" name="e54_anousu" value="<?= $e54_anousu ?>" type="hidden">
      <tr>
        <td align="left" nowrap title="<?= $Tl20_codigo ?>">
          <b>
            <? db_ancora('Licitação', "js_pesquisa_liclicita(true);", ($db_opcao == 1) ? $db_opcao : 3); ?>:
          </b>
        </td>
        <td align="left" nowrap>
          <? db_input("e54_codlicitacao", 10, $Il20_codigo, true, "text", ($db_opcao == 1) ? $db_opcao : 3, ($db_opcao == 1) ? "onchange='js_pesquisa_liclicita(false);'" : "onchange='js_pesquisa_fornecedor(this.value);'"); ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Te54_autori ?>">
          <?= @$Le54_autori ?>
        </td>
        <td>
          <?
          db_input('e54_autori', 10, $Ie54_autori, true, 'text', 3);
          db_input('o58_codele', 10, $Ie54_autori, true, 'hidden', 3);
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Te54_codcom ?>">
          <strong>Nome/Razão Social:</strong>
        </td>
        <td>
          <?php
          if (isset($e54_numcgm) && !empty($e54_numcgm)) {
            $cgm = array($aCgm->z01_numcgm => $aCgm->z01_nome);
            db_select('e54_numcgm', $cgm, true, $db_opcao, " style='width:370;' ");
          } else {
            db_select('e54_numcgm', '', true, $db_opcao, " style='width:370;' ");
          }

          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Te54_destin ?>">
          <b>Destino:</b>
        </td>
        <td nowrap="nowrap">
          <?
          db_input('e54_destin', 51, $Ie54_destin, true, 'text', 1, 'style="background-color: white"');
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Te54_codcom ?>">
          <strong>Tipo de Compra:</strong>
        </td>
        <td>
          <? db_input('e54_codcom', 8, 1, true, 'hidden'); ?>
          <select name="e54_codcomS" id="e54_codcomS" style="width:370;" disabled="true">
            <option value="">Selecione</option>
            <?php foreach ($aPctipocompras as $aPctipocompra) : ?>
              <option <?= ($aPctipocompra->pc50_codcom == $e54_codcom ? 'selected' : '')  ?> value="<?= $aPctipocompra->pc50_codcom ?>">
                <?= $aPctipocompra->pc50_codcom . " - " . $aPctipocompra->pc50_descr ?>
              </option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Te54_codtipo ?>">
          <strong>Tipo de Empenho:</strong>
        </td>
        <td>
          <select name="e54_codtipo" id="e54_codtipo" style="width:370;">
            <option value="">Selecione</option>
            <?php foreach ($aEmptipos as $aEmptipo) : ?>
              <option <?= ($aEmptipo->e41_codtipo == $e54_codtipo ? 'selected' : '')  ?> value="<?= $aEmptipo->e41_codtipo ?>">
                <?= $aEmptipo->e41_codtipo . " - " . $aEmptipo->e41_descr ?>
              </option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Te54_tipol ?>">
          <strong>Tipo de Licitação:</strong>
        </td>
        <td>
          <? db_input('e54_tipol', 8, 1, true, 'hidden'); ?>
          <select name="e54_tipolS" id="e54_tipolS" style="width:370;" disabled="true">
            <option value="">Selecione</option>
            <?php foreach ($aCflicitas as $aCflicita) : ?>
              <option <?= ($aCflicita->l03_tipo == $e54_tipol ? 'selected' : '')  ?> value="<?= $aCflicita->l03_tipo ?>">
                <?= $aCflicita->l03_tipo . " - " . $aCflicita->l03_descr ?>
              </option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>
          <strong>Número do Processo:</strong>
        </td>
        <td>
          <? db_input('e54_numerll', 51, "", true, 'text', 3, '', "", "", "", 16); ?>
          <? db_input('e54_numerl', 8, 1, true, 'hidden', ""); ?>
        </td>
      </tr>
      <tr>
        <td>
          <strong>Número Modalidade:</strong>
        </td>
        <td>
          <? db_input('e54_nummodalidade', 8, 1, true, '', 3, ''); ?>
        </td>
      </tr>
      <tr>
        <td>
          <strong>Prazo de Entrega:</strong>
        </td>
        <td>
          <? db_input('e54_praent', 51, "", true, 'text', $db_opcao, 'style="background-color: white"'); ?>
        </td>
      </tr>
      <tr>
        <td>
          <strong>Condição de Pagamento:</strong>
        </td>
        <td>
          <? db_input('e54_conpag', 51, "", true, 'text', $db_opcao, 'style="background-color: white"'); ?>
        </td>
      </tr>
      <tr>
        <td>
          <strong>Telefone:</strong>
        </td>
        <td>
          <? db_input('e54_telef', 51, "", true, 'text', $db_opcao, 'style="background-color: white"'); ?>
        </td>
      </tr>
      <tr>
        <td>
          <strong>Contato:</strong>
        </td>
        <td>
          <? db_input('e54_contat', 51, "", true, 'text', $db_opcao, 'style="background-color: white"'); ?>
        </td>
      </tr>
      <tr>
        <td>
          <strong>Outras Condições:</strong>
        </td>
        <td>
          <? db_input('e54_codout', 51, "", true, 'text', $db_opcao, 'style="background-color: white"'); ?>
        </td>
      </tr>

      <tr title="Número do processo administrativo (PA). Máximo 15 caractéres.">
        <td nowrap="nowrap">
          <strong>Processo Administrativo (PA):</strong>
        </td>
        <td colspan="3">
          <?php
          db_input('e150_numeroprocesso', 51, $Ie150_numeroprocesso, true, 'text', $db_opcao);
          ?>
        </td>
      </tr>
      <?
      $anousu = db_getsession("DB_anousu");
      if ($anousu > 2007) {
      ?>
        <tr>
          <td nowrap title="<?= @$Te54_concarpeculiar ?>">
            <?
            db_ancora(@$Le54_concarpeculiar, "js_pesquisae54_concarpeculiar(true);", ($db_opcao == 1) ? $db_opcao : 3);
            ?>
          </td>
          <td nowrap="nowrap">
            <?
            db_input("e54_concarpeculiar", 9, $Ie54_concarpeculiar, true, "text", ($db_opcao == 1) ? $db_opcao : 3, "onChange='js_pesquisae54_concarpeculiar(false);'");
            db_input("c58_descr", 40, 0, true, "text", 3);
            ?>
          </td>
        </tr>

      <?
      } else {
        $e54_concarpeculiar = 0;
        db_input("e54_concarpeculiar", 10, 0, true, "hidden", 3, "");
      }
      ?>
      <tr>
        <td><b>Desconto automático:</b></td>
        <td>
          <?
          $aDescAutomatico = array("f" => "Não", "t" => "Sim");
          db_select("e54_desconto", $aDescAutomatico, true, $db_opcao);
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Te54_resumo ?>" colspan="2">
          <fieldset>
            <legend>
              <strong><?= @$Le54_resumo ?></strong>
            </legend>
            <? db_textarea('e54_resumo', 3, 70, $Ie54_resumo, true, 'text', $db_opcao, "") ?>
          </fieldset>
        </td>
      </tr>
    </table>
  </fieldset>

  <div style="margin-top: 10px;">

    <input <?= ($db_opcao == 1 ? "onclick='return js_validacampos();'" : "") ?> name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?> onclick="return js_validaLicitacao();<?php ($db_opcao == 1) ? 'return js_salvaCache();' : ' '; ?>">
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">


    <? if ($db_opcao == 2) { ?>
      <input name="novo" type="button" id="novo" value="Nova autorização" onclick="js_nova();">

      <?
      $permissao_lancar = db_permissaomenu(db_getsession("DB_anousu"), 398, 3489);
      if ($permissao_lancar == "true") {
      ?>
        <input name="lancemp" type="button" id="lancemp" value="Lançar Empenho" onclick="js_lanc_empenho();">
    <?
      }
    }
    ?>

  </div>

  <? if (isset($emprocesso) && $emprocesso == true) { ?>
    <br>
    <font color="red"><b>Autorização gerada por solicitação de compras.</b></font>
  <? } ?>

</form>
<script>
  window.onload = function() {
    var codlicitacao = document.form1.e54_codlicitacao.value;
    if (codlicitacao != "") {
      js_pesquisa_fornecedor(codlicitacao);
      /*let e54_numerl = document.form1.e54_numerl.value;
      if (e54_numerl.indexOf("/") == -1) {
        document.form1.e54_numerll.value = document.form1.e54_numerl.value+"/"+document.form1.e54_anousu.value;
      } else {
          document.form1.e54_numerll.value = document.form1.e54_numerl.value;
      }*/
    }
  }

  function js_validaLicitacao() {
    if ($('dop').value != 3 && ($('e54_numerl').value == '' || $('e54_numerl').value == 0)) {
      alert("Para esse Tipo de Compra é necessário informar o campo Número da Licitação.");
      return false;
    } else {
      return true;
    }
  }

  function js_validacampos() {
    if ($('e54_numcgm').value == '') {
      alert("Campo Nome/Razão Social não informado.");
      return false;
    } else {
      return true;
    }
  }

  function js_pesquisa() {
    <?
    if ($db_opcao == 2 || $db_opcao == 22) {
      $iframe = "selempautoriza";
    } else {
      $iframe = "selempautoriza";
    }
    ?>
    js_OpenJanelaIframe('top.corpo.iframe_empautoriza', 'db_iframe_<?= $iframe ?>', 'func_<?= $iframe ?>.php?criterioadjudicacao=true&funcao_js=parent.js_preenchepesquisa|e54_autori', 'Pesquisa', true, '0', '1');
  }

  function js_preenchepesquisa(chave) {
    db_iframe_<?= $iframe ?>.hide();
    <?
    if ($db_opcao != 1) {
      echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
    }
    ?>

  }

  var db_opcao = <?php echo $db_opcao; ?>;

  var oDBFormCache = new DBFormCache('oDBFormCache', 'db_frmempautorizataxatabela.php');

  oDBFormCache.setElements(new Array($('e54_codtipo'),
    $('e54_codtipodescr'),
    $('e57_codhist'),
    $('e57_codhistdescr'),
    $('e54_concarpeculiar'),
    $('c58_descr'),
    $('e44_tipo'),
    $('e54_codlicitacao')
  ));


  if (db_opcao == 1) {
    oDBFormCache.load();
    oDBFormCache.save();
  }

  function js_salvaCache() {

    oDBFormCache.save();
    return true;
  }


  function js_pesquisae54_concarpeculiar(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('top.corpo.iframe_empautoriza', 'db_iframe_concarpeculiar',
        'func_concarpeculiar.php?funcao_js=parent.js_mostraconcarpeculiar1|' +
        'c58_sequencial|c58_descr', 'Pesquisa', true, '0', '1');
    } else {
      if (document.form1.e54_concarpeculiar.value != '') {
        js_OpenJanelaIframe('top.corpo.iframe_empautoriza',
          'db_iframe_concarpeculiar',
          'func_concarpeculiar.php?pesquisa_chave=' + document.form1.e54_concarpeculiar.value +
          '&funcao_js=parent.js_mostraconcarpeculiar', 'Pesquisa', false);
      } else {
        document.form1.c58_descr.value = '';
      }
    }
  }

  function js_mostraconcarpeculiar(chave, erro) {
    document.form1.c58_descr.value = chave;
    if (erro == true) {
      document.form1.e54_concarpeculiar.focus();
      document.form1.e54_concarpeculiar.value = '';
    }
  }

  function js_mostraconcarpeculiar1(chave1, chave2) {
    document.form1.e54_concarpeculiar.value = chave1;
    document.form1.c58_descr.value = chave2;
    db_iframe_concarpeculiar.hide();
  }

  function js_nova() {
    destin = document.form1.e54_destin.value;
    resumo = document.form1.e54_resumo.value;
    numcgm = document.form1.e54_numcgm.value;
    //nome   = document.form1.z01_nome.value;
    parent.location.href = "emp1_empautorizataxatabela001.php";
  }
  // lançar empenho
  function js_lanc_empenho() {

    autori = document.form1.e54_autori.value;
    var iElemento = $F("o58_codele");

    parent.location.href = "<?= $sUrlEmpenho ?>?iElemento=" + iElemento + "&chavepesquisa=" + autori + "&lanc_emp=true";
  }

  function completaElemento(iElemento) {
    $("o58_codele").value = iElemento;
  }

  function js_reload(valor) {
    obj = document.createElement('input');
    obj.setAttribute('name', 'tipocompra');
    obj.setAttribute('type', 'hidden');
    obj.setAttribute('value', valor);
    document.form1.appendChild(obj);
    document.form1.submit();
  }


  function js_pesquisa_liclicita(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('', 'db_iframe_liclicita', 'func_liclicita.php?criterioadjudicacao=true&funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_edital|l20_anousu|pc50_codcom|l03_tipo|l20_numero|l20_objeto', 'Pesquisa', true);
    } else {
      if (document.form1.e54_codlicitacao.value != '') {
        js_OpenJanelaIframe('', 'db_iframe_liclicita', 'func_liclicita.php?criterioadjudicacao=true&pesquisa_chave=' + document.form1.l20_codigo.value + '&funcao_js=parent.js_mostraliclicita', 'Pesquisa', false);
      } else {
        document.form1.e54_codlicitacao.value = '';
      }
    }
  }

  function novoAjax(params, onComplete) {

    var request = new Ajax.Request('lic4_geraAutorizacoes.RPC.php', {
      method: 'post',
      parameters: 'json=' + Object.toJSON(params),
      onComplete: onComplete
    });

  }

  function js_mostraliclicita(chave1, chave2, chave3, chave4, erro) {
    if (erro == true) {
      document.form1.emite2.disabled = true;
      alert("Licitacao ja julgada,revogada ou com autorizacao ativa.");
      document.form1.e54_codlicitacao.value = '';
      document.form1.e54_codlicitacao.focus();
    } else {
      document.form1.e54_numerl.value = chave1;
      document.form1.e54_numerll.value = chave1 + "/" + chave2;
      var e54_codcom = document.getElementById("e54_codcom"),
        e54_tipol = document.getElementById("e54_tipol");

      for (i = 0; i < e54_codcom.options.length; i++) {
        if (e54_codcom.options[i].value == chave3) {
          e54_codcom.options[i].selected = true;
          break;
        }
      }
      for (i = 0; i < e54_tipol.options.length; i++) {
        if (e54_tipol.options[i].value == chave4) {
          e54_tipol.options[i].selected = true;
          break;
        }
      }
      document.form1.e54_concarpeculiar.value = '000';
      document.form1.c58_descr.value = 'NÃO SE APLICA';
    }
  }

  function js_mostraliclicita1(chave1, chave2, chave3, chave4, chave5, chave6, chave7) {
    document.form1.e54_codlicitacao.value = chave1;
    js_pesquisa_fornecedor(chave1);
    document.form1.e54_codcom.value = chave4;
    document.form1.e54_tipol.value = chave5;
    document.form1.e54_nummodalidade.value = chave6;
    document.form1.e54_concarpeculiar.value = '000';
    document.form1.c58_descr.value = 'NÃO SE APLICA';
    document.form1.e54_resumo.value = chave7;

    document.form1.e54_numerl.value = chave2;
    document.form1.e54_numerll.value = chave2 + "/" + chave3;
    let e54_codcom = document.getElementById("e54_codcomS"),
      e54_tipol = document.getElementById("e54_tipolS");

    for (let i = 0; i < e54_codcom.options.length; i++) {
      if (e54_codcom.options[i].value == chave4) {
        e54_codcom.options[i].selected = true;
        break;
      }
    }
    for (let i = 0; i < e54_tipol.options.length; i++) {
      if (e54_tipol.options[i].value == chave5) {
        e54_tipol.options[i].selected = true;
        break;
      }
    }

    db_iframe_liclicita.hide();

  }

  function js_pesquisa_fornecedor(codlicitacao) {

    document.getElementById("e54_numcgm").innerHTML = "";
    let razaoSocial = document.getElementById("e54_numcgm");
    let params = {
      exec: 'getFonercedoresLic',
      licitacao: codlicitacao
    };

    novoAjax(params, function(e) {

      let cgms = JSON.parse(e.responseText).cgms;
      if (cgms.length > 1) {
        let opt = document.createElement("option");
        opt.value = '';
        opt.text = 'Selecione';
        razaoSocial.add(opt, 0);
      }

      cgms.forEach(function(cgm, i) {
        let opt = document.createElement("option");
        opt.value = cgm.z01_numcgm;
        opt.text = cgm.z01_nome;
        razaoSocial.add(opt, razaoSocial.options[++i]);
      });

    });
  }

  /**
   * Procura se o fornecedor possui débitos em aberto
   */
  function js_debitosemaberto() {

    var sUrlRPC = 'com4_notificafornecedor.RPC.php';
    var iCgm = $('e54_numcgm').value;

    if ($('pesquisar')) {
      $('pesquisar').disabled = true;
    }

    if ($('novo')) {
      $('novo').disabled = true;
    }

    if ($('lancemp')) {
      $('lancemp').disabled = true;
    }

    $('db_opcao').disabled = true;

    js_divCarregando('Aguarde, verificando débitos em aberto...', "msgBoxDebitosEmAberto");

    var oParam = new Object();
    oParam.sExecucao = 'debitosEmAberto';
    oParam.iNumCgm = iCgm;
    oParam.sLiberacao = "A";

    var oAjax = new Ajax.Request(sUrlRPC, {
      method: 'post',
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornodebitosemaberto
    });
  }

  /**
   * Retorno com os débitos em aberto e informações de configuração
   */
  function js_retornodebitosemaberto(oAjax) {

    js_removeObj("msgBoxDebitosEmAberto");

    var oRetorno = eval("(" + oAjax.responseText + ")");
    var iNumCgm = new Number(oRetorno.iNumCgm);
    var iParamFornecDeb = new Number(oRetorno.iParamFornecDeb);
    var iDebitosEmAberto = new Number(oRetorno.iDebitosEmAberto);
    var lParamGerarNotifDebitos = oRetorno.lParamGerarNotifDebitos;

    if (iParamFornecDeb == 1) {

      if ($('pesquisar')) {
        $('pesquisar').disabled = false;
      }

      if ($('novo')) {
        $('novo').disabled = false;
      }

      if ($('lancemp')) {
        $('lancemp').disabled = false;
      }

      $('db_opcao').disabled = false;
    } else if (iParamFornecDeb == 2) {

      if (iDebitosEmAberto > 0) {

        var sMensagem = 'O fornecedor ' + iNumCgm + ' possui débitos em aberto.';
        sMensagem += '\n Deseja Notifica-lo?';
        if (confirm(sMensagem)) {
          js_NotificacaoDebitos(iNumCgm, iParamFornecDeb, oRetorno.aFormaNotificacao, lParamGerarNotifDebitos, true);
        } else {
          js_NotificacaoDebitos(iNumCgm, iParamFornecDeb, oRetorno.aFormaNotificacao, lParamGerarNotifDebitos, false);
        }
      } else {

        if ($('pesquisar')) {
          $('pesquisar').disabled = false;
        }

        if ($('novo')) {
          $('novo').disabled = false;
        }

        if ($('lancemp')) {
          $('lancemp').disabled = false;
        }

        $('db_opcao').disabled = false;
      }
    } else if (iParamFornecDeb == 3) {

      if (iDebitosEmAberto > 0) {

        alert('O fornecedor ' + iNumCgm + ' possui débitos em aberto.');

        js_NotificacaoDebitos(iNumCgm, iParamFornecDeb, oRetorno.aFormaNotificacao, lParamGerarNotifDebitos, true);

      } else {
        if ($('pesquisar')) {
          $('pesquisar').disabled = false;
        }

        if ($('novo')) {
          $('novo').disabled = false;
        }

        if ($('lancemp')) {
          $('lancemp').disabled = false;
        }

        $('db_opcao').disabled = false;
      }
    }
  }

  /**
   * Executa a notificação de débitos ao fornecedor
   */
  function js_NotificacaoDebitos(iNumCgm, iParamFornecDeb, aFormaNotificacao, lGerarNotificacaoDebito, lMostrarJanela) {

    var iOrigem = 3;
    var iCodigoOrigem = $('e54_autori').value;

    oNotificarDebitos = new dbViewNotificaFornecedor(iNumCgm, iOrigem);
    oNotificarDebitos.setCodigoOrigem(iCodigoOrigem);
    oNotificarDebitos.setGerarNotificacaoDebito(lGerarNotificacaoDebito);
    if (lMostrarJanela) {

      oNotificarDebitos.setFormaNotificacao(aFormaNotificacao, true);
      if (aFormaNotificacao.length > 0) {
        oNotificarDebitos.show();
      } else {
        oNotificarDebitos.setFormaNotificacao(aFormaNotificacao, false);
      }
    } else {

      oNotificarDebitos.setGerarNotificacaoDebito(false);
      oNotificarDebitos.setFormaNotificacao(0, false);
    }

    /**
     * Retorno do processo de notificação de debitos
     */
    oNotificarDebitos.setCallBack(function(oRetorno) {

      if (oRetorno.lFormaNotifEmail) {
        alert(oRetorno.sMessage.urlDecode());
      }

      if (oRetorno.lFormaNotifCarta) {
        js_emitircartanotificacao(oRetorno.iCodigoNotificaBloqueioFornecedor);
      }

      if ($('pesquisar')) {
        $('pesquisar').disabled = false;
      }

      if ($('novo')) {
        $('novo').disabled = false;
      }

      if ($('lancemp')) {
        $('lancemp').disabled = false;
      }

      $('db_opcao').disabled = false;
      if (iParamFornecDeb == 3) {
        $('e54_numcgm').value = '';
        $('z01_nome').value = '';
      }
    });
  }

  function js_emitircartanotificacao(iCodigoNotificaBloqueioFornecedor) {

    var jan = window.open('com2_emitircartanotificacao002.php?iCodigoNotificaBloqueioFornecedor=' + iCodigoNotificaBloqueioFornecedor,
      '',
      'width=' + (screen.availWidth - 5) +
      ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
    jan.moveTo(0, 0);
  }
  js_carregarfornecedor();

  function js_carregarfornecedor() {
    let fornecedor = <?= $e54_numcgm ?>
    console.log(fornecedor);

  }
</script>
