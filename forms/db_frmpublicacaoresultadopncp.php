<?php
db_app::load("scripts.js, strings.js, datagrid.widget.js, windowAux.widget.js,dbautocomplete.widget.js");
db_app::load("dbmessageBoard.widget.js, prototype.js, dbtextField.widget.js, dbcomboBox.widget.js, widgets/DBHint.widget.js");
db_app::load("estilos.css, grid.style.css");
?>
<form name="form1" method="post" action="">
    <table border="0">
        <tr>
            <td>
                <strong>Tipo: </strong>
            </td>
            <td>
                <select name="tipo" id="tipo" style="width: 91px;" onchange="js_verificatipo();">
                    <option value="0">Selecione</option>
                    <option value="1">Julgamento</option>
                    <option value="2">Homologação</option>
                    <option value="3">Retificação</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <?
                db_ancora('Licitação:', "js_pesquisal20_codigo(true);", $db_opcao);
                ?>
            </td>
            <td>
                <?
                db_input('l20_codigo', 10, $Il20_codigo, true, 'text', 3, "");
                ?>
                <?
                db_input('l20_objeto', 80, $Il20_objeto, true, 'text', 3, '');
                ?>
            </td>
        </tr>
    </table>
    </br>
    <input type="button" value="Processar" onclick="js_getItens();">
    </br>

    <table style="width: 100%">
        <tr>
            <td colspan="2">
                <strong>Ambiente: </strong>
                <select name="ambiente" id="ambiente">
                    <option value="1">Ambiente de Homologao Externa</option>
                </select>
            </td>
        </tr>
    </table>
    <fieldset>
        <legend><b>Itens</b></legend>
        <div id='cntgriditens'></div>
    </fieldset>
    </br>
    <input type="button" value="Enviar para PNCP" onclick="js_enviarresultado();">
</form>
<script>
    function js_showGrid() {
        let opcao = "<?= $db_opcao ?>";
        oGridItens = new DBGrid('gridItens');
        oGridItens.nameInstance = 'oGridItens';
        if (opcao != 2) {
            oGridItens.setCheckbox(0);
        }
        oGridItens.setCellAlign(new Array("center", "center", "center", "center", "center", 'center', 'center', 'center', 'center'));
        oGridItens.setCellWidth(new Array("5%", "5%", "35%", '15%', '5%', '25%', '15%', '8%', '8%'));
        oGridItens.setHeader(new Array("Código", "Ordem", "Material", "Lote", "CGM", "Fornecedores", "Unidade", "Qtde Licitada", "Valor Licitado"));
        oGridItens.hasTotalValue = false;
        oGridItens.show($('cntgriditens'));

        var width = $('cntgriditens').scrollWidth - 30;
        $("table" + oGridItens.sName + "header").style.width = width;
        $(oGridItens.sName + "body").style.width = width;
        $("table" + oGridItens.sName + "footer").style.width = width;
    }

    function js_pesquisal20_codigo(mostra) {
        let tipo = document.getElementById('tipo').value;

        if (mostra == true && tipo != 0) {
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_liclicita', 'func_licitensresultado.php?funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_objeto', 'Pesquisa', true);
        }else{
            alert('Selecione o Tipo.');
        }
    }

    function js_mostraliclicita1(chave1, chave2) {
        document.form1.l20_codigo.value = chave1;
        document.form1.l20_objeto.value = chave2;
        db_iframe_liclicita.hide();
    }

    function js_getItens() {

        oGridItens.clearAll(true);
        var oParam = new Object();
        oParam.iLicitacao = $F('l20_codigo');
        oParam.iTipo = $F('tipo');
        oParam.exec = "getItens";
        js_divCarregando('Aguarde, pesquisando Itens', 'msgBox');
        var oAjax = new Ajax.Request(
            'lic1_envioresultadopncp.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornoGetItens
            }
        );
    }

    function js_retornoGetItens(oAjax) {

        js_removeObj('msgBox');
        oGridItens.clearAll(true);
        var aEventsIn = ["onmouseover"];
        var aEventsOut = ["onmouseout"];
        aDadosHintGrid = new Array();
        aDadosHintGridlote = new Array();

        var oRetornoitens = JSON.parse(oAjax.responseText);

        var nTotal = new Number(0);

        if (oRetornoitens.status == 1) {

            var seq = 0;
            oRetornoitens.itens.each(function(oLinha, iLinha) {
                seq++;
                var aLinha = new Array();
                aLinha[0] = oLinha.pc01_codmater;
                aLinha[1] = oLinha.l21_ordem;
                aLinha[2] = oLinha.pc01_descrmater.urlDecode();
                aLinha[3] = oLinha.l04_descricao.urlDecode();
                aLinha[4] = '';
                aLinha[5] = '';
                if(oLinha.pc23_valor != 0){
                    aLinha[4] = oLinha.z01_numcgm;
                    aLinha[5] = oLinha.z01_nome.urlDecode();
                }
                aLinha[6] = oLinha.m61_descr;
                aLinha[7] = oLinha.pc11_quant;
                aLinha[8] = oLinha.pc23_valor;
                oGridItens.addRow(aLinha);

            });
            oGridItens.renderRows();

            aDadosHintGrid.each(function(oHint, id) {
                var oDBHint = eval("oDBHint_" + id + " = new DBHint('oDBHint_" + id + "')");
                oDBHint.setText(oHint.sText);
                oDBHint.setShowEvents(aEventsIn);
                oDBHint.setHideEvents(aEventsOut);
                oDBHint.setPosition('B', 'L');
                oDBHint.setUseMouse(true);
                oDBHint.make($(oHint.idLinha), 3);
            });

            aDadosHintGridlote.each(function(oHintlote, id) {
                var oDBHintlote = eval("oDBHintlote_" + id + " = new DBHint('oDBHintlote_" + id + "')");
                oDBHintlote.setText(oHintlote.sTextlote);
                oDBHintlote.setShowEvents(aEventsIn);
                oDBHintlote.setHideEvents(aEventsOut);
                oDBHintlote.setPosition('B', 'L');
                oDBHintlote.setUseMouse(true);
                oDBHintlote.make($(oHintlote.idLinha), 4);
            });

        }
    }

    js_showGrid();

    function js_enviarresultado() {
        var aItensLicitacao = oGridItens.getSelection("object");

        if (aItensLicitacao.length == 0) {
            alert('Nenhum item Selecionado');
            return false;
        }

        let tipo = $F('tipo');

        var oParam = new Object();
        if (tipo == 1) {
            oParam.exec = "enviarResultado";
        } else {
            oParam.exec = "RetificarResultado";
        }
        oParam.ambiente = $F('ambiente');
        oParam.aItensLicitacao = new Array();
        oParam.iLicitacao = $F('l20_codigo');

        for (var i = 0; i < aItensLicitacao.length; i++) {

            with(aItensLicitacao[i]) {
                var itemResultado = new Object();
                itemResultado.pc01_codmater = aCells[1].getValue();
                itemResultado.l21_ordem = aCells[2].getValue();
                itemResultado.z01_numcgm = aCells[5].getValue();
                oParam.aItensLicitacao.push(itemResultado);
            }
        }

        js_divCarregando('Aguarde, Enviando Resultado Itens', 'msgBox');
        var oAjax = new Ajax.Request(
            'lic1_envioresultadopncp.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_returnEnvPncp
            }
        );
    }

    function js_returnEnvPncp(oAjax) {
        js_removeObj('msgBox');
        var oRetornoResultado = eval('(' + oAjax.responseText + ")");

        alert(oRetornoResultado.message.urlDecode());
    }

    function js_verificatipo(){
        js_getItens();
    }

</script>
