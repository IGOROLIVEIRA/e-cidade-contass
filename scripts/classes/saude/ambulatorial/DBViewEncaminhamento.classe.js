/**
 *      E-cidade Software Publico para Gestao Municipal
 *   Copyright (C) 2014  DBSeller Servicos de Informatica
 *                             www.dbseller.com.br
 *                          e-cidade@dbseller.com.br
 *
 *   Este programa e software livre; voce pode redistribui-lo e/ou
 *   modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *   publicada pela Free Software Foundation; tanto a versao 2 da
 *   Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *   Este programa e distribuido na expectativa de ser util, mas SEM
 *   QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *   COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *   PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *   detalhes.
 *
 *   Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *   junto com este programa; se nao, escreva para a Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *   02111-1307, USA.
 *
 *   Copia da licenca no diretorio licenca/licenca_en.txt
 *                 licenca/licenca_pt.txt
 */

const MENSAGENS_DBVIEWENCAMINHAMENTO = 'saude.ambulatorial.DBViewEncaminhamento.';
/**
 * View para encaminhamento de prontuários a outros setores do ambulatorio
 *
 *  @param {int} iLocalOrigem Local de origem onde o componente foi chamado...  Usar as constantes da classe.
 *                           DBViewEncaminhamento.RECEPCAO
 *                           DBViewEncaminhamento.TRIAGEM
 *                           DBViewEncaminhamento.CONSULTA_MEDICA
 *
 * @param {int} iProntuario  Prontuário (FAA) do paciente
 *
 * @example var oTeste = new DBViewEncaminhamento(DBViewEncaminhamento.RECEPCAO, 19);
 *          oTeste.show();
 *
 */
DBViewEncaminhamento = function ( iLocalOrigem, iProntuario ) {

  this.iLocalOrigem = iLocalOrigem;
  this.iProntuario  = iProntuario;
  this.sRpc         = 'sau4_fichaatendimento.RPC.php';

  this.fCallbackFechar = function() {
    return true;
  };

  this.fCallbackSalvar = function() {
    return true;
  };

  /**
   * Select com os setores disponiveis para encaminhamento
   * @type {HTMLSelectElement}
   */
  this.oCboSetores    = document.createElement('select');
  this.oCboSetores.id = 'setorEncaminhamento';
  this.oCboSetores.addClassName( 'field-size-max' );

  var oLegendContainerForm       = document.createElement('legend');
  oLegendContainerForm.innerHTML = "Encaminhamento";

  var oFieldsetContainerForm     = document.createElement('fieldset');
  oFieldsetContainerForm.appendChild(oLegendContainerForm);

  var oForm  = document.createElement("form");
  oForm.addClassName( 'form-container' );

  /**
   * CampoObservação
   * @type {HTMLTextAreaElement}
   */
  this.oInputObservacao  = document.createElement("textarea");
  this.oInputObservacao.id   = 'observacaoEncaminhamento';
  this.oInputObservacao.rows = 3;
  this.oInputObservacao.cols = 80;

  var oLegendaobservacao = document.createElement("legend");
  oLegendaobservacao.innerHTML = "Observação";

  var oFieldsetObservacao = document.createElement("fieldset");
  oFieldsetObservacao.addClassName('separator');
  oFieldsetObservacao.appendChild( oLegendaobservacao );
  oFieldsetObservacao.appendChild( this.oInputObservacao );

  var oLabelSetor          = document.createElement("label");
  oLabelSetor.addClassName('bold');
  oLabelSetor.innerHTML    = "Setor:";

  /**
   * Cria a tabela do formulário
   */
  var oTabela = document.createElement("table");
  var oLinha1 = oTabela.insertRow(0);
  var oLinha2 = oTabela.insertRow(1);
  oLinha1.insertCell(0).addClassName('field-size3').appendChild(oLabelSetor);
  oLinha1.insertCell(1).appendChild(this.oCboSetores);

  var oCelulaSegundaLinha = oLinha2.insertCell(0);
  oCelulaSegundaLinha.setAttribute('colspan', 2);
  oCelulaSegundaLinha.appendChild(oFieldsetObservacao);

  oForm.appendChild(oTabela);
  oFieldsetContainerForm.appendChild(oForm);

  var oBotaoSalvar    = document.createElement("input");
  oBotaoSalvar.type   = "button";
  oBotaoSalvar.id     = "btnSalvarEncaminhamento";
  oBotaoSalvar.value  = "Salvar";

  /**
   * Container com todos elementos do formulário
   * @type {HTMLDivElement}
   */
  this.oDivContainer = document.createElement('div');
  this.oDivContainer.addClassName('container');
  this.oDivContainer.appendChild( oFieldsetContainerForm );
  this.oDivContainer.appendChild( oBotaoSalvar );

};

/**
 * Constantes do local de atendimento
 * @type {Number}
 */
DBViewEncaminhamento.RECEPCAO        = 1;
DBViewEncaminhamento.TRIAGEM         = 2;
DBViewEncaminhamento.CONSULTA_MEDICA = 3;

/**
 * Busca os setores do ambulatorio
 * @return {void}
 */
DBViewEncaminhamento.prototype.buscaSetores = function() {

  var oSelf = this;

  var oParametros                   = {'sExecucao' : 'buscaSetoresUnidade'}
  oParametros.lFiltrarUnidadeLogada = true;
  oParametros.aExcluirLocais        = [this.iLocalOrigem];

  var oObject          = {}
  oObject.method       = 'post';
  oObject.parameters   = 'json=' + Object.toJSON( oParametros );
  oObject.asynchronous = false;
  oObject.onComplete   = function( oAjax ) {

    js_removeObj( 'msgBox' );
    var oRetorno = eval ( '(' + oAjax.responseText + ')');

    if ( parseInt(oRetorno.iStatus) != 1 ) {

      alert ( oRetorno.sMensagem.urlDecode() );
      return
    }

    oRetorno.aSetores.each(function (oSetor) {

      var oOption = new Option(oSetor.sDescricao.urlDecode(), oSetor.iCodigo);
      oOption.setAttribute('local', oSetor.iLocal);
      oSelf.oCboSetores.add(oOption);
    });

  };

  js_divCarregando( _M( MENSAGENS_DBVIEWENCAMINHAMENTO + 'buscando_setores' ), 'msgBox' );
  new Ajax.Request( oSelf.sRpc, oObject );

};

/**
 * define uma função de callback para ser executada ao fechar a janela
 * @param {function} fFunction
 */
DBViewEncaminhamento.prototype.setCallbackFechar = function( fFunction ) {
  this.fCallbackFechar = fFunction;
};

/**
 * define uma função de callback para ser executada ao salvar a movimentação
 * @param {function} fFunction
 */
DBViewEncaminhamento.prototype.setCallbackSalvar = function( fFunction ) {
  this.fCallbackSalvar = fFunction;
};

/**
 * Cria o componente da window
 * @return {}
 */
DBViewEncaminhamento.prototype.criaJaneja = function() {

  var oSelf    = this;
  this.oWindow = new windowAux( 'oWindowEncaminhamento', 'Encaminhamento de Paciente', 800, 380 );

  var sMensagemTitulo = 'Encaminha o paciente para um setor.';
  var sMensagemAjuda  = "Selecione o setor para encaminhamento do paciente";

  this.oWindow.setContent( this.oDivContainer );
  this.oWindow.setShutDownFunction( function () {

    oSelf.oWindow.destroy();
    oSelf.fCallbackFechar();
  });

  this.oMessageBoard = new DBMessageBoard( 'messageBoardMotivosAlta',
                                           sMensagemTitulo,
                                           sMensagemAjuda,
                                           this.oWindow.getContentContainer()
                                         );

  $('btnSalvarEncaminhamento').onclick = function() {
    oSelf.encaminharProntuario();
  };

  this.oWindow.show( null, null, true );
};

/**
 * Salva o encaminhamento do prontuário ao setor selecionado
 * @return {}
 */
DBViewEncaminhamento.prototype.encaminharProntuario = function() {

  var oSelf = this;

  var oParametros         = {'sExecucao' : 'encaminharProntuario'}
  oParametros.iProntuario = this.iProntuario;

  if ( this.oCboSetores.value == '' ) {

    alert( _M( MENSAGENS_DBVIEWENCAMINHAMENTO + 'setor_vazio' ) );
    return false;
  }
  oParametros.iSetorDestino = this.oCboSetores.value;
  oParametros.sObservacao   = encodeURIComponent(tagString( this.oInputObservacao.value ));

  var oObject          = {}
  oObject.method       = 'post';
  oObject.parameters   = 'json=' + Object.toJSON( oParametros );
  oObject.asynchronous = false;
  oObject.onComplete   = function( oAjax ) {

    js_removeObj('msgBox');
    var oRetorno = eval(' (' + oAjax.responseText + ') ');

    alert( oRetorno.sMensagem.urlDecode() );

    if( oRetorno.iStatus != 1) {
      return;
    }
    oSelf.oWindow.destroy();
    oSelf.fCallbackSalvar();
  }

  js_divCarregando( _M( MENSAGENS_DBVIEWENCAMINHAMENTO + 'encaminhando_prontuario' ), 'msgBox' );
  new Ajax.Request( this.sRpc, oObject );
};

/**
 * cria a window
 * @return {void}
 */
DBViewEncaminhamento.prototype.show = function () {

  this.buscaSetores();
  this.criaJaneja();
};