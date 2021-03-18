function dbViewItensLicitacao(sNomeInstance, oNode) {

    var me = this, aItensPosicao = new Array();

    this.aPeriodoItensNovos = new Array()
    this.sInstance = sNomeInstance;
    this.sUrlRpc = 'lic4_licitacao.RPC.php';

    oNode.style.display = 'none';

    sContent = " <table>";
    sContent += "   <tr> ";
    sContent += "     <td> ";
    sContent += "       <fieldset> ";
    sContent += "         <legend>Itens</legend> ";
    sContent += "         <div id='ctnGridItens' style=\"width: 1000px\"></div> ";
    sContent += "       </fieldset> ";
    sContent += "     </td> ";
    sContent += "   </tr> ";
    sContent += " </table> ";
    
    oNode.innerHTML = sContent;
    oNode.style.display = '';

    this.pesquisaItensLicitacao = (params) => {
        let oParam = {
            exec: 'getItensLicitacao',
            iProcCompra: params.iProcCompra,
            iLicitacao: params.iLicitacao
        }

        me.oGridItens.clearAll(true);

        new AjaxRequest(me.sUrlRpc, oParam, (oRetorno, erro) => {

            if(oRetorno.itens){
                me.preencheItens(oRetorno.itens);
            }

        }).setMessage("Aguarde, pesquisando acordos.")
            .execute();
    }
    /**
     * monta a tela principal do aditamento
     */
    this.main = () => {

        /**
         * Itens
         */
        me.oGridItens = new DBGrid('oGridItens');
        me.oGridItens.nameInstance = me.sInstance + '.oGridItens';
        me.oGridItens.setCheckbox(0);
        me.oGridItens.setCellAlign(['center', 'center', 'center', 'center','center', 'center', "center", 'center']);
        me.oGridItens.setCellWidth(["7%", '8%', "30%", "17%", "10%", "10%", "8%", "10%", ""]);
        me.oGridItens.setHeader(["Código", "Nº Item", "Descrição", "Complemento do Item", "Qtde", "Unidade", "ME/EPP", "Qtde Exclusiva", ""]);
        me.oGridItens.setHeight(200);
        me.oGridItens.show($('ctnGridItens'));
        
    }

    me.show = (iProcCompra) => {
        me.main();
        me.pesquisaItensLicitacao(iProcCompra);
    }

    this.preencheItens = (aItens) => {

        me.oGridItens.clearAll(true);

        var aEventsIn  = ["onmouseover"];
        var aEventsOut = ["onmouseout"];
        aDadosHintGrid = new Array();
        let aSelecionados = [];

        aItens.each( (oItem, iSeq) => {

            var aLinha = new Array();
            aLinha[0] = oItem.codigoitem ? oItem.codigoitem : ' - ';
            aLinha[1] = oItem.seqitem;
            aLinha[2] = oItem.descritem ? oItem.descritem.urlDecode() : ' - ';
            aLinha[3] = oItem.complitem ? oItem.complitem.urlDecode() : ' - ';
            aLinha[4] = oItem.qtditem;
            aLinha[5] = oItem.unidade;
            
            oInputQuantidade = new DBTextField('quantidade' + iSeq, 'quantidade' + iSeq, '');
            oInputQuantidade.addStyle("width", "100%");
            oInputQuantidade.setClassName("text-right");
            oInputQuantidade.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, '')");
            oInputQuantidade.setReadOnly(true);
            
            aLinha[6] = new DBComboBox('meEpp' + iSeq, 'meEpp' + iSeq,null,'100%');
            aLinha[6].addItem('0', 'Não');
            aLinha[6].addItem('1', 'Sim');
            aLinha[6].addEvent("onChange", ";" + me.sInstance + ".js_liberaQtdeExclusiva("+iSeq+", this.value);");
            aLinha[6].lDisabled = oItem.marcado;
            
            aLinha[7] = oInputQuantidade;
            aLinha[7].lDisabled = oItem.marcado;
            
            aLinha[8] = oItem.procitem;
            
            if(oItem.marcado){
                aSelecionados.push(iSeq);
            }

            me.oGridItens.addRow(aLinha, false, oItem.marcado, oItem.marcado);
            
            var sTextEvent  = " ";
            
            if (aLinha[1] !== '') {
                sTextEvent += "<b>Item: </b>"+aLinha[1];
            } else {
                sTextEvent += "<b>Nenhum dado à mostrar</b>";
            }

            var oDadosHint           = new Object();
            oDadosHint.idLinha   = `oGridItensrowoGridItens${iSeq}`;
            oDadosHint.sText     = sTextEvent;
            aDadosHintGrid.push(oDadosHint);

        });

        for(let count=0; count < aSelecionados.length; count++){
            for(let i=0; i < 10; i++){
                me.oGridItens.aRows[aSelecionados[count]].aCells[i].addClassName('linha__marcada');
            }
        }

        me.oGridItens.renderRows();

        aDadosHintGrid.each( (oHint, id) => {
            var oDBHint    = eval("oDBHint_"+id+" = new DBHint('oDBHint_"+id+"')");
            oDBHint.setText(oHint.sText);
            oDBHint.setShowEvents(aEventsIn);
            oDBHint.setHideEvents(aEventsOut);
            oDBHint.setPosition('B', 'L');
            oDBHint.setUseMouse(true);
            oDBHint.make($(oHint.idLinha), 2);
        });

        this.js_liberaQtdeExclusiva = (sequencial, valor) => {

            if(parseInt(valor)){
                document.getElementById(`quantidade${sequencial}`).classList.remove('readonly');
                document.getElementById(`quantidade${sequencial}`).removeAttribute('readonly');
            }else{
                document.getElementById(`quantidade${sequencial}`).value = '';
                document.getElementById(`quantidade${sequencial}`).classList.add('readonly');
                document.getElementById(`quantidade${sequencial}`).setAttribute('readonly', false);
            }
            
        }
    }

}
