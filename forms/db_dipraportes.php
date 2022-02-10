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
?>
<form name="form1" method="post" action="">
    <center>
        <br />
        <fieldset style="width: 600;">
            <legend><b>Aportes e transferencias de Recursos</b></legend>
            <table border="0" width="600;">
                <tr>
                    <td>
                        <b>Sequencial</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c240_sequencial', 14, '', true, 'text', 3, "");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b><? db_ancora("Código DIRP", "js_pesquisac240_codigodipr(true);", $db_opcao); ?></b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c240_coddipr', 14, '', true, 'text', 3, "");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Data referência SICOM:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_inputdata("c240_datasicom", @$c240_datasicom_dia, @$c240_datasicom_mes, @$c240_datasicom_ano, true, "text", 1);
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
                        db_select('c240_mescompetencia', $meses, true, 1, "style='width:104px'");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Exercício de competência:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input("c240_exerciciocompetencia", 14, "0", true, "text", $db_opcao, "", "", "", "", 4);
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>Tipo de fundo:</b></td>
                    <td>
                        <?php
                        $arrayTipoFundo = array(
                            0 => "Selecione",
                            1 => "Fundo em Capitalização (Plano Previdenciário)",
                            2 => "Fundo em Repartição (Plano Financeiro)",
                            3 => "Responsabilidade do tesouro municipal"
                        );
                        db_select('c240_tipofundo', $arrayTipoFundo, true, 1, "style='width:260px'");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>Tipos de aportes e transferências de recursos:</b></td>
                    <td>
                        <?php
                        $arrayTipoAporte = array(
                            0 => "Selecione",
                            1 => "Aporte para amortização déficit atuarial",
                            2 => "Transferência para cobertura insuficiência financeiro",
                            3 => "Transferência de recursos para pagamento de despesas administrativas",
                            4 => "Transferência para pagamento de beneficios de responsabilidade do tesouro",
                            5 => "Outros aportes ou transferências"
                        );
                        db_select('c240_tipoaporte', $arrayTipoAporte, true, 1, "style='width:260px'");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Descrição dos outros aportes ou transferências:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_textarea('c240_descricao', 2, 40, '', true, "text", $db_opcao, "", "", "", 200);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Ato normativo:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c240_atonormativo', 14, 0, true, 'text', $db_opcao, "");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Exercício de ato normativo:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c240_exercicioatonormativo', 14, 0, true, 'text', $db_opcao, "");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Valor dos aportes e transferencias de recursos:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c240_valoraporte', 14, 0, true, 'text', $db_opcao, 14);
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
    function js_pesquisac240_codigodipr($lmostra) {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_dipr', 'func_dipr.php?funcao_js=parent.js_preenchecoddipr|c236_coddipr', 'Pesquisa', true);
    }

    function js_preenchecoddipr(chave) {
        db_iframe_dipr.hide();
        document.form1.c240_coddipr.value = chave;
    }

    function js_pesquisa() {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_dipr', 'func_dipraportes.php?funcao_js=parent.js_preenchepesquisa|c240_sequencial', 'Pesquisa', true);
    }

    function js_preenchepesquisa(chave) {
        db_iframe_dipr.hide();
        <?
        if ($db_opcao != 1)
            echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave; ";
        ?>
    }
</script>