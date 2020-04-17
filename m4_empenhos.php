<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
include("classes/db_scripts_classe.php");
require_once("dbforms/db_funcoes.php");
$clrotulo = new rotulocampo;
$clrotulo->label("e60_codemp");

db_postmemory($HTTP_POST_VARS);

if(isset($incluir)){
  db_inicio_transacao();
  //$clidentificacaoresponsaveis->incluir($si166_sequencial);
  db_fim_transacao();
}

?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  </head>
<body bgcolor="#CCCCCC">
<?php
if (db_getsession("DB_id_usuario") != 1) {

  echo "<br><center><br><H2>Essa rotina apenas poderá ser usada pelo usuario dbseller</h2></center>";
} else {
  ?>

  <form name='form1'>
    <div class="container">
      <fieldset>
        <legend><b>Manutenção de empenho</b></legend>
        <table>
          <tr>
            <td  align="left" nowrap title="<?=$Te60_numemp?>">
              <? db_ancora(@$Le60_codemp,"js_pesquisa_empenho(true);",1);  ?>
            </td>
            <td  nowrap>
              <input name="e60_codemp" id='e60_codemp' title='<?=$Te60_codemp?>' size="12" type='text' readonly class="readonly" />
              <b>Sequencial:</b> <input name="e60_numemp" id='e60_numemp' type="text" size="10" readonly class="readonly" />
            </td>
          </tr>
        </table>
      </fieldset>
      <input type="submit" id='buttonSubmit' value='Excluir Empenho'>
      <input type="submit" id="db_opcao" value="Executar" >
    </div>
  </form>

  </body>
  </html>
  <div style='position:absolute;top: 200px; left:15px;
            border:1px solid black;
            width:400px;
            text-align: left;
            padding:3px;
            z-index:10000;
            background-color: #FFFFCC;
            display:none;' id='ajudaItem'>

  </div>
 <!--  <script>
    sUrlRPC = 'con4_lancamentoscontabeisempenho.RPC.php';
    function js_pesquisa_empenho(mostra) {

      if (mostra == true) {

        js_OpenJanelaIframe('top.corpo',
          'db_iframe_empempenho',
          'func_empempenho.php?funcao_js=parent.js_mostraempenho1|e60_codemp|e60_anousu|e60_numemp',
          'Pesquisa',
          true);

      }
    }

    function js_mostraempenho1(chave1, chave2, chave3) {

      document.form1.e60_codemp.value = chave1+"/"+chave2;
      document.form1.e60_numemp.value = chave3;
      db_iframe_empempenho.hide();
      js_visualizarEmpenhos(chave3);

    }


    function js_visualizarEmpenhos(iEmpenho) {

      $('btnVisualizarLancamento').blur();
      iEmpenho = iEmpenho;
      oWindowLancamentos  = new windowAux('wndLancamentos', 'Lancamentos Contábeis', screen.availWidth - 20, '800');
      sContent            = "<div style='text-align:center;padding:2px'>";
      sContent           += "<fieldset style='text-align:center'><legend><b>Lançamentos</b></legend>";
      sContent           += "<div style='width:100%' id='ctnDataGrid'>";
      sContent           += "</div>";
      sContent           += "</fieldset>";
      sContent           += "<input type='button' accessky='s' id='btnAlterar' value='Alterar Lançamento' onclick='js_alterarLancamento("+iEmpenho+")'> ";
      sContent           += "<input type='button' id='btnExcluir' value='Excluir Lançamento' onclick='js_excluirLancamento("+iEmpenho+")'> ";
      sContent           += "<input type='button' id='btnInfo' value='Informações Empenho'> ";
      sContent           += "</div>";
      oWindowLancamentos.setContent(sContent);
      oWindowLancamentos.addEvent('keydown', function(event) {

        if (event.ctrlKey) {

          switch (event.which) {

            case 65:

              $('btnAlterar').click();
              event.preventDefault();
              event.stopPropagation();
              break;

            case 69:

              $('btnExcluir').click();
              event.preventDefault();
              event.stopPropagation();
              break;
          }
        }
      });
      oWindowLancamentos.show(25,0);

      $('btnInfo').observe('click', function (){js_JanelaAutomatica("empempenho", iEmpenho)})
      oMessage   = new messageBoard('msgboard1',
        'Manutenção de Lançamentos Contábeis de Empenho - '+$F('e60_codemp'),
        'Selecione os itens que deseja alterar',
        $("windowwndLancamentos_content"));
      oMessage.show();
      oWindowLancamentos.setShutDownFunction(function (){

        oWindowLancamentos.destroy();
      });

      /*
       *Monta a Grid;
       */
      oGridLancamentos = new DBGrid('gridLancamentos');
      oGridLancamentos.nameInstance = 'oGridLancamentos';
      oGridLancamentos.setCheckbox(0);
      oGridLancamentos.setHeight((oWindowLancamentos.getHeight()/2)-30);
      oGridLancamentos.setCellWidth(new Array('5%','20%','12%', '12%',"41%","5%",'5%'));
      oGridLancamentos.setCellAlign(new Array("left","left", "center","right","left", "center", "center"))
      oGridLancamentos.setHeader(new Array('Código', "Documento",'Data','Valor', 'Observação',"Desconto","OP."));
      oGridLancamentos.aHeaders[6].lDisplayed = false;
      oGridLancamentos.allowSelectColumns(true);

      oGridLancamentos.show($('ctnDataGrid'));
      oGridLancamentos.resizeCols();
      js_getLancamentos(iEmpenho);



    }

    function js_getLancamentos(iEmpenho) {


      var oParam     = new Object();
      oParam.exec    = "getLancamentosEmpenho";
      oParam.iNumEmp = iEmpenho;
      var oAjax      = new Ajax.Request(sUrlRPC,
        {
          method: "post",
          parameters:'json='+Object.toJSON(oParam),
          onComplete: js_retornoGetLancamentos
        });
    }


    function js_retornoGetLancamentos(oAjax) {

      var oRetorno = eval("("+oAjax.responseText+")");
      oGridLancamentos.clearAll(true);
      if (oRetorno.status == 1) {

        if (oRetorno.itens.length == 0) {
          //oGridLancamentos.setStatus('Não foram encontrados Registros');
        }
        for (var i = 0; i < oRetorno.itens.length; i++) {

          var lBloqueia = false;
          with(oRetorno.itens[i]) {

            var aLinha    = new Array();
            aLinha[0]     = codigo;
            aLinha[1]     = "("+tipo+")"+descricaotipo.urlDecode()
            if (temretencao =='f' && temretencaonota == 'f') {
              aLinha[2]  =  eval("data"+i+"= new DBTextFieldData('data"+i+"','data"+i+"','"+js_formatar(data,'d')+"')");
            } else {

              aLinha[2]  =  js_formatar(data,'d');
              lBloqueia  = true;
            }
            aLinha[3]  = js_formatar(valor, 'f');
            aLinha[4]  = observacao.urlDecode().substring(0,50);
            aLinha[5]  = desconto;
            aLinha[6]  = ordempagamento;
            oGridLancamentos.addRow(aLinha, false, lBloqueia);
            if (desconto != '') {
              oGridLancamentos.aRows[i].setClassName('temdesconto');
            }
            if (lBloqueia) {
              oGridLancamentos.aRows[i].setClassName('disabled');
            }
            oGridLancamentos.aRows[i].aCells[1].sEvents +="ondblclick='js_infoLancamento("+codigo+")'";
            if (temretencao == 't' || temretencaonota == 't') {

              var sMsgLinha = "Lançamento possui lançamento de retenções.<br> Não é possivel fazer manutenção nesse Registro.";
              oGridLancamentos.aRows[i].sEvents +="onmouseover='js_ajuda(\""+sMsgLinha+"\", true)'";
              oGridLancamentos.aRows[i].sEvents +="onmouseout='js_ajuda(\"\", false)'";
            }
          }
        }
        oGridLancamentos.renderRows();
      }
      if (oRetorno.aviso != "") {

        oMessage.setHelp("<span style='color:red'>"+oRetorno.aviso.urlDecode()+"</span>");
        alert(oRetorno.aviso.urlDecode());

      }

    }

    function js_alterarLancamento(iEmpenho) {

      /**
       * Verificamos quantos lançamentos o usuário selecionou.
       * é permitido apenas escolher um lançamento por vez (controle de Segurança)
       */

      var sMsgConfirma  = "Você está executando a alteração de data de um lançamento contábil e deve estar ciente ";
      sMsgConfirma     += "de que isto implicará em alteração em todos os registros a ele relacionados, como por exemplo,";
      sMsgConfirma     += "emissão de empenho, notas, ordens de pagamento, retenções de tributos e";
      sMsgConfirma     += "autenticações na Tesouraria. Você realmente tem certeza de que deseja confirmar a operação?";
      if (!confirm(sMsgConfirma)) {
        return false;
      }
      var aLancamentosSelecionados = oGridLancamentos.getSelection("object");
      if (aLancamentosSelecionados.length > 1) {

        alert('Para a manutenção dos lançamentos, é permitido selecionar apenas um lançamento por vez.');
        return false;
      }

      if (aLancamentosSelecionados.length == 0) {

        alert('Nenhum lançamento selecionado.');
        return false;
      }
      var aLancamento       = aLancamentosSelecionados[0];
      var iCodigoLancamento = aLancamento.aCells[0].getValue();
      var iCodigoDesconto   = aLancamento.aCells[6].getValue();
      var oParam      = new Object();
      oParam.exec     = 'alterarLancamento';
      oParam.iNumEmp  = iEmpenho;
      oParam.dtData   = aLancamento.aCells[3].getValue();
      oParam.iCodigo  = aLancamento.aCells[0].getValue();
      oParam.iCodigoDesconto = '';
      if (iCodigoDesconto.trim() != "") {

        var sOutroLancamento  = 'O(s) Lançamento(s) : ';
        aOutrosLancamentos = oGridLancamentos.aRows;
        sVirgula = "";
        for (var iLanc = 0; iLanc < aOutrosLancamentos.length; iLanc++) {

          with(aOutrosLancamentos[iLanc]) {

            /**
             *verificamos se o lancamento é o mesmo
             */
            if (aCells[6].getValue() == iCodigoDesconto) {

              sOutroLancamento += sVirgula+aCells[1].getValue();
              sVirgula = ", ";
            }
          }
        }

        oParam.exec     = 'alterarLancamentoComDesconto';
        sOutroLancamento += " ira(am) ser(am) alterado(s), pois o lançamento selecionado ";
        sOutroLancamento += "originou(aram)-se de um desconto na Nota fiscal.\nConfirma a operação?";
        if (!confirm(sOutroLancamento)) {
          return false;
        }
        oParam.iCodigoDesconto = iCodigoDesconto;
      }

      //return false;
      js_divCarregando('Aguarde, Alterando data','msgBox');
      $('btnAlterar').disabled = true;
      $('btnExcluir').disabled = true;
      $('btnAlterar').blur();
      //return false;

      var oAjax       = new Ajax.Request(sUrlRPC,
        {
          method: "post",
          parameters:'json='+Object.toJSON(oParam),
          onComplete: js_retornoAlterarLancamento
        });
    }

    function js_retornoAlterarLancamento(oAjax) {

      js_removeObj('msgBox');
      $('btnAlterar').disabled = false;
      $('btnExcluir').disabled = false;
      var oRetorno = eval("("+oAjax.responseText+")");
      if (oRetorno.status == 2) {
        alert(oRetorno.message.urlDecode().replace(/\\n/g,'\n'));
      } else {

        js_getLancamentos(oRetorno.iNumEmp);
        alert('Lançamento Alterado com sucesso!');
      }
    }

    /**
     * Retorna verdadeiro se algum dos registros selecionados tem relação com ContaCorrenteDetalhe
     */
    function verificaRelacaoComContaCorrenteDetalhe(iCodigoEmpenho, iCodigoLancamento) {

      var lResultado  = false;
      var oParametros = {
        exec: 'verificaRelacaoComContaCorrenteDetalhe',
        iCodigoEmpenho: iCodigoEmpenho,
        iCodigoLancamento: iCodigoLancamento
      };
      var oCallback = function(oAjax) {
        var oRetorno = eval("("+oAjax.responseText+")");

        lResultado = oRetorno.retorno;
      };

      new Ajax.Request(sUrlRPC, {
        asynchronous: false,
        method: 'post',
        parameters: 'json=' + Object.toJSON(oParametros),
        onComplete: oCallback
      });

      return lResultado;
    }

    function js_excluirLancamento(iEmpenho) {

      /**
       * Verificamos quantos lançamentos o usuário selecionou.
       * é permitido apenas escolher um lançamento por vez (controle de Segurança)
       */
      var aLancamentosSelecionados = oGridLancamentos.getSelection("object");
      if (aLancamentosSelecionados.length > 1) {

        alert('Para a exclusão dos lançamentos, é permitido selecionar apenas um lançamento por vez.');
        return false;
      }

      if (aLancamentosSelecionados.length == 0) {

        alert('Nenhum lançamento selecionado.');
        return false;
      }

      var aLancamento       = aLancamentosSelecionados[0];
      var iCodigoLancamento = aLancamento.aCells[0].getValue();
      var iCodigoDesconto   = aLancamento.aCells[6].getValue();

      if (verificaRelacaoComContaCorrenteDetalhe(iEmpenho, iCodigoLancamento)) {
        var sMensagemContaCorrenteDetalhe = "Este empenho possui conta corrente vinculada, deseja excluí-lo mesmo assim?";

        if (!confirm(sMensagemContaCorrenteDetalhe)) {
          return false;
        }
      }

      var sMsgConfirma = "Você está executando a exclusão de um lançamento contábil e deve estar ciente de que isto ";
      sMsgConfirma    += "implicará em remoção de todos os registros a ele relacionados, como por exemplo, ";
      sMsgConfirma    += "emissão de empenho, notas, ordens de pagamento, retenções de tributos e ";
      sMsgConfirma    += "autenticações na Tesouraria.\nVocê realmente tem certeza de que deseja confirmar a operação?";
      if (!confirm(sMsgConfirma)) {
        return false;
      }

      var oParam             = new Object();
      oParam.exec            = 'excluirLancamento';
      oParam.iNumEmp         = iEmpenho;
      oParam.iCodigo         = iCodigoLancamento;
      oParam.iCodigoDesconto = '';
      if (iCodigoDesconto.trim() != "") {

        var sOutroLancamento  = 'O(s) Lançamento(s) : ';
        aOutrosLancamentos = oGridLancamentos.aRows;
        sVirgula = "";
        for (var iLanc = 0; iLanc < aOutrosLancamentos.length; iLanc++) {

          with(aOutrosLancamentos[iLanc]) {

            /**
             *verificamos se o lancamento é o mesmo
             */
            if (aCells[6].getValue() == iCodigoDesconto) {

              sOutroLancamento += sVirgula+aCells[1].getValue();;
              sVirgula = ", ";
            }
          }
        }

        oParam.exec       = 'excluirLancamentoComDesconto';
        sOutroLancamento += " ira(am) ser(am) excluido(s), pois o lançamento selecionado ";
        sOutroLancamento += "originou(aram)-se de um desconto na Nota fiscal.\nConfirma a operação?";
        if (!confirm(sOutroLancamento)) {
          return false;
        }
        oParam.iCodigoDesconto = iCodigoDesconto;
      }
      js_divCarregando('Aguarde, excluindo lançamento','msgBox');
      $('btnAlterar').disabled = true;
      $('btnExcluir').disabled = true;
      $('btnExcluir').blur();
      //return false;

      new Ajax.Request(sUrlRPC,
        {
          method: "post",
          parameters:'json='+Object.toJSON(oParam),
          onComplete: js_retornoExcluirLancamento
        });
    }

    function js_retornoExcluirLancamento(oAjax) {

      js_removeObj('msgBox');
      $('btnAlterar').disabled = false;
      $('btnExcluir').disabled = false;
      var oRetorno = eval("("+oAjax.responseText+")");
      if (oRetorno.status == 2) {

        alert(oRetorno.message.urlDecode().replace(/\\n/g,'\n'));
      } else {

        alert('Lancamento excluido com sucesso!');
        js_getLancamentos(oRetorno.iNumEmp);
      }
    }

    function js_infoLancamento(iLancamento) {
      var oLancamentoInfo = new infoLancamentoContabil(iLancamento, oWindowLancamentos);
    }


    function js_ajuda(sTexto,lShow) {

      if (lShow) {

        el =  $('gridgridLancamentos');
        var x = 0;
        var y = el.offsetHeight;
        while (el.offsetParent && el.tagName.toUpperCase() != 'BODY') {

          x += el.offsetLeft;
          y += el.offsetTop;
          el = el.offsetParent;

        }
        x += el.offsetLeft;
        y += el.offsetTop;
        $('ajudaItem').innerHTML     = sTexto;
        $('ajudaItem').style.display = '';
        $('ajudaItem').style.top     = y+10;
        $('ajudaItem').style.left    = x;

      } else {
        $('ajudaItem').style.display = 'none';
      }
    }
    $('btnVisualizarLancamento').observe("click", function (){js_visualizarEmpenhos($F('e60_numemp'))});

  </script> -->
<?
}
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>