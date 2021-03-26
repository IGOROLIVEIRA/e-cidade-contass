<?
//MODULO: acordos
$clacordoleis->rotulo->label();
?>
<form name="form1" method="post" action="">
    <center>
        <table align=center style="margin-top:25px;">
            <tr>
                <td align=center>

                    <fieldset>
                        <legend><b>Leis de Contratos</b></legend>
                        <table border="0">
                            <tr>
                                <td nowrap title="<?= @$Tac54_sequencial ?>">
                                    <input name="oid" type="hidden" value="<?= @$ac54_sequencial ?>">
                                    <?= @$Lac54_sequencial ?>
                                </td>
                                <td>
                                    <?
                                    db_input('ac54_sequencial', 10, $Iac54_sequencial, true, 'text', 3, "")
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap title="<?= @$Tac54_descricao ?>">
                                    <?= @$Lac54_descricao ?>
                                </td>
                                <td>
                                    <?
                                    db_textarea('ac54_descricao', 3, 48, $Iac54_descricao, true, 'text', $db_opcao, "", "", "", "100");
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </fieldset>

                </td>
            </tr>
        </table>
    </center>
    <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>"
           type="submit" id="db_opcao"
           value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?> >
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
</form>
<script>
    function js_pesquisa() {
        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_acordoleis', 'func_acordoleis.php?funcao_js=parent.js_preenchepesquisa|0', 'Pesquisa', true);
    }
    function js_preenchepesquisa(chave) {
        db_iframe_acordoleis.hide();
        <?
        if($db_opcao!=1){
          echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        }
        ?>
    }
</script>
