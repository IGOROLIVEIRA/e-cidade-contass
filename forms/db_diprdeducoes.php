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
        <fieldset style="width: 100%;">
            <legend><b>Deduções</b></legend>
            <table border="0" width="100%;">
                <tr>
                    <td>
                        <b>Sequencial</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c239_sequencial', 14, '', true, 'text', 3, "");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b><? db_ancora("Código DIRP", "js_pesquisac239_codigodipr(true);", $db_opcao); ?></b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c239_coddipr', 14, '', true, 'text', 3, "");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Data referência SICOM:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_inputdata("c239_datasicom", @$c239_datasicom_dia, @$c239_datasicom_mes, @$c239_datasicom_ano, true, "text", 1);
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
                        db_select('c239_mescompetencia', $meses, true, 1, "style='width:104px'");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Exercício de competência:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input("c239_exerciciocompetencia", 14, "0", true, "text", $db_opcao, "onkeyup=\"js_ValidaCampos(this, 4, 'valor', false, null, event)\"", "", "", "", 4);
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
                        db_select('c239_tipofundo', $arrayTipoFundo, true, 1, "");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>Tipos de Repasse:</b></td>
                    <td>
                        <?php
                        $arrayTipoRepasse = array(
                            0 => "Selecione",
                            1 => "Patronal",
                            2 => "Segurado"
                        );
                        db_select('c239_tiporepasse', $arrayTipoRepasse, true, 1, "style='width:104px'");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>Tipos de contribuição patronal:</b></td>
                    <td>
                        <?php
                        $arrayTipoRepasse = array(
                            0 => "Selecione",
                            1 => "Servidores",
                            2 => "Servidores afastados com benefícios pagos pela Unidade Gestora (auxílio-doença, salário maternidade e outros)",
                            3 => "Aposentados",
                            4 => "Pensionistas"
                        );
                        db_select('c239_tipocontribuicaopatronal', $arrayTipoRepasse, true, 1, "");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>Tipos de contribuição segurados:</b></td>
                    <td>
                        <?php
                        $arrayTipoContribuicaoSegurados = array(
                            0 => "Selecione",
                            1 => "Servidores",
                            2 => "Aposentados",
                            3 => "Pensionistas"
                        );
                        db_select('c239_tipocontribuicaosegurados', $arrayTipoContribuicaoSegurados, true, 1, "style='width:104px'");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>Tipos de contribuição:</b></td>
                    <td>
                        <?php
                        $arrayTipoContribuicao = array(
                            0 => "Selecione",
                            1 => "Normal",
                            2 => "Suplementar"
                        );
                        db_select('c239_tipocontribuicao', $arrayTipoContribuicao, true, 1, "style='width:104px'");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Descrição da dedução:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_textarea('c239_descricao', 3, 101, '', true, "text", $db_opcao, "", "", "", 200);
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>Tipos de Dedução:</b></td>
                    <td>
                        <?php
                        $arrayTipoContribuicao = array(
                            0 => "Selecione",
                            1 => "Pagamento a maior",
                            2 => "Outros valores compensados"
                        );
                        db_select('c239_tipodeducao', $arrayTipoContribuicao, true, 1, "style='width:200px'");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Valor das deduções:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c239_valordeducao', 14, 0, true, 'text', $db_opcao, "onkeyup=\"js_ValidaCampos(this, 4, 'valor', false, null, event)\"", "", "", "", 14);
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
    function js_pesquisac239_codigodipr($lmostra) {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_dipr', 'func_dipr.php?funcao_js=parent.js_preenchecoddipr|c236_coddipr', 'Pesquisa', true);
    }

    function js_preenchecoddipr(chave) {
        db_iframe_dipr.hide();
        document.form1.c239_coddipr.value = chave;
    }

    function js_pesquisa() {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_dipr', 'func_diprdeducoes.php?funcao_js=parent.js_preenchepesquisa|c239_sequencial', 'Pesquisa', true);
    }

    function js_preenchepesquisa(chave) {
        db_iframe_dipr.hide();
        <?
        if ($db_opcao != 1)
            echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave; ";
        ?>
    }
</script>