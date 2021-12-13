<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("std/db_stdClass.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

include("classes/db_pagordem_classe.php");
include("classes/db_empagetipo_classe.php");
include("classes/db_empord_classe.php");
include("classes/db_empagemov_classe.php");
include("classes/db_empageconf_classe.php");
include("classes/db_empagepag_classe.php");

include("classes/db_slip_classe.php");
include("classes/db_slipnum_classe.php");

$clempagetipo = new cl_empagetipo;
$clpagordem   = new cl_pagordem;
$clempord     = new cl_empord;
$clempagemov  = new cl_empagemov;
$clempagepag  = new cl_empagepag;
$clempageconf  = new cl_empageconf;

$clslip       = new cl_slip;
$clslipnum    = new cl_slipnum;

include("dbforms/db_classesgenericas.php");
$cliframe_seleciona = new cl_iframe_seleciona;

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
//db_postmemory($HTTP_SERVER_VARS,2);

$db_opcao = 1;
$db_botao = false;
?>
<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?php
    db_app::load("scripts.js");
    db_app::load("prototype.js");
    db_app::load("datagrid.widget.js");
    db_app::load("strings.js");
    db_app::load("grid.style.css");
    db_app::load("estilos.css");
    ?>
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <style>
        <? $cor = "#999999" ?>.bordas02 {
            border: 2px solid #cccccc;
            border-top-color: <?= $cor ?>;
            border-right-color: <?= $cor ?>;
            border-left-color: <?= $cor ?>;
            border-bottom-color: <?= $cor ?>;
            background-color: #999999;
        }

        .bordas {
            border: 1px solid #cccccc;
            border-top-color: <?= $cor ?>;
            border-right-color: <?= $cor ?>;
            border-left-color: <?= $cor ?>;
            border-bottom-color: <?= $cor ?>;
            background-color: #cccccc;
        }
    </style>
    <script language="javascript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="javascript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="javascript" type="text/javascript" src="scripts/strings.js"></script>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="js_init()">
    <fieldset>
        <legend><b>Slip S/ Cheque</b></legend>
        <div id='gridNotas' style='z-index:0'></div>
    </fieldset>

    <input type='button' value='Pagamento de Slips' onclick='js_pagarEmpenhos()'>
</body>

</html>
<script>
    // Atualização de GRID - widouglas
    function js_init() {
        // Analisando o retorno
        gridNotas = new DBGrid("gridNotas");
        gridNotas.nameInstance = "gridNotas";

        gridNotas.selectSingle = function(oCheckbox, sRow, oRow) {
            if (oRow.getClassName() == 'comMov') {
                oCheckbox.checked = false;
            }

            if (oCheckbox.checked) {
                oRow.isSelected = true;
                $(sRow).className = 'marcado';
            } else {
                $(sRow).className = oRow.getClassName();
                oRow.isSelected = false;
            }

            /**
             * Atualiza inputs com total e registros
             * com total dos itens selecionados
             */
            var aSelecionados = this.getSelection('object');
            var iSelecionados = aSelecionados.length;
            var nTotal = 0;

            for (var iLinha = 0; iLinha < iSelecionados; iLinha++) {
                var oLinha = aSelecionados[iLinha];
                var nValor = js_strToFloat(oLinha.aCells[3].content);
                nTotal += nValor;
            }

            parent.document.form1.tot.value = js_formatar(nTotal, 'f');
            parent.document.form1.registros.value = iSelecionados;
        }

        gridNotas.setCheckbox(0);
        gridNotas.allowSelectColumns(true);
        gridNotas.setCellWidth(new Array('7%', '7%', '7%', '7%', '7%', '7%', '15%', '15%', '17%', '5%', '7%', '7%', '7%', '7%'));
        gridNotas.setCellAlign(new Array("center", "center", "right", "center", "center", "center", "left", "left", "left", "center", "center", "center", "center"));
        gridNotas.setHeader(new Array("Slip", "Mov.", "Valor", "Conta Crédito", "Conta Débito", "Data", "Descrição", "Descrição Conta", "Nome/Razão Social", "Instituição", "Situação", "Nº Documento"));
        gridNotas.show(document.getElementById('gridNotas'));

        js_getNotas();
    }

    sUrlRPC = "emp4_pagarpagamentoRPC.php";

    function js_getNotas() {
        // Analisando o retorno
        parent.js_divCarregando("Aguarde, consultando Movimentos.", "msgBox");

        var oParam = new Object();

        oParam.iOrdemIni = parent.$F('k17_codigo');
        oParam.iOrdemFim = parent.$F('k17_codigo2');
        oParam.iCodEmp = parent.$F('e60_codemp');
        oParam.iCodEmp2 = parent.$F('e60_codemp2');
        oParam.dtDataIni = parent.$F('dataordemini');
        oParam.dtDataFim = parent.$F('dataordemfim');
        oParam.dtChequeIni = parent.$F('dtchequeini');
        oParam.dtChequeFim = parent.$F('dtchequefim');
        oParam.iCtaPagadora = parent.$F('e83_codtipo');
        oParam.iNumCgm = parent.$F('z01_numcgm');
        oParam.iRecurso = parent.$F('o15_codigo');
        oParam.sNumeroCheque = parent.$F('cheque');
        oParam.sDtAut = parent.$F('e42_dtpagamento');
        oParam.iOPauxiliar = parent.$F('e42_sequencial');
        oParam.iOrdemBanc = parent.$F('k00_codseqpag');

        var sParam = js_objectToJson(oParam);
        var sJson = '{"exec":"getSlipSemCheque","params":[' + sParam + ']}';
        var oAjax = new Ajax.Request(
            sUrlRPC, {
                method: 'post',
                parameters: 'json=' + sJson,
                onComplete: js_retornoGetNotas
            }
        );
    }

    function js_retornoGetNotas(oAjax) {
        parent.js_removeObj("msgBox");
        gridNotas.clearAll(true);
        var oResponse = eval("(" + oAjax.responseText + ")");
        var iRowAtiva = 0;
        $('gridNotasstatus').innerHTML = "";

        if (oResponse.status == 1) {
            for (var iNotas = 0; iNotas < oResponse.aNotasLiquidacao.length; iNotas++) {
                // Erros a partir daqui
                with(oResponse.aNotasLiquidacao[iNotas]) {
                    var nValor = 0;
                    var lDisabled = false;
                    var sDisabled = "";
                    var aLinha = new Array();

                    aLinha[0] = k17_codigo;
                    aLinha[1] = e81_codmov;
                    aLinha[2] = js_formatar(k17_valor, 'f');
                    aLinha[3] = k17_credito;
                    aLinha[4] = k17_debito;
                    aLinha[5] = js_formatar(k17_data, 'd');
                    aLinha[6] = c50_descr.urlDecode().substring(0, 30);
                    aLinha[7] = c60_descr.urlDecode().substring(0, 30);
                    aLinha[8] = z01_nome.urlDecode().substring(0, 30);
                    aLinha[9] = k17_instit;
                    aLinha[10] = k17_situacao;
                    aLinha[11] = js_createInputNumDocumento(e81_numdoc, e81_codmov);

                    gridNotas.addRow(aLinha, false, lDisabled);
                    gridNotas.aRows[iRowAtiva].sValue = k17_valor;
                    iRowAtiva++;
                }
            }
            gridNotas.renderRows();
        } else if (oResponse.status == 2) {
            $('gridNotasstatus').innerHTML = "&nbsp;<b>Não foram encontrados movimentos.</b>";
        }
    }

    function js_createInputNumDocumento(sNumDoc, iCodMov) {
        return "<input value='" + sNumDoc + "' size='13' maxlength='15' id='numdoc" + iCodMov + "'>";
    }

    function js_pagarEmpenhos() {
        var sDataDia = "<?= date("d/m/Y", db_getsession("DB_datausu")) ?>";
        var aMovimentos = gridNotas.getSelection("object");

        if (aMovimentos.length == 0) {
            alert('Nenhum Movimento Selecionado');
            return false;
        }
        /*
        if (js_comparadata(sDataDia, parent.$F('data_para_pagamento'), ">")) {
            alert("Data Informada Inválida.\nData menor que a data do sistema");
            return false;
        }
        */
        oRequisicao = new Object();
        oRequisicao.exec = "pagarSlip";
        oRequisicao.dtPagamento = parent.$F('data_para_pagamento');
        oRequisicao.aMovimentos = new Array();
        var lMostraMsgErroRetencao = false;
        var sMsgRetencaoMesAnterior = "Atenção:\n";
        var sVirgula = "";

        for (var i = 0; i < aMovimentos.length; i++) {
            var oMovimento = new Object();
            oMovimento.iCodSlip = aMovimentos[i].aCells[1].getValue();
            oMovimento.iCodMov = aMovimentos[i].aCells[2].getValue();

            if (js_strToFloat(aMovimentos[i].aCells[3].getValue()) == 0) {
                oMovimento.nValorPagar = 0;
            } else {
                oMovimento.nValorPagar = js_strToFloat(aMovimentos[i].aCells[3].getValue()).valueOf();
            }

            oMovimento.sNumDoc = document.getElementById("numdoc" + aMovimentos[i].aCells[2].getValue()).value;
            oRequisicao.aMovimentos.push(oMovimento);
        }
        // console.log(oRequisicao);
        parent.js_divCarregando("Aguarde, pagando movimentos.", "msgBox")
        var sJson = js_objectToJson(oRequisicao);
        
        var oAjax = new Ajax.Request(
            sUrlRPC, {
                method: 'post',
                parameters: 'json=' + sJson,
                onComplete: js_retornoPagarEmpenho
            }
        );

        return false;
    }

    function js_retornoPagarEmpenho(oAjax) {
        parent.js_removeObj("msgBox");
        var oRetorno = eval("(" + oAjax.responseText + ")");
        console.log(oRetorno);
        js_getNotas();
    }
</script>