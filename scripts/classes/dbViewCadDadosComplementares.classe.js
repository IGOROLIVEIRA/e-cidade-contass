DBViewCadDadosComplementares = function (sId, sNameInstance, iCodigoEndereco, incluir, codLicitacao) {
    var me = this;

    this.iCodigoPais = '';
    this.iCodigoEstado = '';
    this.iCodigoMunicipio = '';
    this.iCodigoBairro = '';
    this.iCodigoLogradouro = '';
    this.iCodigoLocal = '';
    this.iCodigoEndereco = iCodigoEndereco;
    this.iCodigoRua = '';
    this.iCodigoRuasTipo = '';
    this.iCodigoRuaTipo = '';
    this.iCodigoCepRua = '';
    this.iCodigoIbge = '';
    this.iTipoValidacao = 1;
    this.iCodigoRuaMunicipio = "";
    this.iCodigoBairroMunicipio = "";
    this.iCodigoOv02_sequencial = "";
    this.iCodigoOv02_seq = "";
    this.iEnderecoAutomatico = false;
    this.iBairroAutomatico = false;
    this.lModificado = false;
    this.iMunicipioAutomatico = false;
    this.lEnderecoMunicipio = false;
    this.sNameInstance = sNameInstance;
    this.sNumero = '';
    this.sId = sId;
    this.sComplemento = '';
    this.sCondominio = '';
    this.sLoteamento = '';
    this.municiovalidado = false;
    this.sNomeMunicipio = '';
    this.sDistrito = '';
    this.sNomePais = '';
    this.sNomeRua = '';
    this.sNomeBairro = '';
    this.sCepEndereco = '';
    this.objRetorno = '';
    this.iGrausLatitude = '';
    this.iMinutoLatitude = '';
    this.iSegundoLatitude = '';
    this.iGrausLongitude = '';
    this.iMinutoLongitude = '';
    this.iSegundoLongitude = '';
    this.iBdi = '';
    this.iLicitacao = '';
    this.acao = incluir;
    this.callBackFunction = function () {

    }

    this.sUrlRpc = 'con4_endereco.RPC.php';

    var iWidth = 790;
    var iWheigth = 460;

    this.oWindowEndereco = new windowAux('wndEndereco' + me.sId, 'Dados complementares', iWidth, iWheigth);

    sContent = "<div  id='ctnMessageBoard' style='text-align:center;width:100%'>";
    sContent += "  <div style='width:100%' id='ctnDados" + sId + "'>";
    sContent += "  <fieldset style='text-align:center;'>";
    sContent += "    <legend><b>Dados Endereço :</b></legend>";
    sContent += "     <table border='0' style=\"border-collapse:collapse;\">";
    sContent += "       <tr >";
    sContent += "         <td id='ctnLabelCep" + sId + "' >";
    sContent += "           <a href='#' onclick='" + me.sNameInstance + ".lookupCep();'><b>Cep:</b></a>";
    sContent += "         </td>";
    sContent += "         <td id='ctnCodigoCep" + sId + "' >";
    sContent += "         </td>";
    sContent += "         <td><input type='button' id='btnPesquisarCep" + sId + "' value='Pesquisar' ";
    sContent += "            onClick='" + me.sNameInstance + ".pesquisaCep();' style='display:none'>";
    sContent += "         </td>";
    sContent += "         <td id='ctnLabelCodigoObra'>";
    sContent += "         <b>Cód. Obra:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnCodigoObra" + sId + "'></td>";
    sContent += "         </td>";
    sContent += "       </tr>";
    sContent += "       <tr>";
    sContent += "         <td id='ctnLabelPais" + sId + "'>";
    sContent += "           <b>País:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnCodigoPais" + sId + "' colspan='5'></td>";
    sContent += "       </tr>";
    sContent += "       <tr>";
    sContent += "         <td id='ctnLabelEstado" + sId + "' >";
    sContent += "           <b>Estado:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnCodigoEstado" + sId + "' colspan='5'></td>";
    sContent += "       </tr>";
    sContent += "       <tr>";
    sContent += "         <td id='ctnLabelMunicipio" + sId + "' >";
    sContent += "           <b>Município:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnCodigoMunicipio" + sId + "' colspan='5'></td>";
    sContent += "       </tr>";
    sContent += "       <tr>";
    sContent += "         <td id='ctnLabelDistrito" + sId + "' >";
    sContent += "           <b>Distrito:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnDistrito" + sId + "' colspan='5'></td>";
    sContent += "       </tr>";
    sContent += "       <tr>";
    sContent += "         <td id='ctnLabelBairro" + sId + "' >";
    sContent += "           <b>Bairro:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnCodigoBairro" + sId + "' style='display: none'>";
    sContent += "         </td>";
    sContent += "         <td id='ctnDescrBairro" + sId + "' colspan='5'>";
    sContent += "         </td>";
    sContent += "       </tr>";
    sContent += "       <tr valign='top' style='display: none'>";
    sContent += "         <td id='ctnLabelRua" + sId + "' style='width:10%;'>";
    sContent += "           <b>Rua:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnCodigoRua" + sId + "' style='width:25%;'>";
    sContent += "         </td>";
    sContent += "          <td id='ctnCboRuasTipo" + sId + "' style='width:15%;'>";
    sContent += "          </td>";
    sContent += "          <td id='ctnDescrRua" + sId + "'  style='width:50%;' colspan='2'>";
    sContent += "          </td>";
    sContent += "         </tr>";
    sContent += "       <tr>";
    sContent += "         <td id='ctnLabelNumero" + sId + "' >";
    sContent += "           <b>Número:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnCodigoNumero" + sId + "' >";
    sContent += "         </td>";
    sContent += "         <td id='ctnLabelLogradouro" + sId + "' >";
    sContent += "           <b>Logradouro:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnDescrLogradouro" + sId + "' colspan='3'>";
    sContent += "         </td>";
    sContent += "         <td id='ctnDescrComplemento" + sId + "' style='display: none'>";
    sContent += "         </td>";
    sContent += "       </tr>";

    sContent += "       <tr valign='top'>";
    sContent += "          <td id='ctnLabelGrausLatitude" + sId + "' style='width:10%;'>";
    sContent += "           <b>Graus Latitude:</b>";
    sContent += "          </td>"
    sContent += "          <td id='ctnGrausLatitude" + sId + "' style='width:25%;'>";
    sContent += "          </td>";

    sContent += "          <td id='ctnLabelMinutoLatitude" + sId + "'>";
    sContent += "           <b>Minuto da Latitude:</b>";
    sContent += "          </td>";
    sContent += "          <td id='ctnMinutoLatitude" + sId + "'>";
    sContent += "          </td>";

    sContent += "          <td id='ctnLabelSegundoLatitude" + sId + "' style='padding-left: 51px;'>";
    sContent += "           <b>Segundo da Latitude:</b>";
    sContent += "          </td>";
    sContent += "          <td id='ctnSegundoLatitude" + sId + "'>";
    sContent += "          </td>";
    sContent += "        </tr>";

    sContent += "       <tr valign='top'>";
    sContent += "          <td id='ctnLabelGrausLongitude" + sId + "' style='width:10%;'>";
    sContent += "           <b>Graus Longitude:</b>";
    sContent += "          </td>";
    sContent += "          <td id='ctnGrausLongitude" + sId + "' style='width:25%;'>";
    sContent += "          </td>";

    sContent += "          <td id='ctnLabelMinutoLongitude" + sId + "'>";
    sContent += "           <b>Minuto da Longitude:</b>";
    sContent += "          </td>";
    sContent += "          <td id='ctnMinutoLongitude" + sId + "'>";
    sContent += "          </td>";

    sContent += "          <td id='ctnLabelSegundoLongitude" + sId + "' style='padding-left: 51px;'>";
    sContent += "           <b>Segundo da Longitude:</b>";
    sContent += "          </td>";
    sContent += "          <td id='ctnSegundoLongitude" + sId + "'>";
    sContent += "          </td>";
    sContent += "        </tr>";

    sContent += "       <tr style='display: none'>";
    sContent += "         <td id='ctnCodigoCepEnd" + sId + "' >";
    sContent += "         </td>";
    sContent += "         <td colspan='1'> &nbsp;";
    sContent += "         </td>";
    sContent += "         <td id='ctnLabelCodigoIbge" + sId + "' >";
    sContent += "           <b>Código IBGE:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnCodigoIbge" + sId + "' >";
    sContent += "         </td>";
    sContent += "         <td colspan='3'> &nbsp;";
    sContent += "         </td>";
    sContent += "       </tr>";
    sContent += "       <tr id='trCondominio" + sId + "' style='display: none'>";
    sContent += "         <td id='ctnDescrCondominio" + sId + "' colspan='4'>";
    sContent += "         </td>";
    sContent += "       </tr>";
    sContent += "       <tr id='trLoteamento" + sId + "' style='display: none'>";
    sContent += "         <td id='ctnLabelLoteamento" + sId + "' >";
    sContent += "           <b>Loteamento:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnDescrLoteamento" + sId + "' colspan='4'>";
    sContent += "         </td>";
    sContent += "       </tr>";
    sContent += "       <tr id='trPontoReferencia" + sId + "' style='display: none'>";
    sContent += "         <td id='ctnLabelPontoReferencia" + sId + "'  nowrap>";
    sContent += "           <b>Ponto Referência:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnDescrPontoReferencia" + sId + "' colspan='4'>";
    sContent += "         <textarea  id='txtDescrPontoReferencia" + sId + "' rows='5' style='width:100%'></textarea>";
    sContent += "         </td>";
    sContent += "       </tr>";
    sContent += "     </table>";
    sContent += "  </fieldset>";
    sContent += "  <fieldset style='text-align:center;'>";
    sContent += "    <legend><b>Obras e serviços :</b></legend>";
    sContent += "     <table border='0' style=\"border-collapse:collapse;\">";
    sContent += "       <tr>";
    sContent += "         <td id='ctnLabelClassesObjeto" + sId + "' >";
    sContent += "           <b>Classe do objeto:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnClassesObjeto" + sId + "'></td>";
    sContent += "         <td id='ctnLabelGrupoBemPub" + sId + "' >";
    sContent += "           <b>Grupo Bem Público:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnGrupoBemPublico" + sId + "'></td>";
    sContent += "       </tr>";
    sContent += "       <tr>";
    sContent += "         <td id='ctnLabelAtividadeObra" + sId + "' >";
    sContent += "           <b>Atividade da Obra:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnAtividadeObra" + sId + "'></td>";
    sContent += "         <td id='ctnLabelSubgrupoBem" + sId + "' >";
    sContent += "           <b>Subgrupo Bem Público:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnSubGrupoBemPublico" + sId + "'></td>";
    sContent += "       </tr>";
    sContent += "       <tr>";
    sContent += "         <td id='ctnLabelAtividadeServico" + sId + "' >";
    sContent += "           <b>Atividade do Serviço:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnAtividadeServico" + sId + "'></td>";
    sContent += "         <td id='ctnLabelBdi" + sId + "' >";
    sContent += "           <b>BDI:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnBdi" + sId + "'></td>";
    sContent += "       </tr>";
    sContent += "       <tr id='trAtividadeServico" + sId + "' style='display: none'>";
    sContent += "         <td id='ctnLabelAtividadeServico" + sId + "'  nowrap>";
    sContent += "           <b>Descrição Atividade Serviço:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnDescrAtividadeServico" + sId + "' colspan='4'>";
    sContent += "         <textarea  id='txtDescrAtividadeServico" + sId + "' rows='2' style='width:100%'></textarea>";
    sContent += "         </td>";
    sContent += "       </tr>";
    sContent += "       <tr>";
    sContent += "         <td id='ctnLabelAtividadeServEsp" + sId + "' >";
    sContent += "           <b>Atividade dos Serviços Especializados:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnAtividadeServEsp" + sId + "'></td>";
    sContent += "       </tr>";
    sContent += "       <tr id='trAtividadeServicoEsp" + sId + "' style='display: none'>";
    sContent += "         <td id='ctnLabelAtividadeServicoEsp" + sId + "'  nowrap>";
    sContent += "           <b>Descrição Atividade Serviço Especializado:</b>";
    sContent += "         </td>";
    sContent += "         <td id='ctnDescrAtividadeServicoEsp" + sId + "' colspan='4'>";
    sContent += "         <textarea  id='txtDescrAtividadeServicoEsp" + sId + "' rows='2' style='width:100%'></textarea>";
    sContent += "         </td>";
    sContent += "       </tr>";
    sContent += "     </table >";
    sContent += "  </fieldset>";
    sContent += "  </div>";
    sContent += "  <div id='btnAcoes" + sId + "' style='margin-top:5px;'>";
    sContent += "     <input type='button' id='btnSalvar" + sId + "' value='Salvar' onClick='" + me.sNameInstance + ".salvarDadosComplementares();'>";
    sContent += "     <input type='button' id='btnLimpar" + sId + "' value='Limpar' onClick='" + me.sNameInstance + ".limpaForm();'>";
    sContent += "  </div>";
    sContent += "</div>";
    me.oWindowEndereco.setContent(sContent);

//Metodo para fechar a janela e retornar o endereco salvo
    me.close = function () {
        if(!me.acao){
            js_buscaDadosComplementares();
        }

        if (me.getObjetoRetorno() != "") {
            me.getObjetoRetorno().value = me.getCodigoObra();
        }
        me.oWindowEndereco.destroy();
    }
    me.oWindowEndereco.setShutDownFunction(me.close);
    me.oWindowEndereco.allowCloseWithEsc(false);
    this.oMessageBoardEndereco = new DBMessageBoard('msgBoardEndereco' + sId,
        'Dados Complementares',
        '',
        $('ctnMessageBoard')
    );
    this.oMessageBoardEndereco.show();

    /**
     *Seta o objeto que vai receber o retorno
     *@param {objeto} oRetorno
     *return void
     */

    this.setObjetoRetorno = function (oRetorno) {
        this.objRetorno = oRetorno;
    }

    /**
     *Retorna o objeto informado para retorno
     *@return objeto
     */
    this.getObjetoRetorno = function () {

        return this.objRetorno;
    }
    /**
     *Seta o objeto que vai receber o numero da Licitação
     *@param {integer} iLicitacao
     *return void
     */

    this.setLicitacao = function (iLicitacao) {
        this.iLicitacao = iLicitacao;
    }

    /**
     *Retorna o número da licitação
     *@return integer
     */
    this.getLicitacao = function () {
        return this.iLicitacao;
    }
    /**
     *Seta se o campo condominio vai estar disponivel na tela
     *@param {boolean} lCondominio
     *return void
     */

    this.hideCondominio = function () {
        me.lShowCondominio = false;
        if ($('trCondominio' + me.sId)) {
            $('trCondominio' + me.sId).style.display = 'none';
        }
    }

    /**
     *Seta se o campo loteamento vai estar disponivel na tela
     *return void
     */
    this.hideLoteamento = function () {
        me.lShowLoteamento = false;
        if ($('trLoteamento' + me.sId)) {
            $('trLoteamento' + me.sId).style.display = 'none';
        }
    }

    /**
     *Seta se o campo ponto de referencia vai estar disponivel na tela
     *return void
     */
    this.hidePontoReferencia = function () {

        me.lShowPontoReferencia = false;
        if ($('trPontoReferencia' + me.sId)) {
            $('trPontoReferencia' + me.sId).style.display = 'none';
        }
    }

    /**
     *Seta se o campo complemento vai estar disponivel na tela
     *return void
     */
    this.hideComplemento = function () {
        me.lShowComplemento = false;
        if ($('trComplemento' + me.sId)) {
            $('trComplemento' + me.sId).style.display = 'none';
        }
    }

    //Métodos para setar e ler as propriedades
    /**
     *Seta o estado se foi modificado alguma coisa na tela
     *@param {boolean} lModificado
     *@return void
     */
    this.setModificado = function (lModificado) {
        me.lModificado = lModificado;
    }

    /**
     *Retorna o estado se houve alguma modificacao
     *@return {boolean} true se alterado false se nao alterado
     */
    this.getModificado = function () {
        return this.lModificado;
    }

    /**
     *Seta o codigo da rua do endereco do cadastro Imobiliario
     *@param {integer} iCodigoRuaMunicipio
     *@return void
     */
    this.setCodigoRuaMunicipio = function (iCodigoRuaMunicipio) {
        this.iCodigoRuaMunicipio = iCodigoRuaMunicipio;
    }

    /**
     *Retorna o codigo da rua do endereco do cadastro Imobiliario
     *@return {integer} codigo da rua do cadastro imobiliario
     */
    this.getCodigoRuaMunicipio = function () {
        return this.iCodigoRuaMunicipio;
    }

    /**
     *Seta o codigo do bairro do endereco do cadastro Imobiliario
     *@param {integer} iCodigoBairroMunicipio
     *@return void
     */
    this.setCodigoBairroMunicipio = function (iCodigoBairroMunicipio) {
        this.iCodigoBairroMunicipio = iCodigoBairroMunicipio;
    }

    /**
     *Retorna o codigo do bairro do endereco do cadastro Imobiliario
     *@return {integer} codigo do bairro do cadastro imobiliario
     */
    this.getCodigoBairroMunicipio = function () {
        return this.iCodigoBairroMunicipio;
    }

    /**
     *Seta a descricao da rua do endereco
     *@param {string} sNomeRua
     *@return void
     */
    this.setNomeRua = function (sNomeRua) {
        this.sNomeRua = sNomeRua;
    }

    /**
     *Retorna a descricao da rua do endereco
     *@return {string} nome da rua
     */
    this.getNomeRua = function () {
        return this.sNomeRua;
    }

    /**
     *Seta o codigo do tipo da rua conforme a tabela de ligacao
     *@param {string} iCodigoRuasTipo
     *@return void
     */
    this.setRuasTipo = function (iCodigoRuasTipo) {
        this.iCodigoRuasTipo = iCodigoRuasTipo;
    }

    /**
     *Retorna o codigo sequencial que contem a ligacao com o tipo de rua
     *@return {string} com o codigo de ligacao com do tipo de rua
     */
    this.getRuasTipo = function () {
        return this.iCodigoRuasTipo;
    }

    /**
     *Seta o tipo da rua
     *@param {string} iCodigoRuaTipo
     *@return void
     */
    this.setRuaTipo = function (iCodigoRuaTipo) {
        this.iCodigoRuaTipo = iCodigoRuaTipo;
    }

    /**
     *Retorna o tipo da rua que esta selecionado no select da tela
     *@return {string} com o codigo do tipo de rua
     */
    this.getRuaTipo = function () {
        return this.iCodigoRuaTipo;
    }

    /**
     *Seta o Cep da rua
     *@param {string} iCodigoCepRua
     *@return void
     */

    this.setCepRua = function (iCodigoCepRua) {
        this.iCodigoCepRua = iCodigoCepRua;
    }
    /**
     *Retorna o Cep da rua
     *@return {string} com o cep da rua
     */
    this.getCepRua = function () {
        return this.iCodigoCepRua;
    }

    /**
     *Retorna o codigo ov02_seqeuncial do cidadao
     *@return {integer} codigo ov02_sequencial
     */
    this.getCodigoCidadao = function () {

        var aCidadao = new Array();
        aCidadao[0] = this.iCodigoOv02_sequencial;
        aCidadao[1] = this.iCodigoOv02_seq;

        return aCidadao;
    }

    /**
     *Retorna o codigo ov02_seqeuncial do cidadao
     *@return {integer} codigo ov02_sequencial
     */
    this.setCodigoCidadao = function (ov02_sequencial, ov02_seq) {

        this.iCodigoOv02_sequencial = ov02_sequencial;
        this.iCodigoOv02_seq = ov02_seq;
    }

    me.sTxtNomeBairro = null;

    /*
    *Cria o campo de busca do cep
    */
    me.oTxtCep = new DBTextField('txtCep' + sId, 'txtCep' + sId, '');
    //me.oTxtCep.addEvent('onKeyPress', 'return js_mask(event, "0-9|")');
    me.oTxtCep.addEvent('onKeyUp', "js_ValidaCampos(this,1,\"Campo Cep\",\"t\",\"t\",event)");
    me.oTxtCep.addStyle('width', '70px');
    //me.oTxtCep.addStyle('display', 'none');
    me.oTxtCep.setMaxLength(8);
    me.oTxtCep.show($('ctnCodigoCep' + sId));

    if(incluir){
        let oParam = new Object();
        oParam.exec = 'getCodigoObra';
        oParam.licitacao = codLicitacao;
        var oAjax = new Ajax.Request(
            me.sUrlRpc,
            {
                parameters: 'json=' + Object.toJSON(oParam),
                method: 'post',
                onComplete: retornoCodigoObra
            }
        );
    }

    function retornoCodigoObra(oAjax){
        let oRetorno = eval('(' + oAjax.responseText + ')');

        if(oRetorno.status == 1){
            me.setCodigoObra(oRetorno.obra);
            $('txtCodigoObra'+sId).value = oRetorno.obra;
            $('txtCodigoObra'+sId).setAttribute('class', 'readonly');
            $('txtCodigoObra'+sId).setAttribute('disabled', 'disabled');
        }
    }

    /**
     *Retorna o Código da Obra
     *@return {integer} iCodigoObra
     */
    this.getCodigoObra = function () {
        return this.iCodigoObra;
    }

    /**
     *Retorna o codigo da Obra
     *@return {integer} iCodigoObra
     */
    this.setCodigoObra = function (iCodigoObra) {
        this.iCodigoObra = iCodigoObra;
    }

    /**
     *Retorna o Sequencial de cadastro dos dados complementares
     *@return {integer} iSequencial
     */
    this.getSequencial = function () {
        return this.iSequencial;
    }

    /**
     *Retorna o Sequencial de cadastro dos dados complementares
     *@return {integer} iSequencial
     */
    this.setSequencial = function (iSequencial) {
        this.iSequencial = iSequencial;
    }

    this.changeValorObra = (e) => {
        me.setCodigoObra(e.target.value);
        me.getCodigoObra();
    }

    me.oTxtCodigoObra = new DBTextField('txtCodigoObra' + sId, 'txtCodigoObra' + sId, '');
    me.oTxtCodigoObra.addEvent('onKeyUp', "js_ValidaCampos(this,1,\"Campo Código Obra\",\"f\",\"f\",event)");
    me.oTxtCodigoObra.addStyle('width', '80px');
    me.oTxtCodigoObra.setMaxLength(8);
    me.oTxtCodigoObra.show($('ctnCodigoObra' + sId));
    $('ctnCodigoObra' + sId).observe('change', me.changeValorObra);

    /**
     *Metodo para realizar a busca do endereco pelo cep informado
     *caso seja retornado algum dado estes serao preenchidos ate
     *o campo rua.
     */
    this.pesquisaCep = function () {
        if ($('txtCep' + sId).value == '') {
            return false;
        }

        if ($('txtCep' + sId).value.length != 8) {
            alert('Usuário:\n\nO Cep informado possui menos de 8 digitos.\n\nVerifique para continuar a pesquisa.\n\n');
            return false;
        }

        // if ($F('txtDescrBairro' + sId).trim() != "" ||
        //     $F('txtDescrRua' + sId).trim() != "" ||
        //     $F('txtCodigoNumero' + sId).trim() != "") {

            // if (!confirm('usuário:\n\nExistem dados abaixo preenchidos serão perdidos Deseja Continuar?\n\n')) {
            //     $('txtCep' + sId).value = ''
            //     return false;
            // }
        // }

        var oPesquisa = new Object();
        oPesquisa.exec = 'findCep';
        oPesquisa.codigoCep = $F('txtCep' + sId);
        oPesquisa.sNomeBairro = me.sTxtNomeBairro;

        var msgDiv = "Aguarde pesquisando cep.";
        js_divCarregando(msgDiv, 'msgBox');

        var oAjax = new Ajax.Request(
            me.sUrlRpc,
            {
                parameters: 'json=' + Object.toJSON(oPesquisa),
                method: 'post',
                onComplete: me.retornoFindCep
            }
        );
    }

    /**
     * Método que exibe a lookup de pesquisa por CEP
     * No retorno da mesma disparamos a pesquisa que busca as informações do CEP selecionado
     */
    this.lookupCep = function () {

        js_OpenJanelaIframe('', 'db_iframe_cep',
            'func_cep.php?funcao_js=parent.' + me.sNameInstance + '.retornoLookupCep|cep|cp01_bairro',
            'Pesquisa CEP', true);
        $('Jandb_iframe_cep').style.zIndex = 100000;
    }

    /**
     * Método que exibe o retorno da função lookupCep()
     * Escondemos a Lookup e disparamos a pesquisa das informações do CEP selecionado
     */
    this.retornoLookupCep = function () {

        db_iframe_cep.hide();
        $('txtCep' + sId).value = arguments[0];
        me.sTxtNomeBairro = arguments[1];
        me.pesquisaCep();
    }

    /**
     *Metodo que trata o retorno da busca pelo cep informado
     *caso retorno seja false limpa os campos e preenche com os valores default
     *senao preenche os campos com os dados retornados
     */
    this.retornoFindCep = function (oAjax) {

        js_removeObj('msgBox');

        $('cboCodigoPais' + sId).removeAttribute("readonly");
        $('cboCodigoPais' + sId).style.backgroundColor = '#FFFFFF';
        $('cboCodigoMunicipio' + sId).removeAttribute("readonly");
        $('cboCodigoMunicipio' + sId).style.backgroundColor = '#FFFFFF';
        $('txtCodigoBairro' + sId).removeAttribute("readonly");
        $('txtCodigoBairro' + sId).style.backgroundColor = '#FFFFFF';
        $('txtDescrBairro' + sId).removeAttribute("readonly");
        $('txtDescrBairro' + sId).style.backgroundColor = '#FFFFFF';
        $('txtCodigoRua' + sId).removeAttribute("readonly");
        $('txtCodigoRua' + sId).style.backgroundColor = '#FFFFFF';
        $('txtDescrRua' + sId).removeAttribute("readonly");
        $('txtDescrRua' + sId).style.backgroundColor = '#FFFFFF';
        $('txtCepEnd' + sId).removeAttribute("readonly");
        $('txtCepEnd' + sId).style.backgroundColor = '#FFFFFF';
        $('txtCodigoIbge' + sId).removeAttribute("readonly");
        $('txtCodigoIbge' + sId).style.backgroundColor = '#FFFFFF';
        $('cboCodigoEstado' + sId).removeAttribute("readonly");
        $('cboCodigoEstado' + sId).style.backgroundColor = '#FFFFFF';
        $('cboRuasTipo' + sId).removeAttribute("readonly");
        $('cboRuasTipo' + sId).style.backgroundColor = '#FFFFFF';

        var oRetorno = eval('(' + oAjax.responseText + ')');


        if (oRetorno.endereco != false) {

            var iNumReg = oRetorno.endereco.length;

            //if (iNumReg == 1) {

            me.clearAll(1);

            me.preencheCboEstados(oRetorno.estados, oRetorno.endereco[0].iestado);

            $('cboCodigoPais' + sId).value = oRetorno.endereco[0].ipais;
            //$('cboCodigoPais'+sId).style.backgroundColor = '#DEB887';
            //$('cboCodigoPais'+sId).disabled = true;
            me.setPais($F('cboCodigoPais' + sId));

            $('cboCodigoEstado' + sId).value = oRetorno.endereco[0].iestado;
            //$('cboCodigoEstado'+sId).disabled = true;
            //$('cboCodigoEstado'+sId).style.backgroundColor = '#DEB887';
            me.setEstado($F('cboCodigoEstado' + sId));

            $('cboCodigoMunicipio' + sId).value = oRetorno.endereco[0].imunicipio;
            //$('cboCodigoMunicipio'+sId).style.backgroundColor = '#DEB887';
            //$('cboCodigoMunicipio'+sId).disabled = true;
            me.setMunicipio($F('cboCodigoMunicipio' + sId));

            $('txtCodigoBairro' + sId).value = oRetorno.endereco[0].ibairro;
            //$('txtCodigoBairro'+sId).setAttribute("readonly", "readonly");
            //$('txtCodigoBairro'+sId).style.backgroundColor = '#DEB887';
            me.setBairro($F('txtCodigoBairro' + sId));

            $('txtDescrBairro' + sId).value = oRetorno.endereco[0].sbairro.urlDecode();
            //$('txtDescrBairro'+sId).setAttribute("readonly", "readonly");
            //$('txtDescrBairro'+sId).style.backgroundColor = '#DEB887';
            me.setNomeBairro($F('txtDescrBairro' + sId));

            $('txtCodigoRua' + sId).value = oRetorno.endereco[0].irua;
            //$('txtCodigoRua'+sId).setAttribute("readonly", "readonly");
            //$('txtCodigoRua'+sId).style.backgroundColor = '#DEB887';
            me.setRua($F('txtCodigoRua' + sId));

            $('txtDescrRua' + sId).value = oRetorno.endereco[0].srua.urlDecode();
            //$('txtDescrRua'+sId).setAttribute("readonly", "readonly");
            //$('txtDescrRua'+sId).style.backgroundColor = '#DEB887';
            me.setNomeRua($F('txtDescrRua' + sId));
            me.setRuasTipo(oRetorno.endereco[0].iruastipo);
            $('txtCepEnd' + sId).value = $F('txtCep' + sId);

            //$('txtCepEnd'+sId).setAttribute("readonly", "readonly");
            //$('txtCepEnd'+sId).style.backgroundColor = '#DEB887';
            me.setCepEndereco($F('txtCepEnd' + sId));
            me.oCboRuasTipo.setValue(oRetorno.endereco[0].iruatipo);

            /*} else {

            me.clearAll(1);

            }*/

        } else {

            alert('usuário:\n\n\Nenhum endereço retornado para o cep informado !\n\n');
            // $('txtCep' + sId).value = '';
            // me.clearAll(1);
            // me.setCodigoEndereco('');
            // me.buscaEndereco();
        }
    }

    $('txtCep' + sId).observe('change', me.pesquisaCep);

//-------------------------------------Início da Manipulação do Pais----------------------------------------------------

    this.changePais = function () {

        if ($('cboCodigoEstado' + sId).length != 0 && $('cboCodigoEstado' + sId).value != 0) {

            var sMessage = "usuário:\n\nDeseja alterar o País?";
            sMessage += "\n\nOs dados abaixo já preenchidos serão perdidos ! ";
            sMessage += "\n\nDeseja continuar ?";

            if (!confirm(sMessage)) {

                $('cboCodigoPais' + sId).value = me.getPais();
                return false;
            }

            me.clearAll(1);
        }

        me.findEstadoByCodigoPais();
    }

    me.oCboCodigoPais = new DBComboBox('cboCodigoPais' + sId, 'cboCodigoPais' + sId);
    me.oCboCodigoPais.addStyle('width', '100%');
    me.oCboCodigoPais.addEvent('onKeyPress', 'return js_mask(event, "0-9|")');
    me.oCboCodigoPais.show($('ctnCodigoPais' + sId));
    $('ctnCodigoPais' + sId).observe('change', me.changePais);


//-------------------------------------Fim Manipulação o Pais-----------------------------------------------------------
//-------------------------------------Início da Manipulação do Estado--------------------------------------------------

    /*
  *Cria o campo código do Estado
  */
    this.changeEstado = function () {

        if ($('cboCodigoMunicipio' + sId).length != '' && $('cboCodigoMunicipio' + sId).value != 0) {

            var sMessage = "usuário:\n\nDeseja alterar o Estado?";
            sMessage += "\n\nOs dados abaixo já preenchidos serão perdidos!";
            sMessage += "\n\nDeseja continuar ?";

            if (!confirm(sMessage)) {

                $('cboCodigoEstado' + sId).value = me.getEstado();
                return false;

            } else {
                me.clearAll(2);
            }
        }

        me.setEstado($F('cboCodigoEstado' + sId));
        me.findMunicipioByEstado();
    }

    me.oCboCodigoEstado = new DBComboBox('cboCodigoEstado' + sId, 'cboCodigoEstado' + sId);
    me.oCboCodigoEstado.addStyle('width', '100%');
    me.oCboCodigoEstado.addEvent('onKeyPress', 'return js_mask(event, "0-9|")');
    me.oCboCodigoEstado.show($('ctnCodigoEstado' + sId));
    $('ctnCodigoEstado' + sId).observe('change', me.changeEstado);

    this.findEstadoByCodigoPais = function () {

        $('cboCodigoEstado' + sId).options.length = 0;
        var oPesquisa = new Object();
        oPesquisa.exec = 'findEstadoByCodigoPais';
        oPesquisa.iCodigoPais = $F('cboCodigoPais' + sId);

        var msgDiv = "Aguarde carregando lista de estados.";
        js_divCarregando(msgDiv, 'msgBox');

        var oAjax = new Ajax.Request(
            me.sUrlRpc,
            {
                asynchronous: false,
                parameters: 'json=' + Object.toJSON(oPesquisa),
                method: 'post',
                onComplete: me.retornofindEstadoByCodigoPais
            }
        );
    }

    this.retornofindEstadoByCodigoPais = function (oAjax) {
        js_removeObj('msgBox');

        var oRetorno = eval('(' + oAjax.responseText + ')');

        if (oRetorno.status == 2) {

            alert('usuário:\n\nNenhum estado retornado para o País selecionado.\n\n');
            return false;
        }

        iEstado = -1;
        me.preencheCboEstados(oRetorno.itens, iEstado);
    }

//-------------------------------------Fim da Manipulação do Estado-----------------------------------------------------
//-------------------------------------Início da Manipulação do Municipio-----------------------------------------------

    this.findMunicipioByEstado = function () {

        if ($('cboCodigoEstado' + sId).length == 0) {
            return false;
        }

        var msgDiv = "Aguarde pesquisando município.";
        js_divCarregando(msgDiv, 'msgBox');

        /*
        * Função em ajax que realiza a busca do municipio pelo código informado
        */
        $('cboCodigoMunicipio' + sId).options.length = 0;
        var oPesquisa = new Object();
        oPesquisa.exec = 'findMunicipioByEstado';
        oPesquisa.iCodigoEstado = $F('cboCodigoEstado' + sId);

        var oAjax = new Ajax.Request(
            me.sUrlRpc,
            {
                asynchronous: false,
                parameters: 'json=' + Object.toJSON(oPesquisa),
                method: 'post',
                onComplete: me.retornofindMunicipioByEstado
            }
        );

    }

    this.retornofindMunicipioByEstado = function (oAjax) {
        js_removeObj("msgBox");
        var oRetorno = eval('(' + oAjax.responseText + ')');


        if (oRetorno.status == 2) {
            alert('usuário:\n\nNenhum municipio retornado para o estado selecionado.');
            return false;
        }

        var iMunicipio = '';

        if (oRetorno.iEstadoPadrao == $F('cboCodigoEstado' + sId)) {
            iMunicipio = oRetorno.iMunicipioPadrao;
        }

        me.preencheCboMunicipio(oRetorno.aMunicipios, iMunicipio);
    }

    this.preencheCboMunicipio = function (aValues, iCodigoMunicipio) {

        var iCodigoMunicipio = iCodigoMunicipio;
        var iNumMunicipios = aValues.length;

        me.oCboCodigoMunicipio.addItem(0, 'Selecione o município');

        for (var iInd = 0; iInd < iNumMunicipios; iInd++) {
            with (aValues[iInd]) {
                me.oCboCodigoMunicipio.addItem(codigo, descricao.urlDecode());
            }
        }

        if (iCodigoMunicipio != '') {

            me.oCboCodigoMunicipio.setValue(iCodigoMunicipio)
            me.setMunicipio(iCodigoMunicipio);
        }

        // let municipio = codigoMunicipio;
        // let estado = codigoEstado;

        // if(municipio && estado){
        //   console.log('1s ', municipio);
        //   console.log('2s ', estado);
        me.buscaDescricoes();
        //   codigoMunicipio = '';
        //   codigoEstado = '';
        // }

    }

    this.changeMunicipio = function () {

        if ($('txtCodigoBairro' + sId).value != '' || $('txtCodigoRua' + sId).value != '') {

            var sMessage = "Usuário:\n\nDeseja alterar o Município?";
            sMessage += "\n\nOs dados abaixo já preenchidos serão perdidos!";
            sMessage += "\n\nDeseja continuar ?";

            if (!confirm(sMessage)) {

                $('cboCodigoMunicipio' + sId).value = me.getMunicipio();
                return false;

            } else {
                me.clearAll(3);
            }
        }

        me.setMunicipio($F('cboCodigoMunicipio' + sId));

        // let municipio = document.getElementById('cboCodigoMunicipio'+sId).value;
        // let estado    = document.getElementById('cboCodigoEstado'+sId).value;
        me.buscaDescricoes();

    }

    me.oCboCodigoMunicipio = new DBComboBox('cboCodigoMunicipio' + sId, 'cboCodigoMunicipio' + sId);
    me.oCboCodigoMunicipio.addStyle('width', '100%');
    me.oCboCodigoMunicipio.addEvent('onKeyPress', 'return js_mask(event, "0-9|")');
    me.oCboCodigoMunicipio.show($('ctnCodigoMunicipio' + sId));
    $('ctnCodigoMunicipio' + sId).observe('change', me.changeMunicipio);


    /**
     * Seta o codigo do Municipio
     * @param {string} iCodigoMunicipio
     * @return void
     */
    this.setMunicipio = function (iCodigoMunicipio) {
        this.icodigoMunicipio = iCodigoMunicipio;
    }

    /**
     * Seta o codigo do Municipio
     * @return {string} codigo do municipio
     */
    this.getMunicipio = function () {
        return this.icodigoMunicipio;
    }

    /**
     * Seta a descricao do Municipio do endereco
     * @param {string} sNomeBairro
     * @return void
     */
    this.setNomeMunicipio = function (sNomeMunicipio) {
        this.sNomeMunicipio = sNomeMunicipio;
    }

    /**
     * Retorna a descricao do Municipio do endereco
     * @return void
     */
    this.getNomeMunicipio = function () {
        return this.sNomeMunicipio;
    }


    /*-------------------------------------Fim da Manipulação do Município------------------------------------------------*/

    /*-------------------------------------Início da Manipulação do Classes do Objeto ------------------------------------------------*/
    /**
     * Seta o valor do Classes do Objeto
     * @param {integer} iClassesObjeto
     * @return void
     */
    this.setClassesObjeto = function (iClassesObjeto) {
        this.iClassesObjeto = iClassesObjeto;
    }

    /**
     * Retorna o valor do Classes do Objeto
     * @return void
     */
    this.getClassesObjeto = function () {
        return this.iClassesObjeto;
    }

    this.changeClasseObjeto = (e) => {
        let valor = e.target.value;
        $('cboAtividadeObra' + sId).value = 0;
        me.setAtividadeObra(0);
        $('cboAtividadeServico' + sId).value = 0;
        me.setAtividadeServico(0);
        $('cboAtividadeServicoEsp' + sId).value = 0;
        me.setAtividadeServicoEspecializado(0);

        $('trAtividadeServico' + sId).style.display = 'none';
        $('txtDescrAtividadeServico' + sId).value = '';
        $('trAtividadeServicoEsp' + sId).style.display = 'none';
        $('txtDescrAtividadeServicoEsp' + sId).value = '';

        me.setClassesObjeto(valor);
        switch (valor) {
            case '1':
                $('cboAtividadeObra' + sId).disabled = false;
                $('cboAtividadeServico' + sId).disabled = true;
                $('cboAtividadeServicoEsp' + sId).disabled = true;
                break;
            case '2':
                $('cboAtividadeObra' + sId).disabled = true;
                $('cboAtividadeServico' + sId).disabled = false;
                $('cboAtividadeServicoEsp' + sId).disabled = true;
                break;
            case '3':
                $('cboAtividadeObra' + sId).disabled = true;
                $('cboAtividadeServico' + sId).disabled = true;
                $('cboAtividadeServicoEsp' + sId).disabled = false;
                break;
            default:
                $('cboAtividadeObra' + sId).disabled = true;
                $('cboAtividadeServico' + sId).disabled = true;
                $('cboAtividadeServicoEsp' + sId).disabled = true;
                break;
        }

        // if(valor == 1){
        //   // $('cboAtividadeObra'+sId).disabled = true;
        //   $('cboAtividadeObra'+sId).disabled = '';
        // }else{
        // }
    }

    me.oCboClasseObjeto = new DBComboBox('cboClasseObjeto' + sId, 'cboClasseObjeto' + sId);
    me.oCboClasseObjeto.addStyle('width', '90%');
    me.oCboClasseObjeto.show($('ctnClassesObjeto' + sId));
    me.oCboClasseObjeto.addItem(0, 'Selecione');
    me.oCboClasseObjeto.addItem(1, 'Obras');
    me.oCboClasseObjeto.addItem(2, 'Serviços');
    me.oCboClasseObjeto.addItem(3, 'Serviços técnicos especializados');
    $('ctnClassesObjeto' + sId).observe('change', me.changeClasseObjeto);


    /*-------------------------------------Fim da Manipulação do Classes do Objeto ------------------------------------------------*/
    /*-------------------------------------Início da Manipulação do Atividade da Obra ---------------------------------------------*/
    /**
     * Seta o valor da Atividade da Obra
     * @param {integer} iAtividadeObra
     * @return void
     */
    this.setAtividadeObra = function (iAtividadeObra) {
        this.iAtividadeObra = iAtividadeObra;
    }

    /**
     * Retorna o valor da Ativiadade Obra
     * @return void
     */
    this.getAtividadeObra = function () {
        return this.iAtividadeObra;
    }

    this.changeAtividadeObra = (e) => {
        me.setAtividadeObra(e.target.value);
    }

    me.oCboAtividadeObra = new DBComboBox('cboAtividadeObra' + sId, 'cboAtividadeObra' + sId);
    me.oCboAtividadeObra.addStyle('width', '90%');
    me.oCboAtividadeObra.show($('ctnAtividadeObra' + sId));
    me.oCboAtividadeObra.addItem(0, 'Selecione');
    me.oCboAtividadeObra.addItem(1, 'Ampliação');
    me.oCboAtividadeObra.addItem(2, 'Construção');
    me.oCboAtividadeObra.addItem(3, 'Fabricação');
    me.oCboAtividadeObra.addItem(4, 'Recuperação');
    me.oCboAtividadeObra.addItem(5, 'Reforma');
    me.oCboAtividadeObra.addItem(6, 'Restauração');
    $('ctnAtividadeObra' + sId).observe('change', me.changeAtividadeObra);
    $('cboAtividadeObra' + sId).disabled = true;


    /*-------------------------------------Fim da Manipulação do Atividade da Obra ---------------------------------------------*/
    /*-------------------------------------Início da Manipulação do Atividade do Serviço ---------------------------------------------*/
    /**
     * Seta o valor da Atividade do Serviço
     * @param {integer} iAtividadeServico
     * @return void
     */
    this.setAtividadeServico = function (iAtividadeServico) {
        this.iAtividadeServico = iAtividadeServico;
    }

    /**
     * Retorna o valor da Atividade do Servico
     * @return void
     */
    this.getAtividadeServico = function () {
        return this.iAtividadeServico;
    }

    this.limitaTamanho = (id, descricao) => {
        if (descricao.length > 150) {
            alert('É permitido a inserção de até 150 caracteres!');
            let novaString = descricao.substr(0, descricao.length - 2);
            $(id).value = novaString;
        }
    }

    this.changeAtividadeServico = (e) => {
        let elemento = e.target;
        let mostra = elemento.value == '99' ? '' : 'none';
        document.getElementById('trAtividadeServico' + sId).style.display = mostra;
        document.getElementById('txtDescrAtividadeServico' + sId).observe('keypress', () => {
            me.limitaTamanho('txtDescrAtividadeServico' + sId, $('txtDescrAtividadeServico' + sId).value);
        });
        me.setAtividadeServico(elemento.value);
    }

    /* Combo Atividade do Serviço */
    me.oCboAtividadeServico = new DBComboBox('cboAtividadeServico' + sId, 'cboAtividadeServico' + sId);
    me.oCboAtividadeServico.addStyle('width', '90%');
    me.oCboAtividadeServico.show($('ctnAtividadeServico' + sId));
    me.oCboAtividadeServico.addItem(0, 'Selecione');
    me.oCboAtividadeServico.addItem(1, 'Adaptação');
    me.oCboAtividadeServico.addItem(2, 'Conserto');
    me.oCboAtividadeServico.addItem(3, 'Conservação');
    me.oCboAtividadeServico.addItem(4, 'Demolição');
    me.oCboAtividadeServico.addItem(5, 'Instalação');
    me.oCboAtividadeServico.addItem(6, 'Manutenção');
    me.oCboAtividadeServico.addItem(7, 'Montagem');
    me.oCboAtividadeServico.addItem(8, 'Operação');
    me.oCboAtividadeServico.addItem(9, 'Reparação');
    me.oCboAtividadeServico.addItem(10, 'Transporte');
    me.oCboAtividadeServico.addItem(99, 'Outros');
    $('ctnAtividadeServico' + sId).observe('change', me.changeAtividadeServico);
    $('cboAtividadeServico' + sId).disabled = true;

    /*-------------------------------------Fim da Manipulação do Atividade do Serviço ---------------------------------------------*/
    /*-------------------------------------Início da Manipulação do Atividade do Serviço Especializado ---------------------------------------------*/
    /**
     * Seta o valor da Atividade do Serviço Especializado
     * @param {integer} iAtividadeServicoEspecializado
     * @return void
     */
    this.setAtividadeServicoEspecializado = function (iAtividadeServicoEspecizalizado) {
        this.iAtividadeServicoEspecializado = iAtividadeServicoEspecizalizado;
    }

    /**
     * Retorna o valor da Atividade do Serviço Especializado
     * @return void
     */
    this.getAtividadeServicoEspecializado = function () {
        return this.iAtividadeServicoEspecializado;
    }

    this.changeAtividadeServicoEspec = (e) => {
        let elemento = e.target;
        let mostra = elemento.value == '99' ? '' : 'none';
        document.getElementById('trAtividadeServicoEsp' + sId).style.display = mostra;
        $('txtDescrAtividadeServicoEsp' + sId).observe('keypress', () => {
            let descricao = $('txtDescrAtividadeServicoEsp' + sId).value;
            let idElemento = 'txtDescrAtividadeServicoEsp' + sId;
            me.limitaTamanho(idElemento, descricao);
        });
        me.setAtividadeServicoEspecializado(elemento.value);
    }

    /* Combo Atividade dos Serviços Especializados */
    me.oCboAtividadeServicoEsp = new DBComboBox('cboAtividadeServicoEsp' + sId, 'cboAtividadeServicoEsp' + sId);
    me.oCboAtividadeServicoEsp.addStyle('width', '90%');
    me.oCboAtividadeServicoEsp.show($('ctnAtividadeServEsp' + sId));
    me.oCboAtividadeServicoEsp.addItem(0, 'Selecione');
    me.oCboAtividadeServicoEsp.addItem(1, 'Projeto e Planejamento');
    me.oCboAtividadeServicoEsp.addItem(2, 'Estudo técnico');
    me.oCboAtividadeServicoEsp.addItem(3, 'Parecer');
    me.oCboAtividadeServicoEsp.addItem(4, 'Perícia');
    me.oCboAtividadeServicoEsp.addItem(5, 'Avaliação');
    me.oCboAtividadeServicoEsp.addItem(6, 'Assessoria');
    me.oCboAtividadeServicoEsp.addItem(7, 'Consultoria');
    me.oCboAtividadeServicoEsp.addItem(8, 'Auditoria');
    me.oCboAtividadeServicoEsp.addItem(9, 'Fiscalização');
    me.oCboAtividadeServicoEsp.addItem(10, 'Supervisão');
    me.oCboAtividadeServicoEsp.addItem(11, 'Gerenciamento');
    me.oCboAtividadeServicoEsp.addItem(99, 'Outros');
    $('ctnAtividadeServEsp' + sId).observe('change', me.changeAtividadeServicoEspec);
    $('cboAtividadeServicoEsp' + sId).disabled = true;
    /*-------------------------------------Fim da Manipulação do Atividade do Serviço Especializado ---------------------------------------------*/
    /*-------------------------------------Início da Manipulação do Grupo Bem Público-------------- ---------------------------------------------*/
    /**
     * Seta o valor do Grupo Bem Público
     * @param {integer} iGrupoBemPublico
     * @return void
     */
    this.setGrupoBemPublico = function (iGrupoBemPublico) {
        this.iGrupoBemPublico = iGrupoBemPublico;
    }

    /**
     * Retorna o valor do Grupo Bem Público
     * @return void
     */
    this.getGrupoBemPublico = function () {
        return this.iGrupoBemPublico;
    }

    this.preencheSubGrupo = function (valor) {

        me.oCboSubGrupoBemPub.clearItens();
        me.oCboSubGrupoBemPub.addItem(0, 'Selecione');
        $('cboSubGrupoBemPub'+sId).disabled = false;

        switch (valor) {
            case '4':
                me.oCboSubGrupoBemPub.addItem(401, 'Sedes dos poderes executivo, legislativo e judiciário (Palácio do Governo, Prefeitura, Câmara, Fórum etc.)');
                me.oCboSubGrupoBemPub.addItem(402, 'Sedes das Secretarias, Fundações, Autarquias, Empresas Públicas e de Economia Mista.');
                me.oCboSubGrupoBemPub.addItem(403, 'Almoxarifados');
                me.oCboSubGrupoBemPub.addItem(404, 'Oficinas');
                me.oCboSubGrupoBemPub.addItem(405, 'Pátio de manutenção de equipamentos');
                me.oCboSubGrupoBemPub.addItem(406, 'Unidade Fazendárias');
                break;

            case '6':
                me.oCboSubGrupoBemPub.addItem(601, 'Corpo de bombeiros');
                me.oCboSubGrupoBemPub.addItem(602, 'Delegacia');
                me.oCboSubGrupoBemPub.addItem(603, 'Instalações militares');
                me.oCboSubGrupoBemPub.addItem(604, 'Posto policial');
                me.oCboSubGrupoBemPub.addItem(605, 'Posto de salvamento');
                me.oCboSubGrupoBemPub.addItem(606, 'Instituto Médico Legal');
                me.oCboSubGrupoBemPub.addItem(607, 'Menor Infrator');
                me.oCboSubGrupoBemPub.addItem(608, 'Unidade Prisional');
                me.oCboSubGrupoBemPub.addItem(609, 'Cadeia Pública');
                me.oCboSubGrupoBemPub.addItem(610, 'Penitenci?rias');
                break;

            case '8':
                me.oCboSubGrupoBemPub.addItem(801, 'Asilo');
                me.oCboSubGrupoBemPub.addItem(802, 'Centro social, comunitário');
                me.oCboSubGrupoBemPub.addItem(803, 'Centro de triagem');
                me.oCboSubGrupoBemPub.addItem(804, 'Creche');
                me.oCboSubGrupoBemPub.addItem(805, 'Orfanato');
                me.oCboSubGrupoBemPub.addItem(806, 'Reformatório');
                me.oCboSubGrupoBemPub.addItem(807, 'Salão de Idoso');
                break;

            case '10':
                me.oCboSubGrupoBemPub.addItem(1001, 'Ambulatório');
                me.oCboSubGrupoBemPub.addItem(1002, 'Hospital');
                me.oCboSubGrupoBemPub.addItem(1003, 'Centro de saúde');
                me.oCboSubGrupoBemPub.addItem(1004, 'Posto de saúde');
                me.oCboSubGrupoBemPub.addItem(1005, 'Unidade básica de saúde - UBS');
                me.oCboSubGrupoBemPub.addItem(1006, 'Unidade de pronto atendimento - UPA');
                me.oCboSubGrupoBemPub.addItem(1007, 'Farmácia');
                me.oCboSubGrupoBemPub.addItem(1008, 'Centro Cirúrgico');
                me.oCboSubGrupoBemPub.addItem(1009, 'Clínica');
                me.oCboSubGrupoBemPub.addItem(1010, 'Policlínica');
                me.oCboSubGrupoBemPub.addItem(1011, 'Laboratório');
                me.oCboSubGrupoBemPub.addItem(1012, 'Centro de Pesquisas');
                break;

            case '12':
                me.oCboSubGrupoBemPub.addItem(1201, 'Colégio');
                me.oCboSubGrupoBemPub.addItem(1202, 'Escola');
                me.oCboSubGrupoBemPub.addItem(1203, 'Escola técnica');
                me.oCboSubGrupoBemPub.addItem(1204, 'Faculdade');
                me.oCboSubGrupoBemPub.addItem(1205, 'Universidade');
                me.oCboSubGrupoBemPub.addItem(1206, 'Escola de Aperfeiçoamento');
                me.oCboSubGrupoBemPub.addItem(1207, 'Pré-escola');
                me.oCboSubGrupoBemPub.addItem(1208, 'Pós-graduação');
                break;

            case '13':
                me.oCboSubGrupoBemPub.addItem(1301, 'Biblioteca');
                me.oCboSubGrupoBemPub.addItem(1302, 'Cemitério e crematório');
                me.oCboSubGrupoBemPub.addItem(1303, 'Centro cultural');
                me.oCboSubGrupoBemPub.addItem(1304, 'Centro de convenção');
                me.oCboSubGrupoBemPub.addItem(1305, 'Cinema');
                me.oCboSubGrupoBemPub.addItem(1306, 'Concha acústica');
                me.oCboSubGrupoBemPub.addItem(1307, 'Jardim botânico, jardim zoológico, horto florestal');
                me.oCboSubGrupoBemPub.addItem(1308, 'Museu');
                me.oCboSubGrupoBemPub.addItem(1309, 'Teatro');
                me.oCboSubGrupoBemPub.addItem(1310, 'Templo');
                me.oCboSubGrupoBemPub.addItem(1311, 'Igreja');
                me.oCboSubGrupoBemPub.addItem(1312, 'Patrimônio Histórico');
                me.oCboSubGrupoBemPub.addItem(1313, 'Conventos');
                break;

            case '15':
                me.oCboSubGrupoBemPub.addItem(1501, 'Estacionamento');
                me.oCboSubGrupoBemPub.addItem(1502, 'Logradouros públicos e vias especiais');
                me.oCboSubGrupoBemPub.addItem(1503, 'Terminais e estações do sistema de transporte em suas diversas modalidades');
                me.oCboSubGrupoBemPub.addItem(1504, 'Passeios Públicos');
                me.oCboSubGrupoBemPub.addItem(1505, 'Passarelas');
                break;
            case '16':
                me.oCboSubGrupoBemPub.addItem(1601, 'Casas Populares');
                me.oCboSubGrupoBemPub.addItem(1602, 'Unidades Habitacionais');
                break;
            case '17':
                me.oCboSubGrupoBemPub.addItem(1701, 'Estação de captação, bombeamento e adutora de água');
                me.oCboSubGrupoBemPub.addItem(1702, 'Estação de tratamento de água');
                me.oCboSubGrupoBemPub.addItem(1703, 'Rede de distribuição de água');
                me.oCboSubGrupoBemPub.addItem(1704, 'Estação de tratamento de esgoto');
                me.oCboSubGrupoBemPub.addItem(1705, 'Rede de esgotamento sanitário');
                me.oCboSubGrupoBemPub.addItem(1706, 'Drenagem pluvial');
                me.oCboSubGrupoBemPub.addItem(1707, 'Limpeza urbana');
                me.oCboSubGrupoBemPub.addItem(1708, 'Sistemas de tratamento de resíduos sólidos, incluindo aterros sanitários e usinas de compostagem');
                me.oCboSubGrupoBemPub.addItem(1709, 'Unidades de reciclagem');
                me.oCboSubGrupoBemPub.addItem(1710, 'Lavanderia coletiva');
                me.oCboSubGrupoBemPub.addItem(1711, 'Barragens');
                me.oCboSubGrupoBemPub.addItem(1712, 'Açudes');
                me.oCboSubGrupoBemPub.addItem(1713, 'Galerias');
                me.oCboSubGrupoBemPub.addItem(1714, 'Canalização de Esgoto');
                me.oCboSubGrupoBemPub.addItem(1715, 'Módulos Sanitários');
                me.oCboSubGrupoBemPub.addItem(1716, 'Sanitários Públicos');
                me.oCboSubGrupoBemPub.addItem(1717, 'Matadouros');
                me.oCboSubGrupoBemPub.addItem(1718, 'Poços Artesianos');
                me.oCboSubGrupoBemPub.addItem(1719, 'Nascentes, Fontes e Chafarizes');
                break;
            case '20':
                me.oCboSubGrupoBemPub.addItem(2001, 'Armazém ou silo');
                me.oCboSubGrupoBemPub.addItem(2002, 'Central de abastecimento');
                me.oCboSubGrupoBemPub.addItem(2003, 'Mercado municipal');
                me.oCboSubGrupoBemPub.addItem(2004, 'Supermercado');
                me.oCboSubGrupoBemPub.addItem(2005, 'Feira Coberta');
                me.oCboSubGrupoBemPub.addItem(2006, 'Irrigação');
                me.oCboSubGrupoBemPub.addItem(2007, 'Canal de Irrigação');
                break;
            case '24':
                me.oCboSubGrupoBemPub.addItem(2401, 'Correios e telégrafos');
                me.oCboSubGrupoBemPub.addItem(2402, 'Rádio e televisão');
                me.oCboSubGrupoBemPub.addItem(2403, 'Telefonia');
                me.oCboSubGrupoBemPub.addItem(2404, 'Internet');
                me.oCboSubGrupoBemPub.addItem(2405, 'Redes');
                me.oCboSubGrupoBemPub.addItem(2406, 'Antenas');
                break;
            case '25':
                me.oCboSubGrupoBemPub.addItem(2501, 'Usinas hidrelétricas, termoelétricas, eólicas e nucleares');
                me.oCboSubGrupoBemPub.addItem(2502, 'Gasodutos e oleodutos');
                me.oCboSubGrupoBemPub.addItem(2503, 'Rede de distribuição urbana - RDU');
                me.oCboSubGrupoBemPub.addItem(2504, 'Rede de distribuição rural - RDR');
                me.oCboSubGrupoBemPub.addItem(2505, 'Energia elétrica');
                me.oCboSubGrupoBemPub.addItem(2506, 'Linha de transmissão');
                me.oCboSubGrupoBemPub.addItem(2507, 'Subestação de energia elétrica');
                me.oCboSubGrupoBemPub.addItem(2508, 'Combustível doméstico canalizado');
                me.oCboSubGrupoBemPub.addItem(2509, 'Iluminação Pública');
                me.oCboSubGrupoBemPub.addItem(2510, 'Postos de Abastecimento de veículos, máquinas e equipamentos');
                me.oCboSubGrupoBemPub.addItem(2511, 'Barragens');
                break;
            case '26':
                me.oCboSubGrupoBemPub.addItem(2601, 'Rodovias');
                me.oCboSubGrupoBemPub.addItem(2602, 'Ferrovias');
                me.oCboSubGrupoBemPub.addItem(2603, 'Aeroportos');
                me.oCboSubGrupoBemPub.addItem(2604, 'Portos');
                me.oCboSubGrupoBemPub.addItem(2605, 'Hidrovias');
                me.oCboSubGrupoBemPub.addItem(2606, 'Canais');
                me.oCboSubGrupoBemPub.addItem(2607, 'Pontes e viadutos');
                me.oCboSubGrupoBemPub.addItem(2608, 'Mata burro');
                me.oCboSubGrupoBemPub.addItem(2609, 'Túneis');
                me.oCboSubGrupoBemPub.addItem(2610, 'Muros de arrimo e obras de contenção');
                me.oCboSubGrupoBemPub.addItem(2611, 'Canal fluvial');
                me.oCboSubGrupoBemPub.addItem(2612, 'Passarelas em rodovias');
                me.oCboSubGrupoBemPub.addItem(2613, 'Obras de arte correntes');
                me.oCboSubGrupoBemPub.addItem(2614, 'Obras de arte especiais');
                me.oCboSubGrupoBemPub.addItem(2615, 'Metrô');
                me.oCboSubGrupoBemPub.addItem(2616, 'Transporte vertical - Elevadores');
                me.oCboSubGrupoBemPub.addItem(2617, 'Hangar');
                break;
            case '27':
                me.oCboSubGrupoBemPub.addItem(2701, 'Autódromo, kartódromo');
                me.oCboSubGrupoBemPub.addItem(2702, 'Campo e pista de esporte');
                me.oCboSubGrupoBemPub.addItem(2703, 'Clube');
                me.oCboSubGrupoBemPub.addItem(2704, 'Estádio');
                me.oCboSubGrupoBemPub.addItem(2705, 'Ginásio de esporte');
                me.oCboSubGrupoBemPub.addItem(2706, 'Hipódromo');
                me.oCboSubGrupoBemPub.addItem(2707, 'Marina');
                me.oCboSubGrupoBemPub.addItem(2708, 'Piscina pública');
                me.oCboSubGrupoBemPub.addItem(2709, 'Parque');
                me.oCboSubGrupoBemPub.addItem(2710, 'Praça');
                me.oCboSubGrupoBemPub.addItem(2711, 'Ciclovias');
                me.oCboSubGrupoBemPub.addItem(2712, 'Parque Aquático');
                me.oCboSubGrupoBemPub.addItem(2713, 'Unidade Desportiva');
                me.oCboSubGrupoBemPub.addItem(2714, 'Academias');
                me.oCboSubGrupoBemPub.addItem(2715, 'Pista de Skate');
                me.oCboSubGrupoBemPub.addItem(2716, 'Quadra');
                me.oCboSubGrupoBemPub.addItem(2717, 'Hotel');
                me.oCboSubGrupoBemPub.addItem(2718, 'Quadra Poliesportiva');
                break;
            case '99':
                $('cboSubGrupoBemPub'+sId).disabled = true;
                break;
            default:
                break;
        }
    }

    this.changeGrupoBemPub = function (e) {
        let valor = e.target.value;
        me.setGrupoBemPublico(valor);
        me.preencheSubGrupo(valor);
    }
    /*-------------------------------------Fim da Manipulação do Grupo Bem Público-------------- ---------------------------------------------*/
    /*-------------------------------------Início da Manipulação do SubGrupo Bem Público-------------- ---------------------------------------------*/

    /**
     * Seta o valor do SubGrupo Bem Público
     * @param {integer} iSubGrupoBemPublico
     * @return void
     */
    this.setSubGrupoBemPublico = function (iSubGrupoBemPublico) {
        this.iSubGrupoBemPublico = iSubGrupoBemPublico;
    }

    /**
     * Retorna o valor do SubGrupo Bem Público
     * @return void
     */
    this.getSubGrupoBemPublico = function () {
        return this.iSubGrupoBemPublico;
    }

    this.changeSubGrupoBemPub = (e) => {
        me.setSubGrupoBemPublico(e.target.value);
    }

    me.oCboSubGrupoBemPub = new DBComboBox('cboSubGrupoBemPub' + sId, 'cboSubGrupoBemPub' + sId);
    me.oCboSubGrupoBemPub.addStyle('width', '100%');
    me.oCboSubGrupoBemPub.show($('ctnSubGrupoBemPublico' + sId));
    me.oCboSubGrupoBemPub.addItem(0, 'Selecione');
    $('ctnSubGrupoBemPublico' + sId).observe('change', me.changeSubGrupoBemPub);

    /* Combo Grupo Bem Público */
    me.oCboGrupoBemPub = new DBComboBox('cboGrupoBemPub' + sId, 'cboGrupoBemPub' + sId);
    me.oCboGrupoBemPub.addStyle('width', '100%');
    me.oCboGrupoBemPub.show($('ctnGrupoBemPublico' + sId));
    me.oCboGrupoBemPub.addItem(0, 'Selecione');
    me.oCboGrupoBemPub.addItem(4, 'Definição do bem público administração pública');
    me.oCboGrupoBemPub.addItem(6, 'Definição do bem público segurança pública');
    me.oCboGrupoBemPub.addItem(8, 'Definição do bem público da assistência social');
    me.oCboGrupoBemPub.addItem(10, 'Definição do bem público da saúde');
    me.oCboGrupoBemPub.addItem(12, 'Definição do bem público da educação');
    me.oCboGrupoBemPub.addItem(13, 'Definição do bem público de cultura');
    me.oCboGrupoBemPub.addItem(15, 'Definição do bem público de urbanismo');
    me.oCboGrupoBemPub.addItem(16, 'Definição do bem público de habitação');
    me.oCboGrupoBemPub.addItem(17, 'Definição do bem público de saneamento');
    me.oCboGrupoBemPub.addItem(20, 'Definição do bem público para agricultura');
    me.oCboGrupoBemPub.addItem(24, 'Definição do bem público para comunicação');
    me.oCboGrupoBemPub.addItem(25, 'Definição do bem público para energia');
    me.oCboGrupoBemPub.addItem(26, 'Definição do bem público para transportes');
    me.oCboGrupoBemPub.addItem(27, 'Definição do bem público de desporto e lazer');
    me.oCboGrupoBemPub.addItem(99, 'Definição do bem público');
    $('ctnGrupoBemPublico' + sId).observe('change', me.changeGrupoBemPub);

    /*-------------------------------------Início da Manipulação do SubGrupo Bem Público-------------- ---------------------------------------------*/
    /*-------------------------------------Início da Manipulação do Código do IBGE------------------------------------------------*/


    this.findCodigoIbge = function (municipio, estado) {
        /*
        * Função em ajax que realiza a busca do Código do IBGE
        */

        var aMunic = document.getElementById('cboCodigoMunicipio' + sId).options;
        var oParam = new Object();
        oParam.cidade = municipio;
        oParam.estado = estado;
        oParam.exec = 'getCodigoIbge'

        var oAjax = new Ajax.Request(
            sUrlRpc,
            {
                asynchronous: false,
                parameters: 'json=' + Object.toJSON(oParam),
                method: 'post',
                onComplete: me.retornofindCodigoIbge
            }
        );
    }

    this.retornofindCodigoIbge = function (obj) {
        oRetorno = eval('(' + obj.responseText + ')');
        me.oTxtCodigoIbge.setValue(oRetorno);
    }

    me.oTxtCodigoIbge = new DBTextField('txtCodigoIbge' + sId, 'txtCodigoIbge' + sId, '');
    me.oTxtCodigoIbge.addEvent('onKeyUp', "js_ValidaCampos(this,1,\"Campo Código do IBGE\",\"f\",\"f\",event)");
    me.oTxtCodigoIbge.addStyle('width', '100%');
    me.oTxtCodigoIbge.setMaxLength(6);
    me.oTxtCodigoIbge.show($('ctnCodigoIbge' + sId));

    /**
     *Seta o Código do IBGE
     *@param {varchar} iCodigoIbge
     *@return void
     */

    this.setCodigoIbge = function (iCodigoIbge) {
        this.iCodigoIbge = iCodigoIbge;
    }
    /**
     *Retorna o Código do IBGE
     *@return {varchar} com o código do IBGE
     */
    this.getCodigoIbge = function () {
        return this.iCodigoIbge;
    }

    /*-------------------------------------Fim do Código IBGE------------------------------------------------*/
    /*-------------------------------------Início da Manipulação do Bairro------------------------------------------------*/

    /*
    *Metodo para pesquisa da descrição do Bairro pelo codigo
    */
    this.findBairroByCodigo = function () {
        /*
    * Validação para verificar se o usuario ja preencheu o cadastro
    * e esta realizando modificações ent?o exibe alerta na tela.
    */
        if ($('txtCodigoRua' + sId).value != '') {

            var sMessage = "usuário:\n\nDeseja alterar o Bairro ? ";
            sMessage += "\n\n Os dados abaixo já preenchidos serão perdidos ! ";
            sMessage += "\n\n Deseja continuar ?";
            if (!confirm(sMessage)) {
                $('txtCodigoBairro' + sId).value = me.getBairro();
                $('txtDescrBairro' + sId).value = me.getNomeBairro();
                return false;
            } else {
                me.setBairro('');
                me.setNomeBairro('');
                me.clearAll(3);
            }
        }
        //se vazio retorna sem executar a pesquisa
        if ($F('txtCodigoBairro' + sId).trim() == '') {
            $('txtDescrBairro' + sId).value = '';
            me.setBairro('');
            me.setNomeBairro('');
            return false;
        }
        //valida se esta preenchido o codigo do municipio
        if ($F('cboCodigoMunicipio' + sId) == '') {

            $('cboCodigoMunicipio' + sId).value = '';
            return false;
        }

        var msgDiv = "Aguarde pesquisando bairro pelo código.";
        js_divCarregando(msgDiv, 'msgBox');


        var oPesquisa = new Object();
        oPesquisa.exec = 'findBairroByCodigo';
        oPesquisa.iCodigoBairro = $F('txtCodigoBairro' + sId);
        oPesquisa.iCodigoMunicipio = $F('cboCodigoMunicipio' + sId);

        var oAjax = new Ajax.Request(
            me.sUrlRpc,
            {
                parameters: 'json=' + Object.toJSON(oPesquisa),
                method: 'post',
                onComplete: me.retornofindBairroByCodigo
            }
        );
    }

    this.retornofindBairroByCodigo = function (oAjax) {

        js_removeObj("msgBox");

        var oRetorno = eval('(' + oAjax.responseText + ')');

        if (!oRetorno.sNomeBairro) {

            $('txtDescrBairro' + sId).value = 'Código (' + $F('txtCodigoBairro' + sId) + ') não encontrado!';
            $('txtCodigoBairro' + sId).value = '';
            $('txtCodigoBairro' + sId).focus();
            me.setBairro('');
            me.setNomeBairro('');

        } else {

            $('txtDescrBairro' + sId).value = oRetorno.sNomeBairro.urlDecode();
            me.setBairro($F('txtCodigoBairro' + sId));
            me.setNomeBairro($F('txtDescrBairro' + sId));

        }
    }

    /*
    *Cria o campo código do  Bairro
    */
    me.oTxtCodigoBairro = new DBTextField('txtCodigoBairro' + sId, 'txtCodigoBairro' + sId, '');
    me.oTxtCodigoBairro.addStyle('width', '100%');
    //me.oTxtCodigoBairro.addEvent('onKeyPress', 'return js_mask(event, "0-9|")');
    me.oTxtCodigoBairro.addEvent('onKeyUp', "js_ValidaCampos(this,1,\"Campo Bairro\",\"f\",\"f\",event)");
    me.oTxtCodigoBairro.show($('ctnCodigoBairro' + sId));
    $('txtCodigoBairro' + sId).observe('change', me.findBairroByCodigo);

    /**
     *Método para detectar a mudanca no campo Descricao do Bairro
     *@private
     *@return void
     */
    this.changeDescrBairro = function () {

        if ($('txtCodigoRua' + sId).value != '' && me.oTxtCodigoBairro.getValue() != '') {

            var sMessage = "Usuário:\n\nDeseja alterar o Bairro ? ";
            sMessage += "\n\nOs dados abaixo já preenchidos serão perdidos ! ";
            sMessage += "\n\nDeseja continuar ?";

            /**
             *1º caso: usuário cancelou a modifica?ao
             */
            if (!confirm(sMessage)) {

                /*
                * Voltar os dados conforme propriedade da classe
                */
                $('txtDescrBairro' + sId).value = me.getNomeBairro();
                $('txtCodigoBairro' + sId).value = me.getBairro();
                me.setRuasTipo(me.getRuaTipo());
                me.iBairroAutomatico = false;
                return false;

            } else if (me.iBairroAutomatico) {

                me.setBairro($('txtCodigoBairro' + sId).value);
                me.setNomeBairro($('txtDescrBairro' + sId).value);
                me.iBairroAutomatico = false;
            } else {

                me.setBairro('');
                $('txtCodigoBairro' + sId).value = '';
                me.setNomeBairro($('txtDescrBairro' + sId).value);
                me.iBairroAutomatico = false;

            }
            me.clearAll(4);

        } else if (me.iBairroAutomatico) {

            me.setNomeBairro($('txtDescrBairro' + sId).value);
            me.setBairro($('txtCodigoBairro' + sId).value);
            me.setRuasTipo(me.oCboRuasTipo.getValue());
            me.iBairroAutomatico = false;
        } else {

            me.setNomeBairro($('txtDescrBairro' + sId).value);
            me.setBairro('');
            $('txtCodigoBairro' + sId).value = '';
            me.setRuasTipo(me.oCboRuasTipo.getValue());
            me.iBairroAutomatico = false;
        }
        $('txtDescrBairro' + sId).value = $F('txtDescrBairro' + sId).toUpperCase();
        me.iBairroAutomatico = false;
    }

    /*
    *Cria o campo descrição do Bairro
    */
    me.oTxtDescrBairro = new DBTextField('txtDescrBairro' + sId, 'txtDescrBairro' + sId, '');
    me.oTxtDescrBairro.addStyle('width', '100%');
    me.oTxtDescrBairro.show($('ctnDescrBairro' + sId));
    me.oTxtDescrBairro.addEvent('onKeyUp', "js_ValidaCampos(this,2,\"Campo Bairro\",\"f\",\"t\",event)");
    // $('txtDescrBairro' + sId).observe('change', me.changeDescrBairro);
    /*
    *Função para realizar a busca pelo autocomplete do Bairro
    */
    // var sUrl = this.sUrlRpc;
    // var oParam = new Object();
    // oAutoCompleteBairro = new dbAutoComplete($('txtDescrBairro' + sId), sUrl);
    // oAutoCompleteBairro.setTxtFieldId($('txtCodigoBairro' + sId));
    // oAutoCompleteBairro.show();
    // oAutoCompleteBairro.setQueryStringFunction(function () {
    //     /*
    //     *Função para validar se deve disparar a busca do autocomplete
    //     */
    //     oAutoCompleteBairro.setValidateFunction(function () {
    //
    //         if (($F('cboCodigoMunicipio' + sId).trim() == '')) {
    //             return false;
    //         } else {
    //             return true;
    //         }
    //     });
    //     oParam.exec = 'findBairroByName';
    //     oParam.iCodigoEstado = $F('cboCodigoEstado' + sId);
    //     oParam.iCodigoMunicipio = $F('cboCodigoMunicipio' + sId).trim();
    //     oParam.sQuery = $F('txtDescrBairro' + sId);
    //     sQuery = 'json=' + Object.toJSON(oParam);
    //     return sQuery;
    // });
    /**
     *Seta o codigo do bairro
     *@param {string} iCodigoBairro
     *@return void
     */
    this.setBairro = function (iCodigoBairro) {

        this.iCodigoBairro = iCodigoBairro;
    }
    /**
     *Retorna o codigo do bairro
     *@return {string} codigo do bairro
     */
    this.getBairro = function () {
        return this.iCodigoBairro;
    }


    // oAutoCompleteBairro.setCallBackFunction(function (id, label) {
    //
    //     me.oTxtCodigoBairro.setValue(id);
    //     me.oTxtDescrBairro.setValue(label);
    //     me.findComplementoBairro(id);
    // });

    /**
     *Metodo utilizado para buscar os dados complementares do bairro e preencher os campos acima dele
     */
    this.findComplementoBairro = function (id) {

        var oRua = new Object();
        oRua.exec = 'findComplementoBairro';
        oRua.iCodigoBairro = id;

        var msgDiv = "Aguarde ...";
        js_divCarregando(msgDiv, 'msgBox');

        var oAjax = new Ajax.Request(
            me.sUrlRpc,
            {
                parameters: 'json=' + Object.toJSON(oRua),
                method: 'post',
                onComplete: me.retornofindComplementoBairro
            }
        );

    }

    this.retornofindComplementoBairro = function (oAjax) {

        js_removeObj("msgBox");

        var oRetorno = eval('(' + oAjax.responseText + ')');
        if (oRetorno.status == 2) {

            alert('Falha ao retornar os complementos.');
            me.iBairroAutomatico = false;
        } else {

            if ($F('cboCodigoMunicipio' + sId) == '') {

                $('cboCodigoMunicipio' + sId).value = oRetorno[0].icodigomunicipio;
                me.setMunicipio($F('cboCodigoMunicipio' + sId));
                me.iBairroAutomatico = true;
            }

            $('txtCodigoBairro' + sId).value = oRetorno[0].icodigobairro;
            $('txtDescrBairro' + sId).value = oRetorno[0].sdescrbairro.urlDecode();
            me.iBairroAutomatico = true;
        }
    }

//-------------------------------------Fim da Manipulação do Bairro-----------------------------------------------------
//-------------------------------------Início da Manipulação da Rua-----------------------------------------------------
    /**
     *Metodo para pesquisa a descrição da Rua pelo codigo
     */
    this.findRuaByCodigo = function () {

        if ($F('txtCodigoNumero' + sId) != '') {

            var sMessage = "Usuário:\n\nDeseja alterar a Rua ? ";
            sMessage += "\n\nOs dados abaixo já preenchidos serão perdidos ! ";
            sMessage += "\n\nDeseja continuar ?";

            if (!confirm(sMessage)) {

                $('txtCodigoRua' + sId).value = me.getRua();
                return false;
            }

            $('txtDescrRua' + sId).value = '';
            me.clearAll(5);
        }

        if ($F('txtCodigoRua' + sId).trim() == '') {

            $('txtDescrRua' + sId).value = '';
            me.setNomeRua('');
            me.setRua('');
            me.oCboRuasTipo.setEnable();
            //me.oCboRuasTipo.setValue(3);

            return false;
        }

        var oPesquisa = new Object();
        oPesquisa.exec = 'findRuaByCodigo';
        oPesquisa.iCodigoRua = $F('txtCodigoRua' + sId);
        oPesquisa.iCodigoMunicipio = $F('cboCodigoMunicipio' + sId);

        var msgDiv = "Aguarde pesquisando rua pelo código.";
        js_divCarregando(msgDiv, 'msgBox');

        var oAjax = new Ajax.Request(
            me.sUrlRpc,
            {
                parameters: 'json=' + Object.toJSON(oPesquisa),
                method: 'post',
                onComplete: me.retornofindRuaByCodigo
            }
        );
    }

    this.retornofindRuaByCodigo = function (oAjax) {

        js_removeObj("msgBox");

        var oRetorno = eval('(' + oAjax.responseText + ')');

        if (!oRetorno.dados) {

            $('txtDescrRua' + sId).value = 'Código (' + $F('txtCodigoRua' + sId) + ') não encontrado!';
            $('txtCodigoRua' + sId).value = '';
            $('txtCodigoRua' + sId).focus();
            me.setRua('');
            me.setNomeRua('');
            me.oCboRuasTipo.setEnable();
        } else {

            $('txtDescrRua' + sId).value = oRetorno.dados[0].db74_descricao.urlDecode();
            me.setRua($F('txtCodigoRua' + sId));
            me.setNomeRua($F('txtDescrRua' + sId));
            me.setRuasTipo(oRetorno.dados[0].db85_sequencial);
            me.oCboRuasTipo.setValue(oRetorno.dados[0].db85_ruastipo);

        }
    }

    /*
    *Cria o campo código do Rua
    */
    me.oTxtCodigoRua = new DBTextField('txtCodigoRua' + sId, 'txtCodigoRua' + sId, '');
    me.oTxtCodigoRua.addStyle('width', '100%');
    me.oTxtCodigoRua.addEvent('onKeyUp', "js_ValidaCampos(this,1,\"Campo Rua\",\"f\",\"f\",event)");
    me.oTxtCodigoRua.show($('ctnCodigoRua' + sId));
    $('txtCodigoRua' + sId).observe('change', me.findRuaByCodigo);

    /*
    *Cria o campo descrição do Rua
    */
    me.oTxtDescrRua = new DBTextField('txtDescrRua' + sId, 'txtDescrRua' + sId, '');
    me.oTxtDescrRua.addStyle('width', '450px');
    me.oTxtDescrRua.show($('ctnDescrRua' + sId));

    this.changeDescrRua = function () {

        /*
        * No evento onChange do campo descrição realiza
        * validação para verificar se o campo imediato abaixo
        * possui um codigo se o mesmo tiver um codigo alerta o usuario
        * que os dados abaixo serão perdidos. Oferece a opção de continuar ou
        * cancelar a modificação e preservar os dados informados
        */
        if ($('txtCodigoNumero' + sId).value != '' && me.oTxtCodigoRua.getValue() != '') {

            var sMessage = "Usuário:\n\nDeseja alterar a Rua ? ";
            sMessage += "\n\nOs dados abaixo já preenchidos serão perdidos ! ";
            sMessage += "\n\nDeseja continuar ?";

            /**
             *1º caso: usuário cancelou a modifica?ao
             */
            if (!confirm(sMessage)) {

                /*
                * Voltar os dados conforme propriedade da classe
                */
                $('txtDescrRua' + sId).value = me.getNomeRua();
                $('txtCodigoRua' + sId).value = me.getRua();
                me.setRuasTipo(me.getRuaTipo());
                me.iEnderecoAutomatico = false;
                return false;

            } else if (me.iEnderecoAutomatico) {

                me.setRua($('txtCodigoRua' + sId).value);
                me.setNomeRua($('txtDescrRua' + sId).value);

                me.iEnderecoAutomatico = false;
            } else {

                me.setRua('');
                $('txtCodigoRua' + sId).value = '';
                me.setNomeRua($('txtDescrRua' + sId).value);
                me.iEnderecoAutomatico = false;

            }

            me.clearAll(5);

        } else if (me.iEnderecoAutomatico) {

            me.setNomeRua($('txtDescrRua' + sId).value);
            me.setRua($('txtCodigoRua' + sId).value);
            me.setRuasTipo(me.oCboRuasTipo.getValue());
            me.iEnderecoAutomatico = false;
        } else {

            me.setNomeRua($('txtDescrRua' + sId).value);
            me.setRua('');
            me.setRuasTipo(me.oCboRuasTipo.getValue());
            me.iEnderecoAutomatico = false;
        }

        $('txtDescrRua' + sId).value = $F('txtDescrRua' + sId).toUpperCase();
        me.iEnderecoAutomatico = false;

        if ($F('txtCodigoRua' + sId).trim() == '') {
            me.oCboRuasTipo.setEnable();
        }
    }

    $('txtDescrRua' + sId).observe('change', me.changeDescrRua);

    /*
    *Função para realizar a busca pelo autocomplete da Rua
    */
    var sUrl = this.sUrlRpc;
    var oParam = new Object();
    oAutoCompleteRua = new dbAutoComplete($('txtDescrRua' + sId), sUrl);
    oAutoCompleteRua.setTxtFieldId($('txtCodigoRua' + sId));
    oAutoCompleteRua.show();

    /*
    *Função para validar se deve disparar a busca do autocomplete
    */
    oAutoCompleteRua.setValidateFunction(function () {

        if (($F('cboCodigoMunicipio' + sId).trim() == '') || (($F('txtCodigoBairro' + sId).trim() == '') && ($F('txtDescrBairro' + sId).trim() != ''))) {
            return false;
        } else {
            return true;
        }
    });

    oAutoCompleteRua.setQueryStringFunction(function () {
        oParam.exec = 'findRuaByName';
        oParam.iCodigoEstado = $F('cboCodigoEstado' + sId);
        oParam.iCodigoMunicipio = $F('cboCodigoMunicipio' + sId).trim();
        oParam.iCodigoBairro = $F('txtCodigoBairro' + sId).trim();
        oParam.sQuery = $F('txtDescrRua' + sId);
        sQuery = 'json=' + Object.toJSON(oParam);
        return sQuery;
    });

    oAutoCompleteRua.setCallBackFunction(function (id, label) {

        me.oTxtCodigoRua.setValue(id);
        me.oTxtDescrRua.setValue(label);
        me.findComplementoRua(id);
    });

    /**
     *Metodo de pesquisa dos dados complementares da Rua pelo número informado
     */
    this.findComplementoRua = function (id) {

        var oRua = new Object();
        oRua.exec = 'findComplementoRua';
        oRua.iCodigoRua = id;
        oRua.iCodigoMunicipio = $F('cboCodigoMunicipio' + sId);
        oRua.iCodigoBairro = $F('txtCodigoBairro' + sId);

        var msgDiv = "Aguarde ...";
        js_divCarregando(msgDiv, 'msgBox');

        var oAjax = new Ajax.Request(
            me.sUrlRpc,
            {
                parameters: 'json=' + Object.toJSON(oRua),
                method: 'post',
                onComplete: me.retornofindComplementoRua
            }
        );

    }

    this.retornofindComplementoRua = function (oAjax) {

        js_removeObj("msgBox");

        var oRetorno = eval('(' + oAjax.responseText + ')');
        if (oRetorno.status == 2) {

            alert('Falha ao retornar os complementos.');
            me.iEnderecoAutomatico = false;
        } else {

            $('cboCodigoMunicipio' + sId).value = oRetorno[0].icodigomunicipio;
            me.setMunicipio($F('cboCodigoMunicipio' + sId));

            $('txtCodigoBairro' + sId).value = oRetorno[0].icodigobairro;
            me.setBairro($F('txtCodigoBairro' + sId));
            $('txtDescrBairro' + sId).value = oRetorno[0].sdescrbairro.urlDecode();
            me.setNomeBairro($F('txtDescrBairro' + sId));
            $('txtDescrRua' + sId).value = oRetorno[0].sdescrrua.urlDecode();
            //me.setNomeRua($F('txtDescrRua'+sId));
            $('txtCodigoRua' + sId).value = oRetorno[0].icodigorua;
            //me.setRua($F('txtCodigoRua'+sId));
            me.oCboRuasTipo.setValue(oRetorno[0].icodigoruatipo);
            //me.oCboRuasTipo.setDisable();
            me.setRuaTipo(oRetorno[0].icodigoruatipo);
            me.setRuasTipo(oRetorno[0].icodigoruastipo);
            me.iEnderecoAutomatico = true;
            if (oRetorno[0].db76_cep != "") {

                $('txtCepEnd' + sId).value = oRetorno[0].db76_cep;
                me.setCepEndereco($F('txtCepEnd' + sId));
            }
            $('txtCodigoNumero' + sId).focus();
        }
    }

    me.oCboRuasTipo = new DBComboBox('cboRuasTipo' + sId, 'cboRuasTipo' + sId);
    me.oCboRuasTipo.addStyle('width', '60px');

    me.oCboRuasTipo.addEvent('onKeyPress', 'return js_mask(event, "0-9|")');
    me.oCboRuasTipo.show($('ctnCboRuasTipo' + sId));
    /**
     *Metodo disparado quando e modificado o select tipos de rua
     *seta a propriedade com o nova alteracao
     */
    this.changeRuasTipo = function () {

        me.setModificado(true);
        me.setRuaTipo(me.oCboRuasTipo.getValue());
    }

    $('ctnCboRuasTipo' + sId).observe('change', me.changeRuasTipo);

//-------------------------------------Fim da Manipulação da Rua--------------------------------------------------------
//-------------------------------------Inicio da Manipulação do Numero--------------------------------------------------
    /**
     *Metodo de pesquisa dos dados complementares da Rua pelo número informado
     */
    this.findNumeroByNumero = function () {

        //Reset nas propriedades que s?o dependentes do codigo do número.
        me.setCodigoLocal('');
        me.setCodigoEndereco('');
        me.setLoteamento('');
        me.setCondominio('');
        me.setComplemento('');
        me.setPontoReferencia('');
        //me.setCepEndereco('');

        me.setNumero($F('txtCodigoNumero' + sId));
        //Desabilita o bota de pesquisa
        $('btnPesquisarNumero' + sId).disabled = true;

        if ($F('txtCodigoRua' + sId) == '') {

            return false;
        }

        var oPesquisa = new Object();
        oPesquisa.exec = 'findNumeroByNumero';
        oPesquisa.iCodigoRua = $F('txtCodigoRua' + sId);
        oPesquisa.iCodigoBairro = $F('txtCodigoBairro' + sId);
        oPesquisa.iCodigoNumero = $F('txtCodigoNumero' + sId);
        var msgDiv = "Aguarde pesquisando numero.";
        js_divCarregando(msgDiv, 'mensagemBuscaRua');

        var oAjax = new Ajax.Request(
            me.sUrlRpc,
            {
                parameters: 'json=' + Object.toJSON(oPesquisa),
                method: 'post',
                onComplete: function (oAjax) {
                    me.retornofindNumeroByNumero(oAjax);
                }
            }
        );
    }

    this.retornofindNumeroByNumero = function (oAjax) {

        js_removeObj("mensagemBuscaRua");
        var oRetorno = eval('(' + oAjax.responseText + ')');
        if (oRetorno.dados != false) {
            $('btnPesquisarNumero' + sId).disabled = true;
            me.exibeGridRua(oRetorno.dados);
        } else {
            me.setModificado(true);
            $('txtDescrCondominio' + sId).value = '';
            $('txtDescrLoteamento' + sId).value = '';
            $('txtDescrComplemento' + sId).value = '';
            $('txtDescrPontoReferencia' + sId).value = '';
        }

    }

    /**
     *Metodo para montar uma janela que exibe
     *todos os complementos cadastrados para a rua e numero informado
     */

    this.exibeGridRua = function (aDados) {

        var iWidthGrid = 600;
        var iWheigthGrid = 350;
        me.oWindowGridRua = new windowAux('wndGridRua' + me.sId, 'Cadastros da Rua', iWidthGrid, iWheigthGrid);

        var sContentGridRua = "<div  id='ctnMessageBoardRua'>";
        sContentGridRua += "  <div style='width:100%' id='GridRua" + me.sId + "'>";
        sContentGridRua += "  </div>";
        sContentGridRua += "</div>";

        me.oWindowGridRua.setContent(sContentGridRua);
        me.oWindowGridRua.show();

        me.oWindowGridRua.setShutDownFunction(function () {
            $('btnPesquisarNumero' + sId).disabled = false;
            me.oWindowGridRua.destroy();
        });


        //Define a janela por cima da q chamou
        me.oWindowGridRua.setChildOf(me.oWindowEndereco);
        /**
         *Defincao da Grid que exibe os complementos cadastrados para a rua e nuemro selecionado
         */
        me.oGridViewRua = new DBGrid('oGridViewRua');
        me.oGridViewRua.nameInstance = sNameInstance + '.oGridViewRua';
        me.oGridViewRua.sName = 'oGridViewRua';
        me.oGridViewRua.setHeight(300);
        me.oGridViewRua.setCellWidth(new Array('10%',
            '10%',
            '10%',

            '10%',
            '10%',
            '10%',

            '10%',
            '10%',
            '10%',

            '10%'));

        me.oGridViewRua.setHeader(new Array('Cep',
            'Número',
            'Complemento',

            'Loteamento',
            'Condomínio',
            'SeqLocal',

            'SeqEnder',
            'PontoRef',
            'SeqRuasTipo',

            'RuaTipo'));
        me.oGridViewRua.setHeight(200);
        me.oGridViewRua.aHeaders[5].lDisplayed = false;//(false,5);
        me.oGridViewRua.aHeaders[6].lDisplayed = false;//(false,6);
        me.oGridViewRua.aHeaders[7].lDisplayed = false;//(false,7);
        me.oGridViewRua.aHeaders[8].lDisplayed = false;//(false,8);
        me.oGridViewRua.aHeaders[9].lDisplayed = false;//(false,9);
        var iNumDados = aDados.length;

        me.oGridViewRua.show($('GridRua' + me.sId));
        me.oGridViewRua.clearAll(true);

        if (iNumDados > 0) {

            aDados.each(
                function (oRua, iIndRua) {
                    var aRow = new Array();

                    var sCep = (oRua.db76_cep == '' || oRua.db76_cep == 'null') ? '' : oRua.db76_cep;

                    aRow[0] = sCep;
                    aRow[1] = oRua.db75_numero;
                    aRow[2] = oRua.db76_complemento.urlDecode();
                    aRow[3] = oRua.db76_loteamento.urlDecode().substring(0, 30);
                    aRow[4] = oRua.db76_condominio.urlDecode().substring(0, 30);
                    aRow[5] = oRua.db75_sequencial;
                    aRow[6] = oRua.db76_sequencial;
                    aRow[7] = oRua.db76_pontoref.urlDecode();
                    aRow[8] = oRua.db85_sequencial;
                    aRow[9] = oRua.db85_ruastipo;

                    me.oGridViewRua.addRow(aRow);
                    me.oGridViewRua.aRows[iIndRua].sEvents = "onClick='" + me.sNameInstance + ".setEndereco(" + iIndRua + ");'";
                }
            );
            me.oGridViewRua.renderRows();
            $('btnPesquisarNumero' + sId).disabled = true;

        }

    }

    /**
     *Metodo que e disparado quando e apresentada a grid com
     *os enderecos e algum endereco e selecionado.
     *Preenche os dados complementares do endereco
     */

    this.setEndereco = function (iIndLinha) {

        $('txtCepEnd' + sId).value = me.oGridViewRua.aRows[iIndLinha].aCells[0].getValue().trim();
        me.setCodigoLocal(me.oGridViewRua.aRows[iIndLinha].aCells[5].getValue());
        me.setCodigoEndereco(me.oGridViewRua.aRows[iIndLinha].aCells[6].getValue());
        me.setRuaTipo(me.oGridViewRua.aRows[iIndLinha].aCells[9].getValue());
        me.setRuasTipo(me.oGridViewRua.aRows[iIndLinha].aCells[8].getValue());
        me.setNumero($F('txtCodigoNumero' + sId));
        me.setCepEndereco($F('txtCepEnd' + sId));

        me.oWindowGridRua.destroy();
        $('btnPesquisarNumero' + sId).disabled = false;
    }

    /*
    *Cria o campo código do Número
    */
    me.oTxtCodigoNumero = new DBTextField('txtCodigoNumero' + sId, 'txtCodigoNumero' + sId, '');
    me.oTxtCodigoNumero.addStyle('width', '40%');
    //me.oTxtCodigoNumero.addEvent('onKeyPress', 'return js_mask(event, "0-9|")');
    me.oTxtCodigoNumero.addEvent('onKeyUp', "js_ValidaCampos(this,1,\"Campo Número\",\"f\",\"f\",event)");
    me.oTxtCodigoNumero.setMaxLength(4);
    me.oTxtCodigoNumero.show($('ctnCodigoNumero' + sId));
    $('txtCodigoNumero' + sId).observe('change', me.findNumeroByNumero);
    /*
    this.btnPesquisarDisable = function() {
    $('btnPesquisarNumero'+sId).disabled = true;
    }
    $('txtCodigoNumero'+sId).observe('keyup', me.btnPesquisarDisable);
    */

//-------------------------------------Fim da Manipulação do Número-----------------------------------------------------
//-------------------------------------Inicio da Manipulação do Cep do Endereco-----------------------------------------
    /*
    *Cria o campo de cep do endereco
    */
    me.oTxtCepEnd = new DBTextField('txtCepEnd' + sId, 'txtCepEnd' + sId, '');
    //me.oTxtCepEnd.addEvent('onKeyPress', 'return js_mask(event, "0-9|")');
    me.oTxtCepEnd.addEvent('onKeyUp', "js_ValidaCampos(this,1,\"Campo Cep Endereço\",\"f\",\"f\",event)");
    me.oTxtCepEnd.addStyle('width', '100%');
    me.oTxtCepEnd.setMaxLength(8);
    me.oTxtCepEnd.show($('ctnCodigoCepEnd' + sId));
    /**
     *Metodo disparado quando e modificado o campo cep
     *seta a propriedade com o nova alteracao
     */
    this.onchangeCepEnd = function () {
        if ($F('txtCepEnd' + sId).length != 8 && $F('txtCepEnd' + sId).trim() != '') {

            alert('usuário:\n\nO Cep informado possui menos de 8 digitos.\n\nVerifique !\n\n');
            $('txtCepEnd' + sId).focus();
            return false;
        }
        me.setCepEndereco($F('txtCepEnd' + sId));
        me.setModificado(true);
    }


    $('txtCepEnd' + sId).observe('change', me.onchangeCepEnd);

//-------------------------------------Fim da Manipulação do Cep do Endereco--------------------------------------------
//-------------------------------------Início da Manipulação do Condom?nio----------------------------------------------
    /*
    *Cria o campo descrição do Condominio
    */
    me.oTxtDescrCondominio = new DBTextField('txtDescrCondominio' + sId, 'txtDescrCondominio' + sId, '');
    me.oTxtDescrCondominio.addStyle('width', '100%');
    me.oTxtDescrCondominio.show($('ctnDescrCondominio' + sId));
     /**
     *Metodo disparado quando e modificado o campo ponto de condominio
     *seta a propriedade com o nova alteracao
     */
    this.alteraCondominio = function () {

        $('txtDescrCondominio' + sId).value = $F('txtDescrCondominio' + sId).toUpperCase();

        if ($F('txtDescrCondominio' + sId).trim() != me.getCondominio()) {

            me.setCondominio($F('txtDescrCondominio' + sId));
            me.setModificado(true);
        }
    }
    $('txtDescrCondominio' + sId).observe('change', me.alteraCondominio);

//-------------------------------------Fim da Manipulação do Condom?nio-------------------------------------------------


//-------------------------------------Início da Manipulação do Distrito----------------------------------------------

    this.js_removeCaracteres = (elemento) => {
        let contemNumero = /\d/.test(elemento.value);
        let ultimoValor = '';
        if(contemNumero){
            alert('Este campo não aceita números!');
            for(let count = 0; count < elemento.value.length; count++){
                if(/\d/.test(elemento.value[count])){
                    ultimoValor+='';
                    continue;
                }
                ultimoValor += elemento.value[count];
            }
        }
        elemento.value = contemNumero ? ultimoValor : elemento.value;
    }
     /**
     * Seta a descricao do Distrito do endereco
     * @param {string} sDistrito
     * @return void
     */
    this.setDistrito = function (sDistrito) {
        this.sDistrito = sDistrito;
    }

     /**
     * Retorna a descricao do Municipio do endereco
     * @return void
     */
    this.getDistrito = function () {
        return this.sDistrito;
    }

    this.changeDistrito = (event) => {
        me.setDistrito(event.target.value);
    }

    me.oTxtDistrito = new DBTextField('txtDistrito' + sId, 'txtDistrito' + sId, '');
    me.oTxtDistrito.addStyle('width', '100%');
    me.oTxtDistrito.setMaxLength(100);
    me.oTxtDistrito.show($('ctnDistrito' + sId));
    $('ctnDistrito' + sId).observe('change', me.changeDistrito);
    $('ctnDistrito' + sId).observe('keyup', ()=>{
        me.js_removeCaracteres($('txtDistrito'+sId));
    });

//-------------------------------------Fim da Manipulação do Distrito-------------------------------------------------
//-------------------------------------Início da Manipulação do BDI----------------------------------------------
     /**
     * Seta o valor do BDI
     * @param {integer} iBDI
     * @return void
     */
    this.setBdi = function (iBdi) {
        this.iBdi = iBdi;
    }

     /**
     * Retorna o valor do BDI
     * @return void
     */
    this.getBdi = function () {
        return this.iBdi;
    }

    this.changeBdi = (event) => {
        me.setBdi(event.target.value);
    }
    me.oBdi = new DBTextField('txtBdi' + sId, 'txtBdi' + sId, '');
    me.oBdi.addStyle('width', '100%');
    me.oBdi.addEvent('onKeyUp', "js_ValidaCampos(this,4,\"Campo BDI\",\"f\",\"t\",event)");
    me.oBdi.setMaxLength(5);
    me.oBdi.show($('ctnBdi' + sId));
    $('ctnBdi' + sId).observe('change', me.changeBdi);
    $('ctnBdi' + sId).observe('keyup',() => {
        me.js_formataValor($('txtBdi' + sId), 4);
    });
//-------------------------------------Fim da Manipulação do BDI-------------------------------------------------
//-------------------------------------Início da Manipulação do Logradouro----------------------------------------------
     /**
     * Seta a descricao do Logradouro
     * @param {string} sLogradouro
     * @return void
     */
    this.setLogradouro = function (sLogradouro) {
        this.sLogradouro = sLogradouro;
    }

     /**
     * Retorna a descricao do Logradouro
     * @return void
     */
    this.getLogradouro = function () {
        return this.sLogradouro;
    }

    this.changeLogradouro = (event) => {
        me.setLogradouro(event.target.value);
    }

    me.oLogradouro = new DBTextField('txtLogradouro' + sId, 'txtLogradouro' + sId, '');
    me.oLogradouro.addStyle('width', '100%');
    me.oLogradouro.setMaxLength(100);
    me.oLogradouro.show($('ctnDescrLogradouro' + sId));
    $('ctnDescrLogradouro' + sId).observe('change', me.changeLogradouro);
    $('ctnDescrLogradouro' + sId).observe('keyup', ()=>{
        me.js_removeCaracteres($('txtLogradouro'+sId));
    });
//-------------------------------------Fim da Manipulação do Logradouro-------------------------------------------------
//-------------------------------------Início da Manipulação do Grau Latitude------------------------------------------
     /**
     * Seta o valor do Grau Latitude
     * @param {integer} iGrausLatitude
     * @return void
     */
    this.setGrausLatitude = function (iGrausLatitude) {
        this.iGrausLatitude = iGrausLatitude;
    }

     /**
     * Retorna o valor do Grau Latitude
     * @return void
     */
    this.getGrausLatitude = function () {
        return this.iGrausLatitude;
    }

    this.changeGrausLatitude = (event) => {
        me.setGrausLatitude(event.target.value);
    }

    me.oGrausLatitude = new DBTextField('txtGrausLatitude' + sId, 'txtGrausLatitude' + sId, '');
    me.oGrausLatitude.addStyle('width', '40%');
    me.oGrausLatitude.addEvent('onKeyUp', "js_ValidaCampos(this,1,\"Campo Graus Latitude\",\"f\",\"f\",event)");
    me.oGrausLatitude.setMaxLength(2);
    me.oGrausLatitude.show($('ctnGrausLatitude' + sId));
    $('ctnGrausLatitude' + sId).observe('change', me.changeGrausLatitude);

//-------------------------------------Fim da Manipulação do Graus Latitude-------------------------------------------------
//-------------------------------------Início da Manipulação do Minuto Latitude--------------------------------------------
     /**
     * Seta o valor do Minuto Latitude
     * @param {integer} iMinutoLatitude
     * @return void
     */
    this.setMinutosLatitude = function (iMinutoLatitude) {
        this.iMinutoLatitude = iMinutoLatitude;
    }

    /**
     * Retorna o valor do Minuto Latitude
     * @return void
     */
    this.getMinutosLatitude = function () {
        return this.iMinutoLatitude;
    }

    this.changeMinutoLatitude = (event) => {
        me.setMinutosLatitude(event.target.value);
    }

    me.oMinutoLatitude = new DBTextField('txtMinutoLatitude' + sId, 'txtMinutoLatitude' + sId, '');
    me.oMinutoLatitude.addStyle('width', '80px');
    me.oMinutoLatitude.addEvent('onKeyUp', "js_ValidaCampos(this,1,\"Campo Minuto Latitude\",\"f\",\"f\",event)");
    me.oMinutoLatitude.setMaxLength(2);
    me.oMinutoLatitude.show($('ctnMinutoLatitude' + sId));
    $('ctnMinutoLatitude' + sId).observe('change', me.changeMinutoLatitude);
//-------------------------------------Fim da Manipulação do Minuto Latitude--------------------------------------------
//-------------------------------------Início da Manipulação do Segundo Latitude--------------------------------------------
     /**
     * Seta o valor do Segundo Latitude
     * @param {integer} iSegundoLatitude
     * @return void
     */
    this.setSegundosLatitude = function (iSegundoLatitude) {
        this.iSegundoLatitude = iSegundoLatitude;
    }

     /**
     * Retorna o valor do Segundo Latitude
     * @return void
     */
    this.getSegundosLatitude = function () {
        return this.iSegundoLatitude;
    }

    this.changeSegundoLatitude = (event) => {
        me.setSegundosLatitude(event.target.value);
    }

    this.js_formataValor = (elemento, tamanho) => {
       if(!elemento.value.includes('.') && elemento.value.length > tamanho){
           novoValor = elemento.value.substr(0, elemento.value.length-1);
           elemento.value = novoValor;
           alert('É permitido a inserção de até '+tamanho+' caracteres!');
       }
    }

    me.oSegundoLatitude = new DBTextField('txtSegundoLatitude' + sId, 'txtSegundoLatitude' + sId, '');
    me.oSegundoLatitude.addStyle('width', '80px');
    me.oSegundoLatitude.addEvent('onKeyUp', "js_ValidaCampos(this,4,\"Campo Segundo Latitude\",\"f\",\"t\",event)");
    me.oSegundoLatitude.setMaxLength(6);
    me.oSegundoLatitude.show($('ctnSegundoLatitude' + sId));
    $('ctnSegundoLatitude' + sId).observe('change', me.changeSegundoLatitude);
    $('ctnSegundoLatitude' + sId).observe('keyup',() => {
        me.js_formataValor($('txtSegundoLatitude' + sId), 5);
    });

//-------------------------------------Fim da Manipulação do Segundo Latitude-------------------------------------------------
//-------------------------------------Início da Manipulação do Grau Longitude----------------------------------------------
     /**
     * Seta o valor do Grau Longitude
     * @param {integer} iGrausLongitude
     * @return void
     */
    this.setGrausLongitude = function (iGrausLongitude) {
        this.iGrausLongitude = iGrausLongitude;
    }

     /**
     * Retorna o valor do Grau Longitude
     * @return void
     */
    this.getGrausLongitude = function () {
        return this.iGrausLongitude;
    }

    this.changeGrausLongitude = (event) => {
        me.setGrausLongitude(event.target.value);
    }

    me.oGrausLongitude = new DBTextField('txtGrausLongitude' + sId, 'txtGrausLongitude' + sId, '');
    me.oGrausLongitude.addStyle('width', '40%');
    me.oGrausLongitude.addEvent('onKeyUp', "js_ValidaCampos(this,1,\"Campo Graus Longitude\",\"f\",\"f\",event)");
    me.oGrausLongitude.setMaxLength(2);
    me.oGrausLongitude.show($('ctnGrausLongitude' + sId));
    $('ctnGrausLongitude' + sId).observe('change', me.changeGrausLongitude);
//-------------------------------------Fim da Manipulação do Graus Longitude-------------------------------------------------
//-------------------------------------Início da Manipulação do Minuto Longitude----------------------------------------------
     /**
     * Seta o valor do Minuto Longitude
     * @param {integer} iMinutoLongitude
     * @return void
     */
    this.setMinutoLongitude = function (iMinutoLongitude) {
        this.iMinutoLongitude = iMinutoLongitude;
    }

     /**
     * Retorna o valor do Minuto Longitude
     * @return void
     */
    this.getMinutoLongitude = function () {
        return this.iMinutoLongitude;
    }

    this.changeMinutoLongitude = (event) => {
        me.setMinutoLongitude(event.target.value);
    }

    me.oMinutosLongitude = new DBTextField('txtMinutoLongitude' + sId, 'txtMinutoLongitude' + sId, '');
    me.oMinutosLongitude.addStyle('width', '80px');
    me.oMinutosLongitude.addEvent('onKeyUp', "js_ValidaCampos(this,1,\"Campo Minuto Longitude\",\"f\",\"f\",event)");
    me.oMinutosLongitude.setMaxLength(2);
    me.oMinutosLongitude.show($('ctnMinutoLongitude' + sId));
    $('ctnMinutoLongitude' + sId).observe('change', me.changeMinutoLongitude);

//-------------------------------------Fim da Manipulação do Minutos Longitude-------------------------------------------------
//-------------------------------------Início da Manipulação do Segundo Longitude-------------------------------------------------
     /**
     * Seta o valor do Segundo Longitude
     * @param {integer} iSegundoLongitude
     * @return void
     */
    this.setSegundosLongitude = function (iSegundoLongitude) {
        this.iSegundoLongitude = iSegundoLongitude;
    }

    /**
     * Retorna o valor do Segundo Longitude
     * @return void
     */
    this.getSegundosLongitude = function () {
        return this.iSegundoLongitude;
    }

    this.changeSegundoLongitude = (event) => {
        me.setSegundosLongitude(event.target.value);
    }

    me.oSegundoLongitude = new DBTextField('txtSegundoLongitude' + sId, 'txtSegundoLongitude' + sId, '');
    me.oSegundoLongitude.addStyle('width', '80px');
    me.oSegundoLongitude.addEvent('onKeyUp', "js_ValidaCampos(this,4,\"Campo Segundo Longitude\",\"f\",\"t\",event)");
    me.oSegundoLongitude.setMaxLength(6);
    me.oSegundoLongitude.show($('ctnSegundoLongitude' + sId));
    $('ctnSegundoLongitude' + sId).observe('change', me.changeSegundoLongitude);
    $('ctnSegundoLongitude' + sId).observe('keyup',() => {
        me.js_formataValor($('txtSegundoLongitude' + sId), 5);
    });

//-------------------------------------Fim da Manipulação do Segundos Longitude-------------------------------------------------
//-------------------------------------Início da Manipulação do Loteamento----------------------------------------------

    /*
    * Cria o campo descrição do Loteamento
    */
    me.oTxtDescrLoteamento = new DBTextField('txtDescrLoteamento' + sId, 'txtDescrLoteamento' + sId, '');
    me.oTxtDescrLoteamento.addStyle('width', '100%');
    me.oTxtDescrLoteamento.show($('ctnDescrLoteamento' + sId));
    /**
    * Metodo disparado quando e modificado o campo ponto de loteamento
    * seta a propriedade com o nova alteracao
    */
    this.alteraLoteamento = function () {

        $('txtDescrLoteamento' + sId).value = $F('txtDescrLoteamento' + sId).toUpperCase();

        if ($F('txtDescrLoteamento' + sId).trim() != me.getLoteamento()) {
            me.setLoteamento($F('txtDescrLoteamento' + sId));
            me.setModificado(true);
        }
    }

    $('txtDescrLoteamento' + sId).observe('change', me.alteraLoteamento);

    /*
    *Função para realizar a busca pelo autocomplete do Loteamento
    */
    var sUrl = this.sUrlRpc;
    var oParam = new Object();
    oAutoCompleteCondominio = new dbAutoComplete($('txtDescrLoteamento' + sId), sUrl);
    oAutoCompleteCondominio.setTxtFieldId($('txtCodigoNumero' + sId));
    oAutoCompleteCondominio.show();
    oAutoCompleteCondominio.setQueryStringFunction(function () {

        oParam.exec = 'findLoteamentoByName';
        oParam.iCodigoBairro = $F('txtCodigoBairro' + sId);
        oParam.iCodigoRua = $F('txtCodigoRua' + sId);
        oParam.iCodigoNumero = $F('txtCodigoNumero' + sId);
        oParam.sQuery = $F('txtDescrLoteamento' + sId);
        sQuery = 'json=' + Object.toJSON(oParam);
        return sQuery;
    });

//-------------------------------------Fim da Manipulação do Loteamento-------------------------------------------------
//-------------------------------------Início da Manipulação do Complemento---------------------------------------------

    /*
    *Cria o campo descrição do Complemento
    */
    me.oTxtDescrComplemento = new DBTextField('txtDescrComplemento' + sId, 'txtDescrComplemento' + sId, '');
    me.oTxtDescrComplemento.addStyle('width', '100%');
    me.oTxtDescrComplemento.show($('ctnDescrComplemento' + sId));
     /**
     *Metodo disparado quando e modificado o campo complemento
     *seta a propriedade com o nova alteracao
     */
    this.alteraComplemento = function () {

        $('txtDescrComplemento' + sId).value = $F('txtDescrComplemento' + sId).toUpperCase();

        if ($F('txtDescrComplemento' + sId).trim() != me.getComplemento()) {

            me.setCodigoEndereco('');
            me.setComplemento($F('txtDescrComplemento' + sId));
            me.setModificado(true);
        }
    }

    $('txtDescrComplemento' + sId).observe('change', me.alteraComplemento);

//-------------------------------------Fim da Manipulação do Complemento------------------------------------------------
//-------------------------------------Início da Manipulação do Ponto de Refer?ncia-------------------------------------

    this.alteraPontoReferencia = function () {
    //$('txtDescrPontoReferencia'+sId).value = $F('txtDescrPontoReferencia'+sId).toUpperCase();

        if ($F('txtDescrPontoReferencia' + sId).trim() != me.getPontoReferencia()) {

            me.setPontoReferencia($F('txtDescrPontoReferencia' + sId));
            me.setModificado(true);
        }
    }

    $('txtDescrPontoReferencia' + sId).observe('change', me.alteraPontoReferencia);

//-------------------------------------Fim da Manipulação do Ponto de Referência----------------------------------------

     /**
     *Método que exibe a tela de cadastro de endereco
     */
    this.show = function () {
        me.oWindowEndereco.show();
    }

     /**
     *Seta a descricao do ponto de referencia do endereco
     *@param {string} sPontoReferencia
     *@return void
     */

    this.setPontoReferencia = function (sPontoReferencia) {

        this.sPontoReferencia = sPontoReferencia;
    }

     /**
     *Retorna a descricao do ponto de referencia do endereco
     *@return {string} descricao do ponto de referencia
     */

    this.getPontoReferencia = function () {

        return this.sPontoReferencia;
    }

     /**
     *Seta a descricao do loteamento do endereco
     *@param {string} sLoteamento
     *@return void
     */

    this.setLoteamento = function (sLoteamento) {

        this.sLoteamento = sLoteamento;
    }

     /**
     *Retorna a decricao do loteamento do endereco
     *@return {string} descricao do loteamento
     */

    this.getLoteamento = function () {

        return this.sLoteamento;
    }

     /**
     *Seta a descricao do condominio do endereco
     *@param {string} sCondominio nome do condominio
     *@return void
     */

    this.setCondominio = function (sCondominio) {

        this.sCondominio = sCondominio;
    }

     /**
     *Retorna a descricao do condominio do endereco
     *@return {string} nome do condominio
     */

    this.getCondominio = function () {

        return this.sCondominio;
    }

     /**
     *Seta o complemento do endereco
     *@param {string} sComplemento complemento do endereco
     *@return void
     */

    this.setComplemento = function (sComplemento) {

        this.sComplemento = sComplemento;
    }

     /**
     *Retorna o complemnto do endereco
     *@return {string} sComplemento
     */

    this.getComplemento = function () {

        return this.sComplemento;
    }

     /**
     *Seta o numero do endereco
     *@param {string} sNumero
     *@return void
     */

    this.setNumero = function (sNumero) {

        this.sNumero = sNumero;
    }

     /**
     *Retorna o numero do endereco
     *@return {string} sNumero
     */

    this.getNumero = function () {

        return this.sNumero;
    }

     /**
     *Seta o codigo do pais do endereco
     *@param {string} iCodigoPais
     *@return void
     */

    this.setPais = function (iCodigoPais) {

        this.iCodigoPais = iCodigoPais;
    }

     /**
     *Retorna o codigo pais do endereco
     *@return {string} iCodigoPais
     */

    this.getPais = function () {

        return this.iCodigoPais;
    }

     /**
     *Seta a descricao do pais do endereco
     *@param {string} sNomeBairro
     *@return void
     */

    this.setNomePais = function (sNomePais) {

        this.sNomePais = sNomePais;
    }

     /**
     *Retorna a descricao do Pais do endereco
     *@return {string} sNomePais
     */

    this.getNomePais = function () {

        return this.sNomePais;
    }

     /**
     *Seta o codigo do estado do endereco
     *@param {string} iCodigoEstado
     *@return void
     */

    this.setEstado = function (iCodigoEstado) {

        this.iCodigoEstado = iCodigoEstado;
    }

     /**
     *Retorna o codigo do estado do endereco
     *@return void
     */

    this.getEstado = function () {

        return this.iCodigoEstado;
    }


     /**
     *Seta a descricao do bairro do endereco
     *@param {string} sNomeBairro
     *@return void
     */

    this.setNomeBairro = function (sNomeBairro) {
        //$('txtDescrPontoReferencia'+sId).value = sNomeBairro;
        this.sNomeBairro = sNomeBairro;
    }

     /**
     *Retorna a descricao do bairro do endereco
     *@return void
     */

    this.getNomeBairro = function () {

        return this.sNomeBairro;
    }

     /**
     *Seta o logradouro
     *@param {string} sLogradouro
     *@return void
     */

    this.setLogradouro = function (sLogradouro) {

        this.sLogradouro = sLogradouro;
    }

     /**
     *Retorna o Logradouro
     *@return void
     */

    this.getLogradouro = function () {

        return this.sLogradouro;
    }

    /**
     *Seta o codigo da local do endereco
     *@param {string} iCodigoLocal
     *@return void
     */

    this.setCodigoLocal = function (iCodigoLocal) {

        this.iCodigoLocal = iCodigoLocal;
    }

     /**
     *Retorna o codigo da local do endereco
     *@param {string} iCodigoLocal
     *@return void
     */

    this.getCodigoLocal = function () {

        return this.iCodigoLocal;
    }

     /**
     *Seta o codigo do endereco
     *@param {string} iCodigoEndereco
     *@return void
     */

    this.setCodigoEndereco = function (iCodigoEndereco) {

        this.iCodigoEndereco = iCodigoEndereco;
    }

    /**
     *Retorna o codigo do endereco
     *@return string com o codigo
     */

    this.getCodigoEndereco = function () {
        return this.iCodigoEndereco;
    }

     /**
     *Seta o codigo da rua do endereco
     *@param {string} iCodigoRua
     *@return void
     */

    this.setRua = function (iCodigoRua) {

        this.iCodigoRua = iCodigoRua;
    }

     /**
     *Retorna o codigo da rua do endereco
     *@return string
     */

    this.getRua = function () {

        return this.iCodigoRua;
    }

     /**
     *Seta o valor do campo Cep do endereco
     *@param {string} sCepEnder string contendo o cep
     *@return void
     */

    this.setCepEndereco = function (sCepEnder) {

        this.sCepEndereco = sCepEnder;
    }
     /**
     * Retorna o valor do Cep
     * @return string
     */

    this.getCepEndereco = function () {

        return this.sCepEndereco;
    }

     /**
     * Método utilizado para verificar se foi informado o código
     * de endereço da obra, caso tenha sido, carrega os dados para alteração
     * se não foi informado carrega a tela com os campos padrões
     * conforme configurações.
     */
    this.buscaEndereco = function () {

        if (me.getCodigoRuaMunicipio() != "") {

            me.clearAll(1);
            var oEndereco = new Object();
            oEndereco.exec = 'buscaBairroRuaMunicipio';
            oEndereco.icodigoruamunicipio = me.getCodigoRuaMunicipio();
            oEndereco.icodigobairromunicipio = me.getCodigoBairroMunicipio();

            var msgDiv = "Aguarde ...";
            js_divCarregando(msgDiv, 'msgBox');

            var oAjax = new Ajax.Request(
                me.sUrlRpc,
                {
                    parameters: 'json=' + Object.toJSON(oEndereco),
                    method: 'post',
                    onComplete: me.retornoBuscaBairroRuaMunicipio
                }
            );

        } else if (me.getCodigoEndereco() == '') {

            me.clearAll(1);
            var oEndereco = new Object();
            oEndereco.exec = 'buscaValoresPadrao';
            oEndereco.icodigoendereco = me.getCodigoEndereco();

            var msgDiv = "Aguarde ...";
            js_divCarregando(msgDiv, 'msgBox');

            var oAjax = new Ajax.Request(
                me.sUrlRpc,
                {
                    parameters: 'json=' + Object.toJSON(oEndereco),
                    method: 'post',
                    onComplete: me.retornoBuscaValoresPadrao
                }
            );

        } else {

            var oEndereco = new Object();
            oEndereco.exec = 'buscaEndereco';

            oEndereco.icodigoendereco = me.getCodigoEndereco();
            var msgDiv = "Aguarde pesquisando os dados do endereço.";
            js_divCarregando(msgDiv, 'msgBox');

            var oAjax = new Ajax.Request(
                me.sUrlRpc,
                {
                    parameters: 'json=' + Object.toJSON(oEndereco),
                    method: 'post',
                    onComplete: me.retornoBuscaEndereco
                }
            );
        }
    }

     /**
     * Processa os dados retornados da consulta para preencher o
     * form com os valores do bairro e rua do municipio
     */
    this.retornoBuscaBairroRuaMunicipio = function (oAjax) {

        js_removeObj('msgBox');

        var oRetorno = eval('(' + oAjax.responseText + ')');
        var sExpReg = new RegExp('\\\\n', 'g');

        if (oRetorno.status == 2) {
            me.close();
            return false;
        }

        if (!oRetorno) {

            alert("usuário:\n\nFalha ao buscar valores padrão!\n\nContate o administrador.\n\n");

        } else {
            $('cboCodigoPais' + sId).value = oRetorno.valoresPadrao[0].db70_sequencial;
            me.setPais(oRetorno.valoresPadrao[0].db70_sequencial);
            /*$('txtDescrPais'+sId).value  = oRetorno.valoresPadrao[0].db70_descricao.urlDecode();
            me.setNomePais(oRetorno.valoresPadrao[0].db70_descricao.urlDecode());*/
            var iEstado = oRetorno.valoresPadrao[0].db72_cadenderestado;

            me.preencheCboEstados(oRetorno.estados, iEstado);
            me.preencheCboRuasTipo(oRetorno.tiposRua, 3);

            if (oRetorno.municipio == false) {

                me.setMunicipio('');
                me.setNomeMunicipio('');

            } else {

                me.setMunicipio(oRetorno.valoresPadrao[0].db72_sequencial);
                $('cboCodigoMunicipio' + sId).value = me.getMunicipio();

            }

            $('txtDescrRua' + sId).value = oRetorno.bairroRuaMunicipio[0].srua.urlDecode();
            me.oTxtDescrRua.setReadOnly(true);
            $('txtCodigoRua' + sId).value = oRetorno.bairroRuaMunicipio[0].irua;
            me.oTxtCodigoRua.setReadOnly(true);
            me.setRua($('txtCodigoRua' + sId).value);
            $('txtDescrBairro' + sId).value = oRetorno.bairroRuaMunicipio[0].sbairro.urlDecode();
            me.oTxtDescrBairro.setReadOnly(true);
            $('txtCodigoBairro' + sId).value = oRetorno.bairroRuaMunicipio[0].ibairro;
            me.setBairro($('txtCodigoBairro' + sId).value);
            me.oTxtCodigoBairro.setReadOnly(true);
            me.oCboRuasTipo.setValue(oRetorno.bairroRuaMunicipio[0].iruatipo);
            me.setRuaTipo(oRetorno.bairroRuaMunicipio[0].iruatipo);
            me.setRuasTipo(oRetorno.bairroRuaMunicipio[0].iruastipo);
            $('txtCepEnd' + sId).value = oRetorno.cepmunic[0].cep;
            me.setCepEndereco($F('txtCepEnd' + sId));
            me.oTxtCepEnd.setReadOnly(true);

        }
    }
     /**
     * Processa os dados retornados da consulta para preencher o
     * form com os valores padrao
     */
    this.retornoBuscaValoresPadrao = function (oAjax) {

        js_removeObj('msgBox');

        var oRetorno = eval('(' + oAjax.responseText + ')');
        var sExpReg = new RegExp('\\\\n', 'g');

        if (oRetorno.status == 2) {

            alert(oRetorno.message.urlDecode().replace(sExpReg, '\n'));
            me.close();
            return false;
        }

        if (!oRetorno) {

            alert("usuário:\n\nFalha ao buscar valores padrão!\n\nContate o administrador.\n\n");

        } else {
            var iEstado = oRetorno.valoresPadrao[0].db72_cadenderestado;
            var iPais = oRetorno.valoresPadrao[0].db70_sequencial;

            me.preencheCboPaises(oRetorno.aPaises, iPais);
            me.preencheCboEstados(oRetorno.estados, iEstado);
            me.preencheCboRuasTipo(oRetorno.tiposRua, 3);
            if (oRetorno.municipio == false) {

                me.setMunicipio('');
                me.setNomeMunicipio('');
            }

        }
    }

     /**
     * Processa os dados retornados da consulta do
     * endereço informado para preencher o
     * form com os valores retornados
     */

    this.retornoBuscaEnderecoCidadao = function (oAjax) {

        js_removeObj("msgBox");

        var oRetorno = eval('(' + oAjax.responseText + ')');

        var sExpReg = new RegExp('\\\\n', 'g');

        if (oRetorno.status == 2) {

            alert(oRetorno.message.urlDecode().replace(sExpReg, '\n'));
        } else {


            $('cboCodigoPais' + sId).value = oRetorno.endereco.iPais;
            me.setPais(oRetorno.endereco.iPais);

            $('cboCodigoMunicipio' + sId).value = oRetorno.endereco.iMunicipio;
            me.setMunicipio($F('cboCodigoMunicipio' + sId))

            $('txtCodigoBairro' + sId).value = oRetorno.endereco.iBairro;
            me.setBairro($F('txtCodigoBairro' + sId));

            $('txtDescrBairro' + sId).value = oRetorno.endereco.sBairro.urlDecode();
            me.setNomeBairro($F('txtDescrBairro' + sId));

            $('txtCodigoRua' + sId).value = oRetorno.endereco.iRua;
            me.setRua($F('txtCodigoRua' + sId));

            $('txtDescrRua' + sId).value = oRetorno.endereco.sRua.urlDecode();
            me.setNomeRua($F('txtDescrRua' + sId));

            $('txtCodigoNumero' + sId).value = oRetorno.endereco.sNumeroLocal.urlDecode();
            me.setNumero($F('txtCodigoNumero' + sId));

            $('txtCepEnd' + sId).value = oRetorno.endereco.sCep.urlDecode();
            me.setCepEndereco($F('txtCepEnd' + sId));

            // $('txtCodigoIbge'+sId).value            = oRetorno.endereco.iIbge.urlDecode();
            // me.setCodigoIbge($F('txtCodigoIbge'+sId));

            $('txtDescrCondominio' + sId).value = oRetorno.endereco.sCondominio.urlDecode();
            me.setCondominio($F('txtDescrCondominio' + sId));

            $('txtDescrLoteamento' + sId).value = oRetorno.endereco.sLoteamento.urlDecode();
            me.setLoteamento($F('txtDescrLoteamento' + sId));

            $('txtDescrPontoReferencia' + sId).value = oRetorno.endereco.sPontoReferencia.urlDecode();
            me.setPontoReferencia($F('txtDescrPontoReferencia' + sId));

            $('txtDescrComplemento' + sId).value = oRetorno.endereco.sComplemento.urlDecode();
            me.setComplemento($F('txtDescrComplemento' + sId));

            me.setCepRua(oRetorno.endereco.iCep);

            me.preencheCboEstados(oRetorno.estados, oRetorno.endereco.iEstado);
            me.preencheCboRuasTipo(oRetorno.tiposRua, oRetorno.endereco.iRuaTipo);

            $('btnPesquisarNumero' + sId).disabled = false;
            me.setEstado(oRetorno.endereco.iEstado);
            me.oCboRuasTipo.setValue(oRetorno.endereco.iRuaTipo);

            me.setRuaTipo(oRetorno.endereco.iRuaTipo);
            me.setRuasTipo(oRetorno.endereco.iRuasTipo);

            //$('btnSalvar'+sId).value = 'Alterar';
        }

    }

    /**
     * Processa os dados retornados da consulta do
     * endereço informado para preencher o
     * form com os valores retornados
     */
    this.retornoBuscaEndereco = function (oAjax) {

        js_removeObj("msgBox");

        var oRetorno = eval('(' + oAjax.responseText + ')');
        codigoMunicipio = oRetorno.endereco.iMunicipio;
        codigoEstado = oRetorno.endereco.iEstado;
        var sExpReg = new RegExp('\\\\n', 'g');

        if (oRetorno.status == 2) {

            alert(oRetorno.message.urlDecode().replace(sExpReg, '\n'));

        } else {

            $('cboCodigoPais' + sId).value = oRetorno.endereco.iPais;
            me.setPais(oRetorno.endereco.iPais);

            $('txtCodigoBairro' + sId).value = oRetorno.endereco.iBairro;
            me.setBairro($F('txtCodigoBairro' + sId));
            $('txtDescrBairro' + sId).value = oRetorno.endereco.sBairro.urlDecode();
            me.setNomeBairro($F('txtDescrBairro' + sId));

            $('txtCodigoRua' + sId).value = oRetorno.endereco.iRua;
            me.setRua($F('txtCodigoRua' + sId));
            $('txtDescrRua' + sId).value = oRetorno.endereco.sRua.urlDecode();
            me.setNomeRua($F('txtDescrRua' + sId));

            $('txtCodigoNumero' + sId).value = oRetorno.endereco.sNumeroLocal.urlDecode();
            me.setNumero($F('txtCodigoNumero' + sId));

            $('txtCepEnd' + sId).value = oRetorno.endereco.sCep.urlDecode();
            me.setCepEndereco($F('txtCepEnd' + sId));

            $('txtDescrCondominio' + sId).value = oRetorno.endereco.sCondominio.urlDecode();
            me.setCondominio($F('txtDescrCondominio' + sId));

            $('txtDescrLoteamento' + sId).value = oRetorno.endereco.sLoteamento.urlDecode();
            me.setLoteamento($F('txtDescrLoteamento' + sId));

            $('txtDescrPontoReferencia' + sId).value = oRetorno.endereco.sPontoReferencia.urlDecode();
            me.setPontoReferencia($F('txtDescrPontoReferencia' + sId));

            $('txtDescrComplemento' + sId).value = oRetorno.endereco.sComplemento.urlDecode();
            me.setComplemento($F('txtDescrComplemento' + sId));

            me.setCepRua(oRetorno.endereco.iCep);

            me.preencheCboPaises(oRetorno.aPaises, oRetorno.endereco.iPais);
            me.preencheCboEstados(oRetorno.estados, oRetorno.endereco.iEstado);
            me.preencheCboRuasTipo(oRetorno.tiposRua, oRetorno.endereco.iRuaTipo);

            $('cboCodigoMunicipio' + sId).value = oRetorno.iCodigoMunicipio;
            me.setMunicipio($F('cboCodigoMunicipio' + sId));

            $('btnPesquisarNumero' + sId).disabled = false;
            me.setEstado(oRetorno.endereco.iEstado);
            me.oCboRuasTipo.setValue(oRetorno.endereco.iRuaTipo);

            me.setRuaTipo(oRetorno.endereco.iRuaTipo);
            me.setRuasTipo(oRetorno.endereco.iRuasTipo);

            if (me.getCgmMunicipio() == true) {

                var lEnderecoMunicipio = true;
                me.setCgmMunicipio(lEnderecoMunicipio);
                //me.oTxtCep.setReadOnly(lEnderecoMunicipio);
                me.oTxtCodigoPais.setReadOnly(lEnderecoMunicipio);
                me.oTxtDescrPais.setReadOnly(lEnderecoMunicipio);
                me.oCboCodigoEstado.setDisable();
                me.oTxtCodigoMunicipio.setReadOnly(lEnderecoMunicipio);
                me.oTxtDescrMunicipio.setReadOnly(lEnderecoMunicipio);
                me.oTxtCodigoBairro.setReadOnly(lEnderecoMunicipio);
                me.oTxtDescrBairro.setReadOnly(lEnderecoMunicipio);
                me.oTxtCodigoRua.setReadOnly(lEnderecoMunicipio);
                me.oTxtDescrRua.setReadOnly(lEnderecoMunicipio);
                $('btnPesquisarCep' + sId).disabled = lEnderecoMunicipio;
            }

            $('btnSalvar' + sId).value = 'Alterar';
        }

    }
    /*
    * Preenche a combobox dos tipos de rua
    * recebe por parametro array com os dados
    */
    this.preencheCboRuasTipo = function (aValues, iCodigoTipo) {

        var iCodigoTipo = iCodigoTipo;
        var iNumRuasTipo = aValues.length;

        for (var iInd = 0; iInd < iNumRuasTipo; iInd++) {

            with (aValues[iInd]) {
                me.oCboRuasTipo.addItem(codigo, descricao.urlDecode());
            }
        }

        if (iCodigoTipo == '') {
            iCodigoTipo = 3;
        }

        me.oCboRuasTipo.setValue(iCodigoTipo);
        me.setRuaTipo(iCodigoTipo);
    }

    /*
    * Preenche a combobox dos paises recebidos por parametro
    * aValues array de objetos com os paises
    * iCodigoPais valor par deixar selecionado o pais
    */
    this.preencheCboPaises = function (aValues, iCodigoPais) {

        var iNumPaises = aValues.length;

        me.oCboCodigoPais.addItem(0, 'Selecione o País');

        for (var iInd = 0; iInd < iNumPaises; iInd++) {
            with (aValues[iInd]) {
                me.oCboCodigoPais.addItem(codigo, descricao.urlDecode());
            }
        }

        if (iCodigoPais == '') {
            iCodigoPais = aValues[0].codigo;
        }
        me.oCboCodigoPais.setValue(iCodigoPais);

        if (iNumPaises > 0) {
            me.setPais(iCodigoPais);
        }

        me.findEstadoByCodigoPais();
    }

    /*
    * Preenche a combobox dos estados recebidos por parametro
    * aValues array de objetos com os estados
    * iCodigoEstado valor par deixar selecionado o estado
    */
    this.preencheCboEstados = function (aValues, iCodigoEstado) {

        var iNumEstados = aValues.length;

        me.oCboCodigoEstado.addItem(0, 'Selecione o estado');

        for (var iInd = 0; iInd < iNumEstados; iInd++) {
            with (aValues[iInd]) {
                me.oCboCodigoEstado.addItem(codigo, descricao.urlDecode());
            }
        }

        if (iCodigoEstado == '' && aValues.length > 0) {
            iCodigoEstado = aValues[0].codigo;
        }

        me.oCboCodigoEstado.setValue(iCodigoEstado);

        if (iNumEstados > 0) {
            me.setEstado(iCodigoEstado);
        }

        me.findMunicipioByEstado();
    }

    /*
  *Método para limpar os campos da tela conforme
  *o código informado
  *1 limpa todos abaixo de Pais
  *2 limpa todos abaixo de Estado
  *3 limpa todos abaixo de Municipio
  *4 limpa todos abaixo de Bairro
  *5 limpa todos abaixo de Rua
  *6 limpa todos abaixo de Numero
  */
    this.clearAll = function (iCodigoClear) {
        switch (iCodigoClear) {
            case 1:
                $('cboCodigoPais' + sId).value = '';
                me.setPais('');
                $('cboCodigoEstado' + sId).length = 0;
                me.setEstado('');
                $('cboCodigoMunicipio' + sId).value = '';
                me.setMunicipio('');
                me.setNomeMunicipio('');
                $('txtCodigoBairro' + sId).value = '';
                $('txtDescrBairro' + sId).value = '';
                me.setBairro('');
                me.setNomeBairro('');
                $('txtCodigoRua' + sId).value = '';
                $('txtDescrRua' + sId).value = '';
                me.setRua('');
                me.setNomeRua('');
                $('txtCepEnd' + sId).value = '';
                me.setCepEndereco('');
                $('txtCodigoNumero' + sId).value = '';
                me.setNumero('');
                me.setCodigoEndereco('');
                $('txtDescrCondominio' + sId).value = '';
                me.setCondominio('');
                $('txtDescrLoteamento' + sId).value = '';
                me.setLoteamento('');
                $('txtDescrComplemento' + sId).value = '';
                me.setComplemento('');
                $('txtDescrPontoReferencia' + sId).value = '';
                me.setPontoReferencia('');
                $('txtCodigoIbge' + sId).value = '';
                me.setCodigoIbge('');
                $('txtLogradouro' + sId).value = '';
                me.setLogradouro('');
                $('txtDistrito' + sId).value = '';
                me.setDistrito('');
                $('txtGrausLatitude' + sId).value = '';
                me.setGrausLatitude('');
                $('txtMinutoLatitude' + sId).value = '';
                me.setMinutosLatitude('');
                $('txtSegundoLatitude' + sId).value = '';
                me.setSegundosLatitude('');
                $('txtGrausLongitude' + sId).value = '';
                me.setGrausLongitude('');
                $('txtMinutoLongitude' + sId).value = '';
                me.setMinutoLongitude('');
                $('txtSegundoLongitude' + sId).value = '';
                me.setSegundosLongitude('');
                $('txtLogradouro' + sId).value = '';
                me.setLogradouro('');
                $('cboClasseObjeto' + sId).value = 0;
                me.setClassesObjeto('');
                $('cboAtividadeObra' + sId).value = 0;
                $('cboAtividadeObra' + sId).disabled = true;
                me.setAtividadeObra('');
                $('cboAtividadeServico' + sId).value = 0;
                $('cboAtividadeServico' + sId).disabled = true;
                me.setAtividadeServico('');
                $('cboAtividadeServicoEsp' + sId).value = 0;
                $('cboAtividadeServicoEsp' + sId).disabled = true;
                me.setAtividadeServicoEspecializado('');
                $('cboGrupoBemPub' + sId).value = 0;
                me.setGrupoBemPublico('');
                $('cboSubGrupoBemPub' + sId).value = 0;
                me.setSubGrupoBemPublico('');
                $('txtDescrAtividadeServico' + sId).value = '';
                $('txtDescrAtividadeServicoEsp' + sId).value = '';
                me.setBdi('');
                $('txtBdi' + sId).value = '';


                //me.oCboRuasTipo.setValue(3);
                //me.setRuaTipo(3);
                me.setRuasTipo('');
                me.setCepRua('');
                break;

            case 2:
                $('cboCodigoMunicipio' + sId).value = '';
                me.setMunicipio('');
                $('txtCodigoBairro' + sId).value = '';
                $('txtDescrBairro' + sId).value = '';
                me.setBairro('');
                me.setNomeBairro('');
                $('txtCodigoRua' + sId).value = '';
                $('txtDescrRua' + sId).value = '';
                me.setRua('');
                me.setNomeRua('');
                $('txtCodigoNumero' + sId).value = '';
                me.setNumero('');
                $('txtCepEnd' + sId).value = '';
                me.setCepEndereco('');
                me.setCodigoEndereco('');
                $('txtDescrCondominio' + sId).value = '';
                me.setCondominio('');
                $('txtDescrLoteamento' + sId).value = '';
                me.setLoteamento('');
                $('txtDescrComplemento' + sId).value = '';
                me.setComplemento('');
                $('txtDescrPontoReferencia' + sId).value = '';
                me.setPontoReferencia('');
                $('txtCodigoIbge' + sId).value = '';
                me.setCodigoIbge('');
                //me.oCboRuasTipo.setValue(3);
                //me.setRuaTipo(3);
                me.setRuasTipo('');
                me.setCepRua('');
                break;
            case 3:

                $('txtCodigoBairro' + sId).value = '';
                $('txtDescrBairro' + sId).value = '';
                me.setBairro('');
                me.setNomeBairro('');
                $('txtCodigoRua' + sId).value = '';
                $('txtDescrRua' + sId).value = '';
                me.setRua('');
                me.setNomeRua('');
                $('txtCodigoNumero' + sId).value = '';
                me.setNumero('');
                $('txtCepEnd' + sId).value = '';
                me.setCepEndereco('');
                me.setCodigoEndereco('');
                $('txtDescrCondominio' + sId).value = '';
                me.setCondominio('');
                $('txtDescrLoteamento' + sId).value = '';
                me.setLoteamento('');
                $('txtDescrComplemento' + sId).value = '';
                me.setComplemento('');
                $('txtDescrPontoReferencia' + sId).value = '';
                me.setPontoReferencia('');
                $('txtCodigoIbge' + sId).value = '';
                me.setCodigoIbge('');
                //me.oCboRuasTipo.setValue(3);
                //me.setRuaTipo(3);
                me.setRuasTipo('');
                me.setCepRua('');
                break;
            case 4:
                $('txtCodigoRua' + sId).value = '';
                $('txtDescrRua' + sId).value = '';
                me.setRua('');
                me.setNomeRua('');
                $('txtCodigoNumero' + sId).value = '';
                me.setNumero('');
                $('txtCepEnd' + sId).value = '';
                me.setCepEndereco('');
                me.setCodigoEndereco('');
                $('txtDescrCondominio' + sId).value = '';
                me.setCondominio('');
                $('txtDescrLoteamento' + sId).value = '';
                me.setLoteamento('');
                $('txtDescrComplemento' + sId).value = '';
                me.setComplemento('');
                $('txtDescrPontoReferencia' + sId).value = '';
                me.setPontoReferencia('');
                $('txtCodigoIbge' + sId).value = '';
                me.setCodigoIbge('');
                //me.oCboRuasTipo.setValue(3);
                //me.setRuaTipo(3);
                me.setRuasTipo('');
                me.setCepRua('');
                break;
            case 5:
                //$('txtDescrRua'+sId).value              = '';
                $('txtCodigoNumero' + sId).value = '';
                me.setNumero('');
                $('txtCepEnd' + sId).value = '';
                me.setCepEndereco('');
                me.setCodigoEndereco('');
                $('txtDescrCondominio' + sId).value = '';
                me.setCondominio('');
                $('txtDescrLoteamento' + sId).value = '';
                me.setLoteamento('');
                $('txtDescrComplemento' + sId).value = '';
                me.setComplemento('');
                $('txtDescrPontoReferencia' + sId).value = '';
                me.setPontoReferencia('');
                $('txtCodigoIbge' + sId).value = '';
                me.setCodigoIbge('');
                //me.oCboRuasTipo.setValue(3);
                //me.setRuaTipo(3);
                me.setRuasTipo('');
                me.setCepRua('');
                break;
            case 6:
                $('txtCepEnd' + sId).value = '';
                $('txtDescrCondominio' + sId).value = '';
                $('txtDescrLoteamento' + sId).value = '';
                $('txtDescrComplemento' + sId).value = '';
                $('txtDescrPontoReferencia' + sId).value = '';
                break;
        }
    }

    /**
     *Método para salvar dados Complementares
     */
    this.salvarDadosComplementares = function () {
        // Aqui verifico se houve modificação e se o código do endereço esta setado

        if (me.getCodigoEndereco() != '' && me.lModificado == false) {
            me.close();
            me.callBackFunction();
            return false;
        }

        var oEndereco = new Object();

        //
        //   //Verifica se o País foi informado
        if ($F('cboCodigoPais' + sId).value == '' || $F('cboCodigoPais' + sId).value == 0) {
            $('cboCodigoPais' + sId).focus();
            alert("usuário:\n\n\País não informado!\n\n");
            return false;
        }

        //Verifica se o Municipio foi informado
        if ($F('cboCodigoMunicipio' + sId).trim() == '' && me.getTipoValidacao() == 1) {
            $('cboCodigoMunicipio' + sId).focus();
            alert("usuário:\n\n\Município não informado!\n\n");
            return false;
        } else if (me.getTipoValidacao() == 2 && $F('cboCodigoMunicipio' + sId) == '') {
            me.setMunicipio('0');
            me.setNomeMunicipio('');
        }

        // Verifica se o código da obra foi informado
        if ($F('txtCodigoObra' + sId).trim() == '') {
            alert('Campo Código Obra é obrigatório!\n\n');
            return false;
        }

        //Verifica se o Bairro foi informado
        // if ($F('txtDescrBairro' + sId).trim() == '' && me.getTipoValidacao() == 1) {
        //
        //     $('txtCodigoBairro' + sId).focus();
        //     alert("Usuário:\n\n\Bairro não informado!\n\n");
        //     return false;
        // } else if (me.getTipoValidacao() == 2 && $F('txtDescrBairro' + sId).trim() == '') {
        //     me.setBairro('0');
        //     me.setNomeBairro('');
        // }

        if ($F('txtGrausLatitude' + sId).trim() == '') {
            $('txtGrausLatitude' + sId).focus();
            alert("Usuário:\n\n\Graus da Latitude não informado!\n\n");
            return false;
        }

        if ($F('txtMinutoLatitude' + sId).trim() == '') {
            $('txtMinutoLatitude' + sId).focus();
            alert("Usuário:\n\n\Minuto da Latitude não informado!\n\n");
            return false;
        }

        if ($F('txtSegundoLatitude' + sId).trim() == '') {
            $('txtSegundoLatitude' + sId).focus();
            alert("Usuário:\n\n\Segundo da Latitude não informado!\n\n");
            return false;
        }

        if ($F('txtGrausLongitude' + sId).trim() == '') {
            $('txtGrausLongitude' + sId).focus();
            alert("Usuário:\n\n\Graus da Longitude não informado!\n\n");
            return false;
        }

        if ($F('txtMinutoLongitude' + sId).trim() == '') {
            $('txtMinutoLongitude' + sId).focus();
            alert("Usuário:\n\n\Minuto da Longitude não informado!\n\n");
            return false;
        }

        if ($F('txtSegundoLongitude' + sId).trim() == '') {
            $('txtSegundoLongitude' + sId).focus();
            alert("Usuário:\n\n\Segundo da Longitude não informado!\n\n");
            return false;
        }

        if ($F('cboClasseObjeto' + sId) == 0) {
            $('cboClasseObjeto' + sId).focus();
            alert("Usuário:\n\n\Classe do Objeto não informado!\n\n");
            return false;
        }

        if ($F('cboAtividadeServico' + sId) == '99') {
            if ($F('txtDescrAtividadeServico' + sId).trim() == '') {
                alert('Campo Descrição Atividade Serviço é obrigatório!\n\n');
                return false;
            }
            oEndereco.descrAtividadeServico = $F('txtDescrAtividadeServico' + sId);
        }

        if ($F('cboAtividadeServicoEsp' + sId) == '99') {
            if ($F('txtDescrAtividadeServicoEsp' + sId).trim() == '') {
                alert('Campo Descrição Atividade Serviço Especializado é obrigatório!\n\n');
                return false;
            }
            oEndereco.descrAtividadeServicoEsp = $F('txtDescrAtividadeServicoEsp' + sId);
        }

        // Verifica se o código da obra foi informado
        if ($F('cboGrupoBemPub' + sId) == 0) {
            alert('Campo Grupo Bem Público é obrigatório!\n\n');
            return false;
        }

        if ($F('cboSubGrupoBemPub' + sId) == 0 && $F('cboGrupoBemPub' + sId) != 99) {
            alert('Campo SubGrupo Bem Público é obrigatório!\n\n');
            return false;
        }

        if (!$F('txtLogradouro' + sId)) {
            alert('Campo Logradouro é obrigatório!\n\n');
            return false;
        }

        oEndereco.codigoPais = me.getPais();
        oEndereco.codigoEstado = me.getEstado();
        oEndereco.codigoMunicipio = me.getMunicipio();
        oEndereco.distrito = me.getDistrito();
        oEndereco.codigoBairro = me.getBairro();
        oEndereco.numero = me.getNumero();
        oEndereco.cep = $('txtCep' + sId).value;
        oEndereco.codigoObra = me.getCodigoObra();
        oEndereco.logradouro = me.getLogradouro();
        oEndereco.grausLatitude = me.getGrausLatitude();
        oEndereco.minutoLatitude = me.getMinutosLatitude();
        oEndereco.segundoLatitude = me.getSegundosLatitude();
        oEndereco.grausLongitude = me.getGrausLongitude();
        oEndereco.minutoLongitude = me.getMinutoLongitude();
        oEndereco.segundoLongitude = me.getSegundosLongitude();
        oEndereco.classeObjeto = me.getClassesObjeto();
        oEndereco.atividadeObra = me.getAtividadeObra();
        oEndereco.atividadeServico = me.getAtividadeServico();
        oEndereco.atividadeServicoEsp = me.getAtividadeServicoEspecializado();
        oEndereco.grupoBemPub = me.getGrupoBemPublico();
        oEndereco.subGrupoBemPub = me.getSubGrupoBemPublico();
        oEndereco.bdi = me.getBdi();
        oEndereco.licitacao = me.getLicitacao();
        oEndereco.descrBairro = $('txtDescrBairro' + sId).value;
        oEndereco.sequencial = me.getSequencial();

        oDados = new Object();
        oDados.exec = 'salvarDadosComplementares';
        oDados.endereco = oEndereco;
        oDados.acao = me.acao;

        var msgDiv = "Salvando Dados Complementares, aguarde...";
        js_divCarregando(msgDiv, 'msgBox');
        var oAjax = new Ajax.Request(
            me.sUrlRpc,
            {
                parameters: 'json=' + Object.toJSON(oDados),
                method: 'post',
                onComplete: me.retornoSalvaEndereco
            }
        );
    }
     /**
     *Metodo que trata o retorno da inclusao ou alteracao de um endereco
     */
    this.retornoSalvaEndereco = function (oAjax) {

        js_removeObj('msgBox');

        var oRetorno = eval('(' + oAjax.responseText + ')');
        var sExpReg = new RegExp('\\\\n', 'g');
        if (oRetorno.status == 1) {
            // me.setCodigoEndereco(oRetorno.icodigoEndereco);
            // $('cboCodigoMunicipio'+sId).value = oRetorno.icodigoMunicipio;
            // me.setMunicipio(oRetorno.icodigoMunicipio);
            // $('txtCodigoBairro'+sId).value    = oRetorno.icodigoBairro;
            // me.setBairro(oRetorno.icodigoBairro);
            // $('txtCodigoRua'+sId).value       = oRetorno.icodigoRua;
            // me.setRua(oRetorno.icodigoRua);
            //Fecha a janela e preenche o campo com o endereco informado
            alert('Dados salvos com sucesso!');
            me.close();
            me.callBackFunction();
            return false;
        } else {
            alert(oRetorno.message.urlDecode().replace(sExpReg, '\n'));
            me.setCodigoEndereco('');
        }

    }

     /**
     * Retorna se o endereco ? do municipio
     * @param bollean lEnderecoMunicipio
     */
    this.getCgmMunicipio = function () {
        return me.lEnderecoMunicipio;
    }

    this.setCgmMunicipio = function (lEnderecoMunicipio) {
        me.lEnderecoMunicipio = lEnderecoMunicipio;
    }

     /**
     *Seta como read only campos do endereco que nao podem ser modificados
     *quando o endereco e do municipio
     *@param bollean lEnderecoMunicipio true se for do município
     *return void
     */

    this.setEnderecoMunicipio = function (lEnderecoMunicipio) {

        me.setCgmMunicipio(lEnderecoMunicipio);
        //me.oTxtCep.setReadOnly(lEnderecoMunicipio);

        if (lEnderecoMunicipio) {

            me.oCboCodigoPais.setDisable();
            me.oCboCodigoEstado.setDisable();
            me.oCboCodigoMunicipio.setDisable();
            me.oCboRuasTipo.setDisable();

        } else {
            me.oCboCodigoPais.setEnable();
            me.oCboCodigoEstado.setEnable();
            me.oCboCodigoMunicipio.setEnable();
            me.oCboRuasTipo.setEnable();
        }

        $('btnPesquisarCep' + sId).disabled = lEnderecoMunicipio;
        $('cboCodigoMunicipio' + sId).value = me.getMunicipio();
    }

     /**
     *Retorna o tipo de validacao do formulario de endereco
     *return void
     */
    this.getTipoValidacao = function () {
        return this.iTipoValidacao;
    }
     /**
     *Seta o tipo de validacao do formulario de endereco
     *@param integer iTipoValidacao 1 - forte, 2 - fraca
     *return void
     */
    this.setTipoValidacao = function (iTipoValidacao) {
        this.iTipoValidacao = iTipoValidacao;
    }

    me.buscaEndereco();

    this.limpaForm = function () {

        var iCodEndereco = me.getCodigoEndereco();
        $('txtCep' + sId).value = '';
        me.clearAll(1);
        me.setCodigoEndereco('');
        me.oCboRuasTipo.setEnable();
        me.buscaEndereco();
        me.setCodigoEndereco(iCodEndereco);
    }

    this.setCallBackFunction = function (sFunction) {
        this.callBackFunction = sFunction;
    }

    this.buscaDescricoes = function () {
        setTimeout(() => {
            let aMunicipios = document.getElementById('cboCodigoMunicipio' + sId);
            let aEstados = document.getElementById('cboCodigoEstado' + sId);
            var oParam = Object();

            for (var cont = 0; cont < aEstados.options.length; cont++) {
                if (aEstados.options[cont].value == aEstados.value) {
                    oParam.estado = aEstados.options[cont].text;
                }
            }

            oParam.cidade = aMunicipios.options[aMunicipios.selectedIndex].text;
            oParam.exec = 'findCodigoIbge';

            var oAjax = new Ajax.Request(
                me.sUrlRpc,
                {
                    parameters: 'json=' + Object.toJSON(oParam),
                    method: 'post',
                    onComplete: me.preencheCodigo
                });

        }, 300);
    }

    this.preencheCodigo = function (oAjax) {
        var oRetorno = JSON.parse(oAjax.responseText);

        me.setCodigoIbge(oRetorno);
        $('txtCodigoIbge' + sId).value = oRetorno;

    }

    this.preencheCampos = function (codObra) {
        var oPesquisa = new Object();
        oPesquisa.exec = 'findDadosObra';
        oPesquisa.iSequencial = codObra;

        var msgDiv = "Aguarde carregando lista de estados.";
        js_divCarregando(msgDiv, 'msgBox');

        var oAjax = new Ajax.Request(
            me.sUrlRpc,
            {
                asynchronous: false,
                parameters: 'json=' + Object.toJSON(oPesquisa),
                method: 'post',
                onComplete: me.retornoCampos
            }
        );
    }

    this.retornoCampos = function (oAjax) {
        js_removeObj('msgBox');
        var oRetorno = eval('(' + oAjax.responseText + ')');
        let dadoscomplementares = oRetorno.dadoscomplementares[0];
        $('cboCodigoMunicipio' + sId).value = dadoscomplementares.municipio;
        $('txtLogradouro' + sId).value = decodeURI(dadoscomplementares.logradouro).replace(/\+/g, ' ');
        me.setLogradouro(dadoscomplementares.logradouro);
        $('txtDistrito' + sId).value = decodeURI(dadoscomplementares.distrito).replace(/\+/g, ' ');
        me.setDistrito(dadoscomplementares.distrito);
        $('txtCodigoObra' + sId).value = dadoscomplementares.codigoobra;
        me.setCodigoObra(dadoscomplementares.codigoobra);
        $('txtBdi' + sId).value = dadoscomplementares.bdi;
        me.setBdi(dadoscomplementares.bdi);
        $('txtGrausLatitude' + sId).value = dadoscomplementares.grauslatitude;
        me.setGrausLatitude(dadoscomplementares.grauslatitude);
        $('txtMinutoLatitude' + sId).value = dadoscomplementares.minutolatitude;
        me.setMinutosLatitude(dadoscomplementares.minutolatitude);
        $('txtSegundoLatitude' + sId).value = dadoscomplementares.segundolatitude;
        me.setSegundosLatitude(dadoscomplementares.segundolatitude);
        $('txtGrausLongitude' + sId).value = dadoscomplementares.grauslongitude;
        me.setGrausLongitude(dadoscomplementares.grauslongitude);
        $('txtMinutoLongitude' + sId).value = dadoscomplementares.minutolongitude;
        me.setMinutoLongitude(dadoscomplementares.minutolongitude);
        $('txtSegundoLongitude' + sId).value = dadoscomplementares.segundolongitude;
        me.setSegundosLongitude(dadoscomplementares.segundolongitude);
        $('txtCodigoNumero' + sId).value = dadoscomplementares.numero;
        me.setNumero(dadoscomplementares.numero);
        $('cboClasseObjeto' + sId).selectedIndex = dadoscomplementares.classeobjeto;
        me.setClassesObjeto(dadoscomplementares.classeobjeto);
        $('cboAtividadeObra' + sId).disabled = dadoscomplementares.atividadeobra > 0 ? false : true;
        $('cboAtividadeObra' + sId).value = dadoscomplementares.atividadeobra;
        me.setAtividadeObra(dadoscomplementares.atividadeobra);
        $('cboAtividadeServico' + sId).disabled = dadoscomplementares.atividadeservico > 0 ? false : true;
        $('cboAtividadeServico' + sId).value = dadoscomplementares.atividadeservico;
        me.setAtividadeServico(dadoscomplementares.atividadeservico);
        document.getElementById('trAtividadeServico'+sId).style.display = (me.getAtividadeServico() == '99') ? '' : 'none';
        $('cboAtividadeServicoEsp' + sId).disabled = dadoscomplementares.atividadeservicoesp > 0 ? false : true;
        $('cboAtividadeServicoEsp' + sId).value = dadoscomplementares.atividadeservicoesp;
        me.setAtividadeServicoEspecializado(dadoscomplementares.atividadeservicoesp);
        document.getElementById('trAtividadeServicoEsp'+sId).style.display = (me.getAtividadeServicoEspecializado() == '99') ? '' : 'none';
        $('cboGrupoBemPub' + sId).value = dadoscomplementares.grupobempublico;
        me.setGrupoBemPublico(dadoscomplementares.grupobempublico);
        me.preencheSubGrupo(dadoscomplementares.grupobempublico);
        $('cboSubGrupoBemPub' + sId).value = dadoscomplementares.subgrupobempublico;
        me.setSubGrupoBemPublico(dadoscomplementares.subgrupobempublico);
        $('txtDescrBairro' + sId).value = decodeURI(dadoscomplementares.bairro).replace(/\+/g, ' ');
        $('txtCep' + sId).value = dadoscomplementares.cep;
        $('txtDescrAtividadeServico' + sId).value = unescape(decodeURI(dadoscomplementares.descratividadeservico).replace(/\+/g, ' '));
        $('txtDescrAtividadeServicoEsp' + sId).value = unescape(decodeURI(dadoscomplementares.descratividadeservicoesp).replace(/\+/g, ' '));
        me.setSequencial(dadoscomplementares.sequencial);

        let params = eval('('+oAjax.request.parameters.json+')');
        me.checkFirstRegister(params.iSequencial);

    }

    this.checkFirstRegister = function(sequencial){
        var oPesquisa = new Object();
        oPesquisa.exec = 'isFirstRegister';
        oPesquisa.iCodigo = $('txtCodigoObra'+sId).value;
        oPesquisa.iSequencial = sequencial;

        var oAjax = new Ajax.Request(
            me.sUrlRpc,
            {
                asynchronous: false,
                parameters: 'json=' + Object.toJSON(oPesquisa),
                method: 'post',
                onComplete: me.returnCheckRegister
            }
        );
    }

    this.returnCheckRegister = function(oAjax){
        let response = eval('('+oAjax.responseText+')');

        if(response.status == 2){
            $('txtCodigoObra'+sId).setAttribute('class', 'readonly');
            $('txtCodigoObra'+sId).setAttribute('disabled', 'disabled');
        }
    }
}

