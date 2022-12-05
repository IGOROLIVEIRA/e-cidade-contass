<?php
db_app::load("scripts.js, strings.js, datagrid.widget.js, windowAux.widget.js,dbautocomplete.widget.js");
db_app::load("dbmessageBoard.widget.js, prototype.js, dbtextField.widget.js, dbcomboBox.widget.js, widgets/DBHint.widget.js");
db_app::load("estilos.css, grid.style.css");
?>
<form name="form1" method="post" action="">
    <table border="0">
        <tr>
            <td>
                <?
                db_ancora('Licitação:', "js_pesquisal20_codigo(true);", $db_opcao);
                ?>
            </td>
            <td>
                <?
                db_input('l20_codigo', 10, $Il20_codigo, true, 'text', 3, "")
                ?>
                <?
                db_input('l20_objeto', 80, $Il20_objeto, true, 'text', 3, '')
                ?>
            </td>
        </tr>
    </table>
    <input type="button" value="Processar" onclick="js_getItens();">
    <fieldset>
        <legend><b>Itens</b></legend>
        <div id='cntgriditens'></div>
    </fieldset>
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
        oGridItens.hasTotalValue = true;
        oGridItens.show($('cntgriditens'));

        var width = $('cntgriditens').scrollWidth - 30;
        $("table" + oGridItens.sName + "header").style.width = width;
        $(oGridItens.sName + "body").style.width = width;
        $("table" + oGridItens.sName + "footer").style.width = width;
    }

    function js_pesquisal20_codigo(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_liclicita', 'func_licitensresultado.php?funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_objeto', 'Pesquisa', true);
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
                aLinha[0] = oLinha.pc81_codprocitem;
                aLinha[1] = oLinha.pc11_seq;
                aLinha[2] = oLinha.pc01_descrmater.urlDecode();
                aLinha[3] = oLinha.l04_descricao.urlDecode();
                aLinha[4] = oLinha.z01_numcgm;
                aLinha[5] = oLinha.z01_nome.urlDecode();
                aLinha[6] = oLinha.m61_descr;
                aLinha[7] = oLinha.pc11_quant;
                aLinha[8] = oLinha.pc23_valor;
                oGridItens.addRow(aLinha);
                nTotal = nTotal + Number(oLinha.pc23_valor);

                var sTextEvent = " ";

                if (aLinha[2] !== '') {
                    sTextEvent += "<b>Material: </b>" + aLinha[2];
                } else {
                    sTextEvent += "<b>Nenhum dado á mostrar</b>";
                }

                var oDadosHint = new Object();
                oDadosHint.idLinha = `gridItensrowgridItens${iLinha}`;
                oDadosHint.sText = sTextEvent;
                aDadosHintGrid.push(oDadosHint);

                /*LOTE*/
                var sTextEventlote = " ";

                if (aLinha[3] !== '') {
                    sTextEventlote += "<b>Lote: </b>" + aLinha[3];
                } else {
                    sTextEventlote += "<b>Nenhum dado á mostrar</b>";
                }

                var oDadosHintlote = new Object();
                oDadosHintlote.idLinha = `gridItensrowgridItens${iLinha}`;
                oDadosHintlote.sTextlote = sTextEventlote;
                aDadosHintGridlote.push(oDadosHintlote);
            });
            document.getElementById('gridItenstotalValue').innerText = js_formatar(nTotal, 'f');
            document.getElementById('valor').value = js_formatar(nTotal, 'f');

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
</script>