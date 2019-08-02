<form name="form1" method="post">
    <input type="hidden" name="empenho" value="<?= $empenho ?>">
    <table border="0">
        <tr>
            <td align="left" nowrap title="<?=@$Te60_codemp?>">
                <?=@$Le60_codemp?>
                <?
                db_input('e60_codemp',10,'',true,'text',3);
                ?>
            </td>
            <td align="right" nowrap title="<?=@$Te50_codord?>">
                <?
                db_ancora(@$Le50_codord,"js_pesquisae50_getordem(".$empenho.");",$db_opcao);
                ?>
            </td>
            <td>
                <?
                db_input('e50_codord',10,'',true,'text',3);
                ?>
            </td>
        </tr>
        <tr>
            <td nowrap title="<?=@$Te50_obs?>" colspan="3">
                <fieldset>
                    <legend>
                        <strong>Histórico</strong>
                    </legend>
                    <? db_textarea('e50_obs',4,84,$Ie50_obs,true,'text',$db_opcao) ?>
                </fieldset>
            </td>
        </tr>
    </table>

    <div style="margin-top: 10px;">

        <!--        <input name="alterar" type="button" id="alterar" value="Alterar" onclick="js_altera();" >-->
        <input name="alterar" type="submit" id="db_opcao" value="Alterar">

    </div>
</form>
<script type="text/javascript" src="scripts/prototype.js"></script>
<script type="text/javascript" src="scripts/strings.js"></script>
<script>
    function pesquisaOrdemPagamento(empenho) {
        $('e60_codemp').value = empenho;

        js_pesquisae50_getordem(empenho);
    }

    function js_pesquisae50_getordem(e60_codemp) {
        
        js_OpenJanelaIframe(
            '',
            'iframe_alteracaoop',
            'func_pagordem.php?$pesquisa_chave='+e60_codemp+'&funcao_js=parent.js_mostraordem|e50_codord|e50_obs',
            'Pesquisa',
            true,
            '0',
            '1'
        );

    }

    function js_mostraordem(e50_codord, e50_obs) {

        $('e50_codord').value = e50_codord;
        $('e50_obs').value = e50_obs;
        console.log(e50_obs);
        iframe_alteracaoop.hide();

    }

</script>