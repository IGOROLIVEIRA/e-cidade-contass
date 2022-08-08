<?php
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

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_procandam_classe.php");
require_once("classes/db_proctransfer_classe.php");
require_once("classes/db_protprocesso_classe.php");
require_once("classes/db_proctransand_classe.php");

$db_opcao = 1;
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clprocandam = new cl_procandam;
$clproctransfer = new cl_proctransfer;
$clprotprocesso = new cl_protprocesso;
$clproctransand = new cl_proctransand;
$rotulo = new rotulocampo();
$rotulo->label("p58_codproc");
$rotulo->label("p58_requer");
$rotulo->label("p58_numcgm");
$rotulo->label("p58_id_usuario");
$rotulo->label("p58_coddepto");
$rotulo->label("z01_nome");
$rotulo->label("numeroProcesso");

!isset($grupo) ? $grupo = 1 : '';

$instit = db_getsession("DB_instit");
$sSQL = "SELECT p51_codigo, p51_descr FROM tipoproc WHERE p51_instit = $instit";
$tpProcessos = db_utils::getCollectionByRecord(db_query($sSQL));

?>
<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?php
    db_app::load("scripts.js, AjaxRequest.js, datagrid.widget.js, windowAux.widget.js, dbautocomplete.widget.js, dbtextFieldData.widget.js");
    db_app::load("dbmessageBoard.widget.js, prototype.js, dbtextField.widget.js, dbcomboBox.widget.js");
    db_app::load("estilos.css, grid.style.css");
    ?>
    <style>
        .formatselect {
            width: 259px;
            height: 18px;
        }
    </style>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#cccccc">
    <tr>
        <td width="360" height="40">&nbsp;</td>
        <td width="263">&nbsp;</td>
        <td width="25">&nbsp;</td>
        <td width="140">&nbsp;</td>
    </tr>
</table>
<form method="post" action="" name="form1">

    <table align="center">
        <tr>
            <td>
                <table>
                    <tr>
                        <td>
                            <strong>Numero do Processo:</strong>
                        </td>
                        <td>
                            <?php
                            db_input('p58_codproc', 10, "", true, 'text', $db_opcao, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Protocolo Geral:</strong>
                        </td>
                        <td>
                            <?php
                            db_input('p58_numero', 10, "", true, 'text', $db_opcao, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Requerente:</strong>
                        </td>
                        <td>
                            <?php
                            db_input('p58_requer', 35, "", true, 'text', $db_opcao, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Tipo de Processo:</strong>
                        </td>
                        <td>
                            <select name="p51_codigo" class="formatselect">
                                <option value="">Todos</option>
                                <?php foreach ($tpProcessos as $tpProcesso) : ?>
                                    <option value="<?= $tpProcesso->p51_codigo ?>"><?= $tpProcesso->p51_descr ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center">
                <input type="submit" name="db_opcao" value="Pesquisar">
                <input type="button" value="Limpar" onclick="window.location.reload();">
                <input type="button" value="Finalizar" onclick="js_buscarInformacoesFornecedores();">
            </td>
        </tr>
    </table>
</form>
<table height="100%" border="0" align="center" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
        <td align="center" valign="top">
            <?php
            $where = " p58_instit = " . db_getsession("DB_instit")."
        AND p58_codproc NOT IN (SELECT p111_codproc FROM nfaberturaprocesso)
        AND p58_codproc NOT IN (SELECT p112_codproc FROM nfprevisaopagamento)";

            $campos = "p58_codproc,cast(p58_numero||'/'||p58_ano as varchar) as p58_numero,z01_numcgm as DB_p58_numcgm,z01_nome,p58_dtproc,p51_descr,p58_obs,p58_requer as DB_p58_requer";
            if (!empty($p58_codproc)) {
                $nrProcesso = explode("/", $p58_codproc);
                !empty($where) ? $where .= " and p58_codproc = {$nrProcesso[0]} and p58_ano = {$nrProcesso[1]} " : $where .= " p58_codproc = {$nrProcesso[0]} and p58_ano = {$nrProcesso[1]} ";
            }
            if (!empty($p58_numero)) {
                !empty($where) ? $where .= " and p58_numero = {$p58_numero} " : $where .= " p58_numero = {$p58_numero} ";
            }
            if (!empty($p58_requer)) {
                !empty($where) ? $where .= " and p58_requer like '%{$p58_requer}%' " : $where .= " p58_requer like '%{$p58_requer}%' ";
            }
            if (!empty($p51_codigo)) {
                !empty($where) ? $where .= " and p51_codigo = {$p51_codigo} " : $where .= " p51_codigo = {$p51_codigo} ";
            }
            $sql = $clprotprocesso->sql_query("", $campos, " p58_codproc desc ", $where);

            $repassa = array();
            if (isset($p58_codproc)) {
                $repassa = array("p58_codproc" => $p58_codproc);
            }
            db_lovrot($sql . " ", 15, "()", "", "js_addFornecedor|p58_numero|p58_codproc", "", "NoMe", $repassa);
            ?>
        </td>
    </tr>
</table>

</body>

</html>
<script>
    let fornecedores = [];

    function js_removerSelecionados() {
        let aSelecionados = oGridFornecedores.getSelection('object');
        let aLinhasRemover = [];
        aSelecionados.each(function(oLinha) {
            aLinhasRemover.push(oLinha.getRowNumber());
        });

        oGridFornecedores.removeRow(aLinhasRemover);
        oGridFornecedores.renderizar2();

    }

    function novoAjax(params, onComplete) {

        var request = new Ajax.Request('prot4_notificafornecedores.RPC.php', {
            method: 'post',
            parameters: 'json=' + Object.toJSON(params),
            onComplete: onComplete
        });

    }

    function js_addFornecedor(chave1, chave2) {
        var salvar = confirm("Deseja notificar o fornecedor do protocolo " + chave1 + "?");
        if (salvar == true) {
            var jaTem = Array.prototype.filter.call(fornecedores, function(o) {
                return o == chave2;
            });
            if (jaTem.length > 0) {
                alert("Fornecedor já inserido.");
                return;
            }
            fornecedores.push(chave2);
        } else {
            return false;
        }
    }

    function js_buscarInformacoesFornecedores() {
        let ckFornecedores = fornecedores == '';
        if (ckFornecedores) {
            alert("Selecione pelo menos um processo!");
            return false;
        }

        var oParams = {
            exec: 'buscarInformacoes',
            aba: 'geral',
            aCodFornec: fornecedores.join(',')
        };

        novoAjax(oParams, function(e) {
            var oRetorno = JSON.parse(e.responseText);
            if (oRetorno.status == 1) {
                setInformacoes(oRetorno);
            } else {
                alert(oRetorno.erro);
            }
        });
    }

    function js_confirmar() {

        let ckMarcados = false;

        let oParams = {
            exec: "enviarEmail",
            fornecedores: []
        };
        let tipoNotificacao
        for (var oRow of oGridFornecedores.getRows()) {
            if (oRow.isSelected) {
                tipoNotificacao = new Number(oRow.aCells[3].getValue().split('-')[1]);
                if (isNaN(tipoNotificacao)) {
                    alert("Informe o tipo de notificação do processo " + oRow.aCells[1].getValue());
                    ckMarcados = true;
                    return false;
                }

                if (tipoNotificacao == 1) {
                    if (!oRow.aCells[4].getValue()) {
                        alert("Preencha a nota fiscal do processo " + oRow.aCells[1].getValue());
                        ckMarcados = true;
                        return false;
                    }
                }

                if (tipoNotificacao == 2) {
                    if (!oRow.aCells[4].getValue()) {
                        alert("Preencha a nota fiscal do processo " + oRow.aCells[1].getValue());
                        ckMarcados = true;
                        return false;
                    }
                    if (!oRow.aCells[5].getValue()) {
                        alert("Preencha a data de liquidação do processo " + oRow.aCells[1].getValue());
                        ckMarcados = true;
                        return false;
                    }
                    if (!oRow.aCells[6].getValue()) {
                        alert("Preencha a data de previsão do processo " + oRow.aCells[1].getValue());
                        ckMarcados = true;
                        return false;
                    }
                }
                if (tipoNotificacao == 3) {
                    if (!oRow.aCells[4].getValue()) {
                        alert("Preencha a nota fiscal do processo " + oRow.aCells[1].getValue());
                        ckMarcados = true;
                        return false;
                    }
                    if (!oRow.aCells[7].getValue()) {
                        alert("Preencha o número do pagamento do processo " + oRow.aCells[1].getValue());
                        ckMarcados = true;
                        return false;
                    }
                }

                let oFornecedorAdd = {};
                oFornecedorAdd.p110_sequencial = new Number(oRow.aCells[3].getValue().split('-')[0]);
                oFornecedorAdd.protocolo = oRow.aCells[0].getValue();
                oFornecedorAdd.codproc = oRow.aCells[8].getValue();
                oFornecedorAdd.nfe = oRow.aCells[4].getValue();
                oFornecedorAdd.dataliquidacao = oRow.aCells[5].getValue();
                oFornecedorAdd.dataprevisao = oRow.aCells[6].getValue();
                oFornecedorAdd.numpagamento = oRow.aCells[7].getValue();
                oFornecedorAdd.numcgm = oRow.aCells[9].getValue();
                oParams.fornecedores.push(oFornecedorAdd);
                ckMarcados = true;

            }
        }

        if (!ckMarcados) {
            alert('Nenhum fornecedor selecionado para notificação.');
            return false;
        }
        js_divCarregando('Aguarde', 'div_aguarde');
        novoAjax(oParams, function(e) {
            var oRetorno = JSON.parse(e.responseText);
            if (oRetorno.status == 1) {
                js_removeObj('div_aguarde');
                alert('Fornecedor(es) notificado(s) com sucesso.');
                fornecedores = [];
                windowDadosFornecedor.destroy();
                if (tipoNotificacao != 0) {
                    CurrentWindow.corpo.iframe_aberturaprocesso.location.href    = 'pro1_aba2nfaberturaprocesso004.php';
                    CurrentWindow.corpo.iframe_previsaodepagamento.location.href = 'pro1_aba3nfprevisaodepagamento004.php';
                    CurrentWindow.corpo.iframe_geral.location.href= "pro1_aba1nfgeral004.php";
                    parent.mo_camada('previsaodepagamento');
                }
            } else {
                js_removeObj('div_aguarde');
                alert(oRetorno.erro);
            }
        });
    }

    function setInformacoes(oRetorno) {
        var sContentFornecedor = "  <div id='frmDadosFornecedores'>";
        sContentFornecedor += "  </div>";
        sContentFornecedor += "<p align='center'>";
        sContentFornecedor += "  <input type='button' name='confirmar' ";
        sContentFornecedor += "  id='confirmar' value='Confirmar' "
        sContentFornecedor += "  onclick='js_confirmar()' "
        sContentFornecedor += "  />";
        sContentFornecedor += "  <input type='button' name='remover' ";
        sContentFornecedor += "  id='remover' value='Remover' "
        sContentFornecedor += "  />";
        sContentFornecedor += "</p>";

        var iWidth = screen.availWidth / 1.1;
        var iHeight = js_round(screen.availHeight / 1.5, 0);

        windowDadosFornecedor = new windowAux('windowDadosFornecedor',
            'Dados da notificação do fornecedor',
            iWidth,
            iHeight
        );

        windowDadosFornecedor.setContent(sContentFornecedor);

        oMessageBoard = new DBMessageBoard('msgboardDados',
            'Notificação do Fornecedor',
            'Informe os dados abaixo para envio de e-mail ao fornecedor',
            windowDadosFornecedor.getContentContainer()
        );

        windowDadosFornecedor.setShutDownFunction(function() {
            windowDadosFornecedor.destroy();
        });

        oMessageBoard.show();

        oGridFornecedores = new DBGrid('frmDadosFornecedores');
        oGridFornecedores.nameInstance = "oGridFornecedores";
        oGridFornecedores.setCheckbox(0);
        oGridFornecedores.setCellWidth(new Array('11%', '30%', '11%', "11%", "11%", "11%", "11%", "11%", "11%"));
        oGridFornecedores.setHeader(new Array("Nº Processo", "Nome/Razão Social", "Tipo de Notificação", "Nota Fiscal", "Liquidação", "Previsão", "Nº Pagamento", "iSeq", "numcgm"));
        oGridFornecedores.aHeaders[8].lDisplayed = false;
        oGridFornecedores.aHeaders[9].lDisplayed = false;
        oGridFornecedores.show($('frmDadosFornecedores'));

        oGridFornecedores.clearAll(true);

        let aFornecedores = oRetorno.fornecedores;
        let aTiposNotificacao = oRetorno.tiposnotificacao;

        aFornecedores.each(function(oFornecedor, iSeq) {
            aLinha = new Array();

            aLinha[0] = oFornecedor.p58_numero;

            aLinha[1] = oFornecedor.z01_nome;

            aLinha[2] = new DBComboBox('tiponotificacao' + iSeq, 'tiponotificacao' + iSeq, null, '90%');
            aLinha[2].addItem('0', 'Selecione');
            aTiposNotificacao.each(function(oTipoN, iSeq) {
                aLinha[2].addItem(oTipoN.p110_sequencial+'-'+oTipoN.p110_vinculonotificacao, oTipoN.p110_tipo);
            });

            aLinha[2].addEvent("onChange", "js_validaTipoNotificacao(" + iSeq + ",this.value);");

            oNfe = new DBTextField('nfe' + iSeq, 'nfe' + iSeq, '');
            oNfe.addEvent("onKeyPress", "return js_mask(event,\"0-9\")");
            oNfe.addStyle("width", "90%");
            oNfe.setClassName("text-right");
            oNfe.setReadOnly(true);
            aLinha[3] = oNfe.toInnerHtml();

            oLiquidacao = new DBTextFieldData('liquidacao' + iSeq, 'liquidacao' + iSeq);
            oLiquidacao.setReadOnly(true);
            aLinha[4] = oLiquidacao.toInnerHtml();

            oPrevisao = new DBTextFieldData('previsao' + iSeq, 'previsao' + iSeq);
            oPrevisao.setReadOnly(true);
            aLinha[5] = oPrevisao.toInnerHtml();

            oNpagamento = new DBTextField('npagamento' + iSeq, 'npagamento' + iSeq, '');
            oNpagamento.addStyle("width", "90%");
            oNpagamento.setClassName("text-right");
            oNpagamento.setReadOnly(true);
            aLinha[6] = oNpagamento.toInnerHtml();

            aLinha[7] = oFornecedor.p58_codproc;

            aLinha[8] = oFornecedor.p58_numcgm;

            oGridFornecedores.addRow(aLinha);
        });

        oGridFornecedores.renderRows(false, false);
        windowDadosFornecedor.allowCloseWithEsc(false);
        windowDadosFornecedor.show();

        $('remover').observe('click', function() {
            js_removerSelecionados();
        });

    }

    function js_validaTipoNotificacao(iLinha, valor) {

        let aLinha = oGridFornecedores.aRows[iLinha];
        let aNfe, aLiquidacao, aPrevisao, aNpagamento;
        let vinculonotificacao = valor.split('-');

        switch (vinculonotificacao[1]) {

            case '1':
                aNfe = document.getElementById(aLinha.aCells[4].getId()).children[0];
                aNfe.readOnly = false;
                aNfe.removeClassName('readonly');
                aNfe.value = "";

                aLiquidacao = document.getElementById(aLinha.aCells[5].getId()).children[0];
                aLiquidacao.readOnly = true;
                aLiquidacao.addClassName('readonly');
                aLiquidacao.value = "";
                aLiquidacaobtn = document.getElementById(aLinha.aCells[5].getId()).children[1];
                aLiquidacaobtn.disabled = true;

                aPrevisao = document.getElementById(aLinha.aCells[6].getId()).children[0];
                aPrevisao.readOnly = true;
                aPrevisao.addClassName('readonly');
                aPrevisao.value = "";
                aPrevisaobtn = document.getElementById(aLinha.aCells[6].getId()).children[1];
                aPrevisaobtn.disabled = true;

                aNpagamento = document.getElementById(aLinha.aCells[7].getId()).children[0];
                aNpagamento.readOnly = true;
                aNpagamento.addClassName('readonly');
                aNpagamento.value = "";

                break;

            case '2':
                aNfe = document.getElementById(aLinha.aCells[4].getId()).children[0];
                aNfe.readOnly = false;
                aNfe.removeClassName('readonly');
                aNfe.value = "";

                aLiquidacao = document.getElementById(aLinha.aCells[5].getId()).children[0];
                aLiquidacao.readOnly = false;
                aLiquidacao.removeClassName('readonly');
                aLiquidacao.value = "";
                aLiquidacaobtn = document.getElementById(aLinha.aCells[5].getId()).children[1];
                aLiquidacaobtn.disabled = false;

                aPrevisao = document.getElementById(aLinha.aCells[6].getId()).children[0];
                aPrevisao.readOnly = false;
                aPrevisao.removeClassName('readonly');
                aPrevisao.value = "";
                aPrevisaobtn = document.getElementById(aLinha.aCells[6].getId()).children[1];
                aPrevisaobtn.disabled = false;

                aNpagamento = document.getElementById(aLinha.aCells[7].getId()).children[0];
                aNpagamento.readOnly = true;
                aNpagamento.addClassName('readonly');
                aNpagamento.value = "";

                break;

            case '3':

                aNfe = document.getElementById(aLinha.aCells[4].getId()).children[0];
                aNfe.readOnly = false;
                aNfe.removeClassName('readonly');
                aNfe.value = "";


                aLiquidacao = document.getElementById(aLinha.aCells[5].getId()).children[0];
                aLiquidacao.readOnly = true;
                aLiquidacao.addClassName('readonly');
                aLiquidacao.value = "";
                aLiquidacaobtn = document.getElementById(aLinha.aCells[5].getId()).children[1];
                aLiquidacaobtn.disabled = true;

                aPrevisao = document.getElementById(aLinha.aCells[6].getId()).children[0];
                aPrevisao.readOnly = true;
                aPrevisao.addClassName('readonly');
                aPrevisao.value = "";
                aPrevisaobtn = document.getElementById(aLinha.aCells[6].getId()).children[1];
                aPrevisaobtn.disabled = true;

                aNpagamento = document.getElementById(aLinha.aCells[7].getId()).children[0];
                aNpagamento.readOnly = false;
                aNpagamento.removeClassName('readonly');
                aNpagamento.value = "";

                break;

            default:
                aNfe = document.getElementById(aLinha.aCells[4].getId()).children[0];
                aNfe.readOnly = true;
                aNfe.addClassName('readonly');
                aNfe.value = "";

                aLiquidacao = document.getElementById(aLinha.aCells[5].getId()).children[0];
                aLiquidacao.readOnly = true;
                aLiquidacao.addClassName('readonly');
                aLiquidacao.value = "";
                aLiquidacaobtn = document.getElementById(aLinha.aCells[5].getId()).children[1];
                aLiquidacaobtn.disabled = true;

                aPrevisao = document.getElementById(aLinha.aCells[6].getId()).children[0];
                aPrevisao.readOnly = true;
                aPrevisao.addClassName('readonly');
                aPrevisao.value = "";
                aPrevisaobtn = document.getElementById(aLinha.aCells[6].getId()).children[1];
                aPrevisaobtn.disabled = true;

                aNpagamento = document.getElementById(aLinha.aCells[7].getId()).children[0];
                aNpagamento.readOnly = true;
                aNpagamento.addClassName('readonly');
                aNpagamento.value = "";
        }

    }

</script>
