<form name="form1" method="post">
    <input type="hidden" name="empenho" id="empenho" value="<?= $empenho ?>">
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
                db_ancora(@$Le50_codord,"pesquisaOrdemPagamento();",$db_opcao);
                ?>
            </td>
            <td>
                <?
                db_input('e50_codord',10,'',true,'text',3);
                db_input('e50_data',50,"",true,'hidden',3);
                ?>
            </td>
        </tr>
        
        <!-- OC 12746 -->        
        <td style="display: none" id="competDespInput"><b>Competência Despesa: </b>
            <?db_inputData('e50_compdesp', '', '', '', true, 'text', 1); ?>
        </td>        

        <tr>
            <td nowrap title="<?=@$Te50_obs?>" colspan="3">
                <fieldset>
                    <legend>
                        <strong>Histórico</strong>
                    </legend>
                    <? db_textarea('e50_obs',4,84,$Ie50_obs,true,'text',2) ?>
                </fieldset>
            </td>
        </tr>
    </table>

    <div style="margin-top: 10px;">

        <input name="alterar" type="submit" id="db_opcao" value="Alterar">

    </div>
</form>
<script type="text/javascript" src="scripts/prototype.js"></script>
<script type="text/javascript" src="scripts/strings.js"></script>
<script>
    function pesquisaOrdemPagamento() {
        empenho = $('empenho').value;
        $('e60_codemp').value = empenho;
        
        js_pesquisae50_getordem(empenho);
    }

    function js_pesquisae50_getordem(e60_codemp) {

        js_OpenJanelaIframe(
            '',
            'db_iframe_alteracaoop',
            'func_pagordem.php?chave_e60_codemp='+e60_codemp+'&funcao_js=parent.js_mostraordem|e50_codord|e50_obs|e50_compdesp|elemento|e50_data',
            'Pesquisa',
            true,
            '0',
            '1'
        );

    }

    
    function js_mostraordem(e50_codord, e50_obs, e50_compdesp, elemento, e50_data) {
        
        $('e50_codord').value   = e50_codord;
        $('e50_obs').value      = e50_obs;
        $('e50_data').value     = e50_data;
        
        if (e50_compdesp != '') {
            data = new Date(e50_compdesp);
            e50_compdesp = ((data.getDate()+1) + "/" + ("0" + (data.getMonth() + 1)).substr(-2) + "/" + data.getFullYear());            
        }

        aMatrizEntrada = ['3319092', '3319192', '3319592', '3319692'];
        
        if (aMatrizEntrada.indexOf(elemento) !== -1) {
            $('e50_compdesp').value = e50_compdesp;
            document.getElementById('competDespInput').style.display = "table-cell";
        } else {
            document.getElementById('competDespInput').style.display = "none";
        }
        
        db_iframe_alteracaoop.hide();

    }
</script>