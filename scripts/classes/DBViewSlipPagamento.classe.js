/**
 * Componente para o pagamento de um slip
 * @param sNomeInstancia     - Nome da Instancia que esta sendo utilizada
 * @param iTipoTransferencia - Codigo da transferencia (tabela: sliptipooperacao)
 * @param oDivDestino        - Objeto onde este objeto (DBViewSlipPagamento) sera adicionado
 */
 DBViewSlipPagamento = function(sNomeInstancia, iTipoTransferencia, iOpcao, oDivDestino, lInscricaoBaixa, lReadOnly) {

    var me                          = this;
    me.sNomeInstancia               = sNomeInstancia;
    me.sTipoTransferencia           = "";
    me.iTipoTransferencia           = iTipoTransferencia;
    me.sUrlRpc                      = "cai4_transferencia.RPC.php";
    me.oDivDestino                  = oDivDestino;
    me.iCodigoSlip                  = null;
    me.lUsaPCASP                    = false;
    me.iTipoInclusao                = 0;
    me.lImportacao                  = false;
    me.iInscricaoPassivo            = null;
    me.lFinalidadeDePagamentoFundeb = false;
    me.iTamanhoCampo                = 12;
    me.lAlteracao                   = false;
    me.bTemExercicioDevolucaoDebito = false;
    me.bTemExercicioDevolucaoCredito = false;
    me.iLinhaExercicioDevolucao     = 0;
    me.tipocontadebito              = 0;
    me.tipocontacredito             = 0;

    if (lReadOnly == null || lReadOnly == 'undefined') {
      me.lReadOnly = false;
    } else {
      me.lReadOnly = lReadOnly;
    }

    /*
     * Array contendo as contas para credito/debito
     */
    me.aContasCredito = new Array();
    me.aContasDebito  = new Array();

    me.lContaCredito  = false;
    me.lContaDebito   = false;

    /*
     * Parametros que serao executados no comando ajax
     */
    me.sParamContaCredito = "";
    me.sParamContaDebito  = "";

    /*
     * 1 para inclusao
     * 2 para estorno
     */
    me.iOpcao = iOpcao;

    /*
    * Define quais telas deverão ter o numero do documento
    */
    me.iMostrarNumDoc     = 's';

    /**
     * Define o tipo de transferencia
     */

    oCodigoContaDebito  = 0;

    switch (iTipoTransferencia) {

      /*
       * Transferencia Financeira
       */
      case 1: // Pagamento
        me.iTipoInclusao         = 1;
        me.sParamContaCredito    = "getContasSaltes";
        me.iMostrarNumDoc        = 'n';

        me.sPesquisaContaCredito = "Saltes";
        me.sPesquisaContaDebito  = "EventoContabil";

        me.sParamContaDebito     = "getContaEventoContabil";
        me.sTipoTransferencia    = "Concessão de Transferência Financeira";
        me.lContaDebito          = true;

      break;

      case 2: // Estorno Pagamento

        me.iTipoInclusao         = 1;
        me.sParamContaCredito    = "getContasSaltes";

        me.sPesquisaContaCredito = "Saltes";
        me.sPesquisaContaDebito  = "EventoContabil";

        me.sParamContaDebito     = "getContaEventoContabil";
        me.sTipoTransferencia    = "Concessão de Transferência Financeira";
        me.lContaDebito          = true;

      break;

      case 3: // Recebimento
      case 4: // Estorno Recebimento

        me.iTipoInclusao         = 3;
        me.lContaCredito         = true;
        me.sParamContaCredito    = "getContaEventoContabil";

        me.sPesquisaContaCredito = "EventoContabil";
        me.sPesquisaContaDebito  = "Saltes";

        me.sParamContaDebito     = "getContasSaltes";
        me.sTipoTransferencia    = "Recebimento Transferência Financeira";
      break;

      /*
       * Transferencia Bancaria
       */
      case 5: // Inclusao
      case 6: // Estorno

        me.iTipoInclusao         = 5;
        me.sParamContaCredito    = "getContasSaltes";

        me.sPesquisaContaCredito = "Saltes";
        me.sPesquisaContaDebito  = "Saltes";

        me.sParamContaDebito     = "getContasSaltes";
        me.sTipoTransferencia    = "Transferência Bancária";
      break;

      /*
       * Caucao Recebimento
       */
      case 7: // inclusao
      case 8: // estorno

        me.iTipoInclusao         = 7;
        me.lContaCredito         = true;
        // buscara somente as contas credito do evento
        me.sParamContaCredito    = "getContaEventoContabil";

        me.sPesquisaContaCredito = "EventoContabil";
        me.sPesquisaContaDebito  = "Saltes";

        me.sParamContaDebito     = "getContasSaltes";
        me.sTipoTransferencia    = "Recebimento de Caução";
      break;

      /*
       * Caucao Devolucao
       */
      case 9: // inclusao
        me.iTipoInclusao         = 9;
        me.lContaDebito          = true;
        me.sParamContaCredito    = "getContasSaltes";
        me.iMostrarNumDoc        = 'n';

        me.sPesquisaContaCredito = "Saltes";
        me.sPesquisaContaDebito  = "EventoContabil";

        me.sParamContaDebito     = "getContaEventoContabil";
        me.sTipoTransferencia    = "Devolução de Caução";
      break;
      case 10: // estorno

        me.iTipoInclusao         = 9;
        me.lContaDebito          = true;
        me.sParamContaCredito    = "getContasSaltes";

        me.sPesquisaContaCredito = "Saltes";
        me.sPesquisaContaDebito  = "EventoContabil";

        me.sParamContaDebito     = "getContaEventoContabil";
        me.sTipoTransferencia    = "Devolução de Caução";
      break;

      /*
       * Dep. Diversas Origens
       */
      case 11: // Recebimento
      case 12: // Estorno Recebimento

        me.iTipoInclusao          = 11;
        me.lContaCredito          = true;
        me.sTipoTransferencia     = "Recebimento de Depósito de Diversas Origens";

        me.sPesquisaContaCredito = "EventoContabil";
        me.sPesquisaContaDebito  = "Saltes";

        me.sParamContaCredito    = "getContaEventoContabil";
        me.sParamContaDebito     = "getContasSaltes";
      break;

      case 13: // Pagamento
        me.iTipoInclusao      = 13;
        me.lContaDebito       = true;
        me.sTipoTransferencia = "Pagamento de Depósito de Diversas Origens";
        me.iMostrarNumDoc     = 'n';

        if (me.iInscricaoPassivo != null) {
          me.sTipoTransferencia = "Baixa de Inscrição";
        }

        me.sPesquisaContaCredito = "Saltes";
        me.sPesquisaContaDebito  = "EventoContabil";

        me.sParamContaCredito    = "getContasSaltes";
        me.sParamContaDebito     = "getContaEventoContabil";

      break;
      case 14: // Estorno Pagamento

        me.iTipoInclusao      = 13;
        me.lContaDebito       = true;
        me.sTipoTransferencia = "Pagamento de Depósito de Diversas Origens";

        if (me.iInscricaoPassivo != null) {
          me.sTipoTransferencia = "Baixa de Inscrição";
        }

        me.sPesquisaContaCredito = "Saltes";
        me.sPesquisaContaDebito  = "EventoContabil";

        me.sParamContaCredito    = "getContasSaltes";
        me.sParamContaDebito     = "getContaEventoContabil";

      break;

      /**
        * Reconhecimento de perdas
        */
      case 15: // Inclusão
        me.iTipoInclusao      = 15;
        me.lContaDebito       = true;
        me.sTipoTransferencia = "Reconhecimento de Perdas RPPS";
        me.iMostrarNumDoc     = 'n';

        me.sPesquisaContaCredito  = "Saltes";
        me.sPesquisaContaDebito   = "EventoContabil";

        me.sParamContaCredito     = "getContasSaltes";
        me.sParamContaDebito      = "getContaEventoContabil";

      break;
      case 16: // Estorno

        me.iTipoInclusao      = 15;
        me.lContaDebito       = true;
        me.sTipoTransferencia = "Reconhecimento de Perdas RPPS";

        me.sPesquisaContaCredito  = "Saltes";
        me.sPesquisaContaDebito   = "EventoContabil";

        me.sParamContaCredito     = "getContasSaltes";
        me.sParamContaDebito      = "getContaEventoContabil";

      break;

      /**
       * Reconhecimento de ganhos RPPS
       */

      case 17: // Inclusão
      case 18: // Estorno

        me.iTipoInclusao      = 17;
        me.lContaCredito      = true;
        me.sTipoTransferencia = "Reconhecimento de Ganhos RPPS";

        me.sPesquisaContaCredito = "EventoContabil";
        me.sPesquisaContaDebito  = "Saltes";

        me.sParamContaCredito    = "getContaEventoContabil";
        me.sParamContaDebito     = "getContasSaltes";
      break;

    }

    me.oTxtCodigoSlip                          = new DBTextField('oTxtCodigoSlip', me.sNomeInstancia+'.oTxtCodigoSlip', '', me.iTamanhoCampo);
    me.oTxtInstituicaoOrigemCodigo             = new DBTextField('oTxtInstituicaoOrigemCodigo', me.sNomeInstancia+'.oTxtInstituicaoOrigemCodigo', '', me.iTamanhoCampo);
    me.oTxtInstituicaoOrigemCodigo.setReadOnly(true);
    me.oTxtDescricaoInstituicaoOrigem          = new DBTextField('oTxtDescricaoInstituicaoOrigem', me.sNomeInstancia+'.oTxtDescricaoInstituicaoOrigem', '', 56);
    me.oTxtInstituicaoDestinoCodigo            = new DBTextField('oTxtInstituicaoDestinoCodigo', me.sNomeInstancia+'.oTxtInstituicaoDestinoCodigo', '', me.iTamanhoCampo);
    me.oTxtInstituicaoDestinoCodigo.addEvent('onChange', ";"+me.sNomeInstancia+".pesquisaInstituicaoDestino(false);");
    me.oTxtDescricaoInstituicaoDestino         = new DBTextField('sDescricaoInstituicaoDestino', me.sNomeInstancia+'.oTxtDescricaoInstituicaoDestino', '', 56);
    
    me.oTxtFavorecidoInputCodigo               = new DBTextField('oTxtFavorecidoInputCodigo', me.sNomeInstancia+'.oTxtFavorecidoInputCodigo', '', me.iTamanhoCampo);
    me.oTxtFavorecidoInputCodigo.addEvent('onChange', ";"+me.sNomeInstancia+".pesquisaFavorecido(false);");
    me.oTxtFavorecidoInputDescricao            = new DBTextField('oTxtFavorecidoInputDescricao', me.sNomeInstancia+'.oTxtFavorecidoInputDescricao', '', 56);
    me.oTxtFavorecidoInputDescricao .addEvent("onKeyUp", ";" + me.sNomeInstancia + ".buscaFavorecido(this.value);");
    me.oTxtFavorecidoInputdiv               = new DBTextField("oTxtFavorecidoInputdiv", me.sNomeInstancia + ".oTxtFavorecidoInputdiv",    "", 80);
    me.oTxtFavorecidoInputdiv.addEvent("onKeyUp", ";" + me.sNomeInstancia + "");
    
    me.oTxtCaracteristicaDebitoInputCodigo     = new DBTextField('oTxtCaracteristicaDebitoInputCodigo', me.sNomeInstancia+'.oTxtCaracteristicaDebitoInputCodigo', '', me.iTamanhoCampo);
    me.oTxtCaracteristicaDebitoInputCodigo.addEvent('onChange', ";"+me.sNomeInstancia+".pesquisaCaracteristicaPeculiarDebito(false);");
    me.oTxtCaracteristicaDebitoInputDescricao  = new DBTextField('oTxtCaracteristicaDebitoInputDescricao', me.sNomeInstancia+'.oTxtCaracteristicaDebitoInputDescricao', '', 56);
    me.oTxtCaracteristicaCreditoInputCodigo    = new DBTextField('oTxtCaracteristicaCreditoInputCodigo', me.sNomeInstancia+'.oTxtCaracteristicaCreditoInputCodigo', '', me.iTamanhoCampo);
    me.oTxtCaracteristicaCreditoInputCodigo.addEvent('onChange', ";"+me.sNomeInstancia+".pesquisaCaracteristicaPeculiarCredito(false);");
    me.oTxtCaracteristicaCreditoInputDescricao = new DBTextField('oTxtCaracteristicaCreditoInputDescricao', me.sNomeInstancia+'.oTxtCaracteristicaCreditoInputDescricao', '', 56);

    /**
     * Inputs para conta crédito e débito
     */
    me.oTxtContaCreditoCodigo                  = new DBTextField("oTxtContaCreditoCodigo",    me.sNomeInstancia + ".oTxtContaCreditoCodigo",    "", me.iTamanhoCampo);
    me.oTxtContaCreditoCodigo.addEvent("onChange", ";" + me.sNomeInstancia + ".pesquisaConta" + me.sPesquisaContaCredito + "(false, true);");
    me.oTxtContaCreditoDescricao               = new DBTextField("oTxtContaCreditoDescricao", me.sNomeInstancia + ".oTxtContaCreditoDescricao", "", 56);
    me.oTxtContaCreditoDescricao.addEvent("onKeyUp", ";" + me.sNomeInstancia + ".buscaContasCredito(this.value);");

    me.oTxtContaCreditodiv               = new DBTextField("oTxtContaCreditodiv", me.sNomeInstancia + ".oTxtContaCreditodiv",    "", 80);
    me.oTxtContaCreditodiv.addEvent("onKeyUp", ";" + me.sNomeInstancia + "");
    
    me.oTxtContaDebitoCodigo                   = new DBTextField("oTxtContaDebitoCodigo",     me.sNomeInstancia + ".oTxtContaDebitoCodigo",     "", me.iTamanhoCampo);
    me.oTxtContaDebitoCodigo.addEvent("onChange", ";" + me.sNomeInstancia + ".pesquisaConta" + me.sPesquisaContaDebito + "(false, false);");
    me.oTxtContaDebitoDescricao                = new DBTextField("oTxtContaDebitoDescricao",  me.sNomeInstancia + ".oTxtContaDebitoDescricao",  "", 56);
    me.oTxtContaDebitoDescricao.addEvent("onKeyUp", ";" + me.sNomeInstancia + ".buscaContasDebito(this.value);");

    me.oTxtContaDebitodiv               = new DBTextField("oTxtContaDebitodiv", me.sNomeInstancia + ".oTxtContaDebitodiv",    "", 80);
    me.oTxtContaDebitodiv.addEvent("onKeyUp", ";" + me.sNomeInstancia + "");
    
    /**
     * Finalidade Pagamento FUNDEB
     */
    me.oTxtCodigoFinalidadeFundeb = new DBTextField("oTxtCodigoFinalidadeFundeb",    me.sNomeInstancia + ".oTxtCodigoFinalidadeFundeb",    "", me.iTamanhoCampo);
    me.oTxtCodigoFinalidadeFundeb.addEvent("onChange", ";"+me.sNomeInstancia+".pesquisaFinalidadeFundeb(false);");

    me.oTxtDescricaoFinalidadeFundeb = new DBTextField("oTxtDescricaoFinalidadeFundeb",    me.sNomeInstancia + ".oTxtDescricaoFinalidadeFundeb",    "", 56);

    // Criando o campo Exercício da Competência da Devolução
    me.oTxtExercicioCompetenciaDevolucaoInput = new DBTextField('oTxtExercicioCompetenciaDevolucaoInput', me.sNomeInstancia+'.oTxtExercicioCompetenciaDevolucaoInput', '', me.iTamanhoCampo);
    me.oTxtExercicioCompetenciaDevolucaoInput.setMaxLength(4);
    me.oTxtExercicioCompetenciaDevolucaoInput.addEvent("onKeyPress", "return js_teclas(event, this)");

    me.oTxtHistoricoInputCodigo                = new DBTextField('oTxtHistoricoInputCodigo', me.sNomeInstancia+'.oTxtHistoricoInputCodigo', '', me.iTamanhoCampo);
    me.oTxtHistoricoInputCodigo.addEvent('onChange', ";"+me.sNomeInstancia+".pesquisaHistorico(false);");
    me.oTxtHistoricoInputDescricao             = new DBTextField('oTxtHistoricoInputDescricao', me.sNomeInstancia+'.oTxtHistoricoInputDescricao', '', 56);
    me.oTxtHistoricoInputDescricao .addEvent("onKeyUp", ";" + me.sNomeInstancia + ".buscaHistorico(this.value);");
    me.oTxtHistoricoInputdiv               = new DBTextField("oTxtHistoricoInputdiv", me.sNomeInstancia + ".oTxtHistoricoInputdiv",    "", 80);
    me.oTxtHistoricoInputdiv.addEvent("onKeyUp", ";" + me.sNomeInstancia + "");

    me.oTxtFonteInputCodigo = new DBTextField('oTxtFonteInputCodigo', me.sNomeInstancia+'.oTxtFonteInputCodigo', '', me.iTamanhoCampo);
    me.oTxtFonteInputCodigo.addEvent('onFocus', ";"+me.sNomeInstancia+".pesquisaFonte(false);");
    me.oTxtFonteInputDescricao = new DBTextField('oTxtFonteInputDescricao', me.sNomeInstancia+'.oTxtFonteInputDescricao', '', 56);
    
    me.oTxtNumDocumentoInput                       = new DBTextField('oTxtNumDocumentoInput', me.sNomeInstancia+'.oTxtNumDocumentoInput', '', me.iTamanhoCampo);
    me.oTxtNumDocumentoInput.setMaxLength(15);

    me.oTxtValorInput                          = new DBTextField('oTxtValorInput', me.sNomeInstancia+'.oTxtValorInput', '', me.iTamanhoCampo);
    me.oTxtValorInput.addEvent("onKeyPress", "return js_teclas(event,this)");

    me.oTxtProcessoInput                       = new DBTextField('oTxtProcessoInput', me.sNomeInstancia+'.oTxtProcessoInput', '', me.iTamanhoCampo);
    me.oTxtProcessoInput.setMaxLength(15);    

    me.oTxtDataInput                          = new DBTextFieldData('oTxtDataInput', 'oTxtDataInput', null);

    me.oTxtDataEstornoInput                          = new DBTextFieldData('oTxtDataEstornoInput', 'oTxtDataEstornoInput', null);

    /**
     * Seta se o campo será readonly
     */

    me.oTxtInstituicaoOrigemCodigo.setReadOnly(me.lReadOnly);
    me.oTxtDescricaoInstituicaoOrigem.setReadOnly(me.lReadOnly);
    me.oTxtInstituicaoDestinoCodigo.setReadOnly(me.lReadOnly);
    me.oTxtDescricaoInstituicaoDestino.setReadOnly(me.lReadOnly);
    me.oTxtFavorecidoInputCodigo.setReadOnly(me.lReadOnly);
    me.oTxtFavorecidoInputDescricao.setReadOnly(me.lReadOnly);
    me.oTxtFavorecidoInputdiv.setReadOnly(me.lReadOnly); 
    me.oTxtCaracteristicaDebitoInputDescricao.setReadOnly(me.lReadOnly);
    me.oTxtCaracteristicaDebitoInputCodigo.setReadOnly(me.lReadOnly);
    me.oTxtCaracteristicaCreditoInputCodigo.setReadOnly(me.lReadOnly);
    me.oTxtCaracteristicaCreditoInputDescricao.setReadOnly(me.lReadOnly);
    me.oTxtContaCreditoDescricao.setReadOnly(me.lReadOnly);
    me.oTxtContaCreditodiv.setReadOnly(me.lReadOnly);
    me.oTxtContaDebitodiv.setReadOnly(me.lReadOnly);
    me.oTxtHistoricoInputdiv.setReadOnly(me.lReadOnly);    
    me.oTxtContaCreditoCodigo.setReadOnly(me.lReadOnly);
    me.oTxtContaDebitoCodigo.setReadOnly(me.lReadOnly);
    me.oTxtExercicioCompetenciaDevolucaoInput.setReadOnly(me.lReadOnly);
    me.oTxtHistoricoInputCodigo.setReadOnly(me.lReadOnly);
    me.oTxtHistoricoInputDescricao.setReadOnly(me.lReadOnly);
    me.oTxtFonteInputCodigo.setReadOnly(me.lReadOnly);
    me.oTxtNumDocumentoInput.setReadOnly(me.lReadOnly);
    me.oTxtProcessoInput.setReadOnly(me.lReadOnly);
    me.oTxtValorInput.setReadOnly(me.lReadOnly);
    me.oTxtDataInput.setReadOnly(me.lReadOnly); 
    me.oTxtDataEstornoInput.setReadOnly(me.lReadOnly);  
    me.oTxtCodigoFinalidadeFundeb.setReadOnly(me.lReadOnly);
    me.oTxtDescricaoFinalidadeFundeb.setReadOnly(me.lReadOnly);

    /*
     * Textarea das observacoes
     */
    me.oTxtObservacaoInput              = document.createElement('textarea');
    me.oTxtObservacaoInput.name         = "observacao_"+me.sNomeInstancia;
    me.oTxtObservacaoInput.id           = "observacao_"+me.sNomeInstancia;
    me.oTxtObservacaoInput.style.width  = "100%";
    me.oTxtObservacaoInput.style.height = "100px";
    me.oTxtObservacaoInput.disabled     = me.lReadOnly;
    if (me.lReadOnly) {
      me.oTxtObservacaoInput.style.backgroundColor = "#DEB887";
      me.oTxtObservacaoInput.style.color           = "#000";
    }


    /*
     * Textarea das observacoes
     */
    me.oTxtMotivoAnulacaoInput              = document.createElement('textarea');
    me.oTxtMotivoAnulacaoInput.name         = "motivoanulacao_"+me.sNomeInstancia;
    me.oTxtMotivoAnulacaoInput.id           = "motivoanulacao_"+me.sNomeInstancia;
    me.oTxtMotivoAnulacaoInput.style.width  = "100%";
    me.oTxtMotivoAnulacaoInput.style.height = "100px";

    /*
     * Objeto Botao
     */
    me.oButtonSalvar                   = document.createElement('input');
    me.oButtonSalvar.type              = "button";
    me.oButtonSalvar.value             = "Salvar";
    me.oButtonSalvar.id                = "btnSalvar";
    me.oButtonSalvar.name              = "btnSalvar";
    me.oButtonSalvar.style.marginTop   = "10px";

    me.oButtonEstornar                 = document.createElement('input');
    me.oButtonEstornar.type            = "button";
    me.oButtonEstornar.value           = "Estornar";
    me.oButtonEstornar.id              = "btnEstornar";
    me.oButtonEstornar.name            = "btnEstornar";
    me.oButtonEstornar.style.marginTop = "10px";

    me.oButtonImportar                 = document.createElement('input');
    me.oButtonImportar.type            = "button";
    me.oButtonImportar.value           = "Importar";
    me.oButtonImportar.id              = "btnImportar";
    me.oButtonImportar.name            = "btnImportar";
    me.oButtonImportar.style.marginTop = "10px";

    me.oButtonNovo                 = document.createElement('input');
    me.oButtonNovo.type            = "button";
    me.oButtonNovo.value           = "Novo";
    me.oButtonNovo.id              = "btnNovo";
    me.oButtonNovo.name            = "btnNovo";
    me.oButtonNovo.style.marginTop = "10px";

    /**
     * Cria botão para gerar nova baixa
     */
    me.oButtonNovaBaixa                   = document.createElement('input');
    me.oButtonNovaBaixa.type              = "button";
    me.oButtonNovaBaixa.value             = "Nova Baixa";
    me.oButtonNovaBaixa.id                = "btnNovaBaixa";
    me.oButtonNovaBaixa.name              = "btnNovaBaixa";
    me.oButtonNovaBaixa.style.marginTop   = "10px";



    me.setPagamentoEmpenhoPassivo = function (iInscricao) {

      me.iInscricaoPassivo               = iInscricao;
      me.oTxtProcessoAdministrativoInput = new DBTextField('oTxtProcessoAdministrativoInput', me.sNomeInstancia+'.oTxtProcessoAdministrativoInput', '', 50);
      me.sParamContaDebito               = "getContaFavorecido";
      me.sTipoTransferencia              = "Baixa de Inscrição";

      me.oButtonNovaBaixa.onclick        = function (){
        window.location = "con4_baixainscricaopassivopagamento011.php";
      };
    };

    /**
     * Monta o componente e apresenta no objeto passado por parametro
     */
    me.show = function () {

      var oFieldset         = document.createElement("fieldset");
      oFieldset.style.width = "670px";
      var oLegend           = document.createElement("legend");
      oLegend.innerHTML     = "<b>"+me.sTipoTransferencia+"</b>";
      oLegend.id            = "legend_"+me.sNomeInstancia;
      oFieldset.id          = "fieldsetPrincipal_"+me.sNomeInstancia;
      oFieldset.appendChild(oLegend);

      var oTabela         = document.createElement("table");
      oTabela.id          = "table_"+me.sNomeInstancia;
      oTabela.style.width = "100%";

      /*
       * Table Row - Codigo
       */
      var iLinhaTabela = 0;
      var oRowCodigo               = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
      var oCellCodigoLabel         = oRowCodigo.insertCell(0);


      if (me.iOpcao == 1) {
        oCellCodigoLabel.innerHTML   = "<b>Código:</b>";
      } else if (me.iOpcao == 2) {
        oCellCodigoLabel.innerHTML   = "<b><a href='#' onclick='"+me.sNomeInstancia+".pesquisaCodigoSlip(true);'>Código:</a></b>";
      }

      oCellCodigoLabel.style.width = "150px";
      var oCellCodigoInput         = oRowCodigo.insertCell(1);
      oCellCodigoInput.style.width = "50px";
      oCellCodigoInput.id          = "td_codigo_"+me.sNomeInstancia;
      me.oTxtCodigoSlip.setReadOnly(true);
      me.oTxtCodigoSlip.show(oCellCodigoInput);

      /*
       * Instituicao Origem
       */
      var oRowInstituicaoOrigem                = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
      var oCellInstituicaoOrigemLabel          = oRowInstituicaoOrigem.insertCell(0);
      oCellInstituicaoOrigemLabel.innerHTML    = "<b>Instituição Origem:</b>";
      var oCellInstituicaoOrigemInput          = oRowInstituicaoOrigem.insertCell(1);
      oCellInstituicaoOrigemInput.id           = "td_InstituicaoOrigem_"+me.sNomeInstancia;
      var oCellDescricaoInstituicaoOrigemInput = oRowInstituicaoOrigem.insertCell(2);
      oCellDescricaoInstituicaoOrigemInput.id  = "td_DescricaoInstituicaoOrigem_"+me.sNomeInstancia;
      me.oTxtInstituicaoOrigemCodigo.show(oCellInstituicaoOrigemInput);
      me.oTxtInstituicaoOrigemCodigo.setReadOnly(true);
      me.oTxtDescricaoInstituicaoOrigem.setReadOnly(true);
      me.oTxtDescricaoInstituicaoOrigem.show(oCellDescricaoInstituicaoOrigemInput);

      /*
      * Tipo
      */
      var oRowTipo                 = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
      var oCellTipoLabel           = oRowTipo.insertCell(0);
      oCellTipoLabel.innerHTML     = "<strong>Tipo:</strong>";
      oCellTipoLabel.id            = "labelTipo";
      oCellTipoLabel.setAttribute("nowrap","nowrap");

      var oCellTipoInput = oRowTipo.insertCell(1);
      oCellTipoInput.id = "td_tipo_" + me.sNomeInstancia;
      oCellTipoInput.colSpan  = "3";
      oCellTipoInput.tabIndex = "1"; 
      oCellTipoInput.setAttribute("nowrap","nowrap");
         
      if (iTipoTransferencia != 5){
          oCellTipoLabel.setAttribute("hidden","hidden");
          oCellTipoInput.setAttribute("hidden","hidden");
      }

      var selectTipo = document.createElement("select");
      selectTipo.id = "txt_tipo_" + me.sNomeInstancia;
      selectTipo.style.width = "100%";
          
      var options = [
            { value: '', label: 'Selecione' },
            { value: '01', label: '01 - Aplicação Financeira' },
            { value: '02', label: '02 - Resgate de Aplicação Financeira' },
            { value: '03', label: '03 - Transferência entre contas bancárias' },
            { value: '04', label: '04 - Transferências de Valores Retidos' },
            { value: '05', label: '05 - Depósito decendial educação' },
            { value: '06', label: '06 - Depósito decendial saúde' },
            { value: '07', label: '07 - Transferência da Contrapartida do Convênio' },
            { value: '08', label: '08 - Transferência entre contas de fontes diferentes' },
            { value: '09', label: '09 - Transferência da conta caixa para esta conta' },
            { value: '10', label: '10 - Saques' }
      
      ];
          
      options.forEach(function(option) {
          var oTxtTipoInput  = document.createElement("option");
          oTxtTipoInput.value = option.value;
          oTxtTipoInput.text = option.label;
          selectTipo.appendChild(oTxtTipoInput );
      });
          
      oCellTipoInput.appendChild(selectTipo);

      selectTipo.style.display = "block";

      selectTipo.addEventListener("change", validaTipo);

      var selectedIndex = 0;

      selectTipo.addEventListener("keydown", function(event) {
        // Verifica se as teclas pressionadas são as setas para cima ou para baixo
        if (event.keyCode === 38) { 
            selectedIndex = Math.max(0, selectedIndex - 1); 
        } else if (event.keyCode === 40) { 
            selectedIndex = Math.min(selectTipo.options.length - 1, selectedIndex + 1); 
        } else if (event.keyCode === 9) { 
             document.getElementById("oTxtContaDebitoDescricao").focus();
        } 
        else {
            return; 
        }
        event.keyCode
        
        selectTipo.selectedIndex = selectedIndex;

        validaTipo(selectTipo.options[selectedIndex].value);

        event.preventDefault();
      });

      selectTipo.addEventListener("change", function() {
          validaTipo(selectTipo.options[selectTipo.selectedIndex].value);
      });

    /*
    *  Função para validar o tipo selecionado
    */
    function validaTipo(valorSelecionado) 
    {  

        me.oTxtContaDebitoCodigo.setReadOnly(true);
        me.oTxtContaDebitoDescricao.setReadOnly(true);
        me.oTxtContaCreditoCodigo.setReadOnly(true);
        me.oTxtContaCreditoDescricao.setReadOnly(true);
        me.oTxtContaDebitoCodigo.setValue('');
        me.oTxtContaDebitoDescricao.setValue('');
        me.oTxtContaCreditoCodigo.setValue('');
        me.oTxtContaCreditoDescricao.setValue('');
        me.oTxtFonteInputCodigo.setValue('');
        me.oTxtFonteInputDescricao.setValue('');
        me.oTxtHistoricoInputCodigo.setValue('');
        me.oTxtObservacaoInput.setValue('');

        if (valorSelecionado != ''){
            me.oTxtContaDebitoCodigo.setReadOnly(false);
            me.oTxtContaDebitoDescricao.setReadOnly(false);
        }
        if (valorSelecionado == 01){
            me.tipocontadebito   = 2;
            me.tipocontacredito  = 1; 
            me.buscaCamposAtivos(9791);
        }
        if (valorSelecionado == 02){
            me.tipocontadebito   = 1;
            me.tipocontacredito  = 2; 
            me.buscaCamposAtivos(9792);
        }
        if (valorSelecionado == 03){
            me.tipocontadebito   = 1; 
            me.tipocontacredito  = 1; 
            me.buscaCamposAtivos(9793);
        }
        if (valorSelecionado == 04){
            me.tipocontadebito   = 1;
            me.tipocontacredito  = 1; 
            me.buscaCamposAtivos(9794);
        }
        if (valorSelecionado == 05){
            me.tipocontadebito   = 1; 
            me.tipocontacredito  = 1; 
            me.buscaCamposAtivos(9795);
        }
        if (valorSelecionado == 06){
            me.tipocontadebito   = 1; 
            me.tipocontacredito  = 1; 
            me.buscaCamposAtivos(9796);
        }
        if (valorSelecionado == 07){
            me.tipocontadebito   = 1; 
            me.tipocontacredito  = 1; 
            me.buscaCamposAtivos(9797);
        }
        if (valorSelecionado == 08){
            me.tipocontadebito   = 1;
            me.tipocontacredito  = 1;
            me.buscaCamposAtivos(9798); 
        }
        if (valorSelecionado == 09){
            me.tipocontadebito   = 1;
            me.tipocontacredito  = 3; 
            me.buscaCamposAtivos(9799);
        }
        if (valorSelecionado == 10){
            me.tipocontadebito   = 3;
            me.tipocontacredito  = 1; 
            me.buscaCamposAtivos(9790);
        }
        
    }

      /**
       * Instituicao destino
       */
      var oRowInstituicaoDestino                = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
      oRowInstituicaoDestino.id                 = "tr_InstituicaoDestino_"+me.sNomeInstancia;
      var oCellInstituicaoDestinoLabel          = oRowInstituicaoDestino.insertCell(0);
      oCellInstituicaoDestinoLabel.id           = "td_instituicaodestino_"+me.sNomeInstancia;
      oCellInstituicaoDestinoLabel.innerHTML    = "<b><a href='#' onclick='"+me.sNomeInstancia+".pesquisaInstituicaoDestino(true);'>Instituição Destino:</a></b>";

      var oCellInstituicaoDestinoInputCodigo          = oRowInstituicaoDestino.insertCell(1);
      me.oTxtInstituicaoDestinoCodigo.show(oCellInstituicaoDestinoInputCodigo);

      var oCellDescricaoInstituicaoDestinoInput = oRowInstituicaoDestino.insertCell(2);
      oCellDescricaoInstituicaoDestinoInput.id  = "td_DescricaoInstituicaoDestino_"+me.sNomeInstancia;
      me.oTxtDescricaoInstituicaoDestino.setReadOnly(true);
      me.oTxtDescricaoInstituicaoDestino.show(oCellDescricaoInstituicaoDestinoInput);

      /**
       * Favorecido
       */
      var oRowFavorecido             = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
      oRowFavorecido.id              = "tr_favorecido_"+me.sNomeInstancia;
      var oCellFavorecidoLabel       = oRowFavorecido.insertCell(0);
      oCellFavorecidoLabel.id        = "td_favorecido_"+me.sNomeInstancia;

      if (me.iOpcao == 2) {
        oCellFavorecidoLabel.innerHTML = "<b>Favorecido:</b>";
      } else {
        oCellFavorecidoLabel.innerHTML = "<b><a href='#' onclick='"+me.sNomeInstancia+".pesquisaFavorecido(true);'>Favorecido:</a></b>";
      }

      var oCellFavorecidoInputCodigo = oRowFavorecido.insertCell(1);
      me.oTxtFavorecidoInputCodigo.show(oCellFavorecidoInputCodigo);

      var oCellFavorecidoInputDescricao = oRowFavorecido.insertCell(2);
      me.oTxtFavorecidoInputDescricao.show(oCellFavorecidoInputDescricao);

       /**
       * Input div onde mostra os valores do autocomplete
       */
       var oRowFavorecidoInputdiv = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
       var oCellFavorecidoInputdiv = oRowFavorecidoInputdiv.insertCell(0);
       oCellFavorecidoInputdiv = oRowFavorecidoInputdiv.insertCell(1);
       oCellFavorecidoInputdiv = oRowFavorecidoInputdiv.insertCell(2);
       oCellFavorecidoInputdiv.colSpan  = "8";
       oCellFavorecidoInputdiv.id  = "resultfavorecido";
       oCellFavorecidoInputdiv.setAttribute("hidden","hidden");

      /**
       * Label Conta Debito
       */
      var oRowContaDebito             = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
      var oCellContaDebitoLabel       = oRowContaDebito.insertCell(0);
      oCellContaDebitoLabel.id = "labelContaDebito";
      oCellContaDebitoLabel.innerHTML = "<b><a href='#' onclick='"+me.sNomeInstancia+".pesquisaConta"+me.sPesquisaContaDebito+"(true, false);'>Conta Débito:</a></b>";

      /**
       * Input de codigo para a conta débito
       */
      var oCellContaDebitoCodigo = oRowContaDebito.insertCell(1);
      oCellContaDebitoCodigo.id  = "td_contadebito_"+me.sNomeInstancia;
      me.oTxtContaDebitoCodigo.show(oCellContaDebitoCodigo);

      /**
       * Input de descrição para a conta débito
       */
      var oCellContaDebitoDescricao = oRowContaDebito.insertCell(2);
      oCellContaDebitoDescricao.id  = "td_contadebito_"+me.sNomeInstancia;
      me.oTxtContaDebitoDescricao.show(oCellContaDebitoDescricao);

      /**
      * Input div onde mostra os valores do autocomplete
      */
      var oRowContaDebitodiv = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
      var oCellContaDebitodiv = oRowContaDebitodiv.insertCell(0);
      oCellContaDebitodiv = oRowContaDebitodiv.insertCell(1);
      oCellContaDebitodiv = oRowContaDebitodiv.insertCell(2);
      oCellContaDebitodiv.colSpan  = "8";
      oCellContaDebitodiv.id  = "resultdebito";
      oCellContaDebitodiv.setAttribute("hidden","hidden");

      /**
       * Label Caracteristica Peculiar
       */
      var oRowCaracteristica                   = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
      var oCellCaracteristicaDebitoLabel       = oRowCaracteristica.insertCell(0);
      oCellCaracteristicaDebitoLabel.id        = "td_cpca_contadebito_"+me.sNomeInstancia;
      oCellCaracteristicaDebitoLabel.setAttribute("hidden","hidden");
      oCellCaracteristicaDebitoLabel.innerHTML = "<b><a href='#' onclick='"+me.sNomeInstancia+".pesquisaCaracteristicaPeculiarDebito(true);'>C.Peculiar / C.Aplicação:</a></b>";

      /**
       * Codigo Caracteristica Peculiar
       */
      var oCellCaracteristicaDebitoInputCodigo = oRowCaracteristica.insertCell(1);
      me.oTxtCaracteristicaDebitoInputCodigo.show(oCellCaracteristicaDebitoInputCodigo);
      oCellCaracteristicaDebitoInputCodigo.setAttribute("hidden","hidden");

      /**
       * Descricao Caracteristica Peculiar
       */
      var oCellCaracteristicaDebitoInputDescricao = oRowCaracteristica.insertCell(2);
      me.oTxtCaracteristicaDebitoInputDescricao.setReadOnly(true);
      me.oTxtCaracteristicaDebitoInputDescricao.show(oCellCaracteristicaDebitoInputDescricao);
      oCellCaracteristicaDebitoInputDescricao.setAttribute("hidden","hidden");

      /**
       * Label Conta Credito
       */
      var oRowContaCredito             = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
      var oCellContaCreditoLabel       = oRowContaCredito.insertCell(0);
      oCellContaCreditoLabel.innerHTML = "<b><a href='#' onclick='"+me.sNomeInstancia+".pesquisaConta"+me.sPesquisaContaCredito+"(true,true);'>Conta Crédito:</a></b>";
      oCellContaCreditoLabel.id = "labelContaCredito";

      /**
       * Input de codigo para a conta credito
       */
      var oCellContaCreditoCodigo = oRowContaCredito.insertCell(1);
      oCellContaCreditoCodigo.id  = "td_contaCredito_"+me.sNomeInstancia;
      me.oTxtContaCreditoCodigo.show(oCellContaCreditoCodigo);

      /**
       * Input de descrição para a conta credito
       */
      var oCellContaCreditoDescricao = oRowContaCredito.insertCell(2);
      oCellContaCreditoDescricao.id  = "td_contaCredito_"+me.sNomeInstancia;
      me.oTxtContaCreditoDescricao.show(oCellContaCreditoDescricao);

       /**
       * Input div onde mostra os valores do autocomplete
       */
      var oRowContaCreditodiv = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
      var oCellContaCreditodiv = oRowContaCreditodiv.insertCell(0);
      oCellContaCreditodiv = oRowContaCreditodiv.insertCell(1);
      oCellContaCreditodiv = oRowContaCreditodiv.insertCell(2);
      oCellContaCreditodiv.colSpan  = "8";
      oCellContaCreditodiv.id  = "resultcredito";
      oCellContaCreditodiv.setAttribute("hidden","hidden");
     
      /**
       * Label Fonte
       */
      if (me.iAno >= 2022 || me.lAlteracao == true) {
        var oRowFonte             = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
        var oCellFonteLabel       = oRowFonte.insertCell(0);
        oCellFonteLabel.id        = "td_fonte_"+me.sNomeInstancia;
        oCellFonteLabel.innerHTML = "<b><a href='#' onclick='"+me.sNomeInstancia+".pesquisaFonte(true);'>Fonte de Recursos:</a></b>";
    }
    /**
     * Codigo Fonte
     */
    if (me.iAno >= 2022 || me.lAlteracao == true) {
        var oCellFonteInputCodigo = oRowFonte.insertCell(1);
        me.oTxtFonteInputCodigo.show(oCellFonteInputCodigo);
    }

      /**
       * Caracteristica peculiar conta credito
       */
      var oRowCaracteristicaContaCredito        = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
      var oCellCaracteristicaCreditoLabel       = oRowCaracteristicaContaCredito.insertCell(0);
      oCellCaracteristicaCreditoLabel.id        = "td_cpca_contacredito_"+me.sNomeInstancia;
      oCellCaracteristicaCreditoLabel.setAttribute("hidden","hidden");
      oCellCaracteristicaCreditoLabel.innerHTML = "<b><a href='#' onclick='"+me.sNomeInstancia+".pesquisaCaracteristicaPeculiarCredito(true);'>C.Peculiar / C.Aplicação:</a></b>";

      /**
       * Codigo Caracteristica Peculiar
       */
      var oCellCaracteristicaCreditoInputCodigo = oRowCaracteristicaContaCredito.insertCell(1);
      me.oTxtCaracteristicaCreditoInputCodigo.show(oCellCaracteristicaCreditoInputCodigo);
      oCellCaracteristicaCreditoInputCodigo.setAttribute("hidden","hidden");

      /**
       * Descricao Caracteristica Peculiar
       */
      var oCellCaracteristicaCreditoInputDescricao = oRowCaracteristicaContaCredito.insertCell(2);
      me.oTxtCaracteristicaCreditoInputDescricao.setReadOnly(true);
      me.oTxtCaracteristicaCreditoInputDescricao.show(oCellCaracteristicaCreditoInputDescricao);
      oCellCaracteristicaCreditoInputDescricao.setAttribute("hidden","hidden");


      /**
       * Finalidade Pagamento Fundeb
       */
      var oRowFinalidadePagamentoFundeb         = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
      oRowFinalidadePagamentoFundeb.id          = "tr_finalidadepagamento_credito_"+me.sNomeInstancia;
      oRowFinalidadePagamentoFundeb.style.display = 'none';
      var oCellFinalidadePagamentoFundebLabel   = oRowFinalidadePagamentoFundeb.insertCell(0);
      oCellFinalidadePagamentoFundebLabel.id        = "td_finalidadepagamentofundeb_contacredito_"+me.sNomeInstancia;
      oCellFinalidadePagamentoFundebLabel.innerHTML = "<b><a href='#' onclick='"+me.sNomeInstancia+".pesquisaFinalidadeFundeb(true);'>Finalidade C. Crédito:</a></b>";

      /**
       * Codigo Finalidade Pagamento
       */
      var oCellFinalidadePagamentoFundebCodigo = oRowFinalidadePagamentoFundeb.insertCell(1);
      me.oTxtCodigoFinalidadeFundeb.show(oCellFinalidadePagamentoFundebCodigo);

      /**
       * Descrição Finalidade Pagamento
       */
      var oCellFinalidadePagamentoFundebDescricao = oRowFinalidadePagamentoFundeb.insertCell(2);
      me.oTxtDescricaoFinalidadeFundeb.setReadOnly(true);
      me.oTxtDescricaoFinalidadeFundeb.show(oCellFinalidadePagamentoFundebDescricao);

      /**
       * Label Historico
       */
      var oRowHistorico             = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
      var oCellHistoricoLabel       = oRowHistorico.insertCell(0);
      oCellHistoricoLabel.id        = "td_historico_"+me.sNomeInstancia;
      oCellHistoricoLabel.innerHTML = "<b><a href='#' onclick='"+me.sNomeInstancia+".pesquisaHistorico(true);'>Histórico:</a></b>";

      /**
       * Codigo Historico
       */
      var oCellHistoricoInputCodigo = oRowHistorico.insertCell(1);
      me.oTxtHistoricoInputCodigo.show(oCellHistoricoInputCodigo);

      /**
       * Descricao Historico
       */
      var oCellHistoricoInputDescricao = oRowHistorico.insertCell(2);
      me.oTxtHistoricoInputDescricao.show(oCellHistoricoInputDescricao);

      /**
       * Input div onde mostra os valores do autocomplete
       */
       var oRowHistoricoInputdiv = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
       var oCellHistoricoInputdiv = oRowHistoricoInputdiv.insertCell(0);
       oCellHistoricoInputdiv = oRowHistoricoInputdiv.insertCell(1);
       oCellHistoricoInputdiv = oRowHistoricoInputdiv.insertCell(2);
       oCellHistoricoInputdiv.colSpan  = "8";
       oCellHistoricoInputdiv.id  = "resulthistorico";
       oCellHistoricoInputdiv.setAttribute("hidden","hidden");

    
      /**
       * Descricao Historico
       */
      if (me.iAno >= 2022 || me.lAlteracao == true) {
          var oCellFonteInputDescricao = oRowFonte.insertCell(2);
          me.oTxtFonteInputDescricao.setReadOnly(true);
          me.oTxtFonteInputDescricao.show(oCellFonteInputDescricao);
      }

        /**
         * Label Exercício da Competência da Devolução
        */
        me.iLinhaExercicioDevolucao = iLinhaTabela;
        var oRowExercicioCompetenciaDevolucao = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
        var oCelloRowExercicioCompetenciaDevolucaoLabel = oRowExercicioCompetenciaDevolucao.insertCell(0);
        oCelloRowExercicioCompetenciaDevolucaoLabel.innerHTML = "<strong>Exercício da Competência da Devolução:</strong>";

        var oCellExercicioCompetenciaDevolucaoInput = oRowExercicioCompetenciaDevolucao.insertCell(1);
        oCellExercicioCompetenciaDevolucaoInput.colSpan = "2";

        me.oTxtExercicioCompetenciaDevolucaoInput.show(oCellExercicioCompetenciaDevolucaoInput);
        oTabela.rows[me.iLinhaExercicioDevolucao].hidden = true;

      /**
       * Label Processo
       */
      var oRowProcesso                 = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
      var oCellProcessoLabel           = oRowProcesso.insertCell(0);
          oCellProcessoLabel.innerHTML = "<strong>Processo Administrativo:</strong>";

      var oCellProcessoInput           = oRowProcesso.insertCell(1);
          oCellProcessoInput.colSpan   = "2";

      me.oTxtProcessoInput.show(oCellProcessoInput);

       /**
       * Label Número do Documento
       */
       var oRowNumDocumento                 = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
       var oCellNumDocumentoLabel           = oRowNumDocumento.insertCell(0);
           oCellNumDocumentoLabel.innerHTML = "<strong>Número do Documento:</strong>";
           me.iMostrarNumDoc  == 's' ? oCellNumDocumentoLabel.setAttribute("nowrap","nowrap") : oCellNumDocumentoLabel.setAttribute("hidden","hidden");
 
       var oCellNumDocumentoInput           = oRowNumDocumento.insertCell(1);
           oCellNumDocumentoInput.colSpan   = "2";
           me.oTxtNumDocumentoInput.show(oCellNumDocumentoInput);
           me.iMostrarNumDoc  == 's' ? oCellNumDocumentoInput.setAttribute("nowrap","nowrap") : oCellNumDocumentoInput.setAttribute("hidden","hidden");
 
      /**
       * Label Valor
       */
      var oRowValor             = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
      var oCellValorLabel       = oRowValor.insertCell(0);
      oCellValorLabel.innerHTML = "<b>Valor:</b>";

      var oCellValorInput       = oRowValor.insertCell(1);
      oCellValorInput.colSpan   = "2";
      me.oTxtValorInput.show(oCellValorInput);

      /**
      * Label Data
      */
      var oRowData             = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
      var oCellDataLabel       = oRowData.insertCell(0);
      oCellDataLabel.innerHTML = "<b>Data:</b>";
      
      var oCellDataInput       = oRowData.insertCell(1);
      oCellDataInput.colSpan   = "2";
      oCellDataInput.id        = "td_data_"+me.sNomeInstancia;
      me.oTxtDataInput.show(oCellDataInput);

        /**
      * Label Data Estorno
      */
        var oRowDataEstorno      = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
        var oCellDataEstornoLabel       = oRowDataEstorno.insertCell(0);
        oCellDataEstornoLabel.innerHTML = "<b>Data Estorno:</b>";
        
        var oCellDataEstornoInput       = oRowDataEstorno.insertCell(1);
        oCellDataEstornoInput.colSpan   = "2";
        oCellDataEstornoInput.id        = "td_dataestorno_"+me.sNomeInstancia;
        me.oTxtDataEstornoInput.show(oCellDataEstornoInput);
        if (iTipoTransferencia >= 0 && iTipoTransferencia <= 18 && iTipoTransferencia % 2 !== 0) {
          oCellDataEstornoLabel.setAttribute("hidden","hidden");
          oCellDataEstornoInput.setAttribute("hidden","hidden");
        }

      /**
       * Label Processo Administrativo
       */
      if (me.iInscricaoPassivo != null) {

        var oRowProcesso             = oTabela.insertRow(iLinhaTabela); iLinhaTabela++;
        var oCellRowProcesso         = oRowProcesso.insertCell(0);
        oCellRowProcesso.innerHTML   = "<b>Processo Administrativo:</b>";

        var oCellProcessoInput       = oRowProcesso.insertCell(1);
        oCellProcessoInput.colSpan   = "2";
        me.oTxtProcessoAdministrativoInput.show(oCellProcessoInput);
      }

      /**
       * Fieldset Observacao
       */
      var oFieldsetObservacao       = document.createElement('fieldset');
      var oLegendObservacao         = document.createElement('legend');
      oLegendObservacao.innerHTML   = "<b>Descrição do Histórico:</b>";
      oFieldsetObservacao.appendChild(oLegendObservacao);
      oFieldsetObservacao.appendChild(me.oTxtObservacaoInput);

      /**
       * Fieldset Observacao
       */
      var oFieldsetMotivoEstorno    = document.createElement('fieldset');
      oFieldsetMotivoEstorno.id     = "fieldset_motivo_anulacao_"+me.sNomeInstancia;
      var oLegendObservacao         = document.createElement('legend');
      oLegendObservacao.innerHTML   = "<b>Motivo:</b>";
      oFieldsetMotivoEstorno.appendChild(oLegendObservacao);
      oFieldsetMotivoEstorno.appendChild(me.oTxtMotivoAnulacaoInput);

      /**
       * Executamos o APPEND ao objeto destino
       */
      oFieldset.appendChild(oTabela);
      oFieldset.appendChild(oFieldsetObservacao);
      oFieldset.appendChild(oFieldsetMotivoEstorno);
      me.oDivDestino.appendChild(oFieldset);
      me.oDivDestino.appendChild(me.oButtonSalvar);
      me.oDivDestino.appendChild(me.oButtonEstornar);
      me.oDivDestino.appendChild(me.oButtonImportar);
      me.oDivDestino.appendChild(me.oButtonNovo);

      if (me.iOpcao == 1) {

        me.oButtonSalvar.style.display    = '';
        me.oButtonEstornar.style.display  = 'none';
        $("fieldset_motivo_anulacao_"+me.sNomeInstancia).style.display = 'none';
      } else {

        me.oButtonSalvar.style.display    = 'none';
        me.oButtonImportar.style.display  = 'none';
        me.oButtonNovo.style.display  = 'none';
        me.oButtonEstornar.style.display  = '';
        $("fieldset_motivo_anulacao_"+me.sNomeInstancia).style.display = '';
      }

      if (me.iTipoTransferencia != 1) {
        $("tr_InstituicaoDestino_"+me.sNomeInstancia).style.display = 'none';
      }

      if (me.iTipoTransferencia == 5 || me.iTipoTransferencia == 6) {
        oRowFavorecido.style.display = 'none';
      }

      if (me.iInscricaoPassivo != null) {

        me.oDivDestino.appendChild(me.oButtonNovaBaixa);
        me.oButtonImportar.style.display  = 'none';
        oLegend.innerHTML = "<b>Baixa por Pagamento</b>";

        js_divCarregando("Aguarde, buscando os dados da inscrição...", "msgBox");

        var oParam              = new Object();
        oParam.exec             = "getDadosInscricao";
        oParam.iCodigoInscricao = me.iInscricaoPassivo;

        /*
         * Buscamos os valores da inscrição
         */
        new Ajax.Request(me.sUrlRpc,
                        {method: 'post',
                         parameters: 'json='+Object.toJSON(oParam),
                         onComplete: function (oAjax) {

                           js_removeObj("msgBox");
                           var oRetorno = eval("("+oAjax.responseText+")");

                           $("td_favorecido_"+me.sNomeInstancia).innerHTML = "<b>Favorecido:</b>";

                           me.oTxtFavorecidoInputCodigo.setValue(oRetorno.iCgmFavorecido);
                           me.oTxtFavorecidoInputDescricao.setValue(oRetorno.sNomeFavorecido.urlDecode());

                           me.oTxtContaDebitoCodigo.setValue(oRetorno.iContaDebito);
                           me.oTxtContaDebitoDescricao.setValue(oRetorno.sDescrContaDebito.urlDecode());

                           me.oTxtValorInput.setValue(js_formatar(oRetorno.nValorTotalInscricao, 'f'));

                           me.oTxtValorInput.setReadOnly(true);
                         }
                        });
      }
    };

    /**
     * Método que  ajusta tela para baixa de pagamento
     */
    me.ajustaTelaBaixaPagamento = function() {

      me.oTxtFavorecidoInputCodigo.setReadOnly(true);

      me.oTxtContaDebitoCodigo.setReadOnly(true);

      me.oTxtCaracteristicaCreditoInputCodigo.setValue("000");
      me.pesquisaCaracteristicaPeculiarCredito(false);

      me.oTxtCaracteristicaDebitoInputCodigo.setValue("000");
      me.pesquisaCaracteristicaPeculiarDebito(false);
    };

     /**
     * Verifica se o tipo foi selecionado
     * @return boolean
     */
     me.validarTipo = function() {

      if (empty($("txt_tipo_" + me.sNomeInstancia).value)) {
        if (iTipoTransferencia == 5){  
          alert("Selecione um Tipo.");
          return false;
        }
      }
      return true;
    };

    /**
     * Verifica se a conta crédito e conta débito são iguais
     * Devem ser diferentes
     * @return boolean
     */
    me.validarContaCreditoDebito = function() {

      if (me.oTxtContaCreditoCodigo.getValue() == me.oTxtContaDebitoCodigo.getValue()) {

        alert("Conta débito e conta crédito devem ser diferentes.");
        return false;
      }
      return true;
    };

    /**
     * Salva os dados de uma transferencia bancaria
     */
    me.oButtonSalvar.observe('click', function() {

      if (!me.validarInstituicao()) {
        return false;
      }

      if (!me.validarTipo()) {
        return false;
      }

      if (!me.validarContaCreditoDebito()) {
        return false;
      }

      if (me.iTipoTransferencia != 5 && me.iTipoTransferencia != 6) {

        if (me.oTxtFavorecidoInputCodigo.getValue() == "") {

          alert("Favorecido não informado.");
          return false;
        }
      }

      if (me.iAno >= 2022) {
          if (me.oTxtFonteInputCodigo.getValue() == "") {
              alert("Fonte não informada.");
              return false;
          }

            if (me.temExercicioDevolucao()) {
                if (me.oTxtExercicioCompetenciaDevolucaoInput.getValue() == "") {
                    alert("Exercício da Competência da Devolução não informada.");
                    return false;
                }

                if (me.oTxtExercicioCompetenciaDevolucaoInput.getValue().length != 4) {
                    alert("Exercício da Competência da Devolução incorreta.");
                    return false;
                }
            }
      }

      if (me.iTipoTransferencia == 1) {

        if (me.oTxtInstituicaoDestinoCodigo.getValue() == "") {
          alert("Informe a instituição de destino.");
          return false;
        }
      }

      if (me.lFinalidadeDePagamentoFundeb && me.oTxtCodigoFinalidadeFundeb.getValue() == "") {

        alert("Informe a finalidade de pagamento do FUNDEB.");
        return false;
      }

      if (me.oTxtHistoricoInputCodigo.getValue() == "") {

        alert("Informe o histórico para a transferência.");
        return false;
      }
      
      if (me.oTxtDataInput.getValue() == "") {

        alert("Informe a Data.");
        return false;
      } 

      if (me.oTxtValorInput.getValue() == "" || me.oTxtValorInput.getValue() <= 0) {

        alert("O campo valor não pode ser vazio nem ser negativo.");
        return false;
      }

      var aDadosValor = me.oTxtValorInput.getValue().split(',');

      if (aDadosValor.length > 2) {

        alert("Valor digitado inválido. Verifique.");
        return false;
      }

      if (me.getObservacao() == "") {

        alert("Campo descrição do histórico é obrigatório.");
        return false;
      }

      if (me.iInscricaoPassivo != null && me.oTxtProcessoAdministrativoInput.getValue() == "") {

        alert("Campo processo adminstrativo é obrigatório.");
        return false;
      }


      js_divCarregando("Aguarde, salvando dados da transferência...", "msgBox");
      var oParam                            = new Object();
      oParam.exec                           = "salvarSlip";
      oParam.k17_codigo                     = me.oTxtCodigoSlip.getValue();
      oParam.iCodigoTipoOperacao            = me.iTipoTransferencia;
      oParam.k17_debito                     = me.oTxtContaDebitoCodigo.getValue();
      oParam.k17_credito                    = me.oTxtContaCreditoCodigo.getValue();
      oParam.k17_valor                      = me.oTxtValorInput.getValue();
      oParam.k17_hist                       = me.oTxtHistoricoInputCodigo.getValue();
      oParam.iCGM                           = me.oTxtFavorecidoInputCodigo.getValue();
      if (me.iAno >= 2022 || me.lAlteracao == true)
          oParam.iCodigoFonte = me.oTxtFonteInputCodigo.getValue();
      oParam.sCaracteristicaPeculiarDebito  = me.oTxtCaracteristicaDebitoInputCodigo.getValue();
      oParam.sCaracteristicaPeculiarCredito = me.oTxtCaracteristicaCreditoInputCodigo.getValue();
        if (me.iAno >= 2022 && me.temExercicioDevolucao())
            oParam.iExercicioCompetenciaDevolucao = me.oTxtExercicioCompetenciaDevolucaoInput.getValue();
      oParam.k17_texto                      = encodeURIComponent(tagString(me.getObservacao()));
      oParam.sCodigoFinalidadeFundeb        = me.oTxtCodigoFinalidadeFundeb.getValue();
      oParam.k17_numdocumento               = encodeURIComponent(tagString(me.oTxtNumDocumentoInput.getValue())) ;
      oParam.k17_data                       = me.oTxtDataInput.getValue();
      oParam.k17_tiposelect                 = iTipoTransferencia == 5 ? $("txt_tipo_" + me.sNomeInstancia).value : '' ;  
      oParam.k145_numeroprocesso            = encodeURIComponent(tagString(me.oTxtProcessoInput.getValue())) ;

      if(me.iInscricaoPassivo != null) {

        oParam.k17_texto += " Processo Adminstrativo: ";
        oParam.k17_texto += encodeURIComponent(tagString(me.oTxtProcessoAdministrativoInput.getValue()));
        oParam.iInscricao = me.iInscricaoPassivo;
        sMsg  = "Este expediente deverá ser utilizado para registrar o fato contábil ocorrido,";
        sMsg += " mas fica-se claro que é absolutamente ilegal realizar pagamentos sem o prévio empenho da despesa.\n";
        sMsg += "Logo, recomenda-se a abertura de Processo Administrativo e que este seja anexado a documentação,";
        sMsg += "visando proteger a integridade profissional do responsável técnico da área contábil.";
        alert(sMsg);
      }

      if (me.iTipoTransferencia == 1) {
        oParam.iCodigoInstituicaoDestino = me.oTxtInstituicaoDestinoCodigo.getValue();
      }

      new Ajax.Request(me.sUrlRpc,
                      {method: 'post',
                       async: false,
                       parameters: 'json='+Object.toJSON(oParam),
                       onComplete: me.completaSalvar
                      });
    });

    /**
     * Funcao responsavel por tratar os dados do objeto depois de salvar
     */
    me.completaSalvar = function (oAjax) {

      js_removeObj("msgBox");
      var oRetorno = eval("("+oAjax.responseText+")");
      if (oRetorno.status == 1) {

        if (confirm(oRetorno.message.urlDecode()+" Deseja emitir o documento?")) {
          window.open('cai1_slip003.php?&numslip='+oRetorno.iCodigoSlip, '', 'location=0');
        }
        me.clearAllFields();
      } else {
        alert(oRetorno.message.urlDecode());
      }
    };

    /**
     * Executa o estorno do pagamento
     */
    me.oButtonEstornar.observe('click', function() {

      if (iTipoTransferencia >= 0 && iTipoTransferencia <= 18 && iTipoTransferencia % 2 == 0) {
        if (me.oTxtDataEstornoInput.getValue() == ""){
          alert("Informe a Data de Estorno.");
          return false;
        }
      }

      if (me.getMotivoAnulacao() == "") {

        alert("É necessário informar o motivo do estorno.");
        return false;
      }

      var sMsgEstorno = "Deseja estonar a transferência "+me.oTxtCodigoSlip.getValue()+"?";
      if (!confirm(sMsgEstorno)) {
        return false;
      }

      js_divCarregando("Aguarde, estornando transferência...", "msgBox");

      var oParam                 = new Object();
      oParam.exec                = "anularSlip";
      oParam.sMotivo             = encodeURIComponent(tagString(me.getMotivoAnulacao()));
      oParam.k17_codigo          = me.oTxtCodigoSlip.getValue();
      oParam.iCodigoTipoOperacao = me.iTipoTransferencia;
      oParam.iDataEstorno        = me.oTxtDataEstornoInput.getValue(); 

      new Ajax.Request(me.sUrlRpc,
                      {method: 'post',
                       parameters: 'json='+Object.toJSON(oParam),
                       async: false,
                       onComplete: me.completaEstorno
                      });
    });

    me.completaEstorno = function (oAjax) {

      js_removeObj("msgBox");
      var oRetorno = eval("("+oAjax.responseText+")");
      alert(oRetorno.message.urlDecode());
      if (oRetorno.status == 1) {
        me.oTxtDataEstornoInput.setValue('');
        me.oTxtMotivoAnulacaoInput.value = '';
        me.start();
      }
    };

    /**
     * Importa um slip já existente
     */
    me.oButtonImportar.observe('click', function (){

      me.lImportacao = true;
      me.pesquisaCodigoSlip(true);
    });

    me.oButtonNovo.observe('click', function (){
      location.reload();
    });

     /** Bloqueia os campos de contas ao carregar a tela
    */
    if (iTipoTransferencia == 5){
      me.oTxtContaDebitoCodigo.setReadOnly(true);
      me.oTxtContaDebitoDescricao.setReadOnly(true);
      me.oTxtContaCreditoCodigo.setReadOnly(true);
      me.oTxtContaCreditoDescricao.setReadOnly(true);
    }
  
    /**
     * Lookup de pesquisa conta saltes
     */
    me.pesquisaContaSaltes = function (lMostra, lCredito) {

      /**
       * Controla que função chamar para completar os campos
       * e também para pegar o valor do input certo
       */
      var sFunctionCompleta = "Debito";
      var sIframe           = me.sPesquisaContaDebito;
      if (lCredito) {

        sFunctionCompleta = "Credito";
        sIframe           = me.sPesquisaContaCredito;
      }

      var sObjetoTxtConta = "me.oTxtConta" + sFunctionCompleta + "Codigo";
      var oTxtConta       = eval(sObjetoTxtConta);
      var oTxtTipo        = iTipoTransferencia == 5 ? $("txt_tipo_" + me.sNomeInstancia).value : 0;

      var sUrlSaltes = "func_saltesreduz.php?pesquisa_chave="+oTxtConta.getValue()+"&funcao_js=parent."+me.sNomeInstancia+".preenche"+sFunctionCompleta+"&ver_datalimite=1&tipocontadebito="+me.tipocontadebito+"&tipocontacredito="+me.tipocontacredito+"&tipoconta="+sFunctionCompleta+"&tiposelecione="+oTxtTipo+"&codigoconta="+me.oTxtContaDebitoCodigo.getValue(); /* Ocorrencia 2227 */
      if (lMostra) {
        sUrlSaltes = "func_saltesreduz.php?funcao_js=parent."+me.sNomeInstancia+".completa"+sFunctionCompleta+"|k13_reduz|k13_descr|c60_tipolancamento|c60_subtipolancamento|db83_tipoconta|c61_codigo&ver_datalimite=1&tipocontadebito="+me.tipocontadebito+"&tipocontacredito="+me.tipocontacredito+"&tipoconta="+sFunctionCompleta+"&tiposelecione="+oTxtTipo+"&codigoconta="+me.oTxtContaDebitoCodigo.getValue(); /* Ocorrencia 2227 */
      }

      js_OpenJanelaIframe("", 'db_iframe_'+sIframe, sUrlSaltes, "Pesquisa Contas", lMostra);
    };

    me.pesquisaContaEventoContabil = function(lMostra, lCredito) {

      var sFunctionCompleta = "Debito";
      var sIframe           = me.sPesquisaContaDebito;
      if (lCredito) {

        sFunctionCompleta = "Credito";
        sIframe           = me.sPesquisaContaCredito;
      }

      var sObjetoTxtConta = "me.oTxtConta" + sFunctionCompleta + "Codigo";
      var oTxtConta       = eval(sObjetoTxtConta);

      var sUrlEvento  = "func_contaeventocontabil.php?pesquisa_chave="+oTxtConta.getValue()+"&funcao_js=parent."+me.sNomeInstancia+".preenche"+sFunctionCompleta;
      sUrlEvento     += "&iTipoTransferencia="+me.iTipoTransferencia;
      sUrlEvento     += "&lContaCredito="+lCredito;

      if (lMostra) {

        sUrlEvento  = "func_contaeventocontabil.php?iTipoTransferencia="+me.iTipoTransferencia;
        sUrlEvento += "&lContaCredito="+lCredito;
        sUrlEvento += "&funcao_js=parent."+me.sNomeInstancia+".completa"+sFunctionCompleta+"|reduzido|descricao|c60_tipolancamento|c60_subtipolancamento";
      }

      if (me.iInscricaoPassivo != null) {

        sUrlEvento = "func_contafornecedorinscricaopassivo.php?iInscricao="+me.iInscricaoPassivo+"&funcao_js=parent."+me.sNomeInstancia+".completaDebito|c69_credito|c60_descr";
      }

      js_OpenJanelaIframe("", 'db_iframe_'+sIframe, sUrlEvento, "Pesquisa Contas", lMostra);
    };

    me.bTipoDevolucao = function (iTipo, iSubtipo) {
        if (iTipo == 4 && iSubtipo == 2)
            return 't';
        return 'f';
    }

    me.completaDebito = function(iReduzido, sDescricao, iTipo, iSubtipo,iTipoconta,iCodfonte) {
      me.oTxtContaDebitoCodigo.setValue(iReduzido);
      me.oTxtContaDebitoDescricao.setValue(sDescricao);
      me.bTemExercicioDevolucaoDebito = me.bTipoDevolucao(iTipo, iSubtipo);
      me.oTxtFonteInputCodigo.setValue('');
      if (me.oTxtContaDebitoCodigo && (iTipoTransferencia == '1' || iTipoTransferencia == '3' || iTipoTransferencia == '5' || iTipoTransferencia == '7' || iTipoTransferencia == '9' || iTipoTransferencia == '11' || iTipoTransferencia == '13' || iTipoTransferencia == '15' || iTipoTransferencia == '17')) {
          me.oTxtContaCreditoCodigo.setReadOnly(false);
          me.oTxtContaCreditoDescricao.setReadOnly(false);
          document.getElementById("oTxtContaCreditoDescricao").focus();
      }
      if (iTipoTransferencia == 5){
        if (($("txt_tipo_" + me.sNomeInstancia).value != 07 && $("txt_tipo_" + me.sNomeInstancia).value != 10) && $("txt_tipo_" + me.sNomeInstancia).value != 08){
            me.oTxtFonteInputCodigo.setValue(iCodfonte);
            me.oTxtFonteInputCodigo.setReadOnly(true);
            me.pesquisaFonte(false)   
        }
      }  
      me.mostrarExercicioDevolucao();

      var sIframeConta = "db_iframe_" + me.sPesquisaContaDebito;
      var oIframe      = eval(sIframeConta);
      oIframe.hide();
    };

    me.preencheDebito = function(sDescricao,sCodfonte,sReduzido, lErro) {

      me.oTxtContaDebitoDescricao.setValue(sDescricao);
      if (me.lImportacao == false ) {
        me.oTxtFonteInputCodigo.setValue('');
      }
      if (me.oTxtContaDebitoCodigo && (iTipoTransferencia == '1' || iTipoTransferencia == '3' || iTipoTransferencia == '5' || iTipoTransferencia == '7' || iTipoTransferencia == '9' || iTipoTransferencia == '11' || iTipoTransferencia == '13' || iTipoTransferencia == '15' || iTipoTransferencia == '17')) {
        me.oTxtContaCreditoCodigo.setReadOnly(false);
        me.oTxtContaCreditoDescricao.setReadOnly(false);
        document.getElementById("oTxtContaCreditoDescricao").focus();
      }
      if (iTipoTransferencia == 5){
        if (($("txt_tipo_" + me.sNomeInstancia).value != 07 && $("txt_tipo_" + me.sNomeInstancia).value != 10) && $("txt_tipo_" + me.sNomeInstancia).value != 08){
          
          me.oTxtFonteInputCodigo.setValue(sCodfonte);
            me.oTxtFonteInputCodigo.setReadOnly(true);
            me.pesquisaFonte(false)
        }  
      }  
      if (lErro) {
        me.oTxtContaDebitoCodigo.setValue("");
        $(me.oTxtContaDebitoCodigo.sName).focus();
      }

    };

    me.completaCredito = function(iReduzido, sDescricao, iTipo, iSubtipo,iTipoconta,iCodfonte) {

      me.oTxtContaCreditoCodigo.setValue(iReduzido);
      me.oTxtContaCreditoDescricao.setValue(sDescricao);
      me.bTemExercicioDevolucaoCredito = me.bTipoDevolucao(iTipo, iSubtipo);
      if (iTipoTransferencia == 5){
        if (($("txt_tipo_" + me.sNomeInstancia).value == 07 || $("txt_tipo_" + me.sNomeInstancia).value == 10) && $("txt_tipo_" + me.sNomeInstancia).value != 08){
          me.oTxtFonteInputCodigo.setValue(iCodfonte);
          me.oTxtFonteInputCodigo.setReadOnly(true);
          me.pesquisaFonte(false)   
        }
      }  
      me.mostrarExercicioDevolucao();

      var sIframeConta = "db_iframe_" + me.sPesquisaContaCredito;
      var oIframe      = eval(sIframeConta);

      me.verificaRecursoContaCredito();
      oIframe.hide();
    };

    me.preencheCredito = function(sDescricao,iFonte,iReduzido, lErro) {

      me.oTxtContaCreditoDescricao.setValue(sDescricao);
      if (iTipoTransferencia == 5){
        if (($("txt_tipo_" + me.sNomeInstancia).value == 07 || $("txt_tipo_" + me.sNomeInstancia).value == 10) && $("txt_tipo_" + me.sNomeInstancia).value != 08){
          me.oTxtFonteInputCodigo.setValue(iFonte);
          me.oTxtFonteInputCodigo.setReadOnly(true);
          me.pesquisaFonte(false)
        }  
      }  
      if (lErro) {
        me.oTxtContaCreditoCodigo.setValue("");
        $(me.oTxtContaCreditoCodigo.sName).focus();
      }

      me.verificaRecursoContaCredito();
    };

    me.buscaContasCredito = function()
    {
      let inputField  = 'oTxtContaCreditoDescricao';
      let inputCodigo = 'oTxtContaCreditoCodigo';
      let ulField     = 'resultcredito';
      me.buscaContas(inputField,inputCodigo,ulField,me.oTxtContaCreditoDescricao.getValue(),1); 

    }
    me.buscaContasDebito = function()
    {
      let inputField  = 'oTxtContaDebitoDescricao';
      let inputCodigo = 'oTxtContaDebitoCodigo';
      let ulField     = 'resultdebito';
      me.buscaContas(inputField,inputCodigo,ulField,me.oTxtContaDebitoDescricao.getValue(),2); 
    }
    me.buscaHistorico = function()
    {
      let inputField  = 'oTxtHistoricoInputDescricao';
      let inputCodigo = 'oTxtHistoricoInputCodigo';
      let ulField     = 'resulthistorico';
      me.buscaHistoricoAutoComplete(inputField,inputCodigo,ulField,me.oTxtHistoricoInputDescricao.getValue()); 
    }
    me.buscaFavorecido = function()
    {
      let inputField  = 'oTxtFavorecidoInputDescricao';
      let inputCodigo = 'oTxtFavorecidoInputCodigo';
      let ulField     = 'resultfavorecido';
      me.buscaFavorecidoAutoComplete(inputField,inputCodigo,ulField,me.oTxtFavorecidoInputDescricao.getValue()); 
    }
    me.buscaContas = function(inputField,inputCodigo,ulField,descricao,tipoconta)
    {    
        var oParam    = new Object();
        
        if (me.iTipoInclusao == 5){
          oParam.exec   = "verificaContasParaAutoComplete";
        } 
        else if ((me.iTipoInclusao == 13 && tipoconta == 2) || 
                 (me.iTipoInclusao == 11 && tipoconta == 1) || 
                 (me.iTipoInclusao == 17 && tipoconta == 1) || 
                 (me.iTipoInclusao == 15 && tipoconta == 2) || 
                 (me.iTipoInclusao == 7  && tipoconta == 1) ||
                 (me.iTipoInclusao == 9  && tipoconta == 2) ||
                 (me.iTipoInclusao == 1  && tipoconta == 2)
                 ){
          oParam.exec   = "verificaContaEventoContabil";
        }  
        else {
          oParam.exec   = "verificaContaGeral";
        }
        
        oParam.iDescricao  = descricao;
        oParam.inputField  = inputField;
        oParam.inputCodigo = inputCodigo;
        oParam.ulField     = ulField;
        oParam.tipodaconta = me.tipocontadebito;
        oParam.tipoDebCred = tipoconta;
        oParam.iTipoInclusao = me.iTipoInclusao;
        oParam.tiposelecione = me.iTipoInclusao == 5 ? $("txt_tipo_" + me.sNomeInstancia).value : 0;

        if (descricao){
            me.oTxtContaCreditoCodigo.setReadOnly(false);
            me.oTxtContaCreditoDescricao.setReadOnly(false);
        }
       
        if (tipoconta == 1) {
            oParam.tipodaconta = me.tipocontacredito;
            oParam.codigoconta =  me.oTxtContaDebitoCodigo.getValue();
        }
       
        if(descricao.length == 3){
          js_divCarregando("Aguarde, verificando contas...", "msgBox");
        };  
          var oAjax = new Ajax.Request ( "con4_planoContas.RPC.php",
            {method: 'post',
            parameters: 'json='+Object.toJSON(oParam),
            onComplete: me.fillAutoComplete
            });
        
    };
    me.buscaFavorecidoAutoComplete = function(inputField,inputCodigo,ulField,descricao)
    {
      
        var oParam    = new Object();
        oParam.exec   = "verificaFavorecidoAutoComplete";
        oParam.iDescricao  = descricao;
        oParam.inputField  = inputField;
        oParam.inputCodigo = inputCodigo;
        oParam.ulField     = ulField;
        if(oParam.iDescricao.length == 5){
          js_divCarregando("Aguarde, verificando favorecido...", "msgBox");
        }  
        if(oParam.iDescricao.length > 4){
          let oAjax = new Ajax.Request ( "con4_planoContas.RPC.php",
            {method: 'post',
            parameters: 'json='+Object.toJSON(oParam),
            onComplete: me.fillAutoComplete
            });
        };         
    }; 
    me.buscaHistoricoAutoComplete = function(inputField,inputCodigo,ulField,descricao)
    {
        if (descricao) {
          var sValorCaracteres      = descricao;
          var sExpressaoCaracteres  = /^[A-Za-z0-9 -]+?$/i;
          var sRegExpCaracteres     = new RegExp(sExpressaoCaracteres);
          var lResultadoCaracteres  = sRegExpCaracteres.test(sValorCaracteres);
          if (!lResultadoCaracteres) {
            alert('São permitidas apenas letras, números e/ou caracter "_" (underline)');
            document.getElementById(inputField).value = '';
            return false;
          }
        } 
        var oParam    = new Object();
        oParam.exec   = "verificaHistoricoAutoComplete";
        oParam.iDescricao  = descricao;
        oParam.inputField  = inputField;
        oParam.inputCodigo = inputCodigo;
        oParam.ulField     = ulField;
        if(oParam.iDescricao.length == 3){
          js_divCarregando("Aguarde, verificando historicos...", "msgBox");
        };  
          let oAjax = new Ajax.Request ( "con4_planoContas.RPC.php",
            {method: 'post',
            parameters: 'json='+Object.toJSON(oParam),
            onComplete: me.fillAutoComplete
            });   
    }; 

    me.fillAutoComplete = function(oAjax)
    {    
      js_removeObj("msgBox");
     // Importe o arquivo JavaScript que contém o método performsAutoComplete
      require_once('scripts/classes/autocomplete/AutoComplete.js');  
      performsAutoComplete(oAjax);
      if (me.iTipoInclusao == 5) {
        me.fillAutoFields(oAjax);
      }
                 
    }
    me.fillAutoFields = function (oAjax) {

      var oRetorno = JSON.parse(oAjax.responseText);

      var tiposelect = $("txt_tipo_" + me.sNomeInstancia).value;
      
      window.setTimeout(
         function() {
          var oCodigoContaDebito  = document.getElementById("oTxtContaDebitoCodigo").value;
            if (oRetorno.inputField == 'oTxtContaDebitoDescricao' && oCodigoContaDebito ) {
        
              document.getElementById("oTxtContaCreditoDescricao").focus();
              const tipos = ['01', '02', '03', '04', '05', '06', '09'];
              if (tipos.includes(tiposelect)) {

                me.buscaFontes(oCodigoContaDebito)
                // me.pesquisaFonte(false)
                // me.pesquisaContaSaltes(false, false);
                // console.log(document.getElementById("oTxtFonteInputCodigo").value)
                // js_removeObj("msgBox");
              }
            }
        }, 2000
      ); 

      window.setTimeout(
        function() {
           var oCodigoContaCredito = document.getElementById("oTxtContaCreditoCodigo").value;
           if (oRetorno.inputField == 'oTxtContaCreditoDescricao' && oCodigoContaCredito) {
             document.getElementById("oTxtNumDocumentoInput").focus();
             const tipos = ['07', '10'];
             if (tipos.includes(tiposelect)) {
               me.pesquisaContaSaltes(false, false);
            }
           }
       
       }, 2000
     ); 
      
      if (tiposelect == 08) {
          me.oTxtFonteInputCodigo.setReadOnly(false);
      }
    
    };

    me.buscaFontes = function(codigo)
    {
        var oParam    = new Object();
        oParam.exec   = "buscarFontes";
        oParam.iCodigo = codigo;
        
        
        if (codigo){
          let oAjax = new Ajax.Request ( "con4_planoContas.RPC.php",
            {method: 'post',
            parameters: 'json='+Object.toJSON(oParam),
            onComplete: me.retornoFontes
            }); 
          }    
    }; 
    me.retornoFontes = function(oAjax)
    {

      var oRetorno = eval("("+oAjax.responseText+")");
      me.oTxtFonteInputCodigo.setValue(oRetorno.oFonte);
      me.oTxtFonteInputCodigo.setReadOnly(true);
      me.pesquisaFonte(false)
    }

    /**
     * Lookup de pesquisa do Historico
     */
    me.pesquisaHistorico = function (lMostra) {

      var sUrlHistorico = "func_conhist.php?pesquisa_chave="+me.oTxtHistoricoInputCodigo.getValue()+"&funcao_js=parent."+me.sNomeInstancia+".preencheHistorico";
      if (lMostra) {
        sUrlHistorico = "func_conhist.php?funcao_js=parent."+me.sNomeInstancia+".completaHistorico|c50_codhist|c50_descr|c50_descrcompl";
      }
      js_OpenJanelaIframe("", 'db_iframe_conhist', sUrlHistorico, "Pesquisa Histórico", lMostra);
    };

    /**
     * Preenche a descricao Historico
     */
    me.preencheHistorico = function (sDescricao,sHistorico, lErro) {

      me.oTxtHistoricoInputDescricao.setValue(sDescricao);
      if (sHistorico) {
        // me.oTxtObservacaoInput.setValue(sHistorico);
      }
      if (lErro) {
        me.oTxtHistoricoInputCodigo.setValue();
      }
    };

    /**
     * Completa os campos do Historico
     */
    me.completaHistorico = function (iCodigoHistorico, sDescricao, sHistorico) {

      me.oTxtHistoricoInputCodigo.setValue(iCodigoHistorico);
      me.oTxtHistoricoInputDescricao.setValue(sDescricao);
      me.oTxtObservacaoInput.setValue(sHistorico);
      db_iframe_conhist.hide();
    };

    /**
     * Abre lookup de pesquisa do CGM
     */
    me.pesquisaFavorecido = function(lMostra) {

      if (me.oTxtFavorecidoInputCodigo.getValue() == "") {

        me.oTxtFavorecidoInputCodigo.setValue('');
        me.oTxtFavorecidoInputDescricao.setValue('');
      }

      var sUrlFavorecido = "func_nome.php?pesquisa_chave="+me.oTxtFavorecidoInputCodigo.getValue()+"&funcao_js=parent."+me.sNomeInstancia+".preencheFavorecido";
      if (lMostra) {
        sUrlFavorecido = "func_nome.php?funcao_js=parent."+me.sNomeInstancia+".completaFavorecido|z01_numcgm|z01_nome|z01_cgccpf";
      }
      js_OpenJanelaIframe("", 'db_iframe_cgm', sUrlFavorecido, "Pesquisa Favorecido", lMostra);
    };


    /**
     * Preenche o favorecido da transferencia
     */
    me.preencheFavorecido = function (lErro, sNome, sCnpj) {

      if(sCnpj.length == 11){
        if(sCnpj == '00000000000'){
          alert("ERRO: Número do CPF está zerado. Corrija o CGM do fornecedor e tente novamente");
          return false
        }
      }else{
        if(sCnpj == '' || sCnpj == null ){
          alert("ERRO: Número do CPF está zerado. Corrija o CGM do fornecedor e tente novamente");
          return false
        }
      }

      if(sCnpj.length == 14){
        if(sCnpj == '00000000000000'){
          alert("ERRO: Número do CNPJ está zerado. Corrija o CGM do fornecedor e tente novamente");
          return false
        }
      }else{
        if(sCnpj == '' || sCnpj == null ){
          alert("ERRO: Número do CNPJ está zerado. Corrija o CGM do fornecedor e tente novamente");
          return false
        }
      }
      var sCnpjTratado = "";
      if (sCnpj != "" && sCnpj != undefined) {
        sCnpjTratado = js_formatar(sCnpj, 'cpfcnpj')+ " - ";
      }
      me.oTxtFavorecidoInputDescricao.setValue(sCnpjTratado+""+sNome);

      if (lErro) {
        me.oTxtFavorecidoInputCodigo.setValue('');
      }
    };

    /**
     * completa o favorecido da transferencia
     */
    me.completaFavorecido = function (iCodigoFavorecido, sNomeFavorecido, CNPJ) {

      if(CNPJ.length = 11){
        if(CNPJ == '00000000000'){
          alert("ERRO: Número do CPF está zerado. Corrija o CGM do fornecedor e tente novamente");
          return false
        }
      }

      if(CNPJ.length = 14){
        if(CNPJ == '00000000000000'){
          alert("ERRO: Número do CNPJ está zerado. Corrija o CGM do fornecedor e tente novamente");
          return false
        }
      }

      var sCnpjTratado = "";
      if (CNPJ != "") {
        sCnpjTratado = js_formatar(CNPJ, 'cpfcnpj')+ " - ";
      }
      me.oTxtFavorecidoInputCodigo.setValue(iCodigoFavorecido);
      me.oTxtFavorecidoInputDescricao.setValue(sCnpjTratado+""+sNomeFavorecido);
      db_iframe_cgm.hide();
    };


    /**
     * Lookup de pesquisa da Caracteristica Peculiar
     */
    me.pesquisaCaracteristicaPeculiarDebito = function(lMostra) {

      var sUrlCaracteristica = "func_concarpeculiar.php?pesquisa_chave="+me.oTxtCaracteristicaDebitoInputCodigo.getValue()+"&funcao_js=parent."+me.sNomeInstancia+".preencheCaracteristicaDebito";
      if (lMostra) {
        sUrlCaracteristica = "func_concarpeculiar.php?funcao_js=parent."+me.sNomeInstancia+".completaCaracteristicaDebito|c58_sequencial|c58_descr";
      }
      js_OpenJanelaIframe("", 'db_iframe_concarpeculiardebito', sUrlCaracteristica, "Pesquisa Característica Peculiar - Conta Débito", lMostra);
    };

    /**
     * Preenche a caracteristica peculiar
     */
    me.preencheCaracteristicaDebito = function (sDescricao, lErro) {

      me.oTxtCaracteristicaDebitoInputDescricao.setValue(sDescricao);
      if (lErro) {
        me.oTxtCaracteristicaDebitoInputCodigo.setValue('');
      }
    };

    /**
     * Completa os dados da caracteristica peculiar
     */
    me.completaCaracteristicaDebito = function(iCodigo, sDescricao) {

      me.oTxtCaracteristicaDebitoInputCodigo.setValue(iCodigo);
      me.oTxtCaracteristicaDebitoInputDescricao.setValue(sDescricao);
      db_iframe_concarpeculiardebito.hide();
    };

    /**
     * Lookup de pesquisa da Caracteristica Peculiar Credito
     */
    me.pesquisaCaracteristicaPeculiarCredito = function(lMostra) {

      var sUrlCaracteristicaCredito = "func_concarpeculiar.php?pesquisa_chave="+me.oTxtCaracteristicaCreditoInputCodigo.getValue()+"" +
                                          "&funcao_js=parent."+me.sNomeInstancia+".preencheCaracteristicaCredito";
      if (lMostra) {
        sUrlCaracteristicaCredito = "func_concarpeculiar.php?funcao_js=parent."+me.sNomeInstancia+".completaCaracteristicaCredito|c58_sequencial|c58_descr";
      }
      js_OpenJanelaIframe("", 'db_iframe_concarpeculiarcredito', sUrlCaracteristicaCredito, "Pesquisa Característica Peculiar - Conta Crédito", lMostra);
    };

    /**
     * Preenche a caracteristica peculiar da conta credito
     */
    me.preencheCaracteristicaCredito = function (sDescricao, lErro) {

      me.oTxtCaracteristicaCreditoInputDescricao.setValue(sDescricao);
      if (lErro) {
        me.oTxtCaracteristicaCreditoInputCodigo.setValue('');
      }
    };

    /**
     * Completa a caracteristica peculiar da conta credito
     */
    me.completaCaracteristicaCredito = function(iCodigo, sDescricao) {

      me.oTxtCaracteristicaCreditoInputCodigo.setValue(iCodigo);
      me.oTxtCaracteristicaCreditoInputDescricao.setValue(sDescricao);
      db_iframe_concarpeculiarcredito.hide();
    };

    /**
     * Funcoes de Pesquisa da Instituicao de Destino
     */
    me.pesquisaInstituicaoDestino = function (lMostra) {

      var sUrlDestino = "func_db_config.php?lDiminuirCampos=true&pesquisa_chave="+me.oTxtInstituicaoDestinoCodigo.getValue()+"" +
                            "&funcao_js=parent."+me.sNomeInstancia+".preencheInstituicaoDestino";
      if (lMostra) {
        sUrlDestino = "func_db_config.php?lDiminuirCampos=true&funcao_js=parent."+me.sNomeInstancia+".completaInstituicaoDestino|codigo|nomeinst";
      }
      js_OpenJanelaIframe("", 'db_iframe_db_config', sUrlDestino, "Pesquisa Instituição Destino", lMostra);
    };

    /**
     * Preenche pesquisa da instituicao destino
     */
    me.preencheInstituicaoDestino = function (sDescricao, lErro) {

      if (!me.validarInstituicao()) {
        return false;
      }

      me.oTxtDescricaoInstituicaoDestino.setValue(sDescricao);
      if (lErro) {
        me.oTxtInstituicaoDestinoCodigo.setValue('');
      }
    };

    /**
     * Completa a pesquisa da instituicao destino
     */
    me.completaInstituicaoDestino = function (iCodigoInstituicao, sNomeInstituicao) {

      me.oTxtInstituicaoDestinoCodigo.setValue(iCodigoInstituicao);
      me.oTxtDescricaoInstituicaoDestino.setValue(sNomeInstituicao);
      if (!me.validarInstituicao()) {
        return false;
      }
      db_iframe_db_config.hide();
    };

    /**
     * Valida se a instituicao de destino é a mesma de origem
     * @return boolean
     */
    me.validarInstituicao = function() {

      if (me.oTxtInstituicaoDestinoCodigo.getValue() == me.oTxtInstituicaoOrigemCodigo.getValue()) {

        alert("Instituição de destino igual a instituição de origem. Verifique!");
        me.oTxtInstituicaoDestinoCodigo.setValue('');
        me.oTxtDescricaoInstituicaoDestino.setValue('');
        return false;
      }
      return true;
    };

    /**
     * Lookup de pesquisa do codigo do slip
     */
    me.pesquisaCodigoSlip = function (lMostra) {

      var sUrlSlip = "func_sliptipovinculo.php?iTipoOperacao="+me.iTipoInclusao+"&funcao_js=parent."+me.sNomeInstancia+".preencheSlip|k17_codigo";
      js_OpenJanelaIframe("", 'db_iframe_slip', sUrlSlip, "Pesquisa Slip", lMostra);
    };

    /**
     * Preenche o código do slip e carrega as informacoes
     */
    me.preencheSlip = function (iCodigoSlip) {

      me.oTxtCodigoSlip.setValue(iCodigoSlip);
      db_iframe_slip.hide();
      me.getDadosTransferencia();
    };

    me.pesquisaFonte = function (lMostra) {
      var sUrlHistorico = "func_orctiporec.php?pesquisa_chave="+me.oTxtFonteInputCodigo.getValue()+"&funcao_js=parent."+me.sNomeInstancia+".preencheFonte";

      if (lMostra) {
          sUrlHistorico = "func_orctiporec.php?funcao_js=parent."+me.sNomeInstancia+".completaFonte|o15_codigo|o15_descr";
      }
      js_OpenJanelaIframe("", 'db_iframe_fonte', sUrlHistorico, "Pesquisa Histórico", lMostra);
  };

  me.completaFonte = function (iCodigoFonte, sDescricao) {
      me.oTxtFonteInputCodigo.setValue(iCodigoFonte);
      me.oTxtFonteInputDescricao.setValue(sDescricao);
      db_iframe_fonte.hide();
  };

  me.preencheFonte = function (chave, erro) {
      me.oTxtFonteInputDescricao.setValue(chave);
      if (!me.oTxtContaDebitoCodigo.getValue()) {
        me.oTxtFonteInputCodigo.setValue('');
        me.oTxtFonteInputDescricao.setValue('');
      }
      if (erro==true) {
          me.oTxtFonteInputCodigo.focus();
          me.oTxtFonteInputCodigo.value = '';
      }
  };

    /**
     * Busca os dados da instituicao de origem
     */
    me.getDadosInstituicaoOrigem = function (){

     js_divCarregando("Aguarde, carregando dados instituição...", "msgBox");
     var oParam = new Object();
     oParam.exec = "getDadosInstituicaoOrigem";
     new Ajax.Request ( me.sUrlRpc,
                      {
                      method: 'post',
                      parameters: 'json='+Object.toJSON(oParam),
                      async: false,
                      onComplete: function(oAjax){

                        js_removeObj("msgBox");
                        var oRetorno = eval("("+oAjax.responseText+")");

                        me.oTxtDescricaoInstituicaoOrigem.setValue(oRetorno.sInstituicaoOrigem.urlDecode());
                        me.oTxtInstituicaoOrigemCodigo.setValue(oRetorno.iCodigoInstituicaoOrigem);

                      }
                      });
    };

    /**
     * Busca os dados da transferencia financeira
     */
    me.getDadosTransferencia = function() {

      js_divCarregando("Aguarde, carregando dados da transferência...", "msgBox");
      var oParam                 = new Object();
      oParam.exec                = "getDadosTransferencia";
      oParam.k17_codigo          = me.oTxtCodigoSlip.getValue();
      oParam.iCodigoTipoOperacao = me.iTipoTransferencia;
      new Ajax.Request ( me.sUrlRpc,
                        {method: 'post',
                         parameters: 'json='+Object.toJSON(oParam),
                         onComplete: me.preencheDadosTransferencia
                        });
    };

    /**
     * Preenche os dados da transferencia com o retorno do ajax
     */
    me.preencheDadosTransferencia = function (oAjax) {

      js_removeObj("msgBox");
      var oRetorno = eval("("+oAjax.responseText+")");

      me.oTxtContaCreditoCodigo.setValue(oRetorno.iContaCredito);
      me.oTxtContaDebitoCodigo.setValue(oRetorno.iContaDebito);

      var sFunctionPesquisa = "me.pesquisaConta";

      window.setTimeout(
        function() {
          var oFunctionDebito =  eval(sFunctionPesquisa + me.sPesquisaContaDebito);
          oFunctionDebito(false, false, true,);
        }, 700
      );
      window.setTimeout(
        function() {
          var oFunctionCredito = eval(sFunctionPesquisa + me.sPesquisaContaCredito);
          oFunctionCredito(false, true, true);
        }, 400
      );

      if (!me.lImportacao && !me.alteracaoSlip()) {
        me.setAllFieldsReadOnly();
      } else if (me.lImportacao) {
        me.oTxtCodigoSlip.setValue('');
      }

      me.oTxtInstituicaoOrigemCodigo.setValue(oRetorno.iInstituicaoOrigem);
      me.oTxtDescricaoInstituicaoOrigem.setValue(oRetorno.sDescricaoInstituicaoOrigem.urlDecode());

      if (me.iTipoTransferencia == 1) {
        me.oTxtInstituicaoDestinoCodigo.setValue(oRetorno.iInstituicaoDestino);
      }

      me.oTxtFavorecidoInputCodigo.setValue(oRetorno.iCodigoCgm);
      me.oTxtFavorecidoInputDescricao.setValue(oRetorno.sCNPJ+" - "+oRetorno.sNomeCgm.urlDecode());
      me.oTxtCaracteristicaDebitoInputCodigo.setValue(oRetorno.sCaracteristicaDebito);
      me.oTxtCaracteristicaCreditoInputCodigo.setValue(oRetorno.sCaracteristicaCredito);
      me.oTxtHistoricoInputCodigo.setValue(oRetorno.iHistorico);
      me.oTxtFonteInputCodigo.setValue(oRetorno.iCodigoFonte);
      me.oTxtValorInput.setValue(oRetorno.nValor);
      me.oTxtDataInput.setValue(oRetorno.iData);
      me.oTxtNumDocumentoInput.setValue(oRetorno.iNumeroDocumento);
      document.getElementById("txt_tipo_" + me.sNomeInstancia).value =  oRetorno.iTipoSelect;
      me.oTxtProcessoInput.setValue(oRetorno.k145_numeroprocesso);

        if (oRetorno.iDevolucao)  {
            var oTabela = document.getElementById("table_oDBViewSlipPagamento");
            oTabela.rows[me.iLinhaExercicioDevolucao].hidden = false;
        }
      me.oTxtExercicioCompetenciaDevolucaoInput.setValue(oRetorno.iDevolucao);
      me.setObservacao(oRetorno.sObservacao.urlDecode());
      me.pesquisaInstituicaoDestino(false);
      me.pesquisaHistorico(false);
      me.pesquisaCaracteristicaPeculiarDebito(false);
      me.pesquisaCaracteristicaPeculiarCredito(false);
         me.pesquisaFonte(false);
    };


    /**
     * Seta todos os campos do formulario como ReadOnly
     */
    me.setAllFieldsReadOnly = function() {

      me.oTxtCodigoSlip.setReadOnly(true);
      me.oTxtInstituicaoOrigemCodigo.setReadOnly(true);
      me.oTxtDescricaoInstituicaoOrigem.setReadOnly(true);
      me.oTxtInstituicaoDestinoCodigo.setReadOnly(true);
      me.oTxtDescricaoInstituicaoDestino.setReadOnly(true);
      me.oTxtFavorecidoInputCodigo.setReadOnly(true);
      me.oTxtFavorecidoInputDescricao.setReadOnly(true);
      me.oTxtCaracteristicaDebitoInputCodigo.setReadOnly(true);
      me.oTxtCaracteristicaDebitoInputDescricao.setReadOnly(true);
      me.oTxtCaracteristicaCreditoInputCodigo.setReadOnly(true);
      me.oTxtCaracteristicaCreditoInputDescricao.setReadOnly(true);

      document.getElementById("labelContaDebito").innerHTML  = "<b>Conta Débito: </b>";
      document.getElementById("labelContaCredito").innerHTML = "<b>Conta Crédito: </b>";
      me.oTxtContaCreditoCodigo.setReadOnly(true);
      me.oTxtContaCreditoDescricao.setReadOnly(true);
      me.oTxtContaDebitoCodigo.setReadOnly(true);
      me.oTxtContaDebitoDescricao.setReadOnly(true);
      me.oTxtExercicioCompetenciaDevolucaoInput.setReadOnly(true);
      me.oTxtHistoricoInputCodigo.setReadOnly(true);
      me.oTxtHistoricoInputDescricao.setReadOnly(true);
      me.oTxtNumDocumentoInput.setReadOnly(true);
      me.oTxtValorInput.setReadOnly(true);
      me.oTxtDataInput.setReadOnly(true);
      me.setObservacaoReadOnly(true);


      $("td_cpca_contacredito_"+me.sNomeInstancia).innerHTML  = "<b>C.Peculiar / C.Aplicação:</b>";
      $("td_cpca_contadebito_"+me.sNomeInstancia).innerHTML   = "<b>C.Peculiar / C.Aplicação:</b>";
      $("td_instituicaodestino_"+me.sNomeInstancia).innerHTML = "<b>Instituição Destino:</b>";
      $("td_historico_"+me.sNomeInstancia).innerHTML          = "<b>Histórico:</b>";
    };

    /**
     * Limpa todos os campos do formulario
     */
    me.clearAllFields = function() {

      me.oTxtCodigoSlip.setValue('');

      if (me.iTipoTransferencia <= 2) {

        me.oTxtInstituicaoDestinoCodigo.setValue('');
        me.oTxtDescricaoInstituicaoDestino.setValue('');
      }

      me.oTxtFavorecidoInputCodigo.setValue('');
      me.oTxtFavorecidoInputDescricao.setValue('');

      me.oTxtExercicioCompetenciaDevolucaoInput.setValue('');

      /**
       * Trazer preenchido característica peculiar 000 por padrão
       */
      if (!me.alteracaoSlip()) {


        me.oTxtCaracteristicaDebitoInputCodigo.setValue("000");
        me.pesquisaCaracteristicaPeculiarDebito(false);
        me.oTxtCaracteristicaCreditoInputCodigo.setValue("000");
        me.pesquisaCaracteristicaPeculiarCredito(false);
      }
      
      me.oTxtDataInput.setValue('');
      me.oTxtValorInput.setValue('');
      me.oTxtNumDocumentoInput.setValue('');
      me.oTxtDataEstornoInput.getValue('');
      
    };


    /**
     * Retorna o conteudo do textarea observacao
     * @return string
     */
    me.getObservacao = function() {
      return me.oTxtObservacaoInput.value;
    };

    /**
     * Seta valor para o campo observacacao
     * @param {string}
     */
    me.setObservacao = function (sObservacao) {
      me.oTxtObservacaoInput.value = sObservacao;
    };

    /**
     * Seta o campo observacao como readonly
     */
    me.setObservacaoReadOnly = function (lDisable) {

      if (lDisable) {
        me.oTxtObservacaoInput.readOnly = true;
        me.oTxtObservacaoInput.style.backgroundColor = "#DEB887";
      } else {
        me.oTxtObservacaoInput.readOnly = false;
        me.oTxtObservacaoInput.style.backgroundColor = "#FFFFFF";
      }
      return true;
    };

    /**
     * Retorna uma string com o motivo da anulação do slip
     */
    me.getMotivoAnulacao = function() {
      return me.oTxtMotivoAnulacaoInput.value;
    };

    /**
     * Seta o codigo do Slip
     */
    me.setCodigoSlip = function (iCodigoSlip) {
      me.iCodigoSlip = iCodigoSlip;
    };

    /**
     * Retorna o código de um slip
     */
    me.getCodigoSlip = function () {
      return me.iCodigoSlip;
    };

      /**
       * Seta o ano da sessão
       */
      me.setAno = function (iAno) {
          me.iAno = iAno;
      }

    /**
     * Seta se o PCASP esta ativo
     */
    me.setPCASPAtivo = function (lPcaspAtivo) {

      if (lPcaspAtivo == "t") {
        me.lUsaPCASP = true;
      } else {
        me.lUsaPCASP = false;
      }
    };

    /**
     * Funcoes que so devem ser executadas após o componente estar montado na tela
     */
    me.start = function() {

      me.clearAllFields();
      me.getDadosInstituicaoOrigem();

      if (me.iOpcao == 2) {

        me.setAllFieldsReadOnly();
        me.pesquisaCodigoSlip(true);
      }

      if (me.lUsaPCASP === false) {

        alert("Para utilizar a rotina, o PCASP deve estar ativado.");
        me.oButtonEstornar.disabled = true;
        me.oButtonSalvar.disabled = true;
      }

      if(me.iInscricaoPassivo != null) {
        me.ajustaTelaBaixaPagamento();
      }
    };

    /**
     * Seta o Objeto como readonly
     */
    me.setReadOnly = function (lReadOnly) {
      me.lReadOnly = lReadOnly;
    };

    /**
     * Lookup de pesquisa para a finalidade de pagamento fundeb
     */
    me.pesquisaFinalidadeFundeb = function (lMostra) {

      var sUrlFundeb = "func_finalidadepagamentofundeb.php?funcao_js=parent."+me.sNomeInstancia+".preencheFinalidadeFundeb|e151_codigo|e151_descricao";

      if (!lMostra) {
        sUrlFundeb = "func_finalidadepagamentofundeb.php?funcao_js=parent."+me.sNomeInstancia+".completaFinalidadeFundeb&pesquisa_codigo="+me.oTxtCodigoFinalidadeFundeb.getValue();
      }
      js_OpenJanelaIframe("", 'db_iframe_finalidadepagamentofundeb', sUrlFundeb, "Pesquisa finalidade de pagamento do FUNDEB", lMostra);

    };

    /**
     * Preenche os inputs com os dados de código e descrição
     */
    me.preencheFinalidadeFundeb = function (sCodigo, sDescricao) {

      me.oTxtCodigoFinalidadeFundeb.setValue(sCodigo);
      me.oTxtDescricaoFinalidadeFundeb.setValue(sDescricao);
      db_iframe_finalidadepagamentofundeb.hide();
    };

    /**
     * Completa os inputs com a descrição encontrada
     */
    me.completaFinalidadeFundeb = function (sDescricao, lErro) {

      me.oTxtDescricaoFinalidadeFundeb.setValue(sDescricao);
      if (lErro) {
        me.oTxtCodigoFinalidadeFundeb.setValue('');
      }
    };

    /**
     * Função que valida o recurso da conta crédito
     */
    me.verificaRecursoContaCredito = function() {

      js_divCarregando("Aguarde, verificando recurso da conta...", "msgBox");

      var oParam    = new Object();
      oParam.exec   = "verificaRecursoContaReduzida";
      oParam.iConta = me.oTxtContaCreditoCodigo.getValue();

      new Ajax.Request ("con4_planoContas.RPC.php",
                        {method: 'post',
                         parameters: 'json='+Object.toJSON(oParam),
                         onComplete: function (oAjax) {

                           js_removeObj("msgBox");
                           var oRetorno = eval("("+oAjax.responseText+")");
                           if (oRetorno.lUtilizaFundeb) {

                             $('tr_finalidadepagamento_credito_'+me.sNomeInstancia).style.display = '';
                             me.lFinalidadeDePagamentoFundeb = true;
                           } else {

                             $('tr_finalidadepagamento_credito_'+me.sNomeInstancia).style.display = 'none';
                             me.lFinalidadeDePagamentoFundeb = false;
                           }

                         }
                        });

    };

    me.mostrarExercicioDevolucao = function() {
        if (me.iAno < 2022)
            return false;

        var oTabela = document.getElementById("table_oDBViewSlipPagamento");
        oTabela.rows[me.iLinhaExercicioDevolucao].hidden = true;
        if (me.temExercicioDevolucao())
            oTabela.rows[me.iLinhaExercicioDevolucao].hidden = false;
    }

    me.temExercicioDevolucao = function () {
        if (me.bTemExercicioDevolucaoDebito == 't' || me.bTemExercicioDevolucaoCredito == 't')
            return true;
        return false;
    }

    this.excluir = function() {

      js_divCarregando("Aguarde, excluindo transferência...", "msgBox");

      var oParam = {"exec":"excluirSlip", "iCodigoSlip":me.oTxtCodigoSlip.getValue()};

      new Ajax.Request (me.sUrlRpc,
                        {method: 'post',
                         async: false,
                         parameters: 'json='+Object.toJSON(oParam),
                         onComplete: function (oAjax) {

                           js_removeObj("msgBox");
                           var oRetorno = eval("("+oAjax.responseText+")");
                           alert(oRetorno.message.urlDecode());
                           js_pesquisaSlip(true);
                          }
                        });
    }

    /**
     * Define se é rotina de alteração de slip ou não
     * @param lAlteracaoSlip
     */
    this.setAlteracao = function (lAlteracaoSlip) {
      this.lAlteracao = lAlteracaoSlip;
    };

    /**
     * Retorna true ou false para alteração do slip
     * @returns {boolean|*}
     */
    this.alteracaoSlip = function () {
      return this.lAlteracao;
    };
    if (iTipoTransferencia == 5){
      window.onload = function() {
        document.getElementById("txt_tipo_" + me.sNomeInstancia).focus();
      }
    } 
    
    me.buscaCamposAtivos = function(codhist)
    {
        var oParam    = new Object();
        oParam.exec   = "buscarCamposAtivos";
        oParam.codhist = codhist;
        js_divCarregando("Aguarde, verificando Historico...", "msgBox");
        let oAjax = new Ajax.Request ( "con4_planoContas.RPC.php",
            {method: 'post',
            parameters: 'json='+Object.toJSON(oParam),
            onComplete: me.resultCampoAtivo
            });     
    }; 
    me.resultCampoAtivo = function (oAjax) {

      js_removeObj("msgBox");
      var oRetorno = eval("("+oAjax.responseText+")");
      me.oTxtHistoricoInputCodigo.setValue(oRetorno.sCodhist);
      var sUrlHistorico = "func_conhist.php?pesquisa_chave="+me.oTxtHistoricoInputCodigo.getValue()+"&funcao_js=parent."+me.sNomeInstancia+".preencheHistorico";
      js_OpenJanelaIframe("", 'db_iframe_conhist', sUrlHistorico, "Pesquisa Histórico", false);
   
   };

};

