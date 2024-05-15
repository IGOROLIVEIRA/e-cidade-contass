<?
//MODULO: licitacao
$clregulamentalc123->rotulo->label();
?>
<form name="form1" method="post" action="">
    <center>
        <fieldset style="margin-left: 80px; margin-top: 10px;">
            <legend>Regulamentação LC 123/2006</legend>
            <table border="0">
                <tr>
                    <td nowrap title="<?= @$Tl210_sequencial ?>">
                        <?= @$Ll210_sequencial ?>
                    </td>
                    <td>
                        <?
                        db_input('l210_sequencial', 10, $Il210_sequencial, true, 'text', 3, "")
                        ?>
                    </td>
                </tr>
            </table>
            <fieldset style="margin-left: 80px;">
                <legend>O município implementou a regulamentação do art. 47 da LC 123/2006?</legend>
                <table border="0">
                    <tr>
                        <td nowrap title="<?= @$Tl210_regulamentart47 ?>">
                            <?= @$Ll210_regulamentart47 ?>
                        </td>
                        <td>
                            <?
                            $x = array('2' => 'Não','1' => 'Sim');
                            db_select('l210_regulamentart47', $x, true, $db_opcao, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Tl210_nronormareg ?>">
                            <?= @$Ll210_nronormareg ?>
                        </td>
                        <td>
                            <?
                            db_input('l210_nronormareg', 10, $Il210_nronormareg, true, 'text', $db_opcao, "")
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Tl210_datanormareg ?>">
                            <?= @$Ll210_datanormareg ?>
                        </td>
                        <td>
                            <?
                            db_inputdata('l210_datanormareg', @$l210_datanormareg_dia, @$l210_datanormareg_mes, @$l210_datanormareg_ano, true, 'text', $db_opcao, "")
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Tl210_datapubnormareg ?>">
                            <?= @$Ll210_datapubnormareg ?>
                        </td>
                        <td>
                            <?
                            db_inputdata('l210_datapubnormareg', @$l210_datapubnormareg_dia, @$l210_datapubnormareg_mes, @$l210_datapubnormareg_ano, true, 'text', $db_opcao, "")
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset style="margin-left: 80px; margin-top: 10px;">
                <legend>O município regulamentou procedimentos para a participação exclusiva de ME e EPP?</legend>
                <table border="0">
                    <tr>
                        <td nowrap title="<?= @$Tl210_regexclusiva ?>">
                            <?= @$Ll210_regexclusiva ?>
                        </td>
                        <td>
                            <?
                            $x = array('2' => 'Não','1' => 'Sim');
                            db_select('l210_regexclusiva', $x, true, $db_opcao, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Tl210_artigoregexclusiva ?>">
                            <?= @$Ll210_artigoregexclusiva ?>
                        </td>
                        <td>
                            <?
                            db_input('l210_artigoregexclusiva', 10, $Il210_artigoregexclusiva, true, 'text', $db_opcao, "")
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Tl210_valorlimiteregexclusiva ?>">
                            <?= @$Ll210_valorlimiteregexclusiva ?>
                        </td>
                        <td>
                            <?
                            db_input('l210_valorlimiteregexclusiva', 10, $Il210_valorlimiteregexclusiva, true, 'text', $db_opcao, "")
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset style="margin-left: 80px; margin-top: 10px;">
                <legend>O município estabeleceu procedimentos para a participação exclusiva de ME e EPP?</legend>
                <table border="0">
                    <tr>
                        <td nowrap title="<?= @$Tl210_procsubcontratacao ?>">
                            <?= @$Ll210_procsubcontratacao ?>
                        </td>
                        <td>
                            <?
                            $x = array('2' => 'Não','1' => 'Sim');
                            db_select('l210_procsubcontratacao', $x, true, $db_opcao, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Tl210_artigoprocsubcontratacao ?>">
                            <?= @$Ll210_artigoprocsubcontratacao ?>
                        </td>
                        <td>
                            <?
                            db_input('l210_artigoprocsubcontratacao', 10, $Il210_artigoprocsubcontratacao, true, 'text', $db_opcao, "")
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Tl210_percentualsubcontratacao ?>">
                            <?= @$Ll210_percentualsubcontratacao ?>
                        </td>
                        <td>
                            <?
                            db_input('l210_percentualsubcontratacao', 10, $Il210_percentualsubcontratacao, true, 'text', $db_opcao, "")
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset style="margin-left: 80px; margin-top: 10px;">
                <legend>O município estabeleceu critérios para empenho e pagamento de ME e EPP?</legend>
                <table border="0">
                    <tr>
                        <td nowrap title="<?= @$Tl210_criteriosempenhopagamento ?>">
                            <?= @$Ll210_criteriosempenhopagamento ?>
                        </td>
                        <td>
                            <?
                            $x = array('2' => 'Não','1' => 'Sim');
                            db_select('l210_criteriosempenhopagamento', $x, true, $db_opcao, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Tl210_artigoempenhopagamento ?>">
                            <?= @$Ll210_artigoempenhopagamento ?>
                        </td>
                        <td>
                            <?
                            db_input('l210_artigoempenhopagamento', 10, $Il210_artigoempenhopagamento, true, 'text', $db_opcao, "")
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset style="margin-left: 80px; margin-top: 10px;">
                <legend>O município estabeleceu reserva de percentual do objeto para a contratação de ME e EPP, em certames para a aquisição de bens e serviços de natureza divisível?</legend>
                <table border="0">
                    <tr>
                        <td nowrap title="<?= @$Tl210_estabeleceuperccontratacao ?>">
                            <?= @$Ll210_estabeleceuperccontratacao ?>
                        </td>
                        <td>
                            <?
                            $x = array('2' => 'Não','1' => 'Sim');
                            db_select('l210_estabeleceuperccontratacao', $x, true, $db_opcao, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Tl210_artigoperccontratacao ?>">
                            <?= @$Ll210_artigoperccontratacao ?>
                        </td>
                        <td>
                            <?
                            db_input('l210_artigoperccontratacao', 10, $Il210_artigoperccontratacao, true, 'text', $db_opcao, "")
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Tl210_percentualcontratacao ?>">
                            <?= @$Ll210_percentualcontratacao ?>
                        </td>
                        <td>
                            <?
                            db_input('l210_percentualcontratacao', 10, $Il210_percentualcontratacao, true, 'text', $db_opcao, "")
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </fieldset>
    </center>
    <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>"
           type="submit" id="db_opcao"
           value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?> >
</form>
<script>
    function js_pesquisa() {
        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_regulamentalc123', 'func_regulamentalc123.php?funcao_js=parent.js_preenchepesquisa|0', 'Pesquisa', true);
    }
    function js_preenchepesquisa(chave) {
        db_iframe_regulamentalc123.hide();
        <?
        if($db_opcao!=1){
          echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        }
        ?>
    }
</script>
