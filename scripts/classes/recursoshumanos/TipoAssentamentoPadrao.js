(function(window){

  var TipoAssentamentoPadrao = function() {

    this.oDestino            = null;
    this.iCodigoAssentamento = null;
    this.sCaminhoFormulario  = null;

    this.setDestino = function(oDestino) {
      this.oDestino = oDestino;
    }.bind(this);

    this.setCodigoAssentamento = function(iCodigoAssentamento) {
      this.iCodigoAssentamento = iCodigoAssentamento;
    }.bind(this);

    this.oBotaoAcao = null; 
  };

  TipoAssentamentoPadrao.prototype.validarCampos = function () {    
    return true;
  };

  TipoAssentamentoPadrao.prototype.makeEvents = function () {

    this.oBotaoAcao         =  $('db_opcao');

    fCallbackClick          = this.validarCampos.bind(this);
    this.oBotaoAcao.onclick = fCallbackClick;
  };

  TipoAssentamentoPadrao.prototype.make = function() {

    $('h16_dtterm').setStyle('background-color: #e6e4f1');

    if($('db_opcao').name.toLowerCase() == 'excluir'){
      $('h16_dtterm').setStyle('background-color: #deb887');      
    }
    return;
  };

  TipoAssentamentoPadrao.prototype.show = function() {
    
    if ( (this.oDestino instanceof HTMLElement) && this.sCaminhoFormulario ) {
      this.oDestino.load(this.sCaminhoFormulario);
    }

    this.make();
    this.makeEvents();
    return;
  };

  window.TipoAssentamentoPadrao = TipoAssentamentoPadrao;
})(window);
