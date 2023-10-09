<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

db_app::load("scripts.js, strings.js, datagrid.widget.js, windowAux.widget.js,dbautocomplete.widget.js");
db_app::load("dbmessageBoard.widget.js, prototype.js, dbtextField.widget.js, dbcomboBox.widget.js, widgets/DBHint.widget.js");
db_app::load("estilos.css, grid.style.css");
db_app::load("time.js");
?>
<html>

<head>
    <title>Contass Contabilidade Ltda - Pgina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<style>
</style>

<body bgcolor=#CCCCCC>
    <form action="">
        <fieldset style="margin-top:50px;">
            <legend>Envio do evento R-4020 Pessoa jurídica </legend>
            <table style="width:100%">
                <tr>
                    <td colspan="2">
                        <strong>Ambiente: </strong>
                        <select name="ambiente" id="ambiente">
                            <option value="1">Produção</option>
                            <option value="2">Produção restrita</option>
                        </select>

                        <strong>Mês competência: </strong>
                        <select name="mescompetencia" id="mescompetencia" onchange="limparBox()">
                            <option value="">Selecione</option>
                            <option value="01">Janeiro</option>
                            <option value="02">Fevereiro</option>
                            <option value="03">Março</option>
                            <option value="04">Abril</option>
                            <option value="05">Maio</option>
                            <option value="06">Junho</option>
                            <option value="07">Julho</option>
                            <option value="08">Agosto</option>
                            <option value="09">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
                            <?php
                        ?>
                        </select>
                        <strong>Ano competência: </strong>
                            <input type="number" name="anocompetencia" id="anocompetencia" onkeydown="limparBox()" min="1111" max="9999" />
                            <input style="margin-left: 3%" type="button" value="Pesquisar" onclick="js_getEventos();">
                        </td>
                </tr>
                <tr>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id='cntgrideventos'></div>
                    </td>
                </tr>
            </table>

        </fieldset>
        </br>
        <div id='cntgrideventos'></div>
        
        <input style="margin-left: 47%" type="button" value="Transmitir" onclick="js_transmitir();">
    </form>
    <?php
    db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
    ?>
</body>

</html>
<script>
    function js_showGrid() 
    {
        oGridEvento = new DBGrid('gridEventos');
        oGridEvento.nameInstance = 'oGridEvento';
        oGridEvento.setCheckbox(0);
        oGridEvento.setCellAlign(new Array("Center", "Center","Center", "Center", "Center", "Center", "Center"));
        oGridEvento.setCellWidth(new Array("40%", "10%","10%", "10%", "10%", "10%", "10%"));
        oGridEvento.setHeader(new Array("CNPJ Beneficiário","Identificador (OP)","Natureza do Rendimento","Data FG","Valor Bruto","Valor Base", " Valor IRRF"))
        oGridEvento.hasTotalValue = false;
        oGridEvento.setHeight(300);
        // oGridEvento.aHeaders[1].lDisplayed = false;
        oGridEvento.show($('cntgrideventos'));
        
        var width = $('cntgrideventos').scrollWidth - 30;
        $("table" + oGridEvento.sName + "header").style.width = width;
        $(oGridEvento.sName + "body").style.width = width;
        $("table" + oGridEvento.sName + "footer").style.width = width;
    }
    js_showGrid();
    
    function js_getEventos() 
    {
        oGridEvento.clearAll(true);

        let mescompetencia = $F('mescompetencia');
        if (mescompetencia == 0) {
            alert('Selecione um mês competencia');
            return false;
        }

        let anocompetencia = $F('anocompetencia');
        if (mescompetencia == 0) {
            alert('Digite um ano competencia');
            return false;
        }

        let ambiente = $F('ambiente');

        var oParam      = new Object();
        oParam.exec     = "getEventos4020";
        oParam.sMescompetencia = mescompetencia;
        oParam.sAnocompetencia = anocompetencia;
        oParam.sAmbiente       = ambiente
        js_divCarregando('Aguarde, buscando dados do evento', 'msgBox');
        var oAjax = new Ajax.Request(
            'efd1_reinf.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornogetEventos
            }
        );
    }

    function js_retornogetEventos(oAjax) 
    {

        js_removeObj('msgBox');
        oGridEvento.clearAll(true);
        var aEventsIn = ["onmouseover"];
        var aEventsOut = ["onmouseout"];
        aDadosHintGrid = new Array();

        var oRetornoEventos = JSON.parse(oAjax.responseText);

        if (oRetornoEventos.iStatus == 1) {

            var seq = 0;
            oRetornoEventos.efdreinfr4020.each(function(oLinha, iLinha) {

                seq++;
                var aLinha = new Array();
                aLinha[0] = oLinha.CNPJBeneficiario;
                aLinha[1] = oLinha.Identificador;
                aLinha[2] = oLinha.NaturezaRendimento;
                aLinha[3] = oLinha.DataFG;
                aLinha[4] = oLinha.ValorBruto;
                aLinha[5] = oLinha.ValorBase;
                aLinha[6] = oLinha.ValorIRRF;
                oGridEvento.addRow(aLinha);

                var sTextEvent = " ";
                if (aLinha[1] !== '') {
                    sTextEvent += "<b>objeto: </b>" + aLinha[1];
                } else {
                    sTextEvent += "<b>Nenhum dado  mostrar</b>";
                }

                var oDadosHint = new Object();
                oDadosHint.idLinha = `gridEventorowgridEvento${iLinha}`;
                oDadosHint.sText = sTextEvent;
                aDadosHintGrid.push(oDadosHint);
                });

                oGridEvento.renderRows();
                aDadosHintGrid.each(function(oHint, id) {
                var oDBHint = eval("oDBHint_" + id + " = new DBHint('oDBHint_" + id + "')");
                oDBHint.setText(oHint.sText);
                oDBHint.setShowEvents(aEventsIn);
                oDBHint.setHideEvents(aEventsOut);
                oDBHint.setPosition('B', 'L');
                oDBHint.setUseMouse(false);
                oDBHint.make($(oHint.idLinha), 3);
            });
        }
    }

    function js_transmitir() 
    {
        var aEventos = oGridEvento.getSelection("object");

        let mescompetencia = $F('mescompetencia');
        if (mescompetencia == 0) {
            alert('Selecione um mês competencia');
            return false;
        }

        let anocompetencia = $F('anocompetencia');
        if (mescompetencia == 0) {
            alert('Digite um ano competencia');
            return false;
        }

        let ambiente = $F('ambiente');

        if (aEventos.length == 0) {
            alert('Nenhuma OP Selecionada');
            return false;
        }

        var oParam = new Object();
        oParam.aEventos        = new Array();
        oParam.exec            = "transmitirreinfR4020";
        oParam.sMescompetencia = mescompetencia;
        oParam.sAnocompetencia = anocompetencia;
        oParam.sAmbiente       = ambiente
        oParam.aOpsErros       = new Array();
        for (var i = 0; i < aEventos.length; i++) {

            with(aEventos[i]) {
                var evento              = new Object();
                evento.CNPJBeneficiario = aCells[1].getValue().substr(0,18);
                evento.Identificador    = aCells[2].getValue();
                evento.NatRendimento    = aCells[3].getValue();
                evento.DataFG           = aCells[4].getValue();
                evento.ValorBruto       = aCells[5].getValue().substr(2);
                evento.ValorBase        = aCells[6].getValue().substr(2);
                evento.ValorIRRF        = aCells[7].getValue().substr(2);
                evento.Numcgm           = aCells[1].getValue();
                oParam.aEventos.push(evento);
            
                var valor = aCells[3].getValue();
                if (valor.length < 2) {
                    var opserros          = new Object();
                    opserros.op           = aCells[2].getValue();
                    oParam.aOpsErros.push(opserros);
                }
            }   
        }

        js_divCarregando('Aguarde, transmitindo eventos', 'msgBox');
        var oAjax = new Ajax.Request(
            'efd1_reinf.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_returnEnvEventos
            }
        );
    }

    function js_returnEnvEventos(oAjax) 
    {
        js_removeObj('msgBox');
        var oRetornoEventos = eval('(' + oAjax.responseText + ")");

        if (oRetornoEventos.sMessage) {
            if (oRetornoEventos.iStatus == '2') {
                alert(oRetornoEventos.sMessage.urlDecode());
            } else {
                alert(oRetornoEventos.sMessage.urlDecode());
            }
        }

        if (oRetornoEventos.sMessageOp) {
            alert(oRetornoEventos.sMessageOp.urlDecode());
        }
    }
    function limparBox()
    {
        var gridContainer = $('cntgrideventos');
        if (gridContainer) {
            while (gridContainer.firstChild) {
                gridContainer.removeChild(gridContainer.firstChild);
            }
        }

        oGridEvento = new DBGrid('gridEventos');
        oGridEvento.nameInstance = 'oGridEvento';
        oGridEvento.setCheckbox(0);
        oGridEvento.setCellAlign(new Array("Center", "Center", "Center", "Center", "Center", "Center", "Center"));
        oGridEvento.setCellWidth(new Array("40%", "10%","10%", "10%", "10%", "10%", "10%"));
        oGridEvento.setHeader(new Array("CNPJ Beneficiário","Identificador (OP)","Natureza do Rendimento","Data FG","Valor Bruto","Valor Base", " Valor IRRF"))
        oGridEvento.hasTotalValue = false;
        oGridEvento.setHeight(300);
        oGridEvento.show(gridContainer);
        var width = gridContainer.scrollWidth - 30;
        $("table" + oGridEvento.sName + "header").style.width = width;
        $(oGridEvento.sName + "body").style.width = width;
        $("table" + oGridEvento.sName + "footer").style.width = width;

    }
    
    var anoCompetenciaInput = document.getElementById("anocompetencia");
    var anoAtual = new Date().getFullYear();
    anoCompetenciaInput.value = anoAtual;

    var inputAnoCompetencia = document.getElementById("anocompetencia");
    inputAnoCompetencia.style.width = "70px";
</script>