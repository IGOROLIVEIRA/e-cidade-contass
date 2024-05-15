<?
//MODULO: contabilidade
$clnaturdessiops->rotulo->label();
?>
<form name="form1" method="post" action="">
    <fieldset style="width: 350px; height: 90px; margin-bottom:10px;"><legend><b>Código da Despesa:</b></legend>
        <table style="margin-bottom: 10px;">
            <tr>
                <td>&nbsp;</td>
                <td nowrap title="<?=@$Tc226_natdespecidade?>">
                    <strong><?=@$Lc226_natdespecidade?></strong>
                </td>
                <td nowrap title="<?=@$Tc226_natdespsiops?>">
                    <strong><?=@$Lc226_natdespsiops?></strong>
                </td>
            </tr>
            <tr>
                <td><strong>Código da Despesa:</strong></td>
                <td>
                    <?
                    db_input('c226_natdespecidade',11,$Ic226_natdespecidade,true,'text',1,"")
                    ?>
                </td>
                <td>
                    <?
                    db_input('c226_natdespsiops',11,$Ic226_natdespsiops,true,'text',1,"")
                    ?>
                </td>
            </tr>
        </table>
        <input name="c226_anousu" value="<?= db_getsession("DB_anousu") ?>" type="hidden" >
        <input style="display:none" name="novo" type="submit" id="novo" value="Novo" onclick="novaNat();">
        <input name="incluir" type="submit" id="incluir" value="Incluir">
        <input style="display:none" name="excluir" type="submit" id="excluir" value="Excluir">
        <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
    </fieldset>
</form>
<script>
    function js_pesquisa(){
        js_OpenJanelaIframe('','db_iframe_naturdessiops','func_naturdessiops.php?funcao_js=parent.js_preenchepesquisa|c226_natdespecidade|c226_natdespsiops|c226_anousu','Pesquisa',true,0);
    }
    function js_preenchepesquisa(chave, chave1, chave2){
        document.form1.novo.style.display = 'inline-block';
        document.form1.excluir.style.display = 'inline-block';
        document.form1.incluir.style.display = 'none';
        document.form1.c226_natdespecidade.style.background = '#DEB887';
        document.form1.c226_natdespsiops.style.background = '#DEB887';
        document.form1.c226_natdespecidade.setAttribute('readonly',true);
        document.form1.c226_natdespsiops.setAttribute('readonly',true);
        document.form1.c226_natdespecidade.value = chave;
        document.form1.c226_natdespsiops.value = chave1;
        document.form1.c226_anousu.value = chave2;
        db_iframe_naturdessiops.hide();

    }

    function novaNat() {

        document.form1.novo.style.display = 'none';
        document.form1.excluir.style.display = 'none';
        document.form1.incluir.style.display = 'inline-block';
        document.form1.c226_natdespecidade.style.background = '';
        document.form1.c226_natdespsiops.style.background = '';
        document.form1.c226_natdespecidade.setAttribute('readonly',false);
        document.form1.c226_natdespsiops.setAttribute('readonly',false);
        document.form1.c226_natdespecidade.value = "";
        document.form1.c226_natdespsiops.value = "";

    }

</script>
