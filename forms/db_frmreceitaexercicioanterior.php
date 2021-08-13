<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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

//MODULO: contabilidade
$clreceitaexercicioanterior->rotulo->label();
?>
<form name="form1" method="post" action="">
    <center>
        <fieldset>
            <legend><b>Receita do Exercício Anterior</b></legend>
            <table border="0">
                <tr>
                    <td nowrap title="<?= @$Tc234_sequencial ?>">
                        <?= @$Lc234_sequencial ?>
                    </td>
                    <td>
                        <?
                        db_input('c234_sequencial', 10, $Ic234_sequencial, true, 'text', 3, "");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Tc234_orgao ?>">
                        <?= @$Lc234_orgao ?>
                    </td>
                    <td>
                        <?
                        if (($db_opcao == 1 || $db_opcao == 11) || trim(@$instit) == "") {
                            $instit = db_getsession("DB_instit");
                        }
                        $sSQlInstit  = "select codigo             ";
                        $sSQlInstit .= "  from db_config          ";
                        $sSQlInstit .= " where prefeitura is true;";
                        $rsInstit    = $cldb_config->sql_record($sSQlInstit);
                        db_fieldsmemory($rsInstit, 0);
                        if ($codigo == db_getsession("DB_instit")) {
                            $iInstit = null;
                        } else {
                            $iInstit = db_getsession("DB_instit");
                        }
                        $result = $cldb_config->sql_record($cldb_config->sql_query_file($iInstit, "codigo,nomeinst", "codigo"));
                        db_selectrecord("c234_orgao", $result, true, $db_opcao, '', '', '', '', "js_getOrgaos(this.value);");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Tc234_mes ?>">
                        <?= @$Lc234_mes ?>
                    </td>
                    <td>
                        <?
                        $c234_meses = array(
                            1 => 'JANEIRO',
                            'FEVEREIRO',
                            'MARÇO',
                            'ABRIL',
                            'MAIO',
                            'JUNHO',
                            'JULHO',
                            'AGOSTO',
                            'SETEMBRO',
                            'OUTUBRO',
                            'NOVEMBRO',
                            'DEZEMBRO'
                        );
                        db_select("c234_mes", $c234_meses, true, 1, "");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Tc234_ano ?>">
                        <?= @$Lc234_ano ?>
                    </td>
                    <td>
                        <?
                        db_input('c234_ano', 10, $Ic234_ano, true, 'text', $db_opcao, "")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Tc234_receita ?>">
                        <? db_ancora('Natureza da Receita', "js_pesquisaContaOrcamento(true)", 1); ?>
                    </td>
                    <td>
                        <?
                        db_input("c234_receita", 10, null, true, "text", 1, "onchange='js_pesquisaContaOrcamento(false);'");
                        db_input("sDescricaoContaOrcamento", 40, null, true, "text", 3);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Tc234_valorarrecadado ?>">
                        <?= @$Lc234_valorarrecadado ?>
                    </td>
                    <td>
                        <?
                        db_input('c234_valorarrecadado', 10, $Lc234_valorarrecadado, true, 'text', $db_opcao, "onkeyup=\"js_ValidaCampos(this, 4, 'valor', false, null, event)\"");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Tc233_tipoemenda ?>">
                        <?= @$Lc234_tipoemenda ?>
                    </td>
                    <td>
                        <?
                        $c234_tiposemenda = array(3 => '3 - NÃO SE APLICA', 1 => '1 - EMENDA INDIVIDUAL', 2 => '2 - EMENDA DE BANCADA', 4 => '4 - NÃO IMPOSITIVA');
                        db_select('c234_tipoemenda', $c234_tiposemenda, true, 1, "");
                        ?>
                    </td>
                </tr>
            </table>
        </fieldset>
    </center>
    <input name="db_opcao" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
</form>
<script>
    //--------------------------------
    function js_pesquisaContaOrcamento(lMostraWindow) {

        if (lMostraWindow) {
            var sUrl = 'func_conplanoorcamento.php?funcao_js=parent.js_preencheContaOrcamento|c60_estrut|c60_descr&sEstrutural=4';
            js_OpenJanelaIframe('top.corpo', 'db_iframe_conta_orcamento', sUrl, 'Pesquisa', true, '0');
        } else {
            if ($("c234_receita").value != '') {
                var sUrl = 'func_conplanoorcamento.php?sEstrutural=' + $("c234_receita").value + '&funcao_js=parent.js_completaContaOrcamento';
                js_OpenJanelaIframe('top.corpo', 'db_iframe_conta_orcamento', sUrl, 'Pesquisa', false);
            } else {
                $("sDescricaoContaOrcamento").value = '';
            }
        }
    }

    function js_preencheContaOrcamento(iCodigoContaOrcamento, sDescricaoContaOrcamento) {
        $('c234_receita').value = iCodigoContaOrcamento;
        $('sDescricaoContaOrcamento').value = sDescricaoContaOrcamento;
        db_iframe_conta_orcamento.hide();
    }

    function js_completaContaOrcamento(sDescricaoContaOrcamento, lErro) {
        if (!lErro) {
            $('sDescricaoContaOrcamento').value = sDescricaoContaOrcamento;
        } else {
            $('c234_receita').value = '';
            $('sDescricaoContaOrcamento').value = sDescricaoContaOrcamento;
        }
    }

    function js_getOrgaos(iInstit) {

        strJson = '{"method":"getOrgaos","iInstit":"' + iInstit + '"}';
        sUrl = 'con4_db_departRPC.php';
        oAjax = new Ajax.Request(
            sUrl, {
                method: 'post',
                parameters: 'json=' + strJson,
                onComplete: js_retornoOrgaos
            }
        );
    }

    function js_retornoOrgaos(oAjax) {

        oOrgaos = eval("(" + oAjax.responseText + ")");
        $('o40_orgao').options.length = 0;
        $('o40_orgaodescr').options.length = 0;
        $('o41_unidade').options.length = 0;
        $('o41_unidadedescr').options.length = 0;
        if (oOrgaos.length > 0) {

            $('o41_unidadedescr').disabled = false;
            $('o41_unidade').disabled = false;
            js_getUnidades(oOrgaos[0].o40_orgao);
            for (iInd = 0; iInd < oOrgaos.length; iInd++) {

                oOptionId = new Option(oOrgaos[iInd].o40_orgao, oOrgaos[iInd].o40_orgao);
                $('o40_orgao').add(oOptionId, null);
                oOptionDescr = new Option(js_urldecode(oOrgaos[iInd].o40_descr), oOrgaos[iInd].o40_orgao);
                $('o40_orgaodescr').add(oOptionDescr, null);
            }
        }
    }

    function js_pesquisa() {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_receitaexercicioanterior', 'func_receitaexercicioanterior.php?funcao_js=parent.js_preenchepesquisa|c234_sequencial', 'Pesquisa', true);
    }

    function js_preenchepesquisa(chave) {
        db_iframe_receitaexercicioanterior.hide();
        <?
        if ($db_opcao != 1) {
            echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
        }
        ?>
    }
</script>
