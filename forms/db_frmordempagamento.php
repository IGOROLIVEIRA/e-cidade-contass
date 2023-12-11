<form name="form1" method="post">
    <input type="hidden" name="empenho" id="empenho" value="<?= $empenho ?>">
    <table border="0">
        <tr>
            <td>
                <fieldset class="fieldsetDadosOp">
                    <legend>Dados da OP</legend>
                    <table>              
                        <tr>
                            <td>
                                <?= @$Le60_codemp ?>
                            </td>
                            <td>
                                <?
                                db_input('e50_data', 50, "", true, 'hidden', 3);
                                // db_input('e53_valor', 10, "", true, 'hidden', 3);

                                db_input('e60_codemp', 10, '', true, 'text', 3);
                                db_input('e60_numemp', 10, '', true, 'hidden', 3);
                                ?>
                            </td>
                            <td>
                                <?db_ancora(@$Le50_codord, "pesquisaOrdemPagamento();", $db_opcao);?>
                            </td>
                            <td>
                                <?db_input('e50_codord', 10, '', true, 'text', 3);?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Data da OP:</b>
                            </td>
                            <td>
                                <?
                                db_inputdata("dataLiquidacaoAtual", '', '', '', true, "hidden", 3);
                                db_inputdata("dataLiquidacao", '', '', '', true, "text", 2);
                                ?>
                            </td>
                            <td>
                                <b>Data do estorno da OP:</b>
                            </td>
                            <td>
                                <?
                                db_inputdata("dataEstornoAtual", '', '', '', true, "hidden", 3);
                                db_inputdata("dataEstorno", '', '', '', true, "text", 2);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Valor Total:</b>
                            </td>
                            <td>
                                <?db_input('e53_valor', 10, "", true, 'text', 3);?>
                            </td>
                            <td>
                                <b>Valor Pago:</b>
                            </td>
                            <td>
                                <?db_input('e53_vlranu', 10, "", true, 'text', 3);?>
                            </td>
                            <td>
                                <b>Valor Anulado:</b>
                            </td>
                            <td>
                                <?db_input('e53_vlrpag', 10, "", true, 'text', 3);?>
                            </td>
                        </tr>
                        <!-- OC 12746 -->
                        <tr style="display: none" id="competDespInput">
                            <td>
                                <b>Competência Despesa: </b>
                            </td>
                            <td>
                                <? db_inputData('e50_compdesp', '', '', '', true, 'text', 1); ?>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </td>
        </tr>

        <tr>
            <td nowrap title="<?= @$Te50_obs ?>" colspan="3">
                <fieldset>
                    <legend>
                        <strong>Histórico da OP:</strong>
                    </legend>
                    <? db_textarea('historicoOp', 4, 130, $Ie50_obs, true, 'text', 2) ?>
                </fieldset>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <? include("forms/db_frmliquidaboxreinf.php"); ?>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <?
                db_input('e140_sequencial', 50, "", true, 'hidden', 3);
                db_input('desdobramentoDiaria', 50, "", true, 'hidden', 3);
                db_input('salvarDiaria', 50, "", true, 'hidden', 3);
                include("forms/db_frmliquidaboxdiarias.php"); 
                ?>
            </td>
        </tr>
    </table>

    <div style="margin-top: 10px;">

        <input name="alterar" type="submit" id="db_opcao" value="Alterar" onclick="js_alterarRetencao()">
        <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar OP" onclick="pesquisaOrdemPagamento()">

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
            'func_pagordem.php?chave_e60_codemp=' + e60_codemp + '&funcao_js=parent.js_mostraordem|e50_codord|e50_obs|e50_compdesp|elemento|e50_data|e60_numemp|data_anulacao|e53_valor|e50_retencaoir|e50_naturezabemservico|e53_vlranu|e53_vlrpag',
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

    function js_mostraordem(e50_codord, e50_obs, e50_compdesp, elemento, e50_data, e60_numemp, data_anulacao, e53_valor, e50_retencaoir, e50_naturezabemservico, e53_vlranu, e53_vlrpag) {        
        
        $('e60_numemp').value = e60_numemp;
        $('e50_codord').value = e50_codord;
        $('e53_valor').value = e53_valor;
        
        $('e53_vlranu').value = e53_vlranu;
        $('e53_vlrpag').value = e53_vlrpag;
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
        js_pesquisaDiaria(e50_codord,e60_numemp);

        if (e50_compdesp != '') {
            e50_compdesp = converterData(e50_compdesp);
        }

        aMatrizEntrada = ['3319092', '3319192', '3319592', '3319692'];

        if (aMatrizEntrada.indexOf(elemento) !== -1) {
            $('e50_compdesp').value = e50_compdesp;
            document.getElementById('competDespInput').style.display = "table-row";
        } else {
            document.getElementById('competDespInput').style.display = "none";
        }

        $('reinfRetencao').style.width = "85px";
        $('reinfRetencaoEstabelecimento').style.width = "85px";
        $('fieldsetEstabelecimentos').style = "display: none"
        $('estabelecimentosTableBody').innerHTML = '';
        db_iframe_alteracaoop.hide();
    }

    $('e140_dtautorizacao').size = 8;
    $('e140_dtinicial').size = 8;
    $('e140_dtfinal').size = 8;

    $('e140_vrldiariauni').style.marginLeft = '52px';
    $('e140_vrlhospedagemuni').style.marginLeft = '10px';
    $('e140_vlrtransport').style.marginLeft = '2px';
    $('diariaVlrTotal').style.marginLeft = '50px';
    $('hospedagemVlrTotal').style.marginLeft = '12px';
    $('diariaVlrDespesa').style.marginLeft = '48px';

    $('diariaViajante').disabled = true;
    $('diariaVlrTotal').disabled = true;
    $('hospedagemVlrTotal').disabled = true;
    $('diariaPernoiteVlrTotal').disabled = true;

    $('e140_horainicial').addEventListener('blur', function () {js_validaHora('e140_horainicial')});
    $('e140_horafinal').addEventListener('blur', function () {js_validaHora('e140_horafinal')});

    document.addEventListener("DOMContentLoaded", function() {
        var elementosNoSelect = document.querySelectorAll('input:disabled');
        elementosNoSelect.forEach(function (elemento) {
            elemento.style.color = 'black'
        });
    });

</script>