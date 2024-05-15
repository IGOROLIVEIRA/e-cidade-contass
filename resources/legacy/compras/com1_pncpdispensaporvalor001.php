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
            <legend>Dispensa por valor PNCP</legend>
            <table style="width:100%">
                <tr>
                    <td colspan="2">
                        <strong>Ambiente: </strong>
                        <select name="ambiente" id="ambiente">
                            <option value="1">Ambiente de Homologao Externa</option>
                        </select>

                        <strong>Tipo: </strong>
                        <select name="tipo" id="tipo" onchange="js_getProcessodecompra()">
                            <option value="1">Inclusão</option>
                            <option value="2">Retificação</option>
                            <option value="3">Exclusão</option>
                        </select>

                        </select>
                        <strong>Ano competência: </strong>
                        <input type="number" name="anocompetencia" id="anocompetencia" onclick="js_getProcessodecompra()" min="1111" max="9999" />
                        </select>
                    </td>
                </tr>
                <tr>

                </tr>
                <tr height="100%">
                    <td colspan="2">
                        <div id='cntgridprocessodecompras'></div>
                    </td>
                </tr>
            </table>

        </fieldset>
        </br>
        <div id='cntgridprocessodecompras'></div>

        <input style="margin-left: 50%" type="button" value="Enviar para PNCP" onclick="js_enviar();">
    </form>
    <?php
    db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
    ?>
</body>

</html>
<script>

    var anoCompetenciaInput = document.getElementById("anocompetencia");
    var anoAtual = new Date().getFullYear();
    anoCompetenciaInput.value = anoAtual;

    function js_showGrid() {
        oGridLicitacao = new DBGrid('gridLicitacao');
        oGridLicitacao.nameInstance = 'oGridLicitacao';
        oGridLicitacao.setCheckbox(0);
        oGridLicitacao.setCellAlign(new Array("center", "center", "Left", "Center"));
        oGridLicitacao.setCellWidth(new Array("5%", "10%", "80%", "20%"));
        oGridLicitacao.setHeader(new Array("Código", "Processo", "Objeto", "Número de Controle"));
        oGridLicitacao.setHeight(400);
        oGridLicitacao.hasTotalValue = false;
        oGridLicitacao.show($('cntgridprocessodecompras'));

        var width = $('cntgridprocessodecompras').scrollWidth - 30;
        $("table" + oGridLicitacao.sName + "header").style.width = width;
        $(oGridLicitacao.sName + "body").style.width = width;
        $("table" + oGridLicitacao.sName + "footer").style.width = width;
    }
    js_showGrid();

    function js_getProcessodecompra() {
        oGridLicitacao.clearAll(true);

        let anocompetencia = document.getElementById("anocompetencia").value;
        let tipo = document.getElementById("tipo").value;

        var oParam = new Object();
        oParam.ano = anocompetencia;
        oParam.tipo = tipo;
        oParam.exec = "getProcesso";
        js_divCarregando('Aguarde, pesquisando Licitaes', 'msgBox');
        var oAjax = new Ajax.Request(
            'com1_dispensaporvalor.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornoGetProcesso
            }
        );
    }

    function js_retornoGetProcesso(oAjax) {

        js_removeObj('msgBox');
        oGridLicitacao.clearAll(true);
        var aEventsIn = ["onmouseover"];
        var aEventsOut = ["onmouseout"];
        aDadosHintGrid = new Array();

        var oRetornoProcesso = JSON.parse(oAjax.responseText);
        console.log(oRetornoProcesso);
        if (oRetornoProcesso.status == 1) {

            var seq = 0;
            oRetornoProcesso.processos.each(function(oLinha, iLinha) {
                seq++;
                var aLinha = new Array();
                aLinha[0] = oLinha.pc80_codproc;
                aLinha[1] = oLinha.pc80_numdispensa;
                aLinha[2] = oLinha.pc80_resumo.urlDecode();
                aLinha[3] = oLinha.numerodecontrole;
                oGridLicitacao.addRow(aLinha);

                var sTextEvent = " ";
                if (aLinha[3] !== '') {
                    sTextEvent += "<b>objeto: </b>" + aLinha[3];
                } else {
                    sTextEvent += "<b>Nenhum dado  mostrar</b>";
                }

                var oDadosHint = new Object();
                oDadosHint.idLinha = `cntgridprocessodecompras${iLinha}`;
                oDadosHint.sText = sTextEvent;
                aDadosHintGrid.push(oDadosHint);
            });

            oGridLicitacao.renderRows();
            aDadosHintGrid.each(function(oHint, id) {
                var oDBHint = eval("oDBHint_" + id + " = new DBHint('oDBHint_" + id + "')");
                oDBHint.setText(oHint.sText);
                oDBHint.setShowEvents(aEventsIn);
                oDBHint.setHideEvents(aEventsOut);
                oDBHint.setPosition('B', 'L');
                oDBHint.setUseMouse(true);
                oDBHint.make($(oHint.idLinha), 3);
            });
        }
    }
    js_getProcessodecompra();

    function js_enviar() {
        var aProcesso = oGridLicitacao.getSelection("object");

        if (aProcesso.length == 0) {
            alert('Nenhuma Licitao Selecionada');
            return false;
        }

        let tipo = $F('tipo');

        var oParam = new Object();
        if (tipo == 1) {
            oParam.exec = "enviarProcesso";
        } else if (tipo == 2) {
            oParam.exec = "RetificarAviso";
        } else {
            oParam.exec = "excluiraviso";
        }
        oParam.ambiente = $F('ambiente');
        oParam.aProcesso = new Array();

        for (var i = 0; i < aProcesso.length; i++) {

            with(aProcesso[i]) {
                var processo = new Object();
                let numerocontrole = aCells[4].getValue();
                if (tipo == '2' && numerocontrole.length == 1) {
                    alert('Licitao Selecionada não esta presente no PNCP');
                    return false;
                }
                processo.codigo = aCells[1].getValue();
                processo.processo = aCells[2].getValue();
                processo.numerocontrole = numerocontrole;
                oParam.aProcesso.push(processo);
            }
        }

        js_divCarregando('Aguarde, Enviando Processo', 'msgBox');
        var oAjax = new Ajax.Request(
            'com1_dispensaporvalor.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_returnEnvPncp
            }
        );
    }

    function js_returnEnvPncp(oAjax) {
        js_removeObj('msgBox');
        var oRetornoLicitacoes = eval('(' + oAjax.responseText + ")");
        if (oRetornoLicitacoes.status == '2') {
            alert(oRetornoLicitacoes.message.urlDecode());
            window.location.href = "com1_pncpdispensaporvalor001.php";
        } else {
            if (confirm(oRetornoLicitacoes.message.urlDecode())) {
                window.location.href = "com1_pncpdispensaporvalor001.php";
            }
        }
    }
</script>
