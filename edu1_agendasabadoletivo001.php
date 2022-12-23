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

require_once("libs/db_stdlib.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");

$clrotulo = new rotulocampo;
$db_opcao = 1;
?>
<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <?
  db_app::load("scripts.js,
                  prototype.js,
                  strings.js,
                  arrays.js,
                  windowAux.widget.js,
                  datagrid.widget.js,
                  dbmessageBoard.widget.js,
                  dbcomboBox.widget.js,
                  dbtextField.widget.js,
                  DBInputHora.widget.js,
                  datagrid/plugins/DBOrderRows.plugin.js,
                  datagrid/plugins/DBHint.plugin.js");

  db_app::load(
    "estilos.css,
    grid.style.css"
  );
  ?>
</head>

<body style='margin-top: 25px' bgcolor="#cccccc">
  <form name="form1" id='frmSabadoLetivo' method="post">
    <center>
      <div style='display:table;'>
        <fieldset>
          <legend style="font-weight: bold">Agenda de Sábado Letivo </legend>
          <table border='0'>
            <tr>
              <td nowrap title="">
                <b>Calendário : </b>
              </td>
              <td nowrap id="ctnCboCalendario">
              </td>
            </tr>
            <tr>
              <td nowrap title="">
                <b>Data : </b>
              </td>
              <td nowrap id="ctnCboData">
              </td>
            </tr>
            <tr>
              <td nowrap title="">
                <b>Turma : </b>
              </td>
              <td nowrap id="ctnCboTurma">
              </td>
            </tr>
            <tr>
              <td nowrap title="">
                <b>Turno : </b>
              </td>
              <td nowrap id="ctnCboTurno">
              </td>
            </tr>
            <tr>
              <td nowrap title="">
                <b>Disciplina : </b>
              </td>
              <td nowrap id="ctnCboDisciplina">
              </td>
            </tr>
            <tr>
              <td nowrap title="">
                <b>Regente : </b>
              </td>
              <td nowrap id="ctnCboRegente">
              </td>
            </tr>
          </table>
          <fieldset style='width:500px;'>
            <legend>Períodos</legend>
            <div id='ctnGridPeriodosAula'></div>
            </fieldset>
        </fieldset>
      </div>
      <input name="btnIncluir" id="btnIncluir" type="button" value="Incluir"  onclick='js_addAgenda();' >
    </center>
  </form>
  <div class="subcontainer">

    <fieldset style='width:526px;'>
      <legend>Horários Inclusos</legend>
      <div id='cntGridHorariosInclusos'></div>
    </fieldset>

  </div>
</body>
<script>
  sUrlRpc = "edu4_agendasabadoletivo.RPC.php";
  const MSG_HORARIOAULA = 'educacao.escola.edu1_horarioaula.';
  const RPC_HORARIOAULA = 'edu4_horarioaula.RPC.php';
  var aPeriodosEscolaCadastrados = []; // Períodos sem vínculo com a escola
  var iRegente = 0;
  var aPeriodosAula = new Array();
  var oGridPeriodosEscola          = new DBGrid('gridPeriodosEscola');
  oGridPeriodosEscola.nameInstance = 'oGridPeriodosEscola';
  oGridPeriodosEscola.setCheckbox(0);
  oGridPeriodosEscola.setCellWidth( [ '0%', '40%', '20%', '20%', '20%' ] );
  oGridPeriodosEscola.setHeader( [ 'codigo', 'Período', 'H. Início', 'H. Fim', 'Duração', 'periodo_aula' ] );
  oGridPeriodosEscola.setCellAlign( [ 'left', 'left', 'center', 'center', 'center' ] );
  oGridPeriodosEscola.setHeight(130);
  oGridPeriodosEscola.aHeaders[1].lDisplayed = false;
  oGridPeriodosEscola.aHeaders[6].lDisplayed = false;
  oGridPeriodosEscola.show($("ctnGridPeriodosAula"));

  var oGridHorariosInclusos          = new DBGrid('gridHorariosInclusos');
  oGridHorariosInclusos.nameInstance = "oGridHorariosInclusos";
  oGridHorariosInclusos.setCellWidth( [ '42.5%', '42.5%', '15%'] );
  oGridHorariosInclusos.setHeader( [ 'Data', 'Horário', 'Ação' ] );
  oGridHorariosInclusos.setCellAlign( [ 'center', 'center', 'center' ] );
  oGridHorariosInclusos.setHeight(130);
  oGridHorariosInclusos.show($("cntGridHorariosInclusos"));

  init = function() {

    oCboCalendario = new DBComboBox("cboCalendario", "oCboCalendario", null, "450px");
    oCboCalendario.addItem("", "Selecione");
    oCboCalendario.addEvent("onChange", "js_getDatas()");
    oCboCalendario.show($('ctnCboCalendario'));

    oCboData = new DBComboBox("cboData", "oCboData", null, "450px");
    oCboData.addItem("", "Selecione");
    oCboData.addEvent("onChange");
    oCboData.show($('ctnCboData'));

    oCboTurma = new DBComboBox("cboTurma", "oCboTurma", null, "450px");
    oCboTurma.addItem("", "Selecione");
    oCboTurma.addEvent("onChange", "js_getDisciplinas()");
    oCboTurma.show($('ctnCboTurma'));

    oCboTurno = new DBComboBox("cboTurno", "oCboTurno", null, "450px");
    oCboTurno.addItem("", "Selecione");
    oCboTurno.addEvent("onChange", "js_buscaPeriodosAula()");
    oCboTurno.show($('ctnCboTurno'));

    oCboDisciplina = new DBComboBox("cboDisciplina", "oCboDisciplina", null, "450px");
    oCboDisciplina.addItem("", "Selecione");
    oCboDisciplina.addEvent("onChange", "js_getProfessor()");
    oCboDisciplina.show($('ctnCboDisciplina'));

    oCboRegente = new DBComboBox("cboRegente", "oCboRegente", null, "450px");
    oCboRegente.addItem("", "Selecione");
    oCboRegente.addEvent("onChange", "js_getSabadosLetivos()");
    oCboRegente.show($('ctnCboRegente'));

    var oParametros = new Object();
    oParametros.exec = 'getCalendarios';
    oParametros.iCalendario = oCboCalendario.getValue();

    var oAjax = new Ajax.Request(sUrlRpc, {
        method: 'post',
        parameters: 'json=' + Object.toJSON(oParametros),
        onComplete: js_loadDados
        }
    );
  };

  js_loadDados = function(oAjax) {
    var oRetorno = eval("(" + oAjax.responseText + ")");
    oCboCalendario.clearItens();
    oCboCalendario.addItem("", "Selecione");
    oRetorno.calendarios.each(function(oCalendario, iSeq) {
      oCboCalendario.addItem(oCalendario.ed52_i_codigo, oCalendario.ed52_c_descr.urlDecode());
    });
  };

  function js_atualizarDadosLeitura() {

    if (empty($('cboDisciplina').value)) {

      alert('Selecione uma disciplina.');
      return false;
    }

    if (empty($('cboData').value)) {

      alert('Selecione uma data.');
      return false;
    }

    if (empty($('cboTurma').value)) {

      alert('Selecione uma turma.');
      return false;
    }

    var oParametros = new Object();
    oParametros.exec = 'atualizarDados';

    js_divCarregando('Aguarde, Atualizando leituras...<br>Esse procedimento pode levar algum tempo.', 'msgBox');
    new Ajax.Request('edu03_consultaacessoalunos.RPC.php', {
      method: 'post',
      parameters: 'json=' + Object.toJSON(oParametros),
      onComplete: js_pesquisarAlunos
    });
  }

  function js_getDatas() {
    js_divCarregando('Aguarde, Pesquisando datas...<br>Esse procedimento pode levar algum tempo.', 'msgBox');
    var oParametros = new Object();
    oParametros.exec = "getDiasLetivos";
    oParametros.iCalendario = oCboCalendario.getValue();
    var oAjax = new Ajax.Request(sUrlRpc, {
        method: 'post',
        parameters: 'json=' + Object.toJSON(oParametros),
        onComplete: function(oResponse) {

            var oRetorno = eval("(" + oResponse.responseText + ")");
            oCboData.clearItens();
            oCboData.addItem("", "Selecione");
            oRetorno.aDiasLetivos.each(function(oData, iSeq) {
                var sData = js_formatar(oData.ed54_d_data, 'd');
                var sDescricaoDia = sData + " - " + oData.ed54_c_diasemana.urlDecode();
                oCboData.addItem(oData.ed54_d_data, sDescricaoDia);
            });

            oCboTurma.clearItens();
            oCboTurma.addItem("", "Selecione");
            oRetorno.aTurmas.each(function(oTurma, iSeq) {
                oCboTurma.addItem(oTurma.ed57_i_codigo, oTurma.ed57_c_descr.urlDecode());
            });

            js_removeObj('msgBox');
        }
    });

  }

  function js_getDisciplinas(){
    var oParametros = new Object();
    oParametros.exec = "getTurmaDisciplinas";
    oParametros.iTurma = oCboTurma.getValue();
    var oAjax = new Ajax.Request(sUrlRpc, {
      method: 'post',
      parameters: 'json=' + Object.toJSON(oParametros),
      onComplete: function(oResponse) {
        var oRetorno = eval("(" + oResponse.responseText + ")");
        oCboDisciplina.clearItens();
        oCboDisciplina.addItem("", "Selecione");
        oRetorno.aRegencias.each(function(oRegencia, iSeq) {
            oCboDisciplina.addItem(oRegencia.ed59_i_codigo, oRegencia.ed232_c_descr.urlDecode());
        });

        oRetorno.aTurnos.each( function (oTurno, iSeq ) {
            if(oTurno.ed336_turnoreferente == 1){
                oCboTurno.addItem(oTurno.ed336_turnoreferente, "MANHÃ");
                return;
            }
            if(oTurno.ed336_turnoreferente == 2){
                oCboTurno.addItem(oTurno.ed336_turnoreferente, "TARDE");
                return;
            }
            if(oTurno.ed336_turnoreferente == 3){
                oCboTurno.addItem(oTurno.ed336_turnoreferente,oHorario = "NOITE");
                return;
            }
        });
     }
    });

  }

  function js_getProfessor() {

    js_divCarregando('Aguarde, Carregando os Professores...<br>Esse procedimento pode levar algum tempo.', 'msgBox');
    var oParametros = new Object();
    oParametros.exec = "getProfessorDisciplina";
    oParametros.iTurma = oCboTurma.getValue();
    var oAjax = new Ajax.Request(sUrlRpc, {
      method: 'post',
      parameters: 'json=' + Object.toJSON(oParametros),
      onComplete: function(oResponse) {

        var oRetorno = eval("(" + oResponse.responseText + ")");
        oCboRegente.clearItens();
        oCboRegente.addItem("", "Selecione");
        oRetorno.aProfessores.each(function(oProfessor, iSeq) {
            oCboRegente.addItem(oProfessor.ed20_i_codigo, oProfessor.z01_nome.urlDecode());
        });
        js_removeObj('msgBox');
        js_renderizaPeriodos();
      }
    });
  }


  function js_getTurmasNoDia() {

    var oParametros = new Object();
    oParametros.exec = "getTurmasNoDia";
    oParametros.iRegente = iRegente;
    oParametros.dtAula = oCboData.getValue();
    var oAjax = new Ajax.Request(sUrlRpc, {
      method: 'post',
      parameters: 'json=' + Object.toJSON(oParametros),
      onComplete: function(oResponse) {

        var oRetorno = eval("(" + oResponse.responseText + ")");
        oCboTurma.clearItens();
        oCboTurma.addItem("", "Selecione");
        oRetorno.aTurmas.each(function(oTurma, iSeq) {
          oCboTurma.addItem(oTurma.codigo_turma, oTurma.descricao_turma.urlDecode());
        });
      }
    });
  }

/**
 * Busca os períodos cadastrados na secretaria da educação
 * @return
 */
 function js_buscaPeriodosAula () {

    if (aPeriodosEscolaCadastrados.length > 0 ) {
        js_renderizaPeriodos();
        return;
    }

    var oParametros = { 'exec' : 'getPeriodos', 'iTurno': oCboTurno.getValue() };

    var oRequest          = {'method' : 'post'};
    oRequest.parameters   = 'json='+Object.toJSON(oParametros);
    oRequest.asynchronous = false;
    oRequest.onComplete   = function (oAjax) {
        var oRetorno = eval('(' + oAjax.responseText + ')' );
        aPeriodosEscolaCadastrados = oRetorno.aPeriodos;
        js_renderizaPeriodos();
    };

    new Ajax.Request(RPC_HORARIOAULA, oRequest);
 }

 function js_generateInput (oDadosPeriodo, sTipo) {
     var sId    = sTipo + '_' +  oDadosPeriodo.iCodigo;
     var oInput = new DBInputHora( new Element('text', {'type':'text', 'id' : sId}) );
     oInput.getElement().setAttribute( 'tipo', sTipo );
     oInput.getElement().setAttribute( 'nome_periodo', 1 );
     oInput.getElement().setAttribute( 'codigo_periodo', oDadosPeriodo.iCodigo );
     oInput.getElement().setAttribute( 'ordem', oDadosPeriodo.iOrdem );
     oInput.getElement().addClassName( 'tamanhoInputHora' );
     oInput.getElement().addClassName( 'readonly' );
     oInput.getElement().setAttribute('disabled', 'disabled');

    return oInput;
 }

 function js_renderizaPeriodos () {
    oGridPeriodosEscola.clearAll(true);
    aPeriodosEscolaCadastrados.each (function ( oPeriodo ) {
        var aLinha = [];
        aLinha.push(oPeriodo.iCodigo);
        aLinha.push(oPeriodo.sDescricao.urlDecode());
        aLinha.push(oPeriodo.hInicio.urlDecode());
        aLinha.push(oPeriodo.hFim.urlDecode());
        aLinha.push(oPeriodo.sIdDuracao.urlDecode());
        oGridPeriodosEscola.addRow(aLinha);
    });
    oGridPeriodosEscola.renderRows();
 }

 function js_excluirsabado (iRegenciaHorario) {
    js_divCarregando('Aguarde, excluíndo registros!', 'msgBox');
    var oParametros = new Object();
    oParametros.exec = "excluirSabadoLetivo";
    oParametros.iRegenciaHorario  = iRegenciaHorario;
    var oAjax = new Ajax.Request(sUrlRpc, {
      method: 'post',
      parameters: 'json=' + Object.toJSON(oParametros),
      onComplete: function(oResponse) {

        var oRetorno = eval("(" + oResponse.responseText + ")");
        js_removeObj('msgBox');
        var oRetorno = eval("(" + oResponse.responseText + ")");
        if (oRetorno.status == 1) {

          alert('Excluído com sucesso.');
        } else {
          alert(oRetorno.message.urlDecode());
        }
        js_getSabadosLetivos();
      }
    });

 }
 function js_getSabadosLetivos(){
    oGridHorariosInclusos.clearAll(true);
    var oParametros = new Object();
    oParametros.exec = "getSabadosLetivos";
    oParametros.iRegencia  = oCboDisciplina.getValue();
    oParametros.iRecHumano = oCboRegente.getValue();
    var oAjax = new Ajax.Request(sUrlRpc, {
      method: 'post',
      parameters: 'json=' + Object.toJSON(oParametros),
      onComplete: function(oResponse) {

        var oRetorno = eval("(" + oResponse.responseText + ")");

        oRetorno.aSabodosLetivos.each(function(oSabado, iSeq) {
            var aLinha = [];
            var sData = js_formatar(oSabado.ed58_d_data, 'd');
            aLinha.push(sData+" "+oSabado.ed32_c_descr.urlDecode());
            aLinha.push(oSabado.ed17_h_inicio.urlDecode()+" até "+ oSabado.ed17_h_fim.urlDecode());
            aLinha.push("<input type='button' onclick=js_excluirsabado(\'" + oSabado.ed58_i_codigo + "\') value='E'/>")
            oGridHorariosInclusos.addRow(aLinha);
        });
        oGridHorariosInclusos.renderRows();
      }
    });

  }

  function js_sinalizarLinhaGrid(oObjeto, lPintar) {

    if (oObjeto.nodeName == 'TR') {
      oLinha = oObjeto;
    }
    if (oObjeto.nodeName == 'INPUT') {
      oLinha = oObjeto.parentNode.parentNode;
    }
    var sCor = 'white';
    var sCorFonte = 'black';
    if (lPintar) {

      sCor = '#2C7AFE';
      sCorFonte = 'white';
    }
    oLinha.style.backgroundColor = sCor;
    oLinha.style.color = sCorFonte;
  }

  function js_addAgenda() {

    if (empty($('cboCalendario').value)) {

        alert('Selecione uma Calendário.');
        return false;
    }

    if (empty($('cboData').value)) {

        alert('Selecione uma data.');
        return false;
    }

    if (empty($('cboTurma').value)) {

        alert('Selecione uma turma.');
        return false;
    }

    if (empty($('cboTurno').value)) {

        alert('Selecione um turno.');
        return false;
    }
    if (empty($('cboDisciplina').value)) {

        alert('Selecione uma disciplina.');
        return false;
    }

    if (empty($('cboRegente').value)) {

        alert('Selecione um Regente.');
        return false;
    }

    /**
     * Coletamos os codigos das regencias
     */
    var aPeriodoSelecionados = oGridPeriodosEscola.getSelection();
    var aPeriodos = [];
    aPeriodoSelecionados.each( function( oPerido, iSeq) {
        aPeriodos.push(oPerido[1]);
    });

    js_divCarregando('Aguarde, salvando os dados!', 'msgBox');
    var oParametros = new Object();
    oParametros.exec = "salvarSabadoLetivo";
    oParametros.iRecHumano = oCboRegente.getValue();
    oParametros.iRegencia  = oCboDisciplina.getValue();
    oParametros.dData      = oCboData.getValue();
    oParametros.aPeriodos  = aPeriodos;

    var oAjax = new Ajax.Request(sUrlRpc, {
      method: 'post',
      parameters: 'json=' + Object.toJSON(oParametros),
      onComplete: function(oResponse) {

        js_removeObj('msgBox');
        var oRetorno = eval("(" + oResponse.responseText + ")");
        if (oRetorno.status == 1) {

          alert('Salvo com sucesso.');
        } else {
          alert(oRetorno.message.urlDecode());
        }
        js_getSabadosLetivos();
      }
    });
  }



  init();
</script>

</html>
<?
db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
?>
