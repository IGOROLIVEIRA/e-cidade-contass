<?
//MODULO: contabilidade
$clnaturrecsiope->rotulo->label();
?>
<form name="form1" method="post" action="">
    <fieldset style="width: 350px; height: 90px; margin-bottom:10px;"><legend><b>Código da Receita:</b></legend>
        <table style="margin-bottom: 10px;">
            <tr>
                <td>&nbsp;</td>
                <td nowrap title="<?=@$Tc224_natrececidade?>">
                    <strong><?=@$Lc224_natrececidade?></strong>
                </td>
                <td nowrap title="<?=@$Tc224_natrecsiope?>">
                    <strong><?=@$Lc224_natrecsiope?></strong>
                </td>
            </tr>
            <tr>
                <td><strong>Código da Receita:</strong></td>
                <td>
                    <?
                    db_input('c224_natrececidade',15,$Ic224_natrececidade,true,'text',1,"")
                    ?>
                </td>
                <td>
                    <?
                    db_input('c224_natrecsiope',15,$Ic224_natrecsiope,true,'text',1,"")
                    ?>
                </td>
            </tr>
        </table>
        <input name="c224_anousu" value="<?= db_getsession("DB_anousu") ?>" type="hidden" >
        <input style="display:none" name="novo" type="submit" id="novo" value="Novo" onclick="novaNat();">
        <input name="incluir" type="submit" id="incluir" value="Incluir">
        <input style="display:none" name="excluir" type="submit" id="excluir" value="Excluir">
        <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
    </fieldset>
</form>
<script>
    function js_pesquisa(){
        js_OpenJanelaIframe('','db_iframe_naturrecsiope','func_naturrecsiope.php?funcao_js=parent.js_preenchepesquisa|c224_natrececidade|c224_natrecsiope|c224_anousu','Pesquisa',true,0);
    }
    function js_preenchepesquisa(chave, chave1, chave2){
        document.form1.novo.style.display = 'inline-block';
        document.form1.excluir.style.display = 'inline-block';
        document.form1.incluir.style.display = 'none';
        document.form1.c224_natrececidade.style.background = '#DEB887';
        document.form1.c224_natrecsiope.style.background = '#DEB887';
        document.form1.c224_natrececidade.setAttribute('readonly',true);
        document.form1.c224_natrecsiope.setAttribute('readonly',true);
        document.form1.c224_natrececidade.value = chave;
        document.form1.c224_natrecsiope.value = chave1;
        document.form1.c224_anousu.value = chave2;
        db_iframe_naturrecsiope.hide();

    }

    function novaNat() {

        document.form1.novo.style.display = 'none';
        document.form1.excluir.style.display = 'none';
        document.form1.incluir.style.display = 'inline-block';
        document.form1.c224_natrececidade.style.background = '';
        document.form1.c224_natrecsiope.style.background = '';
        document.form1.c224_natrececidade.setAttribute('readonly',false);
        document.form1.c224_natrecsiope.setAttribute('readonly',false);
        document.form1.c224_natrececidade.value = "";
        document.form1.c224_natrecsiope.value = "";

    }

</script>
