<?
//MODULO: empenho
$clfornemensalemp->rotulo->label();
?>
<form name="form1" method="post" action="">
    <fieldset>
        <legend>Fornecedores Mensais</legend>
        <table border="0">
            <tr>
                <td nowrap title="<?php $Tfm101_numcgm ?>"><? db_ancora("Nome/Razão Social", "js_pesquisafm101_numcgm(true);", 1); ?></td>
                <td nowrap>
                    <? db_input("fm101_numcgm", 10, $Ifm101_numcgm, true, "text", 4, "onchange='js_pesquisafm101_numcgm(false);'");
                    db_input("z01_nome", 40, "$Iz01_nome", true, "text", 3);
                    ?></td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Tfm101_datafim ?>">
                    <?= @$Lfm101_datafim ?>
                </td>
                <td>
                    <?
                    db_inputdata('fm101_datafim', @$fm101_datafim_dia, @$fm101_datafim_mes, @$fm101_datafim_ano, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
        </table>

    </fieldset>
    <table width="190" border="0" cellspacing="10" cellpadding="0">
        <tr>
            <td height="30" align="center" bgcolor="#CCCCCC">
                <center>
                    <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
                    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
                </center>
            </td>
        </tr>
    </table>
</form>
<script>
    function js_pesquisa() {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_fornemensalemp', 'func_fornemensalemp.php?funcao_js=parent.js_preenchepesquisa|0', 'Pesquisa', true);
    }

    function js_preenchepesquisa(chave) {
        db_iframe_fornemensalemp.hide();
        <?
        if ($db_opcao != 1) {
            echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
        }
        ?>
    }
    //---------------------------------------------------------------
    function js_pesquisafm101_numcgm(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_cgm', 'func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome', 'Pesquisa', true);
        } else {
            if (document.form1.fm101_numcgm.value != '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_cgm', 'func_nome.php?pesquisa_chave=' + document.form1.fm101_numcgm.value + '&funcao_js=parent.js_mostracgm', 'Pesquisa', false);
            } else {
                document.form1.z01_nome.value = '';
            }
        }
    }

    function js_mostracgm(erro,chave){
        document.form1.z01_nome.value = chave;
        if(erro==true){
            document.form1.fm101_numcgm.focus();
            document.form1.fm101_numcgm.value = '';
        }
    }
    function js_mostracgm1(chave1,chave2){
        document.form1.fm101_numcgm.value = chave1;
        document.form1.z01_nome.value = chave2;
        db_iframe_cgm.hide();
    }
</script>
