<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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
require_once("libs/db_stdlib.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
?>
<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?php
    db_app::load("scripts.js,
                  prototype.js,
                  strings.js,
                  arrays.js,
                  windowAux.widget.js,
                  datagrid.widget.js,
                  dbmessageBoard.widget.js,
                  dbcomboBox.widget.js,
                  dbtextField.widget.js,
                  dbtextFieldData.widget.js,
                  DBInputHora.widget.js,
                  datagrid/plugins/DBOrderRows.plugin.js,
                  datagrid/plugins/DBHint.plugin.js");

    db_app::load(
        "estilos.css,
    grid.style.css"
    );
    ?>
</head>

<body style='margin-top: 25px' bgcolor="#cccccc">
<form name="form1" id='frmProcesso' method="post">
    <center>
        <div style='display:table;'>
            <fieldset>
                <legend style="font-weight: bold">Processo de Compra </legend>
                <table border='0'>
                    <tr>
                        <td nowrap title="À partir de qual data">
                            <?php db_ancora("Código de: ", "pesquisaCodigoProcessoCompra(true, `inicial`);",1); ?>
                        </td>
                        <td>
                            <?php
                            db_input('iCodigoProcessoCompraInicial',4, true, 1, 'text', 1, "onchange='pesquisaCodigoProcessoCompra(false, `inicial`)'");
                            ?>
                            <b><?php db_ancora('a', "pesquisaCodigoProcessoCompra(true, `final`);",1); ?></b>
                            <?php
                            db_input('iCodigoProcessoCompraFinal', 4, true, 1, 'text', 1, "onchange='pesquisaCodigoProcessoCompra(false, `final`)'");
                            ?>
                        </td>
                        <td>
                            <input name="btnProcessar" id="btnProcessar" type="button" value="Processar"  onclick='consultaCodigoProcesso();' >
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="Atualizar para">
                            <strong>Atualizar para:</strong>
                        </td>
                        <td>
                            <?php
                            db_inputdata('iAtualizarDataPara', "", "", "", true, 'text', 1)
                            ?>
                            <b></b>
                        </td>
                        <td>
                            <input name="btnAplicar" id="btnAplicar" type="button" value="Aplicar"  onclick='atualizarDataPara();' >
                        </td>
                    </tr>
                </table>
                <fieldset style='width:600px;'>
                    <div id='ctnGridProcessoCompra'></div>
                </fieldset>
            </fieldset>
        </div>
        <input name="btnAtualizar" id="btnAtualizar" type="button" value="Atualizar"  onclick='atualizarProcessosSelecionados();' >
    </center>
</form>
</body>
<script>
    const sUrlRpc = 'm4_controledatas.RPC.php';
    const oGridProcessoCompra          = new DBGrid('gridProcessoCompra');
    oGridProcessoCompra.nameInstance = 'oGridProcessoCompra';
    oGridProcessoCompra.setCheckbox(0);
    oGridProcessoCompra.setCellWidth( [ '0%', '10%', '70%', '20%'] );
    oGridProcessoCompra.setHeader( [ 'codigo', 'Código', 'Resumo', 'Data'] );
    oGridProcessoCompra.setCellAlign( [ 'left', 'left', 'left', 'center'] );
    oGridProcessoCompra.setHeight(130);
    oGridProcessoCompra.aHeaders[1].lDisplayed = false;
    oGridProcessoCompra.show($('ctnGridProcessoCompra'));
    let aProcessosCompra = [];
    let sInicialFinal = '';

    function consultaCodigoProcesso() {
        const oParametros = {};
        oParametros.exec = 'consultaCodigoProcessoCompra';
        oParametros.codigoProcessoInicial = $F('iCodigoProcessoCompraInicial');
        oParametros.codigoProcessoFinal = $F('iCodigoProcessoCompraFinal');

        if (validaCodigoProcessoCompra(oParametros.codigoProcessoInicial)) {
            js_divCarregando('Aguarde, Atualizando leituras...<br>Esse procedimento pode levar algum tempo.', 'msgBox');
            new Ajax.Request(sUrlRpc, {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParametros),
                onComplete: function(oResponse) {
                    const oRetorno = eval("(" + oResponse.responseText + ")");
                    aProcessosCompra = oRetorno.processosCompra;
                    js_removeObj('msgBox');
                    renderizaProcessoCompra();
                    if (oRetorno.status === 2) {
                        alert(oRetorno.message.urlDecode());
                    }
                }
            });
        }
    }

    function validaCodigoProcessoCompra(codigo) {
        if (typeof codigo === 'string' && codigo.trim() === '') {
           alert('O intervalo código de processo de compra não pode ser vazio!');
           oGridProcessoCompra.clearAll(true);
           return;
        }

        return true;
    }

    function pesquisaCodigoProcessoCompra(mostra, inicial_final) {
        sInicialFinal = inicial_final;
        const sAbreUrl = 'func_proccompras.php?funcao_js=parent.preencheEscondeCodigoProcessoCompra|pc80_codproc';
        const deveAparecer = !!mostra;

        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_pcproc', sAbreUrl, 'Pesquisa', deveAparecer);
    }

    function preencheEscondeCodigoProcessoCompra(codigoProcessoCompra) {
        if (codigoProcessoCompra === '') {
            return;
        }

        const codigoProcessoCompraCompara = $F('iCodigoProcessoCompraInicial');

        if ((typeof sInicialFinal === 'string' && sInicialFinal === 'final')
            && Number(codigoProcessoCompraCompara) > Number(codigoProcessoCompra)
        ) {
            alert('Informe um processo de compra final maior que o processo de compra inicial ' + codigoProcessoCompraCompara);
            return;
        }

        if (typeof sInicialFinal === 'string' && sInicialFinal === 'inicial') {
            document.querySelector(
                'form[name="form1"] input[name="iCodigoProcessoCompraInicial"]'
            ).value = codigoProcessoCompra;
        }

        if (typeof sInicialFinal === 'string' && sInicialFinal === 'final') {
            document.querySelector(
                'form[name="form1"] input[name="iCodigoProcessoCompraFinal"]'
            ).value = codigoProcessoCompra;
        }

        db_iframe_pcproc.hide();
    }

    function renderizaProcessoCompra() {
        oGridProcessoCompra.clearAll(true);
        aProcessosCompra.each(function (oProcessoCompra, iProcessoCompra) {
            let aLinha = [];
            aLinha.push(oProcessoCompra.codigo);
            aLinha.push(oProcessoCompra.codigo);
            aLinha.push(oProcessoCompra.resumo.urlDecode());
            const sDBDataFormatada = oProcessoCompra.data
                .split('-')
                .reverse()
                .join('/');
            const sDBData = oProcessoCompra.data.length ? sDBDataFormatada : '';
            const iData = new DBTextFieldData(
                'oDBTextFieldData' + iProcessoCompra,
                'oDBTextFieldData' + iProcessoCompra,
                sDBData,
                10
            ).toInnerHtml();
            aLinha.push(iData);
            oGridProcessoCompra.addRow(aLinha);
        });
        oGridProcessoCompra.renderRows();
    }

    function atualizarDataPara() {
        if (Array.isArray(aProcessosCompra) && !aProcessosCompra.length) {
            alert('Nenhuma processo de compra listada para atualizar data!');
            return;
        }

        const iAtualizarDataPara = $F('iAtualizarDataPara');

        if (iAtualizarDataPara.length === 0) {
            alert('Insira uma data para atualizar a(s) solicitação(ões) listada(s)!');
            return;
        }

        if (!oGridProcessoCompra.getSelection('array').length) {
            alert('Nenhum processo de compra selecionado para atualizar data!');
            return;
        }

        const iLinhas = oGridProcessoCompra.aRows.length;

        for (let i = 0; i < iLinhas; i++) {
            if (oGridProcessoCompra.aRows[i].isSelected) {
                let oCheckGrid = document.getElementById(
                    oGridProcessoCompra.aRows[i].aCells[4].getId()
                ).firstChild;
                oCheckGrid.value = iAtualizarDataPara;
            }
        }
    }

    function atualizarProcessosSelecionados() {
        const aProcessosSelecionados = oGridProcessoCompra.getSelection('array');

        if (Array.isArray(aProcessosSelecionados) && !aProcessosSelecionados.length) {
            alert('Selecione um processo de compra para atualizar!');
            return;
        }

        let aProcessosParaAtualizacao = new Array(aProcessosSelecionados.length)
            .fill(null)
            .map(() => ({
                codigo: 0,
                data: '',
            }));

        aProcessosSelecionados.each(
            function (oProcessoSelecionado, iProcessoSelecionado) {
                aProcessosParaAtualizacao[iProcessoSelecionado].codigo =
                    oProcessoSelecionado[1];
                aProcessosParaAtualizacao[iProcessoSelecionado].data =
                    oProcessoSelecionado[4];
            }
        );

        const verificaDatasVaziasNoGrid = aProcessosParaAtualizacao.some(
            (item) => typeof item === 'object' && item.data === ''
        );

        if (verificaDatasVaziasNoGrid) {
            alert('Insira uma data para atualizar o(s) processo(s) de compra!');
            return;
        }

        js_divCarregando('Aguarde, atualizando os dados!', 'msgBox');
        let oParametros = {};
        oParametros.exec = 'atualizarDatasProcessosCompra';
        oParametros.processosParaAtualizacao  =  aProcessosParaAtualizacao;
        new Ajax.Request(sUrlRpc, {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParametros),
            onComplete: function(oResponse) {
                js_removeObj('msgBox');
                const oRetorno = eval("(" + oResponse.responseText + ")");
                if (oRetorno.status === 1) {
                    alert('Atualizado(s) com sucesso.');
                } else {
                    alert(oRetorno.message.urlDecode());
                }
            }
        });
    }
</script>

</html>
<?php
db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
?>
