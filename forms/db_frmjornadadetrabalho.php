<?
//MODULO: pessoal
$cljornadadetrabalho->rotulo->label();
?>
<form name="form1" method="post" action="">
    <center>
        <table border="0">
            <tr>
                <td nowrap title="<?= @$Tjt_sequencial ?>">
                    <?= @$Ljt_sequencial ?>
                </td>
                <td>
                    <?
                    db_input('jt_sequencial', 10, $Ijt_sequencial, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Tjt_nome ?>">
                    <?= @$Ljt_nome ?>
                </td>
                <td>
                    <?
                    db_input('jt_nome', 50, $Ijt_nome, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?php echo $Ljt_descricao; ?>" colspan="2">
                    <fieldset>
                        <legend><?php echo $Ljt_descricao ?></legend>
                        <?php db_textarea('jt_descricao', 4, 50, $Ijt_descricao, true, 'text', $db_opcao, ""); ?>
                    </fieldset>
                </td>

            </tr>
        </table>

        <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
        <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
    </center>
</form>
<script>
    function js_pesquisa() {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_jornadadetrabalho', 'func_jornadadetrabalho.php?funcao_js=parent.js_preenchepesquisa|jt_sequencial', 'Pesquisa', true);
    }

    function js_preenchepesquisa(chave) {
        db_iframe_jornadadetrabalho.hide();
        <?
        if ($db_opcao != 1) {
            echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
        }
        ?>
    }
</script>
