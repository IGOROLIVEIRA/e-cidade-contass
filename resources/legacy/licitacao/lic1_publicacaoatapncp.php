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
            <legend>Publicao PNCP</legend>
            <table style="width:100%">
                <tr>
                    <td colspan="2">
                        <strong>Ambiente: </strong>
                        <select name="ambiente" id="ambiente">
                            <option value="1">Ambiente de Homologao Externa</option>
                        </select>

                        <strong>Tipo: </strong>
                        <select name="tipo" id="tipo">
                            <option value="1">Inclus�o</option>
                            <option value="2">Retifica��o</option>
                            <option value="3">Exclus�o</option>
                        </select>
                    </td>
                </tr>
                <tr>

                </tr>
                <tr>
                    <td colspan="2">
                        <div id='cntgridlicitacoesrp'></div>
                    </td>
                </tr>
            </table>

        </fieldset>
        </br>
        <div id='cntgridlicitacoesrp'></div>

        <input style="margin-left: 50%" type="button" value="Enviar para PNCP" onclick="js_enviar();">
    </form>
    <?php
    db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
    ?>
</body>

</html>
<script>
    function js_showGrid() {
        oGridLicitacao = new DBGrid('gridLicitacao');
        oGridLicitacao.nameInstance = 'oGridLicitacao';
        oGridLicitacao.setCheckbox(0);
        oGridLicitacao.setCellAlign(new Array("center", "center", "Left", "Left", "Center", "Center"));
        oGridLicitacao.setCellWidth(new Array("5%", "10%", "20%", "80%", "20%", "20%"));
        oGridLicitacao.setHeader(new Array("C�digo", "Processo", "Modalidade", "Objeto", "N�mero de Controle", "N�mero Ata PNCP"));
        oGridLicitacao.hasTotalValue = false;
        oGridLicitacao.show($('cntgridlicitacoesrp'));

        var width = $('cntgridlicitacoesrp').scrollWidth - 30;
        $("table" + oGridLicitacao.sName + "header").style.width = width;
        $(oGridLicitacao.sName + "body").style.width = width;
        $("table" + oGridLicitacao.sName + "footer").style.width = width;
    }
    js_showGrid();

    function js_getLicitacoes() {
        oGridLicitacao.clearAll(true);
        var oParam = new Object();
        oParam.exec = "getLicitacoesRP";
        js_divCarregando('Aguarde, pesquisando Licitaes', 'msgBox');
        var oAjax = new Ajax.Request(
            'lic1_enviopncp.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornoGetLicitacoes
            }
        );
    }

    function js_retornoGetLicitacoes(oAjax) {

        js_removeObj('msgBox');
        oGridLicitacao.clearAll(true);
        var aEventsIn = ["onmouseover"];
        var aEventsOut = ["onmouseout"];
        aDadosHintGrid = new Array();

        var oRetornoLicitacoes = JSON.parse(oAjax.responseText);

        if (oRetornoLicitacoes.status == 1) {

            var seq = 0;
            oRetornoLicitacoes.licitacoes.each(function(oLinha, iLinha) {
                seq++;
                var aLinha = new Array();
                aLinha[0] = oLinha.l20_codigo;
                aLinha[1] = oLinha.l20_edital;
                aLinha[2] = oLinha.l03_descr.urlDecode();
                aLinha[3] = oLinha.l20_objeto.urlDecode();
                aLinha[4] = oLinha.l213_numerocontrolepncp;
                aLinha[5] = oLinha.l215_ata;
                oGridLicitacao.addRow(aLinha);

                var sTextEvent = " ";
                if (aLinha[3] !== '') {
                    sTextEvent += "<b>objeto: </b>" + aLinha[3];
                } else {
                    sTextEvent += "<b>Nenhum dado  mostrar</b>";
                }

                var oDadosHint = new Object();
                oDadosHint.idLinha = `gridLicitacaorowgridLicitacao${iLinha}`;
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
    js_getLicitacoes();

    function js_enviar() {
        var aLicitacoes = oGridLicitacao.getSelection("object");

        if (aLicitacoes.length == 0) {
            alert('Nenhuma Licitao Selecionada');
            return false;
        }

        let tipo = $F('tipo');

        var oParam = new Object();
        if (tipo == 1) {
            oParam.exec = "enviarAtaRP";
        } else if (tipo == 2) {
            oParam.exec = "retificarAtaRP";
        } else {
            oParam.exec = "excluirAtaRP";
        }
        oParam.ambiente = $F('ambiente');
        oParam.aLicitacoes = new Array();

        for (var i = 0; i < aLicitacoes.length; i++) {

            with(aLicitacoes[i]) {
                var licitacao = new Object();
                let numerocontrole = aCells[5].getValue();
                if ((tipo == '2' || tipo == '3') && numerocontrole.length == 1) {
                    alert('Ata Selecionada n�o esta presente no PNCP');
                    return false;
                }
                licitacao.codigo = aCells[1].getValue();
                licitacao.processo = aCells[2].getValue();
                licitacao.numerocontrole = numerocontrole;
                licitacao.numeroata = aCells[6].getValue();
                oParam.aLicitacoes.push(licitacao);
            }
        }

        js_divCarregando('Aguarde, Enviando Licitacoes', 'msgBox');
        var oAjax = new Ajax.Request(
            'lic1_enviopncp.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_returnEnvPncp
            }
        );
    }

    function js_returnEnvPncp(oAjax) {
        js_removeObj('msgBox');
        var oRetornoLicitacoes = eval('(' + oAjax.responseText + ")");
        alert(oRetornoLicitacoes.message.urlDecode());
        window.location.href = "lic1_publicacaoatapncp.php";
    }
</script>