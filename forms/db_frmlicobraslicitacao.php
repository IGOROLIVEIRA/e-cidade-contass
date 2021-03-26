<?
//MODULO: Obras
$cllicobraslicitacao->rotulo->label();
?>
<form name="form1" method="post" action="" id="formulariolicitacao">
    <fieldset>
        <legend>Licitação</legend>
        <table border="0">
            <tr>
                <td nowrap title="<?=@$Tobr07_sequencial?>">
                    <input name="oid" type="hidden" value="<?=@$oid?>">
                    <?=@$Lobr07_sequencial?>
                </td>
                <td>
                    <?
                    db_input('obr07_sequencial',11,$Iobr07_sequencial,true,'text',3,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tobr07_processo?>">
                    <?=@$Lobr07_processo?>
                </td>
                <td>
                    <?
                    db_input('obr07_processo',11,$Iobr07_processo,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tobr07_exercicio?>">
                    <?=@$Lobr07_exercicio?>
                </td>
                <td>
                    <?
                    db_input('obr07_exercicio',11,$Iobr07_exercicio,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tobr07_objeto?>">
                    <?=@$Lobr07_objeto?>
                </td>
                <td>
                    <?
                    db_textarea('obr07_objeto', 0, 0,'',true,'text',$db_opcao,"","","",'1000')
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tobr07_tipoprocesso?>">
                    <?=@$Lobr07_tipoprocesso?>
                </td>
                <td>
                    <?
                    $result = $clpctipocompratribunal->sql_record($clpctipocompratribunal->sql_query(null,"l44_sequencial,l44_descricao",null,"l44_uf = 'MG'"));
                    db_selectrecord('obr07_tipoprocesso',$result,true,2,"","","","0","");
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
    function js_pesquisa(){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_licobraslicitacao','func_licobraslicitacao.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
    }
    function js_preenchepesquisa(chave){
        db_iframe_licobraslicitacao.hide();
        <?
        if($db_opcao!=1){
            echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        }
        ?>
    }
</script>
