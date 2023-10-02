<?php
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

/**
 * 
 * @author I
 * @revision $Author: dbbruno.silva $
 * @version $Revision: 1.7 $
 */
require("libs/db_stdlib.php");
require("std/db_stdClass.php");
require("libs/db_utils.php");
require("libs/db_app.utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

db_postmemory($HTTP_POST_VARS); //echo '<pre>';print_r($HTTP_POST_VARS);die;
db_postmemory($HTTP_GET_VARS);

$clrotulo = new rotulocampo;
$clrotulo->label("pc16_codmater");
$clrotulo->label("pc11_just");
$clrotulo->label("pc11_resum");
$clrotulo->label("pc11_pgto");
$clrotulo->label("pc11_prazo");
$clrotulo->label("pc01_descrmater");
$oDaoUnidades = db_utils::getDao("matunid");
$sSqlUnid     = $oDaoUnidades->sql_query_file(null, "m61_codmatunid,substr(m61_descr,1,20) as m61_descr,
                                                     m61_usaquant,m61_usadec", "m61_descr");
$rsUnid             = $oDaoUnidades->sql_record($sSqlUnid);
$aUnidades          = db_utils::getColectionByRecord($rsUnid);
$aParametrosCompras = db_stdClass::getParametro("pcparam", array(db_getsession("DB_anousu")));
$db_opcao           = 1;
?>
<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <?
  db_app::load("scripts.js, strings.js, prototype.js,datagrid.widget.js, widgets/dbautocomplete.widget.js");
  db_app::load("widgets/windowAux.widget.js");
  ?>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="js_init()">
  <center>
    <table width="70%">
      <tr>
        <td>
          <fieldset>
            <legend><strong>Importar Itens</strong></legend>
            <form name="form2" id='form2' method="post" action="" enctype="multipart/form-data">

              <table align="left" style="margin-left:44px;">
                <tr>
                  <td>
                    <b> Importar Itens: </b>
                    <select id="importaritens" name="importaritens" onchange="importar()" ali>
                      <option value="1" selected>Não</option>
                      <option value="2">Sim</option>
                    </select>
                  </td>
                  <td id="anexarimportacao" style="display: none;">
                    <b style="margin-left:100px;"> Importar xls: </b>
                    <?php
                    db_input("uploadfile", 30, 0, true, "file", 1);
                    db_input("namefile", 31, 0, true, "hidden", 1);

                    ?>
                  </td>
                </tr>
              </table>
              <table id="inputimportacao" style="display: none;margin-top: 30px;margin-left: -200px;" align="left">
                <tr>
                  <td>
                    <input name='exportar' type='button' id="exportar" value="Gerar Planilha" onclick="gerar()" />
                    <input name='processar' type='button' id="Processar" value="Processar" onclick="processarItens()" />
                  </td>
                </tr>
              </table>
            </form>
            <div id='anexo' style='display:none'></div>
          </fieldset>
        </td>
      </tr>

      <tr>
        <td>
          <fieldset>
            <legend>
              <b>Adicionar Item</b>
            </legend>
            <table>
              <tr>
                <td>
                  <?
                  db_ancora(@$Lpc16_codmater, "js_pesquisapc16_codmater(true);", 1);
                  ?>
                </td>
                <td nowrap>
                  <?
                  $pc17_quant = 1;
                  db_input('pc16_codmater', 8, $Ipc16_codmater, true, 'text', 1, " onchange='js_pesquisapc16_codmater(false);'");
                  db_input('pc01_descrmater', 50, $Ipc01_descrmater, true, 'text', 1, '');
                  db_select('pc17_unid', array(), true, 1, "style='width:150px' onchange='js_usaQuantidade(this)'");
                  db_input('pc17_quant', 5, 0, true, 'text', 1, "style='display:none'");
                  ?>
                </td>
              </tr>
              <tr>
                <td>
                </td>
                <td>
                  <input type='button' id='btnOutrasInf' value='Mais Informações'>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="text-align: center;">
                  <input type="button" value='Adicionar Item' id='btnAddItem'>
                  <input type="button" value='Alterar Item' id='btnAlterarItem' style="display: none;">

                </td>
              </tr>
            </table>
          </fieldset>
        </td>
      </tr>
      <tr>
        <td>
          <fieldset>
            <legend>
              <b>Itens Cadastrados</b>
            </legend>
            <div id='gridItensSolicitacao'>

            </div>
          </fieldset>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: center;">
          <input type="button" value="Salvar Itens" id='btnSalvarItens'>
          <input type='button' value='Exportar Planilha' id='exportarPlanilha' onclick="exportar()">
          <input style="display: none;" onclick="js_lancarEstimativa()" type="button" value="Lançar Estimativa" id='btnLancarEstimativa'>
        </td>
      </tr>
    </table>
  </center>
</body>
<div id='divOUtrasInf' style='display: none; text-align: center;'>
  <table width="100%">
    <tr>
      <td>
        <fieldset>
          <legend>
            <b>Dados Complementares</b>
          </legend>
          <table>
            <tr>
              <td nowrap title="<?= @$Tpc11_prazo ?>">
                <?= @$Lpc11_prazo ?>
              </td>
              <td>
                <?
                db_textarea('pc11_prazo', 3, 30, $Ipc11_prazo, true, 'text', $db_opcao)
                ?>
              </td>
            </tr>
            <tr>
              <td nowrap title="<?= @$Tpc11_pgto ?>">
                <?= @$Lpc11_pgto ?>
              </td>
              <td>
                <?
                db_textarea('pc11_pgto', 3, 30, $Ipc11_pgto, true, 'text', $db_opcao);
                ?>
              </td>
            </tr>
            <tr>
              <td nowrap title="<?= @$Tpc11_resum ?>">
                <?= @$Lpc11_resum ?>
              </td>
              <td>
                <?
                db_textarea('pc11_resum', 3, 30, $Ipc11_resum, true, 'text', $db_opcao)
                ?>
              </td>
            </tr>
            <tr>
              <td nowrap title="<?= @$Tpc11_just ?>">
                <?= @$Lpc11_just ?>
              </td>
              <td>
                <?
                db_textarea('pc11_just', 3, 30, $Ipc11_just, true, 'text', $db_opcao)
                ?>
              </td>
            </tr>
          </table>
        </fieldset>
      </td>
    </tr>
    <tr>
      <td colspan="4" style='text-align: center'>
        <input type='button' value='Salvar Informações' id='btnFecharWindowAux' onclick='windowAuxiliar.hide()'>
      </td>
    </tr>
  </table>
</div>

</html>
<div id='div1' style='display: none;'></div> <br>
<script>
  var sUrlRC = 'com4_solicitacaoCompras.RPC.php';
  var aItensAbertura = new Array();
  var iIndiceAlteracao = 0;

  /***
   * ROTINA PARA SALVAR ANEXO
   */

  function js_salvarAnexo() {
    let iFrame = document.createElement("iframe");
    iFrame.src = 'func_uploadfilexls.php?clone=form2';
    iFrame.id = 'uploadIframe';
    $('anexo').appendChild(iFrame);
  }
  $('uploadfile').observe("change", js_salvarAnexo);

  function processarItens() {

    if (document.getElementById('uploadfile').value == "")
      return alert('Nenhum arquivo selecionado');

    js_divCarregando('Aguarde, adicionando item', "msgBox");
    var oParam = new Object();
    oParam.exec = "processaritens";
    oParam.iSolicitacao = parent.iframe_registro.document.getElementById('pc10_numero').value;
    var oAjax = new Ajax.Request(sUrlRC, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoprocessaritens
    });


  }

  function js_retornoprocessaritens(oAjax) {

    js_removeObj('msgBox');
    var oRetorno = eval("(" + oAjax.responseText + ")");


    if (oRetorno.erroPlanilha) {

      alert('Corrija os itens grifados em vermelho e reprocesse a planilha.');

      var y = window.outerHeight / 2 + window.screenY - (424 / 2)
      var x = window.outerWidth / 2 + window.screenX - (832 / 2)
      return window.open('com4_popuperroimportacaoabertura.php', '', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + 832 + ', height=' + 424 + ', top=' + y + ', left=' + x);

    }

    js_preencheGrid(oRetorno.itens);

  }

  function importar() {
    if (document.getElementById('importaritens').value == "2") {
      document.getElementById('inputimportacao').style.display = '';
      document.getElementById('anexarimportacao').style.display = '';
    } else {
      document.getElementById('inputimportacao').style.display = 'none';
      document.getElementById('anexarimportacao').style.display = 'none';
    }
  }

  function gerar() {
    window.location.href = "com4_xlsitensaberturaplanilha.php";
  }

  function exportar() {

    window.location.href = "com4_xlsexportacaoaberturaplanilha.php?pc11_numero=" + parent.iframe_registro.document.getElementById('pc10_numero').value;
  }

  function js_init() {

    oGridItens = new DBGrid('gridItens');
    oGridItens.nameInstance = "gridItens";
    oGridItens.setCellAlign(new Array("right", "right", "left", "center", "left", "center", "center"));
    oGridItens.setCellWidth(new Array("5%", "10%", "48%", "1%", "12%", "14%", "10%"));
    oGridItens.setHeader(new Array("Seq", "Codigo", "Descrição", "cod. Unidade", "Unidade", "Out.Inf.", "Ação"));
    oGridItens.aHeaders[3].lDisplayed = false;
    oGridItens.show($('gridItensSolicitacao'));
    js_makeWindow();
    $('btnSalvarItens').observe("click", js_salvarItens);
    $('btnAddItem').observe("click", js_adicionarItem);
    $('btnAlterarItem').observe("click", js_alterarItem);
    $('pc17_unid').style.height = $('pc01_descrmater').style.height + "px";
    $('btnOutrasInf').observe("click", js_maisInformacoes);
    js_parametros();

  }

  function js_pesquisapc16_codmater(mostra) {

    if (mostra == true) {
      js_OpenJanelaIframe('',
        'db_iframe_pcmater',
        'func_pcmatersolicita.php?funcao_js=parent.js_mostrapcmater1|pc01_codmater|pc01_descrmater',
        'Pesquisar Materias/Serviços',
        true,
        '0'
      );
    } else {

      if ($F('pc16_codmater') != '') {

        js_OpenJanelaIframe('',
          'db_iframe_pcmater',
          'func_pcmatersolicita.php?pesquisa_chave=' +
          $F('pc16_codmater') +
          '&funcao_js=parent.js_mostrapcmater',
          'Pesquisar Materiais/Serviços',
          false, '0'
        );
      } else {
        $('pc16_codmater').value = '';
      }
    }
  }

  function js_mostrapcmater(sDescricaoMaterial, Erro) {
    $('pc01_descrmater').value = sDescricaoMaterial;
    if (Erro == true) {
      $('pc16_codmater').value = "";
    }
  }

  function js_mostrapcmater1(iCodigoMaterial, sDescricaoMaterial) {

    $('pc16_codmater').value = iCodigoMaterial;
    $('pc01_descrmater').value = sDescricaoMaterial;
    db_iframe_pcmater.hide();
  }

  /**
   * Adiciona o item a solicitacao
   */
  function js_adicionarItem() {

    if ($F('pc16_codmater') == "") {

      alert('Informe o material!');
      return false;

    }
    js_divCarregando('Aguarde, adicionando item', "msgBox");
    var oParam = new Object();
    oParam.iCodigoItem = $F('pc16_codmater');
    oParam.sJustificativa = encodeURIComponent(tagString($F('pc11_just')));
    oParam.sResumo = encodeURIComponent(tagString($F('pc11_resum')));
    oParam.sPrazo = encodeURIComponent(tagString($F('pc11_prazo')));
    oParam.sPgto = encodeURIComponent(tagString($F('pc11_pgto')));
    oParam.iUnidade = $F('pc17_unid');
    oParam.nQuantUnidade = $F('pc17_quant');
    oParam.exec = "adicionarItemAbertura";
    var oAjax = new Ajax.Request(sUrlRC, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoadicionarItem
    });
  }

  function js_retornoalterarItem(oAjax) {

    var oRetorno = eval("(" + oAjax.responseText + ")");
    if (oRetorno.status == 1) {
      alert('Alteração Realizada com Sucesso');
      document.getElementById('btnAddItem').style.display = "";
      document.getElementById('btnAlterarItem').style.display = "none";
      document.getElementById('pc16_codmater').disabled = false
      document.getElementById('pc01_descrmater').disabled = false;
      js_preencheGrid(oRetorno.itens);
      js_limparForm();

    } else {
      alert(oRetorno.message.urlDecode());
    }
  }

  function js_retornoadicionarItem(oAjax) {

    js_removeObj('msgBox');
    var oRetorno = eval("(" + oAjax.responseText + ")");
    if (oRetorno.status == 1) {

      js_preencheGrid(oRetorno.itens);
      js_limparForm();

    } else {
      alert(oRetorno.message.urlDecode());
    }
  }

  function js_preencheGrid(aItens) {
    aItensAbertura = aItens;
    oGridItens.clearAll(true);
    for (var i = 0; i < aItens.length; i++) {

      with(aItens[i]) {

        var aLinha = new Array();
        aLinha[0] = i + 1;
        aLinha[1] = codigoitem;
        aLinha[2] = descricaoitem.urlDecode();
        aLinha[3] = unidade;
        aLinha[4] = unidade_descricao.urlDecode();
        aLinha[5] = "<span id='justificativa" + indice + "' style='display:none'>" + justificativa.urlDecode() + "</span>";
        aLinha[5] += "<span id='resumo" + indice + "'        style='display:none'>" + resumo.urlDecode() + "</span>";
        aLinha[5] += "<span id='pgto" + indice + "'          style='display:none'>" + pagamento.urlDecode() + "</span>";
        aLinha[5] += "<span id='prazo" + indice + "'         style='display:none'>" + prazo.urlDecode() + "</span>";
        aLinha[5] += "<span><a href='#' onclick='js_showInfo(" + indice + ")'><img src='imagens/edittext.png' border='0' ></a>...</span>";
        aLinha[6] = "<input type='button' value='Alterar' onclick='js_alterarLinha(" + indice + ")'>";
        aLinha[6] += "<input type='button' value='Excluir' onclick='js_excluirLinha(" + indice + ", " + temestimativa + ")'>";

        oGridItens.addRow(aLinha);
        oGridItens.aRows[i].aCells[0].sStyle += "background-color:#DED5CB;font-weight:bold;padding:1px";

      }
    }
    var lAlteracao = <?=isset($alterar)?"true":"false";?>;
    if(aItens.length > 0 && lAlteracao) document.getElementById('btnLancarEstimativa').style.display = '';
    oGridItens.renderRows();
  }

  function js_salvarItens() {

    js_divCarregando('Aguarde, Salvando Itens', "msgBox");
    var oParam = new Object();
    oParam.exec = "salvarItensAbertura";
    var oAjax = new Ajax.Request(sUrlRC, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoSalvarItem
    });

  }

  function js_retornoSalvarItem(oAjax) {

    js_removeObj('msgBox');
    var oRetorno = eval("(" + oAjax.responseText + ")");

    if (oRetorno.status == 1) {
      document.getElementById("btnLancarEstimativa").style.display = '';
      return alert('Itens Salvos Com sucesso.');
    } 

    return alert(oRetorno.message.urlDecode());
  }
  oAutoComplete = new dbAutoComplete($('pc01_descrmater'), 'com4_pesquisamateriais.RPC.php');
  oAutoComplete.setTxtFieldId(document.getElementById('pc16_codmater'));
  oAutoComplete.show();

  function js_limparForm() {

    $('pc16_codmater').value = "";
    $('pc01_descrmater').value = "";
    $('pc11_resum').value = "";
    $('pc11_just').value = "";
    $('pc11_pgto').value = "";
    $('pc11_prazo').value = "";
    $('btnFecharWindowAux').onclick = function() {
      windowAuxiliar.hide();
    }

  }

  function js_alterarLinha(iSeq) {
    var oRow = oGridItens.aRows[iSeq];
    iIndiceAlteracao = iSeq;
    document.getElementById('btnAlterarItem').style.display = "";
    document.getElementById('btnAddItem').style.display = "none";
    document.getElementById('pc16_codmater').value = oRow.aCells[1].content;
    document.getElementById('pc01_descrmater').value = oRow.aCells[2].content;
    document.getElementById('pc16_codmater').disabled = true
    document.getElementById('pc01_descrmater').disabled = true;
    document.getElementById('pc17_unid').value = oRow.aCells[3].content;
  }

  function js_alterarItem() {

    var select = document.querySelector('select');
    var option = select.children[select.selectedIndex];
    var unidade = option.textContent;

    oGridItens.aRows[iIndiceAlteracao].aCells[3].content = document.getElementById("pc17_unid").value;
    oGridItens.aRows[iIndiceAlteracao].aCells[4].content = unidade;
    document.getElementById("gridItensrow" + iIndiceAlteracao + "cell3").textContent = document.getElementById("pc17_unid").value;
    document.getElementById("gridItensrow" + iIndiceAlteracao + "cell4").textContent = unidade;

    var oParam = new Object();

    oParam.iUnidade = $F('pc17_unid');
    oParam.iCodigoItem = $F('pc16_codmater');
    oParam.iIndice = iIndiceAlteracao;

    oParam.exec = "alterarItemAbertura";
    var oAjax = new Ajax.Request(sUrlRC, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoalterarItem
    });

  }

  function js_excluirLinha(iSeq) {

    var oRow = oGridItens.aRows[iSeq];
    var sMsg = 'Confirma a Exclusão do item ' + oRow.aCells[0].getValue() + '-' + oRow.aCells[2].getValue() + "?";
    if (aItensAbertura[iSeq].temestimativa) {
      sMsg += '\nExistem Estimativas Lançadas para esse Item.';
    }
    if (!confirm(sMsg)) {
      return false;
    }
    js_divCarregando('Aguarde, removendo item', "msgBox");
    var oParam = new Object();
    oParam.exec = "excluirItens";
    oParam.iItemRemover = iSeq;
    var oAjax = new Ajax.Request(sUrlRC, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoadicionarItem
    });

  }

  /**
   * Adicionamos as unidades ao combo pc17_unid
   */
  <?

  foreach ($aUnidades as $oUnidade) {

    echo "var oOption = new Option('{$oUnidade->m61_descr}',{$oUnidade->m61_codmatunid});\n";
    echo "oOption.setAttribute('usadecimal', '{$oUnidade->m61_usadec}');\n";
    echo "oOption.setAttribute('usaquantidade', '{$oUnidade->m61_usaquant}');\n";
    echo "\$('pc17_unid').add(oOption, null);\n";
  }
  ?>

  function js_usaQuantidade(oSelect) {

    if (oSelect.options[oSelect.selectedIndex].getAttribute("usaquantidade") == "t") {
      $('pc17_quant').style.display = '';
    } else {
      $('pc17_quant').style.display = 'none';
    }

  }

  function js_parametros() {

    var oParam = new Object();
    oParam.exec = "getParametros";
    oParam.sleep = 5;
    oParam.aParametros = new Array();
    var oParamCompras = new Object();
    oParamCompras.sParam = "pcparam";
    oParamCompras.aKeys = new Array();
    oParam.aParametros.push(oParamCompras);
    var oParamOrcam = new Object();
    oParamOrcam.sParam = "orcparametro";
    oParamOrcam.aKeys = new Array();
    oParamOrcam.aKeys.push(2009);
    oParam.aParametros.push(oParamOrcam);
    var oAjax = new Ajax.Request('sys4_parametros.RPC.php', {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoparametro,
      assynchronous: false
    });
  }

  function js_maisInformacoes() {

    $('pc11_resum').value = "";
    $('pc11_just').value = "";
    $('pc11_pgto').value = "";
    $('pc11_prazo').value = "";

    windowAuxiliar.show(10, 10);
    $('pc11_prazo').focus();
    $('btnFecharWindowAux').onclick = function() {
      windowAuxiliar.hide();
    }

  }

  function js_makeWindow() {

    windowAuxiliar = new windowAux('wndAuxiliar', 'Dados Complementares', 600, 500);
    windowAuxiliar.setObjectForContent($('divOUtrasInf'));
    windowAuxiliar.hide();
    //$('divOUtrasInf').style.display= '';

  }

  function js_showInfo(iIndice) {

    iIndice = iIndice;
    $('pc11_resum').value = $('resumo' + iIndice).innerHTML;
    $('pc11_just').value = $('justificativa' + iIndice).innerHTML;
    $('pc11_pgto').value = $('pgto' + iIndice).innerHTML;
    $('pc11_prazo').value = $('prazo' + iIndice).innerHTML;
    $('btnFecharWindowAux').onclick = function() {

      $('resumo' + iIndice).innerHTML = $('pc11_resum').value;
      $('justificativa' + iIndice).innerHTML = $('pc11_just').value;
      $('pgto' + iIndice).innerHTML = $('pc11_pgto').value;
      $('prazo' + iIndice).innerHTML = $('pc11_prazo').value;

      $('pc11_resum').value = "";
      $('pc11_just').value = "";
      $('pc11_pgto').value = "";
      $('pc11_prazo').value = "";
      $('btnFecharWindowAux').onclick = function() {
        windowAuxiliar.hide();
      }
      js_alterarDados(iIndice);
      windowAuxiliar.hide();

    }

    windowAuxiliar.show(10, 10);

  }

  function js_alterarDados(iIndice) {

    js_divCarregando('Aguarde, alterando item', "msgBox");
    var oParam = new Object();
    oParam.iIndice = iIndice;
    oParam.sJustificativa = encodeURIComponent(tagString($('justificativa' + iIndice).innerHTML));
    oParam.sResumo = encodeURIComponent(tagString($('resumo' + iIndice).innerHTML));
    oParam.sPrazo = encodeURIComponent(tagString($('prazo' + iIndice).innerHTML));
    oParam.sPgto = encodeURIComponent(tagString($('pgto' + iIndice).innerHTML));
    oParam.exec = "alterarItem";
    var oAjax = new Ajax.Request(sUrlRC, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoadicionarItem
    });
  }

  function js_retornoparametro(oAjax) {

    var oRetorno = eval("(" + oAjax.responseText + ")");
    for (var iParam = 0; iParam < oRetorno.itens.length; iParam++) {

      with(oRetorno.itens[iParam]) {
        eval("o" + name.valueOf() + "=fields");
      }
    }
    $('pc17_unid').value = opcparam[0].pc30_unid;
  }

  function js_lancarEstimativa(){
    var codigoAbertura = parent.iframe_registro.document.getElementById('pc10_numero').value;
    CurrentWindow.corpo.document.location.href='com4_estimativaregistro001.php?codigoAbertura='+codigoAbertura;
  }
</script>