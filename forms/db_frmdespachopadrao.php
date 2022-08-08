<?
//MODULO: protocolo
$cldespachopadrao->rotulo->label();
?>
<form name="form1" method="post" action="">
    <center>
        <fieldset style="width: 80%;">
            <legend><strong>Despachos Padronizados</strong></legend>
            <table border="0" style="width: 100%;">
                <tr >
                    <td nowrap title="<?=@$Tp201_sequencial?>" style="width:2px;">
                        <?=@$Lp201_sequencial?>
                    </td>
                    <td>
                        <?
                        db_input('p201_sequencial',8,$Ip201_sequencial,true,'text',3,"")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Tp201_descricao?>">
                        <?=@$Lp201_descricao?>
                    </td>
                    <td>
                        <?
                        db_input('p201_descricao',78,0,$Ip201_descricao,true,'text',$db_opcao,"")
                        ?>
                    </td>
                </tr>
            </table>
            <fieldset>
                <legend><strong>Texto Padrão</strong></legend>
                <table align="left">
                <tr>
                    <td>
                        <?
                        db_textarea('p201_textopadrao',10,85,$Ip201_textopadrao,true,'text',$db_opcao,"")
                        ?>
                    </td>
                </tr>
                </table>
            </fieldset>
            </br>
            <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
            <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" style="<?=($db_opcao==1 ? "display:none" : "display:''")?>" >
        </fieldset>
    </center>
</form>
<script>
    function js_pesquisa(){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_despachopadrao','func_despachopadrao.php?funcao_js=parent.js_preenchepesquisa|p201_sequencial','Pesquisa',true);
    }
    function js_preenchepesquisa(chave){
        db_iframe_despachopadrao.hide();
        <?
        if($db_opcao!=1){
            echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        }
        ?>
    }
</script>
