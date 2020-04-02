<?
//MODULO: contabilidade
$clvinculocaspweb->rotulo->label();
$c232_anousu = isset($chavepesquisa2) ? $chavepesquisa2 : $c232_anousu;
?>
<form name="form1" method="post" action="">
    <input type="hidden" name="c232_estrutecidadeant" value="<?=@$c232_estrutecidade?>">
    <input type="hidden" name="c232_estrutcaspwebant" value="<?=@$c232_estrutcaspweb?>">
    <center>
        <fieldset style="margin-top:10px; margin-bottom:10px; ">
            <legend>De/Para Pcasp - Caspweb</legend>
            <table border="0" style="">
                <tr>
                    <td nowrap title="<?=@$Tc232_estrutecidade?>">
                        <?=@$Lc232_estrutecidade?>
                    </td>
                    <td>
                        <?
                        db_input('c232_estrutecidade',9,$Ic232_estrutecidade,true,'text',$db_opcao,"")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Tc232_estrutcaspweb?>">
                        <?=@$Lc232_estrutcaspweb?>
                    </td>
                    <td>
                        <?
                        db_input('c232_estrutcaspweb',9,$Ic232_estrutcaspweb,true,'text',$db_opcao,"")
                        ?>
                    </td>
                </tr>
            </table>
        </fieldset>
        <center>
            <input name="c232_anousu" value="<?= isset($c232_anousu) ? $c232_anousu : db_getsession("DB_anousu") ?>" type="hidden" >
            <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
            <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
    function js_pesquisa(){
        js_OpenJanelaIframe('top.corpo','db_iframe_vinculopcaspmsc','func_vinculocaspweb.php?funcao_js=parent.js_preenchepesquisa|c232_estrutecidade|c232_estrutcaspweb|c232_anousu','Pesquisa',true);
    }
    function js_preenchepesquisa(chave,chave1,chave2){
        db_iframe_vinculopcaspmsc.hide();
        <?
        if($db_opcao!=1){
            echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave+'&chavepesquisa1='+chave1+'&chavepesquisa2='+chave2";
        }
        ?>
    }
</script>
