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
$cldipr->rotulo->label();
?>
<form name="form1" method="post" action="">
    <center>
        <br />
        <fieldset style="width: 850px;">
            <legend><b>Informações Previdenciárias - DIPR</b></legend>
            <table border="0" width="850px;">
                <tr>
                    <td>
                        <b>Sequencial</b>
                    </td>
                    <td nowrap>
                        <?
                        db_input('c236_coddipr', 14, '', true, 'text', 3, "");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>O ente possui segregação da massa instituída por lei?:</b></td>
                    <td>
                        <?php
                        $aSegregacaoLei = array(0 => "Selecione", 't' => "Sim", 'f' => "Não");
                        db_select('c236_massainstituida', $aSegregacaoLei, true, 1, "style='width:120px'");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><b>O município possui beneficiários custeados com recursos do tesouro?:</b></td>
                    <td>
                        <?php
                        $aBeneficiarioTesouro = array(0 => "Selecione", 't' => "Sim", 'f' => "Não");
                        db_select('c236_beneficiotesouro', $aBeneficiarioTesouro, true, 1, "style='width:120px'");
                        ?>
                    </td>
                </tr>

                <tr id="LinhaNumeroAtoNormativo">
                    <td><b>Número do ato normativo:</b></td>
                    <td>
                        <?php
                        db_input("c236_atonormativo", 14, "0", true, "text", $db_opcao, "", "", "", "", 6);
                        ?>
                    </td>
                </tr>

                <tr id="LinhaExercicioAtoNormativo">
                    <td><b>Exercício do ato normativo:</b></td>
                    <td>
                        <?php
                        db_input("c236_exercicionormativo", 14, "0", true, "text", $db_opcao, "", "", "", "", 4);
                        ?>
                    </td>
                </tr>

                <tr>
                    <td nowrap>
                        <?
                        db_ancora("Administração Direta Executivo", "js_pesquisac236_numcgm(true, 'executivo');", $db_opcao);
                        ?>
                    </td>
                    <td>
                        <?
                        db_input('c236_numcgmexecutivo', 14, $Ic236_numcgmexecutico, true, 'text', $db_opcao, " onchange=js_pesquisac236_numcgm(false,'executivo');");
                        if ($c236_numcgmexecutivo) {
                            $resultado = db_query("select z01_nome as z01_nomeexecutivo from cgm where z01_numcgm = {$c236_numcgmexecutivo}");
                            db_fieldsmemory($resultado, 0)->z01_nomeexecutivo;
                        }
                        db_input('z01_nomeexecutivo', 40, "Teste de Valor", true, 'text', 3, '', "z01_nomeexecutivo");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td nowrap>
                        <?
                        db_ancora("Administração Direta Legislativo", "js_pesquisac236_numcgm(true, 'legislativo');", $db_opcao);
                        ?>
                    </td>
                    <td>
                        <?
                        db_input('c236_numcgmlegislativo', 14, $Ic236_numcgmlegislativo, true, 'text', $db_opcao, " onchange=js_pesquisac236_numcgm(false,'legislativo');");
                        if ($c236_numcgmlegislativo) {
                            $resultado = db_query("select z01_nome as z01_nomelegislativo from cgm where z01_numcgm = {$c236_numcgmlegislativo}");
                            db_fieldsmemory($resultado, 0)->z01_nomelegislativo;
                        }
                        db_input('z01_nomelegislativo', 40, $Iz01_nome, true, 'text', 3, '', "z01_nomelegislativo");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td nowrap>
                        <?
                        db_ancora("Unidade Gestora", "js_pesquisac236_numcgm(true, 'gestora');", $db_opcao);
                        ?>
                    </td>
                    <td>
                        <?
                        db_input('c236_numcgmgestora', 14, $Ic236_numcgmgestora, true, 'text', $db_opcao, " onchange=js_pesquisac236_numcgm(false,'gestora');");
                        if ($c236_numcgmgestora) {
                            $resultado = db_query("select z01_nome as z01_nomegestora from cgm where z01_numcgm = {$c236_numcgmgestora}");
                            db_fieldsmemory($resultado, 0)->z01_nomegestora;
                        }
                        db_input('z01_nomegestora', 40, $Iz01_nome, true, 'text', 3, '', "z01_nomegestora");
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
    // Declarando uma variavel global
    campo = "";
    // Verificando se campos condicionais devem aparecer
    // verificarMassaInstituidaPorLei();

    function js_pesquisac236_numcgm(mostra, input) {
        campo = input;
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_cgm', 'func_cgm.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome', 'Pesquisa', true);
            return;
        }
        preencheAutomaticamente();
        return;
    }

    function preencheAutomaticamente() {
        if (campo === "executivo") {
            preencheExecutivoAutomaticamente();
            return;
        }

        if (campo === "legislativo") {
            preencheLegislativoAutomaticamente();
            return;
        }

        if (campo === "gestora") {
            preencheGestoraAutomaticamente();
            return;
        }
    }

    function preencheExecutivoAutomaticamente() {
        campo = "executivo";
        if (document.form1.c236_numcgmexecutivo.value != '') {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_cgm', 'func_cgm.php?pesquisa_chave=' + document.form1.c236_numcgmexecutivo.value + '&funcao_js=parent.js_mostracgm', 'Pesquisa', false);
            return;
        }
        document.form1.z01_nomeexecutivo.value = '';
    }

    function preencheLegislativoAutomaticamente() {
        campo = "legislativo";
        if (document.form1.c236_numcgmlegislativo.value != '') {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_cgm', 'func_cgm.php?pesquisa_chave=' + document.form1.c236_numcgmlegislativo.value + '&funcao_js=parent.js_mostracgm', 'Pesquisa', false);
            return;
        }
        document.form1.z01_nomelegislativo.value = '';
    }

    function preencheGestoraAutomaticamente() {
        campo = "gestora";
        if (document.form1.c236_numcgmgestora.value != '') {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_cgm', 'func_cgm.php?pesquisa_chave=' + document.form1.c236_numcgmgestora.value + '&funcao_js=parent.js_mostracgm', 'Pesquisa', false);
            return;
        }
        document.form1.z01_nomegestora.value = '';
    }

    function js_mostracgm(erro, chave) {
        if (campo === "executivo") {
            document.form1.z01_nomeexecutivo.value = chave;
            if (erro == true) {
                document.form1.c236_numcgmexecutivo.focus();
                document.form1.c236_numcgmexecutivo.value = '';
            }
            return;
        }

        if (campo === "legislativo") {
            document.form1.z01_nomelegislativo.value = chave;
            if (erro == true) {
                document.form1.c236_numcgmlegislativo.focus();
                document.form1.c236_numcgmlegislativo.value = '';
            }
            return;
        }

        if (campo === "gestora") {
            document.form1.z01_nomegestora.value = chave;
            if (erro == true) {
                document.form1.c236_numcgmgestora.focus();
                document.form1.c236_numcgmgestora.value = '';
            }
            return;
        }
    }

    function js_mostracgm1(chave1, chave2) {
        if (campo === "executivo") {
            document.form1.c236_numcgmexecutivo.value = chave1;
            document.form1.z01_nomeexecutivo.value = chave2;
        }

        if (campo === "legislativo") {
            document.form1.c236_numcgmlegislativo.value = chave1;
            document.form1.z01_nomelegislativo.value = chave2;
        }

        if (campo === "gestora") {
            document.form1.c236_numcgmgestora.value = chave1;
            document.form1.z01_nomegestora.value = chave2;
        }
        db_iframe_cgm.hide();
    }

    function js_pesquisa() {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_dipr', 'func_dipr.php?funcao_js=parent.js_preenchepesquisa|c236_coddipr', 'Pesquisa', true);
    }

    function js_preenchepesquisa(chave) {
        db_iframe_dipr.hide();
        <?
        if ($db_opcao != 1) {
            echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave; ";
        ?>
        <? } ?>
    }

    function verificarMassaInstituidaPorLei()
    {
        if (document.form1.c236_massainstituida.value === "f") {
            ocultarLinha('LinhaNumeroAtoNormativo');
            ocultarLinha('LinhaExercicioAtoNormativo');
            return;
        }

        mostrarLinha('LinhaNumeroAtoNormativo');
        mostrarLinha('LinhaExercicioAtoNormativo');
        return;
    }

    function ocultarLinha(identificador) {
        alterarDisplayDaLinha(identificador, 'none');
    }

    function mostrarLinha(identificador) {
        alterarDisplayDaLinha(identificador, 'table-row');
    }

    function alterarDisplayDaLinha(identificador, display) {
        document.getElementById(identificador).style.display = display;
    }
</script>