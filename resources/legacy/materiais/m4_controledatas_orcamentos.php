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
<form name="form1" id='frmMaterialServico' method="post">
    <center>
        <div style='display:table;'>
            <fieldset>
                <legend style="font-weight: bold">Orçamentos </legend>
                <table border='0'>
                    <tr>
                        <td nowrap title="À partir de qual data">
                            <?php db_ancora("Código de: ", "pesquisaCodigoOrcamento(true, `inicial`);",1); ?>
                        </td>
                        <td>
                            <?php
                            db_input('iCodigoOrcamentoInicial',4, true, 1, 'text', 1, "onchange='pesquisaCodigoOrcamento(false, `inicial`)'");
                            ?>
                            <b><?php db_ancora('a', "pesquisaCodigoOrcamento(true, `final`);",1); ?></b>
                            <?php
                            db_input('iCodigoOrcamentoFinal', 4, true, 1, 'text', 1, "onchange='pesquisaCodigoOrcamentoFinal(false, `final`)'");
                            ?>
                        </td>
                        <td>
                            <input name="btnProcessar" id="btnProcessar" type="button" value="Processar"  onclick='consultaCodigoOrcamento();' >
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
                    <div id='ctnGridOrcamentos'></div>
                </fieldset>
            </fieldset>
        </div>
        <input name="btnAtualizar" id="btnAtualizar" type="button" value="Atualizar"  onclick='atualizarOrcamentosSelecionados();' >
    </center>
</form>
</body>
<script>
    const sUrlRpc = 'm4_controledatas.RPC.php';
    const oGridOrcamentos          = new DBGrid('gridOrcamentos');
    oGridOrcamentos.nameInstance = 'oGridOrcamentos';
    oGridOrcamentos.setCheckbox(0);
    oGridOrcamentos.setCellWidth( [ '0%', '10%', '70%', '20%'] );
    oGridOrcamentos.setHeader( [ 'codigo', 'Código', 'Observação', 'Data'] );
    oGridOrcamentos.setCellAlign( [ 'left', 'left', 'left', 'center'] );
    oGridOrcamentos.setHeight(130);
    oGridOrcamentos.aHeaders[1].lDisplayed = false;
    oGridOrcamentos.show($('ctnGridOrcamentos'));
    let aOrcamentos = [];
    let sInicialFinal = '';

    function consultaCodigoOrcamento() {
        let oParametros = {};
        oParametros.exec = 'consultaCodigoOrcamentos';
        oParametros.codigoOrcamentoInicial = $F('iCodigoOrcamentoInicial');
        oParametros.codigoOrcamentoFinal = $F('iCodigoOrcamentoFinal');

        if (validaCodigoOrcamento(oParametros.codigoOrcamentoInicial)) {
            js_divCarregando('Aguarde, Atualizando leituras...<br>Esse procedimento pode levar algum tempo.', 'msgBox');
            new Ajax.Request(sUrlRpc, {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParametros),
                onComplete: function(oResponse) {
                    const oRetorno = eval("(" + oResponse.responseText + ")");
                    aOrcamentos = oRetorno.orcamentos;
                    js_removeObj('msgBox');
                    renderizaOrcamentos();
                    if (oRetorno.status === 2) {
                        alert(oRetorno.message.urlDecode());
                    }
                }
            });
        }
    }

    function validaCodigoOrcamento(codigo) {
        if (typeof codigo === 'string' && codigo.trim() === '') {
           alert('O intervalo código de orçamento não pode ser vazio!');
           oGridOrcamentos.clearAll(true);
           return;
        }

        return true;
    }

    function pesquisaCodigoOrcamento(mostra, inicial_final) {
        sInicialFinal = inicial_final;
        const sAbreUrl = 'func_pcorcam_controledatas.php?funcao_js=parent.preencheEscondeCodigoOrcamento|pc20_codorc';
        const deveAparecer = !!mostra;

        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_pcorcam', sAbreUrl, 'Pesquisa', deveAparecer);
    }

    function preencheEscondeCodigoOrcamento(codigoOrcamento) {
        if (codigoOrcamento === '') {
            return;
        }

        const codigoOrcamentoCompara = $F('iCodigoOrcamentoInicial');

        if ((typeof sInicialFinal === 'string' && sInicialFinal === 'final')
            && Number(codigoOrcamentoCompara) > Number(codigoOrcamento)
        ) {
            alert('Informe um orçamento final maior que o orçamento inicial ' + codigoOrcamentoCompara);
            return;
        }

        if (typeof sInicialFinal === "string" && sInicialFinal === 'inicial') {
            document.querySelector(
                'form[name="form1"] input[name="iCodigoOrcamentoInicial"]'
            ).value = codigoOrcamento;
        }

        if (typeof sInicialFinal === "string" && sInicialFinal === 'final') {
            document.querySelector(
                'form[name="form1"] input[name="iCodigoOrcamentoFinal"]'
            ).value = codigoOrcamento;
        }

        db_iframe_pcorcam.hide();
    }

    function renderizaOrcamentos() {
        oGridOrcamentos.clearAll(true);
        aOrcamentos.each(function (oOrcamento, iOrcamento) {
            const aLinha = [];
            aLinha.push(oOrcamento.codigo);
            aLinha.push(oOrcamento.codigo);
            aLinha.push(oOrcamento.observacao.urlDecode());
            const sDBDataFormatada = oOrcamento.data.split('-').reverse().join('/');
            const sDBData = oOrcamento.data.length ? sDBDataFormatada : '';
            const iData = new DBTextFieldData(
                'oDBTextFieldData' + iOrcamento,
                'oDBTextFieldData' + iOrcamento,
                sDBData,
                10
            ).toInnerHtml();
            aLinha.push(iData);
            oGridOrcamentos.addRow(aLinha);
        });
        oGridOrcamentos.renderRows();
    }

    function atualizarDataPara() {
        if (Array.isArray(aOrcamentos) && !aOrcamentos.length) {
            alert('Nenhum orçamento listado para atualizar data!');
            return;
        }

        const iAtualizarDataPara = $F('iAtualizarDataPara');

        if (iAtualizarDataPara.length === 0) {
            alert('Insira uma data para atualizar o(s) orçamento(s)!');
            return;
        }

        if (!oGridOrcamentos.getSelection('array').length) {
            alert('Nenhum orçamento selecionado para atualizar data!');
            return;
        }

        const iLinhas = oGridOrcamentos.aRows.length;

        for (let i = 0; i < iLinhas; i++) {
            if (oGridOrcamentos.aRows[i].isSelected) {
                let oCheckGrid = document.getElementById(
                    oGridOrcamentos.aRows[i].aCells[4].getId()
                ).firstChild;

                oCheckGrid.value = iAtualizarDataPara;
            }
        }
    }

    function atualizarOrcamentosSelecionados() {
        const aOrcamentosSelecionados = oGridOrcamentos.getSelection('array');

        if (Array.isArray(aOrcamentosSelecionados) && !aOrcamentosSelecionados.length) {
            alert('Selecione um orçamento para atualizar!');
            return;
        }

        let aOrcamentosParaAtualizacao = new Array(aOrcamentosSelecionados.length)
            .fill(null)
            .map(() => ({
                codigo: 0,
                data: '',
            }));

        aOrcamentosSelecionados.each(
            function (oOrcamentoSelecionado, iOrcamentoSelecionado) {
                aOrcamentosParaAtualizacao[iOrcamentoSelecionado].codigo =
                    oOrcamentoSelecionado[1];
                aOrcamentosParaAtualizacao[iOrcamentoSelecionado].data =
                    oOrcamentoSelecionado[4];
            }
        );

        const verificaDatasVaziasNoGrid = aOrcamentosParaAtualizacao.some(
            (item) => typeof item === 'object' && item.data === ''
        );

        if(verificaDatasVaziasNoGrid) {
            alert('Insira uma data para atualizar o(s) orçamento(s)!');
            return;
        }

        js_divCarregando('Aguarde, atualizando os dados!', 'msgBox');
        let oParametros = {};
        oParametros.exec = 'atualizarDatasOrcamentos';
        oParametros.orcamentosParaAtualizacao  =  aOrcamentosParaAtualizacao;
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
