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
$cldirp->rotulo->label();
?>
    <form name="form1" method="post" action="">
        <center>
            <br />
            <fieldset style="width: 800;">
                <legend><b>Informações Previdenciárias - DIPR</b></legend>
                <table border="0" width="800;">
                    <tr>
                        <td><b>O ente possui segregação da massa instituída por lei?:</b></td>
                        <td>
                            <?php
                            $aSegregacaoLei = array(0 => "Selecione", 't' => "Sim", 'f' => "Não");
                            db_select('c236_massainstituida', $aSegregacaoLei, true, 1, "style='width:104px'");
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td><b>O município possui beneficiários custeados com recursos do tesouro?:</b></td>
                        <td>
                            <?php
                            $aBeneficiarioTesouro = array(0 => "Selecione", 't' => "Sim", 'f' => "Não");
                            db_select('c236_beneficiotesouro', $aBeneficiarioTesouro, true, 1, "style='width:104px'");
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td><b>Número do ato normativo:</b></td>
                        <td>
                            <?php
                            db_input("c236_atonormativo", 14, "0", true, "text", $db_opcao, "", "", "", "", 6);
                            ?>
                        </td>
                    </tr>

                    <tr>
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
                            db_input('z01_nomeexecutivo', 40, $Iz01_nome, true, 'text', 3, '', "z01_nomeexecutivo");
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
    campo = "";

    function js_pesquisac236_numcgm(mostra, input) {
        campo = input;
        console.log(mostra);
        console.log(campo);
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_numcgm', 'func_nome.php?funcao_js=top.corpo.js_mostracgm1|z01_numcgm|z01_nome', 'Pesquisa', true, 0);
            return true;
        }
        preencheAutomaticamente();
        return true;
    }

    function preencheAutomaticamente() {
        console.log(campo);
        if (campo === "executivo") {
            preencheExecutivoAutomaticamente();
            return true; 
        }

        if (campo === "legislativo") {
            preencheLegislativoAutomaticamente();
            return true;
        }

        if (campo === "gestora") {
            preencheGestoraAutomaticamente();
            return true;
        }
    }

    function preencheExecutivoAutomaticamente() {
        if (document.form1.c236_numcgmexecutivo.value != '') {
            console.log("Antes");
            js_OpenJanelaIframe('top.corpo', 'db_iframe_numcgm', 'func_nome.php?pesquisa_chave=' + document.form1.c236_numcgmexecutivo.value + '&funcao_js=top.corpo.js_mostracgm', 'Pesquisa', false);
            console.log("Depois");
            return true;
        } 
        document.form1.z01_nomeexecutivo.value = '';
    }

    function preencheLegislativoAutomaticamente() {
        if (document.form1.c236_numcgmlegislativo.value != '') {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_numcgm', 'func_nome.php?pesquisa_chave=' + document.form1.c236_numcgmlegislativo.value + '&funcao_js=top.corpo.js_mostracgm', 'Pesquisa', false);
            return true;
        } 
        document.form1.z01_nomelegislativo.value = '';
    }

    function preencheGestoraAutomaticamente() {
        if (document.form1.c236_numcgmgestora.value != '') {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_numcgm', 'func_nome.php?pesquisa_chave=' + document.form1.c236_numcgmgestora.value + '&funcao_js=top.corpo.js_mostracgm', 'Pesquisa', false);
            return true;
        } 
        document.form1.z01_nomegestora.value = '';
    }

    function js_mostracgm(erro, chave) {
        console.log("Dentro");
        if (campo === "executivo" ) {
            document.form1.z01_nomeexecutivo.value = chave;
            if (erro == true) {
                document.form1.c236_numcgmexecutivo.focus();
                document.form1.c236_numcgmexecutivo.value = '';
            }
        }

        if (campo === "legislativo" ) {
            document.form1.z01_nomelegislativo.value = chave;
            if (erro == true) {
                document.form1.c236_numcgmlegislativo.focus();
                document.form1.c236_numcgmlegislativo.value = '';
            }
        }
        
        if (campo === "gestora" ) {
            document.form1.z01_nomegestora.value = chave;
            if (erro == true) {
                document.form1.c236_numcgmgestora.focus();
                document.form1.c236_numcgmgestora.value = '';
            }
        }
    }

    function js_mostracgm1(chave1, chave2) {
        if (campo === "executivo" ) {
            document.form1.c236_numcgmexecutivo.value = chave1;
            document.form1.z01_nomeexecutivo.value = chave2;
        }

        if (campo === "legislativo" ) {
            document.form1.c236_numcgmlegislativo.value = chave1;
            document.form1.z01_nomelegislativo.value = chave2;
        }
        
        if (campo === "gestora" ) {
            document.form1.c236_numcgmgestora.value = chave1;
            document.form1.z01_nomegestora.value = chave2;
        }
        db_iframe_numcgm.hide();
    }

    function js_pesquisa() {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_dirp', 'func_dirp.php?funcao_js=parent.js_preenchepesquisa|c236_coddirp', 'Pesquisa', true);
    }

    function js_preenchepesquisa(chave) {
        db_iframe_dirp.hide();
        <?
        if ($db_opcao != 1) {
            echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave; ";
        ?>
            js_pesquisac236_numcgm(false,'executivo');
            js_pesquisac236_numcgm(false,'legislativo');
            js_pesquisac236_numcgm(false,'gestora');  
        <? } ?>
    }
</script>