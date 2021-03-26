<?php
//MODULO: protocolo
$cltiposnotificacao->rotulo->label();
?>
<form name="form1" method="post" action="">
    <center>
        <fieldset style="width: 80%;">
            <legend><strong>Tipos de Notificações</strong></legend>
            <table border="0" style="width: 100%;">
                <tr>
                    <td nowrap title="<?=@$Tp110_sequencial?>">
                        <?=@$Lp110_sequencial?>
                    </td>
                    <td>
                        <?php db_input('p110_sequencial',19,$Ip110_sequencial,true,'text',3,""); ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Tp110_vinculonotificacao?>">
                        <?=@$Lp110_vinculonotificacao?>
                    </td>
                    <td>
                        <?php
                        $x = array('' => "Notificação", 1 => "Abertura de Processo", 2 => "Previsão de Pagamento", 3 => "Pagamento Realizado");
                        db_select('p110_vinculonotificacao', $x, true, $db_opcao, ' " style="width:26%;text-align:left;"' );
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Tp110_tipo?>">
                        <?=@$Lp110_tipo?>
                    </td>
                    <td>
                        <?php db_input('p110_tipo',78,$Ip110_tipo,true,'text',$db_opcao,""); ?>
                    </td>
                </tr>
            </table>
            <fieldset>
                <legend><strong>Texto Padrão</strong></legend>
                <table align="left">
                    <tr>
                        <td>
                            <?
                            db_textarea('p110_textoemail',10,85,$Ip110_textoemail,true,'text',$db_opcao,"")
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            </br>
            <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
            <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
        </fieldset>
    </center>
</form>
<script>
    function js_pesquisa(){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_tiposnotificacao','func_tiposnotificacao.php?funcao_js=parent.js_preenchepesquisa|p110_sequencial','Pesquisa',true);
    }
    function js_preenchepesquisa(chave){
        db_iframe_tiposnotificacao.hide();
        <?php
        if($db_opcao!=1){
            echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        }
        ?>
    }
</script>
