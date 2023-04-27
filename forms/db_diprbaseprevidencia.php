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
//MODULO: contabilidade
$cldipr->rotulo->label();
?>
<form name="form1" method="post" action="" onsubmit="return validarCampos()">
    <center>
        <br />
        <fieldset style="width: 100%;">
            <legend><b>Contribuições Previdenciárias Repassadas</b></legend>
            <table border="0" width="100%;">
                <tr>
                    <td>
                        <b>Sequencial</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c238_sequencial', 14, '', true, 'text', 3, "");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b><? db_ancora("Código DIPR", "js_pesquisac237_codigodipr(true);", $db_opcao); ?></b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c238_coddipr', 14, '', true, 'text', 3, "");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>Ente:</b></td>
                    <td>
                        <?php
                        db_select('c238_tipoente', array(0 => "Selecione", '1' => 'Administração Direta Executivo', '2' => 'Administração Direta Legislativo', '3' => 'Unidade Gestora', '4' => 'Autarquia'), true, 1);
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Data referência para o Sicom:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_inputdata("c238_datasicom", @$c238_datasicom_dia, @$c238_datasicom_mes, @$c238_datasicom_ano, true, "text", 1);
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>Mês de competência:</b></td>
                    <td>
                        <?php
                        $meses = array(
                            0 => "Selecione",
                            1 => "Janeiro",
                            2 => "Fevereiro",
                            3 => "Março",
                            4 => "Abril",
                            5 => "Maio",
                            6 => "Junho",
                            7 => "Julho",
                            8 => "Agosto",
                            9 => "Setembro",
                            10 => "Outubro",
                            11 => "Novembro",
                            12 => "Dezembro"
                        );
                        db_select('c238_mescompetencia', $meses, true, 1, "");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Exercício de competência:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input("c238_exerciciocompetencia", 14, "0", true, "text", $db_opcao, "onkeyup=\"js_ValidaCampos(this, 4, 'valor', false, null, event)\"", "", "", "", 4);
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>Tipo de fundo:</b></td>
                    <td>
                        <?php
                        if(db_getsession("DB_anousu") < 2023){
                            $arrayTipoFundo = array(
                                0 => "Selecione",
                                1 => "Fundo em Capitalização (Plano Previdenciário)",
                                2 => "Fundo em Repartição (Plano Financeiro)",                 
                                3 => "Responsabilidade do tesouro municipal"
                            );

                        }else{
                            $arrayTipoFundo = array(
                                0 => "Selecione",
                                1 => "Fundo em Capitalização (Plano Previdenciário)",
                                2 => "Fundo em Repartição (Plano Financeiro)"
                            );

                        }  
                        db_select('c238_tipofundo', $arrayTipoFundo, true, 1, "");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>Tipo de repasse:</b></td>
                    <td>
                        <?php
                        $arrayTipoRepasse = array(
                            0 => "Selecione",
                            1 => "Patronal",
                            2 => "Segurado"
                        );
                        db_select('c238_tiporepasse', $arrayTipoRepasse, true, 1, "onchange='verificarTipoRepasse()'");
                        ?>
                    </td>
                </tr>

                <tr id="LinhaContribuicaoPatronal">
                    <td><b>Tipo de contribuição patronal:</b></td>
                    <td>
                        <?php
                        $arrayTipoRepasse = array(
                            0 => "Selecione",
                            1 => "Servidores",
                            2 => "Servidores afastados com benefícios pagos pela Unidade Gestora (auxílio-doença, salário maternidade e outros)",
                            3 => "Aposentados",
                            4 => "Pensionistas"
                        );
                        db_select('c238_tipocontribuicaopatronal', $arrayTipoRepasse, true, 1, "");
                        ?>
                    </td>
                </tr>

                <tr id="LinhaContribuicaoSegurados">
                    <td><b>Tipo de contribuição segurados:</b></td>
                    <td>
                        <?php
                        $arrayTipoContribuicaoSegurados = array(
                            0 => "Selecione",
                            1 => "Servidores",
                            2 => "Aposentados",
                            3 => "Pensionistas"
                        );
                        db_select('c238_tipocontribuicaosegurados', $arrayTipoContribuicaoSegurados, true, 1, "");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>Tipo de contribuição:</b></td>
                    <td>
                        <?php
                        $arrayTipoContribuicao = array(
                            0 => "Selecione",
                            1 => "Ordinária",
                            2 => "Extraordinária"
                        );
                        db_select('c238_tipocontribuicao', $arrayTipoContribuicao, true, 1, "");
                        ?>
                    </td>
                </tr>


                <tr>
                    <td>
                        <b>Data do repasse:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_inputdata("c238_datarepasse", @$c238_datarepasse_dia, @$c238_datarepasse_mes, @$c238_datarepasse_ano, true, "text", 1);
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Data do vencimento do repasse:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_inputdata("c238_datavencimentorepasse", @$c238_datavencimentorepasse_dia, @$c238_datavencimentorepasse_mes, @$c238_datavencimentorepasse_ano, true, "text", 1);
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Valor original:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c238_valororiginal', 14, null, null, true, "text", "onkeyup=\"js_ValidaCampos(this, 4, 'valor', false, null, event)\"");
                        ?>
                    </td>
                </tr>
                <tr id="LinhaValorJuros">
                    <td>
                        <b>Valor dos juros:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c238_valorjuros', 14, null, null, true, "text", "onkeyup=\"js_ValidaCampos(this, 4, 'valor', false, null, event)\"","","","",14);
                        ?>
                    </td>
                </tr>
                <tr id="LinhaValorMulta">
                    <td>
                        <b>Valor da multa:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c238_valormulta', 14, null, null, true, "text", "onkeyup=\"js_ValidaCampos(this, 4, 'valor', false, null, event)\"","","","",14);
                        ?>
                    </td>
                </tr>
                <tr id="LinhaValorAtuMone">
                    <td>
                        <b>Valor da atualização monetária:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c238_valoratualizacaomonetaria', 14, null, null, true, "text", "onkeyup=\"js_ValidaCampos(this, 4, 'valor', false, null, event)\"","","","",14);
                        ?>
                    </td>
                </tr>
                <tr id="LinhaValorTotDedu">
                    <td>
                        <b>Valor total das deduções:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c238_valortotaldeducoes', 14, null, null, true, "text", "onkeyup=\"js_ValidaCampos(this, 4, 'valor', false, null, event)\"","","","",14);
                        ?>
                    </td>
                </tr>
               
                <tr>
                    <td><b>
                    <?= db_getsession("DB_anousu") < 2023 ? "Valor original repassado menos as deduções:" : "Valor repassado:"?>
                    </b></td>
                    <td nowrap>
                        <?
                        db_input('c238_valororiginalrepassado', 14, null, null, true, "text", "onkeyup=\"js_ValidaCampos(this, 4, 'valor', false, null, event)\"");
                        ?>
                    </td>
                </tr>

            </table>
        </fieldset>
        <br>
        <input name="db_opcao" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
        &nbsp;
        <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
    </center>
</form>

<script>
    verificarTipoRepasse();                 
    function js_pesquisac237_codigodipr($lmostra) {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_dipr', 'func_dipr.php?funcao_js=parent.js_preenchecoddipr|c236_coddipr|c236_massainstituida', 'Pesquisa', true);
    }

    function js_preenchecoddipr(chave, massa) {
        db_iframe_dipr.hide();
        document.form1.c238_coddipr.value = chave;
        document.form1.c238_tipofundo.value = 0;
        if (massa == 'f')
            document.form1.c238_tipofundo.value = 1;  
    }

    function js_pesquisa() {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_dipr', 'func_diprbaseprevidencia.php?funcao_js=parent.js_preenchepesquisa|c238_sequencial', 'Pesquisa', true);
    }

    function js_preenchepesquisa(chave) {
        db_iframe_dipr.hide();
        <?
        if ($db_opcao != 1)
            echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave; ";
        ?>
    }

    function verificarTipoRepasse()
    {
        if (document.form1.c238_tiporepasse.value === "1") {
            condicoesPatronal();
            return;
        }
        if (document.form1.c238_tiporepasse.value === "2") {
            condicoesSegurados();
            return;
        }
        ocultarLinha('LinhaContribuicaoPatronal');
        ocultarLinha('LinhaContribuicaoSegurados');
        return;
    }

    function condicoesPatronal() {
        mostrarLinha('LinhaContribuicaoPatronal');
        ocultarLinha('LinhaContribuicaoSegurados');
        return;
    }
    
    function condicoesSegurados() {
        ocultarLinha('LinhaContribuicaoPatronal');
        mostrarLinha('LinhaContribuicaoSegurados');
        return;
    }

    function ocultarLinha(identificador) {
        alterarDisplayDaLinha(identificador, 'none');
        zerarValor(identificador);
    }

    function mostrarLinha(identificador) {
        alterarDisplayDaLinha(identificador, 'table-row');
    }

    function zerarValor(identificador) {
        if (identificador == 'LinhaContribuicaoSegurados') {
            document.getElementById('c238_tipocontribuicaosegurados').value = 0;
            return;
        }
        // document.getElementById('c238_tipocontribuicaopatronal').value = 0;
        return;
    }

    function alterarDisplayDaLinha(identificador, display) {
        document.getElementById(identificador).style.display = display;
    }

    function validarCampos() {
        return true;
    }

    function verificarCampos() {
        var ano = "<?php echo db_getsession("DB_anousu"); ?>";
        if(ano > 2022){
            mostrarLinha('LinhaValorJuros');
            mostrarLinha('LinhaValorMulta');
            mostrarLinha('LinhaValorAtuMone');
            mostrarLinha('LinhaValorTotDedu');
            return;
        }
        ocultarLinha('LinhaValorJuros');
        ocultarLinha('LinhaValorMulta');
        ocultarLinha('LinhaValorAtuMone');
        ocultarLinha('LinhaValorTotDedu');
        return;
    }

    verificarCampos(); 
</script>