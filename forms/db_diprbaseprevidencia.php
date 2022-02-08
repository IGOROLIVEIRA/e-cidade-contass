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
$cldirp->rotulo->label();
?>
<form name="form1" method="post" action="">
    <center>
        <br />
        <fieldset style="width: 400;">
            <legend><b>Contribuições Previdenciárias Repassadas</b></legend>
            <table border="0" width="400;">
                <tr>
                    <td>
                        <b><?db_ancora("Código DIRP", "js_pesquisac237_codigodirp(true);", $db_opcao);?></b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c238_coddirp', 14, '', true, 'text', 3, "");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Data referência SICOM:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_inputdata("c238_datasicom", null, null, null, true, "text", 1);
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
                        db_select('c238_mescompetencia', $meses, true, 1, "style='width:104px'");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Exercício de competência:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c238_exerciciocompetencia', 14, $exercicio, true, 'text', $db_opcao, "");
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
                        db_select('c238_tipofundo', $arrayTipoFundo, true, 1, "style='width:104px'");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>Tipos de repasse:</b></td>
                    <td>
                        <?php
                        $arrayTipoRepasse = array(
                            0 => "Selecione",
                            1 => "Patronal",
                            2 => "Segurado"
                        );
                        db_select('c238_tiporepasse', $arrayTipoRepasse, true, 1, "style='width:104px'");
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
                        db_select('c238_tipocontribuicaopatronal', $arrayTipoRepasse, true, 1, "style='width:104px'");
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
                        db_select('c238_tipocontribuicaosegurados', $arrayTipoContribuicaoSegurados, true, 1, "style='width:104px'");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>Tipos de contribuição:</b></td>
                    <td>
                        <?php
                        $arrayTipoContribuicao = array(
                            0 => "Selecione",
                            1 => "Servidores",
                            2 => "Aposentados",
                            3 => "Pensionistas"
                        );
                        db_select('c238_tipocontribuicao', $arrayTipoContribuicao, true, 1, "style='width:104px'");
                        ?>
                    </td>
                </tr>


                <tr>
                    <td>
                        <b>Data do repasse:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_inputdata("c238_datarepasse", null, null, null, true, "text", 1);
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Data do vencimento do repasse:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_inputdata("c238_datavencimentorepasse", null, null, null, true, "text", 1);
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Valor original:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c238_valororiginal', 14, 0, true, 'text', $db_opcao, 14);
                        ?>
                    </td>
                </tr>


                <tr>
                    <td>
                        <b>Valor original repassado menos as deduções:</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c238_valororiginalrepassado', 14, 0, true, 'text', $db_opcao, 14);
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
    function js_pesquisac237_codigodirp($lmostra) {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_dirp', 'func_dirp.php?funcao_js=parent.js_preenchepesquisa|c236_coddirp', 'Pesquisa', true);
    }

    function js_preenchepesquisa(chave) {
        db_iframe_dirp.hide();
        document.form1.c238_coddirp.value = chave;
    }
</script>