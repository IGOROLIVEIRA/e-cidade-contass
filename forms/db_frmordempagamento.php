<style>
    .divDadosOp{
        display:flex; 
        justify-content:space-between; 
        margin-bottom: 5
    }
    .fieldsetDadosOp{
        width:500; 
        margin:0 auto
    }
</style>

<form name="form1" method="post">
    <input type="hidden" name="empenho" id="empenho" value="<?= $empenho ?>">
    <table border="0">
        <tr>
            <fieldset class="fieldsetDadosOp">
                <legend>Dados da OP</legend>
                <div class="divDadosOp">
                    <div>
                        <?= @$Le60_codemp ?>
                        <?
                        db_input('e50_data', 50, "", true, 'hidden', 3);
                        db_input('e53_valor', 10, "", true, 'hidden', 3);

                        db_input('e60_codemp', 10, '', true, 'text', 3);
                        db_input('e60_numemp', 10, '', true, 'hidden', 3);
                        ?>
                    </div>
                    <div>
                        <?
                        db_ancora(@$Le50_codord, "pesquisaOrdemPagamento();", $db_opcao);
                        db_input('e50_codord', 10, '', true, 'text', 3);
                        ?>
                    </div>
                </div>
                <div class="divDadosOp">
                    <div>
                        <b>Data da OP:</b>
                        <?
                    db_inputdata("dataLiquidacaoAtual", '', '', '', true, "hidden", 3);
                    db_inputdata("dataLiquidacao", '', '', '', true, "text", 2);
                    ?>
                    </div>
                    <div>

                        <b>Data do estorno da OP:</b>
                        <?
                    db_inputdata("dataEstornoAtual", '', '', '', true, "hidden", 3);
                    db_inputdata("dataEstorno", '', '', '', true, "text", 2);
                    ?>
                    </div>
                </div>
            </fieldset>
        </tr>
        <!-- OC 12746 -->
        <td style="display: none" id="competDespInput"><b>Competência Despesa: </b>
            <? db_inputData('e50_compdesp', '', '', '', true, 'text', 1); ?>
        </td>

        <tr>
            <td nowrap title="<?= @$Te50_obs ?>" colspan="3">
                <fieldset>
                    <legend>
                        <strong>Histórico da OP:</strong>
                    </legend>
                    <? db_textarea('historicoOp', 4, 146, $Ie50_obs, true, 'text', 2) ?>
                </fieldset>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <? include("forms/db_frmliquidaboxreinf.php"); ?>
            </td>
        </tr>
    </table>

    <div style="margin-top: 10px;">

        <input name="alterar" type="submit" id="db_opcao" value="Alterar" onclick="js_alterarRetencao()">

    </div>
</form>
<script type="text/javascript" src="scripts/prototype.js"></script>
<script type="text/javascript" src="scripts/strings.js"></script>
<script>
    function pesquisaOrdemPagamento() {
        empenho = $('empenho').value;
        $('e60_codemp').value = empenho;

        js_pesquisae50_getordem(empenho);
    }

    function js_pesquisae50_getordem(e60_codemp) {
        js_OpenJanelaIframe(
            '',
            'db_iframe_alteracaoop',
            'func_pagordem.php?chave_e60_codemp=' + e60_codemp + '&funcao_js=parent.js_mostraordem|e50_codord|e50_obs|e50_compdesp|elemento|e50_data|e60_numemp|data_anulacao|e53_valor|e50_retencaoir|e50_naturezabemservico',
            'Pesquisa',
            true,
            '0',
            '1'
        );
    }

    // Converter data para o padrão dd/mm/YYYY
    function converterData(dataInformada) {
        let data = new Date(dataInformada.replaceAll("-", "/"));
        return ("0" + data.getDate()).substr(-2) + "/" + ("0" + (data.getMonth() + 1)).substr(-2) + "/" + data.getFullYear();
    }

    function js_mostraordem(e50_codord, e50_obs, e50_compdesp, elemento, e50_data, e60_numemp, data_anulacao, e53_valor, e50_retencaoir, e50_naturezabemservico) {
        $('e60_numemp').value = e60_numemp;
        $('e50_codord').value = e50_codord;
        $('e53_valor').value = e53_valor;
        $('historicoOp').value = e50_obs;
        $('e50_data').value = e50_data;
        $('dataLiquidacao').value = converterData(e50_data);
        $('dataLiquidacaoAtual').value = converterData(e50_data);
        if (data_anulacao !== "") {
            $('dataEstornoAtual').value = converterData(data_anulacao);
            $('dataEstorno').value = converterData(data_anulacao);
            $('dataEstorno').readOnly = false;
            $('dataEstorno').style.backgroundColor = 'white'
            $('dtjs_dataEstorno').type = 'button';
        } else {
            $('dataEstorno').value = "";
            $('dataEstorno').readOnly = true;
            $('dataEstorno').style.backgroundColor = '#DEB887'
            $('dtjs_dataEstorno').type = 'hidden';
        }
        $('reinfRetencao').value = e50_retencaoir == "t" ? 'sim' : 'nao';
        $('naturezaCod').value = e50_naturezabemservico;
        $('naturezaDesc').value = '';
        js_pesquisaNatureza(false);
        js_verificaEstabelecimentosInclusos(e50_codord);
        js_validarRetencaoIR();

        if (e50_compdesp != '') {
            e50_compdesp = converterData(e50_compdesp);
        }

        aMatrizEntrada = ['3319092', '3319192', '3319592', '3319692'];

        if (aMatrizEntrada.indexOf(elemento) !== -1) {
            $('e50_compdesp').value = e50_compdesp;
            document.getElementById('competDespInput').style.display = "table-cell";
        } else {
            document.getElementById('competDespInput').style.display = "none";
        }

        $('reinfRetencao').style.width = "85px";
        $('reinfRetencaoEstabelecimento').style.width = "85px";
        $('fieldsetEstabelecimentos').style = "display: none"
        $('estabelecimentosTableBody').innerHTML = '';
        db_iframe_alteracaoop.hide();
    }
</script>