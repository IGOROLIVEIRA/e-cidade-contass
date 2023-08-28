/**
 * Componente para o pagamento de um slip
 *
 * @author Bruno
 * @param sNomeInstancia     - Nome da Instancia que esta sendo utilizada
 * @param iTipoTransferencia - Codigo da transferencia (tabela: sliptipooperacao)
 * @param oDivDestino        - Objeto onde este objeto (DBViewSlipPagamento) sera adicionado
 */
DBViewSlipRecebimento = function(sNomeInstancia, iTipoTransferencia, oDivDestino, lEstorno, iAno = null) {

  var me                              = this;
  me.sNomeInstancia                   = sNomeInstancia;
  me.sTipoTransferencia               = "";
  me.iTipoTransferencia               = iTipoTransferencia;
  me.oDivDestino                      = oDivDestino;
  me.lEstorno                         = lEstorno;
  me.sUrlRpc                          = "cai4_transferencia.RPC.php";
  me.iCodigoSlip                      = null;
  me.iCodigoSlipRecebido              = null;
  me.oDivGeralGrid                    = null;
  me.oDivContainerCampos              = null;
  me.sParametroContaDebito            = "";
  me.sParametroContaCredito           = "";
  me.bTemExercicioDevolucaoDebito = false;
  me.bTemExercicioDevolucaoCredito = false;
  me.lContaDebito                     = false;
  me.lContaCredito                    = false;
  me.iAno = iAno;
  /**
   * Define o tipo de transferencia
   */
  switch (iTipoTransferencia) {

    case 3:
      me.lContaCredito          = true;
      me.sParametroContaCredito = "getContaEventoContabil";
      me.sParametroContaDebito  = "getContasSaltes";
      me.sTipoTransferencia     = "Recebimento de Transferência Financeira";

      me.sPesquisaContaCredito = "EventoContabil";
      me.sPesquisaContaDebito  = "Saltes";
    break;

    case 4:

      me.lContaCredito          = true;
      me.sParametroContaCredito = "getContaEventoContabil";
      me.sParametroContaDebito  = "getContasSaltes";
      me.sTipoTransferencia     = "Estorno de Transferência Financeira";

      me.sPesquisaContaCredito = "EventoContabil";
      me.sPesquisaContaDebito  = "Saltes";
    break;
  }

  /**
   * Código Slip
   */
  me.oTxtCodigoSlip = new DBTextField('oTxtCodigoSlip', me.sNomeInstancia+'.oTxtCodigoSlip', '', 8);
  me.oTxtCodigoSlip.setReadOnly(true);

  /**
   * Concessor
   */
  me.oTxtInstituicaoOrigemCodigo    = new DBTextField('oTxtInstituicaoOrigemCodigo', me.sNomeInstancia+'.oTxtInstituicaoOrigemCodigo', '', 8);
  me.oTxtInstituicaoOrigemCodigo.setReadOnly(true);
  me.oTxtDescricaoInstituicaoOrigem = new DBTextField('oTxtDescricaoInstituicaoOrigem', me.sNomeInstancia+'.oTxtDescricaoInstituicaoOrigem', '', 35);
  me.oTxtDescricaoInstituicaoOrigem.setReadOnly(true);
  me.oTxtCNPJInstituicaoOrigem       = new DBTextField('oTxtCNPJInstituicaoOrigem', me.sNomeInstancia+'.oTxtCNPJInstituicaoOrigem', '', 18);
  me.oTxtCNPJInstituicaoOrigem.setReadOnly(true);

  /**
   * Caracteristica Conta Credito
   */
  me.oTxtCaracteristicaDebitoInputCodigo     = new DBTextField('oTxtCaracteristicaDebitoInputCodigo', me.sNomeInstancia+'.oTxtCaracteristicaDebitoInputCodigo', '', 8);
  me.oTxtCaracteristicaDebitoInputDescricao  = new DBTextField('oTxtCaracteristicaDebitoInputDescricao', me.sNomeInstancia+'.oTxtCaracteristicaDebitoInputDescricao', '', 56);
  me.oTxtCaracteristicaDebitoInputCodigo.addEvent('onChange', ";"+me.sNomeInstancia+".pesquisaCaracteristicaPeculiarDebito(false);");

  /**
   * Caracteristica conta Débito
   */

  me.oTxtCaracteristicaCreditoInputCodigo    = new DBTextField('oTxtCaracteristicaCreditoInputCodigo', me.sNomeInstancia+'.oTxtCaracteristicaCreditoInputCodigo', '', 8);
  me.oTxtCaracteristicaCreditoInputDescricao = new DBTextField('oTxtCaracteristicaCreditoInputDescricao', me.sNomeInstancia+'.oTxtCaracteristicaCreditoInputDescricao', '', 56);
  me.oTxtCaracteristicaCreditoInputCodigo.addEvent('onChange', ";"+me.sNomeInstancia+".pesquisaCaracteristicaPeculiarCredito(false);");

  /**
   * Inputs para conta crédito e débito
   */
  me.oTxtContaCreditoCodigo = new DBTextField("oTxtContaCreditoCodigo",
                                              me.sNomeInstancia + ".oTxtContaCreditoCodigo",
                                              "",
                                              8
                                             );
  me.oTxtContaCreditoCodigo.addEvent("onChange", ";" + me.sNomeInstancia + ".pesquisaConta" + me.sPesquisaContaCredito + "(false, true);");

  me.oTxtContaCreditoDescricao               = new DBTextField("oTxtContaCreditoDescricao", me.sNomeInstancia + ".oTxtContaCreditoDescricao", "", 56);
  me.oTxtContaDebitoCodigo                   = new DBTextField("oTxtContaDebitoCodigo",     me.sNomeInstancia + ".oTxtContaDebitoCodigo",     "", 8);
  me.oTxtContaDebitoCodigo.addEvent("onChange", ";" + me.sNomeInstancia + ".pesquisaConta" + me.sPesquisaContaDebito + "(false, false);");
  me.oTxtContaDebitoDescricao                = new DBTextField("oTxtContaDebitoDescricao",  me.sNomeInstancia + ".oTxtContaDebitoDescricao",  "", 56);

  me.oTxtContaCreditodiv               = new DBTextField("oTxtContaCreditodiv", me.sNomeInstancia + ".oTxtContaCreditodiv",    "", 80);
  me.oTxtContaCreditodiv.addEvent("onKeyUp", ";" + me.sNomeInstancia + "");
  me.oTxtContaCreditoDescricao.addEvent("onKeyUp", ";" + me.sNomeInstancia + ".buscaContasCredito(this.value);");
  me.oTxtContaDebitoDescricao.addEvent("onKeyUp", ";" + me.sNomeInstancia + ".buscaContasDebito(this.value);");

  me.oTxtContaDebitodiv               = new DBTextField("oTxtContaDebitodiv", me.sNomeInstancia + ".oTxtContaDebitodiv",    "", 80);
  me.oTxtContaDebitodiv.addEvent("onKeyUp", ";" + me.sNomeInstancia + "");
  
    // Criando o campo Exercício da Competência da Devolução
    me.oTxtExercicioCompetenciaDevolucaoInput = new DBTextField('oTxtExercicioCompetenciaDevolucaoInput', me.sNomeInstancia+'.oTxtExercicioCompetenciaDevolucaoInput', '', me.iTamanhoCampo);
    me.oTxtExercicioCompetenciaDevolucaoInput.setMaxLength(4);
    me.oTxtExercicioCompetenciaDevolucaoInput.addEvent("onKeyPress", "return js_teclas(event, this)");

  /**
   * Histórico
   */

  me.oTxtHistoricoInputCodigo                = new DBTextField('oTxtHistoricoInputCodigo', me.sNomeInstancia+'.oTxtHistoricoInputCodigo', '', 8);
  me.oTxtHistoricoInputCodigo.addEvent('onChange', ";"+me.sNomeInstancia+".pesquisaHistorico(false);");
  me.oTxtHistoricoInputDescricao             = new DBTextField('oTxtHistoricoInputDescricao', me.sNomeInstancia+'.oTxtHistoricoInputDescricao', '', 56);

    me.oTxtFonteInputCodigo = new DBTextField('oTxtFonteInputCodigo', me.sNomeInstancia+'.oTxtFonteInputCodigo', '', 8);
    me.oTxtFonteInputCodigo.addEvent('onChange', ";"+me.sNomeInstancia+".pesquisaFonte(false);");
    me.oTxtFonteInputDescricao = new DBTextField('oTxtFonteInputDescricao', me.sNomeInstancia+'.oTxtFonteInputDescricao', '', 56);

    /**
   * Processo administrativo
   */
  me.oTxtProcessoInput                      = new DBTextField('oTxtProcessoInput', me.sNomeInstancia+'.oTxtProcessoInput', '', 8);
  me.oTxtProcessoInput.setMaxLength(15);
  //me.oTxtValorInput.addEvent("onKeyPress", "return js_mask(event,\"0-9|,|-\");");
  //me.oTxtValorInput.setReadOnly(true);

  me.oTxtNumDocumentoInput                       = new DBTextField('oTxtNumDocumentoInput', me.sNomeInstancia+'.oTxtNumDocumentoInput', '', 8);
  me.oTxtNumDocumentoInput.setMaxLength(15);

  /**
   * Valor
   */
  me.oTxtValorInput                          = new DBTextField('oTxtValorInput', me.sNomeInstancia+'.oTxtValorInput', '', 8);
  me.oTxtValorInput.addEvent("onKeyPress", "return js_mask(event,\"0-9|,|-\");");
  me.oTxtValorInput.setReadOnly(true);

  me.oTxtDataInput                          = new DBTextFieldData('oTxtDataInput', 'oTxtDataInput', null);

  /**
   * Text area das observações
   */
  me.oTxtObservacaoInput              = document.createElement('textarea');
  me.oTxtObservacaoInput.name         = "observacao_"+me.sNomeInstancia;
  me.oTxtObservacaoInput.id           = "observacao_"+me.sNomeInstancia;
  me.oTxtObservacaoInput.style.width  = "100%";
  me.oTxtObservacaoInput.style.height = "100px";


  /**
   * Text area das motivo (em caso de estorno)
   */
  me.oTxtMotivoInput              = document.createElement('textarea');
  me.oTxtMotivoInput.name         = "motivo_"+me.sNomeInstancia;
  me.oTxtMotivoInput.id           = "motivo_"+me.sNomeInstancia;
  me.oTxtMotivoInput.style.width  = "100%";
  me.oTxtMotivoInput.style.height = "100px";


  /**
   * Objeto Botao
   */
  me.oButtonSalvar                 = document.createElement('input');
  me.oButtonSalvar.type            = "button";
  me.oButtonSalvar.value           = "Salvar";
  me.oButtonSalvar.id              = "btnSalvar";
  me.oButtonSalvar.name            = "btnSalvar";
  me.oButtonSalvar.style.marginTop = "10px";


  /**
   * Monta o componente e apresenta no objeto passado por parametro
   */
  me.show = function () {

    var oFieldsetCampos         = document.createElement("fieldset");
    oFieldsetCampos.style.width = "670px";
    oFieldsetCampos.id          = "fieldset_campos";
    var oLegend                 = document.createElement("legend");
    oLegend.innerHTML           = "<b>"+me.sTipoTransferencia+"</b>";
    oFieldsetCampos.appendChild(oLegend);

    var oTabela         = document.createElement("table");
    oTabela.id          = "table_"+me.sNomeInstancia;
    oTabela.style.width = "100%";

    /**
     * Table Row - Codigo
     */
    var oRowCodigo               = oTabela.insertRow(0);
    var oCellCodigoLabel         = oRowCodigo.insertCell(0);

    oCellCodigoLabel.innerHTML   = "<b>Código:</b>";
    oCellCodigoLabel.style.width = "150px";
    var oCellCodigoInput         = oRowCodigo.insertCell(1);
    oCellCodigoInput.style.width = "50px";
    oCellCodigoInput.id          = "td_codigo_"+me.sNomeInstancia;
    me.oTxtCodigoSlip.setReadOnly(true);
    me.oTxtCodigoSlip.show(oCellCodigoInput);

    /**
     * Instituicao Origem  - Concessor
     */
    var oRowInstituicaoOrigem                = oTabela.insertRow(1);
    var oCellInstituicaoOrigemLabel          = oRowInstituicaoOrigem.insertCell(0);
    oCellInstituicaoOrigemLabel.innerHTML    = "<b>Concessor:</b>";
    var oCellInstituicaoOrigemInput          = oRowInstituicaoOrigem.insertCell(1);
    oCellInstituicaoOrigemInput.id           = "td_InstituicaoOrigem_"+me.sNomeInstancia;
    var oCellDescricaoInstituicaoOrigemInput = oRowInstituicaoOrigem.insertCell(2);
    oCellDescricaoInstituicaoOrigemInput.id  = "td_DescricaoInstituicaoOrigem_"+me.sNomeInstancia;

    me.oTxtInstituicaoOrigemCodigo.show(oCellInstituicaoOrigemInput);
    me.oTxtDescricaoInstituicaoOrigem.show(oCellDescricaoInstituicaoOrigemInput);

    //Concatena 2 inputs na mesma Cell
    oCellDescricaoInstituicaoOrigemInput.innerHTML += me.oTxtCNPJInstituicaoOrigem.toInnerHtml();

    /**
     * Label Conta Debito
     */
    var oRowContaDebito             = oTabela.insertRow(2);
    var oCellContaDebitoLabel       = oRowContaDebito.insertCell(0);
    //oCellContaDebitoLabel.innerHTML = "<b>Conta Débito:</b>";
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
    var oRowContaDebitodiv = oTabela.insertRow(3);
    var oCellContaDebitodiv = oRowContaDebitodiv.insertCell(0);
    oCellContaDebitodiv = oRowContaDebitodiv.insertCell(1);
    oCellContaDebitodiv = oRowContaDebitodiv.insertCell(2);
    oCellContaDebitodiv.colSpan  = "8";
    oCellContaDebitodiv.id  = "resultdebito";
    oCellContaDebitodiv.setAttribute("hidden","hidden");

    /**
     * Label Caracteristica Peculiar
     */
    var oRowCaracteristica                   = oTabela.insertRow(4);
    var oCellCaracteristicaDebitoLabel       = oRowCaracteristica.insertCell(0);
    oCellCaracteristicaDebitoLabel.id        = 'td_caracteristicapeculiar_'+me.sNomeInstancia;
    oCellCaracteristicaDebitoLabel.innerHTML = "<b><a href='#' onclick='"+me.sNomeInstancia+".pesquisaCaracteristicaPeculiarDebito(true);'>C.Peculiar / C.Aplicação:</a></b>";
    oCellCaracteristicaDebitoLabel.setAttribute("hidden","hidden");
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
    var oRowContaCredito             = oTabela.insertRow(5);
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
   var oRowContaCreditodiv = oTabela.insertRow(6); 
   var oCellContaCreditodiv = oRowContaCreditodiv.insertCell(0);
   oCellContaCreditodiv = oRowContaCreditodiv.insertCell(1);
   oCellContaCreditodiv = oRowContaCreditodiv.insertCell(2);
   oCellContaCreditodiv.colSpan  = "8";
   oCellContaCreditodiv.id  = "resultcredito";
   oCellContaCreditodiv.setAttribute("hidden","hidden");  


    /**
     * Caracteristica peculiar conta credito
     */
    var oRowCaracteristicaContaCredito        = oTabela.insertRow(7);
    var oCellCaracteristicaCreditoLabel       = oRowCaracteristicaContaCredito.insertCell(0);
    oCellCaracteristicaCreditoLabel.id         = 'td_caracteristicapeculiar_credito_'+me.sNomeInstancia;
    oCellCaracteristicaCreditoLabel.innerHTML = "<b><a href='#' onclick='"+me.sNomeInstancia+".pesquisaCaracteristicaPeculiarCredito(true);'>C.Peculiar / C.Aplicação:</a></b>";
    oCellCaracteristicaCreditoLabel.setAttribute("hidden","hidden");
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
     * Label Historico
     */
    var oRowHistorico             = oTabela.insertRow(8);
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
    me.oTxtHistoricoInputDescricao.setReadOnly(true);
    me.oTxtHistoricoInputDescricao.show(oCellHistoricoInputDescricao);

        /**
        * Label Fonte
        */
        if (me.iAno >= 2022) {
            var oRowFonte             = oTabela.insertRow(9);
            var oCellFonteLabel       = oRowFonte.insertCell(0);
            oCellFonteLabel.id        = "td_fonte_"+me.sNomeInstancia;
            oCellFonteLabel.innerHTML = "<b><a href='#' onclick='"+me.sNomeInstancia+".pesquisaFonte(true);'>Fonte de Recursos:</a></b>";
        }

        /**
         * Codigo Fonte
         */
        if (me.iAno >= 2022) {
            var oCellFonteInputCodigo = oRowFonte.insertCell(1);
            me.oTxtFonteInputCodigo.show(oCellFonteInputCodigo);
        }

        /**
         * Descricao Fonte
         */
        if (me.iAno >= 2022) {
            var oCellFonteInputDescricao = oRowFonte.insertCell(2);
            me.oTxtFonteInputDescricao.setReadOnly(true);
            me.oTxtFonteInputDescricao.show(oCellFonteInputDescricao);
        }

        /**
         * Label Exercício da Competência da Devolução
        */
        me.iLinhaExercicioDevolucao = 9;
        if (me.iAno >= 2022)
            me.iLinhaExercicioDevolucao = 10;

         var oRowExercicioCompetenciaDevolucao = oTabela.insertRow(me.iLinhaExercicioDevolucao);
         var oCelloRowExercicioCompetenciaDevolucaoLabel = oRowExercicioCompetenciaDevolucao.insertCell(0);
         oCelloRowExercicioCompetenciaDevolucaoLabel.innerHTML = "<strong>Exercício da Competência da Devolução:</strong>";

         var oCellExercicioCompetenciaDevolucaoInput = oRowExercicioCompetenciaDevolucao.insertCell(1);
         oCellExercicioCompetenciaDevolucaoInput.colSpan = "2";

         me.oTxtExercicioCompetenciaDevolucaoInput.show(oCellExercicioCompetenciaDevolucaoInput);
         oTabela.rows[me.iLinhaExercicioDevolucao].hidden = true;

    /**
     * Label Processo
     */
    if (me.iAno >= 2022)
        var oRowProcesso = oTabela.insertRow(11);
    else
        var oRowProcesso = oTabela.insertRow(10);
    var oCellProcessoLabel           = oRowProcesso.insertCell(0);
        oCellProcessoLabel.innerHTML = "<strong>Processo Administrativo:</strong>";

    var oCellProcessoInput         = oRowProcesso.insertCell(1);
        oCellProcessoInput.colSpan = "2";
    me.oTxtProcessoInput.show(oCellProcessoInput);

    
    /**
    * Label Número do Documento
    */
    var oRowNumDocumento                 = oTabela.insertRow(12); 
    var oCellNumDocumentoLabel           = oRowNumDocumento.insertCell(0);
        oCellNumDocumentoLabel.innerHTML = "<strong>Número do Documento:</strong>";
      
    var oCellNumDocumentoInput           = oRowNumDocumento.insertCell(1);
        oCellNumDocumentoInput.colSpan   = "2";
        me.oTxtNumDocumentoInput.show(oCellNumDocumentoInput);
       
     
    /**
     * Label Valor
     */
    if (me.iAno >= 2022)
        var oRowValor = oTabela.insertRow(13);
    else
        var oRowValor = oTabela.insertRow(14);

    var oCellValorLabel       = oRowValor.insertCell(0);
    oCellValorLabel.innerHTML = "<b>Valor:</b>";

    var oCellValorInput       = oRowValor.insertCell(1);
    oCellValorInput.colSpan   = "2";
    me.oTxtValorInput.show(oCellValorInput);

   /**
   * Label Data
   */
    var oRowData             = oTabela.insertRow(14); 
    var oCellDataLabel       = oRowData.insertCell(0);
    oCellDataLabel.innerHTML = "<b>Data:</b>";
       
    var oCellDataInput       = oRowData.insertCell(1);
    oCellDataInput.colSpan   = "2";
    oCellDataInput.id        = "td_data_"+me.sNomeInstancia;
    me.oTxtDataInput.show(oCellDataInput);

    /**
     * Fieldset Observacao
     */
    var oFieldsetObservacao       = document.createElement('fieldset');
    var oLegendObservacao         = document.createElement('legend');
    oLegendObservacao.innerHTML   = "<b>Descrição do Histórico:</b>";   
    oFieldsetObservacao.appendChild(oLegendObservacao);
    oFieldsetObservacao.appendChild(me.oTxtObservacaoInput);


    /**
     * Fieldset Motivo
     */
    if (me.lEstorno) {

      var oFieldsetMotivo       = document.createElement('fieldset');
      var oLegendMotivo         = document.createElement('legend');
      oLegendMotivo.innerHTML   = "<b>Motivo Estorno</b>";
      oFieldsetMotivo.appendChild(oLegendMotivo);
      oFieldsetMotivo.appendChild(me.oTxtMotivoInput);
    }

    me.oDivContainerCampos    = document.createElement("div");
    me.oDivContainerCampos.id = "divContainerCampos_"+me.sNomeInstancia;
    oFieldsetCampos.appendChild(oTabela);
    oFieldsetCampos.appendChild(oFieldsetObservacao);

    /**
     * Adiciona o campo motivo caso seja tela de estorno de recebimento
     */
    if (me.lEstorno) {
      oFieldsetCampos.appendChild(oFieldsetMotivo);
    }

    me.oDivContainerCampos.appendChild(oFieldsetCampos);
    me.oDivContainerCampos.appendChild(me.oButtonSalvar);

    /**
     * Executamos o APPEND ao objeto destino
     */
    if (me.iCodigoSlipRecebido == null) {
      me.oDivContainerCampos.style.display = 'none';
    }
    me.oDivDestino.appendChild(me.oDivContainerCampos);
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
   * Método que executa RPC para salvar recebimento
   */
  me.oButtonSalvar.observe('click', function() {

    if (!me.validarContaCreditoDebito()) {
      return false;
    }

    if (me.oTxtHistoricoInputCodigo.getValue() == "") {

      alert("Campo Histórico é obrigatório.");
      return false;
    }

          
    if (me.oTxtDataInput.getValue() == "") {

      alert("Informe a Data.");
      return false;
    }

    if (me.getObservacao() == "") {

      alert("Campo descrição do histórico é obrigatório.");
      return false;
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
           return false;
        }
    }

    js_divCarregando("Aguarde, salvando dados do recebimento da transferência...", "msgBox");
    var oParam                            = new Object();
    oParam.exec                           = "receberSlip";
    oParam.iCodigoSlipRecebido            = me.iCodigoSlipRecebido;
    oParam.iCodigoTipoOperacao            = me.iTipoTransferencia;
    oParam.iCodigoInstituicaoOrigem       = me.oTxtInstituicaoOrigemCodigo.getValue();
    oParam.k17_debito                     = me.oTxtContaDebitoCodigo.getValue();
    oParam.sCaracteristicaPeculiarDebito  = me.oTxtCaracteristicaDebitoInputCodigo.getValue();
    oParam.k17_credito                    = me.oTxtContaCreditoCodigo.getValue();
    oParam.sCaracteristicaPeculiarCredito = me.oTxtCaracteristicaCreditoInputCodigo.getValue();
    oParam.k17_hist                       = me.oTxtHistoricoInputCodigo.getValue();
    oParam.k17_valor                      = me.oTxtValorInput.getValue();
    oParam.k17_texto                      = encodeURIComponent(me.getObservacao());
    oParam.k17_numdocumento               = encodeURIComponent(tagString(me.oTxtNumDocumentoInput.getValue())) ;
    oParam.k17_data                       = me.oTxtDataInput.getValue();
    oParam.k145_numeroprocesso            = encodeURIComponent(tagString(me.oTxtProcessoInput.getValue())) ;
    if (me.iAno >= 2022)
        oParam.iCodigoFonte = me.oTxtFonteInputCodigo.getValue();
    oParam.lEstorno                       = me.lEstorno;


    /**
     * Caso seja um estorno de recebimento
     */
    if (me.lEstorno) {

      oParam.exec          = "anularSlip";
      oParam.sMotivo       = encodeURIComponent(me.oTxtMotivoInput.value);
      oParam.k17_codigo    = me.oTxtCodigoSlip.getValue();
      oParam.iDataEstorno  = me.oTxtDataInput.getValue(); 
    }

    new Ajax.Request(me.sUrlRpc,
                    {method: 'post',
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


      var iCodigoSlip = oRetorno.iCodigoSlip;

      if (me.lEstorno) {
        iCodigoSlip = me.oTxtCodigoSlip.getValue();
      }
      if (confirm(oRetorno.message.urlDecode()+" Deseja emitir o documento?")) {
        window.open('cai1_slip003.php?&numslip='+iCodigoSlip, '', 'location=0');
      }

      me.clearAllFields();
      me.oDivContainerCampos.style.display = 'none';
      me.oDivGeralGrid.style.display       = '';
      me.pesquisaTranferenciaRecebimento();
    } else {
      alert(oRetorno.message.urlDecode());
    }
  };


  /**
   * Executa o AJAX para buscar as contas de debito disponíveis
   */
  me.getContasDebito = function() {

    js_divCarregando("Aguarde, buscando contas debito..", "msgBox");

    var oParam                = new Object();
    oParam.exec               = me.sParametroContaDebito;
    oParam.lContaCredito      = me.lContaCredito;
    oParam.lContaDebito       = me.lContaDebito;
    oParam.iTipoTransferencia = me.iTipoTransferencia;

    var oAjax = new Ajax.Request ( me.sUrlRpc,
                                  {
                                  method: 'post',
                                  parameters: 'json='+Object.toJSON(oParam),
                                  onComplete: function(oAjax){

                                    js_removeObj("msgBox");
                                    me.preencheComboContasDebito(oAjax);
                                  }
                                  });
  };

  /**
   * Preenche o combo box com as contas débito
   */
  me.preencheComboContasDebito = function(oAjax) {

    var oRetorno = eval ("("+oAjax.responseText+")");
    if (oRetorno.status == 2) {

      alert(oRetorno.message.urlDecode());
      me.oButtonSalvar.disabled = true;
      return false;
    }
    var aContasDebito = oRetorno.aContas;

    aContasDebito.each (function (oContaDebito, iIndice){
      me.oComboContaDebito.addItem(oContaDebito.reduzido, oContaDebito.reduzido+" - "+oContaDebito.descricao.urlDecode());
    });
    me.oComboContaDebito.show($('td_contadebito_'+me.sNomeInstancia));
  };


  /**
   * Busca as contas credito para serem apresentadas no combo
   *
   */
  me.getContasCredito = function() {

    js_divCarregando("Aguarde, buscando contas Crédito...", "msgBox");
    var oParam                = new Object();
    oParam.exec               = me.sParametroContaCredito;
    oParam.lContaCredito      = me.lContaCredito;
    oParam.lContaDebito       = me.lContaDebito;
    oParam.iTipoTransferencia = me.iTipoTransferencia;

    var oAjax = new Ajax.Request(me.sUrlRpc,
                                {method: 'post',
                                 parameters: 'json='+Object.toJSON(oParam),
                                 onComplete: function(oAjax){

                                   js_removeObj("msgBox");
                                   me.preencheComboContasCredito(oAjax); }});
  };


  /**
   * Preenche o combobox com as informações da conta credito
   */
  me.preencheComboContasCredito = function(oAjax) {

    var oRetorno = eval("("+oAjax.responseText+")");
    if (oRetorno.status == 2) {

      alert(oRetorno.message.urlDecode());
      me.oButtonSalvar.disabled = true;
      return false;
    }
    var aContasCredito = oRetorno.aContas;
    aContasCredito.each(function(oConta, iIndice){
      me.oComboContaCredito.addItem(oConta.reduzido, oConta.reduzido+" - "+oConta.descricao.urlDecode());
    });
    me.oComboContaCredito.show($('td_contacredito_'+me.sNomeInstancia));
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

  me.showGrid = function (oDivGrid) {


    me.oDivGeralGrid         = document.createElement("div");

    var oFieldsetGrid         = document.createElement("fieldset");
    oFieldsetGrid.id          = "fieldset_grid";
    oFieldsetGrid.style.width = "800px";
    var oLegendGrid           = document.createElement("legend");
    oLegendGrid.innerHTML     = "<b>Transferências a Receber</b>";
    oFieldsetGrid.appendChild(oLegendGrid);

    me.oDivGrid               = document.createElement("div");
    me.oDivGrid.id            = 'ctnGridVariavel';
    me.oDivGrid.style.width   = '100%';
    me.oDivGrid.style.display = '';

    oFieldsetGrid.appendChild(me.oDivGrid);
    me.oDivGeralGrid.appendChild(oFieldsetGrid);
    me.oDivDestino.appendChild(me.oDivGeralGrid);

    me.oDBGridListaTransferencias              = new DBGrid('transferencias');
    me.oDBGridListaTransferencias.nameInstance = 'oDBGridListaTransferencias';
    me.oDBGridListaTransferencias.setHeight(200);

    //Header da Grid
    var aHeader      = new Array('Código', 'Data Autenticação','Histórico','Valor','Instituicao Origem');
    me.oDBGridListaTransferencias.setHeader(aHeader);

    var aCellWidth = new Array("100px", "100px", "200px", "200px", "200px");
    me.oDBGridListaTransferencias.setCellWidth(aCellWidth);

    //Alinhamento
    var aAlignCells  = new Array('right', 'center', 'center','right','center');
    me.oDBGridListaTransferencias.setCellAlign(aAlignCells);
    me.oDBGridListaTransferencias.show($('ctnGridVariavel'));
    me.pesquisaTranferenciaRecebimento();
  };

  /**
   * Pesquisa as transferências aptas para recebimento
   */

  me.pesquisaTranferenciaRecebimento = function() {

    js_divCarregando("Aguarde, buscando Tranferências..", "msgBox");

    var oParam                 = new Object();
    oParam.iCodigoTipoOperacao = me.iTipoTransferencia;

    if (me.lEstorno) {
      oParam.exec = "pesquisaEstornoRecebimento";
    } else {
      oParam.exec = "pesquisaTranferenciasRecebimento";
    }

    var oAjax = new Ajax.Request ( me.sUrlRpc,
                                  {
                                  method: 'post',
                                  parameters: 'json='+Object.toJSON(oParam),
                                  onComplete: function(oAjax){

                                    js_removeObj("msgBox");
                                    me.preencheGridRecebimento(oAjax);
                                  }
                                  });
  };



  /**
   * Método para preencher a Grid da tela de recebimento e estorno de recebimento
   */
  me.preencheGridRecebimento = function(oAjax){

    var oRetorno = eval("("+oAjax.responseText.urlDecode()+")");
    me.oDBGridListaTransferencias.clearAll(true);

    if(oRetorno.aTransferenciasRecebimento.length == 0) {

      alert("Não existem Transferências para o recebimento");
      return false;

    }

    oRetorno.aTransferenciasRecebimento.each(function (oTransferencia , iLinha) {

      var aRow = new Array();
      aRow[0]  = oTransferencia.k17_codigo;
      aRow[1]  = oTransferencia.k17_data;
      aRow[2]  = oTransferencia.c50_compl.urlDecode();
      aRow[3]  = js_formatar(oTransferencia.nValor, 'f');
      aRow[4]  = oTransferencia.sInstituicaoOrigem.urlDecode();

      me.oDBGridListaTransferencias.addRow(aRow);
      me.oDBGridListaTransferencias.aRows[iLinha].sEvents += "ondblclick='"+me.sNomeInstancia+".preencheTela("+oTransferencia.k17_codigo+");';";
    });

    me.oDBGridListaTransferencias.renderRows();
  };

  /**
   * Preenche a tela com os dados do slip
   */
  me.preencheTela = function (iCodigo){

    js_divCarregando("Aguarde, buscando Tranferências..", "msgBox");
    var oParam                 = new Object();
    oParam.k17_codigo          = iCodigo;
    oParam.iCodigoTipoOperacao = iTipoTransferencia;
    oParam.lRecebimento        = true;
    oParam.exec                = "getDadosTransferencia";

    var oAjax = new Ajax.Request ( me.sUrlRpc,
                                  {
                                  method: 'post',
                                  parameters: 'json='+Object.toJSON(oParam),
                                  onComplete: function(oAjax){

                                    js_removeObj("msgBox");
                                    if (me.lEstorno) {
                                      me.preencheDadosSlipRecebimento(oAjax);
                                    } else {
                                      me.preencheDadosTela(oAjax);
                                    }
                                  }
                                  });
  };

  /**
   * Preenche o código do slip  e carrega as informações para estorno
   */
  me.preencheDadosSlipRecebimento = function (oAjax) {

    var oRetorno = eval("("+oAjax.responseText.urlDecode()+")");
    $('labelContaDebito').innerHTML  = "<b>Conta Débito:</b>";
    $('labelContaCredito').innerHTML = "<b>Conta Crédito:</b>";
    me.oTxtContaCreditoCodigo.setValue(oRetorno.iContaCredito);
    me.oTxtContaDebitoCodigo.setValue(oRetorno.iContaDebito);

    me.oTxtContaCreditoCodigo.setReadOnly(true);
    me.oTxtContaDebitoCodigo.setReadOnly(true);
    var sFunctionPesquisa = "me.pesquisaConta";

    window.setTimeout(

      function() {
        me.oTxtContaDebitoCodigo.setValue(oRetorno.iContaDebito);
       
      }, 3000
    );

    var oFunctionDebito =  eval(sFunctionPesquisa + me.sPesquisaContaDebito);
    oFunctionDebito(false, false, true);

    window.setTimeout(

      function() {
        var oFunctionCredito = eval(sFunctionPesquisa + me.sPesquisaContaCredito);
        oFunctionCredito(false, true, true);
      }, 100
    );

    me.oTxtCodigoSlip.setValue(oRetorno.iCodigoSlip);
    me.oTxtInstituicaoOrigemCodigo.setValue(oRetorno.iInstituicaoOrigem);
    $('oTxtDescricaoInstituicaoOrigem').value = (oRetorno.sDescricaoInstituicaoOrigem.urlDecode());
    $('oTxtCNPJInstituicaoOrigem').value = oRetorno.sCNPJ;

    me.oTxtCaracteristicaDebitoInputCodigo.setValue(oRetorno.sCaracteristicaDebito);
    me.pesquisaCaracteristicaPeculiarDebito(false);
    me.oTxtCaracteristicaDebitoInputCodigo.setReadOnly(true);

    me.oTxtCaracteristicaCreditoInputCodigo.setValue(oRetorno.sCaracteristicaCredito);
    me.pesquisaCaracteristicaPeculiarCredito(false);
    me.oTxtCaracteristicaCreditoInputCodigo.setReadOnly(true);

    me.oTxtFonteInputCodigo.setValue(oRetorno.iCodigoFonte);
    me.pesquisaFonte(false);
    me.oTxtFonteInputCodigo.setReadOnly(true);
     
    me.oTxtProcessoInput.setValue(oRetorno.k145_numeroprocesso);
    me.oTxtNumDocumentoInput.setValue(oRetorno.iNumeroDocumento);

    me.oTxtHistoricoInputCodigo.setValue(oRetorno.iHistorico);
    me.pesquisaHistorico(false);
    me.oTxtHistoricoInputCodigo.setReadOnly(true);

    me.oTxtValorInput.setValue(oRetorno.nValor);
    me.setObservacao(undoTagString(oRetorno.sObservacao.urlDecode()));
    me.setObservacaoReadOnly(true);

    $("td_caracteristicapeculiar_credito_"+me.sNomeInstancia).innerHTML  = "<b>C.Peculiar / C.Aplicação:</b>";
    $("td_caracteristicapeculiar_"+me.sNomeInstancia).innerHTML          = "<b>C.Peculiar / C.Aplicação:</b>";
    $("td_historico_"+me.sNomeInstancia).innerHTML                       = "<b>Histórico:</b>";

    me.oDivGeralGrid.style.display       = 'none';
    me.oDivContainerCampos.style.display = '';
    /**
     *  Codigo comentado, nao existe os combos no componente.
     */
    /*
    me.oComboContaDebito.setValue(oRetorno.iContaDebito);
    me.oComboContaCredito.setValue(oRetorno.iContaCredito);
    me.oComboContaDebito.setDisable();
    me.oComboContaCredito.setDisable();
    */
  };


  /**
   * Seta valores nos campos da tela
   */
  me.preencheDadosTela = function (oAjax){

    me.oDivGeralGrid.style.display       = 'none';
    me.oDivContainerCampos.style.display = '';

    var oRetorno = eval("("+oAjax.responseText+")");
    console.log(oRetorno);
    me.oTxtInstituicaoOrigemCodigo.setValue(oRetorno.iInstituicaoOrigem);
    $('oTxtDescricaoInstituicaoOrigem').value = oRetorno.sDescricaoInstituicaoOrigem.urlDecode();
    $('oTxtCNPJInstituicaoOrigem').value = oRetorno.sCNPJ.urlDecode();
    me.oTxtValorInput.setValue(oRetorno.nValor);
    me.iCodigoSlipRecebido  = oRetorno.iCodigoSlip;
  };

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

    var sUrlSaltes = "func_saltesreduz.php?ver_datalimite=1&pesquisa_chave="+oTxtConta.getValue()+"&funcao_js=parent."+me.sNomeInstancia+".preenche"+sFunctionCompleta;
    if (lMostra) {
      sUrlSaltes = "func_saltesreduz.php?ver_datalimite=1&funcao_js=parent."+me.sNomeInstancia+".completa"+sFunctionCompleta+"|k13_reduz|k13_descr";
    }

    js_OpenJanelaIframe("", 'db_iframe_'+sIframe, sUrlSaltes, "Pesquisa Contas", lMostra);
  };

  /* [Extensão] - Filtro da Despesa - parte 2 */

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
    js_OpenJanelaIframe("", 'db_iframe_'+sIframe, sUrlEvento, "Pesquisa Contas", lMostra);
  };

    me.bTipoDevolucao = function (iTipo, iSubtipo) {
        if (iTipo == 4 && iSubtipo == 2)
            return true;
        return false;
    }

  me.completaDebito = function(iReduzido, sDescricao, iTipo, iSubtipo) {

    me.oTxtContaDebitoCodigo.setValue(iReduzido);
    me.oTxtContaDebitoDescricao.setValue(sDescricao);
    me.bTemExercicioDevolucaoDebito = me.bTipoDevolucao(iTipo, iSubtipo);
    me.mostrarExercicioDevolucao();

    var sIframeConta = "db_iframe_" + me.sPesquisaContaDebito;
    var oIframe      = eval(sIframeConta);
    oIframe.hide();
  };

  me.preencheDebito = function(sDescricao, lErro) {

    me.oTxtContaDebitoDescricao.setValue(sDescricao);
    if (lErro) {
      me.oTxtContaDebitoCodigo.setValue("");
      $(me.oTxtContaDebitoCodigo.sName).focus();
    }

  };

  me.completaCredito = function(iReduzido, sDescricao, iTipo, iSubtipo) {

    me.oTxtContaCreditoCodigo.setValue(iReduzido);
    me.oTxtContaCreditoDescricao.setValue(sDescricao);
    me.bTemExercicioDevolucaoCredito = me.bTipoDevolucao(iTipo, iSubtipo);
    me.mostrarExercicioDevolucao();

    var sIframeConta = "db_iframe_" + me.sPesquisaContaCredito;
    var oIframe      = eval(sIframeConta);
    oIframe.hide();
  };

  me.preencheCredito = function(sDescricao, lErro) {

    me.oTxtContaCreditoDescricao.setValue(sDescricao);
    if (lErro) {
      me.oTxtContaCreditoCodigo.setValue("");
      $(me.oTxtContaCreditoCodigo.sName).focus();
    }
  }

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
  me.buscaContas = function(inputField,inputCodigo,ulField,descricao,tipoconta)
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
        oParam.exec   = "verificaContaGeral";  
        if(tipoconta == 1)
          oParam.exec   = "verificaContaEventoContabil"; 
        oParam.iDescricao  = descricao;
        oParam.inputField  = inputField;
        oParam.inputCodigo = inputCodigo;
        oParam.ulField     = ulField;
        oParam.tipodaconta = me.tipocontadebito;
        oParam.tipoDebCred = tipoconta;
        oParam.iTipoInclusao = me.iTipoTransferencia;
        oParam.tiposelecione = 0;

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
    me.fillAutoComplete = function(oAjax)
    {    
      js_removeObj("msgBox");
     // Importe o arquivo JavaScript que contém o método performsAutoComplete
      require_once('scripts/classes/autocomplete/AutoComplete.js');  
      performsAutoComplete(oAjax);
      
                 
    }

  /**
   * Lookup de pesquisa do Histórico
   */
  me.pesquisaHistorico = function (lMostra) {

    var sUrlHistorico = "func_conhist.php?pesquisa_chave="+me.oTxtHistoricoInputCodigo.getValue()+"&funcao_js=parent."+me.sNomeInstancia+".preencheHistorico";
    if (lMostra) {
      sUrlHistorico = "func_conhist.php?funcao_js=parent."+me.sNomeInstancia+".completaHistorico|c50_codhist|c50_descr|c50_descrcompl";
    }
    js_OpenJanelaIframe("", 'db_iframe_conhist', sUrlHistorico, "Pesquisa Histórico", lMostra);
  };


  /**
   * Lookup de pesquisa do Fonte
   */


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
        if (erro==true) {
            me.oTxtFonteInputCodigo.focus();
            me.oTxtFonteInputCodigo.value = '';
        }
    };

  /**
   * Preenche a descrição histórico
   */
  me.preencheHistorico = function (sDescricao,sHistorico, lErro) {

    me.oTxtHistoricoInputDescricao.setValue(sDescricao);
    if (sHistorico) {
      me.oTxtObservacaoInput.setValue(sHistorico);
    }
    if (lErro) {
      me.oTxtHistoricoInputCodigo.setValue();
    }
  };

  /**
   * Completa os campos do Histórico
   */
  me.completaHistorico = function (iCodigoHistorico, sDescricao, sHistorico) {

    me.oTxtHistoricoInputCodigo.setValue(iCodigoHistorico);
    me.oTxtHistoricoInputDescricao.setValue(sDescricao);
    me.oTxtObservacaoInput.setValue(sHistorico);
    db_iframe_conhist.hide();
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
   * Seta todos os campos do formulário como ReadOnly
   */
  me.setAllFieldsReadOnly = function() {

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

    me.mostrarExercicioDevolucao = function() {
        if (me.iAno < 2022)
            return false;

        var oTabela = document.getElementById("table_oDBViewSlipRecebimento");
        oTabela.rows[me.iLinhaExercicioDevolucao].hidden = true;
        if (me.temExercicioDevolucao())
            oTabela.rows[me.iLinhaExercicioDevolucao].hidden = false;
    }

    me.temExercicioDevolucao = function () {
        if (me.bTemExercicioDevolucaoDebito == 't' || me.bTemExercicioDevolucaoCredito == 't')
            return true;
        return false;
    }

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

  me.clearAllFields = function() {

    me.oTxtCodigoSlip.setValue('');
    me.oTxtInstituicaoOrigemCodigo.setValue('');
    me.oTxtDescricaoInstituicaoOrigem.setValue('');
    me.oTxtCNPJInstituicaoOrigem.setValue('');
    me.oTxtExercicioCompetenciaDevolucaoInput.setValue('');
    /**
     * Trazer por padrão o campo caracteristica peculiar 000
     */
    me.oTxtCaracteristicaDebitoInputCodigo.setValue("000");
    me.pesquisaCaracteristicaPeculiarDebito(false);
    me.oTxtCaracteristicaCreditoInputCodigo.setValue("000");
    me.pesquisaCaracteristicaPeculiarCredito(false);

    me.oTxtHistoricoInputCodigo.setValue('');
    me.oTxtHistoricoInputDescricao.setValue('');

    me.oTxtFonteInputCodigo.setValue('');
    me.oTxtFonteInputDescricao.setValue('');

    me.oTxtValorInput.setValue('');
    me.setObservacao('');

    if (me.lEstorno) {
      me.oTxtMotivoInput.setValue("");
    }
  };


    /**
     * Seta o ano da sessão
     */
     me.setAno = function (iAno) {
        me.iAno = parseInt(iAno);
    }

  /**
   * Funcoes que só devem ser executadas após o componente estar montado na tela
   */
  me.start = function() {

    me.clearAllFields();
    /**
     * Codigo comentado, pois nao existe os combos criados;;;;
     * @todo Criar combos no componente, e verificar impactos.
     *
     * me.getContasDebito();
     * me.getContasCredito();
    */
  };
  me.show();
  me.showGrid();
};
