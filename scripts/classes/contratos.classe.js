contrato = function () {

    me = this;
    this.verificaLicitacoes = function () {

        let negation = '';
        let tipoCompras = '';
        let iOrigem = $('ac16_origem').value;
        let iTipoOrigem = $('ac16_tipoorigem').value;

        if( iOrigem == '2'){
            if(iTipoOrigem == '2'){
                negation = ' not ';
                tipoCompras = '100, 101, 102, 103';
            }

            if(iTipoOrigem == '3'){
                negation = '';
                tipoCompras = $('tipodispenca').value == '2' ? '100, 101' : $('tipodispenca').value == '1' ? '102, 103' : '';
            }

        }

        var sFuncao = '';
        if ($F('ac16_origem') == 2) {
            sFuncao = 'getLicitacoesContratado';
        } else if ($F('ac16_origem') == 1) {
            sFuncao = 'getProcessosContratado';
        } else {
            return true;
        }

        var oParam         = new Object();
        oParam.exec        = sFuncao;
        oParam.iContratado = $F('ac16_contratado');
        oParam.iContrato   = $F('ac16_sequencial');
        oParam.iTipoOrigem = $F('ac16_tipoorigem');
        oParam.credenciamento = $F('tipodispenca');
        oParam.addNegation    = negation;
        oParam.tipoCompras = tipoCompras;
        js_divCarregando("Aguarde, carregando as licitações...", "msgBox");
        var oAjax   = new Ajax.Request(
            sURL,
            {
                method    : 'post',
                parameters: 'json='+Object.toJSON(oParam),
                onComplete: me.mostraLicitacoesContratado
            }
        );
    }

    this.mostraLicitacoesContratado = function(oResponse)  {

        js_removeObj("msgBox");
        var oRetorno = eval("("+oResponse.responseText+")");
        var sTitulo = '';
        if ($F('ac16_origem') == 1) {
            sTitulo = "Processo de compras";
        } else {
            sTitulo = "Licitações";
        }
        var iLarguraJanela = 1200;
        var iAlturaJanela  = document.body.clientHeight;

        oJanela       = new windowAux('wndLicitacoesVencidas', sTitulo,
            iLarguraJanela,
            iAlturaJanela);

        let sContent     = '  <fieldset style="width: 97%"><legend><b>'+sTitulo+'</b></legend>';
        sContent     += '    <div id="cntDados" style="width:1175px"></div>' ;
        sContent     += '  </fieldset>';
        sContent     += '  <center> ';
        sContent     += '   <input type="button" value="Confirmar" id="btnConfirmarObjetos">';
        sContent     += '  </center> ';

        oJanela.setContent(sContent);
        oMessageBoard = new DBMessageBoard('messageboardlicitacao',
            sTitulo +" vencidas por "+$F('nomecontratado'),
            'Escolha as licitações que farão parte do contrato',
            $('windowwndLicitacoesVencidas_content')
        );
        oJanela.setShutDownFunction(function() {
            oJanela.destroy();
        });

        /**
         * Define o callback para o botao confirmar
         */
        $('btnConfirmarObjetos').observe("click", function (){
            me.confirmaSelecao();
        });
        /*
         * Montamos a grid com os dados
         */
        oGridDados              = new DBGrid('gridDados');
        oGridDados.nameInstance = 'oGridDados';
        oGridDados.setCheckbox(0);
        oGridDados.setHeight(300);
        oGridDados.selectAll = function(idObjeto, sClasse, sLinha) {}; //reeinscrita a funcao selecionar todos, pois somente um sera permitido

        /**
         * reescrita função selectSingle para permitir somente um item selecionados
         */
        oGridDados.selectSingle = function (oCheckbox,sRow,oRow) {

            itens = document.getElementsByClassName("checkboxgridDados");

            for (var i = 0;i < itens.length;i++){

                itens[i].checked = false;
                $('gridDadosrowgridDados'+i).className = 'normal';
                oGridDados.aRows[i].isSelected = false;
            }

            $(sRow).className = 'marcado';
            $(oCheckbox.id).checked = true;
            oRow.isSelected   = true;


            return true;
        };

        oGridDados.setCellWidth(new Array("5%", "4%", "60%", "11%", "10%"));
        oGridDados.setCellAlign(new Array("right", "right", "left", "right", "right"));
        oGridDados.setHeader(new Array("Código","Número", "Objeto", "Número do Exercício", "Data da Inclusão"));
        oGridDados.show($('cntDados'));


        oJanela.show(1,70);
        js_divCarregando("Aguarde, carregando itens...", "msgBox");
        me.preencheDadosItens(oRetorno);
    };

    this.verificaNaturezadoObjeto = function(){
        var oParam = new Object();
        oParam.exec = "buscarNatureza";
        oParam.iContratado = $F('ac16_contratado');
        var oAjax = new Ajax.Request(
            sURL,{
                method :'post',
                parameters: 'json='+Object.toJSON(oParam),
                onComplete: me.mostraNaturezaObjeto
            }
        );
    }

    this.mostraNaturezaObjeto = function(oAjax) {

        var oRetorno = eval("("+oAjax.responseText+")");
        if (oRetorno.status == 1) {

            var cont = Object.keys(oRetorno.numero).length;
            var op = 0;
            let oAcordo = $('ac02_natureza_obj').value;
            for (i = 0; i<cont; i++){
                valorObjeto = oRetorno.numero[i];
                if(oRetorno.numero[i]===oAcordo){
                    op = 1;
                }
            }
        $('ac16_contratado_Natu').value = op;
        } else {

            alert(oRetorno.message.urlDecode());
            return false;
        }
    }

    this.preencheDadosItens = function(oDados) {

        js_removeObj("msgBox");
        oGridDados.clearAll(true);
        if (oDados.itens.length > 0) {

            for (var i = 0; i < oDados.itens.length; i++) {

                with (oDados.itens[0]) {

                    var aLinha = new Array();
                    aLinha[0]  = oDados.itens[i].licitacao;
                    aLinha[1]  = oDados.itens[i].numero;
                    aLinha[2]  = oDados.itens[i].objeto.urlDecode();
                    aLinha[3]  = oDados.itens[i].numero_exercicio;
                    aLinha[4]  = js_formatar(oDados.itens[i].data, 'd');

                    var lMarcado = false;

                    if (js_search_in_array(oDados.itensSelecionados, oDados.itens[i].licitacao)) {
                        lMarcado = true;
                    }
                    oGridDados.addRow(aLinha, false, false, lMarcado);
                }
            }

            oGridDados.renderRows();
            oGridDados.setStatus("");
            me.setPropertiesCss();
        } else {

            oGridDados.setStatus("Não foram Encontrados registros");
        }
    };


    this.setPropertiesCss = () => {

        let aTrs = document.querySelectorAll('#gridDadosbody tr');

        for( let i=0; i < aTrs.length; i++){

            aTrs[i].children[0].style.textAlign = 'center';
            aTrs[i].children[0].style.width = '88px';
            aTrs[i].children[1].style.textAlign = 'center';
            aTrs[i].children[2].style.textAlign = 'center';
            aTrs[i].children[4].style.textAlign = 'center';
            aTrs[i].children[5].style.textAlign = 'center';

        }

        document.getElementById('cntDados').style.width = '1198px';
        document.getElementById('messageboardlicitacao').style.width = '1215px';

    }

    this.confirmaSelecao = function() {

        var aItensSelecionados = oGridDados.getSelection("object");

        if (aItensSelecionados.length == 0) {

            alert('Não foram selecionados nenhum item.');
            return false;
        } else {

            if (aItensSelecionados.length > 1) {

                alert("Permitida Seleção de Somente um Julgamento!!");
                return false;
            }


        }
//cntDados

        var oParam     = new Object();
        oParam.exec    = "setDadosSelecao";
        oParam.itens   = new Array();
        var sDescricao = new String();
        aItensSelecionados.each(function(oLinha, id) {

            if (oLinha.aCells[3].getContent() != "&nbsp;") {
                sDescricao += oLinha.aCells[3].getContent().trim()+". ";
            }
            oParam.itens.push(oLinha.aCells[1].getValue());

        });
        $('ac16_objeto').value       = sDescricao.trim();

        var oAjax   = new Ajax.Request(
            sURL,
            {
                method    : 'post',
                parameters: 'json='+Object.toJSON(oParam),
                onComplete: me.retornoSetDadosSelecao
            }
        );
    }

    this.retornoSetDadosSelecao = function(oAjax) {

        var oRetorno = eval("("+oAjax.responseText+")");
        if (oRetorno.status == 1) {

            oJanela.destroy();
            $('ac16_deptoresponsavel').focus();

        } else {
            alert(oRetorno.message.urlDecode());
        }
    }

    this.getNumeroAcordo  = function() {

        var oParam         = new Object();
        oParam.exec        = 'getNumeroContrato';
        oParam.iGrupo      = $F('ac16_acordogrupo');
        $('ac16_numeroacordo').disabled = true;
        var oAjax   = new Ajax.Request(
            sURL,
            {
                method    : 'post',
                parameters: 'json='+Object.toJSON(oParam),
                onComplete: me.retornoNumeroContrato
            }
        );
    }

    this.getNumeroAcordoAno  = function(iAno,iInstit) {

        var oParam         = new Object();
        oParam.exec        = 'getNumeroContratoAno';
        oParam.iAno        = iAno;
        oParam.iInstit     = iInstit;
        $('ac16_numeroacordo').disabled = true;
        var oAjax   = new Ajax.Request(
            sURL,
            {
                method    : 'post',
                parameters: 'json='+Object.toJSON(oParam),
                onComplete: me.retornoNumeroContratoAno
            }
        );
    }

    this.retornoNumeroContrato = function (oAjax) {

        $('ac16_numeroacordo').disabled = false;
        var oRetorno = eval("("+oAjax.responseText+")");
        if (oRetorno.status == 1) {

            $('ac16_numeroacordo').value = oRetorno.numero;
        } else {

            alert(oRetorno.message.urlDecode());
            $('ac16_acordogrupo').value = '';
            $('ac02_descricao').value   = '';
            return false;
        }
    }

    this.retornoNumeroContratoAno = function (oAjax) {

        $('ac16_numeroacordo').disabled = false;
        var oRetorno = eval("("+oAjax.responseText+")");
        if (oRetorno.status == 1) {

            $('ac16_numeroacordo').value = oRetorno.numero;
        } else {

            alert(oRetorno.message.urlDecode());
            $('ac16_acordogrupo').value = '';
            $('ac02_descricao').value   = '';
            return false;
        }
    }
    /**
     *Salva os dados do contrato
     */
    this.saveContrato = function () {

        var iGrupoContrato            = $F('ac16_acordogrupo');
        var iNumero                   = $F('ac16_numeroacordo');
        var iOrigem                   = $F('ac16_origem');
        var iTipoOrigem               = $F('ac16_tipoorigem');
        var iContratado               = $F('ac16_contratado');
        var iContratdo_Nat            = $F('ac16_contratado_Natu');
        var iDepartamentoResponsavel  = $F('ac16_deptoresponsavel');
        var iComissao                 = $F('ac16_acordocomissao');
        var dtInicio                  = $F('ac16_datainicio');
        var dtTermino                 = $F('ac16_datafim');
        var iAnousu                   = $F('ac16_anousu');
        var sObjeto                   = $F('ac16_objeto');
        var iQtdRenovacao             = $F('ac16_qtdrenovacao');
        var iUnidRenovacao            = $F('ac16_tipounidtempo');
        var sProcesso                 = encodeURIComponent($F('ac16_numeroprocesso'));
        var sFormaFornecimento        = encodeURIComponent($F('ac16_formafornecimento'));
        var sFormaPagamento           = encodeURIComponent($F('ac16_formapagamento'));
        var lEmergencial              = $F('ac26_emergencial')=='f'?false:true;
        var lPeriodoComercial         = $F('ac16_periodocomercial');
        var iCategoriaAcordo          = $F('ac50_sequencial');
        var iTipoUnidadeTempoVigencia = $F('ac16_tipounidtempoperiodo');
        var iQtdPeriodoVigencia       = $F('ac16_qtdperiodo');
        var nValorContrato            = $F('ac16_valor');
        var iLicitacao                = $F('ac16_licitacao');
        var iAdesaoregpreco           = $F('ac16_adesaoregpreco');
        var iLicoutroorgao            = $F('ac16_licoutroorgao');
        var iLei                      = $F('ac16_lei');

        /* Novas validações para atender o SICOM */

        if(iOrigem == '3') {
            if ((iTipoOrigem == '2' || iTipoOrigem == '3') && !iLicitacao) {
                alert('Informe uma Licitação.');
                $('ac16_licitacao').focus();
                return false;
            }

            if(iTipoOrigem == '4' && !iAdesaoregpreco){
                alert('Informe uma Adesão de Registro de Preço.');
                $('ac16_adesaoregpreco').focus();
                return false;
            }

            if(['5', '6', '7', '8', '9'].includes(iTipoOrigem) && !iLicoutroorgao){
                alert('Informe uma Licitação por Outro Órgão.');
                $('ac16_licoutroorgao').focus();
                return false;
            }
        }

        if (iOrigem == "0") {

            alert('Informe a origem do acordo.');
            $('ac16_origem').focus();
            return false;
        }
        if (iTipoOrigem == "0") {

            alert('Informe o Tipo da origem do acordo.');
            $('ac16_tipoorigem').focus();
            return false;
        }

        if (iGrupoContrato == "") {

            alert('Informe o grupo do acordo.');
            $('ac16_acordogrupo').focus();
            return false;
        }
        if (iNumero == "") {

            alert('Informe o número do acordo.');
            $('ac16_numeroacordo').focus();
            return false;
        }

        if (iContratado == "") {

            alert('Informe o contratado do acordo.');
            $('ac16_contratado').focus();
            return false;
        }
        if (iContratdo_Nat == 0 && iOrigem == 2) {

            alert('Natureza do contrato divergente da natureza do objeto da Licitação');
            $('ac16_contratado').focus();
            $('ac16_acordogrupo').focus();
            return false;
        }
        if (iDepartamentoResponsavel == "") {

            alert('Informe o Departamento Responsável.');
            $('ac16_deptoresponsavel').focus();
            return false;
        }
        // if (iComissao == "") {

        //     alert('Informe a comissão de vistoria do acordo.');
        //     $('ac16_acordocomissão').focus();
        //     return false;
        // }

        if (iAnousu == "") {

            alert('Informe o ano do contrato.');
            $('ac16_anousu').focus();
            return false;

        }
        if (dtInicio == "") {

            alert('Informe a data de início do Contrato.');
            $('ac16_datainicio').focus();
            return false;
        }

        if (dtTermino == "") {

            alert('Informe a data de termino do Contrato.');
            $('ac16_datafim').focus();
            return false;
        }

        if (js_comparadata(dtTermino, dtInicio, "<")) {

            alert('Data do termino do contrato deve ser maior que a data de inicio do contrato.');
            $('ac16_datafim').focus();
            return false;
        }

        if (iCategoriaAcordo == "" || iCategoriaAcordo == 0) {

            alert('Informe a categoria do Contrato.');
            $('ac50_sequencial').focus();
            return false;
        }


        if (sObjeto == "") {

            alert('Informe o objeto do Contrato.');
            $('ac16_objeto').focus();
            return false;
        }

        if (iOrigem == 6 && empty(nValorContrato)) {

            alert('Informe o valor do contrato.');
            $('ac16_valor').focus();
            return false;
        }

      if(iGrupoContrato == 1 && iQtdPeriodoVigencia == ""){
            alert('Unid.Execução/Entrega não informado.');
            $('ac16_qtdperiodo').focus();
            return false;
      }
      if(iGrupoContrato == 2 && iQtdPeriodoVigencia == ""){
            alert('Unid.Execução/Entrega não informado.');
            $('ac16_qtdperiodo').focus();
            return false;
      }
      if(iGrupoContrato == 3 && iQtdPeriodoVigencia == ""){
            alert('Unid.Execução/Entrega não informado.');
            $('ac16_qtdperiodo').focus();
            return false;
      }
      if(iGrupoContrato == 7 && iQtdPeriodoVigencia == ""){
            alert('Unid.Execução/Entrega não informado.');
            $('ac16_qtdperiodo').focus();
            return false;
      }

        var oParam      = new Object();
        oParam.exec     = "salvarContrato";
        oParam.contrato = new Object();

        oParam.contrato.iOrigem                   = iOrigem;
        oParam.contrato.iTipoOrigem               = iTipoOrigem;
        oParam.contrato.iGrupo                    = iGrupoContrato;
        oParam.contrato.iNumero                   = iNumero;
        oParam.contrato.iCodigo                   = $F('ac16_sequencial');
        oParam.contrato.iContratado               = iContratado;
        oParam.contrato.iDepartamentoResponsavel  = iDepartamentoResponsavel;
        oParam.contrato.iComissao                 = iComissao;
        oParam.contrato.iAnousu                   = iAnousu;
        oParam.contrato.dtInicio                  = dtInicio;
        oParam.contrato.dtTermino                 = dtTermino;
        oParam.contrato.sObjeto                   = encodeURIComponent(tagString(sObjeto));
        oParam.contrato.iQtdRenovacao             = iQtdRenovacao;
        oParam.contrato.iUnidRenovacao            = iUnidRenovacao;
        oParam.contrato.lEmergencial              = lEmergencial;
        oParam.contrato.sProcesso                 = sProcesso;
        oParam.contrato.sFormaFornecimento        = sFormaFornecimento;
        oParam.contrato.sFormaPagamento           = sFormaPagamento;
        oParam.contrato.lPeriodoComercial         = lPeriodoComercial;
        oParam.contrato.iCategoriaAcordo          = iCategoriaAcordo;
        oParam.contrato.iTipoUnidadeTempoVigencia = iTipoUnidadeTempoVigencia;
        oParam.contrato.iQtdPeriodoVigencia       = iQtdPeriodoVigencia;
        oParam.contrato.nValorContrato            = nValorContrato;
        oParam.contrato.iLicitacao                = iLicitacao;
        oParam.contrato.iAdesaoregpreco           = iAdesaoregpreco;
        oParam.contrato.iLicoutroorgao            = iLicoutroorgao;
        oParam.contrato.iLei                      = iLei;
        js_divCarregando('Aguarde, salvando dados do contrato','msgbox');
        var oAjax   = new Ajax.Request(
            sURL,
            {
                method    : 'post',
                parameters: 'json='+Object.toJSON(oParam),
                onComplete: me.retornoSaveContrato
            }
        );
    }

    this.bloqueiaCampos = function() {

        $('ac16_acordogrupo').disabled             = true;
        $('ac16_numeroacordo').disabled                  = true;
        $('ac16_origem').disabled                  = true;
        $('ac16_anousu').disabled                  = true;
        $('ac16_tipoorigem').disabled              = true;
        $('ac16_contratado').disabled              = true;
        $("ac16_periodocomercial").disabled        = true;
        $("ac16_datainicio").disabled              = true;
        $("ac16_datafim").disabled                 = true;
        $("ac16_deptoresponsavel").disabled        = true;
        $("ac16_acordocomissao").disabled          = true;
        $("ac16_datainicio").style.backgroundColor = "#DEB887";
        $("ac16_datafim").style.backgroundColor    = "#DEB887";
        $("ac16_anousu").style.backgroundColor    = "#DEB887";



        //Desabilita o botao "D" do calendario
        //getByName do prototype
        var btDataInicio = $$('[name="dtjs_ac16_datainicio"]')[0];
        var btDataFim    = $$('[name="dtjs_ac16_datafim"]')[0];

        if (btDataInicio) {
            btDataInicio.disabled = true;
        }

        if (btDataFim) {
            btDataFim.disabled = true;
        }

        //Bloqueando ancoras
        var aAncoras = document.getElementsByClassName("dbancora");

        for (var iAncora = 0; iAncora < aAncoras.length; iAncora++) {

            //iAncora 4 é referente a âncora Categoria.
            if (iAncora != 0) {

                aAncoras[iAncora].setAttribute("onclick", "");
                aAncoras[iAncora].setAttribute("style", "text-decoration: none; color: #000;");
            }
        }

    }

    this.retornoSaveContrato = function (oAjax) {

        $('db_opcao').disabled = false;
        js_removeObj('msgbox');

        var oRetorno = eval("("+oAjax.responseText+")");
        if (oRetorno.status == 1) {

            $('ac16_sequencial').value = oRetorno.iCodigoContrato;
            $('ac16_datainclusao').value = js_formatar(oRetorno.sDataInclusao,"d");
            $('ac16_anousu').value = oRetorno.iAnousu;
            if ($F('ac16_origem') == 6 || $F('ac16_origem') == '6' ) {

                $('pesquisarEmpenhos').style.display = 'inLine';
            }

            me.bloqueiaCampos();

            parent.document.formaba.acordoitem.disabled       = false;
            top.corpo.iframe_acordoitem.location.href         = 'aco1_acordoitem001.php?ac20_acordo='+oRetorno.iCodigoContrato;
            parent.document.formaba.acordogarantia.disabled   = false;
            top.corpo.iframe_acordogarantia.location.href     = 'aco1_acordoacordogarantia001.php?ac12_acordo='+oRetorno.iCodigoContrato;
            parent.document.formaba.acordopenalidade.disabled = false;
            top.corpo.iframe_acordopenalidade.location.href   = 'aco1_acordoacordopenalidade001.php?ac13_acordo='+oRetorno.iCodigoContrato;
            parent.document.formaba.acordodocumento.disabled  = false;
            top.corpo.iframe_acordodocumento.location.href    = 'aco1_acordodocumento001.php?ac40_acordo='+oRetorno.iCodigoContrato;
            alert("Acordo Salvo com Sucesso.");
            parent.mo_camada('acordoitem');
        } else {

            alert(oRetorno.message.urlDecode());
            return false;
        }
    }

    this.getContrato = function(iContrato) {

        var oParam         = new Object();
        oParam.exec        = 'getDadosAcordo';
        oParam.iContrato   = iContrato;
        js_divCarregando('Aguarde, pesquisando dados do contrato', 'msgBox');
        var oAjax   = new Ajax.Request(
            sURL,
            {
                method    : 'post',
                parameters: 'json='+Object.toJSON(oParam),
                onComplete: me.retornoGetContrato
            }
        );

    }

    this.retornoGetContrato = function(oAjax) {


        me.bloqueiaCampos();
        var oBtnOpcao = $('db_opcao');

        oBtnOpcao.disabled = false;
        js_removeObj('msgBox');
        var oRetorno  = eval("("+oAjax.responseText+")");
        if (oRetorno.status == 1) {

            oBtnOpcao.value            = 'Alterar';
            oBtnOpcao.name             = 'alterar';
            $('ac16_sequencial').value = oRetorno.contrato.iSequencial;
            $('ac16_datainclusao').value            = js_formatar(oRetorno.contrato.dtInclusao,'d');
            $('ac16_origem').value     = oRetorno.contrato.iOrigem;
            $('ac16_tipoorigem').value     = oRetorno.contrato.iTipoOrigem;

            if (oRetorno.contrato.iOrigem == 6 || oRetorno.contrato.iOrigem == '6') {
                $('pesquisarEmpenhos').style.display = 'inLine';
            }
            //alert(oRetorno.contrato.sNumeroProcesso.urlDecode());
            $('ac16_acordogrupo').value           = oRetorno.contrato.iGrupo;
            $('ac16_licitacao').value             = oRetorno.contrato.iLicitacao;
            $('ac16_adesaoregpreco').value        = oRetorno.contrato.iAdesaoregpreco;
            $('ac16_licoutroorgao').value         = oRetorno.contrato.iLicoutroorgao;
            $('ac16_numeroacordo').value          = oRetorno.contrato.iNumero;
            $('ac16_contratado').value            = oRetorno.contrato.iContratado;
            $('nomecontratado').value             = oRetorno.contrato.sNomeContratado.urlDecode();
            $('ac16_deptoresponsavel').value      = oRetorno.contrato.iDepartamentoResponsavel;
            $('descrdepto').value                 = oRetorno.contrato.sNomeDepartamentoResponsavel.urlDecode();
            $('ac16_acordocomissao').value        = oRetorno.contrato.iComissao;
            $('ac08_descricao').value             = oRetorno.contrato.sNomeComissao.urlDecode();
            $('ac16_lei').value                   = oRetorno.contrato.sLei.urlDecode();
            $('ac16_anousu').value                = oRetorno.contrato.iAnousu.urlDecode();
            $('ac16_datainicio').value            = oRetorno.contrato.dtInicio;
            $('ac16_datafim').value               = oRetorno.contrato.dtTermino;
            $('ac16_objeto').value                = oRetorno.contrato.sObjeto.urlDecode();
            $('ac16_numeroprocesso').value      = oRetorno.contrato.sNumeroProcesso.urlDecode();
            $('ac16_formafornecimento').value     = oRetorno.contrato.sFormaFornecimento.urlDecode();
            //$('ac16_veiculodivulgacao').value     = oRetorno.contrato.sVeiculoDivulgacao.urlDecode();
            $('ac16_formapagamento').value     = oRetorno.contrato.sFormaPagamento.urlDecode();
            //$('ac16_cpfsignatariocontratante').value     = oRetorno.contrato.sCpfsignatariocontratante.urlDecode();
            $('ac16_qtdrenovacao').value          = oRetorno.contrato.iNumeroRenovacao;
            $('ac16_tipounidtempo').value         = oRetorno.contrato.iTipoRenovacao;
            $('ac16_periodocomercial').value      = oRetorno.contrato.lPeriodoComercial;
            $('ac50_sequencial').value            = oRetorno.contrato.iCategoriaAcordo;
            $('ac16_tipounidtempoperiodo').value  = oRetorno.contrato.iTipoUnidadeTempoVigencia;
            $('ac16_qtdperiodo').value            = oRetorno.contrato.iQtdPeriodoVigencia;
            //$('ac16_acordoclassificacao').value   = oRetorno.contrato.iClassificacao;
            $('ac16_valor').value                 = js_formatar(oRetorno.contrato.nValorContrato, 'f');
            js_verificatipoorigem();
            js_pesquisaac16_acordogrupo(false);
            js_pesquisaac50_descricao(false);

            if (oRetorno.contrato.iTipoOrigem == 4 || oRetorno.contrato.iTipoOrigem == 5) {
                js_pesquisaaadesaoregpreco(false);
                js_pesquisaac16_licoutroorgao(false);
            }


            me.mostraValorAcordo();

            var dtInicio                     = oRetorno.contrato.dtInicio;
            var dtTermino                    = oRetorno.contrato.dtTermino;
            if (js_somarDiasVigencia(dtInicio, dtTermino) != false) {
                $('diasvigencia').value        = js_somarDiasVigencia(dtInicio, dtTermino);
            }
            parent.document.formaba.acordogarantia.disabled = false;
            top.corpo.iframe_acordogarantia.location.href   = 'aco1_acordoacordogarantia001.php?ac12_acordo='+
                oRetorno.contrato.iSequencial;
            parent.document.formaba.acordopenalidade.disabled = false;
            top.corpo.iframe_acordopenalidade.location.href   = 'aco1_acordoacordopenalidade001.php?ac13_acordo='+
                oRetorno.contrato.iSequencial;
            js_exibeBotaoJulgamento();

        }
    };

    /**
     * Verifica se deve mostrar o valor para alteração ou não
     */
    this.mostraValorAcordo = function() {

        if ($('ac16_origem').value == 6) {
            $('trValorAcordo').style.display = 'table-row';
            $('ac16_valor').readOnly         = false;
        }
    };

}
