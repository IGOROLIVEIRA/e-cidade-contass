<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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
require_once("libs/db_libdicionario.php");
require_once("libs/db_libcontabilidade.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_classesgenericas.php");
require_once("classes/db_conparametro_classe.php");
$clrotulo = new rotulocampo;
$clrotulo->label("c52_descr");
$clrotulo->label("c61_reduz");
$clrotulo->label("c51_descr");
$clrotulo->label("c60_descr");
$clrotulo->label("codigo");
$clrotulo->label("c61_codigo");
$clrotulo->label("o15_descr");
$clrotulo->label("nomeinst");
$clrotulo->label("c90_estrutsistema");
$clrotulo->label("c60_estrut");
$clrotulo->label("c60_naturezasaldo");
$clrotulo->label("c64_descr");

$clrotulo->label("db89_db_bancos");
$clrotulo->label("db89_codagencia");
$clrotulo->label("db89_digito");
$clrotulo->label("db83_conta");
$clrotulo->label("db83_dvconta");
$clrotulo->label("db83_identificador");
$clrotulo->label("db83_codigooperacao");
$clrotulo->label("db83_tipoconta");
$clrotulo->label("db83_numerocontratooc");
$clrotulo->label("db83_dataassinaturacop");
$GsTitulo        = 't';
$NsFuncionamento = 'style="background-color:#E6E4F1;"';
$NsFuncao        = 'style="background-color:#E6E4F1;"';

$oEstruturaSistema = new cl_estrutura_sistema();
$iOpcao = 1;
?>
<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?
    db_app::load("scripts.js");
    db_app::load("prototype.js");
    db_app::load("strings.js");
    db_app::load("dbautocomplete.widget.js");
    db_app::load("DBViewContaBancaria.js");
    db_app::load("dbmessageBoard.widget.js");
    db_app::load("estilos.css");
    db_app::load("dbtextField.widget.js");
    db_app::load("dbcomboBox.widget.js");
    db_app::load("prototype.maskedinput.js");
    db_app::load("windowAux.widget.js");
    db_app::load("AjaxRequest.js");
    ?>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <style>
        select {
            width: 98%;
        }

        textarea {
            width: 100%;
        }

        input#c90_estrutcontabil:disabled {
            background-color: #DEB887;
            color: black
        }
    </style>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">


    <form name="form1" id='form1'>
        <center>
            <br />
            <fieldset style="width: 500px;">
                <legend><b>Plano de Contas PCASP</b></legend>
                <table border="0" width="500px;">
                    <tr>
                        <td><b>Código:</b></td>
                        <td>
                            <?php
                            db_input("iCodigoConta", 5, false, 3, "text", 3);
                            ?>

                            <b> Nº Registro Obrig TCE-MG:</b>

                            <?php
                            db_input("c60_nregobrig", 2, true, 3, "text", $db_opcao, "", "", "", "", 2);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap="nowrap">
                            <b>Estrutural Contabilidade</b>
                        </td>
                        <td>
                            <?
                            $mascara = '0.0.0.0.0.00.00.00.00.00';
                            db_input('mascara', 30, $Ic60_estrut, true, 'text', 3, "", "", "", "width:98%;");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap="nowrap">
                            <b>Estrutural Contabilidade</b>
                        </td>
                        <td>
                            <?
                            db_input('c90_estrutcontabil', 30, $Ic60_estrut, true, 'text', $db_opcao, "", "", "", "width:98%;");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Título:</b></td>
                        <td>
                            <?php
                            db_input("sTitulo", 50, "0", true, "text", $db_opcao, "", "", "", "", 50);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Natureza de Saldo:</b></td>
                        <td>
                            <?php
                            $aNaturezaSaldo = array(
                                1 => "Saldo Devedor",
                                2 => "Saldo Credor",
                                3 => "Ambos"
                            );
                            db_select("iNaturezaSaldo", $aNaturezaSaldo, true, $db_opcao);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            db_ancora("<b>Sistema:</b>", "js_lookupSistemaConta(true)", $db_opcao);
                            ?>
                        </td>
                        <td>
                            <?php
                            db_input("iSistemaConta", 5, false, 3, "text", $db_opcao, "onchange='js_lookupSistemaConta(false);'");
                            db_input("sDescricaoSistemaConta", 35, false, 3, "text", 3, "", "", "", "width:81%;");
                            ?>
                        </td>
                    </tr>
                    <tr id="trIndicadorSuperavit" style="display: none;">
                        <td nowrap="nowrap"><b>Indicador Superávit:</b></td>
                        <td>
                            <?php
                            /*
                         * Organiza um array com os valores padrão cadastrado no dicionário de dados
                         */
                            $aIndicadorSuperavit = getValoresPadroesCampo("c60_identificadorfinanceiro");
                            $aRecordSuperavit    = array();
                            foreach ($aIndicadorSuperavit as $sSigla => $sDescricao) {
                                $aRecordSuperavit[$sSigla] = "{$sSigla} - {$sDescricao}";
                            }
                            db_select("sIndicadorSuperavit", $aRecordSuperavit, true, $db_opcao);
                            ?>
                        </td>
                    </tr>
                    <tr id="trDetalhamentoSistema" style="display:none;">
                        <td nowrap="nowrap">
                            <?php
                            db_ancora("<b>Detalhamento do Sistema:</b>", "js_lookupDetalhamentoSistema(true)", $db_opcao);
                            ?>
                        </td>
                        <td>
                            <?php
                            db_input("iDetalhamentoSistema", 5, false, 3, "text", $db_opcao, "onchange='js_lookupDetalhamentoSistema(false);'");
                            db_input("sDescricaoDetalhamentoSistema", 35, false, 3, "text", 3, "", "", "", "width:81%;");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Tipo de Conta</b></td>
                        <td>
                            <?php
                            $aTipoConta = array(0 => "Sintética", 1 => "Analítica");
                            db_select("iTipoConta", $aTipoConta, true, $db_opcao, "onchange='js_verificaEstrutural();'");
                            ?>
                        </td>
                    </tr>
                    <tr id='conta-corrente' style='display: none;'>
                        <td>
                            <?php
                            db_ancora("<b>Conta Corrente:</b>", "js_pesquisaContaCorrente(true)", 3);
                            ?>
                        </td>
                        <td nowrap="nowrap">
                            <?php
                            db_input("iCodigoContaCorrente", 10, null, true, "text", 3, "onchange='js_pesquisaContaCorrente(false);'");
                            db_input("sDescricaoContaCorrente", 35, null, true, "text", 3);
                            ?>
                        </td>
                    </tr>
                    <tr id='infCompMSC' style='display: none;'>
                        <td><b>Inf. Comp. MSC</b></td>
                        <td>
                            <?php
                            $aInfCompMSC = array(
                                "" => "Selecione", 1 => "01 - Poder e Orgão", 2 => "02 - Atributos do Superávit Financeiro", 3 => "03 - Dívida Consolidada", 4 => "04 - Financeiro por Fonte", 5 => "05 - Fonte de recursos", 6 => "06 - Célula da Receita", 7 => "07 - Célula da Despesa", 8 => "08 - Financeiro por fonte mais DC", 9 => "09 - Restos a Pagar"
                            );
                            db_select("c60_infcompmsc", $aInfCompMSC, true, $db_opcao, "");
                            ?>
                        </td>
                    </tr>
                    <tr id="trTipolancamento" style="display:none;">
                        <td colspan="2">
                            <fieldset>
                                <legend>Tipos TCE-MG</legend>
                                <table>
                                    <tr>
                                        <td nowrap="nowrap">
                                            <b>Tipo Lançamento</b>
                                        </td>
                                        <td>
                                            <?php
                                            $aTipoLancamento = array(0 => "", 1 => "01-Depósitos e Consignações", 2 => "02-Débitos de Tesouraria", 3 => "03-Ativo Realizável", 4 => "04-Transferências Financeiras", 5 => "05-Valores Disponibilizados em Conta Única do Tesouro Municipal", 9999 => "99-Outros");
                                            db_select("iTipoLancamento", $aTipoLancamento, true, $db_opcao, "onchange='js_getSubtipo();'");
                                            ?>
                                        </td>
                                    </tr>


                                    <tr id="trsubtipo">
                                        <td nowrap="nowrap">
                                            <b>SubTipo</b>
                                        </td>
                                        <td>
                                            <?php
                                            $asubTipo = array();
                                            db_select("isubtipo", $asubTipo, true, $db_opcao, "onchange='js_novo_subtipo();js_getDesdobraSubtipo();'");
                                            db_input("isubtipo_hidden", 5, 1, 3, "hidden", $db_opcao, "", "", "", "", 4);
                                            ?>
                                        </td>
                                    </tr>

                                    <tr id="trsubtipoNovo" style="display:none;">
                                        <td nowrap="nowrap" colspan="2">
                                            <fieldset>
                                                <legend>Incluir SubTipo</legend>
                                                <b>SubTipo</b><?php db_input("c200_subtipo", 5, 1, 3, "text", $db_opcao, "", "", "", "", 4); ?>
                                                <b>Descrição</b><?php db_input("c200_descsubtipo", 35, 0, 3, "text", $db_opcao, "", "", "", "text-transform: uppercase;", 100); ?>
                                                <input type="button" name="btnIncluirSubtipo" id="btnIncluirSubtipo" value="Adicionar" />
                                            </fieldset>
                                        </td>
                                    </tr>

                                    <tr id="trdesdobramento">
                                        <td nowrap="nowrap">
                                            <b>Desdobramento Subtipo:</b>
                                        </td>
                                        <td>
                                            <?php
                                            $adesdobramento = array();
                                            db_select("idesdobramento", $adesdobramento, true, $db_opcao, "onchange='js_novo_desdobrasubtipo();'");
                                            db_input("idesdobramento_hidden", 5, 1, 3, "hidden", $db_opcao, "", "", "", "", 4);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr id="trdesdobramentoNovo" style="display:none;">
                                        <td nowrap="nowrap" colspan="2">
                                            <fieldset>
                                                <legend>Incluir SubTipo</legend>
                                                <b>Desdobra SubTipo</b><?php db_input("c201_desdobrasubtipo", 5, 1, 3, "text", $db_opcao, "", "", "", "", 4); ?>
                                                <b>Descrição</b><?php db_input("c201_descdesdobrasubtipo", 35, 0, 3, "text", $db_opcao, "", "", "", "text-transform: uppercase;", 100); ?>
                                                <input type="button" name="btnIncluirDesdobraSubtipo" id="btnIncluirDesdobraSubtipo" value="Adicionar" />
                                            </fieldset>
                                        </td>
                                    </tr>

                                </table>
                            </fieldset>
                    <tr id='trdivContaBancaria' style='display: none'>
                        <td>
                            <?php
                            db_ancora("<b>Conta Bancária:</b>", "js_abreContaBancaria(true)", $db_opcao);
                            ?>
                        </td>
                        <td>
                            <?php
                            db_input("iContaBancaria", 5, false, 3, "text", 3);
                            db_input("sDescricaoContaBancaria", 35, false, 3, "text", 3, "", "", "", "width:81%;");
                            ?>
                        </td>
                    </tr>
                    <tr id="trnatureza" style="display: <?= $db_opcao == 2 ? 'table-row' : 'none' ?> ;">
                        <td>
                            <?php
                            db_ancora("<b>Natureza da Receita:</b>", "js_pesquisainatureza(true);", $db_opcao);
                            ?>
                        </td>
                        <td>
                            <?php
                            db_input("c60_naturezadareceita", 5, false, 3, "text", $db_opcao, "onchange='js_pesquisainatureza(false);'");
                            db_input("c60_descr", 35, false, 3, "text", 3, "", "", "", "width:81%;");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <fieldset>
                                <legend><b>Funcionamento</b></legend>
                                <?php
                                db_textarea("sFuncionamento", 3, 65, false, true, 'text', $db_opcao);
                                ?>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <fieldset>
                                <legend><b>Função</b></legend>
                                <?php
                                db_textarea("sFuncao", 3, 65, false, true, 'text', $db_opcao);
                                ?>
                            </fieldset>
                        </td>
                    </tr>
                    <tr id="trCgmPessoa" style="display: none;">
                        <td>
                            <?
                            db_ancora("CGM Pessoa", "js_pesquisac60_cgmpessoa(true);", $db_opcao);
                            ?>
                        </td>
                        <td>
                            <?
                            db_input('c60_cgmpessoa', 5, 1, true, 'text', $db_opcao, " onchange='js_pesquisac60_cgmpessoa(false);'")
                            ?>
                            <?
                            db_input('z01_nome', 40, $Iz01_nomeo, true, 'text', 3, '')
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <br>
            <input type="button" name="btnIncluir" id="btnIncluir" value="Salvar" />
            &nbsp;
            <input type="button" name="btnPesquisar" id="btnPesquisar" value="Pesquisar" />
        </center>
    </form>
</body>

</html>



<script>
    var conta = $("iSistemaConta").value;
    var detalhesistema = $("iDetalhamentoSistema").value;

    /**
     * Função adicionada para incluir o subtipo conforme layout do sicom
     */
    $("btnIncluirSubtipo").observe("click", function() {
        //alert($("c200_subtipo").value);
        js_divCarregando("Cadastrando SubTipo, aguarde...", "msgBox");
        var oParam = new Object();
        oParam.exec = "salvarSubTipo";
        oParam.c200_tipo = $("iTipoLancamento").value;
        oParam.c200_subtipo = $("c200_subtipo").value;
        oParam.c200_descsubtipo = encodeURIComponent(tagString($("c200_descsubtipo").value));

        var oAjax = new Ajax.Request(sUrlRPC, {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: js_retornosalvarSubTipo
        });

    });

    function js_pesquisainatureza(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_orctiporec', 'func_conplanoorcamento.php?funcao_js=parent.js_mostraorctiporec1|c60_codcon|c60_descr&filtro=true', 'Pesquisa', true);
        } else {
            js_OpenJanelaIframe('', 'db_iframe_orctiporec', 'func_conplanoorcamento.php?pesquisa_chave=' + document.form1.c60_naturezadareceita.value + '&funcao_js=parent.js_mostraorctiporec&filtro=true', 'Pesquisa', false);
        }
    }

    function js_mostraorctiporec(chave, erro) {
        document.form1.c60_descr.value = chave;
        if (erro == true) {
            document.form1.c60_naturezadareceita.focus();
            document.form1.c60_naturezadareceita.value = '';
        }
    }

    function js_mostraorctiporec1(chave1, chave2) {
        document.form1.c60_naturezadareceita.value = chave1;
        document.form1.c60_descr.value = chave2;
        db_iframe_orctiporec.hide();
    }

    function js_retornosalvarSubTipo(oAjax) {

        js_removeObj("msgBox");
        var oRetorno = eval("(" + oAjax.responseText + ")");
        alert(oRetorno.message.urlDecode().replace('\\n', ' '));

        if (oRetorno.status == 1) {
            js_getSubtipo();
        }
    }

    function js_verificaEstrutural() {
        let iTipoConta = document.getElementById('iTipoConta').value;

        let iEstrututalpermitido = [
            '111251060', '112519900', '112529900', '112539900', '112549900', '112559900', '121110101', '121110102', '112549950',
            '121110103', '121110104', '121110170', '121110171', '121110401', '121110402', '121110500', '121110601', '121110603',
            '121119901', '121119904', '121119905', '121120100', '121120400', '121120500', '121120601', '121120602', '121120603',
            '121120604', '121120605', '121120698', '121120699', '121130100', '121130400', '121130500', '121130601', '121130602',
            '121130603', '121130604', '121130605', '121130698', '121130699', '121140100', '121140400', '121140500', '121140601',
            '121140602', '121140603', '121140604', '121140605', '121140698', '121140699', '121150100', '121150400', '121150500',
            '121150601', '121150602', '121150603', '121150604', '121150605', '121150698', '121150699', '112510601', '112510602',
            '112510603', '112510604', '112510605', '112510650', '112519901', '112519902', '112519903', '112519904', '112519905',
            '112519950', '112529901', '112529902', '112529903', '112529904', '112529905', '112529950', '112539901', '112539902',
            '112539903', '112539904', '112539905', '112539950', '112549901', '112549902', '112549903', '112549904', '112549905',
            '121120101', '121120102', '121120103', '121120104', '121120105', '121120150', '121120401', '121120402', '121120403',
            '121120404', '121120405', '121120450', '121120501', '121120502', '121120503', '121120504', '121120505', '121120550',
            '121130101', '121130102', '121130103', '121130104', '121130105', '121130150', '121130401', '121130402', '121130403',
            '121130404', '121130405', '121130450', '121130501', '121130502', '121130503', '121130504', '121130505', '121130550',
            '121140101', '121140102', '121140103', '121140104', '121140105', '121140150', '121140401', '121140402', '121140403',
            '121140404', '121140405', '121140450', '121140501', '121140502', '121140503', '121140504', '121140505', '121140550',
            '121150101', '121150102', '121150103', '121150104', '121150105', '121150150', '121150401', '121150402', '121150403',
            '121150404', '121150405', '121150450', '121150501', '121150502', '121150503', '121150504', '121150505', '121150550',
            '121110501', '121110502', '121110503', '121110504', '121110505', '121110550', '112559901', '112559902', '112559903',
            '112559904', '112559905', '112559950'
        ];

        let iEstrutMasc = $('c90_estrutcontabil').value;
        let iEstrutCompl = iEstrutMasc.replace(/[^\d]+/g, '');
        let iEstrutValid = iEstrutCompl.slice(0, 9);

        Array.prototype.contains = function(element) {
            for (var i = 0; i < this.length; i++) {
                if (this[i] == element) {
                    return true;
                }
            }

            return false;
        };

        if (iEstrututalpermitido.contains(iEstrutValid) && iTipoConta == 1) {
            document.getElementById('trnatureza').style.display = "";
        } else {
            document.getElementById('trnatureza').style.display = "none";
            document.getElementById('c60_naturezadareceita').value = '';
        }
    }

    function jsverificatipoconta() {
        let iTipoConta = document.getElementById('iTipoConta').value;

        if (iTipoConta == 1) {
            document.getElementById('trnatureza').style.display = "";
        } else {
            document.getElementById('trnatureza').style.display = "none";
        }
    }

    function js_getSubtipo() {
        var oParam = new Object();
        oParam.exec = 'getSubTipo';
        oParam.c200_tipo = $("iTipoLancamento").value;
        var oAjax = new Ajax.Request(sUrlRPC, {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: js_retornogetSubtipo
        });
    }

    function js_retornogetSubtipo(oAjax) {
        var oRetorno = eval("(" + oAjax.responseText + ")");
        if (oRetorno.status == 2) {
            alert(oRetorno.message.urlDecode().replace('\\n', ' '));
        } else {
            for (var i = $("isubtipo").options.length - 1; i >= 0; i--) {
                $("isubtipo").remove(i);
            }
            var subtipo = document.getElementById("isubtipo");
            var option = document.createElement("option");
            option.text = '';
            option.value = '';
            subtipo.add(option, subtipo[0]);
            for (var i = 0; i < oRetorno.aSubTipos.length; i++) {
                var subtipo = document.getElementById("isubtipo");
                var option = document.createElement("option");
                option.text = oRetorno.aSubTipos[i].c200_descsubtipo;
                option.value = oRetorno.aSubTipos[i].c200_subtipo;
                subtipo.add(option, subtipo[i + 1]);
            }
            var subtipo = document.getElementById("isubtipo");
            var option = document.createElement("option");
            option.text = 'Novo';
            option.value = 'novo';
            subtipo.add(option, subtipo[oRetorno.aSubTipos.length + 1]);

            $("isubtipo").value = $("c200_descsubtipo").value == '' ? '' : $("c200_subtipo").value;
            if ($("isubtipo_hidden").value != '') {
                $("isubtipo").value = $("isubtipo_hidden").value;
                $("isubtipo_hidden").value = '';
            }
            $("c200_subtipo").value = oRetorno.aSubTipos.length == 0 ? 1 : Number(oRetorno.aSubTipos[oRetorno.aSubTipos.length - 1].c200_subtipo) + 1;
            $("c200_descsubtipo").value = '';
            js_novo_subtipo();
        }
    }

    function js_novo_subtipo() {
        if ($("isubtipo").value == 'novo') {
            $("trsubtipoNovo").style.display = '';
        } else {
            $("trsubtipoNovo").style.display = 'none';
        }
    }

    /**
     * Função adicionada para incluir o desdobrasubtipo conforme layout do sicom
     */
    $("btnIncluirDesdobraSubtipo").observe("click", function() {
        js_divCarregando("Cadastrando DesdobraSubTipo, aguarde...", "msgBox");
        var oParam = new Object();
        oParam.exec = "salvarDesdobraSubTipo";
        oParam.c201_tipo = $("iTipoLancamento").value;
        oParam.c201_subtipo = $("isubtipo").value;
        oParam.c201_desdobrasubtipo = $("c201_desdobrasubtipo").value;
        oParam.c201_descdesdobrasubtipo = encodeURIComponent(tagString($("c201_descdesdobrasubtipo").value));

        var oAjax = new Ajax.Request(sUrlRPC, {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: js_retornosalvarDesdobraSubTipo
        });

    });

    function js_retornosalvarDesdobraSubTipo(oAjax) {

        js_removeObj("msgBox");
        var oRetorno = eval("(" + oAjax.responseText + ")");
        alert(oRetorno.message.urlDecode().replace('\\n', ' '));

        if (oRetorno.status == 1) {
            js_getDesdobraSubtipo();
        }
    }

    function js_getDesdobraSubtipo(isubtipo_inicial) {
        var subtipo1 = [0, 1, 2, 3, 4]; // a funcao IN do javascript procura pelo numero da posicao, e nao pelo conteudo, por isso precisa do zero
        var subtipo2 = [0, 1, 2]; // a funcao IN do javascript procura pelo numero da posicao, e nao pelo conteudo, por isso precisa do zero
        var subtipo = isubtipo_inicial > 0 ? isubtipo_inicial : $("isubtipo").value;

        if (($("iTipoLancamento").value == 1 && subtipo in subtipo1) || ($("iTipoLancamento").value == 4 && subtipo in subtipo2) || ($("iTipoLancamento").value == 9999)) {
            var oParam = new Object();
            oParam.exec = 'getDesdobraSubTipo';
            oParam.c201_tipo = $("iTipoLancamento").value;
            oParam.c201_subtipo = subtipo;
            var oAjax = new Ajax.Request(sUrlRPC, {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornogetDesdobraSubtipo
            });
        } else {
            for (var i = $("idesdobramento").options.length - 1; i >= 0; i--) {
                $("idesdobramento").remove(i);
            }
            js_novo_desdobrasubtipo();
        }
    }

    function js_retornogetDesdobraSubtipo(oAjax) {
        var oRetorno = eval("(" + oAjax.responseText + ")");
        if (oRetorno.status == 2) {
            alert(oRetorno.message.urlDecode().replace('\\n', ' '));
        } else {
            for (var i = $("idesdobramento").options.length - 1; i >= 0; i--) {
                $("idesdobramento").remove(i);
            }
            var desdobrasubtipo = document.getElementById("idesdobramento");
            var option = document.createElement("option");
            option.text = '';
            option.value = '';
            desdobrasubtipo.add(option, desdobrasubtipo[0]);
            for (var i = 0; i < oRetorno.aDesdobraSubTipos.length; i++) {
                var desdobrasubtipo = document.getElementById("idesdobramento");
                var option = document.createElement("option");
                option.text = oRetorno.aDesdobraSubTipos[i].c201_descdesdobrasubtipo;
                option.value = oRetorno.aDesdobraSubTipos[i].c201_desdobrasubtipo;
                desdobrasubtipo.add(option, desdobrasubtipo[i + 1]);
            }
            var desdobrasubtipo = document.getElementById("idesdobramento");
            var option = document.createElement("option");
            option.text = 'Novo';
            option.value = 'novo';
            desdobrasubtipo.add(option, desdobrasubtipo[oRetorno.aDesdobraSubTipos.length + 1]);

            $("idesdobramento").value = $("c201_descdesdobrasubtipo").value == '' ? '' : $("c201_desdobrasubtipo").value;
            if ($("idesdobramento_hidden").value != '') {
                $("idesdobramento").value = $("idesdobramento_hidden").value;
                $("idesdobramento_hidden").value = '';
            }
            $("c201_desdobrasubtipo").value = oRetorno.aDesdobraSubTipos.length == 0 ? 1 : Number(oRetorno.aDesdobraSubTipos[oRetorno.aDesdobraSubTipos.length - 1].c201_desdobrasubtipo) + 1;
            $("c201_descdesdobrasubtipo").value = '';
            js_novo_desdobrasubtipo();
        }
    }

    function js_novo_desdobrasubtipo() {
        if ($("idesdobramento").value == 'novo') {
            $("trdesdobramentoNovo").style.display = '';
        } else {
            $("trdesdobramentoNovo").style.display = 'none';
        }
    }

    var sUrlRPC = "con4_conplanoPCASP.RPC.php";

    $("btnPesquisar").observe("click", function() {

        document.getElementById("form1").reset();
        var sUrl = 'func_conplanogeral.php?funcao_js=parent.js_preenchePlano|c60_codcon';
        js_OpenJanelaIframe('top.corpo.iframe_conta', 'db_iframe_conta', sUrl, 'Pesquisa', true, '0');
    });

    function js_preenchePlano(iCodigoConta) {

        db_iframe_conta.hide();
        var oUrl = js_urlToObject(window.location.search);
        if (oUrl.db_opcao == 1) {
            return true;
        }
        js_divCarregando("Aguarde, carregando plano de contas...", "msgBox");
        var oParam = new Object();
        oParam.exec = "getPlanoContasPCASP";
        oParam.iCodigoConta = iCodigoConta;

        var oAjax = new Ajax.Request(sUrlRPC, {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: js_preenchePlanoConta
        });
    }

    function js_preenchePlanoConta(oAjax) {

        js_removeObj("msgBox");
        var oRetorno = eval("(" + oAjax.responseText + ")");
        $("iCodigoConta").value = oRetorno.iCodigoConta;
        document.form1.c90_estrutcontabil.value = oRetorno.sEstrutural;
        var aFields = $('form1').elements;
        for (var iField = 0; iField < aFields.length; iField++) {

            with(aFields[iField]) {

                if (oRetorno.dados[id]) {

                    if (oRetorno.dados[id].urlDecode) {
                        oRetorno.dados[id] = oRetorno.dados[id].urlDecode();
                    }
                    value = oRetorno.dados[id];
                }
            }
        }

        $("c90_estrutcontabil").disabled = true;
        //js_lookupDetalhamentoSistema(false);
        js_lookupSistemaConta(false);
        js_validaFinanceiroBanco();
        $('iTipoConta').value = oRetorno.dados.iTipoConta;
        if (oRetorno.dados.iTipoConta == 1) {
            $('conta-corrente').style.display = "";
            $('infCompMSC').style.display = "";
        }
        $("c60_cgmpessoa").value = oRetorno.dados.iCgmPessoa;
        js_pesquisac60_cgmpessoa(false);

        var lAbaReduzidos = oRetorno.dados.iTipoConta == 0 ? false : true;
        js_liberaAbasPlano(oRetorno.dados.iCodigoConta, lAbaReduzidos, oRetorno.dados.c90_estrutcontabil.split('.').join(''), oRetorno.dados.iCodigoContaCorrente);

        if ($("iSistemaConta").value == '2' && $("iDetalhamentoSistema").value == '7') {
            $("isubtipo_hidden").value = oRetorno.dados["isubtipo"];
            $("idesdobramento_hidden").value = oRetorno.dados["idesdobramento"];
            js_getSubtipo();
            js_getDesdobraSubtipo(oRetorno.dados["isubtipo"]);
        }

        js_habilitacgmpessoa(document.form1.c90_estrutcontabil.value, oRetorno.dados.iTipoConta);

        js_verificaEstrutural();
    }

    /**
     * Atualiza a conta removendo o indicador de superávit
     */
    function removerIndicadorsuperavit() {

        new AjaxRequest(sUrlRPC, {
                exec: "removerIndicadorSuperavit",
                iCodigoConta: $("iCodigoConta").value
            }, function(oResponse, lError) {

                if (lError) {
                    return alert(oResponse.message.urlDecode());
                }
            }).setMessage("Aguarde, alterando o indicador de superávit.")
            .execute();
    }

    /**
     * Valida o indicador de superávit
     * Caso o indicador seja diferente de não se aplica, deve ter algum reduzido cadastrado
     */
    /**
     * Função comentada pois não estava deixando incluir uma conta com puperavit sem reduzido
     */
    /*$('sIndicadorSuperavit').observe('change', function() {

      if ($("iSistemaConta").value == 2 && this.value != 'N') {

        var oGridReduzidos = top.corpo.iframe_reduzido.oGridReduzido;

        if (oGridReduzidos == undefined || oGridReduzidos.getRows().length < 1) {

          this.value = 'N';
          alert('Somente contas analíticas possuem Indicador de Superávit. É necessário cadastrar um reduzido para a conta.');

          if ($("iCodigoConta").value) {
            removerIndicadorsuperavit();
          }
        }
      } else if ($("iCodigoConta").value) {
        removerIndicadorsuperavit();
      }
    });*/


    $("btnIncluir").observe("click", function() {

        var iCodigoConta = $("iCodigoConta").value;
        var iNRegObrig = document.form1.c60_nregobrig.value;
        var sEstrutural = document.form1.c90_estrutcontabil.value;
        var sTitulo = encodeURIComponent(tagString($("sTitulo").value));
        var iNaturezaSaldo = $("iNaturezaSaldo").value;
        var sFuncionamento = encodeURIComponent(tagString($("sFuncionamento").value));
        var iSistemaConta = $("iSistemaConta").value;
        var iDetalhamentoSistema = $("iDetalhamentoSistema").value;
        var sSuperavitFinanceiro = 'N';
        var iClassificacao = 1;
        var iTipoConta = $("iTipoConta").value;
        var iCgmPessoa = document.form1.c60_cgmpessoa.value;
        var iNaturezaReceita = document.form1.c60_naturezadareceita.value;
        var infCompMSC = $("c60_infcompmsc").value;

        if (iSistemaConta == 2 && iDetalhamentoSistema == 7) {
            var iTipoLancamento = $("iTipoLancamento").value;
            var iSubTipo = iTipoLancamento == 0 ? 0 : $("isubtipo").value;
            var iDesdobramento = iTipoLancamento == 0 ? 0 : $("idesdobramento").value;
        } else {
            var iTipoLancamento = 0;
            var iSubTipo = 0;
            var iDesdobramento = 0;
        }

        var sFuncao = encodeURIComponent(tagString($("sFuncao").value));

        /**
         * Validações dos campos
         */
        if (iDetalhamentoSistema == 7) {
            if (iTipoLancamento == "0") {
                alert("Informe o tipo de lançamento.");
                $("iTipoLancamento").style.backgroundColor = '#CDC9C9';
                $("sTitulo").focus();
                return false;
            }
        }

        if (sEstrutural == "") {

            alert("Informe a estrutura contábil do plano de contas.");
            $("c90_estrutcontabil").style.backgroundColor = '#CDC9C9';
            $("sTitulo").focus();
            return false;
        }

        if (sTitulo == "") {

            alert("Informe o título do plano de contas.");
            $("sTitulo").style.backgroundColor = '#CDC9C9';
            $("sTitulo").focus();
            return false;
        }

        if ($("sTitulo").value.length > 50) {

            alert("O Título do plano de contas excede o tamanho máximo de caracteres (50).");
            $("sTitulo").style.backgroundColor = '#CDC9C9';
            $("sTitulo").focus();
            return false;
        }

        if (iSistemaConta == "") {

            alert("Informe o sistema de contas.");
            $("iSistemaConta").style.backgroundColor = '#CDC9C9';
            $("iSistemaConta").focus();
            return false;
        }

        /**
         * retirado validação por que alguns clientes precisam salvar o desdobramento em branco
         * /
         /*if(iTipoLancamento=='1' && (iSubTipo=='1' || iSubTipo=='2' || iSubTipo=='3' || iSubTipo=='4')){
	 if(iDesdobramento==""){
		   alert("Informe o desdobramento.");
		   $("idesdobramento").style.backgroundColor='#CDC9C9';
		   $("idesdobramento").focus();
		   return false;
	   }
  }

         if(iTipoLancamento=='4' && (iSubTipo=='1' || iSubTipo=='2')){
	  if(iDesdobramento==""){
		   alert("Informe o desdobramento.");
		   $("idesdobramento").style.backgroundColor='#CDC9C9';
		   $("idesdobramento").focus();
		   return false;
	   }
  }*/

        let iEstrututalpermitido = [
            '111251060', '112519900', '112529900', '112539900', '112549900', '112559900', '121110101', '121110102', '112549950',
            '121110103', '121110104', '121110170', '121110171', '121110401', '121110402', '121110500', '121110601', '121110603',
            '121119901', '121119904', '121119905', '121120100', '121120400', '121120500', '121120601', '121120602', '121120603',
            '121120604', '121120605', '121120698', '121120699', '121130100', '121130400', '121130500', '121130601', '121130602',
            '121130603', '121130604', '121130605', '121130698', '121130699', '121140100', '121140400', '121140500', '121140601',
            '121140602', '121140603', '121140604', '121140605', '121140698', '121140699', '121150100', '121150400', '121150500',
            '121150601', '121150602', '121150603', '121150604', '121150605', '121150698', '121150699', '112510601', '112510602',
            '112510603', '112510604', '112510605', '112510650', '112519901', '112519902', '112519903', '112519904', '112519905',
            '112519950', '112529901', '112529902', '112529903', '112529904', '112529905', '112529950', '112539901', '112539902',
            '112539903', '112539904', '112539905', '112539950', '112549901', '112549902', '112549903', '112549904', '112549905',
            '121120101', '121120102', '121120103', '121120104', '121120105', '121120150', '121120401', '121120402', '121120403',
            '121120404', '121120405', '121120450', '121120501', '121120502', '121120503', '121120504', '121120505', '121120550',
            '121130101', '121130102', '121130103', '121130104', '121130105', '121130150', '121130401', '121130402', '121130403',
            '121130404', '121130405', '121130450', '121130501', '121130502', '121130503', '121130504', '121130505', '121130550',
            '121140101', '121140102', '121140103', '121140104', '121140105', '121140150', '121140401', '121140402', '121140403',
            '121140404', '121140405', '121140450', '121140501', '121140502', '121140503', '121140504', '121140505', '121140550',
            '121150101', '121150102', '121150103', '121150104', '121150105', '121150150', '121150401', '121150402', '121150403',
            '121150404', '121150405', '121150450', '121150501', '121150502', '121150503', '121150504', '121150505', '121150550',
            '121110501', '121110502', '121110503', '121110504', '121110505', '121110550', '112559901', '112559902', '112559903',
            '112559904', '112559905', '112559950'
        ];

        let iEstrutMasc = $('c90_estrutcontabil').value;
        let iEstrutCompl = iEstrutMasc.replace(/[^\d]+/g, '');
        let iEstrutValid = iEstrutCompl.slice(0, 9);

        Array.prototype.contains = function(element) {
            for (var i = 0; i < this.length; i++) {
                if (this[i] == element) {
                    return true;
                }
            }

            return false;
        };

        if (iTipoConta == 1) {
            if (iNaturezaReceita == '' && iEstrututalpermitido.contains(iEstrutValid)) {
                alert('Natureza da Receita não Informado !');
                return false;
            }

            if (infCompMSC == '') {
                alert('Informação Complementar da MSC não Informado!');
                return false;
            }
        }

        /*
         * Valida se o sistema de contas é "Informações Patrimoniais - 2" caso seja, o indicador
         * de superavit não pode ser "NÃO SE APLICA"
         */
        if (iSistemaConta == 2) {

            if ($("sIndicadorSuperavit").value == "N") {

                alert("Selecione uma opção para cálculo de superavit.");
                return false;
            } else {
                sSuperavitFinanceiro = $("sIndicadorSuperavit").value;
            }
        } else {
            iDetalhamentoSistema = "0";
        }


        if (iDetalhamentoSistema == 6) {

            if ($('iContaBancaria').value == "") {
                alert("Informe uma conta bancária.");
                return false;
            }
        }

        js_divCarregando("Cadastrando plano de contas, aguarde...", "msgBox");
        var oParam = new Object();
        oParam.exec = "salvarPlanoConta";
        oParam.iCodigoConta = iCodigoConta;
        oParam.iNRegObrig = iNRegObrig;
        oParam.sEstrutural = sEstrutural;
        oParam.sTitulo = sTitulo;
        oParam.iNaturezaSaldo = iNaturezaSaldo;
        oParam.sFuncionamento = sFuncionamento;
        oParam.iSistemaConta = iSistemaConta;
        oParam.sIndicadorSuperavit = sSuperavitFinanceiro;
        oParam.iDetalhamentoSistema = iDetalhamentoSistema;
        oParam.iClassificacao = 1;
        oParam.iContaBancaria = $('iContaBancaria').value;
        oParam.iTipoConta = iTipoConta;
        oParam.sFuncao = sFuncao;
        oParam.iTipoLancamento = iTipoLancamento;
        oParam.iSubTipo = iSubTipo;
        oParam.infCompMSC = infCompMSC;

        oParam.iDesdobramento = iDesdobramento;
        oParam.iCgmPessoa = iCgmPessoa;
        oParam.iNaturezaReceita = iNaturezaReceita;

        if (iTipoConta == 1) {
            if ($F('iCodigoContaCorrente') != '') {
                oParam.iContaCorrente = $F('iCodigoContaCorrente');
            } else {
                oParam.iContaCorrente = js_verificaContaEstrutural(sEstrutural);
            }
        }

        var oAjax = new Ajax.Request(sUrlRPC, {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: js_retornoSalvarPlanoConta
        });

    });

    function js_retornoSalvarPlanoConta(oAjax) {

        js_removeObj("msgBox");
        var oRetorno = eval("(" + oAjax.responseText + ")");
        alert(oRetorno.message.urlDecode());

        if (oRetorno.status == 1) {

            $("iCodigoConta").value = oRetorno.iCodigoConta;

            if ($F("iTipoConta") == 1) {

                alert("Aba 'Reduzidos' liberada.");
                parent.mo_camada('reduzido');
                js_liberaAbasPlano(oRetorno.iCodigoConta, true, oRetorno.sEstrutural.split('.').join(''), oRetorno.iContaCorrente);
            }
        }
    }



    function js_validaFinanceiroBanco() {

        var iDetalhamentoSistema = $("iDetalhamentoSistema").value;
        if (iDetalhamentoSistema == 6) {
            $("trdivContaBancaria").style.display = '';

        } else {

            $("trdivContaBancaria").style.display = 'none';
        }
    }

    /**
     * Valida o Subsistema de contas escolhido e mostra a TR do indicador do superavit.
     * Isso só acontecerá caso o sub-sistema de contas escolhidos seja 2.
     */
    function js_validaSistemaConta() {
        var iSistemaConta = $("iSistemaConta").value;
        if (iSistemaConta == 2) {

            $("trIndicadorSuperavit").style.display = '';
            $("trDetalhamentoSistema").style.display = '';

            if (!$("iCodigoConta").value) {
                $('sIndicadorSuperavit').value = 'N';
            }
        } else {

            $('sIndicadorSuperavit').value = 'N';

            $("trIndicadorSuperavit").style.display = 'none';
            $("trDetalhamentoSistema").style.display = 'none';
        }
    }

    /**
     * Funções de Pesquisa da Classificação do Sistema
     */

    /**
     * Funções de Pesquisa do Detalhamento do Sistema de contas
     */
    function js_lookupDetalhamentoSistema(lMostra) {

        if (lMostra == true) {
            var sUrl = 'func_consistema.php?funcao_js=parent.js_mostraDetalhamentoSistema|c52_codsis|c52_descr';
            js_OpenJanelaIframe('top.corpo.iframe_conta', 'db_iframe_consistemaconta', sUrl, 'Pesquisa', true, '0');
        } else {
            if ($("iDetalhamentoSistema").value != '') {
                var sUrl = 'func_consistema.php?pesquisa_chave=' + $("iDetalhamentoSistema").value + '&funcao_js=parent.js_completaDetalhamentoSistema';
                js_OpenJanelaIframe('top.corpo.iframe_conta', 'db_iframe_consistemaconta', sUrl, 'Pesquisa', false);
            } else {
                $("sDescricaoDetalhamentoSistema").value = '';
            }
        }
    }

    function js_mostraDetalhamentoSistema(iCodigo, sDescricao) {

        $("iDetalhamentoSistema").value = iCodigo;
        $("sDescricaoDetalhamentoSistema").value = sDescricao;
        js_validaFinanceiroBanco();
        db_iframe_consistemaconta.hide();

        /* ocultar campos */
        var conta = $("iSistemaConta").value;
        var detalhesistema = $("iDetalhamentoSistema").value;

        if (conta != 2 || detalhesistema != 7) {
            $('iTipoLancamento').value = '';
            $('isubtipo').value = '';
            $('idesdobramento').value = '';
            $("trTipolancamento").style.display = 'none';
        } else {
            $("trTipolancamento").style.display = '';
        }
    }

    function js_completaDetalhamentoSistema(sDescricao, lErro) {

        if (!lErro) {
            $("sDescricaoDetalhamentoSistema").value = sDescricao;
            js_validaFinanceiroBanco();
        } else {
            $("iDetalhamentoSistema").value = '';
            $("sDescricaoDetalhamentoSistema").value = sDescricao;
        }

        /* ocultar campos */
        var conta = $("iSistemaConta").value;
        var detalhesistema = $("iDetalhamentoSistema").value;

        if (conta != 2 || detalhesistema != 7) {
            $('iTipoLancamento').value = '';
            $('isubtipo').value = '';
            $('idesdobramento').value = '';
            $("trTipolancamento").style.display = 'none';
        } else {
            $("trTipolancamento").style.display = '';

        }
    }

    /**
     * Funções de Pesquisa do Sistema de Contas (Sub-Sistema)
     */
    function js_lookupSistemaConta(lMostra) {

        if (lMostra == true) {
            var sUrl = 'func_consistemaconta.php?funcao_js=parent.js_mostraSistemaConta|c65_sequencial|c65_descricao';
            js_OpenJanelaIframe('top.corpo.iframe_conta', 'db_iframe_consistemaconta', sUrl, 'Pesquisa', true, '0');
        } else {
            if ($("iSistemaConta").value != '') {
                var sUrl = 'func_consistemaconta.php?pesquisa_chave=' + $("iSistemaConta").value + '&funcao_js=parent.js_completaSistemaConta';
                js_OpenJanelaIframe('top.corpo.iframe_conta', 'db_iframe_consistemaconta', sUrl, 'Pesquisa', false);
            } else {
                $("sDescricaoSistemaConta").value = '';
            }
        }

        /* ocultar campos */
        var conta = $("iSistemaConta").value;
        var detalhesistema = $("iDetalhamentoSistema").value;

        if (conta != 2 || detalhesistema != 7) {
            $("trTipolancamento").style.display = 'none';
        } else {
            $("trTipolancamento").style.display = '';
        }
    }

    function js_mostraSistemaConta(iCodigo, sDescricao) {

        $("iSistemaConta").value = iCodigo;
        $("sDescricaoSistemaConta").value = sDescricao;
        js_validaSistemaConta();

        if (conta != 2 || detalhesistema != 7) {
            $('iTipoLancamento').value = '';
            $('isubtipo').value = '';
            $('idesdobramento').value = '';
            $("trTipolancamento").style.display = 'none';
        } else {
            $("trTipolancamento").style.display = '';
        }
        db_iframe_consistemaconta.hide();
    }

    function js_completaSistemaConta(sDescricao, lErro) {

        if (!lErro) {

            js_validaSistemaConta();
            $("sDescricaoSistemaConta").value = sDescricao;
        } else {

            $("iSistemaConta").value = '';
            $("sDescricaoSistemaConta").value = sDescricao;
        }
    }

    function js_liberaAbasPlano(iCodigoConta, lAbaReduzidos, sEstrutural = null, iContaCorrente = null) {

        parent.document.formaba.reduzido.disabled = true;
        if (lAbaReduzidos || (sEstrutural != null && iContaCorrente != null)) {

            parent.document.formaba.reduzido.disabled = false;
            parent.iframe_reduzido.location.href = "con1_planocontapcasp004.php?iCodigoConta=" + iCodigoConta + "&sEstrutural=" + sEstrutural + "&iContaCorrente=" + iContaCorrente;

        }

        parent.document.formaba.vinculo.disabled = false;
        parent.iframe_vinculo.location.href = "con1_planocontapcasp005.php?iCodigoConta=" + iCodigoConta;

    }

    js_main = function() {

        new MaskedInput("#c90_estrutcontabil",
            $F('mascara'), {
                placeholder: "0"
            }
        );

        var oUrl = js_urlToObject(window.location.search);

        switch (oUrl.db_opcao) {

            case '3':

                $("btnPesquisar").click();
                $('btnIncluir').value = 'excluir';
                $('btnIncluir').stopObserving('click');
                $('btnIncluir').observe('click', function() {
                    js_removerConta();
                });

                break;

            case '2':
                $("btnPesquisar").click();
                break;
        }
    }


    $('iTipoConta').observe('change', function() {

        $('conta-corrente').style.display = "none";
        $('infCompMSC').style.display = "none";
        if ($F("iTipoConta") == 1) {
            $('conta-corrente').style.display = "";
            $('infCompMSC').style.display = "";
        }
        js_habilitacgmpessoa(document.form1.c90_estrutcontabil.value, $F("iTipoConta"));
    });


    /**
     *  Abre uma WINDOW com para preencher uma conta bancária ou cadastrar uma nova caso não exista
     */
    function js_abreContaBancaria() {

        var iWidth = 650;
        var iHeight = 400;
        oWindowContaBancaria = new windowAux('wndContaBAncaria', 'Infomar conta bancária', iWidth, iHeight);
        var sContent = "<div id='msgContaBancaria' style='text-align:center;'>";
        sContent += "  <div id='divContaBancaria'>";
        sContent += "  </div>";
        sContent += "  <input type='button' id='btnSalvarContaBancaria' name='btnSalvarContaBancaria' value='Salvar'>";
        sContent += "</div>";
        oWindowContaBancaria.setContent(sContent);
        oWindowContaBancaria.setShutDownFunction(function() {
            oWindowContaBancaria.destroy();
        });

        var sMsgHelp = 'Informe os dados abaixo, caso a conta não exista, é necessário acessar as rotinas de cadastro.';
        oMessageBoard = new DBMessageBoard('msgBoard1',
            'Vinculo com Conta Bancária',
            sMsgHelp,
            oWindowContaBancaria.getContentContainer()
        );
        oContaBancaria = new DBViewContaBancaria($F('iContaBancaria'), 'oContaBancaria', false);
        oContaBancaria.setContaPlano(true);
        oContaBancaria.show($('divContaBancaria'));
        if ($F('iContaBancaria') != "") {

            oContaBancaria.getDados($F('iContaBancaria'));
            $('sDescricaoContaBancaria').value = oContaBancaria.getDadosConta();
        }
        oContaBancaria.onAfterSave(function() {

            $('iContaBancaria').value = oContaBancaria.iSequencialContaBancaria;
            $('sDescricaoContaBancaria').value = oContaBancaria.getDadosConta();
            oWindowContaBancaria.destroy();
        });

        oWindowContaBancaria.show();
        $('btnSalvarContaBancaria').observe("click", function() {
            oContaBancaria.salvar();
        });
    }

    /**
     * Função que remove uma conta bancária do sistema
     */
    function js_removerConta() {

        var oParam = new Object();
        oParam.exec = 'removerConta';
        oParam.iCodigoConta = $F('iCodigoConta');
        js_divCarregando('Aguarde. excluindo dados da Conta..', 'msgBox');
        var oAjax = new Ajax.Request(sUrlRPC, {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: js_retornoRemoverConta
        });
    }

    function js_retornoRemoverConta(oAjax) {

        js_removeObj('msgBox');
        var oRetorno = eval("(" + oAjax.responseText + ")");
        if (oRetorno.status == 2) {
            alert(oRetorno.message.urlDecode());
        } else {

            alert('Conta excluida com sucesso!');
            $('form1').reset();
            $("btnPesquisar").click();
        }
    }

    function js_pesquisaContaCorrente(lMostraWindow) {

        if (lMostraWindow) {
            var sUrl = 'func_contacorrente.php?funcao_js=parent.js_preencheContaCorrente|c17_sequencial|c17_descricao';
            js_OpenJanelaIframe('top.corpo.iframe_conta', 'db_iframe_contacorrente', sUrl, 'Pesquisa', true, '0');
        } else {

            if ($("iCodigoContaCorrente").value != '') {
                var sUrl = 'func_contacorrente.php?pesquisa_chave=' + $F("iCodigoContaCorrente");
                sUrl += '&funcao_js=parent.js_completaContaCorrente';
                js_OpenJanelaIframe('top.corpo.iframe_conta', 'db_iframe_contacorente', sUrl, 'Pesquisa', false);
            } else {
                $("sDescricaoRecurso").value = '';
            }
        }
    }

    function js_preencheContaCorrente(iCodigoContaCorrente, sDescricaoContaCorrente) {

        $('iCodigoContaCorrente').value = iCodigoContaCorrente;
        $('sDescricaoContaCorrente').value = sDescricaoContaCorrente;
        db_iframe_contacorrente.hide();
    }

    function js_completaContaCorrente(sDescricaoContaCorrente, lErro) {

        if (!lErro) {
            $('sDescricaoContaCorrente').value = sDescricaoContaCorrente;
        } else {
            $('iCodigoContaCorrente').value = '';
            $('sDescricaoContaCorrente').value = sDescricaoContaCorrente;
        }
    }

    function js_pesquisac60_cgmpessoa(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_cgm_pessoa', 'func_cgm.php?funcao_js=parent.js_mostracgmpessoa1|z01_numcgm|z01_nome', 'Pesquisa', true);
        } else {
            if (document.form1.c60_cgmpessoa.value != '') {
                js_OpenJanelaIframe('', 'db_iframe_cgm_pessoa', 'func_cgm.php?pesquisa_chave=' + document.form1.c60_cgmpessoa.value + '&funcao_js=parent.js_mostracgmpessoa', 'Pesquisa', false);
            } else {
                document.form1.z01_nome.value = '';
            }
        }
    }

    function js_mostracgmpessoa(erro, chave) {
        document.form1.z01_nome.value = chave;
        if (erro == true) {
            document.form1.c60_cgmpessoa.focus();
            document.form1.c60_cgmpessoa.value = '';
        }
    }

    function js_mostracgmpessoa1(chave1, chave2) {
        document.form1.c60_cgmpessoa.value = chave1;
        document.form1.z01_nome.value = chave2;
        db_iframe_cgm_pessoa.hide();
    }

    function js_habilitacgmpessoa(estrutural, iTipoConta) {
        var aEstruturais7 = ['1134101', '1134102', '1134103'];
        var aEstruturais9 = ['121210401', '121210402', '121210403', '121210404', '121210405', '121210406', '121210407', '121210408', '121210409', '121210410', '121210499', '121210501', '121210502', '121210503', '121210504', '121210505', '121210506', '121210507', '121210508', '121210509', '121210510', '121210511', '121210512', '121210513', '121210514', '121210515', '121210599'];
        if ((aEstruturais7.indexOf(estrutural.split('.').join('').substr(0, 7)) != '-1' ||
                aEstruturais9.indexOf(estrutural.split('.').join('').substr(0, 9)) != '-1') && iTipoConta == 1) {
            $("trCgmPessoa").style.display = '';
        } else {
            $("trCgmPessoa").style.display = 'none';
        }
    }

    $('c90_estrutcontabil').observe('change', function() {
        js_habilitacgmpessoa(document.form1.c90_estrutcontabil.value, $F("iTipoConta"));
    });

    /**
     * Função que retorna conta corrente de acordo com o inicial do estrutural
     */

    function js_verificaContaEstrutural(sEstrutural) {

        let aEstC100 = [
            '52111', '521120101', '5211202', '5211203', '5211204', '5211205', '5211206', '5211299', '5212101', '5212102',
            '52129', '6211', '6212', '6213101', '62132', '62133', '62134', '62135', '62136', '62139'
        ];

        let aEstC101 = [
            '5111', '5112', '5221101', '522110201', '522110209', '5221201', '522120201', '522120202', '522120203',
            '522120301', '522120302', '522120303', '5221301', '5221302', '5221303', '5221304', '5221305', '5221306',
            '5221307', '5221309', '5221399', '522190101', '522190109', '522190201', '522190209', '5221904', '5222101',
            '5222102', '522210901', '522210909', '522220101', '522220109', '522220201', '522220209', '522220901',
            '522220909', '5222901', '5222902', '5229101', '5229102', '5229103', '522920101', '522920102', '522920103',
            '522920104', '6111', '6112', '6113', '62211', '6221201', '6221202', '6221299', '6221399', '6222101', '6222102',
            '622210901', '622210909', '622220101', '622220201', '622220901', '622220909', '62229', '62231', '6229101',
            '6229102', '622920101', '622920102', '622920103', '622920104', '7531', '7532', '7533', '7534', '8531', '85321',
            '85322', '85323', '85324', '85331', '85332', '85333', '85334', '85335', '85336', '85337', '85338', '85341',
            '85342', '85343', '85344', '85345'
        ];

        let aEstC102 = [
            '6221301', '6221302', '6221303', '6221304', '6221305', '6221306', '6221307'
        ];

        let aEstC106 = [
            '5311', '5312', '5313', '5316', '5317', '5321', '5322', '5326', '5327', '6311', '6312', '6313', '6314',
            '6315', '6316', '63171', '63172', '63191', '63199', '6321', '6322', '6326', '6327', '63291', '63299'
        ];

        for (var i = 0; i < aEstC100.length; i++) {
            if (sEstrutural.split('.').join('').substr(0, aEstC100[i].length).includes(aEstC100[i])) {
                return 100;
            }
        }

        for (var i = 0; i < aEstC101.length; i++) {
            if (sEstrutural.split('.').join('').substr(0, aEstC101[i].length).includes(aEstC101[i])) {
                return 101;
            }
        }

        for (var i = 0; i < aEstC102.length; i++) {
            if (sEstrutural.split('.').join('').substr(0, aEstC102[i].length).includes(aEstC102[i])) {
                return 102;
            }
        }

        for (var i = 0; i < aEstC106.length; i++) {
            if (sEstrutural.split('.').join('').substr(0, aEstC106[i].length).includes(aEstC106[i])) {
                return 106;
            }
        }

        return 103;
    }

    js_main();
</script>