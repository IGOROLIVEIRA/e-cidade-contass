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
            <legend>Publição Contratos PNCP</legend>
            <table style="width:100%">
                <tr>
                    <td colspan="2">
                        <strong>Ambiente: </strong>
                        <select name="ambiente" id="ambiente">
                            <option value="1">Ambiente de Homologao Externa</option>
                        </select>

                        <strong>Tipo: </strong>
                        <select name="tipo" id="tipo">
                            <option value="0">Selecione</option>
                            <option value="1">Inclusão</option>
                            <option value="2">Retificação</option>
                            <option value="3">Exclusão</option>
                        </select>
                    </td>
                </tr>
                <tr>

                </tr>
                <tr>
                    <td colspan="2">
                        <div id='cntgridcontratos'></div>
                    </td>
                </tr>
            </table>

        </fieldset>
        </br>
        <div id='cntgridcontratos'></div>

        <input style="margin-left: 50%" type="button" value="Enviar para PNCP" onclick="js_enviar();">
    </form>
    <?php
    db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
    ?>
</body>

</html>
<script>
    function js_showGrid() {
        oGridContrato = new DBGrid('gridContrato');
        oGridContrato.nameInstance = 'oGridContrato';
        oGridContrato.setCheckbox(0);
        oGridContrato.setCellAlign(new Array("center", "center", "Center", "Left", "Center", "Center"));
        oGridContrato.setCellWidth(new Array("5%", "40%", "10%", "40%", "10%", "20%"));
        oGridContrato.setHeader(new Array("Código", "Objeto", "Contato", "Fornecedor", "Licitação", "Número de Controle"));
        oGridContrato.hasTotalValue = false;
        oGridContrato.show($('cntgridcontratos'));

        var width = $('cntgridcontratos').scrollWidth - 30;
        $("table" + oGridContrato.sName + "header").style.width = width;
        $(oGridContrato.sName + "body").style.width = width;
        $("table" + oGridContrato.sName + "footer").style.width = width;
    }
    js_showGrid();

    function js_getContratos() {
        oGridContrato.clearAll(true);
        var oParam = new Object();
        oParam.exec = "getContratos";
        js_divCarregando('Aguarde, pesquisando Contratos', 'msgBox');
        var oAjax = new Ajax.Request(
            'aco1_pncpenviocontrato.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornogetContratos
            }
        );
    }

    function js_retornogetContratos(oAjax) {

        js_removeObj('msgBox');
        oGridContrato.clearAll(true);
        var aEventsIn = ["onmouseover"];
        var aEventsOut = ["onmouseout"];
        aDadosHintGrid = new Array();

        var oRetornoContratos = JSON.parse(oAjax.responseText);

        if (oRetornoContratos.status == 1) {

            var seq = 0;
            oRetornoContratos.contratos.each(function(oLinha, iLinha) {
                // print_r(oLinha);exit;
                seq++;
                var aLinha = new Array();
                aLinha[0] = oLinha.sequencial;
                aLinha[1] = oLinha.objeto;
                aLinha[2] = oLinha.contrato;
                aLinha[3] = oLinha.fornecedor;
                aLinha[4] = oLinha.licitacao;
                aLinha[5] = oLinha.numerocontrolepncp;
                oGridContrato.addRow(aLinha);

                var sTextEvent = " ";
                if (aLinha[1] !== '') {
                    sTextEvent += "<b>objeto: </b>" + aLinha[1];
                } else {
                    sTextEvent += "<b>Nenhum dado  mostrar</b>";
                }

                var oDadosHint = new Object();
                oDadosHint.idLinha = `gridContratorowgridContrato${iLinha}`;
                oDadosHint.sText = sTextEvent;
                aDadosHintGrid.push(oDadosHint);
            });

            oGridContrato.renderRows();
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
    js_getContratos();

    function js_enviar() {
        var aContratos = oGridContrato.getSelection("object");

        let tipo = $F('tipo');
        if (tipo == 0) {
            alert('Selecione um Tipo');
            return false;
        }

        if (aContratos.length == 0) {
            alert('Nenhum Contrato Selecionado');
            return false;
        }

        var oParam = new Object();
        if (tipo == 1) {
            oParam.exec = "enviarContrato";
        } else if (tipo == 2) {
            oParam.exec = "RetificarContrato";
        } else {
            oParam.exec = "ExcluirContrato";
        }
        oParam.ambiente = $F('ambiente');
        oParam.aContratos = new Array();

        for (var i = 0; i < aContratos.length; i++) {

            with(aContratos[i]) {
                var contrato = new Object();
                contrato.codigo = aCells[1].getValue();
                contrato.processo = aCells[2].getValue();
                contrato.sequencialpncp = aCells[6].getValue();
                oParam.aContratos.push(contrato);
            }
        }

        js_divCarregando('Aguarde, Enviando contratos', 'msgBox');
        var oAjax = new Ajax.Request(
            'aco1_pncpenviocontrato.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_returnEnvPncp
            }
        );
    }

    function js_returnEnvPncp(oAjax) {
        js_removeObj('msgBox');
        var oRetornoContratos = eval('(' + oAjax.responseText + ")");
        if (oRetornoContratos.status == '2') {
            alert(oRetornoContratos.message.urlDecode());
        } else {
            let tipo = $F('tipo');
            if (tipo == 1)
                alert('Enviado com sucesso !');
            if (tipo == 2)
                alert('Retificação enviada com sucesso!');
            if (tipo == 3)
                alert('Exclusão efetuada com sucesso!');
            window.location.href = "aco1_pncppublicacaocontrato001.php";
        }
    }
</script>
