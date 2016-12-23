function dbViewAditamentoContrato(iTipoAditamento, sNomeInstance, oNode) {

    var me = this,
        aItensPosicao = new Array();

    this.lLiberaDotacoes = true;
    this.lLiberaNovosItens = true;
    this.sLabelBotao = '';
    this.lDatas = false;
    this.lBloqueiaItem = false;
    this.lObrigaDescricao = false;
    this.lTipoAlteracao = false;

    switch (iTipoAditamento) {

        case 2:

            this.lLiberaDotacoes = true;
            this.lDatas = false;
            this.lLiberaNovosItens = false;
            this.sLabelBotao = "Reequil�brio";
            this.lBloqueiaItem = false;
            this.lObrigaDescricao = false;
            this.lTipoAlteracao = false;
            break;

        case 4:

            this.lLiberaDotacoes = true;
            this.lDatas = false;
            this.lLiberaNovosItens = false;
            this.sLabelBotao = "Aditamento";
            this.lBloqueiaItem = false;
            this.lObrigaDescricao = false;
            this.lTipoAlteracao = false;
            break;

        case 5:

            this.lLiberaDotacoes = true;
            this.lDatas = true;
            this.lLiberaNovosItens = false;
            this.sLabelBotao = "Renova��o";
            this.lBloqueiaItem = false;
            this.lObrigaDescricao = false;
            this.lTipoAlteracao = false;
            break;

        case 6:

            this.lLiberaDotacoes = false;
            this.lDatas = true;
            this.lLiberaNovosItens = false;
            this.sLabelBotao = "Prazo";
            this.lBloqueiaItem = true;
            this.lObrigaDescricao = false;
            this.lTipoAlteracao = false;
            break;

        case 7:
            this.lLiberaDotacoes = true;
            this.lDatas = true;
            this.lLiberaNovosItens = false;
            this.sLabelBotao = "Aditamento";
            this.lBloqueiaItem = false;
            this.lObrigaDescricao = true;
            this.lTipoAlteracao = true;
            break;

        case 8:
            this.lLiberaDotacoes = false;
            this.lDatas = false;
            this.lLiberaNovosItens = false;
            this.sLabelBotao = "Execu��o";
            this.lBloqueiaItem = false;
            this.lObrigaDescricao = false;
            this.lTipoAlteracao = false;
            break;
    }

    this.aPeriodoItensNovos = new Array()
    this.sInstance = sNomeInstance;
    this.iTipoAditamento = iTipoAditamento;
    this.sUrlRpc = 'con4_contratosaditamentos.RPC.php';

    oNode.style.display = 'none';

    sContent = " <table>";
    sContent += "   <tr>";
    sContent += "     <td> ";
    sContent += "       <fieldset> ";
    sContent += "         <legend>Dados do Acordo</legend>";
    sContent += "         <table width='100%'> ";

    sContent += "           <tr> ";
    sContent += "             <td nowrap width=\"1%\"> ";
    sContent += "               <label class=\"bold\" for=\"oTxtCodigoAcordo\"> ";
    sContent += "                 <a href='javascript:;' onclick='" + me.sInstance + ".consultaAcordo(); return false;'>Acordo:</a>";
    sContent += "               </label> ";
    sContent += "             </td>";
    sContent += "             <td id=\"ctnCodigoAcordo\"></td>";
    sContent += "           </tr> ";

    sContent += "           <tr> ";
    sContent += "             <td nowrap> ";
    sContent += "               <label class=\"bold\" for=\"oTxtNumeroAditamento\">N�mero do Aditamento:</label>";
    sContent += "             </td>";
    sContent += "             <td id=\"ctnTxtNumeroAditamento\"></td>";
    sContent += "           </tr> ";

    sContent += "           <tr> ";
    sContent += "             <td nowrap> ";
    sContent += "               <label class=\"bold\" for=\"oTxtDataAssinatura\">Data de Assinatura:</label>";
    sContent += "             </td>";
    sContent += "             <td id=\"ctnDataAssinatura\"></td>";
    sContent += "           </tr> ";

    sContent += "           <tr> ";
    sContent += "             <td nowrap> ";
    sContent += "               <label class=\"bold\" for=\"oTxtDataPublicacao\">Data de Publicacao:</label>";
    sContent += "             </td>";
    sContent += "             <td id=\"ctnDataPublicacao\"></td>";
    sContent += "           </tr> ";

    sContent += "           <tr> ";
    sContent += "             <td nowrap> ";
    sContent += "               <label class=\"bold\" for=\"oTextAreaDescricaoAlteracao\">Descri��o da Altera��o:</label>";
    sContent += "             </td>";
    sContent += "             <td id=\"ctnDescricaoAlteracao\"></td>";
    sContent += "           </tr> ";

    sContent += "           <tr> ";
    sContent += "             <td nowrap> ";
    sContent += "               <label class=\"bold\" for=\"oTxtVeiculoDivulgacao\">Ve�culo de Divulga��o:</label>";
    sContent += "             </td>";
    sContent += "             <td id=\"ctnVeiculoDivulgacao\"></td>";
    sContent += "           </tr> ";

    if(iTipoAditamento == 7) {
        sContent += "           <tr> ";
        sContent += "             <td nowrap> ";
        sContent += "               <label class=\"bold\" for=\"oCboTipoAditivo\">Tipo do Aditivo:</label>";
        sContent += "             </td>";
        sContent += "             <td id=\"ctnTipoAditivo\"></td>";
        sContent += "           </tr> ";
    }

    sContent += "           <tr> ";
    sContent += "             <td colspan='2'>";
    sContent += "               <fieldset class=\"separator\">";
    sContent += "                 <legend>Vig�ncia</legend> ";
    sContent += "                 <table border='0'> ";
    sContent += "                    <tr> ";
    sContent += "                      <td><label class=\"bold\" for=\"oTxtDataInicial\">Inicial:</td> ";
    sContent += "                      <td id=\"ctnVigenciaInicial\"></td> ";
    sContent += "                      <td><label class=\"bold\" for=\"oTxtDataFinal\">Final:<label></td> ";
    sContent += "                      <td id=\"ctnVigenciaFinal\"></td> ";
    sContent += "                    </tr> ";
    sContent += "                  </table> ";
    sContent += "               </fieldset> ";
    sContent += "             </td> ";
    sContent += "           </tr> ";

    sContent += "           <tr> ";
    sContent += "             <td colspan='2'> ";
    sContent += "               <fieldset class=\"separator\"> ";
    sContent += "                 <legend>Valores</legend> ";
    sContent += "                 <table> ";
    sContent += "                   <tr> ";
    sContent += "                     <td><label class=\"bold\" for=\"oTxtValorOriginal\">Valor Original:</label></td> ";
    sContent += "                     <td id=\"ctnValorOriginal\"></td> ";
    sContent += "                     <td><label class=\"bold\" for=\"oTxtValorAtual\">Valor Atual:</label></td> ";
    sContent += "                     <td id=\"ctnValorAtual\"></td> ";
    sContent += "                   </tr> ";
    sContent += "                 </table> ";
    sContent += "               </fieldset> ";
    sContent += "             </td> ";
    sContent += "           </tr> ";

    sContent += "         </table> ";
    sContent += "       </fieldset> ";
    sContent += "     </td> ";
    sContent += "   </tr> ";
    sContent += "   <tr> ";
    sContent += "     <td> ";
    sContent += "       <fieldset> ";
    sContent += "         <legend>Itens</legend> ";
    sContent += "         <div id='ctnGridItens' style=\"width: 1000px\"></div> ";
    sContent += "       </fieldset> ";
    sContent += "     </td> ";
    sContent += "   </tr> ";
    sContent += " </table> ";
    sContent += " <input type='button' disabled value='Adicionar Itens' id='btnItens' style='display: none'>";
    sContent += " <input type='button' disabled id='btnAditar' value='Salvar " + me.sLabelBotao + "'> ";
    sContent += " <input type='button' id='btnPesquisarAcordo' value='Pesquisar Acordo' > ";

    oNode.innerHTML = sContent;
    oNode.style.display = '';

    /**
     * Pesquisa acordos
     */
    this.pesquisaAcordo = function (lMostrar) {

        if (lMostrar == true) {

            var sUrl = 'func_acordo.php?funcao_js=parent.js_mostraacordo1|ac16_sequencial|ac16_resumoobjeto&iTipoFiltro=4';
            js_OpenJanelaIframe('top.corpo',
                'db_iframe_acordo',
                sUrl,
                'Pesquisa de Acordo',
                true);
        } else {

            if (me.oTxtCodigoAcordo.getValue() != '') {

                var sUrl = 'func_acordo.php?descricao=true&pesquisa_chave=' + me.oTxtCodigoAcordo.getValue() +
                    '&funcao_js=parent.js_mostraacordo&iTipoFiltro=4';

                js_OpenJanelaIframe('top.corpo',
                    'db_iframe_acordo',
                    sUrl,
                    'Pesquisa de Acordo',
                    false);
            } else {
                me.oTxtCodigoAcordo.setValue('');
            }
        }
    }

    /**
     * Retorno da pesquisa acordos
     */
    js_mostraacordo = function (chave1, chave2, erro) {

        if (erro == true) {

            me.oTxtCodigoAcordo.setValue('');
            me.oTxtDescricaoAcordo.setValue('');
            $('oTxtDescricaoAcordo').focus();
        } else {

            me.oTxtCodigoAcordo.setValue(chave1);
            me.oTxtDescricaoAcordo.setValue(chave2);
            me.pesquisarDadosAcordo();
        }
    }

    /**
     * Retorno da pesquisa acordos
     */
    js_mostraacordo1 = function (chave1, chave2) {

        me.oTxtCodigoAcordo.setValue(chave1);
        me.oTxtDescricaoAcordo.setValue(chave2);
        db_iframe_acordo.hide();
        me.pesquisarDadosAcordo();
    }

    this.consultaAcordo = function () {

        js_OpenJanelaIframe('top.corpo',
            'db_iframe_consultaacordo',
            'con4_consacordos003.php?ac16_sequencial=' + me.oTxtCodigoAcordo.getValue(),
            'Consulta de Acordo',
            true);
    }

    this.pesquisao47_coddot = function (mostra) {

        query = '';
        if (iElementoDotacao != '') {
            query = "elemento=" + iElementoDotacao + "&";
        }

        if (mostra == true) {
            js_OpenJanelaIframe('',
                'db_iframe_orcdotacao',
                'func_permorcdotacao.php?' + query + 'funcao_js=parent.' + me.sInstance + '.mostraorcdotacao1|o58_coddot',
                'Pesquisa de Dota��es',
                true, 0);

            $('Jandb_iframe_orcdotacao').style.zIndex = '100000000';
        } else {
            js_OpenJanelaIframe('',
                'db_iframe_orcdotacao',
                'func_permorcdotacao.php?' + query + 'pesquisa_chave=' + document.form1.o47_coddot.value +
                '&funcao_js=parent.' + me.sInstance + '.mostraorcdotacao',
                'Pesquisa de Dota��es',
                false
            );
        }
    }

    this.mostraorcdotacao = function (chave, erro) {

        if (erro) {
            document.form1.o47_coddot.focus();
            document.form1.o47_coddot.value = '';
        }
        me.getSaldoDotacao(chave);
    }

    this.mostraorcdotacao1 = function (chave1) {

        oTxtDotacao.setValue(chave1);
        db_iframe_orcdotacao.hide();
        $('Jandb_iframe_orcdotacao').style.zIndex = '0';
        $('oTxtValorDotacao').focus();
        me.getSaldoDotacao(chave1);
    }

    this.pesquisarDadosAcordo = function () {

        if (me.oTxtCodigoAcordo.getValue() == "") {

            alert('Informe um acordo!');
            return false;
        }

        var oParam = {
            exec: 'getItensAditar',
            renovacao: (me.iTipoAditamento == 5),
            iAcordo: me.oTxtCodigoAcordo.getValue()
        }

        me.oGridItens.clearAll(true);

        new AjaxRequest(me.sUrlRpc, oParam, function (oRetorno, lErro) {

            if (lErro) {
                return alert(oRetorno.message.urlDecode());
            }

            $('btnAditar').disabled = false;
            $('btnItens').disabled = false;

            me.oTxtValorOriginal.setValue(js_formatar(oRetorno.valores.valororiginal, "f"));
            me.oTxtValorAtual.setValue(js_formatar(oRetorno.valores.valoratual, "f"));

            var aDataInicial = oRetorno.datainicial.split("/");
            var aDataFinal = oRetorno.datafinal.split("/");

            me.oTxtDataInicial.setData(aDataInicial[0], aDataInicial[1], aDataInicial[2]);
            me.oTxtDataFinal.setData(aDataFinal[0], aDataFinal[1], aDataFinal[2]);
            me.oTxtDataAssinatura.setValue('');
            me.oTxtDataPublicacao.setValue('');
            me.oTextAreaDescricaoAlteracao.setValue('');
            me.oTxtVeiculoDivulgacao.setValue('');
            me.oTxtNumeroAditamento.setValue(oRetorno.seqaditivo);

            aItensPosicao = oRetorno.itens;
            me.preencheItens(aItensPosicao);

            aItensPosicao.each(function (oItem, iLinha) {
                me.salvarInfoDotacoes(iLinha);
            });

        }).setMessage("Aguarde, pesquisando acordos.")
            .execute();
    }
    /**
     * monta a tela principal do aditamento
     */
    this.main = function () {

        me.oTxtCodigoAcordo = new DBTextField('oTxtCodigoAcordo', me.sInstance + '.oTxtCodigoAcordo', '', 10);
        me.oTxtCodigoAcordo.addEvent("onChange", ";" + me.sInstance + ".pesquisaAcordo(false);");
        me.oTxtCodigoAcordo.show($('ctnCodigoAcordo'));
        me.oTxtCodigoAcordo.setReadOnly(true);

        var oTxtNode = document.createTextNode(" ");
        $('ctnCodigoAcordo').appendChild(oTxtNode);

        me.oTxtDescricaoAcordo = new DBTextField('oTxtDescricaoAcordo', me.sInstance + '.oTxtDescricaoAcordo', '', 50);
        me.oTxtDescricaoAcordo.show($('ctnCodigoAcordo'), true);
        me.oTxtDescricaoAcordo.setReadOnly(true);

        /**
         * Numero do aditamento
         */
        me.oTxtNumeroAditamento = new DBTextField('oTxtNumeroAditamento', me.sInstance + '.oTxtNumeroAditamento', '', 10);
        me.oTxtNumeroAditamento.setMaxLength(20);
        me.oTxtNumeroAditamento.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, '')");
        me.oTxtNumeroAditamento.show($('ctnTxtNumeroAditamento'));

        /**
         * Data da assinatura
         */
        me.oTxtDataAssinatura = new DBTextFieldData('oTxtDataAssinatura', me.sInstance + '.oTxtDataAssinatura', '');
        me.oTxtDataAssinatura.show($('ctnDataAssinatura'));


        /**
         * Data da Publicacao
         */
        me.oTxtDataPublicacao = new DBTextFieldData('oTxtDataPublicacao', me.sInstance + '.oTxtDataPublicacao', '');
        me.oTxtDataPublicacao.show($('ctnDataPublicacao'));

        /**
         * Descricao da Altera��o
         */
        me.oTextAreaDescricaoAlteracao = new DBTextField('oTextAreaDescricaoAlteracao', me.sInstance + '.oTextAreaDescricaoAlteracao', '', 62);
        me.oTextAreaDescricaoAlteracao.show($('ctnDescricaoAlteracao'));

        /**
         * Tipo do Aditivo
         */

        if(me.lTipoAlteracao) {
            me.oCboTipoAditivo = new DBComboBox('oCboTipoAditivo', me.sInstance + '.oCboTipoAditivo',null,'447px');
            me.oCboTipoAditivo.addItem('0', 'Selecione');
            me.oCboTipoAditivo.addItem('7', 'Outros');
            me.oCboTipoAditivo.addItem('12', 'Altera��o de Projeto/Especifica��o');
            me.oCboTipoAditivo.addItem('14', 'Acr�scimo/Decr�scimo de item(ns) conjugado com outros tipos de termos aditivos');
            //me.oCboTipoAditivo.addEvent("onChange", "js_pesquisaAno();");
            me.oCboTipoAditivo.show($('ctnTipoAditivo'));
        }

        /**
         * Veiculo de Divulga��o
         */
        me.oTxtVeiculoDivulgacao = new DBTextField('oTxtVeiculoDivulgacao', me.sInstance + '.oTxtVeiculoDivulgacao', '', 62);
        me.oTxtVeiculoDivulgacao.show($('ctnVeiculoDivulgacao'));

        /**
         * Vig�ncia
         */
        me.oTxtDataInicial = new DBTextFieldData('oTxtDataInicial', me.sInstance + '.oTxtDataInicial', '');
        me.oTxtDataInicial.show($('ctnVigenciaInicial'));

        me.oTxtDataFinal = new DBTextFieldData('oTxtDataFinal', me.sInstance + '.oTxtDataFinal', '');
        me.oTxtDataFinal.show($('ctnVigenciaFinal'));

        if (!me.lDatas) {

            me.oTxtDataFinal.setReadOnly(true);
            me.oTxtDataInicial.setReadOnly(true);
        }

        if (!me.lObrigaDescricao) {
            me.oTextAreaDescricaoAlteracao.setReadOnly(true);
        }

        me.oTextAreaDescricaoAlteracao.setRequired(true);
        me.oTextAreaDescricaoAlteracao.setMaxLength(250);
        me.oTxtVeiculoDivulgacao.setMaxLength(50);


        /**
         * Valores
         */
        me.oTxtValorOriginal = new DBTextField('oTxtValorOriginal', me.sInstance + '.oTxtValorOriginal', '', 12);
        me.oTxtValorOriginal.setClassName("text-right");
        me.oTxtValorOriginal.show($('ctnValorOriginal'));
        me.oTxtValorOriginal.setReadOnly(true);

        me.oTxtValorAtual = new DBTextField('oTxtValorAtual', me.sInstance + '.oTxtValorAtual', '', 12);
        me.oTxtValorAtual.setClassName("text-right");
        me.oTxtValorAtual.show($('ctnValorAtual'));
        me.oTxtValorAtual.setReadOnly(true);

        /**
         * Itens
         */
        me.oGridItens = new DBGrid('oGridItens');
        me.oGridItens.nameInstance = me.sInstance + '.oGridItens';
        me.oGridItens.setCheckbox(0);
        me.oGridItens.setCellAlign(['right', 'left', "right", "right","right", "right", "right", "center", "center", "center", "center"]);
        me.oGridItens.setCellWidth(["5%", '17%', "9%", "9%","9%", "9%", "9%", "9%", "9%", "10%", "10%"]);
        me.oGridItens.setHeader(["C�digo", "Item", "Qtde Anterior", "Vl Unit Anterior", "Quantidade", "Valor Unit�rio", "Valor Total", "Dota��es", "Seq", "Inicio Exec", "Fim Exec"]);
        me.oGridItens.aHeaders[9].lDisplayed = false;
        me.oGridItens.setHeight(300);
        me.oGridItens.show($('ctnGridItens'));

        $('btnAditar').observe('click', me.aditar);
        $('btnPesquisarAcordo').observe('click', function () {
            me.pesquisaAcordo(true);
        });
    }

    /**
     * Controle das dotacoes do item.
     */
    this.ajusteDotacao = function (iLinha, iElemento) {

        iElementoDotacao = iElemento;

        if ($('wndDotacoesItem')) {
            return false;
        }

        oDadosItem = me.oGridItens.aRows[iLinha];
        windowDotacaoItem = new windowAux('wndDotacoesItem', 'Dota��es Item', 430, 380);

        var sContent = "<div class=\"subcontainer\">";
        sContent += "<fieldset><legend>Adicionar Dota��o</legend>";
        sContent += "  <table>";
        sContent += "   <tr>";
        sContent += "     <td>";
        sContent += "     <a href='#' class='dbancora' style='text-decoration: underline;'";
        sContent += "       onclick='" + me.sInstance + ".pesquisao47_coddot(true);'><b>Dota��o:</b></a>";
        sContent += "     </td>";
        sContent += "     <td id='inputdotacao'></td>";
        sContent += "     <td>";
        sContent += "      <b>Saldo Dota��o:</b>";
        sContent += "     </td>";
        sContent += "     <td id='inputsaldodotacao'></td>";
        sContent += "   </tr>";
        sContent += "   <tr>";
        sContent += "     <td>";
        sContent += "      <b>Valor:</b>";
        sContent += "     </td>";
        sContent += "     <td id='inputvalordotacao'></td>";
        sContent += "     <td colspan='2'></td>";
        sContent += "    </tr>";
        sContent += "  </table>";
        sContent += "</fieldset>";
        sContent += "  <input type='button' value='Adicionar' id='btnSalvarDotacao'>";
        ;
        sContent += "  <fieldset style=\"margin-top: 5px;\">";
        sContent += "    <div id='cntgridDotacoes'></div>";
        sContent += "  </fieldset>";
        sContent += "</div>";

        windowDotacaoItem.setContent(sContent);
        oMessageBoard = new DBMessageBoard('msgboard1',
            'Adicionar Dotacoes',
            'Dota��es Item ' + oDadosItem.aCells[2].getValue() + " (valor: <b>" +
            oDadosItem.aCells[5].getValue() + "</b>)",
            $('windowwndDotacoesItem_content'));

        windowDotacaoItem.setShutDownFunction(function () {
            windowDotacaoItem.destroy();
        });

        $('btnSalvarDotacao').observe("click", function () {
            me.saveDotacao(iLinha)
        });

        oTxtDotacao = new DBTextField('oTxtDotacao', 'oTxtDotacao', '', 10);
        oTxtDotacao.show($('inputdotacao'));
        oTxtDotacao.setReadOnly(true);

        oTxtSaldoDotacao = new DBTextField('oTxtSaldoDotacao', 'oTxtSaldoDotacao', '', 10);
        oTxtSaldoDotacao.show($('inputsaldodotacao'));
        oTxtSaldoDotacao.setReadOnly(true);

        oTxtValorDotacao = new DBTextField('oTxtValorDotacao', 'oTxtValorDotacao', '0,00', 10);
        oTxtValorDotacao.setClassName("text-right");
        oTxtValorDotacao.addEvent("onFocus", "this.value = js_strToFloat(this.value)");
        oTxtValorDotacao.addEvent("onBlur", "this.value = js_formatar(this.value, 'f', 2)");
        oTxtValorDotacao.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, '')");
        oTxtValorDotacao.show($('inputvalordotacao'));

        oMessageBoard.show();
        oGridDotacoes = new DBGrid('gridDotacoes');
        oGridDotacoes.nameInstance = 'oGridDotacoes';
        oGridDotacoes.setCellWidth(['20%', '60%', '20%']);
        oGridDotacoes.setHeader(["Dota��o", "Valor", "&nbsp;"]);
        oGridDotacoes.setCellAlign(["center", "right", "Center"]);
        oGridDotacoes.setHeight(100);
        oGridDotacoes.hasTotalizador = true;

        windowDotacaoItem.show();

        oGridDotacoes.show($('cntgridDotacoes'));
        oGridDotacoes.clearAll(true);
        me.preencheGridDotacoes(iLinha);
    }

    this.preencheGridDotacoes = function (iLinha) {

        oGridDotacoes.clearAll(true);

        nValorTotal = 0;
        aItensPosicao[iLinha].dotacoes.each(function (oDotacao, iDot) {

            var oValorDotacao = new DBTextField("valordot" + iDot, "valordot" + iDot, js_formatar(oDotacao.valor, "f"));
            oValorDotacao.addStyle("width", "100%");
            oValorDotacao.setClassName("text-right");
            oValorDotacao.addEvent("onFocus", "this.value = js_strToFloat(this.value)");
            oValorDotacao.addEvent("onBlur", "this.value = js_formatar(this.value, 'f', 2)");
            oValorDotacao.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, ''); " + me.sInstance + ".atualizarItemDotacao(" + iLinha + ", " + iDot + ", this); ");

            var oBotaoRemover = document.createElement("input");
            oBotaoRemover.type = "button";
            oBotaoRemover.id = "btnexcluidotacao" + iDot;
            oBotaoRemover.value = "E";
            oBotaoRemover.setAttribute("onclick", me.sInstance + ".removerDotacao(" + iLinha + ", " + iDot + ")");

            aLinha = new Array();
            aLinha[0] = "<a href='javascript:;' onclick='" + me.sInstance + ".mostraSaldo(" + oDotacao.dotacao + ");'>" + oDotacao.dotacao + "</a>";
            aLinha[1] = oValorDotacao.toInnerHtml();
            aLinha[2] = oBotaoRemover.outerHTML;

            oGridDotacoes.addRow(aLinha);

            nValorTotal += oDotacao.valor;
        });

        $('TotalForCol1').innerHTML = js_formatar(nValorTotal, 'f');

        oGridDotacoes.renderRows();
    }

    /**
     * Atualiza a informa��o das dota��es do item
     */
    this.atualizarItemDotacao = function (iLinha, iDotacao, oValor) {

        aItensPosicao[iLinha].dotacoes[iDotacao].valor = oValor.value.getNumber();

        nValorTotal = 0;
        aItensPosicao[iLinha].dotacoes.each(function (oDotacao) {
            nValorTotal += oDotacao.valor;
        });

        $('TotalForCol1').innerHTML = js_formatar(nValorTotal, 'f');
    }

    /**
     * Remove a Dotacao
     */
    this.removerDotacao = function (iLinha, iDotacao) {

        if (confirm("Remover dota��o do item?")) {

            aItensPosicao[iLinha].dotacoes.splice(iDotacao, 1);
            me.preencheGridDotacoes(iLinha);
        }
    }

    this.saveDotacao = function (iLinha) {

        if (oTxtDotacao.getValue() == "") {

            alert("Campo dota��o � de preenchimento obrigat�rio.");
            js_pesquisao47_coddot(true);
            return false;
        }

        var nValor = oTxtValorDotacao.getValue().getNumber();

        if (nValor == 0) {

            alert('Campo Valor � de preenchimento obrigat�rio.');
            $('oTxtValorDotacao').focus();
            return false;
        }

        var oDotacao = {
            dotacao: oTxtDotacao.getValue(),
            quantidade: 1,
            valor: nValor,
            valororiginal: nValor
        };

        var lInserir = true;
        aItensPosicao[iLinha].dotacoes.forEach(function (oDotacaoItem) {

            if (oDotacaoItem.dotacao == oDotacao.dotacao) {
                lInserir = false;
                alert("Dota��o j� incluida para o item.");
            }
        });

        if (!lInserir) {
            return false;
        }

        aItensPosicao[iLinha].dotacoes.push(oDotacao);
        me.preencheGridDotacoes(iLinha);
    }

    this.getSaldoDotacao = function (iDotacao) {

        var oParam = new Object();
        oParam.exec = "getSaldoDotacao";
        oParam.iDotacao = iDotacao;
        js_divCarregando('Aguarde, pesquisando saldo Dota��es', 'msgBox');
        var oAjax = new Ajax.Request(
            "con4_contratos.RPC.php",
            {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: me.retornoGetSaldotacao
            }
        );

    }

    this.retornoGetSaldotacao = function (oAjax) {

        js_removeObj('msgBox');
        var oRetorno = eval("(" + oAjax.responseText + ")");
        oTxtSaldoDotacao.setValue(js_formatar(oRetorno.saldofinal, "f"));
    }

    me.mostraSaldo = function (chave) {

        var arq = 'func_saldoorcdotacao.php?o58_coddot=' + chave
        js_OpenJanelaIframe('top.corpo', 'db_iframe_saldos', arq, 'Saldo da dota��o', true);
        $('Jandb_iframe_saldos').style.zIndex = '1500000';
    }

    /**
     * calcula os valores da dota��o conforme o valor modificado pelo usuario
     */
    this.salvarInfoDotacoes = function (iLinha) {

        var oItem = aItensPosicao[iLinha];

        var nQuantidade = oItem.novaquantidade || oItem.quantidade,
            nUnitario = oItem.novounitario || oItem.valorunitario,
            nValorTotal = (+nQuantidade) * (+nUnitario),
            nValorTotalItem = nValorTotal,
            nValorTotalAnterior = 0;

        /**
         * Soma o valor original total
         */
        aItensPosicao[iLinha].dotacoes.each(function (oDotacao) {
            nValorTotalAnterior += +oDotacao.valororiginal;
        });

        aItensPosicao[iLinha].dotacoes.each(function (oDotacao, iDot) {

            var nPercentual = (nValorTotalAnterior == 0) ? 0 : (new Number(oDotacao.valororiginal) * 100) / nValorTotalAnterior;
            var nValorDotacao = js_round((nValorTotalItem * nPercentual) / 100, 2);

            nValorTotal -= nValorDotacao;
            if (iDot == aItensPosicao[iLinha].dotacoes.length - 1) {

                if (nValorTotal != nValorTotalItem) {
                    nValorDotacao += nValorTotal;
                }
            }

            if (nValorDotacao < 0) {
                nValorDotacao = 0;
            }

            aItensPosicao[iLinha].dotacoes[iDot].valor = js_round(nValorDotacao, 2);
        });
    }

    me.show = function () {

        me.main();
        me.pesquisaAcordo(true);
    }

    this.aditar = function () {

        var oSelecionados = {};
        var iSelecionados = [];
        /**
         * @todo incluir aqui todas as valida��es de campos obrigat�rios para o SICOM contratos
         */

        if (me.oTxtNumeroAditamento.getValue() == "") {
            return alert("Obrigat�rio informar o n�mero do aditamento.");
        }

        if (me.iTipoAditamento == 7 && me.oTextAreaDescricaoAlteracao.getValue() == "") {
            return alert("Obrigat�rio informar a descri��o da altera��o.");
        }

        if (me.oTxtVeiculoDivulgacao.getValue() == "") {
            return alert("Obrigat�rio informar o ve�culo de divulga��o do aditivo.");
        }

        if (me.oTxtDataAssinatura.getValue() == "") {
            return alert("Obrigat�rio informar a data de assinatura do aditivo.");
        }

        if (me.oTxtDataPublicacao.getValue() == "") {
            return alert("Obrigat�rio informar a data de Publicacao do aditivo.");
        }

        me.oGridItens.getRows().forEach(function (oRow) {

            if (oRow.isSelected) {
                oSelecionados[oRow.aCells[9].getValue()] = oRow;
                iSelecionados.push(oRow.aCells[1].getValue());
            }
        });

        if (Object.keys(oSelecionados).length == 0) {
            return alert('Nenhum item selecionado para aditar.');
        }


        var oParam = {
            exec: "processarAditamento",
            iAcordo: me.oTxtCodigoAcordo.getValue(),
            datainicial: me.oTxtDataInicial.getValue(),
            datafinal: me.oTxtDataFinal.getValue(),
            dataassinatura: me.oTxtDataAssinatura.getValue(),
            datapublicacao: me.oTxtDataPublicacao.getValue(),
            descricaoalteracao: me.oTextAreaDescricaoAlteracao.getValue(),
            veiculodivulgacao: me.oTxtVeiculoDivulgacao.getValue(),
            tipoaditamento: me.iTipoAditamento,
            sNumeroAditamento: me.oTxtNumeroAditamento.getValue(),
            aItens: [],
            aSelecionados: iSelecionados
        }
        if(iTipoAditamento == 7){
            oParam.tipoalteracaoaditivo = me.oCboTipoAditivo.getValue();
            if(oParam.tipoalteracaoaditivo == 0){
                lAditar = false;
                return alert("Selecione um tipo de aditivo.");
            }
        }
        var lAditar = true;
        aItensPosicao.forEach(function (oItem, iIndice) {

            if (!lAditar) {
                return false;
            }

            var oItemAdicionar = {};

            oItemAdicionar.codigo = oItem.codigo;
            oItemAdicionar.codigoitem = oItem.codigoitem;
            oItemAdicionar.resumo = encodeURIComponent(tagString(oItem.resumo || ''));
            oItemAdicionar.codigoelemento = oItem.codigoelemento || '';
            oItemAdicionar.unidade = oItem.unidade || '';
            oItemAdicionar.quantidade = oItem.quantidade;
            oItemAdicionar.valorunitario = oItem.valorunitario;
            oItemAdicionar.valor = oItem.valor;

            if (oSelecionados[iIndice] != undefined) {

                oItemAdicionar.quantidade = oSelecionados[iIndice].aCells[5].getValue().getNumber();
                oItemAdicionar.valorunitario = oSelecionados[iIndice].aCells[6].getValue().getNumber();
                oItemAdicionar.valor = oItemAdicionar.quantidade * oItemAdicionar.valorunitario;
                oItemAdicionar.dtexecucaoinicio = oSelecionados[iIndice].aCells[10].getValue();
                oItemAdicionar.dtexecucaofim = oSelecionados[iIndice].aCells[11].getValue();

                if (iTipoAditamento == 2 && (+oItemAdicionar.quantidade) > (+oItem.quantidade)) {

                    lAditar = false;
                    return alert("A Quantidade informada para o item " + oItem.descricaoitem.urlDecode() + " deve ser menor ou igual a quantidade original do item.");
                }

                if (oItemAdicionar.quantidade == 0 || oItemAdicionar.valorunitario == 0) {

                    lAditar = false;
                    return alert("Os itens marcados para aditamento devem possuir quantidade e valor unit�rio.");
                }

                /**
                 * Validamos o total do item com as dotacoes quando n�o for aditamento de prazo
                 */
                if (iTipoAditamento != 6) {

                    var nValorDotacao = 0;
                    oItem.dotacoes.forEach(function (oDotacao) {

                        if (oDotacao.valor == 0) {

                            lAditar = false;
                            return alert("Os Valores das dota��es para o item " + oItem.descricaoitem.urlDecode() + " n�o podem estar zeradas.");
                        }

                        nValorDotacao += oDotacao.valor;
                    });

                    if (lAditar && nValorDotacao.toFixed(2) != oItemAdicionar.valor.toFixed(2)) {

                        lAditar = false;
                        return alert("O valor da soma das Dota��es do item " + oItem.descricaoitem.urlDecode() + " deve ser igual ao Valor Total do item.");
                    }

                    oItemAdicionar.dotacoes = oItem.dotacoes;
                } else {
                    oItemAdicionar.dotacoes = oItem.dotacoesoriginal;
                }

            } else {

                if (oItem.novo) {

                    lAditar = false;
                    return alert("Novos itens adicionados devem ser marcados para aditamento.");
                }

                oItemAdicionar.dotacoes = oItem.dotacoesoriginal;
            }

            /**
             * Adiciona os per�odos dos itens novos
             */
            oItemAdicionar.aPeriodos = new Array();

            if (oItem.aPeriodos != undefined) {
                oItemAdicionar.aPeriodos = oItem.aPeriodos;
            }

            /**
             * Limpa os valores para aditamento de prazo e renova��o quando o item n�o � selecionado
             */
            if (iTipoAditamento == 6 || (iTipoAditamento == 5 && oSelecionados[iIndice] == undefined)) {

                oItemAdicionar.quantidade = 0;
                oItemAdicionar.valorunitario = 0;
                oItemAdicionar.valor = 0;
            }

            oParam.aItens.push(oItemAdicionar);
        });

        if (!lAditar) {
            return false;
        }

        new AjaxRequest(me.sUrlRpc, oParam, function (oRetorno, lErro) {

            if (lErro) {
                return alert(oRetorno.message.urlDecode());
            }

            alert("Aditamento realizado com sucesso.");
            me.pesquisarDadosAcordo()

        }).setMessage("Aguarde, aditando contrato.")
            .execute();
    }

    /**
     * Abre a window de novo item
     */
    this.novoItem = function () {

        $('btnItens').disabled = true;

        me.aPeriodoItensNovos = new Array();

        windowNovoItem = new windowAux('wndNovoItem', 'Adicionar Novo Item ', 600, 600);

        var sContent = "<div class=\"subcontainer\">";
        sContent += "  <fieldset><legend>Adicionar Itens</legend>";
        sContent += "  <table>";
        sContent += "    <tr>";
        sContent += "      <td>";
        sContent += "        <a href='#' class='dbancora' style='text-decoration: underline;'";
        sContent += "        onclick='" + me.sInstance + ".pesquisaMaterial(true);'><b>Item:</b></a>";
        sContent += "      </td>";
        sContent += "      <td>";
        sContent += "        <span id='ctntxtCodigoMaterial'></span>";
        sContent += "        <span id='ctntxtDescricaoMaterial'></span>";
        sContent += "      </td>";
        sContent += "    </tr>";
        sContent += "    <tr>";
        sContent += "      <td>";
        sContent += "        <b>Quantidade:</b>";
        sContent += "      </td>";
        sContent += "      <td id='ctntxtQuantidade'>";
        sContent += "      </td>";
        sContent += "    </tr>";
        sContent += "    <tr>";
        sContent += "      <td>";
        sContent += "        <b>Valor Unit�rio:</b>";
        sContent += "      </td>";
        sContent += "      <td id='ctntxtVlrUnitario'>";
        sContent += "      </td>";
        sContent += "    </tr>";
        sContent += "    <tr>";
        sContent += "      <td>";
        sContent += "        <b>Desdobramento:</b>";
        sContent += "      </td>";
        sContent += "      <td id='ctnCboDesdobramento'>";
        sContent += "      </td>";
        sContent += "    </tr>";
        sContent += "    <tr>";
        sContent += "      <td>";
        sContent += "        <b>Unidade:</b>";
        sContent += "      </td>";
        sContent += "      <td id='ctnCboUnidade'></td>";
        sContent += "    </tr>";
        sContent += "    <tr>";
        sContent += "      <td nowrap colspan='2' title='Observa��es'>";
        sContent += "        <fieldset><legend>Resumo do Item</legend>";
        sContent += "        <textarea rows='5' style='width:100%' id='oTxtResumo'></textarea>";
        sContent += "      </td>";
        sContent += "    </tr>";
        sContent += "    <tr>";
        sContent += "      <td colspan='2'>";
        sContent += "        <fieldset class=\"separator\">";
        sContent += "          <legend>Vig�ncia</legend>";
        sContent += "          <table>";
        sContent += "            <tr>";
        sContent += "              <td>";
        sContent += "                <b>De:</b>";
        sContent += "              </td>";
        sContent += "              <td id='ctnDataInicialItem' style=''></td>";
        sContent += "              <td>";
        sContent += "                <b>At�:</b>";
        sContent += "              </td>";
        sContent += "              <td id='ctnDataFinalItem' align='right' style=''></td>";
        sContent += "              <td id='ctnBtnAdicionaPeriodoItem' align='right' style=''>";
        sContent += "                <input type='button' name='btnAdicionarPeriodoItem' id='btnAdicionarPeriodoItem' value='Adicionar' onclick='" + me.sInstance + ".adicionarPeriodo();' >";
        sContent += "              </td>";
        sContent += "            </tr>";
        sContent += "          </table>";
        sContent += "          <div id='ctnGridPeriodoNovoItem'></div>";
        sContent += "        </fieldset>";
        sContent += "      </td>";
        sContent += "    </tr>";
        sContent += "  </table>";
        sContent += "  </fieldset>";
        sContent += "  <input type='button' value='Salvar' id='btnSalvarItem' onclick='" + me.sInstance + ".adicionarNovoItem()'>";
        sContent += "</div>";

        windowNovoItem.setContent(sContent);
        windowNovoItem.setShutDownFunction(function () {

            $('btnItens').disabled = false;
            windowNovoItem.destroy();
        });

        oMessageBoardItens = new DBMessageBoard('msgboardItens', 'Adicionar Novo Item', "Informe os dados do novo Item.", $('windowwndNovoItem_content'));
        oMessageBoardItens.show();

        /**
         * Grid para os novos itens de um contrato que est� sendo aditado.
         */
        oGridPeriodoItemNovo = new DBGrid('ctnGridPeriodoNovoItem');
        oGridPeriodoItemNovo.nameInstance = "oGridPeriodoItemNovo";

        oGridPeriodoItemNovo.setHeader(["Data Inicial", "Data Final", "A��o"]);
        oGridPeriodoItemNovo.setCellWidth(["45%", "45%", "10%"]);
        oGridPeriodoItemNovo.setCellAlign(["center", "center", "center"]);
        oGridPeriodoItemNovo.setHeight(100);
        oGridPeriodoItemNovo.show($('ctnGridPeriodoNovoItem'));
        oGridPeriodoItemNovo.clearAll(true);

        oTxtMaterial = new DBTextField('oTxtMaterial', 'oTxtMaterial', '', 10);
        oTxtMaterial.addEvent("onKeyPress", "return js_mask(event,\"0-9\")");
        oTxtMaterial.addEvent("onChange", ";" + me.sInstance + ".pesquisaMaterial(false); ");
        oTxtMaterial.show($('ctntxtCodigoMaterial'));

        oTxtDataInicialItem = new DBTextFieldData('oTxtDataInicialItem', 'oTxtDataInicialItem', '');
        oTxtDataInicialItem.show($('ctnDataInicialItem'));

        oTxtDataFinalItem = new DBTextFieldData('oTxtDataFinalItem', 'oTxtDataFinalItem', '');
        oTxtDataFinalItem.show($('ctnDataFinalItem'));

        oTxtDescrMaterial = new DBTextField('oTxtDescrMaterial', 'oTxtDescrMaterial', '', 40);
        oTxtDescrMaterial.show($('ctntxtDescricaoMaterial'));
        oTxtDescrMaterial.setReadOnly(true);

        oTxtQuantidade = new DBTextField('oTxtQuantidade', 'oTxtQuantidade', '', 10);
        oTxtQuantidade.addEvent("onFocus", "this.value = js_strToFloat(this.value)");
        oTxtQuantidade.addEvent("onBlur", "this.value = js_formatar(this.value, 'f', 3)");
        oTxtQuantidade.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, '')");
        oTxtQuantidade.setValue("0,000");
        oTxtQuantidade.setClassName("text-right");
        oTxtQuantidade.show($('ctntxtQuantidade'));

        oTxtVlrUnitario = new DBTextField('oTxtVlrUnitario', 'oTxtVlrUnitario', '', 10);
        oTxtVlrUnitario.addEvent("onFocus", "this.value = js_strToFloat(this.value)");
        oTxtVlrUnitario.addEvent("onBlur", "this.value = js_formatar(this.value, 'f', 3)");
        oTxtVlrUnitario.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, '')");
        oTxtVlrUnitario.setValue("0,000");
        oTxtVlrUnitario.setClassName("text-right");
        oTxtVlrUnitario.show($('ctntxtVlrUnitario'));

        oCboDesdobramento = new DBComboBox('oCboDesdobramento', 'oCboDesdobramento', new Array("Selecione"));
        oCboDesdobramento.show($('ctnCboDesdobramento'));

        oCboUnidade = new DBComboBox('oCboUnidade', 'oCboUnidade', new Array("Selecione"));
        oCboUnidade.show($('ctnCboUnidade'));

        /**
         * Busca as Unidades
         */
        new AjaxRequest(me.sUrlRpc, {exec: "getUnidades"}, function (oRetorno, lErro) {

            $('oCboUnidade').options.length = 1;
            oCboUnidade.aItens = new Array();

            if (!lErro) {

                oRetorno.itens.each(function (oItem, id) {
                    oCboUnidade.addItem(oItem.m61_codmatunid, oItem.m61_descr.urlDecode());
                });
            }
        }).setMessage("Aguarde, pesquisando unidades do material.")
            .execute();

        windowNovoItem.show();
    }

    /**
     * Adiciona um periodo ao item novo do acordo
     */
    this.adicionarPeriodo = function () {

        var dtDataInicial = oTxtDataInicialItem.getValue();
        var dtDataFinal = oTxtDataFinalItem.getValue();

        if (dtDataInicial == '' || dtDataFinal == '') {

            alert("Informe as datas de vig�ncia do item.");
            return false;
        }

        if (js_comparadata(dtDataInicial, dtDataFinal, ">=") ||
            js_comparadata(dtDataInicial, me.oTxtDataInicial.getValue(), "<") ||
            js_comparadata(dtDataFinal, me.oTxtDataFinal.getValue(), ">")) {

            alert("H� conflito entre as datas informadas.\n\nO Conflito pode estar ocorrendo entre as datas de vig�ncia e/ou entre os per�odos");
            return false;
        }

        var oPeriodoNovo = {
            dtDataInicial: js_formatar(oTxtDataInicialItem.getValue(), "d"),
            dtDataFinal: js_formatar(oTxtDataFinalItem.getValue(), "d"),
            ac41_sequencial: ''
        };

        me.aPeriodoItensNovos.push(oPeriodoNovo);
        me.loadPeriodoItensNovos();
    }

    /**
     * Exclui o periodo de um item contido na grid: "oGridPeriodoItemNovo"
     */
    this.excluirPeriodoItemNovo = function (iLinha) {

        me.aPeriodoItensNovos.splice(iLinha, 1);
        me.loadPeriodoItensNovos();
    }

    /**
     * Fun��o que carrega os per�odos de um item novo na grid "oGridPeriodoItemNovo"
     */
    this.loadPeriodoItensNovos = function () {

        oGridPeriodoItemNovo.clearAll(true);
        me.aPeriodoItensNovos.each(function (oPeriodo, iLinha) {

            var aLinha = new Array();
            aLinha[0] = js_formatar(oPeriodo.dtDataInicial, 'd');
            aLinha[1] = js_formatar(oPeriodo.dtDataFinal, 'd');
            aLinha[2] = "<input type='button' name='btnExcluiPeriodo' id='btnExcluirPeriodo' value='E' onclick='" + me.sInstance + ".excluirPeriodoItemNovo(" + iLinha + ");' />";
            oGridPeriodoItemNovo.addRow(aLinha);
        });
        oGridPeriodoItemNovo.renderRows();
    }

    this.getElementosMateriais = function (iValorDefault) {

        iValorElemento = '';
        if (iValorDefault != null) {
            iValorElemento = iValorDefault;
        }
        js_divCarregando('Aguarde, pesquisando elementos do material', 'msgBox');
        var oParam = new Object();
        oParam.iMaterial = oTxtMaterial.getValue();
        oParam.exec = "getElementosMateriais";
        var oAjax = new Ajax.Request('con4_contratos.RPC.php', {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: me.retornoGetElementosMaterias
        });
    }

    this.retornoGetElementosMaterias = function (oAjax) {

        js_removeObj('msgBox');
        $('oCboDesdobramento').options.length = 1;
        oCboDesdobramento.aItens = new Array();
        var oRetorno = eval("(" + oAjax.responseText + ")");
        if (oRetorno.status == 1) {

            oRetorno.itens.each(function (oItem, id) {

                var oParametro = new Object();
                oParametro.nome = "elemento"
                oParametro.valor = oItem.elemento.substr(0, 7);
                oCboDesdobramento.addItem(oItem.codigoelemento, oItem.descricao.urlDecode(), null, new Array(oParametro));
            });
        }
    }

    /**
     * Adiciona o item novo
     */
    this.adicionarNovoItem = function () {

        var iCodigoMaterial = oTxtMaterial.getValue();
        var sResumo = $F('oTxtResumo');
        var nQuantidade = oTxtQuantidade.getValue();
        var nValorUnitario = oTxtVlrUnitario.getValue();
        var iUnidade = oCboUnidade.getValue();
        var iElemento = oCboDesdobramento.getValue();

        if (iElemento == '0') {

            alert('Campo Desdobramento � de preenchimento obrigat�rio.');
            return false;
        }

        if (iUnidade == '0') {

            alert('Campo Unidade � de preenchimento obrigat�rio.');
            return false;
        }

        var oNovoMaterial = new Object();
        oNovoMaterial.codigo = '';
        oNovoMaterial.codigoitem = oTxtMaterial.getValue();
        oNovoMaterial.descricaoitem = oTxtDescrMaterial.getValue();
        oNovoMaterial.resumo = sResumo;
        oNovoMaterial.unidade = iUnidade;
        oNovoMaterial.codigoelemento = iElemento;
        oNovoMaterial.elemento = $('oCboDesdobramento').options[$('oCboDesdobramento').selectedIndex].getAttribute('elemento');
        oNovoMaterial.quantidade = nQuantidade.getNumber();
        oNovoMaterial.valorunitario = nValorUnitario.getNumber();
        oNovoMaterial.valor = new Number(oNovoMaterial.quantidade) * new Number(oNovoMaterial.valorunitario);
        oNovoMaterial.aPeriodos = me.aPeriodoItensNovos;
        oNovoMaterial.dotacoes = new Array();
        oNovoMaterial.novo = true;

        aItensPosicao.push(oNovoMaterial);
        me.preencheItens(aItensPosicao);

        $('btnItens').disabled = false;
        windowNovoItem.destroy();
    }

    this.preencheItens = function (aItens) {

        me.oGridItens.clearAll(true);

        aItens.each(function (oItem, iSeq) {

            var aLinha = new Array();

            aLinha[0] = oItem.codigoitem;
            aLinha[1] = oItem.descricaoitem.urlDecode();
            aLinha[2] = js_formatar(oItem.qtdeanterior, 'f', 2);
            aLinha[3] = js_formatar(oItem.vlunitanterior, 'f', 2);

            if (!oItem.novo) {

                if (iTipoAditamento == 2) {
                    oItem.valorunitario = 0;
                    oItem.valor = 0;
                }

                if (iTipoAditamento == 4) {

                    oItem.quantidade = 0;
                    oItem.valorunitario = 0;
                    oItem.valor = 0;
                }

                if (iTipoAditamento == 5 || iTipoAditamento == 6) {
                    oItem.valorunitario = oItem.valor / (oItem.quantidade != 0 ? oItem.quantidade : 1 );
                }
            }

            var nQuantidade = oItem.novaquantidade || oItem.quantidade,
                nUnitario = oItem.novounitario || oItem.valorunitario;

            oInputQuantidade = new DBTextField('quantidade' + iSeq, 'quantidade' + iSeq, js_formatar(nQuantidade, 'f', 3));
            oInputQuantidade.addStyle("width", "100%");
            oInputQuantidade.setClassName("text-right");
            oInputQuantidade.setReadOnly(iTipoAditamento == 6);

            if (iTipoAditamento != 6) {

                oInputQuantidade.addEvent("onFocus", "this.value = js_strToFloat(this.value)");
                oInputQuantidade.addEvent("onBlur", "this.value = js_formatar(this.value, 'f', 3)");
                oInputQuantidade.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, '');" + me.sInstance + ".calculaValorTotal(" + iSeq + ")");
            }

            aLinha[4] = oInputQuantidade.toInnerHtml();

            oInputUnitario = new DBTextField('valorunitario' + iSeq, 'valorunitario' + iSeq, js_formatar(nUnitario, "f", 3));
            oInputUnitario.addStyle("width", "100%");
            oInputUnitario.setClassName("text-right");
            oInputUnitario.setReadOnly(iTipoAditamento == 6);

            if (iTipoAditamento != 6) {

                oInputUnitario.addEvent("onFocus", "this.value = js_strToFloat(this.value)");
                oInputUnitario.addEvent("onBlur", "this.value = js_formatar(this.value, 'f', 3)");
                oInputUnitario.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, ''); " + me.sInstance + ".calculaValorTotal(" + iSeq + ")");
            }

            aLinha[5] = oInputUnitario.toInnerHtml();
            aLinha[6] = js_formatar(nQuantidade * nUnitario, 'f', 2);

            var oBotaoDotacao = document.createElement("input");
            oBotaoDotacao.type = "button";
            oBotaoDotacao.id = "dotacoes" + iSeq;
            oBotaoDotacao.value = "Dota��es";
            oBotaoDotacao.disabled = !me.lLiberaDotacoes;
            oBotaoDotacao.setAttribute("onclick", me.sInstance + ".ajusteDotacao(" + iSeq + ", " + oItem.elemento + ")");

            aLinha[7] = oBotaoDotacao.outerHTML;
            aLinha[8] = new String(iSeq);

            oInputPeriodoIni = new DBTextFieldData('periodoini' + iSeq, 'periodoini' + iSeq, js_formatar(oItem.periodoini, 'd'));
            oInputPeriodoFim = new DBTextFieldData('periodofim' + iSeq, 'periodofim' + iSeq, js_formatar(oItem.periodofim, 'd'));
            
            if(iTipoAditamento == 6 || iTipoAditamento == 7){
                aLinha[9] = oInputPeriodoIni.toInnerHtml().replace("size    = '10'","size    = '8'");
                aLinha[10] = oInputPeriodoFim.toInnerHtml().replace("size    = '10'","size    = '8'");
            } else {
                aLinha[9] = js_formatar(oItem.periodoini, 'd');
                aLinha[10] = js_formatar(oItem.periodofim, 'd');
            }


            me.oGridItens.addRow(aLinha, false, me.lBloqueiaItem, (me.lBloqueiaItem || iTipoAditamento == 5 || oItem.novo));

            if (oItem.dotacoesoriginal == undefined) {

                oItem.dotacoesoriginal = new Array();

                oItem.dotacoes.forEach(function (oDotacaoOriginal) {
                    oItem.dotacoesoriginal.push({
                        dotacao: oDotacaoOriginal.dotacao,
                        quantidade: oDotacaoOriginal.quantidade,
                        valor: oDotacaoOriginal.valor,
                        valororiginal: oDotacaoOriginal.valororiginal
                    });
                });
            }

            me.salvarInfoDotacoes(iSeq);
        });

        me.oGridItens.renderRows();
    }

    /**
     * Calcula o valor da coluna Valor Total
     */
    this.calculaValorTotal = function (iLinha) {

        var aLinha = me.oGridItens.aRows[iLinha],
            nQuantidade = aLinha.aCells[5].getValue().getNumber(),
            nUnitario = aLinha.aCells[6].getValue().getNumber();

        aItensPosicao[iLinha].novaquantidade = nQuantidade;
        aItensPosicao[iLinha].novounitario = nUnitario;

        aLinha.aCells[7].setContent(js_formatar(nQuantidade * nUnitario, 'f', 2));

        me.salvarInfoDotacoes(iLinha);
    }

    this.pesquisaMaterial = function (mostra) {

        if (mostra) {

            js_OpenJanelaIframe('top.corpo',
                'db_iframe_pcmater',
                'func_pcmater.php?funcao_js=parent.' + me.sInstance + '.mostraMaterial|pc01_codmater|pc01_descrmater',
                'Pesquisar Materiais',
                true
            );
            $('Jandb_iframe_pcmater').style.zIndex = 10000000;
        } else {

            if (oTxtMaterial.getValue() != '') {

                js_OpenJanelaIframe('top.corpo',
                    'db_iframe_pcmater',
                    'func_pcmater.php?pesquisa_chave=' + oTxtMaterial.getValue() +
                    '&funcao_js=parent.' + me.sInstance + '.mostrapcmater',
                    'Pesquisar materiais',
                    false);
            } else {
                oTxtDescrMaterial.setValue('');
            }
        }
    }

    this.mostrapcmater = function (chave, erro) {

        oTxtDescrMaterial.setValue(chave);
        if (erro == true) {
            oTxtMaterial.setValue('');
        } else {
            me.getElementosMateriais();
        }
    }

    this.mostraMaterial = function (chave1, chave2) {

        oTxtMaterial.setValue(chave1);
        oTxtDescrMaterial.setValue(chave2);
        db_iframe_pcmater.hide();
        me.getElementosMateriais();
    }

    /**
     * Libera para inclus�o de itens novos
     */
    if (this.lLiberaNovosItens) {

        $('btnItens').style.display = '';
        $('btnItens').observe('click', me.novoItem);
    }
}