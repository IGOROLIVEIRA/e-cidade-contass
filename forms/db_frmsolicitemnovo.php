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


//MODULO: compras
$sArquivoRedireciona = basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
$result_tipo = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit"), "pc30_seltipo,pc30_tipoemiss"));
if ($clpcparam->numrows > 0) {
  db_fieldsmemory($result_tipo, 0);
}

$iOpcaoTipoSolicitacao = $db_opcao;

if ((isset($opcao) && $opcao == "alterar")) {
  echo "<script>var operador = 1;</script>";
} else {
  echo "<script>var operador = 0;</script>";
}

?>
<div>
  <form name="form1" method="post" action="">
    <fieldset>
      <legend><strong>Adicionar Item</strong></legend>
      <table border="0">
        <tr>
          <td nowrap title="<?= @$Tpc16_codmater ?>">
            <?
            db_ancora("Código do material", "js_pesquisapc16_codmater(true);", $tranca);
            ?>
          </td>

          <td>
            <?
            db_input('pc16_codmater', 8, $Ipc16_codmater, true, 'text', $tranca, " onchange='js_pesquisapc16_codmater(false);'");
            db_input("iCodigoRegistro", 8, "iCodigoRegistro", true, 'hidden', $db_opcao);
            db_input("pc01_veiculo", 8, "", true, 'hidden', $db_opcao);
            db_input("codigoitemregistropreco", 8, "", true, 'hidden', $db_opcao);
            db_input("pcmateranterior", 8, $pcmateranterior, true, 'hidden', $db_opcao);
            ?>
          </td>

          <td nowrap style="   display: block;">
            <?
            db_input('pc01_descrmater', 45, $Ipc01_descrmater, true, 'text', $db_opcao, "onchange='js_pesquisa_desdobramento();'");
            ?>
          </td>

          <td nowrap>
            <b> Quantidade: </b>
          </td>
          <td nowrap>

            <?
            db_input('pc01_quantidade', 8, $pc01_quantidade, true, 'text', $db_opcao, '');
            ?>
          </td>

          <td id="titleUnidade" nowrap>
            <b> Unidade: </b>
          </td>

          <td nowrap>


            <?
            $unidade = array();


            $result = db_query("select * from matunid");
            if (pg_numrows($result) != 0) {
              $numrows = pg_numrows($result);
              $unidade[0] = "";

              for ($i = 0; $i < $numrows; $i++) {
                $matunid = db_utils::fieldsMemory($result, $i);

                $unidade[$matunid->m61_codmatunid] = $matunid->m61_descr;
                /*
      echo "<option value=\"$matunid->m61_codmatunid \">$matunid->m61_descr</option>";
      */
              }
            }

            db_select(
              "pc17_unid",
              $unidade,
              true,
              $db_opcao,
              ""
            );

            ?>

          </td>

          <td><strong id='ctnServicoQuantidade' style="display:none;">Controlado por Quantidades: </strong></td>
          <td>
            <?php

            if (substr($o56_elemento, 0, 7) == '3449052') {
              $aOpcoes = array("true" => "SIM");
            } else {
              $aOpcoes = array("false" => "NÃO", "true" => "SIM");
            }

            db_select('pc11_servicoquantidade', $aOpcoes, true, $db_opcao, "style='display:none;' onchange='js_changeControladoPorQtd(this.value);'");
            ?>
          </td>

        </tr>


        <tr>
          <div id="codeleRow">
            <?

            if (isset($o56_codele) && $o56_codele != "") {
              $o56_elemento_ant = $o56_codele;
            }
            if (isset($pc16_codmater) && trim($pc16_codmater) != "") {
              $sql_record = $clpcmaterele->sql_record($clpcmaterele->sql_query($pc16_codmater, null, "o56_codele,o56_descr,o56_elemento", "o56_descr"));
              $dad_select = array();
              for ($i = 0; $i < $clpcmaterele->numrows; $i++) {
                db_fieldsmemory($sql_record, $i);
                //$dad_select[$o56_codele] = $o56_codele." - ".db_formatar($o56_elemento,"elemento_int")." - ".$o56_descr;
                $dad_select[$o56_codele] = $o56_codele . " - " . $o56_elemento . " - " . $o56_descr;
              }
            }
            if (isset($o56_codele_ant)) {
              $o56_codele = $o56_elemento_ant;
            }
            $numrows_materele = $clpcmaterele->numrows;
            if ($numrows_materele > 0) {
            ?>
              <td nowrap title="<?= @$To56_descr ?>">
                <strong>Sub. ele:</strong>
              </td>
              <td nowrap colspan="6">
                <?
                $result_pc18ele = $clsolicitemele->sql_record($clsolicitemele->sql_query_file($pc11_codigo, null, "pc18_codele as o56_codele"));
                if ($clsolicitemele->numrows > 0) {
                  db_fieldsmemory($result_pc18ele, 0);
                }

                db_select("o56_codele", $dad_select, true, $trancaCodEle, "");
                if (isset($o56_codelefunc) && $o56_codelefunc != "") {
                  echo "<script>document.form1.o56_codele.value=$o56_codelefunc;</script>";
                }
                ?>

              </td>

            <?
            }
            db_input("o56_codelefunc", 5, $Io56_codele, true, 'hidden', $db_opcao);
            ?>

          </div>
          <div id="subEl">
            <td colspan="2" nowrap title="<?= @$To56_descr ?>">
              <strong>Desdobramento:</strong>
            </td>
            <td>
              <select style="margin-left: -80;width: 405;" id="eleSub" name="eleSub">
                <option value="0"> </option>;
              </select>
            </td>
          </div>

          <td style="display: none;" id="titleUnidade2" nowrap>
            <b> Unidade: </b>
          </td>

          <td nowrap>


            <?
            $unidade = array();


            $result = db_query("select * from matunid");
            if (pg_numrows($result) != 0) {
              $numrows = pg_numrows($result);
              $unidade[0] = "";

              for ($i = 0; $i < $numrows; $i++) {
                $matunid = db_utils::fieldsMemory($result, $i);

                $unidade[$matunid->m61_codmatunid] = $matunid->m61_descr;
                /*
      echo "<option value=\"$matunid->m61_codmatunid \">$matunid->m61_descr</option>";
      */
              }
            }

            db_select(
              "pc17_unid2",
              $unidade,
              true,
              $db_opcao,
              "style='display: none;'"
            );

            ?>

          </td>

          <td>
            <b style="margin-left: -73px;" id="titleOrdem"> Ordem: </b>
          </td>
          <td>
            <?
            db_input('pc01_ordem', 8, $Ipc01_descrmater, true, 'text', $db_opcao, 'onkeypress="return event.charCode >= 48 && event.charCode <= 57" style="margin-left: -82px;"');
            ?>
          </td>

        </tr>

      </table>
      <input style="float:center; margin-top:10px;" name="<?= ($db_opcao == 1 ? "Adicionar Item" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="button" id="db_opcao" value="<?= ($db_opcao == 1 ? "Adicionar Item" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?> onclick="return js_adicionarItem()">

    </fieldset>

    <table>
      <tr>
        <td>
          <fieldset>
            <legend>Itens</legend>
            <div id='ctnGridItens' style="width: 1000px"></div>
          </fieldset>
        </td>
      </tr>
    </table>
    <input style="float:center; margin-top:10px;" name="salvar" type="submit" value="Salvar Itens">


    <br>

  </form>
</div>
<script>
  const input = document.getElementById("pc01_quantidade");
  input.addEventListener("keypress", mask_4casasdecimais);

  numeros_apos_virgula = 0;


  function mask_4casasdecimais(e) {
    var valor = e.target.value.replace(/[^0-9\,]/g, "");
    virgula = (valor.match(/,/g) || []).length;

    if (e.key == '.') {
      e.preventDefault();
      return false;
    }

    if (virgula >= 1 && e.key == ',') {
      e.preventDefault();
      return false;
    }

    if (valor.length >= 14) {
      valor = valor.substring(0, valor.length - 1);
      e.target.value = valor;
      return false;
    }


    if (virgula == 1) {
      numeros_apos_virgula = valor.substring(valor.indexOf(",") + 1);

    }


    if (numeros_apos_virgula.length == 4) {
      valor = valor.substring(0, valor.length - 1);
      e.target.value = valor;
      numeros_apos_virgula = 0;
      return false;
    }
    e.target.value = valor;

  }

  function js_changeControladoPorQtd(quantidade) {


    if (quantidade == 'true') {

      document.getElementById('pc17_unid2').style.display = "block";
      document.getElementById('titleUnidade2').style.display = "block";
      document.getElementById('pc01_ordem').style.marginLeft = "0px";
      document.getElementById('titleOrdem').style.marginLeft = "60px";
      document.getElementById('ctnServicoQuantidade').style.marginLeft = "-170px";
      document.getElementById('pc11_servicoquantidade').style.marginLeft = "-80px";
      document.getElementById('pc11_servicoquantidade').style.width = "76px";




    } else {
      document.getElementById('pc17_unid2').style.display = "none";
      document.getElementById('titleUnidade2').style.display = "none";
      document.getElementById('pc01_ordem').style.marginLeft = "-82px";
      document.getElementById('titleOrdem').style.marginLeft = "-73px";
      document.getElementById('ctnServicoQuantidade').style.marginLeft = "0px";
      document.getElementById('pc11_servicoquantidade').style.marginLeft = "0px";
      document.getElementById('pc11_servicoquantidade').style.width = "48px";
    }

  }

  function js_buscarEle() {
    var sUrl = "com4_materialsolicitacao.RPC.php";

    var oRequest = new Object();
    oRequest.pc_mat = $F('pc16_codmater').valueOf();
    oRequest.exec = "getDadosElementos";
    var oAjax = new Ajax.Request(
      sUrl, {
        method: 'post',
        parameters: 'json=' + js_objectToJson(oRequest),
        onComplete: js_retornogetDados
      }
    );

  }

  function js_retornogetDados(oAjax) {
    var oRetorno = eval("(" + oAjax.responseText + ")");
    var i = 0;

    if (oRetorno.dados.length > 1) {
      $('eleSub').options[0] = new Option('Selecione', '0');

      i = 1;
    }

    if (oRetorno.dados.length == 1) {
      $('eleSub').disabled = true;
    } else {
      $('eleSub').disabled = false;

    }

    oRetorno.dados.forEach(function(oItem) {
      valor = oItem.codigo + " - " + oItem.elemento + " - " + oItem.nome.urlDecode();
      valorElem = oItem.elemento;
      $('eleSub').options[i] = new Option(valor, oItem.codigo);
      i++;
    });

    document.getElementById("subEl").style.display = "table-row";

    valorEle = document.getElementById("o56_codele_select_descr").value;
    const val = valorEle.split("-");
    const num = val[1].split(" ");
    if ((num[1].substr(0, 7)) != (valorElem.substr(0, 7))) {
      alert("Elemento do item selecionado diferente do item anterior, é necessário remover as dotações vinculadas ao item para a troca do material");
      var input = document.querySelector("#db_opcao");
      input.disabled = true;
      document.getElementById("codeleRow").style.display = "table-row";
      document.form1.o56_codele_select_descr.focus();
    } else {
      var input = document.querySelector("#db_opcao");
      input.disabled = false;
    }
    //$('ctnServicoQuantidade').style.display='table-row';

  }

  function js_materanterior() {

    <?
    echo "materanterior = '$pcmateranterior';\n";
    if ($iRegistroPreco != "") {
      echo  "document.form1.submit();";
    } else {
      echo "
    if(materanterior!=document.form1.pc16_codmater.value){
      document.form1.submit();
    }
  //js_pesquisapc01_servico(document.form1.pc16_codmater.value);
  ";
    }
    ?>
  }

  function js_pesquisapc16_codmater(mostra) {


    var iRegistroPrecoFuncao = false;
    <?
    $sUrlLookup = "func_pcmatersolicita.php";
    $sFiltro    = "";
    if ($iRegistroPreco != "") {

      $sUrlLookup = 'func_pcmaterregistropreco.php';
      echo "iRegistroPrecoFuncao = true;\n";
      $sFiltro = "|pc11_codigo";
    }
    ?>
    if (mostra == true || iRegistroPrecoFuncao) {
      js_OpenJanelaIframe('',
        'db_iframe_pcmater',
        '<?= $sUrlLookup ?>?funcao_js=parent.js_mostrapcmater1' +
        '|pc01_codmater|pc01_descrmater|o56_codele|pc01_servico<?= $sFiltro ?><?= $db_opcao == 1 ? "&opcao_bloq=3&opcao=f" : "&opcao_bloq=1&opcao=i" ?>' +
        '&iRegistroPreco=<?= $iRegistroPreco; ?>',
        'Pesquisa de Materiais',
        true);
    } else {
      if (document.form1.pc16_codmater.value != '') {
        js_OpenJanelaIframe('',
          'db_iframe_pcmater',
          '<?= $sUrlLookup ?>?pesquisa_chave=' +
          document.form1.pc16_codmater.value +
          '&iRegistroPreco=<?= $iRegistroPreco; ?>' +
          '&funcao_js=parent.js_mostrapcmater<?= $db_opcao == 1 ? "&opcao_bloq=3&opcao=f" : "&opcao_bloq=1&opcao=i" ?>',
          'Pesquisa', false, '0');
      } else {
        document.form1.pc01_descrmater.value = '';

        document.form1.submit();
      }
    }
  }

  function js_pesquisa_desdobramento() {

    if (document.form1.pc01_descrmater.value == '') {
      document.form1.pc16_codmater.value = '';

      var options = document.querySelectorAll('#eleSub option');
      options.forEach(o => o.remove());
      $('eleSub').options[0] = new Option('', '0');

      return false;
    }

    var iRegistroPrecoFuncao = false;
    <?
    $sUrlLookup = "func_pcmatersolicita.php";
    $sFiltro    = "";
    if ($iRegistroPreco != "") {

      $sUrlLookup = 'func_pcmaterregistropreco.php';
      echo "iRegistroPrecoFuncao = true;\n";
      $sFiltro = "|pc11_codigo";
    }
    ?>

    if (document.form1.pc16_codmater.value != '') {
      js_OpenJanelaIframe('',
        'db_iframe_pcmater',
        '<?= $sUrlLookup ?>?pesquisa_chave=' +
        document.form1.pc16_codmater.value +
        '&iRegistroPreco=<?= $iRegistroPreco; ?>' +
        '&funcao_js=parent.js_mostrapcmater<?= $db_opcao == 1 ? "&opcao_bloq=3&opcao=f" : "&opcao_bloq=1&opcao=i" ?>',
        'Pesquisa', false, '0');
    } else {
      document.form1.pc01_descrmater.value = '';

      document.form1.submit();
    }
  }

  function js_mostrapcmater(chave, erro, lVeic, servico) {

    if (erro == true) {
      document.form1.pc16_codmater.focus();
      document.form1.pc16_codmater.value = '';


    } else {
      document.form1.pc01_descrmater.value = chave;
      if (servico == 't') {
        document.getElementById('titleUnidade').style.display = "none";
        document.getElementById('pc17_unid').style.display = "none";
        document.getElementById('ctnServicoQuantidade').style.display = "block";
        document.getElementById('pc11_servicoquantidade').style.display = "block";

      } else {
        document.getElementById('titleUnidade').style.display = "block";
        document.getElementById('pc17_unid').style.display = "block";
        document.getElementById('ctnServicoQuantidade').style.display = "none";
        document.getElementById('pc11_servicoquantidade').style.display = "none";
        document.getElementById('pc17_unid2').style.display = "none";
        document.getElementById('titleUnidade2').style.display = "none";
        document.getElementById('pc01_ordem').style.marginLeft = "-82px";
        document.getElementById('titleOrdem').style.marginLeft = "-73px";
      }
      js_buscarEle();

    }
  }

  function js_mostrapcmater1(chave1, chave2, codele, servico, iRegistro) {


    document.form1.pc16_codmater.value = chave1;
    document.form1.pc01_descrmater.value = chave2;
    document.form1.o56_codelefunc.value = codele;

    db_iframe_pcmater.hide();

    if (servico == 't') {
      document.getElementById('titleUnidade').style.display = "none";
      document.getElementById('pc17_unid').style.display = "none";
      document.getElementById('ctnServicoQuantidade').style.display = "block";
      document.getElementById('pc11_servicoquantidade').style.display = "block";

    } else {
      document.getElementById('titleUnidade').style.display = "block";
      document.getElementById('pc17_unid').style.display = "block";
      document.getElementById('ctnServicoQuantidade').style.display = "none";
      document.getElementById('pc11_servicoquantidade').style.display = "none";
      document.getElementById('pc17_unid2').style.display = "none";
      document.getElementById('titleUnidade2').style.display = "none";
      document.getElementById('pc01_ordem').style.marginLeft = "-82px";
      document.getElementById('titleOrdem').style.marginLeft = "-73px";
    }

    js_buscarEle();

  }

  function js_esconteVeic(mostra) {

    if (!mostra) {
      mostra = "f";
    }

    if (mostra == "t") {
      document.form1.pc01_veiculo.value = "t";
    } else {
      if (document.form1.pc01_veiculo.value == "t") {
        document.getElementById("MostraVeiculos").style.display = "none";
        document.form1.ve01_placa = "";
        document.form1.pc14_veiculos.value = "";
      }
      document.form1.pc01_veiculo.value = "";
    }

  }

  function js_adicionarItem() {

    if (document.getElementById('pc17_unid2').style.display == 'block') {
      if ($F('pc17_unid2') == "0") {
        alert('Informe a Unidade!');
        return false;
      }
    } else {
      if ($F('pc17_unid') == "0" && document.getElementById('pc11_servicoquantidade').style.display != 'block') {

        alert('Informe a unidade!');
        return false;

      }

    }

    if ($F('eleSub') == "0") {

      alert('Informe o Desdobramento!');
      return false;

    }

    if ($F('pc16_codmater') == "") {

      alert('Informe o material!');
      return false;

    }

    if ($F('pc01_ordem') == "") {

      alert('Informe a ordem!');
      return false;

    }

    if ($F('pc01_quantidade') == "") {

      alert('Informe a quantidade!');
      return false;

    }


    var sizeItens = oGridItens.aRows.length;

    itens_antigos = oGridItens.aRows;

    // Verifica se o item já foi incluído com o sequencial informado.
    for (var i = 0; i < sizeItens; i++) {
      if (document.getElementById('pc01_ordem').value == itens_antigos[i].aCells[0].content) {
        alert('O item ' + itens_antigos[i].aCells[1].content + ' já foi incluído com o sequencial ' + document.getElementById('pc01_ordem').value + ' nesta solicitação.');
        return;
      }
    }


    oGridItens.clearAll(true);

    var aLinha = new Array();

    aLinha[0] = document.getElementById('pc01_ordem').value;
    aLinha[1] = document.getElementById('pc16_codmater').value;
    aLinha[2] = document.getElementById('pc01_descrmater').value;

    var select;
    var option;
    var unidade;

    if (document.getElementById('pc17_unid2').style.display == 'block') {
      select = document.getElementById('pc17_unid2');
    } else {
      select = document.getElementById('pc17_unid');

    }

    option = select.children[select.selectedIndex];
    unidade = option.textContent;

    aLinha[3] = unidade;
    aLinha[4] = "<input type='button' value='A' onclick='js_excluirLinha()'> <input type='button' value='E' onclick='js_excluirLinha()'>";
    aLinha[5] = document.getElementById('eleSub').value;
    aLinha[6] = document.getElementById('pc01_quantidade').value;

    oGridItens.addRow(aLinha);

    for (var i = 0; i < sizeItens; i++) {
      oGridItens.addRow(itens_antigos[i]);
    }

    oGridItens.renderRows();


  }



  oGridItens = new DBGrid('oGridItens');
  oGridItens.nameInstance = 'oGridItens';
  oGridItens.setCellAlign(['center', 'center', "center", "center", "center", "center", "center"]);
  oGridItens.setCellWidth(["10%", "10%", "50%", "20%", "10%", "0%", "0%"]);
  oGridItens.setHeader(["Ordem", "Código", "Descrição", "Unidade", "Ação", "", ""]);
  oGridItens.aHeaders[5].lDisplayed = false;
  oGridItens.aHeaders[6].lDisplayed = false;


  oGridItens.setHeight(200);
  oGridItens.show($('ctnGridItens'));


  oAutoComplete = new dbAutoComplete($('pc01_descrmater'), 'com4_pesquisamateriais.RPC.php');
  oAutoComplete.setTxtFieldId(document.getElementById('pc16_codmater'));
  oAutoComplete.show();
</script>