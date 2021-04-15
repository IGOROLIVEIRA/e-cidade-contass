/**
 * View para apresentação dos lotes pendentes da uma licitação
 *
 * @author Victor Felipe
 */

DBViewLotesPendentes = function(sNameInstance) {
  
  var me                 = this;
  this.sNameInstance       = sNameInstance;
  this.sUrlRPC             = "lic4_licitacao.RPC.php";
  this.oWindowLotesPendentes = null;
  this.callBackDoubleClick = function() {};
  this.sTextoRodape        = "";

  /**
   * Método Show
   * Este método mostra a windowAux com as notas pendentes existentes
   */
  this.show = function () {
    
    /**
     * Criamos a WindowAux com que irá apresentar as notas pendentes dos itens
     */
    var sTituloLotesPentendes = "Lotes Pendentes";
    
    this.oWindowLotesPendentes    = new windowAux('oWndNotasPendentes_'+this.sNameInstance, sTituloLotesPentendes, 590, 450);

    var sContentLotesPendentes   = "<fieldset>";
        sContentLotesPendentes  += "  <div id='ctnGridLotesPendentes'></div>";
        sContentLotesPendentes  += "</fieldset>";
        
    
    this.oWindowLotesPendentes.setContent(sContentLotesPendentes);
    this.oWindowLotesPendentes.show();

    /**
     * Esconde janela ao clicar no icone para fechar ou apertar tecla ESC 
     */
    this.oWindowLotesPendentes.setShutDownFunction(function() {
      me.oWindowLotesPendentes.hide();
      me.oWindowLotesPendentes.destroy();
    })
    
    /**
     * Criamos a messageBoard para a WindowAux
     */
    var sTituloLotesPendentes = 'Lotes pendentes da licitação'
    var sHelpLotesPendentes   = '';

    
    var oMsgBoardLotesPendentes  = new DBMessageBoard('oMsgBoardLotesPendentes_' + this.sNameInstance, 
                                                      sTituloLotesPendentes,
                                                      sHelpLotesPendentes,
                                                      this.oWindowLotesPendentes.getContentContainer());
    oMsgBoardLotesPendentes.show();
    
    /**
     * Montamos a grid que vai mostrar os lotes pendentes dos itens
     * A terceira coluna não tem largura e nem header para não aparecer na renderização,
     * mas ela armazena os códigos dos itens (liclicitemlote) do lote corrente
     */
    oGridLotesPendentes              = new DBGrid('ctnGridLotesPendentes');
    oGridLotesPendentes.nameInstance = 'oGridLotesPendentes_' + this.sNameInstance;
    let aCellWidth                   = new Array('30%', '70%', "");
    let aCellAlign                   = new Array('center', 'center', "");
    let aHeaders                     = new Array('Sequencial', 'Nome do lote', "");
    oGridLotesPendentes.setHeight(200);
    oGridLotesPendentes.setCellWidth(aCellWidth);
    oGridLotesPendentes.setHeader(aHeaders);
    oGridLotesPendentes.aHeaders[2].lDisplayed = false;
    oGridLotesPendentes.setCellAlign(aCellAlign);
    oGridLotesPendentes.show($('ctnGridLotesPendentes'));
    this.getLotesPendentes();
  }
  
  /**
   * @todo Método que vai buscar os lotes pendentes da licitação
   */
    this.getLotesPendentes = function() {
    
        let oParam  = new Object();
        oParam.exec = "getLotesPendentes";
        oParam.iLicitacao = this.getLicitacao();

        let oAjax   = new Ajax.Request(this.sUrlRPC,
                                      {method: 'post',
                                      parameters: 'json='+Object.toJSON(oParam), 
                                      onComplete: this.preencheGridLotesPendentes 
                                      });
    }

    this.preencheGridLotesPendentes = (oAjax) => {
        oGridLotesPendentes.clearAll(true);
        let oRetorno = eval("("+oAjax.responseText+")");
        let aTemporario = [];
        
        oRetorno.itens.each(oLotePendente => {

            let aLinha    = new Array();
            
            aLinha[1] = oLotePendente.descricao;
            aLinha[2] = oLotePendente.codigo;

            if(aTemporario.length){

                let flag = false;

                aTemporario.map(item => {
                    if(item[1].trim() == oLotePendente.descricao.trim()){
                        item[2] += ', '+oLotePendente.codigo;
                        flag = !flag;
                    }
                });
                
                if(!flag){
                    aTemporario.push(aLinha);  
                }

            }else{
                aLinha[0] = 1;
                aTemporario.push(aLinha);
            }
            
        });
          
        for(let count = 0; count < aTemporario.length; count++){
            aTemporario[count][0] = count+1;
            oGridLotesPendentes.addRow(aTemporario[count]);
            oGridLotesPendentes.aRows[count].sEvents = "ondblclick='" + me.sNameInstance+".loadCallBackDoubleClick("+count+");'";     
        }
        
        if(aTemporario.length){
            oGridLotesPendentes.renderRows();
        }else{
            me.oWindowLotesPendentes.destroy();
        }

    }
  
  /**
   * Seta um valor para a propriedade iLicitacao
   */
    this.setLicitacao = function (iLicitacao) {
        this.iLicitacao = iLicitacao;
    }

  /**
   * Retorna o valor para a propriedade iLicitacao
   */
    this.getLicitacao = function () {
        return this.iLicitacao;
    }
  
  /**
   * Carrega dados da linha e chama funcao definina pelo setCallBackDoubleClick()
   * 
   * @param integer iLinhaGrid - linha da grid que foi clicada
   */
    this.loadCallBackDoubleClick = function(iLinhaGrid) {
        
    /**
     * Objeto com dados da linha que foi dado dois clicks
     */
        let oDadosLinha = new Object();

        oDadosLinha.iCodigo         = oGridLotesPendentes.aRows[iLinhaGrid].aCells[0].getContent();
        oDadosLinha.sDescricao      = oGridLotesPendentes.aRows[iLinhaGrid].aCells[1].getContent();
        oDadosLinha.sLote           = oGridLotesPendentes.aRows[iLinhaGrid].aCells[2].getContent();

      /**
       * Executa funcao definida passando como parametro dados da linha clicada
       */

      return this.callBackDoubleClick(oDadosLinha);

  }

  /**
   * Define a funcao que ser ausada ao clicar duas vezes na linha da grid
   *
   * @param function callBackDoubleClick 
   */
  this.setCallBackDoubleClick = function(callBackDoubleClick) {
    this.callBackDoubleClick = callBackDoubleClick;
  }

  /**
   * Define o texto que sera exibido no rodape, abaixo da grid
   * 
   * @param string sTextoRodape
   */
  this.setTextoRodape = function(sTextoRodape) {
    this.sTextoRodape = sTextoRodape;
  }

  /**
   * Retorna o objeto WindowAux
   *
   * @return windowAux
   */
  this.getWindowAux = function() {
    return this.oWindowLotesPendentes;
  }

}
