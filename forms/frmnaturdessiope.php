<?
//MODULO: contabilidade
$clnaturdessiope->rotulo->label();
$iAnoUsu = db_getsession('DB_anousu');
if ($iAnoUsu < 2021) {
    $tam_campo = 11;
} else {
    $tam_campo = 15;
}
?>
<form name="form1" method="post" action="">
    <fieldset style="width: 350px; height: 90px; margin-bottom:10px;"><legend><b>Código da Despesa:</b></legend>
        <table style="margin-bottom: 10px;">
            <tr>
                <td>&nbsp;</td>
                <td nowrap title="<?=@$Tc222_natdespecidade?>">
                    <strong><?=@$Lc222_natdespecidade?></strong>
                </td>
                <td nowrap title="<?=@$Tc222_natdespsiope?>">
                    <strong><?=@$Lc222_natdespsiope?></strong>
                </td>
                <td nowrap title="<?=@$Tc222_previdencia?>">
                    <strong><?=@$Lc222_previdencia?></strong>
                </td>
            </tr>
            <tr>
                <td nowrap><strong>Código da Despesa:</strong></td>
                <td>
                    <?
                    db_input('c222_natdespecidade',$tam_campo,$Ic222_natdespecidade,true,'text',1,"")
                    ?>
                </td>
                <td>
                    <?
                    db_input('c222_natdespsiope',$tam_campo,$Ic222_natdespsiope,true,'text',1,"")
                    ?>
                </td>
                <td>
                    <?
                    $xx = array("f"=>"NAO","t"=>"SIM");
                    db_select('c222_previdencia',$xx,true,1,"");
                    ?>
                </td>



            </tr>
        </table>
        <input name="c222_anousu" value="<?= db_getsession("DB_anousu") ?>" type="hidden" >
        <input style="display:none" name="novo" type="submit" id="novo" value="Novo" onclick="novaNat();">
        <input name="incluir" type="submit" id="incluir" value="Incluir">
        <input style="display:none" name="alterar" type="submit" id="alterar" value="Alterar">
        <input style="display:none" name="excluir" type="submit" id="excluir" value="Excluir">
        <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
    </fieldset>
</form>
<script>
    function js_pesquisa(){
        js_OpenJanelaIframe('','db_iframe_naturdessiope','func_naturdessiope.php?funcao_js=parent.js_preenchepesquisa|c222_natdespecidade|c222_natdespsiope|c222_previdencia|c222_anousu','Pesquisa',true,0);
    }
    function js_preenchepesquisa(chave, chave1, chave2, chave3){
        document.form1.novo.style.display = 'inline-block';
        document.form1.excluir.style.display = 'inline-block';
        document.form1.incluir.style.display = 'none';
        document.form1.alterar.style.display = 'inline-block';
        document.form1.c222_natdespecidade.style.background = '#DEB887';
        document.form1.c222_natdespsiope.style.background = '#DEB887';
        document.form1.c222_natdespecidade.setAttribute('readonly',true);
        document.form1.c222_natdespsiope.setAttribute('readonly',true);
        document.form1.c222_natdespecidade.value = chave;
        document.form1.c222_natdespsiope.value = chave1;
        document.form1.c222_previdencia.value = chave2;
        document.form1.c222_anousu.value = chave3;
        db_iframe_naturdessiope.hide();

    }

    function novaNat() {

        document.form1.novo.style.display = 'none';
        document.form1.excluir.style.display = 'none';
        document.form1.incluir.style.display = 'inline-block';
        document.form1.c222_natdespecidade.style.background = '';
        document.form1.c222_natdespsiope.style.background = '';
        document.form1.c222_natdespecidade.setAttribute('readonly',false);
        document.form1.c222_natdespsiope.setAttribute('readonly',false);
        document.form1.c222_natdespecidade.value = "";
        document.form1.c222_natdespsiope.value = "";

    }

    let iAnoUsu = <?= $iAnoUsu ?>;
    
    if (iAnoUsu >= 2021) {
        document.getElementById("c222_previdencia").disabled        = true;        
        document.getElementById("c222_natdespecidade").maxLength    = 15;
        document.getElementById("c222_natdespsiope").maxLength      = 15;
    }

</script>
