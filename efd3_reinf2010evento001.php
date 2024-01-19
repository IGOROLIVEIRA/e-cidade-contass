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
    <title>Contass Contabilidade Ltda - Página Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    /* Add this style to your CSS */
    .custom-swal-container {
        width: 70%;
        max-width: 90%;
        height: 90%;
        left: 15%;
    }
    .custom-table {
        width: 100%;
        margin: 20px 0;
        font-family: Arial, sans-serif;
    }
    .custom-table table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
    }
    .custom-table th,
    .custom-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    .custom-table th {
        background-color: #f2f2f2;
    }
    input {
            border-radius: 5px;
        }
</style>

<body bgcolor=#CCCCCC>
    <form action="">
        <fieldset style="margin-top:50px;">
            <legend>Consulta do evento R-2010 Retenção de contribuição previdenciária - Serviços Tomados</legend>
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
                        <strong>Status: </strong>
                        <select name="status" id="status" onchange="limparBox()">
                            <option value="">TODOS</option>
                            <option value="1">EM PROCESSAMENTO </option>
                            <option value="2">ENVIADO</option>
                            <option value="3">ERRO NO ENVIO</option>
                            <option value="8">ERRO NA CONSULTA</option>
                        </select>
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
    </form>
    <?php
    db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
    ?>
</body>

</html>
<script>
    function js_showGrid() {
        oGridEvento = new DBGrid('gridEventos');
        oGridEvento.nameInstance = 'oGridEvento';
        oGridEvento.setCellAlign(new Array("Center", "Center", "Center", "Center", "Center", "Center", "Center", "Center", "Center", "Center", "Center", "Center"));
        oGridEvento.setCellWidth(new Array("30%", "8%", "5%", "5%", "7%", "25%", "25%", "5%","8%", "10%","8%", "5%"));
        oGridEvento.setHeader(new Array("Prestador", "CNO", "Valor Bruto", "Valor Base", "Valor Retido CP", "Optante CPRB", "Obra", "Detalhes","Protocolo","Data Envio","Status","Mensagem Retorno"));
        oGridEvento.hasTotalValue = false;
        oGridEvento.setHeight(400);
        oGridEvento.show($('cntgrideventos'));

        var width = $('cntgrideventos').scrollWidth - 30;
        $("table" + oGridEvento.sName + "header").style.width = width;
        $(oGridEvento.sName + "body").style.width = width;
        $("table" + oGridEvento.sName + "footer").style.width = width;

        document.getElementById('cntgrideventos').addEventListener('click', function(event) {
            var target = event.target;

            if (target.cellIndex === 7) {
                var dados = target.textContent;
                showDadosPopup(dados);
            }
            if (target.cellIndex === 11) {
                var dados = target.textContent;
                showErroPopup(dados);
            }
        });
    }
    js_showGrid();

    function js_getEventos() {
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

        let status = $F('status');
        
        let ambiente = $F('ambiente');
        var oParam = new Object();
        oParam.exec = "getConsultarEvento2010";
        oParam.sMescompetencia = mescompetencia;
        oParam.sAnocompetencia = anocompetencia;
        oParam.sAmbiente = ambiente;
        oParam.sStatus   = status;
        js_divCarregando('Aguarde, Consultando Evento', 'msgBox');
        var oAjax = new Ajax.Request(
            'efd1_reinf.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornogetEventos
            }
        );
    }

    function js_retornogetEventos(oAjax) {

        js_removeObj('msgBox');
        oGridEvento.clearAll(true);
        var aEventsIn = ["onmouseover"];
        var aEventsOut = ["onmouseout"];
        aDadosHintGrid = new Array();

        var oRetornoEventos = JSON.parse(oAjax.responseText);

        if (oRetornoEventos.iStatus == 1) {

            var seq = 0;
            oRetornoEventos.efdreinfr2010.each(function(oLinha, iLinha) {

                seq++;
                var aLinha = new Array();
                aLinha[0] = oLinha.Estabelecimento;
                aLinha[1] = oLinha.CNPJPrestador;
                aLinha[2] = oLinha.ValorBruto;
                aLinha[3] = oLinha.ValorBase;
                aLinha[4] = oLinha.ValorRetidoCP;
                aLinha[5] = oLinha.OptanteCPRB;
                aLinha[6] = oLinha.Obra;
                aLinha[7] = "Clique aqui : ; ," + "<b style='color: #00008b;'>" + oLinha.DadosExtras + "</b>";
                aLinha[8] = oLinha.Protocolo;
                aLinha[9] = oLinha.DataEnvio;
                aLinha[10] = oLinha.Status;
                aLinha[11] = oLinha.DscResp ? "Clique aqui : " + "<b style='color: #00008b;'>" + oLinha.DscResp + "</b>" : "Clique aqui : " + "<b style='color: #00008b;'> Todos eventos processados com sucesso. </b>";

                oGridEvento.addRow(aLinha);

                var sTextEvent = " ";
                if (aLinha[7] !== '') {
                    sTextEvent += "<b>objeto: </b>" + aLinha[7];
                } else {
                    sTextEvent += "<b>Nenhum dado  mostrar</b>";
                }

                var oDadosHint = new Object();
                oDadosHint.idLinha = `cntgrideventos${iLinha}`;
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
                oDBHint.setUseMouse(true);
                oDBHint.make($(oHint.idLinha), 8);
            });

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
        oGridEvento.setCellAlign(new Array("Center", "Center", "Center", "Center", "Center", "Center", "Center", "Center", "Center", "Center", "Center", "Center"));
        oGridEvento.setCellWidth(new Array("30%", "8%", "5%", "5%", "7%", "25%", "25%", "5%","8%", "10%","8%", "5%"));
        oGridEvento.setHeader(new Array("Prestador", "CNO", "Valor Bruto", "Valor Base", "Valor Retido CP", "Optante CPRB", "Obra", "Detalhes","Protocolo","Data Envio","Status","Mensagem Retorno"));
        oGridEvento.hasTotalValue = false;
        oGridEvento.setHeight(400);
        oGridEvento.show(gridContainer);

        document.getElementById('cntgrideventos').addEventListener('click', function(event) {
            var target = event.target;

            if (target.cellIndex === 7) {
                var dados = target.textContent;
                showDadosPopup(dados);
            }
            if (target.cellIndex === 11) {
                var dados = target.textContent;
                showErroPopup(dados);
            }
        });
    }
    function showErroPopup(erro) 
    {
        if (erro.length>1) {
            alert(erro.substr(13)); 
        }
    }
    function showDadosPopup(dados) 
    {
        if (dados.length > 1) {
            var totalValorBruto = 0;
            var totalValorBase = 0;
            var totalValorRetido = 0;
            var contTotal = 0;
            var dadosPrestador = '';
            var data = dados.split(' ; ,');
            var tableHTML = `<table ><tr>`;

            const columnNames = [
                'Tipo Serviço',
                'Nota Fiscal',
                'Série',
                'Data',
                'Empenho',
                'OP',
                'Valor Bruto',
                'Valor Base',
                'Valor Retido CP'
            ];

            for (let i = 0; i < columnNames.length; i++) {
                tableHTML += `<th>${columnNames[i]}</th>`;
            }

            tableHTML += `</tr><tr>`;

            for (let i = 1; i < data.length; i++) {
                contTotal++
                if (contTotal != 10) {
                    tableHTML += `<td>${data[i]}</td>`;
                }
                if (contTotal == 7) {
                    let numeroDecimal = parseFloat(data[i].substr(3).replace(".", "").replace(",", "."));
                    totalValorBruto += numeroDecimal;
                }
                if (contTotal == 8) {
                    let numeroDecimal = parseFloat(data[i].substr(3).replace(".", "").replace(",", "."));
                    totalValorBase += numeroDecimal;
                }
                if (contTotal == 9) {
                    let numeroDecimal = parseFloat(data[i].substr(3).replace(".", "").replace(",", "."));
                    totalValorRetido += numeroDecimal;
                }
                if (contTotal == 10) {
                    let prestador = data[i];
                    dadosPrestador = prestador;
                }
                if (i % 10 === 0) {
                    tableHTML += `</tr><tr>`;
                    contTotal = 0;
                }
            }

            tableHTML += `<tr>`;
            tableHTML += `<th>Total</th>`;
            tableHTML += `<th></th>`;
            tableHTML += `<th></th>`;
            tableHTML += `<th></th>`;
            tableHTML += `<th></th>`;
            tableHTML += `<th></th>`;
            tableHTML += `<th>R$ ${totalValorBruto.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</th>`;
            tableHTML += `<th>R$ ${totalValorBase.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</th>`;
            tableHTML += `<th>R$ ${totalValorRetido.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</th>`;
            tableHTML += `</tr></table>`;

            Swal.fire({
                title: `Detalhes do Prestador<br/><br/>${dadosPrestador}`,
                html: `<div class="custom-table">${tableHTML}</div>`,
                icon: 'info',
                customClass: {
                    container: 'custom-swal-container',
                },
                grow: 'fullscreen',
                heightAuto: false,
                confirmButtonColor: '#006400',
            });
        }
    }
    var anoCompetenciaInput = document.getElementById("anocompetencia");
    var anoAtual = new Date().getFullYear();
    anoCompetenciaInput.value = anoAtual;

    var inputAnoCompetencia = document.getElementById("anocompetencia");
    inputAnoCompetencia.style.width = "70px";
</script>