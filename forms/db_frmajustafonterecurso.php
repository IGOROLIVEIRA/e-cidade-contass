<?PHP
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

//MODULO: contabilidade
$clconlancamcompl->rotulo->label();
$clconlancamval->rotulo->label();
$clconlancam->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("c50_descr");
$clrotulo->label("c70_anousu");
$clrotulo->label("c69_valor");
$clrotulo->label("c79_codsup");
$clrotulo->label("c73_coddot");
$clrotulo->label("c75_numemp");
$clrotulo->label("c74_codrec");
$clrotulo->label("c78_chave");
$clrotulo->label("c80_codord");
$clrotulo->label("c82_reduz");
$clrotulo->label("o15_descr");

$alt = false;

if (isset($c70_codlan) && $c70_codlan != "") {

  $sql1 = "select c71_codlan from conlancamdoc where c71_codlan=$c70_codlan";
  $result1 = db_query($sql1);
  $linhas1 = pg_numrows($result1);

  if ($linhas1 > 0) {

    $sql2 = "select * from conlancamdoc inner join conhistdoc on c71_coddoc=c53_coddoc where c71_codlan=$c70_codlan";
    $result2 = db_query($sql2);
    $linhas2 = pg_numrows($result2);

    if ($linhas2 > 0) {
      $oResultado  = db_utils::fieldsMemory($result2, 0);

      if ($oResultado->c53_coddoc == 980) {
        $conta_reduz = $c69_credito;
        $alt = true;
      } else {
        $alt            = false;
        $conta_reduz    = null;
        $conta_descr    = null;
        $conta_saldo    = null;
        $conta_sinal    = null;
        $c69_debito     = null;
        $debito_descr   = null;
        $debito_saldo   = null;
        $debito_sinal   = null;
        $c69_codhist    = null;
        $c50_descr      = null;
        $c70_codlan     = null;
        $c69_sequen     = null;
        $c69_valor      = null;
        $c72_complem    = null;
        $c70_data       = null;
        $c70_data_dia   = null;
        $c70_data_mes   = null;
        $c70_data_ano   = null;
        db_msgbox('Não é permitido alterar ou excluir lançamentos contábeis automáticos.');
      }
    } else {
      $alt = false;
      $conta_reduz    = null;
      $conta_descr  = null;
      $conta_saldo  = null;
      $conta_sinal  = null;
      $c69_debito     = null;
      $debito_descr   = null;
      $debito_saldo   = null;
      $debito_sinal   = null;
      $c69_codhist    = null;
      $c50_descr      = null;
      $c70_codlan     = null;
      $c69_sequen     = null;
      $c69_valor      = null;
      $c72_complem    = null;
      $c70_data       = null;
      $c70_data_dia   = null;
      $c70_data_mes   = null;
      $c70_data_ano   = null;
      db_msgbox('Não é permitido alterar ou excluir lançamentos contábeis automáticos.');
    }
  } else {
    $alt = true;
  }
  if ($alt == false) {
    if ($db_opcao == 2 || $db_opcao == 3) {
      $db_botao = false;
    }
  }
}

require_once("libs/db_app.utils.php");
db_app::load("scripts.js");
db_app::load("strings.js");
db_app::load("prototype.js");
db_app::load("estilos.css");
db_app::load("grid.style.css");
db_app::load("datagrid.widget.js");
db_app::load("widgets/windowAux.widget.js");
db_app::load("widgets/dbmessageBoard.widget.js");
db_app::load("dbcomboBox.widget.js");

?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<center>
  <form name="form1" method="post" action="">

    <fieldset style="margin-top: 30px; width: 800px;">
      <legend><strong>Manutenção de Lançamentos</strong></legend>
      <center>
        <table border="0">
          <tr>
            <td nowrap title="<?= @$Tc70_codlan ?>"> <?= @$Lc70_codlan ?> </td>
            <td><?
                db_input('c70_codlan', 10, $Ic70_codlan, true, 'text', 3);
                db_input('c69_sequen', 10, $Ic69_sequen, true, 'text', 3);
                ?>
            </td>
          </tr>
          <tr>
            <td nowrap title="Documento">
              <strong>
                Documento: 
              </strong>
            </td>
            <td>
              <?php
              $iDocumento  = 980;
              $sDocumento  = 'AJUSTE DE FONTE DE RECURSO';
              db_input('iDocumento', 10, $Ic69_debito, true, 'text', 3, "onchange='js_pesquisaDocumento(false)'");
              db_input('sDocumento', 50, null, true, 'text', 3, "js_pesquisaDocumento(false)");
              ?>
            </td>
          </tr>
          <tr>          
            <td nowrap title="<?= @$Tc69_codhist ?>">
              <strong>
                Histórico: 
              </strong>
            </td>
            <td>
              <?
              $c69_codhist = 3980;
              $c50_descr = 'AJUSTE DE FONTE DE RECURSO';
              db_input('c69_codhist', 10, $Ic69_codhist, true, 'text', 3, " onchange='js_pesquisac69_codhist(false);'");
              db_input('c50_descr', 50, $Ic50_descr, true, 'text', 3);
              ?>
            </td>
          </tr>
          <tr>
            <td nowrap title="<?= @$Tc69_credito ?>">
              <b>
                <?db_ancora('Conta:', "js_pesquisaconta(true);", $db_opcao == 1 ? $db_opcao : 3);?>
              </b>
            </td>
            <td>
              <?
              db_input('conta_reduz', 10, $Ic69_credito, true, 'text', $db_opcao == 1 ? $db_opcao : 3, " onchange='js_pesquisaconta(false);'");
              db_input('conta_descr', 50, "", true, 'text', 3, '');
              db_input('conta_saldo', 15, $Ic69_credito, true, 'text', 3, "");
              db_input('conta_sinal', 3, $Ic69_credito, true, 'text', 3, "");
              ?>
            </td>
          </tr>
          <tr>
            <td nowrap title="<?= @$To15_codigo ?>">
              <b>
                <?db_ancora('Fonte Recurso Debito:', "js_pesquisao15_codigo_debito(true);", $db_opcao);?>
              </b>
            </td>
            <td>
              <?
              db_input('o15_codigo_debito', 10, $Io15_codigo, true, 'text', $db_opcao, " onchange='js_pesquisao15_codigo_debito(false);'")
              ?>
              <?
              db_input('o15_descr_debito', 50, $Io15_descr, true, 'text', 3, '')
              ?>
            </td>
          </tr>
          <tr>
            <td nowrap title="<?= @$To15_codigo ?>">
              <b>
                <?db_ancora('Fonte Recurso Credito:', "js_pesquisao15_codigo_credito(true);", $db_opcao);?>
              </b>
            </td>
            <td>
              <?
              db_input('o15_codigo_credito', 10, $Io15_codigo, true, 'text', $db_opcao, " onchange='js_pesquisao15_codigo_credito(false);'")
              ?>
              <?
              db_input('o15_descr_credito', 50, $Io15_descr, true, 'text', 3, '')
              ?>
            </td>
          </tr>
          <tr>
            <td nowrap title="<?= @$Tc69_valor ?>"> <?= @$Lc69_valor ?> </td>
            <td><? db_input('c69_valor', 10, $Ic69_valor, true, 'text', $db_opcao); ?></td>
          </tr>
          <tr>
            <td nowrap title="<?= @$Tc70_data ?>"> <?= @$Lc70_data ?> </td>
            <td>
              <?
              if ($db_opcao == "1" && (!isset($c70_data_dia))) {
                $c70_data_dia = "";
                $c70_data_mes = "";
                $c70_data_ano = "";
              }
              db_inputdata('c70_data', $c70_data_dia, $c70_data_mes, $c70_data_ano, true, 'text', $db_opcao, 'onchange="js_pesquisaconta(false)"',"","","none","","",'js_pesquisaconta(false)');
              ?>
            </td>
          </tr>
          <tr>
            <td nowrap title="<?= @$Tc72_complem ?>" colspan="2">
              <fieldset>
                <legend><?= @$Lc72_complem ?></legend>
                <?php
                if (isset($c70_codlan) && ($c70_codlan != "")) {
                  $r = $clconlancamcompl->sql_record($clconlancamcompl->sql_query_file($c70_codlan, "*", "", ""));
                  if ($clconlancamcompl->numrows > 0) {
                    db_fieldsmemory($r, 0);
                  }
                }
                db_textarea("c72_complem", 4, 100, "", true, 'text', $db_opcao);
                ?>
              </fieldset>
            </td>
          </tr>

          <tr>
            <td colspan="2" align="center">
            <input name="db_opcao" type="button" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir"))?>"
              <?= ($db_botao == false ? "disabled" : "")?> onclick="js_validaDados(); ">
            <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
        </table>
      </center>
    </fieldset>

  </form>

</center>
<script>
  if ($('conta_reduz').value != ''){
    js_pesquisaconta(false);
  }

  function js_validaDados() {
    obj = document.form1;
    if (obj.iDocumento.value == "") {
      alert('Campo Documento Obrigatório.');
      obj.conta_reduz.focus();
      return false;
    } else if (obj.conta_reduz.value == "") {
      alert('Campo Conta Obrigatório.');
      obj.conta_reduz.focus();
      return false;
    } else if (obj.c69_codhist.value == "") {c69_codhist
      alert('Campo Histórico Obrigatório.');
      obj.c69_codhist.focus();
      return false;
    } else if (obj.c69_valor.value == "") {
      alert('Campo Valor Obrigatório.');
      obj.c69_valor.focus();
      return false;
    } else if (obj.o15_codigo_debito.value == "") {
      alert('Campo Fonte Debito Obrigatório.');
      obj.c69_valor.focus();
      return false;
    } else if (obj.o15_codigo_credito.value == "") {
      alert('Campo Fonte Credito Obrigatório.');
      obj.c69_valor.focus();
      return false;
    } else if (obj.c70_data.value == "") {
      alert('Campo Data Obrigatório.');
      obj.c69_valor.focus();
      return false;
    } else if (obj.c72_complem.value == "") {
      alert("Informe o Texto Complementar do lançamento.");
      return false;
    } else {

      var opcao = document.createElement("input");
      opcao.setAttribute("type", "hidden");
      opcao.setAttribute("name", "db_opcao");
      opcao.setAttribute("value", document.form1.db_opcao.value);
      document.form1.appendChild(opcao);
      document.form1.submit();
    }
  }

  function js_limpaDados() {
    $("conta_reduz").value = "";
    $("conta_descr").value = "";
    $("conta_saldo").value = "";
    $("conta_sinal").value = "";

    if ($("o15_codigo_debito") != undefined){
      $("o15_codigo_debito").value = "";
      $("o15_codigo_credito").value = "";
      $("o15_descr_debito").value = "";
      $("o15_descr_credito").value = "";      
    } else {
      $("o15_codigo").value = "";
      $("o15_descr").value = "";
    }

    $("c69_codhist").value = "";
    $("c50_descr").value = "";

  }

  function js_pesquisac69_codhist(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_conhist', 'func_conhist.php?funcao_js=parent.js_mostraconhist1|c50_codhist|c50_descr', 'Pesquisa', true);
    } else {
      if (document.form1.c69_codhist.value != '') {
        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_conhist', 'func_conhist.php?pesquisa_chave=' + document.form1.c69_codhist.value + '&funcao_js=parent.js_mostraconhist', 'Pesquisa', false);
      } else {
        document.form1.c50_descr.value = '';
      }
    }
  }

  function js_mostraconhist(chave, erro) {
    document.form1.c50_descr.value = chave;
    if (erro == true) {
      document.form1.c69_codhist.focus();
      document.form1.c69_codhist.value = '';
    }
  }

  function js_mostraconhist1(chave1, chave2) {
    document.form1.c69_codhist.value = chave1;
    document.form1.c50_descr.value = chave2;
    db_iframe_conhist.hide();
  }

  function js_pesquisaconta(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_conplanoexe', 'func_conplanoexelanc.php?lContaCorrente=true&dataret=' + document.form1.c70_data_ano.value + '-' + document.form1.c70_data_mes.value + '-' + document.form1.c70_data_dia.value + '&funcao_js=parent.js_mostra_conta', 'Pesquisa', true);
    } else {
      if (document.form1.conta_reduz.value != '') {
        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_conplanoexe', 'func_conplanoexelanc.php?lContaCorrente=true&dataret=' + document.form1.c70_data_ano.value + '-' + document.form1.c70_data_mes.value + '-' + document.form1.c70_data_dia.value + '&pesquisa_chave=' + document.form1.conta_reduz.value + '&funcao_js=parent.js_mostra_conta2', 'Pesquisa', false);
      } else {
        document.form1.conta_reduz.value = '';
      }
    }
  }

  function js_mostra_conta(chave1, chave2, chave3, chave4) {
    document.form1.conta_reduz.value = chave1;
    document.form1.conta_descr.value = chave2;
    document.form1.conta_saldo.value = chave3;
    document.form1.conta_sinal.value = chave4;
    db_iframe_conplanoexe.hide();
  }

  function js_mostra_conta2(chave1, erro, chave2, chave3) {
    document.form1.conta_descr.value = chave1;
    document.form1.conta_saldo.value = chave2;
    document.form1.conta_sinal.value = chave3;
    if (erro == true) {
      document.form1.conta_reduz.focus();
      document.form1.conta_reduz.value = '';
    }
  }

  function js_pesquisa() {
    js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_conlancamval', 'func_conlancamval.php?chave_c69_codhist=3980&funcao_js=parent.js_preenchepesquisa|c69_sequen', 'Pesquisa', true);
  }

  function js_preenchepesquisa(chave) {
    js_limpaDados();
    db_iframe_conlancamval.hide();
    <?

    if ($db_opcao != 1) {

      echo " location.href = '"
        . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])
        . "?chavepesquisa='+chave";
    }
    ?>
  }

  function js_pesquisaDocumento(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('', 'db_iframe_documento',
        'func_conhistdoc.php?iCodigoTipoDocumento=3000&funcao_js=parent.js_mostraDocumento1|c53_coddoc|c53_descr', 'Pesquisa', true);
    } else {

      if (document.form1.iDocumento.value != '') {
        js_OpenJanelaIframe('',
          'db_iframe_documento',
          'func_conhistdoc.php?iCodigoTipoDocumento=3000&pesquisa_chave=' + document.form1.iDocumento.value +
          '&funcao_js=parent.js_mostraDocumento', 'Pesquisa', false);
      } else {
        document.form1.sDocumento.value = '';
      }
    }
  }

  function js_mostraDocumento(chave, erro) {
    document.form1.sDocumento.value = chave;
    if (erro == true) {
      document.form1.iDocumento.focus();
      document.form1.iDocumento.value = '';
    }
  }

  function js_mostraDocumento1(chave1, chave2) {

    document.form1.iDocumento.value = chave1;
    document.form1.sDocumento.value = chave2;
    db_iframe_documento.hide();
  }

  function js_pesquisao15_codigo_debito(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('', 'db_iframe_orctiporec', 'func_orctiporec.php?funcao_js=parent.js_mostraorctiporec1_debito|o15_codigo|o15_descr', 'Pesquisa', true);
    } else {
      js_OpenJanelaIframe('', 'db_iframe_orctiporec', 'func_orctiporec.php?pesquisa_chave=' + document.form1.o15_codigo_debito.value + '&funcao_js=parent.js_mostraorctiporec_debito', 'Pesquisa', false);
    }
  }

  function js_mostraorctiporec_debito(chave, erro) {
    document.form1.o15_descr_debito.value = chave;
    if (erro == true) {
      document.form1.o15_codigo_debito.focus();
      document.form1.o15_codigo_debito.value = '';
    }
  }

  function js_mostraorctiporec1_debito(chave1, chave2) {
    document.form1.o15_codigo_debito.value = chave1;
    document.form1.o15_descr_debito.value = chave2;
    db_iframe_orctiporec.hide();
  }


  function js_pesquisao15_codigo_credito(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('', 'db_iframe_orctiporec', 'func_orctiporec.php?funcao_js=parent.js_mostraorctiporec1_credito|o15_codigo|o15_descr', 'Pesquisa', true);
    } else {
      js_OpenJanelaIframe('', 'db_iframe_orctiporec', 'func_orctiporec.php?pesquisa_chave=' + document.form1.o15_codigo_credito.value + '&funcao_js=parent.js_mostraorctiporec_credito', 'Pesquisa', false);
    }
  }

  function js_mostraorctiporec_credito(chave, erro) {
    document.form1.o15_descr_credito.value = chave;
    if (erro == true) {
      document.form1.o15_codigo_credito.focus();
      document.form1.o15_codigo_credito.value = '';
    }
  }

  function js_mostraorctiporec1_credito(chave1, chave2) {
    document.form1.o15_codigo_credito.value = chave1;
    document.form1.o15_descr_credito.value = chave2;
    db_iframe_orctiporec.hide();
  }
</script>