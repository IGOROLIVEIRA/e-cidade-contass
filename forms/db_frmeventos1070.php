<?
//MODULO: esocial
$cleventos1070->rotulo->label();
?>
<style>
    #eso09_obsproc {
        width: 50%;
    }

    #eso09_indmateriaproc {
        width: 40%;
    }
</style>
<form name="form1" method="post" action="">
    <fieldset id="fieldset1" style="margin-top: 30px">
        <legend>Identificação do processo e período de validade das informações (ideProcesso)</legend>
        <table border="0">
            <tr style="display: none">
                <td nowrap title="<?= @$Teso09_sequencial ?>">
                    <strong>Sequencial:</strong>
                </td>
                <td>
                    <?
                    db_input('eso09_sequencial', 19, $Ieso09_sequencial, true, 'text', 3, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso09_tipoprocesso ?>">
                    <strong>Preencher com o código correspondente ao tipo de processo:</strong>
                </td>
                <td>
                    <?
                    $x = array("0" => "Selecione", "1" => "Administrativo", "2" => "Judicial", "4" => "Processo FAP de exercício anterior a 2019");
                    db_select('eso09_tipoprocesso', $x, true, $db_opcao, "");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso09_nroprocessoadm ?>">
                    <strong>Informar o número do processo administrativo/judicial de acordo com o tipo informado em tpProc (nrProc):</strong>
                </td>
                <td>
                    <?
                    db_input('eso09_nroprocessoadm', 21, $Ieso09_nroprocessoadm, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset id="fieldset1">
        <legend>Dados do processo (dadosProc)</legend>
        <table>
            <tr>
                <td nowrap title="<?= @$Teso09_indautoria ?>">
                    <strong>Indicativo da autoria da ação judicial:</strong>
                </td>
                <td>
                    <?
                    $x = array("0" => "Selecione", "1" => "Próprio contribuinte", "2" => "Outra entidade, empresa ou empregado");
                    db_select('eso09_indautoria', $x, true, $db_opcao, "");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso09_indmateriaproc ?>">
                    <strong>Indicativo da matéria do processo:</strong>
                </td>
                <td>
                    <?
                    $x = array("0" => "Selecione", "1" => "Exclusivamente tributária ou tributária e FGTS", "7" => "Exclusivamente FGTS e/ou Contribuição Social Rescisória Exclusivamente FGTS e/ou Contribuição Social Rescisória (Lei Complementar 110/2001)");
                    db_select('eso09_indmateriaproc', $x, true, $db_opcao, "");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso09_obsproc ?>">
                    <strong>Observações relacionadas ao processo:</strong>
                </td>
                <td>
                    <?
                    db_input('eso09_obsproc', 255, $Ieso09_obsproc, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset id="fieldset1">
        <legend>Informações complementares do processo judicial (dadosProcJud)</legend>
        <table>
            <tr>
                <td nowrap title="<?= @$Teso09_indundfederacao ?>">
                    <strong>Identificação da Unidade da Federação - UF da Seção Judiciária:</strong>
                </td>
                <td>
                    <?
                    $x = array(
                        "0" => "Selecione",
                        "AC" => "AC",
                        "AL" => "AL",
                        "AP" => "AP",
                        "AM" => "AM",
                        "BA" => "BA",
                        "CE" => "CE",
                        "DF" => "DF",
                        "ES" => "ES",
                        "GO" => "GO",
                        "MA" => "MA",
                        "MT" => "MT",
                        "MS" => "MS",
                        "MG" => "MG",
                        "PA" => "PA",
                        "PB" => "PB",
                        "PR" => "PR",
                        "PE" => "PE",
                        "PI" => "PI",
                        "RJ" => "RJ",
                        "RN" => "RN",
                        "RS" => "RS",
                        "RO" => "RO",
                        "RR" => "RR",
                        "SC" => "SC",
                        "SP" => "SP",
                        "SE" => "SE",
                        "TO" => "TO"
                    );
                    db_select('eso09_indundfederacao', $x, true, $db_opcao, "");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso09_codmuniIBGE ?>">
                    <strong>Preencher com o código do município, conforme tabela do IBGE:</strong>
                </td>
                <td>
                    <?
                    db_input('eso09_codmuniibge', 7, $Ieso09_codmuniIBGE, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso09_idvara ?>">
                    <strong>Código de identificação da Vara:</strong>
                </td>
                <td>
                    <?
                    db_input('eso09_idvara', 4, $Ieso09_idvara, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso09_codsusp ?>">
                    <strong>Código do indicativo da suspensão, atribuído pelo empregador:</strong>
                </td>
                <td>
                    <?
                    db_input('eso09_codsusp', 14, $Ieso09_codsusp, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso09_codsuspexigi ?>">
                    <strong>Indicativo de suspensão da exigibilidade:</strong>
                </td>
                <td>
                    <?
                    $x = array(
                        "0" => "Selecione",
                        "01" => "Liminar em mandado de segurança", "02" => "Depósito judicial do montante integral", "03" => "Depósito administrativo do montante integral", "04" => "Antecipação de tutela", "05" => "Liminar em medida cautelar", "08" => "Sentença em mandado de segurança favorável ao contribuinte", "09" => "Sentença em ação ordinária favorável ao contribuinte e confirmada pelo TRF", "10" => "Acórdão do TRF favorável ao contribuinte", "11" => "Acórdão do STJ em recurso especial favorável ao contribuinte", "12" => "Acórdão do STF em recurso extraordinário favorável ao contribuinte", "13" => "Sentença 1ª instância não transitada em julgado com efeito suspensivo", "14" => "Contestação administrativa FAP", "90" => "Decisão definitiva a favor do contribuinte", "92" => "Sem suspensão da exigibilidade"
                    );
                    db_select('eso09_codsuspexigi', $x, true, $db_opcao, "");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso09_dtdecisao ?>">
                    <strong>Data da decisão, sentença ou despacho administrativo:</strong>
                </td>
                <td>
                    <?
                    db_inputdata('eso09_dtdecisao', @$eso09_dtdecisao_dia, @$eso09_dtdecisao_mes, @$eso09_dtdecisao_ano, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso09_inddeposito ?>">
                    <strong>Indicativo de depósito do montante integral:</strong>
                </td>
                <td>
                    <?
                    $x = array("N" => "NAO", "S" => "SIM");
                    db_select('eso09_inddeposito', $x, true, $db_opcao, "");
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <div style="margin-left: 40%; margin-top: 10px">
        <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
        <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
    </div>
</form>
<script>
    function js_pesquisa() {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_eventos1070', 'func_eventos1070.php?funcao_js=parent.js_preenchepesquisa|0', 'Pesquisa', true);
    }

    function js_preenchepesquisa(chave) {
        db_iframe_eventos1070.hide();
        <?
        if ($db_opcao != 1) {
            echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
        }
        ?>
    }
</script>
